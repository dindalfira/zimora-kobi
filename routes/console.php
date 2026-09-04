<?php

use App\Services\ReminderKegiatanService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    app(ReminderKegiatanService::class)
        ->reminderAwalBulan();

})->monthlyOn(1, '08:00');


Schedule::call(function () {
    app(ReminderKegiatanService::class)
        ->cekKegiatanTerlambat();

})->dailyAt('08:00');

Artisan::command('test:reminder-kegiatan', function () {

    $service = app(\App\Services\ReminderKegiatanService::class);

    $service->reminderAwalBulan();
    $service->cekKegiatanTerlambat();

    $this->info('Semua reminder kegiatan sudah dicek.');
});