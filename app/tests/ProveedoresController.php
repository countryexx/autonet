<?php

class ProveedoresController extends BaseController{

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

        if (isset($permisos->administrativo->proveedores->ver)){
            $ver = $permisos->administrativo->proveedores->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {

            $proveedores = Proveedor::afiliadosinternos()
            ->whereNull('inactivo')
            ->whereNull('inactivo_total')
            ->orderBy('razonsocial')
            ->get();

            $departamentos = DB::table('departamento')->get();

            return View::make('proveedores.proveedores')
                ->with([
                    'departamentos' => $departamentos,
                    'proveedores' => $proveedores,
                    'permisos' => $permisos
                ]);
        }
    }

    /**
     * @return mixed
     */
    public function getProveedoreventual(){

          if (Sentry::check()) {
            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
          }else{
            $id_rol = null;
            $permisos = null;
            $permisos = null;
          }

          if (isset($permisos->administrativo->proveedores->ver)){
              $ver = $permisos->administrativo->proveedores->ver;
          }else{
              $ver = null;
          }

          if (!Sentry::check()){

              return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

          }else if($ver!='on' ) {
              return View::make('admin.permisos');
          }else {

          $proveedor_eventual = DB::table('proveedores')->where('eventual',1)->orderBy('razonsocial')->get();

          return View::make('proveedores.proveedoreventual',[
            'proveedor_eventual'=>$proveedor_eventual,
            'permisos'=>$permisos
          ]);

        }
      }

      public function postNuevoproveedor(){

          if (!Sentry::check()){

              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else{

              if(Request::ajax()){

                  if (Input::get('tipoempresa')==='P.N') {

                      $validaciones = [
                          'nit'=>'required|numeric|unique:proveedores',
                          'tipo_afiliado'=>'required|numeric|digits:1',
                          'digitoverificacion'=>'required|numeric|digits:1',
                          'razonsocial'=>'required|letrasnumerosyespacios|unique:proveedores',
                          'tipoempresa'=>'required|select',
                          'localidad'=>'required|select',
                          'direccion'=>'required',
                          'departamento'=>'required|sololetrasyespacio|select',
                          'ciudad'=>'required|sololetrasyespacio|select',
                          'email'=>'email|unique:proveedores',
                          'telefono'=>'numeric|unique:proveedores',
                          'celular'=>'numeric',
                          'tipo_servicio_pn'=>'required|select'

                      ];

                      $mensajes = [
                          'digitoverificacion.required'=>'El campo digito verificacion es requerido',
                          'digitoverificacion.numeric'=>'El campo digito verificacion debe ser un numero',
                          'digitoverificacion.digits'=>'El campo digito verificacion debe ser de 1 digito',
                          'razonsocial.letrasnumerosyespacios'=>'El campo razon social solo debe contener letras numeros y espacios',
                          'razonsocial.required'=>'El campo razon social es requerido',
                          'tipoempresa.select'=>'Debe seleccionar el tipo de empresa',
                          'localidad.select'=>'Debe seleccionar la localidad',
                          'departamento.select'=>'Debe seleccionar un departamento valido',
                          'departamento.sololetrasyespacio'=>'Debe seleccionar una ciudad',
                          'ciudad.sololetrasyespacio'=>'Debe seleccionar una ciudad',
                          'ciudad.select'=>'Debe seleccionar una ciudad valida',
                          'tipo_servicio_pn.select'=>'Debe seleccionar un tipo de servicio'
                      ];

                      $validador = Validator::make(Input::all(), $validaciones,$mensajes);

                      if ($validador->fails()){

                          return Response::json([
                              'mensaje'=>false,
                              'errores'=>$validador->errors()->getMessages()
                          ]);

                      }else{

                          $proveedor = new Proveedor();
                          $proveedor->nit = Input::get('nit');
                          $proveedor->codigoverificacion = Input::get('digitoverificacion');
                          $proveedor->tipo_afiliado = Input::get('tipo_afiliado');
                          $proveedor->razonsocial = Input::get('razonsocial');
                          $proveedor->tipoempresa = Input::get('tipoempresa');
                          $proveedor->localidad = Input::get('localidad');
                          $proveedor->direccion = Input::get('direccion');
                          $proveedor->departamento = Input::get('departamento');
                          $proveedor->ciudad = Input::get('ciudad');
                          $proveedor->telefono = Input::get('telefono');
                          $proveedor->celular = Input::get('celular');
                          $proveedor->email = Input::get('email');
                          $proveedor->tipo_servicio = Input::get('tipo_servicio_pn');

                          if($proveedor->save()){

                              return Response::json([
                                  'mensaje'=>true,
                                  'respuesta'=>'Registro guardado correctamente!'
                              ]);
                          }
                      }

                  }else{

                      $validaciones = [
                          'nit'=>'required|numeric|digits:9|unique:proveedores',
                          'tipo_afiliado'=>'required|numeric|digits:1',
                          'digitoverificacion'=>'required|numeric|digits:1',
                          'razonsocial'=>'required|letrasnumerosyespacios|unique:proveedores',
                          'tipoempresa'=>'required|select',
                          'localidad'=>'required|select',
                          'representante'=>'required|sololetrasyespacio',
                          'cedula'=>'required|numeric',
                          'direccion'=>'required',
                          'departamento'=>'required|sololetrasyespacio|select',
                          'ciudad'=>'required|sololetrasyespacio|select',
                          'email'=>'email|unique:proveedores',
                          'telefono'=>'numeric|unique:proveedores',
                          'celular'=>'numeric',
                          'contacto_nombrecompleto'=>'required|sololetrasyespacio',
                          'cargo'=>'sololetrasyespacio',
                          'email_contacto'=>'email',
                          'telefono_contacto'=>'numeric',
                          'celular_contacto'=>'numeric',
                          'actividad_economica'=>'required|sololetrasyespacio',
                          'codigo_actividad'=>'required|numeric|digits:4',
                          'codigo_ica'=>'required|numeric|digits:3',
                          'tipo_servicio'=>'select|required'
                      ];

                      $mensajes = [
                          'digitoverificacion.required'=>'El campo digito verificacion es requerido',
                          'digitoverificacion.numeric'=>'El campo digito verificacion debe ser un numero',
                          'digitoverificacion.digits'=>'El campo digito verificacion debe ser de 1 digito',
                          'cargo.sololetrasyespacios'=>'El campo cargo solo debe tener letras y espacios',
                          'razonsocial.letrasnumerosyespacios'=>'El campo razon social solo debe contener letras numeros y espacios',
                          'localidad.select'=>'Debe seleccionar la localidad',
                          'razonsocial.required'=>'El campo razon social es requerido',
                          'tipoempresa.select'=>'Debe seleccionar el tipo de empresa',
                          'departamento.select'=>'Debe seleccionar un departamento valido',
                          'departamento.sololetrasyespacio'=>'Debe seleccionar una ciudad',
                          'ciudad.sololetrasyespacio'=>'Debe seleccionar una ciudad',
                          'ciudad.select'=>'Debe seleccionar una ciudad valida',
                          'tipo_servicio.select'=>'Debe seleccionar un tipo de servicio'
                      ];

                      $validador = Validator::make(Input::all(), $validaciones,$mensajes);

                      if ($validador->fails()){

                          return Response::json([
                              'mensaje'=>false,
                              'errores'=>$validador->errors()->getMessages()
                          ]);

                      }else{

                          $proveedor = new Proveedor();
                          $proveedor->nit = Input::get('nit');
                          $proveedor->tipo_afiliado = Input::get('tipo_afiliado');
                          $proveedor->codigoverificacion = Input::get('digitoverificacion');
                          $proveedor->razonsocial = Input::get('razonsocial');
                          $proveedor->tipoempresa = Input::get('tipoempresa');
                          $proveedor->representantelegal = Input::get('representante');
                          $proveedor->cc = Input::get('cedula');
                          $proveedor->direccion = Input::get('direccion');
                          $proveedor->departamento = Input::get('departamento');
                          $proveedor->ciudad = Input::get('ciudad');
                          $proveedor->telefono = Input::get('telefono');
                          $proveedor->localidad = Input::get('localidad');
                          $proveedor->celular = Input::get('celular');
                          $proveedor->email = Input::get('email');
                          $proveedor->nombre_completo = Input::get('contacto_nombrecompleto');
                          $proveedor->cargo = Input::get('cargo');
                          $proveedor->email_contacto = Input::get('email_contacto');
                          $proveedor->telefono_contacto = Input::get('telefono_contacto');
                          $proveedor->celular_contacto = Input::get('celular_contacto');
                          $proveedor->actividad_economica = Input::get('actividad_economica');
                          $proveedor->codigo_actividad = Input::get('codigo_actividad');
                          $proveedor->codigo_ica = Input::get('codigo_ica');
                          $proveedor->tarifa_ica = Input::get('codigo_ica');
                          $proveedor->codigo_ica = Input::get('codigo_ica');
                          $proveedor->tipo_servicio = Input::get('tipo_servicio');

                          if($proveedor->save()){

                              return Response::json([
                                  'mensaje'=>true,
                                  'respuesta'=>'Registro guardado correctamente!'
                              ]);
                          }
                      }
                  }

              }
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

          if (isset($permisos->administrativo->proveedores->ver)){
              $ver = $permisos->administrativo->proveedores->ver;
          }else{
              $ver = null;
          }

          if (!Sentry::check()){

              return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

          }else if($ver!='on' ) {
              return View::make('admin.permisos');
          }else {
              $proveedores = DB::table('proveedores')->where('razonsocial',$nombre)->get();
              foreach($proveedores as $proveedor){
                  $id = $proveedor->id;
              }
              return View::make('proveedores.proveedoresdetalles')
                  ->with([
                      'proveedores'=>$proveedores,
                      'id'=>$id,
                      'permisos'=>$permisos
                  ]);
          }
      }

      public function getEnviarsmsconductores(){
        if(Sentry::check()){
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->administrativo->proveedores->ver)){
          $ver = $permisos->administrativo->proveedores->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {        
          $conductores = DB::table('conductores')->where('estado','activo')->orderBy('nombre_completo')->get();
          return View::make('proveedores.conductoressms')
          ->with([
              'conductores'=>$conductores,            
              'permisos'=>$permisos
          ]);
        }
      }

      public function postEnviarm2(){
        if(Sentry::check()){
          if(Request::ajax()){ 

            $rules = [
              'sms' => 'required',              
            ];
            $messages = [
              'sms.required' => 'El campo del mensaje esta vacio'
            ];

            $validator = Validator::make(Input::all(), $rules,$messages);

            if ($validator->fails()) {

              return Response::json([
                'errors' => $validator->messages(),
                'mensaje' => 'sintexto'
              ]);

            }else {

                $objArray = [];
                $valores = Input::get('valores');
                if($valores!=''){
                  $cantidad = explode(',', Input::get('valores'));              
                  $smstext = Input::get('sms');
                  for($i = 0; $i< count($cantidad) ; $i++){                                
                    $id = $cantidad[$i];
                    $query = Conductor::find($id);
                    $destino = $query->celular;

                    $post['to'] = array('57'.$destino);
                    $post['text'] = $smstext;
                    $post['from'] = "msg";
                    $user ="Aotour";
                    $password = 'Tour20+';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "http://sms.puntodigitalip.com/Api/rest/message");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
                    curl_setopt($ch, CURLOPT_HTTPHEADER,
                    array(
                    "Accept: application/json",
                    "Authorization: Basic ".base64_encode($user.":".$password)));
                    $result = curl_exec ($ch);
                        
                    $adicion = [
                      'id' => $id,
                      'nombre_conductor' => $query->nombre_completo,
                      'telefono' => $query->celular
                    ];       
                    array_push($objArray, $adicion);   
                  }
                }else{
                    //$conductores = DB::table('conductores')->whereIn('id',[332,534])->get();
                  $conductores = DB::table('conductores')->where('estado','ACTIVO')->get();
                    $smstext = Input::get('sms');
                    for($i = 0; $i< count($conductores) ; $i++){
                        //envio de mensaje
                        $destino = trim($conductores[$i]->celular);                
                        $post['to'] = array('57'.$destino);
                        $post['text'] = $smstext;
                        $post['from'] = "msg";
                        $user ="Aotour";
                        $password = 'Tour20+';
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "http://sms.puntodigitalip.com/Api/rest/message");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
                        curl_setopt($ch, CURLOPT_HTTPHEADER,
                        array(
                        "Accept: application/json",
                        "Authorization: Basic ".base64_encode($user.":".$password)));
                        $result = curl_exec ($ch);

                        $adicion = [
                          'id' => $conductores[$i]->id,
                          'nombre_conductor' => $conductores[$i]->nombre_completo,
                          'telefono' => $conductores[$i]->celular
                        ];       
                        array_push($objArray, $adicion);
                    }
                }
                
                $sms = new HistorialSms();
                $sms->mensaje = Input::get('sms');
                $sms->enviado_por = Sentry::getUser()->id;
                $sms->destinatarios = json_encode($objArray);
                $sms->save();              
                //if(){
                  return Response::json([
                    'mensaje'=>true
                  ]);     
                //}
              }
          }          
        }else{
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
        }
      }

      public function getEnviarm(){
        if(Sentry::check()){
          if(Request::ajax()){     
            $conductores = Input::get('valores');
            $smstext = Input::get('sms');
            for($i = 0; $i< count($conductores) ; $i++){
              $conductor = DB::table('conductores')->where('id',$conductores[$i])->get();
                //envio de mensaje
                $destino = trim($conductor[$i]->celular);                
                $post['to'] = array('57'.$destino);
                $post['text'] = $smstext;
                $post['from'] = "msg";
                $user ="Aotour";
                $password = 'Tour20+';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://sms.puntodigitalip.com/Api/rest/message");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
                curl_setopt($ch, CURLOPT_HTTPHEADER,
                array(
                "Accept: application/json",
                "Authorization: Basic ".base64_encode($user.":".$password)));
                $result = curl_exec ($ch);
            }
            //$conductores = DB::table('conductores')->where('estado','ACTIVO')->get();
            
            if($conductores){
              return Response::json([
                'mensaje'=>true
              ]);     
            }
          }
        }else{
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
        }
      }

      public function getConductores($id){

          if(Sentry::check()){

            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);

          }else{

            $id_rol = null;
            $permisos = null;
            $permisos = null;

          }

          if (isset($permisos->administrativo->proveedores->ver)){
              $ver = $permisos->administrativo->proveedores->ver;
          }else{
              $ver = null;
          }

          if (!Sentry::check()){

              return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

          }else if($ver!='on' ) {
              return View::make('admin.permisos');
          }else {

              $razonsocial = DB::table('proveedores')->where('id',$id)->get();
              foreach($razonsocial as $razon){
                  $nombre_razonsocial = $razon->razonsocial;
              }
              $departamentos = DB::table('departamento')->get();
              $conductores = DB::table('conductores')->where('proveedores_id',$id)->get();
              return View::make('proveedores.conductores')
              ->with([
                  'conductores'=>$conductores,
                   'id'=>$id,
                   'nombre_razonsocial'=>$nombre_razonsocial,
                   'departamentos'=>$departamentos,
                   'i'=>1,
                  'permisos'=>$permisos
              ]);
          }
      }

      public function getListadoconductores(){

          if(Sentry::check()){
            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
          }else{
            $id_rol = null;
            $permisos = null;
            $permisos = null;
          }

          if (isset($permisos->administrativo->proveedores->ver)){
              $ver = $permisos->administrativo->proveedores->ver;
          }else{
              $ver = null;
          }

          if (!Sentry::check()){

              return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

          }else if($ver!='on' ) {
              return View::make('admin.permisos');
          }else {

            $conductores = Conductor::whereHas('proveedor', function($query){

              $query->whereNull('eventual')->whereNull('inactivo_total');

            })->noarchivado()->orderBy('nombre_completo')->get();

            return View::make('proveedores.listado_conductores',[
                'conductores'=>$conductores,
                'permisos'=>$permisos
            ]);
          }
      }

      public function postCargarproveedores(){

        if (!Sentry::check()){

          return Response::json([
            'respuesta'=>'relogin'
          ]);

        }else {

          if(Request::ajax()){

            $option = intval(Input::get('option'));
            $proveedores = [];

            if ($option===1) {

              $proveedores = Proveedor::valido()->afiliadoseventuales()->orderBy('razonsocial')->get();

            }else if($option===2){

              $proveedores = Proveedor::valido()->afiliadosinternos()->orderBy('razonsocial')->get();

            }

            if ($proveedores!=null) {
              return Response::json([
                'respuesta'=>true,
                'proveedores'=>$proveedores
              ]);
            }else{
              return Response::json([
                'respuesta'=>false
              ]);
            }

          }
        }
      }

      /**
       * FUNCION PARA CREAR PROVEEDORES EVENTUALES
       */
      public function postAgregarproveedoreventual(){

          if (!Sentry::check()){

              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if (Request::ajax()) {

                  $validaciones = [
                      'nit'=>'required|numeric',
                      'razonsocial'=>'required'
                  ];

                  $mensajes = [
                      'nit.required'=>'El campo nit es requerido!',
                      'nit.numeric'=>'El campo nit debe ser numerico!'
                  ];

                  $validador = Validator::make(Input::all(), $validaciones,$mensajes);

                  if ($validador->fails())
                  {
                      return Response::json([
                          'mensaje'=>false,
                          'errores'=>$validador->errors()->getMessages()
                      ]);

                  }else{

                      $gtProv = Input::all();

                      $proveedor = new Proveedor();
                      $proveedor->nit = $gtProv['nit'];
                      $proveedor->razonsocial = $gtProv['razonsocial'];
                      $proveedor->eventual = 1;
                      $proveedor->tipo_servicio = 'TRANSPORTE TERRESTRE';

                      if($proveedor->save()){
                          return Response::json([
                              'respuesta'=>true
                          ]);
                      }
                  }
              }
          }
      }
      /**
       * FUNCION PARA CARGAR LOS DATOS DE LOS
       * PROVEEDORES EVENTUALES EN EL FORMULARIO
       */
      public function postMostrarproveedoreventual(){

          if (!Sentry::check()){

              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if (Request::ajax()) {
                  $id = Input::get('id');
                  $proveedor_eventual = DB::table('proveedores')->where('id',$id)->first();
                  return Response::json([
                      'respuesta'=>true,
                      'proveedor_eventual'=>$proveedor_eventual
                  ]);
              }
          }
      }

      /**
       * FUNCION PARA ACTUALIZAR LOS DATOS DE PROVEEDOR EVENTUAL
       */
      public function postActualizarproveedoreventual(){

          if (!Sentry::check()){

              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if (Request::ajax()) {

                  $get = Input::all();

                  $proveedor_eventual = Proveedor::find($get['id']);
                  $proveedor_eventual->nit = $get['nit'];
                  $proveedor_eventual->razonsocial = $get['razonsocial'];

                  if ($proveedor_eventual->save()){
                      return Response::json([
                          'respuesta'=>true,
                          'proveedor_eventual'=>$proveedor_eventual
                      ]);
                  }
              }
          }
      }

      /**
       * FUNCION PARA GUARDAR LOS CONDUCTORES EVENTUALES
       */
      public function postAgregarconductoreventual(){

          if (!Sentry::check()){

              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if(Request::ajax()) {

                  try{

                      $id = Input::get('id');
                      $nombre_completo = Input::get('nombre_completo');
                      $identificacion = Input::get('identificacion');
                      $celular = Input::get('celular');

                      $conductor = new Conductor();
                      $conductor->nombre_completo = $nombre_completo;
                      $conductor->cc = $identificacion;
                      $conductor->celular = $celular;
                      $conductor->proveedores_id = $id;
                      $conductor->eventual = 1;

                      if($conductor->save()){
                          return Response::json([
                              'respuesta'=>true,
                              'conductor'=>$conductor
                          ]);
                      }else{
                          return Response::json([
                              'respuesta'=>false
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

      /**
       * FUNCION PARA CARGAR LOS CONDUCTORES EVENTUALES POR PROVEEDOR
       */
      public function postMostrarconductores(){

          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);

          if (!Sentry::check()){

              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if (Request::ajax()) {

                  $id = Input::get('id');
                  $conductores = Conductor::where('proveedores_id', '=', $id)->get();

                  return Response::json([
                      'respuesta'=>true,
                      'conductores'=>$conductores,
                      'permisos'=>$permisos
                  ]);
              }
          }
      }

      /**
       * FUNCION PARA ACTUALIZAR LOS DATOS DE LOS CONDUCTORES EVENTUALES
       */
      public function postActualizarconductoreventual(){

          if (!Sentry::check()){

              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if (Request::ajax()) {

                  try{

                      $getConductor = Input::all();

                      $conductor = Conductor::find($getConductor['id']);
                      $conductor->nombre_completo = $getConductor['nombre_completo'];
                      $conductor->cc = $getConductor['identificacion'];
                      $conductor->celular = $getConductor['celular'];

                      if($conductor->save()){
                          return Response::json([
                              'respuesta'=>true,
                              'conductor'=>$conductor
                          ]);
                      }else{
                          return Response::json([
                             'respuesta'=>false
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

      /**
       * FUNCION PARA AGREGAR LOS VEHICULOS EVENTUALES
       */
      public function postAgregarvehiculoeventual(){

          if (!Sentry::check()){

              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if(Request::ajax()) {

                  try{

                      $getVehiculo = Input::all();

                      $vehiculo = new Vehiculo();
                      $vehiculo->placa = $getVehiculo['placa'];
                      $vehiculo->clase = $getVehiculo['clase'];
                      $vehiculo->marca = $getVehiculo['marca'];
                      $vehiculo->modelo = $getVehiculo['linea'];
                      $vehiculo->proveedores_id = $getVehiculo['id'];
                      $vehiculo->eventual = 1;

                      if($vehiculo->save()){
                          return Response::json([
                              'respuesta'=>true,
                              'vehiculo'=>$vehiculo
                          ]);
                      }else{
                          return Response::json([
                              'respuesta'=>false
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

      /**
       * FUNCION PARA MOSTRAR LOS VEHICULOS EVENTUALES
       */
      public function postMostrarvehiculos(){

          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);

          if (!Sentry::check()){

              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if (Request::ajax()) {

                  $id = Input::get('id');
                  $vehiculos = Vehiculo::where('proveedores_id', '=', $id)->get();

                  return Response::json([
                      'respuesta'=>true,
                      'vehiculos'=>$vehiculos,
                      'permisos'=>$permisos
                  ]);
              }
          }
      }

      public function postActualizarvehiculoeventual(){

          if (!Sentry::check()){

              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if (Request::ajax()) {

                  $getVehiculo = Input::all();

                  $vehiculo = Vehiculo::find($getVehiculo['id']);
                  $vehiculo->placa = $getVehiculo['placa'];
                  $vehiculo->clase = $getVehiculo['clase'];
                  $vehiculo->marca = $getVehiculo['marca'];
                  $vehiculo->modelo = $getVehiculo['linea'];

                  if($vehiculo->save()){
                      return Response::json([
                          'respuesta'=>true,
                          'vehiculo'=>$vehiculo
                      ]);
                  }else{
                      return Response::json([
                          'respuesta'=>false
                      ]);
                  }
              }
          }
      }

      public function postMostrarconductor(){

          if (!Sentry::check())
          {
              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if(Request::ajax()){

                  $conductor_id = Input::get('conductor_id');
                  $proveedor_id = Input::get('proveedor_id');

                  $conductor = Conductor::find($conductor_id);

                  if ($conductor){
                      return Response::json([
                          'mensaje'=>true,
                          'respuesta'=>$conductor
                      ]);
                  }
              }
          }
      }

      public function postNuevoconductor(){

          if (!Sentry::check())
          {
              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if(Request::ajax()){

                  $validaciones = [
                      'fecha_vinculacion'=>'required|date_format:Y-m-d',
                      'departamento'=>'required|select',
                      'ciudad'=>'required|select',
                      'nombre_completo'=>'required|letrasnumerosyespacios',
                      'cc'=>'required|numeric',
                      'celular'=>'required|numeric',
                      'telefono'=>'numeric',
                      'direccion'=>'required',
                      'tipodelicencia'=>'required|select',
                      'fecha_licencia_expedicion'=>'required|date_format:Y-m-d',
                      'fecha_licencia_vigencia'=>'required|date_format:Y-m-d',
                      'edad'=>'required|numeric',
                      'genero'=>'required|select',
                      'grupo_trabajo'=>'required|select',
                      'tipo_contrato'=>'required|select',
                      'cargo'=>'required|select',
                      'experiencia'=>'required',
                      'accidentes'=>'required|select',
                      'incidentes'=>'required|select',
                      'vehiculo_propio_desplazamiento'=>'required|select',
                      'trayecto_casa_trabajo'=>'required|select',
                      'foto' => 'mimes:jpeg,bmp,png'
                  ];

                  $mensajes = [
                      'nombre_completo.sololetrasyespacios'=>'El nombre solo debe tener espacios y letras',
                      'foto.mimes'=>'La imagen debe ser un archivo de tipo imagen (jpg-bmp-png)',
                      'tipolicencia.select'=>'Seleccione un valor valido para el tipo de licencia'
                  ];

                  $validador = Validator::make(Input::all(), $validaciones,$mensajes);

                  if ($validador->fails())
                  {
                      return Response::json([
                          'mensaje'=>false,
                          'errores'=>$validador->errors()->getMessages()
                      ]);

                  }else{

                      $conductor = new Conductor();
                      $conductor->fecha_vinculacion = Input::get('fecha_vinculacion');
                      $conductor->departamento = Input::get('departamento');
                      $conductor->ciudad = Input::get('ciudad');
                      $conductor->nombre_completo = Input::get('nombre_completo');
                      $conductor->cc = Input::get('cc');
                      $conductor->celular = Input::get('celular');
                      if (Input::get('telefono')==='') {
                          $conductor->telefono = null;
                      }else{
                          $conductor->telefono = Input::get('telefono');
                      }

                      $conductor->direccion = Input::get('direccion');
                      $conductor->tipodelicencia = Input::get('tipodelicencia');
                      $conductor->fecha_licencia_expedicion = Input::get('fecha_licencia_expedicion');
                      $conductor->fecha_licencia_vigencia = Input::get('fecha_licencia_vigencia');
                      $conductor->edad = Input::get('edad');
                      $conductor->genero = Input::get('genero');
                      $conductor->grupo_trabajo = Input::get('grupo_trabajo');
                      $conductor->tipo_contrato = Input::get('tipo_contrato');
                      $conductor->cargo = Input::get('cargo');
                      $conductor->experiencia = Input::get('experiencia');
                      $conductor->accidentes = Input::get('accidentes');
                      $conductor->descripcion_accidente = Input::get('descripcion_accidente');
                      $conductor->incidentes = Input::get('incidentes');
                      $conductor->frecuencia_desplazamiento = Input::get('frecuencia_desplazamiento');
                      $conductor->vehiculo_propio_desplazamiento = Input::get('vehiculo_propio_desplazamiento');
                      $conductor->trayecto_casa_trabajo = Input::get('trayecto_casa_trabajo');
                      $conductor->proveedores_id = Input::get('proveedores_id');
                      $conductor->estado = 'ACTIVO';
                      $conductor->creado_por = Sentry::getUser()->id;

                      if (Input::hasFile('foto')){
                          $file = Input::file('foto');
                          $ubicacion = 'biblioteca_imagenes/proveedores/conductores/';
                          $nombre_imagen = $file->getClientOriginalName();
                          if(file_exists($ubicacion.$nombre_imagen)){
                              $nombre_imagen = rand(1,100).$nombre_imagen;
                          }
                          $conductor->foto = $nombre_imagen;
                      }else{
                          $conductor->foto = 'FALSE';
                      }

                      if($conductor->save()){

                          if (Input::hasFile('foto')){
                              Image::make($file->getRealPath())->resize(250, 316)->save($ubicacion.$nombre_imagen);
                          }

                          return Response::json([
                              'mensaje'=>true,
                              'respuesta'=>'Registro guardado correctamente!'
                          ]);
                      }
                  }
              }
          }
      }

      public function postCambiarimagen(){

          if (!Sentry::check()){

              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if(Request::ajax()){

                  $validaciones = [
                      'foto_perfil' => 'mimes:jpeg,bmp,png|max:512'
                  ];

                  $mensajes = [
                      'foto_perfil.mimes'=>'La imagen debe ser un archivo de tipo imagen (jpg-bmp-png)'
                  ];

                  $validador = Validator::make(Input::all(), $validaciones,$mensajes);

                  if ($validador->fails()){

                      return Response::json([
                          'mensaje'=>false,
                          'errores'=>$validador->errors()->getMessages()
                      ]);

                  }else{

                      $file = null;
                      $nombre_imagen = null;

                      $conductor = Conductor::find(Input::get('conductor_id'));

                      if (Input::hasFile('foto_perfil')){

                        $file = Input::file('foto_perfil');
                        $ubicacion = 'biblioteca_imagenes/proveedores/conductores/';
                        $nombre_imagen = $file->getClientOriginalName();

                        $imagen_antigua = $conductor->foto;
                        $app_imagen_antigua = $conductor->foto_app;

                        if(file_exists($ubicacion.$nombre_imagen)){
                            $nombre_imagen = rand(1,100000).$nombre_imagen;
                        }

                        $conductor->foto = $nombre_imagen;
                        $conductor->foto_app = 'thumbnail'.$nombre_imagen;

                        Image::make($file->getRealPath())->resize(250, 316)->save($ubicacion.$nombre_imagen);

                        Image::make($file->getRealPath())
                        ->resize(250, 250)->save($ubicacion.'thumbnail'.$nombre_imagen);

                        File::delete($ubicacion.$imagen_antigua);
                        File::delete($ubicacion.$app_imagen_antigua);

                      }else{

                          $conductor->foto = 'FALSE';
                      }

                      if($conductor->save()){

                          return Response::json([
                              'mensaje'=>true,
                              'respuesta'=>'Registro guardado correctamente!',
                              'nombre_imagen' => $nombre_imagen
                          ]);

                      }
                  }
              }
          }
      }

      public function postActualizarconductor(){

          if (!Sentry::check())
          {
              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if(Request::ajax()){

                  $validaciones = [
                      'fecha_vinculacion'=>'required|date_format:Y-m-d',
                      'nombre'=>'required|letrasnumerosyespacios',
                      'cc'=>'required|numeric',
                      'celular'=>'numeric',
                      'telefono'=>'numeric',
                      'direccion'=>'required',
                      'tipolicencia'=>'required|select',
                      'fecha_licencia_expedicion'=>'required|date_format:Y-m-d',
                      'fecha_licencia_vigencia'=>'required|date_format:Y-m-d',
                      'edad'=>'required|numeric',
                      'genero'=>'required|select',
                      'grupo_trabajo'=>'required|select',
                      'tipo_contrato'=>'required|select',
                      'cargo'=>'required|select',
                      'experiencia'=>'required',
                      'accidentes'=>'required|select',
                      'incidentes'=>'required|select',
                      'estado'=>'required|select',
                      'vehiculo_propio_desplazamiento'=>'required|select',
                      'trayecto_casa_trabajo'=>'required|select',
                  ];

                  /*$mensajes = [

                  ];*/

                  $validador = Validator::make(Input::all(), $validaciones/*$mensajes/*/);

                  if ($validador->fails())
                  {
                      return Response::json([
                          'mensaje'=>false,
                          'errores'=>$validador->errors()->getMessages()
                      ]);

                  }else{

                      $conductor = Conductor::find(Input::get('id'));
                      $conductor->fecha_vinculacion = Input::get('fecha_vinculacion');
                      $conductor->departamento = Input::get('departamento');
                      $conductor->ciudad = Input::get('ciudad');
                      $conductor->nombre_completo = Input::get('nombre');
                      $conductor->cc = Input::get('cc');
                      $conductor->celular = Input::get('celular');
                      $conductor->telefono = Input::get('telefono');
                      $conductor->direccion = Input::get('direccion');
                      $conductor->tipodelicencia = Input::get('tipolicencia');
                      $conductor->fecha_licencia_expedicion = Input::get('fecha_licencia_expedicion');
                      $conductor->fecha_licencia_vigencia = Input::get('fecha_licencia_vigencia');
                      $conductor->edad = Input::get('edad');
                      $conductor->genero = Input::get('genero');
                      $conductor->grupo_trabajo = Input::get('grupo_trabajo');
                      $conductor->tipo_contrato = Input::get('tipo_contrato');
                      $conductor->cargo = Input::get('cargo');
                      $conductor->experiencia = Input::get('experiencia');
                      $conductor->accidentes = Input::get('accidentes');
                      $conductor->descripcion_accidente = Input::get('descripcion');
                      $conductor->incidentes = Input::get('incidentes');
                      $conductor->frecuencia_desplazamiento = Input::get('frecuencia');
                      $conductor->estado = Input::get('estado');
                      $conductor->vehiculo_propio_desplazamiento = Input::get('vehiculo_propio_desplazamiento');
                      $conductor->trayecto_casa_trabajo = Input::get('trayecto_casa_trabajo');

                      if($conductor->save()){
                          return Response::json([
                              'mensaje'=>true,
                              'respuesta'=>'Registro guardado correctamente!',
                          ]);
                      }
                  }
              }

          }
      }

      public function getVehiculos($id){

          if(Sentry::check()){
            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);

          }else{
            $id_rol = null;
            $permisos = null;
            $permisos = null;
          }

          if (isset($permisos->administrativo->proveedores->ver)){
              $ver = $permisos->administrativo->proveedores->ver;
          }else{
              $ver = null;
          }

          if (!Sentry::check()){

              return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

          }else if($ver!='on' ) {
              return View::make('admin.permisos');
          }else {

              $razonsocial = DB::table('proveedores')->where('id',$id)->get();
              foreach($razonsocial as $razon){
                  $nombre_razonsocial = $razon->razonsocial;
              }
              $vehiculos = DB::table('vehiculos')->where('proveedores_id',$id)->get();

              return View::make('proveedores.vehiculos')
              ->with([
                  'vehiculos'=> $vehiculos,
                  'id'=>$id,
                  'nombre_razonsocial'=>$nombre_razonsocial,
                  'count'=>1,
                  'permisos'=>$permisos
              ]);
          }
      }

      public function getListadovehiculos(){

          if (Sentry::check()) {
            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
          }else{
            $id_rol = null;
            $permisos = null;
            $permisos = null;
          }

          if (isset($permisos->administrativo->proveedores->listado_vehiculos)){
              $ver = $permisos->administrativo->proveedores->listado_vehiculos;
          }else{
              $ver = null;
          }

          if (!Sentry::check()){

              return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

          }else if($ver!='on') {
              return View::make('admin.permisos');
          }else {

              $vehiculos = Vehiculo::whereHas('proveedor', function($query){

                $query->whereNull('eventual')->whereNull('inactivo_total');

              })->noarchivado()->orderBy('placa')->get();

              $cont_vehiculos_sin_prog_mtn = 0;
        			$cont_vehiculo_sin_1rev = 0;

        			foreach($vehiculos as $vehiculo){
        				$consul_mtn_km = "SELECT mantenimiento_kilometraje.id, mantenimiento_kilometraje.kilometraje, mantenimiento_kilometraje.fecha, mantenimiento_kilometraje.hv_vehiculo_id, vehiculos.bloqueado FROM mantenimiento_kilometraje left join vehiculos on mantenimiento_kilometraje.vehiculo_id = vehiculos.id WHERE mantenimiento_kilometraje.vehiculo_id = '".$vehiculo->vehiculo_id."' and mantenimiento_kilometraje.anulado IS NULL and (vehiculos.bloqueado is null or vehiculos.bloqueado = 0) ORDER BY mantenimiento_kilometraje.kilometraje";
        				$resl_mtn_km = DB::select($consul_mtn_km);

        				if(count($resl_mtn_km)>0){
        					foreach($resl_mtn_km as $k => $mtn_km_veh){
        						if($k === 0){
        							$mtn_km_veh->kilometraje;
        							$mtn_km_veh->fecha;

        							$consul_rev = "SELECT * FROM mantenimiento_revision WHERE hv_vehiculo_id = '".$mtn_km_veh->hv_vehiculo_id."' AND mantenimiento_kilometraje_id = '".$mtn_km_veh->id."'";

                      $resl_mtn_rev = DB::select($consul_rev);

        							if(count($resl_mtn_rev)>0){

        							}else{
        								$cont_vehiculo_sin_1rev++;
        							}
        						}
        					}
        				}else{
        					$cont_vehiculos_sin_prog_mtn++;
        				}
        			}

              return View::make('proveedores.listado_vehiculos', [
                  'vehiculos'=>$vehiculos,
                  'permisos'=>$permisos,
                  'cont_vehiculo_sin_1rev'=>$cont_vehiculo_sin_1rev,
  				        'cont_vehiculos_sin_prog_mtn'=>$cont_vehiculos_sin_prog_mtn
              ]);

          }
      }

      public function postNuevovehiculo(){

          if (!Sentry::check()){

              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if(Request::ajax()){

                  if (Input::get('tipo_transporte')==='PRIVADO') {

                      $validaciones = [

                          'placa'=>'required|alpha_dash|unique:vehiculos',
                          'numero_interno'=>'required|numeric',
                          'numero_motor'=>'required|alpha_dash',
                          'clase'=>'required|select',
                          'marca'=>'required|letrasnumerosyespacios',
                          'capacidad'=>'required|numeric',
                          'modelo'=>'required',
                          'anos'=>'required|numeric',
                          'color'=>'required',
                          'propietario'=>'required|letrasnumerosyespacios',
                          'cc'=>'required|numeric',
                          'fecha_vigencia_soat'=>'required|date_format:Y-m-d|alpha_dash',
                          'fecha_vigencia_tecnomecanica'=>'date_format:Y-m-d|alpha_dash',
                          'mantenimiento_preventivo'=>'date_format:Y-m-d|alpha_dash',
                          'poliza_todo_riesgo'=>'required|date_format:Y-m-d|alpha_dash',
                          'foto' => 'mimes:jpeg,bmp,png',
                          'foto_a' => 'mimes:jpeg,bmp,png',
                          'foto_b' => 'mimes:jpeg,bmp,png'
                      ];

                      $mensajes = [
                          'numero_interno.required'=>'El campo numero interno es requerido',
                          'numero_interno.numeric'=>'El campo numero interno debe ser numerico',
                          'anos.required'=>'El campo a&ntilde;o es requerido',
                          /*'ano.numeric'=>'El campo a�o debe ser numerico',*/
                          'propietario.sololetrasyespacio'=>'Este campo debe tener solo letras y espacio'
                      ];

                      $validador = Validator::make(Input::all(), $validaciones, $mensajes);

                      if ($validador->fails())
                      {
                          return Response::json([
                              'mensaje'=>false,
                              'errores'=>$validador->errors()->getMessages()
                          ]);

                      }else{

                          $vehiculo = new Vehiculo();
                          $vehiculo->placa = Input::get('placa');
                          $vehiculo->numero_interno = Input::get('numero_interno');
                          $vehiculo->numero_motor = Input::get('numero_motor');
                          $vehiculo->clase = Input::get('clase');
                          $vehiculo->marca = Input::get('marca');
                          $vehiculo->modelo = Input::get('modelo');
                          $vehiculo->ano = Input::get('anos');
                          $vehiculo->capacidad = Input::get('capacidad');
                          $vehiculo->color = Input::get('color');
                          $vehiculo->cilindraje = Input::get('cilindraje');
                          $vehiculo->numero_vin = Input::get('n_vn');
                          $vehiculo->propietario = Input::get('propietario');
                          $vehiculo->cc = Input::get('cc');
                          $vehiculo->empresa_afiliada = null;
                          $vehiculo->tarjeta_operacion = null;
                          $vehiculo->fecha_vigencia_operacion = null;
                          $vehiculo->fecha_vigencia_soat = Input::get('fecha_vigencia_soat');
                          $vehiculo->fecha_vigencia_tecnomecanica = Input::get('fecha_vigencia_tecnomecanica');
                          $vehiculo->mantenimiento_preventivo = Input::get('mantenimiento_preventivo');
                          $vehiculo->poliza_todo_riesgo = Input::get('poliza_todo_riesgo');
                          $vehiculo->poliza_contractual = null;
                          $vehiculo->poliza_extracontractual = null;
                          $vehiculo->observacion = Input::get('observacion');
                          $vehiculo->proveedores_id = Input::get('proveedores_id');
                          $vehiculo->creado_por = Sentry::getUser()->id;

                          if($vehiculo->save()){

                              return Response::json([
                                  'mensaje'=>true,
                                  'respuesta'=>'Registro guardado correctamente!'
                              ]);

                          }
                      }

                  }elseif(Input::get('tipo_transporte')==='PUBLICO'){

                      $validaciones = [

                          'placa'=>'required|alpha_dash|unique:vehiculos',
                          'numero_interno'=>'required|numeric',
                          'numero_motor'=>'required|alpha_dash',
                          'clase'=>'required|select',
                          'marca'=>'required|alpha_dash',
                          'capacidad'=>'required|numeric',
                          'modelo'=>'required',
                          'anos'=>'required|numeric',
                          'color'=>'required',
                          'propietario'=>'required|letrasnumerosyespacios',
                          'cc'=>'required|numeric',
                          'empresa_afiliada'=>'sololetrasyespacio',
                          'tarjeta_operacion'=>'numeric',
                          'fecha_vigencia_operacion'=>'required|date_format:Y-m-d|alpha_dash',
                          'fecha_vigencia_soat'=>'required|date_format:Y-m-d|alpha_dash',
                          'fecha_vigencia_tecnomecanica'=>'date_format:Y-m-d|alpha_dash',
                          'mantenimiento_preventivo'=>'date_format:Y-m-d|alpha_dash',
                          'poliza_todo_riesgo'=>'required|date_format:Y-m-d|alpha_dash',
                          'poliza_contractual' => 'required|date_format:Y-m-d|alpha_dash',
                          'poliza_extracontractual' => 'required|date_format:Y-m-d|alpha_dash',
                          'foto' => 'mimes:jpeg,bmp,png',
                          'foto_a' => 'mimes:jpeg,bmp,png',
                          'foto_b' => 'mimes:jpeg,bmp,png'
                      ];

                      $mensajes = [
                          'numero_interno.required'=>'El campo numero interno es requerido',
                          'numero_interno.numeric'=>'El campo numero interno debe ser numerico',
                          'anos.required'=>'El campo a&ntilde;o es requerido',
                          /*'ano.numeric'=>'El campo a�o debe ser numerico',*/
                          'propietario.sololetrasyespacio'=>'Este campo debe tener solo letras y espacio'
                      ];

                      $validador = Validator::make(Input::all(), $validaciones, $mensajes);

                      if ($validador->fails()){
                          return Response::json([
                              'mensaje'=>false,
                              'errores'=>$validador->errors()->getMessages()
                          ]);

                      }else{

                          $vehiculo = new Vehiculo();
                          $vehiculo->placa = Input::get('placa');
                          $vehiculo->numero_interno = Input::get('numero_interno');
                          $vehiculo->numero_motor = Input::get('numero_motor');
                          $vehiculo->clase = Input::get('clase');
                          $vehiculo->marca = Input::get('marca');
                          $vehiculo->modelo = Input::get('modelo');
                          $vehiculo->ano = Input::get('anos');
                          $vehiculo->capacidad = Input::get('capacidad');
                          $vehiculo->color = Input::get('color');

                          $vehiculo->cilindraje = Input::get('cilindraje');
                          $vehiculo->numero_vin = Input::get('n_vn');

                          $vehiculo->propietario = Input::get('propietario');
                          $vehiculo->cc = Input::get('cc');
                          $vehiculo->empresa_afiliada = Input::get('empresa_afiliada');
                          $vehiculo->tarjeta_operacion = Input::get('tarjeta_operacion');
                          $vehiculo->fecha_vigencia_operacion = Input::get('fecha_vigencia_operacion');
                          $vehiculo->fecha_vigencia_soat = Input::get('fecha_vigencia_soat');
                          $vehiculo->fecha_vigencia_tecnomecanica = Input::get('fecha_vigencia_tecnomecanica');
                          $vehiculo->mantenimiento_preventivo = Input::get('mantenimiento_preventivo');
                          $vehiculo->poliza_todo_riesgo = Input::get('poliza_todo_riesgo');
                          $vehiculo->poliza_contractual = Input::get('poliza_contractual');
                          $vehiculo->poliza_extracontractual = Input::get('poliza_extracontractual');
                          $vehiculo->observacion = Input::get('observacion');
                          $vehiculo->proveedores_id = Input::get('proveedores_id');

                          if($vehiculo->save()){

                              return Response::json([
                                  'mensaje'=>true,
                                  'respuesta'=>'Registro guardado correctamente!'
                              ]);
                          }
                      }
                  }
              }
          }
      }

      public function postMostrarvehiculo(){

          if (!Sentry::check())
          {
              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if(Request::ajax()){
                  $vehiculo_id = Input::get('vehiculo_id');
                  $proveedor_id = Input::get('proveedor_id');
                  $vehiculo =  DB::table('vehiculos')->where('id',$vehiculo_id)->where('proveedores_id', $proveedor_id)->get();
                  if ($vehiculo){
                      return Response::json([
                          'mensaje'=>true,
                          'respuesta'=>$vehiculo
                      ]);
                  }
              }
          }
      }

      public function postActualizarvehiculo(){

          if (!Sentry::check())
          {
              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if(Request::ajax()){

                  $validaciones = [
                      'placa'=>'required|alpha_dash',
                      'numero_interno'=>'required|numeric',
                      'numero_motor'=>'required|alpha_dash',
                      'clase'=>'required|select',
                      'marca'=>'required|letrasnumerosyespacios',
                      'capacidad'=>'required|numeric',
                      'modelo'=>'required',
                      'anos'=>'required|numeric',
                      'color'=>'required|sololetrasyespacio',
                      'propietario'=>'required|letrasnumerosyespacios',
                      'cc'=>'required|numeric',
                      'empresa_afiliada'=>'required',
                      'tarjeta_operacion'=>'numeric',
                      'fecha_vigencia_operacion'=>'date_format:Y-m-d|alpha_dash',
                      'fecha_vigencia_soat'=>'required|date_format:Y-m-d|alpha_dash',
                      'fecha_vigencia_tecnomecanica'=>'required|date_format:Y-m-d|alpha_dash',
                      'mantenimiento_preventivo'=>'required|date_format:Y-m-d|alpha_dash',
                      'poliza_todo_riesgo'=>'required|date_format:Y-m-d|alpha_dash',
                      'poliza_contractual' => 'required|date_format:Y-m-d|alpha_dash',
                      'poliza_extracontractual' => 'required|date_format:Y-m-d|alpha_dash',
                  ];
                  $mensajes = [
                      'numero_interno.required'=>'El campo numero interno es requerido',
                      'numero_interno.numeric'=>'El campo numero interno debe ser numerico',
                      'anos.required'=>'El campo a&ntilde;o es requerido'
                  ];
                  $validador = Validator::make(Input::all(), $validaciones, $mensajes);

                  if ($validador->fails())
                  {
                      return Response::json([
                          'mensaje'=>false,
                          'errores'=>$validador->errors()->getMessages()
                      ]);

                  }else{

                      $vehiculo = Vehiculo::find(Input::get('id'));
                      $vehiculo->numero_interno = Input::get('numero_interno');
                      $vehiculo->placa = Input::get('placa');
                      $vehiculo->numero_motor = Input::get('numero_motor');
                      $vehiculo->clase = Input::get('clase');
                      $vehiculo->marca = Input::get('marca');
                      $vehiculo->modelo = Input::get('modelo');
                      $vehiculo->ano = Input::get('anos');
                      $vehiculo->capacidad = Input::get('capacidad');
                      $vehiculo->color = Input::get('color');

                      $vehiculo->cilindraje = Input::get('cilindraje');
                      $vehiculo->numero_vin = Input::get('n_vn');

                      $vehiculo->propietario = Input::get('propietario');
                      $vehiculo->cc = Input::get('cc');
                      $vehiculo->empresa_afiliada = Input::get('empresa_afiliada');
                      $vehiculo->tarjeta_operacion = Input::get('tarjeta_operacion');
                      $vehiculo->fecha_vigencia_operacion = Input::get('fecha_vigencia_operacion');
                      $vehiculo->fecha_vigencia_soat = Input::get('fecha_vigencia_soat');
                      $vehiculo->fecha_vigencia_tecnomecanica = Input::get('fecha_vigencia_tecnomecanica');
                      $vehiculo->mantenimiento_preventivo = Input::get('mantenimiento_preventivo');
                      $vehiculo->poliza_todo_riesgo = Input::get('poliza_todo_riesgo');
                      $vehiculo->poliza_contractual = Input::get('poliza_contractual');
                      $vehiculo->poliza_extracontractual = Input::get('poliza_extracontractual');
                      $vehiculo->observacion = Input::get('observacion');

                      if($vehiculo->save()){
                          return Response::json([
                              'respuesta'=>true
                          ]);
                      }
                  }
              }
          }
      }

      /*
      public function postBloquearvehiculos(){

          if (!Sentry::check())
          {
              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if (Request::ajax()) {

                  $bloqueo = intval(Input::get('bloqueo'));
                  $id_vehiculo = Input::get('id');

                  $vehiculo = Vehiculo::find($id_vehiculo);

                  ##SI BLOQUEO ES = 1 ENTONCES ESTA BLOQUEADO, POR LO TANTO APLICAR 0 PARA DESBLOQUEAR
                  if ($bloqueo===1){
                      $vehiculo->bloqueado = 0;
                  }else if($bloqueo===0){
                      $vehiculo->bloqueado = 1;
                  }

                  if ($vehiculo->save()){
                      return Response::json([
                          'respuesta'=>true,
                          'bloqueo'=>$vehiculo->bloqueado
                      ]);
                  }

              }
          }
      }*/

      public function postBloquearconductores(){

          if (!Sentry::check())
          {
              return Response::json([
                  'respuesta'=>'relogin'
              ]);

          }else {

              if (Request::ajax()) {

                  $bloqueo = intval(Input::get('bloqueo'));
                  $id_conductor = Input::get('id');

                  $conductor = Conductor::find($id_conductor);

                  ##SI BLOQUEO ES = 1 ENTONCES ESTA BLOQUEADO, POR LO TANTO APLICAR 0 PARA DESBLOQUEAR
                  if ($bloqueo===1){
                      $conductor->bloqueado = 0;
                  }else if($bloqueo===0){
                      $conductor->bloqueado = 1;
                  }

                  if ($conductor->save()){
                      return Response::json([
                          'respuesta'=>true,
                          'bloqueo'=>$conductor->bloqueado
                      ]);
                  }

              }
          }
      }

      public function postSubirimagenes(){
          if (!Sentry::check())
          {
              return Response::json([
                  'respuesta'=>'relogin'
              ]);
          }else {
              if (Request::ajax()) {
                  $imagenes = DB::table('img_vehiculos')->where('vehiculos_id',Input::get('id'))->count();
                  if($imagenes<4){
                      $validaciones = [
                          'foto' => 'mimes:jpeg,bmp,png'
                      ];
                      $validador = Validator::make(Input::all(), $validaciones);

                      if ($validador->fails()) {
                          return Response::json([
                              'mensaje' => false,
                              'errores' => $validador->errors()->getMessages()
                          ]);

                      }else{

                          if (Input::hasFile('file')) {
                              $file = Input::file('file');
                              $ubicacion = 'biblioteca_imagenes/proveedores/vehiculos/';
                              $nombre_imagen = $file->getClientOriginalName();
                              //$tamaño = $file->getSize();

                              if (file_exists($ubicacion . $nombre_imagen)) {
                                  $nombre_imagen = rand(1, 100) . $nombre_imagen;
                              }

                              $img_vehiculo = new Imgvehiculo;
                              $img_vehiculo->foto = $nombre_imagen;
                              $img_vehiculo->vehiculos_id = Input::get('id');
                          }

                          if ($img_vehiculo->save()) {
                              if (Input::hasFile('file')) {
                                  $width = Image::make($file->getRealPath())->width();
                                  $height = Image::make($file->getRealPath())->height();
                                  Image::make($file->getRealPath())->resize($width/2, $height/2)->save($ubicacion . $nombre_imagen);
                              }

                              return Response::json([
                                  'mensaje' => true,
                                  'respuesta' => 'Registro guardado correctamente!'
                              ]);
                          }
                      }

                  }elseif($imagenes>=4){
                      return Response::json([
                          'mensaje' => false,
                          'respuesta' => 'Las imagenes estan completas!'
                      ]);
                  }
              }
          }
      }

      public function postBloqueouso(){

        if (!Sentry::check())
        {
            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

              $id = Input::get('id');

              $proveedores = Proveedor::find($id);
              $proveedores->inactivo = 1;

              if ($proveedores->save()) {
                $array = [
                  'respuesta'=>true
                ];
                return Response::json($array);
              }

            }
        }
      }

      public function postDesbloqueouso(){

        if (!Sentry::check())
        {
            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

              $id = Input::get('id');

              $proveedores = Proveedor::find($id);
              $proveedores->inactivo = null;

              if ($proveedores->save()) {
                $array = [
                  'respuesta'=>true
                ];
                return Response::json($array);
              }

            }
        }
      }

      public function postBloqueogeneral(){

        if (!Sentry::check())
        {
            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

              $id = Input::get('id');

              $proveedores = Proveedor::find($id);
              $proveedores->inactivo_total = 1;

              if ($proveedores->save()) {
                $array = [
                  'respuesta'=>true
                ];
                return Response::json($array);
              }

            }
        }
      }

      public function postDesbloqueogeneral(){

        if (!Sentry::check())
        {
            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

              $id = Input::get('id');

              $proveedores = Proveedor::find($id);
              $proveedores->inactivo_total = null;

              if ($proveedores->save()) {
                $array = [
                  'respuesta'=>true
                ];
                return Response::json($array);
              }

            }
        }
      }

      public function postArchivarvehiculo(){

        $vehiculo = Vehiculo::find(Input::get('vehiculo_id'));

        if (Input::get('archivar')==0) {
          $vehiculo->archivado = 1;
        }else if(Input::get('archivar')==1){
          $vehiculo->archivado = null;
        }

        if ($vehiculo->save()) {

          return Response::json([
            'response' => true,
            'vehiculo' => $vehiculo->archivado,
            'input' => Input::all()
          ]);

        }

      }

      public function postArchivarconductor(){

        $conductor = Conductor::find(Input::get('conductor_id'));

        if (Input::get('archivar')==0) {
          $conductor->archivado = 1;
        }else if(Input::get('archivar')==1){
          $conductor->archivado = null;
        }

        if ($conductor->save()) {

          return Response::json([
            'response' => true,
            'conductor' => $conductor->archivado,
            'input' => Input::all()
          ]);

        }

      }

      ##-------------ADMINISTRACION----------##
      public function getAdministracion(){

          if (Sentry::check()) {
            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
          }else{
            $id_rol = null;
            $permisos = null;
            $permisos = null;
          }

          if (isset($permisos->administrativo->administracion_proveedores->ver)){
              $ver = $permisos->administrativo->administracion_proveedores->ver;
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
            ->orderBy('razonsocial')
            ->get();
            $array = [
              'proveedores'=>$proveedores,
              'permisos'=>$permisos
            ];
            return View::make('proveedores.administracion',$array);
        }
      }

      public function postBuscaradministracion(){

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

              if (intval(Input::get('proveedor_id'))===0) {

                $vehiculos = DB::table('proveedores')
                ->select('proveedores.id','proveedores.razonsocial','vehiculos.placa','vehiculos.marca','vehiculos.modelo','vehiculos.ano','vehiculos.id as vehiculo_id')
                ->leftJoin('vehiculos','proveedores.id','=','vehiculos.proveedores_id')
                ->orderBy('razonsocial')
                ->get();

                if ($vehiculos!=null) {
                  $array = [
                    'respuesta'=>true,
                    'vehiculos'=>$vehiculos,
                    'permisos'=>$permisos
                  ];
                }else{
                  $array = [
                    'respuesta'=>false,
                    'permisos'=>$permisos,
                    '1'=>'1'
                  ];
                }

              }else if(intval(Input::get('proveedor_id'))!=0){

                $vehiculos = DB::table('proveedores')
                ->select('proveedores.id','proveedores.razonsocial','vehiculos.placa','vehiculos.marca','vehiculos.modelo','vehiculos.ano','vehiculos.id as vehiculo_id')
                ->leftJoin('vehiculos','proveedores.id','=','vehiculos.proveedores_id')
                ->where('vehiculos.proveedores_id',Input::get('proveedor_id'))
                ->orderBy('vehiculos.marca')
                ->get();

                if ($vehiculos!=null) {
                  $array = [
                    'respuesta'=>true,
                    'vehiculos'=>$vehiculos,
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

      public function postAdministraciones(){

        if (!Sentry::check())
        {
            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

              $vehiculo = DB::table('administracion_vehiculos')
              ->where('ano',date('Y'))
              ->where('vehiculo_id',Input::get('vehiculo_id'))->get();

              if ($vehiculo!=null) {
                return Response::json([
                  'respuesta'=>true,
                  'vehiculo'=>$vehiculo
                ]);
              }else{
                return Response::json([
                  'respuesta'=>false
                ]);
              }
            }
        }
      }

      public function postRegistrarpagoadministracion(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

                $ano = Input::get('ano');
                $mes = Input::get('mes');
                $vehiculo_id = Input::get('vehiculo_id');

                $buscar_registro = DB::table('administracion_vehiculos')
                ->where('ano',$ano)
                ->where('mes',$mes)
                ->where('vehiculo_id',$vehiculo_id)
                ->first();

                if ($buscar_registro!=null) {

                  $actualizar = DB::table('administracion_vehiculos')
                  ->where('ano',$ano)
                  ->where('mes',$mes)
                  ->where('vehiculo_id',$vehiculo_id)
                  ->update([
                    'numero_ingreso' => Input::get('numero_ingreso')
                  ]);

                  if (intval($actualizar)!=0) {
                    return Response::json([
                      'respuesta'=>true
                    ]);
                  }else{
                    return Response::json([
                      'respuesta'=>false
                    ]);
                  }

                }else{

                  $administracion = new Administracion;
                  $administracion->ano = Input::get('ano');
                  $administracion->mes = Input::get('mes');
                  $administracion->pago = 1;
                  $administracion->numero_ingreso = Input::get('numero_ingreso');
                  $administracion->creado_por = Sentry::getUser()->id;
                  $administracion->vehiculo_id = Input::get('vehiculo_id');

                  if ($administracion->save()) {
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

      //pago administracion masivo bogotá
      public function postRegistrarpagoadministracionmasivo(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

                $ano = Input::get('ano');
                $mes = Input::get('mes');
                $sw = 0;

                

                $conductores = DB::table('vehiculos')
                ->leftJoin('proveedores', 'proveedores.id' , '=' , 'vehiculos.proveedores_id')
                ->select('vehiculos.*', 'proveedores.razonsocial')
                ->where('proveedores.localidad','bogota')
                //->where('conductores.estado','activo')
                ->orderBy('vehiculos.id')->get();

                //
                $cantidad = count($conductores);

                foreach($conductores as $conductor){
                    $vehiculo = $conductor->id;
                    $sw++;
                    $buscar_registro = DB::table('administracion_vehiculos')
                    ->where('ano',$ano)
                    ->where('mes',$mes)
                    ->where('vehiculo_id',$vehiculo)
                    ->first();
                    if ($buscar_registro!=null) {

                      $actualizar = DB::table('administracion_vehiculos')
                      ->where('ano',$ano)
                      ->where('mes',$mes)
                      ->where('vehiculo_id',$vehiculo)
                      ->update([
                        'numero_ingreso' => Input::get('numero_ingreso')
                      ]);                      
                    }else{

                      $administracion = new Administracion;
                      $administracion->ano = Input::get('ano');
                      $administracion->mes = Input::get('mes');
                      $administracion->pago = 1;
                      $administracion->numero_ingreso = Input::get('numero_ingreso');
                      $administracion->creado_por = Sentry::getUser()->id;
                      $administracion->vehiculo_id = $vehiculo;
                      $administracion->save();
                    }                  
                }
                if ($sw==$cantidad) {
                  return Response::json([
                    'respuesta'=>true,
                    'sw'=>$sw,
                    'cantidad'=>$cantidad
                  ]);
                }else{
                  return Response::json([
                    'respuesta'=>false
                  ]);
                }
            }
        }
      }
      //fin pago administracion masivo bogotá

      public function postBuscarmesadministracion(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

              $administracion = DB::table('administracion_vehiculos')
              ->where('vehiculo_id',Input::get('id'))
              ->where('mes',Input::get('mes'))
              ->where('ano',Input::get('ano'))
              ->first();

              if ($administracion!=null) {
                return Response::json([
                  'respuesta'=>true,
                  'administracion'=>$administracion
                ]);
              }else{
                return Response::json([
                  'respuesta'=>false
                ]);
              }
            }
        }
      }
      ##------------FIN ADMINISTRACION--------##

      ##------------SEGURIDAD SOCIAL---------------##
      public function getSeguridadsocial(){

          if (Sentry::check()) {
            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
          }else{
            $id_rol = null;
            $permisos = null;
            $permisos = null;
          }

          if (isset($permisos->administrativo->seguridad_social->ver)){
              $ver = $permisos->administrativo->seguridad_social->ver;
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
          ->orderBy('razonsocial')
          ->get();

          $array = [
              'proveedores'=>$proveedores,
              'permisos'=>$permisos
          ];

          return View::make('proveedores.seguridadsocial',$array);
        }
      }

      public function postBuscarconductores(){

        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

              if (intval(Input::get('proveedor_id'))===0) {

                $conductores = DB::table('proveedores')
                ->select('conductores.nombre_completo','proveedores.razonsocial','conductores.id as id_conductor')
                ->leftJoin('conductores','proveedores.id','=','conductores.proveedores_id')
                ->orderBy('nombre_completo')
                ->get();

                if ($conductores!=null) {
                  return Response::json([
                    'respuesta'=>true,
                    'conductores'=>$conductores,
                    'permisos'=>$permisos
                  ]);
                }else{
                  return Response::json([
                    'respuesta'=>false
                  ]);
                }

              }else if(intval(Input::get('proveedor_id'))!=0){

                $conductores = DB::table('proveedores')
                ->select('conductores.nombre_completo','proveedores.razonsocial','conductores.id as id_conductor')
                ->leftJoin('conductores','proveedores.id','=','conductores.proveedores_id')
                ->where('conductores.proveedores_id',Input::get('proveedor_id'))
                ->get();

                if ($conductores!=null) {
                  return Response::json([
                    'respuesta'=>true,
                    'conductores'=>$conductores,
                    'permisos'=>$permisos
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

      public function postSeguridadsocials(){

        if (!Sentry::check())
        {
            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

              $seguridad_social = Seguridadsocial::where('ano',date('Y'))
              ->where('conductor_id', Input::get('conductor_id'))
              ->get();

              if (count($seguridad_social)) {

                return Response::json([
                  'respuesta' => true,
                  'seguridad_social' => $seguridad_social
                ]);

              }else{

                return Response::json([
                  'respuesta' => false
                ]);

              }
            }
        }
      }

      public function postBuscarmesseguridad(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

              $seguridadsocial = DB::table('seguridad_social')
              ->where('conductor_id',Input::get('id'))
              ->where('mes',Input::get('mes'))
              ->where('ano',Input::get('ano'))
              ->first();

              if ($seguridadsocial!=null) {
                return Response::json([
                  'respuesta'=>true,
                  'seguridadsocial'=>$seguridadsocial
                ]);
              }else{
                return Response::json([
                  'respuesta'=>false
                ]);
              }
            }
        }
      }

      public function postRegistrarpagoseguridadsocial(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

              $numero_repetido = DB::table('seguridad_social')->where('numero_ingreso',Input::get('numero_ingreso'))->get();

              if ($numero_repetido!=null) {

                return Response::json([
                  'respuesta'=>'repetido'
                ]);

              }else{

                $seguridad_social = new Seguridadsocial;
                $seguridad_social->ano = Input::get('ano');
                $seguridad_social->mes = Input::get('mes');
                $seguridad_social->pago = 1;
                $seguridad_social->numero_ingreso = Input::get('numero_ingreso');
                $seguridad_social->creado_por = Sentry::getUser()->id;
                $seguridad_social->conductor_id = Input::get('conductor_id');

                if ($seguridad_social->save()) {
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
      ##------------FIN SEGURIDAD SOCIAL-----------##

      ##------------------CONTRATOS----------------##
      public function getContratos(){

          if (Sentry::check()) {
            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
          }else{
            $id_rol = null;
            $permisos = null;
            $permisos = null;
          }

          if (isset($permisos->administrativo->contratos->ver)){
              $ver = $permisos->administrativo->contratos->ver;
          }else{
              $ver = null;
          }

          if (!Sentry::check()){

              return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

          }else if($ver!='on' ) {
              return View::make('admin.permisos');
          }else {
              $contratos = DB::table('contratos')->get();
              $array = [
                'contratos'=>$contratos,
                'permisos'=>$permisos
              ];
              return View::make('proveedores.contratos',$array);
          }

      }

      public function postMostrarcontrato(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

              $contrato = Contrato::find(Input::get('id'));

              return Response::json([
                'respuesta'=>true,
                'contrato'=>$contrato
              ]);
            }

        }
      }

      public function postVercontratos(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

              $contrat = false;
              $contrato = DB::table('contratos')->where('id',Input::get('id'))->first();

              $fecha_actual = new DateTime("now");
              $fecha_inicio = new DateTime($contrato->fecha_inicio);
              $fecha_vencimiento = new DateTime($contrato->fecha_vencimiento);

              if ($fecha_actual->format('Y-m-d')>=$fecha_inicio->format('Y-m-d') and
                  $fecha_actual->format('Y-m-d')<=$fecha_vencimiento->format('Y-m-d')) {
                $contrat = true;
              }

              return Response::json([
                'respuesta'=>true,
                'contrato'=>$contrato,
                'contrat'=>$contrat
              ]);
            }

        }
      }

      public function postNuevocontrato(){

        if (!Sentry::check()){

            return Response::json([
              'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

              $cliente = intval(Input::get('cliente'));

              if ($cliente===1) {
                $validaciones = [
                    'fecha_inicial'=>'required|date_format:Y-m-d',
                    'fecha_final'=>'required|date_format:Y-m-d',
                    'contratante'=>'required',
                    'nit'=>'required'
                ];
              }else if($cliente===2){
                $validaciones = [
                    'fecha_inicial'=>'required|date_format:Y-m-d',
                    'fecha_final'=>'required|date_format:Y-m-d',
                    'contratante'=>'required',
                    'nit'=>'required',
                    'representante_legal'=>'required',
                    'cc_representante'=>'required',
                    'telefono_representante'=>'required',
                    'direccion_representante'=>'required'
                ];
              }

              $mensajes = [
                'fecha_inicial.required'=>'La fecha inicial es requerida',
                'contratante.required'=>'El contratante es requerido',
                'fecha_inicial.date'=>'La fecha inicial no tiene un formato valido',
                'fecha_inicial.required'=>'La fecha final es requerida',
                'fecha_final.date'=>'La fecha final no tiene un formato valido',
                'nit.required'=>'El nit o documento de identidad es requerido',
                'representante_legal.required'=>'El nombre del representante legal es requerido',
                'representante_legal.sololetrasyespacio'=>'El nombre del representante solo puede contener letras y espacios',
                'cc_representante.required'=>'El documento de identidad del representante legal es requerido',
                'telefono_representante.required'=>'El telefono del representante es requerido',
                'direccion_representante.required'=>'La direccion del representante legal es requerida',
              ];

              $validador = Validator::make(Input::all(), $validaciones,$mensajes);

              if ($validador->fails()){

                  return Response::json([
                      'mensaje'=>false,
                      'errores'=>$validador->errors()->getMessages()
                  ]);

              }else{

                $contrato = new Contrato;
                $contrato->fecha_inicio = Input::get('fecha_inicial');
                $contrato->fecha_vencimiento = Input::get('fecha_final');
                $contrato->contratante = Input::get('contratante');
                $contrato->nit_contratante = Input::get('nit');
                $contrato->representante_legal = Input::get('representante_legal');
                $contrato->cc_representante = Input::get('cc_representante');
                $contrato->telefono_representante = Input::get('telefono_representante');
                $contrato->direccion_representante = Input::get('direccion_representante');
                $contrato->cliente = Input::get('cliente');
                $contrato->creado_por = Sentry::getUser()->id;

                if ($contrato->save()) {

                  $id = $contrato->id;
                  $c = Contrato::find($id);

                  //ASIGNAR CONSECUTIVO
                  if(strlen($id)===1){
                      $c->numero_contrato = '000'.$id;
                  }elseif(strlen($id)===2){
                      $c->numero_contrato = '00'.$id;
                  }elseif(strlen($id)===3){
                      $c->numero_contrato = '0'.$id;
                  }elseif(strlen($id)===4){
                      $c->numero_contrato = $id;
                  }

                  if ($c->save()) {
                    $array = [
                      'respuesta'=>true
                    ];
                    return Response::json($array);
                  }

                }

              }

            }
        }

      }

      public function postCargarcontratos(){

        if (!Sentry::check()){

            return Response::json([
              'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

              $id = Input::get('id');

              $contratos = DB::table('contratos')->where('id',$id)->first();

              if ($contratos!=null) {
                return Response::json([
                  'respuesta'=>true,
                  'contratos'=>$contratos
                ]);
              }
            }
        }
      }

      public function postActualizarinfocontrato(){

        if (!Sentry::check()){

            return Response::json([
              'respuesta'=>'relogin'
            ]);

        }else {

          if(Request::ajax()){

            $cliente = intval(Input::get('cliente'));

            if ($cliente===1) {
              $validaciones = [
                  'fecha_inicial'=>'required|date_format:Y-m-d',
                  'fecha_final'=>'required|date_format:Y-m-d',
                  'contratante'=>'required',
                  'nit'=>'required'
              ];
            }else{
              $validaciones = [
                  'fecha_inicial'=>'required|date_format:Y-m-d',
                  'fecha_final'=>'required|date_format:Y-m-d',
                  'contratante'=>'required',
                  'nit'=>'required',
                  'representante_legal'=>'required|sololetrasyespacio',
                  'cc_representante'=>'required',
                  'telefono_representante'=>'required',
                  'direccion_representante'=>'required'
              ];
            }

            $mensajes = [
              'contratante.required'=>'El contratante es requerido',
              'fecha_inicial.required'=>'La fecha inicial es requerida',
              'fecha_inicial.date'=>'La fecha inicial no tiene un formato valido',
              'fecha_inicial.required'=>'La fecha final es requerida',
              'fecha_final.date'=>'La fecha final no tiene un formato valido',
              'nit.required'=>'El nit o documento de identidad es requerido',
              'representante_legal.required'=>'El nombre del representante legal es requerido',
              'representante_legal.sololetrasyespacio'=>'El nombre del representante solo puede contener letras y espacios',
              'cc.representante.required'=>'El documento de identidad del representante legal es requerido',
              'telefono_representante.required'=>'El telefono del representante es requerido',
              'direccion_representante.required'=>'La direccion del representante legal es requerida',
              'cliente.numeric'=>'El campo cliente no es valido'
            ];

            $validador = Validator::make(Input::all(), $validaciones,$mensajes);

            if ($validador->fails()){

                return Response::json([
                    'mensaje'=>false,
                    'errores'=>$validador->errors()->getMessages()
                ]);

            }else{

              $contrato = Contrato::find(Input::get('id'));
              $contrato->fecha_inicio = Input::get('fecha_inicial');
              $contrato->fecha_vencimiento = Input::get('fecha_final');
              $contrato->contratante = Input::get('contratante');
              $contrato->nit_contratante = Input::get('nit');
              $contrato->representante_legal = Input::get('representante_legal');
              $contrato->cc_representante = Input::get('cc_representante');
              $contrato->telefono_representante = Input::get('telefono_representante');
              $contrato->direccion_representante = Input::get('direccion_representante');
              $contrato->cliente = Input::get('cliente');
              $contrato->creado_por = Sentry::getUser()->id;

              if ($contrato->save()) {
                return Response::json([
                  'respuesta'=>true
                ]);
              }

            }

          }
        }

      }

      public function postRenovarcontrato(){

        if (!Sentry::check()){

            return Response::json([
              'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

              $contrato = Contrato::find(Input::get('id'));
              $arrayHistorial = $contrato->historial;

              if ($arrayHistorial===null) {
                $arrayRenovacion = '{'.
                                     '"fecha_inicio":"'.$contrato->fecha_inicio.'",'.
                                     '"fecha_vencimiento":"'.$contrato->fecha_vencimiento.'",'.
                                     '"creado_por": "'.$contrato->creado_por.'",'.
                                     '"updated_at": "'.$contrato->updated_at.'"'.
                                   '}';
                $arraynuevo = $arrayRenovacion;
              }else{
                $arrayRenovacion = '{'.
                                     '"fecha_inicio":"'.$contrato->fecha_inicio.'",'.
                                     '"fecha_vencimiento":"'.$contrato->fecha_vencimiento.'",'.
                                     '"creado_por": "'.$contrato->creado_por.'",'.
                                     '"updated_at": "'.$contrato->updated_at.'"'.
                                   '}';
                $arrayHistorial = $arrayHistorial.';'.$arrayRenovacion;
                $arraynuevo = $arrayHistorial;
              }

              //CREAR ARRAY DE DATOS ACTUALES
              $contrato->fecha_inicio = Input::get('fecha_inicial');
              $contrato->fecha_vencimiento = Input::get('fecha_vencimiento');
              $contrato->historial = $arraynuevo;

              if ($contrato->save()) {

                $array = [
                  'respuesta'=>true
                ];
                return Response::json($array);
              }

            }

        }

      }
      ##------------------FIN CONTRATOS------------------##

      public function postSavexamenes(){

        if (!Sentry::check()){

          return Response::json([
                'respuesta'=>'relogin'
          ]);

        }else{

          if(Request::ajax()){

              $newexamenes = new Conductoresexamenes;
              $newexamenes->fecha_examen = Input::get('fecha_examen');
              $newexamenes->novedad_examen = Input::get('novedad_examenes');
              $newexamenes->conductor_id = Input::get('idcondt');
              $newexamenes->creado_por = Sentry::getUser()->id;

              if($newexamenes->save()){

                  $id_con= Input::get('idcondt');

                  $cond_examenes = DB::table('conductor_examenes')
                  ->where('conductor_id',$id_con)
                  ->orderBy('fecha_examen', 'desc')
                  ->whereNull('anulado')->get();

                  return Response::json([
                      'mensaje'=>true,
                      'respuesta'=>'Registro guardado correctamente!',
                      'cond_examenes'=>$cond_examenes
                  ]);
              }
          }
        }
      }

      public function postConsultarhisto(){
        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
            if(Request::ajax()){
              $id_con1 = Input::get('id_conduc');
              $cond_examenes2 = DB::table('conductor_examenes')->where('conductor_id',$id_con1)->get();

              if($cond_examenes2){
                return Response::json([
                    'mensaje'=>true,
                    'hist_examenes'=>$cond_examenes2

                ]);
              }

            }
        }
      }

	    ##------------------APP MOVIL----------------------##

    //revisar si tiene usuario para app movil
    public function postRevisarsitieneusuario(){

      //id conductor
      $id = Input::get('id');
      //buscar conductor para revisar id usuario

      $conductor = Conductor::find($id);

      if ($conductor->usuario_id!=null) {
          $usuario = User::find($conductor->usuario_id);
          if ($usuario) {
            return Response::json([
              'respuesta' =>true,
              'conductor'=>$conductor->usuario_id,
              'usuario'=>$usuario
            ]);
          }
      }else{
        return Response::json([
          'respuesta' =>false,
          'conductor'=>$conductor
        ]);
      }

    }

    public function postCrearusuarioapp(){

      if (Request::ajax()) {

        //id conductor
        $id = Input::get('id');

        //Buscar datos guardados del conductor
        $conductor = Conductor::find($id);

        //Nuevo usuario
        $user = new User();

        //El documento de identidad va a ser el password
        $user->password = $password = Hash::make($conductor->cc);
        $user->activated = 1;
        $user->username = null;
        $user->email = null;

        //agregar campo y nombre completo al usuario
        $nombre_comp = $conductor->nombre_completo;
        $nombre_comp = explode(' ',$nombre_comp);
    		$cant_nombre = count($nombre_comp);

        //Dividir nombre completo entre nombres y apellidos
    		if($cant_nombre===3){
    			$user->first_name = $nombre_comp[0];
    			$user->last_name = $nombre_comp[1].' '.$nombre_comp[2];
    		}else if($cant_nombre>=4){
    			$user->first_name = $nombre_comp[0].' '.$nombre_comp[1];
    			$user->last_name = $nombre_comp[2].' '.$nombre_comp[3];
    		}else{
    			$user->first_name = $nombre_comp[0];
    			$user->last_name = $nombre_comp[1];
    		}

	      $user->nombre_completo = $conductor->nombre_completo;
        $user->identificacion = $conductor->cc;
        $user->telefono = $conductor->celular;
        //especificar si es un usuario de la aplicacion
        $user->usuario_app = 1;
        //especificar si es un conductor o un cliente
        $user->tipo_usuario = 2;

        if($user->save()):

            //enlazar el conductor con el id de usuario
            $conductor_update = Conductor::find($conductor->id);
            $conductor_update->usuario_id = $user->id;

            if ($conductor_update->save()) {

              return Response::json([
                'respuesta' => true
              ]);

            }

        endif;

      }

    }

    public function postActualizardatosapp(){

      $id = Input::get('id');
      $user = User::find($id);
      $user->nombre_completo = Input::get('nombre_completo');
      $user->email = Input::get('email');
      $user->password = Hash::make(Input::get('contrasena'));

      DB::table('conductores')->where('cc', $user->identificacion)
      ->update(['email' => Input::get('email')]);

      if ($user->save()) {
        return Response::json([
          'respuesta' => true
        ]);
      }

    }

    public function postVerproveedores(){

        $tipo_afiliado = Input::get('tipo_afiliado');

        if ($tipo_afiliado==1) {

            $proveedores = Proveedor::all();

        }else if ($tipo_afiliado==2) {

            $proveedores = Proveedor::whereNull('tipo_afiliado')->orWhere('tipo_afiliado', 1)->orderBy('razonsocial')->get();

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

    public function postCargarproveedoresselect(){

        $tipo_afiliado = Input::get('tipo_afiliado');

        if ($tipo_afiliado==3) {

            $proveedores = Proveedor::afiliadosexternos()->valido()->orderBy('razonsocial')->get();
            $centrosdecosto = Centrodecosto::afiliadosexternos()->activos()->orderBy('razonsocial')->get();

        }else if ($tipo_afiliado==2) {

            $proveedores = Proveedor::afiliadosinternos()->valido()->orderBy('razonsocial')->get();
            $centrosdecosto = Centrodecosto::internos()->activos()->orderBy('razonsocial')->get();

        }else if ($tipo_afiliado==1) {

            $proveedores = Proveedor::valido()->orderBy('razonsocial')->get();
            $centrosdecosto = Centrodecosto::activos()->orderBy('razonsocial')->get();

        }

        if (count($proveedores)) {

            return Response::json([
                'respuesta' => true,
                'proveedores' => $proveedores,
                'centrosdecosto' => $centrosdecosto
            ]);

        }

    }

    public function postRestriccionvehiculo(){

      $rules = [
        'vehiculo_id' => 'required|numeric',
        'detalles' => 'required',
        'fecha_vencimiento' => 'required'
      ];

      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {

        return Response::json([
          'errors' => $validator->messages()
        ], 400);

      }else {

        $restriccion_vehiculo = new Restriccionvehiculo;
        $restriccion_vehiculo->detalles = strtoupper(strtolower(Input::get('detalles')));
        $restriccion_vehiculo->fecha_vencimiento = Input::get('fecha_vencimiento');
        $restriccion_vehiculo->vehiculo_id = Input::get('vehiculo_id');

        if ($restriccion_vehiculo->save()) {

          return Response::json([
            'restriccion_vehiculo' => $restriccion_vehiculo
          ], 200);

        }

      }

    }

    public function getVerrestriccionvehiculo(){

      $restriccion_vehiculo = Restriccionvehiculo::where('vehiculo_id', Input::get('vehiculo_id'))
      ->orderBy('id', 'desc')
      ->get();

      if (count($restriccion_vehiculo)) {

        return Response::json([
          'restriccion_vehiculo' => $restriccion_vehiculo
        ], 200);

      }else {

        return Response::json([
          'response' => false
        ], 404);

      }

    }

    public function postCheckrestriccionvehiculo(){

      $restriccion_vehiculo = Restriccionvehiculo::find (Input::get('restriccion_id'));

      if ($restriccion_vehiculo->check==null or $restriccion_vehiculo->check=='off') {
        $restriccion_vehiculo->check = 'on';
      }else if($restriccion_vehiculo->check=='on'){
        $restriccion_vehiculo->check = 'off';
      }

      if ($restriccion_vehiculo->save()) {

        return Response::json([
          'restriccion_vehiculo' => $restriccion_vehiculo
        ], 200);

      }

    }

    public function postEliminarrestriccion(){

      $restriccion_vehiculo = Restriccionvehiculo::find(Input::get('restriccion_id'));

      if ($restriccion_vehiculo->delete()) {

        return Response::json([
          'response' => true
        ], 200);

      }else {

        abort(404);

      }

    }

    public function postBloqueousovehiculo(){

      $rules = [
        'detalles' => 'required'
      ];

      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {

        return Response::json([
          'errors' => $validator->messages()
        ], 400);

      }else {

        if (Request::ajax()) {

          $vehiculo = Vehiculo::find(Input::get('vehiculo_id'));

          if ($vehiculo->bloqueado==1) {
            $vehiculo->bloqueado = null;
          }else if($vehiculo->bloqueado==null){
            $vehiculo->motivo_bloqueo_uso = Input::get('detalles');
            $vehiculo->bloqueado = 1;
          }

          if ($vehiculo->save()) {

            return Response::json([
              'response' => true,
              'vehiculo' => $vehiculo
            ], 200);

          }

        }

      }

    }

    public function postBloqueousoconductor(){

      $rules = [
        'detalles' => 'required'
      ];

      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {

        return Response::json([
          'errors' => $validator->messages()
        ], 400);

      }else {

        if (Request::ajax()) {

          $conductor = Conductor::find(Input::get('conductor_id'));

          if ($conductor->bloqueado==1) {
            $conductor->bloqueado = null;
          }else if($conductor->bloqueado==null){
            $conductor->motivo_bloqueo_uso = Input::get('detalles');
            $conductor->bloqueado = 1;
          }

          if ($conductor->save()) {

            return Response::json([
              'response' => true,
              'conductor' => $conductor
            ], 200);

          }

        }

      }

    }

    public function postBloqueototalvehiculo(){

      $rules = [
        'detalles' => 'required'
      ];

      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {

        return Response::json([
          'errors' => $validator->messages()
        ], 400);

      }else {

        if (Request::ajax()) {

          $vehiculo = Vehiculo::find(Input::get('vehiculo_id'));

          if ($vehiculo->bloqueado_total==1) {
            $vehiculo->bloqueado_total = null;
          }else if($vehiculo->bloqueado_total==null){
            $vehiculo->motivo_bloqueo_total = Input::get('detalles');
            $vehiculo->bloqueado_total = 1;
          }

          if ($vehiculo->save()) {

            return Response::json([
              'response' => true,
              'vehiculo' => $vehiculo
            ], 200);

          }

        }

      }

    }

    public function postBloqueototalconductor(){

      $rules = [
        'detalles' => 'required'
      ];

      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {

        return Response::json([
          'errors' => $validator->messages()
        ], 400);

      }else {

        if (Request::ajax()) {

          $conductor = Conductor::find(Input::get('conductor_id'));

          if ($conductor->bloqueado_total==1) {
            $conductor->bloqueado_total = null;
          }else if($conductor->bloqueado_total==null){
            $conductor->motivo_bloqueo_total = Input::get('detalles');
            $conductor->bloqueado_total = 1;
          }

          if ($conductor->save()) {

            return Response::json([
              'response' => true,
              'conductor' => $conductor
            ], 200);

          }

        }

      }

    }

    public function postDesbloqueousovehiculo(){

      $vehiculo = Vehiculo::find(Input::get('vehiculo_id'));
      $vehiculo->bloqueado = null;
      $vehiculo->motivo_bloqueo_uso = null;

      if ($vehiculo->save()) {

        return Response::json([
          'response' => true
        ], 200);

      }

    }

    public function postDesbloqueousoconductor(){

      $conductor = Conductor::find(Input::get('conductor_id'));
      $conductor->bloqueado = null;
      $conductor->motivo_bloqueo_uso = null;

      if ($conductor->save()) {

        return Response::json([
          'response' => true
        ], 200);

      }

    }

    public function postDesbloqueototalvehiculo(){

      $vehiculo = Vehiculo::find(Input::get('vehiculo_id'));
      $vehiculo->bloqueado_total = null;
      $vehiculo->motivo_bloqueo_total = null;

      if ($vehiculo->save()) {

        return Response::json([
          'response' => true
        ], 200);

      }

    }

    public function postDesbloqueototalconductor(){

      $conductor = Conductor::find(Input::get('conductor_id'));
      $conductor->bloqueado_total = null;
      $conductor->motivo_bloqueo_total = null;

      if ($conductor->save()) {

        return Response::json([
          'response' => true
        ], 200);

      }

    }

    public function getBloqueoestadovehiculo(){

      $vehiculo = Vehiculo::find(Input::get('vehiculo_id'));

      if ($vehiculo) {

        return Response::json([
          'response' => true,
          'vehiculo' => $vehiculo
        ], 200);

      }

    }

    public function getBloqueoestadoconductor(){

      $conductor = Conductor::find(Input::get('conductor_id'));

      if ($conductor) {

        return Response::json([
          'response' => true,
          'conductor' => $conductor
        ], 200);

      }

    }

    public function getRestriccionesvehiculos(){

      $restricciones_vehiculo = Restriccionvehiculo::whereRaw("DATEDIFF(restriccion_vehiculos.fecha_vencimiento, now()) >= 0 and (restriccion_vehiculos.check is null or restriccion_vehiculos.check = 'off')")
      ->with([
        'vehiculo.proveedor'
      ])->get();

      if (count($restricciones_vehiculo)) {

          return Response::json([
            'response' => true,
            'restricciones_vehiculos' => $restricciones_vehiculo
          ]);

      }else {

        return Response::json([
          'response' => false
        ]);

      }

    }

    public function postTodosvehiculos(){

      $option = Input::get('option');

      $query = Vehiculo::whereHas('proveedor', function($q)
      {
          $q->whereNull('inactivo_total');
      });

      if ($option==1) {
        $query->noarchivado();
      }else if($option==2){
        $query->archivado();
      }

      $vehiculos = $query->noeventual()->orderBy('placa', 'asc')->with(['proveedor'])->get();

      if (count($vehiculos)) {

        return Response::json([
          'response' => true,
          'vehiculos' => $vehiculos
        ]);

      }

    }

    public function postTodosconductores(){

      $option = Input::get('option');

      $query = Conductor::whereHas('proveedor', function($q)
      {
          $q->whereNull('inactivo_total');
      })->Seguridadsocialmes();

      if ($option==1) {
        $query->noarchivado();
      }else if($option==2){
        $query->archivado();
      }else if($option==3){
        $query->confoto();
      }elseif ($option==4) {
        $query->confotosinautorizar();
      }

      $conductores = $query->noeventual()->orderBy('nombre_completo', 'asc')->with(['proveedor'])->get();

      if (count($conductores)) {

        return Response::json([
          'response' => true,
          'conductores' => $conductores
        ]);

      }else{
        return Response::json([
          'response' =>false
        ]);
      }

    }

    public function postAprobarfoto(){

      $data = Input::get('data');

      $conductor = Conductor::find($data);
      $name = $conductor->foto_sin_autorizar;

      $query = DB::table('conductores')
      ->where('id', $data)
      ->update([
        'foto_autorizacion' => 1,
        'foto' => $name,
        'foto_app' => $name,
        'foto_sin_autorizar' => null
      ]);

      if($query){
        return Response::json([
          'mensaje'=>true
        ]);
      }else{
        return Response::json([
          'mensaje'=>false
        ]);
      }
    }

    public function postDesaprobarfoto(){

      $data = Input::get('data');

      $conductor = Conductor::find($data);      

      $query = DB::table('conductores')
      ->where('id', $data)
      ->update([
        'foto' => NULL,
        'foto_app' => NULL,
        'foto_autorizacion'=> 0,
        'foto_sin_autorizar' => NULL
      ]);

      if($query){
        //ELIMINAR FOTO DE BIBLIOTECA IMÁGENES
        return Response::json([
          'mensaje'=>true
        ]);
      }else{
        return Response::json([
          'mensaje'=>false
        ]);
      }
    }

    public function postMostrarconductoresasignar(){

      if (!Sentry::check()){

          return Response::json([
              'response'=>'relogin'
          ]);

      }else{

          if(Request::ajax()){

            $conductores = Conductor::where('proveedores_id', Input::get('proveedor_id'))
            ->noeventual()->bloqueado()
            ->bloqueadototal()->noarchivado()
            ->orderBy('nombre_completo')
            ->get();

            $vehiculo_conductores_pivot = VehiculoConductorPivot::where('vehiculo_id', Input::get('vehiculo_id'))->get();

            if (count($conductores)) {

              return Response::json([
                'response' => true,
                'conductores' => $conductores,
                'vehiculo_conductores_pivot' => $vehiculo_conductores_pivot
              ]);

            }

          }
      }

    }

    public function postAsignarconductores(){

      if (!Sentry::check()){

        return Response::json([
            'response'=>'relogin'
        ]);

      }else{

        if(Request::ajax()){

          $rules = [
            'conductor_id' => 'required|array|max:2|min:1',
            'vehiculo_id' => 'required'
          ];

          $mensajes = [
            'conductor_id.required' => 'Debe seleccionar al menos un conductor',
            'conductor_id.max' => 'Solo puede seleccionar a dos conductores'
          ];

          $validator = Validator::make(Input::all(), $rules, $mensajes);

          if ($validator->fails()){

            return Response::json([
              'response' => false,
              'errores' => $validator->errors()->getMessages()
            ]);

          }else {

            $vehiculo_id = Input::get('vehiculo_id');
            $conductores_id = Input::get('conductor_id');

            //Obtener los conductores por cada vehiculo
            $vcp = VehiculoConductorPivot::where('vehiculo_id', $vehiculo_id)->get();

            foreach ($vcp as $v) {
              $v->delete();
            }

            for ($i=0; $i < count($conductores_id) ; $i++) {

              $vcp_search = VehiculoConductorPivot::where('conductor_id', $conductores_id[$i])->first();

              if (!count($vcp_search)) {

                $vcp_new = new VehiculoConductorPivot();
                $vcp_new->conductor_id = $conductores_id[$i];
                $vcp_new->vehiculo_id = $vehiculo_id;
                $vcp_new->creado_por = Sentry::getUser()->id;
                $vcp_new->save();

              }

            }

            return Response::json([
              'response' => true
            ]);

          }

        }

      }

    }

}
