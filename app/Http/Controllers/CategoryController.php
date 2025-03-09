<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    // Show the list of categories

    public function index(Request $request)
    {
        // Filter categories based on the user's education level.
        $educationLvl = auth()->user()->education_level;
        // dd($educationLvl);
        if ($educationLvl === 'shs') {
            $categories = Category::where('name', '!=', 'college')->get();
        } elseif ($educationLvl === 'college') {
            $categories = Category::whereNotIn('name', ['shs', 'senior high school'])->get();
        } else {
            $categories = Category::all();
        }

        // Handle AJAX request for settings-categories (if applicable).
        if ($request->ajax() && $request->is('settings-categories*')) {
            return DataTables::of($categories)
                ->addColumn('action', function ($category) {
                    return '<button class="btn btn-danger delete-category" data-id="' . $category->id . '">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // For show-categories requests, pass the filtered $categories to the view.
        if ($request->is('show-categories*')) {
            return view('category.show-category', compact('categories'));
        }

        // Default: return the settings page, also with the filtered categories.
        return view('category.settings-category', compact('categories'));
    }



    public function store(Request $request)
    {
        // Validate the category name
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        // Create the category
        $category = Category::create([
            'name' => strtolower($request->category_name),
        ]);


        // Return a response with the new category data
        return response()->json(['settings-category' => $category]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id); // Find the category by ID

        try {
            $category->delete(); // Delete the category
            return response()->json(['success' => 'Category deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting category.'], 500);
        }
    }
}
