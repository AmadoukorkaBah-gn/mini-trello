@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl shadow p-8 mt-10">
    <h1 class="text-2xl font-bold mb-6 text-center">Connexion</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            @foreach($errors->all() as $error) <p>{{ $error }}</p> @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Mot de passe</label>
            <input type="password" name="password" required
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700 transition">
            Se connecter
        </button>
    </form>
    <p class="mt-4 text-center text-sm">
        Pas de compte ? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">S'inscrire</a>
    </p>
</div>
@endsection