<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{ 
    public function index(){
        $categories = Category::all(); 
        $products = Product::where('status', 'active')->get();
        return view('Product.product', compact('categories'));
    }

    public function user_index(){
        return response()->json(Product::all(), 200);
    }

    public function product_datatables(){
        $products = Product::select(['id', 'name', 'price', 'category_id', 'stock', 'image', 'status']);

        return DataTables::of($products)
        ->addColumn('category', function($product) {
            return $product->category ? $product->category->category_name : 'N/A';
        })
        ->make(true);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|string|max:255',
            'stock' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status' => 'nullable|string|active',
        ]);

        $validated['status'] = $validated['status'] ?? 'active';

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('products', 'public'); // saved in storage/app/public/products
            $validated['image'] = $path;
        }

        // Create product
        $product = Product::create($validated);

        return response()->json([
            'message' => '✅ Product added successfully!',
            'product' => $product,
        ]);
    }

    public function update(Request $request, $id){
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => '❌ Product not found.'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|string|max:255',
            'stock' => 'nullable|integer',
            'status' => 'nullable|string|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $validated['stock'] = $validated['stock'] ?? 0;
        $validated['status'] = $validated['status'] ?? $product->status;

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('products', 'public');
            $validated['image'] = $path;
        } else {
            $validated['image'] = $product->image;
        }

        $product->update($validated);

        return response()->json([
            'message' => '✅ Product updated successfully!',
            'product' => $product
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => '❌ Product not found.'
            ], 404);
        }

        // Set status to inactive instead of deleting
        $product->status = 'inactive';
        $product->save();

        return response()->json([
            'message' => '✅ Product set to inactive successfully!',
            'product' => $product
        ], 200);
    }

     public function filterProducts(Request $request)
    {
        $category = $request->category;
        $sort = $request->sort;

        $query = Product::where('status', 'active');

        // CATEGORY FILTER
        if ($category && $category !== 'all') {
            $query->whereHas('category', function ($q) use ($category) {
                $q->whereRaw('LOWER(category_name) = ?', [$category]);
            });
        }

        // SORTING
        switch ($sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;

            case 'highlow':
                $query->orderBy('price', 'desc');
                break;

            case 'lowhigh':
                $query->orderBy('price', 'asc');
                break;

            default:
                // Featured (default) – newest first
                $query->orderBy('created_at', 'desc');
                break;
        }

        return response()->json($query->get());
    }

    public function restore($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => '❌ Product not found.'], 404);
        }

        $product->status = 'active';
        $product->save();

        return response()->json([
            'message' => '✅ Product restored successfully!',
            'product' => $product
        ], 200);
    }


}
