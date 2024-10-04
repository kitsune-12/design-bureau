@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редагувати користувача</h1>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="first_name">Ім'я</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                @error('first_name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="last_name">Прізвище</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                @error('last_name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="patronymic">По батькові</label>
                <input type="text" class="form-control" id="patronymic" name="patronymic" value="{{ old('patronymic', $user->patronymic) }}" required>
                @error('patronymic')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Пароль (залиште порожнім, якщо не хочете змінювати)</label>
                <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="role_id">Роль</label>
                <select class="form-control" id="role_id" name="role_id" required>
                    <option value="">Виберіть роль</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                            {{ $role->role_name }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Зберегти</button>
        </form>
    </div>
@endsection
