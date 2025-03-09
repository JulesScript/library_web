<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Research;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ResearchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $courseId = $request->input('course_id');

            // Eager load both the yearlevel and category relationships via course
            $researches = Research::with(['course.yearlevel', 'course.category'])
                ->select(['id', 'course_id', 'file_path', 'file_name', 'file_type', 'uploaded_by', 'created_at'])
                ->when($courseId, function ($query) use ($courseId) {
                    return $query->where('course_id', $courseId);
                })
                ->orderBy('created_at', 'desc');

            return DataTables::of($researches)
                ->addColumn('course_name', function ($research) {
                    return $research->course->name ?? 'N/A';
                })
                ->addColumn('year_level', function ($research) {
                    return $research->course->yearlevel->name ?? 'N/A';
                })
                ->addColumn('category_name', function ($research) {
                    return $research->course->yearlevel->category->name ?? 'N/A';
                })
                ->addColumn('action', function ($research) {
                    return '<a href="/storage/' . $research->file_path . '" target="_blank" class="btn btn-primary btn-sm">View</a>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        // Admin only: Show the research management page
        if (auth()->user()->role === 'admin') {
            $courses = Courses::with('category')->get();
            return view('research.research', compact('courses'));
        }

        abort(403, 'Unauthorized Access');
    }



    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'file_path' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Get file details
        $file = $request->file('file_path');
        $filePath = $file->store('research_files', 'public'); // Store the file in storage/app/public/research_files
        $fileName = $file->getClientOriginalName(); // Get the original file name
        $fileType = $file->getClientMimeType(); // Get the file type

        // Save research data in the database
        Research::create([
            'course_id' => $request->course_id,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'uploaded_by' => auth()->id(), // Save the user ID of the uploader
        ]);

        return back()->with('success', 'Research file uploaded successfully!');
    }
}
