<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;

        return [
            'user_id' => 1,
            'author_id' => Author::inRandomOrder()->first()->id,
            'title' => $title,
            'body' => $this->faker->paragraphs(4, true),
            'image' => "articles/photo_default.jpg",
            'status' => 1,
            'status_text' => 'Publicado',
            'slug' => function () use ($title) {
                $category = Category::inRandomOrder()->first();
                return Str::slug($category->name . '-' . $title);
            },
        ];
    }
}
