<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function calculateAndUpdateMedicineCost()
    {
        $totalMedicineCost = 0;

        // Loop through associated prescriptions
        foreach ($this->prescriptions as $prescription) {
            // Calculate the cost for the current prescription and add to the total
            $medicineCost = $prescription->quantity * $prescription->medicine->cost;
            $totalMedicineCost += $medicineCost;
        }

        // Update the billing record with the total medicine cost
        $this->update([
            'medicine_cost' => $totalMedicineCost,
        ]);
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
