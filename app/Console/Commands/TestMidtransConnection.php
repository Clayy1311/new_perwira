<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Midtrans\Snap;
use Midtrans\Config;

class TestMidtransConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:midtrans-connection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Midtrans API connection and SSL configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Midtrans Connection...');
        
        // Check SSL Certificate
        $this->checkSSLCertificate();
        
        // Check Configuration
        $this->checkConfiguration();
        
        // Test API Connection
        $this->testAPIConnection();
    }

    private function checkSSLCertificate()
    {
        $caCertPath = storage_path('certs/cacert.pem');
        
        if (file_exists($caCertPath)) {
            $this->info('✓ CA Certificate ditemukan: ' . $caCertPath);
            $this->info('  File size: ' . number_format(filesize($caCertPath)) . ' bytes');
            $this->info('  Last modified: ' . date('Y-m-d H:i:s', filemtime($caCertPath)));
        } else {
            $this->error('✗ CA Certificate tidak ditemukan: ' . $caCertPath);
            $this->warn('  Silakan download terlebih dahulu dengan perintah:');
            $this->warn('  curl -o storage/certs/cacert.pem https://curl.se/ca/cacert.pem');
            return false;
        }
        
        return true;
    }

    private function checkConfiguration()
    {
        $this->info("\nKonfigurasi Midtrans:");
        $this->info('  Server Key: ' . (Config::$serverKey ? 'Set' : 'Not Set'));
        $this->info('  Client Key: ' . (Config::$clientKey ? 'Set' : 'Not Set'));
        $this->info('  Is Production: ' . (Config::$isProduction ? 'Yes' : 'No'));
        $this->info('  Is Sanitized: ' . (Config::$isSanitized ? 'Yes' : 'No'));
        $this->info('  Is 3DS: ' . (Config::$is3ds ? 'Yes' : 'No'));
        
        if (isset(Config::$curlOptions[CURLOPT_CAINFO])) {
            $this->info('  SSL Verification: Enabled with CA Certificate');
        } else {
            $this->warn('  SSL Verification: Disabled (Development Mode)');
        }
    }

    private function testAPIConnection()
    {
        $this->info("\nTesting API Connection...");
        
        try {
            $params = [
                'transaction_details' => [
                    'order_id' => 'test-connection-' . time(),
                    'gross_amount' => 10000,
                ],
                'customer_details' => [
                    'first_name' => 'Test',
                    'last_name' => 'User',
                    'email' => 'test@example.com',
                    'phone' => '08123456789',
                ],
                'item_details' => [
                    [
                        'id' => 'item1',
                        'price' => 10000,
                        'quantity' => 1,
                        'name' => 'Test Item',
                    ]
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
            
            $this->info('✓ Koneksi ke Midtrans API berhasil!');
            $this->info('  Snap Token: ' . substr($snapToken, 0, 20) . '...');
            
        } catch (\Exception $e) {
            $this->error('✗ Koneksi ke Midtrans API gagal!');
            $this->error('  Error: ' . $e->getMessage());
            
            if (strpos($e->getMessage(), 'SSL certificate') !== false) {
                $this->warn('  Ini adalah masalah SSL certificate. Pastikan:');
                $this->warn('  1. File cacert.pem sudah didownload');
                $this->warn('  2. Path ke cacert.pem sudah benar');
                $this->warn('  3. Service provider sudah terdaftar');
            }
        }
    }
}