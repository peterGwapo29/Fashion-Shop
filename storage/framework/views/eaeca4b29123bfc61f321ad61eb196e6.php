<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo e(asset('css/product.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/sidebar.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">

        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans antialiased">
       <div class="layout-container">
            <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="content-area">
                <!-- Page Heading -->
                <?php if(isset($header)): ?>
                    <header class="page-header">
                        <div class="header-inner">
                            <?php echo e($header); ?>

                        </div>
                    </header>
                <?php endif; ?>

                <!-- Page Content -->
                <main class="page-content">
                    <?php echo e($slot); ?>

                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
        <script src="<?php echo e(asset('JS/Admin/Product/product.js')); ?>"></script>
        <script src="<?php echo e(asset('JS/Admin/Product/delete.js')); ?>"></script>
        <script src="<?php echo e(asset('JS/Admin/Product/view.js')); ?>"></script>
        <script src="<?php echo e(asset('JS/Admin/Product/edit.js')); ?>"></script>
    </body>
</html>
<?php /**PATH C:\petergwapo\FashionStore\resources\views/layouts/app.blade.php ENDPATH**/ ?>