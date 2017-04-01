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
        return response()->json(['datos' => $users], 200);
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
                return response()->json(['error'=>array('mensaje' => 'Parametros incorrectos.', 'codigo' => 422)], 422);
            }
            else
                {
                    User::create($request->all());
                    return response()->json(['ok'=>array('mensaje' => 'Usuario guardado.', 'codigo' => 201)], 201);
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
            return response()->json(['error'=>array('mensaje' => 'Usuario no encontrado.', 'codigo' => 404)], 404);
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
            return response()->json(['mensaje' => 'El usuario no existe.', 'codigo' => 404], 404);
        }
        
        $nombre=$request->input('nombre');
        $apellido=$request->input('apellido');
        $email=$request->input('email');
        $password=$request->input('password'); 
        $direccion=$request->input('direccion');

        if ($request->method() === 'PATCH')
        {
            $bandera = false;
 
            if ($nombre)
            {
                $user->nombre = $nombre;
                $bandera=true;
            }
 
            if ($apellido)
            {
                $user->apellido = $apellido;
                $bandera=true;
            }
 
            if ($email)
            {
                $user->email = $email;
                $bandera=true;
            }
 
            if ($password)
            {
                $user->password = $password;
                $bandera=true;
            }
            if ($direccion)
            {
                $user->direccion = $direccion;
                $bandera=true;
            }
 
            if ($bandera)
            {
                $user->save();
                return response()->json(['ok'=>array('mensaje' => 'Usuario actualizado.', 'codigo' => 204)], 200);
            }
            else
            {
                return response()->json(['error'=>array(['message'=>'No se ha modificado ningún dato de esta usuario.', 'codigo'=>304])],200);
            }
 
        }
 
        if (!$nombre || !$apellido || !$email || !$password || !$direccion)
        {
            return response()->json(['error'=>array(['mensaje'=>'Faltan valores para completar el proceso.', 'codigo'=>422])],422);
        }
 
        $user->nombre = $nombre;
        $user->apellido = $apellido;
        $user->email = $email;
        $user->password = $password;
        $user->direccion = $direccion;
 
        $user->save();
 
        return response()->json(['ok'=>array('mensaje' => 'Usuario actualizado.', 'codigo' => 204)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user)
        {
            return response()->json(['error'=>array('mensaje' => 'El usuario no existe.', 'codigo' => 404)], 404);
        }
        $user->delete();
        return response()->json(['ok'=>array('mensaje' => 'Usuario borrado.', 'codigo' => 204)], 200);
    }
}
