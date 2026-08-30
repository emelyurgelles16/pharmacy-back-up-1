<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if table doesn't exist yet
        if (!Schema::hasTable('user_trusted_devices')) {
            Schema::create('user_trusted_devices', function (Blueprint $table) {
                $table->id();
                // Use simple unsigned big integer (NO foreign key)
                $table->unsignedBigInteger('user_id');
                $table->string('device_id')->unique();
                $table->string('device_name')->nullable();
                $table->string('ip_address')->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamp('last_used_at');
                $table->timestamp('expires_at')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                
                // Indexes for faster queries
                $table->index('user_id');
                $table->index(['user_id', 'device_id']);
                $table->index(['user_id', 'is_active']);
                $table->index('expires_at');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('user_trusted_devices');
    }
};