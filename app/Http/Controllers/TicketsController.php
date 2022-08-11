<?php

namespace App\Http\Controllers;

use App\Models\tickets;
use App\Models\Contact;
use App\Http\Resources\TicketResource;
use App\Http\Resources\ContactResource;
use App\Http\Requests\StoreticketsRequest;
use App\Http\Requests\UpdateticketsRequest;

class TicketsController extends Controller
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
            'tickets' => TicketResource::collection(Ticket::all())
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
     * @param  \App\Http\Requests\StoreticketsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreticketsRequest $request)
    {
        //$client = Client::find(Auth::client()->id);
        //if ($client->etat != "prospection"){
            $tickets = Ticket::create(([
                'contact_id' => $request->input('contact_id'),
                'project_id' => $request->input('project_id'),
                'titre' => $request->input('titre'),
                'description' => $request->input('description'),
                'file' => $request->input('file')
            ]));
        //}

        return response()->json([
            'status' => 200,
            'ticket' => new TicketResource($tickets)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tickets  $tickets
     * @return \Illuminate\Http\Response
     */
    public function show(tickets $tickets)
    {
 
       if(!$tickets) {
        return response()->json([
            'status' => 401,
            'message' => 'The ticket data does not exist'
        ]);
    }
    else {
        $contact = $tickets->contact;
        return response()->json([
            'status' => 200,
            'ticket' => new TicketResource($tickets),
           
        ]);
    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tickets  $tickets
     * @return \Illuminate\Http\Response
     */
    public function edit(tickets $tickets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateticketsRequest  $request
     * @param  \App\Models\tickets  $tickets
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateticketsRequest $request, tickets $tickets)
    {
        if(!$tickets) {
            return response()->json([
                'status' => 401,
                'message' => 'The ticket data does not exist'
            ]);
        }
        else {
            $tickets->update(([
                'contact_id' => $request->input('contact_id'),
                'project_id' => $request->input('projet_id'),
                'titre' => $request->input('titre'),
                'description' => $request->input('description'),
                'file' => $request->input('file')
            ]));

            return response()->json([
                'status' => 200,
                'ticket' => new TicketResource($ticket)
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tickets  $tickets
     * @return \Illuminate\Http\Response
     */
    public function destroy(tickets $tickets)
    {
        if(!$tickets) {
            return response()->json([
                'status' => 401,
                'message' => 'The ticket data does not exist'
            ]);
        }
        else {
            $tickets->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Deleted successfully!'
            ]);
        }
    }
}
