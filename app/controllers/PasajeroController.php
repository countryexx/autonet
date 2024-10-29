<?php

class PasajeroController extends BaseController{


  public function getIndex(){

    $centrosdecosto = Centrodecosto::orderBy('razonsocial', 'asc')->get();
    $pasajeros = Pasajero::with('centrodecosto')->get();

    return View::make('servicios.pasajeros.index', [
      'centrosdecosto' => $centrosdecosto,
      'pasajeros' => $pasajeros
    ]);
  }

  public function postCrear(){

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

      $pasajero = new Pasajero();
      $pasajero->nombres = Input::get('nombres');
      $pasajero->cedula = Input::get('cedula');
      $pasajero->apellidos = Input::get('apellidos');
      $pasajero->direccion = Input::get('direccion');
      $pasajero->barrio = Input::get('barrio');
      $pasajero->cargo = Input::get('cargo');
      $pasajero->area = Input::get('area');
      $pasajero->subarea = Input::get('subarea');
      $pasajero->centrodecosto_id = Input::get('centrodecosto_id');

      if ($pasajero->save()) {
        return Response::json([
          'response' => true
        ]);
      }

    }

  }

  public function postEliminar(){
    $pasajero = Pasajero::find(Input::get('pasajero_id'));
      if($pasajero->delete()){
        return Response::json([
        'response' => true
        ]);
      }
    }

    public function postBuscar(){
      $pasajero = Pasajero::find(Input::get('pasajero_id'));
      return Response::json([
        'response' => true,
        'pasajero'=> $pasajero
      ]);
    }

    public function postVerproveedores(){

        $tipo_afiliado = Input::get('tipo_afiliado');

        if ($tipo_afiliado==1) {

            $proveedores = Proveedor::all();

        }else if ($tipo_afiliado==287) {

            $proveedores = DB::table('pasajeros')->where('centrodecosto_id',287)->get(); //Proveedor::whereNull('tipo_afiliado')->orWhere('tipo_afiliado', 1)->orderBy('razonsocial')->get();

        }else if ($tipo_afiliado==3) {

            $proveedores = Proveedor::afiliadosexternos()->orderBy('razonsocial')->get();

        }else if($tipo_afiliado==4){

          $proveedores = Proveedor::bogota()->orderBy('razonsocial')->get();

        }else if($tipo_afiliado==5){

          $proveedores = Proveedor::barranquilla()->orderBy('razonsocial')->get();

        }

        return Response::json([
            'respuesta' => true,
            'proveedores' => $proveedores
        ]);

    }

    public function postBuscar2(){
      $pasajero = Pasajero::find(Input::get('pasajero_id'));
      $nombres = $pasajero->nombres;
      $apellidos = $pasajero->apellidos;
      $cedula = $pasajero->cedula;
      $direccion = $pasajero->direccion;
      $correo = $pasajero->correo;
      $arl = $pasajero->arl;
      //$barrio = $pasajero->barrio;
      $municipio = $pasajero->municipio;
      $departamento = $pasajero->departamento;
      $telefono = $pasajero->telefono;
      $area = $pasajero->area;
      $eps = $pasajero->eps;
      $subarea = $pasajero->sub_area;
      return Response::json([
        'response' => true,
        'nombres'=> $nombres,
        'apellidos'=> $apellidos,
        'cedula'=> $cedula,
        'direccion'=> $direccion,
        'correo'=> $correo,
        'arl'=> $arl,
        //'barrio'=> $barrio,
        'municipio'=> $municipio,
        'departamento'=> $departamento,
        'telefono'=> $telefono,
        'area'=> $area,
        'eps'=> $eps,
        'sub_area'=> $subarea,
      ]);
    }

    //
      public function postEditarpasajeroportal(){
      //no cargo area
      $rules = [
        'nombres' => 'required',
        'apellidos' => 'required',
        'cedula' => 'required|numeric',
        'direccion' => 'required',
        'barrio' => 'required',
        'area' => 'required',
        //'centrodecosto_id' => 'required|numeric'
      ];

     

      $validator = Validator::make(Input::all(), $rules);

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
        //$pasajero->centrodecosto_id = Input::get('centrodecosto_id');
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
            'response' => false
          ]);
        }
      }
  }

    //

    //GUARDAR CAMBIOS NUEVO SG
  public function postGuardarcambios(){

    if (!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else{ 

      if(Request::ajax()){

        $id = Input::get('id');

        $duplicado = DB::table('pasajeros')
        ->where('id_employer',Input::get('employ_id'))
        ->pluck('id_employer');

        $pasajero = Pasajero::find($id);
        
        if($duplicado!=null && $duplicado!=$pasajero->id_employer){
          return Response::json([
            'response' =>'employ'
          ]);
        }else{

          $pasajero = Pasajero::find($id);
          $nombre = Input::get('nombre');
          $apellido = Input::get('apellido');
          $employ_id = Input::get('employ_id');
          $telefono = Input::get('telefono');
          $direccion = strtoupper(Input::get('direccion'));
          $barrio = strtoupper(Input::get('barrio'));
          $campana = strtoupper(Input::get('campana'));
          $arl = strtoupper(Input::get('arl'));
          $localidad = strtoupper(Input::get('localidad'));


          
          $cambios = null;

          if(strtoupper($pasajero->nombres)!=$nombre){            
            $cambios = 'Se cambio el Nombre, de '.$pasajero->nombres.' a '.$nombre.'.';
            $pasajero->nombres = strtoupper($nombre);
          }
          if(strtoupper($pasajero->apellidos)!=strtoupper($apellido)){            
            $cambios .= 'Se cambio el Apellido, de '.$pasajero->apellidos.' a '.$apellido.'.';
            $pasajero->apellidos = strtoupper($apellido);
          }
          if($pasajero->id_employer!=$employ_id){            
            $cambios .= 'Se cambio el Employ ID, de '.$pasajero->id_employer.' a '.$employ_id.'.';
            $pasajero->id_employer = $employ_id;
          }
          if($pasajero->telefono!=$telefono){            
            $cambios .= 'Se cambio el Telefono, de '.$pasajero->telefono.' a '.$telefono.'.';
            $pasajero->telefono = $telefono;
          }
          if(strtoupper($pasajero->direccion)!=$direccion){            
            $cambios .= 'Se cambio la Direccion, de '.$pasajero->direccion.' a '.$direccion.'.';
            $pasajero->direccion = strtoupper($direccion);
          }
          if(strtoupper($pasajero->barrio)!=$barrio){            
            $cambios .= 'Se cambio el Barrio, de '.$pasajero->barrio.' a '.$barrio.'.';
            $pasajero->barrio = strtoupper($barrio);
          }
          if(strtoupper($pasajero->localidad)!=$localidad){            
            $cambios .= 'Se cambio el Barrio, de '.$pasajero->localidad.' a '.$localidad.'.';
            $pasajero->localidad = strtoupper($localidad);
          }
          /*if(strtoupper($pasajero->area)!=$campana){
            $pasajero->area = strtoupper($campana);
            $cambios .= 'Se cambió Campaña, de '.$pasajero->area.' a '.$campana.'.<br>';
          }
          if(strtoupper($pasajero->arl)!=$arl){
            $pasajero->arl = strtoupper($arl);
            $cambios .= 'Se cambió Campaña, de '.$pasajero->arl.' a '.$arl.'.<br>';
          }*/

          if(isset($cambios)){

            if($pasajero->cambios==null){
              $array = [
                'cambios' => $cambios,
                'fecha' => date('Y-m-d H:i:s')
              ];
              $pasajero->cambios = json_encode([$array]);
            }else{
              $array = [
                'cambios' => $cambios,
                'fecha' => date('Y-m-d H:i:s')
              ];
              $objArray = json_decode($pasajero->cambios);
              array_push($objArray, $array);
              $pasajero->cambios = json_encode($objArray);
            }

            if ($pasajero->save()){
              return Response::json([
                'response' => true,
                'cambios' => $array
              ]);
            }

          }else{

            return Response::json([
              'response' => false,
              'id' => $id
            ]);

          }    
        }
        

      }
    }    
  }
  //FIN GUARDAR CAMBIOS NUEVO SG


    //Guardar coordenadas
    public function postGuardarcoordenadas(){
      //no cargo area
      $rules = [
        'latitud' => 'required',
        'longitud' => 'required',
      ];

      $messages = [
        'latitud' => 'Debe seleccionar su ubicación en el mapa',
        'longitud' => 'Debe seleccionar su ubicación en el mapa'
      ];

      $validator = Validator::make(Input::all(), $rules, $messages);

      if ($validator->fails()){

        return Response::json([
          'response' => false,
          'errors' => $validator->messages()
        ]);

      }else {

        $latitude = substr(Input::get('latitud'), 0, 10);
        $longitude = substr(Input::get('longitud'), 0, 10);
        $ubicacion = [
          'latitude' => $latitude,
          'longitude' => $longitude,
          'timestamp' => date('Y-m-d H:i:s')
        ];
        $pasajero = Pasajero::find(Input::get('id_pasajero'));
        $pasajero->coordenadas = json_encode([$ubicacion]);;
        /*$pasajero->cedula = Input::get('cedula');
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
        $pasajero->centrodecosto_id = Input::get('centrodecosto_id');*/
        if ($pasajero->save()) {
          return Response::json([
            'response' => true
          ]);
        }else{
          return Response::json([
            'response' => false
          ]);
        }
      }
  }
    //fin guardar coordenadas

    //Nuevo editar pasajero
    public function postEditarpas(){
      //no cargo area
      $rules = [
        'nombres' => 'required',
        'apellidos' => 'required',
        'cedula' => 'required|numeric',
        'direccion' => 'required',
        'barrio' => 'required',
        'area' => 'required',
        //'centrodecosto_id' => 'required|numeric'
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
        if ($pasajero->save()) {
          return Response::json([
            'response' => true
          ]);
        }
      }
  }

    //fin nuevo editar pasajero

    public function postEditarpasajero(){
      //no cargo area
      $rules = [
        'nombres' => 'required',
        'apellidos' => 'required',
        'cedula' => 'required|numeric',
        'direccion' => 'required',
        'barrio' => 'required',
        'area' => 'required',
        //'centrodecosto_id' => 'required|numeric'
      ];

     

      $validator = Validator::make(Input::all(), $rules);

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
        //$pasajero->centrodecosto_id = Input::get('centrodecosto_id');
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
            'response' => false
          ]);
        }
      }
  }

    public function postEditar(){

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
        $pasajero->barrio = Input::get('barrio');
        $pasajero->cargo = Input::get('cargo');
        $pasajero->area = Input::get('area');
        $pasajero->subarea = Input::get('subarea');
        $pasajero->centrodecosto_id = Input::get('centrodecosto_id');

        if ($pasajero->save()) {
          return Response::json([
            'response' => true
          ]);
        }

      }

    }

    public function postMostrarqr(){

      $pasajero = Pasajero::find(Input::get('pasajero_id'));
      $qr_code = DNS2D::getBarcodePNG($pasajero->cedula, "QRCODE", 10, 10,array(1,1,1), true);

      return Response::json([
        'response' => true,
        'qr_code' => $qr_code
      ]);

    }

  }
