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

    public function doctor()
    {
        return $this->belongsTo(User::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'diagnosis_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'tests');
    }

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'symptoms',
        'disease',
        'tests',
        'test_results',
        'treatments',
    ];
}
