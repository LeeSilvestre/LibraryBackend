<?php

namespace App\Models\Registrar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Models\Section;

class Faculty extends Model
{
    use HasFactory;
    protected $table = 'faculty_profile';
    public $timestamps = true;



    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'extension',
        'email'  => 'lname'.'sna@edu.ph',
        'contact_no',
        'position',
        'department',
        'region',
        'province',
        'city',
        'barangay',
        'street',
        'zip_code',
        'is_active',
    ];

    public function student() {
        return $this->hasMany(StudentProfiling::class);
    }
    public function image(){
        return $this->belongsTo(Image::class);
    }

    public function faculty(){
        return $this->belongsTo(Faculty::class);
    }

}
