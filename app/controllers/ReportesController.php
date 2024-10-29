<?php

use Illuminate\Database\Eloquent\Model;

Class ReportesController extends BaseController{

	//VISTA PARA REPORTES QR
  public function getIndex(){

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

      $query = DB::table('qr_rutas')
      ->orderBy('qr_rutas.servicio_id','asc')
      ->leftJoin('servicios', 'servicios.id', '=', 'qr_rutas.servicio_id')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->select('qr_rutas.*', 'servicios.ruta', 'servicios.conductor_id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.detalle_recorrido', 'conductores.nombre_completo', 'vehiculos.placa')
      ->where('servicios.fecha_servicio',date('Y-m-d'))
      ->where('servicios.centrodecosto_id',287)
      ->whereNull('pendiente_autori_eliminacion')
      ->get();

      $o = 1;

      return View::make('reportes.bog.reportes', [

        'documentos' => $query,
        'permisos' =>$permisos,
        'o' => $o

      ]);
    }
  }

  public function getPqr(){

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

      $query = DB::table('qr_rutas')
      ->orderBy('qr_rutas.servicio_id','asc')
      ->leftJoin('servicios', 'servicios.id', '=', 'qr_rutas.servicio_id')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->select('qr_rutas.*', 'servicios.ruta', 'servicios.conductor_id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.detalle_recorrido', 'conductores.nombre_completo', 'vehiculos.placa')
      ->where('servicios.fecha_servicio',date('Y-m-d'))
      ->where('servicios.centrodecosto_id',287)
      ->whereNull('pendiente_autori_eliminacion')
      ->get();

      $o = 1;

      $centrosdecosto = DB::table('centrosdecosto')
      ->whereNull('inactivo')
      ->whereNull('inactivo_total')
      ->orderBy('razonsocial')
      ->get();

      return View::make('reportes.pqr.inicio', [
        'centrosdecosto' => $centrosdecosto,
        'documentos' => $query,
        'permisos' =>$permisos,
        'o' => $o

      ]);
    }
  }

  public function getPqrss(){

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

      $query = DB::table('qr_rutas')
      ->orderBy('qr_rutas.servicio_id','asc')
      ->leftJoin('servicios', 'servicios.id', '=', 'qr_rutas.servicio_id')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->select('qr_rutas.*', 'servicios.ruta', 'servicios.conductor_id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.detalle_recorrido', 'conductores.nombre_completo', 'vehiculos.placa')
      ->where('servicios.fecha_servicio',date('Y-m-d'))
      ->where('servicios.centrodecosto_id',287)
      ->whereNull('pendiente_autori_eliminacion')
      ->get();

      $o = 1;

      $centrosdecosto = DB::table('centrosdecosto')
      ->whereNull('inactivo')
      ->whereNull('inactivo_total')
      ->orderBy('razonsocial')
      ->get();

      return View::make('reportes.pqr.inicio', [
        'centrosdecosto' => $centrosdecosto,
        'documentos' => $query,
        'permisos' =>$permisos,
        'o' => $o

      ]);
    }
  }

  public function postConsultarcliente() {

    $consulta =  DB::table('centrosdecosto')
    ->where('id',Input::get('id'))
    ->first();

    return Response::json([
      'respuesta' => true,
      'cliente' => $consulta
    ]);

  }

  public function postPqr(){

      $cliente = Sentry::getUser()->centrodecosto_id;

      if(Request::ajax()){

            $nombres = Input::get('nombres');
            $telefono = Input::get('telefono');
            $fecha = Input::get('fecha_inicial');
            $tiposolicitud = Input::get('tiposolicitud');
            $info = Input::get('info');
            $email = Input::get('email');
            $solicitante = Input::get('solicitante');
            $ciudad = Input::get('ciudad');
            $direccion = Input::get('direccion');

              if(Input::get('info2')==null){
                  $info2 = 'N/A';
              }else{
                  $info2 = Input::get('info2');
              }

              if(Input::get('tiposerv')==null){
                  $tiposerv = 'N/A';
              }else{
                  $tiposerv = Input::get('tiposerv');
              }

              if(Input::get('conductor')==null){
                  $conductor = 'N/A';
              }else{
                  $conductor = Input::get('conductor');
              }

              if(Input::get('ruta')==null){
                  $ruta = 'N/A';
              }else{
                  $ruta = Input::get('ruta');
              }

              if(Input::get('placa')==null){
                  $placa = 'N/A';
              }else{
                  $placa = Input::get('placa');
              }

              if(Input::get('servicio')==null){
                  $servicio = 'N/A';
              }else{
                  $servicio = Input::get('servicio');
              }

              if(Input::get('fecha_ocurrencia')!=null)           {
                  $fecha_ocurrencia = Input::get('fecha_ocurrencia');
              }else{
                  $fecha_ocurrencia = 'N/A';
              }

              if(Input::get('nombres_r')==null){
                $nombres_r = 'N/A';
              }else{
                $nombres_r = Input::get('nombres_r');
              }

              if(Input::get('apellidos_r')==null){
                $apellidos_r = 'N/A';
              }else{
                $apellidos_r = Input::get('apellidos_r');
              }

              if(Input::get('direccion_r')==null){
                $direccion_r = 'N/A';
              }else{
                $direccion_r = Input::get('direccion_r');
              }

              if(Input::get('telefono_r')==null){
                $telefono_r = 'N/A';
              }else{
                $telefono_r = Input::get('telefono_r');
              }

              if(Input::get('correo_r')==null){
                $correo_r = 'N/A';
              }else{
                $correo_r = Input::get('correo_r');
              }

            if (Input::hasFile('soporte_pqr')){

              $file_pdf = Input::file('soporte_pqr');
              $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

              $ubicacion_pdf = 'biblioteca_imagenes/reportes/pqr/pdf/';

              if(file_exists($ubicacion_pdf.$name_pdf)){
                $name_pdf = rand(1,10000).$name_pdf;
              }

              $file_pdf->move($ubicacion_pdf, $name_pdf);
              $soporte_pqr = $name_pdf;

            }else{
              $soporte_pqr = null;
            }

            $pasajero = new Pqr;
            $pasajero->fecha_solicitud = $fecha;
            $pasajero->nombre = $nombres;
            $pasajero->direccion = $direccion;
            $pasajero->ciudad = $ciudad;
            $pasajero->telefono = $telefono;
            $pasajero->info = strtoupper($info);
            $pasajero->descripcion = $info2;
            $pasajero->email = $email;
            $pasajero->solicitante = $solicitante;
            $pasajero->tipo = $tiposolicitud;
            $pasajero->fecha = date('Y-m-d');
            $username = Sentry::getUser()->username;
            //$dato = DB::table('pasajeros')->where('correo',$username)->pluck('centrodecosto_id');
            $pasajero->cliente = Input::get('cliente_id');
            $data = DB::table('pasajeros')->where('correo',$username)->pluck('cedula');
            $pasajero->id_user = $data;
            $pasajero->id_servicio = $servicio;
            $pasajero->ruta = $ruta;
            $pasajero->placa = $placa;
            $pasajero->conductor = $conductor;
            $pasajero->tipo_serv = $tiposerv;
            $pasajero->descripcion = $info2;
            $pasajero->fecha_ocurrencia = $fecha_ocurrencia;
            $pasajero->novedad = Input::get('novedad');
            $pasajero->campana = Input::get('campana');
            $pasajero->soporte_pqr = $soporte_pqr;

            $pasajero->nombres_r = $nombres_r;
            $pasajero->apellidos_r = $apellidos_r;
            $pasajero->direccion_r = $direccion_r;
            $pasajero->telefono_r = $telefono_r;
            $pasajero->correo_r = $correo_r;

            if($pasajero->save()){

              //guardar achivos
              $archivos = Input::file('archivos');
              $ubicacion = 'biblioteca_imagenes/reportes/pqr/soportes/';
              $sw = 0;

              $arraynombres = [];
              if (Input::hasFile('archivos')) {
                $sw = 1;
                foreach ($archivos as $key => $value) {

                  $nombre_imagen = $value->getClientOriginalName();

                  if(file_exists($ubicacion.$nombre_imagen)){
                    $nombre_imagen = rand(1,10000).$nombre_imagen;
                  }

                  $arrayFiles = [
                    'archivos' => $nombre_imagen
                  ];

                  $pqr = Pqr::find($pasajero->id);

                  if($pqr->archivos == null){
                    $pqr->archivos = json_encode([$arrayFiles]);
                  }else{
                    $objArray = json_decode($pqr->archivos);
                    array_push($objArray, $arrayFiles);
                    $pqr->archivos = json_encode($objArray);
                  }
                  array_push($arraynombres, $arrayFiles);
                  //Image::make($value->getRealPath())->resize(350, 230)->save($ubicacion.$nombre_imagen);
                  $value->move($ubicacion, $nombre_imagen);
                  $pqr->save();
                }
              }else{
                $pqr = Pqr::find($pasajero->id);
                $archivosf = null;
              }
              //end guardar archivos

              //pdf
              $html = View::make('reportes.pqr.index')->with([
                'nombres' => $nombres,
                'telefono'=> $telefono,
                'tipo_solicitud'=> $tiposolicitud,
                'info' => $pasajero->info, //strtoupper($info),
                'email'=> $email,
                'solicitante'=> $solicitante,
                'ciudad'=> $ciudad,
                'direccion' => $direccion,
                'info2' => $info2,
                'tiposerv' => $tiposerv,
                'conductor' => $conductor,
                'placa' => $placa,
                'ruta' => $ruta,
                'servicio' => $servicio,
                'fecha' => $fecha,
                'fecha_ocurrencia' => $fecha_ocurrencia,
                'soporte_pdf' => $soporte_pqr,
                'nombres_r' => $nombres_r,
                'apellidos_r' => $apellidos_r,
                'telefono_r' => $telefono_r,
                'direccion_r' => $direccion_r,
                'correo_r' => $correo_r,
                'archivos' => $pqr->archivos,
                'soporte' => $pqr->soporte_pqr
              ]);

              $insertedId = $pasajero->id;

              $outputName = 'Respuesta_pqr_'.$insertedId; // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
              $pdfPath = 'biblioteca_imagenes/reportes/pqr/'.$outputName.'.pdf';
              File::put($pdfPath, PDF::load($html, 'A4', 'portrait')->output());
              //pdf

              //$cc = 'aotourdeveloper@gmail.com';
              $cc = ['comercial@aotour.com.co','servicioalcliente@aotour.com.co'];
              //$email = 'sistemas@aotour.com.co';

              $data = [
                'consecutivo' => $insertedId,
                'contacto' => $solicitante
              ];

              Mail::send('reportes.pqr.emails.nueva_pqr', $data, function($message) use ($pdfPath, $email, $insertedId, $cc){
                $message->from('no-reply@aotour.com.co', 'Respuesta a PQR');
                $message->to($email)->subject('PQR No. '.$insertedId);
                $message->cc($cc);
                $message->attach($pdfPath);
              });

                          /*if($cliente==19){

                            Mail::send('emails.pdf_pqr', $data, function($message) use ($correoelectronico){
                              $message->from('aotourdeveloper@gmail.com', 'Reporte de PQR');
                              $message->to($correoelectronico)
                              ->bcc(array('jcalderon@aotour.com.co','lrada@aotour.com.co','gestionintegral@aotour.com.co'))
                              ->subject('PQR');
                            });

                          }else if($cliente==287){

                            Mail::send('emails.pdf_pqr', $data, function($message) use ($correoelectronico){
                              $message->from('aotourdeveloper@gmail.com', 'Reporte de PQR');
                              $message->to($correoelectronico)
                              ->bcc(array('jcalderon@aotour.com.co','jrosero@aotour.com.co','gestionintegral@aotour.com.co'))
                              ->subject('PQR');
                            });

                          }else{

                            Mail::send('emails.pdf_pqr', $data, function($message) use ($correoelectronico, $correosistemas){
                              $message->from('aotourdeveloper@gmail.com', 'Reporte de PQR');
                              $message->to($correosistemas)
                              ->subject('PQR');
                            });

                          }*/


                      //fin envio de correo PQR
                return Response::json([
                    'mensaje'=>true,
                      'respuesta'=>'PQR enviado con Éxito!',
                      'respuesta2'=>'Estudiaremos su PQR y pronto tendrá una resuesta!',
                ]);
            }

      }
    //}

  }//SG

  public function getListadopqr(){

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

      $pqr = DB::table('pqr_table')
      ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'pqr_table.cliente')
      ->select('pqr_table.*', 'centrosdecosto.razonsocial')
      ->whereBetween('pqr_table.fecha',[$fechaInicial,$fechaFinal])
      ->orderBy('pqr_table.id', 'DESC')
      ->get();

      $centrosdecosto = DB::table('centrosdecosto')
      ->whereNull('inactivo')
      ->whereNull('inactivo_total')
      ->orderBy('razonsocial')
      ->get();

      return View::make('reportes.pqr.listado')
      ->with([
        'pqr'=>$pqr,
        'centrosdecosto' => $centrosdecosto,
        'permisos'=>$permisos
      ]);
    }
  }

  public function getPortafolio(){

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

      $pqr = DB::table('pqr_table')
      ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'pqr_table.cliente')
      ->select('pqr_table.*', 'centrosdecosto.razonsocial')
      ->orderBy('pqr_table.id', 'DESC')
      ->get();

      $centrosdecosto = DB::table('traslados')
      //->select('traslados.*', 'tarifas.centrodecosto_id', 'tarifas.cliente_auto', 'tarifas.cliente_van')
      //->leftJoin('tarifas', 'tarifas.trayecto_id', '=', 'traslados.id')
      //->where('tarifas.centrodecosto_id', 97)
      //->whereNull('inactivo_total')
      ->orderBy('nombre')
      ->get();

      return View::make('reportes.portafolio.enviar_portafolio')
      ->with([
        'pqr'=>$pqr,
        'centrosdecosto' => $centrosdecosto,
        'permisos'=>$permisos
      ]);
    }
  }

  public function postEnviarportafolio(){

    $fecha = date('Y-m-d');

    $dataText = 'Se realizó envío de portafolio al correo: '.Input::get('email').' el '.$fecha.' a las '.date('H:i').', por '.Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name.'';

    $array = [
        'gestion' => $dataText,
        'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
        'fecha' => $fecha,
        'soporte' => null
    ];

    $sw = intval(Input::get('portafolios_enviar'));
    $clientes = explode(',', Input::get('traslado'));
    $auto = explode(',', Input::get('valorAuto'));
    $van = explode(',', Input::get('valorVan'));
    $datas = '';

    /*return Response::json([
      'respuesta' => true,
      'sw' => $sw
    ]);*/

    $objArray = [];
    for ($i=0; $i<count($clientes) ; $i++) {
      $arrays = [
        'traslado' => $clientes[$i],
        'valor_auto' => $auto[$i],
        'valor_van' => $van[$i],
      ];
      array_push($objArray, $arrays);
  	}

    //Generación de Portafolio
    //$tarifas = DB::table('portafolio')
    //->where('id',35)
    //->first();

    if(Input::get('sw_tarifas')!=0){
      $html = View::make('reportes.portafolio.test_pdf')->with([
        'tarifas' => $objArray
      ]);
    }

    $consulta = "select * from portafolio order by id desc limit 1";
    $ultimo = DB::select($consulta);
    if($ultimo){
      $insertedId = intval($ultimo[0]->id)+1; //COLOCAR DINÁMICO IMPORTANTE
    }else{
      $insertedId = 1;
    }

    $pdfPathFile = 'biblioteca_imagenes/reportes/portafolio/Propuesta_economica_00'.$insertedId.'.pdf';
    if(Input::get('sw_tarifas')!=0){
      File::put($pdfPathFile, PDF::load($html, 'A4', 'portrait')->output());
      //Generación de Portafolio
    }

    //ENVÍO DE CORREO AL CLIENTE CON EL PORTAFOLIO
    $data = [
      'consecutivo' => $sw
    ];

    //$email = 'sistemas@aotour.com.co';
    //$email = Input::get('email');
    $cco = ['comercial@aotour.com.co','servicioalcliente@aotour.com.co'];
    $email = Input::get('email');
    //$cco = ['aotourdeveloper@gmail.com'];

    $urlEjecutivos = 'biblioteca_imagenes/PORTAFOLIO DE SERVICIOS.pdf';
    $urlRutas = 'biblioteca_imagenes/PORTAFOLIO DE RUTAS.pdf';

    Mail::send('emails.mail_v2', $data, function($message) use ($email, $sw, $cco, $urlEjecutivos, $urlRutas, $pdfPathFile){
      $message->from('no-reply@aotour.com.co', '¡VIVE LA EXPERIENCIA AOTOUR!');
      $message->to($email)->subject('Te presentamos nuestro portafolio de servicios');
      $message->bcc($cco);
      if($sw==1){ //SÓLO EJECUTIVOS
        $message->attach($urlEjecutivos);
      }else if($sw==2){ //SÓLO RUTAS
        $message->attach($urlRutas);
      }else if($sw==3){ //EJECUTIVOS Y RUTAS
        $message->attach($urlEjecutivos);
        $message->attach($urlRutas);
      }else{
        //$pdfPaths = 'biblioteca_imagenes/archivos_cotizaciones/'.$file->archivos;
        //$message->attach($pdfPaths);
      }
      if(Input::get('sw_tarifas')!=0){
        $message->attach($pdfPathFile);
      }
    });
    //ENVÍO DE CORREO AL CLIENTE CON EL PORTAFOLIO

    $swE = null;
    $swR = null;

    if($sw==1){ //SÓLO EJECUTIVOS
      $swE = 1;
      $swR = null;
    }else if($sw==2){ //SÓLO RUTAS
      $swE = null;
      $swR = 1;
    }else if($sw==3){ //EJECUTIVOS Y RUTAS
      $swE = 1;
      $swR = 1;
    }

    $portafolio = new Portafolio;
    $portafolio->creado_por = Sentry::getUser()->id;
    $portafolio->fecha = $fecha;
    $portafolio->nombre_cliente = Input::get('nombre_empresa');
    $portafolio->correo = Input::get('email');
    $portafolio->telefono = Input::get('telefono');
    $portafolio->direccion = Input::get('direccion');
    $portafolio->solicitante = Input::get('solicitante');
    $portafolio->ciudad = Input::get('ciudad');
    $portafolio->cantidad_gestiones = 1;
    $portafolio->ejecutivos = $swE;
    $portafolio->rutas = $swR;
    $portafolio->gestiones = json_encode([$array]);
    $portafolio->tarifas = json_encode($objArray);
    if(Input::get('sw_tarifas')!=0){
      $portafolio->pdf_tarifas = $pdfPathFile;
    }
    $portafolio->save();

    return Response::json([
      'respuesta' => true
    ]);

  }

  public function postGuardargestion() {

    $id = Input::get('id');
    $descripcion = Input::get('descripcion');

    $neg = Portafolio::find(intval($id));

    $fecha = date('Y-m-d');

    $dataText = $descripcion;

    //files
    $archivos = Input::file('archivos');
    $ubicacion = 'biblioteca_imagenes/reportes/soporte_gestiones/';
    $arraynombres = [];

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

    }else{
      $archivosf = null;
    }
    //files

    $array = [
        'gestion' => $dataText,
        'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
        'fecha' => $fecha,
        'soporte' => $archivosf
    ];

    $suma = intval($neg->cantidad_gestiones)+1;

    $objArray = json_decode($neg->gestiones);
    array_push($objArray, $array);
    $neg->gestiones = json_encode($objArray);
    $neg->cantidad_gestiones = $suma;
    $neg->save();

    return Response::json([
      'respuesta' => true,
      'id' => $id,
      'neg' => json_decode($neg->gestiones)
    ]);

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
        'fecha' => $fecha,
        'soporte' => null
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

  public function postPortaf() {

    $portafolio = Portafolio::find(Input::get('id'));

    return Response::json([
      'respuesta' => true,
      'portafolio' => $portafolio
    ]);

  }

  public function postNoexitosa() {

    $id = Input::get('id');

    $consulta = DB::table('portafolio')
    ->where('id',$id)
    ->update([
      'estado' => 2
    ]);

    $neg = Portafolio::find(intval($id));

    $fecha = date('Y-m-d');

    $dataText = 'SE CANCELÓ LA NEGOCIACIÓN. ESTA FUE MARCADA COMO NO EXITOSA.';

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

    return Response::json([
      'respuesta' => true
    ]);

  }

  public function postReactivar() {

    $id = Input::get('id');

    $consulta = DB::table('portafolio')
    ->where('id',$id)
    ->update([
      'estado' => null
    ]);

    $neg = Portafolio::find(intval($id));

    $fecha = date('Y-m-d');

    $dataText = 'SE REACTIVÓ LA NEGOCIACIÓN.';

    $array = [
        'gestion' => $dataText,
        'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
        'fecha' => $fecha,
        'soporte' => null
    ];

    $suma = intval($neg->cantidad_gestiones)+1;

    $objArray = json_decode($neg->gestiones);
    array_push($objArray, $array);
    $neg->gestiones = json_encode($objArray);
    $neg->cantidad_gestiones = $suma;
    $neg->save();

    return Response::json([
      'respuesta' => true
    ]);

  }

  public function postNuevocentro(){

		if (!Sentry::check()){

				return Response::json([
					'respuesta'=>'relogin'
				]);

		}else{

			if(Request::ajax()){

				$credito = intval(Input::get('credito'));
				$plazo = null;
				$tipo_cliente = Input::get('tipo_cliente');
				$nit = Input::get('nit');
				$digito = Input::get('digitoverificacion');
				$razonsocial = Input::get('razonsocial');
				$tipoempresa = Input::get('tipoempresa');
				$direccion = Input::get('direccion');
				$ciudad = Input::get('ciudad');
				$departamento = Input::get('departamento');
				$email = Input::get('email');
				$telefono = Input::get('telefono');
				$credito = Input::get('credito');
				$localidad = Input::get('localidad');
				$tipo_cliente2 = Input::get('tipo_cliente2');

				$recargo_nocturno = Input::get('recargo_nocturno');
				$desde = Input::get('desde');
				$hasta = Input::get('hasta');

				$centrodecosto = new Centrodecosto;
				//$centrodecosto->rut = $rutpdf;
				$centrodecosto->tipo_cliente = $tipo_cliente;
				$centrodecosto->nit = $nit;
				$centrodecosto->codigoverificacion = $digito;
				$centrodecosto->razonsocial = $razonsocial;
				$centrodecosto->tipoempresa = $tipoempresa;
				$centrodecosto->direccion = $direccion;
				$centrodecosto->ciudad = $ciudad;
        $dep = DB::table('ciudad')->where('ciudad',$ciudad)->pluck('departamento_id');
        $dep = DB::table('departamento')->where('id',$dep)->pluck('departamento');
				$centrodecosto->departamento = $dep;
				$centrodecosto->email = $email;
				$centrodecosto->telefono = $telefono;
				//$centrodecosto->asesor_comercial = Input::get('asesorcomercial');
				$centrodecosto->credito = $credito;
				$centrodecosto->plazo_pago = $plazo;
				$centrodecosto->localidad = $localidad;

					if($recargo_nocturno==1) {
						$centrodecosto->recargo_nocturno = $recargo_nocturno;
						$centrodecosto->desde = $desde;
						$centrodecosto->hasta = $hasta;
					}

					if(Input::get('tipo_tarifa')==1){
						$type = 1;
					}else{
						$type = null;
					}
					$centrodecosto->tarifa_aotour = $type;

					if(Input::get('tipo_tarifa_proveedor')==1){
						$type = 1;
					}else{
						$type = null;
					}
					$centrodecosto->tarifa_aotour_proveedor = $type;

					/*$centrodecosto->nombres_contacto = strtoupper($first_name_siigo);
					$centrodecosto->apellidos_contacto = strtoupper($last_name_siigo);
					$centrodecosto->correo_contacto = strtoupper($email_siigo);
					$centrodecosto->id_ciudad = $id_ciudad;
					$centrodecosto->state_code = $state_code;
					$centrodecosto->country_code = $country_code;
					$centrodecosto->contribuyente = $contribuyente;*/

					if($centrodecosto->save()){

            $sub = new Subcentro;
            $sub->nombresubcentro = $razonsocial;
            $sub->centrosdecosto_id = $centrodecosto->id;
            $sub->save();

						if(Input::get('tipo_tarifa')==1 or Input::get('tipo_tarifa_proveedor')==1){
							$traslados = DB::table('traslados')->get();

							foreach ($traslados as $traslado) {

								$search = DB::table('tarifas')
								->select('id', 'cliente_auto', 'cliente_van', 'proveedor_auto', 'proveedor_van', 'trayecto_id', 'centrodecosto_id')
								->where('trayecto_id',$traslado->id)
								->where('centrodecosto_id',97)
								->first();

								if($search!=null) {

									$nuevaTarifa = New Tarifa;
									if(Input::get('tipo_tarifa')==1){
										$nuevaTarifa->cliente_auto = $search->cliente_auto;
										$nuevaTarifa->cliente_van = $search->cliente_van;
									}
									if(Input::get('tipo_tarifa_proveedor')==1){
										$nuevaTarifa->proveedor_auto = $search->proveedor_auto;
										$nuevaTarifa->proveedor_van = $search->proveedor_van;
									}
									$nuevaTarifa->trayecto_id = $traslado->id;
									$nuevaTarifa->centrodecosto_id = $centrodecosto->id;
									$nuevaTarifa->save();

								}

							}
						}

            //Envío de correo de creación de cliente en sistema

            //Envío de correo de creación de cliente en sistema

						return Response::json([
							'respuesta'=>true,
							'mensaje'=>'Registro guardado correctamente!'
						]);
					}

			}
		}
	}

  public function getPortafoliosenviados(){

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

      $portafolio = DB::table('portafolio')
      ->leftJoin('users', 'users.id', '=', 'portafolio.creado_por')
      ->select('portafolio.*', 'users.first_name', 'users.last_name')
      ->orderBy('portafolio.id', 'DESC')
      ->get();

      $centrosdecosto = DB::table('centrosdecosto')
      ->whereNull('inactivo')
      ->whereNull('inactivo_total')
      ->orderBy('razonsocial')
      ->get();

      $centrosdecosto = DB::table('traslados')
      //->select('traslados.*', 'tarifas.centrodecosto_id', 'tarifas.cliente_auto', 'tarifas.cliente_van')
      //->leftJoin('tarifas', 'tarifas.trayecto_id', '=', 'traslados.id')
      //->where('tarifas.centrodecosto_id', 97)
      //->whereNull('inactivo_total')
      ->orderBy('nombre')
      ->get();

      $usuarios = DB::table('users')
      ->where('id_rol',12)
      ->whereNotNull('id_empleado')
      ->get();

      return View::make('reportes.portafolio.listado_portafolio')
      ->with([
        'portafolio'=>$portafolio,
        'centrosdecosto' => $centrosdecosto,
        'usuarios' => $usuarios,
        'permisos'=>$permisos
      ]);
    }
  }

  public function postEnviartarifasgestion() {

    $id = Input::get('id');
    $clientes = Input::get('traslado');
    $auto = Input::get('valorAuto');
    $van = Input::get('valorVan');

    $ultimo = Portafolio::find($id);

    $fecha = date('Y-m-d');

    $dataText = 'Se realizó envío de propuesta ecomómica al correo: '.$ultimo->correo.' el '.$fecha.' a las '.date('H:i').', por '.Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name.'';

    $objArray = [];
    for ($i=0; $i<count($clientes) ; $i++) {
      $arrays = [
        'traslado' => $clientes[$i],
        'valor_auto' => $auto[$i],
        'valor_van' => $van[$i],
      ];
      array_push($objArray, $arrays);
  	}

    $html = View::make('reportes.portafolio.test_pdf')->with([
      'tarifas' => $objArray
    ]);

    $insertedId = intval($ultimo->id);

    $pdfPathFile = 'biblioteca_imagenes/reportes/portafolio/Propuesta_economica_00'.$insertedId.'.pdf';
    File::put($pdfPathFile, PDF::load($html, 'A4', 'portrait')->output());
    //Generación de Portafolio

    //ENVÍO DE CORREO AL CLIENTE CON EL PORTAFOLIO
    $data = [
      'consecutivo' => $id
    ];

    //$email = 'sistemas@aotour.com.co';
    $email = $ultimo->correo; //Input::get('email');
    $cco = ['comercial@aotour.com.co','servicioalcliente@aotour.com.co'];
    //$cco = 'aotourdeveloper@gmail.com';

    $urlEjecutivos = 'biblioteca_imagenes/PORTAFOLIO DE SERVICIOS.pdf';
    $urlRutas = 'biblioteca_imagenes/PORTAFOLIO DE RUTAS.pdf';

    Mail::send('reportes.emails.enviar_portafolio', $data, function($message) use ($email, $cco, $pdfPathFile){
      $message->from('no-reply@aotour.com.co', 'PROPUESTA ECONÓMICA AOTOUR');
      $message->to($email)->subject('Te presentamos nuestras tarifas');
      $message->bcc($cco);
      $message->attach($pdfPathFile);
    });

    $array = [
        'gestion' => $dataText,
        'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
        'fecha' => $fecha,
        'soporte' => null//'Propuesta_economica_00'.$insertedId.'.pdf'
    ];

    $ultimo->cantidad_gestiones = intval($ultimo->cantidad_gestiones)+1;
    $ultimo->pdf_tarifas = $pdfPathFile;

    $objArray = json_decode($ultimo->gestiones);
    array_push($objArray, $array);
    $ultimo->gestiones = json_encode($objArray);

    $ultimo->save();

    return Response::json([
      'respuesta' => true
    ]);

  }

  public function postSearch() {

    if (!Sentry::check()){

      return Response::json([
        'respuesta' => 'sesion_caducada'
      ]);

    }else{

      $fecha_inicial = Input::get('fecha_inicial');
      $fecha_final = Input::get('fecha_final');
      $ciudad = Input::get('ciudad'); //ok
      $estado = Input::get('estado'); //ok
      $usuario = Input::get('usuario');
      $cantidad = Input::get('cantidad'); //ok

      $query = "SELECT portafolio.*, users.first_name, users.last_name from portafolio left join users on users.id = portafolio.creado_por where portafolio.fecha between '".$fecha_inicial."' and '".$fecha_final."'";

      if($cantidad!='0'){
        if($cantidad=='6'){
          $query .= " and portafolio.cantidad_gestiones >= ".$cantidad."";
        }else{
          $query .= " and portafolio.cantidad_gestiones = ".$cantidad."";
        }
      }

      if($estado!='0'){
        if($estado=='3'){
          $query .= " and portafolio.estado is null";
        }else{
          $query .= " and portafolio.estado = ".$estado."";
        }
      }

      if($ciudad!='Seleccionar Ciudad'){
        $query .= " and ciudad = '".$ciudad."'";
      }

      if($usuario!='0'){
        $query .= " and portafolio.creado_por = '".$usuario."'";
      }

      $query .= " order by portafolio.id desc";

      $pt = DB::select($query);

      if(count($pt)){

        return Response::json([
          'respuesta' => true,
          'reportes' => $pt,
          'query' => $query,
          'fecha_inicial' => $fecha_inicial,
          'fecha_final' => $fecha_final,
          'ciudad' => $ciudad,
          'estado' => $estado,
          'usuario' => $usuario,
          'cantidad' => $cantidad
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'query' => $query
        ]);

      }

      /*if(count($pqr)) {

        return Response::json([
          'respuesta' => true,
          'reportes' => $pqr,
          'query' => $query,
          'novedad' => $novedad
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }*/

    }

  }

  public function postConsultargestion() {

    $id = Input::get('id');

    $portafolio = DB::table('portafolio')
    ->where('id',$id)
    ->first();

    return Response::json([
      'respuesta' => true,
      'portafolio' => $portafolio
    ]);

  }

  public function getListapqr(){

    if (Sentry::check()) {
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
    }else{
      $id_rol = null;
      $permisos = null;
      $permisos = null;
    }

    if (isset($permisos->portalusuarios->admin->ver)){
      $ver = $permisos->portalusuarios->admin->ver;
    }else{
      $ver = null;
    }

    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on' ) {
      return View::make('admin.permisos');
    }else {

      $pqr = DB::table('pqr_table')
      ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'pqr_table.cliente')
      ->select('pqr_table.*', 'centrosdecosto.razonsocial')
      ->whereIn('pqr_table.cliente',[19,287])
      ->orderBy('pqr_table.id', 'DESC')
      ->get();

      return View::make('portalusuarios.admin.listado.listado_pqr')
      ->with([
        'pqr'=>$pqr,
	      'permisos'=>$permisos
      ]);
    }
  }

  public function postFiltrar() {

    if (!Sentry::check()){

      return Response::json([
        'respuesta' => 'sesion_caducada'
      ]);

    }else{

      $novedad = Input::get('novedad');
      $estado = Input::get('estado');
      $cliente = Input::get('cliente');
      $usuario = Input::get('usuario');
      $fecha_inicial = Input::get('fecha_inicial');
      $fecha_final = Input::get('fecha_final');

      $query = "SELECT pqr_table.*, centrosdecosto.razonsocial from pqr_table left join centrosdecosto on centrosdecosto.id = pqr_table.cliente where pqr_table.fecha between '".$fecha_inicial."' and '".$fecha_final."'";

      if($estado!='0'){
        if($estado=='3'){
          $query .= " and pqr_table.estado is null";
        }else{
          $query .= " and pqr_table.estado = ".$estado."";
        }
      }

      if($novedad!='0'){
        $query .= " and pqr_table.novedad = '".$novedad."'";
      }

      if($cliente!='0'){
        $query .= " and pqr_table.cliente = '".$cliente."'";
      }

      $query .= " order by pqr_table.id desc";

      $pqr = DB::select($query);

      if(count($pqr)) {

        return Response::json([
          'respuesta' => true,
          'reportes' => $pqr,
          'query' => $query,
          'novedad' => $novedad
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

  }

  public function postVerpqr() {

    $id = Input::get('id');

    $consulta = DB::table('pqr_table')
    ->where('id',$id)
    ->update([
      'estado' => 1,
      'fecha_visto' => date('Y-m-d'),
      'hora_visto' => date('H:i')
    ]);

    return Response::json([
      'respuesta' => true
    ]);

  }

  public function postCerrarpqr() {

    $id = Input::get('id');

    if (Input::hasFile('soporte_cierre')){

      $file_pdf = Input::file('soporte_cierre');
      $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

      $ubicacion_pdf = 'biblioteca_imagenes/reportes/pqr/cierre/';

      if(file_exists($ubicacion_pdf.$name_pdf)){
        $name_pdf = rand(1,10000).$name_pdf;
      }

      $file_pdf->move($ubicacion_pdf, $name_pdf);
      $soporte_cierre = $name_pdf;

    }else{
      $soporte_cierre = null;
    }

    $pqr = DB::table('pqr_table')
    ->where('id',$id)
    ->update([
      'estado' => 2,
      'fecha_cierre' => date('Y-m-d'),
      'soporte_cierre' => $soporte_cierre
    ]);

    if($pqr){

      $data = [
        'consecutivo' => $id,
        'contacto' => DB::table('pqr_table')->where('id',$id)->pluck('solicitante')
      ];

      //$email = 'sistemas@aotour.com.co';
      $email = DB::table('pqr_table')->where('id',$id)->pluck('email');
      $cco = ['comercial@aotour.com.co','servicioalcliente@aotour.com.co'];

      Mail::send('reportes.emails.cierre_pqr', $data, function($message) use ($email, $id, $cco, $soporte_cierre){
        $message->from('no-reply@aotour.com.co', 'Gestión de PQR');
        $message->to($email)->subject('Cierre a PQR N° '.$id);
        $message->bcc($cco);
        $message->attach('biblioteca_imagenes/reportes/pqr/cierre/'.$soporte_cierre);
      });

      return Response::json([
        'respuesta' => true
      ]);

    }else{

      return Response::json([
        'respuesta' => false
      ]);

    }

  }

  public function postFiltrarpqr() {

    if (!Sentry::check()){

      return Response::json([
        'respuesta' => 'sesion_caducada'
      ]);

    }else{

      $novedad = Input::get('novedad');
      $ciudad = Input::get('ciudad');

      $query = "SELECT pqr_table.*, centrosdecosto.razonsocial from pqr_table left join centrosdecosto on centrosdecosto.id = pqr_table.cliente where pqr_table.cliente in(19,287)";

      if($novedad!='0'){
        $query .= " and pqr_table.novedad = '".$novedad."'";
        if($ciudad!=0){
          $query .= " and pqr_table.ciudad = '".$ciudad."'";
        }
      }else{
        if($ciudad!='0'){
          $query .= " and pqr_table.ciudad = '".$ciudad."'";
        }
      }

      $query .= " order by pqr_table.id desc";

      $pqr = DB::select($query);

      if(count($pqr)) {

        return Response::json([
          'respuesta' => true,
          'reportes' => $pqr,
          'query' => $query,
          'novedad' => $novedad
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

  }

  public function postSendemail() {

    //$email = Input::get('email');

    $insertedId = 123;

    //pdf
    $html = View::make('reportes.pqr.index')->with([
      'consecutivo' => $insertedId,
      'nombre_completo' => 'samuel',
      'asunto' => 'asunto',
      'fecha' => 'fecha',
      'detalles' => 'detalles',
      'total' => Input::get('total_general'),
      'telefono' => '300',
      'email' => 'sistemas@aotour.com.co',
      'cantidad' => 20
    ]);

    $outputName = 'Respuesta_pqr_'.$insertedId; // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
    $pdfPath = 'biblioteca_imagenes/reportes/pqr/'.$outputName.'.pdf';
    File::put($pdfPath, PDF::load($html, 'A4', 'portrait')->output());
    //pdf

    //$cc = ['facturacion@aotour.com.co','b.carrillo@aotour.com.co','comercial@aotour.com.co'];
    $cc = 'aotourdeveloper@gmail.com';

    $email = 'sistemas@aotour.com.co';

    $data = [
      'consecutivo' => $insertedId
    ];

    Mail::send('reportes.pqr.emails.nueva_pqr', $data, function($message) use ($pdfPath, $email, $insertedId, $cc){
      $message->from('no-reply@aotour.com.co', 'Respuesta a PQR');
      $message->to($email)->subject('PQR No. '.$insertedId);
      $message->cc($cc);
      $message->attach($pdfPath);
    });

  }

  //FIN VISTA PARA REPORTES QR

  public function getServiciossinfacturar(){

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

      $fechaInicial = date('Y-m-d');
      $fechaFinal = date('Y-m-d');

      $consulta = "SELECT servicios.id, centrosdecosto.razonsocial, servicios.fecha_servicio, servicios.hora_servicio, servicios.recoger_en, servicios.dejar_en, servicios.detalle_recorrido, servicios.solicitado_por, servicios.fecha_solicitud, servicios.fecha_orden, servicios.pasajeros, servicios.ciudad, servicios.pendiente_autori_eliminacion, facturacion.facturado, vehiculos.placa, vehiculos.clase, vehiculos.marca, vehiculos.modelo, proveedores.razonsocial as razonproveedor, conductores.nombre_completo, subcentrosdecosto.nombresubcentro, users.first_name, users.last_name  FROM servicios LEFT JOIN facturacion ON facturacion.servicio_id = servicios.id LEFT JOIN centrosdecosto ON centrosdecosto.id = servicios.centrodecosto_id LEFT JOIN proveedores on proveedores.id = servicios.proveedor_id LEFT JOIN conductores on conductores.id = servicios.conductor_id LEFT JOIN vehiculos ON vehiculos.id = servicios.vehiculo_id LEFT JOIN subcentrosdecosto ON subcentrosdecosto.id = servicios.subcentrodecosto_id LEFT JOIN users ON users.id = servicios.creado_por WHERE fecha_servicio BETWEEN '202210116' AND '20221115' AND servicios.pendiente_autori_eliminacion IS NULL AND facturacion.facturado IS NULL";

      $servicios = DB::select($consulta);

        return View::make('reportes.sin_facturar')
        ->with([
          'servicios' => $servicios,
          'o' => 1
        ]);

    }
  }

  //VISTA PARA REPORTES QR
  public function getCrearlinks(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      return View::make('reportes.crear', [

        //'consulta' => $consulta,
        'permisos' => $permisos,

      ]);
    }

  }

  public function postGuardarlink(){

    if(Request::ajax()){

      $fecha = Input::get('fecha');
      $hasta = Input::get('hasta');
      $ciudad = Input::get('ciudad');
      $correo = Input::get('correo');

      $link = new Link();
      $link->fecha = $fecha;
      $link->hora = $hasta;
      $link->ciudad = $ciudad;
      $link->correos = $correo;

      if ($link->save()) {

        $data = [
          'id' => $link->id
        ];

        Mail::send('reportes.emails.link', $data, function($message) use ($correo){
          $message->from('no-reply@aotour.com.co', 'AUTONET');
          $message->to($correo)->subject('Link Temporal');
          $message->cc('aotourdeveloper@gmail.com');
          //$message->attach($pdfPath);
        });

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

  //VISTA PARA REPORTES QR
  public function getTemporal($id){

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

      $fecha = date('Y-m-d');
      $hora = date('H:i');

      $consulta = DB::table('temporal')
      ->where('id',$id)
      ->where('fecha', '>=', $fecha)
      ->where('hora', '>=', $hora)
      ->first();

      $ciudad = $consulta->ciudad;

      if($consulta){

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
            ->where('servicios.localidad',22)
            //->where('centrosdecosto.localidad','BARRANQUILLA')
            ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
            ->whereNull('servicios.pendiente_autori_eliminacion')
            ->whereNull('servicios.afiliado_externo')
            ->where('fecha_servicio',date('Y-m-d'));

        $servicios = $query->orderBy('hora_servicio')->get();

        $proveedores = Proveedor::Afiliadosinternos()
        ->orderBy('razonsocial')
        ->where('localidad','barranquilla')
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

        return View::make('reportes.temporal')
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
          'id' => $id,
          'o' => 1
        ]);

      }else{

        return View::make('reportes.temporal_no_disponible', [

          'consulta' => $consulta,
          'permisos' =>$permisos,
          'id' => $id,
          'o' => 1

        ]);

      }

    }
  }

  public function postValidarhora(){

    if(Request::ajax()){

      $id = Input::get('id');
      $id = intval($id);
      $fecha = date('Y-m-d');
      $hora = date('H:i');

      $consulta = DB::table('temporal')
      ->where('id',$id)
      ->where('fecha', '>=', $fecha)
      ->where('hora', '>=', $hora)
      ->first();

      if ($consulta!=null) {

        return Response::json([
          'respuesta'=>true,
          'consulta'=>$consulta,
          'fecha' => $fecha,
          'hora' => $hora,
          'id' => $id,
        ]);

      }else{

        return Response::json([
          'respuesta'=>false,
          'consulta'=>$consulta,
          'fecha' => $fecha,
          'hora' => $hora,
          'id' => $id,
        ]);
      }
    }
  }

  public function postBuscarordenes(){

      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          if (Request::ajax()){

              $fecha_inicial = Input::get('fecha_inicial');
              $fecha_final = Input::get('fecha_final');
              $servicio = intval(Input::get('servicios'));
              $proveedores = Input::get('proveedores');
              $conductores = Input::get('conductores');
              $option = Input::get('option');

              if ($conductores===null) {
                  $conductores = 0;
              }

              $centrodecosto = Input::get('centrodecosto');

              $subcentro = Input::get('subcentrodecosto');

              if ($subcentro===null) {
                  $subcentro=0;
              }

              $ciudades = Input::get('ciudades');
              $usuarios = Input::get('usuario');
              $codigo = Input::get('codigo');
              $tipo_usuario = Sentry::getUser()->id_tipo_usuario;

              $ids = Input::get('id_link');
              $consult = DB::table('temporal')->where('id',$ids)->first();

              //if($consult->ciudad!='BARRANQUILLA'){ //Bogotá
                //$localidad = "is not null";
              //}else{ //Barranquilla
                $localidad = "is null";
              //}

              $consulta = "select servicios.id, servicios.fecha_orden, servicios.fecha_servicio, servicios.solicitado_por, servicios.programado_app, ".
                  "servicios.resaltar, servicios.pago_directo, servicios.fecha_solicitud, servicios.ciudad, servicios.recoger_en, servicios.ruta, ".
                  "servicios.dejar_en, servicios.detalle_recorrido, servicios.pasajeros, servicios.pasajeros_ruta, servicios.finalizado, servicios.pendiente_autori_eliminacion, ".
                  "servicios.hora_servicio, servicios.origen, servicios.destino, servicios.fecha_pago_directo, servicios.rechazar_eliminacion, ".
                  "servicios.estado_servicio_app, servicios.recorrido_gps, servicios.calificacion_app_conductor_calidad, ".
                  "servicios.calificacion_app_conductor_actitud, servicios.calificacion_app_cliente_calidad, servicios.calificacion_app_cliente_actitud, ".
                  "servicios.aerolinea, servicios.vuelo, servicios.hora_salida, servicios.hora_llegada, servicios.aceptado_app, ".
                  "servicios.cancelado, pago_proveedores.consecutivo as pconsecutivo, pagos.autorizado, ".
                  "servicios_edicion_pivote.id as servicios_id_pivote, servicios.control_facturacion, ordenes_facturacion.id as idordenfactura, ".
                  "reportes_pivote.id as reportes_id_pivote, pago_proveedores.id as pproveedorid, ".
                  "reconfirmacion.ejecutado, reconfirmacion.numero_reconfirmaciones, ".
                  "facturacion.revisado, facturacion.liquidado, facturacion.facturado, facturacion.factura_id, facturacion.liquidacion_id, facturacion.liquidado_autorizado, ".
                  "novedades_reconfirmacion.seleccion_opcion, ".
                  "centrosdecosto.razonsocial, centrosdecosto.tipo_cliente, encuesta.pregunta_1, encuesta.pregunta_2, encuesta.pregunta_3, ".
                  "encuesta.pregunta_4, encuesta.pregunta_5, encuesta.pregunta_6, encuesta.pregunta_7, encuesta.pregunta_8, encuesta.pregunta_9, encuesta.pregunta_10, ".
                  "ordenes_facturacion.numero_factura, ordenes_facturacion.consecutivo, ordenes_facturacion.nomostrar, ".
                  "subcentrosdecosto.nombresubcentro, ".
                  "users.first_name, users.last_name, ".
                  "rutas.nombre_ruta, rutas.codigo_ruta, ".
                  "proveedores.razonsocial as razonproveedor, proveedores.tipo_afiliado, ".
                  "conductores.nombre_completo, conductores.celular, conductores.telefono, conductores.usuario_id, ".
                  "vehiculos.placa, vehiculos.clase,".
                  "vehiculos.marca, vehiculos.modelo, ".
                  "servicios_autorizados_pdf.documento_pdf1, servicios_autorizados_pdf.documento_pdf2, ".

                  " (select id from novedades_app where servicio_id = servicios.id limit 1) as novedades_app ".

                  "from servicios ".
                  "left join servicios_autorizados_pdf on servicios.id = servicios_autorizados_pdf.servicio_id ".
                  "left join reconfirmacion on servicios.id = reconfirmacion.id_servicio ".
                  "left join encuesta on servicios.id = encuesta.id_servicio ".
                  "left join servicios_edicion_pivote on servicios.id = servicios_edicion_pivote.servicios_id ".
                  "left join reportes_pivote on servicios.id = reportes_pivote.servicio_id ".
                  "left join novedades_reconfirmacion on servicios.id = novedades_reconfirmacion.id_reconfirmacion ".
                  "left join facturacion on servicios.id = facturacion.servicio_id ".
                  "left join ordenes_facturacion on facturacion.factura_id = ordenes_facturacion.id ".
                  "left join pago_proveedores on facturacion.pago_proveedor_id = pago_proveedores.id ".
                  "left join pagos on pago_proveedores.id_pago = pagos.id ".
                  "left join rutas on servicios.ruta_id = rutas.id ".
                  "left join proveedores on servicios.proveedor_id = proveedores.id ".
                  "left join conductores on servicios.conductor_id = conductores.id ".
                  "left join vehiculos on servicios.vehiculo_id = vehiculos.id ".
                  "left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id ".
                  "left join subcentrosdecosto on servicios.subcentrodecosto_id = subcentrosdecosto.id ".
                  "left join users on servicios.creado_por = users.id ".
                  "where servicios.fecha_servicio between '".$fecha_inicial."' AND '".$fecha_final."' and servicios.localidad ".$localidad;

                  //MODIFICICACIÓN PARA QUE OPERACIONES NO VISUALICE LOS SERVICIOS MONTADOS POR FACTURACION
                    //SE AGREGÓ EL CAMPO CONTROL FACTURACION

                  if(!($id_rol==2 or $id_rol==1 or $id_rol==5 or $id_rol==52 or $id_rol==8)){
                        //$consulta .=" and facturacion.revisado is null";
                    }

                    if(!($id_rol==1 or $id_rol==2 or $id_rol==8)){
                        $consulta .=" and servicios.control_facturacion is null";
                    }
                  if($option==3){
                      $consulta .= " and servicios.afiliado_externo is null ";
                  }

                  if($option==2){
                      $consulta .= " and servicios.afiliado_externo = 1 ";
                  }

                  if($option==1){
                      //$consulta .= " and servicios.ruta is null and servicios.afiliado_externo is null ";
                  }

              if($servicio!=0){

                  if($servicio===14){
                    $consulta .= " and (((servicios.calificacion_app_cliente_calidad+servicios.calificacion_app_conductor_calidad)/2) < 3)";
                  }

                  if($servicio===15){
                    $consulta .= " and (((servicios.calificacion_app_cliente_calidad+servicios.calificacion_app_conductor_calidad)/2) >= 3) and (((servicios.calificacion_app_cliente_calidad+servicios.calificacion_app_conductor_calidad)/2) < 4)";
                  }

                  if($servicio===16){
                    $consulta .= " and (((servicios.calificacion_app_cliente_calidad+servicios.calificacion_app_conductor_calidad)/2) >= 4)";
                  }

                  if ($servicio===13) {
                      $consulta .= " and servicios.calificacion_app_cliente_calidad is not null ";
                  }

                  if ($servicio===12) {
                      $consulta .= " and (servicios.calificacion_app_conductor_calidad is null or servicios.calificacion_app_cliente_calidad is null) ";
                  }

                  if ($servicio===11) {
                      $consulta .= " and (servicios.calificacion_app_conductor_calidad is not null or servicios.calificacion_app_cliente_calidad is not null) ";
                  }

                  if ($servicio===10) {
                      $consulta .= " and servicios.programado_app is not null ";
                  }

                  //FILTRO PARA NO SHOW
                  if ($servicio===9){
                      $consulta .=" and (novedades_reconfirmacion.seleccion_opcion = 2 or  novedades_reconfirmacion.seleccion_opcion = 5)";
                  }

                  if ($servicio===8) {
                      $consulta .= " and servicios.finalizado is null ";
                  }

                  if ($servicio===7) {
                      $consulta .= " and (facturacion.liquidacion_id is not null and facturacion.liquidado_autorizado is null and facturacion.facturado is null ) ";
                  }

                  if ($servicio===6) {
                      $consulta .= " and encuesta.pregunta_1 is not null ";
                  }

                  if ($servicio===5) {
                      $consulta .=" and (servicios.pago_directo = 1 or servicios.pago_directo =2)";
                  }

                  if($servicio===4){
                      $consulta .=" and (facturacion.facturado IS NULL or facturacion.facturado = 0) ";
                  }

                  if($servicio===3){
                      $consulta .=" and (facturacion.liquidado IS NULL or facturacion.liquidado = 0) ";
                  }

                  if($servicio===2){
                      $consulta .=" and (facturacion.revisado IS NULL or facturacion.revisado = 0) ";
                  }

                  //FILTRO PARA SERVICIOS CANCELADOS
                  if ($servicio===1){
                      $consulta .=" and servicios.cancelado = 1 ";
                  }

              }

              if($proveedores!='0'){
                  $consulta .= " and proveedores.id = ".$proveedores." ";
              }

              if($conductores!='0'){
                  $consulta .= " and conductores.id = ".$conductores." ";
              }

              if($centrodecosto!='0'){
                  $consulta .= " and centrosdecosto.id = '".$centrodecosto."' ";
              }

              if($subcentro!='0'){
                  $consulta .= " and subcentrosdecosto.id = '".$subcentro."' ";
              }

              if($ciudades!='CIUDADES'){
                  $consulta .= " and servicios.ciudad = '".$ciudades."' ";
              }

              if($usuarios!='0'){
                  $consulta .= " and users.id = '".$usuarios."' ";
              }

              if($codigo!=''){
                  $consulta .= " and servicios.id = '".$codigo."' ";
              }

              $servicios = DB::select(DB::raw($consulta." and servicios.pendiente_autori_eliminacion is null ORDER BY fecha_servicio ASC, hora_servicio ASC"));

              if ($servicios!=null) {

                  return Response::json([
                      'mensaje'=>true,
                      'servicios'=>$servicios,
                      'tipo_usuario'=>$tipo_usuario,
                      'id_rol'=>$id_rol,
                      'consulta'=>$consulta,
                      'id_usuario'=>Sentry::getUser()->id,
                      'permisos'=>$permisos
                  ]);

              }else{

                  return Response::json([
                      'mensaje'=>false,
                      'consulta'=>$consulta,
                      'subcentro'=>$subcentro
                  ]);
              }
          }
      }
  }

  //FIN VISTA DE SERVICIOS TEMPORALES

  //VISTA DE USUARIOS QR BOG
  public function getProgramacionbogota(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->bogota->transportes->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $query = DB::table('qr_rutas')
      ->orderBy('qr_rutas.servicio_id','asc')
      ->leftJoin('servicios', 'servicios.id', '=', 'qr_rutas.servicio_id')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->select('qr_rutas.*', 'servicios.ruta', 'servicios.conductor_id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.detalle_recorrido', 'conductores.nombre_completo', 'vehiculos.placa')
      ->where('servicios.fecha_servicio',date('Y-m-d'))
      ->where('servicios.centrodecosto_id',287)
      ->whereNull('pendiente_autori_eliminacion')
      ->get();

      $o = 1;

      return View::make('reportes.bog.reportes', [

        'documentos' => $query,
        'permisos' =>$permisos,
        'o' => $o

      ]);
    }

  }
  //FIN VISTA DE USUARIOS QR BOG

  //VISTA DE CAMPAÑAS
  public function getCampanas(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->bogota->transportes->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);
      //$diaanterior = '20231101';

      $query = "SELECT DISTINCT qr_rutas.employ, servicios.fecha_servicio FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$diaanterior."' AND '".$diaanterior."' AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.centrodecosto_id = 19 AND servicios.ruta = 1 order by qr_rutas.employ";

      $consulta = DB::select($query);

      $o = 1;

      return View::make('reportes.baq.campana', [

        'consulta' => $consulta,
        'permisos' =>$permisos,
        'o' => $o

      ]);
    }

  }
  public function getCampanass($diaanterior){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->bogota->transportes->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $fecha = date('Y-m-d');
      //$diaanterior = strtotime ('-1 day', strtotime($fecha));
      //$diaanterior = date ('Y-m-d' , $diaanterior);
      //$diaanterior = '20231101';

      $query = "SELECT DISTINCT qr_rutas.employ, servicios.fecha_servicio FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$diaanterior."' AND '".$diaanterior."' AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.centrodecosto_id = 19 AND servicios.ruta = 1 order by qr_rutas.employ";

      $consulta = DB::select($query);

      $o = 1;

      return View::make('reportes.baq.campana', [

        'consulta' => $consulta,
        'permisos' =>$permisos,
        'o' => $o

      ]);
    }

  }
  //VISTA DE CAMPAÑAS

  //VISTA DE BARRIOS
  public function getBarrios(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->bogota->transportes->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      $query = "SELECT DISTINCT qr_rutas.neighborhood, servicios.fecha_servicio FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$diaanterior."' AND '".$diaanterior."' AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.centrodecosto_id = 19 AND servicios.ruta = 1 order by qr_rutas.neighborhood asc";

      $consulta = DB::select($query);

      $o = 1;

      return View::make('reportes.baq.barrio', [

        'consulta' => $consulta,
        'permisos' =>$permisos,
        'o' => $o

      ]);
    }

  }
  //VISTA DE BARRIOS

  //VISTA PROVISORIA
  public function getHoy(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->bogota->transportes->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      $consulta = DB::table('servicios')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
      ->whereBetween('servicios.fecha_servicio',['20231101',$diaanterior])
      ->where('servicios.centrodecosto_id',19)
      ->where('servicios.ruta',1)
      ->whereNull('servicios.pendiente_autori_eliminacion')
      ->orderby('servicios.fecha_servicio')
      ->orderby('servicios.hora_servicio')
      ->get();

      $query = "SELECT DISTINCT qr_rutas.employ FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '20231101' AND '".$diaanterior."' AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.centrodecosto_id = 19 AND servicios.ruta = 1 order by qr_rutas.employ";

      $programas = DB::select($query);

      $query = "SELECT DISTINCT qr_rutas.neighborhood FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '20231101' AND '".$diaanterior."' AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.centrodecosto_id = 19 AND servicios.ruta = 1 order by qr_rutas.neighborhood";

      $barrios = DB::select($query);

      $o = 1;

      return View::make('reportes.baq.hoy', [
        'servicios' => $consulta,
        'permisos' =>$permisos,
        'programas' => $programas,
        'barrios' => $barrios,
        'o' => $o
      ]);
    }

  }
  //VISTA PREVISORIA

  /*BOG*/
  //VISTA DE CAMPAÑAS
  public function getCampanasbog(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->bogota->transportes->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);
      $diaanterior = '20231115';

      $query = "SELECT DISTINCT qr_rutas.employ, servicios.fecha_servicio FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$diaanterior."' AND '".$diaanterior."' AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.centrodecosto_id = 287 AND servicios.ruta = 1 order by qr_rutas.employ";

      $consulta = DB::select($query);

      $o = 1;

      return View::make('reportes.bog.campana', [

        'consulta' => $consulta,
        'permisos' =>$permisos,
        'o' => $o

      ]);
    }

  }

  public function getCampanassbog($diaanterior){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->bogota->transportes->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $fecha = date('Y-m-d');
      //$diaanterior = strtotime ('-1 day', strtotime($fecha));
      //$diaanterior = date ('Y-m-d' , $diaanterior);
      //$diaanterior = '20231115';

      $query = "SELECT DISTINCT qr_rutas.employ, servicios.fecha_servicio FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$diaanterior."' AND '".$diaanterior."' AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.centrodecosto_id = 287 AND servicios.ruta = 1 order by qr_rutas.employ";

      $consulta = DB::select($query);

      $o = 1;

      return View::make('reportes.bog.campana', [

        'consulta' => $consulta,
        'permisos' =>$permisos,
        'o' => $o

      ]);
    }

  }
  //VISTA DE CAMPAÑAS

  //VISTA DE BARRIOS
  public function getBarriosbog(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->bogota->transportes->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      $query = "SELECT DISTINCT qr_rutas.neighborhood, servicios.fecha_servicio FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$diaanterior."' AND '".$diaanterior."' AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.centrodecosto_id = 287 AND servicios.ruta = 1 order by qr_rutas.neighborhood asc";

      $consulta = DB::select($query);

      $o = 1;

      return View::make('reportes.bog.barrio', [

        'consulta' => $consulta,
        'permisos' =>$permisos,
        'o' => $o

      ]);
    }

  }
  //VISTA DE BARRIOS

  //VISTA PROVISORIA
  public function getHoybog(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->bogota->transportes->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      $consulta = DB::table('servicios')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
      ->whereBetween('servicios.fecha_servicio',['20231101',$diaanterior])
      ->where('servicios.centrodecosto_id',287)
      ->where('servicios.ruta',1)
      ->whereNull('servicios.pendiente_autori_eliminacion')
      ->orderby('servicios.fecha_servicio')
      ->orderby('servicios.hora_servicio')
      ->get();

      $query = "SELECT DISTINCT qr_rutas.employ FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '20231101' AND '20231130' AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.centrodecosto_id = 287 AND servicios.ruta = 1 order by qr_rutas.employ";

      $programas = DB::select($query);

      $query = "SELECT DISTINCT qr_rutas.neighborhood FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '20231101' AND '20231130' AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.centrodecosto_id = 287 AND servicios.ruta = 1 order by qr_rutas.neighborhood";

      $barrios = DB::select($query);

      $o = 1;

      return View::make('reportes.bog.hoy', [
        'servicios' => $consulta,
        'permisos' =>$permisos,
        'programas' => $programas,
        'barrios' => $barrios,
        'o' => $o
      ]);
    }

  }
  //VISTA PREVISORIA
  /*BOG*/

  //VISTA DE USUARIOS QR BAQ
  public function getProgramacionbarranquilla(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->barranquilla->transportesbq->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $query = DB::table('qr_rutas')
      ->orderBy('qr_rutas.servicio_id','asc')
      ->leftJoin('servicios', 'servicios.id', '=', 'qr_rutas.servicio_id')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->select('qr_rutas.*', 'servicios.ruta', 'servicios.conductor_id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.detalle_recorrido', 'conductores.nombre_completo', 'vehiculos.placa')
      ->where('servicios.fecha_servicio',date('Y-m-d'))
      ->where('servicios.centrodecosto_id',474)
      ->whereNull('pendiente_autori_eliminacion')
      ->get();

      $o = 1;

      return View::make('reportes.baq.reportes', [

        'documentos' => $query,
        'permisos' =>$permisos,
        'o' => $o

      ]);
    }

  }
  //FIN VISTA DE USUARIOS QR BAQ

  //CRONOGRAMA DE SERVICIOS BARRANQUILLA
  public function getCronogramaserviciosbarranquilla(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{
      $fecha = Input::get('fecha');
      $consulta = DB::table('servicios')

      ->leftJoin('proveedores', 'proveedores.id', '=', 'servicios.proveedor_id')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
      ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->select('servicios.id', 'servicios.ruta', 'servicios.proveedor_id', 'servicios.estado_servicio_app', 'servicios.conductor_id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.detalle_recorrido', 'conductores.nombre_completo', 'vehiculos.placa', 'proveedores.razonsocial', 'centrosdecosto.razonsocial as razon_centro', 'subcentrosdecosto.nombresubcentro')
      ->where('servicios.fecha_servicio',$fecha)
      ->where('centrosdecosto.localidad','BARRANQUILLA')
      ->whereNull('pendiente_autori_eliminacion')
      ->orderBy('servicios.proveedor_id','asc')
      ->groupBy(['servicios.conductor_id'])
      ->get();

      $o = 1;

      return View::make('reportes.baq.cronograma_servicios', [

        'datos' => $consulta,
        'permisos' =>$permisos,
        'fecha' => $fecha,
        'o' => $o

      ]);
    }
  }
  //FIN CRONOGRAMA DE SERVICIOS BOGOTÁ

  //CRONOGRAMA DE SERVICIOS BOGOTÁ
  public function getCronogramaserviciosbogota(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{
      $fecha = Input::get('fecha');
      $consulta = DB::table('servicios')

      ->leftJoin('proveedores', 'proveedores.id', '=', 'servicios.proveedor_id')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
      ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->select('servicios.id', 'servicios.ruta', 'servicios.proveedor_id', 'servicios.estado_servicio_app', 'servicios.conductor_id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.detalle_recorrido', 'conductores.nombre_completo', 'vehiculos.placa', 'proveedores.razonsocial', 'centrosdecosto.razonsocial as razon_centro', 'subcentrosdecosto.nombresubcentro')
      ->where('servicios.fecha_servicio',$fecha)
      ->where('centrosdecosto.localidad','BOGOTA')
      ->whereNull('pendiente_autori_eliminacion')
      ->orderBy('servicios.proveedor_id','asc')
      ->groupBy(['servicios.conductor_id'])
      ->get();

      $o = 1;

      return View::make('reportes.bog.cronograma_servicios', [

        'datos' => $consulta,
        'permisos' =>$permisos,
        'fecha' => $fecha,
        'o' => $o

      ]);
    }
  }
  //FIN CRONOGRAMA DE SERVICIOS BOGOTÁ

  //CRONOGRAMA DE SERVICIOS BOGOTÁ v2
  public function getDisponibilidadbogota(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $fecha = date('Y-m-d');

      $consulta = DB::table('conductores')
      ->leftJoin('proveedores', 'proveedores.id', '=', 'conductores.proveedores_id')
      ->select('proveedores.id as id_proveedor', 'proveedores.localidad', 'conductores.id', 'conductores.nombre_completo', 'conductores.inicio_fecha', 'conductores.inicio_hora', 'conductores.fin_fecha', 'conductores.fin_hora', 'proveedores.razonsocial', 'conductores.fecha_licencia_vigencia')
      ->where('conductores.bloqueado')
      ->whereNull('conductores.bloqueado_total')
      ->whereNull('proveedores.inactivo')
      ->whereNull('proveedores.inactivo_total')
      ->where('proveedores.localidad', 'bogota')
      ->orderBy('conductores.nombre_completo','asc')
      ->get();

      $o = 1;

      return View::make('reportes.bog.disponibilidad', [

        'datos' => $consulta,
        'permisos' =>$permisos,
        'fecha' => $fecha,
        'o' => $o

      ]);
    }
  }
  //FIN CRONOGRAMA DE SERVICIOS BOGOTÁ v2

  //CRONOGRAMA DE SERVICIOS - PLACAS BOGOTÁ v3
  public function getDisponibilidadvehiculosbogota(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $fecha = date('Y-m-d');

      $consulta = DB::table('vehiculos')
      ->leftJoin('proveedores', 'proveedores.id', '=', 'vehiculos.proveedores_id')
      ->select('proveedores.id as id_proveedor', 'proveedores.localidad', 'vehiculos.id', 'vehiculos.placa', 'vehiculos.fecha_vigencia_operacion', 'vehiculos.fecha_vigencia_soat', 'vehiculos.fecha_vigencia_tecnomecanica', 'vehiculos.mantenimiento_preventivo', 'vehiculos.poliza_contractual', 'vehiculos.poliza_extracontractual', 'proveedores.razonsocial')
      ->whereNull('vehiculos.bloqueado')
      ->whereNull('vehiculos.bloqueado_total')
      ->whereNull('proveedores.inactivo')
      ->whereNull('proveedores.inactivo_total')
      ->where('proveedores.localidad', 'bogota')
      ->orderBy('vehiculos.placa','asc')
      ->get();

      $o = 1;

      return View::make('reportes.bog.disponibilidadveh', [

        'datos' => $consulta,
        'permisos' =>$permisos,
        'fecha' => $fecha,
        'o' => $o

      ]);
    }
  }
  //FIN CRONOGRAMA DE SERVICIOS - PLACAS BOGOTÁ v3

  //CRONOGRAMA DE SERVICIOS BARRANQUILLA v2
  public function getDisponibilidadbarranquilla(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $fecha = date('Y-m-d');

      $consulta = DB::table('conductores')
      ->leftJoin('proveedores', 'proveedores.id', '=', 'conductores.proveedores_id')
      ->select('proveedores.id as id_proveedor', 'proveedores.localidad', 'conductores.id', 'conductores.nombre_completo', 'conductores.inicio_fecha', 'conductores.inicio_hora', 'conductores.fin_fecha', 'conductores.fin_hora', 'proveedores.razonsocial', 'conductores.fecha_licencia_vigencia')
      ->where('conductores.bloqueado')
      ->whereNull('conductores.bloqueado_total')
      ->whereNull('proveedores.inactivo')
      ->whereNull('proveedores.inactivo_total')
      ->where('proveedores.localidad', 'barranquilla')
      ->orderBy('conductores.nombre_completo','asc')
      ->get();

      $o = 1;

      return View::make('reportes.bog.disponibilidad', [

        'datos' => $consulta,
        'permisos' =>$permisos,
        'fecha' => $fecha,
        'o' => $o

      ]);
    }
  }
  //FIN CRONOGRAMA DE SERVICIOS BARRANQUILLA v2

  //CRONOGRAMA DE SERVICIOS - PLACAS BARRANQUILLA v3
  public function getDisponibilidadvehiculosbarranquilla(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $fecha = date('Y-m-d');

      $consulta = DB::table('vehiculos')
      ->leftJoin('proveedores', 'proveedores.id', '=', 'vehiculos.proveedores_id')
      ->select('proveedores.id as id_proveedor', 'proveedores.localidad', 'vehiculos.id', 'vehiculos.placa', 'vehiculos.fecha_vigencia_operacion', 'vehiculos.fecha_vigencia_soat', 'vehiculos.fecha_vigencia_tecnomecanica', 'vehiculos.mantenimiento_preventivo', 'vehiculos.poliza_contractual', 'vehiculos.poliza_extracontractual', 'proveedores.razonsocial')
      ->whereNull('vehiculos.bloqueado')
      ->whereNull('vehiculos.bloqueado_total')
      ->whereNull('proveedores.inactivo')
      ->whereNull('proveedores.inactivo_total')
      ->where('proveedores.localidad', 'barranquilla')
      ->orderBy('vehiculos.placa','asc')
      ->get();

      $o = 1;

      return View::make('reportes.baq.disponibilidadveh', [

        'datos' => $consulta,
        'permisos' =>$permisos,
        'fecha' => $fecha,
        'o' => $o

      ]);
    }
  }
  //FIN CRONOGRAMA DE SERVICIOS - PLACAS BARRANQUILLA v3

  //CANTIDAD DE SERVICIOS POR CONDUCTOR
  public function getCantidadservicios(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $consulta = DB::table('servicios')

      ->leftJoin('proveedores', 'proveedores.id', '=', 'servicios.proveedor_id')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
      ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->select('servicios.id', 'servicios.ruta', 'servicios.proveedor_id', 'servicios.estado_servicio_app', 'servicios.conductor_id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.detalle_recorrido', 'conductores.nombre_completo', 'vehiculos.placa', 'proveedores.razonsocial', 'centrosdecosto.razonsocial as razon_centro', 'subcentrosdecosto.nombresubcentro')
      ->where('servicios.fecha_servicio',date('Y-m-d'))
      ->where('servicios.centrodecosto_id',287)
      ->whereNull('pendiente_autori_eliminacion')
      ->orderBy('servicios.proveedor_id','asc')
      ->groupBy(['servicios.conductor_id'])
      ->get();

      $o = 1;

      return View::make('reportes.cantidad_servicios', [

        'datos' => $consulta,
        'permisos' =>$permisos,
        'o' => $o
      ]);
    }
  }
  //FIN CANTIDAD DE SERVICIOS POR CONDUCTOR

  public function postBuscar(){

    if (Request::ajax()){

      $fecha_inicial = Input::get('fecha_inicial');
      $fecha_final = Input::get('fecha_final');
      $servicio = intval(Input::get('servicios'));
      $ciudad = Input::get('ciudad');
      $conductor_id = Input::get('conductores');
      $id_rol = Sentry::getUser()->id_rol;
      $option = Input::get('option');

      if ($conductor_id===null) {
        $conductor_id = 0;
      }
      $cliente = Input::get('cliente_search');
      if($cliente==='CLIENTE'){
      	$cliente = 0;
      }

      $codigo = Input::get('codigo');

      $consulta = "select gestion_documental.id, gestion_documental.hora, gestion_documental.cliente, gestion_documental.tipo_ruta, gestion_documental.fecha, gestion_documental.id_image, gestion_documental.estado, gestion_documental.nombre_documento, gestion_documental.placa, gestion_documental.id_conductor, gestion_documental.novedadesruta, ".
          "conductores.nombre_completo, conductores.celular ".
          "from gestion_documental ".
          "left join conductores on gestion_documental.id_conductor = conductores.id ".
          "where gestion_documental.fecha between '".$fecha_inicial."' AND '".$fecha_final."' and gestion_documental.estado in (0,1) ";
      if($option==='1'){
        $consulta .=" and cliente in('SUTHERLAND BAQ','ACEROS CORTADOS','LHOIST','PIMSA','PUERTO PIMSA', 'QUANTICA - BILATERAL')";
      }elseif ($option==='2') {
        $consulta .=" and cliente in('SUTHERLAND BOG','MASTERFOOD')";
      }

      if($conductor_id!='0'){
        $consulta .= " and conductores.id = ".$conductor_id." ";
      }

      if($cliente!='0'){
      	$consulta.=" and gestion_documental.cliente = '".$cliente."' ";
      }

      if($codigo!=''){
        $consulta .= " and gestion_documental.id = '".$codigo."' ";
      }


      $documentos = DB::select(DB::raw($consulta." order by gestion_documental.id asc"));

      if ($documentos!=null) {

        return Response::json([
          'mensaje'=>true,
          'documentos'=>$documentos,
          'consulta'=>$consulta,
          'id_rol'=>$id_rol,
          'option'=>$option
        ]);

      }else{

        return Response::json([
            'mensaje'=>false,
            'consulta'=>$consulta,
        ]);
      }
    }
  }

  //Buscar reportes
  public function postBuscarusuariosbog(){

    if(Request::ajax()){

      $fecha_inicial = Input::get('fecha_inicial');
      $fecha_final = Input::get('fecha_final');
      $servicio = intval(Input::get('servicios'));

      $id_rol = Sentry::getUser()->id_rol;
      $id_cliente = Sentry::getUser()->centrodecosto_id;

      $consulta = "select qr_rutas.id, qr_rutas.id_usuario, qr_rutas.conductor_id, qr_rutas.status, qr_rutas.servicio_id, qr_rutas.fullname, qr_rutas.address, qr_rutas.locality, qr_rutas.neighborhood,  servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.estado_servicio_app, servicios.centrodecosto_id, ".
        "conductores.nombre_completo, conductores.celular, vehiculos.placa ".
        "from qr_rutas ".
        "left join servicios on qr_rutas.servicio_id = servicios.id ".
        "left join conductores on qr_rutas.conductor_id = conductores.id ".
        "left join vehiculos on vehiculos.id = servicios.vehiculo_id ".
        "where servicios.fecha_servicio between '".$fecha_inicial."' AND '".$fecha_final."' and servicios.centrodecosto_id = 287 and servicios.pendiente_autori_eliminacion is null ";

      $documentos = DB::select(DB::raw($consulta." order by qr_rutas.servicio_id asc"));

      if ($documentos!=null) {

        return Response::json([
          'mensaje'=>true,
          'documentos'=>$documentos,
        ]);

      }else{

        return Response::json([
          'mensaje'=>false,
          'consulta'=>$consulta,
        ]);
      }
    }
  }

  public function postBuscarusuariosbaq(){

    if(Request::ajax()){

      $fecha_inicial = Input::get('fecha_inicial');
      $fecha_final = Input::get('fecha_final');
      $servicio = intval(Input::get('servicios'));

      $id_rol = Sentry::getUser()->id_rol;
      $id_cliente = Sentry::getUser()->centrodecosto_id;

      $consulta = "select qr_rutas.id, qr_rutas.id_usuario, qr_rutas.conductor_id, qr_rutas.status, qr_rutas.servicio_id, qr_rutas.fullname, qr_rutas.address, qr_rutas.locality, qr_rutas.neighborhood,  servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.estado_servicio_app, servicios.centrodecosto_id, ".
        "conductores.nombre_completo, conductores.celular, vehiculos.placa ".
        "from qr_rutas ".
        "left join servicios on qr_rutas.servicio_id = servicios.id ".
        "left join conductores on servicios.conductor_id = conductores.id ".
        "left join vehiculos on vehiculos.id = servicios.vehiculo_id ".
        "where servicios.fecha_servicio between '".$fecha_inicial."' AND '".$fecha_final."' and servicios.centrodecosto_id = 474 and servicios.pendiente_autori_eliminacion is null ";

      $documentos = DB::select(DB::raw($consulta." order by qr_rutas.servicio_id asc"));

      if ($documentos!=null) {

        return Response::json([
          'mensaje'=>true,
          'documentos'=>$documentos,
        ]);

      }else{

        return Response::json([
          'mensaje'=>false,
          'consulta'=>$consulta,
        ]);
      }
    }
  }

  public function postExcel(){

    ob_end_clean();
    ob_start();
    Excel::create('Servicios', function($excel){

      $excel->sheet('hoja', function($sheet){

        $fecha_inicial = Input::get('fecha_inicial');
        $fecha_final = Input::get('fecha_final');
        $conductor = Input::get('conductores2');
        //$subcentrodecosto = Input::get('md_subcentrodecosto');

        $consulta = "select qr_rutas.id, qr_rutas.id_usuario, qr_rutas.conductor_id, qr_rutas.status, qr_rutas.servicio_id, qr_rutas.fullname, qr_rutas.address, qr_rutas.locality, qr_rutas.neighborhood,  servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.estado_servicio_app, servicios.centrodecosto_id, ".
          "conductores.nombre_completo, conductores.celular, vehiculos.placa ".
          "from qr_rutas ".
          "left join servicios on qr_rutas.servicio_id = servicios.id ".
          "left join conductores on qr_rutas.conductor_id = conductores.id ".
          "left join vehiculos on vehiculos.id = servicios.vehiculo_id ".
          "where servicios.fecha_servicio between '".$fecha_inicial."' AND '".$fecha_final."' and servicios.centrodecosto_id = 287 and servicios.pendiente_autori_eliminacion is null ";

          $servicios = DB::select($consulta);

        $sheet->loadView('documentos.plantilla_servicios2')
        ->with([
            'servicios'=>$servicios
        ]);
      });
    })->download('xls');
  }

  public function postExcelbog(){

    ob_end_clean();
    ob_start();
    Excel::create('Servicios', function($excel){

      $excel->sheet('hoja', function($sheet){

        $fecha_inicial = Input::get('fecha_inicial');
        $fecha_final = Input::get('fecha_final');
        $conductor = Input::get('conductores2');
        //$subcentrodecosto = Input::get('md_subcentrodecosto');

        $consulta = "select qr_rutas.id, qr_rutas.id_usuario, qr_rutas.conductor_id, qr_rutas.status, qr_rutas.servicio_id, qr_rutas.fullname, qr_rutas.address, qr_rutas.locality, qr_rutas.neighborhood,  servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.estado_servicio_app, servicios.centrodecosto_id, ".
          "conductores.nombre_completo, conductores.celular, vehiculos.placa ".
          "from qr_rutas ".
          "left join servicios on qr_rutas.servicio_id = servicios.id ".
          "left join conductores on qr_rutas.conductor_id = conductores.id ".
          "left join vehiculos on vehiculos.id = servicios.vehiculo_id ".
          "where servicios.fecha_servicio between '".$fecha_inicial."' AND '".$fecha_final."' and servicios.centrodecosto_id = 287 and servicios.pendiente_autori_eliminacion is null ";

          $servicios = DB::select($consulta);

        $sheet->loadView('documentos.plantilla_servicios2')
        ->with([
            'servicios'=>$servicios
        ]);
      });
    })->download('xls');
  }

	public function getPdf(){

    if (Sentry::check()){

		  $cliente = Input::get('cliente');
      $fecha = Input::get('fecha_pdf');

      $consulta = "select gestion_documental.id, gestion_documental.hora, gestion_documental.tipo_ruta, gestion_documental.fecha, gestion_documental.id_image, gestion_documental.nombre_documento, gestion_documental.placa, gestion_documental.id_conductor, ".
                  "conductores.nombre_completo, conductores.celular ".
                  "from gestion_documental ".
                  "left join conductores on gestion_documental.id_conductor = conductores.id ".
                  "where gestion_documental.fecha = '".$fecha."' and gestion_documental.cliente = '".$cliente."' and gestion_documental.estado = 1";
      $documentos = DB::select(DB::raw($consulta." order by gestion_documental.id asc"));

      $html = View::make('documentos.pdf_fotos_rutas')
      ->with(['documentos'=>$documentos, 'fecha'=>$fecha]);
      return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('RUTAS DEL DÍA '.$fecha.' '.$cliente);
  	}
  }

  public function getPdffotos(){

    if (Sentry::check()){

      $id_cliente = Sentry::getUser()->centrodecosto_id;
      if($id_cliente==287){
        $nombre_cliente = 'SUTHERLAND BOG';
      }elseif ($id_cliente==19) {
        $nombre_cliente = 'SUTHERLAND BAQ';
      }

      $fecha = Input::get('fecha_pdf');

      $consulta = "select gestion_documental.id, gestion_documental.hora, gestion_documental.tipo_ruta, gestion_documental.fecha, gestion_documental.id_image, gestion_documental.nombre_documento, gestion_documental.placa, gestion_documental.id_conductor, ".
                "conductores.nombre_completo, conductores.celular ".
                "from gestion_documental ".
                "left join conductores on gestion_documental.id_conductor = conductores.id ".
                "where gestion_documental.fecha = '".$fecha."' and gestion_documental.cliente = '".$nombre_cliente."' and gestion_documental.estado = 1";
      $documentos = DB::select(DB::raw($consulta." order by gestion_documental.id asc"));

      $html = View::make('documentos.pdf_fotos_rutas')
      ->with(['documentos'=>$documentos, 'fecha'=>$fecha]);
      return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('RUTAS DEL DÍA '.$fecha.' '.$nombre_cliente);
    }
  }

  public function getLista(){

        if (Sentry::check()){
            $id_rol = Sentry::getUser()->id_rol;
            $centrodecosto_id = Sentry::getUser()->centrodecosto_id;
            $cliente = DB::table('centrosdecosto')->where('id',$centrodecosto_id)->pluck('razonsocial');
            $idusuario = Sentry::getUser()->id;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
            $ver = $permisos->portalusuarios->admin->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on') {
            return View::make('admin.permisos');
        }else{

          $mess = date('m');
          $ano = date('Y');
          $fechaInicial = $ano.$mess.'01';
          $fechaFinal = $ano.$mess.'31';

          if(Sentry::getUser()->subcentrodecosto_id!=null) {

            $reportes = DB::table('report')
            ->leftJoin('users', 'users.id', '=', 'report.creado_por')
            ->select('report.*', 'users.first_name', 'users.last_name')
            ->whereBetween('report.fecha',[$fechaInicial,$fechaFinal])
            ->where('report.sub',853)
            ->orderBy('report.fecha', 'desc')
            ->get();

          }else{

            $reportes = DB::table('report')
            ->leftJoin('users', 'users.id', '=', 'report.creado_por')
            ->select('report.*', 'users.first_name', 'users.last_name')
            ->whereBetween('report.fecha',[$fechaInicial,$fechaFinal])
            ->orderBy('report.fecha', 'desc')
            ->get();

          }

        return View::make('portalusuarios.admin.listado.lista_novedades')
        ->with('idusuario',$idusuario)
        ->with('fecha',1)
        ->with('cc',$centrodecosto_id)
        ->with('cliente',$cliente)
        ->with('permisos',$permisos)
        ->with('centrodecosto_id',$centrodecosto_id)
        ->with('reportes', $reportes);
        }
    }

    public function getListanovs(){ //IGT

        if (Sentry::check()){
            $id_rol = Sentry::getUser()->id_rol;
            $centrodecosto_id = Sentry::getUser()->centrodecosto_id;
            $cliente = DB::table('centrosdecosto')->where('id',$centrodecosto_id)->pluck('razonsocial');
            $idusuario = Sentry::getUser()->id;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
            $ver = $permisos->portalusuarios->admin->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on') {
            return View::make('admin.permisos');
        }else{

          $mess = date('m');
          $ano = date('Y');
          $fechaInicial = $ano.$mess.'01';
          $fechaFinal = $ano.$mess.'31';

          if(Sentry::getUser()->subcentrodecosto_id!=null) {

            $reportes = DB::table('report')
            ->leftJoin('users', 'users.id', '=', 'report.creado_por')
            ->select('report.*', 'users.first_name', 'users.last_name')
            ->whereBetween('report.fecha',[$fechaInicial,$fechaFinal])
            ->where('report.cliente',Sentry::getUser()->centrodecosto_id)
            ->where('report.sub',Sentry::getUser()->subcentrodecosto_id)
            ->orderBy('report.fecha', 'desc')
            ->get();

          }else{

            $reportes = DB::table('report')
            ->leftJoin('users', 'users.id', '=', 'report.creado_por')
            ->select('report.*', 'users.first_name', 'users.last_name')
            ->whereBetween('report.fecha',[$fechaInicial,$fechaFinal])
            ->where('report.cliente',Sentry::getUser()->centrodecosto_id)
            ->orderBy('report.fecha', 'desc')
            ->get();

          }

        return View::make('portalusuarios.admin.listado.lista_novedades_igt')
        ->with('idusuario',$idusuario)
        ->with('fecha',1)
        ->with('cc',$centrodecosto_id)
        ->with('cliente',$cliente)
        ->with('permisos',$permisos)
        ->with('centrodecosto_id',$centrodecosto_id)
        ->with('reportes', $reportes);
        }
    }

    public function postFiltrarmes() {

      if (!Sentry::check()){

        return Response::json([
          'respuesta' => 'sesion_caducada'
        ]);

      }else{

        $cc = Sentry::getUser()->centrodecosto_id;

        $ciudad = Input::get('ciudad');
        $sedes = Input::get('sedes');
        $ano = Input::get('ano');
        $mes = Input::get('mes');

        $fecha = $ano.'-'.$mes.'-01';
        $fechaFinal = $ano.'-'.$mes.'-31';

        $center = Sentry::getUser()->centrodecosto_id;
        
        if(Sentry::getUser()->subcentrodecosto_id!=null) {

          $reportes = DB::table('report')
          ->select('report.id', 'report.fecha', 'report.fecha_fin', 'report.fecha_created', 'report.ciudad', 'report.descargado', 'report.created_at', 'users.first_name', 'users.last_name')
          ->leftJoin('users', 'users.id', '=', 'report.creado_por')
          ->whereBetween('fecha',[$fecha,$fechaFinal])
          ->where('report.cliente',Sentry::getUser()->centrodecosto_id)
          ->where('report.sub',Sentry::getUser()->subcentrodecosto_id)
          ->orderBy('fecha', 'desc')
          ->get();
          
        }else{

          $reportes = DB::table('report')
          ->select('report.id', 'report.fecha', 'report.fecha_fin', 'report.fecha_created', 'report.ciudad', 'report.descargado', 'report.created_at', 'users.first_name', 'users.last_name')
          ->leftJoin('users', 'users.id', '=', 'report.creado_por')
          ->whereBetween('fecha',[$fecha,$fechaFinal])
          ->where('report.cliente',$center)
          ->orderBy('fecha', 'desc')
          ->get();

        }

        if(count($reportes)) {

          return Response::json([
            'respuesta' => true,
            'cc' => $center,
            'ciudad' => $ciudad,
            'sedes' => $sedes,
            'ano' => $ano,
            'mes' => $mes,
            'fecha' => $fecha,
            'fechaFinal' => $fechaFinal,
            'reportes' => $reportes
          ]);

        }else{

          return Response::json([
            'respuesta' => false,
            'fecha' => $fecha,
            'fechaFinal' => $fechaFinal,
            'centro' => Sentry::getUser()->centrodecosto_id,
            'sub' => Sentry::getUser()->subcentrodecosto_id
          ]);

        }

      }

    }

    public function getMeses(){

          if (Sentry::check()){
              $id_rol = Sentry::getUser()->id_rol;
              $centrodecosto_id = Sentry::getUser()->centrodecosto_id;
              $cliente = DB::table('centrosdecosto')->where('id',$centrodecosto_id)->pluck('razonsocial');
              $idusuario = Sentry::getUser()->id;
              $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
              $permisos = json_decode($permisos);
              $ver = $permisos->portalusuarios->admin->ver;
          }else{
              $ver = null;
          }

          if (!Sentry::check()){
            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

          }else if($ver!='on') {
              return View::make('admin.permisos');
          }else{

            $mess = date('m');
            $ano = date('Y');
            $fechaInicial = $ano.$mess.'01';
            $fechaFinal = $ano.$mess.'31';

            $reportes = DB::table('dash')
            ->leftJoin('users', 'users.id', '=', 'dash.creado_por')
            ->select('dash.*', 'users.first_name', 'users.last_name')
            ->whereIn('dash.cliente',[19,287])
            ->orderBy('fecha_inicial', 'desc')
            ->get();

            return View::make('portalusuarios.admin.listado.lista_meses')
            ->with('idusuario',$idusuario)
            ->with('fecha',1)
            ->with('cc',$centrodecosto_id)
            ->with('cliente',$cliente)
            ->with('permisos',$permisos)
            ->with('centrodecosto_id',$centrodecosto_id)
            ->with('reportes', $reportes);

          }

      }

      public function getDashboard(){

          if (Sentry::check()){
              $id_rol = Sentry::getUser()->id_rol;
              $centrodecosto_id = Sentry::getUser()->centrodecosto_id;
              $cliente = DB::table('centrosdecosto')->where('id',$centrodecosto_id)->pluck('razonsocial');
              $idusuario = Sentry::getUser()->id;
              $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
              $permisos = json_decode($permisos);
              $ver = $permisos->portalusuarios->admin->ver;
          }else{
              $ver = null;
          }

          if (!Sentry::check()){
            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

          }else if($ver!='on') {
              return View::make('admin.permisos');
          }else{

            $mess = date('m');
            $ano = date('Y');
            $fechaInicial = $ano.$mess.'01';
            $fechaFinal = $ano.$mess.'31';

            $reportes = DB::table('dash')
            ->leftJoin('users', 'users.id', '=', 'dash.creado_por')
            ->select('dash.*', 'users.first_name', 'users.last_name')
            ->whereIn('dash.cliente',[489])
            ->orderBy('fecha_inicial', 'desc')
            ->get();

            return View::make('portalusuarios.admin.listado.lista_meses_igt')
            ->with('idusuario',$idusuario)
            ->with('fecha',1)
            ->with('cc',$centrodecosto_id)
            ->with('cliente',$cliente)
            ->with('permisos',$permisos)
            ->with('centrodecosto_id',$centrodecosto_id)
            ->with('reportes', $reportes);

          }

      }

      public function postFiltrarmeses() {

      if (!Sentry::check()){

        return Response::json([
          'respuesta' => 'sesion_caducada'
        ]);

      }else{

        $cc = Sentry::getUser()->centrodecosto_id;

        $ciudad = Input::get('ciudad');
        $sedes = Input::get('sedes');
        $ano = Input::get('ano');
        $mes = Input::get('mes');

        $fecha = $ano.'-'.$mes.'-01';
        $fechaFinal = $ano.'-'.$mes.'-31';

        $center = 489;

        $query = "SELECT dash.*, users.first_name, users.last_name FROM dash left join users on users.id = dash.creado_por where dash.id is not null";

        $query .=" and cliente = ".$center."";

        if($mes!='0'){
          $query .=" and mes = '".strtoupper($mes)."'";
        }

        if($ano!='0'){
          $query .=" and ano = ".$ano."";
        }

        $consulta = DB::select($query);


        if(count($consulta)) {

          return Response::json([
            'respuesta' => true,
            'cc' => $center,
            'ciudad' => $ciudad,
            'sedes' => $sedes,
            'ano' => $ano,
            'mes' => $mes,
            'fecha' => $fecha,
            'fechaFinal' => $fechaFinal,
            'reportes' => $consulta
          ]);

        }else{

          return Response::json([
            'respuesta' => false,
            'query' => $query,
            'ciudad' => $ciudad
          ]);

        }

      }

    }

    public function getDashold(){

          if (Sentry::check()){
              $id_rol = Sentry::getUser()->id_rol;
              $centrodecosto_id = Sentry::getUser()->centrodecosto_id;
              $cliente = DB::table('centrosdecosto')->where('id',$centrodecosto_id)->pluck('razonsocial');
              $idusuario = Sentry::getUser()->id;
              $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
              $permisos = json_decode($permisos);
              $ver = $permisos->portalusuarios->admin->ver;
          }else{
              $ver = null;
          }

          if (!Sentry::check()){
            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

          }else if($ver!='on') {
              return View::make('admin.permisos');
          }else{

            $reportes = DB::table('report')
            ->get();

            $rutas_no = DB::table('dash')
            ->where('id',1)
            ->pluck('rutas_no_exitosas');

          $pasajeros = DB::table('pasajeros')->where('centrodecosto_id',$centrodecosto_id)->get();

          return View::make('portalusuarios.admin.dashboard.dash')
          ->with('idusuario',$idusuario)
          ->with('fecha',1)
          ->with('cc',1)
          ->with('cliente',$cliente)
          ->with('permisos',$permisos)
          ->with('centrodecosto_id',$centrodecosto_id)
          ->with('reportes', $reportes)
          ->with('pasajeros',$pasajeros)
          ->with('datossatisfechos',10)
          ->with('datosnosatisfechos', 20)
          ->with('rutas_no', json_decode($rutas_no));


          }
      }

      public function getDash($id){

            if (Sentry::check()){
                $id_rol = Sentry::getUser()->id_rol;
                $centrodecosto_id = Sentry::getUser()->centrodecosto_id;
                $cliente = DB::table('centrosdecosto')->where('id',$centrodecosto_id)->pluck('razonsocial');
                $idusuario = Sentry::getUser()->id;
                $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
                $permisos = json_decode($permisos);
                $ver = 'on';
                //$ver = $permisos->portalusuarios->admin->ver;
            }else{
                $ver = null;
            }

            if (!Sentry::check()){
              return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

            }else if($ver!='on') {
                return View::make('admin.permisos');
            }else{

              $reportes = DB::table('report')
              ->get();

              $rutas_no = DB::table('dash')
              ->where('id',1)
              ->pluck('rutas_no_exitosas');

            $pasajeros = DB::table('pasajeros')->where('centrodecosto_id',$centrodecosto_id)->get();

            $consulta = "select * from dash order by id desc limit 1";
            $general = DB::select($consulta);
            $generales = DB::table('dash')->where('id',$id)->first();

            $programas = "SELECT DISTINCT programa, id_reporte FROM usuarios_amonestados WHERE id_reporte = ".$id." order by programa ";
            $programas = DB::select($programas);
            //$novedad =
            return View::make('portalusuarios.admin.dashboard.no_exitosas')

            ->with('id', $id)
            ->with('generales', $generales)
            ->with('programas', $programas)

            ->with('idusuario',$idusuario)
            ->with('fecha',1)
            ->with('cc',1)
            ->with('cliente',$cliente)
            ->with('permisos',$permisos)
            ->with('centrodecosto_id',$centrodecosto_id)
            ->with('reportes', $reportes)
            ->with('pasajeros',$pasajeros)
            ->with('datossatisfechos',10)
            ->with('datosnosatisfechos', 20)
            ->with('rutas_no', json_decode($rutas_no));


            }
        }

        public function postExportaramonestados(){

          if (!Sentry::check()){
              return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
          }else{

                $cc = Input::get('cc');
                $id_reporte = Input::get('id_reporte');

                if ($centrodecosto==='-' or $subcentrodecosto==='-') {

                    return Redirect::to('transportes');

                }else{

                    ob_end_clean();
                    ob_start();

                    Excel::create('Novedades Del '.$fecha, function($excel) use ($cc, $id_reporte, $centrodecosto, $subcentrodecosto, $fecha, $fechafinal){

                        $excel->sheet('hoja', function($sheet) use ($centrodecosto, $subcentrodecosto, $fecha, $fechafinal, $cc, $id_reporte){

                            $localidad = DB::table('centrosdecosto')
                            ->where('id',$cc)
                            ->pluck('localidad');

                            if($cc==19){
                              //select distinc cmapañas
                              $servicios = "SELECT DISTINCT qr_rutas.servicio_id, qr_rutas.employ, qr_rutas.id_rutaqr, servicios.fecha_servicio, qr_rutas.id_usuario FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN  '20230601' AND '20230615' AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.centrodecosto_id = 19 AND qr_rutas.employ LIKE '% DTV SPANISH - BARR%'";
                              $servicios = DB::select($servicios);

                              $servicios2 = null;

                            }else{

                              $diasiguiente = strtotime ('+1 day', strtotime($fecha));
                              $diasiguiente = date('Y-m-d' , $diasiguiente);

                              $servicios = DB::table('servicios')
                              ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                              ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                              ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
                              //->where('servicios.fecha_servicio',$fecha)
                              //->where('servicios.hora_servicio', '>=', '08:00')
                              ->whereBetween('servicios.fecha_servicio',['20230616','20230701'])
                              ->where('servicios.centrodecosto_id',$cc)
                              ->where('servicios.ruta',1)
                              ->whereNull('servicios.pendiente_autori_eliminacion')
                              ->orderby('servicios.fecha_servicio')
                              ->orderby('servicios.hora_servicio')
                              ->get();

                              $servicios2 = DB::table('servicios')
                              ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                              ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                              ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
                              ->where('servicios.fecha_servicio',$diasiguiente)
                              ->where('servicios.hora_servicio', '<=', '08:00')
                              ->where('servicios.centrodecosto_id',$cc)
                              ->where('servicios.ruta',1)
                              ->whereNull('servicios.pendiente_autori_eliminacion')
                              ->orderby('servicios.hora_servicio')
                              ->get();

                              //$servicios2 = null;

                            }

                            /*$servicios = DB::table('servicios')
                            ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                            ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                            ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
                            ->whereBetween('servicios.fecha_servicio',['20230601','20230615'])
                            //->where('servicios.hora_servicio', '>=', '08:00')
                            ->where('servicios.centrodecosto_id',$cc)
                            ->where('servicios.ruta',1)
                            ->whereNull('servicios.pendiente_autori_eliminacion')
                            ->orderby('servicios.fecha_servicio')
                            ->orderby('servicios.hora_servicio')
                            ->get();*/


                            //$query = "select servicios.*, subcentrosdecosto.nombresubcentro, vehiculos.clase, vehiculos.capacidad, vehiculos.placa from servicios left join vehiculos on vehiculos.id = servicios.vehiculo_id left join subcentrosdecosto on subcentrosdecosto.id = servicios.subcentrodecosto_id where servicios.fecha_servicio = '".$fecha."' and servicios.centrodecosto_id = ".$cc." and servicios.ruta = 1 order by servicios.hora_servicio";

                            //$servicios = DB::select($query);

                            $sheet->loadView('servicios.plantilla_novedades')
                              ->with([
                                  'servicios'=>$servicios,
                                  'servicios2' => $servicios2
                              ]);

                            $objDrawing = new PHPExcel_Worksheet_Drawing;
                            $objDrawing->setPath('biblioteca_imagenes/logos.png');
                            $objDrawing->setCoordinates('B2');
                            $objDrawing->setResizeProportional(false);
                            $objDrawing->setWidth(120);
                            $objDrawing->setHeight(30);
                            $objDrawing->setWorksheet($sheet);

                        });
                      })->download('xls');
                  }

            }
        }

        public function postQuery(){

          //Costos por campaña; RUTAS EXITOSAS
          /*$servicios = "SELECT DISTINCT qr_rutas.servicio_id, qr_rutas.employ, qr_rutas.id_rutaqr, servicios.fecha_servicio, qr_rutas.id_usuario FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN  '20230601' AND '20230615' AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.centrodecosto_id = 19 AND qr_rutas.employ LIKE '% DTV SPANISH - BARR%'";
          $servicios = DB::select($servicios);
          $cont = 0;

         foreach ($servicios as $key => $value) {

           $programa = str_replace('AMP;', '', $value->employ);
           $programa = str_replace('amp;', '', $programa);

            $update = DB::table('qr_rutas')
            ->where('servicio_id',$value->servicio_id)
            ->where('id_usuario',$value->id_usuario)
            ->update([
                'employ' => $programa
            ]);

            if($update){
              $cont++;
            }

         }*/

         //esoacios por tipo de novedad
         /*$servicios = "SELECT qr_rutas.id, servicio_id, qr_rutas.employ, id_rutaqr, servicios.fecha_servicio, servicios.hora_servicio FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '20230801' AND '20230831' AND servicios.centrodecosto_id = 287 AND servicios.pendiente_autori_eliminacion IS NULL and qr_rutas.employ IS NULL";
         $servicios = DB::select($servicios);
         $cont = 0;

        foreach ($servicios as $key => $value) {

          $programa = str_replace('AMP;', '', $value->employ);
          $programa = str_replace('amp;', '', $programa);

           $update = DB::table('qr_rutas')
           ->where('servicio_id',$value->servicio_id)
           ->where('id_usuario',$value->id_usuario)
           ->update([
               'employ' => $programa
           ]);

           if($update){
             $cont++;
           }

        }*/

        //Pasar data de servicios a qr_rutas
        //$servicios = "SELECT qr_rutas.id, servicio_id, qr_rutas.employ, id_rutaqr, servicios.fecha_servicio, servicios.hora_servicio FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '20231101' AND '20231130' AND servicios.centrodecosto_id = 287 AND servicios.pendiente_autori_eliminacion IS NULL AND qr_rutas.employ like '%TMOBILE%'";
        $servicios = "SELECT distinct qr_rutas.servicio_id, servicios.fecha_servicio, qr_rutas.id, qr_rutas.employ, id_rutaqr, servicios.hora_servicio FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN  '20231221' AND '20231231' AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.centrodecosto_id = 287 AND servicios.ruta is not null";
        $servicios = DB::select($servicios);
        $cont = 0;

        $servicioAnterior = '';

        for ($i=0; $i <count($servicios) ; $i++) {

            if($servicios[$i]->servicio_id!=$servicioAnterior){

              $servicioActual = DB::table('servicios')->where('id',$servicios[$i]->servicio_id)->first();

              $json = json_decode($servicioActual->pasajeros_ruta);

              if(is_array($json)){
                foreach ($json as $key => $value) {

                  $programa = str_replace('AMP;', '', $value->sub_area);
                  $programa = str_replace('amp;', '', $programa);

                  $update = DB::table('qr_rutas')
                  ->where('servicio_id',$servicioActual->id)
                  ->where('id_usuario',$value->apellidos)
                  ->update([
                      'employ' => $programa,
                      'id_rutaqr' => $value->area
                  ]);

                  if($update){
                    $cont++;
                  }

                }
              }
              $servicioAnterior = $servicios[$i]->servicio_id;
            }
        }

          /*$servicios = "SELECT qr_rutas.id, qr_rutas.id_usuario, servicio_id, qr_rutas.employ, id_rutaqr, servicios.fecha_servicio, servicios.hora_servicio FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '20230701' AND '20230731' AND servicios.centrodecosto_id = 19 AND servicios.pendiente_autori_eliminacion IS NULL and qr_rutas.employ LIKE '%AT&AMP;T DTV SPANISH - BARRANQUILLA%'";
          $servicios = DB::select($servicios);
          $cont = 0;

          foreach ($servicios as $key => $value) {

            $programa = str_replace('AMP;', '', $value->employ);
            $programa = str_replace('amp;', '', $programa);

             $update = DB::table('qr_rutas')
             ->where('servicio_id',$value->servicio_id)
             ->where('id_usuario',$value->id_usuario)
             ->update([
                 'employ' => trim($programa) //'SCHLUMBERGER - OFS' //
             ]);

             if($update){
               $cont++;
             }

          }*/



         return Response::json([
           'respuesta' => true,
           'servicios' => $servicios,
           'cont' => $cont
         ]);

        }

        public function postQuerytarifas() { //Función para crear el pdf de tarifas

          //pdf

          $tarifas = DB::table('portafolio')
          ->where('id',35)
          ->first();

          $html = View::make('reportes.portafolio.test_pdf')->with([
            'nombres' => 'Samuel',
            'tarifas' => $tarifas
          ]);

          $insertedId = 12345;

          $outputName = 'Respuesta_pqr_'.$insertedId; // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
          $pdfPath = 'biblioteca_imagenes/portafoliooo.pdf';
          File::put($pdfPath, PDF::load($html, 'A4', 'portrait')->output());



          $data = [
            'facturas' => 1,
          ];

          $email = 'sistemas@aotour.com.co';

          Mail::send('reportes.portafolio.test', $data, function($message) use ($email, $pdfPath){
            $message->from('no-reply@aotour.com.co', 'Notificaciones Aotour');
            $message->to($email)->subject('Cartera Vencida');
            $message->attach($pdfPath);
            //$message->cc($cc);
          });

          return Response::json([
            'respuesta' => true
          ]);

        }

        public function postQuery3() {

          //$servicios = "SELECT * FROM servicios WHERE id IN(615952,615953,615954,615955,615956,615957,615958,615959,616418,616419,616420,616421,616422,616423,616424,616425,616426,616427,616428,616429,616430,616431,616432,616433)";
          $servicios = DB::table('servicios')
          ->whereIn('id',[617241,617492,617496,617499,617500,617507,617510,617512,617516,617518,617522,617523,617525,617529,617530,617537,617539,617544,618332,618728,618735,618736,619144])
          ->get();

          //"SELECT * FROM servicios WHERE id = 615952";

            foreach ($servicios as $servicio) {

              $json = json_decode($servicio->pasajeros_ruta);
              if(is_array($json)){

                $objArray = [];

                foreach ($json as $key => $value) {

                  $array = [
                    'nombres' => $value->nombres,
                    'apellidos' => $value->apellidos,
                    'cedula' => $value->cedula,
                    'direccion' => $value->direccion,
                    'barrio' => $value->barrio,
                    'cargo' => $value->cargo,
                    'area' => 'RUTA EJECUTADA CON ÉXITO',
                    'sub_area' => $value->sub_area,
                    'hora' => $value->hora
                  ];
                  array_push($objArray, $array);

                }

                //$objArray = json_decode($servicio->pasajeros_ruta);
                $update = DB::table('servicios')
                ->where('id',$servicio->id)
                ->update([
                  'pasajeros_ruta' =>json_encode($objArray)
                ]);
                //$servicio->pasajeros_ruta = json_encode($objArray);

              }
          }

          return Response::json([
            'respuesta' => true,
            'servicios' => $servicios
          ]);

        }

        public function postQueryvencidas() { //FUNCIÓN QUE ENVÍA LOS CORRES DE FACTURAS VENCIDAS

          $email = 'sistemas@aotour.com.co';

          $query = "SELECT ordenes_facturacion.id, ordenes_facturacion.fecha_factura, ordenes_facturacion.fecha_vencimiento, ordenes_facturacion.numero_factura, ordenes_facturacion.centrodecosto_id, ordenes_facturacion.total_facturado_cliente, centrosdecosto.razonsocial FROM ordenes_facturacion LEFT JOIN centrosdecosto ON centrosdecosto.id = ordenes_facturacion.centrodecosto_id WHERE ordenes_facturacion.ingreso IS NULL AND ordenes_facturacion.anulado IS NULL AND ordenes_facturacion.id_siigo IS NOT NULL AND fecha_vencimiento < '".date('Y-m-d')."' ORDER BY centrosdecosto.razonsocial";
          $consulta = DB::select($query);

          //Envío de correos a los clientes
          $clienteAnterior = '';
          $array = [];
          foreach ($consulta as $factura) {

            if($factura->centrodecosto_id!=$clienteAnterior){

              //Envío a cada cliente START
              $factous = "SELECT ordenes_facturacion.id, ordenes_facturacion.fecha_factura, ordenes_facturacion.fecha_vencimiento, ordenes_facturacion.numero_factura, ordenes_facturacion.centrodecosto_id, ordenes_facturacion.total_facturado_cliente, centrosdecosto.razonsocial FROM ordenes_facturacion LEFT JOIN centrosdecosto ON centrosdecosto.id = ordenes_facturacion.centrodecosto_id WHERE ordenes_facturacion.ingreso IS NULL AND ordenes_facturacion.anulado IS NULL AND ordenes_facturacion.id_siigo IS NOT NULL AND ordenes_facturacion.centrodecosto_id = ".$factura->centrodecosto_id." AND fecha_vencimiento < '".date('Y-m-d')."' ORDER BY centrosdecosto.razonsocial ";
              $factous = DB::select($factous);

              $data = [
                'facturas' => $factous
              ];

              //$emailCliente = DB::table('centrosdecosto')->where('id',$factura->centrodecosto_id)->pluck('email');
              $emailCliente = 'aotourdeveloper@gmail.com';

              Mail::send('emails.facturas_vencidas_cliente', $data, function($message) use ($emailCliente, $factura){
                $message->from('no-reply@aotour.com.co', 'Notificaciones Aotour');
                $message->to($emailCliente)->subject('Cartera Vencida a la fecha: '.$factura->razonsocial);
                $message->bcc('b.carrillo@aotour.com.co');
              });
              array_push($array,$factura->centrodecosto_id);
              //Envío a cada cliente INDIVIDUAL

            }

            $clienteAnterior = $factura->centrodecosto_id;

          }
          //Fin envío de correos a los clientes

          $data = [
            'contacto' => $email,
            'facturas' => $consulta
          ];

          //$emails = 'sistemas@aotour.com.co';
          $emails = ['contabilidad@aotour.com.co','b.carrillo@aotour.com.co', 'comercial@aotour.com.co'];

          Mail::send('emails.facturas_vencidas', $data, function($message) use ($emails){
            $message->from('no-reply@aotour.com.co', 'AUTONET - Cartera Vencida');
            $message->to($emails)->subject('Relación de facturas vencidas que no tienen ingreso en Siigo');
            $message->bcc('sistemas@aotour.com.co');
          });

          return Response::json([
            'respuesta' => true
          ]);

        }

        public function postQueryreal() {

          /*$query = "SELECT DISTINCT id_usuario FROM qr_rutas  LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE qr_rutas.fecha BETWEEN '20230616' AND '20230630' AND servicios.centrodecosto_id = 19 AND servicios.pendiente_autori_eliminacion IS NULL ";
          $consulta = DB::select($query);*/

          /*$servicio_email = Servicio::find(613013);

          $query_servicio = Servicio::select('servicios.*', 'servicios.fecha_servicio', 'servicios.fecha_solicitud','servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.hora_servicio', 'servicios.pasajeros', 'centrosdecosto.razonsocial', 'vehiculos.clase', 'vehiculos.placa', 'vehiculos.color', 'vehiculos.marca', 'vehiculos.modelo', 'conductores.nombre_completo', 'conductores.celular')
          ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
          ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
          ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
          ->where('servicios.id',$servicio_email->id)
          ->get();

          $solicitado = date('d-m-Y', strtotime($servicio_email->fecha_servicio));

          $data = [
            'id_servicio' => 613054,
            'servicio' => $servicio_email,
            'servicios' => $query_servicio,
            'fecha_solicitud' => $solicitado,
            'solicitante' => $servicio_email->solicitado_por
          ];

          $correoUpdate = 'sistemas@aotour.com.co';
          //$cc = ['transportebogota@aotour.com.co','comercial@aotour.com.co', 'servicioalcliente@aotour.com.co'];
          $cc = 'aotourdeveloper@gmail.com';

          Mail::send('servicios.emails.plantilla', $data, function($message) use ($correoUpdate, $cc){
            $message->from('no-reply@aotour.com.co', 'Notificaciones Aotour');
            $message->to($correoUpdate)->subject('Programación de Servicio');
            $message->bcc($cc);
          });*/

          $ciudad = Input::get('ciudad');
          $messess = Input::get('mes');
          //VARIABLES LOCALES
          $fechaInicial = '2023-11-01';
          $fechaFinal = '2023-11-30';
          $cliente = 19; //Input::get('cliente');// 19;
          //VARIABLE GLOBALES

          //CÁLCULO DE VALOR FACTURA DE RUTAS START
          $cantidadderutas = "SELECT servicios.id, facturacion.unitario_cobrado FROM servicios LEFT JOIN facturacion ON facturacion.servicio_id = servicios.id WHERE servicios.fecha_servicio BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' AND servicios.centrodecosto_id = ".$cliente." AND servicios.subcentrodecosto_id = 101 AND servicios.pendiente_autori_eliminacion IS NULL and servicios.ruta is not null ";
          $cantidadderutas = DB::select($cantidadderutas);
          $contadordeRutas = 0;
          foreach ($cantidadderutas as $ruta) {
            $contadordeRutas = $contadordeRutas+$ruta->unitario_cobrado;
          }
          //CÁLCULO DE VALOR DE FACTURA DE RUTAS END

          $costoFactura = $contadordeRutas;

          $samu = DB::table('qr_rutas')
          ->leftJoin('servicios', 'servicios.id', '=', 'qr_rutas.servicio_id')
          ->select('qr_rutas.id', 'qr_rutas.fecha', 'qr_rutas.employ', 'qr_rutas.id_rutaqr')
          ->whereBetween('fecha_servicio',[$fechaInicial,$fechaFinal])
          ->where('servicios.centrodecosto_id',$cliente)
          ->where('servicios.subcentrodecosto_id', 101)
          ->whereNotNull('employ')
          ->whereNotNull('id_rutaqr')
          ->whereNull('servicios.pendiente_autori_eliminacion')
          ->get();

          $tot = count($samu);
          $costoUnitario = $tot;

          $costoUnitario = floatval($costoFactura)/floatval($costoUnitario);
          $costoUnitario = round($costoUnitario, 2);

          $arrayNovedades = [];

          //CONSULTA DE DIFERENTES TIPOS DE NOVEDADES
          $sql = "SELECT DISTINCT id_rutaqr FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' AND servicios.centrodecosto_id = ".$cliente." AND servicios.subcentrodecosto_id = 101 AND servicios.pendiente_autori_eliminacion IS NULL and qr_rutas.employ is not null and id_rutaqr is not null ";
          $novs = DB::select($sql);
          foreach ($novs as $novedad) {

            $users = "SELECT DISTINCT qr_rutas.id FROM qr_rutas  LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' AND servicios.centrodecosto_id = ".$cliente." AND servicios.subcentrodecosto_id = 101 AND qr_rutas.employ is not null AND servicios.pendiente_autori_eliminacion IS NULL and id_rutaqr = '".$novedad->id_rutaqr."' ";
            $novs = DB::select($users);
            $totalesNovedad = count($novs)*floatval($costoUnitario);

            $porcentajes = 100*floatval(count($novs))/$tot;

            $array = [
                'costo' => round($totalesNovedad, 2),
                'novedad' => $novedad->id_rutaqr,
                'cantidad' => count($novs),
                'porcentaje' => round($porcentajes, 2),
                'creado' => date('Y-m-d H:i'),
            ];

            array_push($arrayNovedades, $array);

          }
          //CONSULTA DE DIFERENTES TIPOS DE NOVEDADES

          //CONSULTA DE CAMPAÑAS
          $query = "SELECT DISTINCT employ FROM qr_rutas  LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' AND servicios.centrodecosto_id = ".$cliente." AND servicios.subcentrodecosto_id = 101 AND servicios.pendiente_autori_eliminacion IS NULL AND qr_rutas.employ is not null and id_rutaqr is not null ";
          $programas = DB::select($query);

          $arrayCostos = [];
          $arrayNovedad = [];
          $arrayExitosas = [];

          //$tot = count(DB::table('qr_rutas')->whereBetween('fecha',['20230626','20230626'])->whereNotNull('employ')->get());
          //$costoUnitario = $tot;

          //$costoUnitario = 6419900/floatval($costoUnitario);
          //$costoUnitario = round($costoUnitario, 2);

          $no_transport = "SELECT DISTINCT qr_rutas.id FROM qr_rutas  LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' AND servicios.centrodecosto_id = ".$cliente." AND servicios.subcentrodecosto_id = 101 AND servicios.pendiente_autori_eliminacion IS NULL and employ is not null and id_rutaqr = 'NO SE PRESENTÓ'";
          $no_transport = DB::select($no_transport);
          $no_transport = count($no_transport);//NO SE PRESENTÓ

          $si_transport = "SELECT DISTINCT qr_rutas.id FROM qr_rutas  LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' AND servicios.centrodecosto_id = ".$cliente." AND servicios.subcentrodecosto_id = 101 AND servicios.pendiente_autori_eliminacion IS NULL and employ is not null and id_rutaqr = 'RUTA EJECUTADA CON ÉXITO'";
          $si_transport = DB::select($si_transport);
          $si_transport = count($si_transport);//EJECUTADA CON ÉXITO

          $totalNoTransportado = floatval($costoUnitario)*$no_transport;
          $totalNoTransportado = round($totalNoTransportado, 2);

          foreach ($programas as $programa) {

            $querys = "SELECT DISTINCT qr_rutas.id FROM qr_rutas  LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' AND servicios.centrodecosto_id = ".$cliente." AND servicios.subcentrodecosto_id = 101 AND servicios.pendiente_autori_eliminacion IS NULL and id_rutaqr is not null and employ is not null and employ = '".$programa->employ."'";
            $consultas = DB::select($querys);
            $totalC = count($consultas)*floatval($costoUnitario);
            $costoN = 0;

            $porcent = 100*floatval(count($consultas))/$tot;

            $array = [
                'costo' => round($totalC, 2),
                'campana' => $programa->employ,
                'cantidad' => count($consultas),
                'porcentaje' => round($porcent, 2),
                'creado' => date('Y-m-d H:i'),
            ];

            array_push($arrayCostos, $array);

            //Costos por campaña; NO SE PRESENTÓ
            $querysss = "SELECT DISTINCT qr_rutas.id FROM qr_rutas  LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' AND servicios.centrodecosto_id = ".$cliente." AND servicios.subcentrodecosto_id = 101 AND servicios.pendiente_autori_eliminacion IS NULL and id_rutaqr is not null and employ = '".$programa->employ."' and id_rutaqr = 'NO SE PRESENTÓ'";
            $consultass = DB::select($querysss);

            $totalN = count($consultass)*floatval($costoUnitario);
            $costoN = 0;
            if($consultass){
              $porcents = 100*floatval(count($consultass))/$no_transport;
            }else{
              $porcents = 0;
            }

            $arrays = [
                'costo' => round($totalN, 2),
                'campana' => $programa->employ,
                'cantidad' => count($consultass),
                'porcentaje' => round($porcents, 2),
                'creado' => date('Y-m-d H:i'),
            ];

            array_push($arrayNovedad, $arrays);
            //Costos por campaña; NO SE PRESENTÓ

            //Costos por campaña; RUTAS EXITOSAS
            $exitosasQuery = "SELECT DISTINCT qr_rutas.id FROM qr_rutas  LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' AND servicios.centrodecosto_id = ".$cliente." AND servicios.subcentrodecosto_id = 101 AND servicios.pendiente_autori_eliminacion IS NULL and id_rutaqr is not null and employ = '".$programa->employ."' and id_rutaqr = 'RUTA EJECUTADA CON ÉXITO'";
            $exitosasSelect = DB::select($exitosasQuery);

            $totalE = count($exitosasSelect)*floatval($costoUnitario);
            $costoE = 0;
            if($exitosasSelect){
              $porcentss = 100*floatval(count($exitosasSelect))/$si_transport;
            }else{
              $porcentss = 0;
            }

            $arraysE = [
                'costo' => round($totalE, 2),
                'campana' => $programa->employ,
                'cantidad' => count($exitosasSelect), //ok
                'porcentaje' => round($porcentss, 2), //ok
                'creado' => date('Y-m-d H:i'), //ok
            ];

            array_push($arrayExitosas, $arraysE);
            //Costos por campaña; RUTAS EXITOSAS

          } //Fin de costos por campaña

          //START CALCULO DE MES Y AÑO
          $fech = explode('-', $fechaInicial);

          $mes = $fech[1];
          $ano = $fech[0];

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
          }//END CÁLCULO DE MES AÑO

          $dash = new Dash;
          $dash->cliente = $cliente;
          $dash->fecha_inicial = $fechaInicial;
          $dash->fecha_final = $fechaFinal;
          $dash->rutas_exitosas = json_encode($arrayExitosas);
          $dash->costos_novedades = json_encode($arrayNovedades);
          $dash->costos_campana = json_encode($arrayCostos);
          $dash->costos_novedad = json_encode($arrayNovedad);
          $dash->costo_total = $costoFactura;
          $dash->costos_no_transportado = $totalNoTransportado;
          $dash->mes = $mes;
          $dash->ano = $ano;
          $dash->creado_por = Sentry::getUser()->id;
          $dash->save();

          //CONSULTA DE CAMPAÑAS

          //$query = "SELECT DISTINCT id_usuario FROM qr_rutas  LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE qr_rutas.fecha BETWEEN '20230616' AND '20230630' AND servicios.centrodecosto_id = 19 AND servicios.pendiente_autori_eliminacion IS NULL ";
          //$consulta = DB::select($query);

          //CONSULTA DE AMONESTADOS
          $search = "SELECT DISTINCT id_usuario, fullname, employ FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' AND servicios.centrodecosto_id = ".$cliente." AND servicios.subcentrodecosto_id = 101 AND servicios.pendiente_autori_eliminacion IS NULL and qr_rutas.employ is not null and id_rutaqr = 'NO SE PRESENTÓ'";
          $consult = DB::select($search);

          foreach ($consult as $key) {

            $amonestadosQuery = "SELECT qr_rutas.id FROM qr_rutas  LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' AND servicios.centrodecosto_id = ".$cliente." AND servicios.subcentrodecosto_id = 101 AND servicios.pendiente_autori_eliminacion IS NULL and employ is not null and id_usuario = '".$key->id_usuario."' and id_rutaqr = 'NO SE PRESENTÓ'";
            $amonestadosSelect = DB::select($amonestadosQuery);
            $totalAmonestados = count($amonestadosSelect);

            if($totalAmonestados>0){

              $amonestado = new Amonestados;
              $amonestado->programa = $key->employ;
              $amonestado->id_usuario = $key->id_usuario;
              $amonestado->nombre_usuario = $key->fullname;
              $amonestado->cantidad = $totalAmonestados;
              $amonestado->centrodecosto = $cliente;
              $amonestado->ciudad = null;
              $amonestado->id_reporte = $dash->id;
              $amonestado->save();

            }

          }

          //Envío de Mail
          $data = [
            'sede' => 'BARRANQUILLA',
            'mes' => $mes
          ];

          //$email = 'sistemas@aotour.com.co';
          //$email = ['luis.torres@sutherlandglobal.com','elimir.ramos@sutherlandglobal.com'];
          $email = ['javier.cristancho@sutherlandglobal.com','ariel.arteta@sutherlandglobal.com'];

          Mail::send('emails.dashboard_generado', $data, function($message) use ($email){
            $message->from('no-reply@aotour.com.co', 'Notificaciones Aotour');
            $message->to($email)->subject('Reporte Dashboard');
            //$message->bcc('dcoba@aotour.com.co');
            //$message->attach($pdfPath);
            //$message->cc($cc);
          });
          //Envío de Mail

          return Response::json([
            'respuesta' => true,
            'consulta' => $programas,
            'costoUnitario' => $costoUnitario,
            'tot' => $tot,
            'tots' => $no_transport,
            'arrayExitosas' => $arrayExitosas,
            'arrayCostos' => $arrayCostos,
            'arrayNovedad' => $arrayNovedad,
            'arrayNovedades' => $arrayNovedades,
            'no_transport' => $no_transport,
            'totalNoTransportado' => $totalNoTransportado,
            'contadordeRutas' => $contadordeRutas
          ]);

        }

        public function postFiltro() {

          $mes = Input::get('mes');
          $mesText = Input::get('mesText');
          $cliente = Input::get('cliente');

          $mesActual = date('m');

          $inicio = '01';

          if($mes == '1'){
            $fin = '31';
          }else if($mes == '2'){
            $fin = '28';
          }else if($mes == '3'){
            $fin = '31';
          }else if($mes == '4'){
            $fin = '30';
          }else if($mes == '5'){
            $fin = '31';
          }else if($mes == '6'){
            $fin = '30';
          }else if($mes == '7'){
            $fin = '31';
          }else if($mes == '8'){
            $fin = '31';
          }else if($mes == '9'){
            $fin = '30';
          }else if($mes == '10'){
            $fin = '31';
          }else if($mes == '11'){
            $fin = '30';
          }else if($mes == '12'){
            $fin = '31';
          }

          if($mes<'10'){
            $mes = '0'.$mes;
          }

          $fechaInicial = '2024'.$mes.$inicio; //falta
          $fechaFinal = '2024'.$mes.$fin; //falta

          $arrayDias = [];

          if($mesActual==$mes){
            $stil = $mes-1;
            $actual = 'on';
          }else{
            $stil = $fin;
            $actual = 'off';
          }

          for($i = $stil; $i>=1; $i--){

            //Fecha
            $day = $i;
            if($i<10){
              $day = '0'.$i;
            }
            $date = '2024-'.$mes.'-'.$day;
            $fech = str_replace('-', '', $date);
            //Fecha

            //Fecha y Hora de envío
            $know = DB::table('report')
            ->where('cliente',$cliente)
            ->where('fecha',$fech)
            ->first();
            //Fecha y Hora de envío



            if($cliente==19){
              $link = 'revisionnovedadesbarranquilla/'.$fech.'';
              $city = 'BARRANQUILLA';
            }else{
              $link = 'revisionnovedadesbogota/'.$fech.'';
              $city = 'BOGOTÁ';
            }

            if($know!=null){
              $fecha_envio = $know->fecha_created;
              $hora_envio = $know->hora_created;
              $estado = $know->descargado;
              $ciudad = $city;
              $ver = true;
              $sw = 1;
            }else{
              $fecha_envio = '';
              $hora_envio = '';
              $estado = 'NO ENVIADO';
              $ciudad = $city;
              $ver = '';
              $sw = 0;
            }

            $array = [
                'fecha' => $date,
                'fecha_envio' => $fecha_envio,
                'hora_envio' => $hora_envio,
                'estado' => $estado,
                'ciudad' => $ciudad,
                'ver' => $ver,
                'link' => $link,
                'sw' => $sw,
            ];

            array_push($arrayDias, $array);
          }

          //START CONSULTA DE VISTA DEL DASHBOARD
          $dashboard = DB::table('dash')
          ->where('cliente',$cliente)
          ->where('mes',$mesText)
          ->first();
          //END CONSULTA DE VISTA DEL DASHBOARD

          return Response::json([
            'respuesta' => true,
            'dashboard' => $dashboard,
            'mes' => $mes,
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'arrayDias' => $arrayDias,
            'cc' => $cliente,
            'mesActual' => $mesActual,
            'actual' => $actual
          ]);

        }

      public function postDatas() {

        $search = DB::table('dash')
        ->where('id',Input::get('id'))
        ->first();

        //$noexitosas = $search->rutas_exitosas

        $exitosas = json_decode($search->rutas_exitosas);
        arsort($exitosas);

        return Response::json([
          'respuesta' => true,
          'dash' => $search,
          'exitosas' => $exitosas,
          'noexitosas' => null
        ]);

      }

      public function postData() {

        $servicios = DB::table('servicios')
        ->where('fecha_servicio','2023-05-28')
        ->whereNotNull('ruta')
        ->where('centrodecosto_id',19)
        ->get();

        $REMITLY_CET_IS_BAQ = 0;

        for ($i=0; $i <count($servicios) ; $i++) {
          $json = json_decode($servicios[$i]->pasajeros_ruta);

          if(is_array($json)){
            foreach ($json as $key => $value) {

              if($value->sub_area=='REMITLY CET IS BAQ'){
                //$campanas = DB::table('pasajeros')
                $REMITLY_CET_IS_BAQ++;
              }

            }
          }
        }

        $pasajeros = null;

        return Response::json([
          'respuesta' => true,
          'pasajeros' => $pasajeros,
          'servicios' => $servicios,
          'REMITLY_CET_IS_BAQ' => $REMITLY_CET_IS_BAQ
        ]);

      }

  public function getNovedades($id){

        if (Sentry::check()){
            $id_rol = Sentry::getUser()->id_rol;
            $centrodecosto_id = Sentry::getUser()->centrodecosto_id;
            $cliente = DB::table('centrosdecosto')->where('id',$centrodecosto_id)->pluck('razonsocial');
            $idusuario = Sentry::getUser()->id;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
            $ver = $permisos->portalusuarios->admin->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on') {
            return View::make('admin.permisos');
        }else{

          $reporte = DB::table('report')
          ->where('id',$id)
          ->first();

          $servicios = DB::table('servicios')
          ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
          ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
          ->leftJoin('proveedores', 'proveedores.id', '=', 'servicios.proveedor_id')
          ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
          ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
          ->select('servicios.*', 'vehiculos.capacidad', 'vehiculos.placa', 'centrosdecosto.razonsocial as razoncentro', 'subcentrosdecosto.nombresubcentro', 'proveedores.razonsocial', 'conductores.nombre_completo')
          //->where('servicios.fecha_servicio',$undia)
          ->where('servicios.hora_servicio', '>=', '20:00')
          //->where('servicios.centrodecosto_id',$cliente)
          ->where('servicios.ruta',1)
          ->orderby('servicios.hora_servicio')
          ->get();

          $servicios = DB::table('servicios')
          ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
          ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
          ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
          ->where('servicios.fecha_servicio',$reporte->fecha)
          //->where('servicios.hora_servicio', '>=', '20:00')
          ->where('servicios.centrodecosto_id',$reporte->cliente)
          ->where('servicios.ruta',1)
          ->orderby('servicios.hora_servicio')
          ->get();

        $pasajeros = DB::table('pasajeros')->where('centrodecosto_id',$centrodecosto_id)->get();
        return View::make('portalusuarios.admin.listado.novedades')
        ->with('idusuario',$idusuario)
        ->with('fecha',$reporte->fecha)
        ->with('cc',$reporte->cliente)
        ->with('cliente',$cliente)
        ->with('permisos',$permisos)
        ->with('centrodecosto_id',$centrodecosto_id)
        ->with('servicios', $servicios)
        ->with('pasajeros',$pasajeros);
        }
    }

    public function getUsuariosderuta() {

      $usuarios = DB::table('pasajeros_rutas')
      ->orderBy('id', 'asc')
      ->get();

      return View::make('autogestion.usuarios')
        ->with('servicios', 4)
        ->with('servicios', 3)
        ->with('servicios', 2)
        ->with('servicios', 1)
        ->with('usuarios',$usuarios);
    }

    public function getEntradas() {

      $usuarios = DB::table('pasajeros_rutas')
      ->orderBy('id', 'asc')
      ->get();

      return View::make('autogestion.usuarios')
        ->with('servicios', 4)
        ->with('servicios', 3)
        ->with('servicios', 2)
        ->with('servicios', 1)
        ->with('usuarios',$usuarios);
    }

    public function getSalidas() {

      $usuarios = DB::table('pasajeros_rutas')
      ->where('estado',1)
      ->orderBy('id', 'asc')
      ->get();

      return View::make('autogestion.salidas')
        ->with('servicios', 4)
        ->with('servicios', 3)
        ->with('servicios', 2)
        ->with('servicios', 1)
        ->with('usuarios',$usuarios);
    }

    public function postSolicitarrutas() {

      $nueva = new RutasSolicitadas;
      $nueva->fecha = Input::get('fecha');
      $nueva->solicitado_por = Sentry::getUser()->id;
      $nueva->cantidad_usuarios = Input::get('cantidad_usuarios');
      $nueva->cliente = Sentry::getUser()->centrodecosto_id;
      $nueva->ciudad = Sentry::getUser()->localidad;
      if(Input::get('tipo_ruta')==1) {
        $nueva->tipo_ruta = 1;
      }
      $nueva->save();

      $idArray = Input::get('idArray');
      $horaArray = Input::get('horaArray');

      for ($i=0; $i < count($idArray); $i++) { 
        
        $usuarioProgramado = new UsuariosProgramados;
        $usuarioProgramado->pasajero_id = $idArray[$i];
        $usuarioProgramado->solicitud_id = $nueva->id;
        $usuarioProgramado->hora = $horaArray[$i];
        $usuarioProgramado->save();

      }

      return Response::json([
        'response' => true
      ]);

    }

    public function getSalidassolicitadas() {

      $usuarios = DB::table('rutas_solicitadas')
      ->leftJoin('users', 'users.id', '=', 'rutas_solicitadas.solicitado_por')
      ->select('rutas_solicitadas.*', 'users.first_name', 'users.last_name')
      ->where('solicitado_por',Sentry::getUser()->id)
      ->orderBy('id', 'asc')
      ->get();

      return View::make('autogestion.salidas_solicitadas')
        ->with('servicios', 4)
        ->with('servicios', 3)
        ->with('servicios', 2)
        ->with('servicios', 1)
        ->with('usuarios',$usuarios);
    }

    public function getSalidassolicitadass($id) {

      $usuarios = DB::table('usuarios_programados')
      ->leftJoin('rutas_solicitadas', 'rutas_solicitadas.id', '=', 'usuarios_programados.solicitud_id')
      ->leftJoin('pasajeros_rutas', 'pasajeros_rutas.id', '=', 'usuarios_programados.pasajero_id')
      ->select('pasajeros_rutas.*', 'usuarios_programados.hora as horario', 'rutas_solicitadas.fecha')
      ->where('rutas_solicitadas.id',$id)
      ->orderBy('id', 'asc')
      ->get();

      $request = DB::table('rutas_solicitadas')
      ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'rutas_solicitadas.cliente')
      ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'rutas_solicitadas.campana')
      ->leftJoin('users', 'users.id', '=', 'rutas_solicitadas.solicitado_por')
      ->select('rutas_solicitadas.*', 'centrosdecosto.id as centro_id', 'subcentrosdecosto.id as subcentro_id', 'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro', 'users.first_name', 'users.last_name')
      ->where('id',$id)
      ->first();

      $conductores = "select id, nombre_completo, bloqueado, bloqueado_total from conductores where bloqueado is null and bloqueado_total is null";
      $conductores = DB::select($conductores);

      $rutas = DB::table('nombre_ruta')->get();

      return View::make('autogestion.salidas_solicitadass')
      ->with('request', $request)
      ->with('conductores', $conductores)
      ->with('rutas', $rutas)
      ->with('usuarios',$usuarios);
    }

    public function postDocumentacionconductor(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          if (Request::ajax()) {

            /**
             * Para restringir a los conductores de la seguridad social toca tomar
             * la seguridad social del mes pasado y la seguridad social del mes actual y
             * adicional a eso tomar que solo pida la seguridad social del mes actual siempre y cuando
             * el dia del mes sea igual o mayor a 7
             *
             */

           if(Input::get('ruta_fecha_servicio')!=null){
             $fecha = Input::get('ruta_fecha_servicio');
           }else{
             $fecha = date('Y-m-d');
           }
            $conductor = Conductor::find(Input::get('id'));

            //$dia_mes = date('d');
            $dia_mes = date('d-');

            //Si el dia del mes es mayor o igual a 7 entonces buscar si hay un registro de seguridad social para el mes actual
            //if ($dia_mes>=7) {
            $date = date('Y-m-d');

            $seguridad_social = "select pago, fecha_inicial, fecha_final from seguridad_social where conductor_id = ".Input::get('id')." and '".$fecha."' between fecha_inicial and fecha_final ";
            $seguridad_social = DB::select($seguridad_social);

            if($seguridad_social!=null){
              foreach ($seguridad_social as $seg) {
                $value = $seg->pago;
              }
            }else{
              $value = null;
            }

            //}else if($dia_mes<7){

              /**
               *  Si el dia del mes es menor que 7 entonces revisar que haya seguridad social para el mes pasado.
               *  Si el mes es enero entonces debe restar un año y tomar el ano pasado y el mes 12
              */
            /*  if (date('m')==1) {

                $seguridad_social = Seguridadsocial::where('conductor_id', Input::get('id'))
                ->where('ano', date('Y')-1)
                ->where('mes', 12)
                ->pluck('pago');

              }else {

                $seguridad_social = Seguridadsocial::where('conductor_id', Input::get('id'))
                ->where('ano',date('Y'))
                ->where('mes', intval(date('m'))-1)
                ->pluck('pago');

              }

            }*/

            $vehicle = null;
            $licencia_conduccion = null;
            $dias_examen_ultimo = null;
            $fecha_examen_ultimo = null;

            if($conductor) {

              $licencia_conduccion = floor((strtotime($conductor->fecha_licencia_vigencia)-strtotime($fecha))/86400);

              $cond_examenes = DB::table('conductor_examenes')->where('conductor_id',Input::get('id'))
              ->orderBy('fecha_examen', 'desc')
              ->whereNull('anulado')->get();

              if($cond_examenes){
                  $fecha_examen_ultimo = $cond_examenes[0]->fecha_examen;
                  $dias_examen_ultimo = $cond_examenes[0]->fecha_examen;
                  $dias_examen_ultimo = floor((strtotime($dias_examen_ultimo)-strtotime($fecha))/86400);
              }else{
                    $dias_examen_ultimo = null;
                    $fecha_examen_ultimo = null;
              }

            }else{
              $array = [
                'respuesta'=>false
              ];

              return Response::json($array);
            }

            $vehiculo_conductor_pivot = VehiculoConductorPivot::where('conductor_id', Input::get('id'))->get();

            $array = [
              'respuesta'=>true,
              'conductor'=>$conductor,
              'vehiculo_conductor_pivot' => $vehiculo_conductor_pivot,
              'licencia_conduccion' => $licencia_conduccion,
              'seguridad_social' => $value,
              'dias_examen_ultimo' => $dias_examen_ultimo,
              'fecha_examen_ultimo' => $fecha_examen_ultimo,
              'ohhh' => $fecha
            ];

            return Response::json($array);
          }
      }
    }

    public function postDocumentacionvehiculo(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          if (Request::ajax()) {

            //$vehiculo = Vehiculo::where('id', Input::get('id'))->with(['restriccionvehiculo'])->first();

            $vehiculo = Vehiculo::where('id', Input::get('id'))->with(['restriccionvehiculo' => function ($query) {
                $query->whereRaw("DATEDIFF(restriccion_vehiculos.fecha_vencimiento, now()) >= 0 and (restriccion_vehiculos.check is null or restriccion_vehiculos.check = 'off')");
            }])->first();

            $administracion = Administracion::where('vehiculo_id', Input::get('id'))
            ->where('ano',date('Y'))
            ->where('mes',date('m'))
            ->pluck('pago');

            $fecha_vigencia_operacion = Vehiculo::calculoCantidadDias($vehiculo->fecha_vigencia_operacion,Input::get('ruta_fecha_servicio'));
            $fecha_vigencia_soat = Vehiculo::calculoCantidadDias($vehiculo->fecha_vigencia_soat,Input::get('ruta_fecha_servicio'));
            $fecha_vigencia_tecnomecanica = Vehiculo::calculoCantidadDias($vehiculo->fecha_vigencia_tecnomecanica,Input::get('ruta_fecha_servicio'));
            $mantenimiento_preventivo = Vehiculo::calculoCantidadDias($vehiculo->mantenimiento_preventivo,Input::get('ruta_fecha_servicio'));
            $poliza_contractual = Vehiculo::calculoCantidadDias($vehiculo->poliza_contractual,Input::get('ruta_fecha_servicio'));
            $poliza_extracontractual = Vehiculo::calculoCantidadDias($vehiculo->poliza_extracontractual,Input::get('ruta_fecha_servicio'));

            return Response::json([
              'respuesta' => true,
              'vehiculo' => $vehiculo,
              'administracion'=> $administracion,
              'fecha_vigencia_operacion' => $fecha_vigencia_operacion,
              'fecha_vigencia_soat' => $fecha_vigencia_soat,
              'fecha_vigencia_tecnomecanica' => $fecha_vigencia_tecnomecanica,
              'mantenimiento_preventivo' => $mantenimiento_preventivo,
              'poliza_contractual' => $poliza_contractual,
              'poliza_extracontractual' => $poliza_extracontractual,
              'prueba' => Input::get('ruta_fecha_servicio')
            ], 200);

          }

      }

    }

    public function postLocalidades() {

      $id = Input::get('id');

      $solicitud = DB::table('rutas_solicitadas')
      ->where('id',$id)
      ->first();

      $localidades = DB::table('localidades')
      ->where('ciudad',$solicitud->ciudad)
      ->where('centrodecosto', $solicitud->cliente)
      ->where('subcentrodecosto',$solicitud->campana)
      ->get();

      return Response::json([
        'response' => true,
        'localidades' => $localidades,
        'tipo' => $solicitud->tipo_ruta,
        'descp' => $solicitud->descripcion
      ]);

    }

    public function postMostrarconductoresyvehiculos(){

      if(Request::ajax()){

        $search = DB::table('conductores')
        ->select('id', 'proveedores_id')
        ->where('id',Input::get('proveedores_id'))
        ->first();

        if(isset($search)) {
          $id = $search->proveedores_id;
        }else{
          $id = 0;
        }

        $vehiculos = "select id, placa, clase, marca, modelo, bloqueado, bloqueado_total from vehiculos where proveedores_id = ".$id." and bloqueado is null and bloqueado_total is null";
        $vehiculos = DB::select($vehiculos);
        

        if($vehiculos){

          return Response::json([
            'mensaje' => true,
            'vehiculos' => $vehiculos,
          ]);

        }else{

          return Response::json([
            'mensaje' => false
          ]);

        }
      }
    }

    public function postConductoresyvehiculos() {

      $conductores = "select conductores.id, conductores.nombre_completo, conductores.bloqueado, conductores.bloqueado_total, conductores.proveedores_id, proveedores.inactivo, proveedores.inactivo_total, proveedores.localidad from conductores left join proveedores on proveedores.id = conductores.proveedores_id where proveedores.localidad in ('PROVISIONAL','BOGOTA') and conductores.bloqueado is null and conductores.bloqueado_total is null and proveedores.inactivo is null and proveedores.inactivo_total is null order by conductores.nombre_completo";
      $conductores = DB::select($conductores);

      $vehiculos = "select vehiculos.id, vehiculos.placa, vehiculos.bloqueado, vehiculos.bloqueado_total, vehiculos.proveedores_id, proveedores.inactivo, proveedores.inactivo_total, proveedores.localidad from vehiculos left join proveedores on proveedores.id = vehiculos.proveedores_id where proveedores.inactivo is null and proveedores.inactivo_total is null and vehiculos.bloqueado is null and vehiculos.bloqueado_total is null";
      $vehiculos = DB::select($vehiculos);

      return Response::json([
        'respuesta' => true,
        'conductores' => $conductores,
        'vehiculos' => $vehiculos
      ]);

    }

    public function postNuevousuario() {

      $id_empleado = Input::get('id_empleado');
      $nombres = Input::get('nombres');
      $apellidos = Input::get('apellidos');
      $telefono = Input::get('telefono');
      $horario_entrada = Input::get('horario_entrada');
      $horario_salida = Input::get('horario_salida');
      $direccion = Input::get('direccion');
      $barrio = Input::get('barrio');
      $localidad = Input::get('localidad');
      $latitude = Input::get('latitude');
      $longitude = Input::get('longitude');
      $programa = Input::get('programa');

      $usuario = new PasajeroRuta;
      $usuario->nombres = strtoupper($nombres);
      $usuario->apellidos = strtoupper($apellidos);
      $usuario->id_empleado = $id_empleado;
      $usuario->horario_entrada = $horario_entrada;
      $usuario->horario_salida = $horario_salida;
      $usuario->estado = 1;
      $usuario->telefono = $telefono;
      $usuario->direccion = strtoupper($direccion);
      $usuario->barrio = strtoupper($barrio);
      $usuario->localidad = strtoupper($localidad);
      $usuario->latitude = $latitude;
      $usuario->longitude = $longitude;
      $usuario->programa = Sentry::getUser()->empresa;
      $usuario->creado_por = Sentry::getUser()->id;
      $usuario->save();

      return Response::json([
        'response' => true
      ]);

    }

    public function postExportarprogramacion(){

      if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

        $id = Input::get('id_reporte');
        $fecha = Input::get('fecha_reporte');

              ob_end_clean();
              ob_start();
              Excel::create('Programación_'.$fecha.'', function($excel) use ($id, $fecha){

                  $excel->sheet('hoja', function($sheet) use ($id, $fecha){

                    $usuarios = DB::table('usuarios_programados')
                    ->leftJoin('rutas_solicitadas', 'rutas_solicitadas.id', '=', 'usuarios_programados.solicitud_id')
                    ->leftJoin('pasajeros_rutas', 'pasajeros_rutas.id', '=', 'usuarios_programados.pasajero_id')
                    ->select('pasajeros_rutas.*', 'usuarios_programados.hora as horario', 'rutas_solicitadas.fecha')
                    ->where('rutas_solicitadas.id',$id)
                    ->orderBy('id', 'asc')
                    ->get();

                    $request = DB::table('rutas_solicitadas')
                    ->where('id',$id)
                    ->first();

                    /*if ($value->cantidad==0){

                      $arrayIP = [];
                      array_push($arrayIP, [
                        'IP' => Methods::getRealIpAddr(),
                        'TIME' => date('Y-m-d H:i:s')
                      ]);
                      $jsonIP = json_encode($arrayIP);

                    }else{

                      $arrayIP = json_decode($value->jsonIP);
                      array_push($arrayIP, [
                        'IP' => Methods::getRealIpAddr(),
                        'TIME' => date('Y-m-d H:i:s')
                      ]);

                      $jsonIP = json_encode($arrayIP);
                    }

                    $updateReport = DB::table('report')
                    ->where('id',$id_reporte)
                    ->update([
                      'descargado' => 1,
                      'cantidad' => intval($value->cantidad)+1,
                      'jsonIP' => $jsonIP
                    ]);*/

                    $updateReport = DB::table('rutas_solicitadas')
                    ->where('id',$id)
                    ->update([
                      'descargado' => 1,
                      'cantidad' => intval($request->cantidad)+1
                    ]);

                    $sheet->loadView('autogestion.plantilla_pasajeros')
                    ->with([
                      'usuarios'=>$usuarios
                    ]);


                    $objDrawing = new PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath('biblioteca_imagenes/logos.png');
                    $objDrawing->setCoordinates('B2');
                    $objDrawing->setResizeProportional(false);
                    $objDrawing->setWidth(120);
                    $objDrawing->setHeight(30);
                    $objDrawing->setWorksheet($sheet);

                  });
                })->download('xls');
            
            
        }
    }

    public function postActualizarusuario() {

      $id = Input::get('id');

      $id_empleado = Input::get('id_empleado');
      $nombres = Input::get('nombres');
      $apellidos = Input::get('apellidos');
      $telefono = Input::get('telefono');
      $horario_entrada = Input::get('horario_entrada');
      $horario_salida = Input::get('horario_salida');

      $usuario = PasajeroRuta::find($id);
      $usuario->nombres = $nombres;
      $usuario->apellidos = $apellidos;
      $usuario->id_empleado = $id_empleado;
      $usuario->horario_entrada = $horario_entrada;
      $usuario->horario_salida = $horario_salida;
      $usuario->telefono = $telefono;
      $usuario->save();

      return Response::json([
        'response' => true
      ]);

    }

    public function postEstadousuario() {

      $usuario = PasajeroRuta::find(Input::get('user_id'));
      $usuario->estado = intval(Input::get('value'));
      $usuario->save();

      return Response::json([
        'response' => true
      ]);

    }

    public function postGuardarp(){ //GUARDADO DE PROVEEDOR

      $nombre_proveedor = Input::get('nombre_proveedor');
      $cc_proveedor = Input::get('cc_proveedor');
      $digito_verificacion = Input::get('digito_verificacion');
      $email = Input::get('email_proveedor');
      $tipo_empresa = Input::get('tipo_empresa');
      $celular = Input::get('celular');
      $telefono = Input::get('telefono');
      $direccion = Input::get('direccion');
      $departamento = Input::get('departamento');
      $ciudad = Input::get('ciudad');
      $sede = Input::get('sede');

      $tipo_cuenta = Input::get('tipo_cuenta');
      $entidad_bancaria = Input::get('entidad_bancaria');
      $numero_cuenta = Input::get('numero_cuenta');
      $certificacion_proveedor = Input::get('certificacion_proveedor');

      $pre = new IngresoProveedor;
      $pre->razonsocial = strtoupper($nombre_proveedor);
      $pre->nit = $cc_proveedor;
      $pre->digito_verificacion = $digito_verificacion;
      $pre->email = strtoupper($email);
      $pre->tipo_empresa = strtoupper($tipo_empresa);
      $pre->celular = strtoupper($celular);
      $pre->telefono = strtoupper($telefono);
      $pre->direccion = strtoupper($direccion);
      $pre->departamento = strtoupper($departamento);
      $pre->ciudad = strtoupper($ciudad);
      $pre->sede = strtoupper($sede);

      $option = Input::get('option');

      if(intval($option)===1){

        $tipodecuenta = Input::get('tipodecuenta');
        $banco = Input::get('banco');
        $numero = Input::get('numero');
        $certificacion = Input::get('certificacion');

        if (Input::hasFile('certificacion')){

          $file_pdf = Input::file('certificacion');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $numero.$name_pdf);
          $certificacion_proveedor = $numero.$name_pdf;

        }else{
          $certificacion_proveedor = null;
        }

        $pre->tipo_cuenta = $tipodecuenta;
        $pre->entidad_bancaria = $banco;
        $pre->numero_cuenta = $numero;
        $pre->certificacion_proveedor = $certificacion_proveedor;

      }else if(intval($option)===2){

        $nombre = Input::get('nombre');
        $identificaciont = Input::get('identificaciont');
        $tipodecuentat = Input::get('tipodecuentat');
        $bancot = Input::get('bancot');
        $numerot = Input::get('numerot');
        $certificaciont = Input::get('certificaciont');
        $poder = Input::get('poder');

        if (Input::hasFile('certificaciont')){

          $file_pdf = Input::file('certificaciont');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $numero.$name_pdf);
          $certificacion_proveedor = $numero.$name_pdf;

        }else{
          $certificacion_proveedor = null;
        }

        if (Input::hasFile('poder')){

          $file_pdf = Input::file('poder');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $identificaciont.$name_pdf);
          $poder = $identificaciont.$name_pdf;

        }else{
          $poder = null;
        }

        $pre->razonsocial_t = strtoupper($nombre);
        $pre->nit_t = $identificaciont;
        $pre->entidad_bancaria_t = $bancot;
        $pre->tipo_cuenta_t = $tipodecuentat;
        $pre->numero_cuenta_t = $numerot;
        $pre->estado_tercero = 1;
        $pre->certificacion_bancaria_t = $certificacion_proveedor;
        $pre->poder_t = $poder;

      }

      if (Input::hasFile('fotop')){//FOTO PROVEEDOR

        $file_pdf = Input::file('fotop');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
        $placa = 'Foto_proveedor';
        //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
        $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
        $pre->foto_proveedor = $placa.$name_pdf;

      }else{
        $pre->foto_proveedor = 0;
      }

      if(intval(Input::get('tipo'))==1){
        $pre->nombre_contacto = strtoupper(Input::get('contacto_nombrecompleto'));
        $pre->cargo_contacto = strtoupper(Input::get('cargop'));
        $pre->email_contacto = strtoupper(Input::get('email_contacto'));
        $pre->telefono_contacto = Input::get('telefono_contacto');
        $pre->celular_contacto = Input::get('celular_contacto');
        $pre->actividad_economica = strtoupper(Input::get('actividad_economica'));
        $pre->codigo_actividad = strtoupper(Input::get('codigo_actividad'));
        $pre->codigo_ica = strtoupper(Input::get('codigo_ica'));
        $pre->tarifa_ica = strtoupper(Input::get('tarifa_ica'));
        $pre->tipo_servicio = strtoupper(Input::get('tipo_servicio'));
      }

      //DATOS BANCARIOS PROVEEDOR
      $pre->tipo_cuenta = $tipo_cuenta;
      $pre->entidad_bancaria = $entidad_bancaria;
      $pre->numero_cuenta = $numero_cuenta;
      if (Input::hasFile('certificacion_proveedor')){

        $file_pdf = Input::file('certificacion_proveedor');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
        $file_pdf->move($ubicacion_pdf, $cc_proveedor.$name_pdf);
        $pre->certificacion_proveedor = $cc_proveedor.$name_pdf;

      }else{
        $pre->certificacion_proveedor = 0;
      }

      //fin proveedor

      if($pre->save()){

        //INGRESO DE VEHÍCULOS
        $numero_interno = Input::get('numero_interno');
        $tipo_transporte = Input::get('tipo_transporte');
        $placa = Input::get('placa');
        $numero_motor = Input::get('numero_motor');
        $clase = Input::get('clase');
        $marca = Input::get('marca');
        $modelo = Input::get('modelo');
        $ano = Input::get('ano');
        $capacidad = Input::get('capacidad');
        $color = Input::get('color');
        $cilindraje = Input::get('cilindraje');
        $vn = Input::get('vn');
        $propietario = Input::get('propietario');
        $cc_propietario = Input::get('cc_propietario');
        $empresa_afiliada = Input::get('empresa_afiliada');
        if($empresa_afiliada!='AOTOUR'){
          $empresa_afiliada = Input::get('cual_empresa');
        }
        $observaciones = Input::get('observaciones');
        $poliza_contractual = Input::get('poliza_contractual');
        $poliza_extra_contractual = Input::get('poliza_extra_contractual');
        $poliza_todo_riesgo = Input::get('poliza_todo_riesgo');
        $tarjeta_propiedad = Input::get('tarjeta_propiedad');
        $tarjeta_operacion = Input::get('tarjeta_operacion');
        $fecha_vigencia_propiedad = Input::get('fecha_vigencia_propiedad');
        $fecha_vigencia_operacion = Input::get('fecha_vigencia_operacion');
        $fecha_vigencia_soat = Input::get('fecha_vigencia_soat');
        $pdf_tpro = Input::get('pdf_tpro');
        $pdf_topr = Input::get('pdf_topr');
        $pdf_soat = Input::get('pdf_soat');
        $vigencia_tecnomecanica = Input::get('vigencia_tecnomecanica');
        //$vigencia_contractual = Input::get('vigencia_contractual'); ...
        //$vigencia_extracontractual = Input::get('vigencia_extracontractual'); ...
        $pdf_tecno = Input::get('pdf_tecno');

        $vehiculo = new IngresoVehiculo;
        $vehiculo->numero_interno = $numero_interno;
        $vehiculo->tipo_transporte = strtoupper($tipo_transporte);
        $vehiculo->placa = strtoupper($placa);
        $vehiculo->numero_motor = $numero_motor;
        $vehiculo->clase = strtoupper($clase);
        $vehiculo->marca = strtoupper($marca);
        $vehiculo->linea = strtoupper($modelo);
        $vehiculo->modelo = $ano;
        $vehiculo->capacidad = $capacidad;
        $vehiculo->color = strtoupper($color);
        $vehiculo->cilindraje = strtoupper($cilindraje);
        $vehiculo->vin = $vn;
        $vehiculo->propietario = strtoupper($propietario);
        $vehiculo->cc_propietario = $cc_propietario;
        $vehiculo->empresa_afiliada = strtoupper($empresa_afiliada);
        $vehiculo->observaciones = strtoupper($observaciones);
        $vehiculo->poliza_contractual = strtoupper($poliza_contractual);
        $vehiculo->poliza_extra_contractual = strtoupper($poliza_extra_contractual);
        $vehiculo->poliza_todo_riesgo = strtoupper($poliza_todo_riesgo);
        $vehiculo->tarjeta_propiedad = strtoupper($tarjeta_propiedad);
        $vehiculo->tarjeta_operacion = $tarjeta_operacion;
        $vehiculo->fecha_vigencia_tp = $fecha_vigencia_propiedad;
        $vehiculo->fecha_vigencia_to = $fecha_vigencia_operacion;
        $vehiculo->vigencia_soat = $fecha_vigencia_soat;

        if (Input::hasFile('pdf_tpro')){

          $file_pdf = Input::file('pdf_tpro');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->tarjeta_propiedad_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->tarjeta_propiedad_pdf = 0;
        }

        if (Input::hasFile('pdf_topr')){

          $file_pdf = Input::file('pdf_topr');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->tarjeta_operacion_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->tarjeta_operacion_pdf = 0;
        }

        if (Input::hasFile('pdf_soat')){

          $file_pdf = Input::file('pdf_soat');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->soat_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->soat_pdf = 0;
        }

        $vehiculo->vigencia_tecnomecanica = $vigencia_tecnomecanica;

        if (Input::hasFile('pdf_tecno')){

          $file_pdf = Input::file('pdf_tecno');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->tecnomecanica_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->tecnomecanica_pdf = 0;
        }

        // PÓLIZAS PDF
        if (Input::hasFile('pdf_contra')){

          $file_pdf = Input::file('pdf_contra');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $random = '1234';//colocar número random
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $random.$name_pdf);
          $vehiculo->poliza_contractual_pdf = $random.$name_pdf;

        }else{
          $vehiculo->poliza_contractual_pdf = 0;
        }

        if (Input::hasFile('pdf_extra')){

          $file_pdf = Input::file('pdf_extra');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $random = '1234';//colocar número random
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $random.$name_pdf);
          $vehiculo->poliza_extra_contractual_pdf = $random.$name_pdf;

        }else{
          $vehiculo->poliza_extra_contractual_pdf = 0;
        }
        //PÓLIZAS PDF

        if (Input::hasFile('foto_frontal')){//FOTO FRONTAL

          $file_pdf = Input::file('foto_frontal');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_frontal = $placa.$name_pdf;

        }else{
          $vehiculo->foto_frontal = 0;
        }

        if (Input::hasFile('foto_dorso')){//FOTO DORSO

          $file_pdf = Input::file('foto_dorso');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_dorso = $placa.$name_pdf;

        }else{
          $vehiculo->foto_dorso = 0;
        }

        if (Input::hasFile('foto_derecha')){//FOTO DERECHA

          $file_pdf = Input::file('foto_derecha');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_derecha = $placa.$name_pdf;

        }else{
          $vehiculo->foto_derecha = 0;
        }

        if (Input::hasFile('foto_izquierda')){//FOTO IZQUIERDA

          $file_pdf = Input::file('foto_izquierda');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_izquierda = $placa.$name_pdf;

        }else{
          $vehiculo->foto_izquierda = 0;
        }

        $vehiculo->proveedor_id = $pre->id;

        $vehiculo->save();

        //fin vehiculo

        //INGRESO DE CONDUCTOR
        $nombre_completoc = Input::get('nombre_completoc');
        $departamentoc = Input::get('departamentoc');
        $ciudadc = Input::get('ciudadc');
        $generoc = Input::get('generoc');
        $edadc = Input::get('edadc');
        $ccc = Input::get('ccc');
        $celularc = Input::get('celularc');
        $telefonoc = Input::get('telefonoc');
        $direccionc = Input::get('direccionc');
        $tipodelicenciac = Input::get('tipodelicenciac');
        $fecha_licencia_expedicionc = Input::get('fecha_licencia_expedicionc');
        $fecha_licencia_vigenciac = Input::get('fecha_licencia_vigenciac');
        $grupo_trabajoc = Input::get('grupo_trabajoc');
        $tipo_contratoc = Input::get('tipo_contratoc');
        $cargoc = Input::get('cargoc');
        $experienciac = Input::get('experienciac');
        $accidentesc = Input::get('accidentesc');
        $descripcion_accidentec = Input::get('descripcion_accidentec');
        //$incidentesc = Input::get('incidentesc');
        //$frecuencia_desplazamientoc = Input::get('frecuencia_desplazamientoc');
        //$vehiculo_propio_desplazamientoc = Input::get('vehiculo_propio_desplazamientoc');
        //$trayecto_casa_trabajoc = Input::get('trayecto_casa_trabajoc');
        $fotoc = Input::get('fotoc');
        $pdf_ss = Input::get('pdf_ss');

        $conductor = new IngresoConductor;
        $conductor->nombre_completo = strtoupper($nombre_completoc);
        $conductor->departamento = strtoupper($departamentoc);
        $conductor->ciudad = strtoupper($ciudadc);
        $conductor->genero = strtoupper($generoc);
        $conductor->edad = $edadc;
        $conductor->cc = $ccc;
        $conductor->celular = $celularc;
        $conductor->telefono = $telefonoc;
        $conductor->direccion = strtoupper($direccionc);
        $conductor->tipo_licencia = strtoupper($tipodelicenciac);
        $conductor->fecha_expedicion = $fecha_licencia_expedicionc;
        $conductor->fecha_vigencia = $fecha_licencia_vigenciac;
        $conductor->grupo_trabajo = strtoupper($grupo_trabajoc);
        $conductor->tipo_contrato = strtoupper($tipo_contratoc);
        $conductor->cargo = strtoupper($cargoc);
        $conductor->experiencia = $experienciac;
        $conductor->accidentes_encinco = strtoupper($accidentesc);
        $conductor->descripcion_accidente = strtoupper($descripcion_accidentec);
        //$conductor->incidentes = strtoupper($incidentesc);
        //$conductor->frecuencia_desplazamiento = $frecuencia_desplazamientoc;
        //$conductor->vehiculo_propio = $vehiculo_propio_desplazamientoc;
        //$conductor->trayecto_casa = $trayecto_casa_trabajoc;

        //
        if (Input::hasFile('fotoc')){

          $file = Input::file('fotoc');
          $ubicacion = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/';
          $nombre_imagen = $file->getClientOriginalName();



          $conductor->foto_conductor = $nombre_imagen;

          Image::make($file->getRealPath())->resize(250, 316)->save($ubicacion.$nombre_imagen);

          Image::make($file->getRealPath())
          ->resize(250, 250)->save($ubicacion.'thumbnail'.$nombre_imagen);

        }else{

          $conductor->foto_conductor = 'FALSE';
        }

        //$conductor->foto_conductor = $fotoc;
        //PDF CÉDULA DEL CONDUCTOR
        if(Input::hasFile('pdf_cc_conductor')){

          $file_pdf = Input::file('pdf_cc_conductor');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/cc/';
          $file_pdf->move($ubicacion_pdf, $ccc.$name_pdf);
          $conductor->pdf_cc = $ccc.$name_pdf;

        }else{
          $conductor->pdf_cc = 0;
        }

        //PDF LICENCIA DEL CONDUCCIÓN
        if(Input::hasFile('pdf_licencia_conductor')){

          $file_pdf = Input::file('pdf_licencia_conductor');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/licencias/';
          $file_pdf->move($ubicacion_pdf, $ccc.$name_pdf);
          $conductor->pdf_licencia = $ccc.$name_pdf;

        }else{
          $conductor->pdf_licencia = 0;
        }

        //PDF SEGURIDAD SOCIAL DEL CONDUCTOR
        if(Input::hasFile('pdf_ss')){

          $file_pdf = Input::file('pdf_ss');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/seguridadsocial';
          $file_pdf->move($ubicacion_pdf, $ccc.$name_pdf);
          $conductor->seguridad_social = $ccc.$name_pdf;

        }else{
          $conductor->seguridad_social = 0;
        }

        $conductor->proveedor_id = $pre->id;
        $conductor->save();

        /*ENVÍO DE CORREO AL GERENTE DE OPERACIONES

        //$email = 'gerenteoperaciones@aotour.com.co';
        $email = 'sistemas@aotour.com.co';

        $cc = ['comercial@aotour.com.co', 'gestionintegral@aotour.com.co' ,'aotourdeveloper@gmail.com']; //REGISTRO DE PROVEEDOR
        $data = [
          'id' => 1
        ];
        Mail::send('portalproveedores.emails.registro', $data, function($message) use ($email, $cc){
          $message->from('no-reply@aotour.com.co', 'AUTONET');
          $message->to($email)->subject('PORTAL PROVEEDORES');
          //$message->cc($cc);
        });
        //FIN ENVÍO DE CORREO AL PROVEEDOR*/

        return Response::json([
          'respuesta' => true,
          'conductor' => $conductor,
          'vehiculo' => $vehiculo
        ]);

      }else{
        return Response::json([
          'respuesta'=>false
        ]);
      }
    }

    public function postOrganizarhoras() {

      $pasajeros = DB::table('pasajeros_rutas')
      ->where('solicitud_id',Input::get('id'))
      ->orderBy('hora', 'asc')
      ->get();

      $solicitud = DB::table('rutas_solicitadas')
      ->where('id',Input::get('id'))
      ->first();

      $query = "SELECT DISTINCT hora from pasajeros_rutas where solicitud_id = ".Input::get('id')."";
      $consulta = DB::select($query);

      foreach ($consulta as $horario) {

        $queryss = "select * from pasajeros_rutas where solicitud_id = ".Input::get('id')." and hora = '".$horario->hora."'";
        $cons = DB::select($queryss);

        $nuevo = new RutasSolicitadas;
        $nuevo->fecha = $solicitud->fecha;
        $nuevo->fecha_solicitud = date('Y-m-d');
        $nuevo->solicitado_por = $solicitud->solicitado_por;
        $nuevo->cantidad_usuarios = 1;
        $nuevo->cliente = Sentry::getUser()->centrodecosto_id;
        $nuevo->campana = Sentry::getUser()->subcentrodecosto_id;
        $nuevo->descripcion = Sentry::getUser()->cargo;
        $nuevo->ciudad = Sentry::getUser()->localidad;
        $nuevo->tipo_ruta = $solicitud->tipo_ruta;
        $nuevo->save();

        foreach ($cons as $con) {

          $update = DB::table('pasajeros_rutas')
          ->where('id',$con->id)
          ->update([
            'solicitud_id' => $nuevo->id
          ]);

        }


      }

      $delete = "DELETE FROM rutas_solicitadas WHERE id = ".Input::get('id')."";
      $deletes = DB::select($delete);

      return Response::json([
        'response' => true,
        'pasajeros' => $pasajeros,
        'consulta' => $consulta
      ]);

    }

    public function getConfirmarubicacion($id) {

      $usuario = DB::table('pasajeros_rutas')
      ->select('id', 'nombres', 'confirmado')
      ->where('id', $id)
      ->first();

      if($usuario->confirmado==1) {
        
        return View::make('autogestion.confirmado')
        ->with('usuario',$usuario);

      }else{
        
        return View::make('autogestion.confirmar')
        ->with('usuario',$usuario);

      }

    }

    //Inicio métodos del cliente

    //Vista para la subida de excel de rutas
    public function getSubidaderutas() {

      if(Sentry::check()){

        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);

        if($id_rol==38){
          $ver = 'on';
        }else{
          $ver = null;
        }

      }

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else if($ver!='on'){
        return View::make('admin.permisos');
      }else{

        $usuarios = DB::table('pasajeros_rutas')
        ->where('centrodecosto_id', Sentry::getUser()->centrodecosto_id)
        ->where('subcentrodecosto_id', Sentry::getUser()->subcentrodecosto_id)
        ->where('fecha', '>=', date('Y-m-d'))
        ->orderBy('id', 'asc')
        ->get();

        return View::make('autogestion.usuarios_ruta')
        ->with('permisos',$permisos)
        ->with('usuarios',$usuarios);

      }

    }

    //Importar excel con la info de los pasajeros
    public function postImportarexcel(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            $var = '';

            Excel::selectSheetsByIndex(0)->load(Input::file('excel'), function($reader){

                $reader->skip(1);
                $result = $reader->noHeading()->get();

                $pasajerosArray = [];

                foreach($result as $value){

                    $nombre_excel = $value[0];

                    $apellidos_excel = $value[1];

                    $apellidos_excel = preg_replace('/[\s]+/mu', ' ', $apellidos_excel);

                    if(is_string($value[1])){

                        /*if($value[2]!=''){
                          $val_cel = str_replace(' ', '', $value[2]);
                          $val_cel = str_replace('-', '', $val_cel);
                          $val_cel = str_replace('(', '', $val_cel);
                          $val_cel = str_replace(')', '', $val_cel);
                        }else{
                          $val_cel = '';
                        }*/

                        $direccion = preg_replace('/[\s]+/mu', ' ', $value[3]);
                        $barrio = preg_replace('/[\s]+/mu', ' ', $value[4]);
                        $localidad = preg_replace('/[\s]+/mu', ' ', $value[5]);
                        $campana = preg_replace('/[\s]+/mu', ' ', $value[7]);

                        $dataExcel = [
                          'id_employer' => strtoupper(trim($value[0])), //EMPLOY ID
                          'nombres' => strtoupper(trim($value[1])), //NOMBRES
                          'telefono' => trim($value[2]), //TELEFONO
                          'direccion' => strtoupper(trim($value[3])), //DIRECCION
                          'barrio' => strtoupper(trim($value[4])), //BARRIO
                          'localidad' => strtoupper(trim($value[5])), //BARRIO
                          'programa' => $value[7], //PROGRAMA
                          'ciudad' => strtoupper($value[6]), //CIUDAD
                          'hora' => $value[8], //HORA
                          'correo' => $value[9], //CORREO
                        ];

                        array_push($pasajerosArray, $dataExcel);
                    }
                }
                echo json_encode([
                  'pasajeros' => $pasajerosArray
                ]);

            });

        }

    }

    //Envíar a transportes la solicitud de uta
    public function postSubirusuarios() {

      $pasajeros = json_decode(Input::get('pasajeros'));
      $contador = 0;
      $fecha = Input::get('fecha');

      if(Input::get('tipo_ruta')==1) {
        $tipo_ruta = 1;
        $texto = 'recogeremos';
      }else{
        $tipo_ruta = NULL;
        $texto = 'llevaremos';
      }

      $nueva = new RutasSolicitadas;
      $nueva->fecha = Input::get('fecha');
      $nueva->fecha_solicitud = date('Y-m-d');
      $nueva->solicitado_por = Sentry::getUser()->id;
      $nueva->cantidad_usuarios = count($pasajeros);
      $nueva->cliente = Sentry::getUser()->centrodecosto_id;
      $nueva->campana = Sentry::getUser()->subcentrodecosto_id;
      $nueva->descripcion = Sentry::getUser()->cargo;
      $nueva->ciudad = Sentry::getUser()->localidad;
      if(Input::get('tipo_ruta')==1) {
        $nueva->tipo_ruta = 1;
      }
      $nueva->save();

      foreach ($pasajeros as $item){

        $id_empleado = $item->id_employer;
        $nombres = $item->nombres;
        $telefono = $item->telefono;
        $direccion = $item->direccion;
        $barrio = $item->barrio;
        $localidad = $item->localidad;
        $ciudad = $item->ciudad;
        $latitude = $item->latitude;
        $longitude = $item->longitude;
        $programa = $item->programa;
        $hora = $item->hora;
        $correo = $item->correo;

        $usuario = new PasajeroRuta;
        $usuario->nombres = strtoupper($nombres);
        $usuario->fecha = $fecha;
        $usuario->id_empleado = $id_empleado;
        $usuario->centrodecosto_id = Sentry::getUser()->centrodecosto_id;
        $usuario->subcentrodecosto_id = Sentry::getUser()->subcentrodecosto_id;
        $usuario->tipo = $tipo_ruta;
        $usuario->estado = 1;
        $usuario->telefono = $telefono;
        $usuario->direccion = strtoupper($direccion);
        $usuario->barrio = strtoupper($barrio);
        $usuario->localidad = strtoupper($localidad);
        $usuario->ciudad = strtoupper($ciudad);
        $usuario->latitude = $latitude;
        $usuario->correo = $correo;
        $usuario->longitude = $longitude;
        $usuario->hora = $hora;
        $usuario->programa = strtoupper($programa);
        $usuario->creado_por = Sentry::getUser()->id;
        $usuario->solicitud_id = $nueva->id;
        $usuario->save();

        if(Sentry::getUser()->centrodecosto_id==489) {

          //Send Email
          if($correo!='' and $correo!=null) {

            if(filter_var($correo, FILTER_VALIDATE_EMAIL)) {
              
              $data = [
                'usuario' => $item,
                'id' => $usuario->id,
                'texto' => $texto,
                'link' => 'https://app.aotour.com.co/autonet/transportederuta/confirmarubicacion/'.$usuario->id
              ];

              $email = $correo; //Colocar el Email del proveedor
              $cc = null;
              //$cc = ['sistemas1@aotour.com.co','aotourdeveloper@gmail.com']; //Copiar a comercial@aotour.com.co

              Mail::send('autogestion.emails.confirmar_ubicacion', $data, function($message) use ($email, $cc){
                $message->from('no-reply@aotour.com.co', 'Solicitud de Ruta');
                $message->to($email)->subject('Ha sido solicitada una ruta a tu nombre...');
                //$message->Bcc($cc);
              });

            }

          }
          //Send Email

          /* Notificar APP */
          $user = DB::table('users')
          ->select('id', 'idregistrationdevice', 'idioma')
          ->where('id_empleado',$id_empleado)
          ->first();

          if($user){
            Servicio::confirmarUbi($user->idregistrationdevice,$user->idioma);
          }
          /* Notificar APP */

          //Send WhatsApp
          $number = '57'.$telefono;

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
              \"name\": \"confirmar_ruta\",
              \"language\": {
                \"code\": \"es\",
              },
              \"components\": [{
                \"type\": \"body\",
                \"parameters\": [{
                  \"type\": \"text\",
                  \"text\": \"".$nombres."\",
                },
                {
                  \"type\": \"text\",
                  \"text\": \"".$texto."\",
                }]
              },
              {
                \"type\": \"button\",
                \"sub_type\": \"url\",
                \"index\": \"0\",
                \"parameters\": [{
                  \"type\": \"payload\",
                  \"payload\": \"".$usuario->id."\"
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
          //Send WhatsApp

        }

        $contador = 1;
        $contador++;

      }

      return Response::json([
        'response' => true,
        'contador' => $contador,
        'id' => $nueva->id
      ]);

    }

    /**/

    //INICIO MÉTODOS DE TRANSPORTES
    public function getRutasporprogramar(){ //Bogotá

      if (Sentry::check()){

        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->bogota->transportes->ver;

      }else{

        $ver = null;

      }

      if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on') {
        return View::make('admin.permisos');
      }else{

        $usuarios = DB::table('rutas_solicitadas')
        ->leftJoin('users', 'users.id', '=', 'rutas_solicitadas.solicitado_por')
        ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'users.centrodecosto_id')
        ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'users.subcentrodecosto_id')
        ->select('rutas_solicitadas.*', 'users.first_name', 'users.last_name', 'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro')
        ->where('rutas_solicitadas.ciudad',2)
        ->where('rutas_solicitadas.fecha', '>=', date('Y-m-d'))
        ->whereNull('visible')
        ->orderBy('id', 'asc')
        //->groupBy(['cliente','ciudad','fecha','tipo_ruta'])
        ->get();

        return View::make('autogestion.archivos_rutas')
        ->with('permisos',$permisos)
        ->with('usuarios',$usuarios);

      }

    }

    public function postRenotificar() {

      $id = Input::get('id');

      $solicitud = RutasSolicitadas::find($id);

      if($solicitud->notificado==1) {

        return Response::json([
          'response' => false
        ]);

      }else{

        $solicitud->notificado = 1;
        $solicitud->save();

        $users = DB::table('pasajeros_rutas')
        ->where('solicitud_id',$id)
        ->whereNull('confirmado')
        ->get();

        foreach ($users as $usuario) {
          
          if($usuario->tipo==1) {
            $tipo_ruta = 1;
            $texto = 'recogeremos';
          }else{
            $tipo_ruta = NULL;
            $texto = 'llevaremos';
          }

          //Send Email
          if($usuario->correo!='' and $usuario->correo!=null) {

            if(filter_var($usuario->correo, FILTER_VALIDATE_EMAIL)) {
              
              $data = [
                'usuario' => $usuario,
                'id' => $usuario->id,
                'texto' => $texto,
                'link' => 'https://app.aotour.com.co/autonet/transportederuta/confirmarubicacion/'.$usuario->id
              ];

              $email = $usuario->correo; //Colocar el Email del proveedor
              $cc = null;
              //$cc = ['sistemas1@aotour.com.co','aotourdeveloper@gmail.com']; //Copiar a comercial@aotour.com.co

              Mail::send('autogestion.emails.confirmar_ubicacion', $data, function($message) use ($email, $cc){
                $message->from('no-reply@aotour.com.co', 'Solicitud de Ruta');
                $message->to($email)->subject('Ha sido solicitada una ruta a tu nombre...');
                //$message->Bcc($cc);
              });

            }

          }
          //Send Email

          //Send WhatsApp
          $number = '57'.$usuario->telefono;

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
              \"name\": \"confirmar_ruta\",
              \"language\": {
                \"code\": \"es\",
              },
              \"components\": [{
                \"type\": \"body\",
                \"parameters\": [{
                  \"type\": \"text\",
                  \"text\": \"".$usuario->nombres."\",
                },
                {
                  \"type\": \"text\",
                  \"text\": \"".$texto."\",
                }]
              },
              {
                \"type\": \"button\",
                \"sub_type\": \"url\",
                \"index\": \"0\",
                \"parameters\": [{
                  \"type\": \"payload\",
                  \"payload\": \"".$usuario->id."\"
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
          //Send WhatsApp

        }

      }

      return Response::json([
        'response' => true
      ]);

    }

    public function postOcultar() {

      $update = DB::table('rutas_solicitadas')
      ->where('id',Input::get('id'))
      ->update([
        'visible' => 1
      ]);

      return Response::json([
        'response' => true
      ]);

    }

    public function getProgramacionderutas($id) {

      if (Sentry::check()){

        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->bogota->transportes->ver;

      }else{

        $ver = null;

      }

      if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on') {
        return View::make('admin.permisos');
      }else{

        $request = DB::table('rutas_solicitadas')
        ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'rutas_solicitadas.cliente')
        ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'rutas_solicitadas.campana')
        ->leftJoin('users', 'users.id', '=', 'rutas_solicitadas.solicitado_por')
        ->select('rutas_solicitadas.*', 'centrosdecosto.id as centro_id', 'subcentrosdecosto.id as subcentro_id', 'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro', 'users.first_name', 'users.last_name')
        ->where('rutas_solicitadas.id',$id)
        ->first();

        $diasiguiente = strtotime('1 day', strtotime($request->fecha));
        $diasiguiente = date('Y-m-d' , $diasiguiente);

        $usuarios = DB::table('pasajeros_rutas')
        ->leftJoin('rutas_solicitadas', 'rutas_solicitadas.id', '=', 'pasajeros_rutas.solicitud_id')
        ->select('pasajeros_rutas.*', 'pasajeros_rutas.hora as horario', 'rutas_solicitadas.fecha')
        ->whereBetween('rutas_solicitadas.fecha',[$request->fecha, $diasiguiente])
        ->where('rutas_solicitadas.id',$id)
        ->orderBy('pasajeros_rutas.localidad', 'asc')
        ->get();

        $rutas = DB::table('nombre_ruta')
        ->where('centrodecosto_id',489)
        ->orderBy('nombre')
        ->get();

        $horarios = "SELECT DISTINCT hora FROM pasajeros_rutas WHERE solicitud_id = ".$id."";
        $horarios = DB::select($horarios);

        $conductores = "select conductores.nombre_completo, conductores.id, conductores.bloqueado, conductores.bloqueado_total, proveedores.inactivo, proveedores.inactivo_total from conductores left join proveedores on proveedores.id = conductores.proveedores_id where conductores.bloqueado is null and conductores.bloqueado_total is null and proveedores.inactivo is null and inactivo_total is null and proveedores.localidad in('BOGOTA', 'PROVISIONAL') order by conductores.nombre_completo";
        $conductores = DB::select($conductores);

        $localidades = "select id, nombre from localidades where centrodecosto = ".$request->cliente." and subcentrodecosto = ".$request->campana."";
        $localidades = DB::select($localidades);

        return View::make('autogestion.programacionderutas')
        ->with('request', $request)
        ->with('conductores', $conductores)
        ->with('localidades', $localidades)
        ->with('horarios', $horarios)
        ->with('rutas', $rutas)
        ->with('o', 1)
        ->with('usuarios',$usuarios);
      }

    }

    //Fin métodos de transportes
}
?>
