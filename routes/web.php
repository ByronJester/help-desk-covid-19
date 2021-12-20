<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VirusCaseController;
use App\Http\Controllers\VaccinationController;
use App\Http\Controllers\ContactTracingController;
use App\Http\Controllers\BackupController;

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

Route::prefix('news')->group(function () {
    Route::get('/', [HomeController::class, 'newsView'])->name('view.news');
    Route::post('/save-post', [HomeController::class, 'savePost']);
    Route::post('/delete-post', [HomeController::class, 'deletePost']);
});

Route::prefix('reports')->group(function () {
    // Route::get('/', [ReportController::class, 'reportView'])->name('view.report');
    // Route::get('/view/{id}', [ReportController::class, 'viewPlace'])->name('view.place.incident'); 

    Route::prefix('cases')->group(function () {
        Route::get('/', [ReportController::class, 'reportView']);
        Route::get('/view/{id}', [ReportController::class, 'viewPlace'])->name('view.place.incident'); 
    });

    Route::prefix('vaccinations')->group(function () {
        Route::post('/submit-request', [VaccinationController::class, 'saveVaccination']);
        Route::get('/', [ReportController::class, 'reportView']);
    });

    Route::prefix('vaccinations-information')->group(function () {
        Route::get('/', [ReportController::class, 'reportView']);
    });

    Route::prefix('vaccinations-classification')->group(function () {
        Route::get('/', [ReportController::class, 'reportView']);
    });

    Route::prefix('pending-vaccination')->group(function () { 
        Route::get('/', [VaccinationController::class, 'vaccinationList']);
    });

    Route::prefix('finish-vaccination')->group(function () { 
        Route::get('/', [VaccinationController::class, 'vaccinationList']); 
    });
});

Route::prefix('users')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/saveUser', [UserController::class, 'saveUser']);
    Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
    Route::get('/', [UserController::class, 'usersView'])->middleware('auth')->name('view.users');
    Route::get('/terms-condition', [UserController::class, 'viewTerms'])->name('view.terms'); 
    Route::get('/{id}', [UserController::class, 'updateUser'])->middleware('auth');
});

Route::prefix('virus-cases')->group(function () {
    Route::post('/save', [VirusCaseController::class, 'caseSave'])->middleware('auth');
    Route::post('/change-status', [VirusCaseController::class, 'changeStatus'])->middleware('auth');
    Route::get('/', [VirusCaseController::class, 'virusList'])->middleware('auth')->name('view.cases');
});

Route::prefix('contact-tracing')->group(function () {
    Route::post('/save', [ContactTracingController::class, 'saveTrace'])->middleware('auth');

    Route::post('/change-status', [ContactTracingController::class, 'changeStatus'])->middleware('auth');

    Route::get('/', [ContactTracingController::class, 'traceList'])
        ->middleware('auth')->name('view.contact.tracing');

    Route::get('/{id}', [ContactTracingController::class, 'tracingView'])
        ->middleware('auth')->name('view.save.tracing');
});

Route::prefix('vaccinations')->group(function () {
    Route::post('/changeStatus', [VaccinationController::class, 'changeStatus'])->middleware('auth'); 
    Route::get('/', [VaccinationController::class, 'vaccinationList'])->middleware('auth');
});

Route::get('/back-up', [BackupController::class, 'backupDatabase'])->middleware('auth');

