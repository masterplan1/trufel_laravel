<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->nullable()->after('id');
            $table->foreign('type_id')->references('id')->on('types');
            $table->unsignedBigInteger('category_id')->nullable()->change();
        });

        // Заповнити type_id з category_id через таблицю categories
        DB::statement('UPDATE products p JOIN categories c ON p.category_id = c.id SET p.type_id = c.type_id');

        // Зробити type_id NOT NULL після заповнення
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropColumn('type_id');
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
        });
    }
};
