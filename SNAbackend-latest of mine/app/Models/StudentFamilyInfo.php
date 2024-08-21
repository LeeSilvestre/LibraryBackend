<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudentProfiling;
use App\Models\Registrar\Faculty;

class StudentFamilyInfo extends Model
{
    use HasFactory;
    
    protected $table = 'student_family_infos';

    protected $primaryKey = 'family_id';

    public $timestamps = true;

    protected $fillable = [
        'student_id', // Foreign key column
        'father_name',
        'father_occupation',
        'father_mobileno',
        'mother_name',
        'mother_occupation',
        'mother_mobileno',
        'guardian_name',
        'guardian_occupation',
        'guardian_mobileno',
    ];

    // Define the relationship with the student_profilings table
    public function student()
    {
        return $this->belongsTo(StudentProfiling::class, 'student_id', 'student_id');
    }
}
