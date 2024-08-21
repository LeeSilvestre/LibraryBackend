<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'book_title';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false; 
    protected $fillable = [
        'book_title', 'book_auth', 'categ_name', 'book_qty', 'is_archived', 'reason', 'pub_date', 'copyright_owner', 'book_code', 'damaged_fine', 'lost_fine'
    ];

    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'categ_name', 'categ_name');
    }
}

