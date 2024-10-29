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
            ->whereIn('id',[19,287,489,323,462])
            ->get();

            if($cliente==19){
              return View::make('admin.mantenimiento');
            }else{
              return View::make('portalusuarios.admin.listado.exportarpasajerossgs')
              ->with('idusuario',$id_usuario)
              ->with('permisos',$permisos)
              ->with('centrosdecosto',$centrosdecosto);
            }
        }
    }

    //ADMINISTRADOR
    public function getEmergia (){

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

            if($cliente==19){
              return View::make('admin.mantenimiento');
            }else{
              return View::make('portalusuarios.admin.listado.exportarpasajerossgs')
              ->with('idusuario',$id_usuario)
              ->with('permisos',$permisos)
              ->with('centrosdecosto',$centrosdecosto);
            }
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

                                $consulta = "select  a.id, a.pasajeros_ruta, a.pasajeros, a.detalle_recorrido, a.hora_servicio, a.email_solicitante, a.recoger_en, a.dejar_en, a.ruta, b.nombresubcentro, d.nombre_completo, e.placa, e.clase, e.capacidad, a.cantidad, a.fecha_servicio, c.unitario_cobrado, c.numero_planilla, day(a.fecha_servicio), month(a.fecha_servicio), f.razonsocial as razon_centro,

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
                                when a.dejar_en like '%SOACH%' then 'SOACHA'
                                else 'CERRADO'

                                END

                                AS 'tipo_servicio',c.servicio_id, c.unitario_cobrado

                                from autonet.servicios a
                                left outer join subcentrosdecosto b on a.subcentrodecosto_id=b.id
                                left outer join facturacion c on c.servicio_id=a.id
                                left outer join conductores d on a.conductor_id = d.id
                                left outer join vehiculos e on a.vehiculo_id =e.id
                                left outer join proveedores f on f.id = a.proveedor_id
                                where a.centrodecosto_id='$centrodecostoid' AND a.motivo_eliminacion is null and a.fecha_servicio between '$fecha' and '$fechafinal'";

                          $servicios = DB::select($consulta);

                          if(Sentry::getUser()->localidad==2){
                            $sheet->loadView('servicios.plantillalistadodia5')
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

    public function postExportarlistadoemergia(){

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
                  Excel::create('Listado Del '.$fecha, function($excel) use ($centrodecosto, $subcentrodecosto, $fecha, $fechafinal, $centrodecostoid){

                      $excel->sheet('hoja', function($sheet) use ($centrodecosto, $subcentrodecosto, $fecha, $fechafinal, $centrodecostoid){

                                $consulta = "select  a.id, a.pasajeros_ruta, a.pasajeros, a.detalle_recorrido, a.hora_servicio, a.email_solicitante, a.recoger_en, a.dejar_en, a.ruta, b.nombresubcentro, d.nombre_completo, e.placa, e.clase, e.capacidad, a.cantidad, a.fecha_servicio, c.unitario_cobrado, c.numero_planilla, day(a.fecha_servicio), month(a.fecha_servicio), f.razonsocial as razon_centro,

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
                                when a.dejar_en like '%SOACH%' then 'SOACHA'
                                else 'CERRADO'

                                END

                                AS 'tipo_servicio',c.servicio_id, c.unitario_cobrado

                                from autonet.servicios a
                                left outer join subcentrosdecosto b on a.subcentrodecosto_id=b.id
                                left outer join facturacion c on c.servicio_id=a.id
                                left outer join conductores d on a.conductor_id = d.id
                                left outer join vehiculos e on a.vehiculo_id =e.id
                                left outer join proveedores f on f.id = a.proveedor_id
                                where a.centrodecosto_id= 474 AND a.motivo_eliminacion is null and a.fecha_servicio = '$fecha' ";

                          $servicios = DB::select($consulta);

                          $sheet->loadView('servicios.plantillalistadodia_emergia')
                          ->with([
                              'servicios'=>$servicios
                          ]);

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

    public function postExportarlistadonovedades(){

      if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

            $centrodecostoid = Input::get('centro');
            $fecha = Input::get('md_fecha_inicial');
            $cc = Input::get('cc');
            $fechafinal = Input::get('md_fecha_final');
            $centrodecosto = Input::get('md_centrodecosto');
            $subcentrodecosto = Input::get('md_subcentrodecosto');
            $id_reporte = Input::get('id_reporte');
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
                  Excel::create('Novedades De Rutas', function($excel) use ($cc, $id_reporte, $centrodecosto, $subcentrodecosto, $fecha, $fechafinal, $centrodecostoid){

                      $excel->sheet('hoja', function($sheet) use ($centrodecosto, $subcentrodecosto, $fecha, $fechafinal, $centrodecostoid, $cc, $id_reporte){

                          $value = DB::table('report')
                          ->where('id',$id_reporte)
                          ->first();

                          $centro = $value->cliente;

                          /*$servicios = DB::table('servicios')
                          ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                          ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                          ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
                          ->where('servicios.fecha_servicio',$fecha)
                          //->where('servicios.hora_servicio', '>=', '20:00')
                          ->where('servicios.centrodecosto_id',$centro)
                          ->where('servicios.ruta',1)
                          ->whereNull('servicios.pendiente_autori_eliminacion')
                          ->orderby('servicios.hora_servicio')
                          ->get();*/

                          if($centro==19){

                            $servicios = DB::table('servicios')
                            ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                            ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                            ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
                            ->where('servicios.fecha_servicio',$value->fecha)
                            //->where('servicios.hora_servicio', '>=', '08:00')
                            ->where('servicios.centrodecosto_id',$centro)
                            ->where('servicios.ruta',1)
                            ->whereNull('servicios.pendiente_autori_eliminacion')
                            ->orderby('servicios.fecha_servicio')
                            ->get();

                            $servicios2 = null;

                          }else if($centro==489){

                            $servicios = DB::table('servicios')
                              ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                              ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                              ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
                              ->where('servicios.fecha_servicio',$value->fecha)
                              //->where('servicios.hora_servicio', '>=', '08:00')
                              ->where('servicios.centrodecosto_id',$centro)
                              ->where('servicios.ruta',1)
                              ->whereNull('servicios.pendiente_autori_eliminacion')
                              ->orderby('servicios.fecha_servicio')
                              ->get();

                              $servicios2 = null;

                          }else{

                            $diasiguiente = strtotime ('+1 day', strtotime($value->fecha_fin));
                            $diasiguiente = date('Y-m-d' , $diasiguiente);

                            if(Sentry::getUser()->subcentrodecosto_id!=null) {

                              $servicios = DB::table('servicios')
                              ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                              ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                              ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
                              ->where('servicios.fecha_servicio',$value->fecha)
                              //->where('servicios.hora_servicio', '>=', '08:00')
                              ->where('servicios.centrodecosto_id',$centro)
                              ->where('servicios.subcentrodecosto_id',853)
                              ->where('servicios.ruta',1)
                              ->whereNull('servicios.pendiente_autori_eliminacion')
                              ->orderby('servicios.fecha_servicio')
                              ->get();

                            }else{

                              $servicios = DB::table('servicios')
                              ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                              ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                              ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
                              ->where('servicios.fecha_servicio',$value->fecha)
                              //->where('servicios.hora_servicio', '>=', '08:00')
                              ->where('servicios.centrodecosto_id',$centro)
                              ->where('servicios.ruta',1)
                              ->whereNull('servicios.pendiente_autori_eliminacion')
                              ->orderby('servicios.fecha_servicio')
                              ->get();

                            }

                            /*$servicios2 = DB::table('servicios')
                            ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                            ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                            ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
                            ->where('servicios.fecha_servicio',$diasiguiente)
                            ->where('servicios.hora_servicio', '<=', '08:00')
                            ->where('servicios.centrodecosto_id',$centro)
                            ->where('servicios.ruta',1)
                            ->whereNull('servicios.pendiente_autori_eliminacion')
                            ->orderby('servicios.hora_servicio')
                            ->get();*/

                            $servicios2 = null;

                          }

                          /*$value = DB::table('report')
                          ->where('id',$id_reporte)
                          ->first();*/

                          if ($value->cantidad==0){

                            $arrayIP = [];
                            array_push($arrayIP, [
                              'IP' => Methods::getRealIpAddr(),
                              'TIME' => date('Y-m-d H:i:s')
                            ]);
                            $jsonIP = json_encode($arrayIP);

                          }else{

                            $arrayIP = json_decode($value->jsonIP);
                            array_push($arrayIP, [
                              'IP' => Methods::getRealIpAddr(),
                              'TIME' => date('Y-m-d H:i:s')
                            ]);

                            $jsonIP = json_encode($arrayIP);
                          }

                          $updateReport = DB::table('report')
                          ->where('id',$id_reporte)
                          ->update([
                            'descargado' => 1,
                            'cantidad' => intval($value->cantidad)+1,
                            'jsonIP' => $jsonIP
                          ]);

                          $sheet->loadView('servicios.plantilla_novedades')
                            ->with([
                                'servicios'=>$servicios,
                                'servicios2' => $servicios2
                            ]);


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

    public function postExportarlistadonovedadesfecha(){

      if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

            $centrodecostoid = Input::get('centro');
            //$fecha = Input::get('md_fecha_inicial');
            $cc = Input::get('cc');
            $fecha = Input::get('fecha');
            $fechafinal = Input::get('md_fecha_final');
            $centrodecosto = Input::get('md_centrodecosto');
            $subcentrodecosto = Input::get('md_subcentrodecosto');
            $id_reporte = Input::get('id_reporte');
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
                  Excel::create('Novedades Del '.$fecha, function($excel) use ($cc, $id_reporte, $centrodecosto, $subcentrodecosto, $fecha, $fechafinal, $centrodecostoid){

                      $excel->sheet('hoja', function($sheet) use ($centrodecosto, $subcentrodecosto, $fecha, $fechafinal, $centrodecostoid, $cc, $id_reporte){

                          $localidad = DB::table('centrosdecosto')
                          ->where('id',$cc)
                          ->pluck('localidad');

                          if($cc==19){

                            $servicios = DB::table('servicios')
                            ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                            ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                            ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
                            ->where('servicios.fecha_servicio',$fecha)
                            //->whereBetween('servicios.fecha_servicio',['20240116','20240131'])
                            //->where('servicios.hora_servicio', '>=', '08:00')
                            ->where('servicios.centrodecosto_id',$cc)
                            ->where('servicios.ruta',1)
                            ->whereNull('servicios.pendiente_autori_eliminacion')
                            ->orderby('servicios.fecha_servicio')
                            ->orderby('servicios.hora_servicio')
                            ->get();

                            $servicios2 = null;

                          }else{

                            $diasiguiente = strtotime ('+1 day', strtotime($fecha));
                            $diasiguiente = date('Y-m-d' , $diasiguiente);

                            $servicios = DB::table('servicios')
                            ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                            ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                            ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
                            ->where('servicios.fecha_servicio',$fecha)
                            //->where('servicios.hora_servicio', '>=', '08:00')
                            //->whereBetween('servicios.fecha_servicio',['20240116','20240131'])
                            ->where('servicios.centrodecosto_id',$cc)
                            ->where('servicios.ruta',1)
                            ->whereNull('servicios.pendiente_autori_eliminacion')
                            ->orderby('servicios.fecha_servicio')
                            ->orderby('servicios.hora_servicio')
                            ->get();

                          }

                          $sheet->loadView('servicios.plantilla_novedades2')
                          ->with([
                              'servicios'=>$servicios,
                              'servicios2' => $servicios2
                          ]);

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

    //NUEVO EXPORTAR NOVEDADES DESDE PORTALUSU/EXPORTARDATOS
    public function postExportarnovporfechas(){

      if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

        $cc = Input::get('cc');
        $fecha = Input::get('fecha');
        $fechafinal = Input::get('md_fecha_final');
        $centrodecosto = Input::get('md_centrodecosto');
        $subcentrodecosto = Input::get('md_subcentrodecosto');

        if ($centrodecosto==='-' or $subcentrodecosto==='-') {

          return Redirect::to('transportes');

        }else{

            ob_end_clean();
            ob_start();

            if($cc==19){
              $city = 'BAQ';
            }else{
              $city = 'BOG';
            }

            Excel::create('Novedades_'.$city.'_'.$fecha.' al '.$fechafinal, function($excel) use ($cc, $centrodecosto, $subcentrodecosto, $fecha, $fechafinal){

                $excel->sheet('hoja', function($sheet) use ($centrodecosto, $subcentrodecosto, $fecha, $fechafinal, $cc){

                    $servicios = DB::table('servicios')
                    ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                    ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                    ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
                    ->whereBetween('servicios.fecha_servicio',[$fecha,$fechafinal])
                    ->where('servicios.centrodecosto_id',$cc)
                    ->where('servicios.ruta',1)
                    ->whereNull('servicios.pendiente_autori_eliminacion')
                    ->orderby('servicios.fecha_servicio')
                    ->orderby('servicios.hora_servicio')
                    ->get();

                    $sheet->loadView('servicios.plantilla_novedades2')
                    ->with([
                      'servicios'=>$servicios,
                      'servicios2' => null
                    ]);

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
    //END NUEVO PORTALUSU/EXPORTARDATOS

    public function postFiltrarmes() {

      if (!Sentry::check()){

        return Response::json([
          'respuesta' => 'sesion_caducada'
        ]);

      }else{

        $cc = Sentry::getUser()->centrodecosto_id;

        $ciudad = Input::get('ciudad');
        $sedes = Input::get('sedes');
        $ano = Input::get('ano');
        $mes = Input::get('mes');

        $fecha = $ano.'-'.$mes.'-01';
        $fechaFinal = $ano.'-'.$mes.'-31';

        if($ciudad=='Barranquilla') {
          $center = 19;
        }else{
          $center = 287;
        }
        
        if(Sentry::getUser()->subcentrodecosto_id!=null) {

          $reportes = DB::table('report')
          ->select('report.id', 'report.fecha', 'report.fecha_fin', 'report.fecha_created', 'report.ciudad', 'report.descargado', 'report.created_at', 'users.first_name', 'users.last_name')
          ->leftJoin('users', 'users.id', '=', 'report.creado_por')
          ->whereBetween('fecha',[$fecha,$fechaFinal])
          ->where('report.cliente',288)
          ->where('report.sub',853)
          ->orderBy('fecha', 'desc')
          ->get();
          
        }else{

          $reportes = DB::table('report')
          ->select('report.id', 'report.fecha', 'report.fecha_fin', 'report.fecha_created', 'report.ciudad', 'report.descargado', 'report.created_at', 'users.first_name', 'users.last_name')
          ->leftJoin('users', 'users.id', '=', 'report.creado_por')
          ->whereBetween('fecha',[$fecha,$fechaFinal])
          ->where('report.cliente',$center)
          ->orderBy('fecha', 'desc')
          ->get();

        }

        if(count($reportes)) {

          return Response::json([
            'respuesta' => true,
            'cc' => $center,
            'ciudad' => $ciudad,
            'sedes' => $sedes,
            'ano' => $ano,
            'mes' => $mes,
            'fecha' => $fecha,
            'fechaFinal' => $fechaFinal,
            'reportes' => $reportes
          ]);

        }else{

          return Response::json([
            'respuesta' => false
          ]);

        }

      }

    }

    public function postFiltrarmeses() {

      if (!Sentry::check()){

        return Response::json([
          'respuesta' => 'sesion_caducada'
        ]);

      }else{

        $cc = Sentry::getUser()->centrodecosto_id;

        $ciudad = Input::get('ciudad');
        $sedes = Input::get('sedes');
        $ano = Input::get('ano');
        $mes = Input::get('mes');

        $fecha = $ano.'-'.$mes.'-01';
        $fechaFinal = $ano.'-'.$mes.'-31';

        if($ciudad=='Barranquilla') {
          $center = 19;
        }else{
          $center = 287;
        }

        $query = "SELECT dash.*, users.first_name, users.last_name FROM dash left join users on users.id = dash.creado_por where dash.id is not null";

        if($ciudad!='Seleccionar'){
          $query .=" and cliente = ".$center."";
        }

        if($mes!='0'){
          $query .=" and mes = '".strtoupper($mes)."'";
        }

        if($ano!='0'){
          $query .=" and ano = ".$ano."";
        }

        $consulta = DB::select($query);


        if(count($consulta)) {

          return Response::json([
            'respuesta' => true,
            'cc' => $center,
            'ciudad' => $ciudad,
            'sedes' => $sedes,
            'ano' => $ano,
            'mes' => $mes,
            'fecha' => $fecha,
            'fechaFinal' => $fechaFinal,
            'reportes' => $consulta
          ]);

        }else{

          return Response::json([
            'respuesta' => false,
            'query' => $query,
            'ciudad' => $ciudad
          ]);

        }

      }

    }

    public function postDescargarselect() {

      $fechas = Input::get('fecha');

      $fechass = Input::get('fechas');

      $count = count($fechass);

      if(Sentry::getUser()->centrodecosto_id==489){
        $cc = 489;
      }else if(Input::get('ciudad')=='Bogotá'){
        $cc = 287;
      }else{
        $cc = 19;
      }

      $objArray = [];

      //$query = "select * from report ";
      $dats = '';
      for($index=$count-1;$index >= 0;$index--) {
        array_push($objArray, $fechass[$index]);
        //$objArray = $fechass[$index];
        $fec = $fechass[$index];
        $coma = '';
        if($index!=0){
          $coma = ',';
        }
        $dats .= "'".$fec."'".$coma;
      }
      //$query .= "where fecha in(".$dats.")";

      //$consults = DB::table('report')
      //->whereIn('fecha',$fechas)
      //->get();

      //$consulta = DB::select($query);

      $fechass = explode(",",$fechass);

      ob_end_clean();
      ob_start();
      Excel::create('Novedades', function($excel) use ($cc, $fechas, $fechass, $objArray){

        $excel->sheet('hoja', function($sheet) use ($fechas, $cc, $fechass, $objArray){

            $localidad = DB::table('centrosdecosto')
            ->where('id',$cc)
            ->pluck('localidad');

            if($cc==19){

              $servicios = DB::table('servicios')
              ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
              ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
              ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
              //->where('servicios.fecha_servicio',$fecha)
              ->whereIn('servicios.fecha_servicio',$fechass)
              //->where('servicios.hora_servicio', '>=', '08:00')
              ->where('servicios.centrodecosto_id',$cc)
              ->where('servicios.ruta',1)
              ->whereNull('servicios.pendiente_autori_eliminacion')
              ->orderby('servicios.fecha_servicio')
              ->orderby('servicios.hora_servicio')
              ->get();

              $servicios2 = null;

            }else if($cc==489){

              $servicios = DB::table('servicios')
                ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
                ->whereIn('servicios.fecha_servicio',$fechass)
                ->where('servicios.centrodecosto_id',$cc)
                ->where('servicios.ruta',1)
                ->whereNull('servicios.pendiente_autori_eliminacion')
                ->orderby('servicios.fecha_servicio')
                ->orderby('servicios.hora_servicio')
                ->get();

                $servicios2 = null;

            }else{

              if(Sentry::getUser()->subcentrodecosto_id!=null) {

                $servicios = DB::table('servicios')
                ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
                ->whereIn('servicios.fecha_servicio',$fechass)
                ->where('servicios.centrodecosto_id',$cc)
                ->where('servicios.subcentrodecosto_id',853)
                ->where('servicios.ruta',1)
                ->whereNull('servicios.pendiente_autori_eliminacion')
                ->orderby('servicios.fecha_servicio')
                ->orderby('servicios.hora_servicio')
                ->get();

              }else{

                $servicios = DB::table('servicios')
                ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
                ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                ->select('servicios.*', 'subcentrosdecosto.nombresubcentro', 'vehiculos.clase', 'vehiculos.capacidad', 'vehiculos.placa')
                ->whereIn('servicios.fecha_servicio',$fechass)
                ->where('servicios.centrodecosto_id',$cc)
                ->where('servicios.ruta',1)
                ->whereNull('servicios.pendiente_autori_eliminacion')
                ->orderby('servicios.fecha_servicio')
                ->orderby('servicios.hora_servicio')
                ->get();

              }

              $servicios2 = null;

            }

            $sheet->loadView('servicios.plantilla_novedades')
            ->with([
                'servicios'=>$servicios,
                'servicios2' => $servicios2
            ]);

            $objDrawing = new PHPExcel_Worksheet_Drawing;
            $objDrawing->setPath('biblioteca_imagenes/logos.png');
            $objDrawing->setCoordinates('B2');
            $objDrawing->setResizeProportional(false);
            $objDrawing->setWidth(120);
            $objDrawing->setHeight(30);
            $objDrawing->setWorksheet($sheet);

        });
        
      })->download('xls');

      //estados

      /*return Response::json([
        'respuesta' => true,
        'fechas' => $fechas,
        'count' => $count,
        'fec' => $fec,
        'query' => $query,
        'consulta' => $consulta,
        'consults' => $consults,
        'city' => Input::get('')
      ]);*/

    }

    //FIN ADMINISTRADOR

}

//controlador del portal de usuarios!!!
