<?php

namespace App\Http\Controllers;

use App\Models\staff;
use App\Http\Requests\StaffRequest;
use App\Http\Resources\StaffResource;

class StaffController extends Controller
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
            'staff' => StaffResource::collection(staff::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StaffRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffRequest $request)
    {
        $password = $request->input('password');
        $staff = staff::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'num_tel' => $request->input('num_tel'),
            'role' => $request->input('role'),
            'CV' => $request->input('CV'),
            'image' => $request->input('image')
        ]);
       /* $details = [
            'greeting' => 'Hi '.$staff->name,
            'body' => 'Congratulations for joining E-build Team !',
            'credentials' => 'Here are your account credentials:',
            'email' => 'email : '.$staff->email,
            'password' => 'password : '.$password,
            'url' => 'http://localhost:8001/login',
            'thanks' => 'Thank you for using our CRM !',
        ];
        Notification::send($staff, new AccessCredentials($details));
*/
        return response()->json([
            'status' => 200,
            'staff' => new StaffResource($staff)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(staff $staff)
    {
        if(!$staff) {
            return response()->json([
                'status' => 401,
                'message' => 'The staff member data does not exist'
            ]);
        }
        else{
            return response()->json([
                'status' => 200,
                'staff' => new StaffResource($staff)
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatestaffRequest  $request
     * @param  \App\Models\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(StaffRequest $request, staff $staff)
    {
        if(!$staff) {
            return response()->json([
                'status' => 401,
                'message' => 'The staff member data does not exist'
            ]);
        }
        else {
            $staff->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'num_tel' => $request->input('num_tel'),
                'role' => $request->input('role'),
                'CV' => $request->input('CV'),
                'image' => $request->input('image')
            ]);

            return response()->json([
                'status' => 200,
                'staff' => new StaffResource($staff)
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(staff $staff)
    {
        if(!$staff) {
            return response()->json([
                'status' => 401,
                'message' => 'The staff member data does not exist'
            ]);
        }
        else {
            $staff->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Deleted successfully!'
            ]);
        }//
    }
}
