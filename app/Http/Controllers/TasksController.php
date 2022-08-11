<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\Staff;
use App\Models\Subtasks;
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
            'tasks' => TaskResource::collection(Task::all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoretaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoretaskRequest $request)
    {
        $task = Task::create(([
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
        $task = Task::where('id', $id)->first();
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
                'staff' => new staffResource($staff),
                'subtasks' => SubtaskResource::collection($subtasks),
                
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatetaskRequest  $request
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatetaskRequest $request, task $task)
    {
        $task = Task::where('id', $id)->first();
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
        //
    }
}
