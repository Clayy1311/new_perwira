<?php

namespace App\Http\Controllers;

use App\Models\UserModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use Illuminate\Support\Str;


use Exception;

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman pemilihan modul pembayaran.
     * User tidak boleh mengakses ini jika sudah punya modul aktif.
     */
    // Method untuk menampilkan form pembayaran Lifetime
    public function showLifetimePaymentForm()
    {
        if (Auth::user()->hasActiveModule()) {
            return redirect()->route('dashboard')->with('info', 'Anda sudah memiliki modul aktif.');
        }

        // Meneruskan tipe modul ke view agar form tahu apa yang harus di-submit
        return view('payment.lifetime', ['moduleType' => 'lifetime']);
    }

    // Method untuk menampilkan form pembayaran 1 Tahun (Yearly)
    public function showYearlyPaymentForm()
    {
        if (Auth::user()->hasActiveModule()) {
            return redirect()->route('dashboard')->with('info', 'Anda sudah memiliki modul aktif.');
        }

        // Meneruskan tipe modul ke view agar form tahu apa yang harus di-submit
        return view('payment.yearly', ['moduleType' => 'yearly']);
    }

    /**
     * Memproses permintaan pembayaran dan menyimpan modul ke database.
     * Module akan diset sebagai 'pending' untuk persetujuan admin.
     */
    public function process(Request $request)
    {
        // Pastikan user belum punya modul aktif sebelum memproses pembayaran baru
        // Sama seperti di atas, ini validasi ganda dari middleware.
        if (auth()->user()->hasActiveModule()) {
            return redirect()->route('dashboard')->with('info', 'Anda sudah memiliki modul aktif.');
        }

        // Validasi input dari form pembayaran
        $request->validate([
            // Pastikan 'yearly' juga ada di sini sesuai pilihan modul Anda
            'module_type' => 'required|in:lifetime,yearly', // <--- Pastikan 'yearly' ada di sini
            'payment_method' => 'required|string|max:50', // Batasi panjang string
        ]);

        // --- Logika untuk menghitung expiry_date berdasarkan module_type ---
        $expiryDate = null; // Default untuk modul 'lifetime'

        if ($request->module_type === 'yearly') { // <--- Cek jika tipe modul adalah 'yearly'
            $expiryDate = Carbon::now()->addYears(1); // <--- Atur kedaluwarsa 1 tahun dari sekarang
        }
        // Jika $request->module_type adalah 'lifetime', $expiryDate akan tetap null, sesuai keinginan.

        // --- Simpan data UserModule ke database ---
        UserModule::create([
            'user_id' => Auth::id(), // Gunakan Auth::id() lebih eksplisit
            'module_type' => $request->module_type,
            'expiry_date' => $expiryDate, // Gunakan variabel $expiryDate yang sudah dihitung
            'payment_method' => $request->payment_method,
            // Sesuaikan jumlah (amount) berdasarkan module_type
            'amount' => $request->module_type === 'lifetime' ? 500000 : 100000, // <--- Sesuaikan harga untuk 'yearly' jika berbeda dari 'monthly'
            'status' => 'inactive', // Status awal: inactive, karena masih menunggu persetujuan
            'status_approved' => 'pending', // Status persetujuan: pending
            'admin_notes' => null, // Catatan admin kosong di awal
        ]);

        // Redirect ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Modul Anda telah berhasil dipilih dan sedang menunggu persetujuan admin.');
    }


    //transaction midtransd

// 1. PERBAIKI CREATE TRANSACTION - TAMBAHKAN CALLBACK URL
public function createTransaction(Request $request) 
{
    Config::$serverKey = config('midtrans.server_key');
    Config::$clientKey = config('midtrans.client_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = config('midtrans.sanitize');
    Config::$is3ds = config('midtrans.is_3ds');

    $user = auth()->user();
    $plan = $request->plan;

    $price = $plan === 'wolfpack' ? 1000000 : 3000000;
    $orderId = 'ORDER-' . time() . '-' . strtoupper(Str::random(5));

    $params = [
        'transaction_details' => [
            'order_id' => $orderId,
            'gross_amount' => $price,
        ],
        'customer_details' => [
            'first_name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone
        ],
        // TAMBAHKAN CALLBACK URLs
        'callbacks' => [
            'finish' => url('/payment/finish'),
            'unfinish' => url('/payment/unfinish'),
            'error' => url('/payment/error')
        ]
    ];

    try {
        // Set notification URL untuk callback
        \Midtrans\Config::$overrideNotifUrl = url('/midtrans/callback');
        
        Log::info('🚀 Creating transaction:', [
            'order_id' => $orderId,
            'amount' => $price,
            'callback_url' => url('/midtrans/callback')
        ]);

        $snap = \Midtrans\Snap::createTransaction($params);

        // Simpan ke database
        Order::create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'plan' => $plan,
            'amount' => $price,
            'status' => 'pending',
            'token' => $snap->token,
            'redirect_url' => $snap->redirect_url,
        ]);

        Log::info('✅ Transaction created successfully:', [
            'order_id' => $orderId,
            'token' => $snap->token
        ]);

        return response()->json([
            'token' => $snap->token,
            'redirect_url' => $snap->redirect_url,
            'order_id' => $orderId
        ]);

    } catch (\Exception $e) {
        Log::error('❌ Midtrans Error: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
            'params' => $params
        ]);

        return response()->json([
            'error' => 'Terjadi kesalahan saat membuat transaksi.',
            'message' => $e->getMessage(),
        ], 500);
    }
}

// 2. CALLBACK DENGAN LOGGING LEBIH DETAIL
public function handleCallback(Request $request)
{
    // Set konfigurasi Midtrans
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    
    Log::info('📥 === MIDTRANS CALLBACK START ===');
    Log::info('📥 RAW Request Data:', $request->all());
    Log::info('📥 Request Headers:', $request->headers->all());
    Log::info('📥 Request Method:', $request->method());
    Log::info('📥 Request URL:', $request->fullUrl());
    
    try {
        $notif = new \Midtrans\Notification();
        
        Log::info('📦 Notification Object:', [
            'order_id' => $notif->order_id,
            'transaction_status' => $notif->transaction_status,
            'payment_type' => $notif->payment_type ?? 'unknown',
            'fraud_status' => $notif->fraud_status ?? 'none',
            'gross_amount' => $notif->gross_amount ?? 0
        ]);
        
        $status = $notif->transaction_status;
        $orderId = $notif->order_id;
        $fraudStatus = $notif->fraud_status ?? null;
        
        $order = Order::where('order_id', $orderId)->first();
        
        if (!$order) {
            Log::error('❌ Order not found in database:', [
                'order_id' => $orderId,
                'available_orders' => Order::pluck('order_id')->toArray()
            ]);
            return response()->json(['error' => 'Order not found'], 404);
        }
        
        Log::info('🔍 Order found:', [
            'order_id' => $order->order_id,
            'current_status' => $order->status,
            'user_id' => $order->user_id,
            'amount' => $order->amount
        ]);
        
        $oldStatus = $order->status;
        
        // Handle status
        switch ($status) {
            case 'capture':
                if ($fraudStatus == 'challenge') {
                    $order->update(['status' => 'challenge']);
                    Log::info('⚠️ Transaction challenged');
                } else if ($fraudStatus == 'accept') {
                    $order->update(['status' => 'paid']);
                    $this->activateUserModule($order);
                    Log::info('✅ Transaction captured and accepted');
                }
                break;
                
            case 'settlement':
                $order->update(['status' => 'paid']);
                $this->activateUserModule($order, 'approved');

                Log::info('✅ Transaction settled - Status updated to PAID');
                break;
                
            case 'pending':
                $order->update(['status' => 'pending']);
                Log::info('⏳ Transaction pending');
                break;
                
            case 'deny':
                $order->update(['status' => 'failed']);
                Log::info('❌ Transaction denied');
                break;
                
            case 'expire':
                $order->update(['status' => 'expired']);
                Log::info('⏰ Transaction expired');
                break;
                
            case 'cancel':
                $order->update(['status' => 'cancelled']);
                Log::info('🚫 Transaction cancelled');
                break;
                
            default:
                Log::warning('⚠️ Unknown status received:', ['status' => $status]);
        }
        
        Log::info('📊 Status Update Summary:', [
            'order_id' => $orderId,
            'old_status' => $oldStatus,
            'new_status' => $order->fresh()->status,
            'midtrans_status' => $status
        ]);
        
        Log::info('📥 === MIDTRANS CALLBACK END ===');
        
        return response()->json(['message' => 'OK'], 200);
        
    } catch (\Exception $e) {
        Log::error('❌ CALLBACK EXCEPTION:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->all()
        ]);
        
        return response()->json(['error' => 'Internal error'], 500);
    }
}

// 3. METHOD UNTUK CEK STATUS MANUAL
public function checkStatus($orderId)
{
    try {
        // Set konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        
        Log::info('🔍 Checking status for order:', ['order_id' => $orderId]);
        Log::info('🔧 Midtrans config:', [
            'server_key' => substr(config('midtrans.server_key'), 0, 10) . '...',
            'is_production' => config('midtrans.is_production')
        ]);
        
        // Cek order di database dulu
        $order = Order::where('order_id', $orderId)->first();
        
        if (!$order) {
            return response()->json(['error' => 'Order not found in database'], 404);
        }
        
        // Cek status ke Midtrans dengan error handling yang lebih baik
        try {
            $status = \Midtrans\Transaction::status($orderId);
            
            Log::info('📊 Midtrans API Response:', [
                'order_id' => $orderId,
                'response_type' => gettype($status),
                'response_content' => json_encode($status, JSON_PRETTY_PRINT)
            ]);
            
            // Convert object to array jika perlu
            $statusArray = json_decode(json_encode($status), true);
            
            return response()->json([
                'success' => true,
                'order_id' => $orderId,
                'database_status' => $order->status,
                'database_created' => $order->created_at,
                'midtrans_status' => $statusArray['transaction_status'] ?? 'unknown',
                'payment_type' => $statusArray['payment_type'] ?? 'unknown',
                'fraud_status' => $statusArray['fraud_status'] ?? 'none',
                'status_code' => $statusArray['status_code'] ?? 'unknown',
                'status_message' => $statusArray['status_message'] ?? 'unknown',
                'gross_amount' => $statusArray['gross_amount'] ?? 0,
                'full_midtrans_response' => $statusArray
            ]);
            
        } catch (\Midtrans\Exception\ApiException $e) {
            Log::error('❌ Midtrans API Exception:', [
                'order_id' => $orderId,
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                'http_status' => $e->getHttpStatusCode() ?? 'unknown'
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Midtrans API Error',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                'database_status' => $order->status,
                'suggestion' => $e->getCode() == 404 ? 'Order not found in Midtrans. Mungkin order belum dibuat atau sudah expired.' : 'Check Midtrans configuration'
            ], 400);
            
        } catch (\Exception $e) {
            Log::error('❌ General Exception in Midtrans status check:', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Unexpected error',
                'message' => $e->getMessage(),
                'database_status' => $order->status
            ], 500);
        }
        
    } catch (\Exception $e) {
        Log::error('❌ Status check failed completely:', [
            'order_id' => $orderId,
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);
        
        return response()->json([
            'success' => false,
            'error' => 'Status check failed',
            'message' => $e->getMessage()
        ], 500);
    }
}

// 4. METHOD UNTUK SIMULASI CALLBACK
public function simulateCallback(Request $request)
{
    $orderId = $request->input('order_id');
    $status = $request->input('status', 'settlement'); // default settlement
    
    if (!$orderId) {
        return response()->json(['error' => 'order_id required'], 400);
    }
    
    // Simulasi data callback Midtrans
    $callbackData = [
        'transaction_time' => now()->toISOString(),
        'transaction_status' => $status,
        'transaction_id' => 'test-' . time(),
        'status_message' => 'midtrans payment notification',
        'status_code' => '200',
        'signature_key' => 'dummy-signature',
        'payment_type' => 'bank_transfer',
        'order_id' => $orderId,
        'merchant_id' => config('midtrans.merchant_id'),
        'gross_amount' => '1000000.00',
        'fraud_status' => 'accept',
        'currency' => 'IDR'
    ];
    
    Log::info('🧪 Simulating callback:', $callbackData);
    
    // Panggil callback dengan data simulasi
    $callbackRequest = new Request($callbackData);
    return $this->handleCallback($callbackRequest);
}

private function activateUserModule($order, $statusApproved = 'pending',)
{
    try {
        $expiry = $order->plan === 'wolfpack' ? now()->addDays(365) : null;
        
        $userModule = UserModule::create
           ([
                'module_type' =>  $order->plan,
                'payment_method' => 'midtrans',
                'amount' => $order->amount,
                'status' => 'active',
                 'status_approved' => $statusApproved,
                'expiry_date' => $expiry,
                'user_id' => $order->user_id
           ]);
        
        
        Log::info('🧩 UserModule activated:', [
            'user_id' => $order->user_id,
            
            'expiry' => $expiry
            
        ]);

        
    } catch (\Exception $e) { dd($e);
        Log::error('❌ Failed to activate module:', [
            'order_id' => $order->order_id,
            'error' => $e->getMessage()
            
        ]);
    }
}

// METHOD UNTUK DEBUGGING STEP BY STEP
public function debugTransaction($orderId)
{
    $order = Order::where('order_id', $orderId)->first();
    
    if (!$order) {
        return response()->json(['error' => 'Order not found in database'], 404);
    }
    
    $debug = [
        'step_1_database' => [
            'order_found' => true,
            'order_id' => $order->order_id,
            'status' => $order->status,
            'amount' => $order->amount,
            'user_id' => $order->user_id,
            'created_at' => $order->created_at,
            'token' => $order->token ?? 'No token saved'
        ]
    ];
    
    // Step 2: Check Midtrans config
    $debug['step_2_config'] = [
        'server_key_set' => !empty(config('midtrans.server_key')),
        'server_key_length' => strlen(config('midtrans.server_key')),
        'is_production' => config('midtrans.is_production'),
        'environment' => config('midtrans.is_production') ? 'production' : 'sandbox'
    ];
    
    // Step 3: Test Midtrans connectivity
    try {
        $serverKey = config('midtrans.server_key');
        $isProduction = config('midtrans.is_production');
        $baseUrl = $isProduction ? 'https://api.midtrans.com' : 'https://api.sandbox.midtrans.com';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $baseUrl . '/v2/' . $orderId . '/status');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($serverKey . ':')
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        $debug['step_3_midtrans_api'] = [
            'url' => $baseUrl . '/v2/' . $orderId . '/status',
            'http_code' => $httpCode,
            'curl_error' => $curlError ?: 'No error',
            'response_length' => strlen($response),
            'response_preview' => substr($response, 0, 200),
            'response_parsed' => json_decode($response, true)
        ];
        
        if ($httpCode == 404) {
            $debug['step_3_midtrans_api']['diagnosis'] = 'Order tidak ditemukan di Midtrans. Kemungkinan: 1) Order belum dibuat, 2) Order expired, 3) Environment mismatch';
        } elseif ($httpCode == 401) {
            $debug['step_3_midtrans_api']['diagnosis'] = 'Authentication failed. Server key salah atau environment mismatch';
        } elseif ($httpCode == 200) {
            $debug['step_3_midtrans_api']['diagnosis'] = 'API sukses, cek transaction_status';
        }
        
    } catch (\Exception $e) {
        $debug['step_3_midtrans_api'] = [
            'error' => $e->getMessage(),
            'diagnosis' => 'Connection ke Midtrans API gagal'
        ];
    }
    
    // Step 4: Check if transaction was actually created
    $debug['step_4_analysis'] = [
        'order_age_minutes' => now()->diffInMinutes($order->created_at),
        'has_token' => !empty($order->token),
        'recommendations' => []
    ];
    
    if (empty($order->token)) {
        $debug['step_4_analysis']['recommendations'][] = 'Token kosong - transaksi mungkin gagal dibuat di Midtrans';
    }
    
    if ($debug['step_3_midtrans_api']['http_code'] == 404) {
        $debug['step_4_analysis']['recommendations'][] = 'Transaksi tidak ditemukan di Midtrans - coba buat ulang transaksi';
    }
    
    if (now()->diffInMinutes($order->created_at) > 30 && $order->status == 'pending') {
        $debug['step_4_analysis']['recommendations'][] = 'Transaksi sudah lama pending - mungkin perlu dibuat ulang';
    }
    
    return response()->json($debug, 200);
}

public function syncStatus($orderId)
{
    try {
        $order = Order::where('order_id', $orderId)->first();
        
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        
        // Get status dari Midtrans
        $serverKey = config('midtrans.server_key');
        $isProduction = config('midtrans.is_production');
        $baseUrl = $isProduction ? 'https://api.midtrans.com' : 'https://api.sandbox.midtrans.com';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $baseUrl . '/v2/' . $orderId . '/status');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Authorization: Basic ' . base64_encode($serverKey . ':')
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            return response()->json(['error' => 'Failed to get status from Midtrans'], 400);
        }
        
        $statusData = json_decode($response, true);
        if($statusData['status_code'] != '200')
        return response()->json($statusData);
        Log::info('🔄 Manual sync status:', [
            'order_id' => $orderId,
            'old_status' => $order->status,
            'midtrans_status' => $statusData['transaction_status'],
            'fraud_status' => $statusData['fraud_status'] ?? 'none'
        ]);
        
        // Update status berdasarkan Midtrans
        $midtransStatus = $statusData['transaction_status'];
        $fraudStatus = $statusData['fraud_status'] ?? 'accept';
        
        $oldStatus = $order->status;
        
        switch ($midtransStatus) {
            case 'settlement':
                $order->update(['status' => 'paid']);
                $this->activateUserModule($order, 'approved');
                Log::info('✅ Manual sync: Updated to PAID (a)');
                break;
                
            case 'capture':
                if ($fraudStatus == 'accept') {
                    $order->update(['status' => 'paid']);
                    $this->activateUserModule($order);
                    Log::info('✅ Manual sync: Updated to PAID (capture-accept)');
                } else {
                    $order->update(['status' => 'challenge']);
                    Log::info('⚠️ Manual sync: Updated to CHALLENGE');
                }
                break;
                
            case 'pending':
                $order->update(['status' => 'pending']);
                Log::info('⏳ Manual sync: Kept as PENDING');
                break;
                
            case 'deny':
                $order->update(['status' => 'failed']);
                Log::info('❌ Manual sync: Updated to FAILED');
                break;
                
            case 'expire':
                $order->update(['status' => 'expired']);
                Log::info('⏰ Manual sync: Updated to EXPIRED');
                break;
                
            case 'cancel':
                $order->update(['status' => 'cancelled']);
                Log::info('🚫 Manual sync: Updated to CANCELLED');
                break;
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Status synced successfully',
            'order_id' => $orderId,
            'old_status' => $oldStatus,
            'new_status' => $order->fresh()->status,
            'midtrans_status' => $midtransStatus,
            'fraud_status' => $fraudStatus,
            'settlement_time' => $statusData['settlement_time'] ?? null,
            'user_module_activated' => in_array($midtransStatus, ['settlement']) || ($midtransStatus == 'capture' && $fraudStatus == 'accept')
        ]);
        
    } catch (\Exception $e) {
        Log::error('❌ Manual sync failed:', [
            'order_id' => $orderId,
            'error' => $e->getMessage()
        ]);
        
        return response()->json([
            'error' => 'Sync failed',
            'message' => $e->getMessage()
        ], 500);
    }
}
public function syncAllPendingOrders()
{
    $pendingOrders = Order::where('status', 'pending')
                          ->where('created_at', '>', now()->subDays(1)) // Hanya yang kurang dari 1 hari
                          ->get();
    
    $results = [];
    
    foreach ($pendingOrders as $order) {
        try {
            $result = $this->syncStatus($order->order_id);
            $results[] = [
                'order_id' => $order->order_id,
                'success' => true,
                'result' => json_decode($result->getContent(), true)
            ];
        } catch (\Exception $e) {
            $results[] = [
                'order_id' => $order->order_id,
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    return response()->json([
        'message' => 'Bulk sync completed',
        'processed' => count($results),
        'results' => $results
    ]);
}


}