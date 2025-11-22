<?php
// app/Services/WbApiService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WbApiService
{
    private $baseUrl = 'http://109.73.206.144:6969/api';
    private $apiKey = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';

    public function getSales($dateFrom, $dateTo) {
        return Http::get('http://109.73.206.144:6969/api/sales', [
            'key' => 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie',
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ]);
    }

    public function fetchData($endpoint, $params = [])
    {
        try {
            $response = Http::timeout(30)->get("{$this->baseUrl}/{$endpoint}", array_merge([
                'key' => $this->apiKey,
                'limit' => 500,
                'page' => 1
            ], $params));

            if ($response->successful()) {
                return $response->json();
            }

            Log::error("API Error: {$response->status()}", ['response' => $response->body()]);
            return null;
        } catch (\Exception $e) {
            Log::error("API Exception: {$e->getMessage()}");
            return null;
        }
    }

    public function fetchAllPages($endpoint, $params = [])
    {
        $page = 1;
        $allData = [];

        do {
            $params['page'] = $page;
            $response = $this->fetchData($endpoint, $params);

            if (!$response || empty($response['data'])) {
                break;
            }

            $allData = array_merge($allData, $response['data']);
            $page++;

            // Пауза чтобы не нагружать API
            sleep(1);

        } while (isset($response['links']['next'])); // или пока есть следующая страница

        return $allData;
    }
}
