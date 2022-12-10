<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Livewire\Backend\ModuleList;
use App\Http\Livewire\Backend\PermissionList;
use App\Http\Livewire\Backend\RoleList;
use App\Http\Livewire\Backend\User;

Route::get('/dashboard', DashboardController::class)->name('dashboard');
Route::get('/access/users', User::class)->name('access/users');
Route::get('/dev/modules', ModuleList::class)->name('dev/modules');
Route::get('/dev/permissions', PermissionList::class)->name('dev/permissions');
Route::get('/dev/roles', RoleList::class)->name('dev/roles');