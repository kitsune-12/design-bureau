@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Додати новий проєкт</h1>

        <form action="{{ route('admin.projects.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Назва проєкту</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Опис проєкту</label>
                <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="cost">Вартість</label>
                <input type="number" step="0.01" class="form-control" id="cost" name="cost" value="{{ old('cost') }}" required>
                @error('cost')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="start_date">Дата початку</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                @error('start_date')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_date">Дата завершення</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
                @error('end_date')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="client_id">Клієнт</label>
                <select class="form-control" id="client_id" name="client_id" required>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->surname }} {{ $client->first_name }}</option>
                    @endforeach
                </select>
                @error('client_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="designer_id">Дизайнер</label>
                <select class="form-control" id="designer_id" name="designer_id" required>
                    @foreach($designers as $designer)
                        <option value="{{ $designer->id }}">{{ $designer->surname }} {{ $designer->first_name }}</option>
                    @endforeach
                </select>
                @error('designer_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div id="materials-container">
                <div class="form-group material-select">
                    <label for="materials-select">Матеріали</label>
                    <select class="form-control materials-select" name="materials[0][id]">
                        <option value="">Оберіть матеріал</option>
                        @foreach($materials as $material)
                            <option value="{{ $material->id }}" data-stock="{{ $material->stock_availability }}">
                                {{ $material->name }} (Залишок: {{ $material->stock_availability }})
                            </option>
                        @endforeach
                    </select>
                    <input type="number" name="materials[0][quantity]" class="form-control quantity" placeholder="Кількість" required>
                    <small>Макс доступно: <span class="max-stock"></span></small>
                </div>
            </div>

            <button type="button" id="add-material" class="btn btn-secondary">Додати матеріал</button>
            <button type="submit" class="btn btn-success">Зберегти</button>
        </form>

        <script>
            let materialCount = 1;

            document.getElementById('add-material').addEventListener('click', function () {
                const materialsContainer = document.getElementById('materials-container');

                const newMaterialDiv = document.createElement('div');
                newMaterialDiv.classList.add('form-group', 'material-select');

                newMaterialDiv.innerHTML = `
            <label for="materials-select">Матеріали</label>
            <select class="form-control materials-select" name="materials[${materialCount}][id]">
                <option value="">Оберіть матеріал</option>
                @foreach($materials as $material)
                <option value="{{ $material->id }}" data-stock="{{ $material->stock_availability }}">
                        {{ $material->name }} (Залишок: {{ $material->stock_availability }})
                    </option>
                @endforeach
                </select>
                <input type="number" name="materials[${materialCount}][quantity]" class="form-control quantity" placeholder="Кількість" required>
            <small>Макс доступно: <span class="max-stock"></span></small>
        `;

                materialsContainer.appendChild(newMaterialDiv);
                materialCount++;
            });

            document.getElementById('materials-container').addEventListener('change', function (event) {
                if (event.target.classList.contains('materials-select')) {
                    const selectedOption = event.target.options[event.target.selectedIndex];
                    const stock = selectedOption.getAttribute('data-stock');
                    const maxStockSpan = event.target.closest('.material-select').querySelector('.max-stock');
                    maxStockSpan.textContent = stock;
                }
            });
        </script>

@endsection
