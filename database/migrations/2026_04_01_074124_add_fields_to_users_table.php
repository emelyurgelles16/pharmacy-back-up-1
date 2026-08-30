<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('full_name')->nullable()->after('username');
            $table->string('employee_id')->nullable()->unique()->after('full_name');
            $table->string('contact_number')->nullable()->after('email');
            $table->text('address')->nullable()->after('contact_number');
            $table->boolean('is_active')->default(true)->after('address');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            $table->string('profile_photo')->nullable()->after('last_login_at');
            $table->text('notes')->nullable()->after('profile_photo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'full_name', 'employee_id', 'contact_number', 
                'address', 'is_active', 'last_login_at', 
                'profile_photo', 'notes'
            ]);
        });
    }
};