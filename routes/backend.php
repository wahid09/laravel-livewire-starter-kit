<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Livewire\Backend\User;

Route::get('/dashboard', DashboardController::class)->name('dashboard');
Route::get('/users', User::class)->name('users');