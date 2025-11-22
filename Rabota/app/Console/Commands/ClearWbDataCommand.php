<?php
// app/Console/Commands/ClearWbDataCommand.php

namespace App\Console\Commands;

use App\Models\Stock;
use Illuminate\Console\Command;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Income;

class ClearWbDataCommand extends Command
{
    protected $signature = 'wb:clear';
    protected $description = 'Clear all WB data from database';

    public function handle()
    {
        if ($this->confirm('Are you sure you want to clear all WB data?')) {
            Sale::truncate();
            Order::truncate();
            Stock::truncate();
            Income::truncate();

            $this->info('All WB data cleared!');
        }
    }
}
