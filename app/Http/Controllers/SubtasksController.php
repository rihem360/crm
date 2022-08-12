<?php

namespace App\Http\Controllers;

use App\Models\subtask;
use App\Models\staff;
use App\Models\project;
use App\Http\Resources\SubtaskResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\StaffResource;
use App\Http\Requests\SubtaskRequest;

class SubtasksController extends Controller
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
            'subtasks' => SubtaskResource::collection(subtask::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SubtaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubtaskRequest $request)
    {
        $subtask = subtask::create(([
            'task_id' => $request->input('task_id'),
            'staffl_id' => $request->input('staff_id'),
            'titre' => $request->input('titre'),
            'deadline' => $request->input('deadline'),
            'description' => $request->input('description'),
            'etat' => $request->input('etat')
        ]));

        return response()->json([
            'status' => 200,
            'subtask' => new SubtaskResource($subtask)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subtask  $subtask
     * @return \Illuminate\Http\Response
     */
    public function show(subtask $subtask)
    {
        if(!$subtask) {
            return response()->json([
                'status' => 401,
                'message' => 'The subtask data does not exist'
            ]);
        }
        else {
            $staff = $subtask->staff;
           
            return response()->json([
                'status' => 200,
                'subtask' => new SubtaskResource($subtask),
                'staff' => new StaffResource($staff),
                
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SubtaskRequest  $request
     * @param  \App\Models\subtask  $subtask
     * @return \Illuminate\Http\Response
     */
    public function update(SubtaskRequest $request, subtask $subtask)
    {
        if(!$subtask) {
            return response()->json([
                'status' => 401,
                'message' => 'The subtask data does not exist'
            ]);
        }
        else {
            $subtask->update([
                'task_id' => $request->input('task_id'),
                'titre' => $request->input('titre'),
                'deadline' => $request->input('deadline'),
                'description' => $request->input('description'),
                'etat' => $request->input('etat')
                
            ]);

            return response()->json([
                'status' => 200, 
                'subtask' => new SubtaskResource($subtask),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subtask  $subtask
     * @return \Illuminate\Http\Response
     */
    public function destroy(subtask $subtask)
    {
        if(!$subtask) {
            return response()->json([
                'status' => 401,
                'message' => 'The subtask data does not exist'
            ]);
        }
        else {
            $subtask->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Deleted successfully!'
            ]);
        }
    }
}
