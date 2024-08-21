<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $table  = 'request_document';
    protected $primaryKey = 'id';

    protected $fillable = [
        'student_id',
        'requested_by',
        'guardian_name',
        'document_type',
        'purpose',
    ];


    public function studentProfile()
    {
        return $this->belongsTo(StudentProfiling::class,'student_id', 'id');
    }
}
