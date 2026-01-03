<?php

namespace App\Services;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Str;

class ThreadService
{
  public function list()
  {
    return Thread::with(['user', 'category'])
      ->latest()
      ->paginate(20);
  }

  public function show(Thread $thread)
  {
    return $thread->load(['user', 'category', 'posts.user', 'attachments']);
  }

  public function create(User $user, array $data)
  {
    $user->can('create_thread') || abort(403);

    $thread = Thread::create([
      'user_id' => $user->id,
      'category_id' => $data['category_id'],
      'title' => $data['title'],
      'slug' => Str::slug($data['title']),
      'body' => $data['body'],
    ]);

    return $thread;
  }

  public function update(User $user, Thread $thread, array $data)
  {
    ($user->can('edit_thread') && $user->id === $thread->user_id) || abort(403);

    if (isset($data['title'])) {
      $data['slug'] = Str::slug($data['title']);
    }

    $thread->update($data);

    return $thread->refresh();
  }

  public function delete(User $user, Thread $thread)
  {
    ($user->can('delete_thread') && $user->id === $thread->user_id) || abort(403);

    $thread->delete();
  }
}
