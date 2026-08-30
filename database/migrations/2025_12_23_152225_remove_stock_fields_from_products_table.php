<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Remove stock-related fields (move to batches)
            $table->dropColumn(['quantity', 'pieces_per_box', 'pieces_left', 'total_pieces', 'expiry_date']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('quantity')->default(0);
            $table->integer('pieces_per_box')->nullable();
            $table->integer('pieces_left')->nullable();
            $table->integer('total_pieces')->nullable();
            $table->date('expiry_date')->nullable();
        });
    }
};