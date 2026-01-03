<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;

class PostService
{
  public function list()
  {
    return Post::with(['user', 'thread', 'parent'])
      ->latest()
      ->paginate(20);
  }

  public function show(Post $post)
  {
    return $post->load(['user', 'thread', 'parent', 'children']);
  }

  public function create(User $user, array $data)
  {
    $user->can('create_post') || abort(403);

    $post = Post::create([
      'user_id' => $user->id,
      'thread_id' => $data['thread_id'],
      'parent_id' => $data['parent_id'] ?? null,
      'content' => $data['content'],
    ]);

    return $post->load(['user', 'thread', 'parent']);
  }

  public function update(User $user, Post $post, array $data)
  {
    ($user->can('edit_post') && $user->id === $post->user_id)
      || abort(403);

    $post->update($data);

    return $post->refresh()->load(['user', 'thread', 'parent', 'children']);
  }

  public function delete(User $user, Post $post)
  {
    ($user->can('delete_post') && $user->id === $post->user_id)
      || abort(403);

    $post->delete();
  }
}
