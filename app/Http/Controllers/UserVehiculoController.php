<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Vehiculo;

class UserVehiculoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.basic', ['only' => ['store', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return response()->json(['mensaje' => 'Recurso no encontrado.', 'codigo' => 404], 404);
        }
        return response()->json(['datos' => $user->vehiculos()->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $idUser)
    {
        $user = User::find($idUser);
        if (!$user)
        {
            return response()->json(['mensaje' => 'El recurso asociado no existe.', 'codigo' => 404], 404);
        }
        else if(!$request->input('tipo') || !$request->input('marca') || !$request->input('modelo') || !$request->input('color') || !$request->input('matricula'))
            {
                return response()->json(['mensaje' => 'Parametros incorrectos.', 'codigo' => 422], 422);
            }
            else
                {
                    $user->vehiculos()->create($request->all());
                    return response()->json(['mensaje' => 'Recurso guardado.', 'codigo' => 201], 201);
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idU, $idV)
    {
        
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
    public function destroy($id)
    {
        //
    }
}
