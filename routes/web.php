<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AppointmentController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/services', [ServicesController::class, 'index'])->name('services');


Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);


Route::resource('users', UserController::class);
Route::get('/profile', [UserController::class, 'index'])->name('users.index');
Route::get('/profile/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::delete('/profile/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::delete('/users/{user}/delete-photo', [UserController::class, 'deletePhoto'])->name('users.deletePhoto');
Route::get('/users', [UserController::class, 'listClients'])->name('clients.list');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users-deleted', [UserController::class, 'trashed'])->name('users.trashed');
Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');


Route::get('/reviews', [ReviewsController::class, 'index'])->name('reviews.index');
Route::get('/my-reviews', [ReviewsController::class, 'myReviews'])->name('reviews.list');
Route::get('/reviews/create', [ReviewsController::class, 'create'])->name('reviews.create');
Route::post('/reviews', [ReviewsController::class, 'store'])->name('reviews.store');


Route::get('/mis-pagos', [PaymentController::class, 'myPayments'])->name('payments.list');
Route::get('/pagos', [PaymentController::class, 'index'])->name('payments.index');
Route::get('/pagos/create', [PaymentController::class, 'create'])->name('payments.create');
Route::post('/pagos', [PaymentController::class, 'store'])->name('payments.store');
Route::get('/pagos/{payment}', [PaymentController::class, 'show'])->name('payments.show');
Route::get('/pagos/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
Route::put('/pagos/{payment}', [PaymentController::class, 'update'])->name('payments.update');
Route::delete('/pagos/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
Route::delete('/pagos/{payment}/delete-file', [PaymentController::class, 'deleteFile'])->name('payments.deleteFile');


Route::get('/appointments', [AppointmentController::class, 'myAppointments'])->name('appointments.index');
Route::get('/appointments-month', [AppointmentController::class, 'myAppointmentsByMonth'])->name('appointments.months');
