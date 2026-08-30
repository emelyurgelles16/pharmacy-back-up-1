<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Check if column exists before adding (para iwas error)
            if (!Schema::hasColumn('products', 'dosage_amount')) {
                $table->decimal('dosage_amount', 10, 2)->nullable()->after('brand');
            }
            if (!Schema::hasColumn('products', 'dosage_unit')) {
                $table->string('dosage_unit', 10)->nullable()->after('dosage_amount');
            }
            if (!Schema::hasColumn('products', 'form')) {
                $table->string('form')->nullable()->after('dosage_unit');
            }
            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable()->after('price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['dosage_amount', 'dosage_unit', 'form', 'image']);
        });
    }
};