<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $roles = Role::when($query, function ($q) use ($query) {
            return $q->where('name', 'like', "%{$query}%");
        })->get();

        return view('admin.roles.index', compact('roles', 'query'));
    }

    public function create()
    {
        return view('admin.roles.create');
        //some test changes
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'role_name' => [
                'required',
                'unique:roles,role_name',
            ]
        ]);

        Role::create($validatedData);

        return redirect()->route('admin.roles.index')->with('success', 'Роль успішно створена');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validatedData = $request->validate([
            'role_name' => [
                'required',
                'unique:roles,role_name,'. $role->id,
            ],
        ]);

        $role->update($validatedData);

        return redirect()->route('admin.roles.index')->with('success', 'Роль успішно оновлена');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Роль успішно видалена');
    }
    public function filter(Request $request)
    {
        $query = $request->input('query');

        $roles = Role::when($query, function ($q) use ($query) {
            return $q->where('role_name', 'like', "%{$query}%");
        })->get();

        return response()->json(['roles' => $roles]);
    }


}
