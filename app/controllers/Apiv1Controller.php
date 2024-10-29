<?php
/**
 * Clase para
 */
class Apiv1Controller extends BaseController{

    public function postGuardaridregistration()
    {

      $user_id = Input::get('id_usuario');
      $registration_id = Input::get('registrationid');
      $device = Input::get('device');
      $idioma = Input::get('idioma');

      $registration = DB::table('users')
      ->where('id', $user_id)
      ->update([
        'idregistrationdevice' => $registration_id,
        'device' => $device,
        'idioma' => $idioma
      ]);

      if ($registration) {

        return Response::json([
          'respuesta' => true,
          'registrationid' => $registration_id,
          'version' => 1
        ]);

      }else {

        return Response::json([
          'respuesta' => false,
          'version' => 1
        ]);

      }

    }

}
