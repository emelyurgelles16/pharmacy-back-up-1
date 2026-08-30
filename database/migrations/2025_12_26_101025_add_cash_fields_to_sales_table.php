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
        Schema::table('sales', function (Blueprint $table) {
            // Add cash_tendered column after total_amount
            $table->decimal('cash_tendered', 10, 2)
                  ->default(0)
                  ->after('total_amount')
                  ->comment('Amount paid by customer');
            
            // Add change column after cash_tendered  
            $table->decimal('change', 10, 2)
                  ->default(0)
                  ->after('cash_tendered')
                  ->comment('Change returned to customer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['cash_tendered', 'change']);
        });
    }
};