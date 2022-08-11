<?php

namespace App\Http\Controllers;

use App\Models\operations;
use App\Http\Requests\StoreoperationsRequest;
use App\Http\Requests\UpdateoperationsRequest;

class OperationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreoperationsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreoperationsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\operations  $operations
     * @return \Illuminate\Http\Response
     */
    public function show(operations $operations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\operations  $operations
     * @return \Illuminate\Http\Response
     */
    public function edit(operations $operations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateoperationsRequest  $request
     * @param  \App\Models\operations  $operations
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateoperationsRequest $request, operations $operations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\operations  $operations
     * @return \Illuminate\Http\Response
     */
    public function destroy(operations $operations)
    {
        //
    }
}
