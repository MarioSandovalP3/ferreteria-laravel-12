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
        Schema::create('purchase_quotations', function (Blueprint $table) {
            $table->id();
            $table->string('rfq_number')->unique()->comment('Auto-generated: RFQ-YYYYMMDD-0001');
            $table->foreignId('supplier_id')->constrained('partners')->onDelete('restrict');
            $table->date('request_date');
            $table->date('expected_date')->nullable()->comment('When products are needed');
            $table->enum('status', ['draft', 'sent', 'received', 'approved', 'converted', 'cancelled'])->default('draft');
            $table->text('notes')->nullable()->comment('Notes visible to supplier');
            $table->text('internal_notes')->nullable()->comment('Internal notes not visible to supplier');
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('restrict');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('converted_to_purchase_id')->nullable()->constrained('purchases')->onDelete('set null');
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('status');
            $table->index('request_date');
            $table->index('supplier_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_quotations');
    }
};
