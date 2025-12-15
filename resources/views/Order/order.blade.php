<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Management') }}
        </h2>
    </x-slot>

    <div class="order-layout">
        <!-- Main Content -->
        <main class="order-content">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Status:</strong> {{ $order->status }}</p>
            <p><strong>Total:</strong> ₱{{ number_format($order->total, 2) }}</p>
        </main>
    </div>

</x-app-layout>
