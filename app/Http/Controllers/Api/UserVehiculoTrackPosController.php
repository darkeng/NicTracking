<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class UserVehiculoTrackPosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $idU, $idV)
    {
        $user = User::find($idU);
        if(!$user)
        {
            return response()->json(['error'=>array('mensaje' => 'Usuario no encontrado.', 'codigo' => 404)], 404);
        }
        $vehiculo = $user->vehiculos()->find($idV);
        if(!$vehiculo)
        {
            return response()->json(['error'=>array('mensaje' => 'Vehiculo no encontrado.', 'codigo' => 404)], 404);
        }

        $Track = $vehiculo->tracker()->first();
        if(!$Track)
        {
            return response()->json(['error'=>array('mensaje' => 'El vehiculo no posee un tracker.', 'codigo' => 404)], 404);
        }
        if($request->has('ultimos') && is_numeric($request->input('ultimos')))
        {
            return response()->json(['datos' => $Track->posiciones()->orderBy('fecha_registro', 'desc')->limit($request->input('ultimos'))->get()], 200);
        }
        if($request->has('desde') && $request->has('hasta'))
        {
            $validator = Validator::make($request->all(), [
                'desde' => 'required|date',
                'hasta' => 'required|date',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors(), 'codigo' => 422], 422);
            }
            else
            {
            return response()->json(['datos' => $Track->posiciones()->whereBetween('fecha_registro', [$request->input('desde'), $request->input('hasta')])->get()], 200);
            }
        }

        return response()->json(['datos' => $Track->posiciones()->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $idU, $idV)
    {
        $user = User::find($idU);
        if(!$user)
        {
            return response()->json(['error'=>array('mensaje' => 'Usuario no encontrado.', 'codigo' => 404)], 404);
        }
        $vehiculo = $user->vehiculos()->find($idV);
        if(!$vehiculo)
        {
            return response()->json(['error'=>array('mensaje' => 'Vehiculo no encontrado.', 'codigo' => 404)], 404);
        }

        $track = $vehiculo->tracker()->first();
        if(!$track)
        {
            return response()->json(['error'=>array('mensaje' => 'El vehiculo no posee un tracker.', 'codigo' => 404)], 404);
        }

        $validator = Validator::make($request->all(), [
            'velocidad' => 'required|numeric',
            'precision' => 'required|numeric',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
            'altitud' => 'required|numeric',
            'precisionAlt' => 'required|numeric',
            'fecha_registro' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'codigo' => 422], 422);
        }
        else
        {
            $track->posiciones()->create($request->all());
            return response()->json(['ok'=>array('mensaje' => 'Recurso guardado.', 'codigo' => 201)], 201);
        }
            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idU, $idV, $idP)
    {
        $user = User::find($idU);
        if(!$user)
        {
            return response()->json(['error'=>array('mensaje' => 'Usuario no encontrado.', 'codigo' => 404)], 404);
        }
        $vehiculo = $user->vehiculos()->find($idV);
        if(!$vehiculo)
        {
            return response()->json(['error'=>array('mensaje' => 'Vehiculo no encontrado.', 'codigo' => 404)], 404);
        }

        $track = $vehiculo->tracker()->first();
        if(!$track)
        {
            return response()->json(['error'=>array('mensaje' => 'El vehiculo no posee un tracker.', 'codigo' => 404)], 404);
        }

        $posicion = $track->posiciones()->find($idP); 
        if (!$posicion)
        {
            return response()->json(['error'=>array(['mensaje'=>'No se encuentra la posicion.', 'codigo'=>404])],404);
        }
        $posicion->delete();
        return response()->json(['ok'=>array('mensaje' => 'Recurso borrado.', 'codigo' => 204)], 200);
    }
}
