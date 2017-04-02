<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Vehiculo;
use App\Tracker;

class VehiculoTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $vehiculo = Vehiculo::find($id);
        if(!$vehiculo)
        {
            return response()->json(['error'=>array('mensaje' => 'Vehiculo no encontrado.', 'codigo' => 404)], 404);
        }
        return response()->json(['datos' => $vehiculo->tracker()->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $idVehiculo)
    {
        $vehiculo = Vehiculo::find($idVehiculo);
        if (!$vehiculo)
        {
            return response()->json(['error' => array('mensaje' => 'No se encontro el vehiculo.', 'codigo' => 404)], 404);
        }
        else if(!$request->input('imei') || !$request->input('numSIM') || !$request->input('descripcion'))
            {
                return response()->json(['error'=>array('mensaje' => 'Parametros incorrectos.', 'codigo' => 422)], 422);
            }
            else
                {
                    $vehiculo->tracker()->create($request->all());
                    return response()->json(['ok'=>array('mensaje' => 'Recurso guardado.', 'codigo' => 201)], 201);
                }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idVe, $idTrack)
    {
        $vehiculo=Vehiculo::find($idVe);
 
        if (!$vehiculo)
        {
            return response()->json(['error'=>array(['mensaje'=>'No se encuentra el vehiculo.', 'codigo'=>404])],404);
        }       
 
        $tracker = $vehiculo->tracker()->find($idTrack);
 
        if (!$tracker)
        {
            return response()->json(['error'=>array(['mensaje'=>'No se encuentra el tracker.', 'codigo'=>404])],404);
        }   
 
        $imei=$request->input('imei');
        $numSIM=$request->input('numSIM');
        $descripcion=$request->input('descripcion');

        if ($request->method() === 'PATCH')
        {
            $bandera = false;
 
            if ($imei)
            {
                $tracker->imei = $imei;
                $bandera=true;
            }
 
            if ($numSIM)
            {
                $tracker->numSIM = $numSIM;
                $bandera=true;
            }
 
            if ($descripcion)
            {
                $tracker->descripcion = $descripcion;
                $bandera=true;
            }
 
            if ($bandera)
            {
                $tracker->save();
                return response()->json(['ok'=>array('mensaje' => 'Tracker actualizado.', 'codigo' => 204)], 200);
            }
            else
            {
                return response()->json(['error'=>array(['message'=>'No se ha modificado ningún dato del tracker.', 'codigo'=>304])],200);
            }
 
        }
 
        if (!$imei || !$numSIM || !$descripcion)
        {
            return response()->json(['error'=>array(['mensaje'=>'Faltan valores para completar el proceso.', 'codigo'=>422])],422);
        }
 
        $tracker->imei = $imei;
        $tracker->numSIM = $numSIM;
        $tracker->descripcion = $descripcion;
 
        $tracker->save();
 
        return response()->json(['ok'=>array('mensaje' => 'Tracker actualizado.', 'codigo' => 204)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idVe, $idT)
    {
        $vehiculo=Vehiculo::find($idVe);
 
        if (!$vehiculo)
        {
            return response()->json(['error'=>array(['mensaje'=>'No se encuentra el vehiculo.', 'codigo'=>404,])],404);
        }
 
        $tracker = $vehiculo->tracker()->find($idT);
 
        if (!$tracker)
        {
            return response()->json(['error'=>array(['mensaje'=>'No se encuentra el tracker.', 'codigo'=>404])],404);
        }
        $tracker->delete();
        return response()->json(['ok'=>array('mensaje' => 'Recurso borrado.', 'codigo' => 204)], 200);
    }
}
