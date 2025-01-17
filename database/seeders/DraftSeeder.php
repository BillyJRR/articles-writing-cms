<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Draft;
use Exception;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class DraftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = Article::with('author', 'categories')->get()->toArray();

        $totalRegistros = count($articles);
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $totalRegistros);
        $progressBar->start();

        foreach ($articles as $article) {
            try {
                $existDraft = Draft::where('article_id', $article['id'])->first();
                if (!$existDraft) {
                    $article['article_id'] = $article['id'];
                    $draft = Draft::create([
                        'article_id' => $article['id'],
                        'author_id' => $article['author_id'],
                        'title' => $article['title'],
                        'body' => $article['body'],
                        'image' => $article['image'],
                        'status' => $article['status'],
                        'status_text' => $article['status_text'],
                        'slug' => $article['slug'],
                        'created_at' => $article['created_at'],
                        'updated_at' => $article['updated_at'],
                        'deleted_at' => $article['deleted_at']
                    ]);
                    
                    $categoryIds = array_map(function ($category) {
                        return $category['id'];
                    }, $article['categories']);

                    $categories = Category::whereIn('id', $categoryIds)->pluck('id');
                    $draft->categories()->attach($categories);
                }

                $progressBar->advance();
            } catch (Exception $e) {
                $output->writeln("\nError en el registro N°".$article['id']);
                $output->writeln("Mensaje de error: {$e->getMessage()}");
                exit(1);
            }            
        }
    }
}
