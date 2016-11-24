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
                    $user->vehiculos()->create($request->all());
                    return response()->json(['ok'=>array('mensaje' => 'Recurso guardado.', 'codigo' => 201)], 201);
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
            return response()->json(['error'=>array(['codigo'=>404,'mensaje'=>'No se encuentra el usuario.'])],404);
        }       
 
        $vehiculo = $user->vehiculos()->find($idVe);
 
        if (!$vehiculo)
        {
            return response()->json(['error'=>array(['codigo'=>404,'mensaje'=>'No se encuentra el vehiculo.'])],404);
        }   
 
        $nombre=$request->input('nombre');
        $apellido=$request->input('apellido');
        $telefono=$request->input('telefono');
        $direccion=$request->input('direccion');
 
        // Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
        // El método de la petición se sabe a través de $request->method();
        /*  nombre      apellido        telefono       direccion       Alcance */
        if ($request->method() === 'PATCH')
        {
            // Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
            $bandera = false;
 
            // Actualización parcial de campos.
            if ($nombre)
            {
                $vehiculo->nombre = $nombre;
                $bandera=true;
            }
 
            if ($apellido)
            {
                $vehiculo->apellido = $apellido;
                $bandera=true;
            }
 
            if ($telefono)
            {
                $vehiculo->telefono = $telefono;
                $bandera=true;
            }
 
            if ($direccion)
            {
                $vehiculo->direccion = $direccion;
                $bandera=true;
            }
 
            if ($bandera)
            {
                // Almacenamos en la base de datos el registro.
                $vehiculo->save();
                return response()->json(['status'=>'ok','data'=>$vehiculo], 200);
            }
            else
            {
                // Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
                // Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
                return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del vehiculo.'])],304);
            }
 
        }
 
        // Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
        if (!$nombre || !$apellido || !$telefono || !$direccion)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el proceso.'])],422);
        }
 
        $vehiculo->nombre = $nombre;
        $vehiculo->apellido = $apellido;
        $vehiculo->telefono = $telefono;
        $vehiculo->direccion = $direccion;
 
        // Almacenamos en la base de datos el registro.
        $vehiculo->save();
 
        return response()->json(['status'=>'ok','data'=>$vehiculo], 200);
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
