@extends('layouts.cart-layout')

@section('title', 'My Cart')

@section('content')
<div class="cart-container">
    <h2>Your Shopping Cart</h2>

    @if($cartItems->isEmpty())
        <p class="empty-message">Your cart is empty.</p>
    @else
    <div class="cart-wrapper">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td class="product-info">
                        <img src="/storage/{{ $item->product->image }}" alt="{{ $item->product->name }}">
                        <span>{{ $item->product->name }}</span>
                    </td>
                    <td>₱{{ number_format($item->unit_price, 2) }}</td>
                    <td>
                        <form action="{{ route('cart.update') }}" method="POST" class="qty-form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                    <td>₱{{ number_format($item->subtotal, 2) }}</td>
                    <td>
                        <button class="btn-delete" onclick="deleteCartItem({{ $item->id }})">Remove</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="cart-total">
            <h3>Total: ₱{{ number_format($cartItems->sum('subtotal'), 2) }}</h3>
            <a href="{{ route('welcome') }}" class="btn-continue">Continue Shopping</a>
            <a href="{{ route('checkout.show') }}" class="btn-checkout">Proceed to Checkout</a>
            @if(!$cartItems->isEmpty())
                <button class="btn-clear-all" onclick="clearAllCart()">Clear All</button>
            @endif
        </div>

    </div>
    @endif
</div>
@endsection

@push('styles')
<style>

</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src=" {{ asset('JS/user/cart.js') }}"></script>
</script>
@endpush
