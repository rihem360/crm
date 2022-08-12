<?php

namespace App\Http\Controllers;

use App\Models\task;
use App\Models\project;
use App\Models\staff;
use App\Models\subtask;
use App\Http\Resources\TaskResource;
use App\Http\Resources\SubtaskResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\StaffResource;
use App\Http\Requests\TaskRequest;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => 200,
            'tasks' => TaskResource::collection(task::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $task = task::create(([
            'project_id' => $request->input('project_id'),
            'staff_id' => $request->input('staff_id'),
            'titre' => $request->input('titre'),
            'deadline' => $request->input('deadline'),
            'description' => $request->input('description'),
            'etat' => $request->input('etat')
        ]));

        return response()->json([
            'status' => 200,
            'task' => new TaskResource($task)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(task $task)
    {
        if(!$task) {
            return response()->json([
                'status' => 401,
                'message' => 'The task data does not exist'
            ]);
        }
        else {
            $project = $task->project;
            $staff = $task->staff;
            $subtasks = $task->subtasks;
           
            return response()->json([
                'status' => 200,
                'task' => new TaskResource($task),
                'project' => new ProjectResource($project),
                'staff' => new StaffResource($staff),
                'subtasks' => SubtaskResource::collection($subtasks),
                
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, task $task)
    {
        if(!$task) {
            return response()->json([
                'status' => 401,
                'message' => 'The task data does not exist'
            ]);
        }
        else {
            $task->update([
                'project_id' => $request->input('project_id'),
                'staff_id' => $request->input('staff_id'),
                'titre' => $request->input('titre'),
                'deadline' => $request->input('deadline'),
                'description' => $request->input('description'),
                'etat' => $request->input('etat')
            ]);

            return response()->json([
                'status' => 200, 
                'task' => new TaskResource($task),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(task $task)
    {
        if(!$task) {
            return response()->json([
                'status' => 401,
                'message' => 'The subtask data does not exist'
            ]);
        }
        else {
            $task->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Deleted successfully!'
            ]);
        }
    }
}
