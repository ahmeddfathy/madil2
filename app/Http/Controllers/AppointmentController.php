<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Notifications\AppointmentStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAppointmentRequest;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Auth::user()->appointments()->latest()->paginate(10);
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        // التحقق من البيانات
        $validated = $request->validate([
            'service_type' => ['required', 'string', 'in:new_abaya,alteration,repair'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'phone' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        // تحويل التاريخ والوقت إلى كائن Carbon
        $appointmentDate = Carbon::parse($validated['appointment_date']);
        $appointmentTime = Carbon::parse($validated['appointment_time']);

        // إنشاء الموعد
        $appointment = Auth::user()->appointments()->create([
            'service_type' => $validated['service_type'],
            'appointment_date' => $appointmentDate,
            'appointment_time' => $appointmentTime,
            'phone' => $validated['phone'],
            'notes' => $validated['notes'],
            'status' => Appointment::STATUS_PENDING
        ]);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment scheduled successfully.');
    }

    public function show(Appointment $appointment)
    {
        // التحقق من أن الموعد يخص المستخدم الحالي
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }

        return view('appointments.show', compact('appointment'));
    }

    public function adminIndex()
    {
        $this->authorize('viewAny', Appointment::class);

        $appointments = Appointment::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', [
                Appointment::STATUS_APPROVED,
                Appointment::STATUS_REJECTED,
                Appointment::STATUS_COMPLETED,
                Appointment::STATUS_CANCELLED
            ]),
            'notes' => 'nullable|string'
        ]);

        $appointment->update($validated);

        // Send notification to user
        $appointment->user->notify(new AppointmentStatusUpdated($appointment));

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment status updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);

        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    public function cancel(Appointment $appointment)
    {
        // التحقق البسيط من الملكية
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }

        // التحقق من أن الموعد لم يتم إلغاؤه من قبل
        if ($appointment->status !== Appointment::STATUS_PENDING) {
            return back()->with('error', 'This appointment cannot be cancelled.');
        }

        $appointment->update(['status' => Appointment::STATUS_CANCELLED]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }
}
