<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $sortDirection = $request->input('sort_direction', 'desc');

        $comments = Comment::query()
            ->orderBy('id', $sortDirection)
            ->paginate($perPage);

        return response()->json([
            'data' => $comments->map(fn($c) => [
                'id' => $c->id,
                'author_name' => $c->author_name,
                'description' => $c->description,
                'estimation' => $c->estimation,
                'created_at' => $c->created_at->format('d.m.Y H:i'),
            ]),
            'meta' => [
                'total' => $comments->total(),
                'per_page' => $comments->perPage(),
                'from' => $comments->firstItem(),
                'to' => $comments->lastItem(),
                'links' => $comments->linkCollection()->toArray(),
            ],
        ]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->noContent();
    }
}
