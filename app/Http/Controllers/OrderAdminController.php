<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderAdminController extends Controller
{
    public function index()
    {
        return view('OrderAdmin.order'); // ✅ your folder
    }

    // ✅ Orders list for DataTables
    public function datatable(Request $request)
    {
        $query = Order::query()
            ->with('user')
            ->select('orders.*');

        return DataTables::of($query)
            ->addColumn('customer', function ($o) {
                return $o->user
                    ? trim(($o->user->first_name ?? '').' '.($o->user->last_name ?? '')).' ('.$o->user->email.')'
                    : 'User #'.$o->user_id;
            })
            ->make(true);
    }

    // ✅ Order items (for expand row)
    public function items(Order $order)
    {
        $items = OrderItem::where('order_id', $order->id)
            ->with('product')
            ->get()
            ->map(function ($it) {
                return [
                    'product'  => $it->product ? $it->product->name : 'Product #'.$it->product_id,
                    'price'    => (float) $it->unit_price,
                    'qty'      => (int) $it->quantity,
                    'subtotal' => (float) $it->subtotal,
                    'image'    => $it->product?->image,
                ];
            });

        return response()->json([
            'order_id' => $order->id,
            'items' => $items
        ], 200);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,paid,completed,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        return response()->json([
            'message' => 'Status updated',
            'status' => $order->status
        ]);
    }
}
