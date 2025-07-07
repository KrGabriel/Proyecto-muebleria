<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersAdminController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('usersAdmin.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);
        User::create($validated);

        return redirect()->route('usersAdmin.index')->with('success', 'Usuario creado correctamente.');
    }

    public function destroy(User $usersAdmin)
    {
        if(auth()->user()->id === $usersAdmin->id) {
            return redirect()->route('usersAdmin.index')->with('error', 'No puedes eliminarte a ti mismo.');
        }
        $usersAdmin->delete();
        return redirect()->route('usersAdmin.index')->with('success', 'Usuario eliminado correctamente.');
    }
}