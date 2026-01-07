<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
  public function register(array $data)
  {
    return User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);
  }

  public function login(array $data)
  {
    $login = $data['login'];

    $user = str_contains($login, '@')
      ? User::where('email', $login)->first()
      : User::where('name', $login)->first();

    if (!$user || !Hash::check($data['password'], $user->password)) {
      abort(401, 'Invalid credentials');
    }

    return $user;
  }

  public function logout(User $user) {}

  public function update(User $user, array $data)
  {
    $user->update($data);
    return $user;
  }

  public function delete(User $user)
  {
    $user->delete();
  }

  public function deleteUser(User $current, int $id)
  {
    if ($current->role_id < 2) {
      abort(403);
    }

    $user = User::findOrFail($id);

    if ($user->role_id === 3 && $current->role_id !== 3) {
      abort(403);
    }

    $user->delete();
  }
}
