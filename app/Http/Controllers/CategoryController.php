<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Show the list of categories
    public function index()
    {
        $categories = Category::all(); // Fetch all categories from the database
        return view('category.category', compact('categories'));
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
        return response()->json(['category' => $category]);
    }
}
