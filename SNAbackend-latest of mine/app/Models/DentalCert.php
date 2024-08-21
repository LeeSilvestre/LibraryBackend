<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DentalCert extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural form of the model name
    protected $table = 'dental_cert';

    // Specify the fillable attributes
    protected $fillable = [
        'student_id',
        'date',
        'dental_history',
        'current_dental_issue',
        'examination_findings',
    ];
}
