<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class borrowingItems extends Model
{
    protected $table = 'borrowing_items';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'rooms_id', 'borrowers_id', 'date_borrowed', 'date_return', 'status', 'created_at', 'updated_at'
    ]; 

    use HasFactory;
    public function borrower()
    {
        return $this->hasMany(Borrowers::class);
    }



    public function borrowedItems()
    {
        return $this->hasManyThrough(Rooms::class, Items::class);
    }
}
