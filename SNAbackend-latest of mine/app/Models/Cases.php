<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes
use App\Models\StudentProfiling;
use App\Models\Cases;

class Cases extends Model
{
    use HasFactory, SoftDeletes; // Add SoftDeletes trait

    protected $primaryKey = 'cases_id';

    protected $fillable = [
        'student_id',
        // 'student_name',
        'case_title',
        'case_description',
        'case_sanction',
        'case_status',
        'case_date',
        'case_status',
        'created_at',
        'updated_at',
        // 'archive_status'
    ];

    protected $dates = ['deleted_at']; // Ensure Laravel treats deleted_at as a date

    // public function student(){
    //     return  $this->hasOne(StudentProfiling::class, 'student_id');
    // }
    public function studentProfile(){
        return $this->hasOne(StudentProfiling::class, 'student_id', 'student_id');
    }
}
