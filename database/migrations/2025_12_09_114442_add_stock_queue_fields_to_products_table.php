<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Optional: Add stock source tracking
            $table->enum('stock_source', ['direct', 'queue'])->default('direct');
            $table->foreignId('last_stock_queue_id')->nullable()->constrained('stock_queues');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['stock_source', 'last_stock_queue_id']);
        });
    }
};