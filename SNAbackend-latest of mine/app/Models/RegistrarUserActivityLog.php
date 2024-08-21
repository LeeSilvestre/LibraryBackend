<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrarUserActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action_type',
        'action_time',
        'ip_address',
        'details',
        'status',
        'module_name',
        'system_name',
        'additional_info',
    ];

    protected $casts = [
        'additional_info' => 'array',
        'action_time' => 'datetime',
    ];
}
