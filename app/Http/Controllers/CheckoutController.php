<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum('subtotal');

        return view('Checkout.checkout', compact('cartItems', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:30',
        ]);

        $user = $request->user();

        $cartItems = CartItem::with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        return DB::transaction(function () use ($user, $cartItems) {
            $total = $cartItems->sum('subtotal');

            $order = Order::create([
                'user_id' => $user->id,
                'status'  => 'pending',
                'total'   => $total,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'unit_price' => $item->unit_price,
                    'quantity'   => $item->quantity,
                    'subtotal'   => $item->subtotal,
                ]);
            }

            // clear cart after order is created
            CartItem::where('user_id', $user->id)->delete();

            // go to payment method page (COD/Bank/E-wallet)
            return redirect()->route('payment.show', $order->id);
        });
    }
}
