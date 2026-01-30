<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    /**
     * Просмотр списка статей
     */
    public function index(): JsonResponse
    {
        $articles = Article::withCount('comments')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'content' => $this->getExcerpt($article->content, 150),
                    'created_at' => $article->created_at->format('d.m.Y H:i'),
                    'comments_count' => $article->comments_count,
                ];
            });

        return response()->json($articles);
    }

    /**
     * Просмотр одной статьи с комментариями
     */
    public function show(int $id): JsonResponse
    {
        $article = Article::with(['comments' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return response()->json([
            'id' => $article->id,
            'title' => $article->title,
            'content' => $article->content,
            'created_at' => $article->created_at->format('d.m.Y H:i'),
            'comments' => $article->comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'author_name' => $comment->author_name,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->format('d.m.Y H:i'),
                ];
            }),
        ]);
    }

    /**
     * Добавление статьи
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article = Article::create($validated);

        return response()->json([
            'message' => 'Статья успешно создана',
            'article' => [
                'id' => $article->id,
                'title' => $article->title,
                'content' => $article->content,
                'created_at' => $article->created_at->format('d.m.Y H:i'),
            ]
        ], 201);
    }

    /**
     * Обновление статьи (опционально, если нужно)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        ]);

        $article->update($validated);

        return response()->json([
            'message' => 'Статья успешно обновлена',
            'article' => $article
        ]);
    }

    /**
     * Удаление статьи (опционально, если нужно)
     */
    public function destroy(int $id): JsonResponse
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return response()->json([
            'message' => 'Статья успешно удалена'
        ]);
    }

    /**
     * Вспомогательная функция для получения отрывка текста
     */
    private function getExcerpt(string $text, int $length = 150): string
    {
        if (mb_strlen($text) <= $length) {
            return $text;
        }

        $excerpt = mb_substr($text, 0, $length);
        $lastSpace = mb_strrpos($excerpt, ' ');

        if ($lastSpace !== false) {
            $excerpt = mb_substr($excerpt, 0, $lastSpace);
        }

        return $excerpt . '...';
    }
}
