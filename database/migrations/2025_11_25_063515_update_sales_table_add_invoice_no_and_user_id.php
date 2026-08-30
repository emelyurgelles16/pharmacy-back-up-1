<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('invoice_no')->unique()->after('id');
            $table->foreignId('user_id')->constrained()->after('invoice_no');
            $table->decimal('tax_rate', 5, 2)->default(12.00)->after('subtotal');
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['invoice_no', 'user_id', 'tax_rate']);
        });
    }
};