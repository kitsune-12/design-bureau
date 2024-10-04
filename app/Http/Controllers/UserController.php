<?php

namespace App\Http\Controllers;

use App\Models\Designer;
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
        $roles = Role::all(); // Отримуємо всі ролі
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'patronymic' => 'required',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id', // Перевіряємо, що роль існує
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']); // Хешуємо пароль

        User::create($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'Користувача успішно створено');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // Отримуємо всі ролі
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'patronymic' => 'required',
            'role_id' => 'required|exists:roles,id', // Перевіряємо, що роль існує
            'password' => 'nullable|min:6', // Пароль не є обов'язковим для оновлення
        ]);

        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']); // Хешуємо новий пароль
        } else {
            unset($validatedData['password']); // Вилучаємо пароль, якщо він не заповнений
        }

        $user->update($validatedData);

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
