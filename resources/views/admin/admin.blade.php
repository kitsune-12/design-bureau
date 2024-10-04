@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Адмін Панель</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-lg">Користувачі</a>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-lg">Оплата</a>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-success btn-lg">Ролі</a>
                    <a href="{{ route('admin.specializations.index') }}" class="btn btn-danger btn-lg">Спціалізація</a>
                    <a href="{{ route('admin.materials.index') }}" class="btn btn-warning btn-lg">Матеріали</a>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-info btn-lg">Проекти</a>
                </div>
            </div>
        </div>
    </div>
@endsection
