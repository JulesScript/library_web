<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    use HasFactory;
    protected $table = 'research_files'; // Specify the table name
    protected $fillable = [
        'course_id',
        'file_path',
        'file_name',
        'file_type',
        'uploaded_by',
    ];

    public function course()
    {
        return $this->belongsTo(Courses::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    
}

