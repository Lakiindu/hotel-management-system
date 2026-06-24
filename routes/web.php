<?php

// Web Routes
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ContactController;

// Admin Controllers
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HotelContentController;

// Customer Controllers
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;
use App\Http\Controllers\Customer\ReviewController as CustomerReviewController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;

// Authentication Controllers
use Illuminate\Support\Facades\Route;

// Mail
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

// Public Frontend Routes
// Home and Rooms pages
Route::get('/', [FrontendController::class, 'home'])->name('home');

// Rooms listing and details pages
Route::get('/rooms', [FrontendController::class, 'rooms'])
    ->name('rooms');

// Room details page with dynamic room ID
Route::get('/rooms/{room}', [FrontendController::class, 'roomDetails'])
    ->name('rooms.details');

// Contact Form Route
// Handles contact form submissions from the frontend
Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

// Public AJAX Rooms Route
Route::get('/ajax/rooms', [FrontendController::class, 'ajaxRooms'])
    ->name('ajax.rooms');

// Dashboard Redirect
Route::get('/dashboard', [DashboardController::class, 'redirect'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Notification Routes
Route::middleware(['auth'])->group(function () {

    // Mark individual notification as read
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    // Mark all notifications as read
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');

});

// Admin Routes
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])
            ->name('dashboard');

        // Admin AJAX Routes
        Route::get('/ajax/rooms', [RoomController::class, 'ajaxRooms'])
            ->name('ajax.rooms');

        Route::get('/ajax/customers', [CustomerController::class, 'ajaxCustomers'])
            ->name('ajax.customers');

        Route::get('/ajax/bookings', [AdminBookingController::class, 'ajaxBookings'])
            ->name('ajax.bookings');

        Route::get('/ajax/payments', [AdminPaymentController::class, 'ajaxPayments'])
            ->name('ajax.payments');

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

        Route::get('/contacts', [AdminContactController::class, 'index'])
            ->name('contacts.index');

        Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])
            ->name('contacts.show');

        Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])
            ->name('contacts.destroy');

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/export/csv', [ReportController::class, 'exportCsv'])
            ->name('reports.export.csv');

        Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])
            ->name('reports.export.pdf');

        /*
        |--------------------------------------------------------------------------
        | Website Management
        |--------------------------------------------------------------------------
        */

        Route::resource('services', ServiceController::class);

        Route::resource('galleries', GalleryController::class);

        Route::resource('hotel-contents', HotelContentController::class);
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

        Route::get('/payments/{payment}/invoice/pdf', [CustomerPaymentController::class, 'downloadInvoicePdf'])
            ->name('payments.invoice.pdf');

        Route::get('/payments/{payment}/invoice/csv', [CustomerPaymentController::class, 'downloadInvoiceCsv'])
            ->name('payments.invoice.csv');
    });

require __DIR__ . '/auth.php';