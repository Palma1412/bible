<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('income_id'); // 34300523
            $table->string('number'); // ""
            $table->date('date'); // "2025-11-20"
            $table->date('last_change_date'); // "2025-11-21"
            $table->string('supplier_article'); // "972f91ed2040d71a"
            $table->string('tech_size'); // "66e7dff9f98764da"
            $table->bigInteger('barcode'); // 376357806
            $table->integer('quantity'); // 48
            $table->decimal('total_price', 10, 2); // "0"
            $table->date('date_close'); // "0001-01-01"
            $table->string('warehouse_name'); // "Электросталь"
            $table->bigInteger('nm_id'); // 353001876
            $table->timestamps();

            $table->index(['date', 'warehouse_name']);
            $table->index('nm_id');
            $table->index('barcode');
            $table->index('income_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income');
    }
};
