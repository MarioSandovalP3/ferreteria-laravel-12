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
            
            // User and Client
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('Vendedor/Cajero');
            $table->foreignId('client_id')->nullable()->constrained('partners')->onDelete('set null')->comment('Cliente (null = público general)');
            
            // Invoice Info
            $table->string('invoice_number')->unique()->comment('Número de folio/factura');
            $table->enum('status', ['completed', 'pending', 'cancelled'])->default('pending');
            
            // Amounts
            $table->decimal('subtotal', 10, 2)->default(0)->comment('Suma sin impuestos');
            $table->decimal('tax_amount', 10, 2)->default(0)->comment('Monto total de impuestos (IVA)');
            $table->decimal('discount_amount', 10, 2)->default(0)->comment('Descuento total aplicado');
            $table->decimal('total', 10, 2)->default(0)->comment('Total a pagar');
            
            // Payment Info
            $table->enum('payment_status', ['paid', 'partial', 'unpaid'])->default('unpaid');
            $table->enum('payment_method', ['cash', 'card', 'transfer', 'mixed', 'credit'])->nullable();
            
            // Notes
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
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
