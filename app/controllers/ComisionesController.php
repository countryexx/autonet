<?php

  class ComisionesController extends BaseController{

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

        if (isset($permisos->contabilidad->comisiones->ver)){
            $ver = $permisos->contabilidad->comisiones->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {

            $comercial = DB::table('asesor_comercial')->get();
            $tercero = DB::table('terceros')->get();
            $users = DB::table('users')->where('coordinador_turismo',1)->get();
            return View::make('comisiones.listado',[
              'comercial'=>$comercial,
              'terceros'=>$tercero,
              'users'=>$users,
              'permisos'=>$permisos
            ]);
      }
    }

    public function postVerfacturas(){

      if (!Sentry::check()){

  			return Response::json([
  				'respuesta'=>'relogin'
  			]);

  		}else {

  			if (Request::ajax()) {

          $fecha_inicial = Input::get('fecha_inicial');
          $fecha_final = Input::get('fecha_final');
          $asesor_comercial = intval(Input::get('id_asesor'));
          $tercero = intval(Input::get('tercero_id'));
          $coordinador_turismo = intval(Input::get('coordinador_turismo'));
          $tipo_servicio = intval(Input::get('tipo_servicio'));

          $consulta = "SELECT ".
                          "ordenes_facturacion.consecutivo, ".
                          "centrosdecosto.razonsocial, ".
                          "centrosdecosto.asesor_comercial, ".
                          "subcentrosdecosto.nombresubcentro, ".
                          "subcentrosdecosto.asesor_comercial as sbasesor_comercial, ".
                          "subcentrosdecosto.tercero as sbtercero, ".
                          "ordenes_facturacion.id as id_factura, ".
                          "ordenes_facturacion.numero_factura, ".
                          "ordenes_facturacion.total_facturado_cliente, ".
                          "ordenes_facturacion.total_utilidad, ".
                          "ordenes_facturacion.tipo_orden, ".
                          "ordenes_facturacion.fecha_expedicion,".
                          "ordenes_facturacion.tipo_orden, ".
                          "ordenes_facturacion.total_costo, ".
                          "ordenes_facturacion.revision_ingreso, ".
                          "ordenes_facturacion.pagado_asesor, ".
                          "ordenes_facturacion.pagado_coordinador, ".
                          "ordenes_facturacion.pagado_tercero, ".
                          "otros_servicios_detalles.negocio, ".
                          "otros_servicios_detalles.creado_por, ".
                          "otros_servicios_detalles.tercero, ".
                          "otros_servicios_detalles.id_tercero, ".
                          "otros_servicios_detalles.pagado_proveedor, ".
                          "otros_servicios_detalles.id as id_servicios_detalles, ".
                          "asesor_comercial.id as asesor_comercial_id, ".
                          "asesor_comercial.nombre_completo ".
                      "FROM ".
                          "ordenes_facturacion ".
                              "LEFT JOIN ".
                          "otros_servicios_detalles ON ordenes_facturacion.id = otros_servicios_detalles.id_factura ".
                              "LEFT JOIN ".
                          "centrosdecosto ON ordenes_facturacion.centrodecosto_id = centrosdecosto.id ".
                              "LEFT JOIN ".
                          "subcentrosdecosto ON ordenes_facturacion.subcentrodecosto_id = subcentrosdecosto.id ".
                              "LEFT JOIN ".
                          "asesor_comercial ON centrosdecosto.asesor_comercial = asesor_comercial.id ".
                      "WHERE ".
                          "ordenes_facturacion.fecha_expedicion BETWEEN '".$fecha_inicial." 00:00:01' AND '".$fecha_final." 23:59:59' and ordenes_facturacion.anulado is null ";


          if ($coordinador_turismo===0) {
            $consulta .= " and ordenes_facturacion.ingreso = 1 and ordenes_facturacion.revision_ingreso = 1 ";
          }

          //SI EL TIPO DE SERVICIO ES DE TRANSPORTE ENTONCES
          if ($tipo_servicio===1) {
            //SELECCIONE TODAS LAS FACTURAS DE TRANSPORTE
            $consulta .="and ordenes_facturacion.tipo_orden = '".$tipo_servicio."' ";
            //SI ES SELECCIONADO EL ASESOR COMERCIAL ENTONCES
            if ($asesor_comercial!=0) {
              //REVISAR QUE FACTURAS NO HAN SIDO PAGADAS OSEA QUE EL PAGADO AL ASESOR ESTE VACIO
              $consulta .="and ordenes_facturacion.pagado_asesor is null and (centrosdecosto.asesor_comercial = '".$asesor_comercial."' ".
                          "or subcentrosdecosto.asesor_comercial ='".$asesor_comercial."') ";
              //SI ES SELECCIONADO EL TERCERO ENTONCES
            }else if($tercero!=0) {
              //REVISAR LAS FACTURAS QUE TENGAN TERCERO Y QUE NO SE LE HAYAN PAGADO AL TERCERO
              $consulta .="and subcentrosdecosto.tercero = '".$tercero."' and ordenes_facturacion.pagado_tercero is null ";
            }
          //SI EL TIPO DE SERVICIO ES DE TURISMO Y OTROS ENTONCES
          }else if ($tipo_servicio===2) {
            $consulta .="and ordenes_facturacion.tipo_orden = '".$tipo_servicio."' ";
            //SI ES SELECCIONADO EL ASESOR COMERCIAL ENTONCES
            if ($asesor_comercial!=0) {
              $consulta .=" and ordenes_facturacion.pagado_asesor is null ";
            }else if($tercero!=0) {
              $consulta .= "and otros_servicios_detalles.id_tercero = '".$tercero."' and ordenes_facturacion.pagado_tercero is null ";
            }else if ($coordinador_turismo!=0) {
              $consulta .=" and ordenes_facturacion.pagado_coordinador is null ";
            }
          }

          $ordenes_facturacion = DB::select($consulta."ORDER BY consecutivo ");

          if ($ordenes_facturacion!=null) {
            return Response::json([
              'respuesta'=>true,
              'ordenes_facturacion'=>$ordenes_facturacion,
              'consulta'=>$consulta
            ]);
          }else{
            return Response::json([
              'respuesta'=>false,
              'consulta'=>$consulta
            ]);
          }
        }
      }
    }

    public function postDetallesvalores(){

      if (!Sentry::check()){

  			return Response::json([
  				'respuesta'=>'relogin'
  			]);

  		}else {

  			if (Request::ajax()) {

          //ID DE LA FACTURA
          $id = intval(Input::get('id'));

          //TOTAL FACTURADO CLIENTE DE LA FACTURA
          $tfacturado_cliente = floatval(Input::get('tfacturado_cliente'));

          //SI TIENE O NO TERCERO EL OTROSSERVICIOSDETALLES
          $tercero_val = intval(Input::get('tercero_val'));

          //SI VA A SER PAGADO EN EFECTIVO O A CREDITO AL PROVEEDOR, DEPENDIENDO DE ESTO SE GENERA O NO UN GASTO BANCARIO
          $pagado_proveedor = intval(Input::get('pagado_proveedor'));

          //BUSQUEDA DE OTROS SERVICIOS SEGUN EL ID DE LA FACTURA
          $otros_servicios = DB::table('otros_servicios')
          ->where('id_servicios_detalles',$id)
          ->get();

          //INICIALIZACION DE LOS VALORES PARA SUMARLOS Y MOSTRARLOS
          $valor = 0;
          $iva_servicio = 0;
          $impuesto = 0;
          $ta = 0;
          $ivata = 0;
          $otros = 0;
          $iva_servicio = 0;
          $tasa_aero = 0;
          $otras_tasas = 0;
          $producto = '';
          $tercero_sum = 0;
          $costo_total_sum = 0;
          $gastos_bancarios_sum = 0;
          $tareal_sum = 0;
          $asesor_comercial_sum = 0;
          $coordinador_sum = 0;
          $aotour_sum = 0 ;
          $i = 0;
          $costoarray = [];
          $tercerarray = [];

          //POR CADA PRODUCTO HACER EL CALCULO
          foreach ($otros_servicios as $value) {

            $costo_total = 0;
            $gastos_bancarios = 0;
            $tareal = 0;
            $tercero = 0;
            $total_facturado_por_producto = 0;
            $asesor_comercial = 0;
            $coordinador = 0;
            $aotour = 0;

            //ARRAY PARA MOSTRAR LOS PRODUCTOS QUE TRAE UNA FACTURA DE OTROS SERVICIOS
            if ($i===0) {
              $producto = $producto.$value->producto;
            }else{
              $producto = $producto.'<br>'.$value->producto;
            }

            //SUMATORIA DE LOS VALORES PRINCIPALES
            $valor = $valor + intval($value->valor);
            $impuesto = $impuesto + intval($value->impuesto);
            $ta = $ta + intval($value->valor_comision);
            $ivata = $ivata + intval($value->iva_comision);
            $otros = $otros + intval($value->otros);
            $iva_servicio = $iva_servicio + intval($value->iva_servicio);
            $tasa_aero = $tasa_aero + intval($value->tasa_aero);
            $otras_tasas = $otras_tasas + intval($value->otras_tasas);
            $i++;

            $costo_total = floatval($value->valor)+floatval($value->impuesto)+floatval($value->iva_servicio)+floatval($value->tasa_aero)+floatval($value->otras_tasas);

            if ($pagado_proveedor===2) {
              $gastos_bancarios = $costo_total*0.0229;
            }

            //CALCULO DE LA TA REAL
            $tareal = (floatval($value->valor_comision)+floatval($value->otros))-$gastos_bancarios;

            if (substr($tareal, 0, 1)==='-'){
                $tareal = 0;
            }

            $total_facturado_por_producto = $costo_total+floatval($value->valor_comision)+floatval($value->otros)+floatval($value->iva_comision);

            //CALCULO DE TIQUETES
            if ($value->producto==='TIQUETES AEREOS') {

              //SI LA FACTURA TIENE TERCERO
              if ($tercero_val===1) {
                $tercero = (floatval($value->valor_comision) - $gastos_bancarios)*0.7;
                  if (substr($tercero, 0, 1)==='-'){
                      $tercero = 0;
                  }
                $tercero_sum = $tercero_sum + $tercero;
              }

              $asesor_comercial = (floatval($value->valor_comision)+floatval($value->otros)-$gastos_bancarios-$tercero)*0.2;
                if (substr($asesor_comercial, 0, 1)==='-'){
                    $asesor_comercial = 0;
                }
              $coordinador = (floatval($value->valor_comision)+floatval($value->otros)-$gastos_bancarios-$tercero-$asesor_comercial)*0.025;
                if (substr($coordinador, 0, 1)==='-'){
                    $coordinador = 0;
                }
              $aotour = $tareal-$tercero-$asesor_comercial-$coordinador;
                if (substr($aotour, 0, 1)==='-'){
                    $aotour = 0;
                }

            //CALCULO DE OTROS PRODUCTOS QUE NO SEAN TIQUETES EJ: CITY TOUR...
            } else if($value->producto!='TIQUETES AEREOS') {

              if ($tercero_val===1) {

                //$tercero = (($total_facturado_por_producto-$gastos_bancarios)*0.1)*0.7;

                $tercero = (($total_facturado_por_producto*0.1)-$gastos_bancarios)*0.7;

                //$tercero = ((floatval($factura->total_facturado_cliente)*0.1)-$gastos_bancarios)*0.7;
                  if (substr($tercero, 0, 1)==='-'){
                      $tercero = 0;
                  }
                $tercero_sum = $tercero_sum + $tercero;

              }

              $asesor_comercial = ($tareal-$tercero)*0.2;
                if (substr($asesor_comercial, 0, 1)==='-'){
                    $asesor_comercial = 0;
                }
              $coordinador = ($tareal-$tercero-$asesor_comercial)*0.025;
                if (substr($coordinador, 0, 1)==='-'){
                    $coordinador = 0;
                }
              $aotour = $tareal-$tercero-$asesor_comercial-$coordinador;
                if (substr($aotour, 0, 1)==='-'){
                    $aotour = 0;
                }
            }

            $costo_total_sum = $costo_total_sum + $costo_total;
            $gastos_bancarios_sum = $gastos_bancarios_sum + $gastos_bancarios;
            $tareal_sum = $tareal_sum + $tareal;
            $asesor_comercial_sum = $asesor_comercial_sum + $asesor_comercial;
            $coordinador_sum = $coordinador_sum + $coordinador;
            $aotour_sum = $aotour_sum + $aotour;
          }

          //ARRAY PARA TODOS LOS VALORES
          $valores = [
            'producto'=>$producto,
            'valor'=>$valor,
            'impuesto'=>$impuesto,
            'ta'=>$ta,
            'ivata'=>$ivata,
            'otros'=>$otros,
            'iva_servicio'=>$iva_servicio,
            'tasa_aero'=>$tasa_aero,
            'otras_tasas'=>$otras_tasas,
            'tercero'=>$tercero_sum,
            'gastos_bancarios'=>$gastos_bancarios_sum,
            'costo_total'=>$costo_total_sum,
            'tareal'=>$tareal_sum,
            'tercero'=>$tercero_sum,
            'tercerarray'=>$tercerarray,
            'tfacturado_cliente'=>$tfacturado_cliente,
            'otros_servicios'=>$otros_servicios,
            'asesor_comercial'=>$asesor_comercial_sum,
            'coordinador'=>$coordinador_sum,
            'aotour'=>$aotour_sum
          ];

          return Response::json([
            'respuesta'=>true,
            'otros_servicios'=>$otros_servicios,
            'valores'=>$valores
          ]);
        }

      }

    }

    public function postPagocomision(){

      if (!Sentry::check()){

  			return Response::json([
  				'respuesta'=>'relogin'
  			]);

  		}else {

  			if (Request::ajax()) {

          $array = [];

          $pago_comisiones = new Pagocomisiones;
          $pago_comisiones->descuento_retefuente = Input::get('descuento_retefuente');
          $pago_comisiones->valor_retefuente = Input::get('valor_retefuente');
          $pago_comisiones->fecha_pago = Input::get('fecha_pago');
          $pago_comisiones->fecha_registro = date('Y-m-d H:i:s');
          $pago_comisiones->total_comision = Input::get('totales_comisiones');
          $pago_comisiones->detalles_descuentos = Input::get('arrayDescuentos');
          $pago_comisiones->otros_descuentos = Input::get('otros_descuentos');
          $pago_comisiones->total_a_pagar = Input::get('total_a_pagar');
          $pago_comisiones->idpersona = intval(Input::get('idpersona'));
          $pago_comisiones->tipo_comision = intval(Input::get('tipo_comision'));
          $idArray = Input::get('idArray');
          $idArray = substr($idArray , 0 , -1);
          $pago_comisiones->arrayidordenesfactura = $idArray;
          $pago_comisiones->tipo_facturas = Input::get('tipo_pago');
          $pago_comisiones->creado_por = Sentry::getUser()->id;

          if ($pago_comisiones->save()) {

            $id = $pago_comisiones->id;
            $p = Pagocomisiones::find($id);

            if(strlen($id)===1){
                $p->consecutivo = 'AP0000'.$id;
            }elseif(strlen($id)===2){
                $p->consecutivo = 'AP000'.$id;
            }elseif(strlen($id)===3){
                $p->consecutivo = 'AP00'.$id;
            }elseif(strlen($id)===4){
                $p->consecutivo = 'AP0'.$id;
            }

            if($p->save()){

              $idpersona = intval(Input::get('idpersona'));

              $tipo_comision = intval(Input::get('tipo_comision'));

              if ($tipo_comision===1) {

                $consulta = "UPDATE ordenes_facturacion ".
                            "SET ".
                                "pagado_asesor = ".$idpersona." ".
                            "WHERE ".
                                "id IN (".$idArray.")";

              }else if ($tipo_comision===2) {

                $consulta = "UPDATE ordenes_facturacion ".
                            "SET ".
                                "pagado_tercero = ".$idpersona." ".
                            "WHERE ".
                                "id IN (".$idArray.")";

              }else if ($tipo_comision===3) {

                $consulta = "UPDATE ordenes_facturacion ".
                            "SET ".
                                "pagado_coordinador = ".$idpersona." ".
                            "WHERE ".
                                "id IN (".$idArray.")";
              }

              $ordenes_facturacion = DB::update($consulta);

              return Response::json([
                'respuesta'=>true,
                'consulta'=>$consulta
              ]);

            }

          }
        }

      }
    }

    public function getPagos(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->contabilidad->pago_de_comisiones->ver)){
            $ver = $permisos->contabilidad->pago_de_comisiones->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {

        $comercial = DB::table('asesor_comercial')->orderBy('nombre_completo')->get();
        $users = DB::table('users')->where('coordinador_turismo',1)->get();
        $terceros = DB::table('terceros')->orderBy('nombre_completo')->get();

        $urla = url('comisiones/pagosporautorizar');
        $urlb = url('comisiones/pagosporpagar');

        $array = [
          'comercial'=>$comercial,
          'users'=>$users,
          'terceros'=>$terceros,
          'option'=>0,
          'valores'=>[
            'titulo'=>'LISTADO DE PAGOS DE COMISIONES',
            'link_pago_comisiones'=>'<li class="active">Pago de Comisiones</li>',
            'link_pago_autorizar'=>'<li><a href="'.$urla.'">Pagos por Autorizar</a></li>',
            'link_pago_pagar'=>'<li><a href="'.$urlb.'">Pagos por Pagar</a></li>',
            'boton'=>'REVISAR'
          ],
          'permisos'=>$permisos
        ];

        return View::make('comisiones.pagos',$array);
      }
    }

    public function getPagosporautorizar(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->contabilidad->pagos_por_autorizar_comision->ver)){
            $ver = $permisos->contabilidad->pagos_por_autorizar_comision->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {
            $comercial = DB::table('asesor_comercial')->orderBy('nombre_completo')->get();
            $users = DB::table('users')->where('coordinador_turismo',1)->get();
            $terceros = DB::table('terceros')->orderBy('nombre_completo')->get();

            $urla = url('comisiones/pagos');
            $urlb = url('comisiones/pagosporpagar');

            $array = [
              'comercial'=>$comercial,
              'users'=>$users,
              'terceros'=>$terceros,
              'option'=>1,
              'valores'=>[
                'titulo'=>'LISTADO DE PAGOS POR AUTORIZAR',
                'link_pago_comisiones'=>'<li><a href="'.$urla.'">Pago de Comisiones</a></li>',
                'link_pago_autorizar'=>'<li class="active">Pagos por Autorizar</li>',
                'link_pago_pagar'=>'<li><a href="'.$urlb.'">Pagos por Pagar</a></li>',
                'boton'=>'AUTORIZAR'
              ],
              'permisos'=>$permisos
            ];

            return View::make('comisiones.pagos',$array);
      }
    }

    public function getPagosporpagar(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->contabilidad->pagos_por_pagar_comision->ver)){
            $ver = $permisos->contabilidad->pagos_por_pagar_comision->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {
            $comercial = DB::table('asesor_comercial')->orderBy('nombre_completo')->get();
            $users = DB::table('users')->where('coordinador_turismo',1)->get();
            $terceros = DB::table('terceros')->orderBy('nombre_completo')->get();

            $urla = url('comisiones/pagos');
            $urlb = url('comisiones/pagosporautorizar');

            $array = [
              'comercial'=>$comercial,
              'users'=>$users,
              'terceros'=>$terceros,
              'option'=>2,
              'valores'=>[
                'titulo'=>'LISTADO DE PAGOS POR PAGAR',
                'link_pago_comisiones'=>'<li><a href="'.$urla.'">Pago de Comisiones</a></li>',
                'link_pago_autorizar'=>'<li><a href="'.$urlb.'">Pagos por Autorizar</a></li>',
                'link_pago_pagar'=>'<li class="active">Pagos por Pagar</li>'
              ]
            ];

            return View::make('comisiones.pagos',$array);
      }
    }

    public function postVerpagos(){

      if (!Sentry::check()){

  			return Response::json([
  				'respuesta'=>'relogin'
  			]);

  		}else {

  			if (Request::ajax()) {

          $fecha_inicial = Input::get('fecha_inicial');
          $fecha_final = Input::get('fecha_final');
          $tipo_servicio = intval(Input::get('tipo_servicio'));
          $asesor_comercial = Input::get('asesor_comercial');
          $tercero = Input::get('tercero');
          $coordinador = Input::get('coordinador_turismo');
          $option = intval(Input::get('option'));


          $consulta = "select pagos_comisiones.id, pagos_comisiones.consecutivo, pagos_comisiones.descuento_retefuente, pagos_comisiones.valor_retefuente, pagos_comisiones.fecha_pago, ".
                      "pagos_comisiones.fecha_registro, pagos_comisiones.total_comision, pagos_comisiones.detalles_descuentos, pagos_comisiones.otros_descuentos, pagos_comisiones.total_a_pagar, ".
                      "pagos_comisiones.idpersona, pagos_comisiones.tipo_facturas, pagos_comisiones.tipo_comision, pagos_comisiones.creado_por, pagos_comisiones.revision, pagos_comisiones.fecha_autorizado, ".
                      "pagos_comisiones.fecha_revision, pagos_comisiones.pagado, pagos_comisiones.pagado_por, pagos_comisiones.fecha_pagado , usersb.first_name as first_nameb, usersb.last_name as last_nameb, ".
                      "users.first_name, users.last_name from pagos_comisiones ".
                      "left join users on pagos_comisiones.revisado_por = users.id ".
                      "left join users as usersb on pagos_comisiones.pagado_por = usersb.id ";


          if ($tipo_servicio!=0) {
            $consulta .= "and tipo_facturas = '".$tipo_servicio."' ";
            if ($asesor_comercial!=0) {
              $consulta .= "and tipo_comision = 1 and idpersona = '".$asesor_comercial."' ";
            }else if ($tercero!=0) {
              $consulta .= "and tipo_comision = 2 and idpersona = '".$tercero."'";
            }else if ($coordinador!=0) {
              $consulta .= "and tipo_comision = 3 and idpersona = '".$coordinador."'";
            }
          }else if ($tipo_servicio===0) {
            if ($asesor_comercial!=0) {
              $consulta .= "and tipo_comision = 1 and idpersona = '".$asesor_comercial."' ";
            }else if ($tercero!=0) {
              $consulta .= "and tipo_comision = 2 and idpersona = '".$tercero."'";
            }else if ($coordinador!=0) {
              $consulta .= "and tipo_comision = 3 and idpersona = '".$coordinador."'";
            }
          }
          if ($option===0) {
            $consulta .= "where pagos_comisiones.fecha_pago between '".$fecha_inicial." 00:00:00' and '".$fecha_final." 23:59:59' ";
          }else if ($option===1) {
            $consulta .= "where pagos_comisiones.fecha_pago between '".$fecha_inicial." 00:00:00' and '".$fecha_final." 23:59:59' ";
            $consulta .= " and pagos_comisiones.revision = 1  and pagado is null";
          }else if ($option===2) {
            $consulta .= "where pagos_comisiones.fecha_pagado between '".$fecha_inicial." 00:00:00' and '".$fecha_final." 23:59:59' ";
            $consulta .= " and pagos_comisiones.pagado = 1";
          }

          $pagos_comisiones = DB::select($consulta);

          if ($pagos_comisiones!=null) {
            return Response::json([
              'respuesta'=>true,
              'pagos_comisiones'=>$pagos_comisiones,
              'consulta'=>$consulta
            ]);
          }else{
            return Response::json([
              'respuesta'=>false,
              'consulta'=>$consulta
            ]);
          }
        }
      }
    }

    public function postVercomisionado(){

      if (!Sentry::check()){

  			return Response::json([
  				'respuesta'=>'relogin'
  			]);

  		}else {

  			if (Request::ajax()) {

          $asesor_comercial = DB::table('asesor_comercial')->where('id',Input::get('id'))->pluck('nombre_completo');

          if ($asesor_comercial!=null) {
            return Response::json([
              'respuesta'=>true,
              'nombre_completo'=>$asesor_comercial
            ]);
          }

        }

      }
    }

    public function postVercomisionadotercero(){

      if (!Sentry::check()){

  			return Response::json([
  				'respuesta'=>'relogin'
  			]);

  		}else {

  			if (Request::ajax()) {

          $tercero = DB::table('terceros')->where('id',Input::get('id'))->pluck('nombre_completo');

          if ($tercero!=null) {
            return Response::json([
              'respuesta'=>true,
              'nombre_completo'=>$tercero
            ]);
          }

        }

      }
    }

    public function postVercomisionadocoordinador(){

      if (!Sentry::check()){

  			return Response::json([
  				'respuesta'=>'relogin'
  			]);

  		}else {

  			if (Request::ajax()) {

          $coordinador = DB::table('users')->where('id',Input::get('id'))->first();

          if ($coordinador!=null) {
            return Response::json([
              'respuesta'=>true,
              'coordinador'=>$coordinador
            ]);
          }

        }

      }
    }

    public function getDetallescomision($id){

      if (!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{
        $pagos_comisiones = Pagocomisiones::find($id);
        if ($pagos_comisiones!=null) {
          return View::make('comisiones.detalles',[
            'pagos_comisiones'=>$pagos_comisiones
          ]);

        }
      }

    }

    public function postRevisarpago(){

      if (!Sentry::check()){

  			return Response::json([
  				'respuesta'=>'relogin'
  			]);

  		}else {

        if (Request::ajax()) {

            $array = Input::get('idArrays');
            $contador_realizados = 0;
            $arrayidsRealizado = [];
            $arrayfechaRealizado = [];
            $arrayusuarioRealizado = [];

            for ($i=0; $i <count($array) ; $i++) {

                $autorizado = DB::table('pagos_comisiones')
                ->where('id', $array[$i])
                ->update([
                  'revision' => 1,
                  'revisado_por'=>Sentry::getUser()->id,
                  'fecha_revision'=>date('Y-m-d H:i:s')
                ]);

                if ($autorizado) {
                  $pago_comision = Pagocomisiones::find($array[$i]);
                  $contador_realizados++;
                  array_push($arrayidsRealizado,$pago_comision->id);
                  array_push($arrayfechaRealizado,$pago_comision->fecha_revision);
                  array_push($arrayusuarioRealizado,Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name);
                }

            }

            if ($contador_realizados!=0) {

              return Response::json([
                'respuesta'=>true,
                'arrayidsRealizado'=>$arrayidsRealizado,
                'arrayfechaRealizado'=>$arrayfechaRealizado,
                'arrayusuarioRealizado'=>$arrayusuarioRealizado
              ]);

            }else{

              return Response::json([
                'respuesta'=>false,
              ]);

            }
        }
      }
    }

    public function postAutorizarpago(){

      if (!Sentry::check()){

  			return Response::json([
  				'respuesta'=>'relogin'
  			]);

  		}else {

  			if (Request::ajax()) {

            $array = Input::get('idArrays');
            $fecha_pago = Input::get('fecha_pago');
            $contador_pagos = count($array);
            $contador_realizados = 0;
            $arrayidsRealizado = [];
            $arrayfechaRealizado = [];
            $arrayusuarioRealizado = [];
            $arrayFechapagado = [];

            for ($i=0; $i <count($array) ; $i++) {

                $autorizado = DB::table('pagos_comisiones')
                ->where('id', $array[$i])
                ->update([
                  'pagado' => 1,
                  'pagado_por'=>Sentry::getUser()->id,
                  'fecha_autorizado'=>date('Y-m-d H:i:s'),
                  'fecha_pagado'=>$fecha_pago
                ]);

                if ($autorizado) {
                  $pago_comision = Pagocomisiones::find($array[$i]);
                  $contador_realizados++;
                  array_push($arrayidsRealizado,$pago_comision->id);
                  array_push($arrayfechaRealizado,$pago_comision->fecha_autorizado);
                  array_push($arrayusuarioRealizado,Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name);
                  array_push($arrayFechapagado,$pago_comision->fecha_pagado);
                }

            }

            if ($contador_realizados!=0) {

              return Response::json([
                'respuesta'=>true,
                'arrayidsRealizado'=>$arrayidsRealizado,
                'arrayfechaRealizado'=>$arrayfechaRealizado,
                'arrayusuarioRealizado'=>$arrayusuarioRealizado,
                'arrayFechapagado'=>$arrayFechapagado
              ]);

            }else{

              return Response::json([
                'respuesta'=>false,
              ]);

            }
        }
      }
    }

    public function postPagarcomision(){

      if (!Sentry::check()){

  			return Response::json([
  				'respuesta'=>'relogin'
  			]);

  		}else {

  			if (Request::ajax()) {

          $id = Input::get('id');

          $pago_comision = Pagocomisiones::find($id);
          $pago_comision->pagado = 1;
          $pago_comision->pagado_por = Sentry::getUser()->id;
          $pago_comision->fecha_pagado = date('Y-m-d H:i:s');

          if ($pago_comision->save()) {
            return Response::json([
              'respuesta'=>true,
            ]);
          }
        }
      }
    }

  }
