@extends('layouts.cart-layout')
@section('title', 'Checkout')

@section('content')
<div class="checkout-container">
  <div class="checkout-header">
    <h2>Checkout</h2>
    <p class="sub">Review your items and confirm delivery details.</p>
  </div>

  <div class="checkout-grid">
    <div class="card">
      <h3 class="card-title">Delivery Information</h3>

      <form method="POST" action="{{ route('checkout.placeOrder') }}" class="form">
        @csrf

        <div class="form-group">
          <label>Address</label>
          <input type="text" name="address"
                 value="{{ old('address', auth()->user()->address) }}" required>
        </div>

        <div class="form-group">
          <label>Contact Number</label>
          <input type="text" name="contact_number"
                 value="{{ old('contact_number', auth()->user()->contact_number) }}" required>
        </div>

        <button type="submit" class="btn-primary">Place Order</button>
      </form>
    </div>

    <div class="card">
      <h3 class="card-title">Order Summary</h3>

      @foreach($cartItems as $item)
        <div class="summary-item">
          <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
          <strong>₱{{ number_format($item->subtotal, 2) }}</strong>
        </div>
      @endforeach

      <div class="summary-total">
        <span>Total</span>
        <strong>₱{{ number_format($total, 2) }}</strong>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush
