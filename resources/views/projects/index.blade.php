@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Mes Projets</h1>
    </div>

    {{-- Formulaire création projet --}}
    <form method="POST" action="{{ route('projects.store') }}"
          class="bg-white rounded-xl shadow p-6 mb-8 flex gap-4">
        @csrf
        <input type="text" name="name" placeholder="Nom du projet" required
            class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <input type="text" name="description" placeholder="Description (optionnel)"
            class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded font-semibold hover:bg-blue-700 transition">
            + Créer
        </button>
    </form>

    {{-- Liste des projets --}}
    @forelse($projects as $project)
    <div class="bg-white rounded-xl shadow p-5 mb-4 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-semibold">{{ $project->name }}</h2>
            @if($project->description)
                <p class="text-gray-500 text-sm">{{ $project->description }}</p>
            @endif
            <p class="text-xs text-gray-400 mt-1">{{ $project->tasks()->count() }} tâche(s)</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('tasks.index', $project->id) }}"
               class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition text-sm">
                Voir les tâches
            </a>
            <form method="POST" action="{{ route('projects.destroy', $project->id) }}">
                @csrf @method('DELETE')
                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition text-sm"
                    onclick="return confirm('Supprimer ce projet ?')">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
    @empty
        <p class="text-center text-gray-400 mt-10">Aucun projet pour l'instant. Créez-en un !</p>
    @endforelse
</div>
@endsection