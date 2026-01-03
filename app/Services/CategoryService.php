<?php

namespace App\Services;

use App\Models\Category;
use App\Models\User;

class CategoryService
{
  public function list()
  {
    return Category::all();
  }

  public function show(Category $category)
  {
    return $category;
  }

  public function create(User $user, array $data)
  {
    ($user->hasRole('admin') || $user->hasRole('owner')) || abort(403);

    return Category::create($data);
  }

  public function update(User $user, Category $category, array $data)
  {
    ($user->hasRole('admin') || $user->hasRole('owner')) || abort(403);

    $category->update($data);

    return $category->refresh();
  }

  public function delete(User $user, Category $category)
  {
    ($user->hasRole('admin') || $user->hasRole('owner')) || abort(403);

    $category->delete();
  }
}
