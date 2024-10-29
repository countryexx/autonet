<?php

use Illuminate\Database\Eloquent\Model;

Class ThumanoController extends BaseController{

	public function getIndex(){    

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';
    }else{
      $ver = 'on';
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{    

            $query = DB::table('gestion_documental')            
            ->leftJoin('conductores', 'gestion_documental.id_conductor', '=', 'conductores.id')            
            ->select('gestion_documental.*', 'conductores.nombre_completo','conductores.celular')            
            ->where('fecha',date('Y-m-d'))
            ->whereIn('gestion_documental.estado',[0,1])
            ->get();            
            $o = 1;

            return View::make('talentohumano.menu_inicial', [  
            
              'documentos' => $query,
              'permisos' =>$permisos,
              'o' => $o
            ]);
                      
        }
    }

    public function getPersonaladministrativo(){    

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->talentohumano->empleados->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{                
      $o = 1;

      //TODOS LOS EMPLEADOS
      $empleados = DB::table('empleados')
      ->orderBy('nombres')
      ->whereNotNull('nombres')
      ->where('tipo_personal','ADMINISTRATIVO')
      ->where('estado',1)
      ->get();

      //EMPLEADOS DE BAQ
      $empleados_baq = DB::table('empleados')
      ->orderBy('nombres')
      ->whereNotNull('nombres')
      ->where('tipo_personal','ADMINISTRATIVO')
      ->where('estado',1)
      ->where('sede','BARRANQUILLA')
      ->get();

      //EMPLEADOS DE BOG
      $empleados_bog = DB::table('empleados')
      ->orderBy('nombres')
      ->whereNotNull('nombres')
      ->where('tipo_personal','ADMINISTRATIVO')
      ->where('estado',1)
      ->where('sede','BOGOTA')
      ->get();

      return View::make('talentohumano.personal_administrativo', [  
      
        'permisos' =>$permisos,
        'empleados' => $empleados,
        'empleadosbaq' => $empleados_baq,
        'empleadosbog' => $empleados_bog,
        'o' => $o
      ]);
                      
        }
    }

    public function getPersonaloperativo(){    

      if(Sentry::check()){
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->talentohumano->empleados->ver;
      }else{
        $ver = null;
      }

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else if($ver!='on'){
        return View::make('admin.permisos');
      }else{ 

        //TODOS LOS EMPLEADOS
        $empleados = DB::table('empleados')
        ->whereNotNull('nombres')
        ->where('tipo_personal','OPERATIVO')
        ->where('estado',1)
        ->get();

        //EMPLEADOS DE BAQ
        $empleados_baq = DB::table('empleados')
        ->orderBy('nombres')
        ->whereNotNull('nombres')
        ->where('tipo_personal','OPERATIVO')
        ->where('estado',1)
        ->where('sede','BARRANQUILLA')
        ->get();

        //EMPLEADOS DE BOG
        $empleados_bog = DB::table('empleados')
        ->orderBy('nombres')
        ->whereNotNull('nombres')
        ->where('tipo_personal','OPERATIVO')
        ->where('estado',1)
        ->where('sede','BOGOTA')
        ->get();

        return View::make('talentohumano.personal_operativo', [  
          'permisos' => $permisos,
          'empleados' => $empleados,
          'empleadosbaq' => $empleados_baq,
          'empleadosbog' => $empleados_bog
        ]);
                        
      }
    }

    public function getPersonalretirado(){    

      if(Sentry::check()){
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->talentohumano->empleados->ver;
      }else{
        $ver = null;
      }

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else if($ver!='on'){
        return View::make('admin.permisos');
      }else{ 

        $empleados = DB::table('empleados')
        ->whereNotNull('nombres')
        ->where('estado',3)
        ->get();

        return View::make('talentohumano.personal_retirado', [  
          'permisos' =>$permisos,
          'empleados' => $empleados,
        ]);
                        
      }
    }

    //REGISTRAR EMPLEADO
    public function postRegistrarempleado(){

      if(Request::ajax()){ 

          $validacion = DB::table('empleados')                        
          ->where('cedula',Input::get('cedula'))
          ->first();

          if($validacion!=null){
            return Response::json([
              'respuesta' => 'duplicado'
            ]);
          }else{

            $empleado = new Empleado;
            
            $empleado->nombres = Input::get('nombres');
            $empleado->apellidos = Input::get('apellidos');
            $empleado->cedula = Input::get('cedula');
            $empleado->telefono = Input::get('telefono');
            $empleado->tipo_personal = Input::get('tipo_personal');
            $empleado->area = Input::get('area');
            $empleado->cargo = Input::get('cargo');
            $empleado->sede = Input::get('sede');
            $empleado->fecha_ingreso = Input::get('fecha_ingreso');
            $empleado->tipo_contrato = Input::get('tipo_contrato');
            $empleado->salario = Input::get('salario');
            $empleado->correo = Input::get('correo');
            $empleado->ciudad = Input::get('ciudad');
            $empleado->direccion = Input::get('direccion');
            $empleado->barrio = Input::get('barrio');
            $empleado->estado = 1;

            if (Input::hasFile('hoja')){

              $file1 = Input::file('hoja');
              $name_pdf1 = str_replace(' ', '', $file1->getClientOriginalName());
              
              $ubicacion_servicios = 'biblioteca_imagenes/talentohumano/hojas/';
              $file1->move($ubicacion_servicios, Input::get('cedula').$name_pdf1);               
              $empleado->hoja_de_vida = Input::get('cedula').$name_pdf1;
            
            }else{
              $empleado->hoja_de_vida = 1;
            }

            if(Input::hasFile('foto_perfil')){

              $file1 = Input::file('foto_perfil');
              $name_pdf1 = str_replace(' ', '', $file1->getClientOriginalName());
              
              $ubicacion_servicios = 'biblioteca_imagenes/talentohumano/fotos/';
              $file1->move($ubicacion_servicios, Input::get('cedula').$name_pdf1);               
              $empleado->foto = Input::get('cedula').$name_pdf1;
            
            }
            
            if($empleado->save()){

              return Response::json([
                'respuesta'=>true,
              ]);
              
            }else{

              return Response::json([
                'respuesta'=>false
              ]);

            }
          } 
      }
      //}

    }//SG

    public function postMostrarinfo(){

      $id = Input::get('id');

      $empleado = Empleado::find($id);

      if($empleado){
        return Response::json([
          'response' => true,
          'empleado'=> $empleado
        ]);
      }else{
        return Response::json([
          'response' => false
        ]);
      }

    }

    //EDITAR EMPLEADO
    public function postGuardarcambios(){

      
        if(Request::ajax()){                         

            $id = Input::get('id');

            $empleado = Empleado::find($id);
            //SI LA CÉDULA QUE INGRESÓ EL USUARIO EN EL UPDATE ES DIFERENTE A LA QUE TIENE ACTUALMENTE EN LA BD (ES DECIR, SI HAY UN CAMBIO DE CÉDULA)
            if($empleado->cedula!=Input::get('cedula')){
              //SE CONSULTA SI HAY UN USUARIO CON EL NÚMERO INGRESADO
              $duplicado = DB::table('empleados')
              ->where('cedula',Input::get('cedula'))
              ->first();

              //SI LA NUEVA CÉDULA INGRESADA ESTÁ REGISTRADA
              if($duplicado!=null){
                
                return Response::json([
                  'respuesta' => 'duplicado'
                ]);

              }else{
                //SI LA NUEVA CÉDULA INGRESADA NO LA TIENE OTRO USUARIO
                $empleado->nombres = Input::get('nombres');
                $empleado->apellidos = Input::get('apellidos');
                $empleado->cedula = Input::get('cedula');
                $empleado->telefono = Input::get('telefono');
                $empleado->tipo_personal = Input::get('tipodepersonal');
                $empleado->sede = Input::get('sede');
                $empleado->area = Input::get('area');
                $empleado->cargo = Input::get('cargo');                
                $empleado->fecha_ingreso = Input::get('fecha_ingreso');
                $empleado->tipo_contrato = Input::get('tipo_contrato');
                $empleado->salario = Input::get('salario');
                $empleado->correo = Input::get('correo');
                $empleado->ciudad = Input::get('ciudad');
                $empleado->direccion = Input::get('direccion');
                $empleado->barrio = Input::get('barrio');

                if (Input::hasFile('hoja')){

                  $file1 = Input::file('hoja');
                  $name_pdf1 = str_replace(' ', '', $file1->getClientOriginalName());
                  
                  $ubicacion_servicios = 'biblioteca_imagenes/mantenimiento_fact/';
                  $file1->move($ubicacion_servicios, Input::get('cedula').$name_pdf1);               
                  $empleado->hoja_de_vida = Input::get('cedula').$name_pdf1;
                
                }

                /*if (Input::hasFile('foto_perfil')){

                  $file1 = Input::file('foto_perfil');
                  $name_pdf1 = str_replace(' ', '', $file1->getClientOriginalName());
                  
                  $ubicacion_servicios = 'biblioteca_imagenes/hojas/';
                  $file1->move($ubicacion_servicios, Input::get('cedula').$name_pdf1);               
                  $empleado->foto = Input::get('cedula').$name_pdf1;
                
                }*/
                
                if($empleado->save()){

                  return Response::json([
                    'respuesta'=>true,
                  ]);
                  
                }else{
                  return Response::json([
                    'respuesta' => false
                  ]);
                }
              }

            }else{
              //SI NO HAY CAMBIO DE CÉDULA
              $empleado->nombres = Input::get('nombres');
              $empleado->apellidos = Input::get('apellidos');
              $empleado->cedula = Input::get('cedula');
              $empleado->telefono = Input::get('telefono');
              $empleado->tipo_personal = Input::get('tipodepersonal');
              $empleado->sede = Input::get('sede');
              $empleado->area = Input::get('area');
              $empleado->cargo = Input::get('cargo');
              $empleado->fecha_ingreso = Input::get('fecha_ingreso');
              $empleado->tipo_contrato = Input::get('tipo_contrato');
              $empleado->salario = Input::get('salario');
              $empleado->correo = Input::get('correo');
              $empleado->ciudad = Input::get('ciudad');
              $empleado->direccion = Input::get('direccion');
              $empleado->barrio = Input::get('barrio');              

              if (Input::hasFile('hoja')){

                $file1 = Input::file('hoja');
                $name_pdf1 = str_replace(' ', '', $file1->getClientOriginalName());
                
                $ubicacion_servicios = 'biblioteca_imagenes/mantenimiento_fact/';
                $file1->move($ubicacion_servicios, Input::get('cedula').$name_pdf1);
                $empleado->hoja_de_vida = Input::get('cedula').$name_pdf1;
              
              }

              /*if (Input::hasFile('foto_perfil')){

                $file1 = Input::file('foto_perfil');
                $name_pdf1 = str_replace(' ', '', $file1->getClientOriginalName());
                
                $ubicacion_servicios = 'biblioteca_imagenes/hojas/';
                $file1->move($ubicacion_servicios, Input::get('cedula').$name_pdf1);               
                $empleado->foto = Input::get('cedula').$name_pdf1;
              
              }*/
              
              if($empleado->save()){

                return Response::json([
                  'respuesta'=>true,
                ]);
                
              }else{
                return Response::json([
                  'respuesta' => false
                ]);
              }
            }
        }
      //}

    }//SG

    //TEST FOTO DESPUES
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

                      $empleado = Empleado::find(Input::get('id'));

                      if (Input::hasFile('foto_perfil')){

                        $file = Input::file('foto_perfil');
                        $ubicacion = 'biblioteca_imagenes/talentohumano/fotos/';
                        $nombre_imagen = $file->getClientOriginalName();

                        $imagen_antigua = $empleado->foto;

                        if(file_exists($ubicacion.$nombre_imagen)){
                            $nombre_imagen = rand(1,100000).$nombre_imagen;
                        }

                        $empleado->foto = $nombre_imagen;

                        Image::make($file->getRealPath())->resize(250, 316)->save($ubicacion.$nombre_imagen);

                        Image::make($file->getRealPath())
                        ->resize(250, 250)->save($ubicacion.'thumbnail'.$nombre_imagen);

                      }else{

                          $empleado->foto = 'FALSE';
                      }

                      if($empleado->save()){

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

    //RETIRO DE EMPLEADOS
    public function postRetirarempleado(){

      if(Request::ajax()){   
        
        $empleado = Input::get('empleado');
        $fecha = Input::get('fecha');
        $observaciones = Input::get('observaciones');

        $consulta = Empleado::find($empleado);

        if($consulta){
          $consulta->fecha_retiro = $fecha;
          $consulta->estado = 3;

          if($consulta->historial==null){

            $text = 'El usuario fue RETIRADO de la compañía el '.$fecha.' con las siguientes observaciones: '.strtoupper($observaciones).'.';
            $array = [
              'detalle' => $text,
              'time' => date('Y-m-d H:i:s')
            ];
            $consulta->historial = json_encode([$array]);

          }else{

            $text = 'El usuario fue RETIRADO de la compañía el '.$fecha.' con las siguientes observaciones: '.strtoupper($observaciones).'.';
            $array = [
              'detalle' => $text,
              'time' => date('Y-m-d H:i:s')
            ];

            $objArray = json_decode($consulta->historial);
            array_push($objArray, $array);
            $consulta->historial = json_encode($objArray);        
          }

          if($consulta->save()){
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

    //RETIRO DE EMPLEADOS
    public function postReingresarempleado(){

      if(Request::ajax()){   
        
        $empleado = Input::get('empleado');
        $fecha = Input::get('fecha');

        $consulta = Empleado::find($empleado);
        if($consulta){

          if($consulta->historial==null){

            $text = 'El usuario fue REINTEGRADO el '.$fecha.'.';
            $array = [
              'detalle' => $text,
              'time' => date('Y-m-d H:i:s')
            ];

            $consulta->historial = json_encode([$array]);

          }else{

            $text = 'El empleado fue REINTEGRADO el '.$fecha.'.';
            $array = [
              'detalle' => $text,
              'time' => date('Y-m-d H:i:s')
            ];

            $objArray = json_decode($consulta->historial);
            array_push($objArray, $array);
            $consulta->historial = json_encode($objArray);
          }

          $consulta->fecha_reingreso = $fecha;
          $consulta->estado = 1;

          if($consulta->save()){
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

    public function postMostrarhoras(){

      $option = Input::get('option');
      $fecha = Input::get('fecha');

      $ingreso = Ingreso::where('empleado',$option)
      ->where('fecha',$fecha)->first();

      if($ingreso){
        return Response::json([
          'response' => true,
          'ingreso'=> $ingreso
        ]);
      }else{
        return Response::json([
          'response' => false
        ]);
      }

    }

    //SOLICITUDES DE PRESTAMOS
    public function getSolicitudesdeprestamos(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->talentohumano->prestamos->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{    

        $empleados = DB::table('empleados')
        ->where('estado',1)
        ->get();

        return View::make('talentohumano.solicitud_prestamos', [  
          'empleados' =>$empleados,
          'permisos' =>$permisos,
        ]);
                      
        }
    }

    //LISTADO DE PRESTAMOS A EMPLEADOS
    public function getListadodeprestamos(){
        
        if (Sentry::check()) {

          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->talentohumano->prestamos->ver;

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

            $empleados = DB::table('empleados')
            ->where('estado',1)
            ->orderBy('nombres')
            ->get();            

            $prestamos = DB::table('prestamos_empleados')
            ->orderBy('empleados.nombres')
            ->leftJoin('empleados', 'empleados.id', '=','prestamos_empleados.empleado')
            ->leftJoin('users', 'users.id', '=', 'prestamos_empleados.creado_por')
            ->select('prestamos_empleados.*', 'empleados.nombres', 'empleados.apellidos', 'users.first_name', 'users.last_name')
            ->where('prestamos_empleados.estado_prestamo',0)
            ->get();            

            return View::make('talentohumano.listado_prestamos')
            ->with('prestamos',$prestamos)                
            ->with('permisos',$permisos)
            ->with('empleados', $empleados)
            ->with('o',$o=1);
        }
    }

    //GUARDAR PRESTAMO
    public function postGuardarprestamo(){

        $fecha_solicitud = Input::get('fecha_solicitud');
        $fecha_aprobacion = Input::get('fecha_aprobacion');
        $empleado = Input::get('empleado');
        $valor = Input::get('valor');

        $prestamo = new PrestamoE();
        $prestamo->fecha_solicitud = $fecha_solicitud;
        $prestamo->fecha_aprobacion = $fecha_aprobacion;
        $prestamo->empleado = $empleado;
        $prestamo->valor = $valor;
        $prestamo->valor_restante = $valor;
        $prestamo->estado_prestamo = 0;
        $prestamo->creado_por = Sentry::getUser()->id;

        //HISTORIAL PUSH
        $consulta = Empleado::find($empleado);

        if($consulta->historial==null){

          $text = 'Se le realizó un PRÉSTAMO solicitado el '.$fecha_solicitud.' y aprobado el '.$fecha_aprobacion.', con valor de: '.number_format($valor).'.';
          $array = [
            'detalle' => $text,
            'time' => date('Y-m-d H:i:s')
          ];
          $consulta->historial = json_encode([$array]);
          $consulta->save();

        }else{

          $text = 'Se le realizó un PRÉSTAMO solicitado el '.$fecha_solicitud.' y aprobado el '.$fecha_aprobacion.', con valor de: '.number_format($valor).'.';
          $array = [
            'detalle' => $text,
            'time' => date('Y-m-d H:i:s')
          ];

          $objArray = json_decode($consulta->historial);
          array_push($objArray, $array);
          $consulta->historial = json_encode($objArray);        
          $consulta->save();
        }
        
        if($prestamo->save()){
            
          return Response::json([
            'respuesta' => true
          ]);

        }else{

          return Response::json([
            'respuesta' => false
          ]);

        }   
    }

    public function postGuardarabono(){

      $id = Input::get('id');
      $fecha = Input::get('fecha');
      $valor_abono = Input::get('valor_abono');
      $valor_restante = Input::get('valor_restante');

      $consulta = PrestamoE::find($id);

      if($consulta->detalles==null){

        $array = [
          'valor_actual' => $consulta->valor_restante,
          'valor_restante' => $valor_restante,
          'valor_abono' => $valor_abono,
          'fecha_abono' => $fecha
        ];
        $consulta->estado_prestamo = 1;
        $consulta->detalles = json_encode([$array]);

      }else{

        $array = [
          'valor_actual' => $consulta->valor_restante,
          'valor_restante' => $valor_restante,
          'valor_abono' => $valor_abono,
          'fecha_abono' => $fecha
        ];

        $objArray = json_decode($consulta->detalles);
        array_push($objArray, $array);
        $consulta->detalles = json_encode($objArray);        
        //$consulta->detalles = json_encode([$array]);
      }    

      $consulta->valor_restante = $valor_restante;
      if($valor_restante==0){
        $consulta->estado_prestamo = 2;
      }

      if($consulta->save()){
        return Response::json([
          'respuesta' => true
        ]);
      }else{
        return Response::json([
          'respuesta' => false
        ]);
      }
    }

    public function getDetalleprestamo($id){

        if (!Sentry::check()){
            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
        }else{

            $prestamos = DB::table('prestamos_empleados')
                ->select('prestamos_empleados.id','users.first_name','users.last_name','prestamos_empleados.valor', 'prestamos_empleados.fecha_aprobacion', 'prestamos_empleados.fecha_solicitud', 'prestamos_empleados.detalles', 'prestamos_empleados.valor_restante',
                    'prestamos_empleados.estado_prestamo', 'prestamos_empleados.detalles')
                ->leftJoin('users','prestamos_empleados.creado_por','=','users.id')
                ->where('prestamos_empleados.id',$id)
                ->first();

            return View::make('talentohumano.detalle_prestamo')
                ->with([
                    'prestamo'=>$prestamos,
                    'id'=>$id
                ]);

        }
    }

    //VACACIONES EMPLEADOS
    public function getVacaciones(){    

      if(Sentry::check()){
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->talentohumano->vacaciones->ver;
      }else{
        $ver = null;
      }

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else if($ver!='on'){
        return View::make('admin.permisos');
      }else{    

        $empleados = DB::table('empleados')
        ->where('estado',1)
        ->get();


        return View::make('talentohumano.vacaciones', [  
          'empleados' =>$empleados,
          'permisos' =>$permisos,
        ]);
                      
      }
    }

    //LISTADO DE VACACIONES A EMPLEADOS
    public function getListadodevacaciones(){
        
        if (Sentry::check()) {

          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->talentohumano->vacaciones->ver;

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

            $empleados = DB::table('empleados')
            ->where('estado',1)
            ->orderBy('nombres')
            ->get();            

            $vacaciones = DB::table('vacaciones')
            ->orderBy('empleados.nombres')
            ->leftJoin('empleados', 'empleados.id', '=','vacaciones.empleado')
            ->leftJoin('users', 'users.id', '=', 'vacaciones.creado_por')
            ->select('vacaciones.*', 'empleados.nombres', 'empleados.apellidos', 'users.first_name', 'users.last_name')
            ->get();            

            return View::make('talentohumano.listado_vacaciones')
            ->with('vacaciones',$vacaciones)                
            ->with('permisos',$permisos)
            ->with('empleados', $empleados)
            ->with('o',$o=1);
        }
    }

    //GUARDAR VACACIONES
    public function postGuardarvacaciones(){

        $fecha_inicial = Input::get('fecha_inicial');
        $fecha_final = Input::get('fecha_final');
        $empleado = Input::get('empleado');
        $observaciones = Input::get('observaciones');

        $vacaciones = new Vacaciones();
        $vacaciones->fecha_inicial = $fecha_inicial;
        $vacaciones->fecha_final = $fecha_final;
        $vacaciones->empleado = $empleado;
        $vacaciones->observaciones = $observaciones;
        $vacaciones->creado_por = Sentry::getUser()->id;

        //HISTORIAL PUSH
        $consulta = Empleado::find($empleado);

        if($consulta->historial==null){

          $text = 'El empleado fue enviado de VACACIONES el '.$fecha_inicial.' hasta '.$fecha_final.', con las siguientes observaciones: '.strtoupper($observaciones).'.';
          $array = [
            'detalle' => $text,
            'time' => date('Y-m-d H:i:s')
          ];

          $consulta->historial = json_encode([$array]);
          $consulta->save();

        }else{

          $text = 'El empleado fue enviado de VACACIONES el '.$fecha_inicial.' hasta '.$fecha_final.', con las siguientes observaciones: '.strtoupper($observaciones).'.';
          $array = [
            'detalle' => $text,
            'time' => date('Y-m-d H:i:s')
          ];

          $objArray = json_decode($consulta->historial);
          array_push($objArray, $array);
          $consulta->historial = json_encode($objArray);        
          $consulta->save();
        }
        
        if($vacaciones->save()){
            
          return Response::json([
            'respuesta' => true
          ]);

        }else{

          return Response::json([
            'respuesta' => false
          ]);

        }   
    }    

    //GUARDAR LLEGADA
    public function postGuardarllegada(){

        $fecha = Input::get('fecha');        
        $empleado = Input::get('empleado');
        $hora_llegada = Input::get('hora_llegada');
        $hora_salida = Input::get('hora_salida');
        $hora_llegadapm = Input::get('hora_llegadapm');
        $hora_salidapm = Input::get('hora_salidapm');

        $consulta = Ingreso::where('empleado',$empleado)
        ->where('fecha',$fecha)->first();

        if($consulta!=null){

          $valor_estado = $consulta->estado+1;
          $update = DB::table('control_ingreso')
          ->where('empleado', $empleado)
          ->where('fecha', $fecha)
          ->update([
            'estado' => $valor_estado,
            'hora_llegada' => $hora_llegada,
            'hora_salida' => $hora_salida,
            'hora_llegadapm' => $hora_llegadapm,
            'hora_salidapm' => $hora_salidapm,
          ]);

          return Response::json([
            'respuesta' => true
          ]);

        }else{

          $ingreso = new Ingreso();
          $ingreso->fecha = $fecha;        
          $ingreso->empleado = $empleado;
          $ingreso->hora_llegada = $hora_llegada;
          $ingreso->hora_salida = $hora_salida;
          $ingreso->hora_llegadapm = $hora_llegadapm;
          $ingreso->hora_salidapm = $hora_salidapm;
          $ingreso->estado = 1;
          
          if($ingreso->save()){
              
            return Response::json([
              'respuesta' => true
            ]);

          }else{

            return Response::json([
              'respuesta' => false
            ]);

          }  
        }
    }

    public function getHistorial($id){

        if (!Sentry::check()){
            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
        }else{

          $consulta = Empleado::find($id);

          return View::make('talentohumano.historial')
            ->with([                    
                'id'=>$id,
                'empleado'=>$consulta,
            ]);

        }
    }    

   //BUSCAR PRÉSTAMOS
    public function postBuscarprestamos(){

        $fecha_inicial = Input::get('fecha_inicial');
        $fecha_final = Input::get('fecha_final');
        $empleado = intval(Input::get('empleado'));
        $estado = intval(Input::get('estado'));

        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);

        $query = "select prestamos_empleados.id, prestamos_empleados.empleado, prestamos_empleados.valor, prestamos_empleados.valor_restante, prestamos_empleados.fecha_aprobacion, prestamos_empleados.fecha_solicitud, prestamos_empleados.estado_prestamo, users.first_name, users.last_name, empleados.nombres, empleados.apellidos from prestamos_empleados ".
        "left join empleados on empleados.id = prestamos_empleados.empleado ".
        "left join users on users.id = prestamos_empleados.creado_por ".
        "where prestamos_empleados.fecha_aprobacion BETWEEN '".$fecha_inicial."' and '".$fecha_final."' ";
        
        if($estado===1){
          //PRESTAMOS PENDIENTES DE PAGO
          $query .= "and prestamos_empleados.estado_prestamo = 0 ";
        }else if($estado===2){            
          //PRESTAMOS CON ABONO
          $query .="and prestamos_empleados.estado_prestamo = 1 ";
        }else if($estado===3){
          //PRESTAMOS CON PAGO
          $query .= "and prestamos_empleados.estado_prestamo = 2 ";
        }

        if ($empleado===0) {
            $consulta = DB::select($query.'order by empleados.nombres asc');
        }else if($empleado!=0){
            $query .= "and empleado = ".$empleado." ";
            $consulta = DB::select($query.'order by empleados.nombres asc');
        }

        if($consulta!=null){
            return Response::json([
                'respuesta' => true,
                'empleado' => $empleado,
                'prestamos' => $consulta,
                'permisos' => $permisos
            ]);
        }else{
            return Response::json([
                'respuesta' => false,
                'hola'=>1
            ]);
        }
    }    

    //BUSCAR VACACIONES
    public function postBuscarvacaciones(){

        $fecha_inicial = Input::get('fecha_inicial');
        $fecha_final = Input::get('fecha_final');
        $empleado = intval(Input::get('empleado'));
        $estado = intval(Input::get('estado'));

        $query = DB::table('vacaciones')
        ->leftJoin('users', 'users.id', '=', 'vacaciones.creado_por')
        ->leftJoin('empleados', 'empleados.id', '=', 'vacaciones.empleado')
        ->select('vacaciones.*', 'empleados.nombres', 'empleados.apellidos','users.first_name', 'users.last_name')
        ->where('vacaciones.fecha_inicial',$fecha_inicial)
        ->get();

        if($query!=null){
            return Response::json([
                'respuesta' => true,
                'empleado' => $empleado,
                'prestamos' => $query
            ]);
        }else{
            return Response::json([
                'respuesta' => false,
                'hola'=>1
            ]);
        }
    }    

    //GESTIÓN DE LLEGADA DE EMPLEADOS
    public function getControldeingreso(){
        
        if (Sentry::check()) {

          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = 'on'; //$permisos->contabilidad->factura_proveedores->ver;

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

            $empleados = DB::table('empleados')
            ->where('estado',1)
            ->orderBy('nombres')
            ->get();            

            $prestamos = DB::table('prestamos_empleados')
            ->orderBy('empleados.nombres')
            ->leftJoin('empleados', 'empleados.id', '=','prestamos_empleados.empleado')
            ->leftJoin('users', 'users.id', '=', 'prestamos_empleados.creado_por')
            ->select('prestamos_empleados.*', 'empleados.nombres', 'empleados.apellidos', 'users.first_name', 'users.last_name')
            ->where('prestamos_empleados.estado_prestamo',0)
            ->get();        

            return View::make('talentohumano.control_ingreso')            
            ->with('prestamos',$prestamos)
            ->with('documentos',$prestamos)
            ->with('permisos',$permisos)
            ->with('empleados', $empleados)
            ->with('o',$o=1);
    }
    }

    //PRUEBA VERSION 2
    public function getControldeingreso2(){    

      if(Sentry::check()){
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->bogota->transportes->ver;
      }else{
        $ver = null;
      }

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else if($ver!='on'){
        return View::make('admin.permisos');
      }else{    
        $query = DB::table('gestion_documental')            
        ->leftJoin('conductores', 'gestion_documental.id_conductor', '=', 'conductores.id')            
        ->select('gestion_documental.*', 'conductores.nombre_completo','conductores.celular')            
        ->where('fecha',date('Y-m-d'))
        ->whereIn('cliente',['SUTHERLAND BOG','MASTERFOOD'])
        ->whereIn('gestion_documental.estado',[0,1])
        ->get();            
        $o = 1;

        $conductores = Conductor::bloqueadototal()->bloqueado()
        ->leftJoin('proveedores', 'proveedores.id', '=', 'conductores.proveedores_id')
        ->select('conductores.nombre_completo','conductores.id')
        ->orderBy('nombre_completo')
        ->where('proveedores.localidad','BOGOTA')
        ->where('conductores.estado','ACTIVO')
        ->get();       

        return View::make('talentohumano.control_ingreso2', [  
        
          'documentos' => $query,
          'permisos' =>$permisos,
          'o' => $o
        ]);
                        
      }
    }

    public function postFile(){

      if (Input::hasFile('hoja_de_vida')){

        $file1 = Input::file('hoja_de_vida');
        $name_pdf1 = str_replace(' ', '', $file1->getClientOriginalName());
        //$name_pdf1 = Input::get('numero_factura').$name_pdf1;
        
        $ubicacion_servicios = 'biblioteca_imagenes/hojas/';
        if($file1->move($ubicacion_servicios, $name_pdf1)){
          echo "si";
        }else{
          echo "no";
        }
      }
    }

    //SUBIR IMAGENES
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

    public function postBuscar(){      

      if (Request::ajax()){

          $fecha_inicial = Input::get('fecha_inicial');
          $fecha_final = Input::get('fecha_final');
          $servicio = intval(Input::get('servicios'));
          $ciudad = Input::get('ciudad');
          $conductor_id = Input::get('conductores');
          $id_rol = Sentry::getUser()->id_rol;
          $option = Input::get('option');

          if ($conductor_id===null) {
            $conductor_id = 0;
          }  
          $cliente = Input::get('cliente_search');
          if($cliente==='CLIENTE'){
          	$cliente = 0;
          }
                                      
          $codigo = Input::get('codigo');                          

            $consulta = "select gestion_documental.id, gestion_documental.hora, gestion_documental.cliente, gestion_documental.tipo_ruta, gestion_documental.fecha, gestion_documental.id_image, gestion_documental.estado, gestion_documental.nombre_documento, gestion_documental.placa, gestion_documental.id_conductor, gestion_documental.novedadesruta, ".                    
                "conductores.nombre_completo, conductores.celular ".
                "from gestion_documental ".                   
                "left join conductores on gestion_documental.id_conductor = conductores.id ".
                "where gestion_documental.fecha between '".$fecha_inicial."' AND '".$fecha_final."' and gestion_documental.estado in (0,1) ";
                if($option==='1'){
                  $consulta .=" and cliente in('SUTHERLAND BAQ','ACEROS CORTADOS','LHOIST','PIMSA','PUERTO PIMSA', 'QUANTICA - BILATERAL')";
                }elseif ($option==='2') {
                  $consulta .=" and cliente in('SUTHERLAND BOG','MASTERFOOD')";
                }

          if($conductor_id!='0'){
          $consulta .= " and conductores.id = ".$conductor_id." ";
        }

        if($cliente!='0'){
        	$consulta.=" and gestion_documental.cliente = '".$cliente."' ";
        }

          if($codigo!=''){
            $consulta .= " and gestion_documental.id = '".$codigo."' ";
          }
          

          $documentos = DB::select(DB::raw($consulta." order by gestion_documental.id asc"));

          if ($documentos!=null) {
             
              return Response::json([
                  'mensaje'=>true,
                  'documentos'=>$documentos,                      
                  'consulta'=>$consulta,
                  'id_rol'=>$id_rol,
                  'option'=>$option
              ]);

          }else{

              return Response::json([
                  'mensaje'=>false,
                  'consulta'=>$consulta,                      
              ]);
          }
      }
      
  }

  public function postBuscarfotos(){      

      if (Request::ajax()){

          $fecha_inicial = Input::get('fecha_inicial');
          $fecha_final = Input::get('fecha_final');
          $servicio = intval(Input::get('servicios'));              
          
          $id_rol = Sentry::getUser()->id_rol;
          $id_cliente = Sentry::getUser()->centrodecosto_id;
          
          $cliente = Input::get('cliente_search');
          if($cliente==='CLIENTE'){
            $cliente = 0;
          }     

          if($id_cliente==287){
            $nombre_cliente = 'SUTHERLAND BOG';
          }elseif ($id_cliente==19){
            $nombre_cliente = 'SUTHERLAND BAQ';
          }

          $consulta = "select gestion_documental.id, gestion_documental.hora, gestion_documental.cliente, gestion_documental.tipo_ruta, gestion_documental.fecha, gestion_documental.id_image, gestion_documental.estado, gestion_documental.nombre_documento, gestion_documental.placa, gestion_documental.id_conductor, gestion_documental.novedadesruta, ".                    
            "conductores.nombre_completo, conductores.celular ".
            "from gestion_documental ".                   
            "left join conductores on gestion_documental.id_conductor = conductores.id ".
            "where gestion_documental.fecha between '".$fecha_inicial."' AND '".$fecha_final."' and gestion_documental.estado = 1 and gestion_documental.cliente = '".$nombre_cliente."' ";

          $documentos = DB::select(DB::raw($consulta." order by gestion_documental.id asc"));

          if ($documentos!=null) {
             
              return Response::json([
                  'mensaje'=>true,
                  'documentos'=>$documentos,
              ]);

          }else{

              return Response::json([
                  'mensaje'=>false,
                  'consulta'=>$consulta,                      
              ]);
          }
      }
      
  }

  	public function postMostrarconductores(){

        if(Request::ajax()){

        	$ciudad_id = Input::get('ciudad_id');

        	if($ciudad_id==1 or $ciudad_id==3){
        		$conductores = Conductor::bloqueadototal()->bloqueado()
        		->leftJoin('proveedores', 'proveedores.id', '=', 'conductores.proveedores_id')
        		 ->select('conductores.*',
                 'conductores.nombre_completo','conductores.id')
	            ->orderBy('nombre_completo')
	            ->where('proveedores.localidad','BARRANQUILLA')
	            ->where('conductores.estado','ACTIVO')
	            ->get();
        	}else if($ciudad_id==2){
        		$conductores = Conductor::bloqueadototal()->bloqueado()
        		->leftJoin('proveedores', 'proveedores.id', '=', 'conductores.proveedores_id')
        		 ->select('conductores.*',
                 'conductores.nombre_completo','conductores.id')
	            ->orderBy('nombre_completo')
	            ->where('proveedores.localidad','BOGOTA')
	            ->get();
        	}else{
        		$conductores=null;
        	}
            

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

    public function postAprobarfoto(){
	    
	    if(Sentry::check()){
	      $id_foto = Input::get('foto_id');
	      $query = GestionDocumental::find($id_foto);	      
	      $query->estado = 1;
	      
	      if($query->save()){
	        return Response::json([
	          'response' =>true,
	          'id' =>$query->id
	        ]);
	      }else{
	        return Response::json([
	          'response' =>false
	        ]);
	      }
	    }
  }

    public function postEliminarfoto(){
	    
	    if(Sentry::check()){
	      $id_foto = Input::get('foto_id');
	      $query = GestionDocumental::find($id_foto);	      
	      //$ubicacion = 'biblioteca_imagenes/gestion_documental/';
	      //$nombre_imagen = $id_foto.'.jpeg';
	      //if(file_exists($ubicacion.$nombre_imagen)){
	      	//File::delete($ubicacion.$nombre_imagen);
	      //}	     	      
        $query->estado = 2;
	      
	      if($query->save()){

	        return Response::json([
	          'response' =>true
	        ]);
	      }else{
	        return Response::json([
	          'response' =>false
	        ]);
	      }
	    }
  }

	public function getPdf(){

		if (Sentry::check()){

			$cliente = Input::get('cliente');
	        $fecha = Input::get('fecha_pdf');
	        
	        $consulta = "select gestion_documental.id, gestion_documental.hora, gestion_documental.tipo_ruta, gestion_documental.fecha, gestion_documental.id_image, gestion_documental.nombre_documento, gestion_documental.placa, gestion_documental.id_conductor, ".                    
                    "conductores.nombre_completo, conductores.celular ".
                    "from gestion_documental ".                   
                    "left join conductores on gestion_documental.id_conductor = conductores.id ".
                    "where gestion_documental.fecha = '".$fecha."' and gestion_documental.cliente = '".$cliente."' and gestion_documental.estado = 1";
            $documentos = DB::select(DB::raw($consulta." order by gestion_documental.id asc"));

	      $html = View::make('documentos.pdf_fotos_rutas')
	      ->with(['documentos'=>$documentos, 'fecha'=>$fecha]);
	      return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('RUTAS DEL DÍA '.$fecha.' '.$cliente);
	  	}
    }

    public function getPdffotos(){

      if (Sentry::check()){

        $id_cliente = Sentry::getUser()->centrodecosto_id;
        if($id_cliente==287){
          $nombre_cliente = 'SUTHERLAND BOG';
        }elseif ($id_cliente==19) {
          $nombre_cliente = 'SUTHERLAND BAQ';
        }

        $fecha = Input::get('fecha_pdf');
        
        $consulta = "select gestion_documental.id, gestion_documental.hora, gestion_documental.tipo_ruta, gestion_documental.fecha, gestion_documental.id_image, gestion_documental.nombre_documento, gestion_documental.placa, gestion_documental.id_conductor, ".                    
                  "conductores.nombre_completo, conductores.celular ".
                  "from gestion_documental ".                   
                  "left join conductores on gestion_documental.id_conductor = conductores.id ".
                  "where gestion_documental.fecha = '".$fecha."' and gestion_documental.cliente = '".$nombre_cliente."' and gestion_documental.estado = 1";
          $documentos = DB::select(DB::raw($consulta." order by gestion_documental.id asc"));

        $html = View::make('documentos.pdf_fotos_rutas')
        ->with(['documentos'=>$documentos, 'fecha'=>$fecha]);
        return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('RUTAS DEL DÍA '.$fecha.' '.$nombre_cliente);
      }
    }

    public function getExcel(){

      ob_end_clean();
      ob_start();
      Excel::create('Servicios', function($excel){

          $excel->sheet('hoja', function($sheet){

              $fecha_inicial = Input::get('fecha_inicial_excel');
              $fecha_final = Input::get('fecha_final_excel');
              $conductor = Input::get('conductores2');
              //$subcentrodecosto = Input::get('md_subcentrodecosto');

              $servicios = DB::select("select servicios.id, servicios.ciudad,  servicios.pasajeros_ruta, servicios.ruta, servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, centrosdecosto.razonsocial, subcentrosdecosto.nombresubcentro from servicios left join centrosdecosto on centrosdecosto.id = servicios.centrodecosto_id left join subcentrosdecosto on subcentrosdecosto.id = servicios.subcentrodecosto_id where servicios.fecha_servicio between '".$fecha_inicial."' and '".$fecha_final."' and servicios.conductor_id = '".$conductor."' and pendiente_autori_eliminacion is null order by fecha_servicio asc");

              $sheet->loadView('documentos.plantilla_servicios')
              ->with([
                  'servicios'=>$servicios
              ]);
          });
      })->download('xls');
      

    }
}
?>