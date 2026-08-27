<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BuktiDukungLKE;

class PertanyaanLKE extends Model
{
    protected $table = 'pertanyaan_lke';

    protected $fillable = [
        'status_pertanyaan',
        'nilai_pertanyaan',
        'bobot_pertanyaan',
    ];

    public function subPilar()
    {
        return $this->belongsTo(
            SubPilarLKE::class,
            'id_subpilar',
            'id_subpilar'
        );
    }

    public function buktiDukung()
    {
        return $this->hasMany(
            BuktiDukungLKE::class,
            'id_pertanyaan',
            'id_pertanyaan'
        );
    }

    public function pemeriksaan()
    {
        return $this->hasMany(
            PemeriksaanLKE::class,
            'pertanyaan_lke_id'
        );
    }

    public function pemeriksaanTerakhir()
    {
        return $this->hasOne(
            PemeriksaanLKE::class,
            'pertanyaan_lke_id'
        )->latestOfMany();
    }
}