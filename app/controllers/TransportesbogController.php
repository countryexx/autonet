<?php

/**
 * Controlador para el modulo de transportes
 */
class TransportesbogController extends BaseController{

  /**
   * Metodo para mostrar todos los servicios del dia
   * @return View Vista
   */
  public function getIndex(){

    if (Sentry::check()){

        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->bogota->servicios->ver;

    }else{
        $ver = null;
    }

    if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on') {

        return View::make('admin.permisos');

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
            //->whereIn('centrosdecosto.localidad',['bogota','provisional'])
            //->whereIn('users.localidad',['2','3'])
            ->where('servicios.localidad',1)
            ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
            ->whereNull('servicios.pendiente_autori_eliminacion')
            ->whereNull('servicios.afiliado_externo')
            ->where('fecha_servicio',date('Y-m-d'))
            ->whereNull('servicios.ruta');

        /**
         * [$servicios description]
         * @var [type]
         */
            //MODIFICICACIÓN PARA QUE OPERACIONES NO VISUALICE LOS SERVICIOS MONTADOS POR FACTURACION
            //SE AGREGÓ EL CAMPO CONTROL FACTURACION
            if($id_rol==1 or $id_rol==2 or $id_rol==8){
                $servicios = $query->orderBy('hora_servicio')->get();
            }else{
                $servicios = $query->whereNull('servicios.control_facturacion')->orderBy('hora_servicio')->get();
            }

        $proveedores = Proveedor::Afiliadosinternos()
        ->orderBy('razonsocial')
        ->whereIn('localidad',['BOGOTA','provisional'])
        ->where('tipo_servicio', 'TRANSPORTE TERRESTRE')
        ->whereNull('inactivo_total')
        ->whereNull('inactivo')
        ->get();

        $centrosdecosto = Centrodecosto::Internos()->whereIn('localidad',['bogota','provisional'])->orderBy('razonsocial')->get();

        $subcentros = DB::table('subcentrosdecosto')->orderBy('nombresubcentro')->get();
        $departamentos = DB::table('departamento')->get();
        $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
        $rutas = DB::table('rutas')->get();

        $usuarios = User::where('coordinador', 1)->where('activated', 1)->orderBy('first_name')->get();

	      $cotizaciones = DB::table('cotizaciones')->where('estado',1)->orderBy('created_at', 'desc')->take(10)->get();
        $o = 1;

        return View::make('servicios.transportesbog', [
          'cotizaciones' => $cotizaciones,
          'servicios' => $servicios,
          'centrosdecosto' => $centrosdecosto,
          'departamentos' => $departamentos,
          'ciudades' => $ciudades,
          'proveedores' => $proveedores,
          'rutas' => $rutas,
          'permisos' => $permisos,
          'usuarios' => $usuarios,
          'o' => $o
        ]);

    }

  }

  /**
   * getServiciosyrutas Mostrar la vista de rutas y servicios - 'transportes/serviciosyrutas'
   */
  public function getServiciosyrutasbog(){

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
            ->where('centrosdecosto.localidad','bogota')
            ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
            ->whereNull('servicios.pendiente_autori_eliminacion')
            ->whereNull('servicios.afiliado_externo')
            ->where('fecha_servicio',date('Y-m-d'));

        $servicios = $query->orderBy('hora_servicio')->get();

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
  }

  /**
   * [postBuscar description]
   * @return [type] [description]
   */
  public function postBuscar(){

      $id_rol = Sentry::getUser()->id_rol;
      $id_usuario = Sentry::getUser()->id;
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

              if($id_usuario==118){

              }
              $consulta = "select servicios.id, servicios.ruta_qr, servicios.fecha_orden, servicios.fecha_servicio, servicios.solicitado_por, servicios.programado_app, ".
                  "servicios.resaltar, servicios.pago_directo, servicios.fecha_solicitud, servicios.ciudad, servicios.recoger_en, servicios.ruta, ".
                  "servicios.dejar_en, servicios.detalle_recorrido, servicios.pasajeros, servicios.pasajeros_ruta, servicios.finalizado, servicios.pendiente_autori_eliminacion, ".
                  "servicios.hora_servicio, servicios.origen, servicios.destino, servicios.fecha_pago_directo, servicios.rechazar_eliminacion, ".
                  "servicios.estado_servicio_app, servicios.recorrido_gps, servicios.calificacion_app_conductor_calidad, ".
                  "servicios.calificacion_app_conductor_actitud, servicios.calificacion_app_cliente_calidad, servicios.calificacion_app_cliente_actitud, ".
                  "servicios.aerolinea, servicios.vuelo, servicios.hora_salida, servicios.hora_llegada, servicios.aceptado_app, ".
                  "servicios.cancelado, servicios.expediente, servicios.email_solicitante, pago_proveedores.consecutivo as pconsecutivo, pagos.autorizado, ".
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
                  "where servicios.fecha_servicio between '".$fecha_inicial."' AND '".$fecha_final."' and servicios.localidad = 1";

                    //MODIFICICACIÓN PARA QUE OPERACIONES NO VISUALICE LOS SERVICIOS MONTADOS POR FACTURACION
                    //SE AGREGÓ EL CAMPO CONTROL FACTURACION

                  if(!($id_rol==2 or $id_rol==1 or $id_rol==5 or $id_rol==52 or $id_rol==8)){
                        $consulta .=" and facturacion.revisado is null";
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
                      $consulta .= " and servicios.ruta is null and servicios.afiliado_externo is null ";
                  }

              if($servicio!=0){

                  if ($servicio===13) {
                      $consulta .= " and servicios.calificacion_app_cliente_calidad is not null ";
                  }

                  if ($servicio===12) {
                      $consulta .= " and servicios.calificacion_app_conductor_calidad is not null ";
                  }

                  if ($servicio===11) {
                      $consulta .= " and (servicios.calificacion_app_conductor_calidad is not null or servicios.calificacion_app_cliente_calidad is not null) ";
                  }

                  if ($servicio===10) {
                      $consulta .= " and servicios.estado_servicio_app is not null ";
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

  public function postMostrarsubcentros(){

    if (!Sentry::check()){

        return Response::json([
            'respuesta'=>'relogin'
        ]);

    }else{

      if(Request::ajax()){

          $subcentros = Subcentro::nobloqueado()->where('centrosdecosto_id',Input::get('centrosdecosto_id'))->orderBy('nombresubcentro')->get();
          $users = User::where('centrodecosto_id', Input::get('centrosdecosto_id'))->get();
          $tarifa_traslado = Tarifastraslados::where('tarifa_ciudad', Input::get('ciudad'))->orderBy('tarifa_nombre')->get();
          $nombre_rutas = NombreRuta::where('centrodecosto_id', Input::get('centrosdecosto_id'))->get();

          if($subcentros){

              return Response::json([
                  'mensaje' => true,
                  'users' => $users,
                  'respuesta'=> $subcentros,
                  'tarifa_traslado' => $tarifa_traslado,
                  'nombre_rutas' => $nombre_rutas
              ]);

          }else{

              return Response::json([
                  'mensaje'=>false,
              ]);

          }

      }

    }
  }

  //FORMULARIO DE EDITAR SERVICIO
  public function postMostrarrutaseditar(){

      if(Request::ajax()){

          $rutas = DB::table('rutas')->where('centrosdecosto_id',Input::get('centrosdecosto_id'))->orderBy('nombre_ruta')->get();

          if($rutas){

              return Response::json([
                  'mensaje'=>true,
                  'respuesta'=>$rutas
              ]);

          }else{

              return Response::json([
                  'mensaje'=>false,
              ]);
          }
      }
  }

  public function postEditarservicio(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          if (Request::ajax()) {

              $cambios = '';

              //Validaciones
              $validaciones = [
                'centrodecosto_id'=>'required|numeric',
                'ciudad'=>'required|select',
                'conductor_id'=>'required|numeric',
                'dejar_en' => 'required',
                'subcentrodecosto_id'=>'required|numeric',
                'solicitado_por'=>'required',
                //'email_solicitante'=>'email',
                'departamento'=>'required|select',
                'ruta_id' => 'required|min:1|numeric',
                'recoger_en'=>'required',
                'detalle_recorrido'=>'required',
                'proveedor_id'=>'required|numeric',
                'vehiculo_id'=>'required|numeric',
                'fecha_servicio'=>'required|date_format:Y-m-d',
                'hora_servicio'=>'required|date_format:H:m',
                'resaltar'=>'required|numeric',
                'pago_directo'=>'required|numeric',
                'firma' => 'required|numeric',
                'notificacion'=>'required|numeric'
              ];

              //VALIDACIONES
              $mensajes = [
                'centrodecosto_id.numeric' => 'Debe seleccionar un centro de costo',
                'subcentrodecosto_id.numeric' => 'Debe seleccionar un subcentro de costo',
                'departamento.select' => 'Debe seleccionar un departamento',
                'ciudad.select' => 'Debe seleccionar una ciudad',
                'ruta_id.required' => 'Debe seleccionar una ruta',
                'ruta_id.numeric' => 'Debe seleccionar una ruta',
                'ruta_id.min' => 'Debe seleccionar una ruta',
                'proveedor_id.numeric' => 'Debe seleccionar un proveedor',
                'resaltar.numeric' => 'Debe seleccionar la opcion resaltar',
                'pago_directo.numeric' => 'Debe seleccionar la opcion pago_directo',
                'firma.numeric' => 'Debe seleccionar la opcion firma',
                'notificacion.numeric' => 'Debe seleccionar la opcion notificacion'
              ];

              //VALIDADOR
              $validador = Validator::make(Input::all(), $validaciones, $mensajes);

              //SI EL VALIDADOR FALLA ENTONCES ENVIA RESPUESTA DE ERROR CON UN ARRAY DE ERROR
              if ($validador->fails()){

                  return Response::json([
                      'respuesta'=>false,
                      'errores'=>$validador->errors()->getMessages()
                  ]);

              }else {

                  $pasajeros = [];
                  $pasajeros_todos='';
                  $nombres_pasajeros='';
                  $celulares_pasajeros='';

                  $nombre_pasajeros = explode(',', Input::get('nombres_pasajeros_editar'));
                  $celular_pasajeros = explode(',', Input::get('celular_pasajeros_editar'));
                  $nivel_pasajeros = explode(',', Input::get('nivel_pasajeros_editar'));
                  $email_pasajeros = explode(',', Input::get('email_pasajeros_editar'));

                  //CONCATENACION DE TODOS LOS DATOS
                  for($i=0; $i<count($nombre_pasajeros); $i++){
                      $pasajeros[$i] = $nombre_pasajeros[$i].','.$celular_pasajeros[$i].','.$nivel_pasajeros[$i].','.$email_pasajeros[$i].'/';
                      $pasajeros_nombres[$i] = $nombre_pasajeros[$i].',';
                      $pasajeros_telefonos[$i] = $celular_pasajeros[$i].',';
                      $pasajeros_todos = $pasajeros_todos.$pasajeros[$i];
                      $nombres_pasajeros = $nombres_pasajeros.$pasajeros_nombres[$i];
                      $celulares_pasajeros = $celulares_pasajeros.$pasajeros_telefonos[$i];
                  }

                  $servicios = Servicio::find(Input::get('id'));

                  $consulta = "SELECT * FROM liquidacion_servicios WHERE '".Input::get('fecha_servicio')."' BETWEEN fecha_inicial AND fecha_final and centrodecosto_id = '".Input::get('centrodecosto_id')."' and subcentrodecosto_id = '".Input::get('subcentrodecosto_id')."' and ciudad = '".Input::get('ciudad')."' and anulado is null and nomostrar is null";
                  $consulta_orden = "SELECT * FROM ordenes_facturacion WHERE '".Input::get('fecha_servicio')."' BETWEEN fecha_inicial AND fecha_final and centrodecosto_id = '".Input::get('centrodecosto_id')."' and subcentrodecosto_id = '".Input::get('subcentrodecosto_id')."' and ciudad = '".Input::get('ciudad')."' and anulado is null and nomostrar is null and tipo_orden = 1";

                  $liquidacion = DB::select($consulta);
                  $ordenes_facturacion = DB::select($consulta_orden);

                  if($ordenes_facturacion!=null or $liquidacion!=null){

                       return Response::json([
                          'respuesta'=>'rechazado',
                           'liquidacion'=>$liquidacion,
                           'ordenes_facturacion'=>$ordenes_facturacion
                       ]);

                  }else{

                      //ASIGNAR VARIABLES AL RESULTADO DE LA BUSQUEDA DE SERVICIOS
                      $centrodecosto = $servicios->centrodecosto_id;
                      $subcentrodecosto = $servicios->subcentrodecosto_id;
                      $departamento = $servicios->departamento;
                      $ciudad = $servicios->ciudad;
                      $pasajeros = $servicios->pasajeros;
                      $cantidad = $servicios->cantidad;
                      $solicitado_por = $servicios->solicitado_por;

                      $email_solicitante = $servicios->email_solicitante;
                      $firma = $servicios->firma;

                      $ruta = $servicios->ruta_id;
                      $recoger_en = $servicios->recoger_en;
                      $dejar_en = $servicios->dejar_en;
                      $detalle_recorrido = $servicios->detalle_recorrido;
                      $proveedor = $servicios->proveedor_id;
                      $conductor = $servicios->conductor_id;
                      $vehiculo = $servicios->vehiculo_id;
                      $fecha_servicio = $servicios->fecha_servicio;
                      $hora_servicio = $servicios->hora_servicio;
                      $resaltar = $servicios->resaltar;
                      $pago_directo = $servicios->pago_directo;
                      $origen = $servicios->origen;
                      $destino = $servicios->destino;
                      $vuelo = $servicios->vuelo;
                      $aerolinea = $servicios->aerolinea;
                      $hora_salida = $servicios->hora_salida;
                      $hora_llegada = $servicios->hora_llegada;

                      //Si el campo app user id es diferente de null
                      if (Input::get('app_user_id')!=null) {
                        //Asignarle valor a la variable app_user_id 228
                        $app_user_id = $servicios->app_user_id;

                      }else {
                        //Si el campo es null o tiene otro valor
                        $app_user_id = null;

                      }

                      $servicios->centrodecosto_id = Input::get('centrodecosto_id');
                      $servicios->subcentrodecosto_id = Input::get('subcentrodecosto_id');
                      $servicios->departamento = Input::get('departamento');
                      $servicios->ciudad = Input::get('ciudad');
                      $servicios->pasajeros = $pasajeros_todos;
                      $servicios->cantidad = Input::get('cantidad');
                      $servicios->solicitado_por = Input::get('solicitado_por');

                      $servicios->email_solicitante = Input::get('email_solicitante');
                      $servicios->firma = Input::get('firma');

                      $servicios->ruta_id = Input::get('ruta_id');
                      $servicios->recoger_en = Input::get('recoger_en');
                      if ($recoger_en!=$servicios->recoger_en) {
                        $arrayRecoger = [
                          'lat' => Input::get('latRecoger'),
                          'lng' => Input::get('lngRecoger')
                        ];
                        $servicios->desde = json_encode([$arrayRecoger]);
                      }

                      $servicios->dejar_en = Input::get('dejar_en');
                      if ($dejar_en!=$servicios->dejar_en) {
                        $arrayDejar = [
                          'lat' => Input::get('latDejar'),
                          'lng' => Input::get('lngDejar')
                        ];
                        $servicios->hasta = json_encode([$arrayDejar]);
                      }

                      $servicios->detalle_recorrido = Input::get('detalle_recorrido');
                      $servicios->proveedor_id = Input::get('proveedor_id');
                      $servicios->conductor_id = Input::get('conductor_id');
                      $servicios->vehiculo_id = Input::get('vehiculo_id');
                      $servicios->fecha_servicio = Input::get('fecha_servicio');
                      $servicios->hora_servicio = Input::get('hora_servicio');
                      $servicios->resaltar = Input::get('resaltar');
                      $servicios->pago_directo = Input::get('pago_directo');
                      $servicios->origen = Input::get('origen');
                      $servicios->destino = Input::get('destino');
                      $servicios->vuelo = Input::get('vuelo');
                      $servicios->aerolinea = Input::get('aerolinea');
                      $servicios->hora_salida = Input::get('hora_salida');
                      $servicios->hora_llegada = Input::get('hora_llegada');
                      $servicios->actualizado_por = Sentry::getUser()->id;
                      $servicios->notificacion = Input::get('notificacion');
                      $servicios->app_user_id = Input::get('app_user_id');

                      if ($servicios->save()) {

                          $cambiosNotificaciones = '';
                          $cambiosConductor = false;

                          if ($centrodecosto!=$servicios->centrodecosto_id) {
                              $centro1 = DB::table('centrosdecosto')->where('id',$servicios->centrodecosto_id)->first();
                              $centro2 = DB::table('centrosdecosto')->where('id',$centrodecosto)->first();

                              $cambios = $cambios.'Se cambio el centro de costo de <b>'.$centro2->razonsocial.'</b> a <b>'.$centro1->razonsocial.'</b><br>';
                          }

                          if ($subcentrodecosto!=$servicios->subcentrodecosto_id) {

                              $subcentro1 = DB::table('subcentrosdecosto')->where('id', $servicios->subcentrodecosto_id)->first();
                              $subcentro2 = DB::table('subcentrosdecosto')->where('id', $subcentrodecosto)->first();

                              $cambios = $cambios.'Se cambio el subcentro de costo de <b>'.$subcentro2->nombresubcentro.'</b> a <b>'.
                              $subcentro1->nombresubcentro.'</b><br>';
                          }

                          if ($departamento!=$servicios->departamento) {
                              $cambios = $cambios.'Se cambio el departamento de <b>'.$departamento.'</b> a <b>'.$servicios->departamento.'</b><br>';
                          }

                          if ($ciudad!=$servicios->ciudad) {
                              $cambios = $cambios.'Se cambio la ciudad de <b>'.$ciudad.'</b> a <b>'.$servicios->ciudad.'</b><br>';
                          }

                          if ($pasajeros!=$servicios->pasajeros) {
                              $cambios = $cambios.'Se cambiaron los datos de los <b>pasajeros</b><br>';
                          }

                          if ($cantidad!=$servicios->cantidad) {
                              $cambios = $cambios.'Se cambio la <b>cantidad</b> de pasajeros de <b>'.$cantidad.'</b> a <b>'.$servicios->cantidad.'</b><br>';
                          }

                          if ($solicitado_por!=$servicios->solicitado_por) {
                              $cambios = $cambios.'Se cambio el nombre de la persona que solicito el servicio de <b>'.$solicitado_por.'</b> a <b>'.$servicios->solicitado_por.'</b><br>';
                          }

                          if ($email_solicitante!=$servicios->email_solicitante) {

                              if ($email_solicitante==='') {
                                  $cambios = $cambios.'Se cambio el email de la persona que solicito el servicio a <b>'.$servicios->email_solicitante.'</b><br>';
                              }else{
                                  $cambios = $cambios.'Se cambio el email de la persona que solicito el servicio de <b>'.$email_solicitante.'</b> a <b>'.$servicios->email_solicitante.'</b><br>';
                              }

                          }

                          //Si el campo ingresado y el que esta en la base de datos son diferenentes
                          //$ruta es el campo anterior y $servicios->ruta es el campo nuevo
                          if ($ruta!=$servicios->ruta_id) {

                            if ($ruta==null) {

                              $rutas2 = Tarifastraslados::where('id', $servicios->ruta_id)->first();
                              $cambios = $cambios.'Se asigno el nombre de ruta <b>'.$rutas2->tarifa_nombre.'</b><br>';

                            }else {

                              //Anterior
                              $rutas1 = Tarifastraslados::where('id', $ruta)->first();

                              //Actual
                              $rutas2 = Tarifastraslados::where('id', $servicios->ruta_id)->first();

                              //Si no encuentra la ruta entonces debe buscar la ruta en las rutas anteriores
                              if (!count($rutas1)) {

                                $rutas1 = Rutat::where('id', $ruta)->first();

                                $cambios = $cambios.'Se cambio la ruta del servicio de <b>'.$rutas1->nombre_ruta.'</b> a <b>'.
                                           $rutas2->tarifa_nombre.'</b><br>';

                              }else {

                                $cambios = $cambios.'Se cambio la ruta del servicio de <b>'.$rutas1->tarifa_nombre.'</b> a <b>'.
                                           $rutas2->tarifa_nombre.'</b><br>';

                              }

                            }

                          }

                          if ($recoger_en!=$servicios->recoger_en) {
                              $cambios = $cambios.'Se cambio el campo recoger en de <b>'.$recoger_en.'</b> a <b>'.$servicios->recoger_en.'</b><br>';
                              $cambiosNotificaciones = $cambiosNotificaciones.'Hubo cambios en el servicio programado para la fecha: '.$fecha_servicio.' y hora: '.$hora_servicio.', se cambio el lugar de recojida de '.$recoger_en.' a '.$servicios->recoger_en;
                          }

                          if ($dejar_en!=$servicios->dejar_en) {
                              $cambios = $cambios.'Se cambio el campo dejar en de <b>'.$dejar_en.'</b> a <b>'.$servicios->dejar_en.'</b><br>';
                              if ($cambiosNotificaciones!='') {
                                  $cambiosNotificaciones = $cambiosNotificaciones.', el lugar de destino de '.$dejar_en.' a '.$servicios->dejar_en;
                              }else{
                                  $cambiosNotificaciones = $cambiosNotificaciones.'Hubo cambios en el servicio programado para la fecha: '.$fecha_servicio.' y hora: '.$hora_servicio.', se cambio el lugar de destino de '.$dejar_en.' a '.$servicios->dejar_en;
                              }
                          }

                          if ($detalle_recorrido!=$servicios->detalle_recorrido) {
                              $cambios = $cambios.'Se cambio el campo detalle del recorrido de <b>'.$detalle_recorrido.'</b> a <b>'.$servicios->detalle_recorrido.'</b><br>';
                          }

                          if ($proveedor!=$servicios->proveedor_id) {
                              $proveedor1 = DB::table('proveedores')->where('id',$servicios->proveedor_id)->first();
                              $proveedor2 = DB::table('proveedores')->where('id',$proveedor)->first();
                              $cambios = $cambios.'Se cambio el proveedor de <b>'.$proveedor2->razonsocial.'</b> a <b>'.$proveedor1->razonsocial.'</b><br>';
                          }

                          if ($vehiculo!=$servicios->vehiculo_id) {
                              $vehiculo1 = DB::table('vehiculos')->where('id',$servicios->vehiculo_id)->first();
                              $vehiculo2 = DB::table('vehiculos')->where('id',$vehiculo)->first();
                              $cambios = $cambios.'Se cambio el vehiculo de marca <b>'.$vehiculo2->marca.'</b> y placas <b>'.$vehiculo2->placa.'</b> a el vehiculo de marca <b>'.$vehiculo1->marca.'</b> y placas <b>'.$vehiculo1->placa.'</b><br>';
                          }

                          if ($fecha_servicio!=$servicios->fecha_servicio) {
                              $cambios = $cambios.'Se cambio la fecha del servicio de <b>'.$fecha_servicio.'</b> al <b>'.$servicios->fecha_servicio.'</b><br>';
                              //$servicio = Servicio::find($servicios->id);
                              //$servicio->notificaciones_reconfirmacion = null;
                              //$servicio->save();

                              if ($cambiosNotificaciones!='') {
                                  $cambiosNotificaciones = $cambiosNotificaciones.', la fecha de '.$fecha_servicio.' a '.$servicios->fecha_servicio;
                              }else{
                                  $cambiosNotificaciones = $cambiosNotificaciones.'Hubo cambios en el servicio programado para la fecha: '.$fecha_servicio.' y hora: '.$hora_servicio.', se cambio la fecha de '.$fecha_servicio.' a '.$servicios->fecha_servicio;
                              }
                          }

                          if ($hora_servicio!=$servicios->hora_servicio) {
                              $cambios = $cambios.'Se cambio la hora del servicio de <b>'.$hora_servicio.'</b> al <b>'.$servicios->hora_servicio.'</b><br>';
                              //$servicio = Servicio::find($servicios->id);
                              //$servicio->notificaciones_reconfirmacion = null;
                              //$servicio->save();

                              if ($cambiosNotificaciones!='') {
                                  $cambiosNotificaciones = $cambiosNotificaciones.', la hora de '.$hora_servicio.' a '.$servicios->hora_servicio;
                              }else{
                                  $cambiosNotificaciones = $cambiosNotificaciones.'Hubo cambios en el servicio programado para la fecha: '.$fecha_servicio.' y hora: '.$hora_servicio.', se cambio la hora de '.$hora_servicio.' a '.$servicios->hora_servicio;
                              }
                          }

                          if ($conductor!=$servicios->conductor_id) {

                              //cuando se cambia de conductor toca iniciar aceptado = 0, por si el conductor habia aceptado antes y tiene que aceptar otro conductor
                              $servicio = Servicio::find($servicios->id);
                              $servicio->aceptado_app = null;
                              //$servicio->notificaciones_reconfirmacion = null;
                              $servicio->hora_programado_app = date('Y-m-d H:i:s');
                              $servicio->save();
                              //conductor nuevo del servicio
                              $conductor1 = DB::table('conductores')->where('id',$servicios->conductor_id)->first();

                              //conductor actual
                              $conductor2 = DB::table('conductores')->where('id',$conductor)->first();
                              $cambios = $cambios.'Se cambio el conductor de <b>'.$conductor2->nombre_completo.'</b> a <b>'.$conductor1->nombre_completo.'</b><br>';

                              $centrodecosto = Centrodecosto::find($servicios->centrodecosto_id);
                              if ($cambiosNotificaciones!='') {
                                    $cambiosNotificaciones = $cambiosNotificaciones.', este servicio ha sido programado cancelado';
                                    //$cambiosNotificaciones = $cambiosNotificaciones.', este servicio ha sido programado para otro conductor';
                              }else{
                                  //$cambiosNotificaciones = $cambiosNotificaciones.'Hubo cambios en el servicio programado para la fecha: '.$fecha_servicio.', hora: '.$hora_servicio.', para '.$centrodecosto->razonsocial.', este servicio ha sido programado para otro conductor';
                                  $cambiosNotificaciones = $cambiosNotificaciones.'Hubo cambios en el servicio programado para la fecha: '.$fecha_servicio.', hora: '.$hora_servicio.', para '.$centrodecosto->razonsocial.', este servicio ha sido cancelado';
                              }

                              $cambiosConductor = true;

                              //se deben hacer dos notificaciones, una para decirle al conductor que no tiene ese servicio asignado y otra para avisar del servicio al nuevo conductor

                              // 1. notificacion de cancelacion
                              Servicio::Notificaciones($cambiosNotificaciones, $conductor2->id);

                              //buscar nombre de centro de costo
                              $centrodecosto = Centrodecosto::find($servicios->centrodecosto_id);
                              $nuevo_servicio = 'Se le ha asignado un nuevo servicio para el día '.$servicios->fecha_servicio.' y hora: '.$servicios->hora_servicio.' para recoger en: '.$servicios->recoger_en.' y dejar en: '.$servicios->dejar_en.' para '.$centrodecosto->razonsocial;

                              // 2. notificacion de servicio asignado a conductor
                              Servicio::Notificaciones($nuevo_servicio, $conductor1->id);

                          }

                          if($servicios->app_user_id!=null && $servicios->app_user_id!=0){ //Si es servicio de la app

                            $actualDate = date('Y-m-d');
                            $actualTime = date('H:i');

                            //if(Input::get('notificacion')==='1'){

                              //si la fecha y la hora actuales son menores a la fecha y hora del servicio
                              if($actualDate<=$servicios->fecha_servicio ){
                                //si hubo cambios en el conductor, fecha u hora.
                                if ($conductor!=$servicios->conductor_id || $hora_servicio!=$servicios->hora_servicio || $fecha_servicio!=$servicios->fecha_servicio) {

                                  $messageCliente = "Le informamos cambio de ";
                                  $messageClienteEn = "AOTOUR informs you change of ";

                                  if($conductor!=$servicios->conductor_id){
                                    $messageCliente = $messageCliente.'CONDUCTOR, ';
                                    $messageClienteEn = $messageClienteEn.'DRIVER, ';
                                  }
                                  if($hora_servicio!=$servicios->hora_servicio){
                                    $messageCliente = $messageCliente.'HORA, ';
                                    $messageClienteEn = $messageClienteEn.'TIME, ';
                                  }
                                  if($fecha_servicio!=$servicios->fecha_servicio){
                                    $messageCliente = $messageCliente.'FECHA, ';
                                    $messageClienteEn = $messageClienteEn.'DATE, ';
                                  }

                                  $messageCliente = $messageCliente.'en su traslado programado para el '.$fecha_servicio.'.';
                                  $messageClienteEn = $messageClienteEn.'on your scheduled transfer on '.$fecha_servicio.'.';
                                  Servicio::NotificacionClient($messageCliente, $messageClienteEn, $servicios->app_user_id);
                                }

                              }

                            //}

                          }else{//sino, confirmar por correo a los pasajeros

                            $actualDate = date('Y-m-d');
                            $actualTime = date('H:i');

                            //si la fecha y la hora actuales son menores a la fecha y hora del servicio
                            if($actualDate<=$servicios->fecha_servicio){
                              //si hubo cambios en el conductor, fecha u hora.
                              if ($conductor!=$servicios->conductor_id || $hora_servicio!=$servicios->hora_servicio || $fecha_servicio!=$servicios->fecha_servicio || $recoger_en!=$servicios->recoger_en || $dejar_en!=$servicios->dejar_en) {

                                $serv = DB::table('servicios')
                                ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
                                ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
                                ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                                ->where('servicios.id',$servicios->id)->first();

                                $data = [
                                  'servicio' => $serv,
                                  'conductor' => DB::table('conductores')->where('id',$serv->conductor_id)->first(),
                                  'vehiculo' => DB::table('vehiculos')->where('id',$serv->vehiculo_id)->first(),
                                  'id' => DB::table('servicios')->where('id',$servicios->id)->pluck('id'),
                                ];

                                $passengers = explode('/', $servicios->pasajeros);

                                for ($i=0; $i<count($passengers)-1; $i++) {

                                  $emai = explode(',', $passengers[$i]);
                                  $correoUpdate =  $emai[3];

                                  if($correoUpdate!=''){

                                    Mail::send('servicios.servicios_ejecutivos.cliente.email_modificado', $data, function($message) use ($correoUpdate){
                                      $message->from('no-reply@aotour.com.co', 'Notificaciones Aotour');
                                      $message->to($correoUpdate)->subject('Actualización de Servicio');
                                    });

                                  }

                                  $number = explode(',', $passengers[$i]);
                                  $numberUpdate =  $number[1];
                                  $numberUpdate = str_replace(' ','',$numberUpdate);

                                  /*if($numberUpdate!=''){

                                    $number = '57'.$numberUpdate;

                                    $number = intval($number);
                                    $dejarEn = $servicios->dejar_en;
                                    $fecha = Input::get('fecha_servicio');
                                    $hora = Input::get('hora_servicio');
                                    $recogerEn = Input::get('recoger_en');
                                    $dejarEn = Input::get('dejar_en');

                                    $placa = DB::table('vehiculos')
                                    ->where('id',Input::get('vehiculo_id'))
                                    ->pluck('placa');

                                    $nombreConductor = DB::table('conductores')
                                    ->where('id',Input::get('conductor_id'))
                                    ->pluck('nombre_completo');

                                    $numeroConductor = DB::table('conductores')
                                    ->where('id',Input::get('conductor_id'))
                                    ->pluck('celular');

                                    $id_servicio = $servicios->id;


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
                                        \"name\": \"modificacion_servicio\",
                                        \"language\": {
                                          \"code\": \"es\",
                                        },
                                        \"components\": [{
                                          \"type\": \"body\",
                                          \"parameters\": [{
                                            \"type\": \"text\",
                                            \"text\": \"".$dejarEn."\",
                                          },
                                          {
                                            \"type\": \"text\",
                                            \"text\": \"".$fecha."\",
                                          },
                                          {
                                            \"type\": \"text\",
                                            \"text\": \"".$hora."\",
                                          },
                                          {
                                            \"type\": \"text\",
                                            \"text\": \"".$recogerEn."\",
                                          },
                                          {
                                            \"type\": \"text\",
                                            \"text\": \"".$dejarEn."\",
                                          },
                                          {
                                            \"type\": \"text\",
                                            \"text\": \"".$placa."\",
                                          },
                                          {
                                            \"type\": \"text\",
                                            \"text\": \"".$nombreConductor."\",
                                          },
                                          {
                                            \"type\": \"text\",
                                            \"text\": \"".$numeroConductor."\",
                                          }]
                                        },
                                        {
                                          \"type\": \"button\",
                                          \"sub_type\": \"url\",
                                          \"index\": \"0\",
                                          \"parameters\": [{
                                            \"type\": \"payload\",
                                            \"payload\": \"".$id_servicio."\"
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

                                  }*/

                                }

                              }

                            }

                          }

                          if ($resaltar!=$servicios->resaltar) {
                              $cambios = $cambios.'Se cambio el campo resaltar<br>';
                          }

                          if ($pago_directo!=$servicios->pago_directo) {
                              $cambios = $cambios.'Se cambio el campo pago directo<br>';
                          }

                          if ($firma!=$servicios->firma) {
                              $cambios = $cambios.'Se cambio el campo firma<br>';
                          }

                          if ($origen!=$servicios->origen) {
                              $cambios = $cambios.'Se cambio el campo origen de <b>'.$origen.'</b> a <b>'.$servicios->origen.'</b><br>';
                          }

                          if ($destino!=$servicios->destino) {
                              $cambios = $cambios.'Se cambio el campo destino de <b>'.$destino.'</b> a <b>'.$servicios->destino.'</b><br>';
                          }

                          if ($aerolinea!=$servicios->aerolinea) {
                              $cambios = $cambios.'Se cambio el campo aerolinea de <b>'.$aerolinea.'</b> a <b>'.$servicios->aerolinea.'</b><br>';
                          }

                          if ($vuelo!=$servicios->vuelo) {
                              $cambios = $cambios.'Se cambio el campo vuelo de <b>'.$vuelo.'</b> a <b>'.$servicios->vuelo.'</b><br>';
                          }

                          if ($hora_salida!=$servicios->hora_salida) {
                              $cambios = $cambios.'Se cambio el campo hora de salida de <b>'.$hora_salida.'</b> a <b>'.$servicios->hora_salida.'</b><br>';
                          }

                          if ($hora_llegada!=$servicios->hora_llegada) {
                              $cambios = $cambios.'Se cambio el campo hora de llegada de <b>'.$hora_llegada.'</b> a <b>'.$servicios->hora_llegada.'</b><br>';
                          }

                          //228
                          if ($app_user_id!=false) {

                            //228 / 249
                            if ($app_user_id!=$servicios->app_user_id) {

                              //228
                              $usuario_anterior = User::find($app_user_id);

                              //249
                              $usuario_nuevo = User::find($servicios->app_user_id);

                              $cambios = $cambios.'Se cambio el usuario del app de '.$usuario_anterior->first_name.' '.$usuario_anterior->last_name.' a '.$usuario_nuevo->first_name.' '.$usuario_nuevo->last_name;

                            }

                          }

                          if ($cambios!='') {

                              $pivote = DB::table('servicios_edicion_pivote')->where('servicios_id',$servicios->id)->first();

                              if ($pivote!=null) {

                                  $ediciones_servicios = DB::table('ediciones_servicios')
                                      ->insert([
                                          'cambios'=>$cambios,
                                          'created_at'=>date('Y-m-d H:i:s'),
                                          'creado_por'=>Sentry::getUser()->id,
                                          'servicios_edicion_id'=>$pivote->id
                                      ]);

                              }else{

                                  $id = DB::table('servicios_edicion_pivote')
                                      ->insertGetId([
                                          'servicios_id'=>$servicios->id
                                      ]);

                                  $ediciones_servicios = DB::table('ediciones_servicios')
                                      ->insert([
                                          'cambios'=>strtoupper($cambios),
                                          'created_at'=>date('Y-m-d H:i:s'),
                                          'creado_por'=>Sentry::getUser()->id,
                                          'servicios_edicion_id'=>$id
                                      ]);
                              }

                              if (intval(Input::get('notificacion'))===1) {

                                  //si hay cambio de conductor no enviar notificacion para no enviarl doble ya que se envia mas arriba
                                  if ($cambiosConductor===false) {

                                    $centrodecosto = Centrodecosto::find($servicios->centrodecosto_id);

                                    $cambiosNotificaciones = $cambiosNotificaciones.' para '.$centrodecosto->razonsocial;

                                    $responseNotificacion = Servicio::Notificaciones($cambiosNotificaciones, $servicios->conductor_id);
                                  }

                                }

                              return Response::json([
                                  'respuesta' => true,
                                  'app_user_id' => $app_user_id,
                                  //'correoUpdate' => $correoUpdate
                              ]);

                          }else{

                              return Response::json([
                                  'respuesta'=>'error',
                                  'app_user_id' => $app_user_id
                              ]);

                          }
                      }
                  }
              }
          }
      }
  }

  public function postMostrarproveedores(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          if (Request::ajax()) {

              $proveedores = DB::select('select * from proveedores where inactivo is null order by razonsocial');

              if ($proveedores!=null) {
                  return Response::json([
                      'respuesta'=>true,
                      'proveedores'=>$proveedores
                  ]);
              }
          }
      }
  }

  public function postMostrarconductoresyvehiculos(){

      if(Request::ajax()){

          $conductores = Conductor::bloqueado()->where('proveedores_id', Input::get('proveedores_id'))->orderBy('nombre_completo')->get();
          $vehiculos = Vehiculo::bloqueadototal()->bloqueado()->where('proveedores_id', Input::get('proveedores_id'))->orderBy('placa')->get();

          if($vehiculos!=null && $conductores!=null){

              return Response::json([
                  'mensaje' => true,
                  'conductores' => $conductores,
                  'vehiculos' => $vehiculos
              ]);

          }else{

              return Response::json([
                  'mensaje' => false
              ]);
          }
      }
  }

  public function postMostrarconductoresyvehiculosfuec(){

      if(Request::ajax()){

          $conductores = Conductor::bloqueadototal()->where('proveedores_id', Input::get('proveedores_id'))->get();
          $vehiculos = Vehiculo::bloqueadototal()->bloqueado()->where('proveedores_id', Input::get('proveedores_id'))->get();

          if($vehiculos!=null && $conductores!=null){

              return Response::json([
                  'mensaje' => true,
                  'conductores' => $conductores,
                  'vehiculos' => $vehiculos
              ]);

          }else{

              return Response::json([
                  'mensaje' => false
              ]);
          }
      }
  }

  public function postMostrarrutas(){

      if (!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else{

          if (Request::ajax()) {

              $rutas = DB::table('rutas')->where('centrosdecosto_id',Input::get('id'))->orderBy('nombre_ruta')->get();

              if ($rutas!=null) {

                  return Response::json([
                      'respuesta'=>true,
                      'rutas' => $rutas
                  ]);

              }else{

                  return Response::json([
                      'respuesta'=>false,

                  ]);
              }

          }
      }
  }

  //AGREGAR RUTA EN FORMULARIO DE CREACION DE SERVICIO
  public function postAgregarruta(){

      if (!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else{

          if(Request::ajax()){

              $validaciones = [
                  'codigo'=>'required',
                  'nombre'=>'required',
                  'tarifa_cliente'=>'required',
                  'tarifa_proveedor'=>'required'
              ];

              $validador = Validator::make(Input::all(), $validaciones);

              if ($validador->fails()){

                  return Response::json([
                      'mensaje'=>false,
                      'errores'=>$validador->errors()->getMessages()
                  ]);

              }else {

                  $ruta = new Rutat;
                  $ruta->codigo_ruta = Input::get('codigo');
                  $ruta->nombre_ruta = Input::get('nombre');
                  $ruta->descripcion_ruta = Input::get('descripcion');
                  $ruta->tarifa_cliente = Input::get('tarifa_cliente');
                  $ruta->tarifa_proveedor = Input::get('tarifa_proveedor');
                  $ruta->centrosdecosto_id = Input::get('centrodecosto_id');
                  $ruta->creado_por = Sentry::getUser()->id;

                  if ($ruta->save()) {

                      $rutas = DB::table('rutas')->where('centrosdecosto_id',Input::get('centrodecosto_id'))->get();
                      return Response::json([
                          'respuesta' => true,
                          'rutas'=>$rutas
                      ]);

                  }
              }
          }
      }
  }

  public function postMostrarconductor(){

      if(Request::ajax()){

          $conductores = Conductor::bloqueadototal()->bloqueado()
          ->orderBy('nombre_completo')
          ->where('proveedores_id', Input::get('proveedores_id'))
          ->get();

          if($conductores!=null){

              return Response::json([
                'mensaje' => true,
                'conductores' => $conductores
              ]);

          }else{

              return Response::json([
                'mensaje' => false,
              ]);

          }
      }
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

                  //DATOS DE LOS PASAJEROS CONVERTIDOS A ARRAYS
                  $nombre_pasajeros = explode(',', Input::get('nombres_pasajeros'));
                  $celular_pasajeros = explode(',', Input::get('celular_pasajeros'));
                  $nivel_pasajeros = explode(',', Input::get('nivel_pasajeros'));
                  $email_pasajeros = explode(',', Input::get('email_pasajeros'));

                  //CONCATENACION DE TODOS LOS DATOS
                  for($i=0; $i < count($nombre_pasajeros); $i++){
                      $pasajeros[$i] = $nombre_pasajeros[$i].','.$celular_pasajeros[$i].','.$nivel_pasajeros[$i].','.$email_pasajeros[$i].'/';
                      $pasajeros_nombres[$i] = $nombre_pasajeros[$i].',';
                      $pasajeros_telefonos[$i] = $celular_pasajeros[$i].',';
                      $pasajeros_todos = $pasajeros_todos.$pasajeros[$i];
                      $nombres_pasajeros = $nombres_pasajeros.$pasajeros_nombres[$i];
                      $celulares_pasajeros = $celulares_pasajeros.$pasajeros_telefonos[$i];
                  }

                  //$pax = explode('/',$servicio->pasajeros);
                  $emails = [];
                  $passengers = '';

                  $totales = count($email_pasajeros);
                  for ($i=0; $i<$totales ; $i++) {
                    if($email_pasajeros[$i]!=''){

                      array_push($emails, $email_pasajeros[$i]);

                    }
                  }

                  //WAA
                  $numeros = [];
                  $names = [];
                  $passengers = '';

                  $totals = count($celular_pasajeros);
                  for ($i=0; $i<$totals ; $i++) {
                    if($celular_pasajeros[$i]!=''){

                      array_push($numeros, $celular_pasajeros[$i]);
                      array_push($names, $nombre_pasajeros[$i]);

                    }
                  }

                  //ARRAY DE LOS CAMPOS DE LOS SERVICIOS
                  $notificacionesArray = explode(',', Input::get('notificacionesArray'));
                  $resaltarArray = explode(',', Input::get('resaltarArray'));
                  $pago_directoArray = explode(',',Input::get('pago_directoArray'));
                  $rutaArray = explode(',', Input::get('rutaArray'));
                  $detalleArray = explode(',', Input::get('detalleArray'));
                  $recoger_enArray = explode(',', Input::get('recoger_enArray'));
                  $latRecogerArray = explode(',', Input::get('latRecogerArray'));
                  $lngRecogerArray = explode(',', Input::get('lngRecogerArray'));
                  $dejar_enArray = explode(',', Input::get('dejar_enArray'));
                  $latDejarArray = explode(',', Input::get('latDejarArray'));
                  $lngDejarArray = explode(',', Input::get('lngDejarArray'));
                  $fechainicioArray = explode(',', Input::get('fechainicioArray'));
                  $horainicioArray = explode(',', Input::get('horainicioArray'));
                  $proveedor_idArray = explode(',', Input::get('proveedor_idArray'));
                  $conductor_idArray = explode(',', Input::get('conductor_idArray'));
                  $conductor_nombreArray = explode(',', Input::get('conductor_nombreArray'));
                  $vehiculo_idArray = explode(',', Input::get('vehiculo_idArray'));
                  $vehiculo_datosArray = explode(',', Input::get('vehiculo_datosArray'));
                  $origenArray = explode(',', Input::get('origenArray'));
                  $destinoArray = explode(',', Input::get('destinoArray'));
                  $vueloArray = explode(',', Input::get('vueloArray'));
                  $aerolineaArray = explode(',', Input::get('aerolineaArray'));
                  $hora_llegadaArray = explode(',', Input::get('hora_llegadaArray'));
                  $hora_salidaArray = explode(',', Input::get('hora_salidaArray'));

                  /*FOR PARA INSERTAR LOS REGISTROS DE LA TABLA DE SERVICIOS SEGUN EL NUMERO DE FILAS INSERTADAS CONTADAS
                    POR EL NUMERO DE SERVICIOS QUE SE INGRESARON EN LA TABLA*/
                  $contar = 0;
                  $contar_falso = 0;
									$servicio_id ='';
                  $serviciosArrays = [];
                  $dataCorreos = '';
                  $dataNumeros = '';
                  $cantidadArrays = count($rutaArray);
                  $countTrue = 0;
                  $countFalse = 0;

                  for($i=0; $i<$cantidadArrays; $i++){

                      $consulta = "SELECT * FROM liquidacion_servicios WHERE '".$fechainicioArray[$i]."' BETWEEN fecha_inicial AND fecha_final and centrodecosto_id = '".Input::get('centrodecosto_id')."' and subcentrodecosto_id = '".Input::get('subcentrodecosto_id')."' and ciudad = '".Input::get('ciudad')."' and anulado is null and nomostrar is null";
                      $consulta_orden = "SELECT * FROM ordenes_facturacion WHERE '".$fechainicioArray[$i]."' BETWEEN fecha_inicial AND fecha_final and centrodecosto_id = '".Input::get('centrodecosto_id')."' and subcentrodecosto_id = '".Input::get('subcentrodecosto_id')."' and ciudad = '".Input::get('ciudad')."' and anulado is null and nomostrar is null and tipo_orden = 1";

                      $liquidacion = DB::select($consulta);
                      $ordenes_facturacion = DB::select($consulta_orden);

                      if($ordenes_facturacion!=null or $liquidacion!=null){
                          $contar_falso++;
                      }else{

                          $code = "";
                          $characters = array_merge(range('0','9'));
                          $max = count($characters) - 1;
                          for ($o = 0; $o < 2; $o++) {
                            $rand = mt_rand(0, $max);
                            $code .= $characters[$rand];
                          }

                          $servicio = new Servicio();
                          $servicio->fecha_orden = Input::get('fecha_orden');
                          $servicio->centrodecosto_id = Input::get('centrodecosto_id');
                          $servicio->subcentrodecosto_id = Input::get('subcentrodecosto_id');

                          if (Input::get('user_id')!=null) {
                            $servicio->app_user_id = Input::get('user_id');
                          }else {
                            $servicio->app_user_id = null;
                          }

                          $servicio->pasajeros = $pasajeros_todos;
                          $servicio->cantidad = Input::get('cantidad');
                          $servicio->departamento = Input::get('departamento');
                          $servicio->ciudad = Input::get('ciudad');
                          $servicio->solicitado_por = Input::get('solicitado_por');
                          $servicio->email_solicitante = Input::get('email_solicitante');
                          $servicio->fecha_solicitud = Input::get('fecha_solicitud');

                          $servicio->firma = Input::get('firma');

                          $servicio->resaltar = $resaltarArray[$i];
                          $servicio->pago_directo = $pago_directoArray[$i];
                          $servicio->ruta_id = $rutaArray[$i];
                          //$servicio->localidad = 1;
                          $servicio->recoger_en = $recoger_enArray[$i];
                          $arrayRecoger = [
                            'lat' => $latRecogerArray[$i],
                            'lng' => $lngRecogerArray[$i]
                          ];
                          $servicio->desde = json_encode([$arrayRecoger]);
                          $servicio->dejar_en = $dejar_enArray[$i];
                          $arrayDejar = [
                            'lat' => $latDejarArray[$i],
                            'lng' => $lngDejarArray[$i]
                          ];
                          $servicio->hasta = json_encode([$arrayDejar]);
                          $servicio->detalle_recorrido = $detalleArray[$i];
                          $servicio->proveedor_id = $proveedor_idArray[$i];
                          $servicio->conductor_id = $conductor_idArray[$i];
                          $servicio->vehiculo_id = $vehiculo_idArray[$i];
                          $servicio->fecha_servicio = $fechainicioArray[$i];
                          $servicio->hora_servicio = $horainicioArray[$i];
                          $servicio->origen = $origenArray[$i];
                          $servicio->destino = $destinoArray[$i];
                          $servicio->aerolinea = $aerolineaArray[$i];
                          $servicio->vuelo = $vueloArray[$i];
                          $servicio->hora_salida = $hora_salidaArray[$i];
                          $servicio->hora_llegada = $hora_llegadaArray[$i];
                          $servicio->creado_por = Sentry::getUser()->id;
                          $servicio->anulado = 0;
                          $servicio->cancelado = 0;
                          $servicio->expediente = Input::get('expediente');
                          $servicio->notificaciones_reconfirmacion = $code;
                          $servicio->aceptado_app = 0;
                          $servicio->localidad = 1;
                          $servicio->hora_programado_app = date('Y-m-d H:i:s');
                          if(Sentry::getUser()->id_rol == 8){
                            $servicio->control_facturacion = 1;
                          }
                          $servicio->localidad = 1;

                          //Para la creacion de servicios de afiliados externos
                          if (isset($option)) {
                            if ($option==2) {
                              $servicio->afiliado_externo = 1;
                            }
                          }

                          $servicio->save();

                          $contar++;
                          if ($notificacionesArray[$i]==='SI') {
                            $number = rand(10000000, 99999999);
                            $notifications = Servicio::enviarNotificaciones($conductor_idArray[$i], $fechainicioArray[$i], $horainicioArray[$i], $recoger_enArray[$i], $dejar_enArray[$i], $number, $servicio->id);
                            $countTrue = $countTrue + intval($notifications['countTrue']);
                            $countFalse = $countFalse + intval($notifications['countFalse']);
                          }

                          //if(Sentry::getUser()->id==2){

                          if($numeros!=[]){//hay celulares

                            for ($z=0; $z < $totals; $z++) {

                              if(isset($numeros[$z])){

                                $placaVehiculo = DB::table('vehiculos')
                                ->where('id',$servicio->vehiculo_id)
                                ->pluck('placa');

                                $nameConductor = DB::table('conductores')
                                ->where('id',$servicio->conductor_id)
                                ->pluck('nombre_completo');

                                $celConductor = DB::table('conductores')
                                ->where('id',$servicio->conductor_id)
                                ->pluck('celular');

                                $number = $numeros[$z]; //'57'.Concatenación del indicativo con el número
                                $namewaap = explode(" ", $names[$z]);

                                if($i==0){
                                  $dataNumeros .= $number.'<br>';
                                }

                                $number = intval($number);
                                $nombre = $namewaap[0];

                                $fecha = $servicio->fecha_servicio;
                                $hora = $servicio->hora_servicio;
                                $origen = $servicio->recoger_en;
                                $destino = $servicio->dejar_en;
                                $cliente = DB::table('centrosdecosto')
                                ->where('id',Input::get('centrodecosto_id'))
                                ->pluck('razonsocial');

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
                                    \"name\": \"service_prog\",
                                    \"language\": {
                                      \"code\": \"es\",
                                    },
                                    \"components\": [{
                                      \"type\": \"body\",
                                      \"parameters\": [{
                                        \"type\": \"text\",
                                        \"text\": \"".$nombre."\",
                                      },
                                      {
                                        \"type\": \"text\",
                                        \"text\": \"".$fecha."\",
                                      },
                                      {
                                        \"type\": \"text\",
                                        \"text\": \"".$hora."\",
                                      },
                                      {
                                        \"type\": \"text\",
                                        \"text\": \"".$origen."\",
                                      },
                                      {
                                        \"type\": \"text\",
                                        \"text\": \"".$destino."\",
                                      },
                                      {
                                        \"type\": \"text\",
                                        \"text\": \"".$placaVehiculo."\",
                                      }]
                                    },
                                    {
                                      \"type\": \"button\",
                                      \"sub_type\": \"url\",
                                      \"index\": \"0\",
                                      \"parameters\": [{
                                        \"type\": \"payload\",
                                        \"payload\": \"".$servicio->id."\"
                                      }]
                                    },{
                                      \"type\": \"button\",
                                      \"sub_type\": \"url\",
                                      \"index\": \"1\",
                                      \"parameters\": [{
                                        \"type\": \"payload\",
                                        \"payload\": \"".$servicio->id."\"
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

                          }else{
                            $response = null;
                          }

                          /*if($emails!=[]){//hay correos

                            $valores = count($email_pasajeros);

                            $query_servicio = Servicio::select('servicios.*', 'servicios.fecha_servicio', 'servicios.fecha_solicitud','servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.hora_servicio', 'servicios.pasajeros', 'centrosdecosto.razonsocial', 'vehiculos.clase', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'conductores.nombre_completo', 'conductores.celular')
                            ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
                            ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
                            ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                            ->where('servicios.id',$servicio->id)
                            ->first();

                            $conductor = DB::table('conductores')
                            ->where('id',$servicio->conductor_id)
                            ->first();

                            $vehiculo = DB::table('vehiculos')
                            ->where('id',$servicio->vehiculo_id)
                            ->first();

                            $data = [
                              'conductor' => $conductor,
                              'servicio' => 1111,
                              'vehiculo' => $vehiculo,
                              'firma' => 1111,
                              'servicio' => $query_servicio,
                            ];

                            $emailcc = ['aotourdeveloper@gmail.com','transportebogota@aotour.com.co'];
                            //$emailcc = 'aotourdeveloper@gmail.com';
                            $email = $emails;

                            Mail::send('emails.nuevo_servicio', $data, function($message) use ($emails, $emailcc){
                              $message->from('no-reply@aotour.com.co', 'AOTOUR');
                              $message->to($emails)->subject('Programación de Servicio / Service Schedule');
                              $message->cc($emailcc);
                            });

                          }*/

                          if($i==$cantidadArrays-1){
                            $coma = '';
                          }else{
                            $coma = ',';
                          }
                          $servicio_id = $servicio_id . $servicio->id.$coma;
                          array_push($serviciosArrays, $servicio->id);

                      }
                  }

                  $sw = 0;
                  /*if(Sentry::getUser()->id===2){
                    //SI ESTÁ ACTIVADA LA OPCIÓN KILÓMETRAJE
                    $paxss = explode('/', $pasajeros_todos);
                    //SEPARACIÓN DE USUARIOS
                    $pac = explode(',', $paxss[0]);
                    $sw = $pac[1];
                    $o = 0;
                    for($i=0; $i < count($paxss)-1; $i++){
                      $pac = explode(',', $paxss[$o]);

                      $sw = $pac[1];
                      $post['to'] = array('57'.$sw);
                      $post['text'] = "TE LLEVAMOS. Tracking: https://app.aotour.com.co/autonet/maps/trackingservice/".$servicio->id."";
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
                      $o++;
                    }
                    //SEPARACIÓN DE USUARIOS

                    //
                  }*/

                  $conta = $email_pasajeros;

                  $totaless = count($email_pasajeros);
                  $query_servicio = null;

                  if($totaless>0){

                    for ($i=0; $i < $totaless; $i++) {
                      if($email_pasajeros[$i]!=''){
                        $query_servicio = Servicio::select('servicios.*', 'servicios.fecha_servicio', 'servicios.fecha_solicitud','servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.hora_servicio', 'servicios.pasajeros', 'centrosdecosto.razonsocial', 'vehiculos.clase', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'conductores.nombre_completo', 'conductores.celular')
                        ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
                        ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
                        ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                        ->whereIn('servicios.id',$serviciosArrays)
                        ->get();

                        $dataCorreos .= $email_pasajeros[$i].'<br>';

                        $data = [
                          'cantidad' => $cantidadArrays,
                          'nombre_pasajeros' => $nombre_pasajeros,
                          'servicios' => $query_servicio,
                        ];

                        $emailcc = ['aotourdeveloper@gmail.com'];//,'transportebarranquilla@aotour.com.co'
                        $email = $email_pasajeros[$i];

                        /*Mail::send('emails.nuevo_servicio', $data, function($message) use ($email, $emailcc){
                          $message->from('no-reply@aotour.com.co', 'AOTOUR');
                          $message->to($email)->subject('Programación de Servicio / Service Schedule');
                          $message->cc($emailcc);
                        });*/
                      }
                    }

                  }

                  return Response::json([
                      'mensaje'=>true,
                      'numeros' => $numeros,
                      'query_servicio' => $query_servicio,
                      'nombre_pasajeros' => $nombre_pasajeros,
                      'serviciosArrays' => $serviciosArrays,
                      'totaless' => $totaless,
                      'email_pasajeros' => $email_pasajeros,
                      'dataNumeros' => $dataNumeros,
                      'dataCorreos' => $dataCorreos,
                      'pasajeros'=>$pasajeros_todos,
                      'contar'=>$contar,
                      'contar_falso'=>$contar_falso,
                      'servicio_id'=>$servicio_id,
                      'cantidadArrays' => $cantidadArrays,
                      'passengers' => $emails,
                      'sw' => $sw,
                      //'valores' => $valores,
                      //'vals' => Input::get('email_pasajeros'),
                      'email' => $email_pasajeros,
                      'notifications' => [
                        'countTrue' => $countTrue,
                        'countFalse' => $countFalse,
                      ]
                  ]);

              }
          }
      }
  }

  public function postMostrardatosservicio(){

    $servicio = DB::table('servicios')
    ->where('id',Input::get('id'))
    ->first();

    $usuarios_app = User::where('centrodecosto_id', $servicio->centrodecosto_id)->get();

    $proveedor = DB::table('proveedores')
    ->where('id',$servicio->proveedor_id)
    ->first();

    $proveedores_eventuales = DB::table('proveedores')
    ->where('eventual',1)
    ->orderBy('razonsocial')
    ->get();

    $proveedores = Proveedor::Afiliadosinternos()
    ->orderBy('razonsocial')
    ->whereIn('localidad',['bogota','provisional'])
    ->where('tipo_servicio', 'TRANSPORTE TERRESTRE')
    ->whereNull('inactivo_total')
    ->whereNull('inactivo')
    ->get();

    if ($servicio!=null) {
        return Response::json([
            'usuarios_app' => $usuarios_app,
            'respuesta' => true,
            'servicios' => $servicio,
            'proveedor' => $proveedor,
            'proveedores_eventuales' => $proveedores_eventuales,
            'proveedores' => $proveedores
        ]);
    }

  }

  public function postMostrarciudades(){

      $departamento_id = DB::table('departamento')->where('departamento',Input::get('departamento'))->first();
      $ciudades = DB::table('ciudad')->where('departamento_id',$departamento_id->id)->get();
      if ($ciudades!=null) {
          return Response::json([
              'mensaje'=>true,
              'ciudades'=>$ciudades
          ]);
      }else{
          return Response::json([
              'mensaje'=>false
          ]);
      }
  }

  public function postCancelarservicio(){

      if (!Sentry::check())
      {
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else{

          if(Request::ajax()){
              $servicios = Servicio::find(Input::get('id'));
              $servicios->cancelado = 1;
              $servicios->cancelado_por = Sentry::getUser()->id;

              if($servicios->save()){
                  return Response::json([
                      'mensaje'=>true
                  ]);
              }

          }

      }
  }

  public function postEliminarservicio(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          if(Request::ajax()){

              #GUARDAR LA NOVEDAD RECONFIRMACION EN UNA VARIABLE
              $novedadesreconfirmacion = DB::table('novedades_reconfirmacion')->where('id_reconfirmacion', Input::get('id'))->first();
              if ($novedadesreconfirmacion===null){
                  $novedadesreconfirmacion = null;
              }

              #ELIMINAR LAS NOVEDADES RECONFIRMACION
              $elimnovedades = DB::table('novedades_reconfirmacion')->where('id_reconfirmacion', Input::get('id'))->delete();

              #GUARDAR LA RECONFIRMACION EN UNA VARIABLE
              $reconfirmacion = DB::table('reconfirmacion')->where('id_servicio', Input::get('id'))->first();

              #ELIMINAR LA RECONFIRMACION
              $elimreconfirm = DB::table('reconfirmacion')->where('id_servicio', Input::get('id'))->delete();

              #GUARDAR LA FACTURACION EN UNA VARIABLE
              $facturacion = DB::table('facturacion')->where('servicio_id',Input::get('id'))->first();

              #ELIMINAR LA FACTURACION
              $elimfactura = DB::table('facturacion')->where('servicio_id',Input::get('id'))->delete();

              #SERVICIOS EDICION PIVOTE
              $servicios_edicion_pivote = DB::table('servicios_edicion_pivote')->where('servicios_id',Input::get('id'))->first();

              #SI SERVICIOS EDICION PIVOTE EXISTE ENTONCES ELIMINAR LAS EDICIONES
              if ($servicios_edicion_pivote) {
                  $ediciones_servicios = DB::table('ediciones_servicios')->where('servicios_edicion_id', $servicios_edicion_pivote->id)->delete();
                  $servicios_edicion_delete = DB::table('servicios_edicion_pivote')->where('id', $servicios_edicion_pivote->id)->delete();
              }

              $servicios = Servicio::find(Input::get('id'));

              $servicio = DB::table('servicios')
              ->select('servicios.id', 'servicios.fecha_orden', 'servicios.fecha_servicio', 'servicios.hora_inicio',
                       'servicios.hora_finalizado',
                       'servicios.solicitado_por', 'servicios.resaltar', 'servicios.recorrido_gps', 'servicios.aceptado_app',
                       'servicios.fecha_solicitud','servicios.ciudad','servicios.recoger_en','servicios.dejar_en',
                       'servicios.detalle_recorrido','servicios.pasajeros','servicios.hora_servicio','servicios.origen',
                       'servicios.destino', 'servicios.aerolinea', 'servicios.vuelo', 'servicios.hora_salida',
                       'servicios.hora_llegada', 'servicios.cancelado','centrosdecosto.razonsocial',
                       'subcentrosdecosto.nombresubcentro','users.first_name','users.last_name',
                       'rutas.nombre_ruta','rutas.codigo_ruta','proveedores.razonsocial AS razonproveedor',
                       'conductores.nombre_completo','conductores.celular','conductores.telefono',
                       'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo')
              ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
              ->leftJoin('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
              ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
              ->LeftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
              ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
              ->leftJoin('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
              ->leftJoin('users', 'servicios.creado_por', '=', 'users.id')
              ->where('servicios.id', Input::get('id'))
              ->first();

              /*$serv = DB::table('servicios')
              ->leftJoin('reconfirmacion', 'servicios.id', '=', 'reconfirmacion.id_servicio')
              ->where('id', Input::get('id'))
              ->get();*/

              $papelera = DB::table('papelera')->insert([
                  'informacion'=>json_encode($servicio),
                  'informacion_facturacion'=>json_encode($facturacion),
                  'informacion_novedades_reconfirmacion'=>json_encode($novedadesreconfirmacion),
                  'informacion_reconfirmacion'=>json_encode($reconfirmacion),
                  'motivo_eliminacion'=>$servicios->motivo_eliminacion,
                  'servicios'=>1,
                  'eliminado_por'=>$servicios->usuario_eliminacion,
                  'fecha_eliminacion'=>$servicios->fecha_solicitud_eliminacion
              ]);

              if($servicios->delete()){
                  return Response::json([
                      'mensaje'=>true,
                      'facturacion'=>$facturacion
                  ]);
              }else{
                  return Response::json([
                      'mensaje'=>false
                  ]);
              }

          }

      }
  }

  public function postDetalleseliminacion(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else {

          if (Request::ajax()) {

              $id = Input::get('id');
              $servicio = DB::table('servicios')
                  ->select('servicios.motivo_eliminacion','servicios.fecha_solicitud_eliminacion','users.first_name','users.last_name')
                  ->leftJoin('users','servicios.usuario_eliminacion','=','users.id')
                  ->where('servicios.id',$id)
                  ->first();
              return Response::json([
                  'respuesta'=>true,
                  'servicio'=>$servicio
              ]);
          }
      }
  }

  public function postProgramareliminacion(){

      if (!Sentry::check()){

        return Response::json([
          'respuesta'=>'relogin'
        ]);

      }else {

          if (Request::ajax()) {

              #TOMAR ID DEL SERVICIO
              $id = Input::get('id');

              #BUSCAR SERVICIO POR ID
              $servicio = Servicio::find($id);
              $servicio->motivo_eliminacion = Input::get('motivo_eliminacion');
              $servicio->pendiente_autori_eliminacion = 1;
              $servicio->usuario_eliminacion = Sentry::getUser()->id;
              $servicio->fecha_solicitud_eliminacion = date('Y-m-d H:i:s');

              if (is_null($servicio->recorrido_gps)):

                if($servicio->save()):

                    $apikey = 'AAAAmVuqq8M:APA91bGKk3kzjOdsCwbkxDUJwjW56XSJnVX5c-xa9AkPOGcFc1qdtHfppEiIUkM7klen0lHC84DK07Ds7wrrTEJiDBgZHzLabezWkTUx1qeFWM5uggF8nPO3HjQsTcrC0EYw3RGhrsch';
                    $id_usuario = DB::table('conductores')->where('id', $servicio->conductor_id)->pluck('usuario_id');
                    $id_registration = DB::table('users')->where('id', $id_usuario)->pluck('idregistrationdevice');

                    if ($id_registration!=null and $id_registration!='') {

                      $registrationId = [$id_registration];

                      $data = [
                        'body' => 'Se ha cancelado el servicio que tenia programado para el día '.$servicio->fecha_servicio.' y hora: '.$servicio->hora_servicio.' para recoger en: '.strtolower($servicio->recoger_en).' y dejar en: '.strtolower($servicio->recoger_en).', revisar listado de servicios',
                        'message' => 'Se ha cancelado el servicio que tenia programado para el día '.$servicio->fecha_servicio.' y hora: '.$servicio->hora_servicio.' para recoger en: '.strtolower($servicio->recoger_en).' y dejar en: '.strtolower($servicio->recoger_en).', revisar listado de servicios',
                        'title' => 'Aotour Mobile',
                        'notId' => rand(8, 18),
                        'vibrationPattern' => [2000, 1000, 500, 500],
                        'soundname' => 'default'
                      ];

                      $fields = [
                        'registration_ids' => $registrationId,
                        'data' => $data
                      ];

                      $headers = [
                        'Authorization: key='. $apikey,
                        'Content-Type: application/json'
                      ];

                      $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                      $result = curl_exec($ch);

                      curl_close($ch);

                    }

                    return Response::json([
                        'respuesta'=>true
                    ]);

                else:

                    return Response::json([
                      'respuesta'=>false
                    ]);

                endif;

              elseif(!is_null($servicio->recorrido_gps)):

                return Response::json([
                  'respuesta' => false,
                  'mensaje' => 'Este servicio no puede ser eliminado ya que contiene registro GPS!.'
                ]);

              endif;

          }
      }
  }

  public function postRechazareliminacion(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else {

          if (Request::ajax()) {

              //CONTAR ORDENES DE FACTURACION PARA SABER SI YA EXISTE UNA ORDEN DE FACTURACION CON ESTOS VALORES
              $id = Input::get('id');

              $servicio = Servicio::find($id);

              $consulta = "SELECT * FROM liquidacion_servicios WHERE '".$servicio->fecha_servicio."' BETWEEN fecha_inicial AND fecha_final and centrodecosto_id = '".$servicio->centrodecosto_id."' and subcentrodecosto_id = '".$servicio->subcentrodecosto_id."' and anulado is null and nomostrar is null";
              $consulta_orden = "SELECT * FROM ordenes_facturacion WHERE '".$servicio->fecha_servicio."' BETWEEN fecha_inicial AND fecha_final and centrodecosto_id = '".$servicio->centrodecosto_id."' and subcentrodecosto_id = '".$servicio->subcentrodecosto_id."' and anulado is null and nomostrar is null";

              $liquidacion = DB::select($consulta);
              $ordenes_facturacion = DB::select($consulta_orden);

              if($ordenes_facturacion!=null or $liquidacion!=null){

                  return [
                      'respuesta'=>'rechazado',
                      'consulta'=>$consulta,
                      'consulta_orden'=>$consulta_orden,
                      'liquidacion'=>$liquidacion,
                      'ordenes_facturacion'=>$liquidacion
                  ];

              }else{

                  $servicio->motivo_rechazo = Input::get('motivo_rechazo');
                  $servicio->rechazar_eliminacion = 1;
                  $servicio->pendiente_autori_eliminacion = null;

                  if ($servicio->save()){

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
  }

  public function postMotivorechazo(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else {

          if (Request::ajax()) {

              $id = Input::get('id');

              $servicio = DB::table('servicios')->where('id',$id)->first();

              return Response::json([
                  'respuesta'=>true,
                  'motivo_rechazo'=>$servicio->motivo_rechazo
              ]);

          }
      }
  }

  /**
   * [getReconfirmacion Obtener vista de]
   * @param  [entero] $id [description]
   * @return [type]     [description]
   */
  public function getReconfirmacion($id){

      if (Sentry::check()){
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->bogota->reconfirmacion->ver;
      }else{
        $id_rol = null;
        $permisos = null;
        $permisos = null;
        $ver = null;
      }

      if (!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on') {

          return View::make('admin.permisos');

      }else{

          $servicios = DB::table('servicios')
              ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
              ->join('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
              ->leftJoin('facturacion', 'servicios.id', '=', 'facturacion.servicio_id')
              ->join('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
              ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
              ->join('users', 'servicios.creado_por', '=', 'users.id')
              ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.pasajeros','servicios.finalizado',
                       'proveedores.razonsocial', 'conductores.nombre_completo', 'users.first_name', 'servicios.centrodecosto_id', 'users.last_name',
                       'centrosdecosto.razonsocial as razon', 'subcentrosdecosto.nombresubcentro', 'facturacion.revisado')
              ->where('servicios.id', $id)->get();

              $service = DB::table('servicios')
                ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
                ->join('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
                ->leftJoin('facturacion', 'servicios.id', '=', 'facturacion.servicio_id')
                ->join('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
                ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
                ->join('users', 'servicios.creado_por', '=', 'users.id')
                ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.pasajeros','servicios.finalizado', 'servicios.ruta', 'servicios.hora_inicio', 'servicios.hora_finalizado', 'servicios.recoger_en', 'servicios.dejar_en', 'servicios.detalle_recorrido', 'servicios.estado_servicio_app',
                         'proveedores.razonsocial', 'conductores.nombre_completo', 'users.first_name', 'servicios.centrodecosto_id', 'users.last_name',
                         'centrosdecosto.razonsocial as razon', 'subcentrosdecosto.nombresubcentro', 'facturacion.revisado')
                ->where('servicios.id', $id)->first();

          $reconfirmacion = DB::table('reconfirmacion')
              ->join('users','reconfirmacion.reconfirmado_por', '=','users.id')
              ->select('reconfirmacion.id','reconfirmacion.reconfirmacion2hrs','reconfirmacion.novedad_2',
                       'reconfirmacion.reconfirmacion1hrs','reconfirmacion.novedad_1',
                       'reconfirmacion.reconfirmacion30min','reconfirmacion.novedad_30',
                       'reconfirmacion.reconfirmacion_horacita','reconfirmacion.novedad_hora',
                       'reconfirmacion.reconfirmacion_ejecucion','reconfirmacion.novedad_ejecucion',
                       'reconfirmacion.ejecutado','reconfirmacion.novedad_ejecucion','users.first_name','users.last_name')
              ->where('reconfirmacion.id_servicio',$id)->first();

          $consulta = "select id, fecha, hora, consecutivo, nombre_encuestado, centrodecosto, area, pregunta_1, pregunta_2, ".
                      "pregunta_3, pregunta_4, pregunta_5, pregunta_6, pregunta_7, pregunta_8, cual5, pregunta_9, ".
                      "cual6, pregunta_10, cual7, hora, created_at, updated_at, ".
                      "extract(month from created_at) as mes, fecha, ".
                      "extract(minute from created_at) as minutos, percepcion, creado_por, id_servicio from encuesta where id_servicio = '".$id."'";

          $encuesta = DB::select($consulta." limit 1");

          $novedades = DB::table('novedades_reconfirmacion')
          ->select('novedades_reconfirmacion.created_at','novedades_reconfirmacion.seleccion_opcion',
                   'users.first_name','users.last_name','novedades_reconfirmacion.descripcion')
          ->join('users', 'novedades_reconfirmacion.creado_por', '=', 'users.id')
          ->where('id_reconfirmacion',$id)
          ->get();

          $novedades_app = DB::table('novedades_app')
          ->where('servicio_id', $id)
          ->get();

          $reportes_pivote = DB::table('reportes_pivote')->where('servicio_id',$id)->first();

          if ($reportes_pivote!=null) {

              $reportes = DB::table('reportes')
              ->select('reportes.descripcion', 'reportes.creado_por','reportes.created_at',
                        'users.first_name','users.last_name')
              ->where('reportes_id', $reportes_pivote->id)
              ->leftJoin('users','reportes.creado_por', '=','users.id')
              ->get();

          }else{
              $reportes = null;
          }

          $servicios_edicion_pivote = DB::table('servicios_edicion_pivote')->where('servicios_id',$id)->first();

          if ($servicios_edicion_pivote!=null) {

              $ediciones = DB::table('ediciones_servicios')
              ->select('ediciones_servicios.cambios', 'ediciones_servicios.creado_por','ediciones_servicios.created_at',
                        'users.first_name','users.last_name')
              ->where('servicios_edicion_id', $servicios_edicion_pivote->id)
              ->leftJoin('users','ediciones_servicios.creado_por', '=','users.id')
              ->get();

          }else{
              $ediciones= null;
          }

          $cambiosFacturacion = DB::table('facturacion')->where('servicio_id',$id)->pluck('cambios_servicio');

          return View::make('servicios.reconfirmacion')
          ->with([
              'servicios' => $servicios,
              'service' => $service,
              'reconfirmacion' => $reconfirmacion,
              'novedades' => $novedades,
              'novedades_app' => $novedades_app,
              'reportes'=>$reportes,
              'i'=>0,
              'ediciones' => $ediciones,
              'encuesta' => $encuesta,
              'cambiosFacturacion' => $cambiosFacturacion,
              'permisos' => $permisos
          ]);
      }
  }

  public function postReconfirmaciones(){

      if(Request::ajax()){

          if(Input::get('reconfirmacion')==='1'){
              $data_update = trim(Input::get('data_update'));
              if($data_update=='0'){
                  $reconfirmacion = Reconfirmacion::find(Input::get('reconfirmacion_id'));
                  $reconfirmacion->reconfirmacion2hrs = date('H:i:s');
                  if(Input::get('novedad_reconfirmacion')!=null){
                      $reconfirmacion->novedad_2 = Input::get('novedad_reconfirmacion');
                  }else{
                      $reconfirmacion->novedad_2 = 'RECONFIRMACION SIN NINGUNA NOVEDAD';
                  }
                  $reconfirmacion->numero_reconfirmaciones = $reconfirmacion->numero_reconfirmaciones + 1;

                  if($reconfirmacion->save()){
                      return Response::json([
                          'respuesta'=>true,
                      ]);
                  }
              }else{
                  $reconfirmacion = new Reconfirmacion();
                  $reconfirmacion->id_servicio = Input::get('id');
                  $reconfirmacion->reconfirmacion2hrs = date('H:i:s');
                  if(Input::get('novedad_reconfirmacion')!=null){
                      $reconfirmacion->novedad_2 = Input::get('novedad_reconfirmacion');
                  }else{
                      $reconfirmacion->novedad_2 = 'RECONFIRMACION SIN NINGUNA NOVEDAD';
                  }
                  $reconfirmacion->reconfirmado_por = Sentry::getUser()->id;
                  $reconfirmacion->numero_reconfirmaciones = 1;
                  if($reconfirmacion->save()){

                      return Response::json([
                          'respuesta'=>true,
                      ]);

                  }
              }
          }

          if(Input::get('reconfirmacion')==='2'){
              $data_update = trim(Input::get('data_update'));
              if($data_update=='0'){
                  $reconfirmacion = Reconfirmacion::find(Input::get('reconfirmacion_id'));
                  $reconfirmacion->reconfirmacion1hrs = date('H:i:s');
                  if(Input::get('novedad_reconfirmacion')!=null){
                     $reconfirmacion->novedad_1 = Input::get('novedad_reconfirmacion');
                  }else{
                     $reconfirmacion->novedad_1 = 'RECONFIRMACION SIN NINGUNA NOVEDAD';
                  }
                  $reconfirmacion->numero_reconfirmaciones = $reconfirmacion->numero_reconfirmaciones + 1;
                  if($reconfirmacion->save()){
                      return Response::json([
                          'respuesta'=>true,
                      ]);
                  }
              }else{
                  $reconfirmacion = new Reconfirmacion();
                  $reconfirmacion->id_servicio = Input::get('id');
                  $reconfirmacion->reconfirmacion1hrs = date('H:i:s');
                  if(Input::get('novedad_reconfirmacion')!=null){
                      $reconfirmacion->novedad_1 = Input::get('novedad_reconfirmacion');
                  }else{
                      $reconfirmacion->novedad_1 = 'RECONFIRMACION SIN NINGUNA NOVEDAD';
                  }
                  $reconfirmacion->reconfirmado_por = Sentry::getUser()->id;
                  $reconfirmacion->numero_reconfirmaciones = 1;
                  if($reconfirmacion->save()){

                      return Response::json([
                          'respuesta'=>true,
                      ]);

                  }
              }

          }

          if(Input::get('reconfirmacion')==='3'){
              $data_update = trim(Input::get('data_update'));
              if($data_update=='0'){
                  $reconfirmacion = Reconfirmacion::find(Input::get('reconfirmacion_id'));
                  $reconfirmacion->reconfirmacion30min = date('H:i:s');
                  if(Input::get('novedad_reconfirmacion')!=null){
                      $reconfirmacion->novedad_30 = Input::get('novedad_reconfirmacion');
                  }else{
                      $reconfirmacion->novedad_30 = 'RECONFIRMACION SIN NINGUNA NOVEDAD';
                  }
                  $reconfirmacion->numero_reconfirmaciones = $reconfirmacion->numero_reconfirmaciones + 1;
                  if($reconfirmacion->save()){
                      return Response::json([
                          'respuesta'=>true,
                      ]);
                  }
              }else{
                  $reconfirmacion = new Reconfirmacion();
                  $reconfirmacion->id_servicio = Input::get('id');
                  $reconfirmacion->reconfirmacion30min = date('H:i:s');
                  if(Input::get('novedad_reconfirmacion')!=null){
                      $reconfirmacion->novedad_30 = Input::get('novedad_reconfirmacion');
                  }else{
                      $reconfirmacion->novedad_30 = 'RECONFIRMACION SIN NINGUNA NOVEDAD';
                  }
                  $reconfirmacion->reconfirmado_por = Sentry::getUser()->id;
                  $reconfirmacion->numero_reconfirmaciones = 1;
                  if($reconfirmacion->save()){

                      return Response::json([
                          'respuesta'=>true,
                      ]);

                  }
              }

          }

          if(Input::get('reconfirmacion')==='4'){
              $data_update = trim(Input::get('data_update'));
              if($data_update=='0'){
                  $reconfirmacion = Reconfirmacion::find(Input::get('reconfirmacion_id'));
                  $reconfirmacion->reconfirmacion_horacita = date('H:i:s');
                  if(Input::get('novedad_reconfirmacion')!=null){
                      $reconfirmacion->novedad_hora = Input::get('novedad_reconfirmacion');
                  }else{
                      $reconfirmacion->novedad_hora = 'RECONFIRMACION SIN NINGUNA NOVEDAD';
                  }
                  $reconfirmacion->numero_reconfirmaciones = $reconfirmacion->numero_reconfirmaciones + 1;
                  if($reconfirmacion->save()){
                      return Response::json([
                          'respuesta'=>true,
                      ]);
                  }
              }else{
                  $reconfirmacion = new Reconfirmacion();
                  $reconfirmacion->id_servicio = Input::get('id');
                  $reconfirmacion->reconfirmacion_horacita = date('H:i:s');
                  if(Input::get('novedad_reconfirmacion')!=null){
                      $reconfirmacion->novedad_hora = Input::get('novedad_reconfirmacion');
                  }else{
                      $reconfirmacion->novedad_hora = 'RECONFIRMACION SIN NINGUNA NOVEDAD';
                  }
                  $reconfirmacion->reconfirmado_por = Sentry::getUser()->id;
                  $reconfirmacion->numero_reconfirmaciones = 1;
                  if($reconfirmacion->save()){

                      return Response::json([
                          'respuesta'=>true,
                      ]);

                  }
              }
          }

          if(Input::get('reconfirmacion')==='5'){
              $data_update = trim(Input::get('data_update'));
              if($data_update=='0'){
                  $reconfirmacion = Reconfirmacion::find(Input::get('reconfirmacion_id'));
                  $reconfirmacion->reconfirmacion_ejecucion = date('H:i:s');
                  if(Input::get('novedad_reconfirmacion')!=null){
                      $reconfirmacion->novedad_ejecucion = Input::get('novedad_reconfirmacion');
                  }else{
                      $reconfirmacion->novedad_ejecucion = 'RECONFIRMACION SIN NINGUNA NOVEDAD';
                  }
                  $reconfirmacion->numero_reconfirmaciones = $reconfirmacion->numero_reconfirmaciones + 1;
                  $reconfirmacion->ejecutado = 1;
                  if($reconfirmacion->save()){
                      return Response::json([
                          'respuesta'=>true,
                      ]);
                  }
              }else{
                  $reconfirmacion = new Reconfirmacion();
                  $reconfirmacion->id_servicio = Input::get('id');
                  $reconfirmacion->reconfirmacion_ejecucion = date('H:i:s');
                  if(Input::get('novedad_reconfirmacion')!=null){
                      $reconfirmacion->novedad_ejecucion = Input::get('novedad_reconfirmacion');
                  }else{
                      $reconfirmacion->novedad_ejecucion = 'RECONFIRMACION SIN NINGUNA NOVEDAD';
                  }
                  $reconfirmacion->reconfirmado_por = Sentry::getUser()->id;
                  $reconfirmacion->numero_reconfirmaciones = 1;
                  $reconfirmacion->ejecutado = 1;
                  if($reconfirmacion->save()){

                      return Response::json([
                          'respuesta'=>true,
                      ]);

                  }
              }
          }
      }
  }

  public function postNumeroreconfirmaciones(){

      $reconfirmacion = DB::table('reconfirmacion')->where('id_servicio',Input::get('id'))->first();
      return Response::json([
          'respuesta'=>true,
          'reconfirmacion'=>$reconfirmacion
      ]);
  }

  public function postReconfirmar(){

      /* Importante el campo opcion hace referencia a las diferentes vistas de servicios para
         reconfirmacion siendo las posibles opciones los siguientes valores

         option = 1 Para vista de servicios principales
         option = 3 Para vista de servicios y rutas
         option = 4 Para vista de servicios de afiliados externos
      */
      $option = Input::get('option');

      $query = Servicio::select('servicios.id','servicios.hora_servicio','servicios.fecha_servicio','servicios.subcentrodecosto_id','servicios.centrodecosto_id',
               'reconfirmacion.reconfirmacion2hrs','reconfirmacion.reconfirmacion1hrs','reconfirmacion.reconfirmacion30min',
               'reconfirmacion.reconfirmacion_horacita','reconfirmacion.reconfirmacion_ejecucion')
      ->leftJoin('reconfirmacion', 'servicios.id', '=', 'reconfirmacion.id_servicio')
      ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id');

      if($option==1){
        $query->whereNull('servicios.ruta')
        ->whereNull('servicios.afiliado_externo');
      }

      if ($option==3) {
        $query->whereNull('servicios.afiliado_externo');
      }

      if($option==4){
        $query->where('servicios.afiliado_externo', 1);
      }

      $servicios = $query->where('servicios.fecha_servicio',date('Y-m-d'))
      ->whereNull('servicios.pendiente_autori_eliminacion')
      ->where('centrosdecosto.localidad','bogota')
      ->orderBy('servicios.hora_servicio')
      ->get();

      return Response::json([
          'servicios'=>$servicios
      ]);
  }

  public function postNovedad(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          if (Request::ajax()) {

              try{

                  $novedad = new Novedad;
                  $novedad->seleccion_opcion = Input::get('seleccion');
                  $novedad->descripcion = Input::get('descripcion');
                  $novedad->id_reconfirmacion = Input::get('id');
                  $novedad->creado_por = Sentry::getUser()->id;

                  if ($novedad->save()) {

                      return Response::json([
                         'respuesta'=>true,
                      ]);
                  }

              } catch (Exception $e) {

                  return Response::json([
                     'respuesta'=>'error',
                     'e'=>$e
                  ]);

              }
          }
      }
  }

  public function getServiciosporeliminar(){

      if (Sentry::check()) {
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->bogota->poreliminar->ver;
      }else{
        $id_rol = null;
        $permisos = null;
        $permisos = null;
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
              ->leftJoin('users as userelim', 'servicios.usuario_eliminacion', '=', 'userelim.id')
              ->leftJoin('facturacion', 'servicios.id','=','facturacion.servicio_id')
              ->select('servicios.id','servicios.fecha_orden','servicios.fecha_servicio','servicios.finalizado',
                  'facturacion.revisado','facturacion.liquidado','facturacion.facturado','facturacion.factura_id',
                  'servicios.solicitado_por','servicios.resaltar','servicios.pago_directo','servicios.ruta','servicios.motivo_eliminacion',
                  'servicios.fecha_solicitud_eliminacion','usuario_eliminacion',
                  'servicios.fecha_solicitud','servicios.pasajeros_ruta','servicios.ciudad','servicios.recoger_en','servicios.dejar_en',
                  'servicios.detalle_recorrido','servicios.pasajeros','servicios.hora_servicio','servicios.origen','servicios.motivo_eliminacion',
                  'servicios.pendiente_autori_eliminacion',
                  'servicios.destino', 'servicios.aerolinea', 'servicios.vuelo', 'servicios.hora_salida',
                  'servicios.hora_llegada', 'servicios.cancelado','centrosdecosto.razonsocial',
                  'subcentrosdecosto.nombresubcentro','users.first_name','users.last_name',
                  'rutas.nombre_ruta','rutas.codigo_ruta','proveedores.razonsocial AS razonproveedor',
                  'conductores.nombre_completo','conductores.celular','conductores.telefono',
                  'reconfirmacion.numero_reconfirmaciones','reconfirmacion.id as id_reconfirmacion','reconfirmacion.ejecutado',
                  'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo',
                  'servicios_edicion_pivote.id as id_pivote', 'reportes_pivote.id as id_reporte','userelim.first_name as first_name_elim',
                  'userelim.last_name as last_name_elim')
              ->where('servicios.anulado',0)
              ->where('servicios.cancelado',0)
              ->where('centrosdecosto.localidad','bogota')
              ->where('pendiente_autori_eliminacion',1)
              ->orderBy('fecha_solicitud_eliminacion')
              ->get();

          $proveedores = DB::table('proveedores')
              ->where('tipo_servicio','TRANSPORTE TERRESTRE')
              ->where('localidad','bogota')
              ->whereNull('inactivo_total')
              ->orderBy('razonsocial')->get();

          $centrosdecosto = DB::table('centrosdecosto')
              ->whereNull('inactivo_total')
              ->where('localidad','bogota')
              ->orderBy('razonsocial')
              ->get();

          $subcentros = DB::table('subcentrosdecosto')->orderBy('nombresubcentro')->get();
          $departamentos = DB::table('departamento')->get();
          $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
          $rutas = DB::table('rutas')->get();
          $usuarios = DB::table('users')->where('coordinador',1)->where('activated',1)->get();

          return View::make('servicios.servicios_eliminarbog')
              ->with([
                  'servicios'=>$servicios,
                  'centrosdecosto'=>$centrosdecosto,
                  'departamentos'=>$departamentos,
                  'ciudades'=>$ciudades,
                  'proveedores'=>$proveedores,
                  'rutas'=>$rutas,
                  'usuarios'=>$usuarios,
                  'permisos'=>$permisos,
                  'o'=>1
              ]);

      }
  }

  //FINALIZAR SERVICIOS COLOCANDO EL NUMERO DE CONSTANCIA
  public function postTerminarservicio(){

    if (!Sentry::check()){

        return Response::json([
            'respuesta'=>'relogin'
        ]);

    }else{

        if (Request::ajax()) {

          try {

            $numero_constancia = Input::get('numero_constancia');

            $id = Input::get('id');
            $facturacion = new Facturacion();
            $facturacion->numero_planilla = $numero_constancia;
            $facturacion->servicio_id = $id;
            $user = Sentry::findUserById(Sentry::getUser()->id);

            $array = [
              'fecha'=>date('Y-m-d H:i:s'),
              'accion'=>'SERVICIO FINALIZADO CON EL NUMERO DE CONSTANCIA: <span class="bolder">'.$facturacion->numero_planilla.'</span>',
              'realizado_por'=>$user->first_name.' '.$user->last_name
            ];

            $facturacion->cambios_servicio = '['.json_encode($array).']';

            if ($facturacion->save()) {

              $servicio = Servicio::find(Input::get('id'));
              $servicio->finalizado = 1;
              $servicio->save();

              return Response::json([
                'respuesta'=>true
              ]);
            }else{
              return Response::json([
                'respuesta'=>false
              ]);
            }

          }catch (Exception $e){
            return Response::json([
              'respuesta'=>false,
              'e'=>$e
            ]);
          }

        }

      }
  }

  public function getExportarnovedad($id){

      if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{
          $novedades_reconfirmacion = DB::table('novedades_reconfirmacion')
          ->leftJoin('servicios', 'novedades_reconfirmacion.id_reconfirmacion', '=', 'servicios.id')
          ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
          ->leftJoin('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
          ->where('id_reconfirmacion',$id)->first();
          /*$html = View::make('servicios.plantilla_novedad')->with('novedades_reconfirmacion', $novedades_reconfirmacion)->render();*/
          $html = View::make('servicios.plantilla_novedad')->with('novedades_reconfirmacion',$novedades_reconfirmacion);
          return PDF::load($html, 'A4', 'portrait')->download('novedad');

      }
  }

  public function postReporte(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          if (Request::ajax()) {

              $reportes_pivote = DB::table('reportes_pivote')->where('servicio_id',Input::get('id'))->first();

              if ($reportes_pivote!=null) {

                  $reportes = DB::table('reportes')
                  ->insert([
                      'descripcion'=>Input::get('descripcion_reporte'),
                      'reportes_id'=>$reportes_pivote->id,
                      'creado_por'=> Sentry::getUser()->id,
                      'created_at'=>date('Y-m-d H:i:s')
                  ]);

                  if ($reportes!=null) {

                      return Response::json([
                          'respuesta'=>true
                      ]);
                  }

              }else{

                  $id = DB::table('reportes_pivote')
                  ->insertGetId([
                      'servicio_id' => Input::get('id')
                  ]);

                  if ($id!=null) {

                      $reportes = DB::table('reportes')
                      ->insert([
                          'descripcion'=>Input::get('descripcion_reporte'),
                          'reportes_id'=>$id,
                          'creado_por'=> Sentry::getUser()->id,
                          'created_at'=>date('Y-m-d H:i:s')
                      ]);

                      if ($reportes!=null) {

                          return Response::json([
                              'respuesta'=>true
                          ]);
                      }

                  }
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

          Excel::selectSheetsByIndex(0)->load(Input::file('excel'), function($reader){
              $reader->skip(1);
              $result = $reader->noHeading()->get();

              foreach($result as $value){

				$nombre_excel = $value[0];

				$apellidos_excel = $value[1];
                  if(is_string($value[0])){
				$dataExcel[] = [
                     'nombres'=> strtoupper(trim($nombre_excel)),
                     'apellidos'=> strtoupper($apellidos_excel),
                     'cedula'=>$value[2],
                     'direccion'=>strtoupper(trim($value[3])),
                     'barrio'=>strtoupper(trim($value[4])),
                     'cargo'=>strtoupper($value[5]),
                     'area'=>strtoupper($value[6]),
                     'sub_area'=>strtoupper($value[7]),
                     'hora'=>$value[8]
                  ];
				}
              }

              echo $var = json_encode($dataExcel);

          });

      }

  }

  public function postNuevaruta(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          $ruta_id = DB::table('rutas')
              ->where('centrosdecosto_id',Input::get('centrodecosto'))
              ->where('nombre_ruta', 'RUTA EMPRESARIAL')->first();

          $pasajeros = '['.Input::get('pasajeros').']';

          $pax = json_decode($pasajeros);

          $detalleArray = explode(',', Input::get('detalleArray'));
          $proveedorArray = explode(',', Input::get('proveedorArray'));
          $conductorArray = explode(',', Input::get('conductorArray'));
          $vehiculoArray = explode(',', Input::get('vehiculoArray'));
          $recoger_enArray = explode(',', Input::get('recoger_enArray'));
          $dejar_enArray = explode(',', Input::get('dejar_enArray'));
          $horaArray = explode(',', Input::get('horaArray'));

          $nombre_comercial = DB::table('centrosdecosto')->where('id',Input::get('centrodecosto'))->first();

          for($i=0; $i<count($detalleArray); $i++){

              $arraypasajeros = [];

              for ($j=0; $j < count($pax[$i]); $j++) {

                  $array_pax = [
                      'nombres'=>trim($pax[$i][$j]->nombres),
                      'apellidos'=>trim($pax[$i][$j]->apellidos),
                      'cedula'=>$pax[$i][$j]->cedula,
                      'direccion'=>trim($pax[$i][$j]->direccion),
                      'barrio'=>trim($pax[$i][$j]->barrio),
                      'cargo'=>$pax[$i][$j]->cargo,
                      'area'=>$pax[$i][$j]->area,
                      'sub_area'=>$pax[$i][$j]->sub_area,
                      'hora'=>$pax[$i][$j]->hora,
                  ];

                  array_push($arraypasajeros, $array_pax);
              }



              $servicio = new Servicio();
              $servicio->fecha_orden = date('Y-m-d');
              $servicio->centrodecosto_id = Input::get('centrodecosto');
              $servicio->subcentrodecosto_id = Input::get('subcentrodecosto');
              $servicio->pasajeros = $nombre_comercial->nombre_comercial.',,,/';
              $servicio->pasajeros_ruta = json_encode($arraypasajeros);
              $servicio->cantidad = count($arraypasajeros);
              $servicio->departamento = Input::get('departamento');
              $servicio->ciudad = Input::get('ciudad');
              $servicio->solicitado_por = Input::get('solicitado_por');
              $servicio->fecha_solicitud = Input::get('fecha_solicitud');
              $servicio->email_solicitante = null;
              $servicio->estado_email = 0;
              $servicio->ruta_id = $ruta_id->id;
              $servicio->recoger_en = $recoger_enArray[$i];
              $servicio->dejar_en = $dejar_enArray[$i];
              $servicio->detalle_recorrido = $detalleArray[$i];
              $servicio->proveedor_id = $proveedorArray[$i];
              $servicio->conductor_id = $conductorArray[$i];
              $servicio->vehiculo_id = $vehiculoArray[$i];
              $servicio->fecha_servicio = Input::get('fecha_servicio');
              $servicio->hora_servicio = $horaArray[$i];
              $servicio->resaltar = 0;
              $servicio->pago_directo = null;
              $servicio->origen = '';
              $servicio->destino = '';
              $servicio->aerolinea = '';
              $servicio->vuelo = '';
              $servicio->hora_salida = '';
              $servicio->hora_llegada = '';
              $servicio->creado_por = Sentry::getUser()->id;
              $servicio->ruta = 1;
              $servicio->localidad = 1;
              $servicio->aceptado_app = 0;
              $servicio->hora_programado_app = date('Y-m-d H:i:s');
              if(Sentry::getUser()->id_rol == 8){
                $servicio->control_facturacion = 1;
              }
              $servicio->save();

              $number = rand(10000000, 99999999);
              $notifications = Servicio::enviarNotificaciones($conductorArray[$i], Input::get('fecha_servicio'), $horaArray[$i], $recoger_enArray[$i], $dejar_enArray[$i], $number, $servicio->id);

          }

          return Response::json([
              'respuesta'=>true
          ]);

      }

  }

  public function postVerrutapax(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          $servicio = DB::table('servicios')->where('id',Input::get('id'))->pluck('pasajeros_ruta');

          return Response::json([
              'respuesta'=>true,
              'pasajeros'=>$servicio
          ]);
      }
  }

  public function postEditarrutapax(){
        $paws = 1;
        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            $servicio = Servicio::find(Input::get('id'));
            $servicio->pasajeros_ruta = Input::get('pasajeros');

            $json = json_decode(Input::get('pasajeros')); //Lista actualizada de los pasajeros

            //CONSULTA DE LOS USUARIOS ACTUALES DE LA RUTA
            $pasajeros_search = DB::table('qr_rutas')
            ->where('servicio_id', Input::get('id'))
            //->where('subcentrodecosto_id','!=',201920)
            ->get();

            $contador_actual = count($pasajeros_search);
            $cont = 0;
            $cont2 = 0;

            $existentes = 0;
            $nuevos = 0;
            $hola = 0;

            //INSERSIÓN DE NUEVO DE TODOS LOS USUARIOS
            foreach ($json as $data) {

                $cont++;
                $sw = 0;

                foreach($pasajeros_search as $pass){
                    $cont2++;
                    if($data->apellidos == $pass->id_usuario){
                        $sw=1;
                    }
                }

                if($sw==1){
                    $existentes++;
                }else{

                    $code = $data->apellidos;

                    $fecha = $servicio->fecha_servicio;
                    $hora = str_replace(':', '-', $servicio->hora_servicio);
                    $qrcode = $code.$fecha.$hora.$servicio->id.$servicio->conductor_id; //Valor de Código QR - CONCATENACIÓN
                    $placa = DB::table('vehiculos')->where('id',$servicio->vehiculo_id)->pluck('placa');

                    $nuevos++;
                    $qr = new Ruta_qr();
                    $qr->id_usuario = $data->apellidos;  //ID del pasajero
                    $qr->code = $qrcode;
                    $qr->cel = $data->cedula; //Celular del pasajero
                    $qr->address = $data->direccion; //Dirección del pasajero
                    $qr->fullname = $data->nombres; //Nombre completo del pasajero
                    $qr->neighborhood = $data->barrio; //Barrio del pasajero
                    $qr->locality = $data->cargo; //Localidad del pasajero (Si aplica)
                    $qr->fecha = $servicio->fecha_servicio;
                    $qr->hora = $servicio->hora_servicio;
                    $qr->updated_at = date('Y-m-d H:i:s');
                    $qr->servicio_id = Input::get('id');
                    $qr->vehiculo = $placa;
                    $qr->save();

                    $hora = $servicio->hora_servicio;
                    $horaMasTreita = date('H:i',strtotime('+30 minute',strtotime($hora)));

                    if( (date('Y-m-d') < $servicio->fecha_servicio) || (date('Y-m-d') == $servicio->fecha_servicio and date('H:i')<= $horaMasTreita ) ){ // (Si la fecha actual es menor a la fecha del servicio) Ó (la FECHA ACTUAL es igual a la del servicio Y la hora actual es MENOR o IGUAL a la hora del servicio +30mins)

                        if($data->cedula!='' and $data->cedula!=null){ //Si se ingresó el número del pasajero, se envía el mensaje por whatsapp de la ruta

                            /* IMMPORTANTE - Validar si ya fue programado, para envío de mensaje de actualuzación*/

                            //Inicio generación de código QR
                            $qr_code = DNS2D::getBarcodePNG($qrcode, "QRCODE", 10, 10,array(1,1,1), true);
                            Image::make($qr_code)->save('biblioteca_imagenes/qr_codes/'.$qrcode.'.png');
                            //Fin generación de código QR

                            $qr = Crypt::encryptString($qrcode); //Encryptación del valor de QR

                            $number = '57'.$data->cedula; //Concatenación del indicativo con el número
                            $namewaap = explode(" ", $data->nombres); //Obtencíon del primer nombre del usuario

                            $placaVehiculo = DB::table('vehiculos')
                            ->where('id',$servicio->vehiculo_id)
                            ->pluck('placa');

                            $nameConductor = DB::table('conductores')
                            ->where('id',$servicio->conductor_id)
                            ->pluck('nombre_completo');

                            $celConductor = DB::table('conductores')
                            ->where('id',$servicio->conductor_id)
                            ->pluck('celular');

                            $fecha = date('Y-m-d');
                            $manana = strtotime ('+1 day', strtotime($fecha));
                            $manana = date ('Y-m-d' , $manana);

                            if($servicio->fecha_servicio == date('Y-m-d')){
                                $dia = 'HOY';
                            }else if($servicio->fecha_servicio == $manana){
                                $dia = 'MANANA';
                            }else{
                                $dia = $servicio->fecha_servicio;
                            }

                            $number = intval($number);
                            $nombre = $namewaap[0];
                            $hora = $servicio->hora_servicio;
                            $placa = $placaVehiculo;
                            $conductor = $nameConductor;
                            $numero = $celConductor;
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
                                \"name\": \"qr_code\",
                                \"language\": {
                                  \"code\": \"es\",
                                },
                                \"components\": [{
                                  \"type\": \"body\",
                                  \"parameters\": [{
                                    \"type\": \"text\",
                                    \"text\": \"".$nombre."\",
                                  },
                                  {
                                    \"type\": \"text\",
                                    \"text\": \"".$dia."\",
                                  },
                                  {
                                    \"type\": \"text\",
                                    \"text\": \"".$hora."\",
                                  },
                                  {
                                    \"type\": \"text\",
                                    \"text\": \"".$placa."\",
                                  },
                                  {
                                    \"type\": \"text\",
                                    \"text\": \"".$conductor."\",
                                  },
                                  {
                                    \"type\": \"text\",
                                    \"text\": \"".$numero."\",
                                  },
                                  {
                                    \"type\": \"text\",
                                    \"text\": \"3012633878\",
                                  }]
                                },
                                {
                                  \"type\": \"button\",
                                  \"sub_type\": \"url\",
                                  \"index\": \"0\",
                                  \"parameters\": [{
                                    \"type\": \"payload\",
                                    \"payload\": \"".$qr."\"
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


            } //End for each #1

            //Usuarios eliminados

            //Registrar al pasajero como leído cuando la hora de modificación sea posterior a la del servicio
            $eliminados = 0;
            $existentes = 0;
            foreach($pasajeros_search as $pass){
                $switc = 0;
                foreach ($json as $data) {

                    if($data->apellidos == $pass->id_usuario){
                        $switc=1;
                    }

                }

                if($switc == 0){
                    $eliminados++;

                    //Eliminación de la Base de datos QR_RUTAS al pasajero eliminado
                    //ELIMINACION DE LOS USUARIOS DE ESE SERVICIO
                    $eliminar = DB::table('qr_rutas')
                    ->where('servicio_id', Input::get('id'))
                    ->where('id_usuario',$pass->id_usuario)
                    ->delete();

                    if($eliminar){
                        //Envío de mensaje al pasajero

                        $hora = $servicio->hora_servicio;
                        $horaMasTreita = date('H:i',strtotime('+30 minute',strtotime($hora)));

                        if( (date('Y-m-d') < $servicio->fecha_servicio) || (date('Y-m-d') == $servicio->fecha_servicio and date('H:i')<= $horaMasTreita ) ){ // (Si la fecha actual es menor a la fecha del servicio) Ó (la FECHA ACTUAL es igual a la del servicio Y la hora actual es MENOR o IGUAL a la hora del servicio +30mins)

                            if($pass->cel!='' and $pass->cel!=null){ //Si se ingresó el número del pasajero, se envía el mensaje por whatsapp de la eliminacion de ruta

                                $number = '57'.$pass->cel; //Concatenación del indicativo con el número
                                $namewaap = explode(" ", $pass->fullname);

                                $number = intval($number);
                                $nombre = $namewaap[0];
                                $hora = $servicio->hora_servicio;

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
                                    \"name\": \"route_deleteb\",
                                    \"language\": {
                                      \"code\": \"es\",
                                    },
                                    \"components\": [{
                                      \"type\": \"body\",
                                      \"parameters\": [{
                                        \"type\": \"text\",
                                        \"text\": \"".$nombre."\",
                                      },
                                      {
                                        \"type\": \"text\",
                                        \"text\": \"".$servicio->fecha_servicio."\",
                                      },
                                      {
                                        \"type\": \"text\",
                                        \"text\": \"".$servicio->hora_servicio."\",
                                      },
                                      {
                                        \"type\": \"text\",
                                        \"text\": \"3012633878\",
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
                }else{
                    $existentes++;
                }
            }

            if($contador_actual!=$cont and $servicio->fecha_servicio>=date('Y-m-d') and $servicio->hora_servicio>=date('H:i')){

                //Notificar al conductor
            }

            $servicio->cantidad = $cont;

            if ($servicio->save()) {
                return Response::json([
                    'respuesta'=>true,
                    'sw' => $sw,
                    'hola' => $hola,
                    'existentes' => $existentes,
                    'nuevos' => $nuevos,
                    'cont' => $cont,
                    'cont2' => $cont2,
                    'json' => $json,
                    'pasajeros_search' => $pasajeros_search,
                    'eliminados' => $eliminados
                ]);
            }
        }
    }

  /*public function postEditarrutapax(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          $servicio = Servicio::find(Input::get('id'));
          $servicio->pasajeros_ruta = Input::get('pasajeros');

          if ($servicio->save()) {
              return Response::json([
                  'respuesta'=>true
              ]);
          }


      }
  }*/

  public function getExportarpasajerosrutas($id){
      ob_end_clean();
      ob_start();
      Excel::create('Ruta', function($excel) use ($id){

          $excel->sheet('Rutas '.$id, function($sheet) use ($id){

              $servicio = DB::table('servicios')
              ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
              ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
              ->leftJoin('facturacion', 'servicios.id', '=', 'facturacion.servicio_id')
              ->where('servicios.id', $id)->first();

              $sheet->loadView('servicios.plantilla_pasajeros_ruta')
              ->with([
                  'servicio'=>$servicio,
                  'ch_nombre'=>1,
                  'ch_apellido'=>1,
                  'ch_cedula'=>1,
                  'ch_direccion'=>1,
                  'ch_barrio'=>1,
                  'ch_cargo'=>1,
                  'ch_area'=>1,
                  'ch_subarea'=>1,
                  'ch_horario'=>1
              ]);

              $objDrawing = new PHPExcel_Worksheet_Drawing;
              $objDrawing->setPath('biblioteca_imagenes/logos.png');
              $objDrawing->setCoordinates('A2');
              $objDrawing->setResizeProportional(false);
              $objDrawing->setWidth(40);
              $objDrawing->setHeight(30);
              $objDrawing->setWorksheet($sheet);

              $sheet->setFontFamily('Calibri')
                    ->getStyle('A8:K8')->applyFromArray(array(
                        'fill' => array(
                            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'D2D2D2')
                        )
                    ))->getActiveSheet()->getRowDimension('8')->setRowHeight(30);

              $sheet->setStyle(array(
                  'font' => array(
                      'size'      =>  11
                  )
              ));
          });

      })->download('xls');

  }

  public function postExportarrutasfechas(){

    ob_end_clean();
    ob_start();
    Excel::create('rutas', function($excel){

        $excel->sheet('hoja', function($sheet){

            $fecha_inicial = Input::get('md_fecha_inicial');
            $fecha_final = Input::get('md_fecha_final');
            $centrodecosto = Input::get('md_centrodecosto');
            $subcentrodecosto = Input::get('md_subcentrodecosto');

            $servicios = DB::select("select pasajeros_ruta, ruta, fecha_servicio from servicios where servicios.fecha_servicio between '".$fecha_inicial."' and '".$fecha_final."' and ruta = 1 and centrodecosto_id ='".$centrodecosto."' and subcentrodecosto_id = '".$subcentrodecosto."' and pendiente_autori_eliminacion is null order by fecha_servicio");

            $sheet->loadView('servicios.plantilla_pasajeros_total')
            ->with([
                'servicios'=>$servicios
            ]);
        });
    })->download('xls');
  }

  public function postExportarrutasdia(){

    if (!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else{

        $fecha = Input::get('md_fecha_inicial');
        $centrodecosto = Input::get('md_centrodecosto');
        $subcentrodecosto = Input::get('md_subcentrodecosto');

        if ($centrodecosto==='-' or $subcentrodecosto==='-') {

            return Redirect::to('transportes');

        }else{

            ob_end_clean();
            ob_start();
            Excel::create('ruta_dia'.$fecha, function($excel) use ($centrodecosto, $subcentrodecosto, $fecha){

                if (Input::get('ch_nombre')) {
                  $ch_nombre = Input::get('ch_nombre');
                }else{
                  $ch_nombre = null;
                }

                if (Input::get('ch_apellido')) {
                  $ch_apellido = Input::get('ch_apellido');
                }else{
                  $ch_apellido = null;
                }

                if (Input::get('ch_cedula')) {
                  $ch_cedula = Input::get('ch_cedula');
                }else{
                  $ch_cedula = null;
                }

                if (Input::get('ch_direccion')) {
                  $ch_direccion = Input::get('ch_direccion');
                }else{
                  $ch_direccion = null;
                }

                if (Input::get('ch_barrio')) {
                  $ch_barrio = Input::get('ch_barrio');
                }else{
                  $ch_barrio = null;
                }

                if (Input::get('ch_cargo')) {
                  $ch_cargo = Input::get('ch_cargo');
                }else{
                  $ch_cargo = null;
                }

                if (Input::get('ch_area')) {
                  $ch_area = Input::get('ch_area');
                }else{
                  $ch_area = null;
                }

                if (Input::get('ch_area')) {
                  $ch_subarea = Input::get('ch_subarea');
                }else{
                  $ch_subarea = null;
                }

                if (Input::get('ch_horario')) {
                  $ch_horario = Input::get('ch_horario');
                }else{
                  $ch_horario = null;
                }

                if (Input::get('ch_embarcado')) {
                    $ch_embarcado = Input::get('ch_embarcado');
                }else{
                    $ch_embarcado = null;
                }

                if (Input::get('ch_no_embarcado')) {
                    $ch_no_embarcado = Input::get('ch_no_embarcado');
                }else{
                    $ch_no_embarcado = null;
                }

                if (Input::get('ch_autorizado')) {
                    $ch_autorizado = Input::get('ch_autorizado');
                }else{
                    $ch_autorizado = null;
                }

                if (Input::get('ch_firma')) {
                    $ch_firma = Input::get('ch_firma');
                }else{
                    $ch_firma = null;
                }

                $consulta = "select servicios.fecha_servicio, servicios.hora_servicio, detalle_recorrido, servicios.ruta, servicios.pasajeros_ruta, ".
                            "conductores.nombre_completo, centrosdecosto.razonsocial, facturacion.numero_planilla from servicios ".
                            "left join conductores on servicios.conductor_id = conductores.id ".
                            "left join facturacion on servicios.id = facturacion.servicio_id ".
                            "left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id ".
                            "where servicios.ruta = 1 and servicios.centrodecosto_id =".$centrodecosto." and servicios.subcentrodecosto_id = ".$subcentrodecosto." and servicios.fecha_servicio = '".$fecha."' and pendiente_autori_eliminacion is null order by servicios.detalle_recorrido";

                $servicios = DB::select($consulta);

                foreach ($servicios as $servicio) {

                    $range = '';
                    $contador = 1;

                    $excel->sheet($servicio->detalle_recorrido, function($sheet) use
                    ($servicio, $ch_nombre, $ch_apellido, $ch_cedula, $ch_direccion, $ch_barrio, $ch_cargo, $ch_area, $ch_subarea, $ch_horario,
                                $ch_embarcado, $ch_no_embarcado, $ch_autorizado, $ch_firma, $contador, $range){

                        $array = [
                          'servicio'=>$servicio,
                          'ch_nombre'=>$ch_nombre,
                          'ch_apellido'=>$ch_apellido,
                          'ch_cedula'=>$ch_cedula,
                          'ch_direccion'=>$ch_direccion,
                          'ch_barrio'=>$ch_barrio,
                          'ch_cargo'=>$ch_cargo,
                          'ch_area'=>$ch_area,
                          'ch_subarea'=>$ch_subarea,
                          'ch_horario'=>$ch_horario,
                          'ch_embarcado'=>$ch_embarcado,
                          'ch_no_embarcado'=>$ch_no_embarcado,
                          'ch_autorizado'=>$ch_autorizado,
                          'ch_firma'=>$ch_firma
                        ];

                        $objDrawing = new PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath('biblioteca_imagenes/logos.png');
                        $objDrawing->setCoordinates('A2');
                        $objDrawing->setResizeProportional(false);
                        $objDrawing->setWidth(40);
                        $objDrawing->setHeight(30);
                        $objDrawing->setWorksheet($sheet);

                        if ($ch_nombre!=null) {
                          $contador++;
                        }
                        if ($ch_apellido!=null) {
                          $contador++;
                        }
                        if ($ch_cedula!=null) {
                          $contador++;
                        }
                        if ($ch_direccion!=null) {
                          $contador++;
                        }
                        if ($ch_barrio!=null) {
                          $contador++;
                        }
                        if ($ch_cargo!=null) {
                          $contador++;
                        }
                        if ($ch_area!=null) {
                          $contador++;
                        }
                        if ($ch_subarea!=null) {
                          $contador++;
                        }
                        if ($ch_horario!=null) {
                          $contador++;
                        }
                        if ($ch_embarcado!=null) {
                            $contador++;
                        }
                        if ($ch_no_embarcado!=null) {
                            $contador++;
                        }
                        if ($ch_autorizado!=null) {
                            $contador++;
                        }

                        if ($contador===2) {
                          $range = $range.':C8';
                        }
                        if ($contador===3) {
                          $range .= ':D8';
                        }
                        if ($contador===4) {
                          $range .= ':E8';
                        }
                        if ($contador===5) {
                          $range .= ':F8';
                        }
                        if ($contador===6) {
                          $range .= ':G8';
                        }
                        if ($contador===7) {
                          $range .= ':H8';

                          $borders = array(
                            'borders' => array(
                              'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                              )
                            )

                          );

                        }
                        if ($contador===8) {
                          $range .= ':I8';
                        }
                        if ($contador===9) {
                          $range .= ':J8';
                        }
                        if ($contador===10) {
                          $range .= ':K8';
                        }
                        if ($contador===11) {
                            $range .= ':L8';
                        }
                        if ($contador===12) {
                            $range .= ':M8';
                        }
                        if ($contador===13) {
                            $range .= ':N8';
                        }

                        $sheet->getStyle('A8'.$range)->applyFromArray(array(
                                  'fill' => array(
                                      'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                                      'color' => array('rgb' => 'D2D2D2')
                                  )
                        ))->getActiveSheet()->getRowDimension('8')->setRowHeight(30);

                        /*$sheet->cells('A1:A50', function($cells) {

                            $cells->setFont(array(
                                'family'     => 'Verdana',
                                'size'       => '50',
                                'bold'       =>  true
                            ));

                        });*/


                        $contador++;

                        $sheet->loadView('servicios.plantilla_pasajeros_ruta')
                            ->with($array);
                    });
                }

            })->download('xls');

        }

    }

  }

  public function postExportarlistadodia(){

      if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

          $fecha = Input::get('md_fecha_inicial');
          $centrodecosto = Input::get('md_centrodecosto');
          $subcentrodecosto = Input::get('md_subcentrodecosto');

          if ($centrodecosto==='-' or $subcentrodecosto==='-') {

              return Redirect::to('transportes');

          }else{

              ob_end_clean();
              ob_start();
              Excel::create('Listado Dia '.$fecha, function($excel) use ($centrodecosto, $subcentrodecosto, $fecha){

                  $excel->sheet('hoja', function($sheet) use ($centrodecosto, $subcentrodecosto, $fecha){

                      $consulta = "select * from servicios where centrodecosto_id = ".$centrodecosto." and subcentrodecosto_id = ".$subcentrodecosto." and ruta = 1 and fecha_servicio ='".$fecha."' and pendiente_autori_eliminacion is null";
                      $servicios = DB::select($consulta);

                      $sheet->loadView('servicios.plantillalistadodia')
                      ->with([
                          'servicios'=>$servicios
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

  public function postBuscarpapelera(){


    if (!Sentry::check()){

        return Response::json([
            'respuesta'=>'relogin'
        ]);

    }else{

      if (Request::ajax()) {

        //ASIGNACION DE VARIABLES
        $fecha_inicial = Input::get('fecha_inicial');
        $fecha_final = Input::get('fecha_final');
        $fecha_eliminacion = Input::get('fecha_eliminacion');
        $proveedor = intval(Input::get('proveedores'));
        $conductor = intval(Input::get('conductores'));
        $centrodecosto = intval(Input::get('centrodecosto'));
        $subcentrodecosto = intval(Input::get('subcentrodecosto'));
        $ciudades = Input::get('ciudades');

        if ($ciudades==='CIUDADES') {
          $nciudad = null;
        }else{
          $nciudad = $ciudades;
        }

        if ($subcentrodecosto===0 or $subcentrodecosto==='-') {
          $nsubcentrodecosto = null;
        }else{
          $nsubcentrodecosto = DB::table('subcentrosdecosto')->where('id',$subcentrodecosto)->pluck('nombresubcentro');
        }

        $nproveedor = DB::table('proveedores')->where('id',$proveedor)->pluck('razonsocial');

        if ($conductor===0 or $conductor==='-') {
          $nconductor = null;
        }else{
          $nconductor = DB::table('conductores')->where('id',$conductor)->pluck('nombre_completo');
        }

        if ($centrodecosto===0) {
            $ncentrodecosto = null;
        }else{
            $ncentrodecosto = DB::table('centrosdecosto')->where('id',$centrodecosto)->pluck('razonsocial');
        }

        $j = 0;

        //BUSQUEDA GENERAL EN LA TABLA

        if ($fecha_eliminacion!=''):

            $arrayPapelera = [];

            $papelera = DB::table('papelera')
                ->leftJoin('users', 'papelera.eliminado_por', '=', 'users.id')
                ->whereBetween('fecha_eliminacion', [$fecha_eliminacion.' 00:00:00',$fecha_eliminacion.' 23:59:59'])
                ->get();

            foreach ($papelera as $pal) :

                //INICIALIZACION DE VARIABLE EN CERO
                $json = '';
                //SI EL LOS VALORES NO ESTAN VACIOS

                if ($pal->informacion!='null') :

                    //DECODIFICAR JSON Y OBTENER EL CAMPO DE INFORMACION
                    $json = json_decode($pal->informacion);

                    //SI LA FECHA DE EL JSON ES IGUAL A LA FECHA INICIAL


                        $array = [
                            'id' => $json->id,
                            'fecha_orden' => $json->fecha_orden,
                            'fecha_servicio' => $json->fecha_servicio,
                            'solicitado_por' => $json->solicitado_por,
                            'fecha_solicitud' => $json->fecha_solicitud,
                            'ciudad' => $json->ciudad,
                            'recoger_en' => $json->recoger_en,
                            'dejar_en' => $json->dejar_en,
                            'detalle_recorrido' => $json->detalle_recorrido,
                            'pasajeros' => $json->pasajeros,
                            'hora_servicio' => $json->hora_servicio,
                            'origen' => $json->origen,
                            'destino' => $json->destino,
                            'aerolinea' => $json->aerolinea,
                            'vuelo' => $json->vuelo,
                            'hora_salida' => $json->hora_salida,
                            'hora_llegada' => $json->hora_llegada,
                            'razonsocial' => $json->razonsocial,
                            'nombresubcentro' => $json->nombresubcentro,
                            'first_name' => $json->first_name,
                            'last_name' => $json->last_name,
                            'nombre_ruta' => $json->nombre_ruta,
                            'codigo_ruta' => $json->codigo_ruta,
                            'razonproveedor' => $json->razonproveedor,
                            'nombre_completo' => $json->nombre_completo,
                            'celular' => $json->celular,
                            'telefono' => $json->telefono,
                            'placa' => $json->placa,
                            'clase' => $json->clase,
                            'marca' => $json->marca,
                            'modelo' => $json->modelo,
                            'motivo_eliminacion' => $pal->motivo_eliminacion,
                            'eliminado_por' => $pal->eliminado_por,
                            'fecha_eliminacion' => $pal->fecha_eliminacion,
                            'pnombre' => $pal->first_name,
                            'papellido' => $pal->last_name

                        ];

                        array_push($arrayPapelera, $array);


                endif;
            endforeach;

        else:

            $arrayPapelera = [];

            $papelera = DB::table('papelera')
                ->leftJoin('users', 'papelera.eliminado_por', '=', 'users.id')
                ->get();

            //FUNCION PARA CONOCER LA CANTIDAD DE DIAS ENTRE FECHAS PARA REALIZAR EL FOREACH Y LA BUSQUEDA DE LOS SERVICIOS
            function dias_transcurridos($fecha_i,$fecha_f){
                $dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
                $dias = abs($dias);
                $dias = floor($dias);
                return $dias;
            }

            //CANTIDAD DE DIAS TRANSCURRIDOS ENTRE FECHAS
            $dias_transcurridos = strval(dias_transcurridos($fecha_inicial,$fecha_final));

            if ($dias_transcurridos===0) {
                $dias_transcurridos = 1;
            }

            //FOR CON LA CANTIDAD DE DIAS TRANSCURRIDOS ENTRE FECHAS
            for ($i=0; $i < $dias_transcurridos+1; $i++) {

                foreach ($papelera as $pal) {

                    //INICIALIZACION DE VARIABLE EN CERO
                    $json = '';
                    //SI EL LOS VALORES NO ESTAN VACIOS

                    if ($pal->informacion!='null') {

                        //DECODIFICAR JSON Y OBTENER EL CAMPO DE INFORMACION
                        $json = json_decode($pal->informacion);

                        //SI LA FECHA DE EL JSON ES IGUAL A LA FECHA INICIAL
                        if ($json->fecha_servicio===$fecha_inicial) {

                            $array = [

                                'id'=>$json->id,
                                'fecha_orden'=>$json->fecha_orden,
                                'fecha_servicio'=>$json->fecha_servicio,
                                'solicitado_por'=>$json->solicitado_por,
                                'fecha_solicitud'=>$json->fecha_solicitud,
                                'ciudad'=>$json->ciudad,
                                'recoger_en'=>$json->recoger_en,
                                'dejar_en'=>$json->dejar_en,
                                'detalle_recorrido'=>$json->detalle_recorrido,
                                'pasajeros'=>$json->pasajeros,
                                'hora_servicio'=>$json->hora_servicio,
                                'origen'=>$json->origen,
                                'destino'=>$json->destino,
                                'aerolinea'=>$json->aerolinea,
                                'vuelo'=>$json->vuelo,
                                'hora_salida'=>$json->hora_salida,
                                'hora_llegada'=>$json->hora_llegada,
                                'razonsocial'=>$json->razonsocial,
                                'nombresubcentro'=>$json->nombresubcentro,
                                'first_name'=>$json->first_name,
                                'last_name'=>$json->last_name,
                                'nombre_ruta'=>$json->nombre_ruta,
                                'codigo_ruta'=>$json->codigo_ruta,
                                'razonproveedor'=>$json->razonproveedor,
                                'nombre_completo'=>$json->nombre_completo,
                                'celular'=>$json->celular,
                                'telefono'=>$json->telefono,
                                'placa'=>$json->placa,
                                'clase'=>$json->clase,
                                'marca'=>$json->marca,
                                'modelo'=>$json->modelo,
                                'motivo_eliminacion'=>$pal->motivo_eliminacion,
                                'eliminado_por'=>$pal->eliminado_por,
                                'fecha_eliminacion'=>$pal->fecha_eliminacion,
                                'pnombre'=>$pal->first_name,
                                'papellido'=>$pal->last_name

                            ];

                            if ($nproveedor!=null or $nconductor!=null or $ncentrodecosto!=null or $nsubcentrodecosto!=null or $nciudad!=null) {

                                if ($nproveedor===$json->razonproveedor and $nconductor===$json->nombre_completo and $ncentrodecosto===$json->razonsocial
                                    and $nsubcentrodecosto===$json->nombresubcentro and $nciudad===$json->ciudad) {

                                    array_push($arrayPapelera,$array);

                                }else if ($nproveedor===$json->razonproveedor and $nconductor===$json->nombre_completo and $ncentrodecosto===$json->razonsocial
                                    and $nsubcentrodecosto===$json->nombresubcentro and $nciudad===null) {
                                    array_push($arrayPapelera,$array);
                                }else if ($nproveedor===$json->razonproveedor and $nconductor===$json->nombre_completo and $ncentrodecosto===$json->razonsocial
                                    and $nsubcentrodecosto===null and $nciudad===null) {
                                    array_push($arrayPapelera,$array);
                                }else if ($nproveedor===$json->razonproveedor and $nconductor===$json->nombre_completo and $ncentrodecosto===null
                                    and $nsubcentrodecosto===null and $nciudad===null) {
                                    array_push($arrayPapelera,$array);
                                }else if ($nproveedor===$json->razonproveedor and $nconductor===null and $ncentrodecosto===null
                                    and $nsubcentrodecosto===null and $nciudad===null) {
                                    array_push($arrayPapelera,$array);
                                }else if ($nproveedor===null and $nconductor===null and $ncentrodecosto===null
                                    and $nsubcentrodecosto===null and $nciudad===$json->ciudad) {
                                    array_push($arrayPapelera,$array);
                                }else if ($nproveedor===null and $nconductor===null and $ncentrodecosto===$json->razonsocial
                                    and $nsubcentrodecosto===null and $nciudad===$json->ciudad) {
                                    array_push($arrayPapelera,$array);
                                }else if ($nproveedor===null and $nconductor===null and $ncentrodecosto===$json->razonsocial
                                    and $nsubcentrodecosto===$json->nombresubcentro and $nciudad===$json->ciudad) {
                                    array_push($arrayPapelera,$array);
                                }else if ($nproveedor===$json->razonproveedor and $nconductor===null and $ncentrodecosto===$json->razonsocial
                                    and $nsubcentrodecosto===$json->nombresubcentro and $nciudad===$json->ciudad) {
                                    array_push($arrayPapelera,$array);
                                }else if ($nproveedor===$json->razonproveedor and $nconductor===null and $ncentrodecosto===$json->razonsocial
                                    and $nsubcentrodecosto===$json->nombresubcentro and $nciudad===$json->ciudad) {
                                    array_push($arrayPapelera,$array);
                                }else if ($nproveedor===$json->razonproveedor and $nconductor===null and $ncentrodecosto===null
                                    and $nsubcentrodecosto===null and $nciudad===$json->ciudad) {
                                    array_push($arrayPapelera,$array);
                                }else if ($nproveedor===$json->razonproveedor and $nconductor===$json->nombre_completo and $ncentrodecosto===null
                                    and $nsubcentrodecosto===null and $nciudad===$json->ciudad) {
                                    array_push($arrayPapelera,$array);
                                }else if ($nproveedor===$json->razonproveedor and $nconductor===$json->nombre_completo and $ncentrodecosto===$json->razonsocial
                                    and $nsubcentrodecosto===null and $nciudad===$json->ciudad) {
                                    array_push($arrayPapelera,$array);
                                }else if ($nproveedor===null and $nconductor===null and $ncentrodecosto===$json->razonsocial
                                    and $nsubcentrodecosto===null and $nciudad===null) {
                                    array_push($arrayPapelera,$array);
                                }else if ($nproveedor===$json->razonproveedor and $nconductor===null and $ncentrodecosto===$json->razonsocial
                                    and $nsubcentrodecosto===null and $nciudad===$json->ciudad) {
                                    array_push($arrayPapelera,$array);
                                }else if ($nproveedor===$json->razonproveedor and $nconductor===null and $ncentrodecosto===$json->razonsocial
                                    and $nsubcentrodecosto===null and $nciudad===null) {
                                    array_push($arrayPapelera,$array);
                                }

                            }else{

                                array_push($arrayPapelera,$array);
                            }

                            $j++;

                        }
                    }
                }

                $fecha_inicial = strtotime ('+'.strval(1).' day',strtotime($fecha_inicial));
                $fecha_inicial = date ('Y-m-d', $fecha_inicial);

            }
        endif;


        return Response::json([
          'respuesta'=>true,
          'arrayPapelera'=>$arrayPapelera,
          'papelera'=>$papelera,
          'servicios'=>$j
        ]);
      }

    }

  }

	public function postValidarpdf(){
		if(Request::ajax()){
			#VALIDACION PARA IMAGENES
			$validaciones = [
				'solicitud_pdf' => 'mimes:pdf',
				'correo_pdf' => 'mimes:pdf'
			];
			#MENSAJE DE VALIDACION
			$mensajes = [
				'solicitud_pdf.mimes'=>'El archivo adjunto en Formato Solicitud debe ser formato PDF',
				'correo_pdf.mimes'=>'El archivo adjunto en Correo AUtorizado debe ser formato PDF'
			];
			#CLASE PARA VALIDAR
			$validador = Validator::make(Input::all(), $validaciones,$mensajes);

			#SI LA VALICION FALLA
			if ($validador->fails()){

				return Response::json([
					'mensaje'=>false,
					'errores'=>$validador->errors()->getMessages()
				]);

			}else{
					if (Input::hasFile('solicitud_pdf') && Input::hasFile('correo_pdf')){
						$file1 = Input::file('solicitud_pdf');
						$file2 = Input::file('correo_pdf');

						return Response::json([
                                'respuesta'=>true,
								'mensaje'=>'OK'
                            ]);

					}else {
                        return Response::json([
                            'respuesta'=>false,
							'errores'=>$validador->errors()->getMessages()
                        ]);
                    }

				}
		}

	}

	public function postSavepdfservicio(){

		$id_serv = explode(',', Input::get('servicio_id'));
		//$id_serv = Input::get('servicio_id');
		$cant_ser = count($id_serv);

			if (Input::hasFile('solicitud_pdf') && Input::hasFile('correo_pdf')){
				//$id_serv = $servicio->id;

				$servicio_pdf1 = Input::file('solicitud_pdf');
				$servicio_pdf2 = Input::file('correo_pdf');


				$name_pdf1 = str_replace(' ', '', $servicio_pdf1->getClientOriginalName());
				$name_pdf2 = str_replace(' ', '', $servicio_pdf2->getClientOriginalName());
				$ubicacion_servicios = 'biblioteca_imagenes/servicios_autorizados/';

				$nombre_pdf2_old = 'na.pdf';
				for($i=0; $i<$cant_ser; $i++){
					$nombre_pdf1 = $id_serv[$i].'_solicitud_'.$name_pdf1;
					$nombre_pdf2 = $id_serv[$i].'_correo_'.$name_pdf2;
					if($i=== 0){
						$servicio_pdf1->move($ubicacion_servicios, $nombre_pdf1);
						$servicio_pdf2->move($ubicacion_servicios, $nombre_pdf2);

						$servicio_autorizado = new Servicioautorizados();
						$servicio_autorizado->servicio_id = $id_serv[$i];
						$servicio_autorizado->documento_pdf1 = $nombre_pdf1;
						$servicio_autorizado->documento_pdf2 = $nombre_pdf2;
						$servicio_autorizado->agregado_por = Sentry::getUser()->id;
						$servicio_autorizado->save();

						$nombre_pdf1_old = $nombre_pdf1;
						$nombre_pdf2_old = $nombre_pdf2;
					}

					if($i != 0){
						$servicio_autorizado = new Servicioautorizados();
						$servicio_autorizado->servicio_id = $id_serv[$i];
						$servicio_autorizado->documento_pdf1 = $nombre_pdf1_old;
						$servicio_autorizado->documento_pdf2 = $nombre_pdf2_old;
						$servicio_autorizado->agregado_por = Sentry::getUser()->id;
						$servicio_autorizado->save();

					}


				}

				return Response::json([
					'respuesta'=>true,
					'mensaje'=>'OK'
				]);

			}else{
					return Response::json([
						'respuesta'=>'no_pdf'
					]);

			}


	}

	public function postRecibirpagodirect(){
		if (!Sentry::check()){
				return Response::json([
					'mensaje'=>'relogin'
				]);
		}else{
			$id_serv = Input::get('id_serv');

			if (Request::ajax()) {
				$update_serv_pago = Servicio::find($id_serv);
				$update_serv_pago->pago_directo = '2';
				$update_serv_pago->fecha_pago_directo = date('Y-m-d H:i:s');

				if($update_serv_pago->save()){
					return Response::json([
						'mensaje'=>true
					]);
				}else{
						return Response::json([
							'mensaje'=>false
						]);
				}
			}
		}
	}

  public function postServicioruta(){

    $servicio_id = Input::get('id');

    $servicio = Servicio::find($servicio_id);

    if($servicio->ruta!=null){
      $usuarios = DB::table('qr_rutas')->where('servicio_id',$servicio->id)->get();
    }else{
      $usuarios = null;
    }

    if ($servicio) {
      return Response::json([
          'respuesta' => true,
          'servicio'=> $servicio,
          'usuarios' => $usuarios
      ]);
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
        $servicio = DB::table('servicios')->where('id', $id)->pluck('recorrido_gps');
        $estado = DB::table('servicios')->where('id', $id)->pluck('estado_servicio_app');
        $finalizado = DB::table('servicios')->where('id', $id)->pluck('hora_finalizado');
        $recoger = DB::table('servicios')->where('id', $id)->pluck('recoger_pasajero');
        $codigo = DB::table('servicios')->where('id', $id)->pluck('notificaciones_reconfirmacion');

        if ($servicio) {
          return Response::json([
              'servicio' => $servicio,
              'respuesta' => true,
              'estado' => $estado,
              'finalizado' => $finalizado,
              'recoger' => $recoger,
              'codigo' => $codigo
          ]);
        }

      }

    }

  }

  public function postEnviarnotificacion(){

    $servicio = Servicio::where('id', Input::get('id'))->with(['centrodecosto'])->first();

    $message = 'Se le ha asignado un servicio para el dia: '.$servicio->fecha_servicio.', hora: '.$servicio->hora_servicio.', recoger en: '.$servicio->recoger_en.', dejar en: '.$servicio->dejar_en.' para '.$servicio->centrodecosto->razonsocial;
    return Servicio::Notificaciones($message, $servicio->conductor->id);

  }

	public function getServicioseditados(){

        if (Sentry::check()) {
    			$id_rol = Sentry::getUser()->id_rol;
    			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
    			$permisos = json_decode($permisos);
	        $ver = $permisos->bogota->poreliminar->ver;
        }else{
  			  $id_rol = null;
  			  $permisos = null;
  			  $permisos = null;
  			  $ver = null;
        }

        if (!Sentry::check()){
            $messageFalse = '<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero';
            return Redirect::to('/')->with('mensaje', $messageFalse);
        }else if($ver!='on') {
            return View::make('admin.permisos');
        }else{

            $servicios = DB::table('servicios_editados')
				        ->join('servicios', 'servicios_editados.id_servicio', '=', 'servicios.id')
                ->leftJoin('servicios_edicion_pivote', 'servicios.id', '=', 'servicios_edicion_pivote.servicios_id')
                ->leftJoin('reportes_pivote', 'servicios.id', '=', 'reportes_pivote.servicio_id')
                ->leftJoin('rutas', 'servicios_editados.ruta_id', '=', 'rutas.id')
                ->leftJoin('reconfirmacion', 'servicios.id', '=', 'reconfirmacion.id_servicio')
                ->leftJoin('proveedores', 'servicios_editados.proveedor_id', '=', 'proveedores.id')
                ->leftJoin('conductores', 'servicios_editados.conductor_id', '=', 'conductores.id')
                ->LeftJoin('vehiculos', 'servicios_editados.vehiculo_id', '=', 'vehiculos.id')
                ->leftJoin('centrosdecosto', 'servicios_editados.centrodecosto_id', '=', 'centrosdecosto.id')
                ->leftJoin('subcentrosdecosto', 'servicios_editados.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
                ->leftJoin('users', 'servicios.creado_por', '=', 'users.id')
                ->leftJoin('users as userelim', 'servicios.usuario_eliminacion', '=', 'userelim.id')
                ->leftJoin('facturacion', 'servicios.id','=','facturacion.servicio_id')
                ->select('servicios_editados.id AS id_edit','servicios.id','servicios.fecha_orden','servicios.fecha_servicio','servicios.finalizado','servicios_editados.cambios',
                    'facturacion.revisado','facturacion.liquidado','facturacion.facturado','facturacion.factura_id',
                    'servicios_editados.solicitado_por','servicios_editados.resaltar','servicios_editados.pago_directo','servicios_editados.ruta','servicios.motivo_eliminacion', 'servicios.fecha_solicitud_eliminacion','servicios.usuario_eliminacion', 'servicios.fecha_solicitud','servicios_editados.pasajeros_ruta','servicios_editados.ciudad','servicios_editados.recoger_en','servicios_editados.dejar_en',
                    'servicios_editados.detalle_recorrido','servicios_editados.pasajeros','servicios_editados.hora_servicio','servicios_editados.origen','servicios.motivo_eliminacion','servicios.pendiente_autori_eliminacion',
                    'servicios_editados.destino', 'servicios_editados.aerolinea', 'servicios_editados.vuelo', 'servicios_editados.hora_salida',
                    'servicios_editados.hora_llegada', 'servicios.cancelado','centrosdecosto.razonsocial',
                    'subcentrosdecosto.nombresubcentro','users.first_name','users.last_name',
                    'rutas.nombre_ruta','rutas.codigo_ruta','proveedores.razonsocial AS razonproveedor',
                    'conductores.nombre_completo','conductores.celular','conductores.telefono',
                    'reconfirmacion.numero_reconfirmaciones','reconfirmacion.id as id_reconfirmacion','reconfirmacion.ejecutado',
                    'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo',
                    'servicios_edicion_pivote.id as id_pivote', 'reportes_pivote.id as id_reporte','userelim.first_name as first_name_elim',
                    'userelim.last_name as last_name_elim')
                ->whereNull('servicios_editados.autorizado')
                //->where('fecha_servicio',date('Y-m-d'))
                //->where('centrosdecosto.localidad','bogota')
                ->where('servicios.localidad',1)
                ->orderBy('servicios_editados.id', 'desc')
                ->get();

            $proveedores = DB::table('proveedores')
                ->where('tipo_servicio','TRANSPORTE TERRESTRE')
                ->whereNull('inactivo_total')
                ->orderBy('razonsocial')->get();

            $centrosdecosto = DB::table('centrosdecosto')
                ->whereNull('inactivo_total')
                ->orderBy('razonsocial')
                ->get();

            $subcentros = DB::table('subcentrosdecosto')->orderBy('nombresubcentro')->get();
            $departamentos = DB::table('departamento')->get();
            $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
            $rutas = DB::table('rutas')->get();
            $usuarios = DB::table('users')->where('coordinador',1)->where('activated',1)->get();

            return View::make('servicios.servicios_editadosbog')
                ->with([
                    'servicios'=>$servicios,
                    'centrosdecosto'=>$centrosdecosto,
                    'departamentos'=>$departamentos,
                    'ciudades'=>$ciudades,
                    'proveedores'=>$proveedores,
                    'rutas'=>$rutas,
                    'usuarios'=>$usuarios,
                    'permisos'=>$permisos,
                    'o'=>1
                ]);

        }
    }

	public function postAutorizareditarservicio(){

    if (!Sentry::check()){

      return Response::json([
          'respuesta'=>'relogin'
      ]);

    }else{

      if (Request::ajax()) {

        $cambios = '';

        //Validaciones
        $validaciones = [
            'centrodecosto_id' => 'required|numeric',
            'subcentrodecosto_id' => 'required|numeric',
            'solicitado_por' => 'required',
            'departamento' => 'required|select',
            'ciudad' => 'required|select',
            'ruta_id' => 'required|min:1|numeric',
            'recoger_en' => 'required',
            'dejar_en' => 'required',
            'detalle_recorrido' => 'required',
            'proveedor_id' => 'required|numeric',
            'conductor_id' => 'required|numeric',
            'vehiculo_id' => 'required|numeric',
            'fecha_servicio' => 'required|date_format:Y-m-d',
            'hora_servicio' => 'required|date_format:H:m',
            'resaltar' => 'required|numeric',
            'pago_directo' => 'required|numeric',
            'firma' => 'required|numeric',
            'notificacion' => 'required|numeric'
        ];

        //VALIDACIONES
        $mensajes = [
            'centrodecosto_id.numeric' => 'Debe seleccionar un centro de costo',
            'subcentrodecosto_id.numeric' => 'Debe seleccionar un subcentro de costo',
            'departamento.select' => 'Debe seleccionar un departamento',
            'ciudad.select' => 'Debe seleccionar una ciudad',
            'ruta_id.required' => 'Debe seleccionar una ruta',
            'ruta_id.numeric' => 'Debe seleccionar una ruta',
            'proveedor_id.numeric' => 'Debe seleccionar un proveedor',
            'resaltar.numeric' => 'Debe seleccionar la opcion resaltar',
            'pago_directo.numeric' => 'Debe seleccionar la opcion pago_directo',
            'notificacion.numeric' => 'Debe seleccionar la opcion notificacion',
            'firma.numeric' => 'Debe seleccionar la opcion firma',
            'notificacion.required' => 'Debe seleccionar la opcion notificacion'
        ];
        //VALIDADOR
        $validador = Validator::make(Input::all(), $validaciones, $mensajes);

        //SI EL VALIDADOR FALLA ENTONCES ENVIA RESPUESTA DE ERROR CON UN ARRAY DE ERROR
        if ($validador->fails()){

            return Response::json([
                'respuesta'=>false,
                'errores'=>$validador->errors()->getMessages()
            ]);

        }else {

          $pasajeros = [];
          $pasajeros_todos='';
          $nombres_pasajeros='';
          $celulares_pasajeros='';

          $nombre_pasajeros = explode(',', Input::get('nombres_pasajeros_editar'));
          $celular_pasajeros = explode(',', Input::get('celular_pasajeros_editar'));
          $nivel_pasajeros = explode(',', Input::get('nivel_pasajeros_editar'));
          $email_pasajeros = explode(',', Input::get('email_pasajeros_editar'));

          //CONCATENACION DE TODOS LOS DATOS
          for($i=0; $i<count($nombre_pasajeros); $i++){

            $pasajeros[$i] = $nombre_pasajeros[$i].','.$celular_pasajeros[$i].','.$nivel_pasajeros[$i].','.$email_pasajeros[$i].'/';
            $pasajeros_nombres[$i] = $nombre_pasajeros[$i].',';
            $pasajeros_telefonos[$i] = $celular_pasajeros[$i].',';
            $pasajeros_todos = $pasajeros_todos.$pasajeros[$i];
            $nombres_pasajeros = $nombres_pasajeros.$pasajeros_nombres[$i];
            $celulares_pasajeros = $celulares_pasajeros.$pasajeros_telefonos[$i];

          }

          $consulta = "SELECT * FROM liquidacion_servicios WHERE '".Input::get('fecha_servicio')."' BETWEEN fecha_inicial AND fecha_final and centrodecosto_id = '".Input::get('centrodecosto_id')."' and subcentrodecosto_id = '".Input::get('subcentrodecosto_id')."' and ciudad = '".Input::get('ciudad')."' and anulado is null and nomostrar is null";
          $consulta_orden = "SELECT * FROM ordenes_facturacion WHERE '".Input::get('fecha_servicio')."' BETWEEN fecha_inicial AND fecha_final and centrodecosto_id = '".Input::get('centrodecosto_id')."' and subcentrodecosto_id = '".Input::get('subcentrodecosto_id')."' and ciudad = '".Input::get('ciudad')."' and anulado is null and nomostrar is null and tipo_orden = 1";

          $liquidacion = DB::select($consulta);

          $ordenes_facturacion = DB::select($consulta_orden);

          if($ordenes_facturacion!=null){

               return Response::json([
                  'respuesta'=>'rechazado',
                  'liquidacion'=>$liquidacion,
                  'ordenes_facturacion'=>$ordenes_facturacion
               ]);

          }else{

            $servicios = Servicio::find(Input::get('id'));

            //ASIGNAR VARIABLES AL RESULTADO DE LA BUSQUEDA DE SERVICIOS
            $centrodecosto = $servicios->centrodecosto_id;
            $subcentrodecosto = $servicios->subcentrodecosto_id;
            $departamento = $servicios->departamento;
            $ciudad = $servicios->ciudad;
            $pasajeros = $servicios->pasajeros;
            $cantidad = $servicios->cantidad;
            $solicitado_por = $servicios->solicitado_por;

            $email_solicitante = $servicios->email_solicitante;

            $firma = $servicios->firma;

            //Valor anterior en la base de datos
            $ruta = $servicios->ruta_id;

            $ruta_nombre_id = $servicios->ruta_nombre_id;
            $recoger_en = $servicios->recoger_en;
            $dejar_en = $servicios->dejar_en;
            $detalle_recorrido = $servicios->detalle_recorrido;
            $proveedor = $servicios->proveedor_id;
            $conductor = $servicios->conductor_id;
            $vehiculo = $servicios->vehiculo_id;
            $fecha_servicio = $servicios->fecha_servicio;
            $hora_servicio = $servicios->hora_servicio;
            $resaltar = $servicios->resaltar;
            $pago_directo = $servicios->pago_directo;
            $origen = $servicios->origen;
            $destino = $servicios->destino;
            $vuelo = $servicios->vuelo;
            $aerolinea = $servicios->aerolinea;
            $hora_salida = $servicios->hora_salida;
            $hora_llegada = $servicios->hora_llegada;
            $app_user_id = $servicios->app_user_id;

            if ($centrodecosto!=Input::get('centrodecosto_id')) {
                $centro1 = DB::table('centrosdecosto')->where('id',Input::get('centrodecosto_id'))->first();
                $centro2 = DB::table('centrosdecosto')->where('id',$centrodecosto)->first();

                $cambios = $cambios.'Se cambio el centro de costo de <b>'.$centro2->razonsocial.'</b> a <b>'.$centro1->razonsocial.'</b><br>';
            }

            if ($subcentrodecosto!=Input::get('subcentrodecosto_id')) {
                $subcentro1 = DB::table('subcentrosdecosto')->where('id',Input::get('subcentrodecosto_id'))->first();
                $subcentro2 = DB::table('subcentrosdecosto')->where('id',$subcentrodecosto)->first();
                $cambios = $cambios.'Se cambio el subcentro de costo de <b>'.$subcentro2->nombresubcentro.'</b> a <b>'.$subcentro1->nombresubcentro.'</b><br>';
            }

            if ($departamento!=Input::get('departamento')) {
                $cambios = $cambios.'Se cambio el departamento de <b>'.$departamento.'</b> a <b>'.Input::get('departamento').'</b><br>';
            }

            if ($ciudad!=Input::get('ciudad')) {
                $cambios = $cambios.'Se cambio la ciudad de <b>'.$ciudad.'</b> a <b>'.Input::get('ciudad').'</b><br>';
            }

            if ($pasajeros!=$pasajeros_todos) {
                $cambios = $cambios.'Se cambiaron los datos de los <b>Pasajeros</b><br>';
            }

            if ($cantidad!=Input::get('cantidad')) {
                $cambios = $cambios.'Se cambio la <b>cantidad</b> de pasajeros de <b>'.$cantidad.'</b> a <b>'.Input::get('cantidad').'</b><br>';
            }

            if ($solicitado_por!=Input::get('solicitado_por')) {
                $cambios = $cambios.'Se cambio el nombre de la persona que solicito el servicio de <b>'.$solicitado_por.'</b> a <b>'.Input::get('solicitado_por').'</b><br>';
            }

            if ($email_solicitante!=Input::get('email_solicitante')) {
                $cambios = $cambios.'Se cambio el email la persona que solicito el servicio de <b>'.$solicitado_por.'</b> a <b>'.Input::get('email_solicitante').'</b><br>';
            }

            //Si el valor anterior es diferente del actual
            if ($ruta!=Input::get('ruta_id')) {

              if ($ruta==null) {
                /*
                if (Input) {
                  // code...
                }*/

                $rutas2 = Tarifastraslados::where('id', Input::get('ruta_id'))->first();
                $cambios = $cambios.'Se asigno el nombre de ruta <b>'.$rutas2->tarifa_nombre.'</b><br>';

              }else {

                //Anterior
                $rutas1 = Tarifastraslados::where('id', $ruta)->first();

                //Actual
                $rutas2 = Tarifastraslados::where('id', Input::get('ruta_id'))->first();

                //Si no encuentra la ruta entonces debe buscar la ruta en las rutas anteriores
                if (!count($rutas1)) {

                  $rutas1 = Rutat::where('id', $ruta)->first();

                  $cambios = $cambios.'Se cambio la ruta del servicio de <b>'.$rutas1->nombre_ruta.'</b> a <b>'.
                             $rutas2->tarifa_nombre.'</b><br>';

                }else {

                  $cambios = $cambios.'Se cambio la ruta del servicio de <b>'.$rutas1->tarifa_nombre.'</b> a <b>'.
                             $rutas2->tarifa_nombre.'</b><br>';

                }

              }

            }

            if ($recoger_en!=Input::get('recoger_en')) {
                $cambios = $cambios.'Se cambio el campo recoger en de <b>'.$recoger_en.'</b> a <b>'.Input::get('recoger_en').'</b><br>';
            }

            if ($dejar_en!=Input::get('dejar_en')) {
                $cambios = $cambios.'Se cambio el campo dejar en de <b>'.$dejar_en.'</b> a <b>'.Input::get('dejar_en').'</b><br>';
            }

            if ($detalle_recorrido!=Input::get('detalle_recorrido')) {
                $cambios = $cambios.'Se cambio el campo detalle del recorrido de <b>'.$detalle_recorrido.'</b> a <b>'.Input::get('detalle_recorrido').'</b><br>';
            }

            if ($ruta_nombre_id!=Input::get('nombre_ruta_id')) {

                if ($ruta_nombre_id==null) {

                  if (Input::get('nombre_ruta_id')!=0) {

                    $ruta_nombre1 = NombreRuta::where('id', Input::get('nombre_ruta_id'))->first();
                    $cambios = $cambios.'Se asigno el nombre de ruta <b>'.$ruta_nombre1->nombre.'</b><br>';

                  }

                }else{

                  $ruta_nombre1 = NombreRuta::where('id', Input::get('nombre_ruta_id'))->first();
                  $ruta_nombre2 = NombreRuta::where('id', $ruta_nombre_id)->first();

                  $cambios = $cambios.'Se cambio el nombre de la ruta de <b>'.$ruta_nombre2->nombre.'</b> a <b>'.$ruta_nombre1->nombre.'</b><br>';

                }

            }

            if ($proveedor!=Input::get('proveedor_id')) {
                $proveedor1 = DB::table('proveedores')->where('id',Input::get('proveedor_id'))->first();
                $proveedor2 = DB::table('proveedores')->where('id',$proveedor)->first();
                $cambios = $cambios.'Se cambio el proveedor de <b>'.$proveedor2->razonsocial.'</b> a <b>'.$proveedor1->razonsocial.'</b><br>';
            }

            if ($conductor!=Input::get('conductor_id')) {
                $conductor1 = DB::table('conductores')->where('id',Input::get('conductor_id'))->first();
                $conductor2 = DB::table('conductores')->where('id',$conductor)->first();
                $cambios = $cambios.'Se cambio el conductor de <b>'.$conductor2->nombre_completo.'</b> a <b>'.$conductor1->nombre_completo.'</b><br>';
            }

            if ($vehiculo!=Input::get('vehiculo_id')) {
                $vehiculo1 = DB::table('vehiculos')->where('id',Input::get('vehiculo_id'))->first();
                $vehiculo2 = DB::table('vehiculos')->where('id',$vehiculo)->first();
                $cambios = $cambios.'Se cambio el vehiculo de marca <b>'.$vehiculo2->marca.'</b> y placas <b>'.$vehiculo2->placa.'</b> a el vehiculo de marca <b>'.$vehiculo1->marca.'</b> y placas <b>'.$vehiculo1->placa.'</b><br>';
            }

            if ($fecha_servicio!=Input::get('fecha_servicio')) {
                $cambios = $cambios.'Se cambio la fecha del servicio de <b>'.$fecha_servicio.'</b> al <b>'.Input::get('fecha_servicio').'</b><br>';
            }

            if ($hora_servicio!=Input::get('hora_servicio')) {
                $cambios = $cambios.'Se cambio la hora del servicio de <b>'.$hora_servicio.'</b> al <b>'.Input::get('hora_servicio').'</b><br>';
            }

            if ($resaltar!=Input::get('resaltar')) {
                $cambios = $cambios.'Se cambio el campo resaltar<br>';
            }

            if ($firma!=Input::get('firma')) {
                $cambios = $cambios.'Se cambio el campo firma<br>';
            }

            if ($pago_directo!=Input::get('pago_directo')) {
                $cambios = $cambios.'Se cambio el campo pago directo<br>';
            }

            if ($origen!=Input::get('origen')) {
                $cambios = $cambios.'Se cambio el campo origen de <b>'.$origen.'</b> a <b>'.Input::get('origen').'</b><br>';
            }

            if ($destino!=Input::get('destino')) {
                $cambios = $cambios.'Se cambio el campo destino de <b>'.$destino.'</b> a <b>'.Input::get('destino').'</b><br>';
            }

            if ($aerolinea!=Input::get('aerolinea')) {
                $cambios = $cambios.'Se cambio el campo aerolinea de <b>'.$aerolinea.'</b> a <b>'.Input::get('aerolinea').'</b><br>';
            }

            if ($vuelo!=Input::get('vuelo')) {
                $cambios = $cambios.'Se cambio el campo vuelo de <b>'.$vuelo.'</b> a <b>'.Input::get('vuelo').'</b><br>';
            }

            if ($hora_salida!=Input::get('hora_salida')) {
                $cambios = $cambios.'Se cambio el campo hora de salida de <b>'.$hora_salida.'</b> a <b>'.Input::get('hora_salida').'</b><br>';
            }

            if ($hora_llegada!=Input::get('hora_llegada')) {
                $cambios = $cambios.'Se cambio el campo hora de llegada de <b>'.$hora_llegada.'</b> a <b>'.Input::get('hora_llegada').'</b><br>';
            }

            //Si user app id es null, no ha sido asignado en la base de datos
            if ($servicios->app_user_id==null) {

              //Si el campo en la base de datos es null y el campo ingresado es diferente
              if ($app_user_id!=Input::get('app_user_id') and $app_user_id!=null) {

                  //Buscar el usuario
                  $usuario_anterior = User::find(Input::get('app_user_id'));

                  //Guardar cambios en el usuario
                  $cambios = $cambios.'Se asigno el usuario app '.$usuario_anterior->first_name.' '.$usuario_anterior->last_name.' al servicio';

              }

            }else {

              if ($app_user_id!=Input::get('app_user_id')) {

                  $usuario_anterior = User::find($servicios->app_user_id);
                  $usuario_nuevo = User::find(Input::get('app_user_id'));

                  $cambios = $cambios.'Se cambio el usuario del app de '.$usuario_anterior->first_name.' '.$usuario_anterior->last_name.' a '.$usuario_nuevo->first_name.' '.$usuario_nuevo->last_name;

              }

            }

						if($cambios!=''){

							$servicio_editado = new Servicioeditado;

							$servicio_editado->centrodecosto_id = Input::get('centrodecosto_id');
  							$servicio_editado->subcentrodecosto_id = Input::get('subcentrodecosto_id');
  							$servicio_editado->departamento = Input::get('departamento');
  							$servicio_editado->ciudad = Input::get('ciudad');
  							$servicio_editado->pasajeros = $pasajeros_todos;
  							$servicio_editado->cantidad = Input::get('cantidad');

  							$servicio_editado->solicitado_por = Input::get('solicitado_por');

  							$servicio_editado->email_solicitante = Input::get('email_solicitante');

  							$servicio_editado->firma = Input::get('firma');

  							$servicio_editado->ruta_id = Input::get('ruta_id');
  							$servicio_editado->ruta_nombre_id = Input::get('nombre_ruta_id');
  							$servicio_editado->recoger_en = Input::get('recoger_en');
  							$servicio_editado->dejar_en = Input::get('dejar_en');
  							$servicio_editado->detalle_recorrido = Input::get('detalle_recorrido');
  							$servicio_editado->proveedor_id = Input::get('proveedor_id');
  							$servicio_editado->conductor_id = Input::get('conductor_id');
  							$servicio_editado->vehiculo_id = Input::get('vehiculo_id');
  							$servicio_editado->fecha_servicio = Input::get('fecha_servicio');
  							$servicio_editado->hora_servicio = Input::get('hora_servicio');
  							$servicio_editado->resaltar = Input::get('resaltar');
  							$servicio_editado->pago_directo = Input::get('pago_directo');
  							$servicio_editado->origen = Input::get('origen');
  							$servicio_editado->destino = Input::get('destino');
  							$servicio_editado->vuelo = Input::get('vuelo');
  							$servicio_editado->aerolinea = Input::get('aerolinea');
  							$servicio_editado->hora_salida = Input::get('hora_salida');
  							$servicio_editado->hora_llegada = Input::get('hora_llegada');
  							$servicio_editado->actualizado_por = Sentry::getUser()->id;
              $servicio_editado->notificacion = Input::get('notificacion');

              $servicio_editado->app_user_id = Input::get('app_user_id');

							$servicio_editado->cambios =strtoupper($cambios);
							$servicio_editado->id_servicio = $servicios->id;

              if($servicio_editado->save()){

              	$pivote = DB::table('servicios_edicion_pivote')->where('servicios_id',$servicios->id)->first();

              	if ($pivote!=null) {

                  $ediciones_servicios = DB::table('ediciones_servicios')
                  ->insert([
                  	'cambios'=>'SE MODIFICO SERVICIO, ESPERANDO AUTORIZACION.',
                  	'created_at'=>date('Y-m-d H:i:s'),
                  	'creado_por'=>Sentry::getUser()->id,
                  	'servicios_edicion_id'=>$pivote->id
                  ]);

              	}else{

              		$id = DB::table('servicios_edicion_pivote')->insertGetId(['servicios_id'=>$servicios->id]);

              		$ediciones_servicios = DB::table('ediciones_servicios')
              			->insert([
              				'cambios'=>'SE MODIFICO SERVICIO, ESPERANDO AUTORIZACION.',
              				'created_at'=>date('Y-m-d H:i:s'),
              				'creado_por'=>Sentry::getUser()->id,
              				'servicios_edicion_id'=>$id
              			]);
              	}

              	return Response::json([
              		'respuesta'=>true
              	]);

              }

            }else{

              return Response::json([
                  'respuesta'=>'error'
              ]);

            }

          }

        }

      }

    }

  }

  public function postRechazarcambios(){

		if (!Sentry::check()){
            return Response::json(['respuesta'=>'relogin']);
        }else{
			if (Request::ajax()){
				//$id= Input::get('id');
				//$id_edit= Input::get('id_edit');

				DB::table('servicios_editados')->where('id',Input::get('id_edit'))
					->update([
						'autorizado'=>2,
						'autorizado_por'=>Sentry::getUser()->id,
						'autorizado_fecha'=>date('Y-m-d H:i:s')
					]);
				$servicio_editado = DB::table('servicios_editados')->where('id', Input::get('id_edit'))->first();
				$no_cambios = $servicio_editado->cambios;
				$no_cambio = str_replace('SE CAMBIO','NO SE CAMBIO',$no_cambios);

				$cambios = "<b>".Sentry::getUser()->first_name." ".Sentry::getUser()->last_name. ", RECHAZO CAMBIOS SOLICITADOS: </b><br>".$no_cambio . "<br>";
				$pivote = DB::table('servicios_edicion_pivote')->where('servicios_id',Input::get('id'))->first();
				if ($pivote!=null) {
					$ediciones_servicios = DB::table('ediciones_servicios')
						->insert([
							'cambios'=>$cambios,
							'created_at'=>date('Y-m-d H:i:s'),
							'creado_por'=>$servicio_editado->actualizado_por,
							'servicios_edicion_id'=>$pivote->id
						]);
				}else{
					$id = DB::table('servicios_edicion_pivote')->insertGetId(['servicios_id'=>Input::get('id')]);

					$ediciones_servicios = DB::table('ediciones_servicios')
						->insert([
							'cambios'=>$cambios,
							'created_at'=>date('Y-m-d H:i:s'),
							'creado_por'=>$servicio_editado->actualizado_por,
							'servicios_edicion_id'=>$id
						]);
				}

				return Response::json(['respuesta'=>true]);
			}
		}
	}

	public function postAutorizarcambios(){

		if (!Sentry::check()){

        return Response::json([
          'respuesta' => 'relogin'
        ]);

    }else{

			if (Request::ajax()){
				//$id= Input::get('id');
				//$id_edit= Input::get('id_edit');

				DB::table('servicios_editados')->where('id',Input::get('id_edit'))
				->update([
					'autorizado'=>1,
					'autorizado_por'=>Sentry::getUser()->id,
					'autorizado_fecha'=>date('Y-m-d H:i:s')
				]);

				$servicio_editado = DB::table('servicios_editados')->where('id', Input::get('id_edit'))->first();
				$servicio = Servicio::find(Input::get('id'));

        //tomar valores para comparar
        $compareRecogeren = $servicio->recoger_en;
        $compareDejaren = $servicio->dejar_en;
        $compareFechaservicio = $servicio->fecha_servicio;
        $compareHoraservicio = $servicio->hora_servicio;
        //conductor actual
        $compareConductorid = $servicio->conductor_id;
        //conductor nuevo
        $nuevoconductor = $servicio_editado->conductor_id;

				//$servicio_editado->actualizado_por;
				//$servicio_editado->cambios;
				$servicio->centrodecosto_id =$servicio_editado->centrodecosto_id;
  				$servicio->subcentrodecosto_id= $servicio_editado->subcentrodecosto_id;
  				$servicio->departamento =$servicio_editado->departamento;
  				$servicio->ciudad =$servicio_editado->ciudad;
  				$servicio->pasajeros =$servicio_editado->pasajeros;
  				$servicio->cantidad =$servicio_editado->cantidad;
  				$servicio->solicitado_por = $servicio_editado->solicitado_por;

  				$servicio->email_solicitante = $servicio_editado->email_solicitante;

  				$servicio->firma = $servicio_editado->firma;

  				$servicio->ruta_id = $servicio_editado->ruta_id;
  				$servicio->ruta_nombre_id =$servicio_editado->ruta_nombre_id;
  				$servicio->recoger_en = $servicio_editado->recoger_en;
  				$servicio->dejar_en = $servicio_editado->dejar_en;
  				$servicio->detalle_recorrido = $servicio_editado->detalle_recorrido;
  				$servicio->proveedor_id = $servicio_editado->proveedor_id;
  				$servicio->conductor_id = $servicio_editado->conductor_id;
  				$servicio->vehiculo_id = $servicio_editado->vehiculo_id;
  				$servicio->fecha_servicio = $servicio_editado->fecha_servicio;
  				$servicio->hora_servicio = $servicio_editado->hora_servicio;
  				$servicio->resaltar = $servicio_editado->resaltar;
  				$servicio->pago_directo = $servicio_editado->pago_directo;
  				$servicio->origen = $servicio_editado->origen;
  				$servicio->destino = $servicio_editado->destino;
  				$servicio->vuelo = $servicio_editado->vuelo;
  				$servicio->aerolinea = $servicio_editado->aerolinea;
  				$servicio->hora_salida = $servicio_editado->hora_salida;
  				$servicio->hora_llegada = $servicio_editado->hora_llegada;
			  $servicio->actualizado_por = $servicio_editado->actualizado_por;


        if ($servicio_editado->app_user_id!=false) {

          $servicio->app_user_id = $servicio_editado->app_user_id;

        }

				//$servicio_editado->cambios =strtoupper($cambios);
				$cambios = "<b>SE AUTORIZO CAMBIOS, SOLICITADOS: </b><br>".$servicio_editado->cambios. "<br>";

				if($servicio->save()){

          $servicio_id = $servicio->id;

					$pivote = DB::table('servicios_edicion_pivote')->where('servicios_id',Input::get('id'))->first();

					if ($pivote!=null) {

						$ediciones_servicios = DB::table('ediciones_servicios')
						->insert([
							'cambios'=>$cambios,
							'created_at'=>date('Y-m-d H:i:s'),
							'creado_por'=>$servicio_editado->actualizado_por,
							'servicios_edicion_id'=>$pivote->id
						]);

					}else{

						$id = DB::table('servicios_edicion_pivote')->insertGetId(['servicios_id'=>Input::get('id')]);

						$ediciones_servicios = DB::table('ediciones_servicios')
							->insert([
								'cambios'=>$cambios,
								'created_at'=>date('Y-m-d H:i:s'),
								'creado_por'=>$servicio_editado->actualizado_por,
								'servicios_edicion_id'=>$id
							]);
					}

          $cambiosNotificaciones = '';
          $cambiosConductor = false;

          //las notificaciones solo seran para lugar de recogida, destino, fecha, hora, centro de costo y cambio de conductor.
          if ($compareRecogeren!=$servicio_editado->recoger_en) {
              $cambiosNotificaciones = $cambiosNotificaciones.'Hubo cambios en el servicio programado para la fecha: '.$compareFechaservicio.', hora: '.$compareHoraservicio.', se cambio el lugar de recojida de '.$compareRecogeren.' a '.$servicio->recoger_en;
          }
          //notificacion para el cambio en lugar de destino
          if ($compareDejaren!=$servicio_editado->dejar_en) {
              if ($cambiosNotificaciones!='') {
                  $cambiosNotificaciones = $cambiosNotificaciones.', el lugar de destino de '.$compareDejaren.' a '.$servicio->dejar_en;
              }else{
                  $cambiosNotificaciones = $cambiosNotificaciones.'Hubo cambios en el servicio programado para la fecha: '.$compareFechaservicio.' y hora: '.$compareHoraservicio.', se cambio el lugar de destino de '.$compareDejaren.' a '.$servicio->dejar_en;
              }
          }

          if ($compareFechaservicio!=$servicio_editado->fecha_servicio) {

              //$servicio = Servicio::find($servicio_id);
              //$servicio->notificaciones_reconfirmacion = null;
              //$servicio->save();

              if ($cambiosNotificaciones!='') {
                  $cambiosNotificaciones = $cambiosNotificaciones.', la fecha de '.$compareFechaservicio.' a '.$servicio->fecha_servicio;
              }else{
                  $cambiosNotificaciones = $cambiosNotificaciones.'Hubo cambios en el servicio programado para la fecha: '.$compareFechaservicio.' y hora: '.$compareHoraservicio.', se cambio la fecha de '.$compareFechaservicio.' a '.$servicio->fecha_servicio;
              }
          }

          //notificacion para el cambio de hora
          if ($compareHoraservicio!=$servicio_editado->hora_servicio) {

              //$servicio = Servicio::find($servicio_id);
              //$servicio->notificaciones_reconfirmacion = null;
              //$servicio->save();

              if ($cambiosNotificaciones!='') {
                  $cambiosNotificaciones = $cambiosNotificaciones.', la hora de '.$compareHoraservicio.' a '.$servicio->hora_servicio;
              }else{
                  $cambiosNotificaciones = $cambiosNotificaciones.'Hubo cambios en el servicio programado para la fecha: '.$compareFechaservicio.' y hora: '.$compareHoraservicio.', se cambio la hora de '.$compareHoraservicio.' a '.$servicio->hora_servicio;
              }
          }

          //notificacion para el cambio conductor y historial de cambios en el servicio
          if ($compareConductorid!=$servicio_editado->conductor_id) {

              //cuando se cambia de conductor toca iniciar aceptado = 0 y reiniciar las reconfirmaciones, por si el conductor habia aceptado antes y tiene que aceptar otro conductor
              $servicio = Servicio::find($servicio_id);
              $servicio->aceptado_app = null;
              //$servicio->notificaciones_reconfirmacion = null;
              $servicio->hora_programado_app = date('Y-m-d H:i:s');
              $servicio->save();

              //conductor actual
              $conductor2 = DB::table('conductores')->where('id',$compareConductorid)->first();

              //nuevoconductor
              $conductor1 = DB::table('conductores')->where('id',$nuevoconductor)->first();

              $centrodecosto = Centrodecosto::find($servicio->centrodecosto_id);

              if ($cambiosNotificaciones!='') {
                  $cambiosNotificaciones = $cambiosNotificaciones.', para '.$centrodecosto->razonsocial.', este servicio ha sido cancelado';
                  //$cambiosNotificaciones = $cambiosNotificaciones.', para '.$centrodecosto->razonsocial.', este servicio ha sido programado para otro conductor';
              }else{
                  $cambiosNotificaciones = $cambiosNotificaciones.'Hubo cambios en el servicio programado para la fecha: '.$compareFechaservicio.', hora: '.$compareHoraservicio.', para '.$centrodecosto->razonsocial.', este servicio ha sido cancelado';
                  //$cambiosNotificaciones = $cambiosNotificaciones.'Hubo cambios en el servicio programado para la fecha: '.$compareFechaservicio.', hora: '.$compareHoraservicio.', para '.$centrodecosto->razonsocial.', este servicio ha sido programado para otro conductor';
              }

              $cambiosConductor = true;

              //se deben hacer dos notificaciones, una para decirle al conductor que no tiene ese servicio asignado y otra para avisar del servicio al nuevo conductor

              // 1. notificacion de cancelacion
              Servicio::Notificaciones($cambiosNotificaciones, $conductor2->id);

              //buscar nombre de centro de costo
              $centrodecosto = Centrodecosto::find($servicio->centrodecosto_id);
              $nuevo_servicio = 'Se le ha asignado un nuevo servicio para el día '.$servicio->fecha_servicio.' y hora: '.$servicio->hora_servicio.' para recoger en: '.$servicio->recoger_en.' y dejar en: '.$servicio->dejar_en.' para '.$centrodecosto->razonsocial;

              // 2. notificacion de servicio asignado a conductor
              Servicio::Notificaciones($nuevo_servicio, $conductor1->id);

          }

          if (intval($servicio_editado->notificacion)===1) {

            //si hay cambio de conductor no enviar notificacion para no enviarl doble ya que se envia mas arriba
            if ($cambiosConductor===false) {

              $centrodecosto = Centrodecosto::find($servicio->centrodecosto_id);

              $cambiosNotificaciones = $cambiosNotificaciones.' para '.$centrodecosto->razonsocial;

              $responseNotificacion = Servicio::Notificaciones($cambiosNotificaciones, $servicio->conductor_id);
            }

          }

					return Response::json(['respuesta'=>true]);
				}else{
						return Response::json(['respuesta'=>false]);
				}
			}
		}
	}

	public function getRutas(){
		if (Sentry::check()){
            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
            $ver = $permisos->bogota->servicios->ver;
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
								->leftJoin('servicios_autorizados_pdf', 'servicios.id', '=', 'servicios_autorizados_pdf.servicio_id')
                ->select('servicios.id','servicios.fecha_orden','servicios.fecha_servicio','servicios.finalizado','servicios.rechazar_eliminacion',
                         'facturacion.revisado','facturacion.liquidado','facturacion.facturado','facturacion.factura_id',
                         'servicios.solicitado_por','servicios.resaltar','servicios.pago_directo','servicios.ruta',
                         'servicios.fecha_solicitud','servicios.pasajeros_ruta','servicios.ciudad','servicios.recoger_en','servicios.dejar_en',
                         'servicios.detalle_recorrido','servicios.pasajeros','servicios.hora_servicio','servicios.origen','servicios.motivo_eliminacion',
                         'servicios.pendiente_autori_eliminacion', 'servicios.estado_servicio_app',
                         'servicios.destino', 'servicios.aerolinea', 'servicios.vuelo', 'servicios.hora_salida',
                         'servicios.hora_llegada', 'servicios.cancelado','centrosdecosto.razonsocial',
                         'subcentrosdecosto.nombresubcentro','users.first_name','users.last_name',
                         'rutas.nombre_ruta','rutas.codigo_ruta','proveedores.razonsocial AS razonproveedor',
                         'conductores.nombre_completo','conductores.celular','conductores.telefono',
                         'reconfirmacion.numero_reconfirmaciones','reconfirmacion.id as id_reconfirmacion','reconfirmacion.ejecutado',
                         'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo',
                         'encuesta.pregunta_1','encuesta.pregunta_2','encuesta.pregunta_3','encuesta.pregunta_4',
                         'encuesta.pregunta_8','encuesta.pregunta_9','encuesta.pregunta_10',
                         'servicios_edicion_pivote.id as id_pivote', 'reportes_pivote.id as id_reporte', 'servicios_autorizados_pdf.documento_pdf1', 'servicios_autorizados_pdf.documento_pdf2')
                ->where('servicios.anulado',0)
                ->where('servicios.cancelado',0)
                ->whereNull('servicios.pendiente_autori_eliminacion')
                ->whereNotNull('servicios.ruta')
				->where('fecha_servicio',date('Y-m-d'))
                ->orderBy('hora_servicio')
                ->get();

            $proveedores = DB::table('proveedores')
            ->where('tipo_servicio','TRANSPORTE TERRESTRE')
            ->whereNull('inactivo_total')
			->whereNull('inactivo')
            ->orderBy('razonsocial')->get();

            $centrosdecosto = DB::table('centrosdecosto')
            ->whereNull('inactivo_total')
            ->orderBy('razonsocial')
            ->get();

            $subcentros = DB::table('subcentrosdecosto')->orderBy('nombresubcentro')->get();
            $departamentos = DB::table('departamento')->get();
            $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
            $rutas = DB::table('rutas')->get();
            $usuarios = DB::table('users')->where('coordinador',1)->where('activated',1)->get();

			$cotizaciones = DB::table('cotizaciones')->where('estado',1)->orderBy('created_at', 'desc')->take(10)->get();

            return View::make('servicios.rutas')
                ->with('cotizaciones',$cotizaciones)
				->with('servicios',$servicios)
                ->with('centrosdecosto',$centrosdecosto)
                ->with('departamentos',$departamentos)
                ->with('ciudades',$ciudades)
                ->with('proveedores',$proveedores)
                ->with('rutas',$rutas)
                ->with('permisos',$permisos)
                ->with('usuarios',$usuarios)
                ->with('o',$o=1);
        }
	}

  public function postRegistraridweb(){

    $user = User::find(Sentry::getUser()->id);
    $user->id_registration_web = Input::get('token');
    if ($user->save()) {
      return Response::json([
        'respuesta' => true
      ]);
    }

  }

  public function getServiciosporaceptar(){

    if (Sentry::check()){

      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->bogota->poraceptar->ver;
      if (isset($permisos->bogota->poraceptar->ver)) {
        $ver = $permisos->bogota->poraceptar->ver;
      }else{
        return View::make('admin.permisos');
      }

    }else{
        $ver = null;
    }

    if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on') {
          return View::make('admin.permisos');
    }else{

      $servicios = Servicio::whereNull('pendiente_autori_eliminacion')
      ->whereRaw("TIMESTAMPDIFF(MINUTE, now(), CONCAT(fecha_servicio,' ',hora_servicio)) > 1")
      ->where('aceptado_app', 0)
      ->orWhere('aceptado_app', 3)
      ->orderBy('hora_servicio')->get();

      $proveedores = DB::table('proveedores')
      ->where('tipo_servicio','TRANSPORTE TERRESTRE')
      ->whereNull('inactivo_total')
      ->whereNull('inactivo')
      ->orderBy('razonsocial')->get();

      return View::make('servicios.poraceptar')->with([
        'a' => 1,
        'servicios' => $servicios,
        'proveedores' => $proveedores,
        'permisos' => $permisos
      ]);

    }

  }

  public function postCambiarproveedor(){

    if (!Sentry::check()){

        return Response::json([
            'respuesta'=>'relogin'
        ]);

    }else{

        if (Request::ajax()){

          $servicio = Servicio::find(Input::get('servicio_id'));

          return Response::json([
            'respuesta' => true,
            'servicio' => $servicio,
            'conductores' => $servicio->proveedor->conductores(),
            'vehiculos' => $servicio->proveedor->vehiculos()
          ]);

        }
    }

  }

  public function postGuardarcambioproveedor(){

    if (!Sentry::check()){

        return Response::json([
            'respuesta'=>'relogin'
        ]);

    }else{

      if (Request::ajax()) {

        $servicio = Servicio::find(Input::get('servicio_id'));

        $proveedor_id = Input::get('proveedor_id');
        $conductor_id = Input::get('conductor_id');
        $vehiculo_id = Input::get('vehiculo_id');

        $proveedor = $servicio->proveedor_id;
        $conductor = $servicio->conductor_id;
        $vehiculo = $servicio->vehiculo_id;

        if ($proveedor_id!=$servicio->proveedor_id or $conductor_id!=$servicio->conductor_id or $vehiculo_id!=$servicio->vehiculo_id) {

            $servicio->proveedor_id = $proveedor_id;
            $servicio->conductor_id = $conductor_id;
            $servicio->vehiculo_id = $vehiculo_id;
            $servicio->aceptado_app = 0;
            //$servicio->notificaciones_reconfirmacion = null;
            $servicio->hora_programado_app = date('Y-m-d H:i:s');

            if($servicio->save()){

              $cambios = '';

              if ($proveedor!=$servicio->proveedor_id) {
                  $proveedor1 = DB::table('proveedores')->where('id',$servicio->proveedor_id)->first();
                  $proveedor2 = DB::table('proveedores')->where('id',$proveedor)->first();
                  $cambios = $cambios.'Se cambio el proveedor de <b>'.$proveedor2->razonsocial.'</b> a <b>'.$proveedor1->razonsocial.'</b><br>';
              }

              if ($conductor!=$servicio->conductor_id) {
                  $conductor1 = DB::table('conductores')->where('id',$servicio->conductor_id)->first();
                  $conductor2 = DB::table('conductores')->where('id',$conductor)->first();
                  $cambios = $cambios.'Se cambio el proveedor de <b>'.$conductor2->nombre_completo.'</b> a <b>'.$conductor1->nombre_completo.'</b><br>';
              }

              if ($vehiculo!=$servicio->vehiculo_id) {
                  $vehiculo1 = DB::table('vehiculos')->where('id',$servicio->vehiculo_id)->first();
                  $vehiculo2 = DB::table('vehiculos')->where('id',$vehiculo)->first();
                  $cambios = $cambios.'Se cambio el vehiculo de marca <b>'.$vehiculo2->marca.'</b> y placas <b>'.$vehiculo2->placa.'</b> a el vehiculo de marca <b>'.$vehiculo1->marca.'</b> y placas <b>'.$vehiculo1->placa.'</b><br>';
              }

              $number = rand(1000000, 9999999);
              $notificacion = Servicio::enviarNotificaciones($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $number, $servicio->id);

              if ($cambios!='') {

                  $pivote = DB::table('servicios_edicion_pivote')->where('servicios_id',$servicio->id)->first();

                  if ($pivote!=null) {

                      $ediciones_servicios = DB::table('ediciones_servicios')
                          ->insert([
                              'cambios'=>$cambios,
                              'created_at'=>date('Y-m-d H:i:s'),
                              'creado_por'=>Sentry::getUser()->id,
                              'servicios_edicion_id'=>$pivote->id
                          ]);

                  }else{

                      $id = DB::table('servicios_edicion_pivote')
                          ->insertGetId([
                              'servicios_id'=>$servicio->id
                          ]);

                      $ediciones_servicios = DB::table('ediciones_servicios')
                          ->insert([
                              'cambios'=>strtoupper($cambios),
                              'created_at'=>date('Y-m-d H:i:s'),
                              'creado_por'=>Sentry::getUser()->id,
                              'servicios_edicion_id'=>$id
                          ]);
                  }

                  return Response::json([
                      'respuesta'=>true,
                  ]);

              }else{

                  return Response::json([
                      'respuesta'=>'error',
                  ]);
              }

            }

        }else {

          return Response::json([
              'respuesta'=> 'no_cambios'
          ]);

        }

      }

    }

  }

  public function getServiciosafiliadosexternos(){

    $ver = null;

    if (Sentry::check()){

        $rol_id = Sentry::getUser()->id_rol;

        $permisos = json_decode(Rol::find($rol_id)->permisos);

        if (isset($permisos->bogota->afiliadosexternos->ver)) {

            $ver = $permisos->bogota->afiliadosexternos->ver;

            if($ver!='on') {

                return Redirect::to('permiso_denegado');

            }else{

                $servicios = Servicio::afiliadosexternos()
                ->where('fecha_servicio', date('Y-m-d'))
                ->whereNull('pendiente_autori_eliminacion')
                ->orderBy('hora_servicio','asc')
                ->get();

                $proveedores = Proveedor::valido()->orderBy('razonsocial')->get();
                $centrosdecosto = Centrodecosto::activos()->afiliadosexternos()->orderBy('razonsocial')->get();
                $departamentos = Departamento::all();
                $ciudades = Ciudad::orderBy('ciudad')->get();
                $rutas = DB::table('rutas')->get();
                $usuarios = User::all();

                return View::make('servicios.transportes_afiliados_ex', [
                    'permisos' => $permisos,
                    'servicios' => $servicios,
                    'proveedores' => $proveedores,
                    'centrosdecosto' => $centrosdecosto,
                    'departamentos' => $departamentos,
                    'ciudades' => $ciudades,
                    'rutas' => $rutas,
                    'usuarios' => $usuarios,
                    'o' => 1
                ]);

            }

        }else{

            return Redirect::to('permiso_denegado');
        }

    }else if(!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }

  }

  public function getExportarplanederodamiento(){

    $rules = [
      'fecha_inicial' => 'required|date:format',
      'fecha_inicial' => 'required'
    ];

    $validator = Validator::make($rules, Input::all());

    if ($validator->fails()) {
      // code...
    }

  }

  public function postEnviarmailservicios(){

    $rules = [
      'correo_electronico' => 'required',
      'contenido_email' => 'required',
      'asunto' => 'required'
    ];

    $messages = [
      'contenido_email.required' => 'El campo detalles es requerido'
    ];

    $validator = Validator::make(Input::all(), $rules, $messages);

    if ($validator->fails()) {

      return Response::json([
        'response' => false,
        'errores' => $validator->messages()
      ]);

    }else {

      $firma_correo = FirmaCorreo::where('user_id', Sentry::getUser()->id)->first();

      $correo_electronico = explode(',', trim(Input::get('correo_electronico')));

      $cc_correo_electronico = Input::get('cc_correo_electronico');

      if ($cc_correo_electronico!='') {
        $cc_correo_electronico = explode(',', trim(Input::get('cc_correo_electronico')));
      }else {
        $cc_correo_electronico = null;
      }

      $contenido_email = trim(Input::get('contenido_email'));
      $contenido_correo_electronico = json_decode(Input::get('contenido_correo_electronico'));
      $asunto = trim(Input::get('asunto'));

      $html = View::make('emails.envio_servicios', [
        'contenido_email' => $contenido_email,
        'contenido_correo_electronico' => $contenido_correo_electronico,
        'firma_correo' => $firma_correo
      ]);

      Mail::send('emails.envio_servicios', [
        'asunto' => $asunto,
        'contenido_email' => $contenido_email,
        'firma_correo' => $firma_correo,
        'contenido_correo_electronico' => $contenido_correo_electronico
      ],
      function($message) use ($correo_electronico, $asunto, $cc_correo_electronico){

          $message->to($correo_electronico);

          if ($cc_correo_electronico!=null) {
            $message->cc($cc_correo_electronico);
          }

          $message->from('jrosero@aotour.com.co', 'TRANSPORTES - AOTOUR');
          $message->subject($asunto);
      });

      $historial_mails = new HistorialMails();
      $historial_mails->para = json_encode($correo_electronico);
      $historial_mails->cc = json_encode($cc_correo_electronico);
      $historial_mails->vista_renderizada = $html;
      if (count($firma_correo)) {
        $historial_mails->firma_id = $firma_correo->id;
      }
      $historial_mails->contenido_email = $contenido_email;
      $historial_mails->contenido_correo_electronico = json_encode($contenido_correo_electronico);
      $historial_mails->asunto = $asunto;

      if($historial_mails->save()){
        return Response::json([
          'response' => true
        ]);
      }

    }

  }

  //NUEVOS SERVICIOS
  public function getServiciosporprogramar(){

      if (Sentry::check()){

          $id_rol = Sentry::getUser()->id_rol;
          $idusuario = Sentry::getUser()->id;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->bogota->servicios->ver;


      }else{
          $ver = null;
      }

      if (!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on') {

          return View::make('admin.permisos');

      }else{
        $centrosdecosto = Centrodecosto::Activos()->internos()->whereIn('localidad',['bogota','provisional'])->orderBy('razonsocial')->get();
        $proveedores = Proveedor::Valido()->afiliadosinternos()->whereIn('localidad',['bogota','provisional'])->orderBy('razonsocial')->get();
        $departamentos = Departamento::orderBy('departamento', 'asc')->get();
        $subcentrosdecosto = Subcentro::where('centrosdecosto_id', 100)->orderBy('nombresubcentro')->get();
        $tarifas_grupo = Tarifastraslados::select('tarifa_ciudad')->orderBy('tarifa_ciudad')->groupBy('tarifa_ciudad')->get();
        $tarifas = Tarifastraslados::orderBy('tarifa_nombre')->get();
        $servicios_programar = DB::table('servicios_autonet')
        ->leftJoin('centrosdecosto', 'centrosdecosto.id' , '=' , 'servicios_autonet.centrodecosto_id')
        ->select('servicios_autonet.*', 'centrosdecosto.razonsocial')
        ->whereNull('estado_programado')
        ->where('servicios_autonet.localidad','bogota')
        ->orderBy('date')
        ->orderBy('time')->get();

        return View::make('portalusuarios.admin.listado_serviciosadmin')
        ->with('centrosdecosto',$centrosdecosto)
        ->with('proveedores',$proveedores)
        ->with('departamentos',$departamentos)
        ->with('subcentrosdecosto',$subcentrosdecosto)
        ->with('tarifas_grupo',$tarifas_grupo)
        ->with('tarifas',$tarifas)
        ->with('permisos',$permisos)
        ->with('servicios',$servicios_programar);
      }
    }

    public function postMostrarinfoservicio(){

    //Mostrar informacion del servicio
    $servicio = ServicioA::where('id', Input::get('servicio_id'))
    ->first();
    $subcentros = DB::table('subcentrosdecosto')->where('centrosdecosto_id',$servicio->centrodecosto_id)->orderBy('nombresubcentro')->get();

    return Response::json([
      'response' => true,
      'servicio' => $servicio,
      'subcentros' => $subcentros
    ]);

  }

    public function postBuscarsubcentros(){
        $id = Input::get('id');
        $subcentros = DB::table('subcentrosdecosto')->where('centrosdecosto_id', $id)->orderBy('nombresubcentro')->get();

        if(!empty($subcentros)){
            return Response::json([
                'mensaje'=>true,
                'subcentros'=>$subcentros,
            ]);
        }else{
            return Response::json([
                'mensaje'=>false
            ]);
        }
    }


    public function postProgramarservicio(){

    $validaciones = [
        'centrodecosto' => 'required',
        'subcentrodecosto' => 'required|numeric',
        'cantidad_pasajeros' => 'required',
        'departamento' => 'required',
        'ciudad' => 'required'
    ];

    $messages = [
      'subcentrodecosto.numeric' => 'Debe seleccionar un subcentro de costo'
    ];

    //Campos de notificacion y envío de email
    $email_cliente = Input::get('email_cliente');
    $notificacion_conductor = Input::get('notificacion_conductor');

    //Validador de reglas
    $validador = Validator::make(Input::all(), $validaciones, $messages);

    //Si el validador falla
    if ($validador->fails()){

        //Retornar false y errores
        return Response::json([
          'response' => false,
          'errores' => $validador->errors()->getMessages(),
        ]);

    }else {

      $pasajeros = [];
      $pasajeros_todos='';
      $nombres_pasajeros='';
      $celulares_pasajeros='';

      $nombre_pasajeros = explode(',', Input::get('nombres_pasajeros'));
      $celular_pasajeros = explode(',', Input::get('celular_pasajeros'));
      $email_pasajeros = explode(',', Input::get('email_pasajeros'));

      //CONCATENACION DE TODOS LOS DATOS
      for($i=0; $i<count($nombre_pasajeros); $i++){

          $pasajeros[$i] = $nombre_pasajeros[$i].','.$celular_pasajeros[$i].','.$email_pasajeros[$i].'/';
          $pasajeros_nombres[$i] = $nombre_pasajeros[$i].',';
          $pasajeros_telefonos[$i] = $celular_pasajeros[$i].',';
          $pasajeros_todos = $pasajeros_todos.$pasajeros[$i];
          $nombres_pasajeros = $nombres_pasajeros.$pasajeros_nombres[$i];
          $celulares_pasajeros = $celulares_pasajeros.$pasajeros_telefonos[$i];

      }

      $servicio_nuevo = ServicioA::find(Input::get('servicio_autonet_id'));
      $contador = 0;
      $consulta = "SELECT * FROM liquidacion_servicios WHERE '".Input::get('fecha_servicio')."' BETWEEN fecha_inicial AND fecha_final and centrodecosto_id = '".Input::get('centrodecosto')."' and subcentrodecosto_id = '".Input::get('subcentrodecosto')."' and ciudad = '".Input::get('ciudad')."' and anulado is null and nomostrar is null";
        $consulta_orden = "SELECT * FROM ordenes_facturacion WHERE '".Input::get('fecha_servicio')."' BETWEEN fecha_inicial AND fecha_final and centrodecosto_id = '".Input::get('centrodecosto')."' and subcentrodecosto_id = '".Input::get('subcentrodecosto')."' and ciudad = '".Input::get('ciudad')."' and anulado is null and nomostrar is null and tipo_orden = 1";

        $liquidacion = DB::select($consulta);
        $ordenes_facturacion = DB::select($consulta_orden);
        if($liquidacion!=null or $ordenes_facturacion!=null){
            $contador++;
        }else{

            $code = "";
            $characters = array_merge(range('0','9'));
            $max = count($characters) - 1;
            for ($o = 0; $o < 2; $o++) {
              $rand = mt_rand(0, $max);
              $code .= $characters[$rand];
            }

            $servicio = new Servicio();
            $servicio->fecha_orden = date('Y-m-d');
            $servicio->centrodecosto_id = Input::get('centrodecosto');
            $servicio->subcentrodecosto_id = Input::get('subcentrodecosto');
            $servicio->pasajeros = $pasajeros_todos;
            $servicio->cantidad = Input::get('cantidad_pasajeros');
            $servicio->departamento = Input::get('departamento');
            $servicio->ciudad = Input::get('ciudad');
            $servicio->solicitado_por = Input::get('solicitado_por');
            $servicio->fecha_solicitud = Input::get('fecha_solicitud');
            $servicio->estado_email = Input::get('estado_email');
            $servicio->email_solicitante = Input::get('email_solicitante');
            $servicio->ruta_id = Input::get('tarifa_traslado');
            $servicio->recoger_en = Input::get('recoger_en');
            $servicio->dejar_en = Input::get('dejar_en');
            $servicio->detalle_recorrido = Input::get('detalle_recorrido');
            $servicio->proveedor_id = Input::get('proveedor_id');
            $servicio->conductor_id = Input::get('conductor_id');
            $servicio->vehiculo_id = Input::get('vehiculo_id');

            $servicio->fecha_servicio = Input::get('fecha_servicio');

            $servicio->hora_servicio = Input::get('hora_servicio');
            $servicio->resaltar = 1;
            $servicio->pago_directo = 0;
            $servicio->origen = Input::get('origen');
            $servicio->destino = Input::get('destino');
            $servicio->aerolinea = Input::get('aerolinea');
            $servicio->vuelo = Input::get('vuelo');
            $servicio->hora_salida = Input::get('hora_salida');
            $servicio->hora_llegada = Input::get('hora_llegada');
            $servicio->creado_por = Sentry::getUser()->id;
            $servicio->anulado = 0;
            $servicio->cancelado = 0;
            $servicio->aceptado_app = 0;
            $servicio->hora_programado_app = date('Y-m-d H:i:s');
            $servicio->notificaciones_reconfirmacion = $code;
            $servicio->servicios_autonet_id = Input::get('servicio_autonet_id');
            $servicio->localidad = 1;

            if ($servicio->save()) {

              $consulta_sms = DB::table('conductores')
              ->where('id',$servicio->conductor_id)
              ->pluck('celular');

              $consulta_name = DB::table('conductores')
              ->where('id',$servicio->conductor_id)
              ->pluck('nombre_completo');

              $numberok = $consulta_sms;
              $name_first = explode(" ", $consulta_name);

              $servicio_nuevo->estado_programado = 1;
              $servicio_nuevo->programado_fecha = date('Y-m-d H:i:s');
              $servicio_nuevo->servicio_id = $servicio->id;

              //QUERY FIRMA
              $query = FirmaCorreo::select('firma_correo.*', 'firma_correo.id','firma_correo.nombre_completo','firma_correo.nombre_puesto','firma_correo.user_id')
              ->leftJoin('users', 'users.id', '=', 'firma_correo.user_id')
              ->where('users.id',Sentry::getUser()->id)
              ->get();
              //

              $servicio_email = Servicio::find($servicio->id);

              $query_servicio = Servicio::select('servicios.*', 'servicios.fecha_servicio', 'servicios.fecha_solicitud','servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.hora_servicio', 'servicios.pasajeros', 'centrosdecosto.razonsocial', 'vehiculos.clase', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'conductores.nombre_completo', 'conductores.celular')
              ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
              ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
              ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
              ->where('servicios.id',$servicio_email->id)
              ->get();

              $data = [
                'id_servicio' => $servicio->id,
                'servicio' => $servicio_email,
                'email_cliente' => $servicio->email_solicitante,
                'firma' => $query,
                'servicios' => $query_servicio,
              ];

              if($email_cliente==1){
                //ENVÍO DE EMAIL SGS

                $sw = 0;

                if(Input::get('centrodecosto')==343){

                  //$emailcc = Input::get('email_solicitante');//['lgiraldo@coninsa.co', 'llopez@coninsa.co', 'mmoreno@coninsa.co', 'amosorio@coninsa.co', 'dasanchez@coninsa.co', 'sramirez@coninsa.co', 'anaruiz@coninsa.co', 'lfarroyave@coninsa.co', 'asistentecomercial@coninsa.co', 'lctorom@coninsa.co', 'ttobon@coninsa.co', 'tifigueroa@coninsa.co', 'gcardona@coninsa.co', 'dcreyes@coninsa.co'];
                  $emailcc = [Input::get('email_solicitante'), 'dcreyes@coninsa.co'];
                  $email = $email_pasajeros;//'sdgonzalezmendoza@gmail.com';

                  Mail::send('servicios.servicios_ejecutivos.cliente.email_programado', $data, function($message) use ($email, $emailcc){
                    $message->from('no-reply@aotour.com.co', 'AOTOUR');
                    $message->to($email)->subject('Programación de Servicio');
                    $message->cc($emailcc);
                  });

                }else{

                  //start
                  $passengers = explode('/', $servicio->pasajeros);

                  for ($i=0; $i<count($passengers)-1; $i++) {

                    $emai = explode(',', $passengers[$i]);
                    $correoUpdate =  $emai[2];

                    if($correoUpdate!=''){

                      /*Mail::send('emails.email_servicio_gps', $data, function($message) use ($correoUpdate){
                        $message->from('no-reply@aotour.com.co', 'Aotour Notifications');
                        $message->to($correoUpdate)->subject('Programación de Servicio / Service Schedule');
                        $message->cc('transportebogota@aotour.com.co');
                      });*/

                    }

                  }

                  if(Input::get('email_solicitante')!='' and Input::get('email_solicitante')!=null){

                    $data = [
                      'id_servicio' => $servicio->id,
                      'servicio' => $servicio_email,
                      'servicios' => $query_servicio,
                      'fecha_solicitud' => Input::get('fecha_solicitud'),
                      'solicitante' => $servicio_email->solicitado_por
                    ];

                    //$correoUpdate = 'sistemas@aotour.com.co';

                    $correoUpdate = Input::get('email_solicitante');

                    $cc = ['transportebogota@aotour.com.co', 'aotourdeveloper@gmail.com'];
                    //$cc = 'aotourdeveloper@gmail.com';

                    Mail::send('servicios.emails.plantilla', $data, function($message) use ($correoUpdate, $cc){
                      $message->from('no-reply@aotour.com.co', 'Notificaciones Aotour');
                      $message->to($correoUpdate)->subject('Programación de Servicio');
                      $message->bcc($cc);
                    });

                  }

                }

                //$email = $servicio_email->email_solicitante;
              }

              if ($servicio_nuevo->save()) {

                /*NOTIFIVACIÓN PUSHER*/
                //Pusher

                //$sin_programar_baq = ServicioA::whereNull('estado_programado')->where('localidad','barranquilla')->count();

                $canal = 'autonetbog';
                $sin_programar = ServicioA::whereNull('estado_programado')->where('localidad','bogota')->count();

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

                $result = null;

                $number_random = rand(1000000, 9999999);
                if ($notificacion_conductor==1) {
                  Servicio::enviarNotificaciones($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $number_random, $servicio->id);
                }
              }
            }
        }

        return Response::json([
          'response' => true,
          'contador' =>$contador,
          //'sw'=>$sw
        ]);
    }
  }

  public function postCancelarsolicitud(){
    if(Sentry::check()){
      $id_servicio = Input::get('servicio_id');
      $query = ServicioA::find($id_servicio);
      $query->estado_programado = 2;
      if($query->save()){
        return Response::json([
          'response' =>true
        ]);
      }else{
        return Response::json([
          'response' =>false
        ]);
      }
    }
  }
  //NUEVOS SERVICIOS

  public function getPlanderodamiento(){

    $ver = null;

    if (Sentry::check()){

        $rol_id = Sentry::getUser()->id_rol;

        $permisos = json_decode(Rol::find($rol_id)->permisos);

        if (isset($permisos->bogota->servicios->ver)) {

            $ver = $permisos->bogota->servicios->ver;

            if($ver!='on') {

                return Redirect::to('permiso_denegado');

            }else{

              $fecha_inicial = Input::get('fecha_inicial');
              $fecha_final = Input::get('fecha_final');

              $servicios_agrupados = Servicio::select('centrosdecosto.razonsocial', 'nombre_ruta.nombre', 'servicios.ruta_nombre_id',
                      'servicios.recoger_en', 'vehiculos.placa', 'servicios.dejar_en', 'servicios.fecha_servicio',
                      'servicios.hora_servicio', 'servicios.centrodecosto_id')
                      ->leftJoin('nombre_ruta', 'servicios.ruta_nombre_id', '=', 'nombre_ruta.id')
                      ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
                      ->leftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
                      ->whereBetween('fecha_servicio', [$fecha_inicial, $fecha_final])
                      ->where('ruta', 1)
                      ->whereNull('servicios.pendiente_autori_eliminacion')
                      ->whereNull('servicios.afiliado_externo')
                      //->whereNotNull('servicios.ruta_nombre_id')
                      ->groupBy(['servicios.ruta_nombre_id', 'servicios.hora_servicio'])
                      ->orderBy('centrosdecosto.razonsocial')
                      ->orderBy('servicios.hora_servicio')
                      ->orderBy('nombre_ruta.nombre')
                      ->orderBy('servicios.fecha_servicio')
                      ->get();

              $servicios_sin_agrupar = Servicio::select('centrosdecosto.razonsocial', 'nombre_ruta.nombre', 'servicios.ruta_nombre_id',
                      'servicios.recoger_en', 'vehiculos.placa', 'servicios.dejar_en', 'servicios.fecha_servicio', 'servicios.hora_servicio')
                      ->leftJoin('nombre_ruta', 'servicios.ruta_nombre_id', '=', 'nombre_ruta.id')
                      ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
                      ->leftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
                      ->whereBetween('fecha_servicio', [$fecha_inicial, $fecha_final])
                      ->where('ruta', 1)
                      ->whereNull('servicios.pendiente_autori_eliminacion')
                      ->whereNull('servicios.afiliado_externo')
                      ->orderBy('centrosdecosto.razonsocial')
                      ->orderBy('servicios.hora_servicio')
                      ->orderBy('nombre_ruta.nombre')
                      ->orderBy('servicios.fecha_servicio')
                      ->get();

              $fecha_inicial = new DateTime($fecha_inicial);
              $fecha_final = new DateTime($fecha_final);

              $fechas = [$fecha_inicial->format('Y-m-d')];

              while ($fecha_inicial!=$fecha_final) {

                $fecha_inicial->modify('+1 day');
                array_push($fechas, $fecha_inicial->format('Y-m-d'));

              }

              return View::make('servicios.plan_rodamiento', [
                'servicios_agrupados' => $servicios_agrupados,
                'servicios_sin_agrupar' => $servicios_sin_agrupar,
                'fechas' => $fechas,
                'permisos' => $permisos,
                'fecha_inicial' => $fecha_inicial->format('Y-m-d'),
                'fecha_final' => $fecha_final->format('Y-m-d')
              ]);

            }

        }else{

            return Redirect::to('permiso_denegado');
        }

    }else if(!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }

  }

  public function getPoriniciar(){

    if (Sentry::check()){

        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->bogota->servicios->ver;

    }else{
        $ver = null;
    }

    if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on') {

        return View::make('admin.permisos');

    }else{

        $fechaActual = date('Y-m-d');
        $horaActual = date('H:i');

        $query = DB::table('servicios')
            ->leftJoin('reportes_pivote', 'servicios.id', '=', 'reportes_pivote.servicio_id')
            ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
            ->leftJoin('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
            ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
            ->LeftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
            ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
            ->leftJoin('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
            ->leftJoin('users', 'servicios.creado_por', '=', 'users.id')
            ->leftJoin('facturacion', 'servicios.id','=','facturacion.servicio_id')
            ->select('servicios.*',
                 'facturacion.revisado','facturacion.liquidado','facturacion.facturado','facturacion.factura_id',
                 'proveedores.tipo_afiliado', 'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro','users.first_name',
                 'users.last_name',
                 'rutas.nombre_ruta','rutas.codigo_ruta','proveedores.razonsocial AS razonproveedor',
                 'conductores.nombre_completo','conductores.celular','conductores.telefono','conductores.usuario_id',
                 'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo')
            ->where('servicios.anulado',0)
            //->whereIn('centrosdecosto.localidad',['bogota','provisional'])
            //->whereIn('users.localidad',['2','3'])
            ->whereNotNull('servicios.localidad')
            ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
            ->whereNull('servicios.pendiente_autori_eliminacion')
            ->whereNull('servicios.afiliado_externo')
            ->where('fecha_servicio',date('Y-m-d'));
            //->whereNull('servicios.ruta');

        /**
         * [$servicios description]
         * @var [type]
         */

          //MODIFICICACIÓN PARA QUE OPERACIONES NO VISUALICE LOS SERVICIOS MONTADOS POR FACTURACION
          //SE AGREGÓ EL CAMPO CONTROL FACTURACION
          if($id_rol==1 or $id_rol==2 or $id_rol==8){
              $servicios = $query->orderBy('hora_servicio', 'ASC')->get();
          }else{
              $servicios = $query->whereNull('servicios.control_facturacion')->orderBy('hora_servicio', 'ASC')->get();
          }

        $o = 1;

        return View::make('servicios.por_iniciar', [
          'servicios' => $servicios,
          'permisos' => $permisos,
          'o' => $o,
          'fechaActual' => $fechaActual,
          'horaActual' => $horaActual
        ]);

    }

  }

  public function postBuscarordenesporiniciar(){

      $id_rol = Sentry::getUser()->id_rol;
      $id_usuario = Sentry::getUser()->id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      if (!Sentry::check()){

        return Response::json([
          'respuesta'=>'relogin'
        ]);

      }else{

        if (Request::ajax()){

          $fechaActual = date('Y-m-d');
          $horaActual = date('H:i');

          $consulta = "select servicios.id, servicios.fecha_servicio, ".
            "servicios.ruta, servicios.localidad, ".
            "servicios.pendiente_autori_eliminacion, ".
            "servicios.hora_servicio, ".
            "servicios.estado_servicio_app, ".
            "servicios.control_facturacion, servicios.aceptado_app, ".
            "centrosdecosto.razonsocial, reconfirmacion.numero_reconfirmaciones, ".
            "conductores.nombre_completo, conductores.celular, conductores.usuario_id ".

            "from servicios ".

            "left join conductores on servicios.conductor_id = conductores.id ".
            "left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id ".
            "left join reconfirmacion on servicios.id = reconfirmacion.id_servicio ".
            "where servicios.fecha_servicio between '".$fechaActual."' AND '".$fechaActual."' and servicios.localidad IS NOT NULL AND servicios.estado_servicio_app IS NULL and servicios.hora_servicio > '".$horaActual."'";

          $servicios = DB::select(DB::raw($consulta." and servicios.pendiente_autori_eliminacion is null ORDER BY hora_servicio ASC"));

            if ($servicios!=null) {

                return Response::json([
                    'mensaje'=>true,
                    'servicios'=>$servicios,
                    'fechaActual' => $fechaActual,
                    'horaActual' => $horaActual
                ]);

            }else{

                return Response::json([
                    'mensaje'=>false,
                    'consulta'=>$consulta,
                    'horaActual' => $horaActual
                ]);
            }
        }
      }
  }

  public function getOrdenes(){

    if (Sentry::check()){

        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->bogota->servicios->ver;

    }else{
        $ver = null;
    }

    if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on') {

        return View::make('admin.permisos');

    }else{

        $fechaActual = date('Y-m-d');
        $horaActual = date('H:i');

        $query = DB::table('servicios')
            ->leftJoin('reportes_pivote', 'servicios.id', '=', 'reportes_pivote.servicio_id')
            ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
            ->leftJoin('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
            ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
            ->LeftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
            ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
            ->leftJoin('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
            ->leftJoin('users', 'servicios.creado_por', '=', 'users.id')
            ->leftJoin('facturacion', 'servicios.id','=','facturacion.servicio_id')
            ->select('servicios.*',
                 'facturacion.revisado','facturacion.liquidado','facturacion.facturado','facturacion.factura_id',
                 'proveedores.tipo_afiliado', 'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro','users.first_name',
                 'users.last_name',
                 'rutas.nombre_ruta','rutas.codigo_ruta','proveedores.razonsocial AS razonproveedor',
                 'conductores.nombre_completo','conductores.celular','conductores.telefono','conductores.usuario_id',
                 'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo')
            ->where('servicios.anulado',0)
            //->whereIn('centrosdecosto.localidad',['bogota','provisional'])
            //->whereIn('users.localidad',['2','3'])
            ->where('servicios.localidad', 1)
            ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
            ->whereNull('servicios.pendiente_autori_eliminacion')
            ->whereNull('servicios.afiliado_externo')
            ->where('fecha_servicio',date('Y-m-d'));
            //->whereNull('servicios.ruta');

        /**
         * [$servicios description]
         * @var [type]
         */

          //MODIFICICACIÓN PARA QUE OPERACIONES NO VISUALICE LOS SERVICIOS MONTADOS POR FACTURACION
          //SE AGREGÓ EL CAMPO CONTROL FACTURACION
          if($id_rol==1 or $id_rol==2 or $id_rol==8){
              $servicios = $query->orderBy('hora_servicio', 'ASC')->get();
          }else{
              $servicios = $query->whereNull('servicios.control_facturacion')->orderBy('hora_servicio', 'ASC')->get();
          }

        $o = 1;

        return View::make('servicios.ordenes', [
          'servicios' => $servicios,
          'permisos' => $permisos,
          'o' => $o,
          'fechaActual' => $fechaActual,
          'horaActual' => $horaActual
        ]);

    }

  }

  public function postDocumentacionemail(){

    $conductores = Conductor::whereHas('proveedor', function($query){

      $query->whereNull('eventual')->whereNull('inactivo_total');

    })->noarchivado()->whereNull('bloqueado_total')->whereNull('bloqueado')->orderBy('nombre_completo')->get();

    //CONSULTA DE DOCUMENTACIÓN CONDUCTORES

    ##CANTIDAD DE DOCUMENTOS POR VENCER POR TODOS LOS CONDUCTORES
    $documentos_por_vencer = 0;
    $documentos_vencidos = 0;
    $total_conductores = 0;
    #CANTIDAD DE CONDUCTORES QUE NO TIENEN SEGURIDAD SOCIAL
    $contar_seguridad = 0;
    foreach($conductores as $conductor){
        if($conductor->nombre_completo){
            $date = date('Y-m-d');
            $i = 0;
            $seguridad_social = null;
            $estado_ssocial = null;

            $ss = "select seguridad_social.fecha_inicial, seguridad_social.fecha_final from seguridad_social where conductor_id = ".$conductor->id." and '".$date."' between fecha_inicial and fecha_final ";
            $ss = DB::select($ss);

            if($ss!=null){
              $sietedias = strtotime ('+7 day', strtotime($date));
              $fechaMasSieteDias = date('Y-m-d' , $sietedias);

              $sele = DB::table('seguridad_social')
              ->where('conductor_id',$conductor->id)
              ->where('fecha_final', '<=', $fechaMasSieteDias)
              ->where('fecha_final', '>=', $date)
              ->first();

              if($sele!=null){
                $documentos_por_vencer++;
                $total_conductores++;
              }
            }else{
              $contar_seguridad++;
            }

            ##CANTIDAD DE DOCUMENTOS VENCIDOS POR CONDUCTOR
            $documentos_vencidos_por_conductor = 0;
            ##CANTIDAD DE DOCUMENTOS POR VENCER POR CONDUCTOR
            $documentos_por_vencer_por_conductor = 0;
            $licencia_conduccion = floor((strtotime($conductor->fecha_licencia_vigencia)-strtotime(date('Y-m-d')))/86400);
            //DIA ACTUAL
            $fecha_actual = intval(date('d'));
            ##CANTIDAD DE CONDUCTORES QUE TIENEN DOCUMENTOS VENCIDOS
            if ($licencia_conduccion<0){
                $documentos_vencidos_por_conductor++;
                $documentos_vencidos++;
            }

            ##CANTIDAD DE CONDUCTORES QUE TIENEN DOCUMENTOS POR VENCER
            if (($licencia_conduccion>=0 && $licencia_conduccion<=7))
            {
                $documentos_por_vencer++;
                $documentos_por_vencer_por_conductor++;
                if(!$ss!=null){
                  $total_conductores++;
                }
            }

        }
    }

    //DOCUMENTACIÓN POR VENCER DE LOS VEHÍCULOS

    #CANTIDAD DE VEHICULOS CON DOCUMENTOS VENCIDOS
    $documentos_vehiculos_vencidos = 0;

    ##CANTIDAD DE VEHICULOS CON DOCUMENTOS POR VENCER
    $documentos_vehiculos_por_vencer = 0;

    ##CANTIDAD DE DOCUMENTOS POR VENCER POR VEHICULO
    $cantidad_documentos_por_vencer = 0;

    ##CANTIDAD DE DOCUMENTOS VENCIDOS POR VEHICULO
    $documentos_vencidos_por_vehiculos = 0;

    //Inicializar todas las variables
    $tarjeta_operacion = null;
    $mantenimiento_preventivo = null;
    $soat = null;
    $tecnomecanica = null;
    $poliza_extracontractual = null;
    $poliza_contractual = null;

    $i = 0;

    $total_vehiculos = 0;
    $sw = 0;

    ##CANTIDAD DE DOCUMENTOS
    $documentos_vencidos_por_vehiculos = 0;
    $cantidad_documentos_por_vencer = 0;

    $vehiculos = Vehiculo::whereHas('proveedor', function($query){

      $query->whereNull('eventual')->whereNull('inactivo_total');

    })->noarchivado()->whereNull('bloqueado_total')->whereNull('bloqueado')->orderBy('placa')->get();

    foreach($vehiculos as $vehiculo){

      $sw = 0;

      $tarjeta_operacion = floor((strtotime($vehiculo->fecha_vigencia_operacion)-strtotime(date('Y-m-d')))/86400);
      $soat = floor((strtotime($vehiculo->fecha_vigencia_soat)-strtotime(date('Y-m-d')))/86400);
      $tecnomecanica = floor((strtotime($vehiculo->fecha_vigencia_tecnomecanica)-strtotime(date('Y-m-d')))/86400);
      $mantenimiento_preventivo = floor((strtotime($vehiculo->mantenimiento_preventivo)-strtotime(date('Y-m-d')))/86400);
      $poliza_contractual = floor((strtotime($vehiculo->poliza_contractual)-strtotime(date('Y-m-d')))/86400);
      $poliza_extracontractual = floor((strtotime($vehiculo->poliza_extracontractual)-strtotime(date('Y-m-d')))/86400);

      ##CANTIDAD DE VEHICULOS QUE TIENEN DOCUMENTOS VENCIDOS
      if ($tarjeta_operacion<0 or $soat<0 or $tecnomecanica<0 or $mantenimiento_preventivo<0
              or $poliza_contractual<0 or $poliza_extracontractual<0){
          $documentos_vehiculos_vencidos++;
      }

      ##CANTIDAD DE VEHICULOS QUE TIENEN DOCUMENTOS POR VENCER
      if (($tarjeta_operacion>=0 && $tarjeta_operacion<=7) or
              ($soat>=0 && $soat<=7) or
              ($tecnomecanica>=0 && $tecnomecanica<=7) or
              ($mantenimiento_preventivo>=0 && $mantenimiento_preventivo<=7) or
              ($poliza_contractual>=0 && $poliza_contractual<=7) or
              ($poliza_extracontractual>=0 && $poliza_extracontractual<=7))
      {
          $documentos_vehiculos_por_vencer++;
      }

      ##TARJETA DE OPERACION VENCIDA
      if ($tarjeta_operacion<0){
          $documentos_vencidos_por_vehiculos++;
      }

      if ($tarjeta_operacion>=0 && $tarjeta_operacion<=7){
          $cantidad_documentos_por_vencer++;
          $sw = 1;
      }

      ##SOAT
      if ($soat<0){
          $documentos_vencidos_por_vehiculos++;
      }

      if ($soat>=0 && $soat<=7){
          $cantidad_documentos_por_vencer++;
          $sw = 1;
      }

      ##TECNOMECANICA
      if($tecnomecanica<0){
          $documentos_vencidos_por_vehiculos++;
      }

      if ($tecnomecanica>=0 && $tecnomecanica<=7){
          $cantidad_documentos_por_vencer++;
          $sw = 1;
      }

      ##MANTENIMIENTO PREVENTIVO
      if($mantenimiento_preventivo<0){
          $documentos_vencidos_por_vehiculos++;
      }

      if ($mantenimiento_preventivo>=0 && $mantenimiento_preventivo<=7){
          $cantidad_documentos_por_vencer++;
          $sw = 1;
      }

      ##POLIZA CONTRACTUAL
      if($poliza_contractual<0){
          $documentos_vencidos_por_vehiculos++;
      }

      if ($poliza_contractual>=0 && $poliza_contractual<=7){
          $cantidad_documentos_por_vencer++;
          $sw = 1;
      }

      ##POLIZA EXTRACONTRACTUAL
      if($poliza_extracontractual<0){
          $documentos_vencidos_por_vehiculos++;
      }

      if ($poliza_contractual>=0 && $poliza_contractual<=7){
          $cantidad_documentos_por_vencer++;
          $sw = 1;
      }

      if($sw==1){
        $total_vehiculos++;


      }
    }

    $alerta = DB::table('alerta_documentacion')
    ->where('id',1)
    ->pluck('fecha');

    if($total_conductores>0 and $alerta<date('Y-m-d')){

      $email = 'juridica@aotour.com.co';
      //$email = 'sistemas@aotour.com.co';

      $data = [
        'cantidad_conductores' => $total_conductores
      ];

      Mail::send('emails.documentacion_por_vencer_conductores', $data, function($message) use ($email){
        $message->from('no-reply@aotour.com.co', 'AUTONET');
        $message->to($email)->subject('Documentación por Vencer - Conductores');
      });

      //ENVÍO DE EMAIL AL PROVEEDOR DE DOCUMENTACIÓN VENCIDA DE SU CONDUCTOR
      foreach($conductores as $conductor){
          if($conductor->nombre_completo){
              $date = date('Y-m-d');
              $i = 0;
              $seguridad_social = null;
              $estado_ssocial = null;

              $ss = "select seguridad_social.fecha_inicial, seguridad_social.fecha_final from seguridad_social where conductor_id = ".$conductor->id." and '".$date."' between fecha_inicial and fecha_final ";
              $ss = DB::select($ss);

              if($ss!=null){
                $sietedias = strtotime ('+7 day', strtotime($date));
                $fechaMasSieteDias = date('Y-m-d' , $sietedias);

                /*$sele = DB::table('seguridad_social')
                ->where('conductor_id',$conductor->id)
                ->where('fecha_final', '<=', $fechaMasSieteDias)
                ->where('fecha_final', '>=', $date)
                ->first();*/

                $sele = DB::table('seguridad_social')
                ->where('conductor_id',$conductor->id)
                ->orderBy('id', 'DESC')
                ->first();

                if( $sele->fecha_final<=$fechaMasSieteDias and $sele->fecha_final>=$date ){

                  $documentos_por_vencer++;
                  $total_conductores++;

                  $texts ="<li>El ".$sele->fecha_final." vence la <b>SEGURIDAD SOCIAL</b> de tu conductor <b>".$conductor->nombre_completo."</b></li>";

                  $email = DB::table('proveedores')
                  ->where('id',$conductor->proveedores_id)
                  ->pluck('email');

                  //$email = 'sistemas@aotour.com.co';

                  if( isset($email) and filter_var($email, FILTER_VALIDATE_EMAIL) ){

                    $data = [
                      'texts' => $texts
                    ];

                    Mail::send('emails.documento_por_vencer', $data, function($message) use ($email){
                      $message->from('no-reply@aotour.com.co', 'AUTONET');
                      $message->to($email)->subject('Documentación por Vencer - Conductor');
                      $message->cc('aotourdeveloper@gmail.com');
                    });

                  }

                }
              }else{
                $contar_seguridad++;
              }

              ##CANTIDAD DE DOCUMENTOS VENCIDOS POR CONDUCTOR
              $documentos_vencidos_por_conductor = 0;
              ##CANTIDAD DE DOCUMENTOS POR VENCER POR CONDUCTOR
              $documentos_por_vencer_por_conductor = 0;
              $licencia_conduccion = floor((strtotime($conductor->fecha_licencia_vigencia)-strtotime(date('Y-m-d')))/86400);
              //DIA ACTUAL
              $fecha_actual = intval(date('d'));
              ##CANTIDAD DE CONDUCTORES QUE TIENEN DOCUMENTOS VENCIDOS
              if ($licencia_conduccion<0){
                  $documentos_vencidos_por_conductor++;
                  $documentos_vencidos++;
              }

              ##CANTIDAD DE CONDUCTORES QUE TIENEN DOCUMENTOS POR VENCER
              if (($licencia_conduccion>=0 && $licencia_conduccion<=7))
              {
                  $documentos_por_vencer++;
                  $documentos_por_vencer_por_conductor++;

                  if(!$ss!=null){
                    $total_conductores++;
                  }

                  $texts ="<li>En ".$licencia_conduccion." días vence la <b>LICENCIA DE CONDUCCIÓN</b> de tu conductor <b>".$conductor->nombre_completo."</b></li>";

                  $email = DB::table('proveedores')
                  ->where('id',$conductor->proveedores_id)
                  ->pluck('email');

                  //$email = 'sistemas@aotour.com.co';

                  if( isset($email) and filter_var($email, FILTER_VALIDATE_EMAIL) ){

                    $data = [
                      'texts' => $texts
                    ];

                    Mail::send('emails.documento_por_vencer', $data, function($message) use ($email){
                      $message->from('no-reply@aotour.com.co', 'AUTONET');
                      $message->to($email)->subject('Documentación por Vencer - Conductor');
                      $message->cc('aotourdeveloper@gmail.com');
                    });

                  }

              }

          }
      }

    }

    if($total_vehiculos>0 and $alerta<date('Y-m-d')){

      $email = 'juridica@aotour.com.co';
      //$email = 'sistemas@aotour.com.co';

      $data = [
        'cantidad_vehiculos' => $total_vehiculos
      ];

      Mail::send('emails.documentacion_por_vencer_vehiculos', $data, function($message) use ($email){
        $message->from('no-reply@aotour.com.co', 'AUTONET');
        $message->to($email)->subject('Documentación por Vencer - Vehículos');
      });

      //PT2 ENVÍO DE NOTIFICACIÓN A LOS PROVEEDORES
      foreach($vehiculos as $vehiculo){

        $sw = 0;

        $tarjeta_operacion = floor((strtotime($vehiculo->fecha_vigencia_operacion)-strtotime(date('Y-m-d')))/86400);
        $soat = floor((strtotime($vehiculo->fecha_vigencia_soat)-strtotime(date('Y-m-d')))/86400);
        $tecnomecanica = floor((strtotime($vehiculo->fecha_vigencia_tecnomecanica)-strtotime(date('Y-m-d')))/86400);
        $mantenimiento_preventivo = floor((strtotime($vehiculo->mantenimiento_preventivo)-strtotime(date('Y-m-d')))/86400);
        $poliza_contractual = floor((strtotime($vehiculo->poliza_contractual)-strtotime(date('Y-m-d')))/86400);
        $poliza_extracontractual = floor((strtotime($vehiculo->poliza_extracontractual)-strtotime(date('Y-m-d')))/86400);

        ##CANTIDAD DE VEHICULOS QUE TIENEN DOCUMENTOS VENCIDOS
        if ($tarjeta_operacion<0 or $soat<0 or $tecnomecanica<0 or $mantenimiento_preventivo<0
                or $poliza_contractual<0 or $poliza_extracontractual<0){
            $documentos_vehiculos_vencidos++;
        }

        ##CANTIDAD DE VEHICULOS QUE TIENEN DOCUMENTOS POR VENCER
        if (($tarjeta_operacion>=0 && $tarjeta_operacion<=7) or
                ($soat>=0 && $soat<=7) or
                ($tecnomecanica>=0 && $tecnomecanica<=7) or
                ($mantenimiento_preventivo>=0 && $mantenimiento_preventivo<=7) or
                ($poliza_contractual>=0 && $poliza_contractual<=7) or
                ($poliza_extracontractual>=0 && $poliza_extracontractual<=7))
        {
            $documentos_vehiculos_por_vencer++;
        }

        ##TARJETA DE OPERACION VENCIDA
        if ($tarjeta_operacion<0){
            $documentos_vencidos_por_vehiculos++;
        }

        if ($tarjeta_operacion>=0 && $tarjeta_operacion<=7){
            $cantidad_documentos_por_vencer++;
            $sw = 1;
        }

        ##SOAT
        if ($soat<0){
            $documentos_vencidos_por_vehiculos++;
        }

        if ($soat>=0 && $soat<=7){
            $cantidad_documentos_por_vencer++;
            $sw = 1;
        }

        ##TECNOMECANICA
        if($tecnomecanica<0){
            $documentos_vencidos_por_vehiculos++;
        }

        if ($tecnomecanica>=0 && $tecnomecanica<=7){
            $cantidad_documentos_por_vencer++;
            $sw = 1;
        }

        ##MANTENIMIENTO PREVENTIVO
        if($mantenimiento_preventivo<0){
            $documentos_vencidos_por_vehiculos++;
        }

        if ($mantenimiento_preventivo>=0 && $mantenimiento_preventivo<=7){
            $cantidad_documentos_por_vencer++;
            $sw = 1;
        }

        ##POLIZA CONTRACTUAL
        if($poliza_contractual<0){
            $documentos_vencidos_por_vehiculos++;
        }

        if ($poliza_contractual>=0 && $poliza_contractual<=7){
            $cantidad_documentos_por_vencer++;
            $sw = 1;
        }

        ##POLIZA EXTRACONTRACTUAL
        if($poliza_extracontractual<0){
            $documentos_vencidos_por_vehiculos++;
        }

        if ($poliza_contractual>=0 && $poliza_contractual<=7){
            $cantidad_documentos_por_vencer++;
            $sw = 1;
        }

        if($sw==1){
          $total_vehiculos++;

          $texts = '';

          if ($tarjeta_operacion>=0 && $tarjeta_operacion<=7){
              $texts .="<li>En ".$tarjeta_operacion." días se vence la <b>TARJETA DE OPERACIÓN</b> de tu vehículo de placas <b>".$vehiculo->placa."</b></li>";
          }

          if ($soat>=0 && $soat<=7){ //SOAT
              $texts .="<li>En ".$soat." días se vence el <b>SOAT</b> de tu vehículo de placas <b>".$vehiculo->placa."</b></li>";
          }

          if ($tecnomecanica>=0 && $tecnomecanica<=7){
            $texts .="<li>En ".$tecnomecanica." días se vence la <b>TECNOMECÁNICA</b> de tu vehículo de placas <b>".$vehiculo->placa."</b></li>";
          }

          if ($mantenimiento_preventivo>=0 && $mantenimiento_preventivo<=7){
            $texts .="<li>En ".$mantenimiento_preventivo." días se vence el <b>MANTENIMIENTO PREVENTIVO</b> de tu vehículo de placas <b>".$vehiculo->placa."</b></li>";
          }

          if ($poliza_contractual>=0 && $poliza_contractual<=7){
            $texts .="<li>En ".$poliza_contractual." días se vence la <b>POLIZA CONTRACTUAL</b> de tu vehículo de placas <b>".$vehiculo->placa."</b></li>";
          }

          if ($poliza_extracontractual>=0 && $poliza_extracontractual<=7){
            $texts .="<li>En ".$poliza_extracontractual." días se vence la <b>POLIZA EXTRACONTRACTUAL</b> de tu vehículo de placas <b>".$vehiculo->placa."</b></li>";
          }

          if($texts != ''){ //Envío de email con los documentos por vencer

            $email = DB::table('proveedores')
            ->where('id',$vehiculo->proveedores_id)
            ->pluck('email');

            //$email = 'sistemas@aotour.com.co';

            if(isset($email) and filter_var($email, FILTER_VALIDATE_EMAIL)){

              $data = [
                'texts' => $texts
              ];

              Mail::send('emails.documento_por_vencer', $data, function($message) use ($email){
                $message->from('no-reply@aotour.com.co', 'AUTONET');
                $message->to($email)->subject('Documentación por Vencer - Vehículo');
                $message->cc('aotourdeveloper@gmail.com');
              });

            }

          }

        }
      }

    }

    $update = DB::table('alerta_documentacion')
    ->where('id',1)
    ->update([
      'fecha' => date('Y-m-d')
    ]);

    return Response::json([
      'mensaje'=>false,
      //'consulta'=>$consulta2,
      //'subcentro'=>$subcentro,
      //'horaActual' => $horaActual,
      //'hoy' => $hoy,
      //'ayer' => $ayer,
      //'documentos_por_vencer' => $documentos_por_vencer,
      //'documentos_vencidos' => $documentos_vencidos,
      'total_conductores' => $total_conductores,
      //'fechaMasSieteDias' => $fechaMasSieteDias,
      'total_vehiculos' => $total_vehiculos
    ]);

  }

  public function postBuscarordenes(){

      $id_rol = Sentry::getUser()->id_rol;
      $id_usuario = Sentry::getUser()->id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          if (Request::ajax()){

              $fechaActual = date('Y-m-d H:i');//'2022-05-04 11:21';//

              $horaActual = date('H:i');

              /*1 HORA END*/
              $fechaMinima = date('Y-m-d');
              $horaMinima = date('H:i');
              $fechaMaxima = date('Y-m-d',strtotime('+90 minute',strtotime($fechaActual)));
              $horaMaxima = date('H:i',strtotime('+90 minute',strtotime($horaActual)));

              $consulta2 = "SELECT servicios.id, servicios.pasajeros, servicios.app_user_id, servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.conductor_id, servicios.centrodecosto_id, servicios.aceptado_app, servicios.estado_servicio_app, servicios.pendiente_autori_eliminacion, servicios.ruta, servicios.localidad, servicios.recoger_en, servicios.dejar_en, servicios.estado_km, reconfirmacion.reconfirmacion1hrs, centrosdecosto.razonsocial as razonsocial, conductores.nombre_completo, conductores.celular FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join reconfirmacion on reconfirmacion.id_servicio = servicios.id left join conductores on conductores.id = servicios.conductor_id WHERE servicios.fecha_servicio between '".$fechaMinima."' and '".$fechaMaxima."' AND servicios.hora_servicio >= '".$horaMinima."' AND servicios.hora_servicio <= '".$horaMaxima."' AND servicios.estado_servicio_app IS NULL and servicios.pendiente_autori_eliminacion is null AND reconfirmacion.novedad_1 is null and servicios.localidad is not null order by servicios.fecha_servicio asc, servicios.hora_servicio asc";

              $servicios = DB::select($consulta2);
              $cantidad = count($servicios);

              //Si hay servicios, notificar al conductor y crear el registro de notificar START
              if($servicios){

                foreach ($servicios as $bucle) {
                  if($bucle->reconfirmacion1hrs!=null){

                  }else{
                    $message = '1 Hora';
                    Servicio::Notificarparaconfirmar($bucle->conductor_id, $bucle->fecha_servicio, $bucle->hora_servicio, $bucle->recoger_en, $bucle->dejar_en, $message, $bucle->id);

                    $reconfirmador = new Reconfirmacion();
                    $reconfirmador->reconfirmacion1hrs = date('H:i:s');
                    $reconfirmador->reconfirmado_por = Sentry::getUser()->id;
                    $reconfirmador->id_servicio = $bucle->id;
                    $reconfirmador->save();

                  }
                }
              }
              //Si hay servicios, notificar al conductor y crear el registro de notificar END

                //if($cantidad==0){

                  /*30 MINUTOS END*/
                  $fechaMinima = date('Y-m-d');
                  $horaMinima = date('H:i');
                  $fechaMaxima = date('Y-m-d',strtotime('+45 minute',strtotime($fechaActual)));
                  $horaMaxima = date('H:i',strtotime('+45 minute',strtotime($horaActual)));

                  $consulta2 = "SELECT servicios.id, servicios.pasajeros, servicios.app_user_id, servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.conductor_id, servicios.centrodecosto_id, servicios.aceptado_app, servicios.estado_servicio_app, servicios.pendiente_autori_eliminacion, servicios.ruta, servicios.localidad, servicios.recoger_en, servicios.dejar_en, servicios.estado_km, reconfirmacion.reconfirmacion30min, centrosdecosto.razonsocial as razonsocial, conductores.nombre_completo, conductores.celular FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join reconfirmacion on reconfirmacion.id_servicio = servicios.id left join conductores on conductores.id = servicios.conductor_id WHERE servicios.fecha_servicio between '".$fechaMinima."' and '".$fechaMaxima."' AND servicios.hora_servicio >= '".$horaMinima."' AND servicios.hora_servicio <= '".$horaMaxima."' AND servicios.estado_servicio_app IS NULL and servicios.pendiente_autori_eliminacion is null AND reconfirmacion.novedad_30 is null and servicios.localidad is not null order by servicios.fecha_servicio asc, servicios.hora_servicio asc";

                  $servicios1 = DB::select($consulta2);
                  $cantidad1 = count($servicios1);

                  //Si hay servicios, notificar al conductor y crear el registro de notificar START
                  if($servicios1){

                    foreach ($servicios1 as $bucle) {
                      if($bucle->reconfirmacion30min!=null){ //Ya se envió la notificación

                      }else{ //Notificación no enviada, enviarla!
                        $message = '30 Minutos';
                        Servicio::Notificarparaconfirmar($bucle->conductor_id, $bucle->fecha_servicio, $bucle->hora_servicio, $bucle->recoger_en, $bucle->dejar_en, $message, $bucle->id);

                        $reconfirmador = DB::table('reconfirmacion')
                        ->where('id_servicio',$bucle->id)
                        ->update([
                          'reconfirmacion30min' => date('H:i:s'),
                          'reconfirmado_por' => Sentry::getUser()->id
                        ]);

                      }
                    }
                  }

                  //if($cantidad==0){ // ¡Si cantidad es mayor a cero, se encontraron mas de un servicio!
                    /*15 MINUTOS END*/
                    $fechaMinima = date('Y-m-d');
                    $horaMinima = date('H:i');
                    $fechaMaxima = date('Y-m-d',strtotime('+15 minute',strtotime($fechaActual)));
                    $horaMaxima = date('H:i',strtotime('+15 minute',strtotime($horaActual)));

                    $consulta2 = "SELECT servicios.id, servicios.pasajeros, servicios.app_user_id, servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.conductor_id, servicios.centrodecosto_id, servicios.aceptado_app, servicios.estado_servicio_app, servicios.pendiente_autori_eliminacion, servicios.ruta, servicios.localidad, servicios.recoger_en, servicios.dejar_en, servicios.estado_km, reconfirmacion.reconfirmacion_horacita, centrosdecosto.razonsocial as razonsocial, conductores.nombre_completo, conductores.celular FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join reconfirmacion on reconfirmacion.id_servicio = servicios.id left join conductores on conductores.id = servicios.conductor_id WHERE servicios.fecha_servicio between '".$fechaMinima."' and '".$fechaMaxima."' AND servicios.hora_servicio >= '".$horaMinima."' AND servicios.hora_servicio <= '".$horaMaxima."' AND servicios.estado_servicio_app IS NULL and servicios.pendiente_autori_eliminacion is null AND reconfirmacion.novedad_hora is null and servicios.localidad is not null order by servicios.fecha_servicio asc, servicios.hora_servicio asc";

                    $servicios2 = DB::select($consulta2);
                    $cantidad2 = count($servicios2);

                    //Si hay servicios, notificar al conductor y crear el registro de notificar START
                    if($servicios2){

                      foreach ($servicios2 as $bucle) {
                        if($bucle->reconfirmacion_horacita!=null){ //Ya se envió la notificación

                        }else{ //Notificación no enviada, enviarla!
                          $message = '15 Minutos';
                          Servicio::Notificarparainiciar($bucle->conductor_id, $bucle->fecha_servicio, $bucle->hora_servicio, $bucle->recoger_en, $bucle->dejar_en, $message, $bucle->id);

                          $reconfirmador = DB::table('reconfirmacion')
                          ->where('id_servicio',$bucle->id)
                          ->update([
                            'reconfirmacion_horacita' => date('H:i:s'),
                            'reconfirmado_por' => Sentry::getUser()->id
                          ]);

                        }
                      }
                    }
                    //Si hay servicios, notificar al conductor y crear el registro de notificar END

                  //}

                //}

              //}

              if ($servicios!=null or $servicios1!=null or $servicios2!=null) {

                /*1 HORA END*/
                $fechaMinima = date('Y-m-d');
                $horaMinima = date('H:i');
                $fechaMaxima = date('Y-m-d',strtotime('+90 minute',strtotime($fechaActual)));
                $horaMaxima = date('H:i',strtotime('+90 minute',strtotime($horaActual)));

                $consulta3 = "SELECT servicios.id, servicios.pasajeros, servicios.app_user_id, servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.conductor_id, servicios.centrodecosto_id, servicios.aceptado_app, servicios.estado_servicio_app, servicios.pendiente_autori_eliminacion, servicios.ruta, servicios.localidad, servicios.recoger_en, servicios.dejar_en, servicios.estado_km, reconfirmacion.reconfirmacion1hrs, centrosdecosto.razonsocial as razonsocial, conductores.nombre_completo, conductores.celular FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join reconfirmacion on reconfirmacion.id_servicio = servicios.id left join conductores on conductores.id = servicios.conductor_id WHERE servicios.fecha_servicio between '".$fechaMinima."' and '".$fechaMaxima."' AND servicios.hora_servicio >= '".$horaMinima."' AND servicios.hora_servicio <= '".$horaMaxima."' AND servicios.estado_servicio_app IS NULL and servicios.pendiente_autori_eliminacion is null AND (reconfirmacion.novedad_1 is null OR reconfirmacion.novedad_30 is null) and servicios.localidad is not null order by servicios.fecha_servicio asc, servicios.hora_servicio asc";

                $servicios = DB::select($consulta3);
                $cantidad = count($servicios);
                //Si hay servicios, notificar al conductor y crear el registro de notificar

                return Response::json([
                  'mensaje'=>true,
                  'servicios'=>$servicios,
                  'servicios1'=>$servicios1,
                  'servicios2'=>$servicios2,
                  'fechaActual' => $fechaActual,
                  'horaActual' => $horaActual,
                  'cantidad' => $cantidad
                ]);

              }else{

                return Response::json([
                  'mensaje'=>false,
                  'consulta'=>$consulta2,
                  //'subcentro'=>$subcentro,
                  'horaActual' => $horaActual
                ]);
              }
          }
      }
  }
  /*public function postBuscarordenes(){

      $id_rol = Sentry::getUser()->id_rol;
      $id_usuario = Sentry::getUser()->id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          if (Request::ajax()){

              $fechaActual = date('Y-m-d H:i');//'2022-05-04 11:21';//

              $horaActual = date('H:i');


              $fechaMinima = date('Y-m-d');
              $horaMinima = date('H:i');
              $fechaMaxima = date('Y-m-d',strtotime('+120 minute',strtotime($fechaActual)));
              $horaMaxima = date('H:i',strtotime('+120 minute',strtotime($fechaActual)));

              $consulta2 = "SELECT servicios.id, servicios.pasajeros, servicios.app_user_id, servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.conductor_id, servicios.centrodecosto_id, servicios.aceptado_app, servicios.estado_servicio_app, servicios.pendiente_autori_eliminacion, servicios.ruta, servicios.localidad, servicios.recoger_en, servicios.dejar_en, servicios.estado_km, reconfirmacion.reconfirmacion2hrs, centrosdecosto.razonsocial as razonsocial, conductores.nombre_completo, conductores.celular FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join reconfirmacion on reconfirmacion.id_servicio = servicios.id left join conductores on conductores.id = servicios.conductor_id WHERE servicios.fecha_servicio between '".$fechaMinima."' and '".$fechaMaxima."' AND servicios.hora_servicio >= '".$horaMinima."' AND servicios.hora_servicio <= '".$horaMaxima."' AND (servicios.estado_servicio_app IS NULL OR servicios.estado_servicio_app <> 2) and servicios.pendiente_autori_eliminacion is null AND reconfirmacion.reconfirmacion2hrs is null and servicios.localidad = 1 order by servicios.fecha_servicio asc, servicios.hora_servicio asc";

              $servicios = DB::select($consulta2);
              $cantidad = count($servicios);

              if($cantidad==0){


                $fechaMinima = date('Y-m-d');
                $horaMinima = date('H:i');
                $fechaMaxima = date('Y-m-d',strtotime('+60 minute',strtotime($fechaActual)));
                $horaMaxima = date('H:i',strtotime('+60 minute',strtotime($fechaActual)));

                $consulta2 = "SELECT servicios.id, servicios.pasajeros, servicios.app_user_id, servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.conductor_id, servicios.centrodecosto_id, servicios.aceptado_app, servicios.estado_servicio_app, servicios.pendiente_autori_eliminacion, servicios.ruta, servicios.localidad, servicios.recoger_en, servicios.dejar_en, servicios.estado_km, reconfirmacion.reconfirmacion2hrs, centrosdecosto.razonsocial as razonsocial, conductores.nombre_completo, conductores.celular FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join reconfirmacion on reconfirmacion.id_servicio = servicios.id left join conductores on conductores.id = servicios.conductor_id WHERE servicios.fecha_servicio between '".$fechaMinima."' and '".$fechaMaxima."' AND servicios.hora_servicio >= '".$horaMinima."' AND servicios.hora_servicio <= '".$horaMaxima."' AND (servicios.estado_servicio_app IS NULL OR servicios.estado_servicio_app <> 2) and servicios.pendiente_autori_eliminacion is null AND reconfirmacion.reconfirmacion1hrs is null and servicios.localidad = 1 order by servicios.fecha_servicio asc, servicios.hora_servicio asc";

                $servicios = DB::select($consulta2);
                $cantidad = count($servicios);

                if($cantidad==0){


                  $fechaMinima = date('Y-m-d');
                  $horaMinima = date('H:i');
                  $fechaMaxima = date('Y-m-d',strtotime('+30 minute',strtotime($fechaActual)));
                  $horaMaxima = date('H:i',strtotime('+30 minute',strtotime($fechaActual)));

                  $consulta2 = "SELECT servicios.id, servicios.pasajeros, servicios.app_user_id, servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.conductor_id, servicios.centrodecosto_id, servicios.aceptado_app, servicios.estado_servicio_app, servicios.pendiente_autori_eliminacion, servicios.ruta, servicios.localidad, servicios.recoger_en, servicios.dejar_en, servicios.estado_km, reconfirmacion.reconfirmacion2hrs, centrosdecosto.razonsocial as razonsocial, conductores.nombre_completo, conductores.celular FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join reconfirmacion on reconfirmacion.id_servicio = servicios.id left join conductores on conductores.id = servicios.conductor_id WHERE servicios.fecha_servicio between '".$fechaMinima."' and '".$fechaMaxima."' AND servicios.hora_servicio >= '".$horaMinima."' AND servicios.hora_servicio <= '".$horaMaxima."' AND (servicios.estado_servicio_app IS NULL OR servicios.estado_servicio_app <> 2) and servicios.pendiente_autori_eliminacion is null AND reconfirmacion.reconfirmacion30min is null and servicios.localidad = 1 order by servicios.fecha_servicio asc, servicios.hora_servicio asc";

                  $servicios = DB::select($consulta2);
                  $cantidad = count($servicios);

                  if($cantidad==0){


                    $fechaMinima = date('Y-m-d');
                    $horaMinima = date('H:i');
                    $fechaMaxima = date('Y-m-d',strtotime('+15 minute',strtotime($fechaActual)));
                    $horaMaxima = date('H:i',strtotime('+15 minute',strtotime($fechaActual)));

                    $consulta2 = "SELECT servicios.id, servicios.pasajeros, servicios.app_user_id, servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, servicios.conductor_id, servicios.centrodecosto_id, servicios.aceptado_app, servicios.estado_servicio_app, servicios.pendiente_autori_eliminacion, servicios.ruta, servicios.localidad, servicios.recoger_en, servicios.dejar_en, servicios.estado_km, reconfirmacion.reconfirmacion2hrs, centrosdecosto.razonsocial as razonsocial, conductores.nombre_completo, conductores.celular FROM `servicios` left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id left join reconfirmacion on reconfirmacion.id_servicio = servicios.id left join conductores on conductores.id = servicios.conductor_id WHERE servicios.fecha_servicio between '".$fechaMinima."' and '".$fechaMaxima."' AND servicios.hora_servicio >= '".$horaMinima."' AND servicios.hora_servicio <= '".$horaMaxima."' AND (servicios.estado_servicio_app IS NULL OR servicios.estado_servicio_app <> 2) and servicios.pendiente_autori_eliminacion is null AND reconfirmacion.reconfirmacion_horacita is null and servicios.localidad = 1 order by servicios.fecha_servicio asc, servicios.hora_servicio asc";

                    $servicios = DB::select($consulta2);
                    $cantidad = count($servicios);

                  }

                }

              }

              $hoy = DB::table('qr_ingreso')
              ->where('fecha',date('Y-m-d'))
              ->pluck('codigo');



              if( date('H:i')>='06:00' and date('H:i')<='08:00' ){

                $dat = date('Y-m-d');
                $fecch = strtotime('-1 day',strtotime($dat));
                $fecch = date ('Y-m-d' , $fecch);

                $ayer = DB::table('qr_ingreso')
                ->where('fecha',$fecch)
                ->pluck('codigo');

              }else{

                $ayer = null;
              }



              if ($servicios!=null) {

                return Response::json([
                  'mensaje'=>true,
                  'servicios'=>$servicios,
                  'fechaActual' => $fechaActual,
                  'horaActual' => $horaActual,
                  'cantidad' => $cantidad,
                  'hoy' => $hoy,
                  'ayer' => $ayer,
                  //'documentos_por_vencer' => $documentos_por_vencer,
                  //'documentos_vencidos' => $documentos_vencidos,
                  //'total_conductores' => $total_conductores,
                  //'fechaMasSieteDias' => $fechaMasSieteDias,
                  //'total_vehiculos' => $total_vehiculos
                ]);

              }else{

                return Response::json([
                  'mensaje'=>false,
                  'consulta'=>$consulta2,
                  //'subcentro'=>$subcentro,
                  'horaActual' => $horaActual,
                  'hoy' => $hoy,
                  'ayer' => $ayer,
                  //'documentos_por_vencer' => $documentos_por_vencer,
                  //'documentos_vencidos' => $documentos_vencidos,
                  //'total_conductores' => $total_conductores,
                  //'fechaMasSieteDias' => $fechaMasSieteDias,
                  //'total_vehiculos' => $total_vehiculos
                ]);
              }
          }
      }
  }*/

  public function postBuscarordenesfinalizadas(){

      $id_rol = Sentry::getUser()->id_rol;
      $id_usuario = Sentry::getUser()->id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      if (!Sentry::check()){

        return Response::json([
          'respuesta'=>'relogin'
        ]);

      }else{

        if (Request::ajax()){

          $fechaActual = date('Y-m-d');
          $horaActual = date('H:i');

          $consulta = "select servicios.id, servicios.fecha_servicio, ".
            "servicios.ruta, servicios.localidad, ".
            "servicios.pendiente_autori_eliminacion, ".
            "servicios.hora_servicio, ".
            "servicios.estado_servicio_app, ".
            "servicios.control_facturacion, ".
            "centrosdecosto.razonsocial, ".
            "conductores.nombre_completo, conductores.celular, conductores.usuario_id, reconfirmacion.numero_reconfirmaciones ".

            "from servicios ".

            "left join conductores on servicios.conductor_id = conductores.id ".
            "left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id ".
            "left join reconfirmacion on servicios.id = reconfirmacion.id_servicio ".
            "where servicios.fecha_servicio between '".$fechaActual."' AND '".$fechaActual."' and servicios.localidad = 1 AND servicios.estado_servicio_app = 2";

          $servicios = DB::select(DB::raw($consulta." and servicios.pendiente_autori_eliminacion is null ORDER BY hora_servicio ASC"));

            if ($servicios!=null) {

                return Response::json([
                    'mensaje'=>true,
                    'servicios'=>$servicios,
                    'fechaActual' => $fechaActual,
                    'horaActual' => $horaActual
                ]);

            }else{

                return Response::json([
                    'mensaje'=>false,
                    'consulta'=>$consulta,
                    //'subcentro'=>$subcentro,
                    'horaActual' => $horaActual
                ]);
            }
        }
      }
  }

  public function postBuscarordenesactivas(){

      $id_rol = Sentry::getUser()->id_rol;
      $id_usuario = Sentry::getUser()->id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      if (!Sentry::check()){

        return Response::json([
          'respuesta'=>'relogin'
        ]);

      }else{

        if (Request::ajax()){

          $fechaActual = date('Y-m-d');
          $horaActual = date('H:i');

          $consulta = "select servicios.id, servicios.fecha_servicio, ".
            "servicios.ruta, servicios.localidad, ".
            "servicios.pendiente_autori_eliminacion, ".
            "servicios.hora_servicio, ".
            "servicios.estado_servicio_app, ".
            "servicios.control_facturacion, ".
            "centrosdecosto.razonsocial, ".
            "conductores.nombre_completo, conductores.celular, conductores.usuario_id, reconfirmacion.numero_reconfirmaciones ".

            "from servicios ".

            "left join conductores on servicios.conductor_id = conductores.id ".
            "left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id ".
            "left join reconfirmacion on servicios.id = reconfirmacion.id_servicio ".
            "where servicios.fecha_servicio between '".$fechaActual."' AND '".$fechaActual."' and servicios.localidad = 1 AND servicios.estado_servicio_app = 1";

          $servicios = DB::select(DB::raw($consulta." and servicios.pendiente_autori_eliminacion is null ORDER BY hora_servicio ASC"));

            if ($servicios!=null) {

                return Response::json([
                    'mensaje'=>true,
                    'servicios'=>$servicios,
                    'fechaActual' => $fechaActual,
                    'horaActual' => $horaActual
                ]);

            }else{

                return Response::json([
                    'mensaje'=>false,
                    'consulta'=>$consulta,
                    //'subcentro'=>$subcentro,
                    'horaActual' => $horaActual
                ]);
            }
        }
      }
  }

  public function postBuscarordenesprogramadas(){

      $id_rol = Sentry::getUser()->id_rol;
      $id_usuario = Sentry::getUser()->id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      if (!Sentry::check()){

        return Response::json([
          'respuesta'=>'relogin'
        ]);

      }else{

        if (Request::ajax()){

          $fechaActual = date('Y-m-d');
          $horaActual = date('H:i');

          $consulta = "select servicios.id, servicios.fecha_servicio, ".
            "servicios.ruta, servicios.localidad, ".
            "servicios.pendiente_autori_eliminacion, ".
            "servicios.hora_servicio, ".
            "servicios.estado_servicio_app, ".
            "servicios.control_facturacion, servicios.aceptado_app, ".
            "centrosdecosto.razonsocial, reconfirmacion.numero_reconfirmaciones, ".
            "conductores.nombre_completo, conductores.celular, conductores.usuario_id ".

            "from servicios ".

            "left join conductores on servicios.conductor_id = conductores.id ".
            "left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id ".
            "left join reconfirmacion on servicios.id = reconfirmacion.id_servicio ".
            "where servicios.fecha_servicio between '".$fechaActual."' AND '".$fechaActual."' and servicios.localidad = 1 AND servicios.estado_servicio_app IS NULL and servicios.hora_servicio > '".$horaActual."'";

          $servicios = DB::select(DB::raw($consulta." and servicios.pendiente_autori_eliminacion is null ORDER BY hora_servicio ASC"));

            if ($servicios!=null) {

                return Response::json([
                    'mensaje'=>true,
                    'servicios'=>$servicios,
                    'fechaActual' => $fechaActual,
                    'horaActual' => $horaActual
                ]);

            }else{

                return Response::json([
                    'mensaje'=>false,
                    'consulta'=>$consulta,
                    //'subcentro'=>$subcentro,
                    'horaActual' => $horaActual
                ]);
            }
        }
      }
  }

  public function postReconfirmarconductor(){

    $id = Input::get('id');

    $consulta_reconfirmacion = DB::table('reconfirmacion')->where('id_servicio',$id)->first();
    $servicio = DB::table('servicios')->where('id',$id)->first();

    //YA HAY UN REGISTRO GUARDADO EN LA TABLA RECONFIRMACIÓN
    if($consulta_reconfirmacion!=null){

      if($consulta_reconfirmacion->numero_reconfirmaciones==1){

        $actualizar = DB::table('reconfirmacion')
        ->where('id_servicio',$id)
        ->update([
          'reconfirmacion1hrs' => date('H:i:s'),
          'novedad_1' => 'RECONFIRMACION APP 1H',
          'numero_reconfirmaciones' => 2,
          'reconfirmado_por' => Sentry::getUser()->id,
          'id_servicio' => $id
        ]);

        $message = '1 Hora';


        Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);
        //NOTIFICACIÓN AL CLIENTE
        $sw = 0;
        if($servicio->app_user_id!=null and $servicio->app_user_id!=0){
          Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);
          $sw = 1;
        }else if($servicio->ruta!=1){ //Si es servicio ejecutivo

          $pax = explode('/',$servicio->pasajeros);

          for ($i=0; $i < count($pax); $i++) {
            $pasajeros[$i] = explode(',', $pax[$i]);
          }

          for ($i=0; $i < count($pax)-1; $i++) {

            for ($j=0; $j < count($pasajeros[$i]); $j++) {

              if ($j===1) {
                $nombre = $pasajeros[$i][$j];
              }

              $correo = null;

              if ($j===2) {
                $correo = $pasajeros[$i][$j];
              }

              if($correo!=''){


                $data = [
                  'servicio' => $servicio
                ];

                $emailcc = ['aotourdeveloper@gmail.com']; //,'transportebogota@aotour.com.co'
                //$emailcc = 'aotourdeveloper@gmail.com';
                $email = $correo;

                Mail::send('emails.reconfirmacion', $data, function($message) use ($email, $emailcc){
                  $message->from('no-reply@aotour.com.co', 'AOTOUR');
                  $message->to($email)->subject('Reconfirmación de 1 Hora');
                  $message->cc($emailcc);
                });


              }

            }

            if($nombre!=''){


              $numero = $nombre;

              Servicio::ReconfirmarWhatsApp($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id, $numero, 3012030290);


            }

          }

          $alterno = DB::table('alterno')
          ->where('servicio_id', $servicio->id)
          ->whereNull('tipo')
          ->get();

          if($alterno){
            foreach ($alterno as $alte) {
              Servicio::ReconfirmarWhatsApp($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id, $alte->celular, 3012030290);
            }
          }//RECONFIRMACIÓN AL USUARIO ALTERNO

          //EMAILS
          $alterno = DB::table('alterno')
          ->where('servicio_id', $servicio->id)
          ->whereNotNull('tipo')
          ->get();

          if($alterno){
            foreach ($alterno as $alte) {

              $data = [
                'servicio' => $servicio
              ];

              $emailcc = ['aotourdeveloper@gmail.com']; //,'transportebogota@aotour.com.co'
              $email = $alte->correo;

              Mail::send('emails.reconfirmacion', $data, function($message) use ($email, $emailcc){
                $message->from('no-reply@aotour.com.co', 'AOTOUR');
                $message->to($email)->subject('Reconfirmación de 2 horas');
                $message->cc($emailcc);
              });
            }
          }

        }

      }else if($consulta_reconfirmacion->numero_reconfirmaciones==2){

        $actualizar = DB::table('reconfirmacion')
        ->where('id_servicio',$id)
        ->update([
          'reconfirmacion30min' => date('H:i:s'),
          'novedad_30' => 'RECONFIRMACION APP 30min',
          'numero_reconfirmaciones' => 3,
          'reconfirmado_por' => Sentry::getUser()->id,
          'id_servicio' => $id
        ]);

        $message = '30 Minutos';

        Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

        $pax = explode('/',$servicio->pasajeros);

        for ($i=0; $i < count($pax); $i++) {
          $pasajeros[$i] = explode(',', $pax[$i]);
        }

        for ($i=0; $i < count($pax)-1; $i++) {

          for ($j=0; $j < count($pasajeros[$i]); $j++) {

            if ($j===1) {
              $nombre = $pasajeros[$i][$j];
            }

            $correo = null;

            if ($j===2) {
              $correo = $pasajeros[$i][$j];
            }

            if($correo!=''){


              $data = [
                'servicio' => $servicio
              ];

              $emailcc = ['aotourdeveloper@gmail.com']; //,'transportebogota@aotour.com.co'
              //$emailcc = 'aotourdeveloper@gmail.com';
              $email = $correo;

              Mail::send('emails.reconfirmacion', $data, function($message) use ($email, $emailcc){
                $message->from('no-reply@aotour.com.co', 'AOTOUR');
                $message->to($email)->subject('Reconfirmación de 30 minutos');
                $message->cc($emailcc);
              });


            }

          }

          if($nombre!=''){


            $numero = $nombre;

            Servicio::ReconfirmarWhatsAppt($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id, $numero, 3012030290);


          }

        }

        $alterno = DB::table('alterno')
        ->where('servicio_id', $servicio->id)
        ->whereNull('tipo')
        ->get();

        if($alterno){
          foreach ($alterno as $alte) {
            Servicio::ReconfirmarWhatsAppt($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id, $alte->celular, 3012030290);
          }
        }//RECONFIRMACIÓN AL USUARIO ALTERNO

        //EMAILS
        $alterno = DB::table('alterno')
        ->where('servicio_id', $servicio->id)
        ->whereNotNull('tipo')
        ->get();

        if($alterno){
          foreach ($alterno as $alte) {

            $data = [
              'servicio' => $servicio
            ];

            $emailcc = ['aotourdeveloper@gmail.com']; //,'transportebogota@aotour.com.co'
            $email = $alte->correo;

            Mail::send('emails.reconfirmacion', $data, function($message) use ($email, $emailcc){
              $message->from('no-reply@aotour.com.co', 'AOTOUR');
              $message->to($email)->subject('Reconfirmación de 2 horas');
              $message->cc($emailcc);
            });
          }
        }

      }else if($consulta_reconfirmacion->numero_reconfirmaciones==3){

        $actualizar = DB::table('reconfirmacion')
        ->where('id_servicio',$id)
        ->update([
          'reconfirmacion_horacita' => date('H:i:s'),
          'novedad_hora' => 'RECONFIRMACION APP 15min',
          'numero_reconfirmaciones' => 4,
          'reconfirmado_por' => Sentry::getUser()->id,
          'id_servicio' => $id
        ]);

        $message = '15 Minutos';

        $pax = explode('/',$servicio->pasajeros);

        for ($i=0; $i < count($pax); $i++) {
          $pasajeros[$i] = explode(',', $pax[$i]);
        }

        for ($i=0; $i < count($pax)-1; $i++) {

          for ($j=0; $j < count($pasajeros[$i]); $j++) {

            if ($j===1) {
              $nombre = $pasajeros[$i][$j];
            }

            $correo = null;

            if ($j===2) {
              $correo = $pasajeros[$i][$j];
            }

            if($correo!=''){


              $data = [
                'servicio' => $servicio
              ];

              $emailcc = ['aotourdeveloper@gmail.com']; //,'transportebogota@aotour.com.co'
              //$emailcc = 'aotourdeveloper@gmail.com';
              $email = $correo;

              Mail::send('emails.reconfirmacion', $data, function($message) use ($email, $emailcc){
                $message->from('no-reply@aotour.com.co', 'AOTOUR');
                $message->to($email)->subject('Reconfirmación de 15 minutos');
                $message->cc($emailcc);
              });


            }

          }

          if($nombre!=''){


            $numero = $nombre;

            Servicio::ReconfirmarWhatsAppq($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id, $numero, 3012030290);


          }

        }

        $alterno = DB::table('alterno')
        ->where('servicio_id', $servicio->id)
        ->whereNull('tipo')
        ->get();

        if($alterno){
          foreach ($alterno as $alte) {
            Servicio::ReconfirmarWhatsAppq($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id, $alte->celular, 3012030290);
          }
        }//RECONFIRMACIÓN A USUARIO ALTERNO

        //EMAILS
        $alterno = DB::table('alterno')
        ->where('servicio_id', $servicio->id)
        ->whereNotNull('tipo')
        ->get();

        if($alterno){
          foreach ($alterno as $alte) {

            $data = [
              'servicio' => $servicio
            ];

            $emailcc = ['aotourdeveloper@gmail.com']; //,'transportebogota@aotour.com.co'
            $email = $alte->correo;

            Mail::send('emails.reconfirmacion', $data, function($message) use ($email, $emailcc){
              $message->from('no-reply@aotour.com.co', 'AOTOUR');
              $message->to($email)->subject('Reconfirmación de 1 hora');
              $message->cc($emailcc);
            });
          }
        }

        Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

        Servicio::ReconfirmarCliente($servicio->app_user_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

      }

    }else{

      //sin registro en la tabla de reconfirmación
      $reconfirmador = new Reconfirmacion();
      $reconfirmador->reconfirmacion2hrs = date('H:i:s');
      $reconfirmador->novedad_2 = 'RECONFIRMACION APP 2H';
      $reconfirmador->numero_reconfirmaciones = 1;
      $reconfirmador->reconfirmado_por = Sentry::getUser()->id;
      $reconfirmador->id_servicio = $id;
      $reconfirmador->save();

      $message = '2 Horas';

      //NOTIFICACIÓN AL CLIENTE
        $sw = 0;
        Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);
        if($servicio->app_user_id!=null and $servicio->app_user_id!=0){ //NOTIFICAR POR WHATSAPP LA RECONFIRMACIÓN AL CLIENTE
          Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);
          $sw = 1;
        }else if($servicio->ruta!=1){ //Si es servicio ejecutivo

          //Servicio::ReconfirmarCliente($servicio->app_user_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

          $pax = explode('/',$servicio->pasajeros);

          for ($i=0; $i < count($pax); $i++) {
            $pasajeros[$i] = explode(',', $pax[$i]);
          }

          for ($i=0; $i < count($pax)-1; $i++) {

            for ($j=0; $j < count($pasajeros[$i]); $j++) {

              if ($j===1) {
                $nombre = $pasajeros[$i][$j];
              }

              $correo = null;

              if ($j===2) {
                $correo = $pasajeros[$i][$j];
              }

              if($correo!=''){


                $data = [
                  'servicio' => $servicio
                ];

                $emailcc = ['aotourdeveloper@gmail.com']; //,'transportebogota@aotour.com.co'
                //$emailcc = 'aotourdeveloper@gmail.com';
                $email = $correo;

                Mail::send('emails.reconfirmacion', $data, function($message) use ($email, $emailcc){
                  $message->from('no-reply@aotour.com.co', 'AOTOUR');
                  $message->to($email)->subject('Reconfirmación de 2 horas');
                  $message->cc($emailcc);
                });


              }

            }

            if($nombre!=''){


              $numero = $nombre;

              Servicio::ReconfirmarWhatsApp2h($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id, $numero, 3012030290);


            }

          }

          $alterno = DB::table('alterno')
          ->where('servicio_id', $servicio->id)
          ->whereNull('tipo')
          ->get();

          if($alterno){
            foreach ($alterno as $alte) {
              Servicio::ReconfirmarWhatsApp2h($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id, $alte->celular, 3012030290);
            }
          }

          //EMAILS
          $alterno = DB::table('alterno')
          ->where('servicio_id', $servicio->id)
          ->whereNotNull('tipo')
          ->get();

          if($alterno){
            foreach ($alterno as $alte) {

              $data = [
                'servicio' => $servicio
              ];

              $emailcc = ['aotourdeveloper@gmail.com']; //,'transportebogota@aotour.com.co'
              $email = $alte->correo;

              Mail::send('emails.reconfirmacion', $data, function($message) use ($email, $emailcc){
                $message->from('no-reply@aotour.com.co', 'AOTOUR');
                $message->to($email)->subject('Reconfirmación de 2 horas');
                $message->cc($emailcc);
              });
            }
          }

        }

    }

      return Response::json([
        'response' => true
      ]);

  }
  /*public function postReconfirmarconductor(){

    $id = Input::get('id');

    $consulta_reconfirmacion = DB::table('reconfirmacion')->where('id_servicio',$id)->first();
    $servicio = DB::table('servicios')->where('id',$id)->first();

    //YA HAY UN REGISTRO GUARDADO EN LA TABLA RECONFIRMACIÓN
    if($consulta_reconfirmacion!=null){

      if($consulta_reconfirmacion->numero_reconfirmaciones==1){

        $actualizar = DB::table('reconfirmacion')
        ->where('id_servicio',$id)
        ->update([
          'reconfirmacion1hrs' => date('H:i:s'),
          'novedad_1' => 'RECONFIRMACION APP 1H',
          'numero_reconfirmaciones' => 2,
          'reconfirmado_por' => Sentry::getUser()->id,
          'id_servicio' => $id
        ]);

        $message = '1 Hora';

        //NOTIFICACIÓN AL CLIENTE
        $sw = 0;
        if($servicio->app_user_id!=null and $servicio->app_user_id!=0){
          Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);
          $sw = 1;
        }else if($servicio->ruta!=1){ //Si es servicio ejecutivo

          $pax = explode('/',$servicio->pasajeros);

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

              Servicio::ReconfirmarWhatsApp($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id, $numero, 3012633287);


            }

          }

        }

      }else if($consulta_reconfirmacion->numero_reconfirmaciones==2){

        $actualizar = DB::table('reconfirmacion')
        ->where('id_servicio',$id)
        ->update([
          'reconfirmacion30min' => date('H:i:s'),
          'novedad_30' => 'RECONFIRMACION APP 30min',
          'numero_reconfirmaciones' => 3,
          'reconfirmado_por' => Sentry::getUser()->id,
          'id_servicio' => $id
        ]);

        $message = '30 Minutos';

        Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

      }else if($consulta_reconfirmacion->numero_reconfirmaciones==3){

        $actualizar = DB::table('reconfirmacion')
        ->where('id_servicio',$id)
        ->update([
          'reconfirmacion_horacita' => date('H:i:s'),
          'novedad_hora' => 'RECONFIRMACION APP 15min',
          'numero_reconfirmaciones' => 4,
          'reconfirmado_por' => Sentry::getUser()->id,
          'id_servicio' => $id
        ]);

        $message = '15 Minutos';

        Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

      }

    }else{

      //sin registro en la tabla de reconfirmación
      $reconfirmador = new Reconfirmacion();
      $reconfirmador->reconfirmacion2hrs = date('H:i:s');
      $reconfirmador->novedad_2 = 'RECONFIRMACION APP 2H';
      $reconfirmador->numero_reconfirmaciones = 1;
      $reconfirmador->reconfirmado_por = Sentry::getUser()->id;
      $reconfirmador->id_servicio = $id;
      $reconfirmador->save();

      $message = '2 Horas';

      //NOTIFICACIÓN AL CLIENTE
        $sw = 0;
        if($servicio->app_user_id!=null and $servicio->app_user_id!=0){
          Servicio::Reconfirmar($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);
          $sw = 1;
        }else if($servicio->ruta!=1){ //Si es servicio ejecutivo

          //Servicio::ReconfirmarCliente($servicio->app_user_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

          $pax = explode('/',$servicio->pasajeros);

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

              Servicio::ReconfirmarWhatsApp2h($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id, $numero, 3012633287);


            }

          }
          $alterno = DB::table('alterno')
          ->where('servicio_id', $servicio->id)
          ->whereNull('tipo')
          ->get();

          if($alterno){
            foreach ($alterno as $alte) {
              Servicio::ReconfirmarWhatsApp2h($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id, $alte->celular, 3012030290);
            }
          }

          //EMAILS
          $alterno = DB::table('alterno')
          ->where('servicio_id', $servicio->id)
          ->whereNotNull('tipo')
          ->get();

          if($alterno){
            foreach ($alterno as $alte) {

              $data = [
                'servicio' => $servicio
              ];

              $emailcc = ['aotourdeveloper@gmail.com']; //,'transportebogota@aotour.com.co'
              $email = $alte->correo;

              Mail::send('emails.reconfirmacion', $data, function($message) use ($email, $emailcc){
                $message->from('no-reply@aotour.com.co', 'AOTOUR');
                $message->to($email)->subject('Reconfirmación de 2 horas');
                $message->cc($emailcc);
              });
            }
          }
        }

    }

      return Response::json([
        'response' => true
      ]);

  }*/

  public function postNotificarconductor(){

    $id = Input::get('id');
    $servicio = DB::table('servicios')->where('id',$id)->first();
    $conductor = DB::table('conductores')->where('id',$servicio->conductor_id)->first();


    //YA HAY UN REGISTRO GUARDADO EN LA TABLA RECONFIRMACIÓN
    if($conductor!=null){

      $message = 'Servicio';
      Servicio::RecordarServicio($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

    }

    return Response::json([
      'response' => true
    ]);

  }

  public function postAceptarnovedad(){

    $id = Input::get('id');

    $servicio = DB::table('novedades_app')
    ->where('id',$id)
    ->update([
      'estado' => 1,
      'usuario_rechazo' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
    ]);

    if($servicio){

      //Servicio::RecordarServicio($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $message, $servicio->id);

      return Response::json([
        'respuesta' => true
      ]);

    }

  }

  public function postRechazarnovedad(){

    $id = Input::get('id');
    $servicio_id = Input::get('servicio_id');

    //$delete=Novedadapp::where('id',$id)->delete();
    $servicio = DB::table('novedades_app')
    ->where('id',$id)
    ->update([
      'estado' => 2,
      'usuario_rechazo' => Sentry::getUser()->first_name. ' '.Sentry::getUser()->last_name
    ]);

    if($servicio){

      Servicio::RechazarNovedad($id, $servicio_id);

      //Informar el rechazo por notificación APP

      return Response::json([
        'respuesta' => true
      ]);

    }

  }

  public function getOrdenes2(){

    if (Sentry::check()){

        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->bogota->servicios->ver;

    }else{
        $ver = null;
    }

    if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on') {

        return View::make('admin.permisos');

    }else{

        $fechaActual = date('Y-m-d');
        $horaActual = date('H:i');

        $query = DB::table('servicios')
            ->leftJoin('reportes_pivote', 'servicios.id', '=', 'reportes_pivote.servicio_id')
            ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
            ->leftJoin('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
            ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
            ->LeftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
            ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
            ->leftJoin('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
            ->leftJoin('users', 'servicios.creado_por', '=', 'users.id')
            ->leftJoin('facturacion', 'servicios.id','=','facturacion.servicio_id')
            ->select('servicios.*',
                 'facturacion.revisado','facturacion.liquidado','facturacion.facturado','facturacion.factura_id',
                 'proveedores.tipo_afiliado', 'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro','users.first_name',
                 'users.last_name',
                 'rutas.nombre_ruta','rutas.codigo_ruta','proveedores.razonsocial AS razonproveedor',
                 'conductores.nombre_completo','conductores.celular','conductores.telefono','conductores.usuario_id',
                 'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo')
            ->where('servicios.anulado',0)
            //->whereIn('centrosdecosto.localidad',['bogota','provisional'])
            //->whereIn('users.localidad',['2','3'])
            ->where('servicios.localidad',1)
            ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
            ->whereNull('servicios.pendiente_autori_eliminacion')
            ->whereNull('servicios.afiliado_externo')
            ->where('fecha_servicio',date('Y-m-d'));
            //->whereNull('servicios.ruta');

        /**
         * [$servicios description]
         * @var [type]
         */

          //MODIFICICACIÓN PARA QUE OPERACIONES NO VISUALICE LOS SERVICIOS MONTADOS POR FACTURACION
          //SE AGREGÓ EL CAMPO CONTROL FACTURACION
          if($id_rol==1 or $id_rol==2 or $id_rol==8){
              $servicios = $query->orderBy('hora_servicio', 'ASC')->get();
          }else{
              $servicios = $query->whereNull('servicios.control_facturacion')->orderBy('hora_servicio', 'ASC')->get();
          }

        $o = 1;

        return View::make('servicios.ordenes', [
          'servicios' => $servicios,
          'permisos' => $permisos,
          'o' => $o,
          'fechaActual' => $fechaActual,
          'horaActual' => $horaActual
        ]);

    }

  }

  public function postExpediente(){

    $expediente = Input::get('expediente');

    $fecha = date('Y-m-d');
    $fechaInicial = strtotime ('-45 day', strtotime($fecha));
    $fechaInicial = date ('Y-m-d' , $fechaInicial);

    $fechaFinal = strtotime ('+40 day', strtotime($fecha));
    $fechaFinal = date('Y-m-d' , $fechaFinal);


    $consultaExpediente = DB::table('servicios')
    ->whereBetween('fecha_servicio',[$fechaInicial,$fechaFinal])
    ->where('centrodecosto_id',329)
    ->where('expediente',$expediente)
    ->whereNull('pendiente_autori_eliminacion')
    ->where('localidad',1)
    ->first();

    if($consultaExpediente!=null){ //Si el expediente ya fue asignado antes y no está facturado el servicio, se añade el servicio al mismo expediente

      $subcentro = $consultaExpediente->subcentrodecosto_id;

      return Response::json([
        'respuesta' => true,
        'expediente' => $expediente,
        'subcentro' => $subcentro
      ]);

    }else{

      //Consultar subcentros disponibles para asignar

      $consulta = "SELECT id, nombresubcentro, centrosdecosto_id FROM subcentrosdecosto WHERE centrosdecosto_id = 329 AND nombresubcentro LIKE '%BOG%' AND nombresubcentro NOT LIKE '%CARBONES%' AND id != 1052";
      $consulta = DB::select($consulta);

      //$consulta = DB::table('subcentrosdecosto')
      //->where('centrosdecosto_id',329)
      //->get();

      $cantidad = count($consulta);

      /*while ($cantidad) {
        // code...
      }*/

      $sw = 0;
      $servicio = '';

      foreach ($consulta as $sucentro) {

        $id = $sucentro->id;

        if($sw==0){

          $servicio = DB::table('servicios')
          ->leftJoin('facturacion', 'facturacion.servicio_id', '=', 'servicios.id')
          ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.centrodecosto_id', 'servicios.subcentrodecosto_id', 'facturacion.facturado', 'facturacion.liquidacion_id', 'facturacion.liquidado_autorizado')
          ->whereNull('pendiente_autori_eliminacion')
          ->whereBetween('fecha_servicio',[$fechaInicial,$fechaFinal])
          ->where('centrodecosto_id',329)
          ->where('subcentrodecosto_id',$id)
          ->whereNull('facturacion.liquidacion_id')
          ->first();

        }

        if($servicio===null and $sw===0){
          $data = $id;
          $sw=1;
        }

      }

      return Response::json([
        'respuesta' => false,
        'expediente' => $expediente,
        'disponible' => $data,
        'data' => $data,
        'consulta' => $consulta,
        'servicio' => $servicio
      ]);

    }

  }

  public function postNuevaconfirmacion() {

    $ids = Input::get('ids');
    $numbs = Input::get('numbs');

    $numeros = explode(';', $numbs);

    for ($i=0; $i < count($numeros); $i++) {

      $servicios = explode(',', $ids);

      for ($g=0; $g < count($servicios); $g++) {

        $servicio = Servicio::select('servicios.*', 'servicios.fecha_servicio', 'servicios.fecha_solicitud','servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.hora_servicio', 'servicios.pasajeros', 'centrosdecosto.razonsocial', 'vehiculos.clase', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'conductores.nombre_completo', 'conductores.celular')
        ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
        ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
        ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
        ->where('servicios.id',$servicios[$g])
        ->first();

        $placaVehiculo = DB::table('vehiculos')
        ->where('id',$servicio->vehiculo_id)
        ->pluck('placa');

        $nameConductor = DB::table('conductores')
        ->where('id',$servicio->conductor_id)
        ->pluck('nombre_completo');

        $celConductor = DB::table('conductores')
        ->where('id',$servicio->conductor_id)
        ->pluck('celular');

        $number = $numeros[$i]; //'57'.Concatenación del indicativo con el número

        $number = intval($number);
        $nombre = 'ESTIMADO(A)';

        $fecha = $servicio->fecha_servicio;
        $hora = $servicio->hora_servicio;
        $origen = $servicio->recoger_en;
        $destino = $servicio->dejar_en;
        $cliente = DB::table('centrosdecosto')
        ->where('id',$servicio->centrodecosto_id)
        ->pluck('razonsocial');

        if($placaVehiculo=='ABC-123'){
          $placaVehiculo = 'POR CONFIRMAR';
        }

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
            \"name\": \"service_prog\",
            \"language\": {
              \"code\": \"es\",
            },
            \"components\": [{
              \"type\": \"body\",
              \"parameters\": [{
                \"type\": \"text\",
                \"text\": \"".$nombre."\",
              },
              {
                \"type\": \"text\",
                \"text\": \"".$fecha."\",
              },
              {
                \"type\": \"text\",
                \"text\": \"".$hora."\",
              },
              {
                \"type\": \"text\",
                \"text\": \"".$origen."\",
              },
              {
                \"type\": \"text\",
                \"text\": \"".$destino."\",
              },
              {
                \"type\": \"text\",
                \"text\": \"".$placaVehiculo."\",
              }]
            },
            {
              \"type\": \"button\",
              \"sub_type\": \"url\",
              \"index\": \"0\",
              \"parameters\": [{
                \"type\": \"payload\",
                \"payload\": \"".$servicio->id."\"
              }]
            },{
              \"type\": \"button\",
              \"sub_type\": \"url\",
              \"index\": \"1\",
              \"parameters\": [{
                \"type\": \"payload\",
                \"payload\": \"".$servicio->id."\"
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

        $otro = new Alterno;
        $otro->servicio_id = $servicios[$g];
        $otro->celular = $numeros[$i];
        $otro->save();

      }


    }

    return Response::json([
      'respuesta' => true,
      'ids' => $ids,
      'numbs' => explode(';', $numbs)
    ]);

  }

  public function postNuevaconfirmacioncorreo() {

    $ids = Input::get('ids');
    $emails = Input::get('emails');

    $emails = explode(';', $emails);

    $serv = Servicio::find(explode(',',$ids)[0]);

    $pax = explode('/',$serv->pasajeros);
    $nombrep = '';

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

        }
        $count++;
        if($sw===$count){
          $nombrep .= $nombre;
        }else{
          $nombrep .= $nombre.',';
        }
    }

    for ($i=0; $i < count($emails); $i++) {

        $query_servicio = Servicio::select('servicios.*', 'servicios.fecha_servicio', 'servicios.fecha_solicitud','servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.hora_servicio', 'servicios.pasajeros', 'centrosdecosto.razonsocial', 'vehiculos.clase', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'conductores.nombre_completo', 'conductores.celular')
        ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
        ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
        ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
        ->whereIn('servicios.id',[$ids])
        ->get();

        $data = [
          'cantidad' => count($query_servicio),
          'nombre_pasajeros' => $nombrep,//$nombre_pasajeros,
          'servicios' => $query_servicio,
        ];

        $emailcc = ['aotourdeveloper@gmail.com'];//,'transportebarranquilla@aotour.com.co'
        $email = $emails[$i];

        Mail::send('emails.nuevo_servicio', $data, function($message) use ($email, $emailcc){
          $message->from('no-reply@aotour.com.co', 'AOTOUR');
          $message->to($email)->subject('Programación de Servicio / Service Schedule');
          $message->cc($emailcc);
        });

        foreach ($query_servicio as $servi) {
          $otro = new Alterno;
          $otro->servicio_id = $servi->id;
          $otro->correo = $email;
          $otro->tipo = 1;
          $otro->save();
        }

    }

    return Response::json([
      'respuesta' => true,
      'ids' => $ids
    ]);

  }

}
