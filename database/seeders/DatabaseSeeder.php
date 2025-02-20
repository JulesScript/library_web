<?php

namespace Database\Seeders;
use App\Models\YearLevel;
use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $collegeCategory = Category::where('name', 'College')->first();
    
        if ($collegeCategory) {
            YearLevel::insert([
                ['category_id' => $collegeCategory->id, 'name' => '1st Year College'],
                ['category_id' => $collegeCategory->id, 'name' => '2nd Year College'],
                ['category_id' => $collegeCategory->id, 'name' => '3rd Year College'],
                ['category_id' => $collegeCategory->id, 'name' => '4th Year College'],
            ]);
        }
    }
}
