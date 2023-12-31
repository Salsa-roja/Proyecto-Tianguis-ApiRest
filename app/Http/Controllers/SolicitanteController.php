<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SolicitanteService;
use App\Services\ArchivosService;
use App\Services\UsuarioService;
class SolicitanteController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    } 
 

    private $storage="solicitantes";

    public function searchById($idSolicitante){
        try {
            //$itemDB = SolicitanteService::searchById($idSolicitante);
            //return response()->json($itemDB, 200);
            $this->data= SolicitanteService::searchById($idSolicitante);
            $this->status=true;
            return $this->jsonResponse();
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
    public function guardar(){
        try{
            $this->validate($this->request, [
                'nombres' => 'required',
                'ape_paterno' => 'required',
                'ape_materno' => 'required',
                'edad' => 'required',
                'curp' => 'required',
                'telefono' => 'required',
                'nombre_login' => 'required',
                'correo',
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
                'id_nivel_educativo',
                'disc_lenguaje',
                'disc_motriz',
                'disc_visual',
                'disc_mental',
                'disc_auditiva',
                'lugar_atencion' => 'required',
                'curriculum' => 'required'
            ]);

            $params = $this->request->all();
            $params["request"] = $this->request;
            
            #valida si el usuario ya existe
            if( UsuarioService::existeByUsername($params['nombre_login']) ){                
                $this->msg='El nombre de usuario ya está en uso, utiliza otro';
                return $this->jsonResponse();
            }
            #valida si el solicitante ya existe
            if( SolicitanteService::existeByCurp($params['curp']) ){                
                $this->msg='La CURP ya está en uso, por favor verifica';
                return $this->jsonResponse();
            }

            if($this->request->hasFile('curriculum')){

                $fieldArchivo = ArchivosService::subirArchivo($this->request->file('curriculum'),
                                                                $this->storage,
                                                                'CV_'.$params['curp'],
                                                                'path' 
                );
            }
            
            $this->data = SolicitanteService::guardar($params,$fieldArchivo);
            $this->status=true;

            return $this->jsonResponse();
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Editar solicitante
     */
    public function editar(){
        try{
            $this->validate($this->request, [
                'id' => 'required',
                'nombres' => 'required',
                'ape_paterno' => 'required',
                'ape_materno' => 'required',
                'edad' => 'required',
                'curp' => 'required',
                'telefono' => 'required',
                'nombre_login' => 'required',
                'correo',
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
                'id_nivel_educativo'=> 'required',
                'disc_lenguaje',
                'disc_motriz',
                'disc_visual',
                'disc_mental',
                'disc_auditiva',
                'lugar_atencion' => 'required'
            ]);

            $params = $this->request->all();
            $params["request"] = $this->request;
            
            #valida si el usuario ya existe
            if( UsuarioService::existeByUsername($params['nombre_login'],SolicitanteService::getIdUsuario($params['id'])) ){
                $this->msg='El nombre de usuario ya está en uso, utiliza otro';
                return $this->jsonResponse();
            }

            $this->data = SolicitanteService::editar($params);
            $this->status=true;

            return $this->jsonResponse();
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Guardar nuevo Curriculum del solicitante
     */
    public function guardarCv(){
        try{
            $this->validate($this->request, [
                'nuevo_cv' => 'required',
                'id_solicitante' => 'required'
            ]);
            $params = $this->request->all();
            $params["request"] = $this->request;
            
            #obtener info del solicitante
            $solicitante = SolicitanteService::searchById($params['id_solicitante'],false);
            $params["solicitante"] = $solicitante;

            #borrar archivo si existe
            if($solicitante->curriculum!=''){
                ArchivosService::borrarArchivoStorage($solicitante->curriculum,$this->storage);
            }

            if($this->request->hasFile('nuevo_cv')){

                $fieldArchivo = ArchivosService::subirArchivo($this->request->file('nuevo_cv'),
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

    public function getNivelesEducativos(){
        try {
            $items = SolicitanteService::getNivelesEducativos();
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
