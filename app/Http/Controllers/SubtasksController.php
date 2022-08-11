<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Staff;
use App\Models\Project;
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
            'subtasks' => SubtaskResource::collection(Subtask::all())
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
     * @param  \App\Http\Requests\SubtaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubtaskRequest $request)
    {
        $subtasks = Subtask::create(([
            'task_id' => $request->input('task_id'),
            'staffl_id' => $request->input('staff_id'),
            'titre' => $request->input('titre'),
            'deadline' => $request->input('deadline'),
            'description' => $request->input('description'),
            'etat' => $request->input('etat')
        ]));

        return response()->json([
            'status' => 200,
            'subtask' => new SubtaskResource($subtasks)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subtasks  $subtasks
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subtasks = Subtasks::where('id', $id)->first();
        if(!$subtasks) {
            return response()->json([
                'status' => 401,
                'message' => 'The subtask data does not exist'
            ]);
        }
        else {
            $staff = $subtasks->staff;
           
            return response()->json([
                'status' => 200,
                'subtasks' => new SubtasksResource($subtasks),
                'staff' => new StaffResource($staff),
                
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subtasks  $subtasks
     * @return \Illuminate\Http\Response
     */
    public function edit(Subtasks $subtasks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SubtasksRequest  $request
     * @param  \App\Models\Subtasks  $subtasks
     * @return \Illuminate\Http\Response
     */
    public function update(SubtaskRequest $request, $id)
    {
        $subtasks = Subtasks::where('id', $id)->first();
        if(!$subtasks) {
            return response()->json([
                'status' => 401,
                'message' => 'The subtask data does not exist'
            ]);
        }
        else {
            $subtasks->update([
                'task_id' => $request->input('task_id'),
                'titre' => $request->input('titre'),
                'deadline' => $request->input('deadline'),
                'description' => $request->input('description'),
                'etat' => $request->input('etat')
                
            ]);

            return response()->json([
                'status' => 200, 
                'subtask' => new SubtaskResource($subtasks),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subtasks  $subtasks
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subtasks = Subtasks::where('id', $id)->first();
        if(!$subtasks) {
            return response()->json([
                'status' => 401,
                'message' => 'The subtask data does not exist'
            ]);
        }
        else {
            $subtasks->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Deleted successfully!'
            ]);
        }
    }
}
