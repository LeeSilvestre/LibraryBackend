<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Librarian extends Model
{
    protected $table = 'librarian';

    protected $primaryKey = 'lib_id';

    public $timestamps = false; 

    protected $fillable = [
        'lib_email',
        'lib_pass',
    ];
}
