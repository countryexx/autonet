<?php
use App\User;
use App\Controllers\Controller;

class EscolarController extends BaseController{

    public function getIndex(){

        if (Sentry::check()){
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->transporteescolar->gestionusuarios->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on') {
            return View::make('admin.permisos');
        }else{

            $centrosdecosto = Centrodecosto::where('id',341)->get();

            return View::make('escolar.create')
                ->with('centrosdecosto',$centrosdecosto)
                ->with('permisos',$permisos)
                ->with('o',$o=1);
        }
    }

    public function postImportarexcelp(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          $var = '';

          Excel::selectSheetsByIndex(0)->load(Input::file('excel'), function($reader){
              $reader->skip(1);
              $result = $reader->noHeading()->get();
              $cc = DB::table('centrosdecosto')->where('id',Input::get('centrodecosto_id'))->pluck('razonsocial');
              $pasajerosArray = [];
              foreach($result as $value){

                $contrato = $value[0];

                $tipo_ruta = $value[1];

                if(is_string($value[1])){

                $dataExcel = [
                     'contrato'=> strtoupper(trim($contrato)),
                     'tipo_ruta'=> strtoupper($tipo_ruta),
                     'nombre_estudiante'=>strtoupper(trim($value[2])),
                     'curso'=>strtoupper(trim($value[3])),
                     'telefono'=>strtoupper(trim($value[4])),
                     'direccion'=>strtoupper(trim($value[5])),
                     'barrio'=>strtoupper(trim($value[6])),
                     'localidad'=>strtoupper(trim($value[7])),
                     'zona'=>strtoupper(trim($value[8])),
                     'nombre_padre'=>strtoupper(trim($value[9])),
                     'valor'=>strtoupper(trim($value[10])),
                     'ruta'=>strtoupper(trim($value[11])),
                  ];
                  array_push($pasajerosArray, $dataExcel);

                }
              }
              echo json_encode([
                'pasajeros' => $pasajerosArray
              ]);

          });
      }

    }//SG

    public function postCrearusuarios(){

      if (!Sentry::check()){

        return Response::json([
            'respuesta' => 'relogin'
        ]);

      }else{

        $usuarios = json_decode(Input::get('pasajeros'));
        $sw=0;
        $sw2 = 0;
        $existen = 0;
        $creados = 0;
        foreach ($usuarios as $user) {

          /*VALIDAR SI EL USUARIO YA EXISTE PARA NO AGREGARLO*/
          $buscar = DB::table('escolar')->where('contrato',$user->contrato)->first();
          if($buscar!=null){
            $existen++;
          }else{
            $creados++;
            $usuario = new Escolar();
            $usuario->contrato = $user->contrato;
            $usuario->tipo_ruta = $user->tipo_ruta;
            $usuario->nombre_estudiante = $user->nombre_estudiante;
            $usuario->curso = $user->curso;
            $usuario->telefono = $user->telefono;
            $usuario->direccion = $user->direccion;
            $usuario->barrio = $user->barrio;
            $usuario->localidad = $user->localidad;
            $usuario->zona = $user->zona;
            $usuario->nombre_padre = $user->nombre_padre;

            $usuario->valor = $user->valor;
            $usuario->ruta = $user->ruta;

            $usuario->save();

            $qr_code = DNS2D::getBarcodePNG($user->contrato, "QRCODE", 10, 10,array(1,1,1), true);

            Image::make($qr_code)->save('biblioteca_imagenes/escolar/codigos/'.$user->contrato.'.png');

            /*CÓDIGO DE CREACIÓN DE USUARIOS*/

            $name_user = 'AOESC'.$user->contrato;

            $usuario = Sentry::createUser([
                'username'     => $name_user,
                'password'  => $user->telefono,
                'activated' => true,
                'first_name'=>$user->nombre_padre,
                'last_name'=>null,
                'usuario_portal'=>3,
                'identificacion' => $user->contrato,
                'id_rol' => 51,
            ]);

            /*Código de envío de mensaje: USUARIO Y CONTRASEÑA*/
            $post['to'] = array('57'.$user->telefono);
            $post['text'] = "AOTOUR le informa la creacion de su usuario AUTONET. LINK: http://165.227.54.86/autonet/, USUARIO: ".$name_user.", CLAVE: su numero de celular.";
            $post['from'] = "msg";
            $user ="Aotour";
            $password = 'Tour20+';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://sms.puntodigitalip.com/Api/rest/message");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
            curl_setopt($ch, CURLOPT_HTTPHEADER,
            array(
              "Accept: application/json",
              "Authorization: Basic ".base64_encode($user.":".$password)));
            $result = curl_exec ($ch);
            /*Código de envío de mensaje: USUARIO Y CONTRASEÑA*/

          }

        }

        if($creados!=0){

          return Response::json([
            'respuesta'=>true,
            'existen' => $existen,
            'creados' => $creados
          ]);

        }else if($existen!=0){

          return Response::json([
            'respuesta'=>false,
            'existen' => $existen,
            'creados' => $creados
          ]);

        }

      }
    }//SG

    //LISTADO DE USUARIOS ESCOLARES
    public function getListado(){

      if(Sentry::check()){
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->transporteescolar->gestionusuarios->ver;
      }else{
        $ver = null;
      }

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else if($ver!='on'){
        return View::make('admin.permisos');
      }else{

        $query = DB::table('escolar')->get();
        $o = 1;

        return View::make('escolar.listado', [
          'usuarios' => $query,
          'permisos' =>$permisos,
          'o' => $o
        ]);
      }
    }
    //FIN VISTA DE GESTIÓN DE LOS PAGOS

    public function postActivar(){
      if(Request::ajax()){
        $id = Input::get('id');

        $user = Escolar::find($id);
        $user->estado = null;
        $user->save();

        return Response::json([
          'respuesta' => true,
        ]);
      }
    }

    public function postDesactivar(){
      if(Request::ajax()){
        $id = Input::get('id');

        $user = Escolar::find($id);
        $user->estado = 1;
        $user->save();

        return Response::json([
          'respuesta' => true
        ]);
      }
    }

    public function postReenviarcodigo(){

      if(Request::ajax()){

        $id = Input::get('id');

        $consulta = DB::table('escolar')->where('id',$id)->first();

        $name_user = 'AOESC'.$consulta->contrato;

        /*Código de envío del enlace para descarga del código qr*/
        $post['to'] = array('57'.$consulta->telefono);
        //$post['text'] = "Sr(a) ".$consulta->nombre_padre.", el código QR para el transporte de su hijo(a) lo podrá descargar en el siguiente enlace. https://app.aotour.com.co/autonet/transporteescolar/descargarcodigoqr/".$consulta->contrato.".";
        $post['text'] = "AOTOUR le informa la creacion de su usuario AUTONET. LINK: https://app.aotour.com.co/autonet/, USUARIO: ".$name_user.", CLAVE: su numero de celular.";
        $post['from'] = "msg";
        $user ="Aotour";
        $password = 'Tour20+';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sms.puntodigitalip.com/Api/rest/message");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($ch, CURLOPT_HTTPHEADER,
        array(
          "Accept: application/json",
          "Authorization: Basic ".base64_encode($user.":".$password)));
        $result = curl_exec ($ch);
        /*Código de envío del enlace para descarga del código qr*/

        return Response::json([
          'respuesta' => true
        ]);
      }

    }

    public function getDescargarcodigo($data){

        return View::make('escolar.enlace_qr', [
          'data' => $data,
        ]);

    }

    public function postWompi(){

      //CONSULTA DE USUARIOS
      $usuarios = DB::table('escolar')->whereNull('estado')->get();

      $fecha = explode('-', date('Y-m-d'));
      $mes = $fecha[1];
      $ano = $fecha[0];

      $completa = $ano.'-'.$mes.'-30T04:59:59';

      foreach($usuarios as $usuario){

        $valor = $usuario->valor;
  			$valor2 = $valor.'00';

        $pago = new EscolarP();
        $pago->contrato = $usuario->contrato;
        $pago->mes = $mes;
        $pago->ano = $ano;
        $pago->estado_pago = 0;
        $pago->mora = 0;
        $pago->valor_ordinario = $usuario->valor;
        $pago->link = null;
        $pago->save();

        /*INICIO CREACIÓN DE LINK DINÁMICO*/
        $apiUrl = "https://production.wompi.co/v1/payment_links"; //links de pago productivo
        //$apiUrl = "https://sandbox.wompi.co/v1/payment_links"; //links de pago pruebas
        //$ApiKey = "Bearer prv_prod_cVJvfcfo7LeK8jrKWmp7TweNWcN7uGgO"; //links de pago productivo samuel
        $ApiKey = "Bearer prv_prod_WJ9PkFir6uPwOPwstzfI8LsfPPedpRda"; //links de pago productivo aotour

        $data = [
          "name" => "TRANSPORTE ESCOLAR AOTOUR",
          "description" => "Pague aquí la mensualidad del transporte del estudiante ".$usuario->nombre_estudiante."",
          "single_use" => true,
          "collect_shipping" => false,
          "currency" => "COP",
          "expires_at"=> $completa,
          //"redirect_url" => "http://localhost/autonet/transporteescolar/pago/".$pago->id, //pruebas
          "redirect_url" => "https://app.aotour.com.co/autonet/transporteescolar/pago/".$pago->id, //producción
          "amount_in_cents" => intval($valor2),
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
        /*FIN CREACIÓN DE LINK DINÁMICO*/

        $pago->link = 'https://checkout.wompi.co/l/'.$result->data->id;
        $pago->save();

      }

      return Response::json([
        'respuesta' => true,
      ]);

    }

    public function getPago($id){

      //$decrypted = Crypt::decryptString($id);

      //$link =  http_build_url();
      $host= $_SERVER["REQUEST_URI"];

      $host = explode("/", $host);
      $host = $host[4];

      $host = explode("&", $host);
      $host = $host[0];

      $host = explode("=", $host);
      $host = $host[1];

      //$response = file_get_contents('https://sandbox.wompi.co/v1/transactions/'.$host.''); //prueba
      $response = file_get_contents('https://production.wompi.co/v1/transactions/'.$host.''); //producción
			$response = json_decode($response);

      $host = $response->data->status;

      if($host==='APPROVED'){

        $consulta = DB::table('escolar_pagos')
        ->where('id',$id)->first();

        if($consulta->estado_pago!=1){
          $pago = DB::table('escolar_pagos')
            ->where('id', $id)
            ->update([
              'estado_pago'=>1,
          ]);
        }

        $estado = 1;

      }else{
        $estado = 0;
      }

      return View::make('escolar.pago_realizado', [
        'id' => $id,
        'estado' => $estado
      ]);

    }

    //INICIO VISTA DE GESTIÓN DE LOS PAGOS
    public function getPagos(){

      if(Sentry::check()){
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->contabilidad->listado_de_pagos_preparar->ver;
      }else{
        $ver = null;
      }

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else if($ver!='on'){
        return View::make('admin.permisos');
      }else{

        $fecha = explode('-', date('Y-m-d'));
    		$mes = $fecha[1];

        $query = DB::table('escolar_pagos')
        ->leftJoin('escolar', 'escolar_pagos.contrato', '=', 'escolar.contrato')
        ->select('escolar_pagos.*', 'escolar.nombre_padre','escolar.nombre_estudiante', 'escolar.tipo_ruta')
        ->where('escolar_pagos.mes',$mes)
        ->get();
        $o = 1;

        return View::make('escolar.pagos', [
          'pagos' => $query,
          'permisos' =>$permisos,
          'o' => $o
        ]);
      }
    }
    //FIN VISTA DE GESTIÓN DE LOS PAGOS

    public function postBuscarusuarios(){

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

        if (Request::ajax()){

          $selected = Input::get('selected');

          if($selected==='ESTADO'){
            $usuarios = DB::table('escolar')->get();
          }else if($selected==='ACTIVOS'){
            $usuarios = DB::table('escolar')->whereNull('estado')->get();
          }else if($selected ==='INACTIVOS'){
            $usuarios = DB::table('escolar')->where('estado',1)->get();
          }

          if($usuarios!=null){

            return Response::json([
              'mensaje'=>true,
              'usuarios' => $usuarios,
            ]);

          }else{

            return Response::json([
              'mensaje'=>false,
            ]);

          }



        }
      }
    }

    //BUSCAR PAGOS
    public function postBuscar(){

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

        if (Request::ajax()){

          $option_mes = Input::get('option_mes');
          $option_ano = Input::get('option_ano');

          if($option_mes==='MES' or $option_ano==='AÑO'){

            return Response::json([
              'mensaje'=>'incompleto',
            ]);

          }else{

            $sw = 0;

            $fecha = explode('-', date('Y-m-d'));
            $dia = intval($fecha[2]);

            $consulta = "select escolar_pagos.id, escolar_pagos.contrato, escolar_pagos.mes, escolar_pagos.ano, escolar_pagos.estado_pago, escolar_pagos.mora, escolar_pagos.valor_ordinario, escolar_pagos.valor_mora, escolar_pagos.link, escolar_pagos.link_mora, ".
                "escolar.tipo_ruta, escolar.nombre_estudiante, escolar.telefono, escolar.direccion, escolar.barrio, escolar.nombre_padre, escolar.valor, escolar.estado ".
                "from escolar_pagos ".
                "left join escolar on escolar_pagos.contrato = escolar.contrato ";

            $consulta .=" where escolar_pagos.mes = '".$option_mes."' ";
            $consulta .="and escolar_pagos.ano = ".$option_ano."";

            $pagos = DB::select(DB::raw($consulta));

            if($pagos!=null){

              return Response::json([
                'mensaje'=>true,
                'option_mes' => $option_mes,
                'option_ano' => $option_ano,
                'pagos' => $pagos,
                'sw' => $sw,
                'dia' => $dia
              ]);

            }else{

              return Response::json([
                'mensaje'=>false,
                'consulta' => $pagos,
                'option_mes' => $option_mes,
              ]);

            }

          }

        }
      }
    }

    public function postReenviarlink(){

      $id = Input::get('id');

      $consulta = DB::table('escolar_pagos')->where('id',$id)->first();

      if($consulta->mora===1){
        $link = $consulta->link_mora;
      }else{
        $link = $consulta->link;
      }

      $numero = '3013869946';

      $post['to'] = array('57'.$numero);
      $post['text'] = "Sr(a) Samuel, Aotour le indica el link para generar su pago. Si ya lo realizó, haga caso omiso al mensaje. Link: ".parse_str($link);
      $post['from'] = "msg";
      $user ="Aotour";
      $password = 'Tour20+';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "http://sms.puntodigitalip.com/Api/rest/message");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
      curl_setopt($ch, CURLOPT_HTTPHEADER,
      array(
        "Accept: application/json",
        "Authorization: Basic ".base64_encode($user.":".$password)));
      $result = curl_exec ($ch);
      /*CÓDIGO DE REENVÍO DEL CÓDIGO POR MEDIO DE MENSAJE DE TEXTO*/

      return Response::json([
        'respuesta' => true,
        'link' => $link
      ]);

    }

    public function postLinkmora(){

      /*VALIDAR SI ES POSIBLE HACER EL LINK CON RECARGO DEPENDIENDO DE LA FECHA*/

      $id = Input::get('id');
      $valor = Input::get('valor');
      $nombre = Input::get('nombre');
      $valor_mora = $valor + ($valor*0.10);

      //$valor = $usuario->valor;
      $valor2 = $valor_mora.'00';

      /*INICIO CREACIÓN DE LINK DINÁMICO*/
      $apiUrl = "https://production.wompi.co/v1/payment_links"; //links de pago productivo
      //$apiUrl = "https://sandbox.wompi.co/v1/payment_links"; //links de pago pruebas
      $ApiKey = "Bearer prv_prod_cVJvfcfo7LeK8jrKWmp7TweNWcN7uGgO";

      //$encrypted = Crypt::encryptString($id);

      $data = [
        "name" => "TRANSPORTE ESCOLAR AOTOUR - RECARGO 10%",
        "description" => "Pague aquí la mensualidad del transporte del estudiante ".$nombre."",
        "single_use" => true,
        "collect_shipping" => false,
        //"redirect_url" => "http://localhost/autonet/transporteescolar/pago/".$id, //pruebas
        "redirect_url" => "https://app.aotour.com.co/autonet/transporteescolar/pago/".$id, //producción
        "currency" => "COP",
        "amount_in_cents" => intval($valor2),
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
      /*FIN CREACIÓN DE LINK DINÁMICO*/

      $pago = EscolarP::find($id);//DB::table('escolar_pagos')->where('id',$id)->first();
      $pago->mora = 1;
      $pago->valor_mora = $valor_mora; //obtener de la misma consulta
      $pago->link_mora = 'https://checkout.wompi.co/l/'.$result->data->id;

      if($pago->save()){

        /*Código de envío de mensaje de texto*/

        return Response::json([
          'respuesta' => true,
          'id' => $id,
          'valor' => $valor,
          'mora' => $valor_mora
        ]);

      }

    }

    public function getSeguimiento(){

      if (Sentry::check()){
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->escolar->gestion->ver;
      }else{
          $ver = null;
      }

      if (!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on') {
          return View::make('admin.permisos');
      }else{

        $id = Sentry::getUser()->identificacion;

        $escolar = DB::table('escolar')->where('contrato',$id)->first();

        return View::make('escolar.usuarios.seguimiento')
            ->with('data',$escolar->contrato)
            ->with('escolar',$escolar)
            ->with('permisos',$permisos);
      }

    }

    public function getDescargarcodigoqr($id){

      $contrato = Crypt::decryptString($id);

      $usuario = Escolar::where('contrato',$contrato)->first();

      $html = View::make('escolar.usuarios.qrcode')->with([
        'usuario' => $usuario,
      ]);

      return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('CODIGO QR '.$contrato);

    }

    public function getEnlacesdepago(){

      if (Sentry::check()){
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->escolar->gestion->ver;
      }else{
          $ver = null;
      }

      if (!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on') {
          return View::make('admin.permisos');
      }else{

        $id = Sentry::getUser()->identificacion;

        $pagos = DB::table('escolar_pagos')->where('contrato',$id)->orderBy('id')->get();

        return View::make('escolar.usuarios.pagos')
            ->with('pagos',$pagos)
            ->with('permisos',$permisos)
            ->with('o',$o=1);
      }

    }

    public function getSeguimientoservicios(){

      if (Sentry::check()){
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->escolar->gestion->ver;
      }else{
          $ver = null;
      }

      if (!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on') {
          return View::make('admin.permisos');
      }else{

        $id = Sentry::getUser()->identificacion;

        $pagos = DB::table('escolar_pagos')->where('contrato',$id)->orderBy('id')->get();

        $hora = date('H:i');
        $fecha_actual = date('Y-m-d');
        //$hora = date('H:i',strtotime('-120 minute',strtotime($hora)));

        $servicios = DB::table('servicios')
        ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.estado_servicio_app', 'escolar_qr.servicio_id', 'escolar_qr.usuario', 'escolar_qr.novedad_c', 'escolar_qr.novedad_p', 'escolar_qr.estado_ruta')
        ->leftJoin('escolar_qr', 'servicios.id', '=', 'escolar_qr.servicio_id')
        ->where('escolar_qr.usuario', $id)
        ->where('servicios.fecha_servicio', $fecha_actual)
        ->orderBy('servicios.fecha_servicio', 'ASC')
        ->get();

        return View::make('escolar.usuarios.servicios')
            ->with('pagos',$pagos)
            ->with('servicios',$servicios)
            ->with('contrato',$id)
            ->with('permisos',$permisos)
            ->with('hora',$hora)
            ->with('fecha_actual',$fecha_actual)
            ->with('o',$o=1);
      }

    }

    public function postNovedad(){

      $id_servicio = Input::get('id_servicio');
      $usuario = Input::get('usuario');
      $novedad = Input::get('novedad');

      $update = DB::table('escolar_qr')
      ->where('servicio_id',$id_servicio)
      ->where('usuario',$usuario)
      ->update([
        'novedad_p' => $novedad,
      ]);

      if($update){

        return Response::json([
          'respuesta' => true,
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
        ]);

      }
    }

    public function postBorrarnovedad(){

      $id_servicio = Input::get('id_servicio');
      $usuario = Input::get('usuario');

      $update = DB::table('escolar_qr')
      ->where('servicio_id',$id_servicio)
      ->where('usuario',$usuario)
      ->update([
        'novedad_p' => null,
      ]);

      if($update){

        return Response::json([
          'respuesta' => true,
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
        ]);

      }
    }

    public function getTracking($code){

      if (Sentry::check()){
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->escolar->gestion->ver;
      }else{
          $ver = null;
      }

      if (!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on') {
          return View::make('admin.permisos');
      }else{

        $decrypted = Crypt::decryptString($code);
        //$decrypted = $code;
        $consult = Servicio::find($decrypted);

        if(isset($consult)){

          if($consult->pendiente_autori_eliminacion==1){
            return View::make('servicios.gps.eliminado')
            ->with([
              'id_ser' => $decrypted
            ]);
          }else{

            $id = Sentry::getUser()->identificacion;
            //CONSULTA DE DIRECCIÓN, CONTRATO.
            $data = DB::table('escolar')->where('contrato',$id)->first();

            $query = Servicio::select('servicios.*', 'conductores.nombre_completo', 'conductores.cc', 'conductores.foto', 'conductores.celular', 'vehiculos.color','vehiculos.placa','vehiculos.modelo', 'vehiculos.marca', 'vehiculos.clase', 'servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'centrosdecosto.razonsocial', 'escolar_qr.novedad_c', 'escolar_qr.estado_ruta')
            ->leftJoin('escolar_qr', 'servicios.id', '=', 'escolar_qr.servicio_id')
            ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
            ->leftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
            ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
            ->where('servicios.id',$decrypted);

            $servicio = $query->orderBy('hora_servicio')->first();

            return View::make('escolar.usuarios.tracking')
            ->with([
              'servicios' => $servicio,
              'id_ser' => $decrypted,
              'data' => $data
            ]);
          }
        }else{
          return View::make('servicios.gps.eliminado')
            ->with([
              'id_ser' => $decrypted,
            ]);
        }
      }
    }

    public function postServicioruta(){

      $servicio_id = Input::get('id');

      $servicio = Servicio::find($servicio_id);
      $conductor = DB::table('conductores')->where('id',$servicio->conductor_id)->pluck('nombre_completo');

      if ($servicio) {
        return Response::json([
            'respuesta' => true,
            'servicio'=> $servicio,
            'conductor' => $conductor
        ]);
      }
    }

      public function postActualizarmapaviaje(){

        $id = Input::get('id');
        $servicio = DB::table('servicios')->where('id', $id)->pluck('recorrido_gps');
        $estado = DB::table('servicios')->where('id', $id)->pluck('estado_servicio_app');

          return Response::json([
              'servicio' => $servicio,
              'estado' => $estado,
              'respuesta' => true
          ]);

  }

  public function postBuscarservicios(){

    if(!Sentry::check()){
    return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else{

      if (Request::ajax()){

        $fecha = Input::get('fecha_inicial');

        $id_rol = Sentry::getUser()->id_rol;

        $id = Sentry::getUser()->identificacion;

        $hora = date('H:i');
        $fecha_actual = date('Y-m-d');
        $hora = date('H:i',strtotime('+120 minute',strtotime($hora)));

          $consulta = "select servicios.id, servicios.fecha_servicio, servicios.hora_servicio, servicios.estado_servicio_app, ".
              "escolar_qr.usuario, escolar_qr.estado_ruta, escolar_qr.novedad_p, escolar_qr.novedad_c ".
              "from servicios ".
              "left join escolar_qr on escolar_qr.servicio_id = servicios.id ".
              "where escolar_qr.usuario = '".$id."' AND servicios.fecha_servicio = '".$fecha."' ";

          $services = DB::select(DB::raw($consulta." order by servicios.fecha_servicio asc"));

          if ($services!=null) {

            $idArray = [];
            foreach ($services as $servicio){
              $array = [
                'id_encriptado' => Crypt::encryptString($servicio->id)
              ];
              array_push($idArray, $array);
            }

            return Response::json([
              'mensaje'=>true,
              'servicios'=>$services,
              'id_number'=>$idArray,
              'hora'=>$hora,
              'fecha_actual'=>$fecha_actual,
            ]);

          }else{

            return Response::json([
              'mensaje'=>false,
              'consulta'=>$consulta,
            ]);
          }
      }
    }
  }


}
