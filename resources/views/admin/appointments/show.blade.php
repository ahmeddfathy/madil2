<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/appointments.css') }}">
</head>
<body class="bg-light">
    <div class="appointments-container py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="page-title">
                    <i class="fas fa-calendar-alt"></i> Appointment Details
                </h1>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Appointments
                </a>
            </div>

            <!-- Update Status -->
            <div class="card appointment-details-card mb-4">
                <div class="card-header">
                    <h3><i class="fas fa-edit"></i> Update Status</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.appointments.update-status', $appointment) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="pending" @selected($appointment->status === 'pending')>Pending</option>
                                    <option value="approved" @selected($appointment->status === 'approved')>Approved</option>
                                    <option value="completed" @selected($appointment->status === 'completed')>Completed</option>
                                    <option value="cancelled" @selected($appointment->status === 'cancelled')>Cancelled</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes', $appointment->notes) }}</textarea>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Status
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row g-4">
                <!-- Customer Information -->
                <div class="col-md-6">
                    <div class="card appointment-details-card h-100">
                        <div class="card-header">
                            <h3><i class="fas fa-user"></i> Customer Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="detail-item mb-3">
                                <dt><i class="fas fa-user-circle"></i> Name</dt>
                                <dd>{{ $appointment->user->name }}</dd>
                            </div>
                            <div class="detail-item">
                                <dt><i class="fas fa-envelope"></i> Email</dt>
                                <dd>{{ $appointment->user->email }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appointment Information -->
                <div class="col-md-6">
                    <div class="card appointment-details-card h-100">
                        <div class="card-header">
                            <h3><i class="fas fa-info-circle"></i> Appointment Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <dt><i class="fas fa-concierge-bell"></i> Service Type</dt>
                                        <dd>{{ ucfirst($appointment->service_type) }}</dd>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <dt><i class="fas fa-check-circle"></i> Status</dt>
                                        <dd>
                                            <span class="status-badge {{ $appointment->status }}">
                                                <i class="fas fa-circle status-icon"></i>
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </dd>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <dt><i class="fas fa-calendar"></i> Date</dt>
                                        <dd>{{ $appointment->formatted_date }}</dd>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <dt><i class="fas fa-clock"></i> Time</dt>
                                        <dd>{{ $appointment->formatted_time }}</dd>
                                    </div>
                                </div>

                                @if($appointment->notes)
                                <div class="col-12">
                                    <div class="detail-item">
                                        <dt><i class="fas fa-sticky-note"></i> Notes</dt>
                                        <dd class="notes-text">{{ $appointment->notes }}</dd>
                                    </div>
                                </div>
                                @endif

                                <div class="col-12">
                                    <div class="detail-item">
                                        <dt><i class="fas fa-calendar-plus"></i> Created</dt>
                                        <dd>
                                            {{ $appointment->created_at ? $appointment->created_at->format('F j, Y g:i A') : 'Not available' }}
                                        </dd>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
