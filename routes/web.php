<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
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
        'name' => $googleUser->name,
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



// ✅ Unified dashboard
Route::get('/dashboard', function () {
    if (session()->has('admin_id')) {
        return view('dashboard');
    }

    if (Auth::check()) {
        return view('dashboard');
    }

    return redirect()->route('login');
})->name('dashboard');

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


require __DIR__.'/auth.php';
