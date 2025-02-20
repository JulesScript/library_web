<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Courses;
use App\Models\Research;
use Illuminate\Http\Request;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index()
    {
        $totalResearches = Research::count();
        $totalCourses = Courses::count();
        $totalCategories = Category::count();
        $recentResearches = Research::latest()->limit(5)->get();

        // Get research count per month for the last 12 months
        $researchPerMonth = Research::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $labels = [];
        $data = [];

        foreach ($researchPerMonth as $item) {
            $monthName = Carbon::create()->month($item->month)->format('F'); // Convert month number to name
            $labels[] = $monthName;
            $data[] = $item->count;
        }

        return view('dashboard', compact('totalResearches', 'totalCourses', 'totalCategories', 'recentResearches', 'labels', 'data'));
    }
}
