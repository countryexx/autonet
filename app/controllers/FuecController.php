<?php

  class FuecController extends BaseController {

    public function getIndex(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->administrativo->fuec->ver)){
            $ver = $permisos->administrativo->fuec->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {

            $proveedores = DB::table('proveedores')
            ->whereNull('inactivo_total')
            ->whereNull('inactivo')
            ->orderBy('razonsocial')
            ->get();

            $rutas_fuec = DB::table('rutas_fuec')->orderBy('origen')->get();
            $contratos = DB::table('contratos')->orderBy('contratante')->get();

            $array = [
              'proveedores'=>$proveedores,
              'rutas'=>$rutas_fuec,
              'contratos'=>$contratos,
              'permisos'=>$permisos
            ];
            return View::make('fuec.fuec',$array);
      }

    }

    public function postDocumentacionconductor(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          if (Request::ajax()) {

            /**
             * Para restringir a los conductores de la seguridad social toca tomar
             * la seguridad social del mes pasado y la seguridad social del mes actual y
             * adicional a eso tomar que solo pida la seguridad social del mes actual siempre y cuando
             * el dia del mes sea igual o mayor a 7
             *
             */

           if(Input::get('ruta_fecha_servicio')!=null){
             $fecha = Input::get('ruta_fecha_servicio');
           }else{
             $fecha = date('Y-m-d');
           }
            $conductor = Conductor::find(Input::get('id'));

            //$dia_mes = date('d');
            $dia_mes = date('d-');

            //Si el dia del mes es mayor o igual a 7 entonces buscar si hay un registro de seguridad social para el mes actual
            //if ($dia_mes>=7) {
            $date = date('Y-m-d');

            $seguridad_social = "select pago, fecha_inicial, fecha_final from seguridad_social where conductor_id = ".Input::get('id')." and '".$fecha."' between fecha_inicial and fecha_final ";
            $seguridad_social = DB::select($seguridad_social);

            if($seguridad_social!=null){
              foreach ($seguridad_social as $seg) {
                $value = $seg->pago;
              }
            }else{
              $value = null;
            }

            //}else if($dia_mes<7){

              /**
               *  Si el dia del mes es menor que 7 entonces revisar que haya seguridad social para el mes pasado.
               *  Si el mes es enero entonces debe restar un año y tomar el ano pasado y el mes 12
              */
            /*  if (date('m')==1) {

                $seguridad_social = Seguridadsocial::where('conductor_id', Input::get('id'))
                ->where('ano', date('Y')-1)
                ->where('mes', 12)
                ->pluck('pago');

              }else {

                $seguridad_social = Seguridadsocial::where('conductor_id', Input::get('id'))
                ->where('ano',date('Y'))
                ->where('mes', intval(date('m'))-1)
                ->pluck('pago');

              }

            }*/

            $vehicle = null;
            $licencia_conduccion = null;
            $dias_examen_ultimo = null;
            $fecha_examen_ultimo = null;

            if($conductor) {

              $licencia_conduccion = floor((strtotime($conductor->fecha_licencia_vigencia)-strtotime($fecha))/86400);

              $cond_examenes = DB::table('conductor_examenes')->where('conductor_id',Input::get('id'))
              ->orderBy('fecha_examen', 'desc')
              ->whereNull('anulado')->get();

              if($cond_examenes){
                  $fecha_examen_ultimo = $cond_examenes[0]->fecha_examen;
                  $dias_examen_ultimo = $cond_examenes[0]->fecha_examen;
                  $dias_examen_ultimo = floor((strtotime($dias_examen_ultimo)-strtotime($fecha))/86400);
              }else{
                    $dias_examen_ultimo = null;
                    $fecha_examen_ultimo = null;
              }

              $vehicle = DB::table('vehiculos')
              ->where('conductores_id',$conductor->id)
              ->first();
            }else{
              $array = [
                'respuesta'=>false
              ];

              return Response::json($array);
            }

            $vehiculo_conductor_pivot = VehiculoConductorPivot::where('conductor_id', Input::get('id'))->get();

            $array = [
              'respuesta'=>true,
              'conductor'=>$conductor,
              'vehiculo_conductor_pivot' => $vehiculo_conductor_pivot,
              'licencia_conduccion' => $licencia_conduccion,
              'seguridad_social' => $value,
              'dias_examen_ultimo' => $dias_examen_ultimo,
              'fecha_examen_ultimo' => $fecha_examen_ultimo,
              'ohhh' => $fecha,
              'vehicle' => $vehicle
            ];

            return Response::json($array);
          }
      }
    }

    public function postDocumentacionvehiculo(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          if (Request::ajax()) {

            //$vehiculo = Vehiculo::where('id', Input::get('id'))->with(['restriccionvehiculo'])->first();

            $vehiculo = Vehiculo::where('id', Input::get('id'))->with(['restriccionvehiculo' => function ($query) {
                $query->whereRaw("DATEDIFF(restriccion_vehiculos.fecha_vencimiento, now()) >= 0 and (restriccion_vehiculos.check is null or restriccion_vehiculos.check = 'off')");
            }])->first();

            $administracion = Administracion::where('vehiculo_id', Input::get('id'))
            ->where('ano',date('Y'))
            ->where('mes',date('m'))
            ->pluck('pago');

            $fecha_vigencia_operacion = Vehiculo::calculoCantidadDias($vehiculo->fecha_vigencia_operacion,Input::get('ruta_fecha_servicio'));
            $fecha_vigencia_soat = Vehiculo::calculoCantidadDias($vehiculo->fecha_vigencia_soat,Input::get('ruta_fecha_servicio'));
            $fecha_vigencia_tecnomecanica = Vehiculo::calculoCantidadDias($vehiculo->fecha_vigencia_tecnomecanica,Input::get('ruta_fecha_servicio'));
            $mantenimiento_preventivo = Vehiculo::calculoCantidadDias($vehiculo->mantenimiento_preventivo,Input::get('ruta_fecha_servicio'));
            $poliza_contractual = Vehiculo::calculoCantidadDias($vehiculo->poliza_contractual,Input::get('ruta_fecha_servicio'));
            $poliza_extracontractual = Vehiculo::calculoCantidadDias($vehiculo->poliza_extracontractual,Input::get('ruta_fecha_servicio'));

            return Response::json([
              'respuesta' => true,
              'vehiculo' => $vehiculo,
              'administracion'=> $administracion,
              'fecha_vigencia_operacion' => $fecha_vigencia_operacion,
              'fecha_vigencia_soat' => $fecha_vigencia_soat,
              'fecha_vigencia_tecnomecanica' => $fecha_vigencia_tecnomecanica,
              'mantenimiento_preventivo' => $mantenimiento_preventivo,
              'poliza_contractual' => $poliza_contractual,
              'poliza_extracontractual' => $poliza_extracontractual,
              'prueba' => Input::get('ruta_fecha_servicio')
            ], 200);

          }

      }

    }

    public function getExportarpdf($id){

      Excel::create('Fuec'.date('Y-m-d').'-'.rand(0,999), function($excel) use ($id){

        $excel->sheet('Hoja', function($sheet) use($id){

            $sheet->setWidth(array(
                'A' => 14,
                'B' => 12,
                'C' => 13,
                'D' => 13,
                'E' => 25,
                'F' => 5,
                'G' => 12
            ));

            $sheet->cells('A6', function($cells) {
              $cells->setAlignment('center');
              $cells->setValignment('center');
            });

            $sheet->cells('A15', function($cells) {
              $cells->setAlignment('left');
              $cells->setValignment('left ');
            });

            $sheet->mergeCells('A6:G6');
            $sheet->mergeCells('A8:G8');
            $sheet->mergeCells('A9:G9');
            $sheet->mergeCells('A10:G10');
            $sheet->mergeCells('A11:G11');

            $sheet->mergeCells('A13:G13');
            $sheet->mergeCells('A14:G14');
            $sheet->mergeCells('A15:G15');

            $sheet->mergeCells('A17:G17');
            $sheet->mergeCells('A18:G18');

            $sheet->mergeCells('A19:C19');
            $sheet->mergeCells('F19:G19');
            $sheet->mergeCells('A20:C20');
            $sheet->mergeCells('F20:G20');
            $sheet->mergeCells('A21:G21');
            $sheet->mergeCells('B22:C22');
            $sheet->mergeCells('E22:G22');
            $sheet->mergeCells('B23:C23');
            $sheet->mergeCells('E23:G23');
            $sheet->mergeCells('A24:C24');
            $sheet->mergeCells('D24:G24');
            $sheet->mergeCells('A25:C25');
            $sheet->mergeCells('D25:G25');

            $fuec = DB::table('fuec')
                ->select('contratos.numero_contrato','fuec.consecutivo','contratos.contratante','contratos.nit_contratante','contratos.cliente','contratos.representante_legal',
                'contratos.cc_representante','contratos.telefono_representante','contratos.direccion_representante', 'vehiculos.ano as vehiculo_ano',
                'fuec.objeto_contrato','fuec.ano','rutas_fuec.ruta as descripcion_ruta','rutas_fuec.origen','rutas_fuec.destino','fuec.fecha_inicial','fuec.fecha_final',
                'vehiculos.placa','vehiculos.modelo','vehiculos.modelo','vehiculos.marca','vehiculos.clase','vehiculos.numero_interno','vehiculos.tarjeta_operacion',
                'fuec.conductor','vehiculos.empresa_afiliada','fuec.colegio')
                ->leftJoin('vehiculos','fuec.vehiculo','=','vehiculos.id')
                ->leftJoin('contratos','fuec.contrato_id','=','contratos.id')
                ->leftJoin('rutas_fuec','fuec.ruta_id','=','rutas_fuec.id')
                ->where('fuec.id',$id)
                ->first();

            $sheet->getStyle('A26')->getAlignment()->setWrapText(true);

            $sheet->getStyle('A28')->getAlignment()->setWrapText(true);

            $sheet->getStyle('A30')->getAlignment()->setWrapText(true);


            $sheet->getStyle('A26')
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $sheet->getStyle('A15:G15')
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $sheet->getStyle('A29:G29')
            ->getAlignment()
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $sheet->getStyle('A30:G30')
            ->getAlignment()
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $sheet->getStyle('A31:G31')
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $sheet->setHeight(6, 30);
            $sheet->setHeight(15, 30);

            $sheet->getStyle('A15')->getAlignment()->setWrapText(true);
            $sheet->getStyle('A18')->getAlignment()->setWrapText(true);
            $sheet->getStyle('A6')->getAlignment()->setWrapText(true);

            $styleArray = array(
              'borders' => array(
                'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
                )
              )
            );

            $sheet->getStyle('A6:G6')->applyFromArray($styleArray);
            $sheet->getStyle('A8:G8')->applyFromArray($styleArray);
            $sheet->getStyle('A9:G9')->applyFromArray($styleArray);
            $sheet->getStyle('A10:G10')->applyFromArray($styleArray);
            $sheet->getStyle('A11:G11')->applyFromArray($styleArray);
            $sheet->getStyle('A13:G13')->applyFromArray($styleArray);
            $sheet->getStyle('A14:G14')->applyFromArray($styleArray);
            $sheet->getStyle('A15:G15')->applyFromArray($styleArray);
            $sheet->getStyle('A17:G17')->applyFromArray($styleArray);
            $sheet->getStyle('A18:G18')->applyFromArray($styleArray);
            $sheet->getStyle('A19:G19')->applyFromArray($styleArray);
            $sheet->getStyle('A20:G20')->applyFromArray($styleArray);
            $sheet->getStyle('A21:G21')->applyFromArray($styleArray);
            $sheet->getStyle('A22:G22')->applyFromArray($styleArray);
            $sheet->getStyle('A23:G23')->applyFromArray($styleArray);
            $sheet->getStyle('A24:G24')->applyFromArray($styleArray);
            $sheet->getStyle('A25:G25')->applyFromArray($styleArray);

            $arrayidc = explode(',',$fuec->conductor);
            $numero = 6;
            $contado = count($arrayidc);
            $solo = 0;

            for ($o=0; $o<count($arrayidc); $o++) {

                if (intval($o)===2) {
                  $sheet->getStyle('A3'.($numero).':G3'.($numero))->applyFromArray($styleArray);
                  $sheet->getStyle('A3'.($numero+1).':G3'.($numero+1))->applyFromArray($styleArray);
                  if (intval($contado)===3) {
                    $sheet->setHeight(32, 21);
                    $sheet->setHeight(33, 21);
                    $sheet->getStyle('A32')->getAlignment()->setWrapText(true);
                    $sheet->getStyle('A33')->getAlignment()->setWrapText(true);
                  }

                }else if (intval($o)===1) {
                  $numero = 0;
                  $sheet->getStyle('A3'.($numero).':G3'.($numero))->applyFromArray($styleArray);
                  $sheet->getStyle('A3'.($numero+1).':G3'.($numero+1))->applyFromArray($styleArray);
                  if (intval($contado)===2) {
                    $sheet->setHeight(30, 21);
                    $sheet->setHeight(31, 21);
                  }
                }else if (intval($o)===0) {
                  $sheet->getStyle('A2'.$numero.':G2'.$numero)->applyFromArray($styleArray);
                  $sheet->getStyle('A2'.($numero+1).':G2'.($numero+1))->applyFromArray($styleArray);
                  $sheet->getStyle('A2'.($numero+2).':G2'.($numero+2))->applyFromArray($styleArray);
                  $sheet->getStyle('A2'.($numero+3).':G2'.($numero+3))->applyFromArray($styleArray);
                  if (intval($contado)===1) {
                    $sheet->setHeight(28, 21);
                    $sheet->setHeight(29, 21);
                  }

                }

                $numero = $numero+2;
            }

            unset($styleArray);

            $objDrawing = new PHPExcel_Worksheet_Drawing;
            $objDrawing->setPath('biblioteca_imagenes/mintransporte.png');
            $objDrawing->setCoordinates('A2');
            $objDrawing->setResizeProportional(false);
            $objDrawing->setWidth(380);
            $objDrawing->setHeight(80);
            $objDrawing->setWorksheet($sheet);

            $objDrawing = new PHPExcel_Worksheet_Drawing;
            $objDrawing->setPath('biblioteca_imagenes/logo_excel.png');
            $objDrawing->setCoordinates('E2');
            $objDrawing->setResizeProportional(false);
            $objDrawing->setWidth(280);
            $objDrawing->setHeight(80);
            $objDrawing->setWorksheet($sheet);

            //$sheet->protect('xmnuy20hj');

            $sheet->loadView('fuec.formatoexcel')->with([
                'fuec'=>$fuec,
                'arrayidc'=>$arrayidc
            ]);

        })->download('xls');

      });
    }

    public function postNuevo(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          if (Request::ajax()) {

            $validaciones = [
                'contrato_id'=>'required|numeric',
                'ruta'=>'required',
                'objeto_contrato'=>'required',
                'fecha_inicial'=>'required|date_format:Y-m-d',
                'fecha_final'=>'required|date_format:Y-m-d',
                'proveedor'=>'required',
                'vehiculo'=>'required',
                'arrayId'=>'required'
            ];

            $mensajes = [
                'contrato.numeric'=>'El campo contrato debe ser numerico',
                'contrato.required'=>'El campo contrato es requerido',
                'ruta.required'=>'El campo ruta es requerido',
                'objeto_contrato.required'=>'El campo objeto contrato es requerido',
                'fecha_inicial.required'=>'El campo fecha inicial es requerido',
                'fecha_final.required'=>'El campo fecha final es requerido',
                'proveedor.required'=>'El campo proveedor es requerido',
                'vehiculo.required'=>'El campo vehiculo es requerido',
                'arrayId.required'=>'El campo conductor es requerido'
            ];

            $validador = Validator::make(Input::all(), $validaciones,$mensajes);

            if ($validador->fails()){

                return Response::json([
                    'mensaje'=>false,
                    'errores'=>$validador->errors()->getMessages()
                ]);

            }else{

              //TODOS LOS REGISTROS Y SE TOMA EL ULTIMO REGISTRO GUARDADO
              $fuec_ultimo = Fuec::all();
              $ultimo = $fuec_ultimo->last();

              if ($ultimo!=null) {

                $ultimo_ano = intval($ultimo->ano);
                $ultimo = intval($ultimo->consecutivo);

              }else if($ultimo===null) {

                $ultimo = intval($ultimo);
                $ultimo_ano = 0;
              }

              $fuec = new Fuec;
              $fuec->ano = date('Y');
              $fuec->contrato_id = Input::get('contrato_id');
              $fuec->ruta_id = Input::get('ruta');
              $fuec->objeto_contrato = Input::get('objeto_contrato');
              $fuec->colegio = Input::get('colegio');
              $fuec->fecha_inicial = Input::get('fecha_inicial');
              $fuec->fecha_final = Input::get('fecha_final');
              $fuec->proveedor = Input::get('proveedor');
              $fuec->vehiculo = Input::get('vehiculo');
              $fuec->conductor = Input::get('arrayId');
              $fuec->creado_por = Sentry::getUser()->id;

              if ($fuec->save()) {

                //TOMAR ID PARA BUSCAR EL ULTIMO REGISTRO GUARDADO
                $id = $fuec->id;
                $ano = intval($fuec->ano);
                $f = Fuec::find($id);

                //SI ESTA VACIO ENTONCES ES IGUAL A CERO
                if ($ultimo===0 or (intval($ultimo_ano)!=intval($ano))) {
                  $f->consecutivo = '0001';
                //SI NO ESTA VACIO ENTONCES
                }else if ($ultimo!=0){

                    if (strlen($ultimo+1)===1) {

                      $f->consecutivo = '000'.($ultimo+1);

                    }else if (strlen($ultimo+1)===2) {

                      $f->consecutivo = '00'.($ultimo+1);

                    }else if (strlen($ultimo+1)===3) {

                      $f->consecutivo = '0'.($ultimo+1);

                    }else if (strlen($ultimo+1)===4) {

                      $f->consecutivo = $ultimo+1;

                    }
                }

                if ($f->save()) {
                  return Response::json([
                    'respuesta'=>true,
                    'fuec_ultimo'=>$fuec_ultimo,
                    'ultimo'=>$ultimo
                  ]);
                }
              }
            }
          }
      }
    }

    public function postActualizar(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if (Request::ajax()) {

                $validaciones = [
                    'contrato'=>'required|numeric',
                    'ruta'=>'required',
                    'objeto_contrato'=>'required',
                    'fecha_inicial'=>'required|date_format:Y-m-d',
                    'fecha_final'=>'required|date_format:Y-m-d',
                    'proveedor'=>'required',
                    'vehiculo'=>'required',
                    'arrayId'=>'required'
                ];

                $mensajes = [
                    'contrato.numeric'=>'El campo contrato debe ser numerico',
                    'contrato.required'=>'El campo contrato es requerido',
                    'ruta.required'=>'El campo ruta es requerido',
                    'objeto_contrato.required'=>'El campo objeto contrato es requerido',
                    'fecha_inicial.required'=>'El campo fecha inicial es requerido',
                    'fecha_final.required'=>'El campo fecha final es requerido',
                    'proveedor.required'=>'El campo proveedor es requerido',
                    'vehiculo.required'=>'El campo vehiculo es requerido',
                    'arrayId.required'=>'El campo conductor es requerido'
                ];

                $validador = Validator::make(Input::all(), $validaciones,$mensajes);

                if ($validador->fails()){

                    return Response::json([
                        'mensaje'=>false,
                        'errores'=>$validador->errors()->getMessages()
                    ]);

                }else{

                    $fuec = Fuec::find(Input::get('id'));
                    $fuec->contrato_id = Input::get('contrato');
                    $fuec->ruta_id = Input::get('ruta');
                    $fuec->objeto_contrato = Input::get('objeto_contrato');
                    $fuec->colegio = Input::get('colegio');
                    $fuec->fecha_inicial = Input::get('fecha_inicial');
                    $fuec->fecha_final = Input::get('fecha_final');
                    $fuec->proveedor = Input::get('proveedor');
                    $fuec->vehiculo = Input::get('vehiculo');
                    $fuec->conductor = Input::get('arrayId');
                    $fuec->creado_por = Sentry::getUser()->id;

                    if ($fuec->save()) {
                        return Response::json([
                            'respuesta'=>true
                        ]);
                    }
                }
            }
        }
    }

    public function getListado(){

        if (Sentry::check()) {
            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
        }else{
            $id_rol = null;
            $permisos = null;
            $permisos = null;
        }

        if (isset($permisos->administrativo->fuec->ver)){
            $ver = $permisos->administrativo->fuec->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {

          $proveedores = DB::table('proveedores')
          ->whereNull('inactivo_total')
          ->orderBy('razonsocial')
          ->get();
          $array = [
            'proveedores'=>$proveedores
          ];
          return View::make('fuec.listado',$array);
      }
    }

    public function getListadovencimiento(){

        if (Sentry::check()) {
            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
        }else{
            $id_rol = null;
            $permisos = null;
            $permisos = null;
        }

        if (isset($permisos->administrativo->fuec->ver)){
            $ver = $permisos->administrativo->fuec->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {

          $date = date('Y-m-d');

          $proveedores = DB::table('proveedores')
          ->whereNull('inactivo_total')
          ->orderBy('razonsocial')
          ->get();

          $vencimientos = DB::table('fuec')
          ->leftJoin('proveedores', 'proveedores.id', '=', 'fuec.proveedor')
          ->leftJoin('conductores', 'conductores.id', '=', 'fuec.conductor')
          ->leftJoin('vehiculos', 'vehiculos.id', '=', 'fuec.vehiculo')
          ->select('fuec.*', 'conductores.nombre_completo', 'vehiculos.placa', 'proveedores.razonsocial')
          ->whereNull('proveedores.inactivo')
          ->whereNull('proveedores.inactivo_total')
          ->whereNull('conductores.bloqueado')
          ->whereNull('conductores.bloqueado_total')
          ->whereNull('vehiculos.bloqueado')
          ->whereNull('vehiculos.bloqueado_total')
          ->where('fuec.fecha_inicial', '<=', $date)
          ->where('fuec.fecha_final', '>=', $date)
          ->orderBy('fuec.fecha_final')
          ->groupBy('fuec.fecha_final', 'fuec.conductor', 'fuec.vehiculo')
          ->get();

          $array = [
            'proveedores'=>$vencimientos
          ];
          return View::make('fuec.nuevo.vencimiento',$array);
      }
    }

    public function getListadonuevo(){

        if (Sentry::check()) {
            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
        }else{
            $id_rol = null;
            $permisos = null;
            $permisos = null;
        }

        if (isset($permisos->administrativo->fuec->crear)){
            $ver = $permisos->administrativo->fuec->crear;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {

          $proveedores = DB::table('proveedores')
          ->whereNull('inactivo_total')
          ->orderBy('razonsocial')
          ->get();

          $rutas_fuec = DB::table('rutas_fuec')
          ->get();

          $array = [
            'proveedores' => $proveedores,
            'rutas_fuec' => $rutas_fuec
          ];
          return View::make('fuec.nuevo.generar_fuec',$array);
      }
    }

    public function postProveedores(){

      $localidad = Input::get('ciudad');

      /*CONDUCTORES: FALTA EXÁMENES*/
      /*VEHÍCULOS: FALTA ADMINISTRACIÓN*/

      $proveedores = DB::table('proveedores')
      ->leftJoin('conductores', 'conductores.proveedores_id', '=', 'proveedores.id')
      ->leftJoin('vehiculos', 'vehiculos.proveedores_id', '=', 'proveedores.id')
      ->select('proveedores.*', 'vehiculos.id as id_vehiculo', 'vehiculos.placa', 'vehiculos.fecha_vigencia_operacion', 'vehiculos.fecha_vigencia_soat', 'vehiculos.fecha_vigencia_tecnomecanica', 'vehiculos.mantenimiento_preventivo', 'vehiculos.poliza_contractual','vehiculos.poliza_extracontractual', 'conductores.id as id_conductor', 'conductores.nombre_completo', 'conductores.fecha_licencia_vigencia')
      ->where('proveedores.localidad', $localidad)
      ->whereNull('proveedores.inactivo')//PROVEEDORES
      ->whereNull('proveedores.inactivo_total')//PROVEEDORES
      ->whereNull('conductores.bloqueado')//CONDUCTORES
      ->whereNull('conductores.bloqueado_total')//CONDUCTORES
      ->whereNull('vehiculos.bloqueado')//VEHICULOS
      ->whereNull('vehiculos.bloqueado_total')//VEHICULOS
      ->get();

      $conductores_array = [];
      $examenes_array = [];
      $administracion_array = [];
      $i = 0;
      $date = date('Y-m-d');

      foreach ($proveedores as $conductor) {

        //$ss = "select seguridad_social.fecha_inicial, seguridad_social.fecha_final from seguridad_social where conductor_id = ".$conductor->id_conductor." and fecha_inicial < '".$date."' and fecha_final > '".$date."'";

        //start Administración
        $administracion = Administracion::where('vehiculo_id', $conductor->id_vehiculo)
        ->where('ano',date('Y'))
        ->where('mes',date('m'))
        ->pluck('pago');

        if($administracion!=null){
          $administracion_array[$i] = 1;
        }else{
          $administracion_array[$i] = 0;
        }
        //end administración

        //start seguridad social
        $ss = DB::table('seguridad_social')
        ->where('conductor_id',$conductor->id_conductor)
        ->where('fecha_inicial', '<=', $date)
        ->where('fecha_final', '>=', $date)
        ->orderBy('fecha_final', 'desc')
        ->first();

        if($ss!=null){
          $conductores_array[$i] = $ss->fecha_final;
        }else{
          $conductores_array[$i] = 0;
        }
        //end administración

        //start exámenes
        $cond_examenes = DB::table('conductor_examenes')->where('conductor_id',$conductor->id_conductor)
        ->orderBy('fecha_examen', 'desc')
        ->whereNull('anulado')->get();

        if($cond_examenes){
            $fecha_examen_ultimo = $cond_examenes[0]->fecha_examen;
            $dias_examen_ultimo = $cond_examenes[0]->fecha_examen;
            $dias_examen_ultimo = floor((strtotime($dias_examen_ultimo)-strtotime(date('Y-m-d')))/86400);
            $examenes_array[$i] = $dias_examen_ultimo;
        }else{
              $dias_examen_ultimo = null;
              $fecha_examen_ultimo = null;
              $examenes_array[$i] = $dias_examen_ultimo;
        }
        //end administración
        $i++;

      }

      return Response::json([
        'response' => true,
        'proveedores' => $proveedores,
        'fecha_actual' => date('Y-m-d'),
        'conductores' => $conductores_array,
        'examenes' => $examenes_array,
        'administracion' => $administracion_array
      ]);

    }

    public function postFiltroclientes() {

      $localidad = Input::get('ciudad');

      $clientes = DB::table('centrosdecosto')
      ->whereIn('localidad', [$localidad,'provisional'])
      ->whereNull('inactivo')
      ->whereNull('inactivo_total')
      ->get();

      return Response::json([
        'response' => true,
        'clientes' => $clientes
      ]);

    }

    public function postFuecs(){

      $proveedores = Input::get('proveedores');
      $conductores = Input::get('conductores');
      $vehiculos = Input::get('vehiculos');
      $rutas = Input::get('rutas');
      $clientes = Input::get('clientes');

      $objeto_contrato = 'TRANSPORTE TERRESTRE DE PERSONAL EMPRESARIAL';

      $contador_fuec = Input::get('contador_fuec');

      if($contador_fuec===null){
        $contador_fuec = 0;
      }

      /*$soat = DB::table('vehiculos')
      ->where('id',$id_vehiculo)
      ->first();*/

      $arrayRutas = explode(',' , $rutas);
      $arrayClientes = explode(',' , $clientes);

      $arrayProveedores = explode(',' , $proveedores);
      $arrayConductores = explode(',' , $conductores);
      $arrayVehiculos = explode(',' , $vehiculos);

      $contador = Input::get('contador');
      if($contador===null){
        $contador = 0;
      }else{
        $contador = $contador+1;
      }

      $cantidad_de_rutas = count($arrayRutas);
      $cantidad_proveedores = count($arrayProveedores);

      /* -start- Inserción de datos para la creación de Fuec Másivo */
      for ($a=$contador; $a == $contador; $a++) {

        for ($b=0; $b<count($arrayClientes); $b++) {

          $contrato = DB::table('contratos')
          ->where('centrodecosto_id', $arrayClientes[$b])
          ->first();

          for ($c=0; $c<count($arrayProveedores); $c++) {

            /*Inserción code*/
            //TODOS LOS REGISTROS Y SE TOMA EL ULTIMO REGISTRO GUARDADO
            $fuec_ultimo = Fuec::all();
            $ultimo = $fuec_ultimo->last();

            if ($ultimo!=null) {

              $ultimo_ano = intval($ultimo->ano);
              $ultimo = intval($ultimo->consecutivo);

            }else if($ultimo===null) {

              $ultimo = intval($ultimo);
              $ultimo_ano = 0;

            }

            $documentos = DB::table('vehiculos')
            ->where('id', $arrayVehiculos[$c])
            ->first();

            $date = date('Y-m-d');

            $ss = DB::table('seguridad_social')
            ->where('conductor_id',$arrayConductores[$c])
            ->where('fecha_inicial', '<=', $date)
            ->where('fecha_final', '>=', $date)
            ->orderBy('fecha_final', 'desc')
            ->first();

            if($ss!=null){
              $fecha_seguridad = $ss->fecha_final;
            }else{
              $fecha_seguridad = 0;
            }

            $soat = $documentos->fecha_vigencia_soat;
            $poliza_contractual = $documentos->poliza_contractual;
            $poliza_extracontractual = $documentos->poliza_extracontractual;
            $mantenimiento_preventivo = $documentos->mantenimiento_preventivo;
            $tecnomecanica = $documentos->fecha_vigencia_tecnomecanica;
            $tarjeta_operacion = $documentos->fecha_vigencia_operacion;

            $fecha_final = $soat;
            if($poliza_contractual<$fecha_final){
              $fecha_final = $poliza_contractual;
            }
            if($poliza_extracontractual<$fecha_final){
              $fecha_final = $poliza_extracontractual;
            }
            if($mantenimiento_preventivo<$fecha_final){
              $fecha_final = $mantenimiento_preventivo;
            }
            if($tecnomecanica<$fecha_final){
              $fecha_final = $tecnomecanica;
            }
            if($tarjeta_operacion<$fecha_final){
              $fecha_final = $tarjeta_operacion;
            }

            if($fecha_seguridad!=0){
              if($fecha_seguridad<$fecha_final){
                $fecha_final = $fecha_seguridad;
              }
            }

            //$fecha_final = $documentos->soat

            $fuec = new Fuec;
            $fuec->ano = date('Y');
            $fuec->contrato_id = $contrato->id;
            $fuec->ruta_id = $arrayRutas[$a];
            $fuec->objeto_contrato = $objeto_contrato;
            //$fuec->colegio = Input::get('colegio');
            $fuec->fecha_inicial = date('Y-m-d');
            $fuec->fecha_final = $fecha_final;
            $fuec->proveedor = $arrayProveedores[$c];
            $fuec->vehiculo = $arrayVehiculos[$c];
            $fuec->conductor = $arrayConductores[$c];
            $fuec->creado_por = Sentry::getUser()->id;

            if ($fuec->save()) {
              $contador_fuec = $contador_fuec+1;
              //TOMAR ID PARA BUSCAR EL ULTIMO REGISTRO GUARDADO
              $id = $fuec->id;
              $ano = intval($fuec->ano);
              $f = Fuec::find($id);

              //SI ESTA VACIO ENTONCES ES IGUAL A CERO
              if ($ultimo===0 or (intval($ultimo_ano)!=intval($ano))) {
                $f->consecutivo = '0001';
              //SI NO ESTA VACIO ENTONCES
              }else if ($ultimo!=0){

                  if (strlen($ultimo+1)===1) {

                    $f->consecutivo = '000'.($ultimo+1);

                  }else if (strlen($ultimo+1)===2) {

                    $f->consecutivo = '00'.($ultimo+1);

                  }else if (strlen($ultimo+1)===3) {

                    $f->consecutivo = '0'.($ultimo+1);

                  }else if (strlen($ultimo+1)===4) {

                    $f->consecutivo = $ultimo+1;

                  }
              }

            $f->save();

            }
            /*Inserción code*/

          }

        }

      }
      /* -end- Inserción de datos para la creación de Fuec Másivo */

      if($contador==($cantidad_de_rutas-1)){

        return Response::json([
          'response'=>false,
          'contador_fuec' => $contador_fuec,
          'cantidad_proveedores' => $cantidad_proveedores
        ]);

      }else{

        return Response::json([
          'response'=>true,
          'proveedores' => $proveedores,
          'conductores' => $conductores,
          'vehiculos' => $vehiculos,
          'rutas' => $rutas,
          'clientes' => $clientes,
          'contador_fuec' => $contador_fuec,
          'contador' => $contador,
          'cantidad_de_rutas' => $cantidad_de_rutas
        ]);

      }

      /*return Response::json([
        'response' => true,
        'arrarProveedores' => $arrarProveedores,
        'id_conductor' => $id_vehiculo,
        'arrayRutas' => $arrayRutas,
        'arrayConductores' => $arrayConductores,
        'clientes' => $clientes,
        'objeto_contrato' => $objeto_contrato,
        'documentación' => $soat
      ]);*/

    }

    public function getListadogeneral(){

      if (!Sentry::check()){
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{
        $fuec = DB::table('fuec')
        ->leftJoin('vehiculos','fuec.vehiculo','=','vehiculos.id')
        ->get();

        $array = [
          'fuec'=>$fuec
        ];

        return View::make('fuec.fuec_general', $array);
      }
    }

    public function postMostrar(){

      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      if (!Sentry::check())
      {
          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else {

          if(Request::ajax()){

            if (intval(Input::get('proveedor_id'))===0) {

              $vehiculos = DB::table('proveedores')
              ->select('proveedores.id','proveedores.razonsocial','vehiculos.placa','vehiculos.marca','vehiculos.modelo','vehiculos.ano','vehiculos.id as vehiculo_id')
              ->leftJoin('vehiculos','proveedores.id','=','vehiculos.proveedores_id')
              ->orderBy('razonsocial')
              ->get();

              if ($vehiculos!=null) {
                $array = [
                  'respuesta'=>true,
                  'vehiculos'=>$vehiculos
                ];
              }else{
                $array = [
                  'respuesta'=>false,
                  '1'=>'1'
                ];
              }

            }else if(intval(Input::get('proveedor_id'))!=0){

              $vehiculos = DB::table('proveedores')
              ->select('proveedores.id','proveedores.razonsocial','vehiculos.placa','vehiculos.marca','vehiculos.modelo','vehiculos.ano','vehiculos.id as vehiculo_id')
              ->leftJoin('vehiculos','proveedores.id','=','vehiculos.proveedores_id')
              ->where('vehiculos.proveedores_id',Input::get('proveedor_id'))
              ->orderBy('vehiculos.marca')
              ->get();

              if ($vehiculos!=null) {
                $array = [
                  'respuesta'=>true,
                  'vehiculos'=>$vehiculos,
                  'permisos'=>$permisos
                ];
              }else{
                $array = [
                  'respuesta'=>false,
                  '2'=>'2',
                  'permisos'=>$permisos
                ];
              }
            }

            return Response::json($array);
          }
      }
    }

    public function getVer($id){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->administrativo->fuec->ver)){
            $ver = $permisos->administrativo->fuec->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {

          return View::make('admin.permisos');

        }else {

            $fuec = Fuec::where('vehiculo', $id)->with(['vehiculo'])->orderBy('id', 'desc')->get();

            $vehiculo = Vehiculo::find($id);

            /*
            $fuec = DB::table('fuec')
            ->select('fuec.id','contratos.numero_contrato', 'contratos.contratante','contratos.nit_contratante',
            'fuec.fecha_inicial','fuec.fecha_final','fuec.consecutivo', 'rutas_fuec.origen', 'rutas_fuec.destino')
            ->leftJoin('contratos', 'fuec.contrato_id', '=', 'contratos.id')
            ->leftJoin('rutas_fuec', 'fuec.ruta_id', '=', 'rutas_fuec.id')
            ->where('fuec.vehiculo',$id)
            ->orderBy('id', 'desc')
            ->get();*/

            return View::make('fuec.verfuec')
            ->with([
                'fuec' => $fuec,
                'vehiculo' => $vehiculo,
                'permisos' => $permisos
            ]);

        }
    }

    public function getEditar($id){

        if (!Sentry::check()){
            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
        }else {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);


            $proveedores = DB::table('proveedores')
            ->whereNull('inactivo_total')
            ->orderBy('razonsocial')
            ->get();
            $fuec = DB::table('fuec')
                ->select('contratos.numero_contrato','contratos.contratante','contratos.nit_contratante','fuec.consecutivo',
                'fuec.objeto_contrato','fuec.ruta_id','fuec.fecha_inicial','fuec.fecha_final','vehiculos.placa','fuec.colegio',
                'vehiculos.modelo','vehiculos.modelo','vehiculos.marca','vehiculos.clase','vehiculos.numero_interno',
                'vehiculos.tarjeta_operacion','fuec.proveedor','fuec.vehiculo','fuec.conductor','fuec.id','fuec.contrato_id',
                'fuec.conductor','vehiculos.empresa_afiliada', 'users.first_name', 'users.last_name')
                ->leftJoin('vehiculos','fuec.vehiculo','=','vehiculos.id')
                ->leftJoin('contratos','fuec.contrato_id','=','contratos.id')
                ->leftJoin('users','fuec.creado_por','=','users.id')
                ->where('fuec.id',$id)
                ->first();
            $array = [
                'proveedores' => $proveedores,
                'fuec'=>$fuec,
                'permisos'=>$permisos
            ];
            return View::make('fuec.fuec_editar', $array);
        }
    }

    public function postNuevoruta(){

      if (!Sentry::check())
      {
          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else {

          if(Request::ajax()){

            $rutas_fuec = new Rutafuec;
            $rutas_fuec->origen = Input::get('origen');
            $rutas_fuec->destino = Input::get('destino');
            $rutas_fuec->ruta = Input::get('ruta');
            $rutas_fuec->creado_por = Sentry::getUser()->id;
            if ($rutas_fuec->save()) {
              $array = [
                'respuesta'=>true
              ];
              return Response::json($array);
            }
          }
      }
    }

    public function postVerrutafuec(){

      if (!Sentry::check())
      {
          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else {

          if(Request::ajax()){

            $rutas_fuec = Rutafuec::find(Input::get('id'));

            return Response::json([
              'respuesta'=>true,
              'rutas_fuec'=>$rutas_fuec
            ]);

          }

      }

    }

    public function postEditarrutafuec(){

      if (!Sentry::check())
      {
          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else {

          if(Request::ajax()){

            $rutas_fuec = Rutafuec::find(Input::get('id'));
            $rutas_fuec->origen = Input::get('origen');
            $rutas_fuec->destino = Input::get('destino');
            $rutas_fuec->ruta = Input::get('ruta');

            if ($rutas_fuec->save()) {
              return Response::json([
                'respuesta'=>true,
                'rutas_fuec'=>$rutas_fuec
              ]);
            }

          }

      }

    }

    public function postMostrarrutas(){

      if (!Sentry::check())
      {
          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else {

          if(Request::ajax()){

            $ruta_descripcion = DB::table('rutas_fuec')->where('id',Input::get('id'))->pluck('ruta');
            if ($ruta_descripcion!=null) {
              return Response::json([
                'respuesta'=>true,
                'ruta_descripcion'=>$ruta_descripcion
              ]);
            }else{
              return Response::json([
                'respuesta'=>false
              ]);
            }

          }
      }
    }

    public function postCargarruta(){


      if (!Sentry::check())
      {
          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else {

          if(Request::ajax()){

            $rutas = DB::table('rutas_fuec')->orderBy('destino')->get();
            return Response::json([
              'cargado'=>true,
              'rutas'=>$rutas
            ]);

          }
      }
    }

  	public function getExportarfuecpdf($id){

        if (!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else{

          $fuec = DB::table('fuec')
            ->select('contratos.numero_contrato','fuec.consecutivo', 'fuec.id','contratos.contratante','contratos.nit_contratante','contratos.cliente','contratos.representante_legal',
            'contratos.cc_representante','contratos.telefono_representante','contratos.direccion_representante', 'vehiculos.ano as vehiculo_ano',
            'fuec.objeto_contrato','fuec.ano','rutas_fuec.ruta as descripcion_ruta','rutas_fuec.origen','rutas_fuec.destino','fuec.fecha_inicial','fuec.fecha_final',
            'vehiculos.placa','vehiculos.modelo','vehiculos.modelo','vehiculos.marca','vehiculos.clase','vehiculos.numero_interno','vehiculos.tarjeta_operacion',
            'fuec.conductor','vehiculos.empresa_afiliada','fuec.colegio')
            ->leftJoin('vehiculos','fuec.vehiculo','=','vehiculos.id')
            ->leftJoin('contratos','fuec.contrato_id','=','contratos.id')
            ->leftJoin('rutas_fuec','fuec.ruta_id','=','rutas_fuec.id')
            ->where('fuec.id',$id)
            ->first();

          $arrayidc = explode(',',$fuec->conductor);

          $html = View::make('fuec.pdf_fuec')->with([
            'fuec' => $fuec,
            'arrayidc' => $arrayidc,
            'numero_encriptado' => $fuec->id
          ]);

          //return $html;

          return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('FUEC'.$fuec->consecutivo);

        }
  	}

    public function postEnviarfuecmail(){

      if (Request::ajax()) {

        $validaciones = [
            'email' => 'required|email'
        ];

        $validador = Validator::make(Input::all(), $validaciones);

        if ($validador->fails()){

            return Response::json([
                'response' => false,
                'errores' => $validador->errors()->getMessages()
            ]);

        }else{

          $fuecidArray = Input::get('fuecidArray');

          $email_destino = Input::get('email');

          $fuecs = DB::table('fuec')
            ->select('contratos.numero_contrato','fuec.consecutivo', 'fuec.id as fuec_id','contratos.contratante',
            'contratos.nit_contratante', 'contratos.cliente','contratos.representante_legal', 'contratos.cc_representante',
            'contratos.telefono_representante', 'contratos.direccion_representante', 'vehiculos.ano as vehiculo_ano',
            'fuec.objeto_contrato','fuec.ano', 'rutas_fuec.ruta as descripcion_ruta','rutas_fuec.origen','rutas_fuec.destino',
            'fuec.fecha_inicial','fuec.fecha_final', 'vehiculos.placa','vehiculos.modelo','vehiculos.modelo','vehiculos.marca',
            'vehiculos.clase','vehiculos.numero_interno', 'vehiculos.tarjeta_operacion', 'vehiculos.id as vehiculo_id', 'fuec.conductor',
            'vehiculos.empresa_afiliada','fuec.colegio', 'proveedores.razonsocial')
            ->leftJoin('vehiculos','fuec.vehiculo','=','vehiculos.id')
            ->leftJoin('proveedores', 'vehiculos.proveedores_id', '=', 'proveedores.id')
            ->leftJoin('contratos','fuec.contrato_id','=','contratos.id')
            ->leftJoin('rutas_fuec','fuec.ruta_id','=','rutas_fuec.id')
            ->whereIn('fuec.id', $fuecidArray)
          ->get();

          //return $fuecs;

          $conductores = explode(',', $fuecs[0]->conductor);

          $data = [
            'placa_vehiculo' => $fuecs[0]->placa,
            'fuecs' => $fuecs
          ];

          $arrayIds = [];

          foreach ($fuecs as $fuec){
            array_push($arrayIds, $fuec->fuec_id);
          }

          $envio_fuec = new Enviofuec();
          $envio_fuec->email = $email_destino;
          $envio_fuec->enviado_por = Sentry::getUser()->id;
          $envio_fuec->vehiculo_id = $fuecs[0]->vehiculo_id;
          $envio_fuec->fuec_array = json_encode($arrayIds);
          $envio_fuec->save();

          Fuec::whereIn('id', $arrayIds)->update([
            'envio_fuec_id' => $envio_fuec->id
          ]);

          $mensaje = 'Se ha realizado el envio de un paquete de fuecs al correo electronico: '.$email_destino.' para el proveedor '.ucwords(strtolower($fuecs[0]->razonsocial));

          Notification::NotificacionesConductores($mensaje, $conductores);

          Mail::send('emails.correo_fuecs', $data, function($message) use ($email_destino){

          	$message->from('juridica@aotour.com.co', 'Auto Ocasional Tour - Autonet');
          	$message->to($email_destino)->subject('Formato unico de extracto de contrato');
          	$message->cc('aotourdeveloper@gmail.com');

          });

          return Response::json([
            'response' => true
          ]);

        }

      }

    }

    public function postHistoricofuec(){

      if (Request::ajax()){

        //Buscar fuec seleccionado y obtener el vehiculo y usuario que creo el fuec
        $fuec = Fuec::where('id', Input::get('fuec_id'))->with(['vehiculo', 'user'])->first();

        //Fecha de creacion del fuec, apartir de esta fecha se buscan la seguridad social, la administracion
        $creacion_fuec = new DateTime($fuec->created_at);

        //Conductores asignados en el fuec y seguridad social
        $conductores_id = explode(',', $fuec->conductor);
        $conductores = Conductor::whereIn('id', $conductores_id)->get();

        $seguridad_social = Seguridadsocial::whereIn('conductor_id', $conductores_id)
        ->where([
          'ano' => $creacion_fuec->format('Y'),
          'mes' => $creacion_fuec->format('m')
        ])->with(['user', 'conductor'])->get();

        $administracion = Administracion::where('vehiculo_id', $fuec->vehiculo)
          ->where([
            'ano' => $creacion_fuec->format('Y'),
            'mes' => $creacion_fuec->format('m')
          ])->with(['user'])->first();

        $examenes_sensometricos = Conductoresexamenes::selectRaw('conductor_id, max(created_at) as ultima_fecha')
        ->whereIn('conductor_id', $conductores_id)
        ->groupBy('conductor_id')
        ->with(['conductor', 'user'])
        ->get();

        return Response::json([
          'response' => true,
          'fuec' => $fuec,
          'conductores' => $conductores,
          'seguridad_social' => $seguridad_social,
          'administracion' => $administracion,
          'examenes_sensometricos' => $examenes_sensometricos
        ]);

      }

    }

    public function postDescargas(){

      if(Request::ajax()){

        $fuec = Fuec::find(Input::get('fuec_id'));

        if (count($fuec)){

          return Response::json([
              'response' => true,
              'fuec' => $fuec
          ]);

        }

      }

    }

    public function getHistorialmail(){

      if (Sentry::check()) {
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
      }else{
        $id_rol = null;
        $permisos = null;
        $permisos = null;
      }

      if (isset($permisos->administrativo->fuec->ver)){
        $ver = $permisos->administrativo->fuec->ver;
      }else{
        $ver = null;
      }

      if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on' ) {

        return View::make('admin.permisos');

      }else {

        $envio_fuec = Enviofuec::orderBy('id', 'desc')->with(['vehiculo', 'user', 'fuec'])->get();

        return View::make('fuec.historial_mail', [
          'permisos' => $permisos,
          'envio_fuec' => $envio_fuec,
          'i' => 1
        ]);

      }

    }

    public function getEnviados($envio_fuec_id)
    {

      if (Sentry::check()) {
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
      }else{
        $id_rol = null;
        $permisos = null;
        $permisos = null;
      }

      if (isset($permisos->administrativo->fuec->ver)){
        $ver = $permisos->administrativo->fuec->ver;
      }else{
        $ver = null;
      }

      if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on') {

        return View::make('admin.permisos');

      }else{

        //Tomar envio fuec segun id
        $envio_fuec = Enviofuec::where('id', $envio_fuec_id)->with(['fuec'])->first();

        //Si el campo fuecidarray no es null
        if (!is_null($envio_fuec->fuec_array)) {

          //Convertir string a arrays
          $array_id = json_decode($envio_fuec->fuec_array);

          //Obtener fuecs de acuerdo al id de arrays
          $fuecs = Fuec::whereIn('id', $array_id)->with(['enviofuec'])->get();

        //Si el campo fuecidarray es null
        }else if(is_null($envio_fuec->fuec_array)){

          //Obtener los fuecs de acuerdo al campo envio_fuec_id
          $fuecs = $envio_fuec->fuec;

        }

        return View::make('fuec.listado_enviados', [
          'envio_fuec' => $envio_fuec,
          'fuecs' => $fuecs,
          'i' => 1,
          'permisos' => $permisos
        ]);

      }

    }

    public function postInfodescarga(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else {

        $fuec = Fuec::where('id', Input::get('fuec_id'))->with(['enviofuec', 'enviofuec.user'])->first();

        if (count($fuec)) {

          return Response::json([
            'response' => true,
            'fuec'  => $fuec
          ]);

        }

      }

    }

    public function getList(){

      $fecha = date('Y-m-d');

      $conductor_id = 534;

      $consulta = "SELECT fuec.*, contratos.contratante, rutas_fuec.origen, rutas_fuec.destino FROM fuec left join contratos on contratos.id = fuec.contrato_id left join rutas_fuec on rutas_fuec.id = fuec.ruta_id WHERE '".$fecha."' BETWEEN DATE(fuec.created_at) AND fecha_final AND FIND_IN_SET('".$conductor_id."', conductor) > 0 ORDER BY id DESC";
      $fuec = DB::select($consulta);

      $array = [
        'fuecs'=>$fuec
      ];

      return View::make('fuec.fuec_descargas_app',$array);

    }

  }
