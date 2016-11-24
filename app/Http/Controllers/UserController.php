<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        return response()->json(['datos' => $users, 'codigo' => 200], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->input('nombre') || !$request->input('apellido') || !$request->input('email') || !$request->input('password') || !$request->input('direccion'))
            {
                return response()->json(['mensaje' => 'Parametros incorrectos.', 'codigo' => 422], 422);
            }
            else
                {
                    User::create($request->all());
                    return response()->json(['mensaje' => 'Recurso guardado.', 'codigo' => 201], 201);
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
        $user=User::find($id);
        if(!$user)
        {
            return response()->json(['mensaje' => 'Recurso no encontrado.', 'codigo' => 404], 404);
        }

        return response()->json(['datos' => $user], 200);
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
        $user = User::find($id);
        if (!$user)
        {
            return response()->json(['mensaje' => 'El recurso asociado no existe.', 'codigo' => 404], 404);
        }
        else if(!$request->input('nombre') || !$request->input('apellido') || !$request->input('email') || !$request->input('password') || !$request->input('direccion'))
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
