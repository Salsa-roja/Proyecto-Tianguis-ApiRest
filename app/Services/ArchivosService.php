<?php

namespace App\Services;

use App\Models\Archivo;
use App\Models\Registros;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArchivosService
{
    /** 
     * @param req_file: Objeto $request->file() proveniente del formulario
     * @param storage string Directorio donde se va a guardar en el sistema de archivos (ver app/config/filesystems)
     * @param storageName string Nombre del archivo a guardar en el servidor; por defecto se usará la fecha y hora de subida
     * @param returnMode string (path | id) si se usa 'id', se guardara el registro en la tabla archivos y se retornara el id con el que se guardo, si se usa 'path, solo se retornará el nombre del archivo que quedó en el servidor'
     * @param customName string Nombre del archivo a mostrar en el sistema; por defecto se usará la fecha y hora de subida
     */
    public static function subirArchivo($req_file, $storage='public',$storageName='',$returnMode='path',$customName=null)
    {
        try {
            
            $ext = $req_file->getClientOriginalExtension();
            $filename = $storageName."_".date("YmdHis"). '.' . $ext;

            if($returnMode=="id"){
                $archivo = new Archivo();
                $archivo->nombre = isset($customName) ? $customName: $filename;
                $archivo->path = $filename;
                $archivo->save();
                $ret = $archivo->id;
            }else{
                $ret = $filename;   
            }

            Storage::disk($storage)->put($filename, file_get_contents($req_file));
            return $ret;
            
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function descargarArchivo($idArchivo)
    {
        try {
            $filename = Archivo::where('id', $idArchivo)->first()->ruta;
            return Storage::disk('local')->download('registros/' . $filename);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param storageName string
     * @param fileName string
     */
    public static function descargaStorage($storageName,$fileName)
    {
        try {
            return Storage::disk($storageName)->download($fileName);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param storageName string
     * @param fileName string
     */
    public static function base64File($storageName,$fileName)
    {
        try {
            $path = Storage::disk($storageName)->path($fileName);
            return base64_encode(file_get_contents($path));
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    /* public static function mostrarArchivo()
    {

        try {
            $archivosDB = Registros::where('categoria_id')->get();

            return response()->json($archivosDB);

        } catch (\Exception $e) {

            throw new \Exception($e->getMessage());
        }
    } */

    public static function modificarArchivo(Request $request, $id)
    {
        try {
            $ruta = '';
            if ($request->hasFile('archivo')) {
                $file = $request->file('archivo');
                $ext = $file->getClientOriginalExtension();
                $filename = $request->nombre;
                $ruta = $request->registro . '-' . $filename . '.' . $ext;
                Storage::disk('local')->put('registros/' . $ruta, file_get_contents($file));
            } else {
                $ruta = $request->ruta;
            }
            DB::table('archivos')->where('id', $id)->update([
                'nombre' => $request->nombre,
                'ruta' => $ruta
            ]);
            return response()->json('Ok');
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function borrarArchivo($id)//borrar de db
    {
        try {
            DB::table('archivos')->where('id', $id)->update([
                'activo' => false
            ]);
            return response()->json('Ok');
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function borrarArchivoStorage($path,$storage){
        if(Storage::disk($storage)->exists($path))
            return Storage::disk($storage)->delete($path);
        else
            return false;
        
    }
}
