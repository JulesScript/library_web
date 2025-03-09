<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Courses;
use App\Models\Research;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $educationLvl = auth()->user()->education_level; // e.g., 'shs' or 'college'
        // dd($educationLvl);
        // Build a query to filter research files based on the user's education level.
        $researchQuery = Research::query();

        if ($educationLvl === 'shs') {
            $researchQuery->whereHas('course.yearlevel.category', function ($q) {
                $q->whereIn('name', ['shs', 'senior high school']);
            });
            // dd($educationLvl);
        } elseif ($educationLvl === 'college') {
            $researchQuery->whereHas('course.yearlevel.category', function ($q) {
                $q->where('name', 'college');
            });
            // dd($educationLvl);

        }



        $totalResearchFiles = $researchQuery->count();
        $recentUploadsCount = $researchQuery->where('created_at', '>=', now()->subMonth())->count();

        return view('dashboard', compact(
            'totalResearchFiles',
            'recentUploadsCount'
        ));
    }



    // public function index()
    // {

    //     return view('dashboard');
    // }
}
