<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(CategoryService $service)
    {
        return $service->list();
    }

    public function store(Request $request, CategoryService $service)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
        ]);

        return $service->create($request->user(), $data);
    }

    public function show(Category $category, CategoryService $service)
    {
        return $service->show($category);
    }

    public function update(Request $request, Category $category, CategoryService $service)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'sometimes|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
        ]);

        return $service->update($request->user(), $category, $data);
    }

    public function destroy(Category $category, CategoryService $service)
    {
        $service->delete(request()->user(), $category);

        return response()->noContent();
    }
}
