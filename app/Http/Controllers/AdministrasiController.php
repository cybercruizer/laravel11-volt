<?php

namespace App\Http\Controllers;

use App\Models\Woroworo;
use Illuminate\Http\Request;

class AdministrasiController extends Controller
{
    public function index() {
        $woro2 = Woroworo::where('kategori','walikelas')->get();
        return view('administrasi.index',compact('woro2'));
        
    }
}
