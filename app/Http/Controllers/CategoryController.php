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
        // Handle the AJAX request for DataTables (used for settings-categories)
        if ($request->ajax() && $request->is('settings-categories*')) {
            $categories = Category::select(['id', 'name', 'created_at']);

            return DataTables::of($categories)
                ->addColumn('action', function ($category) {
                    // Button for deleting category
                    return '<button class="btn btn-danger delete-category" data-id="' . $category->id . '">Delete</button>';
                })
                ->rawColumns(['action']) // Ensure the button is rendered correctly as raw HTML
                ->make(true);
        }

        // Handle the regular request for showing categories (for show-categories route)
        if ($request->is('show-categories*')) {
            // Get all categories
            $categories = Category::all();

            // Pass categories to the view
            return view('category.show-category', compact('categories'));
        }

        // Default return for settings-categories (you can render the full management page here)
        return view('category.settings-category');
    }



    public function store(Request $request)
    {
        // Validate the category name
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        // Create the category
        $category = Category::create([
            'name' => $request->category_name,
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
