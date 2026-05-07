<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('utilisateurs')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string|max:50|unique:roles,nom',
            'description' => 'nullable|string',
        ]);

        Role::create($request->only(['nom', 'description']));

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle créé avec succès !');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'nom'         => 'required|string|max:50|unique:roles,nom,' . $id,
            'description' => 'nullable|string',
        ]);

        $role->update($request->only(['nom', 'description']));

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle modifié avec succès !');
    }
}