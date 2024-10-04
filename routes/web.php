<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    //Users
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/users/search', [UserController::class, 'search'])->name('admin.users.search');
    Route::get('/users/filter', [UserController::class, 'filter'])->name('admin.users.filter');

    //Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
    Route::get('/roles/filter', [RoleController::class, 'filter'])->name('admin.roles.filter');

    //Specializations
    Route::get('/specializations', [SpecializationController::class, 'index'])->name('admin.specializations.index');
    Route::get('/specializations/create', [SpecializationController::class, 'create'])->name('admin.specializations.create');
    Route::post('/specializations', [SpecializationController::class, 'store'])->name('admin.specializations.store');
    Route::get('/specializations/{specialization}/edit', [SpecializationController::class, 'edit'])->name('admin.specializations.edit');
    Route::put('/specializations/{specialization}', [SpecializationController::class, 'update'])->name('admin.specializations.update');
    Route::delete('/specializations/{specialization}', [SpecializationController::class, 'destroy'])->name('admin.specializations.destroy');
    Route::get('/specializations/filter', [SpecializationController::class, 'filter'])->name('admin.specializations.filter');

    // admin
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin');

});
