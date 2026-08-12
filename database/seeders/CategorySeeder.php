<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Power Tools',
            'Hand Tools',
            'Fasteners',
            'Electrical',
            'Plumbing',
            'Paint & Finishing',
            'Building Materials',
            'Safety & PPE',
            'Adhesives & Sealants',
            'Hardware & Accessories',
        ];

        foreach ($categories as $name) {
            Category::query()->firstOrCreate(['name' => $name]);
        }
    }
}
