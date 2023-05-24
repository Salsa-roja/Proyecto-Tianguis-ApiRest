<?php

namespace App\Services;

use Firebase\JWT\JWT;
use App\Models\SocketClient;
use App\Models\SocketQueque;

use Illuminate\Support\Facades\Log;

use ElephantIO\Client;

/**
 * Class SocketService
 *
 * Esta clase maneja las conexiones de sockets. Cuando se crea una instancia de SocketService,
 * se abre una conexión de socket. Es importante llamar al método close() cuando hayas terminado
 * de usar la instancia, para cerrar la conexión y liberar los recursos.
 * 
 * @param array $authInfo Un arreglo con la informacion decodificada del inicio de sesión, obtenida del objeto Request en los controladores.
 * @param string $event el evento con el cual se van a emitir los mensajes hacia el servidor websocket. {@default "notify_client"}
 * 
 */
class SocketService
{

   protected $version;
   protected $url;
   protected $token;
   protected $event;
   protected $queque;
   protected $client = false;

   public function __construct($authInfo, $event='notify_client'){
      try {

         if(isset($authInfo->id)){

            $this->version = Client::CLIENT_4X;
            $this->url = env('WS_SERVER');
            $this->event = $event;
            $this->token = self::tokenizeAuthInfo($authInfo);
            $this->queque = [];
            # create instance
            $this->client = new Client(Client::engine($this->version, $this->url, [
               'headers' => [
                  "token:  ".$this->token
               ],
               'query' => [
                  'room'=>'user_api'
               ],
               'debug' => true
            ]), Log::getLogger());

            $this->client->initialize();

         }else{
            throw new \Exception('Invalid authInfo');
         }

      } catch (\Exception $e) {
         //throw new \Exception($e->getMessage());
         throw new \Exception('No fue posible conectar al servidor websocket');
      }  

   }

   /**
    * Crea un json web token
    * @param string $JWTtoken Una cadena que contiene la informacion del usuario firmada con JWT
    */
   private static function tokenizeAuthInfo($authInfo){
      
      return   JWT::encode(
                  [
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
                  ], 
                  env('JWT_SECRET'), 'HS256'
               );
   }

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

   public static function setSeen($notifId){
      try {
         
         $notif = SocketQueque::find($notifId);

         if($notif){
            $notif->vista = true;
            $notif->enviada = true;// Si por alguna razon el socket no confirmo la recepcion, se establece la notificacion como enviada
            $notif->save();
         }
         
         return $notif;

      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }  
   }

   public static function setSended($notifId){
      try {

         $notif = SocketQueque::find($notifId);

         if($notif){
            $notif->enviada = true;
            $notif->save();
         }

         return $notif;

      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }  
   }

   public static function deleteNotification($notifId){
      try {
         
         $notif = SocketQueque::find($notifId);
 
         $notif->activo = false;
         $notif->save();
         
         return $notif;

      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }  
   }

   /**
    * Agrega UNA notificacion a la cola del socket y comunica al servidor websocket con el metodo notifyClient()
    *
    * @param array $notificacion Contiene la información sobre la notificacion, que incluye las claves 'id_usuario', 'sala', 'titulo' y 'descripcion'.
    *
    * @throws Exception Si ocurre algún error al intentar agregar la notificacion a la cola.
    */
   public function addToQueque($notificacion){
      try {

         $item = new SocketQueque();
         $item->id_usuario    = $notificacion['id_usuario'];
         $item->sala          = $notificacion['sala'];
         $item->titulo        = $notificacion['titulo'];
         $item->descripcion   = $notificacion['descripcion'];
         $item->created_at    = date('Y-m-d H:i:s');
         $item->save();

         array_push($this->queque, [
            'id' => $item->id,
            'id_usuario' => $item->id_usuario,
            'sala' => $item->sala,
            'titulo' => $item->titulo,
            'descripcion' => $item->descripcion,
            'created_at' => $item->created_at,
         ]);

         return $this;

      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }  
   }

   /**
    * Envia un mensaje al servidor websocket con la notificación pendiente a ser enviada usando el evento 'notify_client'
    *
    * @param array $mensaje Una instancia del modelo SocketQueque.
    *
    * @throws Exception Si ocurre algún error al intentar enviar la solicitud al servidor websocket
    */
   public function emitQueque(){
      try {

         $this->client->emit($this->event, $this->queque);

         //$this->client->wait($this->event);
         # SocketService queda esperando una emision del servidor del evento 'queque_emmited' para finalizar la lectura del stream
         $this->client->wait('queque_emmited');
         
         return $this;

      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }  
   }

   /**
    * Cierra la conexión de socket. Debes llamar a este método cuando hayas terminado de usar
    * la instancia de SocketService.
    */
   public function close(){
      $this->queque = [];
      $this->client->close();
      return $this;
   }

   public function getClientStatus(){
      return $this->client;
   }

   public static function getLastNotifications($usuarioId){
      try {
         return SocketQueque::where([ 'id_usuario'=>$usuarioId, 'activo'=>true ])//, 'enviada' => true
                              ->orderBy('created_at','desc')
                              //->limit(6)
                              ->get();
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }

   public static function getAllNotifications($usuarioId){
      try {
         return SocketQueque::where([ 'id_usuario'=>$usuarioId, 'activo'=>true ])
                              ->orderBy('created_at','desc')
                              ->get();
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }
   }
}