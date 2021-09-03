<?php

use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;

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

Route::get('/dashboard', [\App\Http\Controllers\FileSystemController::class, 'listDirectory'])->middleware(['auth'])->name('dashboard');

//Route::middleware(['auth'])->get('/test', [\App\Http\Controllers\FileSystemController::class, 'listDirectory']);

require __DIR__ . '/auth.php';

Route::group(['prefix' => '/laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});
