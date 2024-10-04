@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редагувати роль</h1>

        <form action="{{ route('admin.materials.update', $material->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Назва матеріалу</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $material->name) }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="type">Тип матеріалу</label>
                <input type="text" class="form-control" id="type" name="type" value="{{ old('type', $material->type) }}" required>
                @error('type')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Опис матеріалу</label>
                <textarea class="form-control" id="description" name="description" >{{old('description', $material->description)}}</textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="stock_availability">Кількість матеріалу в наявності</label>
                <input type="text" class="form-control" id="stock_availability" name="stock_availability" value="{{ old('stock_availability', $material->stock_availability) }}" required>
                @error('stock_availability')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-warning">Оновити</button>
        </form>
    </div>
@endsection
