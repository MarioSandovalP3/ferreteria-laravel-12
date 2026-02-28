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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Quantity and Pricing
            $table->integer('quantity')->comment('Cantidad vendida');
            $table->decimal('unit_price', 10, 2)->comment('Precio unitario');
            
            // Discounts and Taxes per item
            $table->decimal('discount_percent', 5, 2)->default(0)->comment('% de descuento');
            $table->decimal('discount_amount', 10, 2)->default(0)->comment('Monto de descuento');
            $table->decimal('tax_percent', 5, 2)->default(0)->comment('% de impuesto (IVA)');
            $table->decimal('tax_amount', 10, 2)->default(0)->comment('Monto de impuesto');
            
            // Totals
            $table->decimal('subtotal', 10, 2)->comment('Cantidad × Precio - Descuento');
            $table->decimal('total', 10, 2)->comment('Subtotal + Impuesto');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
