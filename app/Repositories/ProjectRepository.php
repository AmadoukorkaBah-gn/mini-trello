<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAllForUser(int $userId): Collection
    {
        return Project::where('user_id', $userId)->latest()->get();
    }

    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function findOrFail(int $id): Project
    {
        return Project::findOrFail($id);
    }

    public function delete(Project $project): void
    {
        $project->delete();
    }
}