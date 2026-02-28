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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('tax_rate', 5, 2)->default(16.00)->after('cost')->comment('Tax rate percentage (e.g., 16.00 for 16%)');
            $table->boolean('is_tax_exempt')->default(false)->after('tax_rate')->comment('Whether product is exempt from tax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['tax_rate', 'is_tax_exempt']);
        });
    }
};
