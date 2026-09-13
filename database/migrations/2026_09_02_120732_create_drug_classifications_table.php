<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('drug_classifications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique()->nullable();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->string('color')->default('#6c757d');
            $table->enum('type', ['OTC', 'Prescription', 'Dangerous'])->nullable()->change();
            $table->boolean('requires_prescription')->default(false);
            $table->boolean('requires_special_handling')->default(false);
            $table->boolean('requires_logging')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('drug_classifications');
    }
};