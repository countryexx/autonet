<?php

class Notification extends Eloquent{

  const FIREBASE_KEY_DRIVER = "AAAABsrVRW8:APA91bHeyqFdFTYzPuSQe6SXB-FO1bLqJ_cQcNTWim-oBShNazh00NagwyKA0ouZC94lre12goZcjSzyqwpDJsGPiVa4voh7xm3-DOkl11u2YF9f3PnLXFRdmb59vXYj6cHeafkuqeA-";
  const FIREBASE_KEY_CLIENT = "AAAAXZ-yM9s:APA91bGhnV8patuAqhFUFD0VUxmfNS65-8rkck3_Dngwb8LMsK1QomoZQsXHF5-Z4lXuPMMogTqpPD5KDqZzSL5tux6GcN5Rvugv0yGVtLHORIZxl_Pw4mB2JbZHXufQvkefloY1-IeS";
  const VIBRATION_PATTERN = [2000, 2000, 500, 1000];
  const LED_COLOR = [0, 0, 255, 0];

  //Pusher
  const APP_ID_PUSHER = "578229";
  const KEY_PUSHER = "a8962410987941f477a1";
  const SECRET_PUSHER = "6a73b30cfd22bc7ac574";

  public static function NotificacionesConductores($message, $conductores_id){

    $apikey = Notification::FIREBASE_KEY_DRIVER;

    $users_id = Conductor::whereIn('id', $conductores_id)->lists('usuario_id');

    $users = User::whereIn('id', $users_id)->get();

    if (count($users)) {

      foreach ($users as $user) {

        if ($user->idregistrationdevice!=null and $user->idregistrationdevice!='') {

          $vibration_pattern = Notification::VIBRATION_PATTERN;

          $data = [
            'body' => $message,
            'message' => $message,
            'title' => 'Aotour Mobile',
            'notId' => rand(1000000, 9999999),
            'vibrationPattern' => $vibration_pattern,
            'soundname' => 'default',
            'ledColor' => NOTIFICATION::LED_COLOR,
            'sound' => 'default',
            'visibility' => 1,
          ];

          $fields = [
            'registration_ids' => [$user->idregistrationdevice],
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

    }

  }

}

?>
