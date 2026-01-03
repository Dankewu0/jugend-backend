<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request, UserService $service)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|min:2|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        return $service->register($data);
    }

    public function login(Request $request, UserService $service)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        return $service->login($data);
    }

    public function logout(Request $request, UserService $service)
    {
        $service->logout($request->user());
        return response()->noContent();
    }

    public function me(Request $request)
    {
        return $request->user();
    }

    public function update(Request $request, UserService $service)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|min:3|max:255',
            'email' => 'sometimes|string|min:2|max:255',
        ]);

        return $service->update($request->user(), $data);
    }

    public function destroy(Request $request, UserService $service)
    {
        $service->delete($request->user());
        return response()->noContent();
    }

    public function destroyUser(Request $request, int $id, UserService $service)
    {
        $service->deleteUser($request->user(), $id);
        return response()->noContent();
    }
}
