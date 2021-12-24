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

Route::get('/peserta', function () {
    return view('peserta');
});

Route::get('/narasumber', function () {
    return view('narasumber');
});

Route::get('/narasumber-token-detail', function () {
    return view('narasumber-token-detail');
});

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/admin-narasumber', function () {
    return view('admin-narasumber');
});

Route::get('/admin-peserta', function () {
    return view('admin-peserta');
});

Route::get('/admin-kelompok', function () {
    return view('admin-kelompok');
});

Route::get('/admin-detail-kelompok', function () {
    return view('admin-detail-kelompok');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
