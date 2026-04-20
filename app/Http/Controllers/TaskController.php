<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(private readonly TaskService $taskService) {}

    public function index(int $projectId)
    {
        $tasks = $this->taskService->getTasksForProject($projectId);
        return view('tasks.index', compact('tasks', 'projectId'));
    }

    public function store(StoreTaskRequest $request, int $projectId)
    {
        $this->taskService->createTask([...$request->validated(), 'project_id' => $projectId]);
        return redirect()->route('tasks.index', $projectId)->with('success', 'Tâche créée !');
    }

    public function update(Request $request, int $id)
    {
        $this->taskService->updateTask($id, $request->only('title', 'description', 'status', 'assigned_to'));
        return redirect()->back()->with('success', 'Tâche mise à jour.');
    }

   public function destroy(int $id)
{
    $task = $this->taskService->getTaskById($id);
    $projectId = $task->project_id;

    $this->taskService->deleteTask($id);

    return redirect()->route('tasks.index', $projectId)
        ->with('success', 'Tâche supprimée.');
}

    public function updateStatus(Request $request, int $id)
    {
        $request->validate(['status' => 'required|in:TODO,IN_PROGRESS,DONE']);
        $task = $this->taskService->changeStatus($id, $request->status);
        return response()->json(['success' => true, 'task' => $task]);
    }
}