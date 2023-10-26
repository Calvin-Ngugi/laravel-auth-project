<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

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
