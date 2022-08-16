<?php

namespace App\Http\Controllers;

use App\Models\responses;
use App\Models\tickets;
use App\Models\contact;
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
            'responses' => ResponseResource::collection(responses::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ResponseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResponseRequest $request)
    {
        $responses = Responses::create(([
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
     * @param  \App\Models\responses  $response
     * @return \Illuminate\Http\Response
     */
    public function show(responses $response)
    {
        if(!$response) {
            return response()->json([
                'status' => 401,
                'message' => 'The response data does not exist'
            ]);
        }
        else {
            $ticket = $response->ticket;
            return response()->json([
                'status' => 200,
                'response' => new ResponseResource($response),
                'tickets' => new TicketResource($ticket)
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ResponseRequest  $request
     * @param  \App\Models\responses  $response
     * @return \Illuminate\Http\Response
     */
    public function update(ResponseRequest $request, responses $response)
    {
        if(!$response) {
            return response()->json([
                'status' => 401,
                'message' => 'The response data does not exist'
            ]);
        }
        else {
            $response -> update(([
                'staff_id' => $request->input('staff_id'),
                'ticket_id' => $request->input('ticket_id'),
                'titre' => $request->input('titre'),
                'description' => $request->input('description'),
                'file' => $request->input('file'),
                'image' => $request->input('image'),
            ]));

            return response()->json([
                'status' => 200,
                'response' => new ResponseResource($response)
            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\response  $response
     * @return \Illuminate\Http\Response
     */
    public function destroy(responses $response)
    {
        if(!$response) {
            return response()->json([
                'status' => 401,
                'message' => 'The response data does not exist'
            ]);
        }
        else {
            $response->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Deleted successfully!'
            ]);
        }
    }
}
