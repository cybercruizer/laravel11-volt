<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Presensi;
use Illuminate\Http\Request;

class RfidController extends Controller
{
    public function storeFromRFID($uid, $device_id)
    {
        //$uid =
        //$timestamp = $request->query('time');
        //$decodedTimestamp = urldecode($timestamp);
        // $carbonTime = Carbon::parse($decodedTimestamp)->toDateTimeString();
        //$device_id = $request->query('device_id');
        // return response()->json([
        //     'uid' => $uid,
        //     'timestamp' => $decodedTimestamp,
        //     'device_id' => $device_id,
        // ]);
        if (!$uid) {
            return response()->json([
                'success' => false,
                'message' => 'UID tidak ditemukan'
            ], 400);
        }

        $siswa = Siswa::where('rfid_uid', $uid)->first();
        //dd($siswa);
        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        $waktu = Carbon::now();
        $jamMasuk = $waktu->format('H:i:s');
        $tanggal = $waktu->format('Y-m-d');

        $keterangan = $waktu->lt(Carbon::createFromTime(7, 0, 0)) ? 'H' : 'T';
        if ($keterangan == 'H') {
            $keteranganText = 'Hadir';
        } else {
            $keteranganText = 'Terlambat';
        }

        // Cek apakah sudah presensi hari ini
        $sudahPresensi = Presensi::where('student_id', $siswa->student_id)
            ->whereDate('tanggal', $tanggal)
            ->exists();

        if ($sudahPresensi) {
            return response()->json([
                'success' => false,
                'message' => 'Presensi sudah tercatat hari ini'
            ], 200);
        }

        $presensi = Presensi::create([
            'student_id' => $siswa->student_id,
            'user_id' => 1,
            'kelas_id' => $siswa->kelas->class_id,
            'keterangan' => $keterangan,
            'tanggal' => $tanggal,
            'jam_masuk' => $jamMasuk,
        ]);
        if ($presensi) {
            return response()->json([
                'success' => true,
                'message' => $siswa->student_name,
                'status' => $keteranganText,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan presensi'
            ], 500);
        }
    }
}
