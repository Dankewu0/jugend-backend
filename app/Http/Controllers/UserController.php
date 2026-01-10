<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request, UserService $service)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'avatar' => 'sometimes|file|image',
        ]);

        return $service->register($data);
    }

    public function login(Request $request, UserService $service)
    {
        $data = $request->validate([
            'login' => 'required|string',
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
            'email' => 'sometimes|email',
            'password' => 'sometimes|string|min:6',
            'avatar' => 'sometimes|file|image',
        ]);

        return $service->update($request->user(), $data);
    }

    public function destroy(Request $request, UserService $service)
    {
        $service->selfDelete($request->user());
        return response()->noContent();
    }

    public function destroyUser(Request $request, int $id, UserService $service)
    {
        $service->adminDelete($request->user(), $id);
        return response()->noContent();
    }
}
