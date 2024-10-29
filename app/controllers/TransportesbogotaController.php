<?php

class TransportesbogotaController extends BaseController{

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

      if (isset($permisos->bogota->servicios->ver)){
        $ver = $permisos->bogota->servicios->ver;
      }else{
        $ver = null;
      }

      if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on') {

        return View::make('admin.permisos');

      }else{

        $query = Servicio::select('servicios.*', 'facturacion.revisado','facturacion.liquidado','facturacion.facturado','facturacion.factura_id',
                  'proveedores.tipo_afiliado', 'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro','users.first_name',
                  'users.last_name', 'rutas.nombre_ruta','rutas.codigo_ruta','proveedores.razonsocial AS razonproveedor',
                  'conductores.nombre_completo','conductores.celular','conductores.telefono','conductores.usuario_id',
                  'reconfirmacion.numero_reconfirmaciones','reconfirmacion.id as id_reconfirmacion','reconfirmacion.ejecutado',
                  'vehiculos.placa','vehiculos.clase','vehiculos.marca','vehiculos.modelo',
                  'encuesta.pregunta_1','encuesta.pregunta_2','encuesta.pregunta_3','encuesta.pregunta_4',
                  'encuesta.pregunta_8','encuesta.pregunta_9','encuesta.pregunta_10',
                  'servicios_edicion_pivote.id as id_pivote', 'reportes_pivote.id as id_reporte', 'servicios_autorizados_pdf.documento_pdf1', 'servicios_autorizados_pdf.documento_pdf2')
            ->leftJoin('servicios_edicion_pivote', 'servicios.id', '=', 'servicios_edicion_pivote.servicios_id')
            ->leftJoin('reportes_pivote', 'servicios.id', '=', 'reportes_pivote.servicio_id')
            ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
            ->leftJoin('reconfirmacion', 'servicios.id', '=', 'reconfirmacion.id_servicio')
            ->leftJoin('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
            ->leftJoin('conductores', 'servicios.conductor_id', '=', 'conductores.id')
            ->LeftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
            ->leftJoin('centrosdecosto', 'servicios.centrodecosto_id', '=', 'centrosdecosto.id')
            ->leftJoin('subcentrosdecosto', 'servicios.subcentrodecosto_id', '=', 'subcentrosdecosto.id')
            ->leftJoin('users', 'servicios.creado_por', '=', 'users.id')
            ->leftJoin('encuesta', 'servicios.id','=','encuesta.id_servicio')
            ->leftJoin('facturacion', 'servicios.id','=','facturacion.servicio_id')
            ->leftJoin('servicios_autorizados_pdf', 'servicios.id', '=', 'servicios_autorizados_pdf.servicio_id')
            ->where('servicios.anulado',0)
            ->where('centrosdecosto.localidad','bogota')
            ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
            ->whereNull('servicios.pendiente_autori_eliminacion')
            ->whereNull('servicios.afiliado_externo')
            ->where('fecha_servicio',date('Y-m-d'));

        $servicios = $query->orderBy('hora_servicio')->get();

        $proveedores = Proveedor::Afiliadosinternos()
        ->orderBy('razonsocial')
        ->where('tipo_servicio', 'TRANSPORTE TERRESTRE')
        ->where('localidad','bogota')
        ->whereNull('inactivo_total')
        ->whereNull('inactivo')
        ->get();

        $centrosdecosto = Centrodecosto::Internos()->whereIn('localidad',['bogota','provisional'])->orderBy('razonsocial')->get();

        $subcentros = DB::table('subcentrosdecosto')->orderBy('nombresubcentro')->get();
        $departamentos = DB::table('departamento')->get();
        $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
        $rutas = DB::table('rutas')->get();
        $usuarios = DB::table('users')->where('coordinador',1)->where('activated',1)->get();

        $cotizaciones = DB::table('cotizaciones')->where('estado',1)->orderBy('created_at', 'desc')->take(10)->get();

        return View::make('servicios.transportes_servicios_rutasbog')
        ->with([
          'cotizaciones' => $cotizaciones,
          'servicios' => $servicios,
          'centrosdecosto' => $centrosdecosto,
          'departamentos' => $departamentos,
          'ciudades' => $ciudades,
          'proveedores' => $proveedores,
          'rutas' => $rutas,
          'permisos'=> $permisos,
          'usuarios' => $usuarios,
          'o' => 1
        ]);

      }
  }
  }
  ?>