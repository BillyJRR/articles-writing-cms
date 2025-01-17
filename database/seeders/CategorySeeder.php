<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Tecnología',
            'slug' => Str::slug('Tecnología'),
        ]);

        Category::create([
            'name' => 'Salud y Bienestar',
            'slug' => Str::slug('Salud y Bienestar'),
        ]);

        Category::create([
            'name' => 'Deportes',
            'slug' => Str::slug('Deportes'),
        ]);

        Category::create([
            'name' => 'Cultura y Entretenimiento',
            'slug' => Str::slug('Cultura y Entretenimiento'),
        ]);

        Category::create([
            'name' => 'Educación y Ciencia',
            'slug' => Str::slug('Educación y Ciencia'),
        ]);
    }
}
