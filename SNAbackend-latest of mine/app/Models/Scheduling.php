<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Registrar\Faculty;

class Scheduling extends Model
{
    use HasFactory;

    protected $table = 'scheduling';
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($scheduling) {
            if ($scheduling->adviser_id) {
                $adviser = Faculty::find($scheduling->adviser_id);
                if ($adviser) {
                    $scheduling->class_desc = $adviser->department;
                }
            }
        });
    }

    protected $fillable = [
        'class_desc',
        'section',
        'adviser_id',
        'time',
        'day'
    ];

    public function studentProfile()
    {
        return $this->belongsTo(StudentProfiling::class, 'section', 'section');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'adviser_id', 'id');
    }
}
