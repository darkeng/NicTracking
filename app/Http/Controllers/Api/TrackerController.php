<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tracker;

class TrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['datos' => Tracker::all()],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tracker = Tracker::find($id);
        if(!$tracker)
        {
            return response()->json(['error'=>array('mensaje' => 'Tracker no encontrado.', 'codigo' => 404)], 404);
        }
        return response()->json(['datos' => $tracker], 200);
    }
}
