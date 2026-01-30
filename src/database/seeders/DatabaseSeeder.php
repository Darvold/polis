<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создаем 5 статей
        $articles = Article::factory()->count(5)->create();

        // Для каждой статьи создаем от 3 до 7 комментариев
        $articles->each(function ($article) {
            Comment::factory()->count(rand(3, 7))->create([
                'article_id' => $article->id,
            ]);
        });
    }
}
