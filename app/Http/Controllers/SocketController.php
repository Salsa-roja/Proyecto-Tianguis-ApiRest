<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SocketService;
use App\Services\UsuarioService;

class SocketController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    } 

    public function listConnections(){
        try {
            
            $items = SocketService::listConnections();
            
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function saveConnection(){
        try {
            
            $this->validate($this->request, [
               'idHandshake' =>'required'
            ]);

            $params = $this->request->all();
            $params["id_usuario"] = $this->request->auth->id;
            
            $items = SocketService::saveConnection($params);
            
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function deleteConnection(){
        try {
            
            $this->validate($this->request, [
                'idHandshake' =>'required'
            ]);

            $params = $this->request->all();

            $items = SocketService::deleteConnection($params['idHandshake']);
            
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function resetConnections(){
        try {

            $result = SocketService::resetConnections();
            
            return response()->json($result, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function setSeen(){
        try {
            
            $params = $this->request->all();

            if(isset($params['id'])){
                $items = SocketService::setSeen($params['id']);
                return response()->json($items, 200);
            }else{
                return response()->json("field 'id' required", 400);
            }
            
        } catch (\Exception $ex) {
            return response()->json_encode(['error' => $ex->getMessage()], 500);
        }
    }

    public function setSended(){
        try {
            
            $params = $this->request->all();

            if(isset($params['id'])){

                $items = SocketService::setSended($params['id']);
                return response()->json($items, 200);
            }else{
                return response()->json("field 'id' required", 400);
            }


        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function getLastNotifications($usuarioId){
        try {
            $this->data = SocketService::getLastNotifications($usuarioId);
            $this->status = true;
            return $this->jsonResponse();
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500); 
        }
    }

    public function getAllNotifications($usuarioId){
        try {
            $this->data = SocketService::getAllNotifications($usuarioId);
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

    public function deleteNotification($notifId){
        try {

            $this->data = SocketService::deleteNotification($notifId);
            return $this->jsonResponse();

        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

}
