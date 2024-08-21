<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowedBook extends Model
{
    protected $table = 'borrowed_books';
    protected $primaryKey = 'borrow_id';
    public $timestamps = false; 
    protected $fillable = [
        'book_title', 'student_id', 'borrowed_date', 'return_duedate', 'borrow_status', 'access_no', 'return_date'
    ];
    public function book()
{
    return $this->belongsTo(Book::class, 'book_title', 'book_title');
}
}
