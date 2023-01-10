<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Services\MaCitaService;

class MailController extends Controller {
    
    public function mail(request $request) {
        try{
            $data = MaCitaService::cita($request->idCita);
            if($data){
                //$data = array('name'=> 'Test');
                $resultado = Mail::send('/mail/mail', compact('data'), function($message) use($request, $data) {
                    $message->to($request->correo, $data[0]->nombre_solicitante)->subject('CONFIRMACIÓN DE CITA');
                    $message->from($request->server("MAIL_FROM_ADDRESS"),$request->server("MAIL_FROM_NAME"));
                });
                if($resultado){
                    $cadena = 'El correo se pudo enviar. Revisar la cuenta proporcionada!.';
                } else {
                    throw new Exception('No se puedo enviar el correo!.');
                }
            } else {
                $cadena = 'No existe información de la cita!.';
            }        
        }catch(\Exception $ex){
            throw new \Exception($ex->getMessage(), $ex->getCode());
        } catch (QueryException $e) {
            return response(["success" => false, "message" => $e->getMessage()], 400)
                ->header('Content-Type', 'application/json');
        } catch (Exception $e) {
            return response(["success" => false, "message" => $e->getMessage()], 200)
                ->header('Content-Type', 'application/json');
        } catch (FatalThrowableError $e) {
            return response(["success" => false, "message" => $e->getMessage()], 400)
                ->header('Content-Type', 'application/json');
        }
        //Si se envío correctamente devolvemos true
        return response(["success" => true, "message" => $cadena], 200)
            ->header('Content-Type', 'application/json');
    }
}