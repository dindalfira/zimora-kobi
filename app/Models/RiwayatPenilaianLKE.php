<?php

namespace App\Models;

use App\Models\SubPilarLKE;
use Illuminate\Database\Eloquent\Model;

class RiwayatPenilaianLKE extends Model
{
    protected $table = 'riwayat_penilaian_lke';

    protected $fillable = [
        'periode',
        'id_subpilar',
        'nilai_mandiri',
        'bobot',
        'bobot_mandiri',
    ];

    protected $casts = [
        'periode' => 'integer',
        'nilai_mandiri' => 'decimal:2',
        'bobot' => 'decimal:2',
        'bobot_mandiri' => 'decimal:2',
    ];

    public function subpilar()
    {
        return $this->belongsTo(
            SubPilarLKE::class,
            'id_subpilar',
            'id_subpilar'
        );
    }
}