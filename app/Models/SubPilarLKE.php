<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PertanyaanLKE;
use App\Models\RiwayatPenilaianLKE;

class SubPilarLKE extends Model
{
    protected $table = 'SubPilarLKE';

    protected $fillable = [
        'status',
        'kelengkapan_pemenuhan',
        'nilai_mandiri',
    ];

    public $timestamps = true;

    public function index()
    {
        $pertanyaan = PertanyaanLKE::with('subpilar')->get();

        return view('lke', compact('pertanyaan'));
    }

    public function pertanyaan()
    {
        return $this->hasMany(
            PertanyaanLKE::class,
            'id_subpilar',
            'id_subpilar'
        );
    }

    public function riwayatPenilaian()
    {
        return $this->hasMany(
            RiwayatPenilaianLKE::class,
            'id_subpilar',
            'id_subpilar'
        );
    }
}
