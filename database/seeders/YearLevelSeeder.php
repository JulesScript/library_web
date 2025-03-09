<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\YearLevel;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YearLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Try to get the "shs" category first
        $shs = Category::where('name', 'shs')->first();

        // If not found, try "senior high school"
        if (!$shs) {
            $shs = Category::where('name', 'senior high school')->first();
        }

        // Get the college category
        $college = Category::where('name', 'college')->first();

        // Optionally, you could check and create these categories if they don't exist.
        if ($shs) {
            YearLevel::create(['category_id' => $shs->id, 'name' => 'Grade 11']);
            YearLevel::create(['category_id' => $shs->id, 'name' => 'Grade 12']);
        } else {
            // Handle the case when neither "shs" nor "senior high school" exists.
            // For example, you might create a default SHS category:
            $shs = Category::create(['name' => 'senior high school']);
            YearLevel::create(['category_id' => $shs->id, 'name' => 'Grade 11']);
            YearLevel::create(['category_id' => $shs->id, 'name' => 'Grade 12']);
        }

        if ($college) {
            YearLevel::create(['category_id' => $college->id, 'name' => '1st Year']);
            YearLevel::create(['category_id' => $college->id, 'name' => '2nd Year']);
            YearLevel::create(['category_id' => $college->id, 'name' => '3rd Year']);
            YearLevel::create(['category_id' => $college->id, 'name' => '4th Year']);
        } else {
            // Optionally handle the case when the college category doesn't exist.
        }
    }
}
