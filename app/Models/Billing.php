<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }

    public function finance()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'appointment_id',
        'consultation_fee',
        'services_cost',
        'medicine_cost',
        'status',
        'total',
        'finance_id'
    ];
}
