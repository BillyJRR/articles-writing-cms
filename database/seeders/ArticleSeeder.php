<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::factory(100)->create()->each(function ($article) {
            $categories = Category::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();
            $article->categories()->attach($categories);

            sort($categories);
            $firstCategory = Category::find($categories[0]);
            $article->slug = Str::slug($firstCategory->name) . '/' . Str::slug($article->title);
            $article->save();
        });
    }
}
