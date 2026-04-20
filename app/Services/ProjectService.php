<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Auth\Access\AuthorizationException;

class ProjectService
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository
    ) {}

    public function getProjectsForUser(int $userId): Collection
    {
        return $this->projectRepository->getAllForUser($userId);
    }

    public function createProject(array $data, int $userId): Project
    {
        return $this->projectRepository->create([...$data, 'user_id' => $userId]);
    }

    public function deleteProject(int $projectId, int $userId): void
    {
        $project = $this->projectRepository->findOrFail($projectId);

        if ($project->user_id !== $userId) {
            throw new AuthorizationException('Action non autorisée.');
        }

        $this->projectRepository->delete($project);
    }
}