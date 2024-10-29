<?php

use Illuminate\Database\Eloquent\Model;

Class InventarioController extends BaseController{

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

      $equipos = DB::table('equipos')
      ->get();

      return View::make('inventario.index', [
        'equipos' => $equipos,
        'documentos' => $query,
        'permisos' =>$permisos,
        'o' => $o
      ]);
    }
  }

  //CORREOS
  public function getCorreos(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';//$permisos->barranquilla->transportesbq->ver;
    }else{
      $ver = 'on';//null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $correos = DB::table('correos')->get();

      return View::make('inventario.correos', [
        'correos' => $correos
      ]);
    }
  }

  //LÍNEAS
  public function getLineas(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';//$permisos->barranquilla->transportesbq->ver;
    }else{
      $ver = 'on';//null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $lineas = DB::table('lineas')->get();

      return View::make('inventario.lineas', [
        'lineas' => $lineas
      ]);
    }
  }

  //Historial del Email
  public function getAddress($id){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';//$permisos->bogota->transportes->ver;
    }else{
      $ver = 'on';//null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $correo = DB::table('correos')
      ->where('id',$id)
      ->first();

      return View::make('inventario.historial', [
        'address'=> $correo->address,
        'historial' => json_decode($correo->historial)
      ]);
    }
  }

  //Actas de entrega
  public function getActasdeentrega(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';//$permisos->bogota->transportes->ver;
    }else{
      $ver = 'on';//null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $actas = DB::table('actas')
      ->leftJoin('equipos', 'equipos.id', '=', 'actas.equipo')
      ->leftJoin('empleados', 'empleados.id', '=', 'actas.empleado')
      ->select('actas.*', 'empleados.nombres', 'empleados.apellidos', 'equipos.categoria', 'equipos.marca')
      ->where('actas.tipo',1)
      ->get();

      return View::make('inventario.actas_entrega', [
        'actas'=> $actas
      ]);
    }
  }

  //Paz y Salvo
  public function getPazysalvo(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';//$permisos->bogota->transportes->ver;
    }else{
      $ver = 'on';//null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $actas = DB::table('actas')
      ->leftJoin('equipos', 'equipos.id', '=', 'actas.equipo')
      ->leftJoin('empleados', 'empleados.id', '=', 'actas.empleado')
      ->select('actas.*', 'empleados.nombres', 'empleados.apellidos', 'equipos.categoria', 'equipos.marca')
      ->where('actas.tipo',2)
      ->get();

      return View::make('inventario.paz_y_salvo', [
        'actas'=> $actas
      ]);
    }
  }

  //Vista de acta de entrega
  public function getActae($id){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';//$permisos->bogota->transportes->ver;
    }else{
      $ver = 'on';//null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $acta = DB::table('actas')
      ->leftJoin('equipos', 'equipos.id', '=', 'actas.equipo')
      ->leftJoin('empleados', 'empleados.id', '=', 'actas.empleado')
      ->select('actas.*', 'empleados.nombres', 'empleados.apellidos', 'equipos.categoria', 'equipos.marca', 'equipos.espacio')
      ->where('actas.id',$id)
      ->first();

      return View::make('inventario.acta', [
        'acta'=> $acta
      ]);
    }
  }

  //Vista de acta de entrega
  public function getActar($id){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';//$permisos->bogota->transportes->ver;
    }else{
      $ver = 'on';//null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $acta = DB::table('actas')
      ->where('id',$id)
      ->first();

      return View::make('inventario.acta_recibido', [
        'acta'=> $acta
      ]);
    }
  }

  //Inventario por empleado
  public function getEmpleados(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';//$permisos->bogota->transportes->ver;
    }else{
      $ver = 'on';//null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $actas = DB::table('actas')
      ->leftJoin('equipos', 'equipos.id', '=', 'actas.equipo')
      ->leftJoin('empleados', 'empleados.id', '=', 'actas.empleado')
      ->select('actas.*', 'empleados.nombres', 'empleados.apellidos', 'equipos.categoria', 'equipos.marca')
      ->where('actas.tipo',2)
      ->get();

      $empleados = DB::table('empleados')
      ->where('estado',1)
      ->get();

      return View::make('inventario.empleados', [
        'actas'=> $actas,
        'empleados' => $empleados
      ]);
    }
  }

  //Vista de Equipo
  public function getEquipo($id){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = 'on';//$permisos->bogota->transportes->ver;
    }else{
      $ver = 'on';//null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      $equipo = DB::table('equipos')
      ->where('id',$id)
      ->first();

      return View::make('inventario.equipo', [
        'equipo'=> $equipo
      ]);
    }
  }












  public function postBuscar(){

    if(!Sentry::check()){
    return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else{

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
  }

  //APROBAR FOTOS DE BIOSEGURIDAD
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

  //ELIMINAR FOTO
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

  //EXPORTAR PDF DE LAS FOTOS DE BIOSEGURIDAD
  public function postExportarpdf(){

    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else{

      $cliente = Input::get('cliente');
      $fecha = Input::get('fecha_pdf');

      $consulta = "select gestion_documental.id, gestion_documental.hora, gestion_documental.tipo_ruta, gestion_documental.fecha, gestion_documental.id_image, gestion_documental.nombre_documento, gestion_documental.placa, gestion_documental.id_conductor, ".
                "conductores.nombre_completo, conductores.celular ".
                "from gestion_documental ".
                "left join conductores on gestion_documental.id_conductor = conductores.id ".
                "where gestion_documental.fecha = '".$fecha."' and gestion_documental.cliente = '".$cliente."' and gestion_documental.estado = 1";
        $documentos = DB::select(DB::raw($consulta." order by gestion_documental.id asc"));

      $html = View::make('documentos.pdf_fotos_rutas')->with([
        'documentos' => $documentos,
        'fecha' => $fecha,
      ]);

      return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('RUTAS DEL DÍA '.$fecha.' '.$cliente);
    }
  }

  //EXPORTACIÓN A EXCEL SERVICIOS DE UN DETERMINADO CONDUCTOR
  public function getExcel(){

    ob_end_clean();
    ob_start();
    $start = Input::get('fecha_inicial_excel');
    $end = Input::get('fecha_final_excel');
    $nombrec = Conductor::find(Input::get('conductores2'));
    Excel::create('Servicios - '.$nombrec->nombre_completo.' - '.$start.' al '.$end.'', function($excel){

        $excel->sheet('hoja', function($sheet){

            $fecha_inicial = Input::get('fecha_inicial_excel');
            $fecha_final = Input::get('fecha_final_excel');
            $conductor = Input::get('conductores2');
            $nombrec = Conductor::find($conductor);

            $servicios = DB::select("select servicios.id, servicios.ciudad,  servicios.pasajeros_ruta, servicios.ruta, servicios.fecha_servicio, servicios.hora_servicio, servicios.detalle_recorrido, centrosdecosto.razonsocial, subcentrosdecosto.nombresubcentro from servicios left join centrosdecosto on centrosdecosto.id = servicios.centrodecosto_id left join subcentrosdecosto on subcentrosdecosto.id = servicios.subcentrodecosto_id where servicios.fecha_servicio between '".$fecha_inicial."' and '".$fecha_final."' and servicios.conductor_id = '".$conductor."' and pendiente_autori_eliminacion is null order by fecha_servicio asc");

            $sheet->loadView('documentos.plantilla_servicios')
            ->with([
              'servicios'=>$servicios
            ]);
        });
    })->download('xls');
  }

  //GUARDAR CAMBIOS DE MODIFICACIONES
  public function postEditarinfo(){

    $validaciones = [
      'cliente'=>'required',
      'fecha'=>'required',
      'hora'=>'required',
      'novedades'=>'required',
    ];

    $mensajes = [
      'cliente.required'=>'Debe selerccionar un CLIENTE',
      'fecha.required'=>'El campo FECHA es requerido',
      'hora.required'=>'El campo HORA es requerido',
      'novedades.required'=>'El campo NOVEDADES es requerido',
    ];

    $validador = Validator::make(Input::all(), $validaciones,$mensajes);

    if ($validador->fails())
    {
      return Response::json([
        'respuesta'=>false,
        'errores'=>$validador->errors()->getMessages()
      ]);

    }else{

      $id = Input::get('id');
      $hora = Input::get('hora');
      $fecha = Input::get('fecha');
      $novedades = Input::get('novedades');

      if(Input::get('cliente')==1){
        $cliente = 'SUTHERLAND BAQ';
      }elseif (Input::get('cliente')==2) {
        $cliente = 'SUTHERLAND BOG';
      }

      $consulta = DB::table('gestion_documental')
      ->where('id',$id)
      ->update([
        'hora' => $hora,
        'fecha' => $fecha,
        'novedadesruta' =>$novedades,
        'cliente' => $cliente
      ]);

      if($consulta!=null){

        return Response::json([
            'respuesta' => true
        ]);

      }else{

        return Response::json([
            'respuesta' => true
        ]);
      }
    }
  }
  //FIN GUARDAR CAMBIOS

  //VISTA DE VIZUALIZACIÓN DE LOS CLIENTES (SGS)
  public function getVerificacionderutas(){

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $cliente = Sentry::getUser()->centrodecosto_id;
      $centrodecostoname = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->portalusuarios->gestiondocumental->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{

      if($cliente==287){

        $query = DB::table('gestion_documental')
        ->leftJoin('conductores', 'gestion_documental.id_conductor', '=', 'conductores.id')
        ->select('gestion_documental.*', 'conductores.nombre_completo','conductores.celular')
        ->where('fecha',date('Y-m-d'))
        ->where('cliente','SUTHERLAND BOG')
        ->where('gestion_documental.estado',1)
        ->get();
        $o = 1;

      }else if($cliente==19){

        $query = DB::table('gestion_documental')
        ->leftJoin('conductores', 'gestion_documental.id_conductor', '=', 'conductores.id')
        ->select('gestion_documental.*', 'conductores.nombre_completo','conductores.celular')
        ->where('fecha',date('Y-m-d'))
        ->where('cliente','SUTHERLAND BAQ')
        ->where('gestion_documental.estado',1)
        ->get();
        $o = 1;

      }

      return View::make('portalusuarios.admin.listado', [

        'documentos' => $query,
        'permisos' =>$permisos,
        'cliente' =>$centrodecostoname,
        'o' => $o
      ]);
    }
  }

  //BUSCAR FOTOS DE BIOSEGURIDAD (FECHAS) CLIENTES SGS
  public function postBuscarfotos(){

    if(!Sentry::check()){
    return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else{

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
  }

  //VISTA DE REPORTE DE LIMPIEZA
  public function getReportedelimpieza(){

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

      $datos = DB::table('limpieza_vehiculos')
      ->where('fecha',date('Y-m-d'))
      ->where('ciudad','BARRANQUILLA')
      ->groupBy('nombre_conductor')->get();

      $conductores = DB::table('limpieza_vehiculos')
      ->where('ciudad','BARRANQUILLA')
      ->whereBetween('fecha',['20210401',date('Y-m-d')])
      ->groupBy('nombre_conductor')
      ->get();
      $o = 1;

      return View::make('documentos.reporte_limpieza_listado', [
        'datos' => $datos,
        'permisos' =>$permisos,
        'conductores' => $conductores,
        'o' => $o
      ]);

    }
  }
  //FIN VISTA REPORTE DE LIMPIEZA

  //BUSCAR REPORTES DE LIMPIEZA
  public function postBuscarreportes(){

    if(!Sentry::check()){
    return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else{

      if (Request::ajax()){

        $fecha = Input::get('fecha');
        $fecha_final = Input::get('fecha_final');
        $servicio = intval(Input::get('servicios'));
        $conductores = Input::get('conductores');

        $id_rol = Sentry::getUser()->id_rol;
        $id_cliente = Sentry::getUser()->centrodecosto_id;

        $consulta = "SELECT * FROM limpieza_vehiculos where fecha between '".$fecha."' and '".$fecha_final."'";

        if ($conductores!='-') {
          $consulta .= " and nombre_conductor = '".$conductores."' and ciudad = 'BARRANQUILLA'";
        }else{
          $consulta .= " and ciudad = 'BARRANQUILLA' group by nombre_conductor";
        }

        $documentos = DB::select($consulta);

        if ($documentos!=null) {

          return Response::json([
            'mensaje'=>true,
            'documentos'=>$documentos,
          ]);

        }else{

          return Response::json([
            'mensaje'=>false,
            $consulta
          ]);
        }
      }
    }
  }

  //EXPOTARR REPORTE DE LIMPIEZA INDIVIDUAL (V1)
  public function getExportarreporte($id){

    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else{

      $consulta = DB::table('limpieza_vehiculos')->where('id',$id)->first();

      $fecha = $consulta->fecha;
      $conductor = $consulta->conductor_id;

      $documentos = DB::table('limpieza_vehiculos')
      ->where('fecha',$fecha)
      ->where('conductor_id',$conductor)
      ->get();

      $driver = DB::table('conductores')->where('id',$conductor)->first();

      $vh = DB::table('vehiculos')->where('proveedores_id',$driver->proveedores_id)->first();

      $html = View::make('documentos.reporte_limpieza_pdf_individual')->with([
        'documentos' => $documentos,
        'nombre_conductor' => $driver->nombre_completo,
        'placa' => $vh->placa,
        'tipo_vehiculo' => $vh->clase
      ]);

      //return $html;

      return PDF::load(utf8_decode($html), 'A4', 'portrait')->download('Reporte de Limpieza'.$fecha);
    }
  }
  //FIN DE EXPORTAR REPORTE DE LIMPIEZA

  //EXPORTAR REPORTES DE LIMPIEZA GENERAL
  public function postExportarreportes(){

    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else{

      $fecha_inicial = Input::get('fecha');
      $fecha_final = Input::get('fecha_final');
      $conductores = Input::get('conductores');

      if ($conductores!='-') {

        $documentos = DB::table('limpieza_vehiculos')
        ->select('id', 'nombre_conductor', 'fecha')
        ->whereBetween('fecha',[$fecha_inicial,$fecha_final])
        ->where('nombre_conductor',$conductores)
        ->where('ciudad','BARRANQUILLA')
        ->orderBy('nombre_conductor')
        ->get();
        $sw=1;

      }else{

        $documentos = DB::table('limpieza_vehiculos')
        ->select('id', 'nombre_conductor', 'fecha')
        ->whereBetween('fecha',[$fecha_inicial,$fecha_final])
        ->where('ciudad','BARRANQUILLA')
        ->orderBy('nombre_conductor')
        ->get();
        $sw=1;
      }

      $html = View::make('documentos.reporte_limpieza_pdf')->with([
        'documentos' => $documentos,
        'switch' => $sw,
        'nombre_conductor' => 'test',
        'tipo_vehiculo' => 'toyota',
        'placa'=>'SGM227'
      ]);

      //return $html;

      return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('REPORTE DE LIMPIEZA'.$fecha_inicial.' - '.$fecha_final);

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

		public function postWompis(){

			$response = file_get_contents('https://sandbox.wompi.co/v1/transactions/115195-1642536275-82378');
			$response = json_decode($response);

			return Response::json([
				'respuesta' => true,
				'json' => $response->data->status
			]);

		}

    public function postWompia(){

      //$apiUrl = "https://sandbox.wompi.co/v1/tokens/cards"; //card prueba

      //$apiUrl = "https://production.wompi.co/v1/payment_links"; //links de pago productivo

      $apiUrl = "https://sandbox.wompi.co/v1/payment_links"; //links de pago pruebas

      //$ApiKey = "Bearer prv_prod_cVJvfcfo7LeK8jrKWmp7TweNWcN7uGgO"; //SAMUEL
			$ApiKey = "Bearer prv_prod_WJ9PkFir6uPwOPwstzfI8LsfPPedpRda"; //Aotour

			$valor = 5000;
			$valor2 = $valor.'00';

			$fecha = explode('-', date('Y-m-d'));
      $mes = $fecha[1];
      $ano = $fecha[0];

      $completa = $ano.'-'.$mes.'-21T04:59:59';
      //Links de pago
      $data = [
        "name" => "PRUEBA LINK AUTONET", // Nombre del Link de pago
        "description" => "Test autonet", // Descripción del link de pago
        "single_use" => true, // Link para una o varias transacciones (true/false)
        "collect_shipping" => false, // If you want to collect the customer's shipping information during checkout
        "currency" => "COP", // Tipo de moneda (Peso colombiano)
				"expires_at"=> $completa,
        "amount_in_cents" => intval($valor2), // Especificar valor. También se puede dejar nulo para que el cliente elija la cantidad a pagar
      ];

      //Card
      /*$data = [
        "number" => "4242424242424242", // Card number (13 to 19 digits)
        "cvc" => "123", // Card verification code (3 or 4 digits, depending on franchise)
        "exp_month" => "08", // Expiration month (2 digits string)
        "exp_year" => "28", // Expiration year (2 digits string)
        "card_holder" => "John Smith" // Card holder name
      ];*/


      $headers = [
        'Accept: application/json',
        'Authorization: Bearer prv_test_Ig9hDRTpqzvsvafOWcYQSQWdC938MtMK', //pruebas
        //'Authorization: Bearer prv_prod_cVJvfcfo7LeK8jrKWmp7TweNWcN7uGgO', //links productivo
        //'Authorization: Bearer prv_prod_WJ9PkFir6uPwOPwstzfI8LsfPPedpRda', //links pruebas
      ];

      $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      $result = curl_exec($ch);

      curl_close($ch);

      $result = json_decode($result);

      return Response::json([
        'respuesta' => true,
        'transaccion' => $result
      ]);

    }

		public function postWompi(){

			/*$llave = 'pub_test_kHmWs45k3rd7O9n1ER9hs5jHAccsCqmZ';
			$response = file_get_contents('https://sandbox.wompi.co/v1/merchants/'.$llave.''); //prueba
			$response = json_decode($response);
			$response = $response->data->presigned_acceptance->acceptance_token

			return Response::json([
        'respuesta' => true,
        'transaccion' =>
      ]);*/

			//Real down
			$valor2 = 180000;

			//$apiUrl = "https://sandbox.wompi.co/v1/tokens/cards"; //card prueba
			$apiUrl = "https://production.wompi.co/v1/tokens/cards"; //card produccion

			//INICIO CREACIÓN DE LINK DINÁMICO
			//$apiUrl = "https://production.wompi.co/v1/payment_links"; //links de pago productivo
			//$apiUrl = "https://sandbox.wompi.co/v1/payment_links"; //links de pago pruebas
			//$ApiKey = "Bearer prv_prod_cVJvfcfo7LeK8jrKWmp7TweNWcN7uGgO"; //links de pago productivo samuel
			//$ApiKey = "Bearer pub_test_kHmWs45k3rd7O9n1ER9hs5jHAccsCqmZ"; //links de pago productivo aotour

			/*$data = [
				"name" => "TRANSPORTE ESCOLAR AOTOUR",
				"description" => "Pague aquí la mensualidad del transporte del estudiante",
				"single_use" => true,
				"collect_shipping" => false,
				"currency" => "COP",
				//"expires_at"=> $completa,
				//"redirect_url" => "http://localhost/autonet/transporteescolar/pago/".$pago->id, //pruebas
				//"redirect_url" => "https://app.aotour.com.co/autonet/transporteescolar/pago/".$pago->id, //producción
				//"redirect_url" => "http://165.227.54.86/autonet/transporteescolar/pago/".$pago->id, //producción
				"amount_in_cents" => intval($valor2),
			];*/

			//Card
      $data = [
        "number" => "5471413012962407", // Card number (13 to 19 digits)
        "cvc" => "572", // Card verification code (3 or 4 digits, depending on franchise)
        "exp_month" => "12", // Expiration month (2 digits string)
        "exp_year" => "26", // Expiration year (2 digits string)
        "card_holder" => "SAMUEL GONZALEZ" // Card holder name
      ];

			/*$data = [
        "number" => "5471413012962407", // Card number (13 to 19 digits)
        "cvc" => "572", // Card verification code (3 or 4 digits, depending on franchise)
        "exp_month" => "12", // Expiration month (2 digits string)
        "exp_year" => "26", // Expiration year (2 digits string)
        "card_holder" => "SAMUEL GONZALEZ" // Card holder name
      ];*/

			$headers = [
				'Accept: application/json',
				//'Authorization: Bearer pub_test_kHmWs45k3rd7O9n1ER9hs5jHAccsCqmZ', //links pruebas samuel
				'Authorization: Bearer pub_prod_k3EGLrTVqzDhXKogfQwL8PGo080sw5K0', //links productivo aotour
			];

			$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $apiUrl);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			$result = curl_exec($ch);

			curl_close($ch);

			$result = json_decode($result);
			//FIN CREACIÓN DE LINK DINÁMICO

			//START OBTENCIÓN DE TOKEN DE ACEPTACIÓN
			//$llave = 'pub_test_kHmWs45k3rd7O9n1ER9hs5jHAccsCqmZ'; //prueba SAMUEL
      $llave = 'pub_prod_k3EGLrTVqzDhXKogfQwL8PGo080sw5K0'; //producción AOTOUR
      $response = file_get_contents('https://production.wompi.co/v1/merchants/'.$llave.''); //prueba
			$response = json_decode($response);
      $acceptance_token = $response->data->presigned_acceptance->acceptance_token;
			//END OBTENCIÓN DE TOKEN DE ACEPTACIÓN

			// START CREACIÓN DE FUENTE DE PAGO
			$token = $result->data->id;
			$apiUrl2 = "https://production.wompi.co/v1/payment_sources"; //card prueba fuente de pago

			$datas = [
        "type" => "CARD",
        "token" => $token,
        "customer_email" => "sdgonzalezmendoza@gmail.com",
        "acceptance_token" => $acceptance_token,
      ];

			$headers = [
        'Accept: application/json',
        //'Authorization: Bearer prv_test_Ig9hDRTpqzvsvafOWcYQSQWdC938MtMK', //links pruebas samuel
        'Authorization: Bearer prv_prod_WJ9PkFir6uPwOPwstzfI8LsfPPedpRda', //links productivo aotour
      ];
      $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl2);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datas));
      $resultados = curl_exec($ch);
			$resultados = json_decode($resultados);
			$id_fuente_pago = $resultados->data->id;
			// START CREACIÓN DE FUENTE DE PAGO

			//START TRANSACCION CON FUENTE DE PAGO
			$apiUrl3 = "https://production.wompi.co/v1/transactions"; //card prueba fuente de pago
			$datass = [
        "amount_in_cents" => 200000,
        "currency" => "COP",
        "customer_email" => "sdgonzalezmendoza@gmail.com",
				"payment_method" => [
					"installments" => 1
				],
        "reference" => "sJK4489dDjkd390ds02",
				"payment_source_id" => $id_fuente_pago
      ];
			$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl3);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datass));
      $resultados = curl_exec($ch);
			$resultado_transaccion = json_decode($resultados);
			// END TRANSACCION CON FUENTE DE PAGO

			return Response::json([
        'respuesta' => true,
        'transaccion' => $result,
				'token' => $token,
				'fuente_pago' => $id_fuente_pago,
				'resultado_transaccion' => $resultado_transaccion
      ]);

			//$pago->link = 'https://checkout.wompi.co/l/'.$result->data->id;

		}

    public function postWompicard(){

      $apiUrl = "https://sandbox.wompi.co/v1/v1/tokens/cards"; //card prueba
      //$apiUrl = "https://production.wompi.co/merchants/merchant_pub_test_kHmWs45k3rd7O9n1ER9hs5jHAccsCqmZ"; //card prueba      /merchants/

      //$apiUrl = "https://production.wompi.co/v1/payment_links"; //links productivo

      $ApiKey = "Bearer prv_prod_cVJvfcfo7LeK8jrKWmp7TweNWcN7uGgO";

      $data = [
				"number" => "4242424242424242", // Número de la tarjeta
			  "cvc" => "123", // Código de seguridad de la tarjeta (3 o 4 dígitos según corresponda)
			  "exp_month" => "08", // Mes de expiración (string de 2 dígitos)
			  "exp_year" => "28", // Año expresado en 2 dígitos
			  "card_holder" => "José Pérez" // Nombre del tarjetahabiente
			];


			$headers = [
				//'Accept: application/json',
				'Authorization: Bearer pub_test_kHmWs45k3rd7O9n1ER9hs5jHAccsCqmZ', //links pruebas samuel
				//'Authorization: Bearer prv_prod_WJ9PkFir6uPwOPwstzfI8LsfPPedpRda', //links productivo aotour
			];

      $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      $result = curl_exec($ch);

      curl_close($ch);

      $result = json_decode($result);

      return Response::json([
        'respuesta' => true,
        'transaccion' => $result
      ]);

    }

    public function postWompinequi(){

      $referenceCode = 'aotour_mobile_client_'.date('YmdHis');

      //$referencia = new ReferenciasPayu;
      //$referencia->reference_code = $referenceCode;
      //$referencia->save();

      $pago = new PagoServicio;
      $pago->reference_code = $referenceCode;
      $pago->order_id = 123;
      $pago->user_id = 11;
      $pago->valor = 11111;
      $pago->numero_tarjeta = '************1111';
      $pago->tipo_tarjeta =  'SADDD';
      $pago->estado =  'APROVED';

      if($pago->save()){

        $pay = DB::table('pago_servicios')
        ->where('reference_code',$referenceCode)
        ->first();

        return Response::json([
          'response' => true,
          'pay' => $pay,
          'pay2' => $pay->id
        ]);
      }
      
      
/*
      $apiUrl = "https://sandbox.wompi.co/v1/transactions"; //URL DE PRODUCCIÓN

      $valorReal = '200000';

      $referenceCode = 'aotour_mobile_client_'.date('YmdHis');

      $data = [
        "amount_in_cents" => intval($valorReal),
        "currency" => "COP",
        "customer_email" => "sdg@gmail.com",
        "payment_method" => [
          "type" => 'PSE',
          "user_type" => 0,
          "user_legal_id_type" => "CC",
          "user_legal_id" => "1099888777",
          "financial_institution_code" => "1",
          "payment_description" => "Pago a Tienda Wompi, ref: JD38USJW2XPLQA",

        ],
        "reference" => $referenceCode,
        //"payment_source_id" => $queryCard->fuente_pago,
      ];

      $headers = [
        'Accept: application/json',
        'Authorization: Bearer pub_test_kHmWs45k3rd7O9n1ER9hs5jHAccsCqmZ', //links pruebas samuel
        //'Authorization: Bearer prv_prod_WJ9PkFir6uPwOPwstzfI8LsfPPedpRda', //links productivo aotour
      ];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $apiUrl);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      $result = curl_exec($ch);

      curl_close($ch);

      $result = json_decode($result);*/

      return Response::json([
        'respuesta' => true,
        'transaccion' => $result,
        //'response' => $response
      ]);

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
}
?>
