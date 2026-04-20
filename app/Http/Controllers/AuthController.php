<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $this->authService->register($request->validated());

        return redirect()->route('login')->with('success', 'Compte créé ! Connectez-vous.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

   public function login(LoginRequest $request)
{
    $user = $this->authService->login($request->only('email', 'password'));

    if (!$user) {
        return back()->withErrors([
            'email' => 'Identifiants incorrects'
        ]);
    }

    return redirect()->route('projects.index');
}

    public function logout()
    {
        $this->authService->logout();

        return redirect()->route('login');
    }
}