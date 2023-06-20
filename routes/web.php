<?php

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

Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::view('/home', 'home'); //ビュールート

Route::get('/list', [App\Http\Controllers\ProductController::class, 'showList'])->name('list.search');
Route::get('/regist', [App\Http\Controllers\CompanyController::class, 'showRegistForm'])->name('regist');
Route::post('/regist', [App\Http\Controllers\ProductController::class, 'registSubmit'])->name('regist.submit');
Route::get('/detail/{id}', [App\Http\Controllers\ProductController::class, 'showDetail'])->name('detail');
Route::post('/remove{id}', [App\Http\Controllers\ProductController::class, 'removeList'])->name('list.remove');
Route::get('/edit/{id}', [App\Http\Controllers\ProductController::class, 'detailEdit'])->name('edit');
