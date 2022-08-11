<?php

namespace App\Http\Controllers;

use App\Models\teams;
use App\Models\Staff;

use App\Http\Resources\TeamResource;
use App\Http\Resources\StaffResource;
use App\Http\Requests\StoreteamsRequest;
use App\Http\Requests\UpdateteamsRequest;

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
            'teams' => TeamResource::collection(Team::all())
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
     * @param  \App\Http\Requests\StoreteamsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreteamsRequest $request)
    {
        $teams = Team::create([
            'pseudo' => $request->input('pseudo'),
        ]);
        $members = array();
        $members = $request->input("staff");
        foreach($members as $staff) {
            $teams->staff()->attach($staff);
        }
        return response()->json([
            'status' => 200,
            'team' => new TeamResource($teams),
            'staff' => StaffResource::collection($teams->staff)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\teams  $teams
     * @return \Illuminate\Http\Response
     */
    public function show(teams $teams)
    {
        if(!$teams) {
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
            'equipe' => new TeamResource($teams),
            'members' => $members
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\teams  $teams
     * @return \Illuminate\Http\Response
     */
    public function edit(teams $teams)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateteamsRequest  $request
     * @param  \App\Models\teams  $teams
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateteamsRequest $request, teams $teams)
    {
        if(!$teams) {
            return response()->json([
                'status' => 401,
                'message' => 'The team data does not exist'
            ]);
        }
        else {
            $teams->update([
                'pseudo' => $request->input('pseudo'),
            ]);
            $members = array();
            $members = $request->input("staff");
            foreach($members as $staff) {
                $teams->staff()->attach($staff);
            }
            return response()->json([
                'status' => 200,
                'team' => new TeamResource($teams),
                'staff' => StaffResource::collection($teams->staff)
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\teams  $teams
     * @return \Illuminate\Http\Response
     */
    public function destroy(teams $teams)
    {
        if(!$teams) {
            return response()->json([
                'status' => 401,
                'message' => 'The team data does not exist'
            ]);
        }
        else {
            $teams->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Deleted successfully!'
            ]);
        }
    }
}
