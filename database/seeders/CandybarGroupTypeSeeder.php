<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class CandybarGroupTypeSeeder extends Seeder
{
    public function run(): void
    {
        // Ідемпотентно: не створює дубль якщо вже є
        Type::firstOrCreate(
            ['is_candybar_group' => true],
            [
                'name'              => 'Кендібар',
                'weight_quantity'   => 'quantity',
                'is_candybar'       => false,
                'is_candybar_group' => true,
                'image'             => null,
            ]
        );
    }
}
