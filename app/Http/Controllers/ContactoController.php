<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContactoService;

class ContactoController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    } 
 

    public function listado(){
        try {
            $items = ContactoService::listado();
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function guardar(){
        try{
            $this->validate($this->request, [
                'nombre' => 'required',
                'correo' => 'required',
                'comentario' => 'required'
            ]);
            $params = $this->request->all();
            $params["request"] = $this->request;
            $this->data = ContactoService::guardar($params);
            $this->status=true;
            return $this->jsonResponse();
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function eliminar($id){
        try {
            $items = ContactoService::eliminar($id);
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

}
