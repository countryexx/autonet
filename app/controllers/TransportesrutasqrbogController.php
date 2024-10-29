<?php
use Illuminate\Database\Eloquent\Model;

class TransportesrutasqrbogController extends BaseController{

    public function getIndex(){

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

            $programacion_rutaqr = DB::table('qr_rutas')->get();
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
                //->where('servicios.ruta_qr',1)
                ->whereIn('users.localidad',[2,3])
                ->whereNull('servicios.pendiente_autori_eliminacion')
				        ->whereNotNull('servicios.ruta')
                ->where('fecha_servicio',date('Y-m-d'))
                ->orderBy('hora_servicio')
                ->get();

            $proveedores = Proveedor::Afiliadosinternos()
            ->orderBy('razonsocial')
            ->where('tipo_servicio', 'TRANSPORTE TERRESTRE')
            ->whereNull('inactivo_total')
            ->whereNull('inactivo')
            ->get();

            $centrosdecosto = Centrodecosto::Internos()->orderBy('razonsocial')->get();

            $subcentros = DB::table('subcentrosdecosto')->orderBy('nombresubcentro')->get();
            $departamentos = DB::table('departamento')->get();
            $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
            $rutas = DB::table('rutas')->get();
            $usuarios = DB::table('users')->where('coordinador',1)->where('activated',1)->get();
            $pass = DB::table('qr_rutas')->where('estado',1)->get();
			$cotizaciones = DB::table('cotizaciones')->where('estado',1)->orderBy('created_at', 'desc')->take(10)->get();

            return View::make('servicios.rutasqrbog')
                ->with('cotizaciones',$cotizaciones)
				        ->with('servicios',$servicios)
                ->with('centrosdecosto',$centrosdecosto)
                ->with('departamentos',$departamentos)
                ->with('ciudades',$ciudades)
                ->with('proveedores',$proveedores)
                ->with('rutas',$rutas)
                ->with('permisos',$permisos)
                ->with('usuarios',$usuarios)
                ->with('pass', $pass)
                ->with('programacion_rutaqr',$programacion_rutaqr)
                ->with('o',$o=1);
        }
    }

    public function postBuscar(){

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

                $consulta = "select servicios.id, servicios.id as servicioid, servicios.fecha_orden, servicios.fecha_servicio, servicios.solicitado_por, ".
                    "servicios.resaltar, servicios.pago_directo, servicios.fecha_solicitud, servicios.ciudad, servicios.recoger_en, servicios.ruta, ".
                    "servicios.dejar_en, servicios.detalle_recorrido, servicios.pasajeros, servicios.pasajeros_ruta, servicios.finalizado, ".
                    "servicios.pendiente_autori_eliminacion, servicios.ruta_nombre_id, ".
                    "servicios.hora_servicio, servicios.origen, servicios.destino, servicios.pago_directo, servicios.rechazar_eliminacion, ".
                    "servicios.estado_servicio_app, servicios.recorrido_gps, ".
                    "servicios.aerolinea, servicios.vuelo, servicios.hora_salida, servicios.hora_llegada, ".
                    "servicios.cancelado, pago_proveedores.consecutivo as pconsecutivo, pagos.autorizado, ".
                    "servicios_edicion_pivote.id as servicios_id_pivote, ordenes_facturacion.id as idordenfactura, ".
                    "reportes_pivote.id as reportes_id_pivote, pago_proveedores.id as pproveedorid, ".
                    "reconfirmacion.ejecutado, reconfirmacion.numero_reconfirmaciones, ".
                    "facturacion.revisado, facturacion.liquidado, facturacion.facturado, facturacion.factura_id, ".
                    "facturacion.liquidacion_id, facturacion.liquidado_autorizado, ".
                    "novedades_reconfirmacion.seleccion_opcion, nombre_ruta.nombre, ".
                    "centrosdecosto.razonsocial, encuesta.pregunta_1, encuesta.pregunta_2, encuesta.pregunta_3, ".
                    "encuesta.pregunta_4, encuesta.pregunta_5, encuesta.pregunta_6, encuesta.pregunta_7, encuesta.pregunta_8, encuesta.pregunta_9, encuesta.pregunta_10, ".
                    "ordenes_facturacion.numero_factura, ordenes_facturacion.consecutivo, ordenes_facturacion.nomostrar, ".
                    "subcentrosdecosto.nombresubcentro, ".
                    "users.first_name, users.last_name, ".
                    "rutas.nombre_ruta, rutas.codigo_ruta, ".
                    "proveedores.razonsocial as razonproveedor, ".
                    "conductores.nombre_completo, conductores.celular, conductores.telefono, conductores.id, ".
                    "vehiculos.placa, vehiculos.clase,".
                    "vehiculos.marca, vehiculos.modelo, ".
										"servicios_autorizados_pdf.documento_pdf1, servicios_autorizados_pdf.documento_pdf2 ".
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
                    "left join nombre_ruta on servicios.ruta_nombre_id = nombre_ruta.id ".

                    "where servicios.fecha_servicio between '".$fecha_inicial."' AND '".$fecha_final."' and servicios.ruta is not null and users.localidad in (2,3) ";

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

                $servicios = DB::select(DB::raw($consulta." and servicios.pendiente_autori_eliminacion is null order by hora_servicio asc"));

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

    public function postMostrarsubcentros(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

        if(Request::ajax()){

            $subcentros = Subcentro::nobloqueado()->where('centrosdecosto_id',Input::get('centrosdecosto_id'))
            ->orderBy('nombresubcentro')->get();

            $nombre_rutas = NombreRuta::where('centrodecosto_id', Input::get('centrosdecosto_id'))->get();

            if($subcentros){

                return Response::json([
                    'mensaje' => true,
                    'respuesta' => $subcentros,
                    'nombre_rutas' => $nombre_rutas
                ]);

            }else{

                return Response::json([
                    'mensaje' => false,
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
                    'centrodecosto_id' => 'required|numeric',
                    'subcentrodecosto_id' => 'required|numeric',
                    'solicitado_por' => 'required',
                    'email_solicitante '=> 'email',
                    'departamento' => 'required|select',
                    'ciudad' => 'required|select',
                    'ruta_id' => 'required|numeric',
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
                    'firma' => 'required|numeric'
                ];

                //Validaciones
                $mensajes = [
                    'centrodecosto_id.numeric'=>'Debe seleccionar un centro de costo',
                    'subcentrodecosto_id.numeric'=>'Debe seleccionar un subcentro de costo',
                    'departamento.select'=>'Debe seleccionar un departamento',
                    'ciudad.select'=>'Debe seleccionar una ciudad',
                    'ruta_id.required'=>'Debe seleccionar una ruta',
                    'ruta_id.numeric'=>'Debe seleccionar una ruta',
                    'proveedor_id.numeric'=>'Debe seleccionar un proveedor',
                    'resaltar.numeric'=>'Debe seleccionar la opcion resaltar',
                    'pago_directo.numeric'=>'Debe seleccionar la opcion pago_directo',
                    'firma.numeric' => 'Debe seleccionar la opcion firma'
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

                    //Si ordenes de facturacion es diferente de null quiere decir que hay un registro por lo tanto no se puede editar el servicio
                    if (Sentry::getUser()->id_rol==1) {

                      //Asignar variables al resultado de la busqueda de servicios
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
                      $ruta_nombre = $servicios->ruta_nombre_id;
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
                      $servicios->ruta_nombre_id = Input::get('ruta_nombre_id');
                      $servicios->recoger_en = Input::get('recoger_en');
                      $servicios->dejar_en = Input::get('dejar_en');
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

                      if ($servicios->save()) {

                          if ($centrodecosto!=$servicios->centrodecosto_id) {
                              $centro1 = DB::table('centrosdecosto')->where('id',$servicios->centrodecosto_id)->first();
                              $centro2 = DB::table('centrosdecosto')->where('id',$centrodecosto)->first();

                              $cambios = $cambios.'Se cambio el centro de costo de <b>'.$centro2->razonsocial.'</b> a <b>'.$centro1->razonsocial.'</b><br>';
                          }
                          if ($subcentrodecosto!=$servicios->subcentrodecosto_id) {
                              $subcentro1 = DB::table('subcentrosdecosto')->where('id',$servicios->subcentrodecosto_id)->first();
                              $subcentro2 = DB::table('subcentrosdecosto')->where('id',$subcentrodecosto)->first();
                              $cambios = $cambios.'Se cambio el subcentro de costo de <b>'.$subcentro2->nombresubcentro.'</b> a <b>'.$subcentro1->nombresubcentro.'</b><br>';
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

                          if ($ruta!=$servicios->ruta_id) {
                              $rutas1 = DB::table('rutas')->where('id',$servicios->ruta_id)->first();
                              $rutas2 = DB::table('rutas')->where('id',$ruta)->first();
                              $cambios = $cambios.'Se cambio la ruta del servicio de <b>'.$rutas2->nombre_ruta.'</b> a <b>'.$rutas1->nombre_ruta.'</b><br>';
                          }

                          //Si el dato anterior es null
                          if ($ruta_nombre==0 or $ruta_nombre==null) {

                            if (!$servicios->ruta_nombre_id==0) {

                              //Buscar el dato actual y crear nuevo registro
                              $ruta_nombre_1 = NombreRuta::find($servicios->ruta_nombre_id);
                              $cambios = $cambios.'Se asigno el nombre de ruta <b>'.$ruta_nombre_1->nombre.'</b><br>';

                            }

                          }else {

                            //Si el dato anterior no es null entonces
                            if ($ruta_nombre != $servicios->ruta_nombre_id) {

                                $rutas_nombre_1 = NombreRuta::find($servicios->ruta_nombre_id);
                                $rutas_nombre_2 = NombreRuta::find($ruta_nombre);

                                $cambios = $cambios.'Se cambio el nombre de la ruta del servicio de <b>'.$rutas_nombre_2->nombre.'</b> a <b>'.$rutas_nombre_1->nombre.'</b><br>';
                            }

                          }

                          if ($recoger_en!=$servicios->recoger_en) {
                              $cambios = $cambios.'Se cambio el campo recoger en de <b>'.$recoger_en.'</b> a <b>'.$servicios->recoger_en.'</b><br>';
                          }
                          if ($dejar_en!=$servicios->dejar_en) {
                              $cambios = $cambios.'Se cambio el campo dejar en de <b>'.$dejar_en.'</b> a <b>'.$servicios->dejar_en.'</b><br>';
                          }
                          if ($detalle_recorrido!=$servicios->detalle_recorrido) {
                              $cambios = $cambios.'Se cambio el campo detalle del recorrido de <b>'.$detalle_recorrido.'</b> a <b>'.$servicios->detalle_recorrido.'</b><br>';
                          }
                          if ($proveedor!=$servicios->proveedor_id) {
                              $proveedor1 = DB::table('proveedores')->where('id',$servicios->proveedor_id)->first();
                              $proveedor2 = DB::table('proveedores')->where('id',$proveedor)->first();
                              $cambios = $cambios.'Se cambio el proveedor de <b>'.$proveedor2->razonsocial.'</b> a <b>'.$proveedor1->razonsocial.'</b><br>';
                          }
                          if ($conductor!=$servicios->conductor_id) {
                              $conductor1 = DB::table('conductores')->where('id',$servicios->conductor_id)->first();
                              $conductor2 = DB::table('conductores')->where('id',$conductor)->first();
                              $cambios = $cambios.'Se cambio el conductor de <b>'.$conductor2->nombre_completo.'</b> a <b>'.$conductor1->nombre_completo.'</b><br>';
                          }
                          if ($vehiculo!=$servicios->vehiculo_id) {
                              $vehiculo1 = DB::table('vehiculos')->where('id',$servicios->vehiculo_id)->first();
                              $vehiculo2 = DB::table('vehiculos')->where('id',$vehiculo)->first();
                              $cambios = $cambios.'Se cambio el vehiculo de marca <b>'.$vehiculo2->marca.'</b> y placas <b>'.$vehiculo2->placa.'</b> a el vehiculo de marca <b>'.$vehiculo1->marca.'</b> y placas <b>'.$vehiculo1->placa.'</b><br>';
                          }
                          if ($fecha_servicio!=$servicios->fecha_servicio) {
                              $cambios = $cambios.'Se cambio la fecha del servicio de <b>'.$fecha_servicio.'</b> al <b>'.$servicios->fecha_servicio.'</b><br>';
                          }
                          if ($hora_servicio!=$servicios->hora_servicio) {
                              $cambios = $cambios.'Se cambio la hora del servicio de <b>'.$hora_servicio.'</b> al <b>'.$servicios->hora_servicio.'</b><br>';
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

                      if($ordenes_facturacion!=null){

                           return Response::json([
                             'respuesta' => 'rechazado',
                             'liquidacion' => $liquidacion,
                             'ordenes_facturacion' => $ordenes_facturacion
                           ]);

                      }else{

                        //Asignar variables al resultado de la busqueda de servicios
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
                        $ruta_nombre = $servicios->ruta_nombre_id;
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
                        $servicios->ruta_nombre_id = Input::get('ruta_nombre_id');
                        $servicios->recoger_en = Input::get('recoger_en');
                        $servicios->dejar_en = Input::get('dejar_en');
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

                        if ($servicios->save()) {

                            if ($centrodecosto!=$servicios->centrodecosto_id) {
                                $centro1 = DB::table('centrosdecosto')->where('id',$servicios->centrodecosto_id)->first();
                                $centro2 = DB::table('centrosdecosto')->where('id',$centrodecosto)->first();

                                $cambios = $cambios.'Se cambio el centro de costo de <b>'.$centro2->razonsocial.'</b> a <b>'.$centro1->razonsocial.'</b><br>';
                            }
                            if ($subcentrodecosto!=$servicios->subcentrodecosto_id) {
                                $subcentro1 = DB::table('subcentrosdecosto')->where('id',$servicios->subcentrodecosto_id)->first();
                                $subcentro2 = DB::table('subcentrosdecosto')->where('id',$subcentrodecosto)->first();
                                $cambios = $cambios.'Se cambio el subcentro de costo de <b>'.$subcentro2->nombresubcentro.'</b> a <b>'.$subcentro1->nombresubcentro.'</b><br>';
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

                            if ($ruta!=$servicios->ruta_id) {
                                $rutas1 = DB::table('rutas')->where('id',$servicios->ruta_id)->first();
                                $rutas2 = DB::table('rutas')->where('id',$ruta)->first();
                                $cambios = $cambios.'Se cambio la ruta del servicio de <b>'.$rutas2->nombre_ruta.'</b> a <b>'.$rutas1->nombre_ruta.'</b><br>';
                            }

                            //Si el dato anterior es null
                            if ($ruta_nombre==0 or $ruta_nombre==null) {

                              if (!$servicios->ruta_nombre_id==0) {

                                //Buscar el dato actual y crear nuevo registro
                                $ruta_nombre_1 = NombreRuta::find($servicios->ruta_nombre_id);
                                $cambios = $cambios.'Se asigno el nombre de ruta <b>'.$ruta_nombre_1->nombre.'</b><br>';

                              }

                            }else {

                              //Si el dato anterior no es null entonces
                              if ($ruta_nombre != $servicios->ruta_nombre_id) {

                                  $rutas_nombre_1 = NombreRuta::find($servicios->ruta_nombre_id);
                                  $rutas_nombre_2 = NombreRuta::find($ruta_nombre);

                                  $cambios = $cambios.'Se cambio el nombre de la ruta del servicio de <b>'.$rutas_nombre_2->nombre.'</b> a <b>'.$rutas_nombre_1->nombre.'</b><br>';
                              }

                            }

                            if ($recoger_en!=$servicios->recoger_en) {
                                $cambios = $cambios.'Se cambio el campo recoger en de <b>'.$recoger_en.'</b> a <b>'.$servicios->recoger_en.'</b><br>';
                            }
                            if ($dejar_en!=$servicios->dejar_en) {
                                $cambios = $cambios.'Se cambio el campo dejar en de <b>'.$dejar_en.'</b> a <b>'.$servicios->dejar_en.'</b><br>';
                            }
                            if ($detalle_recorrido!=$servicios->detalle_recorrido) {
                                $cambios = $cambios.'Se cambio el campo detalle del recorrido de <b>'.$detalle_recorrido.'</b> a <b>'.$servicios->detalle_recorrido.'</b><br>';
                            }
                            if ($proveedor!=$servicios->proveedor_id) {
                                $proveedor1 = DB::table('proveedores')->where('id',$servicios->proveedor_id)->first();
                                $proveedor2 = DB::table('proveedores')->where('id',$proveedor)->first();
                                $cambios = $cambios.'Se cambio el proveedor de <b>'.$proveedor2->razonsocial.'</b> a <b>'.$proveedor1->razonsocial.'</b><br>';
                            }
                            if ($conductor!=$servicios->conductor_id) {
                                $conductor1 = DB::table('conductores')->where('id',$servicios->conductor_id)->first();
                                $conductor2 = DB::table('conductores')->where('id',$conductor)->first();
                                $cambios = $cambios.'Se cambio el conductor de <b>'.$conductor2->nombre_completo.'</b> a <b>'.$conductor1->nombre_completo.'</b><br>';
                            }
                            if ($vehiculo!=$servicios->vehiculo_id) {
                                $vehiculo1 = DB::table('vehiculos')->where('id',$servicios->vehiculo_id)->first();
                                $vehiculo2 = DB::table('vehiculos')->where('id',$vehiculo)->first();
                                $cambios = $cambios.'Se cambio el vehiculo de marca <b>'.$vehiculo2->marca.'</b> y placas <b>'.$vehiculo2->placa.'</b> a el vehiculo de marca <b>'.$vehiculo1->marca.'</b> y placas <b>'.$vehiculo1->placa.'</b><br>';
                            }
                            if ($fecha_servicio!=$servicios->fecha_servicio) {
                                $cambios = $cambios.'Se cambio la fecha del servicio de <b>'.$fecha_servicio.'</b> al <b>'.$servicios->fecha_servicio.'</b><br>';
                            }
                            if ($hora_servicio!=$servicios->hora_servicio) {
                                $cambios = $cambios.'Se cambio la hora del servicio de <b>'.$hora_servicio.'</b> al <b>'.$servicios->hora_servicio.'</b><br>';
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

                                return Response::json([
                                    'respuesta'=>true,
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
        }
    }

    public function postMostrarproveedores(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

            if (Request::ajax()) {

                $proveedores = DB::select('select * from proveedores where inactivo is null and localidad = "bogota" order by razonsocial');

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

            $conductores = Conductor::bloqueado()->where('proveedores_id', Input::get('proveedores_id'))->get();
            $vehiculos = Vehiculo::bloqueadototal()->bloqueado()->where('proveedores_id', Input::get('proveedores_id'))->get();
            $recogeren = DB::table('recogeren_dejaren')->where('tipo',1)->orderBy('nombre_lugar')->get();
            $dejaren = DB::table('recogeren_dejaren')->where('tipo',2)->orderBy('nombre_lugar')->get();

            if($vehiculos!=null && $conductores!=null){
                return Response::json([
                    'mensaje' => true,
                    'conductores' => $conductores,
                    'vehiculos' => $vehiculos,
                    'recoger' => $recogeren,
                    'dejar' => $dejaren
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
                'respuesta'=>'relogin'
            ]);

        }else{

            if(Request::ajax()){

                $pasajeros = [];
                $pasajeros_todos='';
                $nombres_pasajeros='';
                $celulares_pasajeros='';

                $estado_email = Input::get('estado_email');

                //DATOS DE LOS PASAJEROS CONVERTIDOS A ARRAYS
                $nombre_pasajeros = explode(',', Input::get('nombres_pasajeros'));
                $celular_pasajeros = explode(',', Input::get('celular_pasajeros'));
                $nivel_pasajeros = explode(',', Input::get('nivel_pasajeros'));
                $email_pasajeros = explode(',', Input::get('email_pasajeros'));

                //CONCATENACION DE TODOS LOS DATOS
                for($i=0; $i<count($nombre_pasajeros); $i++){
                    $pasajeros[$i] = $nombre_pasajeros[$i].','.$celular_pasajeros[$i].','.$nivel_pasajeros[$i].','.$email_pasajeros[$i].'/';
                    $pasajeros_nombres[$i] = $nombre_pasajeros[$i].',';
                    $pasajeros_telefonos[$i] = $celular_pasajeros[$i].',';
                    $pasajeros_todos = $pasajeros_todos.$pasajeros[$i];
                    $nombres_pasajeros = $nombres_pasajeros.$pasajeros_nombres[$i];
                    $celulares_pasajeros = $celulares_pasajeros.$pasajeros_telefonos[$i];
                }

                //ARRAY DE LOS CAMPOS DE LOS SERVICIOS
                $resaltarArray = explode(',', Input::get('resaltarArray'));
                $pago_directoArray = explode(',',Input::get('pago_directoArray'));

                $rutaArray = explode(',', Input::get('rutaArray'));
                $ruta_nombreArray = explode(',', Input::get('ruta_nombreArray'));

                $detalleArray = explode(',', Input::get('detalleArray'));
                $recoger_enArray = explode(',', Input::get('recoger_enArray'));
                $dejar_enArray = explode(',', Input::get('dejar_enArray'));
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
                $cantidadArrays = count($rutaArray);

                for($i=0; $i<$cantidadArrays; $i++){

                    $consulta = "SELECT * FROM liquidacion_servicios WHERE '".$fechainicioArray[$i]."' BETWEEN fecha_inicial AND fecha_final and centrodecosto_id = '".Input::get('centrodecosto_id')."' and subcentrodecosto_id = '".Input::get('subcentrodecosto_id')."' and ciudad = '".Input::get('ciudad')."' and anulado is null and nomostrar is null";
                    $consulta_orden = "SELECT * FROM ordenes_facturacion WHERE '".$fechainicioArray[$i]."' BETWEEN fecha_inicial AND fecha_final and centrodecosto_id = '".Input::get('centrodecosto_id')."' and subcentrodecosto_id = '".Input::get('subcentrodecosto_id')."' and ciudad = '".Input::get('ciudad')."' and anulado is null and nomostrar is null and tipo_orden = 1";

                    $liquidacion = DB::select($consulta);
                    $ordenes_facturacion = DB::select($consulta_orden);

                    if($ordenes_facturacion!=null or $liquidacion!=null){
                        $contar_falso++;
                    }else{

                        $servicio = new Servicio();
                        $servicio->fecha_orden = Input::get('fecha_orden');
                        $servicio->centrodecosto_id = Input::get('centrodecosto_id');
                        $servicio->subcentrodecosto_id = Input::get('subcentrodecosto_id');
                        $servicio->pasajeros = $pasajeros_todos;
                        $servicio->cantidad = Input::get('cantidad');
                        $servicio->departamento = Input::get('departamento');
                        $servicio->ciudad = Input::get('ciudad');
                        $servicio->solicitado_por = Input::get('solicitado_por');
                        $servicio->fecha_solicitud = Input::get('fecha_solicitud');
                        $servicio->email_solicitante = Input::get('email_solicitante');

                        $servicio->firma = Input::get('firma');

                        $servicio->resaltar = $resaltarArray[$i];
                        $servicio->pago_directo = $pago_directoArray[$i];
                        $servicio->ruta_id = $rutaArray[$i];
                        $servicio->ruta_nombre_id = $ruta_nombreArray[$i];
                        $servicio->recoger_en = $recoger_enArray[$i];
                        $servicio->dejar_en = $dejar_enArray[$i];
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
                        $servicio->ruta = 1;
                        $servicio->localidad = 1;
                        $servicio->save();

                        $contar++;
												$servicio_id = $servicio_id . $servicio->id.",";

                      }
                }

                if($estado_email==='1') {

                  $pax = explode(',', $nombres_pasajeros);
                  $pax_tel = explode(',', $celulares_pasajeros);

                  $data = [
                      'ruta'=>$rutaArray,
                      'dejar_en'=>$dejar_enArray,
                      'pax'=>$pax,
                      'pax_tel'=>$pax_tel,
                      'fecha_solicitud'=>Input::get('fecha_solicitud'),
                      'fecha_servicio'=>$fechainicioArray,
                      'hora_inicio'=>$horainicioArray,
                      'recoger_en'=>$recoger_enArray,
                      'detalle'=>$detalleArray,
                      'nombres_conductor'=>$conductor_nombreArray,
                      'vehiculos_datos'=>$vehiculo_datosArray,
                      'gestionado_por'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
                      'empresa'=>Input::get('centrodecosto_nombre'),
                      'subcentrocosto'=>Input::get('subcentrocosto_nombre')
                  ];

                  $fromEmail = Input::get('email_solicitante');
                  $fromName = 'SISTEMAS - AOTOUR';

                  Mail::send('emails.plantilla_correo_servicios', $data, function($message) use ($fromEmail, $fromName){
                      $message->to($fromEmail, $fromName);
                      $message->from($fromEmail, $fromName);
                      $message->subject('Detalles de solicitud de traslado - Aotour');
                  });

                  return Response::json([
                      'mensaje'=>true,
                      'mail'=>true,
                      'mail_respuesta'=>'Correo enviado!',
                      'pasajeros'=>$pasajeros_todos,
                      'contar'=>$contar,
                      'contar_falso'=>$contar_falso,
			                'servicio_id' => $servicio_id
                  ]);

                }else{

                  return Response::json([
                      'mensaje' => true,
                      'pasajeros' => $pasajeros_todos,
                      'contar' => $contar,
                      'contar_falso' => $contar_falso,
				              'servicio_id' => $servicio_id
                  ]);

                }

            }
        }
    }

    public function postMostrardatosservicio(){

        $servicio = DB::table('servicios')
            ->where('id',Input::get('id'))
            ->first();

        $proveedor = DB::table('proveedores')
            ->where('id', $servicio->proveedor_id)
            ->first();

        $proveedores_eventuales = DB::table('proveedores')
            ->where('eventual',1)
            ->orderBy('razonsocial')
            ->get();

        $proveedores = DB::table('proveedores')
            ->whereNull('eventual')
            ->whereNull('inactivo')
            ->orderBy('razonsocial')
            ->get();

        if ($servicio!=null) {

            return Response::json([
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
                ->select('servicios.id','servicios.fecha_orden','servicios.fecha_servicio',
                         'servicios.solicitado_por','servicios.resaltar',
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

                #GUARDAR DATOS DEL SERVICIO
                if($servicio->save()):
                    return Response::json([
                        'respuesta'=>true
                    ]);
                else:
                    return Response::json([
                        'respuesta'=>false
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

    //INICIO RECONFIRMACION
    public function getReconfirmacion($id){

        if (Sentry::check()){
            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
            $ver = $permisos->transportes->reconfirmacion->ver;
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
                'servicios'=>$servicios,
                'reconfirmacion'=>$reconfirmacion,
                'novedades'=>$novedades,
                'reportes'=>$reportes,
                'i'=>0,
                'ediciones'=>$ediciones,
                'encuesta'=>$encuesta,
                'cambiosFacturacion'=>$cambiosFacturacion,
                'permisos'=>$permisos
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

        $servicios = DB::table('servicios')
        ->select('servicios.id','servicios.hora_servicio','servicios.fecha_servicio','servicios.subcentrodecosto_id','servicios.centrodecosto_id',
                 'reconfirmacion.reconfirmacion2hrs','reconfirmacion.reconfirmacion1hrs','reconfirmacion.reconfirmacion30min',
                 'reconfirmacion.reconfirmacion_horacita','reconfirmacion.reconfirmacion_ejecucion')
        ->leftJoin('reconfirmacion', 'servicios.id', '=', 'reconfirmacion.id_servicio')
        /*->whereBetween('fecha_servicio', array(date('Y-m-d'), date('Y-m-d',strtotime('+1 day'))))*/
        ->where('servicios.fecha_servicio',date('Y-m-d'))
        ->whereNull('servicios.pendiente_autori_eliminacion')
		    ->whereNotNull('servicios.ruta')
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
          $ver = $permisos->transportes->poreliminar->ver;
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
                ->where('pendiente_autori_eliminacion',1)
                ->orderBy('fecha_solicitud_eliminacion')
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

            return View::make('servicios.servicios_eliminar')
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
            $nombres_ruta = NombreRuta::where('centrodecosto_id', Input::get('centrodecosto_id'))->get();

            Excel::selectSheetsByIndex(0)->load(Input::file('excel'), function($reader) use ($nombres_ruta){

                $reader->skip(1);
                $result = $reader->noHeading()->get();

                $pasajerosArray = [];

                foreach($result as $value){
                    
                    $dir=DB::table('pasajeros')->where('pasajeros.cedula',$value[0])->pluck('direccion');
                    $tel=DB::table('pasajeros')->where('pasajeros.cedula',$value[0])->pluck('telefono');
                    $nom=DB::table('pasajeros')->where('pasajeros.cedula',$value[0])->pluck('nombres');
                    $ape=DB::table('pasajeros')->where('pasajeros.cedula',$value[0])->pluck('apellidos');
                    $area_1=DB::table('pasajeros')->where('pasajeros.cedula',$value[0])->pluck('area');
                    $email=DB::table('pasajeros')->where('pasajeros.cedula',$value[0])->pluck('correo');
                    $Subarea_1=DB::table('pasajeros')->where('pasajeros.cedula',$value[0])->pluck('sub_area');

                    $dataExcel = [
                       'id_employer' => strtoupper($value[0]), 
                       'nombres' =>$nom,
                       'apellidos' => $ape,
                       'cedula' => $value[3],  
                       'direccion' => $dir,
                       'barrio' => $tel,                      
                       'cargo' => $email,
                       'area' => $area_1,
                       'sub_area' => $Subarea_1,
                       'hora' => $value[2],
                       'ruta' => $value[4],
                       'conductor' => $value[5],
                       'placa' => $value[6],
                       'recoger' => $value[7],
                       'dejar' => $value[8],
                    ];
                    array_push($pasajerosArray, $dataExcel);
			            
                }
                echo json_encode([
                  'pasajeros' => $pasajerosArray,
                  'nombres_ruta' => $nombres_ruta
                ]);

            });

        }

    }

    public function postNuevarutaqr(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta' => 'relogin'
            ]);

        }else{

            //Arrays de datos para rutas recibidas
            $detalleArray = explode(',', Input::get('detalleArray'));


            $rutaIdArray = explode(',', Input::get('rutaIdArray'));      

            $conductorIdArray = explode(',', Input::get('conductorIdArray'));
            $vehiculoplacaArray = explode(',', Input::get('vehiculoplacaArray'));
            $recoger_enArray = explode(',', Input::get('recoger_enArray'));
            $dejar_enArray = explode(',', Input::get('dejar_enArray'));
            $horaArray = explode(',', Input::get('horaArray'));

            $nombre_comercial = Centrodecosto::find(Input::get('centrodecosto'))->razonsocial;

            $pasajeros = json_decode(Input::get('pasajeros'));

            for ($i=0; $i < count($rutaIdArray); $i++) {

                $servicio = new Servicio();
                $servicio->fecha_orden = date('Y-m-d');
                $servicio->centrodecosto_id = Input::get('centrodecosto');
                $servicio->subcentrodecosto_id = Input::get('subcentrodecosto');
                $servicio->pasajeros = $nombre_comercial.',,,/';

                $servicio->pasajeros_ruta = json_encode($pasajeros[$i]);

                $servicio->cantidad = count($pasajeros[$i]);

                $servicio->departamento = Input::get('departamento');
                $servicio->ciudad = Input::get('ciudad');

                $servicio->solicitado_por = Input::get('solicitado_por');
                $servicio->email_solicitante = Input::get('email_solicitante');

                $servicio->firma = Input::get('firma');

                $servicio->fecha_solicitud = Input::get('fecha_solicitud');

                $servicio->estado_email = 0;
                $servicio->ruta_id = Input::get('tipo_traslado');                
                $servicio->recoger_en = $recoger_enArray[$i];
                $servicio->dejar_en = $dejar_enArray[$i];
                $servicio->detalle_recorrido = strtoupper(strtolower($detalleArray[$i]));
                $proveedor = DB::table('conductores')->where('id',$conductorIdArray[$i])->pluck('proveedores_id');
                $servicio->proveedor_id = $proveedor;
                $servicio->conductor_id = $conductorIdArray[$i]; //$conductorArray[$i];
                $placa = DB::table('vehiculos')->where('placa',$vehiculoplacaArray[$i])->pluck('id');
                $servicio->vehiculo_id = $placa;
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
                $servicio->email_solicitante = Input::get('email_solicitante');
                $servicio->ruta_qr = 1;
                $servicio->aceptado_app = 0;
                $servicio->hora_programado_app = date('Y-m-d H:i:s');
                $rnid = DB::table('nombre_ruta')->where('nombre',($detalleArray[$i]))->pluck('id');
                $servicio->ruta_nombre_id = $rnid;
                $servicio->localidad = 1;
                $servicio->save();

                $number = rand(10000000, 99999999);
                $notifications = Servicio::enviarNotificaciones($conductorIdArray[$i], Input::get('fecha_servicio'), $horaArray[$i], $recoger_enArray[$i], $dejar_enArray[$i], $number, $servicio->id);
                $nombrerazonsocial = DB::table('centrosdecosto')->where('id',Input::get('centrodecosto'))->pluck('razonsocial');
                $nombrerazonsocialsub = DB::table('subcentrosdecosto')->where('id',Input::get('subcentrodecosto'))->pluck('nombresubcentro');
                //$placavehiculo = DB::table('vehiculos')->where('id',$vehiculoArray[$i])->pluck('placa');
                //$vehiculoplacaArray[$i]
                foreach ($pasajeros[$i] as $item){
              
                    $programacion_rutaqr = new Ruta_qr();
                    $programacion_rutaqr->id_usuario=$item->cedula;
                    $programacion_rutaqr->vehiculo=$placa;
                    $programacion_rutaqr->conductor_id=$conductorIdArray[$i];
                    $programacion_rutaqr->centrodecosto_id=Input::get('centrodecosto');
                    $programacion_rutaqr->subcentrodecosto_id=Input::get('subcentrodecosto');
                    $programacion_rutaqr->fecha= Input::get('fecha_servicio');
                    $programacion_rutaqr->hora=$horaArray[$i];
                    $programacion_rutaqr->fecha=Input::get('fecha_servicio');
                    $programacion_rutaqr->id_rutaqr=$rnid;//$rutaIdArray[$i];
                    $programacion_rutaqr->save();      
                    //$ruta = DB::table('nombre_ruta')->where('id',$rutaIdArray[$i])->pluck('nombre');
                  /*  $data = [          
                      'fecha' => Input::get('fecha_servicio'),
                      'hora'=> $horaArray[$i],
                      'ruta'=> $detalleArray[$i],

                    ];

                    $pass=$item->cargo;
                    
                    Mail::send('emails.correo_rutaqr', $data, function($message) use ($pass){

                      $message->from('aotourdeveloper@gmail.com', 'Información de Ruta');
                      $message->to($pass)->subject('Info de Ruta');

                    });  
                    */
                    $claveapi = "ac7945800d4558ddf707";
                    $Destino = $item->barrio; 
                    $Mensaje = "AOTOUR le informa sr(a) ".$item->nombres. " ".$item->apellidos." que tiene la ruta ".$detalleArray[$i]." en la ciudad de ".Input::get('ciudad')." programada para el día ".Input::get('fecha_servicio')." a las ".$horaArray[$i]." de la empresa ".$nombrerazonsocial." de la sede ".$nombrerazonsocialsub.", el vehiculo asignado es el de placas ".$vehiculoplacaArray[$i].".";
                        
                    $usuario = 16; //CODIGO DE USUARIO
                    // Escoja el tipo a enviar dato
                    $Tipo = "SMS";
                    $ch = curl_init(); 
                    curl_setopt($ch, CURLOPT_URL, 'https://conectbox.com/index.php/APIsms/api/EnviarSms'); 
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, 'claveapi='.$claveapi.'&d='.$Destino.'&m='.$Mensaje.'&t='.$Tipo.'&usuario='.$usuario);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
                    $output = curl_exec($ch); 
                    curl_close($ch);
                    //prueba
                    
                    }
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
    }

    public function getExportarpasajerosrutas($id){

        Excel::create('Ruta', function($excel) use ($id){

            $excel->sheet('Rutas', function($sheet) use ($id){

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

      Excel::create('rutas', function($excel){

          $excel->sheet('hoja', function($sheet){

              $fecha_inicial = Input::get('md_fecha_inicial');
              $fecha_final = Input::get('md_fecha_final');
              $centrodecosto = Input::get('md_centrodecosto');
              $subcentrodecosto = Input::get('md_subcentrodecosto');

              $servicios = DB::select("select pasajeros_ruta, ruta, fecha_servicio from servicios where servicios.fecha_servicio between '".$fecha_inicial."' and '".$fecha_final."' and ruta = 1 and centrodecosto_id ='".$centrodecosto."' and subcentrodecosto_id = '".$subcentrodecosto."' order by fecha_servicio");

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

              Excel::create('ruta', function($excel) use ($centrodecosto, $subcentrodecosto, $fecha){

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
                              "where servicios.ruta = 1 and centrodecosto_id =".$centrodecosto." and subcentrodecosto_id = ".$subcentrodecosto." and fecha_servicio = '".$fecha."' order by detalle_recorrido";

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

                Excel::create('rutas', function($excel) use ($centrodecosto, $subcentrodecosto, $fecha){

                    $excel->sheet('hoja', function($sheet) use ($centrodecosto, $subcentrodecosto, $fecha){

                        $consulta = "select * from servicios where centrodecosto_id = ".$centrodecosto." and subcentrodecosto_id = ".$subcentrodecosto." and ruta = 1 and fecha_servicio ='".$fecha."' ";
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

        $id = Input::get('id');

        $servicio = DB::table('servicios')->where('id', $id)->first();

        if ($servicio) {
          return Response::json([
              'respuesta' => true,
              'servicio'=> $servicio
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

            if ($servicio) {
              return Response::json([
                  'servicio' => $servicio,
                  'respuesta' => true
              ]);
            }

          }

        }

      }

      public function postEnviarnotificacion(){

        $apikey = 'AAAAmVuqq8M:APA91bGKk3kzjOdsCwbkxDUJwjW56XSJnVX5c-xa9AkPOGcFc1qdtHfppEiIUkM7klen0lHC84DK07Ds7wrrTEJiDBgZHzLabezWkTUx1qeFWM5uggF8nPO3HjQsTcrC0EYw3RGhrsch';
        $id_servicio = Input::get('id');
        $servicio = DB::table('servicios')->where('id', $id_servicio)->first();
        $id_usuario = DB::table('conductores')->where('id', $servicio->conductor_id)->pluck('usuario_id');
  			$centrodecosto = Centrodecosto::find($servicio->centrodecosto_id);
        $id_registration = DB::table('users')->where('id', $id_usuario)->pluck('idregistrationdevice');
        $registrationId = [$id_registration];
  			$number = rand(10000000, 99999999);

  			$msg = [
          'message' => 'Se le ha asignado un servicio para el dia: '.$servicio->fecha_servicio.', hora: '.$servicio->hora_servicio.', recoger en: '.$servicio->recoger_en.', dejar en: '.$servicio->dejar_en.' para '.$centrodecosto->razonsocial,
          'title' => 'Aotour Mobile',
  				'vibrationPattern' => [
            2000,
            1000,
            500,
            500
          ],
          'soundname' => 'default',
          'notId' => $number,
        ];

        $fields = [
          'registration_ids' => $registrationId,
          'data' => $msg
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

        if ($result===FALSE) {
          return Response::json([
            'respuesta' => false,
            'id_servicio'=> $id_servicio,
            'id_conductor'=> $servicio->conductor_id,
            'registrationid'=>$registrationId
          ]);
        }else{
          return Response::json([
            'respuesta' => true,
            'id_servicio'=> $id_servicio,
            'id_conductor'=> $servicio->conductor_id,
            'registrationid'=>$registrationId
          ]);
        }

        curl_close($ch);

      }

  	public function getServicioseditados(){

          if (Sentry::check()) {
  			$id_rol = Sentry::getUser()->id_rol;
  			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
  			$permisos = json_decode($permisos);
  			$ver = $permisos->transportes->poreliminar->ver;
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

              return View::make('servicios.servicios_editados')
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
                  //VALIDACIONES
                  $validaciones = [
                      'centrodecosto_id'=>'required|numeric',
                      'subcentrodecosto_id'=>'required|numeric',
                      'solicitado_por'=>'required',
                      'departamento'=>'required|select',
                      'ciudad'=>'required|select',
                      'ruta_id'=>'required|numeric',
                      'recoger_en'=>'required',
                      'dejar_en'=>'required',
                      'detalle_recorrido'=>'required',
                      'proveedor_id'=>'required|numeric',
                      'conductor_id'=>'required|numeric',
                      'vehiculo_id'=>'required|numeric',
                      'fecha_servicio'=>'required|date_format:Y-m-d',
                      'hora_servicio'=>'required|date_format:H:m',
                      'resaltar'=>'required|numeric',
                      'pago_directo'=>'required|numeric',
                      'firma'=>'required|numeric',
  										'notificacion'=>'required|numeric'
                  ];

                  //VALIDACIONES
                  $mensajes = [
                      'centrodecosto_id.numeric'=>'Debe seleccionar un centro de costo',
                      'subcentrodecosto_id.numeric'=>'Debe seleccionar un subcentro de costo',
                      'departamento.select'=>'Debe seleccionar un departamento',
                      'ciudad.select'=>'Debe seleccionar una ciudad',
                      'ruta_id.required'=>'Debe seleccionar una ruta',
                      'ruta_id.numeric'=>'Debe seleccionar una ruta',
                      'proveedor_id.numeric'=>'Debe seleccionar un proveedor',
                      'resaltar.numeric'=>'Debe seleccionar la opcion resaltar',
                      'pago_directo.numeric'=>'Debe seleccionar la opcion pago_directo',
  										'notificacion.numeric'=>'Debe seleccionar la opcion notificacion',
  										'firma.numeric' => 'Debe seleccionar la opcion firma',
  										'notificacion.required'=>'Debe seleccionar la opcion notificacion'
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
                              'respuesta' => 'rechazado',
                              'liquidacion' => $liquidacion,
                              'ordenes_facturacion' => $ordenes_facturacion
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

                                  if ($email_solicitante==='') {
                                      $cambios = $cambios.'Se cambio el email de la persona que solicito el servicio a <b>'.Input::get('email_solicitante').'</b><br>';
                                  }else{
                                      $cambios = $cambios.'Se cambio el email de la persona que solicito el servicio de <b>'.$email_solicitante.'</b> a <b>'.Input::get('email_solicitante').'</b><br>';
                                  }

                              }

                              if ($ruta!=Input::get('ruta_id')) {

                                if ($ruta==null) {

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

                              if ($ruta_nombre_id!=Input::get('ruta_nombre_id')) {

                                  if ($ruta_nombre_id==null) {

                                    $ruta_nombre1 = NombreRuta::where('id', Input::get('ruta_nombre_id'))->first();
                                    $cambios = $cambios.'Se asigno el nombre de ruta <b>'.$ruta_nombre1->nombre.'</b><br>';

                                  }else{

                                    $ruta_nombre1 = NombreRuta::where('id', Input::get('ruta_nombre_id'))->first();
                                    $ruta_nombre2 = NombreRuta::where('id', $ruta_nombre_id)->first();

                                    $cambios = $cambios.'Se cambio el nombre de la ruta de <b>'.$ruta_nombre2->nombre.'</b> a <b>'.
                                    $ruta_nombre1->nombre.'</b><br>';

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
                              if ($pago_directo!=Input::get('pago_directo')) {
                                  $cambios = $cambios.'Se cambio el campo pago directo<br>';
                              }

                              if ($firma!=Input::get('firma')) {
                                  $cambios = $cambios.'Se cambio el campo firma y calificacion<br>';
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

  						if($cambios != ''){
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
                $servicio_editado->ruta_nombre_id = Input::get('ruta_nombre_id');
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

}
