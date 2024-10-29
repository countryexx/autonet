<?php

class OtrosserviciosController extends BaseController{

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

		if (isset($permisos->turismo->otros->ver)){
			$ver = $permisos->turismo->otros->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$centrodecosto = DB::table('centrosdecosto')
				->whereNull('inactivo_total')
				->whereNull('inactivo')
				->orderBy('razonsocial')
				->get();
			$departamento = DB::table('departamento')->orderBy('departamento')->get();
			$terceros = DB::table('terceros')->orderBy('nombre_completo')->get();

			return View::make('otrosservicios.otrosservicios')
            ->with([
                'centrosdecosto'=>$centrodecosto,
                'departamento'=>$departamento,
                'terceros'=>$terceros,
                'permisos'=>$permisos
            ]);
	    }
	}

	public function postNuevo(){

		if (!Sentry::check()){

			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else {

			if (Request::ajax()) {

				$total_ingresos_propios = 0;
				$total_costos = 0;
				$total_utilidad = 0;

				//ULTIMA ID DE FACTURA PARA SACAR NUMERO CONSECUTIVO
				$ultimo_id = DB::table('ordenes_facturacion')
                    ->select('id','numero_factura')
                    ->orderBy('id','desc')
                    ->first();

				//NUEVA FACTURA PARA TIQUETES
				$orden_facturacion = new Ordenfactura;
				$orden_facturacion->centrodecosto_id = Input::get('centrodecosto_id');
				$orden_facturacion->subcentrodecosto_id = Input::get('subcentrodecosto_id');
				$orden_facturacion->ciudad = Input::get('ciudad');
				$orden_facturacion->fecha_expedicion = date('Y-m-d H:i:s');
				$orden_facturacion->fecha_inicial = Input::get('fecha_orden');
				$orden_facturacion->fecha_final = Input::get('fecha_orden');
				$orden_facturacion->tipo_orden = 2;
				$orden_facturacion->total_facturado_cliente = Input::get('valor');
				$orden_facturacion->fecha_factura = date('Y-m-d');
				$orden_facturacion->facturado = 1;

				//CALCULO DE VALORES PARA TOTAL COSTOS Y TOTAL UTILIDAD
				$valorArray = explode(',',Input::get('valorArray'));
				$valorcomisionArray = explode(',',Input::get('valorcomisionArray'));
				$otrosArray = explode(',',Input::get('otrosArray'));

				for ($i=0; $i < count($valorArray); $i++) {
					$total_ingresos_propios = $total_ingresos_propios+intval($valorArray[$i]);
				}

				for ($i=0; $i < count($valorcomisionArray); $i++) {
					$total_utilidad = $total_utilidad+intval($valorcomisionArray[$i]);
				}

				for ($i=0; $i < count($otrosArray); $i++) {
					$total_utilidad = $total_utilidad+intval($otrosArray[$i]);
				}

				$productoArray = explode(',',Input::get('productoArray'));
				$destino_detalleArray = explode(',',Input::get('destino_detalleArray'));
				$porcentajeArray = explode(',',Input::get('porcentajeArray'));
				$ivacomisionArray = explode(',',Input::get('ivacomisionArray'));
				$valordolaresArray = explode(',',Input::get('valordolaresArray'));
				$ivaservicioArray = explode(',',Input::get('ivaservicioArray'));
				$tasaaeroArray = explode(',',Input::get('tasaaeroArray'));
				$otrastasasArray = explode(',',Input::get('otrastasasArray'));
				$impuestosArray = explode(',',Input::get('impuestosArray'));
				$descuentosArray = explode(',',Input::get('descuentosArray'));

				for ($i=0; $i < count($valorArray); $i++) {
					$total_costos = $total_costos+intval($impuestosArray[$i]);
					$total_costos = $total_costos+intval($tasaaeroArray[$i]);
					$total_costos = $total_costos+intval($otrastasasArray[$i]);
					$total_costos = $total_costos+intval($ivaservicioArray[$i]);
				}

				$orden_facturacion->total_ingresos_propios = $total_ingresos_propios;
				$orden_facturacion->total_costo = $total_costos;
				$orden_facturacion->total_utilidad = $total_utilidad;
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

					//CREACION DE LOS DETALLES PRINCIPALES DE EL SERVICIOS (OTROS SERVICIOS)
					$otros_servicios_detalle = new Otrosserviciosdetalle;
					$otros_servicios_detalle->centrodecosto = Input::get('centrodecosto_id');
					$otros_servicios_detalle->subcentrodecosto = Input::get('subcentrodecosto_id');
					$otros_servicios_detalle->fecha = Input::get('fecha');
					$otros_servicios_detalle->valor = Input::get('valor');
					$otros_servicios_detalle->negocio = Input::get('negocio');
					$otros_servicios_detalle->tercero = Input::get('tercero');
					$otros_servicios_detalle->id_tercero = Input::get('id_tercero');
					$otros_servicios_detalle->pagado_proveedor = Input::get('pagado_proveedor');
					$otros_servicios_detalle->forma_pago = Input::get('forma_pago');
					$otros_servicios_detalle->concepto = Input::get('concepto');
					$otros_servicios_detalle->autorizado_por = Input::get('autorizado_por');
					$otros_servicios_detalle->plazo = Input::get('plazo');
					$otros_servicios_detalle->comentarios = Input::get('comentarios');

					//SE ASIGNA EL NUMERO DE FACTURA A ESTOS SERVICIOS
					$otros_servicios_detalle->id_factura = $id;
					$otros_servicios_detalle->creado_por = Sentry::getUser()->id;

					if($otros_servicios_detalle->save()){

						//SE ASIGNA EL NUMERO CONSECUTIVO PARA ESTE SERVICIO (OTROS SERVICIOS)
						$id_servicios = $otros_servicios_detalle->id;
						$orden_s = Otrosserviciosdetalle::find($id_servicios);

						if (strlen(intval($id_servicios))===1) {
							$orden_s->consecutivo = 'AR000' . $id_servicios;
							$orden_s->save();
						} elseif (strlen(intval($id_servicios))===2) {
							$orden_s->consecutivo = 'AR00' . $id_servicios;
							$orden_s->save();
						} elseif (strlen(intval($id_servicios))===3) {
							$orden_s->consecutivo = 'AR0' . $id_servicios;
							$orden_s->save();
						} elseif (strlen(intval($id_servicios))===4) {
							$orden_s->consecutivo = 'AR' . $id_servicios;
							$orden_s->save();
						}

						for ($i=0; $i < count($productoArray); $i++) {
							$otros_servicios = new Otrosservicios;
							$otros_servicios->fecha = Input::get('fecha_orden');
							$otros_servicios->departamento = Input::get('departamento');
							$otros_servicios->ciudad = Input::get('ciudad');
							$otros_servicios->producto = $productoArray[$i];
							$otros_servicios->destino_detalle = $destino_detalleArray[$i];
							$otros_servicios->porcentaje = $porcentajeArray[$i];
							$otros_servicios->valor_comision = $valorcomisionArray[$i];
							$otros_servicios->iva_comision = $ivacomisionArray[$i];
							$otros_servicios->otros = $otrosArray[$i];
							$otros_servicios->valor_dolares = $valordolaresArray[$i];
							$otros_servicios->valor = $valorArray[$i];
							$otros_servicios->iva_servicio = $ivaservicioArray[$i];
							$otros_servicios->tasa_aero = $tasaaeroArray[$i];
							$otros_servicios->otras_tasas = $otrastasasArray[$i];
							$otros_servicios->impuesto = $impuestosArray[$i];
							$otros_servicios->descuento = $descuentosArray[$i];
							$otros_servicios->id_servicios_detalles = $id_servicios;
							$otros_servicios->save();
						}

						return Response::json([
							'respuesta'=>true,
							'idfacturacion'=>$id
						]);
					}
				}
			}
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

		if (isset($permisos->turismo->otros->ver)){
			$ver = $permisos->turismo->otros->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$centrosdecosto = DB::table('centrosdecosto')->orderBy('razonsocial')->get();
			$ciudades = DB::table('ciudad')->orderBy('ciudad')->get();

			$otros_servicios = DB::table('otros_servicios_detalles')
			->select('otros_servicios_detalles.id','ordenes_facturacion.numero_factura','ordenes_facturacion.anulado',
			'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro', 'otros_servicios_detalles.fecha','otros_servicios_detalles.negocio',
			'otros_servicios_detalles.consecutivo', 'otros_servicios_detalles.id_factura','ordenes_facturacion.revision_ingreso', 'ordenes_facturacion.revisado_por')
			->leftJoin('ordenes_facturacion', 'otros_servicios_detalles.id_factura', '=', 'ordenes_facturacion.id')
			->leftJoin('centrosdecosto', 'otros_servicios_detalles.centrodecosto', '=', 'centrosdecosto.id')
			->leftJoin('subcentrosdecosto', 'otros_servicios_detalles.subcentrodecosto', '=', 'subcentrosdecosto.id')
			->where('fecha',date('Y-m-d'))->get();

			return View::make('otrosservicios.listado_otros_servicios')
			->with([
				'i'=>1,
				'otros_servicios'=>$otros_servicios,
			  'centrosdecosto'=>$centrosdecosto,
				'ciudades'>=$ciudades,
				'permisos'=>$permisos
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

				/*UPDATE  otros_servicios_detalles
					LEFT JOIN
					        otros_servicios
					ON      otros_servicios_detalles.id = otros_servicios.id_servicios_detalles
					SET     otros_servicios_detalles.centrodecosto = otros_servicios.centrodecosto_id,
							otros_servicios_detalles.subcentrodecosto = otros_servicios.subcentrodecosto_id*/
				$fecha_inicial = Input::get('fecha_inicial');
				$fecha_final = Input::get('fecha_final');
				$centrodecosto = intval(Input::get('centrodecosto'));
				$subcentrodecosto = intval(Input::get('subcentrodecosto'));
				$opcion = intval(Input::get('opcion'));
				$numero = Input::get('numero');

				if ($opcion!=0) {

						$consulta = "select otros_servicios_detalles.fecha, ordenes_facturacion.numero_factura, ordenes_facturacion.anulado, ".
												"ordenes_facturacion.ingreso, ordenes_facturacion.revision_ingreso, otros_servicios_detalles.id_factura, otros_servicios_detalles.id, ".
												"centrosdecosto.id as centro_id, subcentrosdecosto.id as subcentro_id, otros_servicios_detalles.negocio, ".
												"otros_servicios_detalles.consecutivo, centrosdecosto.razonsocial, subcentrosdecosto.nombresubcentro from otros_servicios_detalles ".
												"left join centrosdecosto on otros_servicios_detalles.centrodecosto = centrosdecosto.id ".
												"left join ordenes_facturacion on otros_servicios_detalles.id_factura = ordenes_facturacion.id ".
												"left join subcentrosdecosto on otros_servicios_detalles.subcentrodecosto = subcentrosdecosto.id ".
												"where otros_servicios_detalles.id is not null ";

						if ($opcion===1) {
							$consulta .= " and otros_servicios_detalles.consecutivo = '".$numero."' ";
						}
						if ($opcion===2) {
							$consulta .= " and ordenes_facturacion.numero_factura = '".$numero."' ";
						}
						if ($opcion===3) {
							$consulta .= " and otros_servicios_detalles.negocio = '".$numero."' ";
						}
				}else if ($opcion===0) {

						$consulta = "select otros_servicios_detalles.fecha, ordenes_facturacion.numero_factura, ordenes_facturacion.anulado, otros_servicios_detalles.id_factura, ".
												"otros_servicios_detalles.id, centrosdecosto.id as centro_id, subcentrosdecosto.id as subcentro_id, otros_servicios_detalles.negocio, ".
												"ordenes_facturacion.ingreso, ordenes_facturacion.revision_ingreso, otros_servicios_detalles.consecutivo, centrosdecosto.razonsocial, ".
												"subcentrosdecosto.nombresubcentro from otros_servicios_detalles ".
						 						"left join centrosdecosto on otros_servicios_detalles.centrodecosto = centrosdecosto.id ".
						 						"left join ordenes_facturacion on otros_servicios_detalles.id_factura = ordenes_facturacion.id ".
						 						"left join subcentrosdecosto on otros_servicios_detalles.subcentrodecosto = subcentrosdecosto.id ".
												"where otros_servicios_detalles.fecha between '".$fecha_inicial."' and '".$fecha_final."' ";

						if ($centrodecosto!=0) {
								$consulta .= " and otros_servicios_detalles.centrodecosto = ".$centrodecosto." ";
						}

						if ($subcentrodecosto!=0) {
								$consulta .= " and otros_servicios_detalles.subcentrodecosto = ".$subcentrodecosto." ";
						}
				}

				$otros_servicios = DB::select($consulta.' order by consecutivo');

				$array = [
					'respuesta'=>true,
					'otros_servicios' => $otros_servicios,
					'consulta'=>$consulta
				];

				if ($otros_servicios!=null) {
						return Response::json($array);
				}else{
					 return Response::json([
						 	'respuesta'=>false,
							'consulta'=>$consulta
					 ]);
				}
			}
		}
	}

	public function postMostrarproducto(){

		if (!Sentry::check()){

			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else{

			if (Request::ajax()) {

					$consulta = "select producto from otros_servicios where id_servicios_detalles = ".Input::get('id');
					$productos = DB::select($consulta);

					return Response::json([
						'res'=>true,
						'productos'=>$productos,
						'consulta'=>$consulta
					]);

			}
		}
	}

	public function getMostrarpersona(){

		if (!Sentry::check()){

				return Response::json([
						'mensaje'=>'relogin'
				]);

		}else{

			if (Request::ajax()) {

				$nombre_completo = Input::get('term');

				$consulta = "select nombresubcentro from subcentrosdecosto where centrosdecosto_id = '100' and nombresubcentro like '%".$nombre_completo."%'";
				$clientes = DB::select($consulta);
				$array = [];

					foreach ($clientes as $cliente)
					{
							$array[] = $cliente->nombresubcentro;
					}

				return Response::json(array_unique($array));
			}

		}

	}

	public function postTomarpersona(){

      if (!Sentry::check()){

          return Response::json([
              'mensaje'=>'relogin'
          ]);

      }else{

        if (Request::ajax()) {

          $valor = Input::get('valor');

					$consulta = "select * from subcentrosdecosto where centrosdecosto_id = '100' and nombresubcentro = '".$valor."' limit 1";

          $datos = DB::select($consulta);

          return Response::json([
            'respuesta'=>true,
            'datos'=>$datos
          ]);

        }

      }
  }
	
	public function postNuevoar(){

		if (!Sentry::check()){

			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else {

			if (Request::ajax()) {

				$total_ingresos_propios = 0;
				$total_costos = 0;
				$total_utilidad = 0;

				//ULTIMA ID DE FACTURA PARA SACAR NUMERO CONSECUTIVO
				/*$ultimo_id = DB::table('ordenes_facturacion')
                    ->select('id','numero_factura')
                    ->orderBy('id','desc')
                    ->first();

				//NUEVA FACTURA PARA TIQUETES
				$orden_facturacion = new Ordenfactura;
				$orden_facturacion->centrodecosto_id = Input::get('centrodecosto_id');
				$orden_facturacion->subcentrodecosto_id = Input::get('subcentrodecosto_id');
				$orden_facturacion->ciudad = Input::get('ciudad');
				$orden_facturacion->fecha_expedicion = date('Y-m-d H:i:s');
				$orden_facturacion->fecha_inicial = Input::get('fecha_orden');
				$orden_facturacion->fecha_final = Input::get('fecha_orden');
				$orden_facturacion->tipo_orden = 2;
				$orden_facturacion->total_facturado_cliente = Input::get('valor');
				$orden_facturacion->fecha_factura = date('Y-m-d');
				$orden_facturacion->facturado = 1;*/

				//CALCULO DE VALORES PARA TOTAL COSTOS Y TOTAL UTILIDAD
				$valorArray = explode(',',Input::get('valorArray'));
				$valorcomisionArray = explode(',',Input::get('valorcomisionArray'));
				$otrosArray = explode(',',Input::get('otrosArray'));

				for ($i=0; $i < count($valorArray); $i++) {
					$total_ingresos_propios = $total_ingresos_propios+intval($valorArray[$i]);
				}

				for ($i=0; $i < count($valorcomisionArray); $i++) {
					$total_utilidad = $total_utilidad+intval($valorcomisionArray[$i]);
				}

				for ($i=0; $i < count($otrosArray); $i++) {
					$total_utilidad = $total_utilidad+intval($otrosArray[$i]);
				}

				$productoArray = explode(',',Input::get('productoArray'));
				$destino_detalleArray = explode(',',Input::get('destino_detalleArray'));
				$porcentajeArray = explode(',',Input::get('porcentajeArray'));
				$ivacomisionArray = explode(',',Input::get('ivacomisionArray'));
				$valordolaresArray = explode(',',Input::get('valordolaresArray'));
				$ivaservicioArray = explode(',',Input::get('ivaservicioArray'));
				$tasaaeroArray = explode(',',Input::get('tasaaeroArray'));
				$otrastasasArray = explode(',',Input::get('otrastasasArray'));
				$impuestosArray = explode(',',Input::get('impuestosArray'));
				$descuentosArray = explode(',',Input::get('descuentosArray'));

				for ($i=0; $i < count($valorArray); $i++) {
					$total_costos = $total_costos+intval($impuestosArray[$i]);
					$total_costos = $total_costos+intval($tasaaeroArray[$i]);
					$total_costos = $total_costos+intval($otrastasasArray[$i]);
					$total_costos = $total_costos+intval($ivaservicioArray[$i]);
				}

				/*$orden_facturacion->total_ingresos_propios = $total_ingresos_propios;
				$orden_facturacion->total_costo = $total_costos;
				$orden_facturacion->total_utilidad = $total_utilidad;
				$orden_facturacion->numero_factura = intval($ultimo_id->numero_factura)+1;
				$orden_facturacion->creado_por = Sentry::getUser()->id;*/

				//if ($orden_facturacion->save()) {

					//ASIGNACION DE NUMERO CONSECUTIVO
					/*$id = $orden_facturacion->id;
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
					}*/

					//CREACION DE LOS DETALLES PRINCIPALES DE EL SERVICIOS (OTROS SERVICIOS)
					$otros_servicios_detalle = new Otrosserviciosdetalle;
					$otros_servicios_detalle->centrodecosto = Input::get('centrodecosto_id');
					$otros_servicios_detalle->subcentrodecosto = Input::get('subcentrodecosto_id');
					$otros_servicios_detalle->fecha = Input::get('fecha');
					$otros_servicios_detalle->valor = Input::get('valor');
					$otros_servicios_detalle->negocio = Input::get('negocio');
					$otros_servicios_detalle->tercero = Input::get('tercero');
					$otros_servicios_detalle->id_tercero = Input::get('id_tercero');
					$otros_servicios_detalle->pagado_proveedor = Input::get('pagado_proveedor');
					$otros_servicios_detalle->forma_pago = Input::get('forma_pago');
					$otros_servicios_detalle->concepto = Input::get('concepto');
					$otros_servicios_detalle->autorizado_por = Input::get('autorizado_por');
					$otros_servicios_detalle->plazo = Input::get('plazo');
					$otros_servicios_detalle->comentarios = Input::get('comentarios');
					
					$otros_servicios_detalle->fecha_orden = Input::get('fecha_orden');
					$otros_servicios_detalle->ciudad = Input::get('ciudad');
					$otros_servicios_detalle->total_ingresos_propios = $total_ingresos_propios;
					$otros_servicios_detalle->total_utilidad = $total_utilidad;
					$otros_servicios_detalle->total_costo = $total_costos;

					//SE ASIGNA EL NUMERO DE FACTURA A ESTOS SERVICIOS
					//$otros_servicios_detalle->id_factura = $id;
					$otros_servicios_detalle->creado_por = Sentry::getUser()->id;

					if($otros_servicios_detalle->save()){

						//SE ASIGNA EL NUMERO CONSECUTIVO PARA ESTE SERVICIO (OTROS SERVICIOS)
						$id_servicios = $otros_servicios_detalle->id;
						$orden_s = Otrosserviciosdetalle::find($id_servicios);

						if (strlen(intval($id_servicios))===1) {
							$orden_s->consecutivo = 'AR000' . $id_servicios;
							$orden_s->save();
						} elseif (strlen(intval($id_servicios))===2) {
							$orden_s->consecutivo = 'AR00' . $id_servicios;
							$orden_s->save();
						} elseif (strlen(intval($id_servicios))===3) {
							$orden_s->consecutivo = 'AR0' . $id_servicios;
							$orden_s->save();
						} elseif (strlen(intval($id_servicios))===4) {
							$orden_s->consecutivo = 'AR' . $id_servicios;
							$orden_s->save();
						}

						for ($i=0; $i < count($productoArray); $i++) {
							$otros_servicios = new Otrosservicios;
							$otros_servicios->fecha = Input::get('fecha_orden');
							$otros_servicios->departamento = Input::get('departamento');
							$otros_servicios->ciudad = Input::get('ciudad');
							$otros_servicios->producto = $productoArray[$i];
							$otros_servicios->destino_detalle = $destino_detalleArray[$i];
							$otros_servicios->porcentaje = $porcentajeArray[$i];
							$otros_servicios->valor_comision = $valorcomisionArray[$i];
							$otros_servicios->iva_comision = $ivacomisionArray[$i];
							$otros_servicios->otros = $otrosArray[$i];
							$otros_servicios->valor_dolares = $valordolaresArray[$i];
							$otros_servicios->valor = $valorArray[$i];
							$otros_servicios->iva_servicio = $ivaservicioArray[$i];
							$otros_servicios->tasa_aero = $tasaaeroArray[$i];
							$otros_servicios->otras_tasas = $otrastasasArray[$i];
							$otros_servicios->impuesto = $impuestosArray[$i];
							$otros_servicios->descuento = $descuentosArray[$i];
							$otros_servicios->id_servicios_detalles = $id_servicios;
							$otros_servicios->save();
						}

						return Response::json([
							'respuesta'=>true,
							'idfacturacion'=>$id_servicios
						]);
					}
				//}
			}
		}
	}
}
