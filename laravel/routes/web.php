<?php

use App\Http\Controllers\FileSystemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function (){

    Route::get('/dashboard', [FileSystemController::class, 'listDirectory'])->name('dashboard');
    Route::view('/test', 'test');
    Route::get('/editfield', [FileSystemController::class, 'editField'])->name('editfield');
    Route::get('/download', [FileSystemController::class, 'download'])->name('download');
    Route::get('/delete', [FileSystemController::class, 'delete'])->name('delete');
    Route::post('/save', [FileSystemController::class, 'save'])->name('save');
    Route::any('/upload', [FileSystemController::class, 'upload'])->name('upload');
    Route::any('/create', [FileSystemController::class, 'create'])->name('create');

});

require __DIR__ . '/auth.php';
