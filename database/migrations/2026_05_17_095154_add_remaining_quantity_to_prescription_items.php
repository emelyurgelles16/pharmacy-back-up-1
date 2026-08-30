<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prescription_items', function (Blueprint $table) {
            // Rename 'quantity' to 'quantity_prescribed' for clarity
            $table->renameColumn('quantity', 'quantity_prescribed');
            
            // Add new columns
            $table->integer('quantity_remaining')->default(0);
            $table->integer('quantity_dispensed')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('prescription_items', function (Blueprint $table) {
            $table->renameColumn('quantity_prescribed', 'quantity');
            $table->dropColumn(['quantity_remaining', 'quantity_dispensed']);
        });
    }
};