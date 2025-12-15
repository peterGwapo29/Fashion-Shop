<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
   <?php $__env->slot('header', null, []); ?> 
    <div class="dash-head">
      <div>
        <h2 class="dash-title">Admin Dashboard</h2>
        <p class="dash-sub">Overview of orders, sales, and product performance</p>
      </div>
    </div>
   <?php $__env->endSlot(); ?>

  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
  <div class="dash-page">

    
    <div class="dash-cards">
      <div class="dash-card">
        <p class="card-label">Total Orders</p>
        <p class="card-value"><?php echo e($totalOrders); ?></p>
        <button class="card-link" data-open="ordersModal">View Details</button>
      </div>

      <div class="dash-card">
        <p class="card-label">Cancelled Products (Qty)</p>
        <p class="card-value"><?php echo e($cancelledProductsQty); ?></p>
        <button class="card-link" data-open="ordersModal">See Orders</button>
      </div>

      <div class="dash-card">
        <p class="card-label">Total Sales</p>
        <p class="card-value">₱<?php echo e(number_format($totalSales, 2)); ?></p>
        <button class="card-link" data-open="salesModal">View Breakdown</button>
      </div>
    </div>

    
    <div class="dash-grid">
      <div class="panel">
        <div class="panel-head">
          <h3>Orders & Sales (Last 6 Months)</h3>
          <p>Click the chart to open the table.</p>
        </div>
        <canvas id="ordersSalesChart" height="120"></canvas>
      </div>

      <div class="panel">
        <div class="panel-head">
          <h3>Marketable vs Non-Marketable</h3>
          <p>Click bars to view product tables.</p>
        </div>
        <canvas id="marketChart" height="120"></canvas>
      </div>
    </div>

    
    <div class="panel">
      <div class="panel-head">
        <h3>Latest Orders</h3>
        <p>Quick preview (full list in table).</p>
      </div>

      <div class="mini-table">
        <div class="mini-row mini-head">
          <span>Order</span><span>Customer</span><span>Total</span><span>Status</span>
        </div>
        <?php $__currentLoopData = $latestOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="mini-row">
            <span>#<?php echo e($o->id); ?></span>
            <span><?php echo e($o->user?->first_name); ?> <?php echo e($o->user?->last_name); ?></span>
            <span>₱<?php echo e(number_format($o->total,2)); ?></span>
            <span class="pill pill-<?php echo e(strtolower($o->status)); ?>"><?php echo e(strtoupper($o->status)); ?></span>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>

  </div>

  
  <div class="modal-overlay hidden" id="ordersModal">
    <div class="modal-box wide">
      <div class="modal-top">
        <h3>Orders Table</h3>
        <button class="modal-close" data-close="ordersModal">✕</button>
      </div>

      <table id="ordersTable" class="dt-table">
        <thead>
          <tr>
            <th>Order</th><th>Customer</th><th>Email</th><th>Payment</th><th>Ref</th><th>Total</th><th>Status</th><th>Date</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  
  <div class="modal-overlay hidden" id="salesModal">
    <div class="modal-box wide">
      <div class="modal-top">
        <h3>Sales Breakdown</h3>
        <button class="modal-close" data-close="salesModal">✕</button>
      </div>
      <p class="modal-hint">Showing orders that are PAID / SHIPPED / COMPLETED.</p>

      <table id="salesTable" class="dt-table">
        <thead>
          <tr>
            <th>Order</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  
  <div class="modal-overlay hidden" id="marketableModal">
    <div class="modal-box wide">
      <div class="modal-top">
        <h3>Most Marketable Products</h3>
        <button class="modal-close" data-close="marketableModal">✕</button>
      </div>

      <table id="marketableTable" class="dt-table">
        <thead>
          <tr><th>ID</th><th>Name</th><th>Price</th><th>Sold Qty</th></tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  
  <div class="modal-overlay hidden" id="nonMarketableModal">
    <div class="modal-box wide">
      <div class="modal-top">
        <h3>Non-Marketable Products</h3>
        <button class="modal-close" data-close="nonMarketableModal">✕</button>
      </div>

      <table id="nonMarketableTable" class="dt-table">
        <thead>
          <tr><th>ID</th><th>Name</th><th>Price</th><th>Sold Qty</th></tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\petergwapo\FashionStore\resources\views/dashboard.blade.php ENDPATH**/ ?>