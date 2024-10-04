@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редагувати платіж</h1>

        <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="status">Статус</label>
                <input type="text" class="form-control" id="status" name="status" value="{{ old('status', $payment->status) }}" required>
                @error('status')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="amount">Сума</label>
                <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount', $payment->amount) }}" required>
                @error('amount')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="payment_date">Дата платежу</label>
                <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}" required>
                @error('payment_date')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="project_id">Проект</label>
                <select class="form-control" id="project_id" name="project_id" required>
                    <option value="">Оберіть проект</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" {{ $payment->project_id == $project->id ? 'selected' : '' }}>
                            {{ $project->title }}
                        </option>
                    @endforeach
                </select>
                @error('project_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Оновити</button>
        </form>
    </div>
@endsection
