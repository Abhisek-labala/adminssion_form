<!DOCTYPE html>
<html>
<head>
    <title>Admission Request</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            font-size: 14px;
            padding: 30px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            color: #007bff;
        }

        .section-title {
            font-size: 16px;
            margin-top: 30px;
            font-weight: bold;
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th,
        table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ccc;
        }

        table th {
            background-color: #f2f2f2;
            width: 30%;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Admission Request</h2>
        <p><small>Submitted to {{ $admission->hospital_name }}</small></p>
    </div>

    <div class="section-title">Patient Information</div>
    <table>
        <tr>
            <th>Patient Name</th>
            <td>{{ $admission->patient_name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $admission->patient_email }}</td>
        </tr>
        <tr>
            <th>Patient ID</th>
            <td>{{ $admission->patient_id }}</td>
        </tr>
        <tr>
            <th>Doctor Name</th>
            <td>{{ $admission->doctor_name }}</td>
        </tr>
        <tr>
            <th>Department</th>
            <td>{{ $admission->department }}</td>
        </tr>
        <tr>
            <th>Admission Date</th>
            <td>{{ \Carbon\Carbon::parse($admission->admission_date)->format('d M, Y') }}</td>
        </tr>
        <tr>
            <th>Reason</th>
            <td>{{ $admission->reason }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $admission->status }}</td>
        </tr>
        <tr>
            <th>Hospital</th>
            <td>{{ $admission->hospital_name ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Thank you for choosing {{ $admission->hospital_name }}. We will contact you shortly regarding your admission request.</p>
    </div>

</body>
</html>
