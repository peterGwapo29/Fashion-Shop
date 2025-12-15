<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('google_auth');

Route::get('/auth/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    $user = User::updateOrCreate([
        'google_id' => $googleUser->id,
    ], [
        'first_name' => $googleUser->first_name,
        'email' => $googleUser->email,
        'google_token' => $googleUser->token,
        'google_refresh_token' => $googleUser->refreshToken,
        'email_verified_at' => now(),
    ]);

    Auth::login($user);
    return redirect()->route('welcome');
});

// 🏠 Public welcome page
Route::get('/', function () {
    $categories = Category::all();
    return view('welcome', compact('categories'));
})->name('welcome');


//cart
Route::get('/cart', function () {
    return view('cart');
})->name('cart.page');


Route::get('/dashboard', function () {
    if (session()->has('admin_id')) {
        return view('dashboard');
    }

    if (Auth::check()) {
        return view('dashboard');
    }

    return redirect()->route('login');
})->name('dashboard');

// Route::get('welcome', function () {
//     if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
//         return redirect()->route('verification.notice');
//     }

//     $categories = Category::all();
//     return view('welcome', compact('categories'));
// })->name('welcome');


    // ✅ ADMIN PROFILE ROUTES (Fixed)
    Route::get('/profile/admin', [ProfileController::class, 'edit'])->name('profileEdit');
    Route::patch('/profile/admin', [ProfileController::class, 'update'])->name('profileUpdate');
    Route::delete('/profile/admin', [ProfileController::class, 'destroy'])->name('profileDestroy');


    // ✅ USER PROFILE ROUTES
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserController::class, 'destroy'])->name('profile.destroy');

    // ✅ OTHER ROUTES
    Route::put('/admin/password/update', [UserController::class, 'updatePassword'])->name('admin.password.update');
    Route::get('/user', [UserController::class, 'index'])->name('user.page');
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/product/list', [ProductController::class, 'product_datatables'])->name('product.datatables');
    Route::get('/products/user', [ProductController::class, 'user_index']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::put('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');


    //filter products
    Route::get('/filter-products', [ProductController::class, 'filterProducts'])->name('products.filter');

    //cart
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'deleteItem'])->name('cart.delete');
    Route::get('/cart/count', [CartController::class, 'count']);
    Route::delete('/cart/clear-all', [CartController::class, 'clearAll'])->name('cart.clearAll');


    //wishlist
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::get('/wishlist', [WishlistController::class, 'view'])->name('wishlist.view');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::get('/wishlist/count', [\App\Http\Controllers\WishlistController::class, 'count']);
    Route::delete('/wishlist/clear-all', [WishlistController::class, 'clearAll'])->name('wishlist.clearAll');

    //My Order
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    
    //Payment
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}', [PaymentController::class, 'submit'])->name('payment.submit');

    //Checkout
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');


    // OrderAdmin
    Route::get('/orderAdmin', [OrderAdminController::class, 'index'])->name('orderAdmin');
    Route::get('/orderAdmin/list', [OrderAdminController::class, 'datatable'])->name('orderAdmin.list');
    Route::get('/orderAdmin/{order}/items', [OrderAdminController::class, 'items'])->name('orderAdmin.items');
    Route::put('/orderAdmin/{order}/status', [OrderAdminController::class, 'updateStatus'])->name('orderAdmin.status');


    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/charts/overview', [DashboardController::class, 'chartOverview'])->name('dashboard.charts.overview');
    Route::get('/dashboard/table/orders', [DashboardController::class, 'tableOrders'])->name('dashboard.table.orders');
    Route::get('/dashboard/table/products/marketable', [DashboardController::class, 'tableMarketable'])->name('dashboard.table.marketable');
    Route::get('/dashboard/table/products/nonmarketable', [DashboardController::class, 'tableNonMarketable'])->name('dashboard.table.nonmarketable');
    Route::put('/dashboard/orders/{order}/status', [DashboardController::class, 'updateOrderStatus'])->name('dashboard.order.status');


    //Category
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/list', [CategoryController::class, 'list'])->name('category.list');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::put('/category/{category}/restore', [CategoryController::class, 'restore'])->name('category.restore');


    require __DIR__.'/auth.php';
