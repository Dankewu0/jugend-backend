<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Services\ThreadService;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    protected ThreadService $service;

    public function __construct(ThreadService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->list();
    }

    public function popular()
    {
        return $this->service->popular();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        return $this->service->create($request->user(), $data);
    }

    public function show(Thread $thread)
    {
        return $this->service->show($thread);
    }

    public function update(Request $request, Thread $thread)
    {
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'body' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        return $this->service->update($request->user(), $thread, $data);
    }

    public function destroy(Thread $thread)
    {
        $this->service->delete(request()->user(), $thread);

        return response()->noContent();
    }
}
