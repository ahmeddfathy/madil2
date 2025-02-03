<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Controllers
use App\Http\Controllers\{
    ProductController,
    OrderController,
    AppointmentController,
    CartController,
    CheckoutController,
    ProfileController,
    NotificationController,
    DashboardController,
    PhoneController,
    AddressController
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
})->name('home');

// Static Pages Routes

// About Page
Route::get('/about', function () {
    return view('about');
})->name('about');



// Newsletter Subscription
Route::post('/newsletter/subscribe', function (Request $request) {
    // هنا يمكن إضافة منطق معالجة الاشتراك في النشرة البريدية
    return back()->with('success', 'تم الاشتراك في النشرة البريدية بنجاح');
})->name('newsletter.subscribe');

// Products Routes (Public)
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/filter', [ProductController::class, 'filter'])->name('filter');
    Route::get('/{product}/details', [ProductController::class, 'getProductDetails'])->name('details');
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
        Route::post('/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    });

    // Customer Routes
    Route::middleware(['role:customer'])->group(function () {
        // Products
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::post('/products/filter', [ProductController::class, 'filter'])->name('products.filter');

        // Phones
        Route::post('/phones', [PhoneController::class, 'store']);
        Route::get('/phones/{id}', [PhoneController::class, 'show']);
        Route::put('/phones/{id}', [PhoneController::class, 'update']);
        Route::delete('/phones/{id}', [PhoneController::class, 'destroy']);

        // Addresses
        Route::post('/addresses', [AddressController::class, 'store']);
        Route::get('/addresses/{id}', [AddressController::class, 'show']);
        Route::put('/addresses/{id}', [AddressController::class, 'update']);
        Route::delete('/addresses/{id}', [AddressController::class, 'destroy']);

        // Cart
        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/add', [ProductController::class, 'addToCart'])->name('add');
            Route::get('/items', [ProductController::class, 'getCartItems'])->name('items');
            Route::patch('/update/{cartItem}', [CartController::class, 'updateQuantity'])->name('update');
            Route::delete('/remove/{cartItem}', [CartController::class, 'removeItem'])->name('remove');
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
            Route::get('/dashboard/', [AdminDashboardController::class, 'index'])->name('dashboard');

            // Products Management
            Route::middleware(['permission:manage products'])->group(function () {
                Route::resource('products', AdminProductController::class);
                Route::resource('categories', AdminCategoryController::class);
            });

            // Orders Management
            Route::middleware(['permission:manage orders'])->group(function () {
                Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
                Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
                Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
                    ->name('orders.update-status');
                Route::put('/orders/{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])
                    ->name('orders.update-payment-status');
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

// Cart Routes
Route::post('/cart/add', [ProductController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/items', [ProductController::class, 'getCartItems'])->name('cart.items');
Route::patch('/cart/items/{cartItem}', [ProductController::class, 'updateCartItem'])->name('cart.update-item');
Route::delete('/cart/items/{cartItem}', [ProductController::class, 'removeCartItem'])->name('cart.remove-item');
