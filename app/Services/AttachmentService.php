<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\User;

class AttachmentService
{
  public function list()
  {
    return Attachment::with(['user', 'post', 'thread'])
      ->latest()
      ->paginate(20);
  }

  public function create(User $user, array $data)
  {
    $user || abort(403);

    $attachment = Attachment::create([
      'user_id' => $user->id,
      'post_id' => $data['post_id'] ?? null,
      'thread_id' => $data['thread_id'] ?? null,
      'filename' => $data['filename'],
      'path' => $data['path'],
    ]);

    return $attachment->load(['user', 'post', 'thread']);
  }

  public function show(Attachment $attachment)
  {
    return $attachment->load(['user', 'post', 'thread']);
  }

  public function update(User $user, Attachment $attachment, array $data)
  {
    ($user->id === $attachment->user_id || $user->hasRole('admin') || $user->hasRole('owner'))
      || abort(403);

    $attachment->update($data);

    return $attachment->refresh()->load(['user', 'post', 'thread']);
  }

  public function delete(User $user, Attachment $attachment)
  {
    ($user->id === $attachment->user_id || $user->hasRole('admin') || $user->hasRole('owner'))
      || abort(403);

    $attachment->delete();
  }
}
