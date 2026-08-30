<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if column exists before adding
            if (!Schema::hasColumn('users', 'otp_locked_until')) {
                $table->timestamp('otp_locked_until')->nullable()->after('otp_last_attempt_at');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('otp_locked_until');
        });
    }
};