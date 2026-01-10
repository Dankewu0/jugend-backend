<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class UserService
{
  public function register(array $data): User
  {
    if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
      $data['avatar'] = $data['avatar']->store('avatars', 'public');
    }

    $user = User::query()->create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
      'avatar' => $data['avatar'] ?? null,
    ]);

    $user->createToken('api-token')->plainTextToken;

    return $user;
  }

  public function login(array $data): User
  {
    $login = $data['login'];

    $user = User::query()
      ->where('email', $login)
      ->orWhere('name', $login)
      ->first();

    if (!$user || !Hash::check($data['password'], $user->password)) {
      abort(401);
    }

    $user->createToken('api-token')->plainTextToken;

    return $user;
  }

  public function logout(User $user): void
  {
    $token = $user->currentAccessToken();

    if ($token instanceof PersonalAccessToken) {
      $token->delete();
    }
  }

  public function update(User $user, array $data): User
  {
    if (isset($data['password'])) {
      $data['password'] = Hash::make($data['password']);
    }

    if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
      $data['avatar'] = $data['avatar']->store('avatars', 'public');
    }

    $user->fill($data);
    $user->save();

    return $user;
  }

  public function selfDelete(User $user): void
  {
    $user->delete();
  }

  public function adminDelete(User $current, int $id): void
  {
    if ($current->role_id < 2) {
      abort(403);
    }

    $user = User::query()->findOrFail($id);

    if ($user->role_id === 3 && $current->role_id !== 3) {
      abort(403);
    }

    $user->delete();
  }
}
