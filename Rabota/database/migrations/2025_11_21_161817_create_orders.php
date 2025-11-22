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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('g_number'); // "8760351661738655347"
            $table->dateTime('date'); // "2025-11-19 00:03:42"
            $table->date('last_change_date'); // "2025-11-19"
            $table->string('supplier_article'); // "47950aca18716c3a"
            $table->string('tech_size'); // "66e7dff9f98764da"
            $table->bigInteger('barcode'); // 133733494
            $table->decimal('total_price', 10, 2); // "5908.2"
            $table->integer('discount_percent'); // 38
            $table->string('warehouse_name'); // "Рязань (Тюшевское)"
            $table->string('oblast'); // "Смоленская область"
            $table->bigInteger('income_id'); // 30796370
            $table->string('odid'); // "0"
            $table->bigInteger('nm_id'); // 337904859
            $table->string('subject'); // "bac0461335ae5efa"
            $table->string('category'); // "9f463620982b6cc9"
            $table->string('brand'); // "5b61c34e26e75022"
            $table->boolean('is_cancel'); // false
            $table->dateTime('cancel_dt')->nullable();
            $table->timestamps();

            $table->index(['date', 'warehouse_name']);
            $table->index('nm_id');
            $table->index('barcode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
