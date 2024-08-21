<?php

namespace App\Models; // Ensure the correct namespace is used

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudentProfiling;

class Consultation extends Model
{
    use HasFactory;

    protected $primaryKey = 'con_id';

    protected $fillable = [
        'student_id',
        'con_title',
        'con_notes',
        'con_date',
        'con_status',
    ];

   public function student()
    {
        return $this->belongsTo(StudentProfiling::class);
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfiling::class, 'student_id', 'student_id');
    }

    

}

