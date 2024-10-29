<?php

class TarifastrasladosController extends BaseController{

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

		if (isset($permisos->administrativo->rutas_y_tarifas->ver)){
			$ver = $permisos->administrativo->rutas_y_tarifas->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$ruta_general = DB::table('tarifa_traslado')->get();
			$ciudades = DB::table('ciudad')->orderBy('ciudad')->get();

			return View::make('parametros.tarifastraslados')
			->with([
				'ruta_general'=>$ruta_general,
				'ciudades'=>$ciudades,
				'i'=>1,
				'permisos'=>$permisos
			]);
		}

	}

	public function postNuevo(){

		if (!Sentry::check())
		{
			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else {

			if(Request::ajax()){

				$validaciones = [
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
					'minivan_proveedor'=>'numeric'
           		];

				$validador = Validator::make(Input::all(), $validaciones);

				if ($validador->fails()){

					return Response::json([
						'mensaje'=>false,
						'errores'=>$validador->errors()->getMessages()
					]);

				}else {

					$ruta = new Tarifastraslados;
					$ruta->tarifa_nombre = Input::get('nombre');
					$ruta->tarifa_ciudad = Input::get('ciudad');
					$ruta->tarifa_descripcion = Input::get('descripcion');
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
					$ruta->creado_por = Sentry::getUser()->id;

					$ruta->tarifa_cliente_automovil_329 = Input::get('automovil_cliente_aviatur');
					$ruta->tarifa_cliente_minivan_329 = Input::get('minivan_cliente_aviatur');
					$ruta->tarifa_cliente_van_329 = Input::get('van_cliente_aviatur');
					$ruta->tarifa_cliente_buseta_329 = Input::get('buseta_cliente_aviatur');
					$ruta->tarifa_cliente_bus_329 = Input::get('bus_cliente_aviatur');

					if ($ruta->save()) {
						$rutaid = $ruta->id;
						$largo = strlen($rutaid);
						if($largo===1){
							$ruta = Tarifastraslados::find($rutaid);
							$ruta->tarifa_codigo = 'TT0'.$rutaid;
							if($ruta->save()){
								return Response::json([
									'respuesta' => true
								]);
							}
						}else if($largo>=2){
							$ruta = Tarifastraslados::find($rutaid);
							$ruta->tarifa_codigo = 'TT'.$rutaid;
							if($ruta->save()){
								return Response::json([
									'respuesta' => true
								]);
							}
						}
					}
				}
			}
		}

	}

	public function postEditar(){

		$ruta_general = DB::table('tarifa_traslado')->where('id',Input::get('id'))->first();

		if($ruta_general!=null){

			return Response::json([
				'respuesta'=>true,
				'ruta'=>$ruta_general
			]);

		}

	}

	public function postActualizar(){

		 $ruta_general = Tarifastraslados::find(Input::get('id'));
		 $ruta_general->tarifa_nombre = Input::get('nombre');
		 $ruta_general->tarifa_descripcion = Input::get('descripcion');
		 $ruta_general->tarifa_cliente_van = Input::get('van_cliente');
		 $ruta_general->tarifa_proveedor_van = Input::get('van_proveedor');
		 $ruta_general->tarifa_cliente_bus = Input::get('bus_cliente');
		 $ruta_general->tarifa_proveedor_bus = Input::get('bus_proveedor');
		 $ruta_general->tarifa_cliente_automovil = Input::get('automovil_cliente');
		 $ruta_general->tarifa_proveedor_automovil = Input::get('automovil_proveedor');
		 $ruta_general->tarifa_cliente_buseta = Input::get('buseta_cliente');
		 $ruta_general->tarifa_proveedor_buseta = Input::get('buseta_proveedor');
		 $ruta_general->tarifa_cliente_minivan = Input::get('minivan_cliente');
		 $ruta_general->tarifa_proveedor_minivan = Input::get('minivan_proveedor');

		 $ruta_general->tarifa_cliente_automovil_329 = Input::get('automovil_cliente_aviatur');
		 $ruta_general->tarifa_cliente_minivan_329 = Input::get('minivan_cliente_aviatur');
		 $ruta_general->tarifa_cliente_van_329 = Input::get('van_cliente_aviatur');
		 $ruta_general->tarifa_cliente_buseta_329 = Input::get('buseta_cliente_aviatur');
		 $ruta_general->tarifa_cliente_bus_329 = Input::get('bus_cliente_aviatur');

		 $ruta_general->actualizado_por = Sentry::getUser()->id;

		if($ruta_general->save()){

			return Response::json([
				'respuesta'=>true,
				'mensaje'=>'guardado'
			]);

		}

	}

	public function postEliminar(){

		 $ruta_general = Tarifastraslados::find(Input::get('id'));

		 if ($ruta_general->delete()) {
	 		return Response::json([
	 			'respuesta'=>true,
	 			'mensaje'=>'Eliminado!'
	 		]);
		 }

	}

	public function postVertarifatraslado(){

		$tarifa_traslado = Tarifastraslados::where('tarifa_ciudad', Input::get('stringCiudad'))->orderBy('tarifa_nombre')->get();

		if (count($tarifa_traslado)) {

			return Response::json([
				'response' => true,
				'tarifa_traslado' => $tarifa_traslado
			]);

		}else {

			return Response::json([
				'response' => false
			]);

		}

	}

	//New Version

	public function getTrayectos(){

		if (Sentry::check()) {
			$id_rol = Sentry::getUser()->id_rol;
			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
			$permisos = json_decode($permisos);
		}else{
			$id_rol = null;
			$permisos = null;
			$permisos = null;
		}

		if (isset($permisos->administrativo->rutas_y_tarifas->ver)){
			$ver = $permisos->administrativo->rutas_y_tarifas->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$ruta_general = DB::table('traslados')
			->whereIn('ciudad',['barranquilla','provisional'])
			->get();

			$ciudades = DB::table('ciudad')->orderBy('ciudad')->get();

			$centrosdecosto = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->get();

			$clientes = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->whereIn('localidad',['barranquilla','provisional'])
			->whereNull('tarifa_aotour')
			//->where('id','!=', 97)
			//->where('id','!=', 100)
			->where('id','!=', 407)
			->orderBy('razonsocial', 'asc')
			->get();

			//$select = "SELECT DISTINCT tarifas.centrodecosto_id, centrosdecosto.id as id_centro, centrosdecosto.razonsocial FROM tarifas LEFT JOIN centrosdecosto ON centrosdecosto.id = tarifas.centrodecosto_id WHERE centrosdecosto.id is not null AND tarifas.tarifa_aotour is null";

			$select = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is null and localidad in('barranquilla','provisional') and id!=97 and id!=407 order by razonsocial asc";


			$query = DB::select($select);

			//$consultas = "SELECT DISTINCT tarifas.centrodecosto_id, centrosdecosto.id as id_centro, centrosdecosto.razonsocial FROM tarifas LEFT JOIN centrosdecosto ON centrosdecosto.id = tarifas.centrodecosto_id WHERE centrosdecosto.id is not null and tarifas.tarifa_aotour is not null";

			$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is not null and localidad in('barranquilla','provisional') and id!=97 and id!=407";

			$bd = DB::select($consultas);

			return View::make('parametros.trayectos')
			->with([
				'ruta_general'=>$ruta_general,
				'centrosdecosto' => $centrosdecosto,
				'ciudades'=>$ciudades,
				'clientes' => $clientes,
				'i'=>1,
				'permisos'=>$permisos,
				'query' => $query,
				'bd' => $bd
			]);
		}

	}

	public function getTrayectosproveedor(){

		if (Sentry::check()) {
			$id_rol = Sentry::getUser()->id_rol;
			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
			$permisos = json_decode($permisos);
		}else{
			$id_rol = null;
			$permisos = null;
			$permisos = null;
		}

		if (isset($permisos->administrativo->rutas_y_tarifas->ver)){
			$ver = $permisos->administrativo->rutas_y_tarifas->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$ruta_general = DB::table('traslados')->get();

			$ciudades = DB::table('ciudad')->orderBy('ciudad')->get();

			$centrosdecosto = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->get();

			$clientes = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->whereIn('localidad',['barranquilla','provisional'])
			->whereNull('tarifa_aotour_proveedor')
			//->where('id','!=', 97)
			->where('id','!=', 100)
			->where('id','!=', 407)
			->orderBy('razonsocial', 'asc')
			->get();

			$select = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour_proveedor is null and localidad in('barranquilla','provisional') and id!=97 and id!=407 and id!=100 order by razonsocial asc";


			$query = DB::select($select);

			$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour_proveedor is not null and localidad in('barranquilla','provisional') and id!=97 and id!=407";

			$bd = DB::select($consultas);

			return View::make('parametros.trayectosproveedor')
			->with([
				'ruta_general'=>$ruta_general,
				'centrosdecosto' => $centrosdecosto,
				'ciudades'=>$ciudades,
				'clientes' => $clientes,
				'i'=>1,
				'permisos'=>$permisos,
				'query' => $query,
				'bd' => $bd
			]);
		}

	}

	public function getTrayectosaotour(){

		if (Sentry::check()) {
			$id_rol = Sentry::getUser()->id_rol;
			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
			$permisos = json_decode($permisos);
		}else{
			$id_rol = null;
			$permisos = null;
			$permisos = null;
		}

		if (isset($permisos->administrativo->rutas_y_tarifas->ver)){
			$ver = $permisos->administrativo->rutas_y_tarifas->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$ruta_general = DB::table('traslados')->get();

			$ciudades = DB::table('ciudad')->orderBy('ciudad')->get();

			$centrosdecosto = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->get();

			$clientes = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->whereIn('localidad',['barranquilla','provisional'])
			->whereNull('tarifa_aotour')
			//->where('id','!=', 97)
			//->where('id','!=', 100)
			->where('id','!=', 407)
			->orderBy('razonsocial', 'asc')
			->get();

			//$select = "SELECT DISTINCT tarifas.centrodecosto_id, centrosdecosto.id as id_centro, centrosdecosto.razonsocial FROM tarifas LEFT JOIN centrosdecosto ON centrosdecosto.id = tarifas.centrodecosto_id WHERE centrosdecosto.id is not null AND tarifas.tarifa_aotour is null";

			$select = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is not null and localidad in('barranquilla','provisional') and id!=97 and id!=407 order by razonsocial asc";


			$query = DB::select($select);

			//$consultas = "SELECT DISTINCT tarifas.centrodecosto_id, centrosdecosto.id as id_centro, centrosdecosto.razonsocial FROM tarifas LEFT JOIN centrosdecosto ON centrosdecosto.id = tarifas.centrodecosto_id WHERE centrosdecosto.id is not null and tarifas.tarifa_aotour is not null";

			$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is not null and localidad in('barranquilla','provisional') and id!=97 and id!=407";

			$bd = DB::select($consultas);

			return View::make('parametros.trayectosaotour')
			->with([
				'ruta_general'=>$ruta_general,
				'centrosdecosto' => $centrosdecosto,
				'ciudades'=>$ciudades,
				'clientes' => $clientes,
				'i'=>1,
				'permisos'=>$permisos,
				'query' => $query,
				'bd' => $bd
			]);
		}

	}

	public function getTrayectosaotourbog(){

		if (Sentry::check()) {
			$id_rol = Sentry::getUser()->id_rol;
			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
			$permisos = json_decode($permisos);
		}else{
			$id_rol = null;
			$permisos = null;
			$permisos = null;
		}

		if (isset($permisos->administrativo->rutas_y_tarifas->ver)){
			$ver = $permisos->administrativo->rutas_y_tarifas->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$ruta_general = DB::table('traslados')->get();

			$ciudades = DB::table('ciudad')->orderBy('ciudad')->get();

			$centrosdecosto = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->get();

			$clientes = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->whereIn('localidad',['bogota','provisional'])
			->whereNull('tarifa_aotour')
			//->where('id','!=', 97)
			->where('id','!=', 100)
			->where('id','!=', 407)
			->orderBy('razonsocial', 'asc')
			->get();

			//$select = "SELECT DISTINCT tarifas.centrodecosto_id, centrosdecosto.id as id_centro, centrosdecosto.razonsocial FROM tarifas LEFT JOIN centrosdecosto ON centrosdecosto.id = tarifas.centrodecosto_id WHERE centrosdecosto.id is not null AND tarifas.tarifa_aotour is null";

			$select = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is not null and localidad in('bogota','provisional') and id!=292 and id!=407 and id!=100 order by razonsocial asc";


			$query = DB::select($select);

			//$consultas = "SELECT DISTINCT tarifas.centrodecosto_id, centrosdecosto.id as id_centro, centrosdecosto.razonsocial FROM tarifas LEFT JOIN centrosdecosto ON centrosdecosto.id = tarifas.centrodecosto_id WHERE centrosdecosto.id is not null and tarifas.tarifa_aotour is not null";

			$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is not null and localidad in('bogota','provisional') and id!=292 and id!=407";

			$bd = DB::select($consultas);

			return View::make('parametros.trayectosaotour_bog')
			->with([
				'ruta_general'=>$ruta_general,
				'centrosdecosto' => $centrosdecosto,
				'ciudades'=>$ciudades,
				'clientes' => $clientes,
				'i'=>1,
				'permisos'=>$permisos,
				'query' => $query,
				'bd' => $bd
			]);
		}

	}

	public function getTrayectosaotourproveedor(){

		if (Sentry::check()) {
			$id_rol = Sentry::getUser()->id_rol;
			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
			$permisos = json_decode($permisos);
		}else{
			$id_rol = null;
			$permisos = null;
			$permisos = null;
		}

		if (isset($permisos->administrativo->rutas_y_tarifas->ver)){
			$ver = $permisos->administrativo->rutas_y_tarifas->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$ruta_general = DB::table('traslados')->get();

			$ciudades = DB::table('ciudad')->orderBy('ciudad')->get();

			$centrosdecosto = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->get();

			$clientes = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->whereIn('localidad',['barranquilla','provisional'])
			->whereNull('tarifa_aotour_proveedor')
			//->where('id','!=', 97)
			->where('id','!=', 100)
			->where('id','!=', 407)
			->orderBy('razonsocial', 'asc')
			->get();

			//$select = "SELECT DISTINCT tarifas.centrodecosto_id, centrosdecosto.id as id_centro, centrosdecosto.razonsocial FROM tarifas LEFT JOIN centrosdecosto ON centrosdecosto.id = tarifas.centrodecosto_id WHERE centrosdecosto.id is not null AND tarifas.tarifa_aotour is null";

			$select = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour_proveedor is not null and localidad in('barranquilla','provisional') and id!=97 and id!=407 and id!=100 order by razonsocial asc";


			$query = DB::select($select);

			//$consultas = "SELECT DISTINCT tarifas.centrodecosto_id, centrosdecosto.id as id_centro, centrosdecosto.razonsocial FROM tarifas LEFT JOIN centrosdecosto ON centrosdecosto.id = tarifas.centrodecosto_id WHERE centrosdecosto.id is not null and tarifas.tarifa_aotour is not null";

			$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour_proveedor is not null and localidad in('barranquilla','provisional') and id!=97 and id!=407";

			$bd = DB::select($consultas);

			return View::make('parametros.trayectosaotour_proveedor')
			->with([
				'ruta_general'=>$ruta_general,
				'centrosdecosto' => $centrosdecosto,
				'ciudades'=>$ciudades,
				'clientes' => $clientes,
				'i'=>1,
				'permisos'=>$permisos,
				'query' => $query,
				'bd' => $bd
			]);
		}

	}

	public function getTrayectosaotourproveedorbog(){

		if (Sentry::check()) {
			$id_rol = Sentry::getUser()->id_rol;
			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
			$permisos = json_decode($permisos);
		}else{
			$id_rol = null;
			$permisos = null;
			$permisos = null;
		}

		if (isset($permisos->administrativo->rutas_y_tarifas->ver)){
			$ver = $permisos->administrativo->rutas_y_tarifas->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$ruta_general = DB::table('traslados')->get();

			$ciudades = DB::table('ciudad')->orderBy('ciudad')->get();

			$centrosdecosto = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->get();

			$clientes = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->whereIn('localidad',['bogota','provisional'])
			->whereNull('tarifa_aotour_proveedor')
			//->where('id','!=', 97)
			->where('id','!=', 100)
			->where('id','!=', 407)
			->orderBy('razonsocial', 'asc')
			->get();

			//$select = "SELECT DISTINCT tarifas.centrodecosto_id, centrosdecosto.id as id_centro, centrosdecosto.razonsocial FROM tarifas LEFT JOIN centrosdecosto ON centrosdecosto.id = tarifas.centrodecosto_id WHERE centrosdecosto.id is not null AND tarifas.tarifa_aotour is null";

			$select = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour_proveedor is not null and localidad in('bogota','provisional') and id!=97 and id!=407 and id!=100 order by razonsocial asc";


			$query = DB::select($select);

			//$consultas = "SELECT DISTINCT tarifas.centrodecosto_id, centrosdecosto.id as id_centro, centrosdecosto.razonsocial FROM tarifas LEFT JOIN centrosdecosto ON centrosdecosto.id = tarifas.centrodecosto_id WHERE centrosdecosto.id is not null and tarifas.tarifa_aotour is not null";

			$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour_proveedor is not null and localidad in('bogota','provisional') and id!=97 and id!=407";

			$bd = DB::select($consultas);

			return View::make('parametros.trayectosaotour_proveedor_bog')
			->with([
				'ruta_general'=>$ruta_general,
				'centrosdecosto' => $centrosdecosto,
				'ciudades'=>$ciudades,
				'clientes' => $clientes,
				'i'=>1,
				'permisos'=>$permisos,
				'query' => $query,
				'bd' => $bd
			]);
		}

	}

	public function postAnadirtarifaindividual() {

		$id_trayecto = Input::get('id_trayecto');
		$centro = Input::get('centro');
		$valor = Input::get('valor');
		$valor_proveedor = Input::get('valor_proveedor');
		$cliente_van = Input::get('cliente_van');
		$proveedor_van = Input::get('proveedor_van');
		$cliente_master = Input::get('cliente_master');
		$proveedor_master = Input::get('proveedor_master');

		$tarifa = New Tarifa;
		$tarifa->cliente_auto = $valor;
		$tarifa->cliente_van = $cliente_van;
		$tarifa->cliente_master = $cliente_master;
		$tarifa->proveedor_auto = $valor_proveedor;
		$tarifa->proveedor_van = $proveedor_van;
		$tarifa->proveedor_master = $proveedor_master;
		$tarifa->estado = 1;
		$tarifa->centrodecosto_id = $centro;
		$tarifa->localidad = Input::get('localidad');
		$tarifa->trayecto_id = $id_trayecto;

		if( $tarifa->save() ) {

			return Response::json([
				'respuesta' => true
			]);
		}


	}

	public function postAnadirtarifaindividualaotour() {

		$id_trayecto = Input::get('id_trayecto');
		$centro = Input::get('centro');
		$valor = Input::get('valor');
		$valor_proveedor = Input::get('valor_proveedor');
		$cliente_van = Input::get('cliente_van');
		$proveedor_van = Input::get('proveedor_van');
		$cliente_master = Input::get('cliente_master');
		$proveedor_master = Input::get('proveedor_master');

		//Guardar el registro de aotour
		$tarifa = New Tarifa;
		$tarifa->cliente_auto = $valor;
		$tarifa->cliente_van = $cliente_van;
		$tarifa->cliente_master = $cliente_master;
		$tarifa->proveedor_auto = $valor_proveedor;
		$tarifa->proveedor_van = $proveedor_van;
		$tarifa->proveedor_master = $proveedor_master;
		$tarifa->estado = 1;
		$tarifa->centrodecosto_id = $centro;
		$tarifa->localidad = Input::get('localidad');
		$tarifa->trayecto_id = $id_trayecto;
		$tarifa->save();

		$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is not null and localidad in('barranquilla','provisional') and id!=97 and id!=407";

		$bd = DB::select($consultas);

		foreach ($bd as $key) {

			$tarifa = New Tarifa;
			$tarifa->cliente_auto = $valor;
			$tarifa->cliente_van = $cliente_van;
			$tarifa->proveedor_auto = $valor_proveedor;
			$tarifa->proveedor_van = $proveedor_van;
			$tarifa->estado = 1;
			$tarifa->centrodecosto_id = $key->id_centro;
			$tarifa->localidad = Input::get('localidad');
			$tarifa->trayecto_id = $id_trayecto;
			$tarifa->save();

		}

		return Response::json([
			'respuesta' => true,
			'centrodecosto_id' => $centro
		]);



	}

	public function postAnadirtarifaindividualaotourbog() {

		$id_trayecto = Input::get('id_trayecto');
		$centro = Input::get('centro');
		$valor = Input::get('valor');
		$valor_proveedor = Input::get('valor_proveedor');
		$cliente_van = Input::get('cliente_van');
		$proveedor_van = Input::get('proveedor_van');

		//Guardar el registro de aotour
		$tarifa = New Tarifa;
		$tarifa->cliente_auto = $valor;
		$tarifa->cliente_van = $cliente_van;
		$tarifa->proveedor_auto = $valor_proveedor;
		$tarifa->proveedor_van = $proveedor_van;
		$tarifa->estado = 1;
		$tarifa->centrodecosto_id = $centro;
		$tarifa->localidad = Input::get('localidad');
		$tarifa->trayecto_id = $id_trayecto;
		$tarifa->save();

		$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is not null and localidad in('bogota','provisional') and id!=292 and id!=407";

		$bd = DB::select($consultas);

		foreach ($bd as $key) {

			$tarifa = New Tarifa;
			$tarifa->cliente_auto = $valor;
			$tarifa->cliente_van = $cliente_van;
			$tarifa->proveedor_auto = $valor_proveedor;
			$tarifa->proveedor_van = $proveedor_van;
			$tarifa->estado = 1;
			$tarifa->centrodecosto_id = $key->id_centro;
			$tarifa->localidad = Input::get('localidad');
			$tarifa->trayecto_id = $id_trayecto;
			$tarifa->save();

		}

		return Response::json([
			'respuesta' => true,
			'centrodecosto_id' => $centro
		]);



	}

	public function postActualizartarifaindividual() {

		$id = Input::get('id');
		$valor = Input::get('valor');
		$valorVan = Input::get('valuev');
		$valorMaster = Input::get('valorMaster');

		$consulta =  DB::table('tarifas')
		->where('id',$id)
		->pluck('cliente_auto');

		if(1>2) {

			return Response::json([
				'respuesta' => 'igual'
			]);

		}else{

			$tarifa =  DB::table('tarifas')
			->where('id',$id)
			->update([
				'cliente_auto' => $valor,
				'cliente_van' => $valorVan,
				'cliente_master' => $valorMaster
			]);

			if($tarifa) {

				$search =  DB::table('tarifas')
				->where('id',$id)
				->first();

				if($search->centrodecosto_id==97) { //Si es aotour, se modifican los valores de los clientes con TA

					$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is not null and localidad in('barranquilla','provisional') and id!=97 and id!=407";

					$bd = DB::select($consultas);

					foreach ($bd as $key) {

						$tarifa =  DB::table('tarifas')
						->where('centrodecosto_id',$key->id_centro)
						->where('trayecto_id',$search->trayecto_id)
						->update([
							'cliente_auto' => $valor,
							'cliente_van' => $valorVan,
							'cliente_master' => $valorMaster
						]);

					}


				}

				return Response::json([
					'respuesta' => true,
					'id' => $id,
					'valor' => $valor
				]);

			}

		}

	}

	public function postActualizartarifaindividualproveedor() {

		$id = Input::get('id');
		$valor = Input::get('valor');
		$valorv = Input::get('valuev');

		$consulta =  DB::table('tarifas')
		->where('id',$id)
		->pluck('proveedor_auto');

		if(1>2) {

			return Response::json([
				'respuesta' => 'igual'
			]);

		}else{

			$tarifa =  DB::table('tarifas')
			->where('id',$id)
			->update([
				'proveedor_auto' => $valor,
				'proveedor_van' => $valorv
			]);

			if($tarifa) {

				$search =  DB::table('tarifas')
				->where('id',$id)
				->first();

				$sw = 0;

				if($search->centrodecosto_id==97) { //Si es aotour, se modifican los valores de los clientes con TA

					$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour_proveedor is not null and localidad in('barranquilla','provisional') and id!=97 and id!=407";

					$bd = DB::select($consultas);

					foreach ($bd as $key) {

						$tarifa =  DB::table('tarifas')
						->where('centrodecosto_id',$key->id_centro)
						->where('trayecto_id',$search->trayecto_id)
						->update([
							'proveedor_auto' => $valor,
							'proveedor_van' => $valorv
						]);

						$sw = $sw+$tarifa;

					}


				}

				return Response::json([
					'respuesta' => true,
					'sw' => $sw,
					'trayecto' => $search->trayecto_id,
					//'bd' => $bd
				]);

			}

		}

	}

	public function postActualizartrayecto() {

		$id_trayecto = Input::get('id_trayecto');
		$clientes = Input::get('clientes');
		$cliente_auto = Input::get('cliente_auto');
		$cliente_van = Input::get('cliente_van');
		$proveedor_auto = Input::get('proveedor_auto');
		$proveedor_van = Input::get('proveedor_van');

		$trayecto = DB::table('traslados')
		->where('id',$id_trayecto)
		->first();

		$datas = '';

		$cantidad = count($clientes);

		for ($i=0; $i<count($clientes) ; $i++) {

	        if(count($clientes)>1){

	          if($i==count($clientes)-1){
	            $coma = '';
	          }else{
	            $coma = ',';
	          }

	          $datas .= $clientes[$i].$coma;

	        }else{

	          $datas = $clientes[$i];

	        }

      	}

      	$text = '';

      	if($cliente_auto!='') {

      		$text ="cliente_auto = ".$cliente_auto;
      	}

      	if($cliente_van!='') {
      		if($text!=''){
      			$text .=", cliente_van = ".$cliente_van;
      		}else{
      			$text ="cliente_van = ".$cliente_van;
      		}
      	}

      	if($proveedor_auto!='') {
      		if($text!=''){
      			$text .=", proveedor_auto = ".$proveedor_auto;
      		}else{
      			$text ="proveedor_auto = ".$proveedor_auto;
      		}
      	}

      	if($proveedor_van!='') {
      		if($text!='') {
      			$text .=", proveedor_van = ".$proveedor_van;
      		}else{
      			$text ="proveedor_van = ".$proveedor_van;
      		}
      	}

		$query = "UPDATE tarifas SET ".$text." WHERE trayecto_id = ".$id_trayecto." and centrodecosto_id in (".$datas.") ";

		$consulta = DB::update($query);

		return Response::json([
			'respuesta' => true,
			'trayecto' => $trayecto,
			'consulta' => $consulta,
			'query' => $query,
			'datas' => $datas,
			'cliente_auto' => $cliente_auto
		]);


	}

	public function postActualizartrayectomasivo() {

		$id_trayecto = Input::get('id_trayecto');
		$clientes = Input::get('idArray');
		$cliente_auto = Input::get('cliente_auto');
		$centro = Input::get('centro');
		//$proveedor_auto = Input::get('proveedor_auto');
		//$proveedor_van = Input::get('proveedor_van');

		$trayecto = DB::table('traslados')
		->where('id',$id_trayecto)
		->first();

		$datas = '';

		$cantidad = count($clientes);

		for ($i=0; $i<count($clientes) ; $i++) {

	        if(count($clientes)>1){

	          if($i==count($clientes)-1){
	            $coma = '';
	          }else{
	            $coma = ',';
	          }

	          $datas .= $clientes[$i].$coma;

	        }else{

	          $datas = $clientes[$i];

	        }

      	}

      	$text = '';

      	if($cliente_auto!='') {

      		$text ="cliente_auto = ".$cliente_auto;
      	}

      	$datas .= ','.$centro;

		$query = "UPDATE tarifas SET ".$text." WHERE trayecto_id = ".$id_trayecto." and centrodecosto_id in (".$datas.") ";

		$consulta = DB::update($query);

		return Response::json([
			'respuesta' => true,
			'trayecto' => $trayecto,
			'consulta' => $consulta,
			'query' => $query,
			'datas' => $datas,
			'cliente_auto' => $cliente_auto
		]);


	}

	public function postAsignartao() {

		$id_trayecto = Input::get('id_trayecto');
		$clientes = Input::get('idArray');
		$cliente_auto = Input::get('valor');

		$trayecto = DB::table('traslados')
		->where('id',$id_trayecto)
		->first();

		$datas = '';

		$cantidad = count($clientes);

		for ($i=0; $i<count($clientes) ; $i++) {

			$existe = DB::table('tarifas')
			->where('centrodecosto_id',$clientes[$i])
			->where('trayecto_id',$id_trayecto)
			->first();

			if($existe) { //Actualizar existente

				$update = DB::table('tarifas')
				->where('centrodecosto_id',$clientes[$i])
				->where('trayecto_id',$id_trayecto)
				->update([
					'cliente_auto' => $cliente_auto
				]);

			}else{ //Crear el registro con el valor

				$nuevaTarifa = New Tarifa;
				$nuevaTarifa->trayecto_id = $id_trayecto;
				$nuevaTarifa->cliente_auto = $cliente_auto;
				$nuevaTarifa->centrodecosto_id = $clientes[$i];
				$nuevaTarifa->estado = 1;
				$nuevaTarifa->save();

			}

      	}

      	return Response::json([
			'respuesta' => true
		]);

	}

	public function postAumentarporcentaje() {

		$cliente_auto = Input::get('valor');
		$clientes = Input::get('idArray');

		$datas = '';

		$cantidad = count($clientes);

		for ($i=0; $i<count($clientes) ; $i++) {

	        if(count($clientes)>1){

	          if($i==count($clientes)-1){
	            $coma = '';
	          }else{
	            $coma = ',';
	          }

	          $datas .= $clientes[$i].$coma;

	        }else{

	          $datas = $clientes[$i];

	        }

      	}

      	$text = '';

      	if($cliente_auto!='') {

      		$text ="cliente_auto = ".$cliente_auto;
      	}

      	$sel = " SELECT * FROM tarifas where centrodecosto_id in (".$datas.") ";
      	$selee = DB::select($sel);
      	$sw = 0;

      	foreach ($selee as $key) {

      		if($key->centrodecosto_id==97){
      			$sw = 1;
      		}

      		$new = doubleval($key->cliente_auto)*doubleval($cliente_auto)/100;
      		$new2 = doubleval($key->proveedor_auto)*doubleval($cliente_auto)/100;

      		$updates = DB::table('tarifas')
      		->where('id',$key->id)
      		->update([
      			'cliente_auto' => $key->cliente_auto+$new,
      			//'proveedor_auto' => $key->proveedor_auto+$new2
      		]);
      	}

		//$query = "UPDATE tarifas SET ".$text." WHERE centrodecosto_id in (".$datas.") ";

		//$consulta = DB::update($query);

		if($sw==1) {

			//Consulta de todos los clientes
			$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is not null and localidad in('barranquilla','provisional') and id!=97 and id!=407";

			$bd = DB::select($consultas); //Consulta del query

			foreach ($bd as $key) { //Recorrer los clientes

				//Conusltar las tarifas de cada iteración de clientes
				$sell = " SELECT * FROM tarifas where centrodecosto_id = ".$key->id_centro."";
      			$fees = DB::select($sell);

      			foreach ($fees as $fee) { //Recorrer las tarifas del cliente iterado

      				$news = doubleval($fee->cliente_auto)*doubleval($cliente_auto)/100; //calcular el aumento del porcentaje
      				$news2 = doubleval($fee->proveedor_auto)*doubleval($cliente_auto)/100; //calcular el aumento del porcentaje

					$updates = DB::table('tarifas')
		      		->where('id',$fee->id)
		      		->update([
		      			'cliente_auto' => $fee->cliente_auto+$news,
		      			//'proveedor_auto' => $fee->proveedor_auto+$news2
		      		]); //Actualizar el valor de esa tarifa

      			}

			}

		}

		return Response::json([
			'respuesta' => true,
			'sw' => $sw,
			//'trayecto' => $trayecto,
			//'consulta' => $consulta,
			//'query' => $query,
			'datas' => $datas,
			'cliente_auto' => $cliente_auto
		]);


	}

	public function postAumentarporcentajeproveedor() {

		$cliente_auto = Input::get('valor');
		$clientes = Input::get('idArray');

		$datas = '';

		$cantidad = count($clientes);

		for ($i=0; $i<count($clientes) ; $i++) {

	        if(count($clientes)>1){

	          if($i==count($clientes)-1){
	            $coma = '';
	          }else{
	            $coma = ',';
	          }

	          $datas .= $clientes[$i].$coma;

	        }else{

	          $datas = $clientes[$i];

	        }

      	}

      	$text = '';

      	if($cliente_auto!='') {

      		$text ="cliente_auto = ".$cliente_auto;
      	}

      	$sel = " SELECT * FROM tarifas where centrodecosto_id in (".$datas.") ";
      	$selee = DB::select($sel);
      	$sw = 0;

      	foreach ($selee as $key) {

      		if($key->centrodecosto_id==97){
      			$sw = 1;
      		}

      		$new = doubleval($key->cliente_auto)*doubleval($cliente_auto)/100;
      		$new2 = doubleval($key->proveedor_auto)*doubleval($cliente_auto)/100;

      		$rest = substr($new2, -3);

      		if($rest>=1 and $rest<=500){

      		}

      		$updates = DB::table('tarifas')
      		->where('id',$key->id)
      		->update([
      			//'cliente_auto' => $key->cliente_auto+$new,
      			'proveedor_auto' => $key->proveedor_auto+$new2
      		]);
      	}

		//$query = "UPDATE tarifas SET ".$text." WHERE centrodecosto_id in (".$datas.") ";

		//$consulta = DB::update($query);

		if($sw==1) {

			//Consulta de todos los clientes
			$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is not null and localidad in('barranquilla','provisional') and id!=97 and id!=407";

			$bd = DB::select($consultas); //Consulta del query

			foreach ($bd as $key) { //Recorrer los clientes

				//Conusltar las tarifas de cada iteración de clientes
				$sell = " SELECT * FROM tarifas where centrodecosto_id = ".$key->id_centro."";
      			$fees = DB::select($sell);

      			foreach ($fees as $fee) { //Recorrer las tarifas del cliente iterado

      				$news = doubleval($fee->cliente_auto)*doubleval($cliente_auto)/100; //calcular el aumento del porcentaje
      				$news2 = doubleval($fee->proveedor_auto)*doubleval($cliente_auto)/100; //calcular el aumento del porcentaje

					$updates = DB::table('tarifas')
		      		->where('id',$fee->id)
		      		->update([
		      			//'cliente_auto' => $fee->cliente_auto+$news,
		      			'proveedor_auto' => $fee->proveedor_auto+$news2
		      		]); //Actualizar el valor de esa tarifa

      			}

			}

		}

		return Response::json([
			'respuesta' => true,
			'sw' => $sw,
			//'trayecto' => $trayecto,
			//'consulta' => $consulta,
			//'query' => $query,
			'datas' => $datas,
			'cliente_auto' => $cliente_auto
		]);


	}

	public function postNuevotrayecto() {

		$nombre = Input::get('nombre');
		$tarifa_cliente = Input::get('tarifa_cliente');
		$tarifa_cliente_van = Input::get('tarifa_cliente_van');
		$tarifa_proveedor = Input::get('tarifa_proveedor');
		$tarifa_proveedor_van = Input::get('tarifa_proveedor_van');
		$cliente = Input::get('cliente');

		if(Input::get('localidad')==1){
			$city = 'BOGOTA';
			$locality = 1;
		}else{
			$city = 'BARRANQUILLA';
			$locality = null;
		}

		$trayecto = new Traslado;
		$trayecto->nombre = strtoupper($nombre);
		$trayecto->ciudad = $city;
		$trayecto->save();

		$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and localidad in('barranquilla','provisional')";

		$bd = DB::select($consultas);



		$tarifa = new Tarifa;
		$tarifa->centrodecosto_id = $cliente;
		$tarifa->trayecto_id = $trayecto->id;
		$tarifa->cliente_auto = $tarifa_cliente;
		$tarifa->cliente_van = $tarifa_cliente_van;
		$tarifa->proveedor_auto = $tarifa_proveedor;
		$tarifa->proveedor_van = $tarifa_proveedor_van;
		$tarifa->localidad = $locality;
		$tarifa->estado = 1;
		$tarifa->save();

		if($cliente==97) { //Si es aotour, se modifican los valores de los clientes con TA

			$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is not null and localidad in('barranquilla','provisional') and id!=97 and id!=407";

			$bd = DB::select($consultas);

			foreach ($bd as $key) {

				$tarifa = new Tarifa;
				$tarifa->centrodecosto_id = $key->id_centro;
				$tarifa->trayecto_id = $trayecto->id;
				$tarifa->cliente_auto = $tarifa_cliente;
				$tarifa->cliente_van = $tarifa_cliente_van;
				$tarifa->proveedor_auto = $tarifa_proveedor;
				$tarifa->proveedor_van = $tarifa_proveedor_van;
				$tarifa->localidad = $locality;
				$tarifa->estado = 1;
				$tarifa->save();

			}


		}

		/*foreach ($variable as $key) {
			$tarifa = new Tarifa;
			$tarifa->estado = 1;
			$tarifa->centrodecosto_id = $key->id;
			$tarifa->trayecto_id = $trayecto->id;
			$tarifa->save();
		}*/

		return Response::json([
			'respuesta' => true
		]);


	}

	public function postVerificartarifaproveedor() {

		$cliente = Input::get('cliente');
		$id_trayecto = Input::get('id_trayecto');

		$centrodecosto = DB::table('centrosdecosto')
		->where('id',$cliente)
		->pluck('tarifa_aotour_proveedor');

		$consulta = 0;
		$valorAuto = 0;
		$valorVan = 0;

		if($centrodecosto==1) {

			$consulta = DB::table('tarifas')
			->where('trayecto_id',$id_trayecto)
			->where('centrodecosto_id',97)
			->first();

			$valorAuto = $consulta->proveedor_auto;
			$valorVan = $consulta->proveedor_van;

		}

		return Response::json([
			'respuesta' => true,
			'tarifa' => $valorAuto,
			'tarifa_van' => $valorVan
		]);

	}

	public function postActualizartrayectoindividual() {

		$id_tarifa = Input::get('id_tarifa');
		$cliente_auto = Input::get('cliente_auto');
		$cliente_van = Input::get('cliente_van');
		$proveedor_auto = Input::get('proveedor_auto');
		$proveedor_van = Input::get('proveedor_van');

		$tarifa = DB::table('tarifas')
		->where('id',$id_tarifa)
		->first();

      	$text = '';

      	if($cliente_auto!='') {

      		$text ="cliente_auto = ".$cliente_auto;
      	}

      	if($cliente_van!='') {
      		if($text!=''){
      			$text .=", cliente_van = ".$cliente_van;
      		}else{
      			$text ="cliente_van = ".$cliente_van;
      		}
      	}

      	if($proveedor_auto!='') {
      		if($text!=''){
      			$text .=", proveedor_auto = ".$proveedor_auto;
      		}else{
      			$text ="proveedor_auto = ".$proveedor_auto;
      		}
      	}

      	if($proveedor_van!='') {
      		if($text!='') {
      			$text .=", proveedor_van = ".$proveedor_van;
      		}else{
      			$text ="proveedor_van = ".$proveedor_van;
      		}
      	}

		$query = "UPDATE tarifas SET ".$text." WHERE id = ".$id_tarifa."";

		$consulta = DB::update($query);

		return Response::json([
			'respuesta' => true,
			'consulta' => $consulta,
			'query' => $query,
			'cliente_auto' => $cliente_auto
		]);


	}

	public function postConsultarclientestarifa() {

		$select = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is null and localidad in('barranquilla','provisional') and id!=97 and id!=407 order by razonsocial asc";


		$query = DB::select($select);

		return Response::json([
			'respuesta' => true,
			'clientes' => $query
		]);

	}

	public function postUnircliente() {

		$clientes = Input::get('idArray');

		$datas = '';

		$cantidad = count($clientes);

		for ($i=0; $i<count($clientes) ; $i++) {

			$traslados = DB::table('traslados')
			->get();

			foreach ($traslados as $traslado) {

				$search = DB::table('tarifas')
				->select('id', 'cliente_auto', 'proveedor_auto', 'trayecto_id', 'centrodecosto_id')
				->where('trayecto_id',$traslado->id)
				->where('centrodecosto_id',97)
				->first();

				if($search!=null) {

					$fee = DB::table('tarifas')
					->where('trayecto_id',$traslado->id)
					->where('trayecto_id',$clientes[$i])
					->whereNull('localidad')
					->first();

					if($fee){

						$update = DB::table('tarifas')
						->where('trayecto_id',$traslado->id)
						->where('centrodecosto_id',$clientes[$i])
						->update([
							'cliente_auto' => $search->cliente_auto,
							'proveedor_auto' => $search->proveedor_auto,
						]);

					}else{

						$newFee = New Tarifa;
						$newFee->trayecto_id = $traslado->id;
						$newFee->cliente_auto = $search->cliente_auto;
						//$newFee->cliente_van = $tarifa_cliente_van;
						$newFee->proveedor_auto = $search->proveedor_auto;
						//$newFee->proveedor_van = $tarifa_proveedor_van;
						$newFee->centrodecosto_id = $clientes[$i];
						$newFee->estado = 1;
						$newFee->save();

					}

				}

			}

			$updates = DB::table('centrosdecosto')
			->where('id',$clientes[$i])
			->update([
				'tarifa_aotour' => 1
			]);

      	}

      	return Response::json([
      		'respuesta' => true,
      		'clientes' => $datas
      	]);
	}

	public function postUnirclientebog() {

		$clientes = Input::get('idArray');

		$datas = '';

		$cantidad = count($clientes);

		for ($i=0; $i<count($clientes) ; $i++) {

			$traslados = DB::table('traslados')
			->get();

			foreach ($traslados as $traslado) {

				$search = DB::table('tarifas')
				->select('id', 'cliente_auto', 'proveedor_auto', 'trayecto_id', 'centrodecosto_id')
				->where('trayecto_id',$traslado->id)
				->where('centrodecosto_id',292)
				->first();

				if($search!=null) {

					$fee = DB::table('tarifas')
					->where('trayecto_id',$traslado->id)
					->where('trayecto_id',$clientes[$i])
					->whereNotNull('localidad')
					->first();

					if($fee){

						$update = DB::table('tarifas')
						->where('trayecto_id',$traslado->id)
						->where('centrodecosto_id',$clientes[$i])
						->update([
							'cliente_auto' => $search->cliente_auto,
							'proveedor_auto' => $search->proveedor_auto,
							'localidad' => 1
						]);

					}else{

						$newFee = New Tarifa;
						$newFee->trayecto_id = $traslado->id;
						$newFee->cliente_auto = $search->cliente_auto;
						//$newFee->cliente_van = $tarifa_cliente_van;
						$newFee->proveedor_auto = $search->proveedor_auto;
						//$newFee->proveedor_van = $tarifa_proveedor_van;
						$newFee->centrodecosto_id = $clientes[$i];
						$newFee->estado = 1;
						$newFee->localidad = 1;
						$newFee->save();

					}

				}

			}

			$updates = DB::table('centrosdecosto')
			->where('id',$clientes[$i])
			->update([
				'tarifa_aotour' => 1
			]);

      	}

      	return Response::json([
      		'respuesta' => true,
      		'clientes' => $datas
      	]);
	}

	public function postUnirclienteproveedor() {

		$clientes = Input::get('idArray');

		$datas = '';

		$cantidad = count($clientes);

		for ($i=0; $i<count($clientes) ; $i++) {

			$traslados = DB::table('traslados')
			->get();

			foreach ($traslados as $traslado) {

				$search = DB::table('tarifas')
				->select('id', 'cliente_auto', 'cliente_van', 'proveedor_auto', 'proveedor_van', 'trayecto_id', 'centrodecosto_id')
				->where('trayecto_id',$traslado->id)
				->where('centrodecosto_id',97)
				->first();

				if($search!=null) {
					$update = DB::table('tarifas')
					->where('trayecto_id',$traslado->id)
					->where('centrodecosto_id',$clientes[$i])
					->update([
						//'cliente_auto' => $search->cliente_auto,
						'proveedor_auto' => $search->proveedor_auto,
						'proveedor_van' => $search->proveedor_van
					]);
				}

			}

			$updates = DB::table('centrosdecosto')
			->where('id',$clientes[$i])
			->update([
				'tarifa_aotour_proveedor' => 1
			]);

	        /*if(count($clientes)>1){

	          if($i==count($clientes)-1){
	            $coma = '';
	          }else{
	            $coma = ',';
	          }

	          $datas .= $clientes[$i].$coma;

	        }else{

	          $datas = $clientes[$i];

	        }*/

      	}

      	return Response::json([
      		'respuesta' => true,
      		'clientes' => $datas
      	]);
	}

	public function getTarifas(){

		if (Sentry::check()) {
			$id_rol = Sentry::getUser()->id_rol;
			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
			$permisos = json_decode($permisos);
		}else{
			$id_rol = null;
			$permisos = null;
			$permisos = null;
		}

		if (isset($permisos->administrativo->rutas_y_tarifas->ver)){
			$ver = $permisos->administrativo->rutas_y_tarifas->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$clientes = DB::table('centrosdecosto')
			->whereNull('inactivo_total')
			->whereNull('inactivo')
			->get();

			$ciudades = DB::table('ciudad')->orderBy('ciudad')->get();

			return View::make('parametros.tarifas_clientes')
			->with([
				'clientes'=>$clientes,
				'ciudades'=>$ciudades,
				'i'=>1,
				'permisos'=>$permisos
			]);
		}

	}

	public function getTarifascliente($id){

		if (Sentry::check()) {
			$id_rol = Sentry::getUser()->id_rol;
			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
			$permisos = json_decode($permisos);
		}else{
			$id_rol = null;
			$permisos = null;
			$permisos = null;
		}

		if (isset($permisos->administrativo->rutas_y_tarifas->ver)){
			$ver = $permisos->administrativo->rutas_y_tarifas->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$tarifas = DB::table('tarifas')
			->leftJoin('traslados', 'traslados.id', '=', 'tarifas.trayecto_id')
			->select('tarifas.*', 'traslados.nombre')
			->where('centrodecosto_id',$id)
			->get();

			$nombre_cliente = DB::table('centrosdecosto')
			->where('id',$id)
			->pluck('razonsocial');

			$ciudades = DB::table('ciudad')->orderBy('ciudad')->get();

			return View::make('parametros.trayectos_cliente')
			->with([
				'tarifas'=>$tarifas,
				'ciudades'=>$ciudades,
				'i'=>1,
				'permisos'=>$permisos,
				'nombre_cliente' => $nombre_cliente
			]);
		}

	}

	public function postImportarexcel(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else{

        	$nombres_ruta = null;

            Excel::selectSheetsByIndex(0)->load(Input::file('excels'), function($reader) use ($nombres_ruta){

                $reader->skip(1);
                $result = $reader->noHeading()->get();

                $trayectosArray = [];

                foreach($result as $value){

                    if(is_string($value[0])){

                        $dataExcel = [
                           'nombres' => $value[0], //TRAYECTO
                           'apellidos' => $value[1], //CLIENTE AUTO
                           'cedula' => $value[2], //CIENTE VAN
                           'direccion' => $value[3], //PROVEEDOR AUTO
                           'barrio' => $value[4], //PROVEEDOR VAN
                        ];

                        array_push($trayectosArray, $dataExcel);
                    }
                }
                echo json_encode([
                  'trayectos' => $trayectosArray,
                  'nombres_ruta' => $nombres_ruta,
                  //'apellidos_excel' => $apellidos_excel
                ]);

            });

        }

    }


    //BOGOTÁ
    public function getTrayectosbog(){

		if (Sentry::check()) {
			$id_rol = Sentry::getUser()->id_rol;
			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
			$permisos = json_decode($permisos);
		}else{
			$id_rol = null;
			$permisos = null;
			$permisos = null;
		}

		if (isset($permisos->administrativo->rutas_y_tarifas->ver)){
			$ver = $permisos->administrativo->rutas_y_tarifas->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$ruta_general = DB::table('traslados')
			->whereIn('ciudad',['bogota','provisional'])
			->get();

			$ciudades = DB::table('ciudad')->orderBy('ciudad')->get();

			$centrosdecosto = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->get();

			$clientes = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->whereIn('localidad',['bogota','provisional'])
			->whereNull('tarifa_aotour')
			//->where('id','!=', 97)
			->where('id','!=', 100)
			->where('id','!=', 407)
			->orderBy('razonsocial', 'asc')
			->get();

			//$select = "SELECT DISTINCT tarifas.centrodecosto_id, centrosdecosto.id as id_centro, centrosdecosto.razonsocial FROM tarifas LEFT JOIN centrosdecosto ON centrosdecosto.id = tarifas.centrodecosto_id WHERE centrosdecosto.id is not null AND tarifas.tarifa_aotour is null";

			$select = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is null and localidad in('bogota', 'provisional') and id!=292 and id!=407 and id!=100 order by razonsocial asc";


			$query = DB::select($select);

			//$consultas = "SELECT DISTINCT tarifas.centrodecosto_id, centrosdecosto.id as id_centro, centrosdecosto.razonsocial FROM tarifas LEFT JOIN centrosdecosto ON centrosdecosto.id = tarifas.centrodecosto_id WHERE centrosdecosto.id is not null and tarifas.tarifa_aotour is not null";

			$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour is not null and localidad in('bogota', 'provisional') and id!=97 and id!=407";

			$bd = DB::select($consultas);

			return View::make('parametros.trayectos_bog')
			->with([
				'ruta_general'=>$ruta_general,
				'centrosdecosto' => $centrosdecosto,
				'ciudades'=>$ciudades,
				'clientes' => $clientes,
				'i'=>1,
				'permisos'=>$permisos,
				'query' => $query,
				'bd' => $bd
			]);
		}

	}

	public function getTrayectosproveedorbog(){

		if (Sentry::check()) {
			$id_rol = Sentry::getUser()->id_rol;
			$permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
			$permisos = json_decode($permisos);
		}else{
			$id_rol = null;
			$permisos = null;
			$permisos = null;
		}

		if (isset($permisos->administrativo->rutas_y_tarifas->ver)){
			$ver = $permisos->administrativo->rutas_y_tarifas->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$ruta_general = DB::table('traslados')->get();

			$ciudades = DB::table('ciudad')->orderBy('ciudad')->get();

			$centrosdecosto = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->get();

			$clientes = DB::table('centrosdecosto')
			->whereNull('inactivo')
			->whereNull('inactivo_total')
			->whereIn('localidad',['bogota', 'provisional'])
			->whereNull('tarifa_aotour_proveedor')
			->where('id','!=', 292)
			->where('id','!=', 100)
			->where('id','!=', 407)
			->orderBy('razonsocial', 'asc')
			->get();

			$select = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour_proveedor is null and localidad in('bogota', 'provisional') and id!=292 and id!=407 and id!=100 order by razonsocial asc";


			$query = DB::select($select);

			$consultas = "SELECT id as id_centro, razonsocial FROM centrosdecosto WHERE inactivo is null and inactivo_total is null and tarifa_aotour_proveedor is not null and localidad in('bogota','provisional') and id!=292 and id!=407";

			$bd = DB::select($consultas);

			return View::make('parametros.trayectosproveedor_bog')
			->with([
				'ruta_general'=>$ruta_general,
				'centrosdecosto' => $centrosdecosto,
				'ciudades'=>$ciudades,
				'clientes' => $clientes,
				'i'=>1,
				'permisos'=>$permisos,
				'query' => $query,
				'bd' => $bd
			]);
		}

	}

}
