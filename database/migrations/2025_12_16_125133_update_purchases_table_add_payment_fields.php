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
        Schema::table('purchases', function (Blueprint $table) {
            // Renombrar total_amount a total
            $table->renameColumn('total_amount', 'total');
        });
        
        Schema::table('purchases', function (Blueprint $table) {
            // Agregar nuevos campos
            $table->decimal('subtotal', 10, 2)->default(0)->after('invoice_number');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('subtotal');
            $table->enum('payment_status', ['paid', 'pending', 'partial'])->default('pending')->after('status');
            $table->date('due_date')->nullable()->after('payment_status')->comment('Fecha de vencimiento si es crédito');
        });
        
        // Copiar total a subtotal para datos existentes
        DB::statement('UPDATE purchases SET subtotal = total WHERE subtotal = 0');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'tax_amount', 'payment_status', 'due_date']);
        });
        
        Schema::table('purchases', function (Blueprint $table) {
            $table->renameColumn('total', 'total_amount');
        });
    }
};
