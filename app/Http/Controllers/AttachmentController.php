<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Services\AttachmentService;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function index(AttachmentService $service)
    {
        return $service->list();
    }

    public function store(Request $request, AttachmentService $service)
    {
        $data = $request->validate([
            'filename' => 'required|string|max:255',
            'path' => 'required|string|max:1024',
            'post_id' => 'nullable|exists:posts,id',
            'thread_id' => 'nullable|exists:threads,id',
        ]);

        return $service->create($request->user(), $data);
    }

    public function show(Attachment $attachment, AttachmentService $service)
    {
        return $service->show($attachment);
    }

    public function update(Request $request, Attachment $attachment, AttachmentService $service)
    {
        $data = $request->validate([
            'filename' => 'sometimes|string|max:255',
            'path' => 'sometimes|string|max:1024',
        ]);

        return $service->update($request->user(), $attachment, $data);
    }

    public function destroy(Attachment $attachment, AttachmentService $service)
    {
        $service->delete(request()->user(), $attachment);

        return response()->noContent();
    }
}
