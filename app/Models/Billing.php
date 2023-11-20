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

    public function getTotalAttribute()
    {
        $services = json_decode($this->diagnosis->tests, true);
        $filteredServices = collect($services);
        $servicesTotal = collect($filteredServices)->sum('unit_cost');
        
        $medicines = json_decode($this->diagnosis->treatments, true);
        $filteredMedicines = collect($medicines);
        $medicinesTotal = collect($filteredMedicines)->sum('unit_cost');

        // Add any other calculations you need
        $total = $servicesTotal + $medicinesTotal;

        return $total;
    }

    protected $fillable = [
        'appointment_id',
        'consultation_fee',
        'status',
        'total',
        'finance_id'
    ];
}
