<?php

namespace App\Services;

use Firebase\JWT\JWT;
use App\Models\SocketClient;
use App\Models\SocketQueque;

use Illuminate\Support\Facades\Log;

use ElephantIO\Client;

abstract class SocketService
{

   public static function listConnections(){
      try {
         return SocketClient::all();
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function saveConnection($params){
      try {
         $item = new SocketClient();
         $item->idHandshake   = $params['idHandshake'];
         $item->id_usuario    = $params['id_usuario'];
         $item->created_at    = date('Y-m-d H:i:s');
         $item->save();

         return $item;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function deleteConnection($idHandshake){
      try {

         $item = SocketClient::where('idHandshake',$idHandshake);
         $item->forceDelete();

         return $item;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function resetConnections(){
      try {

         $item = SocketClient::truncate();

         return $item;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }
   /**
    * Agrega una notificacion a la cola del socket.
    *
    * @param array $notificacion Contiene la información sobre la notificacion, que incluye las claves 'id_usuario', 'sala', 'titulo' y 'descripcion'.
    * @param stdClassObject $authInfo Contiene la informacion del usuario cuya sesion lleva a cabo la acción que dispara la notificación. este parametro sera firmado mediante JWT para incrustarse a los encabezados de la solicitud hacia el websocket
    * @throws Exception Si ocurre algún error al intentar agregar la notificacion a la cola.
    */
   public static function addToQueque($notificacion,$authInfo){
      try {
         $item = new SocketQueque();
         $item->id_usuario    = $notificacion['id_usuario'];
         $item->sala          = $notificacion['sala'];
         $item->titulo        = $notificacion['titulo'];
         $item->descripcion   = $notificacion['descripcion'];
         $item->created_at    = date('Y-m-d H:i:s');
         $item->save();

         $SocketQueque = [
            'id' => $item->id,
            'id_usuario' => $item->id_usuario,
            'sala' => $item->sala,
            'titulo' => $item->titulo,
            'descripcion' => $item->descripcion,
            'created_at' => $item->created_at,
         ];
         $pl=[
            'id' => $authInfo->id,
            'nombre' => $authInfo->nombre,
            'correo' => $authInfo->correo,
            'rol' => $authInfo->rol,
            'rol_id' => $authInfo->rol_id,
            'permisos' => $authInfo->permisos,
            'id_empresa' => $authInfo->id_empresa,
            'id_solicitante' => $authInfo->id_solicitante,
            'iat' => $authInfo->iat,
            'exp' => $authInfo->exp,
         ];
         $jwt = JWT::encode($pl, env('JWT_SECRET'), 'HS256');

         #Comunicar via websocket al cliente
         return SocketService::notifyClient($SocketQueque,$jwt);

      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }  
   }


   public static function setSeen($idNotif){
      try {
         
         $notif = SocketQueque::find($idNotif);

         if($notif){
            $notif->vista = true;
            $notif->save();
         }
         
         return $notif;

      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }  
   }

   public static function setSended($idNotif){
      try {

         $notif = SocketQueque::find($idNotif);

         if($notif){
            $notif->enviada = true;
            $notif->save();
         }

         return $notif;

      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }  
   }

   /**
    * Envia un mensaje al servidor websocket con la notificación pendiente a ser enviada
    *
    * @param array $mensaje Una instancia del modelo SocketQueque.
    * @param string $JWTtoken Una cadena que contiene la informacion del usuario firmada con JWT
    * @throws Exception Si ocurre algún error al intentar enviar la solicitud al servidor websocket
    */
   public static function notifyClient($SocketQueque,$JWTtoken){
      try {
         $version = Client::CLIENT_4X;
         $url = env('WS_SERVER');
         $token = $JWTtoken;
         $event = 'notify_client';
         //echo sprintf("Creating first socket to %s\n", $url);
         
         // create first instance
         $client = new Client(Client::engine($version, $url, [
            'headers' => [
               "token: $token"
            ],
            'query' => [
               'room'=>'user_api'
            ],
            'debug' => true
         ]), Log::getLogger());//
          $client->initialize();

         $data = [$SocketQueque];
         $client->emit($event, $data);

         $client->wait($event);
         $client->close();
         
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }  
   }

}