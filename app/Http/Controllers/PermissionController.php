<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(PermissionService $service)
    {
        return $service->list();
    }

    public function store(Request $request, PermissionService $service)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string',
        ]);

        return $service->create($request->user(), $data);
    }

    public function show(Permission $permission, PermissionService $service)
    {
        return $service->show($permission);
    }

    public function update(Request $request, Permission $permission, PermissionService $service)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255|unique:permissions,name,' . $permission->id,
            'description' => 'nullable|string',
        ]);

        return $service->update($request->user(), $permission, $data);
    }

    public function destroy(Permission $permission, PermissionService $service)
    {
        $service->delete(request()->user(), $permission);

        return response()->noContent();
    }
}
