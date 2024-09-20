<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('task', [TaskController::class, 'index'])->name('task.index');
    Route::get('create', [TaskController::class, 'create'])->name('task.create');
    Route::post('store', [TaskController::class, 'store'])->name('task.store');
    Route::get('edit/{task}', [TaskController::class, 'edit'])->name('task.edit');
    Route::patch('update/{task}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('destroy/{task}', [TaskController::class, 'destroy'])->name('task.destroy');
    Route::patch('tasks/{task}/complete', [TaskController::class, 'complete'])->name('task.complete');

});



require __DIR__.'/auth.php';
