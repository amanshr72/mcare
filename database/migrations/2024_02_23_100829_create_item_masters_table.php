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
        Schema::create('item_masters', function (Blueprint $table) {
            $table->id();
            $table->string('item_name')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_description')->nullable();
            $table->string('category')->nullable();
            $table->string('brand_name')->nullable();
            $table->string('mfg_date')->nullable();
            $table->string('mfg_name')->nullable();
            $table->integer('gst')->nullable();
            $table->decimal('price')->nullable();
            $table->string('fi_raw')->nullable();
            $table->string('ean_no')->nullable();
            $table->string('pack_size')->nullable();
            $table->decimal('unit_id', 8)->nullable();
            $table->string('unit_type')->nullable();
            $table->decimal('cogs', 8)->nullable();
            $table->string('rm_type')->nullable();
            $table->string('imported')->nullable()->comment('Imported/Domestic');
            $table->string('country')->nullable();
            $table->string('type_of_item')->nullable();
            $table->string('hsn_code')->nullable();
            $table->string('self_life_days')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_masters');
    }
};
