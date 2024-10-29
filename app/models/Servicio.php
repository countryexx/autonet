<?php

class Servicio extends Eloquent{

    protected $table = 'servicios';

    public function proveedor()
    {
        return $this->belongsTo('Proveedor');
    }

    public function conductor()
    {
        return $this->belongsTo('Conductor');
    }

    public function vehiculo()
    {
	      return $this->belongsTo('Vehiculo');
    }

    public function centrodecosto()
    {
        return $this->belongsTo('Centrodecosto');
    }

    public function subcentrodecosto()
    {
        return $this->belongsTo('Subcentro');
    }

    public function tarifatraslados()
    {
        return $this->belongsTo('Tarifastraslados', 'ruta_id');
    }

    public function user()
    {
        return $this->belongsTo('User', 'creado_por');
    }

    public function serviciopivote()
    {
        return $this->hasOne('Serviciopivote', 'servicios_id');
    }

    public function reportepivote()
    {
        return $this->hasOne('Reportepivote');
    }

    public function reconfirmacion()
    {
        return $this->hasOne('Reconfirmacion', 'id_servicio');
    }

    public function facturacion()
    {
        return $this->hasOne('Facturacion', 'servicio_id');
    }

    public function novedad()
    {
        return $this->hasOne('Novedad', 'id_reconfirmacion');
    }

    public function novedadapp()
    {
        return $this->hasMany('Novedadapp');
    }

    public function servicioaplicacion()
    {
        return $this->hasMany('Servicioaplicacion');
    }

    public function scopeAfiliadosexternos($query)
    {
        return $query->where('afiliado_externo', 1);
    }

    public function scopeCanceladoapp($query)
    {
        return $query->where('cancelado_app', 1)->whereNull('pendiente_autori_eliminacion');
    }

    public function mostrar_30_min_despues(){

      $horaActual = new \DateTime('now');

      $hora_servicio = new \DateTime($this->hora_programado_app);

      $interval = $horaActual->diff($hora_servicio);

      //ya paso la hora
      if(intval($interval->invert)===1){

        $minutes = null;

        $minutes = $interval->days * 24 * 60;
        $minutes += $interval->h * 60;
        $minutes += $interval->i;

        if (intval($minutes)>=30 or $this->aceptado_app==3){

          return true;

        }else{

          return false;

        }

      }

    }

    public function pasajeros(){

      //valor del campo pasajeros
      $paxServicio = $this->pasajeros;

      //campo para guardar html de datos
      $htmlPasajeros= '';

      //si el campo de ruta es diferente de vacio entonces es ruta
      if ($this->ruta!=null) {

        $pax = explode('/', $paxServicio);

        for ($i=0; $i < count($pax); $i++) {
          $pasajeros[$i] = explode(',', $pax[$i]);
        }

        for ($i=0; $i < count($pax)-1; $i++) {

            for ($j=0; $j < count($pasajeros[$i]); $j++){

              if ($j===0) {
                $nombre = $pasajeros[$i][$j];
              }

              if ($j===1) {
                $celular = $pasajeros[$i][$j];
              }

              if ($j===2) {
                $email = $pasajeros[$i][$j];
              }

              if ($j===3) {
                $nivel = $pasajeros[$i][$j];
              }

            }

            if (!isset($celular)){
              $celular = "";
            }

            if (!isset($nombre)){
              $nombre = "";
            }

            $htmlPasajeros .= '<a href title="'.$celular.'">'.$nombre.'</a><br>';

        }

        $htmlPasajeros .= '<a data-id="'.$paxServicio.'" class="btn btn-default pax_ruta" data-toggle="modal" data-target=".mymodal3"><i class="fa fa-search"></i></a>';

      }else{

        $pax = explode('/', $paxServicio);

        for ($i=0; $i < count($pax); $i++) {
          $pasajeros[$i] = explode(',', $pax[$i]);
        }

        for ($i=0; $i < count($pax)-1; $i++) {

          for ($j=0; $j < count($pasajeros[$i]); $j++) {

            if ($j===0) {
              $nombre = $pasajeros[$i][$j];
            }

            if ($j===1) {
              $celular = $pasajeros[$i][$j];
            }

            if ($j===2) {
              $email = $pasajeros[$i][$j];
            }

            if ($j===3) {
              $nivel = $pasajeros[$i][$j];
            }

          }

          if (isset($celular)){
              $htmlPasajeros .= '<a href title="'.$celular.'">'.$nombre.'</a><br>';
          }else{
              $htmlPasajeros .= '<a>'.$nombre.'</a><br>';
          }

        }

      }

      return $htmlPasajeros;
    }

    public static function notificacionData($cliente_id, $data){

      $apikey = Notification::FIREBASE_KEY_CLIENT;

      $user = User::find($cliente_id);

      $id_registration = $user->idregistrationdevice;

      if ($id_registration!=null and $id_registration!='') {

        $registrationId = [$id_registration];

        $fields = [
          'registration_ids' => $registrationId,
          'priority' => 'high'
        ];

        if ($user->device=='android') {
          $fields['data'] = $data;
        }else if($user->device=='ios'){
          $fields['notification'] = $data;
        }else {
          $fields['data'] = $data;
        }

        $headers = [
          'Authorization: key='. $apikey,
          'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);

        curl_close($ch);

      }

    }

    public static function notificacionGeneral($cliente_id, $message){

      $countFalse = 0;
      $countTrue = 0;

      $apikey = Notification::FIREBASE_KEY_CLIENT;

      $user = User::find($cliente_id);

      $id_registration = $user->idregistrationdevice;

      if ($id_registration!=null and $id_registration!='') {

        $registrationId = [$id_registration];

        $data = [
          'message' => $message,
          'body' => $message,
          'title' => 'Aotour Mobile Client',
          'notId' => rand(1000000, 9999999),
          'vibrationPattern' => Notification::VIBRATION_PATTERN,
          'soundname' => 'default',
          'sound' => 'default',
          'visibility' => 1,
        ];

        $fields = [
          'registration_ids' => $registrationId,
          'priority' => 'high',
          'content-available' => true
        ];

        if ($user->device=='android') {
          $fields['data'] = $data;
        }else if($user->device=='ios'){
          $fields['notification'] = $data;
        }else {
          $fields['data'] = $data;
        }

        $headers = [
          'Authorization: key='. $apikey,
          'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);

        curl_close($ch);

      }

    }

    public static function notificacionGeneral2($cliente_id, $message, $arrayData){

      $countFalse = 0;
      $countTrue = 0;

      $apikey = Notification::FIREBASE_KEY_CLIENT;

      $user = User::find($cliente_id);

      $id_registration = $user->idregistrationdevice;

      if ($id_registration!=null and $id_registration!='') {

        $registrationId = [$id_registration];

        $data = [
          'message' => $message,
          'body' => $message,
          'title' => 'Aotour Mobile',
          'notId' => rand(1000000, 9999999),
          'vibrationPattern' => Notification::VIBRATION_PATTERN,
          'soundname' => 'default',
          'sound' => 'default',
          'visibility' => 1,
        ];

        $fields = [
          'registration_ids' => $registrationId,
          'priority' => 'high',
          'content-available' => true
        ];

        if ($user->device=='android') {
          $fields['data'] = $data;
        }else if($user->device=='ios'){
          $fields['notification'] = $data;
        }else {
          $fields['data'] = $data;
        }

        $headers = [
          'Authorization: key='. $apikey,
          'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);

        curl_close($ch);

      }

    }

    public static function actionButton($servicio, $cliente_id, $fecha, $hora, $conductor, $marca, $modelo, $placa){

      $countFalse = 0;
      $countTrue = 0;
      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_CLIENT;

      $user = User::find($cliente_id);

      $id_registration = $user->idregistrationdevice;

      if ($id_registration!=null and $id_registration!='') {

        $id = $id_registration;

        if($user->idioma==='en'){
          $title = 'Scheduled Service';
          $message = 'Your service has been scheduled for '.$fecha.' at '.$hora.'. The driver '.$conductor.' will be in charge of making the transfer. The vehicle is a '.$marca.' '.$modelo.' with license plate '.$placa.'. Thanks for trusting us.';
        }else{
          $title = 'Servicio Programado';
          $message = 'Su servicio ha sido programado para el día '.$fecha.' a las '.$hora.'. El conductor '.$conductor.' será el encargado de realizar el traslado. El vehículo es un '.$marca.' '.$modelo.' con placa '.$placa.'. Gracias por confiar en nosotros. ';
        }

        $fields = array (
          'registration_ids' => array (
            $id
          ),
          'notification' => array (
            "body" => $message,
            "title" => $title,
            "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
            'vibrationPattern' => [2000, 1000, 500, 500],
          ),
          'data' => array (
            "id" => 1,
            "servicio" => $servicio,
            "screen" => 'pending',
          )
        );
        $fields = json_encode ( $fields );

        $headers = array (
          'Authorization: key=' . $apikey,
          'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        curl_close ( $ch );

        /*Guardar Notificación*/
        $notificationSave = new Notifications;
        $notificationSave->fecha = date('Y-m-d H:i');
        $notificationSave->titulo = 'Servicio Programado';
        $notificationSave->text = 'Su servicio ha sido programado para el día '.$fecha.' a las '.$hora.'. El conductor '.$conductor.' será el encargado de realizar el traslado. El vehículo es un '.$marca.' '.$modelo.' con placa '.$placa.'. Gracias por confiar en nosotros. ';
        $notificationSave->titulo_en = 'Scheduled Service';
        $notificationSave->text_en = 'Your service has been scheduled for '.$fecha.' at '.$hora.'. The driver '.$conductor.' will be in charge of making the transfer. The vehicle is a '.$marca.' '.$modelo.' with license plate '.$placa.'. Thanks for trusting us.';
        $notificationSave->id_usuario = $cliente_id;
        $notificationSave->tipo = 1;
        $notificationSave->id_servicio = $servicio;
        $notificationSave->save();
        /*Guardar Notificación*/

        return $result;

      }

    }

    public static function confirmarUbi($id, $idioma){

      $countFalse = 0;
      $countTrue = 0;
      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_CLIENT;

      if($idioma==='en'){

        $title = 'Confirm your location...';
        $message = 'Please confirm the location to know your exact address.';

      }else{

        $title = 'Confirma tu ubicación...';
        $message = 'Por favor confirma la ubicación para saber con exactitud tu dirección.';

      }

      $fields = array (
        'registration_ids' => array (
          $id
        ),
        'notification' => array (
          "body" => $message,
          "title" => $title,
          "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
          'vibrationPattern' => [2000, 1000, 500, 500],
        ),
        'data' => array (
          "id" => 1
        )
      );
      $fields = json_encode ( $fields );

      $headers = array (
        'Authorization: key=' . $apikey,
        'Content-Type: application/json'
      );

      $ch = curl_init ();
      curl_setopt ( $ch, CURLOPT_URL, $url );
      curl_setopt ( $ch, CURLOPT_POST, true );
      curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

      $result = curl_exec ( $ch );
      curl_close ( $ch );

      /*Guardar Notificación
      $notificationSave = new Notifications;
      $notificationSave->fecha = date('Y-m-d H:i');
      $notificationSave->titulo = 'Servicio Programado';
      $notificationSave->text = 'Su servicio ha sido programado para el día '.$fecha.' a las '.$hora.'. El conductor '.$conductor.' será el encargado de realizar el traslado. El vehículo es un '.$marca.' '.$modelo.' con placa '.$placa.'. Gracias por confiar en nosotros. ';
      $notificationSave->titulo_en = 'Scheduled Service';
      $notificationSave->text_en = 'Your service has been scheduled for '.$fecha.' at '.$hora.'. The driver '.$conductor.' will be in charge of making the transfer. The vehicle is a '.$marca.' '.$modelo.' with license plate '.$placa.'. Thanks for trusting us.';
      $notificationSave->id_usuario = $cliente_id;
      $notificationSave->tipo = 1;
      $notificationSave->id_servicio = $servicio;
      $notificationSave->save();
      Guardar Notificación*/

    }

    public static function rutaProgramada($id, $idioma, $servicio, $placa){

      $countFalse = 0;
      $countTrue = 0;
      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_CLIENT;

      if($idioma==='en'){

        $title = "Assigned Trip!";
        $message = "You have been scheduled to route on ".$servicio->fecha_servicio." at ".$servicio->hora_servicio." The vehicle's license plate is ".$placa.".";

      }else{

        $title = "¡Ruta Asignada!";
        $message = "Has sido programado para ruta el ".$servicio->fecha_servicio." a las ".$servicio->hora_servicio.". La placa del vehículo es ".$placa.".";

      }

      $fields = array (
        'registration_ids' => array (
          $id
        ),
        'notification' => array (
          "body" => $message,
          "title" => $title,
          "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
          'vibrationPattern' => [2000, 1000, 500, 500],
        ),
        'data' => array (
          "id" => 1
        )
      );
      $fields = json_encode ( $fields );

      $headers = array (
        'Authorization: key=' . $apikey,
        'Content-Type: application/json'
      );

      $ch = curl_init ();
      curl_setopt ( $ch, CURLOPT_URL, $url );
      curl_setopt ( $ch, CURLOPT_POST, true );
      curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

      $result = curl_exec ( $ch );
      curl_close ( $ch );

      /*Guardar Notificación
      $notificationSave = new Notifications;
      $notificationSave->fecha = date('Y-m-d H:i');
      $notificationSave->titulo = 'Servicio Programado';
      $notificationSave->text = 'Su servicio ha sido programado para el día '.$fecha.' a las '.$hora.'. El conductor '.$conductor.' será el encargado de realizar el traslado. El vehículo es un '.$marca.' '.$modelo.' con placa '.$placa.'. Gracias por confiar en nosotros. ';
      $notificationSave->titulo_en = 'Scheduled Service';
      $notificationSave->text_en = 'Your service has been scheduled for '.$fecha.' at '.$hora.'. The driver '.$conductor.' will be in charge of making the transfer. The vehicle is a '.$marca.' '.$modelo.' with license plate '.$placa.'. Thanks for trusting us.';
      $notificationSave->id_usuario = $cliente_id;
      $notificationSave->tipo = 1;
      $notificationSave->id_servicio = $servicio;
      $notificationSave->save();
      Guardar Notificación*/

    }

    public static function notificarTarifado($cliente_id, $fecha, $hora, $total){

      $countFalse = 0;
      $countTrue = 0;
      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_CLIENT;

      $user = User::find($cliente_id);

      $id_registration = $user->idregistrationdevice;

      if ($id_registration!=null and $id_registration!='') {

        $id = $id_registration;

        if($user->idioma==='en'){

          $title = 'Payment Available!';
          $message = 'The service requested for the day '.$fecha.' at '.$hora.' has a price of COP $'.number_format($total).'. Enter the list of services or the list of payments.';

        }else{

          $title = '¡Pago Disponible!';
          $message = 'El servicio solicitado para el dia '.$fecha.'  a las '.$hora.' tiene un valor de COP $'.number_format($total).'. Ingrese al listado de servicios o al listado de pagos.';

        }



        $fields = array (
          'registration_ids' => array (
            $id
          ),
          'notification' => array (
            "body" => $message,
            "title" => $title,
            "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
            'vibrationPattern' => [2000, 1000, 500, 500],
          )
        );
        $fields = json_encode ( $fields );

        $headers = array (
          'Authorization: key=' . $apikey,
          'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        curl_close ( $ch );

        /*Guardar Notificación*/
        $notificationSave = new Notifications;
        $notificationSave->fecha = date('Y-m-d H:i');
        $notificationSave->titulo = '¡Pago Disponible!';
        $notificationSave->text = 'El servicio solicitado para el dia '.$fecha.'  a las '.$hora.' tiene un valor de COP $'.number_format($total).'. Ingrese al listado de servicios o al listado de pagos.';
        $notificationSave->titulo_en = 'Payment Available!';
        $notificationSave->text_en = 'The service requested for the day '.$fecha.' at '.$hora.' has a price of COP $'.number_format($total).'. Enter the list of services or the list of payments.';
        $notificationSave->id_usuario = $cliente_id;
        $notificationSave->tipo = 2;
        //$notificationSave->id_servicio = $servicio;
        $notificationSave->save();
        /*Guardar Notificación*/

        return $result;

      }

    }

    public static function RechazarNovedad($novedad, $id_servicio){//RECHAZAR NOVEDAD DE SERVICIO

      $countFalse = 0;
      $countTrue = 0;

      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_DRIVER;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $servicio = Servicio::find($id_servicio);

      if ($servicio->conductor->user!=null) {

        $id_registration = $servicio->conductor->user->idregistrationdevice;

        if ($id_registration!=null and $id_registration!='') {

          $texto = 'La novedad ingresada en el servicio del '.$servicio->fecha_servicio.' fue rechazada.';

          $id = $id_registration;

          $fields = array (
            'registration_ids' => array (
              $id
            ),
            'notification' => array (
              "body" => $texto,
              "title" => 'Novedad Rechazada!',
              "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png'
            )
          );
          $fields = json_encode ( $fields );

          $headers = array (
            'Authorization: key=' . $apikey,
            'Content-Type: application/json'
          );

          $ch = curl_init ();
          curl_setopt ( $ch, CURLOPT_URL, $url );
          curl_setopt ( $ch, CURLOPT_POST, true );
          curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
          curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
          curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

          $result = curl_exec ( $ch );
          curl_close ( $ch );

          /*Guardar Notificación*
          $notificationSave = new Notifications;
          $notificationSave->fecha = date('Y-m-d H:i');
          $notificationSave->titulo = 'SERVICIO POR ACEPTAR...';
          $notificationSave->text = 'Le recordamos el servicio que tiene pendiente por aceptar para '.$day.' a las '.$horaServicio.' horas, desde: '.strtoupper($recogerEn).' hasta: '.strtoupper($dejarEn).' para el cliente '.strtoupper($servicio->centrodecosto->razonsocial);
          $notificationSave->id_usuario = $servicio->conductor->user->id;
          $notificationSave->tipo = 0;
          $notificationSave->id_servicio = $servicio->id;
          $notificationSave->save();
          Guardar Notificación*/

          if ($result===FALSE) {

            $countFalse++;

          }else{

            $countTrue++;

          }

        }

        $counters['countTrue'] = $countTrue;
        $counters['countFalse'] = $countFalse;

        return $counters;

      }

    }

    public static function notificacionWeb($message){

      $apikey = Notification::FIREBASE_KEY_DRIVER;

      $id_registration_web = User::whereNotNull('id_registration_web')->lists('id_registration_web');

      $data = [
        'data' => [
          'tipo_notificacion' => 'success'
        ],
        'notification' => [
          'title' => 'Autonet',
          'body' => $message,
          'icon' => 'https://app.aotour.com.co/autonet/image_notifications.png'
        ],
        'registration_ids' => $id_registration_web
      ];

      $headers = [
        'Authorization: key='. $apikey,
        'Content-Type: application/json'
      ];

      $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      $result = curl_exec($ch);

      curl_close($ch);

    }

    public static function enviarNotificacionPusher($channel, $name, $data){

      //Production pusher
      $app_id = Notification::APP_ID_PUSHER;
      $key = Notification::KEY_PUSHER;
      $secret = Notification::SECRET_PUSHER;;

      $body = [
        'data' => $data,
        'name' => $name,
        'channel' => $channel
      ];

      $auth_timestamp =  strtotime('now');
      //$auth_timestamp = '1534427844';

      $auth_version = '1.0';

      //Body convertido a md5 mediante una funcion
      $body_md5 = md5(json_encode($body));

      $string_to_sign =
        "POST\n/apps/".$app_id.
        "/events\nauth_key=".$key.
        "&auth_timestamp=".$auth_timestamp.
        "&auth_version=".$auth_version.
        "&body_md5=".$body_md5;

      $auth_signature = hash_hmac('SHA256', $string_to_sign, $secret);

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, 'https://api-us2.pusher.com/apps/'.$app_id.'/events?auth_key='.$key.'&body_md5='.$body_md5.'&auth_version=1.0&auth_timestamp='.$auth_timestamp.'&auth_signature='.$auth_signature.'&');

      curl_setopt($ch, CURLOPT_POST, 1);

      $headers = [
        'Content-Type: application/json'
      ];

      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

      $result = curl_exec($ch);

      curl_close($ch);

    }

    /*NOTIFICACIONES NUEVO - IONIC START*/


    public static function NotificacionDriver($message, $conductor_id){ //NOTIFICACIÓN DE APP CONDUCTORES

      $url = 'https://fcm.googleapis.com/fcm/send';
      $key = Notification::FIREBASE_KEY_DRIVER;

      $conductor = Conductor::find($conductor_id);

      if ($conductor->user->idregistrationdevice!=null and $conductor->user->idregistrationdevice!='' and $conductor->user!=null) {

        $id = $conductor->user->idregistrationdevice;

        $fields = array (
          'registration_ids' => array (
            $id
          ),
          'data' => array (
            "body" => $message
          )
        );
        $fields = json_encode ( $fields );

        $headers = array (
          'Authorization: key=' . $key,
          'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        curl_close ( $ch );

        return Response::json([
          'respuesta' => true,
          'resultado' => $result
        ]);

      }

    }//NOTIFICACIÓN DE APP CONDUCTORES

    /*NOTIFICACIONES NUEVO IONIC END*/














    //SDGM

    public static function RecordarServicio($conductorId, $fechaServicio, $horaServicio, $recogerEn, $dejarEn, $message, $id_servicio){//RECORDAR SERVICIO AL CONDUCTOR

      $countFalse = 0;
      $countTrue = 0;

      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_DRIVER;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $servicio = Servicio::find($id_servicio);

      if ($servicio->conductor->user!=null) {

        $id_registration = $servicio->conductor->user->idregistrationdevice;

        if ($id_registration!=null and $id_registration!='') {

          if($fechaServicio===date('Y-m-d')){
            $day = 'HOY';
          }else{
            $day = 'MAÑANA';
          }

          $texto = 'Le recordamos el servicio que tiene pendiente por aceptar para '.$day.' a las '.$horaServicio.' horas, desde: '.strtoupper($recogerEn).' hasta: '.strtoupper($dejarEn).' para el cliente '.strtoupper($servicio->centrodecosto->razonsocial);

          $id = $id_registration;

          $fields = array (
            'registration_ids' => array (
              $id
            ),
            'notification' => array (
              "body" => $texto,
              "title" => 'SERVICIO POR ACEPTAR...',
              "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png'
            )
          );
          $fields = json_encode ( $fields );

          $headers = array (
            'Authorization: key=' . $apikey,
            'Content-Type: application/json'
          );

          $ch = curl_init ();
          curl_setopt ( $ch, CURLOPT_URL, $url );
          curl_setopt ( $ch, CURLOPT_POST, true );
          curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
          curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
          curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

          $result = curl_exec ( $ch );
          curl_close ( $ch );

          /*Guardar Notificación*/
          $notificationSave = new Notifications;
          $notificationSave->fecha = date('Y-m-d H:i');
          $notificationSave->titulo = 'SERVICIO POR ACEPTAR...';
          $notificationSave->text = 'Le recordamos el servicio que tiene pendiente por aceptar para '.$day.' a las '.$horaServicio.' horas, desde: '.strtoupper($recogerEn).' hasta: '.strtoupper($dejarEn).' para el cliente '.strtoupper($servicio->centrodecosto->razonsocial);
          $notificationSave->id_usuario = $servicio->conductor->user->id;
          $notificationSave->tipo = 0;
          $notificationSave->id_servicio = $servicio->id;
          $notificationSave->save();
          /*Guardar Notificación*/

          if ($result===FALSE) {

            $countFalse++;

          }else{

            $countTrue++;

          }

        }

        $counters['countTrue'] = $countTrue;
        $counters['countFalse'] = $countFalse;

        return $counters;

      }

    }

    /*NOTIFICACIONES VERSIÓN FINAL*/
    public static function Reconfirmar($conductorId, $fechaServicio, $horaServicio, $recogerEn, $dejarEn, $message, $id_servicio){//RECONFIRMADOR PARA EL CONDUCTOR

      $countFalse = 0;
      $countTrue = 0;

      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_DRIVER;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $servicio = Servicio::find($id_servicio);

      if ($servicio->conductor->user!=null) {

        $id_registration = $servicio->conductor->user->idregistrationdevice;

        if ($id_registration!=null and $id_registration!='') {

          if($fechaServicio===date('Y-m-d')){
            $day = 'HOY';
          }else{
            $day = 'MAÑANA';
          }

          $texto = 'Le recordamos el servicio programado para el día de '.$day.' a las '.$horaServicio.' horas, desde: '.strtoupper($recogerEn).' hasta: '.strtoupper($dejarEn).' para el cliente '.strtoupper($servicio->centrodecosto->razonsocial);

          $id = $id_registration;

          $fields = array (
            'registration_ids' => array (
              $id
            ),
            'notification' => array (
              "body" => $texto,
              "title" => 'Reconfirmación de '.$message,
              "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png'
            )
          );
          $fields = json_encode ( $fields );

          $headers = array (
            'Authorization: key=' . $apikey,
            'Content-Type: application/json'
          );

          $ch = curl_init ();
          curl_setopt ( $ch, CURLOPT_URL, $url );
          curl_setopt ( $ch, CURLOPT_POST, true );
          curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
          curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
          curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

          $result = curl_exec ( $ch );
          curl_close ( $ch );

          //Guardar Notificación
          $notificationSave = new Notifications;
          $notificationSave->fecha = date('Y-m-d H:i');
          $notificationSave->titulo = 'Reconfirmación de '.$message;
          $notificationSave->text = 'Le recordamos el servicio programado para el día de '.$day.' a las '.$horaServicio.' horas, desde: '.strtoupper($recogerEn).' hasta: '.strtoupper($dejarEn).' para el cliente '.strtoupper($servicio->centrodecosto->razonsocial);
          $notificationSave->id_usuario = $servicio->conductor->user->id;
          $notificationSave->tipo = 0;
          $notificationSave->id_servicio = $servicio->id;
          $notificationSave->save();
          //Guardar Notificación

          if ($result===FALSE) {

            $countFalse++;

          }else{

            $countTrue++;

          }

        }

        $counters['countTrue'] = $countTrue;
        $counters['countFalse'] = $countFalse;

        return $counters;

      }

    }

    public static function Reconfirmarinicio($conductorId, $fechaServicio, $horaServicio, $recogerEn, $dejarEn, $message, $id_servicio){//RECONFIRMADOR PARA EL CONDUCTOR

      $countFalse = 0;
      $countTrue = 0;

      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_DRIVER;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $servicio = Servicio::find($id_servicio);

      if ($servicio->conductor->user!=null) {

        $id_registration = $servicio->conductor->user->idregistrationdevice;

        if ($id_registration!=null and $id_registration!='') {

          $texto = 'Confirma aquí tu servicio de las '.$horaServicio.'.';

          $id = $id_registration;

          $fields = array (
            'registration_ids' => array (
              $id
            ),
            'notification' => array (
              "body" => $texto,
              "title" => 'En 2 horas inicia tu servicio...',
              "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png'
            )
          );
          $fields = json_encode ( $fields );

          $headers = array (
            'Authorization: key=' . $apikey,
            'Content-Type: application/json'
          );

          $ch = curl_init ();
          curl_setopt ( $ch, CURLOPT_URL, $url );
          curl_setopt ( $ch, CURLOPT_POST, true );
          curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
          curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
          curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

          $result = curl_exec ( $ch );
          curl_close ( $ch );

          //Guardar Notificación
          /*$notificationSave = new Notifications;
          $notificationSave->fecha = date('Y-m-d H:i');
          $notificationSave->titulo = 'Reconfirmación de '.$message;
          $notificationSave->text = 'Le recordamos el servicio programado para el día de '.$day.' a las '.$horaServicio.' horas, desde: '.strtoupper($recogerEn).' hasta: '.strtoupper($dejarEn).' para el cliente '.strtoupper($servicio->centrodecosto->razonsocial);
          $notificationSave->id_usuario = $servicio->conductor->user->id;
          $notificationSave->tipo = 0;
          $notificationSave->id_servicio = $servicio->id;
          $notificationSave->save();*/
          //Guardar Notificación

          if ($result===FALSE) {

            $countFalse++;

          }else{

            $countTrue++;

          }

        }

        $counters['countTrue'] = $countTrue;
        $counters['countFalse'] = $countFalse;

        return $counters;

      }

    }

    public static function Notificarparaconfirmar($conductorId, $fechaServicio, $horaServicio, $recogerEn, $dejarEn, $message, $id_servicio){//RECONFIRMADOR PARA EL CONDUCTOR

      $countFalse = 0;
      $countTrue = 0;

      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_DRIVER;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $servicio = Servicio::find($id_servicio);

      if ($servicio->conductor->user!=null) {

        $id_registration = $servicio->conductor->user->idregistrationdevice;

        if ($id_registration!=null and $id_registration!='') {

          $texto = 'Presiona aquí para confirmar tu servicio de las '.$horaServicio.'.';

          $id = $id_registration;

          $fields = array (
            'registration_ids' => array (
              $id
            ),
            'notification' => array (
              "body" => $texto,
              "title" => 'Confirma tu servicio...',
              "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png'
            ),
            'data' => array (
              "id" => 4,
              "screen" => 'future',
            )
          );
          $fields = json_encode ( $fields );

          $headers = array (
            'Authorization: key=' . $apikey,
            'Content-Type: application/json'
          );

          $ch = curl_init ();
          curl_setopt ( $ch, CURLOPT_URL, $url );
          curl_setopt ( $ch, CURLOPT_POST, true );
          curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
          curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
          curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

          $result = curl_exec ( $ch );
          curl_close ( $ch );

          if ($result===FALSE) {

            $countFalse++;

          }else{

            $countTrue++;

          }

        }

        $counters['countTrue'] = $countTrue;
        $counters['countFalse'] = $countFalse;

        //return $counters;

      }

    }

    public static function Notificarparainiciar($conductorId, $fechaServicio, $horaServicio, $recogerEn, $dejarEn, $message, $id_servicio){//RECONFIRMADOR PARA EL CONDUCTOR

      $countFalse = 0;
      $countTrue = 0;

      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_DRIVER;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $servicio = Servicio::find($id_servicio);

      if ($servicio->conductor->user!=null) {

        $id_registration = $servicio->conductor->user->idregistrationdevice;

        if ($id_registration!=null and $id_registration!='') {

          $texto = 'Presiona aquí para ir a iniciar tu servicio de las '.$horaServicio.'.';

          $id = $id_registration;

          $fields = array (
            'registration_ids' => array (
              $id
            ),
            'notification' => array (
              "body" => $texto,
              "title" => '¡Inicia tu Servicio!',
              "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png'
            )
          );
          $fields = json_encode ( $fields );

          $headers = array (
            'Authorization: key=' . $apikey,
            'Content-Type: application/json'
          );

          $ch = curl_init ();
          curl_setopt ( $ch, CURLOPT_URL, $url );
          curl_setopt ( $ch, CURLOPT_POST, true );
          curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
          curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
          curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

          $result = curl_exec ( $ch );
          curl_close ( $ch );

          //Guardar Notificación
          /*$notificationSave = new Notifications;
          $notificationSave->fecha = date('Y-m-d H:i');
          $notificationSave->titulo = 'Reconfirmación de '.$message;
          $notificationSave->text = 'Le recordamos el servicio programado para el día de '.$day.' a las '.$horaServicio.' horas, desde: '.strtoupper($recogerEn).' hasta: '.strtoupper($dejarEn).' para el cliente '.strtoupper($servicio->centrodecosto->razonsocial);
          $notificationSave->id_usuario = $servicio->conductor->user->id;
          $notificationSave->tipo = 0;
          $notificationSave->id_servicio = $servicio->id;
          $notificationSave->save();*/
          //Guardar Notificación

          if ($result===FALSE) {

            $countFalse++;

          }else{

            $countTrue++;

          }

        }

        $counters['countTrue'] = $countTrue;
        $counters['countFalse'] = $countFalse;

        //return $counters;

      }

    }

    public static function ReconfirmarCliente($userId, $fechaServicio, $horaServicio, $recogerEn, $dejarEn, $message, $id_servicio){//RECONFIRMADOR AL USUARIO

      $countFalse = 0;
      $countTrue = 0;

      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_CLIENT;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $usuario = DB::table('users')
      ->where('id',$userId)
      ->first();

      if ($usuario->idregistrationdevice!=null and $usuario->idregistrationdevice!='') {

          $id = $usuario->idregistrationdevice;

          if($usuario->idioma==='en'){

            $title = 'Aotour Notifications';
            $message = 'Your service to '.strtoupper($dejarEn).' will start at '.$horaServicio.'. If you have any concerns, you can contact the driver in the call option, located in SCHEDULED SERVICES.';

          }else{

            $title = 'Notificaciones Aotour';
            $message = 'Su servicio a '.strtoupper($dejarEn).' iniciará a las '.$horaServicio.' horas. Si presentas alguna inquietud, puedes comunicarte con el conductor en la opción de llamada, ubicada en SERVICIOS PROGRAMADOS.';

          }

          $fields = array (
            'registration_ids' => array (
              $id
            ),
            'notification' => array (
              "body" => $message,
              "title" => $title,
              "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
              "vibration_pattern" => $vibration_pattern
            )
          );
          $fields = json_encode ( $fields );

          $headers = array (
            'Authorization: key=' . $apikey,
            'Content-Type: application/json'
          );

          $ch = curl_init ();
          curl_setopt ( $ch, CURLOPT_URL, $url );
          curl_setopt ( $ch, CURLOPT_POST, true );
          curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
          curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
          curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

          $result = curl_exec ( $ch );
          curl_close ( $ch );


          if ($result===FALSE) {

            $countFalse++;

          }else{

            $countTrue++;

          }

        }

        /*Guardar Notificación*/
        $notificationSave = new Notifications;
        $notificationSave->fecha = date('Y-m-d H:i');
        $notificationSave->titulo = 'Notificaciones Aotour';
        $notificationSave->text = 'Su servicio a '.strtoupper($dejarEn).' iniciará a las '.$horaServicio.' horas. Si presentas alguna inquietud, puedes comunicarte con el conductor en la opción de llamada, ubicada en SERVICIOS PROGRAMADOS.';
        $notificationSave->titulo_en = 'Aotour Notifications';
        $notificationSave->text_en = 'Your service to '.strtoupper($dejarEn).' will start at '.$horaServicio.'. If you have any concerns, you can contact the driver in the call option, located in SCHEDULED SERVICES.';
        $notificationSave->id_usuario = $userId;
        $notificationSave->tipo = 3;
        $notificationSave->id_servicio = $id_servicio;
        $notificationSave->save();
        /*Guardar Notificación*/

        $counters['countTrue'] = $countTrue;
        $counters['countFalse'] = $countFalse;

        return $counters;

    }

    public static function NotificacionesUpdate($mensaje, $conductor_id){//CAMBIOS EN EL SERVICIO,

      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_DRIVER;

      $conductor = Conductor::find($conductor_id);
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      if ($conductor->user!=null) {

        if ($conductor->user->idregistrationdevice!=null and $conductor->user->idregistrationdevice!='') {

          $id = $conductor->user->idregistrationdevice;

          $fields = array (
            'registration_ids' => array (
              $id
            ),
            'notification' => array (
              "body" => $mensaje,
              "title" => 'Cambios en el Servicio',
              "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png'
            )
          );
          $fields = json_encode ( $fields );

          $headers = array (
            'Authorization: key=' . "AAAABsrVRW8:APA91bHeyqFdFTYzPuSQe6SXB-FO1bLqJ_cQcNTWim-oBShNazh00NagwyKA0ouZC94lre12goZcjSzyqwpDJsGPiVa4voh7xm3-DOkl11u2YF9f3PnLXFRdmb59vXYj6cHeafkuqeA-",
            'Content-Type: application/json'
          );

          $ch = curl_init ();
          curl_setopt ( $ch, CURLOPT_URL, $url );
          curl_setopt ( $ch, CURLOPT_POST, true );
          curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
          curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
          curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

          $result = curl_exec ( $ch );

          if ($result===FALSE) {

            return Response::json([
              'respuesta' => false,
              'response' => 'ID device no registrado'
            ]);

          }else{

            return Response::json([
              'respuesta' => true,
              'token' => $id,
              'resultado' => $result
            ]);

          }

          curl_close($ch);

        }else{

          return Response::json([
            'response' => false,
            'respuesta' => 'ID device no registrado'
          ]);

        }

      }else {

        return Response::json([
          'response' => false,
          'respuesta' => 'No tiene cuenta para la aplicacion'
        ]);

      }

    }

    public static function Notificaciones($mensaje, $conductor_id){//PROGRAMACIÓN DE SERVICIO Y NOTIFICAR EN LISTA DE SERVICIOS

      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_DRIVER;

      $conductor = Conductor::find($conductor_id);
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      if ($conductor->user!=null) {

        if ($conductor->user->idregistrationdevice!=null and $conductor->user->idregistrationdevice!='') {

          $id = $conductor->user->idregistrationdevice;

          $fields = array (
            'registration_ids' => array (
              $id
            ),
            'notification' => array (
              "body" => $mensaje,
              "title" => '¡Servicio Asignado!',
              "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png'
            )
          );
          $fields = json_encode ( $fields );

          $headers = array (
            'Authorization: key=' . "AAAABsrVRW8:APA91bHeyqFdFTYzPuSQe6SXB-FO1bLqJ_cQcNTWim-oBShNazh00NagwyKA0ouZC94lre12goZcjSzyqwpDJsGPiVa4voh7xm3-DOkl11u2YF9f3PnLXFRdmb59vXYj6cHeafkuqeA-",
            'Content-Type: application/json'
          );

          $ch = curl_init ();
          curl_setopt ( $ch, CURLOPT_URL, $url );
          curl_setopt ( $ch, CURLOPT_POST, true );
          curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
          curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
          curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

          $result = curl_exec ( $ch );

          if ($result===FALSE) {

            return Response::json([
              'respuesta' => false,
              'response' => 'ID device no registrado'
            ]);

          }else{

            return Response::json([
              'respuesta' => true,
              'token' => $id,
              'resultado' => $result
            ]);

          }

          curl_close($ch);

        }else{

          return Response::json([
            'response' => false,
            'respuesta' => 'ID device no registrado'
          ]);

        }

      }else {

        return Response::json([
          'response' => false,
          'respuesta' => 'No tiene cuenta para la aplicacion'
        ]);

      }

    }

    public static function enviarNotificaciones($conductorId, $fechaServicio, $horaServicio, $recogerEn, $dejarEn, $idNotificacion, $id_servicio){//ACTUALIZADO

      $countFalse = 0;
      $countTrue = 0;

      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_DRIVER;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $servicio = Servicio::find($id_servicio);

      if ($servicio->conductor->user!=null) {

        $id_registration = $servicio->conductor->user->idregistrationdevice;

        if ($id_registration!=null and $id_registration!='') {

          $message = 'Se le ha asignado un nuevo servicio para el día '.$fechaServicio.', hora: '.$horaServicio.', recoger en: '.ucwords(strtolower($recogerEn)).' y dejar en: '.ucwords(strtolower($dejarEn)).' para '.ucwords(strtolower($servicio->centrodecosto->razonsocial));

          $id = $id_registration;

          $fields = array (
            'registration_ids' => array (
              $id
            ),
            'notification' => array (
              "body" => $message,
              "title" => '¡Servicio Asignado!',
              "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png'
            )
          );
          $fields = json_encode ( $fields );

          $headers = array (
            'Authorization: key=' . $apikey,
            'Content-Type: application/json'
          );

          $ch = curl_init ();
          curl_setopt ( $ch, CURLOPT_URL, $url );
          curl_setopt ( $ch, CURLOPT_POST, true );
          curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
          curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
          curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

          $result = curl_exec ( $ch );
          curl_close ( $ch );


          if ($result===FALSE) {

            $countFalse++;

          }else{

            $countTrue++;
            /*Guardar Notificación*/
            $notificationSave = new Notifications;
            $notificationSave->fecha = date('Y-m-d H:i');
            $notificationSave->titulo = 'Servicio Asignado';
            $notificationSave->text = $message;
            //$notificationSave->titulo_en = 'Scheduled Service';
            //$notificationSave->text_en = $message;
            $notificationSave->id_usuario = $servicio->conductor->user->id;
            $notificationSave->tipo = 6;
            $notificationSave->id_servicio = $id_servicio;
            $notificationSave->save();
            /*Guardar Notificación*/

          }

        }

        $counters['countTrue'] = $countTrue;
        $counters['countFalse'] = $countFalse;

        return $counters;

      }

    }

    public static function NotificacionClient($message, $messageEn, $user){ //NOTIFICACIÓN UPDATE SERVICIO DE APP CLIENTE

      $url = 'https://fcm.googleapis.com/fcm/send';
      $key = Notification::FIREBASE_KEY_CLIENT;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $usuario = DB::table('users')
      ->where('id',$user)
      ->first();

      if ($usuario->idregistrationdevice!=null and $usuario->idregistrationdevice!='') {

        $id = $usuario->idregistrationdevice;

        if($usuario->idioma==='en'){

          $title = 'Service Update...';
          $message = $messageEn;

        }else{

          $title = 'Actualización de Servicio...';
          $message = $message;

        }

        $fields = array (
          'registration_ids' => array (
            $id
          ),
          'notification' => array (
            "body" => $message,
            "title" => $title,
            "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
            "vibration_pattern" => $vibration_pattern
          )
        );
        $fields = json_encode ( $fields );

        $headers = array (
          'Authorization: key=' . $key,
          'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        //curl_close ( $ch );

        /*Guardar Notificación*/
        $notificationSave = new Notifications;
        $notificationSave->fecha = date('Y-m-d H:i');
        $notificationSave->titulo = 'Actualización de Servicio...';
        $notificationSave->text = $message;
        $notificationSave->titulo_en = 'Service Update...';
        $notificationSave->text_en = $messageEn;
        $notificationSave->id_usuario = $cliente_id;
        $notificationSave->tipo = 6;
        $notificationSave->id_servicio = $servicio;
        $notificationSave->save();
        /*Guardar Notificación*/

        return Response::json([
          'respuesta' => true,
          'resultado' => $result
        ]);

      }

    }//NOTIFICACIÓN DE APP CLIENTE

    public static function ServicioIniciado($servicio_id, $user){ //NOTIFICACIÓN UPDATE SERVICIO DE APP CLIENTE

      $url = 'https://fcm.googleapis.com/fcm/send';
      $key = Notification::FIREBASE_KEY_CLIENT;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $usuario = DB::table('users')
      ->where('id',$user)
      ->first();

      if ($usuario->idregistrationdevice!=null and $usuario->idregistrationdevice!='') {

        $id = $usuario->idregistrationdevice;

        if($usuario->idioma==='en'){

          $title = 'Service Started!';
          $message = 'Your service is now available for tracking. Click here to go.';

        }else{

          $title = '¡Servicio Iniciado!';
          $message = 'Tu servicio ya se encuentra disponible para hacer tracking. Click aquí para ir.';

        }

        $fields = array (
          'registration_ids' => array (
            $id
          ),
          'notification' => array (
            "body" => $message,
            "title" => $title,
            "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
            "vibration_pattern" => $vibration_pattern
          ),
          'data' => array (
            "id" => 4,
            "servicio" => $servicio_id,
            "screen" => 'current',
          )
        );
        $fields = json_encode ( $fields );

        $headers = array (
          'Authorization: key=' . $key,
          'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        //curl_close ( $ch );

        /*Guardar Notificación*/
        $notificationSave = new Notifications;
        $notificationSave->fecha = date('Y-m-d H:i');
        $notificationSave->titulo = '¡Servicio Iniciado!';
        $notificationSave->text = 'Tu servicio ya se encuentra disponible para hacer tracking. Click aquí para ir.';
        $notificationSave->titulo_en = 'Service Started!';
        $notificationSave->text_en = 'Your service is now available for tracking. Click here to go.';
        $notificationSave->id_usuario = $user;
        $notificationSave->tipo = 4;
        $notificationSave->id_servicio = $servicio_id;
        $notificationSave->save();
        /*Guardar Notificación*/

        return Response::json([
          'respuesta' => true,
          'resultado' => $result
        ]);

      }

    }//NOTIFICACIÓN DE APP CLIENTE INICIO DE SERVICIO

    public static function RutaIniciada($servicio_id, $idregistrationdevice){ //NOTIFICACIÓN UPDATE SERVICIO DE APP CLIENTE

      $url = 'https://fcm.googleapis.com/fcm/send';
      $key = Notification::FIREBASE_KEY_CLIENT;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $id = $idregistrationdevice;

      /*if($usuario->idioma==='en'){

        $title = 'Service Started!';
        $message = 'Your Route is now available for tracking. Click here to go.';

      }else{

        $title = '¡Servicio Iniciado!';
        $message = 'Tu ruta ya se encuentra disponible para hacer tracking. Click aquí para ir.';

      }*/

      $title = '¡Tu ruta ha iniciado!';
        $message = 'Tu ruta ya se encuentra disponible para hacer tracking. Click aquí para ir.';

      $fields = array (
        'registration_ids' => array (
          $id
        ),
        'notification' => array (
          "body" => $message,
          "title" => $title,
          "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
          "vibration_pattern" => $vibration_pattern
        ),
        'data' => array (
          "id" => 4,
          "servicio" => $servicio_id,
          "screen" => 'current',
        )
      );
      $fields = json_encode ( $fields );

      $headers = array (
        'Authorization: key=' . $key,
        'Content-Type: application/json'
      );

      $ch = curl_init ();
      curl_setopt ( $ch, CURLOPT_URL, $url );
      curl_setopt ( $ch, CURLOPT_POST, true );
      curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

      $result = curl_exec ( $ch );
      //curl_close ( $ch );

      /*Guardar Notificación
      $notificationSave = new Notifications;
      $notificationSave->fecha = date('Y-m-d H:i');
      $notificationSave->titulo = '¡Servicio Iniciado!';
      $notificationSave->text = 'Tu servicio ya se encuentra disponible para hacer tracking. Click aquí para ir.';
      $notificationSave->titulo_en = 'Service Started!';
      $notificationSave->text_en = 'Your service is now available for tracking. Click here to go.';
      $notificationSave->id_usuario = $user;
      $notificationSave->tipo = 4;
      $notificationSave->id_servicio = $servicio_id;
      $notificationSave->save();
      Guardar Notificación*/

    }//NOTIFICACIÓN DE APP CLIENTE INICIO DE SERVICIO

    public static function usuarioActual($servicio_id, $idregistrationdevice){ //Notificación al pasajero que van por el

      $url = 'https://fcm.googleapis.com/fcm/send';
      $key = Notification::FIREBASE_KEY_CLIENT;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $id = $idregistrationdevice;

      /*if($usuario->idioma==='en'){

        $title = 'Service Started!';
        $message = 'Your Route is now available for tracking. Click here to go.';

      }else{

        $title = '¡Servicio Iniciado!';
        $message = 'Tu ruta ya se encuentra disponible para hacer tracking. Click aquí para ir.';

      }*/

      $title = 'Tu conductor viene en camino...';
        $message = 'Tu conductor se dirige a tu dirección. Te notificaremos cuando llegue a tu ubicación.';

      $fields = array (
        'registration_ids' => array (
          $id
        ),
        'notification' => array (
          "body" => $message,
          "title" => $title,
          "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
          "vibration_pattern" => $vibration_pattern
        ),
        'data' => array (
          "id" => 4,
          "servicio" => $servicio_id,
          "screen" => 'current',
        )
      );
      $fields = json_encode ( $fields );

      $headers = array (
        'Authorization: key=' . $key,
        'Content-Type: application/json'
      );

      $ch = curl_init ();
      curl_setopt ( $ch, CURLOPT_URL, $url );
      curl_setopt ( $ch, CURLOPT_POST, true );
      curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

      $result = curl_exec ( $ch );
      //curl_close ( $ch );

      /*Guardar Notificación
      $notificationSave = new Notifications;
      $notificationSave->fecha = date('Y-m-d H:i');
      $notificationSave->titulo = '¡Servicio Iniciado!';
      $notificationSave->text = 'Tu servicio ya se encuentra disponible para hacer tracking. Click aquí para ir.';
      $notificationSave->titulo_en = 'Service Started!';
      $notificationSave->text_en = 'Your service is now available for tracking. Click here to go.';
      $notificationSave->id_usuario = $user;
      $notificationSave->tipo = 4;
      $notificationSave->id_servicio = $servicio_id;
      $notificationSave->save();
      Guardar Notificación*/

    }//NOTIFICACIÓN DE APP CLIENTE INICIO DE SERVICIO

    public static function esperandoPasajeroUp($servicio_id, $idregistrationdevice){ //Notificación al pasajero que van por el

      $url = 'https://fcm.googleapis.com/fcm/send';
      $key = Notification::FIREBASE_KEY_CLIENT;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $id = $idregistrationdevice;

      /*if($usuario->idioma==='en'){

        $title = 'Service Started!';
        $message = 'Your Route is now available for tracking. Click here to go.';

      }else{

        $title = '¡Servicio Iniciado!';
        $message = 'Tu ruta ya se encuentra disponible para hacer tracking. Click aquí para ir.';

      }*/

      $title = 'Tu conductor ha llegado...';
        $message = 'Tu conductor te está esperando. Presiona aquí para conocer la ubicación de tu conductor.';

      $fields = array (
        'registration_ids' => array (
          $id
        ),
        'notification' => array (
          "body" => $message,
          "title" => $title,
          "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
          "vibration_pattern" => $vibration_pattern
        ),
        'data' => array (
          "id" => 4,
          "servicio" => $servicio_id,
          "screen" => 'current',
        )
      );
      $fields = json_encode ( $fields );

      $headers = array (
        'Authorization: key=' . $key,
        'Content-Type: application/json'
      );

      $ch = curl_init ();
      curl_setopt ( $ch, CURLOPT_URL, $url );
      curl_setopt ( $ch, CURLOPT_POST, true );
      curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

      $result = curl_exec ( $ch );
      //curl_close ( $ch );

      /*Guardar Notificación
      $notificationSave = new Notifications;
      $notificationSave->fecha = date('Y-m-d H:i');
      $notificationSave->titulo = '¡Servicio Iniciado!';
      $notificationSave->text = 'Tu servicio ya se encuentra disponible para hacer tracking. Click aquí para ir.';
      $notificationSave->titulo_en = 'Service Started!';
      $notificationSave->text_en = 'Your service is now available for tracking. Click here to go.';
      $notificationSave->id_usuario = $user;
      $notificationSave->tipo = 4;
      $notificationSave->id_servicio = $servicio_id;
      $notificationSave->save();
      Guardar Notificación*/

    }//NOTIFICACIÓN DE APP CLIENTE INICIO DE SERVICIO

    public static function bienvenidoaBordo($servicio_id, $idregistrationdevice){ //Notificación al pasajero que van por el

      $url = 'https://fcm.googleapis.com/fcm/send';
      $key = Notification::FIREBASE_KEY_CLIENT;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $id = $idregistrationdevice;

      /*if($usuario->idioma==='en'){

        $title = 'Service Started!';
        $message = 'Your Route is now available for tracking. Click here to go.';

      }else{

        $title = '¡Servicio Iniciado!';
        $message = 'Tu ruta ya se encuentra disponible para hacer tracking. Click aquí para ir.';

      }*/

      $title = '¡Bienvenido a Bordo!';
        $message = 'En instantes nos dirigiremos al punto de destino.';

      $fields = array (
        'registration_ids' => array (
          $id
        ),
        'notification' => array (
          "body" => $message,
          "title" => $title,
          "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
          "vibration_pattern" => $vibration_pattern
        ),
        'data' => array (
          "id" => 4,
          "servicio" => $servicio_id,
          "screen" => 'current',
        )
      );
      $fields = json_encode ( $fields );

      $headers = array (
        'Authorization: key=' . $key,
        'Content-Type: application/json'
      );

      $ch = curl_init ();
      curl_setopt ( $ch, CURLOPT_URL, $url );
      curl_setopt ( $ch, CURLOPT_POST, true );
      curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

      $result = curl_exec ( $ch );
      //curl_close ( $ch );

      /*Guardar Notificación
      $notificationSave = new Notifications;
      $notificationSave->fecha = date('Y-m-d H:i');
      $notificationSave->titulo = '¡Servicio Iniciado!';
      $notificationSave->text = 'Tu servicio ya se encuentra disponible para hacer tracking. Click aquí para ir.';
      $notificationSave->titulo_en = 'Service Started!';
      $notificationSave->text_en = 'Your service is now available for tracking. Click here to go.';
      $notificationSave->id_usuario = $user;
      $notificationSave->tipo = 4;
      $notificationSave->id_servicio = $servicio_id;
      $notificationSave->save();
      Guardar Notificación*/

    }//NOTIFICACIÓN DE APP CLIENTE INICIO DE SERVICIO

    public static function haciaDestino($servicio_id, $idregistrationdevice, $dejar_en){ //Notificación al pasajero que van por el

      $url = 'https://fcm.googleapis.com/fcm/send';
      $key = Notification::FIREBASE_KEY_CLIENT;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $id = $idregistrationdevice;

      /*if($usuario->idioma==='en'){

        $title = 'Service Started!';
        $message = 'Your Route is now available for tracking. Click here to go.';

      }else{

        $title = '¡Servicio Iniciado!';
        $message = 'Tu ruta ya se encuentra disponible para hacer tracking. Click aquí para ir.';

      }*/

      $title = 'Recorrido terminado...';
        $message = 'Ahora nos dirigimos hacia el punto de destino: '.$dejar_en.'.';

      $fields = array (
        'registration_ids' => array (
          $id
        ),
        'notification' => array (
          "body" => $message,
          "title" => $title,
          "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
          "vibration_pattern" => $vibration_pattern
        ),
        'data' => array (
          "id" => 4,
          "servicio" => $servicio_id,
          "screen" => 'current',
        )
      );
      $fields = json_encode ( $fields );

      $headers = array (
        'Authorization: key=' . $key,
        'Content-Type: application/json'
      );

      $ch = curl_init ();
      curl_setopt ( $ch, CURLOPT_URL, $url );
      curl_setopt ( $ch, CURLOPT_POST, true );
      curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

      $result = curl_exec ( $ch );
      //curl_close ( $ch );

      /*Guardar Notificación
      $notificationSave = new Notifications;
      $notificationSave->fecha = date('Y-m-d H:i');
      $notificationSave->titulo = '¡Servicio Iniciado!';
      $notificationSave->text = 'Tu servicio ya se encuentra disponible para hacer tracking. Click aquí para ir.';
      $notificationSave->titulo_en = 'Service Started!';
      $notificationSave->text_en = 'Your service is now available for tracking. Click here to go.';
      $notificationSave->id_usuario = $user;
      $notificationSave->tipo = 4;
      $notificationSave->id_servicio = $servicio_id;
      $notificationSave->save();
      Guardar Notificación*/

    }//NOTIFICACIÓN DE APP CLIENTE INICIO DE SERVICIO

    public static function finCalificar($servicio_id, $idregistrationdevice){ //Notificación al pasajero que van por el

      $url = 'https://fcm.googleapis.com/fcm/send';
      $key = Notification::FIREBASE_KEY_CLIENT;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $id = $idregistrationdevice;

      /*if($usuario->idioma==='en'){

        $title = 'Service Started!';
        $message = 'Your Route is now available for tracking. Click here to go.';

      }else{

        $title = '¡Servicio Iniciado!';
        $message = 'Tu ruta ya se encuentra disponible para hacer tracking. Click aquí para ir.';

      }*/

      $title = '¡Ruta finalizada!';
        $message = 'Esperamos que hayas disfrutado tu viaje. Te agradecemos calificar nuestro servicio.';

      $fields = array (
        'registration_ids' => array (
          $id
        ),
        'notification' => array (
          "body" => $message,
          "title" => $title,
          "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
          "vibration_pattern" => $vibration_pattern
        ),
        'data' => array (
          "id" => 4,
          "servicio" => $servicio_id,
          "screen" => 'current',
        )
      );
      $fields = json_encode ( $fields );

      $headers = array (
        'Authorization: key=' . $key,
        'Content-Type: application/json'
      );

      $ch = curl_init ();
      curl_setopt ( $ch, CURLOPT_URL, $url );
      curl_setopt ( $ch, CURLOPT_POST, true );
      curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

      $result = curl_exec ( $ch );
      //curl_close ( $ch );

      /*Guardar Notificación
      $notificationSave = new Notifications;
      $notificationSave->fecha = date('Y-m-d H:i');
      $notificationSave->titulo = '¡Servicio Iniciado!';
      $notificationSave->text = 'Tu servicio ya se encuentra disponible para hacer tracking. Click aquí para ir.';
      $notificationSave->titulo_en = 'Service Started!';
      $notificationSave->text_en = 'Your service is now available for tracking. Click here to go.';
      $notificationSave->id_usuario = $user;
      $notificationSave->tipo = 4;
      $notificationSave->id_servicio = $servicio_id;
      $notificationSave->save();
      Guardar Notificación*/

    }//NOTIFICACIÓN DE APP CLIENTE INICIO DE SERVICIO

    public static function Enespera($servicio_id, $user){ //NOTIFICACIÓN UPDATE SERVICIO DE APP CLIENTE

      $url = 'https://fcm.googleapis.com/fcm/send';
      $key = Notification::FIREBASE_KEY_CLIENT;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $usuario = DB::table('users')
      ->where('id',$user)
      ->first();

      if ($usuario->idregistrationdevice!=null and $usuario->idregistrationdevice!='') {

        $id = $usuario->idregistrationdevice;

        if($usuario->idioma==='en'){

          $title = 'En punto de espera...';
          $message = 'Tu conductor te está esperando...';

        }else{

          $title = 'En punto de espera...';
          $message = 'Tu conductor te está esperando...';

        }

        $fields = array (
          'registration_ids' => array (
            $id
          ),
          'notification' => array (
            "body" => $message,
            "title" => $title,
            "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
            "vibration_pattern" => $vibration_pattern
          ),
          'data' => array (
            "id" => 4,
            "servicio" => $servicio_id,
            "screen" => 'waiting',
          )
        );
        $fields = json_encode ( $fields );

        $headers = array (
          'Authorization: key=' . $key,
          'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        //curl_close ( $ch );

        /*Guardar Notificación*/
        $notificationSave = new Notifications;
        $notificationSave->fecha = date('Y-m-d H:i');
        $notificationSave->titulo = 'En punto de espera...';
        $notificationSave->text = 'Tu conductor te está esperando...';
        $notificationSave->titulo_en = 'En punto de espera...';
        $notificationSave->text_en = 'Tu conductor te está esperando...';
        $notificationSave->id_usuario = $user;
        $notificationSave->tipo = 4;
        $notificationSave->id_servicio = $servicio_id;
        $notificationSave->save();
        /*Guardar Notificación*/

        return Response::json([
          'respuesta' => true,
          'resultado' => $result
        ]);

      }

    }//NOTIFICACIÓN DE APP CLIENTE INICIO DE SERVICIO

    public static function Recogidoup($servicio_id, $user){ //NOTIFICACIÓN UPDATE SERVICIO DE APP CLIENTE

      $url = 'https://fcm.googleapis.com/fcm/send';
      $key = Notification::FIREBASE_KEY_CLIENT;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $usuario = DB::table('users')
      ->where('id',$user)
      ->first();

      if ($usuario->idregistrationdevice!=null and $usuario->idregistrationdevice!='') {

        $id = $usuario->idregistrationdevice;

        if($usuario->idioma==='en'){

          $title = 'En camino hacia punto de destino';
          $message = 'Tu viaje a iniciado. Esperamos que disfrutes tu viaje.';

        }else{

          $title = 'En camino hacia punto de destino';
          $message = 'Tu viaje a iniciado. Esperamos que disfrutes tu viaje.';

        }

        $fields = array (
          'registration_ids' => array (
            $id
          ),
          'notification' => array (
            "body" => $message,
            "title" => $title,
            "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
            "vibration_pattern" => $vibration_pattern
          ),
          'data' => array (
            "id" => 4,
            "servicio" => $servicio_id,
            "screen" => 'waiting',
          )
        );
        $fields = json_encode ( $fields );

        $headers = array (
          'Authorization: key=' . $key,
          'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        //curl_close ( $ch );

        /*Guardar Notificación*/
        $notificationSave = new Notifications;
        $notificationSave->fecha = date('Y-m-d H:i');
        $notificationSave->titulo = 'En camino hacia punto de destino';
        $notificationSave->text = 'Tu viaje a iniciado. Esperamos que disfrutes tu viaje.';
        $notificationSave->titulo_en = 'En camino hacia punto de destino';
        $notificationSave->text_en = 'Tu viaje a iniciado. Esperamos que disfrutes tu viaje.';
        $notificationSave->id_usuario = $user;
        $notificationSave->tipo = 4;
        $notificationSave->id_servicio = $servicio_id;
        $notificationSave->save();
        /*Guardar Notificación*/

        return Response::json([
          'respuesta' => true,
          'resultado' => $result
        ]);

      }

    }//NOTIFICACIÓN DE APP CLIENTE INICIO DE SERVICIO

    public static function ServicioFinalizado($servicio, $user){ //NOTIFICACIÓN UPDATE SERVICIO DE APP CLIENTE

      $url = 'https://fcm.googleapis.com/fcm/send';
      $key = Notification::FIREBASE_KEY_CLIENT;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $usuario = DB::table('users')
      ->where('id',$user)
      ->first();

      if ($usuario->idregistrationdevice!=null and $usuario->idregistrationdevice!='') {

        $id = $usuario->idregistrationdevice;

        if($usuario->idioma==='en'){

          $title = 'Service Finished!';
          $message = 'The Service has been finished. Please dont forget to rate the driver. Click here to go.';

        }else{

          $title = '¡Servicio Finalizado!';
          $message = 'El Servicio ha sido finalizado. Por favor, no olvide calificar al conductor. Haga clic aquí para ir a calificar.';

        }

        $fields = array (
          'registration_ids' => array (
            $id
          ),
          'notification' => array (
            "body" => $message,
            "title" => $title,
            "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
            "vibration_pattern" => $vibration_pattern
          ),
          'data' => array (
            "id" => 5,
            "servicio" => $servicio,
            "service" => $servicio,
            "screen" => 'rate'
          )
        );
        $fields = json_encode ( $fields );

        $headers = array (
          'Authorization: key=' . $key,
          'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        //curl_close ( $ch );

        /*Guardar Notificación*/
        $notificationSave = new Notifications;
        $notificationSave->fecha = date('Y-m-d H:i');
        $notificationSave->titulo = '¡Servicio Finalizado!';
        $notificationSave->text = 'El Servicio ha sido finalizado. Por favor, no olvide calificar al conductor. Haga clic aquí para ir a calificar.';
        $notificationSave->titulo_en = 'Service Finished!';
        $notificationSave->text_en = 'The Service has been finished. Please dont forget to rate the driver. Click here to go to rate.';
        $notificationSave->id_usuario = $user;
        $notificationSave->tipo = 5;
        $notificationSave->id_servicio = $servicio;
        $notificationSave->save();
        /*Guardar Notificación*/

        return Response::json([
          'respuesta' => true,
          'resultado' => $result
        ]);

      }

    }//NOTIFICACIÓN DE APP CLIENTE INICIO DE SERVICIO

    /*NOTIFICACIONES VERSIÓN FINAL*/

    /*NOTIFICACIONES WHATSAPP RECONFIRMACIÓN 15 MINS*/
    public static function ReconfirmarWhatsAppq($conductorId, $fechaServicio, $horaServicio, $recogerEn, $dejarEn, $message, $id_servicio, $phone, $contacto){//RECONFIRMADOR PARA EL PASAJERO WAA

      //$phone = '3004580108';

      $number = '57'.$phone;

      $number = intval($number);
      //$contacto = 3012030290;
      $codigo = DB::table('servicios')->where('id',$id_servicio)->pluck('notificaciones_reconfirmacion');

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);

      curl_setopt($ch, CURLOPT_POST, TRUE);

      curl_setopt($ch, CURLOPT_POSTFIELDS, "{
        \"messaging_product\": \"whatsapp\",
        \"to\": \"".$number."\",
        \"type\": \"template\",
        \"template\": {
          \"name\": \"confirmacion_quince\",
          \"language\": {
            \"code\": \"es\",
          },
          \"components\": [{
            \"type\": \"body\",
            \"parameters\": [{
              \"type\": \"text\",
              \"text\": \"".$recogerEn."\",
            },
            {
              \"type\": \"text\",
              \"text\": \"".$contacto."\",
            }]
          },
          {
            \"type\": \"button\",
            \"sub_type\": \"url\",
            \"index\": \"0\",
            \"parameters\": [{
              \"type\": \"payload\",
              \"payload\": \"".$id_servicio."\"
            }]
          },{
            \"type\": \"button\",
            \"sub_type\": \"url\",
            \"index\": \"1\",
            \"parameters\": [{
              \"type\": \"payload\",
              \"payload\": \"".$id_servicio."\"
            }]
          }]
        }
      }");

      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
      ));

      $response = curl_exec($ch);
      curl_close($ch);

    }

    /*NOTIFICACIONES WHATSAPP RECONFIRMACIÓN 30 MINS*/
    public static function ReconfirmarWhatsAppt($conductorId, $fechaServicio, $horaServicio, $recogerEn, $dejarEn, $message, $id_servicio, $phone, $contacto){//RECONFIRMADOR PARA EL PASAJERO WAA

      //$phone = '3004580108';

      $number = '57'.$phone;

      $number = intval($number);
      //$contacto = 3012030290;
      $codigo = DB::table('servicios')->where('id',$id_servicio)->pluck('notificaciones_reconfirmacion');

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);

      curl_setopt($ch, CURLOPT_POST, TRUE);

      curl_setopt($ch, CURLOPT_POSTFIELDS, "{
        \"messaging_product\": \"whatsapp\",
        \"to\": \"".$number."\",
        \"type\": \"template\",
        \"template\": {
          \"name\": \"confirmacion_treinta\",
          \"language\": {
            \"code\": \"es\",
          },
          \"components\": [{
            \"type\": \"body\",
            \"parameters\": [{
              \"type\": \"text\",
              \"text\": \"".$recogerEn."\",
            },
            {
              \"type\": \"text\",
              \"text\": \"".$contacto."\",
            }]
          },
          {
            \"type\": \"button\",
            \"sub_type\": \"url\",
            \"index\": \"0\",
            \"parameters\": [{
              \"type\": \"payload\",
              \"payload\": \"".$id_servicio."\"
            }]
          },{
            \"type\": \"button\",
            \"sub_type\": \"url\",
            \"index\": \"1\",
            \"parameters\": [{
              \"type\": \"payload\",
              \"payload\": \"".$id_servicio."\"
            }]
          }]
        }
      }");

      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
      ));

      $response = curl_exec($ch);
      curl_close($ch);

    }

    /*NOTIFICACIONES WHATSAPP RECONFIRMACIÓN*/
    public static function ReconfirmarWhatsApp($conductorId, $fechaServicio, $horaServicio, $recogerEn, $dejarEn, $message, $id_servicio, $phone, $contacto){//RECONFIRMADOR PARA EL PASAJERO WAA

      //$phone = '3004580108';

      $number = $phone;//'57'.

      $number = intval($number);
      //$contacto = 3012030290;
      $codigo = DB::table('servicios')->where('id',$id_servicio)->pluck('notificaciones_reconfirmacion');

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);

      curl_setopt($ch, CURLOPT_POST, TRUE);

      curl_setopt($ch, CURLOPT_POSTFIELDS, "{
        \"messaging_product\": \"whatsapp\",
        \"to\": \"".$number."\",
        \"type\": \"template\",
        \"template\": {
          \"name\": \"reconfirmacion\",
          \"language\": {
            \"code\": \"es\",
          },
          \"components\": [{
            \"type\": \"body\",
            \"parameters\": [{
              \"type\": \"text\",
              \"text\": \"".$recogerEn."\",
            },
            {
              \"type\": \"text\",
              \"text\": \"".$contacto."\",
            }]
          },
          {
            \"type\": \"button\",
            \"sub_type\": \"url\",
            \"index\": \"0\",
            \"parameters\": [{
              \"type\": \"payload\",
              \"payload\": \"".$id_servicio."\"
            }]
          },
          {
            \"type\": \"button\",
            \"sub_type\": \"url\",
            \"index\": \"1\",
            \"parameters\": [{
              \"type\": \"payload\",
              \"payload\": \"".$id_servicio."\"
            }]
          }]
        }
      }");

      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
      ));

      $response = curl_exec($ch);
      curl_close($ch);

    }

    /*NOTIFICACIONES WHATSAPP RECONFIRMACIÓN*/
    public static function ReconfirmarWhatsApp2h($conductorId, $fechaServicio, $horaServicio, $recogerEn, $dejarEn, $message, $id_servicio, $phone, $contacto){//RECONFIRMADOR PARA EL PASAJERO WAA

      //$phone = '3004580108';

      $number = $phone;//'57'.

      $number = intval($number);
      //$contacto = 3012030290;

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);

      curl_setopt($ch, CURLOPT_POST, TRUE);

      curl_setopt($ch, CURLOPT_POSTFIELDS, "{
        \"messaging_product\": \"whatsapp\",
        \"to\": \"".$number."\",
        \"type\": \"template\",
        \"template\": {
          \"name\": \"reconfirmacion_dos\",
          \"language\": {
            \"code\": \"es\",
          },
          \"components\": [{
            \"type\": \"body\",
            \"parameters\": [{
              \"type\": \"text\",
              \"text\": \"".$recogerEn."\",
            },
            {
              \"type\": \"text\",
              \"text\": \"".$contacto."\",
            }]
          },
          {
            \"type\": \"button\",
            \"sub_type\": \"url\",
            \"index\": \"0\",
            \"parameters\": [{
              \"type\": \"payload\",
              \"payload\": \"".$id_servicio."\"
            }]
          },{
            \"type\": \"button\",
            \"sub_type\": \"url\",
            \"index\": \"1\",
            \"parameters\": [{
              \"type\": \"payload\",
              \"payload\": \"".$id_servicio."\"
            }]
          }]
        }
      }");

      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
      ));

      $response = curl_exec($ch);
      curl_close($ch);

    }

    /*NOTIFICACIONES WHATSAPP RECONFIRMACIÓN*/
    public static function ServicioIniciadoWhatsApp($id,$phone){//RECONFIRMADOR PARA EL PASAJERO WAA

      //$phone = '3004580108';

      $servicio = DB::table('servicios')
      ->where('id',$id)
      ->first();

      $number = $phone;//'57'.

      $number = intval($number);
      if($servicio->localidad!=1){ //Barranquilla
        $contacto = 3012030290;
      }else{ //Bogotá
        $contacto = 3012633287;
      }

      $recogerEn = $servicio->recoger_en;
      $dejarEn = $servicio->dejar_en;
      $codigo = $servicio->notificaciones_reconfirmacion;

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);

      curl_setopt($ch, CURLOPT_POST, TRUE);

      curl_setopt($ch, CURLOPT_POSTFIELDS, "{
        \"messaging_product\": \"whatsapp\",
        \"to\": \"".$number."\",
        \"type\": \"template\",
        \"template\": {
          \"name\": \"iniciarservicio\",
          \"language\": {
            \"code\": \"es\",
          },
          \"components\": [{
            \"type\": \"body\",
            \"parameters\": [{
              \"type\": \"text\",
              \"text\": \"".$recogerEn."\",
            },
            {
              \"type\": \"text\",
              \"text\": \"".$dejarEn."\",
            },
            {
              \"type\": \"text\",
              \"text\": \"".$codigo."\",
            }]
          },
          {
            \"type\": \"button\",
            \"sub_type\": \"url\",
            \"index\": \"0\",
            \"parameters\": [{
              \"type\": \"payload\",
              \"payload\": \"".$id."\"
            }]
          }]
        }
      }");

      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
      ));

      $response = curl_exec($ch);
      curl_close($ch);

    }

    /*NOTIFICACIONES WHATSAPP RECOGIDO*/ //PENDIENTE DE TERMINAR
    public static function Notificarrecogido($servicio, $number, $nombreConductor, $cel){//RECONFIRMADOR PARA EL PASAJERO WAA

      $number = $number;//'57'.

      $number = intval($number);
      if($servicio->localidad!=1){ //Barranquilla
        $contacto = 3012030290;
      }else{ //Bogotá
        $contacto = 3012633287;
      }

      $recogerEn = $servicio->recoger_en;
      $dejarEn = $servicio->dejar_en;
      $codes = $servicio->notificaciones_reconfirmacion;
      //$codigo = $servicio->notificaciones_reconfirmacion;

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);

      curl_setopt($ch, CURLOPT_POST, TRUE);

      curl_setopt($ch, CURLOPT_POSTFIELDS, "{
        \"messaging_product\": \"whatsapp\",
        \"to\": \"".$number."\",
        \"type\": \"template\",
        \"template\": {
          \"name\": \"waiting\",
          \"language\": {
            \"code\": \"es\",
          },
          \"components\": [{
            \"type\": \"body\",
            \"parameters\": [{
              \"type\": \"text\",
              \"text\": \"".$nombreConductor."\",
            },
            {
              \"type\": \"text\",
              \"text\": \"".$recogerEn."\",
            },{
              \"type\": \"text\",
              \"text\": \"".$codes."\",
            },{
              \"type\": \"text\",
              \"text\": \"".$cel."\",
            }]
          },
          {
            \"type\": \"button\",
            \"sub_type\": \"url\",
            \"index\": \"0\",
            \"parameters\": [{
              \"type\": \"payload\",
              \"payload\": \"".$servicio->id."\"
            }]
          }]
        }
      }");

      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
      ));

      $response = curl_exec($ch);
      curl_close($ch);

    }

    public static function Desvincularconductor($conductor){//RECHAZAR NOVEDAD DE SERVICIO

      $countFalse = 0;
      $countTrue = 0;

      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_DRIVER;
      $vibration_pattern = Notification::VIBRATION_PATTERN;

      $conductor = Conductor::find($conductor);

      if ($conductor->user!=null) {

        $id_registration = $conductor->user->idregistrationdevice;

        if ($id_registration!=null and $id_registration!='') {

          $texto = 'Tu proveedor te ha desvinculado de su plataforma. Se cerrará tu sesión en UP DRIVER y tu usuario quedará inactivo.';

          $id = $id_registration;

          $fields = array (
            'registration_ids' => array (
              $id
            ),
            'notification' => array (
              "body" => $texto,
              "title" => '¡Cierre de Sesión!',
              "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png'
            ),
            'data' => array (
              "id" => 4,
              "screen" => 'login',
            )
          );

          $fields = json_encode ( $fields );

          $headers = array (
            'Authorization: key=' . $apikey,
            'Content-Type: application/json'
          );

          $ch = curl_init ();
          curl_setopt ( $ch, CURLOPT_URL, $url );
          curl_setopt ( $ch, CURLOPT_POST, true );
          curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
          curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
          curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

          $result = curl_exec ( $ch );
          curl_close ( $ch );

          if ($result===FALSE) {

            $countFalse++;

          }else{

            $countTrue++;

          }

        }

        $counters['countTrue'] = $countTrue;
        $counters['countFalse'] = $countFalse;

        //return $counters;

      }

    }

    public static function notificarCliente($cliente_id, $servicio_aplicacion_id){

      $countFalse = 0;
      $countTrue = 0;
      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_CLIENT;

      $user = User::find($cliente_id);

      $id_registration = $user->idregistrationdevice;

      if ($id_registration!=null and $id_registration!='') {

        $id = $id_registration;

        if($user->idioma==='en'){
          $title = 'Successful Payment!';
          $message = 'Your payment was processed successfully. We will notify you shortly when your service is scheduled.';
        }else{
          $title = 'Pago Exitoso!';
          $message = 'Tu pago fue procesado exitosamente. En breve te notificaremos la programado tu servicio.';
        }

        $fields = array (
          'registration_ids' => array (
            $id
          ),
          'notification' => array (
            "body" => $message,
            "title" => $title,
            "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
            'vibrationPattern' => [2000, 1000, 500, 500],
          ),
          'data' => array (
            "id" => 1,
            "servicio" => $servicio_aplicacion_id,
          )
        );
        $fields = json_encode ( $fields );

        $headers = array (
          'Authorization: key=' . $apikey,
          'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        curl_close ( $ch );

        //Guardar Notificación
        $notificationSave = new Notifications;
        $notificationSave->fecha = date('Y-m-d H:i');
        $notificationSave->titulo = 'Pago Exitoso!';
        $notificationSave->text = 'Tu pago fue procesado exitosamente. En breve te notificaremos la programado tu servicio.';
        $notificationSave->titulo_en = 'Successful Payment!';
        $notificationSave->text_en = 'Your payment was processed successfully. We will notify you shortly when your service is scheduled.';
        $notificationSave->id_usuario = $cliente_id;
        $notificationSave->tipo = 1;
        $notificationSave->id_servicio = $servicio_aplicacion_id;
        $notificationSave->save();
        //Guardar Notificación*/

        return $result;

      }

    }

    public static function notificarCliente2($cliente_id, $servicio_aplicacion_id){

      $countFalse = 0;
      $countTrue = 0;
      $url = 'https://fcm.googleapis.com/fcm/send';

      $apikey = Notification::FIREBASE_KEY_CLIENT;

      $user = User::find($cliente_id);

      $id_registration = $user->idregistrationdevice;

      if ($id_registration!=null and $id_registration!='') {

        $id = $id_registration;

        if($user->idioma==='en'){
          $title = 'Payment Declined!';
          $message = 'Your payment could not be processed. Click here to try to make the payment again.';
        }else{
          $title = 'Pago Declinado!';
          $message = 'Tu pago no pudo ser procesado. Presiona aquí para intentar hacer el pago nuevamente.';
        }

        $fields = array (
          'registration_ids' => array (
            $id
          ),
          'notification' => array (
            "body" => $message,
            "title" => $title,
            "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
            'vibrationPattern' => [2000, 1000, 500, 500],
          ),
          'data' => array (
            "id" => 1,
            "servicio" => $servicio_aplicacion_id,
          )
        );
        $fields = json_encode ( $fields );

        $headers = array (
          'Authorization: key=' . $apikey,
          'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        curl_close ( $ch );

        //Guardar Notificación
        $notificationSave = new Notifications;
        $notificationSave->fecha = date('Y-m-d H:i');
        $notificationSave->titulo = 'Pago Declinado!';
        $notificationSave->text = 'Tu pago no pudo ser procesado. Presiona aquí para intentar hacer el pago nuevamente.';
        $notificationSave->titulo_en = 'Payment Declined!';
        $notificationSave->text_en = 'Your payment could not be processed. Click here to try to make the payment again.';
        $notificationSave->id_usuario = $cliente_id;
        $notificationSave->tipo = 1;
        $notificationSave->id_servicio = $servicio_aplicacion_id;
        $notificationSave->save();
        //Guardar Notificación*/

        return $result;

      }

    }



}
