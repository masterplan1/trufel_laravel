<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('types', function (Blueprint $table) {
            $table->string('image')->nullable()->after('is_candybar');
            $table->boolean('is_candybar_group')->default(false)->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('types', function (Blueprint $table) {
            $table->dropColumn(['image', 'is_candybar_group']);
        });
    }
};
