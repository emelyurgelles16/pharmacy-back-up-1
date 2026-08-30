<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->decimal('dosage_amount', 10, 2)->nullable();  // ✅ binago
            $table->string('dosage_unit', 10)->nullable();       // ✅ bago
            $table->string('form')->nullable();                   // ✅ bago
            $table->string('type');
            $table->string('category')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();                  // ✅ bago
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};