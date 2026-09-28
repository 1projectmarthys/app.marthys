<?php

namespace App\Http\Controllers;

use App\Models\anggaranhrdnoop;
use Illuminate\Http\Request;

class PrintAnggaranhrdnoop extends Controller
{

    public function show($id)
    {
        //
        //print anggaran hrd noop
        $anggaranhrdnoop = anggaranhrdnoop::with('detail_anggaranhrdnoop')->findOrFail($id);
        return view('anggaranhrdnoop.print', compact('anggaranhrdnoop'));
    }

}
