<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmpresaService;
use App\Services\ArchivosService;

class EmpresaController extends Controller
{
    public function __construct()
    {
        //
    } 

    public function listado(){
        try {
            $items = EmpresaService::listado();
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

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
                'nombre_rh' => 'required',
                'correo_rh' => 'required',
                'telefono_rh' => 'required'
            ]);
            $params = $request->all();
            $params["request"] = $request;
            $fieldsArchivo=[];

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

            $items = EmpresaService::guardar($params,$fieldsArchivo);
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

}
