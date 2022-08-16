<?php

namespace App\Http\Controllers;

use App\Models\cgpi;
use App\Http\Resources\CgpiResource;
use App\Http\Requests\CgpiRequest;
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
            'cgpis' => CgpiResource::collection(cgpi::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CgpiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CgpiRequest $request)
    {
        $cgpi = cgpi::create(([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'num_tel' => $request->input('num_tel'),
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
            $customers = $cgpi->customers;
            return response()->json([
                'status' => 200,
                'cgpi' => new CgpiResource($cgpi),
                'customers'=> $customers
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CgpiRequest  $request
     * @param  \App\Models\cgpi  $cgpi
     * @return \Illuminate\Http\Response
     */
    public function update(CgpiRequest $request, cgpi $cgpi)
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
            ]));
           /*$details = [
                'greeting' => 'Hi '.$cgpi->name,
                'body' => 'Congratulations for becoming an official cgpi with Weaplan !',
                'credentials' => 'Here are your account credentials:',
                'email' => 'email : '.$cgpi->email,
                'password' => 'password : '.$password,
                'url' => 'http://localhost:8001/login',
                'thanks' => 'Thank you !',
            ];
            Notification::send($cgpi, new AccessCredentials($details));
*/
            return response()->json([
                'status' => 200,
                'cgpi' => new CgpiResource($cgpi)
            ]);
        }
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
