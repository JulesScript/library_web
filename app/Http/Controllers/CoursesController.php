<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Courses;
use App\Models\YearLevel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CoursesController extends Controller
{
    public function index(Request $request)
    {
        $yearlevels = YearLevel::all();

        if ($request->ajax() && $request->is('settings-courses*')) {
            $courses = Courses::with(['yearlevel.category'])
                ->select([
                    'id',
                    'yearlevel_id',
                    'name as course_name',
                    'created_at'
                ]);

            return DataTables::of($courses)
                ->addColumn('category_name', function ($course) {
                    // Access the category name through the yearlevel relationship.
                    return ($course->yearlevel && $course->yearlevel->category)
                        ? $course->yearlevel->category->name
                        : 'No Category';
                })

                ->addColumn('action', function ($course) {
                    return '<button class="btn btn-danger delete-courses" data-id="' . $course->id . '">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        if ($request->is('show-courses*')) {
            $courses = Courses::with('yearlevel.category')->get();
            return view('courses.show-courses', compact('courses'));
        }

        return view('courses.settings-courses', compact('yearlevels'));
    }




    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'yearlevel_id' => 'required|integer|exists:year_levels,id', // Ensure it exists in the year_levels table
            'course_name'   => 'required|string|max:255'
        ]);

        // Create the course using the correct property name
        $course = Courses::create([
            'yearlevel_id' => $request->yearlevel_id,  // Changed from $request->yearlevelId to $request->yearlevel_id
            'name'         => $request->course_name,
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

    public function filter(Request $request)
    {
        $yearlevelId = $request->input('yearlevel_id');
        $courses = Courses::where('yearlevel_id', $yearlevelId)->get();

        return response()->json(['courses' => $courses]);
    }


    public function filterByYear(Request $request)
    {
        $courses = Courses::where('year_level_id', $request->year_id)->get();
        return response()->json(['courses' => $courses]);
    }
}
