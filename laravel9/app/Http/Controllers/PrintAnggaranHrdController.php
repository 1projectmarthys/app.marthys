<?php

namespace App\Http\Controllers;

use App\Models\anggaranhrd;
use Illuminate\Http\Request;

class PrintAnggaranHrdController extends Controller
{

    public function show($id)
    {
        //print anggaran hrd
        $anggaranhrd = anggaranhrd::with('detail_anggaranhrd')->findOrFail($id);
        return view('anggaranhrd.print', compact('anggaranhrd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

}
