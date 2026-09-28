<?php

namespace App\Http\Controllers;

use App\Models\serieslegalop;
use Illuminate\Http\Request;

class SerieslegalopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('serieslegalop.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        return view('serieslegalop.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\serieslegalop  $serieslegalop
     * @return \Illuminate\Http\Response
     */
    public function show(serieslegalop $serieslegalop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\serieslegalop  $serieslegalop
     * @return \Illuminate\Http\Response
     */
    public function edit(serieslegalop $serieslegalop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\serieslegalop  $serieslegalop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, serieslegalop $serieslegalop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\serieslegalop  $serieslegalop
     * @return \Illuminate\Http\Response
     */
    public function destroy(serieslegalop $serieslegalop)
    {
        //
    }
}
