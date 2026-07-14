<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(): Response 
    {
        $users = User::select('id', 'name', 'email', 'is_active')
                      ->latest()
                      ->paginate(5);

        return Inertia::render('Users/index', [
            'users' => $users 
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()->route('users.index')
                         ->with('success', 'Usuario creado con exito.');
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return redirect()->route('users.index')
                         ->with('success', 'Usuario actualizado con exito.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'Usuario eliminado con exito.');
    }
}
