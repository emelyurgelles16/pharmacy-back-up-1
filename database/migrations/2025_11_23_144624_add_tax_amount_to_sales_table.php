<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {

            // Add tax_amount only if it does NOT exist
            if (!Schema::hasColumn('sales', 'tax_amount')) {
                $table->decimal('tax_amount', 10, 2)->default(0);
            }

            // Add total_amount only if NOT exists
            if (!Schema::hasColumn('sales', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {

            if (Schema::hasColumn('sales', 'tax_amount')) {
                $table->dropColumn('tax_amount');
            }

            if (Schema::hasColumn('sales', 'total_amount')) {
                $table->dropColumn('total_amount');
            }
        });
    }
};
