<?php

namespace App\Http\Controllers\Affectation;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamStaffRequest;
use App\Models\teams;
use App\Models\staff;
use App\Http\Resources\TeamResource;
use App\Http\Resources\StaffResource;

class StaffTeamController extends Controller
{
     /**
     * attach an existing staff to an existing team in storage.
     *
     * @param  \App\Http\Requests\TeamStaffRequest  $request
     * @return \Illuminate\Http\Responses
     */
    public function attachStaff(TeamStaffRequest $request)
    {
        $request->validate([
            'staff_id' => 'required',
            'team_id' => 'required',
        ]);
        $team = teams::where('id', $request->team_id)->first();
        $team-staff()->attach($request->staff_id);
        $members = array();
        foreach($team->staff as $staff) {
            $member = new StaffResource($staff);
            $members [] = $member;
        }
        return response()->json([
            'status' => 200,
            'team' => new TeamResource($team),
            'members' => $members
        ]);
    }

     /**
     * detach an existing  from an existing team in storage.
     *
     * @param  \App\Http\Requests\TeamStaffRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function detachStaff(TeamStaffRequest $request) {
        $request->validate([
            'staff_id' => 'required',
            'team_id' => 'required',
        ]);
        $team = Team::where('id', $request->team_id)->first();
        $team->staff()->detach($request->staff_id);
        $members = array();
        $member = "No members added yet !";
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

}