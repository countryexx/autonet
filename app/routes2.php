<?php

  use Illuminate\Support\Facades\Route;

  Route::get('testuri', function() {


return 'testing';

  });

  /*
  Route::get('mailtest', function(){

    $asunto = 'Solicitud de traslados / Paula Alvarez';
    $texto = 'De acuerdo a su amable solicitud le confirmo la coordinación de sus traslados, ante cualquier inquietud por favor  no dude en contactarnos.';

    //return $contenido_correo_electronico['datos_traslado'];

    $contenido_email = 'Buenos dias envio solicitud de traslados';

    return View::make('emails.envio_servicios', [
      'texto' => $texto,
      'contenido_email' => $contenido_email
    ]);

    Mail::send('emails.envio_servicios', ['texto' => $texto], function($message) use($asunto)
    {
        $message->to('aotourdeveloper@gmail.com', 'Auto Ocasional Tour')
        ->from('transportes1@aotour.com.co', 'Auto Ocasional Tour')
        ->cc('sistemas@aotour.com.co')
        ->subject($asunto);
    });

  });*/

  Route::post('descargarcodigoqr', function(){

    $pasajero = Input::get('codeinfo');
    //$pasajero = Pasajero::find(Input::get('codeinfo'));
    $code = DB::table('pasajeros')->where('id',$pasajero)->pluck('cedula');
    $username = Sentry::getUser()->username;
    $data = DB::table('pasajeros')->where('id',$pasajero)->pluck('cedula');
    $nombres = DB::table('pasajeros')->where('id',$pasajero)->pluck('nombres');
    $apellidos = DB::table('pasajeros')->where('id',$pasajero)->pluck('apellidos');
    $cliente = DB::table('pasajeros')->where('id',$pasajero)->pluck('centrodecosto_id');
    $centro = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
    $direccion = DB::table('pasajeros')->where('id',$pasajero)->pluck('direccion');
    $barrio = DB::table('pasajeros')->where('id',$pasajero)->pluck('barrio');
    $html = View::make('portalusuarios.qrcode4')->with([
      'data' => $data,
      'code' => $code,
      'nombres' => $nombres,
      'apellidos' => $apellidos,
      'centro' => $centro,
      'username' => $username,
      'direccion' => $direccion,
      'barrio' => $barrio
    ]);

    return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('CODE'.$data);
  });

  Route::get('descargarqr', function(){
    $username = Sentry::getUser()->username;
    $data = DB::table('pasajeros')->where('correo',$username)->get();    
    $cliente = DB::table('pasajeros')->where('correo',$username)->pluck('centrodecosto_id');
    $centro = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');    
    $html = View::make('portalusuarios.qrcode3')->with([
      'dato' => $data,
      'centro' => $centro,      
    ]);

    return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('QR CODE');
  });

  Route::get('descargarpoliticas', function() {
    $html = View::make('portalusuarios.descargas.politicadedatos');

    return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('Política de Tratamiento Datos - AOTOUR');
  });

  Route::get('descargarqremail', function($code){
//    $user = Pasajero::where('cedula', $code)->pluck('ce');
    $user = $code;
    $html = View::make('portalusuarios.qrcode3')->with([
      'data' => $user,
      //'nombres' => $nombres,
      //'apellidos' => $apellidos,
      //'centro' => $centro,
      //'username' => $username
    ]);

    return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('CODE'.$data);

  });

  Route::get('pdfdownload', function(){
    $name = Input::get('name');
    $texto = Input::get('texto');    
    $html = View::make('admin.pdf_limpieza')->with([
      'name' => $name,
      'texto' => $texto,      
    ]);

    return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('QR CODE');
  });

  Route::get('descargar/fuec_link/numero/{fuec_id}', function($fuec_id){

    $fuec = DB::table('fuec')
      ->select('contratos.numero_contrato','fuec.consecutivo', 'fuec.id', 'contratos.contratante','contratos.nit_contratante','contratos.cliente','contratos.representante_legal',
        'contratos.cc_representante','contratos.telefono_representante','contratos.direccion_representante', 'vehiculos.ano as vehiculo_ano',
        'fuec.objeto_contrato','fuec.ano','rutas_fuec.ruta as descripcion_ruta','rutas_fuec.origen','rutas_fuec.destino','fuec.fecha_inicial','fuec.fecha_final',
        'vehiculos.placa','vehiculos.modelo','vehiculos.modelo','vehiculos.marca','vehiculos.clase','vehiculos.numero_interno','vehiculos.tarjeta_operacion',
        'fuec.conductor','vehiculos.empresa_afiliada','fuec.colegio')
      ->leftJoin('vehiculos','fuec.vehiculo','=','vehiculos.id')
      ->leftJoin('contratos','fuec.contrato_id','=','contratos.id')
      ->leftJoin('rutas_fuec','fuec.ruta_id','=','rutas_fuec.id')
      ->where('fuec.id', $fuec_id)
      ->first();

    $fuec_save = Fuec::find($fuec->id);

    if (!is_null($fuec_save->envio_fuec)) {

      if (is_null($fuec_save->enviofuec->politicas_aceptadas)) {

        return View::make('fuec.aceptar_politicas', [
          'fuec' => $fuec_save
        ]);

      }else if(!is_null($fuec_save->enviofuec->politicas_aceptadas)){

        if ($fuec_save->cantidad_descargas==null){
          $fuec_save->cantidad_descargas = 1;
        }else{
          $fuec_save->cantidad_descargas = intval($fuec_save->cantidad_descargas) + 1;
        }

        if (is_null($fuec_save->jsonIP)){

          $arrayIP = [];

          array_push($arrayIP, [
            'IP' => Methods::getRealIpAddr(),
            'USER_AGENT' => Methods::getBrowser(),
            'TIME' => date('Y-m-d H:i:s')
          ]);

          $fuec_save->jsonIP = json_encode($arrayIP);

        }else{

          $arrayIP = json_decode($fuec_save->jsonIP);

          array_push($arrayIP, [
            'IP' => Methods::getRealIpAddr(),
            'USER_AGENT' => Methods::getBrowser(),
            'TIME' => date('Y-m-d H:i:s')
          ]);

          $fuec_save->jsonIP = json_encode($arrayIP);
        }

        $fuec_save->save();

        $arrayidc = explode(',',$fuec->conductor);

        $html = View::make('fuec.pdf_fuec')->with([
          'fuec' => $fuec,
          'arrayidc' => $arrayidc
        ]);

        return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('FUEC'.$fuec->consecutivo);

      }

    }

  });

  Route::get('descargar/fuec/numero/{fuec_id}', function($fuec_id){

  	$fuec = DB::table('fuec')
  					->select('contratos.numero_contrato','fuec.consecutivo', 'fuec.id', 'contratos.contratante','contratos.nit_contratante','contratos.cliente','contratos.representante_legal',
  					'contratos.cc_representante','contratos.telefono_representante','contratos.direccion_representante', 'vehiculos.ano as vehiculo_ano',
  					'fuec.objeto_contrato','fuec.ano','rutas_fuec.ruta as descripcion_ruta','rutas_fuec.origen','rutas_fuec.destino','fuec.fecha_inicial','fuec.fecha_final',
  					'vehiculos.placa','vehiculos.modelo','vehiculos.modelo','vehiculos.marca','vehiculos.clase','vehiculos.numero_interno','vehiculos.tarjeta_operacion',
  					'fuec.conductor','vehiculos.empresa_afiliada','fuec.colegio')
  					->leftJoin('vehiculos','fuec.vehiculo','=','vehiculos.id')
  					->leftJoin('contratos','fuec.contrato_id','=','contratos.id')
  					->leftJoin('rutas_fuec','fuec.ruta_id','=','rutas_fuec.id')
  					->where('fuec.id', $fuec_id)
  					->first();

  	$arrayidc = explode(',',$fuec->conductor);

  	$html = View::make('fuec.pdf_fuec')->with([
  		'fuec' => $fuec,
  		'arrayidc' => $arrayidc
  	]);

  	return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('FUEC'.$fuec->consecutivo);

  });

  Route::post('politicas/fuec/aceptar/{envio_fuec_id}', function($envio_fuec_id){

    $validaciones = [
      'cc' => 'required|numeric',
      'aceptar_politicas' => 'accepted'
    ];

    $messages = [
      'aceptar_politicas.accepted' => 'Debe aceptar las politicas de uso antes de continuar'
    ];

    //VALIDADOR
    $validador = Validator::make(Input::all(), $validaciones, $messages);

    //SI EL VALIDADOR FALLA ENTONCES ENVIA RESPUESTA DE ERROR CON UN ARRAY DE ERROR
    if ($validador->fails()){

      return Redirect::back()->withErrors($validador)->withInput();

    }else {

      $envio_fuec = Enviofuec::where('id', $envio_fuec_id)->with(['vehiculo', 'fuec'])->first();

      if (Input::get('cc')!=$envio_fuec->vehiculo->proveedor->nit) {

        return Redirect::back()->with('errores', 'El numero de identificacion no coincide')->withInput();

      }else {

        $envio_fuec->politicas_aceptadas = 1;
        $envio_fuec->fecha_aceptacion = date('Y-m-d H:i:s');

        $envio_fuec->jsonIP = json_encode([
          'IP' => Methods::getRealIpAddr(),
          'USER_AGENT' => Methods::getBrowser()
        ]);

        if($envio_fuec->save()){

          return View::make('fuec.politicas_aceptadas', [
            'envio_fuec' => $envio_fuec
          ]);

        }

      }

    }

  });
  //Portal de Usuarios
    Route::get('portalusuarioslogin', function(){
      return View::make('portalusuarios.login');
    });
  //

    //
      Route::get('portalusuarios', function(){

        if (!Sentry::check()){

          return View::make('admin.login')->with('mensaje','Para ingresar al sistema debe loguearse primero');

        }else{

          //$id_rol = Sentry::getUser()->id_rol;
          //$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          //$permisos = json_decode($permisos);

          return View::make('admin.principal');
        /*  ->with([
            'permisos'=>$permisos
          ]);
*/
        }

      });
    //

  Route::get('/', function(){

  	if (!Sentry::check()){

  		return View::make('admin.login')->with('mensaje','Para ingresar al sistema debe loguearse primero');

  	}else{

  		$id_rol = Sentry::getUser()->id_rol;
      $id_usuario = Sentry::getUser()->id;
      $userportal = Sentry::getUser()->usuario_portal;
  		$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
  		$permisos = json_decode($permisos);

      //$consulta = "select top 1 * from welcome order by id desc";
      //$welcome = DB::select($consulta);

      //$consulta = "select * from welcome order by id desc limit 1";
      //$welcome = DB::select($consulta);
      $welcome = DB::table('welcome')->orderBy('id','desc')->limit(1)->first();

  		return View::make('admin.principal')
  		->with([
  			'permisos'=>$permisos,
        'userportal'=>$userportal,
        'idusuario' =>$id_usuario,
        'welcome' =>$welcome
  		]);

  	}

  });

  //
    //Route::get('register/verify/{code}', 'Auth\Auth')
  //

  Route::get('admin/graficas', function(){

  	if (!Sentry::check()){

  		return View::make('admin.login')->with('mensaje','Para ingresar al sistema debe loguearse primero');

  	}else{

  		$id_rol = Sentry::getUser()->id_rol;
  		$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
  		$permisos = json_decode($permisos);

  		return View::make('admin.graficas')
  		->with([
  			'permisos' => $permisos
  		]);

  	}

  });

  Route::get('permiso_denegado', function(){

  	$id_rol = Sentry::getUser()->id_rol;
  	$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
  	$permisos = json_decode($permisos);

  	return View::make('admin.permisos', [
  		'permisos' => $permisos
  	]);

  });

  Route::get('papelera', function(){

  	$id_rol = Sentry::getUser()->id_rol;
  	$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
  	$permisos = json_decode($permisos);
  	$ver = $permisos->barranquilla->papeleradereciclajebq->ver;

  	if (!Sentry::check()){

  		return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

  	}else if($ver!='on') {
  		return View::make('admin.permisos');
  	}else{

  		$papelera = DB::table('papelera')
  		->leftJoin('users', 'papelera.eliminado_por', '=', 'users.id')
  		->select('papelera.id','papelera.informacion','papelera.eliminado_por','papelera.motivo_eliminacion','papelera.fecha_eliminacion',
  				 'users.first_name','users.last_name')
  	  ->orderBy('fecha_eliminacion','desc')
  		->get();

  		$proveedores = DB::table('proveedores')->where('localidad','barranquilla')->orderBy('razonsocial')->get();
  		$centrosdecosto = DB::table('centrosdecosto')
      ->where('localidad','barranquilla')
  			->whereNull('inactivo_total')
  			->orderBy('razonsocial')
  			->get();
  		$subcentrosdecosto = DB::table('subcentrosdecosto')->orderBy('nombresubcentro')->get();
  		$ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
  		$usuarios = DB::table('users')->where('coordinador',1)->where('activated',1)->get();

  		return View::make('admin.papelera')
  		->with([
  			'papelera'=>$papelera,
  			'proveedores'=>$proveedores,
  			'centrosdecosto'=>$centrosdecosto,
  			'subcentrosdecosto'=>$subcentrosdecosto,
  			'ciudades'=>$ciudades,
  			'usuarios'=>$usuarios

  		]);

  	}

  });

  Route::get('papelerabog', function(){

    $id_rol = Sentry::getUser()->id_rol;
    $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
    $permisos = json_decode($permisos);
    $ver = $permisos->bogota->papeleradereciclaje->ver;

    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on') {
      return View::make('admin.permisos');
    }else{

      $papelera = DB::table('papelera')
      ->leftJoin('users', 'papelera.eliminado_por', '=', 'users.id')
      ->select('papelera.id','papelera.informacion','papelera.eliminado_por','papelera.motivo_eliminacion','papelera.fecha_eliminacion',
           'users.first_name','users.last_name')
      ->orderBy('fecha_eliminacion','desc')
      ->get();

      $proveedores = DB::table('proveedores')->where('localidad','bogota')->orderBy('razonsocial')->get();
      $centrosdecosto = DB::table('centrosdecosto')
      ->where('localidad','bogota')
        ->whereNull('inactivo_total')
        ->orderBy('razonsocial')
        ->get();
      $subcentrosdecosto = DB::table('subcentrosdecosto')->orderBy('nombresubcentro')->get();
      $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
      $usuarios = DB::table('users')->where('coordinador',1)->where('activated',1)->get();

      return View::make('admin.papelerabog')
      ->with([
        'papelera'=>$papelera,
        'proveedores'=>$proveedores,
        'centrosdecosto'=>$centrosdecosto,
        'subcentrosdecosto'=>$subcentrosdecosto,
        'ciudades'=>$ciudades,
        'usuarios'=>$usuarios

      ]);

    }

  });
  
  //SERVICIOS Y RUTAS BARRANQUILLA
  Route::get('serviciosyrutasbarranquilla', function (){
    if (Sentry::check()) {
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
      }else{
        $id_rol = null;
        $permisos = null;
        $permisos = null;
      }

      if (isset($permisos->barranquilla->serviciosbq->ver)){
        $ver = $permisos->barranquilla->serviciosbq->ver;
      }else{
        $ver = null;
      }

      if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on') {

        return View::make('admin.permisos');

      }else{

        $query = Servicio::select('servicios.*', 'facturacion.revisado','facturacion.liquidado','facturacion.facturado','facturacion.factura_id',
                  'proveedores.tipo_afiliado', 'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro','users.first_name',
                  'users.last_name', 'rutas.nombre_ruta','rutas.codigo_ruta','proveedores.razonsocial AS razonproveedor',
                  'conductores.nombre_completo','conductores.celular','conductores.telefono','conductores.usuario_id',
                  'reconfirmacion.numero_reconfirmaciones','reconfirmacion.id as id_reconfirmacion','reconfirmacion.ejecutado',
                  'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo',
                  'encuesta.pregunta_1','encuesta.pregunta_2','encuesta.pregunta_3','encuesta.pregunta_4',
                  'encuesta.pregunta_8','encuesta.pregunta_9','encuesta.pregunta_10',
                  'servicios_edicion_pivote.id as id_pivote', 'reportes_pivote.id as id_reporte', 'servicios_autorizados_pdf.documento_pdf1', 'servicios_autorizados_pdf.documento_pdf2')
            ->leftJoin('servicios_edicion_pivote', 'servicios.id', '=', 'servicios_edicion_pivote.servicios_id')
            ->leftJoin('reportes_pivote', 'servicios.id', '=', 'reportes_pivote.servicio_id')
            ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
            ->leftJoin('reconfirmacion', 'servicios.id', '=', 'reconfirmacion.id_servicio')
            ->leftJoin('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
            ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
            ->LeftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
            ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
            ->leftJoin('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
            ->leftJoin('users', 'servicios.creado_por', '=', 'users.id')
            ->leftJoin('encuesta', 'servicios.id','=','encuesta.id_servicio')
            ->leftJoin('facturacion', 'servicios.id','=','facturacion.servicio_id')
            ->leftJoin('servicios_autorizados_pdf', 'servicios.id', '=', 'servicios_autorizados_pdf.servicio_id')
            ->where('servicios.anulado',0)
            ->whereNull('servicios.localidad')
            //->whereIn('centrosdecosto.localidad',['barranquilla','provisional'])
            //->whereIn('users.localidad',['1','3'])
            ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
            ->whereNull('servicios.pendiente_autori_eliminacion')
            ->whereNull('servicios.afiliado_externo')
            ->where('fecha_servicio',date('Y-m-d'));

            //MODIFICICACIÓN PARA QUE OPERACIONES NO VISUALICE LOS SERVICIOS MONTADOS POR FACTURACION
            //SE AGREGÓ EL CAMPO 
            if($id_rol==1 or $id_rol==2 or $id_rol==8){            
              $servicios = $query->orderBy('hora_servicio')->get(); 
            }else{                
              $servicios = $query->whereNull('servicios.control_facturacion')->orderBy('hora_servicio')->get();
            }

        $proveedores = Proveedor::Afiliadosinternos()
        ->orderBy('razonsocial')
        ->whereIn('localidad',['barranquilla','provisional'])
        ->where('tipo_servicio', 'TRANSPORTE TERRESTRE')
        ->whereNull('inactivo_total')
        ->whereNull('inactivo')
        ->get();

        $centrosdecosto = Centrodecosto::Internos()->whereIn('localidad',['BARRANQUILLA','provisional'])->orderBy('razonsocial')->get();

        $subcentros = DB::table('subcentrosdecosto')->orderBy('nombresubcentro')->get();
        $departamentos = DB::table('departamento')->get();
        $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
        $rutas = DB::table('rutas')->get();
        $usuarios = DB::table('users')->where('coordinador',1)->where('activated',1)->get();

        $cotizaciones = DB::table('cotizaciones')->where('estado',1)->orderBy('created_at', 'desc')->take(10)->get();

        return View::make('servicios.transportes_servicios_rutasbaq')
        ->with([
          'cotizaciones' => $cotizaciones,
          'servicios' => $servicios,
          'centrosdecosto' => $centrosdecosto,
          'departamentos' => $departamentos,
          'ciudades' => $ciudades,
          'proveedores' => $proveedores,
          'rutas' => $rutas,
          'permisos'=> $permisos,
          'usuarios' => $usuarios,
          'o' => 1
        ]);

      }
    });
  
  //SERVICIOS Y RUTAS BOGOTÁ
  Route::get('serviciosyrutasbogota', function (){
    if (Sentry::check()) {
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
      }else{
        $id_rol = null;
        $permisos = null;
        $permisos = null;
      }

      if (isset($permisos->bogota->servicios->ver)){
        $ver = $permisos->bogota->servicios->ver;
      }else{
        $ver = null;
      }

      if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on') {

        return View::make('admin.permisos');

      }else{

        $query = Servicio::select('servicios.*', 'facturacion.revisado','facturacion.liquidado','facturacion.facturado','facturacion.factura_id',
                  'proveedores.tipo_afiliado', 'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro','users.first_name',
                  'users.last_name', 'rutas.nombre_ruta','rutas.codigo_ruta','proveedores.razonsocial AS razonproveedor',
                  'conductores.nombre_completo','conductores.celular','conductores.telefono','conductores.usuario_id',
                  'reconfirmacion.numero_reconfirmaciones','reconfirmacion.id as id_reconfirmacion','reconfirmacion.ejecutado',
                  'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo',
                  'encuesta.pregunta_1','encuesta.pregunta_2','encuesta.pregunta_3','encuesta.pregunta_4',
                  'encuesta.pregunta_8','encuesta.pregunta_9','encuesta.pregunta_10',
                  'servicios_edicion_pivote.id as id_pivote', 'reportes_pivote.id as id_reporte', 'servicios_autorizados_pdf.documento_pdf1', 'servicios_autorizados_pdf.documento_pdf2')
            ->leftJoin('servicios_edicion_pivote', 'servicios.id', '=', 'servicios_edicion_pivote.servicios_id')
            ->leftJoin('reportes_pivote', 'servicios.id', '=', 'reportes_pivote.servicio_id')
            ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
            ->leftJoin('reconfirmacion', 'servicios.id', '=', 'reconfirmacion.id_servicio')
            ->leftJoin('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
            ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
            ->LeftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
            ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
            ->leftJoin('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
            ->leftJoin('users', 'servicios.creado_por', '=', 'users.id')
            ->leftJoin('encuesta', 'servicios.id','=','encuesta.id_servicio')
            ->leftJoin('facturacion', 'servicios.id','=','facturacion.servicio_id')
            ->leftJoin('servicios_autorizados_pdf', 'servicios.id', '=', 'servicios_autorizados_pdf.servicio_id')
            ->where('servicios.anulado',0)
            //->whereIn('centrosdecosto.localidad',['bogota','provisional'])
            //->whereIn('users.localidad',['2','3'])
            ->where('servicios.localidad',1)
            ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
            ->whereNull('servicios.pendiente_autori_eliminacion')
            ->whereNull('servicios.afiliado_externo')
            ->where('fecha_servicio',date('Y-m-d'));

            //MODIFICICACIÓN PARA QUE OPERACIONES NO VISUALICE LOS SERVICIOS MONTADOS POR FACTURACION
            //SE AGREGÓ EL CAMPO 
            if($id_rol==1 or $id_rol==2 or $id_rol==8){            
              $servicios = $query->orderBy('hora_servicio')->get(); 
            }else{                
              $servicios = $query->whereNull('servicios.control_facturacion')->orderBy('hora_servicio')->get();
            }

        $proveedores = Proveedor::Afiliadosinternos()
        ->orderBy('razonsocial')
        ->where('tipo_servicio', 'TRANSPORTE TERRESTRE')
        ->where('localidad','bogota')
        ->whereNull('inactivo_total')
        ->whereNull('inactivo')
        ->get();

        $centrosdecosto = Centrodecosto::Internos()->whereIn('localidad',['bogota','provisional'])->orderBy('razonsocial')->get();

        $subcentros = DB::table('subcentrosdecosto')->orderBy('nombresubcentro')->get();
        $departamentos = DB::table('departamento')->get();
        $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
        $rutas = DB::table('rutas')->get();
        $usuarios = DB::table('users')->where('coordinador',1)->where('activated',1)->get();

        $cotizaciones = DB::table('cotizaciones')->where('estado',1)->orderBy('created_at', 'desc')->take(10)->get();

        return View::make('servicios.transportes_servicios_rutasbog')
        ->with([
          'cotizaciones' => $cotizaciones,
          'servicios' => $servicios,
          'centrosdecosto' => $centrosdecosto,
          'departamentos' => $departamentos,
          'ciudades' => $ciudades,
          'proveedores' => $proveedores,
          'rutas' => $rutas,
          'permisos'=> $permisos,
          'usuarios' => $usuarios,
          'o' => 1
        ]);

      }
    });

  Route::get('menu', function (){
  	return Redirect::to('/');
  });

  Route::controller('fuec', 'FuecController');
  Route::controller('portalusu','PortalusuariosController');
  Route::controller('pqr','PqrController');
  Route::controller('formulariolimpieza','ProvisionalController');
  Route::controller('listadousuariosqr','ListadoAController');
  //Route::controller('misservicios','ServiciosController');
  Route::controller('serviciosgps','GpsController');
  Route::controller('serviciosadmin', 'ServiciosadminController'); //Administrador de Centro de Costo
  Route::controller('centrodecosto','CentrodecostoController');
  Route::controller('ciudades','DepartamentosController');
  Route::controller('rutas', 'RutasController');
  Route::controller('proveedores','ProveedoresController');
  Route::controller('usuarios','UsuariosController');
  Route::controller('transportes','TransportesController');
  //Route::controller('serviciosyrutasbog','TransportesbogotaController'); //prueba
  Route::controller('transportesbaq','TransportesbaqController');
  Route::controller('transportesbog','TransportesbogController');
  Route::controller('facturacion', 'FacturacionController');
  Route::controller('otrosservicios', 'OtrosserviciosController');
  Route::controller('encuestasygraficas', 'EncuestasygraficasController');
  Route::controller('cotizaciones', 'CotizacionesController');
  Route::controller('comisiones', 'ComisionesController');
  Route::controller('mobile', 'MobileController');
  Route::controller('hvvehiculos', 'HvvehiculosController');
  Route::controller('tarifastraslados', 'TarifastrasladosController');
  Route::controller('transportesrutasqr', 'TransportesrutasqrController');  //Samuel
  Route::controller('transportesrutasqrbog', 'TransportesrutasqrbogController');  //Samuel
  Route::controller('transportesrutas', 'TransportesrutasController');
  Route::controller('transportesrutasbog', 'TransportesrutasbogController'); //bog
  Route::controller('oauth', 'OAuthController');
  Route::controller('importarpasajeros', 'importController'); //samuel
  Route::controller('singin', 'RegistroController'); //samuel
  Route::controller('listadopasajeros', 'listadoController'); //samuel
  Route::controller('dashboard', 'DashboardController'); //samuel
  Route::controller('gestiondocumental', 'GestiondocumentalController'); //samuel
  Route::controller('control', 'ControlController'); //samuel
  Route::controller('pasajeros', 'PasajeroController');
  Route::controller('talentohumano', 'ThumanoController');
  Route::controller('gestionintegral', 'GestionintegralController');

  Route::controller('reportes', 'ReportesController');
  //Route::controller('maps', 'MapsController');
  Route::controller('portalproveedores', 'RegistroproveedoresController');

  Route::group(['prefix' => 'api', 'before' => 'oauth'], function(){
      Route::controller('v1','Apiv1Controller');
  });

  Route::group(['prefix' => 'api', 'before' => 'oauth'], function(){
      Route::controller('v2','Apiv2Controller');
  });
?>
