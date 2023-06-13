<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Contacto;
use App\Models\Usuarios;
use Exception;
use Illuminate\Support\Facades\Mail;

class ContactoService
{

   public static function listado()
   {
      try {

         return Contacto::where('activo', true)->orderBy('created_at','desc')->get();
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

    public static function guardar($params){
        try {

            $itemDB = new Contacto();
            $itemDB->nombre = $params['nombre'];
            $itemDB->correo = $params['correo'];
            $itemDB->comentario = $params['comentario'];

            $itemDB->save();
            return $itemDB;
        } catch (\Exception $e) {
            return response()->json([   'error' => $e->getMessage(),
                                        'funcion' => 'guardar'
                                    ], 500);
        }
      
   }

   public static function eliminar($contactoId){
      try {
         
         $Contacto = Contacto::find($contactoId);
 
         $Contacto->activo = false;
         $Contacto->save();
         
         return $Contacto;

      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }  
   }

}
