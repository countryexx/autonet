<?php

class RutasController extends BaseController{

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

		if (isset($permisos->administracion->usuarios->ver)){
			$ver = $permisos->administracion->usuarios->ver;
		}else{
			$ver = null;
		}

		if (!Sentry::check()){

			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

		}else if($ver!='on' ) {
			return View::make('admin.permisos');
		}else {

			$ruta_general = DB::table('ruta_general')->get();
			return View::make('parametros.rutas')
			->with([
				'ruta_general'=>$ruta_general,
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

					$ruta = new Ruta;
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
					$ruta->creado_por = Sentry::getUser()->id;

					if ($ruta->save()) {
						$rutaid = $ruta->id;
						$largo = strlen($rutaid);
						if($largo===1){
							$ruta = Ruta::find($rutaid);
							$ruta->codigo_ruta = 'RT0'.$rutaid;
							if($ruta->save()){
								return Response::json([
									'respuesta' => true
								]);
							}
						}else if($largo===2){
							$ruta = Ruta::find($rutaid);
							$ruta->codigo_ruta = 'RT'.$rutaid;
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

		$ruta_general = DB::table('ruta_general')->where('id',Input::get('id'))->first();

		if($ruta_general!=null){

			return Response::json([
				'respuesta'=>true,
				'ruta'=>$ruta_general
			]);

		}

	}

	public function postActualizar(){

		 $ruta_general = Ruta::find(Input::get('id'));
		 $ruta_general->nombre_ruta = Input::get('nombre');
		 $ruta_general->descripcion_ruta = Input::get('descripcion');
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
		 $ruta_general->actualizado_por = Sentry::getUser()->id;

		if($ruta_general->save()){

			return Response::json([
				'respuesta'=>true,
				'mensaje'=>'guardado'
			]);

		}

	}

	public function postEliminar(){

		 $ruta_general = Ruta::find(Input::get('id'));

		 if ($ruta_general->delete()) {
	 		return Response::json([
	 			'respuesta'=>true,
	 			'mensaje'=>'Eliminado!'
	 		]);
		 }

	}

}
