<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NoticiaService;
use App\Services\ArchivosService;


class NoticiasController extends Controller
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    } 
 

    public $storage="noticias";

    public function listado(){
        try {
            $items = NoticiaService::listado();
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function listadoPublicas(){
        try {
            $items = NoticiaService::listadoPublicas();
            return response()->json($items, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function searchById($id){
        try {
            $this->data = NoticiaService::searchById($id);
            return $this->jsonResponse();
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function guardar(){
        try{
            $this->validate($this->request, [
                'titulo' => 'required',
                'imagen' => 'required',
                'descripcion' => 'required',
                'fecha_publicacion' => 'required'
            ]);

            $params = $this->request->all();
            $params["request"] = $this->request;
            $pathImagen='';


            #guardar archivo imagen
            if($this->request->hasFile('imagen')){

                $pathImagen =   ArchivosService::subirArchivo($this->request->file('imagen'),
                                                                'noticias',
                                                                'ntc',
                                                                'path'
                                                            );
            }


            $this->data = NoticiaService::guardar($params,$pathImagen);
            $this->status=true;

            return $this->jsonResponse();
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

     public function editar(){
        try{
            $this->validate($this->request, [
                'id' => 'required',
                'titulo' => 'required',
                'imagen',
                'descripcion' => 'required',
                'fecha_publicacion' => 'required'
            ]);
            $params = $this->request->all();
            $params["request"] = $this->request;
            $pathImagen = null;

            #guardar archivo imagen si fue suplido
            if($this->request->hasFile('imagen')){

                $pathImagen =   ArchivosService::subirArchivo($this->request->file('imagen'),
                                                                'noticias',
                                                                'ntc_'.date('Ymd_his'),
                                                                'path'
                                                            );
            }
            $this->data = NoticiaService::editar($params,$pathImagen);
            $this->status=true;

            return $this->jsonResponse();
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * descargar imagen 
     */
    public function descarga_imagen($idNoticia){
        try {
            $itemDB = NoticiaService::searchById($idNoticia);
            return ArchivosService::descargaStorage($this->storage,$itemDB->imagen);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    
}
