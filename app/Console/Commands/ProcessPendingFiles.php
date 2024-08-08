<?php

namespace App\Console\Commands;

use App\Jobs\ProcessCSVfileJob;
use App\Models\Excel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

class ProcessPendingFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Excel:upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process pending CSV files';
    public function __construct()
    {
        parent::__construct();
    }  


    /**
     * Execute the console command.
     */
    protected $excelData;
    public function handle()
    {
        $pendingFiles = Excel::where('status', 'in a process')->get();
        Log::debug("Excel data retrieved: " . json_encode($pendingFiles));

        foreach ($pendingFiles as $file) {
            // ProcessCSVfileJob::dispatch($file->id);
            Log::info("dispatched and Starting job for Excel data ID: " . $this->excelData);

            // $excelData = DB::table('excel_data')->find($this->excelData);
            // $excelData = Excel::findOrFail($this->excelData);
            // if ($excelData->status !== 'in a process') {
            //     return;
            // }
    
            // Log::debug("Excel data retrieved: " . json_encode($excelData));
    
            $storedFilePath = storage_path('app/' . $file->stored_path);
            $spreadsheet = IOFactory::load($storedFilePath);
            $sheet = $spreadsheet->getActiveSheet();
            $csvData = $sheet->toArray();
            $csvColumns = $csvData[0];
    
            $tableColumns = DB::getSchemaBuilder()->getColumnListing($file->table_type);
    
            // for Compare columns
            $missingColumns = array_diff($tableColumns, $csvColumns);
            // DD($missingColumns);
            $extraColumns = array_diff($csvColumns, $tableColumns);
            // DD($extraColumns);
            
            if (!empty($missingColumns) || !empty($extraColumns)) {
                DB::table('excel_data')->where('id', $this->excelData)->update(['status' => 'Failed']);
                // Excel::update(['status'=>"Failed"]);
                return ;
            }
    
            $csvData = array_slice($csvData, 1);
            // DD($csvData);
            foreach ($csvData as $row) {
                $rowData = array_combine($csvColumns, $row);
                Log::debug(" Data:" . json_encode($rowData));
                DB::table($file->table_type)->insert($rowData);
            }
            DB::table('excel_data')->where('id', $this->excelData)->update(['status' => 'succced']);
     
        }
        $this->info('Dispatched ' . $pendingFiles->count() . ' files for processing');
    }
}