<?php
// app/Services/DataStorageService.php

namespace App\Services;

use App\Models\Sale;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Income;
use Illuminate\Support\Facades\Log;

class DataStorageService
{
    public function saveSales($salesData)
    {
        foreach ($salesData as $sale) {
            try {
                Sale::updateOrCreate(
                    ['sale_id' => $sale['sale_id']],
                    $this->mapSaleData($sale)
                );
            } catch (\Exception $e) {
                Log::error("Error saving sale: {$e->getMessage()}", ['sale' => $sale]);
            }
        }
    }

    public function saveOrders($ordersData)
    {
        foreach ($ordersData as $order) {
            try {
                Order::updateOrCreate(
                    ['g_number' => $order['g_number']],
                    $this->mapOrderData($order)
                );
            } catch (\Exception $e) {
                Log::error("Error saving order: {$e->getMessage()}", ['order' => $order]);
            }
        }
    }

    public function saveStocks($stocksData)
    {
        foreach ($stocksData as $stocks) {
            try {
                Stock::updateOrCreate(
                    ['nm_id' => $stocks['nm_id'], 'warehouse_name' => $stocks['warehouse_name']],
                    $this->mapStockData($stocks)
                );
            } catch (\Exception $e) {
                Log::error("Error saving stock: {$e->getMessage()}", ['stock' => $stocks]);
            }
        }
    }

    public function saveIncomes($incomesData)
    {
        foreach ($incomesData as $income) {
            try {
                Income::updateOrCreate(
                    ['income_id' => $income['income_id']],
                    $this->mapIncomeData($income)
                );
            } catch (\Exception $e) {
                Log::error("Error saving income: {$e->getMessage()}", ['income' => $income]);
            }
        }
    }

    // Маппинг данных...
    private function mapSaleData($sale) { /* ... */ }
    private function mapOrderData($order) { /* ... */ }
    private function mapStockData($warehouse) { /* ... */ }
    private function mapIncomeData($income) { /* ... */ }
}
