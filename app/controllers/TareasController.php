<?php

use Illuminate\Database\Eloquent\Model;

Class TareasController extends BaseController{

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

      $users = DB::table('empleados')
      ->whereIn('estado',[1,4])
      ->where('id','!=',Sentry::getUser()->id_empleado)
      ->get();

      $actividades = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.asignado_por')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('responsable',Sentry::getUser()->id_empleado)
      ->whereNull('actividades.estado')
      ->get();

      $consult = "SELECT actividades.*, empleados.nombres, empleados.apellidos FROM actividades left join empleados on empleados.id = actividades.responsable WHERE actividades.estado is null and FIND_IN_SET('".Sentry::getUser()->id_empleado."', implicados) > 0 "; 

      $shared = DB::select($consult);

      return View::make('tareas.index', [
        'permisos' =>$permisos,
        'users' => $users,
        'actividades' => $actividades,
        'shared' => $shared
      ]);

    }
  }

  public function getTasks(){

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

      //NUEVOOOOOO
      $users = DB::table('empleados')
      ->whereIn('estado',[1,4])
      ->where('id','!=',Sentry::getUser()->id_empleado)
      ->get();

      $actividades = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.responsable')
      ->leftJoin('users', 'users.id_empleado', '=', 'actividades.asignado_por')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos', 'users.first_name', 'users.last_name')
      //->where('asignado_por',Sentry::getUser()->id_empleado)
      ->whereNull('actividades.estado')
      ->orderBy('actividades.fecha')
      //->whereBetween('fecha',['20320320','20230413'])
      ->get();

      return View::make('tareas.todas', [
        'permisos' =>$permisos,
        'users' => $users,
        'actividades' => $actividades
      ]);

    }
  }

  public function getAsignadas(){

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

      //NUEVOOOOOO
      $users = DB::table('empleados')
      ->whereIn('estado',[1,4])
      ->where('id','!=',Sentry::getUser()->id_empleado)
      ->get();

      $actividades = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.responsable')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('asignado_por',Sentry::getUser()->id_empleado)
      ->whereNull('actividades.estado')
      ->get();

      return View::make('tareas.asignadas', [
        'permisos' =>$permisos,
        'users' => $users,
        'actividades' => $actividades
      ]);

    }
  }

  public function getGenerarproyecto(){

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

      //NUEVOOOOOO
      $users = DB::table('empleados')
      ->whereIn('estado',[1,4])
      ->where('id','!=',Sentry::getUser()->id_empleado)
      ->get();

      $actividades = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.responsable')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('asignado_por',Sentry::getUser()->id_empleado)
      ->where('fecha',date('Y-m-d'))
      ->get();

      return View::make('tareas.generar', [
        'permisos' =>$permisos,
        'users' => $users,
        'actividades' => $actividades
      ]);

    }
  }

  public function getAdjuntarproyecto(){

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

      //NUEVOOOOOO
      $users = DB::table('empleados')
      ->whereIn('estado',[1,4])
      ->where('id','!=',Sentry::getUser()->id_empleado)
      ->get();

      $proyectos = DB::table('proyectos')
      ->leftJoin('empleados', 'empleados.id', '=', 'proyectos.usuario')
      ->select('proyectos.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('usuario',Sentry::getUser()->id_empleado)
      //->where('fecha',date('Y-m-d'))
      ->get();

      return View::make('tareas.adjuntar', [
        'permisos' =>$permisos,
        'users' => $users,
        'proyectos' => $proyectos
      ]);

    }
  }

  public function postEliminar(){

    $id = Input::get('id');

    $query = "DELETE FROM proyectos WHERE id = ".$id.";";

    $select = DB::select($query);

    return Response::json([
      'respuesta' => true
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
      

      return View::make('tareas.emails.tarea_copiada', [
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

      if($actividad->implicados!=null){
        $actuales = $actividad->implicados;
        $actividad->implicados = $actuales.','.$datas;
      }else{
        $actividad->implicados = $datas;
      }

      if($actividad->save()){

        $usuarioss = explode(",",$datas);

        $text = '';

        for ($i=0; $i <count($usuarioss) ; $i++) { 

          $consult = "SELECT * FROM correos WHERE FIND_IN_SET('".$usuarioss[$i]."', usuario) > 0 ";

          $shared = DB::select($consult);

          foreach ($shared as $key) {

            $text .= $key->address;

            $email = $key->address;

            $names = DB::table('empleados')->where('id',$actividad->responsable)->first();

            $nombreAsignado = $names->nombres.' '.$names->apellidos;
            
            $data = [
              'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
              'nombre_tarea' => $actividad->nombre,
              'id' => $actividad->id,
              'asignadoa' => $nombreAsignado
            ];

            Mail::send('tareas.emails.tarea_asignada', $data, function($message) use ($email){
              $message->from('no-reply@aotour.com.co', 'AUTONET');
              $message->to($email)->subject('Tarea Compartida');
            });

          }
        }

        return Response::json([
          'response' => true,
          'text' => $text
        ]);

      }
  }

  //Tipos de Comprobante
  public function postTiposdecomprobante(){

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-d8d5cd2d0a-siigoapi.apiary-proxy.com/v1/document-types?type=FV");
    //curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/document-types?type=FV");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    //var_dump($response);

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response)
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

    //curl_setopt($ch, CURLOPT_URL, "https://private-anon-a5e9bc99c3-siigoapi.apiary-proxy.com/v1/payment-types?document_type=FV");
    curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/payment-types?document_type=FV");

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

    /*$ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-214159ed09-siigoapi.apiary-proxy.com/v1/taxes");

    //curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/taxes");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: ".SiigoController::TOKEN_SIIGO.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);*/

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
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/products?created_start=");
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

  //Vendedor
  public function postVendedor(){

    $ch = curl_init();

    //curl_setopt($ch, CURLOPT_URL, "https://private-anon-a5e9bc99c3-siigoapi.apiary-proxy.com/v1/users");

    curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/users?created_start=&page=2&page_size=25");

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

    //curl_setopt($ch, CURLOPT_URL, "https://private-anon-50b3c59d4c-siigoapi.apiary-proxy.com/auth");
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

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-d8d5cd2d0a-siigoapi.apiary-proxy.com/v1/credit-notes");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"document\": {
        \"id\": 24453
      },
      \"number\": 1,
      \"date\": \"2022-12-21\",
      \"invoice\": \"d41788d4-0e91-4232-acd3-e869518d6acd\",
      \"reason\": \"1\",
      \"retentions\": [
        {
          \"id\": 13156
        }
      ],
      \"observations\": \"Observaciones\",
      \"items\": [
        {
          \"code\": \"Item-1\",
          \"description\": \"Servicio de Transporte AOTOUR\",
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

    /*Guardar en Siigo*/

    $identificacion = "1043027888"; //Número de identificación del cliente

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
    curl_close($ch);
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

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://private-anon-caf85a6666-siigoapi.apiary-proxy.com/v1/invoices/{1efbdf9c-6488-46f4-b7a9-95f5d7377ad9}");
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

    $ch = curl_init();

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
    curl_close($ch);

    return Response::json([
      'respuesta' => true,
      'response' => json_decode($response)
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
    $sw = 0;

    for ($i=0; $i<count($participantesTarea) ; $i++) { 

      if($cantidad==1){

        $datas = null;
        $sw = 1;

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

      //correo al asignado

      $consultt = "SELECT * FROM correos WHERE FIND_IN_SET('".$asignado."', usuario) > 0 ";

      $sharedd = DB::select($consultt);

      foreach ($sharedd as $key) {

        $email = $key->address;

        $data = [
          'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
          'nombre_tarea' => $actividad->nombre,
          'id' => $actividad->id,
        ];

        Mail::send('tareas.emails.asignacion', $data, function($message) use ($email){
          $message->from('no-reply@aotour.com.co', 'AUTONET');
          $message->to($email)->subject('Tarea Asignada');
        });

      }

      //correo al asignado end

      $usuarioss = explode(",",$actividad->implicados);

      $text = '';

      for ($i=0; $i <count($usuarioss) ; $i++) { 

        $consult = "SELECT * FROM correos WHERE FIND_IN_SET('".$usuarioss[$i]."', usuario) > 0 ";

        $shared = DB::select($consult);

        foreach ($shared as $key) {
          
          $text .= $key->address; //correo del empleado en la iteración

          $email = $key->address;

          $names = DB::table('empleados')->where('id',$actividad->responsable)->first();

          $nombreAsignado = $names->nombres.' '.$names->apellidos;
          
          $data = [
            'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
            'nombre_tarea' => $actividad->nombre,
            'id' => $actividad->id,
            'asignadoa' => $nombreAsignado
          ];

          Mail::send('tareas.emails.tarea_asignada', $data, function($message) use ($email){
            $message->from('no-reply@aotour.com.co', 'AUTONET');
            $message->to($email)->subject('Tarea Compartida');
          });

        }

      }

      //Envío de correos

      return Response::json([
        'respuesta' => true,
        'asignado' => $asignado,
        'nombreTarea' => $nombreTarea,
        'descripcionTarea' => $descripcionTarea,
        'participantesTarea' => $participantesTarea,
        'shared' => $shared,
        'i' => $i,
        'datas' => $datas,
        'sw' => $sw
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

        if($cantidad==1){

          $datas = null;

        }else if(count($users)>1){

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

        if($usuarioss[$i]!=Sentry::getUser()->id_empleado){

          $consult = "SELECT * FROM correos WHERE FIND_IN_SET('".$usuarioss[$i]."', usuario) > 0 ";

          $shared = DB::select($consult);

          foreach ($shared as $key) {
            
            $text .= $key->address; //correo del empleado en la iteración

            $email = $key->address;

            $data = [
              'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
              'nombre_tarea' => $actividad->nombre,
              'id' => $actividad->id
            ];

            Mail::send('tareas.emails.tarea_copiada', $data, function($message) use ($email){
              $message->from('no-reply@aotour.com.co', 'AUTONET');
              $message->to($email)->subject('Tarea Compartida');
            });

          }

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
    $fecha2 = Input::get('fecha2');
    $opcion = Input::get('opcion');

    //$fecha = $a.$m.$d;

    //$actividades = DB::table('')

    $actividades = DB::table('actividades')
    ->leftJoin('empleados', 'empleados.id', '=', 'actividades.asignado_por')
    ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
    ->where('responsable',Sentry::getUser()->id_empleado)
    ->whereBetween('fecha',[$fecha,$fecha2])
    ->get();

    $query = "SELECT actividades.*, empleados.nombres, empleados.apellidos FROM actividades left join empleados on empleados.id = actividades.asignado_por WHERE responsable = ".Sentry::getUser()->id_empleado." and fecha between '".$fecha."' and '".$fecha2."'";

    if ($opcion!=1) {
      $query .= " and actividades.estado is null ";
    }else{
      $query .= " and actividades.estado is not null ";
    }

    $actividades = DB::select($query);

    $consult = "SELECT actividades.*, empleados.nombres, empleados.apellidos FROM actividades left join empleados on empleados.id = actividades.responsable WHERE fecha between '".$fecha."' and '".$fecha2."' and FIND_IN_SET('".Sentry::getUser()->id_empleado."', implicados) > 0";

    if ($opcion!=1) {
      $consult .= " and actividades.estado is null ";
    }else{
      $consult .= " and actividades.estado is not null ";
    }

    $shared = DB::select($consult);

    return Response::json([
      'respuesta' => true,
      'fecha' => $fecha,
      'actividades' => $actividades,
      'shared' => $shared,
      'query' => $query
    ]);

  }

  public function postFiltrardiaa(){

    $fecha = Input::get('fecha');
    $fecha2 = Input::get('fecha2');
    $opcion = Input::get('opcion');

    //$fecha = $a.$m.$d;

    //$actividades = DB::table('')

    if ($opcion!=1) {
      
      $actividades = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.responsable')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('asignado_por',Sentry::getUser()->id_empleado)
      ->whereBetween('fecha',[$fecha,$fecha2])
      ->whereNull('actividades.estado')
      ->get();

    }else{

      $actividades = DB::table('actividades')
      ->leftJoin('empleados', 'empleados.id', '=', 'actividades.responsable')
      ->select('actividades.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('asignado_por',Sentry::getUser()->id_empleado)
      ->whereBetween('fecha',[$fecha,$fecha2])
      ->whereNotNull('actividades.estado')
      ->get();
      //$query .= " and actividades.estado is not null ";
    }

    return Response::json([
      'respuesta' => true,
      'fecha' => $fecha,
      'actividades' => $actividades
    ]);

  }

  public function postFiltrardiaas(){

    $fecha = Input::get('fecha');
    $fecha2 = Input::get('fecha2');
    $users = Input::get('users');
    $opcion = Input::get('opcion');

    $query = "select actividades.*, empleados.nombres, empleados.apellidos, users.first_name, users.last_name from actividades left join empleados on empleados.id = actividades.responsable left join users on users.id_empleado = actividades.asignado_por where fecha between '".$fecha."' and '".$fecha2."' ";

    if ($opcion!=1) {
      $query .= " and actividades.estado is null ";
    }else{
      $query .= " and actividades.estado is not null ";
    }

    if ($users=='') {
      $actividades = DB::select($query."order by fecha asc ");
    }else if($users!='' and $users!='null'){

      $sw = 0;

      $datas = '';

      for ($i=0; $i<count($users) ; $i++) { 

        if(count($users)>1){

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

      $query .= "and responsable in(".$datas.")";
      $actividades = DB::select($query);
    }

    //$actividades = DB::select($actividades);

    return Response::json([
      'respuesta' => true,
      'fecha' => $fecha,
      'actividades' => $actividades,
      'users' => $users,
      'query' => $query
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

      return View::make('tareas.task', [
        'task' => $task,
        'permisos' =>$permisos
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

                $email = $key->address;

                $data = [
                  'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
                  'nombre_tarea' => $task->nombre,
                  'comentarios' => $task->comentarios,
                  'adjuntos' => $task->adjuntos,
                  'id' => $task->id
                ];

                Mail::send('tareas.emails.tarea_activada', $data, function($message) use ($email){
                  $message->from('no-reply@aotour.com.co', 'AUTONET');
                  $message->to($email)->subject('Tarea Reactivada');
                });

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

                $email = $key->address;

                $data = [
                  'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
                  'nombre_tarea' => $task->nombre,
                  'comentarios' => $task->comentarios,
                  'adjuntos' => $task->adjuntos,
                  'id' => $task->id
                ];

                Mail::send('tareas.emails.tarea_cerrada', $data, function($message) use ($email){
                  $message->from('no-reply@aotour.com.co', 'AUTONET');
                  $message->to($email)->subject('Tarea Cerrada');
                });

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

      if(Sentry::getUser()->id_empleado!=$tarea->responsable){

        $consultt = "SELECT * FROM correos WHERE FIND_IN_SET('".$tarea->responsable."', usuario) > 0 ";

        $sharedd = DB::select($consultt);

        foreach ($sharedd as $key) {

          $email = $key->address;

          $data = [
            'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
            'nombre_tarea' => $tarea->nombre,
            'id' => $tarea->id,
            'comenta' => strtoupper($comentario)
          ];

          Mail::send('tareas.emails.comentarios', $data, function($message) use ($email){
            $message->from('no-reply@aotour.com.co', 'AUTONET');
            $message->to($email)->subject('Nuevo Comentario');
          });

        }

      }
          
      if($tarea->implicados!=null){

        $usuarioss = explode(",",$tarea->implicados);

        $text = '';

        for ($i=0; $i <count($usuarioss) ; $i++) {

          if($usuarioss[$i]!=Sentry::getUser()->id_empleado){

            $consult = "SELECT * FROM correos WHERE FIND_IN_SET('".$usuarioss[$i]."', usuario) > 0 ";

            $shared = DB::select($consult);

            foreach ($shared as $key) {

              $text .= $key->address; //correo del empleado en la iteración

              $email = $key->address;

              $data = [
                'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
                'nombre_tarea' => $tarea->nombre,
                'id' => $tarea->id,
                'comenta' => strtoupper($comentario)
              ];

              Mail::send('tareas.emails.comentarios', $data, function($message) use ($email){
                $message->from('no-reply@aotour.com.co', 'AUTONET');
                $message->to($email)->subject('Nuevo Comentario');
              });

            }

          }

        }

        //Envío de correos
      }

      if($tarea->asignado_por!=null && Sentry::getUser()->id_empleado!=$tarea->asignado_por){

        $consult = "SELECT * FROM correos WHERE FIND_IN_SET('".$tarea->asignado_por."', usuario) > 0 ";

        $shar = DB::select($consult);

        foreach ($shar as $key) {

          //$text .= $key->address; //correo del empleado en la iteración

          $email = $key->address;

          $data = [
            'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
            'nombre_tarea' => $tarea->nombre,
            'id' => $tarea->id,
            'comenta' => $comentario
          ];

          Mail::send('tareas.emails.comentarios', $data, function($message) use ($email){
            $message->from('no-reply@aotour.com.co', 'AUTONET');
            $message->to($email)->subject('Nuevo Comentario');
          });

        }

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

  public function postAdjuntar() {

    $fecha_proyecto = Input::get('fecha');

    $proyecto = new Proyecto;
    $proyecto->usuario = Sentry::getUser()->id_empleado;
    $proyecto->fecha_proyecto = $fecha_proyecto;

    if (Input::hasFile('recibo')){

      $file_pdf = Input::file('recibo');
      $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

      $ubicacion_pdf = 'biblioteca_imagenes/proyectos/';
      $file_pdf->move($ubicacion_pdf, Sentry::getUser()->id_empleado.$fecha_proyecto.$name_pdf);
      $pdf_soporte = Sentry::getUser()->id_empleado.$fecha_proyecto.$name_pdf;

      $proyecto->file = $pdf_soporte;

      $proyecto->save();

      return Response::json([
        'respuesta' => true,
        'pdf_soporte' => $pdf_soporte
      ]);

    }

    return Response::json([
      'respuesta' => false,
      'pdf_soporte' => $pdf_soporte
    ]);

  }

  public function postEliminarusuario() {

    $id = Input::get('id');
    $tarea_id = Input::get('tarea_id');

    $task = Actividad::find($tarea_id);

    $implicados = $task->implicados;

    $usuarioss = explode(",",$implicados);

    $text = '';
    $sw = 0;

    $sended = '';

    for ($i=0; $i <count($usuarioss) ; $i++) {

      if($usuarioss[$i] == $id){

        //Enviar correo
        $sended = 'ok';

        $consult = "SELECT * FROM correos WHERE FIND_IN_SET('".$id."', usuario) > 0 ";

        $shared = DB::select($consult);

        foreach ($shared as $key) {

          $email = $key->address;

          $data = [
            'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
            'nombre_tarea' => $task->nombre,
            'id' => $task->id,
          ];

          Mail::send('tareas.emails.eliminado', $data, function($message) use ($email){
            $message->from('no-reply@aotour.com.co', 'AUTONET');
            $message->to($email)->subject('Eliminado');
          });

        }

      }else{

        $sw++;

        if($i == (count($usuarioss)-1)){
          $coma = '';
        }else{
          $coma = ',';
        }

        if($sw==count($usuarioss)-1){
          $coma = '';
        }

        if(count($usuarioss) == 2){
          $text = $usuarioss[$i];
        }else{
          $text .= $usuarioss[$i].$coma;
        }

      } 
      //new

    }

    $task->implicados = $text;
    $task->save();

    return Response::json([
      'respuesta' => true,
      'text' => $text,
      'users' => count($usuarioss),
      'i' => $i,
      'sended' => $sended
    ]);

  }

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

                     //Image::make($file->getRealPath())->save($ubicacion.$nombre_imagen);

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

                        if (Input::hasFile('file')) {
                          $width = Image::make($file->getRealPath())->width();
                          $height = Image::make($file->getRealPath())->height();
                          Image::make($file->getRealPath())->save($ubicacion . $nombre_imagen);
                          File::delete($ubicacion.$imagen_antigua);
                        }

                        if(Sentry::getUser()->id_empleado!=$actividad->responsable){

                          $consultt = "SELECT * FROM correos WHERE FIND_IN_SET('".$tarea->responsable."', usuario) > 0 ";

                          $sharedd = DB::select($consultt);

                          foreach ($sharedd as $key) {

                            $email = $key->address;

                            $data = [
                              'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
                              'nombre_tarea' => $actividad->nombre,
                              'id' => $actividad->id,
                            ];

                            Mail::send('tareas.emails.adjuntos', $data, function($message) use ($email){
                              $message->from('no-reply@aotour.com.co', 'AUTONET');
                              $message->to($email)->subject('Archivos Adjuntos');
                            });

                          }

                        }
          
                        if($actividad->implicados!=null){

                          $usuarioss = explode(",",$actividad->implicados);

                          $text = '';

                          for ($i=0; $i <count($usuarioss) ; $i++) { 

                            if($usuarioss[$i]!=Sentry::getUser()->id_empleado){

                              $consult = "SELECT * FROM correos WHERE FIND_IN_SET('".$usuarioss[$i]."', usuario) > 0 ";

                              $shared = DB::select($consult);

                              foreach ($shared as $key) {

                                $text .= $key->address; //correo del empleado en la iteración

                                $email = $key->address;

                                $data = [
                                  'usuario' => Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name,
                                  'nombre_tarea' => $actividad->nombre,
                                  'id' => $actividad->id,
                                ];

                                Mail::send('tareas.emails.adjuntos', $data, function($message) use ($email){
                                  $message->from('no-reply@aotour.com.co', 'AUTONET');
                                  $message->to($email)->subject('Archivos Adjuntos');
                                });

                              }

                            }

                          }

                          //Envío de correos
                        }

                         return Response::json([
                             //'respuesta'=>true,
                             'nombre_imagen'=>$nombre_imagen,
                             'text' => $text
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

}

?>
