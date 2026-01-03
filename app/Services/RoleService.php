<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;

class RoleService
{
  public function list()
  {
    return Role::all();
  }

  public function show(Role $role)
  {
    return $role;
  }

  public function create(User $user, array $data)
  {
    ($user->hasRole('admin') || $user->hasRole('owner')) || abort(403);

    return Role::create($data);
  }

  public function update(User $user, Role $role, array $data)
  {
    ($user->hasRole('admin') || $user->hasRole('owner')) || abort(403);

    $role->update($data);

    return $role->refresh();
  }

  public function delete(User $user, Role $role)
  {
    ($user->hasRole('admin') || $user->hasRole('owner')) || abort(403);

    $role->delete();
  }
}
