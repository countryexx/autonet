<?php

  class EncuestasygraficasController extends BaseController{

    public function getIndex(){

      if (!Sentry::check()){

  			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

  		}else{

        $centrosdecosto = DB::table('centrosdecosto')->orderBy('razonsocial')->get();
        return View::make('encuestasygraficas.menugrafico')->with([
          'centrosdecosto'=>$centrosdecosto
        ]);

      }

    }

    public function postGuardarencuesta(){

      if (!Sentry::check()){

  			return Response::json([
  				'respuesta'=>'relogin'
  			]);

  		}else{

  			if(Request::ajax()){

          try{

            $encuesta = new Graficoencuesta();
            $encuesta->nombre_encuestado = strtoupper(Input::get('encuestado'));
            $encuesta->centrodecosto = Input::get('id_centro');
            $encuesta->fecha = Input::get('fecha');
            $encuesta->hora = Input::get('hora');
            $encuesta->area = strtoupper(Input::get('area'));
            $encuesta->pregunta_1 = Input::get('pregunta_1');
            $encuesta->pregunta_2 = Input::get('pregunta_2');
            $encuesta->pregunta_3 = Input::get('pregunta_3');
            $encuesta->pregunta_4 = Input::get('pregunta_4');
            $encuesta->pregunta_5 = Input::get('pregunta_5');
            $encuesta->pregunta_6 = Input::get('pregunta_6');
            $encuesta->pregunta_7 = Input::get('pregunta_7');
            $encuesta->pregunta_8 = Input::get('pregunta_8');
            $encuesta->cual5 = strtoupper(Input::get('cual5'));
            $encuesta->pregunta_9 = Input::get('pregunta_9');
            $encuesta->cual6 = strtoupper(Input::get('cual6'));
            $encuesta->pregunta_10 = Input::get('pregunta_10');
            $encuesta->cual7 = strtoupper(Input::get('cual7'));
            $encuesta->percepcion = strtoupper(Input::get('percepcion'));
            $encuesta->creado_por = Sentry::getUser()->id;
            $encuesta->id_servicio = Input::get('id_servicio');

            if ($encuesta->save()) {
              $id = $encuesta->id;
              $enc = Graficoencuesta::find($id);

              if (strlen(intval($id))===1) {

                  $enc->consecutivo = 'EC000'.$id;
                  if ($enc->save()) {
                    return Response::json([
                        'respuesta'=>true
                    ]);
                  }

              }elseif (strlen(intval($id))===2) {
                  $enc->consecutivo = 'EC00'.$id;
                  if ($enc->save()) {
                    return Response::json([
                        'respuesta'=>true
                    ]);
                  }
              }elseif(strlen(intval($id))===3){
                  $enc->consecutivo = 'EC0'.$id;
                  if ($enc->save()) {
                    return Response::json([
                        'respuesta'=>true
                    ]);
                  }
              }elseif(strlen(intval($id))===4){
                  $enc->consecutivo = 'EC'.$id;
                  if ($enc->save()) {
                    return Response::json([
                        'respuesta'=>true
                    ]);
                  }
              }

            }

          }catch (Exception $e){
              return Response::json([
                  'respuesta'=>'error',
                  'e'=>$e,
              ]);
          }

        }

      }
    }

    public function postGraficosservicios(){

        function diasMes($mes,$ano){
          $dias =  date('t', mktime(0,0,0, $mes, 1, $ano));
          return $dias;
        }

        //CANTIDAD DE DIAS DEL MES
        $mes = Input::get('mes');
        $ano = Input::get('ano');

        $dias = diasMes($mes,$ano);

        $fecha = strval($ano).strval($mes).'01';

        $fecha = date($fecha);

        $arraycount = [];
        $arraydias = [];

        $centrodecosto = intval(Input::get('centrodecosto'));

        for ($i=0; $i < $dias ; $i++) {
          $nuevafecha = strtotime ('+'.$i.' day', strtotime($fecha));
          $nuevafecha = date ('Y-m-d', $nuevafecha);

          if ($centrodecosto!=0) {
            $cantidad_servicios = DB::table('servicios')->where('fecha_servicio',$nuevafecha)->where('centrodecosto_id',$centrodecosto)->count();
          }else if($centrodecosto===0){
            $cantidad_servicios = DB::table('servicios')->where('fecha_servicio',$nuevafecha)->count();
          }

          array_push($arraycount, $cantidad_servicios);
          array_push($arraydias, $i+1);

        }

        return Response::json([
          'respuesta'=>true,
          'arraycount'=>$arraycount,
          'dias'=>$dias,
          'dias'=>$arraydias
        ]);
    }

    public function postGraficosencuesta(){

        $fecha_inicial = Input::get('fecha_inicial');
        $fecha_final = Input::get('fecha_final');
        $centrodecosto = Input::get('centrodecosto');

        $consulta = "select * from servicios ".
            "left join encuesta on servicios.id = encuesta.id_servicio ".
            "where servicios.fecha_servicio between '".$fecha_inicial."' and '".$fecha_final."' and encuesta.pregunta_1 is not null and ";

        $servicios = DB::select($consulta);

        $i = 0;
        $excelente = 0;
        $bueno = 0;
        $aceptable = 0;
        $regular = 0;
        $malo = 0;

        foreach ($servicios as $value) {

            if ($value->pregunta_1===1) {
              $malo++;
            }else if ($value->pregunta_1===2) {
              $regular++;
            }else if ($value->pregunta_1===3) {
              $aceptable++;
            }else if ($value->pregunta_1===4) {
              $bueno++;
            }else if ($value->pregunta_1===5) {
              $excelente++;
            }

            if ($value->pregunta_2===1) {
              $malo++;
            }else if ($value->pregunta_2===2) {
              $regular++;
            }else if ($value->pregunta_2===3) {
              $aceptable++;
            }else if ($value->pregunta_2===4) {
              $bueno++;
            }else if ($value->pregunta_2===5) {
              $excelente++;
            }

            if ($value->pregunta_3===1) {
              $malo++;
            }else if ($value->pregunta_3===2) {
              $regular++;
            }else if ($value->pregunta_3===3) {
              $aceptable++;
            }else if ($value->pregunta_3===4) {
              $bueno++;
            }else if ($value->pregunta_3===5) {
              $excelente++;
            }

            if ($value->pregunta_4===1) {
              $malo++;
            }else if ($value->pregunta_4===2) {
              $regular++;
            }else if ($value->pregunta_4===3) {
              $aceptable++;
            }else if ($value->pregunta_4===4) {
              $bueno++;
            }else if ($value->pregunta_4===5) {
              $excelente++;
            }

            if ($value->pregunta_5===1) {
              $malo++;
            }else if ($value->pregunta_5===2) {
              $regular++;
            }else if ($value->pregunta_5===3) {
              $aceptable++;
            }else if ($value->pregunta_5===4) {
              $bueno++;
            }else if ($value->pregunta_5===5) {
              $excelente++;
            }

            if ($value->pregunta_6===1) {
              $malo++;
            }else if ($value->pregunta_6===2) {
              $regular++;
            }else if ($value->pregunta_6===3) {
              $aceptable++;
            }else if ($value->pregunta_6===4) {
              $bueno++;
            }else if ($value->pregunta_6===5) {
              $excelente++;
            }

            if ($value->pregunta_7===1) {
              $malo++;
            }else if ($value->pregunta_7===2) {
              $regular++;
            }else if ($value->pregunta_7===3) {
              $aceptable++;
            }else if ($value->pregunta_7===4) {
              $bueno++;
            }else if ($value->pregunta_7===5) {
              $excelente++;
            }

        }


        $json = [
          'malo'=>$malo,
          'regular'=>$regular,
          'aceptable'=>$aceptable,
          'bueno'=>$bueno,
          'excelente'=>$excelente
        ];

        return Response::json([
          'servicios'=>$servicios,
          'respuesta'=>true,
          'resultado'=>[$json]
        ]);

    }

    public function postServiciosano(){

      if (!Sentry::check()){

        return Response::json([
          'respuesta'=>'relogin'
        ]);

      }else{

        $ano = Input::get('ano');
        $centrodecosto = intval(Input::get('centrodecosto'));

        //CALCULAR POR MES LOS SERVICIOS POR CENTRO DE COSTO PARA SACAR EL AÑO
        function diasMes($mes,$ano){
          $dias =  date('t', mktime(0,0,0, $mes, 1, $ano));
          return $dias;
        }

        /*$dias_enero = diasMes(01,$ano);
        $dias_febrero = diasMes(02,$ano);
        $dias_marzo = diasMes(03,$ano);
        $dias_abril = diasMes(04,$ano);
        $dias_mayo = diasMes(05,$ano);
        $dias_junio = diasMes(06,$ano);
        $dias_julio = diasMes(07,$ano);
        $dias_agosto = diasMes(08,$ano);
        $dias_septiembre = diasMes(09,$ano);
        $dias_octubre = diasMes(10,$ano);
        $dias_noviembre = diasMes(11,$ano);
        $dias_diciembre = diasMes(12,$ano);

        $consulta_enero = "select count(*) from servicios where fecha_servicio between '".$ano."-01-01' and '".$ano."-01-".$dias_enero."' ";
        $consulta_febrero = "select count(*) from servicios where fecha_servicio between '".$ano."-02-01' and '".$ano."-02-".$dias_febrero."' ";
        $consulta_marzo = "select count(*) from servicios where fecha_servicio between '".$ano."-03-01' and '".$ano."-03-".$dias_marzo."' ";
        $consulta_abril = "select count(*) from servicios where fecha_servicio between '".$ano."-04-01' and '".$ano."-04-".$dias_abril."' ";
        $consulta_mayo = "select count(*) from servicios where fecha_servicio between '".$ano."-05-01' and '".$ano."-05-".$dias_mayo."' ";
        $consulta_junio = "select count(*) from servicios where fecha_servicio between '".$ano."-06-01' and '".$ano."-06-".$dias_junio."' ";
        $consulta_julio = "select count(*) from servicios where fecha_servicio between '".$ano."-07-01' and '".$ano."-07-".$dias_julio."' ";
        $consulta_agosto = "select count(*) from servicios where fecha_servicio between '".$ano."-08-01' and '".$ano."-08-".$dias_agosto."' ";
        $consulta_septiembre = "select count(*) from servicios where fecha_servicio between '".$ano."-09-01' and '".$ano."-09-".$dias_septiembre."' ";
        $consulta_octubre = "select count(*) from servicios where fecha_servicio between '".$ano."-10-01' and '".$ano."-10-".$dias_octubre."' ";
        $consulta_noviembre = "select count(*) from servicios where fecha_servicio between '".$ano."-11-01' and '".$ano."-11-".$dias_noviembre."' ";
        $consulta_diciembre = "select count(*) from servicios where fecha_servicio between '".$ano."-12-01' and '".$ano."-12-".$dias_diciembre."' ";

        if ($centrodecosto!=0) {

          $enero = DB::select($consulta_enero.'and centrodecosto_id = '.$centrodecosto);
          $febrero = DB::select($consulta_febrero.'and centrodecosto_id = '.$centrodecosto);
          $marzo = DB::select($consulta_marzo.'and centrodecosto_id = '.$centrodecosto);
          $abril = DB::select($consulta_abril.'and centrodecosto_id = '.$centrodecosto);
          $mayo = DB::select($consulta_mayo.'and centrodecosto_id = '.$centrodecosto);
          $junio = DB::select($consulta_junio.'and centrodecosto_id = '.$centrodecosto);
          $julio = DB::select($consulta_julio.'and centrodecosto_id = '.$centrodecosto);
          $agosto = DB::select($consulta_agosto.'and centrodecosto_id = '.$centrodecosto);
          $septiembre = DB::select($consulta_septiembre.'and centrodecosto_id = '.$centrodecosto);
          $octubre = DB::select($consulta_octubre.'and centrodecosto_id = '.$centrodecosto);
          $noviembre = DB::select($consulta_noviembre.'and centrodecosto_id = '.$centrodecosto);
          $diciembre = DB::select($consulta_diciembre.'and centrodecosto_id = '.$centrodecosto);

        }else{

          $enero = DB::select($consulta_enero);
          $febrero = DB::select($consulta_febrero);
          $marzo = DB::select($consulta_marzo);
          $abril = DB::select($consulta_abril);
          $mayo = DB::select($consulta_mayo);
          $junio = DB::select($consulta_junio);
          $julio = DB::select($consulta_julio);
          $agosto = DB::select($consulta_agosto);
          $septiembre = DB::select($consulta_septiembre);
          $octubre = DB::select($consulta_octubre);
          $noviembre = DB::select($consulta_noviembre);
          $diciembre = DB::select($consulta_diciembre);
        }


        return Response::json([
          'respuesta'=>true,
          'resultado'=>[$enero,$febrero,$marzo,$abril,$mayo,$junio,$julio,$agosto,$septiembre,$octubre,$noviembre,$diciembre]
        ]);*/

      }
    }

  }
