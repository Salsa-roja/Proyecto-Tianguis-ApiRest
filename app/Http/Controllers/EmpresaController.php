<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmpresaService;
use App\Services\ArchivosService;
use App\Services\UsuarioService;

class EmpresaController extends Controller
{
    public function __construct()
    {
        //
    } 

    public $storage="empresas";

    public function searchById($idSolicitante){
        try {
            $itemDB = EmpresaService::searchById($idSolicitante,false);
            return response()->json($itemDB, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function listado(){
        try {
            $items = EmpresaService::listado();
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    /** 
     * Guardar Empresa
     */
    public function guardar(Request $request){
        try{
            $this->validate($request, [
                'nombre_comercial' => 'required',
                'razon_social' => 'required',
                'rfc' => 'required',
                'descripcion' => 'required',
                'numero_empleados' => 'required',
                'constancia_sit_fiscal' => 'required',
                'licencia_municipal' => 'required',
                'alta_patronal' => 'required',
                'contr_discapacitados',
                'contr_antecedentes',
                'contr_adultos',
                'nombre_login' => 'required',
                'nombre_rh' => 'required',
                'correo_rh' => 'required',
                'contrasena' => 'required',
                'telefono_rh' => 'required'
            ]);
            $params = $request->all();
            $params["request"] = $request;
            $fieldsArchivo=[];

            if( UsuarioService::existeByUsername($params['nombre_login']) ){                
                $this->msg='El nombre de usuario ya está en uso, utiliza otro';
                return $this->jsonResponse();
            }
            #valida si el solicitante ya existe
            if( EmpresaService::existeByRFC($params['rfc']) ){                
                $this->msg='El RFC ya está en uso, por favor verifica';
                return $this->jsonResponse();
            }

            #guardar archivos con prefijo alias
            if($request->hasFile('constancia_sit_fiscal')){

                $fieldsArchivo['constancia_sit_fiscal'] =   ArchivosService::subirArchivo($request->file('constancia_sit_fiscal'),
                                                                'empresas',
                                                                'c_sit_fiscal_'.$params['rfc'],
                                                                'path'
                                                            );
            }
            if($request->hasFile('licencia_municipal')){
                $fieldsArchivo['licencia_municipal'] = ArchivosService::subirArchivo($request->file('licencia_municipal'),
                                                                'empresas',
                                                                'lic_municipal_'.$params['rfc'],
                                                                'path'
                );
            }
            if($request->hasFile('alta_patronal')){
                $fieldsArchivo['alta_patronal'] = ArchivosService::subirArchivo($request->file('alta_patronal'),
                                                                'empresas',
                                                                'alta_patronal_'.$params['rfc'],
                                                                'path'
                );
            }

            $this->data = EmpresaService::guardar($params,$fieldsArchivo);
            $this->status=true;

            return $this->jsonResponse();
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Editar Empresa
     */

     public function editar(Request $request){
        try{
            $this->validate($request, [
                'id' => 'required',
                'nombre_comercial' => 'required',
                'razon_social' => 'required',
                'rfc' => 'required',
                'descripcion' => 'required',
                'numero_empleados' => 'required',
                'contr_discapacitados',
                'contr_antecedentes',
                'contr_adultos',
                'nombre_rh' => 'required',
                'correo_rh' => 'required',
                'telefono_rh' => 'required'
            ]);
            $params = $request->all();
            $params["request"] = $request;

            $this->data = EmpresaService::editar($params);
            $this->status=true;

            return $this->jsonResponse();
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Guardar nuevo Archivo de la empresa
     */
    public function guardarDocto(Request $request){
        try{
            $this->validate($request, [
                'inputName' => 'required',
                'id_empresa' => 'required'
            ]);
            $params = $request->all();

            $params["request"] = $request;
            
            #obtener info de la empresa
            $empresa = EmpresaService::searchById($params['id_empresa'],false);
            $params["empresa"] = $empresa;

            $campo = $params['inputName'];

            #borrar archivo si existe
            if($empresa->$campo != ''){
                ArchivosService::borrarArchivoStorage($empresa->$campo,$this->storage);
            }


            if( $request->hasFile($campo) ){
                # obtener prefijo para generar el nobre de archivo correspondiente
                switch ($campo) {
                    case 'constancia_sit_fiscal':
                        $prefix = 'c_sit_fiscal_';
                        break;
                    case 'licencia_municipal':
                        $prefix = 'lic_municipal_';
                        break;
                    case 'alta_patronal_':
                        $prefix = 'alta_patronal_';
                        break;
                }
                $fieldArchivo = ArchivosService::subirArchivo($request->file( $campo ),
                                                                $this->storage,
                                                                $prefix.$empresa->rfc,
                                                                'path' 
                );
            }

            $items = EmpresaService::guardarDocto($params,$fieldArchivo);
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Borrar Documento de la empresa
     */
    public function borrarDocto($idEmpresa,$archivo){
        try{
            #obtener info del solicitante
            $solicitante = EmpresaService::searchById($idEmpresa,false);
            #borrar archivo
            ArchivosService::borrarArchivoStorage($solicitante->$archivo,$this->storage);
            #borrar path 
            $solicitante->$archivo='';
            $solicitante->save();
            
            return response()->json($solicitante, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * descargar archivo 
     */
    public function descarga_archivo($idEmpresa,$archivo){
        try {
            $itemDB = EmpresaService::searchById($idEmpresa,false);
            //return $itemDB;
            return ArchivosService::descargaStorage($this->storage,$itemDB->$archivo);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
