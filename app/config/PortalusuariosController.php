<?php

class PortalusuariosController extends BaseController{
	
    public function getIndex(){    

      return View::make('admin.principalportal');
    
    }

	public function postLogin(){

        if(Request::ajax()){

        	$id_employer = Input::get('usuario');
        	$password = Input::get('password');

        	$pasajero = Pasajero::where('correo',$id_employer)->first();

        	if(!$pasajero){
        		return Response::json([
        			'respuesta' => false,
        		]);
        	}else if($pasajero->cedula == $password){    			
        		return Response::json([
        			'respuesta' => true,
        			'encontrado' => true
        		]);
                session_start();
                $_SESSION['user'] = 2;
        	}else{
        		$tipousuario = $pasajero->tipousuario;
        		return Response::json([
    				'respuesta' => true,
    				'encontrado' => false,
        		]);
        	}
        }
    }
    public function getQrcode(){
        
        if (Sentry::check()){
            $id_rol = Sentry::getUser()->id_rol;
            $userportal = Sentry::getUser()->usuario_portal;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
            $ver = $permisos->portalusuarios->qrusers->ver;            

        }else{
            $ver = null;
        }
        if (!Sentry::check()){            
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on') {
            return View::make('admin.permisos');
        }else{
            
            $username = Sentry::getUser()->username;
            $data = DB::table('pasajeros')->where('correo',$username)->get();            
            $cliente = DB::table('pasajeros')->where('correo',$username)->pluck('centrodecosto_id');
            $centro = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');

            return View::make('portalusuarios.qrcode')
            ->with('permisos',$permisos)
            ->with('dato',$data)
            ->with('centro',$centro);           
        }        
    }

    public function getPoliticas(){        
        
        if (Sentry::check()){  
            $id_rol = Sentry::getUser()->id_rol;
            $userportal = Sentry::getUser()->usuario_portal;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
            $ver = $permisos->portalusuarios->qrusers->ver;   
            
        }else{
            $ver = null;
        }
        if (!Sentry::check()){            
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on') {
            return View::make('admin.permisos');
        }else{
            return View::make('portalusuarios.descargarpoliticas')
            ->with('permisos',$permisos);
        }
    }

    public function postEnviarpqr() {

        if(Request::ajax()){
            $validaciones = [
            'nombres'=>'required',
            'telefono'=>'required',
            'tiposolicitud'=>'required',
            //'email'=>'required|email',
            'ciudad'=>'required|sololetrasyespacio',
            'direccion'=>'required',
            'info'=>'required',            
          ];

          $mensajes = [
            'nombres.required'=>'El campo nombres es requerido',
            //'apellidos.required'=>'El campo apellidos es requerido',
            'telefono.required'=>'El campo telefono es requerido',
            //'id_employer.required'=>'El campo id id_employer es requerido',
            //'cedula.numeric'=>'El campo cedula debe ser numerico',
            'tiposolicitud.select'=>'El campo tiposolicitud es requerido',
            //'email.required'=>'El campo email es requerido',
            'ciudad.sololetrasyespacio'=>'Debe seleccionar un campo de ciudad',
            'direccion.required'=>'El campo direccion es requerido',
            'info.required'=>'El campo Info es requerido',

          ];

      
          $validador = Validator::make(Input::all(), $validaciones,$mensajes);

          if ($validador->fails())
          {
            return Response::json([
              'mensaje'=>false,
              'errores'=>$validador->errors()->getMessages()
            ]);

          }else{

            $nombres = Input::get('nombres');
            //$apellidos = Input::get('apellidos');
            $telefono = Input::get('telefono');
            //$cedula = Input::get('cedula');
            $tiposolicitud = Input::get('tiposolicitud');
            $info = Input::get('info');
            $email = Input::get('email');
            $ciudad = Input::get('ciudad');
            $direccion = Input::get('direccion');

            $pasajero = new Pqr;
            $pasajero->telefono = $telefono;
            $pasajero->info = $info;
            $pasajero->email = $email;
            $pasajero->tipo = $tiposolicitud;
            $pasajero->id_user = 1;
            if($pasajero->save()){
                return Response::json([
                    'mensaje'=>true,
                ]);
            }            

        }
            
        }
    }

    //ADMINISTRADOR
    public function getExportardatos (){

        if (Sentry::check()){
          $id_rol = Sentry::getUser()->id_rol;
          $id_usuario = Sentry::getUser()->id;
          $cliente = Sentry::getUser()->centrodecosto_id;  
          $nombrecentrodecosto = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);

          //Filtro para visión sólamente de Gerencia, Facturación y ADMIN.
          if($id_rol==1 or $id_rol ==2 or $id_rol==8 or $id_rol = 38){
            $ver = 'on';
          }else{
            $ver = null;
          }

        }else{
          $ver = null;
        }
        if (!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on') {

          return View::make('admin.permisos');

        }else{

            $centrosdecosto = DB::table('centrosdecosto')
            ->whereIn('id',[19,287])
            ->get();

            //if($cliente==19){
              //return View::make('admin.mantenimiento');
            //}else{
              return View::make('portalusuarios.admin.listado.exportarpasajerossgs')
              ->with('idusuario',$id_usuario)
              ->with('permisos',$permisos)
              ->with('centrosdecosto',$centrosdecosto);
           // }              
        }
    }

    public function getTestsms (){

        if (Sentry::check()){
          $id_rol = Sentry::getUser()->id_rol;
          $id_usuario = Sentry::getUser()->id;
          $cliente = Sentry::getUser()->centrodecosto_id;  
          $nombrecentrodecosto = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = 'on';

        }else{
          $ver = null;
        }
        if (!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on') {

          return View::make('admin.permisos');

        }else{
                return View::make('portalusuarios.test')
                ->with('idusuario',$id_usuario)
                ->with('permisos',$permisos);
        }
    }

    public function getDashboardadministrador (){

        if (Sentry::check()){
          $id_rol = Sentry::getUser()->id_rol;
          $id_usuario = Sentry::getUser()->id;
          $cliente = Sentry::getUser()->centrodecosto_id;  
          $nombrecentrodecosto = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = 'on';

        }else{
          $ver = null;
        }
        if (!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on') {

          return View::make('admin.permisos');

        }else{
                return View::make('portalusuarios.admin.dashboard.seleccionar')
                ->with('idusuario',$id_usuario)
                ->with('permisos',$permisos);
        }
    }

    public function postExportarlistadodia(){

      if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{ 
                        
            $centrodecostoid = Sentry::getUser()->centrodecosto_id;
            $fecha = Input::get('md_fecha_inicial');
            $fechafinal = Input::get('md_fecha_final');
            $centrodecosto = Input::get('md_centrodecosto');
            $subcentrodecosto = Input::get('md_subcentrodecosto');
            if($fecha < '2000-01-01'){                
                    echo "<script>
                        alert('No hay datos para descargar.');
                    </script>";
            }else{
              
              if ($centrodecosto==='-' or $subcentrodecosto==='-') {

                  return Redirect::to('transportes');

              }else{
                  ob_end_clean();
                  ob_start();
                  Excel::create('Listado Del '.$fecha.' al '.$fechafinal, function($excel) use ($centrodecosto, $subcentrodecosto, $fecha, $fechafinal, $centrodecostoid){

                      $excel->sheet('hoja', function($sheet) use ($centrodecosto, $subcentrodecosto, $fecha, $fechafinal, $centrodecostoid){                    

                                $consulta = "select  a.id, a.pasajeros_ruta, a.detalle_recorrido, a.hora_servicio, b.nombresubcentro, d.nombre_completo, e.placa, a.cantidad , a.fecha_servicio, c.unitario_cobrado, c.numero_planilla, day(a.fecha_servicio), month(a.fecha_servicio),                                                   

                                CASE

                                WHEN a.dejar_en LIKE '%Aut%' AND a.recoger_en LIKE '%Sutherlan%' THEN 'AUTO'
                                when a.dejar_en LIKE '%sutherland%' and recoger_en like'%aut%' THEN 'AUTO'
                                ELSE 'VAN'

                                END

                                as 'tipo_vehiculo',

                                CASE 

                                when a.dejar_en like '%ABIE%' OR a.dejar_en like '%ABOE%' OR a.dejar_en like '%AIER%' OR a.dejar_en like '%BIE%' OR a.dejar_en like '%ABI%' OR a.recoger_en like '%ABIER%' OR a.recoger_en like '%ABOE%' 
                                OR a.recoger_en like '%AIER%' OR a.recoger_en like '%ABIR%' OR a.recoger_en like '%BIE%'
                                then 'ABIERTO'
                                when a.dejar_en like '%CERR%' OR  a.dejar_en like '%CRRA%' OR  a.dejar_en like '%CARRA%' OR a.recoger_en like '%CERRA%' OR a.recoger_en like '%CRRA%' 
                                OR a.recoger_en like '%CARR%' then 'CERRADO'
                                else 'SOACHA'

                                END

                                AS 'tipo_servicio',c.servicio_id, c.unitario_cobrado

                                from autonet.servicios a
                                left outer join subcentrosdecosto b on a.subcentrodecosto_id=b.id
                                left outer join facturacion c on c.servicio_id=a.id
                                left outer join conductores d on a.conductor_id = d.id
                                left outer join vehiculos e on a.vehiculo_id =e.id
                                where a.centrodecosto_id='$centrodecostoid' AND a.motivo_eliminacion is null and a.fecha_servicio between '$fecha' and '$fechafinal'";                            
                    
                          $servicios = DB::select($consulta);

                          $sheet->loadView('servicios.plantillalistadodia2')
                          ->with([
                              'servicios'=>$servicios
                          ]);

                          ob_end_clean();
                          ob_start();

                          $objDrawing = new PHPExcel_Worksheet_Drawing;
                          $objDrawing->setPath('biblioteca_imagenes/logos.png');
                          $objDrawing->setCoordinates('B2');
                          $objDrawing->setResizeProportional(false);
                          $objDrawing->setWidth(120);
                          $objDrawing->setHeight(30);
                          $objDrawing->setWorksheet($sheet);

                      });
                    })->download('xls');
                }
            }
        }
    }

    public function postExportarlistadosgs(){

      if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{ 
                        
            $centrodecostoid = Input::get('centro');
            $fecha = Input::get('md_fecha_inicial');
            $fechafinal = Input::get('md_fecha_final');
            $centrodecosto = Input::get('md_centrodecosto');
            $subcentrodecosto = Input::get('md_subcentrodecosto');
            if($fecha < '2000-01-01'){                
                    echo "<script>
                        alert('No hay datos para descargar.');
                    </script>";
            }else{
              
              if ($centrodecosto==='-' or $subcentrodecosto==='-') {

                  return Redirect::to('transportes');

              }else{
                  ob_end_clean();
                  ob_start();
                  Excel::create('Listado Del '.$fecha.' al '.$fechafinal, function($excel) use ($centrodecosto, $subcentrodecosto, $fecha, $fechafinal, $centrodecostoid){

                      $excel->sheet('hoja', function($sheet) use ($centrodecosto, $subcentrodecosto, $fecha, $fechafinal, $centrodecostoid){                    

                                $consulta = "select  a.id, a.pasajeros_ruta, a.detalle_recorrido, a.hora_servicio, b.nombresubcentro, d.nombre_completo, e.placa, e.clase, a.cantidad , a.fecha_servicio, c.unitario_cobrado, c.numero_planilla, day(a.fecha_servicio), month(a.fecha_servicio),                                                   

                                CASE

                                WHEN a.dejar_en LIKE '%Aut%' AND a.recoger_en LIKE '%Sutherlan%' THEN 'AUTO'
                                when a.dejar_en LIKE '%sutherland%' and recoger_en like'%aut%' THEN 'AUTO'
                                ELSE 'VAN'

                                END

                                as 'tipo_vehiculo',

                                CASE 

                                when a.dejar_en like '%ABIE%' OR a.dejar_en like '%ABOE%' OR a.dejar_en like '%AIER%' OR a.dejar_en like '%BIE%' OR a.dejar_en like '%ABI%' OR a.recoger_en like '%ABIER%' OR a.recoger_en like '%ABOE%' 
                                OR a.recoger_en like '%AIER%' OR a.recoger_en like '%ABIR%' OR a.recoger_en like '%BIE%'
                                then 'ABIERTO'
                                when a.dejar_en like '%CERR%' OR  a.dejar_en like '%CRRA%' OR  a.dejar_en like '%CARRA%' OR a.recoger_en like '%CERRA%' OR a.recoger_en like '%CRRA%' 
                                OR a.recoger_en like '%CARR%' then 'CERRADO'
                                else 'SOACHA'

                                END

                                AS 'tipo_servicio',c.servicio_id, c.unitario_cobrado

                                from autonet.servicios a
                                left outer join subcentrosdecosto b on a.subcentrodecosto_id=b.id
                                left outer join facturacion c on c.servicio_id=a.id
                                left outer join conductores d on a.conductor_id = d.id
                                left outer join vehiculos e on a.vehiculo_id =e.id
                                where a.centrodecosto_id='$centrodecostoid' AND a.motivo_eliminacion is null and a.fecha_servicio between '$fecha' and '$fechafinal'";                            
                    
                          $servicios = DB::select($consulta);

                          if(Sentry::getUser()->localidad==2){
                            $sheet->loadView('servicios.plantillalistadodia3')
                              ->with([
                                  'servicios'=>$servicios
                              ]);
                          }else{
                            if($centrodecostoid == '287'){
                              $sheet->loadView('servicios.plantillalistadodia3')
                              ->with([
                                  'servicios'=>$servicios
                              ]);
                            }elseif ($centrodecostoid == '19') {
                              $sheet->loadView('servicios.plantillalistadodia4')
                              ->with([
                                  'servicios'=>$servicios
                              ]);
                            }else{
                              $sheet->loadView('servicios.plantillalistadodia3')
                              ->with([
                                  'servicios'=>$servicios
                              ]);
                            }
                          }

                          $objDrawing = new PHPExcel_Worksheet_Drawing;
                          $objDrawing->setPath('biblioteca_imagenes/logos.png');
                          $objDrawing->setCoordinates('B2');
                          $objDrawing->setResizeProportional(false);
                          $objDrawing->setWidth(120);
                          $objDrawing->setHeight(30);
                          $objDrawing->setWorksheet($sheet);

                      });
                    })->download('xls');
                }
            }
        }
    }

    //FIN ADMINISTRADOR

}

//controlador del portal de usuarios!!!
