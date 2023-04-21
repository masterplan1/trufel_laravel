<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function testimonials()
    {
        $comments = Comment::orderBy('id', 'desc')->get();
        return view('testimonials', ['comments' => $comments]);
    }

    public function addTestimonial(Request $request)
    {
        $validated = $request->validate([
            'author_name' => 'required',
            'estimation' => 'integer|nullable',
            'description' => 'required',
        ]);
        $comment = Comment::create($validated);
        return response($comment);
    }
}
