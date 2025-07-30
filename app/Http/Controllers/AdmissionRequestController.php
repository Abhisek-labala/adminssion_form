<?php

namespace App\Http\Controllers;

use App\Models\AdmissionRequest;
use App\Models\Hospital;
use Illuminate\Http\Request;
use App\Jobs\SendAdmissionRequestEmail;
use Yajra\DataTables\DataTables;

class AdmissionRequestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AdmissionRequest::select('id', 'patient_name', 'patient_email', 'doctor_name', 'department', 'admission_date', 'status', 'hospital_name','email_sent');
            return DataTables::of($data)->make(true);
        }

        return view('admission_requests.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|regex:/^[A-Za-z\s]+$/',
            'patient_id' => 'required|unique:admission_requests,patient_id',
            'patient_email' => 'required|email|unique:admission_requests,patient_email',
            'doctor_name' => 'required',
            'department' => 'required',
            'admission_date' => 'required|date',
            'reason' => 'required',
            'status' => 'required|in:Pending,Approved,Cancelled',
            'hospital_name' => 'required',
        ], [
            'patient_name.required' => 'Patient name is required.',
            'patient_name.regex' => 'Patient name must contain only letters and spaces.',

            'patient_id.required' => 'Patient ID is required.',
            'patient_id.unique' => 'This Patient ID is already used for an admission request.',

            'patient_email.required' => 'Email address is required.',
            'patient_email.email' => 'Please provide a valid email address.',
            'patient_email.unique' => 'This email is already used for an admission request.',

            'doctor_name.required' => 'Doctor name is required.',
            'department.required' => 'Department is required.',
            'admission_date.required' => 'Admission date is required.',
            'admission_date.date' => 'Admission date must be a valid date.',
            'reason.required' => 'Reason is required.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be either Pending, Approved, or Cancelled.',
            'hospital_name.required' => 'Hospital name is required.',
        ]);


        $admission = AdmissionRequest::create($validated);
        SendAdmissionRequestEmail::dispatch($admission);

        return response()->json(['message' => 'Admission request submitted successfully.']);
    }
    public function getHospitals()
    {
        $hospitals = Hospital::select('id', 'name')->get();
        return response()->json($hospitals);
    }
}
