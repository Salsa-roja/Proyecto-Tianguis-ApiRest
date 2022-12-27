<?php

namespace App\Http\Controllers;
use App\Services\VacanteService;

//use PDF;

class VacanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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


    public function searchId($id)
    {
        try {
            $ip = VacanteService::searchId($id);
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

    public function filtro($id1,$id2)
    {
        try {
            $ip = VacanteService::filtro($id1,$id2);
            return response()->json($ip, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
