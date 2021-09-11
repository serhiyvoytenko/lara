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

    Route::get('/editfield', [FileSystemController::class, 'editField'])->name('editfield');
    Route::post('/save', [FileSystemController::class, 'save'])->name('save');

});


//Route::middleware(['auth'])->get('/test', [\App\Http\Controllers\FileSystemController::class, 'listDirectory']);

require __DIR__ . '/auth.php';
