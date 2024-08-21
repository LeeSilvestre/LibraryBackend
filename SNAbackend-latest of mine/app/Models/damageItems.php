<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class damageItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'item_name',
        'category',
        'unit_of_measure',
        'room_number',
        'school_level',
        'quantity',
        'report_by',
        'description',
        'date_reported',
        'adviser'
    ];

    public function item()
    {
        return $this->belongsTo(items::class);
    }
}
