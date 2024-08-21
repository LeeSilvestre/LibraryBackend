<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    protected $table = 'book_category';
    protected $primaryKey = 'categ_name';
    public $incrementing = false;
    public $timestamps = false; 
    protected $fillable = [
        'categ_name', 'is_archived', 'book_ddc', 'lost_fine', 'damaged_fine'
    ];
}
