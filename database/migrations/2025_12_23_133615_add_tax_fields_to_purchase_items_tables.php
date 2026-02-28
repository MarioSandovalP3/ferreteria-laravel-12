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
        // Add tax fields to purchase_items
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->decimal('tax_rate', 5, 2)->default(0)->after('subtotal')->comment('Tax rate applied to this item');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('tax_rate')->comment('Calculated tax amount for this item');
            $table->boolean('is_tax_exempt')->default(false)->after('tax_amount')->comment('Whether this item is tax exempt');
        });

        // Add tax fields to purchase_quotation_items
        Schema::table('purchase_quotation_items', function (Blueprint $table) {
            $table->decimal('tax_rate', 5, 2)->default(0)->after('quoted_price')->comment('Tax rate applied to this item');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('tax_rate')->comment('Calculated tax amount for this item');
            $table->boolean('is_tax_exempt')->default(false)->after('tax_amount')->comment('Whether this item is tax exempt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->dropColumn(['tax_rate', 'tax_amount', 'is_tax_exempt']);
        });

        Schema::table('purchase_quotation_items', function (Blueprint $table) {
            $table->dropColumn(['tax_rate', 'tax_amount', 'is_tax_exempt']);
        });
    }
};
