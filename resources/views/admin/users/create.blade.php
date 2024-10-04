@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Додати нового користувача</h1>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="first_name">Ім'я</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                @error('first_name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="last_name">Прізвище</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                @error('last_name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="patronymic">По батькові</label>
                <input type="text" class="form-control" id="patronymic" name="patronymic" value="{{ old('patronymic') }}" required>
                @error('patronymic')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" required>
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="role_id">Роль</label>
                <select class="form-control" id="role_id" name="role_id" required>
                    <option value="">Виберіть роль</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                    @endforeach
                </select>
                @error('role_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{--<div class="form-group">
                <label for="role">Роль</label>
                <select id="role_id" name="role_id" class="form-control" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                    @endforeach
                </select>
            </div>--}}

            <div id="specialization-section" class="form-group" style="display: none;">
                <label for="specialization_id">Спеціалізація</label>
                <select id="specialization_id" name="specialization_id" class="form-control">
                    <option value="">Виберіть спеціалізацію</option>
                    @foreach ($specializations as $specialization)
                        <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Зберегти</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role_id');
            const specializationSection = document.getElementById('specialization-section');

            function toggleSpecializationField() {
                if (roleSelect.options[roleSelect.selectedIndex].text.toLowerCase() === 'designer') {
                    specializationSection.style.display = 'block';
                } else {
                    specializationSection.style.display = 'none';
                }
            }

            roleSelect.addEventListener('change', toggleSpecializationField);
            toggleSpecializationField();
        });
    </script>
@endsection
