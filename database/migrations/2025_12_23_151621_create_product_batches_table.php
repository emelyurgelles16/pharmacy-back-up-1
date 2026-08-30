<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_batches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');           // Boxes in this batch
            $table->integer('pieces_per_box');
            $table->integer('pieces_left');        // Remaining pieces in this batch
            $table->date('expiry_date')->nullable();
            $table->date('arrival_date')->nullable();
            $table->string('batch_number')->nullable();
            $table->timestamps();
            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_batches');
    }
};