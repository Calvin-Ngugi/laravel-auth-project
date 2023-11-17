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

    public function medicineSum()
    {
        $medicineData = json_decode($this->attributes['medicines']);
        // dd($medicineData);

        if (is_array($medicineData)) {
            // Check if it's an array of objects or an array of strings
            if (isset($medicineData[0]) && is_array($medicineData[0])) {
                return array_sum(array_column($medicineData, 'unit_cost'));
            } else {
                $totalCost = 0;
                foreach ($medicineData as $medicineIndex) {

                    // Assuming your medicine data is stored in another table named "medicines"
                    $medicine = Medicine::find($medicineIndex);

                    // dd($medicine->unit_cost);
                    if ($medicine) {
                        // Access the unit_cost property and add it to the total
                        $totalCost += $medicine->unit_cost;
                    }
                }
                return ($totalCost);
                // dd('isString');
                // Handle the case when "medicines" is an array of strings
                return array_sum(array_map('intval', $medicineData));
            }
        }

        return 0; // Default to 0 if the 'medicine' attribute is not a valid JSON array
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
