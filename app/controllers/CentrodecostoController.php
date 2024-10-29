<?php

class CentrodecostoController extends BaseController{

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

		if (isset($permisos->administrativo->centros_de_costo->ver)){
			$ver = $permisos->administrativo->centros_de_costo->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$centrosdecosto = DB::table('centrosdecosto')
			->select('asesor_comercial.nombre_completo','asesor_comercial.id','centrosdecosto.id','centrosdecosto.nit','centrosdecosto.codigoverificacion','centrosdecosto.razonsocial',
							 'centrosdecosto.tipoempresa','centrosdecosto.direccion','centrosdecosto.ciudad','centrosdecosto.departamento','centrosdecosto.email','centrosdecosto.telefono',
							 'centrosdecosto.asesor_comercial','centrosdecosto.inactivo','centrosdecosto.inactivo_total')
			->leftJoin('asesor_comercial','centrosdecosto.asesor_comercial','=','asesor_comercial.id')
			->orderBy('razonsocial')->get();

			$asesor_comercial = DB::table('asesor_comercial')->orderBy('nombre_completo')->get();
			$departamentos = DB::table('departamento')->get();

			return View::make('parametros.centrodecosto')
				->with([
					'departamentos'=>$departamentos,
				    'centrosdecosto'=>$centrosdecosto,
				    'asesor_comercial'=>$asesor_comercial,
					'i'=>1,
					'permisos'=>$permisos
				]);
		}
	}

	public function getSiigo(){

		if (Sentry::check()) {
			$id_rol = Sentry::getUser()->id_rol;
			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
			$permisos = json_decode($permisos);
		}else{
			$id_rol = null;
			$permisos = null;
			$permisos = null;
		}

		if (isset($permisos->administrativo->centros_de_costo->ver)){
			$ver = $permisos->administrativo->centros_de_costo->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$centrosdecosto = DB::table('centrosdecosto')
			->whereNull('estado_siigo')
			->get();

			/*->select('asesor_comercial.nombre_completo','asesor_comercial.id','centrosdecosto.id','centrosdecosto.nit','centrosdecosto.codigoverificacion','centrosdecosto.razonsocial',
							 'centrosdecosto.tipoempresa','centrosdecosto.direccion','centrosdecosto.ciudad','centrosdecosto.departamento','centrosdecosto.email','centrosdecosto.telefono',
							 'centrosdecosto.asesor_comercial','centrosdecosto.inactivo','centrosdecosto.inactivo_total', 'centrosdecosto.valor_metro', 'centrosdecosto.valor_metro_m', 'centrosdecosto.valor_metro_d', 'centrosdecosto.localidad')
			->leftJoin('asesor_comercial','centrosdecosto.asesor_comercial','=','asesor_comercial.id')
			//->where('centrosdecosto.id',287)
			->orderBy('razonsocial')->get();*/

			$asesor_comercial = DB::table('asesor_comercial')->orderBy('nombre_completo')->get();
			$departamentos = DB::table('departamento')->get();

			return View::make('parametros.siigo')
				->with([
					'departamentos'=>$departamentos,
				    'centrosdecosto'=>$centrosdecosto,
				    'asesor_comercial'=>$asesor_comercial,
					'i'=>1,
					'permisos'=>$permisos
				]);
		}
	}

	public function getSubsiigo(){

		if (Sentry::check()) {
			$id_rol = Sentry::getUser()->id_rol;
			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
			$permisos = json_decode($permisos);
		}else{
			$id_rol = null;
			$permisos = null;
			$permisos = null;
		}

		if (isset($permisos->administrativo->centros_de_costo->ver)){
			$ver = $permisos->administrativo->centros_de_costo->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$subcentrosdecosto = DB::table('subcentrosdecosto')
			->whereNull('estado_siigo')
			->get();

			$asesor_comercial = DB::table('asesor_comercial')->orderBy('nombre_completo')->get();
			$departamentos = DB::table('departamento')->get();

			return View::make('parametros.subsiigo')
				->with([
					'departamentos'=>$departamentos,
				    'subcentrosdecosto'=>$subcentrosdecosto,
				    'asesor_comercial'=>$asesor_comercial,
					'i'=>1,
					'permisos'=>$permisos
				]);
		}
	}

	public function getTarifasporkilometraje(){

		if (Sentry::check()) {
			$id_rol = Sentry::getUser()->id_rol;
			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
			$permisos = json_decode($permisos);
		}else{
			$id_rol = null;
			$permisos = null;
			$permisos = null;
		}

		if (isset($permisos->administrativo->centros_de_costo->ver)){
			$ver = $permisos->administrativo->centros_de_costo->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$centrosdecosto = DB::table('centrosdecosto')
			->select('asesor_comercial.nombre_completo','asesor_comercial.id','centrosdecosto.id','centrosdecosto.nit','centrosdecosto.codigoverificacion','centrosdecosto.razonsocial',
							 'centrosdecosto.tipoempresa','centrosdecosto.direccion','centrosdecosto.ciudad','centrosdecosto.departamento','centrosdecosto.email','centrosdecosto.telefono',
							 'centrosdecosto.asesor_comercial','centrosdecosto.inactivo','centrosdecosto.inactivo_total', 'centrosdecosto.valor_metro', 'centrosdecosto.valor_metro_m', 'centrosdecosto.valor_metro_d', 'centrosdecosto.localidad')
			->leftJoin('asesor_comercial','centrosdecosto.asesor_comercial','=','asesor_comercial.id')
			//->where('centrosdecosto.id',287)
			->orderBy('razonsocial')->get();

			$asesor_comercial = DB::table('asesor_comercial')->orderBy('nombre_completo')->get();
			$departamentos = DB::table('departamento')->get();

			return View::make('parametros.tarifas_km')
				->with([
					'departamentos'=>$departamentos,
				    'centrosdecosto'=>$centrosdecosto,
				    'asesor_comercial'=>$asesor_comercial,
					'i'=>1,
					'permisos'=>$permisos
				]);
		}
	}

	/**
	 * @desc FUNCION QUE SIRVE PARA CREAR UN CENTRO DE COSTO
	 * @return true, false or relogin
     */
	public function postNuevocentro(){

		if (!Sentry::check()){

				return Response::json([
					'respuesta'=>'relogin'
				]);

		}else{

			if(Request::ajax()){

				$credito = intval(Input::get('credito'));

				$validaciones = [
					'tipo_cliente'=>'required|numeric',
					'nit'=>'required|numeric',
					'digitoverificacion'=>'required',
					'razonsocial'=>'required|letrasnumerosyespacios|unique:centrosdecosto',
					'tipoempresa'=>'required|select',
					'direccion'=>'required',
					'departamento'=>'required|sololetrasyespacio',
					'ciudad'=>'required|sololetrasyespacio',
					'email'=>'required|email',
					'telefono'=>'required',
					'asesorcomercial'=>'required|numeric',
					'credito'=>'not_in:0',
					'tipo_cliente2'=>'required',
					'localidad'=>'required|select'
				];

				$mensajes = [
					'nit.required'=>'El campo nit es requerido',
					'nit.numeric'=>'El campo nit debe ser numerico',
					'digitoverificacion.required'=>'El campo digito verificacion es requerido',
					'razonsocial.letrasnumerosyespacios'=>'El campo razon social solo debe contener letras numeros y espacios',
					'razonsocial.required'=>'El campo razon social es requerido',
					'direccion.required'=>'El campo direccion es requerido',
					'email.required'=>'El campo email es requerido',
					'telefono.required'=>'El campo telefono es requerido',
					'tipoempresa.select'=>'Debe seleccionar el tipo de empresa',
					'ciudad.sololetrasyespacio'=>'Debe seleccionar un campo de ciudad',
					'departamento.sololetrasyespacio'=>'Debe seleccionar un campo de departamento',
					'credito.not_in'=>'Debe seleccionar el campo credito',
					'tipo_cliente2.required'=>'Debe seleccionar la localidad',
					'localidad.select'=>'Debe seleccionar la localidad'
				];

				$plazo = null;

				if($credito===1){
					$validaciones['plazo_pago'] = 'required|numeric';
					$mensajes['plazo_pago.required'] = 'Debe digitar un plazo de pago';
					$mensajes['plazo_pago.numeric'] = 'El plazo de pago debe ser un valor numerico';
					$plazo = Input::get('plazo_pago');
				}

				$validador = Validator::make(Input::all(), $validaciones,$mensajes);

				if ($validador->fails())
				{
					return Response::json([
						'mensaje'=>false,
						'errores'=>$validador->errors()->getMessages()
					]);

				}else{

					$contribuyente = Input::get('contribuyente');
					$direccion_siigo = Input::get('direccion');

					$first_name_siigo = Input::get('first_name_siigo');
					$last_name_siigo = Input::get('last_name_siigo');
					$email_siigo = Input::get('email_siigo');


					//$ciudad = Input::get('ciudad');
					//$state_name = Input::get('state_name');
					$state_code = Input::get('state_code');
					$country_code = Input::get('country_code');
					//$country_name = Input::get('country_name');
					$id_ciudad = Input::get('id_ciudad');

					$rut = Input::get('rut');

					if (Input::hasFile('rut')){

			          $file_pdf = Input::file('rut');
			          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

			          $ubicacion_pdf = 'biblioteca_imagenes/clientes/rut/';
			          $file_pdf->move($ubicacion_pdf, Input::get('nit').$name_pdf);
			          $rutpdf = Input::get('nit').$name_pdf;



			        }else{
			          $test = 0;
			          $rutpdf = null;
			        }

			        /*return Response::json([
						'mensaje'=>false,
						'test' => $test,
					]);*/

					//Siigo
					/*$ch = curl_init();

					curl_setopt($ch, CURLOPT_URL, "https://private-anon-42d6253761-siigoapi.apiary-proxy.com/v1/customers");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($ch, CURLOPT_HEADER, FALSE);

					curl_setopt($ch, CURLOPT_POST, TRUE);

					curl_setopt($ch, CURLOPT_POSTFIELDS, "{
					  \"type\": \"Customer\",
					  \"person_type\": \"Company\",
					  \"id_type\": \"31\",
					  \"identification\": \"".Input::get('nit')."\",
					  \"check_digit\": \"".Input::get('digitoverificacion')."\",
					  \"name\": [
					    \"". Input::get('razonsocial') ."\"
					  ],
					  \"commercial_name\": \"". Input::get('razonsocial') ."\",
					  \"branch_office\": 0,
					  \"active\": true,
					  \"vat_responsible\": false,
					  \"fiscal_responsibilities\": [
					    {
					      \"code\": \"".$contribuyente."\"
					    }
					  ],
					  \"address\": {
					    \"address\": \"".$direccion_siigo."\",
					    \"city\": {
					      \"country_code\": \"".$country_code."\",
					      \"state_code\": \"".$state_code."\",
					      \"city_code\": \"".$id_ciudad."\"
					    },
					  },
					  \"phones\": [
					    {
					      \"number\": \"".Input::get('telefono')."\",
					    }
					  ],
					  \"contacts\": [
					    {
					      \"first_name\": \"".$first_name_siigo."\",
					      \"last_name\": \"".$last_name_siigo."\",
					      \"email\": \"".$email_siigo."\",

					    }
					  ],

					}");

					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					  "Content-Type: application/json",
					  "Authorization: ".SiigoController::TOKEN_SIIGO.""
					));

					$response = curl_exec($ch);
					curl_close($ch);*/
					//Siigo

					/*return Response::json([
						'mensaje'=>false,
						'response' => json_decode($response),
						'digit' => Input::get('digitoverificacion')
					]);*/

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
					//$centrodecosto->id_siigo = json_decode($response)->id;
					//$centrodecosto->rut = $rutpdf;
					$centrodecosto->tipo_cliente = $tipo_cliente;
					$centrodecosto->nit = $nit;
					$centrodecosto->codigoverificacion = $digito;
					$centrodecosto->razonsocial = $razonsocial;
					$centrodecosto->tipoempresa = $tipoempresa;
					$centrodecosto->direccion = $direccion;
					$centrodecosto->ciudad = $ciudad;
					$centrodecosto->departamento = $departamento;
					$centrodecosto->email = $email;
					$centrodecosto->telefono = $telefono;
					$centrodecosto->asesor_comercial = Input::get('asesorcomercial');
					$centrodecosto->credito = $credito;
					$centrodecosto->plazo_pago = $plazo;
					$centrodecosto->localidad = $localidad;
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

					//$centrodecosto->nombres_contacto = strtoupper($first_name_siigo);
					//$centrodecosto->apellidos_contacto = strtoupper($last_name_siigo);
					//$centrodecosto->correo_contacto = strtoupper($email_siigo);
					//$centrodecosto->id_ciudad = $id_ciudad;
					//$centrodecosto->state_code = $state_code;
					//$centrodecosto->country_code = $country_code;
					//$centrodecosto->contribuyente = $contribuyente;

					if($centrodecosto->save()){

						//
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
						//
						/*Email a Contabilidad
			            $email = 'contabilidad@aotour.com.co';
									$email = 'sistemas@aotour.com.co';
			            if($email){

			              $data = [
			                'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
			                'cliente' => $razonsocial,
											'link' => 'siigo'
			              ];

			              Mail::send('emails.cliente_creado', $data, function($message) use ($email){
			                $message->from('no-reply@aotour.com.co', 'AUTONET');
			                $message->to($email)->subject('Notificaciones Aotour');
			                $message->cc('aotourdeveloper@gmail.com');
			              });
			            }
						Email a Contabilidad*/
						return Response::json([
							'mensaje'=>true,
							'respuesta'=>'Registro guardado correctamente!'
						]);
					}
				}
			}
		}
	}

	public function postGenerarcliente() {

		if(Request::ajax()){

			$id = Input::get('id');

			$consulta = DB::table('centrosdecosto')
			->where('id',$id)
			->first();

			if($consulta){

				$nit = $consulta->nit;
				$digito = $consulta->codigoverificacion;
				$razonsocial = $consulta->razonsocial;
				$contribuyente = $consulta->contribuyente;
				$direccion_siigo = $consulta->direccion;
				$country_code = $consulta->country_code;
				$state_code = $consulta->state_code;
				$id_ciudad = $consulta->id_ciudad;
				$telefono = $consulta->telefono;
				$first_name_siigo = $consulta->nombres_contacto;
				$last_name_siigo = $consulta->apellidos_contacto;
				$email_siigo = $consulta->correo_contacto;

				//Siigo
				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, "https://private-anon-3207d9563d-siigoapi.apiary-proxy.com/v1/customers");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_HEADER, FALSE);

				curl_setopt($ch, CURLOPT_POST, TRUE);

				curl_setopt($ch, CURLOPT_POSTFIELDS, "{
				  \"type\": \"Customer\",
				  \"person_type\": \"Company\",
				  \"id_type\": \"31\",
				  \"identification\": \"".$nit."\",
				  \"check_digit\": \"".$digito."\",
				  \"name\": [
				    \"". $razonsocial ."\"
				  ],
				  \"commercial_name\": \"". $razonsocial ."\",
				  \"branch_office\": 0,
				  \"active\": true,
				  \"vat_responsible\": false,
				  \"fiscal_responsibilities\": [
				    {
				      \"code\": \"".$contribuyente."\"
				    }
				  ],
				  \"address\": {
				    \"address\": \"".$direccion_siigo."\",
				    \"city\": {
				      \"country_code\": \"".$country_code."\",
				      \"state_code\": \"".$state_code."\",
				      \"city_code\": \"".$id_ciudad."\"
				    },
				  },
				  \"phones\": [
				    {
				      \"number\": \"".$telefono."\",
				    }
				  ],
				  \"contacts\": [
				    {
				      \"first_name\": \"".$first_name_siigo."\",
				      \"last_name\": \"".$last_name_siigo."\",
				      \"email\": \"".$email_siigo."\",

				    }
				  ],

				}");

				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				  "Content-Type: application/json",
				  "Authorization: ".SiigoController::TOKEN_SIIGO.""
				));

				$response = curl_exec($ch);
				curl_close($ch);
				//Siigo

				/*return Response::json([
					'mensaje'=>false,
					'response' => json_decode($response),
					'digit' => Input::get('digitoverificacion')
				]);*/

				$consulta = DB::table('centrosdecosto')
				->where('id',$id)
				->update([
					'estado_siigo' => 1,
					'id_siigo' => json_decode($response)->id
				]);

				return Response::json([
					'mensaje' => true
				]);

			}else{

				return Response::json([
					'mensaje' => false,
					'centrodecosto' => $consulta
				]);

			}
		}
	}

	/**
	 * @desc funcion para editar los centros de costo
	 * @return true, false o relogin
	 */
	public function postActualizarcentro(){

		if (!Sentry::check())
		{
			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else {

			if(Request::ajax()){

				$validaciones = [
					'nit'=>'required|numeric',
					'digitoverificacion'=>'required|numeric|digits:1',
					'razonsocial'=>'required|letrasnumerosyespacios',
					'tipoempresa'=>'required|select',
					'direccion'=>'required',
					'departamento'=>'required|sololetrasyespacio',
					'ciudad'=>'required|sololetrasyespacio',
					'email'=>'required|email',
				];

				$plazo_pago = null;

				$mensajes = [
					'digitoverificacion.required'=>'El campo digito verificacion es requerido',
					'digitoverificacion.numeric'=>'El campo digito verificacion debe ser un numero',
					'digitoverificacion.digits'=>'El campo digito verificacion debe ser de 1 digito',
					'razonsocial.letrasnumerosyespacios'=>'El campo razon social solo debe contener letras numeros y espacios',
					'razonsocial.required'=>'El campo razon social es requerido',
					'tipoempresa.select'=>'Debe seleccionar el tipo de empresa',
					'ciudad.sololetrasyespacio'=>'Debe seleccionar un campo de ciudad',
					'departamento.sololetrasyespacio'=>'Debe seleccionar un campo de ciudad',

				];

				$credito = intval(Input::get('credito'));

				if($credito===1){
					$validaciones['plazo_pago'] = 'required|numeric';
					$mensajes['plazo_pago.required'] = 'Debe digitar un plazo de pago';
					$mensajes['plazo_pago.numeric'] = 'El plazo de pago debe ser un valor numerico';
					$plazo_pago = Input::get('plazo_pago');
				}

				$validador = Validator::make(Input::all(), $validaciones,$mensajes);

				if ($validador->fails()){

					return Response::json([
						'mensaje'=>false,
						'errores'=>$validador->errors()->getMessages()
					]);

				}else{

					$centrodecosto = Centrodecosto::find(Input::get('id'));
					$centrodecosto->nit = Input::get('nit');
					$centrodecosto->codigoverificacion = Input::get('digitoverificacion');
					$centrodecosto->razonsocial = Input::get('razonsocial');
					$centrodecosto->tipoempresa = Input::get('tipoempresa');
					$centrodecosto->direccion = Input::get('direccion');
					$centrodecosto->ciudad = Input::get('ciudad');
					$centrodecosto->departamento = Input::get('departamento');
					$centrodecosto->email = Input::get('email');
					$centrodecosto->telefono = Input::get('telefono');
					$centrodecosto->asesor_comercial = Input::get('asesor_comercial');
					$centrodecosto->credito = $credito;
					$centrodecosto->plazo_pago = $plazo_pago;

					if($centrodecosto->save()){


						return Response::json([
							'mensaje'=>true,
							'respuesta'=>'Registro guardado correctamente!'
						]);
					};
				}

			}
		}
	}

	public function postActualizarcentrokm(){

		if (!Sentry::check())
		{
			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else {

			if(Request::ajax()){

				$centrodecosto = Centrodecosto::find(Input::get('id'));
				$centrodecosto->valor_metro = Input::get('valor_metro');
				$centrodecosto->valor_metro_m = Input::get('valor_metro_m');
				$centrodecosto->valor_metro_d = Input::get('valor_metro_d');

				if($centrodecosto->save()){

					return Response::json([
						'mensaje'=>true,
						'respuesta'=>'Registro guardado correctamente!'
					]);
				};
			}
		}
	}

	/**
	 * @desc Sirve para bloquear los centros de costo
	 * @return true, false or relogin
	 */
	public function postBloqueo(){

		if (!Sentry::check()){
			return Response::json([
				'respuesta'=>'relogin'
			]);
		}else {

			if (Request::ajax()) {

				$id = Input::get('id');
				$option = Input::get('option');



				$centrodecosto = Centrodecosto::find($id);
				if($option==0):
					$inactivo = Input::get('inactivo');
					if ($inactivo==1):
						$centrodecosto->inactivo = null;
					else:
						$centrodecosto->inactivo = 1;
					endif;
				elseif($option==1):
					$inactivo_total = Input::get('inactivo_total');
					if ($inactivo_total==1):
						$centrodecosto->inactivo_total = null;
					else:
						$centrodecosto->inactivo_total = 1;
					endif;
				endif;

				if($centrodecosto->save()){
					return Response::json([
						'respuesta'=>true
					]);
				}
			}
		}

	}

	public function postNuevosubcentro(){

		if (!Sentry::check()){

			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else{

			if(Request::ajax()){

				$validaciones = [
					'nombresubcentro'=>'required',
					'nombre_contacto'=>'sololetrasyespacio',
					'email_contacto'=>'email',
					'telefono'=>'numeric|unique:subcentrosdecosto',
				];

				$validador = Validator::make(Input::all(), $validaciones);

				if ($validador->fails())
				{
					return Response::json([
						'mensaje'=>false,
						'errores'=>$validador->errors()->getMessages()
					]);

				}else{

					$subcentro = new Subcentro;
					$subcentro->nombresubcentro = Input::get('nombresubcentro');
					$subcentro->nombre_contacto = Input::get('nombre_contacto');
					$subcentro->cargo_contacto = Input::get('cargo_contacto');
					$subcentro->email_contacto = Input::get('email_contacto');
					$subcentro->celular = Input::get('celular');
					$subcentro->telefono = Input::get('telefono');
					$subcentro->centrosdecosto_id = Input::get('id');

					if($subcentro->save()){

						return Response::json([
							'mensaje'=>true,
							'respuesta'=>'Registro guardado correctamente!'
						]);
					};
				}
			}
		}
	}

	public function postVersubcentro(){

		if (!Sentry::check())
		{
			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else {

			if(Request::ajax()){

				$subcentro = DB::table('subcentrosdecosto')->where('id',Input::get('id'))->first();

				return Response::json([
					'respuesta' => true,
					'subcentro' => $subcentro
				]);

			}
		}
	}

	public function postActualizarsubcentro(){

		if (!Sentry::check())
		{
			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else {

			if(Request::ajax()){

				$validaciones = [
					'razonsocial'=>'required',
					'nombre_completo'=>'sololetrasyespacio',
					'cargo'=>'sololetrasyespacio',
					'email'=>'email',
					'celular'=>'numeric',
					'telefono'=>'numeric'
				];

				$validador = Validator::make(Input::all(), $validaciones);

				if ($validador->fails())
				{
					return Response::json([
						'mensaje'=>false,
						'errores'=>$validador->errors()->getMessages()
					]);

				}else{

					$subcentrodecosto = Subcentro::find(Input::get('id_subcentro'));
					$subcentrodecosto->nombresubcentro = Input::get('razonsocial');
					$subcentrodecosto->nombre_contacto = Input::get('nombre_completo');
					$subcentrodecosto->cargo_contacto = Input::get('cargo');
					$subcentrodecosto->email_contacto = Input::get('email');
					$subcentrodecosto->celular = Input::get('celular');
					$subcentrodecosto->telefono = Input::get('telefono');

				    if($subcentrodecosto->save()){
				    	return Response::json([
							'respuesta'=>true,
						]);
					};
				}

			}
		}
	}

	public function getSubcentrosdecosto($id){

		if (Sentry::check()) {
			$id_rol = Sentry::getUser()->id_rol;
			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
			$permisos = json_decode($permisos);
		}else{
			$id_rol = null;
			$permisos = null;
			$permisos = null;
		}

		if (isset($permisos->administrativo->centros_de_costo->ver)){
			$ver = $permisos->administrativo->centros_de_costo->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

		  $subcentrosdecosto = DB::table('subcentrosdecosto')
			->select('subcentrosdecosto.id','subcentrosdecosto.nombresubcentro','subcentrosdecosto.nombre_contacto','subcentrosdecosto.identificacion',
							 'subcentrosdecosto.cargo_contacto','subcentrosdecosto.email_contacto','subcentrosdecosto.celular','subcentrosdecosto.telefono',
							 'subcentrosdecosto.centrosdecosto_id','subcentrosdecosto.direccion','asesor_comercial.nombre_completo','terceros.nombre_completo as tnombre_completo')
			->leftJoin('asesor_comercial','subcentrosdecosto.asesor_comercial','=','asesor_comercial.id')
			->leftJoin('terceros','subcentrosdecosto.tercero','=','terceros.id')
			->where('centrosdecosto_id',$id)
			->orderBy('nombresubcentro')
			->get();
			$comercial = DB::table('asesor_comercial')->get();
			$terceros = DB::table('terceros')->get();
			$centrodecosto = DB::table('centrosdecosto')->where('id',$id)->first();
			$razon_social = $centrodecosto->razonsocial;

			$proveedores = DB::table('proveedores')->whereNull('inactivo')->get();

				return View::make('parametros.subcentrodecosto')
					->with([
					 'id'=>$id,
					 'centrodecosto'=>$centrodecosto,
					 'subcentrosdecosto'=>$subcentrosdecosto,
					 'i'=>1,
					 'razon_social'=>$razon_social,
					 'comercial'=>$comercial,
					 'terceros'=>$terceros,
					 'permisos'=>$permisos,
					 'proveedores' => $proveedores
					]);
		}

	}

	public function postNuevocontacto(){

		if (!Sentry::check())
		{
			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else {

			if(Request::ajax()){

				$validaciones = [
	                'nombre'=>'required',
	                'cargo'=>'required'
           		];

				$validador = Validator::make(Input::all(), $validaciones);

				if ($validador->fails()){

					return Response::json([
						'mensaje'=>false,
						'errores'=>$validador->errors()->getMessages()
					]);

				}else{

					$nuevo_contacto = new Contactodirecto;
					$nuevo_contacto->nombre = Input::get('nombre');
					$nuevo_contacto->cargo = Input::get('cargo');
					$nuevo_contacto->email = Input::get('email');
					$nuevo_contacto->celular = Input::get('celular');
					$nuevo_contacto->telefono = Input::get('telefono');
					$nuevo_contacto->centrosdecosto_id = Input::get('id_centro');

					if($nuevo_contacto->save()){

						return Response::json([
							'respuesta'=>true
						]);

					}
				}
			}
		}
	}

	public function postNuevocliente(){

		if (!Sentry::check()){
			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else {

			if(Request::ajax()){

				$validaciones = [
					//'nombre_completo'=>'required',
					'identificacion'=>'required|unique:subcentrosdecosto'
				];

				$validador = Validator::make(Input::all(), $validaciones);

				if ($validador->fails()){

					return Response::json([
						'mensaje'=>false,
						'errores'=>$validador->errors()->getMessages()
					]);

				}else{

					$direccion_siigo = Input::get('direccion_siigo');
					$first_name_siigo = Input::get('first_name_siigo');
					$last_name_siigo = Input::get('last_name_siigo');
					$email_siigo = Input::get('email_siigo');

					$ciudad = Input::get('ciudad');
					$state_name = Input::get('state_name');
					$state_code = Input::get('state_code');
					$country_code = Input::get('country_code');
					$country_name = Input::get('country_name');
					$id_ciudad = Input::get('id_ciudad');

					$nuevo_cliente = new Subcentro;
					//$nuevo_cliente->id_siigo = json_decode($response)->id;
					$nuevo_cliente->nombresubcentro = Input::get('first_name').' '.Input::get('last_name');
					$nuevo_cliente->identificacion = Input::get('identificacion');
					$nuevo_cliente->direccion = Input::get('direccion');
					$nuevo_cliente->email_contacto = Input::get('email');
					$nuevo_cliente->celular = Input::get('celular');
					$nuevo_cliente->telefono = Input::get('telefono');
					$nuevo_cliente->asesor_comercial = Input::get('asesor_comercial');
					$nuevo_cliente->tercero = Input::get('tercero');
					$nuevo_cliente->centrosdecosto_id = Input::get('id');

					//$nuevo_cliente->nombres_contacto = strtoupper($first_name_siigo);
					//$nuevo_cliente->apellidos_contacto = strtoupper($last_name_siigo);
					//$nuevo_cliente->correo_contacto = strtoupper($email_siigo);
					//$nuevo_cliente->id_ciudad = $id_ciudad;
					//$nuevo_cliente->ciudad = $ciudad;
					//$nuevo_cliente->state_code = $state_code;
					//$nuevo_cliente->country_code = $country_code;

					//Guardar datos de siigo en la tabla de subcentros

					if($nuevo_cliente->save()){

						/*Email a Contabilidad*/
            /*$email = 'contabilidad@aotour.com.co';
						$email = 'sistemas@aotour.com.co';
            if($email){

              $data = [
                'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
                'cliente' => $nuevo_cliente->nombresubcentro,
								'link' => 'subsiigo'
              ];

              Mail::send('emails.cliente_creado', $data, function($message) use ($email){
                $message->from('no-reply@aotour.com.co', 'AUTONET');
                $message->to($email)->subject('Notificaciones Aotour');
                $message->cc('aotourdeveloper@gmail.com');
              });
            }*/
						/*Email a Contabilidad*/

						return Response::json([
							'respuesta'=>true
						]);
					}

					return Response::json([
						'respuesta'=>false,
						'response' => json_decode($response)
					]);
				}
			}
		}
	}

	public function postGenerarclientesub() {

		if(Request::ajax()){

			$id = Input::get('id');

			$consulta = DB::table('subcentrosdecosto')
			->where('id',$id)
			->first();

			if($consulta){

				$identificacion = $consulta->identificacion;
				//$digito = $consulta->codigoverificacion;

				$test = explode(' ', $consulta->nombresubcentro);

				$longitud = count($test);

				if($longitud==4){

					$nombres = $test[0].' '.$test[1];
					$apellidos = $test[2].' '.$test[3];

				}else if($longitud==2){

					$nombres = $test[0];
					$apellidos = $test[1];

				}else if($longitud==3){

					$nombres = $test[0];
					$apellidos = $test[1].' '.$test[2];

				}else{

					$nombres = $test[0].' '.$test[1];
					$apellidos = $test[2].' '.$test[3];

				}

				/*return Response::json([
					'mensaje' => false,
					'test' => $test,
					'longitud' => $longitud,
					'nombres' => $nombres,
					'apellidos' => $apellidos
				]);*/

				//$contribuyente = $consulta->contribuyente;
				$direccion_siigo = $consulta->direccion;
				$country_code = $consulta->country_code;
				$state_code = $consulta->state_code;
				$id_ciudad = $consulta->id_ciudad;
				$telefono = $consulta->telefono;
				$first_name_siigo = $consulta->nombres_contacto;
				$last_name_siigo = $consulta->apellidos_contacto;
				$email_siigo = $consulta->correo_contacto;
				$celular = $consulta->celular;

				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, "https://private-anon-42d6253761-siigoapi.apiary-proxy.com/v1/customers");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_HEADER, FALSE);

				curl_setopt($ch, CURLOPT_POST, TRUE);

				curl_setopt($ch, CURLOPT_POSTFIELDS, "{
				  \"type\": \"Customer\",
				  \"person_type\": \"Person\",
				  \"id_type\": \"13\",
				  \"identification\": \"". $identificacion ."\",
				  \"check_digit\": \"4\",
				  \"name\": [
				    \"". $nombres ."\",
				    \"". $apellidos ."\"
				  ],
				  \"commercial_name\": \"". $nombres." ".$apellidos ."\",
				  \"branch_office\": 0,
				  \"active\": true,
				  \"vat_responsible\": false,
				  \"fiscal_responsibilities\": [
				    {
				      \"code\": \"R-99-PN\"
				    }
				  ],
				  \"address\": {
				    \"address\": \"".$direccion_siigo."\",
				    \"city\": {
				      \"country_code\": \"".$country_code."\",
				      \"state_code\": \"".$state_code."\",
				      \"city_code\": \"".$id_ciudad."\"
				    },
				  },
				  \"phones\": [
				    {
				      \"number\": \"". $celular ."\",
				    }
				  ],
				  \"contacts\": [
				    {
				      \"first_name\": \"".$first_name_siigo."\",
				      \"last_name\": \"".$last_name_siigo."\",
				      \"email\": \"".$email_siigo."\",

				    }
				  ],

				}");

				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				  "Content-Type: application/json",
				  "Authorization: ".SiigoController::TOKEN_SIIGO.""
				));

				$response = curl_exec($ch);
				curl_close($ch);

				/*return Response::json([
					'mensaje'=>false,
					'response' => json_decode($response),
					'digit' => Input::get('digitoverificacion')
				]);*/

				$consulta = DB::table('subcentrosdecosto')
				->where('id',$id)
				->update([
					'estado_siigo' => 1,
					'id_siigo' => json_decode($response)->id
				]);

				return Response::json([
					'mensaje' => true
				]);

			}else{

				return Response::json([
					'mensaje' => false,
					'centrodecosto' => $consulta
				]);

			}
		}
	}

	public function postEditarcliente(){

		if (!Sentry::check())
		{
			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else {

			if(Request::ajax()){

				$cliente = Subcentro::find(Input::get('id'));

				if($cliente!=null){

					return Response::json([
						'respuesta'=>true,
						'cliente'=>$cliente
					]);

				}

			}
		}
	}

	public function postActualizarcliente(){

		if (!Sentry::check()) {

			return Response::json([
				'respuesta'=>'relogin'
			]);

		} else {

			if (Request::ajax()) {

				$validaciones = [
					'id'=>'required',
					'nombre'=>'required',
					'identificacion'=>'required'
        ];

				$mensajes = [
					'nombre.required'=>'El campo nombre es requerido!',
					'identificacion.required'=>'El campo identificacion es requerido!'
				];

				$validador = Validator::make(Input::all(), $validaciones, $mensajes);

				if ($validador->fails()){

					return Response::json([
						'respuesta'=>false,
						'errores'=>$validador->errors()->getMessages()
					]);

				}else{

					$cliente = Subcentro::find(Input::get('id'));
					$cliente->nombresubcentro = Input::get('nombre');
					$cliente->identificacion = Input::get('identificacion');
					$cliente->direccion = Input::get('direccion');
					$cliente->telefono = Input::get('telefono');
					$cliente->celular = Input::get('celular');
					$cliente->email_contacto = Input::get('email');
					$cliente->asesor_comercial = Input::get('asesor_comercial');
					$cliente->tercero = Input::get('tercero');

					if ($cliente->save()) {
						return Response::json([
							'respuesta'=>true
						]);
					}

				}

			}
		}

	}

	public function postActualizarcontacto(){

		if (!Sentry::check())		{
			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else{

			if(Request::ajax()){

				$validaciones = [
					'nombre'=>'required',
					'cargo'=>'required'
	            ];



				$validador = Validator::make(Input::all(), $validaciones);

				if ($validador->fails())
				{
					return Response::json([
						'mensaje'=>false,
						'errores'=>$validador->errors()->getMessages()
					]);

				}else{


					$contactos = Contactodirecto::find(Input::get('id'));
					$contactos->nombre = Input::get('nombre');
					$contactos->cargo = Input::get('cargo');
					$contactos->email = Input::get('email');
					$contactos->celular = Input::get('celular');
					$contactos->telefono = Input::get('telefono');

					if ($contactos->save()) {
						return Response::json([
							'respuesta'=>true
						]);
					}
				}

			}

		}
	}

	public function postContactos(){

		if (!Sentry::check())
		{
			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else{

			if (Request::ajax()) {

				$id = Input::get('id');
				$contactos = DB::table('contactos_directos')->where('centrosdecosto_id',$id)->get();
				return Response::json([
					'mensaje'=>true,
					'respuesta'=>$contactos
				]);

			}

		}
	}

	public function postDetalles(){

		if (!Sentry::check()){

			return Response::json([
				'mensaje'=>'relogin'
			]);

		}else{

			if (Request::ajax()) {

				$centrosdecosto = DB::table('centrosdecosto')->where('id',Input::get('id'))->first();

				if ($centrosdecosto!=null):
					return Response::json([
						'mensaje'=>true,
						'respuesta'=>$centrosdecosto
					]);
				endif;
			}
		}
	}

	public function postDetallesvalores(){

		if (!Sentry::check()){

			return Response::json([
				'mensaje'=>'relogin'
			]);

		}else{

			if (Request::ajax()) {

				$centrosdecosto = DB::table('centrosdecosto')->where('id',Input::get('id'))->first();

				if ($centrosdecosto!=null):
					return Response::json([
						'mensaje'=>true,
						'respuesta'=>$centrosdecosto
					]);
				endif;
			}
		}
	}

	//TARIFAS Y RUTAS DE CENTROS DE COSTO
	public function getTarifas($id){

		if (!Sentry::check())
		{
			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else {

			$centrosdecosto = DB::table('centrosdecosto')->where('id', $id)->first();
			$rutas = DB::table('rutas')->where('centrosdecosto_id',$id)->orderBy('codigo_ruta')->get();
			return View::make('parametros.tarifas')->with([
				'rutas'=>$rutas,
				'centrosdecosto'=>$centrosdecosto,
		        'i'=>1
			]);
		}
	}

	public function postExportar(){

		if (!Sentry::check()){

			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else{

			if(Request::ajax()){

				//TRAE LOS DATOS DE LA TABLA GENERAL
			    $ruta_exportar = DB::table('ruta_general')->get();

			    if($ruta_exportar!=null){


					//TRAE EL NOMBRE DEL CENTRO DE COSTO
				    $centrodecosto = DB::table('centrosdecosto')->where('id',Input::get('id'))->pluck('razonsocial');


				    //DIVIDE EL NOMBRE DEL CENTRO DE COSTO EN VARIAS PARTES SEGUN ESPACIOS
				    $letras = explode(' ', $centrodecosto);

				    $letras_codigo ='';
				    $letras_final = '';

				    //LETRAS DEL CENTRO DE COSTO

		 			$o=1;

				    for ($i=0; $i < count($letras); $i++) {
				    	$letras_codigo .= $letras[$i][0];
				    	$o++;
				    }

				    //EXTRAE LOS DOS PRIMEROS CARACTERES DE LA CADENA
				    $letra_codigo = substr($letras_codigo, 0,2);

				    //RECORRE LOS DATOS DE LA TABLA GENERAL

				    foreach ($ruta_exportar as $ruta) {

				    	$rutat = new Rutat;
				    	if(strlen($ruta->id)===1){
				    		$rutat->codigo_ruta = $letra_codigo.'0'.$ruta->id;
				    	}elseif (strlen($ruta->id)===2) {
				    		$rutat->codigo_ruta = $letra_codigo.$ruta->id;
				    	}

				    	$rutat->nombre_ruta = $ruta->nombre_ruta;
				    	$rutat->descripcion_ruta = $ruta->descripcion_ruta;
				    	$rutat->tarifa_cliente_van = $ruta->tarifa_cliente_van;
				    	$rutat->tarifa_proveedor_van = $ruta->tarifa_proveedor_van;
						$rutat->tarifa_cliente_bus = $ruta->tarifa_cliente_bus;
						$rutat->tarifa_proveedor_bus = $ruta->tarifa_proveedor_bus;
						$rutat->tarifa_cliente_automovil = $ruta->tarifa_cliente_automovil;
						$rutat->tarifa_proveedor_automovil = $ruta->tarifa_proveedor_automovil;
						$rutat->tarifa_cliente_buseta = $ruta->tarifa_cliente_buseta;
						$rutat->tarifa_proveedor_buseta = $ruta->tarifa_proveedor_buseta;
						$rutat->tarifa_cliente_minivan = $ruta->tarifa_cliente_minivan;
						$rutat->tarifa_proveedor_minivan = $ruta->tarifa_proveedor_minivan;
				    	$rutat->centrosdecosto_id = Input::get('id');
				    	$rutat->creado_por = Sentry::getUser()->id;
				    	$rutat->save();

				    }

					return Response::json(['respuesta'=>true]);


			    }else{

			    	return Response::json([
			    		'respuesta'=>false,
			    		'mensaje'=>'No hay rutas para exportar'
			    	]);

			    }

	     	}

		}
	}

	public function postRutanueva(){

		if (!Sentry::check()){

			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else{

			if(Request::ajax()){

				$validaciones = [
				    'codigo'=>'required',
	                'nombre'=>'required',
	                'van_cliente'=>'numeric',
	                'van_proveedor'=>'numeric',
	                'bus_cliente'=>'numeric',
	                'bus_proveedor'=>'numeric',
	                'automovil_cliente'=>'numeric',
	                'automovil_proveedor'=>'numeric',
	                'buseta_cliente'=>'numeric',
	                'buseta_proveedor'=>'numeric',
					'minivan_cliente'=>'numeric',
					'minivan_proveedor'=>'numeric',
					'centrodecosto_id'=>'required'
           		];

				$validador = Validator::make(Input::all(), $validaciones);

				if ($validador->fails()){

					return Response::json([
						'mensaje'=>false,
						'errores'=>$validador->errors()->getMessages()
					]);

				}else{

					$ruta = new Rutat;
					$ruta->codigo_ruta = Input::get('codigo');
					$ruta->nombre_ruta = Input::get('nombre');
					$ruta->descripcion_ruta = Input::get('descripcion');
					$ruta->tarifa_cliente_van = Input::get('van_cliente');
					$ruta->tarifa_proveedor_van = Input::get('van_proveedor');
					$ruta->tarifa_cliente_bus = Input::get('bus_cliente');
					$ruta->tarifa_proveedor_bus = Input::get('bus_proveedor');
					$ruta->tarifa_cliente_automovil = Input::get('automovil_cliente');
					$ruta->tarifa_proveedor_automovil = Input::get('automovil_proveedor');
					$ruta->tarifa_cliente_buseta = Input::get('buseta_cliente');
					$ruta->tarifa_proveedor_buseta = Input::get('buseta_proveedor');
					$ruta->tarifa_cliente_minivan = Input::get('minivan_cliente');
					$ruta->tarifa_proveedor_minivan = Input::get('minivan_proveedor');
					$ruta->centrosdecosto_id = Input::get('centrodecosto_id');
					$ruta->creado_por = Sentry::getUser()->id;

					if ($ruta->save()) {

						return Response::json([
							'respuesta' => true
						]);

					}
				}
			}
		}
	}

	public function postEditarruta(){

		if (!Sentry::check()){

			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else{

			if(Request::ajax()){

				$ruta = DB::table('rutas')->where('id',Input::get('id'))->first();
				return Response::json([
					'respuesta'=>true,
					'ruta'=>$ruta
				]);

			}
		}
	}

	public function postActualizarruta(){

		if (!Sentry::check()){

			return Response::json([
				'respuesta'=>'relogin'
			]);

		}else{

			if(Request::ajax()){

					$ruta = Rutat::find(Input::get('id'));
					$ruta->codigo_ruta = Input::get('codigo');
					$ruta->nombre_ruta = Input::get('nombre');
					$ruta->descripcion_ruta = Input::get('descripcion');
					$ruta->tarifa_cliente_van = Input::get('van_cliente');
					$ruta->tarifa_proveedor_van = Input::get('van_proveedor');
					$ruta->tarifa_cliente_bus = Input::get('bus_cliente');
					$ruta->tarifa_proveedor_bus = Input::get('bus_proveedor');
					$ruta->tarifa_cliente_automovil = Input::get('automovil_cliente');
					$ruta->tarifa_proveedor_automovil = Input::get('automovil_proveedor');
					$ruta->tarifa_cliente_buseta = Input::get('buseta_cliente');
					$ruta->tarifa_proveedor_buseta = Input::get('buseta_proveedor');
					$ruta->tarifa_cliente_minivan = Input::get('minivan_proveedor');
					$ruta->tarifa_proveedor_minivan = Input::get('minivan_proveedor');
					$ruta->actualizado_por = Sentry::getUser()->id;

					if ($ruta->save()) {

						return Response::json([
							'respuesta' => true
						]);

					}

			}
		}
	}

	public function postClienteeventual(){

		$cliente_eventual = DB::table('subcentrosdecosto')->where('identificacion',Input::get('cc'))->first();

		if ($cliente_eventual===null) {

			return Response::json([
				'respuesta'=>false,
			]);

		}else if ($cliente_eventual!=null) {

			return Response::json([
				'respuesta'=>true,
				'clienteeventual'=>$cliente_eventual
			]);

		}
	}

	public function postVercentrosdecosto(){

	    $tipo_afiliado = Input::get('tipo_afiliado');

	    if ($tipo_afiliado==1) {

	        $centrosdecosto = Centrodecosto::orderBy('razonsocial')->get();

	    }else if ($tipo_afiliado==2) {

	        $centrosdecosto = Centrodecosto::internos()->orderBy('razonsocial')->get();

	    }else if ($tipo_afiliado==3) {

	        $centrosdecosto = Centrodecosto::afiliadosexternos()->orderBy('razonsocial')->get();

	    }

	    return Response::json([
	        'respuesta' => true,
	        'centrosdecosto' => $centrosdecosto
	    ]);

  }

  public function postCargarcentrosdecostoselect(){

      $tipo_cliente = Input::get('tipo_cliente');

      if ($tipo_cliente==3) {

          $centrosdecosto = Centrodecosto::afiliadosexternos()->activos()->orderBy('razonsocial')->get();

      }else if ($tipo_cliente==2) {

          $centrosdecosto = Centrodecosto::internos()->activos()->orderBy('razonsocial')->get();

      }else if ($tipo_cliente==1) {

          $centrosdecosto = Centrodecosto::activos()->orderBy('razonsocial')->get();

      }

      if (count($centrosdecosto)) {

          return Response::json([
              'respuesta' => true,
              'centrosdecosto' => $centrosdecosto
          ]);

      }

	}

	public function postVercentrodecosto(){

		if (!Sentry::check()){

				return Response::json([
					'response' => 'login_expired'
				]);

		}else{

			if (Request::ajax()) {

				$centrodecosto = Centrodecosto::where('id', Input::get('centrodecosto_id'))->with(['nombreruta'])->first();

				if (count($centrodecosto)) {

					return Response::json([
						'response' => true,
						'centrodecosto' => $centrodecosto
					]);

				}

			}

		}

	}

	public function postNuevonombreruta(){

		if (!Sentry::check()){

				return Response::json([
					'response' => 'login_expired'
				]);

		}else{

			if (Request::ajax()) {

				$rules = [
					'nombre_ruta' => 'required',
					'centrodecosto_id' => 'required|numeric'
				];

				$validator = Validator::make(Input::all(), $rules);

				if ($validator->fails()) {

					return Response::json([
						'response' => false,
						'errores' => $validator->errors()->getMessages()
					]);

				}else {

					$nombre_ruta = new NombreRuta();
					$nombre_ruta->nombre = strtoupper(strtolower(Input::get('nombre_ruta')));
					$nombre_ruta->centrodecosto_id = Input::get('centrodecosto_id');

					if ($nombre_ruta->save()) {

						return Response::json([
							'response' => true,
							'nombre_ruta' => $nombre_ruta
						]);

					}

				}

			}

		}

	}

	public function postActualizarnombreruta(){

		if (!Sentry::check()){

				return Response::json([
					'response' => 'login_expired'
				]);

		}else{

			if (Request::ajax()) {

				$nombre_ruta = NombreRuta::find(Input::get('nombre_ruta_id'));
				$nombre_ruta->nombre = strtoupper(strtolower(Input::get('nombre_ruta')));

				if($nombre_ruta->save()){

					return Response::json([
						'response' => true
					]);

				}

			}

		}

	}

	public function postVernombresderuta(){

		//return Input::all();

		$nombres_de_ruta = NombreRuta::where('centrodecosto_id', Input::get('centrodecosto_id'))->orderBy('id')->get();

		if (count($nombres_de_ruta)) {

			return Response::json([
				'response' => true,
				'nombres_de_ruta' => $nombres_de_ruta
			]);

		}

	}

	public function postConsultarmails() {

		$id = Input::get('id');

		$cliente = Centrodecosto::find($id);

		return Response::json([
			'respuesta' => true,
			'cliente' => json_decode($cliente->mails)
		]);

	}

	public function postGuardarcambios() {

		$id = Input::get('id');
		$mails = Input::get('mails');

		$objArray = [];

		for ($i=0; $i < count($mails); $i++) {
			$array = [
				'mail' => strtoupper($mails[$i])
			];
			array_push($objArray, $array);
		}

		$update = DB::table('centrosdecosto')
		->where('id',$id)
		->update([
			'mails' => json_encode($objArray)
		]);

		return Response::json([
			'respuesta' => true,
			'mails' => $mails,
			'id' => $id,
			'objArray' => $objArray
		]);

	}

}
