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

            /*Código de envío de mensaje: USUARIO Y CONTRASEÑA
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
            Código de envío de mensaje: USUARIO Y CONTRASEÑA*/

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

    //Links con acceso con mas tiempo tiempo en completa
    /*public function postWompi(){

      //CONSULTA DE USUARIOS
      //$usuarios = DB::table('escolar')
      //->where('id',192)
      //->whereNull('estado')->get();

      $usuarios = DB::table('escolar')
      ->leftJoin('escolar_pagos', 'escolar_pagos.contrato', '=', 'escolar.contrato')
      ->select('escolar_pagos.id', 'escolar.contrato', 'escolar.nombre_estudiante', 'escolar.valor', 'escolar_pagos.estado_pago')
      ->where('escolar_pagos.estado_pago',0)
      ->get();

      //->whereBetween('id',[358,422])

      $fecha = explode('-', date('Y-m-d'));
      $mes = $fecha[1];
      $ano = $fecha[0];

      //$completa = $ano.'-'.$mes.'-30T04:59:59';
      $completa = $ano.'-02-13T04:59:59';

      foreach($usuarios as $usuario){

        $valor = $usuario->valor;
  			$valor2 = $valor.'00';

        //INICIO CREACIÓN DE LINK DINÁMICO
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
          //"redirect_url" => "https://app.aotour.com.co/autonet/transporteescolar/pago/".$pago->id, //producción
          "redirect_url" => "http://165.227.54.86/autonet/transporteescolar/pago/".$usuario->id, //producción
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
        //FIN CREACIÓN DE LINK DINÁMICO

        $guardarLink = DB::table('escolar_pagos')
        ->where('contrato',$usuario->contrato)
        ->update([
            'link'=> 'https://checkout.wompi.co/l/'.$result->data->id,
        ]);

        //$pago->link = 'https://checkout.wompi.co/l/'.$result->data->id;
        //$pago->save();

      }

      return Response::json([
        'respuesta' => true,
      ]);

    }*/

    //ORIGINAL
    public function postWompi(){

      $mes_g = Input::get('mes');
      $ano_g = Input::get('ano');

      //CONSULTA DE USUARIOS
      $usuarios = DB::table('escolar')
      ->whereIn('contrato',[2694,2695,2696,2697,2698])
      //->whereNull('estado')
      ->get();

      //$pagos = DB::table('escolar_pagos')
      //->where('mes',$mes_g)
      //->where('ano',$ano_g)
      //->first();

      /*$usuarios = DB::table('escolar')
      ->leftJoin('escolar_pagos', 'escolar_pagos.contrato', '=', 'escolar.contrato')
      ->select('escolar.id', 'escolar.contrato', 'escolar.nombre_estudiante', 'escolar.valor', 'escolar_pagos.estado_pago')
      ->whereNull('escolar_pagos.estado_pago')
      ->get();*/

      if($mes_g<10){
        $mes_link = '0'.$mes_g;
      }else{
        $mes_link = $mes_g;
      }

      //->whereBetween('id',[358,422])

      $fecha = explode('-', date('Y-m-d'));
      //$mes = $fecha[1];
      //$ano = $fecha[0];

      //$completa = $ano.'-'.$mes.'-30T04:59:59';
      //$completa = '2022-02-13T04:59:59';
      $completa = $ano_g.'-'.$mes_link.'-12T04:59:59';

      $var = 0;

      foreach($usuarios as $usuario){
        $var++;
        $valor = $usuario->valor;
  			$valor2 = $valor.'00';

        $pago = new EscolarP();
        $pago->contrato = $usuario->contrato;
        $pago->mes = $mes_g;//$mes;
        $pago->ano = $ano_g;
        $pago->estado_pago = 0;
        $pago->mora = 0;
        $pago->valor_ordinario = $usuario->valor;
        $pago->link = null;
        $pago->save();

        //INICIO CREACIÓN DE LINK DINÁMICO
        $apiUrl = "https://production.wompi.co/v1/payment_links"; //links de pago productivo
        //$apiUrl = "https://sandbox.wompi.co/v1/payment_links"; //links de pago pruebas
        $ApiKey = "Bearer prv_prod_cVJvfcfo7LeK8jrKWmp7TweNWcN7uGgO"; //links de pago productivo samuel
        //$ApiKey = "Bearer prv_prod_WJ9PkFir6uPwOPwstzfI8LsfPPedpRda"; //links de pago productivo aotour
        $referenceCode = $ano_g.'-'.$mes_link.'_transporte_escolar_aotour_'.$usuario->contrato.'_'.date('YmdHis');
        $data = [
          "name" => "TRANSPORTE ESCOLAR AOTOUR",
          "description" => "Pague aquí la mensualidad del transporte del estudiante ".$usuario->nombre_estudiante."",
          "single_use" => true,
          "collect_shipping" => false,
          "currency" => "COP",
          "expires_at"=> $completa,
          "reference" => $referenceCode,
          //"redirect_url" => "http://localhost/autonet/transporteescolar/pago/".$pago->id, //pruebas
          //"redirect_url" => "https://app.aotour.com.co/autonet/transporteescolar/pago/".$pago->id, //producción
          "redirect_url" => "http://165.227.54.86/autonet/transporteescolar/pago/".$pago->id, //producción
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
        //FIN CREACIÓN DE LINK DINÁMICO

        $pago->link = 'https://checkout.wompi.co/l/'.$result->data->id;
        $pago->save();

      }

      return Response::json([
        'respuesta' => true,
        'mes' => $mes_g,
        'ano' => $ano_g,
        'count' => $var
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

      $transaccion = $host;

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
              'metodo_pago'=>$response->data->payment_method_type,
              'id_transaccion' => $transaccion
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
    		//$mes = $fecha[1];
        $mes = 3;//$fecha[1];

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

            $consulta = "select escolar_pagos.id, escolar_pagos.contrato, escolar_pagos.mes, escolar_pagos.ano, escolar_pagos.estado_pago, escolar_pagos.mora, escolar_pagos.valor_ordinario, escolar_pagos.valor_mora, escolar_pagos.link, escolar_pagos.link_mora, escolar_pagos.soporte_pdf, escolar_pagos.metodo_pago, escolar_pagos.id_transaccion, escolar_pagos.facturado, ".
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
        //"redirect_url" => "https://app.aotour.com.co/autonet/transporteescolar/pago/".$id, //producción
        "redirect_url" => "http://165.227.54.86/autonet/transporteescolar/pago/".$id, //producción
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

    public function postGuardarsoporte(){

      $id = Input::get('id');

      if (Input::hasFile('pdf_soporte')){

        $file_pdf = Input::file('pdf_soporte');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/escolar/soporte_pagos/';
        $file_pdf->move($ubicacion_pdf, $id.$name_pdf);
        $pdf_soporte = $id.$name_pdf;

        $update = DB::table('escolar_pagos')
        ->where('id',$id)
        ->update([
          'estado_pago' => 1,
          'metodo_pago' => 'CONSIGNACIÓN',
          'soporte_pdf' => $pdf_soporte
        ]);

        return Response::json([
          'respuesta' => true
        ]);

      }else{

        $pdf_soporte = null;
        return Response::json([
          'respuesta' => false
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

    public function postCambiarnumero(){

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

        if (Request::ajax()){

            $id = Input::get('id');
            $numero = Input::get('numero');
            $contrato = Input::get('contrato');

            $update = DB::table('escolar')
            ->where('id',$id)
            ->update([
              'telefono' => $numero,
            ]);

            if($update){

              $pass = DB::table('users')
              ->where('identificacion',$contrato)
              ->update([
                'password' => Hash::make($numero),
              ]);

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

    public function postUsuarios(){

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

        if (Request::ajax()){

          $consulta = DB::table('escolar')
          ->leftJoin('users', 'users.identificacion', '=', 'escolar.contrato')
          ->select('escolar.id', 'escolar.contrato', 'escolar.nombre_estudiante', 'escolar.telefono', 'escolar.valor', 'escolar.nombre_padre', 'users.last_login')
          ->whereNull('users.last_login')
          ->get();

          $contador = 0;

          foreach ($consulta as $user) {

              $contador++;

              $name_user = 'AOESC'.$user->contrato;

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

          if($consulta){

            return Response::json([
              'respuesta' => true,
              'contador' => $contador,
              'usuarios' => $consulta
            ]);

          }else{

            return Response::json([
              'respuesta' => false,
            ]);
          }
        }
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

  public function postFacturar(){

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else{

      if(Request::ajax()){

        $id = Input::get('id_pago');
        $contrato = Input::get('contrato');

        $pago = DB::table('escolar_pagos')
        ->where('id',$id)
        ->first();

        $valor_ordinario = $pago->valor_ordinario;
        $valor_de_mora = $pago->valor_mora;

        if($pago->mora==1){
          $valor_factura = $pago->valor_mora;

          $valor_utilidad_factura = (intval($valor_ordinario)*0.935)-(intval($valor_de_mora));

        }else{

          $valor_factura = $pago->valor_ordinario;
          //$valor_utilidad_factura = 0;
          $valor_utilidad_factura = intval($valor_ordinario)*0.065;

        }

        $valor_cliente_factura = intval($valor_factura);
        $valor_proveedor_factura = intval($valor_ordinario)*0.935;

        //Consulta de proveedores con convenio de pagos

        $mes = Input::get('mes');

        $ano = Input::get('ano');

        if($mes==1 || $mes==3 || $mes==5 || $mes==7 || $mes==8 || $mes==10 || $mes==12){
          $dia_final = '-31';
        }else if($mes==4 || $mes==6 || $mes==9 || $mes==11){
          $dia_final = '-30';
        }else if($mes==2){
          $dia_final = '-28';
        }

        if($mes<10){
          $mes = '0'.$mes;
        }

        //$mes = '01';
        $fecha_inicial = $ano.'-'.$mes.'-01';
        $fecha_final = $ano.'-'.$mes.$dia_final;

        $servicios = DB::table('servicios')
        ->select('escolar_qr.*', 'servicios.fecha_servicio', 'servicios.id as id_servicio', 'servicios.hora_servicio')
        ->leftJoin('escolar_qr', 'escolar_qr.servicio_id', '=', 'servicios.id')
        ->where('escolar_qr.usuario', $contrato)
        ->whereBetween('servicios.fecha_servicio',[$fecha_inicial,$fecha_final])
        ->whereNull('servicios.pendiente_autori_eliminacion')
        ->get();

        $cantidad = count($servicios);
        $countSamu = null;

        $proveedor = DB::table('servicios')
        ->select('escolar_qr.id', 'escolar_qr.servicio_id', 'servicios.pendiente_autori_eliminacion', 'servicios.fecha_servicio', 'servicios.proveedor_id')
        ->leftJoin('escolar_qr', 'escolar_qr.servicio_id', '=', 'servicios.id')
        ->where('escolar_qr.usuario', $contrato)
        ->whereBetween('servicios.fecha_servicio',[$fecha_inicial,$fecha_final])
        ->whereNull('servicios.pendiente_autori_eliminacion')
        ->where('servicios.centrodecosto_id',341)
        ->first();

        if($proveedor->proveedor_id===536 || $proveedor->proveedor_id===408){ //MARÍA CAMILA RAMÍREZ & INVERSIONES ALCAYA (SÓLO DESCUENTOS DE LEY)

          $valor_proveedor_factura = intval($valor_ordinario);
          $valor_cliente_factura = $valor_factura;

          if($pago->mora==1){
            $valor_utilidad_factura = intval($valor_ordinario)-(intval($valor_de_mora));
          }else{
            $valor_utilidad_factura = 0;
          }
        }

        if($proveedor->proveedor_id===1961){

          $samu = DB::table('servicios')
          ->select('proveedores.id', 'servicios.fecha_servicio', 'servicios.proveedor_id', 'servicios.centrodecosto_id')
          ->leftJoin('proveedores', 'proveedores.id', '=', 'servicios.proveedor_id')
          //->leftJoin('facturacion', 'facturacion.servicio_id', '=', 'servicios.id')
          ->whereBetween('servicios.fecha_servicio',[$fecha_inicial,$fecha_final])
          ->where('proveedores.id',196)
          ->whereNull('servicios.pendiente_autori_eliminacion')
          ->where('servicios.centrodecosto_id',341)
          ->get();

          $countSamu = count($samu);

          $valor_proveedor_factura = 8000/intval($countSamu);

        }else if($proveedor->proveedor_id===345){ // 345 ADELA LEGUIZAMON $ 2,800,000

          $samu = DB::table('servicios')
          ->select('proveedores.id', 'servicios.fecha_servicio', 'servicios.proveedor_id', 'servicios.centrodecosto_id')
          ->leftJoin('proveedores', 'proveedores.id', '=', 'servicios.proveedor_id')
          //->leftJoin('facturacion', 'facturacion.servicio_id', '=', 'servicios.id')
          ->whereBetween('servicios.fecha_servicio',[$fecha_inicial,$fecha_final])
          ->where('proveedores.id',345)
          ->whereNull('servicios.pendiente_autori_eliminacion')
          ->where('servicios.centrodecosto_id',341)
          ->get();

          $countSamu = count($samu);

          $valor_proveedor_factura = (2800000*0.935)/intval($countSamu);

          $valor_utilidad_factura = $valor_factura-$valor_proveedor_factura;

          /*UTULIDAD DEL 10% CUANDO EL PROVEEDOR ES ADELA LEGUIZAMON*/

        }else if($proveedor->proveedor_id===351){ // 351 JAIRO SEBASTIAN ZULUAGA $ 1,400,000

          $samu = DB::table('servicios')
          ->select('proveedores.id', 'servicios.fecha_servicio', 'servicios.proveedor_id', 'servicios.centrodecosto_id')
          ->leftJoin('proveedores', 'proveedores.id', '=', 'servicios.proveedor_id')
          //->leftJoin('facturacion', 'facturacion.servicio_id', '=', 'servicios.id')
          ->whereBetween('servicios.fecha_servicio',[$fecha_inicial,$fecha_final])
          ->where('proveedores.id',351)
          ->whereNull('servicios.pendiente_autori_eliminacion')
          ->where('servicios.centrodecosto_id',341)
          ->get();

          $countSamu = count($samu);

          $valor_proveedor_factura = 1400000/intval($countSamu);

          /*UTILIDAD DEL 0% CUANDO EL PROVEEDOR ES JAIRO ZULUAGA*/

        }else{

          $samu = DB::table('servicios')
          ->select('proveedores.id', 'servicios.fecha_servicio', 'servicios.proveedor_id', 'servicios.centrodecosto_id')
          ->leftJoin('proveedores', 'proveedores.id', '=', 'servicios.proveedor_id')
          //->leftJoin('facturacion', 'facturacion.servicio_id', '=', 'servicios.id')
          ->whereBetween('servicios.fecha_servicio',[$fecha_inicial,$fecha_final])
          ->where('proveedores.id',$proveedor->proveedor_id)
          ->whereNull('servicios.pendiente_autori_eliminacion')
          ->where('servicios.centrodecosto_id',341)
          ->get();

          $countSamu = count($samu);

          $valor_proveedor_factura = $valor_proveedor_factura;///intval($countSamu);
        }

        $valor_por_servicio_qr = $valor_proveedor_factura;
        $valor_por_servicio = intval($valor_proveedor_factura)/intval($cantidad);
        $valor_por_servicio_cliente = intval($valor_cliente_factura)/intval($cantidad);

        //GENERACIÓN DE LA FACTURA

        $ultimo_id = DB::table('ordenes_facturacion')
        ->select('id','numero_factura')
        ->orderBy('id','desc')
        ->first();

        $buscar_subcentro = DB::table('subcentrosdecosto')
        ->where('identificacion',$contrato)
        ->first();

        if($buscar_subcentro!=null){
          $contrato_factura = $buscar_subcentro->id;
        }else{

          $nombre_sub = DB::table('escolar')
          ->where('contrato',$contrato)
          ->pluck('nombre_padre');

          $nuevo = new Subcentro;
          $nuevo->nombresubcentro = $nombre_sub;
          $nuevo->centrosdecosto_id = 341;
          $nuevo->identificacion = $contrato;
          $nuevo->save();

          $contrato_factura = $nuevo->id;

        }

        $orden_facturacion = new Ordenfactura;
        $orden_facturacion->centrodecosto_id = 341;
        $orden_facturacion->subcentrodecosto_id = $contrato_factura;
        $orden_facturacion->contrato = $contrato;
        $orden_facturacion->ciudad = 'BOGOTA';
        $orden_facturacion->fecha_expedicion = date('Y-m-d H:i:s');
        $orden_facturacion->fecha_inicial = $fecha_inicial;
        $orden_facturacion->fecha_final = $fecha_final;
        $orden_facturacion->tipo_orden = 1;
        $orden_facturacion->total_facturado_cliente = $valor_factura;
        $orden_facturacion->total_costo = $valor_proveedor_factura;
        $orden_facturacion->total_utilidad = $valor_utilidad_factura;
        $orden_facturacion->numero_factura = intval($ultimo_id->numero_factura)+1;
        $orden_facturacion->creado_por = Sentry::getUser()->id;
        $orden_facturacion->fecha_factura = date('Y-m-d');
        //$orden_facturacion->otros_ingresos = Input::get('otros_ingresos');
        //$orden_facturacion->otros_costos = Input::get('otros_costos');
        //$orden_facturacion->observaciones = Input::get('observaciones_liq');
        $orden_facturacion->facturado = 1;

        $orden_facturacion->save();

        $id_facturas = $orden_facturacion->id;

        $orden = Ordenfactura::find($id_facturas);

        if (strlen(intval($id_facturas))===1) {
            $orden->consecutivo = 'AT000'.$id_facturas;
            $orden->save();
        }elseif (strlen(intval($id_facturas))===2) {
            $orden->consecutivo = 'AT00'.$id_facturas;
            $orden->save();
        }elseif(strlen(intval($id_facturas))===3){
            $orden->consecutivo = 'AT0'.$id_facturas;
            $orden->save();
        }elseif(strlen(intval($id_facturas))===4){
            $orden->consecutivo = 'AT'.$id_facturas;
            $orden->save();
        }elseif(strlen(intval($id_facturas))===5){
            $orden->consecutivo = 'AT'.$id_facturas;
            $orden->save();
        }

        foreach($servicios as $servicio){

          //CONSULTAR SI EL SERVICIO SE ENCUENTRA EN OTRA FACTURA PARA AÑADIRLE LA COMA Y LA OTRA FACTURA
          $query = DB::table('facturacion')
          ->where('servicio_id',$servicio->id_servicio)
          ->first();

          if($query!=null){
            $id_factura = $query->facturas_id.$id_facturas.',';

            $cobrado = $query->total_cobrado;
            $pagado = $query->total_pagado;

            $total_c = doubleval($cobrado)+doubleval($valor_por_servicio_cliente);
            $total_p = doubleval($pagado)+(doubleval($valor_por_servicio));
            $utility = doubleval($total_c)-doubleval($total_p);

            /*ACTUALIZACIÓN DE VALORES EN LA TABLA DE FACTURACIÓN*/
            $actualizar = DB::table('facturacion')
            ->where('servicio_id',$servicio->id_servicio)
            ->update([
              'facturas_id' => $id_factura,
              'unitario_cobrado' => $total_c,
              'unitario_pagado' => $total_p,
              'total_cobrado' => $total_c,
              'total_pagado' => $total_p,
              'utilidad' => $utility
            ]);

            /*ACTUALIZACIÓN DE VALORES EN LA TABLA DE USUARIOS (SERVICIOS INDIVIDUALES)*/
            $update_valor_qr = DB::table('escolar_qr')
            ->where('servicio_id', $servicio->id_servicio)
            ->where('usuario', $contrato)
            ->update([
              'valor_cobrado' => $valor_por_servicio_cliente,
              'valor_pagado' => $valor_por_servicio,
              'utility' => doubleval($valor_por_servicio_cliente)-doubleval($valor_por_servicio),
            ]);

          }else{

            $id_factura = $id_facturas.',';
            $valor_utilidad = doubleval($valor_por_servicio_cliente)-doubleval($valor_por_servicio);
            $facturacion = new Facturacion();
            $facturacion->calidad_servicio = 'BUENO';
            $facturacion->observacion = 'REALIZADO A SATISFACCION';
            $facturacion->numero_planilla = $servicio->id_servicio;
            $facturacion->unitario_cobrado = $valor_por_servicio_cliente;
            $facturacion->unitario_pagado = doubleval($valor_por_servicio);
            $facturacion->total_cobrado = doubleval($valor_por_servicio_cliente);
            $facturacion->total_pagado = doubleval($valor_por_servicio);
            $facturacion->utilidad = $valor_utilidad;
            $facturacion->revisado = 1;
            $facturacion->liquidado = 1;
            $facturacion->facturado = 1;
            $facturacion->creado_por = Sentry::getUser()->id;
            $facturacion->servicio_id = $servicio->id_servicio;
            $facturacion->facturas_id = $id_factura;
            $facturacion->factura_id = $id_facturas;
            $facturacion->save();

            $update_valor_qr = DB::table('escolar_qr')
            ->where('servicio_id', $facturacion->servicio_id)
            ->where('usuario', $contrato)
            ->update([
              'valor_cobrado' => $facturacion->total_cobrado,
              'valor_pagado' => $facturacion->total_pagado,
              'utility' => $facturacion->utilidad,
            ]);
          }


        }

        /*$fecha_inicial = Input::get('fecha_inicial');
        $fecha_final = Input::get('fecha_final');
        $hora_servicio = Input::get('hora_servicio');

        $hora_del_servicio = Input::get('hora_del_servicio');
        $realización_de_la_ruta = Input::get('realizacion_de_la_ruta');
        $busqueda_de_los_datos = Input::get('busqueda_de_los_datos');*/

        $actualizacion = DB::table('escolar_pagos')
        ->where('id',$id)
        ->update([
          'facturado' => 1
        ]);

        return Response::json([
          'respuesta' => true,
          'id' => $id,
          'servicios' => $servicios,
          'fecha_inicial' => $fecha_inicial,
          'fecha_final' => $fecha_final,
          'contrato' => $contrato,
          'valor_por_servicio' => $valor_por_servicio,
          'cantidad' => $cantidad,
          'valor_factura' => $valor_factura,
          'countSamu' => $countSamu
        ]);

      }
    }

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

  public function getPruebas(){

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

          return View::make('escolar.validaciones.pruebas')
              ->with('centrosdecosto',$centrosdecosto)
              ->with('permisos',$permisos)
              ->with('o',$o=1);
      }
  }

  public function getValidar(){

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
          $conductor = DB::table('conductores')
          ->where('id',534)
          ->first();

          $vehiculo = DB::table('vehiculos')
          ->where('placa','uuw126')
          ->first();

          return View::make('escolar.validaciones.validar')
              ->with('centrosdecosto',$centrosdecosto)
              ->with('permisos',$permisos)
              ->with('conductor',$conductor)
              ->with('vehiculo',$vehiculo)
              ->with('codigo',1234)
              ->with('o',$o=1);
      }
  }

  public function getSolicitud(){

    return View::make('escolar.validaciones.solicitud')
    ->with('codigo',1234)
    ->with('o',$o=1);
      
  }

  public function getSolicitud2(){

    return View::make('escolar.validaciones.solicitud')
    ->with('codigo',1234)
    ->with('o',$o=1);
      
  }

  public function postConsultartarifa(){

    $distancia = Input::get('distancia');
    $tiempo = Input::get('tiempo');

    /*Cálculo del tiempo*/
    //SI EL SERVICIO NO SOBREPASA LOS 10 MINUTOS Y LA DISTANCIA ES MENOR A LOS 3KM, SE COBRA LA TARIFA MÍNIMA.

    if($tiempo<=600 and $distancia<3000){
      //$valor_tarifa = 25000;
      $valor_tarifa = 11000;
      //SI EL SERVICIO PASA LOS 10 MINUTOS(600seg), PERO NO HA RECORRIDO LOS 3KM(300m), SE COBRA LA TARIFA MÍNIMA, Y SE ADICIONAN 600 PESOS POR CADA MINUTO.
    }else if($tiempo>600 and $distancia<=3000){
      /*START COBRO TARIFA MÍNIMA MÁS (600*MIN)*/
      $valor_tarifa = 9000+(($tiempo-600)*5);
      if($valor_tarifa<25000){
        //$valor_tarifa = 25000;
        $valor_tarifa = 11000;
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
        $valor_tarifa = 11000;
        //$valor_tarifa = 25000;
      }

      /* END COBRO TARIFA MÍNIMA MÁS (300*100M)*/
    }
    /*Cálculo por tiempo*/

    return Response::json([
      'respuesta' => true,
      'distancia' => $distancia,
      'tiempo' => $tiempo,
      'valor' => $valor_tarifa
    ]);
      
  }

  public function postImportarexcelt(){

    if (!Sentry::check()){

        return Response::json([
            'respuesta'=>'relogin'
        ]);

    }else{

        $var = '';

        Excel::selectSheetsByIndex(0)->load(Input::file('excel'), function($reader){
            $reader->skip(1);
            $result = $reader->noHeading()->get();

            $transaccionesArray = [];
            foreach($result as $value){

              $numero = $value[0];

              if(is_string($value[0])){

              $dataExcel = [
                   'numero'=> strtoupper(trim($numero)),
                ];
                array_push($transaccionesArray, $dataExcel);

              }
            }
            echo json_encode([
              'transacciones' => $transaccionesArray
            ]);

        });
    }

  }//SG

  public function postImportarexcele(){

    if (!Sentry::check()){

        return Response::json([
            'respuesta'=>'relogin'
        ]);

    }else{

        $var = '';

        Excel::selectSheetsByIndex(0)->load(Input::file('excel'), function($reader){
            $reader->skip(1);
            $result = $reader->noHeading()->get();

            $emailsArray = [];
            foreach($result as $value){

              $contrato = $value[0];
              $acudiente = $value[1];
              $estudiante = $value[2];
              $curso = $value[3];
              $email = $value[4];

              //if(!is_string($value[0])){

              $dataExcel = [
                   'contrato'=> strtoupper(trim($contrato)),
                   'acudiente'=> strtoupper(trim($acudiente)),
                   'estudiante'=> strtoupper(trim($estudiante)),
                   'curso'=> strtoupper(trim($curso)),
                   'email'=> strtoupper(trim($email)),
                ];
                array_push($emailsArray, $dataExcel);

              //}
            }
            echo json_encode([
              'emails' => $emailsArray
            ]);

        });
    }

  }//SG

  public function postNotificacion(){//2 Y 1 HORA

    $fechaActual = date('Y-m-d H:i');//'2022-05-04 11:21';//
    $horaMasTreita = date('Y-m-d H:i',strtotime('+30 minute',strtotime($fechaActual)));

    /*2 HORA END*/
    $fechaMinima = date('Y-m-d');
    $horaMinima = date('H:i');
    $fechaMaxima = date('Y-m-d',strtotime('+120 minute',strtotime($fechaActual)));
    $horaMaxima = date('H:i',strtotime('+120 minute',strtotime($fechaActual)));

    $consulta2 = "SELECT servicios.id, servicios.pasajeros, servicios.app_user_id, servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.conductor_id, servicios.centrodecosto_id, servicios.aceptado_app, servicios.estado_servicio_app, servicios.pendiente_autori_eliminacion, servicios.ruta, servicios.recoger_en, servicios.dejar_en, servicios.estado_km, reconfirmacion.reconfirmacion2hrs, centrosdecosto.razonsocial as razonsocial, subcentrosdecosto.nombresubcentro as subcentro FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join subcentrosdecosto on subcentrosdecosto.id = servicios.subcentrodecosto_id left join nombre_ruta on nombre_ruta.id = servicios.ruta_nombre_id left join reconfirmacion on reconfirmacion.id_servicio = servicios.id WHERE servicios.fecha_servicio between '".$fechaMinima."' and '".$fechaMaxima."' AND servicios.hora_servicio >= '".$horaMinima."' AND servicios.hora_servicio <= '".$horaMaxima."' AND (servicios.estado_servicio_app IS NULL OR servicios.estado_servicio_app <> 2) and servicios.pendiente_autori_eliminacion is null AND reconfirmacion.reconfirmacion2hrs is null order by servicios.fecha_servicio asc, servicios.hora_servicio asc";

    $servicios = DB::select($consulta2);
    $servicios2 = DB::select($consulta2);

    foreach ($servicios as $servicio) {

      $consulta_reconfirmacion = DB::table('reconfirmacion')->where('id_servicio',$servicio->id)->first();
      if($consulta_reconfirmacion!=null){

        //YA HAY UN REGISTRO GUARDADO EN LA TABLA RECONFIRMACIÓN
        $actualizar = DB::table('reconfirmacion')
        ->where('id_servicio',$servicio->id)
        ->update([
          'reconfirmacion2hrs' => date('H:i:s'),
          'novedad_2' => 'RECONFIRMACION APP 2H',
          'numero_reconfirmaciones' => 1,
          'reconfirmado_por' => 2,
          'id_servicio' => $servicio->id
        ]);

        $message = '2 Horas';

        Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

      }else{

        //sin registro en la tabla de reconfirmación
        $reconfirmador = new Reconfirmacion();
        $reconfirmador->reconfirmacion2hrs = date('H:i:s');
        $reconfirmador->novedad_2 = 'RECONFIRMACION APP 2H';
        $reconfirmador->numero_reconfirmaciones = 1;
        $reconfirmador->reconfirmado_por = 2;
        $reconfirmador->id_servicio = $servicio->id;
        $reconfirmador->save();

        $message = '2 Horas';

        Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

      }
      //NOTIFICACIÓN AL CLIENTE
      $sw = 0;
      if($servicio->app_user_id!=null and $servicio->app_user_id!=0){
        Servicio::ReconfirmarCliente($servicio->app_user_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);
        $sw = 1;
      }else if($servicio->ruta!=1){ //Si es servicio ejecutivo

        $pax = explode('/',$servicio->pasajeros);

        for ($i=0; $i < count($pax); $i++) {
          $pasajeros[$i] = explode(',', $pax[$i]);
        }

        for ($i=0; $i < count($pax)-1; $i++) {

          for ($j=0; $j < count($pasajeros[$i]); $j++) {

            if ($j===3) {
              $nombre = $pasajeros[$i][$j];
            }

          }

          if($nombre!=''){
            
            /*ENVÍO DE RECONFIRMACIÓN AL USUARIO POR CORREO*/
            $email = $nombre;

            $data = [
              'servicio' => $servicio
            ];
            Mail::send('emails.reconfirmacion', $data, function($message) use ($email){
              $message->from('no-reply@aotour.com.co', 'AOTOUR');
              $message->to($email)->subject('Notificaciones Aotour');
              $message->cc('aotourdeveloper@gmail.com');
            });
            //FIN ENVÍO DE RECONFIRMACIÓN AL USUARIO POR CORREO*/

          }

        }

      }

    }
    /*2 HORAS END*/

    /*1 HORA START*/
    $fechaMinima = date('Y-m-d');
    $horaMinima = date('H:i');
    $fechaMaxima = date('Y-m-d',strtotime('+60 minute',strtotime($fechaActual)));
    $horaMaxima = date('H:i',strtotime('+60 minute',strtotime($fechaActual)));
    //test hora

    $consulta = "SELECT servicios.id, servicios.pasajeros, servicios.app_user_id, servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.conductor_id, servicios.centrodecosto_id, servicios.aceptado_app, servicios.estado_servicio_app, servicios.pendiente_autori_eliminacion, servicios.ruta, servicios.recoger_en, servicios.dejar_en, servicios.estado_km, reconfirmacion.reconfirmacion1hrs, centrosdecosto.razonsocial as razonsocial, subcentrosdecosto.nombresubcentro as subcentro FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join subcentrosdecosto on subcentrosdecosto.id = servicios.subcentrodecosto_id left join nombre_ruta on nombre_ruta.id = servicios.ruta_nombre_id left join reconfirmacion on reconfirmacion.id_servicio = servicios.id WHERE servicios.fecha_servicio between '".$fechaMinima."' and '".$fechaMaxima."' AND servicios.hora_servicio >= '".$horaMinima."' AND servicios.hora_servicio <= '".$horaMaxima."' AND (servicios.estado_servicio_app IS NULL OR servicios.estado_servicio_app <> 2) and servicios.pendiente_autori_eliminacion is null AND reconfirmacion.reconfirmacion1hrs is null order by servicios.fecha_servicio asc, servicios.hora_servicio asc";

    $servicios = DB::select($consulta);

    foreach ($servicios as $servicio) {

      $consulta_reconfirmacion = DB::table('reconfirmacion')->where('id_servicio',$servicio->id)->first();
      if($consulta_reconfirmacion!=null){

        //YA HAY UN REGISTRO GUARDADO EN LA TABLA RECONFIRMACIÓN
        $actualizar = DB::table('reconfirmacion')
        ->where('id_servicio',$servicio->id)
        ->update([
          'reconfirmacion1hrs' => date('H:i:s'),
          'novedad_1' => 'RECONFIRMACION APP 1H',
          'numero_reconfirmaciones' => 2,
          'reconfirmado_por' => 2,
          'id_servicio' => $servicio->id
        ]);

        $message = '1 Hora';

        Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

      }else{

        //sin registro en la tabla de reconfirmación
        $reconfirmador = new Reconfirmacion();
        $reconfirmador->reconfirmacion1hrs = date('H:i:s');
        $reconfirmador->novedad_1 = 'RECONFIRMACION APP 1H';
        $reconfirmador->numero_reconfirmaciones = 2;
        $reconfirmador->reconfirmado_por = 2;
        $reconfirmador->id_servicio = $servicio->id;
        $reconfirmador->save();

        $message = '1 Hora';

        Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

      }
      //NOTIFICACIÓN AL CLIENTE
      //if($servicio->app_user_id!=null and $servicio->app_user_id!=0){
        //Servicio::ReconfirmarCliente($servicio->app_user_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);
      //}

    }
    /*1 HORA END*/

    return Response::json([
      'respuesta' => true,
      'servicios' => $servicios,
      'new' => $consulta2,
      //'sw' => $sw
    ]);

  }

  public function postNotificacion2(){//30 y 15 MINUTOS

    $fechaActual = date('Y-m-d H:i');//'2022-05-04 21:01';//
    //Validar servicio y ruta
    //Validar la fecha actual, fecha minima y fecha maxima
    $horaMasTreita = date('Y-m-d H:i',strtotime('+30 minute',strtotime($fechaActual)));

    /*30 MINUTOS START*/
    $fechaMinima = date('Y-m-d');
    $horaMinima = date('H:i');
    $fechaMaxima = date('Y-m-d',strtotime('+30 minute',strtotime($fechaActual)));
    $horaMaxima = date('H:i',strtotime('+30 minute',strtotime($fechaActual)));
    //test hora

    $consulta = "SELECT servicios.id, servicios.pasajeros, servicios.app_user_id, servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.conductor_id, servicios.centrodecosto_id, servicios.aceptado_app, servicios.estado_servicio_app, servicios.pendiente_autori_eliminacion, servicios.ruta, servicios.recoger_en, servicios.dejar_en, servicios.estado_km, reconfirmacion.reconfirmacion30min, centrosdecosto.razonsocial as razonsocial, subcentrosdecosto.nombresubcentro as subcentro FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join subcentrosdecosto on subcentrosdecosto.id = servicios.subcentrodecosto_id left join nombre_ruta on nombre_ruta.id = servicios.ruta_nombre_id left join reconfirmacion on reconfirmacion.id_servicio = servicios.id WHERE servicios.fecha_servicio between '".$fechaMinima."' and '".$fechaMaxima."' AND servicios.hora_servicio >= '".$horaMinima."' AND servicios.hora_servicio <= '".$horaMaxima."' AND (servicios.estado_servicio_app IS NULL OR servicios.estado_servicio_app <> 2) and servicios.pendiente_autori_eliminacion is null AND reconfirmacion.reconfirmacion30min is null order by servicios.fecha_servicio asc, servicios.hora_servicio asc";

    $servicios = DB::select($consulta);

    foreach ($servicios as $servicio) {

      $consulta_reconfirmacion = DB::table('reconfirmacion')->where('id_servicio',$servicio->id)->first();
      if($consulta_reconfirmacion!=null){

        //YA HAY UN REGISTRO GUARDADO EN LA TABLA RECONFIRMACIÓN
        $actualizar = DB::table('reconfirmacion')
        ->where('id_servicio',$servicio->id)
        ->update([
          'reconfirmacion30min' => date('H:i:s'),
          'novedad_30' => 'RECONFIRMACION APP 30min',
          'numero_reconfirmaciones' => 3,
          'reconfirmado_por' => 2,
          'id_servicio' => $servicio->id
        ]);

        $message = '30 Minutos';

        Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

      }else{

        //sin registro en la tabla de reconfirmación
        $reconfirmador = new Reconfirmacion();
        $reconfirmador->reconfirmacion30min = date('H:i:s');
        $reconfirmador->novedad_30 = 'RECONFIRMACION APP 30min';
        $reconfirmador->numero_reconfirmaciones = 3;
        $reconfirmador->reconfirmado_por = 2;
        $reconfirmador->id_servicio = $servicio->id;
        $reconfirmador->save();

        $message = '30 Minutos';

        Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

      }
      //NOTIFICACIÓN AL CLIENTE
      //if($servicio->app_user_id!=null and $servicio->app_user_id!=0){
        //Servicio::ReconfirmarCliente($servicio->app_user_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);
      //}

    }
    /*30 MINUTOS END*/

    /*15 MINUTOS START*/
    $fechaMinima = date('Y-m-d');
    $horaMinima = date('H:i');
    $fechaMaxima = date('Y-m-d',strtotime('+15 minute',strtotime($fechaActual)));
    $horaMaxima = date('H:i',strtotime('+15 minute',strtotime($fechaActual)));
    //test hora

    $consulta = "SELECT servicios.id, servicios.pasajeros, servicios.app_user_id, servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.conductor_id, servicios.centrodecosto_id, servicios.aceptado_app, servicios.estado_servicio_app, servicios.pendiente_autori_eliminacion, servicios.ruta, servicios.recoger_en, servicios.dejar_en, servicios.estado_km, reconfirmacion.reconfirmacion_horacita, centrosdecosto.razonsocial as razonsocial, subcentrosdecosto.nombresubcentro as subcentro FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join subcentrosdecosto on subcentrosdecosto.id = servicios.subcentrodecosto_id left join nombre_ruta on nombre_ruta.id = servicios.ruta_nombre_id left join reconfirmacion on reconfirmacion.id_servicio = servicios.id WHERE servicios.fecha_servicio between '".$fechaMinima."' and '".$fechaMaxima."' AND servicios.hora_servicio >= '".$horaMinima."' AND servicios.hora_servicio <= '".$horaMaxima."' AND (servicios.estado_servicio_app IS NULL OR servicios.estado_servicio_app <> 2) and servicios.pendiente_autori_eliminacion is null AND reconfirmacion.reconfirmacion_horacita is null order by servicios.fecha_servicio asc, servicios.hora_servicio asc";

    $servicios = DB::select($consulta);

    foreach ($servicios as $servicio) {

      $consulta_reconfirmacion = DB::table('reconfirmacion')->where('id_servicio',$servicio->id)->first();
      if($consulta_reconfirmacion!=null){

        //YA HAY UN REGISTRO GUARDADO EN LA TABLA RECONFIRMACIÓN
        $actualizar = DB::table('reconfirmacion')
        ->where('id_servicio',$servicio->id)
        ->update([
          'reconfirmacion_horacita' => date('H:i:s'),
          'novedad_hora' => 'RECONFIRMACION APP 15min',
          'numero_reconfirmaciones' => 4,
          'reconfirmado_por' => 2,
          'id_servicio' => $servicio->id
        ]);

        $message = '15 Minutos';

        Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

      }else{

        //sin registro en la tabla de reconfirmación
        $reconfirmador = new Reconfirmacion();
        $reconfirmador->reconfirmacion_horacita = date('H:i:s');
        $reconfirmador->novedad_hora = 'RECONFIRMACION APP 15min';
        $reconfirmador->numero_reconfirmaciones = 4;
        $reconfirmador->reconfirmado_por = 2;
        $reconfirmador->id_servicio = $servicio->id;
        $reconfirmador->save();

        $message = '15 Minutos';

        Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

      }
      //NOTIFICACIÓN AL CLIENTE
      if($servicio->app_user_id!=null and $servicio->app_user_id!=0){
        Servicio::ReconfirmarCliente($servicio->app_user_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);
      }else if($servicio->ruta!=1){ //Si es servicio ejecutivo

        $pax = explode('/',$servicio->pasajeros);

        for ($i=0; $i < count($pax); $i++) {
          $pasajeros[$i] = explode(',', $pax[$i]);
        }

        for ($i=0; $i < count($pax)-1; $i++) {

          for ($j=0; $j < count($pasajeros[$i]); $j++) {

            if ($j===3) {
              $nombre = $pasajeros[$i][$j];
            }

          }

          if($nombre!=''){
            
            /*ENVÍO DE RECONFIRMACIÓN AL USUARIO POR CORREO*/
            $email = $nombre;

            $data = [
              'servicio' => $servicio
            ];
            Mail::send('emails.reconfirmacion', $data, function($message) use ($email){
              $message->from('no-reply@aotour.com.co', 'AOTOUR');
              $message->to($email)->subject('Notificaciones Aotour');
              $message->cc('aotourdeveloper@gmail.com');
            });
            //FIN ENVÍO DE RECONFIRMACIÓN AL USUARIO POR CORREO*/

          }

        }

      }

    }
    /*15 MINUTOS END*/

    return Response::json([
      'respuesta' => true,
      'servicios' => $servicios,
    ]);

  }

  public function postFacturas(){

    $select = "SELECT DISTINCT ordenes_facturacion.id, ordenes_facturacion.numero_factura, ordenes_facturacion.total_facturado_cliente, ordenes_facturacion.ingreso, pago_proveedores.id, pagos.id FROM ordenes_facturacion LEFT JOIN facturacion ON facturacion.factura_id =  ordenes_facturacion.id LEFT JOIN servicios ON servicios.id = facturacion.servicio_id LEFT JOIN pago_proveedores ON pago_proveedores.id = facturacion.pago_proveedor_id LEFT JOIN pagos ON pagos.id = pago_proveedores.id_pago WHERE servicios.fecha_servicio BETWEEN '20220101' AND '20220730' AND servicios.centrodecosto_id = 329 AND ordenes_facturacion.ingreso IS NOT NULL";

    $query = DB::select($select);

    return Response::json([
      'respuesta' => true,
      'select' => $select,
      'query' => $query
    ]);

  }

  public function postNotificar(){

    $url = 'https://fcm.googleapis.com/fcm/send';

    $id = DB::table('users')->where('id',3997)->pluck('idregistrationdevice');

    $id = 'e9UDdemYSM2tvO5WvSNse2:APA91bGT_PioVxLsK_flJm-n80xcMdZE9J2YPLJ89nyi2wnH9_8f9hbeo9dmxjUznIpSdS8BzFrijqBjzUXiVjuWMuEXRYi8QSefH7ZNErqtNfORtOOrgOWQHxjF_DAp_eQIfeo_y2A3';

    $message = 'Le informamos que su servicio fue programado para el día Lunes 24 de Abril a las 18:00 horas.';

    $message = 'Se le ha asignado un servicio para el dia: 2022-06-10, hora: 21:51, recoger en: AOTOUR BARRANQUILLA CRA 53, dejar en: AEROPUERTO ERNESTO CORTISSOZ para SGS COLOMBIA HOLDING';

    $message = 'Hubo cambios en el servicio programado para el: 2022-06-10 y hora: 21:51. Se cambió la hora de 21:51 a 22:30.';

    $fields = array (
      'registration_ids' => array (
        $id
      ),
      'notification' => array (
        "body" => $message,
        "title" => 'audio',
        "sw" => 1,
        "sound" => 'https://app.aotour.com.co/autonet/biblioteca_imagenes/inicio.mp3',
        "icon" => 'https://app.aotour.com.co/autonet/image_notifications.png'
      )
    );
    $fields = json_encode ( $fields );

    $key = "AAAABsrVRW8:APA91bHeyqFdFTYzPuSQe6SXB-FO1bLqJ_cQcNTWim-oBShNazh00NagwyKA0ouZC94lre12goZcjSzyqwpDJsGPiVa4voh7xm3-DOkl11u2YF9f3PnLXFRdmb59vXYj6cHeafkuqeA-"; //Conductor

    //$key = "AAAAXZ-yM9s:APA91bGhnV8patuAqhFUFD0VUxmfNS65-8rkck3_Dngwb8LMsK1QomoZQsXHF5-Z4lXuPMMogTqpPD5KDqZzSL5tux6GcN5Rvugv0yGVtLHORIZxl_Pw4mB2JbZHXufQvkefloY1-IeS"; //Cliente

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
      //'token' => $registrationId,
      'resultado' => $result
    ]);

  }

  //Prueba de notificaciones PUSH
  public function postNotificar2(){

    $apikey = 'AAAABsrVRW8:APA91bHeyqFdFTYzPuSQe6SXB-FO1bLqJ_cQcNTWim-oBShNazh00NagwyKA0ouZC94lre12goZcjSzyqwpDJsGPiVa4voh7xm3-DOkl11u2YF9f3PnLXFRdmb59vXYj6cHeafkuqeA-';

    $vibration_pattern = Notification::VIBRATION_PATTERN;

    //$registrationId = [$conductor->user->idregistrationdevice];
    $registrationId = ['ejpXMDInQ_mLcoAcvA1FY9:APA91bEswZqc-ztFVZTsW7JDInBvlBy2Ua_aBkkd--YXIY948yEm3a7Tr0dIVX-sJgtPua_4yPRtlemH-TO45ViwWtIDcobDX0E3GLdtyk7sg_UA69IQkYS1skNLLkRYNhOdnGgKCLHm'];

    /*Versión corta test
    curl -X POST -H "Authorization: Bearer AAAABsrVRW8:APA91bHeyqFdFTYzPuSQe6SXB-FO1bLqJ_cQcNTWim-oBShNazh00NagwyKA0ouZC94lre12goZcjSzyqwpDJsGPiVa4voh7xm3-DOkl11u2YF9f3PnLXFRdmb59vXYj6cHeafkuqeA-" -H "Content-Type: application/json" -d '{
      "message":{
        "topic":"YOUR-TOPIC-NAME",
        "notification":{
          "title":"Hello",
          "body":"This is a text message!"
        }
      }
    }' https://fcm.googleapis.com/v1/projects/aotour-mobile-driver-pro/messages:send
    Fin versión corta*/
    return Response::json([
      'respuesta' => true,
      'token' => $registrationId,
      'resultado' => $result
    ]);

    /*
    $mensaje = 'Prueba de notificación push';

    $data = [
      'body' => 'Se le ha asignado un nuevo servicio para el día',
      'message' => 'Se le ha asignado un nuevo servicio para el día',
      'title' => 'Aotour Mobile',
      'notId' => rand(1000000, 9999999),
      'vibrationPattern' => $vibration_pattern,
      'soundname' => 'default',
      'sound' => 'default',
      'visibility' => 1,
    ];

    $fields = [
      'registration_ids' => $registrationId,
      'priority' => 'high',
      'content-available' => true
    ];

    $fields['data'] = $data;

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
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);

      return Response::json([
        'respuesta' => true,
        'token' => $registrationId,
        'resultado' => $result
      ]);*/
  }

  //Generar, Guardar y enviar PDF por correo electrónico
  public function postEnviaremails(){

    $contador = Input::get('contador');
    if($contador===null){
      $contador = 1;
      $emails = json_decode(Input::get('emails'));
    }else{
      $emails = json_decode(Input::get('emails'));
    }


    $count = count($emails);
    $sw=0;
    $contadora = 0;
    foreach ($emails as $envio) {
      $contadora = $contadora + 1;
      if(intval($contadora)===intval($contador)){
        $sw=1;
        $contrato = $envio->contrato;
        $acudiente = $envio->acudiente;
        $estudiante = $envio->estudiante;
        $curso = $envio->curso;
        $email = $envio->email;

        $html = View::make('escolar.validaciones.pdf_contrato')->with([
          'contrato' => $contrato,
          'acudiente' => $acudiente,
          'estudiante' => $estudiante,
          'curso' => $curso,
          'email' => $email
        ]);

        //return $html;

        $outputName = 'documento_aotour_'.$contrato; // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
        $pdfPath = 'biblioteca_imagenes/escolar/pdf/'.$outputName.'.pdf';
        File::put($pdfPath, PDF::load($html, 'legal', 'portrait')->output());

        //new
        //new

        $data = [
          'contrato' => $contrato,
          'acudiente' => $acudiente
        ];
        $message = 'TEST';

        Mail::send('escolar.validaciones.email_pdf', $data, function($message) use ($pdfPath, $email, $contrato){
        	$message->from('no-reply@aotour.com.co', 'Auto Ocasional Tour SAS - AOTOUR');
        	$message->to($email)->subject('Terminación unilateral del CONTRATO No. '.$contrato);
          $message->cc('escolar@aotour.com.co');
        	$message->attach($pdfPath);
        });

        $update = DB::table('escolar')
        ->where('contrato',$contrato)
        ->update([
          'envio_email' => 1,
          'fecha_envio' => date('Y-m-d h:i:s'),
          'correo_envio' => $email
        ]);

      }
      //$count++;


      //return PDF::load(utf8_decode($html), 'Legal', 'portrait')->save(storage_path('biblioteca_imagenes/escolar/') . 'archivo-'.$contrato.'.pdf');
      //PDF::load('vista-pdf', $html)->save(storage_path('biblioteca_imagenes/escolar/') . 'archivo-'.$contrato.'.pdf');
      //

    }

    if($sw===1){

      $contador = $contador + 1;

      return Response::json([
        'respuesta' => true,
        'contador' => $contador,
        'emails' => $emails
      ]);

    }elseif(intval($contador)>intval($count)){

      return Response::json([
        'respuesta' => false
      ]);

    }else{
      return Response::json([
        'respuesta' => false,
        'conta' => $contador,
        'count' => $count,
        'sw' => $sw
      ]);
    }
    //PDF::clear();
  }

  public function getPdfemail(){

    $acudiente = 'LUZ DIVINA MENDOZA CORONADO';

    return View::make('escolar.validaciones.pdf_contrato')
    ->with('acudiente',$acudiente);
    //->with('o',$o=1);

  }

  public function postValidarpagos(){

    if (!Sentry::check()){

      return Response::json([
          'respuesta' => 'relogin'
      ]);

    }else{

      $pagos = json_decode(Input::get('transacciones'));

      foreach ($pagos as $pago) {

        $sw=0;
        try {
          //$link = file_get_contents('https://sandbox.wompi.co/v1/transactions/'.$pago->numero.''); //prueba
          $link = file_get_contents('https://production.wompi.co/v1/transactions/'.$pago->numero.''); //producción
        } catch (Exception $e) {
          $sw=1;
        }

        if($sw==0){

    			$response = json_decode($link);

          $estado = $response->data->status;

          if($estado=='APPROVED'){

            $id_pago = $response->data->redirect_url;
            $id_pago = explode("/", $id_pago);
            $id_pago = $id_pago[6];

            $metodo_pago = $response->data->payment_method_type;

            $consulta_pago = DB::table('escolar_pagos')
            ->where('id',$id_pago)
            ->first();

            if($consulta_pago->estado_pago!=1){

              $update_pago = DB::table('escolar_pagos')
              ->where('id',$id_pago)
              ->update([
                'estado_pago' => 1,
                'metodo_pago' => $metodo_pago,
                'id_transaccion' => $pago->numero
              ]);

            }else{

              $update_pago = DB::table('escolar_pagos')
              ->where('id',$id_pago)
              ->update([
                'metodo_pago' => $metodo_pago,
                'id_transaccion' => $pago->numero
              ]);

            }

          }

        }

      }

      return Response::json([
        'respuesta' => true,
      ]);

    }
  }//SG

  public function postValidacionunitaria(){

    if (!Sentry::check()){

      return Response::json([
          'respuesta' => 'relogin'
      ]);

    }else{

      $numero = Input::get('numero');

        $sw = 0;
        try {
          //$link = file_get_contents('https://sandbox.wompi.co/v1/transactions/'.$numero.''); //prueba
          $link = file_get_contents('https://production.wompi.co/v1/transactions/'.$numero.''); //producción
        } catch (Exception $e) {
          $sw=1;
        }

        if($sw==0){

    			$response = json_decode($link);

          $estado = $response->data->status;

          $id_pago = $response->data->redirect_url;
          $id_pago = explode("/", $id_pago);
          $id_pago = $id_pago[6];

          $metodo_pago = $response->data->payment_method_type;

          $consulta_pago = DB::table('escolar_pagos')
          ->where('id',$id_pago)
          ->first();

          $escolar = DB::table('escolar')
          ->where('contrato',$consulta_pago->contrato)
          ->first();

          if($estado=='APPROVED'){

            if($consulta_pago->estado_pago!=1){

              $update_pago = DB::table('escolar_pagos')
              ->where('id',$id_pago)
              ->update([
                'estado_pago' => 1,
                'metodo_pago' => $metodo_pago,
                'id_transaccion' => $numero
              ]);

            }else{

              $update_pago = DB::table('escolar_pagos')
              ->where('id',$id_pago)
              ->update([
                'metodo_pago' => $metodo_pago,
                'id_transaccion' => $numero
              ]);

            }

            return Response::json([
              'respuesta' => true,
              'detalles' => $response,
              'usuario' => $escolar
            ]);

          }else{

            return Response::json([
              'respuesta' => false,
              'detalles' => $response,
              'usuario' => $escolar
            ]);

          }

        }else{

          return Response::json([
            'respuesta' => 'invalido'
          ]);

        }

    }
  }//SG

  //new controller
  public function postBuscarcliente(){

    $id = Input::get('id_cliente');
    $tipo = Input::get('tipo');

    if($tipo==='NIT'){

    }else{

    }

    $search = DB::table('centrosdecosto')
    ->where('nit',$id)
    ->first();

    if($search!=null){

      return Response::json([
        'respuesta'=>true,
        'razonsocial'=>$search->razonsocial,
        'tipo' => $tipo
      ]);

    }else{

      return Response::json([
        'respuesta'=>false,
        'nit'=>$id,
        'tipo' => $tipo
      ]);

    }
  }

  public function postBuscarusuario(){

    $id = Input::get('id_cliente');
    $tipo = Input::get('tipo');

    if($tipo==='NIT'){

    }else{

    }

    $search = DB::table('subcentrosdecosto')
    ->where('identificacion',$id)
    ->first();

    if($search!=null){

      return Response::json([
        'respuesta' => true,
        'razonsocial'=>$search->nombresubcentro,
        'celular'=>$search->celular,
        'email'=>$search->email_contacto,
      ]);

    }else{

      return Response::json([
        'respuesta' => false
      ]);

    }

  }

  public function postAddtoken(){

      $id = Input::get('id');
      
      $correo_electronico = Input::get('correo_electronico');

      $numero = Input::get('numero');
      $nombre = Input::get('nombre');
      $mes = strval(Input::get('mes'));
      $ano = strval(Input::get('ano'));
      $cvc = strval(Input::get('ccv'));

      $valor = Input::get('valor');

      if($mes<='9'){
        $mes = '0'.$mes;
      }

      if($ano==='2022'){
        $ano = '22';
      }else if($ano==='2023'){
        $ano = '23';
      }else if($ano==='2024'){
        $ano = '24';
      }else if($ano==='2025'){
        $ano = '25';
      }else if($ano==='2026'){
        $ano = '26';
      }else if($ano==='2027'){
        $ano = '27 ';
      }else if($ano==='2028'){
        $ano = '28';
      }else if($ano==='2029'){
        $ano = '29';
      }else if($ano==='2030'){
        $ano = '30';
      }

      $numero = str_replace(' ', '', $numero);

      //$usuario = User::find($id);

      $apiUrl = "https://sandbox.wompi.co/v1/tokens/cards"; //card prueba
      //$apiUrl = "https://production.wompi.co/v1/tokens/cards"; //links de pago productivo

      $data = [
        "number" => strval($numero),
        "cvc" => $cvc,
        "exp_month" => $mes,
        "exp_year" => $ano,
        "card_holder" => $nombre
      ];

      $headers = [
        'Accept: application/json',
        'Authorization: Bearer pub_test_kHmWs45k3rd7O9n1ER9hs5jHAccsCqmZ', //links pruebas samuel
        //'Authorization: Bearer pub_prod_k3EGLrTVqzDhXKogfQwL8PGo080sw5K0', //links productivo aotour
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
        $llave = 'pub_test_kHmWs45k3rd7O9n1ER9hs5jHAccsCqmZ'; //prueba SAMUEL
        //$llave = 'pub_prod_k3EGLrTVqzDhXKogfQwL8PGo080sw5K0'; //producción AOTOUR
        $response = file_get_contents('https://sandbox.wompi.co/v1/merchants/'.$llave.''); //prueba
        $response = json_decode($response);
        $acceptance_token = $response->data->presigned_acceptance->acceptance_token;
        //END OBTENCIÓN DE TOKEN DE ACEPTACIÓN

        //START FUENTE DE PAGO
        $token_tarjeta = $result->data->id;
        $apiUrlFuente = "https://sandbox.wompi.co/v1/payment_sources"; //card prueba fuente de pago

        $datas = [
          "type" => "CARD",
          "token" => $token_tarjeta,
          "customer_email" => 'sdgm2207@gmail.com',
          "acceptance_token" => $acceptance_token,
        ];

        $headers = [
          'Accept: application/json',
          'Authorization: Bearer prv_test_Ig9hDRTpqzvsvafOWcYQSQWdC938MtMK', //links pruebas samuel
          //'Authorization: Bearer prv_prod_WJ9PkFir6uPwOPwstzfI8LsfPPedpRda', //links productivo aotour
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

        //Pago del servicio
        $valor_servicio = $valor;

        $apiUrl = "https://sandbox.wompi.co/v1/transactions"; //URL DE PRUEBAS
        //$apiUrl = "https://production.wompi.co/v1/transactions"; //URL DE PRODUCCIÓN

        $valorReal = $valor_servicio.'00';
        $referenceCode = 'aotour_web_client_'.date('YmdHis');

        $data = [
          "amount_in_cents" => intval($valorReal),
          "currency" => "COP",
          "customer_email" => 'sdgm2207@gmail.com',
          "payment_method" => [
            "installments" => 1
          ],
          "reference" => $referenceCode,
          "payment_source_id" => $id_fuente_pago,
        ];
        $headers = [
          'Accept: application/json',
          'Authorization: Bearer prv_test_Ig9hDRTpqzvsvafOWcYQSQWdC938MtMK', //links pruebas samuel
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
            
            return Response::json([
              'respuesta' => true, //Transacción realizada
              'transaccion' => $result,
              'id' => $transaction,
              'reference_code' => $referenceCode,
              'precio' => $valor_servicio
            ]);

        }else if($estado==='PENDING'){

          return Response::json([
            'respuesta' => 'pendiente', //Transacción pendiente
            'transaccion' => $result,
            'id' => $transaction,
            'reference_code' => $referenceCode,
            'precio' => $valor_servicio
          ]);

        }else if($estado==='DECLINED'){

          return Response::json([
            'respuesta' => 'declinada', //Transacción declinada
            'transaccion' => $result,
            'id' => $transaction,
            'reference_code' => $referenceCode,
            'precio' => $valor_servicio
          ]);

        }
        //Fin hacer pago

        return Response::json([
            'respuesta' => true,
            'token_card' => $result,
            'prueba' => $valorReal
            //'last_four' => $result->data->payment_method->extra->last_four,
            //'brand' => $result->data->payment_method->extra->brand
            //'id' => $transaction
        ]);

      }else{

        return Response::json([
            'respuesta' => false, //Falso quiere decir que no se puedo crear el token
            'token_card' => $result
        ]);

      }

    }

    public function postValidarpago(){

      $id = Input::get('id');

      $respuesta = file_get_contents('https://sandbox.wompi.co/v1/transactions/'.$id.''); //prueba
      //$respuesta = file_get_contents('https://production.wompi.co/v1/transactions/'.$id.''); //producción
      $result = json_decode($respuesta);

      $estado = $result->data->status;

      if($estado==='APPROVED'){

        $precio = substr($result->data->amount_in_cents, 0, -2);

        return Response::json([
          'respuesta' => true,
          'last_four' => $result->data->payment_method->extra->last_four,
          'brand' => $result->data->payment_method->extra->brand,
          'precio' => $precio,
          //'reference_code'=> ,
          //'order_id' => ,
          'transaccion' => $result
        ]);

      }else if($estado==='DECLINED'){
        
        return Response::json([
          'respuesta' => 'declinada'
        ]);

      }else if($estado==='PENDING'){
        
        return Response::json([
          'respuesta' => 'pendiente'
        ]);

      }

    }

  public function postGuardarservicio(){

    $cliente = Input::get('cliente');
    $ciudad = Input::get('ciudad');
    $fecha = Input::get('fecha');
    $hora = Input::get('hora');
    $desde = Input::get('desde');
    $hasta = Input::get('hasta');
    $nota = Input::get('nota');
    $nombres = Input::get('nombres');
    $celulares = Input::get('celulares');
    $correos = Input::get('correos');

    $valor = Input::get('precio');

    $brand = Input::get('brand');
    $last_four = Input::get('last_four');

    $reference_code = Input::get('reference_code');
    $order_id = Input::get('order_id');

    $sw = Input::get('sw');

    $orgDate = $fecha;
    $fecha = date("Y-m-d", strtotime($orgDate));

    $subcentro_id = null;

    $payment = null;

    if($sw!=1){

      $nombre_subcentro = null;
      $email_subcentro = null;

      $centrodecostoid = DB::table('centrosdecosto')
      ->where('razonsocial',$cliente)
      ->pluck('id');

      $nombre_pasajeros = $nombres; //explode(',', Input::get('nombres'));
      $celular_pasajeros = $celulares; //explode(',', Input::get('celulares'));
      $email_pasajeros = $correos; //explode(',', Input::get('correos'));

    }else{

      $nombre_subcentro = Input::get('nombre_subcentro');
      $identificacion = Input::get('identificacion_subcentro');
      $direccion = Input::get('direccion_subcentro');
      $email_subcentro = Input::get('email_subcentro');
      $celular_subcentro = Input::get('celular_subcentro');

      $subcentro = new Subcentro;
      $subcentro->nombresubcentro = strtoupper($nombre_subcentro);
      $subcentro->nombre_contacto = strtoupper($nombre_subcentro);
      $subcentro->identificacion = $identificacion;
      $subcentro->direccion = $direccion;
      $subcentro->cargo_contacto = null;
      $subcentro->email_contacto = strtoupper($email_subcentro);
      $subcentro->celular = $celular_subcentro;
      $subcentro->telefono = null;
      $subcentro->centrosdecosto_id = 100;

      $subcentro->save();

      $centrodecostoid = 100;
      $subcentro_id = $subcentro->id;

      $nombre_pasajeros = explode(',', $nombres);
      $celular_pasajeros = explode(',', $celulares);
      $email_pasajeros = explode(',', $correos);

      //guardar pago
      $pago = new PagoServicio;
      $pago->reference_code = $reference_code;
      $pago->order_id = $order_id;
      $pago->user_id = $subcentro_id;
      $pago->valor = $valor;
      $pago->numero_tarjeta = '************'.$last_four;
      $pago->tipo_tarjeta = $brand;
      $pago->estado = 'APROVED';

      $pago->save();

      $payment = $pago->id;

    }

    $pasajeros = [];
    $pasajeros_todos='';
    $nombres_pasajeros='';
    $celulares_pasajeros='';

    //$nombres = count($nombres);

    //CONCATENACION DE TODOS LOS DATOS
    for($i=0; $i < count($nombre_pasajeros); $i++){
      $pasajeros[$i] = $nombre_pasajeros[$i].','.$celular_pasajeros[$i].','.$email_pasajeros[$i].'/';
      $pasajeros_nombres[$i] = $nombre_pasajeros[$i].',';
      $pasajeros_telefonos[$i] = $celular_pasajeros[$i].',';
      $pasajeros_todos = $pasajeros_todos.$pasajeros[$i];
      $nombres_pasajeros = $nombres_pasajeros.$pasajeros_nombres[$i];
      $celulares_pasajeros = $celulares_pasajeros.$pasajeros_telefonos[$i];
    }

    $servicio = new ServicioA();
    $servicio->centrodecosto_id = $centrodecostoid;
    $servicio->subcentrodecosto_id = $subcentro_id;
    $servicio->passengers = $pasajeros_todos;
    $servicio->request_date = $fecha;
    $servicio->solicitado_por = strtoupper($nombre_subcentro);
    $servicio->email_solicitante = strtoupper($email_subcentro);

    //$servicio->origen = $desde;
    //$servicio->destino = $hasta;
    //$servicio->vuelo = $vueloArray;
    //$servicio->aerolinea = $aerolineaArray;
    //$servicio->hora_llegada = $hora_llegadaArray;
    //$servicio->hora_salida = $hora_salidaArray;

    $servicio->pickup = strtoupper($desde);
    $servicio->destination = strtoupper($hasta);
    $servicio->requeriments = strtoupper($nota);
    $servicio->date = $fecha;
    $servicio->time = $hora;
    $servicio->localidad = $ciudad;//$sede;
    $servicio->pago_id = $payment;
    //$servicio->expediente = $expediente;
    //$servicio->solicitado_por = Sentry::getUser()->first_name. ' '.Sentry::getUser()->last_name;
    //$servicio->creado_por = Sentry::getUser()->id;
    //$servicio->email_solicitante = Sentry::getUser()->username;
    //$servicio->tipo_request = 2;

    $servicio->save();

    if(1>0){

      $canal = 'autonetbaq';
      $sin_programar = ServicioA::whereNull('estado_programado')->where('localidad','barranquilla')->count();

      $idpusher = "578229";
      $keypusher = "a8962410987941f477a1";
      $secretpusher = "6a73b30cfd22bc7ac574";

      //CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
      $channel = 'servicios';
      $name = $canal;

      $data = json_encode([
      //'proceso' => 1,
      'cantidad' => $sin_programar
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

      //Envío de Correo al solicitante
      
      if($sw!=1){
        //Servicio empresarial
/*
        $email = $email_subcentro; //Email de la persona solicitante

        $data = [
          'valor' => $valor,
          'franquicia' => $brand,
          'last_four' => $last_four,
          'servicio' => $servicio->id,
          'solicitante' => strtoupper($nombre_subcentro),
          'fecha' => $fecha,
          'hora' => $hora,
          'recoger_en' => strtoupper($desde),
          'dejar_en' => strtoupper($hasta),
          'notas' => strtoupper($nota)
        ];
        Mail::send('emails.servicios_pagina_web.correo_pago', $data, function($message) use ($email){
          $message->from('no-reply@aotour.com.co', 'AOTOUR');
          $message->to($email)->subject('Confirmación de Servicio');
          $message->cc('aotourdeveloper@gmail.com');
        });
        //FIN ENVÍO DE RECONFIRMACIÓN AL USUARIO POR CORREO*/
        
      }else{

        //Servicio pagado con tarjeta (PERSONA NATURAL)

        $email = $email_subcentro; //Email de la persona solicitante

        $data = [
          'valor' => $valor,
          'franquicia' => $brand,
          'last_four' => $last_four,
          'servicio' => $servicio->id,
          'solicitante' => strtoupper($nombre_subcentro),
          'fecha' => $fecha,
          'hora' => $hora,
          'recoger_en' => strtoupper($desde),
          'dejar_en' => strtoupper($hasta),
          'notas' => strtoupper($nota)
        ];
        Mail::send('emails.servicios_pagina_web.correo_pago', $data, function($message) use ($email){
          $message->from('no-reply@aotour.com.co', 'AOTOUR');
          $message->to($email)->subject('Confirmación de Servicio');
          $message->cc('aotourdeveloper@gmail.com');
        });
        //FIN ENVÍO DE RECONFIRMACIÓN AL USUARIO POR CORREO*/

      }

      //Envío de Correo al solicitante

      return Response::json([
        'respuesta'=>true,
        'cliente'=>$cliente,
        'ciudad'=>$ciudad,
        'fecha'=>$fecha,
        'hora'=>$hora,
        'desde'=>$desde,
        'hasta'=>$hasta,
        'nota'=>$nota,
        'nombres'=>$nombres,
        'celulares'=>$celulares,
        'correos'=>$correos,
        'precio' => $valor,
        'brand' => $brand,
        'last_four' => $last_four
      ]);

    }else{

      return Response::json([
        'respuesta'=>false
      ]);

    }

  }

  public function getServicio($id){

    $servicio = Servicio::find($id);
    
    $conductor = DB::table('conductores')
    ->where('id',$servicio->conductor_id)
    ->first();

    $vehiculo = DB::table('vehiculos')
    ->where('id',$servicio->vehiculo_id)
    ->first();

    return View::make('escolar.validaciones.email')
    ->with('servicio',$servicio)
    ->with('conductor',$conductor)
    ->with('vehiculo',$vehiculo)
    ->with('o',$o=1);
      
  }

  public function getEmail(){

    //$servicio = Servicio::find($id);
    
    //$conductor = DB::table('conductores')
    //->where('id',$servicio->conductor_id)
    //->first();

    //$vehiculo = DB::table('vehiculos')
    //->where('id',$servicio->vehiculo_id)
    //->first();

    return View::make('emails.servicios_pagina_web.correo_pago')
    //->with('servicio',$servicio)
    //->with('conductor',$conductor)
    //->with('vehiculo',$vehiculo)
    ->with('o',$o=1);
      
  }

  public function postWaaa(){ //Prueba de mensajes de Whatsapp

    /*$params=['messaging_product'=>'whatsapp', 'to'=>'573004580108', 'type'=>'template'];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v15.0/102100369400004/messages');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS => $params);

    //curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"messaging_product\": \"whatsapp\",\n  \"recipient_type\": \"individual\",\n  \"to\": \"573004580108\",\n  \"type\": \"text\",\n  \"text\": { // the text object\n    \"preview_url\": true,\n    \"body\": \"Message content including a URL begins with https:// or http://\"\n  }\n}");

    $headers = array();
    $headers[] = 'Authorization: Bearer EAAHPlqcJlZCMBAJNW9B35ImPNGs0AqXHYP1PVTBVZBntbyZBcBUiaQQQQyiUTEwrRFUkevCaZCg4L9t4YxZCEJHpOZAb6jeI2k4SuVq0ZA2PZCXvRO9dujwxm1Ce6I1xixvybDptkPZC40QAN9hwXHnLklcVzuB3jyYPFUkpEZC7KoO16fL53dP4PpC4IzA6mqLlACvmdRxuQMKpVKC2LmJNooL5hpmguzXtIZD';
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }else{
        echo $ch;
    }


    curl_close($ch);*/

    ////NUEVO
    $phone = '3142909372';

    $number = '57'.$phone;

    $number = intval($number);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/102100369400004/messages");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    /*img*/
    /*curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"messaging_product\": \"whatsapp\",
      \"to\": \"573004580108\",
      \"type\": \"template\",
      \"template\": {
        \"name\": \"img_qr \",
        \"language\": {
          \"code\": \"es\",
        },
        \"components\": [{
          \"type\": \"header\",
          \"parameters\": [{
            \"type\": \"image\",
            \"image\": {
              \"link\": \"https://app.aotour.com.co/autonet/biblioteca_imagenes/codigosqr/1000005084.png\",
            }
          }]
        }]
      }
    }");*/
    /*img*/

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"messaging_product\": \"whatsapp\",
      \"to\": \"573004580108\",
      \"type\": \"template\",
      \"template\": {
        \"name\": \"qr_code\",
        \"language\": {
          \"code\": \"es\",
        },
        \"components\": [{
          \"type\": \"body\",
          \"parameters\": [{
            \"type\": \"text\",
            \"text\": \"SAMUEL DAVID\"
          },
          {
            \"type\": \"text\",
            \"text\": \"HOY\"
          },
          {
            \"type\": \"text\",
            \"text\": \"17:00\"
          },
          {
            \"type\": \"text\",
            \"text\": \"KPO780\"
          },
          {
            \"type\": \"text\",
            \"text\": \"ILMA BONILLA LOPEZ\"
          },
          {
            \"type\": \"text\",
            \"text\": \"3013869946\"
          }]
        },
        {
          \"type\": \"button\",
          \"sub_type\": \"url\",
          \"index\": \"0\",
          \"parameters\": [{
            \"type\": \"payload\",
            \"payload\": \"535070\"
          }]
        }]
      }
    }");

    /*curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"messaging_product\": \"whatsapp\",
      \"to\": \"573004580108\",
      \"type\": \"text\",
      \"text\": {
        \"body\": \"your-text-message-content\", 
      }
    }");*/

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'result' => $response,
      'number' => $number
    ]);

  }

  public function postWaa() {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"messaging_product\": \"whatsapp\",
      \"to\": \"573013869946\",
      \"type\": \"template\",
      \"template\": {
        \"name\": \"registro\",
        \"language\": {
          \"code\": \"es\",
        },
      }
    }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'result' => $response
    ]);

  }

  public function postWaass(){ //Prueba de mensajes de Whatsapp - IMAGEN QR

    ////NUEVO
    $phone = '3004580108';

    $number = '57'.$phone;

    $number = intval($number);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/102100369400004/messages");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"messaging_product\": \"whatsapp\",
      \"to\": \"573004580108\",
      \"type\": \"template\",
      \"template\": {
        \"name\": \"route_delete\",
        \"language\": {
          \"code\": \"es\",
        },
        \"components\": [{
          \"type\": \"body\",
          \"parameters\": [{
            \"type\": \"text\",
            \"text\": \"SAMU\",
          },
          {
            \"type\": \"text\",
            \"text\": \"2022-11-20\",
          },
          {
            \"type\": \"text\",
            \"text\": \"23:59\",
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

    return Response::json([
      'respuesta' => true,
      'result' => $response
    ]);

  }

  public function postWaaimgqr(){ //Prueba de mensajes de Whatsapp - IMAGEN QR

    ////NUEVO
    $phone = '3004580108';

    $number = '57'.$phone;

    $number = intval($number);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"messaging_product\": \"whatsapp\",
      \"to\": \"573004580108\",
      \"type\": \"template\",
      \"template\": {
        \"name\": \"img_qr \",
        \"language\": {
          \"code\": \"es\",
        },
        \"components\": [{
          \"type\": \"header\",
          \"parameters\": [{
            \"type\": \"image\",
            \"image\": {
              \"link\": \"https://app.aotour.com.co/autonet/biblioteca_imagenes/codigosqr/1000005084.png\",
            }
          }]
        }]
      }
    }");

    /*curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"messaging_product\": \"whatsapp\",
      \"to\": \"573004580108\",
      \"type\": \"template\",
      \"template\": {
        \"name\": \"qr_code\",
        \"language\": {
          \"code\": \"es\",
        },
        \"components\": [{
          \"type\": \"body\",
          \"parameters\": [{
            \"type\": \"text\",
            \"text\": \"SAMUEL DAVID\"
          },
          {
            \"type\": \"text\",
            \"text\": \"HOY\"
          },
          {
            \"type\": \"text\",
            \"text\": \"17:00\"
          },
          {
            \"type\": \"text\",
            \"text\": \"KPO780\"
          },
          {
            \"type\": \"text\",
            \"text\": \"ILMA BONILLA LOPEZ\"
          },
          {
            \"type\": \"text\",
            \"text\": \"3013869946\"
          }]
        },
        {
          \"type\": \"button\",
          \"sub_type\": \"url\",
          \"index\": \"0\",
          \"parameters\": [{
            \"type\": \"payload\",
            \"payload\": \"535070\"
          }]
        }]
      }
    }");*/

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'result' => $response,
      'number' => $number
    ]);

  }

  public function postNequis(){
/*
    // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v14.0/102746939280103/messages');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"messaging_product\": \"whatsapp\",\n  \"recipient_type\": \"individual\",\n  \"to\": \"573013869946\",\n  \"type\": \"text\",\n  \"text\": { // the text object\n    \"preview_url\": true,\n    \"body\": \"Message content including a URL begins with https:// or http://\"\n  }\n}");

    $headers = array();
    $headers[] = 'Authorization: Bearer EAAHbwt5LG1UBABqFCM7igIXfn5bEo2Qli0I7JXubGlzugVLo1vc3fHOv0s1shOZAVXmNKCLVx6zACaTQnuFCOZBw252a51iaTn1B9bwCxuqYxZAdAkiivBO0PxQSYF2ZAuFSVYt6ZBQHqgyc82lY2kOmCSHD81KZBaQnxFXPVTYICLW3piTFmDj6jp34ocvPZCh81BdD8LH1UGufqlOrj4G';
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    
    curl_close($ch);*/

    $user_id = 3997;

    $consulta = "select * from servicios where app_user_id = ".$user_id." and estado_servicio_app = 1 and pendiente_autori_eliminacion is null order by fecha_servicio asc limit 1";
    $ultimo = DB::select($consulta);

    $id = $ultimo[0]->id;

    return Response::json([
      'respuesta' => true,
      'prueba' => $id
    ]);

/*


    $apiUrl = "https://graph.facebook.com/v14.0/102746939280103/messages";

    $data = [
    "messaging_product" => "whatsapp",
    "recipient_type" => "individual",
    //"to" => "573013869946",
    "to" => "573013869946",
    "type" => "text",
    "text" => [
        "body" => "Message content including a URL begins with https:// or http://"
      ]
    ];

    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer EAAHbwt5LG1UBAPIeiAzn19maQa9hJYZCZAihcg8XQhuXAgWdi7eyOjMoksbLs0InJvG4cdee5ZCnArJGNtVWqKZBYZCB3ZBBKFVMphFcKGJYqP8Cypdk2xnkojyKiw1ZAQfvRx6MZC9GbGhEVZCohZAIbjBpSt014lT54WYZBgUQrXnPpZATS4hZBytw8SrIlOZBJrgRMTvJrUSKuF4SOwC06s4SoX'
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

    return Response::json([
      "result" => $result
    ]);*/
      
  }

  public function postAuth() {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.cellvoz.com/v2/auth/login");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{

      \"account\": \"00486310168\",
      \"password\": \"4ut0n3T.!2019\"}");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => false,
      'response' => $response
    ]);

  }

  public function postVoz() {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.cellvoz.com/v2/sms/text2speech");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"number\": \"3142909372\",
      \"countryCode\": \"57\",
      \"message\": \"Hola, señor Isaac Barrios Papita. AOTOUR le recuerda su servicio de 21:00\",
      \"type\": \"1\"}");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJzaXN0ZW1hc0Bhb3RvdXIuY29tLmNvIiwidXNlciI6eyJuYW1lcyI6bnVsbCwiYWNjb3VudCI6bnVsbCwiaWR2IjoxODM2NSwiaWRzIjoxNjAwMiwidGlwb0NsaWVudGUiOjMyLCJzYWxkbyI6NTAsImN1ZW50YSI6IjAwNDg2MzEwMTY4IiwiZW1wcmVzYSI6IlNhbXVlbCBHb256w6FsZXoiLCJub21icmUiOiJTYW11ZWwgR29uesOhbGV6IiwicmF6b25Tb2NpYWwiOiJTYW11ZWwgR29uesOhbGV6IiwidGlwb1BhZ28iOiJQcmVwYWdvIiwiY2l1ZGFkIjoiICIsImRpcmVjY2lvbiI6IiAiLCJkb2N1bWVudG8iOm51bGwsImVtYWlsIjoic2lzdGVtYXNAYW90b3VyLmNvbS5jbyIsInRlbGVmb25vIjoiNTczMDEzODY5OTQ2IiwiY29ydGUiOiIxOTg4LTAxLTAxIiwidGlwb1N1YnVzdWFyaW8iOm51bGwsImNsYXZlIjpudWxsfSwiaWF0IjoxNjcyMzQyNjg4LCJleHAiOjE2NzI0MjkwODh9.Ek3gm0OuwS0bvnZMhbygBc9IuAUJ8TBPFNdxPPCPOLI",
      "api-key: b9e3d44921687784ecfadd581193f59ee0646258"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => false,
      'response' => $response
    ]);
    
  }

}
