

<?php $__env->startSection('title', 'My Cart'); ?>

<?php $__env->startSection('content'); ?>
<div class="cart-container">
    <h2>Your Shopping Cart</h2>

    <?php if($cartItems->isEmpty()): ?>
        <p class="empty-message">Your cart is empty.</p>
    <?php else: ?>
    <div class="cart-wrapper">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="product-info">
                        <img src="/storage/<?php echo e($item->product->image); ?>" alt="<?php echo e($item->product->name); ?>">
                        <span><?php echo e($item->product->name); ?></span>
                    </td>
                    <td>₱<?php echo e(number_format($item->unit_price, 2)); ?></td>
                    <td>
                        <form action="<?php echo e(route('cart.update')); ?>" method="POST" class="qty-form">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                            <input type="number" name="quantity" value="<?php echo e($item->quantity); ?>" min="1">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                    <td>₱<?php echo e(number_format($item->subtotal, 2)); ?></td>
                    <td>
                        <button class="btn-delete" onclick="deleteCartItem(<?php echo e($item->id); ?>)">Remove</button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <div class="cart-total">
            <h3>Total: ₱<?php echo e(number_format($cartItems->sum('subtotal'), 2)); ?></h3>
            <a href="<?php echo e(route('welcome')); ?>" class="btn-continue">Continue Shopping</a>
            <a href="<?php echo e(route('checkout.show')); ?>" class="btn-checkout">Proceed to Checkout</a>
            <?php if(!$cartItems->isEmpty()): ?>
                <button class="btn-clear-all" onclick="clearAllCart()">Clear All</button>
            <?php endif; ?>
        </div>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>

</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src=" <?php echo e(asset('JS/user/cart.js')); ?>"></script>
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.cart-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\petergwapo\FashionStore\resources\views/Cart/cart.blade.php ENDPATH**/ ?>