<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Add product to wishlist
    public function add(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->product_id;

        $exists = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($exists) {
            return response()->json(['status' => 'info', 'message' => 'Already in wishlist']);
        }

        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        return response()->json(['status' => 'success', 'message' => 'Added to wishlist']);
    }

    // View wishlist page
    public function view()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product.category')
            ->get();

        $categories = \App\Models\Category::all();

        return view('Wishlist.wishlist', compact('wishlistItems', 'categories'));
    }


    // Remove item
    public function remove($id)
    {
        Wishlist::findOrFail($id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Removed from wishlist']);
    }

    public function count()
    {
        $count = \App\Models\Wishlist::where('user_id', auth()->id())->count();
        return response()->json(['count' => $count]);
    }

    public function clearAll()
    {
        $userId = auth()->id();
        \App\Models\Wishlist::where('user_id', $userId)->delete();

        return response()->json([
            'message' => 'All items have been removed from your wishlist.'
        ]);
    }

}
