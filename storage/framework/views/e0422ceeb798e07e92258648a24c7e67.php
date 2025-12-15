
<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('content'); ?>
<div class="checkout-container">
  <div class="checkout-header">
    <h2>Checkout</h2>
    <p class="sub">Review your items and confirm delivery details.</p>
  </div>

  <div class="checkout-grid">
    <div class="card">
      <h3 class="card-title">Delivery Information</h3>

      <form method="POST" action="<?php echo e(route('checkout.placeOrder')); ?>" class="form">
        <?php echo csrf_field(); ?>

        <div class="form-group">
          <label>Address</label>
          <input type="text" name="address"
                 value="<?php echo e(old('address', auth()->user()->address)); ?>" required>
        </div>

        <div class="form-group">
          <label>Contact Number</label>
          <input type="text" name="contact_number"
                 value="<?php echo e(old('contact_number', auth()->user()->contact_number)); ?>" required>
        </div>

        <button type="submit" class="btn-primary">Place Order</button>
      </form>
    </div>

    <div class="card">
      <h3 class="card-title">Order Summary</h3>

      <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="summary-item">
          <span><?php echo e($item->product->name); ?> × <?php echo e($item->quantity); ?></span>
          <strong>₱<?php echo e(number_format($item->subtotal, 2)); ?></strong>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      <div class="summary-total">
        <span>Total</span>
        <strong>₱<?php echo e(number_format($total, 2)); ?></strong>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/checkout.css')); ?>">
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.cart-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\petergwapo\FashionStore\resources\views/Checkout/checkout.blade.php ENDPATH**/ ?>