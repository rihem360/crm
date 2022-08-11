<?php

namespace App\Http\Controllers;

use App\Models\documents;
use App\Models\Operation;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\OperationResource;
use App\Http\Requests\DocumentRequest;

class DocumentsController extends Controller
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
            'documents' => DocumentResource::collection(Document::all())
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
     * @param  \App\Http\Requests\StoredocumentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoredocumentsRequest $request)
    {
        $documents = Documents::create([
            'contact_id' => $request->input('contact_id'),
            'type_doc' => $request->input('type_doc'),
            'info_supp' => $request->input('info_supp'),
            'etat' => $request->input('etat')
        ]);
        $operations = array();
        $operations = $request->input('operations');
        foreach($operations as $op) {
            $operation = Operation::create([
                'document_id' => $documents->id,
                'nature_operation' => $op['nature_operation'],
                'montant_HT' => $op['montant_HT'],
                'montant_TVA' => $op['montant_TVA']
            ]);
        }
        return response()->json([
            'status' => 200,
            'document' => new DocumentResource($documents),
            'operations' => OperationResource::collection($documents->operations)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\documents  $documents
     * @return \Illuminate\Http\Response
     */
    public function show(documents $documents)
    {
        if(!$documents) {
            return response()->json([
                'status' => 401,
                'message' => 'The document data does not exist'
            ]);
        }
        return response()->json([
            'status' => 200,
            'document' => new DocumentResource($documents),
            'operations' => OperationResource::collection($documents->operations)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\documents  $documents
     * @return \Illuminate\Http\Response
     */
    public function edit(documents $documents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatedocumentsRequest  $request
     * @param  \App\Models\documents  $documents
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatedocumentsRequest $request, documents $documents)
    {
        if(!$team) {
            return response()->json([
                'status' => 401,
                'message' => 'The document data does not exist'
            ]);
        }
        $documents->update([
            'contact_id' => $request->input('contact_id'),
            'type_doc' => $request->input('type_doc'),
            'info_supp' => $request->input('info_supp'),
            'etat' => $request->input('etat')
        ]);
        $operations = array();
        $operations = $request->input('operations');
        foreach($operations as $op) {
            $operation = Operation::create([
                'document_id' => $documents->id,
                'nature_operation' => $op->nature_operation,
                'montant_HT' => $op->montant_HT,
                'montant_TVA' => $op->montant_TVA
            ]);
        }
        return response()->json([
            'status' => 200,
            'document' => new DocumentResource($documents),
            'operations' => OperationResource::collection($documents->operations)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\documents  $documents
     * @return \Illuminate\Http\Response
     */
    public function destroy(documents $documents)
    {
        if(!$documents) {
            return response()->json([
                'status' => 401,
                'message' => 'The document data does not exist'
            ]);
        }
        else {
            $documents->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Deleted successfully!'
            ]);
        }
    }
}
