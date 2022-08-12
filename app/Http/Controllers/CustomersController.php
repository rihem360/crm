<?php

namespace App\Http\Controllers;

use App\Models\customers;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use Illuminate\Support\Facades\Hash;
use App\Notifications\AccessCredentials;
use Illuminate\Support\Facades\Notification;
class CustomersController extends Controller
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
            'customer' => CustomerResource::collection(customers::all())
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
     * @param  \App\Http\Requests\CustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $customer = customers::create(([
            'cgpi_id' => $request->input('cgpi_id'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'num_tel' => $request->input('num_tel'),
            'raison_sociale' => $request->input('raison_sociale'),
            'location' => $request->input('location'),
            'industry' => $request->input('industry'),
            'aum' => $request->input('aum'),
           
        ]));

        return response()->json([
            'status' => 200,
            'customer' => new CustomerResource($customer)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function show(customers $customer)
    {
        if(!$customer) {
            return response()->json([
                'status' => 401,
                'message' => 'The customer data does not exist'
            ]);
        }
        else {
            return response()->json([
                'status' => 200,
                'customer' => new CustomerResource($customer)
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function edit(customers $customers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CustomerRequest  $request
     * @param  \App\Models\customers  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, customers $customer)
    {   
        if(!$customer) {
            return response()->json([
                'status' => 401,
                'message' => 'The customer data does not exist'
            ]);
        }
        else {
            $customer->update([
                'cgpi_id' => $request->input('cgpi_id'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'num_tel' => $request->input('num_tel'),
                'raison_sociale' => $request->input('raison_sociale'),
                'location' => $request->input('location'),
                'industry' => $request->input('industry'),
                'aum' => $request->input('aum'),
            ]);
            /*$details = [
                'greeting' => 'Hi '.$customers->name,
                'body' => 'Congratulations for becoming an official client of E-Build !',
                'credentials' => 'Here are your account credentials:',
                'email' => 'email : '.$customers->email,
                'password' => 'password : '.$password,
                'url' => 'http://localhost:8001/login',
                'thanks' => 'Thank you for choosing E-Build !',
            ];
            Notification::send($customers, new AccessCredentials($details));
*/
            return response()->json([
                'status' => 200,
                'customer' => new CustomerResource($customer)
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customers  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(customers $customer)
    {
        $customer = customers::where('id', $id)->first();
        if(!$customer) {
            return response()->json([
                'status' => 401,
                'message' => 'The client data does not exist'
            ]);
        }
        else {
            $customer->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Deleted successfully!'
            ]);
        }
    }
}
