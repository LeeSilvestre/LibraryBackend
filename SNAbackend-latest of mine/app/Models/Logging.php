<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logging extends Model
{
    protected $table = 'logging';
    protected $primaryKey = 'log_id';
    public $timestamps = false; 
    protected $fillable = [
        'student_id', 'login_time', 'logout_time', 'status', 'login_date'
    ];
}

