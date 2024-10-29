<?php

use Illuminate\Database\Eloquent\Model;

Class SiigoController extends BaseController{

  //const KEY_SIIGO = "OWE1OGNkY2QtZGY4ZC00Nzg1LThlZGYtNmExMzUzMmE4Yzc1Omt2YS4yJTUyQEU="; //Pruebas
  const KEY_SIIGO = "OGM0NDViNGQtMzIzNC00ZTdmLTllMjEtZmRjN2Y2ODFlYjRjOmY2ZDZyZTQvKUQ="; //Producción

  //const TOKEN_SIIGO = "eyJhbGciOiJSUzI1NiIsImtpZCI6IkQ3OTkxNEU2MTJFRkI4NjE5RDNFQ0U4REFGQTU0RDFBMDdCQjM5QjJSUzI1NiIsInR5cCI6ImF0K2p3dCIsIng1dCI6IjE1a1U1aEx2dUdHZFBzNk5yNlZOR2dlN09iSSJ9.eyJuYmYiOjE2ODUxNTkwMzMsImV4cCI6MTY4NTI0NTQzMywiaXNzIjoiaHR0cDovL21zLXNlY3VyaXR5c2VydmljZTo1MDAwIiwiYXVkIjoiaHR0cDovL21zLXNlY3VyaXR5c2VydmljZTo1MDAwL3Jlc291cmNlcyIsImNsaWVudF9pZCI6IlNpaWdvQVBJIiwic3ViIjoiMTAxODMxNSIsImF1dGhfdGltZSI6MTY4NTE1OTAzMywiaWRwIjoibG9jYWwiLCJuYW1lIjoic2lpZ29hcGlAcHJ1ZWJhcy5jb20iLCJtYWlsX3NpaWdvIjoic2lpZ29hcGlAcHJ1ZWJhcy5jb20iLCJjbG91ZF90ZW5hbnRfY29tcGFueV9rZXkiOiJTaWlnb0FQSSIsInVzZXJzX2lkIjoiNjI5IiwidGVuYW50X2lkIjoiMHgwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDM5MjIwMSIsInVzZXJfbGljZW5zZV90eXBlIjoiMCIsInBsYW5fdHlwZSI6IjE0IiwidGVuYW50X3N0YXRlIjoiMSIsIm11bHRpdGVuYW50X2lkIjoiNDA4IiwiY29tcGFuaWVzIjoiMCIsImFwaV9zdWJzY3JpcHRpb25fa2V5IjoiNTYyZTNhMTViMTQ4NDg2ZDkyMTYxYjdhZmNiODdmM2MiLCJhY2NvdW50YW50IjoiZmFsc2UiLCJqdGkiOiI1MDMwMDJGNzU1QzU2QUVFRDg1OEExRjNFMzEwNTVBQyIsImlhdCI6MTY4NTE1OTAzMywic2NvcGUiOlsiU2lpZ29BUEkiXSwiYW1yIjpbImN1c3RvbSJdfQ.YPf2FrWoRPXi79AQMH_S6WwE7zDtNxwNBzf2ewhDWlu6uDvpY8zjMc2hxUFNuDMNIjPc7QbDGfJ54EHnz7rQQLjuG8ucFgkDflrQVeBMzGFTe0Bwgd6uzVYtuAzzS6Wvsf-NC0yVuAVtYCNj5pSL_32LQHRiYd08fAi16xcuwf9GtH_AuLNGJS9CtCHRnfFbRHaK7E7-lZPq0AOek53E4zhv7HAkoc_IavgKd7nCc40_tBWu6FU90JUhxkqToxCk8Vcb4_P9nyF9najoc6kpnxhif2e4V7oSCEWYZCDIg7WESk-0JN70FZgiN3OJ9-Iwmu_659NFzIw-r3Qh5708KA"; //Pruebas

  const TOKEN_SIIGO = "eyJhbGciOiJSUzI1NiIsImtpZCI6IkYyRDQ2NTgyMUY1QjE2QTU3QkZENDQ3NUVBNzgwRTk1MzlGMTFEOThSUzI1NiIsInR5cCI6ImF0K2p3dCIsIng1dCI6Ijh0UmxnaDliRnFWN19VUjE2bmdPbFRueEhaZyJ9.eyJuYmYiOjE2OTA0NjUxNTksImV4cCI6MTY5MDU1MTU1OSwiaXNzIjoiaHR0cDovL21zLXNlY3VyaXR5c2VydmljZTo1MDAwIiwiYXVkIjoiaHR0cDovL21zLXNlY3VyaXR5c2VydmljZTo1MDAwL3Jlc291cmNlcyIsImNsaWVudF9pZCI6IlNpaWdvQVBJIiwic3ViIjoiNjE2NjgwIiwiYXV0aF90aW1lIjoxNjkwNDY1MTU5LCJpZHAiOiJsb2NhbCIsIm5hbWUiOiJjb250YWJpbGlkYWRAYW90b3VyLmNvbS5jbyIsIm1haWxfc2lpZ28iOiJjb250YWJpbGlkYWRAYW90b3VyLmNvbS5jbyIsImNsb3VkX3RlbmFudF9jb21wYW55X2tleSI6IkFVVE9PQ0FTSU9OQUxUT1VSU0FTIiwidXNlcnNfaWQiOiIxMDA1IiwidGVuYW50X2lkIjoiMHgwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDIxNDQwOCIsInVzZXJfbGljZW5zZV90eXBlIjoiMCIsInBsYW5fdHlwZSI6IjE0IiwidGVuYW50X3N0YXRlIjoiMSIsIm11bHRpdGVuYW50X2lkIjoiMTU2IiwiY29tcGFuaWVzIjoiMCIsImFwaV9zdWJzY3JpcHRpb25fa2V5IjoiM2Q3MTgwOTQzMDllNDQ0Njk3ZDcxYmIxMTNiMWQ5OTUiLCJhY2NvdW50YW50IjoiZmFsc2UiLCJqdGkiOiI1MERFMzg5MTgzRThGRkY5OEQ0QkI3OEU1MTc1QzdGQiIsImlhdCI6MTY5MDQ2NTE1OSwic2NvcGUiOlsiU2lpZ29BUEkiXSwiYW1yIjpbImN1c3RvbSJdfQ.M2qFYil3aeE8fkFLOol1blIakh7835CiEhJNtUPshGpCjbWwEoMQH5zE8SUxAsA_YKp_EFVVu1el8N79jq6jVpPq-IOYAqAZIM373Uk5O8JrFHOfkIuKoXAEP7dtYNNja3WJwbDCDu7M-8vNm-npVsAFsSiI6TQLqfZDZRhFQ7WVfp5TpZtyhrTeGvD9GRHtHrZ_hbFvLYsgLMx395EOOMiLgirnstV-2hTnAioTxbWPmlkRi8a8-r4BH48O8Z_TWsDy9KNsjjg2NmYY-IRZ_aFg_n7e_w2ZHM5DPSF0v_Qt86ikiSW3JhOzqh_uB8wljQg-koNf5bY_aleLLjpREQ"; //Producción

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
      //return View::make('emails.preparado', [

      //NUEVOOOOOO
      $users = DB::table('empleados')
      ->where('estado',1)
      ->get();

      $actividades = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.asignado_por')
      //->rightJoin('empleados', 'empleados.id', '=', 'actividades.responsable')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('responsable',Sentry::getUser()->id_empleado)
      //->orwhere('asignado_por',Sentry::getUser()->id_empleado)
      ->where('fecha',date('Y-m-d'))
      ->get();

      $consult = "SELECT actividades.*, empleados.nombres, empleados.apellidos FROM actividades left join empleados on empleados.id = actividades.responsable WHERE fecha = '".date('Y-m-d')."' and FIND_IN_SET('".Sentry::getUser()->id_empleado."', implicados) > 0 ";

      $shared = DB::select($consult);

      //test
      $detalles = DB::table('cotizaciones_detalle')
      ->where('id_cotizaciones',1623)
      ->get();

      $query = "SELECT qr_rutas.*, servicios.fecha_servicio, servicios.hora_servicio FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.pendiente_autori_eliminacion IS NULL AND servicios.fecha_servicio = '20231119' and servicios.localidad is null and servicios.ruta is not null order by qr_rutas.id_usuario asc";

      $users = DB::select($query);

      $sw = 0;
      $anterior = '';
      $servicioAnterior = '';
      $arrayUsers = [];
      $arrayServicios = [];

      foreach ($users as $user) {

        if($anterior==$user->id_usuario){
          $sw = 1;
          array_push($arrayUsers,$user->id_usuario);
          $data = [
            'uno' => $servicioAnterior,
            'dos' => $user->servicio_id
          ];
          array_push($arrayServicios,$data);

        }

        $anterior = $user->id_usuario;
        $servicioAnterior = $user->servicio_id;

      }

      $centrosdecosto = DB::table('centrosdecosto')
      ->whereIn('id',[19,287])
      ->get();

      //return View::make('emails.usuarios_dobles', [ 
      //return View::make('emails.servicio_calificar', [ 
      return View::make('siigo.index', [
      //return View::make('siigo.vehiculos', [ 
        'documentos' => $query,
        'permisos' =>$permisos,
        'o' => $o,
        'users' => $users,
        'actividades' => $actividades,
        'shared' => $shared,
        'cantidad' => 5,
        'telefono' => 3013869946,
        'email' => 'sdgm2207@gmail.com',
        'consecutivo' => 1623,
        'asunto' => 'prueba',
        'nombre_completo' => 'Samu',
        'fecha' => '13 de junio del 2023',
        'total' => 19000278,
        'detalles' => $detalles,
        'idArray' => $arrayUsers,
        'arrayServicios' => $arrayServicios,
        'centrosdecosto' => $centrosdecosto
      ]);

    }
  }

  public function getRecordar(){

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
      //return View::make('emails.preparado', [

      //NUEVOOOOOO
      $users = DB::table('empleados')
      ->where('estado',1)
      ->get();

      $actividades = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.asignado_por')
      //->rightJoin('empleados', 'empleados.id', '=', 'actividades.responsable')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('responsable',Sentry::getUser()->id_empleado)
      //->orwhere('asignado_por',Sentry::getUser()->id_empleado)
      ->where('fecha',date('Y-m-d'))
      ->get();

      $consult = "SELECT actividades.*, empleados.nombres, empleados.apellidos FROM actividades left join empleados on empleados.id = actividades.responsable WHERE fecha = '".date('Y-m-d')."' and FIND_IN_SET('".Sentry::getUser()->id_empleado."', implicados) > 0 ";

      $shared = DB::select($consult);

      //test
      $detalles = DB::table('cotizaciones_detalle')
      ->where('id_cotizaciones',1623)
      ->get();

      //return View::make('emails.mail', [ 
      return View::make('emails.recordar', [ 
      //return View::make('escolar.validaciones.pdf_contrato', [
      //return View::make('siigo.vehiculos', [ 
        'documentos' => $query,
        'permisos' =>$permisos,
        'o' => $o,
        'users' => $users,
        'actividades' => $actividades,
        'shared' => $shared,
        'cantidad' => 5,
        'telefono' => 3013869946,
        'email' => 'sdgm2207@gmail.com',
        'consecutivo' => 1623,
        'asunto' => 'prueba',
        'nombre_completo' => 'Samu',
        'fecha' => '13 de junio del 2023',
        'total' => 19000278,
        'detalles' => $detalles
      ]);

    }
  }

  public function getPlantilla(){

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
      //return View::make('emails.preparado', [

      //NUEVOOOOOO
      $users = DB::table('empleados')
      ->where('estado',1)
      ->get();

      $actividades = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.asignado_por')
      //->rightJoin('empleados', 'empleados.id', '=', 'actividades.responsable')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('responsable',Sentry::getUser()->id_empleado)
      //->orwhere('asignado_por',Sentry::getUser()->id_empleado)
      ->where('fecha',date('Y-m-d'))
      ->get();

      $consult = "SELECT actividades.*, empleados.nombres, empleados.apellidos FROM actividades left join empleados on empleados.id = actividades.responsable WHERE fecha = '".date('Y-m-d')."' and FIND_IN_SET('".Sentry::getUser()->id_empleado."', implicados) > 0 ";

      $shared = DB::select($consult);

      //test
      $detalles = DB::table('cotizaciones_detalle')
      ->where('id_cotizaciones',1623)
      ->get();

      $servicio = DB::table('servicios')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->select('servicios.*', 'conductores.nombre_completo', 'conductores.celular', 'vehiculos.placa', 'vehiculos.clase', 'vehiculos.modelo', 'vehiculos.marca')
      ->whereIn('servicios.id',[611616,638109])
      ->get();

      /*$conductor = DB::table('conductores')
      ->where('id',$servicio->conductor_id)
      ->first();

      $vehiculo = DB::table('vehiculos')
      ->where('id',$servicio->vehiculo_id)
      ->first();*/

      //return View::make('emails.mail', [ 
      //return View::make('emails.mail_v2', [ 
      //return View::make('emails.nuevo_servicio', [
      return View::make('servicios.plantilla_cotizaciones_test', [
        'servicios' => $servicio,
        'documentos' => $query,
        'permisos' =>$permisos,
        'o' => $o,
        'users' => $users,
        'actividades' => $actividades,
        'shared' => $shared,
        'cantidad' => 5,
        'telefono' => 3013869946,
        'email' => 'sdgm2207@gmail.com',
        'consecutivo' => 1623,
        'asunto' => 'prueba',
        'nombre_completo' => 'Samu',
        'fecha' => '13 de junio del 2023',
        'total' => 19000278,
        'detalles' => $detalles,
        'soporte' => 'soporte',
        'contacto' => 'contacto'
      ]);

    }
  }

  public function getBienvenida(){

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
      //return View::make('emails.preparado', [

      //NUEVOOOOOO
      $users = DB::table('empleados')
      ->where('estado',1)
      ->get();

      $actividades = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.asignado_por')
      //->rightJoin('empleados', 'empleados.id', '=', 'actividades.responsable')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('responsable',Sentry::getUser()->id_empleado)
      //->orwhere('asignado_por',Sentry::getUser()->id_empleado)
      ->where('fecha',date('Y-m-d'))
      ->get();

      $consult = "SELECT actividades.*, empleados.nombres, empleados.apellidos FROM actividades left join empleados on empleados.id = actividades.responsable WHERE fecha = '".date('Y-m-d')."' and FIND_IN_SET('".Sentry::getUser()->id_empleado."', implicados) > 0 ";

      $shared = DB::select($consult);

      //test
      $detalles = DB::table('cotizaciones_detalle')
      ->where('id_cotizaciones',1623)
      ->get();

      //return View::make('emails.mail_v2', [ 
      return View::make('cotizaciones.negociacion_exitosa', [ 
      //return View::make('escolar.validaciones.pdf_contrato', [
      //return View::make('siigo.vehiculos', [ 
        'documentos' => $query,
        'permisos' =>$permisos,
        'o' => $o,
        'users' => $users,
        'actividades' => $actividades,
        'shared' => $shared,
        'cantidad' => 5,
        'telefono' => 3013869946,
        'email' => 'sdgm2207@gmail.com',
        'consecutivo' => 1623,
        'asunto' => 'prueba',
        'nombre_completo' => 'Samu',
        'fecha' => '13 de junio del 2023',
        'total' => 19000278,
        'detalles' => $detalles
      ]);

    }
  }

  public function getAprobada(){

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
      //return View::make('emails.preparado', [

      //NUEVOOOOOO
      $users = DB::table('empleados')
      ->where('estado',1)
      ->get();

      $actividades = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.asignado_por')
      //->rightJoin('empleados', 'empleados.id', '=', 'actividades.responsable')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('responsable',Sentry::getUser()->id_empleado)
      //->orwhere('asignado_por',Sentry::getUser()->id_empleado)
      ->where('fecha',date('Y-m-d'))
      ->get();

      $consult = "SELECT actividades.*, empleados.nombres, empleados.apellidos FROM actividades left join empleados on empleados.id = actividades.responsable WHERE fecha = '".date('Y-m-d')."' and FIND_IN_SET('".Sentry::getUser()->id_empleado."', implicados) > 0 ";

      $shared = DB::select($consult);

      //test
      $detalles = DB::table('cotizaciones_detalle')
      ->where('id_cotizaciones',1623)
      ->get();

      //return View::make('emails.mail_v2', [ 
      return View::make('cotizaciones.cotizacion_aprobada', [ 
      //return View::make('escolar.validaciones.pdf_contrato', [
      //return View::make('siigo.vehiculos', [ 
        'documentos' => $query,
        'permisos' =>$permisos,
        'o' => $o,
        'users' => $users,
        'actividades' => $actividades,
        'shared' => $shared,
        'cantidad' => 5,
        'telefono' => 3013869946,
        'email' => 'sdgm2207@gmail.com',
        'consecutivo' => 1623,
        'asunto' => 'prueba',
        'nombre_completo' => 'Samu',
        'fecha' => '13 de junio del 2023',
        'total' => 19000278,
        'detalles' => $detalles
      ]);

    }
  }

  public function getRechazada(){

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
      //return View::make('emails.preparado', [

      //NUEVOOOOOO
      $users = DB::table('empleados')
      ->where('estado',1)
      ->get();

      $actividades = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.asignado_por')
      //->rightJoin('empleados', 'empleados.id', '=', 'actividades.responsable')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('responsable',Sentry::getUser()->id_empleado)
      //->orwhere('asignado_por',Sentry::getUser()->id_empleado)
      ->where('fecha',date('Y-m-d'))
      ->get();

      $consult = "SELECT actividades.*, empleados.nombres, empleados.apellidos FROM actividades left join empleados on empleados.id = actividades.responsable WHERE fecha = '".date('Y-m-d')."' and FIND_IN_SET('".Sentry::getUser()->id_empleado."', implicados) > 0 ";

      $shared = DB::select($consult);

      //test
      $detalles = DB::table('cotizaciones_detalle')
      ->where('id_cotizaciones',1623)
      ->get();

      //return View::make('emails.mail_v2', [ 
      return View::make('cotizaciones.cotizacion_rechazada', [ 
      //return View::make('escolar.validaciones.pdf_contrato', [
      //return View::make('siigo.vehiculos', [ 
        'documentos' => $query,
        'permisos' =>$permisos,
        'o' => $o,
        'users' => $users,
        'actividades' => $actividades,
        'shared' => $shared,
        'cantidad' => 5,
        'telefono' => 3013869946,
        'email' => 'sdgm2207@gmail.com',
        'consecutivo' => 1623,
        'asunto' => 'prueba',
        'nombre_completo' => 'Samu',
        'fecha' => '13 de junio del 2023',
        'total' => 19000278,
        'detalles' => $detalles
      ]);

    }
  }

  public function getPorta(){

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
      //return View::make('emails.preparado', [

      //NUEVOOOOOO
      $users = DB::table('empleados')
      ->where('estado',1)
      ->get();

      $actividades = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.asignado_por')
      //->rightJoin('empleados', 'empleados.id', '=', 'actividades.responsable')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('responsable',Sentry::getUser()->id_empleado)
      //->orwhere('asignado_por',Sentry::getUser()->id_empleado)
      ->where('fecha',date('Y-m-d'))
      ->get();

      $consult = "SELECT actividades.*, empleados.nombres, empleados.apellidos FROM actividades left join empleados on empleados.id = actividades.responsable WHERE fecha = '".date('Y-m-d')."' and FIND_IN_SET('".Sentry::getUser()->id_empleado."', implicados) > 0 ";

      $shared = DB::select($consult);

      //test
      $detalles = DB::table('cotizaciones_detalle')
      ->where('id_cotizaciones',1623)
      ->get();

      //return View::make('emails.mail_v2', [ 
      return View::make('cotizaciones.portafolio', [ 
      //return View::make('escolar.validaciones.pdf_contrato', [
      //return View::make('siigo.vehiculos', [ 
        'documentos' => $query,
        'permisos' =>$permisos,
        'o' => $o,
        'users' => $users,
        'actividades' => $actividades,
        'shared' => $shared,
        'cantidad' => 5,
        'telefono' => 3013869946,
        'email' => 'sdgm2207@gmail.com',
        'consecutivo' => 1623,
        'asunto' => 'prueba',
        'nombre_completo' => 'Samu',
        'fecha' => '13 de junio del 2023',
        'total' => 19000278,
        'detalles' => $detalles
      ]);

    }
  }

  public function getSendpqr(){

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

      //NUEVOOOOOO
      $users = DB::table('empleados')
      ->where('estado',1)
      ->get();

      $actividades = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.asignado_por')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('responsable',Sentry::getUser()->id_empleado)
      ->where('fecha',date('Y-m-d'))
      ->get();

      $consult = "SELECT actividades.*, empleados.nombres, empleados.apellidos FROM actividades left join empleados on empleados.id = actividades.responsable WHERE fecha = '".date('Y-m-d')."' and FIND_IN_SET('".Sentry::getUser()->id_empleado."', implicados) > 0 ";

      $shared = DB::select($consult);

      $detalles = DB::table('cotizaciones_detalle')
      ->where('id_cotizaciones',1623)
      ->get();

      return View::make('cotizaciones.send_pqr', [
        'documentos' => $query,
        'permisos' =>$permisos,
        'o' => $o,
        'users' => $users,
        'actividades' => $actividades,
        'shared' => $shared,
        'cantidad' => 5,
        'telefono' => 3013869946,
        'email' => 'sdgm2207@gmail.com',
        'consecutivo' => 1623,
        'asunto' => 'prueba',
        'nombre_completo' => 'Samu',
        'fecha' => '13 de junio del 2023',
        'total' => 19000278,
        'detalles' => $detalles
      ]);

    }
  }

  public function getClosepqr(){

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

      //NUEVOOOOOO
      $users = DB::table('empleados')
      ->where('estado',1)
      ->get();

      $actividades = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.asignado_por')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('responsable',Sentry::getUser()->id_empleado)
      ->where('fecha',date('Y-m-d'))
      ->get();

      $consult = "SELECT actividades.*, empleados.nombres, empleados.apellidos FROM actividades left join empleados on empleados.id = actividades.responsable WHERE fecha = '".date('Y-m-d')."' and FIND_IN_SET('".Sentry::getUser()->id_empleado."', implicados) > 0 ";

      $shared = DB::select($consult);

      $detalles = DB::table('cotizaciones_detalle')
      ->where('id_cotizaciones',1623)
      ->get();

      return View::make('cotizaciones.close_pqr', [
        'documentos' => $query,
        'permisos' =>$permisos,
        'o' => $o,
        'users' => $users,
        'actividades' => $actividades,
        'shared' => $shared,
        'cantidad' => 5,
        'telefono' => 3013869946,
        'email' => 'sdgm2207@gmail.com',
        'consecutivo' => 1623,
        'asunto' => 'prueba',
        'nombre_completo' => 'Samu',
        'fecha' => '13 de junio del 2023',
        'total' => 19000278,
        'detalles' => $detalles
      ]);

    }
  }

  public function postArchivos() {

    $archivos = Input::file('archivos');
    $ubicacion = 'biblioteca_imagenes/archivos_cotizaciones/';
    $sw = 0;
    $insertedId = 1621;

    $arraynombres = [];
    if (Input::hasFile('archivos')) {
      $sw = 1;
      foreach ($archivos as $key => $value) {
        $nombre_imagen = $value->getClientOriginalName();
        if(file_exists($ubicacion.$nombre_imagen)){
          $nombre_imagen = rand(1,10000).$nombre_imagen;
        }
        $arrayVehiculo = [
          'archivos' => $nombre_imagen, 'c1' => Input::get('c1v1'), 'c2' => Input::get('c2v1'), 'c3' => Input::get('c3v1')
        ];
        $cotizacion = Cotizacion::find($insertedId);
        if($cotizacion->archivos1 == null){
          $cotizacion->archivos1 = json_encode([$arrayVehiculo]);
        }else{
          $objArray = json_decode($cotizacion->archivos1);
          array_push($objArray, $arrayVehiculo);
          $cotizacion->archivos1 = json_encode($objArray);
        }
        array_push($arraynombres, $arrayVehiculo);
        $value->move($ubicacion, $nombre_imagen);
        $cotizacion->save();
      }
    }else{
      $archivosf = null;
    }

    //Vehiculo 2
    $arraynombres2 = [];
    $archivos2 = Input::file('archivos2');

    if (Input::hasFile('archivos2')) {
      $sw = 1;
      foreach ($archivos2 as $key => $value) {
        $nombre_imagen = $value->getClientOriginalName();
        if(file_exists($ubicacion.$nombre_imagen)){
          $nombre_imagen = rand(1,10000).$nombre_imagen;
        }
        $arrayVehiculo = [
          'archivos' => $nombre_imagen, 'c1' => Input::get('c1v2'), 'c2' => Input::get('c2v2'), 'c3' => Input::get('c3v2')
        ];
        $cotizacion = Cotizacion::find($insertedId);
        if($cotizacion->archivos2 == null){
          $cotizacion->archivos2 = json_encode([$arrayVehiculo]);
        }else{
          $objArray = json_decode($cotizacion->archivos2);
          array_push($objArray, $arrayVehiculo);
          $cotizacion->archivos2 = json_encode($objArray);
        }
        array_push($arraynombres2, $arrayVehiculo);
        $value->move($ubicacion, $nombre_imagen);
        $cotizacion->save();
      }
    }else{
      $archivosf = null;
    }

    //Vehiculo 3
    $arraynombres3 = [];
    $archivos3 = Input::file('archivos3');

    if (Input::hasFile('archivos3')) {
      $sw = 1;
      foreach ($archivos3 as $key => $value) {
        $nombre_imagen = $value->getClientOriginalName();
        if(file_exists($ubicacion.$nombre_imagen)){
          $nombre_imagen = rand(1,10000).$nombre_imagen;
        }
        $arrayVehiculo = [
          'archivos' => $nombre_imagen, 'c1' => Input::get('c1v3'), 'c2' => Input::get('c2v3'), 'c3' => Input::get('c3v3')
        ];
        $cotizacion = Cotizacion::find($insertedId);
        if($cotizacion->archivos3 == null){
          $cotizacion->archivos3 = json_encode([$arrayVehiculo]);
        }else{
          $objArray = json_decode($cotizacion->archivos3);
          array_push($objArray, $arrayVehiculo);
          $cotizacion->archivos3 = json_encode($objArray);
        }
        array_push($arraynombres3, $arrayVehiculo);
        $value->move($ubicacion, $nombre_imagen);
        $cotizacion->save();
      }
    }else{
      $archivosf = null;
    }

    //Vehiculo 4
    $arraynombres4 = [];
    $archivos4 = Input::file('archivos4');

    if (Input::hasFile('archivos4')) {
      $sw = 1;
      foreach ($archivos4 as $key => $value) {
        $nombre_imagen = $value->getClientOriginalName();
        if(file_exists($ubicacion.$nombre_imagen)){
          $nombre_imagen = rand(1,10000).$nombre_imagen;
        }
        $arrayVehiculo = [
          'archivos' => $nombre_imagen, 'c1' => Input::get('c1v4'), 'c2' => Input::get('c2v4'), 'c3' => Input::get('c3v4')
        ];
        $cotizacion = Cotizacion::find($insertedId);
        if($cotizacion->archivos4 == null){
          $cotizacion->archivos4 = json_encode([$arrayVehiculo]);
        }else{
          $objArray = json_decode($cotizacion->archivos4);
          array_push($objArray, $arrayVehiculo);
          $cotizacion->archivos4 = json_encode($objArray);
        }
        array_push($arraynombres4, $arrayVehiculo);
        $value->move($ubicacion, $nombre_imagen);
        $cotizacion->save();
      }
    }else{
      $archivosf = null;
    }

    //Vehiculo 5
    $arraynombres5 = [];
    $archivos5 = Input::file('archivos5');

    if (Input::hasFile('archivos5')) {
      $sw = 1;
      foreach ($archivos5 as $key => $value) {
        $nombre_imagen = $value->getClientOriginalName();
        if(file_exists($ubicacion.$nombre_imagen)){
          $nombre_imagen = rand(1,10000).$nombre_imagen;
        }
        $arrayVehiculo = [
          'archivos' => $nombre_imagen, 'c1' => Input::get('c1v5'), 'c2' => Input::get('c2v5'), 'c3' => Input::get('c3v5')
        ];
        $cotizacion = Cotizacion::find($insertedId);
        if($cotizacion->archivos5 == null){
          $cotizacion->archivos5 = json_encode([$arrayVehiculo]);
        }else{
          $objArray = json_decode($cotizacion->archivos5);
          array_push($objArray, $arrayVehiculo);
          $cotizacion->archivos5 = json_encode($objArray);
        }
        array_push($arraynombres5, $arrayVehiculo);
        $value->move($ubicacion, $nombre_imagen);
        $cotizacion->save();
      }
    }else{
      $archivosf = null;
    }

    return Response::json([
      'mensaje' => true,
      'sw' => $sw
    ]);

  }

  public function getEmail(){

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


      return View::make('siigo.mail', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmailzoom(){

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


      return View::make('siigo.email_zoom', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmailingreso(){

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


      return View::make('siigo.prov.email_ingreso', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmailrevision(){

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


      return View::make('siigo.prov.email_revision', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmaildocumentosparaactualizar(){

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


      return View::make('siigo.prov.email_documentos_rechazados', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmailcapacitar(){

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


      return View::make('siigo.prov.email_capacitar', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmaildocumentosaprobados(){

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


      return View::make('siigo.prov.email_documentos_aprobados', [
        //'documentos' => $query,
        'link' => 1,
        'estado' => 'APROBADA',
        'texto2' => 'Se ha <b>Aprobado</b> la documentación del conductor <b>SAMUEL GONZÁLEZ.</b>',
        'texto' => 'Algunos documentos del conductor <b>SAMUEL GONZÁLEZ</b> fueron <b>Rechazados!</b>',
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmaildocumentosactualizados(){

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


      return View::make('siigo.prov.email_documentos_actualizados', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmailbienvenido(){

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


      return View::make('siigo.prov.email_bienvenido', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmailaviso(){

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


      return View::make('siigo.prov.email_aviso', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmailpqr(){

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


      return View::make('siigo.prov.email_pqr', [
        'titulo' => 'NUEVA PQR',
        'texto' => 'Se ha generado una nueva PQR',
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmailenviararchivos(){

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


      return View::make('siigo.prov.email_enviar_archivos', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmailtest(){

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


      return View::make('siigo.email_test', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmaileconomy(){

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


      return View::make('siigo.email_economy', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmail2(){

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


      return View::make('siigo.email_acept', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }


  public function getEmail3(){

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


      return View::make('siigo.email_rechaz', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmail4(){

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


      return View::make('siigo.email_port', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmail5(){

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


      return View::make('siigo.email_welco', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmail6(){

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


      return View::make('siigo.email_test_e', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getEmail7(){

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


      return View::make('siigo.pqr', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getAdjuntos(){

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


      return View::make('tareas.emails.adjuntos', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getComentario(){

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


      return View::make('tareas.emails.comentarios', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function getParticipante(){

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


      return View::make('tareas.emails.participante', [
        //'documentos' => $query,
        'permisos' =>$permisos
      ]);

    }
  }

  public function postSharetask(){

    $id = Input::get('id');
    $users = Input::get('users');

    $actividad = Actividad::find($id);

    $datas = '';

    for ($i=0; $i<count($users) ; $i++) {

        /*if($cantidad==0){

          $datas = null;

        }else */if(count($users)>1){

          if($i==count($users)-1){
            $coma = '';
          }else{
            $coma = ',';
          }

          $datas .= $users[$i].$coma;

        }else{

          $datas = $users[$i];

        }

      }

      $actividad->implicados = $datas;

      if($actividad->save()){
        return Response::json([
          'response' => true
        ]);
      }
  }

  //Tipos de Comprobante
  public function postTiposdecomprobante(){

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-76611b81f4-siigoapi.apiary-proxy.com/v1/document-types?type=FV");
    //curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/document-types?type=NC");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    $date = date('Y-m-d');

    $sietedias = strtotime ('+7 day', strtotime($date));
    $fechaMasSieteDias = date('Y-m-d' , $sietedias);

    $sele = DB::table('seguridad_social')
    ->where('conductor_id',1301)
    ->orderBy('id', 'DESC')
    ->first();

    if( $sele->fecha_final<=$fechaMasSieteDias and $sele->fecha_final>=$date ){
      $enviar = 'SS vence en unos días';
    }

    //var_dump($response);

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response),
      'sele' => $sele,
      'enviar' => $enviar
    ]);

  }

  //Tipos de Comprobante 2
  public function postTiposdecomprobante2(){

    $ch = curl_init();

    //curl_setopt($ch, CURLOPT_URL, "https://private-anon-a5e9bc99c3-siigoapi.apiary-proxy.com/v1/journals/");
    curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/journals/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response)
    ]);

  }

  //Consultar cliente
  public function postConsultarcliente(){

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-a5e9bc99c3-siigoapi.apiary-proxy.com/v1/customers/{89decf33-0525-4d08-af04-28405aab6c96}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response)
    ]);

  }

  //Listar clientes
  public function postListarclientes(){

    $ch = curl_init();

    //curl_setopt($ch, CURLOPT_URL, "https://private-anon-a5e9bc99c3-siigoapi.apiary-proxy.com/v1/customers?created_start=&page=2&page_size=25");

    curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/customers?created_start=&page=4&page_size=100");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response)
    ]);

  }

  //Formas de pago
  public function postFormasdepago(){

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-76611b81f4-siigoapi.apiary-proxy.com/v1/payment-types?document_type=FV");
    //curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/payment-types?document_type=FV");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response)
    ]);

  }

  //Impuestos
  public function postImpuestos(){

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-76611b81f4-siigoapi.apiary-proxy.com/v1/taxes");

    //curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/taxes");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    //GI
    /*$ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/account-groups");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);*/

    //CC
    /*$ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/products?created_start=");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);*/

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response)
    ]);

  }

  //Vendedor
  public function postVendedor(){

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-76611b81f4-siigoapi.apiary-proxy.com/v1/users");

    //curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/users?created_start=&page=2&page_size=25");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response)
    ]);

  }

  public function postAuth(){

    $ch = curl_init();

    //curl_setopt($ch, CURLOPT_URL, "https://private-anon-0fcb762271-siigoapi.apiary-proxy.com/auth");
    curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/auth");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    //curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      //\"username\": \"siigoapi@pruebas.com\",
      //\"access_key\": \"".SiigoController::KEY_SIIGO."\"
    //}");

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"username\": \"contabilidad@aotour.com.co\",
      \"access_key\": \"".SiigoController::KEY_SIIGO."\"
    }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    //var_dump($response);

    return Response::json([
      'respuesta' => true,
      'response' => $response
    ]);

  }

  /*public function postConsultarcliente() {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-aa0e36b2df-siigoapi.apiary-proxy.com/v1/customers?created_start=");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: eyJhbGciOiJSUzI1NiIsImtpZCI6IkQ3OTkxNEU2MTJFRkI4NjE5RDNFQ0U4REFGQTU0RDFBMDdCQjM5QjJSUzI1NiIsInR5cCI6ImF0K2p3dCIsIng1dCI6IjE1a1U1aEx2dUdHZFBzNk5yNlZOR2dlN09iSSJ9.eyJuYmYiOjE2Njc3OTIxOTQsImV4cCI6MTY2Nzg3ODU5NCwiaXNzIjoiaHR0cDovL21zLXNlY3VyaXR5c2VydmljZTo1MDAwIiwiYXVkIjoiaHR0cDovL21zLXNlY3VyaXR5c2VydmljZTo1MDAwL3Jlc291cmNlcyIsImNsaWVudF9pZCI6IlNpaWdvQVBJIiwic3ViIjoiMTAxODMxNSIsImF1dGhfdGltZSI6MTY2Nzc5MjE5NCwiaWRwIjoibG9jYWwiLCJuYW1lIjoic2lpZ29hcGlAcHJ1ZWJhcy5jb20iLCJtYWlsX3NpaWdvIjoic2lpZ29hcGlAcHJ1ZWJhcy5jb20iLCJjbG91ZF90ZW5hbnRfY29tcGFueV9rZXkiOiJTaWlnb0FQSSIsInVzZXJzX2lkIjoiNjI5IiwidGVuYW50X2lkIjoiMHgwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDM5MjIwMSIsInVzZXJfbGljZW5zZV90eXBlIjoiMCIsInBsYW5fdHlwZSI6IjE0IiwidGVuYW50X3N0YXRlIjoiMSIsIm11bHRpdGVuYW50X2lkIjoiNDA4IiwiY29tcGFuaWVzIjoiMCIsImFwaV9zdWJzY3JpcHRpb25fa2V5IjoiNTYyZTNhMTViMTQ4NDg2ZDkyMTYxYjdhZmNiODdmM2MiLCJhY2NvdW50YW50IjoiZmFsc2UiLCJqdGkiOiI1OUZDQjdCMjI4OEFFNzFBRkY0MjJDMzlCRDNDQUEyMyIsImlhdCI6MTY2Nzc5MjE5NCwic2NvcGUiOlsiU2lpZ29BUEkiXSwiYW1yIjpbImN1c3RvbSJdfQ.M5KTLB9GVEkYfy8GUcwa0S79Ae3Y4TZk56kee098dV1iNYNcIyCtIPH-59eTyJMsNeU00JdzvsWChirXdo60ebvCBLirYJunAQMilKmVJcDjmZa1dx-_KTczcjqJ8J88NfdN6a8rjb2-bz6yhjsAS_Zzjkzmb3PQYzbvc6k310CWgO1DYk3nHmBCD5bgTE526zUXw_UX6z2fnazyEtlYBuEzied2hHQIYidmtKGC7RFnlyPk6n1vRYAdWOzmYBcI6JX1AMpNxbHJ9CN_ecEHkuR4m8ZTIPpUoGLm_3wTU-k8p-uSKVwSg8qz0nSEvPj7rIctPciab_pygL7EmVTjCw"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    var_dump($response);

  }*/

  public function postNotac() {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-76611b81f4-siigoapi.apiary-proxy.com/v1/credit-notes");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"document\": {
        \"id\": 28392
      },
      \"number\": 1,
      \"date\": \"2023-03-31\",
      \"invoice\": \"5a750b68-00bf-401f-9a55-3972535ed532\",
      \"reason\": \"1\",
      
      \"observations\": \"Observaciones\",
      \"items\": [
        {
          \"code\": \"Item-1\",
          \"description\": \"Servicio de Transporte AOTOUR\",
          \"quantity\": 1,
          \"price\": 100000,
          \"discount\": 0,
        }
      ],
      \"payments\": [
        {
          \"id\": 8709,
          \"value\": 100000,
          \"due_date\": \"2023-03-31\"
        }
      ]
    }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response),
      //'id' => $response->id,
    ]);

  }

  public function postCrearfactura() {

   /* curl_setopt($ch, CURLOPT_POSTFIELDS, "{
        \"document\": {
          \"id\": 28347
        },
        \"date\": \"2023-03-31\",
        \"customer\": {
          \"identification\": \"104302799\",
          \"branch_office\": 0
        },
        \"retentions\": [{\"id\": ".$reteICA."}],
        \"seller\": 629,
        \"observations\": \"".$observa."\",
        \"items\": [
          {
            \"code\": \"Item-1\",
            \"description\": \"".strtoupper(Input::get('observaciones'))."\",
            \"quantity\": 1,
            \"price\": ".$valor.",
            ".$retef."
          }
        ],
        \"payments\": [
          {
            \"id\": ".Input::get('forma_pago').",
            \"value\": ".round($totalfactura, 2).",
            \"due_date\": \"".$treintadias."\"
          }
        ],

        }");
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: Bearer ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);*/

    /*Guardar en Siigo*/

    /*$identificacion = "1043027888"; //Número de identificación del cliente

    $ciudad = 'BARRANQUILLA';

    $cliente = DB::table('centrosdecosto')
    ->where('id',469)
    ->pluck('razonsocial');

    $descripcion = "".$cliente." \n\n SERVICIO DE OPERACION Y LOGISTICA DE TRANSPORTE PRESTADOS EN LA CIUDAD DE ".$ciudad." DEL DIA 05 AL 06 DE DICIEMBRE DEL 2022"; //Descrición de la factura

    $val = 1986000; //Valor bruto de la factura

    if($ciudad==='BARRANQUILLA'){
      $procentaje = 7;
    }else{
      $procentaje = 7;
    }

    $valor = 1000000;
    $ica = $valor*$procentaje/1000;
    $retefuente = $valor*0.035;

    $totalfactura = $valor-$ica-$retefuente;

    $fecha = date('Y-m-d');

    $treintadias = strtotime ('+30 day', strtotime($fecha));
    $treintadias = date('Y-m-d' , $treintadias);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-aa0e36b2df-siigoapi.apiary-proxy.com/v1/invoices");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"document\": {
        \"id\": 28688
      },
      \"date\": \"2022-12-18\",
      \"customer\": {
        \"identification\": \"".$identificacion."\",
        \"branch_office\": 0
      },
      \"retentions\": [
        {
          \"id\": 13167
        }
      ],
      \"seller\": 629,
      \"observations\": \"Observaciones\",
      \"items\": [
        {
          \"code\": \"Item-1\",
          \"description\": \"".$descripcion."\",
          \"quantity\": 1,
          \"price\": ".$valor.",
          \"taxes\": [
            {
              \"id\": 13173
            }
          ]
        }
      ],
      \"payments\": [
        {
          \"id\": 8709,
          \"value\": ".$totalfactura.",
          \"due_date\": \"".$treintadias."\"
        }
      ],

    }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: Bearer ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);*/
    /*Guardar en Siigo*/

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response),
      //'id' => $response->id,
    ]);

    /*$ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-aa0e36b2df-siigoapi.apiary-proxy.com/v1/invoices");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"document\": {
        \"id\": 24446
      },
      \"date\": \"2022-12-13\",
      \"customer\": {
        \"identification\": \"13832081\",
        \"branch_office\": 0
      },
      \"cost_center\": 235,
      \"currency\": {
        \"code\": \"CLP\",
        \"exchange_rate\": 0.00021
      },
      \"seller\": 629,
      \"observations\": \"Observaciones\",
      \"items\": [
        {
          \"code\": \"Item-1\",
          \"description\": \"Servicio de Transporte AOTOUR - Prueba Samuel\",
          \"quantity\": 1,
          \"price\": 1069.77,
          \"discount\": 0,
          \"taxes\": [
            {
              \"id\": 13156
            }
          ]
        }
      ],
      \"payments\": [
        {
          \"id\": 5636,
          \"value\": 1273.03,
          \"due_date\": \"2021-03-19\"
        }
      ],
      \"additional_fields\": {}
    }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6IkQ3OTkxNEU2MTJFRkI4NjE5RDNFQ0U4REFGQTU0RDFBMDdCQjM5QjJSUzI1NiIsInR5cCI6ImF0K2p3dCIsIng1dCI6IjE1a1U1aEx2dUdHZFBzNk5yNlZOR2dlN09iSSJ9.eyJuYmYiOjE2NzA4NjQ4NTUsImV4cCI6MTY3MDk1MTI1NSwiaXNzIjoiaHR0cDovL21zLXNlY3VyaXR5c2VydmljZTo1MDAwIiwiYXVkIjoiaHR0cDovL21zLXNlY3VyaXR5c2VydmljZTo1MDAwL3Jlc291cmNlcyIsImNsaWVudF9pZCI6IlNpaWdvQVBJIiwic3ViIjoiMTAxODMxNSIsImF1dGhfdGltZSI6MTY3MDg2NDg1NSwiaWRwIjoibG9jYWwiLCJuYW1lIjoic2lpZ29hcGlAcHJ1ZWJhcy5jb20iLCJtYWlsX3NpaWdvIjoic2lpZ29hcGlAcHJ1ZWJhcy5jb20iLCJjbG91ZF90ZW5hbnRfY29tcGFueV9rZXkiOiJTaWlnb0FQSSIsInVzZXJzX2lkIjoiNjI5IiwidGVuYW50X2lkIjoiMHgwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDM5MjIwMSIsInVzZXJfbGljZW5zZV90eXBlIjoiMCIsInBsYW5fdHlwZSI6IjE0IiwidGVuYW50X3N0YXRlIjoiMSIsIm11bHRpdGVuYW50X2lkIjoiNDA4IiwiY29tcGFuaWVzIjoiMCIsImFwaV9zdWJzY3JpcHRpb25fa2V5IjoiNTYyZTNhMTViMTQ4NDg2ZDkyMTYxYjdhZmNiODdmM2MiLCJhY2NvdW50YW50IjoiZmFsc2UiLCJqdGkiOiI4NjkwRDZENjBENzM2MTM3QTNCQTFGMkQwMjk1NUYwMSIsImlhdCI6MTY3MDg2NDg1NSwic2NvcGUiOlsiU2lpZ29BUEkiXSwiYW1yIjpbImN1c3RvbSJdfQ.aHyS5yNPGpxBZgwCjZHZdN3bpsYUTcOb-wSgECixd2JA39BDQd-Xlrusn0npZL4jaS7Oz8lNcKK3wGcpVSXMZ46eDRdMest3LvifKNSPS64nYJ3PM38UXGIOu-34LAdzwjOLNT10sD27XyhnLtuDcKL1nSYdBJenTW7ocOBSBDc7-s6lzf4iQ9aCHfq8DT_d7r9U1VmCydPbBAPPSDz0sXb6BncecZTbhhEA7rcxXOmWy6gN3xqG0wymEpaCFlRI2-iW-X3gs8uX54knIx-Jj4coN9-wlfOQbNUjz1gqHnyj2_GX7Q5vpZsJBxVfdPzmqQ5bkfo2QUN0jRVL48R4Gg"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    //var_dump($response);

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response),
      //'id' => $response->id,
    ]);*/

  }

  public function postCrearrecibo() {

    $valor = 1;
    $identificacion = 1;
    $consecutivo = 1;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-a5e9bc99c3-siigoapi.apiary-proxy.com/v1/vouchers");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"document\": {
        \"id\": 28550
      },
      \"date\": \"2022-12-15\",
      \"type\": \"DebtPayment\",
      \"customer\": {
        \"identification\": \"104302799\",
        \"branch_office\": 0
      },
      \"items\": [
        {
          \"due\": {
            \"prefix\": \"FV-44\",
            \"consecutive\": 14936,
            \"quote\": 1,
            \"date\": \"2022-12-15\"
          },
          \"value\": 345000
        }
      ],
      \"payment\": {
        \"id\": 5636,
        \"value\": 345000
      },
      \"observations\": \"Observaciones\"
    }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response)
    ]);

  }

  public function postCrearfacturadian() {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-42d6253761-siigoapi.apiary-proxy.com/v1/invoices");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"document\": {
        \"id\": 24446
      },
      \"date\": \"2022-12-19\",
      \"customer\": {
        \"person_type\": \"Person\",
        \"id_type\": \"13\",
        \"identification\": \"13832081\",
        \"branch_office\": 0,
        \"name\": [
          \"Manuel\",
          \"Camacho\"
        ],
        \"address\": {
          \"address\": \"Cra. 18 #79A - 42\",
          \"city\": {
            \"country_code\": \"Co\",
            \"country_name\": \"Colombia\",
            \"state_code\": \"19\",
            \"state_name\": \"Cauca\",
            \"city_code\": \"19001\",
            \"city_name\": \"Popayán\"
          },
          \"postal_code\": \"110911\"
        },
        \"phones\": [
          {
            \"indicative\": \"57\",
            \"number\": \"3006003345\",
            \"extension\": \"132\"
          }
        ],
        \"contacts\": [
          {
            \"first_name\": \"Marcos\",
            \"last_name\": \"Castillo\",
            \"email\": \"marcos.castillo@contacto.com\",
          }
        ]
      },
      \"cost_center\": 235,
      \"currency\": {
        \"code\": \"USD\",
        \"exchange_rate\": 3825.03
      },
      \"seller\": 629,
      \"stamp\": {
        \"send\": true
      },
      \"mail\": {
        \"send\": true
      },
      \"observations\": \"Observaciones\",
      \"items\": [
        {
          \"code\": \"Item-1\",
          \"description\": \"Camiseta de algodón\",
          \"quantity\": 1,
          \"price\": 1069.77,
          \"discount\": 0,
          \"taxes\": [
            {
              \"id\": 13156
            }
          ]
        }
      ],
      \"payments\": [
        {
          \"id\": 5636,
          \"value\": 1273.03,
          \"due_date\": \"2021-03-19\"
        }
      ],
      \"additional_fields\": {}
    }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response)
    ]);

  }

  public function postConsultarfactura() {

    $token = DB::table('siigo')->where('id',1)->pluck('token');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/invoices/{1e61a7eb-349f-4ee2-9cdf-faa51ebb5db1}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Authorization: ".$token."",
      "Partner-Id: AUTONET"
    ));
    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'response' => $response
    ]);

    $query = "SELECT * FROM ordenes_facturacion WHERE ingreso IS NULL AND anulado IS NULL AND id_siigo IS NOT NULL order by id desc";
    $consulta = DB::select($query);
    $cont = 0;
    foreach ($consulta as $factura) {
      
      $id = $factura->id_siigo;

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/invoices/{".$id."}");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);

      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: ".SiigoController::TOKEN_SIIGO.""
      ));

      $response = curl_exec($ch);
      curl_close($ch);

      $update = DB::table('ordenes_facturacion')
      ->where('id',$factura->id)
      ->update([
        'fecha_vencimiento' => json_decode($response)->payments[0]->due_date
      ]);

      $cont++;

    }

    

  }

  public function postConsultarfacturapdf() {

    //$b64 = "";

    //$bin = base64_decode($b64, true);

    //$filepath = "biblioteca_imagenes/\qr_codes/pruebassss.pdf";

    //file_put_contents($filepath, $bin);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-d1b53a010a-siigoapi.apiary-proxy.com/v1/invoices/{9c157102-8c39-4d55-92f8-d3b8b38adf39}/pdf");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response)
    ]);

  }

  public function postConsultarrecibo() {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://private-anon-a5e9bc99c3-siigoapi.apiary-proxy.com/v1/vouchers/86343a28-fb72-49f8-88af-5c7f565e440f");
    //curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/vouchers/id");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response)
    ]);

  }

  public function postMail() {

    /*$ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-152bcbf7d4-siigoapi.apiary-proxy.com/v1/invoices/c5372290-ea13-4f09-b86f-6aeeb1f86701/mail");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"mail_to\": \"sistemas@aotour.com.co\",
      \"copy_to\": \"aotourdeveloper@gmail.com\"
    }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);*/

    //ENVÍO DE CORREO AL CLIENTE CON EL PORTAFOLIO
    $data = [
      'consecutivo' => 1
    ];

    //$email = 'aotourdeveloper@gmail.com';
    $email = 'sistemas@aotour.com.co';

    Mail::send('emails.mail', $data, function($message) use ($email){
      $message->from('no-reply@aotour.com.co', 'Plantilla Email');
      $message->to($email)->subject('Prueba de plantilla');
      $message->cc('aotourdeveloper@gmail.com');
    });

    /*$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"messaging_product\": \"whatsapp\",
      \"to\": \"".$number."\",
      \"type\": \"template\",
      \"template\": {
        \"name\": \"service_prog\",
        \"language\": {
          \"code\": \"es\",
        },
        \"components\": [{
          \"type\": \"body\",
          \"parameters\": [{
            \"type\": \"text\",
            \"text\": \"".$nombre."\",
          },
          {
            \"type\": \"text\",
            \"text\": \"".$fecha."\",
          },
          {
            \"type\": \"text\",
            \"text\": \"".$hora."\",
          },
          {
            \"type\": \"text\",
            \"text\": \"".$origen."\",
          },
          {
            \"type\": \"text\",
            \"text\": \"".$cliente."\",
          }]
        },
        {
          \"type\": \"button\",
          \"sub_type\": \"url\",
          \"index\": \"0\",
          \"parameters\": [{
            \"type\": \"payload\",
            \"payload\": \"".$servicio->id."\"
          }]
        }]
      }
    }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);*/

    return Response::json([
      'respuesta' => true
    ]);

  }

  public function postConsultarfacturas() { //Consultar todas las facturas

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-aa0e36b2df-siigoapi.apiary-proxy.com/v1/invoices?created_start=");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: eyJhbGciOiJSUzI1NiIsImtpZCI6IkQ3OTkxNEU2MTJFRkI4NjE5RDNFQ0U4REFGQTU0RDFBMDdCQjM5QjJSUzI1NiIsInR5cCI6ImF0K2p3dCIsIng1dCI6IjE1a1U1aEx2dUdHZFBzNk5yNlZOR2dlN09iSSJ9.eyJuYmYiOjE2Njc3OTIxOTQsImV4cCI6MTY2Nzg3ODU5NCwiaXNzIjoiaHR0cDovL21zLXNlY3VyaXR5c2VydmljZTo1MDAwIiwiYXVkIjoiaHR0cDovL21zLXNlY3VyaXR5c2VydmljZTo1MDAwL3Jlc291cmNlcyIsImNsaWVudF9pZCI6IlNpaWdvQVBJIiwic3ViIjoiMTAxODMxNSIsImF1dGhfdGltZSI6MTY2Nzc5MjE5NCwiaWRwIjoibG9jYWwiLCJuYW1lIjoic2lpZ29hcGlAcHJ1ZWJhcy5jb20iLCJtYWlsX3NpaWdvIjoic2lpZ29hcGlAcHJ1ZWJhcy5jb20iLCJjbG91ZF90ZW5hbnRfY29tcGFueV9rZXkiOiJTaWlnb0FQSSIsInVzZXJzX2lkIjoiNjI5IiwidGVuYW50X2lkIjoiMHgwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDM5MjIwMSIsInVzZXJfbGljZW5zZV90eXBlIjoiMCIsInBsYW5fdHlwZSI6IjE0IiwidGVuYW50X3N0YXRlIjoiMSIsIm11bHRpdGVuYW50X2lkIjoiNDA4IiwiY29tcGFuaWVzIjoiMCIsImFwaV9zdWJzY3JpcHRpb25fa2V5IjoiNTYyZTNhMTViMTQ4NDg2ZDkyMTYxYjdhZmNiODdmM2MiLCJhY2NvdW50YW50IjoiZmFsc2UiLCJqdGkiOiI1OUZDQjdCMjI4OEFFNzFBRkY0MjJDMzlCRDNDQUEyMyIsImlhdCI6MTY2Nzc5MjE5NCwic2NvcGUiOlsiU2lpZ29BUEkiXSwiYW1yIjpbImN1c3RvbSJdfQ.M5KTLB9GVEkYfy8GUcwa0S79Ae3Y4TZk56kee098dV1iNYNcIyCtIPH-59eTyJMsNeU00JdzvsWChirXdo60ebvCBLirYJunAQMilKmVJcDjmZa1dx-_KTczcjqJ8J88NfdN6a8rjb2-bz6yhjsAS_Zzjkzmb3PQYzbvc6k310CWgO1DYk3nHmBCD5bgTE526zUXw_UX6z2fnazyEtlYBuEzied2hHQIYidmtKGC7RFnlyPk6n1vRYAdWOzmYBcI6JX1AMpNxbHJ9CN_ecEHkuR4m8ZTIPpUoGLm_3wTU-k8p-uSKVwSg8qz0nSEvPj7rIctPciab_pygL7EmVTjCw"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response)
    ]);

  }

  //PROYECTOS

  public function postAsignartarea(){

    $asignado = Input::get('asignado');
    $nombreTarea = Input::get('nombreTarea');
    $descripcionTarea = Input::get('descripcionTarea');
    $participantesTarea = Input::get('participantesTarea');
    $cantidad = Input::get('cantidad');

    $datas = '';

    for ($i=0; $i<count($participantesTarea) ; $i++) {

      if($cantidad==0){

        $datas = null;

      }else if(count($participantesTarea)>1){

        if($i==count($participantesTarea)-1){
          $coma = '';
        }else{
          $coma = ',';
        }

        $datas .= $participantesTarea[$i].$coma;

      }else{

        $datas = $participantesTarea[$i];

      }

    }

    $actividad = new Actividad;
    $actividad->nombre = $nombreTarea;
    $actividad->descripcion = $descripcionTarea;
    $actividad->implicados = $datas;
    $actividad->responsable = $asignado;
    $actividad->asignado_por = Sentry::getUser()->id_empleado;
    $actividad->fecha = date('Y-m-d');

    if($actividad->save()){

      //Envío de correos
      //if($actividad->asignado_por!=null){ //Enviar correo

        //$correo =  DB::table('correos')
        //->where('usuario')

        $consult = "SELECT * FROM correos WHERE FIND_IN_SET('".Sentry::getUser()->id_empleado."', usuario) > 0 ";

        $shared = DB::select($consult);

      //}
      //Envío de correos

      return Response::json([
        'respuesta' => true,
        'asignado' => $asignado,
        'nombreTarea' => $nombreTarea,
        'descripcionTarea' => $descripcionTarea,
        'participantesTarea' => $participantesTarea,
        'shared' => $shared
      ]);

    }

  }

  public function postAgregaractividad() {

    $nombre = Input::get('nombre');
    $users = Input::get('users');
    $descripcionTarea = Input::get('descripcionTarea');
    $cantidad = Input::get('cantidad');

    $datas = '';

    try {

      for ($i=0; $i<count($users) ; $i++) {

        /*if($cantidad==0){

          $datas = null;

        }else */if(count($users)>1){

          if($i==count($users)-1){
            $coma = '';
          }else{
            $coma = ',';
          }

          $datas .= $users[$i].$coma;

        }else{

          $datas = $users[$i];

        }

      }

    } catch (Exception $e) {

      return Response::json([
        'respuesta' => false,
        'datas' => $datas,
        'cantidad' => count($users)
      ]);

    }

    $actividad = new Actividad;
    $actividad->nombre = $nombre;
    $actividad->implicados = $datas;
    $actividad->responsable = Sentry::getUser()->id_empleado;
    $actividad->descripcion = $descripcionTarea;
    $actividad->fecha = date('Y-m-d');

    if($actividad->save()){

      $usuarioss = explode(",",$actividad->implicados);

      $text = '';

      for ($i=0; $i <count($usuarioss) ; $i++) {

        $consult = "SELECT * FROM correos WHERE FIND_IN_SET('".$usuarioss[$i]."', usuario) > 0 ";

        $shared = DB::select($consult);

        foreach ($shared as $key) {
          $text .= $key->address; //correo del empleado en la iteración

          $data = [
            'motivo' => $motivo,
            'nombre' => $nombre
          ];

          Mail::send('portalproveedores.emails.documento_rechazado', $data, function($message) use ($email){
            $message->from('no-reply@aotour.com.co', 'AUTONET');
            $message->to($email)->subject('Actividades Diarias');
          });

        }

      }

      //Envío de correos

      return Response::json([
        'respuesta' => true,
        'test' => $datas,
        'cantidad' => count($users),
        'shared' => $shared,
        'usuarioss' => $usuarioss,
        'text' => $text
      ]);

    }

  }

  public function postFiltrardia(){

    $fecha = Input::get('fecha');

    //$fecha = $a.$m.$d;

    //$actividades = DB::table('')

    $actividades = DB::table('actividades')
    ->leftJoin('empleados', 'empleados.id', '=', 'actividades.asignado_por')
    ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
    ->where('responsable',Sentry::getUser()->id_empleado)
    ->where('fecha',$fecha)
    ->get();

    $consult = "SELECT actividades.*, empleados.nombres, empleados.apellidos FROM actividades left join empleados on empleados.id = actividades.responsable WHERE fecha = '".$fecha."' and FIND_IN_SET('".Sentry::getUser()->id_empleado."', implicados) > 0 ";

    $shared = DB::select($consult);

    return Response::json([
      'respuesta' => true,
      'fecha' => $fecha,
      'actividades' => $actividades,
      'shared' => $shared
    ]);



  }

  public function getTask($id) {

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $task = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.asignado_por')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('actividades.id',$id)
      ->first();

      return View::make('proyectos.task', [
        'task' => $task,
        'permisos' =>$permisos,
        //'o' => $o,
      ]);

    }

  }

  public function postActivartarea() {

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else{

      $id = Input::get('id');

      $task = Actividad::find($id);

      if($task){

        $task->estado = null;

        $array = null;

        $cambios = $task->comentarios;

        $foto = DB::table('empleados')
        ->where('id',Sentry::getUser()->id_empleado)
        ->pluck('foto');

        $comentario = 'HE REACTIVADO LA TAREA.';

        $array = [
          'usuario' => 2,
          'mensaje' => strtoupper($comentario),
          'valor' => null,
          'time' => date('H:i:s'),
          'date' => date('Y-m-d'),
          'user' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
          'foto' => $foto
        ];

        if($task->comentarios!=null){
            $objArray = json_decode($cambios);
            array_push($objArray, $array);
            $data = json_encode($objArray);
        }else{
            $data = json_encode([$array]);
        }

        $task->comentarios = $data;

        if($task->save()){

          $text = '';

          if($task->implicados!=null){

            $usuarioss = explode(",",$task->implicados);

            $text = '';

            for ($i=0; $i <count($usuarioss) ; $i++) {

              $consult = "SELECT * FROM correos WHERE FIND_IN_SET('".$usuarioss[$i]."', usuario) > 0 ";

              $shared = DB::select($consult);

              foreach ($shared as $key) {

                $text .= $key->address; //correo del empleado en la iteración

                /*$data = [
                  'motivo' => $motivo,
                  'nombre' => $nombre
                ];

                Mail::send('portalproveedores.emails.documento_rechazado', $data, function($message) use ($email){
                  $message->from('no-reply@aotour.com.co', 'AUTONET');
                  $message->to($email)->subject('Actividades Diarias');
                });*/

              }

            }

            //Envío de correos
          }

          return Response::json([
            'response' => true,
            'text' => $text
          ]);

        }
      }

    }

  }

  public function postCerrartarea() {

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else{

      $id = Input::get('id');

      $task = Actividad::find($id);

      if($task){

        $task->estado = 1;

        if($task->save()){

          $text = '';

          if($task->implicados!=null){

            $usuarioss = explode(",",$task->implicados);

            $text = '';

            for ($i=0; $i <count($usuarioss) ; $i++) {

              $consult = "SELECT * FROM correos WHERE FIND_IN_SET('".$usuarioss[$i]."', usuario) > 0 ";

              $shared = DB::select($consult);

              foreach ($shared as $key) {

                $text .= $key->address; //correo del empleado en la iteración

                /*$data = [
                  'motivo' => $motivo,
                  'nombre' => $nombre
                ];

                Mail::send('portalproveedores.emails.documento_rechazado', $data, function($message) use ($email){
                  $message->from('no-reply@aotour.com.co', 'AUTONET');
                  $message->to($email)->subject('Actividades Diarias');
                });*/

              }

            }

            //Envío de correos
          }

          return Response::json([
            'response' => true,
            'text' => $text
          ]);

        }
      }

    }

  }

  public function postAgregarcomentario() {

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else{

      $task = Input::get('task');
      $comentario = Input::get('comentario');

      $tarea = Actividad::find($task);
      $cambios = $tarea->comentarios;

      $array = null;

      $foto = DB::table('empleados')
      ->where('id',Sentry::getUser()->id_empleado)
      ->pluck('foto');

      $array = [
        'usuario' => 2,
        'mensaje' => strtoupper($comentario),
        'valor' => null,
        'time' => date('H:i:s'),
        'date' => date('Y-m-d'),
        'user' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
        'foto' => $foto
      ];

      if($tarea->comentarios!=null){
          $objArray = json_decode($cambios);
          array_push($objArray, $array);
          $data = json_encode($objArray);
      }else{
          $data = json_encode([$array]);
      }

      $tarea->comentarios = $data;

      $text = '';

      if($tarea->implicados!=null){

        $usuarioss = explode(",",$tarea->implicados);

        $text = '';

        for ($i=0; $i <count($usuarioss) ; $i++) {

          $consult = "SELECT * FROM correos WHERE FIND_IN_SET('".$usuarioss[$i]."', usuario) > 0 ";

          $shared = DB::select($consult);

          foreach ($shared as $key) {

            $text .= $key->address; //correo del empleado en la iteración

            /*$data = [
              'motivo' => $motivo,
              'nombre' => $nombre
            ];

            Mail::send('portalproveedores.emails.documento_rechazado', $data, function($message) use ($email){
              $message->from('no-reply@aotour.com.co', 'AUTONET');
              $message->to($email)->subject('Actividades Diarias');
            });*/

          }

        }

        //Envío de correos
      }

      if($tarea->save()){

        $comments = DB::table('actividades')
        ->where('id',$tarea->id)
        ->pluck('comentarios');

        return Response::json([
          'response' => true,
          'comentarios' => json_decode($comments)
        ]);

      }


    }

  }

  public function postRoutes() {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://routes.googleapis.com/directions/v2:computeRoutes");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"origin\": {
        \"location\": {
          \"latLng\": {
            \"latitude\": \"37.419734\",
            \"longitude\": \"-122.0827784\",
          }
        }
      },
      \"destination\": {
        \"location\": {
          \"latLng\": {
            \"latitude\": \"37.417670\",
            \"longitude\": \"-122.079595\",
          }
        }
      },
      \"travelMode\": \"DRIVE\",
      \"routingPreference\": \"TRAFFIC_AWARE\",
      \"departureTime\": \"2023-10-15T15:01:23.045123456Z\",
      \"computeAlternativeRoutes\": \"false\",
      \"routeModifiers\": {
        \"avoidTolls\": \"false\",
        \"avoidHighways\": \"false\",
        \"avoidFerries\": \"false\",
      },
      \"languageCode\": \"en-US\",
      \"units\": \"IMPERIAL\"
    }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "X-Goog-Api-Key: AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0",
      "X-Goog-FieldMask: routes.duration,routes.distanceMeters,routes.polyline.encodedPolyline"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'response' => $response
    ]);

  }

  public function postEnviarmail(){

    /*Prueba de Pusher*/
    /*$idpusher = "578229";
    $keypusher = "a8962410987941f477a1";
    $secretpusher = "6a73b30cfd22bc7ac574";

    //CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
    $channel = 'inicio_servicio';
    $name = 'scheduled';
    $id = 633777;

    $nombreConductor = 'SAMUEL GONZÁLEZ';
    $horaServicio = '18:30';
    $nombreCliente = 'EMERGIA';

    $data = json_encode([
      'proceso' => 1,
      'cantidad' => 10,
      'id' => $id,
      'conductor' => $nombreConductor,
      'hora' => $horaServicio,
      'cliente' => $nombreCliente
    ]);

    $app_id = $idpusher;
    $key = $keypusher;
    $secret = $secretpusher;

    $body = [
    'data' => $data,
    'name' => $name,
    'channel' => $channel
    ];

    $auth_timestamp =  strtotime('now');
    //$auth_timestamp = '1534427844';

    $auth_version = '1.0';

    //Body convertido a md5 mediante una funcion
    $body_md5 = md5(json_encode($body));

    $string_to_sign =
    "POST\n/apps/".$app_id.
    "/events\nauth_key=".$key.
    "&auth_timestamp=".$auth_timestamp.
    "&auth_version=".$auth_version.
    "&body_md5=".$body_md5;

    $auth_signature = hash_hmac('SHA256', $string_to_sign, $secret);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api-us2.pusher.com/apps/'.$app_id.'/events?auth_key='.$key.'&body_md5='.$body_md5.'&auth_version=1.0&auth_timestamp='.$auth_timestamp.'&auth_signature='.$auth_signature.'&');

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $headers = [
    'Content-Type: application/json'
    ];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

    $response = curl_exec($ch);*/

    /*Prueba de Pusher*/

    /*$servicio = DB::table('servicios')
    ->where('id',611616)
    ->first();

    $conductor = DB::table('conductores')
    ->where('id',$servicio->conductor_id)
    ->first();

    $vehiculo = DB::table('vehiculos')
    ->where('id',$servicio->vehiculo_id)
    ->first();

    $data = [
      'servicio' => $servicio,
      'conductor' => $conductor,
      'vehiculo' => $vehiculo
    ];

    $email = 'sistemas@aotour.com.co';

    Mail::send('emails.nuevo_servicio', $data, function($message) use ($email){
      $message->from('no-reply@aotour.com.co', 'Servicio Programado');
      $message->to($email)->subject('Tu servicio fue programado...');
      $message->cc('aotourdeveloper@gmail.com');
      //$message->attach($pdfPath);
    });*/

    /*$number = '573013869946';
    $dejarEn = 'SUTHERLAND';

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"messaging_product\": \"whatsapp\",
      \"to\": \"".$number."\",
      \"type\": \"template\",
      \"template\": {
        \"name\": \"recorrido_finalizado\",
        \"language\": {
          \"code\": \"es\",
        },
        \"components\": [{
          \"type\": \"body\",
          \"parameters\": [{
            \"type\": \"text\",
            \"text\": \"".$dejarEn."\",
          }]
        }]
      }
    }");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);*/

    //envío de mensaje de espera al usuario de ruta

    /*$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"messaging_product\": \"whatsapp\",
      \"to\": \"".$number."\",
      \"type\": \"template\",
      \"template\": {
        \"name\": \"calificacion\",
        \"language\": {
          \"code\": \"es\",
        },
        \"components\": [{
          
          \"type\": \"button\",
          \"sub_type\": \"url\",
          \"index\": \"0\",
          \"parameters\": [{
            \"type\": \"payload\",
            \"payload\": \"".$id."\"
          }]
        }]
      }
    }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);*/

    $number = '573013869946';
    $nombre = 'SAMUEL';
    $fecha = '2023-10-21';
    $hora = '07:00';
    $origen = 'REST';
    $destino = 'Caja';
    $placaVehiculo = 'UUW128';
    $id = 654225;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"messaging_product\": \"whatsapp\",
      \"to\": \"".$number."\",
      \"type\": \"template\",
      \"template\": {
        \"name\": \"service_prog\",
        \"language\": {
          \"code\": \"es\",
        },
        \"components\": [{
          \"type\": \"body\",
          \"parameters\": [{
            \"type\": \"text\",
            \"text\": \"".$nombre."\",
          },
          {
            \"type\": \"text\",
            \"text\": \"".$fecha."\",
          },
          {
            \"type\": \"text\",
            \"text\": \"".$hora."\",
          },
          {
            \"type\": \"text\",
            \"text\": \"".$origen."\",
          },
          {
            \"type\": \"text\",
            \"text\": \"".$destino."\",
          },
          {
            \"type\": \"text\",
            \"text\": \"".$placaVehiculo."\",
          }]
        },
        {
          \"type\": \"button\",
          \"sub_type\": \"url\",
          \"index\": \"0\",
          \"parameters\": [{
            \"type\": \"payload\",
            \"payload\": \"".$id."\"
          }]
        },{
          \"type\": \"button\",
          \"sub_type\": \"url\",
          \"index\": \"1\",
          \"parameters\": [{
            \"type\": \"payload\",
            \"payload\": \"".$id."\"
          }]
        }]
      }
    }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return Response::json([
      'mensaje'=>true,
      'response' => $response
    ]);

  }

  /*Finalizar Servicio Pusher*/
  public function postFinalizarservicio(){

    /*Prueba de Pusher*/
    $idpusher = "578229";
    $keypusher = "a8962410987941f477a1";
    $secretpusher = "6a73b30cfd22bc7ac574";

    //CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
    $channel = 'fin_servicio_baq';
    $name = 'ended_baq';
    $id = 633768;

    $nombreConductor = 'SAMUEL GONZÁLEZ';
    $horaServicio = '18:30';
    $nombreCliente = 'EMERGIA';

    $data = json_encode([
      'proceso' => 1,
      'cantidad' => 10,
      'id' => $id,
      'conductor' => $nombreConductor,
      'hora' => $horaServicio,
      'cliente' => $nombreCliente
    ]);

    $app_id = $idpusher;
    $key = $keypusher;
    $secret = $secretpusher;

    $body = [
    'data' => $data,
    'name' => $name,
    'channel' => $channel
    ];

    $auth_timestamp =  strtotime('now');
    //$auth_timestamp = '1534427844';

    $auth_version = '1.0';

    //Body convertido a md5 mediante una funcion
    $body_md5 = md5(json_encode($body));

    $string_to_sign =
    "POST\n/apps/".$app_id.
    "/events\nauth_key=".$key.
    "&auth_timestamp=".$auth_timestamp.
    "&auth_version=".$auth_version.
    "&body_md5=".$body_md5;

    $auth_signature = hash_hmac('SHA256', $string_to_sign, $secret);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api-us2.pusher.com/apps/'.$app_id.'/events?auth_key='.$key.'&body_md5='.$body_md5.'&auth_version=1.0&auth_timestamp='.$auth_timestamp.'&auth_signature='.$auth_signature.'&');

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $headers = [
    'Content-Type: application/json'
    ];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

    $response = curl_exec($ch);

    return Response::json([
      'mensaje'=>true,
      'response' => $response
    ]);

  }
  /*Finalizar Servicio Pusher*/

  public function postIngresoimagenv2(){

     if (!Sentry::check()){

         return Response::json([
             'respuesta'=>'relogin'
         ]);

     }else{

         if(Request::ajax()){

             #VALIDACION PARA IMAGENES
             $validaciones = [
                 'foto' => 'mimes:jpeg,bmp,png'
             ];

             #MENSAJE DE VALIDACION
             $mensajes = [
                 'foto.mimes'=>'La imagen debe ser un archivo de tipo imagen (jpg-bmp-png)'
             ];

             #CLASE PARA VALIDAR
             $validador = Validator::make(Input::all(), $validaciones,$mensajes);

             #SI LA VALICION FALLA
             if (1>2){

                 return Response::json([
                     'mensaje'=>false,
                     'errores'=>$validador->errors()->getMessages()
                 ]);

             }else{

                 #BUSCAR LA ORDEN DE FACTURA CON EL ID
                 $actividad = Actividad::find(Input::get('id'));

                 #SI EL INPUT TIENE IMAGEN
                 if (Input::hasFile('file')){

                     #ASIGNAR ARCHIVO A LA VARIABLE
                     $file = Input::file('file');

                     #UBICACION DE LAS IMAGENES DE INGRESO
                     $ubicacion = 'biblioteca_imagenes/actividades/diarias/';

                     #NOMBRE ORIGINAL DEL ARCHIVO
                     $nombre_imagen = $file->getClientOriginalName();

                     #VALOR EN LA BASE DE DATOS PARA LA IMAGEN EXISTENTE O VACIA
                     $imagen_antigua = $actividad->adjuntos;

                     #SI EL CAMPO DE LA IMAGEN ESTA VACIO ENTONCES
                     if ($imagen_antigua===null){

                         if(file_exists($ubicacion.$nombre_imagen)){
                             #SI EL ARCHIVO EXISTE ENTONCES CAMBIELE EL NOMBRE YA QUE EL ARCHIVO EXISTE Y SI EXISTE
                             #CON EL MISMO NOMBRE PUEDE OCURRIR DE QUE SE GUARDE ENCIMA DEL EXISTENTE POR LO TANTO
                             #AL NOMBRE SE LE ASIGNA UN NUMERO ALEATORIO
                             $nombre_imagen = rand(1,100000).$nombre_imagen;
                         }

                         $array = [
                            [
                              'usuario'=> Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
                              'nombre_imagen'=>$nombre_imagen,
                              'fecha'=>date('Y-m-d H:i:s')
                            ]
                         ];

                         $actividad->adjuntos = json_encode($array);

                     #SI EL CAMPO DE LA IMAGEN EXISTE ENTONCES
                     }else if($imagen_antigua!=null){

                         #CONVERTIR EL STRING A JSON
                         $array = json_decode($actividad->adjuntos);

                         #REVISAR SI ES ARRAY
                         if (is_array($array)){

                             if(file_exists($ubicacion.$nombre_imagen)){
                                 #SI EL ARCHIVO EXISTE ENTONCES CAMBIELE EL NOMBRE YA QUE EL ARCHIVO EXISTE Y SI EXISTE
                                 #CON EL MISMO NOMBRE PUEDE OCURRIR DE QUE SE GUARDE ENCIMA DEL EXISTENTE POR LO TANTO
                                 #AL NOMBRE SE LE ASIGNA UN NUMERO ALEATORIO
                                 $nombre_imagen = rand(1,100000).$nombre_imagen;
                             }

                             #CREAR ARRAY PARA ASIGNAR VARIAS IMAGENES
                             $arrayVar = [
                                 'usuario'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
                                 'nombre_imagen'=>$nombre_imagen,
                                 'fecha'=>date('Y-m-d H:i:s')
                             ];

                             array_push($array, $arrayVar);

                             $actividad->adjuntos = json_encode($array);

                         }else{

                             #SI EL CAMPO ESTA VACIO Y SE LE VA A AGREGAR UNA IMAGEN ENTONCES TOMAR EL CAMPO ACTUAL Y INTRODUCIRLO A UN ARRAY
                             $array = [
                                 [
                                     'usuario'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
                                     'nombre_imagen'=>$imagen_antigua,
                                     'fecha'=>date('Y-m-d H:i:s')
                                 ]
                             ];

                             #CREAR UN ARRAY CON LA NUEVA IMAGEN
                             $arrayVar = [
                                 'usuario'=>Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
                                 'nombre_imagen'=>$nombre_imagen,
                                 'fecha'=>date('Y-m-d H:i:s')
                             ];

                             array_push($array, $arrayVar);

                             $actividad->adjuntos = json_encode($array);
                         }
                     }

                     if($actividad->save()){
                         /*if (Input::hasFile('foto')){
                             Image::make($file->getRealPath())->save($ubicacion.$nombre_imagen);
                             File::delete($ubicacion.$imagen_antigua);
                         }*/

                        $text = '';

                        if($actividad->implicados!=null){

                          $usuarioss = explode(",",$actividad->implicados);

                          $text = '';

                          for ($i=0; $i <count($usuarioss) ; $i++) {

                            $consult = "SELECT * FROM correos WHERE FIND_IN_SET('".$usuarioss[$i]."', usuario) > 0 ";

                            $shared = DB::select($consult);

                            foreach ($shared as $key) {

                              $text .= $key->address; //correo del empleado en la iteración

                              /*$data = [
                                'motivo' => $motivo,
                                'nombre' => $nombre
                              ];

                              Mail::send('portalproveedores.emails.documento_rechazado', $data, function($message) use ($email){
                                $message->from('no-reply@aotour.com.co', 'AUTONET');
                                $message->to($email)->subject('Actividades Diarias');
                              });*/

                            }

                          }

                          //Envío de correos
                        }

                         if (Input::hasFile('file')) {
                              $width = Image::make($file->getRealPath())->width();
                              $height = Image::make($file->getRealPath())->height();
                              Image::make($file->getRealPath())->save($ubicacion . $nombre_imagen);
                              File::delete($ubicacion.$imagen_antigua);
                          }

                         return Response::json([
                             //'respuesta'=>true,
                             'nombre_imagen'=>$nombre_imagen
                         ]);
                     }

                 }else {
                     return Response::json([
                         'respuesta'=>false
                     ]);
                 }

             }
         }
     }
  }

  //BAQ
  public function postEnviarrepetidosbaq() {

    $cc = Input::get('cc');
    $fecha = Input::get('fecha');

    $query = "SELECT qr_rutas.*, servicios.fecha_servicio, servicios.hora_servicio FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.pendiente_autori_eliminacion IS NULL AND servicios.fecha_servicio = '".$fecha."' AND servicios.centrodecosto_id = ".$cc." AND servicios.localidad is null AND servicios.ruta is not null order by qr_rutas.id_usuario asc";

    $users = DB::select($query);

    $sw = 0;
    $anterior = '';
    $servicioAnterior = '';
    $arrayUsers = [];
    $arrayServicios = [];

    foreach ($users as $user) {

      if($anterior==$user->id_usuario){
        $sw = 1;
        array_push($arrayUsers,$user->id_usuario);
        $data = [
          'uno' => $servicioAnterior,
          'dos' => $user->servicio_id
        ];
        array_push($arrayServicios,$data);

      }

      $anterior = $user->id_usuario;
      $servicioAnterior = $user->servicio_id;

    }

    if($sw==1){

      $data = [
        'idArray' => $arrayUsers,
        'arrayServicios' => $arrayServicios,
        'fecha' => $fecha
      ];

      //$email = 'jefedetransportebaq@aotour.com.co';
      $email = 'sistemas@aotour.com.co';

      Mail::send('emails.usuarios_dobles', $data, function($message) use ($email, $fecha){
        $message->from('no-reply@aotour.com.co', 'Duplicados - '.$fecha);
        $message->to($email)->subject('Revisión de Rutas');
        $message->bcc(['aotourdeveloper@gmail.com']);
      });

    }

    return Response::json([
      'respuesta' => true,
      'users' => $users,
      'array1' => $arrayUsers,
      'array2' => $arrayServicios,
      'sw' => $sw,
      'query' => $query
    ]);

  }

  //BOG
  public function postEnviarrepetidosbog() {

    $cc = Input::get('cc');
    $fecha = Input::get('fecha');

    $query = "SELECT qr_rutas.*, servicios.fecha_servicio, servicios.hora_servicio FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.fecha_servicio = '".$fecha."' AND servicios.centrodecosto_id = ".$cc." AND servicios.ruta is not null AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.localidad is not null order by qr_rutas.id_usuario asc";

    $users = DB::select($query);

    $sw = 0;
    $anterior = '';
    $servicioAnterior = '';
    $arrayUsers = [];
    $arrayServicios = [];

    foreach ($users as $user) {

      if($anterior==$user->id_usuario){
        $sw = 1;
        array_push($arrayUsers,$user->id_usuario);
        $data = [
          'uno' => $servicioAnterior,
          'dos' => $user->servicio_id
        ];
        array_push($arrayServicios,$data);

      }

      $anterior = $user->id_usuario;
      $servicioAnterior = $user->servicio_id;

    }

    if($sw==1){

      $data = [
        'idArray' => $arrayUsers,
        'arrayServicios' => $arrayServicios,
        'fecha' => $fecha
      ];

      $email = 'jefedetransportebog@aotour.com.co';
      //$email = 'sistemas@aotour.com.co';

      Mail::send('emails.usuarios_dobles', $data, function($message) use ($email, $fecha){
        $message->from('no-reply@aotour.com.co', 'Duplicados - '.$fecha);
        $message->to($email)->subject('Revisión de Rutas');
        $message->bcc(['aotourdeveloper@gmail.com']);
      });

    }

    return Response::json([
      'respuesta' => true,
      'users' => $users,
      'array1' => $arrayUsers,
      'array2' => $arrayServicios,
      'sw' => $sw
    ]);

  }

  public function postConfirmarservicio() {

    /*$users = DB::table('qr_rutas')
    ->leftJoin('servicios', 'servicios.id', '=', 'qr_rutas.servicio_id')
    ->select('qr_rutas.*', 'servicios.fecha_servicio', 'servicios.hora_servicio')
    ->where('qr_rutas.fecha','20231119')
    ->whereNull('servicios.pendiente_autori_eliminacion')
    ->whereNotNull('servicios.localidad')
    ->whereNotNull('servicios.ruta')
    ->orderBy('qr_rutas.id_usuario', 'asc')
    ->get();*/

    $query = "SELECT qr_rutas.*, servicios.fecha_servicio, servicios.hora_servicio FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.pendiente_autori_eliminacion IS NULL AND ( (servicios.fecha_servicio = '20231101' AND servicios.hora_servicio >='19:00' AND servicios.hora_servicio<='23:59') OR (servicios.fecha_servicio = '20231102' AND servicios.hora_servicio <='07:00') ) and servicios.localidad is not null and servicios.ruta is not null order by qr_rutas.id_usuario asc";

    //$query = "SELECT qr_rutas.*, servicios.fecha_servicio, servicios.hora_servicio FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE servicios.pendiente_autori_eliminacion IS NULL AND servicios.fecha_servicio = '20231126' and servicios.centrodecosto_id = 19 and servicios.localidad is null and servicios.ruta is not null order by qr_rutas.id_usuario asc";

    $users = DB::select($query);

    $sw = 0;
    $anterior = '';
    $servicioAnterior = '';
    $arrayUsers = [];
    $arrayServicios = [];

    foreach ($users as $user) {

      if($anterior==$user->id_usuario){
        $sw = 1;
        array_push($arrayUsers,$user->id_usuario);
        $data = [
          'uno' => $servicioAnterior,
          'dos' => $user->servicio_id
        ];
        array_push($arrayServicios,$data);

      }

      $anterior = $user->id_usuario;
      $servicioAnterior = $user->servicio_id;

    }

    if($sw==1){

      //Enviar Emails
      $data = [
        'idArray' => $arrayUsers,
        'arrayServicios' => $arrayServicios,
        'fecha' => '01 de Noviembre del 2023'
      ];

      $email = 'jefedetransportebog@aotour.com.co';

      Mail::send('emails.usuarios_dobles', $data, function($message) use ($email){
        $message->from('no-reply@aotour.com.co', 'Reporte de usuarios repetidos');
        $message->to($email)->subject('Revisión de Novedades');
        $message->cc(['aotourdeveloper@gmail.com']);
      });
      //Enviar Emails

    }

    return Response::json([
      'respuesta' => true,
      'users' => $users,
      'array1' => $arrayUsers,
      'array2' => $arrayServicios,
      'sw' => $sw
    ]);

    /*$id = Input::get('id');

    $consulta = DB::table('reconfirmacion')
    ->where('id_servicio',$id)
    ->first();

    if($consulta){

      $cantidad_reconfirmaciones = $consulta->numero_reconfirmaciones;
      if($cantidad_reconfirmaciones==null){

        $servicio = DB::table('reconfirmacion')
        ->where('id_servicio',$id)
        ->update([
          'numero_reconfirmaciones' => intval($cantidad_reconfirmaciones)+1,
          'reconfirmacion1hrs' => date('H:i:s'),
          'novedad_1' => 'El conductor realizó su confirmación de 1:45H desde UP DRIVER'
        ]);

      }else if($cantidad_reconfirmaciones==1){

        $servicio = DB::table('reconfirmacion')
        ->where('id_servicio',$id)
        ->update([
          'numero_reconfirmaciones' => intval($cantidad_reconfirmaciones)+1,
          'reconfirmacion30min' => date('H:i:s'),
          'novedad_30' => 'El conductor realizó su confirmación de 45mins desde UP DRIVER'
        ]);

      }else if($cantidad_reconfirmaciones==2){

        $servicio = DB::table('reconfirmacion')
        ->where('id_servicio',$id)
        ->update([
          'numero_reconfirmaciones' => intval($cantidad_reconfirmaciones)+1,
          'reconfirmacion_horacita' => date('H:i:s'),
          'novedad_hora' => 'El conductor realizó su confirmación de INICIO desde UP DRIVER'
        ]);

        $servicioIniciado = DB::table('servicios')
        ->where('id',$id)
        ->update([
          'estado_servicio_app' => 1
        ]);

      }

    }else{

      $reconfirmar = new Reconfirmacion;
      $reconfirmar->id_servicio = $id;
      $reconfirmar->numero_reconfirmaciones = 1;
      $reconfirmar->reconfirmacion2hrs = date('H:i:s');
      $reconfirmar->novedad_2 = 'El conductor realizó su confirmación de 2H desde UP DRIVER';
      $reconfirmar->save();

    }

    return Response::json([
      'respuesta' => true
    ]);*/

  }

  public function postCuadrar() {

    $fechaInicial = '20231001';
    $fechaFinal = '20231015';

    $query = "select * from servicios where centrodecosto_id = 19 and fecha_servicio between ".$fechaInicial." and ".$fechaFinal." and recorrido_gps is not null and pendiente_autori_eliminacion is null and estado_servicio_app = 2";
    $consulta = DB::select($query);

    $totales = 0;
    $sumadora = 0;
    $sumadora2 = 0;

    foreach ($consulta as $servicio) {
      
      $ubicaciones = json_decode($servicio->recorrido_gps);
        
      $latOld = 0;
      $lonOld = 0;
      $sw = 0;
      $tots = 0;

      if(count($ubicaciones)>1){
        
        foreach ($ubicaciones as $ubi) {
          $sumadora++;
          if($sw!=0){

            $lat2 = $ubi->latitude; //latitud coord 2
            $lon2 = $ubi->longitude; //longitud coord 2

            $theta = $lonOld - $lon2;
            $dist = sin(deg2rad($latOld)) * sin(deg2rad($lat2)) +  cos(deg2rad($latOld)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;

            $nuevoValor = $miles * 1.609344;
            if($nuevoValor>0.0){
              $sumadora2++;
              $tots = floatval(round($tots, 4))+floatval(round($nuevoValor, 4));
            }

          }else{
            $sw = 1;
          }

          $latOld = $ubi->latitude; //latitud coord 1
          $lonOld = $ubi->longitude; //longitud coord 1

        }
        $totales = $totales+$tots;

        $updateServices = DB::table('servicios')
        ->where('id',$servicio->id)
        ->update([
          'anulado_por' => $tots
        ]);

      }
      
    }

    return Response::json([
      'respuesta' => true,
      'totales' => floatval($totales),
      'consulta' => $consulta,
      'sumadora' => $sumadora,
      'sumadora2' => $sumadora2
    ]);

  }

  public function postWhatsapp() {

    /*$numero = 3013869946;
    $codigo = 190889;

    //Envío del código
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"messaging_product\": \"whatsapp\",
      \"to\": \"".$numero."\",
      \"type\": \"template\",
      \"template\": {
        \"name\": \"register\",
        \"language\": {
          \"code\": \"es\",
        },
        \"components\": [{
          \"type\": \"body\",
          \"parameters\": [{
            \"type\": \"text\",
            \"text\": \"".$codigo."\",
          }]
        }]
      }
    }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);*/

    return Response::json([
      'respuesta' => true,
      'response' => $response
    ]);

  }

}

?>
