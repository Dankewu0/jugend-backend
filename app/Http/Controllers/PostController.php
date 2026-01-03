<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(PostService $service)
    {
        return $service->list();
    }

    public function store(Request $request, PostService $service)
    {
        $data = $request->validate([
            'content' => 'required|string',
            'thread_id' => 'required|exists:threads,id',
            'parent_id' => 'nullable|exists:posts,id',
        ]);

        return $service->create($request->user(), $data);
    }

    public function show(Post $post, PostService $service)
    {
        return $service->show($post);
    }

    public function update(Request $request, Post $post, PostService $service)
    {
        $data = $request->validate([
            'content' => 'sometimes|string',
        ]);

        return $service->update($request->user(), $post, $data);
    }

    public function destroy(Post $post, PostService $service)
    {
        $service->delete(request()->user(), $post);

        return response()->noContent();
    }
}
