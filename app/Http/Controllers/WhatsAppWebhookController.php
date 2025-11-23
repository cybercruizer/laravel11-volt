<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    /**
     * Handle incoming webhook from WhatsApp Manager
     */
    public function handleWebhook(Request $request)
    {
        // Get webhook data
        $deviceId = $request->input('deviceId');
        $from = $request->input('from');
        $message = $request->input('body');
        $isGroup = $request->input('isGroup');

        // Log incoming message
        Log::info('WhatsApp Message Received', [
            'device' => $deviceId,
            'from' => $from,
            'message' => $message,
            'is_group' => $isGroup
        ]);

        // Check if message contains specific keywords
        $messageLower = strtolower($message);
        
        if (str_contains($messageLower, 'spp') || str_contains($messageLower, 'tagihan')) {
            // Handle SPP/Tagihan request
            $replyMessage = $this->handleSppTagihan($from, $message);
            
            // Send reply back to WhatsApp server
            $this->sendReply($deviceId, $from, $replyMessage);
        }

        return response()->json([
            'success' => true,
            'message' => 'Webhook received'
        ]);
    }

    /**
     * Handle SPP/Tagihan logic
     */
    protected function handleSppTagihan($from, $message)
    {
        // Extract phone number from WhatsApp ID
        $phone = explode('@', $from)[0];
        
        Log::info('SPP/Tagihan request', [
            'phone' => $phone,
            'message' => $message
        ]);

        // Your custom logic here
        // Example: Check database, calculate bill, etc.
        
        $reply = "Halo! Kami telah menerima permintaan tagihan Anda.\n\n";
        $reply .= "Nomor: {$phone}\n";
        $reply .= "Silakan tunggu, admin akan segera memproses permintaan Anda.";
        
        return $reply;
    }

    /**
     * Send reply to WhatsApp server
     */
    protected function sendReply($deviceId, $to, $message)
    {
        $whatsappServerUrl = env('WHATSAPP_SERVER_URL', 'http://localhost:3000');
        
        // First, check device status
        try {
            $statusResponse = Http::timeout(5)
                ->get("{$whatsappServerUrl}/api/devices/{$deviceId}/status");
            
            if ($statusResponse->successful()) {
                $status = $statusResponse->json();
                
                if (!$status['connected']) {
                    Log::warning('Device not connected', [
                        'device' => $deviceId,
                        'status' => $status
                    ]);
                    return false;
                }
                
                Log::info('Device status check', $status);
            }
        } catch (\Exception $e) {
            Log::error('Failed to check device status', [
                'error' => $e->getMessage()
            ]);
        }
        
        // Send message
        try {
            $response = Http::timeout(30)
                ->post("{$whatsappServerUrl}/api/send-message", [
                    'deviceId' => $deviceId,
                    'to' => $to,
                    'message' => $message
                ]);

            if ($response->successful()) {
                Log::info('Reply sent successfully', [
                    'device' => $deviceId,
                    'to' => $to,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                Log::error('Failed to send reply', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'device' => $deviceId,
                    'to' => $to
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Error sending reply', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'device' => $deviceId,
                'to' => $to
            ]);
            return false;
        }
    }
}

// ============================================
// ROUTES
// ============================================

// Add to routes/api.php:

/*
use App\Http\Controllers\WhatsAppWebhookController;

Route::post('/whatsapp/webhook', [WhatsAppWebhookController::class, 'handleWebhook']);
*/

// ============================================
// .ENV CONFIGURATION
// ============================================

/*
# Add to your .env file:
WHATSAPP_SERVER_URL=http://localhost:3000
*/

// ============================================
// UPDATE Node.js server.js to handle send-message
// ============================================

/*
Add this endpoint to your Node.js server.js:

// Send message endpoint
app.post('/api/send-message', requireAuth, async (req, res) => {
  const { deviceId, to, message } = req.body;
  
  const client = clients.get(deviceId);
  
  if (!client || !client.info) {
    return res.status(404).json({ error: 'Device not connected' });
  }
  
  try {
    await client.sendMessage(to, message);
    res.json({ success: true, message: 'Message sent' });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});
*/