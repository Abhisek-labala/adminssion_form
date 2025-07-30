<!DOCTYPE html>
<html>

<head>
    <title>Admission Requests</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Admission Requests</h2>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Add Admission</button>

        <table id="admissionTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Email</th>
                    <th>Doctor</th>
                    <th>Department</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Hospital</th>
                    <th>Email Status</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="addForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Admission Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        @csrf
                        <div class="container">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="patient_name" class="form-label">Patient Name</label>
                                    <input type="text" name="patient_name" class="form-control" id="patient_name"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="patient_id" class="form-label">Patient ID</label>
                                    <input type="text" name="patient_id" class="form-control" id="patient_id" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="patient_email" class="form-label">Patient Email</label>
                                    <input type="email" name="patient_email" class="form-control" id="patient_email"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="doctor_name" class="form-label">Doctor Name</label>
                                    <input type="text" name="doctor_name" class="form-control" id="doctor_name"
                                        required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="department" class="form-label">Department</label>
                                    <input type="text" name="department" class="form-control" id="department" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="admission_date" class="form-label">Date of Admission Request</label>
                                    <input type="date" name="admission_date" class="form-control" id="admission_date"
                                        required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="reason" class="form-label">Reason for Admission</label>
                                    <textarea name="reason" class="form-control" id="reason" rows="2"
                                        required></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="status" class="form-label">IPD Request Status</label>
                                    <select name="status" class="form-select" id="status" required>
                                        <option value="Pending">Pending</option>
                                        <option value="Approved">Approved</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="hospital_name" class="form-label">Hospital Name</label>
                                    <select name="hospital_name" id="hospital_name" class="form-control" required>
                                        <option value="">SELECT HOSPITAL NAME</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.6/css/selectize.bootstrap5.min.css"
        rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.6/js/standalone/selectize.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

        const table = $('#admissionTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admission.index") }}',
            columns: [
                { data: 'id' },
                { data: 'patient_name' },
                { data: 'patient_email' },
                { data: 'doctor_name' },
                { data: 'department' },
                { data: 'admission_date' },
                { data: 'status' },
                { data: 'hospital_name' },
                {
                    data: 'email_sent',
                    render: function (data, type, row, meta) {
                        if (data === true || data === 1) {
                            return '<span style="color: green;">Sent</span>';
                        } else {
                            return '<span style="color: red;">Not Sent</span>';
                        }
                    }
                }

            ]
        });
        function showToast(icon, title) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }

        $('#addForm').on('submit', function (e) {
            e.preventDefault();

            let isValid = true;
            let errors = [];

            const name = $('#patient_name').val().trim();
            const email = $('#patient_email').val().trim();
            const mobile = $('#patient_id').val().trim(); // assuming 'patient_id' is mobile (if not, adjust)
            const doctor = $('#doctor_name').val().trim();
            const department = $('#department').val().trim();
            const admissionDate = $('#admission_date').val().trim();
            const reason = $('#reason').val().trim();
            const status = $('#status').val();
            const hospital = $('#hospital_name').val();

            // Name validation (only letters and space)
            if (!name || !/^[A-Za-z\s]+$/.test(name)) {
                isValid = false;
                errors.push('Patient Name is required and must contain only letters and spaces.');
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email || !emailRegex.test(email)) {
                isValid = false;
                errors.push('A valid Patient Email is required.');
            }

            // Doctor name
            if (!doctor) {
                isValid = false;
                errors.push('Doctor Name is required.');
            }

            // Department
            if (!department) {
                isValid = false;
                errors.push('Department is required.');
            }

            // Admission date
            if (!admissionDate) {
                isValid = false;
                errors.push('Admission Date is required.');
            }

            // Reason
            if (!reason) {
                isValid = false;
                errors.push('Reason is required.');
            }

            // Status
            if (!status) {
                isValid = false;
                errors.push('Status is required.');
            }

            // Hospital
            if (!hospital) {
                isValid = false;
                errors.push('Hospital Name is required.');
            }

            if (!isValid) {
                showToast('error', errors.join('<br>'));
                return;
            }

            // Submit the form
            $.ajax({
                url: '{{ route("admission.store") }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function (res) {
                    $('#addModal').modal('hide');
                    $('#addForm')[0].reset();
                    table.ajax.reload();
                    showToast('success', res.message);
                },
                error: function (xhr) {
                    let message = 'Submission failed.';
                    if (xhr.responseJSON?.errors) {
                        message = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    } else if (xhr.responseJSON?.message) {
                        message = xhr.responseJSON.message;
                    }
                    showToast('error', message);
                }
            });
        });

        $(document).ready(function () {
            // Initialize selectize
            $('#hospital_name').selectize({
                valueField: 'name',
                labelField: 'name',
                searchField: 'name',
                create: false,
                preload: true,
                load: function (query, callback) {
                    $.ajax({
                        url: '/hospitals',
                        type: 'GET',
                        success: function (res) {
                            callback(res);
                        },
                        error: function () {
                            callback();
                        }
                    });
                }
            });
        });

    </script>
</body>

</html>
