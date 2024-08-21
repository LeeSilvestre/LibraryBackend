<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryStatus extends Model
{
    protected $table = 'library_status';

    protected $primaryKey = 'student_id';
    public $incrementing = false;

    public $timestamps = false; 

    protected $fillable = [
        'student_id',
        'status',
    ];
}
