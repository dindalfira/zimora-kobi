<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PemeriksaanLKE extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_lke';

    protected $fillable = [
        'pertanyaan_lke_id',
        'catatan_pemeriksaan',
        'status_pemeriksaan',
        'jawaban',
        'narasi',
        'nilai',
        'persentase',
        'diperiksa_oleh',
        'diperiksa_pada',
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
        'persentase' => 'decimal:2',
    ];

    public function pertanyaan()
    {
        return $this->belongsTo(
            PertanyaanLKE::class,
            'pertanyaan_lke_id',
            'id_pertanyaan'
        );
    }
}