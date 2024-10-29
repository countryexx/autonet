<?php

class DepartamentosController extends BaseController{

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

        if (isset($permisos->administrativo->ciudades->ver)){
            $ver = $permisos->administrativo->ciudades->ver;
        }else{
            $ver = null;
        }

        //$ver = 'on';

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {
            $departamentos = DB::table('departamento')->orderby('id')->get();
            return View::make('parametros.departamentos')->with('departamentos', $departamentos);
        }

    }

    public function getVer($nombre){

      if (Sentry::check()) {
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
      }else{
        $id_rol = null;
        $permisos = null;
        $permisos = null;
      }

      if (isset($permisos->administrativo->ciudades->ver)){
          $ver = $permisos->administrativo->ciudades->ver;
      }else{
          $ver = null;
      }

      if (!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on' ) {
          return View::make('admin.permisos');
      }else {
        $departamento = $nombre;
        $iddepartamento = DB::table('departamento')->where('departamento', $nombre)->pluck('id');
        $ciudades = DB::table('ciudad')->where('departamento_id', $iddepartamento)->get();
        return View::make('parametros.ciudades')->with('ciudades',$ciudades)->with('departamento',$departamento);
      }

    }

    public function getVerbarrio($ciudad){

      $ver = null;

      if (Sentry::check()){

          $rol_id = Sentry::getUser()->id_rol;

          $permisos = json_decode(Rol::find($rol_id)->permisos);

          if (isset($permisos->administracion->usuarios->ver)) {

              $ver = $permisos->administracion->usuarios->ver;

              if($ver!='on') {

                  return Redirect::to('permiso_denegado');

              }else{

                $ciudad = Ciudad::where('ciudad', $ciudad)->first();
                $barrios = Barrio::where('ciudad_id', $ciudad->id)->get();

                return View::make('parametros.barrios', [
                  'barrios' => $barrios,
                  'ciudad' => $ciudad,
                  'permisos' => $permisos,
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

    public function postNuevobarrio(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

        if (Request::ajax()) {

          $rules = [
            'nombre' => 'required|min:3|letrasespacionumerosycoma|unique:barrios',
            'sector' => 'required|alpha|max:30',
            'ciudad_id' => 'required|numeric'
          ];

          $mensajes = [
            'nombre.required' => 'El campo barrio es requerido',
            'nombre.unique' => 'El dato digitado ya ha sido tomado',
            'nombre.sololetrasyespacio' => 'El campo barrio solo debe contener letras, espacios y numeros',
            'sector.required' => 'El campo sector es requerido',
            'sector.alpha' => 'Debe seleccionar el campo sector',
            'ciudad_id.required' => 'El campo ciudad es requerido',
            'ciudad_id.numeric' => 'El campo ciudad debe ser numerico',
          ];

          $validator = Validator::make(Input::all(), $rules, $mensajes);

          if ($validator->fails())
          {
              return Response::json([
                  'mensaje'=>false,
                  'errores'=>$validator->errors()->getMessages()
              ]);

          }else{

            $barrio = new Barrio();
            $barrio->nombre = strtoupper(Input::get('barrio'));
            $barrio->ciudad_id = Input::get('ciudad_id');
            $barrio->sector = strtoupper(Input::get('sector'));

            if ($barrio->save()) {
              return Response::json([
                'response' => true
              ]);
            }

          }

        }

      }

    }

    public function postModificarciudades(){

        if(Request::ajax()){

            $validaciones = [
                'ciudad'=>'required|sololetrasyespacio|unique:ciudad'
            ];

            $mensajes = [
                'ciudad.sololetrasyespacio'=>'Este campo solo debe tener letras y espacios'
            ];

            $validador = Validator::make(Input::all(), $validaciones,$mensajes);

            if ($validador->fails())
            {
                return Response::json([
                    'mensaje'=>false,
                    'errores'=>$validador->errors()->getMessages()
                ]);

            }else{

              /*  try
                {*/
                    $id_ciudad = Input::get('id_ciudad');
                    $valor_ciudad = Input::get('ciudad');
                    $ciudad = Ciudad::find($id_ciudad);
                    $ciudad->ciudad = $valor_ciudad;


                    if($ciudad->save()){

                        return Response::json([
                            'mensaje'=>true,
                            'respuesta'=>'Registro guardado correctamente!'
                        ]);

                    };

                }
               /* catch(Exception $ex)
                {
                    return Response::json([
                        'mensaje'=>false,
                        'ex'=>$ex
                    ]);
                }
            }*/
        }

    }

    public function postMostrarciudades(){

        $iddepartamento = Input::get('id');
        $ciudades = DB::table('ciudad')->where('departamento_id', $iddepartamento)->orderBy('ciudad')->get();

        if(!empty($ciudades)){

            return Response::json([
                'mensaje'=>true,
                'respuesta'=>$ciudades
            ]);

        }else if(empty($ciudades)){

            return Response::json([
                'mensaje'=>false
            ]);

        }
    }

    public function postMostrarciudadesnombre(){

        $ciudad = Input::get('ciudad');
        $ciudades = DB::table('ciudad')->where('ciudad', $ciudad)->orderBy('ciudad')->first();
        $ciudadess = DB::table('ciudad')->where('departamento_id',$ciudades->departamento_id)->get();

        if(!empty($ciudades)){
            return Response::json([
                'mensaje'=>true,
                'respuesta'=>$ciudades,
                'ciudades'=>$ciudadess
            ]);
        }else if(empty($ciudades)){
            return Response::json([
                'mensaje'=>false
            ]);
        }
    }

    public function postEliminarciudad(){

        if(Request::ajax()){
            $id_ciudad = Input::get('id_ciudad');
            $ciudad = Ciudad::find($id_ciudad);

            if($ciudad->delete()){
                return Response::json([
                    'mensaje'=>true,
                    'respuesta'=>'Registro guardado correctamente!'
                ]);
            };
        }
    }

    public function postMostrardepartamentos(){
        $departamentos = DB::table('departamento')->get();
        if(!empty($departamentos)){
            return Response::json([
                'mensaje'=>true,
                'respuesta'=>$departamentos
            ]);
        }
    }

    public function postGuardardepartamento(){

        if(Request::ajax()){

            $validaciones = [
                'departamento'=>'required|sololetrasyespacio|unique:departamento'
            ];

            $mensajes = [
                'departamento.sololetrasyespacio'=>'Este campo solo debe tener letras y espacios'
            ];


            $validador = Validator::make(Input::all(), $validaciones,$mensajes);

            if ($validador->fails())
            {
                return Response::json([
                    'mensaje'=>false,
                    'errores'=>$validador->errors()->getMessages()
                ]);

            }else{

                try
                {
                    $departamento = Input::get('departamento');
                    $departamentos = new Departamento;
                    $departamentos->departamento = $departamento;

                    if($departamentos->save()){

                        return Response::json([
                            'mensaje'=>true,
                            'respuesta'=>'Registro guardado correctamente!'
                        ]);

                    };

                }
                catch(Exception $ex)
                {
                    return Response::json([
                        'mensaje'=>false,
                        'ex'=>$ex
                    ]);
                }
            }
        }

    }

    public function postGuardarciudad(){
        if(Request::ajax()){

            $validaciones = [
                'id_departamento'=>'required|numeric',
                'ciudad'=>'required|sololetrasyespacio|unique:ciudad'
            ];

            $mensajes = [
                'ciudad.unique'=>'Esta ciudad ya ha sido tomada',
                'id_departamento.numeric'=>'Debe seleccionar un departamento',
                'ciudad.sololetrasyespacio'=>'Este campo solo debe tener letras y espacios'
            ];


            $validador = Validator::make(Input::all(), $validaciones,$mensajes);

            if ($validador->fails())
            {
                return Response::json([
                    'mensaje'=>false,
                    'errores'=>$validador->errors()->getMessages()
                ]);

            }else{

                try
                {
                    $departamento = Input::get('id_departamento');
                    $nombre_ciudad = Input::get('ciudad');
                    $ciudad = DB::table('ciudad')->insert(array(
                        'ciudad' => $nombre_ciudad,
                        'departamento_id' => $departamento)
                    );

                    if($ciudad){

                        return Response::json([
                            'mensaje'=>true,
                            'respuesta'=>'Registro guardado correctamente!'
                        ]);

                    };

                }
                catch(Exception $ex)
                {
                    return Response::json([
                        'mensaje'=>false,
                        'ex'=>$ex
                    ]);
                }
            }
        }
    }
}
