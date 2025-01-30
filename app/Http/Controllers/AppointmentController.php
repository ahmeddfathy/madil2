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
            return $this->redirectToLogin();
        }

        $validated = $this->validateAppointment($request);

        if (!$this->validateCartItem($validated['cart_item_id'])) {
            return back()->with('error', 'لا يمكنك حجز موعد لهذا المنتج');
        }

        try {
            $appointment = $this->createAppointment($validated);
            return $this->successResponse($appointment);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
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
     * تحديث حالة الموعد
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $validated = $this->validateStatus($request);
        $appointment->update($validated);

        $appointment->user->notify(new AppointmentStatusUpdated($appointment));

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'تم تحديث حالة الموعد بنجاح');
    }

    /**
     * إلغاء الموعد
     */
    public function cancel(Appointment $appointment)
    {
        $this->authorizeAccess($appointment);

        if ($appointment->status !== Appointment::STATUS_PENDING) {
            return back()->with('error', 'لا يمكن إلغاء هذا الموعد');
        }

        $appointment->update(['status' => Appointment::STATUS_CANCELLED]);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'تم إلغاء الموعد بنجاح');
    }

    /**
     * حذف الموعد
     */
    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);
        $appointment->delete();

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'تم حذف الموعد بنجاح');
    }

    /**
     * التحقق من صحة البيانات
     */
    private function validateAppointment(Request $request): array
    {
        return $request->validate([
            'service_type' => ['required', 'string', 'in:new_abaya,alteration,repair'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'phone' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'location' => ['required', 'string', 'in:store,client_location'],
            'address' => ['required_if:location,client_location', 'nullable', 'string', 'max:500'],
            'cart_item_id' => ['required', 'exists:cart_items,id']
        ]);
    }

    /**
     * التحقق من صحة حالة الموعد
     */
    private function validateStatus(Request $request): array
    {
        return $request->validate([
            'status' => ['required', 'in:' . implode(',', [
                Appointment::STATUS_APPROVED,
                Appointment::STATUS_REJECTED,
                Appointment::STATUS_COMPLETED,
                Appointment::STATUS_CANCELLED
            ])],
            'notes' => ['nullable', 'string']
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
        $appointment->cart_item_id = $data['cart_item_id'];
        $appointment->service_type = $data['service_type'];
        $appointment->appointment_date = Carbon::parse($data['appointment_date']);
        $appointment->appointment_time = Carbon::parse($data['appointment_time']);
        $appointment->phone = $data['phone'];
        $appointment->notes = $data['notes'];
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
     * إعادة توجيه لصفحة تسجيل الدخول
     */
    private function redirectToLogin()
    {
        return redirect()
            ->route('login')
            ->with('error', 'يجب تسجيل الدخول أولاً لحجز موعد');
    }

    /**
     * استجابة النجاح
     */
    private function successResponse(Appointment $appointment)
    {
        return redirect()
            ->route('appointments.show', $appointment)
            ->with('success', 'تم حجز الموعد بنجاح');
    }

    /**
     * استجابة الخطأ
     */
    private function errorResponse(\Exception $e)
    {
        Log::error('خطأ في حفظ الموعد: ' . $e->getMessage());
        return back()->with('error', 'حدث خطأ أثناء حفظ الموعد. الرجاء المحاولة مرة أخرى.');
    }
}
