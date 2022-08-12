<?php

namespace App\Http\Controllers;

use App\Models\tickets;
use App\Models\contact;
use App\Http\Resources\TicketResource;
use App\Http\Resources\ContactResource;
use App\Http\Requests\TicketRequest;

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
            'tickets' => TicketResource::collection(tickets::all())
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketRequest $request)
    {
        $ticket = tickets::create(([
            'contact_id' => $request->input('contact_id'),
            'project_id' => $request->input('project_id'),
            'titre' => $request->input('titre'),
            'description' => $request->input('description'),
            'file' => $request->input('file')
        ]));

        return response()->json([
            'status' => 200,
            'ticket' => new TicketResource($ticket)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tickets  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(tickets $ticket)
    {
 
       if(!$ticket) {
        return response()->json([
            'status' => 401,
            'message' => 'The ticket data does not exist'
        ]);
    }
    else {
        $contact = $ticket->contact;
        return response()->json([
            'status' => 200,
            'ticket' => new TicketResource($ticket),
            'contact' => new ContactResource($contact)
        ]);
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TicketRequest  $request
     * @param  \App\Models\tickets  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(TicketRequest $request, tickets $ticket)
    {
        if(!$ticket) {
            return response()->json([
                'status' => 401,
                'message' => 'The ticket data does not exist'
            ]);
        }
        else {
            $ticket->update(([
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
     * @param  \App\Models\tickets  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(tickets $ticket)
    {
        if(!$ticket) {
            return response()->json([
                'status' => 401,
                'message' => 'The ticket data does not exist'
            ]);
        }
        else {
            $ticket->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Deleted successfully!'
            ]);
        }
    }
}
