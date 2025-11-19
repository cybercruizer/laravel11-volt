<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran2425;
use App\Models\Siswa;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function getSPP($nis)
    {
        // return expected (text) :
        // Juli (tahap=1) : jumlah
        // Agustus (tahap=2) : jumlah
        // September (tahap=1) : jumlah        
        $siswa = Siswa::where('student_number', $nis)->first();
        if (!$siswa) {
            return "NIS tidak ditemukan.";
        }

        $pembayaran = Pembayaran2425::select('nis', 'nama', 'jenis', 'jenjang', 'paralel', 'tahap', 'jumlah', 'kategori')
            ->where('nis', $nis)
            ->where('jenis', 'A')
            ->orderBy('tahap')
            ->get();

        if ($pembayaran->isEmpty()) {
            return "Tidak ada data SPP untuk NIS ini.";
        }

        $bulanMap = [
            1 => 'Juli', 2 => 'Agustus', 3 => 'September', 4 => 'Oktober',
            5 => 'November', 6 => 'Desember', 7 => 'Januari', 8 => 'Februari',
            9 => 'Maret', 10 => 'April', 11 => 'Mei', 12 => 'Juni'
        ];

        $responseMessage = "Informasi SPP untuk " . $siswa->student_name . " (NIS: " . $nis . "):\n";
        foreach ($pembayaran as $item) {
            $bulan = $bulanMap[$item->tahap] ?? "Bulan ke-" . $item->tahap;
            $responseMessage .= "$bulan : Rp " . number_format($item->jumlah ?? 0, 0, ',', '.') . "\n";
        }
        return $responseMessage;
    }

    public function handle(Request $request)
    {
        $data    = $request->all();
        $sender  = $data['sender'] ?? null;
        $message = trim($data['message'] ?? '');

        // // Default reply
        // $reply = ["message" => "Sorry, I don't understand."];

        // Parsing pesan: ambil kata pertama sebagai command, sisanya sebagai parameter
        $parts   = explode(' ', $message, 2);
        $command = strtolower($parts[0] ?? '');
        $nis     = $parts[1] ?? null;

        if ($command === "spp" && $nis) {
            // Misalnya ambil data SPP dari database berdasarkan NIS
            // $spp = Spp::where('nis', $nis)->first();
            // Untuk contoh, kita balas statis dulu
            $message = $this->getSPP($nis);
            $reply = [
                "message" => $message,
            ];
        }
        // Kirim balasan ke Fonnte
        if($reply) {
            $this->sendFonnte($sender, $reply);
            return response()->json(['status' => 'ok']);
        }
        
    }

    private function sendFonnte($target, $data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://api.fonnte.com/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => [
                'target'   => $target,
                'message'  => $data['message'] ?? '',
                'url'      => $data['url'] ?? '',
                'filename' => $data['filename'] ?? '',
            ],
            CURLOPT_HTTPHEADER     => [
                "Authorization: " . env('FONNTE_TOKEN'), // simpan TOKEN di .env
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
