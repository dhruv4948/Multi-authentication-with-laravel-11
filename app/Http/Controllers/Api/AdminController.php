<?php

namespace App\Http\Controllers\Api;

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


class AdminController extends Controller
{
    public function index()
    {
        $showTask = Task::with('teamLeaderName')->get();
        $clientList = Client::get();
        return response()->json([
            'tasks' => $showTask,
            'clients' => $clientList
        ]);
    }   
    
    public function getTeamLeader()
    {
        $leader = User::where('role', 'Team_leaders')->get();
        $emp = User::where('role', 'Employees')->get()->map(function ($employee) {
            $employee->team_id = User::find($employee->team_id)->name ?? null;
            return $employee;
        });
        return response()->json([
            'leaders' => $leader,
            'employees' => $emp
        ]);
    }

    public function promoteEmp($empId)
    {
        $promo = User::findOrFail($empId);
        if ($promo->role == "Employees") {
            $promo->role = "Team_leaders";
            $promo->save();
            return response()->json(['message' => 'Promoted to Team Leader'], 200);
        } else {
            return response()->json(['message' => 'Unable to promote'], 400);
        }
    }

    public function demoteTeamleader($empId)
    {
        $promo = User::findOrFail($empId);
        if ($promo->role == "Team_leaders") {
            $promo->role = "Employees";
            $promo->save();
            return response()->json(['message' => 'Demoted to Employee'], 200);
        } else {
            return response()->json(['message' => 'Unable to demote'], 400);
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

        return response()->json(['message' => 'Team Leader updated successfully'], 200);
    }

    public function addTask()
    {
        $leader = User::where('role', 'Team_leaders')->get();
        $cate = Category::get();
        $project = Project::get();
        return response()->json([
            'leaders' => $leader,
            'categories' => $cate,
            'projects' => $project
        ]);
    }

    public function storeTask(Request $req)
    {
        $validatedData = $req->validate([
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required|date',
            'teamLeader' => 'required|integer|exists:users,id',
            'category_id' => 'required|exists:category,id',
            'project_id' => 'required|exists:projects,id',
        ]);

        $task = Task::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'],
            'leader_id' => $validatedData['teamLeader'],
            'category_id' => $validatedData['category_id'],
            'project_id' => $validatedData['project_id']
        ]);

        return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
    }

    public function addProject()
    {
        $clientList = Client::get();
        $showProject = Project::with('client')->get();
        return response()->json([
            'clients' => $clientList,
            'projects' => $showProject
        ]);
    }

    public function saveProject(Request $request)
    {
        $validatedData = $request->validate([
            'project_name' => 'required',
            'client_id' => 'required|exists:clients,id',
            'due_date' => 'required|date'
        ]);

        $project = Project::create($validatedData);

        return response()->json(['message' => 'Project created successfully', 'project' => $project], 201);
    }

    public function saveClient(Request $request)
    {
        $validatedData = $request->validate([
            'client_name' => 'required'
        ]);

        $client = Client::create($validatedData);

        return response()->json(['message' => 'Client created successfully', 'client' => $client], 201);
    }
}