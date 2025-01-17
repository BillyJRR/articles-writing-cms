<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create([
            'name' => 'Juan Pérez',
            'slug' => Str::slug('Juan Pérez'),
        ]);

        Author::create([
            'name' => 'María González',
            'slug' => Str::slug('María González'),
        ]);

        Author::create([
            'name' => 'Carlos Fernández',
            'slug' => Str::slug('Carlos Fernández'),
        ]);

        Author::create([
            'name' => 'Laura Medina',
            'slug' => Str::slug('Laura Medina'),
        ]);

        Author::create([
            'name' => 'José Ramírez',
            'slug' => Str::slug('José Ramírez'),
        ]);
    }
}
