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
        Schema::create('stock_receipt_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_masters_id')->index()->nullable();
            $table->foreignId('stock_receipts_id')->index()->nullable();
            $table->string('item_name')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('item_code', 100)->nullable();
            $table->string('available_stock', 100)->nullable();
            $table->string('batch_number')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('tax')->nullable();
            $table->string('tax_amount')->nullable();
            $table->string('gross_amount')->nullable();
            $table->string('final_amount')->nullable();
            $table->string('lot_no')->nullable();
            $table->string('quantity', 10)->nullable();
            $table->string('rate')->nullable();
            $table->string('price')->nullable();
            $table->dateTime('mfg_date')->nullable();
            $table->dateTime('mfg_name')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->string('Status')->nullable();
            $table->longText('Message')->nullable();
            $table->string('LastSavedDocNo', 10)->nullable();
            $table->string('LastSavedCode', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_receipt_list_items');
    }
};
