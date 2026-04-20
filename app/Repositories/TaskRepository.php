<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAllForProject(int $projectId): Collection
    {
        return Task::where('project_id', $projectId)->with('assignee')->get();
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function findOrFail(int $id): Task
    {
        return Task::findOrFail($id);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task->fresh();
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}