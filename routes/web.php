<?php

use App\Http\Controllers\TodoController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('todos',TodoController::class)->middleware(['auth']);

Route::get('undone', [TodoController::class, 'undone'])->name('todos.undone')->middleware(['auth']);
Route::get('done', [TodoController::class, 'done'])->name('todos.done')->middleware(['auth']);

Route::put('makedone/{todo}', [TodoController::class, 'makedone'])->name('makedone')->middleware(['auth']);
Route::put('makeundone/{todo}', [TodoController::class, 'makeundone'])->name('makeundone')->middleware(['auth']);

Route::get('/{todo}/affectedTo/{user}',[TodoController::class, 'affectedTo'])->name('affectedTo')->middleware(['auth']);


require __DIR__.'/auth.php';
Route::get('/index', function () {
    return view('index');
});
