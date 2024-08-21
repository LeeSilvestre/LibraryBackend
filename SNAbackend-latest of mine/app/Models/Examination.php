<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    use HasFactory;

    protected $primaryKey = 'exam_id';

    protected $fillable = [
        'student_id',
        'exam_title',
        'exam_score',
        'exam_remarks',
        'exam_date',
        'exam_status',
    ];

    protected $casts = [
        'exam_date' => 'date',
    ];
}
