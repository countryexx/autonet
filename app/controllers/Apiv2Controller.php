<?php

class Apiv2Controller extends BaseController{

    public function postServicioactivo()
    {

      ##BUSCAR SERVICIOS DEL CONDUCTOR QUE NO SE HAYAN FINALIZADO
      $user_id = intval(Input::get('id_usuario'));

      $conductor = Conductor::where('usuario_id', $user_id)->first();

      $fecha = date('Y-m-d');
      $diaanterior = strtotime('-1 day', strtotime($fecha));
      $diaanterior = date('Y-m-d', $diaanterior);

      $query = Conductor::where('usuario_id',$user_id)->pluck('estado_aplicacion');
      $departamento = Conductor::where('usuario_id',$user_id)->pluck('departamento');

      $servicio = Servicio::where('conductor_id', $conductor->id)
      ->whereBetween('fecha_servicio', [$diaanterior, $fecha])
      ->where('estado_servicio_app', 1)
      ->with(['centrodecosto'])
      ->first();


      if ($servicio) {

        return Response::json([
            'response' => true,
            'servicio' => $servicio,
            'estado' => $query,
            'departamento' => $departamento
        ]);

      }else{

        return Response::json([
            'response' => false,
            'estado' => $query,
            'departamento' => $departamento
        ]);

      }

    }


    //test gps
    public function postGpsactivo()
    {

      ##BUSCAR SERVICIOS DEL CONDUCTOR QUE NO SE HAYAN FINALIZADO
      $user_id = intval(Input::get('id_usuario'));

      $conductor = Conductor::where('usuario_id', $user_id)->first();
      if($conductor->estado_aplicacion == 1){
        return Response::json([
          'response' => true,
          'servicio' => $conductor
        ]);
      }else{
        return Response::json([
          'response' => false
        ]);
      }

    }
    //test gps

    public function postRecogerpasajero(){

      $servicio = Servicio::where('id', Input::get('servicio_id'))->with(['conductor', 'centrodecosto'])->first();

      $servicio->recoger_pasajero = 1;
      $servicio->recoger_pasajero_location = json_encode([
        'latitude' => Input::get('latitude'),
        'longitude' => Input::get('longitude'),
        'timestamp' => date('Y-m-d H:i:s')
      ]);

      if ($servicio->save()) {

        if($servicio->app_user_id!=null){
            $notifications = Servicio::Recogidoup(Input::get('servicio_id'), $servicio->app_user_id);
        }

        //Notificación a los usuarios recogidos que nos dirigimos al punto de destino
        $serv = DB::table('servicios')
        ->where('id',Input::get('servicio_id'))
        ->first();

        if($serv->tipo_ruta==1) {

          $users = DB::table('qr_rutas')
          ->where('servicio_id',Input::get('servicio_id'))
          ->where('status', 1)
          ->get();

          if($users){

            foreach ($users as $user) {

              $number = '57'.$user->cel;
              $dejarEn = $serv->dejar_en;

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
                  \"name\": \"recorrido_finalizado\",
                  \"language\": {
                    \"code\": \"es\",
                  },
                  \"components\": [{
                    \"type\": \"body\",
                    \"parameters\": [{
                      \"type\": \"text\",
                      \"text\": \"".$dejarEn."\",
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

              $idregistrationdevice = DB::table('users')
              ->where('id_empleado',$user->id_usuario)
              ->pluck('idregistrationdevice');

              if($idregistrationdevice) {
                $notificationss = Servicio::haciaDestino($servicio->id, $idregistrationdevice, $servicio->dejar_en);
              }

            }

          }

        }/*else{

          $idregistrationdevice = DB::table('users')
          ->where('id_empleado',$id)
          ->pluck('idregistrationdevice');

          if($idregistrationdevice) {
            $notificationss = Servicio::bienvenidoaBordo($servicio, $idregistrationdevice);
          }

        }*/
        //Notificación a los usuarios recogidos que nos dirigimos al lugar de destino

        //Actualizar Ubicación
        $array = [
          'latitude' => Input::get('latitude'),
          'longitude' => Input::get('longitude'),
          'timestamp' => date('Y-m-d H:i:s')
        ];

        /*if ($servicio->recorrido_gps===null) {

            $update = DB::table('servicios')
            ->where('id',$servicio->id)
            ->update([
              'recorrido_gps' => json_encode([$array])
            ]);

        }*/
        //Actualizar Ubicación

        $pasajeros = explode('/', $servicio->pasajeros);

    		$nombres_pasajeros = '';

    		for ($i=0; $i < count($pasajeros); $i++) {
    			$nombre_pasajero = explode(',', $pasajeros[$i]);
    			$nombres_pasajeros .= $nombre_pasajero[0].' ';
    		}

    		$message = 'El conductor '.ucwords(strtolower($servicio->conductor->nombre_completo)).' ha recojido al pasajero(s): '.ucwords(strtolower($nombres_pasajeros)). ' del servicio de las '.$servicio->hora_servicio. ' horas de '.ucwords(strtolower($servicio->centrodecosto->razonsocial));

        Servicio::notificacionWeb($message);

        return Response::json([
          'response' => true,
          'servicio' => $servicio
        ]);

      }

    }

    public function postRecogerpasajerov2(){

      $servicio = Servicio::where('id', Input::get('servicio_id'))->with(['conductor', 'centrodecosto'])->first();

      $servicio->recoger_pasajero = 1;
      $servicio->recoger_pasajero_location = json_encode([
        'latitude' => Input::get('latitude'),
        'longitude' => Input::get('longitude'),
        'timestamp' => date('Y-m-d H:i:s')
      ]);

      if ($servicio->save()) {

        if($servicio->app_user_id!=null){
            $notifications = Servicio::Recogidoup(Input::get('servicio_id'), $servicio->app_user_id);
        }

        //Notificación a los usuarios recogidos que nos dirigimos al punto de destino
        $serv = DB::table('servicios')
        ->where('id',Input::get('servicio_id'))
        ->first();

        if($serv->tipo_ruta==1) {

          $users = DB::table('qr_rutas')
          ->where('servicio_id',Input::get('servicio_id'))
          ->where('status', 1)
          ->get();

          if($users){

            foreach ($users as $user) {

              $number = '57'.$user->cel;
              $dejarEn = $serv->dejar_en;

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
                  \"name\": \"recorrido_finalizado\",
                  \"language\": {
                    \"code\": \"es\",
                  },
                  \"components\": [{
                    \"type\": \"body\",
                    \"parameters\": [{
                      \"type\": \"text\",
                      \"text\": \"".$dejarEn."\",
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

          }

        }
        //Notificación a los usuarios recogidos que nos dirigimos al lugar de destino

        //Actualizar Ubicación
        $array = [
          'latitude' => Input::get('latitude'),
          'longitude' => Input::get('longitude'),
          'timestamp' => date('Y-m-d H:i:s')
        ];

        /*if ($servicio->recorrido_gps===null) {

            $update = DB::table('servicios')
            ->where('id',$servicio->id)
            ->update([
              'recorrido_gps' => json_encode([$array])
            ]);

        }*/
        //Actualizar Ubicación

        $pasajeros = explode('/', $servicio->pasajeros);

        $nombres_pasajeros = '';

        for ($i=0; $i < count($pasajeros); $i++) {
          $nombre_pasajero = explode(',', $pasajeros[$i]);
          $nombres_pasajeros .= $nombre_pasajero[0].' ';
        }

        $message = 'El conductor '.ucwords(strtolower($servicio->conductor->nombre_completo)).' ha recojido al pasajero(s): '.ucwords(strtolower($nombres_pasajeros)). ' del servicio de las '.$servicio->hora_servicio. ' horas de '.ucwords(strtolower($servicio->centrodecosto->razonsocial));

        Servicio::notificacionWeb($message);

        return Response::json([
          'response' => true,
          'servicio' => $servicio
        ]);

      }

    }

    public function postFinalizarviaje()
    {

      $id = Input::get('id_servicio');
      $servicio = Servicio::find($id);
      $servicio->estado_servicio_app = 2;
      $servicio->hora_finalizado = date('Y-m-d H:i:s');
      $servicio->calificacion_app_conductor_calidad = Input::get('calificacionCalidad');

      if ($servicio->save()) {

        if($servicio->app_user_id!=null){
          $finalizarServicio = Servicio::ServicioFinalizado($id, $servicio->app_user_id);
        }

        return Response::json([
          'respuesta'=>true
        ]);

      }

    }

    //Nuevo servicio - recoger pasajero con código
    public function postRecogerpasajerov2original(){

      $codigo = Input::get('codigo');

      $tipo_servicio = DB::table('servicios')
      ->select('ruta')
      ->where('id',Input::get('servicio_id'))
      ->first();

      if($tipo_servicio->ruta==1) { //Servicio de ruta

        $servicio = Servicio::where('id', Input::get('servicio_id'))->with(['conductor', 'centrodecosto'])->first();

        $servicio->recoger_pasajero = 1;
        $servicio->recoger_pasajero_location = json_encode([
          'latitude' => Input::get('latitude'),
          'longitude' => Input::get('longitude'),
          'timestamp' => date('Y-m-d H:i:s')
        ]);

        if ($servicio->save()) {

          //Notificación a los usuarios recogidos que nos dirigimos al punto de destino
          $serv = DB::table('servicios')
          ->select('tipo_ruta', 'dejar_en')
          ->where('id',Input::get('servicio_id'))
          ->first();

          if($serv->tipo_ruta==1) {

            $users = DB::table('qr_rutas')
            ->where('servicio_id',Input::get('servicio_id'))
            ->where('status', 1)
            ->get();

            if($users){

              foreach ($users as $user) {

                $number = '57'.$user->cel;
                $dejarEn = $serv->dejar_en;

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
                    \"name\": \"recorrido_finalizado\",
                    \"language\": {
                      \"code\": \"es\",
                    },
                    \"components\": [{
                      \"type\": \"body\",
                      \"parameters\": [{
                        \"type\": \"text\",
                        \"text\": \"".$dejarEn."\",
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

            }

          }
          //Notificación a los usuarios recogidos que nos dirigimos al lugar de destino

          //Actualizar Ubicación
          $array = [
            'latitude' => Input::get('latitude'),
            'longitude' => Input::get('longitude'),
            'timestamp' => date('Y-m-d H:i:s')
          ];

          $pasajeros = explode('/', $servicio->pasajeros);

          $nombres_pasajeros = '';

          for ($i=0; $i < count($pasajeros); $i++) {
            $nombre_pasajero = explode(',', $pasajeros[$i]);
            $nombres_pasajeros .= $nombre_pasajero[0].' ';
          }

          $message = 'El conductor '.ucwords(strtolower($servicio->conductor->nombre_completo)).' ha recojido al pasajero(s): '.ucwords(strtolower($nombres_pasajeros)). ' del servicio de las '.$servicio->hora_servicio. ' horas de '.ucwords(strtolower($servicio->centrodecosto->razonsocial));

          Servicio::notificacionWeb($message);

          return Response::json([
            'response' => true,
            'servicio' => $servicio
          ]);

        }

      }else{ //servicio ejecutivo

        $know = DB::table('servicios')
        ->select('id')
        ->where('id',Input::get('servicio_id'))
        ->where('notificaciones_reconfirmacion',$codigo)
        ->first();

        if($know!=null) {

          $servicio = Servicio::where('id', Input::get('servicio_id'))->with(['conductor', 'centrodecosto'])->first();

          $servicio->recoger_pasajero = 1;
          $servicio->recoger_pasajero_location = json_encode([
            'latitude' => Input::get('latitude'),
            'longitude' => Input::get('longitude'),
            'timestamp' => date('Y-m-d H:i:s')
          ]);

          if ($servicio->save()) {

            if($servicio->app_user_id!=null){
                $notifications = Servicio::Recogidoup(Input::get('servicio_id'), $servicio->app_user_id);
            }

            //Actualizar Ubicación
            $array = [
              'latitude' => Input::get('latitude'),
              'longitude' => Input::get('longitude'),
              'timestamp' => date('Y-m-d H:i:s')
            ];

            $pasajeros = explode('/', $servicio->pasajeros);

            $nombres_pasajeros = '';

            for ($i=0; $i < count($pasajeros); $i++) {
              $nombre_pasajero = explode(',', $pasajeros[$i]);
              $nombres_pasajeros .= $nombre_pasajero[0].' ';
            }

            $message = 'El conductor '.ucwords(strtolower($servicio->conductor->nombre_completo)).' ha recojido al pasajero(s): '.ucwords(strtolower($nombres_pasajeros)). ' del servicio de las '.$servicio->hora_servicio. ' horas de '.ucwords(strtolower($servicio->centrodecosto->razonsocial));

            Servicio::notificacionWeb($message);

            return Response::json([
              'response' => true,
              'servicio' => $servicio
            ]);

          }

        }else{

          $servicio = Servicio::where('id', Input::get('servicio_id'))->with(['conductor', 'centrodecosto'])->first();

          return Response::json([
            'response' => true,
            'servicio' => $servicio
          ]);

        }
      }

    }
    //Nuevo servicio - recoger pasajero con código

    public function postFinalizarservicio2()
    {

      $servicio_id = Input::get('servicio_id');
      $ruta = Input::get('ruta');

      $servicio = Servicio::find($servicio_id);
      $servicio->estado_servicio_app = 2;
      $servicio->hora_finalizado = date('Y-m-d H:i:s');

      if ($servicio->save()) {

        /*$find = Cservicio::where('id_servicio',$servicio_id)->first();
        $find->s_finalizado = date('H:i');
        $find->save();
        $dat = $find->s_finalizado;
        $horaInicio = new DateTime('22:12');
        $horaTermino = new DateTime($dat);

        $interval = $horaInicio->diff($horaTermino);
        $intervalo = $interval->format('%H horas %i minutos %s seconds');*/

        return Response::json([
          'response' => true,
          //'time' => $intervalo,
          //'km' => $find->kilometros,
        ]);

      }else {

        return Response::json([
          'response' => false
        ]);

      }

    }

    public function postFinalizarservicio3()
    {

      $servicio_id = Input::get('servicio_id');
      $ruta = Input::get('ruta');

      $servicio = Servicio::find($servicio_id);
      $servicio->estado_servicio_app = 2;
      $servicio->hora_finalizado = date('Y-m-d H:i:s');

      if ($servicio->save()) {

        /*$find = Cservicio::where('id_servicio',$servicio_id)->first();
        $find->s_finalizado = date('H:i');
        $find->save();
        $dat = $find->s_finalizado;
        $horaInicio = new DateTime('22:12');
        $horaTermino = new DateTime($dat);

        $interval = $horaInicio->diff($horaTermino);
        $intervalo = $interval->format('%H horas %i minutos %s seconds');*/

        $url = 'https://fcm.googleapis.com/fcm/send';
        $key = Notification::FIREBASE_KEY_CLIENT;
        $vibration_pattern = Notification::VIBRATION_PATTERN;

        $users = DB::table('qr_rutas')
        ->where('servicio_id',$servicio->id)
        ->get();

        if($users){

          foreach ($users as $user) {

            $usuario = DB::table('users')
            ->where('email',$user->id_usuario)
            ->first();

            if($usuario!=null){

              if ($usuario->idregistrationdevice!=null and $usuario->idregistrationdevice!='') {

                $id = $usuario->idregistrationdevice;

                if($usuario->idioma==='en'){

                  $title = 'Service Finished!';
                  $message = 'The Service has been finished. Please dont forget to rate the driver. Click here to go.';

                }else{

                  $title = 'Ruta Finalizada!';
                  $message = 'Te invitamos a calificar la experiencia en nuestro servicio. Click aquí para ir a calificar.';

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
                    "servicio" => $servicio_id,
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

                return Response::json([
                  'response' => true,
                ]);

              }

            }

          }

        }

        //$usuarios = DB::table('users')
        //->where('id',$user)
        //->first();

        /*if ($usuario->idregistrationdevice!=null and $usuario->idregistrationdevice!='') {

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

          return Response::json([
            'respuesta' => true,
          ]);

        }*/

        return Response::json([
          'response' => false,
          'users' => $users
          //'time' => $intervalo,
          //'km' => $find->kilometros,
        ]);

      }else {

        return Response::json([
          'response' => false,
          'users' => $users
        ]);

      }

    }

    public function postFinalizarservicio()
    {

      $servicio_id = Input::get('servicio_id');
      $ruta = Input::get('ruta');

      $servicio = Servicio::find($servicio_id);
      $servicio->estado_servicio_app = 2;
      $servicio->hora_finalizado = date('Y-m-d H:i:s');

      if ($servicio->save()) {

        /*$find = Cservicio::where('id_servicio',$servicio_id)->first();
        $find->s_finalizado = date('H:i');
        $find->save();
        $dat = $find->s_finalizado;
        $horaInicio = new DateTime('22:12');
        $horaTermino = new DateTime($dat);

        $interval = $horaInicio->diff($horaTermino);
        $intervalo = $interval->format('%H horas %i minutos %s seconds');*/

        return Response::json([
          'response' => true,
          //'time' => $intervalo,
          //'km' => $find->kilometros,
        ]);

      }else {

        return Response::json([
          'response' => false
        ]);

      }

    }

    public function postBuscarservicios()
    {

      $id_usuario = Input::get('id_usuario');
      $fecha = explode(',', Input::get('fecha'));

      $conductor_id = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->pluck('id');

      $servicios = Servicio::selectRaw('servicios.*, centrosdecosto.razonsocial as razonsocial,  subcentrosdecosto.nombresubcentro as subcentro, nombre_ruta.nombre as nombreruta, c_servicios.valor_total, c_servicios.valor_proveedor, facturacion.unitario_pagado')
      ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
      ->leftJoin('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
      ->leftJoin('nombre_ruta', 'servicios.ruta_nombre_id', '=', 'nombre_ruta.id')
      ->leftjoin('c_servicios','c_servicios.id_servicio', '=', 'servicios.id')
      ->leftjoin('facturacion','facturacion.servicio_id', '=', 'servicios.id')
      ->where('servicios.conductor_id', $conductor_id)
      ->whereIn('servicios.fecha_servicio', $fecha)
      ->whereNull('servicios.pendiente_autori_eliminacion')
      ->where('estado_servicio_app', 2)
      ->orderBy('servicios.fecha_servicio', 'asc')
      ->orderBy('servicios.hora_servicio', 'asc')
      ->get();

      if (count($servicios)) {

        return Response::json([
          'respuesta' => true,
          'servicios' => $servicios
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postBuscarserviciosmes()
    {

      $id_usuario = Input::get('id_usuario');

      $ano = date('Y');
      $mes = explode(',', Input::get('mes'));

      $fechaInicial = $mes[0].'-01';
      $fechaFinal = $mes[0].'-31';

      //$fechaInicial = new DateTime($fechaInicial);

      //$fechaFinal = new DateTime($fechaFinal);

      $conductor_id = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->pluck('id');

      $servicios = Servicio::selectRaw('servicios.*, centrosdecosto.razonsocial as razonsocial,  subcentrosdecosto.nombresubcentro as subcentro, nombre_ruta.nombre as nombreruta, c_servicios.valor_total, c_servicios.valor_proveedor, facturacion.unitario_pagado')
      ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
      ->leftJoin('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
      ->leftJoin('nombre_ruta', 'servicios.ruta_nombre_id', '=', 'nombre_ruta.id')
      ->leftjoin('c_servicios','c_servicios.id_servicio', '=', 'servicios.id')
      ->leftjoin('facturacion','facturacion.servicio_id', '=', 'servicios.id')
      ->where('servicios.conductor_id', $conductor_id)
      ->whereBetween('servicios.fecha_servicio', [$fechaInicial,$fechaFinal])
      ->whereNull('servicios.pendiente_autori_eliminacion')
      ->where('estado_servicio_app', 2)
      ->orderBy('servicios.fecha_servicio', 'asc')
      ->orderBy('servicios.hora_servicio', 'asc')
      ->get();

      if (count($servicios)) {

        return Response::json([
          'respuesta' => true,
          'servicios' => $servicios,
          'an' => $ano
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'ano' => $ano,
          'mes' => $mes[0],
          'fi' => $fechaInicial,
          'ff' => $fechaFinal
        ]);

      }

    }

}
