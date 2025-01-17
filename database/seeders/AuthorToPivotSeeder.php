<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Draft;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class AuthorToPivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = Article::all();
        $totalRegistros = count($articles->toArray());
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $totalRegistros);
        $progressBar->start();

        foreach ($articles as $article) {
            try {
                DB::table('article_author')->insert([
                    'article_id' => $article['id'],
                    'author_id' => $article['author_id'],
                ]);

                $progressBar->advance();
            } catch (Exception $e) {
                $output->writeln("\nError en el registro N°".$article['id']);
                $output->writeln("Mensaje de error: {$e->getMessage()}");
                exit(1);
            }
        }

        $progressBar->finish();
        $output->writeln("\nFinalizó la importación de autor con el articulo\n"); 

        $drafts = Draft::all();
        $totalRegistros_2 = count($drafts->toArray());
        $output_2 = new ConsoleOutput();
        $progressBar_2 = new ProgressBar($output_2, $totalRegistros_2);
        $progressBar_2->start();

        foreach ($drafts as $draft) {
            try {
                DB::table('draft_author')->insert([
                    'draft_id' => $draft['id'],
                    'author_id' => $draft['author_id'],
                ]);
                $progressBar_2->advance();
            } catch (Exception $e) {
                $output_2->writeln("\nError en el registro N°".$draft['id']);
                $output_2->writeln("Mensaje de error: {$e->getMessage()}");
                exit(1);
            }
        }

        $progressBar_2->finish();
        $output_2->writeln("\nFinalizó la importación de autor con el borrador\n"); 
    }
}
