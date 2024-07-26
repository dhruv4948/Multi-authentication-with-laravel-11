<?php

namespace App\Jobs;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\Excel;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Models\ExcelModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpParser\Node\Stmt\TryCatch;

class ProcessCSVJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $excelData;


    public function __construct(Excel $excelData)
    {
        $this->excelData = $excelData;

    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('Processing file: ' . $this->excelData->stored_path);

        $filePath = storage_path('app/' . $this->excelData->stored_path);
        $table = $this->excelData->table_type;

        try {
            if (($handle = fopen($filePath, 'r')) !== false) {
                // Get the column names from the CSV file
                $csvColumns = fgetcsv($handle, 1000, ',');
                if ($csvColumns === false) {
                    Log::error('Failed to read the CSV header');
                }
                Log::info('CSV Columns: ' . implode(', ', $csvColumns));

                // Get the column names of the target table
                $tableColumns = Schema::getColumnListing($table);
                Log::info('Table Columns: ' . implode(', ', $tableColumns));

                // Ensure the CSV columns match the table columns
                $commonColumns = array_intersect($csvColumns, $tableColumns);

                $insertData = [];
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    $row = [];
                    foreach ($csvColumns as $index => $csvColumn) {
                        if (in_array($csvColumn, $commonColumns)) {
                            $row[$csvColumn] = $data[$index];
                        }
                    }
                    // Log each row data
                    Log::info('Row data: ' . json_encode($row));
                    // Check if row is not empty
                    if (!empty($row)) {
                        $insertData[] = $row;
                        Log::info('Mapped Row: ' . json_encode($row));
                    } else {
                        Log::info('Empty row skipped');
                    }
                }
                fclose($handle);

                // Log insert data before inserting
                Log::info('Insert Data:' . json_encode($insertData));

                // Insert data into the table if not empty
                if (!empty($insertData)) {
                    try {
                        DB::table($table)->insert($insertData);
                        $this->excelData->update(['status' => 'succced']);
                        return;
                    } catch (\Exception $e) {
                        Log::error('Failed to insert data:' . $e->getMessage());
                        $this->excelData->status = 'Failed';
                        return;
                    }
                } else {
                    Log::error('No data to insert into table');
                    $this->excelData->status = 'Failed';
                }
                $this->excelData->save();
            }
        } catch (\Exception $e) {
            Log::error('Failed to process file: ' . $e->getMessage());
            $this->excelData->status = 'failed';
        }
    }
}
