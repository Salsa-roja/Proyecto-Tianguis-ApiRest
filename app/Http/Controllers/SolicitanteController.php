<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SolicitanteService;
use App\Services\ArchivosService;
class SolicitanteController extends Controller
{
    public function __construct()
    {
        //
    } 

    public $storage="solicitantes";

    public function searchById($idSolicitante){
        try {
            $itemDB = SolicitanteService::searchById($idSolicitante);
            return response()->json($itemDB, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function listado(){
        try {
            $items = SolicitanteService::listado();
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Guardar nuevo solicitante
     */
    public function guardar(Request $request){
        try{
            $this->validate($request, [
                'nombre' => 'required',
                'ape_paterno' => 'required',
                'ape_materno' => 'required',
                'edad' => 'required',
                'curp' => 'required',
                'telefono' => 'required',
                'nombre_login' => 'required',
                'contrasena' => 'required',
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
                'curriculum' => 'required'
            ]);
            $params = $request->all();
            $params["request"] = $request;
            
            if($request->hasFile('curriculum')){

                $fieldArchivo = ArchivosService::subirArchivo($request->file('curriculum'),
                                                                $this->storage,
                                                                'CV_'.$params['curp'],
                                                                'path' 
                );
            }

            $items = SolicitanteService::guardar($params,$fieldArchivo);
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Guardar nuevo Curriculum del solicitante
     */
    public function guardarCv(Request $request){
        try{
            $this->validate($request, [
                'nuevo_cv' => 'required',
                'id_solicitante' => 'required'
            ]);
            $params = $request->all();
            $params["request"] = $request;
            
            #obtener info del solicitante
            $solicitante = SolicitanteService::searchById($params['id_solicitante'],false);
            $params["solicitante"] = $solicitante;

            #borrar archivo si existe
            if($solicitante->curriculum!=''){
                ArchivosService::borrarArchivoStorage($solicitante->curriculum,$this->storage);
            }

            if($request->hasFile('nuevo_cv')){

                $fieldArchivo = ArchivosService::subirArchivo($request->file('nuevo_cv'),
                                                                $this->storage,
                                                                'CV_'.$solicitante->curp,
                                                                'path' 
                );
            }

            $items = SolicitanteService::guardarCv($params,$fieldArchivo);
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Borrar Curriculum del solicitante
     */
    public function borrarCv($idSolicitante){
        try{
            #obtener info del solicitante
            $solicitante = SolicitanteService::searchById($idSolicitante,false);
            #borrar archivo
            ArchivosService::borrarArchivoStorage($solicitante->curriculum,$this->storage);
            #borrar path 
            $solicitante->curriculum='';
            $solicitante->save();
            
            return response()->json($solicitante, 200);
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

    /**
     * descargar archivo cv
     */
    public function descarga_cv($idSolicitante){
        try {
            $itemDB = SolicitanteService::searchById($idSolicitante);
            //return $itemDB;
            return ArchivosService::descargaStorage($this->storage,$itemDB->curriculum);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
