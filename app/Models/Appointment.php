<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function receptionist()
    {
        return $this->belongsTo(User::class);
    }

    public function checkup()
    {
        return $this->belongsTo(CheckUp::class);
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    protected $fillable = [
        'receptionist_id',
        'checkup_id',
        'diagnosis_id',
        'patient_id',
        'status',
        'billing',
    ];
}
