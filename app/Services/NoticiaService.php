<?php

namespace App\Services;

use App\Models\Noticia;
use Illuminate\Support\Carbon;


abstract class NoticiaService
{

   public static function listadoPublicas()
   {
      try {
         $items = Noticia::where(['activo'=> true])->whereDate('fecha_publicacion', '<=', Carbon::now())->get();
         return $items;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function listado()
   {
      try {
         $items = Noticia::where('activo', true)->get();
         return $items;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   /**
    * Buscar noticia por id
    *
    * @param id number - id de la noticia
    **/
    public static function searchById($id)
    {
       try {
             return Noticia::find($id);
       } catch (\Exception $e) {
          throw new \Exception($e->getMessage());
       }
    }

   public static function guardar($params, $pathImagen)
   {
      try {

         # guardar noticia
         $Noticia = new Noticia();
         $Noticia->titulo = trim($params['titulo']);
         $Noticia->descripcion = $params['descripcion'];
         $Noticia->fecha_publicacion = $params['fecha_publicacion'];
         $Noticia->imagen = $pathImagen;
         $Noticia->save();

         return $Noticia;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function editar($params,$pathImagen)
   {
      try {

         #obtener info de la empresa
         $Noticia = self::searchById($params['id']);

         # editar noticia
         $Noticia->titulo = trim($params['titulo']);
         $Noticia->descripcion = $params['descripcion'];
         $Noticia->fecha_publicacion = $params['fecha_publicacion'];
         if ($pathImagen != null){
            $fileDelete = ArchivosService::borrarArchivoStorage($Noticia->imagen,'noticias') ;
            $Noticia->imagen = $pathImagen;
        }
         $Noticia->save();

         return $Noticia;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function eliminar($id)
   {
       try {
            $noticia = Noticia::find($id);
            if ($noticia) {
                  $noticia->activo = 0;
                  $noticia->save();
            }
           return $noticia;
       } catch (\Exception $ex) {
           return response()->json(['mensaje' => 'Hubo un error al eliminar el vacante', $ex->getMessage()], 400);
       }
   }
}
