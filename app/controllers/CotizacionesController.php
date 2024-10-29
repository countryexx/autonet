<?php

class CotizacionesController extends BaseController{

  public function getIndex(){

    if (Sentry::check()) {
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
    }else{
      $id_rol = null;
      $permisos = null;
      $permisos = null;
    }

    if (isset($permisos->comercial->cotizaciones->ver)){
      $ver = $permisos->comercial->cotizaciones->ver;
    }else{
      $ver = null;
    }

    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on' ) {
      return View::make('admin.permisos');
    }else {

	  //$fecha = date('Y-m-d');
      //$diaanterior = strtotime ('-1 day', strtotime($fecha));
      //$diaanterior = date ('Y-m-d' , $diaanterior);

    $tarifas = DB::table('traslados')->get();

	  $centrosdecosto = DB::table('centrosdecosto')->whereNull('inactivo_total')->whereNull('inactivo')->orderBy('razonsocial')->get();
	  $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
	  $rutas = DB::table('ruta_general')->orderBy('nombre_ruta')->get();

	  return View::make('servicios.cotizaciones2')
          ->with([
            'permisos'=>$permisos,
            'centrosdecosto'=>$centrosdecosto,
            'ciudades'=>$ciudades,
            'rutas'=>$rutas,
            'tarifas' => $tarifas
          ]);
    }
  }

  public function postNuevo(){

    if (!Sentry::check()){

        return Response::json([
            'mensaje'=>'relogin'
        ]);

    }else{

      if (Request::ajax()) {

        $validaciones = [
          'nombre_completo'=>'required',
		  //'identificacion'=>'required',
          'tipo'=>'required|numeric',
          'enviar'=>'required|numeric',
          'asunto'=>'required'
        ];

        $mensajes = [
          'tipo.select'=>'Seleccione el tipo de cotizacion',
          'enviar.select'=>'Seleccione la opcion enviar Mail',
          'identificacion.numeric'=>'El campo identificacion debe ser un numero',
          'email.email'=>'El email debe ser una direccion valida',
          'asunto.required'=>'Rellene el campo asunto'
        ];

        $validador = Validator::make(Input::all(), $validaciones,$mensajes);

        if ($validador->fails()){

            return Response::json([
              'mensaje'=>false,
              'errores'=>$validador->errors()->getMessages()
            ]);

        }else{

          $cotizacionesdia = DB::table('cotizaciones')->where('fecha',date('Y-m-d'))->count();

          if ($cotizacionesdia===null) {
              $numerodia = 1;
          }else{
            $numerodia = $cotizacionesdia+1;
          }

          $arraynombres = [];

          //$cotizaciones =

          $cotizaciones = new Cotizacion;
          $cotizaciones->fecha = date('Y-m-d');
          $cotizaciones->consecutivo = date('dmY').'-'.$numerodia;
          $cotizaciones->nombre_completo = Input::get('nombre_completo');
          $cotizaciones->fecha_vencimiento = Input::get('fecha_vencimiento');
          $cotizaciones->nit = Input::get('identificacion');
          $cotizaciones->direccion = Input::get('direccion');
          $cotizaciones->celular = Input::get('telefono');
          $cotizaciones->email = Input::get('email');
          $cotizaciones->asunto = Input::get('asunto');
          $cotizaciones->tipo = Input::get('tipo');
          $cotizaciones->contenido_html = Input::get('contenido');
          $cotizaciones->enviar_mail = Input::get('enviar');
          $cotizaciones->contacto = Input::get('contacto');
          $cotizaciones->vendedor = Input::get('vendedor');
          $cotizaciones->observacion = Input::get('observaciones');
          $cotizaciones->creado_por = Sentry::getUser()->id;

          if ($cotizaciones->save()) {

            $insertedId = $cotizaciones->id;
            $archivos = Input::file('archivos');
            $ubicacion = 'biblioteca_imagenes/archivos_cotizaciones/';



            if (Input::hasFile('archivos')) {

              foreach ($archivos as $key => $value) {

                $nombre_imagen = $value->getClientOriginalName();
                if(file_exists($ubicacion.$nombre_imagen)){
                    $nombre_imagen = rand(1,10000).$nombre_imagen;
                }
                array_push($arraynombres, $nombre_imagen);
                $value->move($ubicacion, $nombre_imagen);

              }

              $archivosf = implode(',',$arraynombres);
              $cotizacion = Cotizacion::find($insertedId);
              $cotizacion->archivos = $archivosf;
              $cotizacion->save();

            }else{
              $archivosf = null;
            }

            if (intval(Input::get('enviar'))===1) {

              $fromEmail = Input::get('email');
              $fromName = 'MAIL - AOTOUR';

              $tipo_cotizacion = $cotizaciones->tipo;

              $data = [
                'tipo'=>$tipo_cotizacion
              ];

              $cotizaciones = DB::table('cotizaciones')
              ->leftJoin('users', 'cotizaciones.creado_por', '=', 'users.id')
              ->where('cotizaciones.id',$insertedId)->first();

              $html = View::make('servicios.plantilla_cotizaciones')->with('cotizaciones',$cotizaciones);
              $dataa = PDF::load($html, 'A4', 'portrait')->output();

              Mail::send('emails.plantilla_pdf_cotizacion', $data, function($message) use ($fromEmail, $fromName, $dataa){
                  $message->to($fromEmail, $fromName);
                  $message->from($fromEmail, $fromName);
                  $message->subject('Detalles de solicitud de cotizacion - Aotour');
                  $message->attachData($dataa, 'Cotizacion.pdf');
              });

              return Response::json([
                'mensaje'=>true,
                'observaciones'=>Input::get('observaciones')
              ]);

            }else{
              return Response::json([
                'mensaje'=>true,
                'arraynombres'=>$arraynombres,
                'observaciones'=>Input::get('observaciones')
              ]);
            }

          }

        }

      }
    }
  }

  public function postActualizar(){

    if (!Sentry::check()){

        return Response::json([
            'mensaje'=>'relogin'
        ]);

    }else{

      if (Request::ajax()) {

          $validaciones = [
            'nombre_completo'=>'required',
            'tipo'=>'required|numeric',
            'asunto'=>'required'
          ];

          $mensajes = [
            'tipo.select'=>'Seleccione el tipo de cotizacion',
            'enviar.select'=>'Seleccione la opcion enviar Mail',
            'identificacion.numeric'=>'El campo identificacion debe ser un numero',
            'email.email'=>'El email debe ser una direccion valida',
            'asunto.required'=>'Rellene el campo asunto'
          ];

          $validador = Validator::make(Input::all(), $validaciones,$mensajes);

          if ($validador->fails()){

              return Response::json([
                'mensaje'=>false,
                'errores'=>$validador->errors()->getMessages()
              ]);

          }else{

            $cotizaciones = Cotizacion::find(Input::get('id'));
            $cotizaciones->nombre_completo = Input::get('nombre_completo');
            $cotizaciones->fecha_vencimiento = Input::get('fecha_vencimiento');
            $cotizaciones->nit = Input::get('identificacion');
            $cotizaciones->direccion = Input::get('direccion');
            $cotizaciones->celular = Input::get('telefono');
            $cotizaciones->email = Input::get('email');
            $cotizaciones->asunto = Input::get('asunto');
            $cotizaciones->tipo = Input::get('tipo');
            $cotizaciones->contenido_html = Input::get('contenido');
            $cotizaciones->enviar_mail = Input::get('enviar');
            $cotizaciones->contacto = Input::get('contacto');
            $cotizaciones->vendedor = Input::get('vendedor');
            $cotizaciones->observacion = Input::get('observaciones');
            $cotizaciones->creado_por = Sentry::getUser()->id;

            if ($cotizaciones->save()) {
              return Response::json([
                'mensaje'=>true
              ]);
            }
          }
      }
    }
  }

  public function getClientes(){

    if (!Sentry::check()){

        return Response::json([
            'mensaje'=>'relogin'
        ]);

    }else{

      if (Request::ajax()) {

        $nombre_completo = Input::get('term');

        $consulta = "select nombre_completo from cotizaciones where nombre_completo like '%".$nombre_completo."%'";
        $clientes = DB::select($consulta);
        $array = [];

        	foreach ($clientes as $cliente)
        	{
        	    $array[] = $cliente->nombre_completo;
        	}

        return Response::json(array_unique($array));
      }

    }
  }

  public function postTomarcliente(){

      if (!Sentry::check()){

          return Response::json([
              'mensaje'=>'relogin'
          ]);

      }else{

        if (Request::ajax()) {

          $valor = Input::get('valor');

          $consulta = "select * from cotizaciones where nombre_completo = '".$valor."' limit 1";

          $datos = DB::select($consulta);

          return Response::json([
            'respuesta'=>true,
            'datos'=>$datos
          ]);

        }

      }
  }

  public function getDetalles($id){

    if (Sentry::check()) {
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
    }else{
      $id_rol = null;
      $permisos = null;
      $permisos = null;
    }

    if (isset($permisos->comercial->cotizaciones->ver)){
      $ver = $permisos->comercial->cotizaciones->ver;
    }else{
      $ver = null;
    }

    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on' ) {
      return View::make('admin.permisos');
    }else {
      $cotizaciones = Cotizacion::find($id);
      return View::make('servicios.cotizaciones_editar')->with([
        'cotizaciones'=>$cotizaciones,
        'permisos'=>$permisos
      ]);
    }

  }

  public function getListado(){

    if (Sentry::check()) {
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
    }else{
      $id_rol = null;
      $permisos = null;
      $permisos = null;
    }

    if (isset($permisos->comercial->cotizaciones->ver)){
      $ver = $permisos->comercial->cotizaciones->ver;
    }else{
      $ver = null;
    }

    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on' ) {
      return View::make('admin.permisos');
    }else {

      $fecha = date('Y-m-d');
      $fecha = explode("-",$fecha);
      $ano = $fecha[0];
      $mes = $fecha[1];
      $diaFinal = 31;

      $fechaInicial = $ano.$mes.'01';
      $fechaFinal = $ano.$mes.$diaFinal;

      $cotizaciones = DB::table('cotizaciones')->whereBetween('fecha',[$fechaInicial,$fechaFinal])->orderBy('id', 'desc')->get();

      $centrosdecosto = DB::table('centrosdecosto')
      ->whereNull('inactivo')
      ->whereNull('inactivo_total')
      ->orderBy('razonsocial')
      ->get();

      $users = DB::table('users')
      ->where('id_rol',12)
      ->whereNotNull('id_empleado')
      ->get();

      $ciudades = DB::table('ciudad')->get();

      $diaanterior = strtotime ('-1 day', strtotime($fechaInicial));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      $antiguas = DB::table('cotizaciones')
      ->where('estado',2)
      ->where('fecha','<=', $diaanterior)
      ->whereNotNull('fecha_solicitud')
      ->orderBy('id', 'desc')
      ->get();

      return View::make('servicios.listado')
      ->with([
        'cotizaciones'=>$cotizaciones,
        'otrascotizaciones'=>$antiguas,
        'centrosdecosto' => $centrosdecosto,
	      'permisos'=>$permisos,
        'users' => $users,
        'ciudades' => $ciudades
      ]);
    }
  }

  public function postBuscar(){

    if (!Sentry::check()){

        return Response::json([
            'respuesta'=>'relogin'
        ]);

    }else{

      if (Request::ajax()) {

        $fecha_vencimiento = Input::get('fecha_vencimiento');
        $estado = intval(Input::get('estado'));

        if ($fecha_vencimiento==='') {

          $fecha_inicial = Input::get('fecha_inicial');
          $fecha_final = Input::get('fecha_final');
          $consulta = "select * from cotizaciones where fecha between '".$fecha_inicial."' and '".$fecha_final."'";

          if ($estado===1) {
            $consulta .= " and estado = '1'";
          }else if ($estado===2) {
            $consulta .= " and estado = '2'";
          }else if ($estado===3) {
            $consulta .= " and estado = '3'";
          }else if ($estado===4) {
            $consulta .= " and estado = '4'";
          }else if ($estado===5) {
            $consulta .= " and estado = '5'";
          }

          $cotizaciones = DB::select($consulta);

          if ($cotizaciones!=null) {

            return Response::json([
              'respuesta'=>true,
              'cotizaciones'=>$cotizaciones,
              'consulta'=>$consulta
            ]);
          }else{
            return Response::json([
              'respuesta'=>'norespuesta',
              'consulta'=>$consulta
            ]);
          }

        }else if ($fecha_vencimiento!='') {

          $consulta = "select * from cotizaciones where fecha_vencimiento = '".$fecha_vencimiento."'";

          if ($estado===1) {
            $consulta .= " and estado = '1'";
          }else if ($estado===2) {
            $consulta .= " and estado = '2'";
          }else if ($estado===3) {
            $consulta .= " and estado = '3'";
          }else if ($estado===4) {
            $consulta .= " and estado = '4'";
          }else if ($estado===5) {
            $consulta .= " and estado = '5'";
          }

          $cotizaciones = DB::select($consulta);

          if ($cotizaciones!=null) {

            return Response::json([
              'respuesta'=>true,
              'cotizaciones'=>$cotizaciones,
              'consulta'=>$consulta
            ]);
          }else{
            return Response::json([
              'respuesta'=>'norespuesta',
              'consulta'=>$consulta
            ]);
          }

        }
      }
    }
  }

  public function postEstadocotizacion(){

    if (!Sentry::check()){

        return Response::json([
            'respuesta'=>'relogin'
        ]);

    }else{

      if (Request::ajax()) {

        $id = Input::get('id');
        $valor = Input::get('valor');

        $cotizacion = Cotizacion::find($id);
        $cotizacion->estado = $valor;

        if ($cotizacion->save()) {
          return Response::json([
            'respuesta'=>true
          ]);
        }else{
			return Response::json([
            'respuesta'=>false
          ]);
		}
      }

    }
  }

  public function getExportarexcel($id){

    Excel::create('Cotizacion'.date('Y-m-d').'-'.rand(0,999), function($excel) use ($id){

      $excel->sheet('Hoja', function($sheet) use($id){

          /*$sheet->setWidth(array(
              'A' => 14,
              'B' => 12,
              'C' => 13,
              'D' => 13,
              'E' => 25,
              'F' => 5,
              'G' => 12
          ));*/

          $cotizaciones = DB::table('cotizaciones')
          ->select('cotizaciones.id','cotizaciones.email as mail','cotizaciones.nombre_completo','cotizaciones.direccion','cotizaciones.fecha_vencimiento',
          'cotizaciones.consecutivo','cotizaciones.fecha','cotizaciones.nit','cotizaciones.creado_por','users.id','cotizaciones.contacto','cotizaciones.celular',
          'cotizaciones.tipo','cotizaciones.vendedor','cotizaciones.observacion','cotizaciones.contenido_html','cotizaciones.enviar_mail','cotizaciones.creado_por')
          ->leftJoin('users', 'cotizaciones.creado_por', '=', 'users.id')
          ->where('cotizaciones.id',$id)->first();

          /*$objDrawing = new PHPExcel_Worksheet_Drawing;
          $objDrawing->setPath('biblioteca_imagenes/mintransporte.png');
          $objDrawing->setCoordinates('A2');
          $objDrawing->setResizeProportional(false);
          $objDrawing->setWidth(380);
          $objDrawing->setHeight(80);
          $objDrawing->setWorksheet($sheet);*/

          /*$objDrawing = new PHPExcel_Worksheet_Drawing;
          $objDrawing->setPath('biblioteca_imagenes/logo_excel.png');
          $objDrawing->setCoordinates('E2');
          $objDrawing->setResizeProportional(false);
          $objDrawing->setWidth(280);
          $objDrawing->setHeight(80);
          $objDrawing->setWorksheet($sheet);*/

          //$sheet->protect('xmnuy20hj');

          $sheet->loadView('servicios.formatoexcelcotizacion')->with([
              'cotizaciones'=>$cotizaciones
          ]);
      })->download('xls');

    });
  }

  public function getExportarcotizacion($id){

      if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

          $cotizaciones = DB::table('cotizaciones')
          ->select('cotizaciones.id','cotizaciones.email as mail','cotizaciones.nombre_completo','cotizaciones.direccion','cotizaciones.fecha_vencimiento',
          'cotizaciones.consecutivo','cotizaciones.fecha','cotizaciones.nit','cotizaciones.creado_por','users.id','cotizaciones.contacto','cotizaciones.celular',
          'cotizaciones.tipo','cotizaciones.vendedor','cotizaciones.observacion','cotizaciones.contenido_html','cotizaciones.enviar_mail','cotizaciones.creado_por')
          ->leftJoin('users', 'cotizaciones.creado_por', '=', 'users.id')
          ->where('cotizaciones.id',$id)->first();

          $html = View::make('servicios.plantilla_cotizaciones')->with('cotizaciones',$cotizaciones);
          return PDF::load(utf8_decode($html), 'A4', 'portrait')->download('cotizacion');

      }
  }

  public function getDescargarcotizacion($consecutivo){

        $cotizaciones = DB::table('cotizaciones')
        ->select('cotizaciones.id','cotizaciones.email as mail','cotizaciones.nombre_completo','cotizaciones.direccion','cotizaciones.fecha_vencimiento',
        'cotizaciones.consecutivo','cotizaciones.fecha','cotizaciones.nit','cotizaciones.creado_por','users.id','cotizaciones.contacto','cotizaciones.celular',
        'cotizaciones.tipo','cotizaciones.vendedor','cotizaciones.observacion','cotizaciones.contenido_html','cotizaciones.enviar_mail','cotizaciones.creado_por')
        ->leftJoin('users', 'cotizaciones.creado_por', '=', 'users.id')
        ->where('cotizaciones.id',$consecutivo)->first();

        return View::make('servicios.descargar_cotizacion')->with([
          'consecutivo'=>$consecutivo
        ]);

  }

  public function postDescargararchivo(){

    $consecutivo = Input::get('id');

    $file= "https://app.aotour.com.co/autonet/biblioteca_imagenes/escolar/pdf/cotizacion_aotour_n_".$consecutivo.".pdf";

    $headers = array(
              'Content-Type: application/pdf',
            );

    return Response::download($file, 'filename.pdf', $headers);

  }

  public function postEnviarmail(){

    $id = Input::get('id');

    $replyName = '';
    $replyEmail = '';

    $cotizaciones = Cotizacion::find($id);

    $fromEmail = $cotizaciones->email;

    $tipo_cotizacion = $cotizaciones->tipo;

    $cotizaciones = DB::table('cotizaciones')
    ->select('cotizaciones.id','cotizaciones.asunto','cotizaciones.email as mail','cotizaciones.nombre_completo','cotizaciones.direccion','cotizaciones.fecha_vencimiento',
    'cotizaciones.consecutivo','cotizaciones.fecha','cotizaciones.archivos','cotizaciones.nit','cotizaciones.creado_por','users.id','cotizaciones.contacto','cotizaciones.celular',
    'cotizaciones.tipo','cotizaciones.vendedor','cotizaciones.observacion','cotizaciones.contenido_html','cotizaciones.enviar_mail','cotizaciones.creado_por')
    ->leftJoin('users', 'cotizaciones.creado_por', '=', 'users.id')
    ->where('cotizaciones.id',$id)->first();

    $html = View::make('servicios.plantilla_cotizaciones')->with('cotizaciones',$cotizaciones);
    $dataa = PDF::load($html, 'A4', 'portrait')->output();

    $idUser = Sentry::getUser()->id;

    $data = [
      'tipo'=>$tipo_cotizacion,
      'idUser'=>$idUser,
      'cotizaciones'=>$cotizaciones
    ];

    if ($idUser===46) {
      $replyEmail = 'ventas2@aotour.com.co';
      $replyName = 'VENTAS2 - AOTOUR';
      $fromName = 'VENTAS2 - AOTOUR';
    }elseif ($idUser===3) {
      $replyEmail = 'ventas1@aotour.com.co';
      $replyName = 'VENTAS1 - AOTOUR';
      $fromName = 'VENTAS1 - AOTOUR';
    }elseif ($idUser===4) {
      $replyEmail = 'comercial@aotour.com.co';
      $replyName = 'COMERCIAL - AOTOUR';
      $fromName = 'COMERCIAL - AOTOUR';
    }elseif ($idUser===2) {
      $replyEmail = 'sistemas@aotour.com.co';
      $replyName = 'SISTEMAS - AOTOUR';
      $fromName = 'SISTEMAS - AOTOUR';
    }else{
      $replyEmail = 'mail@aotour.com.co';
      $replyName = 'MAIL - AOTOUR';
      $fromName = 'MAIL - AOTOUR';
    }

    $nombresarchivos = $cotizaciones->archivos;

    $mail = Mail::send('emails.plantilla_pdf_cotizacion', $data, function($message) use ($nombresarchivos, $cotizaciones, $idUser, $fromEmail, $fromName, $dataa, $replyEmail, $replyName){
        $message->to([$fromEmail, $replyEmail]);
        $message->from($fromEmail, $fromName);
        $message->ReplyTo($replyEmail,$replyName);
        $message->subject($cotizaciones->consecutivo.' - '.$cotizaciones->asunto);

        if ($cotizaciones->archivos!=null) {
          $archivos_mail = explode(',',$nombresarchivos);
          $ubicacion = 'biblioteca_imagenes/archivos_cotizaciones/';
          for ($i=0; $i < count($archivos_mail) ; $i++) {
            $message->attach($ubicacion.$archivos_mail[$i]);
          }
        }
        $message->attachData($dataa, 'Cotizacion.pdf');
    });

    return Response::json([
      'respuesta'=>true,
    ]);
  }

  public function postEnviarhtml(){

    if (!Sentry::check()){

        return Response::json([
            'respuesta'=>'relogin'
        ]);

    }else{

      if (Request::ajax())

        try {

          $replyEmail = '';
          $replyName = '';

          $id = Input::get('id');

          $cotizaciones = Cotizacion::find($id);

          $asunto = $cotizaciones->asunto;

          $fromEmail = $cotizaciones->email;

          $tipo_cotizacion = $cotizaciones->tipo;

          $cotizaciones = DB::table('cotizaciones')
          ->leftJoin('users', 'cotizaciones.creado_por', '=', 'users.id')
          ->where('cotizaciones.id',$id)->first();

          $idUser = Sentry::getUser()->id;

          $data = [
            'tipo'=>$tipo_cotizacion,
            'cotizaciones'=>$cotizaciones,
            'iduser'=>$idUser
          ];

          $nombresarchivos = $cotizaciones->archivos;

          if ($idUser===46) {
            $replyEmail = 'ventas2@aotour.com.co';
            $replyName = 'VENTAS2 - AOTOUR';
            $fromName = 'VENTAS2 - AOTOUR';
          }elseif ($idUser===3) {
            $replyEmail = 'ventas1@aotour.com.co';
            $replyName = 'VENTAS1 - AOTOUR';
            $fromName = 'VENTAS1 - AOTOUR';
          }elseif ($idUser===4) {
            $replyEmail = 'comercial@aotour.com.co';
            $replyName = 'COMERCIAL - AOTOUR';
            $fromName = 'COMERCIAL - AOTOUR';
          }elseif ($idUser===2) {
            $replyEmail = 'sistemas@aotour.com.co';
            $replyName = 'SISTEMAS - AOTOUR';
            $fromName = 'SISTEMAS - AOTOUR';
          }else{
            $replyEmail = 'mail@aotour.com.co';
            $replyName = 'MAIL - AOTOUR';
            $fromName = 'MAIL - AOTOUR';
          }

          $mail = Mail::send('emails.plantilla_pdf_cotizacion', $data, function($message) use ($cotizaciones, $nombresarchivos, $fromEmail, $fromName, $replyName, $replyEmail, $asunto){

              $message->to([$fromEmail, $replyEmail]);
              $message->from($fromEmail, $fromName);
              $message->ReplyTo($replyEmail,$replyName);

              if ($cotizaciones->archivos!=null) {
                $archivos_mail = explode(',',$nombresarchivos);
                $ubicacion = 'biblioteca_imagenes/archivos_cotizaciones/';
                for ($i=0; $i < count($archivos_mail) ; $i++) {
                  $message->attach($ubicacion.$archivos_mail[$i]);
                }
              }

              //$message->cc('bduarte@aotour.com.co','BDUARTE - AOTOUR');
              $message->subject($cotizaciones->consecutivo.' - '.$asunto);
          });

          return Response::json([
            'respuesta'=>true,
            'id'=>$idUser
          ]);

        }catch(Exception $e) {
          return Response::json([
            'respuesta'=>false,
            'e'=>$e
          ]);
        }


    }
  }

  public function postBuscarcc(){
	   if (!Sentry::check()){
  		return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
  	}else{
  		if(Request::ajax()){
  			$centrodecosto_id = Input::get('centrodecosto_id');
  			$centrosdecosto = DB::table('centrosdecosto')->where('id', $centrodecosto_id)->first();

  			if($centrosdecosto != null){
  				return Response::json([
  				  'mensaje'=>true,
  				  'centrosdecosto'=>$centrosdecosto
  				]);
  			}else{
  					return Response::json(['mensaje'=>false]);
  			}
  		}else{
  				return Response::json(['mensaje'=>'relogin']);
  		}
  	}
  }

  public function postBuscartarifa(){
  	if (!Sentry::check()){
  		return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
  	}else{
  		if(Request::ajax()){
  			$tipo_serv = Input::get('tipo_serv');
  			$tipo_veh = Input::get('tipo_veh');
        $cc = Input::get('cc');


  			if($tipo_veh === 'AUTOMOVIL' or $tipo_veh === 'CAMIONETA'){
  				$consulta = "SELECT tarifa_cliente_automovil as tarifa FROM tarifa_traslado WHERE id = '$tipo_serv'";
  			}
  			if($tipo_veh === 'MINIVANS'){
  				$consulta = "SELECT tarifa_cliente_minivan as tarifa FROM tarifa_traslado WHERE id = '$tipo_serv'";
  			}
  			if($tipo_veh === 'VANS'){
  				$consulta = "SELECT tarifa_cliente_van as tarifa FROM tarifa_traslado WHERE id = '$tipo_serv'";
  			}
  			if($tipo_veh === 'BUS'){
  				$consulta = "SELECT tarifa_cliente_bus as tarifa FROM tarifa_traslado WHERE id = '$tipo_serv'";
  			}
  			if($tipo_veh === 'BUSETA'){
  				$consulta = "SELECT tarifa_cliente_buseta as tarifa FROM tarifa_traslado WHERE id = '$tipo_serv'";
  			}

        //

        if($tipo_veh === 'AUTOMOVIL' || $tipo_veh === 'CAMIONETA'){

          $consulta = "SELECT cliente_auto as tarifa FROM tarifas WHERE trayecto_id = ".$tipo_serv." and centrodecosto_id = ".$cc."";

        }else if($tipo_veh === 'MINIVANS' || $tipo_veh === 'VANS'){

          $consulta = "SELECT cliente_van as tarifa FROM tarifas WHERE trayecto_id = '$tipo_serv' and centrodecosto_id = '$cc'";

        }else{

          $consulta = "SELECT cliente_van as tarifa FROM tarifas WHERE trayecto_id = '$tipo_serv' and centrodecosto_id = 1000";

        }

  			$cotizacion_re = DB::select($consulta);

  			if($cotizacion_re != null){

          return Response::json([
  				  'mensaje'=>true,
  				  'cotizacion_re'=>$cotizacion_re,
            'consulta' => $consulta
  				]);

  			}else{

          return Response::json([
  				  'mensaje'=>false
  				]);

        }

  		}else{
  				return Response::json(['mensaje'=>'relogin']);
  		}
  	}

  }

  public function postBuscartarifalistado(){
  	if (!Sentry::check()){
  		return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
  	}else{
  		if(Request::ajax()){
  			$tipo_serv = Input::get('tipo_serv');
  			$tipo_veh = Input::get('tipo_veh');
        $cc = Input::get('cc');

        $nc = DB::table('cotizaciones')
        ->where('id',Input::get('id_cotizacion'))
        ->pluck('nombre_completo');

        $cc = DB::table('centrosdecosto')
        ->where('razonsocial',$nc)
        ->pluck('id');

  			if($tipo_veh === 'AUTOMOVIL' or $tipo_veh === 'CAMIONETA'){
  				$consulta = "SELECT tarifa_cliente_automovil as tarifa FROM tarifa_traslado WHERE id = '$tipo_serv'";
  			}
  			if($tipo_veh === 'MINIVANS'){
  				$consulta = "SELECT tarifa_cliente_minivan as tarifa FROM tarifa_traslado WHERE id = '$tipo_serv'";
  			}
  			if($tipo_veh === 'VANS'){
  				$consulta = "SELECT tarifa_cliente_van as tarifa FROM tarifa_traslado WHERE id = '$tipo_serv'";
  			}
  			if($tipo_veh === 'BUS'){
  				$consulta = "SELECT tarifa_cliente_bus as tarifa FROM tarifa_traslado WHERE id = '$tipo_serv'";
  			}
  			if($tipo_veh === 'BUSETA'){
  				$consulta = "SELECT tarifa_cliente_buseta as tarifa FROM tarifa_traslado WHERE id = '$tipo_serv'";
  			}

        //

        if($tipo_veh === 'AUTOMOVIL' || $tipo_veh === 'CAMIONETA'){

          $consulta = "SELECT cliente_auto as tarifa FROM tarifas WHERE trayecto_id = ".$tipo_serv." and centrodecosto_id = ".$cc."";

        }else if($tipo_veh === 'MINIVANS' || $tipo_veh === 'VANS'){

          $consulta = "SELECT cliente_van as tarifa FROM tarifas WHERE trayecto_id = '$tipo_serv' and centrodecosto_id = '$cc'";

        }else{

          $consulta = "SELECT cliente_van as tarifa FROM tarifas WHERE trayecto_id = '$tipo_serv' and centrodecosto_id = 1000";

        }

  			$cotizacion_re = DB::select($consulta);

  			if($cotizacion_re != null){

          return Response::json([
  				  'mensaje'=>true,
  				  'cotizacion_re'=>$cotizacion_re,
            'consulta' => $consulta
  				]);

  			}else{

          return Response::json([
  				  'mensaje'=>false
  				]);

        }

  		}else{
  				return Response::json(['mensaje'=>'relogin']);
  		}
  	}

  }

  public function postNuevotrayecto(){

    $traslado = new Traslado;
    $traslado->nombre = Input::get('nombre');
    $traslado->ciudad = Input::get('ciudad');
    $traslado->save();

    if( Input::get('cc')== 97){

      $consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is not null and localidad in('barranquilla','provisional') and id!=97 and id!=407";

			$bd = DB::select($consultas);

			foreach ($bd as $key) {

				$tarifa = new Tarifa;
				$tarifa->centrodecosto_id = $key->id_centro;
				$tarifa->trayecto_id = $traslado->id;
        if(Input::get('vehiculo')=='AUTOMOVIL' || Input::get('vehiculo')=='CAMIONETA'){
          $tarifa->cliente_auto = Input::get('cliente');
          $tarifa->proveedor_auto = Input::get('proveedor');
        }else if( Input::get('vehiculo')=='MINIVANS' or Input::get('vehiculo')=='VANS' ) {
      		$tarifa->cliente_van = Input::get('cliente');
          $tarifa->proveedor_van = Input::get('proveedor');
        }else{
          $tarifa->cliente_master = Input::get('cliente');
          $tarifa->proveedor_master = Input::get('proveedor');
        }
				$tarifa->localidad = Input::get('ciudad');
				$tarifa->estado = 1;
				$tarifa->save();

			}

    }else{

      $tarifa = new Tarifa;
  		$tarifa->centrodecosto_id = Input::get('cc');
  		$tarifa->trayecto_id = $traslado->id;
      if(Input::get('vehiculo')=='AUTOMOVIL' || Input::get('vehiculo')=='CAMIONETA'){
        $tarifa->cliente_auto = Input::get('cliente');
        $tarifa->proveedor_auto = Input::get('proveedor');
      }else if( Input::get('vehiculo')=='MINIVANS' or Input::get('vehiculo')=='VANS' ) {
    		$tarifa->cliente_van = Input::get('cliente');
        $tarifa->proveedor_van = Input::get('proveedor');
      }else{
        $tarifa->cliente_master = Input::get('cliente');
        $tarifa->proveedor_master = Input::get('proveedor');
      }
  		//$tarifa->localidad = Input::get('ciudad'); //localidad null cuando es baq
  		$tarifa->estado = 1;
  		$tarifa->save();

    }

    return Response::json([
      'respuesta' => true,
      'traslado' => $traslado->id
    ]);

  }

  public function postNuevocot(){

    if (!Sentry::check()){
        return Response::json(['mensaje'=>'relogin']);
    }else{

      if (Request::ajax()) {

        /*$validaciones = [
          'nombre_completo'=>'required',
		  //'identificacion'=>'required',
          'tipo'=>'required|numeric',
          //'enviar'=>'required|numeric',
          'asunto'=>'required'
        ];

        $mensajes = [
          'tipo.select'=>'Seleccione el tipo de cotizacion',
          'enviar.select'=>'Seleccione la opcion enviar Mail',
          'identificacion.numeric'=>'El campo identificacion debe ser un numero',
          'email.email'=>'El email debe ser una direccion valida',
          'asunto.required'=>'Rellene el campo asunto'
        ];

        $validador = Validator::make(Input::all(), $validaciones,$mensajes);

        if ($validador->fails()){

            return Response::json([
              'mensaje'=>false,
              'errores'=>$validador->errors()->getMessages()
            ]);

        }else{*/

          $cotizacionesdia = DB::table('cotizaciones')->where('fecha',date('Y-m-d'))->count();

          if ($cotizacionesdia===null) {
              $numerodia = 1;
          }else{
            $numerodia = $cotizacionesdia+1;
          }

          $arraynombres = [];

          $cotizaciones = new Cotizacion;
          $cotizaciones->fecha = date('Y-m-d');
          $cotizaciones->consecutivo = date('dmY').'-'.$numerodia;
          $cotizaciones->nombre_completo = Input::get('nombre_completo');
          $cotizaciones->fecha_vencimiento = Input::get('fecha_vencimiento');
          $cotizaciones->nit = Input::get('identificacion');
          $cotizaciones->direccion = Input::get('direccion');
          $cotizaciones->celular = Input::get('telefono');
          $cotizaciones->email = Input::get('email');
          $cotizaciones->asunto = Input::get('asunto');
          $cotizaciones->tipo = Input::get('tipo');
          $cotizaciones->quien = Input::get('quien');
          $cotizaciones->fecha_solicitud = Input::get('fecha_solicitud');
          //$cotizaciones->contenido_html = Input::get('contenido');
          //$cotizaciones->enviar_mail = Input::get('enviar');
          $cotizaciones->contacto = Input::get('contacto');
          $cotizaciones->vendedor = Input::get('vendedor');
          $cotizaciones->observacion = Input::get('observaciones');
          $cotizaciones->creado_por = Sentry::getUser()->id;
	        $cotizaciones->estado = 2;
	        $cotizaciones->valor_total = Input::get('total_general');
          //$cotizaciones->gestiones = json_encode([$array]);
          //SOPORTE
          if (Input::hasFile('pdf_soporte')){

            $file_pdf = Input::file('pdf_soporte');
            $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

            $ubicacion_pdf = 'biblioteca_imagenes/archivos_cotizaciones/';
            $file_pdf->move($ubicacion_pdf, $name_pdf);
            $cotizaciones->soporte_pdf = $name_pdf;
          }

          if ($cotizaciones->save()) {

            $insertedId = $cotizaciones->id;

      			$fecha_servicioV = explode(',',Input::get('fecha_servicioV'));
      			$tipo_servV = explode(',',Input::get('tipo_servV'));
      			$descripV = explode(',',Input::get('descripV'));
      			$ciudadV = explode(',',Input::get('ciudadV'));
      			$t_vehV = explode(',',Input::get('t_vehV'));
      			$paxV = explode(',',Input::get('paxV'));
      			$vehiculoV = explode(',',Input::get('vehiculoV'));
      			$valorTrayectoV = explode(',',Input::get('valorTrayectoV'));
      			$valorTotalV = explode(',',Input::get('valorTotalV'));

      			for ($i=0; $i < count($tipo_servV); $i++){
      				$cotizacion_det = new Cotizaciondetalle;
      				$cotizacion_det->id_cotizaciones = $insertedId;
      				$cotizacion_det->fecha_servicio = $fecha_servicioV[$i];
      				$cotizacion_det->tipo_servicio = $tipo_servV[$i];
      				$cotizacion_det->descripcion = $descripV[$i];
      				$cotizacion_det->ciudad = $ciudadV[$i];
      				$cotizacion_det->tipo_vehiculo = $t_vehV[$i];
      				$cotizacion_det->pax = $paxV[$i];
      				$cotizacion_det->vehiculos = $vehiculoV[$i];
      				$cotizacion_det->valorxvehiculo = $valorTrayectoV[$i];
      				$cotizacion_det->valortotal = $valorTotalV[$i];
      				$cotizacion_det->save();
      			}

            /*$archivos = Input::file('archivos');
            $ubicacion = 'biblioteca_imagenes/archivos_cotizaciones/';

            if (Input::hasFile('archivos')) {

              foreach ($archivos as $key => $value) {

                $nombre_imagen = $value->getClientOriginalName();
                if(file_exists($ubicacion.$nombre_imagen)){
                    $nombre_imagen = rand(1,10000).$nombre_imagen;
                }
                array_push($arraynombres, $nombre_imagen);
                $value->move($ubicacion, $nombre_imagen);

              }

              $archivosf = implode(',',$arraynombres);
              $cotizacion = Cotizacion::find($insertedId);
              $cotizacion->archivos = $archivosf;
              $cotizacion->save();

            }else{
              $archivosf = null;
            }*/

            $archivos = Input::file('archivos');
            $ubicacion = 'biblioteca_imagenes/archivos_cotizaciones/';
            $sw = 0;
            //$insertedId = 1621;

            $arraynombres = [];
            if (Input::hasFile('archivos')) {
              $sw = 1;
              foreach ($archivos as $key => $value) {
                $nombre_imagen = $value->getClientOriginalName();
                if(file_exists($ubicacion.$nombre_imagen)){
                  $nombre_imagen = rand(1,10000).$nombre_imagen;
                }
                $arrayVehiculo = [
                  'archivos' => $nombre_imagen, 'c1' => Input::get('c1v1'), 'c2' => Input::get('c2v1'), 'c3' => Input::get('c3v1'), 'desv1' => Input::get('desv1')
                ];
                $cotizacion = Cotizacion::find($insertedId);
                if($cotizacion->archivos1 == null){
                  $cotizacion->archivos1 = json_encode([$arrayVehiculo]);
                }else{
                  $objArray = json_decode($cotizacion->archivos1);
                  array_push($objArray, $arrayVehiculo);
                  $cotizacion->archivos1 = json_encode($objArray);
                }
                array_push($arraynombres, $arrayVehiculo);
                Image::make($value->getRealPath())->resize(350, 230)->save($ubicacion.$nombre_imagen);
                //$value->move($ubicacion, $nombre_imagen);
                $cotizacion->save();
              }
            }else{
              $archivosf = null;
            }

            //Vehiculo 2
            $arraynombres2 = [];
            $archivos2 = Input::file('archivos2');

            if (Input::hasFile('archivos2')) {
              $sw = 1;
              foreach ($archivos2 as $key => $value) {
                $nombre_imagen = $value->getClientOriginalName();
                if(file_exists($ubicacion.$nombre_imagen)){
                  $nombre_imagen = rand(1,10000).$nombre_imagen;
                }
                $arrayVehiculo = [
                  'archivos' => $nombre_imagen, 'c1' => Input::get('c1v2'), 'c2' => Input::get('c2v2'), 'c3' => Input::get('c3v2'), 'desv2' => Input::get('desv2')
                ];
                $cotizacion = Cotizacion::find($insertedId);
                if($cotizacion->archivos2 == null){
                  $cotizacion->archivos2 = json_encode([$arrayVehiculo]);
                }else{
                  $objArray = json_decode($cotizacion->archivos2);
                  array_push($objArray, $arrayVehiculo);
                  $cotizacion->archivos2 = json_encode($objArray);
                }
                array_push($arraynombres2, $arrayVehiculo);
                $value->move($ubicacion, $nombre_imagen);
                $cotizacion->save();
              }
            }else{
              $archivosf = null;
            }

            //Vehiculo 3
            $arraynombres3 = [];
            $archivos3 = Input::file('archivos3');

            if (Input::hasFile('archivos3')) {
              $sw = 1;
              foreach ($archivos3 as $key => $value) {
                $nombre_imagen = $value->getClientOriginalName();
                if(file_exists($ubicacion.$nombre_imagen)){
                  $nombre_imagen = rand(1,10000).$nombre_imagen;
                }
                $arrayVehiculo = [
                  'archivos' => $nombre_imagen, 'c1' => Input::get('c1v3'), 'c2' => Input::get('c2v3'), 'c3' => Input::get('c3v3'), 'desv3' => Input::get('desv3')
                ];
                $cotizacion = Cotizacion::find($insertedId);
                if($cotizacion->archivos3 == null){
                  $cotizacion->archivos3 = json_encode([$arrayVehiculo]);
                }else{
                  $objArray = json_decode($cotizacion->archivos3);
                  array_push($objArray, $arrayVehiculo);
                  $cotizacion->archivos3 = json_encode($objArray);
                }
                array_push($arraynombres3, $arrayVehiculo);
                $value->move($ubicacion, $nombre_imagen);
                $cotizacion->save();
              }
            }else{
              $archivosf = null;
            }

            //Vehiculo 4
            $arraynombres4 = [];
            $archivos4 = Input::file('archivos4');

            if (Input::hasFile('archivos4')) {
              $sw = 1;
              foreach ($archivos4 as $key => $value) {
                $nombre_imagen = $value->getClientOriginalName();
                if(file_exists($ubicacion.$nombre_imagen)){
                  $nombre_imagen = rand(1,10000).$nombre_imagen;
                }
                $arrayVehiculo = [
                  'archivos' => $nombre_imagen, 'c1' => Input::get('c1v4'), 'c2' => Input::get('c2v4'), 'c3' => Input::get('c3v4'), 'desv4' => Input::get('desv4')
                ];
                $cotizacion = Cotizacion::find($insertedId);
                if($cotizacion->archivos4 == null){
                  $cotizacion->archivos4 = json_encode([$arrayVehiculo]);
                }else{
                  $objArray = json_decode($cotizacion->archivos4);
                  array_push($objArray, $arrayVehiculo);
                  $cotizacion->archivos4 = json_encode($objArray);
                }
                array_push($arraynombres4, $arrayVehiculo);
                $value->move($ubicacion, $nombre_imagen);
                $cotizacion->save();
              }
            }else{
              $archivosf = null;
            }

            //Vehiculo 5
            $arraynombres5 = [];
            $archivos5 = Input::file('archivos5');

            if (Input::hasFile('archivos5')) {
              $sw = 1;
              foreach ($archivos5 as $key => $value) {
                $nombre_imagen = $value->getClientOriginalName();
                if(file_exists($ubicacion.$nombre_imagen)){
                  $nombre_imagen = rand(1,10000).$nombre_imagen;
                }
                $arrayVehiculo = [
                  'archivos' => $nombre_imagen, 'c1' => Input::get('c1v5'), 'c2' => Input::get('c2v5'), 'c3' => Input::get('c3v5'), 'desv5' => Input::get('desv5')
                ];
                $cotizacion = Cotizacion::find($insertedId);
                if($cotizacion->archivos5 == null){
                  $cotizacion->archivos5 = json_encode([$arrayVehiculo]);
                }else{
                  $objArray = json_decode($cotizacion->archivos5);
                  array_push($objArray, $arrayVehiculo);
                  $cotizacion->archivos5 = json_encode($objArray);
                }
                array_push($arraynombres5, $arrayVehiculo);
                $value->move($ubicacion, $nombre_imagen);
                $cotizacion->save();
              }
            }else{
              $archivosf = null;
            }

            //if (intval(Input::get('enviar'))===1) {
            if(1>0){

              $fromEmail = 'sistemas@aotour.com.co';//Input::get('email');
              $fromName = 'MAIL - AOTOUR';

              $tipo_cotizacion = $cotizaciones->tipo;

              $data = [
                'tipo'=>$tipo_cotizacion
              ];

              $cotizaciones = DB::table('cotizaciones')
              ->leftJoin('users', 'cotizaciones.creado_por', '=', 'users.id')
              ->where('cotizaciones.id',$insertedId)->first();

              //$html = View::make('servicios.plantilla_cotizaciones')->with('cotizaciones',$cotizaciones);
              //$dataa = PDF::load($html, 'A4', 'portrait')->output();

              /*$html = View::make('escolar.validaciones.pdf_contrato')->with([
                'contrato' => 12345,
                'acudiente' => 'SAMUEL GONZALEZ',
                'estudiante' => 'SANTIAGO GONZALEZ',
                'curso' => 'PRIMERO',
                'email' => 'SDGM2207@GMAIL.COM'
              ]);*/

              $dataText = 'Se realizó envío de cotización al correo: '.Input::get('email').' el '.date('Y-m-d').' a las '.date('H:i').', por '.Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name.'';
              /*$array = [
                  'gestion' => $dataText,
                  'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
                  'fecha' => date('Y-m-d')
              ];*/

              $detalles = DB::table('cotizaciones_detalle')
              ->where('id_cotizaciones',$insertedId)
              ->get();

              $arrayData = [];

              foreach ($detalles as $detalle) {
                $arrays = [
                    'trayecto' => $detalle->tipo_servicio,
                    'vehiculos' => $detalle->vehiculos,
                    'valortotal' => $detalle->valortotal
                ];
                array_push($arrayData, $arrays);
              }

              $array = [
                  'gestion' => $dataText,
                  'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
                  'fecha' => date('Y-m-d'),
                  'cambios' => json_encode($arrayData)
              ];

              $coti = Cotizacion::find($insertedId);
              $coti->cantidad_gestiones = 1;
              $coti->gestiones = json_encode([$array]);
              $coti->save();

              $fecha = explode('-', Input::get('fecha_solicitud'));
          		$mes = $fecha[1];
          		if($mes==='01'){
          			$mes = 'ENERO';
          		}else if($mes==='02'){
          			$mes = 'FEBRERO';
          		}else if($mes==='03'){
          			$mes = 'MARZO';
          		}else if($mes==='04'){
          			$mes = 'ABRIL';
          		}else if($mes==='05'){
          			$mes = 'MAYO';
          		}else if($mes==='06'){
          			$mes = 'JUNIO';
          		}else if($mes==='07'){
          			$mes = 'JULIO';
          		}else if($mes==='08'){
          			$mes = 'AGOSTO';
          		}else if($mes==='09'){
          			$mes = 'SEPTIEMBRE';
          		}else if($mes==='10'){
          			$mes = 'OCTUBRE';
          		}else if($mes==='11'){
          			$mes = 'NOVIEMBRE';
          		}else if($mes==='12'){
          			$mes = 'DICIEMBRE';
          		}

              $dates = $fecha[2].' de '.ucwords(strtolower($mes)).' del '.$fecha[0];

              $empleado = DB::table('empleados')
              ->where('id',Sentry::getUser()->id_empleado)
              ->first();

              $html = View::make('servicios.plantilla_cotizaciones_test')->with([
                'consecutivo' => $insertedId,
                'nombre_completo' => strtoupper(Input::get('nombre_completo')),
                'contacto' => Input::get('contacto'),
                'asunto' => $cotizaciones->asunto,
                'soporte' => $cotizaciones->soporte_pdf,
                'fecha' => $dates,
                'detalles' => $detalles,
                'total' => Input::get('total_general'),
                'telefono' => $empleado->telefono,
                'email' => $empleado->correo,
                'cantidad' => count($tipo_servV),
                'no_mostrar' => Input::get('no_mostrar'),
                'observaciones' => Input::get('observaciones')
              ]);

              $outputName = 'Cotizacion_Aotour_'.$insertedId; // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
              $pdfPath = 'biblioteca_imagenes/escolar/pdf/'.$outputName.'.pdf';
              File::put($pdfPath, PDF::load($html, 'A4', 'portrait')->output());

              /*if($cotizacion->archivos!=null){
                  foreach(json_decode($cotizacion->archivos) as $file){
                    'biblioteca_imagenes/archivos_cotizaciones/'.$file->archivos
                  }
              }*/

              $email = Input::get('email');
              //$email = 'sistemas@aotour.com.co';

              $cc = ['facturacion@aotour.com.co','b.carrillo@aotour.com.co','comercial@aotour.com.co','gustelo@aotour.com.co'];
              //$cc = 'comercial@aotour.com.co';
              //$cc = 'aotourdeveloper@gmail.com';

              if(Input::get('nombre_completo')=='SGS COLOMBIA HOLDING BARRANQUILLA' or Input::get('nombre_completo')=='SGS COLOMBIA HOLDING BOGOTA' ){
                $clients = 'SGS COLOMBIA HOLDING';
              }else{
                $clients = Input::get('nombre_completo');
              }

              $data = [
                'consecutivo' => $insertedId,
                'fecha' => $dates,
                'asunto' => $cotizaciones->asunto,
                'contacto' => Input::get('contacto'),
                'cliente' => $clients
              ];
              //nueva_cotizacion
              Mail::send('emails.mail', $data, function($message) use ($pdfPath, $email, $insertedId, $cc, $cotizaciones){
              	$message->from('no-reply@aotour.com.co', 'COTIZACIÓN AOTOUR');
              	$message->to($email)->subject('Cotización AOTOUR No. '.$insertedId);
                $message->cc($cc);
              	$message->attach($pdfPath);
                if(isset($cotizaciones->archivos1)){
                  foreach(json_decode($cotizaciones->archivos1) as $file){
                    // code...
                    $pdfPaths = 'biblioteca_imagenes/archivos_cotizaciones/'.$file->archivos;
                    $message->attach($pdfPaths);
                  }
                }
              });

              return Response::json([
                'mensaje'=>true,
                'observaciones'=>Input::get('observaciones')
              ]);

            }else{

            }

			return Response::json([
                'mensaje'=>true,
                'arraynombres'=>$arraynombres,
                'observaciones'=>Input::get('observaciones')
              ]);
          }

        //}

      }
    }
  }

  public function postFiltrar() {

    if (!Sentry::check()){

      return Response::json([
        'respuesta' => 'sesion_caducada'
      ]);

    }else{

      $estado = Input::get('estado');
      $cliente = Input::get('cliente');
      $usuario = Input::get('usuario');
      $fecha_inicial = Input::get('fecha_inicial');
      $fecha_final = Input::get('fecha_final');

      $query = "SELECT * from cotizaciones where fecha between '".$fecha_inicial."' and '".$fecha_final."'";

      if($estado!='0'){
        $query .= " and estado = ".$estado."";
      }

      if($cliente!='Seleccionar Cliente'){
        $query .= " and nombre_completo = '".$cliente."'";
      }

      if($usuario!='0'){
        $query .= " and creado_por = ".$usuario."";
      }

      $query .= " order by id desc";

      $cotizaciones = DB::select($query);

      if(count($cotizaciones)) {

        return Response::json([
          'respuesta' => true,
          'cotizaciones' => $cotizaciones,
          'query' => $query,
          'estado' => $estado
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'query' => $query,
        ]);

      }

    }

  }

  public function getEmail(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';
    }else{
      $ver = 'on';
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{


      return View::make('emails.enviar_cotizacion', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getAceptarcotizacion($consecutivo) {

    $cliente = DB::table('cotizaciones')
    ->where('id',$consecutivo)
    ->first();

    $email = 'comercial@aotour.com.co';
    $cc = ['facturacion@aotour.com.co','b.carrillo@aotour.com.co','comercial@aotour.com.co','gustelo@aotour.com.co'];
    $sw = '';
    if($cliente->estado!=1 and $cliente->estado!=3){

      //estado en 1
      $update = DB::table('cotizaciones')
      ->where('id',$consecutivo)
      ->update([
        'estado' => 1
      ]);

      $data = [
        'consecutivo'=>$consecutivo,
        'cliente' => $cliente->nombre_completo
      ];

      Mail::send('emails.cotizacion_aprobada', $data, function($message) use ($email, $consecutivo,$cc){
        $message->from('no-reply@aotour.com.co', 'COTIZACIÓN APROBADA');
        $message->to($email)->subject('Cotización No. '.$consecutivo);
        $message->cc($cc);
      });

    }else if($cliente->estado==3){
      $sw = 'rechazada';
    }else if($cliente->estado==1){
      $sw = 'aprobada';
    }

    return View::make('servicios.aceptar_cotizacion')->with([
      'consecutivo'=>$consecutivo,
      'sw' => $sw
    ]);

  }

  public function getRechazarcotizacion($consecutivo) {

    $cliente = DB::table('cotizaciones')
    ->where('id',$consecutivo)
    ->first();

    $email = 'comercial@aotour.com.co';
    $cc = ['facturacion@aotour.com.co','b.carrillo@aotour.com.co','comercial@aotour.com.co','gustelo@aotour.com.co'];
    $sw = '';
    if($cliente->estado!=1 and $cliente->estado!=3){

      //estado en 3

      $update = DB::table('cotizaciones')
      ->where('id',$consecutivo)
      ->update([
        'estado' => 3
      ]);

      $data = [
        'consecutivo'=>$consecutivo,
        'cliente' => $cliente->nombre_completo
      ];

      Mail::send('emails.cotizacion_rechazada', $data, function($message) use ($email, $consecutivo, $cc){
        $message->from('no-reply@aotour.com.co', 'COTIZACIÓN RECHAZADA');
        $message->to($email)->subject('Cotización No. '.$consecutivo);
        $message->cc($cc);
      });

    }else if($cliente->estado==3){
      $sw = 'rechazada';
    }else if($cliente->estado==1){
      $sw = 'aprobada';
    }

    /*Agregar gestión de Rechazo*/

    /*Agregar gestión de Rechazo*/

    return View::make('servicios.rechazar_cotizacion')->with([
      'consecutivo'=>$consecutivo,
      'sw' => $sw
    ]);

  }

  public function getDetallescot($id){

    if (Sentry::check()) {
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
    }else{
      $id_rol = null;
      $permisos = null;
      $permisos = null;
    }

    if (isset($permisos->comercial->cotizaciones->ver)){
      $ver = $permisos->comercial->cotizaciones->ver;
    }else{
      $ver = null;
    }

    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on' ) {
      return View::make('admin.permisos');
    }else {

	  $cotizaciones = Cotizacion::find($id);
      $cotizaciones_det = DB::table('cotizaciones_detalle')->where('id_cotizaciones',$id)->get();

	  $centrosdecosto = DB::table('centrosdecosto')->whereNull('inactivo_total')->whereNull('inactivo')->orderBy('razonsocial')->get();
	  $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
	  $rutas = DB::table('ruta_general')->orderBy('nombre_ruta')->get();

	  return View::make('servicios.cotizaciones_editar2')->with([
        'i'=>1,
		'cotizaciones'=>$cotizaciones,
        'permisos'=>$permisos,
		'cotizaciones_det'=>$cotizaciones_det,
		'centrosdecosto'=>$centrosdecosto,
		'ciudades'=>$ciudades,
		'rutas'=>$rutas
      ]);
    }

  }

  public function getExportarcot($id){

      if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

          $cotizaciones = DB::table('cotizaciones')
          ->select('cotizaciones.id','cotizaciones.email as mail','cotizaciones.nombre_completo','cotizaciones.direccion','cotizaciones.fecha_vencimiento',
          'cotizaciones.consecutivo','cotizaciones.fecha','cotizaciones.nit','cotizaciones.creado_por','users.id','cotizaciones.contacto','cotizaciones.celular',
          'cotizaciones.tipo','cotizaciones.vendedor','cotizaciones.observacion','cotizaciones.contenido_html','cotizaciones.enviar_mail','cotizaciones.creado_por')
          ->leftJoin('users', 'cotizaciones.creado_por', '=', 'users.id')
          ->where('cotizaciones.id',$id)->first();

		      $cotizacion_det = DB::table('cotizaciones_detalle')->where('id_cotizaciones',$id)->get();

          $html = View::make('servicios.plantilla_cotizaciones2')->with(['cotizaciones'=>$cotizaciones, 'cotizacion_det'=>$cotizacion_det]);
          return PDF::load(utf8_decode($html), 'A4', 'portrait')->download('cotizacion '.$cotizaciones->consecutivo);

      }
  }

  public function postActualizarcot(){

    if (!Sentry::check()){

        return Response::json(['mensaje'=>'relogin']);

    }else{

      if (Request::ajax()) {

            $cotizaciones = Cotizacion::find(Input::get('id'));
            //$cotizaciones->nombre_completo = Input::get('nombre_completo');
            //$cotizaciones->fecha_vencimiento = Input::get('fecha_vencimiento');
            //$cotizaciones->nit = Input::get('identificacion');
            $cotizaciones->direccion = Input::get('direccion');
            $cotizaciones->celular = Input::get('telefono');
            $cotizaciones->email = Input::get('email');
            $cotizaciones->asunto = Input::get('asunto');
            $cotizaciones->tipo = Input::get('tipo');

            $cotizaciones->contacto = Input::get('contacto');
            $cotizaciones->vendedor = Input::get('vendedor');
            $cotizaciones->observacion = Input::get('observaciones');
            //$cotizaciones->creado_por = Sentry::getUser()->id;

  			if($cotizaciones->save()){

  				DB::table('cotizaciones_detalle')->where('id_cotizaciones', $cotizaciones->id)->delete();

  				$fecha_servicioV = explode(',',Input::get('fecha_servicioV'));
  				$tipo_servV = explode(',',Input::get('tipo_servV'));
  				$descripV = explode(',',Input::get('descripV'));
  				$ciudadV = explode(',',Input::get('ciudadV'));
  				$t_vehV = explode(',',Input::get('t_vehV'));
  				$paxV = explode(',',Input::get('paxV'));
  				$vehiculoV = explode(',',Input::get('vehiculoV'));
  				$valorTrayectoV = explode(',',Input::get('valorTrayectoV'));
  				$valorTotalV = explode(',',Input::get('valorTotalV'));

  				for ($i=0; $i < count($tipo_servV); $i++){

  					$cotizacion_det = new Cotizaciondetalle;
  					$cotizacion_det->id_cotizaciones = $cotizaciones->id;
  					$cotizacion_det->fecha_servicio = $fecha_servicioV[$i];
  					$cotizacion_det->tipo_servicio = $tipo_servV[$i];
  					$cotizacion_det->descripcion = $descripV[$i];
  					$cotizacion_det->ciudad = $ciudadV[$i];
  					$cotizacion_det->tipo_vehiculo = $t_vehV[$i];
  					$cotizacion_det->pax = $paxV[$i];
  					$cotizacion_det->vehiculos = $vehiculoV[$i];
  					$cotizacion_det->valorxvehiculo = $valorTrayectoV[$i];
  					$cotizacion_det->valortotal = $valorTotalV[$i];
  					$cotizacion_det->save();

  				}

  				return Response::json(['mensaje'=>true]);

  			}
	    }
    }
  }

  public function postTiposervicios(){

  	if (!Sentry::check()){

  		return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

  	}else{

  		if(Request::ajax()){

  			$ciudad = Input::get('ciudad');

  			$tipo_servicio = DB::table('tarifa_traslado')->where('tarifa_ciudad', $ciudad)->orderBy('tarifa_nombre')->get();

        $tipo_servicio = DB::table('traslados')
        //->leftJoin('')
        //->whereIn('ciudad',[$ciudad,'PROVISIONAL'])
        ->whereNotNull('id')->orderBy('nombre')->get();

  			if($tipo_servicio != null){

  				return Response::json([
  				  'mensaje'=>true,
  				  'tipo_servicio'=>$tipo_servicio
  				]);

  			}else{

  				return Response::json([
  				  'mensaje'=>'no hay',
  				  'ciudad'=>$ciudad
  				]);

  			}

  		}
  	}

  }

  public function postTiposervicioscotizacion(){

  	if (!Sentry::check()){

  		return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

  	}else{

  		if(Request::ajax()){

  			$ciudad = Input::get('ciudad');

  			$tipo_servicio = DB::table('tarifa_traslado')->where('tarifa_ciudad', $ciudad)->orderBy('tarifa_nombre')->get();

        $tipo_servicio = DB::table('traslados')
        //->leftJoin('')
        //->whereIn('ciudad',[$ciudad,'PROVISIONAL'])
        ->whereNotNull('id')->orderBy('nombre')->get();

  			if($tipo_servicio != null){

  				return Response::json([
  				  'mensaje'=>true,
  				  'tipo_servicio'=>$tipo_servicio
  				]);

  			}else{

  				return Response::json([
  				  'mensaje'=>'no hay',
  				  'ciudad'=>$ciudad
  				]);

  			}

  		}
  	}

  }

  //GESTIONES
  public function postReactivar() {

    $id = Input::get('id');

    $consulta = DB::table('cotizaciones')
    ->where('id',$id)
    ->update([
      'estado' => 2
    ]);

    $cot = Cotizacion::find(intval($id));

    $fecha = date('Y-m-d');

    $dataText = 'SE REACTIVÓ LA COTIZACIÓN.';

    $array = [
        'gestion' => $dataText,
        'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
        'fecha' => $fecha
    ];

    if($cot->gestiones===null) {
      $cot->cantidad_gestiones = 1;
      $cot->gestiones = json_encode([$array]);
    }else{
      $suma = intval($cot->cantidad_gestiones)+1;
      $objArray = json_decode($cot->gestiones);
      array_push($objArray, $array);
      $cot->gestiones = json_encode($objArray);
      $cot->cantidad_gestiones = $suma;
    }

    $cot->save();

    return Response::json([
      'respuesta' => true
    ]);

  }

  public function postAprobada() {

    $id = Input::get('id');

    $consulta = DB::table('cotizaciones')
    ->where('id',$id)
    ->update([
      'estado' => 1
    ]);

    $cot = Cotizacion::find(intval($id));

    $fecha = date('Y-m-d');

    $dataText = 'SE REGISTRÓ LA COTIZACIÓN COMO APROBADA.';

    $array = [
        'gestion' => $dataText,
        'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
        'fecha' => $fecha
    ];

    if($cot->gestiones===null) {
      $cot->cantidad_gestiones = 1;
      $cot->gestiones = json_encode([$array]);
    }else{
      $suma = intval($cot->cantidad_gestiones)+1;
      $objArray = json_decode($cot->gestiones);
      array_push($objArray, $array);
      $cot->gestiones = json_encode($objArray);
      $cot->cantidad_gestiones = $suma;
    }
    $cot->save();

    //ENVÍO DE CORREO AL CLIENTE
    $data = [
      'consecutivo' => $id
    ];

    /*//$email = 'sistemas@aotour.com.co';
    $email = $cot->correo;
    $cc = ['aotourdeveloper@gmail.com','comercial@aotour.com.co','servicioalcliente@aotour.com.co'];

    Mail::send('reportes.emails.negociacion_exitosa', $data, function($message) use ($email, $id, $cc){
      $message->from('no-reply@aotour.com.co', '¡Bienvenido!');
      $message->to($email)->subject('AOTOUR te da la bienvenida');
      $message->cc($cc);
      $message->attach('biblioteca_imagenes/Formato_Inscripcion_de_clientes.docx');
    });*/
    //ENVÍO DE CORREO AL CLIENTE

    return Response::json([
      'respuesta' => true
    ]);

  }

  public function postRechazada() {

    $id = Input::get('id');

    $consulta = DB::table('cotizaciones')
    ->where('id',$id)
    ->update([
      'estado' => 3
    ]);

    $cot = Cotizacion::find(intval($id));

    $fecha = date('Y-m-d');
    $motivo = Input::get('motivo');

    $dataText = 'SE REGISTRÓ LA COTIZACIÓN COMO RECHAZADA.<br>Motivo: '.strtoupper($motivo).''; //Motivo, colocar dato dinámico al insertar a la base de datos

    $array = [
        'gestion' => $dataText,
        'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
        'fecha' => $fecha
    ];

    if($cot->gestiones===null) {
      $cot->cantidad_gestiones = 1;
      $cot->gestiones = json_encode([$array]);
    }else{
      $suma = intval($cot->cantidad_gestiones)+1;
      $objArray = json_decode($cot->gestiones);
      array_push($objArray, $array);
      $cot->gestiones = json_encode($objArray);
      $cot->cantidad_gestiones = $suma;
    }

    $cot->save();

    return Response::json([
      'respuesta' => true
    ]);

  }

  public function postConsultargestion() {

    $id = Input::get('id');

    $portafolio = DB::table('cotizaciones')
    ->where('id',$id)
    ->first();

    if($portafolio->gestiones!=null){
      return Response::json([
        'respuesta' => true,
        'portafolio' => $portafolio
      ]);
    }else{
      return Response::json([
        'respuesta' => false,
        'portafolio' => $portafolio
      ]);
    }

  }

  public function postExitosa() {

    $id = Input::get('id');

    $consulta = DB::table('portafolio')
    ->where('id',$id)
    ->update([
      'estado' => 1
    ]);

    $neg = Portafolio::find(intval($id));

    $fecha = date('Y-m-d');

    $dataText = 'SE CONCRETÓ LA NEGOCIACIÓN. ESTA FUE MARCADA COMO EXITOSA.';

    $array = [
        'gestion' => $dataText,
        'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
        'fecha' => $fecha
    ];

    $suma = intval($neg->cantidad_gestiones)+1;

    $objArray = json_decode($neg->gestiones);
    array_push($objArray, $array);
    $neg->gestiones = json_encode($objArray);
    $neg->cantidad_gestiones = $suma;
    $neg->save();

    //ENVÍO DE CORREO AL CLIENTE
    $data = [
      'consecutivo' => $id
    ];

    //$email = 'sistemas@aotour.com.co';
    $email = $neg->correo;
    $cc = ['aotourdeveloper@gmail.com','comercial@aotour.com.co','servicioalcliente@aotour.com.co'];

    Mail::send('reportes.emails.negociacion_exitosa', $data, function($message) use ($email, $id, $cc){
      $message->from('no-reply@aotour.com.co', '¡Bienvenido!');
      $message->to($email)->subject('AOTOUR te da la bienvenida');
      $message->cc($cc);
      $message->attach('biblioteca_imagenes/Formato_Inscripcion_de_clientes.docx');
    });
    //ENVÍO DE CORREO AL CLIENTE

    return Response::json([
      'respuesta' => true
    ]);

  }

  public function postFees() {

    $id = Input::get('id');

    $detalles = DB::table('cotizaciones_detalle')
    ->where('id_cotizaciones',$id)
    ->get();

    return Response::json([
      'respuesta' => true,
      'detalles' => $detalles
    ]);

  }

  public function postActualizarcotizacion() {

    $insertedId = Input::get('id');

    $fecha_servicioV = explode(',',Input::get('fecha_servicioV'));
    $tipo_servV = explode(',',Input::get('tipo_servV'));
    $descripV = explode(',',Input::get('descripV'));
    $ciudadV = explode(',',Input::get('ciudadV'));
    $t_vehV = explode(',',Input::get('t_vehV'));
    $paxV = explode(',',Input::get('paxV'));
    $vehiculoV = explode(',',Input::get('vehiculoV'));
    $valorTrayectoV = explode(',',Input::get('valorTrayectoV'));
    $valorTotalV = explode(',',Input::get('valorTotalV'));

    $cot = Cotizacion::find(intval($insertedId));

    $detalles = DB::table('cotizaciones_detalle')
    ->where('id_cotizaciones',$insertedId)
    ->get();

    $arrayData = [];

    foreach ($detalles as $detalle) {
      $array = [
          'trayecto' => $detalle->tipo_servicio,
          'vehiculos' => $detalle->vehiculos,
          'valortotal' => $detalle->valortotal
      ];
      array_push($arrayData, $array);
    }

    $cotizacion = DB::table('cotizaciones')
    ->where('id',$insertedId)
    ->update([
      'valor_total' => Input::get('total_general')
    ]);

    $delete = DB::table('cotizaciones_detalle')
    ->where('id_cotizaciones',$insertedId)
    ->delete();

    $arrayData2 = [];

    for ($i=0; $i < count($tipo_servV); $i++){
      $cotizacion_det = new Cotizaciondetalle;
      $cotizacion_det->id_cotizaciones = $insertedId;
      $cotizacion_det->fecha_servicio = $fecha_servicioV[$i];
      $cotizacion_det->tipo_servicio = $tipo_servV[$i];
      $cotizacion_det->descripcion = $descripV[$i];
      $cotizacion_det->ciudad = $ciudadV[$i];
      $cotizacion_det->tipo_vehiculo = $t_vehV[$i];
      $cotizacion_det->pax = $paxV[$i];
      $cotizacion_det->vehiculos = $vehiculoV[$i];
      $cotizacion_det->valorxvehiculo = $valorTrayectoV[$i];
      $cotizacion_det->valortotal = $valorTotalV[$i];
      $cotizacion_det->save();

      $array = [
          'trayecto' => $cotizacion_det->tipo_servicio,
          'vehiculos' => $cotizacion_det->vehiculos,
          'valortotal' => $cotizacion_det->valortotal
      ];
      array_push($arrayData2, $array);

    }

    //Guardar la Gestión

    $fecha = date('Y-m-d');

    $dataText = 'Se realizó actualización de Tarifas/Traslados';

    $array = [
        'gestion' => $dataText,
        'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
        'fecha' => $fecha,
        'cambios' => json_encode($arrayData2)
    ];

    if($cot->gestiones===null) {
      $cot->cantidad_gestiones = 1;
      $cot->gestiones = json_encode([$array]);
    }else{
      $suma = intval($cot->cantidad_gestiones)+1;
      $objArray = json_decode($cot->gestiones);
      array_push($objArray, $array);
      $cot->gestiones = json_encode($objArray);
      $cot->cantidad_gestiones = $suma;
    }

    $cot->save();
    //Guardar la Gestión

    $cotizaciones = DB::table('cotizaciones')
    ->leftJoin('users', 'cotizaciones.creado_por', '=', 'users.id')
    ->select('cotizaciones.*', 'users.first_name', 'users.last_name')
    ->where('cotizaciones.id',$insertedId)->first();

    $fecha = explode('-', $cotizaciones->fecha_solicitud);
    $mes = $fecha[1];
    if($mes==='01'){
      $mes = 'ENERO';
    }else if($mes==='02'){
      $mes = 'FEBRERO';
    }else if($mes==='03'){
      $mes = 'MARZO';
    }else if($mes==='04'){
      $mes = 'ABRIL';
    }else if($mes==='05'){
      $mes = 'MAYO';
    }else if($mes==='06'){
      $mes = 'JUNIO';
    }else if($mes==='07'){
      $mes = 'JULIO';
    }else if($mes==='08'){
      $mes = 'AGOSTO';
    }else if($mes==='09'){
      $mes = 'SEPTIEMBRE';
    }else if($mes==='10'){
      $mes = 'OCTUBRE';
    }else if($mes==='11'){
      $mes = 'NOVIEMBRE';
    }else if($mes==='12'){
      $mes = 'DICIEMBRE';
    }

    $dates = $fecha[2].' de '.ucwords(strtolower($mes)).' del '.$fecha[0];

    $empleado = DB::table('empleados')
    ->where('id',Sentry::getUser()->id_empleado)
    ->first();

    $html = View::make('servicios.plantilla_cotizaciones_test')->with([
      'consecutivo' => $insertedId,
      'nombre_completo' => strtoupper($cotizaciones->nombre_completo),
      'contacto' => $cotizaciones->contacto,
      'asunto' => $cotizaciones->asunto,
      'soporte' => $cotizaciones->soporte_pdf,
      'fecha' => $dates,
      'detalles' => DB::table('cotizaciones_detalle')->where('id_cotizaciones',$insertedId)->get(),//$detalles,
      'total' => Input::get('total_general'),
      'telefono' => $empleado->telefono,
      'email' => $empleado->correo,
      'cantidad' => count($tipo_servV),
      'no_mostrar' => Input::get('no_mostrar'),
      'observaciones' => $cotizaciones->observacion
    ]);

    $outputName = 'Cotizacion_Aotour_'.$insertedId; // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
    $pdfPath = 'biblioteca_imagenes/escolar/pdf/'.$outputName.'.pdf';
    if(file_exists($pdfPath)){
        File::delete($pdfPath);
    }
    File::put($pdfPath, PDF::load($html, 'A4', 'portrait')->output());

    //Envío de correo
    //$email = 'sistemas@aotour.com.co';
    $email = $cotizaciones->email;

    $cc = ['facturacion@aotour.com.co','b.carrillo@aotour.com.co','comercial@aotour.com.co','gustelo@aotour.com.co'];
    //$cc = 'comercial@aotour.com.co';

    if(Input::get('nombre_completo')=='SGS COLOMBIA HOLDING BARRANQUILLA' or Input::get('nombre_completo')=='SGS COLOMBIA HOLDING BOGOTA' ){
      $clients = 'SGS COLOMBIA HOLDING';
    }else{
      $clients = Input::get('nombre_completo');
    }

    $data = [
      'consecutivo' => $insertedId,
      'fecha' => $dates,
      'asunto' => $cotizaciones->asunto,
      'contacto' => $cotizaciones->contacto,
      'cliente' => $cotizaciones->nombre_completo
    ];

    Mail::send('emails.mod_cotizacion', $data, function($message) use ($pdfPath, $email, $insertedId, $cc, $cotizaciones){
      $message->from('no-reply@aotour.com.co', 'RECOTIZACIÓN AOTOUR');
      $message->to($email)->subject('Negociación de cotización #'.$insertedId);
      $message->cc($cc);
      $message->attach($pdfPath);
      if(isset($cotizaciones->archivos1)){
        foreach(json_decode($cotizaciones->archivos1) as $file){
          // code...
          $pdfPaths = 'biblioteca_imagenes/archivos_cotizaciones/'.$file->archivos;
          $message->attach($pdfPaths);
        }
      }
    });
    //Envío de correo

    return Response::json([
      'mensaje' => true
    ]);

  }

 }
