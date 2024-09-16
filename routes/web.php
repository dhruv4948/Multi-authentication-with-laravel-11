<?php

use App\Http\Controllers\admin\AdminDashboardContorller;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\DashboardContorller;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\teamLedaer\team_leadeDashboardrController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){DD('dd');});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// // Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//     // Login Routes for all Users
//     Route::get('admin/dashboard', [AdminDashboardContorller::class, 'index'])->name('admin.dashboard');
//     Route::get('leader/dashboard', [team_leadeDashboardrController::class, 'index'])->name('Leader.dashboard');
//     Route::get('Employee/dashboard', [DashboardContorller::class, 'index'])->name('Employee.dashboard');

//     //Admin
//     Route::get('dashboard', [AdminDashboardContorller::class, 'index'])->name('admin.dashboard');
//     Route::get('getTeamLeader', [AdminDashboardContorller::class, 'getTeamLeader'])->name('get.teamLeader');
//     Route::get('emp/{empId}/promote', [AdminDashboardContorller::class, 'promoteEmp'])->name('emp.promote');
//     Route::get('emp/{empId}/demote', [AdminDashboardContorller::class, 'demoteTeamLeader'])->name('teamLeader.demote');
//     Route::post('/users/{userId}/update-team-leader', [AdminDashboardContorller::class, 'updateTeamLeader'])->name('update.teamleader');

//     //admin-Adding task
//     Route::get('admin/add/task', [AdminDashboardContorller::class, 'addTask'])->name('admin.addTask');
//     Route::post('admin/store/task', [AdminDashboardContorller::class, 'storeTask'])->name('admin.storeTask');

//     //admin-projects
//     Route::get('add/projects', [AdminDashboardContorller::class, 'addProject'])->name('add.project');
//     Route::post('store/projects', [AdminDashboardContorller::class, 'saveProject'])->name('save.project');

//     //admin-add Clients
//     Route::post('store/Client', [AdminDashboardContorller::class, 'saveClient'])->name('save.client');

//     //admin-upload excel
//     Route::post('upload/excel', [ExcelController::class, 'uploadFiles'])->name('upload.excel');

//     Route::get('/Error/{id}', [ExcelController::class, 'showError'])->name('show.error');

//     Route::get('load/Excel', [ExcelController::class, 'loadExcel'])->name('load.excel');
//     Route::post('multiple/excel', [ExcelController::class, 'uploadFiles'])->name('upload.multiple.excel');


//     //admin-download Excell sheeet
//     Route::get('download/excel', [AdminDashboardContorller::class, 'downloadExcel'])->name('download.excel');

    
//     //admim-comments
//     Route::get('admin/comments/', [CommentsController::class, 'adminComments'])->name('show.admin.comments');
//     Route::get('admin/task/{taskId}/comments', [CommentsController::class, 'singleTaskComments'])->name('show.admin.task.comments');
//     Route::post('add/{tId}/comments/', [CommentsController::class, 'saveAdminComments'])->name('add.comments.admin');


//     //Team_leader
//     Route::get('team/members', [team_leadeDashboardrController::class, 'showTeamMembers'])->name('teamLeader.showMembers');
//     Route::get('dashboard', [team_leadeDashboardrController::class, 'index'])->name('teamLeader.dashboard');
//     Route::post('assign/emp/{taskId}', [team_leadeDashboardrController::class, 'assignToEmp'])->name('assign.emp');

//     //Team_leader-comment
//     Route::get('leader/comments', [CommentsController::class, 'leaderComments'])->name('show.comments.leader');
//     Route::post('add/leader/{taskId}/comments', [CommentsController::class, 'addLeaderComments'])->name('comments.leader');
//     Route::get('leader/task/{taskId}/comments', [CommentsController::class, 'singleTaskCommentleader'])->name('show.leader.task.comments');


//     // Employee-comment
//     Route::post('add/comments', [CommentsController::class, 'addComments'])->name('add.comments');
//     Route::get('emp/{taskId}/comments', [CommentsController::class, 'empComments'])->name('show.comments.emp');


//     // Employee-comment
//     Route::post('add/comments', [CommentsController::class, 'addComments'])->name('add.comments');
//     Route::get('emp/comments', [CommentsController::class, 'empComments'])->name('show.comments.emp');

//     //Employee-update status of task 
//     Route::post('update/status/{taskId}', [DashboardContorller::class, 'updateStatus'])->name('update.task.status');


// });








require __DIR__ . '/auth.php';