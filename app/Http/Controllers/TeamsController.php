<?php

namespace App\Http\Controllers;

use App\Models\teams;
use App\Models\staff;
use App\Http\Resources\TeamResource;
use App\Http\Resources\StaffResource;
use App\Http\Requests\TeamRequest;

class TeamsController extends Controller
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
            'teams' => TeamResource::collection(teams::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TeamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamRequest $request)
    {
        $team = teams::create([
            'pseudo' => $request->input('pseudo'),
        ]);
        $members = array();
        $members = $request->input("staff");
        foreach($members as $staff) {
            $teams->staff()->attach($staff);
        }
        return response()->json([
            'status' => 200,
            'team' => new TeamResource($team),
            'staff' => StaffResource::collection($team->staff)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\teams  $team
     * @return \Illuminate\Http\Response
     */
    public function show(teams $team)
    {
        if(!$team) {
            return response()->json([
                'status' => 401,
                'message' => 'The team data does not exist'
            ]);
        }
        $members = array();
        foreach($teams->staff as $staff) {
            $member = new StaffResource($staff);
            $members [] = $member;
        }
        return response()->json([
            'status' => 200,
            'equipe' => new TeamResource($team),
            'members' => $members
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TeamRequest  $request
     * @param  \App\Models\teams  $team
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request, teams $team)
    {
        if(!$team) {
            return response()->json([
                'status' => 401,
                'message' => 'The team data does not exist'
            ]);
        }
        else {
            $team->update([
                'pseudo' => $request->input('pseudo'),
            ]);
            $members = array();
            $members = $request->input("staff");
            foreach($members as $staff) {
                $teams->staff()->attach($staff);
            }
            return response()->json([
                'status' => 200,
                'team' => new TeamResource($team),
                'staff' => StaffResource::collection($team->staff)
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\teams  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(teams $team)
    {
        if(!$team) {
            return response()->json([
                'status' => 401,
                'message' => 'The team data does not exist'
            ]);
        }
        else {
            $team->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Deleted successfully!'
            ]);
        }
    }
}
