<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthStaffController;
use App\Http\Controllers\Auth\AuthContactController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\CgpisController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\SubtasksController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\ResponsesController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\Affectation\StaffTeamController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/passforget', [AuthController::class, 'resetNotif']);
Route::post('/staffpassReset/{id}', [AuthStaffController::class, 'reset']);
Route::post('/contactpassReset/{id}', [AuthContactController::class, 'reset']);
Route::delete('/logout', [AuthController::class, 'logout']);
Route::apiResource('/staff', StaffController::class);
Route::middleware(['auth:sanctum', 'type.admin'])->group(function () {
   
    Route::apiResource('/contacts', ContactsController::class);
    Route::apiResource('/customers', CustomersController::class);
    Route::apiResource('/cgpi', CgpisController::class);
    Route::apiResource('/teams', TeamsController::class);
    Route::post('/staffteamAdd', [StaffTeamController::class, 'attachStaff']);
    Route::post('/staffteamRemove', [StaffTeamController::class, 'detachStaff']);
    Route::apiResource('/projects', ProjectsController::class);
    Route::apiResource('/tasks', TasksController::class);
    Route::apiResource('/subtasks', SubtasksController::class);
   
    
    Route::get('/allresponses', [ResponsesController::class, 'index']);
    Route::get('/responses/{id}', [ReponsesController::class, 'show']);
    Route::get('/alltickets', [TicketsController::class, 'index']);
    Route::get('/ticket/{id}', [TicketsController::class, 'show']);
    Route::apiResource('/documents', DocumentsController::class);
});

Route::middleware(['auth:sanctum', 'type.staff'])->group(function () {
    Route::get('/project', [ProjectsController::class, 'index']);
    Route::get('/project/{projet}', [ProjectsController::class, 'show']);
    Route::get('/task', [TasksController::class, 'index']);
    Route::get('/task/{id}', [TasksController::class, 'show']);
    Route::get('/subtask', [SubtasksController::class, 'index']);
    Route::get('/subtask/{id}', [SubtasksController::class, 'show']);
    Route::apiResource('/responses', ResponsesController::class);
    Route::get('/showtickets', [TicketsController::class, 'index']);
    Route::get('/ticketById/{id}', [TicketsController::class, 'show']);  
});

Route::middleware(['auth:sanctum', 'type.contact'])->group(function () {
    Route::post('/password', [AuthContactController::class, 'changePassword']);
    Route::apiResource('/tickets', TicketsController::class);
    Route::get('/allprojects', [ProjectsController::class, 'index']);
    Route::get('/projet/{projet}', [ProjectsController::class, 'show']);
    Route::get('/getResponses', [ResponsesController::class, 'index']);
    Route::get('/response/{id}', [ResponsesController::class, 'show']);
    Route::get('/alldocuments', [DocumentsController::class, 'index']);
    Route::get('/document/{id}', [DocumentsController::class, 'show']);
});
Route::middleware(['auth:sanctum', 'type.cgpi'])->group(function () {

    Route::get('/cgpis/{id}', [CgpisController::class, 'show']);
});

