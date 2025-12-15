@extends('layouts.cart-layout')
@section('title', 'Payment')

@section('content')
<div class="payment-container">
  <h2>Choose Payment Method</h2>
  <p>Order #{{ $order->id }} • ₱{{ number_format($order->total, 2) }}</p>

  <form method="POST" action="{{ route('payment.submit', $order->id) }}">
    @csrf

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
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endpush

@push('scripts')
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
@endpush
