<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if columns exist before adding
            if (!Schema::hasColumn('users', 'is_verified')) {
                $table->boolean('is_verified')->default(false);
            }
            if (!Schema::hasColumn('users', 'otp_expires_at')) {
                $table->timestamp('otp_expires_at')->nullable();
            }
            if (!Schema::hasColumn('users', 'otp_attempts')) {
                $table->integer('otp_attempts')->default(0);
            }
            if (!Schema::hasColumn('users', 'otp_last_attempt_at')) {
                $table->timestamp('otp_last_attempt_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_verified',
                'otp_expires_at',
                'otp_attempts',
                'otp_last_attempt_at'
            ]);
        });
    }
};