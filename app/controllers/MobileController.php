<?php

/**
 * Clase para servicios solicitados via movil - url = 'autonet/mobile'
 */
class MobileController extends BaseController{

	/**
	 * Metodo para renderizar la vista de los servicios que han sido programados y no
	 * tienen tarifa - url = 'autonet/mobile/serviciosprogramadossintarifa'
	 * @return view [description]
	 */
	public function getServiciosprogramadossintarifa(){

		/**
		 * Variable para asignar el valor
		 * @var string
		 */
		$ver = null;

		/**
		 * Si el usuario ha sido autenticado usando la clase Sentry y metodo check()
		 * @var boolean
		 */
    if (Sentry::check()){

				/**
				 * id del rol del usuario
				 * @var integer
				 */
        $rol_id = Sentry::getUser()->id_rol;

				/**
				 * Traer los permisos de acuerdo al rol
				 * @var array
				 */
        $permisos = json_decode(Rol::find($rol_id)->permisos);


				//Si el permiso esta asignado a la variable
        if (isset($permisos->mobile->servicios_programados_sintarifa->ver)) {

						//Asignar valor a la variable $ver de acuerdo al objeto permisos
            $ver = $permisos->mobile->servicios_programados_sintarifa->ver;

						//Si la variable no tiene el valor 'on' entonces no tiene permisos para acceder a la vista
            if($ver!='on') {

							/**
							 * Redireccion a url de permiso denegado
							 * @var view
							 */
              return Redirect::to('permiso_denegado');

            }else{

							$centrosdecosto = Centrodecosto::Activos()->internos()->orderBy('razonsocial')->get();
							$proveedores = Proveedor::Valido()->afiliadosinternos()->orderBy('razonsocial')->get();
							$departamentos = Departamento::orderBy('departamento', 'asc')->get();


					    $serviciosAplicacion = "SELECT servicios_aplicacion.*, pago_servicios.estado FROM servicios_aplicacion LEFT JOIN pago_servicios ON pago_servicios.id = servicios_aplicacion.pago_servicio_id WHERE servicios_aplicacion.programado IS NULL AND cancelado IS NULL AND servicios_aplicacion.fecha > '20240101'";

					    $serviciosAplicacion = DB::select($serviciosAplicacion);
;
					    //$serviciosAplicacion = Servicioaplicacion::Sintarifa()->orderBy('created_at', 'desc')->get();
							$subcentrosdecosto = Subcentro::where('centrosdecosto_id', 100)->orderBy('nombresubcentro')->get();

							$tarifas = Tarifastraslados::orderBy('tarifa_ciudad')->get();
							$tarifas_grupo = Tarifastraslados::select('tarifa_ciudad')->orderBy('tarifa_ciudad')->groupBy('tarifa_ciudad')->get();

					    return View::make('mobile.servicios_por_aplicacion', [
								'permisos' => $permisos,
					      'servicios_aplicacion' => $serviciosAplicacion,
								'tarifas' => $tarifas,
								'centrosdecosto' => $centrosdecosto,
								'subcentrosdecosto' => $subcentrosdecosto,
								'proveedores' => $proveedores,
								'departamentos' => $departamentos,
								'tarifas_grupo' => $tarifas_grupo,
								'i' => 1
					    ]);

						}

				}else{

						return Redirect::to('permiso_denegado');
				}

		}else if(!Sentry::check()){

				return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}

  }

  public function getServiciosprogramadospagados(){

		$ver = null;

    if (Sentry::check()){

        $rol_id = Sentry::getUser()->id_rol;

        $permisos = json_decode(Rol::find($rol_id)->permisos);

        if (isset($permisos->mobile->servicios_programados_pagados->ver)) {

            $ver = $permisos->mobile->servicios_programados_pagados->ver;

            if($ver!='on') {

                return Redirect::to('permiso_denegado');

            }else{

							$centrosdecosto = Centrodecosto::Activos()->internos()->orderBy('razonsocial')->get();

							$subcentrosdecosto = Subcentro::where('centrosdecosto_id', 100)->orderBy('nombresubcentro')->get();

							$proveedores = Proveedor::Valido()->afiliadosinternos()->orderBy('razonsocial')->get();

							$departamentos = Departamento::orderBy('departamento', 'asc')->get();

					    //$serviciosAplicacion = Servicioaplicacion::Pagados()->orderBy('fecha_pago', 'desc')->get();
						$serviciosAplicacion = "SELECT servicios_aplicacion.*, pago_servicios.estado, pago_servicios.reference_code, centrosdecosto.razonsocial, subcentrosdecosto.nombresubcentro, users.first_name, users.last_name, users.telefono FROM servicios_aplicacion LEFT JOIN pago_servicios ON pago_servicios.id = servicios_aplicacion.pago_servicio_id LEFT JOIN users on users.id = servicios_aplicacion.user_id LEFT JOIN centrosdecosto on centrosdecosto.id = users.centrodecosto_id LEFT JOIN subcentrosdecosto on subcentrosdecosto.id = users.subcentrodecosto_id WHERE servicios_aplicacion.programado IS NULL AND cancelado IS NULL AND servicios_aplicacion.fecha > '20240101'";

					    $serviciosAplicacion = DB::select($serviciosAplicacion);

							/*foreach ($serviciosAplicacion as $servicio) {
								echo $servicio->pagoservicio()->valor.' ';
							}*/

							$tarifas = Tarifastraslados::orderBy('tarifa_ciudad')->get();
							$tarifas_grupo = Tarifastraslados::select('tarifa_ciudad')->orderBy('tarifa_ciudad')->groupBy('tarifa_ciudad')->get();

					    return View::make('mobile.servicios_por_aplicacion', [
								'permisos' => $permisos,
					      'servicios_aplicacion' => $serviciosAplicacion,
								'centrosdecosto' => $centrosdecosto,
								'subcentrosdecosto' => $subcentrosdecosto,
								'proveedores' => $proveedores,
								'departamentos' => $departamentos,
								'tarifas' => $tarifas,
								'tarifas_grupo' => $tarifas_grupo,
								'i' => 1
					    ]);

						}

					}else{

						return Redirect::to('permiso_denegado');

					}

		}else if(!Sentry::check()){

				return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}

  }

	public function getServiciosprogramadostarifado(){

		$ver = null;

    if (Sentry::check()){

        $rol_id = Sentry::getUser()->id_rol;

        $permisos = json_decode(Rol::find($rol_id)->permisos);

        if (isset($permisos->mobile->servicios_programados_tarifado->ver)) {

            $ver = $permisos->mobile->servicios_programados_tarifado->ver;

            if($ver!='on') {

                return Redirect::to('permiso_denegado');

            }else{

								$centrosdecosto = Centrodecosto::Activos()->internos()->orderBy('razonsocial')->get();
								$proveedores = Proveedor::Valido()->afiliadosinternos()->orderBy('razonsocial')->get();
								$departamentos = Departamento::orderBy('departamento', 'asc')->get();
								$subcentrosdecosto = Subcentro::where('centrosdecosto_id', 100)->orderBy('nombresubcentro')->get();

						    $serviciosAplicacion = Servicioaplicacion::Tarifado()
								->whereNull('cancelado')
								->whereNull('pago_pendiente')
								->get();

								$tarifas = Tarifastraslados::orderBy('tarifa_ciudad')->get();
								$tarifas_grupo = Tarifastraslados::select('tarifa_ciudad')->orderBy('tarifa_ciudad')->groupBy('tarifa_ciudad')->get();

						    return View::make('mobile.servicios_por_aplicacion', [
									'permisos' => $permisos,
						      'servicios_aplicacion' => $serviciosAplicacion,
									'tarifas' => $tarifas,
									'tarifas_grupo' => $tarifas_grupo,
									'centrosdecosto' => $centrosdecosto,
									'subcentrosdecosto' => $subcentrosdecosto,
									'proveedores' => $proveedores,
									'departamentos' => $departamentos,
									'i' => 1
						    ]);

							}

						}else{

							return Redirect::to('permiso_denegado');
						}

			}else if(!Sentry::check()){

					return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

			}

  }

	public function getServiciosprogramados(){

		$ver = null;

    if (Sentry::check()){

        $rol_id = Sentry::getUser()->id_rol;

        $permisos = json_decode(Rol::find($rol_id)->permisos);

        if (isset($permisos->mobile->servicios_programados->ver)) {

            $ver = $permisos->mobile->servicios_programados->ver;

            if($ver!='on') {

                return Redirect::to('permiso_denegado');

            }else{

							$centrosdecosto = Centrodecosto::Activos()->internos()->orderBy('razonsocial')->get();
							$proveedores = Proveedor::Valido()->afiliadosinternos()->orderBy('razonsocial')->get();
							$departamentos = Departamento::orderBy('departamento', 'asc')->get();
							$subcentrosdecosto = Subcentro::where('centrosdecosto_id', 100)->orderBy('nombresubcentro')->get();

							$serviciosAplicacion = Servicioaplicacion::whereNull('cancelado')
							->where('empresarial', 1)
							->where('pago_facturacion', 1)
							->programado()
							->orderBy('created_at', 'desc')
							->get();

							$tarifas = Tarifastraslados::orderBy('tarifa_ciudad')->get();
							$tarifas_grupo = Tarifastraslados::select('tarifa_ciudad')->orderBy('tarifa_ciudad')->groupBy('tarifa_ciudad')->get();

					    return View::make('mobile.servicios_por_aplicacion', [
								'permisos' => $permisos,
					      'servicios_aplicacion' => $serviciosAplicacion,
								'tarifas' => $tarifas,
								'tarifas_grupo' => $tarifas_grupo,
								'centrosdecosto' => $centrosdecosto,
								'subcentrosdecosto' => $subcentrosdecosto,
								'proveedores' => $proveedores,
								'departamentos' => $departamentos,
								'i' => 1
					    ]);

						}

					}else{

						return Redirect::to('permiso_denegado');
					}

		}else if(!Sentry::check()){

				return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}


  }

	public function getServiciosprogramadosparticulares(){

		$ver = null;

    if (Sentry::check()){

        $rol_id = Sentry::getUser()->id_rol;

        $permisos = json_decode(Rol::find($rol_id)->permisos);

        if (isset($permisos->mobile->servicios_programados->ver)) {

            $ver = $permisos->mobile->servicios_programados->ver;

            if($ver!='on') {

                return Redirect::to('permiso_denegado');

            }else{

							$centrosdecosto = Centrodecosto::Activos()->internos()->orderBy('razonsocial')->get();
							$proveedores = Proveedor::Valido()->afiliadosinternos()->orderBy('razonsocial')->get();
							$departamentos = Departamento::orderBy('departamento', 'asc')->get();
							$subcentrosdecosto = Subcentro::where('centrosdecosto_id', 100)->orderBy('nombresubcentro')->get();

							$serviciosAplicacion = Servicioaplicacion::whereNull('cancelado')
							->whereNull('empresarial')
							->programado()
							->get();

							$tarifas = Tarifastraslados::orderBy('tarifa_ciudad')->get();
							$tarifas_grupo = Tarifastraslados::select('tarifa_ciudad')->orderBy('tarifa_ciudad')->groupBy('tarifa_ciudad')->get();

					    return View::make('mobile.servicios_por_aplicacion', [
								'permisos' => $permisos,
					      'servicios_aplicacion' => $serviciosAplicacion,
								'tarifas' => $tarifas,
								'tarifas_grupo' => $tarifas_grupo,
								'centrosdecosto' => $centrosdecosto,
								'subcentrosdecosto' => $subcentrosdecosto,
								'proveedores' => $proveedores,
								'departamentos' => $departamentos,
								'i' => 1
					    ]);

						}

					}else{

						return Redirect::to('permiso_denegado');
					}

		}else if(!Sentry::check()){

				return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}


  }

	public function getServiciospendientesporliquidar(){

		$ver = null;

    if (Sentry::check()){

        $rol_id = Sentry::getUser()->id_rol;

        $permisos = json_decode(Rol::find($rol_id)->permisos);

        if (isset($permisos->mobile->servicios_programados->ver)) {

            $ver = $permisos->mobile->servicios_programados->ver;

            if($ver!='on') {

                return Redirect::to('permiso_denegado');

            }else{

							$centrosdecosto = Centrodecosto::Activos()->internos()->orderBy('razonsocial')->get();
							$proveedores = Proveedor::Valido()->afiliadosinternos()->orderBy('razonsocial')->get();
							$departamentos = Departamento::orderBy('departamento', 'asc')->get();
							$subcentrosdecosto = Subcentro::where('centrosdecosto_id', 100)->orderBy('nombresubcentro')->get();

					    $serviciosAplicacion = Servicioaplicacion::whereNull('cancelado')
							->where('liquidacion_pendiente', 1)
							->programado()
							->orderBy('liquidacion_para_pago')
							->get();

							$tarifas = Tarifastraslados::orderBy('tarifa_ciudad')->get();
							$tarifas_grupo = Tarifastraslados::select('tarifa_ciudad')->orderBy('tarifa_ciudad')->groupBy('tarifa_ciudad')->get();

					    return View::make('mobile.servicios_por_aplicacion', [
								'permisos' => $permisos,
					      'servicios_aplicacion' => $serviciosAplicacion,
								'tarifas' => $tarifas,
								'tarifas_grupo' => $tarifas_grupo,
								'centrosdecosto' => $centrosdecosto,
								'subcentrosdecosto' => $subcentrosdecosto,
								'proveedores' => $proveedores,
								'departamentos' => $departamentos,
								'i' => 1
					    ]);

						}

					}else{

						return Redirect::to('permiso_denegado');
					}

		}else if(!Sentry::check()){

				return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}


  }

	/*
	public function getServiciosprogramadospendientepago(){

		$ver = null;

    if (Sentry::check()){

        $rol_id = Sentry::getUser()->id_rol;

        $permisos = json_decode(Rol::find($rol_id)->permisos);

        if (isset($permisos->mobile->servicios_programados->ver)) {

            $ver = $permisos->mobile->servicios_programados->ver;

            if($ver!='on') {

                return Redirect::to('permiso_denegado');

            }else{

							$centrosdecosto = Centrodecosto::Activos()->internos()->orderBy('razonsocial')->get();
							$proveedores = Proveedor::Valido()->afiliadosinternos()->orderBy('razonsocial')->get();
							$departamentos = Departamento::orderBy('departamento', 'asc')->get();
							$subcentrosdecosto = Subcentro::where('centrosdecosto_id', 100)->orderBy('nombresubcentro')->get();

					    $serviciosAplicacion = Servicioaplicacion::programado()
							->whereNotNull('pago_pendiente')
							->orderBy('programado_fecha', 'desc')
							->get();

							$tarifas = Tarifastraslados::orderBy('tarifa_ciudad')->get();
							$tarifas_grupo = Tarifastraslados::select('tarifa_ciudad')->orderBy('tarifa_ciudad')->groupBy('tarifa_ciudad')->get();

					    return View::make('mobile.servicios_por_aplicacion', [
								'permisos' => $permisos,
					      'servicios_aplicacion' => $serviciosAplicacion,
								'tarifas' => $tarifas,
								'tarifas_grupo' => $tarifas_grupo,
								'centrosdecosto' => $centrosdecosto,
								'subcentrosdecosto' => $subcentrosdecosto,
								'proveedores' => $proveedores,
								'departamentos' => $departamentos,
								'i' => 1
					    ]);

						}

					}else{

						return Redirect::to('permiso_denegado');
					}

		}else if(!Sentry::check()){

				return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}

  }
	*/
	public function getServiciosempresariales(){

		$ver = null;

    if (Sentry::check()){

        $rol_id = Sentry::getUser()->id_rol;

        $permisos = json_decode(Rol::find($rol_id)->permisos);

        if (isset($permisos->mobile->servicios_programados_facturacion->ver)) {

            $ver = $permisos->mobile->servicios_programados_facturacion->ver;

            if($ver!='on') {

                return Redirect::to('permiso_denegado');

            }else{

							$centrosdecosto = Centrodecosto::Activos()->internos()->orderBy('razonsocial')->get();
							$proveedores = Proveedor::Valido()->afiliadosinternos()->orderBy('razonsocial')->get();
							$departamentos = Departamento::orderBy('departamento', 'asc')->get();
							$subcentrosdecosto = Subcentro::where('centrosdecosto_id', 100)->orderBy('nombresubcentro')->get();

					    /*$serviciosAplicacion = Servicioaplicacion::whereRaw('(pago_facturacion = 1 or liquidacion_pendiente = 1)')
							->whereNull('programado')
							->whereNull('cancelado')
							->orderBy('pago_facturacion_fecha', 'desc')
							->get();*/

							$serviciosAplicacion = "SELECT servicios_aplicacion.*, pago_servicios.estado, pago_servicios.reference_code, centrosdecosto.razonsocial, subcentrosdecosto.nombresubcentro, users.first_name, users.last_name, users.telefono FROM servicios_aplicacion LEFT JOIN pago_servicios ON pago_servicios.id = servicios_aplicacion.pago_servicio_id LEFT JOIN users on users.id = servicios_aplicacion.user_id LEFT JOIN centrosdecosto on centrosdecosto.id = users.centrodecosto_id LEFT JOIN subcentrosdecosto on subcentrosdecosto.id = users.subcentrodecosto_id WHERE servicios_aplicacion.programado IS NULL AND cancelado IS NULL AND servicios_aplicacion.fecha > '20240101'";

					    	$serviciosAplicacion = DB::select($serviciosAplicacion);

							//Tarifas generales
							$tarifas_grupo = Tarifastraslados::select('tarifa_ciudad')->orderBy('tarifa_ciudad')->groupBy('tarifa_ciudad')->get();

							//return $tarifas_grupo;

							$tarifas = Tarifastraslados::orderBy('tarifa_nombre')->get();

					    return View::make('mobile.servicios_por_aplicacion', [
								'permisos' => $permisos,
					      'servicios_aplicacion' => $serviciosAplicacion,
								'tarifas_grupo' => $tarifas_grupo,
								'tarifas' => $tarifas,
								'centrosdecosto' => $centrosdecosto,
								'subcentrosdecosto' => $subcentrosdecosto,
								'proveedores' => $proveedores,
								'departamentos' => $departamentos,
								'i' => 1
					    ]);

						}

					}else{
						return Redirect::to('permiso_denegado');
					}

		}else if(!Sentry::check()){

				return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}

  }

	public function getServicioscanceladosinprogramar(){

		$ver = null;

    if (Sentry::check()){

        $rol_id = Sentry::getUser()->id_rol;

        $permisos = json_decode(Rol::find($rol_id)->permisos);

        if (isset($permisos->mobile->servicios_programados_facturacion->ver)) {

            $ver = $permisos->mobile->servicios_programados_facturacion->ver;

            if($ver!='on') {

                return Redirect::to('permiso_denegado');

            }else{

							$centrosdecosto = Centrodecosto::Activos()->internos()->orderBy('razonsocial')->get();
							$proveedores = Proveedor::Valido()->afiliadosinternos()->orderBy('razonsocial')->get();
							$departamentos = Departamento::orderBy('departamento', 'asc')->get();
							$subcentrosdecosto = Subcentro::where('centrosdecosto_id', 100)->orderBy('nombresubcentro')->get();

					    $serviciosAplicacion = Servicioaplicacion::Canceladosinprogramar()
							->orderBy('created_at', 'desc')
							->get();

							//Tarifas generales
							$tarifas_grupo = Tarifastraslados::select('tarifa_ciudad')
							->orderBy('tarifa_ciudad')
							->groupBy('tarifa_ciudad')
							->get();

							//return $tarifas_grupo;

							$tarifas = Tarifastraslados::orderBy('tarifa_nombre')->get();

					    return View::make('mobile.servicios_por_aplicacion', [
								'permisos' => $permisos,
					      'servicios_aplicacion' => $serviciosAplicacion,
								'tarifas_grupo' => $tarifas_grupo,
								'tarifas' => $tarifas,
								'centrosdecosto' => $centrosdecosto,
								'subcentrosdecosto' => $subcentrosdecosto,
								'proveedores' => $proveedores,
								'departamentos' => $departamentos,
								'i' => 1
					    ]);

						}

					}else{
						return Redirect::to('permiso_denegado');
					}

		}else if(!Sentry::check()){

				return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}

  }

	public function getServicioscancelados(){

		/**
		 * Variable para asignar el valor
		 * @var string
		 */
		$ver = null;

		/**
		 * Si el usuario ha sido autenticado usando la clase Sentry y metodo check()
		 * @var boolean
		 */
    if (Sentry::check()){

				/**
				 * id del rol del usuario
				 * @var integer
				 */
        $rol_id = Sentry::getUser()->id_rol;

				/**
				 * Traer los permisos de acuerdo al rol
				 * @var array
				 */
        $permisos = json_decode(Rol::find($rol_id)->permisos);


				//Si el permiso esta asignado a la variable
        if (isset($permisos->mobile->servicios_programados_sintarifa->ver)) {

						//Asignar valor a la variable $ver de acuerdo al objeto permisos
            $ver = $permisos->mobile->servicios_programados_sintarifa->ver;

						//Si la variable no tiene el valor 'on' entonces no tiene permisos para acceder a la vista
            if($ver!='on') {
							/**
							 * Redireccion a url de permiso denegado
							 * @var view
							 */
              return Redirect::to('permiso_denegado');

            }else{

							$servicios_cancelados = Servicio::canceladoapp()->get();

							return View::make('mobile.servicios_cancelados', [
								'o' => 1,
								'servicios' => $servicios_cancelados,
								'permisos' => $permisos
							]);

						}

				}

		}

	}

	/*
	public function getServiciosempresarialescredito(){

		$ver = null;

    if (Sentry::check()){

        $rol_id = Sentry::getUser()->id_rol;

        $permisos = json_decode(Rol::find($rol_id)->permisos);

        if (isset($permisos->mobile->servicios_programados_facturacion->ver)) {

            $ver = $permisos->mobile->servicios_programados_facturacion->ver;

            if($ver!='on') {

                return Redirect::to('permiso_denegado');

            }else{

							$centrosdecosto = Centrodecosto::Activos()->internos()->orderBy('razonsocial')->get();
							$proveedores = Proveedor::Valido()->afiliadosinternos()->orderBy('razonsocial')->get();
							$departamentos = Departamento::orderBy('departamento', 'asc')->get();
							$subcentrosdecosto = Subcentro::where('centrosdecosto_id', 100)->orderBy('nombresubcentro')->get();

					    $serviciosAplicacion = Servicioaplicacion::Pagocredito()
							->whereNull('programado')
							->orderBy('pago_facturacion_fecha', 'desc')
							->get();

							//Tarifas generales
							$tarifas_grupo = Tarifastraslados::select('tarifa_ciudad')->orderBy('tarifa_ciudad')->groupBy('tarifa_ciudad')->get();

							$tarifas = Tarifastraslados::orderBy('tarifa_nombre')->get();

					    return View::make('mobile.servicios_por_aplicacion', [
								'permisos' => $permisos,
					      'servicios_aplicacion' => $serviciosAplicacion,
								'tarifas_grupo' => $tarifas_grupo,
								'tarifas' => $tarifas,
								'centrosdecosto' => $centrosdecosto,
								'subcentrosdecosto' => $subcentrosdecosto,
								'proveedores' => $proveedores,
								'departamentos' => $departamentos,
								'i' => 1
					    ]);

						}

					}else{
						return Redirect::to('permiso_denegado');
					}

		}else if(!Sentry::check()){

				return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}

  }
	*/
	public function postTarifar(){

		$nombre_tarifa = Input::get('nombre_tarifa');
		$vehiculo_tarifa = Input::get('vehiculo_tarifa');
		$servicio_id = Input::get('servicio_id');
		$vehiculo = Input::get('vehiculo');

		$servicio = Servicioaplicacion::find($servicio_id);
		$servicio->tarifado = 1;
		$servicio->valor = $vehiculo_tarifa;
		$servicio->tarifador_user_id = Sentry::getUser()->id;
		$servicio->tarifastraslados_id = $nombre_tarifa;
		$servicio->vehiculo_tarifado = $vehiculo;

		if ($servicio->save()) {

			$subtotal = $servicio->valor;
			$comision = $subtotal*0.0349+900;
			$comision_iva = $comision*0.19;
			$total = $subtotal+$comision+$comision_iva;

			$update = DB::table('servicios_aplicacion')
			->where('id',$servicio->id)
			->update([
				'valor'=>$total
			]);

			Servicio::notificarTarifado($servicio->user_id, $servicio->fecha, $servicio->hora, $total);

			return Response::json([
				'response' => true
			]);

		}

	}

	public function postVertarifas(){

		$tarifas = Tarifastraslados::find(Input::get('id'));

		return Response::json([
			'response' => true,
			'tarifas_traslados' => $tarifas
		]);

	}

	public function postMostrarinfoservicio(){

		//Mostrar informacion del servicio en servicios empresariales a programar
		$servicio = Servicioaplicacion::where('id', Input::get('servicio_id'))
		->with('user.centrodecosto.subcentro')
		->first();

		return Response::json([
			'response' => true,
			'servicio' => $servicio
		]);

	}

	public function postCancelarservicio(){

		$id = Input::get('id');

		$servicio_app = DB::table('servicios_aplicacion')
		->where('id',$id)
		->update([
			'cancelado' => 1,
			'cancelado_por' => Sentry::getUser()->id
		]);

		/*Actualizar Notificador de AUTONET*/
		$idpusher = "578229";
		$keypusher = "a8962410987941f477a1";
		$secretpusher = "6a73b30cfd22bc7ac574";

		//CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
		$channel = 'servicios';
		$name = 'mobile';

		$sin_tarifa = Servicioaplicacion::sintarifa()->count();
		$pagados = Servicioaplicacion::pagados()->count();
		$empresarial = Servicioaplicacion::Pagofacturacion()->count();
		$cancelados = Servicio::canceladoapp()->count();

		$data = json_encode([
			'sin_tarifa' => $sin_tarifa,
			'cancelados' => $cancelados,
			'empresarial' => $empresarial,
			'pagados' => $pagados
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

		return Response::json([
			'respuesta' => true,
			'id' => $id,
			'servicio' => $servicio_app
		]);
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

		//Campos de notificacion
		$notificacion_cliente = Input::get('notificacion_cliente');
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

			$servicioaplicacion = Servicioaplicacion::find(Input::get('servicioaplicacion_id'));

			//if ($servicioaplicacion->multiple==1) {
			if (0==1) {

				$fechas = explode(',', $servicioaplicacion->fechas);

				for ($i=0; $i < count($fechas) ; $i++) {

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
						$servicio->ruta_id = Input::get('tarifa_traslado');
						$servicio->recoger_en = Input::get('recoger_en');
						$servicio->dejar_en = Input::get('dejar_en');
						if(Input::get('viaje')!=null){
							$servicio->numero_viaje = Input::get('viaje');
						}
						$servicio->detalle_recorrido = Input::get('detalle_recorrido');
						$servicio->proveedor_id = Input::get('proveedor_id');
						$servicio->conductor_id = Input::get('conductor_id');
						$servicio->vehiculo_id = Input::get('vehiculo_id');
						$servicio->fecha_servicio = $fechas[$i];
						$servicio->hora_servicio = Input::get('hora_servicio');
						$servicio->resaltar = 0;
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
						$servicio->notificaciones_reconfirmacion = null;
						$servicio->programado_app = 1;
						$servicio->serviciosaplicacion_id = Input::get('servicioaplicacion_id');
						$servicio->app_user_id = $servicioaplicacion->user_id;
						if(Sentry::getUser()->localidad==2){
							$servicio->localidad = 1;
						}
						$servicio->save();

						$result = null;

						/**
						 * Notificacion para el conductor
						 */
						if ($notificacion_conductor==1) {

							$number_random = rand(1000000, 9999999);
							Servicio::enviarNotificaciones($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $number_random, $servicio->id);

						}

				}

				$servicioaplicacion->programado = 1;
				$servicioaplicacion->programado_fecha = date('Y-m-d H:i:s');
				$servicioaplicacion->servicio_id = $servicio->id;

				if ($servicioaplicacion->save()) {

					$message = 'Sus servicios han sido programados satisfactoriamente, para mas informacion ingrese al listado de servicios programados, gracias por confiar en nosotros.';

					$number_random = rand(1000000, 9999999);

					$data = [
						'message' => $message,
						'body' => $message,
						'title' => 'Aotour Mobile',
						'notId' => $number_random,
						'vibrationPattern' => [2000, 1000, 500, 500],
						'soundname' => 'default',
						'subtitle' => 'Servicio programado'
					];

					if ($notificacion_cliente==1) {
						$result = Servicio::Actionbutton($servicioaplicacion->user_id, $data);
					}

					/*Actualizar Notificador de AUTONET*/
					$idpusher = "578229";
					$keypusher = "a8962410987941f477a1";
					$secretpusher = "6a73b30cfd22bc7ac574";

					//CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
					$channel = 'servicios';
					$name = 'mobile';

					$sin_tarifa = Servicioaplicacion::sintarifa()->count();
					$pagados = Servicioaplicacion::pagados()->count();
					$empresarial = Servicioaplicacion::Pagofacturacion()->count();
					$cancelados = Servicio::canceladoapp()->count();

					$data = json_encode([
						'sin_tarifa' => $sin_tarifa,
						'cancelados' => $cancelados,
						'empresarial' => $empresarial,
						'pagados' => $pagados
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

					return Response::json([
						'response' => true
					]);

				}

			}else {

	            $servicioApp = DB::table('servicios_aplicacion')
	            ->where('id',Input::get('servicioaplicacion_id'))
	            ->first();

	            if($servicioApp->recogerLatitude!=null) {

	            	$arrayRecoger = [
		                'lat' => $servicioApp->recogerLatitude,
		                'lng' => $servicioApp->recogerLongitude
		            ];

		            $recogerCoords = json_encode([$arrayRecoger]);

		            $arrayDejar = [
		                'lat' => $servicioApp->destinoLatitude,
		                'lng' => $servicioApp->destinoLongitude
		            ];

		            $dejarCoords = json_encode([$arrayDejar]);

	            }else{

	            	$recogerCoords = NULL;
	            	$dejarCoords = NULL;

	            }

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
					$servicio->ruta_id = Input::get('tarifa_traslado');
					$servicio->recoger_en = Input::get('recoger_en');
					$servicio->desde = $recogerCoords;

					$servicio->dejar_en = Input::get('dejar_en');
					$servicio->hasta = $dejarCoords;

					$servicio->detalle_recorrido = Input::get('detalle_recorrido');
					$servicio->proveedor_id = Input::get('proveedor_id');
					$servicio->conductor_id = Input::get('conductor_id');
					$servicio->vehiculo_id = Input::get('vehiculo_id');

					$servicio->fecha_servicio = Input::get('fecha_servicio');

					$servicio->hora_servicio = Input::get('hora_servicio');
					$servicio->resaltar = 0;
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
					$servicio->notificaciones_reconfirmacion = $code;
					$servicio->aceptado_app = 0;
					$servicio->hora_programado_app = date('Y-m-d H:i:s');
					$servicio->programado_app = 1;
					$servicio->serviciosaplicacion_id = Input::get('servicioaplicacion_id');
					$servicio->app_user_id = $servicioaplicacion->user_id;
					if(Sentry::getUser()->localidad==2){
						$servicio->localidad = 1;
					}

				if ($servicio->save()) {

					$servicioaplicacion->programado = 1;
					$servicioaplicacion->programado_fecha = date('Y-m-d H:i:s');
					$servicioaplicacion->servicio_id = $servicio->id;

					if ($servicioaplicacion->save()) {

						$message = 'Su servicio ha sido programado satisfactoriamente, el conductor '.ucwords(strtolower($servicio->conductor->nombre_completo)).' será el encargado de realizar su servicio del dia '.$servicio->fecha_servicio.' '.$servicio->hora_servicio.', el modelo y las placas del vehiculo son las siguientes: '.ucwords(strtolower($servicio->vehiculo->marca)).' '.ucwords(strtolower($servicio->vehiculo->modelo)).' '.$servicio->vehiculo->placa.', gracias por confiar en nosotros.';

						$number_random = rand(1000000, 9999999);

						$result = null;

						if ($notificacion_cliente==1) {
							$result = Servicio::Actionbutton($servicio->id, $servicioaplicacion->user_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->conductor->nombre_completo, $servicio->vehiculo->marca, $servicio->vehiculo->modelo, $servicio->vehiculo->placa);
						}

						if ($notificacion_conductor==1) {
							Servicio::enviarNotificaciones($servicio->conductor_id, $servicio->fecha_servicio, $servicio->hora_servicio, $servicio->recoger_en, $servicio->dejar_en, $number_random, $servicio->id);
						}

						/*Actualizar Notificador de AUTONET*/
						$idpusher = "578229";
						$keypusher = "a8962410987941f477a1";
						$secretpusher = "6a73b30cfd22bc7ac574";

						//CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
						$channel = 'servicios';
						$name = 'mobile';

						$sin_tarifa = Servicioaplicacion::sintarifa()->count();
						$pagados = Servicioaplicacion::pagados()->count();
						$empresarial = Servicioaplicacion::Pagofacturacion()->count();
						$cancelados = Servicio::canceladoapp()->count();

						$data = json_encode([
							'sin_tarifa' => $sin_tarifa,
							'cancelados' => $cancelados,
							'empresarial' => $empresarial,
							'pagados' => $pagados
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

						return Response::json([
							'response' => true,
							'servicio_id' => $servicio->id,
							'result' => $result
						]);

					}

				}

			}

		}

	}

	public function postAgregarnovedad(){

		$rules = [
			'detalle' => 'required',
			'valor' => 'required|numeric',
			'servicio_id' => 'required'
		];

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {

			return Response::json([
				'response' => false,
				'errores' => $validator->messages()
			]);

		}else {

			$servicio_aplicacion = Servicioaplicacion::find(Input::get('servicio_id'));
			$detalle = strtoupper(strtolower(trim(Input::get('detalle'))));
			$valor = strtoupper(strtolower(trim(Input::get('valor'))));

			if ($servicio_aplicacion->novedades==null) {

				$novedades = [];

				$array = [
					'detalle' => $detalle,
					'valor' => $valor
				];

				array_push($novedades, $array);

				$servicio_aplicacion->novedades = json_encode($novedades);

			}else {

				$novedades = json_decode($servicio_aplicacion->novedades);

				$array = [
					'detalle' => $detalle,
					'valor' => $valor
				];

				array_push($novedades, $array);

				$servicio_aplicacion->novedades = json_encode($novedades);

			}

			if ($servicio_aplicacion->save()) {

				return Response::json([
					'response' => true,
					'servicio_id' => $servicio_aplicacion->id,
					'novedad' => [
						'detalle' => $detalle,
						'valor' => $valor
					],
					'cantidad' => count(json_decode($servicio_aplicacion->novedades))
				]);

			}

		}

	}

	public function postVernovedad(){

		$rules = [
			'servicio_id' => 'required|numeric'
		];

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {

			return Response::json([
				'response' => false,
				'errores' => $validator->messages()
			]);

		}else {

			$servicio_aplicacion = Servicioaplicacion::find(Input::get('servicio_id'));

			if (count($servicio_aplicacion)) {

				return Response::json([
					'response' => true,
					'servicio_id' => $servicio_aplicacion->id,
					'novedades' => $servicio_aplicacion->novedades
				]);

			}

		}

	}

	public function postRemovernovedad(){

		$rules = [
			'servicio_id' => 'required',
			'index' => 'required'
		];

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {

			return Response::json([
				'response' => false,
				'errores' => $validator->messages()
			]);

		}else {

			$servicio_aplicacion = Servicioaplicacion::find(Input::get('servicio_id'));

			$novedades = json_decode($servicio_aplicacion->novedades);

			$i = 0;

			$array = [];

			for ($i=0; $i < count($novedades); $i++) {

				if ($i!=Input::get('index')) {
					array_push($array, $novedades[$i]);
				}

			}

			$servicio_aplicacion->novedades = json_encode($array);

			if($servicio_aplicacion->save()){

				return Response::json([
					'response' => true,
					'novedades' => $servicio_aplicacion->novedades
				]);

			}

		}

	}

	public function postRevisarnovedades(){

		$rules = [
			'servicio_id' => 'required|numeric',
			'valor_tarifa' => 'required|numeric'
		];

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {

			return Response::json([
				'response' => false,
				'errores' => $validator->messages()
			]);

		}else {

			$valor_tarifa = Input::get('valor_tarifa');

			$total_novedades = 0;
			$servicio_aplicacion = Servicioaplicacion::find(Input::get('servicio_id'));

			if ($servicio_aplicacion->novedades!=null) {
				$novedades = json_decode($servicio_aplicacion->novedades);
				foreach ($novedades as $novedad) {
					$total_novedades = $total_novedades+$novedad->valor;
				}
			}

			$subtotal = $valor_tarifa+$total_novedades;
			$comision = $subtotal*0.0349+900;
			$comision_iva = $comision*0.19;
			$total = $subtotal+$comision+$comision_iva;

			return Response::json([
				$servicio_aplicacion,
				'response' => true,
				'valor_tarifa' => number_format($valor_tarifa),
				'subtotal' => number_format($subtotal),
				'total_novedades' => number_format($total_novedades),
				'comision' => number_format($comision),
				'comision_iva' => number_format($comision_iva),
				'total' => number_format($total)
			]);

		}

	}

	public function postLiquidarnovedades(){

		$rules = [
			'servicio_id' => 'required|numeric',
			'valor_tarifa' => 'required|numeric'
		];

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {

			return Response::json([
				'response' => false,
				'errores' => $validator->messages()
			]);

		}else {

			$servicio_aplicacion = Servicioaplicacion::find(Input::get('servicio_id'));
			$servicio_aplicacion->fecha_liquidacion = date('Y-m-d H:i:s');
			$servicio_aplicacion->liquidacion_para_pago = 1;
			$servicio_aplicacion->pago_pendiente = 1;
			$servicio_aplicacion->valor = Input::get('valor_tarifa');

			if ($servicio_aplicacion->save()) {

				$message = 'El servicio del dia: '.$servicio_aplicacion->servicio->fecha_servicio.' y hora: '.$servicio_aplicacion->servicio->hora_servicio.' esta disponible para pago, entra al listado de pagos para cancelar el servicio';

				$data = [
					'body' => $message,
					'message' => $message,
					'title' => 'Aotour Mobile',
					'notId' => rand(1000000, 9999999),
					'vibrationPattern' => [2000, 1000, 500, 500],
					'soundname' => 'default',
					'click-action' => 'realizar_pago',
					'actions' => [
						[
							'icon' => 'realizarPago',
							'title' => 'PAGAR',
							'callback' => 'realizarPago',
							'foreground' => true,
							'force-start' => 1
						]
					],
					'servicio_id' => $servicio_aplicacion->id,
					'subtitle' => 'Servicio tarifado'
				];

				$result = Servicio::actionButton($servicio_aplicacion->user_id, $data);

				return Response::json([
					'response' => true,
					'result' => $result
				]);

			}

		}

	}

	public function postVerliquidacion(){

		$rules = [
			'servicio_id' => 'required'
		];

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {

			return Response::json([
				'response' => false,
				'errores' => $validator->messages()
			]);

		}else {

			$servicio_aplicacion = Servicioaplicacion::find(Input::get('servicio_id'));

			$total_novedades = 0;

			if ($servicio_aplicacion->novedades!=null) {
				$novedades = json_decode($servicio_aplicacion->novedades);
				foreach ($novedades as $novedad) {
					$total_novedades = $total_novedades+$novedad->valor;
				}
			}

			$servicio_aplicacion['subtotal'] = $servicio_aplicacion->valor+$total_novedades;
			$servicio_aplicacion['total_novedades'] = $total_novedades;
			$servicio_aplicacion['comision'] = $servicio_aplicacion['subtotal']*0.0349+900;
			$servicio_aplicacion['comision_iva'] = $servicio_aplicacion['comision']*0.19;
			$servicio_aplicacion['total'] = round($servicio_aplicacion['subtotal']+$servicio_aplicacion['comision']+$servicio_aplicacion['comision_iva']);

			if (count($servicio_aplicacion)) {

				return Response::json([
					'response' => true,
					'servicio_aplicacion' => $servicio_aplicacion
				]);

			}

		}

	}

	public function postVerestadopago(){

		$rules = [
			'pago_servicio_id' => 'required|numeric'
		];

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {

			return Response::json([
				'response' => false,
				'errores' => $validator->messages()
			]);

		}else {

			$pago_servicio = Pagoservicio::where('id', Input::get('pago_servicio_id'))->first();

			return Response::json([
				'response' => true,
				'pago_servicio' => $pago_servicio
			]);

			/** Sandbox
			 *  $ApiKey = '4Vj8eK4rloUd272L48hsrarnUA';
 			 *	$ApiLogin = 'pRRXKOl8ikMmt9u';
 			 *  $apiUrl = 'https://sandbox.api.payulatam.com/reports-api/4.0/service.cgi';
			 */

			/*$ApiKey = 'jrBeGBFOFoP1CZtJPPBeiS4YOe';
			$ApiLogin = 'O1TNwadJmZqxU5x';
			$apiUrl = 'https://api.payulatam.com/reports-api/4.0/service.cgi';


			$data = [
			   'test' => true,
			   'language' => 'en',
			   'command' => 'ORDER_DETAIL',
			   'merchant' => [
			      'apiLogin' => $ApiLogin,
			      'apiKey' => $ApiKey
			   ],
			   'details' => [
			      'orderId' => $pago_servicio->order_id
			   ]
			];

			$headers = [
        'Accept: application/json',
        'Content-Type: application/json'
      ];

      $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      $response = json_decode(curl_exec($ch));
      curl_close($ch);

			$transactions = $response->result->payload->transactions;

			if (count($pago_servicio)) {

				return Response::json([
					'response' => true,
					'transactions' => $transactions
				]);

			}*/

		}

	}

}
