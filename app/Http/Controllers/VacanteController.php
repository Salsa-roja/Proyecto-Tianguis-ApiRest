<?php


namespace App\Http\Controllers;

use App\Services\VacanteService;
use Illuminate\Http\Request;
//use PDF;
use App\Models\VacanteSolicitante;
use App\Dto\ParseDTO;
use App\Dto\SolicitudDto;
use DateTime;

class VacanteController extends Controller
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getVacantes()
    {
        try {
            $id_empresa = $this->request->auth->id_empresa;
            $datos = VacanteService::getVacantes($id_empresa);
            return response()->json(['data' => $datos, 'user' => $this->request->auth], 200);
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


    public function searchId()
    {
        try {
            $params["request"] = $this->request;
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

    public function vacanteMasLejana()
    {
        try {
            $filtro = VacanteService::vacanteMasLejana($this->request->all());
            return response()->json($filtro, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function filtro()
    {
        try {
            $params["request"] = $this->request;
            $filtro = VacanteService::filtro($this->request->all(), $params);
            return response()->json($filtro, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function getSolicitudesVacante($idVacante)
    {
        try {
            $response = VacanteService::getSolicitudesVacante($idVacante);
            return response()->json($response, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    } //...getSolicitudesVacante

    public function updateEstatusSolicitud(Request $request)
    {
        try {
            // $params["request"] = $request;
            $response = VacanteService::updateEstatusSolicitud($request->all());
            return response()->json($response, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function vincular(Request $request)
    {
        try {
            $this->validate($request, [
                'idVacante' => 'required'
            ]);
            $params = $request->all();
            $params["request"] = $request;
            $response = VacanteService::vincular($params);
            return response()->json($response, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    } //...vincular

    public function getEstatusPostulacion()
    {
        try {
            $datos = VacanteService::getEstatusPostulacion();
            return response()->json($datos, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    
    public function save(Request $request)
    {
        try {
            $params["request"] = $request;
            $datos = VacanteService::guardar($request->all(), $params);
            return response()->json($datos, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage(), 'msg' => 'Algo salió mal.'], 500);
        }
    }
}
