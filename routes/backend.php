<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Livewire\Backend\Module\ModuleList;
use App\Http\Livewire\Backend\Permission\PermissionList;
use App\Http\Livewire\Backend\Role\RoleList;
use App\Http\Livewire\Backend\User\User;
use App\Http\Livewire\Backend\User\AddUser;
use App\Http\Livewire\Backend\User\EditUserComponent;
use App\Http\Livewire\Backend\Module\ModuleCreateComponent;
use App\Http\Livewire\Backend\Rank\RankListComponent;
use App\Http\Livewire\Backend\Role\RoleCreateComponent;
use App\Http\Livewire\Backend\Role\RoleUpdateComponent;
use App\Http\Livewire\AccessControl\LoginRecord\LoginRecordList;
use App\Http\Livewire\AccessControl\AccessLog\AccessLogList;
use App\Http\Livewire\Backend\User\UserProfileUpdate;
use App\Http\Controllers\ImportData\ImportDataController;


Route::get('/dashboard', DashboardController::class)->name('dashboard');

//Permission
Route::get('/dev-console/permissions', PermissionList::class)->name('dev-console/permissions');

//Role
Route::get('/dev-console/roles', RoleList::class)->name('dev-console/roles');
Route::get('/dev-console/roles/create', RoleCreateComponent::class)->name('role.create');
Route::get('/dev-console/roles/{role}/edit', RoleUpdateComponent::class)->name('role.update');

//Module
Route::get('/dev-console/modules', ModuleList::class)->name('dev-console/modules');
Route::get('dev-console/module/create', ModuleCreateComponent::class)->name('module.create');
//User
Route::get('/access-control/users', User::class)->name('access-control/users');
Route::get('/access-control/user/create', AddUser::class)->name('user.create');
Route::get('access-control/user/{user}/edit', EditUserComponent::class)->name('user.edit');
Route::get('access-control/user/profile/{user}/edit', UserProfileUpdate::class)->name('profile.update');

//Login Record
Route::get('access-control/login-records', LoginRecordList::class)->name('access-control/login-records');

// Access Log
Route::get('access-control/access-logs', AccessLogList::class)->name('access-control/access-logs');
//Application setup
Route::get('application-setup/ranks', RankListComponent::class)->name('application-setup/ranks');
Route::get('dev-console/data-imports', [ImportDataController::class, 'index'])->name('dev-console/data-imports');
Route::post('dev-console/data-uploads', [ImportDataController::class, 'upload'])->name('data.upload');