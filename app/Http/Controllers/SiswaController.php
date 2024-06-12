<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index() {
        $siswas = Siswa::with('kelas')->paginate(50);
        return view('siswas.index', compact('siswas'));
    }

}
