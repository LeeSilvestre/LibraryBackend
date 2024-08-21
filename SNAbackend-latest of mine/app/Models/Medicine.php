<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = 'medicine';
    protected $primaryKey = 'medicine_id';
    public $timestamps = false;
    protected $fillable = [
        'medicine_name', 'unit', 'size', 'quantity', 'expiration_date',
    ];
}
