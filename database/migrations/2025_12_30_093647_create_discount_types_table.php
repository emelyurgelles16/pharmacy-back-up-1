<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('discount_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Example: "PWD", "Senior Citizen"
            $table->string('code')->unique(); // Example: "PWD", "SENIOR"
            $table->decimal('discount_percent', 5, 2); // 20.00, 15.50
            $table->boolean('requires_id')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discount_types');
    }
};