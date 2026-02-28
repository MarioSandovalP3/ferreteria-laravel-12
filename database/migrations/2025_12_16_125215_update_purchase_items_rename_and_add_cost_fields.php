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
        Schema::table('purchase_items', function (Blueprint $table) {
            // Renombrar unit_price a cost
            $table->renameColumn('unit_price', 'cost');
        });
        
        Schema::table('purchase_items', function (Blueprint $table) {
            // Agregar campos de histórico de costos
            $table->decimal('previous_cost', 10, 2)->nullable()->after('cost')->comment('Costo anterior del producto');
            $table->decimal('new_average_cost', 10, 2)->nullable()->after('previous_cost')->comment('Nuevo costo promedio calculado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->dropColumn(['previous_cost', 'new_average_cost']);
        });
        
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->renameColumn('cost', 'unit_price');
        });
    }
};
