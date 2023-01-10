<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use App\Models\Usuarios;

class UserNotifiable extends Usuarios{
   use Notifiable;

   public function routeNotificationForMail($notification)
   {
       return $this->correo;
   }
}