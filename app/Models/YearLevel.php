<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearLevel extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function courses()
    {
        return $this->hasMany(Courses::class);
    }
}
