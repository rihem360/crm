<?php

namespace App\Http\Controllers\Affectation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teams;
use App\Models\Staff;
use App\Http\Resources\TeamResource;
use App\Http\Resources\StaffResource;
use App\Http\Requests\StaffTeamRequest;

class StaffTeamController extends Controller
{
     /**
     * attach an existing staff to an existing team in storage.
     *
     * @param  \App\Http\Requests\StaffTeamRequest  $request
     * @return \Illuminate\Http\Responses
     */
    public function attachStaff(StaffTeamRequest $request)
    {
        $request->validate([
            'staff_id' => 'required',
            'team_id' => 'required',
        ]);
        $teams = Team::where('id', $request->team_id)->first();
        $teams-staff()->attach($request->staff_id);
        $members = array();
        foreach($teams->staff as $staff) {
            $member = new StaffResource($staff);
            $members [] = $member;
        }
        return response()->json([
            'status' => 200,
            'team' => new TeamResource($teams),
            'members' => $members
        ]);
    }

     /**
     * detach an existing  from an existing team in storage.
     *
     * @param  \App\Http\Requests\StaffTeamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function detachStaff(StaffTeamRequest $request) {
        $request->validate([
            'staff_id' => 'required',
            'team_id' => 'required',
        ]);
        $teams = Team::where('id', $request->team_id)->first();
        $teams->staff()->detach($request->staff_id);
        $members = array();
        $member = "No members added yet !";
        foreach($teams->staff as $Staff) {
            $member = new StaffResource($Staff);
            $members [] = $member;
        }
        return response()->json([
            'status' => 200,
            'equipe' => new EquipeResource($teams),
            'members' => $members
        ]);
    }

}