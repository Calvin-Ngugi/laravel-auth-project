<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckUp extends Model
{
    use HasFactory;

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    protected $fillable = [
        'patient_id',
        'height',
        'weight',
        'temperature',
        'blood_pressure',
        'blood_sugar',
        'heart_rate',
    ];
}
