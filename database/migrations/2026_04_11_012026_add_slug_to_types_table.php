<?php

use App\Models\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('types', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });

        foreach (Type::all() as $type) {
            $type->updateQuietly(['slug' => Str::slug(Str::transliterate($type->name))]);
        }

        Schema::table('types', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('types', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
