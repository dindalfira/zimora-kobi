<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiDukungLKE extends Model
{
    protected $table = 'bukti_dukung_lke';

    protected $fillable = [
        'status_bukti_dukung',
        'link_bukti_dukung',
    ];

    public function pertanyaan()
    {
        return $this->belongsTo(
            PertanyaanLKE::class,
            'id_pertanyaan',
            'id_pertanyaan'
        );
    }
}