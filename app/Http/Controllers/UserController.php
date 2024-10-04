<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use App\Models\Specialization;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $users = User::when($query, function ($q) use ($query) {
            return $q->where('first_name', 'like', "%{$query}%")
                ->orWhere('last_name', 'like', "%{$query}%");
        })->get();

        return view('admin.users.index', compact('users', 'query'));
    }

    public function create()
    {
        $roles = Role::all();
        $specializations = Specialization::all();
        return view('admin.users.create', compact('roles', 'specializations'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'patronymic' => 'required',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
            'specialization_id' => 'nullable|exists:specializations,id',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);
        if($validatedData['role_id'] == Role::where('role_name', 'designer')->first()->id){
            $validatedData['specialization_id'] = $request->specialization_id;
            Designer::create($validatedData);
            $test = new Designer();
        }
        else {
            User::create($validatedData);
        }
        return redirect()->route('admin.users.index')->with('success', 'Користувача успішно створено');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $specializations = Specialization::all();
        return view('admin.users.edit', compact('user', 'roles', 'specializations'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'patronymic' => 'required',
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|min:6',
            'specialization_id' => 'nullable|exists:specializations,id',
        ]);
        $user =  User::findOrFail($id);
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);
        if($validatedData['role_id'] == Role::where('role_name', 'designer')->first()->id){
            $user = Designer::findOrFail($id);
            $user->update($validatedData);
        }

        return redirect()->route('admin.users.index')->with('success', 'Користувача успішно оновлено');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Користувача успішно видалено');
    }

    public function filter(Request $request)
    {
        $query = $request->input('query');

        $users = User::when($query, function ($q) use ($query) {
            return $q->where('first_name', 'like', "%{$query}%")
                ->orWhere('last_name', 'like', "%{$query}%");
        })->get();

        return response()->json(['users' => $users]);
    }
}
