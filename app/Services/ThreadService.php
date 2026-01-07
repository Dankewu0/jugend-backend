<?php

namespace App\Services;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Str;

class ThreadService
{
  public function list(int $perPage = 20)
  {
    return Thread::with(['user', 'category'])
      ->latest()
      ->paginate($perPage);
  }

  public function show(Thread $thread)
  {
    return $thread->load(['user', 'category', 'posts.user', 'attachments']);
  }

  public function create(User $user, array $data)
  {
    if (!$user->can('create_thread')) {
      abort(403);
    }

    return Thread::create([
      'user_id' => $user->id,
      'category_id' => $data['category_id'],
      'title' => $data['title'],
      'slug' => Str::slug($data['title']),
      'body' => $data['body'],
    ]);
  }

  public function update(User $user, Thread $thread, array $data)
  {
    if (!$user->can('edit_thread') || $user->id !== $thread->user_id) {
      abort(403);
    }

    if (isset($data['title'])) {
      $data['slug'] = Str::slug($data['title']);
    }

    $thread->update($data);

    return $thread->refresh();
  }

  public function delete(User $user, Thread $thread)
  {
    if (!$user->can('delete_thread') || $user->id !== $thread->user_id) {
      abort(403);
    }

    $thread->delete();
  }

  public function popular(int $limit = 5)
  {
    return Thread::withCount('posts')
      ->with(['user', 'category'])
      ->orderByDesc('posts_count')
      ->orderByDesc('updated_at')
      ->take($limit)
      ->get();
  }
}
