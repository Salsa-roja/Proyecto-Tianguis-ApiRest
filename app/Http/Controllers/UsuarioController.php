<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UsuarioService;
use App\Services\ArchivosService;
use App\Services\SocketService;

class UsuarioController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    } 

    public function listado(Request $request){
        try {
            $items = UsuarioService::listado($request->auth);
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function guardar(){
        try{
            $this->validate($this->request, [
                'nombres' =>'required',
                'ape_paterno' =>'required',
                'ape_materno' =>'required',
                'correo' =>'required',
                'nombre_login' => 'required',
                'contrasena' =>'required'
            ]);
            $params = $this->request->all();
            $params["request"] = $this->request;

            #valida si el usuario ya existe
            if( UsuarioService::existeByUsername($params['nombre_login']) ){                
                $this->msg='El nombre de usuario ya está en uso, utiliza otro';
                $this->statusHttp = 400;
                return $this->jsonResponse();
            }

            $resp = UsuarioService::guardar($params);
            $this->status = ($resp)?true:false;
            $this->statusHttp = ($this->status)?200:401;
            $this->data = $resp;
            return $this->jsonResponse();
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function editar(){
        try{
            $this->validate($this->request, [
                'id' =>'required',
                'nombres' =>'required',
                'ape_paterno' =>'required',
                'ape_materno' =>'required',
                'correo' =>'required',
                'nombre_login' => 'required'
            ]);
            $params = $this->request->all();
            $params["request"] = $this->request;

            $Usuario = UsuarioService::searchById($params['id'],false);

            #si cambia el nombre de usuario
            if($Usuario->nombre_login != $params['nombre_login']){
                #valida si el usuario ya existe
                if( UsuarioService::existeByUsername($params['nombre_login']) ){
                    $this->msg = 'El nombre de usuario ya está en uso, utiliza otro';
                    $this->statusHttp = 400;
                    return $this->jsonResponse();
                }
            }
            $resp = UsuarioService::editar($params);
            $this->status = ($resp)?true:false;
            $this->statusHttp = ($this->status)?200:401;
            $this->data = $resp;
            return $this->jsonResponse();
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function detalle($usuarioId){
        try {
            $Usuario = UsuarioService::searchById($usuarioId);
            $this->data=[$Usuario,$this->request->auth];

            # Solo admins o usuarios que pertenezcan a la misma empresa que el usuario solicitado pueden ver el detalle
            if($this->request->auth->rol=='Administrador' || $Usuario->idEmpresa == $this->request->auth->id_empresa){
                $this->data=$Usuario;
            } else{
                $this->msg='No tienes permisos suficientes para ver la informacion del usuario';
                $this->statusHttp=401;
                $this->status=false;
            }
            return $this->jsonResponse();
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function getLastNotifications($usuarioId){
        try {
            $this->data = UsuarioService::getLastNotifications($usuarioId);
            return $this->jsonResponse();
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500); 
        }
    }

    public function setNotificationSeen($notifId){
        try {

            $this->data = SocketService::setSeen($notifId);
            return $this->jsonResponse();
            
        } catch (\Exception $ex) {
            return response()->json_encode(['error' => $ex->getMessage()], 500);
        }
    }
}
