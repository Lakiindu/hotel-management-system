<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Customer\ReviewController as CustomerReviewController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;

// Front Page
Route::get('/', [FrontendController::class, 'home'])->name('home');

Route::get('/rooms', [FrontendController::class, 'rooms'])->name('rooms');

Route::get('/rooms/{room}', [FrontendController::class, 'roomDetails'])->name('rooms.details');

// AJAX Rooms Route
Route::get('/ajax/rooms', [FrontendController::class, 'ajaxRooms'])
    ->name('ajax.rooms');

// Dashboard Redirect
Route::get('/dashboard', [DashboardController::class, 'redirect'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin Routes - only admin can access
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])
            ->name('dashboard');

        Route::resource('rooms', RoomController::class);

        Route::get('/customers', [CustomerController::class, 'index'])
            ->name('customers.index');

        Route::get('/customers/{user}', [CustomerController::class, 'show'])
            ->name('customers.show');

        Route::patch('/customers/{user}/toggle-status', [CustomerController::class, 'toggleStatus'])
            ->name('customers.toggleStatus');

        Route::get('/bookings', [AdminBookingController::class, 'index'])
            ->name('bookings.index');

        Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])
            ->name('bookings.updateStatus');

        Route::get('/payments', [AdminPaymentController::class, 'index'])
            ->name('payments.index');

        Route::patch('/payments/{payment}/confirm', [AdminPaymentController::class, 'confirm'])
            ->name('payments.confirm');

        Route::get('/reviews', [AdminReviewController::class, 'index'])
            ->name('reviews.index');

        Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])
            ->name('reviews.destroy');

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/export/csv', [ReportController::class, 'exportCsv'])
            ->name('reports.export.csv');

        Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])
            ->name('reports.export.pdf');
    });

// Customer Routes
Route::middleware(['auth'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'customerDashboard'])
            ->name('dashboard');

        Route::get('/rooms/{room}/book', [CustomerBookingController::class, 'create'])
            ->name('bookings.create');

        Route::post('/rooms/{room}/book', [CustomerBookingController::class, 'store'])
            ->name('bookings.store');

        Route::get('/bookings', [CustomerBookingController::class, 'index'])
            ->name('bookings.index');

        Route::get('/bookings/{booking}', [CustomerBookingController::class, 'show'])
            ->name('bookings.show');

        Route::patch('/bookings/{booking}/cancel', [CustomerBookingController::class, 'cancel'])
            ->name('bookings.cancel');

        Route::get('/bookings/{booking}/review', [CustomerReviewController::class, 'create'])
            ->name('reviews.create');

        Route::post('/bookings/{booking}/review', [CustomerReviewController::class, 'store'])
            ->name('reviews.store');

        Route::get('/payments', [CustomerPaymentController::class, 'index'])
            ->name('payments.index');

        Route::patch('/payments/{payment}/pay', [CustomerPaymentController::class, 'pay'])
            ->name('payments.pay');

        Route::get('/payments/{payment}/invoice', [CustomerPaymentController::class, 'invoice'])
            ->name('payments.invoice');

        Route::get('/payments/{payment}/card', [CustomerPaymentController::class, 'cardForm'])
            ->name('payments.card');

        Route::post('/payments/{payment}/card', [CustomerPaymentController::class, 'processCard'])
            ->name('payments.card.process');

        Route::get('/profile', [CustomerProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile', [CustomerProfileController::class, 'update'])
            ->name('profile.update');

        Route::put('/profile/password', [CustomerProfileController::class, 'updatePassword'])
            ->name('profile.password');
    });

// Profile Routes
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';