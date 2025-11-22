<?php
// app/Console/Commands/FetchWbDataCommand.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Income;

class FetchWbDataCommand extends Command
{
    protected $signature = 'wb:fetch
                            {--days=7 : Number of days to fetch}
                            {--all : Fetch all data}';
    protected $description = 'Fetch data from WB API and save to database';

    private $apiKey = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
    private $baseUrl = 'http://109.73.206.144:6969/api';

    public function handle()
    {
        $days = $this->option('days');

        $this->info("Fetching data for last {$days} days...");

        $this->fetchSales($days);
        $this->fetchOrders($days);
        $this->fetchStocks();
        $this->fetchIncomes($days);

        $this->info('Data fetched successfully!');
    }

    private function fetchSales($days)
    {
        $dateFrom = now()->subDays($days)->format('Y-m-d');
        $dateTo = now()->format('Y-m-d');

        $response = Http::get("{$this->baseUrl}/sales", [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'key' => $this->apiKey,
            'limit' => 500
        ]);

        if ($response->successful()) {
            $sales = $response->json()['data'] ?? [];
            $count = 0;

            foreach ($sales as $sale) {
                Sale::updateOrCreate(
                    ['sale_id' => $sale['sale_id']],
                    $sale
                );
                $count++;
            }

            $this->info("Fetched {$count} sales");
        } else {
            $this->error('Failed to fetch sales');
        }
    }

    private function fetchOrders($days)
    {
        $dateFrom = now()->subDays($days)->format('Y-m-d');
        $dateTo = now()->format('Y-m-d');

        $response = Http::get("{$this->baseUrl}/orders", [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'key' => $this->apiKey,
            'limit' => 500
        ]);

        if ($response->successful()) {
            $orders = $response->json()['data'] ?? [];
            $count = 0;

            foreach ($orders as $order) {
                Order::updateOrCreate(
                    ['g_number' => $order['g_number']],
                    $order
                );
                $count++;
            }

            $this->info("Fetched {$count} orders");
        } else {
            $this->error('Failed to fetch orders');
        }
    }

    private function fetchStocks()
    {
        $dateFrom = now()->format('Y-m-d');

        $response = Http::get("{$this->baseUrl}/stocks", [
            'dateFrom' => $dateFrom,
            'key' => $this->apiKey,
            'limit' => 500
        ]);

        if ($response->successful()) {
            $stocks = $response->json()['data'] ?? [];
            $count = 0;

            foreach ($stocks as $stock) {
                Stock::updateOrCreate(
                    ['nm_id' => $stock['nm_id'], 'warehouse_name' => $stock['warehouse_name']],
                    $stock
                );
                $count++;
            }

            $this->info("Fetched {$count} stocks");
        } else {
            $this->error('Failed to fetch stocks');
        }
    }

    private function fetchIncomes($days)
    {
        $dateFrom = now()->subDays($days)->format('Y-m-d');
        $dateTo = now()->format('Y-m-d');

        $response = Http::get("{$this->baseUrl}/incomes", [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'key' => $this->apiKey,
            'limit' => 500
        ]);

        if ($response->successful()) {
            $incomes = $response->json()['data'] ?? [];
            $count = 0;

            foreach ($incomes as $income) {
                Income::updateOrCreate(
                    ['income_id' => $income['income_id']],
                    $income
                );
                $count++;
            }

            $this->info("Fetched {$count} incomes");
        } else {
            $this->error('Failed to fetch incomes');
        }
    }
}
