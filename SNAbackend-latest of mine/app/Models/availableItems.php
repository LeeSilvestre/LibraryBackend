<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class availableItems extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'available_quantity'];

    public function item()
    {
        return $this->belongsTo(items::class);
    }
}
