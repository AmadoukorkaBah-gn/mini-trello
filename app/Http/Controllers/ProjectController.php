<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Services\ProjectService;
use Illuminate\Auth\Access\AuthorizationException;

class ProjectController extends Controller
{
    public function __construct(private readonly ProjectService $projectService) {}

    public function index()
    {
        $projects = $this->projectService->getProjectsForUser(auth()->id());

        return view('projects.index', compact('projects'));
    }

    public function store(StoreProjectRequest $request)
    {
        $this->projectService->createProject($request->validated(), auth()->id());

        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès !');
    }

    public function destroy(int $id)
    {
        try {
            $this->projectService->deleteProject($id, auth()->id());
            return redirect()->route('projects.index')->with('success', 'Projet supprimé.');
        } catch (AuthorizationException $e) {
            return redirect()->route('projects.index')->with('error', $e->getMessage());
        }
    }
}