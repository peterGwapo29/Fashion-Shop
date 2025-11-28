<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Fashion Store</title>

  <link rel="stylesheet" href="{{ asset('css/welcome.css') }}" />
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

    <!-- Cart Button -->
    <a href="{{ route('cart.view') }}" class="cart-btn">
        <i class="fa-solid fa-cart-shopping"></i>
        <span class="cart-count" id="cart-count">
            {{ \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity') ?? 0 }}
        </span>
    </a>
    
<!-- Wishlist Button -->
  <a href="{{ route('wishlist.view') }}" class="btn-wishlist">
      <i class="fa-regular fa-heart"></i>
      <span class="wishlist-count" id="wishlist-count">
          {{ \App\Models\Wishlist::where('user_id', Auth::id())->count() ?? 0 }}
      </span>
  </a>

    @guest
    <a href="{{ route('login') }}" class="btn-gradient">Login</a>
    @endguest

    @auth
    <div class="user-greet">
        @if (Auth::user()->image)
        <a href="{{ route('user.page') }}">
            <img src="{{ asset('storage/' . Auth::user()->image) }}" class="profile-img">
        </a>
        @endif
        <span class="username-first_name">
            <a href="{{ route('user.page') }}"><strong>{{ Auth::user()->first_name }}</strong></a>
        </span>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-gradient">Logout</button>
    </form>
    @endauth
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
    @foreach($categories as $cat)
    <option value="{{ strtolower($cat->category_name) }}">{{ $cat->category_name }}</option>
    @endforeach
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
<script src="{{ asset('JS/user/loadproduct.js') }}"></script>

</body>
</html>
