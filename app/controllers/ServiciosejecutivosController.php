<?php

/**
 * Controlador para el modulo de transportes
 */
class ServiciosejecutivosController extends BaseController{

  /**
   * Metodo para mostrar todos los servicios del dia
   * @return View Vista
   */

   //INICIO NUEVOS SERVICIOS
  public function getIndex(){

    if (Sentry::check()){

      $id_rol = Sentry::getUser()->id_rol;
      $idusuario = Sentry::getUser()->id;
      $cliente = Sentry::getUser()->centrodecosto_id;
      $subcentro = Sentry::getUser()->subcentrodecosto_id;
      $userportal = Sentry::getUser()->usuario_portal;
      $centrodecostoname = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
      $centrodecostolocalidad = DB::table('centrosdecosto')->where('id',$cliente)->pluck('localidad');
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      if($cliente==329 || $cliente==343 || $cliente==287 || $cliente==19 || $cliente==489 || $cliente==97){
        $ver = 'on';
      }else{
        $ver = null;
      }

    }else{
      $ver = null;
    }

    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on') {

      return View::make('admin.permisos');

    }else{

      $usuario = Sentry::getUser()->id;

      if(Sentry::getUser()->username==='dcreyes@coninsa.co'){

        $query = DB::table('servicios_autonet')
        ->whereNull('estado_programado')
        ->where('centrodecosto_id',$cliente);

      }else if($cliente==343){

        $query = DB::table('servicios_autonet')
        ->whereNull('estado_programado')
        ->where('creado_por',$usuario)
        ->where('centrodecosto_id',$cliente);

      }else{

        if($cliente==329){

          $query = DB::table('servicios_autonet')
          ->whereNull('estado_programado')
          ->where('centrodecosto_id',$cliente)
          ->where('solicitado_por',Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name);

        }else if($cliente==489){

          $query = DB::table('servicios_autonet')
          ->whereNull('estado_programado')
          ->where('creado_por',$usuario)
          ->where('centrodecosto_id',$cliente);

        }else{

          $query = DB::table('servicios_autonet')
          ->whereNull('estado_programado')
          ->where('centrodecosto_id',$cliente);

        }

      }

      $servicios = $query->orderBy('time')->get();

      $departamentos = DB::table('departamento')->get();

      /*$tarifas = DB::table('tarifa_traslado')
      ->select('tarifa_cliente_minivan_'.$cliente.'', 'tarifa_cliente_van_'.$cliente.'', 'tarifa_cliente_bus_'.$cliente.'', 'tarifa_cliente_buseta_'.$cliente.'', 'tarifa_cliente_automovil_'.$cliente.'', 'id', 'tarifa_nombre', 'tarifa_ciudad')
      ->orWhereNotNull('tarifa_cliente_minivan_'.$cliente.'')
      ->orWhereNotNull('tarifa_cliente_van_'.$cliente.'')
      ->orWhereNotNull('tarifa_cliente_bus_'.$cliente.'')
      ->orWhereNotNull('tarifa_cliente_buseta_'.$cliente.'')
      ->orWhereNotNull('tarifa_cliente_automovil_'.$cliente.'')
      ->get();*/

      $tarifas = DB::table('tarifa_traslado')
      ->where('id',1111121)
      ->get();

      $o = 1;

      if($cliente==343){

        return View::make('servicios.servicios_ejecutivos.cliente.principal2', [
          'cliente' => $cliente,
          'servicios' => $servicios,
          'permisos' => $permisos,
          'userportal' => $userportal,
          'cliente' => $centrodecostoname,
          'departamentos'=>$departamentos,
          'tarifas' => $tarifas,
          'o' => $o
        ]);

      }else{

        return View::make('servicios.servicios_ejecutivos.cliente.principal', [
          'cliente' => $cliente,
          'servicios' => $servicios,
          'permisos' => $permisos,
          'userportal' => $userportal,
          'cliente' => $centrodecostoname,
          'departamentos'=>$departamentos,
          'tarifas' => $tarifas,
          'o' => $o
        ]);

      }

    }

  }

  public function postBuscar(){

    $id_rol = Sentry::getUser()->id_rol;
    $idusuario = Sentry::getUser()->id;
    $subcentrodecosto = Sentry::getUser()->subcentrodecosto_id;
    $cliente = Sentry::getUser()->centrodecosto_id;
    $centrodecostoname = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
    $centrodecostolocalidad = DB::table('centrosdecosto')->where('id',$cliente)->pluck('localidad');
    $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
    $permisos = json_decode($permisos);

    if (!Sentry::check()){

        return Response::json([
            'respuesta'=>'relogin'
        ]);

    }else{

        if (Request::ajax()){
            $usuario = Sentry::getUser()->id;
            $fecha_inicial = Input::get('fecha_inicial');
            $fecha_final = Input::get('fecha_final');
            $servicio = intval(Input::get('servicios'));

            $codigo = Input::get('codigo');

              if(Sentry::getUser()->centrodecosto_id==19 or Sentry::getUser()->centrodecosto_id==287){

                $consulta = "select servicios.id, servicios.fecha_orden, servicios.fecha_servicio, servicios.solicitado_por, servicios.programado_app, ".
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
                    "where servicios.fecha_servicio between '".$fecha_inicial."' AND '".$fecha_final."' ";

                    
                      
                      if(Sentry::getUser()->subcentrodecosto_id!=null) {
                        $consulta .= " and servicios.centrodecosto_id in (287) and servicios.subcentrodecosto_id = 853 ";
                      }else{
                        
                        if(Input::get('ciudad')!='CIUDAD'){
                          $consulta .= " and servicios.centrodecosto_id = ".Input::get('ciudad')." ";
                        }

                      }

                    //$consulta .= " and servicios.centrodecosto_id in (19) ";

              }else if(Sentry::getUser()->username=='dcreyes@coninsa.co' or $cliente!=343){

                $consulta = "select servicios.id, servicios.fecha_orden, servicios.fecha_servicio, servicios.solicitado_por, servicios.programado_app, ".
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
                    "where servicios.fecha_servicio between '".$fecha_inicial."' AND '".$fecha_final."' and servicios.centrodecosto_id = '".$cliente."' and servicios.ruta is null ";

                    if($cliente==329){
                      $consulta .=" and servicios.solicitado_por = '".Sentry::getUser()->first_name." ".Sentry::getUser()->last_name."' ";
                    }

              }else if($cliente==343){
                $consulta = "select servicios.id, servicios.fecha_orden, servicios.fecha_servicio, servicios.solicitado_por, servicios.programado_app, ".
                    "servicios.resaltar, servicios.pago_directo, servicios.fecha_solicitud, servicios.ciudad, servicios.recoger_en, servicios.ruta, ".
                    "servicios.dejar_en, servicios.detalle_recorrido, servicios.pasajeros, servicios.pasajeros_ruta, servicios.finalizado, servicios.pendiente_autori_eliminacion, ".
                    "servicios.hora_servicio, servicios.origen, servicios.destino, servicios.fecha_pago_directo, servicios.rechazar_eliminacion, ".
                    "servicios.estado_servicio_app, servicios.recorrido_gps, servicios.calificacion_app_conductor_calidad, servicios_autonet.creado_por, ".
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
                    "left join servicios_autonet on servicios.id = servicios_autonet.servicio_id ".
                    "where servicios.fecha_servicio between '".$fecha_inicial."' AND '".$fecha_final."' and servicios.centrodecosto_id = '".$cliente."' and servicios_autonet.creado_por = '".$usuario."' and servicios.ruta is null ";
              }


                  //$consulta .=" and servicios.control_facturacion is null order by servicios.hora_servicio";

                  if(!$id_rol==1 or $id_rol==2 or $id_rol==8){

                    $consulta .=" and servicios.control_facturacion is null";
                      //$servicios = $consulta->whereNull('servicios.control_facturacion')->orderBy('hora_servicio')->get();
                  }

            $servicios = DB::select(DB::raw($consulta." and servicios.pendiente_autori_eliminacion is null order by servicios.fecha_servicio ASC, servicios.hora_servicio ASC"));

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
                    'id_number'=>$idArray,
                    'cliente' => $cliente
                ]);

            }else{

                return Response::json([
                    'mensaje'=>false,
                ]);
            }
        }
    }
}

  public function getDescargarservicio($id){

    $servicio = DB::table('servicios')
    ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
    ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
    ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.recoger_en', 'servicios.dejar_en', 'servicios.detalle_recorrido', 'servicios.ciudad', 'servicios.origen', 'servicios.destino', 'servicios.aerolinea', 'servicios.vuelo', 'servicios.hora_salida', 'servicios.hora_llegada', 'conductores.nombre_completo', 'conductores.cc', 'conductores.celular', 'conductores.foto', 'conductores.foto_app', 'vehiculos.placa', 'vehiculos.color', 'vehiculos.clase', 'vehiculos.marca', 'vehiculos.modelo')
    ->where('servicios.id',$id)
    ->first();

    $html = View::make('servicios.servicios_ejecutivos.cliente.descargar_servicio')->with([
      'servicio' => $servicio,
    ]);

    return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('Orden de Servicio # '.$id);

  }

  public function getEmail($id){

    $servicio = DB::table('servicios')
    ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
    ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
    ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.recoger_en', 'servicios.dejar_en', 'servicios.detalle_recorrido', 'servicios.ciudad', 'servicios.origen', 'servicios.destino', 'servicios.aerolinea', 'servicios.vuelo', 'servicios.hora_salida', 'servicios.hora_llegada', 'conductores.nombre_completo', 'conductores.cc', 'conductores.celular', 'vehiculos.placa', 'vehiculos.color', 'vehiculos.clase', 'vehiculos.marca', 'vehiculos.modelo')
    ->where('servicios.id',$id)
    ->first();

    return View::make('servicios.servicios_ejecutivos.cliente.descargar_servicio', [
      'servicio' => $servicio,
    ]);

  }

  public function postNuevoservicio(){

    if (!Sentry::check()){

      return Response::json([
        'respuesta'=> 'relogin'
      ]);

    }else{

      if(Request::ajax()){

          $pasajeros = [];
          $pasajeros_todos='';
          $nombres_pasajeros='';
          $celulares_pasajeros='';

          $option = Input::get('option');

          $validaciones = [

          ];

          $mensajes = [

          ];

          $validador = Validator::make(Input::all(), $validaciones,$mensajes);

          if ($validador->fails()){

            return Response::json([
              'mensaje'=>false,
              'errores'=>$validador->errors()->getMessages()
            ]);

          }else{

            $estado_email = Input::get('estado_email');
            $sede = Input::get('sede');

            //DATOS DE LOS PASAJEROS CONVERTIDOS A ARRAYS
            $nombre_pasajeros = explode(',', Input::get('nombres_pasajeros'));
            $celular_pasajeros = explode(',', Input::get('celular_pasajeros'));
            //$nivel_pasajeros = explode(',', Input::get('nivel_pasajeros'));
            $email_pasajeros = explode(',', Input::get('email_pasajeros'));

            //CONCATENACION DE TODOS LOS DATOS
            for($i=0; $i < count($nombre_pasajeros); $i++){
              $pasajeros[$i] = $nombre_pasajeros[$i].','.$celular_pasajeros[$i].','.$email_pasajeros[$i].'/';
              $pasajeros_nombres[$i] = $nombre_pasajeros[$i].',';
              $pasajeros_telefonos[$i] = $celular_pasajeros[$i].',';
              $pasajeros_todos = $pasajeros_todos.$pasajeros[$i];
              $nombres_pasajeros = $nombres_pasajeros.$pasajeros_nombres[$i];
              $celulares_pasajeros = $celulares_pasajeros.$pasajeros_telefonos[$i];
            }

              //ARRAY DE LOS CAMPOS DE LOS SERVICIOS
              $notificacionesArray = explode(',', Input::get('notificacionesArray'));
              $resaltarArray = explode(',', Input::get('resaltarArray'));
              $pago_directoArray = explode(',',Input::get('pago_directoArray'));
              $rutaArray = explode(',', Input::get('rutaArray'));
              $detalleArray = explode(',', Input::get('detalleArray'));
              $recoger_enArray = explode(',', Input::get('recoger_enArray'));
              $dejar_enArray = explode(',', Input::get('dejar_enArray'));
              $fechainicioArray = explode(',', Input::get('fechainicioArray'));
              $horainicioArray = explode(',', Input::get('horainicioArray'));

              $origenArray = Input::get('origenArray');
              $destinoArray = Input::get('destinoArray');
              $vueloArray = Input::get('vueloArray');
              $aerolineaArray = Input::get('aerolineaArray');
              $hora_llegadaArray = Input::get('hora_llegadaArray');
              $hora_salidaArray = Input::get('hora_salidaArray');

              $expediente = Input::get('expediente');

              $centrodecosto_valor = Sentry::getUser()->centrodecosto_id;

              /*FOR PARA INSERTAR LOS REGISTROS DE LA TABLA DE SERVICIOS SEGUN EL NUMERO DE FILAS INSERTADAS CONTADAS
                POR EL NUMERO DE SERVICIOS QUE SE INGRESARON EN LA TABLA*/
              $contar = 0;
              $contar_falso = 0;
              $servicio_id ='';
              $cantidadArrays = count($rutaArray);
              $countTrue = 0;
              $countFalse = 0;

              for($i=0; $i<$cantidadArrays; $i++){

                $servicio = new ServicioA();
                $servicio->centrodecosto_id = $centrodecosto_valor;
                $servicio->passengers = $pasajeros_todos;
                $servicio->departamento = Input::get('departamento');
                $servicio->ciudad = Input::get('ciudad');
                $servicio->request_date = date('Y-m-d');

                $servicio->origen = $origenArray;
                $servicio->destino = $destinoArray;
                $servicio->vuelo = $vueloArray;
                $servicio->aerolinea = $aerolineaArray;
                $servicio->hora_llegada = $hora_llegadaArray;
                $servicio->hora_salida = $hora_salidaArray;

                $servicio->pickup = $recoger_enArray[$i];
                $servicio->destination = $dejar_enArray[$i];
                $servicio->requeriments = $detalleArray[$i];
                $servicio->date = $fechainicioArray[$i];
                $servicio->time = $horainicioArray[$i];
                $servicio->localidad = $sede;
                $servicio->expediente = $expediente;
                $servicio->solicitado_por = Sentry::getUser()->first_name. ' '.Sentry::getUser()->last_name;
                $servicio->creado_por = Sentry::getUser()->id;
                $servicio->email_solicitante = Sentry::getUser()->username;
                $servicio->tipo_request = 2;

                $servicio->save();

                /*NOTIFIVACIÓN PUSHER*/

                if($sede=='Barranquilla'){
                  $canal = 'autonetbaq';
                  $sin_programar = ServicioA::whereNull('estado_programado')->where('localidad','barranquilla')->count();
                }else if($sede=='Bogota'){
                  $canal = 'autonetbog';
                  $sin_programar = ServicioA::whereNull('estado_programado')->where('localidad','bogota')->count();
                }
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

                /* FIN NOTIFICACIÓN PUSHER*/

              }

              return Response::json([
                'mensaje'=>true,
                'pasajeros'=>$pasajeros_todos,
                'servicio_id'=>$servicio_id,
              ]);

          }
      }
    }
  }

  public function postNuevoservicio2(){

    if (!Sentry::check()){

      return Response::json([
        'respuesta'=> 'relogin'
      ]);

    }else{

      if(Request::ajax()){

          $pasajeros = [];
          $pasajeros_todos='';
          $nombres_pasajeros='';
          $celulares_pasajeros='';

          $option = Input::get('option');

          $validaciones = [

          ];

          $mensajes = [

          ];

          $validador = Validator::make(Input::all(), $validaciones,$mensajes);

          if ($validador->fails()){

            return Response::json([
              'mensaje'=>false,
              'errores'=>$validador->errors()->getMessages()
            ]);

          }else{

            $estado_email = Input::get('estado_email');
            $sede = Input::get('sede');

            //DATOS DE LOS PASAJEROS CONVERTIDOS A ARRAYS
            $nombre_pasajeros = explode(',', Input::get('nombres_pasajeros'));
            $celular_pasajeros = explode(',', Input::get('celular_pasajeros'));
            //$nivel_pasajeros = explode(',', Input::get('nivel_pasajeros'));
            $email_pasajeros = explode(',', Input::get('email_pasajeros'));

            //CONCATENACION DE TODOS LOS DATOS
            for($i=0; $i < count($nombre_pasajeros); $i++){
              $pasajeros[$i] = $nombre_pasajeros[$i].','.$celular_pasajeros[$i].','.$email_pasajeros[$i].'/';
              $pasajeros_nombres[$i] = $nombre_pasajeros[$i].',';
              $pasajeros_telefonos[$i] = $celular_pasajeros[$i].',';
              $pasajeros_todos = $pasajeros_todos.$pasajeros[$i];
              $nombres_pasajeros = $nombres_pasajeros.$pasajeros_nombres[$i];
              $celulares_pasajeros = $celulares_pasajeros.$pasajeros_telefonos[$i];
            }

              //ARRAY DE LOS CAMPOS DE LOS SERVICIOS
              $notificacionesArray = explode(',', Input::get('notificacionesArray'));
              $resaltarArray = explode(',', Input::get('resaltarArray'));
              $pago_directoArray = explode(',',Input::get('pago_directoArray'));
              $rutaArray = explode(',', Input::get('rutaArray'));
              $detalleArray = explode(',', Input::get('detalleArray'));
              $recoger_enArray = explode(',', Input::get('recoger_enArray'));
              $dejar_enArray = explode(',', Input::get('dejar_enArray'));
              $fechainicioArray = explode(',', Input::get('fechainicioArray'));
              $horainicioArray = explode(',', Input::get('horainicioArray'));

              $origenArray = Input::get('origenArray');
              $destinoArray = Input::get('destinoArray');
              $vueloArray = Input::get('vueloArray');
              $aerolineaArray = Input::get('aerolineaArray');
              $hora_llegadaArray = Input::get('hora_llegadaArray');
              $hora_salidaArray = Input::get('hora_salidaArray');

              $sucursal = Input::get('sucursal');
              $centrodecosto = Input::get('centrodecosto');

              $centrodecosto_valor = Sentry::getUser()->centrodecosto_id;

              /*FOR PARA INSERTAR LOS REGISTROS DE LA TABLA DE SERVICIOS SEGUN EL NUMERO DE FILAS INSERTADAS CONTADAS
                POR EL NUMERO DE SERVICIOS QUE SE INGRESARON EN LA TABLA*/
              $contar = 0;
              $contar_falso = 0;
              $servicio_id ='';
              $cantidadArrays = count($rutaArray);
              $countTrue = 0;
              $countFalse = 0;

              for($i=0; $i<$cantidadArrays; $i++){

                $servicio = new ServicioA();
                $servicio->centrodecosto_id = $centrodecosto_valor;
                $servicio->passengers = $pasajeros_todos;
                $servicio->departamento = Input::get('departamento');
                $servicio->ciudad = Input::get('ciudad');
                $servicio->request_date = date('Y-m-d');

                $servicio->origen = $origenArray;
                $servicio->destino = $destinoArray;
                $servicio->vuelo = $vueloArray;
                $servicio->aerolinea = $aerolineaArray;
                $servicio->hora_llegada = $hora_llegadaArray;
                $servicio->hora_salida = $hora_salidaArray;

                $servicio->pickup = $recoger_enArray[$i];
                $servicio->destination = $dejar_enArray[$i];
                $servicio->requeriments = $detalleArray[$i];
                $servicio->date = $fechainicioArray[$i];
                $servicio->time = $horainicioArray[$i];
                $servicio->localidad = $sede;
                //$servicio->expediente = $expediente;
                $servicio->sucursal = $sucursal;
                $servicio->centrodecosto = $centrodecosto;
                $servicio->solicitado_por = Sentry::getUser()->first_name. ' '.Sentry::getUser()->last_name;
                $servicio->creado_por = Sentry::getUser()->id;
                $servicio->email_solicitante = Sentry::getUser()->username;
                $servicio->tipo_request = 2;

                $servicio->save();

                /*NOTIFIVACIÓN PUSHER*/

                if($sede=='Barranquilla'){
                  $canal = 'autonetbaq';
                  $sin_programar = ServicioA::whereNull('estado_programado')->where('localidad','barranquilla')->count();
                }else if($sede=='Bogota'){
                  $canal = 'autonetbog';
                  $sin_programar = ServicioA::whereNull('estado_programado')->where('localidad','bogota')->count();
                }
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

                /* FIN NOTIFICACIÓN PUSHER*/

              }

              return Response::json([
                'mensaje'=>true,
                'pasajeros'=>$pasajeros_todos,
                'servicio_id'=>$servicio_id,
              ]);

          }
      }
    }
  }

  public function postImportarexcel(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          $var = '';
          $nombres_ruta = NombreRuta::where('centrodecosto_id', Input::get('centrodecosto_id'))->get();

          Excel::selectSheetsByIndex(0)->load(Input::file('excel'), function($reader) use ($nombres_ruta){

              $reader->skip(1);
              $result = $reader->noHeading()->get();

              $pasajerosArray = [];
              foreach($result as $value){

                $nombre_excel = $value[0];

                $apellidos_excel = $value[1];

                if(is_string($value[0])){

                  $dataExcel = [
                    'ciudad' => strtoupper(trim($value[0])),
                    'expediente' => strtoupper(trim($value[1])),
                    'passengers' => strtoupper(trim($value[2])),
                    'phone' => trim($value[3]),
                    'email' => strtoupper(trim($value[4])),
                    'date' => strtoupper(trim($value[5])),
                    'triptime' => trim($value[6]),
                    'pickup' => strtoupper(trim($value[7])),
                    'destination' => strtoupper(trim($value[8])),
                    'requeriments' => strtoupper(trim($value[9])),

                    'origen' => strtoupper(trim($value[10])),
                    'destino' => strtoupper(trim($value[11])),
                    'aerolinea' => strtoupper(trim($value[12])),
                    'vuelo' => strtoupper(trim($value[13])),
                    'hora_salida' => strtoupper(trim($value[14])),
                    'hora_llegada' => strtoupper(trim($value[15])),
                  ];

                  array_push($pasajerosArray, $dataExcel);

                }

              }

              echo json_encode([
                'pasajeros' => $pasajerosArray,
                'nombres_ruta' => $nombres_ruta
              ]);

          });

      }

  }

    public function postImportarexcel2(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            $var = '';
            $nombres_ruta = NombreRuta::where('centrodecosto_id', Input::get('centrodecosto_id'))->get();

            Excel::selectSheetsByIndex(0)->load(Input::file('excel'), function($reader) use ($nombres_ruta){

                $reader->skip(1);
                $result = $reader->noHeading()->get();

                $pasajerosArray = [];
                foreach($result as $value){

                  $nombre_excel = $value[0];

                  $apellidos_excel = $value[1];

                  if(is_string($value[0])){

                    $dataExcel = [
                      'ciudad' => strtoupper(trim($value[0])),
                      'cc' => strtoupper(trim($value[1])),
                      'suc' => strtoupper(trim($value[2])),
                      'passengers' => strtoupper(trim($value[3])),
                      'phone' => trim($value[4]),
                      'email' => strtoupper(trim($value[5])),
                      'date' => strtoupper(trim($value[6])),
                      'triptime' => trim($value[7]),
                      'pickup' => strtoupper(trim($value[8])),
                      'destination' => strtoupper(trim($value[9])),
                      'requeriments' => strtoupper(trim($value[10])),

                      'origen' => strtoupper(trim($value[11])),
                      'destino' => strtoupper(trim($value[12])),
                      'aerolinea' => strtoupper(trim($value[13])),
                      'vuelo' => strtoupper(trim($value[14])),
                      'hora_salida' => strtoupper(trim($value[15])),
                      'hora_llegada' => strtoupper(trim($value[16])),
                    ];

                    array_push($pasajerosArray, $dataExcel);

                  }

                }

                echo json_encode([
                  'pasajeros' => $pasajerosArray,
                  'nombres_ruta' => $nombres_ruta
                ]);

            });

        }

    }

    public function postNuevosservicios(){

      if (!Sentry::check()){
        return Response::json([
            'respuesta' => 'relogin'
        ]);
      }else{

        $servicios_nuevos = json_decode(Input::get('servicios'));
        $sw=0;
        $sw2 = 0;
        $sede = Input::get('sede');

        foreach ($servicios_nuevos as $item) {

          $cliente = Sentry::getUser()->centrodecosto_id;

          $pasajeros = [];
          $pasajeros_todos='';
          $nombres_pasajeros='';
          $celulares_pasajeros='';

          $nombre_pasajeros = explode(',', $item->passengers);
          $celular_pasajeros = explode('-', $item->phone);
          $email_pasajeros = explode(',', $item->email);

          //CONCATENACION DE TODOS LOS DATOS
          for($i=0; $i<count($nombre_pasajeros); $i++){

            if(!isset($celular_pasajeros[$i])){
              $cel = '';
            }else{
              $cel = $celular_pasajeros[$i];
            }

            if(!isset($email_pasajeros[$i])){
              $email_pax = '';
            }else{
              $email_pax = $email_pasajeros[$i];
            }

            $pasajeros[$i] = $nombre_pasajeros[$i].','.$cel.','.$email_pax.'/';
            $pasajeros_nombres[$i] = $nombre_pasajeros[$i].',';
            $pasajeros_telefonos[$i] = $cel.',';
            $pasajeros_todos = $pasajeros_todos.$pasajeros[$i];
            $nombres_pasajeros = $nombres_pasajeros.$pasajeros_nombres[$i];
            $celulares_pasajeros = $celulares_pasajeros.$pasajeros_telefonos[$i];

          }

          $servicio_nuevo = new ServicioA();
          $servicio_nuevo->ciudad_excel = $item->ciudad;
          $servicio_nuevo->passengers = $pasajeros_todos;

          if(isset($item->phone)){
            $servicio_nuevo->phone = $item->phone;
          }

          if(isset($item->email)){
            $servicio_nuevo->email = $item->email;
          }

          $servicio_nuevo->date = $item->date;

          if(isset($item->triptime)){
            $servicio_nuevo->time = $item->triptime;
          }

          if(isset($item->requeriments)){
            $servicio_nuevo->requeriments = $item->requeriments;
          }

          if(isset($item->origen)){
            $servicio_nuevo->origen = $item->origen;
          }

          if(isset($item->destino)){
            $servicio_nuevo->destino = $item->destino;
          }

          if(isset($item->aerolinea)){
            $servicio_nuevo->aerolinea = $item->aerolinea;
          }

          if(isset($item->vuelo)){
            $servicio_nuevo->vuelo = $item->vuelo;
          }

          if(isset($item->hora_salida)){
            $servicio_nuevo->hora_salida = $item->hora_salida;
          }

          if(isset($item->hora_llegada)){
            $servicio_nuevo->hora_llegada = $item->hora_llegada;
          }
          if(isset($item->centrodecosto)){
            $servicio_nuevo->centrodecosto = $item->centrodecosto;
          }
          if(isset($item->sucursal)){
            $servicio_nuevo->sucursal = $item->sucursal;
          }
          if(isset($item->expediente)){
            $servicio_nuevo->expediente = $item->expediente;
          }
          $servicio_nuevo->centrodecosto_id = Sentry::getUser()->centrodecosto_id;
          $servicio_nuevo->pickup = $item->pickup;
          $servicio_nuevo->destination = $item->destination;
          $servicio_nuevo->localidad = $sede;
          $servicio_nuevo->request_date = date('Y-m-d');
          $servicio_nuevo->solicitado_por = Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name;
          $servicio_nuevo->creado_por = Sentry::getUser()->id;
          $servicio_nuevo->tipo_request = 1;
          $servicio_nuevo->email_solicitante = Sentry::getUser()->username;

          $servicio_nuevo->save();
          $sw++;

        }

        if($sw!=0){

          /*NOTIFIVACIÓN PUSHER*/

          if($sede=='Barranquilla'){
            $canal = 'autonetbaq';
            $sin_programar = ServicioA::whereNull('estado_programado')->where('localidad','barranquilla')->count();
          }else if($sede=='Bogota'){
            $canal = 'autonetbog';
            $sin_programar = ServicioA::whereNull('estado_programado')->where('localidad','bogota')->count();
          }
          $idpusher = "578229";
          $keypusher = "a8962410987941f477a1";
          $secretpusher = "6a73b30cfd22bc7ac574";

          //CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
          $channel = 'servicios';
          $name = $canal;

          $data = json_encode([
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

          /* FIN NOTIFICACIÓN PUSHER*/

          return Response::json([
            'respuesta'=>true,
          ]);
        }else{
          return Response::json([
            'respuesta'=>false,
          ]);
        }

        return Response::json([
          'respuesta'=>false,
        ]);
      }

    }//SG

  public function getProgramados(){

    if (Sentry::check()){

      $id_rol = Sentry::getUser()->id_rol;
      $idusuario = Sentry::getUser()->id;
      $cliente = Sentry::getUser()->centrodecosto_id;

      $userportal = Sentry::getUser()->usuario_portal;
      $centrodecostoname = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
      $centrodecostolocalidad = DB::table('centrosdecosto')->where('id',$cliente)->pluck('localidad');
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      if($cliente==329 || $cliente==343 || $cliente==287 || $cliente==19 || $cliente==489 || $cliente==97){
        $ver = 'on';
      }else{
        $ver = null;
      }

    }else{
      $ver = null;
    }

    if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on') {

        return View::make('admin.permisos');

    }else{

        if(Sentry::getUser()->username=='dcreyes@coninsa.co'){

          $query = DB::table('servicios')
          ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
          ->LeftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
          ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
          ->leftJoin('servicios_autonet', 'servicios.id', '=', 'servicios_autonet.servicio_id')
          ->select('servicios.*',
                'centrosdecosto.razonsocial',
                'conductores.nombre_completo','conductores.celular','conductores.telefono','conductores.usuario_id',
                'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo', 'servicios_autonet.expediente')
          ->where('servicios.anulado',0)
          ->where('servicios.centrodecosto_id',$cliente)
          ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
          ->whereNull('servicios.pendiente_autori_eliminacion')
          ->whereNull('servicios.afiliado_externo')
          ->where('fecha_servicio',date('Y-m-d'))
          ->whereNull('servicios.ruta');

        }else if($cliente==343){

          $usuario = Sentry::getUser()->id;

          $query = DB::table('servicios')
          ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
          ->LeftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
          ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
          ->leftJoin('servicios_autonet', 'servicios.id', '=', 'servicios_autonet.servicio_id')
          ->select('servicios.*',
                'centrosdecosto.razonsocial',
                'conductores.nombre_completo','conductores.celular','conductores.telefono','conductores.usuario_id',
                'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo', 'servicios_autonet.expediente', 'servicios_autonet.creado_por')
          ->where('servicios.anulado',0)
          ->where('servicios.centrodecosto_id',$cliente)
          ->where('servicios_autonet.creado_por', $usuario)
          ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
          ->whereNull('servicios.pendiente_autori_eliminacion')
          ->whereNull('servicios.afiliado_externo')
          ->where('fecha_servicio',date('Y-m-d'))
          ->whereNull('servicios.ruta');

        }else if($cliente==329){ //AVIATUR

          $query = DB::table('servicios')
          ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
          ->LeftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
          ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
          ->leftJoin('servicios_autonet', 'servicios.id', '=', 'servicios_autonet.servicio_id')
          ->select('servicios.*',
                'centrosdecosto.razonsocial',
                'conductores.nombre_completo','conductores.celular','conductores.telefono','conductores.usuario_id',
                'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo', 'servicios_autonet.expediente')
          ->where('servicios.anulado',0)
          ->where('servicios.centrodecosto_id',$cliente)
          ->where('servicios.solicitado_por',Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name)
          ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
          ->whereNull('servicios.pendiente_autori_eliminacion')
          ->whereNull('servicios.afiliado_externo')
          ->where('fecha_servicio',date('Y-m-d'))
          ->whereNull('servicios.ruta');

        }else if($cliente==19){

          $query = DB::table('servicios')
          ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
          ->LeftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
          ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
          ->leftJoin('servicios_autonet', 'servicios.id', '=', 'servicios_autonet.servicio_id')
          ->select('servicios.*',
                'centrosdecosto.razonsocial',
                'conductores.nombre_completo','conductores.celular','conductores.telefono','conductores.usuario_id',
                'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo', 'servicios_autonet.expediente')
          ->where('servicios.anulado',0)
          ->whereIn('servicios.centrodecosto_id',[19])
          ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
          ->whereNull('servicios.pendiente_autori_eliminacion')
          ->whereNull('servicios.afiliado_externo')
          ->where('fecha_servicio',date('Y-m-d'))
          ->whereNull('servicios.ruta');


        }else if($cliente==287){

          if(Sentry::getUser()->subcentrodecosto_id!=null) {

            $query = DB::table('servicios')
            ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
            ->LeftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
            ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
            ->leftJoin('servicios_autonet', 'servicios.id', '=', 'servicios_autonet.servicio_id')
            ->select('servicios.*',
                  'centrosdecosto.razonsocial',
                  'conductores.nombre_completo','conductores.celular','conductores.telefono','conductores.usuario_id',
                  'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo', 'servicios_autonet.expediente')
            ->where('servicios.anulado',0)
            ->where('servicios.centrodecosto_id',287)
            ->where('servicios.subcentrodecosto_id',853)
            ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
            ->whereNull('servicios.pendiente_autori_eliminacion')
            ->whereNull('servicios.afiliado_externo')
            ->where('fecha_servicio',date('Y-m-d'))
            ->whereNull('servicios.ruta');

          }else{

            $query = DB::table('servicios')
            ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
            ->LeftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
            ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
            ->leftJoin('servicios_autonet', 'servicios.id', '=', 'servicios_autonet.servicio_id')
            ->select('servicios.*',
                  'centrosdecosto.razonsocial',
                  'conductores.nombre_completo','conductores.celular','conductores.telefono','conductores.usuario_id',
                  'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo', 'servicios_autonet.expediente')
            ->where('servicios.anulado',0)
            ->where('servicios.centrodecosto_id',287)
            ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
            ->whereNull('servicios.pendiente_autori_eliminacion')
            ->whereNull('servicios.afiliado_externo')
            ->where('fecha_servicio',date('Y-m-d'))
            ->whereNull('servicios.ruta');

          }


        }else{

          $query = DB::table('servicios')
          ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
          ->LeftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
          ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
          ->leftJoin('servicios_autonet', 'servicios.id', '=', 'servicios_autonet.servicio_id')
          ->select('servicios.*',
                'centrosdecosto.razonsocial',
                'conductores.nombre_completo','conductores.celular','conductores.telefono','conductores.usuario_id',
                'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo', 'servicios_autonet.expediente')
          ->where('servicios.anulado',0)
          ->where('servicios.centrodecosto_id',$cliente)
          ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
          ->whereNull('servicios.pendiente_autori_eliminacion')
          ->whereNull('servicios.afiliado_externo')
          ->where('fecha_servicio',date('Y-m-d'))
          ->whereNull('servicios.ruta');

        }


        $servicios = $query->orderBy('hora_servicio')->get();

        $departamentos = DB::table('departamento')->get();

        $o = 1;

        if($cliente==343){

          return View::make('servicios.servicios_ejecutivos.cliente.programados2', [
            'idusuario' => $idusuario,
            'servicios' => $servicios,
            'permisos' => $permisos,
            'userportal' => $userportal,
            'cliente' => $centrodecostoname,
            'departamentos'=>$departamentos,
            'o' => $o
          ]);

        }else{

          return View::make('servicios.servicios_ejecutivos.cliente.programados', [
            'idusuario' => $idusuario,
            'servicios' => $servicios,
            'permisos' => $permisos,
            'userportal' => $userportal,
            'cliente' => $centrodecostoname,
            'departamentos'=>$departamentos,
            'o' => $o
          ]);

        }

    }

  }

      public function postExportarlistadoservicios(){

          if (!Sentry::check()){

              return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

          }else{

              ob_end_clean();
              ob_start();

              Excel::create('Traslados del '.Input::get('fecha_inicial').' al '.Input::get('fecha_final').'', function($excel){

                  $excel->sheet('Servicios', function($sheet){
                      //TOMAR LOS VALORES DEL FORM-DATA
                      $fecha_inicial = Input::get('fecha_inicial');
                      $fecha_final = Input::get('fecha_final');

                      //STRING CONSULTA
                      $consulta = "select servicios.id, servicios.fecha_servicio, servicios.hora_servicio, servicios.ciudad, servicios.detalle_recorrido, servicios.solicitado_por, servicios.pasajeros, servicios.solicitado_por, ".
                          "proveedores.razonsocial as prazonproveedor, conductores.nombre_completo, servicios.recoger_en, servicios.dejar_en, centrosdecosto.razonsocial, servicios.pasajeros, ".
                          "subcentrosdecosto.nombresubcentro, servicios_autonet.sucursal, servicios_autonet.centrodecosto ".
                          "from servicios ".
                          "left join subcentrosdecosto on servicios.subcentrodecosto_id = subcentrosdecosto.id ".
                          "left join servicios_autonet on servicios.id = servicios_autonet.servicio_id ".
                          "left join proveedores on servicios.proveedor_id = proveedores.id ".
                          "left join conductores on servicios.conductor_id = conductores.id ".
                          "left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id ".
                          "where fecha_servicio between '".Input::get('fecha_inicial')."' and '".Input::get('fecha_final')."' and servicios.centrodecosto_id = 343";
                      //SI EL PROVEEDOR ES SELECCIONADO ENTONCES AGREGUELO A LA CONSULTA

                      $servicios = DB::select($consulta);

                      $sheet->loadView('servicios.servicios_ejecutivos.cliente.exportarlistado')
                          ->with([
                              'servicios'=>$servicios
                          ]);

                      $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(11);

                      $sheet->getStyle("B4:D4")->getFont()->setSize(13.5);
                      $sheet->getStyle("B5:D5")->getFont()->setSize(13.5);

                      $sheet->mergeCells('C4:H4');
                      $sheet->mergeCells('C5:H5');
                      $sheet->mergeCells('I4:J4');

                      $sheet->setFontFamily('Arial')
                          ->getStyle('A7:K7')->applyFromArray(array(
                              'fill' => array(
                                  'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                                  'color' => array('rgb' => 'F47321'),
                                  'textWrap' =>1
                              ),
                              'font'  => array(
                                  'size'  => 1,
                                  'name'  => 'Arial'
                              )

                          ))->getActiveSheet()->getRowDimension('7')->setRowHeight(48);

                      $sheet->setFontFamily('Arial')
                          ->getStyle('A4:M4')->getActiveSheet()->getRowDimension('4')->setRowHeight(48);

                      $sheet->setFontFamily('Arial')
                          ->getStyle('A4:M4')->getActiveSheet()->getRowDimension('5')->setRowHeight(30);

                      $sheet->setFontFamily('Arial')
                          ->getStyle('B13:D13')->getActiveSheet()->getRowDimension('9')->setRowHeight(30);

                      for ($i=6; $i < 1000; $i++) {
                          $sheet->getStyle('A'.$i.':'.'J'.$i)->getAlignment()->setWrapText(true);
                      }

                      $styleArray = array(
                          'borders' => array(
                              'allborders' => array(
                                  'style' => PHPExcel_Style_Border::BORDER_THIN
                              )
                          )
                      );

                      $sheet->getStyle('C4:H4')->applyFromArray($styleArray);
                      $sheet->getStyle('C5:H5')->applyFromArray($styleArray);
                      $sheet->getStyle('I4:J4')->applyFromArray($styleArray);
                  });

              })->download('xls');

          }
      }

      public function getTracking($code){

        $decrypted = Crypt::decryptString($code);
        //$decrypted = $code;
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

            $query = Servicio::select('servicios.*', 'conductores.nombre_completo', 'conductores.cc', 'conductores.foto', 'conductores.celular', 'vehiculos.color','vehiculos.placa','vehiculos.modelo', 'vehiculos.marca', 'vehiculos.clase', 'servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'centrosdecosto.razonsocial')
            ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
            ->leftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
            ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
            ->where('servicios.id',$decrypted);

            $servicio = $query->orderBy('hora_servicio')->first();

            return View::make('servicios.servicios_ejecutivos.cliente.tracking')
            ->with([
              'servicios' => $servicio,
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

      public function getTracker($code){

        //$decrypted = Crypt::decryptString($code);
        //$decrypted = $code;
        //$consult = Servicio::find($decrypted);

        $consult = Servicio::find($code);
        if(isset($consult)){

          if($consult->pendiente_autori_eliminacion==1){
            return View::make('servicios.gps.eliminado')
            ->with([
              'id_ser' => $decrypted
            ]);
          }else if($consult->ruta==1){
            return View::make('servicios.gps.is_route')
            ->with([
              'id_ser' => $code//$decrypted
            ]);
          }else{

            $query = Servicio::select('servicios.*', 'conductores.nombre_completo', 'conductores.cc', 'conductores.foto', 'conductores.celular', 'vehiculos.color','vehiculos.placa','vehiculos.modelo', 'vehiculos.marca', 'vehiculos.clase', 'servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'centrosdecosto.razonsocial')
            ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
            ->leftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
            ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
            ->where('servicios.id',$code);

            $servicio = $query->orderBy('hora_servicio')->get();

            return View::make('servicios.gps.tracker')
            ->with([
              'servicio' => $servicio,
              'id_ser' => $code
            ]);
          }
        }else{
          return View::make('servicios.gps.eliminado')
            ->with([
              'id_ser' => $code,
            ]);
        }
      }

      public function postConsultarmensajes(){

        //dejar el ID dinámico para cada servicio diferente

        $id = Input::get('id');

        $consult = Message::where('servicio_id',$id)->first();
        //Realizar consulta del arreglo json para la muestra de los mensajes y hora

        return Response::json([
          'respuesta' => true,
          'motivo' => $consult->messageEn
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
              'conductor' => $conductor
          ]);
        }
      }

      public function postActualizarmapaviaje(){

        $id = Input::get('id');
        $servicio = DB::table('servicios')->where('id', $id)->pluck('recorrido_gps');
        $estado = DB::table('servicios')->where('id', $id)->pluck('estado_servicio_app');
        $recoger_pasajero = DB::table('servicios')->where('id', $id)->pluck('recoger_pasajero');
        //$conductor = DB::table('servicios')->where('id', 205899)->pluck('recorrido_gps');

          return Response::json([
              'servicio' => $servicio,
              'estado' => $estado,
              'recoger' =>$recoger_pasajero,
              //'conductor' => $conductor,
              'respuesta' => true
          ]);

  }

  //FIN SERVICIOS NUEVOS

  //Rutas admin
    public function getRutasempresariales(){

        if (Sentry::check()){

            $id_rol = Sentry::getUser()->id_rol;
            $idusuario = Sentry::getUser()->id;
            $cliente = Sentry::getUser()->centrodecosto_id;
            $userportal = Sentry::getUser()->usuario_portal;
            $subcentro = Sentry::getUser()->subcentrodecosto_id;
            $subcentrodecostoname = DB::table('subcentrosdecosto')->where('id',$subcentro)->pluck('nombresubcentro');
           // $subcentrodecostoname2 = DB::table('subcentrosdecosto')->where('id',853)->pluck('nombresubcentro');
            $centrodecostoname = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
            $centrodecostolocalidad = DB::table('centrosdecosto')->where('id',$cliente)->pluck('localidad');
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
            if($id_rol==38){
              $ver = $permisos->portalusuarios->admin->ver;
            }else if($id_rol==40){
              $ver = $permisos->portalusuarios->bancos->ver;
            }


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
                ->where('servicios.anulado',0)
                ->where('servicios.cancelado',0)
                ->where('servicios.centrodecosto_id',$cliente)
                ->whereNull('servicios.pendiente_autori_eliminacion')
                ->whereNotNull('servicios.ruta')
                ->where('fecha_servicio',date('Y-m-d'))
                ->orderBy('hora_servicio')
                ->whereNull('servicios.control_facturacion')
                ->orderBy('hora_servicio')
                ->get();

            $proveedores = Proveedor::Afiliadosinternos()
            ->orderBy('razonsocial')
            ->where('localidad','barranquilla')
            ->where('tipo_servicio', 'TRANSPORTE TERRESTRE')
            ->whereNull('inactivo_total')
            ->whereNull('inactivo')
            ->get();

            $centrosdecosto = Centrodecosto::Internos()->where('localidad','barranquilla')->orderBy('razonsocial')->get();
            if($idusuario==642 or $idusuario==4495){
              $subcentrosdecosto = DB::table('subcentrosdecosto')->whereIn('id', [178, 509])->orderBy('nombresubcentro')->get();
            }else if($idusuario==605 or $idusuario==594 or $idusuario==643){
              $subcentrosdecosto = DB::table('subcentrosdecosto')->where('centrosdecosto_id',287)->orderBy('nombresubcentro')->get();
            }


            $subcentros = DB::table('subcentrosdecosto')/*->whereIn('id', [101, 178, 179, 509, 625])*/->orderBy('nombresubcentro')->get();
            $departamentos = DB::table('departamento')->get();
            $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
            $rutas = DB::table('rutas')->get();
            $usuarios = DB::table('users')->where('coordinador',1)->where('activated',1)->where('permissions',null)->get();

            $cotizaciones = DB::table('cotizaciones')->where('estado',1)->orderBy('created_at', 'desc')->take(10)->get();

            return View::make('portalusuarios.admin.rutasempresariales')
                ->with('cotizaciones',$cotizaciones)
                ->with('servicios',$servicios)
                ->with('centrosdecosto',$centrosdecosto)
                ->with('departamentos',$departamentos)
                ->with('ciudades',$ciudades)
                ->with('proveedores',$proveedores)
                ->with('rutas',$rutas)
                ->with('userportal', $userportal)
                ->with('permisos',$permisos)
                ->with('usuarios',$usuarios)
                ->with('cliente',$centrodecostoname)
                ->with('subcentro',$subcentrodecostoname)
                ->with('idusuario',$idusuario)
                ->with('sub',$subcentrosdecosto)
                ->with('o',$o=1);
        }
    }
  //

    //buscar admin rutas
      public function postBuscarrutas(){

        $id_rol = Sentry::getUser()->id_rol;
        $cliente = Sentry::getUser()->centrodecosto_id;
        $idusuario = Sentry::getUser()->id;
        $subcentrodecosto = Sentry::getUser()->subcentrodecosto_id;
        $centrodecostoname = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
        $centrodecostolocalidad = DB::table('centrosdecosto')->where('id',$cliente)->pluck('localidad');
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

                $consulta = "select servicios.id, servicios.fecha_orden, servicios.fecha_servicio, servicios.solicitado_por, servicios.programado_app, ".
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
                    "where servicios.fecha_servicio between '".$fecha_inicial."' AND '".$fecha_final."' and servicios.centrodecosto_id = '".$cliente."'";

                if($servicio!=0){

                    if ($servicio===6) {
                        $consulta .= " and encuesta.pregunta_1 is not null ";
                    }

                    if ($servicio===7) {
                        $consulta .= " and (facturacion.liquidacion_id is not null and facturacion.liquidado_autorizado is null and facturacion.facturado is null ) ";
                    }

                    if ($servicio===8) {
                        $consulta .= " and servicios.finalizado is null ";
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
          //FILTRO PARA NO SHOW
          if ($servicio===9){
                        $consulta .=" and (novedades_reconfirmacion.seleccion_opcion = 2 or  novedades_reconfirmacion.seleccion_opcion = 5)";
                    }
                }

                if($proveedores!='0'){
                    $consulta .= " and proveedores.id = ".$proveedores." ";
                }

                if($conductores!='0'){
                    $consulta .= " and conductores.id = ".$conductores." ";
                }

                if($centrodecosto!='0'){
                    $consulta .= " and subcentrosdecosto.id = '".$centrodecosto."' ";
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

                //SE AGREGÓ EL CAMPO CONTROL FACTURACION
                if(!($id_rol==1 or $id_rol==2 or $id_rol==8)){
                    $consulta .=" and servicios.control_facturacion is null";
                }

                $servicios = DB::select(DB::raw($consulta." and servicios.pendiente_autori_eliminacion is null order by hora_servicio asc "));

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

    //Solicitar Servicio ADMIN

      public function getSolicitarservicio(){
      if (Sentry::check()){
            $id_rol = Sentry::getUser()->id_rol;
            $idusuario = Sentry::getUser()->id;
            $userportal = Sentry::getUser()->usuario_portal;
            $username = Sentry::getUser()->username;
            $identificacion = Sentry::getUser()->identificacion;
            $direccionuser = DB::table('pasajeros')->where('cedula',$identificacion)->pluck('direccion');
            $telefonouser = DB::table('pasajeros')->where('cedula',$identificacion)->pluck('telefono');
            $nombresuser = DB::table('pasajeros')->where('cedula',$identificacion)->pluck('nombres');
            $apellidosuser = DB::table('pasajeros')->where('cedula',$identificacion)->pluck('apellidos');
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
            $ver = $permisos->portalusuarios->admin->ver;
            $departamentos = DB::table('departamento')->get();
        }else{
            $ver = null;
        }

        if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on') {
            return View::make('admin.permisos');
        }else{

        return View::make('portalusuarios.admin.solicitarservicio')
        ->with('userportal',$userportal)
        ->with('idusuario',$idusuario)
        ->with('permisos',$permisos)
        ->with('direccion',$direccionuser)
        ->with('telefono',$telefonouser)
        ->with('nombres',$nombresuser)
        ->with('apellidos',$apellidosuser)
        ->with('identificacion',$identificacion)
        ->with('username',$username)
        ->with('departamentos', $departamentos);
        }
    }

    //

    //

    public function postSolicitarservicioadministrador(){

      if(Request::ajax()){


          $validaciones = [
            'nombres'=>'required',
            'fecha'=>'required',
            'hora'=>'required',
            'cantidadpasajeros'=>'required',
            'cantidadvehiculos'=>'required',
            'lugarrecogida'=>'required',
            'lugardestino'=>'required',
          ];

          $mensajes = [
            'nombres.required'=>'El campo nombres es obligatorio',
            'fecha.required'=>'El campo fecha es obligatorio',
            'hora.required'=>'El campo hora es obligatorio',
            'cantidadpasajeros.required'=>'El campo cantidad pasajeros es obligatorio',
            'cantidadvehiculos.required'=>'El campo cantidad vehiculos es obligatorio',
            'lugarrecogida.required'=>'El campo lugar de recogida es obligatorio',
            'lugardestino.required'=>'El campo lugar de destino es obligatorio',
          ];


            $validador = Validator::make(Input::all(), $validaciones,$mensajes);

          if ($validador->fails())
          {
            return Response::json([
              'mensaje'=>false,
              'errores'=>$validador->errors()->getMessages()
            ]);

            }else{

              $nombres = Input::get('nombres');

              $servicioportal = new Serviciosp;
              $servicioportal->fecha_servicio = Input::get('fecha');
              $servicioportal->hora_servicio = Input::get('hora');
              $servicioportal->cantidad_pasajeros = Input::get('cantidadpasajeros');
              $servicioportal->numero_vehiculos = Input::get('cantidadvehiculos');
              $servicioportal->recoger_en = Input::get('lugarrecogida');
              $servicioportal->dejar_en = Input::get('lugardestino');
              $servicioportal->departamento = Input::get('departamento');

              if($servicioportal->save()){
                return Response::json([
                    'mensaje'=>true,
                ]);

              }else{
                return Response::json([
                  'mensaje'  => false
                ]);
              }


          }
        }

    }

    public function getVista(){

      if (Sentry::check()){

          $id_rol = Sentry::getUser()->id_rol;
          $idusuario = Sentry::getUser()->id;
          $cliente = Sentry::getUser()->centrodecosto_id;
          $subcentro = Sentry::getUser()->subcentrodecosto_id;
          $userportal = Sentry::getUser()->usuario_portal;
          $centrodecostoname = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
          $centrodecostolocalidad = DB::table('centrosdecosto')->where('id',$cliente)->pluck('localidad');
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          if($id_rol==38){
            $ver = $permisos->portalusuarios->admin->ver;
          }else if($id_rol==40){
            $ver = $permisos->portalusuarios->bancos->ver;
          }

      }else{
          $ver = null;
      }

      if (!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on') {

          return View::make('admin.permisos');

      }else{

          return View::make('portalusuarios.admin.servicios_excel2')
          ->with('userportal',$userportal)
          ->with('idusuario',$idusuario)
          ->with('permisos',$permisos);
      }
    }

    //

  /**
   * getServiciosyrutas Mostrar la vista de rutas y servicios - 'transportesbaq/serviciosyrutasbaq'
   */
  public function getServiciosyrutasbaq(){

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
            //->where('servicios.localidad',1)
            ->where('centrosdecosto.localidad','barranquilla')
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

        $centrosdecosto = Centrodecosto::Internos()->where('localidad','BARRANQUILLA')->orderBy('razonsocial')->get();

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
  }

  /**
   * [postBuscar description]
   * @return [type] [description]
   */

}
