<?php

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminProjectController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('page.home');
});

Route::get('/about', function () {
    return view('page.about');
});

Route::get('/profile', [MahasiswaController::class, 'index']);
Route::get('/project', [ProjectController::class, 'index'])->name('project.index');
Route::get('/project/{id}', [ProjectController::class, 'show'])->name('project.show');

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminProjectController::class, 'index'])->name('admin.home');
    Route::get('/projects', [AdminProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('/projects/create', [AdminProjectController::class, 'create'])->name('admin.projects.create');
    Route::post('/projects', [AdminProjectController::class, 'store'])->name('admin.projects.store');
    Route::get('/projects/{project}/edit', [AdminProjectController::class, 'edit'])->name('admin.projects.edit');
    Route::put('/projects/{project}', [AdminProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('/projects/{project}', [AdminProjectController::class, 'destroy'])->name('admin.projects.destroy');
});
