<?php

namespace App\Http\Controllers;

use App\Services\TurnosTitulosService;

//use PDF;

class TurnosTitulosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTurnos()
    {
        try {
            $datos = TurnosTitulosService::getTurnos();
            return response()->json($datos, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function getTitulos()
    {
        try {
            $datos = TurnosTitulosService::getTitulos();
            return response()->json($datos, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
