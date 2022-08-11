<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\Ticket;
use App\Models\Contact;
use App\Http\Resources\ResponseResource;
use App\Http\Resources\TicketResource;
use App\Http\Resources\ContactResource;
use App\Http\Requests\ResponseRequest;


class ResponsesController extends Controller
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
            'responses' => ResponseResource::collection(Response::all())
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
     * @param  \App\Http\Requests\ResponseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResponseRequest $request)
    {
        $responses = Response::create(([
            'staff_id' => $request->input('staff_id'),
            'ticket_id' => $request->input('ticket_id'),
            'titre' => $request->input('titre'),
            'description' => $request->input('description'),
            'file' => $request->input('file'),
            'image' => $request->input('image'),
        ]));

        return response()->json([
            'status' => 200,
            'response' => new ResponseResource($responses)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $responses = Response::where('id', $id)->first();
        if(!$responses) {
            return response()->json([
                'status' => 401,
                'message' => 'The response data does not exist'
            ]);
        }
        else {
            $ticket = $responses->ticket;
            return response()->json([
                'status' => 200,
                'response' => new ResponseResource($responses),
                'tickets' => new ResponseResource($tickets)
            ]);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Response  $responses
     * @return \Illuminate\Http\Response
     */
    public function edit(Response $responses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ResponseRequest  $request
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function update(ResponseRequest $request, Response $responses)
    {
        if(!$responses) {
            return response()->json([
                'status' => 401,
                'message' => 'The response data does not exist'
            ]);
        }
        else {
            $responses = update(([
                'ticket_id' => $request->input('ticket_id'),
                'titre' => $request->input('titre'),
                'description' => $request->input('description'),
                'file' => $request->input('file'),
                'image' => $request->input('image'),
            ]));

            return response()->json([
                'status' => 200,
                'response' => new ResponseResource($responses)
            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Response  $responses
     * @return \Illuminate\Http\Response
     */
    public function destroy(Response $responses)
    {
        if(!$responses) {
            return response()->json([
                'status' => 401,
                'message' => 'The response data does not exist'
            ]);
        }
        else {
            $responses->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Deleted successfully!'
            ]);
        }
    }
}
