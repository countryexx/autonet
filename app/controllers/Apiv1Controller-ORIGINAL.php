<?php
/**
 * Clase para
 */
class Apiv1Controller extends BaseController{

    public function getObtenerconductor()
    {

        $tipo_usuario = intval(Input::get('tipo_usuario'));
        $usuario = null;
        $id_usuario = Input::get('id_usuario');

        if ($tipo_usuario===1){
            $usuario = 'Corporativo';
        }else if($tipo_usuario===2){
            $usuario = 'Conductor';
        }else if($tipo_usuario===3){
            $usuario = 'Personal';
        }

        $conductor = DB::table('conductores')
            ->where('usuario_id',$id_usuario)
            ->first();

        if ($conductor){
            return Response::json([
                'respuesta' => true,
                'conductor' => $conductor,
                'usuario' => $usuario
            ]);
        }
    }



    //INICIO GPS DISPONIBILIDAD

    public function postVehiculo(){

      $id = Input::get('id_conductor');
      $estado = Input::get('estado');
      $query = DB::table('conductores')->where('usuario_id',$id)->pluck('id');
      $conductor = Conductor::find($query);

      $latitude = substr(Input::get('latitude'), 0, 10);
      $longitude = substr(Input::get('longitude'), 0, 10);

      //Objeto array json
      $objArray = null;

      //Array a insertar en json
      $array = [
        'latitude' => $latitude,
        'longitude' => $longitude,
        'timestamp' => date('Y-m-d H:i:s')
      ];

      //CONSULTA SI EL CONDUCTOR TIENE UN SERVICIO ACTIVO
      $servicio_ahora = DB::table('servicios')->where('conductor_id',$query)->where('estado_servicio_app',1)->pluck('estado_servicio_app');
      if($servicio_ahora!=1){
          //COLOCAR QUE CADA VEZ QUE INICIE GPS, SE BORRE EL QUE YA ESTÁ GUARDADO!
          if($estado == 1){
            $conductor->estado_aplicacion = 1;
            if($conductor->gps == null){
              $conductor->gps = json_encode([$array]);
            }else{
              $objArray = json_decode($conductor->gps);
              array_push($objArray, $array);
              $conductor->gps = json_encode($objArray);
            }
          }else{
            $conductor->estado_aplicacion = 0;
            //BORRAR GPS VIEJO
          }
      }


      if($conductor->save()){
        return Response::json([
          'response' => true,
          'valor' => $servicio_ahora
        ]);
      }else{
        return Response::json([
          'response' => false,
          'valor' => $servicio_ahora
        ]);
      }

    }

    public function postReporteslimpieza(){

      $id_usuario = Input::get('usuario');
      $query = Conductor::where('usuario_id', $id_usuario)->pluck('id');
      $conductor = Conductor::find($query);
      $proveedor = Proveedor::find($conductor->proveedores_id);

      $value1 = Input::get('limpieza');
      $value2 = Input::get('elementos');

      $formulario = new Formulario;
      $formulario->nombre_proveedor = $proveedor->razonsocial;
      $formulario->nombre_conductor = $conductor->nombre_completo;
      $formulario->telefono = $conductor->celular;
      $formulario->ciudad = $conductor->ciudad;
      $formulario->fecha = date('Y-m-d');
      $formulario->limpieza = $value1;
      $formulario->elementos_limpieza = $value2;
      $formulario->conductor_id = $conductor->id;

      if($formulario->save()){

        return Response::json([
          'mensaje'=>true,
          'name'=>$conductor->nombre_completo,
          'ciudadpdf'=>$conductor->ciudad,
          'nombrep'=>$proveedor->razonsocial,
          'fechapdf'=> date('Y-m-d'),
        ]);
      }
    }

    public function postGestiondocumental(){

      $imagen_ip = Input::get('nombre_imagen');
      $fecha = Input::get('fecha');
      $hora = Input::get('hora');
      $cliente = Input::get('cliente');
      $tipo_ruta = Input::get('tipo_ruta');
      $id_image = Input::get('image');
      $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$id_image));
      $nombre_documento = Input::get('nombre_documento');
      $placa = Input::get('placa');
      $novedadesruta = Input::get('novedades');
      $id_usuario = intval(Input::get('id_usuario'));
      $id_conductor = DB::table('conductores')->where('usuario_id',$id_usuario)->pluck('id');


      $documento = new GestionDocumental();
      $documento->id_image = $imagen_ip;
      $documento->nombre_documento = $nombre_documento;
      $documento->placa = $placa;
      $documento->id_conductor = $id_conductor;
      $documento->fecha = $fecha;
      $documento->hora = $hora;
      $documento->cliente = $cliente;
      $documento->tipo_ruta = $tipo_ruta;
      $documento->novedadesruta = $novedadesruta;
      $documento->estado = 0;

      if($documento->save()){

        $filepath = "biblioteca_imagenes/gestion_documental/".$documento->id.'.jpeg';
        file_put_contents($filepath,$data);

        return Response::json([
          'respuesta'=>true
        ]);
        $img=Image::make($filepath);
      }else{
        return response::json([
          'respuesta' =>false
        ]);
      }
    }

    //FIN GPS DISPONIBILIDAD
    public function postIniciogps(){

      $id_usuario = intval(Input::get('id_usuario'));
      $id_conductor = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->pluck('id');

      $conductor = Conductor::find($id_conductor);
      $conductor->estado_aplicacion = 1;

      if($conductor->save()){
        return Response::json([
          'response' => true,
          'conductor' => $conductor
        ]);
      }else{
        return Response::json([
          'response' => false
        ]);
      }

    }
    //

    public function postIniciarservicio()
    {

      //ID del servicio
      $id = Input::get('id_servicio');

      //Coordenadas enviadas por el conductor
      $latitude = substr(Input::get('latitude'), 0, 10);
      $longitude = substr(Input::get('longitude'), 0, 10);

      //Objeto array json
      $objArray = null;

      //Array a insertar en json
      $array = [
        'latitude' => $latitude,
        'longitude' => $longitude,
        'timestamp' => date('Y-m-d H:i:s')
      ];

      //Busqueda del servicio a guardar coordenadas
      $servicio = Servicio::find($id);

      if ($servicio->recorrido_gps===null) {

          if ($servicio->app_user_id!=null) {

            $message = 'El servicio para recoger en: '.$servicio->recoger_en.', y dejar en: '.$servicio->dejar_en.' de las '.$servicio->hora_servicio.' horas esta disponible para seguimiento.';

            $number_random = rand(1000000, 9999999);

            $data = [
              'message' => $message,
              'body' => $message,
              'title' => 'Aotour Mobile',
              'notId' => $number_random,
              'vibrationPattern' => [2000, 1000, 500, 500],
              'soundname' => 'default',
              'subtitle' => 'Servicio programado'
            ];

            //Notificacion de que el servicio esta disponible para poder realizar el seguimiento desde el cliente
            Servicio::notificacionData($servicio->app_user_id, $data);

          }

          $servicio->recorrido_gps = json_encode([$array]);

      }else{

        $objArray = json_decode($servicio->recorrido_gps);
        array_push($objArray, $array);
        $servicio->recorrido_gps = json_encode($objArray);

      }

      if ($servicio->save()) {

          if ($servicio->tracking_cliente==1) {

            if ($servicio->app_user_id!=null) {

              $user_id = $servicio->app_user_id;

            	$channel = 'aotour_mobile_client_user_'.$user_id;
            	$name = 'servicio_activo';

              $data = json_encode([
                'ultima_ubicacion' => [
                  'latitude' => $latitude,
                  'longitude' => $longitude
                ],
                'servicio_id' => $id,
                'estado_servicio_app' => $servicio->estado_servicio_app
              ]);

          		Servicio::enviarNotificacionPusher($channel, $name, $data);

            }

          }

          return Response::json([
            'respuesta'=>true,
            'cc'=>$servicio->centrodecosto_id
          ]);

      }

    }

    public function postIniciarservicio2()
    {

      //ID del servicio
      $id = Input::get('id_servicio');

      //Coordenadas enviadas por el conductor
      $latitude = substr(Input::get('latitude'), 0, 10);
      $longitude = substr(Input::get('longitude'), 0, 10);

      //Objeto array json
      $objArray = null;

      //Array a insertar en json
      $array = [
        'latitude' => $latitude,
        'longitude' => $longitude,
        'timestamp' => date('Y-m-d H:i:s')
      ];

      //Busqueda del servicio a guardar coordenadas
      $servicio = Servicio::find($id);

      if ($servicio->recorrido_gps===null) {

          if ($servicio->app_user_id!=null) {

            $message = 'El servicio para recoger en: '.$servicio->recoger_en.', y dejar en: '.$servicio->dejar_en.' de las '.$servicio->hora_servicio.' horas esta disponible para seguimiento.';

            $number_random = rand(1000000, 9999999);

            $data = [
              'message' => $message,
              'body' => $message,
              'title' => 'Aotour Mobile',
              'notId' => $number_random,
              'vibrationPattern' => [2000, 1000, 500, 500],
              'soundname' => 'default',
              'subtitle' => 'Servicio programado'
            ];

            //Notificacion de que el servicio esta disponible para poder realizar el seguimiento desde el cliente
            Servicio::notificacionData($servicio->app_user_id, $data);

          }

          $servicio->recorrido_gps = json_encode([$array]);
          $servicio->notificaciones_reconfirmacion_cliente = 0;

      }else{

        $objArray = json_decode($servicio->recorrido_gps);

        $datos = null;

        if($servicio->recoger_pasajero!=null){

          $prueba = Cservicio::where('id_servicio',$servicio->id)->first();

          $cont = count($objArray)-1;

          //TEST
          function distance($lat1, $lon1, $lat2, $lon2, $unit) {

            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
              return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
              } else {
                  return $miles;
                }
          }

          $lat = $objArray[$cont]->latitude;
          $lon = $objArray[$cont]->longitude;

          $punto1 = [$lat, $lon];
          $punto2 = [$latitude, $longitude];

          $dis = distance($punto1[0], $punto1[1], $punto2[0], $punto2[1], "K");
          //$dis = round($dis, 1);

          $datos = $prueba->kilometros+$dis;
          $prueba->kilometros = $datos;
          $prueba->save();
        }

        array_push($objArray, $array);
        $servicio->recorrido_gps = json_encode($objArray);

      }

      if ($servicio->save()) {

          if ($servicio->tracking_cliente==1) {

            if ($servicio->app_user_id!=null) {

              $user_id = $servicio->app_user_id;

              $channel = 'aotour_mobile_client_user_'.$user_id;
              $name = 'servicio_activo';

              $data = json_encode([
                'ultima_ubicacion' => [
                  'latitude' => $latitude,
                  'longitude' => $longitude
                ],
                'servicio_id' => $id,
                'estado_servicio_app' => $servicio->estado_servicio_app
              ]);

              Servicio::enviarNotificacionPusher($channel, $name, $data);

            }

          }

          return Response::json([
            'respuesta'=>true,
            'cc'=>$servicio->centrodecosto_id,
            //'punto1' => $punto1,
            //'punto2' => $punto2,
            //'distancia' => $dis,
            'id' => $id,
            'km' => $datos
          ]);

      }

    }

    public function postFinalizarservicio()
    {

      $id = Input::get('id_servicio');
      $servicio = Servicio::find($id);
      $servicio->estado_servicio_app = 2;
      $servicio->hora_finalizado = date('Y-m-d H:i:s');
      $servicio->calificacion_app_conductor_calidad = Input::get('calificacionCalidad');
      $servicio->calificacion_app_conductor_actitud = Input::get('calificacionActitud');

      if ($servicio->save()) {

          $baseFromJavascript = Input::get('imagen');

        // Remover la parte de la cadena de texto que no necesitamos (data:image/png;base64,)
        // y usar base64_decode para obtener la información binaria de la imagen
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseFromJavascript));

        //Ubicacion para el archivo
        $filepath = "biblioteca_imagenes/firmas_servicios/".'firma_'.$servicio->id.'.png';

        //Guardar imagen
        file_put_contents($filepath,$data);

        $img = Image::make($filepath);

        //Recortar imagen
        //$img->trim()->crop(500, 500, 0)->rotate(-90)->trim('black', ['left'])->save($filepath);
        if($servicio->app_user_id!=null){
          $finalizarServicio = Servicio::ServicioFinalizado($id, $servicio->app_user_id);
        }else if($servicio->ruta==1){

          $url = 'https://fcm.googleapis.com/fcm/send';
          $key = Notification::FIREBASE_KEY_CLIENT;
          $vibration_pattern = Notification::VIBRATION_PATTERN;

          $users = DB::table('qr_rutas')
          ->where('servicio_id',$servicio->id)
          ->get();

          $usuarios = DB::table('users')
          ->where('id',$user)
          ->first();

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

        }
        return Response::json([
          'respuesta'=>true
        ]);

      }

    }

    public function postFinalizarservicio2()
    {

      $id = Input::get('id_servicio');
      $servicio = Servicio::find($id);
      $servicio->estado_servicio_app = 2;
      $servicio->hora_finalizado = date('Y-m-d H:i:s');
      $servicio->calificacion_app_conductor_calidad = Input::get('calificacionCalidad');
      $servicio->calificacion_app_conductor_actitud = Input::get('calificacionActitud');

      $test = json_decode($servicio->recoger_pasajero_location);
      $inicio_km = $test->timestamp;
      $inicio_km = explode(' ', $inicio_km);
      $ini = $inicio_km[1];
      if ($servicio->save()) {

          $baseFromJavascript = Input::get('imagen');

        // Remover la parte de la cadena de texto que no necesitamos (data:image/png;base64,)
        // y usar base64_decode para obtener la información binaria de la imagen
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseFromJavascript));

        //Ubicacion para el archivo
        $filepath = "biblioteca_imagenes/firmas_servicios/".'firma_'.$servicio->id.'.png';

        //Guardar imagen
        file_put_contents($filepath,$data);

        $img = Image::make($filepath);

        //Recortar imagen
        //$img->trim()->crop(500, 500, 0)->rotate(-90)->trim('black', ['left'])->save($filepath);
        //$ini = '15:00:00';
        $find = Cservicio::where('id_servicio',$id)->first();
        $find->s_finalizado = date('Y-m-d H:i:s');
        $find->save();
        //$dat = $find->s_finalizado;
        //$dat = $find->s_finaliazdo[1]; //Hora de finalización
        $fin = explode(' ', $find->s_finalizado); //Fecha de finalización
        $dat = $fin[1];
        //$dat = '21:25:00'; //hora de finalización del servicio (PARA HACER PRUEBAS)
        $horaInicio = new DateTime($ini); //HORA DE INICIO DE KILOMETRAJE (PRUEBAS)
        $horaTermino = new DateTime($fin[1]);
        //$horaTermino = '19:00';

        $interval = $horaInicio->diff($horaTermino);
        $intervalo = $interval->format('%H horas %i minutos %s segundos');

        $horas = $interval->format('%H');
        $minutos = $interval->format('%i');
        $segundos = $interval->format('%s');
        $km = $find->kilometros;

        $extra = null;
        $extra2 = null;
        $extra3 = null;

        //INICIO CONTROLES HORA PICO 06:00 - 08:00
        if('06:00:00'>=$ini and '06:00:00'<=$dat){
          if($dat>='08:00:00' and $ini<='06:00:00'){
            $extra = 200*60;
          }else if($dat<'08:00:00' and $ini<='06:00:00'){
            $start = new DateTime('06:00');
            $end = new DateTime($dat);

            $inter = $start->diff($end);
            $m = $inter->format('%i');

            $extra = 200*$m;
          }else if($dat<'08:00:00' and $ini>'06:00:00'){
            $start = new DateTime($ini);
            $end = new DateTime($dat);

            $inter = $start->diff($end);
            $m = $inter->format('%i');

            $extra = 200*$m;
          }else if($dat>'08:00:00' and $ini>'06:00:00'){
            $start = new DateTime($ini);
            $end = new DateTime('08:00:00');

            $inter = $start->diff($end);
            $m = $inter->format('%i');

            $extra = 200*$m;
          }
          $msj = 'Parte del servicio ejecutado en hora pico';
        }else{
          $msj = 'Servicio no ejecutado en hora pico';
          $extra = 0;
        }
        //FIN CONTROLES HORA PICO 06:00 - 08:00

        //INICIO CONTROLES HORA PICO 12:00 - 14:00
        if('14:00:00'>=$ini and '12:00:00'<=$dat){
          if($dat>='14:00:00' and $ini<='12:00:00'){
            $extra2 = 200*60;
          }else if($dat<'14:00:00' and $ini<='12:00:00'){
            $start = new DateTime('12:00');
            $end = new DateTime($dat);

            $inter = $start->diff($end);
            $m = $inter->format('%i');

            $extra2 = 200*$m;
          }else if($dat<'14:00:00' and $ini>'12:00:00'){
            $start = new DateTime($ini);
            $end = new DateTime($dat);

            $inter = $start->diff($end);
            $m = $inter->format('%i');

            $extra2 = 200*$m;
          }else if($dat>'14:00:00' and $ini>'12:00:00'){
            $start = new DateTime($ini);
            $end = new DateTime('14:00:00');

            $inter = $start->diff($end);
            $m = $inter->format('%i');

            $extra2 = 200*$m;
          }
          $msj = 'Parte del servicio ejecutado en hora pico';
        }else{
          $msj = 'Servicio no ejecutado en hora pico';
          $extra2 = 0;
        }
        //FIN CONTROLES HORA PICO 12:00 - 14:00

        //INICIO CONTROLES HORA PICO 17:00 - 19:00

          if($dat>='19:00' and $ini<='17:00:00'){
            $extra3 = 200*120;
          }else if($dat<'19:00' and $ini<='17:00:00'){
            $start = new DateTime('17:00');
            $end = new DateTime($dat);

            $inter = $start->diff($end);
            $m = $inter->format('%i');

            $extra3 = 200*$m;
          }else if($dat<'19:00' and $ini>'17:00:00'){
            $start = new DateTime($ini);
            $end = new DateTime($dat);

            $inter = $start->diff($end);
            $m = $inter->format('%i');

            $extra3 = 200*$m;
          }else if($dat>'19:00' and $ini>'17:00:00'){
            $start = new DateTime($ini);
            $end = new DateTime('19:00:00');

            $inter = $start->diff($end);
            $m = $inter->format('%i');

            $extra3 = 200*$m;
          }

        //FIN CONTROLES HORA PICO 17:30 - 19:30

        //SI EL SERVICIO NO HA SOBREPASADO LOS 10 MINUTOS Y LA DISTANCIA RECORRIDA ES MENOR A LOS 3KM, SE COBRA LA TARIFA MÍNIMA.
        if($minutos<=10 and $horas<='00' and $km<'3.0'){

          /*START COBRO TARIFA MÍNIMA*/
          $valor_tarifa = 9000;
          /*END COBRO TARIFA MÍNIMA*/

        //SI EL SERVICIO PASÓ LOS 10 MINUTOS, PERO NO HA RECORRIDO LOS 3KM, SE COBRA LA TARIFA MÍNIMA, Y SE ADICIONAN 600 PESOS POR CADA MINUTO TRANSCURRIDO.
        }else if(($minutos>10 or $horas>'00') and $km<='3.0'){

          /*START COBRO TARIFA MÍNIMA MÁS (600*MIN)*/
          if($horas==='00'){

            $valor_tarifa = 9000+(($minutos-10)*600);

          }else{

            $hor = 60*$horas;
            $valor_tarifa = 9000+(($minutos+$hor-10)*600);
          }
          /*END COBRO TARIFA MÍNIMA MÁS (600*MIN)*/

        //SI EL SERVICIO PASÓ LOS 3KM SE COBRA EL VALOR DE LA TARIFA MÍNIMA, Y SE ADICIONAN 300 PESOS POR CADA 100 METROS (CONTANDO DESPUÉS DE LOS 3KM)
        }else if($km>'3.0'){

          //CALCULAR DATOS DE TIEMPO NEW START
          if($horas==='00'){

            $valor_tiempo = ($minutos-10)*600;

          }else{

            $hor = 60*$horas;
            $valor_tiempo = (($minutos+$hor)-10)*600;
          }
          //CALCULAR DATOS DE TIEMPO NEW END

          /* START COBRO TARIFA MÍNIMA MÁS (300*100M)*/

          $test = round($km, 1);
          $test = explode('.', $test);
          $test = $test[1];
          //FIN SEPARACIÓN DE CIFRAS

          $valor_tarifa = 9000+( ((intval($km)-3.0)*300).'0'+($test*300) );
          $valor_tarifa = $valor_tarifa+$valor_tiempo;

          /* END COBRO TARIFA MÍNIMA MÁS (300*100M)*/

        }

        //CALCULAR RECARGOS POR DOMINGOS Y FESTIVOS
        /* SI LA FECHA DE INICIO Y FINALIZACIÓN ES LA MISMA*/
        $extra_noche = null;
        if($inicio_km[0]===$fin){
        $extra_noche = 0;
          //INICIO CONTROLES HORA PICO 17:30 - 19:30
          //if('20:00:00'>=$ini and '23:59:00'<=$dat){

            //
            if($ini<='20:00:00' and $dat>='23:59:00'){ //SI EL SERVICIO ES EJECUTADO EN TODOS LOS MINUTOS DE RECARGO NOCTURNO PARTE 1
              $extra_noche = $valor_tarifa*0.20;
            }else if($ini<='20:00:00' and $dat<'23:59:00'){
              $extra_noche = $valor_tarifa*0.20;
            }else if('20:00:00'<= $ini and '23:59:00'<=$dat){
              $extra_noche = $valor_tarifa*0.20;
            }else if('20:00:00'>= $ini and '23:59:00'<=$dat){
              $extra_noche = $valor_tarifa*0.20;
            }else if($dat<'23:59:00' and $ini>'20:00:00'){
              $extra_noche = $valor_tarifa*0.20;
            }

          //FIN CONTROLES HORA PICO 17:30 - 19:30
        }else{// SI EL SERVICIO ES EJECUTADO EN LA MADRUGADA

          if($dat<='05:00:00'){ //SI EL SERVICIO ES EJECUTADO EN TODOS LOS MINUTOS DE RECARGO NOCTURNO PARTE 1
            $extra_noche = $valor_tarifa*0.20;
          }else{
            $extra_noche = 0;
          }

        }

        $nombre = '';

        $asunto = 'SERVICIO EJECUTADO';
        //$correo_electronico = 'sdgonzalezmendoza@gmail.com';
        $cc_correo_electronico = 'aotourdeveloper@gmail.com';

        $conductor = Conductor::where('id',$servicio->conductor_id)->first();
        $vehiculo = Vehiculo::where('id',$servicio->vehiculo_id)->first();

        //ENVÍO DE CORREOS PASAJEROS

        $pax = explode('/',$servicio->pasajeros);
        $sw = count($pax);
        $count = 0;

        for ($i=0; $i < count($pax); $i++) {
            $pasajeros[$i] = explode(',', $pax[$i]);
        }

        for ($i=0; $i < count($pax)-1; $i++) {

            for ($j=0; $j < count($pasajeros[$i]); $j++) {

              if ($j===0) {
                $nombre = $pasajeros[$i][$j];
              }

              if ($j===3) {
                $correo_electronico = $pasajeros[$i][$j];
              }

            }
            $count++;

            //INICIO ENVÍO DE EMAIL

            Mail::send('emails.data_servicio_facturacion', [
              'asunto' => $asunto,
              'nombre_usuario' => $nombre,
              'contenido' => $find,
              'kilometros' => round($find->kilometros, 1),
              'tiempo' => $intervalo,
              'valor_tarifa' => $valor_tarifa+$extra+$extra2+$extra3+$extra_noche,
              'extra' => $extra,
              'fecha' => $servicio->fecha_servicio,
              'hora' => $servicio->hora_servicio,
              'hours' => $horas,
              'minutes' => $minutos,
              'seconds' => $segundos,
              'nombre_conductor' => $conductor->nombre_completo,
              'celular' => $conductor->celular,
              'clase' => $vehiculo->clase,
              'placa' => $vehiculo->placa,
              'marca' => $vehiculo->marca,
              'modelo' => $vehiculo->modelo
              //'firma_correo' => $firma_correo,
              //'contenido_correo_electronico' => $contenido_correo_electronico
            ],
            function($message) use ($correo_electronico, $asunto, $cc_correo_electronico){

              $message->to($correo_electronico);

              if ($cc_correo_electronico!=null) {
                $message->cc($cc_correo_electronico);
              }

              $message->from('transportebarranquilla@aotour.com.co', 'AOTOUR');
              $message->subject($asunto);
            });
            //FIN ENVÍO DE EMAIL

        }

        //FIN ENVÍO DE CORREOS PASAJEROS


        //CALCULAR RECARGOS POR DOMINGOS Y FESTIVOS
        $valor_full = $valor_tarifa+$extra+$extra2+$extra3+$extra_noche;
        $guarda_valor = DB::table('c_servicios')
        ->where('id_servicio', $servicio->id)
        ->update([
          'valor_tarifa' => $valor_full,
          'valor_proveedor' => $valor_full*0.70,
          'recargo' => $extra,
          'valor_total' => $valor_tarifa+$extra
        ]);

        //INICIO CREAR REGISTRO DE FACTURACIÓN
        $facturacion = new Facturacion();
        $facturacion->calidad_servicio = 'BUENO';
        $facturacion->observacion = 'SERVICIO POR KILOMETRAJE';
        $facturacion->numero_planilla = $id;
        $facturacion->unitario_cobrado = $valor_full;
        $facturacion->unitario_pagado = $valor_full*0.70;
        $facturacion->total_cobrado = $valor_full;
        $facturacion->total_pagado = $valor_full*0.70;
        $facturacion->utilidad = $valor_full*0.30;
        $facturacion->revisado = 1;
        $facturacion->liquidado = 1;
        $facturacion->servicio_id = $id;

        $nombre_completo = DB::table('conductores')
        ->where('id',$servicio->conductor_id)
        ->pluck('nombre_completo');

        $accion_a = 'OBSERVACION: <span class="bolder">SERVICIO POR KILOMETRAJE</span>';
        $accion_b = 'NUMERO DE CONSTANCIA: <span class="bolder">'.$id.'</span>';
        $array = [
            'fecha'=>date('Y-m-d H:i:s'),
            'accion'=>$accion_a.', '.$accion_b,
            'realizado_por'=>$nombre_completo
        ];
        $facturacion->cambios_servicio = '['.json_encode($array).']';
        $facturacion->save();
        //FALTANTE REGISTRO DE CAMBIOS DE LIQUIDACIÓN
        //FIN CREACIÓN DE REGISTRO DE FACTURACIÓN


        return Response::json([
          'respuesta'=>true,
          '1_fecha_inicio' => $inicio_km[0],
          '2_fecha_fin' => $fin[0],
          '3_extra_noche' => $extra_noche,
          'time' => $intervalo,
          'km' => round($find->kilometros, 1),
          'inicio_km' => $ini,
          'dat' => $dat,
          'min'=> $minutos,
          'valor_tarifa' => $valor_full,
          'test' => $test,
          'hours' => $horas,
          'minutes' => $minutos,
          'seconds' => $segundos,
          'msj' => $msj,
          'extra' => $extra,
          'nombre' => $nombre,
          'extra2' => $extra2,
          'extra3' => $extra3
          //'hora_inicio' => $horaInicio,
          //'hora_termino' => $horaTermino
        ]);

      }

    }

    public function postServicioactivo()
    {

      ##BUSCAR SERVICIOS DEL CONDUCTOR QUE NO SE HAYAN FINALIZADO
      $id_usuario = intval(Input::get('id_usuario'));

      $id_conductor = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->pluck('id');

      $query = Conductor::where('id_usuario',$id_usuario)->pluck('estado_aplicacion');

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      $servicio = DB::table('servicios')
      ->where('conductor_id', $id_conductor)
      ->whereBetween('fecha_servicio', [$diaanterior, $fecha])
      ->where('estado_servicio_app',1)
      ->pluck('id');

      if ($servicio) {

        return Response::json([
            'respuesta' => true,
            'servicio_activo' => $servicio,
            'diaanterior' => $diaanterior,
            'fecha_actual' => $fecha,
            'estado' => $query
        ]);

      }else{

        return Response::json([
            'respuesta' => false,
            'estado' => $query
        ]);

      }

    }

    public function getServiciospendientes()
    {

      $id_usuario = intval(Input::get('id_usuario'));

      $id_conductor = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->pluck('id');

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      //$horalimite = date('H:i',strtotime('+59 minute',strtotime($servicio->hora_servicio)));
      $diasiguiente = strtotime ('+1 day', strtotime($fecha));
      $diasiguiente = date('Y-m-d' , $diasiguiente);

      $consulta = "SELECT servicios.*, reconfirmacion.reconfirmacion2hrs, centrosdecosto.razonsocial as razonsocial, subcentrosdecosto.nombresubcentro as subcentro, nombre_ruta.nombre as nombreruta FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join subcentrosdecosto on subcentrosdecosto.id = servicios.subcentrodecosto_id left join nombre_ruta on nombre_ruta.id = servicios.ruta_nombre_id left join reconfirmacion on reconfirmacion.id_servicio = servicios.id WHERE `conductor_id` = ".$id_conductor." AND servicios.fecha_servicio between '".$diaanterior."' and '".$diasiguiente."' AND (servicios.estado_servicio_app IS NULL OR servicios.estado_servicio_app <> 2) and servicios.aceptado_app = 1 and servicios.pendiente_autori_eliminacion is null order by servicios.fecha_servicio asc, servicios.hora_servicio asc";
      /*$consulta = "SELECT serv.* FROM servicios as serv left join reconfirmacion as reconf ON reconf.id_servicio = serv.id WHERE serv.conductor_id = ".$id_conductor.
      " AND serv.fecha_servicio BETWEEN '".$fecha."' AND '".$fecha.
      "' AND (serv.estado_servicio_app IS NULL OR serv.estado_servicio_app <> 2) and (reconf.ejecutado IS NULL or reconf.ejecutado = '0') order by serv.fecha_servicio";*/

      $servicios = DB::select($consulta);

      /*$servicios = DB::table('servicios')
      ->where('conductor_id', $id_conductor)
      ->whereBetween('fecha_servicio', [$diaanterior, $fecha])
      ->Where('estado_servicio_app', null)
      ->orwhere('estado_servicio_app','<>',2)
      ->get();*/

      $servicio_activo = DB::table('servicios')
      ->where('conductor_id', $id_conductor)
      ->whereBetween('fecha_servicio', [$diaanterior, $diasiguiente])
      ->where('estado_servicio_app',1)
      ->pluck('id');

      if ($servicios) {

        return Response::json([
            'respuesta' => true,
            'servicios' => $servicios,
            'servicio_activo' => $servicio_activo,
            'id_conductor' => $id_conductor
        ]);

      }else{

        return Response::json([
            'respuesta' => false
        ]);

      }
    }

    public function getServiciospendientes2()
    {

      $id_usuario = intval(Input::get('id_usuario'));

      $id_conductor = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->pluck('id');

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      //$horalimite = date('H:i',strtotime('+59 minute',strtotime($servicio->hora_servicio)));
      $diasiguiente = strtotime ('+1 day', strtotime($fecha));
      $diasiguiente = date('Y-m-d' , $diasiguiente);

      $time = date('H:i');
      $horav3 = date('H:i',strtotime('-30 minute',strtotime($time)));

      $consulta = "SELECT servicios.id, servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.conductor_id, servicios.ruta_nombre_id, servicios.subcentrodecosto_id, servicios.centrodecosto_id, servicios.aceptado_app, servicios.estado_servicio_app, servicios.pendiente_autori_eliminacion, servicios.pasajeros_ruta, servicios.pasajeros, servicios.ruta, servicios.recoger_en, servicios.dejar_en, servicios.estado_km, reconfirmacion.reconfirmacion2hrs, centrosdecosto.razonsocial as razonsocial, subcentrosdecosto.nombresubcentro as subcentro, nombre_ruta.nombre as nombreruta FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join subcentrosdecosto on subcentrosdecosto.id = servicios.subcentrodecosto_id left join nombre_ruta on nombre_ruta.id = servicios.ruta_nombre_id left join reconfirmacion on reconfirmacion.id_servicio = servicios.id WHERE `conductor_id` = ".$id_conductor." AND servicios.fecha_servicio between '".$diaanterior."' and '".$diasiguiente."' AND (servicios.estado_servicio_app IS NULL OR servicios.estado_servicio_app <> 2) and servicios.aceptado_app = 1 and servicios.pendiente_autori_eliminacion is null order by servicios.fecha_servicio asc, servicios.hora_servicio asc";

      $servicios = DB::select($consulta);

      $fecha_hoy = date('Y-m-d');
      $hora_actual = $time;//date('H:i');
      $sww = 0;

      $estados_array = [];
      $i = 0;
      foreach ($servicios as $servicio) {

        $consulta_reconfirmacion = DB::table('reconfirmacion')->where('id_servicio',$servicio->id)->first();

        if($consulta_reconfirmacion!=null){
          $sw = 1;
        }else{
          $sw = 0;
        }

        $hora_menos_tres = date('H:i',strtotime('-180 minute',strtotime($servicio->hora_servicio)));
        $hora_menos_uno_media = date('H:i',strtotime('-90 minute',strtotime($servicio->hora_servicio)));

        $fecha_ayer = date('Y-m-d',strtotime('-1 day',strtotime($fecha_hoy)));
        $fecha_manana = date('Y-m-d',strtotime('1 day',strtotime($fecha_hoy)));

        //SI EL SERVICIO YA ESTÁ RECONFIRMADO
        if($sw===1){
          $estados_array[$i] = 2;
        //SI NO ESTÁ RECONFIRMADO AÚN
        }else{
          //SERVICIOS DEL DÍA ANTERIOR
          if($fecha_ayer===$servicio->fecha_servicio){ //SI EL SERVICIO ES DE AYER, AUTOMÁTICAMENTE SE COLOCA COMO NO RECONFIRMADO
            $estados_array[$i] = 0;
          //SERVICIOS DEL DÍA ACTUAL
          }else if($fecha_hoy===$servicio->fecha_servicio){
            if($hora_actual<=$hora_menos_uno_media and $servicio->hora_servicio<'03:00' and $servicio->fecha_servicio>='01:30'){
              $estados_array[$i] = 1;
            }else if($hora_actual>=$hora_menos_tres and $hora_actual<=$hora_menos_uno_media and $servicio->hora_servicio>='03:00'){
              $estados_array[$i] = 1;
            }else if($hora_actual<$hora_menos_tres and $hora_actual<$servicio->hora_servicio){
              $estados_array[$i] = 3;
            }else if($hora_actual>$hora_menos_uno_media){
              $estados_array[$i] = 0;
            }
          //SERVICIOS DEL DÍA DESPUÉS
          }else if($fecha_manana===$servicio->fecha_servicio){

            if($servicio->hora_servicio<='03:00' and $servicio->hora_servicio){
              if($hora_actual<$hora_menos_tres and $servicio->hora_servicio<='03:00'){
                $estados_array[$i] = 3;
              }else if($hora_actual>=$hora_menos_tres and $hora_actual<=$hora_menos_uno_media and $servicio->hora_servicio>='00:00' and $servicio->hora_servicio<='01:29'){
                $estados_array[$i] = 1;
              }else if($hora_actual>=$hora_menos_tres and $hora_actual>=$hora_menos_uno_media and $servicio->hora_servicio<='03:00' and $servicio->hora_servicio>='01:30'){
                $estados_array[$i] = 1;
              }else if($hora_actual>$hora_menos_uno_media){
                $estados_array[$i] = 0;
              }
            }else{
              $estados_array[$i] = 3;
            }
          }
        }

        $i++;
      }

      $servicio_activo = DB::table('servicios')
      ->where('conductor_id', $id_conductor)
      ->whereBetween('fecha_servicio', [$diaanterior, $diasiguiente])
      ->where('estado_servicio_app',1)
      ->pluck('id');

      if ($servicios) {

        return Response::json([
            'respuesta' => true,
            'servicios' => $servicios,
            'servicio_activo' => $servicio_activo,
            'id_conductor' => $id_conductor,
            'drivers' => $estados_array,
            'horac' => $hora_menos_tres,
            'horac2' => $hora_menos_uno_media,
            'horaactual' => $hora_actual,
            'horav3' => $horav3,
            'reconfirmacion'=>$consulta_reconfirmacion
        ]);

      }else{

        return Response::json([
            'respuesta' => false,
        ]);

      }
    }

    public function getServiciospendientesporaceptar()
    {

      $id_usuario = intval(Input::get('id_usuario'));

      $conductor_id = Conductor::where('usuario_id', $id_usuario)->pluck('id');

      /*
      $id_conductor = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->pluck('id');*/

      $fecha = date('Y-m-d');
      $diaanterior = strtotime('-1 day', strtotime($fecha));
      $diaanterior = date('Y-m-d' , $diaanterior);

      $consulta = "SELECT servicios.*, timestampdiff(minute, date_sub(now(), interval 3 hour), CONCAT(fecha_servicio,' ',hora_servicio)) > 1 as fecha, centrosdecosto.razonsocial as razonsocial, subcentrosdecosto.nombresubcentro FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join subcentrosdecosto on servicios.subcentrodecosto_id = subcentrosdecosto.id WHERE `conductor_id` = ".$conductor_id." AND (aceptado_app = 0 or aceptado_app is null) AND pendiente_autori_eliminacion is null AND TIMESTAMPDIFF(MINUTE, date_sub(now(), interval 3 hour), CONCAT(fecha_servicio,' ',hora_servicio)) > 1 ORDER BY fecha_servicio ASC, hora_servicio ASC limit 10";

      $servicios = DB::select($consulta);

      if ($servicios) {

        return Response::json([
            'respuesta' => true,
            'servicios' => $servicios,
            'id_conductor' => $conductor_id
        ]);

      }else{

        return Response::json([
            'respuesta' => false,
            //'consulta' => $consulta
        ]);

      }
    }

    public function postServicioaceptar()
    {

      $id_servicio = Input::get('id_servicio');

      $servicioaceptado = DB::table('servicios')
      ->where('id', $id_servicio)
      ->update([
        'aceptado_app' => 1
      ]);

      if (count($servicioaceptado)) {

        $servicio = Servicio::find($id_servicio);
        $centrodecosto = Centrodecosto::find($servicio->centrodecosto_id);
        $conductor = Conductor::find($servicio->conductor_id);

        $apikey = 'AAAAmVuqq8M:APA91bGKk3kzjOdsCwbkxDUJwjW56XSJnVX5c-xa9AkPOGcFc1qdtHfppEiIUkM7klen0lHC84DK07Ds7wrrTEJiDBgZHzLabezWkTUx1qeFWM5uggF8nPO3HjQsTcrC0EYw3RGhrsch';

        $id_registration_web = User::whereNotNull('id_registration_web')->lists('id_registration_web');

        $data = [
          'data' => [
            'tipo_notificacion' => 'success'
          ],
          'notification' => [
            'title' => 'Autonet',
            'body' => 'El servicio programado para el dia '.$servicio->fecha_servicio.', hora: '.$servicio->hora_servicio.', recoger en: '.$servicio->recoger_en.', dejar en: '.$servicio->dejar_en.' y cliente '.$centrodecosto->razonsocial.' ha sido aceptado por el conductor: '.$conductor->nombre_completo,
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

        return Response::json([
          'respuesta'=>true
        ]);
      }

    }

    public function postReconfirmarservicio(){

      $id_servicio = Input::get('id_servicio');
      $reconfirmacion = new Reconfirmacion();
      $reconfirmacion->id_servicio = $id_servicio;
      $reconfirmacion->reconfirmacion2hrs = date('H:i:s');
      $reconfirmacion->novedad_2 = 'RECONFIRMACION SIN NINGUNA NOVEDAD';
      $reconfirmacion->numero_reconfirmaciones = 1;
      $reconfirmacion->reconfirmado_por = 2;

      if($reconfirmacion->save()){

        return Response::json([
            'respuesta'=>true,
        ]);
      }

    }

    public function postServiciorechazar()
    {

      $id_servicio = Input::get('id_servicio');
      $sw = Input::get('sw');

      $serviciorechazado = DB::table('servicios')
      ->where('id', $id_servicio)
      ->update([
        //rechazado
        'aceptado_app' => 3,
        'estado_rechazo' => $sw
      ]);

      if (count($serviciorechazado)) {

        $servicio = Servicio::find($id_servicio);
        $centrodecosto = Centrodecosto::find($servicio->centrodecosto_id);
        $conductor = Conductor::find($servicio->conductor_id);

        $apikey = 'AAAAspaKTnU:APA91bFtuJmRtfKVvJlX9N3KMTya2mzRHRjvpqAXRxFaQeI6mF51sspyIenNFNE6X2Bxde2rAKs2hq1JKqvngTcMLNq_oHjOKRXb8pxQ0JH114DQZG11v1_D0nL45JugpkCIynnRiqpL';

        $id_registration_web = User::whereNotNull('id_registration_web')->lists('id_registration_web');

        $data = [
          'data' => [
            'tipo_notificacion' => 'danger'
          ],
          'notification' => [
            'title' => 'Autonet',
            'body' => 'El servicio programado para el dia '.$servicio->fecha_servicio.', hora: '.$servicio->hora_servicio.', recoger en: '.$servicio->recoger_en.', dejar en: '.$servicio->dejar_en.' y cliente '.$centrodecosto->razonsocial.' ha sido rechazado por el conductor: '.$conductor->nombre_completo,
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

        return Response::json([
          'respuesta'=>true
        ]);
      }

    }

    public function postServiciorechazar2()
    {

      $id_servicio = Input::get('id_servicio');
      $sw = Input::get('sw');

      $serviciorechazado = DB::table('servicios')
      ->where('id', $id_servicio)
      ->update([
        //rechazado
        'aceptado_app' => 3,
        'estado_rechazo' => $sw
      ]);

      if (count($serviciorechazado)) {

        $servicio = Servicio::find($id_servicio);
        $centrodecosto = Centrodecosto::find($servicio->centrodecosto_id);
        $conductor = Conductor::find($servicio->conductor_id);

        $apikey = 'AAAAspaKTnU:APA91bFtuJmRtfKVvJlX9N3KMTya2mzRHRjvpqAXRxFaQeI6mF51sspyIenNFNE6X2Bxde2rAKs2hq1JKqvngTcMLNq_oHjOKRXb8pxQ0JH114DQZG11v1_D0nL45JugpkCIynnRiqpL';

        $id_registration_web = User::whereNotNull('id_registration_web')->lists('id_registration_web');

        if($servicio->ruta===1){
          $texto = 'RECHAZADA la RUTA programada';
        }else{
          $texto = 'RECHAZADO la SERVICIO programado';
        }
        if($sw===1){
          $razon = ''.'TENGO DOS SERVICIOS A LA MISMA HORA'.'';
        }else if($sw===2){
          $razon = ''.'FALTA DE TIEMPO ENTRE SERVICIOS'.'';
        }else if($sw===3){
          $razon = ''.'IMPEDIMENTOS PERSONALES'.'';
        }else{
          $razon = '';
        }

        //$fecha = date('Y-m-d');
        //$diaanterior = strtotime ('1 day', strtotime($fecha));
        //$diaanterior = date ('Y-m-d' , $diaanterior);

        //if($servicio->fecha_servicio===$fecha){
          //$texto2 = 'para el dia de hoy'
       // }

        $data = [
          'data' => [
            'tipo_notificacion' => 'danger'
          ],
          'notification' => [
            'title' => 'AUTONET - SERVICIO RECHAZADO',
            'body' => 'Ha sido '.$texto.' por parte del conductor '.$conductor->nombre_completo.', para el dia '.$servicio->fecha_servicio.', a las: '.$servicio->hora_servicio.', del cliente '.$centrodecosto->razonsocial.'.<br>'.$servicio->recoger_en.' - '.$servicio->dejar_en.'.',
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
/*
        $servicio = Servicio::find($id_servicio);
        $centrodecosto = Centrodecosto::find($servicio->centrodecosto_id);
        $conductor = Conductor::find($servicio->conductor_id);

        //NEW NOTIFICATION
        $url = "https://fcm.googleapis.com/fcm/send";
        $token = "csLjAoMaZrc:APA91bHq1W4ADx9oJBMz_4zFhg2kObW99MNWsEUxBlNRWX21Hn3BIMM4Y9pvHQy5M-KB-_iz9oppY8_HBEuuQo7hTNatBrtxt2u5lSyeqJ0URGgozAHQ5PEx5V1yCZrAhi0o7jchse5V";
        $serverKey = 'AAAAspaKTnU:APA91bFtuJmRtfKVvJlX9N3KMTya2mzRHRjvpqAXRxFaQeI6mF51sspyIenNFNE6X2Bxde2rAKs2hq1JKqvngTcMLNq_oHjOKRXb8pxQ0JH114DQZG11v1_D0nL45JugpkCIynnRiqpL';
        $title = "Notification Autonet";
        $body = "Notification Test";
        $notification = array('title' =>$title , 'text' => $body, 'sound' => 'default', 'badge' => '1');
        $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
        $json = json_encode($arrayToSend);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        //Send the request
        $response = curl_exec($ch);
        //Close request
        if ($response === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);*/
        //NEW NOTIFICATION

        return Response::json([
          'respuesta'=>true
        ]);
      }

    }
    public function postListapasajeros(){

      $id_servicio= Input::get('id_servicio');

      $usuarios=DB::table('qr_rutas')
      ->select('qr_rutas.*', 'pasajeros.cedula', 'pasajeros.id_employer', 'pasajeros.nombres', 'pasajeros.apellidos', 'pasajeros.telefono', 'pasajeros.direccion', 'pasajeros.barrio', 'pasajeros.localidad', 'pasajeros.municipio', 'pasajeros.departamento', 'pasajeros.area')
      ->leftjoin('pasajeros','qr_rutas.id_usuario','=','pasajeros.cedula')
      ->where('qr_rutas.servicio_id',$id_servicio)
      ->get();

      if (count($usuarios)){
        return Response::json([
          'respuesta'=>true,
          'usuarios'=>$usuarios
        ]);

      }else{

        return Response::json([
          'respuesta'=>false,
          'consulta'=>$usuarios
        ]);

      }
    }

    public function postListapasajerose(){

      $id_servicio= Input::get('id_servicio');

      $usuarios=DB::table('escolar_qr')
      ->select('escolar_qr.*', 'escolar.nombre_estudiante', 'escolar.curso', 'escolar.telefono', 'escolar.direccion', 'escolar.barrio', 'escolar.localidad', 'escolar.nombre_padre', 'escolar.estado')
      ->leftjoin('escolar','escolar_qr.usuario','=','escolar.contrato')
      ->where('escolar_qr.servicio_id',$id_servicio)
      ->get();

      if (count($usuarios)){
        return Response::json([
          'respuesta'=>true,
          'usuarios'=>$usuarios
        ]);

      }else{

        return Response::json([
          'respuesta'=>false,
          'consulta'=>$usuarios
        ]);

      }
    }

    public function postNovedadc(){

      $id_servicio = Input::get('id_servicio');
      $usuario = Input::get('usuario');
      $novedad = Input::get('novedad');

      $update = DB::table('escolar_qr')
      ->where('servicio_id',$id_servicio)
      ->where('usuario',$usuario)
      ->update([
        'novedad_c' => $novedad,
      ]);

      if($update){

        /*Código pusher*/
        /*NOTIFIVACIÓN PUSHER*/
        //Pusher
        $idpusher = "578229";
        $keypusher = "a8962410987941f477a1";
        $secretpusher = "6a73b30cfd22bc7ac574";

        //CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
        $channel = 'escolar';
        $name = 'rutas';

        $info = 'LORE';

        $data = json_encode([
        //'proceso' => 1,
          'info' => $info,
          'user' => $usuario,
          'novedad' => $novedad
        ]);

        $app_id = $idpusher;
        $key = $keypusher;
        $secret = $secretpusher;

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

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $headers = [
        'Content-Type: application/json'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

        $result = curl_exec($ch);

        /* FIN NOTIFICACIÓN PUSHER*/

        return Response::json([
          'respuesta' => true,
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
        ]);

      }
    }

      //ESCANEO DE USUARIOS EN LISTA V1
     public function postRutasqrpasajeros(){


        $id_usuario=Input::get('codigo');
        $id_servicio=Input::get('id_servicio');


        $hora_servicio=DB::table('servicios')
        ->where('id',$id_servicio)
        ->pluck('hora_servicio');

        $fecha_servicio=DB::table('servicios')
        ->where('id',$id_servicio)
        ->pluck('fecha_servicio');

        $conductor=DB::table('servicios')
        ->where('id',$id_servicio)
        ->pluck('conductor_id');

        $centrodecosto=DB::table('servicios')
        ->where('id',$id_servicio)
        ->pluck('centrodecosto_id');

        $subcentrodecosto=DB::table('servicios')
        ->where('id',$id_servicio)
        ->pluck('subcentrodecosto_id');


/*      $tusuarios=DB::table('qr_rutas')
        ->where('fecha',$fecha_servicio)
        ->where('hora_servicio',$hora_servicio)
        ->where('',)*/

        $estado=DB::table('qr_rutas')
        ->where('fecha',$fecha_servicio)
        ->where('hora',$hora_servicio)
        ->where('id_usuario',$id_usuario)
        ->update(['status'=>1]);

        $usuarios = DB::table('qr_rutas')
        ->leftJoin('pasajeros','qr_rutas.id_usuario','=','pasajeros.cedula')
        ->leftJoin('nombre_ruta','qr_rutas.id_rutaqr','=','nombre_ruta.id')
        ->where('qr_rutas.id_usuario',$id_usuario)
        ->where('qr_rutas.servicio_id',$id_servicio)
        ->where('qr_rutas.fecha',$fecha_servicio)
        ->where('qr_rutas.hora',$hora_servicio)
        ->where('qr_rutas.conductor_id',$conductor)
        ->where('qr_rutas.centrodecosto_id',$centrodecosto)
        ->where('qr_rutas.subcentrodecosto_id',$subcentrodecosto)
        ->get();

        if (count($usuarios)){
        return Response::json([
        'respuesta'=>true,
        'usuarios'=>$usuarios,
/*      'todos_usuarios'=>$tusuarios*/
        ]);
        }else{

        return Response::json([
        'respuesta'=>false
        ]);
      }
    }
    //FIN SCANEO QR DESDE LISTA V1

    //SCANEO QR DESDE LISTA V2
    public function postScaneodeqrregistro(){

        $id_usuario=Input::get('codigo');
        $id_servicio=Input::get('id_servicio');

        $estado = DB::table('qr_rutas')
        ->where('servicio_id',$id_servicio)
        ->where('id_usuario',$id_usuario)
        ->pluck('status');

        if($estado==1){

          return Response::json([
            'escaneado'=>false
          ]);

        }else{

          $estado=DB::table('qr_rutas')
          ->where('servicio_id',$id_servicio)
          ->where('id_usuario',$id_usuario)
          ->update(['status'=>1]);

          $consulta = "SELECT qr_rutas.id_usuario, qr_rutas.id_rutaqr, qr_rutas.fecha, qr_rutas.hora, pasajeros.nombres, pasajeros.apellidos, pasajeros.direccion, pasajeros.barrio, pasajeros.localidad FROM qr_rutas LEFT JOIN pasajeros ON pasajeros.cedula = qr_rutas.id_usuario WHERE qr_rutas.servicio_id='$id_servicio' AND qr_rutas.id_usuario='$id_usuario'";

          $usuarios = DB::select($consulta);

          if (count($usuarios)){
            return Response::json([
              'respuesta'=>true,
              'usuarios'=>$usuarios,
            ]);
          }else{
            return Response::json([
              'respuesta'=>false
            ]);
          }

        } //FIN SI
    }
    //FIN SCANEO QR DESDE LISTA V2

    //SCANEO QR ESCOLAR
    public function postScaneodeqre(){

        $id_usuario=Input::get('codigo');
        $id_servicio=Input::get('id_servicio');

        $estado = DB::table('escolar_qr')
        ->where('servicio_id',$id_servicio)
        ->where('usuario',$id_usuario)
        ->pluck('estado_ruta');

        if($estado==1){

          return Response::json([
            'escaneado'=>false
          ]);

        }else{

          $estado=DB::table('escolar_qr')
          ->where('servicio_id',$id_servicio)
          ->where('usuario',$id_usuario)
          ->update(['estado_ruta'=>1]);

          if (count($estado)){

            /*Código pusher*/
            /*NOTIFIVACIÓN PUSHER*/
            //Pusher
            $idpusher = "578229";
            $keypusher = "a8962410987941f477a1";
            $secretpusher = "6a73b30cfd22bc7ac574";

            //CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
            $channel = 'escolar';
            $name = 'rutas';

            $info = 'LORE';
            $novedad = 0;

            $data = json_encode([
            //'proceso' => 1,
              'info' => $info,
              'user' => $id_usuario,
              'novedad' => $novedad
            ]);

            $app_id = $idpusher;
            $key = $keypusher;
            $secret = $secretpusher;

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

            curl_setopt($ch, CURLOPT_POST, true);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $headers = [
            'Content-Type: application/json'
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

            $result = curl_exec($ch);

            /* FIN NOTIFICACIÓN PUSHER*/

            $usuario = DB::table('escolar')->where('contrato',$id_usuario)->first();

            return Response::json([
              'respuesta'=>true,
              'usuario'=>$usuario,
            ]);
          }else{
            return Response::json([
              'respuesta'=>false
            ]);
          }

          /*$consulta = "SELECT qr_rutas.id_usuario, qr_rutas.id_rutaqr, qr_rutas.fecha, qr_rutas.hora, pasajeros.nombres, pasajeros.apellidos, pasajeros.direccion, pasajeros.barrio, pasajeros.localidad FROM qr_rutas LEFT JOIN pasajeros ON pasajeros.cedula = qr_rutas.id_usuario WHERE qr_rutas.servicio_id='$id_servicio' AND qr_rutas.id_usuario='$id_usuario'";

          $usuarios = DB::select($consulta);

          if (count($usuarios)){
            return Response::json([
              'respuesta'=>true,
              'usuarios'=>$usuarios,
            ]);
          }else{
            return Response::json([
              'respuesta'=>false
            ]);
          }*/

        } //FIN SI
    }
    //FIN SCANEO QR ESCOLAR

    public function postRecogerpass(){

      $id = Input::get('id');
      $id_usuario = Input::get('id_usuario');
      $id_servicio = Input::get('id_servicio');

      $estado=DB::table('qr_rutas')
      ->where('servicio_id',$id_servicio)
      ->where('id_usuario',$id_usuario)
      ->update(['status2'=>1]);

      $ids = DB::table('qr_rutas')
        ->where('servicio_id',$id_servicio)
        ->where('id_usuario',$id_usuario)
        ->pluck('id');

      /*$id_tabla = DB::table('qr_rutas')
        ->where('servicio_id',$id_servicio)
        ->where('id_usuario',$id_usuario)
        ->pluck('id');*/

      $consulta = "SELECT qr_rutas.id_usuario, qr_rutas.id_rutaqr, qr_rutas.fecha, qr_rutas.hora, pasajeros.nombres, pasajeros.apellidos, pasajeros.direccion, pasajeros.barrio, pasajeros.localidad FROM qr_rutas LEFT JOIN pasajeros ON pasajeros.cedula = qr_rutas.id_usuario WHERE qr_rutas.servicio_id='$id_servicio' AND qr_rutas.id_usuario='$id_usuario'";

      $usuarios = DB::select($consulta);

      if (count($usuarios)){

        //NOTIFICACIÓN A LA TABLA DE USUARIOS

        $idpusher = "578229";
        $keypusher = "a8962410987941f477a1";
        $secretpusher = "6a73b30cfd22bc7ac574";

        $channel = 'reportes';
        $name = 'usuarios';

        $data = json_encode([
          'sw' => 2,
          'id_usuario' => $id_usuario,
          'id' => $ids
        ]);

        $app_id = $idpusher;
        $key = $keypusher;
        $secret = $secretpusher;

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

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $headers = [
          'Content-Type: application/json'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

        $result = curl_exec($ch);
        //FIN

        return Response::json([
          'respuesta'=>true,
          'usuarios'=>$usuarios,
        ]);
      }else{
        return Response::json([
          'respuesta'=>false,
        ]);
      }
    }

	public function postAutorizado2(){
    $idservicio = Input::get('id_servicio');
    $idusuario = Input::get('id_usuario');
    $dato1 = Servicio::where('id',$idservicio)->first();
    $pasajeroruta = new Ruta_qr();
    $pasajeroruta->id_usuario = $idusuario;
    $pasajeroruta->fecha = $dato1->fecha_servicio;
    $pasajeroruta->hora = $dato1->hora_servicio;
    $pasajeroruta->status = 3;
    $pasajeroruta->save();
    return Response::json([
      'respuesta' => true,

    ]);
  }

  public function postAutorizadoscan(){

    return Response::json([
      'respuesta' => false,
    ]);
    
    $idusuario = Input::get('id_usuario');
    $duplicado = Ruta_qr::where('id_usuario',$idusuario)
    ->where('servicio_id',Input::get('id_servicio'))
    ->first();

    if($duplicado!=null){
      if($duplicado->status === 2 || $duplicado->status === 3){
        return Response::json([
          'respuesta' => 'duplicadoa'
        ]);
      }else{
        return Response::json([
          'respuesta' => 'duplicadop'
        ]);
      }
    }else{

      $consulta = Pasajero::where('cedula',$idusuario)->first();

      if($consulta!=null){
        $idservicio = Input::get('id_servicio');
        $dato1 = Servicio::where('id',$idservicio)->first();
        $cantidadp = $dato1->cantidad;
        $cambios = $dato1->pasajeros_ruta;

        $pasajeroruta = new Ruta_qr();
        $pasajeroruta->id_usuario = $idusuario;
        $pasajeroruta->fecha = $dato1->fecha_servicio;
        $pasajeroruta->hora = $dato1->hora_servicio;
        $pasajeroruta->centrodecosto_id = $dato1->centrodecosto_id;
        $pasajeroruta->subcentrodecosto_id = $dato1->subcentrodecosto_id;
        $placadata = Vehiculo::where('id',$dato1->vehiculo_id)->first();
        $pasajeroruta->vehiculo = $placadata->placa;
        $pasajeroruta->id_rutaqr = $dato1->detalle_recorrido;
        $pasajeroruta->conductor_id = $dato1->conductor_id;
        $pasajeroruta->servicio_id = $idservicio;
        $pasajeroruta->status = 2;
        $pasajeroruta->save();

        $array = [
          'nombres' => strtoupper($consulta->nombres),
          'apellidos' => strtoupper($consulta->apellidos),
          'cedula' => $consulta->cedula,
          'direccion' => strtoupper($consulta->direccion),
          'barrio' => strtoupper($consulta->barrio),
          'cargo' => 'N/A',
          'area' => strtoupper($consulta->area),
          'sub_area' => strtoupper($consulta->sub_area),
          'hora' => $dato1->hora_servicio,
        ];
        $cambios = json_decode($cambios);

        array_push($cambios, $array);

        $servicio2 = Servicio::find(Input::get('id_servicio'));
        if($cantidadp==4){
            $detalle = 'VAN';
            $servicio2->dejar_en = $detalle;
        }
        $servicio2->cantidad = $cantidadp+1;
        $servicio2->resaltar = 1;
        $servicio2->pasajeros_ruta = json_encode($cambios);
        if($servicio2->save()){
          return Response::json([
            'respuesta' => true,
          ]);
        }else{
          return Response::json([
            'respuesta' => false,
          ]);
        }

      }else{
        $idservicio = Input::get('id_servicio');
        $dato1 = Servicio::where('id',$idservicio)->first();
        $cantidadp = $dato1->cantidad;
        $cambios = $dato1->pasajeros_ruta;

        $pasajeroruta = new Ruta_qr();
        $pasajeroruta->id_usuario = $idusuario;
        $pasajeroruta->fecha = $dato1->fecha_servicio;
        $pasajeroruta->hora = $dato1->hora_servicio;
        $pasajeroruta->centrodecosto_id = $dato1->centrodecosto_id;
        $pasajeroruta->subcentrodecosto_id = $dato1->subcentrodecosto_id;
        $placadata = Vehiculo::where('id',$dato1->vehiculo_id)->first();
        $pasajeroruta->vehiculo = $placadata->placa;
        $pasajeroruta->id_rutaqr = $dato1->detalle_recorrido;
        $pasajeroruta->conductor_id = $dato1->conductor_id;
        $pasajeroruta->servicio_id = $idservicio;
        $pasajeroruta->status = 3;
        $pasajeroruta->save();

        $array = [
          'nombres' => 'SIN REGISTRARSE',
          'apellidos' => 'SIN REGISTRARSE',
          'cedula' => 'N/A',
          'direccion' => 'N/A',
          'barrio' => 'N/A',
          'cargo' => 'N/A',
          'area' => 'N/A',
          'sub_area' => 'N/A',
          'hora' => $dato1->hora_servicio,
        ];
        $cambios = json_decode($cambios);

        array_push($cambios, $array);

        $servicio2 = Servicio::find(Input::get('id_servicio'));
        if($cantidadp==4){
            $detalle = 'VAN';
            $servicio2->dejar_en = $detalle;
        }
        $servicio2->cantidad = $cantidadp+1;
        $servicio2->resaltar = 1;
        $servicio2->pasajeros_ruta = json_encode($cambios);
        if($servicio2->save()){
          return Response::json([
            'respuesta' => true,
          ]);
        }else{
          return Response::json([
            'respuesta' => false,
          ]);
        }
      }
    }
  }


/*	public function postAutorizado(){
      $id = Input::get('id');
      $validaciones = [
        'id' => 'required'
      ];
      $mensajesValidacion = [
        'id.required' => 'El campo id es requerido!',
      ];
      $validador = Validator::make(Input::all(), $validaciones, $mensajesValidacion);
      if ($validador->fails()){

      return Response::json([
          'errores'=>$validador->errors()->getMessages(),
          'respuesta'=>false
      ]);

      }else {
        $user = DB::table('pasajeros')->where('id_employer', $id)->get();
        if(count($user)){
          return Response::json([
            'respuesta' => true,
            'pasajero' => $user
          ]);
        }else{
          return Response::json([
            'respuesta' => false
          ]);
        }
      }
    }*/
//

    public function postBuscarservicios()
    {

      $id_usuario = Input::get('id_usuario');
      $fecha = Input::get('fecha');

      $conductor_id = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->pluck('id');

      $servicios = Servicio::selectRaw('servicios.*, centrosdecosto.razonsocial as razonsocial, subcentrosdecosto.nombresubcentro')
      ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
      ->leftJoin('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
      ->leftJoin('nombre_ruta', 'servicios.ruta_nombre_id', '=', 'nombre_ruta.id')
      ->leftjoin('c_servicios','c_servicios.id_servicio', '=', 'servicios.id')
      ->where('conductor_id', $conductor_id)
      ->where('fecha_servicio', $fecha)
      ->whereNull('pendiente_autori_eliminacion')
      //->where('estado_servicio_app', 2)
      ->orderBy('hora_servicio', 'asc')
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

    public function postGuardardisponibilidad()
    {

      $id_usuario = Input::get('id_usuario');
      $fecha_inicial = Input::get('fecha_inicial');
      $hora_inicial = Input::get('hora_inicial');
      $fecha_final = Input::get('fecha_final');
      $hora_final = Input::get('hora_final');

      $driver = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->first();

      if($fecha_inicial==='hoy'){
        $fechaI = date('Y-m-d');
      }else{
        $date = date('Y-m-d');
        $fechaI = strtotime ('+1 day', strtotime($date));
        $fechaI = date ('Y-m-d' , $fechaI);
      }

      if($fecha_final==='hoyf'){
        $fechaF = date('Y-m-d');
      }else{
        $datef = date('Y-m-d');
        $fechaF = strtotime ('+1 day', strtotime($datef));
        $fechaF = date ('Y-m-d' , $fechaF);
      }

      if($fecha_inicial==='hoy' && $fecha_final==='hoyf'){
        
        $servicio = DB::table('servicios')
        ->where('fecha_servicio',date('Y-m-d'))
        ->where('conductor_id', $driver->id)
        ->whereBetween('hora_servicio', [$hora_inicial,$hora_final])
        ->first();

      }else if($fecha_inicial==='hoy' && $fecha_final==='mananaf'){

        $servicio = DB::table('servicios')
        ->where('fecha_servicio',date('Y-m-d'))
        ->where('conductor_id', $driver->id)
        ->whereBetween('hora_servicio', [$hora_inicial,'23:59'])
        ->first();

        if(!$servicio!=null){

          $servicio = DB::table('servicios')
          ->where('fecha_servicio',$fechaF)
          ->where('conductor_id', $driver->id)
          ->whereBetween('hora_servicio', ['00:00',$hora_final])
          ->first();

        }

      }else if($fecha_inicial==='manana' && $fecha_final==='mananaf'){

        $servicio = DB::table('servicios')
        ->where('fecha_servicio',$fechaF)
        ->where('conductor_id', $driver->id)
        ->whereBetween('hora_servicio', [$hora_inicial,$hora_final])
        ->first();

      }
        
      if($servicio!=null){
        
        return Response::json([
          'respuesta' => 'servicio',
          'servicio' => $servicio
        ]);

      }else{

        $conductor = DB::table('conductores')
        ->where('usuario_id',$id_usuario)
        ->update([
          'inicio_fecha' => $fechaI,
          'inicio_hora' => $hora_inicial,
          'fin_fecha' => $fechaF,
          'fin_hora' => $hora_final
        ]);

        return Response::json([
          'respuesta' => true,
          'fecha_inicial' => $fechaI,
          'fecha_final' => $fechaF,
          'servicio' => $servicio
        ]);

      }

    }

    public function postConsultardisponibilidad()
    {

      $id_usuario = Input::get('id_usuario');
      
      $fechaActual = date('Y-m-d');

      $diasiguiente = strtotime ('+1 day', strtotime($fechaActual));
      $diasiguiente = date ('Y-m-d' , $diasiguiente);

      $conductor = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->first();

      $mensaje = '';

      if($conductor->inicio_fecha==$fechaActual or $conductor->inicio_fecha==$diasiguiente){
        
        if($conductor->inicio_fecha==$fechaActual and $conductor->fin_fecha==$fechaActual){

          $mensaje = 'Desde HOY a las '.$conductor->inicio_hora.', Hasta las '.$conductor->fin_hora.'';

        }else if($conductor->inicio_fecha==$fechaActual and $conductor->fin_fecha==$diasiguiente){

          $mensaje = 'Desde HOY a las '.$conductor->inicio_hora.', Hasta MAÑANA a las '.$conductor->fin_hora.'';

        }else if($conductor->inicio_fecha==$diasiguiente and $conductor->fin_fecha==$diasiguiente){

          $mensaje = 'Desde MAÑANA a las '.$conductor->inicio_hora.', Hasta las '.$conductor->fin_hora.'';

        }

        return Response::json([
          'respuesta' => true,
          'conductor' => $conductor,
          'mensaje' => $mensaje,
          'sw' => 1
        ]);

      }else{
        
        return Response::json([
          'respuesta' => false,
          'sw' => 0
        ]);

      }

    }

    public function postEliminardisponibilidad()
    {

      $id_usuario = Input::get('id_usuario');
      $fechaActual = date('Y-m-d');

      if($fechaActual>='07:00' and $fechaActual<='17:00'){

        return Response::json([
          'respuesta' => false,
          'mensaje' => 'El plazo para la eliminación ya venció. Comuníquese con el counter.'
        ]);

      }else{

        $conductor = DB::table('conductores')
        ->where('usuario_id',$id_usuario)
        ->update([
          'inicio_fecha' => null,
          'inicio_hora' => null,
          'fin_fecha' => null,
          'fin_hora' => null
        ]);

        return Response::json([
          'respuesta' => true
        ]);

      }

    }

    public function postReporteserrores()
    {

      $validaciones = [
        'descripcion' => 'required'
      ];

      $mensajes = [
        'descripcion.required' => 'Este campo es requerido'
      ];

      $validador = Validator::make(Input::all(), $validaciones, $mensajes);

      //SI EL VALIDADOR FALLA ENTONCES ENVIA RESPUESTA DE ERROR CON UN ARRAY DE ERROR
      if ($validador->fails()){

          return Response::json([
              'respuesta'=>false,
              'errores'=>$validador->errors()->getMessages()
          ]);

      }else {

        $id_usuario = Input::get('id_usuario');
        $descripcion = Input::get('descripcion');

        $reportes_errores = new Reporteerrores;
        $reportes_errores->descripcion = $descripcion;
        $reportes_errores->usuario_id = $id_usuario;

        if ($reportes_errores->save()) {

          return Response::json([
            'respuesta' => true
          ]);

        }else{

          return Response::json([
            'respuesta' => false
          ]);

        }

      }

    }

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

    public function postHorainicio()
    {

      $id = Input::get('id_servicio');

      $servicio = Servicio::where('id', $id)->with(['centrodecosto'])->first();
      $servicio->hora_inicio = date('Y-m-d H:i:s');
      $servicio->estado_servicio_app = 1; ## 1 = SERVICIO EN PROCESO, 2 = SERVICIO FINALIZADO
      $conductor_id = $servicio->conductor_id;
      $query = DB::table('conductores')
      ->where('id', $conductor_id)
      ->update([
        'estado_aplicacion' => 0
      ]);

      if ($servicio->save()) {

          //Si hay un usuario asignado para el servicio
          return Response::json([
            'response' => true,
            'servicio' => $servicio
          ]);
      }

    }

    public function postHorainiciov2()
    {

    	$id = Input::get('id_servicio');

  		$servicio = Servicio::where('id', $id)->with(['centrodecosto'])->first();
  		$servicio->hora_inicio = date('Y-m-d H:i:s');
  		$servicio->estado_servicio_app = 1; ## 1 = SERVICIO EN PROCESO, 2 = SERVICIO FINALIZADO
  		$conductor_id = $servicio->conductor_id;
  		$query = DB::table('conductores')
  		->where('id', $conductor_id)
  		->update([
  		  'estado_aplicacion' => 0
  		]);

  		if ($servicio->save()) {

  		  //Si hay un usuario asignado para el servicio
        $user = DB::table('servicios')
        ->where('id',$id)
        ->pluck('app_user_id');

        if($servicio->app_user_id!=null){
          $notifications = Servicio::ServicioIniciado($id, $user);
        }else if($servicio->ruta!=1){

          /*$pax = explode('/',$servicio->pasajeros);

          for ($i=0; $i < count($pax); $i++) {
            $pasajeros[$i] = explode(',', $pax[$i]);
          }

          for ($i=0; $i < count($pax)-1; $i++) {

            for ($j=0; $j < count($pasajeros[$i]); $j++) {

              if ($j===1) {
                $nombre = $pasajeros[$i][$j];
              }

            }

            if($nombre!=''){
              
              
              $numero = $nombre;

              Servicio::ServicioIniciadoWhatsApp($id, $numero);
              

            }

          }*/

        }

        $cliente = DB::table('centrosdecosto')
        ->where('id',$servicio->centrodecosto_id)
        ->pluck('razonsocial');

  		  return Response::json([
  		    'response' => true,
  		    'servicio' => $servicio,
          'cliente' => $cliente
  		  ]);
  		}
    	/*
      $id = Input::get('id_servicio');

      $servicio = Servicio::where('id', $id)->with(['centrodecosto'])->first();
      $conductor_id = $servicio->conductor_id;
      $query = DB::table('conductores')
      ->where('id', $conductor_id)
      ->update([
        'estado_aplicacion' => 0
      ]);
      $dat = date('H:i',strtotime('-59 minute',strtotime($servicio->hora_servicio)));
      $fechaactual = date('Y-m-d');
      $dato = date('H:i');
      $fechadelservicio = $servicio->fecha_servicio;
      $nombre_ruta = $servicio->detalle_recorrido;

      if(strcasecmp($nombre_ruta,'E')==0){
         $dat = date('H:i',strtotime('-89 minute',strtotime($servicio->hora_servicio)));
          if($dato<$dat){
            return Response::json([
              'response' => false,
            ]);
           }else{
               $servicio->hora_inicio = date('Y-m-d H:i:s');
              $servicio->estado_servicio_app = 1; ## 1 = SERVICIO EN PROCESO, 2 = SERVICIO FINALIZADO
            if ($servicio->save()) {

              //Si hay un usuario asignado para el servicio
              return Response::json([
                'response' => true,
                'servicio' => $servicio
                ]);
            }
          }
      }else{
        if($fechadelservicio==$fechaactual){
          $dato = date('H:i');
          if($dato<$dat){
              return Response::json([
                'response' => false,
              ]);
          }else{
            $servicio->hora_inicio = date('Y-m-d H:i:s');
            $servicio->estado_servicio_app = 1; ## 1 = SERVICIO EN PROCESO, 2 = SERVICIO FINALIZADO
            if ($servicio->save()) {
              //Si hay un usuario asignado para el servicio
              return Response::json([
                  'response' => true,
                  'servicio' => $servicio
              ]);
            }
          }
        }else if($fechaactual>$fechadelservicio){
          $servicio->hora_inicio = date('Y-m-d H:i:s');
          $servicio->estado_servicio_app = 1; ## 1 = SERVICIO EN PROCESO, 2 = SERVICIO FINALIZADO
          if ($servicio->save()) {
            //Si hay un usuario asignado para el servicio
            return Response::json([
                'response' => true,
                'servicio' => $servicio
            ]);
          }
        }else if($fechaactual<$fechadelservicio){
          if($servicio->hora_servicio>'23:31' and $dato <'00:30'){
            $servicio->hora_inicio = date('Y-m-d H:i:s');
            $servicio->estado_servicio_app = 1; ## 1 = SERVICIO EN PROCESO, 2 = SERVICIO FINALIZADO
            if ($servicio->save()) {
              //Si hay un usuario asignado para el servicio
              return Response::json([
                  'response' => true,
                  'servicio' => $servicio
              ]);
            }
          }else{
            return Response::json([
              'response' => false,
            ]);
          }
          // hora servicio          dato
          //23:59   si        >      00:28 si  si ejecuta
          //23:29  no               00:28 si   no ejecuta
          //01:00  no               00:30  si no ejecuta


        }
      }
       */
    }

    public function postHorainiciov3()
    {

      $id = Input::get('id_servicio');

      $servicio = Servicio::where('id', $id)->with(['centrodecosto'])->first();
      $servicio->hora_inicio = date('Y-m-d H:i:s');
      $servicio->estado_servicio_app = 1; ## 1 = SERVICIO EN PROCESO, 2 = SERVICIO FINALIZADO
      $conductor_id = $servicio->conductor_id;
      $query = DB::table('conductores')
      ->where('id', $conductor_id)
      ->update([
        'estado_aplicacion' => 0
      ]);

      if ($servicio->save()) {

        //Si hay un usuario asignado para el servicio
        $user = DB::table('servicios')
        ->where('id',$id)
        ->pluck('app_user_id');

        if($servicio->app_user_id!=null){
          $notifications = Servicio::ServicioIniciado($id, $user);
        }else if($servicio->ruta==1){

          $users = DB::table('qr_rutas')
          ->where('servicio_id',$id)
          ->get();

          if($users){

            $name = DB::table('conductores')
            ->where('id',$servicio->conductor_id)
            ->pluck('nombre_completo');

            foreach ($users as $user) {
              
              //not
              $url = 'https://fcm.googleapis.com/fcm/send';
              $key = Notification::FIREBASE_KEY_CLIENT;
              $vibration_pattern = Notification::VIBRATION_PATTERN;

              $usuario = DB::table('users')
              ->where('email',$user->id_usuario)
              ->first();

              if($usuario!=null){

                if ($usuario->idregistrationdevice!=null and $usuario->idregistrationdevice!='') {

                  $ids = $usuario->idregistrationdevice;

                  if($usuario->idioma==='en'){

                    $title = 'Service Started!';
                    $message = 'Your service is now available for tracking. Click here to go.';

                  }else{

                    $title = '¡Tu ruta ha Iniciado!';
                    $message = 'Pulsa aquí para ver la ubicación de '. $name.'.';

                  }

                  $fields = array (
                    'registration_ids' => array (
                      $ids
                    ),
                    'notification' => array (
                      "body" => $message,
                      "title" => $title,
                      "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png',
                      "vibration_pattern" => $vibration_pattern
                    ),
                    'data' => array (
                      "id" => 4,
                      "servicio" => $id,
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

                }
                //not
              }
            }

          }

        }

        $cliente = DB::table('centrosdecosto')
        ->where('id',$servicio->centrodecosto_id)
        ->pluck('razonsocial');

        return Response::json([
          'response' => true,
          'servicio' => $servicio,
          'cliente' => $cliente
        ]);
      }
    }

    public function postFoto(){

      $id_usuario = intval(Input::get('id_usuario'));
      $foto = Conductor::where('usuario_id', $id_usuario)->where('foto_autorizacion',1)->pluck('foto_app');

      if($foto!=null){
        return Response::json([
          'respuesta' => true,
          'foto' =>$foto
        ]);
      }else{
        return Response::json([
          'respuesta' => false
        ]);
      }

    }

    public function getConsultafuec2()
    {

      $id_usuario = intval(Input::get('id_usuario'));

      $conductor_id = Conductor::where('usuario_id', $id_usuario)->pluck('id');

      $fecha = date('Y-m-d');

      $consulta = "SELECT fuec.*, contratos.contratante, rutas_fuec.origen, rutas_fuec.destino FROM fuec left join contratos on contratos.id = fuec.contrato_id left join rutas_fuec on rutas_fuec.id = fuec.ruta_id WHERE '".$fecha."' BETWEEN DATE(fuec.created_at) AND fecha_final AND FIND_IN_SET('".$conductor_id."', conductor) > 0 ORDER BY id DESC";

      $fuec = DB::select($consulta);

      if ($fuec) {

        return Response::json([
          'respuesta' => true,
          'fuec' => $fuec,
          'id_conductor' => $conductor_id,
          'consulta' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'fuec' => $fuec,
          'consulta' => $consulta
        ]);

      }
    }

    public function getConsultafuec()
    {

      $id_usuario = intval(Input::get('id_usuario'));

      $conductor_id = Conductor::where('usuario_id', $id_usuario)->pluck('id');

      $fecha = date('Y-m-d');

      $consulta = "SELECT fuec.*, contratos.contratante, rutas_fuec.origen, rutas_fuec.destino FROM fuec left join contratos on contratos.id = fuec.contrato_id left join rutas_fuec on rutas_fuec.id = fuec.ruta_id WHERE '".$fecha."' BETWEEN DATE(fuec.created_at) AND fecha_final AND FIND_IN_SET('".$conductor_id."', conductor) > 0 ORDER BY id DESC";

      $fuec = DB::select($consulta);

      if ($fuec) {

        return Response::json([
          'respuesta' => true,
          'fuec' => $fuec,
          'id_conductor' => $conductor_id,
          'consulta' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'fuec' => $fuec,
          'consulta' => $consulta
        ]);

      }
    }

    public function postExportarfuecpdf(){

          ini_set('max_execution_time', 300);

          $json = Input::all();

          $id = $json['id'];

          $fuec = DB::table('fuec')
          ->select('contratos.numero_contrato','fuec.consecutivo', 'fuec.cantidad_descargas', 'fuec.id','contratos.contratante','contratos.nit_contratante','contratos.cliente','contratos.representante_legal',
          'contratos.cc_representante','contratos.telefono_representante','contratos.direccion_representante', 'vehiculos.ano as vehiculo_ano',
          'fuec.objeto_contrato','fuec.ano','rutas_fuec.ruta as descripcion_ruta','rutas_fuec.origen','rutas_fuec.destino','fuec.fecha_inicial','fuec.fecha_final',
          'vehiculos.placa','vehiculos.modelo','vehiculos.modelo','vehiculos.marca','vehiculos.clase','vehiculos.numero_interno','vehiculos.tarjeta_operacion',
          'fuec.conductor','vehiculos.empresa_afiliada','fuec.colegio')
          ->leftJoin('vehiculos','fuec.vehiculo','=','vehiculos.id')
          ->leftJoin('contratos','fuec.contrato_id','=','contratos.id')
          ->leftJoin('rutas_fuec','fuec.ruta_id','=','rutas_fuec.id')
          ->where('fuec.id',$id)
          ->first();

          $cantidad = Fuec::find($id);
          if($cantidad->cantidad_descargas==null){
            $cantidad->cantidad_descargas = 1;
          }else{
            $cantidad->cantidad_descargas = intval($cantidad->cantidad_descargas) + 1;
          }

          if (is_null($cantidad->jsonIP)){

            $arrayIP = [];

            array_push($arrayIP, [
              'IP' => Methods::getRealIpAddr(),
              'USER_AGENT' => 'AOTOUR MOBILE DRIVER',
              'TIME' => date('Y-m-d H:i:s')
            ]);

            $cantidad->jsonIP = json_encode($arrayIP);

          }else{

            $arrayIP = json_decode($cantidad->jsonIP);

            array_push($arrayIP, [
              'IP' => Methods::getRealIpAddr(),
              'USER_AGENT' => 'AOTOUR MOBILE DRIVER',
              'TIME' => date('Y-m-d H:i:s')
            ]);

            $cantidad->jsonIP = json_encode($arrayIP);
          }

          $cantidad->save();

          $arrayidc = explode(',',$fuec->conductor);

          $view = View::make('fuec.pdf_fuec')->with([
              'fuec' => $fuec,
              'arrayidc' => $arrayidc,
              'numero_encriptado' => $fuec->id
          ])->render();

          $view = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $view);
          //$view = preg_replace('/>\s+</', '><', $view);

          $pdf = PDF::load($view, 'Legal', 'portrait')->output();

          return Response::json([
            'response' => true,
            'pdf' => base64_encode($pdf),
            'option' => 3
          ]);
    }

    //test
    public function postSubirfotoapp(){

      $id_image = Input::get('image');
      $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$id_image));
      $id_usuario = intval(Input::get('id_usuario'));
      /*$id_conductor = DB::table('conductores')->where('usuario_id',$id_usuario)->pluck('id');

      $conductor = Conductor::find($id_conductor);

      $conductor->foto_sin_autorizar = $id_conductor.'.jpg';
      //$conductor->foto_app = $id_conductor.'.jpg';
      $conductor->foto_autorizacion = 0;

      if($conductor->save()){

        $filepath = "biblioteca_imagenes/proveedores/conductores/".$conductor->id.'.jpg';
        file_put_contents($filepath,$data);

        $img=Image::make($filepath);

        return Response::json([
          'respuesta'=>true
        ]);

      }else{

        return Response::json([
          'respuesta'=>false
        ]);

      }*/

      return Response::json([
        'respuesta'=>true
      ]);
    }
    //test

    public function postDescargarconstancia()
    {

      ini_set('max_execution_time', 300);

      $json = Input::all();

    	$id = $json['servicio_id'];

    	$servicio = Servicio::find($id);

      $filepath = "biblioteca_imagenes/firmas_servicios/".'firma_'.$servicio->id.'.png';

      /*
      if ($servicio->imagen_recortada==null) {

        //Si el archivo existe recortarla
        if (file_exists($filepath)) {

          //Obtener imagen con la clase Image y metodo make()
          $img = Image::make($filepath);

          //Recortar la imagen, eliminar los espacios en blanco, eliminar el color negro que se genere a la derecha y rotarla -90 grados.
          $img->trim()->crop(500, 500, 0)->rotate(-90)->trim('black', ['left'])->save($filepath);

          //Guardar en la base de datos el campo como 1 para especificar que la imagen fue recortada y no utilizar el metodo de nuevo.
          $servicio->imagen_recortada = 1;

          //Guardar
          $servicio->save();

        }

      }*/

      $view = View::make('servicios.plantilla_constancia_vieja')->with([
        'servicio' => $servicio,
        'filepath' => $filepath
      ])->render();

    	$view = preg_replace('/>\s+</', '><', $view);

    	$pdf = PDF::load($view, 'A4', 'portrait')->output();

    	return Response::json([
    		'response' => true,
    		'pdf' => base64_encode($pdf),
    		'option' => 3
    	]);

    }

    public function postNovedadesapp()
    {

      $data = Input::all();

      $novedad_app = new Novedadapp();

      if ($data['tipo_novedad']==1) {

        $novedad_app->tipo_novedad = $data['tipo_novedad'];
        $novedad_app->detalles = $data['detalles'];
        $novedad_app->servicio_id = $data['servicio_id'];
        $novedad_app->user_id = $data['user_id'];

      }else if ($data['tipo_novedad']==2) {

        $novedad_app->tipo_novedad = $data['tipo_novedad'];

        $detalles = Input::get('dias_disposicion').','.Input::get('horas_disposicion').','.Input::get('minutos_disposicion');

        $novedad_app->detalles = $detalles;
        $novedad_app->servicio_id = $data['servicio_id'];
        $novedad_app->user_id = $data['user_id'];

      }else if ($data['tipo_novedad']==3) {

        $novedad_app->tipo_novedad = $data['tipo_novedad'];

        $detalles = $data['detalles'].'&/()'.Input::get('horas_disposicion').','.Input::get('minutos_disposicion');

        $novedad_app->detalles = $detalles;
        $novedad_app->servicio_id = $data['servicio_id'];
        $novedad_app->user_id = $data['user_id'];

      }else if ($data['tipo_novedad']==4) {

        $novedad_app->tipo_novedad = $data['tipo_novedad'];
        $novedad_app->detalles = $data['detalles'];
        $novedad_app->servicio_id = $data['servicio_id'];
        $novedad_app->user_id = $data['user_id'];

      }else if ($data['tipo_novedad']==5) {

        $novedad_app->tipo_novedad = $data['tipo_novedad'];
        $novedad_app->detalles = $data['detalles'];
        $novedad_app->servicio_id = $data['servicio_id'];
        $novedad_app->user_id = $data['user_id'];

      }

      $facturacion = Facturacion::where('servicio_id', $data['servicio_id'])->first();

      if (count($facturacion)) {

        return Response::json([
          'response' => false
        ]);

      }else {

        if ($novedad_app->save()) {

          return Response::json([
            'response' => true,
            'novedad_app' => $novedad_app
          ]);

        }

      }

    }

    public function postCargarnovedades()
    {

      $novedad_app = Novedadapp::where('servicio_id', Input::get('servicio_id'))->get();

      if ($novedad_app) {

        return Response::json([
          'response' => true,
          'novedad_app' => $novedad_app
        ]);

      }

    }

    public function postEliminarnovedad()
    {

      $novedad_id = Input::get('novedad_id');

      $novedad_app = Novedadapp::find($novedad_id);

      if ($novedad_app->delete()) {

        return Response::json([
          'response' => true
        ]);

      }

    }

    /*MÉTODOS NUEVOS*/

    public function postServiciospendientes()
    {

      $id_usuario = intval(Input::get('id_usuario'));

      $id_conductor = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->pluck('id');

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      //$horalimite = date('H:i',strtotime('+59 minute',strtotime($servicio->hora_servicio)));
      $diasiguiente = strtotime ('+1 day', strtotime($fecha));
      $diasiguiente = date('Y-m-d' , $diasiguiente);

      $consulta = "SELECT servicios.*, reconfirmacion.reconfirmacion2hrs, centrosdecosto.razonsocial as razonsocial, subcentrosdecosto.nombresubcentro as subcentro, nombre_ruta.nombre as nombreruta FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join subcentrosdecosto on subcentrosdecosto.id = servicios.subcentrodecosto_id left join nombre_ruta on nombre_ruta.id = servicios.ruta_nombre_id left join reconfirmacion on reconfirmacion.id_servicio = servicios.id WHERE `conductor_id` = ".$id_conductor." AND servicios.fecha_servicio between '".$diaanterior."' and '".$diasiguiente."' AND (servicios.estado_servicio_app IS NULL OR servicios.estado_servicio_app <> 2) and servicios.aceptado_app = 1 and servicios.pendiente_autori_eliminacion is null order by servicios.fecha_servicio asc, servicios.hora_servicio asc";
      /*$consulta = "SELECT serv.* FROM servicios as serv left join reconfirmacion as reconf ON reconf.id_servicio = serv.id WHERE serv.conductor_id = ".$id_conductor.
      " AND serv.fecha_servicio BETWEEN '".$fecha."' AND '".$fecha.
      "' AND (serv.estado_servicio_app IS NULL OR serv.estado_servicio_app <> 2) and (reconf.ejecutado IS NULL or reconf.ejecutado = '0') order by serv.fecha_servicio";*/

      $servicios = DB::select($consulta);

      /*$servicios = DB::table('servicios')
      ->where('conductor_id', $id_conductor)
      ->whereBetween('fecha_servicio', [$diaanterior, $fecha])
      ->Where('estado_servicio_app', null)
      ->orwhere('estado_servicio_app','<>',2)
      ->get();*/

      $servicio_activo = DB::table('servicios')
      ->where('conductor_id', $id_conductor)
      ->whereBetween('fecha_servicio', [$diaanterior, $diasiguiente])
      ->where('estado_servicio_app',1)
      ->pluck('id');

      if ($servicios) {

        return Response::json([
            'respuesta' => true,
            'servicios' => $servicios,
            'servicio_activo' => $servicio_activo,
            'id_conductor' => $id_conductor,
            'id_usuario' => $id_usuario
        ]);

      }else{

        return Response::json([
            'respuesta' => false,
            'id_usuario' => $id_usuario
        ]);

      }
    }

    public function postServiciospendientesporaceptar()
    {

      $id_usuario = intval(Input::get('id_usuario'));

      $conductor_id = Conductor::where('usuario_id', $id_usuario)->pluck('id');

      /*
      $id_conductor = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->pluck('id');*/

      $fecha = date('Y-m-d');
      $diaanterior = strtotime('-1 day', strtotime($fecha));
      $diaanterior = date('Y-m-d' , $diaanterior);

      $diasiguiente = strtotime('1 day', strtotime($fecha));
      $diasiguiente = date('Y-m-d' , $diasiguiente);

      /*$consulta = "SELECT servicios.*, timestampdiff(minute, date_sub(now(), interval 3 hour), CONCAT(fecha_servicio,' ',hora_servicio)) > 1 as fecha, centrosdecosto.razonsocial as razonsocial, subcentrosdecosto.nombresubcentro FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join subcentrosdecosto on servicios.subcentrodecosto_id = subcentrosdecosto.id WHERE `conductor_id` = ".$conductor_id." AND (aceptado_app = 0 or aceptado_app is null) AND pendiente_autori_eliminacion is null AND TIMESTAMPDIFF(MINUTE, date_sub(now(), interval 3 hour), CONCAT(fecha_servicio,' ',hora_servicio)) > 1 ORDER BY fecha_servicio ASC, hora_servicio ASC limit 10";*/

      $consulta = "SELECT servicios.id, servicios.fecha_servicio, servicios.hora_servicio, servicios.recoger_en, servicios.dejar_en, servicios.detalle_recorrido, servicios.pasajeros, servicios.pendiente_autori_eliminacion, servicios.aceptado_app, servicios.ruta, centrosdecosto.razonsocial, subcentrosdecosto.nombresubcentro FROM servicios LEFT JOIN centrosdecosto ON centrosdecosto.id = servicios.centrodecosto_id LEFT JOIN subcentrosdecosto ON subcentrosdecosto.id = servicios.subcentrodecosto_id WHERE `conductor_id` = ".$conductor_id." AND (servicios.aceptado_app IS NULL OR servicios.aceptado_app = 0) AND servicios.fecha_servicio BETWEEN '".$diaanterior."' AND '".$diasiguiente."' AND pendiente_autori_eliminacion IS NULL ORDER BY servicios.fecha_servicio ASC, servicios.hora_servicio ASC LIMIT 10";

      $servicios = DB::select($consulta);

      if ($servicios) {

        return Response::json([
            'respuesta' => true,
            'servicios' => $servicios,
            'id_conductor' => $conductor_id,
            'id_usuario' => $id_usuario
        ]);

      }else{

        return Response::json([
            'respuesta' => false,
            'consulta' => $consulta,
            'id_usuario' => $id_usuario,
            'id_conductor' => $conductor_id,
            //'email' => Input::get('name'),
            //'pass' => Input::get('pass'),
        ]);

      }

    }

    public function postIniciarserviciov3()
    {

      $data = file_get_contents('php://input');

      $var = json_decode($data);
      //$lat = $var->location->coords->latitude; ok

      //$id_servicio = $var->myParams->id_servicio; ok

      //$obj = json_decode($data);

      //$latitude = $data->location->coords->latitude;

      //new
      $id = $var->myParams->id_servicio;

      //$latitude =  substr($var->location->coords->latitude, 0, 10);
      //$longitude = substr($var->location->coords->longitude, 0, 10);
      //$speed = substr($var->location->coords->speed, 0, 10);
      //$odometro = $var->location->odometer;

      $latitude =  $var->location->coords->latitude;
      $longitude = $var->location->coords->longitude;
      $speed = $var->location->coords->speed;
      $odometro = $var->location->odometer;

      //Objeto array json
      $objArray = null;

      //Array a insertar en json
      $array = [
        'latitude' => $latitude,
        'longitude' => $longitude,
        'speed' => $speed,
        'odometro' => $odometro,
        'timestamp' => date('Y-m-d H:i:s')
      ];

      //Busqueda del servicio a guardar coordenadas
      $servicio = Servicio::find($id);

      if ($servicio->recorrido_gps===null) {

          if ($servicio->app_user_id!=null) {

            $message = 'El servicio para recoger en: '.$servicio->recoger_en.', y dejar en: '.$servicio->dejar_en.' de las '.$servicio->hora_servicio.' horas esta disponible para seguimiento.';

            $number_random = rand(1000000, 9999999);

            $data = [
              'message' => $message,
              'body' => $message,
              'title' => 'Aotour Mobile',
              'notId' => $number_random,
              'vibrationPattern' => [2000, 1000, 500, 500],
              'soundname' => 'default',
              'subtitle' => 'Servicio programado'
            ];

            //Notificacion de que el servicio esta disponible para poder realizar el seguimiento desde el cliente
            Servicio::notificacionData($servicio->app_user_id, $data);

          }

          $servicio->recorrido_gps = json_encode([$array]);

      }else{

        $objArray = json_decode($servicio->recorrido_gps);
        array_push($objArray, $array);
        $servicio->recorrido_gps = json_encode($objArray);

      }

      if ($servicio->save()) {

          if ($servicio->tracking_cliente==1) {

            if ($servicio->app_user_id!=null) {

              $user_id = $servicio->app_user_id;

              $channel = 'aotour_mobile_client_user_'.$user_id;
              $name = 'servicio_activo';

              $data = json_encode([
                'ultima_ubicacion' => [
                  'latitude' => $latitude,
                  'longitude' => $longitude,
                ],
                'servicio_id' => $id,
                'estado_servicio_app' => $servicio->estado_servicio_app
              ]);

              Servicio::enviarNotificacionPusher($channel, $name, $data);

            }

          }

      }
      //new

      

      $user = DB::table('users')
      ->where('id',2)
      ->update([
        'prueba' => $data,
        'nombre_completo' => 'samuel'
      ]);

    }

    public function postIniciarserviciov2()
    {

      //$arrayidc = explode('-',$id);

      //$id = $arrayidc[0];
      //ID del servicio
      $id = Input::get('id_servicio');

      //$json = Input::all();

      //$latitude = $lat;//$json[0];
      //$longitude = $lat;//$json[1];

      //Coordenadas enviadas por el conductor
      $latitude =  substr(Input::get('latitude'), 0, 10);
      $longitude = substr(Input::get('longitude'), 0, 10);
      $speed = substr((Input::get('speed'))*3.6, 0, 8);
      //$odometro = Input::get('odometro');

      //Objeto array json
      $objArray = null;

      //Array a insertar en json
      $array = [
        'latitude' => $latitude,
        'longitude' => $longitude,
        'speed' => $speed,
        'timestamp' => date('Y-m-d H:i:s')
      ];

      //Busqueda del servicio a guardar coordenadas
      $servicio = Servicio::find($id);

      if ($servicio->recorrido_gps===null) {

          if ($servicio->app_user_id!=null) {

            $message = 'El servicio para recoger en: '.$servicio->recoger_en.', y dejar en: '.$servicio->dejar_en.' de las '.$servicio->hora_servicio.' horas esta disponible para seguimiento.';

            $number_random = rand(1000000, 9999999);

            $data = [
              'message' => $message,
              'body' => $message,
              'title' => 'Aotour Mobile',
              'notId' => $number_random,
              'vibrationPattern' => [2000, 1000, 500, 500],
              'soundname' => 'default',
              'subtitle' => 'Servicio programado'
            ];

            //Notificacion de que el servicio esta disponible para poder realizar el seguimiento desde el cliente
            Servicio::notificacionData($servicio->app_user_id, $data);

          }

          $servicio->recorrido_gps = json_encode([$array]);

      }else{

        $objArray = json_decode($servicio->recorrido_gps);
        array_push($objArray, $array);
        $servicio->recorrido_gps = json_encode($objArray);

      }

      if ($servicio->save()) {

          if ($servicio->tracking_cliente==1) {

            if ($servicio->app_user_id!=null) {

              $user_id = $servicio->app_user_id;

            	$channel = 'aotour_mobile_client_user_'.$user_id;
            	$name = 'servicio_activo';

              $data = json_encode([
                'ultima_ubicacion' => [
                  'latitude' => $latitude,
                  'longitude' => $longitude,
                ],
                'servicio_id' => $id,
                'estado_servicio_app' => $servicio->estado_servicio_app
              ]);

          		Servicio::enviarNotificacionPusher($channel, $name, $data);

            }

          }

          return Response::json([
            'respuesta'=>true,
            'cc'=>$servicio->centrodecosto_id
          ]);

      }

    }

    public function postActualizardatos(){

      $conductor = DB::table('conductores')
      ->where('usuario_id', Input::get('id_usuario'))
      ->first();

      if($conductor){

        return Response::json([
          'respuesta' => true,
          'conductor' => $conductor,
          'id_usuario' => Input::get('id_usuario'),
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'conductor' => $conductor,
          'id_usuario' => Input::get('id_usuario'),
        ]);

      }

    }

    public function postConsultafuec3()
    {

      $id_usuario = intval(Input::get('id_usuario'));

      $conductor_id = Conductor::where('usuario_id', $id_usuario)->pluck('id');

      $fecha = date('Y-m-d');

      $consulta = "SELECT distinct contratante, contratos.id FROM contratos left join fuec on fuec.contrato_id = contratos.id WHERE '".$fecha."' BETWEEN DATE(fuec.created_at) AND fecha_final AND FIND_IN_SET('".$conductor_id."', conductor) > 0 ";

      $fuec = DB::select($consulta);

      if ($fuec) {

        return Response::json([
          'respuesta' => true,
          'fuec' => $fuec,
          'id_conductor' => $conductor_id,
          'consulta' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'fuec' => $fuec,
          'consulta' => $consulta
        ]);

      }
    }

    public function postConsultafueccliente()
    {

      $id_usuario = intval(Input::get('id_usuario'));
      $contratante = Input::get('id');

      $conductor_id = Conductor::where('usuario_id', $id_usuario)->pluck('id');

      $fecha = date('Y-m-d');

      $consulta = "SELECT fuec.*, contratos.contratante, rutas_fuec.origen, rutas_fuec.destino FROM fuec left join contratos on contratos.id = fuec.contrato_id left join rutas_fuec on rutas_fuec.id = fuec.ruta_id WHERE contrato_id = ".$contratante." and '".$fecha."' BETWEEN DATE(fuec.created_at) AND fecha_final AND FIND_IN_SET('".$conductor_id."', conductor) > 0 ORDER BY id DESC";

      $fuec = DB::select($consulta);

      if ($fuec) {

        return Response::json([
          'respuesta' => true,
          'fuec' => $fuec,
          'id_conductor' => $conductor_id,
          'consulta' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'fuec' => $fuec,
          'consulta' => $consulta
        ]);

      }
    }

    public function postConsultafuec2()
    {

      $id_usuario = intval(Input::get('id_usuario'));

      $conductor_id = Conductor::where('usuario_id', $id_usuario)->pluck('id');

      $fecha = date('Y-m-d');

      $consulta = "SELECT fuec.*, contratos.contratante, rutas_fuec.origen, rutas_fuec.destino FROM fuec left join contratos on contratos.id = fuec.contrato_id left join rutas_fuec on rutas_fuec.id = fuec.ruta_id WHERE '".$fecha."' BETWEEN DATE(fuec.created_at) AND fecha_final AND FIND_IN_SET('".$conductor_id."', conductor) > 0 ORDER BY id DESC";

      $fuec = DB::select($consulta);

      if ($fuec) {

        return Response::json([
          'respuesta' => true,
          'fuec' => $fuec,
          'id_conductor' => $conductor_id,
          'consulta' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'fuec' => $fuec,
          'consulta' => $consulta
        ]);

      }
    }

    public function postExportarfuecpdfv2(){

      ini_set('max_execution_time', 300);

      //$json = Input::all();

      //$id = $json['id'];
      $id = Input::get('id');

      $fuec = DB::table('fuec')
      ->select('contratos.numero_contrato','fuec.consecutivo', 'fuec.cantidad_descargas', 'fuec.id','contratos.contratante','contratos.nit_contratante','contratos.cliente','contratos.representante_legal',
      'contratos.cc_representante','contratos.telefono_representante','contratos.direccion_representante', 'vehiculos.ano as vehiculo_ano',
      'fuec.objeto_contrato','fuec.ano','rutas_fuec.ruta as descripcion_ruta','rutas_fuec.origen','rutas_fuec.destino','fuec.fecha_inicial','fuec.fecha_final',
      'vehiculos.placa','vehiculos.modelo','vehiculos.modelo','vehiculos.marca','vehiculos.clase','vehiculos.numero_interno','vehiculos.tarjeta_operacion',
      'fuec.conductor','vehiculos.empresa_afiliada','fuec.colegio')
      ->leftJoin('vehiculos','fuec.vehiculo','=','vehiculos.id')
      ->leftJoin('contratos','fuec.contrato_id','=','contratos.id')
      ->leftJoin('rutas_fuec','fuec.ruta_id','=','rutas_fuec.id')
      ->where('fuec.id',$id)
      ->first();

      $cantidad = Fuec::find($id);
      if($cantidad->cantidad_descargas==null){
        $cantidad->cantidad_descargas = 1;
      }else{
        $cantidad->cantidad_descargas = intval($cantidad->cantidad_descargas) + 1;
      }

      if (is_null($cantidad->jsonIP)){

        $arrayIP = [];

        array_push($arrayIP, [
          'IP' => Methods::getRealIpAddr(),
          'USER_AGENT' => 'AOTOUR MOBILE DRIVER',
          'TIME' => date('Y-m-d H:i:s')
        ]);

        $cantidad->jsonIP = json_encode($arrayIP);

      }else{

        $arrayIP = json_decode($cantidad->jsonIP);

        array_push($arrayIP, [
          'IP' => Methods::getRealIpAddr(),
          'USER_AGENT' => 'AOTOUR MOBILE DRIVER',
          'TIME' => date('Y-m-d H:i:s')
        ]);

        $cantidad->jsonIP = json_encode($arrayIP);
      }

      $cantidad->save();

      $arrayidc = explode(',',$fuec->conductor);

      $view = View::make('fuec.pdf_fuec')->with([
          'fuec' => $fuec,
          'arrayidc' => $arrayidc,
          'numero_encriptado' => $fuec->id
      ])->render();

      $view = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $view);
      //$view = preg_replace('/>\s+</', '><', $view);

      $pdf = PDF::load($view, 'Legal', 'portrait')->output();

      return Response::json([
        'response' => true,
        'pdf' => base64_encode($pdf),
        'option' => 3
      ]);
    }

    public function postFotos(){


      $id_image = Input::get('image');
      $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$id_image));

      $id_usuario = intval(Input::get('id_usuario'));

      return Response::json([
        'respuesta' => true,
        'id_usuario' => $id_usuario,
        'img' => $data
      ]);

    }

    public function postNovedadesappv2()
    {
      $tipo_novedad = Input::get('tipo_novedad');
      $id_servicio = Input::get('servicio_id');
      $user = Input::get('user_id');
      $detalles = Input::get('detalles');

      $novedad_app = new Novedadapp();

      $novedadApp = '';

      if ($tipo_novedad==1) {

        $novedad_app->tipo_novedad = $tipo_novedad;
        $novedad_app->detalles = $detalles;
        $novedad_app->servicio_id = $id_servicio;
        $novedad_app->user_id = $user;

        $novedadApp = 'Parada Adicional';

      }else if ($tipo_novedad==2) {

        $novedad_app->tipo_novedad = $tipo_novedad;
        $novedad_app->detalles = $detalles;
        $novedad_app->servicio_id = $id_servicio;
        $novedad_app->user_id = $user;

        $novedadApp = 'Tiempo de Espera';

      }else if ($tipo_novedad==3) {

        $novedad_app->tipo_novedad = $tipo_novedad;
        $novedad_app->detalles = $detalles;
        $novedad_app->servicio_id = $id_servicio;
        $novedad_app->user_id = $user;

        $novedadApp = 'Parada Adicional y Tiempo de Espera';

      }else if ($tipo_novedad==4) {

        $novedad_app->tipo_novedad = $tipo_novedad;
        $novedad_app->detalles = $detalles;
        $novedad_app->servicio_id = $id_servicio;
        $novedad_app->user_id = $user;

        $novedadApp = 'No Show';

      }else if ($tipo_novedad==5) {

        $novedad_app->tipo_novedad = $tipo_novedad;
        $novedad_app->detalles = $detalles;
        $novedad_app->servicio_id = $id_servicio;
        $novedad_app->user_id = $user;

        $novedadApp = 'Otros';

      }

      $facturacion = Facturacion::where('servicio_id', $id_servicio)->first();

      if (count($facturacion)) {

        return Response::json([
          'response' => false
        ]);

      }else {

        if ($novedad_app->save()) {

          //if($user==483){

            $queryServicio = Servicio::find($id_servicio);

            if($queryServicio->localidad!=null){ //Bogotá
              $email = 'transportebogota@aotour.com.co';
            }else{ //Barranquilla
              $email = 'transportebarranquilla@aotour.com.co';
            }

            $conductor = DB::table('conductores')
            ->where('id',$queryServicio->conductor_id)
            ->pluck('nombre_completo');

            $data = [
              'novedad' => $novedadApp,
              'servicio' => $id_servicio,
              'fecha' => $queryServicio->fecha_servicio,
              'dejar_en' => $queryServicio->dejar_en,
              'conductor' => $conductor
            ];

            Mail::send('emails.novedad', $data, function($message) use ($email){
              $message->from('no-reply@aotour.com.co', 'AUTONET');
              $message->to($email)->subject('Novedad de Servicio');
              $message->cc('aotourdeveloper@gmail.com');
            });

            //WhatsApp

            $nombreConductor = DB::table('conductores')->where('id',$queryServicio->conductor_id)->pluck('nombre_completo');
            $fecha = $queryServicio->fecha_servicio;
            $dejarEn = $queryServicio->dejar_en;
            $cliente = DB::table('centrosdecosto')->where('id',$queryServicio->centrodecosto_id)->pluck('razonsocial');
            $novedad = $novedadApp;

            if($queryServicio->localidad!=null){ //Bogotá
              $numero = 3012633287;
            }else{ //Barranquilla
              $numero = 3012030290;
            }

            $number = '57'.$numero; //Concatenación del indicativo con el número

            $number = intval($number);

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
                \"name\": \"novedades_servicios\",
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
                    \"text\": \"".$fecha."\",
                  },
                  {
                    \"type\": \"text\",
                    \"text\": \"".$dejarEn."\",
                  },
                  {
                    \"type\": \"text\",
                    \"text\": \"".$cliente."\",
                  },
                  {
                    \"type\": \"text\",
                    \"text\": \"".$novedad."\",
                  }]
                },
                {
                  \"type\": \"button\",
                  \"sub_type\": \"url\",
                  \"index\": \"0\",
                  \"parameters\": [{
                    \"type\": \"payload\",
                    \"payload\": \"".$queryServicio->id."\"
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
            //FIN ENVÍO DE RECONFIRMACIÓN AL USUARIO POR CORREO*/

          //}

          return Response::json([
            'response' => true,
            'novedad_app' => $novedad_app
          ]);

        }

      }

    }

    public function postChat(){

      $id = Input::get('id');

      $request = DB::table('messages')
      ->where('servicio_id',$id)
      ->pluck('message');

      return Response::json([
        'respuesta' => true,
        'mensajes' => $request,
        'id' => $id,
        'request' => $request
      ]);

    }

    public function postMensaje(){

      $id = 413088;
      $id = Input::get('id');
      $mensaje = Input::get('texto');
      $numero = Input::get('numero');
      $conductor = Input::get('conductor');

      if($numero==0){
        $mensajeEn = $mensaje;
      }elseif($numero==1){
        $mensajeEn = 'Hello. I am your driver '.$conductor.'. I am at the pick up point.';
      }else if($numero==2){
        $mensajeEn = 'Hello. I am your driver '.$conductor.'. I will be at the pickup point in 15 minutes.';
      }else if($numero==3){
        $mensajeEn = 'Hello. I am your driver '.$conductor.'. I will be at the pick up point in 5 minutes.';
      }else if($numero==4){
        $mensajeEn = 'Hello. I am your driver '.$conductor.'. I am in terminal 1.';
      }else if($numero==5){
        $mensajeEn = 'Hello. I am your driver '.$conductor.'. I am in terminal 2.';
      }else if($numero==6){
        $mensajeEn = 'Hello. I am your driver '.$conductor.'. I am going to the pick up point.';
      }else if($numero==7){
        $mensajeEn = 'Hello. I am your driver '.$conductor.'. This is message 7.';
      }else if($numero==8){
        $mensajeEn = 'Hello. I am your driver '.$conductor.'. This is message 8.';
      }else if($numero==9){
        $mensajeEn = 'Hello. I am your driver '.$conductor.'. This is message 9.';
      }else if($numero==10){
        $mensajeEn = 'Hello. I am your driver '.$conductor.'. This is message 10.';
      }else if($numero==11){
        $mensajeEn = 'Hello. I am your driver '.$conductor.'. This is message 11.';
      }else if($numero==12){
        $mensajeEn = 'Hello. I am your driver '.$conductor.'. This is message 12.';
      }else if($numero==13){
        $mensajeEn = 'Hello. I am your driver '.$conductor.'. This is message 13.';
      }

      $cambios = DB::table('messages')
      ->where('servicio_id',$id)
      ->pluck('message');

      $array = null;

      $array = [
        'usuario' => 2,
        'mensaje' => strtoupper($mensaje),
        'time' => date('H:i:s'),
        'date' => date('Y-m-d'),
      ];

      //Spanish
      if($cambios!=null){
        $objArray = json_decode($cambios);
        array_push($objArray, $array);
        $data = json_encode($objArray);
      }else{
        $data = json_encode([$array]);
      }

      //INGLÉS
      $cambiosEn = DB::table('messages')
      ->where('servicio_id',$id)
      ->pluck('messageEn');

      $arrayEn = null;

      $arrayEn = [
        'usuario' => 2,
        'mensaje' => strtoupper($mensajeEn),
        'time' => date('H:i:s'),
        'date' => date('Y-m-d'),
      ];

      if($cambiosEn!=null){
        $objArrayEn = json_decode($cambiosEn);
        array_push($objArrayEn, $arrayEn);
        $dataEn = json_encode($objArrayEn);
      }else{
        $dataEn = json_encode([$arrayEn]);
      }

      $correccion = DB::table('messages')
      ->where('id', 1)
      ->update([
        'message' => $data,
        'messageEn' => $dataEn,
      ]);

      /*Código pusher*/
      /*NOTIFIVACIÓN PUSHER*/
      //Pusher
      $idpusher = "578229";
      $keypusher = "a8962410987941f477a1";
      $secretpusher = "6a73b30cfd22bc7ac574";

      //CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
      $channel = strval($id);
      $name = 'messages';

      $info = '1';

      $motivo = DB::table('messages')
      ->where('id',1)
      ->pluck('messageEn');

      $data = json_encode([
        'info' => $info,
        'motivo' => $motivo
      ]);

      $app_id = $idpusher;
      $key = $keypusher;
      $secret = $secretpusher;

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

      curl_setopt($ch, CURLOPT_POST, true);

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

      $headers = [
      'Content-Type: application/json'
      ];

      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

      $result = curl_exec($ch);

      $mensajes = DB::table('messages')
      ->where('servicio_id',$id)
      ->pluck('message');

      return Response::json([
        'respuesta' => true,
        'mensajes' => json_decode($mensajes)
      ]);
      /* FIN NOTIFICACIÓN PUSHER*/

    }

    public function postBuscarproveedor(){

      $id = Input::get('id');
      $busqueda = DB::table('proveedores')
      ->where('id',$id)
      ->first();

      if($busqueda!=null){

        return Response::json([
          'respuesta' => true,
          'proveedor' => $busqueda
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postDisponibilidad(){

      $id = Input::get('id');
      
      $inicio_fecha = Input::get('inicio_fecha');
      $inicio_hora = Input::get('inicio_hora');
      $fin_fecha = Input::get('fin_fecha');
      $fin_hora = Input::get('fin_hora');

      $busqueda = DB::table('conductores')
      ->where('id',$id)
      ->update([
        'inicio_fecha' => $inicio_fecha,
        'inicio_hora' => $inicio_hora,
        'fin_fecha' => $fin_fecha,
        'fin_hora' => $fin_hora
      ]);

      if($busqueda){

        return Response::json([
          'respuesta' => true,
          'disponibilidad' => $busqueda
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    //SCANEO QR DESDE LISTA WAA VERSIÓN
    public function postScaneodeqr(){

        $code=Input::get('codigo');

        $id_servicio=Input::get('id_servicio');

        $estado = DB::table('qr_rutas')
        ->where('servicio_id',$id_servicio)
        ->where('code',$code)
        ->pluck('status');

        if($estado==1){

          return Response::json([
            'escaneado'=>false
          ]);

        }else{

          $estado=DB::table('qr_rutas')
          ->where('servicio_id',$id_servicio)
          ->where('code',$code)
          ->update([
            'status'=>1
          ]);

          $consulta = "SELECT qr_rutas.id_usuario, qr_rutas.fullname as nombres, qr_rutas.fecha, qr_rutas.hora, qr_rutas.address as direccion, qr_rutas.locality as localidad, qr_rutas.neighborhood as barrio, qr_rutas.vehiculo as id_rutaqr FROM qr_rutas WHERE qr_rutas.servicio_id='$id_servicio' AND qr_rutas.code='$code'";

          $usuarios = DB::select($consulta);

          if (count($usuarios)){
            return Response::json([
              'respuesta'=>true,
              'usuarios'=>$usuarios,
            ]);
          }else{
            return Response::json([
              'respuesta'=>false
            ]);
          }

        } //FIN SI
    }
    //FIN SCANEO QR DESDE LISTA V2

    public function postNorecogido() {

      $id = Input::get('id');
      $motivo = Input::get('motivo');
      $servicio = Input::get('servicio');

      $update = DB::table('qr_rutas')
      ->where('servicio_id',$servicio)
      ->where('id_usuario',$id)
      ->update([
        'id_rutaqr' => $motivo
      ]);

      $pasajeros = DB::table('servicios')
      ->where('id',$servicio)
      ->pluck('pasajeros_ruta');

      $objArray = null;
      $array = null;

      $json = json_decode($pasajeros);

      $sw=1;

      if(is_array($json)){

        foreach ($json as $key => $value) {

          if( $value->apellidos==$id ) {
            $updates = $motivo;
          }else{
            $updates = $value->area;
          }

          $array = [
            'nombres' => $value->nombres,
            'apellidos' => $value->apellidos,
            'cedula' => $value->cedula,
            'direccion' => $value->direccion,
            'barrio' => $value->barrio,
            'cargo' => $value->cargo,
            'area' => $updates,
            'sub_area' => $value->sub_area,
            'hora' => $value->hora
          ];

          if($sw==1) {
            $data = json_encode([$array]);
            //array_push($objArray, $array);
          }else{

            $pass = DB::table('servicios')
            ->where('id',$servicio)
            ->pluck('pasajeros_ruta');

            $objArray = json_decode($pass);
            array_push($objArray, $array);
            $data = json_encode($objArray);

            //$data = json_encode($objArray);
            //array_push($objArray, $array);

          }

          $actualizar = DB::table('servicios')
          ->where('id',$servicio)
          ->update([
            'pasajeros_ruta' => $data
          ]);

          $sw++;
          //$data = json_encode([$array]);

          //array_push($objArray, $array);

        }

      }

      if($update) {

        return Response::json([
          'response' => true,
          'objArray' => $objArray
        ]);

      }


    }

    public function postDejarpasajeroruta(){

      $employ_id = Input::get('id_pasajero');
      $servicio_id = Input::get('id_servicio');

      $pasajero_location = json_encode([
        'latitude' => Input::get('latitude'),
        'longitude' => Input::get('longitude'),
        'timestamp' => date('Y-m-d H:i:s')
      ]);

      $query = DB::table('qr_rutas')
      ->where('servicio_id', $servicio_id)
      ->where('id_usuario', $employ_id)
      ->update([
        'location' => $pasajero_location
      ]);

      if($query){

        return Response::json([
          'response' => true
        ]);

      }else{

        return Response::json([
          'response' => false
        ]);

      }

    }

    public function postConsultarestado(){ //Consultar si el pasajero ya fue dejado en su ubicación

      $employ_id = Input::get('id_pasajero');
      $servicio_id = Input::get('id_servicio');

      $query = DB::table('qr_rutas')
      ->where('servicio_id', $servicio_id)
      ->where('id_usuario', $employ_id)
      ->pluck('location');

      if($query!=null){

        return Response::json([
          'response' => true
        ]);

      }else{

        return Response::json([
          'response' => false
        ]);

      }
      
    }

    public function postFinalizarviaje()
    {

      $id = Input::get('id_servicio');
      $servicio = Servicio::find($id);
      $servicio->estado_servicio_app = 2;
      $servicio->hora_finalizado = date('Y-m-d H:i:s');
      $servicio->calificacion_pasajero = Input::get('calificacionCalidad');

      if ($servicio->save()) {

        if($servicio->app_user_id!=null){
          $finalizarServicio = Servicio::ServicioFinalizado($id, $servicio->app_user_id);
        }

        return Response::json([
          'respuesta'=>true
        ]);

      }

    }

    public function postContactos()
    {

      $barranquilla_movil = DB::table('contactos')
      ->where('ciudad','BARRANQUILLA')
      ->where('tipo','movil')
      ->get();

      $barranquilla_email = DB::table('contactos')
      ->where('ciudad','BARRANQUILLA')
      ->where('tipo','email')
      ->get();

      $bogota_movil = DB::table('contactos')
      ->where('ciudad','BOGOTA')
      ->where('tipo','movil')
      ->get();

      $bogota_email = DB::table('contactos')
      ->where('ciudad','BOGOTA')
      ->where('tipo','email')
      ->get();
        
      return Response::json([
        'respuesta'=>true,
        'barranquilla_movil' => $barranquilla_movil,
        'barranquilla_email' => $barranquilla_email,
        'bogota_movil' => $bogota_movil,
        'bogota_email' => $bogota_email
      ]);

      

    }

    public function postMostrarcrear(){

      $id_usuario = Input::get('id_usuario');

      $conductor = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->first();

      $localidad = DB::table('proveedores')
      ->where('id',$conductor->proveedores_id)
      ->pluck('localidad'); //Saber de qué ciudad es el conductor, para mostrar las rutas de esa ciudad

      //Consulta de vehiculos que pueden ser usados por el conductor
      $vehiculos = DB::table('vehiculos')
      ->where('proveedores_id',$conductor->proveedores_id)
      ->whereNull('bloqueado')
      ->whereNull('bloqueado_total')
      ->get();

      //Consulta de rutas Fuec
      if($localidad=='barranquilla'){
        $dato1 = 'SANTA MARTA';
        $dato2 = 'CARTAGENA';
      }else{
        $dato1 = 'SOACHA';
        $dato2 = 'USME';
      }

      $query = "SELECT * FROM rutas_fuec WHERE origen LIKE '%".$localidad."%' OR destino LIKE '%".$localidad."%' OR destino LIKE '%".$dato1."%' OR origen LIKE '%".$dato1."%' OR destino LIKE '%".$dato2."%' OR origen LIKE '%".$dato2."%'";

      $rutas_fuec = DB::select($query);

      return Response::json([
        'respuesta' => true,
        'vehiculos' => $vehiculos,
        'rutas_fuec' => $rutas_fuec
      ]);


    }

    //listar clientes
    public function postListarclientesfuec(){

      $id_usuario = Input::get('id_usuario');

      $conductor = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->first();

      $localidad = DB::table('proveedores')
      ->where('id',$conductor->proveedores_id)
      ->pluck('localidad'); //Saber de qué ciudad es el conductor, para consultar los clientes

      //Consulta de clientes activos
      $clientes = DB::table('centrosdecosto')
      ->where('localidad',$localidad)
      ->whereNull('inactivo')
      ->whereNull('inactivo')
      ->get();

      return Response::json([
        'respuesta' => true,
        'clientes' => $clientes
      ]);

    }

    //Crear fuecs
    public function postCrearfuecs() {

      $vehiculo = Input::get('vehiculo'); //ID del vehículo seleccionado en el form
      $id_usuario = Input::get('id_usuario');

      $conductor = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->first(); //ID del conductor

      $arrayRutas = Input::get('rutas'); //Array de las rutas seleccionadas en el form
      $cliente = Input::get('cliente');

      $objeto_contrato = 'TRANSPORTE TERRESTRE DE PERSONAL EMPRESARIAL';

      $contrato = DB::table('contratos')
      ->where('centrodecosto_id', $cliente)
      ->first();

      for ($c=0; $c<count($arrayRutas); $c++) {

        //TODOS LOS REGISTROS Y SE TOMA EL ULTIMO REGISTRO GUARDADO
        $fuec_ultimo = Fuec::all();
        $ultimo = $fuec_ultimo->last();

        if ($ultimo!=null) {

          $ultimo_ano = intval($ultimo->ano);
          $ultimo = intval($ultimo->consecutivo);

        }else if($ultimo===null) {

          $ultimo = intval($ultimo);
          $ultimo_ano = 0;

        }

        $documentos = DB::table('vehiculos')
        ->where('id', $vehiculo)
        ->first();

        $date = date('Y-m-d');

        $ss = DB::table('seguridad_social')
        ->where('conductor_id',$conductor)
        ->where('fecha_inicial', '<=', $date)
        ->where('fecha_final', '>=', $date)
        ->orderBy('fecha_final', 'desc')
        ->first();

        if($ss!=null){
          $fecha_seguridad = $ss->fecha_final;
        }else{
          $fecha_seguridad = 0;
        }

        $soat = $documentos->fecha_vigencia_soat;
        $poliza_contractual = $documentos->poliza_contractual;
        $poliza_extracontractual = $documentos->poliza_extracontractual;
        $mantenimiento_preventivo = $documentos->mantenimiento_preventivo;
        $tecnomecanica = $documentos->fecha_vigencia_tecnomecanica;
        $tarjeta_operacion = $documentos->fecha_vigencia_operacion;

        $fecha_final = $soat;
        if($poliza_contractual<$fecha_final){
          $fecha_final = $poliza_contractual;
        }
        if($poliza_extracontractual<$fecha_final){
          $fecha_final = $poliza_extracontractual;
        }
        if($mantenimiento_preventivo<$fecha_final){
          $fecha_final = $mantenimiento_preventivo;
        }
        if($tecnomecanica<$fecha_final){
          $fecha_final = $tecnomecanica;
        }
        if($tarjeta_operacion<$fecha_final){
          $fecha_final = $tarjeta_operacion;
        }

        if($fecha_seguridad!=0){
          if($fecha_seguridad<$fecha_final){
            $fecha_final = $fecha_seguridad;
          }
        }

        //$fecha_final = $documentos->soat

        $fuec = new Fuec;
        $fuec->ano = date('Y');
        $fuec->contrato_id = $contrato->id;
        $fuec->ruta_id = $arrayRutas[$c];
        $fuec->objeto_contrato = $objeto_contrato;
        $fuec->fecha_inicial = date('Y-m-d');
        $fuec->fecha_final = $fecha_final;
        $fuec->proveedor = $proveedor_id;
        $fuec->vehiculo = $vehiculo;
        $fuec->conductor = $conductor;
        $fuec->creado_por = Sentry::getUser()->id;

        if ($fuec->save()) {

          $contador_fuec = $contador_fuec+1;
          //TOMAR ID PARA BUSCAR EL ULTIMO REGISTRO GUARDADO
          $id = $fuec->id;
          $ano = intval($fuec->ano);
          $f = Fuec::find($id);

          //SI ESTA VACIO ENTONCES ES IGUAL A CERO
          if ($ultimo===0 or (intval($ultimo_ano)!=intval($ano))) {
            $f->consecutivo = '0001';
          //SI NO ESTA VACIO ENTONCES
          }else if ($ultimo!=0){
            if (strlen($ultimo+1)===1) {
              $f->consecutivo = '000'.($ultimo+1);
            }else if (strlen($ultimo+1)===2) {
              $f->consecutivo = '00'.($ultimo+1);
            }else if (strlen($ultimo+1)===3) {
              $f->consecutivo = '0'.($ultimo+1);
            }else if (strlen($ultimo+1)===4) {
              $f->consecutivo = $ultimo+1;
            }
          }

          $f->save();
        }

      }

      return Response::json([
        'respuesta' => true
      ]);
        
    }

}
