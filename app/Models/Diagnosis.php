<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'symptoms',
        'disease',
        'test',
        'test_results',
        'treatments',
    ];
}
