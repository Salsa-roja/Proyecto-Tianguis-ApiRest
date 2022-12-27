<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SolicitanteService;

class SolicitanteController extends Controller
{
    public function __construct()
    {
        //
    } 

    public function listado(){
        try {
            $items = SolicitanteService::listado();
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function guardar(Request $request){
        try{
            $this->validate($request, [
                'nombre' => 'required',
                'ap_paterno' => 'required',
                'ap_materno' => 'required',
                'edad' => 'required',
                'curp' => 'required',
                'telefono' => 'required',
                'email' => 'required',
                'pass' => 'required',
                'c_numero' => 'required',
                'c_postal' => 'required',
                'id_colonia' => 'required',
                'ciudad',
                'descr_profesional' => 'required',
                'sueldo_deseado' => 'required',
                'area_desempeno',
                'posicion_interes',
                'industria_interes',
                'habilidades',
                'exp_profesional',
                'formacion_educativa',
                'disc_lenguaje',
                'disc_motriz',
                'disc_visual',
                'disc_mental',
                'disc_auditiva',
                'lugar_atencion' => 'required',
                'curriculum'
            ]);
            $params = $request->all();
            $params["request"] = $request;
            $items = SolicitanteService::guardar($params);

            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function getCPs(){
        try {
            $items = SolicitanteService::getCPs();
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function getColonias($cpostal){
        try {
            $items = SolicitanteService::getColonias($cpostal);
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
