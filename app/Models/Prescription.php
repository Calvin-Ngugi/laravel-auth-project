<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    protected $fillable = ['patient_id', 'appointment_id', 'diagnosis_id', 'quantity', 'medicine_id', 'is_valid'];
}
