<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Midtrans\Config;

class DebugMidtrans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:midtrans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug Midtrans configuration step by step';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== MIDTRANS DEBUG REPORT ===');
        $this->line('');
        
        // 1. Check .env file
        $this->checkEnvFile();
        
        // 2. Check env() function
        $this->checkEnvFunction();
        
        // 3. Check config() function
        $this->checkConfigFunction();
        
        // 4. Check Midtrans Config class
        $this->checkMidtransConfig();
        
        // 5. Check SSL Certificate
        $this->checkSSLCert();
        
        // 6. Test API
        $this->testAPI();
    }

    private function checkEnvFile()
    {
        $this->info('1. CHECKING .ENV FILE:');
        
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            $this->error('   ✗ .env file tidak ditemukan!');
            return;
        }
        
        $envContent = file_get_contents($envPath);
        
        $keys = ['MIDTRANS_SERVER_KEY', 'MIDTRANS_CLIENT_KEY', 'MIDTRANS_IS_PRODUCTION'];
        
        foreach ($keys as $key) {
            if (strpos($envContent, $key) !== false) {
                preg_match('/' . $key . '=(.*)/', $envContent, $matches);
                $value = trim($matches[1] ?? '');
                $this->info("   ✓ {$key}=" . ($value ? substr($value, 0, 20) . '...' : 'EMPTY'));
            } else {
                $this->error("   ✗ {$key} tidak ditemukan di .env");
            }
        }
        $this->line('');
    }

    private function checkEnvFunction()
    {
        $this->info('2. CHECKING ENV() FUNCTION:');
        
        $keys = [
            'MIDTRANS_SERVER_KEY',
            'MIDTRANS_CLIENT_KEY', 
            'MIDTRANS_IS_PRODUCTION'
        ];
        
        foreach ($keys as $key) {
            $value = env($key);
            if ($value !== null) {
                $display = is_string($value) && strlen($value) > 20 ? substr($value, 0, 20) . '...' : $value;
                $this->info("   ✓ env('{$key}') = {$display}");
            } else {
                $this->error("   ✗ env('{$key}') = NULL");
            }
        }
        $this->line('');
    }

    private function checkConfigFunction()
    {
        $this->info('3. CHECKING CONFIG() FUNCTION:');
        
        $configs = [
            'midtrans.server_key',
            'midtrans.client_key',
            'midtrans.is_production'
        ];
        
        foreach ($configs as $config) {
            $value = config($config);
            if ($value !== null) {
                $display = is_string($value) && strlen($value) > 20 ? substr($value, 0, 20) . '...' : ($value === false ? 'false' : $value);
                $this->info("   ✓ config('{$config}') = {$display}");
            } else {
                $this->error("   ✗ config('{$config}') = NULL");
            }
        }
        $this->line('');
    }

    private function checkMidtransConfig()
    {
        $this->info('4. CHECKING MIDTRANS CONFIG CLASS:');
        
        $this->info('   Server Key: ' . (Config::$serverKey ?: 'NULL'));
        $this->info('   Client Key: ' . (Config::$clientKey ?: 'NULL'));
        $this->info('   Is Production: ' . (Config::$isProduction ? 'true' : 'false'));
        $this->info('   Is Sanitized: ' . (Config::$isSanitized ? 'true' : 'false'));
        $this->info('   Is 3DS: ' . (Config::$is3ds ? 'true' : 'false'));
        
        $this->line('');
        
        if (empty(Config::$serverKey)) {
            $this->error('   ❌ SERVER KEY KOSONG! Service Provider mungkin belum jalan.');
        }
        
        if (empty(Config::$clientKey)) {
            $this->error('   ❌ CLIENT KEY KOSONG! Service Provider mungkin belum jalan.');
        }
    }

    private function checkSSLCert()
    {
        $this->info('5. CHECKING SSL CERTIFICATE:');
        
        $certPath = storage_path('certs/cacert.pem');
        if (file_exists($certPath)) {
            $this->info('   ✓ CA Certificate: ' . $certPath);
            $this->info('   ✓ File size: ' . number_format(filesize($certPath)) . ' bytes');
        } else {
            $this->error('   ✗ CA Certificate tidak ditemukan: ' . $certPath);
        }
        $this->line('');
    }

    private function testAPI()
    {
        $this->info('6. TESTING API CONNECTION:');
        
        if (empty(Config::$serverKey)) {
            $this->error('   ❌ Tidak bisa test API - Server Key kosong');
            return;
        }
        
        try {
            // Manual CURL test
            $url = Config::$isProduction 
                ? 'https://api.midtrans.com/v2/charge'
                : 'https://api.sandbox.midtrans.com/v2/charge';
                
            $testData = [
                'payment_type' => 'credit_card',
                'transaction_details' => [
                    'order_id' => 'test-' . time(),
                    'gross_amount' => 10000
                ],
                'credit_card' => [
                    'token_id' => 'test-token'
                ]
            ];
            
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($testData),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Authorization: Basic ' . base64_encode(Config::$serverKey . ':'),
                ],
                CURLOPT_SSL_VERIFYPEER => false, // Untuk test saja
                CURLOPT_TIMEOUT => 30,
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);
            
            if ($error) {
                $this->error('   ✗ CURL Error: ' . $error);
            } else {
                $this->info('   ✓ HTTP Response Code: ' . $httpCode);
                if ($httpCode == 401) {
                    $this->error('   ❌ API Key tidak valid atau salah!');
                } elseif ($httpCode == 200 || $httpCode == 400) {
                    $this->info('   ✓ Koneksi ke API berhasil!');
                }
            }
            
        } catch (\Exception $e) {
            $this->error('   ✗ Exception: ' . $e->getMessage());
        }
    }
}