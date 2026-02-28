<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('purchase_number')->nullable()->after('id');
        });

        // Generate purchase numbers for existing purchases
        $purchases = DB::table('purchases')->orderBy('created_at')->get();
        $numbersByYear = [];

        foreach ($purchases as $purchase) {
            $year = date('Y', strtotime($purchase->created_at));
            
            if (!isset($numbersByYear[$year])) {
                $numbersByYear[$year] = 1;
            }
            
            $purchaseNumber = "PO-{$year}-" . str_pad($numbersByYear[$year], 4, '0', STR_PAD_LEFT);
            
            DB::table('purchases')
                ->where('id', $purchase->id)
                ->update(['purchase_number' => $purchaseNumber]);
            
            $numbersByYear[$year]++;
        }

        // Make purchase_number unique after populating
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('purchase_number')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('purchase_number');
        });
    }
};
