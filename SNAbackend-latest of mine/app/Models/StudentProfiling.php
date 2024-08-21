<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Registrar\Faculty;
use App\Models\LibraryStatus;
use App\Models\BorrowedBook;
use App\Models\DocumentRequest;
use App\Models\Cases;
use App\Models\Scheduling;
use App\Models\Consultation;
use App\Models\PhysicalExamination;
use App\Models\ConsultationRecords;

class StudentProfiling extends Model
{
    use HasFactory;
    protected $primaryKey = 'student_recno'; // Set the primary key

    public $incrementing = false; // Ensure Laravel doesn't assume ID is auto-incrementing

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         // Generate custom primary key
    //         $year = date('Y');
    //         $randomDigits = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT); // Random 4 digits
    //         $studentID = $year . $randomDigits;

    //         $model->student_id = $studentID;
    //         $model->email = $studentID . '@sna.edu.ph';

    //         \Log::info('Student ID in creating event: ' . $model->student_id);
    //         \Log::info('Email in creating event: ' . $model->email);
    //         // Generate random password
    //         // $model->password = static::generatePassword();
    //     });
    // }

    protected $fillable = [
        'student_lrn',
        'student_id',
        'first_name',
        'last_name',
        'middle_name',
        'extension',
        'sex_at_birth',
        'birth_date',
        'email',

        'region',
        'province',
        'city',
        'barangay',
        'street',
        'zip_code',

        'year',

        'religion',
        'contact_no',
        'guardian',
        'guardian_mobileno',
        'strand',
        'grade_level',
        'section',
        'adviser_id',
        'enrollment_status',
        'enrollment_date',

    ];

    public function setYearAttribute($value)
    {
        $this->attributes['year'] = $value ?: date('Y');
    }

    // account creation
    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }

    public function document()
    {
        return $this->hasOne(DocumentRequest::class, 'id');
    }

    public function borrowed(){
        return $this->hasMany(BorrowedBook::class, 'student_id', 'student_id');
    }

    public function consultation(){
        return $this->hasMany(Consultation::class, 'student_id', 'student_id');
    }

    public function physical_exam(){
        return $this->hasMany(PhysicalExamination::class, 'student_id', 'student_id');
    }

    public function guidance(){
        return $this->belongsTo(Cases::class, 'student_id', 'student_id');
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'student_id', 'student_id');
    }

    public function consultationRecords()
    {
        return $this->hasMany(ConsultationRecords::class, 'student_id', 'student_id');
    }




    public function adviser()
    {
        return $this->belongsTo(Faculty::class, 'adviser_id', 'id');
    }

    public function cases()
    {
        return $this->hasOne(Cases::class, 'adviser_id', 'id');
    }


    public function library()
    {
        return $this->belongsTo(LibraryStatus::class, 'student_id', 'student_id');
    }


    public function docreq()
    {
        return $this->hasMany(DocumentRequest::class, 'student_id', 'student_id');
    }
    public function schedule()
    {
        return $this->hasMany(Scheduling::class, 'section', 'section');
    }

    public function image(){
        return $this->hasMany(Image::class, 'student_lrn', 'student_lrn');
    }
}
