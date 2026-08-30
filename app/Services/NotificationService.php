<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public function kirim(
        int $userId,
        string $tipe,
        string $judul,
        string $pesan,
        ?string $url = null,
        ?string $idPilar = null,
        ?int $idPertanyaan = null
    ) {
        return Notification::create([
            'user_id' => $userId,
            'tipe' => $tipe,
            'judul' => $judul,
            'pesan' => $pesan,
            'url' => $url,
            'id_pilar' => $idPilar,
            'id_pertanyaan' => $idPertanyaan,
            'dibaca' => false,
        ]);
    }
}
