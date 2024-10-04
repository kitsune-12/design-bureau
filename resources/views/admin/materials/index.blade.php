@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1400px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Список маеріалів</h1>
            <a href="" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Повернутися на головну
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 d-flex align-items-end">
                <a href="{{ route('admin.materials.create') }}" class="btn btn-success" style="width: 260px; white-space: nowrap;">
                    <i class="fas fa-plus"></i> Додати новий матеріал
                </a>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <div class="input-group" style="width: 300px; margin-left: auto;">
                    <input type="text" class="form-control" id="search" placeholder="Пошук за назвою" value="{{ request('query') }}">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>

        </div>

        <div class="table-responsive" style="max-height: 605px; overflow-y: auto;">
            <table class="table table-bordered" style="background-color: #ffffff;">
                <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Назва матеріалу</th>
                    <th>Тип</th>
                    <th>Кількість в наявності</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody id="materials-table-body">
                @foreach ($materials as $material)
                    <tr>
                        <td>{{ $material->id }}</td>
                        <td>{{ $material->name }}</td>
                        <td>{{ $material->type }}</td>
                        <td>{{ $material->stock_availability }}</td>
                        <td>
                            <a href="{{ route('admin.materials.edit', $material->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.materials.destroy', $material->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Ви впевнені, що хочете видалити цю роль?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div id="no-results" style="display: none;">Не знайдено результатів.</div>
        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            const tableBody = document.getElementById('materials-table-body');
            const noResults = document.getElementById('no-results');

            searchInput.addEventListener('input', () => fetchmaterials(searchInput.value));

            function fetchmaterials(query) {
                fetch(`{{ route('admin.materials.filter') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        updateTable(data.materials);
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            function updateTable(materials) {
                tableBody.innerHTML = '';
                if (materials.length === 0) {
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                    materials.forEach(material => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${material.id}</td>
                        <td>${material.name}</td>
                        <td>
                            <a href="{{ url('admin/materials') }}/${material.id}/edit" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ url('admin/materials') }}/${material.id}" method="POST" style="display:inline;" onsubmit="return confirm('Ви впевнені, що хочете видалити цю роль?')">
                                @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
`;
                        tableBody.appendChild(row);
                    });
                }
            }
        });
    </script>



@endsection
