<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UsuarioService;
use App\Services\ArchivosService;

class UsuarioController extends Controller
{
    public function __construct()
    {
        //
    } 

    public function listado(){
        try {
            $items = UsuarioService::listado();
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function guardar(Request $request){
        try{
            /* pendiente validacion de que tipo de usuario se va a agregar */
            $this->validate($request, [
                'rol_id' =>'required',
                'nombres' =>'required',
                'ape_paterno' =>'required',
                'ape_materno' =>'required',
                'correo' =>'required',
                'contrasena' =>'required',
                'activo' =>'required'
            ]);
            $params = $request->all();
            $params["request"] = $request;

            $items = UsuarioService::guardar($params);
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

}
