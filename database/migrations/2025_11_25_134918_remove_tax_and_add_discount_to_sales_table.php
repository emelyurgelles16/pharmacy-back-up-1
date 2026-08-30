<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Remove tax columns
            $table->dropColumn(['tax_rate', 'tax_amount']);
            
            // Add discount column
            $table->decimal('discount', 10, 2)->default(0)->after('subtotal');
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Add back tax columns
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            
            // Remove discount column
            $table->dropColumn('discount');
        });
    }
};