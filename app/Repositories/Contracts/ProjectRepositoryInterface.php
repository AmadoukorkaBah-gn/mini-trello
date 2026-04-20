<?php

namespace App\Repositories\Contracts;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    public function getAllForUser(int $userId): Collection;
    public function create(array $data): Project;
    public function findOrFail(int $id): Project;
    public function delete(Project $project): void;
}