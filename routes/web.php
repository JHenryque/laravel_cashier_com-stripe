<?php

use App\Http\Controllers\MainController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    $users = User::all();
//    dd($users);
//});

Route::get('/login', [MainController::class, 'loginPage'])->name('login');
Route::get('/login/{id}', [MainController::class, 'loginSubmit'])->name('login.submit');
