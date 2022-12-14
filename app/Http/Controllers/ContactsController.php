<?php

namespace App\Http\Controllers;

use App\Models\contact;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use Illuminate\Support\Facades\Hash;
use App\Notifications\AccessCredentials;
use Illuminate\Support\Facades\Notification;
class ContactsController extends Controller
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
            'contacts' => ContactResource::collection(contact::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        $contact = contact::create(([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'num_tel' => $request->input('num_tel'),
            'company' => $request->input('company'),
        ]));

        return response()->json([
            'status' => 200,
            'contact' => new ContactResource($contact)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(contact $contact)
    {
        if(!$contact) {
            return response()->json([
                'status' => 401,
                'message' => 'The contact data does not exist'
            ]);
        }
        else {
            return response()->json([
                'status' => 200,
                'contact' => new ContactResource($contact)
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ContactRequest  $request
     * @param  \App\Models\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, contact $contact)
    {
        if(!$contact) {
            return response()->json([
                'status' => 401,
                'message' => 'The contact data does not exist'
            ]);
        }
        else {
            $password = $request->input('password');
            $contact->update(([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($password),
                'num_tel' => $request->input('num_tel'),
                'company' => $request->input('company'),
                
            ]));
            /*$details = [
                'greeting' => 'Hi '.$contact->name,
                'body' => 'Congratulations for becoming an official contact of Weaplan !',
                'credentials' => 'Here are your account credentials:',
                'email' => 'email : '.$contact->email,
                'password' => 'password : '.$password,
                'url' => 'http://localhost:8001/login',
                'thanks' => 'Thank you for choosing Weaplan !',
            ];
            Notification::send($contact, new AccessCredentials($details));
*/
            return response()->json([
                'status' => 200,
                'contact' => new ContactResource($contact)
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(contact $contact)
    {
        if(!$contact) {
            return response()->json([
                'status' => 401,
                'message' => 'The contact data does not exist'
            ]);
        }
        else {
            $contact->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Deleted successfully!'
            ]);
        }
    }
}

