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
        Schema::create('stock_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_masters_id')->index()->nullable();

            $table->integer('groupid')->nullable();
            $table->string('po_prefix', 100)->nullable();
            $table->integer('po_number')->nullable();
            
            $table->string('branch_code', 50)->nullable();
            $table->string('doc_prefix', 100)->nullable();
            $table->string('issued_to')->nullable();
            $table->string('godown_name')->nullable();
            $table->string('received_from')->nullable();
            $table->longText('list_items')->nullable();

            $table->string('product_name', 255);
            $table->string('category', 255)->nullable();
            $table->string('vendor_company', 255);
            $table->string('Item_Code', 255);
            $table->string('user_code', 255)->nullable();
            $table->string('Qty', 225)->nullable();
            $table->string('user_qty', 255);
            $table->float('Price', 10, 2)->nullable();
            $table->float('User_Price', 10, 2)->nullable();
            $table->string('Discount', 100)->nullable();
            $table->string('Tax', 100)->nullable();
            $table->float('SubTotal', 10, 2)->nullable();
            $table->float('Ftotal', 10, 2)->nullable();
            $table->string('UOM', 100)->nullable();
            $table->string('U_Desc', 100)->nullable();
            $table->string('notes', 300)->nullable();
            $table->dateTime('created_on');
            $table->integer('created_by');
            $table->integer('po_type')->comment('0=fixed,1=float');
            $table->integer('status')->default(0)->comment('0=pending, 1=approved, 2=rejected, 3=released, 4=cancelled, 5=checked');
            $table->string('cancelledBy', 255)->nullable();
            $table->dateTime('cancelledOn')->nullable();
            $table->string('Location', 100);
            $table->string('Address_as', 100);
            $table->string('Delivery_Address', 100)->nullable();
            $table->string('comment', 500)->nullable();
            $table->string('refernece_document_no', 255)->nullable();
            $table->date('reference_date')->nullable();
            $table->string('user_prefix', 255)->nullable();
            $table->string('batch_number', 100)->nullable();
            $table->date('manu_date')->nullable();
            $table->string('manu_name', 100)->nullable();
            /* Response Status */
            $table->string('response_status')->nullable();
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
        Schema::dropIfExists('stock_receipts');
    }
};
