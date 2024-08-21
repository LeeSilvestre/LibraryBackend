<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyBorrow extends Model
{
    protected $table = 'faculty_borrow';
    protected $primaryKey = 'borrow_id';
    public $timestamps = false; 
    protected $fillable = [
        'book_title', 'id', 'borrowed_date', 'return_duedate', 'borrow_status', 'access_no', 'return_date', 'total_fine'
    ];
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_title', 'book_title');
    }
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'id', 'id');
    }
}
