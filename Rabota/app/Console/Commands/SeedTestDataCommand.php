<?php
// app/Console/Commands/SeedTestDataCommand.php

namespace App\Console\Commands;

use App\Models\Stock;
use Illuminate\Console\Command;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Income;

class SeedTestDataCommand extends Command
{
    protected $signature = 'wb:seed-test-data';
    protected $description = 'Create test data for demonstration';

    public function handle()
    {
        $this->createTestSales();
        $this->createTestOrders();
        $this->createTestStocks();
        $this->createTestIncomes();

        $this->info('Test data created successfully!');
    }

    private function createTestSales()
    {
        Sale::create([
            'g_number' => '340778569923063949',
            'date' => '2025-11-19',
            'last_change_date' => '2025-11-19',
            'supplier_article' => '75a1ec0245bc6dfe',
            'tech_size' => '66e7dff9f98764da',
            'barcode' => 34345736,
            'total_price' => 4332.25,
            'discount_percent' => 5,
            'is_supply' => false,
            'is_realization' => true,
            'warehouse_name' => 'Электросталь',
            'country_name' => 'Россия',
            'income_id' => 33776502,
            'sale_id' => 'S19978066096',
            'nm_id' => 631881485,
            'subject' => '716cae14263ef4b7',
            'category' => '9f463620982b6cc9',
            'brand' => 'a66c77274e96b48c',
        ]);

        $this->info('Created test sales');
    }

    private function createTestOrders()
    {
        Order::create([
            'g_number' => '8760351661738655347',
            'date' => '2025-11-19 00:03:42',
            'last_change_date' => '2025-11-19',
            'supplier_article' => '47950aca18716c3a',
            'tech_size' => '66e7dff9f98764da',
            'barcode' => 133733494,
            'total_price' => 5908.20,
            'discount_percent' => 38,
            'warehouse_name' => 'Рязань (Тюшевское)',
            'oblast' => 'Смоленская область',
            'income_id' => 30796370,
            'odid' => '0',
            'nm_id' => 337904859,
            'subject' => 'bac0461335ae5efa',
            'category' => '9f463620982b6cc9',
            'brand' => '5b61c34e26e75022',
            'is_cancel' => false,
        ]);

        $this->info('Created test orders');
    }

    private function createTestStocks()
    {
        Stock::create([
            'date' => '2025-11-21',
            'barcode' => 391877287,
            'quantity' => 2,
            'warehouse_name' => 'Чашниково',
            'nm_id' => 86583024,
        ]);

        $this->info('Created test stocks');
    }

    private function createTestIncomes()
    {
        Income::create([
            'income_id' => 34300523,
            'date' => '2025-11-20',
            'last_change_date' => '2025-11-21',
            'supplier_article' => '972f91ed2040d71a',
            'tech_size' => '66e7dff9f98764da',
            'barcode' => 376357806,
            'quantity' => 48,
            'total_price' => 0,
            'date_close' => '0001-01-01',
            'warehouse_name' => 'Электросталь',
            'nm_id' => 353001876,
        ]);

        $this->info('Created test incomes');
    }
}
