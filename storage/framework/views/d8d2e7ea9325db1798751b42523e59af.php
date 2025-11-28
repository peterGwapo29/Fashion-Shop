<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Cart'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/wishlist.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/cart.css')); ?>">

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="container">
        <a href="<?php echo e(route('welcome')); ?>" style="display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <img src="/images/logo.png" alt="Fashion Store Logo" class="logo" style="width: 150px; height: auto;">
        </a>
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\petergwapo\FashionStore\resources\views/layouts/cart-layout.blade.php ENDPATH**/ ?>