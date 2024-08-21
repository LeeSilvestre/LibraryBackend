<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dosage',
        'expirationDate',
        'quantity',
        'unit',
        'dateAcquisition',
    ];
    protected $table = 'inventories';

    public function consultationRecords()
    {
        return $this->hasMany(ConsultationRecord::class, 'medicine_id');
    }

}
