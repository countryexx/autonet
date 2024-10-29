<?php
/**
 * Clase para gestión de aplicación móvil (VERSIÓN IONIC)
 */
class Apiv3Controller extends BaseController{

  public function postObtenerusuario()
  {

      $id_usuario = Input::get('id_usuario');

      $search = DB::table('users')
      ->where('id',$id_usuario)
      ->first();

      if($search->baneado==1){

        return Response::json([
            'respuesta' => 'login'
        ]);

      }else{

        return Response::json([
            'respuesta' => true,
            'usuario' => $search
        ]);

      }


  }

    public function postServiciossolicitados(){

      $user_id = Input::get('id');

      $user = User::find($user_id);

      if ($user->empresarial===1) {

        $servicios = Servicioaplicacion::where('user_id', $user_id)
        ->whereRaw('cancelado is null and programado is null')
        ->orderBy('fecha', 'asc')
        ->orderBy('hora', 'asc')
        ->get();

      }else {

        $servicios = Servicioaplicacion::where('user_id', $user_id)
        ->whereRaw('pago_servicio_id is not null and pago_facturacion is null and cancelado is null')
        ->orderBy('fecha', 'asc')
        ->orderBy('hora', 'asc')
        ->get();

      }

      if (count($servicios)) {

        return Response::json([
          'respuesta' => true,
          'servicios' => $servicios,
          'user_id' => $user_id
        ]);

      }else {

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postServiciosprogramados(){

      $user = User::find(Input::get('id'));

      $fechaActual = date('Y-m-d');
      $horaActual = date('H:i');

      $servicios = Servicio::whereNull('calificacion_app_cliente_calidad')
      ->whereNull('servicios.calificacion_app_cliente_actitud')
      ->where('app_user_id', $user->id)
      ->where('fecha_servicio', date('Y-m-d'))
      ->whereNull('pendiente_autori_eliminacion')
      ->whereNull('cancelado_app')
      ->where('fecha_servicio', '>=', $fechaActual)
      ->where('hora_servicio', '>=', $horaActual)
      ->orderBy('fecha_servicio')
      ->orderBy('hora_servicio')
      ->with(['conductor', 'vehiculo', 'servicioaplicacion'])
      ->get();

      if (count($servicios)) {

        return Response::json([
          'respuesta' => true,
          'servicios' => $servicios,
          'user_id' => $user->id
        ]);

      }else {

        return Response::json([
          'respuesta' => false,
          'servicios' => $servicios,
          'user_id' => $user->id
        ]);

      }

    }

    public function postBuscarprogramados(){

      $user = User::find(Input::get('id'));

      $fecha_servicio = Input::get('fecha');

      $fechas = explode(',', $fecha_servicio);

      $fechaActual = date('Y-m-d');
      $horaActual = date('H:i');

      $servicios = Servicio::whereIn('fecha_servicio', $fechas)
      ->where('app_user_id', $user->id)
      ->whereNull('calificacion_app_cliente_calidad')
      ->whereNull('servicios.calificacion_app_cliente_actitud')
      ->whereNull('pendiente_autori_eliminacion')
      ->whereNull('cancelado_app')
      ->where('fecha_servicio', '>=', $fechaActual)
      ->where('hora_servicio', '>=', $horaActual)
      ->orderBy('fecha_servicio')
      ->orderBy('hora_servicio')
      ->with(['conductor', 'vehiculo', 'servicioaplicacion'])
      ->get();

      if (count($servicios)) {

        return Response::json([
          'respuesta' => true,
          'servicios' => $servicios
        ]);

      }else {

        return Response::json([
          'respuesta' => false,
          'servicios' => $servicios
        ]);

      }

    }

    public function postBuscarhistorial(){

      $id = Input::get('id');
      $fecha = Input::get('fecha');

      $user = User::find($id);

      $servicios = Servicio::where('fecha_servicio', $fecha)
      ->where('app_user_id', $user->id)
      ->whereNull('pendiente_autori_eliminacion')
      ->orderBy('fecha_servicio')
      ->orderBy('hora_servicio')
      ->with(['conductor', 'vehiculo'])
      ->get();

      if (count($servicios)) {

        return Response::json([
            'response' => true,
            'servicios' => $servicios,
        ]);

      }else {

        return Response::json([
            'response' => false,
        ]);
      }

    }

    public function postCalificarservicio(){

      $servicio = Servicio::find(Input::get('id_servicio'));
      $servicio->calificacion_app_cliente_calidad = Input::get('valor_calificacion');
      $servicio->calificacion_app_cliente_actitud = Input::get('valor_calificacion_conductor');

      if ($servicio->save()) {

        return Response::json([
          'response' => true
        ]);

      }

    }

    public function postAddtoken(){

      $id = Input::get('id');
      $nombre = Input::get('nombre');
      $identificacion = Input::get('identificacion');
      $numero = Input::get('numero');
      $cvc = strval(Input::get('cvc'));
      $mes = strval(Input::get('mes'));
      $ano = strval(Input::get('ano'));

      $usuario = User::find($id);

      //$apiUrl = "https://sandbox.wompi.co/v1/tokens/cards"; //card prueba
      $apiUrl = "https://production.wompi.co/v1/tokens/cards"; //links de pago productivo

      $data = [
        "number" => strval($numero),
        "cvc" => $cvc,
        "exp_month" => $mes,
        "exp_year" => $ano,
        "card_holder" => $nombre
      ];

      $headers = [
        'Accept: application/json',
        //'Authorization: Bearer pub_test_9RD6zkd3C7iLZ1jzqnF00aSBp33t7dsk',
        'Authorization: Bearer pub_prod_k3EGLrTVqzDhXKogfQwL8PGo080sw5K0', //links productivo aotour
      ];

      $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      $result = curl_exec($ch);

      curl_close($ch);

      $result = json_decode($result);

      $switch=0;
      try {
        if($result->status==='CREATED'){
          $switch=0;
        }
      } catch (Exception $e) {
        $switch=1;
      }

      if($switch===0){

        //START OBTENCIÓN DE TOKEN DE ACEPTACIÓN
  			//$llave = 'pub_test_9RD6zkd3C7iLZ1jzqnF00aSBp33t7dsk'; //prueba SAMUEL
        $llave = 'pub_prod_k3EGLrTVqzDhXKogfQwL8PGo080sw5K0'; //producción AOTOUR
        $response = file_get_contents('https://production.wompi.co/v1/merchants/'.$llave.''); //prueba
  			$response = json_decode($response);
        $acceptance_token = $response->data->presigned_acceptance->acceptance_token;
  			//END OBTENCIÓN DE TOKEN DE ACEPTACIÓN

        //START FUENTE DE PAGO
        $token_tarjeta = $result->data->id;
        $apiUrlFuente = "https://production.wompi.co/v1/payment_sources"; //card prueba fuente de pago

  			$datas = [
          "type" => "CARD",
          "token" => $token_tarjeta,
          "customer_email" => $usuario->email,
          "acceptance_token" => $acceptance_token,
        ];

  			$headers = [
          'Accept: application/json',
          //'Authorization: Bearer prv_test_aZ1VdvKqmz91uyEBsiqQAuswY2ZSpFIl', //links pruebas samuel
          'Authorization: Bearer prv_prod_WJ9PkFir6uPwOPwstzfI8LsfPPedpRda', //links productivo aotour
        ];
        $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $apiUrlFuente);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datas));
        $resultados = curl_exec($ch);
  			$resultados = json_decode($resultados);
  			$id_fuente_pago = $resultados->data->id;
  			// START CREACIÓN DE FUENTE DE PAGO
        //START FUENTE DE PAGO

        $expiration = $result->data->exp_year.'/'.$result->data->exp_month;

        $token = new TokenPayU;
        $token->creditCardTokenId = $result->data->id;
        $token->fuente_pago = $id_fuente_pago;
        $token->identificationNumber = $identificacion;
        $token->paymentMethod = $result->data->brand;
        $token->maskedNumber = $result->data->bin.'*****'.$result->data->last_four;
        $token->lastFour = $result->data->last_four;
        $token->name = strtoupper($result->data->card_holder);
        $token->expirationDate = $expiration;
        $token->payerId = $id;
        $token->valido = 1;
        $token->save();

        return Response::json([
            'respuesta' => true,
            'token_card' => $result
        ]);

      }else{

        return Response::json([
            'respuesta' => false,
            'token_card' => $result
        ]);

      }

    }

    public function postBuscartokens(){

      $id = Input::get('id');

      $consulta = DB::table('tokens_payu')
      ->where('payerId',$id)
      ->get();

      if($consulta){

        return Response::json([
          'respuesta' => true,
          'tokens' => $consulta
        ]);
      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }
    }

    public function postEliminartoken(){

      $id = Input::get('id');
      $token_id = Input::get('id_token');

      $consulta = DB::table('tokens_payu')
      ->where('id',$token_id)
      ->delete();

      return Response::json([
        'respuesta' => true
      ]);
    }

    public function postConsultartarjetas(){

      $id = Input::get('id');

      $consulta = DB::table('tokens_payu')
      ->where('payerId',$id)
      ->get();

      if($consulta){

        return Response::json([
          'respuesta' => true,
          'tarjetas' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }
    }

    public function postPagarservicio(){

      $id_usuario = Input::get('id_usuario');
      //$id_servicio_app = Input::get('id_servicio_app');
      $id_tarjeta = Input::get('id_tarjeta');
      $lastFour = Input::get('lastFour');
      $valor_servicio = Input::get('valor');

      /*$queryService = DB::table('servicios_aplicacion')
      ->where('id',$id_servicio_app)
      ->first();*/

      $queryCard = DB::table('tokens_payu')
      ->where('id',$id_tarjeta)
      ->first();

      $usuario = User::find($id_usuario);

      //$apiUrl = "https://sandbox.wompi.co/v1/transactions"; //URL DE PRUEBAS
      $apiUrl = "https://production.wompi.co/v1/transactions"; //URL DE PRODUCCIÓN

      //$valor = $queryService->valor;
      $valorReal = $valor_servicio.'00';

      $referenceCode = 'aotour_mobile_client_'.date('YmdHis');

      $referencia = new ReferenciasPayu;
      $referencia->reference_code = $referenceCode;
      $referencia->save();

      $data = [
        "amount_in_cents" => intval($valorReal),
        "currency" => "COP",
        "customer_email" => $usuario->email,
				"payment_method" => [
					"installments" => 1
				],
        "reference" => $referenceCode,
				"payment_source_id" => $queryCard->fuente_pago,
      ];
      $headers = [
        'Accept: application/json',
        //'Authorization: Bearer prv_test_Ig9hDRTpqzvsvafOWcYQSQWdC938MtMK', //links pruebas samuel
        'Authorization: Bearer prv_prod_WJ9PkFir6uPwOPwstzfI8LsfPPedpRda', //links productivo aotour
      ];
      $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      $result = curl_exec($ch);

      curl_close($ch);

      $result = json_decode($result);

      $estado = $result->data->status;
      $transaction = $result->data->id;

      if($estado==='APPROVED'){

        $cardPay = $result->data->payment_method->extra->last_four;
        $cardType = $result->data->payment_method->extra->brand;

        $pago = new PagoServicio;
        $pago->reference_code = $referenceCode;
        $pago->order_id = $result->transactionResponse->orderId;
        $pago->user_id = $id_usuario;
        $pago->valor = $valor;
        $pago->numero_tarjeta = '************'.$cardPay;
        $pago->tipo_tarjeta =  $cardType;
        $pago->estado =  $estado;

        if ($pago->save()) {

          //PENDIENTE GUARDAR EL SERVICIO EN LA BASE DE DATOS

          return Response::json([
            'response' => true,
            'transaccion' => $result,
            'estado' => $estado,
            'transaccion' => $transaction
          ]);

          //$servicioApp = Servicioaplicacion::find($id_servicio_app);
          //$servicios_aplicacion->pago_servicio_id = $pago->id;
          //$servicios_aplicacion->fecha_pago = date('Y-m-d H:i:s');

          /*if ($servicios_aplicacion->save()) {

            //Notification::enviarMensaje('El usuario '.ucwords(strtolower($user->first_name)).' '.ucwords(strtolower($user->last_name)).' ha realizado el pago de un servicio para el dia '.$servicios_aplicacion->fecha.' '.$servicios_aplicacion->hora.', revisar el listado de servicios pagados para realizar la programacion.');

            return Response::json([
              'response' => true,
            ]);

          }*/

        }else{

          return Response::json([
            'response' => false,
            'transaccion' => $result,
            'estado' => $estado,
            'transaccion' => $transaction
          ]);

        }

      }else{

        return Response::json([
          'response' => false,
          'transaccion' => $result,
          'estado' => $estado,
          'transaccion' => $transaction
        ]);

      }

    }

    public function postHacervalidacion(){

      $id_transaccion = Input::get('id_transaccion');
      $id_usuario = Input::get('id_usuario');
      $valor = Input::get('valor');

      /*Datos del Servicio*/
      $recoger = Input::get('recoger');
      $dejar = Input::get('dejar');
      $tipo_vehiculo = Input::get('tipo_vehiculo');
      $fecha = Input::get('fecha');
      $hora = Input::get('hora');
      $detalles = Input::get('detalles');
      $check = Input::get('check');
      $email = Input::get('email');
      /*Datos del Servicio*/

      //$respuesta = file_get_contents('https://sandbox.wompi.co/v1/transactions/'.$id_transaccion.''); //prueba
      $respuesta = file_get_contents('https://production.wompi.co/v1/transactions/'.$id_transaccion.''); //producción
      $result = json_decode($respuesta);

      $estadoo = $result->data->status;

      if($estadoo==='APPROVED'){

        $cardPay = $result->data->payment_method->extra->last_four;
        $cardType = $result->data->payment_method->extra->brand;

        $referenceCode = 'aotour_mobile_client_'.date('YmdHis');

        $referencia = new ReferenciasPayu;
        $referencia->reference_code = $referenceCode;
        $referencia->save();

        $pago = new PagoServicio;
        $pago->reference_code = $referenceCode;
        $pago->order_id = $id_transaccion;
        $pago->user_id = $id_usuario;
        $pago->valor = $valor;
        $pago->numero_tarjeta = '************'.$cardPay;
        $pago->tipo_tarjeta =  $cardType;
        $pago->estado =  $estadoo;

        if($pago->save()){

          $usuario = User::find($id_usuario);

          if ($usuario->empresarial==1) {

            $servicio_aplicacion = new Servicioaplicacion();

            $servicio_aplicacion->address_destino = $dejar;
            $servicio_aplicacion->address_recoger = $recoger;
            $servicio_aplicacion->fecha = $fecha;
            //$fechasText = 'el dia y hora: '.$servicio_aplicacion->fecha;
            $servicio_aplicacion->formatted_address_destino = $dejar;
            $servicio_aplicacion->formatted_address_recoger = $recoger;
            //$hora = str_replace(" ","", $hora);
            $servicio_aplicacion->hora = $hora;
            $servicio_aplicacion->nota = $detalles;
            $servicio_aplicacion->tipo_vehiculo = $tipo_vehiculo;
            $servicio_aplicacion->user_id = $id_usuario;
            $servicio_aplicacion->empresarial = 1;

            if (isset($check)) {
              if ($check==true) {
                $servicio_aplicacion->correo_confirmacion = $email;
              }
            }

            $pay = DB::table('pago_servicios')
            ->where('reference_code',$referenceCode)
            ->first();

            $servicio_aplicacion->pago_servicio_id = $pay->id;
            $servicio_aplicacion->fecha_pago = date('Y-m-d H:i:s');

            $servicio_aplicacion->save();

            return Response::json([
              'response' => true
            ]);

          }else{

            $servicios_aplicacion = new Servicioaplicacion();

            $servicios_aplicacion->address_destino = $dejar;
            $servicios_aplicacion->address_recoger = $recoger;
            $servicios_aplicacion->fecha = $fecha;
            $servicios_aplicacion->formatted_address_destino = $dejar;
            $servicios_aplicacion->formatted_address_recoger = $recoger;
            $servicios_aplicacion->hora = $hora;
            $servicios_aplicacion->nota = $detalles;
            $servicios_aplicacion->tipo_vehiculo = $tipo_vehiculo;
            $servicios_aplicacion->user_id = $id_usuario;

            $pay = DB::table('pago_servicios')
            ->where('reference_code',$referenceCode)
            ->first();

            $servicios_aplicacion->pago_servicio_id = $pay->id;
            $servicios_aplicacion->fecha_pago = date('Y-m-d H:i:s');

            $servicios_aplicacion->save();

            return Response::json([
              'response' => true
            ]);

          }

        }

      }else if($estadoo==='DECLINED'){

        return Response::json([
          'response' => 'declined'
        ]);

      }else{

        return Response::json([
          'response' => 'waiting'
        ]);

      }

    }

    public function postPagarserviciomain(){

      $id_usuario = Input::get('id_usuario');
      $id_servicio_app = Input::get('id_servicio_app');
      $id_tarjeta = Input::get('id_tarjeta');
      $lastFour = Input::get('lastFour');

      $queryService = DB::table('servicios_aplicacion')
      ->where('id',$id_servicio_app)
      ->first();

      $queryCard = DB::table('tokens_payu')
      ->where('id',$id_tarjeta)
      ->first();

      $usuario = User::find($id_usuario);

      //$apiUrl = "https://sandbox.wompi.co/v1/transactions"; //URL DE PRUEBAS
      $apiUrl = "https://production.wompi.co/v1/transactions"; //URL DE PRODUCCIÓN

      $valor = $queryService->valor;
      $valor = explode(".", $valor);
      $valorReal = $valor[0].'00';

      $referenceCode = 'aotour_mobile_client_'.date('YmdHis');

      $referencia = new ReferenciasPayu;
      $referencia->reference_code = $referenceCode;
      $referencia->save();

      $data = [
        "amount_in_cents" => intval($valorReal),
        "currency" => "COP",
        "customer_email" => $usuario->email,
				"payment_method" => [
					"installments" => 1
				],
        "reference" => $referenceCode,
				"payment_source_id" => $queryCard->fuente_pago,
      ];
      $headers = [
        'Accept: application/json',
        //'Authorization: Bearer prv_test_Ig9hDRTpqzvsvafOWcYQSQWdC938MtMK', //links pruebas samuel
        'Authorization: Bearer prv_prod_WJ9PkFir6uPwOPwstzfI8LsfPPedpRda', //links productivo aotour
      ];
      $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      $result = curl_exec($ch);

      curl_close($ch);

      $result = json_decode($result);

      /*return Response::json([
        'response' => 'hola',
        'result' => $result,
        'valor' => $valorReal[0]
      ]);*/

      $estado = $result->data->status;
      $transaction = $result->data->id;

      if($estado==='APPROVED'){

        $cardPay = $result->data->payment_method->extra->last_four;
        $cardType = $result->data->payment_method->extra->brand;

        $pago = new PagoServicio;
        $pago->reference_code = $referenceCode;
        $pago->order_id = $result->transactionResponse->orderId;
        $pago->user_id = $id_usuario;
        $pago->valor = $valor;
        $pago->numero_tarjeta = '************'.$cardPay;
        $pago->tipo_tarjeta =  $cardType;
        $pago->estado =  $estado;

        if ($pago->save()) {

          $servicioApp = Servicioaplicacion::find($id_servicio_app);
          $servicios_aplicacion->pago_servicio_id = $pago->id;
          $servicios_aplicacion->fecha_pago = date('Y-m-d H:i:s');

          if ($servicios_aplicacion->save()) {

            //Notification::enviarMensaje('El usuario '.ucwords(strtolower($user->first_name)).' '.ucwords(strtolower($user->last_name)).' ha realizado el pago de un servicio para el dia '.$servicios_aplicacion->fecha.' '.$servicios_aplicacion->hora.', revisar el listado de servicios pagados para realizar la programacion.');

            return Response::json([
              'response' => true,
            ]);

          }

        }

      }else if($estado==='PENDING'){

        return Response::json([
          'response' => false,
          'transaccion' => $result,
          'estado' => $estado,
          'transaccion' => $transaction
        ]);

      }

    }

    public function postHacervalidacionmain(){

      $id_transaccion = Input::get('id_transaccion');
      $id_usuario = Input::get('id_usuario');
      $valor = Input::get('valor');
      $id_servicio_app = Input::get('id_servicio_app');

      //$respuesta = file_get_contents('https://sandbox.wompi.co/v1/transactions/'.$id_transaccion.''); //prueba
      $respuesta = file_get_contents('https://production.wompi.co/v1/transactions/'.$id_transaccion.''); //producción
      $result = json_decode($respuesta);

      $estadoo = $result->data->status;

      if($estadoo==='APPROVED'){

        $cardPay = $result->data->payment_method->extra->last_four;
        $cardType = $result->data->payment_method->extra->brand;

        $referenceCode = 'aotour_mobile_client_'.date('YmdHis');

        $referencia = new ReferenciasPayu;
        $referencia->reference_code = $referenceCode;
        $referencia->save();

        $pago = new PagoServicio;
        $pago->reference_code = $referenceCode;
        $pago->order_id = $id_transaccion;
        $pago->user_id = $id_usuario;
        $pago->valor = $valor;
        $pago->numero_tarjeta = '************'.$cardPay;
        $pago->tipo_tarjeta =  $cardType;
        $pago->estado =  $estadoo;

        if($pago->save()){

          $servicioApp = Servicioaplicacion::find($id_servicio_app);
          $servicioApp->pago_servicio_id = $pago->id;
          $servicioApp->fecha_pago = date('Y-m-d H:i:s');

          if ($servicioApp->save()) {

            //Notification::enviarMensaje('El usuario '.ucwords(strtolower($user->first_name)).' '.ucwords(strtolower($user->last_name)).' ha realizado el pago de un servicio para el dia '.$servicios_aplicacion->fecha.' '.$servicios_aplicacion->hora.', revisar el listado de servicios pagados para realizar la programacion.');

            return Response::json([
              'response' => true,
              'transaccion' => $result
            ]);

          }

        }

      }else if($estadoo==='DECLINED'){

        return Response::json([
          'response' => 'declined'
        ]);

      }else{

        return Response::json([
          'response' => false,
          'transaccion' => $result
        ]);

      }

    }

    public function postValidarpago(){

      $id = Input::get('id');
      $id_usuario = Input::get('id_usuario');
      $id_servicio_app = Input::get('id_servicio_app');

      //$response = file_get_contents('https://sandbox.wompi.co/v1/transactions/'.$id.''); //prueba
      $response = file_get_contents('https://production.wompi.co/v1/transactions/'.$id.''); //producción
			$response = json_decode($response);

      $estado = $response->data->status;

      if($estado==='APPROVED'){

        $referenceCode = 'aotour_mobile_client_'.date('YmdHis');

        $referencia = new ReferenciasPayu;
        $referencia->reference_code = $referenceCode;
        $referencia->save();

        $queryService = DB::table('servicios_aplicacion')
        ->where('id',$id_servicio_app)
        ->first();

        $valor = $queryService->valor;
        $valorReal = $valor.'00';

        $cardPay = $response->data->payment_method->extra->last_four;
        $cardType = $response->data->payment_method->extra->brand;
        $transaction = $response->data->id;

        $pago = new PagoServicio;
        $pago->reference_code = $referenceCode;
        $pago->order_id = $transaction;
        $pago->user_id = $id_usuario;
        $pago->valor = $valor;
        $pago->numero_tarjeta = '************'.$cardPay;
        $pago->tipo_tarjeta =  $cardType;
        $pago->estado =  $estado;
        $pago->save();

        $servicioApp = Servicioaplicacion::find($id_servicio_app);
        $servicioApp->pago_servicio_id = $pago->id;
        $servicioApp->fecha_pago = date('Y-m-d H:i:s');
        $servicioApp->save();

        return Response::json([
          'response' => true,
          'transaccion' => $response
        ]);

      }else{

        return Response::json([
          'response' => 'PENDING',
          'transaccion' => $response
        ]);

      }


    }

    public function postDetallespago(){

      $pago = Input::get('pago');
      $id_usuario = Input::get('id_usuario');

      $detallePago = DB::table('pago_servicios')
      ->where('id',$pago)
      ->first();

      if($detallePago){

        return Response::json([
          'response' => true,
          'pago' => $detallePago
        ]);

      }else{

        return Response::json([
          'response' => false
        ]);

      }

    }

    public function postServiciosporpagar(){

      $user_id = Input::get('id_usuario');

      $servicios = DB::table('servicios_aplicacion')
      ->where('user_id', $user_id)
      ->whereNull('pago_servicio_id')
      ->whereNull('pago_facturacion')
      ->whereNull('cancelado')
      ->get();

      if($servicios){

        return Response::json([
          'response' => true,
          'servicios' => $servicios
        ]);

      }else{

        return Response::json([
          'response' => false,
          'servicios' => $servicios
        ]);

      }

    }

    public function postCreate(){

      $idioma = Input::get('idioma');

      $tipo = Input::get('tipo');
      $nombres = Input::get('nombre');
      $apellidos = Input::get('apellido');
      $correo = Input::get('email');
      $contrasena = Input::get('contrasena');
      $telefono = Input::get('telefono');
      $empresa = Input::get('empresa');
      $cargo = Input::get('cargo');
      $centro = Input::get('centro');

      $usuario = DB::table('users')
      ->where('email',$correo)
      ->first();

      if($usuario){

        return Response::json([
          'response' => false,
          'error' => 'existe'
        ]);

      }else{

        $user = new User();

        if ($tipo=='empresarial') {
          $user->empresarial = 1;
          $user->empresa = trim(strtoupper(strtolower($empresa)));
          $user->centro_de_costo = trim($centro);
          $user->cargo = trim($cargo);
        }else{
          $user->particular = 1;
        }

        $user->first_name = strtoupper(strtolower($nombres));
        $user->last_name = strtoupper(strtolower($apellidos));
        $user->email = strtolower($correo);
        $user->telefono = $telefono;
        $user->password = Hash::make($contrasena);
        $user->activation_code = str_random(40);
        $user->usuario_app = 2;

        if ($user->save()) {

          $data = [
            'activation_code' => $user->activation_code
          ];

          $userArray = [
            'id' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'telefono' => $user->telefono,
            'empresarial' => $user->empresarial,
            'centro' => $user->centrodecosto_id
          ];

          $userToken = User::find($user->id);

          $token = $userToken->createToken('Token Name')->accessToken;

          //ENVÍO DE CORREO

          $emailcc = 'aotourdeveloper@gmail.com';

          if($idioma=='en'){

            Mail::send('mobile.client.email_activacion_en', $user, function($message) use ($correo, $emailcc){
              $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
              $message->to($correo)->subject('Account Activation');
              $message->cc($emailcc);
            });

          //Mail::to($user->email)->cc('aotourdeveloper@gmail.com')->send(new ActivarCuentaEn($user));
          }else{

            Mail::send('mobile.client.email_activacion', $user, function($message) use ($correo, $emailcc){
              $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
              $message->to($correo)->subject('Activacion de cuenta');
              $message->cc($emailcc);
            });

          }

          /*if (isset($empresa)) {
            //Notification::enviarMensaje('Un nuevo usuario ha sido registrado en la aplicacion con los siguientes datos, empresa: '.ucwords(strtolower($empresa)).', nombre completo: '.ucwords(strtolower($user->first_name)).' '.ucwords(strtolower($user->last_name)));
          }else{
            Notification::enviarMensaje('Un nuevo usuario ha sido registrado en la aplicacion con los siguientes datos, nombre completo: '.ucwords(strtolower($user->first_name)).' '.ucwords(strtolower($user->last_name)));
              if($idioma=='english'){
            Mail::to($user->email)->cc('aotourdeveloper@gmail.com')->send(new ActivarCuentaEn($user));
            }else{
              Mail::to($user->email)->cc('aotourdeveloper@gmail.com')->send(new ActivarCuenta($user));
            }
          }*/

          return Response::json([
            'response' => true,
            'token' => $token,
            'userArray' => $userArray
          ]);

        }

      }

    }

    public function postCambiaridioma(){

      $id = Input::get('id');
      $idioma = Input::get('idioma');

      $ActualizarIdioma = DB::table('users')
      ->where('id',$id)
      ->update([
        'idioma' => $idioma
      ]);

      return Response::json([
        'respuesta' => true
      ]);

    }

    public function postCalculartarifa(){

      $id_usuario = Input::get('id');
      $distancia = Input::get('distancia'); //Distacia en metros (Ejemplo: 4291 = 4,3 km)
      $tiempo = Input::get('tiempo'); //Tiempo en segundos (Ejemolo: 863 = 14mins)
      $fecha = Input::get('fecha');
      $hora = Input::get('hora');
      $tipo_vehiculo = Input::get('tipo_vehiculo');

      $valor = 2800;

      $status = true;

      /*Código para calcular tarifa*/

      /*Cálculo del tiempo*/
      //SI EL SERVICIO NO SOBREPASA LOS 10 MINUTOS Y LA DISTANCIA ES MENOR A LOS 3KM, SE COBRA LA TARIFA MÍNIMA.
      if($tiempo<=600 and $distancia<3000){
        $valor_tarifa = 25000;
        //SI EL SERVICIO PASA LOS 10 MINUTOS(600seg), PERO NO HA RECORRIDO LOS 3KM(300m), SE COBRA LA TARIFA MÍNIMA, Y SE ADICIONAN 600 PESOS POR CADA MINUTO.
      }else if($tiempo>600 and $distancia<=3000){
        /*START COBRO TARIFA MÍNIMA MÁS (600*MIN)*/
        $valor_tarifa = 9000+(($tiempo-600)*5);
        if($valor_tarifa<25000){
          $valor_tarifa = 25000;
        }
        /*END COBRO TARIFA MÍNIMA MÁS (600*MIN)*/
        //SI EL SERVICIO PASÓ LOS 3KM SE COBRA EL VALOR DE LA TARIFA MÍNIMA, Y SE ADICIONAN 300 PESOS POR CADA 100 METROS (CONTANDO DESPUÉS DE LOS 3KM)
      }else if($distancia>3000){
        //CALCULAR DATOS DE TIEMPO NEW START
        $valor_tiempo = ($tiempo-600)*5;
        /* START COBRO TARIFA MÍNIMA MÁS (300*100M)*/
        $valor_tarifa = 9000+( (($distancia-3000)*3) );
        $valor_tarifa = $valor_tarifa+$valor_tiempo;

        if($valor_tarifa<25000){
          $valor_tarifa = 25000;
        }

        /* END COBRO TARIFA MÍNIMA MÁS (300*100M)*/
      }
      /*Cálculo por tiempo*/

      return Response::json([
        'response' => $status,
        'distancia' => $distancia,
        'tiempo' => $tiempo,
        'valor' => intval($valor_tarifa)
      ]);

    }

    public function postCalculartarifa2(){

      $id_usuario = Input::get('id');
      $distancia = Input::get('distancia'); //Distacia en metros (Ejemplo: 4291 = 4,3 km)
      $tiempo = Input::get('tiempo'); //Tiempo en segundos (Ejemolo: 863 = 14mins)
      $fecha = Input::get('fecha');
      $hora = Input::get('hora');
      $tipo_vehiculo = Input::get('tipo_vehiculo');

      $valor = 2800;

      $status = true;

      /*Código para calcular tarifa*/

      /*Cálculo del tiempo*/
      //SI EL SERVICIO NO SOBREPASA LOS 10 MINUTOS Y LA DISTANCIA ES MENOR A LOS 3KM, SE COBRA LA TARIFA MÍNIMA.
      if($tiempo<=600 and $distancia<3000){
        $valor_tarifa = 25000;
        //SI EL SERVICIO PASA LOS 10 MINUTOS(600seg), PERO NO HA RECORRIDO LOS 3KM(300m), SE COBRA LA TARIFA MÍNIMA, Y SE ADICIONAN 600 PESOS POR CADA MINUTO.
      }else if($tiempo>600 and $distancia<=3000){
        /*START COBRO TARIFA MÍNIMA MÁS (600*MIN)*/
        $valor_tarifa = 9000+(($tiempo-600)*5);
        if($valor_tarifa<25000){
          $valor_tarifa = 25000;
        }
        /*END COBRO TARIFA MÍNIMA MÁS (600*MIN)*/
        //SI EL SERVICIO PASÓ LOS 3KM SE COBRA EL VALOR DE LA TARIFA MÍNIMA, Y SE ADICIONAN 300 PESOS POR CADA 100 METROS (CONTANDO DESPUÉS DE LOS 3KM)
      }else if($distancia>3000){
        //CALCULAR DATOS DE TIEMPO NEW START
        $valor_tiempo = ($tiempo-600)*5;
        /* START COBRO TARIFA MÍNIMA MÁS (300*100M)*/
        $valor_tarifa = 9000+( (($distancia-3000)*3) );
        $valor_tarifa = $valor_tarifa+$valor_tiempo;

        if($valor_tarifa<25000){
          $valor_tarifa = 1000;
        }

        /* END COBRO TARIFA MÍNIMA MÁS (300*100M)*/
      }
      /*Cálculo por tiempo*/

      return Response::json([
        'response' => $status,
        'distancia' => $distancia,
        'tiempo' => $tiempo,
        'valor' => intval($valor_tarifa)
      ]);

    }

    public function postSolicitarservicio(){

        $valorTarifa = null;
        $user_id = Input::get('user_id');
        $sw = Input::get('sw');
        $idioma = Input::get('idioma');
        $cobro = Input::get('cobro');

        $address_recoger = Input::get('address_recoger');
        $address_destino = Input::get('address_destino');
        $confirmacion_correo_electronico = Input::get('confirmacion_correo_electronico');
        $correo_confirmacion = Input::get('email');
        $fecha = Input::get('fecha');
        $hora = Input::get('hora');
        $nota = Input::get('nota');
        $tipo_vehiculo = Input::get('tipo_vehiculo');

        //Buscar el usuario que esta solicitando el servicio.
        $user = User::find($user_id);

        //Asignar a una variable si el usuario es empresarial o particular. esto para seleccionar la tarifa.
        if ($user->empresarial==1) {
          $tipo_cliente = 1;
        }else {
          $tipo_cliente = 2;
        }

        //Si el usuario ha sido activado entonces.
        if (!$user->activated!=1) {

          //Si el usuario es empresarial entonces crear el servicio para que aparezca en servicios de pago por facturacion
          if ($user->empresarial==1) {

            $servicio_aplicacion = new Servicioaplicacion();

            $servicio_aplicacion->address_destino = $address_destino;
            $servicio_aplicacion->address_recoger = $address_recoger;
            //$servicio_aplicacion->destinoLatitude = $request->destinoLatitude;
            //$servicio_aplicacion->destinoLongitude = $request->destinoLongitude;

            //$servicio_aplicacion->destino_zona = $request->destino_zona;
            //$servicio_aplicacion->recoger_zona = $request->recoger_zona;
            $servicio_aplicacion->fecha = $fecha;
            $fechasText = 'el dia y hora: '.$servicio_aplicacion->fecha;

            $servicio_aplicacion->formatted_address_destino = $address_destino;
            $servicio_aplicacion->formatted_address_recoger = $address_recoger;

            $hora = str_replace(" ","", $hora);

            $servicio_aplicacion->hora = $hora;
            $servicio_aplicacion->nota = $nota;
            /*if($request->viaje){
              $servicio_aplicacion->viaje = $request->viaje;
            }else if($request->viaje_en){
              $servicio_aplicacion->viaje = $request->viaje_en;
            }
            if($request->centro){
              $servicio_aplicacion->centro_cliente = $request->centro;
            }else if($request->centro_en){
              $servicio_aplicacion->centro_cliente = $request->centro;
            }*/
            //$servicio_aplicacion->recogerLatitude = $request->recogerLatitude;
            //$servicio_aplicacion->recogerLongitude = $request->recogerLongitude;
            $servicio_aplicacion->tipo_vehiculo = $tipo_vehiculo;
            $servicio_aplicacion->user_id = $user_id;
            if($tipo_cliente==1){
              if($cobro===1){
                $servicio_aplicacion->pago_facturacion = 1;

                $servicio_aplicacion->tarifado = 1;

              }else{

                $servicio_aplicacion->esperando_tarifa = 1;
                $servicio_aplicacion->pago_pendiente = 1;
                $servicio_aplicacion->liquidacion_pendiente = 1;

              }

            }
            if(intval($sw)===2){ // PAGO DIRECTO EMPRESARIAL

            }else{ //PAGO POR FACTURACION

            }
            $servicio_aplicacion->pago_facturacion_fecha = date('Y-m-d H:i:s');

            if (isset($confirmacion_correo_electronico)) {

              if ($confirmacion_correo_electronico==true) {
                $servicio_aplicacion->correo_confirmacion = $correo_confirmacion;
              }

            }

            $user = User::find($user_id);

            if ($user->empresarial==1) {
              $servicio_aplicacion->empresarial = 1;
            }

            if ($servicio_aplicacion->save()) {

              //$result = Notification::enviarMensaje('El usuario '.ucwords(strtolower($user->first_name)).' '.ucwords(strtolower($user->last_name)).
              //' de la empresa: '.ucwords(strtolower($user->centrodecosto->razonsocial)).
              //' ha solicitado la programacion de un servicio para '.$fechasText.' '.$hora.
              //', revisa el listado de servicios empresariales!');

              if ($servicio_aplicacion->correo_confirmacion!=null) {

                $emailcc = 'aotourdeveloper@gmail.com';
                $correo = $correo_confirmacion;
                $datos = [
                  'servicio_aplicacion' => $servicio_aplicacion,
                  'first_name' => $user->first_name,
                  'last_name' => $user->last_name
                ];

                if($idioma=='en'){

                  Mail::send('mobile.client.confirmacion_servicio_en', $datos, function($message) use ($correo, $emailcc){
                    $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
                    $message->to($correo)->subject('Service confirmation');
                    $message->cc($emailcc);
                  });

                }else{

                  Mail::send('mobile.client.confirmacion_servicio', $datos, function($message) use ($correo, $emailcc){
                    $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
                    $message->to($correo)->subject('Confirmacion de servicio');
                    $message->cc($emailcc);
                  });

                }

              }

              $idpusher = "578229";
              $keypusher = "a8962410987941f477a1";
              $secretpusher = "6a73b30cfd22bc7ac574";

              //CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
              $channel = 'servicios';
              $name = 'mobile';

              $sin_tarifa = Servicioaplicacion::sintarifa()->count();
              $pagados = Servicioaplicacion::pagados()->count();
              $empresarial = Servicioaplicacion::Pagofacturacion()->count();
              $cancelados = Servicio::canceladoapp()->count();

              $data = json_encode([
                'sin_tarifa' => $sin_tarifa,
                'cancelados' => $cancelados,
                'empresarial' => $empresarial,
                'pagados' => $pagados
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

              /*ENVÍO DE CORREO A OPERACIONES*/
              $emailcc = 'aotourdeveloper@gmail.com';
              $correoOperaciones = ['transportebarranquilla@aotour.com.co', 'transportebogota@aotour.com.co'];
              $datos = [
                'servicio_aplicacion' => $servicio_aplicacion,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name
              ];
              Mail::send('mobile.client.confirmacion_servicio', $datos, function($message) use ($correoOperaciones, $emailcc){
                $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
                $message->to($correoOperaciones)->subject('Confirmacion de servicio');
                $message->cc($emailcc);
              });
              //ENVÍO DE CORREO A OPERACIONES*/

              //ENVÍO DE WHATSAPP

              $numberBAQ = 573012030290;
              $numberBOG = 573012633287;
              $cliente = DB::table('centrosdecosto')
              ->where('id', $user->centrodecosto_id)
              ->pluck('razonsocial');

              $ch = curl_init();

              curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
              curl_setopt($ch, CURLOPT_HEADER, FALSE);

              curl_setopt($ch, CURLOPT_POST, TRUE);

              curl_setopt($ch, CURLOPT_POSTFIELDS, "{
                \"messaging_product\": \"whatsapp\",
                \"to\": \"".$numberBAQ."\",
                \"type\": \"template\",
                \"template\": {
                  \"name\": \"service_request\",
                  \"language\": {
                    \"code\": \"es\",
                  },
                  \"components\": [{
                    \"type\": \"body\",
                    \"parameters\": [{
                      \"type\": \"text\",
                      \"text\": \"".$cliente."\",
                    },
                    {
                      \"type\": \"text\",
                      \"text\": \"".$fecha."\",
                    },
                    {
                      \"type\": \"text\",
                      \"text\": \"".$hora."\",
                    }]
                  }]
                }
              }");

              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer EAAHPlqcJlZCMBAMDLjgTat7TlxvpmDq1fgzt2gZBPUnEsTyEuxuJw9uvGJM1WrWtpN7fmpmn3G2KXFZBRIGLKEDhZBPZAeyUSy2OYiIcNEf2mQuFcW67sgGoU95VkYayreD5iBx2GbnZBgaGvS8shX6f2JKeBp7pm9TNLm2EZBEbcx0Sdg47miONZCpUNZCfqEWlZAFxkltEOBPAZDZD"
              ));

              $response = curl_exec($ch);
              curl_close($ch);

              //BOG
              $ch = curl_init();

              curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
              curl_setopt($ch, CURLOPT_HEADER, FALSE);

              curl_setopt($ch, CURLOPT_POST, TRUE);

              curl_setopt($ch, CURLOPT_POSTFIELDS, "{
                \"messaging_product\": \"whatsapp\",
                \"to\": \"".$numberBOG."\",
                \"type\": \"template\",
                \"template\": {
                  \"name\": \"service_request\",
                  \"language\": {
                    \"code\": \"es\",
                  },
                  \"components\": [{
                    \"type\": \"body\",
                    \"parameters\": [{
                      \"type\": \"text\",
                      \"text\": \"".$cliente."\",
                    },
                    {
                      \"type\": \"text\",
                      \"text\": \"".$fecha."\",
                    },
                    {
                      \"type\": \"text\",
                      \"text\": \"".$hora."\",
                    }]
                  }]
                }
              }");

              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer EAAHPlqcJlZCMBAMDLjgTat7TlxvpmDq1fgzt2gZBPUnEsTyEuxuJw9uvGJM1WrWtpN7fmpmn3G2KXFZBRIGLKEDhZBPZAeyUSy2OYiIcNEf2mQuFcW67sgGoU95VkYayreD5iBx2GbnZBgaGvS8shX6f2JKeBp7pm9TNLm2EZBEbcx0Sdg47miONZCpUNZCfqEWlZAFxkltEOBPAZDZD"
              ));

              $response = curl_exec($ch);
              curl_close($ch);

              return Response::json([
                'response' => true,
                'tipo_cliente' => $tipo_cliente,
              ]);

            }

          }else {

            //Si el tipo de vehiculo es automovil entonces.
            /*if ($tipo_vehiculo==='automovil') {

              return response()->json(Servicio::tarifa($request->recoger_zona, $request->destino_zona, $tipo_cliente, $request));

            }else {*/

            $servicios_aplicacion = new Servicioaplicacion();

            $servicios_aplicacion->address_destino = $address_destino;
            $servicios_aplicacion->address_recoger = $address_recoger;
            //$servicios_aplicacion->destinoLatitude = $request->destinoLatitude;
            //$servicios_aplicacion->destinoLongitude = $request->destinoLongitude;

            //$servicios_aplicacion->destino_zona = $request->destino_zona;
            //$servicios_aplicacion->recoger_zona = $request->recoger_zona;
            $servicios_aplicacion->fecha = $fecha;
            $servicios_aplicacion->formatted_address_destino = $address_destino;
            $servicios_aplicacion->formatted_address_recoger = $address_recoger;

            $hora = date("G:i", strtotime(str_replace(" ","", $hora)));

            $servicios_aplicacion->hora = $hora;
            $servicios_aplicacion->nota = $nota;
            //$servicios_aplicacion->recogerLatitude = $request->recogerLatitude;
            //$servicios_aplicacion->recogerLongitude = $request->recogerLongitude;
            $servicios_aplicacion->tipo_vehiculo = $tipo_vehiculo;
            $servicios_aplicacion->user_id = $user_id;
            $servicios_aplicacion->esperando_tarifa = 1;

            $servicios_aplicacion->esperando_tarifa = 1;
            $servicios_aplicacion->pago_pendiente = 1;
            $servicios_aplicacion->liquidacion_pendiente = 1;

            $user = User::find($user_id);

            if ($user->empresarial==1) {
              $servicios_aplicacion->empresarial = 1;
            }

            if ($servicios_aplicacion->save()) {

              /*$result = Notification::enviarMensaje('El usuario '.ucwords(strtolower($user->first_name.' '.$user->last_name)).
              ' ha solicitado la tarifa de un servicio en '.ucwords(strtolower($request->tipo_vehiculo)).' para el dia '.
              $request->fecha.' '.$hora.', revisa el listado de servicios sin tarifar para que le envies la tarifa del servicio!');

              if($request->idioma=='english'){
                $sms1 = 'In moments we will be reviewing your request, please wait a moment while we send you the information.';
              }else{
                $sms1 = 'En momentos estaremos revisando su solicitud por favor espere un momento mientras le enviamos la informacion.';
              }*/

              $idpusher = "578229";
              $keypusher = "a8962410987941f477a1";
              $secretpusher = "6a73b30cfd22bc7ac574";

              //CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
              $channel = 'servicios';
              $name = 'mobile';

              $sin_tarifa = Servicioaplicacion::sintarifa()->count();
              $pagados = Servicioaplicacion::pagados()->count();
              $empresarial = Servicioaplicacion::Pagofacturacion()->count();
              $cancelados = Servicio::canceladoapp()->count();

              $data = json_encode([
                'sin_tarifa' => $sin_tarifa,
                'cancelados' => $cancelados,
                'empresarial' => $empresarial,
                'pagados' => $pagados
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

              /*ENVÍO DE CORREO A OPERACIONES*/
              $emailcc = 'aotourdeveloper@gmail.com';
              $correoOperaciones = ['transportebarranquilla@aotour.com.co', 'transportebogota@aotour.com.co'];
              $datos = [
                'servicio_aplicacion' => $servicios_aplicacion,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name
              ];
              Mail::send('mobile.client.confirmacion_servicio', $datos, function($message) use ($correoOperaciones, $emailcc){
                $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
                $message->to($correoOperaciones)->subject('Confirmacion de servicio');
                $message->cc($emailcc);
              });
              //ENVÍO DE CORREO A OPERACIONES*/

              return Response::json([
                'response' => true,
                //'message' => $sms1,
                //'result' => $result
              ]);

            }

            //}

          }

        }else {
            if($request->idioma==='english'){
              $mensaje1 = 'You cannot request services yet, you must activate your email account.';
              $mensaje2 = 'You cannot request services yet, we are confirming your data.';

            }else{
              $mensaje1 = 'Aun no puedes solicitar servicios, debes activar tu cuenta de mail.';
              $mensaje2 = 'Aun no puedes solicitar servicios, estamos confirmando tus datos.';
            }

            if ($user->empresarial!=1) {
              $message = $mensaje1;
            }else {
              $message = $mensaje2;
            }

            return response()->json([
              'response' => false,
              'message' => $message
            ]);

        }
    }

    public function postCancelarserviciop(){

      $servicio = Servicio::find(Input::get('id_servicio'));

      $fecha_servicio = $servicio->fecha_servicio.' '.$servicio->hora_servicio;

      $fecha_actual = date('Y-m-d H:i:s');

      $diferencia =  (strtotime($fecha_servicio)-strtotime($fecha_actual))/60;

      if ($diferencia>0) {

          if ($diferencia>120) {

            $servicio->cancelado_app = 1;

            if ($servicio->save()) {

              /**
               * Cuando se cancela el servicio enviar en tiempo real tanto la notificacion
               * como la actualizacion de la cantidad de servicios cancelados
               */
              $channel = 'servicios';
              $name = 'mobile';

              $sin_tarifa = Servicioaplicacion::sintarifa()->count();
              $pagados = Servicioaplicacion::pagados()->count();
              $empresarial = Servicioaplicacion::Pagofacturacion()->count();
              $cancelados = Servicio::canceladoapp()->count();

              $data = json_encode([
                'sin_tarifa' => $sin_tarifa,
                'cancelados' => $cancelados,
                'empresarial' => $empresarial,
                'pagados' => $pagados
              ]);

              //Notification::enviarNotificacionPusher($channel, $name, $data);
              //Notification::enviarMensaje('Un servicio ha sido cancelado desde la aplicacion, por favor revisar listado de servicios cancelados!');

              return Response::json([
                  'response' => true,
              ]);

            }

          }else{

            return Response::json([
              'response' => 'tiempo'
            ]);

          }

      }else if($diferencia<=0){

        return Response::json([
          'response' => 'tiempo'
        ]);

      }

    }

    public function postCancelarservicio(){

      $servicios_aplicacion = Servicioaplicacion::find(Input::get('id_servicio'));

      $fecha_servicio = $servicios_aplicacion->fecha.' '.$servicios_aplicacion->hora;

      $fecha_actual = date('Y-m-d H:i:s');

      $diferencia =  (strtotime($fecha_servicio)-strtotime($fecha_actual))/60;

      if ($diferencia>0) {

          if ($diferencia>120) {

            if ($servicios_aplicacion->programado==1) {

              return Response::json([
                'response' => 'programado'
              ]);

            }else {

              $servicios_aplicacion->cancelado = 1;

              if ($servicios_aplicacion->save()) {

                //$result = Notification::enviarMensaje('Un servicio no programado ha sido cancelado por parte del usuario: '.ucwords(strtolower($servicios_aplicacion->user->first_name)).' '.ucwords(strtolower($servicios_aplicacion->user->last_name)).', por favor revisa el listado de servicios cancelados no programados.');

                return Response::json([
                  'response' => true
                ]);

              }

            }

          }else{

            return Response::json([
              'response' => 'tiempo'
            ]);

          }

      }else if($diferencia<=0){

        return Response::json([
          'response' => 'tiempo'
        ]);

      }

    }

    //FUNCIÓN PARA MOSTRAR DATOS DEL CONDUCTOR EN SERVICIOS PROGRAMADOS
    public function postConductor(){

      $id = Input::get('id_servicio');

      $conductor = DB::table('servicios')
      ->select('conductores.nombre_completo', 'conductores.celular', 'conductores.foto', 'vehiculos.placa', 'vehiculos.color', 'vehiculos.marca', 'vehiculos.clase', 'vehiculos.modelo', 'servicios.fecha_servicio')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->where('servicios.id',$id)
      ->first();

      return Response::json([
        'response' => true,
        'conductor' => $conductor
      ]);

    }

    public function postTrackingdesdecliente(){

      $servicio_id = Input::get('id_servicio');
      $user_id = Input::get('user_id');

      $servicio = Servicio::find($servicio_id);

      if(isset($servicio->estado_servicio_app)){

        if($servicio->estado_servicio_app!=1){

          return Response::json([
            'response' => false,
            'servicio' => $servicio
          ]);

        }else{

          //return Response::json([
            //'response' => false,
            //'servicio' => $servicio
          //]);

          $servicio->tracking_cliente = 1;

          $traslado = DB::table('servicios')
          ->select('vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'vehiculos.color', 'conductores.nombre_completo', 'conductores.celular')
          ->leftJoin('conductores', 'conductores.id', "=", 'servicios.conductor_id')
          ->leftJoin('vehiculos', 'vehiculos.id', "=", 'servicios.vehiculo_id')
          ->where('servicios.id',$servicio_id)
          ->first();

          $parseRecorrido = json_decode($servicio->recorrido_gps);

          $cantidad_puntos = count($parseRecorrido);

          if ($servicio->save()) {

            return Response::json([
              'response' => true,
              'servicio_id' => $servicio_id,
              'ultima_ubicacion' => $parseRecorrido[$cantidad_puntos-1],
              'servicio' => $servicio,
              'traslado' => $traslado
            ]);

          }

        }

      }else{

        return Response::json([
          'response' => false,
        ]);

      }

    }

    public function postTrackingdesdeclientev2(){

      $user_id = Input::get('user_id');

      /*$service = DB::table('servicios')
      ->where('app_user_id',$user_id)
      ->where('estado_servicio_app',1)
      ->pluck('id');*/

      /*$consulta = "select * from servicios where app_user_id = ".$user_id." and estado_servicio_app = 1 and pendiente_autori_eliminacion is null order by fecha_servicio asc limit 1";
      $ultimo = DB::select($consulta);

      $service = $ultimo[0]->id;*/

      $id = Input::get('id_servicio');

      //$service = Servicio::find(intval($id));

      /*DB::table('servicios')
      ->where('app_user_id',$user_id)
      ->where('estado_servicio_app',1)
      ->pluck('id');*/

      $servicio = Servicio::find(intval($id));

      $servicio->tracking_cliente = 1;

      $traslado = DB::table('servicios')
      ->select('vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'vehiculos.color', 'conductores.nombre_completo', 'conductores.celular')
      ->leftJoin('conductores', 'conductores.id', "=", 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', "=", 'servicios.vehiculo_id')
      ->where('servicios.id',$servicio->id)
      ->first();

      $parseRecorrido = json_decode($servicio->recorrido_gps);

      $cantidad_puntos = count($parseRecorrido);

      if ($servicio->save()) {

        return Response::json([
          'response' => true,
          'servicio_id' => $servicio->id,
          'ultima_ubicacion' => $parseRecorrido[$cantidad_puntos-1],
          'servicio' => $servicio,
          'traslado' => $traslado
        ]);

      }

    }

    public function postCoordenadasupdate(){

      $servicio_id = Input::get('id_servicio');
      //$user_id = Input::get('user_id');

      $servicio = Servicio::find($servicio_id);
      //$servicio->tracking_cliente = 1;

      $parseRecorrido = json_decode($servicio->recorrido_gps);

      $cantidad_puntos = count($parseRecorrido);

      //if ($servicio->save()) {

      return Response::json([
        'response' => true,
        'servicio_id' => $servicio_id,
        'ultima_ubicacion' => $parseRecorrido[$cantidad_puntos-1],
        'cantidad_puntos' => $cantidad_puntos,
        'estado_servicio_app' => $servicio->estado_servicio_app,
        'dejar_en' => $servicio->dejar_en,
        'recogido' => $servicio->recoger_pasajero
      ]);

      //}

    }

    public function postActualizarubicacion(){

      $servicio_id = Input::get('id');
      //$user_id = Input::get('user_id');

      $servicio = Servicio::find($servicio_id);
      //$servicio->tracking_cliente = 1;

      $parseRecorrido = json_decode($servicio->recorrido_gps);

      $cantidad_puntos = count($parseRecorrido);

      //if ($servicio->save()) {

      return Response::json([
        'response' => true,
        'servicio_id' => $servicio_id,
        'ultima_ubicacion' => $parseRecorrido[$cantidad_puntos-1],
        'cantidad_puntos' => $cantidad_puntos,
        'estado_servicio_app' => $servicio->estado_servicio_app,
        'dejar_en' => $servicio->dejar_en,
        'recogido' => $servicio->recoger_pasajero
      ]);

      //}

    }

    public function postWazee() {

      $id = Input::get('id');
      $puntos = Input::get('puntos');

      $update = DB::table('servicios')
      ->where('id',$id)
      ->update([
        'motivo_rechazo' => $puntos
      ]);

      return Response::json([
        'respuesta' => true
      ]);

    }

    public function postRequest(){

      $user_id = Input::get('user_id');

      $consulta = DB::table('notificaciones')
      ->where('id_usuario',$user_id)
      ->whereNull('leido')
      ->first();

      $fechaActual = date('Y-m-d');

      $diaanterior = strtotime ('-1 day', strtotime($fechaActual));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      $diasiguiente = strtotime ('+1 day', strtotime($fechaActual));
      $diasiguiente = date ('Y-m-d' , $diasiguiente);

      $servicio = DB::table('servicios')
      ->whereBetween('fecha_servicio',[$diaanterior, $diasiguiente])
      ->where('app_user_id',$user_id)
      ->where('estado_servicio_app',1)
      ->first();

      if($servicio!=null){
        $sw = 1;
        $id = $servicio->id;
      }else{
        $sw = 0;
        $id = null;
      }

      if($consulta){

        return Response::json([
          'respuesta' => true,
          'sw' => $sw,
          'servicio' => $id
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'sw' => $sw,
          'servicio' => $id
        ]);

      }

    }

    public function postRate(){

      $id = Input::get('id_servicio');

      $servicio = Servicio::find($id);

      if($servicio->calificacion_app_cliente_actitud!=null){

        return Response::json([
          'respuesta' => false,
          'servicio' => $servicio
        ]);

      }else{

        return Response::json([
          'respuesta' => true,
          'servicio' => $servicio
        ]);

      }

    }

    public function postCalificarserviciopush(){

      $id = Input::get('id_servicio');

      $servicio = Servicio::find($id);

      if($servicio->calificacion_app_cliente_actitud!=null){

        return Response::json([
          'respuesta' => false,
          'servicio' => $servicio
        ]);

      }else{

        return Response::json([
          'respuesta' => true,
          'servicio' => $servicio
        ]);

      }

    }

    public function postServicioactivo(){

      $user = User::find(Input::get('id'));

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      $diasiguiente = strtotime ('+1 day', strtotime($fecha));
      $diasiguiente = date ('Y-m-d' , $diasiguiente);

      $servicios_activos = DB::table('servicios')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->leftJoin('servicios_aplicacion', 'servicios_aplicacion.servicio_id', '=', 'servicios.id')
      ->leftJoin('pago_servicios', 'pago_servicios.id', '=', 'servicios_aplicacion.pago_servicio_id')
      ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.recoger_en', 'servicios.dejar_en', 'servicios.notificaciones_reconfirmacion as codigo', 'servicios.desde', 'servicios.hasta', 'servicios.detalle_recorrido', 'servicios.estado_servicio_app', 'servicios.recoger_pasajero', 'conductores.nombre_completo', 'conductores.celular', 'conductores.foto_app', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'vehiculos.clase', 'vehiculos.ano', 'vehiculos.color', 'pago_servicios.valor', 'pago_servicios.numero_tarjeta', 'pago_servicios.tipo_tarjeta', 'pago_servicios.estado')
      ->whereBetween('servicios.fecha_servicio', [$diaanterior, $diasiguiente])
      ->where('servicios.estado_servicio_app', 1)
      ->where('servicios.app_user_id', $user->id)
      ->whereNull('servicios.pendiente_autori_eliminacion')
      //->whereNotNull('recorrido_gps')
      ->orderBy('servicios.fecha_servicio')
      ->orderBy('servicios.hora_servicio')
      ->first();

      $servicios_calificar = DB::table('servicios')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.recoger_en', 'servicios.dejar_en', 'servicios.estado_servicio_app', 'servicios.recoger_pasajero', 'servicios.calificacion_app_cliente_calidad', 'servicios.pendiente_autori_eliminacion', 'servicios.app_user_id', 'conductores.nombre_completo', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'vehiculos.clase', 'vehiculos.ano', 'vehiculos.color')
      ->where('servicios.fecha_servicio', '>', '20240318')
      ->where('servicios.app_user_id', $user->id)
      ->where('servicios.estado_servicio_app', 2)
      ->whereNull('servicios.pendiente_autori_eliminacion')
      ->whereNull('servicios.calificacion_app_cliente_calidad')
      ->first();

      $notificacion = DB::table('notificaciones')
      ->where('id_usuario',Input::get('user_id'))
      ->whereNull('leido')
      ->get();

      $notificacion = count($notificacion);

      if (count($servicios_activos)) {

        return Response::json([
          'response' => true,
          'servicios' => $servicios_activos,
          'notificacion' => $notificacion,
          'calificar' => $servicios_calificar
        ]);

      }else {

        return Response::json([
          'response' => false,
          'notificacion' => $notificacion,
          'calificar' => $servicios_calificar
        ]);

      }

    }

    public function postConsultas(){ //CONSULTAS V2 - ACTUAL

      $user = User::find(Input::get('user_id'));

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      $diasiguiente = strtotime ('+1 day', strtotime($fecha));
      $diasiguiente = date ('Y-m-d' , $diasiguiente);

      /*SERVICIO ACTIVO*/
      $servicios_activos = Servicio::where('app_user_id', $user->id)
      ->where('estado_servicio_app', 1)
      ->whereNull('pendiente_autori_eliminacion')
      ->whereBetween('fecha_servicio', [$diaanterior, $diasiguiente])
      ->whereNotNull('recorrido_gps')
      ->orderBy('fecha_servicio')
      ->orderBy('hora_servicio')
      //->with(['conductor', 'vehiculo'])
      ->first();
      /*SERVICIO ACTIVO*/

      /*Pago Pendiente*/
      $pago = DB::table('servicios_aplicacion')
      ->where('user_id', $user)
      ->whereNull('pago_servicio_id')
      ->whereNull('pago_facturacion')
      ->whereNull('cancelado')
      ->first();
      /*Pago Pendiente*/

      /*Calificación Pendiente*/
      $calificacion = DB::table('servicios')
      ->where('app_user_id', $user)
      ->where('estado_servicio_app',2)
      ->whereNull('calificacion_app_cliente_calidad')
      ->whereNull('calificacion_app_cliente_actitud')
      ->whereNull('pendiente_autori_eliminacion')
      ->first();
      /*Calificación Pendiente*/

      if(count($servicios_activos)){
        $servicio_activo = true;
      }else{
        $servicio_activo = false;
      }

      if(count($pago)){
        $pago_pendiente = true;
      }else{
        $pago_pendiente = false;
      }

      if(count($calificacion)){
        $calificacion_pendiente = true;
      }else{
        $calificacion_pendiente = false;
      }

      return Response::json([
        'response' => true,
        'servicio_activo' => $servicio_activo,
        'servicios' => $servicios_activos,
        'pago_pendiente' => $pago_pendiente,
        'pago' => $pago,
        'calificacion_pendiente' => $calificacion_pendiente,
        'calificacion' => $calificacion

      ]);

    }

    public function postNotificaciones(){

      $id = Input::get('user_id');

      $fechaActual = date('Y-m-d');
      $horaActual = date('H:i');

      $servicios = DB::table('servicios')
      ->select('servicios.id')
      ->where('app_user_id',$id)
      ->whereNull('pendiente_autori_eliminacion')
      ->where('fecha_servicio', '>=', $fechaActual)
      ->get();

      $notificaciones = DB::table('notificaciones')
      ->leftJoin('servicios', 'servicios.id', '=', 'notificaciones.id_servicio', 'seevicios.estado_servicio_app')
      ->select('notificaciones.*', 'servicios.fecha_servicio', 'servicios.hora_servicio')
      ->where('id_usuario',intval($id))
      ->where('servicios.fecha_servicio', '>=', $fechaActual)
      ->orderBy('fecha', 'DESC')
      ->get();

      if($notificaciones){

        $update = DB::table('notificaciones')
        ->where('id_usuario',intval($id))
        ->whereNull('leido')
        ->update([
          'leido'=> 1
        ]);

        return Response::json([
          'response' => true,
          'notificaciones' => $notificaciones,
          'servicios' => $servicios
        ]);

      }else{

        $update = DB::table('notificaciones')
        ->where('id_usuario',intval($id))
        ->whereNull('leido')
        ->update([
          'leido'=> 1
        ]);

        return Response::json([
          'response' => false,
          'usuario' => $id,
          'notificaciones' => $notificaciones,
          'servicios' => $servicios
        ]);

      }

    }

    public function postServicioprogramado(){

      $id = Input::get('id_servicio');
      $sw = Input::get('sw');

      if($sw===2){
        $id = Input::get('id_servicio');
        $id = intval($id);
      }

      $servicio = DB::table('servicios')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.recoger_en', 'servicios.dejar_en', 'servicios.detalle_recorrido', 'servicios.hora_servicio', 'conductores.nombre_completo', 'vehiculos.modelo', 'vehiculos.marca', 'vehiculos.placa', 'conductores.foto', 'conductores.celular')
      ->where('servicios.id',$id)
      ->first();

      if($servicio!=null){

        return Response::json([
          'response' => true,
          'servicio' => $servicio
        ]);

      }else{

        return Response::json([
          'response' => false
        ]);

      }
    }

    public function postEliminarcuenta(){

      $id_usuario = Input::get('id');

      $id_usuario = User::find($id_usuario);

      $update = DB::table('users')
      ->where('id',$id_usuario->id)
      ->update([
        'email' => NULL
      ]);

      if($update){

        return Response::json([
          'respuesta' => true,
          'usuario' => $id_usuario
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'usuario' => $id_usuario
        ]);

      }

    }

    //Validar los endpoints de la app driver old

    //APIV3

    //VERSIÓN FLUTTER
    public function postMisviajes(){

      $id = Input::get('id');
      $fecha = Input::get('fecha');

      $servicios = DB::table('servicios')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.conductor_id')
      ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.recoger_en', 'servicios.dejar_en', 'servicios.notificaciones_reconfirmacion as codigo', 'servicios.desde', 'servicios.hasta', 'servicios.detalle_recorrido', 'servicios.estado_servicio_app', 'servicios.recoger_pasajero', 'conductores.nombre_completo', 'conductores.celular', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'vehiculos.clase', 'vehiculos.ano', 'vehiculos.color')
      ->where('servicios.fecha_servicio',$fecha)
      ->where('app_user_id', $id)
      ->whereNull('pendiente_autori_eliminacion')
      ->orderBy('fecha_servicio')
      ->orderBy('hora_servicio')
      ->get();

      if (count($servicios)) {

        return Response::json([
            'response' => true,
            'servicios' => $servicios,
        ]);

      }else {

        return Response::json([
            'response' => false,
        ]);
      }

    }

    public function postProximosviajes(){

      $user = Input::get('id');

      $fechaActual = date('Y-m-d');
      $horaActual = date('H:i');

      $diezdias = strtotime('10 day', strtotime($fechaActual));
      $diezdias = date('Y-m-d' , $diezdias);

      $servicios = DB::table('servicios')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->leftJoin('servicios_aplicacion', 'servicios_aplicacion.servicio_id', '=', 'servicios.id')
      ->leftJoin('pago_servicios', 'pago_servicios.id', '=', 'servicios_aplicacion.pago_servicio_id')
      ->select('servicios.id', 'servicios.recoger_en', 'servicios.desde', 'servicios.dejar_en', 'servicios.hasta', 'servicios.detalle_recorrido', 'servicios.conductor_id', 'servicios.vehiculo_id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.pendiente_autori_eliminacion', 'servicios.estado_servicio_app', 'servicios.notificaciones_reconfirmacion as codigo', 'servicios.app_user_id', 'servicios.recoger_pasajero', 'conductores.nombre_completo', 'conductores.celular', 'conductores.foto_app', 'vehiculos.placa', 'vehiculos.clase', 'vehiculos.marca', 'vehiculos.modelo', 'vehiculos.ano', 'vehiculos.color', 'servicios_aplicacion.servicio_id', 'servicios_aplicacion.pago_servicio_id', 'pago_servicios.valor', 'pago_servicios.numero_tarjeta', 'pago_servicios.tipo_tarjeta', 'pago_servicios.estado')
      ->whereBetween('servicios.fecha_servicio', [$fechaActual, $diezdias])
      ->where('servicios.app_user_id', $user)
      ->whereNull('servicios.pendiente_autori_eliminacion')
      ->whereNull('servicios.estado_servicio_app')
      ->whereNull('servicios.cancelado_app')
      ->orderBy('servicios.fecha_servicio')
      ->orderBy('servicios.hora_servicio')
      ->get();

      if (count($servicios)) {

        return Response::json([
          'respuesta' => true,
          'servicios' => $servicios,
          'user_id' => $user
        ]);

      }else {

        return Response::json([
          'respuesta' => false,
          'servicios' => $servicios,
          'user_id' => $user
        ]);

      }

    }

    public function postProximasrutas(){

      $user = Input::get('id');
      $us = User::find($user);

      $fechaActual = date('Y-m-d');
      $horaActual = date('H:i');

      $diezdias = strtotime('4 day', strtotime($fechaActual));
      $diezdias = date('Y-m-d' , $diezdias);

      $servicios = DB::table('servicios')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->leftJoin('servicios_aplicacion', 'servicios_aplicacion.servicio_id', '=', 'servicios.id')
      ->leftJoin('qr_rutas', 'qr_rutas.servicio_id', '=', 'servicios.id')
      ->select('servicios.id', 'servicios.recoger_en', 'servicios.desde', 'servicios.dejar_en', 'servicios.hasta', 'servicios.detalle_recorrido', 'servicios.conductor_id', 'servicios.vehiculo_id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.pendiente_autori_eliminacion', 'servicios.estado_servicio_app', 'servicios.notificaciones_reconfirmacion as codigo', 'servicios.app_user_id', 'servicios.recoger_pasajero', 'conductores.nombre_completo', 'conductores.celular', 'conductores.foto_app', 'vehiculos.placa', 'vehiculos.clase', 'vehiculos.marca', 'vehiculos.modelo', 'vehiculos.ano', 'vehiculos.color', 'servicios_aplicacion.servicio_id', 'servicios_aplicacion.pago_servicio_id')
      ->whereBetween('servicios.fecha_servicio', [$fechaActual, $diezdias])
      ->where('qr_rutas.id_usuario', $us->identificacion)
      ->whereNull('servicios.pendiente_autori_eliminacion')
      ->whereNull('servicios.estado_servicio_app')
      ->orderBy('servicios.fecha_servicio')
      ->orderBy('servicios.hora_servicio')
      ->get();

      if (count($servicios)) {

        return Response::json([
          'respuesta' => true,
          'servicios' => $servicios,
          'user_id' => $user
        ]);

      }else {

        return Response::json([
          'respuesta' => false,
          'servicios' => $servicios,
          'user_id' => $user
        ]);

      }

    }

    public function postCalculartarifaservicio(){

      $id_usuario = Input::get('id');
      $distancia = Input::get('distancia'); //Distacia en metros (Ejemplo: 4291 = 4,3 km)
      $tiempo = Input::get('tiempo'); //Tiempo en segundos (Ejemolo: 863 = 14mins)
      $fecha = Input::get('fecha');
      $hora = Input::get('hora');
      $tipo_vehiculo = Input::get('tipo_vehiculo');

      $valor = 2800;

      $status = true;

      /*Código para calcular tarifa*/

      /*Cálculo del tiempo*/
      //SI EL SERVICIO NO SOBREPASA LOS 10 MINUTOS Y LA DISTANCIA ES MENOR A LOS 3KM, SE COBRA LA TARIFA MÍNIMA.
      if($tiempo<=600 and $distancia<3000){
        $valor_tarifa = 25000;
        //SI EL SERVICIO PASA LOS 10 MINUTOS(600seg), PERO NO HA RECORRIDO LOS 3KM(300m), SE COBRA LA TARIFA MÍNIMA, Y SE ADICIONAN 600 PESOS POR CADA MINUTO.
      }else if($tiempo>600 and $distancia<=3000){
        /*START COBRO TARIFA MÍNIMA MÁS (600*MIN)*/
        $valor_tarifa = 9000+(($tiempo-600)*5);
        if($valor_tarifa<25000){
          $valor_tarifa = 25000;
        }
        /*END COBRO TARIFA MÍNIMA MÁS (600*MIN)*/
        //SI EL SERVICIO PASÓ LOS 3KM SE COBRA EL VALOR DE LA TARIFA MÍNIMA, Y SE ADICIONAN 300 PESOS POR CADA 100 METROS (CONTANDO DESPUÉS DE LOS 3KM)
      }else if($distancia>3000){
        //CALCULAR DATOS DE TIEMPO NEW START
        $valor_tiempo = ($tiempo-600)*5;
        /* START COBRO TARIFA MÍNIMA MÁS (300*100M)*/
        $valor_tarifa = 9000+( (($distancia-3000)*3) );
        $valor_tarifa = $valor_tarifa+$valor_tiempo;

        if($valor_tarifa<25000){
          $valor_tarifa = 25000;
        }

        /* END COBRO TARIFA MÍNIMA MÁS (300*100M)*/
      }
      /*Cálculo por tiempo*/

      return Response::json([
        'response' => $status,
        'distancia' => $distancia,
        'tiempo' => $tiempo,
        'valor' => intval($valor_tarifa)
      ]);

    }

    public function postPedirservicio(){

        $valorTarifa = null;
        $user_id = Input::get('id');
        $sw = Input::get('sw');
        $idioma = Input::get('idioma');
        $cobro = Input::get('cobro');

        $tipo_solicitud = Input::get('tipo_solicitud');
        $ruta = Input::get('ruta');

        $nombre_empresa = Input::get('nombre_empresa');
        $address_recoger = Input::get('address_recoger');
        $address_destino = Input::get('address_destino');
        $fecha = Input::get('fecha');
        $hora = Input::get('hora');
        $nota = Input::get('nota');
        $tipo_vehiculo = Input::get('tipo_vehiculo');

        $recogerLatitude = Input::get('latitude_recoger');
        $recogerLongitude = Input::get('longitude_recoger');
        $destinoLatitude = Input::get('latitude_dejar');
        $destinoLongitude = Input::get('longitude_dejar');

        $valor = 10000;

        //Buscar el usuario que esta solicitando el servicio.
        $user = User::find($user_id);

        //Asignar a una variable si el usuario es empresarial o particular. esto para seleccionar la tarifa.
        if ($user->empresarial==1) {
          $tipo_cliente = 1;
        }else {
          $tipo_cliente = 2;
        }

        //Si el usuario ha sido activado entonces.
        if (!$user->activated!=1) {

          //Si el usuario es empresarial entonces crear el servicio para que aparezca en servicios de pago por facturacion
          if ($tipo_solicitud==1) { // Convenio corporativo

            $servicio_aplicacion = new Servicioaplicacion();

            $servicio_aplicacion->address_destino = $address_destino;
            $servicio_aplicacion->address_recoger = $address_recoger;
            $servicio_aplicacion->destinoLatitude = $destinoLatitude;
            $servicio_aplicacion->destinoLongitude = $destinoLongitude;
            //ervicio_aplicacion->destino_zona = $request->destino_zona;
            //$servicio_aplicacion->recoger_zona = $request->recoger_zona;
            $servicio_aplicacion->fecha = $fecha;
            $fechasText = 'el dia y hora: '.$servicio_aplicacion->fecha;

            $servicio_aplicacion->formatted_address_destino = $address_destino;
            $servicio_aplicacion->formatted_address_recoger = $address_recoger;
            $servicio_aplicacion->recogerLatitude = $recogerLatitude;
            $servicio_aplicacion->recogerLongitude = $recogerLongitude;
            $hora = str_replace(" ","", $hora);

            $servicio_aplicacion->hora = $hora;
            $servicio_aplicacion->nota = $nota;
            $servicio_aplicacion->tipo_vehiculo = $tipo_vehiculo;
            $servicio_aplicacion->user_id = $user_id;
            $servicio_aplicacion->empresa = $nombre_empresa;
            //$servicio_aplicacion->pago_facturacion = 1;

            $servicio_aplicacion->tarifado = 1;

            $servicio_aplicacion->pago_facturacion_fecha = date('Y-m-d H:i:s');

            $user = User::find($user_id);

            $servicio_aplicacion->empresarial = 1;

            if ($servicio_aplicacion->save()) {

              if ($servicio_aplicacion->correo_confirmacion!=null) {

                $emailcc = 'aotourdeveloper@gmail.com';
                $correo = $correo_confirmacion;
                $datos = [
                  'servicio_aplicacion' => $servicio_aplicacion,
                  'first_name' => $user->first_name,
                  'last_name' => $user->last_name
                ];

                if($idioma=='en'){

                  Mail::send('mobile.client.confirmacion_servicio_en', $datos, function($message) use ($correo, $emailcc){
                    $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
                    $message->to($correo)->subject('Service confirmation');
                    $message->cc($emailcc);
                  });

                }else{

                  Mail::send('mobile.client.confirmacion_servicio', $datos, function($message) use ($correo, $emailcc){
                    $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
                    $message->to($correo)->subject('Confirmacion de servicio');
                    $message->cc($emailcc);
                  });

                }

              }

              $idpusher = "578229";
              $keypusher = "a8962410987941f477a1";
              $secretpusher = "6a73b30cfd22bc7ac574";

              //CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
              $channel = 'servicios';
              $name = 'mobile';

              $sin_tarifa = Servicioaplicacion::sintarifa()->count();
              $pagados = Servicioaplicacion::pagados()->count();
              $empresarial = Servicioaplicacion::Pagofacturacion()->count();
              $cancelados = Servicio::canceladoapp()->count();

              $data = json_encode([
                'sin_tarifa' => $sin_tarifa,
                'cancelados' => $cancelados,
                'empresarial' => $empresarial,
                'pagados' => $pagados
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

              /*ENVÍO DE CORREO A OPERACIONES*/
              $emailcc = 'aotourdeveloper@gmail.com';
              $correoOperaciones = ['transportebarranquilla@aotour.com.co', 'transportebogota@aotour.com.co'];
              $datos = [
                'servicio_aplicacion' => $servicio_aplicacion,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name
              ];
              Mail::send('mobile.client.confirmacion_servicio', $datos, function($message) use ($correoOperaciones, $emailcc){
                $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
                $message->to($correoOperaciones)->subject('Confirmacion de servicio');
                $message->cc($emailcc);
              });
              //ENVÍO DE CORREO A OPERACIONES*/

              //ENVÍO DE WHATSAPP

              $numberBAQ = 573012030290;
              $numberBOG = 573012633287;
              $cliente = DB::table('centrosdecosto')
              ->where('id', $user->centrodecosto_id)
              ->pluck('razonsocial');

              $ch = curl_init();

              curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
              curl_setopt($ch, CURLOPT_HEADER, FALSE);

              curl_setopt($ch, CURLOPT_POST, TRUE);

              curl_setopt($ch, CURLOPT_POSTFIELDS, "{
                \"messaging_product\": \"whatsapp\",
                \"to\": \"".$numberBAQ."\",
                \"type\": \"template\",
                \"template\": {
                  \"name\": \"service_request\",
                  \"language\": {
                    \"code\": \"es\",
                  },
                  \"components\": [{
                    \"type\": \"body\",
                    \"parameters\": [{
                      \"type\": \"text\",
                      \"text\": \"".$cliente."\",
                    },
                    {
                      \"type\": \"text\",
                      \"text\": \"".$fecha."\",
                    },
                    {
                      \"type\": \"text\",
                      \"text\": \"".$hora."\",
                    }]
                  }]
                }
              }");

              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer EAAHPlqcJlZCMBAMDLjgTat7TlxvpmDq1fgzt2gZBPUnEsTyEuxuJw9uvGJM1WrWtpN7fmpmn3G2KXFZBRIGLKEDhZBPZAeyUSy2OYiIcNEf2mQuFcW67sgGoU95VkYayreD5iBx2GbnZBgaGvS8shX6f2JKeBp7pm9TNLm2EZBEbcx0Sdg47miONZCpUNZCfqEWlZAFxkltEOBPAZDZD"
              ));

              $response = curl_exec($ch);
              curl_close($ch);

              //BOG
              $ch = curl_init();

              curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
              curl_setopt($ch, CURLOPT_HEADER, FALSE);

              curl_setopt($ch, CURLOPT_POST, TRUE);

              curl_setopt($ch, CURLOPT_POSTFIELDS, "{
                \"messaging_product\": \"whatsapp\",
                \"to\": \"".$numberBOG."\",
                \"type\": \"template\",
                \"template\": {
                  \"name\": \"service_request\",
                  \"language\": {
                    \"code\": \"es\",
                  },
                  \"components\": [{
                    \"type\": \"body\",
                    \"parameters\": [{
                      \"type\": \"text\",
                      \"text\": \"".$cliente."\",
                    },
                    {
                      \"type\": \"text\",
                      \"text\": \"".$fecha."\",
                    },
                    {
                      \"type\": \"text\",
                      \"text\": \"".$hora."\",
                    }]
                  }]
                }
              }");

              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer EAAHPlqcJlZCMBAMDLjgTat7TlxvpmDq1fgzt2gZBPUnEsTyEuxuJw9uvGJM1WrWtpN7fmpmn3G2KXFZBRIGLKEDhZBPZAeyUSy2OYiIcNEf2mQuFcW67sgGoU95VkYayreD5iBx2GbnZBgaGvS8shX6f2JKeBp7pm9TNLm2EZBEbcx0Sdg47miONZCpUNZCfqEWlZAFxkltEOBPAZDZD"
              ));

              $response = curl_exec($ch);
              curl_close($ch);

              return Response::json([
                'response' => true,
                'estado' => 'APROVED',
                'tipo_cliente' => $tipo_cliente,
              ]);

            }

          }else { //SERVICIO PARTICULAR

            $servicios_aplicacion = new Servicioaplicacion();

            $servicios_aplicacion->address_destino = $address_destino;
            $servicios_aplicacion->address_recoger = $address_recoger;
            $servicios_aplicacion->destinoLatitude = $destinoLatitude;
            $servicios_aplicacion->destinoLongitude = $destinoLongitude;
            $servicios_aplicacion->fecha = $fecha;
            $servicios_aplicacion->formatted_address_destino = $address_destino;
            $servicios_aplicacion->formatted_address_recoger = $address_recoger;

            $hora = date("G:i", strtotime(str_replace(" ","", $hora)));

            $servicios_aplicacion->hora = $hora;
            $servicios_aplicacion->nota = $nota;
            $servicios_aplicacion->recogerLatitude = $recogerLatitude;
            $servicios_aplicacion->recogerLongitude = $recogerLongitude;
            $servicios_aplicacion->tipo_vehiculo = $tipo_vehiculo;
            $servicios_aplicacion->user_id = $user_id;
            $servicios_aplicacion->esperando_tarifa = 1;

            $servicios_aplicacion->esperando_tarifa = 1;
            $servicios_aplicacion->pago_pendiente = 1;
            $servicios_aplicacion->liquidacion_pendiente = 1;
            $servicios_aplicacion->valor = $valor;

            $user = User::find($user_id);

            if ($user->empresarial==1) {
              $servicios_aplicacion->empresarial = 1;
            }

            if ($servicios_aplicacion->save()) {

              /*$result = Notification::enviarMensaje('El usuario '.ucwords(strtolower($user->first_name.' '.$user->last_name)).
              ' ha solicitado la tarifa de un servicio en '.ucwords(strtolower($request->tipo_vehiculo)).' para el dia '.
              $request->fecha.' '.$hora.', revisa el listado de servicios sin tarifar para que le envies la tarifa del servicio!');

              if($request->idioma=='english'){
                $sms1 = 'In moments we will be reviewing your request, please wait a moment while we send you the information.';
              }else{
                $sms1 = 'En momentos estaremos revisando su solicitud por favor espere un momento mientras le enviamos la informacion.';
              }*/

              $idpusher = "578229";
              $keypusher = "a8962410987941f477a1";
              $secretpusher = "6a73b30cfd22bc7ac574";

              //CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
              $channel = 'servicios';
              $name = 'mobile';

              $sin_tarifa = Servicioaplicacion::sintarifa()->count();
              $pagados = Servicioaplicacion::pagados()->count();
              $empresarial = Servicioaplicacion::Pagofacturacion()->count();
              $cancelados = Servicio::canceladoapp()->count();

              $data = json_encode([
                'sin_tarifa' => $sin_tarifa,
                'cancelados' => $cancelados,
                'empresarial' => $empresarial,
                'pagados' => $pagados
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

              /*ENVÍO DE CORREO A OPERACIONES
              $emailcc = 'aotourdeveloper@gmail.com';
              $correoOperaciones = ['transportebarranquilla@aotour.com.co', 'transportebogota@aotour.com.co'];
              $datos = [
                'servicio_aplicacion' => $servicios_aplicacion,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name
              ];
              Mail::send('mobile.client.confirmacion_servicio', $datos, function($message) use ($correoOperaciones, $emailcc){
                $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
                $message->to($correoOperaciones)->subject('Confirmacion de servicio');
                $message->cc($emailcc);
              });
              //ENVÍO DE CORREO A OPERACIONES*/




              //pago de servicio
              $id_usuario = $user_id;
              $id_tarjeta = Input::get('id_tarjeta');
              $lastFour = Input::get('lastFour');
              $paymentMethod = Input::get('paymentMethod');
              $valor_servicio = 10000;

              $queryCard = DB::table('tokens_payu')
              ->where('id',$id_tarjeta)
              ->first();

              $usuario = User::find($id_usuario);

              //$apiUrl = "https://sandbox.wompi.co/v1/transactions"; //URL DE PRUEBAS
              $apiUrl = "https://production.wompi.co/v1/transactions"; //URL DE PRODUCCIÓN
              $valorReal = $valor_servicio.'00';

              $referenceCode = 'up_by_aotour_'.date('YmdHis');

              $referencia = new ReferenciasPayu;
              $referencia->reference_code = $referenceCode;
              $referencia->user_id = $user_id;
              $referencia->servicio_aplicacion_id = $servicios_aplicacion->id;
              $referencia->lastfour = $lastFour;
              $referencia->paymentMethod = $paymentMethod;
              $referencia->save();

              $data = [
                "amount_in_cents" => intval($valorReal),
                "currency" => "COP",
                "customer_email" => $usuario->email,
                "payment_method" => [
                  "installments" => 1
                ],
                "reference" => $referenceCode,
                "payment_source_id" => $queryCard->fuente_pago,
              ];
              $headers = [
                'Accept: application/json',
                'Authorization: Bearer prv_test_aZ1VdvKqmz91uyEBsiqQAuswY2ZSpFIl', //links pruebas aotour
                //'Authorization: Bearer prv_prod_WJ9PkFir6uPwOPwstzfI8LsfPPedpRda', //links productivo aotour
              ];
              $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $apiUrl);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
              $result = curl_exec($ch);

              curl_close($ch);

              $result = json_decode($result);

              /*return Response::json([
                'respuesta' => true,
                'result' => $result
              ]);*/

              $estado = $result->data->status;
              $transaction = $result->data->id;

              if($estado==='APPROVED'){

                $cardPay = $result->data->payment_method->extra->last_four;
                $cardType = $result->data->payment_method->extra->brand;

                $pago = new PagoServicio;
                $pago->reference_code = $referenceCode;
                $pago->order_id = $result->transactionResponse->orderId;
                $pago->user_id = $id_usuario;
                $pago->valor = $valor;
                $pago->numero_tarjeta = '************'.$cardPay;
                $pago->tipo_tarjeta =  $cardType;
                $pago->estado =  $estado;

                if ($pago->save()) {

                  return Response::json([
                    'response' => true,
                    'transaccion' => $result,
                    'estado' => $estado,
                    'transaccion' => $transaction
                  ]);

                }else{

                  return Response::json([
                    'response' => false,
                    'transaccion' => $result,
                    'estado' => $estado,
                    'transaccion' => $transaction
                  ]);

                }

              }else{

                return Response::json([
                  'response' => true,
                  'transaccion' => $result,
                  'estado' => $estado,
                  'transaccion' => $transaction
                ]);

              }

            
              //pago de servicio

              return Response::json([
                'response' => true,
              ]);

            }

            //}

          }

        }else {
            if($request->idioma==='english'){
              $mensaje1 = 'You cannot request services yet, you must activate your email account.';
              $mensaje2 = 'You cannot request services yet, we are confirming your data.';

            }else{
              $mensaje1 = 'Aun no puedes solicitar servicios, debes activar tu cuenta de mail.';
              $mensaje2 = 'Aun no puedes solicitar servicios, estamos confirmando tus datos.';
            }

            if ($user->empresarial!=1) {
              $message = $mensaje1;
            }else {
              $message = $mensaje2;
            }

            return response()->json([
              'response' => false,
              'message' => $message
            ]);

        }
    }

    /*Ruta*/
    public function postPedirruta() {

      $valorTarifa = null;
      $user_id = Input::get('id');
      $sw = Input::get('sw');
      $idioma = Input::get('idioma');
      $cobro = Input::get('cobro');

      $tipo_solicitud = Input::get('tipo_solicitud');
      $ruta = Input::get('ruta');

      $nombre_empresa = Input::get('nombre_empresa');
      $address_recoger = Input::get('address_recoger');
      $address_destino = Input::get('address_destino');
      $fecha = Input::get('fecha');
      $hora = Input::get('hora');
      $nota = Input::get('nota');
      $tipo_vehiculo = Input::get('tipo_vehiculo');

      $recogerLatitude = Input::get('latitude_recoger');
      $recogerLongitude = Input::get('longitude_recoger');
      $destinoLatitude = Input::get('latitude_dejar');
      $destinoLongitude = Input::get('longitude_dejar');

      $valor = 10000;

      $user = User::find($user_id);

      //Si el usuario ha sido activado entonces.
      if (!$user->activated!=1) {

        $servicio_aplicacion = new Servicioaplicacion();

        $servicio_aplicacion->address_destino = $address_destino;
        $servicio_aplicacion->address_recoger = $address_recoger;
        $servicio_aplicacion->destinoLatitude = $destinoLatitude;
        $servicio_aplicacion->destinoLongitude = $destinoLongitude;
        
        $servicio_aplicacion->fecha = $fecha;
        $fechasText = 'el dia y hora: '.$servicio_aplicacion->fecha;

        $servicio_aplicacion->formatted_address_destino = $address_destino;
        $servicio_aplicacion->formatted_address_recoger = $address_recoger;
        $servicio_aplicacion->recogerLatitude = $recogerLatitude;
        $servicio_aplicacion->recogerLongitude = $recogerLongitude;
        $hora = str_replace(" ","", $hora);

        $servicio_aplicacion->hora = $hora;
        $servicio_aplicacion->nota = $nota;
        $servicio_aplicacion->tipo_vehiculo = $tipo_vehiculo;
        $servicio_aplicacion->user_id = $user_id;
        $servicio_aplicacion->empresa = $nombre_empresa;

        $user = User::find($user_id);

        $servicio_aplicacion->empresarial = 1;

        if ($servicio_aplicacion->save()) {

          //ENVÍO DE CORREO A OPERACIONES*/
          
          return Response::json([
            'response' => true
          ]);

        }

      }else {

          if($request->idioma==='english'){
            $mensaje2 = 'You cannot request services.';
          }else{
            $mensaje2 = 'No puedes solicitar servicios.';
          }

          $message = $mensaje2;

          return response()->json([
            'response' => false,
            'message' => $message
          ]);

      }
    }
    /*Ruta*/

    public function postEditardatos() {

      $empresa = Input::get('empresa');
      $id_empleado = Input::get('id_empleado');
      $user_id = Input::get('user_id');

      $user = User::find($user_id);
      $user->empresa = trim(strtoupper(strtolower($empresa)));
      $user->id_empleado = $id_empleado;
      $user->save();

      return Response::json([
        'response' => true
      ]);

    }

    public function postRutaactiva(){

      $user = User::find(Input::get('id'));

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      $diasiguiente = strtotime ('+1 day', strtotime($fecha));
      $diasiguiente = date ('Y-m-d' , $diasiguiente);

      $servicios_activos = DB::table('servicios')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->leftJoin('servicios_aplicacion', 'servicios_aplicacion.servicio_id', '=', 'servicios.id')
      ->leftJoin('qr_rutas', 'qr_rutas.servicio_id', '=', 'servicios.id')
      ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.recoger_en', 'servicios.dejar_en', 'servicios.notificaciones_reconfirmacion as codigo', 'servicios.desde', 'servicios.hasta', 'servicios.tipo_ruta', 'servicios.detalle_recorrido', 'servicios.estado_servicio_app', 'servicios.recoger_pasajero', 'conductores.nombre_completo', 'conductores.celular', 'conductores.foto_app', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'vehiculos.clase', 'vehiculos.ano', 'vehiculos.color', 'qr_rutas.status', 'qr_rutas.id_usuario', 'qr_rutas.fullname', 'qr_rutas.address', 'qr_rutas.location', 'qr_rutas.coords', 'qr_rutas.sw')
      ->whereBetween('servicios.fecha_servicio', [$diaanterior, $diasiguiente])
      ->where('servicios.estado_servicio_app', 1)
      ->where('qr_rutas.id_usuario', $user->id_empleado)
      ->whereNull('servicios.pendiente_autori_eliminacion')
      //->whereNotNull('recorrido_gps')
      ->orderBy('servicios.fecha_servicio')
      ->orderBy('servicios.hora_servicio')
      ->first();

      $servicios_calificar = DB::table('servicios')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->leftJoin('qr_rutas', 'qr_rutas.servicio_id', '=', 'servicios.id')
      ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.recoger_en', 'servicios.dejar_en', 'servicios.estado_servicio_app', 'servicios.recoger_pasajero', 'servicios.calificacion_app_cliente_calidad', 'servicios.pendiente_autori_eliminacion', 'servicios.app_user_id', 'conductores.nombre_completo', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'vehiculos.clase', 'vehiculos.ano', 'vehiculos.color', 'qr_rutas.id as qr_id')
      ->where('servicios.fecha_servicio', '>', '20240420')
      ->where('qr_rutas.id_usuario', $user->id_empleado)
      ->where('servicios.estado_servicio_app', 2)
      ->where('qr_rutas.status',1)
      ->whereNull('servicios.pendiente_autori_eliminacion')
      ->whereNull('qr_rutas.rate')
      ->first();

      if (count($servicios_activos)) {

        return Response::json([
          'response' => true,
          'servicios' => $servicios_activos,
          'calificar' => $servicios_calificar
        ]);

      }else {

        return Response::json([
          'response' => false,
          'calificar' => $servicios_calificar
        ]);

      }

    }

    public function postRutassolicitadas() {

      $id = Input::get('id_empleado');

      $query = "SELECT id, nombres, id_empleado, fecha, hora, direccion, barrio, localidad, programa, latitude, longitude, confirmado FROM pasajeros_rutas WHERE id_empleado = ".$id." and fecha >= '".date('Y-m-d')."'";

      $consulta = DB::select($query);

      if($consulta) {

        return Response::json([
          'response' => true,
          'solicitudes' => $consulta
        ]);

      }else{

        return Response::json([
          'response' => false,
          'solicitudes' => $consulta
        ]);

      }

    }

    public function postConfirmardireccion() {

      $id = Input::get('id');
      $direccion = Input::get('direccion');
      $latitude = Input::get('latitude');
      $longitude = Input::get('longitude');

      $update = PasajeroRuta::find($id);

      if($update->confirmado==1) {

        return Response::json([
          'response' => false
        ]);

      }else{

        $update->direccion = $direccion;
        $update->latitude = $latitude;
        $update->longitude = $longitude;
        $update->confirmado = 1;
        $update->save();

        return Response::json([
          'response' => true
        ]);

      }

    }

    public function postReintentarpago () {

      $service_id = Input::get('servicios_aplicacion_id');
      $card_id = Input::get('id_tarjeta');
      $lastFour = Input::get('lastFour');
      $paymentMethod = Input::get('paymentMethod');

      $servicio = DB::table('servicios_aplicacion')
      ->where('id',$service_id)
      ->first();

      $queryCard = DB::table('tokens_payu')
      ->where('id',$card_id)
      ->first();

      //pago de servicio
      $id_usuario = $servicio->user_id;
      $valor_servicio = $servicio->valor;

      $usuario = User::find($id_usuario);

      //$apiUrl = "https://sandbox.wompi.co/v1/transactions"; //URL DE PRUEBAS
      $apiUrl = "https://production.wompi.co/v1/transactions"; //URL DE PRODUCCIÓN
      $valorReal = $valor_servicio.'00';

      $pago_servicio_id = DB::table('servicios_aplicacion')
      ->where('id',$service_id)
      ->pluck('pago_servicio_id');

      $pending = DB::table('pago_servicios')
      ->where('id',$pago_servicio_id)
      ->update([
        'estado' => 'PENDING'
      ]);

      $referenceOld = DB::table('referencias_payu')
      ->where('servicio_aplicacion_id',$service_id)
      ->first();

      $data = [
        "amount_in_cents" => intval($valorReal),
        "currency" => "COP",
        "customer_email" => $usuario->email,
        "payment_method" => [
          "installments" => 1
        ],
        "reference" => $referenceOld->reference_code,
        "payment_source_id" => $queryCard->fuente_pago,
      ];
      $headers = [
        'Accept: application/json',
        'Authorization: Bearer prv_test_aZ1VdvKqmz91uyEBsiqQAuswY2ZSpFIl', //links pruebas aotour
        //'Authorization: Bearer prv_prod_WJ9PkFir6uPwOPwstzfI8LsfPPedpRda', //links productivo aotour
      ];
      $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      $result = curl_exec($ch);

      curl_close($ch);

      $result = json_decode($result);

      $estado = $result->data->status;
      $transaction = $result->data->id;

      if($estado==='APPROVED'){

        $cardPay = $result->data->payment_method->extra->last_four;
        $cardType = $result->data->payment_method->extra->brand;

        $updatePago = DB::table('pago_servicios')
        ->where('id',$pago_servicio_id)
        ->update([
          //'reference_code' => $referenceCode,
          'order_id' => $result->transactionResponse->orderId,
          'numero_tarjeta' => '************'.$lastFour,
          'tipo_tarjeta' => $cardType,
          'estado' => $estado
        ]);

        if ($updatePago) {

          return Response::json([
            'response' => true,
            'transaccion' => $result,
            'estado' => $estado,
            'transaccion' => $transaction
          ]);

        }else{

          return Response::json([
            'response' => false,
            'transaccion' => $result,
            'estado' => $estado,
            'transaccion' => $transaction
          ]);

        }

      }else{

        return Response::json([
          'response' => true,
          'transaccion' => $result,
          'estado' => $estado,
          'transaccion' => $transaction
        ]);

      }


    }

    public function postServiciospedidos(){

      $user_id = Input::get('id');

      $user = User::find($user_id);

      $servicios = DB::table('servicios_aplicacion')
      ->LeftJoin('servicios', 'servicios.id', '=', 'servicios_aplicacion.servicio_id')
      ->LeftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->leftJoin('pago_servicios', 'servicios_aplicacion.pago_servicio_id', '=', 'pago_servicios.id')
      ->select('servicios_aplicacion.*', 'servicios.id as id_servicio', 'servicios.pendiente_autori_eliminacion', 'conductores.nombre_completo', 'conductores.celular', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.detalle_recorrido', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'pago_servicios.estado as estado_pago')
      ->whereNull('servicios_aplicacion.cancelado')
      ->whereNull('servicios.pendiente_autori_eliminacion')
      ->where('servicios_aplicacion.user_id', $user_id)
      ->whereNull('servicios.estado_servicio_app')
      ->orderBy('servicios_aplicacion.fecha', 'asc')
      ->orderBy('servicios_aplicacion.hora', 'asc')
      ->get();

      if (count($servicios)) {

        return Response::json([
          'respuesta' => true,
          'servicios' => $servicios,
          'user_id' => $user_id
        ]);

      }else {

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postGuardarlugar() {

      $id = Input::get('id');
      $nombre = Input::get('nombre');
      $direccion = Input::get('direccion');
      $latitude = Input::get('latitude');
      $longitude = Input::get('longitude');

      $lugar = new LugarF;
      $lugar->nombre = $nombre;
      $lugar->direccion = $direccion;
      $lugar->latitude = $latitude;
      $lugar->longitude = $longitude;
      $lugar->usuario = $id;
      $lugar->save();

      return Response::json([
        'respuesta' => true
      ]);

    }

    public function postEditarlugar() {

      $id = Input::get('id');
      $nombre = Input::get('nombre');
      $direccion = Input::get('direccion');
      $latitude = Input::get('latitude');
      $longitude = Input::get('longitude');

      $lugar = LugarF::find($id);

      if($lugar){

        $lugar->nombre = $nombre;
        $lugar->direccion = $direccion;
        $lugar->latitude;
        $lugar->longitude;
        $lugar->save();

        return Response::json([
          'respuesta' => true
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postEliminarlugar() {

      $id = Input::get('id');

      $consulta = DB::table('lugares')
      ->where('id',$id)
      ->delete();

      if($consulta){

        return Response::json([
          'respuesta' => true
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postListarlugares() {

      $id = Input::get('id');

      $consulta = DB::table('lugares')
      ->where('usuario',$id)
      ->get();

      if($consulta){

        return Response::json([
          'respuesta' => true,
          'lugares' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'lugares' => $consulta
        ]);

      }

    }

    public function postConsultarcodigo() {

      $id = Input::get('id');

      $codigo = DB::table('servicios')
      ->where('id',$id)
      ->pluck('notificaciones_reconfirmacion');

      return Response::json([
        'response' => true,
        'codigo' => $codigo
      ]);

    }

    public function postCalificacionderuta(){

        $tipo = Input::get('valor');
        $id = Input::get('id');
        $comentarios = Input::get('comentarios');

        $servicio = DB::table('qr_rutas')
        ->where('id',$id)
        ->update([
            'rate' => $tipo,
            'comentarios' => trim(strtoupper($comentarios))
        ]);

        return Response::json([
            'respuesta' => true,
            'tipo' => $tipo,
            'id' => $id
        ]);

    }

}
