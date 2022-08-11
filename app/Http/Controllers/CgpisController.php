<?php

namespace App\Http\Controllers;

use App\Models\cgpi;
use App\Http\Requests\StorecgpiRequest;
use App\Http\Requests\UpdatecgpiRequest;
use Illuminate\Support\Facades\Hash;
use App\Notifications\AccessCredentials;
use Illuminate\Support\Facades\Notification;
class CgpisController extends Controller
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
            'cgpis' => CgpiResource::collection(Cgpi::all())
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
     * @param  \App\Http\Requests\StorecgpiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorecgpiRequest $request)
    {
        $cgpi = Cgpi::create(([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'num_tel' => $request->input('num_tel'),
            'staff' => $request->input('staff'),
            
        ]));

        return response()->json([
            'status' => 200,
            'cgpi' => new CgpiResource($cgpi)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cgpi  $cgpi
     * @return \Illuminate\Http\Response
     */
    public function show(cgpi $cgpi)
    {
        if(!$cgpi) {
            return response()->json([
                'status' => 401,
                'message' => 'The cgpi data does not exist'
            ]);
        }
        else {
            return response()->json([
                'status' => 200,
                'cgpi' => new CgpiResource($cgpi)
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cgpi  $cgpi
     * @return \Illuminate\Http\Response
     */
    public function edit(cgpi $cgpi)
    {
        if(!$cgpi) {
            return response()->json([
                'status' => 401,
                'message' => 'The cgpi data does not exist'
            ]);
        }
        else {
            $password = $request->input('password');
            $cgpi->update(([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($password),
                'num_tel' => $request->input('num_tel'),
                'staff' => $request->input('staff'),
            
            ]));
            $details = [
                'greeting' => 'Hi '.$cgpi->name,
                'body' => 'Congratulations for becoming an official cgpi with Weaplan !',
                'credentials' => 'Here are your account credentials:',
                'email' => 'email : '.$cgpi->email,
                'password' => 'password : '.$password,
                'url' => 'http://localhost:8001/login',
                'thanks' => 'Thank you !',
            ];
            Notification::send($cgpi, new AccessCredentials($details));

            return response()->json([
                'status' => 200,
                'cgpi' => new CgpiResource($cgpi)
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatecgpiRequest  $request
     * @param  \App\Models\cgpi  $cgpi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatecgpiRequest $request, cgpi $cgpi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cgpi  $cgpi
     * @return \Illuminate\Http\Response
     */
    public function destroy(cgpi $cgpi)
    {
        if(!$cgpi) {
            return response()->json([
                'status' => 401,
                'message' => 'The cgpi data does not exist'
            ]);
        }
        else {
            $cgpi->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Deleted successfully!'
            ]);
        }
    }
}
