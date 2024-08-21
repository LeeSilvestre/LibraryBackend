<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Image extends Model
{
    use HasFactory;

    protected $table = 'image';

    protected $fillable = [
        'student_lrn',
        'image',
        'file_type'
    ];

    public function studentProfile()
    {
        return $this->belongsTo(StudentProfiling::class,'student_id', 'id');
    }
    public function faculty() {
        return $this->hasOne(Faculty::class, 'adviser_id', 'id');
    }
}
