<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReportesService;


class ReportesController extends Controller
{
   private $request;

   public function __construct(Request $request)
   {
      $this->request = $request;
   } 

   public function generales(){
      try {

         $this->data =  ReportesService::generales();
         return $this->jsonResponse();

      } catch (\Exception $ex) {
         return response()->json(['mensaje' => 'Hubo un error al obtener estadisticas generales', $ex->getMessage()], 500);
      }

   }

   public function graficaConversion(){
      try {
         
         $this->data =  ReportesService::grafica_conversion();
         return $this->jsonResponse();
         
      } catch (\Exception $ex) {
         return response()->json(['mensaje' => 'Hubo un error al obtener la grafica de conversión', $ex->getMessage()], 500);
      }

   }
}
