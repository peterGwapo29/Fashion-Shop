<x-app-layout>
  <x-slot name="header">
    <div class="dash-head">
      <div>
        <h2 class="dash-title">Admin Dashboard</h2>
        <p class="dash-sub">Overview of orders, sales, and product performance</p>
      </div>
    </div>
  </x-slot>

  <meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <div class="dash-page">

    {{-- Cards --}}
    <div class="dash-cards">
      <div class="dash-card">
        <p class="card-label">Total Orders</p>
        <p class="card-value">{{ $totalOrders }}</p>
        <button class="card-link" data-open="ordersModal">View Details</button>
      </div>

      <div class="dash-card">
        <p class="card-label">Cancelled Products (Qty)</p>
        <p class="card-value">{{ $cancelledProductsQty }}</p>
        <button class="card-link" data-open="ordersModal">See Orders</button>
      </div>

      <div class="dash-card">
        <p class="card-label">Total Sales</p>
        <p class="card-value">₱{{ number_format($totalSales, 2) }}</p>
        <button class="card-link" data-open="salesModal">View Breakdown</button>
      </div>
    </div>

    {{-- Charts --}}
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

    {{-- Recent Orders quick list --}}
    <div class="panel">
      <div class="panel-head">
        <h3>Latest Orders</h3>
        <p>Quick preview (full list in table).</p>
      </div>

      <div class="mini-table">
        <div class="mini-row mini-head">
          <span>Order</span><span>Customer</span><span>Total</span><span>Status</span>
        </div>
        @foreach($latestOrders as $o)
          <div class="mini-row">
            <span>#{{ $o->id }}</span>
            <span>{{ $o->user?->first_name }} {{ $o->user?->last_name }}</span>
            <span>₱{{ number_format($o->total,2) }}</span>
            <span class="pill pill-{{ strtolower($o->status) }}">{{ strtoupper($o->status) }}</span>
          </div>
        @endforeach
      </div>
    </div>

  </div>

  {{-- MODAL: Orders table --}}
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

  {{-- MODAL: Sales breakdown (uses same orders table filtered client-side if you want) --}}
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

  {{-- MODAL: Marketable --}}
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

  {{-- MODAL: Non-marketable --}}
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
</x-app-layout>
