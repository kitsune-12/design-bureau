@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Додати нову роль</h1>

        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="role_name">Назва ролі</label>
                <input type="text" class="form-control" id="role_name" name="role_name" value="{{ old('role_name') }}" required>
                @error('role_name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Зберегти</button>
        </form>
    </div>
@endsection
