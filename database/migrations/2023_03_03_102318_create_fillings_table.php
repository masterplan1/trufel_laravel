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
        Schema::create('fillings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            // $table->foreignId('category_id');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('image');
            $table->text('description');
            $table->integer('unit_price');
            $table->string('min_weight')->nullable();
            $table->string('min_quantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fillings');
    }
};
