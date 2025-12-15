
<?php $__env->startSection('title', 'Payment'); ?>

<?php $__env->startSection('content'); ?>
<div class="payment-container">
  <h2>Choose Payment Method</h2>
  <p>Order #<?php echo e($order->id); ?> • ₱<?php echo e(number_format($order->total, 2)); ?></p>

  <form method="POST" action="<?php echo e(route('payment.submit', $order->id)); ?>">
    <?php echo csrf_field(); ?>

    <label class="pay-option">
      <input type="radio" name="payment_method" value="COD" checked>
      Cash on Delivery
    </label>

    <label class="pay-option">
      <input type="radio" name="payment_method" value="BANK">
      Bank Transfer
    </label>

    <label class="pay-option">
      <input type="radio" name="payment_method" value="EWALLET">
      E-Wallet
    </label>

    <div id="refBox" class="ref-box">
      <label>Reference Number</label>
      <input type="text" name="payment_reference">
    </div>

    <button class="btn-primary">Confirm Payment</button>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/payment.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  const radios = document.querySelectorAll('input[name="payment_method"]');
  const refBox = document.getElementById('refBox');

  function toggleRef() {
    const val = document.querySelector('input[name="payment_method"]:checked').value;
    refBox.style.display = (val === 'BANK' || val === 'EWALLET') ? 'block' : 'none';
  }

  radios.forEach(r => r.addEventListener('change', toggleRef));
  toggleRef();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.cart-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\petergwapo\FashionStore\resources\views/Payment/payment.blade.php ENDPATH**/ ?>