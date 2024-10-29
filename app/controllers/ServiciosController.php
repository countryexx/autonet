<?php

/**
 * Controlador para el modulo de transportes
 */
class ServiciosController extends BaseController{

  /**
   * Metodo para mostrar todos los servicios del dia
   * @return View Vista
   */
  public function getIndex(){

    if (Sentry::check()){

        $id_rol = Sentry::getUser()->id_rol;
        $idusuario = Sentry::getUser()->id;      
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
            ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
            ->whereNull('servicios.pendiente_autori_eliminacion')
            ->whereNull('servicios.afiliado_externo')
            ->where('fecha_servicio',date('Y-m-d'))
            ->whereNull('servicios.ruta');

        /**
         * [$servicios description]
         * @var [type]
         */
        $servicios = $query->orderBy('hora_servicio')->get();

        $proveedores = Proveedor::Afiliadosinternos()
        ->orderBy('razonsocial')
        ->where('localidad','BARRANQUILLA')
        ->where('tipo_servicio', 'TRANSPORTE TERRESTRE')
        ->whereNull('inactivo_total')
        ->whereNull('inactivo')
        ->get();

        $centrosdecosto = Centrodecosto::Internos()->where('localidad','BARRANQUILLA')->orderBy('razonsocial')->get();

        $subcentros = DB::table('subcentrosdecosto')->orderBy('nombresubcentro')->get();
        $departamentos = DB::table('departamento')->get();
        $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
        $rutas = DB::table('rutas')->get();

        $usuarios = User::where('coordinador', 1)->where('activated', 1)->orderBy('first_name')->get();

        $cotizaciones = DB::table('cotizaciones')->where('estado',1)->orderBy('created_at', 'desc')->take(10)->get();
        $o = 1;

        return View::make('servicios.gps.servicios', [
          'cotizaciones' => $cotizaciones,
          'idusuario' => $idusuario,
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
                ->get();          

            $proveedores = Proveedor::Afiliadosinternos()
            ->orderBy('razonsocial')
            ->where('localidad','barranquilla')
            ->where('tipo_servicio', 'TRANSPORTE TERRESTRE')
            ->whereNull('inactivo_total')
            ->whereNull('inactivo')
            ->get();

            $centrosdecosto = Centrodecosto::Internos()->where('localidad','barranquilla')->orderBy('razonsocial')->get();
            if($idusuario==642){
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

                $servicios = DB::select(DB::raw($consulta." and servicios.pendiente_autori_eliminacion is null order by hora_servicio asc "));

        foreach ($servicios as $servicio){

        }

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
    //

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
                    "where servicios.fecha_servicio between '".$fecha_inicial."' AND '".$fecha_final."' and servicios.centrodecosto_id = '".$cliente."' ";              

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
}

  