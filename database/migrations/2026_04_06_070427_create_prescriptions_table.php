<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('prescription_number')->unique();
            $table->string('patient_name');
            $table->integer('patient_age')->nullable();
            $table->string('patient_contact')->nullable();
            $table->text('patient_address')->nullable();
            $table->string('doctor_name');
            $table->string('doctor_license')->nullable();
            $table->date('date_issued');
            $table->date('valid_until')->nullable();
            $table->text('special_instructions')->nullable();
            $table->enum('status', ['active', 'used', 'expired', 'cancelled'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};