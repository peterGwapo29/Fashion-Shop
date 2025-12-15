<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Fashion Store</title>

  <link rel="stylesheet" href="<?php echo e(asset('css/welcome.css')); ?>" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body>

<!-- HEADER -->
<header class="header">
  <div class="container header-content">
    <div class="logo">FashionStore</div>

    <nav class="nav">
      <a href="#">Home</a>
      <a href="#">Shop</a>
      <a href="#">Collections</a>
      <a href="#">Contact</a>
    </nav>

    <div class="buttonss">

    <a href="<?php echo e(route('orders.index')); ?>" class="btn-orders">
        <i class="fa-solid fa-receipt"></i>
        My Orders
    </a>

    <!-- Cart Button -->
    <a href="<?php echo e(route('cart.view')); ?>" class="cart-btn">
        <i class="fa-solid fa-cart-shopping"></i>
        <span class="cart-count" id="cart-count">
            <?php echo e(\App\Models\CartItem::where('user_id', Auth::id())->sum('quantity') ?? 0); ?>

        </span>
    </a>
    
<!-- Wishlist Button -->
  <a href="<?php echo e(route('wishlist.view')); ?>" class="btn-wishlist">
      <i class="fa-regular fa-heart"></i>
      <span class="wishlist-count" id="wishlist-count">
          <?php echo e(\App\Models\Wishlist::where('user_id', Auth::id())->count() ?? 0); ?>

      </span>
  </a>

    <?php if(auth()->guard()->guest()): ?>
    <a href="<?php echo e(route('login')); ?>" class="btn-gradient">Login</a>
    <?php endif; ?>

    <?php if(auth()->guard()->check()): ?>
    <div class="user-greet">
        <?php if(Auth::user()->image): ?>
        <a href="<?php echo e(route('user.page')); ?>">
            <img src="<?php echo e(asset('storage/' . Auth::user()->image)); ?>" class="profile-img">
        </a>
        <?php endif; ?>
        <span class="username-first_name">
            <a href="<?php echo e(route('user.page')); ?>"><strong><?php echo e(Auth::user()->first_name); ?></strong></a>
        </span>
    </div>

    <form method="POST" action="<?php echo e(route('logout')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn-gradient">Logout</button>
    </form>
    <?php endif; ?>
</div>

  </div>
</header>

<!-- HERO -->
<section class="hero">
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h1>Discover Your Signature Style</h1>
    <p>Premium, curated fashion pieces made to elevate every moment.</p>
    <a href="#" class="btn-primary">Shop Now</a>
  </div>
</section>

<!-- FILTER BAR -->
<div class="filter-sort-container">
  <select id="filter-category" class="filter-select">
    <option value="all">All</option>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e(strtolower($cat->category_name)); ?>"><?php echo e($cat->category_name); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>

  <select id="sort-products" class="filter-select">
      <option value="featured">Featured</option>
      <option value="newest">Newest</option>
      <option value="highlow">Price: High-Low</option>
      <option value="lowhigh">Price: Low-High</option>
  </select>
</div>


<!-- PRODUCT GRID -->
<div id="products-container" class="product-grid"></div>


<!-- FOOTER -->
<footer class="footer">
  <p>&copy; 2025 FashionStore</p>
  <div class="social-icons">
    <a href="#"><i class="fab fa-facebook-f"></i></a>
    <a href="#"><i class="fab fa-instagram"></i></a>
    <a href="#"><i class="fab fa-twitter"></i></a>
  </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo e(asset('JS/user/loadproduct.js')); ?>"></script>

</body>
</html>
<?php /**PATH C:\petergwapo\FashionStore\resources\views/welcome.blade.php ENDPATH**/ ?>