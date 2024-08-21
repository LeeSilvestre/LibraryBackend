<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $table = 'student_profile';
    protected $primaryKey = 'student_id';
    public $timestamps = false; 
    protected $fillable = [
        'student_lrn', 'first_name', 'last_name', 'middle_name', 'extension',
        'student_email', 'student_birthd', 'student_birthp', 'student_civil', 'student_sex',
        'student_citizen', 'student_religion', 'student_region', 'student_province',
        'student_city', 'student_barangay', 'student_street', 'student_zip'
    ];
}

