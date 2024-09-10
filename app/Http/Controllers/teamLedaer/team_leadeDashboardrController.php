<?php

namespace App\Http\Controllers\teamLedaer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\task_emp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class team_leadeDashboardrController extends Controller
{
    public function index()
    {
        //to see the task which is assigned by admin to leader
        $auth_id = Auth()->id();
        $showTask = Task::where('leader_id', $auth_id)->get();

        // to see leaders team members in modal
        $auth_id = Auth()->id();
        $mem = User::where('team_id', $auth_id)->get();
        return view('teamLeader.teamLeaderDashboard', compact('showTask', 'mem'));
    }


    public function showTeamMembers()
    {
        // to see leaders team members
        $auth_id = Auth()->id();
        $mem = User::where('team_id', $auth_id)->get();
        return view('teamLeader.TeamMembers', compact('mem'));
    }


    public function assignToEmp(Request $request,$taskId)
    {
        $auth_id = Auth()->id();
        $showTaskId = Task::where('leader_id', $auth_id)->get();

        $validateData = $request->validate([
            'emp_id' => 'required',
            'emp_id.*' => 'exists:users,id',
        ]);

        task_emp::insert([
            'task_id'=>$taskId,
            'emp_id' => $validateData['emp_id']
        ]);

        return redirect()->route('Leader.dashboard');   
    }







    
}

