<?php


use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\TeamLeaderController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ExcelController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:')->group(function () {
// Profile routes



// Route::get('/profile', [ProfileController::class, 'edit']);
// Route::patch('/profile', [ProfileController::class, 'update']);
// Route::delete('/profile', [ProfileController::class, 'destroy']);

Route::get('dashboard', [AdminController::class, 'index']);
Route::get('getTeamLeader', [AdminController::class, 'getTeamLeader']);
Route::get('emp/{empId}/promote', [AdminController::class, 'promoteEmp']);
Route::get('emp/{empId}/demote', [AdminController::class, 'demoteTeamLeader']);
Route::post('/users/{userId}/update-team-leader', [AdminController::class, 'updateTeamLeader']);

//admin-Adding task
Route::get('admin/add/task', [AdminController::class, 'addTask']);
Route::post('admin/store/task', [AdminController::class, 'storeTask']);

//admin-projects
Route::get('add/projects', [AdminController::class, 'addProject']);
Route::post('store/projects', [AdminController::class, 'saveProject']);

//admin-add Clients
Route::post('save/client', [AdminController::class, 'saveClient']);

//admin-upload excel
Route::post('upload/excel', [ExcelController::class, 'uploadFiles']);

Route::get('/error/{id}', [ExcelController::class, 'showError']);

Route::get('load/Excel', [ExcelController::class, 'loadExcel']);
Route::post('multiple/excel', [ExcelController::class, 'uploadFiles']);

//admin-download Excell sheeet
Route::get('download/excel', [AdminController::class, 'downloadExcel']);

//admin-comments
Route::get('admin/comments/', [CommentController::class, 'adminComments']);
Route::get('admin/task/{taskId}/comments', [CommentController::class, 'singleTaskComments']);
Route::post('add/{tId}/comments/', [CommentController::class, 'saveAdminComments']);


    // Team Leader routes
    Route::prefix('leader')->group(function () {
        Route::get('dashboard', [TeamLeaderController::class, 'index']);
        Route::get('team-members', [TeamLeaderController::class, 'showTeamMembers']);
        Route::post('tasks/{taskId}/assign', [TeamLeaderController::class, 'assignToEmployee']);
        Route::get('comments', [CommentController::class, 'leaderComments']);
        Route::post('tasks/{taskId}/comments', [CommentController::class, 'addLeaderComments']);
        Route::get('tasks/{taskId}/comments', [CommentController::class, 'singleTaskCommentLeader']);
    });

    // Employee routes
    Route::prefix('employee')->group(function () {
        Route::get('dashboard', [EmployeeController::class, 'index']);
        Route::post('tasks/{taskId}/comments', [CommentController::class, 'addComments']);
        Route::get('tasks/{taskId}/comments', [CommentController::class, 'empComments']);
        Route::put('tasks/{taskId}/status', [EmployeeController::class, 'updateStatus']);
    });
// });
