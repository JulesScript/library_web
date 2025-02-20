<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Courses;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CoursesController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        // Handle the AJAX request for DataTables (used for settings-courses)
        if ($request->ajax() && $request->is('settings-courses*')) {
            // Eager load category relationship
            $courses = Courses::with('category')->select(['id', 'category_id', 'name', 'created_at']);

            return DataTables::of($courses)
                ->addColumn('category_name', function ($course) {
                    return $course->category->name ?? 'No Category'; // Get category name, handle null case
                })
                ->addColumn('action', function ($course) {
                    return '<button class="btn btn-danger delete-courses" data-id="' . $course->id . '">Delete</button>';
                })
                ->rawColumns(['action']) // Ensure the button is rendered correctly as raw HTML
                ->make(true);
        }

        // Handle the regular request for showing courses (for show-courses route)
        if ($request->is('show-courses*')) {
            $courses = Courses::with('category')->get(); // Eager load category relationship
            return view('courses.show-courses', compact('courses'));
        }

        return view('courses.settings-courses', compact('categories'));
    }


    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'category_id' => 'required|integer|exists:categories,id', // Ensure it exists in the database
            'course_name' => 'required|string|max:255'
        ]);

        // Create the course
        $course = Courses::create([
            'category_id' => $request->category_id,
            'name' => $request->course_name,
        ]);

        return response()->json(['settings-courses' => $course]);
    }

    public function destroy($id)
    {
        $courses = Courses::findOrFail($id); // Find the courses by ID

        try {
            $courses->delete(); // Delete the courses
            return response()->json(['success' => 'courses deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting courses.'], 500);
        }
    }

    public function filterCourses(Request $request)
    {
        $courses = Courses::where('category_id', $request->category_id)->get();
        return response()->json(['courses' => $courses]);
    }
    
    public function filterByYear(Request $request)
    {
        $courses = Courses::where('year_level_id', $request->year_id)->get();
        return response()->json(['courses' => $courses]);
    }
    

}
