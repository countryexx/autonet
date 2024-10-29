<?php

class listadoController extends BaseController{

	public function getIndex(){

	   if (Sentry::check()){
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->administracion->listado_pasajeros->ver;
       
      }else{
        $ver = null;
      }
      if (!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else if($ver!='on') {
        return View::make('admin.permisos');
      }else{         
	      
        $centrosdecosto = Centrodecosto::Internos()->orderBy('razonsocial')->get();	  	      

        $pasajeros = DB::table('pasajeros')
        ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'pasajeros.centrodecosto_id')
        ->select('pasajeros.*',
                'pasajeros.nombres', 'pasajeros.apellidos', 'pasajeros.id_employer', 'pasajeros.cedula','pasajeros.direccion', 'pasajeros.telefono', 'pasajeros.correo', 'pasajeros.id')
        ->where('pasajeros.centrodecosto_id',287)
        ->get();        

        return View::make('servicios.pasajeros.listado')
          ->with('centrosdecosto',$centrosdecosto)
          ->with('permisos',$permisos)
          ->with('pasajeros', $pasajeros)
          ->with('o',$o=1);
        }
  }

  //
/*
public function postMostrar(){

      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      if (!Sentry::check())
      {
          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else {

          if(Request::ajax()){

            if (intval(Input::get('centrodecosto_id'))===0) {

              $pasajeros = DB::table('pasajeros')
              ->select('pasajeros.cedula','centrosdecosto.razonsocial as cedula')
              ->leftJoin('pasajeros','centrosdecosto.id','=','pasajero.centrodecosto_id')
              ->orderBy('razonsocial')
              ->get();

              if ($pasajeros!=null) {
                $array = [
                  'respuesta'=>true,
                  'pasajeros'=>$pasajeros
                ];
              }else{
                $array = [
                  'respuesta'=>false,
                  '1'=>'1'
                ];
              }

            }else if(intval(Input::get('centrodecosto_id'))!=0){

              $pasajeros = DB::table('pasajeros')
              ->select('pasajeros.cedula','pasajeros.nombres','pasajeros.area','pasajeros.sub_area','pasajeros.version','pasajeros.municipio','pasajeros.id_employer as pasajeros.id_employer')
              ->leftJoin('pasajeros','centrosdecosto.id','=','pasajeros.centrodecosto_id')
              ->where('pasajeros.centrodecosto_id',Input::get('centrodecosto_id'))
              ->orderBy('pasajeros.nombres')
              ->get();

              if ($pasajeros!=null) {
                $array = [
                  'respuesta'=>true,
                  'pasajeros'=>$pasajeros,
                  'permisos'=>$permisos
                ];
              }else{
                $array = [
                  'respuesta'=>false,
                  '2'=>'2',
                  'permisos'=>$permisos
                ];
              }
            }

            return Response::json($array);
          }
      }
    }
*/
  //

  public function postMostrarqr(){
    $pasajeros = Pasajero::find(Input::get('pasajero_id'));
    $qr_code = DNS2D::getBarcodePNG($pasajeros->cedula, "QRCODE", 10, 10,array(1,1,1), true);

    return Response::json([
      'response' => true,
      'qr_code' => $qr_code
    ]);
  }

  public function postEliminarpas(){
    $pasajero = Pasajero::find(Input::get('pasajero_id'));
    $pasajero->estado = 0;
    if ($pasajero->delete()) {
      return Response::json([
        'response' => true
      ]);
      } 
  }

  public function postEditarpas(){
      //no cargo area
      $rules = [
        'nombres' => 'required',
        'apellidos' => 'required',
        'cedula' => 'required|numeric',
        'direccion' => 'required',
        'barrio' => 'required',
        'area' => 'required',
        'centrodecosto_id' => 'required|numeric'
      ];

      $messages = [
        'centrodecosto_id.numeric' => 'Debe seleccionar el campo centro de costo'
      ];

      $validator = Validator::make(Input::all(), $rules, $messages);

      if ($validator->fails()){

        return Response::json([
          'response' => false,
          'errors' => $validator->messages()
        ]);

      }else {

        $pasajero = Pasajero::find(Input::get('pasajero_id'));
        $pasajero->nombres = Input::get('nombres');
        $pasajero->cedula = Input::get('cedula');
        $pasajero->apellidos = Input::get('apellidos');
        $pasajero->direccion = Input::get('direccion');
        $pasajero->correo = Input::get('email');
        $pasajero->arl = Input::get('arl');
        $pasajero->barrio = Input::get('barrio');
        $pasajero->telefono = Input::get('telefono');
        $pasajero->area = Input::get('area');
        $pasajero->sub_area = Input::get('subarea');
        $pasajero->municipio = Input::get('municipio');
        $pasajero->departamento = Input::get('departamento');
        $pasajero->eps = Input::get('eps');
        $pasajero->centrodecosto_id = Input::get('centrodecosto_id');
       /* $pasajero = Pasajero::find(Input::get('pasajero_id'));
        $pasajero->nombres = Input::get('nombres');
        //$pasajero->cedula = Input::get('cedula');
        $pasajero->apellidos = Input::get('apellidos');
        $pasajero->direccion = Input::get('direccion');
        $pasajero->correo = Input::get('correo');
        $pasajero->arl = Input::get('arl');
        $pasajero->barrio = Input::get('barrio');
        $pasajero->telefono = Input::get('telefono');
        $pasajero->area = Input::get('area');
        $pasajero->subarea = Input::get('subarea');*/
        if ($pasajero->save()) {
          return Response::json([
            'response' => true
          ]);
        }
      }
  }
}

?>