<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tracker;
use App\Posicion;

class TrackerPosicionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($idTrack)
    {
        $Track = Tracker::find($idTrack);
        if(!$Track)
        {
            return response()->json(['error'=>array('mensaje' => 'No se encontro el rastreador.', 'codigo' => 404)], 404);
        }
        return response()->json(['datos' => $Track->posiciones()->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $idTrack)
    {
        $track = Tracker::find($idTrack);
        if (!$track)
        {
            return response()->json(['error' => array('mensaje' => 'No se encontro el tracker.', 'codigo' => 404)], 404);
        }
        else if(!$request->input('lat') || !$request->input('lan') || !$request->input('fecha_registro'))
            {
                return response()->json(['error'=>array('mensaje' => 'Parametros incorrectos.', 'codigo' => 422)], 422);
            }
            else
                {
                    $track->posiciones()->create($request->all());
                    return response()->json(['ok'=>array('mensaje' => 'Recurso guardado.', 'codigo' => 201)], 201);
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idT, $idP)
    {
        $tracker=Tracker::find($idT);
 
        if (!$tracker)
        {
            return response()->json(['error'=>array(['mensaje'=>'No se encuentra el tracker.', 'codigo'=>404,])],404);
        }
 
        $posicion = $tracker->Posiciones()->find($idP);
 
        if (!$posicion)
        {
            return response()->json(['error'=>array(['mensaje'=>'No se encuentra la Posicion.', 'codigo'=>404])],404);
        }
        $posicion->delete();
        return response()->json(['ok'=>array('mensaje' => 'Recurso borrado.', 'codigo' => 204)], 200);
    }
}
