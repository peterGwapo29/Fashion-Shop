<nav x-data="{ open: false }" class="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" class="logo-image">
        <span>Mekylla</span>
    </div>

    <!-- Menu -->
    <ul class="sidebar-menu">
        <li>
            <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                    <rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/>
                    <rect width="7" height="9" x="14" y="12" rx="1"/>
                    <rect width="7" height="5" x="3" y="16" rx="1"/>
                </svg>
                Dashboard
            </a>
        </li>

        <li>
            <a href="<?php echo e(route('product')); ?>" class="<?php echo e(request()->routeIs('product') ? 'active' : ''); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart-icon lucide-shopping-cart">
                    <circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/>
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                </svg>  
                Product
            </a>
        </li>
    </ul>

    <!-- User Section -->
    <div class="sidebar-user" x-data="{ menuOpen: false }" @click.outside="menuOpen = false">
        <!-- Dropdown Menu ABOVE the toggle button -->
        <div x-show="menuOpen" x-transition.origin.bottom class="user-dropdown">
            <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-2 text-sm text-white hover:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                Profile
            </a>

            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); this.closest('form').submit();"
                   class="flex items-center gap-2 text-sm text-white hover:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out">
                        <path d="m16 17 5-5-5-5"/>
                        <path d="M21 12H9"/>
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    </svg>
                    Logout
                </a>
            </form>
        </div>

        <!-- Username and Toggle Button -->
        <div class="flex items-center justify-between w-full relative z-10">
            <p class="user-name">
                <?php if(session()->has('admin_id')): ?>
                    
                    <span><?php echo e(session('admin_name')); ?></span>
                <?php elseif(Auth::check()): ?>
                    
                    <span><?php echo e(Auth::user()->name); ?></span>
                <?php else: ?>
                    <span>Guest</span>
                <?php endif; ?>
            </p>
            <button class="toggle-btn" @click="menuOpen = !menuOpen">
                <svg x-show="!menuOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up-icon lucide-chevron-up">
                    <path d="m18 15-6-6-6 6"/>
                </svg>

                <svg x-show="menuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</nav>
<?php /**PATH C:\petergwapo\Taghoy\BSIT-3A-IPT2\Taghoy-Laravel-Homepage-User\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>