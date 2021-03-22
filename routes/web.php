<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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

// $tema = 'theme2';

// if($tema == 'theme1') {
//     Route::get('/', function () {
//         return View::first(['theme1.index', 'theme1']);
//     });
// }

// if($tema == 'theme2') {
//     Route::get('/', function () {
//         return View::first(['theme2.index', 'theme2']);
//     });
// }
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
