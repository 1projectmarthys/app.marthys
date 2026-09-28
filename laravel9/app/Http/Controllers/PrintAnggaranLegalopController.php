<?php

namespace App\Http\Controllers;
use App\Models\anggaranlegalop;
use Illuminate\Http\Request;

class PrintAnggaranLegalopController extends Controller
{
    //
    public function show($id)
    {
        //
        $anggaranlegalop = anggaranlegalop::with('detail_anggaranlegalop', 'serieslegalop')->findOrFail($id);
        return view('anggaranlegalop.print', compact('anggaranlegalop'));
    }
}
