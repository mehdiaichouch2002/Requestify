<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\SuperAdminRegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// document-request routes :
Route::prefix('document-request')->name('document-request.')->group(function () {
    Route::get('/create', [DocumentController::class, 'create'])->name('create');
    Route::post('/', [DocumentController::class, 'store'])->name('store');
});

// material-request routes :
Route::prefix('material-request')->name('material-request.')->group(function () {
    Route::get('/create', [MaterialController::class, 'create'])->name('create');
    Route::post('/', [MaterialController::class, 'store'])->name('store');
});

// request a leave :
Route::prefix('vacation-request')->name('vacation-request.')->group(function () {
    Route::get('/create', [VacationController::class, 'create'])->name('create');
    Route::post('/', [VacationController::class, 'store'])->name('store');
});

// request remote work:
Route::prefix('homework-request')->name('homework-request.')->group(function () {
    Route::get('/create',[HomeworkController::class, 'create'])->name('create');
    Route::post('/', [HomeworkController::class, 'store'])->name('store');
});

// request valuation:
Route::prefix('evaluation-request')->name('evaluation-request.')->group(function () {
    Route::get('/create',[EvaluationController::class, 'create'])->name('create');
    Route::post('/', [EvaluationController::class, 'store'])->name('store');
});


// collaborator-history
Route::get('/collaborator-history', [DashboardController::class, 'history'])->name('collaborator-history');

});
Route::middleware('admin')->group(function () {
    // homework management:
    Route::prefix('homework-management')->name('homework-management.')->group(function () {
        Route::get('/', [HomeworkController::class, 'index'])->name('index');
        Route::get('/create', function () {
            return view('formulaire');
        })->name('create');
        Route::get('/show/{id}', [HomeworkController::class, 'show'])->name('show');
        Route::delete('/{id}', [HomeworkController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/accept', [HomeworkController::class, 'accept'])->name('accept');
        Route::get('/{id}/reject', [HomeworkController::class, 'reject'])->name('reject');
        Route::post('/create', [HomeworkController::class, 'formulaire'])->name('save');
    });

    // vacation management:
    Route::prefix('vacation-management')->name('vacation-management.')->group(function () {
        Route::get('/', [VacationController::class, 'index'])->name('index');
        Route::get('/show/{id}', [VacationController::class, 'show'])->name('show');
        Route::patch('/{id}', [VacationController::class, 'update'])->name('update');
        Route::delete('/{id}', [VacationController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/accept', [VacationController::class, 'accept'])->name('accept');
        Route::get('/{id}/reject', [VacationController::class, 'reject'])->name('reject');
    });

    // user-management routes:
    Route::prefix('user-management')->name('user-management.')->group(function () {
        Route::get('/', [SuperAdminRegistrationController::class, 'index'])->name('index');
        Route::get('/show/{id}', [SuperAdminRegistrationController::class, 'show'])->name('show');
        Route::get('/create', [SuperAdminRegistrationController::class, 'create'])->name('create');
        Route::post('/', [SuperAdminRegistrationController::class, 'store'])->name('store');
        Route::patch('/{id}', [SuperAdminRegistrationController::class, 'update'])->name('update');
        Route::delete('/{id}', [SuperAdminRegistrationController::class, 'destroy'])->name('destroy');
    });

    // document-management routes:
    Route::prefix('document-management')->name('document-management.')->group(function () {
        Route::get('/', [DocumentController::class, 'index'])->name('index');
        Route::get('/{id}/show', [DocumentController::class, 'show'])->name('show');
        Route::get('/{id}/accept', [DocumentController::class, 'accept'])->name('accept');
        Route::get('/{id}/reject', [DocumentController::class, 'reject'])->name('reject');
        Route::delete('/{id}', [DocumentController::class, 'destroy'])->name('destroy');
    });

    // material-management routes:
    Route::prefix('material-management')->name('material-management.')->group(function () {
        Route::get('/', [MaterialController::class, 'index'])->name('index');
        Route::get('/{id}/show', [MaterialController::class, 'show'])->name('show');
        Route::get('/{id}/accept', [MaterialController::class, 'accept'])->name('accept');
        Route::get('/{id}/reject', [MaterialController::class, 'reject'])->name('reject');
        Route::delete('/{id}', [MaterialController::class, 'destroy'])->name('destroy');
    });

    // evaluation-management routes:
    Route::prefix('evaluation-management')->name('evaluation-management.')->group(function () {
        Route::get('/', [EvaluationController::class, 'index'])->name('index');
        Route::get('/{id}/show', [EvaluationController::class, 'show'])->name('show');
        Route::get('/{id}/accept', [EvaluationController::class, 'accept'])->name('accept');
        Route::get('/{id}/reject', [EvaluationController::class, 'reject'])->name('reject');
        Route::delete('/{id}', [EvaluationController::class, 'destroy'])->name('destroy');
    });

    //admin-history
    Route::get('/admin-history', [DashboardController::class, 'history'])->name('admin-history');
   });


require __DIR__.'/auth.php';
