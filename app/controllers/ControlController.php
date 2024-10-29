<?php

use Illuminate\Database\Eloquent\Model;

Class ControlController extends BaseController{

	public function getIndex(){    

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->talentohumano->control_ingreso->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{    

      $empleados = DB::table('empleados')
      ->orderBy('empleados.nombres')
      ->leftJoin('control_ingreso', 'empleados.id', '=', 'control_ingreso.empleado')
      ->select('empleados.nombres', 'empleados.apellidos','empleados.telefono','empleados.id as dataid', 'control_ingreso.hora_llegada','control_ingreso.hora_salida','control_ingreso.hora_llegadapm', 'control_ingreso.hora_salidapm', 'control_ingreso.fecha', 'control_ingreso.estado', 'control_ingreso.id', 'control_ingreso.observaciones')            
      ->where('control_ingreso.fecha',date('Y-m-d'))      
      ->where('empleados.sede','BARRANQUILLA')
      ->get();

      $o = 1;

      return View::make('talentohumano.control_ingreso_baq', [  
      
        'documentos' => $empleados,
        'permisos' =>$permisos,
        'o' => $o
      ]);
                      
    }
  }

  public function getControlbog(){    

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->talentohumano->control_ingreso_bog->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{    

      $empleados = DB::table('empleados')
      ->orderBy('empleados.nombres')
      ->leftJoin('control_ingreso', 'empleados.id', '=', 'control_ingreso.empleado')
      ->select('empleados.nombres', 'empleados.apellidos','empleados.telefono','empleados.id as dataid', 'control_ingreso.hora_llegada','control_ingreso.hora_salida','control_ingreso.hora_llegadapm', 'control_ingreso.hora_salidapm', 'control_ingreso.fecha', 'control_ingreso.estado', 'control_ingreso.id', 'control_ingreso.observaciones')            
      ->where('control_ingreso.fecha',date('Y-m-d'))      
      ->where('empleados.sede','BOGOTA')
      ->get();

      $o = 1;

      return View::make('talentohumano.control_ingreso_bog', [  
      
        'documentos' => $empleados,
        'permisos' =>$permisos,
        'o' => $o
      ]);
                      
    }
  }

  public function postGenerarplanilla(){
      
    if(Sentry::check()){

      if(Input::get('info')==1){
        $ciudad = 'BOGOTA';
      }else{
        $ciudad = 'BARRANQUILLA';
      }

      $consultar = DB::table('control_ingreso')
      ->leftJoin('empleados', 'empleados.id', '=', 'control_ingreso.empleado')
      ->where('empleados.sede',$ciudad)
      ->where('fecha',date('Y-m-d'))
      ->get();

      if(!$consultar){
        if(Input::get('info')==1){
          $empleados = DB::table('empleados')
          ->where('estado',1)
          ->where('sede','BOGOTA')
          ->get();
        }else{
          $empleados = DB::table('empleados')
          ->where('estado',1)
          ->where('sede','BARRANQUILLA')
          ->get();
        }
        

        if($empleados){
          foreach ($empleados as $empleado) {
            $nuevo = new Ingreso;
            $nuevo->empleado = $empleado->id;
            $nuevo->fecha = date('Y-m-d');
            $nuevo->estado = 0;
            $nuevo->save();
          }

          return Response::json([
            'response' =>true,
          ]);

        }else{
          return Response::json([
            'vacio' =>true
          ]);
        }
      }else{
        return Response::json([
          'response'=>'relogin',
        ]);
      }
    }else{
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }
  }

  //OBSERVACION
  public function postGuardarobservacion(){

    if(Request::ajax()){   
      
      $id = Input::get('id');
      $empleado = Input::get('empleado');
      $observaciones = Input::get('observaciones');

      $consulta = Ingreso::find($id);

      if($consulta){
        $consulta->observaciones = strtoupper($observaciones);
        $consulta->save();

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

  //VISTA PARA BARRANQUILLA
  public function getHistorialllegada(){    

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->talentohumano->control_ingreso->historial;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{    

      $empleados = DB::table('empleados')
      ->orderBy('empleados.nombres')
      ->leftJoin('control_ingreso', 'empleados.id', '=', 'control_ingreso.empleado')
      ->select('empleados.nombres', 'empleados.apellidos','empleados.telefono','empleados.id as dataid', 'control_ingreso.hora_llegada','control_ingreso.hora_salida','control_ingreso.hora_llegadapm', 'control_ingreso.hora_salidapm', 'control_ingreso.fecha', 'control_ingreso.estado', 'control_ingreso.id', 'control_ingreso.observaciones')            
      ->where('control_ingreso.fecha',date('Y-m-d'))      
      ->where('empleados.sede','BARRANQUILLA')
      ->get();

      $o = 1;

      $empleados_lista = DB::table('empleados')
      ->where('estado',1)            
      ->get();

      return View::make('talentohumano.historial_llegada', [  
      
        'datos' => $empleados,
        'permisos' =>$permisos,
        'empleados'=>$empleados_lista,
        'o' => $o
      ]);
    }
  }

  //VISTA PARA BOGOTÁ
  public function getHistorialllegadabog(){    

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->talentohumano->control_ingreso_bog->historial;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{    

      $empleados = DB::table('empleados')
      ->orderBy('empleados.nombres')
      ->leftJoin('control_ingreso', 'empleados.id', '=', 'control_ingreso.empleado')
      ->select('empleados.nombres', 'empleados.apellidos','empleados.telefono','empleados.id as dataid', 'control_ingreso.hora_llegada','control_ingreso.hora_salida','control_ingreso.hora_llegadapm', 'control_ingreso.hora_salidapm', 'control_ingreso.fecha', 'control_ingreso.estado', 'control_ingreso.id', 'control_ingreso.observaciones')            
      ->where('control_ingreso.fecha',date('Y-m-d'))      
      ->where('empleados.sede','BOGOTA')
      ->get();

      $o = 1;

      $empleados_lista = DB::table('empleados')
      ->where('estado',1)            
      ->get();

      return View::make('talentohumano.historial_llegada_bog', [  
      
        'datos' => $empleados,
        'permisos' =>$permisos,
        'empleados'=>$empleados_lista,
        'o' => $o
      ]);
                
    }
  }
  //FIN VISTA PARA BARRANQUILLA

  public function postBuscarhistorial(){      

    if (Request::ajax()){

      $fecha_inicial = Input::get('fecha_inicial');
      $fecha_final = Input::get('fecha_final');
      
      $empleado_id = Input::get('empleados');
      $id_rol = Sentry::getUser()->id_rol;
      $option = Input::get('option');

      if ($empleado_id===null) {
        $empleado_id = 0;
      }  

        $consulta = "select empleados.id as dataid, empleados.nombres, empleados.apellidos, control_ingreso.hora_llegada, control_ingreso.hora_salida, control_ingreso.hora_llegadapm, control_ingreso.hora_salidapm, control_ingreso.fecha, control_ingreso.estado, control_ingreso.id, control_ingreso.observaciones ".                    
            "from empleados ".
            "left join control_ingreso on control_ingreso.empleado = empleados.id ".
            "where control_ingreso.fecha between '".$fecha_inicial."' AND '".$fecha_final."'";
      if(intval($option)===0){
        $consulta .=" and empleados.sede='BARRANQUILLA'";
      }elseif(intval($option)===1){
        $consulta .=" and empleados.sede='BOGOTA'";
      }

      if($empleado_id!='0'){
        $consulta .= " and control_ingreso.empleado = ".$empleado_id." ";
      }

      $datos = DB::select(DB::raw($consulta." order by empleados.nombres asc"));

      if ($datos!=null) {
         
        return Response::json([
          'mensaje'=>true,
          'documentos'=>$datos,
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

  public function getPdfbog(){

    if (Sentry::check()){

      $fecha = Input::get('fecha_final');

      $consulta = "select control_ingreso.id, control_ingreso.hora_llegada, control_ingreso.hora_salida, control_ingreso.hora_llegadapm, control_ingreso.hora_salidapm, control_ingreso.observaciones, empleados.nombres, empleados.apellidos, empleados.sede, empleados.cargo from control_ingreso left join empleados on empleados.id =  control_ingreso.empleado where empleados.estado=1 and empleados.sede='BOGOTA' and control_ingreso.fecha = '".$fecha."' ";
      $documentos = DB::select($consulta);

        $html = View::make('documentos.plantilla_ingreso')
         ->with(['documentos'=>$documentos, 'fecha'=>$fecha]);
        return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('PLANILLA_INGRESO_BOG_'.$fecha.'');
      }else{
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }
    }

    public function getPdfbaq(){

    if (Sentry::check()){

      $fecha = Input::get('fecha_final');

      //PROCESO A REALIZAR
      $consulta = "select control_ingreso.id, control_ingreso.hora_llegada, control_ingreso.hora_salida, control_ingreso.hora_llegadapm, control_ingreso.hora_salidapm, control_ingreso.observaciones, empleados.nombres, empleados.apellidos, empleados.sede, empleados.cargo from control_ingreso left join empleados on empleados.id =  control_ingreso.empleado where empleados.estado=1 and empleados.sede='BARRANQUILLA' and control_ingreso.fecha = '".$fecha."' ";
      $documentos = DB::select($consulta);
      //FIN PROCESO A REALIZAR

        $html = View::make('documentos.plantilla_ingreso')
         ->with(['documentos'=>$documentos, 'fecha'=>$fecha]);
        return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('PLANILLA_INGRESO_BAQ_'.$fecha.'');
      }
    }

    public function getWelcome(){    

        if(Sentry::check()){
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->barranquilla->transportesbq->ver;
        }else{
          $ver = null;
        }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{  

      $emoticones = DB::table('emoticones')->get();

      return View::make('talentohumano.welcome', [  
      
        'emoticones' => $emoticones,
        //'permisos' =>$permisos,
        //'conductores'=>$conductores,
        //'o' => $o

      ]);
    }
  }

  public function postGuardarwelcome(){

    $welcome = new Welcome;
    $welcome->nombre = Input::get('nombre');
    $welcome->mensaje = strtoupper(strtoupper(Input::get('mensaje')));
    
    //CONTROLES PARA EL VALOR 1
    if(Input::get('sw1')==1){ //SI ES UN PDF
      if (Input::hasFile('valor')){
        $file1 = Input::file('valor');
        $name_pdf1 = str_replace(' ', '', $file1->getClientOriginalName());
        
        $ubicacion_servicios = 'biblioteca_imagenes/mantenimiento_fact/';
        $file1->move($ubicacion_servicios, 'file'.$name_pdf1);               
        $welcome->seccionuno = 'file'.$name_pdf1;
      
      }else{
        $welcome->seccionuno = 12;
      }
      $welcome->estado1 = 1;
    }else if(Input::get('sw1')==2){ //SI ES UN VÍDEO
      $welcome->seccionuno = Input::get('valor');
      $welcome->estado1 = 2;
    }else if(Input::get('sw1')==3){ //SI ES UNA IMAGEN
      if(Input::hasFile('foto_perfil')){
        $file1 = Input::file('foto_perfil');
        $name_pdf1 = str_replace(' ', '', $file1->getClientOriginalName());
        
        $ubicacion_servicios = 'biblioteca_imagenes/talentohumano/fotos/';
        $file1->move($ubicacion_servicios, 'foto'.$name_pdf1);               
        $welcome->seccionuno = 'foto'.$name_pdf1;
      }
      $welcome->estado1 = 3;
    }

    //CONTROLES PARA EL VALOR 2
    if(Input::get('sw2')==1){ //SI ES UN PDF
      if (Input::hasFile('valor2')){
        $file1 = Input::file('valor2');
        $name_pdf1 = str_replace(' ', '', $file1->getClientOriginalName());
        
        $ubicacion_servicios = 'biblioteca_imagenes/mantenimiento_fact/';
        $file1->move($ubicacion_servicios, 'file'.$name_pdf1);               
        $welcome->secciondos = 'file'.$name_pdf1;
      
      }else{
        $welcome->secciondos = 12;
      }
      $welcome->estado2 = 1;
    }else if(Input::get('sw2')==2){ //SI ES UN VÍDEO
      $welcome->secciondos = Input::get('valor2');
      $welcome->estado2 = 2;
    }else if(Input::get('sw2')==3){ //SI ES UNA IMAGEN
      if(Input::hasFile('foto_perfil2')){
        $file1 = Input::file('foto_perfil2');
        $name_pdf1 = str_replace(' ', '', $file1->getClientOriginalName());
        
        $ubicacion_servicios = 'biblioteca_imagenes/talentohumano/fotos/';
        $file1->move($ubicacion_servicios, 'foto'.$name_pdf1);               
        $welcome->secciondos = 'foto'.$name_pdf1;
      }
      $welcome->estado2 = 3;
    }

    if(Input::get('sub1')!=null){
      $welcome->sub1 = strtoupper(Input::get('sub1'));
    }

    if(Input::get('sub2')!=null){
      $welcome->sub2 = strtoupper(Input::get('sub2'));
    }

    /*if (Input::hasFile('secciondos')){

      $file1 = Input::file('secciondos');
      $name_pdf1 = str_replace(' ', '', $file1->getClientOriginalName());
      
      $ubicacion_servicios = 'biblioteca_imagenes/mantenimiento_fact/';
      $file1->move($ubicacion_servicios, 'file'.$name_pdf1);               
      $welcome->secciondos = 'file'.$name_pdf1;
    
    }else{
      $welcome->pdf = 11;
    }    */

    if($welcome->save()){
      return Response::json([
        'respuesta' => true
      ]);
    }else{
      return Response::json([
        'respuesta' => false
      ]);
    }

  }

  public function getHistorialdemensajes(){

    if (Sentry::check()) {
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
    }else{
      $id_rol = null;
      $permisos = null;
      $permisos = null;
    }

    if(isset($permisos->administrativo->proveedores->ver)){
      $ver = $permisos->administrativo->proveedores->ver;
    }else{
      $ver = null;
    }

    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on' ) {
      return View::make('admin.permisos');
    }else{

      $welcome = DB::table('welcome')->get();

      return View::make('talentohumano.historial_mensajes')
      ->with([
        'permisos' => $permisos,
        'welcome' => $welcome
      ]);
    }
  }

  public function getListadodemensajes(){
    
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
      $emoticones = DB::table('emoticones')->get();

      return View::make('talentohumano.listadodemensajes', [
      
        'emoticones' => $emoticones,
        //'permisos' =>$permisos,
        //'conductores'=>$conductores,
        //'o' => $o
      ]);
    }
  }

  public function getEmoticones(){    

    if(Sentry::check()){
      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->barranquilla->transportesbq->ver;
    }else{
      $ver = null;
    }

    if(!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else if($ver!='on'){
      return View::make('admin.permisos');
    }else{  

      $emoticones = DB::table('emoticones')->get();

      return View::make('talentohumano.emoticones', [  
      
        'emoticones' => $emoticones,
        //'permisos' =>$permisos,
        //'conductores'=>$conductores,
        //'o' => $o
      ]);
    }
  }

  //GUARDAR EMOTICÓN
  public function postGuardaremoticon(){

    if(Request::ajax()){   
      
      $nombre = Input::get('nombre');
      $codigo = Input::get('codigo');

      $consulta = Emoticones::where('codigo',$codigo)->first();

      if($consulta!=null){

        return Response::json([
          'respuesta'=>false
        ]);

      }else{

        $new = new Emoticones;
        $new->nombre = strtoupper($nombre);
        $new->codigo = $codigo;

        if($new->save()){
          return Response::json([
            'respuesta'=>true
          ]);
        }          
      }
    }
  }

  public function postBuscar2(){

    if (Request::ajax()){
      
      $empleados = DB::table('empleados')
      ->whereIn('estado',[1,2])
      ->get();

      return Response::json([
        'mensaje' => true,
        'documentos' => $empleados
      ]);
    }
  }

  //GUARDAR LLEGADA
  public function postGuardarllegada(){

    if (!Sentry::check()){
      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
    }else{

      $fecha = date('Y-m-d');
      $empleado = Input::get('empleado');
      $hora_llegada = Input::get('hora_llegada');
      $hora_salida = Input::get('hora_salida');
      $hora_llegadapm = Input::get('hora_llegadapm');
      $hora_salidapm = Input::get('hora_salidapm');

      $id = Input::get('empleado_id');
      //$observaciones = Input::get('observaciones');

      $consulta = Ingreso::where('empleado',$id)
      ->where('fecha',$fecha)->first();

      if($consulta!=null){
        if(intval(Input::get('status'))===3){
          $valor_estado = 4;
        }else{
          $valor_estado = $consulta->estado+1;
        }
        //$valor_estado = $consulta->estado+1;
        $update = DB::table('control_ingreso')
        ->where('empleado', $id)
        ->where('fecha', $fecha)
        ->update([
          'estado' => $valor_estado,
          'hora_llegada' => $hora_llegada,
          'hora_salida' => $hora_salida,
          'hora_llegadapm' => $hora_llegadapm,
          'hora_salidapm' => $hora_salidapm,
        ]);

        return Response::json([
          'response' => true,
          'ingreso' => $valor_estado
        ]);

      }else{

        $ingreso = new Ingreso();
        $ingreso->fecha = $fecha;        
        $ingreso->empleado = $id;
        $ingreso->hora_llegada = $hora_llegada;
        $ingreso->hora_salida = $hora_salida;
        $ingreso->hora_llegadapm = $hora_llegadapm;
        $ingreso->hora_salidapm = $hora_salidapm;
        $ingreso->estado = 1;
        
        if($ingreso->save()){
            
          return Response::json([
            'response' => true,
            'ingreso' => 1
          ]);

        }else{

          return Response::json([
            'response' => false
          ]);
        }  
      }
    }
  }

  //TEST
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
}
?>