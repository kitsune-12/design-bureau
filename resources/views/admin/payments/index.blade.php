@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1400px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Список платежів</h1>
            <a href="" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Повернутися на головну
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 d-flex align-items-end">
                <a href="{{ route('admin.payments.create') }}" class="btn btn-success" style="width: 260px;">
                    <i class="fas fa-plus"></i> Додати новий платіж
                </a>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <div class="input-group" style="width: 300px; margin-left: auto;">
                    <input type="text" class="form-control" id="search" placeholder="Пошук за статусом" value="{{ request('query') }}">
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
                    <th>Статус</th>
                    <th>Сума</th>
                    <th>Дата платежу</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody id="payments-table-body">
                @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->status }}</td>
                        <td>{{ $payment->amount }}</td>
                        <td>{{ $payment->payment_date }}</td>
                        <td>
                            <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Ви впевнені, що хочете видалити цей платіж?')">
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
            const tableBody = document.getElementById('payments-table-body');
            const noResults = document.getElementById('no-results');

            searchInput.addEventListener('input', () => fetchPayments(searchInput.value));

            function fetchPayments(query) {
                fetch(`{{ route('admin.payments.filter') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        updateTable(data.payments);
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            function updateTable(payments) {
                tableBody.innerHTML = '';
                if (payments.length === 0) {
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                    payments.forEach(payment => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${payment.id}</td>
                            <td>${payment.status}</td>
                            <td>${payment.amount}</td>
                            <td>${payment.payment_date}</td>
                            <td>
                                <a href="{{ url('admin/payments') }}/${payment.id}/edit" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ url('admin/payments') }}/${payment.id}" method="POST" style="display:inline;" onsubmit="return confirm('Ви впевнені, що хочете видалити цей платіж?')">
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
