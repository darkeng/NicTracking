<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Vehiculo;

class UserVehiculoController extends Controller
{

    /*public function __construct()
    {
        $this->middleware('auth.basic.once', ['only' => ['store', 'update', 'destroy']]);
    }*/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($idUser)
    {
        $user = User::find($idUser);
        if(!$user)
        {
            return response()->json(['error'=>array('mensaje' => 'No se encontro el usuario.', 'codigo' => 404)], 404);
        }
        return response()->json(['datos' => $user->vehiculos()->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $idUser
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $idUser)
    {
        $user = User::find($idUser);
        if (!$user)
        {
            return response()->json(['error' => array('mensaje' => 'No se encontro el usuario.', 'codigo' => 404)], 404);
        }
        else if(!$request->input('tipo') || !$request->input('marca') || !$request->input('modelo') || !$request->input('color') || !$request->input('matricula'))
            {
                return response()->json(['error'=>array('mensaje' => 'Parametros incorrectos.', 'codigo' => 422)], 422);
            }
            else
                {
                    $userRet=$user->vehiculos()->create($request->all());
                    return response()->json(['ok'=>array('mensaje' => 'Recurso guardado.', 'id' => $userRet->id, 'codigo' => 201)], 201);
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idUser, $idVe)
    {
        if (!User::find($idUser))
        {
            return response()->json(['error' => array('mensaje' => 'No se encontro el usuario.', 'codigo' => 404)], 404);
        }
        $vehiculo=Vehiculo::find($idVe);
        if (!$vehiculo)
        {
            return response()->json(['error' => array('mensaje' => 'No se encontro el vehiculo.', 'codigo' => 404)], 404);
        }
        return response()->json(['datos'=>$vehiculo], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idUser, $idVe)
    {
        $user=User::find($idUser);
 
        if (!$user)
        {
            return response()->json(['error'=>array(['mensaje'=>'No se encuentra el usuario.', 'codigo'=>404])],404);
        }       
 
        $vehiculo = $user->vehiculos()->find($idVe);
 
        if (!$vehiculo)
        {
            return response()->json(['error'=>array(['mensaje'=>'No se encuentra el vehiculo.', 'codigo'=>404])],404);
        }   
 
        $tipo=$request->input('tipo');
        $marca=$request->input('marca');
        $modelo=$request->input('modelo');
        $color=$request->input('color'); 
        $matricula=$request->input('matricula');
        $perdido=$request->input('perdido');

        // Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
        /*  tipo      marca        modelo       color   matricula   perdido*/
        if ($request->method() === 'PATCH')
        {
            // Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
            $bandera = false;
 
            // Actualización parcial de campos.
            if ($tipo)
            {
                $vehiculo->tipo = $tipo;
                $bandera=true;
            }
 
            if ($marca)
            {
                $vehiculo->marca = $marca;
                $bandera=true;
            }
 
            if ($modelo)
            {
                $vehiculo->modelo = $modelo;
                $bandera=true;
            }
 
            if ($color)
            {
                $vehiculo->color = $color;
                $bandera=true;
            }

            if ($matricula)
            {
                $vehiculo->matricula = $matricula;
                $bandera=true;
            }

            if ($perdido)
            {
                $vehiculo->perdido = $perdido;
                $bandera=true;
            }
 
            if ($bandera)
            {
                // Almacenamos en la base de datos el registro.
                $vehiculo->save();
                return response()->json(['ok'=>array('mensaje' => 'Vehiculo actualizado.', 'codigo' => 204)], 200);
            }
            else
            {
                // Se devuelve un array error con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
                // Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
                return response()->json(['error'=>array(['message'=>'No se ha modificado ningún dato del vehiculo.', 'codigo'=>304])],200);
            }
 
        }
 
        // Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
        if (!$tipo || !$marca || !$modelo || !$color || !$matricula || !$perdido)
        {
            // Se devuelve un array error con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['error'=>array(['mensaje'=>'Faltan valores para completar el proceso.', 'codigo'=>422])],422);
        }
 
        $vehiculo->tipo = $tipo;
        $vehiculo->marca = $marca;
        $vehiculo->modelo = $modelo;
        $vehiculo->color = $color;
        $vehiculo->matricula = $matricula;
        $vehiculo->perdido = $perdido;
 
        // Almacenamos en la base de datos el registro.
        $vehiculo->save();
 
        return response()->json(['ok'=>array('mensaje' => 'Vehiculo actualizado.', 'codigo' => 204)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idUser, $idVehiculo)
    {
        $user=User::find($idUser);
 
        if (!$user)
        {
            return response()->json(['error'=>array(['mensaje'=>'No se encuentra el usuario.', 'codigo'=>404,])],404);
        }       
 
        $vehiculo = $user->vehiculos()->find($idVehiculo);
 
        if (!$vehiculo)
        {
            return response()->json(['error'=>array(['mensaje'=>'No se encuentra el vehiculo.', 'codigo'=>404])],404);
        }
        $vehiculo->delete();
        return response()->json(['ok'=>array('mensaje' => 'Recurso borrado.', 'codigo' => 204)], 200);
    }
}
