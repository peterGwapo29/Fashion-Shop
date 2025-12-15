<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(Request $request, Order $order)
    {
        abort_if($order->user_id !== $request->user()->id, 403);

        return view('Payment.payment', compact('order'));
    }

    public function submit(Request $request, Order $order)
    {
        abort_if($order->user_id !== $request->user()->id, 403);

        $request->validate([
            'payment_method' => 'required|in:COD,BANK,EWALLET',
            'payment_reference' => 'nullable|string|max:100', // for BANK/EWALLET
        ]);

        $order->payment_method = $request->payment_method;

        // If user chooses BANK/EWALLET, you can require reference:
        if (in_array($request->payment_method, ['BANK', 'EWALLET'])) {
            $request->validate([
                'payment_reference' => 'required|string|max:100',
            ]);
            $order->payment_reference = $request->payment_reference;
        }

        // COD can stay pending; BANK/EWALLET can also stay pending until “confirmed”
        $order->status = ($request->payment_method === 'COD') ? 'pending' : 'pending';

        $order->save();

        return redirect()->route('orders.index', $order->id)
            ->with('success', 'Payment method saved successfully!');
    }
}
