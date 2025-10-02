<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Siswa;
use App\Models\RFIDLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RFIDController extends Controller
{
    /**
     * Handle RFID scan from device
     * 
     * Expected JSON payload:
     * {
     *   "device_id": "RFID001",
     *   "uid": "A1B2C3D4",
     *   "timestamp": "2025-10-02 14:30:45"
     * }
     */
    public function handleScan(Request $request)
    {
        // Log incoming request for debugging
        Log::info('RFID Scan Request', [
            'ip' => $request->ip(),
            'payload' => $request->all()
        ]);

        // Validate request
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string|max:50',
            'uid' => 'required|string|max:50',
            'timestamp' => 'required|date_format:Y-m-d H:i:s',
            'test' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data format',
                'errors' => $validator->errors()
            ], 400);
        }

        $deviceId = $request->device_id;
        $uid = $request->uid;
        $timestamp = $request->timestamp;
        $isTest = $request->test ?? false;

        // Handle test request
        if ($isTest) {
            return response()->json([
                'success' => true,
                'message' => 'Test successful! API is working.',
                'data' => [
                    'received_device_id' => $deviceId,
                    'received_uid' => $uid,
                    'received_timestamp' => $timestamp,
                    'server_time' => now()->format('Y-m-d H:i:s')
                ]
            ]);
        }

        // Check if UID exists in database
        $user = Siswa::where('rfid_uid', $uid)->first();

        if (!$user) {
            // Card not registered
            $this->logAccess($deviceId, $uid, $timestamp, false, 'kartu belum terdaftar');
            
            return response()->json([
                'success' => false,
                'message' => 'kartu belum terdaftar'
            ], 200); // Return 200 so device doesn't retry
        }

        // Check if user is active
        if (!$user->aktif()) {
            $this->logAccess($deviceId, $uid, $timestamp, false, 'Siswa tidak aktif', $user->student_id);
            
            return response()->json([
                'success' => false,
                'message' => 'Siswa Tidak Aktif'
            ], 200);
        }

        // Check for duplicate scan (within 5 minutes)
        $recentScan = RFIDLog::where('user_id', $user->student_id)
            ->where('device_id', $deviceId)
            ->where('created_at', '>', Carbon::now()->subMinutes(5))
            ->first();

        if ($recentScan) {
            return response()->json([
                'success' => false,
                'message' => 'Duplicate scan detected'
            ], 200);
        }

        // Log successful access
        $this->logAccess($deviceId, $uid, $timestamp, true, 'Presensi Sukses', $user->id);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Sukses ' . $user->student_name,
            'data' => [
                'student_id' => $user->student_number,
                'name' => $user->student_name,
            ]
        ]);
    }

    /**
     * Log RFID access attempt
     */
    private function logAccess($deviceId, $uid, $timestamp, $success, $message, $userId = null)
    {
        try {
            RFIDLog::create([
                'device_id' => $deviceId,
                'rfid_uid' => $uid,
                'user_id' => $userId,
                'scanned_at' => $timestamp,
                'success' => $success,
                'message' => $message,
                'ip_address' => request()->ip()
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log RFID access', [
                'error' => $e->getMessage(),
                'device_id' => $deviceId,
                'uid' => $uid
            ]);
        }
    }

    /**
     * Test endpoint to check if API is working
     */
    public function test()
    {
        return response()->json([
            'success' => true,
            'message' => 'RFID API is working',
            'server_time' => now()->format('Y-m-d H:i:s'),
            'version' => '1.0'
        ]);
    }
}