<?php
class Pago extends Eloquent {

  protected $table = 'pagos';

  public static function NotificarPago($mensaje, $conductor_id, $nombre, $mes, $valor){//PROGRAMACIÓN DE SERVICIO Y NOTIFICAR EN LISTA DE SERVICIOS

    $url = 'https://fcm.googleapis.com/fcm/send';

    $apikey = Notification::FIREBASE_KEY_DRIVER;

    $conductor = Conductor::find($conductor_id);
    $vibration_pattern = Notification::VIBRATION_PATTERN;

    if ($conductor->user!=null) {

      if ($conductor->user->idregistrationdevice!=null and $conductor->user->idregistrationdevice!='') {

        $id = $conductor->user->idregistrationdevice;

        $mensaje = 'AOTOUR SAS ha generado un pago a nombre del proveedor '.$nombre.'';

        $fields = array (
          'registration_ids' => array (
            $id
          ),
          'notification' => array (
            "body" => $mensaje,
            "title" => '¡Pago Realizado!',
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

}
