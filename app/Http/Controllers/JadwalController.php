<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\PelaksanaanKegiatan;

class JadwalController extends Controller
{
    public function index()
    {
        $pelaksanaan = PelaksanaanKegiatan::with('kegiatan')
            ->orderBy('waktu_pelaksanaan', 'asc')
            ->get();

        return view('jadwal', compact('pelaksanaan'));
    }
}
