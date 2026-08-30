<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            if (!Schema::hasColumn('sales', 'discount_type_id')) {
                $table->foreignId('discount_type_id')
                      ->nullable()
                      ->after('change')
                      ->constrained('discount_types')
                      ->onDelete('set null');
            }
            
            if (!Schema::hasColumn('sales', 'discount_percent')) {
                $table->decimal('discount_percent', 5, 2)
                      ->default(0)
                      ->after('discount_type_id');
            }
            
            if (!Schema::hasColumn('sales', 'customer_type')) {
                $table->string('customer_type')
                      ->default('walk_in')
                      ->after('discount_percent')
                      ->comment('walk_in, pwd, senior, etc.');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['discount_type_id']);
            $table->dropColumn(['discount_type_id', 'discount_percent', 'customer_type']);
        });
    }
};