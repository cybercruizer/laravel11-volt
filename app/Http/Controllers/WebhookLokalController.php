<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\Pembayaran2425;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class WebhookLokalController extends Controller
{
    /**
     * Handle incoming webhook from WhatsApp Manager
     */
    public function handle(Request $request)
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
        $parts   = explode(' ', $message, 2);
        $command = strtolower($parts[0] ?? '');
        $nis     = $parts[1] ?? null;
        $reply   = null;

        if ($command === "spp" && $nis) {
            // Misalnya ambil data SPP dari database berdasarkan NIS
            // $spp = Spp::where('nis', $nis)->first();
            // Untuk contoh, kita balas statis dulu
            $message = $this->getSPP($nis);
            $reply = $message;
            Log::info($reply);
        }
        if ($reply) {
            $this->sendReply($deviceId, $from, $reply);
            return response()->json(['status' => 'ok']);
        }
    }

    /**
     * Handle SPP/Tagihan logic
     */
    public function getSPP($nis)
    {
        // return expected (text) :
        // Juli (tahap=1) : jumlah
        // Agustus (tahap=2) : jumlah
        // September (tahap=1) : jumlah        
        // $siswa = Siswa::where('student_number', $nis)->first();
        // if (!$siswa) {
        //     return "NIS tidak ditemukan.";
        // }

        $pembayaran = Pembayaran2425::select('nis', 'nama', 'jenis', 'jenjang', 'paralel', 'tahap', 'jumlah', 'kategori')
            ->where('nis', $nis)
            ->where('jenis', 'A')
            ->orderBy('tahap')
            ->get();
        //dd($pembayaran);
        if ($pembayaran->first->nis === null) {
            return "Mohon maaf NIS " . $nis . " tidak ditemukan.";
            Log::info('NIS tidak ditemukan');
        } else {
            $bulanMap = [
                1 => 'Juli',
                2 => 'Agustus',
                3 => 'September',
                4 => 'Oktober',
                5 => 'November',
                6 => 'Desember',
                7 => 'Januari',
                8 => 'Februari',
                9 => 'Maret',
                10 => 'April',
                11 => 'Mei',
                12 => 'Juni'
            ];
            $nama= $pembayaran->first()->nama;
            $responseMessage = "Informasi SPP telah *terbayar* untuk " . $nama . " (NIS: " . $nis . "):\n";
            foreach ($pembayaran as $item) {
                $bulan = $bulanMap[$item->tahap] ?? "Bulan ke-" . $item->tahap;
                $responseMessage .= "$bulan : Rp " . number_format($item->jumlah ?? 0, 0, ',', '.') . "\n";
            }
            return $responseMessage;
            Log::info($responseMessage);
        }
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
