<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Posicion;

class PosicionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json(['datos' => Posicion::all()],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posicion = Posicion::find($id);
        if(!$posicion)
        {
            return response()->json(['error'=>array('mensaje' => 'No se encontro la posicion.', 'codigo' => 404)], 404);
        }
        return response()->json(['datos' => $posicion], 200);
    }
}
