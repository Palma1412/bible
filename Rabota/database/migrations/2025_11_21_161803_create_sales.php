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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('g_number'); // "340778569923063949"
            $table->date('date'); // "2025-11-19"
            $table->date('last_change_date'); // "2025-11-19"
            $table->string('supplier_article'); // "75a1ec0245bc6dfe"
            $table->string('tech_size'); // "66e7dff9f98764da"
            $table->bigInteger('barcode'); // 34345736
            $table->decimal('total_price', 10, 2); // "4332.25"
            $table->integer('discount_percent'); // "5"
            $table->boolean('is_supply'); // false
            $table->boolean('is_realization'); // true
            $table->decimal('promo_code_discount', 10, 2)->nullable();
            $table->string('warehouse_name'); // "Электросталь"
            $table->string('country_name'); // "Россия"
            $table->string('oblast_okrug_name'); // "Южный федеральный округ"
            $table->string('region_name'); // "Краснодарский край"
            $table->bigInteger('income_id'); // 33776502
            $table->string('sale_id'); // "S19978066096"
            $table->bigInteger('odid')->nullable();
            $table->decimal('spp', 10, 2); // "28"
            $table->decimal('for_pay', 10, 2); // "1502.49"
            $table->decimal('finished_price', 10, 2); // "1383"
            $table->decimal('price_with_disc', 10, 2); // "1914"
            $table->bigInteger('nm_id'); // 631881485
            $table->string('subject'); // "716cae14263ef4b7"
            $table->string('category'); // "9f463620982b6cc9"
            $table->string('brand'); // "a66c77274e96b48c"
            $table->boolean('is_storno')->nullable();
            $table->timestamps();

            $table->index(['date', 'warehouse_name']);
            $table->index('nm_id');
            $table->index('barcode');
            $table->index('sale_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
