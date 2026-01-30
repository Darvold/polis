<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Добавление комментария к статье
     */
    public function store(Request $request, int $articleId): JsonResponse
    {
        $article = Article::findOrFail($articleId);

        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'article_id' => $articleId,
            'author_name' => $validated['author_name'],
            'content' => $validated['content'],
        ]);

        return response()->json([
            'message' => 'Комментарий успешно добавлен',
            'comment' => [
                'id' => $comment->id,
                'author_name' => $comment->author_name,
                'content' => $comment->content,
                'created_at' => $comment->created_at->format('d.m.Y H:i'),
            ]
        ], 201);
    }

    /**
     * Получение комментариев статьи
     */
    public function index(int $articleId): JsonResponse
    {
        $article = Article::findOrFail($articleId);

        $comments = $article->comments()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'author_name' => $comment->author_name,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->format('d.m.Y H:i'),
                ];
            });

        return response()->json($comments);
    }
}
