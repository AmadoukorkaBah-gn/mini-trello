<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository
    ) {}

    public function getTasksForProject(int $projectId): Collection
    {
        return $this->taskRepository->getAllForProject($projectId);
    }

    public function createTask(array $data): Task
    {
        return $this->taskRepository->create($data);
    }

    public function updateTask(int $taskId, array $data): Task
    {
        $task = $this->taskRepository->findOrFail($taskId);
        return $this->taskRepository->update($task, $data);
    }

    public function deleteTask(int $taskId): void
    {
        $task = $this->taskRepository->findOrFail($taskId);
        $this->taskRepository->delete($task);
    }

    public function assignTask(int $taskId, int $userId): Task
    {
        $task = $this->taskRepository->findOrFail($taskId);
        return $this->taskRepository->update($task, ['assigned_to' => $userId]);
    }

    public function changeStatus(int $taskId, string $status): Task
    {
        $task = $this->taskRepository->findOrFail($taskId);
        return $this->taskRepository->update($task, ['status' => $status]);
    }
}