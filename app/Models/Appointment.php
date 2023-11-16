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

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    protected $fillable = [
        'receptionist_id',
        'diagnosis_id',
        'checkup_id',
        'patient_id',
        'room_id',
        'billing',
        'status',
    ];
}
