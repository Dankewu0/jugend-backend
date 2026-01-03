<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(RoleService $service)
    {
        return $service->list();
    }

    public function show(Role $role, RoleService $service)
    {
        return $service->show($role);
    }

    public function store(Request $request, RoleService $service)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        return $service->create($request->user(), $data);
    }

    public function update(Request $request, Role $role, RoleService $service)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255|unique:roles,name,' . $role->id,
        ]);

        return $service->update($request->user(), $role, $data);
    }

    public function destroy(Role $role, RoleService $service)
    {
        $service->delete(request()->user(), $role);

        return response()->noContent();
    }
}
