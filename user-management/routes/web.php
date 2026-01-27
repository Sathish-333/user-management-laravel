<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserManagementController;


Route::get('/admin/users', [UserManagementController::class, 'index']);
Route::get('/admin/users/create', [UserManagementController::class, 'create']);
Route::post('/admin/users', [UserManagementController::class, 'store']);

Route::get('/admin/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');

Route::put('/admin/users/{user}', [UserManagementController::class, 'update'])->name('users.update');

Route::delete('/admin/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');