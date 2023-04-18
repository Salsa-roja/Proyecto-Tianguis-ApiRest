<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SocketService;

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
            
            $this->validate($this->request, [
                'id' =>'required'
            ]);

            $params = $this->request->all();

            $items = SocketService::setSeen($params['id']);
            
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function setSended(){
        try {
            
            $this->validate($this->request, [
                'id' =>'required'
            ]);

            $params = $this->request->all();

            $items = SocketService::setSended($params['id']);
            
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function testAddToQueque(){
        try {
            $notificacion = $this->request->all();
            $result = SocketService::addToQueque($notificacion);
            
            return response()->json($result, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

}
