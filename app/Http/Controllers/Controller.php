<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public $statusHttp=200; //200:ok, 201: created, 400:error en solicitud, 401:no autorizado
    public $msg;
    public $data;
    public $status;
    
    public function __construct()
    {
        $this->msg='';
        $this->data=[];
        $this->status=false;
    } 

    public function jsonResponse(){
       return response()->json([
            'status'=>$this->status,
            'msg'=>$this->msg,
            'data'=>$this->data,
            'statusHttp'=>$this->statusHttp
        ], $this->statusHttp);
    }
}
