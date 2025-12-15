@extends('layouts.cart-layout')
@section('title', 'Order Receipt')

@section('content')
<div class="receipt-page">
  <div class="receipt-card">
    <div class="receipt-top">
      <div>
        <h2>Order Receipt</h2>
        <p class="sub">Order #{{ $order->id }}</p>
      </div>

      <span class="badge {{ $order->status === 'paid' ? 'paid' : 'pending' }}">
        {{ strtoupper($order->status) }}
      </span>
    </div>

    <div class="receipt-grid">
      <div class="receipt-box">
        <h4>Summary</h4>
        <p><strong>Total:</strong> ₱{{ number_format($order->total, 2) }}</p>
        <p><strong>Payment:</strong> {{ $order->payment_method ?? 'Not set' }}</p>
        <p><strong>Reference:</strong> {{ $order->payment_reference ?? '—' }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
      </div>

      <div class="receipt-box">
        <h4>Actions</h4>
        <div class="receipt-actions">
          <a href="{{ route('orders.index') }}" class="btn-outline">Back to My Orders</a>
          <a href="{{ route('welcome') }}" class="btn-primary">Continue Shopping</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/receipt.css') }}">
@endpush
