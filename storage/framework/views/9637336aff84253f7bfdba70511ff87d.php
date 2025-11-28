<!DOCTYPE html>
<html lang="en" style="scroll-behavior: smooth;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Mekylla Store - Online Bags</title>

    <link rel="stylesheet" href="<?php echo e(asset('css/welcome.css')); ?>">


    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>
<body class="bg-white text-gray-800">

<header class="border-b bg-white shadow-sm">
    <div class="container mx-auto flex justify-between items-center py-4 px-6" id="Home">
        
        <!-- Left: Logo -->
        <div class="flex items-center space-x-2">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" style="height: 60px;">
            <h1 class="font-bold text-xl text-gray-800">Mekylla Store</h1>
        </div>

        <!-- Center: Navigation links -->
        <nav class="hidden md:flex space-x-8 text-gray-700 font-medium">
            <a href="#Home" class="hover:text-pink-500 transition">Home</a>
            <a href="#" class="hover:text-pink-500 transition">About Us</a>
            <a href="#product-container" class="hover:text-pink-500 transition">Product</a>
        </nav>

        <!-- Right: User / Cart / Auth -->
        <div class="flex justify-center items-center" style="gap: 18px;">
            <!-- Category Dropdown --> 
            <select class="border rounded-lg px-10 py-5 text-sm focus:ring-2 focus:ring-pink-400 cursor-pointer">
                <option>All Categories</option>
                <option>Women</option>
                <option>Men</option>
                <option>Kids</option>
            </select>

            <!-- Greeting -->
            <span class="text-sm text-gray-600 hidden lg:inline">
                Hello, <strong>UserName</strong>
            </span>

            <!-- Cart Icon -->
            <div class="relative cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    width="24" height="24" 
                    viewBox="0 0 24 24" 
                    fill="none" 
                    stroke="currentColor" 
                    stroke-width="2" 
                    stroke-linecap="round" 
                    stroke-linejoin="round" class="lucide lucide-shopping-cart-icon lucide-shopping-cart">
                    <circle cx="8" cy="21" r="1"/>
                    <circle cx="19" cy="21" r="1"/>
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                </svg>
                <span class="absolute bg-pink-500 text-white text-xs" style="margin-top: -32px; margin-left: 14px; border-radius: 100%; padding: 3px 8px;">0</span>
            </div>

            <!-- Auth Buttons -->
            <div class="flex gap-3">
                <?php if(auth()->guard()->guest()): ?>
                    <!-- Show this when NOT logged in -->
                    <a href="<?php echo e(route('login')); ?>" 
                    class="px-5 py-2 border-2 border-pink-400 text-pink-400 rounded-full font-semibold text-sm hover:bg-pink-500 hover:text-white transition">
                        Login
                    </a>
                <?php endif; ?>

                <?php if(auth()->guard()->check()): ?>
                    <!-- Greeting with Profile Image -->
                    <div class="flex items-center gap-2 cursor-pointer ">
                        <?php if(Auth::user()->image): ?>
                            <a href="<?php echo e(route('user.page')); ?>">
                                <img src="<?php echo e(asset('storage/' . Auth::user()->image)); ?>" 
                                alt="Profile" 
                                class="rounded-full object-cover border border-gray-300" style="height: 40px; width: 40px;">
                            </a>
                        <?php endif; ?>
                        <span class="text-sm text-gray-600 hidden lg:inline">
                            Hello, <strong><?php echo e(Auth::user()->name); ?></strong>
                        </span>
                    </div>

                    <!-- Logout Button -->
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" 
                            class="px-5 py-2 border-2 border-pink-400 text-pink-400 rounded-full font-semibold text-sm hover:bg-pink-500 hover:text-white transition">
                            Logout
                        </button>
                    </form>
                <?php endif; ?>
            </div>

        </div>

        <!-- Mobile Menu Button -->
        <button class="md:hidden block text-gray-700 hover:text-pink-500 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

    </div>
</header>

<!-- Hero Section -->
<section class="bg-gray-100 py-12" id="Home">
  <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-6">
    <!-- Left Text -->
    <div class="max-w-lg space-y-4">
      <p class="text-sm text-gray-600">2025</p>
      <h2 class="text-4xl font-bold text-gray-800 leading-tight">New Summer Collection...</h2>
      <p class="text-gray-500">The largest range of luxury handbags</p>
      <a href="#product-container" class="inline-block bg-pink-500 text-white px-6 py-2 rounded-full hover:bg-pink-600 transition mt-2">
        Shop now →
      </a>
      <div class="mt-6 flex items-center space-x-4">
        <img src="<?php echo e(asset('images/product/pngegg4.png')); ?>" style="height: 350px;">
        <img src="<?php echo e(asset('images/product/pngegg6.png')); ?>" style="height: 350px;">
        <img src="<?php echo e(asset('images/product/pngegg5.png')); ?>" style="height: 350px;">
      </div>
    </div>

  </div>
</section>

<section class="flex justify-center items-center text-sm text-center" style="gap: 100px; margin-top: 40px;">
    <div>
        <p class="text-2xl">🚚</p>
        <p>Free Shipping</p>
    </div>
    <div>
        <p class="text-2xl">💰</p>
        <p>Money Guarantee</p>
    </div>
    <div>
        <p class="text-2xl">📞</p>
        <p>24/7 Help Center</p>
    </div>
    <div>
        <p class="text-2xl">💳</p>
        <p>Secure Payment</p>
    </div>
</section>

<!-- Popular This Week -->
<section class="py-12" style="margin-top: 60px;">
    <div class="container mx-auto text-center px-6">
        <h3 class="text-2xl font-semibold mb-8">Popular This Week</h3>

        <div class="flex flex-wrap justify-center gap-8 overflow-x-auto pb-4">
            <div class="flex flex-col items-center min-w-[200px]">
                <img src="<?php echo e(asset('images/product/pngegg1.png')); ?>" 
                     alt="Bag" 
                     class="mx-auto mb-4 w-48 h-48 object-contain">
                <p class="font-medium">Pink Handbag</p>
            </div>

            <div class="flex flex-col items-center min-w-[200px]">
                <img src="<?php echo e(asset('images/product/pngegg3.png')); ?>" 
                     alt="Bag" 
                     class="mx-auto mb-4 w-48 h-48 object-contain">
                <p class="font-medium">Black Backpack</p>
            </div>

            <div class="flex flex-col items-center min-w-[200px]">
                <img src="<?php echo e(asset('images/product/pngegg7.png')); ?>" 
                     alt="Bag" 
                     class="mx-auto mb-4 w-48 h-48 object-contain">
                <p class="font-medium">Brown Satchel</p>
            </div>

            <div class="flex flex-col items-center min-w-[200px]">
                <img src="<?php echo e(asset('images/product/pngegg5.png')); ?>" 
                     alt="Bag" 
                     class="mx-auto mb-4 w-48 h-48 object-contain">
                <p class="font-medium">Tote Bag</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Products -->
<section class="py-12 bg-gray-50" style="margin-top: 60px;">
  <div class="container mx-auto text-center px-6">
    <h3 class="text-2xl font-semibold mb-2">Our Products</h3>
    <p class="text-gray-500 mb-8">
      From celebrity inspired women’s fashion to the latest in-trend styles.
    </p>

    <div 
      style="display: grid; justify-content: center; grid-template-columns: 300px 300px 300px 300px; gap: 1rem;" 
      id="product-container">
    </div>

    <div id="product"></div>


    
  </div>
</section>


<footer class="bg-gray-800 text-gray-400 text-center py-6 mt-12">
    <p>&copy; 2025 Mekylla Store.</p>
</footer>

<script src="<?php echo e(asset('JS/user/welcome.js')); ?>"></script>

</body>
</html>
<?php /**PATH C:\petergwapo\Taghoy\BSIT-3A-IPT2\Taghoy-Laravel-Homepage-User\resources\views/welcome.blade.php ENDPATH**/ ?>