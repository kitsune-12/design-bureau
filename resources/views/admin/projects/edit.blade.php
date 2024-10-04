@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редагувати проєкт: {{ $project->name }}</h1>

        <form action="{{ route('admin.projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Назва проєкту</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $project->name) }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Опис проєкту</label>
                <textarea class="form-control" id="description" name="description">{{ old('description', $project->description) }}</textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="cost">Вартість</label>
                <input type="number" step="0.01" class="form-control" id="cost" name="cost" value="{{ old('cost', $project->cost) }}" required>
                @error('cost')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="start_date">Дата початку</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $project->start_date->format('Y-m-d')) }}" required>
                @error('start_date')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_date">Дата завершення</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $project->end_date ? $project->end_date->format('Y-m-d') : '') }}">
                @error('end_date')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="client_id">Клієнт</label>
                <select class="form-control" id="client_id" name="client_id" required>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ $project->client_id == $client->id ? 'selected' : '' }}>
                            {{ $client->surname }} {{ $client->first_name }}
                        </option>
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
                        <option value="{{ $designer->id }}" {{ $project->designer_id == $designer->id ? 'selected' : '' }}>
                            {{ $designer->last_name }} {{ $designer->first_name }}
                        </option>
                    @endforeach
                </select>
                @error('designer_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="materials">Матеріали</label>
                <div id="materials-container">
                    @foreach($project->materials as $index => $material)
                        <div class="material-item">
                            <select class="form-control material-select" name="materials[{{ $index }}][id]" required>
                                <option value="">Оберіть матеріал</option>
                                @foreach($materials as $m)
                                    <option value="{{ $m->id }}" {{ $m->id == $material->id ? 'selected' : '' }}>
                                        {{ $m->name }} (Залишок: {{ $m->stock_availability }})
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" name="materials[{{ $index }}][quantity]" placeholder="Кількість" class="form-control material-quantity" min="1" max="{{ $material->stock_availability }}" value="{{ old('materials.' . $index . '.quantity', $material->pivot->quantity) }}" required>
                            <button type="button" class="btn btn-danger remove-material">Видалити</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-secondary mt-2" id="add-material">Додати матеріал</button>
            </div>

            <script>
                const materialsContainer = document.getElementById('materials-container');
                const addMaterialButton = document.getElementById('add-material');
                let materialCount = {{ $project->materials->count() }};

                addMaterialButton.addEventListener('click', function () {
                    const newMaterialItem = document.createElement('div');
                    newMaterialItem.classList.add('material-item');
                    newMaterialItem.innerHTML = `
                        <select class="form-control material-select" name="materials[${materialCount}][id]" required>
                            <option value="">Оберіть матеріал</option>
                            @foreach($materials as $material)
                    <option value="{{ $material->id }}">{{ $material->name }} (Залишок: {{ $material->stock_availability }})</option>
                            @endforeach
                    </select>
                    <input type="number" name="materials[${materialCount}][quantity]" placeholder="Кількість" class="form-control material-quantity" min="1" max="" required>
                        <button type="button" class="btn btn-danger remove-material">Видалити</button>
                    `;
                    materialsContainer.appendChild(newMaterialItem);
                    materialCount++;
                });

                materialsContainer.addEventListener('click', function (event) {
                    if (event.target.classList.contains('remove-material')) {
                        event.target.closest('.material-item').remove();
                    }
                });

                materialsContainer.addEventListener('change', function (event) {
                    if (event.target.classList.contains('material-select')) {
                        const selectedOption = event.target.selectedOptions[0];
                        const quantityInput = event.target.nextElementSibling;
                        const maxQuantity = selectedOption.text.match(/\(Залишок: (\d+)\)/)[1];

                        if (selectedOption.value) {
                            quantityInput.style.display = 'block';
                            quantityInput.setAttribute('max', maxQuantity);
                        } else {
                            quantityInput.style.display = 'none';
                        }
                    }
                });
            </script>

            <button type="submit" class="btn btn-success">Оновити</button>
        </form>
    </div>
@endsection
