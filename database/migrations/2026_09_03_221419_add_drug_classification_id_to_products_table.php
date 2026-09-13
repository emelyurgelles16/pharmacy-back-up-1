<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('drug_classification_id')
                  ->nullable()
                  ->after('category')
                  ->constrained('drug_classifications')
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['drug_classification_id']);
            $table->dropColumn('drug_classification_id');
        });
    }
};