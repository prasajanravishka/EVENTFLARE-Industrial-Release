<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOperationsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\EventShowcaseController;
use App\Http\Controllers\FoodCalculatorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Supplier\SupplierDashboardController;
use App\Http\Controllers\Supplier\SupplierListingController;
use App\Http\Controllers\Supplier\SupplierProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::post('/contact', [PageController::class, 'contact'])->name('contact.submit');
Route::get('/events', [PageController::class, 'events'])->name('events.index');
Route::get('/marketplace', [\App\Http\Controllers\MarketplaceController::class, 'index'])->name('marketplace.index');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

Route::prefix('events')->name('events.')->group(function () {
    Route::get('/weddings', [EventShowcaseController::class, 'weddings'])->name('weddings');
    Route::get('/dj-parties', [EventShowcaseController::class, 'djParties'])->name('dj-parties');
    Route::get('/birthdays', [EventShowcaseController::class, 'birthdays'])->name('birthdays');
    Route::get('/hotel-venues', [EventShowcaseController::class, 'hotels'])->name('hotels');
    Route::get('/get-together', [EventShowcaseController::class, 'getTogether'])->name('get-together');
});

Route::get('/food-calculator', [FoodCalculatorController::class, 'index'])->name('food-calculator');
Route::post('/food-calculator', [FoodCalculatorController::class, 'calculate'])->name('food-calculator.calculate');

/*
|--------------------------------------------------------------------------
| Authenticated Buyer / Client Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'buyer'])->group(function () {
    // Client Event Hub Dashboard
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');

    // Booking Creation & Lifecycle
    Route::get('/book', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/events/wedding-booking', function (\Illuminate\Http\Request $request) {
        return redirect()->route('booking.create', array_merge(['event' => 'Weddings'], $request->query()));
    })->name('events.wedding-booking');
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('client.bookings');
    Route::get('/my-bookings/{id}', [BookingController::class, 'show'])->name('client.bookings.show');
    Route::get('/my-bookings/{id}/pdf', [BookingController::class, 'pdf'])->name('client.bookings.pdf');

    // Supplier Rating Submission
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
});

/*
|--------------------------------------------------------------------------
| Authenticated Supplier Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'supplier'])->prefix('supplier')->name('supplier.')->group(function () {
    // Supplier Command Center Dashboard
    Route::get('/dashboard', [SupplierDashboardController::class, 'index'])->name('dashboard');

    // Business Profile & Services Configuration
    Route::get('/profile', [SupplierProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [SupplierProfileController::class, 'update'])->name('profile.update');

    // Packages & Listings CRUD
    Route::get('/listings', [SupplierListingController::class, 'index'])->name('listings.index');
    Route::post('/listings', [SupplierListingController::class, 'store'])->name('listings.store');
    Route::put('/listings/{id}', [SupplierListingController::class, 'update'])->name('listings.update');
    Route::patch('/listings/{id}/toggle', [SupplierListingController::class, 'toggle'])->name('listings.toggle');
    Route::delete('/listings/{id}', [SupplierListingController::class, 'destroy'])->name('listings.destroy');
});

/*
|--------------------------------------------------------------------------
| Authenticated Admin Console Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Executive Overview Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Bookings Operations
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');
    Route::post('/bookings/{id}/assign', [AdminBookingController::class, 'assignSupplier'])->name('bookings.assign');
    Route::delete('/bookings/assignments/{id}', [AdminBookingController::class, 'removeAssignment'])->name('bookings.assignments.destroy');
    Route::delete('/bookings/{id}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');

    // People & Accounts: Clients & Suppliers
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/suppliers', [AdminUserController::class, 'suppliers'])->name('suppliers.index');
    Route::post('/suppliers', [AdminUserController::class, 'storeSupplier'])->name('suppliers.store');
    Route::put('/suppliers/{id}', [AdminUserController::class, 'updateSupplier'])->name('suppliers.update');

    // Ratings & Reviews Moderation
    Route::get('/ratings', [AdminOperationsController::class, 'ratings'])->name('ratings.index');
    Route::patch('/ratings/{id}/toggle', [AdminOperationsController::class, 'toggleRating'])->name('ratings.toggle');
    Route::delete('/ratings/{id}', [AdminOperationsController::class, 'destroyRating'])->name('ratings.destroy');

    // Event Types & Services Catalog
    Route::get('/event-types', [AdminOperationsController::class, 'eventTypes'])->name('event-types.index');
    Route::post('/event-types', [AdminOperationsController::class, 'storeEventType'])->name('event-types.store');
    Route::post('/services', [AdminOperationsController::class, 'storeService'])->name('services.store');

    // Budgets Audit
    Route::get('/budgets', [AdminOperationsController::class, 'budgets'])->name('budgets.index');

    // Customer Inquiries & Messages
    Route::get('/messages', [AdminOperationsController::class, 'messages'])->name('messages.index');
    Route::patch('/messages/{id}/toggle', [AdminOperationsController::class, 'toggleMessageRead'])->name('messages.toggle');
    Route::delete('/messages/{id}', [AdminOperationsController::class, 'destroyMessage'])->name('messages.destroy');

    // Staff & Administrators
    Route::get('/staff', [AdminOperationsController::class, 'staff'])->name('staff.index');
    Route::post('/staff', [AdminOperationsController::class, 'storeStaff'])->name('staff.store');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
