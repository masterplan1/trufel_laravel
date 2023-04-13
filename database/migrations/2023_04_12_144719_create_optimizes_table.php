<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('optimizes', function (Blueprint $table) {
            $table->id();
            $table->string('img', 255);
            $table->boolean('done')->default(0);
            $table->string('error', 255)->nullable();
            $table->integer('diff', false, true)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('optimizes');
    }
};
