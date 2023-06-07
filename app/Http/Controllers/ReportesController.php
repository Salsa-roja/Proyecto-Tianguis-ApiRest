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
            return response()->json(['error' => $ex->getMessage()], 500);
        }

    }

}
