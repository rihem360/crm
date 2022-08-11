<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Teams;
use App\Models\Task;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\TaskResource;
use App\Http\Requests\ProjectRequest;

class ProjectsController extends Controller
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
            'projets' => ProjectResource::collection(Project::all())
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
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $project = Project::create([
            'team_id' => $request->input('team_id'),
            'project_name' => $request->input('project_name'),
            'description'=> $request->input('description'),
            'deadline' => $request->input('deadline'),
            'date_debut' => $request->input('date_debut'),
            'etat' => $request->input('etat'),
        ]);
        
        return response()->json([
            'status' => 200,
            'projet' => new ProjectResource($project)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $projet
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        if(!$project) {
            return response()->json([
                'status' => 401,
                'message' => 'The staff member data does not exist'
            ]);
        }
        else {
            $teams = $project->teams ;
            $tasks = $project->tasks ;
            return response()->json([
                'status' => 200,
                'projet' => new ProjectResource($project),
                'team' => new TeamsResource($teams),
                'task' => TasksResource::collection($tasks)
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @param  \App\Models\Project  $projet
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Projet $project)
    {
        if(!$project) {
            return response()->json([
                'status' => 401,
                'message' => 'The project data does not exist'
            ]);
        }
        else {
            $project->update([
                'team_id' => $request->input('team_id'),
                'project_name' => $request->input('project_name'),
                'description'=> $request->input('description'),
                'deadline' => $request->input('deadline'),
                'date_debut' => $request->input('date_debut'),
                'etat' => $request->input('etat')
            ]);

            return response()->json([
                'status' => 200,
                'projet' => new ProjetResource($project)
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $projet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if(!$project) {
            return response()->json([
                'status' => 401,
                'message' => 'The project data does not exist'
            ]);
        }
        else {
            $project->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Deleted successfully!'
            ]);
        }
    }
}
