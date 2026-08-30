<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stock_queues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable(); // CHANGE: remove foreign key muna
            
            // Kung bagong product (wala sa products table)
            $table->string('product_name')->nullable();
            $table->string('brand')->nullable();
            $table->string('dosage')->nullable();
            $table->string('form')->nullable();
            $table->string('type')->nullable();
            $table->string('category')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('pieces_per_box')->nullable();
            $table->date('expiry_date')->nullable();
            
            // Stock details
            $table->integer('quantity'); // boxes na idinagdag
            $table->integer('total_pieces'); // auto-computed: quantity * pieces_per_box
            $table->dateTime('arrival_date')->nullable(); // REQUIRED FOR NEW STOCK
            
            // Status tracking
            $table->enum('status', ['pending', 'in_queue', 'transferred'])->default('pending');
            $table->unsignedBigInteger('added_by')->nullable(); // CHANGE: remove foreign key muna
            $table->dateTime('transferred_at')->nullable();
            $table->unsignedBigInteger('transferred_by')->nullable(); // CHANGE: remove foreign key muna
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_queues');
    }
};