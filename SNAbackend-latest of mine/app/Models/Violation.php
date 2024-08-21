<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'student_name',
        'case_title',
        'case_description',
        'case_sanction',
        'case_status',
        'case_date'
    ];

    public function studentProfile()
    {
        return $this->hasOne(StudentProfiling::class, 'id', 'student_id');
    }
    
}
