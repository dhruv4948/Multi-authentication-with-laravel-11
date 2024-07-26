<?php

namespace App\Jobs;

use App\Models\Excel;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProcessCSVfileJob implements ShouldQueue
{
    use Batchable,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $excelData;

    public function __construct($excelData)
    {
        $this->excelData = $excelData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {


        Log::info("dispatched and Starting job for Excel data ID: " . $this->excelData);

        // $excelData = DB::table('excel_data')->find($this->excelData);
        $excelData = Excel::findOrFail($this->excelData);
        if ($excelData->status !== 'in a process') {
            return;
        }
        Log::debug("Excel data retrieved: " . json_encode($excelData));

        $storedFilePath = storage_path('app/' . $excelData->stored_path);
        $spreadsheet = IOFactory::load($storedFilePath);
        $sheet = $spreadsheet->getActiveSheet();
        $csvData = $sheet->toArray();
        $csvColumns = $csvData[0]; 

        $tableColumns = DB::getSchemaBuilder()->getColumnListing($excelData->table_type);

        // for Compare columns
        $missingColumns = array_diff($tableColumns, $csvColumns);
        $extraColumns = array_diff($csvColumns, $tableColumns);

        if (!empty($missingColumns) || !empty($extraColumns)) {
            DB::table('excel_data')->where('id', $this->excelData)->update(['status' => 'Failed']);
            return;
        }

        $csvData = array_slice($csvData, 1); 
        foreach ($csvData as $row) {
            $rowData = array_combine($csvColumns, $row);
            DB::table($excelData->table_type)->insert($rowData);
            Log::debug(" Data:" . json_encode($rowData));

        }

        DB::table('excel_data')->where('id', $this->excelData)->update(['status' => 'succced']);

    }
}
