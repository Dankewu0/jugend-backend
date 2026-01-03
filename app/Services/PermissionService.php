<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\User;

class PermissionService
{
  public function list()
  {
    return Permission::all();
  }

  public function show(Permission $permission)
  {
    return $permission;
  }

  public function create(User $user, array $data)
  {
    ($user->hasRole('admin') || $user->hasRole('owner')) || abort(403);

    return Permission::create($data);
  }

  public function update(User $user, Permission $permission, array $data)
  {
    ($user->hasRole('admin') || $user->hasRole('owner')) || abort(403);

    $permission->update($data);

    return $permission->refresh();
  }

  public function delete(User $user, Permission $permission)
  {
    ($user->hasRole('admin') || $user->hasRole('owner')) || abort(403);

    $permission->delete();
  }
}
