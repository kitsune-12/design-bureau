@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1400px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Список користувачів</h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Додати нового користувача
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 d-flex align-items-end">
                <div class="input-group" style="width: 300px; margin-left: auto;">
                    <input type="text" class="form-control" id="search" placeholder="Пошук за іменем або прізвищем" value="{{ request('query') }}">
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
                    <th>Ім'я</th>
                    <th>Прізвище</th>
                    <th>Побатькові</th>
                    <th>Роль</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody id="users-table-body">
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->patronymic }}</td>
                        <td>{{ $user->role->role_name ?? 'Невідомо' }}</td> <!-- Відображаємо роль -->
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Ви впевнені, що хочете видалити цього користувача?')">
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
            const tableBody = document.getElementById('users-table-body');
            const noResults = document.getElementById('no-results');

            searchInput.addEventListener('input', () => fetchUsers(searchInput.value));

            function fetchUsers(query) {
                fetch(`{{ route('admin.users.filter') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        updateTable(data.users);
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            function updateTable(users) {
                tableBody.innerHTML = '';
                if (users.length === 0) {
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                    users.forEach(user => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${user.id}</td>
                            <td>${user.first_name}</td>
                            <td>${user.last_name}</td>
                            <td>${user.role ? user.role.name : 'Невідомо'}</td>
                            <td>
                                <a href="{{ url('admin/users') }}/${user.id}/edit" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ url('admin/users') }}/${user.id}" method="POST" style="display:inline;" onsubmit="return confirm('Ви впевнені, що хочете видалити цього користувача?')">
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
