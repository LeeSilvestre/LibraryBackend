<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationArchive extends Model
{
    use HasFactory;

    protected $table = 'consultation_archives';

    protected $fillable = [
        'con_id',
        'student_id',
        'con_title',
        'con_notes',
        'con_date',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class, 'con_id');
    }
}
