<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // ADD PRODUCT TO CART
    public function addToCart(Request $request)
    {
        $user = Auth::id();
        $product = Product::findOrFail($request->product_id);

        // Check if already in cart
        $cartItem = CartItem::where('user_id', $user)
            ->where('product_id', $product->id)
            ->first();

            if (!Auth::check()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please login first.'
                ], 401);
            }


        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->subtotal = $cartItem->quantity * $cartItem->unit_price;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => $user,
                'product_id' => $product->id,
                'quantity' => 1,
                'unit_price' => $product->price,
                'subtotal' => $product->price
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart!'
        ]);
    }

    // VIEW CART PAGE
    public function viewCart()
    {
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with('product')
            ->get();

        return view('Cart.cart', compact('cartItems'));
    }

    // UPDATE CART QUANTITY
    public function updateCart(Request $request)
    {
        $item = CartItem::find($request->id);

        if ($item) {
            $item->quantity = $request->quantity;
            $item->subtotal = $item->quantity * $item->unit_price;
            $item->save();
        }

        return back()->with('success', 'Cart updated!');
    }

    // DELETE ITEM FROM CART
    public function deleteItem($id)
    {
        CartItem::find($id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Item removed from cart'
        ]);
    }

    public function count() {
        $count = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity');
        return response()->json(['count' => $count]);
    }

    public function clearAll()
    {
        $userId = auth()->id();
        \App\Models\CartItem::where('user_id', $userId)->delete();

        return response()->json([
            'message' => 'All items have been removed from your cart.'
        ]);
    }


}
