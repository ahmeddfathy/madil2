<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\{
    ProductController,
    OrderController,
    AppointmentController,
    CartController,
    CheckoutController,
    ProfileController,
    NotificationController,
    DashboardController
};

// Admin Controllers
use App\Http\Controllers\Admin\{
    OrderController as AdminOrderController,
    ProductController as AdminProductController,
    CategoryController as AdminCategoryController,
    AppointmentController as AdminAppointmentController,
    ReportController as AdminReportController,
    DashboardController as AdminDashboardController
};

// Public Routes
Route::get('/', function () {
    $products = \App\Models\Product::with('images')
        ->latest()
        ->take(3)
        ->get();
    return view('index', compact('products'));
});

// Auth Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Common Routes (for all authenticated users)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    });

    // Customer Routes
    Route::middleware(['role:customer'])->group(function () {
        // Products
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

        // Cart
        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/{product}', [CartController::class, 'add'])->name('add');
            Route::patch('/{product}', [CartController::class, 'update'])->name('update');
            Route::delete('/{product}', [CartController::class, 'remove'])->name('remove');
            Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        });

        // Checkout
        Route::controller(CheckoutController::class)->prefix('checkout')->name('checkout.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store')->middleware('web');
        });

        // Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        });

        // Appointments
        Route::prefix('appointments')->name('appointments.')->group(function () {
            Route::get('/', [AppointmentController::class, 'index'])->name('index');
            Route::get('/create', [AppointmentController::class, 'create'])->name('create');
            Route::post('/', [AppointmentController::class, 'store'])->name('store');
            Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('show');
            Route::delete('/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('cancel');
        });
    });

    // Admin Routes
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            // Dashboard
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            // Products Management
            Route::middleware(['permission:manage products'])->group(function () {
                Route::resource('products', AdminProductController::class);
                Route::resource('categories', AdminCategoryController::class);
            });

            // Orders Management
            Route::middleware(['permission:manage orders'])->group(function () {
                Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
                Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
                Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
                    ->name('orders.update-status')
                    ->middleware('can:update,order');
                Route::patch('/orders/{order}/payment', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.update-payment');
            });

            // Appointments Management
            Route::middleware(['permission:manage appointments'])->group(function () {
                Route::resource('appointments', AdminAppointmentController::class)->except(['create', 'store', 'edit', 'update']);
                Route::patch('/appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.update-status');
            });

            // Reports Management
            Route::middleware(['permission:manage reports'])->group(function () {
                Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
                Route::get('/reports/export', [AdminReportController::class, 'export'])->name('reports.export');
            });
        });
});

Route::post('/appointments', [AppointmentController::class, 'store'])
    ->name('appointments.store');
