<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // Idagdag ang prescription_id column
            $table->unsignedBigInteger('prescription_id')->nullable()->after('id');
            
            // Optional: foreign key constraint
            $table->foreign('prescription_id')
                  ->references('id')
                  ->on('prescriptions')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // I-drop ang foreign key muna
            $table->dropForeign(['prescription_id']);
            
            // I-drop ang column
            $table->dropColumn('prescription_id');
        });
    }
};