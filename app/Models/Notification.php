<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'tipe',
        'judul',
        'pesan',
        'id_pilar',
        'id_pertanyaan',
        'url',
        'dibaca',
        'dibaca_at',
    ];

    protected $casts = [
        'dibaca' => 'boolean',
        'dibaca_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
