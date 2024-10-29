<?php

class Apiv2Controller extends BaseController{

    public function postServicioactivo()
    {

      ##BUSCAR SERVICIOS DEL CONDUCTOR QUE NO SE HAYAN FINALIZADO
      $user_id = intval(Input::get('id_usuario'));

      $conductor = Conductor::where('usuario_id', $user_id)->first();

      $fecha = date('Y-m-d');
      $diaanterior = strtotime('-1 day', strtotime($fecha));
      $diaanterior = date('Y-m-d', $diaanterior);

      $query = Conductor::where('usuario_id',$user_id)->pluck('estado_aplicacion');

      $servicio = Servicio::where('conductor_id', $conductor->id)
      ->whereBetween('fecha_servicio', [$diaanterior, $fecha])
      ->where('estado_servicio_app', 1)
      ->with(['centrodecosto'])
      ->first();


      if ($servicio) {

        return Response::json([
            'response' => true,
            'servicio' => $servicio,
            'estado' => $query
        ]);

      }else{

        return Response::json([
            'response' => false,
            'estado' => $query
        ]);

      }

    }

    
    //test gps
    public function postGpsactivo()
    {

      ##BUSCAR SERVICIOS DEL CONDUCTOR QUE NO SE HAYAN FINALIZADO
      $user_id = intval(Input::get('id_usuario'));

      $conductor = Conductor::where('usuario_id', $user_id)->first();
      if($conductor->estado_aplicacion == 1){
        return Response::json([
          'response' => true,
          'servicio' => $conductor
        ]);
      }else{
        return Response::json([
          'response' => false
        ]);
      }

    }
    //test gps

    public function postRecogerpasajero(){

      $servicio = Servicio::where('id', Input::get('servicio_id'))->with(['conductor', 'centrodecosto'])->first();

      $servicio->recoger_pasajero = 1;
      $servicio->recoger_pasajero_location = json_encode([
        'latitude' => Input::get('latitude'),
        'longitude' => Input::get('longitude'),
        'timestamp' => date('Y-m-d H:i:s')
      ]);

      if ($servicio->save()) {

        $pasajeros = explode('/', $servicio->pasajeros);

    		$nombres_pasajeros = '';

    		for ($i=0; $i < count($pasajeros); $i++) {
    			$nombre_pasajero = explode(',', $pasajeros[$i]);
    			$nombres_pasajeros .= $nombre_pasajero[0].' ';
    		}

    		$message = 'El conductor '.ucwords(strtolower($servicio->conductor->nombre_completo)).' ha recojido al pasajero(s): '.ucwords(strtolower($nombres_pasajeros)). ' del servicio de las '.$servicio->hora_servicio. ' horas de '.ucwords(strtolower($servicio->centrodecosto->razonsocial));

        Servicio::notificacionWeb($message);

        return Response::json([
          'response' => true,
          'servicio' => $servicio
        ]);

      }

    }

    public function postFinalizarservicio()
    {

      $servicio_id = Input::get('servicio_id');
      $ruta = Input::get('ruta');

      $servicio = Servicio::find($servicio_id);
      $servicio->estado_servicio_app = 2;
      $servicio->hora_finalizado = date('Y-m-d H:i:s');

      if ($servicio->save()) {

        /*$find = Cservicio::where('id_servicio',$servicio_id)->first();
        $find->s_finalizado = date('H:i');
        $find->save();
        $dat = $find->s_finalizado;
        $horaInicio = new DateTime('22:12');
        $horaTermino = new DateTime($dat);

        $interval = $horaInicio->diff($horaTermino);
        $intervalo = $interval->format('%H horas %i minutos %s seconds');*/

        return Response::json([
          'response' => true,
          //'time' => $intervalo,
          //'km' => $find->kilometros,
        ]);

      }else {

        return Response::json([
          'response' => false
        ]);

      }

    }

    public function postBuscarservicios()
    {

      $id_usuario = Input::get('id_usuario');
      $fecha = explode(',', Input::get('fecha'));

      $conductor_id = DB::table('conductores')
      ->where('usuario_id',$id_usuario)
      ->pluck('id');

      $servicios = Servicio::selectRaw('servicios.*, centrosdecosto.razonsocial as razonsocial,  subcentrosdecosto.nombresubcentro as subcentro, nombre_ruta.nombre as nombreruta, c_servicios.valor_total, c_servicios.valor_proveedor, facturacion.unitario_pagado')
      ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
      ->leftJoin('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
      ->leftJoin('nombre_ruta', 'servicios.ruta_nombre_id', '=', 'nombre_ruta.id')
      ->leftjoin('c_servicios','c_servicios.id_servicio', '=', 'servicios.id')
      ->leftjoin('facturacion','facturacion.servicio_id', '=', 'servicios.id')
      ->where('servicios.conductor_id', $conductor_id)
      ->whereIn('servicios.fecha_servicio', $fecha)
      ->whereNull('servicios.pendiente_autori_eliminacion')
      //->where('estado_servicio_app', 2)
      ->orderBy('servicios.fecha_servicio', 'asc')
      ->orderBy('servicios.hora_servicio', 'asc')
      ->get();

      if (count($servicios)) {

        return Response::json([
          'respuesta' => true,
          'servicios' => $servicios
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

}
