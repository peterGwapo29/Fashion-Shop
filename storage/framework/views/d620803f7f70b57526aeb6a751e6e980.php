<aside class="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <span>MDB</span>
    </div>

    <!-- Menu -->
    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                    </svg>
                    Manage
                </a>
            </li>

            <li>
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5.121 17.804A4 4 0 1112 21a4 4 0 01-6.879-3.196zM12 3v4m0 4v4" />
                    </svg>
                    Userinfo
                </a>
            </li>

            <li>
                <a href="<?php echo e(route('product')); ?>" class="<?php echo e(request()->routeIs('product') ? 'active' : ''); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 13V9a1 1 0 00-1-1h-4V4H9v4H5a1 1 0 00-1 1v4H2l10 9 10-9h-2z" />
                    </svg>
                    Product
                </a>
            </li>

            <li>
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h18v4H3zM4 7h16v10H4zM5 17h14v2H5z" />
                    </svg>
                    Order
                </a>
            </li>

            <li>
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6V4m0 16v-2m8-8h2M4 12H2m15.364-7.364l1.414 1.414M5.636 18.364l1.414-1.414M18.364 18.364l-1.414-1.414M5.636 5.636l1.414 1.414" />
                    </svg>
                    System
                </a>
            </li>

            <li>
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m9-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Setting
                </a>
            </li>
        </ul>
    </nav>
</aside>
<?php /**PATH C:\petergwapo\Taghoy\BSIT-3A-IPT2\Taghoy-Laravel-Homepage-User\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>