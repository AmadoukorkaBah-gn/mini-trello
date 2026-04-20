<?php

namespace App\Repositories\Contracts;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function getAllForProject(int $projectId): Collection;
    public function create(array $data): Task;
    public function findOrFail(int $id): Task;
    public function update(Task $task, array $data): Task;
    public function delete(Task $task): void;
}