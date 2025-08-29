<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResponsibleCorporatesController;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','is_admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/responsible-corp-add', [ResponsibleCorporatesController::class, 'create'])->name('responsible-corp-add');
    Route::post('/responsible-corp-add', [ResponsibleCorporatesController::class, 'store'])->name('responsible-corp-add');
    Route::get('/responsible-corp-list', [ResponsibleCorporatesController::class, 'index'])->name('responsible-corp-list');
    Route::get('/responsible-corp-update/{id?}', [ResponsibleCorporatesController::class, 'edit'])->name('responsible-corp-update');
    Route::post('/responsible-corp-updating/{id?}', [ResponsibleCorporatesController::class, 'update'])->name('responsible-corp-updating');
    Route::get('/responsible-corp-delete/{id?}', [ResponsibleCorporatesController::class, 'destroy'])->name('responsible-corp-delete');
    Route::get('/listing_statusupdateres/{id}/{status}', [ResponsibleCorporatesController::class, 'listing_statusupdateRes'])->name('listing_statusupdateres');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');