<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $table = 'faculty';
    protected $primaryKey = 'id';
    public $timestamps = false; 
    protected $fillable = [
        'fname', 'mname', 'lname', 'extension'
    ];
}
