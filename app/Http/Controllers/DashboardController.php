<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ✅ totals (cards)
        $totalOrders = Order::count();

        // “cancelled products” = total qty in cancelled orders (safer than just count of products)
        $cancelledProductsQty = OrderItem::whereHas('order', fn($q) => $q->where('status', 'cancelled'))
            ->sum('quantity');

        // total sales = sum of completed/paid/shipped (adjust based on your flow)
        $totalSales = Order::whereIn('status', ['paid', 'completed', 'shipped'])
            ->sum('total');

        // quick lists
        $latestOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalOrders',
            'cancelledProductsQty',
            'totalSales',
            'latestOrders'
        ));
    }

    /**
     * Chart overview:
     * - Orders per month
     * - Sales per month
     * - Marketable vs Non-marketable counts
     */
    public function chartOverview()
    {
        // Orders per month (last 6 months)
        $ordersByMonth = Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as cnt")
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('ym')
            ->orderBy('ym')
            ->get();

        // Sales per month (only paid/completed/shipped)
        $salesByMonth = Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COALESCE(SUM(total),0) as total")
            ->whereIn('status', ['paid', 'completed', 'shipped'])
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('ym')
            ->orderBy('ym')
            ->get();

        // Marketable / non-marketable (based on sold qty)
        // marketable = sold_qty >= 10, non = sold_qty < 10 (change threshold anytime)
        $sold = OrderItem::selectRaw("product_id, SUM(quantity) as sold_qty")
            ->groupBy('product_id');

        $marketableCount = DB::query()->fromSub($sold, 's')
            ->where('sold_qty', '>=', 10)
            ->count();

        $nonMarketableCount = DB::query()->fromSub($sold, 's')
            ->where('sold_qty', '<', 10)
            ->count();

        // Align labels
        $labels = collect(range(0, 5))
            ->map(fn($i) => now()->subMonths(5 - $i)->format('Y-m'))
            ->values();

        $ordersMap = $ordersByMonth->keyBy('ym')->map->cnt;
        $salesMap  = $salesByMonth->keyBy('ym')->map->total;

        return response()->json([
            'labels' => $labels,
            'orders' => $labels->map(fn($m) => (int)($ordersMap[$m] ?? 0)),
            'sales'  => $labels->map(fn($m) => (float)($salesMap[$m] ?? 0)),
            'marketable' => $marketableCount,
            'non_marketable' => $nonMarketableCount,
        ]);
    }

    // Data table: orders
    public function tableOrders(Request $request)
    {
        // Simple server-side format (works with DataTables)
        $q = Order::with('user')->latest();

        $total = $q->count();

        $start = (int) $request->get('start', 0);
        $len   = (int) $request->get('length', 10);

        $data = $q->skip($start)->take($len)->get()->map(function ($o) {
            return [
                'id' => $o->id,
                'customer' => $o->user ? ($o->user->first_name.' '.$o->user->last_name) : ('User #'.$o->user_id),
                'email' => $o->user?->email ?? '-',
                'payment_method' => $o->payment_method ?? '-',
                'payment_reference' => $o->payment_reference ?? '-',
                'total' => (float)$o->total,
                'status' => $o->status,
                'date' => $o->created_at->format('M d, Y'),
            ];
        });

        return response()->json([
            'draw' => (int) $request->get('draw', 1),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data,
        ]);
    }

    // Data table: marketable products (top sold)
    public function tableMarketable(Request $request)
    {
        $base = Product::query()
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->selectRaw("products.id, products.name, products.price, COALESCE(SUM(order_items.quantity),0) as sold_qty")
            ->groupBy('products.id', 'products.name', 'products.price')
            ->havingRaw("COALESCE(SUM(order_items.quantity),0) >= 10")
            ->orderByDesc('sold_qty');

        return $this->datatableResponse($request, $base);
    }

    // Data table: non-marketable products (low sold)
    public function tableNonMarketable(Request $request)
    {
        $base = Product::query()
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->selectRaw("products.id, products.name, products.price, COALESCE(SUM(order_items.quantity),0) as sold_qty")
            ->groupBy('products.id', 'products.name', 'products.price')
            ->havingRaw("COALESCE(SUM(order_items.quantity),0) < 10")
            ->orderBy('sold_qty');

        return $this->datatableResponse($request, $base);
    }

    private function datatableResponse(Request $request, $query)
    {
        $total = $query->count(); // ok for grouped query in MySQL most cases

        $start = (int) $request->get('start', 0);
        $len   = (int) $request->get('length', 10);

        $rows = $query->skip($start)->take($len)->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => (float)$p->price,
                'sold_qty' => (int)$p->sold_qty,
            ];
        });

        return response()->json([
            'draw' => (int) $request->get('draw', 1),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $rows,
        ]);
    }

    // Optional: update order status directly from dashboard
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,paid,completed,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Updated', 'status' => $order->status], 200);
    }
}
