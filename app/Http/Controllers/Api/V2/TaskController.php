<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function index()
    {
        return TaskResource::collection(auth()->user()->tasks()->get());
    }

    public function store(StoreTaskRequest $request)
    {
        $task = auth()->user()->tasks()->create($request->validated());

        return TaskResource::make($task);
    }

    public function show(Task $task)
    {
        Gate::authorize('view', $task);

        return TaskResource::make($task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return TaskResource::make($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->noContent();
    }
}
