<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Rename existing dosage column for backup
            $table->renameColumn('dosage', 'dosage_old');
            
            // Add new columns
            $table->decimal('dosage_amount', 10, 2)->nullable()->after('brand');
            $table->string('dosage_unit', 10)->nullable()->after('dosage_amount');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('dosage_old', 'dosage');
            $table->dropColumn(['dosage_amount', 'dosage_unit']);
        });
    }
};