<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalCert extends Model
{
    use HasFactory;

    protected $table = 'medical_cert';


    protected $fillable = [
        'date_created',
        'name',
        'school_id',
        'birthdate',
        'age',
        'blood_pressure',
        'pulse_rate',
        'vision_left',
        'vision_right',
        'weight',
        'height',
    ];

}
