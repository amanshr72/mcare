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
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_receipt_list_id')->index()->nullable();
            $table->string('item_name')->nullable();
            $table->string('item_code', 100)->nullable();
            $table->string('batch_number')->nullable();
            $table->string('quantity', 10)->nullable();
            $table->string('quantity_2', 10)->nullable();
            $table->dateTime('manufacturing_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_outs');
    }
};
