<?php

class FacturacionController extends BaseController{

    #####################REVISION#######################
    public function getRevision(){

        if (Sentry::check()) {

          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->facturacion->revision->ver;

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
                ->join('rutas', 'servicios.ruta_id', '=', 'rutas.id')
                ->leftJoin('facturacion', 'servicios.id', '=', 'facturacion.servicio_id')
				        ->leftJoin('servicios_autorizados_pdf', 'servicios.id', '=', 'servicios_autorizados_pdf.servicio_id')
                ->leftJoin('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
                ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
                ->leftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
                ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
                ->leftJoin('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
                ->leftJoin('users', 'servicios.creado_por', '=', 'users.id')
                ->select('centrosdecosto.razonsocial', 'servicios.*', 'proveedores.tipo_afiliado',
                    'subcentrosdecosto.nombresubcentro','users.first_name','users.last_name',
                    'facturacion.numero_planilla','facturacion.revisado','facturacion.liquidado','facturacion.facturado',
                    'facturacion.cod_centro_costo','rutas.nombre_ruta','rutas.codigo_ruta','proveedores.razonsocial AS razonproveedor',
                    'conductores.nombre_completo','conductores.celular','conductores.telefono',
                    'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo', 'servicios_autorizados_pdf.documento_pdf1', 'servicios_autorizados_pdf.documento_pdf2')
                ->whereNull('servicios.afiliado_externo')
                ->where('servicios.anulado',0)
                ->where('servicios.cancelado',0)
                ->where('fecha_servicio',date('Y-m-d'))
                ->whereNull('pendiente_autori_eliminacion')
                ->orderBy('hora_servicio')
                ->get();

            $proveedores = Proveedor::Afiliadosinternos()
            ->orderBy('razonsocial')
            ->where('tipo_servicio', 'TRANSPORTE TERRESTRE')
            ->whereNull('inactivo_total')
            ->whereNull('inactivo')
            ->get();

            $centrosdecosto = Centrodecosto::Internos()->orderBy('razonsocial')->get();

            $subcentros = DB::table('subcentrosdecosto')->get();
            $ciudades = DB::table('ciudad')->get();
            $usuarios = DB::table('users')->get();

            return View::make('facturacion.revision')
            ->with([
                'servicios'=>$servicios,
                'proveedores'=>$proveedores,
                'centrosdecosto'=>$centrosdecosto,
                'ciudades'=>$ciudades,
                'usuarios'=>$usuarios,
                'permisos'=>$permisos,
                'o'=>$o=1
            ]);
        }
    }

    public function getRevisar($id){

        if (Sentry::check()) {

          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->facturacion->revision->ver;

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

            #MOSTRAR SERVICIOS DENTRO DE LA VISTA
            $servicios = Servicio::whereNull('pendiente_autori_eliminacion')
                ->selectRaw('servicios.*, centrosdecosto.razonsocial, subcentrosdecosto.nombresubcentro')
                ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
                ->leftJoin('facturacion', 'servicios.id', '=', 'facturacion.servicio_id')
                ->leftJoin('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
                ->where('servicios.id',$id)->get();

            foreach ($servicios as $servicio) {
                $fecha_servicio = $servicio->fecha_servicio;
                $proveedor_id = $servicio->proveedor_id;
                $pax = $servicio->pasajeros;
                $centrodecosto_id = $servicio->centrodecosto_id;
                $subcentrodecosto_id = $servicio->subcentrodecosto_id;

				$ciudad_t = $servicio->ciudad;
				$ruta_id_t = $servicio->ruta_id;
            }

            $rutas_programadas = DB::table('servicios')
                ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
                ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
                ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
                ->join('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
                ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
                ->select('rutas.nombre_ruta','rutas.codigo_ruta',
                    'servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.id',
                    'servicios.fecha_servicio','servicios.hora_servicio','servicios.centrodecosto_id','servicios.ciudad','servicios.ruta_id',
                    'proveedores.razonsocial',
                    'vehiculos.placa','vehiculos.marca','vehiculos.clase',
                    'facturacion.numero_planilla','facturacion.observacion','facturacion.facturado','facturacion.cambios_servicio',
                    'facturacion.cod_centro_costo',
                    'conductores.nombre_completo')
                ->where('servicios.centrodecosto_id',$centrodecosto_id)
                ->where('servicios.subcentrodecosto_id',$subcentrodecosto_id)
                ->where('fecha_servicio',$fecha_servicio)
                ->whereNull('pendiente_autori_eliminacion')
                ->where('pasajeros',$pax)
                ->get();

            $rutas_centro = DB::table('rutas')->where('centrosdecosto_id',$centrodecosto_id)->get();

			//$rutas_tarifa = DB::table('tarifa_traslado')->where('tarifa_ciudad',$ciudad_t)->get();

            return View::make('facturacion.revision_detalles')->with([
                'servicios'=>$servicios,
                'rutas_programadas'=>$rutas_programadas,
                'rutas_centro'=>$rutas_centro,
                'permisos'=>$permisos
            ]);
        }
    }

    public function postVernovedad(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

                $novedad = DB::table('novedades_reconfirmacion')
                    ->select('novedades_reconfirmacion.id','novedades_reconfirmacion.seleccion_opcion','novedades_reconfirmacion.descripcion',
                        'novedades_reconfirmacion.creado_por','novedades_reconfirmacion.created_at','users.first_name','users.last_name')
                    ->leftJoin('users','novedades_reconfirmacion.creado_por','=','users.id')
                    ->where('id_reconfirmacion',Input::get('id'))->first();

                return Response::json([
                    'respuesta'=>true,
                    'novedad'=>$novedad
                ]);

            }

        }
    }

    public function postVernovedadapp(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

                $novedades_app = Novedadapp::where('servicio_id', Input::get('servicio_id'))->get();

                if (count($novedades_app)) {

                  return Response::json([
                      'response' => true,
                      'novedades_app' => $novedades_app
                  ]);

                }else {

                  return Response::json([
                      'response' => false
                  ]);

                }

            }

        }
    }

    public function postBuscar(){

        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);

        if (!Sentry::check())
        {
            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else{

            $fecha_inicial = Input::get('fecha_inicial');
            $fecha_final = Input::get('fecha_final');
            $servicio = intval(Input::get('servicios'));
            $proveedores = intval(Input::get('proveedores'));
            $conductores = intval(Input::get('conductores'));
            $centrodecosto = intval(Input::get('centrodecosto'));
            $subcentro = intval(Input::get('subcentrodecosto'));
            $ciudades = Input::get('ciudades');
            $usuarios = intval(Input::get('usuario'));

            //Tipo de cliente
            $tipo_afiliado = Input::get('tipo_afiliado');

            $consulta = "select servicios.*, novedades_reconfirmacion.id_reconfirmacion, ".
                "reconfirmacion.ejecutado, ".
                "(select id from novedades_app where servicio_id = servicios.id limit 1) as novedades_app, facturacion.revisado, facturacion.liquidado, facturacion.numero_planilla, facturacion.facturado, facturacion.cod_centro_costo, ".
                "centrosdecosto.razonsocial, ".
                "subcentrosdecosto.nombresubcentro, ".
                "users.first_name, users.last_name,".
                "rutas.nombre_ruta, rutas.codigo_ruta,".
                "proveedores.razonsocial as razonproveedor, ".
                "conductores.nombre_completo, conductores.celular, conductores.telefono, ".
                "vehiculos.placa, vehiculos.clase, ".
                "vehiculos.marca, vehiculos.modelo, ".
				        "servicios_autorizados_pdf.documento_pdf1, servicios_autorizados_pdf.documento_pdf2 ".
                "from servicios ".
                "left join reconfirmacion on servicios.id = reconfirmacion.id_servicio ".
                "left join novedades_reconfirmacion on servicios.id = novedades_reconfirmacion.id_reconfirmacion ".
                "left join facturacion on servicios.id = facturacion.servicio_id ".
                "left join rutas on servicios.ruta_id = rutas.id ".
                "left join proveedores on servicios.proveedor_id = proveedores.id ".
                "left join conductores on servicios.conductor_id = conductores.id ".
                "left join vehiculos on servicios.vehiculo_id = vehiculos.id ".
                "left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id ".
                "left join subcentrosdecosto on servicios.subcentrodecosto_id = subcentrosdecosto.id ".
                "left join users on servicios.creado_por = users.id ".
				    "left join servicios_autorizados_pdf on servicios.id = servicios_autorizados_pdf.servicio_id ".
            "where servicios.fecha_servicio BETWEEN '".$fecha_inicial."' AND '".$fecha_final."' and afiliado_externo is null ";

            /*if ($tipo_afiliado==0 or $tipo_afiliado==2) {
                $consulta .= " and servicios.afiliado_externo is null ";
            }else if ($tipo_afiliado==3) {
                $consulta .= " and servicios.afiliado_externo = 1 ";
            }*/

            if($servicio!=0){

                //FILTRO PARA SERVICIOS PROGRAMADOS
                if ($servicio===1) {
                    $consulta .=" and servicios.cancelado= 0 and servicios.anulado = 0 ";
                }

                if($servicio===3){
                    $consulta .=" and (facturacion.revisado IS NULL or facturacion.revisado= 0) ";
                }
            }

            if($proveedores!=0){
                $consulta .= " and proveedores.id = '".$proveedores."' ";
            }

            if($conductores!=0){
                $consulta .= " and conductores.id = '".$conductores."' ";
            }

            if($centrodecosto!=0){
                $consulta .= " and centrosdecosto.id = '".$centrodecosto."' ";
            }

            if($subcentro!=0){
                $consulta .= " and subcentrosdecosto.id = '".$subcentro."' ";
            }

            if($ciudades!='CIUDADES'){
                $consulta .= " and servicios.ciudad = '".$ciudades."' ";
            }

            if($usuarios!=0){
                $consulta .= " and users.id = '".$usuarios."' ";
            }

            $servicios = DB::select($consulta." and servicios.pendiente_autori_eliminacion is null order by hora_servicio asc");

            if ($servicios!=null) {

                return Response::json([
                    'mensaje'=>true,
                    'servicios'=>$servicios,
                    'consulta'=>$consulta,
                    'permisos'=>$permisos
                ]);

            }else{

                return Response::json([
                    'mensaje'=>false,
                    'servicios'=>$servicios,
                    'consulta'=>$consulta
                ]);
            }

        }
    }
    ################FIN REVISION#####################

    ##################LIQUIDACION####################
    public function postBuscarliquidacion(){

        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            $fecha_inicial = Input::get('fecha_inicial');
            $fecha_final = Input::get('fecha_final');
            $proveedores = intval(Input::get('proveedores'));
            $conductores = intval(Input::get('conductores'));
            $centrodecosto = intval(Input::get('centrodecosto'));
            $subcentro = intval(Input::get('subcentrodecosto'));
            $ciudades = Input::get('ciudades');
            $usuarios = Input::get('usuario');
            $codigo = Input::get('codigo');
            $servicios = intval(Input::get('servicios'));
            $tipo_afiliado = Input::get('tipo_afiliado');

            $consulta = "select facturacion.liquidacion_id, servicios.id, servicios.fecha_servicio, servicios.pasajeros, servicios.recoger_en, ".
                "servicios.dejar_en, servicios.hora_servicio, ".
                "centrosdecosto.razonsocial, ".
                "facturacion.numero_planilla, facturacion.revisado, facturacion.observacion, facturacion.servicio_id, ".
                "facturacion.unitario_cobrado, facturacion.unitario_pagado, facturacion.total_cobrado, facturacion.total_pagado, ".
                "facturacion.utilidad, facturacion.liquidado, facturacion.facturado, facturacion.liquidado_autorizado, ".
                "proveedores.razonsocial as razonproveedor, ".
                "centrosdecosto.razonsocial, ".
                "subcentrosdecosto.nombresubcentro, ".
                "conductores.nombre_completo, conductores.celular, conductores.telefono, ".
                "vehiculos.placa, vehiculos.clase, ".
                "vehiculos.marca, vehiculos.modelo, pagos.autorizado ".
                "from servicios ".
                "left join reconfirmacion on servicios.id = reconfirmacion.id_servicio ".
                "left join facturacion on servicios.id = facturacion.servicio_id ".
                "left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id ".
                "left join subcentrosdecosto on servicios.subcentrodecosto_id = subcentrosdecosto.id ".
                "left join proveedores on servicios.proveedor_id = proveedores.id ".
                "left join conductores on servicios.conductor_id = conductores.id ".
                "left join vehiculos on servicios.vehiculo_id = vehiculos.id ".
                "left join pago_proveedores on facturacion.pago_proveedor_id = pago_proveedores.id ".
                    "left join pagos on pago_proveedores.id_pago = pagos.id ".
                "WHERE facturacion.revisado = 1 AND servicios.fecha_servicio BETWEEN '".$fecha_inicial."' AND '".$fecha_final."' ";

            if ($tipo_afiliado==0 or $tipo_afiliado==2) {
                $consulta .= " and servicios.afiliado_externo is null ";
            }else if ($tipo_afiliado==3) {
                $consulta .= " and servicios.afiliado_externo = 1 ";
            }

            if ($servicios===1) {
                $consulta .= " and (facturacion.liquidado IS NULL or facturacion.liquidado= 0) ";
            }else if($servicios===2){
                $consulta .= " and (facturacion.facturado IS NULL or facturacion.facturado = 0) ";
            }

            if($proveedores!=0){
                $consulta .= " and proveedores.id = ".$proveedores." ";
            }

            if($conductores!=0){
                $consulta .= " and conductores.id = '".$conductores."' ";
            }

            if($centrodecosto!=0){
                $consulta .= " and centrosdecosto.id = ".$centrodecosto." ";
            }

            if($subcentro!=0){
                $consulta .= " and subcentrosdecosto.id = ".$subcentro." ";
            }

            if($ciudades!='CIUDADES'){
                $consulta .= " and servicios.ciudad = '".$ciudades."' ";
            }

            if($usuarios!=0){
                $consulta .= " and users.id = ".$usuarios." ";
            }

            $servicios = DB::select(DB::raw($consulta." order by numero_planilla asc "));

            if ($servicios!=null) {

                return Response::json([
                    'mensaje'=>true,
                    'servicios'=>$servicios,
                    'consulta'=>$consulta,
                    'usuario'=>Sentry::getUser()->id,
                    'permisos'=>$permisos
                ]);

            }else{
                return Response::json([
                    'mensaje'=>false
                ]);
            }

        }
    }

    public function getAutorizacionservicios(){

        if (Sentry::check()) {

          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->facturacion->autorizar->ver;

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

            $liquidaciones = DB::table('liquidacion_servicios')
                ->select('liquidacion_servicios.*', 'centrosdecosto.razonsocial','subcentrosdecosto.nombresubcentro')
                ->leftJoin('centrosdecosto','liquidacion_servicios.centrodecosto_id','=','centrosdecosto.id')
                ->leftJoin('subcentrosdecosto','liquidacion_servicios.subcentrodecosto_id','=','subcentrosdecosto.id')
                ->whereNull('liquidacion_servicios.autorizado')
                ->whereNull('liquidacion_servicios.anulado')
                ->whereNull('liquidacion_servicios.nomostrar')
                ->get();

    			  $otros_servicios = DB::table('otros_servicios_detalles')
    				->select('otros_servicios_detalles.consecutivo','otros_servicios_detalles.fecha_orden', 'otros_servicios_detalles.created_at',
                        'centrosdecosto.razonsocial','subcentrosdecosto.nombresubcentro','otros_servicios_detalles.valor','otros_servicios_detalles.total_ingresos_propios',
                        'otros_servicios_detalles.ciudad','otros_servicios_detalles.total_costo', 'otros_servicios_detalles.total_utilidad',
                        'otros_servicios_detalles.id','otros_servicios_detalles.autorizado', 'otros_servicios_detalles.anulado',
                        'centrosdecosto.tipo_cliente', 'otros_servicios.descuento')
                    ->leftJoin('centrosdecosto','otros_servicios_detalles.centrodecosto','=','centrosdecosto.id')
                    ->leftJoin('subcentrosdecosto','otros_servicios_detalles.subcentrodecosto','=','subcentrosdecosto.id')
                    ->leftJoin('otros_servicios', 'otros_servicios_detalles.id', '=', 'otros_servicios.id_servicios_detalles')
                    ->whereNull('otros_servicios_detalles.id_factura')
    				        ->whereNull('otros_servicios_detalles.autorizado')
                    ->whereNull('otros_servicios_detalles.anulado')
                    ->get();

            $ciudades = DB::table('ciudad')->get();
            $centrosdecosto = DB::table('centrosdecosto')
                ->whereNull('inactivo_total')
                ->orderBy('razonsocial')
                ->get();

            return View::make('facturacion.liquidacion_servicios')->with([
                'liquidaciones'=>$liquidaciones,
				        'otros_servicios'=>$otros_servicios,
                'ciudades'=>$ciudades,
                'centrosdecosto'=>$centrosdecosto,
                'permisos'=>$permisos
            ]);

        }

    }

    public function postBuscarliquidaciones(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if (Request::ajax()) {

                $fecha_inicial = Input::get('fecha_inicial');
                $fecha_final = Input::get('fecha_final');
                $centrodecosto = intval(Input::get('centrodecosto'));
                $subcentrodecosto = intval(Input::get('subcentrodecosto'));
                $ciudad = Input::get('ciudades');

                $consulta = "select liquidacion_servicios.id, liquidacion_servicios.consecutivo, centrosdecosto.razonsocial, liquidacion_servicios.fecha_autorizado, ".
                    "subcentrosdecosto.nombresubcentro, liquidacion_servicios.ciudad, liquidacion_servicios.fecha_registro,  liquidacion_servicios.fecha_inicial, ".
                    "liquidacion_servicios.fecha_final, liquidacion_servicios.total_facturado_cliente, liquidacion_servicios.total_costo, liquidacion_servicios.total_utilidad, liquidacion_servicios.autorizado, liquidacion_servicios.observaciones ".
                    "from liquidacion_servicios ".
                    "left join centrosdecosto on liquidacion_servicios.centrodecosto_id = centrosdecosto.id ".
                    "left join subcentrosdecosto on liquidacion_servicios.subcentrodecosto_id = subcentrosdecosto.id ".
                    "left join users on liquidacion_servicios.autorizado_por = users.id ";

                if (intval(Input::get('option'))===1) {
                    $consulta .= "where liquidacion_servicios.autorizado is null and liquidacion_servicios.anulado is null ";
                }else if(intval(Input::get('option'))===2){
                    $consulta .= "where liquidacion_servicios.facturado is null and liquidacion_servicios.autorizado is not null and liquidacion_servicios.anulado is null ";
                }

                if ($centrodecosto!=0) {
                    $consulta .= "and centrosdecosto.id = ".$centrodecosto." ";
                }

                if ($subcentrodecosto!=0) {
                    $consulta .= "and subcentrosdecosto.id = ".$subcentrodecosto." ";
                }

                if ($ciudad!='CIUDADES') {
                    $consulta .= "and liquidacion_servicios.ciudad = '".$ciudad."' ";
                }

                $liquidaciones = DB::select($consulta." and nomostrar is null");

                if ($liquidaciones!=null) {
                    return Response::json([
                        'respuesta'=>true,
                        'option'=>Input::get('option'),
                        'liquidaciones'=>$liquidaciones,
                        'consulta'=>$consulta
                    ]);
                }else{
                    return Response::json([
                        'respuesta'=>false,
                        'option'=>Input::get('option'),
                        'consulta'=>$consulta
                    ]);
                }

            }
        }

    }

    public function postAsignarnumeroplanilla(){

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else{

            if(Request::ajax()){

                $contador = 0;
                $errores = '';

                //ARRAYS TRAIDOS DE LOS VALORES SELECCIONADOS
                $dataidArray = json_decode(Input::get('dataidArray'));
                $checkArray = json_decode(Input::get('checkArray'));
                $rutaArray = json_decode(Input::get('rutaArray'));

                $recogerenArray = json_decode(Input::get('recogerenArray'));
                $dejarenArray = json_decode(Input::get('dejarenArray'));

                $recogerAr = json_decode(Input::get('recogerenArray'));

                $descripcionArray = json_decode(Input::get('descripcionArray'));

                $codcentrocostoArray = json_decode(Input::get('codcentrocostoArray'));
                $fechainicioArray = json_decode(Input::get('fechainicioArray'));
                $horainicioArray = json_decode(Input::get('horainicioArray'));
                $observacionArray = json_decode(Input::get('observacionArray'));
                $planillaArray = json_decode(Input::get('planillaArray'));

                //CICLO PARA LA CANTIDAD DE SERVICIOS SELECCIONADOS
                for ($i=0; $i < count($checkArray); $i++) {

                    //SI EL SERVICIO ES CHECKEADO ENTONCES
                    if ($checkArray[$i]==='true') {

                        //BUSQUE EL SERVICIO POR LA ID
                        $servicio = Servicio::find($dataidArray[$i]);
                        $servicio->ruta_id = $rutaArray[$i];
                        $servicio->recoger_en = $recogerenArray[$i];
                        $servicio->dejar_en = $dejarenArray[$i];
                        $servicio->detalle_recorrido = $descripcionArray[$i];
                        $servicio->fecha_servicio = $fechainicioArray[$i];
                        $servicio->hora_servicio = $horainicioArray[$i];
                        $servicio->save();

            						//BUSCAR TIPO DE VEHICULO, PARA CONSULTAR LA TARIFA Y AGREGARLA AUTOMATICAMENTE A LA TB FACTURACION
            						$vehiculo_id_serv = $servicio->vehiculo_id;
            						$serv_vehiculo = Vehiculo::find($vehiculo_id_serv);
            						$tipo_vehiculo_ser = $serv_vehiculo->clase;
            						$ciudad_serv = $servicio->ciudad;


            						if($tipo_vehiculo_ser === 'AUTOMOVIL' || $tipo_vehiculo_ser === 'CAMIONETA'){
            							$tarifa_cliente = DB::table('tarifa_traslado')->where('id',$servicio->ruta_id)->where('tarifa_ciudad',$ciudad_serv)->pluck('tarifa_cliente_automovil');

            							$tarifa_proveedor = DB::table('tarifa_traslado')->where('id',$servicio->ruta_id)->where('tarifa_ciudad',$ciudad_serv)->pluck('tarifa_proveedor_automovil');
            						}
            						if($tipo_vehiculo_ser === 'MICROBUS' ){
            							$tarifa_cliente = DB::table('tarifa_traslado')->where('id',$servicio->ruta_id)->where('tarifa_ciudad',$ciudad_serv)->pluck('tarifa_cliente_van');

            							$tarifa_proveedor = DB::table('tarifa_traslado')->where('id',$servicio->ruta_id)->where('tarifa_ciudad',$ciudad_serv)->pluck('tarifa_proveedor_van');
            						}
            						if($tipo_vehiculo_ser === 'BUS' ){
            							$tarifa_cliente = DB::table('tarifa_traslado')->where('id',$servicio->ruta_id)->where('tarifa_ciudad',$ciudad_serv)->pluck('tarifa_cliente_bus');

            							$tarifa_proveedor = DB::table('tarifa_traslado')->where('id',$servicio->ruta_id)->where('tarifa_ciudad',$ciudad_serv)->pluck('tarifa_proveedor_bus');
            						}
            						if($tipo_vehiculo_ser === 'BUSETA' ){
            							$tarifa_cliente = DB::table('tarifa_traslado')->where('id',$servicio->ruta_id)->where('tarifa_ciudad',$ciudad_serv)->pluck('tarifa_cliente_buseta');

            							$tarifa_proveedor = DB::table('tarifa_traslado')->where('id',$servicio->ruta_id)->where('tarifa_ciudad',$ciudad_serv)->pluck('tarifa_proveedor_buseta');
            						}
            						if($tipo_vehiculo_ser === 'MINIVAN' ){
            							$tarifa_cliente = DB::table('tarifa_traslado')->where('id',$servicio->ruta_id)->where('tarifa_ciudad',$ciudad_serv)->pluck('tarifa_cliente_minivan');

            							$tarifa_proveedor = DB::table('tarifa_traslado')->where('id',$servicio->ruta_id)->where('tarifa_ciudad',$ciudad_serv)->pluck('tarifa_proveedor_minivan');
            						}

                        //BUSCA EL REGISTRO DE LA FACTURA SEGUN EL ID
                        $factura = DB::table('facturacion')->where('servicio_id',$dataidArray[$i])->first();

                        //SI LA CONSULTA ESTA VACIA ENTONCES NO HAY UN REGISTRO EXISTENTE PARA ESA ID
                        if ($factura===null) {

                            //GUARDAR EL REGISTRO NUEVO
                            try {

                                //NUEVO REGISTRO PARA LA FACTURACION
                                $facturacion = new Facturacion();
                                $facturacion->cod_centro_costo = $codcentrocostoArray[$i];
                                $facturacion->observacion = $observacionArray[$i];
                                $facturacion->numero_planilla = $planillaArray[$i];
                                $facturacion->calidad_servicio = Input::get('calidad_servicio');
                                $facturacion->revisado = 1;
                                $facturacion->servicio_id = $dataidArray[$i];
                                $facturacion->creado_por = Sentry::getUser()->id;

                								//se valida q las variables tengan valores para agregar
                								if($tarifa_cliente != null || $tarifa_proveedor != null){
                									$facturacion->unitario_cobrado = $tarifa_cliente;
                									$facturacion->unitario_pagado = $tarifa_proveedor;
                								}


                                $array = [
                                    'fecha'=>date('Y-m-d H:i:s'),
                                    'accion'=>'OBSERVACION: '.$observacionArray[$i].', NUMERO DE CONSTANCIA: <span class="bolder">'.$planillaArray[$i].'</span>',
                                    'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                                ];

                                $facturacion->cambios_servicio = '['.json_encode($array).']';
                                $facturacion->save();

                            }catch (Exception $e) {

                                return Response::json([
                                    'respuesta'=>'error',
                                    'e'=>$e
                                ]);

                            }

                        //SI NO ENTONCES ACTUALIZA EL REGISTRO EN LA YA EXISTENTE
                        }elseif($factura=!null){

                            try {

                                $accion_a = '';
                                $accion_b = '';

                                //TOMAR LOS VALORES DEL CAMPO JSON PARA SABER SI ESTA VACIO O NO
                                $cambios = DB::table('facturacion')->where('servicio_id',$dataidArray[$i])->pluck('cambios_servicio');
                                //CONOCER EL NUMERO DE PLANILLA DEL SERVICIO
                                $numero_anterior = DB::table('facturacion')->where('servicio_id',$dataidArray[$i])->pluck('numero_planilla');
                                //BUSCAR EN LA FACTURA EL NUMERO
                                $obs = DB::table('facturacion')->where('servicio_id',$dataidArray[$i])->first();
                                //SI LA FACTURA NO SE HA REVISADO ENTONCES
                                if ($obs->revisado!=1) {

                                    $accion_a = 'OBSERVACION: <span class="bolder">'.$observacionArray[$i].'</span>';
                                    $accion_b = ', NUMERO DE CONSTANCIA: <span class="bolder">'.$planillaArray[$i].'</span>';

                                }else if($obs->revisado===1){

                                    if ($obs->observacion!=$observacionArray[$i]) {
                                        $accion_a = 'SE CAMBIO DE: <span class="bolder">'.$obs->observacion.'</span> A: <span class="bolder">'.$observacionArray[$i].'</span>';
                                    }else{
                                        $accion_a = 'SE MANTUVO LA OBSERVACION COMO: <span class="bolder">'.$obs->observacion.'</span>';
                                    }

                                    if($obs->numero_planilla!=$planillaArray[$i]){
                                        $accion_b = 'SE CAMBIO EL NUMERO DE CONSTANCIA DE: <span class="bolder">'.$obs->numero_planilla.'</span> A: <span class="bolder">'.$planillaArray[$i].'</span>';
                                    }else{
                                        $accion_b = 'SE MANTUVO EL NUMERO DE CONSTANCIA: <span class="bolder">'.$obs->numero_planilla.'</span>';
                                    }
                                }

                                if ($cambios!=null) {

                                    $cambios = json_decode($cambios);

                                    $array = [
                                        'fecha'=>date('Y-m-d H:i:s'),
                                        'accion'=>$accion_a.', '.$accion_b,
                                        'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                                    ];

                                    //ARRAY ADICIONADO
                                    array_push($cambios,$array);

                                    DB::table('facturacion')->where('servicio_id', $dataidArray[$i])
                                        ->update(array(
                                            'creado_por'=> Sentry::getUser()->id,
                                            'cod_centro_costo'=>$codcentrocostoArray[$i],
                                            'revisado'=>1,
                                            'observacion' => $observacionArray[$i],
                                            'numero_planilla'=>$planillaArray[$i],
                                            'cambios_servicio'=>json_encode($cambios),
                                            'calidad_servicio'=>Input::get('calidad_servicio'),
                                            'actualizado_por'=>Sentry::getUser()->id,
                                            'updated_at'=>date('Y-m-d H:i:s')
                                        ));

                                }else{

                                    $array = [
                                        'fecha'=>date('Y-m-d H:i:s'),
                                        'accion'=>$accion_a.', '.$accion_b,
                                        'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                                    ];

                                    DB::table('facturacion')->where('servicio_id', $dataidArray[$i])
                                        ->update(array(
                                            'creado_por'=> Sentry::getUser()->id,
                                            'cod_centro_costo'=>$codcentrocostoArray[$i],
                                            'revisado'=>1,
                                            'observacion' => $observacionArray[$i],
                                            'numero_planilla'=>$planillaArray[$i],
                                            'cambios_servicio'=>'['.json_encode($array).']',
                                            'calidad_servicio'=>Input::get('calidad_servicio'),
                                            'actualizado_por'=>Sentry::getUser()->id,
                                            'updated_at'=>date('Y-m-d H:i:s')
                                        ));
                                }

                            } catch (Exception $e) {
                                return Response::json([
                                    'respuesta'=>'error',
                                    'e'=>$e
                                ]);
                            }
                        }
                    }

                    $contador++;

                }

                if ($contador===0) {

                }else{

                    if($errores!=''){

                        return Response::json([
                            'respuesta'=>false,
                            'errores'=>$errores
                        ]);

                    }else{
                        return Response::json([
                            'respuesta'=>true,
                            'codcentrocostoArray'=>$codcentrocostoArray,
                            'factura'=>$factura
                        ]);
                    }

                }

            }

        }
    }

    public function getLiquidacion(){

        if (Sentry::check()) {
            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
            $ver = $permisos->facturacion->liquidacion->ver;
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

            $proveedores = Proveedor::Afiliadosinternos()
            ->orderBy('razonsocial')
            ->where('tipo_servicio', 'TRANSPORTE TERRESTRE')
            ->whereNull('inactivo_total')
            ->whereNull('inactivo')
            ->get();

            $conductores = Conductor::all();

            $centrosdecosto = Centrodecosto::Internos()->orderBy('razonsocial')->get();

            $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
            $usuarios = DB::table('users')->orderBy('first_name')->get();

            $servicios = Servicio::select('servicios.id','servicios.fecha_servicio','servicios.recoger_en','servicios.hora_servicio',
                    'servicios.dejar_en','servicios.pasajeros','servicios.resaltar',
                    'facturacion.numero_planilla','facturacion.observacion','facturacion.servicio_id','facturacion.liquidado_autorizado',
                    'facturacion.unitario_cobrado','facturacion.unitario_pagado','facturacion.total_cobrado',
                    'facturacion.total_pagado','facturacion.utilidad','facturacion.liquidado','facturacion.facturado',
                    'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo','facturacion.liquidado_autorizado',
                    'centrosdecosto.razonsocial','subcentrosdecosto.nombresubcentro',
                    'conductores.celular','conductores.telefono','conductores.nombre_completo',
                'proveedores.razonsocial as razonproveedor')
                ->join('users', 'servicios.creado_por', '=', 'users.id')
                ->join('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
                ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
                ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
                ->join('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
                ->join('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
                ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
                ->whereNull('servicios.afiliado_externo')
                ->where('fecha_servicio',date('Y-m-d'))
                ->whereNull('pendiente_autori_eliminacion')
                ->where('revisado',1)
                ->orderBy('fecha_servicio')
                ->get();

            return View::make('facturacion.liquidacion')
                ->with([
                    'proveedores'=>$proveedores,
                    'conductores'=>$conductores,
                    'centrosdecosto'=>$centrosdecosto,
                    'ciudades'=>$ciudades,
                    'usuarios'=>$usuarios,
                    'servicios'=>$servicios,
                    'permisos'=>$permisos,
                    'o'=>$o=1
                ]);
        }
    }

    /*
     * FUNCION PARA RECIBIR LOS DATOS COBRADOS Y PAGADOS EN LA LIQUIDACION DE SERVICIOS
     */
    public function postLiquidar(){

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else{

            if(Request::ajax()){

                $coment_totalc = '';
                $coment_totalp = '';
                $coment_totalu = '';

                //TOMAR LOS VALORES DE EL CAMPO CAMBIOS PARA CONOCER SI ESTA O NO VACIO
                $cambios = DB::table('facturacion')->where('servicio_id',Input::get('servicio_id'))->pluck('cambios_servicio');
                $liquidado = DB::table('facturacion')->where('servicio_id',Input::get('servicio_id'))->first();                

                //SI EL CAMPO CAMBIOS NO ESTA VACIO ENTONCES
                if ($cambios!=null) {
                    //SI EL CAMPO DE LA UTILIDAD NO ESTA VACIO ENTONCES ESTE SERVICIO YA HA SIDO LIQUIDADO
                    if ($liquidado->utilidad!=null) {

                        if (floatval($liquidado->total_cobrado)!=floatval(Input::get('unitario_cobrado'))) {
                            $coment_totalc = 'TOTAL COBRADO SE CAMBIO DE: <span class="bolder">$'.number_format($liquidado->total_cobrado).'</span> A: <span class="bolder">$'.number_format(Input::get('unitario_cobrado')).'</span>';
                        }else{
                            $coment_totalc = 'TOTAL COBRADO SE MANTUVO EN: <span class="bolder">$'.number_format($liquidado->total_cobrado).'</span>';
                        }

                        if (floatval($liquidado->total_pagado)!=floatval(Input::get('unitario_pagado'))) {
                            $coment_totalp = 'TOTAL PAGADO SE CAMBIO DE: <span class="bolder">$'.number_format($liquidado->total_pagado).'</span> A: <span class="bolder">$'.number_format(Input::get('unitario_pagado')).'</span>';
                        }else{
                            $coment_totalp = 'TOTAL PAGADO SE MANTUVO EN: <span class="bolder">$'.number_format($liquidado->total_pagado).'</span>';
                        }

                        if (floatval($liquidado->utilidad)!=floatval(Input::get('utilidad'))) {
                            $coment_totalu = 'UTILIDAD SE CAMBIO DE: <span class="bolder">$'.number_format($liquidado->total_cobrado).'</span> A: <span class="bolder">$'.number_format(Input::get('utilidad')).'</span>';
                        }else{
                            $coment_totalu = 'UTILIDAD SE MANTUVO EN: <span class="bolder">$'.number_format($liquidado->utilidad).'</span>';
                        }

                        $array = [
                            'fecha'=>date('Y-m-d H:i:s'),
                            'accion'=>$coment_totalc.','.$coment_totalp.','.$coment_totalu,
                            'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                        ];

                        $cambios = json_decode($cambios);
                        //ARRAY ADICIONADO A $CAMBIOS
                        array_push($cambios,$array);
                        //GUARDADO
                        $liquidar = DB::table('facturacion')
                            ->where('servicio_id', Input::get('servicio_id'))
                            ->update([
                                'cambios_servicio'=>json_encode($cambios),
                                'unitario_cobrado'=> Input::get('unitario_cobrado'),
                                'unitario_pagado'=> Input::get('unitario_pagado'),
                                'total_cobrado'=> Input::get('unitario_cobrado'),
                                'total_pagado'=> Input::get('unitario_pagado'),
                                'utilidad'=> Input::get('utilidad'),
                                'liquidado'=>1,
                            ]);
                            //$query = DB::table('facturacion')->where('')
                        //SI SE GUARDO EL REGISTRO ENTONCES
                        if ($liquidar!=null) {

                            return Response::json([
                                'respuesta'=>true,
                                'liquidar'=>$liquidado
                            ]);

                        }else{
                            //SI NO SE GUARDO ENTONCES
                            return Response::json([
                                'respuesta'=>false
                            ]);

                        }
                        //SI EL CAMPO UTILIDAD ESTA VACIO ENTONCES
                    }else{

                        $array = [
                            'fecha'=>date('Y-m-d H:i:s'),
                            'accion'=>'SERVICIO LIQUIDADO CON LOS SIGUIENTES VALORES TOTAL COBRADO = <span class="bolder">$'.number_format(Input::get('unitario_cobrado')).'</span>, TOTAL PAGADO = <span class="bolder">$'.number_format(Input::get('unitario_pagado')).'</span> Y UTILIDAD: <span class="bolder">$'.number_format(Input::get('utilidad')).'</span>',
                            'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                        ];

                        $cambios = json_decode($cambios);

                        array_push($cambios,$array);

                        $liquidar = DB::table('facturacion')
                            ->where('servicio_id', Input::get('servicio_id'))
                            ->update([
                                'cambios_servicio'=>json_encode($cambios),
                                'unitario_cobrado'=> Input::get('unitario_cobrado'),
                                'unitario_pagado'=> Input::get('unitario_pagado'),
                                'total_cobrado'=> Input::get('unitario_cobrado'),
                                'total_pagado'=> Input::get('unitario_pagado'),
                                'utilidad'=> Input::get('utilidad'),
                                'liquidado'=>1,
                            ]);

                        if ($liquidar!=null) {

                            return Response::json([
                                'respuesta'=>true,
                                'liquidar'=>$liquidado
                            ]);

                        }else{
                            //SI NO SE GUARDO ENTONCES
                            return Response::json([
                                'respuesta'=>false
                            ]);

                        }

                    }
                    //SI EL CAMPO CAMBIOS ESTA VACIO ENTONCES
                }else{
                    //SI EL CAMPO DE UTILIDAD NO ESTA VACIO QUIERE DECIR QUE YA TIENE UN REGISTRO
                    if ($liquidado->utilidad!=null) {

                        if (floatval($liquidado->total_cobrado)!=floatval(Input::get('unitario_cobrado'))) {
                            $coment_totalc = 'TOTAL COBRADO SE CAMBIO DE: <span class="bolder">$'.number_format($liquidado->total_cobrado).'</span> A: <span class="bolder">$'.number_format(Input::get('unitario_cobrado')).'</span>';
                        }else{
                            $coment_totalc = 'TOTAL COBRADO SE MANTUVO EN: <span class="bolder">$'.number_format($liquidado->total_cobrado).'</span>';
                        }

                        if (floatval($liquidado->total_pagado)!=floatval(Input::get('unitario_pagado'))) {
                            $coment_totalp = 'TOTAL PAGADO SE CAMBIO DE: <span class="bolder">$'.number_format($liquidado->total_pagado).'</span> A: <span class="bolder">$'.number_format(Input::get('unitario_pagado')).'</span>';
                        }else{
                            $coment_totalp = 'TOTAL PAGADO SE MANTUVO EN: <span class="bolder">$'.number_format($liquidado->total_pagado).'</span>';
                        }

                        if (floatval($liquidado->utilidad)!=floatval(Input::get('utilidad'))) {
                            $coment_totalu = 'UTILIDAD SE CAMBIO DE: <span class="bolder">$'.number_format($liquidado->total_cobrado).'</span> A: <span class="bolder">$'.number_format(Input::get('utilidad')).'</span>';
                        }else{
                            $coment_totalu = 'UTILIDAD SE MANTUVO EN: <span class="bolder">$'.number_format($liquidado->utilidad).'</span>';
                        }

                        $array = [
                            'fecha'=>date('Y-m-d H:i:s'),
                            'accion'=>$coment_totalc.', '.$coment_totalp.', '.$coment_totalu,
                            'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                        ];

                        //GUARDADO
                        $liquidar = DB::table('facturacion')
                            ->where('servicio_id', Input::get('servicio_id'))
                            ->update([
                                'cambios_servicio'=>'['.json_encode($array).']',
                                'unitario_cobrado'=> Input::get('unitario_cobrado'),
                                'unitario_pagado'=> Input::get('unitario_pagado'),
                                'total_cobrado'=> Input::get('unitario_cobrado'),
                                'total_pagado'=> Input::get('unitario_pagado'),
                                'utilidad'=> Input::get('utilidad'),
                                'liquidado'=>1,
                            ]);
                        //SI SE GUARDO EL REGISTRO ENTONCES
                        if ($liquidar!=null) {

                            return Response::json([
                                'respuesta'=>true,
                                'liquidar'=>$liquidado
                            ]);

                        }else{
                            //SI NO SE GUARDO ENTONCES
                            return Response::json([
                                'respuesta'=>false
                            ]);

                        }
                        //SI EL CAMPO UTILIDAD ESTA VACIO ENTONCES
                    }else{

                        $array = [
                            'fecha'=>date('Y-m-d H:i:s'),
                            'accion'=>'SERVICIO LIQUIDADO CON LOS SIGUIENTES VALORES TOTAL COBRADO = <span class="bolder">$'.number_format(Input::get('unitario_cobrado')).'</span>, TOTAL PAGADO = <span class="bolder">$'.number_format(Input::get('unitario_pagado')).'</span> Y UTILIDAD = $'.number_format(Input::get('utilidad')).'</span>',
                            'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                        ];

                        $liquidar = DB::table('facturacion')
                            ->where('servicio_id', Input::get('servicio_id'))
                            ->update([
                                'cambios_servicio'=>'['.json_encode($array).']',
                                'unitario_cobrado'=> Input::get('unitario_cobrado'),
                                'unitario_pagado'=> Input::get('unitario_pagado'),
                                'total_cobrado'=> Input::get('unitario_cobrado'),
                                'total_pagado'=> Input::get('unitario_pagado'),
                                'utilidad'=> Input::get('utilidad'),
                                'liquidado'=>1,
                            ]);

                        if ($liquidar!=null) {

                            return Response::json([
                                'respuesta'=>true,
                                'liquidar'=>$liquidado
                            ]);

                        }else{
                            //SI NO SE GUARDO ENTONCES
                            return Response::json([
                                'respuesta'=>false
                            ]);

                        }

                    }

                }

            }
        }
    }

    public function postContarserviciosliquidados(){

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else{

            if(Request::ajax()){

                $fecha_inicial = Input::get('fecha_inicial');
                $fecha_final = Input::get('fecha_final');
                $centrodecosto = Input::get('centrodecosto_id');
                $subcentro = Input::get('subcentrodecosto_id');
                $ciudades = Input::get('ciudad');

                $servicios = DB::table('servicios')
                    ->select('servicios.id','facturacion.numero_planilla')
                    ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
                    ->whereBetween('fecha_servicio', array($fecha_inicial, $fecha_final))
                    ->where('centrodecosto_id',$centrodecosto)
                    ->where('subcentrodecosto_id',$subcentro)
                    ->where('ciudad',$ciudades)
                    ->where('conductor_id','<>',0)
                    ->where('vehiculo_id','<>',0)
                    ->where('cancelado',0)
                    ->where('pendiente_autori_eliminacion',null)
                    ->orderBy('numero_planilla')
                    ->count();

                if ($servicios!=null) {

                    return Response::json([
                        'respuesta'=>true,
                        'servicios'=>$servicios
                    ]);

                }else{

                    return Response::json([
                        'respuesta'=>true,
                        'servicios'=>$servicios
                    ]);

                }
            }
        }
    }

    public function postAutorizarliquidacion(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if (Request::ajax()) {
                //ARRAY DE SERVICIOS
                $arrayS = explode(',',Input::get('idArrays'));

                $count = 0;

                //IDENTIFICAR SI LA LIQUIDACION FUE DIVIDIDA
                $divide = Input::get('divide');

                //VALOR PARA SABER SI TODOS LOS SERVICIOS HAN SIDO AUTORIZADOS
                $autorizado = Input::get('autorizado');

                //ID DE LA LIQUIDACION
                $id = Input::get('id');

                $id_detalle = Input::get('id_detalle');

                //ARRAY DE LOS CAMBIOS
                $array = [
                    'fecha'=>date('Y-m-d H:i:s'),
                    'accion'=>'SERVICIO AUTORIZADO PARA FACTURAR',
                    'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                ];

                //FOR PARA RECORRER LOS IDS
                for ($i=0; $i < count($arrayS) ; $i++) {

                    $cambios = DB::table('facturacion')->where('servicio_id',$arrayS[$i])->pluck('cambios_servicio');
                    $cambios = json_decode($cambios);

                    if ($cambios!=null) {
                        array_push($cambios,$array);
                        $guardarLiq = DB::table('facturacion')
                            ->where('servicio_id',$arrayS[$i])
                            ->update([
                                'liquidado_autorizado'=>1,
                                'cambios_servicio'=>json_encode($cambios)
                            ]);
                    }else{
                        $guardarLiq = DB::table('facturacion')
                            ->where('servicio_id',$arrayS[$i])
                            ->update([
                                'liquidado_autorizado'=>1,
                                'cambios_servicio'=>'['.json_encode($array).']'
                            ]);
                    }

                    if ($guardarLiq!=null) {
                        $count++;
                    }

                }
                $hola = null;
                //VARIABLE PARA SABER SI LA LIQUIDACION ESTA AUTORIZADA TOTALMENTE EL VALOR 1 DETERMINA EL AUTORIZADO
                if (intval($autorizado)===1) {

                    if($divide==='true'){

                        $aut = DB::update("update liquidacion_servicios set autorizado = ".$autorizado.", autorizado_por = ".Sentry::getUser()->id.", fecha_autorizado = '".date('Y-m-d H:i:s')."' where id_detalle = ".$id_detalle);
                        $hola = true;

                    }else{
                        $hola = false;
                        $aut = DB::update("update liquidacion_servicios set autorizado = ".$autorizado.", autorizado_por = ".Sentry::getUser()->id.", fecha_autorizado = '".date('Y-m-d H:i:s')."' where id = ".$id);
                        $total_cobrado = 0;
                        $total_costo = 0;
                        $utilidad = 0;

                        //CONSULTA PARA TOMAR LOS SERVICIOS ENLAZADOS A ESTA PRELIQUIDACION
                        $selLiq = DB::table('facturacion')->where('liquidacion_id',$id)->get();

                        //CICLO PARA REALIZAR LA SUMA DE LOS CAMBIOS EN LOS VALORES Y ACTUALIZARLOS EN LA PRELIQUIDACION
                        foreach ($selLiq as $key => $value) {
                            $total_cobrado = $total_cobrado+floatval($value->total_cobrado);
                            $total_costo = $total_costo+floatval($value->total_pagado);
                            $utilidad = $utilidad+floatval($value->utilidad);
                        }

                        $otros_ingresos = DB::table('liquidacion_servicios')->where('id', $id)->pluck('otros_ingresos');

                        $liquidacion = DB::table('liquidacion_servicios')
                            ->where('id',$id)
                            ->update([
                                'total_facturado_cliente'=>$total_cobrado+$otros_ingresos,
                                'total_costo'=>$total_costo,
                                'total_utilidad'=>$utilidad
                            ]);
                    }


                }

                if ($count!=0) {
                    return Response::json([
                        'respuesta'=>true,
                        'divide'=>$id_detalle,
                        'hola'=>$hola
                    ]);
                }else{
                    return Response::json([
                        'respuesta'=>false
                    ]);
                }

            }
        }
    }

    public function postExportarlistadocorteservicios(){

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else{

            $fecha_inicial = Input::get('fecha_inicial');
            $fecha_final = Input::get('fecha_final');
            $proveedores = Input::get('proveedores');
            $conductores = Input::get('conductores');
            $centrodecosto = Input::get('centrodecosto');
            $subcentro = Input::get('subcentrodecosto');
            $ciudades = Input::get('ciudades');

            //CONSULTA DE SERVICIOS TOTALES
            $consulta = "select * from servicios ".
                "left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id ".
                "left join subcentrosdecosto on servicios.subcentrodecosto_id = subcentrosdecosto.id ".
                "where fecha_servicio between '".Input::get('fecha_inicial')."' and '".Input::get('fecha_final')."' ";


            $consulta2 = "select * from servicios ".
                "left join facturacion on servicios.id = facturacion.servicio_id ".
                "left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id ".
                "left join subcentrosdecosto on servicios.subcentrodecosto_id = subcentrosdecosto.id ".
                "where servicios.fecha_servicio between '".Input::get('fecha_inicial')."' AND '".Input::get('fecha_final')."' ";

            //NUMERO DE SERVICIOS TOTALES

            //SI EL CONDUCTOR ES SELECCIONADO ENTONCES AGREGUELO A LA CONSULTA

            //SI EL CENTRO DE COSTO ES SELECCIONADO ENTONCES AGREGUELO A LA CONSULTA
            if($centrodecosto!='0'){
                $consulta .= " and servicios.centrodecosto_id = '".$centrodecosto."' ";
                $consulta2 .= " and servicios.centrodecosto_id = '".$centrodecosto."' ";
            }
            //SI EL SUBCENTRO DE COSTO ES SELECCIONADO ENTONCES AGREGUELO A LA CONSULTA
            if($subcentro!='0'){
                $consulta .= " and servicios.subcentrodecosto_id = '".$subcentro."' ";
                $consulta2 .= " and servicios.subcentrodecosto_id = '".$subcentro."' ";
            }
            //SI LA CIUDAD ES SELECCIONADA ENTONCES AGREGUELO A LA CONSULTA
            if($ciudades!='CIUDADES'){
                $consulta .= " and servicios.ciudad = '".$ciudades."' ";
                $consulta2 .= " and servicios.ciudad = '".$ciudades."' ";
            }

            $count_servicios_totales = count(DB::select($consulta. " and servicios.pendiente_autori_eliminacion is null"));
            $count_servicios_sin_revisar = count(DB::select($consulta2." and facturacion.liquidado is not null"));

            if(($count_servicios_totales-$count_servicios_sin_revisar)!= 0){
				$resul_count = $count_servicios_totales-$count_servicios_sin_revisar;
                return Redirect::to('facturacion/liquidacion')->with('mensaje','Hay '.$resul_count.' servicios pendientes por Revisar y/o Liquidar!');
            }else{

                ob_end_clean();
                ob_start();

                Excel::create('Listado', function($excel){

                    $excel->sheet('Servicios', function($sheet){
                        //TOMAR LOS VALORES DEL FORM-DATA
                        $fecha_inicial = Input::get('fecha_inicial');
                        $fecha_final = Input::get('fecha_final');
                        $servicio = Input::get('servicios');
                        $proveedores = Input::get('proveedores');
                        $conductores = Input::get('conductores');
                        $centrodecosto = Input::get('centrodecosto');
                        $subcentro = Input::get('subcentrodecosto');
                        $ciudades = Input::get('ciudades');

                        //STRING CONSULTA
                        $consulta = "select servicios.id, servicios.fecha_servicio, servicios.ciudad, servicios.solicitado_por, facturacion.numero_planilla, servicios.pasajeros, ".
                            "proveedores.razonsocial as prazonproveedor, servicios.recoger_en, servicios.dejar_en, centrosdecosto.razonsocial, ".
                            "subcentrosdecosto.nombresubcentro, facturacion.observacion, facturacion.unitario_cobrado, facturacion.unitario_pagado, ".
                            "facturacion.total_cobrado, total_pagado, facturacion.utilidad, facturacion.cod_centro_costo, ".
                            "facturacion.utilidad from facturacion ".
                            "left join servicios on facturacion.servicio_id = servicios.id ".
                            "left join subcentrosdecosto on servicios.subcentrodecosto_id = subcentrosdecosto.id ".
                            "left join proveedores on servicios.proveedor_id = proveedores.id ".
                            "left join conductores on servicios.conductor_id = conductores.id ".
                            "left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id ".
                            "where fecha_servicio between '".Input::get('fecha_inicial')."' and '".Input::get('fecha_final')."' ";
                        //SI EL PROVEEDOR ES SELECCIONADO ENTONCES AGREGUELO A LA CONSULTA
                        if($proveedores!='0'){
                            $consulta .= " and proveedores.id = '".$proveedores."' ";
                        }
                        //SI EL CONDUCTOR ES SELECCIONADO ENTONCES AGREGUELO A LA CONSULTA
                        if($conductores!='0'){
                            $consulta .= " and conductores.id = '".$conductores."' ";
                        }
                        //SI EL CENTRO DE COSTO ES SELECCIONADO ENTONCES AGREGUELO A LA CONSULTA
                        if($centrodecosto!='0'){
                            $consulta .= " and centrosdecosto.id = '".$centrodecosto."' ";
                        }
                        //SI EL SUBCENTRO DE COSTO ES SELECCIONADO ENTONCES AGREGUELO A LA CONSULTA
                        if($subcentro!='0'){
                            $consulta .= " and subcentrosdecosto.id = '".$subcentro."' ";
                        }
                        //SI LA CIUDAD ES SELECCIONADA ENTONCES AGREGUELO A LA CONSULTA
                        if($ciudades!='CIUDADES'){
                            $consulta .= " and servicios.ciudad = '".$ciudades."' ";
                        }
                        //REALIZE CONSULTA
                        //$servicios = DB::select($consulta." order by servicios.fecha_servicio asc ");
                        $servicios = DB::select($consulta);

                        $sheet->loadView('facturacion.exportarlistadocorte')
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
                            ->getStyle('A7:J7')->applyFromArray(array(
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
    }

    public function postGenerarliquidacion(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if(Request::ajax()){

                $option = Input::get('option');

                //CONTAR ORDENES DE FACTURACION PARA SABER SI YA EXISTE UNA ORDEN DE FACTURACION CON ESTOS VALORES
                $ordenes_facturacion = DB::table('ordenes_facturacion')
                    ->where('centrodecosto_id',Input::get('centrodecosto_id'))
                    ->where('subcentrodecosto_id',Input::get('subcentrodecosto_id'))
                    ->where('tipo_orden',1)
                    ->where('ciudad',Input::get('ciudad'))
                    ->where('anulado',null)
                    ->whereBetween('fecha_inicial', array(Input::get('fecha_inicial'), Input::get('fecha_final')))
                    ->whereBetween('fecha_final', array(Input::get('fecha_inicial'), Input::get('fecha_final')))->get();


                $liquidaciones = DB::table('liquidacion_servicios')
                    ->where('centrodecosto_id',Input::get('centrodecosto_id'))
                    ->where('subcentrodecosto_id',Input::get('subcentrodecosto_id'))
                    ->where('ciudad',Input::get('ciudad'))
                    ->whereBetween('fecha_inicial', array(Input::get('fecha_inicial'), Input::get('fecha_final')))
                    ->whereBetween('fecha_final', array(Input::get('fecha_inicial'), Input::get('fecha_final')))
                    ->where('anulado',null)->get();


                if (count($ordenes_facturacion) > 0  ) {

                    return Response::json([
                        'respuesta'=>'AT',
                        'ordenes_facturacion'=>$ordenes_facturacion
                    ]);

                }else if(count($liquidaciones) > 0){

          					return Response::json([
          						'respuesta'=>'OF',
          						'liquidaciones'=>$liquidaciones
          					]);

          			}else{

                    $liquidacion_servicios = new Liquidacionservicios;
                    $liquidacion_servicios->centrodecosto_id = Input::get('centrodecosto_id');
                    $liquidacion_servicios->subcentrodecosto_id = Input::get('subcentrodecosto_id');
                    $liquidacion_servicios->ciudad = Input::get('ciudad');
                    $liquidacion_servicios->fecha_registro = date('Y-m-d H:i:s');
                    $liquidacion_servicios->fecha_inicial = Input::get('fecha_inicial');
                    $liquidacion_servicios->fecha_final = Input::get('fecha_final');
                    $liquidacion_servicios->total_facturado_cliente = floatval(Input::get('total_generado_cobrado'))+floatval(Input::get('otros_ingresos'));
                    $liquidacion_servicios->total_costo = Input::get('total_generado_pagado');
                    $liquidacion_servicios->total_utilidad = Input::get('total_generado_utilidad');
                    $liquidacion_servicios->otros_ingresos = Input::get('otros_ingresos');
                    $liquidacion_servicios->otros_costos = Input::get('otros_costos');
                    $liquidacion_servicios->creado_por = Sentry::getUser()->id;
                    $liquidacion_servicios->observaciones = Input::get('observaciones');

                    if (isset($option)) {

                      if ($option==3) {

                        $liquidacion_servicios->afiliado_externo = 1;

                      }

                    }

                    if ($liquidacion_servicios->save()) {

                        $id = $liquidacion_servicios->id;
                        $liquidacion = Liquidacionservicios::find($id);

                        if (strlen(intval($id))===1) {
                            $liquidacion->consecutivo = 'OF000'.$id;
                            $liquidacion->save();
                        }elseif (strlen(intval($id))===2) {
                            $liquidacion->consecutivo = 'OF00'.$id;
                            $liquidacion->save();
                        }elseif(strlen(intval($id))===3){
                            $liquidacion->consecutivo = 'OF0'.$id;
                            $liquidacion->save();
                        }elseif(strlen(intval($id))===4){
                            $liquidacion->consecutivo = 'OF'.$id;
                            $liquidacion->save();
                        }else{
                            $liquidacion->consecutivo = 'OF'.$id;
                            $liquidacion->save();
                        }

                        $id_facturaArray = (explode(',', Input::get('id_facturaArray')));
                        $contar=0;

                        //CICLO PARA ENLAZAR LOS SERVICIOS A UNA LIQUIDACION
                        for ($i=0; $i <count($id_facturaArray); $i++) {

                            //REVISAR SI EL CAMPO CAMBIOS ESTA VACIO O NO
                            $cambios = DB::table('facturacion')->where('servicio_id',$id_facturaArray[$i])->pluck('cambios_servicio');
                            //CODIFICAR EL CAMPO CAMBIOS YA QUE ESTE AL SER TRAIDO DE LA BASE DE DATOS ES UN STRING
                            $cambios = json_decode($cambios);

                            $array = [
                                'fecha'=>date('Y-m-d H:i:s'),
                                'accion'=>'SERVICIO PREPARADO PARA AUTORIZAR EN LA PRE LIQUIDACION CON NUMERO CONSECUTIVO: <span class="bolder">'.$liquidacion->consecutivo.'</span>',
                                'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                            ];

                            //SI EL CAMPO CAMBIOS ESTA VACIO ENTONCES
                            if ($cambios!=null) {

                                //AGREGAR ARRAY A LOS VALORES
                                array_push($cambios,$array);
                                //AGREGAR EL CAMPO
                                DB::table('facturacion')
                                    ->where('servicio_id', $id_facturaArray[$i])
                                    ->update(array(
                                        'liquidacion_id' => $id,
                                        'cambios_servicio'=>json_encode($cambios)
                                    ));
                            }else{

                                DB::table('facturacion')
                                    ->where('servicio_id', $id_facturaArray[$i])
                                    ->update(array(
                                        'liquidacion_id' => $id,
                                        'cambios_servicio'=>'['.json_encode($array).']',
                                    ));
                            }

                            $contar++;
                        }

                        if ($contar>0) {

                            return Response::json([
                                'respuesta'=>true,
                                'contar'=>$contar,
                                'ordenes_facturacion'=>$ordenes_facturacion,
                                'id'=>$id
                            ]);

                        }else{
                            return Response::json([
                                'respuesta'=>'error',
                            ]);
                        }

                    }
                }

            }
        }
    }

	  public function postReegenerarliquidacion(){
		  if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
			if(Request::ajax()){
				$liquidacion_servicios_id = Input::get('liquidacion_servicios_id');
				$liquidacion_serv = Liquidacionservicios::find($liquidacion_servicios_id);

				$liquidacion_serv->total_facturado_cliente = floatval(Input::get('total_generado_cobrado'))+floatval(Input::get('otros_ingresos'));
				$liquidacion_serv->total_costo = Input::get('total_generado_pagado');
				$liquidacion_serv->total_utilidad = Input::get('total_generado_utilidad');
				$liquidacion_serv->otros_ingresos = Input::get('otros_ingresos');
				$liquidacion_serv->otros_costos = Input::get('otros_costos');
				$liquidacion_serv->observaciones = Input::get('observaciones');
				$liquidacion_serv->save();

				$id_facturaArray = (explode(',', Input::get('id_facturaArray')));
				$contar=0;

				//COMPARAR SERVICIOS QUE HAY EN LA BASE DE DATOS CON LOS NUEVOS
				$servicio_Ant = DB::table('facturacion')->where('liquidacion_id', $liquidacion_servicios_id)->get();
				foreach ($servicio_Ant as $key2 => $value2){
					$existe = 0;
					for ($i=0; $i <count($id_facturaArray); $i++){
						if(strval($value2->servicio_id) === strval($id_facturaArray[$i])){
							$existe++;
						}
					}
					//CICLO PARA ENLAZAR LOS SERVICIOS A LA LIQUIDACION $liquidacion_servicios_id
					if($existe === 0){
						$cambios = DB::table('facturacion')->where('servicio_id',$value2->servicio_id)->pluck('cambios_servicio');
                        //CODIFICAR EL CAMPO CAMBIOS YA QUE ESTE AL SER TRAIDO DE LA BASE DE DATOS ES UN STRING
                        $cambios = json_decode($cambios);

                        $array = [
                            'fecha'=>date('Y-m-d H:i:s'),
                            'accion'=>'SERVICIO DESVINCUNLADO DEL CONSECUTIVO: <span class="bolder">OF'.$liquidacion_servicios_id.'</span>',
                            'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                        ];
						//SI EL CAMPO CAMBIOS ESTA VACIO ENTONCES
						if ($cambios!=null) {
							//AGREGAR ARRAY A LOS VALORES
							array_push($cambios,$array);
							//AGREGAR EL CAMPO
							DB::table('facturacion')
								->where('servicio_id', $value2->servicio_id)
								->update(array(
									'liquidacion_id' => null,
									'liquidado_autorizado'=>null,
									'cambios_servicio'=>json_encode($cambios)
								));
						}else{
							DB::table('facturacion')
								->where('servicio_id', $value2->servicio_id)
								->update(array(
									'liquidacion_id' => null,
									'liquidado_autorizado'=>null,
									'cambios_servicio'=>'['.json_encode($array).']',
								));
						}
					}
				}

				//COMPARAR LOS SERVICIOS NUEVOS CON LOS QUE ESTAN EN LA BASE DE DATOS
				$servicio_act = DB::table('facturacion')->where('liquidacion_id', $liquidacion_servicios_id)->get();
				for ($i=0; $i <count($id_facturaArray); $i++) {
					$existe = 0;
					foreach ($servicio_act as $key3 => $value3){
						if(strval($id_facturaArray[$i]) === strval($value3->servicio_id)){
							$existe++;
						}
					}
					//CICLO PARA ENLAZAR LOS SERVICIOS A LA LIQUIDACION $liquidacion_servicios_id
					if($existe === 0){
						//REVISAR SI EL CAMPO CAMBIOS ESTA VACIO O NO
						$cambios = DB::table('facturacion')->where('servicio_id',$id_facturaArray[$i])->pluck('cambios_servicio');
						//CODIFICAR EL CAMPO CAMBIOS YA QUE ESTE AL SER TRAIDO DE LA BASE DE DATOS ES UN STRING
						$cambios = json_decode($cambios);
						$array = [
							'fecha'=>date('Y-m-d H:i:s'),
							'accion'=>'SERVICIO PREPARADO PARA AUTORIZAR EN LA PRE LIQUIDACION CON NUMERO CONSECUTIVO: <span class="bolder">OF'.$liquidacion_servicios_id.'</span>',
							'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
						];
						//SI EL CAMPO CAMBIOS ESTA VACIO ENTONCES
						if ($cambios!=null) {
							//AGREGAR ARRAY A LOS VALORES
							array_push($cambios,$array);
							//AGREGAR EL CAMPO
							DB::table('facturacion')
								->where('servicio_id', $id_facturaArray[$i])
								->update(array(
									'liquidacion_id' => $liquidacion_servicios_id,
									'cambios_servicio'=>json_encode($cambios)
								));
						}else{
							DB::table('facturacion')
								->where('servicio_id', $id_facturaArray[$i])
								->update(array(
									'liquidacion_id' => $liquidacion_servicios_id,
									'cambios_servicio'=>'['.json_encode($array).']',
								));
						}
					}
				}

				return Response::json([
					'respuesta'=>true,
					'contar'=>$contar
				]);

			}
		}
	  }

    public function postAnularliquidacion(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if(Request::ajax()){

                $liquidacion_servicios = Liquidacionservicios::find(Input::get('id'));
                $liquidacion_servicios->anulado = 1;
                $liquidacion_servicios->anulado_por = Sentry::getUser()->id;

                if ($liquidacion_servicios->save()) {

                    $facturacion = DB::table('facturacion')->where('liquidacion_id',Input::get('id'))->get();

                    foreach ($facturacion as $key => $value) {

                        $cambios = DB::table('facturacion')->where('servicio_id',$value->servicio_id)->pluck('cambios_servicio');
                        //CODIFICAR EL CAMPO CAMBIOS YA QUE ESTE AL SER TRAIDO DE LA BASE DE DATOS ES UN STRING
                        $cambios = json_decode($cambios);

                        $array = [
                            'fecha'=>date('Y-m-d H:i:s'),
                            'accion'=>'SERVICIO DESVINCUNLADO POR ANULACION DE LA PRELIQUIDACION CON NUMERO CONSECUTIVO: <span class="bolder">'.$liquidacion_servicios->consecutivo.'</span>',
                            'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                        ];

                        //REVISAR SI EL CAMPO ESTA O NO VACIO PARA AGREGAR EL ARRAY
                        if ($cambios!=null) {

                            //AGREGAR ARRAY A LOS VALORES
                            array_push($cambios,$array);
                            //AGREGAR EL CAMPO
                            DB::table('facturacion')
                                ->where('servicio_id', $value->servicio_id)
                                ->update(array(
                                    'liquidacion_id'=>null,
                                    'liquidado_autorizado'=>null,
                                    'cambios_servicio'=>json_encode($cambios)
                                ));

                        }else{

                            DB::table('facturacion')
                                ->where('servicio_id', $value->servicio_id)
                                ->update(array(
                                    'liquidacion_id' => null,
                                    'liquidado_autorizado'=>null,
                                    'cambios_servicio'=>'['.json_encode($array).']'
                                ));

                        }

                    }

                    return Response::json([
                        'respuesta'=>true,
                        'liquidacion_servicios'=>$liquidacion_servicios
                    ]);
                }else{
                    return Response::json([
                        'respuesta'=>false,
                        'liquidacion_servicios'=>$liquidacion_servicios
                    ]);
                }

            }
        }
    }

    public function getServiciosautorizados(){

        if (Sentry::check()) {

          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->facturacion->autorizar->ver;

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

            $ciudad = DB::table('ciudad')->orderBy('ciudad')->get();
            $centrosdecosto = DB::table('centrosdecosto')
                ->whereNull('inactivo_total')
                ->orderBy('razonsocial')
                ->get();

            $consulta = "select liquidacion_servicios.*, centrosdecosto.razonsocial, subcentrosdecosto.nombresubcentro ".
                "from liquidacion_servicios ".
                "left join centrosdecosto on liquidacion_servicios.centrodecosto_id = centrosdecosto.id ".
                "left join subcentrosdecosto on liquidacion_servicios.subcentrodecosto_id = subcentrosdecosto.id ".
                "where liquidacion_servicios.autorizado is not null and liquidacion_servicios.facturado is null and liquidacion_servicios.anulado is null ";

            $liquidaciones = DB::select($consulta);

      			$otros_servicios = DB::table('otros_servicios_detalles')
      				->select('otros_servicios_detalles.consecutivo','otros_servicios_detalles.fecha_orden', 'otros_servicios_detalles.created_at',
                          'centrosdecosto.razonsocial','subcentrosdecosto.nombresubcentro','otros_servicios_detalles.valor',
                          'otros_servicios_detalles.total_ingresos_propios', 'otros_servicios.descuento',
                          'otros_servicios_detalles.ciudad','otros_servicios_detalles.total_costo', 'otros_servicios_detalles.total_utilidad',
                          'otros_servicios_detalles.id','otros_servicios_detalles.autorizado', 'otros_servicios_detalles.anulado',
                          'centrosdecosto.tipo_cliente')
                      ->leftJoin('centrosdecosto','otros_servicios_detalles.centrodecosto','=','centrosdecosto.id')
                      ->leftJoin('subcentrosdecosto','otros_servicios_detalles.subcentrodecosto','=','subcentrosdecosto.id')
                      ->leftJoin('otros_servicios', 'otros_servicios_detalles.id', '=', 'otros_servicios.id_servicios_detalles')
                      ->whereNull('otros_servicios_detalles.id_factura')
                      ->whereNull('otros_servicios_detalles.anulado')
      				->where('otros_servicios_detalles.autorizado',1)
              ->get();

            return View::make('facturacion.serviciosautorizados',[
                'centrosdecosto'=>$centrosdecosto,
                'ciudades'=>$ciudad,
                'liquidaciones'=>$liquidaciones,
				        'otros_servicios'=>$otros_servicios,
                'permisos'=>$permisos
            ]);
        }
    }

    public function postVerliquidacionservicios(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if(Request::ajax()){

                $liquidacion_servicios = DB::table('liquidacion_servicios')->where('id',Input::get('id'))->first();
                $facturacion = DB::table('facturacion')->where('liquidacion_id',$liquidacion_servicios->id)->get();

                $total_generado_cobrado = 0;
                $total_generado_pagado = 0;
                $total_generado_utilidad = 0;
                $arrayId = [];

                foreach ($facturacion as $key => $value) {
                    array_push($arrayId,$value->servicio_id);
                    $total_generado_cobrado = $total_generado_cobrado+floatval($value->total_cobrado);
                    $total_generado_pagado = $total_generado_pagado+floatval($value->total_pagado);
                    $total_generado_utilidad = $total_generado_utilidad+floatval($value->utilidad);
                }

                if ($liquidacion_servicios!=null) {

                    return Response::json([
                        'respuesta'=>true,
                        'liquidacion_servicios'=>$liquidacion_servicios,
                        'id_facturaArray'=>$arrayId,
                        'total_generado_cobrado'=>$total_generado_cobrado,
                        'total_generado_pagado'=>$total_generado_pagado,
                        'total_generado_utilidad'=>$total_generado_utilidad,
                        'otros_ingresos' => $liquidacion_servicios->otros_ingresos,
                        'otros_costos' => $liquidacion_servicios->otros_costos
                    ]);

                }else{

                    return Response::json([
                        'respuesta'=>false,
                        'liquidacion_servicios'=>$liquidacion_servicios
                    ]);

                }
            }

        }
    }

    public function postVercentrodecosto(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if (Request::ajax()) {

                $centrosdecosto = DB::table('centrosdecosto')->orderBy('razonsocial')->get();

                return Response::json([
                    'respuesta'=>true,
                    'centrosdecosto'=>$centrosdecosto
                ]);

            }else{

                return Response::json([
                    'respuesta'=>false
                ]);
            }
        }
    }

    public function postVersubcentros(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if (Request::ajax()) {

                $id = Input::get('id');
                $subcentrosdecosto = DB::table('subcentrosdecosto')->where('centrosdecosto_id', $id)->orderBy('nombresubcentro')->get();

                return Response::json([
                    'respuesta'=>true,
                    'subcentros'=>$subcentrosdecosto
                ]);

            }else{

                return Response::json([
                    'respuesta'=>false
                ]);
            }
        }
    }

    public function postDividirpreliquidaciones(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if (Request::ajax()) {

                //CONTAR ORDENES DE FACTURACION PARA SABER SI YA EXISTE UNA ORDEN DE FACTURACION CON ESTOS VALORES
                $ordenes_facturacion = DB::table('ordenes_facturacion')
                    ->where('centrodecosto_id',Input::get('centrodecosto_id'))
                    ->where('subcentrodecosto_id',Input::get('subcentrodecosto_id'))
                    ->where('tipo_orden',1)
                    ->where('ciudad',Input::get('ciudad'))
                    ->where('anulado',null)
                    ->whereBetween('fecha_inicial', array(Input::get('fecha_inicial'), Input::get('fecha_final')))
                    ->whereBetween('fecha_final', array(Input::get('fecha_inicial'), Input::get('fecha_final')))
                    ->count();

                $liquidaciones = DB::table('liquidacion_servicios')
                    ->where('centrodecosto_id',Input::get('centrodecosto_id'))
                    ->where('subcentrodecosto_id',Input::get('subcentrodecosto_id'))
                    ->where('ciudad',Input::get('ciudad'))
                    ->whereBetween('fecha_inicial', array(Input::get('fecha_inicial'), Input::get('fecha_final')))
                    ->whereBetween('fecha_final', array(Input::get('fecha_inicial'), Input::get('fecha_final')))
                    ->where('anulado',null)
                    ->count();

                if ($ordenes_facturacion>0 or $liquidaciones>0) {

                    return Response::json([
                        'respuesta'=>false,
                        'ordenes_facturacion',$ordenes_facturacion
                    ]);

                }else{

                    //VALORES PARA GENERAR LA PRE-LIQUIDACION INICIAL
                    $centrodecosto_id = Input::get('centrodecosto_id');
                    $subcentrodecosto_id = Input::get('subcentrodecosto_id');
                    $fecha_inicial = Input::get('fecha_inicial');
                    $fecha_final = Input::get('fecha_final');
                    $ciudad = Input::get('ciudad');
                    $total_cobrado = floatval(Input::get('total_cobrado'));
                    $total_pagado = Input::get('total_pagado');
                    $total_utilidad = Input::get('total_utilidad');
                    $otros_ingresos = floatval(Input::get('otros_ingresos'));
                    $otros_costos = Input::get('otros_costos');

                    //ARRAYS
                    $totales_cobrado = Input::get('totales_cobrado');
                    $totales_pagado = Input::get('totales_pagado');
                    $totales_utilidad = Input::get('totales_utilidad');
                    $valor_adicional = Input::get('valor_adicional');
                    $totales_cobrado_final = Input::get('totales_cobrado_final');
                    $centrosdecosto = Input::get('centrosdecosto');
                    $subcentrosdecosto = Input::get('subcentrosdecosto');
                    $id_facturaArray = Input::get('id_facturaArray');

                    $liquidacion_servicios = new Liquidacionservicios;
                    $liquidacion_servicios->centrodecosto_id = $centrodecosto_id;
                    $liquidacion_servicios->subcentrodecosto_id = $subcentrodecosto_id;
                    $liquidacion_servicios->ciudad = $ciudad;
                    $liquidacion_servicios->fecha_registro = date('Y-m-d H:i:s');
                    $liquidacion_servicios->fecha_inicial = $fecha_inicial;
                    $liquidacion_servicios->fecha_final = $fecha_final;
                    $liquidacion_servicios->total_facturado_cliente = $total_cobrado;
                    $liquidacion_servicios->total_costo = $total_pagado;
                    $liquidacion_servicios->total_utilidad = $total_utilidad;
                    $liquidacion_servicios->otros_ingresos = $otros_ingresos;
                    $liquidacion_servicios->otros_costos = $otros_costos;
                    $liquidacion_servicios->creado_por = Sentry::getUser()->id;
                    $liquidacion_servicios->observaciones = Input::get('observaciones');
                    $liquidacion_servicios->nomostrar = 1;

                    if ($liquidacion_servicios->save()){

                        $results = DB::select("select * from liquidacion_servicios where consecutivo is not null order by consecutivo desc limit 1");

                        for ($i=0; $i <count($totales_cobrado); $i++) {

                            $liquidacion = new Liquidacionservicios();

                            $liquidacion->centrodecosto_id = $centrosdecosto[$i];
                            $liquidacion->subcentrodecosto_id = $subcentrosdecosto[$i];
                            $liquidacion->fecha_inicial = $fecha_inicial;
                            $liquidacion->fecha_final = $fecha_final;
                            $liquidacion->ciudad = $ciudad;
                            $liquidacion->total_facturado_cliente = floatval($totales_cobrado[$i]);
                            $liquidacion->valor_adicional = floatval($valor_adicional[$i]);
                            $liquidacion->total_costo = $totales_pagado[$i];
                            $liquidacion->total_utilidad = $totales_utilidad[$i];
                            $liquidacion->dividida = 1;
                            $liquidacion->fecha_registro = date('Y-m-d H:i:s');
                            $liquidacion->creado_por = Sentry::getUser()->id;
                            $liquidacion->created_at = date('Y-m-d H:i:s');
                            $liquidacion->updated_at = date('Y-m-d H:i:s');
                            $liquidacion->id_detalle = $liquidacion_servicios->id;

                            if($liquidacion->save()){

                                $id = $liquidacion->id;
                                if (strlen(intval($id))===1) {
                                    $liquidacion->consecutivo = 'OF000'.$id;
                                    $liquidacion->save();
                                }elseif (strlen(intval($id))===2) {
                                    $liquidacion->consecutivo = 'OF00'.$id;
                                    $liquidacion->save();
                                }elseif(strlen(intval($id))===3){
                                    $liquidacion->consecutivo = 'OF0'.$id;
                                    $liquidacion->save();
                                }elseif(strlen(intval($id))===4){
                                    $liquidacion->consecutivo = 'OF'.$id;
                                    $liquidacion->save();
                                }else{
                                    $liquidacion->consecutivo = 'OF'.$id;
                                    $liquidacion->save();
                                }
                            }
                        }

                        for ($i=0; $i <count($id_facturaArray); $i++) {

                            $cambios = DB::table('facturacion')->where('servicio_id',$id_facturaArray[$i])->pluck('cambios_servicio');
                            //CODIFICAR EL CAMPO CAMBIOS YA QUE ESTE AL SER TRAIDO DE LA BASE DE DATOS ES UN STRING
                            $cambios = json_decode($cambios);

                            $array = [
                                'fecha'=>date('Y-m-d H:i:s'),
                                'accion'=>'SERVICIO PREPARADO PARA AUTORIZAR EN LA PRE LIQUIDACION MULTIPLE CON ID: <span class="bolder">'.$liquidacion_servicios->id.'</span>',
                                'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                            ];

                            //SI EL CAMPO CAMBIOS ESTA VACIO ENTONCES
                            if ($cambios!=null) {

                                //AGREGAR ARRAY A LOS VALORES
                                array_push($cambios,$array);
                                //AGREGAR EL CAMPO
                                DB::table('facturacion')
                                    ->where('servicio_id', $id_facturaArray[$i])
                                    ->update(array(
                                        'liquidacion_id' => $liquidacion_servicios->id,
                                        'cambios_servicio'=>json_encode($cambios)
                                    ));
                            }else{

                                DB::table('facturacion')
                                    ->where('servicio_id', $id_facturaArray[$i])
                                    ->update(array(
                                        'liquidacion_id' => $liquidacion_servicios->id,
                                        'cambios_servicio'=>'['.json_encode($array).']',
                                    ));
                            }

                        }

                        return Response::json([
                            'respuesta'=>true,
                            'count'=>count($totales_cobrado)
                        ]);
                    }
                }
            }
        }
    }
    ##############FIN LIQUIDACION###################

    ##############ORDENES DE FACTURACION############
    public function postBuscarordenesfacturacion(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if (Request::ajax()) {

                $fecha_inicial = Input::get('fecha_inicial');
                $fecha_final = Input::get('fecha_final');
                $centrodecosto = intval(Input::get('centrodecosto'));
                $subcentrodecosto = intval(Input::get('subcentrodecosto'));
                $ciudad = Input::get('ciudades');
                $opcion = intval(Input::get('opcion'));
                $opcion2 = intval(Input::get('opcion2'));
                $numero = Input::get('numero');
                $tipo_cliente = Input::get('tipo_cliente');

                $consulta = "select ordenes_facturacion.id, ordenes_facturacion.consecutivo, centrosdecosto.razonsocial, ".
                    "subcentrosdecosto.nombresubcentro, ".
                    "ordenes_facturacion.ciudad, ordenes_facturacion.fecha_expedicion,  ordenes_facturacion.fecha_inicial, centrosdecosto.credito, centrosdecosto.plazo_pago, ".
                    "ordenes_facturacion.fecha_final, ordenes_facturacion.numero_factura, ordenes_facturacion.total_facturado_cliente, ".
                    "ordenes_facturacion.fecha_factura, ordenes_facturacion.anulado, ordenes_facturacion.revision_ingreso, ordenes_facturacion.ingreso, ".
                    "ordenes_facturacion.tipo_orden, centrosdecosto.tipo_cliente ".
                    "from ordenes_facturacion ".
                    "left join centrosdecosto on ordenes_facturacion.centrodecosto_id = centrosdecosto.id ".
                    "left join subcentrosdecosto on ordenes_facturacion.subcentrodecosto_id = subcentrosdecosto.id ".
                    "where ordenes_facturacion.id is not null ";

                if ($tipo_cliente==1) {
                  $consulta .= "and (centrosdecosto.tipo_cliente = 2 or centrosdecosto.tipo_cliente is null) ";
                }

                if ($tipo_cliente==3) {
                  $consulta .= "and centrosdecosto.tipo_cliente = 2 ";
                }

                if ($centrodecosto!=0) {
                    $consulta .= "and centrosdecosto.id = ".$centrodecosto." ";
                }

                if ($subcentrodecosto!=0) {
                    $consulta .= "and subcentrosdecosto.id = ".$subcentrodecosto." ";
                }

                if ($numero!='') {

                    if ($opcion2===2) {
                        $consulta .= "and ordenes_facturacion.numero_factura = '".$numero."' ";
                    }elseif ($opcion2===1) {
                        $consulta .= "and ordenes_facturacion.consecutivo = '".$numero."' ";
                    }

                }

                if ($opcion!=0) {
                    $consulta .= "and fecha_expedicion between '".$fecha_inicial." 00:00:01' and '".$fecha_final." 23:59:59' ";
                    if ($opcion===1) {
                        $consulta .= "and ordenes_facturacion.ingreso is null and ordenes_facturacion.anulado is null ";
                    }else if ($opcion===2) {
                        $consulta .= "and ordenes_facturacion.ingreso = 1 and ordenes_facturacion.revision_ingreso is null ";
                    }else if ($opcion===3) {
                        $consulta .= "and ordenes_facturacion.ingreso = 1 and ordenes_facturacion.revision_ingreso = 1";
                    }

                }else if ($opcion2===0) {
                    $consulta .= "and fecha_expedicion between '".$fecha_inicial." 00:00:01' and '".$fecha_final." 23:59:59' ";
                }

                if ($ciudad!='CIUDADES') {
                    $consulta .= "and ordenes_facturacion.ciudad = '".$ciudad."' ";
                }

                $ordenes_facturacion = DB::select($consulta." and ordenes_facturacion.nomostrar is null ");

                if ($ordenes_facturacion!=null) {

                    return Response::json([
                        'respuesta'=>true,
                        'ordenes_facturacion'=>$ordenes_facturacion,
                        'consulta'=>$consulta
                    ]);

                }else{
                    return Response::json([
                        'respuesta'=>false
                    ]);
                }

            }
        }
    }

    public function postNuevafactura(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if(Request::ajax()){

                $afiliado_externo = Input::get('afiliado_externo');

                //CONTAR ORDENES DE FACTURACION PARA SABER SI YA EXISTE UNA ORDEN DE FACTURACION CON ESTOS VALORES
                $ordenes_facturacion = DB::table('ordenes_facturacion')
                    ->where('centrodecosto_id',Input::get('centrodecosto_id'))
                    ->where('subcentrodecosto_id',Input::get('subcentrodecosto_id'))
                    ->where('tipo_orden',1)
                    ->where('ciudad',Input::get('ciudad'))
                    ->where('anulado',null)
                    ->whereBetween('fecha_inicial', array(Input::get('fecha_inicial'), Input::get('fecha_final')))
                    ->whereBetween('fecha_final', array(Input::get('fecha_inicial'), Input::get('fecha_final')))
                    ->count();

                if ($ordenes_facturacion>0) {

                    return Response::json([
                        'respuesta'=>false,
                        'ordenes_facturacion',$ordenes_facturacion
                    ]);

                }else{

                    //SABER EL ULTIMO NUMERO DE FACTURA QUE SE AGREGO PARA AUTOMATIZAR EL CONTADOR CABE RESALTAR QUE ESTO SOLO FUNCIONARA CUANDO HAYA ALGUN NUMERO DE FACTURA,
                    //EN EL CASO DE QUE HAYA QUE COMENZAR DESDE 0 TOCARIA CAMBIAR PARTE DE ESTE CODIGO
                    $ultimo_id = DB::table('ordenes_facturacion')
                        ->select('id','numero_factura')
                        ->orderBy('id','desc')
                        ->first();

                    //NUEVA ORDEN DE FACTURA
                    $orden_facturacion = new Ordenfactura;
                    $orden_facturacion->centrodecosto_id = Input::get('centrodecosto_id');
                    $orden_facturacion->subcentrodecosto_id = Input::get('subcentrodecosto_id');
                    $orden_facturacion->ciudad = Input::get('ciudad');
                    $orden_facturacion->fecha_expedicion = date('Y-m-d H:i:s');
                    $orden_facturacion->fecha_inicial = Input::get('fecha_inicial');
                    $orden_facturacion->fecha_final = Input::get('fecha_final');
                    $orden_facturacion->tipo_orden = 1;
                    $orden_facturacion->total_facturado_cliente = floatval(Input::get('total_generado_cobrado'))+floatval(Input::get('otros_ingresos'));
                    $orden_facturacion->total_costo = Input::get('total_generado_pagado');
                    $orden_facturacion->total_utilidad = Input::get('total_generado_utilidad');
                    $orden_facturacion->numero_factura = intval($ultimo_id->numero_factura)+1;
                    $orden_facturacion->creado_por = Sentry::getUser()->id;
                    $orden_facturacion->fecha_factura = date('Y-m-d');
                    $orden_facturacion->otros_ingresos = Input::get('otros_ingresos');
                    $orden_facturacion->otros_costos = Input::get('otros_costos');
                    $orden_facturacion->observaciones = Input::get('observaciones_liq');
                    $orden_facturacion->facturado = 1;

                    if (isset($afiliado_externo)) {

                      if ($afiliado_externo==1) {
                          $orden_facturacion->afiliado_externo = 1;
                      }

                    }

                    $centrodecosto = Centrodecosto::find(Input::get('centrodecosto_id'));

                    if ($centrodecosto->tipo_cliente==2) {
                        $orden_facturacion->afiliado_externo = 1;
                    }

                    if ($orden_facturacion->save()) {

                        $id = $orden_facturacion->id;
                        $orden = Ordenfactura::find($id);

                        if (strlen(intval($id))===1) {
                            $orden->consecutivo = 'AT000'.$id;
                            $orden->save();
                        }elseif (strlen(intval($id))===2) {
                            $orden->consecutivo = 'AT00'.$id;
                            $orden->save();
                        }elseif(strlen(intval($id))===3){
                            $orden->consecutivo = 'AT0'.$id;
                            $orden->save();
                        }elseif(strlen(intval($id))===4){
                            $orden->consecutivo = 'AT'.$id;
                            $orden->save();
                        }

                        $id_facturaArray = (explode(',', Input::get('id_facturaArray')));
                        $contar=0;

                        //COLOCAR LOS NUMEROS DE FACTURA Y EL ESTADO FACTURADO A LOS SERVICIOS
                        for ($i=0; $i <count($id_facturaArray); $i++) {

                            //REVISAR SI EL CAMPO CAMBIOS ESTA VACIO O NO
                            $cambios = DB::table('facturacion')->where('servicio_id',$id_facturaArray[$i])->pluck('cambios_servicio');
                            //CODIFICAR EL CAMPO CAMBIOS YA QUE ESTE AL SER TRAIDO DE LA BASE DE DATOS ES UN STRING
                            $cambios = json_decode($cambios);
                            //ASIGNAR LOS VALORES A LOS CAMPOS FACTURA ID, FACTURADO
                            $array = [
                                'fecha'=>date('Y-m-d H:i:s'),
                                'accion'=>'SERVICIO VINCULADO A LA FACTURA: <span class="bolder">'.$orden_facturacion->numero_factura.'</span>',
                                'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                            ];
                            //
                            if ($cambios!=null) {

                                array_push($cambios,$array);

                                DB::table('facturacion')
                                    ->where('servicio_id', $id_facturaArray[$i])
                                    ->update(array(
                                        'factura_id' => $id,
                                        'facturado'=>1,
                                        'cambios_servicio'=>json_encode($cambios)
                                    ));
                            }else{
                                DB::table('facturacion')
                                    ->where('servicio_id', $id_facturaArray[$i])
                                    ->update(array(
                                        'factura_id' => $id,
                                        'facturado'=>1,
                                        'cambios_servicio'=>'['.json_encode($array).']',
                                    ));
                            }

                            $contar++;
                        }

                        $facturacion = DB::table('facturacion')->where('servicio_id', Input::get('id'))
                            ->update(array(
                                'numero_planilla'=>Input::get('numero_constancia')
                            ));

                        $liquidacion_facturado = DB::table('liquidacion_servicios')
                            ->where('id',Input::get('id_liquidado_servicio'))
                            ->update([
                                'facturado'=>1
                            ]);

                        if ($contar>0) {

                            return Response::json([
                                'respuesta'=>true,
                                'contar'=>$contar,
                                'ordenes_facturacion'=>$ordenes_facturacion,
                                'ultimo_id'=>$ultimo_id,
                                'id'=>$id
                            ]);

                        }else{
                            return Response::json([
                                'respuesta'=>'error',
                            ]);
                        }

                    }
                }

            }
        }
    }

    public function getOrdenesfacturacion(){

        if (Sentry::check()) {

          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->facturacion->ordenes_de_facturacion->ver;

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

            $option = 5;
            $centrosdecosto = Centrodecosto::activos()->internos()->orderBy('razonsocial')->get();

            $ordenes_facturacion = DB::table('ordenes_facturacion')
                ->leftJoin('subcentrosdecosto', 'ordenes_facturacion.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
                ->leftJoin('centrosdecosto', 'ordenes_facturacion.centrodecosto_id', '=', 'centrosdecosto.id')
                ->leftJoin('users', 'ordenes_facturacion.revisado_por', '=', 'users.id')
                ->select('ordenes_facturacion.id','ordenes_facturacion.consecutivo','ordenes_facturacion.ciudad','centrosdecosto.credito',
                    'centrosdecosto.plazo_pago', 'centrosdecosto.tipo_cliente',
                    'ordenes_facturacion.fecha_expedicion','ordenes_facturacion.fecha_inicial','ordenes_facturacion.fecha_final',
                    'ordenes_facturacion.dividida', 'ordenes_facturacion.id_detalle',
                    'ordenes_facturacion.numero_factura','ordenes_facturacion.total_facturado_cliente','ordenes_facturacion.fecha_factura',
                    'ordenes_facturacion.total_otros_ingresos','ordenes_facturacion.anulado',
                    'ordenes_facturacion.tipo_orden','ordenes_facturacion.ingreso', 'ordenes_facturacion.revision_ingreso',
                    'centrosdecosto.razonsocial',
                    'subcentrosdecosto.nombresubcentro')
                ->whereNull('nomostrar')
                ->orderBy('consecutivo', 'desc')->paginate(100);

            $numero_facturas = DB::table('ordenes_facturacion')
                ->whereNull('anulado')
                ->count();

            $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
            $usuarios = DB::table('users')->orderBy('first_name')->get();

            return View::make('facturacion.ordenes_facturacion',[
                'ordenes_facturacion'=>$ordenes_facturacion,
                'centrosdecosto'=>$centrosdecosto,
                'ciudades'=>$ciudades,
                'usuarios'=>$usuarios,
                'option'=>$option,
                'numero_facturas'=>$numero_facturas,
                'permisos'=>$permisos
            ]);

        }

    }

    public function getFacturasporvencer(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->facturacion->ordenes_de_facturacion->ver;
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

            $option = 0;
            $centrosdecosto = DB::table('centrosdecosto')->orderBy('razonsocial')->get();

            $ordenes_facturacion = DB::table('ordenes_facturacion')
                ->leftJoin('subcentrosdecosto', 'ordenes_facturacion.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
                ->leftJoin('centrosdecosto', 'ordenes_facturacion.centrodecosto_id', '=', 'centrosdecosto.id')
                ->leftJoin('users', 'ordenes_facturacion.revisado_por', '=', 'users.id')
                ->select('ordenes_facturacion.id','ordenes_facturacion.consecutivo','ordenes_facturacion.ciudad','centrosdecosto.credito','centrosdecosto.plazo_pago',
                    'ordenes_facturacion.fecha_expedicion','ordenes_facturacion.fecha_inicial','ordenes_facturacion.fecha_final',
                    'ordenes_facturacion.numero_factura','ordenes_facturacion.total_facturado_cliente','ordenes_facturacion.fecha_factura',
                    'ordenes_facturacion.total_otros_ingresos','ordenes_facturacion.anulado','ordenes_facturacion.id_detalle','ordenes_facturacion.dividida',
                    'ordenes_facturacion.tipo_orden','ordenes_facturacion.ingreso', 'ordenes_facturacion.revision_ingreso',
                    'centrosdecosto.razonsocial',
                    'subcentrosdecosto.nombresubcentro')
                ->where('ordenes_facturacion.anulado',null)
                ->where('revision_ingreso',null)
                ->where('ingreso',null)
                ->where('nomostrar', null)
                ->orderBy('consecutivo', 'desc')->get();

            $ordenes = [];

            foreach ($ordenes_facturacion as $orden):

                $fecha_vencimiento = null;
                $dias_restantes = null;
                $dias_vencidos = null;

                #FACTURAS POR VENCER

                #ASIGNAR LA FECHA ACTUAL A UN OBJETO DATE
                $fecha_actual = new DateTime();
                #CONVERTIR LA FECHA DE EXPEDICION A UN OBJETO DATE
                $fecha_expedicion = new DateTime($orden->fecha_expedicion);

                if ($orden->tipo_orden==1):
                    $tipo = 'TRANSPORTE';
                else:
                    $tipo = 'OTROS';
                endif;

                #SI EL CLIENTE TIENE CREDITO ENTONCES
                if(intval($orden->credito)===1):
                    #ASIGNAR EL VALOR DE PLAZO DE PAGO
                    $plazo_pago = $orden->plazo_pago;
                    //CALCULA LA FECHA DE VENCIMIENTO
                    $fecha_vencimiento = date_add($fecha_expedicion, date_interval_create_from_date_string($plazo_pago.' days'));
                    $fecha_vencimiento = date_format($fecha_vencimiento,'Y-m-d');
                    $fecha_vencimiento = new DateTime($fecha_vencimiento);
                    //CANTIDAD DE DIAS VENCIDOS
                    $dias_vencidos = $fecha_actual->diff($fecha_vencimiento);
                    $dias_vencidos = $dias_vencidos->format('%R%a');
                    $operador = substr($dias_vencidos,0,1);

                    if($operador==='+'){
                        $dias_vencidos = 0;
                    }else if($operador==='-') {
                        if(abs($dias_vencidos)===0){
                            $dias_vencidos = 0;
                        }else if(abs($dias_vencidos)>0){
                            $dias_vencidos = abs($dias_vencidos);
                        }
                    }

                    if($dias_vencidos<1):

                        $array = [
                            'id'=>$orden->id,
                            'consecutivo'=>$orden->consecutivo,
                            'razonsocial'=>$orden->razonsocial,
                            'nombresubcentro'=>$orden->nombresubcentro,
                            'ciudad'=>$orden->ciudad,
                            'fecha_expedicion'=>$orden->fecha_expedicion,
                            'fecha_inicial'=>$orden->fecha_inicial,
                            'fecha_final'=>$orden->fecha_final,
                            'fecha_vencimiento'=>date_format($fecha_vencimiento,'Y-m-d'),
                            'dias_vencidos'=>$dias_vencidos,
                            'numero_factura'=>$orden->numero_factura,
                            'dias_restantes'=>$dias_restantes,
                            'total_facturado_cliente'=>$orden->total_facturado_cliente,
                            'tipo_orden'=>$tipo,
                            'operador'=>$operador,
                            'revision_ingreso'=>$orden->revision_ingreso,
                            'ingreso'=>$orden->ingreso
                        ];

                        array_push($ordenes,$array);
                    endif;

                else:
                    //SI EL CLIENTE NO TIENE CREDITO ENTONCES EL PLAZO DE PAGO ES DE 1 DIA
                    $plazo_pago = 1;
                    //CALCULA LA FECHA DE VENCIMIENTO
                    $fecha_vencimiento = date_add($fecha_expedicion, date_interval_create_from_date_string($plazo_pago.' days'));
                    $fecha_vencimiento = date_format($fecha_vencimiento,'Y-m-d');
                    $fecha_vencimiento = new DateTime($fecha_vencimiento);
                    //CANTIDAD DE DIAS VENCIDOS
                    $dias_vencidos = $fecha_actual->diff($fecha_vencimiento);
                    $dias_vencidos = $dias_vencidos->format('%R%a');

                    if ($dias_vencidos==='+0'){
                        $dias_vencidos = 0;
                    }else if($dias_vencidos==='-0'){
                        $dias_vencidos = 1;
                    }else{
                        $dias_vencidos = abs($dias_vencidos)+1;
                    }
                    //$dias_vencidos = intval($dias_vencidos);


                    if($dias_vencidos<1):

                        $array = [
                            'id'=>$orden->id,
                            'consecutivo'=>$orden->consecutivo,
                            'razonsocial'=>$orden->razonsocial,
                            'nombresubcentro'=>$orden->nombresubcentro,
                            'ciudad'=>$orden->ciudad,
                            'fecha_expedicion'=>$orden->fecha_expedicion,
                            'fecha_inicial'=>$orden->fecha_inicial,
                            'fecha_final'=>$orden->fecha_final,
                            'fecha_vencimiento'=>date_format($fecha_vencimiento,'Y-m-d'),
                            'dias_vencidos'=>$dias_vencidos,
                            'numero_factura'=>$orden->numero_factura,
                            'dias_restantes'=>$dias_restantes,
                            'total_facturado_cliente'=>$orden->total_facturado_cliente,
                            'tipo_orden'=>$tipo,
                            'operador'=>null,
                            'revision_ingreso'=>$orden->revision_ingreso,
                            'ingreso'=>$orden->ingreso
                        ];

                        array_push($ordenes,$array);
                    endif;
                endif;

            endforeach;

            $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
            $usuarios = DB::table('users')->orderBy('first_name')->get();

            return View::make('facturacion.ordenes_facturacion',[
                'ordenes_facturacion'=>$ordenes,
                'centrosdecosto'=>$centrosdecosto,
                'ciudades'=>$ciudades,
                'usuarios'=>$usuarios,
                'option'=>$option
            ]);
        }
    }

    public function getFacturasvencidas(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->facturacion->ordenes_de_facturacion->ver;
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

            $option = 1;
            $centrosdecosto = DB::table('centrosdecosto')->orderBy('razonsocial')->get();

            $ordenes_facturacion = DB::table('ordenes_facturacion')
                ->leftJoin('subcentrosdecosto', 'ordenes_facturacion.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
                ->leftJoin('centrosdecosto', 'ordenes_facturacion.centrodecosto_id', '=', 'centrosdecosto.id')
                ->leftJoin('users', 'ordenes_facturacion.revisado_por', '=', 'users.id')
                ->select('ordenes_facturacion.id','ordenes_facturacion.consecutivo','ordenes_facturacion.ciudad','centrosdecosto.credito','centrosdecosto.plazo_pago',
                    'ordenes_facturacion.fecha_expedicion','ordenes_facturacion.fecha_inicial','ordenes_facturacion.fecha_final',
                    'ordenes_facturacion.numero_factura','ordenes_facturacion.total_facturado_cliente','ordenes_facturacion.fecha_factura',
                    'ordenes_facturacion.total_otros_ingresos','ordenes_facturacion.anulado','ordenes_facturacion.id_detalle','ordenes_facturacion.dividida',
                    'ordenes_facturacion.tipo_orden','ordenes_facturacion.ingreso', 'ordenes_facturacion.revision_ingreso',
                    'centrosdecosto.razonsocial',
                    'subcentrosdecosto.nombresubcentro')
                ->where('ordenes_facturacion.anulado',null)
                ->where('revision_ingreso',null)
                ->where('ingreso',null)
                ->where('nomostrar', null)
                ->orderBy('consecutivo', 'desc')
                ->get();

            $ordenes = [];

            foreach ($ordenes_facturacion as $orden):

                $fecha_vencimiento = null;
                $dias_restantes = null;

                #ASIGNAR LA FECHA ACTUAL A UN OBJETO DATE
                $fecha_actual = new DateTime();
                #CONVERTIR LA FECHA DE EXPEDICION A UN OBJETO DATE
                $fecha_expedicion = new DateTime($orden->fecha_expedicion);
                if ($orden->tipo_orden==1):
                    $tipo = 'TRANSPORTE';
                else:
                    $tipo = 'OTROS';
                endif;
                #SI EL CLIENTE TIENE CREDITO ENTONCES
                if($orden->credito==1):
                    #ASIGNAR EL VALOR DE PLAZO DE PAGO
                    $plazo_pago = intval($orden->plazo_pago);
                    //CALCULA LA FECHA DE VENCIMIENTO
                    $fecha_vencimiento = date_add($fecha_expedicion, date_interval_create_from_date_string($plazo_pago.' days'));
                    $fecha_vencimiento = date_format($fecha_vencimiento,'Y-m-d');
                    $fecha_vencimiento = new DateTime($fecha_vencimiento);
                    //CANTIDAD DE DIAS VENCIDOS
                    $dias_vencidos = $fecha_actual->diff($fecha_vencimiento);
                    $dias_vencidos = $dias_vencidos->format('%R%a');
                    $operador = substr($dias_vencidos,0,1);

                    if($operador==='+'){
                        $dias_vencidos = 0;
                    }else if($operador==='-') {
                        if(abs($dias_vencidos)===0){
                            $dias_vencidos = 0;
                        }else if(abs($dias_vencidos)>0){
                            $dias_vencidos = abs($dias_vencidos);
                        }
                    }

                    if($dias_vencidos>=1):

                        $array = [
                            'id'=>$orden->id,
                            'consecutivo'=>$orden->consecutivo,
                            'razonsocial'=>$orden->razonsocial,
                            'nombresubcentro'=>$orden->nombresubcentro,
                            'ciudad'=>$orden->ciudad,
                            'fecha_expedicion'=>$orden->fecha_expedicion,
                            'fecha_inicial'=>$orden->fecha_inicial,
                            'fecha_final'=>$orden->fecha_final,
                            'fecha_vencimiento'=>date_format($fecha_vencimiento,'Y-m-d'),
                            'dias_vencidos'=>$dias_vencidos,
                            'numero_factura'=>$orden->numero_factura,
                            'dias_restantes'=>$dias_restantes,
                            'total_facturado_cliente'=>$orden->total_facturado_cliente,
                            'tipo_orden'=>$tipo,
                            'operador'=>$operador,
                            'revision_ingreso'=>$orden->revision_ingreso,
                            'ingreso'=>$orden->ingreso
                        ];

                        array_push($ordenes,$array);
                    endif;

                else:

                    //SI EL CLIENTE NO TIENE CREDITO ENTONCES EL PLAZO DE PAGO ES DE 1 DIA
                    $plazo_pago = 1;
                    $fecha_vencimiento = date_add($fecha_expedicion, date_interval_create_from_date_string($plazo_pago.' days'));
                    $fecha_vencimiento = date_format($fecha_vencimiento,'Y-m-d');
                    $fecha_vencimiento = new DateTime($fecha_vencimiento);
                    //CANTIDAD DE DIAS VENCIDOS
                    $dias_vencidos = $fecha_actual->diff($fecha_vencimiento);
                    $dias_vencidos = $dias_vencidos->format('%R%a');
                    $operador = substr($dias_vencidos,0,1);

                    if($operador==='+'){
                        $dias_vencidos = 0;
                    }else if($operador==='-') {
                        if(abs($dias_vencidos)===0){
                            $dias_vencidos = 0;
                        }else if(abs($dias_vencidos)>0){
                            $dias_vencidos = abs($dias_vencidos);
                        }
                    }

                    if($dias_vencidos>=1):

                        $array = [
                            'id'=>$orden->id,
                            'consecutivo'=>$orden->consecutivo,
                            'razonsocial'=>$orden->razonsocial,
                            'nombresubcentro'=>$orden->nombresubcentro,
                            'ciudad'=>$orden->ciudad,
                            'fecha_expedicion'=>$orden->fecha_expedicion,
                            'fecha_inicial'=>$orden->fecha_inicial,
                            'fecha_final'=>$orden->fecha_final,
                            'fecha_vencimiento'=>date_format($fecha_vencimiento,'Y-m-d'),
                            'dias_vencidos'=>$dias_vencidos,
                            'numero_factura'=>$orden->numero_factura,
                            'dias_restantes'=>$dias_restantes,
                            'total_facturado_cliente'=>$orden->total_facturado_cliente,
                            'tipo_orden'=>$tipo,
                            'operador'=>$operador,
                            'revision_ingreso'=>$orden->revision_ingreso,
                            'ingreso'=>$orden->ingreso
                        ];

                        array_push($ordenes,$array);
                    endif;
                endif;
            endforeach;

            $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
            $usuarios = DB::table('users')->orderBy('first_name')->get();

            return View::make('facturacion.ordenes_facturacion',[
                'ordenes_facturacion'=>$ordenes,
                'centrosdecosto'=>$centrosdecosto,
                'ciudades'=>$ciudades,
                'usuarios'=>$usuarios,
                'option'=>$option
            ]);
        }
    }

    public function getFacturasconingreso(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->facturacion->ordenes_de_facturacion->ver;
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

            $option = 2;

            $centrosdecosto = DB::table('centrosdecosto')->orderBy('razonsocial')->get();

            $ordenes_facturacion = DB::table('ordenes_facturacion')
                ->leftJoin('subcentrosdecosto', 'ordenes_facturacion.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
                ->leftJoin('centrosdecosto', 'ordenes_facturacion.centrodecosto_id', '=', 'centrosdecosto.id')
                ->leftJoin('users', 'ordenes_facturacion.revisado_por', '=', 'users.id')
                ->select('ordenes_facturacion.id','ordenes_facturacion.consecutivo','ordenes_facturacion.ciudad','centrosdecosto.credito','centrosdecosto.plazo_pago',
                    'ordenes_facturacion.fecha_expedicion','ordenes_facturacion.fecha_inicial','ordenes_facturacion.fecha_final',
                    'ordenes_facturacion.numero_factura','ordenes_facturacion.total_facturado_cliente','ordenes_facturacion.fecha_factura',
                    'ordenes_facturacion.total_otros_ingresos','ordenes_facturacion.anulado','ordenes_facturacion.dividida','ordenes_facturacion.id_detalle',
                    'ordenes_facturacion.tipo_orden','ordenes_facturacion.ingreso', 'ordenes_facturacion.revision_ingreso',
                    'centrosdecosto.razonsocial',
                    'subcentrosdecosto.nombresubcentro')
                ->where('ordenes_facturacion.anulado',null)
                ->where('ingreso',1)
                ->whereNull('revision_ingreso')
                ->orderBy('consecutivo', 'desc')
                //->get();
                ->paginate(100);

            $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
            $usuarios = DB::table('users')->orderBy('first_name')->get();

            return View::make('facturacion.ordenes_facturacion')
                ->with([
                    'ordenes_facturacion'=>$ordenes_facturacion,
                    'centrosdecosto'=>$centrosdecosto,
                    'ciudades'=>$ciudades,
                    'usuarios'=>$usuarios,
                    'option'=>$option
                ]);
        }
    }

    public function getFacturasrevisadas(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->facturacion->ordenes_de_facturacion->ver;
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
            $option = 3;

            $centrosdecosto = DB::table('centrosdecosto')->orderBy('razonsocial')->get();

            $ordenes_facturacion = DB::table('ordenes_facturacion')
                ->leftJoin('subcentrosdecosto', 'ordenes_facturacion.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
                ->leftJoin('centrosdecosto', 'ordenes_facturacion.centrodecosto_id', '=', 'centrosdecosto.id')
                ->leftJoin('users', 'ordenes_facturacion.revisado_por', '=', 'users.id')
                ->select('ordenes_facturacion.id','ordenes_facturacion.consecutivo','ordenes_facturacion.ciudad','centrosdecosto.credito','centrosdecosto.plazo_pago',
                    'ordenes_facturacion.fecha_expedicion','ordenes_facturacion.fecha_inicial','ordenes_facturacion.fecha_final',
                    'ordenes_facturacion.numero_factura','ordenes_facturacion.total_facturado_cliente','ordenes_facturacion.fecha_factura',
                    'ordenes_facturacion.total_otros_ingresos','ordenes_facturacion.anulado','ordenes_facturacion.dividida','ordenes_facturacion.id_detalle',
                    'ordenes_facturacion.tipo_orden','ordenes_facturacion.ingreso', 'ordenes_facturacion.revision_ingreso',
                    'centrosdecosto.razonsocial',
                    'subcentrosdecosto.nombresubcentro')
                ->where('ordenes_facturacion.anulado',null)
                ->where('ingreso',1)
                ->where('revision_ingreso',1)
                ->orderBy('consecutivo', 'desc')
                //->get();
                ->paginate(100);

            $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
            $usuarios = DB::table('users')->orderBy('first_name')->get();

            return View::make('facturacion.ordenes_facturacion')
                ->with([
                    'ordenes_facturacion'=>$ordenes_facturacion,
                    'centrosdecosto'=>$centrosdecosto,
                    'ciudades'=>$ciudades,
                    'usuarios'=>$usuarios,
                    'option'=>$option
                ]);
        }
    }

    public function getFacturasanuladas(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->facturacion->ordenes_de_facturacion->ver;
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
            $option = 4;

            $centrosdecosto = DB::table('centrosdecosto')->orderBy('razonsocial')->get();

            $ordenes_facturacion = DB::table('ordenes_facturacion')
                ->leftJoin('subcentrosdecosto', 'ordenes_facturacion.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
                ->leftJoin('centrosdecosto', 'ordenes_facturacion.centrodecosto_id', '=', 'centrosdecosto.id')
                ->leftJoin('users', 'ordenes_facturacion.revisado_por', '=', 'users.id')
                ->select('ordenes_facturacion.id','ordenes_facturacion.consecutivo','ordenes_facturacion.ciudad','centrosdecosto.credito','centrosdecosto.plazo_pago',
                    'ordenes_facturacion.fecha_expedicion','ordenes_facturacion.fecha_inicial','ordenes_facturacion.fecha_final',
                    'ordenes_facturacion.numero_factura','ordenes_facturacion.total_facturado_cliente','ordenes_facturacion.fecha_factura',
                    'ordenes_facturacion.total_otros_ingresos','ordenes_facturacion.anulado','ordenes_facturacion.dividida',
                    'ordenes_facturacion.tipo_orden','ordenes_facturacion.ingreso', 'ordenes_facturacion.revision_ingreso',
                    'centrosdecosto.razonsocial',
                    'subcentrosdecosto.nombresubcentro')
                ->where('ordenes_facturacion.anulado',1)
                ->orderBy('consecutivo', 'desc')
                //->get();
                ->paginate(100);

            $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
            $usuarios = DB::table('users')->orderBy('first_name')->get();

            return View::make('facturacion.ordenes_facturacion')
                ->with([
                    'ordenes_facturacion'=>$ordenes_facturacion,
                    'centrosdecosto'=>$centrosdecosto,
                    'ciudades'=>$ciudades,
                    'usuarios'=>$usuarios,
                    'option'=>$option
                ]);
        }
    }

    public function getVerorden($id){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->facturacion->ordenes_de_facturacion->ver;
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

            $ordenes_facturacion = DB::table('ordenes_facturacion')
                ->leftJoin('centrosdecosto', 'ordenes_facturacion.centrodecosto_id', '=', 'centrosdecosto.id')
                ->leftJoin('users', 'ordenes_facturacion.anulado_por', '=', 'users.id')
                ->leftJoin('subcentrosdecosto', 'ordenes_facturacion.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
                ->select('ordenes_facturacion.id','ordenes_facturacion.consecutivo','ordenes_facturacion.fecha_inicial','ordenes_facturacion.motivo_anulacion',
                    'ordenes_facturacion.fecha_final','ordenes_facturacion.ciudad','ordenes_facturacion.total_facturado_cliente','ordenes_facturacion.tipo_orden',
                    'ordenes_facturacion.numero_factura','ordenes_facturacion.total_otros_ingresos','ordenes_facturacion.total_costo',
                    'ordenes_facturacion.total_utilidad','ordenes_facturacion.total_gastos_operacionales','ordenes_facturacion.fecha_expedicion',
                    'ordenes_facturacion.fecha_factura','ordenes_facturacion.fecha_vencimiento','ordenes_facturacion.ingreso',
                    'ordenes_facturacion.modo_ingreso','ordenes_facturacion.facturado','ordenes_facturacion.recibo_caja','ordenes_facturacion.anulado',
                    'ordenes_facturacion.fecha_ingreso','centrosdecosto.razonsocial','ordenes_facturacion.foto_ingreso','ordenes_facturacion.concepto',
                    'users.first_name','users.last_name','ordenes_facturacion.revision_ingreso',
                    'subcentrosdecosto.nombresubcentro','subcentrosdecosto.identificacion')
                ->where('ordenes_facturacion.id',$id)
                ->first();

            return View::make('facturacion.detalle_orden_facturacion')
            ->with([
                'ordenes_facturacion'=>$ordenes_facturacion,
                'permisos'=>$permisos
            ]);

        }
    }

    public function getVerdetalle($id){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->facturacion->ordenes_de_facturacion->ver;
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

            $ordenes_facturacion = DB::table('ordenes_facturacion')
                ->leftJoin('centrosdecosto', 'ordenes_facturacion.centrodecosto_id', '=', 'centrosdecosto.id')
                ->leftJoin('subcentrosdecosto', 'ordenes_facturacion.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
                ->select('ordenes_facturacion.id','ordenes_facturacion.consecutivo','ordenes_facturacion.fecha_inicial','ordenes_facturacion.otros_ingresos','ordenes_facturacion.otros_costos',
                    'ordenes_facturacion.fecha_final','ordenes_facturacion.ciudad','ordenes_facturacion.total_facturado_cliente',
                    'ordenes_facturacion.numero_factura','ordenes_facturacion.total_otros_ingresos','ordenes_facturacion.total_costo',
                    'ordenes_facturacion.total_utilidad','ordenes_facturacion.total_gastos_operacionales','ordenes_facturacion.fecha_expedicion',
                    'ordenes_facturacion.fecha_factura','ordenes_facturacion.fecha_vencimiento','ordenes_facturacion.ingreso','ordenes_facturacion.foto_ingreso',
                    'ordenes_facturacion.modo_ingreso','ordenes_facturacion.facturado','ordenes_facturacion.tipo_orden','ordenes_facturacion.fecha_ingreso',
                    'ordenes_facturacion.recibo_caja', 'ordenes_facturacion.observaciones',
                    'centrosdecosto.razonsocial',
                    'subcentrosdecosto.nombresubcentro')
                ->where('ordenes_facturacion.id',$id)
                ->first();

            if (intval($ordenes_facturacion->tipo_orden)===1) {

                $servicios = DB::table('facturacion')
                    ->select('facturacion.observacion','facturacion.numero_planilla','facturacion.calidad_servicio','facturacion.unitario_cobrado',
                        'facturacion.unitario_pagado','facturacion.total_cobrado','facturacion.total_pagado','facturacion.utilidad',
                        'servicios.fecha_servicio','servicios.pasajeros','pago_proveedores.consecutivo','pago_proveedores.revisado',
                        'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo','pago_proveedores.programado',
                        'proveedores.razonsocial',
                        'pagos.preparado','pagos.auditado','pagos.autorizado',
                        'conductores.celular','conductores.telefono','conductores.nombre_completo')
                    ->leftJoin('servicios', 'facturacion.servicio_id', '=', 'servicios.id')
                    ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
                    ->leftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
                    ->leftJoin('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
                    ->leftJoin('pago_proveedores','facturacion.pago_proveedor_id','=','pago_proveedores.id')
                    ->leftJoin('pagos','pago_proveedores.id_pago','=','pagos.id')
                    ->where('factura_id',$id)
                    ->orderBy('numero_planilla')
                    ->get();

                return View::make('facturacion.detalle_facturacion_generada')
                    ->with([
                        'ordenes_facturacion'=>$ordenes_facturacion,
                        'servicios'=>$servicios,
                        'permisos'=>$permisos
                    ]);

            }else if (intval($ordenes_facturacion->tipo_orden)===2) {

                $otros_servicios_detalles = DB::table('otros_servicios_detalles')
                    ->where('id_factura',$ordenes_facturacion->id)
                    ->first();

                $otros_servicios = DB::table('otros_servicios')->where('id_servicios_detalles',$otros_servicios_detalles->id)->get();
                $terceros = DB::table('terceros')->get();

                return View::make('facturacion.detalle_facturacion_generada')
                    ->with([
                        'ordenes_facturacion'=>$ordenes_facturacion,
                        'otros_servicios_detalles'=>$otros_servicios_detalles,
                        'otros_servicios'=>$otros_servicios,
                        'terceros'=>$terceros,
                        'permisos'=>$permisos
                    ]);
            }
        }
    }

    public function postFacturar(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

                $orden = Ordenfactura::find(Input::get('id'));
                $orden->total_otros_ingresos = Input::get('total_otros_ingresos');
                $orden->concepto = Input::get('concepto');
                $orden->numero_factura = Input::get('numero_factura');
                $orden->fecha_factura = Input::get('fecha_factura');
                $orden->fecha_vencimiento = Input::get('fecha_vencimiento');
                $orden->facturado = 1;

                if ($orden->save()) {

                    return Response::json([
                        'respuesta'=>true
                    ]);

                }


            }
        }
    }

    //ESTO ESTA EN TRANSPORTES - RECONFIRMACION
    public function postBuscarnumeroconstancia(){

        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{

            if(Request::ajax()){

                $numero_factura = DB::table('facturacion')->where('servicio_id', Input::get('id'))->first();

                $array = [
                    'respuesta'=>true,
                    'numero_factura'=>$numero_factura
                ];
                return Response::json($array);

            }
        }
    }

    public function postCambiarnumeroconstancia(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if(Request::ajax()){

                try {

                    $cambios = DB::table('facturacion')->where('servicio_id',Input::get('id'))->pluck('cambios_servicio');
                    $numero_anterior = DB::table('facturacion')->where('servicio_id',Input::get('id'))->pluck('numero_planilla');

                    //SI EXISTE UN REGISTRO DE LOS CAMBIOS
                    if ($cambios!=null or $cambios!='') {

                        //EDITAR EL NUMERO DE PLANILLA
                        $facturacion = DB::table('facturacion')->where('servicio_id', Input::get('id'))
                            ->update(array(
                                'numero_planilla'=>Input::get('numero_constancia')
                            ));

                        //ARRAY A A ADICIONAR AL EXISTENTE
                        $array = [
                            'fecha'=>date('Y-m-d H:i:s'),
                            'accion'=>'NUMERO DE CONSTANCIA CAMBIADO DE: <span class="bolder">'.$numero_anterior.'</span> A: <span class="bolder">'.Input::get('numero_constancia').'</span>',
                            'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                        ];

                        $cambios = json_decode($cambios);
                        //ARRAY ADICIONADO
                        array_push($cambios,$array);

                        //SI EL RESULTADO ES CERO ENTONCES NO HUBO CAMBIOS
                        if ($facturacion===0) {

                            return Response::json([
                                'respuesta'=>'cero',
                                'cambios'=>$cambios
                            ]);

                        }else{

                            //SI HUBO CAMBIOS ENTONCES GUARDAR EL CAMBIO
                            $facturacion = DB::table('facturacion')->where('servicio_id', Input::get('id'))
                                ->update(array(
                                    'cambios_servicio'=>json_encode($cambios)
                                ));

                            if ($facturacion!=null) {

                                return Response::json([
                                    'respuesta'=>true,
                                    'cambios'=>$cambios
                                ]);

                            }

                        }

                    }else{

                        //SI ESTA VACIO EL CAMPO DE CAMBIOS ENTONCES EL PRIMER REGISTRO DEBE TENER LOS CARACTERES []
                        //ARRAY PARA CAMBIAR EL NUMERO DE CONSTANCIA
                        $array = [
                            'fecha'=>date('Y-m-d H:i:s'),
                            'accion'=>'NUMERO DE CONSTANCIA CAMBIADO DE: <span class="bolder">'.$numero_anterior.'</span> A: <span class="bolder">'.Input::get('numero_constancia').'</span>',
                            'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                        ];

                        $facturacion = DB::table('facturacion')->where('servicio_id', Input::get('id'))
                            ->update(array(
                                'numero_planilla'=>Input::get('numero_constancia')
                            ));

                        if ($facturacion!=null) {

                            //GUARDAR LOS CAMBIOS DEL SERVICIO
                            $cambiosb = DB::table('facturacion')->where('servicio_id', Input::get('id'))
                                ->update(array(
                                    'cambios_servicio'=>'['.json_encode($array).']'
                                ));

                            return Response::json([
                                'respuesta'=>true,
                                'cambiosb'=>$cambiosb
                            ]);

                        }else{

                            return Response::json([
                                'respuesta'=>'cero',
                                'cambios'=>$cambios
                            ]);

                        }

                    }

                }catch (Exception $e) {
                    return Response::json([
                        'respuesta'=>'error',
                        'e'=>$e
                    ]);
                }

            }
        }

    }

    public function getDetallesautorizacion($id){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->facturacion->autorizar->ver;
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

            $liquidacion_servicio = DB::table('liquidacion_servicios')
                ->select('liquidacion_servicios.consecutivo','centrosdecosto.razonsocial','subcentrosdecosto.nombresubcentro','liquidacion_servicios.fecha_registro',
                    'liquidacion_servicios.fecha_final','liquidacion_servicios.fecha_inicial','liquidacion_servicios.ciudad','liquidacion_servicios.id',
                    'liquidacion_servicios.total_facturado_cliente','liquidacion_servicios.observaciones','liquidacion_servicios.otros_ingresos','liquidacion_servicios.otros_costos',
                    'liquidacion_servicios.total_costo','liquidacion_servicios.total_utilidad')
                ->leftJoin('centrosdecosto','liquidacion_servicios.centrodecosto_id','=','centrosdecosto.id')
                ->leftJoin('subcentrosdecosto','liquidacion_servicios.subcentrodecosto_id','=','subcentrosdecosto.id')
                ->where('liquidacion_servicios.id',$id)
                ->first();

            $facturacion = DB::table('facturacion')
                ->select('servicios.id','servicios.fecha_servicio','facturacion.numero_planilla','servicios.pasajeros','facturacion.calidad_servicio',
                    'proveedores.razonsocial as prazonsocial', 'servicios.dejar_en','servicios.recoger_en','servicios.detalle_recorrido','novedades_reconfirmacion.id_reconfirmacion',
                    'conductores.nombre_completo','facturacion.unitario_cobrado','facturacion.unitario_pagado','facturacion.total_cobrado','facturacion.total_pagado',
                    'facturacion.observacion',
                    'facturacion.utilidad','facturacion.liquidado_autorizado','facturacion.facturado')
                ->leftJoin('servicios','facturacion.servicio_id','=','servicios.id')
                ->leftJoin('novedades_reconfirmacion','servicios.id','=','novedades_reconfirmacion.id_reconfirmacion')
                ->leftJoin('proveedores','servicios.proveedor_id','=','proveedores.id')
                ->leftJoin('conductores','servicios.conductor_id','=','conductores.id')
                ->where('facturacion.liquidacion_id',$id)
                ->orderBy('servicios.fecha_servicio')
                ->get();

            return View::make('facturacion.detalles_liquidacion')
                ->with([
                    'facturacion'=>$facturacion,
                    'liquidacion_servicios'=>$liquidacion_servicio,
                    'permisos'=>$permisos
                ]);

        }
    }

    //DETALLE DE LAS PREFACTURAS CUANDO SON DIVIDIDAS
    public function getDetallesautorizaciondividida($id){

      if (Sentry::check()) {
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->facturacion->autorizar->ver;
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

            $liquidacion_servicio = DB::table('liquidacion_servicios')
                ->select('liquidacion_servicios.consecutivo','centrosdecosto.razonsocial','subcentrosdecosto.nombresubcentro','liquidacion_servicios.fecha_registro',
                    'liquidacion_servicios.fecha_final','liquidacion_servicios.fecha_inicial','liquidacion_servicios.ciudad','liquidacion_servicios.id', 'liquidacion_servicios.otros_ingresos',
                    'liquidacion_servicios.total_facturado_cliente','liquidacion_servicios.observaciones','liquidacion_servicios.id_detalle','liquidacion_servicios.dividida', 'liquidacion_servicios.otros_costos',
                    'liquidacion_servicios.total_costo','liquidacion_servicios.total_utilidad','liquidacion_servicios.valor_adicional')
                ->leftJoin('centrosdecosto','liquidacion_servicios.centrodecosto_id','=','centrosdecosto.id')
                ->leftJoin('subcentrosdecosto','liquidacion_servicios.subcentrodecosto_id','=','subcentrosdecosto.id')
                ->where('liquidacion_servicios.id',$id)
                ->first();

            //esto se hizo para team foods especificamente aqui llamo a la preliquidacion madre que es la que contiene todos los servicios
            $preliquidacion_falsa = DB::table('liquidacion_servicios')->where('id',$liquidacion_servicio->id_detalle)->first();

            return View::make('facturacion.detalles_liquidacion_dividida')
                ->with([
                    'liquidacion_servicios'=>$liquidacion_servicio,
                    'preliquidacion_falsa'=>$preliquidacion_falsa
                ]);
        }
    }

    public function postFacturaciondividida(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if (Request::ajax()) {

                //ID DE LA PREFACTURA DE LA QUE SE VAN A TOMAR LOS DATOS PARA FACTURAR
                $id_detalle = Input::get('id');

                //PRE LIQUIDACION A PARTIR DE LA CUAL SE CREARA UNA FACTURA FALSA
                $liquidacion = DB::table('liquidacion_servicios')->where('id',$id_detalle)->first();

                //CREACION DE LA FACTURA FALSA
                $orden_facturacion = new Ordenfactura();
                $orden_facturacion->centrodecosto_id = $liquidacion->centrodecosto_id;
                $orden_facturacion->subcentrodecosto_id = $liquidacion->subcentrodecosto_id;
                $orden_facturacion->fecha_inicial = $liquidacion->fecha_inicial;
                $orden_facturacion->fecha_final = $liquidacion->fecha_final;
                $orden_facturacion->fecha_expedicion = date('Y-m-d H:i:s');
                $orden_facturacion->ciudad = $liquidacion->ciudad;
                $orden_facturacion->fecha_factura = date('Y-m-d');
                $orden_facturacion->tipo_orden = 1;
                $orden_facturacion->total_facturado_cliente = $liquidacion->total_facturado_cliente;
                $orden_facturacion->total_costo = $liquidacion->total_costo;
                $orden_facturacion->total_utilidad = $liquidacion->total_utilidad;
                $orden_facturacion->otros_ingresos = $liquidacion->otros_ingresos;
                $orden_facturacion->otros_costos = $liquidacion->otros_costos;
                $orden_facturacion->facturado = 1;
                $orden_facturacion->nomostrar = 1;
                $orden_facturacion->creado_por = Sentry::getUser()->id;

                //SI SE GUARDA SATISFACTORIAMENTE
                if ($orden_facturacion->save()){

                    //ASIGNAR EL NUMERO CONSECUTIVO
                    $id = $orden_facturacion->id;
                    $orden = Ordenfactura::find($id);

                    if (strlen(intval($id))===1) {
                        $orden->consecutivo = 'AT000'.$id;
                        $orden->save();
                    }elseif (strlen(intval($id))===2) {
                        $orden->consecutivo = 'AT00'.$id;
                        $orden->save();
                    }elseif(strlen(intval($id))===3){
                        $orden->consecutivo = 'AT0'.$id;
                        $orden->save();
                    }elseif(strlen(intval($id))===4){
                        $orden->consecutivo = 'AT'.$id;
                        $orden->save();
                    }

                    //BUSCAR LOS SERVICIOS QUE PERTENECER A ESA LIQUIDACION
                    $servicios_enlazar = DB::table('facturacion')->where('liquidacion_id',$id_detalle)->get();

                    //COLOCAR LOS NUMEROS DE FACTURA Y EL ESTADO FACTURADO A LOS SERVICIOS
                    foreach ($servicios_enlazar as $servicios) {

                        //REVISAR SI EL CAMPO CAMBIOS ESTA VACIO O NO
                        $cambios = DB::table('facturacion')->where('id',$servicios->id)->pluck('cambios_servicio');

                        //CODIFICAR EL CAMPO CAMBIOS YA QUE ESTE AL SER TRAIDO DE LA BASE DE DATOS ES UN STRING
                        $cambios = json_decode($cambios);

                        //ASIGNAR LOS VALORES A LOS CAMPOS FACTURA ID, FACTURADO
                        $array = [
                            'fecha'=>date('Y-m-d H:i:s'),
                            'accion'=>'SERVICIO VINCULADO A LA FACTURA CON NUMERO AT: <span class="bolder">'.$orden->consecutivo.'</span>',
                            'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
                        ];

                        if ($cambios!=null) {

                            array_push($cambios,$array);
                            //AGREGAR ESTADO FACTURADO A LOS SERVICIOS
                            DB::table('facturacion')
                                ->where('id', $servicios->id)
                                ->update(array(
                                    'factura_id' => $id,
                                    'facturado'=>1,
                                    'cambios_servicio'=>json_encode($cambios)
                                ));
                        }else{
                            //AGREGAR ESTADO FACTURADO A LOS SERVICIOS
                            DB::table('facturacion')
                                ->where('servicio_id', $servicios->id)
                                ->update(array(
                                    'factura_id' => $id,
                                    'facturado'=>1,
                                    'cambios_servicio'=>'['.json_encode($array).']',
                                ));
                        }
                    }

                    $liquidacion_servicios = DB::table('liquidacion_servicios')->where('id_detalle',$id_detalle)->get();

                    $ultimo_id = DB::table('ordenes_facturacion')
                        ->select('id','numero_factura')
                        ->orderBy('numero_factura','desc')
                        ->first('numero_factura');

                    $numero_factura = intval($ultimo_id->numero_factura)+1;

                    foreach ($liquidacion_servicios as $liq){

                        $factura = new Ordenfactura();
                        $factura->centrodecosto_id = $liq->centrodecosto_id;
                        $factura->subcentrodecosto_id = $liq->subcentrodecosto_id;
                        $factura->fecha_inicial = $liq->fecha_inicial;
                        $factura->fecha_final = $liq->fecha_final;
                        $factura->fecha_expedicion = date('Y-m-d H:i:s');
                        $factura->ciudad = $liq->ciudad;
                        $factura->fecha_factura = date('Y-m-d');
                        $factura->numero_factura = $numero_factura;
                        $factura->tipo_orden = 1;
                        $factura->total_facturado_cliente = $liq->total_facturado_cliente+$liq->valor_adicional;

                        $factura->total_costo = $liq->total_costo;
                        $factura->total_utilidad = $liq->total_utilidad+$liq->valor_adicional;
                        $factura->facturado = 1;
                        $factura->creado_por = Sentry::getUser()->id;
                        $factura->dividida = 1;
                        $factura->id_detalle = $id;

                        if ($factura->save()) {

                            $id_c = $factura->id;
                            $orden = Ordenfactura::find($id_c);

                            if (strlen(intval($id)) === 1) {
                                $orden->consecutivo = 'AT000' . $id_c;
                                $orden->save();
                            } elseif (strlen(intval($id)) === 2) {
                                $orden->consecutivo = 'AT00' . $id_c;
                                $orden->save();
                            } elseif (strlen(intval($id)) === 3) {
                                $orden->consecutivo = 'AT0' . $id_c;
                                $orden->save();
                            } elseif (strlen(intval($id)) === 4) {
                                $orden->consecutivo = 'AT' . $id_c;
                                $orden->save();
                            }

                            DB::table('liquidacion_servicios')
                                ->where('id', $liq->id)
                                ->update([
                                    'facturado' => 1
                                ]);
                        }

                        $numero_factura++;
                    }



                    return Response::json([
                        'respuesta'=>true,
                        'id'=>$id
                    ]);

                }
            }
        }
    }

    //AGREGAR INGRESO A LA FACTURA
    public function postIngreso(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

                $orden = Ordenfactura::find(Input::get('id'));
                $orden->ingreso = 1;
                $orden->fecha_ingreso = Input::get('fecha_ingreso');
                $orden->modo_ingreso = Input::get('modo_ingreso');
                $orden->recibo_caja = Input::get('recibo_caja');
                $orden->actualizado_por = Sentry::getUser()->id;

                if ($orden->save()) {
                    return Response::json([
                        'respuesta'=>true
                    ]);
                }
            }
        }
    }

    /**
     * @desc FUNCION PARA AGREGAR IMAGENES DE INGRESO A LA FACTURACION
     * @return mixed
     */
    public function postIngresoimagen(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if(Request::ajax()){

                #VALIDACION PARA IMAGENES
                $validaciones = [
                    'foto' => 'mimes:jpeg,bmp,png'
                ];

                #MENSAJE DE VALIDACION
                $mensajes = [
                    'foto.mimes'=>'La imagen debe ser un archivo de tipo imagen (jpg-bmp-png)'
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

                    #BUSCAR LA ORDEN DE FACTURA CON EL ID
                    $ordenes = Ordenfactura::find(Input::get('id'));

                    #SI EL INPUT TIENE IMAGEN
                    if (Input::hasFile('foto')){

                        #ASIGNAR ARCHIVO A LA VARIABLE
                        $file = Input::file('foto');

                        #UBICACION DE LAS IMAGENES DE INGRESO
                        $ubicacion = 'biblioteca_imagenes/facturacion/ingresos/';

                        #NOMBRE ORIGINAL DEL ARCHIVO
                        $nombre_imagen = $file->getClientOriginalName();

                        #VALOR EN LA BASE DE DATOS PARA LA IMAGEN EXISTENTE O VACIA
                        $imagen_antigua = $ordenes->foto_ingreso;

                        #SI EL CAMPO DE LA IMAGEN ESTA VACIO ENTONCES
                        if ($imagen_antigua===null){

                            if(file_exists($ubicacion.$nombre_imagen)){
                                #SI EL ARCHIVO EXISTE ENTONCES CAMBIELE EL NOMBRE YA QUE EL ARCHIVO EXISTE Y SI EXISTE
                                #CON EL MISMO NOMBRE PUEDE OCURRIR DE QUE SE GUARDE ENCIMA DEL EXISTENTE POR LO TANTO
                                #AL NOMBRE SE LE ASIGNA UN NUMERO ALEATORIO
                                $nombre_imagen = rand(1,100000).$nombre_imagen;
                            }

                            $array = [
                                [
                                    'detalle'=>Input::get('detalle'),
                                    'nombre_imagen'=>$nombre_imagen
                                ]
                            ];

                            $ordenes->foto_ingreso = json_encode($array);

                        #SI EL CAMPO DE LA IMAGEN EXISTE ENTONCES
                        }else if($imagen_antigua!=null){

                            #CONVERTIR EL STRING A JSON
                            $array = json_decode($ordenes->foto_ingreso);

                            #REVISAR SI ES ARRAY
                            if (is_array($array)){

                                if(file_exists($ubicacion.$nombre_imagen)){
                                    #SI EL ARCHIVO EXISTE ENTONCES CAMBIELE EL NOMBRE YA QUE EL ARCHIVO EXISTE Y SI EXISTE
                                    #CON EL MISMO NOMBRE PUEDE OCURRIR DE QUE SE GUARDE ENCIMA DEL EXISTENTE POR LO TANTO
                                    #AL NOMBRE SE LE ASIGNA UN NUMERO ALEATORIO
                                    $nombre_imagen = rand(1,100000).$nombre_imagen;
                                }

                                #CREAR ARRAY PARA ASIGNAR VARIAS IMAGENES
                                $arrayVar = [
                                    'detalle'=>Input::get('detalle'),
                                    'nombre_imagen'=>$nombre_imagen
                                ];

                                array_push($array, $arrayVar);

                                $ordenes->foto_ingreso = json_encode($array);

                            }else{

                                #SI EL CAMPO ESTA VACIO Y SE LE VA A AGREGAR UNA IMAGEN ENTONCES TOMAR EL CAMPO ACTUAL Y INTRODUCIRLO A UN ARRAY
                                $array = [
                                    [
                                        'detalle'=>'INGRESO # 1',
                                        'nombre_imagen'=>$imagen_antigua
                                    ]
                                ];

                                #CREAR UN ARRAY CON LA NUEVA IMAGEN
                                $arrayVar = [
                                    'detalle'=>Input::get('detalle'),
                                    'nombre_imagen'=>$nombre_imagen
                                ];

                                array_push($array, $arrayVar);

                                $ordenes->foto_ingreso = json_encode($array);
                            }
                        }

                        if($ordenes->save()){
                            if (Input::hasFile('foto')){
                                Image::make($file->getRealPath())->save($ubicacion.$nombre_imagen);
                                File::delete($ubicacion.$imagen_antigua);
                            }
                            return Response::json([
                                'respuesta'=>true,
                                'nombre_imagen'=>$nombre_imagen
                            ]);
                        }

                    }else {
                        return Response::json([
                            'respuesta'=>false
                        ]);
                    }

                }
            }
        }
    }

    public function postImagencamara(){

        //BUSCAR EL NUMERO DE FACTURA
        $ordenes_facturacion = Ordenfactura::find(Input::get('id'));

        //NOMBRE DE LA IMAGEN BASADO EN EL NUMERO DE FACTURA
        $nombre_imagen = $ordenes_facturacion->numero_factura;

        //TOMAR LOS DATOS ENVIADOS DESDE EL CAMPO DE FORMULARIO OCULTO
        $encoded_data = $_POST['mydata'];

        //CODIFICAR LOS DATOS
        $binary_data = base64_decode($encoded_data);

        //SI EL ARCHIVO YA EXISTE ELIMINARLO
        if(file_exists('biblioteca_imagenes/facturacion/ingresos/'.$ordenes_facturacion->foto_ingreso.'.jpg')){
            File::delete('biblioteca_imagenes/facturacion/ingresos/'.$ordenes_facturacion->foto_ingreso.'.jpg');
        }

        //MOVER IMAGEN A LA CARPETA ASIGNADA
        $result = file_put_contents('biblioteca_imagenes/facturacion/ingresos/RC'.$nombre_imagen.'.jpg', $binary_data);

        //SI EL ARCHIVO ES MOVIDO A LA CARPETA ENTONCES
        if ($result) {

            //ASIGNAR LOS DATOS DE IMAGEN
            $ordenes_facturacion->foto_ingreso = 'RC'.$nombre_imagen.'.jpg';

            //GUARDAR LOS DATOS
            if ($ordenes_facturacion->save()) {
                return Redirect::to('facturacion/verorden/'.Input::get('id'));
            }
        }
    }

    public function postRevisioningreso(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if (Request::ajax()) {

                $revisioningreso = Ordenfactura::find(Input::get('id'));
                $revisioningreso->revision_ingreso = 1;
                $revisioningreso->revisado_por = Sentry::getUser()->id;
                if ($revisioningreso->save()) {
                    return Response::json([
                        'respuesta'=>true
                    ]);
                }
            }
        }
    }

    public function postAnularfacturaotros(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            $orden_facturacion = Ordenfactura::find(Input::get('data-id'));
            $orden_facturacion->anulado = 1;
            $orden_facturacion->motivo_anulacion = Input::get('motivo_anulacion');
            $orden_facturacion->anulado_por = Sentry::getUser()->id;
            if ($orden_facturacion->save()) {
                return Response::json([
                    'respuesta'=>true
                ]);
            }
        }
    }

    public function postAnularfacturatransporte(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            $contar = 0;
            //DATA-ID ES EL ID DE LA FACTURA
            //BUSQUEDA DE LOS SERVICIOS QUE TIENEN EL ID DE ESA FACTURA
            $facturacion = DB::table('facturacion')->where('factura_id',Input::get('data-id'))->get();
            //BUSCAR NUMERO DE FACTURA PARA AGREGARLO AL ARRAY
            $numeroFactura = DB::table('ordenes_facturacion')->where('id',Input::get('data-id'))->pluck('numero_factura');

            $array = [
                'fecha'=>date('Y-m-d H:i:s'),
                'accion'=>'SERVICIO DESVINCUNLADO DE LA FACTURA: <span class="bolder">'.$numeroFactura.'</span> POR ANULACION',
                'realizado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name
            ];

            //CICLO EN EL QUE SE VA A COMPARAR SI ESTA VACIO O NO EL CAMPO
            foreach ($facturacion as $key => $value) {

                $cambios = DB::table('facturacion')->where('servicio_id',$value->servicio_id)->pluck('cambios_servicio');
                //CODIFICAR EL CAMPO CAMBIOS YA QUE ESTE AL SER TRAIDO DE LA BASE DE DATOS ES UN STRING
                $cambios = json_decode($cambios);

                if ($cambios!=null) {

                    array_push($cambios,$array);

                    DB::table('facturacion')
                        ->where('factura_id', Input::get('data-id'))
                        ->update([
                            'facturado' => null,
                            'factura_id'=>null,
                            'cambios_servicio'=>json_encode($cambios),
                        ]);
                }else{

                    DB::table('facturacion')
                        ->where('factura_id', Input::get('data-id'))
                        ->update([
                            'facturado' => null,
                            'factura_id'=>null,
                            'cambios_servicio'=>'['.json_encode($array).']',
                        ]);
                }
                $contar++;

                //ID DE LIQUIDACION SERVICIOS PARA QUITAR EL FACTURADO
                $idliquidacion = $value->liquidacion_id;
            }

            //ACTIVAR LOS SERVICIOS QUITANDOLE EL ESTADO FACTURADO
            if ($contar!=0) {

                $orden_facturacion = Ordenfactura::find(Input::get('data-id'));
                $orden_facturacion->anulado = 1;
                $orden_facturacion->anulado_por = Sentry::getUser()->id;
                $orden_facturacion->motivo_anulacion = Input::get('motivo_anulacion');

                $liquidacion_servicios = Liquidacionservicios::find($idliquidacion);

                //SI NO ESTA VACIO ENTONCES EL REGISTRO EXISTE
                if ($liquidacion_servicios!=null) {
                    $liquidacion_servicios->facturado = null;
                    $liquidacion_servicios->save();
                }

                if ($orden_facturacion->save()) {
                    return Response::json([
                        'respuesta'=>true
                    ]);
                }

            }else{

                return Response::json([
                    'respuesta'=>false,
                    'contar'=>$contar,
                    'facturacion'=>$facturacion
                ]);
            }

        }
    }

    public function postAnularfacturaproveedor(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            //BUSCAR EL PAGO DE PROVEEDOR
            $pago_proveedor = Pagoproveedor::find(Input::get('data-id'));
            $pago_proveedor->anulado = 1;
            $pago_proveedor->fecha_anulado = date('Y-m-d H:i:s');
            $pago_proveedor->anulado_por = Sentry::getUser()->id;
            $pago_proveedor->motivo_anulacion = Input::get('motivo_anulacion');

            /*SI EL PAGO DE PROVEEDOR ES DIFERENTE DE VACIO QUIERE DECIR QUE NO SE PUEDE ANULAR YA QUE
            ESTA REGISTRADO EN UN PAGO*/
            if ($pago_proveedor->id_pago!=null) {

                return Response::json([
                    'respuesta'=>false
                ]);

            }else if($pago_proveedor->id_pago===null){

                if ($pago_proveedor->save()) {

                    $servicios_factura = DB::table('facturacion')
                        ->where('pago_proveedor_id', Input::get('data-id'))
                        ->update([
                            'programado_pago'=>null,
                            'pago_proveedor_id'=>null,
                            'pagado_real'=>null
                        ]);

                    return Response::json([
                        'respuesta'=>true
                    ]);
                }
            }
        }
    }

    public function getExportarordenfacturacion($id){

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else{

            ob_end_clean();
            ob_start();

            Excel::create('Ordenfactura', function($excel) use ($id){

                $excel->sheet('Servicios', function($sheet) use ($id){

                    $servicios = DB::table('facturacion')
                        ->join('servicios', 'facturacion.servicio_id', '=', 'servicios.id')
                        ->join('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
                        ->join('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
                        ->join('ordenes_facturacion', 'facturacion.factura_id', '=', 'ordenes_facturacion.id')
                        ->where('facturacion.factura_id',$id)
                        ->orderBy('servicios.fecha_servicio')
                        ->get();

                    $sheet->loadView('facturacion.plantilla_ordenes_facturacion')
                        ->with([
                            'servicios'=>$servicios
                        ]);

                    $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(11);

                    $sheet->getStyle("D4:F4")->getFont()->setSize(13.5);
                    $sheet->getStyle("D5:F5")->getFont()->setSize(13.5);


                    $sheet->mergeCells('E4:J4');
                    $sheet->mergeCells('E5:J5');
                    $sheet->mergeCells('K4:L5');

                    $sheet->setFontFamily('Arial')
                        ->getStyle('A7:M7')->applyFromArray(array(
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
                        ->getStyle('B13:D13')->getActiveSheet()->getRowDimension('13')->setRowHeight(30);

                    for ($i=6; $i < 1000; $i++) {
                        $sheet->getStyle('A'.$i.':'.'M'.$i)->getAlignment()->setWrapText(true);
                    }

                    $styleArray = array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    );

                    $sheet->getStyle('E4:J4')->applyFromArray($styleArray);
                    $sheet->getStyle('E5:J5')->applyFromArray($styleArray);
                    $sheet->getStyle('K4:L5')->applyFromArray($styleArray);
                });

            })->download('xls');
        }
    }

    public function postExportarexcelordenes(){

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else{

            $fecha_inicial = Input::get('fecha_inicial');
            $fecha_final = Input::get('fecha_final');
            $centrosdecosto = intval(Input::get('centrodecosto'));
            $subcentrosdecosto = intval(Input::get('subcentrodecosto'));

            ob_end_clean();
            ob_start();

            Excel::create('Ordenesfacturacion', function($excel) use ($fecha_inicial, $fecha_final, $centrosdecosto, $subcentrosdecosto){

                $excel->sheet('Ordenes', function($sheet) use ($fecha_inicial, $fecha_final, $centrosdecosto, $subcentrosdecosto){

                    $consulta = "select ordenes_facturacion.id, ordenes_facturacion.consecutivo, ordenes_facturacion.ciudad, ".
                        "centrosdecosto.razonsocial, subcentrosdecosto.nombresubcentro, ordenes_facturacion.fecha_expedicion, ".
                        "ordenes_facturacion.fecha_inicial, ordenes_facturacion.fecha_final, ordenes_facturacion.numero_factura, ".
                        "ordenes_facturacion.fecha_factura, ordenes_facturacion.tipo_orden, ordenes_facturacion.total_facturado_cliente, ".
                        "ordenes_facturacion.total_otros_ingresos, ordenes_facturacion.total_costo, ordenes_facturacion.total_utilidad ".
                        "from ordenes_facturacion ".
                        "left join centrosdecosto on ordenes_facturacion.centrodecosto_id = centrosdecosto.id ".
                        "left join subcentrosdecosto on ordenes_facturacion.subcentrodecosto_id = subcentrosdecosto.id ".
                        "where fecha_expedicion between '".$fecha_inicial." 00:00:01' and '".$fecha_final." 23:59:59'";

                    if ($centrosdecosto!=0) {
                        $consulta .= " and centrodecosto_id = '".$centrosdecosto."' ";
                    }

                    if ($subcentrosdecosto!=0) {
                        $consulta .= " and subcentrodecosto_id = '".$subcentrosdecosto."' ";
                    }

                    $ordenes_facturacion = DB::select($consulta);

                    $sheet->setColumnFormat(array(
                        'L' => '0%',
                        'I' => '$#,##0_-',
                        'J' => '$#,##0_-',
                        'K' => '$#,##0_-'
                    ));

                    $sheet->loadView('facturacion.exportar_ordenes_facturacion')
                        ->with([
                            'ordenes_facturacion'=>$ordenes_facturacion
                        ]);

                });

            })->download('xls');
        }
    }

    public function postNumerofactura(){

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else{

            $id_factura = Input::get('id_factura');
            $numero_factura = DB::table('ordenes_facturacion')->select('numero_factura')->where('id',$id_factura)->first();
            return Response::json([
                'res'=>true,
                'numero_factura'=>$numero_factura
            ]);
        }
    }
    ######################FIN ORDENES DE FACTURACION#####################

    #########################PAGO DE PROVEEDORES#########################
    public function postExportarpagosproveedores(){

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else{

            ob_end_clean();
            ob_start();

            Excel::create('Exportarpagos', function($excel){

                $excel->sheet('Pagoproveedores', function($sheet){

                    $fecha_inicial = Input::get('fecha_inicial');
                    $fecha_final = Input::get('fecha_final');
                    $proveedores = Input::get('proveedores');
                    $centrodecosto = Input::get('centrodecosto');
                    $subcentro = Input::get('subcentrodecosto');

                    $consulta = "select proveedores.razonsocial as nombre_proveedor, centrosdecosto.razonsocial, ".
                        "subcentrosdecosto.nombresubcentro, servicios.fecha_servicio, servicios.id, total_pagado from servicios ".
                        "left join proveedores on servicios.proveedor_id = proveedores.id ".
                        "left join facturacion on servicios.id = facturacion.servicio_id ".
                        "left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id ".
                        "left join subcentrosdecosto on servicios.subcentrodecosto_id = subcentrosdecosto.id ".
                        "where fecha_servicio between '".$fecha_inicial."' and '".$fecha_final."' and afiliado_externo is null ";

                    if($proveedores!='0'){
                        $consulta .= " and proveedores.id = '".$proveedores."' ";
                    }

                    if($centrodecosto!='0'){
                        $consulta .= " and centrosdecosto.id = '".$centrodecosto."' ";
                    }

                    if($subcentro!='0'){
                        $consulta .= " and subcentrosdecosto.id = '".$subcentro."' ";
                    }

                    $servicios = DB::select($consulta." order by servicios.fecha_servicio asc ");

                    $sheet->loadView('facturacion.exportarcorteproveedores')
                        ->with([
                            'servicios'=>$servicios,
                            'fecha_inicial'=>$fecha_inicial,
                            'fecha_final'=>$fecha_final
                        ]);
                });

            })->download('xls');
        }
    }

    public function getPagoproveedores(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->contabilidad->pago_proveedores->ver)){
            $ver = $permisos->contabilidad->pago_proveedores->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else{

          $proveedores = Proveedor::Afiliadosinternos()
          ->orderBy('razonsocial')
          ->where('tipo_servicio', 'TRANSPORTE TERRESTRE')
          ->whereNull('inactivo_total')
          ->whereNull('inactivo')
          ->get();

          $centrosdecosto = Centrodecosto::Internos()->orderBy('razonsocial')->get();

          return View::make('facturacion.pago_proveedores')
          ->with([
              'centrosdecosto'=>$centrosdecosto,
              'proveedores'=>$proveedores,
              'permisos'=>$permisos
          ]);
        }
    }

    public function postBuscarpagoproveedores(){

        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
            if (Request::ajax()) {
                $fecha_inicial = Input::get('fecha_inicial');
                $fecha_final = Input::get('fecha_final');
                $proveedores = intval(Input::get('proveedores'));
                $conductores = Input::get('conductores');
                $centrodecosto = Input::get('centrodecosto');
                $subcentro = Input::get('subcentrodecosto');
                $tipo_afiliado = Input::get('tipo_afiliado');

                $consulta = "SELECT `servicios`.`id`, `servicios`.`fecha_servicio`, ".
                    "`servicios`.`detalle_recorrido`, `servicios`.`pasajeros`, ".
                    "`servicios`.`proveedor_id`, ".
                    "`facturacion`.`id` as facturaid, `facturacion`.`observacion`, `facturacion`.`facturado`, `facturacion`.`numero_planilla`, ".
                    "`facturacion`.`factura_id`, `facturacion`.`total_pagado`, `facturacion`.`programado_pago`, `facturacion`.`pagado`, ".
                    "`facturacion`.`pago_proveedor_id`, `facturacion`.`revisado`, `facturacion`.`liquidado`,".
                    "`pago_proveedores`.`consecutivo` as pconsecutivo, `pago_proveedores`.`numero_factura` as numerofactura, `pago_proveedores`.`programado`, ".
                    "`centrosdecosto`.`razonsocial`, ".
                    "`ordenes_facturacion`.`numero_factura`, `ordenes_facturacion`.`consecutivo`, `ordenes_facturacion`.`ingreso`, `ordenes_facturacion`.`fecha_expedicion`,".
                    "`subcentrosdecosto`.`nombresubcentro`".
                    "from `servicios`".
                    "left join `facturacion` on `servicios`.`id` = `facturacion`.`servicio_id`".
                    "left join `pago_proveedores` on `facturacion`.`pago_proveedor_id` = `pago_proveedores`.`id`".
                    "left join `ordenes_facturacion` on `facturacion`.`factura_id` = `ordenes_facturacion`.`id`".
                    "left join `proveedores` on `servicios`.`proveedor_id` = `proveedores`.`id`".
                    "left join `conductores` on `servicios`.`conductor_id` = `conductores`.`id`".
                    "left join `centrosdecosto` on `servicios`.`centrodecosto_id` = `centrosdecosto`.`id`".
                    "left join `subcentrosdecosto` on `servicios`.`subcentrodecosto_id` = `subcentrosdecosto`.`id`".
                "WHERE `servicios`.`fecha_servicio` BETWEEN '".$fecha_inicial."' AND '".$fecha_final."' and servicios.afiliado_externo is null and servicios.pendiente_autori_eliminacion is null ";

                /*if ($tipo_afiliado==0 or $tipo_afiliado==2) {
                    $consulta .= " and (proveedores.tipo_afiliado IS NULL OR proveedores.tipo_afiliado = 1) ";
                }else if ($tipo_afiliado==3) {
                    $consulta .= " and centrosdecosto.tipo_cliente = 2 ";
                }*/

                if($proveedores!=0){
                    $consulta .= " and `proveedor_id` = '".$proveedores."' ";
                }

                if($conductores!=0){
                    $consulta .= " and `conductores`.`id` = '".$conductores."' ";
                }

                if($centrodecosto!=0){
                    $consulta .= " and `centrosdecosto`.`id` = '".$centrodecosto."' ";
                }

                if($subcentro!=0){
                    $consulta .= " and `subcentrosdecosto`.`id` = '".$subcentro."' ";
                }

                $servicios = DB::select(DB::raw($consulta." order by `fecha_servicio` asc"));

                if ($servicios!=null) {

                    return Response::json([
                        'respuesta'=>true,
                        'servicios'=>$servicios
                    ]);

                }else{

                    return Response::json([
                        'respuesta'=>false
                    ]);
                }
            }
        }
    }

    public function postBuscarpagos(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if (Request::ajax()) {

                $consulta = '';
                $proceso = intval(Input::get('proceso'));
                $proveedor = intval(Input::get('proveedor'));
                $fecha_inicial = Input::get('fecha_inicial');
                $fecha_final = Input::get('fecha_final');
                $estado = intval(Input::get('estado'));

                #PAGOS A PREPARAR
                if ($proceso===0) {

                    #SI EL SELECCIONADO NO PREPARADO ENTONCES SOLO MOSTRAR LOS QUE NO ESTAN PREPARANDOS
                    if ($estado===1){

                        $consulta = "select pagos.id, proveedores.razonsocial, proveedores.tipo_afiliado, pagos.fecha_registro, pagos.fecha_pago, pagos.fecha_preparacion, ".
                            "pagos.total_pagado, pagos.descuento_retefuente, pagos.otros_descuentos, pagos.total_neto, ".
                            "pagos.auditado, pagos.preparado, pagos.pagado, pagos.autorizado, users.first_name, users.last_name from pagos ".
                            "left join proveedores on pagos.proveedor = proveedores.id ".
                            "left join users on pagos.usuario = users.id ".
                            "where pagos.preparado is null ";

                    }else if($estado===0){

                        $consulta = "select pagos.id, proveedores.razonsocial, proveedores.tipo_afiliado, pagos.fecha_registro, pagos.fecha_pago, pagos.fecha_preparacion, ".
                            "pagos.total_pagado, pagos.descuento_retefuente, pagos.otros_descuentos, pagos.total_neto, ".
                            "pagos.auditado, pagos.preparado, pagos.pagado, pagos.autorizado, users.first_name, users.last_name from pagos ".
                            "left join proveedores on pagos.proveedor = proveedores.id ".
                            "left join users on pagos.usuario = users.id ".
                            "where pagos.fecha_pago BETWEEN '".$fecha_inicial."' AND '".$fecha_final."' ";

                    }

                    if ($proveedor===0) {
                        $pagos = DB::select($consulta);
                    }else if($proveedor!=0){
                        $consulta .= "and proveedor = ".$proveedor." ";
                        $pagos = DB::select($consulta);
                    }

                    if ($pagos!=null) {
                        return Response::json([
                            'respuesta'=>true,
                            'pagos'=>$pagos
                        ]);
                    }else{
                        return Response::json([
                            'respuesta'=>false,
                            'consulta'=>$consulta
                        ]);
                    }

                #PAGOS A AUDITAR
                }elseif ($proceso===1) {

                    if ($estado===0){

                        $consulta = "select pagos.id, proveedores.razonsocial, proveedores.tipo_afiliado, pagos.fecha_registro, pagos.fecha_pago, pagos.fecha_preparacion, ".
                            "pagos.total_pagado, pagos.descuento_retefuente, pagos.otros_descuentos, pagos.total_neto, ".
                            "pagos.auditado, pagos.preparado, pagos.pagado, pagos.autorizado, users.first_name, users.last_name from pagos ".
                            "left join proveedores on pagos.proveedor = proveedores.id ".
                            "left join users on pagos.usuario = users.id ".
                            "where pagos.fecha_preparacion BETWEEN '".$fecha_inicial."' AND '".$fecha_final."' and preparado = 1 ";

                    }else if($estado===1){

                        $consulta = "select pagos.id, proveedores.razonsocial, proveedores.tipo_afiliado, pagos.fecha_registro, pagos.fecha_pago, pagos.fecha_preparacion, ".
                            "pagos.total_pagado, pagos.descuento_retefuente, pagos.otros_descuentos, pagos.total_neto, ".
                            "pagos.auditado, pagos.preparado, pagos.pagado, pagos.autorizado, users.first_name, users.last_name from pagos ".
                            "left join proveedores on pagos.proveedor = proveedores.id ".
                            "left join users on pagos.usuario = users.id ".
                            "where pagos.preparado = 1 and pagos.auditado is null ";
                    }

                    if ($proveedor===0) {
                        $pagos = DB::select($consulta);
                    }else if($proveedor!=0){
                        $consulta .= " and proveedor = ".$proveedor." ";
                        $pagos = DB::select($consulta);
                    }

                    if ($pagos!=null) {
                        return Response::json([
                            'respuesta'=>true,
                            'pagos'=>$pagos,
                            'consulta'=>$consulta
                        ]);
                    }else{
                        return Response::json([
                            'respuesta'=>false,
                            'consulta'=>$consulta
                        ]);
                    }

                #PAGOS A AUTORIZAR
                }elseif ($proceso===2) {

                    if($estado===1){

                        $consulta = "select pagos.id, proveedores.razonsocial, proveedores.tipo_afiliado, pagos.fecha_registro, pagos.fecha_pago, pagos.fecha_preparacion, ".
                            "pagos.total_pagado, pagos.descuento_retefuente, pagos.otros_descuentos, pagos.total_neto, ".
                            "pagos.auditado, pagos.preparado, pagos.pagado, pagos.autorizado, users.first_name, users.last_name from pagos ".
                            "left join proveedores on pagos.proveedor = proveedores.id ".
                            "left join users on pagos.usuario = users.id ".
                            "where pagos.auditado = 1 and pagos.autorizado is null ";

                    }else if($estado===0){

                        $consulta = "select pagos.id, proveedores.razonsocial, proveedores.tipo_afiliado, pagos.fecha_registro, pagos.fecha_pago, pagos.fecha_preparacion, ".
                            "pagos.total_pagado, pagos.descuento_retefuente, pagos.otros_descuentos, pagos.total_neto, ".
                            "pagos.auditado, pagos.preparado, pagos.pagado, pagos.autorizado, users.first_name, users.last_name from pagos ".
                            "left join proveedores on pagos.proveedor = proveedores.id ".
                            "left join users on pagos.usuario = users.id ".
                            "where pagos.fecha_preparacion BETWEEN '".$fecha_inicial."' AND '".$fecha_final."' and pagos.auditado = 1 ";

                    }

                    if ($proveedor===0) {
                        $pagos = DB::select($consulta);
                    }else if($proveedor!=0){
                        $consulta .= " and proveedor = ".$proveedor." ";
                        $pagos = DB::select($consulta);
                    }

                    if ($pagos!=null) {
                        return Response::json([
                            'respuesta'=>true,
                            'pagos'=>$pagos
                        ]);
                    }else{
                        return Response::json([
                            'respuesta'=>false,
                            'consulta'=>$consulta,                            
                        ]);
                    }

                #PAGOS A PAGAR
                }elseif ($proceso===3) {

                    $consulta = "select pagos.id, proveedores.razonsocial, proveedores.tipo_afiliado, pagos.fecha_registro, pagos.fecha_pago, pagos.fecha_preparacion, pagos.fecha_pago_real, ".
                        "pagos.total_pagado, pagos.descuento_retefuente, pagos.otros_descuentos, pagos.total_neto, ".
                        "pagos.auditado, pagos.preparado, pagos.pagado, pagos.autorizado, users.first_name, users.last_name from pagos ".
                        "left join proveedores on pagos.proveedor = proveedores.id ".
                        "left join users on pagos.usuario = users.id ".
                        "where pagos.autorizado = 1 and pagos.fecha_pago_real BETWEEN '".$fecha_inicial."' AND '".$fecha_final."'  ";

                    if ($proveedor===0) {
                        $pagos = DB::select($consulta);
                    }else if($proveedor!=0){
                        $consulta .= " and proveedor = ".$proveedor." ";
                        $pagos = DB::select($consulta);
                    }

                    if ($pagos!=null) {
                        return Response::json([
                            'respuesta'=>true,
                            'pagos'=>$pagos,
                            'consulta'=>$consulta
                        ]);
                    }else{
                        return Response::json([
                            'respuesta'=>false,
                            'consulta'=>$consulta
                        ]);
                    }
                }
            }
        }
    }

    /**
     * @desc FUNCION PARA VALIDAR QUE EL VALOR COBRADO NO SEA MAYOR AL VALOR LIQUIDADO POR FACTURACION
     * @return mixed
     */
    public function postValidarvalorcobrado(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if (Request::ajax()) {

                $id = Input::get('id');
                $valor_cobrado = intval(Input::get('valor_cobrado'));

                $valor_liquidado = DB::table('facturacion')->where('id',$id)->pluck('total_pagado');

                if(intval($valor_liquidado)<$valor_cobrado){

                    return Response::json([
                        'respuesta'=>false,
                        'valor_liquidado'=>$valor_liquidado,
                        'id'=>$id
                    ]);

                }else{

                    return Response::json([
                        'respuesta'=>true,
                        'valor_liquidado'=>$valor_liquidado,
                        'id'=>$id
                    ]);
                }
            }
        }
    }

    public function postNuevopagoproveedores(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if (Request::ajax()) {

                //REVISAR SI YA EXISTE UNA FACTURA CON ESAS FECHAS
                $contar_ordenes = DB::table('pago_proveedores')
                    ->where('proveedor',Input::get('proveedor'))
                    ->whereNull('anulado')
                    ->where('centrodecosto', Input::get('centrodecosto'))
                    ->where('subcentrodecosto', Input::get('subcentrodecosto'))
                    ->whereBetween('fecha_inicial', ([Input::get('fecha_inicial'),Input::get('fecha_final')]))
                    ->whereBetween('fecha_final', ([Input::get('fecha_inicial'),Input::get('fecha_final')]))
                    ->count();

                if(intval($contar_ordenes)>0){

                    return Response::json([
                        'respuesta'=>false
                    ]);

                }else{

                    try{

                        $pago_proveedor = new Pagoproveedor;
                        $pago_proveedor->numero_factura = Input::get('numero_factura');
                        $pago_proveedor->fecha_expedicion = date('Y-m-d H:i:s');
                        $pago_proveedor->fecha_pago = Input::get('fecha_pago');
                        $pago_proveedor->proveedor = Input::get('proveedor');
                        $pago_proveedor->centrodecosto = Input::get('centrodecosto');
                        $pago_proveedor->subcentrodecosto = Input::get('subcentrodecosto');
                        $pago_proveedor->fecha_inicial = Input::get('fecha_inicial');
                        $pago_proveedor->fecha_final = Input::get('fecha_final');
                        $pago_proveedor->valor_no_cobrado = Input::get('valornocobrado');
                        $pago_proveedor->subtotal_general = Input::get('subtotal_generado_pagar');
                        $pago_proveedor->valor = Input::get('total_real_pagar');
                        $pago_proveedor->observaciones = Input::get('observaciones');
                        $pago_proveedor->creado_por = Sentry::getUser()->id;

                        if ($pago_proveedor->save()) {

                            //ASIGNAR CONSECUTIVO
                            $id = $pago_proveedor->id;
                            $p = Pagoproveedor::find($id);

                            if(strlen($id)===1){
                                $p->consecutivo = 'AP0000'.$id;
                            }elseif(strlen($id)===2){
                                $p->consecutivo = 'AP000'.$id;
                            }elseif(strlen($id)===3){
                                $p->consecutivo = 'AP00'.$id;
                            }elseif(strlen($id)===4){
                                $p->consecutivo = 'AP0'.$id;
                            }else if(strlen($id)>4){
                                $p->consecutivo = 'AP'.$id;
                            }

                            if($p->save()){

                                $guardados = 0;

                                $update = DB::update("update facturacion set programado_pago = 1, pago_proveedor_id = ".$id." where id in (".Input::get('idArray').")");

                                $pagadorealArray = (explode(',', Input::get('pagadorealArray')));
                                $idarray = (explode(',', Input::get('idArray')));

                                for ($i=0; $i < count($pagadorealArray); $i++) {
                                    $update = Facturacion::find($idarray[$i]);
                                    $update->pagado_real = $pagadorealArray[$i];
                                    if ($update->save()) {
                                        $guardados = $guardados+1;
                                    }
                                }
                                $contador_guardados = count($pagadorealArray);


                                if ($update!=null) {
                                    return Response::json([
                                        'respuesta'=>true,
                                        'guardados'=>$guardados,
                                        'contador_guardados'=>$contador_guardados,
                                        'consecutivo'=>$p->consecutivo

                                    ]);
                                }
                            }
                        }

                    }catch (Exception $e){
                        return Response::json([
                            'respuesta'=>'error',
                            'e'=>$e,
                        ]);
                    }
                }
            }
        }
    }

    public function getFacturapagoproveedores(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->contabilidad->factura_proveedores->ver)){
            $ver = $permisos->contabilidad->factura_proveedores->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else{

            $centrosdecosto = DB::table('centrosdecosto')
                ->whereNull('inactivo_total')
                ->orderBy('razonsocial')
                ->get();
            $proveedores = DB::table('proveedores')
                ->whereNull('inactivo_total')
                ->orderBy('razonsocial')->get();

            return View::make('facturacion.factura_pago_proveedores')
                ->with([
                    'centrosdecosto' => $centrosdecosto,
                    'proveedores' => $proveedores,
                    'permisos'=>$permisos
                ]);
        }
    }

    public function getDetallepagoproveedores($id){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->contabilidad->factura_proveedores->ver)){
            $ver = $permisos->contabilidad->factura_proveedores->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {
            $pago_proveedores_detalles = DB::table('facturacion')
                ->select('servicios.id','servicios.fecha_servicio', 'servicios.pasajeros', 'servicios.detalle_recorrido', 'facturacion.observacion',
                    'facturacion.numero_planilla', 'facturacion.total_pagado', 'facturacion.pagado_real', 'pago_proveedores.fecha_pago',
                    'pago_proveedores.numero_factura as pfactura', 'ordenes_facturacion.numero_factura', 'ordenes_facturacion.consecutivo',
                    'ordenes_facturacion.ingreso', 'ordenes_facturacion.fecha_expedicion','ordenes_facturacion.id as id_orden_factura')
                ->leftJoin('servicios', 'facturacion.servicio_id', '=', 'servicios.id')
                ->leftJoin('ordenes_facturacion', 'facturacion.factura_id', '=', 'ordenes_facturacion.id')
                ->leftJoin('pago_proveedores', 'facturacion.pago_proveedor_id','=', 'pago_proveedores.id')
                ->where('facturacion.pago_proveedor_id',$id)->get();

            $pago_proveedores = DB::table('pago_proveedores')
                ->select('centrosdecosto.razonsocial as centrodecostonombre', 'proveedores.razonsocial as proveedornombre',
                    'pago_proveedores.id as idpago','pago_proveedores.valor_no_cobrado','pago_proveedores.consecutivo',
                    'users.first_name','users.last_name','pago_proveedores.revisado','pagos.preparado',
                    'pago_proveedores.fecha_expedicion', 'pago_proveedores.numero_factura','pago_proveedores.fecha_inicial', 'pago_proveedores.observaciones',
                    'subcentrosdecosto.nombresubcentro','pago_proveedores.valor','pago_proveedores.fecha_final','pago_proveedores.fecha_pago')
                ->leftJoin('centrosdecosto', 'pago_proveedores.centrodecosto', '=', 'centrosdecosto.id')
                ->leftJoin('proveedores', 'pago_proveedores.proveedor', '=', 'proveedores.id')
                ->leftJoin('subcentrosdecosto', 'pago_proveedores.subcentrodecosto', '=', 'subcentrosdecosto.id')
                ->leftJoin('users', 'pago_proveedores.creado_por', '=', 'users.id')
                ->leftJoin('pagos', 'pago_proveedores.id_pago', '=', 'pagos.id')
                ->where('pago_proveedores.id',$id)
                ->first();

            return View::make('facturacion.pago_proveedores_detalles')
                ->with([
                    'pago_proveedores_detalles'=>$pago_proveedores_detalles,
                    'pago_proveedores'=>$pago_proveedores,
                    'permisos'=>$permisos
                ]);
        }

    }

    public function postRevisarpagoproveedor(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if (Request::ajax()) {

                $revisar = Pagoproveedor::find(Input::get('id'));
                $revisar->revisado = 1;
                $revisar->fecha_revisado = date('Y-m-d H:i:s');
                $revisar->revisado_por = Sentry::getUser()->id;
                $revisar->save();

                if ($revisar->save()) {
                    return Response::json([
                        'respuesta'=>true
                    ]);
                }

            }
        }
    }

    public function postGuardarpago(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if (Request::ajax()) {

                //VALIDAR SI YA EXISTE UN PAGO DE ESTE PROVEEDOR PARA ESTA FECHA
                $validar = DB::table('pagos')
                    ->where('fecha_pago', Input::get('fecha_pago'))
                    ->where('proveedor',Input::get('proveedor'))
                    ->get();

                if ($validar!=null) {

                    return Response::json([
                        'existe'=>true
                    ]);

                }else{                    

                    $pago = new Pago;
                    $pago->proveedor = Input::get('proveedor');
                    $pago->fecha_registro = date('Y-m-d H:i:s');
                    $pago->fecha_pago = Input::get('fecha_pago');
                    $pago->total_pagado = Input::get('totales_cuentas');
                    $pago->descuento_retefuente = Input::get('valor_retefuente');
                    $pago->detalles_descuentos = Input::get('arrayDescuentos');
                    $pago->otros_descuentos = Input::get('otros_descuentos');
                    
                    $prestamos = DB::table('prestamos')
                    ->where('proveedor_id',Input::get('proveedor'))
                    ->where('estado_prestamo',0)
                    ->first();

                    //$prestamos2 = DB::table('prestamos')->where('proveedor_id',Input::get('proveedor'))->get();

                    if($prestamos!=null){
                        $pago->descuento_prestamo = Input::get('prestamo1');
                    }
                    $pago->total_neto = Input::get('totales_pagado');
                    $pago->observaciones = Input::get('observaciones');
                    $pago->usuario = Sentry::getUser()->id;

                    if ($pago->save()) {

                        $variable = null;

                        if($prestamos!=null){
                            $texto = "PRESTAMO DESCONTADO DEL PAGO # ".$pago->id.", EL DÍA ".date('y-m-d').", POR EL USUARIO ".Sentry::getUser()->first_name." ".Sentry::getUser()->last_name."";

                            DB::update("update prestamos set id_pago = ".$pago->id.", estado_prestamo = 1, detalles = '".$texto."' where proveedor_id = ".Input::get('proveedor')." and estado_prestamo = 0");
                            $variable = 1;
                        }else{
                            $variable = 0;
                        }

                        DB::update("update pago_proveedores set id_pago = ".$pago->id.", programado = 1 where anulado is null and id in (".Input::get('idArray').")");

                        return Response::json([
                            'respuesta'=>true,
                            'validar'=>$validar,
                            'sw'=>$variable
                        ]);

                    }else{
                        return Response::json([
                            'errors'=>true
                        ]);
                    }
                }
            }
        }
    }

    public function getListadodepagospreparados(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->contabilidad->listado_de_pagos_preparar->ver)){
            $ver = $permisos->contabilidad->listado_de_pagos_preparar->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {

            $proveedores = DB::table('proveedores')
                ->whereNull('inactivo_total')
                ->orderby('razonsocial')
                ->get();
            return View::make('facturacion.listadodepagosapreparar')
                ->with([
                    'proveedores'=>$proveedores,
                    'permisos'=>$permisos
                ]);

        }
    }

    public function getListadodepagosauditados(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->contabilidad->listado_de_pagos_auditar->ver)){
            $ver = $permisos->contabilidad->listado_de_pagos_auditar->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {

            $proveedores = DB::table('proveedores')
                ->whereNull('inactivo_total')
                ->orderby('razonsocial')
                ->get();

            return View::make('facturacion.listadodepagosauditar')
                ->with([
                    'proveedores'=>$proveedores,
                    'permisos'=>$permisos
                ]);
        }
    }

    public function getListadopagosautorizados(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->contabilidad->listado_de_pagos_autorizar->ver)){
            $ver = $permisos->contabilidad->listado_de_pagos_autorizar->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {

            $proveedores = DB::table('proveedores')
                ->whereNull('inactivo_total')
                ->orderby('razonsocial')
                ->get();
            return View::Make('facturacion.listado_pagos_autorizados')
                ->with([
                    'proveedores'=>$proveedores,
                    'permisos'=>$permisos
                ]);
        }
    }

    public function getListadopagos(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->contabilidad->listado_de_pagados->ver)){
            $ver = $permisos->contabilidad->listado_de_pagados->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {

            $proveedores = DB::table('proveedores')
                ->whereNull('inactivo_total')
                ->orderby('razonsocial')
                ->get();

            return View::Make('facturacion.listadodepagospagados')
                ->with([
                    'proveedores'=>$proveedores,
                    'permisos'=>$permisos
                ]);
        }
    }

    public function postBuscarfacturapagosproveedores(){

        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
            if (Request::ajax()) {

                $opcion = intval(Input::get('opcion'));
                $fecha_pago = Input::get('fecha_pago');
                $proveedores = intval(Input::get('proveedor'));

                if($opcion===1){
                    $centrodecosto = intval(Input::get('centrodecosto'));
                    $subcentrodecosto = intval(Input::get('subcentrodecosto'));

                    $consulta = "select pago_proveedores.id, pago_proveedores.consecutivo, pago_proveedores.numero_factura, ".
                        "pago_proveedores.fecha_expedicion, pago_proveedores.fecha_inicial, pago_proveedores.fecha_final, pago_proveedores.fecha_pago, ".
                        "pago_proveedores.valor,pago_proveedores.fecha_revisado, pago_proveedores.revisado, pago_proveedores.programado, pago_proveedores.anulado, pago_proveedores.motivo_anulacion, ".
                        "centrosdecosto.razonsocial, subcentrosdecosto.nombresubcentro, proveedores.id as proveedorid, proveedores.razonsocial as proveedor, ".
                        "users1.first_name as creado_first_name, users1.last_name as creado_last_name, users2.first_name as revisado_first_name, ".
                        "users2.last_name as revisado_last_name ".
                        "from pago_proveedores ".
                        "left join users as users1 on pago_proveedores.creado_por = users1.id ".
                        "left join users as users2 on pago_proveedores.revisado_por = users2.id ".
                        "left join proveedores on pago_proveedores.proveedor = proveedores.id ".
                        "left join centrosdecosto on pago_proveedores.centrodecosto = centrosdecosto.id ".
                        "left join subcentrosdecosto on pago_proveedores.subcentrodecosto = subcentrosdecosto.id ".
                        "where pago_proveedores.fecha_pago = '".$fecha_pago."'";

                    if($proveedores!=0){
                        $consulta = $consulta ." and proveedor = ".$proveedores." ";
                    }

                    if($centrodecosto!=0){
                        $consulta = $consulta ." and centrodecosto = ".$centrodecosto." ";
                    }

                    if($subcentrodecosto!=0){
                        $consulta = $consulta ." and subcentrodecosto = ".$subcentrodecosto." ";
                    }

                }else if($opcion===2){

                    $opcion_numero = intval(Input::get('opcion_numero'));
                    $numero = Input::get('numero');

                    if($opcion_numero===1){

                        $consulta = "select pago_proveedores.id, pago_proveedores.consecutivo, pago_proveedores.numero_factura, ".
                            "pago_proveedores.fecha_expedicion, pago_proveedores.fecha_pago, pago_proveedores.centrodecosto, ".
                            "pago_proveedores.subcentrodecosto, pago_proveedores.fecha_inicial, pago_proveedores.fecha_final, pago_proveedores.valor_no_cobrado, ".
                            "pago_proveedores.valor, centrosdecosto.razonsocial, subcentrosdecosto.nombresubcentro, users.first_name as creado_first_name, users.last_name as creado_last_name, ".
                            "proveedores.razonsocial as proveedor, pago_proveedores.anulado from pago_proveedores ".
                            "left join users on pago_proveedores.creado_por = users.id ".
                            "left join centrosdecosto on pago_proveedores.centrodecosto = centrosdecosto.id ".
                            "left join subcentrosdecosto on pago_proveedores.subcentrodecosto = subcentrosdecosto.id ".
                            "left join proveedores on pago_proveedores.proveedor = proveedores.id ".
                            "where numero_factura = '".$numero."'";

                    }else if($opcion_numero===2){
                        $consulta = "select pago_proveedores.id, pago_proveedores.consecutivo, pago_proveedores.numero_factura, ".
                            "pago_proveedores.fecha_expedicion, pago_proveedores.fecha_pago, pago_proveedores.centrodecosto, ".
                            "pago_proveedores.subcentrodecosto, pago_proveedores.fecha_inicial, pago_proveedores.fecha_final, pago_proveedores.valor_no_cobrado, ".
                            "pago_proveedores.valor, centrosdecosto.razonsocial, subcentrosdecosto.nombresubcentro, users.first_name as creado_first_name, users.last_name as creado_last_name, ".
                            "proveedores.razonsocial as proveedor, pago_proveedores.anulado from pago_proveedores ".
                            "left join users on pago_proveedores.creado_por = users.id ".
                            "left join centrosdecosto on pago_proveedores.centrodecosto = centrosdecosto.id ".
                            "left join subcentrosdecosto on pago_proveedores.subcentrodecosto = subcentrosdecosto.id ".
                            "left join proveedores on pago_proveedores.proveedor = proveedores.id ".
                            "where consecutivo = '".$numero."'";
                    }

                }

                $pagos = DB::select(DB::raw($consulta."order by `consecutivo` asc"));

                if (intval($proveedores)!=0) {

                    $pago_mostrar = DB::table('pagos')
                        ->select('pagos.id','pagos.detalles_descuentos','pagos.proveedor','pagos.fecha_pago','pagos.fecha_registro','pagos.total_pagado','pagos.descuento_retefuente',
                            'pagos.otros_descuentos','pagos.total_neto','pagos.usuario','users.first_name','users.last_name','pagos.preparado','pagos.observaciones',
                            'pagos.auditado','pagos.autorizado', 'pagos.descuento_prestamo')
                        ->leftJoin('users','pagos.usuario','=','users.id')
                        ->where('pagos.proveedor',$proveedores)
                        ->where('pagos.fecha_pago',$fecha_pago)
                        ->first();

                    $prestamo_mostrar = DB::table('prestamos')
                    ->where('proveedor_id',$proveedores)
                    ->where('estado_prestamo',0)
                    ->where('fecha',$fecha_pago)
                    ->first();
                    //
                    if($prestamo_mostrar!=null){
                        $total = $prestamo_mostrar->valor_prestado;                       
                    }else{
                        $total = null;                        
                    }
                    //

                }else{
                    $pago_mostrar = null;
                    $total = null;
                }

                if ($pagos!=null) {

                    return Response::json([
                        'respuesta'=>true,
                        'pagos'=>$pagos,
                        'pago_mostrar'=>$pago_mostrar,
                        'valor_prestamos'=>$total,
                        'proveedor'=>$proveedores,
                        'consulta'=>$prestamo_mostrar
                    ]);

                }else{

                    return Response::json([
                        'respuesta'=>false
                    ]);
                }
            }
        }
    }

    public function postDetallesdeprestamo(){

        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
            if (Request::ajax()) {

                $id = Input::get('id');
                $pago = Input::get('pago_id');

                if($id!=''){

                    $query = DB::table('prestamos')                
                    ->where('prestamos.id',$id)
                    ->first(); 

                }elseif($pago!=''){

                    $query = DB::table('prestamos')
                    ->select('prestamos.id', 'prestamos.valor_prestado', 'prestamos.created_at', 'prestamos.razon', 'prestamos.detalles_valores')
                    ->leftJoin('pagos', 'pagos.id', '=', 'prestamos.id_pago')
                    ->where('pagos.id',$pago)
                    ->first();
                }else{

                    $query = DB::table('prestamos')                
                    ->where('id',$id)
                    ->first(); 

                }

                if($query){
                    return Response::json([
                        'respuesta'=>true,
                        'prestamo'=>$query,
                        'option'=>Input::get('data_option'),
                        'pago'=>$pago
                    ]);
                }else{
                    return Response::json([
                        'respuesta'=>false,
                        'prestamo'=>$query,
                        'pago'=>$pago
                    ]);
                }
            }
        }
    }

    public function postDetallesdeprestamosinpago(){

        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
            if (Request::ajax()) {

                $id = Input::get('prestamo_id');

                $query = DB::table('prestamos')                
                ->where('prestamos.id',$id)
                ->first();             

                if($query){
                    return Response::json([
                        'respuesta'=>true,
                        'prestamo'=>$query,
                        'id'=>$id
                    ]);
                }else{
                    return Response::json([
                        'respuesta'=>false,
                        'prestamo'=>$query,
                        'id'=>$id
                    ]);
                }
            }
        }
    }

    public function postPrepararpago(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if (Request::ajax()) {

                $cn = "update pagos set preparado = 1, fecha_preparacion = '".Input::get('fecha_preparacion')."', preparado_por = ".Sentry::getUser()->id." where id in (".Input::get('idArray').")";

                $update = DB::update($cn);

                if ($update!=null) {
                    return Response::json([
                        'respuesta'=>true
                    ]);
                }else{
                    return Response::json([
                        'cn'=>$cn
                    ]);
                }
            }
        }
    }

    public function postAuditarpago(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if (Request::ajax()) {

                $update = DB::update("update pagos set auditado = 1, auditado_por = ".Sentry::getUser()->id." where id in (".Input::get('idArray').")");

                if ($update!=null) {

                    return Response::json([
                        'respuesta'=>true
                    ]);
                }
            }
        }
    }

    public function postMostrarfacturasconingreso(){

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else{

            return Response::json([
                'respuesta'=>true
            ]);

        }
    }

    public function postCambiarfechapago(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if (Request::ajax()) {

                $pago_proveedores = Pagoproveedor::find(Input::get('id'));
                $pago_proveedores->fecha_pago = Input::get('fecha_pago');
                if ($pago_proveedores->save()) {
                    return Response::json([
                        'respuesta'=>true
                    ]);
                }

            }
        }
    }

    public function getDetalleap($id){

        if (!Sentry::check()){
            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
        }else{

            $pago_proveedores = DB::table('pago_proveedores')
                ->select('pago_proveedores.id','users.first_name','users.last_name','pago_proveedores.consecutivo', 'pago_proveedores.anulado', 'pago_proveedores.fecha_expedicion',
                    'pago_proveedores.numero_factura','pago_proveedores.fecha_inicial','pago_proveedores.fecha_final','pago_proveedores.fecha_pago',
                    'proveedores.razonsocial as razonsocialp','pago_proveedores.valor','centrosdecosto.razonsocial','subcentrosdecosto.nombresubcentro')
                ->leftJoin('proveedores','pago_proveedores.proveedor','=','proveedores.id')
                ->leftJoin('centrosdecosto','pago_proveedores.centrodecosto','=','centrosdecosto.id')
                ->leftJoin('subcentrosdecosto','pago_proveedores.subcentrodecosto','=','subcentrosdecosto.id')
                ->leftJoin('users','pago_proveedores.creado_por','=','users.id')
                //->leftJoin('prestamos', 'prestamos.proveedor_id', '=', 'pago_proveedores.proveedor')
                ->where('pago_proveedores.id_pago',$id)
                ->where('pago_proveedores.anulado', null)
                //->where('prestamos.estado_prestamo',0)
                ->get();

            return View::make('facturacion.detalleap')
                ->with([
                    'pago_proveedores'=>$pago_proveedores,
                    'id'=>$id
                ]);

        }
    }

    public function postAutorizarpago(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if (Request::ajax()) {

                $update = DB::update("update pagos set autorizado = 1, fecha_pago_real = '".Input::get('fecha_pago_real')."', autorizado_por = ".Sentry::getUser()->id." where id in (".Input::get('idArray').")");

                if ($update!=null) {

                    return Response::json([
                        'respuesta'=>true
                    ]);
                }
            }
        }
    }

    /**************************************************************************************/
    #########################FIN PAGO PROVEEDORES##################

	public function getExportarof($of){
		if (!Sentry::check()){
            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
        }else{

            //CONSULTA DE SERVICIOS TOTALES
            $consulta = "select servicios.id, servicios.fecha_servicio, servicios.ciudad, servicios.solicitado_por, facturacion.numero_planilla, servicios.pasajeros, proveedores.razonsocial as prazonproveedor, servicios.recoger_en, servicios.dejar_en, centrosdecosto.razonsocial, subcentrosdecosto.nombresubcentro, facturacion.observacion, facturacion.unitario_cobrado, facturacion.unitario_pagado, facturacion.total_cobrado, total_pagado, facturacion.utilidad, facturacion.cod_centro_costo, facturacion.utilidad from  servicios
			left join  facturacion on facturacion.servicio_id = servicios.id
			left join subcentrosdecosto on servicios.subcentrodecosto_id = subcentrosdecosto.id
			left join proveedores on servicios.proveedor_id = proveedores.id
			left join conductores on servicios.conductor_id = conductores.id
			left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id
			left join liquidacion_servicios on liquidacion_servicios.id = facturacion.liquidacion_id
			where facturacion.liquidacion_id = '".$of."' and servicios.pendiente_autori_eliminacion is null order by servicios.fecha_servicio";

			$servicios_of = DB::select($consulta);

            if(count($servicios_of) > 0){

                ob_end_clean();
                ob_start();
                Excel::create('Listado OF'.$of, function($excel) use ($servicios_of) {
                    $excel->sheet('Servicios', function($sheet) use ($servicios_of) {
                        //TOMAR LOS VALORES DEL FORM-DATA
						$sheet->loadView('facturacion.exportarlistadocorte')->with(['servicios'=>$servicios_of]);

                        $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(11);

                        $sheet->getStyle("D4:F4")->getFont()->setSize(13.5);
                        $sheet->getStyle("D5:F5")->getFont()->setSize(13.5);

                        $sheet->mergeCells('E4:J4');
                        $sheet->mergeCells('E5:J5');
                        $sheet->mergeCells('K4:L4');

                        $sheet->setFontFamily('Arial')
                            ->getStyle('A7:N7')->applyFromArray(array(
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
                            ->getStyle('B13:D13')->getActiveSheet()->getRowDimension('13')->setRowHeight(30);

                        for ($i=6; $i < 1000; $i++) {
                            $sheet->getStyle('A'.$i.':'.'M'.$i)->getAlignment()->setWrapText(true);
                        }

                        $styleArray = array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        );

                        $sheet->getStyle('E4:J4')->applyFromArray($styleArray);
                        $sheet->getStyle('E5:J5')->applyFromArray($styleArray);
                        $sheet->getStyle('K4:L4')->applyFromArray($styleArray);
                    });

                })->download('xls');
            }else{
					return Redirect::to('facturacion/autorizacionservicios');
			}
        }
	}

	public function getVerdetalleotros($id){
		if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->facturacion->ordenes_de_facturacion->ver;
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

			$ordenes_fac = DB::table('otros_servicios_detalles')
				->leftJoin('ordenes_facturacion', 'otros_servicios_detalles.id_factura', '=', 'ordenes_facturacion.numero_factura')
                ->leftJoin('centrosdecosto', 'otros_servicios_detalles.centrodecosto', '=', 'centrosdecosto.id')
                ->leftJoin('subcentrosdecosto', 'otros_servicios_detalles.subcentrodecosto', '=', 'subcentrosdecosto.id')
                ->select('otros_servicios_detalles.id','otros_servicios_detalles.consecutivo','otros_servicios_detalles.fecha_orden','ordenes_facturacion.numero_factura',
                    'otros_servicios_detalles.ciudad','otros_servicios_detalles.valor','otros_servicios_detalles.id_factura','otros_servicios_detalles.total_costo','otros_servicios_detalles.total_utilidad','ordenes_facturacion.fecha_ingreso', 'ordenes_facturacion.modo_ingreso',
                    'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro')
                ->where('otros_servicios_detalles.id',$id)
                ->first();

			$otros_servicios_detalles = DB::table('otros_servicios_detalles')
				->where('id',$id)
				->first();

			$otros_servicios = DB::table('otros_servicios')->where('id_servicios_detalles',$otros_servicios_detalles->id)->get();
			$terceros = DB::table('terceros')->get();

			return View::make('facturacion.detalle_facturacion_otros_servicios')
				->with([
					'ordenes_facturacion'=>$ordenes_fac,
					'otros_servicios_detalles'=>$otros_servicios_detalles,
					'otros_servicios'=>$otros_servicios,
					'terceros'=>$terceros,
					'permisos'=>$permisos
				]);
		}

	}

	public function postAutorizarotros(){
		$id_otros_ser = Input::get('id_otros_serv');

		if (Request::ajax()){

			$otros_serviciosd = Otrosserviciosdetalle::find($id_otros_ser);
			$otros_serviciosd->autorizado = 1;
			if($otros_serviciosd->save()){
				return Response::json(['respuesta'=>true]);
			}else{
				return Response::json(['respuesta'=>false]);
			}
		}else{
			return Response::json(['respuesta'=>'relogin']);
		}

	}

	public function postAnularotros(){

		$id_otros_ser = Input::get('id_otros_serv');

		if (Request::ajax()){

			$otros_serviciosD = Otrosserviciosdetalle::find($id_otros_ser);
			$otros_serviciosD->anulado = 1;
			if($otros_serviciosD->save()){
				return Response::json(['respuesta'=>true]);
			}else{
				return Response::json(['respuesta'=>false]);
			}
		}else{
			return Response::json(['respuesta'=>'relogin']);
		}

	}

	public function postFacturacionotroservicios(){
		$id_otros_ser = Input::get('id');

		if (Request::ajax()){
			$otros_serviciosD = Otrosserviciosdetalle::find($id_otros_ser);

		//ULTIMA ID DE FACTURA PARA SACAR NUMERO CONSECUTIVO
			$ultimo_id = DB::table('ordenes_facturacion')
				->select('id','numero_factura')->orderBy('id','desc')->first();

			//NUEVA FACTURA PARA TIQUETES
			$orden_facturacion = new Ordenfactura;
			$orden_facturacion->centrodecosto_id = $otros_serviciosD->centrodecosto;
			$orden_facturacion->subcentrodecosto_id = $otros_serviciosD->subcentrodecosto;
			$orden_facturacion->ciudad = $otros_serviciosD->ciudad;
			$orden_facturacion->fecha_expedicion = date('Y-m-d H:i:s');
			$orden_facturacion->fecha_inicial = $otros_serviciosD->fecha_orden;
			$orden_facturacion->fecha_final = $otros_serviciosD->fecha_orden;
			$orden_facturacion->tipo_orden = 2;
			$orden_facturacion->total_facturado_cliente = $otros_serviciosD->valor;
			$orden_facturacion->fecha_factura = date('Y-m-d');
			$orden_facturacion->facturado = 1;

			$orden_facturacion->total_ingresos_propios = $otros_serviciosD->total_ingresos_propios;
			$orden_facturacion->total_costo = $otros_serviciosD->total_costo;
			$orden_facturacion->total_utilidad = $otros_serviciosD->total_utilidad;
			$orden_facturacion->numero_factura = intval($ultimo_id->numero_factura)+1;
			$orden_facturacion->creado_por = Sentry::getUser()->id;

			if ($orden_facturacion->save()) {

				//ASIGNACION DE NUMERO CONSECUTIVO
				$id = $orden_facturacion->id;
				$orden = Ordenfactura::find($id);

				if (strlen(intval($id))===1) {
					$orden->consecutivo = 'AT000' . $id;
					$orden->save();
				} elseif (strlen(intval($id))===2) {
					$orden->consecutivo = 'AT00' . $id;
					$orden->save();
				} elseif (strlen(intval($id))===3) {
					$orden->consecutivo = 'AT0' . $id;
					$orden->save();
				} elseif (strlen(intval($id))===4) {
					$orden->consecutivo = 'AT' . $id;
					$orden->save();
				}

				//SE ASIGNA EL NUMERO DE FACTURA A ESTOS SERVICIOS
				$otros_serviciosD->id_factura = $id;
				$otros_serviciosD->save();

				return Response::json(['respuesta'=>true, 'consecutivo'=>$orden->consecutivo]);
			}

		}else{
			return Response::json(['respuesta'=>'relogin']);
		}
	}

    public function postHabilitarservicio(){
        if (!Sentry::check()){
            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
        }else{

            $id = Input::get('id');
            $query = Facturacion::where('servicio_id',$id)->first();
            $query->autorizacion = 1;
            if($query->save()){
                return Response::json([
                    'respuesta' => true
                ]);
            }

        }
    }

    public function getModificarpago($id){

        if (!Sentry::check()){
            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
        }else{

            $pago_proveedores = DB::table('pago_proveedores')
                ->select('pago_proveedores.id','users.first_name','users.last_name','pago_proveedores.consecutivo', 'pago_proveedores.anulado', 'pago_proveedores.fecha_expedicion',
                    'pago_proveedores.numero_factura','pago_proveedores.fecha_inicial','pago_proveedores.fecha_final','pago_proveedores.fecha_pago',
                    'proveedores.razonsocial as razonsocialp','pago_proveedores.valor','centrosdecosto.razonsocial','subcentrosdecosto.nombresubcentro')
                ->leftJoin('proveedores','pago_proveedores.proveedor','=','proveedores.id')
                ->leftJoin('centrosdecosto','pago_proveedores.centrodecosto','=','centrosdecosto.id')
                ->leftJoin('subcentrosdecosto','pago_proveedores.subcentrodecosto','=','subcentrosdecosto.id')
                ->leftJoin('users','pago_proveedores.creado_por','=','users.id')
                ->where('pago_proveedores.id_pago',$id)
                ->where('pago_proveedores.anulado', null)
                ->get();

            return View::make('soporte.contabilidad.modificar')
                ->with([
                    'pago_proveedores'=>$pago_proveedores,
                    'id'=>$id
                ]);

        }
    }

    public function postGuardarmodificacion(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if (Request::ajax()) {

                    $id = Input::get('id');

                    $pago = Pago::find($id);
                    $valor_retefuente = intval($pago->descuento_retefuente);
                    $valor_descuentos = Input::get('otros_descuentos');
                    $valor_nuevo = $pago->total_pagado - ($valor_retefuente+$valor_descuentos);
                    
                    
                    //$pago->observaciones = Input::get('observaciones');
                    //$pago->usuario = Sentry::getUser()->id;

                    //SI NO VIENE EN CERO LOS DESCUENTOS
                    if (intval($valor_descuentos)!=0 and $valor_descuentos!=null) {

                        if(intval($valor_descuentos)===intval($pago->otros_descuentos)){
                            return Response::json([
                                'igual'=>true
                            ]);
                        }else{
                            
                            $pago->detalles_descuentos = Input::get('arrayDescuentos');
                            $pago->otros_descuentos = Input::get('otros_descuentos');
                            $pago->total_neto = $valor_nuevo;

                            if($pago->save()){
                                return Response::json([
                                    'respuesta'=>true,
                                    'validar'=>$pago,
                                ]);
                            }else{
                                return Response::json([
                                    'errors'=>true
                                ]);
                            }
                        }   
                        //SI VIENE  EN CERO LOS DESCUENTOS                     
                    }else{

                        if(intval($valor_descuentos)===intval($pago->otros_descuentos)){

                            return Response::json([
                                'vacio'=>true,
                                'valor_descuentos'=>$valor_descuentos,
                                'valor_descuentos_pago'=>$pago->otros_descuentos
                            ]);

                        }else{

                            $pago->detalles_descuentos = Input::get('arrayDescuentos');
                            $pago->otros_descuentos = Input::get('otros_descuentos');
                            $pago->total_neto = $valor_nuevo;

                            if($pago->save()){
                                return Response::json([
                                    'respuesta'=>true,
                                    'valor_descuentos'=>$valor_descuentos,
                                    'valor_descuentos_pago'=>$pago->otros_descuentos
                                    //'validar'=>$pago,
                                ]);
                            }else{
                                return Response::json([
                                    'errors'=>true
                                ]);
                            }

                        }                        
                    }
            }
        }
    }

    public function postEfectuardescuento(){
        
        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if (Request::ajax()) {

                $id = Input::get('id');
                $id_prestamo = Input::get('id_prestamo');

                $pago = Pago::find($id);

                $prestamo = DB::table('prestamos')
                ->where('proveedor_id', $pago->proveedor)
                ->where('estado_prestamo',0)
                ->update([
                    'estado_prestamo' => 1,
                    'id_pago' => $id
                ]);
                $presta = Prestamo::find($id_prestamo);
                $resta = $pago->total_neto - $presta->valor_prestado;

                $pago = DB::table('pagos')
                ->where('id', $id)
                ->update([
                    'total_neto' => $resta,
                    'descuento_prestamo' => $presta->valor_prestado
                ]);

                if($prestamo and $pago){
                    return Response::json([
                        'respuesta' => true,
                        'sql' => $prestamo
                    ]);
                }else{
                    return Response::json([
                        'respuesta' => false,
                        'sql' => $prestamo
                    ]);
                }
                //}
                //$valor_retefuente = intval($pago->descuento_retefuente);
                //$valor_descuentos = Input::get('otros_descuentos');
                //$valor_nuevo = $pago->total_pagado - ($valor_retefuente+$valor_descuentos);
            }
        }
    }

    //PRESTAMOS A PROVEEDORES
    public function getPrestamosproveedores(){
        if (Sentry::check()) {

          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->contabilidad->factura_proveedores->ver;

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
            $proveedores = DB::table('proveedores')->whereNull('inactivo')->get();
            return View::make('facturacion.prestamos')
            ->with([
                'proveedores'=>$proveedores,                
                'permisos'=>$permisos,
                'o'=>$o=1
            ]);
        }
    }

    //LISTADO DE PRESTAMOS A PROVEEDORES
    public function getListadoprestamosproveedores(){
        if (Sentry::check()) {

          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->contabilidad->factura_proveedores->ver;

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

            $proveedores = DB::table('proveedores')->whereNull('inactivo')->get();
            $date = date('y-m-d');
  //          $prestamos = DB::table('prestamos')
            //->where('fecha',$date)
            $query = "select prestamos.id, prestamos.proveedor_id, prestamos.fecha, prestamos.valor_prestado, prestamos.razon, prestamos.estado_prestamo, proveedores.razonsocial, users.first_name, users.last_name from prestamos left join proveedores on proveedores.id = prestamos.proveedor_id left join users on users.id = prestamos.creado_por where prestamos.estado_prestamo = 0 ";
            $prestamos = DB::select($query);
            /*
            ->select('prestamos.id', 'prestamos.proveedor_id,'' prestamos.fecha, prestamos.valor_prestado, prestamos.razon, prestamos.estado_prestamo, proveedores.razonsocial')
            ->leftJoin('proveedores', 'proveedores.id', '=', 'prestamos.proveedor_id')
            ->leftJoin('users', 'users.id', '=', 'prestamos.creado_por')
            ->where('estado_prestamo',0)
            ->get();
*/
            return View::make('facturacion.listado_prestamos')
            ->with([
                'prestamos'=>$prestamos,
                'proveedores'=>$proveedores,                
                'permisos'=>$permisos,
                'o'=>$o=1
            ]);
        }
    }

    public function postConsultaproveedor(){

        $fecha_inicial = Input::get('fecha_inicial');
        $fecha_final = Input::get('fecha_final');
        $proveedor = intval(Input::get('proveedor'));
        $estado = intval(Input::get('estado'));


        $query = "select prestamos.id, prestamos.proveedor_id, prestamos.valor_prestado, prestamos.fecha, prestamos.razon, prestamos.estado_prestamo, users.first_name, users.last_name, proveedores.razonsocial from prestamos ".
        "left join proveedores on proveedores.id = prestamos.proveedor_id ".
        "left join users on users.id = prestamos.creado_por ".
        "where prestamos.fecha BETWEEN '".$fecha_inicial."' and '".$fecha_final."' ";
        
        if($estado===1){
            $query .= "and prestamos.estado_prestamo = 0 ";
        }else if($estado===2){            
            $query .="and prestamos.estado_prestamo = 1 ";
        }else if($estado===3){
            $query .= "and prestamos.estado_prestamo = 2 ";
        }

        if ($proveedor===0) {
            $consulta = DB::select($query);
        }else if($proveedor!=0){
            $query .= "and proveedor_id = ".$proveedor." ";
            $consulta = DB::select($query);
        }

        if($consulta!=null){
            return Response::json([
                'respuesta' => true,
                'proveedor' => $proveedor,
                'prestamos' => $consulta
            ]);
        }else{
            return Response::json([
                'respuesta' => false
            ]);
        }
    }

    public function postConsultaproveedorselect(){
        
        $proveedor = intval(Input::get('id'));


        $query = "select prestamos.id, prestamos.proveedor_id, prestamos.valor_prestado, prestamos.fecha, prestamos.razon, prestamos.estado_prestamo, proveedores.razonsocial from prestamos ".
        "left join proveedores on proveedores.id = prestamos.proveedor_id ".
        "where prestamos.proveedor_id = '".$proveedor."' and estado_prestamo = 0 ";
        
        $consulta = DB::select($query);
        
        if($consulta!=null){
            return Response::json([
                'respuesta' => true,
                'prestamos' => $consulta
            ]);
        }else{
            return Response::json([
                'respuesta' => false
            ]);
        }
    }

    public function getDetalleprestamo($id){

        if (!Sentry::check()){
            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
        }else{

            $prestamos = DB::table('prestamos')
                ->select('prestamos.id','users.first_name','users.last_name','prestamos.valor_prestado', 'prestamos.fecha', 'prestamos.razon', 'prestamos.detalles', 'prestamos.id_pago',
                    'prestamos.estado_prestamo', 'prestamos.detalles_valores',
                    'proveedores.razonsocial as razonsocial', 'pagos.fecha_pago')
                ->leftJoin('proveedores','prestamos.proveedor_id','=','proveedores.id')
                ->leftJoin('pagos','prestamos.id_pago','=','pagos.id')                
                ->leftJoin('users','prestamos.creado_por','=','users.id')
                ->where('prestamos.id',$id)
                ->first();

            return View::make('facturacion.detalle_prestamo')
                ->with([
                    'prestamo'=>$prestamos,
                    'id'=>$id
                ]);

        }
    }

    public function postGuardarprestamo(){

        $validaciones = [          
          'proveedor_id'=>'required|numeric',
          'fecha'=>'required',                    
          'razon'=>'required',                     
          'valor'=>'required|numeric',
        ];

        $mensajes = [
          'proveedor_id.required'=>'Debe selerccionar un PROVEEDOR',
          'proveedor_id.numeric'=>'Debe selerccionar un PROVEEDOR',
          'fecha.required'=>'El campo FECHA es requerido',          
          'razon.required'=>'El campo CONCEPTO es requerido',
          'valor.required'=>'El campo VALOR es requerido',
          'valor.numeric'=>'El campo VALOR debe ser numerico',          
        ];
      
          $validador = Validator::make(Input::all(), $validaciones,$mensajes);

          if ($validador->fails())
          {
            return Response::json([
              'respuesta'=>false,
              'errores'=>$validador->errors()->getMessages()
            ]);

          }else{

            $valor = Input::get('valor');
            $fecha = Input::get('fecha');
            $proveedor_id = Input::get('proveedor_id');
            $razon = Input::get('razon');

            $consulta = DB::table('prestamos')
            ->where('fecha',$fecha)
            ->where('proveedor_id',$proveedor_id)
            ->first();

            if($consulta!=null){
                return Response::json([
                    'respuesta' => 'existe'
                ]);
            }else{

                $array = [
                    'valor' => $valor,
                    'concepto' => strtoupper($razon),
                    'usuario'=> Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
                    'timestamp' => date('Y-m-d H:i:s')
                ];

                $new = new Prestamo();
                $new->valor_prestado = $valor;
                $new->fecha = $fecha;
                $new->estado_prestamo = 0;
                $new->detalles_valores = json_encode([$array]);
                $new->proveedor_id = $proveedor_id;
                //$new->razon = strtoupper($razon);
                $new->creado_por = Sentry::getUser()->id;
                
                if($new->save()){
                    return Response::json([
                        'respuesta' => true
                    ]);
                }

            }            
        }
    }

    public function postGuardarprestamo2(){

        $validaciones = [          
          //'prestamo_id'=>'required|numeric',
          'fecha'=>'required',                    
          'razon'=>'required',                     
          'valor'=>'required|numeric',
        ];

        $mensajes = [
          //'prestamo_id.required'=>'Debe selerccionar un PROVEEDOR',
          //'proveedor_id.numeric'=>'Debe selerccionar un PROVEEDOR',
          'fecha.required'=>'El campo FECHA es requerido',          
          'razon.required'=>'El campo CONCEPTO es requerido',
          'valor.required'=>'El campo VALOR es requerido',
          'valor.numeric'=>'El campo VALOR debe ser numerico',          
        ];
      
          $validador = Validator::make(Input::all(), $validaciones,$mensajes);

          if ($validador->fails())
          {
            return Response::json([
              'respuesta'=>false,
              'errores'=>$validador->errors()->getMessages()
            ]);

          }else{

            $valor = Input::get('valor');
            $fecha = Input::get('fecha');
            $prestamo_id = Input::get('prestamo_id');
            $razon = Input::get('razon');

            $query = Prestamo::find($prestamo_id);
            
            if($query!=null){

                //Objeto array json
                $objArray = null;

                //Array a insertar en json
                $array = [
                    'valor' => $valor,
                    'concepto' => strtoupper($razon),
                    'usuario'=> Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
                    'timestamp' => date('Y-m-d H:i:s')
                ];

                $query->valor_prestado = $query->valor_prestado+$valor;
                  
                if($query->detalles_valores == null){
                  $query->detalles_valores = json_encode([$array]);
                }else{
                  $objArray = json_decode($query->detalles_valores);
                  array_push($objArray, $array);
                  $query->detalles_valores = json_encode($objArray);        
                }  

                if($query->save()){

                    return Response::json([
                      'respuesta' => true,
                      'query' => $query
                    ]);

                } 

            }else{

                return Response::json([
                    'respuesta' => true
                ]);

            }
            
        }
    }

  public function getExportarconstancia($id){

      if (!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else{

          //Tiempo maximo de ejecucion del script 300 segundos.
          ini_set('max_execution_time', 300);

          //Traer informacion del servicio
          $servicio = Servicio::where('id', $id)->first();

          //Ubicacion de la firma
          $filepath = "biblioteca_imagenes/firmas_servicios/".'firma_'.$servicio->id.'.png';

          /*
          //Si la imagen no ha sido recortada, usar el metodo crop para recortarla
          if ($servicio->imagen_recortada==null) {

            //Si el archivo existe recortarla
            if (file_exists($filepath)) {

              //Obtener imagen con la clase Image y metodo make()
              $img = Image::make($filepath);

              //Recortar la imagen, eliminar los espacios en blanco, eliminar el color negro que se genere a la derecha y rotarla -90 grados.
              $img->trim()->crop(500, 500, 0)->rotate(-90)->trim('black', ['left'])->save($filepath);

              //Guardar en la base de datos el campo como 1 para especificar que la imagen fue recortada y no utilizar el metodo de nuevo.
              $servicio->imagen_recortada = 1;

              //Guardar
              $servicio->save();

            }

          }*/

          $html = View::make('servicios.plantilla_constancia_vieja')->with([
            'servicio' => $servicio,
            'filepath' => $filepath
          ])->render();

          $html = preg_replace('/>\s+</', '><', $html);

          return PDF::load($html, 'A4', 'portrait')->show('Servicio: #'. $servicio->id);

      }

  }

}
