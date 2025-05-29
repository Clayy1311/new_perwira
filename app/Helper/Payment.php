<?php

if (!function_exists('createTransaksiMidtrans')) {
    function createTransaksiMidtrans($transactionDetail, $customerDetail)
    {
        $url = "https://app.sandbox.midtrans.com/snap/v1/transactions";

        $payload = [
            'transaction_details' => $transactionDetail,
            'customer_details' => $customerDetail,
        ];

 $serverKey = config('midtrans.server_key'); // atau env('MIDTRANS_SERVER_KEY')

        $password = '';
        $auth = base64_encode("$serverKey:$password");

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . $auth,
            'Content-Type: application/json',
            'Accept: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return [
                'success' => false,
                'message' => 'Curl error: ' . $error,
                'http_code' => $httpCode,
                'token' => null,
                'redirect_url' => null,
            ];
        }

        $responseData = json_decode($response, true);
        if ($httpCode >= 200 && $httpCode < 300 && isset($responseData['token'], $responseData['redirect_url'])) {
            \Log::info('Midtrans response', ['body' => $responseData]);

            return [
                'success' => true,
                'token' => $responseData['token'],
                'redirect_url' => $responseData['redirect_url'],
            ];
        } else {
            return [
                'success' => false,
                'message' => $responseData['message'] ?? 'Gagal membuat transaksi',
                'http_code' => $httpCode,
                'token' => null,
                'redirect_url' => null,
            ];
        }
    }
}