<?php

namespace App\Jobs;

use App\Models\Excel;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;


use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\IOFactory;

// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProcessCSVfileJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
    public function handle()
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
        // DD($missingColumns);
        $extraColumns = array_diff($csvColumns, $tableColumns);
        // DD($extraColumns);
        $allData = DB::table($excelData->table_type)->get();
        // DD($allData);

        if (!empty($missingColumns) || !empty($extraColumns)) {
            DB::table('excel_data')->where('id', $this->excelData)->update(['status' => 'Failed']);
            // Excel::update(['status'=>"Failed"]);
            return redirect()->with('error','Colum mismatched');
        }

        $csvData = array_slice($csvData, 1);
        // DD($csvData);
        foreach ($csvData as $row) {
            $rowData = array_combine($csvColumns, $row);
            Log::debug(" Data:" . json_encode($rowData));
            DB::table($excelData->table_type)->insert($rowData);
        }
        DB::table('excel_data')->where('id', $this->excelData)->update(['status' => 'succced']);
 
    }
}