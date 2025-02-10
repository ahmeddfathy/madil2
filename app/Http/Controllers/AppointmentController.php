<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\CartItem;
use App\Notifications\AppointmentStatusUpdated;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    /**
     * عرض قائمة المواعيد للمستخدم
     */
    public function index()
    {
        $appointments = Auth::user()
            ->appointments()
            ->latest()
            ->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    /**
     * عرض نموذج إنشاء موعد جديد
     */
    public function create()
    {
        return view('appointments.create');
    }

    /**
     * حفظ موعد جديد
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'يجب تسجيل الدخول أولاً لحجز موعد');
        }

        try {
            $validated = $this->validateAppointment($request);

            if ($validated['service_type'] !== 'custom_design' && !$this->validateCartItem($validated['cart_item_id'])) {
                return back()
                    ->with('error', 'لا يمكنك حجز موعد لهذا المنتج');
            }

            $appointment = $this->createAppointment($validated);

            return redirect()
                ->route('appointments.show', $appointment)
                ->with('success', 'تم حجز الموعد بنجاح');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('خطأ في حجز الموعد: ' . $e->getMessage());
            return back()
                ->with('error', 'حدث خطأ أثناء حجز الموعد. الرجاء المحاولة مرة أخرى.')
                ->withInput();
        }
    }

    /**
     * عرض تفاصيل الموعد
     */
    public function show(Appointment $appointment)
    {
        $this->authorizeAccess($appointment);
        return view('appointments.show', compact('appointment'));
    }

    /**
     * عرض قائمة المواعيد للمشرف
     */
    public function adminIndex()
    {
        $this->authorize('viewAny', Appointment::class);

        $appointments = Appointment::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * التحقق من صحة البيانات
     */
    private function validateAppointment(Request $request): array
    {
        return $request->validate([
            'service_type' => ['required', 'string', 'in:new_abaya,alteration,repair,custom_design'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required'],
            'phone' => ['required', 'string', 'max:20'],
            'notes' => ['required_if:service_type,custom_design', 'nullable', 'string', 'max:1000'],
            'location' => ['required', 'string', 'in:store,client_location'],
            'address' => ['required_if:location,client_location', 'nullable', 'string', 'max:500'],
            'cart_item_id' => ['nullable', 'exists:cart_items,id']
        ]);
    }

    /**
     * التحقق من ملكية cart_item
     */
    private function validateCartItem(int $cartItemId): bool
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        return $cartItem->cart->user_id === Auth::id();
    }

    /**
     * إنشاء موعد جديد
     */
    private function createAppointment(array $data): Appointment
    {
        $appointment = new Appointment();
        $appointment->user_id = Auth::id();
        $appointment->cart_item_id = $data['cart_item_id'] ?? null;
        $appointment->service_type = $data['service_type'];
        $appointment->appointment_date = Carbon::parse($data['appointment_date']);
        $appointment->appointment_time = Carbon::parse($data['appointment_time']);
        $appointment->phone = $data['phone'];
        $appointment->notes = $data['service_type'] === 'custom_design'
            ? 'تصميم مخصص: ' . $data['notes']
            : $data['notes'];
        $appointment->status = Appointment::STATUS_PENDING;
        $appointment->location = $data['location'];
        $appointment->address = $data['address'];
        $appointment->save();

        return $appointment;
    }

    /**
     * التحقق من صلاحية الوصول
     */
    private function authorizeAccess(Appointment $appointment): void
    {
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }
    }

    /**
     * تحديث الموعد
     */
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

            return redirect()
                ->route('appointments.show', $appointment)
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

    /**
     * إلغاء الموعد
     */
    public function cancel(Appointment $appointment)
    {
        $this->authorizeAccess($appointment);

        try {
            if ($appointment->status !== Appointment::STATUS_PENDING) {
                return back()->with('error', 'لا يمكن إلغاء هذا الموعد في الوقت الحالي');
            }

            $appointment->update([
                'status' => Appointment::STATUS_CANCELLED,
            ]);

            return redirect()
                ->route('appointments.show', $appointment)
                ->with('success', 'تم إلغاء الموعد بنجاح');

        } catch (\Exception $e) {
            Log::error('خطأ في إلغاء الموعد: ' . $e->getMessage());
            return back()
                ->with('error', 'حدث خطأ أثناء إلغاء الموعد. الرجاء المحاولة مرة أخرى.');
        }
    }
}
