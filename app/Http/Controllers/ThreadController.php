<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Services\ThreadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThreadController extends Controller
{
    public function index(ThreadService $service)
    {
        return $service->list();
    }

    public function store(Request $request, ThreadService $service)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        return $service->create($request->user(), $data);
    }

    public function show(Thread $thread, ThreadService $service)
    {
        return $service->show($thread);
    }

    public function update(Request $request, Thread $thread, ThreadService $service)
    {
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'body' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        return $service->update($request->user(), $thread, $data);
    }

    public function destroy(Thread $thread, ThreadService $service)
    {
        $service->delete(request()->user(), $thread);

        return response()->noContent();
    }
}
