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
    <div class="dashboard-layout">
        <!-- Main Content -->
        <main class="dashboard-content">
            <!-- Top bar -->
            <div class="topbar">
                <h2>Dashboard</h2>
                <div class="user-info">
                    <span>Hi, Admin</span>
                </div>
            </div>

            <!-- Cards Grid -->
            <div class="cards-grid">
                <div class="card">
                    <p class="card-label">Sales</p>
                    <p class="card-value">67,343</p>
                </div>
                <div class="card">
                    <p class="card-label">Purchases</p>
                    <p class="card-value">2,343</p>
                </div>
                <div class="card">
                    <p class="card-label">Orders</p>
                    <p class="card-value">35,343</p>
                </div>
            </div>

            <!-- Overview Grid -->
            <div class="overview-grid">
                <div class="overview-card">
                    <h3>Overview</h3>
                    <p>Member Profit</p>
                    <p>+2345</p>
                </div>
                <div class="overview-card center">
                    <h3>Total Sale</h3>
                    <div class="chart-circle">
                        <span>70%</span>
                    </div>
                </div>
                <div class="overview-card">
                    <h3>Activity</h3>
                    <ul>
                        <li>✔ New Order received</li>
                        <li>✔ Payment confirmed</li>
                        <li>✔ Delivery Scheduled</li>
                    </ul>
                </div>
            </div>

            <!-- Chart -->
            <div class="chart-card">
                <h3>Monthly Sales Overview</h3>
                <canvas id="salesChart"></canvas>
            </div>
        </main>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov'],
                datasets: [{
                    label: 'Sales',
                    data: [40,60,80,130,60,50,60,50,50],
                    backgroundColor: getComputedStyle(document.documentElement)
                        .getPropertyValue('--primary-color').trim(),
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
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