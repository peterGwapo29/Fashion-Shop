<x-app-layout>
  <x-slot name="header">
    <div class="oa-head">
      <div>
        <h2 class="oa-title">Order Management</h2>
        <p class="oa-sub">View orders, expand to see items, and update status.</p>
      </div>
    </div>
  </x-slot>

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/orderAdmin.css') }}">

  <div class="oa-page">
    <div class="oa-panel">
      <div class="oa-panel-top">
        <h3>Orders</h3>
        <p>Click the + icon to expand and view order items.</p>
      </div>

      <div class="oa-table-wrap">
        <table id="orderTable" class="oa-table">
          <thead>
            <tr>
              <th class="oa-col-control"></th>
              <th>Order ID</th>
              <th>Customer</th>
              <th>Payment Method</th>
              <th>Payment Ref</th>
              <th>Total</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

</x-app-layout>
