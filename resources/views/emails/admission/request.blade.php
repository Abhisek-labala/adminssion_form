@component('mail::message')
# Admission Request Submitted

Dear {{ $admission->patient_name }},

Your admission request has been received with the following details:

- **Patient ID:** {{ $admission->patient_id }}
- **Doctor Name:** {{ $admission->doctor_name }}
- **Department:** {{ $admission->department }}
- **Admission Date:** {{ \Carbon\Carbon::parse($admission->admission_date)->format('d M, Y') }}
- **Reason:** {{ $admission->reason }}
- **Status:** {{ $admission->status }}
- **Hospital:** {{ $admission->hospital_name }}

Thank you for trusting our hospital.

Thanks,
{{ $admission->hospital_name }}
@endcomponent
