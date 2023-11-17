<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    public function hasAppointment()
    {
        return $this->appointments()->exists();
    }

    public function hasCompletedAppointment()
    {
        return $this->appointments()->where('status', 'completed')->exists();
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    protected $fillable = [
        'name',
        'gender',
        'dob',
        'phone_number',
        'id_number',
        'next_of_kin_name',
        'next_of_kin_phone',
        'next_of_kin_relationship'
    ];
}
