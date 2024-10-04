@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Список проєктів</h1>

        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary mb-3">Додати новий проєкт</a>

        @if($projects->count() > 0)
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Назва</th>
                    <th>Опис</th>
                    <th>Вартість</th>
                    <th>Дата початку</th>
                    <th>Дата завершення</th>
                    <th>Клієнт</th>
                    <th>Дизайнер</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->description }}</td>
                        <td>{{ $project->cost }}</td>
                        <td>{{ $project->start_date->format('Y-m-d') }}</td>
                        <td>{{ $project->end_date ? $project->end_date->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $project->client->surname }} {{ $project->client->first_name }}</td>
                        <td>{{ $project->designer->surname }} {{ $project->designer->first_name }}</td>
                        <td>
                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-warning">Редагувати</a>
                            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Ви впевнені, що хочете видалити проєкт?')">Видалити</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Поки що немає жодного проєкту.</p>
        @endif
    </div>
@endsection
