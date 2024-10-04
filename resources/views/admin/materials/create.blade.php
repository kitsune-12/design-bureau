@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Додати нову роль</h1>

        <form action="{{ route('admin.materials.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Назва матеріалу</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Тип матеріалу</label>
                <input type="text" class="form-control" id="type" name="type" value="{{ old('type') }}" required>
                @error('type')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Опис матеріалу</label>
                <textarea class="form-control" id="description" name="description" ></textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="stock_availability">Кількість матеріалу в наявності</label>
                <input type="number" class="form-control" id="stock_availability" name="stock_availability" value="{{ old('stock_availability') }}" required>
                @error('stock_availability')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Зберегти</button>
        </form>
    </div>
@endsection
