<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('Category.category');
    }

    public function list(Request $request)
    {
        $query = Category::query()->select(['category_id', 'category_name', 'description', 'status']);

        return datatables()
            ->of($query)
            ->addColumn('actions', function ($row) {
                $isInactive = strtolower($row->status) === 'inactive';

                $editBtn = '<button class="btn-edit" data-id="'.$row->category_id.'">Edit</button>';

                if ($isInactive) {
                    $toggleBtn = '<button class="btn-restore" data-id="'.$row->category_id.'">Restore</button>';
                } else {
                    $toggleBtn = '<button class="btn-delete" data-id="'.$row->category_id.'">Delete</button>';
                }

                return '<div class="button-group">'.$editBtn.$toggleBtn.'</div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $data['status'] = 'active';

        Category::create($data);

        return response()->json(['message' => 'Category created successfully.']);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $category->update($data);

        return response()->json(['message' => 'Category updated successfully.']);
    }

    public function destroy(Category $category)
    {
        $category->update(['status' => 'inactive']);

        return response()->json(['message' => 'Category set to inactive.']);
    }

    public function restore(Category $category)
    {
        $category->update(['status' => 'active']);

        return response()->json(['message' => 'Category restored successfully.']);
    }
}
