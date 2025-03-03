<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\CartItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Notifications\AppointmentCreated;
use Illuminate\Support\Facades\Notification;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $query = Appointment::where('user_id', Auth::id());

        if (request('filter') === 'upcoming') {
            $query->where('appointment_date', '>', now());
        } elseif (request('filter') === 'past') {
            $query->where('appointment_date', '<=', now());
        }

        $appointments = $query->latest()->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أولاً لحجز موعد'
            ], 401);
        }

        try {
            DB::beginTransaction();

            $validated = $this->validateAppointment($request);

            $appointmentDate = Carbon::parse($validated['appointment_date']);
            $appointmentTime = Carbon::parse($validated['appointment_time']);

            if ($appointmentDate->isPast() || ($appointmentDate->isToday() && $appointmentTime->isPast())) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكن حجز موعد في وقت سابق'
                ], 422);
            }

            // Check for conflicting appointments
            $conflictingAppointment = Appointment::where('appointment_date', $appointmentDate->format('Y-m-d'))
                ->where(function ($query) use ($appointmentTime) {
                    // تحويل الوقت بنفس التنسيق للتأكد من المقارنة الصحيحة
                    $timeFormat = $appointmentTime->format('H:i');
                    $query->whereRaw("TIME_FORMAT(appointment_time, '%H:%i') = ?", [$timeFormat]);
                })
                ->whereIn('status', [
                    Appointment::STATUS_PENDING,
                    Appointment::STATUS_APPROVED
                ])
                ->first();

            if ($conflictingAppointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'هذا الموعد محجوز بالفعل، يرجى اختيار وقت آخر'
                ], 422);
            }

            if ($validated['service_type'] !== 'custom_design' && !$this->validateCartItem($validated['cart_item_id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكنك حجز موعد لهذا المنتج'
                ], 422);
            }

            // Create the appointment with status set to pending
            $appointment = $this->createAppointment($validated);

            // إرسال إشعار فقط في حالة التصميم الخاص
            if ($validated['service_type'] === 'custom_design') {
                $appointment->user->notify(new AppointmentCreated($appointment));
            }

            DB::commit();

            $redirectUrl = $validated['service_type'] === 'custom_design'
                ? route('appointments.show', $appointment->reference_number)
                : route('cart.index');

            return response()->json([
                'success' => true,
                'message' => 'تم حجز الموعد بنجاح',
                'redirect_url' => $redirectUrl
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'يرجى التحقق من البيانات المدخلة',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('خطأ في حجز الموعد: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حجز الموعد. الرجاء المحاولة مرة أخرى.'
            ], 500);
        }
    }

    public function show(Appointment $appointment)
    {
        $this->authorizeAccess($appointment);
        return view('appointments.show', compact('appointment'));
    }


    private function validateAppointment(Request $request): array
    {
        return $request->validate([
            'service_type' => ['required', 'string', 'in:new_abaya,alteration,repair,custom_design'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'phone' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'location' => ['required', 'string', 'in:store,client_location'],
            'address' => ['required_if:location,client_location', 'nullable', 'string', 'max:500'],
            'cart_item_id' => ['nullable', 'exists:cart_items,id']
        ]);
    }

    private function validateCartItem(?int $cartItemId): bool
    {
        if (!$cartItemId) {
            return true;
        }

        try {
            $cartItem = CartItem::findOrFail($cartItemId);
            return $cartItem->cart->user_id === Auth::id();
        } catch (\Exception $e) {
            Log::error('Error validating cart item: ' . $e->getMessage());
            return false;
        }
    }

    private function createAppointment(array $data): Appointment
    {
        $appointment = new Appointment();
        $appointment->user_id = Auth::id();
        $appointment->cart_item_id = $data['cart_item_id'] ?? null;
        $appointment->service_type = $data['service_type'];
        $appointment->appointment_date = Carbon::parse($data['appointment_date'])->format('Y-m-d');
        $appointment->appointment_time = Carbon::parse($data['appointment_time'])->format('H:i:00');
        $appointment->phone = $data['phone'];
        $appointment->notes = $data['notes'] ?? null;
        $appointment->status = Appointment::STATUS_PENDING;
        $appointment->location = $data['location'];
        $appointment->address = $data['address'] ?? null;
        $appointment->save();

        return $appointment;
    }

    private function authorizeAccess(Appointment $appointment): void
    {
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }
    }

    public function update(Request $request, Appointment $appointment)
    {
        $this->authorizeAccess($appointment);

        try {
            $validated = $request->validate([
                'appointment_date' => ['required', 'date', 'after_or_equal:today'],
                'appointment_time' => ['required'],
                'phone' => ['required', 'string', 'max:20'],
                'notes' => ['nullable', 'string', 'max:1000'],
                'location' => ['required', 'string', 'in:store,client_location'],
                'address' => ['required_if:location,client_location', 'nullable', 'string', 'max:500'],
            ]);

            $appointment->update([
                'appointment_date' => Carbon::parse($validated['appointment_date']),
                'appointment_time' => Carbon::parse($validated['appointment_time']),
                'phone' => $validated['phone'],
                'notes' => $validated['notes'],
                'location' => $validated['location'],
                'address' => $validated['address'],
            ]);

            $redirectRoute = $appointment->service_type === 'custom_design'
                ? route('appointments.show', $appointment->reference_number)
                : route('cart.index');

            return redirect()
                ->to($redirectRoute)
                ->with('success', 'تم تحديث الموعد بنجاح');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('خطأ في تحديث الموعد: ' . $e->getMessage());
            return back()
                ->with('error', 'حدث خطأ أثناء تحديث الموعد. الرجاء المحاولة مرة أخرى.')
                ->withInput();
        }
    }

    public function cancel(Appointment $appointment)
    {
        $this->authorizeAccess($appointment);

        try {
            if ($appointment->status !== Appointment::STATUS_PENDING) {
                return back()->with('error', 'لا يمكن إلغاء هذا الموعد في الوقت الحالي');
            }

            $appointment->update(['status' => Appointment::STATUS_CANCELLED]);

            return redirect()
                ->route('appointments.show', $appointment->reference_number)
                ->with('success', 'تم إلغاء الموعد بنجاح');

        } catch (\Exception $e) {
            Log::error('خطأ في إلغاء الموعد: ' . $e->getMessage());
            return back()
                ->with('error', 'حدث خطأ أثناء إلغاء الموعد. الرجاء المحاولة مرة أخرى.');
        }
    }

    public function getAvailableTimeSlots(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date|after_or_equal:today',
            ]);

            $date = Carbon::parse($request->date);
            $dayOfWeek = $date->dayOfWeek;

            // Define time slots based on day
            $slots = $dayOfWeek === 5 ? // Friday
                [['start' => '17:00', 'end' => '23:00', 'label' => 'الفترة المسائية']] :
                [
                    ['start' => '11:00', 'end' => '14:00', 'label' => 'الفترة الصباحية'],
                    ['start' => '17:00', 'end' => '23:00', 'label' => 'الفترة المسائية']
                ];

            $availableSlots = [];
            $today = Carbon::now();
            $isToday = $date->isSameDay($today);

            // Get all booked appointments for this date
            $bookedAppointments = Appointment::where('appointment_date', $date->format('Y-m-d'))
                ->whereIn('status', [
                    Appointment::STATUS_PENDING,
                    Appointment::STATUS_APPROVED
                ])
                ->get(['appointment_time'])
                ->map(function ($appointment) {
                    // تأكد من تنسيق الوقت بشكل صحيح بغض النظر عن تنسيق التخزين
                    return Carbon::parse($appointment->appointment_time)->format('H:i');
                })
                ->toArray();

            foreach ($slots as $slot) {
                $slotTimes = [];
                $currentTime = Carbon::parse($slot['start']);
                $endTime = Carbon::parse($slot['end']);

                while ($currentTime < $endTime) {
                    $timeValue = $currentTime->format('H:i');

                    // Skip if time is in the past for today
                    if ($isToday) {
                        $slotDateTime = Carbon::parse($date->format('Y-m-d') . ' ' . $timeValue);
                        if ($slotDateTime <= $today) {
                            $currentTime->addMinutes(30);
                            continue;
                        }
                    }

                    // Skip if time is already booked
                    if (!in_array($timeValue, $bookedAppointments)) {
                        $slotTimes[] = [
                            'value' => $timeValue,
                            'label' => Carbon::parse($timeValue)->format('g:i A')
                        ];
                    }

                    $currentTime->addMinutes(30);
                }

                if (count($slotTimes) > 0) {
                    $availableSlots[] = [
                        'label' => $slot['label'],
                        'times' => $slotTimes
                    ];
                }
            }

            // If no available slots, find the next available day
            $suggestedDate = null;
            if (empty($availableSlots)) {
                $checkDate = $date->copy()->addDay();
                $maxDaysToCheck = 30; // To prevent infinite loop, stop after a reasonable number of days
                $daysChecked = 0;

                while ($daysChecked < $maxDaysToCheck) {
                    // Skip Fridays (only has evening slots) if there are other options
                    if ($daysChecked < $maxDaysToCheck - 7 && $checkDate->dayOfWeek === 5) {
                        $checkDate->addDay();
                        $daysChecked++;
                        continue;
                    }

                    // Define time slots for this day
                    $daySlots = $checkDate->dayOfWeek === 5 ? // Friday
                        [['start' => '17:00', 'end' => '23:00']] :
                        [
                            ['start' => '11:00', 'end' => '14:00'],
                            ['start' => '17:00', 'end' => '23:00']
                        ];

                    // Get all booked appointment times for this potential date
                    $bookedTimes = Appointment::where('appointment_date', $checkDate->format('Y-m-d'))
                        ->whereIn('status', [
                            Appointment::STATUS_PENDING,
                            Appointment::STATUS_APPROVED
                        ])
                        ->get(['appointment_time'])
                        ->map(function ($appointment) {
                            return Carbon::parse($appointment->appointment_time)->format('H:i');
                        })
                        ->toArray();

                    // Calculate how many slots are available vs. booked
                    $availableSlotsForDay = [];
                    $totalAvailableSlots = 0;

                    foreach ($daySlots as $slot) {
                        $currentTime = Carbon::parse($slot['start']);
                        $endTime = Carbon::parse($slot['end']);

                        while ($currentTime < $endTime) {
                            $timeValue = $currentTime->format('H:i');

                            // If this time slot isn't booked, it's available
                            if (!in_array($timeValue, $bookedTimes)) {
                                $totalAvailableSlots++;
                            }

                            $currentTime->addMinutes(30);
                        }
                    }

                    // If we have at least one available slot on this day
                    if ($totalAvailableSlots > 0) {
                        $suggestedDate = $checkDate->format('Y-m-d');
                        break;
                    }

                    $checkDate->addDay();
                    $daysChecked++;
                }
            }

            return response()->json([
                'success' => true,
                'available_slots' => $availableSlots,
                'suggested_date' => $suggestedDate,
                'message' => $suggestedDate ? 'لا توجد مواعيد متاحة في هذا اليوم. يمكنك الحجز في ' . Carbon::parse($suggestedDate)->locale('ar')->translatedFormat('l d F Y') : null
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting available time slots: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء جلب المواعيد المتاحة'
            ], 500);
        }
    }
}
