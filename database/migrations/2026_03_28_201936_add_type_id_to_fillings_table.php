<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fillings', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->nullable()->after('id');
            $table->foreignId('category_id')->nullable()->change();
        });

        // Populate type_id from existing category relationships
        DB::statement('
            UPDATE fillings f
            JOIN categories c ON f.category_id = c.id
            SET f.type_id = c.type_id
            WHERE f.category_id IS NOT NULL
        ');

        Schema::table('fillings', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('fillings', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropColumn('type_id');
            $table->foreignId('category_id')->nullable(false)->change();
        });
    }
};
