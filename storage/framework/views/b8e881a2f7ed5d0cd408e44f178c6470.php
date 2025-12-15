
<?php $__env->startSection('title', 'My Orders'); ?>

<?php $__env->startSection('content'); ?>
<div class="orders-page">
  <div class="orders-header">
    <div>
      <h2>My Orders</h2>
      <p class="sub">View your purchase history and download receipts.</p>
    </div>

    <a href="<?php echo e(route('welcome')); ?>" class="btn-outline">
      <i class="fa-solid fa-bag-shopping"></i> Continue Shopping
    </a>
  </div>

  <?php if($orders->isEmpty()): ?>
    <div class="empty-box">
      <h3>No orders yet</h3>
      <p>Your orders will appear here after checkout.</p>
      <a href="<?php echo e(route('welcome')); ?>" class="btn-primary">Shop Now</a>
    </div>
  <?php else: ?>
    <div class="orders-card">
      <table class="orders-table">
        <thead>
          <tr>
            <th>Order</th>
            <th>Status</th>
            <th>Total</th>
            <th>Date</th>
            <th>Receipt</th>
          </tr>
        </thead>
        <tbody>
          <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td class="mono">#<?php echo e($order->id); ?></td>
              <td>
                <span class="badge <?php echo e($order->status === 'paid' ? 'paid' : 'pending'); ?>">
                  <?php echo e(strtoupper($order->status)); ?>

                </span>
              </td>
              <td class="bold">₱<?php echo e(number_format($order->total, 2)); ?></td>
              <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
              <td>
                <a class="btn-view" href="<?php echo e(route('orders.show', $order->id)); ?>">
                  View Receipt
                </a>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/orders.css')); ?>">
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.cart-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\petergwapo\FashionStore\resources\views/Order/index.blade.php ENDPATH**/ ?>