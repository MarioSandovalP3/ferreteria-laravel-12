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
        // Add tax breakdown fields to purchases
        Schema::table('purchases', function (Blueprint $table) {
            $table->decimal('taxable_subtotal', 10, 2)->default(0)->after('subtotal')->comment('Subtotal of taxable items');
            $table->decimal('exempt_subtotal', 10, 2)->default(0)->after('taxable_subtotal')->comment('Subtotal of tax-exempt items');
        });

        // Add tax breakdown fields to purchase_quotations
        Schema::table('purchase_quotations', function (Blueprint $table) {
            $table->decimal('taxable_subtotal', 10, 2)->default(0)->after('notes')->comment('Subtotal of taxable items');
            $table->decimal('exempt_subtotal', 10, 2)->default(0)->after('taxable_subtotal')->comment('Subtotal of tax-exempt items');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('exempt_subtotal')->comment('Total tax amount');
            $table->decimal('grand_total', 10, 2)->default(0)->after('tax_amount')->comment('Grand total including tax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn(['taxable_subtotal', 'exempt_subtotal']);
        });

        Schema::table('purchase_quotations', function (Blueprint $table) {
            $table->dropColumn(['taxable_subtotal', 'exempt_subtotal', 'tax_amount', 'grand_total']);
        });
    }
};
