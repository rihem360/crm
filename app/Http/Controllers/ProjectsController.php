<?php

namespace App\Http\Controllers;

use App\Models\project;
use App\Models\teams;
use App\Models\task;
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
            'projets' => ProjectResource::collection(project::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $project = project::create([
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
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(project $project)
    {
        if(!$project) {
            return response()->json([
                'status' => 401,
                'message' => 'The project data does not exist'
            ]);
        }
        else {
            $teams = $project->teams ;
            $tasks = $project->tasks ;
            return response()->json([
                'status' => 200,
                'projet' => new ProjectResource($project),
                'team' => new TeamResource($teams),
                'task' => TaskResource::collection($tasks)
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, project $project)
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
                'projet' => new ProjectResource($project)
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(project $project)
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
