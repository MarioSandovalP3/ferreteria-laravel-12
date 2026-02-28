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
            // Add variant support columns
            $table->foreignId('parent_id')->nullable()->after('id')->constrained('products')->onDelete('cascade');
            $table->boolean('is_variant')->default(false)->after('parent_id');
            $table->json('variant_attributes')->nullable()->after('features');
            
            // Add indexes for performance
            $table->index('parent_id');
            $table->index('is_variant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropIndex(['parent_id']);
            $table->dropIndex(['is_variant']);
            $table->dropColumn(['parent_id', 'is_variant', 'variant_attributes']);
        });
    }
};
