<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class borrowedItems extends Model
{
    use HasFactory;


    protected $fillable = [
        'item_id',
        'item_name',
        'category',
        'unit_of_measure',
        'room_number',
        'school_level',
        'student_id',
        'quantity',
        'borrow_date',
        'return_date',
        'status',
        'adviser'
    ];



    public function item()
    {
        return $this->belongsTo(items::class);
    }






}
