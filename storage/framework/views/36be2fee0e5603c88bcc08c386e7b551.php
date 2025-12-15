
<?php $__env->startSection('title', 'Order Receipt'); ?>

<?php $__env->startSection('content'); ?>
<div class="receipt-page">
  <div class="receipt-card">
    <div class="receipt-top">
      <div>
        <h2>Order Receipt</h2>
        <p class="sub">Order #<?php echo e($order->id); ?></p>
      </div>

      <span class="badge <?php echo e($order->status === 'paid' ? 'paid' : 'pending'); ?>">
        <?php echo e(strtoupper($order->status)); ?>

      </span>
    </div>

    <div class="receipt-grid">
      <div class="receipt-box">
        <h4>Summary</h4>
        <p><strong>Total:</strong> ₱<?php echo e(number_format($order->total, 2)); ?></p>
        <p><strong>Payment:</strong> <?php echo e($order->payment_method ?? 'Not set'); ?></p>
        <p><strong>Reference:</strong> <?php echo e($order->payment_reference ?? '—'); ?></p>
        <p><strong>Date:</strong> <?php echo e($order->created_at->format('M d, Y h:i A')); ?></p>
      </div>

      <div class="receipt-box">
        <h4>Actions</h4>
        <div class="receipt-actions">
          <a href="<?php echo e(route('orders.index')); ?>" class="btn-outline">Back to My Orders</a>
          <a href="<?php echo e(route('welcome')); ?>" class="btn-primary">Continue Shopping</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/receipt.css')); ?>">
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.cart-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\petergwapo\FashionStore\resources\views/Order/receipt.blade.php ENDPATH**/ ?>