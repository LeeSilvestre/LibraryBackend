<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StudentProfiling;

class ConsultationRecord extends Model
{
    protected $table = 'consultation_record';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'complaint',
        'blood_pressure',
        'pulse_rate',
        'oxygen_sat',
        'temp',
        'treatment',
        'medicine_id',
        'time_in',
        'time_out',
        'is_timeout'
    ];

    // Casting attributes to ensure proper data types
    protected $casts = [
        'is_timeout' => 'boolean',
        'time_in' => 'datetime:Y-m-d H:i:s',
        'time_out' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Define the relationship with the Medicine model.
     */
    // ConsultationRecord.php

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfiling::class, 'student_id', 'student_id');
    }




}
