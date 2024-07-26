<?php

namespace App\Console\Commands;

use App\Jobs\ProcessCSVfileJob;
use App\Models\Excel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessPendingFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:process-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process pending CSV files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pendingFiles = Excel::where('status', 'in process')->get();
        Log::debug("Excel data retrieved: " . json_encode($pendingFiles));

        foreach ($pendingFiles as $file) {
            ProcessCSVfileJob::dispatch($file->id);
        }

        $this->info('Dispatched ' . $pendingFiles->count() . ' files for processing');
    }
}