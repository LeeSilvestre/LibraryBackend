<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudentProfiling;

class PhysicalExamination extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural form of the model
    protected $table = 'physical_examinations';

    // Allow mass assignment on these attributes
    protected $fillable = [
        'student_id',
        'blood_pressure',
        'pulse_rate',
        'vision_left',
        'vision_right',
        'height',
        'weight',
        'cl',
        'abdomen',
        'extremities',
        'skin',
        'cvs',
        'personal_family_history',
        'remarks',
        'date'
    ];
    public function student()
    {
        return $this->belongsTo(StudentProfiling::class, 'student_id');
    }
}
