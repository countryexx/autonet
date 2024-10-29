<?php

/**
 * Controlador para el modulo de Dashboard
 */
class DashboardController extends BaseController{

  public function getIndex(){
    
    if (Sentry::check()){

      $id_rol = Sentry::getUser()->id_rol;
      $idusuario = Sentry::getUser()->id;
      $idusario = Sentry::getUser()->id;
      $cliente = Sentry::getUser()->centrodecosto_id;  
      $nombrecentrodecosto = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->portalusuarios->admin->ver;

    }else{
      $ver = null;
    }
    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on') {

      return View::make('admin.permisos');

    }else{
      $fechainicial = Input::get('md_fecha_inicial');
      $fechafinal = Input::get('md_fecha_final');
      
      //INICIO CONSULTA OBTENER DATOS
      
      //BARRANQUILLA
      if($cliente==19){
        if($fechainicial < '2020-01-29'){
          if($fechainicial!=null){
                    echo "<script>
                        alert('No hay datos para mostrar.');
                    </script>";
          }

                    //FECHA INCORRECTA
                    //CONSULTA % UTILIZACIÓN DEL VEHICULO VAN
                    $consultautilizacion = "

                    SELECT  xy.fecha_dia, 
                    case 
                    when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                    ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/7)*100
                    END
                    AS 'OCUPACION', 
                    xy.tipo_vehiculo              
                    FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                    where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                    ) xy
                    where date(xy.fecha) between '20000101' and '20000101' and tipo_vehiculo = 'VAN'
                    GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                    ";
                    $informacionvan = DB::select($consultautilizacion);
                    $contadorinformacion = count($informacionvan);
                    //FIN % DE UTILIZACIÓN VAN

                    //CONSULTA % UTILIZACIÓN DEL VEHICULO AUTO
                    $consultautilizacionauto = "
                    SELECT  xy.fecha_dia, 
                    case 
                    when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                    ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
                    END
                    AS 'OCUPACION', 
                    xy.tipo_vehiculo
                    FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                    where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                    ) xy
                    where date(xy.fecha) between '20000101' and '20000101' and tipo_vehiculo = 'AUTO'
                    GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                    ";
                    $informacionauto = DB::select($consultautilizacionauto);
                    $contadorinformacionauto = count($informacionauto);
                    $resultadofinal = $contadorinformacion + $contadorinformacionauto;
                    //FIN % DE UTILIZACIÓN AUTO
                    $question = "select * from pasajeros where date(created_at) between '20000101' and '20000101' and centrodecosto_id='".$cliente."' ";
                    $registros = DB::select($question);
                    //->where('created_at',$fechafinal)
                    //->get();
                    $re = count($registros);
                    //$satisfechos = DB::table('servicios')
                    //->where('calificacion_app_conductor_calidad', '>',2.9)->where('centrodecosto_id',$cliente)->get();
                    $datossatisfechos = 0;
                    //$nosatisfechos = DB::table('servicios')
                    //->where('calificacion_app_conductor_calidad','<',3)->where('centrodecosto_id',$cliente)->get();
                    $datosnosatisfechos = 0;
                    
                    $efectivos = DB::table('qr_rutas')
                    ->where('status',1)
                    ->where('centrodecosto_id',$cliente)
                    ->whereBetween('fecha',['20000101', '20000101'])
                    ->get();
                    $cantidadefectivos = count($efectivos);
                    $autorizados = DB::table('qr_rutas')
                    ->where('status',2)
                    ->where('centrodecosto_id',$cliente)
                    ->whereBetween('fecha',['20000101', '2000101'])
                    ->get();
                    $cantidadautorizados = count($autorizados);
                    $abstraccion = DB::table('qr_rutas')
                    ->whereNull('status')
                    ->where('centrodecosto_id',$cliente)
                    ->whereBetween('fecha',['20000101', '20000101'])
                    ->get();
                    $cantidadabstraccion = count($abstraccion);
                    
                    //QUERY RUTAS QR
                    //OBTENER PASAJEROS AMONESTADOS
                      $queryamonestados = DB::table('qr_rutas')
                      ->leftJoin('pasajeros', 'qr_rutas.id_usuario', '=', 'pasajeros.cedula')
                      ->select('qr_rutas.*','pasajeros.nombres', 'pasajeros.apellidos')
                      ->whereNull('qr_rutas.status')->where('qr_rutas.centrodecosto_id',$cliente)->whereBetween('qr_rutas.fecha',['20000101','20000101']);
                      $pasajerosamonestados = $queryamonestados->orderBy('pasajeros.id')->get();
                      $totalpasajeros = count($pasajerosamonestados);
                    //FIN OBTENER PASAJEROS AMONESTADOS
                    
                    //OBTENER SERVICIOS FACTURADOS
                    $queryf = DB::table('facturacion')
                         
                      ->leftJoin('servicios', 'servicios.id', '=', 'facturacion.servicio_id')
                      ->whereBetween('servicios.fecha_servicio',['20000101','20000101'])
                      ->where('facturacion.facturado',1)
                      ->where('servicios.anulado',0)                        
                      ->where('servicios.centrodecosto_id',$cliente)
                      ->where('servicios.ruta',1)
                      ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
                      ->whereNull('servicios.pendiente_autori_eliminacion')
                      ->whereNull('servicios.afiliado_externo')                
                      ->get();
                    //CONTADOR DE SERVICIOS
                    $cantidadservicios = count($queryf);
                    //FIN OBTENER SERVICIOS FACTURADOS

                      $recorridos = DB::table('servicios')
                      ->where('centrodecosto_id',$cliente)
                      ->whereBetween('fecha_servicio',['20000101','20000101'])
                      ->whereNull('servicios.pendiente_autori_eliminacion')
                      ->whereNull('servicios.afiliado_externo')
                      ->where('ruta',1)
                      ->get();
                      $recorridosrealizados = count($recorridos);

                      if($cliente==287){
                        $americas = DB::table('servicios')
                        ->where('subcentrodecosto_id',851)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',['20000101','20000101'])
                        ->get();
                        $countamericas = count($americas);

                        $toberin = DB::table('servicios')
                        ->where('subcentrodecosto_id',852)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',['20000101','20000101'])
                        ->get();
                        $counttoberin = count($toberin);

                        $torrecristal = DB::table('servicios')
                        ->where('subcentrodecosto_id',853)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',['20000101','20000101'])
                        ->get();
                        $counttorrecristal = count($torrecristal);
                        $countrutas = null;
                        $countcarnavales = null;
                      }else{
                        $rutas = DB::table('servicios')
                        ->where('subcentrodecosto_id',178)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',['20000101','20000101'])
                        ->get();
                        $countrutas = count($rutas);

                        $carnavales = DB::table('servicios')
                        ->where('subcentrodecosto_id',509)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',['20000101','20000101'])
                        ->get();
                        $countcarnavales = count($carnavales);
                        $counttoberin = null;
                        $counttorrecristal = null;
                        $countamericas = null;        
                      }

        }else{
                    //FECHA CORRECTA
                    //CONSULTA % UTILIZACIÓN DEL VEHICULO VAN
                    $consultautilizacion = "

                    SELECT  xy.fecha_dia, 
                    case 
                    when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                    ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/7)*100
                    END
                    AS 'OCUPACION', 
                    xy.tipo_vehiculo              
                    FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                    where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                    ) xy
                    where date(xy.fecha) between '".$fechainicial."' and '".$fechafinal."' and tipo_vehiculo = 'VAN'
                    GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                    ";
                    $informacionvan = DB::select($consultautilizacion);
                    $contadorinformacion = count($informacionvan);
                    //FIN % DE UTILIZACIÓN VAN

                    //CONSULTA % UTILIZACIÓN DEL VEHICULO AUTO
                    $consultautilizacionauto = "
                    SELECT  xy.fecha_dia, 
                    case 
                    when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                    ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
                    END
                    AS 'OCUPACION', 
                    xy.tipo_vehiculo
                    FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                    where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                    ) xy
                    where date(xy.fecha) between '".$fechainicial."' and '".$fechafinal."' and tipo_vehiculo = 'AUTO'
                    GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                    ";
                    $informacionauto = DB::select($consultautilizacionauto);
                    $contadorinformacionauto = count($informacionauto);
                    $resultadofinal = $contadorinformacion + $contadorinformacionauto;
                    //FIN % DE UTILIZACIÓN AUTO
                    $question = "select * from pasajeros where date(created_at) between '".$fechainicial."' and '".$fechafinal."' and centrodecosto_id='".$cliente."' ";
                    $registros = DB::select($question);
                    //->where('created_at',$fechafinal)
                    //->get();
                    $re = count($registros);

                    $satisfechos = DB::table('servicios')
                    ->where('calificacion_app_conductor_calidad', '>',2.9)->where('centrodecosto_id',$cliente)->get();
                    $datossatisfechos = count($satisfechos);

                    $nosatisfechos = DB::table('servicios')
                    ->where('calificacion_app_conductor_calidad','<',3)->where('centrodecosto_id',$cliente)->get();
                    $datosnosatisfechos = count($nosatisfechos);
                    
                    $efectivos = DB::table('qr_rutas')
                    ->where('status',1)
                    ->where('centrodecosto_id',$cliente)
                    ->whereBetween('fecha',[$fechainicial, $fechafinal])
                    ->get();
                    $cantidadefectivos = count($efectivos);

                    $autorizados = DB::table('qr_rutas')
                    ->where('status',2)
                    ->where('centrodecosto_id',$cliente)
                    ->whereBetween('fecha',[$fechainicial, $fechafinal])
                    ->get();
                    $cantidadautorizados = count($autorizados);

                    $abstraccion = DB::table('qr_rutas')
                    ->whereNull('status')
                    ->where('centrodecosto_id',$cliente)
                    ->whereBetween('fecha',[$fechainicial, $fechafinal])
                    ->get();
                    $cantidadabstraccion = count($abstraccion);
                    
                    //QUERY RUTAS QR
                    //OBTENER PASAJEROS AMONESTADOS
                      $queryamonestados = DB::table('qr_rutas')
                      ->leftJoin('pasajeros', 'qr_rutas.id_usuario', '=', 'pasajeros.cedula')
                      ->select('qr_rutas.*','pasajeros.nombres', 'pasajeros.apellidos')
                      ->whereNull('qr_rutas.status')->where('qr_rutas.centrodecosto_id',$cliente)->whereBetween('qr_rutas.fecha',[$fechainicial,$fechafinal]);
                      $pasajerosamonestados = $queryamonestados->orderBy('pasajeros.id')->get();
                      $totalpasajeros = count($pasajerosamonestados);
                    //FIN OBTENER PASAJEROS AMONESTADOS
                    
                    //OBTENER SERVICIOS FACTURADOS
                    $queryf = DB::table('facturacion')
                         
                      ->leftJoin('servicios', 'servicios.id', '=', 'facturacion.servicio_id')
                      ->whereBetween('servicios.fecha_servicio',[$fechainicial,$fechafinal])
                      ->where('facturacion.facturado',1)
                      ->where('servicios.anulado',0)                        
                      ->where('servicios.centrodecosto_id',$cliente)
                      ->where('servicios.ruta',1)
                      ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
                      ->whereNull('servicios.pendiente_autori_eliminacion')
                      ->whereNull('servicios.afiliado_externo')                
                      ->get();
                    //CONTADOR DE SERVICIOS
                    $cantidadservicios = count($queryf);
                    //FIN OBTENER SERVICIOS FACTURADOS

                      $recorridos = DB::table('servicios')
                      ->where('centrodecosto_id',$cliente)
                      ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                      ->whereNull('servicios.pendiente_autori_eliminacion')
                      ->whereNull('servicios.afiliado_externo')
                      ->where('ruta',1)
                      ->get();
                      $recorridosrealizados = count($recorridos);

                      if($cliente==287){
                        $americas = DB::table('servicios')
                        ->where('subcentrodecosto_id',851)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                        ->get();
                        $countamericas = count($americas);

                        $toberin = DB::table('servicios')
                        ->where('subcentrodecosto_id',852)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                        ->get();
                        $counttoberin = count($toberin);

                        $torrecristal = DB::table('servicios')
                        ->where('subcentrodecosto_id',853)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                        ->get();
                        $counttorrecristal = count($torrecristal);
                        $countrutas = null;
                        $countcarnavales = null;
                      }else{
                        $rutas = DB::table('servicios')
                        ->where('subcentrodecosto_id',178)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                        ->get();
                        $countrutas = count($rutas);

                        $carnavales = DB::table('servicios')
                        ->where('subcentrodecosto_id',509)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                        ->get();
                        $countcarnavales = count($carnavales);
                        $counttoberin = null;
                        $counttorrecristal = null;
                        $countamericas = null;        
                      }


        }
      }else{
            if($fechainicial < '2020-01-01'){
                    if($fechainicial!=null){
                              echo "<script>
                                  alert('No hay datos para mostrar.');
                              </script>";
                    }

                              //FECHA INCORRECTA
                              //CONSULTA % UTILIZACIÓN DEL VEHICULO VAN
                              $consultautilizacion = "

                              SELECT  xy.fecha_dia, 
                              case 
                              when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                              ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/7)*100
                              END
                              AS 'OCUPACION', 
                              xy.tipo_vehiculo              
                              FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                              where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                              ) xy
                              where date(xy.fecha) between '20000101' and '20000101' and tipo_vehiculo = 'VAN'
                              GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                              ";
                              $informacionvan = DB::select($consultautilizacion);
                              $contadorinformacion = count($informacionvan);
                              //FIN % DE UTILIZACIÓN VAN

                              //CONSULTA % UTILIZACIÓN DEL VEHICULO AUTO
                              $consultautilizacionauto = "
                              SELECT  xy.fecha_dia, 
                              case 
                              when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                              ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
                              END
                              AS 'OCUPACION', 
                              xy.tipo_vehiculo
                              FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                              where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                              ) xy
                              where date(xy.fecha) between '20000101' and '20000101' and tipo_vehiculo = 'AUTO'
                              GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                              ";
                              $informacionauto = DB::select($consultautilizacionauto);
                              $contadorinformacionauto = count($informacionauto);
                              $resultadofinal = $contadorinformacion + $contadorinformacionauto;
                              //FIN % DE UTILIZACIÓN AUTO
                              $question = "select * from pasajeros where date(created_at) between '20000101' and '20000101' and centrodecosto_id='".$cliente."' ";
                              $registros = DB::select($question);
                              //->where('created_at',$fechafinal)
                              //->get();
                              $re = count($registros);
                              //$satisfechos = DB::table('servicios')
                              //->where('calificacion_app_conductor_calidad', '>',2.9)->where('centrodecosto_id',$cliente)->get();
                              $datossatisfechos = 0;
                              //$nosatisfechos = DB::table('servicios')
                              //->where('calificacion_app_conductor_calidad','<',3)->where('centrodecosto_id',$cliente)->get();
                              $datosnosatisfechos = 0;
                              
                              $efectivos = DB::table('qr_rutas')
                              ->where('status',1)
                              ->where('centrodecosto_id',$cliente)
                              ->whereBetween('fecha',['20000101', '20000101'])
                              ->get();
                              $cantidadefectivos = count($efectivos);
                              $autorizados = DB::table('qr_rutas')
                              ->where('status',2)
                              ->where('centrodecosto_id',$cliente)
                              ->whereBetween('fecha',['20000101', '2000101'])
                              ->get();
                              $cantidadautorizados = count($autorizados);
                              $abstraccion = DB::table('qr_rutas')
                              ->whereNull('status')
                              ->where('centrodecosto_id',$cliente)
                              ->whereBetween('fecha',['20000101', '20000101'])
                              ->get();
                              $cantidadabstraccion = count($abstraccion);
                              
                              //QUERY RUTAS QR
                              //OBTENER PASAJEROS AMONESTADOS
                                $queryamonestados = DB::table('qr_rutas')
                                ->leftJoin('pasajeros', 'qr_rutas.id_usuario', '=', 'pasajeros.cedula')
                                ->select('qr_rutas.*','pasajeros.nombres', 'pasajeros.apellidos')
                                ->whereNull('qr_rutas.status')->where('qr_rutas.centrodecosto_id',$cliente)->whereBetween('qr_rutas.fecha',['20000101','20000101']);
                                $pasajerosamonestados = $queryamonestados->orderBy('pasajeros.id')->get();
                                $totalpasajeros = count($pasajerosamonestados);
                              //FIN OBTENER PASAJEROS AMONESTADOS
                              
                              //OBTENER SERVICIOS FACTURADOS
                              $queryf = DB::table('facturacion')
                                   
                                ->leftJoin('servicios', 'servicios.id', '=', 'facturacion.servicio_id')
                                ->whereBetween('servicios.fecha_servicio',['20000101','20000101'])
                                ->where('facturacion.facturado',1)
                                ->where('servicios.anulado',0)                        
                                ->where('servicios.centrodecosto_id',$cliente)
                                ->where('servicios.ruta',1)
                                ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
                                ->whereNull('servicios.pendiente_autori_eliminacion')
                                ->whereNull('servicios.afiliado_externo')                
                                ->get();
                              //CONTADOR DE SERVICIOS
                              $cantidadservicios = count($queryf);
                              //FIN OBTENER SERVICIOS FACTURADOS

                                $recorridos = DB::table('servicios')
                                ->where('centrodecosto_id',$cliente)
                                ->whereBetween('fecha_servicio',['20000101','20000101'])
                                ->whereNull('servicios.pendiente_autori_eliminacion')
                                ->whereNull('servicios.afiliado_externo')
                                ->where('ruta',1)
                                ->get();
                                $recorridosrealizados = count($recorridos);

                                if($cliente==287){
                                  $americas = DB::table('servicios')
                                  ->where('subcentrodecosto_id',851)
                                  ->whereNull('pendiente_autori_eliminacion')
                                  ->whereBetween('fecha_servicio',['20000101','20000101'])
                                  ->get();
                                  $countamericas = count($americas);

                                  $toberin = DB::table('servicios')
                                  ->where('subcentrodecosto_id',852)
                                  ->whereNull('pendiente_autori_eliminacion')
                                  ->whereBetween('fecha_servicio',['20000101','20000101'])
                                  ->get();
                                  $counttoberin = count($toberin);

                                  $torrecristal = DB::table('servicios')
                                  ->where('subcentrodecosto_id',853)
                                  ->whereNull('pendiente_autori_eliminacion')
                                  ->whereBetween('fecha_servicio',['20000101','20000101'])
                                  ->get();
                                  $counttorrecristal = count($torrecristal);
                                  $countrutas = null;
                                  $countcarnavales = null;
                                }else{
                                  $rutas = DB::table('servicios')
                                  ->where('subcentrodecosto_id',178)
                                  ->whereNull('pendiente_autori_eliminacion')
                                  ->whereBetween('fecha_servicio',['20000101','20000101'])
                                  ->get();
                                  $countrutas = count($rutas);

                                  $carnavales = DB::table('servicios')
                                  ->where('subcentrodecosto_id',509)
                                  ->whereNull('pendiente_autori_eliminacion')
                                  ->whereBetween('fecha_servicio',['20000101','20000101'])
                                  ->get();
                                  $countcarnavales = count($carnavales);
                                  $counttoberin = null;
                                  $counttorrecristal = null;
                                  $countamericas = null;        
                                }
                  }else{

                    //CONSULTA SGS BOG
                    //CONSULTA % UTILIZACIÓN DEL VEHICULO VAN
                    $consultautilizacion = "
                    SELECT  xy.fecha_dia, 
                    case 
                    when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                    ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
                    END
                    AS 'OCUPACION', 
                    xy.tipo_vehiculo              
                    FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                    where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                    ) xy
                    where date(xy.fecha) between '".$fechainicial."' and '".$fechafinal."' and tipo_vehiculo = 'VAN'
                    GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                    ";
                    $informacionvan = DB::select($consultautilizacion);
                    $contadorinformacion = count($informacionvan);
                    //FIN % DE UTILIZACIÓN VAN

                    //CONSULTA % UTILIZACIÓN DEL VEHICULO AUTO
                    $consultautilizacionauto = "
                    SELECT  xy.fecha_dia, 
                    case 
                    when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                    ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
                    END
                    AS 'OCUPACION', 
                    xy.tipo_vehiculo
                    FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                    where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                    ) xy
                    where date(xy.fecha) between '".$fechainicial."' and '".$fechafinal."' and tipo_vehiculo = 'AUTO'
                    GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                    ";
                    $informacionauto = DB::select($consultautilizacionauto);
                    $contadorinformacionauto = count($informacionauto);

                    $resultadofinal = $contadorinformacion + $contadorinformacionauto;
                    //FIN % DE UTILIZACIÓN AUTO

                    $question = "select * from pasajeros where date(created_at) between '".$fechainicial."' and '".$fechafinal."' and centrodecosto_id='".$cliente."' ";
                      $registros = DB::select($question);
                      //->where('created_at',$fechafinal)
                      //->get();
                      $re = count($registros);

                      /*$satisfechos = DB::table('servicios')
                      ->where('calificacion_app_conductor_calidad', '>',2.9)->where('centrodecosto_id',$cliente)->get();*/
                      $datossatisfechos = 0;

                      /*$nosatisfechos = DB::table('servicios')
                      ->where('calificacion_app_conductor_calidad','<',3)->where('centrodecosto_id',$cliente)->get();*/
                      $datosnosatisfechos = 0;
                      
                      $efectivos = DB::table('qr_rutas')
                      ->where('status',1)
                      ->where('centrodecosto_id',$cliente)
                      ->whereBetween('fecha',[$fechainicial, $fechafinal])
                      ->get();
                      $cantidadefectivos = count($efectivos);

                      $autorizados = DB::table('qr_rutas')
                      ->where('status',2)
                      ->where('centrodecosto_id',$cliente)
                      ->whereBetween('fecha',[$fechainicial, $fechafinal])
                      ->get();
                      $cantidadautorizados = count($autorizados);

                      $abstraccion = DB::table('qr_rutas')
                      ->whereNull('status')
                      ->where('centrodecosto_id',$cliente)
                      ->whereBetween('fecha',[$fechainicial, $fechafinal])
                      ->get();
                      $cantidadabstraccion = count($abstraccion);
                      
                      //QUERY RUTAS QR
                      //OBTENER PASAJEROS AMONESTADOS
                        $queryamonestados = DB::table('qr_rutas')
                        ->leftJoin('pasajeros', 'qr_rutas.id_usuario', '=', 'pasajeros.cedula')
                        ->select('qr_rutas.*','pasajeros.nombres', 'pasajeros.apellidos')
                        ->whereNull('qr_rutas.status')->where('qr_rutas.centrodecosto_id',$cliente)->whereBetween('qr_rutas.fecha',[$fechainicial,$fechafinal]);
                        $pasajerosamonestados = $queryamonestados->orderBy('pasajeros.id')->get();
                        $totalpasajeros = count($pasajerosamonestados);
                      //FIN OBTENER PASAJEROS AMONESTADOS
                      
                      //OBTENER SERVICIOS FACTURADOS
                      $queryf = DB::table('facturacion')
                           
                        ->leftJoin('servicios', 'servicios.id', '=', 'facturacion.servicio_id')
                        ->whereBetween('servicios.fecha_servicio',[$fechainicial,$fechafinal])
                        ->where('facturacion.facturado',1)
                        ->where('servicios.anulado',0)                        
                        ->where('servicios.centrodecosto_id',$cliente)
                        ->where('servicios.ruta',1)
                        ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
                        ->whereNull('servicios.pendiente_autori_eliminacion')
                        ->whereNull('servicios.afiliado_externo')                
                        ->get();
                      //CONTADOR DE SERVICIOS
                      $cantidadservicios = count($queryf);
                      //FIN OBTENER SERVICIOS FACTURADOS

                        $recorridos = DB::table('servicios')
                        ->where('centrodecosto_id',$cliente)
                        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                        ->whereNull('servicios.pendiente_autori_eliminacion')
                        ->whereNull('servicios.afiliado_externo')
                        ->where('ruta',1)
                        ->get();
                        $recorridosrealizados = count($recorridos);

                        if($cliente==287){
                          $americas = DB::table('servicios')
                          ->where('subcentrodecosto_id',851)
                          ->whereNull('pendiente_autori_eliminacion')
                          ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                          ->get();
                          $countamericas = count($americas);

                          $toberin = DB::table('servicios')
                          ->where('subcentrodecosto_id',852)
                          ->whereNull('pendiente_autori_eliminacion')
                          ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                          ->get();
                          $counttoberin = count($toberin);

                          $torrecristal = DB::table('servicios')
                          ->where('subcentrodecosto_id',853)
                          ->whereNull('pendiente_autori_eliminacion')
                          ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                          ->get();
                          $counttorrecristal = count($torrecristal);
                          $countrutas = null;
                          $countcarnavales = null;
                        }else{
                          $rutas = DB::table('servicios')
                          ->where('subcentrodecosto_id',178)
                          ->whereNull('pendiente_autori_eliminacion')
                          ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                          ->get();
                          $countrutas = count($rutas);

                          $carnavales = DB::table('servicios')
                          ->where('subcentrodecosto_id',509)
                          ->whereNull('pendiente_autori_eliminacion')
                          ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                          ->get();
                          $countcarnavales = count($carnavales);
                          $counttoberin = null;
                          $counttorrecristal = null;
                          $countamericas = null;        
                        }
                      }

      }

      //FIN CONSULTA OBTENER DATOS
      

      return View::make('portalusuarios.admin.dashboard.index',[
        'permisos' => $permisos,
        'idusuario' => $idusuario,
        'cliente' => $cliente,
        'fechainicial' => $fechainicial,
        'registros' => $re,
        'serviciosfacturados' => $cantidadservicios,
        'recorridosrealizados' => $recorridosrealizados,
        'cantidadefectivos' => $cantidadefectivos,
        'cantidadautorizados' => $cantidadautorizados,
        'cantidadabstraccion' => $cantidadabstraccion,
        'datossatisfechos' => $datossatisfechos,
        'datosnosatisfechos' => $datosnosatisfechos,
        'nombrecentrodecosto' => $nombrecentrodecosto,    
        'pasajerosamonestados' => $pasajerosamonestados,
        'totalpasajeros' => $totalpasajeros,
        'infovan' => $informacionvan,
        'infoauto' => $informacionauto,
        'resultadofinal' => $resultadofinal,
        'counttorrecristal' =>$counttorrecristal,
        'counttoberin' => $counttoberin,
        'countamericas' => $countamericas,
        'countrutas' => $countrutas,
        'countcarnavales' => $countcarnavales,
        //'info' => $informacion,
        //'coun' => $contadorinformacion
        'contadorinformacion' => $contadorinformacion,
        'contadorinformacionauto' => $contadorinformacionauto
      ]);
    }

  }


  public function getGraficos(){

    if (Sentry::check()){

        $id_rol = Sentry::getUser()->id_rol;
        $cliente = Sentry::getUser()->centrodecosto_id;  
        $nombrecentrodecosto = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->portalusuarios->admin->ver;

    }else{
        $ver = null;
    }

    if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on') {

      return View::make('portalusuarios.admin.dashboard');

    }else{
      $registros = DB::table('pasajeros')
      ->get();
      $example = " SELECT * FROM pasajeros WHERE DATE(created_at) BETWEEN '20110101' AND '20191231'";
      $resultado = DB::select($example);
      $re = count($resultado);

      //CONSULTA % UTILIZACIÓN DEL VEHICULO VAN
        $consultautilizacion = "

        SELECT  xy.fecha_dia, 

            case 

            when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
            ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
            END
            AS 'OCUPACION', 

            xy.tipo_vehiculo

              

            FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),

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
            where a.centrodecosto_id=287 AND a.motivo_eliminacion is null 

            ) xy

            where month(xy.fecha)='12' and tipo_vehiculo = 'VAN'
            GROUP BY xy.tipo_vehiculo,xy.fecha_dia

            ";

            $informacionvan = DB::select($consultautilizacion);
            $contadorinformacion = count($informacionvan);
      //FIN % DE UTILIZACIÓN VAN

      

      //CONSULTA % UTILIZACIÓN DEL VEHICULO AUTO
        $consultautilizacionauto = "

        SELECT  xy.fecha_dia, 

            case 

            when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
            ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
            END
            AS 'OCUPACION', 

            xy.tipo_vehiculo

              

            FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),

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
            where a.centrodecosto_id=287 AND a.motivo_eliminacion is null 

            ) xy

            where month(xy.fecha)='12' and tipo_vehiculo = 'AUTO'
            GROUP BY xy.tipo_vehiculo,xy.fecha_dia

            ";

            $informacionauto = DB::select($consultautilizacionauto);
            $contadorinformacionauto = count($informacionauto);
      //FIN % DE UTILIZACIÓN AUTO

          /*  //COMPORTAMIENTO MENSUAL EN TIEMPO DE RECORRIDO
              $comportamiento = DB::table('servicios')->

            //FIN COMPORTAMIENTO MENSUAL EN TIEMPO DE RECORRIDO
*/


      $satisfechos = DB::table('servicios')
      ->where('calificacion_app_conductor_calidad', '>',2.9)->where('centrodecosto_id',$cliente)->get();
      $datossatisfechos = count($satisfechos);

      $nosatisfechos = DB::table('servicios')
      ->where('calificacion_app_conductor_calidad','<',3)->where('centrodecosto_id',$cliente)->get();
      $datosnosatisfechos = count($nosatisfechos);
      //
      $efectivos = DB::table('qr_rutas')->where('status',1)->where('centrodecosto_id',19)->get();
      $cantidadefectivos = count($efectivos);
      $autorizados = DB::table('qr_rutas')->where('status',2)->where('centrodecosto_id',19)->get();
      $cantidadautorizados = count($autorizados);
      $abstraccion = DB::table('qr_rutas')->whereNull('status')->where('centrodecosto_id',19)->get();
      $cantidadabstraccion = count($abstraccion);
      
      //QUERY RUTAS QR
      //OBTENER PASAJEROS AMONESTADOS
        $queryamonestados = DB::table('qr_rutas')
        ->leftJoin('pasajeros', 'qr_rutas.id_usuario', '=', 'pasajeros.cedula')
        ->select('qr_rutas.*',
                'pasajeros.nombres', 'pasajeros.apellidos')
        ->whereNull('qr_rutas.status')->where('qr_rutas.centrodecosto_id',19);
        $pasajerosamonestados = $queryamonestados->orderBy('pasajeros.id')->get();
        $totalpasajeros = count($pasajerosamonestados);
        //array_unique($pasajerosamonestados);
      //FIN OBTENER PASAJEROS AMONESTADOS
      
      //OBTENER SERVICIOS FACTURADOS
      $query = DB::table('facturacion')
           
            ->leftJoin('servicios', 'servicios.id', '=', 'facturacion.servicio_id')
            ->where('facturacion.facturado',1)
            ->where('servicios.anulado',0)                        
            ->where('servicios.centrodecosto_id',$cliente)
            ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
            ->whereNull('servicios.pendiente_autori_eliminacion')
            ->whereNull('servicios.afiliado_externo')
            ->where('fecha_servicio',date('Y-m-d'))
            ->get();
      //CONTADOR DE SERVICIOS
      $cantidadservicios = count($query);
      //FIN OBTENER SERVICIOS FACTURADOS

        $recorridos = DB::table('servicios')
        ->where('centrodecosto_id',$cliente)
        ->whereNull('servicios.pendiente_autori_eliminacion')
        ->whereNull('servicios.afiliado_externo')
        ->where('ruta',1)
        ->get();
        $recorridosrealizados = count($recorridos);
        $americas = DB::table('servicios')
        ->where('subcentrodecosto_id',851)
        //->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->get();
        $countamericas = count($americas);

        $toberin = DB::table('servicios')
        ->where('subcentrodecosto_id',852)
        //->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->get();
        $counttoberin = count($toberin);

        $torrecristal = DB::table('servicios')
        ->where('subcentrodecosto_id',853)
        //->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->get();
        $counttorrecristal = count($torrecristal);
        //        

      return View::make('portalusuarios.admin.dashboard.dashboard', [
        'permisos' => $permisos,
        'registros' => 0,
        'serviciosfacturados' => 0,
        'recorridosrealizados' => 0,
        'cantidadefectivos' => 0,
        'cantidadautorizados' => 0,
        'cantidadabstraccion' => 0,
        'datossatisfechos' => 0,
        'datosnosatisfechos' => 0,
        'nombrecentrodecosto' => $nombrecentrodecosto,    
        'pasajerosamonestados' => $pasajerosamonestados,
        'totalpasajeros' => $totalpasajeros,
        'infovan' => $informacionvan,
        'infoauto' => $informacionauto,
        'counttorrecristal' =>$counttorrecristal,
        'counttoberin' => $counttoberin,
        'countamericas' => $countamericas,
        'contadorinformacion' => $contadorinformacion,
        'contadorinformacionauto' => $contadorinformacionauto
      ]);

    }

  }

  public function getObtenerdatos(){
    
    if (Sentry::check()){

        $id_rol = Sentry::getUser()->id_rol;
        $idusuario = Sentry::getUser()->idusuario;
        $cliente = Sentry::getUser()->centrodecosto_id;  
        $nombrecentrodecosto = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->portalusuarios->admin->ver;

    }else{
        $ver = null;
    }
    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on') {

      return View::make('portalusuarios.admin.dashboard');

    }else{

      $fechainicial = Input::get('md_fecha_inicial');
      $fechafinal = Input::get('md_fecha_final');
      
      //INICIO CONSULTA OBTENER DATOS
      
      //BARRANQUILLA
      if($cliente==19){
        if($fechainicial < '2020-01-29'){
          if($fechainicial!=null){
                    echo "<script>
                        alert('No hay datos para mostrar.');
                    </script>";
          }

                    //FECHA INCORRECTA
                    //CONSULTA % UTILIZACIÓN DEL VEHICULO VAN
                    $consultautilizacion = "

                    SELECT  xy.fecha_dia, 
                    case 
                    when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                    ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/7)*100
                    END
                    AS 'OCUPACION', 
                    xy.tipo_vehiculo              
                    FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                    where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                    ) xy
                    where date(xy.fecha) between '20000101' and '20000101' and tipo_vehiculo = 'VAN'
                    GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                    ";
                    $informacionvan = DB::select($consultautilizacion);
                    $contadorinformacion = count($informacionvan);
                    //FIN % DE UTILIZACIÓN VAN

                    //CONSULTA % UTILIZACIÓN DEL VEHICULO AUTO
                    $consultautilizacionauto = "
                    SELECT  xy.fecha_dia, 
                    case 
                    when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                    ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
                    END
                    AS 'OCUPACION', 
                    xy.tipo_vehiculo
                    FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                    where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                    ) xy
                    where date(xy.fecha) between '20000101' and '20000101' and tipo_vehiculo = 'AUTO'
                    GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                    ";
                    $informacionauto = DB::select($consultautilizacionauto);
                    $contadorinformacionauto = count($informacionauto);
                    $resultadofinal = $contadorinformacion + $contadorinformacionauto;
                    //FIN % DE UTILIZACIÓN AUTO
                    $question = "select * from pasajeros where date(created_at) between '20000101' and '20000101' and centrodecosto_id='".$cliente."' ";
                    $registros = DB::select($question);
                    //->where('created_at',$fechafinal)
                    //->get();
                    $re = count($registros);
                    //$satisfechos = DB::table('servicios')
                    //->where('calificacion_app_conductor_calidad', '>',2.9)->where('centrodecosto_id',$cliente)->get();
                    $datossatisfechos = 0;
                    //$nosatisfechos = DB::table('servicios')
                    //->where('calificacion_app_conductor_calidad','<',3)->where('centrodecosto_id',$cliente)->get();
                    $datosnosatisfechos = 0;
                    
                    $efectivos = DB::table('qr_rutas')
                    ->where('status',1)
                    ->where('centrodecosto_id',$cliente)
                    ->whereBetween('fecha',['20000101', '20000101'])
                    ->get();
                    $cantidadefectivos = count($efectivos);
                    $autorizados = DB::table('qr_rutas')
                    ->where('status',2)
                    ->where('centrodecosto_id',$cliente)
                    ->whereBetween('fecha',['20000101', '2000101'])
                    ->get();
                    $cantidadautorizados = count($autorizados);
                    $abstraccion = DB::table('qr_rutas')
                    ->whereNull('status')
                    ->where('centrodecosto_id',$cliente)
                    ->whereBetween('fecha',['20000101', '20000101'])
                    ->get();
                    $cantidadabstraccion = count($abstraccion);
                    
                    //QUERY RUTAS QR
                    //OBTENER PASAJEROS AMONESTADOS
                      $queryamonestados = DB::table('qr_rutas')
                      ->leftJoin('pasajeros', 'qr_rutas.id_usuario', '=', 'pasajeros.cedula')
                      ->select('qr_rutas.*','pasajeros.nombres', 'pasajeros.apellidos')
                      ->whereNull('qr_rutas.status')->where('qr_rutas.centrodecosto_id',$cliente)->whereBetween('qr_rutas.fecha',['20000101','20000101']);
                      $pasajerosamonestados = $queryamonestados->orderBy('pasajeros.id')->get();
                      $totalpasajeros = count($pasajerosamonestados);
                    //FIN OBTENER PASAJEROS AMONESTADOS
                    
                    //OBTENER SERVICIOS FACTURADOS
                    $queryf = DB::table('facturacion')
                         
                      ->leftJoin('servicios', 'servicios.id', '=', 'facturacion.servicio_id')
                      ->whereBetween('servicios.fecha_servicio',['20000101','20000101'])
                      ->where('facturacion.facturado',1)
                      ->where('servicios.anulado',0)                        
                      ->where('servicios.centrodecosto_id',$cliente)
                      ->where('servicios.ruta',1)
                      ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
                      ->whereNull('servicios.pendiente_autori_eliminacion')
                      ->whereNull('servicios.afiliado_externo')                
                      ->get();
                    //CONTADOR DE SERVICIOS
                    $cantidadservicios = count($queryf);
                    //FIN OBTENER SERVICIOS FACTURADOS

                      $recorridos = DB::table('servicios')
                      ->where('centrodecosto_id',$cliente)
                      ->whereBetween('fecha_servicio',['20000101','20000101'])
                      ->whereNull('servicios.pendiente_autori_eliminacion')
                      ->whereNull('servicios.afiliado_externo')
                      ->where('ruta',1)
                      ->get();
                      $recorridosrealizados = count($recorridos);

                      if($cliente==287){
                        $americas = DB::table('servicios')
                        ->where('subcentrodecosto_id',851)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',['20000101','20000101'])
                        ->get();
                        $countamericas = count($americas);

                        $toberin = DB::table('servicios')
                        ->where('subcentrodecosto_id',852)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',['20000101','20000101'])
                        ->get();
                        $counttoberin = count($toberin);

                        $torrecristal = DB::table('servicios')
                        ->where('subcentrodecosto_id',853)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',['20000101','20000101'])
                        ->get();
                        $counttorrecristal = count($torrecristal);
                        $countrutas = null;
                        $countcarnavales = null;
                      }else{
                        $rutas = DB::table('servicios')
                        ->where('subcentrodecosto_id',178)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',['20000101','20000101'])
                        ->get();
                        $countrutas = count($rutas);

                        $carnavales = DB::table('servicios')
                        ->where('subcentrodecosto_id',509)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',['20000101','20000101'])
                        ->get();
                        $countcarnavales = count($carnavales);
                        $counttoberin = null;
                        $counttorrecristal = null;
                        $countamericas = null;        
                      }

        }else{
                    //FECHA CORRECTA
                    //CONSULTA % UTILIZACIÓN DEL VEHICULO VAN
                    $consultautilizacion = "

                    SELECT  xy.fecha_dia, 
                    case 
                    when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                    ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/7)*100
                    END
                    AS 'OCUPACION', 
                    xy.tipo_vehiculo              
                    FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                    where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                    ) xy
                    where date(xy.fecha) between '".$fechainicial."' and '".$fechafinal."' and tipo_vehiculo = 'VAN'
                    GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                    ";
                    $informacionvan = DB::select($consultautilizacion);
                    $contadorinformacion = count($informacionvan);
                    //FIN % DE UTILIZACIÓN VAN

                    //CONSULTA % UTILIZACIÓN DEL VEHICULO AUTO
                    $consultautilizacionauto = "
                    SELECT  xy.fecha_dia, 
                    case 
                    when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                    ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
                    END
                    AS 'OCUPACION', 
                    xy.tipo_vehiculo
                    FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                    where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                    ) xy
                    where date(xy.fecha) between '".$fechainicial."' and '".$fechafinal."' and tipo_vehiculo = 'AUTO'
                    GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                    ";
                    $informacionauto = DB::select($consultautilizacionauto);
                    $contadorinformacionauto = count($informacionauto);
                    $resultadofinal = $contadorinformacion + $contadorinformacionauto;
                    //FIN % DE UTILIZACIÓN AUTO
                    $question = "select * from pasajeros where date(created_at) between '".$fechainicial."' and '".$fechafinal."' and centrodecosto_id='".$cliente."' ";
                    $registros = DB::select($question);
                    //->where('created_at',$fechafinal)
                    //->get();
                    $re = count($registros);

                    $satisfechos = DB::table('servicios')
                    ->where('calificacion_app_conductor_calidad', '>',2.9)->where('centrodecosto_id',$cliente)->get();
                    $datossatisfechos = count($satisfechos);

                    $nosatisfechos = DB::table('servicios')
                    ->where('calificacion_app_conductor_calidad','<',3)->where('centrodecosto_id',$cliente)->get();
                    $datosnosatisfechos = count($nosatisfechos);
                    
                    $efectivos = DB::table('qr_rutas')
                    ->where('status',1)
                    ->where('centrodecosto_id',$cliente)
                    ->whereBetween('fecha',[$fechainicial, $fechafinal])
                    ->get();
                    $cantidadefectivos = count($efectivos);

                    $autorizados = DB::table('qr_rutas')
                    ->where('status',2)
                    ->where('centrodecosto_id',$cliente)
                    ->whereBetween('fecha',[$fechainicial, $fechafinal])
                    ->get();
                    $cantidadautorizados = count($autorizados);

                    $abstraccion = DB::table('qr_rutas')
                    ->whereNull('status')
                    ->where('centrodecosto_id',$cliente)
                    ->whereBetween('fecha',[$fechainicial, $fechafinal])
                    ->get();
                    $cantidadabstraccion = count($abstraccion);
                    
                    //QUERY RUTAS QR
                    //OBTENER PASAJEROS AMONESTADOS
                      $queryamonestados = DB::table('qr_rutas')
                      ->leftJoin('pasajeros', 'qr_rutas.id_usuario', '=', 'pasajeros.cedula')
                      ->select('qr_rutas.*','pasajeros.nombres', 'pasajeros.apellidos')
                      ->whereNull('qr_rutas.status')->where('qr_rutas.centrodecosto_id',$cliente)->whereBetween('qr_rutas.fecha',[$fechainicial,$fechafinal]);
                      $pasajerosamonestados = $queryamonestados->orderBy('pasajeros.id')->get();
                      $totalpasajeros = count($pasajerosamonestados);
                    //FIN OBTENER PASAJEROS AMONESTADOS
                    
                    //OBTENER SERVICIOS FACTURADOS
                    $queryf = DB::table('facturacion')
                         
                      ->leftJoin('servicios', 'servicios.id', '=', 'facturacion.servicio_id')
                      ->whereBetween('servicios.fecha_servicio',[$fechainicial,$fechafinal])
                      ->where('facturacion.facturado',1)
                      ->where('servicios.anulado',0)                        
                      ->where('servicios.centrodecosto_id',$cliente)
                      ->where('servicios.ruta',1)
                      ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
                      ->whereNull('servicios.pendiente_autori_eliminacion')
                      ->whereNull('servicios.afiliado_externo')                
                      ->get();
                    //CONTADOR DE SERVICIOS
                    $cantidadservicios = count($queryf);
                    //FIN OBTENER SERVICIOS FACTURADOS

                      $recorridos = DB::table('servicios')
                      ->where('centrodecosto_id',$cliente)
                      ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                      ->whereNull('servicios.pendiente_autori_eliminacion')
                      ->whereNull('servicios.afiliado_externo')
                      ->where('ruta',1)
                      ->get();
                      $recorridosrealizados = count($recorridos);

                      if($cliente==287){
                        $americas = DB::table('servicios')
                        ->where('subcentrodecosto_id',851)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                        ->get();
                        $countamericas = count($americas);

                        $toberin = DB::table('servicios')
                        ->where('subcentrodecosto_id',852)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                        ->get();
                        $counttoberin = count($toberin);

                        $torrecristal = DB::table('servicios')
                        ->where('subcentrodecosto_id',853)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                        ->get();
                        $counttorrecristal = count($torrecristal);
                        $countrutas = null;
                        $countcarnavales = null;
                      }else{
                        $rutas = DB::table('servicios')
                        ->where('subcentrodecosto_id',178)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                        ->get();
                        $countrutas = count($rutas);

                        $carnavales = DB::table('servicios')
                        ->where('subcentrodecosto_id',509)
                        ->whereNull('pendiente_autori_eliminacion')
                        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                        ->get();
                        $countcarnavales = count($carnavales);
                        $counttoberin = null;
                        $counttorrecristal = null;
                        $countamericas = null;        
                      }


        }
      }else{
            if($fechainicial < '2020-01-01'){
                    if($fechainicial!=null){
                              echo "<script>
                                  alert('No hay datos para mostrar.');
                              </script>";
                    }

                              //FECHA INCORRECTA
                              //CONSULTA % UTILIZACIÓN DEL VEHICULO VAN
                              $consultautilizacion = "

                              SELECT  xy.fecha_dia, 
                              case 
                              when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                              ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/7)*100
                              END
                              AS 'OCUPACION', 
                              xy.tipo_vehiculo              
                              FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                              where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                              ) xy
                              where date(xy.fecha) between '20000101' and '20000101' and tipo_vehiculo = 'VAN'
                              GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                              ";
                              $informacionvan = DB::select($consultautilizacion);
                              $contadorinformacion = count($informacionvan);
                              //FIN % DE UTILIZACIÓN VAN

                              //CONSULTA % UTILIZACIÓN DEL VEHICULO AUTO
                              $consultautilizacionauto = "
                              SELECT  xy.fecha_dia, 
                              case 
                              when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                              ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
                              END
                              AS 'OCUPACION', 
                              xy.tipo_vehiculo
                              FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                              where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                              ) xy
                              where date(xy.fecha) between '20000101' and '20000101' and tipo_vehiculo = 'AUTO'
                              GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                              ";
                              $informacionauto = DB::select($consultautilizacionauto);
                              $contadorinformacionauto = count($informacionauto);
                              $resultadofinal = $contadorinformacion + $contadorinformacionauto;
                              //FIN % DE UTILIZACIÓN AUTO
                              $question = "select * from pasajeros where date(created_at) between '20000101' and '20000101' and centrodecosto_id='".$cliente."' ";
                              $registros = DB::select($question);
                              //->where('created_at',$fechafinal)
                              //->get();
                              $re = count($registros);
                              //$satisfechos = DB::table('servicios')
                              //->where('calificacion_app_conductor_calidad', '>',2.9)->where('centrodecosto_id',$cliente)->get();
                              $datossatisfechos = 0;
                              //$nosatisfechos = DB::table('servicios')
                              //->where('calificacion_app_conductor_calidad','<',3)->where('centrodecosto_id',$cliente)->get();
                              $datosnosatisfechos = 0;
                              
                              $efectivos = DB::table('qr_rutas')
                              ->where('status',1)
                              ->where('centrodecosto_id',$cliente)
                              ->whereBetween('fecha',['20000101', '20000101'])
                              ->get();
                              $cantidadefectivos = count($efectivos);
                              $autorizados = DB::table('qr_rutas')
                              ->where('status',2)
                              ->where('centrodecosto_id',$cliente)
                              ->whereBetween('fecha',['20000101', '2000101'])
                              ->get();
                              $cantidadautorizados = count($autorizados);
                              $abstraccion = DB::table('qr_rutas')
                              ->whereNull('status')
                              ->where('centrodecosto_id',$cliente)
                              ->whereBetween('fecha',['20000101', '20000101'])
                              ->get();
                              $cantidadabstraccion = count($abstraccion);
                              
                              //QUERY RUTAS QR
                              //OBTENER PASAJEROS AMONESTADOS
                                $queryamonestados = DB::table('qr_rutas')
                                ->leftJoin('pasajeros', 'qr_rutas.id_usuario', '=', 'pasajeros.cedula')
                                ->select('qr_rutas.*','pasajeros.nombres', 'pasajeros.apellidos')
                                ->whereNull('qr_rutas.status')->where('qr_rutas.centrodecosto_id',$cliente)->whereBetween('qr_rutas.fecha',['20000101','20000101']);
                                $pasajerosamonestados = $queryamonestados->orderBy('pasajeros.id')->get();
                                $totalpasajeros = count($pasajerosamonestados);
                              //FIN OBTENER PASAJEROS AMONESTADOS
                              
                              //OBTENER SERVICIOS FACTURADOS
                              $queryf = DB::table('facturacion')
                                   
                                ->leftJoin('servicios', 'servicios.id', '=', 'facturacion.servicio_id')
                                ->whereBetween('servicios.fecha_servicio',['20000101','20000101'])
                                ->where('facturacion.facturado',1)
                                ->where('servicios.anulado',0)                        
                                ->where('servicios.centrodecosto_id',$cliente)
                                ->where('servicios.ruta',1)
                                ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
                                ->whereNull('servicios.pendiente_autori_eliminacion')
                                ->whereNull('servicios.afiliado_externo')                
                                ->get();
                              //CONTADOR DE SERVICIOS
                              $cantidadservicios = count($queryf);
                              //FIN OBTENER SERVICIOS FACTURADOS

                                $recorridos = DB::table('servicios')
                                ->where('centrodecosto_id',$cliente)
                                ->whereBetween('fecha_servicio',['20000101','20000101'])
                                ->whereNull('servicios.pendiente_autori_eliminacion')
                                ->whereNull('servicios.afiliado_externo')
                                ->where('ruta',1)
                                ->get();
                                $recorridosrealizados = count($recorridos);

                                if($cliente==287){
                                  $americas = DB::table('servicios')
                                  ->where('subcentrodecosto_id',851)
                                  ->whereNull('pendiente_autori_eliminacion')
                                  ->whereBetween('fecha_servicio',['20000101','20000101'])
                                  ->get();
                                  $countamericas = count($americas);

                                  $toberin = DB::table('servicios')
                                  ->where('subcentrodecosto_id',852)
                                  ->whereNull('pendiente_autori_eliminacion')
                                  ->whereBetween('fecha_servicio',['20000101','20000101'])
                                  ->get();
                                  $counttoberin = count($toberin);

                                  $torrecristal = DB::table('servicios')
                                  ->where('subcentrodecosto_id',853)
                                  ->whereNull('pendiente_autori_eliminacion')
                                  ->whereBetween('fecha_servicio',['20000101','20000101'])
                                  ->get();
                                  $counttorrecristal = count($torrecristal);
                                  $countrutas = null;
                                  $countcarnavales = null;
                                }else{
                                  $rutas = DB::table('servicios')
                                  ->where('subcentrodecosto_id',178)
                                  ->whereNull('pendiente_autori_eliminacion')
                                  ->whereBetween('fecha_servicio',['20000101','20000101'])
                                  ->get();
                                  $countrutas = count($rutas);

                                  $carnavales = DB::table('servicios')
                                  ->where('subcentrodecosto_id',509)
                                  ->whereNull('pendiente_autori_eliminacion')
                                  ->whereBetween('fecha_servicio',['20000101','20000101'])
                                  ->get();
                                  $countcarnavales = count($carnavales);
                                  $counttoberin = null;
                                  $counttorrecristal = null;
                                  $countamericas = null;        
                                }
                  }else{

                    //CONSULTA SGS BOG
                    //CONSULTA % UTILIZACIÓN DEL VEHICULO VAN
                    $consultautilizacion = "
                    SELECT  xy.fecha_dia, 
                    case 
                    when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                    ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
                    END
                    AS 'OCUPACION', 
                    xy.tipo_vehiculo              
                    FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                    where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                    ) xy
                    where date(xy.fecha) between '".$fechainicial."' and '".$fechafinal."' and tipo_vehiculo = 'VAN'
                    GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                    ";
                    $informacionvan = DB::select($consultautilizacion);
                    $contadorinformacion = count($informacionvan);
                    //FIN % DE UTILIZACIÓN VAN

                    //CONSULTA % UTILIZACIÓN DEL VEHICULO AUTO
                    $consultautilizacionauto = "
                    SELECT  xy.fecha_dia, 
                    case 
                    when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
                    ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
                    END
                    AS 'OCUPACION', 
                    xy.tipo_vehiculo
                    FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),
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
                    where a.centrodecosto_id='$cliente' AND a.motivo_eliminacion is null 
                    ) xy
                    where date(xy.fecha) between '".$fechainicial."' and '".$fechafinal."' and tipo_vehiculo = 'AUTO'
                    GROUP BY xy.tipo_vehiculo,xy.fecha_dia
                    ";
                    $informacionauto = DB::select($consultautilizacionauto);
                    $contadorinformacionauto = count($informacionauto);

                    $resultadofinal = $contadorinformacion + $contadorinformacionauto;
                    //FIN % DE UTILIZACIÓN AUTO

                    $question = "select * from pasajeros where date(created_at) between '".$fechainicial."' and '".$fechafinal."' and centrodecosto_id='".$cliente."' ";
                      $registros = DB::select($question);
                      //->where('created_at',$fechafinal)
                      //->get();
                      $re = count($registros);

                      /*$satisfechos = DB::table('servicios')
                      ->where('calificacion_app_conductor_calidad', '>',2.9)->where('centrodecosto_id',$cliente)->get();*/
                      $datossatisfechos = 0;

                      /*$nosatisfechos = DB::table('servicios')
                      ->where('calificacion_app_conductor_calidad','<',3)->where('centrodecosto_id',$cliente)->get();*/
                      $datosnosatisfechos = 0;
                      
                      $efectivos = DB::table('qr_rutas')
                      ->where('status',1)
                      ->where('centrodecosto_id',$cliente)
                      ->whereBetween('fecha',[$fechainicial, $fechafinal])
                      ->get();
                      $cantidadefectivos = count($efectivos);

                      $autorizados = DB::table('qr_rutas')
                      ->where('status',2)
                      ->where('centrodecosto_id',$cliente)
                      ->whereBetween('fecha',[$fechainicial, $fechafinal])
                      ->get();
                      $cantidadautorizados = count($autorizados);

                      $abstraccion = DB::table('qr_rutas')
                      ->whereNull('status')
                      ->where('centrodecosto_id',$cliente)
                      ->whereBetween('fecha',[$fechainicial, $fechafinal])
                      ->get();
                      $cantidadabstraccion = count($abstraccion);
                      
                      //QUERY RUTAS QR
                      //OBTENER PASAJEROS AMONESTADOS
                        $queryamonestados = DB::table('qr_rutas')
                        ->leftJoin('pasajeros', 'qr_rutas.id_usuario', '=', 'pasajeros.cedula')
                        ->select('qr_rutas.*','pasajeros.nombres', 'pasajeros.apellidos')
                        ->whereNull('qr_rutas.status')->where('qr_rutas.centrodecosto_id',$cliente)->whereBetween('qr_rutas.fecha',[$fechainicial,$fechafinal]);
                        $pasajerosamonestados = $queryamonestados->orderBy('pasajeros.id')->get();
                        $totalpasajeros = count($pasajerosamonestados);
                      //FIN OBTENER PASAJEROS AMONESTADOS
                      
                      //OBTENER SERVICIOS FACTURADOS
                      $queryf = DB::table('facturacion')
                           
                        ->leftJoin('servicios', 'servicios.id', '=', 'facturacion.servicio_id')
                        ->whereBetween('servicios.fecha_servicio',[$fechainicial,$fechafinal])
                        ->where('facturacion.facturado',1)
                        ->where('servicios.anulado',0)                        
                        ->where('servicios.centrodecosto_id',$cliente)
                        ->where('servicios.ruta',1)
                        ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
                        ->whereNull('servicios.pendiente_autori_eliminacion')
                        ->whereNull('servicios.afiliado_externo')                
                        ->get();
                      //CONTADOR DE SERVICIOS
                      $cantidadservicios = count($queryf);
                      //FIN OBTENER SERVICIOS FACTURADOS

                        $recorridos = DB::table('servicios')
                        ->where('centrodecosto_id',$cliente)
                        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                        ->whereNull('servicios.pendiente_autori_eliminacion')
                        ->whereNull('servicios.afiliado_externo')
                        ->where('ruta',1)
                        ->get();
                        $recorridosrealizados = count($recorridos);

                        if($cliente==287){
                          $americas = DB::table('servicios')
                          ->where('subcentrodecosto_id',851)
                          ->whereNull('pendiente_autori_eliminacion')
                          ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                          ->get();
                          $countamericas = count($americas);

                          $toberin = DB::table('servicios')
                          ->where('subcentrodecosto_id',852)
                          ->whereNull('pendiente_autori_eliminacion')
                          ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                          ->get();
                          $counttoberin = count($toberin);

                          $torrecristal = DB::table('servicios')
                          ->where('subcentrodecosto_id',853)
                          ->whereNull('pendiente_autori_eliminacion')
                          ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                          ->get();
                          $counttorrecristal = count($torrecristal);
                          $countrutas = null;
                          $countcarnavales = null;
                        }else{
                          $rutas = DB::table('servicios')
                          ->where('subcentrodecosto_id',178)
                          ->whereNull('pendiente_autori_eliminacion')
                          ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                          ->get();
                          $countrutas = count($rutas);

                          $carnavales = DB::table('servicios')
                          ->where('subcentrodecosto_id',509)
                          ->whereNull('pendiente_autori_eliminacion')
                          ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
                          ->get();
                          $countcarnavales = count($carnavales);
                          $counttoberin = null;
                          $counttorrecristal = null;
                          $countamericas = null;        
                        }
                      }

      }

      //FIN CONSULTA OBTENER DATOS
      

      return View::make('portalusuarios.admin.dashboard.infodashboard',[
        'permisos' => $permisos,
        'idusuario' => $idusuario,
        'cliente' => $cliente,
        'fechainicial' => $fechainicial,
        'registros' => $re,
        'serviciosfacturados' => $cantidadservicios,
        'recorridosrealizados' => $recorridosrealizados,
        'cantidadefectivos' => $cantidadefectivos,
        'cantidadautorizados' => $cantidadautorizados,
        'cantidadabstraccion' => $cantidadabstraccion,
        'datossatisfechos' => $datossatisfechos,
        'datosnosatisfechos' => $datosnosatisfechos,
        'nombrecentrodecosto' => $nombrecentrodecosto,    
        'pasajerosamonestados' => $pasajerosamonestados,
        'totalpasajeros' => $totalpasajeros,
        'infovan' => $informacionvan,
        'infoauto' => $informacionauto,
        'resultadofinal' => $resultadofinal,
        'counttorrecristal' =>$counttorrecristal,
        'counttoberin' => $counttoberin,
        'countamericas' => $countamericas,
        'countrutas' => $countrutas,
        'countcarnavales' => $countcarnavales,
        //'info' => $informacion,
        //'coun' => $contadorinformacion
        'contadorinformacion' => $contadorinformacion,
        'contadorinformacionauto' => $contadorinformacionauto
      ]);
      
    }
  }


  //INICIO GENERAL DE SERVICIOS
  public function postObtenergeneraldeservicios(){
    
    if (Sentry::check()){

        $id_rol = Sentry::getUser()->id_rol;
        $cliente = Sentry::getUser()->centrodecosto_id;  
        $nombrecentrodecosto = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->portalusuarios->admin->ver;

    }else{
        $ver = null;
    }
    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on') {

      return View::make('portalusuarios.admin.dashboard');

    }else{

      $fechainicial = Input::get('md_fecha_inicial');
      $fechafinal = Input::get('md_fecha_final');
      
      //CONSULTA % UTILIZACIÓN DEL VEHICULO VAN
        $consultautilizacion = "

        SELECT  xy.fecha_dia, 

            case 

            when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
            ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
            END
            AS 'OCUPACION', 

            xy.tipo_vehiculo

              

            FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),

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
            where a.centrodecosto_id=287 AND a.motivo_eliminacion is null 

            ) xy

            where date(xy.fecha) between '".$fechainicial."' and '".$fechafinal."' and tipo_vehiculo = 'VAN'
            GROUP BY xy.tipo_vehiculo,xy.fecha_dia

            ";

            $informacionvan = DB::select($consultautilizacion);
            $contadorinformacion = count($informacionvan);
      //FIN % DE UTILIZACIÓN VAN

      

      //CONSULTA % UTILIZACIÓN DEL VEHICULO AUTO
        $consultautilizacionauto = "

        SELECT  xy.fecha_dia, 

            case 

            when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
            ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
            END
            AS 'OCUPACION', 

            xy.tipo_vehiculo

              

            FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),

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
            where a.centrodecosto_id=287 AND a.motivo_eliminacion is null 

            ) xy

            where date(xy.fecha) between '".$fechainicial."' and '".$fechafinal."' and tipo_vehiculo = 'AUTO'
            GROUP BY xy.tipo_vehiculo,xy.fecha_dia

            ";

            $informacionauto = DB::select($consultautilizacionauto);
            $contadorinformacionauto = count($informacionauto);

            $resultadofinal = $contadorinformacion + $contadorinformacionauto;
          //FIN % DE UTILIZACIÓN AUTO

          /*  //COMPORTAMIENTO MENSUAL EN TIEMPO DE RECORRIDO
              $comportamiento = DB::table('servicios')->

            //FIN COMPORTAMIENTO MENSUAL EN TIEMPO DE RECORRIDO
          */

      //select from_unixtime(fecha_creacion,'%m.%d.%Y') as fecha from table group by fecha de creación
      //$DB::table('pasajeros')->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])->get();
      //$registros = DB::table('pasajeros')
      $question = "select * from pasajeros where date(created_at) between '".$fechainicial."' and '".$fechafinal."' ";
      $registros = DB::select($question);
      //->where('created_at',$fechafinal)
      //->get();
      $re = count($registros);

      $satisfechos = DB::table('servicios')
      ->where('calificacion_app_conductor_calidad', '>',2.9)->where('centrodecosto_id',$cliente)->get();
      $datossatisfechos = count($satisfechos);

      $nosatisfechos = DB::table('servicios')
      ->where('calificacion_app_conductor_calidad','<',3)->where('centrodecosto_id',$cliente)->get();
      $datosnosatisfechos = count($nosatisfechos);
      
      /*$efectivos = DB::table('qr_rutas')
      ->where('status',1)
      ->where('centrodecosto_id',$cliente)
      ->whereBetween('fecha',[$fechainicial, $fechafinal])
      ->get();*/
      $cantidadefectivos = 0;

     /* $autorizados = DB::table('qr_rutas')
      ->where('status',2)
      ->where('centrodecosto_id',$cliente)
      ->whereBetween('fecha',[$fechainicial, $fechafinal])
      ->get();*/
      $cantidadautorizados = 0;

      /*$abstraccion = DB::table('qr_rutas')
      ->whereNull('status')
      ->where('centrodecosto_id',$cliente)
      ->whereBetween('fecha',[$fechainicial, $fechafinal])
      ->get();*/
      $cantidadabstraccion = 0;
      
      //QUERY RUTAS QR
      //OBTENER PASAJEROS AMONESTADOS
        $queryamonestados = DB::table('qr_rutas')
        ->leftJoin('pasajeros', 'qr_rutas.id_usuario', '=', 'pasajeros.cedula')
        ->select('qr_rutas.*','pasajeros.nombres', 'pasajeros.apellidos')
        ->whereNull('qr_rutas.status')->where('qr_rutas.centrodecosto_id',19)->whereBetween('qr_rutas.fecha',['20120101','20120101']);
        $pasajerosamonestados = $queryamonestados->orderBy('pasajeros.id')->get();
        $totalpasajeros = count($pasajerosamonestados);
      //FIN OBTENER PASAJEROS AMONESTADOS
      
      //OBTENER SERVICIOS FACTURADOS
      $queryf = DB::table('facturacion')
           
        ->leftJoin('servicios', 'servicios.id', '=', 'facturacion.servicio_id')
        ->whereBetween('servicios.fecha_servicio',[$fechainicial,$fechafinal])
        ->where('facturacion.facturado',1)
        ->where('servicios.anulado',0)                        
        ->where('servicios.centrodecosto_id',$cliente)
        ->where('servicios.ruta',1)
        ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
        ->whereNull('servicios.pendiente_autori_eliminacion')
        ->whereNull('servicios.afiliado_externo')                
        ->get();
      //CONTADOR DE SERVICIOS
      $cantidadservicios = count($queryf);
      //FIN OBTENER SERVICIOS FACTURADOS

        $recorridos = DB::table('servicios')
        ->where('centrodecosto_id',$cliente)
        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->whereNull('servicios.pendiente_autori_eliminacion')
        ->whereNull('servicios.afiliado_externo')
        ->where('ruta',1)
        ->get();
        $recorridosrealizados = count($recorridos);

        $americas = DB::table('servicios')
        ->where('subcentrodecosto_id',851)
        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->get();
        $countamericas = count($americas);

        $toberin = DB::table('servicios')
        ->where('subcentrodecosto_id',852)
        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->get();
        $counttoberin = count($toberin);

        $torrecristal = DB::table('servicios')
        ->where('subcentrodecosto_id',853)
        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->get();
        $counttorrecristal = count($torrecristal);
        $sub = DB::table('subcentrosdecosto')->get();

      return View::make('portalusuarios.admin.listado.exportarpasajerossgs',[
        'permisos' => $permisos,
        'registros' => $re,
        'subcentrosdecosto' => $sub,
        'serviciosfacturados' => $cantidadservicios,
        'recorridosrealizados' => $recorridosrealizados,
        'cantidadefectivos' => $cantidadefectivos,
        'cantidadautorizados' => $cantidadautorizados,
        'cantidadabstraccion' => $cantidadabstraccion,
        'datossatisfechos' => $datossatisfechos,
        'datosnosatisfechos' => $datosnosatisfechos,
        'nombrecentrodecosto' => $nombrecentrodecosto,    
        'pasajerosamonestados' => $pasajerosamonestados,
        'totalpasajeros' => $totalpasajeros,
        'infovan' => $informacionvan,
        'infoauto' => $informacionauto,
        'counttorrecristal' =>$counttorrecristal,
        'counttoberin' => $counttoberin,
        'countamericas' => $countamericas,
        'resultadofinal' => $resultadofinal,
        //'coun' => $contadorinformacion
        'contadorinformacion' => $contadorinformacion,
        'contadorinformacionauto' => $contadorinformacionauto
      ]);      

    }
  }
  //FIN GENERAL DE SERVICIOS

  public function postPasajerosamonestados(){

    if (Sentry::check()){

      $id_rol = Sentry::getUser()->id_rol;
      $cliente = Sentry::getUser()->centrodecosto_id;  
      $nombrecentrodecosto = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->portalusuarios->admin->ver;

    }else{
        $ver = null;
    }
    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on') {

      return View::make('portalusuarios.admin.dashboard');

    }else{
      return View::make('portalusuarios.admin.dashboard.listadopasajerosamonestados',[
        'permisos' => $permisos,
        //'pasajerosamonestados' => $pasajerosamonestados,
      ]);
    }
  }


  //INICIO COMPORTAMIENTO DE PASAJEROS

  public function postObtenercomportamientodepasajeros(){
    
    if (Sentry::check()){

      $id_rol = Sentry::getUser()->id_rol;
      $cliente = Sentry::getUser()->centrodecosto_id;  
      $nombrecentrodecosto = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);
      $ver = $permisos->portalusuarios->admin->ver;

    }else{
        $ver = null;
    }
    if (!Sentry::check()){

      return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

    }else if($ver!='on') {

      return View::make('portalusuarios.admin.dashboard');

    }else{
      $fechainicial = Input::get('md_fecha_inicial');
      $fechafinal = Input::get('md_fecha_final');
      
      //CONSULTA % UTILIZACIÓN DEL VEHICULO VAN
        $consultautilizacion = "

        SELECT  xy.fecha_dia, 

            case 

            when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
            ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
            END
            AS 'OCUPACION', 

            xy.tipo_vehiculo

              

            FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),

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
            where a.centrodecosto_id=287 AND a.motivo_eliminacion is null 

            ) xy

            where date(xy.fecha) between '20121101' and '20121101' and tipo_vehiculo = 'VAN'
            GROUP BY xy.tipo_vehiculo,xy.fecha_dia

            ";

            $informacionvan = DB::select($consultautilizacion);
            $contadorinformacion = count($informacionvan);
      //FIN % DE UTILIZACIÓN VAN

      

      //CONSULTA % UTILIZACIÓN DEL VEHICULO AUTO
        $consultautilizacionauto = "

        SELECT  xy.fecha_dia, 

            case 

            when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
            ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
            END
            AS 'OCUPACION', 

            xy.tipo_vehiculo

              

            FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),

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
            where a.centrodecosto_id=287 AND a.motivo_eliminacion is null 

            ) xy

            where date(xy.fecha) between '20121101' and '20121101' and tipo_vehiculo = 'AUTO'
            GROUP BY xy.tipo_vehiculo,xy.fecha_dia

            ";

            $informacionauto = DB::select($consultautilizacionauto);
            $contadorinformacionauto = count($informacionauto);

            $resultadofinal = $contadorinformacion + $contadorinformacionauto;
      //FIN % DE UTILIZACIÓN AUTO

          /*  //COMPORTAMIENTO MENSUAL EN TIEMPO DE RECORRIDO
              $comportamiento = DB::table('servicios')->

            //FIN COMPORTAMIENTO MENSUAL EN TIEMPO DE RECORRIDO
*/

      
      $question = "select * from pasajeros where date(created_at) between '20120101' and '20120101' ";
      $registros = DB::select($question);
      //->where('created_at',$fechafinal)
      //->get();
      $re = count($registros);

      $satisfechos = DB::table('servicios')
      ->where('calificacion_app_conductor_calidad', '>',2.9)->where('centrodecosto_id',$cliente)->get();
      $datossatisfechos = count($satisfechos);

      $nosatisfechos = DB::table('servicios')
      ->where('calificacion_app_conductor_calidad','<',3)->where('centrodecosto_id',$cliente)->get();
      $datosnosatisfechos = count($nosatisfechos);
      
      $efectivos = DB::table('qr_rutas')
      ->where('status',1)
      ->where('centrodecosto_id',19)
      ->whereBetween('fecha',[$fechainicial, $fechafinal])
      ->get();
      $cantidadefectivos = count($efectivos);

      $autorizados = DB::table('qr_rutas')
      ->where('status',2)
      ->where('centrodecosto_id',19)
      ->whereBetween('fecha',[$fechainicial, $fechafinal])
      ->get();
      $cantidadautorizados =  count($autorizados);

      $abstraccion = DB::table('qr_rutas')
      ->whereNull('status')
      ->where('centrodecosto_id',19)
      ->whereBetween('fecha',[$fechainicial, $fechafinal])
      ->get();
      $cantidadabstraccion = count($abstraccion);
      
      //QUERY RUTAS QR
      //OBTENER PASAJEROS AMONESTADOS
        $queryamonestados = DB::table('qr_rutas')
        ->leftJoin('pasajeros', 'qr_rutas.id_usuario', '=', 'pasajeros.cedula')
        ->select('qr_rutas.*','pasajeros.nombres', 'pasajeros.apellidos')
        ->whereNull('qr_rutas.status')->where('qr_rutas.centrodecosto_id',19)->whereBetween('qr_rutas.fecha',['20120101','20120101']);
        $pasajerosamonestados = $queryamonestados->orderBy('pasajeros.id')->get();
        $totalpasajeros = count($pasajerosamonestados);
      //FIN OBTENER PASAJEROS AMONESTADOS
      
      //OBTENER SERVICIOS FACTURADOS
      $queryf = DB::table('facturacion')
           
        ->leftJoin('servicios', 'servicios.id', '=', 'facturacion.servicio_id')
        ->whereBetween('servicios.fecha_servicio',['20120101','20120101'])
        ->where('facturacion.facturado',1)
        ->where('servicios.anulado',0)                        
        ->where('servicios.centrodecosto_id',$cliente)
        ->where('servicios.ruta',1)
        ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
        ->whereNull('servicios.pendiente_autori_eliminacion')
        ->whereNull('servicios.afiliado_externo')                
        ->get();
      //CONTADOR DE SERVICIOS
      $cantidadservicios = count($queryf);
      //FIN OBTENER SERVICIOS FACTURADOS

        $recorridos = DB::table('servicios')
        ->where('centrodecosto_id',$cliente)
        ->whereBetween('fecha_servicio',['20120101','20120101'])
        ->whereNull('servicios.pendiente_autori_eliminacion')
        ->whereNull('servicios.afiliado_externo')
        ->where('ruta',1)
        ->get();
        $recorridosrealizados = count($recorridos);

        $americas = DB::table('servicios')
        ->where('subcentrodecosto_id',851)
        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->get();
        $countamericas = count($americas);

        $toberin = DB::table('servicios')
        ->where('subcentrodecosto_id',852)
        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->get();
        $counttoberin = count($toberin);

        $torrecristal = DB::table('servicios')
        ->where('subcentrodecosto_id',853)
        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->get();
        $counttorrecristal = count($torrecristal);
        $sub = DB::table('subcentrosdecosto')->get();

      return View::make('portalusuarios.admin.listado.exportarpasajerossgs',[
        'permisos' => $permisos,
        'registros' => $re,
        'subcentrosdecosto' => $sub,
        'serviciosfacturados' => $cantidadservicios,
        'recorridosrealizados' => $recorridosrealizados,
        'cantidadefectivos' => $cantidadefectivos,
        'cantidadautorizados' => $cantidadautorizados,
        'cantidadabstraccion' => $cantidadabstraccion,
        'datossatisfechos' => $datossatisfechos,
        'datosnosatisfechos' => $datosnosatisfechos,
        'nombrecentrodecosto' => $nombrecentrodecosto,    
        'pasajerosamonestados' => $pasajerosamonestados,
        'totalpasajeros' => $totalpasajeros,
        'infovan' => $informacionvan,
        'infoauto' => $informacionauto,
        'counttorrecristal' =>$counttorrecristal,
        'counttoberin' => $counttoberin,
        'countamericas' => $countamericas,
        'resultadofinal' => $resultadofinal,
        //'coun' => $contadorinformacion
        'contadorinformacion' => $contadorinformacion,
        'contadorinformacionauto' => $contadorinformacionauto
      ]);
      
    }
  }
  // FIN COMPORTAMIENTO DE PASAJEROS

  //INICIO USAURIOS AMONESTADOS
    public function postObtenerusuariosamonestados(){
      
      if(Sentry::check()){
        $id_rol = Sentry::getUser()->id_rol;
        $cliente = Sentry::getUser()->centrodecosto_id;
        $nombrecentrodecosto = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->portalusuarios->admin->ver;
      }else{
        $ver = null;
      }

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else if($ver!='on'){
        return View::make('admin.permisos');
      }else{
        $fechainicial = Input::get('md_fecha_inicial');
        $fechafinal = Input::get('md_fecha_final');
      
        //CONSULTA % UTILIZACIÓN DEL VEHICULO VAN
        $consultautilizacion = "

        SELECT  xy.fecha_dia, 

            case 

            when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
            ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
            END
            AS 'OCUPACION', 

            xy.tipo_vehiculo

              

            FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),

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
            where a.centrodecosto_id=287 AND a.motivo_eliminacion is null 

            ) xy

            where date(xy.fecha) between '20121101' and '20121101' and tipo_vehiculo = 'VAN'
            GROUP BY xy.tipo_vehiculo,xy.fecha_dia

            ";

            $informacionvan = DB::select($consultautilizacion);
            $contadorinformacion = count($informacionvan);
      //FIN % DE UTILIZACIÓN VAN

      

      //CONSULTA % UTILIZACIÓN DEL VEHICULO AUTO
        $consultautilizacionauto = "

        SELECT  xy.fecha_dia, 

            case 

            when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
            ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
            END
            AS 'OCUPACION', 

            xy.tipo_vehiculo

              

            FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),

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
            where a.centrodecosto_id=287 AND a.motivo_eliminacion is null 

            ) xy

            where date(xy.fecha) between '20121101' and '20121101' and tipo_vehiculo = 'AUTO'
            GROUP BY xy.tipo_vehiculo,xy.fecha_dia

            ";

            $informacionauto = DB::select($consultautilizacionauto);
            $contadorinformacionauto = count($informacionauto);

            $resultadofinal = $contadorinformacion + $contadorinformacionauto;
      //FIN % DE UTILIZACIÓN AUTO

          /*  //COMPORTAMIENTO MENSUAL EN TIEMPO DE RECORRIDO
              $comportamiento = DB::table('servicios')->

            //FIN COMPORTAMIENTO MENSUAL EN TIEMPO DE RECORRIDO
          */

      
      $question = "select * from pasajeros where date(created_at) between '20120101' and '20120101' ";
      $registros = DB::select($question);
      //->where('created_at',$fechafinal)
      //->get();
      $re = count($registros);

      $satisfechos = DB::table('servicios')
      ->where('calificacion_app_conductor_calidad', '>',2.9)->where('centrodecosto_id',$cliente)->get();
      $datossatisfechos = count($satisfechos);

      $nosatisfechos = DB::table('servicios')
      ->where('calificacion_app_conductor_calidad','<',3)->where('centrodecosto_id',$cliente)->get();
      $datosnosatisfechos = count($nosatisfechos);
      
      $efectivos = DB::table('qr_rutas')
      ->where('status',1)
      ->where('centrodecosto_id',19)
      ->whereBetween('fecha',[$fechainicial, $fechafinal])
      ->get();
      $cantidadefectivos = 0;

      $autorizados = DB::table('qr_rutas')
      ->where('status',2)
      ->where('centrodecosto_id',19)
      ->whereBetween('fecha',[$fechainicial, $fechafinal])
      ->get();
      $cantidadautorizados =  0;

      $abstraccion = DB::table('qr_rutas')
      ->whereNull('status')
      ->where('centrodecosto_id',19)
      ->whereBetween('fecha',[$fechainicial, $fechafinal])
      ->get();
      $cantidadabstraccion = 0;
      
      //QUERY RUTAS QR
      //OBTENER PASAJEROS AMONESTADOS
        $queryamonestados = DB::table('qr_rutas')
        ->leftJoin('pasajeros', 'qr_rutas.id_usuario', '=', 'pasajeros.cedula')
        ->select('qr_rutas.*','pasajeros.nombres', 'pasajeros.apellidos')
        ->whereNull('qr_rutas.status')->where('qr_rutas.centrodecosto_id',19)->whereBetween('qr_rutas.fecha',[$fechainicial,$fechafinal]);
        $pasajerosamonestados = $queryamonestados->orderBy('pasajeros.id')->get();
        $totalpasajeros = count($pasajerosamonestados);
      //FIN OBTENER PASAJEROS AMONESTADOS
      
      //OBTENER SERVICIOS FACTURADOS
      $queryf = DB::table('facturacion')
           
        ->leftJoin('servicios', 'servicios.id', '=', 'facturacion.servicio_id')
        ->whereBetween('servicios.fecha_servicio',['20120101','20120101'])
        ->where('facturacion.facturado',1)
        ->where('servicios.anulado',0)                        
        ->where('servicios.centrodecosto_id',$cliente)
        ->where('servicios.ruta',1)
        ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
        ->whereNull('servicios.pendiente_autori_eliminacion')
        ->whereNull('servicios.afiliado_externo')                
        ->get();
      //CONTADOR DE SERVICIOS
      $cantidadservicios = count($queryf);
      //FIN OBTENER SERVICIOS FACTURADOS

        $recorridos = DB::table('servicios')
        ->where('centrodecosto_id',$cliente)
        ->whereBetween('fecha_servicio',['20120101','20120101'])
        ->whereNull('servicios.pendiente_autori_eliminacion')
        ->whereNull('servicios.afiliado_externo')
        ->where('ruta',1)
        ->get();
        $recorridosrealizados = count($recorridos);

        $americas = DB::table('servicios')
        ->where('subcentrodecosto_id',851)
        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->get();
        $countamericas = count($americas);

        $toberin = DB::table('servicios')
        ->where('subcentrodecosto_id',852)
        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->get();
        $counttoberin = count($toberin);

        $torrecristal = DB::table('servicios')
        ->where('subcentrodecosto_id',853)
        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->get();
        $counttorrecristal = count($torrecristal);
        $sub = DB::table('subcentrosdecosto')->get();

      return View::make('portalusuarios.admin.listado.exportarpasajerossgs',[
        'permisos' => $permisos,
        'registros' => $re,
        'subcentrosdecosto' => $sub,
        'serviciosfacturados' => $cantidadservicios,
        'recorridosrealizados' => $recorridosrealizados,
        'cantidadefectivos' => $cantidadefectivos,
        'cantidadautorizados' => $cantidadautorizados,
        'cantidadabstraccion' => $cantidadabstraccion,
        'datossatisfechos' => $datossatisfechos,
        'datosnosatisfechos' => $datosnosatisfechos,
        'nombrecentrodecosto' => $nombrecentrodecosto,    
        'pasajerosamonestados' => $pasajerosamonestados,
        'totalpasajeros' => $totalpasajeros,
        'infovan' => $informacionvan,
        'infoauto' => $informacionauto,
        'counttorrecristal' =>$counttorrecristal,
        'counttoberin' => $counttoberin,
        'countamericas' => $countamericas,
        'resultadofinal' => $resultadofinal,
        //'coun' => $contadorinformacion
        'contadorinformacion' => $contadorinformacion,
        'contadorinformacionauto' => $contadorinformacionauto
      ]);
      
      }
    }
  //FIN USUARIOS AMONESTADOS

    // INICIO OBTENER UTILIZACION DEL VEHICULO
    public function getObtenerutilizaciondelvehiculo(){
      if(Sentry::check()){
        $id_rol = Sentry::getUser()->id_rol;
        $cliente = Sentry::getUser()->centrodecosto_id;
        $nombrecentrodecosto = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = $permisos->portalusuarios->admin->ver;
      }else{
        $ver = null;
      }

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else if($ver!='on'){
        return View::make('admin.permisos');
      }else{
        $fechainicial = Input::get('md_fecha_inicial');
        $fechafinal = Input::get('md_fecha_final');
      
        //CONSULTA % UTILIZACIÓN DEL VEHICULO VAN
        $consultautilizacion = "

        SELECT  xy.fecha_dia, 

            case 

            when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
            ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
            END
            AS 'OCUPACION', 

            xy.tipo_vehiculo

              

            FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),

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
            where a.centrodecosto_id=287 AND a.motivo_eliminacion is null 

            ) xy

            where date(xy.fecha) between '".$fechainicial."' and '".$fechafinal."' and tipo_vehiculo = 'VAN'
            GROUP BY xy.tipo_vehiculo,xy.fecha_dia

            ";

            $informacionvan = DB::select($consultautilizacion);
            $contadorinformacion = count($informacionvan);
            
            //FIN % DE UTILIZACIÓN VAN

      //CONSULTA % UTILIZACIÓN DEL VEHICULO AUTO
        $consultautilizacionauto = "

        SELECT  xy.fecha_dia, 

            case 

            when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
            ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
            END
            AS 'OCUPACION', 

            xy.tipo_vehiculo

              

            FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),

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
            where a.centrodecosto_id=287 AND a.motivo_eliminacion is null 

            ) xy

            where date(xy.fecha) between '".$fechainicial."' and '".$fechafinal."' and tipo_vehiculo = 'AUTO'
            GROUP BY xy.tipo_vehiculo,xy.fecha_dia

            ";

            $informacionauto = DB::select($consultautilizacionauto);
            $contadorinformacionauto = count($informacionauto);

            $resultadofinal = $contadorinformacion + $contadorinformacionauto;
      //FIN % DE UTILIZACIÓN AUTO

          /*  //COMPORTAMIENTO MENSUAL EN TIEMPO DE RECORRIDO
              $comportamiento = DB::table('servicios')->

            //FIN COMPORTAMIENTO MENSUAL EN TIEMPO DE RECORRIDO
*/

      
      $question = "select * from pasajeros where date(created_at) between '20120101' and '20120101' ";
      $registros = DB::select($question);
      //->where('created_at',$fechafinal)
      //->get();
      $re = count($registros);

      $satisfechos = DB::table('servicios')
      ->where('calificacion_app_conductor_calidad', '>',2.9)->where('centrodecosto_id',$cliente)->get();
      $datossatisfechos = count($satisfechos);

      $nosatisfechos = DB::table('servicios')
      ->where('calificacion_app_conductor_calidad','<',3)->where('centrodecosto_id',$cliente)->get();
      $datosnosatisfechos = count($nosatisfechos);
      
      $efectivos = DB::table('qr_rutas')
      ->where('status',1)
      ->where('centrodecosto_id',19)
      ->whereBetween('fecha',[$fechainicial, $fechafinal])
      ->get();
      $cantidadefectivos = 0;

      $autorizados = DB::table('qr_rutas')
      ->where('status',2)
      ->where('centrodecosto_id',19)
      ->whereBetween('fecha',[$fechainicial, $fechafinal])
      ->get();
      $cantidadautorizados =  0;

      $abstraccion = DB::table('qr_rutas')
      ->whereNull('status')
      ->where('centrodecosto_id',19)
      ->whereBetween('fecha',[$fechainicial, $fechafinal])
      ->get();
      $cantidadabstraccion = 0;
      
      //QUERY RUTAS QR
      //OBTENER PASAJEROS AMONESTADOS
        $queryamonestados = DB::table('qr_rutas')
        ->leftJoin('pasajeros', 'qr_rutas.id_usuario', '=', 'pasajeros.cedula')
        ->select('qr_rutas.*','pasajeros.nombres', 'pasajeros.apellidos')
        ->whereNull('qr_rutas.status')->where('qr_rutas.centrodecosto_id',19)->whereBetween('qr_rutas.fecha',['20120101','20120101']);
        $pasajerosamonestados = $queryamonestados->orderBy('pasajeros.id')->get();
        $totalpasajeros = count($pasajerosamonestados);
      //FIN OBTENER PASAJEROS AMONESTADOS
      
      //OBTENER SERVICIOS FACTURADOS
      $queryf = DB::table('facturacion')
           
        ->leftJoin('servicios', 'servicios.id', '=', 'facturacion.servicio_id')
        ->whereBetween('servicios.fecha_servicio',['20120101','20120101'])
        ->where('facturacion.facturado',1)
        ->where('servicios.anulado',0)                        
        ->where('servicios.centrodecosto_id',$cliente)
        ->where('servicios.ruta',1)
        ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
        ->whereNull('servicios.pendiente_autori_eliminacion')
        ->whereNull('servicios.afiliado_externo')                
        ->get();
      //CONTADOR DE SERVICIOS
      $cantidadservicios = count($queryf);
      //FIN OBTENER SERVICIOS FACTURADOS

        $recorridos = DB::table('servicios')
        ->where('centrodecosto_id',$cliente)
        ->whereBetween('fecha_servicio',['20120101','20120101'])
        ->whereNull('servicios.pendiente_autori_eliminacion')
        ->whereNull('servicios.afiliado_externo')
        ->where('ruta',1)
        ->get();
        $recorridosrealizados = count($recorridos);

        $americas = DB::table('servicios')
        ->where('subcentrodecosto_id',851)
        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->get();
        $countamericas = count($americas);

        $toberin = DB::table('servicios')
        ->where('subcentrodecosto_id',852)
        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->get();
        $counttoberin = count($toberin);

        $torrecristal = DB::table('servicios')
        ->where('subcentrodecosto_id',853)
        ->whereBetween('fecha_servicio',[$fechainicial,$fechafinal])
        ->get();
        $counttorrecristal = count($torrecristal);
        $sub = DB::table('subcentrosdecosto')->get();

      return View::make('portalusuarios.admin.listado.exportarpasajerossgs',[
        'permisos' => $permisos,
        'registros' => $re,
        'subcentrosdecosto' => $sub,
        'serviciosfacturados' => $cantidadservicios,
        'recorridosrealizados' => $recorridosrealizados,
        'cantidadefectivos' => $cantidadefectivos,
        'cantidadautorizados' => $cantidadautorizados,
        'cantidadabstraccion' => $cantidadabstraccion,
        'datossatisfechos' => $datossatisfechos,
        'datosnosatisfechos' => $datosnosatisfechos,
        'nombrecentrodecosto' => $nombrecentrodecosto,    
        'pasajerosamonestados' => $pasajerosamonestados,
        'totalpasajeros' => $totalpasajeros,
        'infovan' => $informacionvan,
        'infoauto' => $informacionauto,
        'counttorrecristal' =>$counttorrecristal,
        'counttoberin' => $counttoberin,
        'countamericas' => $countamericas,
        'resultadofinal' => $resultadofinal,
        //'coun' => $contadorinformacion
        'contadorinformacion' => $contadorinformacion,
        'contadorinformacionauto' => $contadorinformacionauto
      ]);
     
      }
    }
    //EXPORTAR DATOS PASAJEROS SGS
    
    public function getExportdatos(){

        if (Sentry::check()) {
            $id_rol = Sentry::getUser()->id_rol;
            $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
            $permisos = json_decode($permisos);
            $ver = $permisos->portalusuarios->admin->ver;
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
          $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on') {
            return View::make('admin.permisos');
        }else{

            /*$proveedores = Proveedor::Afiliadosinternos()
            ->orderBy('razonsocial')
            ->where('tipo_servicio', 'TRANSPORTE TERRESTRE')
            ->whereNull('inactivo_total')
            ->whereNull('inactivo')
            ->get();*/

            /*$conductores = Conductor::all();*/

            $centrosdecosto = Centrodecosto::Internos()->orderBy('razonsocial')->get();

            $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
            $usuarios = DB::table('users')->orderBy('first_name')->get();

            $servicios = Servicio::select('servicios.id','servicios.fecha_servicio','servicios.recoger_en','servicios.hora_servicio',
                    'servicios.dejar_en','servicios.pasajeros','servicios.resaltar',
                    'facturacion.numero_planilla','facturacion.observacion','facturacion.servicio_id','facturacion.liquidado_autorizado',
                    'facturacion.unitario_cobrado','facturacion.unitario_pagado','facturacion.total_cobrado',
                    'facturacion.total_pagado','facturacion.utilidad','facturacion.liquidado','facturacion.facturado',
                    'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo','facturacion.liquidado_autorizado',
                    'centrosdecosto.razonsocial','subcentrosdecosto.nombresubcentro',
                    'conductores.celular','conductores.telefono','conductores.nombre_completo',
                'proveedores.razonsocial as razonproveedor')
                ->join('users', 'servicios.creado_por', '=', 'users.id')
                ->join('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
                ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
                ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
                ->join('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
                ->join('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
                ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
                ->whereNull('servicios.afiliado_externo')
                ->where('fecha_servicio',date('Y-m-d'))
                ->whereNull('pendiente_autori_eliminacion')
                ->where('revisado',1)
                ->orderBy('fecha_servicio')
                ->get();

            return View::make('facturacion.liquidacion')
                ->with([
                    'proveedores'=>$proveedores,
                    'conductores'=>$conductores,
                    'centrosdecosto'=>$centrosdecosto,
                    'ciudades'=>$ciudades,
                    'usuarios'=>$usuarios,
                    'servicios'=>$servicios,
                    'permisos'=>$permisos,
                    'o'=>$o=1
                ]);
        }
    }

  //FIN EXPORTAR PASAJEROS SGS

  //FIN OBTENER UTILIZACION DEL VEHICULO

  public function postConsultar() {

    $fecha_inicial = Input::get('fecha_inicial');
    $fecha_final = Input::get('fecha_final');
    $centrodecosto = Sentry::getUser()->centrodecosto_id;

    $serviciosRealizadosc = DB::table('servicios')
    ->select('id')
    ->whereBetween('fecha_servicio',[$fecha_inicial, $fecha_final])
    ->whereNull('pendiente_autori_eliminacion')
    ->where('centrodecosto_id',$centrodecosto)
    ->get();
    $serviciosRealizados = count($serviciosRealizadosc);

    $serviciosFacturadosc = DB::table('servicios')
    ->leftJoin('facturacion', 'facturacion.servicio_id', '=', 'servicios.id')
    ->select('servicios.id', 'facturacion.servicio_id', 'facturacion.facturado')
    ->whereBetween('fecha_servicio',[$fecha_inicial, $fecha_final])
    ->whereNull('pendiente_autori_eliminacion')
    ->where('centrodecosto_id',$centrodecosto)
    ->whereNotNull('facturado')
    ->get();
    $serviciosFacturados = count($serviciosFacturadosc);

    $usuariosRegistradosc = "select * from users where date(created_at) between '".$fecha_inicial."' and '".$fecha_final."' and centrodecosto_id = ".$centrodecosto." and usuario_portal = 4 ";

    $usuariosRegistradoscc = DB::select($usuariosRegistradosc);
    $usuariosRegistrados = count($usuariosRegistradoscc);

    //Comportamiento
    $efectivos = DB::table('qr_rutas')
    ->leftJoin('servicios', 'servicios.id', '=', 'qr_rutas.servicio_id')
    ->select('servicios.id', 'servicios.fecha_servicio', 'qr_rutas.status', 'servicios.centrodecosto_id')
    ->whereBetween('servicios.fecha_servicio' , [$fecha_inicial, $fecha_final])
    ->where('servicios.centrodecosto_id',$centrodecosto)
    ->where('qr_rutas.status',1)
    ->get();
    $countEfectivos = count($efectivos);

    $abtencion = DB::table('qr_rutas')
    ->leftJoin('servicios', 'servicios.id', '=', 'qr_rutas.servicio_id')
    ->select('servicios.id', 'servicios.fecha_servicio', 'qr_rutas.status', 'servicios.centrodecosto_id')
    ->whereBetween('servicios.fecha_servicio' , [$fecha_inicial, $fecha_final])
    ->where('servicios.centrodecosto_id',$centrodecosto)
    ->whereNull('qr_rutas.status')
    ->get();
    $countAbtencion = count($abtencion);

    $autorizados = DB::table('qr_rutas')
    ->leftJoin('servicios', 'servicios.id', '=', 'qr_rutas.servicio_id')
    ->select('servicios.id', 'servicios.fecha_servicio', 'qr_rutas.status', 'servicios.centrodecosto_id')
    ->whereBetween('servicios.fecha_servicio' , [$fecha_inicial, $fecha_final])
    ->where('servicios.centrodecosto_id',$centrodecosto)
    ->where('qr_rutas.status',3)
    ->get();
    $countAutorizados = count($autorizados);

    //test
    $fechainicial = $fecha_inicial;
    $fechafinal = $fecha_final;
  
    //CONSULTA % UTILIZACIÓN DEL VEHICULO VAN
    $consultautilizacion = "

    SELECT  xy.fecha_dia, 

    case 

    when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
    ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
    END
    AS 'OCUPACION', 

    xy.tipo_vehiculo

      

    FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),

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
    where a.centrodecosto_id=287 AND a.motivo_eliminacion is null 

    ) xy

    where date(xy.fecha) between '".$fechainicial."' and '".$fechafinal."' and tipo_vehiculo = 'VAN'
    GROUP BY xy.tipo_vehiculo,xy.fecha_dia

    ";

    $informacionvan = DB::select($consultautilizacion);
    $contadorinformacion = count($informacionvan);
    //FIN % DE UTILIZACIÓN VAN

    //CONSULTA % UTILIZACIÓN DEL VEHICULO AUTO
    $consultautilizacionauto = "

    SELECT  xy.fecha_dia, 

      case 

      when xy.tipo_vehiculo = 'AUTO' THEN ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/4)*100
      ELSE ((sum(xy.pasajeros1)/count(xy.tipo_vehiculo))/10)*100
      END
      AS 'OCUPACION', 

      xy.tipo_vehiculo

        

      FROM (select  a.id AS 'id', b.nombresubcentro, a.cantidad AS 'pasajeros1', a.fecha_servicio AS 'fecha', day(a.fecha_servicio) AS 'fecha_dia', month(a.fecha_servicio),

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
      where a.centrodecosto_id=287 AND a.motivo_eliminacion is null 

      ) xy

      where date(xy.fecha) between '".$fecha_inicial."' and '".$fecha_final."' and tipo_vehiculo = 'AUTO'
      GROUP BY xy.tipo_vehiculo,xy.fecha_dia

      ";

      $informacionauto = DB::select($consultautilizacionauto);
      $contadorinformacionauto = count($informacionauto);

      $resultadofinal = $contadorinformacion + $contadorinformacionauto;
      //FIN % DE UTILIZACIÓN AUTO

    //OBTENER PASAJEROS AMONESTADOS
    $queryamonestados = DB::table('qr_rutas')
    ->leftJoin('servicios', 'servicios.id', '=', 'qr_rutas.servicio_id')
    ->select('servicios.id', 'servicios.fecha_servicio', 'qr_rutas.fullname', 'qr_rutas.status')
    ->whereNull('qr_rutas.status')
    ->where('servicios.centrodecosto_id',$centrodecosto)
    ->whereBetween('servicios.fecha_servicio',[$fechainicial,$fechafinal]);

    $queryamonestados = "SELECT distinct fullname FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE STATUS IS NULL AND servicios.centrodecosto_id = ".$centrodecosto." AND fecha_servicio BETWEEN '".$fecha_inicial."' AND '".$fecha_final."' order by qr_rutas.fullname";
    $pasajerosamonestados = DB::select($queryamonestados);

    $queryamonestados2 = "SELECT fullname FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE STATUS IS NULL AND servicios.centrodecosto_id = ".$centrodecosto." AND fecha_servicio BETWEEN '".$fecha_inicial."' AND '".$fecha_final."' order by qr_rutas.fullname";
    $pasajerosamonestadost = DB::select($queryamonestados2);


    //$pasajerosamonestados = $queryamonestados->orderBy('qr_rutas.fullname')->get();

    $totalpasajeros = count($pasajerosamonestados);
    //FIN OBTENER PASAJEROS AMONESTADOS

    return Response::json([
      'respuesta' => true,
      'realizados' => $serviciosRealizados,
      'facturados' => $serviciosFacturados,
      'registrados' => $usuariosRegistrados,
      'efectivos' => $countEfectivos,
      'abtencion' => $countAbtencion,
      'autorizados' => $countAutorizados,
      'contadorinformacion' => $contadorinformacion,
      'contadorinformacionauto' => $contadorinformacionauto,
      'infonauto' => $informacionauto,
      'infovan' => $informacionvan,
      'amonestados' => $pasajerosamonestados,
      'amonestadost' => $pasajerosamonestadost,
      'total_amonestados' => $totalpasajeros,
      'cc' => $centrodecosto,
      'fi' => $fecha_inicial,
      'ff' => $fecha_final
    ]);
  }

}
