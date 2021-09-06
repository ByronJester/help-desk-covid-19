<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;

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
    // return view('app');
    return redirect()->route('view.home');
});


Route::prefix('home')->group(function () {
    Route::get('/', [HomeController::class, 'homeView'])->name('view.home');
    Route::post('/save-post', [HomeController::class, 'savePost']);
    Route::post('/delete-post', [HomeController::class, 'deletePost']);
    
});

Route::prefix('reports')->group(function () {
	Route::post('/save-incident', [ReportController::class, 'savePlaceIncident'])->middleware('auth');
    Route::get('/', [ReportController::class, 'reportView'])->name('view.report');
    Route::get('/view/{id}', [ReportController::class, 'viewPlace'])->name('view.place.incident'); 
});

Route::prefix('users')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/saveUser', [UserController::class, 'saveUser']);
    Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
    Route::get('/', [UserController::class, 'usersView'])->middleware('auth')->name('view.users');
    Route::get('/{id}', [UserController::class, 'updateUser'])->middleware('auth');
});
