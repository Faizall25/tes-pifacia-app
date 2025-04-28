<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Project\CommentController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Project\TaskController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password.update');

    Route::resource('projects', ProjectController::class);
    Route::post('/projects/{id}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
    Route::post('/projects/export', [ProjectController::class, 'export'])->name('projects.export');
    Route::post('/projects/import', [ProjectController::class, 'import'])->name('projects.import');

    Route::resource('tasks', TaskController::class);
    Route::post('/tasks/{id}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
    Route::post('/tasks/export', [TaskController::class, 'export'])->name('tasks.export');
    Route::post('/tasks/import', [TaskController::class, 'import'])->name('tasks.import');

    Route::resource('comments', CommentController::class);
    Route::post('/comments/{id}/restore', [CommentController::class, 'restore'])->name('comments.restore');
    Route::post('/comments/export', [CommentController::class, 'export'])->name('comments.export');
    Route::post('/comments/import', [CommentController::class, 'import'])->name('comments.import');

    Route::resource('roles', RoleController::class)->only(['index', 'show']);
    Route::middleware(['role:Administrator'])->group(function () {
        Route::resource('roles', RoleController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::post('/roles/{id}/restore', [RoleController::class, 'restore'])->name('roles.restore');
        Route::post('/roles/export', [RoleController::class, 'export'])->name('roles.export');
        Route::post('/roles/import', [RoleController::class, 'import'])->name('roles.import');

        Route::resource('users', UserController::class);
        Route::post('/users/export', [UserController::class, 'export'])->name('users.export');
        Route::post('/users/import', [UserController::class, 'import'])->name('users.import');
    });
});
