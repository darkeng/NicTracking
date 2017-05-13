<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Vehiculo;

class VehiculoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['datos' => Vehiculo::all()],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehiculo = Vehiculo::find($id);
        if(!$vehiculo)
        {
            return response()->json(['error'=>array('mensaje' => 'No se encontro el vehiculo.', 'codigo' => 404)], 404);
        }
        return response()->json(['datos' => $vehiculo], 200);
    }
}
