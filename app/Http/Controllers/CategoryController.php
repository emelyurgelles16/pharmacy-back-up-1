<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories with pagination.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // ✅ PAGINATION: 30 items per page
        $query = Category::query();

        // ✅ Server-side search (optional)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // ✅ Order by name alphabetically
        $categories = $query->orderBy('name', 'asc')->paginate(30);

        // ✅ LAGING HTML VIEW ANG IBALIK
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
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

    /**
     * Get all categories as JSON (for dropdowns, etc.)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return response()->json($categories);
    }
    
    /**
     * Display the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Remove the specified category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
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