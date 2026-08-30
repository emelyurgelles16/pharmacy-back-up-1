<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // ilalagay natin total_pieces pagkatapos ng pieces_left
            if (!Schema::hasColumn('products', 'total_pieces')) {
                $table->integer('total_pieces')->nullable()->after('pieces_left');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('total_pieces');
        });
    }
};
