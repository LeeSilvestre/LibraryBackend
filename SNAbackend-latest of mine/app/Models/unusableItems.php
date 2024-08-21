<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unusableItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'item_name',
        'category',
        'room_number',
        'school_level',
        'quantity',
        'report_by',
        'description',
        'date_reported',
    ];

    public function item()
    {
        return $this->belongsTo(items::class);
    }
}
