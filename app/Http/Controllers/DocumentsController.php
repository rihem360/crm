<?php

namespace App\Http\Controllers;

use App\Models\documents;
use App\Models\operations;
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
            'documents' => DocumentResource::collection(documents::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DocumentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request)
    {
        $document = documents::create([
            'contact_id' => $request->input('contact_id'),
            'type_doc' => $request->input('type_doc'),
            'info_supp' => $request->input('info_supp'),
            'etat' => $request->input('etat')
        ]);
        $operations = array();
        $operations = $request->input('operations');
        foreach($operations as $op) {
            $operation = operations::create([
                'document_id' => $document->id,
                'nature_operation' => $op['nature_operation'],
                'montant_HT' => $op['montant_HT'],
                'montant_TVA' => $op['montant_TVA']
            ]);
        }
        return response()->json([
            'status' => 200,
            'document' => new DocumentResource($document),
            'operations' => OperationResource::collection($document->operations)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\documents  $document
     * @return \Illuminate\Http\Response
     */
    public function show(documents $document)
    {
        if(!$document) {
            return response()->json([
                'status' => 401,
                'message' => 'The document data does not exist'
            ]);
        }
        return response()->json([
            'status' => 200,
            'document' => new DocumentResource($document),
            'operations' => OperationResource::collection($document->operations)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DocumentsRequest  $request
     * @param  \App\Models\documents  $documents
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentsRequest $request, documents $document)
    {
        if(!$document) {
            return response()->json([
                'status' => 401,
                'message' => 'The document data does not exist'
            ]);
        }
        $document->update([
            'contact_id' => $request->input('contact_id'),
            'type_doc' => $request->input('type_doc'),
            'info_supp' => $request->input('info_supp'),
            'etat' => $request->input('etat')
        ]);
        $operations = array();
        $operations = $request->input('operations');
        foreach($operations as $op) {
            $operation = Operation::create([
                'document_id' => $document->id,
                'nature_operation' => $op->nature_operation,
                'montant_HT' => $op['montant_HT'],
                'montant_TVA' => $op['montant_TVA']
            ]);
        }
        return response()->json([
            'status' => 200,
            'document' => new DocumentResource($document),
            'operations' => OperationResource::collection($document->operations)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\documents  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(documents $document)
    {
        if(!$document) {
            return response()->json([
                'status' => 401,
                'message' => 'The document data does not exist'
            ]);
        }
        else {
            $document->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Deleted successfully!'
            ]);
        }
    }
}
