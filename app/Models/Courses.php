<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;
    protected $fillable = ['yearlevel_id', 'name'];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // In App\Models\Course.php
    public function yearlevel()
    {
        return $this->belongsTo(YearLevel::class, 'yearlevel_id');
    }
}
