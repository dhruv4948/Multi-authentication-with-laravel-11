<?php

use App\Console\Commands\ProcessPendingFiles;
use App\Jobs\ProcessCSVfileJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Excel;
use Illuminate\Support\Facades\Log;



// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();




// $excelData = new Excel;
// Schedule::job(new ProcessCSVfileJob($excelData))->everyMinute();

// Schedule::command('files:process-pending')->everyMinute();

// Artisan::command('files:process-pending', function (Schedule $schedule) {
//     // Schedule the custom command to run every minute
//     $schedule->command('files:process-pending')->everyMinute();
//     Log::debug("Comand ran !");

// });

// Schedule::command(ProcessPendingFiles::class)->everyMinute();
