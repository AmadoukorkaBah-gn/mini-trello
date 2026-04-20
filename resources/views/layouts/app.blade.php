<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Trello</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center shadow">
        <a href="{{ route('projects.index') }}" class="text-xl font-bold">🗂️ Mini Trello</a>
        @auth
        <div class="flex items-center gap-4">
            <span class="text-sm">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-white text-blue-600 px-3 py-1 rounded text-sm font-medium">
                    Déconnexion
                </button>
            </form>
        </div>
        @endauth
    </nav>

    <main class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>