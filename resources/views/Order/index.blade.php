@extends('layouts.cart-layout')
@section('title', 'My Orders')

@section('content')
<div class="orders-page">
  <div class="orders-header">
    <div>
      <h2>My Orders</h2>
      <p class="sub">View your purchase history and download receipts.</p>
    </div>

    <a href="{{ route('welcome') }}" class="btn-outline">
      <i class="fa-solid fa-bag-shopping"></i> Continue Shopping
    </a>
  </div>

  @if($orders->isEmpty())
    <div class="empty-box">
      <h3>No orders yet</h3>
      <p>Your orders will appear here after checkout.</p>
      <a href="{{ route('welcome') }}" class="btn-primary">Shop Now</a>
    </div>
  @else
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
          @foreach($orders as $order)
            <tr>
              <td class="mono">#{{ $order->id }}</td>
              <td>
                <span class="badge {{ $order->status === 'paid' ? 'paid' : 'pending' }}">
                  {{ strtoupper($order->status) }}
                </span>
              </td>
              <td class="bold">₱{{ number_format($order->total, 2) }}</td>
              <td>{{ $order->created_at->format('M d, Y') }}</td>
              <td>
                <a class="btn-view" href="{{ route('orders.show', $order->id) }}">
                  View Receipt
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
@endpush
