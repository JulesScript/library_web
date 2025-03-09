<?php

namespace App\Http\Controllers;

use App\Models\YearLevel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax() && $request->is('settings-grades*')) {
            $grades = YearLevel::with('category')->select(['id', 'category_id', 'name', 'created_at']);

            return DataTables::of($grades)
                ->editColumn('category_id', function ($grade) {
                    return $grade->category ? $grade->category->name : 'N/A';
                })
                ->addColumn('action', function ($grade) {
                    // Button for deleting grade
                    return '<button class="btn btn-danger delete-grade" data-id="' . $grade->id . '">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('grade.settings-grade');
    }

    public function filterYearLevels(Request $request)
    {
        $categoryId = $request->input('category_id');
        $yearlevels = YearLevel::where('category_id', $categoryId)->get();

        return response()->json(['yearlevels' => $yearlevels]);
    }
}
