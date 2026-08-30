<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string'
        ]);

        try {
            $category = Category::create([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => Str::slug($request->name)
            ]);

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'add_category',
                'Categories',
                'Added new category: ' . $category->name,
                'Success'
            );

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Category created successfully',
                    'category' => $category
                ], 201);
            }

            return redirect()->route('categories.index')
                ->with('success', 'Category created successfully.');
                
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to create category: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to create category.');
        }
    }

    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }
    
    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string'
        ]);

        try {
            $oldName = $category->name;
            
            $category->update([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => Str::slug($request->name)
            ]);

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'update_category',
                'Categories',
                'Updated category: ' . $oldName . ' → ' . $category->name,
                'Success'
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Category updated successfully',
                'category' => $category
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update category: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Category $category)
    {
        try {
            $categoryName = $category->name;
            
            $category->delete();

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'delete_category',
                'Categories',
                'Deleted category: ' . $categoryName,
                'Success'
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Category deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete category: ' . $e->getMessage()
            ], 500);
        }
    }
}