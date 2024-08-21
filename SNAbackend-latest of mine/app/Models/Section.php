<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Registrar\Faculty;

class Section extends Model
{
    use HasFactory;


    protected $table = 'sections';

    protected $fillable = [
        'grade_level',
        'section'
    ];

    public function adviser()
    {
        return $this->hasOne(Faculty::class, 'id');
    }
}
