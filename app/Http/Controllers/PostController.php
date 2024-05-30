<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Requests\LikeRequest;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CommentRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return view('posts.all', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        Post::create([
            'user_id' => auth()->id(),
            'content' => $request->validated('content'),
        ]);
        return redirect()->route('post.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        Gate::authorize('update', $post);

        $post->update([
            'content' => $request->validated('content')
        ]);

        return redirect()->route('post.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return redirect()->route('post.index')->with('success', 'Post deleted successfully.');
    }

    public function like(LikeRequest $request,Post $post)
    {
        $like = Like::where('user_id', Auth::id())->where('post_id', $post->id)->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $post->id,
            ]);
        }

        return redirect()->back();
    }


    public function storeComment(CommentRequest $request, Post $post)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'content' => $request->validated('content'),
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
}
