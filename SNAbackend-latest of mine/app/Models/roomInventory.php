<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roomInventory extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'item_id', 'quantity'];

    public function room()
    {
        return $this->belongsTo(rooms::class);
    }

    public function item()
    {
        return $this->belongsTo(Items::class);
    }
}
