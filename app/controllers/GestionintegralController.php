<?php

use Illuminate\Database\Eloquent\Model;

Class GestionintegralController extends BaseController{

    //VISTA PARA BARRANQUILLA
    public function getIndex(){    

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

        $indicadores = DB::table('indicadores')
        ->leftJoin('ejecucion_indicadores', 'indicadores.id', '=', 'ejecucion_indicadores.indicador_id')
        ->select('ejecucion_indicadores.*', 'indicadores.id as id_indicador', 'indicadores.nombre', 'indicadores.area', 'indicadores.tipo_indicador', 'indicadores.interpretacion_indicador', 'indicadores.fecha_creacion', 'indicadores.meta_asociada', 'indicadores.valor_programado', 'indicadores.variable_a', 'indicadores.variable_b', 'indicadores.formula', 'indicadores.fuente_informacion', 'indicadores.frecuencia_reporte', 'indicadores.unidad_medida', 'indicadores.tendencia', 'indicadores.tipo_medicion', 'indicadores.linea_base', 'indicadores.personas_interesadas')
        ->WhereNotNull('indicadores.id')->get();


              $query = DB::table('gestion_documental')            
              ->leftJoin('conductores', 'gestion_documental.id_conductor', '=', 'conductores.id')            
              ->select('gestion_documental.*', 'conductores.nombre_completo','conductores.celular')            
              ->where('fecha',date('Y-m-d'))
              ->whereIn('cliente',['SUTHERLAND BAQ','ACEROS CORTADOS','LHOIST','PIMSA','PUERTO PIMSA','QUANTICA - BILATERAL'])
              ->whereIn('gestion_documental.estado',[0,1])
              ->get();            
              $o = 1;

              $conductores = Conductor::bloqueadototal()->bloqueado()
              ->leftJoin('proveedores', 'proveedores.id', '=', 'conductores.proveedores_id')
              ->select('conductores.nombre_completo','conductores.id')
              ->orderBy('nombre_completo')
              ->where('proveedores.localidad','BARRANQUILLA')
              ->where('conductores.estado','ACTIVO')
              ->get();

              return View::make('integral.list', [  
              
                'documentos' => $query,
                'permisos' =>$permisos,
                'conductores'=>$conductores,

                'indicadores'=>$indicadores,
                'o' => $o
              ]);
                        
          }
      }
      //FIN VISTA PARA BARRANQUILLA

      public function postNuevoindicador(){
        
        $nombre = Input::get('nombre');
        $proceso = Input::get('proceso');
        $tipo = Input::get('tipo');
        $interpretacion_indicador = Input::get('interpretacion_indicador');
        $meta_asociada = Input::get('meta_asociada');
        $valor_programado = Input::get('valor_programado');
        $variable_a = Input::get('variable_a');
        $variable_b = Input::get('variable_b');
        $formula_indicador = Input::get('formula_indicador');
        $fuente_informacion = Input::get('fuente_informacion');
        $frecuencia = Input::get('frecuencia');
        $unidad_medida = Input::get('unidad_medida');
        $tendencia = Input::get('tendencia');
        $tipo_medicion = Input::get('tipo_medicion');
        $linea_base = Input::get('linea_base');
        $personas_interesadas = Input::get('personas_interesadas');
        $analisis = Input::get('analisis');
        $acciones_mejora = Input::get('acciones_mejora');

        $resultado_deseado = Input::get('resultado_deseado');
        $resultado_satisfactorio = Input::get('resultado_satisfactorio');
        $resultado_critico = Input::get('resultado_critico');

        $indicador = new Indicador();
        $indicador->nombre = strtoupper(trim($nombre));
        $indicador->area = strtoupper(trim($proceso));
        $indicador->tipo_indicador = strtoupper(trim($tipo));
        $indicador->interpretacion_indicador = strtoupper(trim($interpretacion_indicador));
        $indicador->meta_asociada = strtoupper(trim($meta_asociada));
        $indicador->valor_programado = trim($valor_programado);
        $indicador->variable_a = strtoupper(trim($variable_a));
        $indicador->variable_b = strtoupper(trim($variable_b));
        $indicador->formula = strtoupper(trim($formula_indicador));
        $indicador->fuente_informacion = strtoupper(trim($fuente_informacion));
        $indicador->frecuencia_reporte = strtoupper(trim($frecuencia));
        $indicador->unidad_medida = strtoupper(trim($unidad_medida));
        $indicador->tendencia = strtoupper(trim($tendencia));
        $indicador->tipo_medicion = strtoupper(trim($tipo_medicion));
        $indicador->linea_base = strtoupper(trim($linea_base));
        $indicador->personas_interesadas = strtoupper(trim($personas_interesadas));
        $indicador->fecha_creacion = date('Y-m-d');
        $indicador->analisis = strtoupper(trim($analisis));
        $indicador->acciones_mejora = strtoupper(trim($acciones_mejora));

        
        if($indicador->save()){

          $datos = new EjecucionIndicador();
          $datos->resultado_deseado = trim($resultado_deseado);
          $datos->resultado_satisfactorio = trim($resultado_satisfactorio);
          $datos->resultado_critico = trim($resultado_critico);
          $datos->indicador_id = $indicador->id;

          //DATOS DE GRÁFICO

          //FIN DATOS DE GRÁFICO

          $datos->save();

          return Response::json([
            'respuesta'=>true
          ]);
        }

      }

      public function getDetallesindicador($id){
      
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

        //$indicador = Indicador::find($id);

        $indicador = DB::table('indicadores')
        ->leftJoin('ejecucion_indicadores', 'indicadores.id', '=', 'ejecucion_indicadores.indicador_id')
        ->select('ejecucion_indicadores.*', 'indicadores.id as id_indicador', 'indicadores.nombre', 'indicadores.area', 'indicadores.tipo_indicador', 'indicadores.interpretacion_indicador', 'indicadores.fecha_creacion', 'indicadores.meta_asociada', 'indicadores.valor_programado', 'indicadores.variable_a', 'indicadores.variable_b', 'indicadores.formula', 'indicadores.fuente_informacion', 'indicadores.frecuencia_reporte', 'indicadores.unidad_medida', 'indicadores.tendencia', 'indicadores.tipo_medicion', 'indicadores.linea_base', 'indicadores.personas_interesadas', 'indicadores.analisis', 'indicadores.acciones_mejora')
        ->WhereNotNull('indicadores.id')
        ->where('indicadores.id',$id)
        ->first();

        return View::make('integral.detalles_indicador', [  
          'indicador' => $indicador,
          //'permisos' =>$permisos,
          //'conductores'=>$conductores,
          //'o' => $o
        ]);
      }

    }

    public function postGuardarcambio2(){
      
      $id = Input::get('id');
      $valor = Input::get('valor');
      $opcion = Input::get('opcion');

      $consulta = "UPDATE ejecucion_indicadores set ";
      if(intval($opcion)===1){
        $consulta .=" b1 = '".$valor."' ";
      }else if(intval($opcion)===2){
        $consulta .=" b2 = '".$valor."' ";
      }else if(intval($opcion)===3){
        $consulta .=" b3 = '".$valor."' ";
      }else if(intval($opcion)===4){
        $consulta .=" b4 = '".$valor."' ";
      }else if(intval($opcion)===5){
        $consulta .=" b5 = '".$valor."' ";
      }else if(intval($opcion)===6){
        $consulta .=" b6 = '".$valor."' ";
      }else if(intval($opcion)===7){
        $consulta .=" b7 = '".$valor."' ";
      }else if(intval($opcion)===8){
        $consulta .=" b8 = '".$valor."' ";
      }else if(intval($opcion)===9){
        $consulta .=" b9 = '".$valor."' ";
      }else if(intval($opcion)===10){
        $consulta .=" b10 = '".$valor."' ";
      }else if(intval($opcion)===11){
        $consulta .=" b11 = '".$valor."' ";
      }else if(intval($opcion)===12){
        $consulta .=" b12 = '".$valor."' ";
      }

      $consulta .= " WHERE indicador_id = ".$id."";

      $consulta = DB::update($consulta);

      if($consulta){
        return Response::json([
          'respuesta'=>true
        ]);
      }else{
        return Response::json([
          'respuesta'=>false
        ]);
      }

    }

    //GUARDAR CAMBIOS
    public function postGuardarcambio(){

      $id = Input::get('id');
      $valor = Input::get('valor');
      $opcion = Input::get('opcion');

      $consulta = "UPDATE ejecucion_indicadores set ";
      if(intval($opcion)===1){
        $consulta .=" a1 = '".$valor."' ";
      }else if(intval($opcion)===2){
        $consulta .=" a2 = '".$valor."' ";
      }else if(intval($opcion)===3){
        $consulta .=" a3 = '".$valor."' ";
      }else if(intval($opcion)===4){
        $consulta .=" a4 = '".$valor."' ";
      }else if(intval($opcion)===5){
        $consulta .=" a5 = '".$valor."' ";
      }else if(intval($opcion)===6){
        $consulta .=" a6 = '".$valor."' ";
      }else if(intval($opcion)===7){
        $consulta .=" a7 = '".$valor."' ";
      }else if(intval($opcion)===8){
        $consulta .=" a8 = '".$valor."' ";
      }else if(intval($opcion)===9){
        $consulta .=" a9 = '".$valor."' ";
      }else if(intval($opcion)===10){
        $consulta .=" a10 = '".$valor."' ";
      }else if(intval($opcion)===11){
        $consulta .=" a11 = '".$valor."' ";
      }else if(intval($opcion)===12){
        $consulta .=" a12 = '".$valor."' ";
      }

      $consulta .= " WHERE indicador_id = ".$id."";

      $consulta = DB::update($consulta);

      if($consulta){

        //Pusher
        $idpusher = "578229";
        $keypusher = "a8962410987941f477a1";
        $secretpusher = "6a73b30cfd22bc7ac574";

        //CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
        $channel = 'dashboard';
        $name = 'datos';

        //$user = User::find(2);

        $query = DB::table('ejecucion_indicadores')
        ->where('indicador_id',$id)
        ->first();

        //NUEVOS DATOS
        if($query->b1===0 || $query->b1===null){
          $enero = 0;
        }else{
          $enero = ($query->a1/$query->b1)*100;
        }
        if($query->b2===0 || $query->b2===null){
          $febrero = 0;
        }else{
          $febrero = ($query->a2/$query->b2)*100;
        }
        if($query->b3===0 || $query->b3===null){
          $marzo = 0;
        }else{
          $marzo = ($query->a3/$query->b3)*100;
        }
        if($query->b4===0 || $query->b4===null){
          $abril = 0;
        }else{
          $abril = ($query->a4/$query->b4)*100;
        }
        if($query->b5===0 || $query->b5===null){
          $mayo = 0;
        }else{
          $mayo = ($query->a5/$query->b5)*100;
        }
        if($query->b6===0 || $query->b6===null){
          $junio = 0;
        }else{
          $junio = ($query->a6/$query->b6)*100;
        }
        if($query->b7===0 || $query->b7===null){
          $julio = 0;
        }else{
          $julio = ($query->a7/$query->b7)*100;
        }
        if($query->b8===0 || $query->b8===null){
          $agosto = 0;
        }else{
          $agosto = ($query->a8/$query->b8)*100;
        }
        if($query->b9===0 || $query->b9===null){
          $septiembre = 0;
        }else{
          $septiembre = ($query->a9/$query->b9)*100;
        }
        if($query->b10===0 || $query->b10===null){
          $octubre = 0;
        }else{
          $octubre = ($query->a10/$query->b10)*100;
        }
        if($query->b11===0 || $query->b11===null){
          $noviembre = 0;
        }else{
          $noviembre = ($query->a11/$query->b11)*100;
        }
        if($query->b12===0 || $query->b12===null){
          $diciembre = 0;
        }else{
          $diciembre = ($query->a12/$query->b12)*100;
        }        
        //FIN NUEVOS DATOS

        $data = json_encode([
          'valor' => $valor,
          'resultado_deseado'=>$query->resultado_deseado,
          'resultado_satisfactorio'=>$query->resultado_satisfactorio,
          'resultado_critico'=>$query->resultado_critico,
          'enero'=>$enero,
          'febrero'=>$febrero,
          'marzo'=>$marzo,
          'abril'=>$abril,
          'mayo'=>$mayo,
          'junio'=>$junio,
          'julio'=>$julio,
          'agosto'=>$agosto,
          'septiembre'=>$septiembre,
          'octubre'=>$octubre,
          'noviembre'=>$noviembre,
          'diciembre'=>$diciembre
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

        $result = curl_exec($ch);

        //FIN CANAL DE RECONFIRMACIONES

        return Response::json([
            'response' => true,
            'enero'=>number_format($enero),
            'febrero'=>number_format($febrero),
            'marzo'=>number_format($marzo),
            'abril'=>number_format($abril),
            'mayo'=>number_format($mayo),
            'junio'=>number_format($junio),
            'julio'=>number_format($julio),
            'agosto'=>number_format($agosto),
            'septiembre'=>number_format($septiembre),
            'octubre'=>number_format($octubre),
            'noviembre'=>number_format($noviembre),
            'diciembre'=>number_format($diciembre),
            'resultado_deseado'=>$query->resultado_deseado,
            'resultado_satisfactorio'=>$query->resultado_satisfactorio,
            'resultado_critico'=>$query->resultado_critico
        ]);

      }else{

        return Response::json([
            'response' => false
        ]);

      }
    }
    //FIN GUARDAR CAMBIOS

    //VISTA PARA BOGOTÁ
    public function getVerificaciondefotosbog(){    

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

            return View::make('documentos.listadobog', [  
            
              'documentos' => $query,
              'permisos' =>$permisos,
              'conductores'=>$conductores,
              'o' => $o
            ]);
                      
        }
    }
    //FIN VISTA PARA BOGOTÁ

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

              /*if($id_cliente==287){
                $nombre_cliente = 'SUTHERLAND BOG';
              }elseif ($id_cliente==19){
                $nombre_cliente = 'SUTHERLAND BAQ';
              }*/

              $consulta = "select gestion_documental.id, gestion_documental.hora, gestion_documental.cliente, gestion_documental.tipo_ruta, gestion_documental.fecha, gestion_documental.id_image, gestion_documental.estado, gestion_documental.nombre_documento, gestion_documental.placa, gestion_documental.id_conductor, gestion_documental.novedadesruta, ".                    
                "conductores.nombre_completo, conductores.celular ".
                "from gestion_documental ".                   
                "left join conductores on gestion_documental.id_conductor = conductores.id ".
                "where gestion_documental.fecha between '".$fecha_inicial."' AND '".$fecha_final."' and gestion_documental.estado = 1";

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

    public function getPdf2(){

    if (Sentry::check()){

     

        $html = View::make('documentos.plantilla_ingreso');
        return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('PLANTILLA INGRESO ');
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

    public function postConsulta(){
      
      $consulta = User::find(2);
      
      if($consulta!=null){

        //Pusher
        $idpusher = "578229";
        $keypusher = "a8962410987941f477a1";
        $secretpusher = "6a73b30cfd22bc7ac574";

        //CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
        $channel = 'dashboard';
        $name = 'datos';

        $user = User::find(2);

        $data = json_encode([
          'rol' => $user->id_rol,
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

        $result = curl_exec($ch);

        //FIN CANAL DE RECONFIRMACIONES
        
        return Response::json([
          'response'=>true,
          'usuario'=>$consulta->first_name.' '.$consulta->last_name
        ]);

      }else{

        return Response::json([
          'response'=>false
        ]);

      }

    }
}
?>