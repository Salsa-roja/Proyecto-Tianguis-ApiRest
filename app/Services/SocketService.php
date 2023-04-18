<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\SocketClient;
use App\Models\SocketQueque;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket;
use GuzzleHttp\Psr7\Request;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\Socket\Connector as RConnector;
use React\EventLoop\Loop;

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

use Illuminate\Support\Facades\Log;

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
    * @param array $notificacion Un arreglo con información sobre la notificacion, que incluye las claves 'id_usuario', 'sala', 'titulo' y 'descripcion'.
    * @throws Exception Si ocurre algún error al intentar agregar la notificacion a la cola.
    */
   public static function addToQueque($notificacion){
      try {

         $item = new SocketQueque();
         $item->id_usuario    = $notificacion['id_usuario'];
         $item->sala          = $notificacion['sala'];
         $item->titulo        = $notificacion['titulo'];
         $item->descripcion   = $notificacion['descripcion'];
         $item->created_at    = date('Y-m-d H:i:s');
         //$item->save();

         #Comunicar via websocket al cliente
         return SocketService::notifyClient($item);

      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }  
   }


   public static function setSeen($idNotif){
      try {

         $notif = SocketQueque::find($idNotif);
         $notif->vista = true;
         $notif->save();
         
         return true;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }  
   }

   public static function setSended($idNotif){
      try {

         $notif = SocketQueque::find($idNotif);
         $notif->enviada = true;
         $notif->save();
         
         return true;
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }  
   }
                  /* 
                  
                  'Accept' => '* /*',
                  'Accept-Encoding' => 'gzip, deflate, br',
                  'Connection' => 'keep-alive',
                  'Host' => 'localhost:3500',
                  'Referer' => env('APP_URL'),


                  json_encode([
                        "event" => "notify_client",
                        "data" => $SocketQueque
                     ]) */
                                       /* $conn->send(json_encode('notify_client'));
                  $conn->close(); 
                  
                  */
   /**
    * Envia un mensaje al servidor websocket con la notificación pendiente a ser enviada
    *
    * @param array $mensaje Una instancia del modelo SocketQueque.
    * @throws Exception Si ocurre algún error al intentar enviar la solicitud al servidor websocket
    */
   public static function notifyClient2($SocketQueque){
      try {
         $extra = "?token=eyJ0UzI1NiJ9-2YGe7rCrZM&room=user_3&EIO=4&transport=polling&t=KTssJ1X";

         $headers = [
            'token' => 'DFGER5ERTE7',
            'Origin' => env('APP_URL')
         ];

         $reactConnector = new RConnector([
            'dns' => '8.8.8.8',
            'timeout' => 10
         ]);
         $loop = Loop::get();
         $connector = new Connector($loop, $reactConnector);

         $connector(
               env('WS_SERVER').$extra, 
               [], 
               $headers
         )->then(
               function(WebSocket $conn) use ($SocketQueque) {
                  return var_dump([ 'request'=>$conn->request, 'response'=>$conn->response ]);

                  $conn->on('handshake', function() use ($conn) {
                     $data = [
                          'request' => $conn->request,
                          'response' => $conn->response
                     ];
                     $json = json_encode($data);
                     echo $json;
                     $conn->send('notify_client');
                  });
   
                  $conn->on('error', function($e) {
                        echo "Websocket Error: {$e->getMessage()}\n";
                  });

                  $conn->on('open', function() use($conn) {
                        echo "Connection succesfull\n";
                        $conn->send('notify_client');
                        $conn->close();
                  });

                  $conn->on('close', function($code = null, $reason = null) {
                     echo "Connection closed ({$code} - {$reason})\n";
                  }); 
               }, 
               function(\Exception $e) use ($loop){
                  echo "Error: {$e->getMessage()}\n";
                  $loop->stop();
               }
             
            )//...->then()
            ;
            
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }  
   }

   public static function notifyClient($SocketQueque){
      try {
         
         $url = env('WS_SERVER');

         $version = new Version2X($url, [
             'headers' => [
                 'token' => 'DFGER5ERTE7',
                 'Origin' => env('APP_URL'),
             ],
             'debug' => true,
             'version' => 4,
             'use_b64' => true,
             'transport' => 'polling'
         ]);
 
         $client = new Client($version, Log::getLogger());
         //var_dump($client);
         $client->initialize();
 
         // Emitir un evento 'notify_client' al servidor
         $client->emit('notify_client', ['data' => 'Mensaje desde Lumen usando Elephant.io']);
 
         $client->close();
      } catch (\Exception $e) {
         throw new \Exception($e->getMessage());
      }  
   }

}