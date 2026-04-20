@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Tâches du projet</h1>
        <a href="{{ route('projects.index') }}" class="text-blue-600 hover:underline text-sm">
            ← Retour aux projets
        </a>
    </div>

    {{-- Formulaire création tâche --}}
    <form method="POST" action="{{ route('tasks.store', $projectId) }}"
          class="bg-white rounded-xl shadow p-6 mb-8 grid grid-cols-3 gap-4">
        @csrf

        <input type="text" name="title" placeholder="Titre de la tâche" required
            class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">

        <input type="text" name="description" placeholder="Description"
            class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">

        <button type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded font-semibold hover:bg-blue-700 transition">
            + Ajouter une tâche
        </button>
    </form>

    {{-- Kanban Board --}}
    <div class="grid grid-cols-3 gap-6">

        @foreach(['TODO' => 'À faire', 'IN_PROGRESS' => 'En cours', 'DONE' => 'Terminé'] as $status => $label)

        <div class="bg-gray-50 rounded-xl p-4 min-h-64"
             data-status="{{ $status }}"
             ondrop="drop(event)"
             ondragover="allowDrop(event)">

            <h2 class="font-bold text-lg mb-4 text-gray-700">
                {{ $label }}
                <span class="text-sm font-normal text-gray-400">
                    ({{ $tasks->where('status', $status)->count() }})
                </span>
            </h2>

            @foreach($tasks->where('status', $status) as $task)

            <div class="bg-white rounded-lg shadow p-4 mb-3 cursor-grab"
                 draggable="true"
                 ondragstart="drag(event)"
                 data-task-id="{{ $task->id }}"
                 id="task-{{ $task->id }}">

                <p class="font-medium">{{ $task->title }}</p>

                @if($task->description)
                    <p class="text-gray-500 text-sm mt-1">{{ $task->description }}</p>
                @endif

                @if($task->assignee)
                    <p class="text-xs text-blue-500 mt-2">
                        👤 {{ $task->assignee->name }}
                    </p>
                @endif

                <div class="flex gap-2 mt-3">

                    <button
                        onclick="openEditModal(
                            {{ $task->id }},
                            '{{ addslashes($task->title) }}',
                            '{{ addslashes($task->description) }}',
                            '{{ $task->status }}'
                        )"
                        class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded hover:bg-yellow-200">
                        Modifier
                    </button>

                    <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
                        @csrf
                        @method('DELETE')

                        <button class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded hover:bg-red-200"
                            onclick="return confirm('Supprimer ?')">
                            Supprimer
                        </button>
                    </form>

                </div>
            </div>

            @endforeach

        </div>

        @endforeach
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="edit-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-md">

        <h2 class="text-xl font-bold mb-4">Modification d'une tache</h2>

        <form id="edit-form" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <input type="text" name="title" id="edit-title"
                class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">

            <input type="text" name="description" id="edit-description"
                class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">

            {{-- ✅ STATUS AJOUTÉ (IMPORTANT) --}}
            <select name="status" id="edit-status"
                class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">

                <option value="TODO">📋 À faire</option>
                <option value="IN_PROGRESS">⚙️ En cours</option>
                <option value="DONE">✅ Terminé</option>

            </select>

            <div class="flex gap-3 justify-end">

                <button type="button" onclick="closeEditModal()"
                    class="px-4 py-2 border rounded hover:bg-gray-100">
                    Annuler
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Enregistrer
                </button>

            </div>

        </form>

    </div>
</div>

{{-- JS --}}
<script>

// Drag & Drop
function allowDrop(event) {
    event.preventDefault();
}

function drag(event) {
    event.dataTransfer.setData(
        'taskId',
        event.target.closest('[data-task-id]').dataset.taskId
    );
}

function drop(event) {
    event.preventDefault();

    const taskId = event.dataTransfer.getData('taskId');
    const newStatus = event.currentTarget.dataset.status;
    const taskEl = document.getElementById('task-' + taskId);

    event.currentTarget.appendChild(taskEl);

    fetch(`/tasks/${taskId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ status: newStatus }),
    });
}

// Modal
function openEditModal(taskId, title, description, status) {

    document.getElementById('edit-title').value = title;
    document.getElementById('edit-description').value = description;

    // ✅ AJOUT IMPORTANT
    document.getElementById('edit-status').value = status;

    document.getElementById('edit-form').action = `/tasks/${taskId}`;
    document.getElementById('edit-modal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('edit-modal').classList.add('hidden');
}

</script>

@endsection