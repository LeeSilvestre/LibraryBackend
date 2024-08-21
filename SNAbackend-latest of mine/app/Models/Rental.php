<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rental';
    protected $primaryKey = 'rental_id';
    public $timestamps = false; 
    protected $fillable = [
        'student_id', 'Araling_Panlipunan', 'English', 'Filipino', 'MAPEH', 'Mathematics', 'Science', 'TLE', 'CL', 'VE', 'release_date', 'return_date', 'AP_code', 'E_code','F_code','MA_code','M_code', 'S_code', 'T_code', 'V_code', 'C_code', 'status', 
        'book_title1_damaged', 'book_title2_damaged', 'book_title3_damaged', 'book_title4_damaged', 'book_title5_damaged', 'book_title6_damaged', 'book_title8_damaged', 'book_title9_damaged', 
        'book_title1_lost', 'book_title2_lost', 'book_title3_lost', 'book_title4_lost', 'book_title5_lost', 'book_title6_lost', 'book_title7_lost', 'book_title8_lost', 'book_title9_lost',
        'book_title1_fine', 'book_title2_fine', 'book_title3_fine', 'book_title4_fine', 'book_title5_fine', 'book_title6_fine', 'book_title7_fine', 'book_title8_fine', 'book_title9_fine', 'total_fine'
    ];
}
