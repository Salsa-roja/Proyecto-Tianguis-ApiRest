<?php


namespace App\Http\Controllers;

use App\Services\VacanteService;
use Illuminate\Http\Request;
//use PDF;

class VacanteController extends Controller
{
   
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getVacante()
    {
        try {
            $datos = VacanteService::getVacante();
            return response()->json( $datos, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function inhabilitar($id)
    {
        try {
            $datos = VacanteService::inhabilitar($id);
            return response()->json($datos, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage(), 'msg' => 'Algo salió mal.'], 500);
        }
    }


    public function searchId(Request $request)
    {
        try {
        
            $params["request"] = $request;
           
           
            $ip = VacanteService::searchId($params);
            return response()->json($ip, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function searchName($name)
    {
        try {
            $names = VacanteService::searchName($name);
            return response()->json($names, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function filtro()
    {
        try {
            $filtro = VacanteService::filtro($this->request->all());
            return response()->json($filtro, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function getSolicitudesVacante($idVacante){
        try {
            $response = VacanteService::getSolicitudesVacante($idVacante);
            return response()->json($response, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }//...getSolicitudesVacante

    public function vincular(Request $request){
        try {
            $this->validate($request, ['idVacante' => 'required']);
            $params = $request->all();
            $params["request"] = $request;
            $response = VacanteService::vincular($params);
            return response()->json($response, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }//...vincular
}           
