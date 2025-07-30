<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionRequest extends Model
{
protected $fillable = [
    'patient_name', 'patient_id', 'patient_email', 'doctor_name',
    'department', 'admission_date', 'reason', 'status', 'hospital_name','email_sent'
];

}
