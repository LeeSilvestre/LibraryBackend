<?php

namespace App\Models\Registrar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Registrar\Faculty;
use App\Models\StudentProfiling;

class Enrollment extends Model
{
    use HasFactory;
    protected $table = 'student_enrollment_info';

    protected $primaryKey = 'family_id';

    public $timestamps = true;


    public $fillable = [
        'student_id', // Foreign key column
        'year',
        'strand',
        'grade_level',
        'section',
        'enrollment_status',
        'enrollment_date',
    ];


    public function student()
    {
        return $this->belongsTo(StudentProfiling::class, 'student_id', 'student_id');
    }
    public function adviser()
    {
        return $this->belongsTo(Faculty::class, 'adviser_id', 'id');
    }
}
