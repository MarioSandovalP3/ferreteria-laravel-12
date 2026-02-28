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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            // Product Type: physical, service, digital
            $table->enum('product_type', ['physical', 'service', 'digital'])->default('physical');
            
            $table->string('sku')->unique();
            $table->string('barcode')->unique()->nullable()->comment('Barcode for POS and supply chain');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            
            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('compare_at_price', 10, 2)->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->boolean('on_sale')->default(false);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->timestamp('sale_starts_at')->nullable();
            $table->timestamp('sale_ends_at')->nullable();
            
            // Inventory
            $table->integer('stock')->default(0);
            $table->integer('low_stock_threshold')->default(5);
            $table->boolean('track_inventory')->default(true);
            $table->boolean('allow_backorder')->default(false);
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'on_backorder'])->default('in_stock');
            
            // Physical Properties (for physical products)
            $table->decimal('weight', 8, 2)->nullable()->comment('Weight in kg');
            $table->decimal('length', 8, 2)->nullable()->comment('Length in cm');
            $table->decimal('width', 8, 2)->nullable()->comment('Width in cm');
            $table->decimal('height', 8, 2)->nullable()->comment('Height in cm');
            $table->boolean('requires_shipping')->default(true);
            
            // Service Fields (for service products)
            $table->integer('duration')->nullable()->comment('Service duration in minutes');
            $table->boolean('booking_required')->default(false);
            $table->integer('max_bookings_per_day')->nullable();
            
            // Digital Product Fields (for digital products)
            $table->enum('file_type', ['ebook', 'video', 'audio', 'software', 'template', 'document', 'other'])->nullable()->comment('Type of digital file');
            $table->string('file_path')->nullable()->comment('Path to downloadable file');
            $table->string('download_url')->nullable()->comment('Public download URL');
            $table->string('preview_url')->nullable()->comment('Preview/demo URL or path');
            $table->decimal('file_size', 10, 2)->nullable()->comment('File size in MB');
            $table->string('version')->nullable()->comment('Version number for software/templates');
            $table->integer('download_limit')->nullable()->comment('Max downloads per purchase');
            $table->integer('download_expiry_days')->nullable()->comment('Days until download link expires');
            
            // Images
            $table->string('featured_image')->nullable();
            $table->json('images')->nullable();
            
            // Product Details
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
            $table->string('model')->nullable();
            $table->json('specifications')->nullable();
            $table->json('features')->nullable();
            
            // Status & Visibility
            $table->boolean('is_active')->default(true);
            $table->enum('status', ['active', 'draft', 'inactive'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
            $table->integer('views')->default(0);
            $table->integer('order')->default(0);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
