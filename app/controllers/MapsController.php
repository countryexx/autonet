<?php

/**
 * Clase para servicios solicitados via movil - url = 'autonet/mobile'
 */
class MapsController extends BaseController{


    public function getIndex(){

        if (Sentry::check()){

            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
            $ver = 'on';

        }else{

            $ver = null;

        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on') {
            return View::make('admin.permisos');
        }else{

            $servicios = DB::table('servicios')
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
                ->leftJoin('nombre_ruta', 'servicios.ruta_nombre_id','=','nombre_ruta.id')
                                ->leftJoin('servicios_autorizados_pdf', 'servicios.id', '=', 'servicios_autorizados_pdf.servicio_id')
                ->select('servicios.*', 'nombre_ruta.nombre', 'facturacion.revisado','facturacion.liquidado','facturacion.facturado',
                         'facturacion.factura_id', 'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro',
                         'users.first_name','users.last_name', 'rutas.nombre_ruta','rutas.codigo_ruta',
                         'proveedores.razonsocial AS razonproveedor', 'conductores.nombre_completo','conductores.celular',
                         'conductores.telefono', 'reconfirmacion.numero_reconfirmaciones', 'reconfirmacion.id as id_reconfirmacion',
                         'reconfirmacion.ejecutado', 'vehiculos.placa','vehiculos.clase','vehiculos.marca',
                         'vehiculos.modelo', 'encuesta.pregunta_1','encuesta.pregunta_2','encuesta.pregunta_3',
                         'encuesta.pregunta_4', 'encuesta.pregunta_8','encuesta.pregunta_9','encuesta.pregunta_10',
                         'servicios_edicion_pivote.id as id_pivote', 'reportes_pivote.id as id_reporte',
                         'servicios_autorizados_pdf.documento_pdf1', 'servicios_autorizados_pdf.documento_pdf2')
                ->whereIn('servicios.id',[192517,186948])
                ->get();

            $centrosdecosto = Centrodecosto::Internos()->whereIn('localidad',['barranquilla','provisional'])->orderBy('razonsocial')->get();

            $subcentros = DB::table('subcentrosdecosto')->orderBy('nombresubcentro')->get();
            $departamentos = DB::table('departamento')->get();
            $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
            $rutas = DB::table('rutas')->get();
            $usuarios = DB::table('users')->where('coordinador',1)->where('activated',1)->where('permissions',null)->get();

                  $cotizaciones = DB::table('cotizaciones')->where('estado',1)->orderBy('created_at', 'desc')->take(10)->get();

            return View::make('portalusuarios.test.test')
               ->with('cotizaciones',$cotizaciones)
                        ->with('servicios',$servicios)
                ->with('centrosdecosto',$centrosdecosto)
                ->with('departamentos',$departamentos)
                ->with('ciudades',$ciudades)
                ->with('rutas',$rutas)
                ->with('permisos',$permisos)
                ->with('usuarios',$usuarios)
                ->with('o',$o=1);
        }
    }

    public function getLiveviewbog(){

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
            return View::make('servicios.gps.live_bog')
            ->with('permisos',$permisos);
        }
    }

     public function postBuscar(){

          if (Request::ajax()){

              $fecha_inicial = Input::get('fecha_inicial');
              $fecha_final = Input::get('fecha_final');
              $servicio = intval(Input::get('servicios'));

              $email_usuario = Input::get('email_usuario');

              $codigo = Input::get('codigo');

                $consulta = "select servicios.id, servicios.fecha_orden, servicios.fecha_servicio, servicios.solicitado_por, servicios.email_solicitante, servicios.programado_app, ".
                    "servicios.resaltar, servicios.pago_directo, servicios.fecha_solicitud, servicios.ciudad, servicios.recoger_en, servicios.ruta, ".
                    "servicios.dejar_en, servicios.detalle_recorrido, servicios.pasajeros, servicios.pasajeros_ruta, servicios.finalizado, servicios.pendiente_autori_eliminacion, ".
                    "servicios.hora_servicio, servicios.origen, servicios.destino, servicios.fecha_pago_directo, servicios.rechazar_eliminacion, ".
                    "servicios.estado_servicio_app, servicios.recorrido_gps, servicios.calificacion_app_conductor_calidad, ".
                    "servicios.calificacion_app_conductor_actitud, servicios.calificacion_app_cliente_calidad, servicios.calificacion_app_cliente_actitud, ".
                    "servicios.aerolinea, servicios.vuelo, servicios.hora_salida, servicios.hora_llegada, servicios.aceptado_app, ".
                    "servicios.cancelado, pago_proveedores.consecutivo as pconsecutivo, pagos.autorizado, ".
                    "servicios_edicion_pivote.id as servicios_id_pivote, ordenes_facturacion.id as idordenfactura, ".
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
                    "where servicios.email_solicitante='".$email_usuario."' and servicios.fecha_servicio between '".$fecha_inicial."' AND '".$fecha_final."' and servicios.ruta is null";

              if($codigo!=''){
                  $consulta .= " and servicios.id = '".$codigo."' ";
              }

              $servicios = DB::select(DB::raw($consulta." and servicios.pendiente_autori_eliminacion is null ORDER BY fecha_servicio ASC, hora_servicio ASC"));

              if ($servicios!=null) {

                  $idArray = [];
                  foreach ($servicios as $servicio){
                    $array = [
                      'id_encriptado' => Crypt::encryptString($servicio->id)
                    ];
                    array_push($idArray, $array);
                  }

                  return Response::json([
                      'mensaje'=>true,
                      'servicios'=>$servicios,
                      'id_array'=>$idArray,
                      'consulta'=>$consulta,
                  ]);

              }else{

                  return Response::json([
                      'mensaje'=>false,
                      'consulta'=>$consulta,
                  ]);
              }
          }

  }


    public function getLiveview(){

        if (Sentry::check()){

            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
            $ver = $permisos->barranquilla->transportesbq->ver;

        }else{

            $ver = null;

        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on') {
            return View::make('admin.permisos');
        }else{
            return View::make('servicios.gps.live')
            ->with('permisos',$permisos);
        }
    }

    public function getLiveviewbogold(){

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
            return View::make('servicios.gps.live_bog')
            ->with('permisos',$permisos);
        }
    }

    public function getTracking($code){

      //$decrypted = Crypt::decryptString($code);
      //$decrypted = 293253;

      $decrypted = $code;
      $consult = Ruta_qr::find($decrypted);

      if(isset($consult)){

        $servicio = DB::table('servicios')
        ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
        ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
        ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
        ->select('servicios.*', 'centrosdecosto.razonsocial', 'conductores.nombre_completo','conductores.foto', 'conductores.celular', 'vehiculos.color','vehiculos.placa','vehiculos.modelo', 'vehiculos.marca', 'vehiculos.clase')
        ->where('servicios.id',$consult->servicio_id)
        ->get();

        return View::make('maps.tracking_ruta')
        ->with([
            'servicio' => $servicio,
            'id_ser' => $consult->servicio_id,
            'id_user' => $consult->id,
            'address' => $consult->address,
            'fullname' => $consult->fullname,
            'lat' => json_decode($consult->coords)[0]->lat,
            'lng' => json_decode($consult->coords)[0]->lng
        ]);

      }else{

        return View::make('servicios.gps.eliminado')
        ->with([
            'id_ser' => $decrypted,
        ]);

      }
    }

    public function getTrackingservice($code){

      //$decrypted = Crypt::decryptString($code);
      //$decrypted = 293253;
      $decrypted = $code;
      $consult = Servicio::find($decrypted);

      if(isset($consult)){

        if($consult->pendiente_autori_eliminacion==1){
          return View::make('servicios.gps.eliminado')
          ->with([
            'id_ser' => $decrypted
          ]);
        }else if($consult->ruta==1){
          return View::make('servicios.gps.is_route')
          ->with([
            'id_ser' => $decrypted
          ]);
        }else{

          $query = Servicio::select('servicios.*', 'conductores.nombre_completo','conductores.foto', 'conductores.celular', 'vehiculos.color','vehiculos.placa','vehiculos.modelo', 'vehiculos.marca', 'vehiculos.clase', 'servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'centrosdecosto.razonsocial')
          ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
          ->leftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
          ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
          ->where('servicios.id',$decrypted);

          $servicio = $query->orderBy('hora_servicio')->get();

          return View::make('maps.tracking')
          ->with([
            'servicio' => $servicio,
            'id_ser' => $decrypted
          ]);
        }
      }else{
        return View::make('servicios.gps.eliminado')
          ->with([
            'id_ser' => $decrypted,
          ]);
      }
    }

    public function getNavigation(){

        return View::make('maps.navigation')
        ->with([
        'servicio' => 1234
        ]);

    }

    public function getRoute(){

        return View::make('maps.route')
        ->with([
        'servicio' => 1234
        ]);

    }

    public function postActualizarmapanav() {

        $query = "SELECT * FROM eventos_nav ORDER BY id desc LIMIT 1";

        $consulta = DB::select($query);

        return Response::json([
            'response' => true,
            'coords' => $consulta
        ]);

    }

    public function getTrackingservices($code){

      $decrypted = $code;
      $consult = Servicio::find($decrypted);

      if(isset($consult)){

        $query = Servicio::select('servicios.*', 'conductores.nombre_completo','conductores.foto', 'conductores.celular', 'vehiculos.color','vehiculos.placa','vehiculos.modelo', 'vehiculos.marca', 'vehiculos.clase', 'servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'centrosdecosto.razonsocial')
          ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
          ->leftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
          ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
          ->where('servicios.id',$decrypted);

          $servicio = $query->orderBy('hora_servicio')->get();

          return View::make('maps.tracking_admin')
          ->with([
            'servicio' => $servicio,
            'id_ser' => $decrypted
          ]);
          
        if($consult->pendiente_autori_eliminacion==1){
          return View::make('servicios.gps.eliminado')
          ->with([
            'id_ser' => $decrypted
          ]);
        }else{

          $query = Servicio::select('servicios.*', 'conductores.nombre_completo','conductores.foto', 'conductores.celular', 'vehiculos.color','vehiculos.placa','vehiculos.modelo', 'vehiculos.marca', 'vehiculos.clase', 'servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'centrosdecosto.razonsocial')
          ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
          ->leftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
          ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
          ->where('servicios.id',$decrypted);

          $servicio = $query->orderBy('hora_servicio')->get();

          return View::make('maps.tracking_admin')
          ->with([
            'servicio' => $servicio,
            'id_ser' => $decrypted
          ]);
        }
      }else{
        return View::make('servicios.gps.eliminado')
          ->with([
            'id_ser' => $decrypted,
          ]);
      }
    }

    public function getRate($code){

      //$decrypted = Crypt::decryptString($code);
      //$decrypted = 293253;
      $decrypted = $code;
      $consult = Servicio::find($decrypted);



        if($consult->calificacion_app_cliente_calidad!=null){

            if($consult->calificacion_app_cliente_calidad==1 or $consult->calificacion_app_cliente_calidad==2){

                return View::make('maps.calificado_malo')
                ->with([
                    'id_ser' => $decrypted
                ]);

            }else if($consult->calificacion_app_cliente_calidad==3){

                return View::make('maps.calificado_regular')
                ->with([
                    'id_ser' => $decrypted
                ]);

            }else{

                return View::make('maps.calificado_bueno')
                ->with([
                    'id_ser' => $decrypted
                ]);

            }

        }else{

          $query = Servicio::select('servicios.*', 'conductores.nombre_completo','conductores.foto', 'conductores.celular', 'vehiculos.color','vehiculos.placa','vehiculos.modelo', 'vehiculos.marca', 'vehiculos.clase', 'servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'centrosdecosto.razonsocial')
          ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
          ->leftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
          ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
          ->where('servicios.id',$decrypted);

          $servicio = $query->orderBy('hora_servicio')->get();

          return View::make('maps.rate')
          ->with([
            'servicio' => $servicio,
            'id_ser' => $decrypted
          ]);
        }

    }

    public function getConfirm($code){

      //$decrypted = Crypt::decryptString($code);
      //$decrypted = 293253;

      $decrypted = $code;
      $consult = Ruta_qr::find($decrypted);

      if(isset($consult)){

        $servicio = DB::table('servicios')
        ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
        ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
        ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
        ->select('servicios.*', 'centrosdecosto.razonsocial', 'conductores.nombre_completo','conductores.foto', 'conductores.celular', 'vehiculos.color','vehiculos.placa','vehiculos.modelo', 'vehiculos.marca', 'vehiculos.clase')
        ->where('servicios.id',$consult->servicio_id)
        ->get();

        return View::make('maps.confirm')
        ->with([
            'servicio' => $servicio,
            'id_ser' => $consult->servicio_id,
            'id_user' => $consult->id,
            'address' => $consult->address,
            'fullname' => $consult->fullname,
            'lat' => json_decode($consult->coords)[0]->lat,
            'lng' => json_decode($consult->coords)[0]->lng,
            'actualizado' => $consult->actualizado,
            'fecha_actualizado' => $consult->fecha_actualizado
        ]);

      }else{

        return View::make('servicios.gps.eliminado')
        ->with([
            'id_ser' => $decrypted,
        ]);

      }
    }

    public function postActualizarrecogida() {

        $id = Input::get('id');
        $lat = Input::get('lat');
        $lng = Input::get('lng');

        $consulta =  DB::table('qr_rutas')
        ->where('id',$id)
        ->first();

        if($consulta->actualizado!=null){

            return Response::json([
                'respuesta' => false
            ]);

        }else{

            $data = [
              'lat' => $lat,
              'lng' => $lng
            ];

            $update = DB::table('qr_rutas')
            ->where('id',$id)
            ->update([
                'coords' => json_encode([$data]),
                'actualizado' => 1,
                'fecha_actualizado' => date('Y-m-d H:i')
            ]);

            return Response::json([
                'respuesta' => true
            ]);

        }

    }

    public function getCalificar($code){

      //$decrypted = Crypt::decryptString($code);
      //$decrypted = 293253;
      $decrypted = $code;
      $consult = Ruta_qr::find($decrypted);

        if($consult->rate!=null){

            if($consult->rate==1 or $consult->rate==2){

                return View::make('maps.calificado_malo')
                ->with([
                    'id_ser' => $decrypted
                ]);

            }else if($consult->rate==3){

                return View::make('maps.calificado_regular')
                ->with([
                    'id_ser' => $decrypted
                ]);

            }else{

                return View::make('maps.calificado_bueno')
                ->with([
                    'id_ser' => $decrypted
                ]);

            }

        }else{

          $query = Servicio::select('servicios.*', 'conductores.nombre_completo','conductores.foto', 'conductores.celular', 'vehiculos.color','vehiculos.placa','vehiculos.modelo', 'vehiculos.marca', 'vehiculos.clase', 'servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'centrosdecosto.razonsocial')
          ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
          ->leftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
          ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
          ->where('servicios.id',$decrypted);

          $servicio = $query->orderBy('hora_servicio')->get();

          return View::make('maps.rate_ruta')
          ->with([
            'servicio' => $servicio,
            'id_user' => $decrypted
          ]);
        }

    }

    public function postRatevalue(){

        $tipo = Input::get('tipo');
        $id = Input::get('id');

        $servicio = DB::table('servicios')
        ->where('id',$id)
        ->update([
            'calificacion_app_cliente_calidad' => $tipo
        ]);

        return Response::json([
            'respuesta' => true,
            'tipo' => $tipo,
            'id' => $id
        ]);

    }

    public function postRatevalueruta(){

        $tipo = Input::get('tipo');
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

    public function postServicioruta(){

      $servicio_id = Input::get('id');

      $servicio = Servicio::find($servicio_id);
      $conductor = DB::table('conductores')->where('id',$servicio->conductor_id)->pluck('nombre_completo');

      if ($servicio) {
        return Response::json([
            'respuesta' => true,
            'servicio'=> $servicio,
            'conductor' => $conductor,
        ]);
      }
    }

    public function postServiciofinalizado(){

      $servicio_id = Input::get('id');

      $servicio = Servicio::find($servicio_id);
      $conductor = DB::table('conductores')->where('id',$servicio->conductor_id)->pluck('nombre_completo');

      $users = DB::table('qr_rutas')
      ->where('servicio_id',$servicio_id)
      ->get();

      if ($servicio) {
        return Response::json([
            'respuesta' => true,
            'servicio'=> $servicio,
            'conductor' => $conductor,
            'users' => $users
        ]);
      }
    }

    public function getMisservicios($email){

      if( null !== Crypt::decryptString($email) ){
        $decrypted = Crypt::decryptString($email);
      }else{
        $decrypted = 'NO';
      }



        $data = DB::table('servicios')
        ->where('email_solicitante',$decrypted)
        ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
        ->whereNull('pendiente_autori_eliminacion')
        ->where('servicios.anulado',0)
        ->whereNull('servicios.afiliado_externo')
        ->whereNull('servicios.ruta')
        ->first();
        if($data==null){
          return View::make('servicios.gps.no_servicios', [
            'email' => $decrypted,
          ]);
          echo "hola";
        }else{

            $query = DB::table('servicios')
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
            ->select('servicios.*',
                 'facturacion.revisado','facturacion.liquidado','facturacion.facturado','facturacion.factura_id',
                 'proveedores.tipo_afiliado', 'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro','users.first_name',
                 'users.last_name',
                 'rutas.nombre_ruta','rutas.codigo_ruta','proveedores.razonsocial AS razonproveedor',
                 'conductores.nombre_completo','conductores.celular','conductores.telefono','conductores.usuario_id',
                 'reconfirmacion.numero_reconfirmaciones','reconfirmacion.id as id_reconfirmacion','reconfirmacion.ejecutado',
                 'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo',
                 'encuesta.pregunta_1','encuesta.pregunta_2','encuesta.pregunta_3','encuesta.pregunta_4',
                 'encuesta.pregunta_8','encuesta.pregunta_9','encuesta.pregunta_10',
                 'servicios_edicion_pivote.id as id_pivote', 'reportes_pivote.id as id_reporte', 'servicios_autorizados_pdf.documento_pdf1', 'servicios_autorizados_pdf.documento_pdf2')
            ->where('servicios.anulado',0)
            ->where('servicios.email_solicitante',$decrypted)
            ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
            ->whereNull('servicios.pendiente_autori_eliminacion')
            ->whereNull('servicios.afiliado_externo')
            ->where('fecha_servicio',date('Y-m-d'))
            ->whereNull('servicios.ruta');

            $servicios = $query->orderBy('hora_servicio')->get();
            $o = 1;

            return View::make('servicios.gps.servicios', [

              'servicios' => $servicios,
              'email' => $decrypted,
              'o' => $o
            ]);

        }
    }

    public function postConsultardisponibilidad(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if (Request::ajax()) {

                $id = Input::get('id');
                $fecha_actual = date('Y-m-d');

                //
                $consultaservicios = "SELECT servicios.id, conductores.nombre_completo, servicios.recorrido_gps, servicios.estado_servicio_app FROM conductores
                  LEFT JOIN proveedores ON proveedores.id = conductores.proveedores_id
                  LEFT JOIN servicios ON servicios.conductor_id = conductores.id
                  WHERE servicios.localidad is null AND servicios.fecha_servicio = '".$fecha_actual."' order by id";
                $servicio = DB::select($consultaservicios);

                $consultaconductores = "SELECT conductores.id, conductores.nombre_completo FROM conductores
                LEFT JOIN proveedores ON proveedores.id = conductores.proveedores_id
                WHERE proveedores.localidad = 'barranquilla' AND proveedores.inactivo is null and proveedores.inactivo_total is null order by id";
                $conductores = DB::select($consultaconductores);

                if ($servicio) {
                    return Response::json([
                      'servicio' => $servicio,
                      'conductores' => $conductores,
                      'respuesta' => true
                    ]);
                }
            }
        }
    }

    public function postConsultardisponibilidadbog(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if (Request::ajax()) {

                $id = Input::get('id');
                $fecha_actual = date('Y-m-d');

                //
                $consultaservicios = "SELECT servicios.id, conductores.nombre_completo, servicios.recorrido_gps, servicios.estado_servicio_app FROM conductores
                  LEFT JOIN proveedores ON proveedores.id = conductores.proveedores_id
                  LEFT JOIN servicios ON servicios.conductor_id = conductores.id
                  WHERE servicios.localidad is not null AND servicios.fecha_servicio = '".$fecha_actual."' order by id";
                $servicio = DB::select($consultaservicios);

                $consultaconductores = "SELECT conductores.id, conductores.nombre_completo FROM conductores
                LEFT JOIN proveedores ON proveedores.id = conductores.proveedores_id
                WHERE proveedores.localidad = 'bogota' AND proveedores.inactivo is null and proveedores.inactivo_total is null order by id";
                $conductores = DB::select($consultaconductores);

                if ($servicio) {
                    return Response::json([
                      'servicio' => $servicio,
                      'conductores' => $conductores,
                      'respuesta' => true
                    ]);
                }
            }
        }
    }

    public function postActualizarmapa(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if (Request::ajax()) {

                $id = Input::get('id');
                $fecha_actual = date('Y-m-d');
                $consulta = "SELECT servicios.id, servicios.recoger_en, servicios.dejar_en, servicios.hora_servicio, conductores.nombre_completo, servicios.recorrido_gps, servicios.estado_servicio_app FROM conductores
                  LEFT JOIN proveedores ON proveedores.id = conductores.proveedores_id
                  LEFT JOIN servicios ON servicios.conductor_id = conductores.id
                  WHERE servicios.localidad is null AND servicios.fecha_servicio = '".$fecha_actual."' order by id";
                $servicio = DB::select($consulta);

                $consultaconductores = "SELECT conductores.id, conductores.nombre_completo, conductores.estado_aplicacion, conductores.gps FROM conductores
                LEFT JOIN proveedores ON proveedores.id = conductores.proveedores_id
                WHERE proveedores.localidad = 'barranquilla' AND proveedores.inactivo is null and proveedores.inactivo_total is null order by id";
                $conductores = DB::select($consultaconductores);

                $estado = DB::table($consulta);

                if ($servicio or $conductores) {
                    return Response::json([
                      'servicio' => $servicio,
                      'conductores' => $conductores,
                      'estado' => $estado,
                      'respuesta' => true
                    ]);
                }
            }
        }
    }

    public function postActualizarmapabog(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if (Request::ajax()) {

                $id = Input::get('id');
                $fecha_actual = date('Y-m-d');

                 $consulta = "SELECT servicios.id, servicios.recoger_en, servicios.dejar_en, servicios.hora_servicio, conductores.nombre_completo, servicios.recorrido_gps, servicios.estado_servicio_app FROM conductores
                  LEFT JOIN proveedores ON proveedores.id = conductores.proveedores_id
                  LEFT JOIN servicios ON servicios.conductor_id = conductores.id
                  WHERE servicios.localidad is not null AND servicios.fecha_servicio = '".$fecha_actual."' order by id";
                $servicio = DB::select($consulta);

                $consultaconductores = "SELECT conductores.id, conductores.nombre_completo, conductores.estado_aplicacion, conductores.gps FROM conductores
                LEFT JOIN proveedores ON proveedores.id = conductores.proveedores_id
                WHERE proveedores.localidad = 'bogota' AND proveedores.inactivo_total is null and proveedores.inactivo is null order by id";
                $conductores = DB::select($consultaconductores);
                //$conductores = null;

                $estado = DB::table($consulta);


                if ($servicio or $conductores) {
                    return Response::json([
                      'servicio' => $servicio,
                      'conductores' => $conductores,
                      'estado' => $estado,
                      'respuesta' => true
                    ]);
                }
            }
        }
    }

    public function postLocalizarconductor() {

        $id = Input::get('id');

        $servicio = Servicio::find($id);

        return Response::json([
            'respuesta' => true,
            'servicio' => $servicio
        ]);

    }

    public function postLocalizarconductoravailable() {

        $id = Input::get('id');

        $conductor = Conductor::find($id);

        return Response::json([
            'respuesta' => true,
            'conductor' => $conductor
        ]);

    }

    public function postValidarpoliticas() {

        $id = Input::get('id');

        $servicio = Servicio::find($id);

        if($servicio->notificaciones_reconfirmacion_cliente==1){

            return Response::json([
                'respuesta' => true
            ]);

        }else{

            $servicio->notificaciones_reconfirmacion_cliente = 1;
            $servicio->save();

            return Response::json([
                'respuesta' => false
            ]);

        }
    }

    public function postActualizarmapaviaje(){

        $id = Input::get('id');
        $servicio = DB::table('servicios')->where('id', $id)->pluck('recorrido_gps');
        $desde = DB::table('servicios')->where('id', $id)->pluck('desde');
        $hasta = DB::table('servicios')->where('id', $id)->pluck('hasta');
        $estado = DB::table('servicios')->where('id', $id)->pluck('estado_servicio_app');
        $recoger_pasajero = DB::table('servicios')->where('id', $id)->pluck('recoger_pasajero');
        //$conductor = DB::table('servicios')->where('id', 205899)->pluck('recorrido_gps');

        /*$sound = Input::get('sound');
        if($sound==1){
            $update = DB::table('servicios')
            ->where('id',$id)
            ->update([
                'estado_km' = 1
            ]);
        }*/

          return Response::json([
              'servicio' => $servicio,
              'estado' => $estado,
              'recoger' =>$recoger_pasajero,
              //'conductor' => $conductor,
              'desde' => $desde,
              'hasta' => $hasta,
              'respuesta' => true
          ]);

  }

    public function postActualizarmaparuta(){

        $id = Input::get('id');

        $user = DB::table('qr_rutas')
        ->where('id',Input::get('id_user'))
        ->first();

        $servicio = DB::table('servicios')->where('id', $id)->pluck('recorrido_gps');
        $desde = DB::table('servicios')->where('id', $id)->pluck('desde');
        $hasta = DB::table('servicios')->where('id', $id)->pluck('hasta');
        $estado = DB::table('servicios')->where('id', $id)->pluck('estado_servicio_app');
        $recoger_pasajero = DB::table('servicios')->where('id', $id)->pluck('recoger_pasajero');

        return Response::json([
          'servicio' => $servicio,
          'estado' => $estado,
          'recoger' =>$recoger_pasajero,
          //'conductor' => $conductor,
          'desde' => $desde,
          'hasta' => $hasta,
          'lat' => json_decode($user->coords)[0]->lat,
          'lng' => json_decode($user->coords)[0]->lng,
          'sw' => $user->sw,
          'location' => $user->location,
          'respuesta' => true
        ]);

    }

    public function postSimular() {

        //Objeto array json
        $objArray = null;

        //Array a insertar en json

        $array = [
            'latitude' => 4.643744,
            'longitude' => -74.074437,
            'timestamp' => date('Y-m-d H:i:s')
        ];

        $id = 611655;
        $servicio = Servicio::find($id);// DB::table('servicios')->where('id',$id)->first();

        $objArray = json_decode($servicio->recorrido_gps);
        array_push($objArray, $array);
        $servicio->recorrido_gps = json_encode($objArray);
        $servicio->save();

        return Response::json([
            'respuesta' => true
        ]);

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


}

?>
