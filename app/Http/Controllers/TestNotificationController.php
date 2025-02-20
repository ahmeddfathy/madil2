<?php

namespace App\Http\Controllers;

use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;

class TestNotificationController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseNotificationService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function sendNotification(Request $request)
    {
        try {
            $response = $this->firebaseService->sendNotification(
                $request->input('token'),
                'إشعار تجريبي',
                'هذا إشعار اختباري!'
            );

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
