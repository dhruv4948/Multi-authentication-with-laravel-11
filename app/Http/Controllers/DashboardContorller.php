<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Task;
use App\Models\task_emp;
use App\Models\User_Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardContorller extends Controller
{
    public function index()
    {
        $auth_id = auth()->id();
        $showTask = task_emp::with('getEmpTask')->where('emp_id', $auth_id)->get();

        $task_status = Task::get();
        // DD($task_status);
        return view('Dashboard', compact('showTask','task_status'));
    }

    public function updateStatus(Request $request,$taskId)
    {
        $updateStatus = Task::where('id',$taskId)->update([
            'status' => $request->status
        ]);
        return redirect()->route('Employee.dashboard');
    }





    public function addTask()
    {
        $cate = category::get();
        return view('AddTask', compact('cate'));
    }

    public function saveTask(Request $req)
    {
        $validatedData = $req->validate([
            'title' => 'required ',
            'description' => 'required ',
            'due_date' => 'required|date ',
            'user_id' => 'required|integer|exists:users,id',
            'category_id' => 'required | array',
            'category_id.*' => 'exists:category,id',
        ]);
        $task = Task::insert([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'],
            'user_id' => Auth()->id(),
            'category_id' => $validatedData['category_id'][0]
        ]);
        return redirect()->route('account.dashboard');
    }
    public function acceptedTask($taskId)
    {
        $ifAccepted = User_task::where('task_id', $taskId)->exists();
        if (!$ifAccepted) {
            User_Task::insert([
                'user_id' => Auth()->id(),
                'task_id' => $taskId
            ]);
            return redirect()->route('account.dashboard')->with('error', 'Task removed successfully');
        } else {
            return redirect()->back()->with('error', 'Task is Already Accepted');
        }
    }

    public function removeAcceptedTask($taskId)
    {
        User_task::where('task_id', $taskId)->delete();
        return redirect()->route('account.dashboard')->with('error', 'Task removed successfully');
    }
}