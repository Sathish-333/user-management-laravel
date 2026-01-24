<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;



Route::get('/users/{user_id}', [UserController::class, 'show']);
