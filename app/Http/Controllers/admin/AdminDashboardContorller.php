<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Schema;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class AdminDashboardContorller extends Controller
{
    public function index()
    {
        $showTask = Task::with('teamLeaderName')->get();
        $clientList = Client::get();
        // return view('admin.AdminDashboard', compact('showTask', 'clientList'));
    }

    public function getTeamLeader()
    {
        $leader = User::where('role', 'Team_leaders')->get();
        $emp = User::where('role', 'Employees')->get();
        
        foreach($emp as $key => &$value)
        {
            $x = User::where('id', $value['team_id'])->get();
            $value['team_id'] = $x[0]['name'];
            // dd($x);
        }
        return view('admin.AllUsers', compact( 'emp', 'leader'));
    }

    public function promoteEmp($empId)
    {
        $promo = User::findOrFail($empId);
        if ($promo->role == "Employees") {
            $promo->role = "Team_leaders";
            $promo->save();
            return redirect()->route('get.teamLeader')->with('successEmp', 'Promoted to Team Leader');
        } else {
            return redirect()->route('get.teamLeader')->with('errorEmp', 'Unable to promote');
        }
    }

    public function demoteTeamleader($empId)
    {
        $promo = User::findOrFail($empId);
        if ($promo->role == "Team_leaders") {
            $promo->role = "Employees";
            $promo->save();
            return redirect()->route('get.teamLeader')->with('success', 'Demoted to Team Leader');
        } else {
            return redirect()->route('get.teamLeader')->with('error', 'Unable to demote');
        }
    }

    public function updateTeamLeader(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $validatedData = $request->validate([
            'team_leader_id' => 'required|exists:users,id',
        ]);
        
        $user->team_id = $validatedData['team_leader_id'];
        $user->save();

        return redirect()->back()->with('success', 'Team Leader updated successfully');
    }
    //Task 
    public function addTask()
    {
        $leader = User::where('role', 'Team_leaders')->get();
        $cate = category::get();
        $project = project::get();
        return view('admin.AdminAddTask', compact('cate', 'leader', 'project'));
    }
    public function storeTask(Request $req)
    {
        $validatedData = $req->validate([
            'title' => 'required ',
            'description' => 'required ',
            'due_date' => 'required|date ',
            'teamLeader' => 'required ',
            'teamLeader.*' => 'required|integer|exists:users,id',
            'category_id' => 'required | array',
            'category_id.*' => 'exists:category,id',
            'project_id' => 'required ',
            'project_id.*' => 'exists:projects,id',
        ]);
        Task::insert([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'],
            'created_at' => now(),
            'updated_at' => now(),
            'leader_id' => $validatedData['teamLeader'],
            'category_id' => $validatedData['category_id'][0],
            'project_id' => $validatedData['project_id']
        ]);
        return redirect()->route('admin.dashboard');
    }

    public function addProject()
    {
        $clientList = Client::get();
        $showProject = Project::with('client')->get();
        // DD($showProject);
        return view('admin.addProject', compact('clientList', 'showProject'));
    }

    public function saveProject(Request $request)
    {
        $validatedData = $request->validate([
            'project_name' => 'required',
            'client_id' => 'required | array',
            'client_id.*' => 'exists:clients,id',
            'due_date' => 'required'

        ]);
        Project::insert([
            'project_name' => $validatedData['project_name'],
            'client_id' => $validatedData['client_id'][0],
            'due_date' => $validatedData['due_date']
        ]);
        return redirect()->route('admin.dashboard');
    }
    public function saveClient(Request $request)
    {
        $validatedData = $request->validate([
            'client_name' => 'required'
        ]);
        Client::insert([
            'client_name' => $validatedData['client_name']
        ]);
        return redirect()->route('admin.dashboard');
    }

    public function uploadExcel(Request $request)
    {
        $request->validate([
            'excelFile' => 'required | file'
        ]);

        $path = storage_path() . '/app/' . $request->file('excelFile')->store('excelFiles');

        $reader = new Csv();
        $spreadsheets = $reader->load($path);
        $sheet = $spreadsheets->getActiveSheet();

        $ColumnName = [];
        $highestColumns = $sheet->getHighestColumn();
        // DD($highestColumns);

        //let check  the columns of excel sheet
        // for ($column = 'A'; $column <= $highestColumns; $column++) {
        //     $ColumnName[] = $sheet->getCell($column . '1')->getValue();
        // }

        //let check  the columns of task table
        $TableColumn = Schema::getColumnListing('client');

        $missingColumns = array_diff($ColumnName, $TableColumn);
        $extraColumns = array_diff($TableColumn, $ColumnName);

        if (!empty($missingColumns) || !empty($extraColumns)) {

            $errors = [];
            if (!empty($missingColumns)) {
                $errors[] = 'Missing columns in the Excel sheet: ' . implode(', ', $missingColumns);
            }
            if (!empty($extraColumns)) {
                $errors[] = 'Extra columns in the database table: ' . implode(', ', $extraColumns);
            }
            return redirect()->back()->withErrors($errors);
        }

        $highestRows = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRows; $row++) {
            $id = $sheet->getCell('A' . $row)->getValue();
            $client_name = $sheet->getCell('B' . $row)->getValue();

            client::insert([
                'id' => $id,
                'client_name' => $client_name
            ]);
        }
        return redirect()->back()->with('success', 'Data Added SuccessFully');
    }

    public function downloadExcel()
    {
        $task = Task::get();
        // DD($task);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'id');
        $sheet->setCellValue('B1', 'title');
        $sheet->setCellValue('C1', 'descriprion');
        $sheet->setCellValue('D1', 'due_date');
        $sheet->setCellValue('E1', 'created_at');
        $sheet->setCellValue('F1', 'updated_at');
        $sheet->setCellValue('G1', 'status');
        $sheet->setCellValue('H1', 'leader_id');
        $sheet->setCellValue('I1', 'category_id');
        $sheet->setCellValue('J1', 'project_id');

        $row = 2;
        foreach ($task as $t) {
            $sheet->setCellValue('A' . $row, $t['id']);
            $sheet->setCellValue('B' . $row, $t['title']);
            $sheet->setCellValue('C' . $row, $t['description']);
            $sheet->setCellValue('D' . $row, $t['due_date']);
            $sheet->setCellValue('E' . $row, $t['created_at']);
            $sheet->setCellValue('F' . $row, $t['updated_at']);
            $sheet->setCellValue('G' . $row, $t['status']);
            $sheet->setCellValue('h' . $row, $t['leader_id']);
            $sheet->setCellValue('i' . $row, $t['category_id']);
            $sheet->setCellValue('j' . $row, $t['project_id']);

            $row++;
        }

        $fileName = "Task_Data";

        $writer = new Xlsx($spreadsheet);
        $finalName = $fileName . '.Csv';


        // Download the file
        $writer->save($finalName);

        return redirect()->back()->with('success', 'Downloded SuccessFully');

    }
}
