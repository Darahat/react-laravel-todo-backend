<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\TodoResource;

use App\Models\Todo;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/todos', function () {
    return TodoResource::collection(Todo::all());
});
Route::get('/todo/{id}', function ($id) {
    return new TodoResource(Todo::findOrFail($id));
});
Route::put('/todo/{id}', [TodoController::class, 'update'])->name('todo.update');
Route::delete('/todo/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');
Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});