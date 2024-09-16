<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessCSVfileJob;
use App\Models\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


class ExcelController extends Controller
{
    public function loadExcel()
    {
        $excelData = Excel::get();
        return view('admin.AdminAddExcel', compact('excelData'));
    }
    public function showError($id)
    {
        $err = Excel::findOrFail($id);
        // DD($err);
        return view('admin.showError', compact('err'));
    }
    public function uploadFiles(Request $req)
    {
        // if ($req->has('excelFile')) {

        //     $dt = array_map('str_getcsv', file($req->excelFile));
        //     $header = $dt[0];
        //     unset($dt[0]);

        //     $c = array_chunk($dt, 10);
        //     DD($c[0]);

        //     foreach ($dt as $itm) {
        //         $clientData = array_combine($header, $itm);
        //         client::insert($clientData);
        //     }
        //     return "Done";
        // }

        $valData = $req->validate([
            'excelFile' => 'required|file|mimes:xlsx,csv',
            'table_type' => 'required',
        ]);

        $csvFilePath = $req->file('excelFile')->store('excelFiles');
        $selectedTable = $valData['table_type'];

        $excelData = Excel::create([
            'uploaded_time' => now(),
            'stored_path' => $csvFilePath,
            'table_type' => $selectedTable,
        ]);


        // $dataWithoutHeaders = [];
        // foreach ($worksheet->getRowIterator() as $row) {
        //     $cellIterator = $row->getCellIterator();
        //     $cellIterator->setIterateOnlyExistingCells(false); // Iterate over all cells, even if they are null

        //     $rowData = [];
        //     foreach ($cellIterator as $cell) {
        //         $rowData[] = $cell->getCalculatedValue();
        //     }

        //     if ($row->getRowIndex() !== 1) { // Skip the first row (header)
        //         $dataWithoutHeaders[] = $rowData;
        //     }
        // }
        // DD($dataWithoutHeaders);

        // $FilePath = storage_path('app/'.$req->file('excelFile')->store('excelFiles'));
        // $spreadsheet = IOFactory::load($FilePath);
        // $worksheet = $spreadsheet->getActiveSheet();

        // $csvData = $worksheet->toArray();
        // $csvColumn = $csvData[0];
        // $tableColumns = Schema::getColumnListing($selectedTable);
        // $missingColumns = array_diff($tableColumns,$csvColumn);
        // $extraColumns = array_diff($csvColumn,$tableColumns);

        // if(!empty($missingColumns) || !empty($extraColumns)){
        //     return back()->with('error', 'Column mismatch. Please ensure the CSV columns match the table columns.');
        // }else{

        //     $csvData =  array_slice($csvData,1);
        //     foreach($csvData as $row){
        //         $rowData =  array_combine($csvColumn,$row);
        //         DB::table($selectedTable)->insert($rowData);

        //     }
        // }

        Log::info("Excel data created: ", $excelData->toArray());

        ProcessCSVfileJob::dispatch($excelData->id);
        // check::dispatch();
        return redirect()->back()->with('success','Uploaded succesfully');
    }
}