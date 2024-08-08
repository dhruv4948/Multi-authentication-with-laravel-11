<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\comments;
use App\Models\Task;
use App\Models\task_emp;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function empComments()
    {
        // //for emp ,  whereHas function will sort out the employees,teamLeaders comments !

        $com = comments::whereHas('emptoteam', function ($query) {
            $query->whereIn('role', ['Employees', 'Team_leaders']);
        })->orderBy('id', 'desc')->get();

        return view('employeeComments', compact('com'));

    }

    public function addComments(Request $request)
    {
        $authId = Auth()->id();
        $showTask = task_emp::where('emp_id', $authId)->get();
        $validatedData = $request->validate(
            ['comments' => 'required']
        );
        comments::insert([
            'task_id' => $showTask[0]['task_id'],
            'user_id' => $authId,
            'comments' => $validatedData['comments'],
            'date' => now()
        ]);
        return redirect()->back();
    }



    // Team_Leader
    // public function leaderComments()
    // {
    //     $comment = comments::orderBy('id', 'desc')->get();
    //     return view('LeaderComments', compact('comment', ));
    // }

    public function singleTaskCommentleader($taskId)
    {
        $singleTaskCommentLeader = comments::with('users')->orderBy('id', 'desc')->where('task_id', $taskId)->get();
        // DD($singleTaskCommentLeader);
        return view('LeaderComments', compact('singleTaskCommentLeader'));
    }

    public function addLeaderComments(Request $request,$taskId)
    {
        $authId = Auth()->id();
        DD($taskId);
            $validatedData = $request->validate(
            ['comments' => 'required']
        );
        $data = comments::insert([
            'task_id' => $request->taskId,
            'user_id' => $authId,
            'comments' => $validatedData['comments'],
            'date' => now()
        ]);
        DD($data);
        return redirect()->back();

    }

    // ADMIN    
    public function adminComments()
    {
        $comment = comments::with('users')->orderBy('date', 'desc')->get();
        return view('AdminComments', compact('comment'));
    }

    public function singleTaskComments($taskId)
    {
        $singleTaskcomment = comments::with('users')->orderBy('id', 'desc')->where('task_id', $taskId)->get();
        // DD($singleTaskcomment);
        return view('AdminComments', compact('singleTaskcomment'));
    }

    public function saveAdminComments(Request $request, )
    {
        $authId = Auth()->id();

        $validatedData = $request->validate(
            ['comments' => 'required']
        );
        comments::insert([
            'task_id' => $request->taskId,
            'user_id' => $authId,
            'comments' => $validatedData['comments'],
            'date' => now()
        ]);
        return redirect()->back();
    }
}
