<?php
use App\User;
use App\Controllers\Controller;

class RegistroproveedoresController extends BaseController{

    public function getIndex(){

            $departamentos = DB::table('departamento')->get();
            $centrosdecosto = Centrodecosto::Internos()->whereIn('id',[19,287])->orderBy('razonsocial')->get();
            $pasajeros = Pasajero::where('cedula', 12)->orderBy('nombres')->get();

            return View::make('portalproveedores.formulario_proveedores')
                ->with('centrosdecosto',$centrosdecosto)
                ->with('pasajeros',$pasajeros)
                ->with('departamentos',$departamentos)
                ->with('o',$o=1);

    }

    public function getNuevosproveedores(){

      if (Sentry::check()) {
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
      }else{
        $id_rol = null;
        $permisos = null;
        $permisos = null;
      }

      if (isset($permisos->administrativo->proveedores->ver)){
        $ver = $permisos->administrativo->proveedores->ver;
      }else{
        $ver = null;
      }

      if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on' ){
        return View::make('admin.permisos');
      }else{

        $proveedores = Proveedor::afiliadosinternos()
        ->where('estado',0)
        ->orderBy('razonsocial')
        ->get();

        $proveedores = DB::table('ingreso_proveedores')
        ->leftJoin('ingreso_conductores', 'ingreso_conductores.proveedor_id', '=', 'ingreso_proveedores.id')
        ->leftJoin('ingreso_vehiculos', 'ingreso_vehiculos.proveedor_id', '=', 'ingreso_proveedores.id')
        ->select('ingreso_proveedores.*', 'ingreso_vehiculos.test', 'ingreso_vehiculos.autorizado_juridica as autorizado_juridica_vehiculo', 'ingreso_conductores.autorizado_juridica as autorizado_juridica_conductor', 'ingreso_conductores.autorizado_licencia', 'ingreso_conductores.autorizado_cc', 'ingreso_conductores.autorizado_seguridad_social', 'ingreso_conductores.nombre_completo', 'ingreso_vehiculos.autorizado_tp', 'ingreso_vehiculos.autorizado_to', 'ingreso_vehiculos.autorizado_soat', 'ingreso_vehiculos.autorizado_tecnomecanica' , 'ingreso_vehiculos.placa', 'ingreso_vehiculos.autorizado_pc', 'ingreso_vehiculos.autorizado_pec')
        ->where('ingreso_vehiculos.test',1)
        ->whereIn('ingreso_proveedores.estado_global',[1,2,3])
        ->get();

        $departamentos = DB::table('departamento')->get();

        //$proveedores = null;

        return View::make('portalproveedores.gestion.nuevosproveedores')
        ->with([
          'departamentos' => $departamentos,
          'proveedores' => $proveedores,
          'permisos' => $permisos
        ]);
      }
    }

    public function getNuevosvehiculos(){

      if (Sentry::check()) {
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
      }else{
        $id_rol = null;
        $permisos = null;
        $permisos = null;
      }

      if (isset($permisos->administrativo->proveedores->ver)){
        $ver = $permisos->administrativo->proveedores->ver;
      }else{
        $ver = null;
      }

      $ver = 'on';

      if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on' ){
        return View::make('admin.permisos');
      }else{

        $proveedores = Proveedor::afiliadosinternos()
        ->where('estado',0)
        ->orderBy('razonsocial')
        ->get();

        $proveedores = DB::table('ingreso_proveedores')
        ->leftJoin('ingreso_conductores', 'ingreso_conductores.proveedor_id', '=', 'ingreso_proveedores.id')
        ->leftJoin('ingreso_vehiculos', 'ingreso_vehiculos.proveedor_id', '=', 'ingreso_proveedores.id')
        ->select('ingreso_proveedores.*', 'ingreso_vehiculos.test', 'ingreso_vehiculos.id as id_vehiculo', 'ingreso_vehiculos.placa', 'ingreso_vehiculos.capacidad', 'ingreso_vehiculos.modelo', 'ingreso_vehiculos.linea', 'ingreso_vehiculos.marca', 'ingreso_vehiculos.color', 'ingreso_vehiculos.autorizado_juridica as autorizado_juridica_vehiculo', 'ingreso_conductores.autorizado_juridica as autorizado_juridica_conductor', 'ingreso_conductores.autorizado_licencia', 'ingreso_conductores.autorizado_cc', 'ingreso_conductores.autorizado_seguridad_social', 'ingreso_vehiculos.autorizado_tp', 'ingreso_vehiculos.autorizado_to', 'ingreso_vehiculos.autorizado_soat', 'ingreso_vehiculos.autorizado_tecnomecanica')
        ->whereNull('ingreso_proveedores.estado_global')
        ->get();

        $departamentos = DB::table('departamento')->get();

        return View::make('portalproveedores.gestion.nuevosvehiculos')
        ->with([
          'departamentos' => $departamentos,
          'proveedores' => $proveedores,
          'permisos' => $permisos
        ]);
      }
    }

    public function getVehiculosenrevision(){

      if (Sentry::check()) {
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
      }else{
        $id_rol = null;
        $permisos = null;
        $permisos = null;
      }

      if (isset($permisos->administrativo->proveedores->ver)){
        $ver = $permisos->administrativo->proveedores->ver;
      }else{
        $ver = null;
      }

      if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on' ){
        return View::make('admin.permisos');
      }else{

        $proveedores = Proveedor::afiliadosinternos()
        ->where('estado',0)
        ->orderBy('razonsocial')
        ->get();

        $proveedores = DB::table('ingreso_proveedores')
        ->leftJoin('ingreso_conductores', 'ingreso_conductores.proveedor_id', '=', 'ingreso_proveedores.id')
        ->leftJoin('ingreso_vehiculos', 'ingreso_vehiculos.proveedor_id', '=', 'ingreso_proveedores.id')
        ->select('ingreso_proveedores.*', 'ingreso_vehiculos.placa', 'ingreso_vehiculos.test', 'ingreso_vehiculos.autorizado_juridica as autorizado_juridica_vehiculo', 'ingreso_conductores.autorizado_juridica as autorizado_juridica_conductor', 'ingreso_conductores.autorizado_licencia', 'ingreso_conductores.autorizado_cc', 'ingreso_conductores.autorizado_seguridad_social', 'ingreso_conductores.nombre_completo', 'ingreso_vehiculos.autorizado_tp', 'ingreso_vehiculos.autorizado_to', 'ingreso_vehiculos.autorizado_soat', 'ingreso_vehiculos.autorizado_tecnomecanica')
        ->where('ingreso_vehiculos.test',1)
        ->get();

        $departamentos = DB::table('departamento')->get();

        return View::make('portalproveedores.gestion.vehiculos_revision')
        ->with([
          'departamentos' => $departamentos,
          'proveedores' => $proveedores,
          'permisos' => $permisos
        ]);
      }
    }

    public function getCapacitacion(){

      if (Sentry::check()) {
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
      }else{
        $id_rol = null;
        $permisos = null;
        $permisos = null;
      }

      if (isset($permisos->administrativo->proveedores->ver)){
        $ver = $permisos->administrativo->proveedores->ver;
      }else{
        $ver = null;
      }

      if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on' ){
        return View::make('admin.permisos');
      }else{

        $proveedores = Proveedor::afiliadosinternos()
        ->where('estado',0)
        ->orderBy('razonsocial')
        ->get();

        $conductores = DB::table('ingreso_conductores')
        ->leftJoin('ingreso_proveedores', 'ingreso_conductores.proveedor_id', '=', 'ingreso_proveedores.id')
        ->leftJoin('ingreso_vehiculos', 'ingreso_vehiculos.proveedor_id', '=', 'ingreso_proveedores.id')
        ->select('ingreso_conductores.*', 'ingreso_proveedores.id as id_proveedor', 'ingreso_proveedores.autorizacion_th', 'ingreso_proveedores.autorizacion_juridica', 'ingreso_proveedores.autorizacion_contabilidad', 'ingreso_proveedores.nit', 'ingreso_proveedores.digito_verificacion', 'ingreso_proveedores.razonsocial', 'ingreso_proveedores.tipo_empresa', 'ingreso_proveedores.email', 'ingreso_proveedores.estado_global', 'ingreso_vehiculos.test', 'ingreso_vehiculos.placa', 'ingreso_vehiculos.autorizado_juridica as autorizado_juridica_vehiculo', 'ingreso_vehiculos.autorizado_tp', 'ingreso_vehiculos.autorizado_to', 'ingreso_vehiculos.autorizado_soat', 'ingreso_vehiculos.autorizado_tecnomecanica')
        ->where('ingreso_proveedores.estado_global',4)
        ->get();

        $departamentos = DB::table('departamento')->get();

        return View::make('portalproveedores.gestion.capacitacion')
        ->with([
          'departamentos' => $departamentos,
          'conductores' => $conductores,
          'permisos' => $permisos
        ]);
      }
    }

    public function postMostrardetalles(){

      if(Request::ajax()){

        $id = Input::get('id');
        $proveedor = IngresoProveedor::find($id);

        if($proveedor){

          return Response::json([
            'respuesta'=>true,
            'proveedor'=>$proveedor
          ]);

        }else{

          return Response::json([
            'respuesta'=>false
          ]);

        }
      }

    }

    public function postSendlegal(){ //ENVIARLO A REVISIÓN A TODAS LAS ÁREAS

      $id = Input::get('id');

      $update = DB::table('ingreso_vehiculos')
      ->where('id',$id)
      ->update([
        'test'=> 1
      ]);

      $proveedor = DB::table('ingreso_vehiculos')
      ->where('id',$id)
      ->pluck('proveedor_id');

      $update = DB::table('ingreso_proveedores')
      ->where('id',$proveedor)
      ->update([
        'estado_global'=> 1
      ]);

      if($update){

        /*ENVÍO DE CORREO AL ÁREA JURÍDICA PARA REVISIÓN*/

          $email = ['talentohumano@aotour.com.co', 'contabilidad@aotour.com.co', 'juridica@aotour.com.co', 'gestionintegral@aotour.com.co', 'comercial@aotour.com.co', 'sistemas@aotour.com.co'];

          $razonsocial = DB::table('ingreso_proveedores')
          ->where('id',$proveedor)
          ->first();

          //$email = 'sistemas@aotour.com.co';
          $data = [
            //'email' => $email,
            'proveedor' => $razonsocial
          ];
          Mail::send('portalproveedores.emails.revision', $data, function($message) use ($email){
            $message->from('no-reply@aotour.com.co', 'AOTOUR');
            $message->to($email)->subject('PORTAL PROVEEDORES');
            $message->cc('aotourdeveloper@gmail.com');
          });
          //FIN ENVÍO DE CORREO AL PROVEEDOR*/

        return Response::json([
          'respuesta'=> true
        ]);
      }else{
        return Response::json([
          'respuesta' => false
        ]);
      }

    }

    public function postSenddatafinacy(){ //ÁPROBACIÓN JURÍDICA

      $id = Input::get('id');

      $update = DB::table('ingreso_proveedores')
      ->where('id',$id)
      ->update([
        'estado_global'=> 1
      ]);

      if($update){

        /*ENVÍO DE CORREO AL AL PROVEEDOR PARA PEDIR DATOS FINANCIEROS*/
        $email = DB::table('ingreso_proveedores')
        ->where('id',$id)
        ->pluck('email');

        $email = 'sistemas@aotour.com.co';
        $data = [
          'email' => $email,
          'id' => $id
        ];
        Mail::send('portalproveedores.emails.datos_financieros', $data, function($message) use ($email){
          $message->from('no-reply@aotour.com.co', 'AOTOUR');
          $message->to($email)->subject('PORTAL PROVEEDORES');
          $message->cc('aotourdeveloper@gmail.com');
        });
        //FIN ENVÍO DE CORREO AL PROVEEDOR*/

        return Response::json([
          'respuesta'=> true
        ]);
      }else{
        return Response::json([
          'respuesta' => false
        ]);
      }

    }

    public function getInformacionfinanciera($id){ //LINK DE REVISIÓN DEL PROVEEDOR

      $proveedor = IngresoProveedor::find($id);
      //$conductor = DB::table('ingreso_conductores')->where('proveedor_id',$id)->first();
      //$vehiculo = DB::table('ingreso_vehiculos')->where('proveedor_id',$id)->first();

      if($proveedor->autorizacion_contabilidad===null and $proveedor->estado_global===1){

        return View::make('portalproveedores.gestion.datos_financieros')
        ->with('id',$id)
        ->with('proveedor',$proveedor);
        //->with('conductor',$conductor)
        //->with('vehiculo',$vehiculo);

      }else if($proveedor->autorizacion_contabilidad===1){
        return View::make('portalproveedores.gestion.datos_enviados');
      }
    }

    public function postEnviarinformacioninanciera(){ //ENVIO DE DATOS FINANCIEROS POR EL PROVEEDOR

      $id = Input::get('id');
      $option = Input::get('option');

      $consulta = DB::table('ingreso_proveedores')
      ->where('id',$id)
      ->first();

      if(intval($option)===1){

        $tipodecuenta = Input::get('tipodecuenta');
        $banco = Input::get('banco');
        $numero = Input::get('numero');
        $certificacion = Input::get('certificacion');

        if (Input::hasFile('certificacion')){

          $file_pdf = Input::file('certificacion');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $numero.$name_pdf);
          $certificacion_proveedor = $numero.$name_pdf;

        }else{
          $certificacion_proveedor = null;
        }

        $update = DB::table('ingreso_proveedores')
        ->where('id',$id)
        ->update([
          'tipo_cuenta' => $tipodecuenta,
          'entidad_bancaria' => $banco,
          'numero_cuenta' => $numero,
          'certificacion_proveedor' => $certificacion_proveedor,
          'autorizacion_contabilidad' => 1
        ]);

        if($update){

          /*ENVÍO DE CORREO AL ÁREA DE CONTABILIDAD*/
          $email = DB::table('ingreso_proveedores')
          ->where('id',$id)
          ->pluck('email');

          $email = 'sistemas@aotour.com.co'; //correo de contabilidad y link de acceso directo
          $data = [
            'email' => $email,
            'id' => $id
          ];
          Mail::send('portalproveedores.emails.envio_datos_financieros', $data, function($message) use ($email){
            $message->from('no-reply@aotour.com.co', 'AOTOUR');
            $message->to($email)->subject('PORTAL PROVEEDORES');
            $message->cc('aotourdeveloper@gmail.com');
          });
          //FIN ENVÍO DE CORREO AL PROVEEDOR*/

          return Response::json([
            'respuesta' => true
          ]);

        }else{

          return Response::json([
            'respuesta' => false
          ]);

        }

      }else if(intval($option)===2){

        $nombre = Input::get('nombre');
        $identificaciont = Input::get('identificaciont');
        $tipodecuentat = Input::get('tipodecuentat');
        $bancot = Input::get('bancot');
        $numerot = Input::get('numerot');
        $certificaciont = Input::get('certificaciont');
        $poder = Input::get('poder');

        if (Input::hasFile('certificacion')){

          $file_pdf = Input::file('certificacion');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $numero.$name_pdf);
          $certificacion_proveedor = $numero.$name_pdf;

        }else{
          $certificacion_proveedor = null;
        }

        if (Input::hasFile('poder')){

          $file_pdf = Input::file('poder');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $identificaciont.$name_pdf);
          $poder = $identificaciont.$name_pdf;

        }else{
          $poder = null;
        }

        $update = DB::table('ingreso_proveedores')
        ->where('id',$id)
        ->update([
          'razonsocial_t' => strtoupper($nombre),
          'nit_t' => $identificaciont,
          'entidad_bancaria_t' => $bancot,
          'tipo_cuenta_t' => $tipodecuentat,
          'numero_cuenta_t' => $numerot,
          'estado_tercero' => 1,
          'certificacion_bancaria_t' => $certificacion_proveedor,
          'poder_t' => $poder,
          'autorizacion_contabilidad' => 1
        ]);

        if($update){

          /*ENVÍO DE CORREO AL ÁREA CONTABILIDAD*/
          $email = DB::table('ingreso_proveedores')
          ->where('id',$id)
          ->pluck('email');

          $email = 'sistemas@aotour.com.co'; //Correo de contabilidad y link de acceso directo
          $data = [
            'email' => $email,
            'id' => $id
          ];
          Mail::send('portalproveedores.emails.envio_datos_financieros', $data, function($message) use ($email){
            $message->from('no-reply@aotour.com.co', 'AOTOUR');
            $message->to($email)->subject('PORTAL PROVEEDORES');
            $message->cc('aotourdeveloper@gmail.com');
          });
          //FIN ENVÍO DE CORREO AL PROVEEDOR*/

          return Response::json([
            'respuesta' => true
          ]);

        }else{

          return Response::json([
            'respuesta' => false
          ]);
        }

      }

    }

    public function getDatosfinancieros(){

      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $proveedores = DB::table('ingreso_proveedores')
      //->where('autorizacion_contabilidad',1)
      ->WhereNull('autorizacion_contabilidad')
      ->whereIn('estado_global', [1,2,3])
      ->get();

      return View::make('portalproveedores.pagos')
      ->with('permisos',$permisos)
      ->with('proveedores',$proveedores);
    }

    public function postAprobardatosfinancieros(){

      $id = Input::get('id');

      $proveedor = IngresoProveedor::find($id);
      if($proveedor){
        $proveedor->autorizacion_contabilidad = 1;
        //$proveedor->estado_global = 3;
        if($proveedor->save()){

          /*ENVÍO DE CORREO A LAS ÁREAS DE LA APROBACIÓN DE CONTABILIDAD*/

          $email = ['talentohumano@aotour.com.co', 'contabilidad@aotour.com.co', 'juridica@aotour.com.co', 'gestionintegral@aotour.com.co', 'comercial@aotour.com.co', 'sistemas@aotour.com.co'];

          $proveedor = DB::table('ingreso_proveedores')
          ->where('id',$id)
          ->first();

          //$email = 'sistemas@aotour.com.co'; //Correo de contabilidad y link de acceso directo
          $data = [
            //'email' => $email,
            'proveedor' => $proveedor
          ];
          Mail::send('portalproveedores.emails.aprobacion_contabilidad', $data, function($message) use ($email){
            $message->from('no-reply@aotour.com.co', 'AOTOUR');
            $message->to($email)->subject('PORTAL PROVEEDORES');
            $message->cc('aotourdeveloper@gmail.com');
          });
          //FIN ENVÍO DE CORREO AL ÁREA JURÍDICA PARA CAPACITACIÓN*/

          return Response::json([
            'response'=>true
          ]);
        }else{
          return Response::json([
            'response'=>false
          ]);
        }
      }else{
        return Response::json([
          'response'=>false
        ]);
      }
    }

    public function postSendtransportes(){

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

        if(Request::ajax()){

          $id_proveedor = Input::get('id');

          $query = IngresoProveedor::find($id_proveedor);
          $conductor = DB::table('ingreso_conductores')->where('proveedor_id',$id_proveedor)->first();
          $vehiculo = DB::table('ingreso_vehiculos')->where('proveedor_id',$id_proveedor)->first();

          $nuevo_proveedor = new Proveedor;
          $nuevo_proveedor->razonsocial = $query->razonsocial;
          $nuevo_proveedor->nit = $query->nit;
          $nuevo_proveedor->codigoverificacion = $query->digito_verificacion;
          $nuevo_proveedor->tipoempresa = $query->tipo_empresa;
          $nuevo_proveedor->direccion = $query->direccion;
          $nuevo_proveedor->departamento = $query->departamento;
          $nuevo_proveedor->ciudad = $query->ciudad;
          $nuevo_proveedor->celular = $query->celular;
          $nuevo_proveedor->telefono = $query->telefono;
          $nuevo_proveedor->email = $query->email;
          $nuevo_proveedor->nombre_completo = $query->nombre_contacto;
          $nuevo_proveedor->cargo = $query->cargo_contacto;
          $nuevo_proveedor->email_contacto = $query->email_contacto;
          $nuevo_proveedor->telefono_contacto = $query->telefono_contacto;
          $nuevo_proveedor->celular_contacto = $query->celular_contacto;
          $nuevo_proveedor->actividad_economica = $query->actividad_economica;
          $nuevo_proveedor->codigo_actividad = $query->codigo_actividad;
          $nuevo_proveedor->codigo_ica = $query->codigo_ica;
          $nuevo_proveedor->tarifa_ica = $query->tarifa_ica;
          $nuevo_proveedor->tipo_servicio = 'TRANSPORTE TERRESTRE';
          $nuevo_proveedor->tipo_cuenta = $query->tipo_cuenta;
          $nuevo_proveedor->entidad_bancaria = $query->entidad_bancaria;
          $nuevo_proveedor->certificacion_bancaria = $query->certificacion_proveedor;
          $nuevo_proveedor->numero_cuenta = $query->numero_cuenta;
          $nuevo_proveedor->tipo_afiliado = 1;
          $nuevo_proveedor->localidad = $query->sede;
          $nuevo_proveedor->save();

          $nuevo_conductor = new Conductor();
          $nuevo_conductor->nombre_completo = $conductor->nombre_completo;
          $nuevo_conductor->fecha_vinculacion = date('Y-m-d');
          $nuevo_conductor->departamento = $conductor->departamento;
          $nuevo_conductor->ciudad = $conductor->ciudad;
          $nuevo_conductor->cc = $conductor->cc;
          $nuevo_conductor->celular = $conductor->celular;
          $nuevo_conductor->telefono = $conductor->telefono;
          $nuevo_conductor->genero = $conductor->genero;
          $nuevo_conductor->edad = $conductor->edad;
          $nuevo_conductor->direccion = $conductor->direccion;
          $nuevo_conductor->tipodelicencia = $conductor->tipo_licencia;
          $nuevo_conductor->fecha_licencia_expedicion = $conductor->fecha_expedicion;
          $nuevo_conductor->fecha_licencia_vigencia = $conductor->fecha_vigencia;
          $nuevo_conductor->grupo_trabajo = $conductor->grupo_trabajo;
          $nuevo_conductor->tipo_contrato = $conductor->tipo_contrato;
          $nuevo_conductor->cargo = $conductor->cargo;
          $nuevo_conductor->experiencia = $conductor->experiencia;
          $nuevo_conductor->accidentes = $conductor->accidentes_encinco;
          $nuevo_conductor->descripcion_accidente =  $conductor->descripcion_accidente;
          $nuevo_conductor->incidentes = $conductor->incidentes;
          $nuevo_conductor->frecuencia_desplazamiento = $conductor->frecuencia_desplazamiento;
          $nuevo_conductor->vehiculo_propio_desplazamiento = $conductor->vehiculo_propio;
          $nuevo_conductor->trayecto_casa_trabajo = $conductor->trayecto_casa;

          $sgso = new Seguridadsocial();
          $sgso->fecha_inicial = $conductor->fechainicial_seguridad_social;
          $sgso->fecha_final = $conductor->fechafinal_seguridad_social;
          $sgso->numero_ingreso = $conductor->numero_planilla;
          $sgso->save();

          $nuevo_conductor->proveedores_id = $nuevo_proveedor->id;
          $nuevo_conductor->save();

          $nuevo_vehiculo = new Vehiculo();
          $nuevo_vehiculo->placa = $vehiculo->placa;
          $nuevo_vehiculo->numero_motor = $vehiculo->numero_motor;
          $nuevo_vehiculo->clase = $vehiculo->clase;
          $nuevo_vehiculo->marca = $vehiculo->marca;
          $nuevo_vehiculo->modelo = $vehiculo->linea;
          $nuevo_vehiculo->ano = $vehiculo->modelo;
          $nuevo_vehiculo->capacidad = $vehiculo->capacidad;
          $nuevo_vehiculo->color = $vehiculo->color;
          $nuevo_vehiculo->propietario = $vehiculo->propietario;
          $nuevo_vehiculo->cc = $vehiculo->cc_propietario;
          $nuevo_vehiculo->empresa_afiliada = $vehiculo->empresa_afiliada;
          $nuevo_vehiculo->tarjeta_operacion = $vehiculo->tarjeta_operacion;
          $nuevo_vehiculo->fecha_vigencia_operacion = $vehiculo->fecha_vigencia_to;
          $nuevo_vehiculo->fecha_vigencia_soat = $vehiculo->vigencia_soat;
          $nuevo_vehiculo->fecha_vigencia_tecnomecanica = $vehiculo->vigencia_tecnomecanica;
          $nuevo_vehiculo->mantenimiento_preventivo = date('Y-m-d'); ////change
          $nuevo_vehiculo->poliza_todo_riesgo = date('Y-m-d'); //change
          $nuevo_vehiculo->poliza_contractual = date('Y-m-d');
          $nuevo_vehiculo->poliza_extracontractual = date('Y-m-d');
          $nuevo_vehiculo->creado_por = Sentry::getUser()->id;
          $nuevo_vehiculo->created_at = date('Y-m-d H:m:i');
          $nuevo_vehiculo->proveedores_id = $nuevo_proveedor->id;
          $nuevo_vehiculo->numero_interno = $vehiculo->numero_interno;
          $nuevo_vehiculo->cilindraje = $vehiculo->cilindraje;
          $nuevo_vehiculo->observacion = $vehiculo->observaciones;
          $nuevo_vehiculo->numero_vin = $vehiculo->vin;
          $nuevo_vehiculo->save();

          //Guardar USER
          Config::set('cartalyst/sentry::users.login_attribute', 'username');
          $user = Sentry::createUser([
            'username'     => $query->email,
            'password'  => $query->nit,
            'activated' => true,
            'first_name'=> $query->razonsocial,
            //'last_name'=> $user->apellidos,
            'tipo_usuario' => 8,
            'id_rol' => 49,
            'usuario_portal' => 1,
            'identificacion' => $query->nit,
            'proveedor_id' => $nuevo_proveedor->id,
          ]);
          //Fin Guradar USER

          /*Guardar seguridad social del provedor*/
          $values = explode('-', $conductor->fechainicial_seguridad_social);

          $ss = new Seguridadsocial();
          $ss->fecha_inicial = $conductor->fechainicial_seguridad_social;
          $ss->fecha_final = $conductor->fechafinal_seguridad_social;
          $ss->numero_ingreso = $conductor->numero_planilla;
          $ss->pago = 1;
          $ss->ano = $values[0];
          $ss->mes = $values[1];
          $ss->creado_por = Sentry::getUser()->id;
          $ss->conductor_id = $nuevo_conductor->id;
          $ss->save();
          /*Guardar seguridad social del proveedor*/

          /*ENVÍO DE CORREO AL PROVEEDOR*/
          $email = $query->email;
          $data = [
            'email' => $query->email,
            'pass' => $query->nit
          ];
          /*Mail::send('portalproveedores.emails.entrega_usuario', $data, function($message) use ($email){
            $message->from('no-reply@aotour.com.co', 'AOTOUR');
            $message->to($email)->subject('PORTAL PROVEEDORES');
            $message->cc('aotourdeveloper@gmail.com');
          });*/
          //FIN ENVÍO DE CORREO AL PROVEEDOR*/

          if($query){

            $query->estado_global = 5;
            $email = ['talentohumano@aotour.com.co', 'contabilidad@aotour.com.co', 'juridica@aotour.com.co', 'gestionintegral@aotour.com.co', 'comercial@aotour.com.co', 'sistemas@aotour.com.co'];

            /*ENVÍO DE CORREO A TODAS LAS ÁREAS*/

            //$email = 'aotourdeveloper@gmail.com'; //Copiar a todas las área implicadas
            $data = [
              'email' => $query->email,
              'pass' => $query->nit,
              'placa' => $vehiculo->placa,
              'conductor' => $conductor->nombre_completo,
              'proveedor' => $query
            ];
            /*Mail::send('portalproveedores.emails.ingreso_proveedor', $data, function($message) use ($email){
              $message->from('no-reply@aotour.com.co', 'AOTOUR');
              $message->to($email)->subject('PORTAL PROVEEDORES');
              $message->cc('aotourdeveloper@gmail.com');
            });*/
            //FIN ENVÍO DE CORREO A GERENCIA DE OPERACIONES*/

            if($query->save()){

              return Response::json([
                'respuesta' => true
              ]);

            }else{

              return Response::json([
                'respuesta' => false
              ]);

            }

          }else{
            return Response::json([
              'respuesta' => 'noexiste'
            ]);
          }

        }

      }
    }

    public function postSendcap(){

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

        if(Request::ajax()){
          $id_proveedor = Input::get('id');

          $query = IngresoProveedor::find($id_proveedor);
          if($query){

            $query->estado_global = 4;

            if($query->save()){

              /*ENVÍO DE CORREO PARA CAPACITACIÓN*/
              //$email = $query->email;

              $email = ['talentohumano@aotour.com.co', 'contabilidad@aotour.com.co', 'juridica@aotour.com.co', 'gestionintegral@aotour.com.co', 'comercial@aotour.com.co', 'sistemas@aotour.com.co'];

              //$email = 'sistemas@aotour.com.co';
              $data = [
                'id'    => $query->id,
                'proveedor' => $query
              ];

              Mail::send('portalproveedores.emails.envio_capacitacion', $data, function($message) use ($email){
                $message->from('no-reply@aotour.com.co', 'AOTOUR');
                $message->to($email)->subject('PORTAL PROVEEDORES');
                $message->cc('aotourdeveloper@gmail.com');
              });
              //FIN ENVÍO DE CORREO AL PROVEEDOR*/

              return Response::json([
                'respuesta' => true
              ]);

            }else{

              return Response::json([
                'respuesta' => false
              ]);

            }

          }else{
            return Response::json([
              'respuesta' => 'noexiste'
            ]);
          }

        }

      }
    }

    public function postSendproveedor(){ //DEVOLVER DOCUMENTOS AL PROVEEDOR

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

        if(Request::ajax()){
          $id_proveedor = Input::get('id');

          $query = IngresoProveedor::find($id_proveedor);
          if($query){

            $query->estado_global = 2;

            if($query->save()){

              /*ENVÍO DE CORREO AL PROVEEDOR PARA CORRECCIÓN DE DOCUMENTOS*/
              $email = $query->email;
              $data = [
                'id'    => $query->id,
              ];

              Mail::send('portalproveedores.emails.documentos_rechazados', $data, function($message) use ($email){
                $message->from('no-reply@aotour.com.co', 'AOTOUR');
                $message->to($email)->subject('PORTAL PROVEEDORES');
                $message->cc('aotourdeveloper@gmail.com');
              });
              //FIN ENVÍO DE CORREO AL PROVEEDOR*/

              //ENVÍO DE CORREO A LAS ÁREAS PARA AVISAR QUE SE LE ENVÍO UNA CORRECCIÓN AL PROVEEDOR
              $email = ['talentohumano@aotour.com.co', 'contabilidad@aotour.com.co', 'juridica@aotour.com.co', 'gestionintegral@aotour.com.co', 'comercial@aotour.com.co', 'sistemas@aotour.com.co'];

              $data = [
                'id'    => $query->id,
              ];

              Mail::send('portalproveedores.emails.documentos_rechazados_ao', $data, function($message) use ($email){
                $message->from('no-reply@aotour.com.co', 'AOTOUR');
                $message->to($email)->subject('PORTAL PROVEEDORES');
                $message->cc('aotourdeveloper@gmail.com');
              });
              //FIN ENVÍO DE CORREO AL PROVEEDOR

              return Response::json([
                'respuesta' => true
              ]);

            }else{

              return Response::json([
                'respuesta' => false
              ]);

            }

          }else{
            return Response::json([
              'respuesta' => 'noexiste'
            ]);
          }

        }

      }
    }

    public function getRevisarinformacion($id){ //RECHAZO DE DOCUMENTOS

      $proveedor = IngresoProveedor::find($id);
      $conductor = DB::table('ingreso_conductores')->where('proveedor_id',$id)->first();
      $vehiculo = DB::table('ingreso_vehiculos')->where('proveedor_id',$id)->first();

      if($proveedor->estado_global===2){
        return View::make('portalproveedores.gestion.revisar_info')
        ->with('id',$id)
        ->with('proveedor',$proveedor)
        ->with('conductor',$conductor)
        ->with('vehiculo',$vehiculo);
      }else if($proveedor->estado_global===3){
        return View::make('portalproveedores.gestion.datos_enviados');
      }
    }

    public function postEnviardocumentos(){ //ENVÍO NUEVAMENTE DE DOCUMENTOS RECHAZADOS

      $id = Input::get('id');
      $proveedor = IngresoProveedor::find($id);
      $conductor = DB::table('ingreso_conductores')->where('proveedor_id',$id)->first();
      $vehiculo = DB::table('ingreso_vehiculos')->where('proveedor_id',$id)->first();

      //TECNOMECÁNICA
      if (Input::hasFile('tecnomecanica')){

        $file_pdf = Input::file('tecnomecanica');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $ubicacion_anterior = $ubicacion_pdf.$vehiculo->tecnomecanica_pdf;
        if(file_exists($ubicacion_anterior)){
            File::delete($ubicacion_anterior);
        }
        $file_pdf->move($ubicacion_pdf, $vehiculo->placa.$name_pdf);
        $cambiar = DB::table('ingreso_vehiculos')
        ->where('proveedor_id', $id)
        ->update([
            'tecnomecanica_pdf'=> $vehiculo->placa.$name_pdf,
            'autorizado_tecnomecanica' => null
        ]);
      }

      //SOAT
      if (Input::hasFile('soat')){

        $file_pdf = Input::file('soat');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $ubicacion_anterior = $ubicacion_pdf.$vehiculo->soat_pdf;
        if(file_exists($ubicacion_anterior)){
            File::delete($ubicacion_anterior);
        }
        $file_pdf->move($ubicacion_pdf, $vehiculo->placa.$name_pdf);
        $cambiar = DB::table('ingreso_vehiculos')
        ->where('proveedor_id', $id)
        ->update([
            'soat_pdf'=> $vehiculo->placa.$name_pdf,
            'autorizado_soat' => null
        ]);
      }

      //TARJETA DE PROPIEDAD
      if (Input::hasFile('tp')){

        $file_pdf = Input::file('tp');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $ubicacion_anterior = $ubicacion_pdf.$vehiculo->tarjeta_propiedad_pdf;
        if(file_exists($ubicacion_anterior)){
            File::delete($ubicacion_anterior);
        }
        $file_pdf->move($ubicacion_pdf, $vehiculo->placa.$name_pdf);
        $cambiar = DB::table('ingreso_vehiculos')
        ->where('proveedor_id', $id)
        ->update([
            'tarjeta_propiedad_pdf'=> $vehiculo->placa.$name_pdf,
            'autorizado_tp' => null
        ]);
      }

      //TARJETA DE OPERACIÓN
      if (Input::hasFile('to')){

        $file_pdf = Input::file('to');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $ubicacion_anterior = $ubicacion_pdf.$vehiculo->tarjeta_operacion_pdf;
        if(file_exists($ubicacion_anterior)){
            File::delete($ubicacion_anterior);
        }
        $file_pdf->move($ubicacion_pdf, $vehiculo->placa.$name_pdf);
        $cambiar = DB::table('ingreso_vehiculos')
        ->where('proveedor_id', $id)
        ->update([
            'tarjeta_operacion_pdf'=> $vehiculo->placa.$name_pdf,
            'autorizado_to' => null
        ]);
      }

      //CÉDULA
      if (Input::hasFile('cedula')){

        $file_pdf = Input::file('cedula');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/cc/';
        $ubicacion_anterior = $ubicacion_pdf.$conductor->pdf_cc;
        if(file_exists($ubicacion_anterior)){
            File::delete($ubicacion_anterior);
        }
        $file_pdf->move($ubicacion_pdf, $conductor->cc.$name_pdf);
        $cambiar = DB::table('ingreso_conductores')
        ->where('proveedor_id', $id)
        ->update([
            'pdf_cc'=> $conductor->cc.$name_pdf,
            'autorizado_cc' => null
        ]);
      }

      //LICENCIA
      if (Input::hasFile('licencia')){

        $file_pdf = Input::file('licencia');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/licencias/';
        $ubicacion_anterior = $ubicacion_pdf.$conductor->pdf_licencia;
        if(file_exists($ubicacion_anterior)){
            File::delete($ubicacion_anterior);
        }
        $file_pdf->move($ubicacion_pdf, $conductor->cc.$name_pdf);
        $cambiar = DB::table('ingreso_conductores')
        ->where('proveedor_id', $id)
        ->update([
            'pdf_licencia'=> $conductor->cc.$name_pdf,
            'autorizado_licencia' => null
        ]);
      }

      $email = 'juridica@aotour.com.co';

      //SEGURIDAD SOCIAL
      if (Input::hasFile('seg_social')){

        $file_pdf = Input::file('seg_social');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/seguridadsocial';

        $ubicacion_anterior = $ubicacion_pdf.$conductor->seguridad_social;

        if(file_exists($ubicacion_anterior)){
            File::delete($ubicacion_anterior);
        }

        $file_pdf->move($ubicacion_pdf, $conductor->cc.$name_pdf);
        $cambiar = DB::table('ingreso_conductores')
        ->where('proveedor_id', $id)
        ->update([
            'seguridad_social'=> $conductor->cc.$name_pdf,
            'autorizado_seguridad_social' => null,
        ]);
        $email = ['juridica@aotour.com.co', 'talentohumano@aotour.com.co'];

      }

      $cambiar_estado_proveedor = DB::table('ingreso_proveedores')
      ->where('id', $id)
      ->update([
          'estado_global'=> 3
      ]);

      /*ENVÍO DE CORREO A JURÍDICA DE LA ACTUALIZACIÓN DE DOCUMENTOS RECHAZADOS*/
      //$email = 'juridica@aotour.com.co';
      //$email = 'sistemas@aotour.com.co';
      $data = [
        'id'    => 1,
        'proveedor' => $proveedor
      ];
      Mail::send('portalproveedores.emails.documentos_reenviados', $data, function($message) use ($email){
        $message->from('no-reply@aotour.com.co', 'AUTONET');
        $message->to($email)->subject('PORTAL PROVEEDORES');
        $message->cc('aotourdeveloper@gmail.com');
      });
      //FIN ENVÍO DE CORREO AL PROVEEDOR*/

      return Response::json([
        'respuesta' => true
      ]);

    }

    public function getConductores($id){

      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $conductores = DB::table('ingreso_conductores')
      ->leftJoin('ingreso_proveedores', 'ingreso_proveedores.id', '=', 'ingreso_conductores.proveedor_id')
      ->select('ingreso_conductores.*', 'ingreso_proveedores.razonsocial', 'ingreso_proveedores.autorizacion_th', 'ingreso_proveedores.autorizacion_contabilidad')
      ->where('proveedor_id',$id)
      ->first();

      $cond = IngresoConductor::where('proveedor_id',$id)->first();
      $estado = $cond->autorizado_juridica;

      return View::make('portalproveedores.conductores.conductores')
      ->with('permisos',$permisos)
      ->with('id',$id)
      ->with('estado',$estado)
      ->with('conductor',$conductores);

    }

    public function getVehiculos($id){

      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $vehiculos = DB::table('ingreso_vehiculos')
      ->leftJoin('ingreso_proveedores', 'ingreso_proveedores.id', '=', 'ingreso_vehiculos.proveedor_id')
      ->select('ingreso_vehiculos.*', 'ingreso_proveedores.razonsocial')
      ->where('proveedor_id',$id)
      ->first();

      $veh = IngresoVehiculo::where('proveedor_id',$id)->first();
      $estado = $veh->autorizado_juridica;

      return View::make('portalproveedores.vehiculos.vehiculos')
      ->with('permisos',$permisos)
      ->with('id',$id)
      ->with('estado',$estado)
      ->with('vehiculos',$vehiculos);

    }

    public function getVehiculosdetalles($id){

      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $vehiculos = DB::table('ingreso_vehiculos')
      ->leftJoin('ingreso_proveedores', 'ingreso_proveedores.id', '=', 'ingreso_vehiculos.proveedor_id')
      ->select('ingreso_vehiculos.*', 'ingreso_proveedores.razonsocial')
      ->where('ingreso_vehiculos.id',$id)
      ->first();

      $veh = IngresoVehiculo::where('id',$id)->first();
      $estado = $veh->autorizado_juridica;

      return View::make('portalproveedores.vehiculos.vehiculos_detalles')
      ->with('permisos',$permisos)
      ->with('id',$id)
      ->with('estado',$estado)
      ->with('vehiculos',$vehiculos);

    }

    public function getSeguridadsocial(){

      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $conductores = DB::table('ingreso_conductores')
      ->leftJoin('ingreso_proveedores', 'ingreso_proveedores.id', '=', 'ingreso_conductores.proveedor_id')
      ->select('ingreso_conductores.*', 'ingreso_proveedores.autorizacion_th', 'ingreso_proveedores.razonsocial', 'ingreso_proveedores.tipo_empresa')
      ->whereNull('autorizacion_th')
      ->whereIn('ingreso_proveedores.estado_global',[1,2,3])
      ->get();

      return View::make('portalproveedores.seguridad_social')
      ->with('permisos',$permisos)
      ->with('conductores',$conductores);
    }

    public function getConductoresagregados(){

      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $conductores = DB::table('ingreso_conductores')
      ->leftJoin('proveedores', 'proveedores.id', '=', 'ingreso_conductores.proveedor_id')
      ->select('ingreso_conductores.*', 'proveedores.razonsocial')
      ->where('estado_aprobado',0)
      //->whereIn('ingreso_proveedores.estado_global',[1,2,3])
      ->get();

      return View::make('portalproveedores.conductores_agregados')
      ->with('permisos',$permisos)
      ->with('conductores',$conductores);
    }

    public function postAprobarproveedor(){

      $id = Input::get('id');

      $proveedor = IngresoProveedor::find($id);

      if($proveedor){
        $proveedor->autorizado_juridica = 1;
        if($proveedor->save()){

          $vehiculo = IngresoVehiculo::where('proveedor_id',$id)->first();
          $conductor = IngresoConductor::where('proveedor_id',$id)->first();

          if($vehiculo->autorizado_juridica===1 and $conductor->autorizado_juridica===1){
            $proveedor->autorizacion_juridica = 1;
            $proveedor->save();
          }

          return Response::json([
            'response'=>true
          ]);
        }else{
          return Response::json([
            'response'=>false
          ]);
        }
      }else{
        return Response::json([
          'response'=>false
        ]);
      }
    }

    public function postAprobarvehiculo(){

      $id = Input::get('id');

      $vehiculo = IngresoVehiculo::where('proveedor_id',$id)->first();

      if($vehiculo){
        $vehiculo->autorizado_juridica = 1;
        if($vehiculo->save()){

          $proveedor = IngresoProveedor::find($id);
          $conductor = IngresoConductor::where('proveedor_id',$id)->first();

          if($proveedor->autorizado_juridica===1 and $conductor->autorizado_juridica===1){
            $proveedor->autorizacion_juridica = 1;
            $proveedor->save();
          }

          return Response::json([
            'response'=>true
          ]);
        }else{
          return Response::json([
            'response'=>false
          ]);
        }
      }else{
        return Response::json([
          'response'=>false
        ]);
      }
    }

    public function postAprobarconductorth(){

      $id = Input::get('id');
      $numero_planilla = Input::get('numero_planilla');
      $fecha_inicial = Input::get('fecha_inicial');
      $fecha_final = Input::get('fecha_final');

      $conductor = IngresoConductor::find($id);

      $proveedor = IngresoProveedor::find($conductor->proveedor_id);

      if($proveedor){

        $proveedor->autorizacion_th = 1;

        if($proveedor->save()){

          $conductor->fechainicial_seguridad_social = $fecha_inicial;
          $conductor->fechafinal_seguridad_social = $fecha_final;
          $conductor->numero_planilla = $numero_planilla;
          $conductor->save();

          /*ENVÍO DE CORREO A LAS ÁREAS DE LA APROBACIÓN DE CONTABILIDAD*/

          $email = ['talentohumano@aotour.com.co', 'contabilidad@aotour.com.co', 'juridica@aotour.com.co', 'gestionintegral@aotour.com.co', 'comercial@aotour.com.co', 'sistemas@aotour.com.co'];

          $proveedor = DB::table('ingreso_proveedores')
          ->where('id',$id)
          ->first();

          //$email = 'sistemas@aotour.com.co'; //Correo de contabilidad y link de acceso directo
          $data = [
            //'email' => $email,
            'proveedor' => $proveedor
          ];
          Mail::send('portalproveedores.emails.aprobacion_th', $data, function($message) use ($email){
            $message->from('no-reply@aotour.com.co', 'AOTOUR');
            $message->to($email)->subject('PORTAL PROVEEDORES');
            $message->cc('aotourdeveloper@gmail.com');
          });
          //FIN ENVÍO DE CORREO AL ÁREA JURÍDICA PARA CAPACITACIÓN*/

          return Response::json([
            'response'=>true
          ]);

        }else{

          return Response::json([
            'response'=>false
          ]);

        }

      }else{

        return Response::json([
          'response'=>false
        ]);

      }
    }

    public function postAprobarconductornuevo(){

      $id = Input::get('id');
      $numero_planilla = Input::get('numero_planilla');
      $fecha_inicial = Input::get('fecha_inicial');
      $fecha_final = Input::get('fecha_final');

      $conductor = IngresoConductor::find($id);

      $nuevo_conductor = new Conductor();
      $nuevo_conductor->nombre_completo = $conductor->nombre_completo;
      $nuevo_conductor->fecha_vinculacion = date('Y-m-d');
      $nuevo_conductor->departamento = $conductor->departamento;
      $nuevo_conductor->ciudad = $conductor->ciudad;
      $nuevo_conductor->cc = $conductor->cc;
      $nuevo_conductor->celular = $conductor->celular;
      $nuevo_conductor->telefono = $conductor->telefono;
      $nuevo_conductor->genero = $conductor->genero;
      $nuevo_conductor->edad = $conductor->edad;
      $nuevo_conductor->direccion = $conductor->direccion;
      $nuevo_conductor->tipodelicencia = $conductor->tipo_licencia;
      $nuevo_conductor->fecha_licencia_expedicion = $conductor->fecha_expedicion;
      $nuevo_conductor->fecha_licencia_vigencia = $conductor->fecha_vigencia;
      $nuevo_conductor->grupo_trabajo = $conductor->grupo_trabajo;
      $nuevo_conductor->tipo_contrato = $conductor->tipo_contrato;
      $nuevo_conductor->cargo = $conductor->cargo;
      $nuevo_conductor->experiencia = $conductor->experiencia;
      $nuevo_conductor->accidentes = $conductor->accidentes_encinco;
      $nuevo_conductor->descripcion_accidente =  $conductor->descripcion_accidente;
      $nuevo_conductor->incidentes = $conductor->incidentes;
      $nuevo_conductor->frecuencia_desplazamiento = $conductor->frecuencia_desplazamiento;
      $nuevo_conductor->vehiculo_propio_desplazamiento = $conductor->vehiculo_propio;
      $nuevo_conductor->trayecto_casa_trabajo = $conductor->trayecto_casa;
      $nuevo_conductor->estado = 'ACTIVO';
      $nuevo_conductor->creado_por = Sentry::getUser()->id;

      $nuevo_conductor->proveedores_id = $conductor->proveedor_id;
      $nuevo_conductor->save();

      $sgso = new Seguridadsocial();
      $sgso->fecha_inicial = $fecha_inicial;
      $sgso->fecha_final = $fecha_final;
      $sgso->numero_ingreso = $numero_planilla;
      $sgso->conductor_id = $nuevo_conductor->id;
      $sgso->creado_por = Sentry::getUser()->id;
      $sgso->pago = 1;
      $sgso->save();

      $proveedor = Proveedor::find($conductor->proveedor_id);

      if($proveedor){

        $conductor->estado_aprobado = 1;
        $conductor->save();
        //$conductor->fechainicial_seguridad_social = $fecha_inicial;
        //$conductor->fechafinal_seguridad_social = $fecha_final;
        //$conductor->numero_planilla = $numero_planilla;
        //$conductor->save();

        /*ENVÍO DE CORREO A LAS ÁREAS DE LA APROBACIÓN DE CONTABILIDAD*/

        //$email = ['talentohumano@aotour.com.co', 'contabilidad@aotour.com.co', 'juridica@aotour.com.co', 'gestionintegral@aotour.com.co', 'comercial@aotour.com.co', 'sistemas@aotour.com.co'];

        $proveedor = DB::table('proveedores')
        ->where('id',$conductor->proveedor_id)
        ->first();

        $email = $proveedor->email;
        //$email = 'sistemas@aotour.com.co'; //Correo de contabilidad y link de acceso directo
        $data = [
          //'email' => $email,
          'conductor' => $nuevo_conductor->nombre_completo
        ];
        Mail::send('portalproveedores.emails.aprobacion_conductor_nuevo', $data, function($message) use ($email){
          $message->from('no-reply@aotour.com.co', 'Notificaciones Aotour');
          $message->to($email)->subject('¡Conductor Aprobado!');
          $message->bcc('juridica@aotour.com.co');
        });
        //FIN ENVÍO DE CORREO AL ÁREA JURÍDICA PARA CAPACITACIÓN*/

        /*Envío de Mensaje WPP al conductor*/

        /*Envío de Mensaje WPP al conductor*/

        return Response::json([
          'respuesta'=>true
        ]);

      }else{

        return Response::json([
          'respuesta'=>false
        ]);

      }
    }

    public function postNoaprobarconductorth(){

      $id = Input::get('id');

      $conductor = IngresoConductor::find($id);

      $proveedor = IngresoProveedor::find($conductor->proveedor_id);

      if($proveedor){

        $proveedor->autorizacion_th = 2;

        if($proveedor->save()){

          $conductor->autorizado_seguridad_social = 2;
          $conductor->save();

          /*ENVÍO DE CORREO A LAS ÁREAS DE LA NO APROBACIÓN DE TH*/

          /*$email = ['talentohumano@aotour.com.co', 'contabilidad@aotour.com.co', 'juridica@aotour.com.co', 'gestionintegral@aotour.com.co', 'comercial@aotour.com.co', 'sistemas@aotour.com.co'];

          $proveedor = DB::table('ingreso_proveedores')
          ->where('id',$id)
          ->first();

          //$email = 'sistemas@aotour.com.co'; //Correo de contabilidad y link de acceso directo

          $data = [
            'proveedor' => $proveedor
          ];
          Mail::send('portalproveedores.emails.noaprobacionth', $data, function($message) use ($email){
            $message->from('no-reply@aotour.com.co', 'AOTOUR');
            $message->to($email)->subject('PORTAL PROVEEDORES');
            $message->cc('aotourdeveloper@gmail.com');
          });*/
          //FIN ENVÍO DE CORREO A LAS ÁREAS DE LA NO APROBACIÓN DE TH*/

          return Response::json([
            'response'=>true
          ]);

        }else{

          return Response::json([
            'response'=>false
          ]);

        }

      }else{

        return Response::json([
          'response'=>false
        ]);

      }
    }

    public function postAprobarconductorju(){

      $id = Input::get('id');

      $conductor = IngresoConductor::where('proveedor_id',$id)->first();

      if($conductor){
        $conductor->autorizado_juridica = 1;
        if($conductor->save()){

          $proveedor = IngresoProveedor::find($id);
          $vehiculo = IngresoVehiculo::where('proveedor_id',$id)->first();

          if($proveedor->autorizado_juridica===1 and $vehiculo->autorizado_juridica===1){
            $proveedor->autorizacion_juridica = 1;
            $proveedor->save();
          }

          return Response::json([
            'response'=>true
          ]);
        }else{
          return Response::json([
            'response'=>false
          ]);
        }
      }else{
        return Response::json([
          'response'=>false
        ]);
      }
    }

    public function postGuardarp2(){

      $nombre_proveedor = Input::get('nombre_proveedor');
      $cc_proveedor = Input::get('cc_proveedor');
      $digito_verificacion = Input::get('digito_verificacion');
      $email = Input::get('email_proveedor');
      $tipo_empresa = Input::get('tipo_empresa');
      $celular = Input::get('celular');
      $telefono = Input::get('telefono');
      $direccion = Input::get('direccion');
      $departamento = Input::get('departamento');
      $ciudad = Input::get('ciudad');
      $sede = Input::get('sede');

      $tipo_cuenta = Input::get('tipo_cuenta');
      $entidad_bancaria = Input::get('entidad_bancaria');
      $numero_cuenta = Input::get('numero_cuenta');
      $certificacion_proveedor = Input::get('certificacion_proveedor');

      $pre = new IngresoProveedor;
      $pre->razonsocial = strtoupper($nombre_proveedor);
      $pre->nit = $cc_proveedor;
      $pre->digito_verificacion = $digito_verificacion;
      $pre->email = strtoupper($email);
      $pre->tipo_empresa = strtoupper($tipo_empresa);
      $pre->celular = strtoupper($celular);
      $pre->telefono = strtoupper($telefono);
      $pre->direccion = strtoupper($direccion);
      $pre->departamento = strtoupper($departamento);
      $pre->ciudad = strtoupper($ciudad);
      $pre->sede = strtoupper($sede);

      $option = Input::get('option');

      if(intval($option)===1){

        $tipodecuenta = Input::get('tipodecuenta');
        $banco = Input::get('banco');
        $numero = Input::get('numero');
        $certificacion = Input::get('certificacion');

        if (Input::hasFile('certificacion')){

          $file_pdf = Input::file('certificacion');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $numero.$name_pdf);
          $certificacion_proveedor = $numero.$name_pdf;

        }else{
          $certificacion_proveedor = null;
        }

        $pre->tipo_cuenta = $tipodecuenta;
        $pre->entidad_bancaria = $banco;
        $pre->numero_cuenta = $numero;
        $pre->certificacion_proveedor = $certificacion_proveedor;

      }else if(intval($option)===2){

        $nombre = Input::get('nombre');
        $identificaciont = Input::get('identificaciont');
        $tipodecuentat = Input::get('tipodecuentat');
        $bancot = Input::get('bancot');
        $numerot = Input::get('numerot');
        $certificaciont = Input::get('certificaciont');
        $poder = Input::get('poder');

        if (Input::hasFile('certificaciont')){

          $file_pdf = Input::file('certificaciont');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $numero.$name_pdf);
          $certificacion_proveedor = $numero.$name_pdf;

        }else{
          $certificacion_proveedor = null;
        }

        if (Input::hasFile('poder')){

          $file_pdf = Input::file('poder');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $identificaciont.$name_pdf);
          $poder = $identificaciont.$name_pdf;

        }else{
          $poder = null;
        }

        $pre->razonsocial_t = strtoupper($nombre);
        $pre->nit_t = $identificaciont;
        $pre->entidad_bancaria_t = $bancot;
        $pre->tipo_cuenta_t = $tipodecuentat;
        $pre->numero_cuenta_t = $numerot;
        $pre->estado_tercero = 1;
        $pre->certificacion_bancaria_t = $certificacion_proveedor;
        $pre->poder_t = $poder;

      }

      if (Input::hasFile('fotop')){//FOTO PROVEEDOR

        $file_pdf = Input::file('fotop');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
        $placa = 'Foto_proveedor';
        //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
        $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
        $pre->foto_proveedor = $placa.$name_pdf;

      }else{
        $pre->foto_proveedor = 0;
      }

      if(intval(Input::get('tipo'))==1){
        $pre->nombre_contacto = strtoupper(Input::get('contacto_nombrecompleto'));
        $pre->cargo_contacto = strtoupper(Input::get('cargop'));
        $pre->email_contacto = strtoupper(Input::get('email_contacto'));
        $pre->telefono_contacto = Input::get('telefono_contacto');
        $pre->celular_contacto = Input::get('celular_contacto');
        $pre->actividad_economica = strtoupper(Input::get('actividad_economica'));
        $pre->codigo_actividad = strtoupper(Input::get('codigo_actividad'));
        $pre->codigo_ica = strtoupper(Input::get('codigo_ica'));
        $pre->tarifa_ica = strtoupper(Input::get('tarifa_ica'));
        $pre->tipo_servicio = strtoupper(Input::get('tipo_servicio'));
      }

      //DATOS BANCARIOS PROVEEDOR
      $pre->tipo_cuenta = $tipo_cuenta;
      $pre->entidad_bancaria = $entidad_bancaria;
      $pre->numero_cuenta = $numero_cuenta;
      if (Input::hasFile('certificacion_proveedor')){

        $file_pdf = Input::file('certificacion_proveedor');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
        $file_pdf->move($ubicacion_pdf, $cc_proveedor.$name_pdf);
        $pre->certificacion_proveedor = $cc_proveedor.$name_pdf;

      }else{
        $pre->certificacion_proveedor = 0;
      }

      if($pre->save()){

        return Response::json([
          'respuesta' => true,
          'id' => $pre->id
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postGuardarv(){

      $id = Input::get('id');

      //INGRESO DE VEHÍCULOS
      $numero_interno = Input::get('numero_interno');
      $tipo_transporte = Input::get('tipo_transporte');
      $placa = Input::get('placa');
      $numero_motor = Input::get('numero_motor');
      $clase = Input::get('clase');
      $marca = Input::get('marca');
      $modelo = Input::get('modelo');
      $ano = Input::get('ano');
      $capacidad = Input::get('capacidad');
      $color = Input::get('color');
      $cilindraje = Input::get('cilindraje');
      $vn = Input::get('vn');
      $propietario = Input::get('propietario');
      $cc_propietario = Input::get('cc_propietario');
      $empresa_afiliada = Input::get('empresa_afiliada');
      if($empresa_afiliada!='AOTOUR'){
        $empresa_afiliada = Input::get('cual_empresa');
      }
      $observaciones = Input::get('observaciones');
      $poliza_contractual = Input::get('poliza_contractual');
      $poliza_extra_contractual = Input::get('poliza_extra_contractual');
      $poliza_todo_riesgo = Input::get('poliza_todo_riesgo');
      $tarjeta_propiedad = Input::get('tarjeta_propiedad');
      $tarjeta_operacion = Input::get('tarjeta_operacion');
      $fecha_vigencia_propiedad = Input::get('fecha_vigencia_propiedad');
      $fecha_vigencia_operacion = Input::get('fecha_vigencia_operacion');
      $fecha_vigencia_soat = Input::get('fecha_vigencia_soat');
      $pdf_tpro = Input::get('pdf_tpro');
      $pdf_topr = Input::get('pdf_topr');
      $pdf_soat = Input::get('pdf_soat');
      $vigencia_tecnomecanica = Input::get('vigencia_tecnomecanica');
      //$vigencia_contractual = Input::get('vigencia_contractual'); ...
      //$vigencia_extracontractual = Input::get('vigencia_extracontractual'); ...
      $pdf_tecno = Input::get('pdf_tecno');

      $vehiculo = new IngresoVehiculo;
      $vehiculo->numero_interno = $numero_interno;
      $vehiculo->tipo_transporte = strtoupper($tipo_transporte);
      $vehiculo->placa = strtoupper($placa);
      $vehiculo->numero_motor = $numero_motor;
      $vehiculo->clase = strtoupper($clase);
      $vehiculo->marca = strtoupper($marca);
      $vehiculo->linea = strtoupper($modelo);
      $vehiculo->modelo = $ano;
      $vehiculo->capacidad = $capacidad;
      $vehiculo->color = strtoupper($color);
      $vehiculo->cilindraje = strtoupper($cilindraje);
      $vehiculo->vin = $vn;
      $vehiculo->propietario = strtoupper($propietario);
      $vehiculo->cc_propietario = $cc_propietario;
      $vehiculo->empresa_afiliada = strtoupper($empresa_afiliada);
      $vehiculo->observaciones = strtoupper($observaciones);
      $vehiculo->poliza_contractual = strtoupper($poliza_contractual);
      $vehiculo->poliza_extra_contractual = strtoupper($poliza_extra_contractual);
      $vehiculo->poliza_todo_riesgo = strtoupper($poliza_todo_riesgo);
      $vehiculo->tarjeta_propiedad = strtoupper($tarjeta_propiedad);
      $vehiculo->tarjeta_operacion = $tarjeta_operacion;
      $vehiculo->fecha_vigencia_tp = $fecha_vigencia_propiedad;
      $vehiculo->fecha_vigencia_to = $fecha_vigencia_operacion;
      $vehiculo->vigencia_soat = $fecha_vigencia_soat;

      if (Input::hasFile('pdf_tpro')){

        $file_pdf = Input::file('pdf_tpro');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
        $vehiculo->tarjeta_propiedad_pdf = $placa.$name_pdf;

      }else{
        $vehiculo->tarjeta_propiedad_pdf = 0;
      }

      if (Input::hasFile('pdf_topr')){

        $file_pdf = Input::file('pdf_topr');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
        $vehiculo->tarjeta_operacion_pdf = $placa.$name_pdf;

      }else{
        $vehiculo->tarjeta_operacion_pdf = 0;
      }

      if (Input::hasFile('pdf_soat')){

        $file_pdf = Input::file('pdf_soat');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
        $vehiculo->soat_pdf = $placa.$name_pdf;

      }else{
        $vehiculo->soat_pdf = 0;
      }

      $vehiculo->vigencia_tecnomecanica = $vigencia_tecnomecanica;

      if (Input::hasFile('pdf_tecno')){

        $file_pdf = Input::file('pdf_tecno');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
        $vehiculo->tecnomecanica_pdf = $placa.$name_pdf;

      }else{
        $vehiculo->tecnomecanica_pdf = 0;
      }

      // PÓLIZAS PDF
      if (Input::hasFile('pdf_contra')){

        $file_pdf = Input::file('pdf_contra');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
        $random = '1234';//colocar número random
        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $file_pdf->move($ubicacion_pdf, $random.$name_pdf);
        $vehiculo->poliza_contractual_pdf = $random.$name_pdf;

      }else{
        $vehiculo->poliza_contractual_pdf = 0;
      }

      if (Input::hasFile('pdf_extra')){

        $file_pdf = Input::file('pdf_extra');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
        $random = '1234';//colocar número random
        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $file_pdf->move($ubicacion_pdf, $random.$name_pdf);
        $vehiculo->poliza_extra_contractual_pdf = $random.$name_pdf;

      }else{
        $vehiculo->poliza_extra_contractual_pdf = 0;
      }
      //PÓLIZAS PDF

      if (Input::hasFile('foto_frontal')){//FOTO FRONTAL

        $file_pdf = Input::file('foto_frontal');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
        $placa = 'UNO';
        //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
        $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
        $vehiculo->foto_frontal = $placa.$name_pdf;

      }else{
        $vehiculo->foto_frontal = 0;
      }

      if (Input::hasFile('foto_dorso')){//FOTO DORSO

        $file_pdf = Input::file('foto_dorso');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
        $placa = 'UNO';
        //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
        $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
        $vehiculo->foto_dorso = $placa.$name_pdf;

      }else{
        $vehiculo->foto_dorso = 0;
      }

      if (Input::hasFile('foto_derecha')){//FOTO DERECHA

        $file_pdf = Input::file('foto_derecha');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
        $placa = 'UNO';
        //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
        $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
        $vehiculo->foto_derecha = $placa.$name_pdf;

      }else{
        $vehiculo->foto_derecha = 0;
      }

      if (Input::hasFile('foto_izquierda')){//FOTO IZQUIERDA

        $file_pdf = Input::file('foto_izquierda');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
        $placa = 'UNO';
        //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
        $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
        $vehiculo->foto_izquierda = $placa.$name_pdf;

      }else{
        $vehiculo->foto_izquierda = 0;
      }

      $vehiculo->proveedor_id = $id;

      if($vehiculo->save()){

        return Response::json([
          'respuesta' => true,
          'id' => $id
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postGuardarco(){

      $id = Input::get('id');

      $nombre_completoc = Input::get('nombre_completoc');
      $departamentoc = Input::get('departamentoc');
      $ciudadc = Input::get('ciudadc');
      $generoc = Input::get('generoc');
      $edadc = Input::get('edadc');
      $ccc = Input::get('ccc');
      $celularc = Input::get('celularc');
      $telefonoc = Input::get('telefonoc');
      $direccionc = Input::get('direccionc');
      $tipodelicenciac = Input::get('tipodelicenciac');
      $fecha_licencia_expedicionc = Input::get('fecha_licencia_expedicionc');
      $fecha_licencia_vigenciac = Input::get('fecha_licencia_vigenciac');
      $grupo_trabajoc = Input::get('grupo_trabajoc');
      $tipo_contratoc = Input::get('tipo_contratoc');
      $cargoc = Input::get('cargoc');
      $experienciac = Input::get('experienciac');
      $accidentesc = Input::get('accidentesc');
      $descripcion_accidentec = Input::get('descripcion_accidentec');
      $fotoc = Input::get('fotoc');
      $pdf_ss = Input::get('pdf_ss');

      $conductor = new IngresoConductor;
      $conductor->nombre_completo = strtoupper($nombre_completoc);
      $conductor->departamento = strtoupper($departamentoc);
      $conductor->ciudad = strtoupper($ciudadc);
      $conductor->genero = strtoupper($generoc);
      $conductor->edad = $edadc;
      $conductor->cc = $ccc;
      $conductor->celular = $celularc;
      $conductor->telefono = $telefonoc;
      $conductor->direccion = strtoupper($direccionc);
      $conductor->tipo_licencia = strtoupper($tipodelicenciac);
      $conductor->fecha_expedicion = $fecha_licencia_expedicionc;
      $conductor->fecha_vigencia = $fecha_licencia_vigenciac;
      $conductor->grupo_trabajo = strtoupper($grupo_trabajoc);
      $conductor->tipo_contrato = strtoupper($tipo_contratoc);
      $conductor->cargo = strtoupper($cargoc);
      $conductor->experiencia = $experienciac;
      $conductor->accidentes_encinco = strtoupper($accidentesc);
      $conductor->descripcion_accidente = strtoupper($descripcion_accidentec);

      if (Input::hasFile('fotoc')){

        $file = Input::file('fotoc');
        $ubicacion = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/';
        $nombre_imagen = $file->getClientOriginalName();

        $conductor->foto_conductor = $nombre_imagen;

        Image::make($file->getRealPath())->resize(250, 316)->save($ubicacion.$nombre_imagen);

        Image::make($file->getRealPath())
        ->resize(250, 250)->save($ubicacion.'thumbnail'.$nombre_imagen);

      }else{

        $conductor->foto_conductor = 'FALSE';
      }

      //PDF CÉDULA DEL CONDUCTOR
      if(Input::hasFile('pdf_cc_conductor')){

        $file_pdf = Input::file('pdf_cc_conductor');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/cc/';
        $file_pdf->move($ubicacion_pdf, $ccc.$name_pdf);
        $conductor->pdf_cc = $ccc.$name_pdf;

      }else{
        $conductor->pdf_cc = 0;
      }

      //PDF LICENCIA DEL CONDUCCIÓN
      if(Input::hasFile('pdf_licencia_conductor')){

        $file_pdf = Input::file('pdf_licencia_conductor');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/licencias/';
        $file_pdf->move($ubicacion_pdf, $ccc.$name_pdf);
        $conductor->pdf_licencia = $ccc.$name_pdf;

      }else{
        $conductor->pdf_licencia = 0;
      }

      //PDF SEGURIDAD SOCIAL DEL CONDUCTOR
      if(Input::hasFile('pdf_ss')){

        $file_pdf = Input::file('pdf_ss');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/seguridadsocial';
        $file_pdf->move($ubicacion_pdf, $ccc.$name_pdf);
        $conductor->seguridad_social = $ccc.$name_pdf;

      }else{
        $conductor->seguridad_social = 0;
      }

      $conductor->proveedor_id = $id;
      $conductor->save();

      /*ENVÍO DE CORREO AL GERENTE DE OPERACIONES

      //$email = 'gerenteoperaciones@aotour.com.co';
      $email = 'sistemas@aotour.com.co';

      $cc = ['comercial@aotour.com.co', 'gestionintegral@aotour.com.co' ,'aotourdeveloper@gmail.com']; //REGISTRO DE PROVEEDOR
      $data = [
        'id' => 1
      ];
      Mail::send('portalproveedores.emails.registro', $data, function($message) use ($email, $cc){
        $message->from('no-reply@aotour.com.co', 'AUTONET');
        $message->to($email)->subject('PORTAL PROVEEDORES');
        //$message->cc($cc);
      });
      //FIN ENVÍO DE CORREO AL PROVEEDOR*/

      return Response::json([
        'respuesta' => true,
        //'conductor' => $conductor,
        //'vehiculo' => $vehiculo
      ]);

    }

    public function postGuardarp(){ //GUARDADO DE PROVEEDOR

      $nombre_proveedor = Input::get('nombre_proveedor');
      $cc_proveedor = Input::get('cc_proveedor');
      $digito_verificacion = Input::get('digito_verificacion');
      $email = Input::get('email_proveedor');
      $tipo_empresa = Input::get('tipo_empresa');
      $celular = Input::get('celular');
      $telefono = Input::get('telefono');
      $direccion = Input::get('direccion');
      $departamento = Input::get('departamento');
      $ciudad = Input::get('ciudad');
      $sede = Input::get('sede');

      $tipo_cuenta = Input::get('tipo_cuenta');
      $entidad_bancaria = Input::get('entidad_bancaria');
      $numero_cuenta = Input::get('numero_cuenta');
      $certificacion_proveedor = Input::get('certificacion_proveedor');

      $pre = new IngresoProveedor;
      $pre->razonsocial = strtoupper($nombre_proveedor);
      $pre->nit = $cc_proveedor;
      $pre->digito_verificacion = $digito_verificacion;
      $pre->email = strtoupper($email);
      $pre->tipo_empresa = strtoupper($tipo_empresa);
      $pre->celular = strtoupper($celular);
      $pre->telefono = strtoupper($telefono);
      $pre->direccion = strtoupper($direccion);
      $pre->departamento = strtoupper($departamento);
      $pre->ciudad = strtoupper($ciudad);
      $pre->sede = strtoupper($sede);

      $option = Input::get('option');

      if(intval($option)===1){

        $tipodecuenta = Input::get('tipodecuenta');
        $banco = Input::get('banco');
        $numero = Input::get('numero');
        $certificacion = Input::get('certificacion');

        if (Input::hasFile('certificacion')){

          $file_pdf = Input::file('certificacion');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $numero.$name_pdf);
          $certificacion_proveedor = $numero.$name_pdf;

        }else{
          $certificacion_proveedor = null;
        }

        $pre->tipo_cuenta = $tipodecuenta;
        $pre->entidad_bancaria = $banco;
        $pre->numero_cuenta = $numero;
        $pre->certificacion_proveedor = $certificacion_proveedor;

      }else if(intval($option)===2){

        $nombre = Input::get('nombre');
        $identificaciont = Input::get('identificaciont');
        $tipodecuentat = Input::get('tipodecuentat');
        $bancot = Input::get('bancot');
        $numerot = Input::get('numerot');
        $certificaciont = Input::get('certificaciont');
        $poder = Input::get('poder');

        if (Input::hasFile('certificaciont')){

          $file_pdf = Input::file('certificaciont');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $numero.$name_pdf);
          $certificacion_proveedor = $numero.$name_pdf;

        }else{
          $certificacion_proveedor = null;
        }

        if (Input::hasFile('poder')){

          $file_pdf = Input::file('poder');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $identificaciont.$name_pdf);
          $poder = $identificaciont.$name_pdf;

        }else{
          $poder = null;
        }

        $pre->razonsocial_t = strtoupper($nombre);
        $pre->nit_t = $identificaciont;
        $pre->entidad_bancaria_t = $bancot;
        $pre->tipo_cuenta_t = $tipodecuentat;
        $pre->numero_cuenta_t = $numerot;
        $pre->estado_tercero = 1;
        $pre->certificacion_bancaria_t = $certificacion_proveedor;
        $pre->poder_t = $poder;

      }

      if (Input::hasFile('fotop')){//FOTO PROVEEDOR

        $file_pdf = Input::file('fotop');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
        $placa = 'Foto_proveedor';
        //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
        $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
        $pre->foto_proveedor = $placa.$name_pdf;

      }else{
        $pre->foto_proveedor = 0;
      }

      if(intval(Input::get('tipo'))==1){
        $pre->nombre_contacto = strtoupper(Input::get('contacto_nombrecompleto'));
        $pre->cargo_contacto = strtoupper(Input::get('cargop'));
        $pre->email_contacto = strtoupper(Input::get('email_contacto'));
        $pre->telefono_contacto = Input::get('telefono_contacto');
        $pre->celular_contacto = Input::get('celular_contacto');
        $pre->actividad_economica = strtoupper(Input::get('actividad_economica'));
        $pre->codigo_actividad = strtoupper(Input::get('codigo_actividad'));
        $pre->codigo_ica = strtoupper(Input::get('codigo_ica'));
        $pre->tarifa_ica = strtoupper(Input::get('tarifa_ica'));
        $pre->tipo_servicio = strtoupper(Input::get('tipo_servicio'));
      }

      //DATOS BANCARIOS PROVEEDOR
      $pre->tipo_cuenta = $tipo_cuenta;
      $pre->entidad_bancaria = $entidad_bancaria;
      $pre->numero_cuenta = $numero_cuenta;
      if (Input::hasFile('certificacion_proveedor')){

        $file_pdf = Input::file('certificacion_proveedor');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
        $file_pdf->move($ubicacion_pdf, $cc_proveedor.$name_pdf);
        $pre->certificacion_proveedor = $cc_proveedor.$name_pdf;

      }else{
        $pre->certificacion_proveedor = 0;
      }

      //fin proveedor

      if($pre->save()){

        //INGRESO DE VEHÍCULOS
        $numero_interno = Input::get('numero_interno');
        $tipo_transporte = Input::get('tipo_transporte');
        $placa = Input::get('placa');
        $numero_motor = Input::get('numero_motor');
        $clase = Input::get('clase');
        $marca = Input::get('marca');
        $modelo = Input::get('modelo');
        $ano = Input::get('ano');
        $capacidad = Input::get('capacidad');
        $color = Input::get('color');
        $cilindraje = Input::get('cilindraje');
        $vn = Input::get('vn');
        $propietario = Input::get('propietario');
        $cc_propietario = Input::get('cc_propietario');
        $empresa_afiliada = Input::get('empresa_afiliada');
        if($empresa_afiliada!='AOTOUR'){
          $empresa_afiliada = Input::get('cual_empresa');
        }
        $observaciones = Input::get('observaciones');
        $poliza_contractual = Input::get('poliza_contractual');
        $poliza_extra_contractual = Input::get('poliza_extra_contractual');
        $poliza_todo_riesgo = Input::get('poliza_todo_riesgo');
        $tarjeta_propiedad = Input::get('tarjeta_propiedad');
        $tarjeta_operacion = Input::get('tarjeta_operacion');
        $fecha_vigencia_propiedad = Input::get('fecha_vigencia_propiedad');
        $fecha_vigencia_operacion = Input::get('fecha_vigencia_operacion');
        $fecha_vigencia_soat = Input::get('fecha_vigencia_soat');
        $pdf_tpro = Input::get('pdf_tpro');
        $pdf_topr = Input::get('pdf_topr');
        $pdf_soat = Input::get('pdf_soat');
        $vigencia_tecnomecanica = Input::get('vigencia_tecnomecanica');
        //$vigencia_contractual = Input::get('vigencia_contractual'); ...
        //$vigencia_extracontractual = Input::get('vigencia_extracontractual'); ...
        $pdf_tecno = Input::get('pdf_tecno');

        $vehiculo = new IngresoVehiculo;
        $vehiculo->numero_interno = $numero_interno;
        $vehiculo->tipo_transporte = strtoupper($tipo_transporte);
        $vehiculo->placa = strtoupper($placa);
        $vehiculo->numero_motor = $numero_motor;
        $vehiculo->clase = strtoupper($clase);
        $vehiculo->marca = strtoupper($marca);
        $vehiculo->linea = strtoupper($modelo);
        $vehiculo->modelo = $ano;
        $vehiculo->capacidad = $capacidad;
        $vehiculo->color = strtoupper($color);
        $vehiculo->cilindraje = strtoupper($cilindraje);
        $vehiculo->vin = $vn;
        $vehiculo->propietario = strtoupper($propietario);
        $vehiculo->cc_propietario = $cc_propietario;
        $vehiculo->empresa_afiliada = strtoupper($empresa_afiliada);
        $vehiculo->observaciones = strtoupper($observaciones);
        $vehiculo->poliza_contractual = strtoupper($poliza_contractual);
        $vehiculo->poliza_extra_contractual = strtoupper($poliza_extra_contractual);
        $vehiculo->poliza_todo_riesgo = strtoupper($poliza_todo_riesgo);
        $vehiculo->tarjeta_propiedad = strtoupper($tarjeta_propiedad);
        $vehiculo->tarjeta_operacion = $tarjeta_operacion;
        $vehiculo->fecha_vigencia_tp = $fecha_vigencia_propiedad;
        $vehiculo->fecha_vigencia_to = $fecha_vigencia_operacion;
        $vehiculo->vigencia_soat = $fecha_vigencia_soat;

        if (Input::hasFile('pdf_tpro')){

          $file_pdf = Input::file('pdf_tpro');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->tarjeta_propiedad_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->tarjeta_propiedad_pdf = 0;
        }

        if (Input::hasFile('pdf_topr')){

          $file_pdf = Input::file('pdf_topr');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->tarjeta_operacion_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->tarjeta_operacion_pdf = 0;
        }

        if (Input::hasFile('pdf_soat')){

          $file_pdf = Input::file('pdf_soat');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->soat_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->soat_pdf = 0;
        }

        $vehiculo->vigencia_tecnomecanica = $vigencia_tecnomecanica;

        if (Input::hasFile('pdf_tecno')){

          $file_pdf = Input::file('pdf_tecno');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->tecnomecanica_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->tecnomecanica_pdf = 0;
        }

        // PÓLIZAS PDF
        if (Input::hasFile('pdf_contra')){

          $file_pdf = Input::file('pdf_contra');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $random = '1234';//colocar número random
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $random.$name_pdf);
          $vehiculo->poliza_contractual_pdf = $random.$name_pdf;

        }else{
          $vehiculo->poliza_contractual_pdf = 0;
        }

        if (Input::hasFile('pdf_extra')){

          $file_pdf = Input::file('pdf_extra');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $random = '1234';//colocar número random
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $random.$name_pdf);
          $vehiculo->poliza_extra_contractual_pdf = $random.$name_pdf;

        }else{
          $vehiculo->poliza_extra_contractual_pdf = 0;
        }
        //PÓLIZAS PDF

        if (Input::hasFile('foto_frontal')){//FOTO FRONTAL

          $file_pdf = Input::file('foto_frontal');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_frontal = $placa.$name_pdf;

        }else{
          $vehiculo->foto_frontal = 0;
        }

        if (Input::hasFile('foto_dorso')){//FOTO DORSO

          $file_pdf = Input::file('foto_dorso');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_dorso = $placa.$name_pdf;

        }else{
          $vehiculo->foto_dorso = 0;
        }

        if (Input::hasFile('foto_derecha')){//FOTO DERECHA

          $file_pdf = Input::file('foto_derecha');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_derecha = $placa.$name_pdf;

        }else{
          $vehiculo->foto_derecha = 0;
        }

        if (Input::hasFile('foto_izquierda')){//FOTO IZQUIERDA

          $file_pdf = Input::file('foto_izquierda');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_izquierda = $placa.$name_pdf;

        }else{
          $vehiculo->foto_izquierda = 0;
        }

        $vehiculo->proveedor_id = $pre->id;

        $vehiculo->save();

        //fin vehiculo

        //INGRESO DE CONDUCTOR
        $nombre_completoc = Input::get('nombre_completoc');
        $departamentoc = Input::get('departamentoc');
        $ciudadc = Input::get('ciudadc');
        $generoc = Input::get('generoc');
        $edadc = Input::get('edadc');
        $ccc = Input::get('ccc');
        $celularc = Input::get('celularc');
        $telefonoc = Input::get('telefonoc');
        $direccionc = Input::get('direccionc');
        $tipodelicenciac = Input::get('tipodelicenciac');
        $fecha_licencia_expedicionc = Input::get('fecha_licencia_expedicionc');
        $fecha_licencia_vigenciac = Input::get('fecha_licencia_vigenciac');
        $grupo_trabajoc = Input::get('grupo_trabajoc');
        $tipo_contratoc = Input::get('tipo_contratoc');
        $cargoc = Input::get('cargoc');
        $experienciac = Input::get('experienciac');
        $accidentesc = Input::get('accidentesc');
        $descripcion_accidentec = Input::get('descripcion_accidentec');
        //$incidentesc = Input::get('incidentesc');
        //$frecuencia_desplazamientoc = Input::get('frecuencia_desplazamientoc');
        //$vehiculo_propio_desplazamientoc = Input::get('vehiculo_propio_desplazamientoc');
        //$trayecto_casa_trabajoc = Input::get('trayecto_casa_trabajoc');
        $fotoc = Input::get('fotoc');
        $pdf_ss = Input::get('pdf_ss');

        $conductor = new IngresoConductor;
        $conductor->nombre_completo = strtoupper($nombre_completoc);
        $conductor->departamento = strtoupper($departamentoc);
        $conductor->ciudad = strtoupper($ciudadc);
        $conductor->genero = strtoupper($generoc);
        $conductor->edad = $edadc;
        $conductor->cc = $ccc;
        $conductor->celular = $celularc;
        $conductor->telefono = $telefonoc;
        $conductor->direccion = strtoupper($direccionc);
        $conductor->tipo_licencia = strtoupper($tipodelicenciac);
        $conductor->fecha_expedicion = $fecha_licencia_expedicionc;
        $conductor->fecha_vigencia = $fecha_licencia_vigenciac;
        $conductor->grupo_trabajo = strtoupper($grupo_trabajoc);
        $conductor->tipo_contrato = strtoupper($tipo_contratoc);
        $conductor->cargo = strtoupper($cargoc);
        $conductor->experiencia = $experienciac;
        $conductor->accidentes_encinco = strtoupper($accidentesc);
        $conductor->descripcion_accidente = strtoupper($descripcion_accidentec);
        //$conductor->incidentes = strtoupper($incidentesc);
        //$conductor->frecuencia_desplazamiento = $frecuencia_desplazamientoc;
        //$conductor->vehiculo_propio = $vehiculo_propio_desplazamientoc;
        //$conductor->trayecto_casa = $trayecto_casa_trabajoc;

        //
        if (Input::hasFile('fotoc')){

          $file = Input::file('fotoc');
          $ubicacion = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/';
          $nombre_imagen = $file->getClientOriginalName();



          $conductor->foto_conductor = $nombre_imagen;

          Image::make($file->getRealPath())->resize(250, 316)->save($ubicacion.$nombre_imagen);

          Image::make($file->getRealPath())
          ->resize(250, 250)->save($ubicacion.'thumbnail'.$nombre_imagen);

        }else{

          $conductor->foto_conductor = 'FALSE';
        }

        //$conductor->foto_conductor = $fotoc;
        //PDF CÉDULA DEL CONDUCTOR
        if(Input::hasFile('pdf_cc_conductor')){

          $file_pdf = Input::file('pdf_cc_conductor');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/cc/';
          $file_pdf->move($ubicacion_pdf, $ccc.$name_pdf);
          $conductor->pdf_cc = $ccc.$name_pdf;

        }else{
          $conductor->pdf_cc = 0;
        }

        //PDF LICENCIA DEL CONDUCCIÓN
        if(Input::hasFile('pdf_licencia_conductor')){

          $file_pdf = Input::file('pdf_licencia_conductor');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/licencias/';
          $file_pdf->move($ubicacion_pdf, $ccc.$name_pdf);
          $conductor->pdf_licencia = $ccc.$name_pdf;

        }else{
          $conductor->pdf_licencia = 0;
        }

        //PDF SEGURIDAD SOCIAL DEL CONDUCTOR
        if(Input::hasFile('pdf_ss')){

          $file_pdf = Input::file('pdf_ss');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/seguridadsocial';
          $file_pdf->move($ubicacion_pdf, $ccc.$name_pdf);
          $conductor->seguridad_social = $ccc.$name_pdf;

        }else{
          $conductor->seguridad_social = 0;
        }

        $conductor->proveedor_id = $pre->id;
        $conductor->save();

        /*ENVÍO DE CORREO AL GERENTE DE OPERACIONES

        //$email = 'gerenteoperaciones@aotour.com.co';
        $email = 'sistemas@aotour.com.co';

        $cc = ['comercial@aotour.com.co', 'gestionintegral@aotour.com.co' ,'aotourdeveloper@gmail.com']; //REGISTRO DE PROVEEDOR
        $data = [
          'id' => 1
        ];
        Mail::send('portalproveedores.emails.registro', $data, function($message) use ($email, $cc){
          $message->from('no-reply@aotour.com.co', 'AUTONET');
          $message->to($email)->subject('PORTAL PROVEEDORES');
          //$message->cc($cc);
        });
        //FIN ENVÍO DE CORREO AL PROVEEDOR*/

        return Response::json([
          'respuesta' => true,
          'conductor' => $conductor,
          'vehiculo' => $vehiculo
        ]);

      }else{
        return Response::json([
          'respuesta'=>false
        ]);
      }
    }

    public function postGuardarc2(){ //GUARDADO DE CONDUCTOR

      $nombre_proveedor = Input::get('nombre_proveedor');
      $cc_proveedor = Input::get('cc_proveedor');
      $digito_verificacion = Input::get('digito_verificacion');
      $email = Input::get('email_proveedor');
      $tipo_empresa = Input::get('tipo_empresa');
      $celular = Input::get('celular');
      $telefono = Input::get('telefono');
      $direccion = Input::get('direccion');
      $departamento = Input::get('departamento');
      $ciudad = Input::get('ciudad');
      $sede = Input::get('sede');

      $tipo_cuenta = Input::get('tipo_cuenta');
      $entidad_bancaria = Input::get('entidad_bancaria');
      $numero_cuenta = Input::get('numero_cuenta');
      $certificacion_proveedor = Input::get('certificacion_proveedor');

      $pre = new IngresoProveedor;
      $pre->razonsocial = strtoupper($nombre_proveedor);
      $pre->nit = $cc_proveedor;
      $pre->digito_verificacion = $digito_verificacion;
      $pre->email = strtoupper($email);
      $pre->tipo_empresa = strtoupper($tipo_empresa);
      $pre->celular = strtoupper($celular);
      $pre->telefono = strtoupper($telefono);
      $pre->direccion = strtoupper($direccion);
      $pre->departamento = strtoupper($departamento);
      $pre->ciudad = strtoupper($ciudad);
      $pre->sede = strtoupper($sede);

      $option = Input::get('option');

      if(intval($option)===1){

        $tipodecuenta = Input::get('tipodecuenta');
        $banco = Input::get('banco');
        $numero = Input::get('numero');
        $certificacion = Input::get('certificacion');

        if (Input::hasFile('certificacion')){

          $file_pdf = Input::file('certificacion');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $numero.$name_pdf);
          $certificacion_proveedor = $numero.$name_pdf;

        }else{
          $certificacion_proveedor = null;
        }

        $pre->tipo_cuenta = $tipodecuenta;
        $pre->entidad_bancaria = $banco;
        $pre->numero_cuenta = $numero;
        $pre->certificacion_proveedor = $certificacion_proveedor;

      }else if(intval($option)===2){

        $nombre = Input::get('nombre');
        $identificaciont = Input::get('identificaciont');
        $tipodecuentat = Input::get('tipodecuentat');
        $bancot = Input::get('bancot');
        $numerot = Input::get('numerot');
        $certificaciont = Input::get('certificaciont');
        $poder = Input::get('poder');

        if (Input::hasFile('certificaciont')){

          $file_pdf = Input::file('certificaciont');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $numero.$name_pdf);
          $certificacion_proveedor = $numero.$name_pdf;

        }else{
          $certificacion_proveedor = null;
        }

        if (Input::hasFile('poder')){

          $file_pdf = Input::file('poder');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $identificaciont.$name_pdf);
          $poder = $identificaciont.$name_pdf;

        }else{
          $poder = null;
        }

        $pre->razonsocial_t = strtoupper($nombre);
        $pre->nit_t = $identificaciont;
        $pre->entidad_bancaria_t = $bancot;
        $pre->tipo_cuenta_t = $tipodecuentat;
        $pre->numero_cuenta_t = $numerot;
        $pre->estado_tercero = 1;
        $pre->certificacion_bancaria_t = $certificacion_proveedor;
        $pre->poder_t = $poder;

      }

      if (Input::hasFile('fotop')){//FOTO PROVEEDOR

        $file_pdf = Input::file('fotop');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
        $placa = 'Foto_proveedor';
        //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
        $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
        $pre->foto_proveedor = $placa.$name_pdf;

      }else{
        $pre->foto_proveedor = 0;
      }

      if(intval(Input::get('tipo'))==1){
        $pre->nombre_contacto = strtoupper(Input::get('contacto_nombrecompleto'));
        $pre->cargo_contacto = strtoupper(Input::get('cargop'));
        $pre->email_contacto = strtoupper(Input::get('email_contacto'));
        $pre->telefono_contacto = Input::get('telefono_contacto');
        $pre->celular_contacto = Input::get('celular_contacto');
        $pre->actividad_economica = strtoupper(Input::get('actividad_economica'));
        $pre->codigo_actividad = strtoupper(Input::get('codigo_actividad'));
        $pre->codigo_ica = strtoupper(Input::get('codigo_ica'));
        $pre->tarifa_ica = strtoupper(Input::get('tarifa_ica'));
        $pre->tipo_servicio = strtoupper(Input::get('tipo_servicio'));
      }

      //DATOS BANCARIOS PROVEEDOR
      $pre->tipo_cuenta = $tipo_cuenta;
      $pre->entidad_bancaria = $entidad_bancaria;
      $pre->numero_cuenta = $numero_cuenta;
      if (Input::hasFile('certificacion_proveedor')){

        $file_pdf = Input::file('certificacion_proveedor');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
        $file_pdf->move($ubicacion_pdf, $cc_proveedor.$name_pdf);
        $pre->certificacion_proveedor = $cc_proveedor.$name_pdf;

      }else{
        $pre->certificacion_proveedor = 0;
      }

      if($pre->save()){

        //INGRESO DE VEHÍCULOS
        $numero_interno = Input::get('numero_interno');
        $tipo_transporte = Input::get('tipo_transporte');
        $placa = Input::get('placa');
        $numero_motor = Input::get('numero_motor');
        $clase = Input::get('clase');
        $marca = Input::get('marca');
        $modelo = Input::get('modelo');
        $ano = Input::get('ano');
        $capacidad = Input::get('capacidad');
        $color = Input::get('color');
        $cilindraje = Input::get('cilindraje');
        $vn = Input::get('vn');
        $propietario = Input::get('propietario');
        $cc_propietario = Input::get('cc_propietario');
        $empresa_afiliada = Input::get('empresa_afiliada');
        if($empresa_afiliada!='AOTOUR'){
          $empresa_afiliada = Input::get('cual_empresa');
        }
        $observaciones = Input::get('observaciones');
        $poliza_contractual = Input::get('poliza_contractual');
        $poliza_extra_contractual = Input::get('poliza_extra_contractual');
        $poliza_todo_riesgo = Input::get('poliza_todo_riesgo');
        $tarjeta_propiedad = Input::get('tarjeta_propiedad');
        $tarjeta_operacion = Input::get('tarjeta_operacion');
        $fecha_vigencia_propiedad = Input::get('fecha_vigencia_propiedad');
        $fecha_vigencia_operacion = Input::get('fecha_vigencia_operacion');
        $fecha_vigencia_soat = Input::get('fecha_vigencia_soat');
        $pdf_tpro = Input::get('pdf_tpro');
        $pdf_topr = Input::get('pdf_topr');
        $pdf_soat = Input::get('pdf_soat');
        $vigencia_tecnomecanica = Input::get('vigencia_tecnomecanica');
        //$vigencia_contractual = Input::get('vigencia_contractual'); ...
        //$vigencia_extracontractual = Input::get('vigencia_extracontractual'); ...
        $pdf_tecno = Input::get('pdf_tecno');

        $vehiculo = new IngresoVehiculo;
        $vehiculo->numero_interno = $numero_interno;
        $vehiculo->tipo_transporte = strtoupper($tipo_transporte);
        $vehiculo->placa = strtoupper($placa);
        $vehiculo->numero_motor = $numero_motor;
        $vehiculo->clase = strtoupper($clase);
        $vehiculo->marca = strtoupper($marca);
        $vehiculo->linea = strtoupper($modelo);
        $vehiculo->modelo = $ano;
        $vehiculo->capacidad = $capacidad;
        $vehiculo->color = strtoupper($color);
        $vehiculo->cilindraje = strtoupper($cilindraje);
        $vehiculo->vin = $vn;
        $vehiculo->propietario = strtoupper($propietario);
        $vehiculo->cc_propietario = $cc_propietario;
        $vehiculo->empresa_afiliada = strtoupper($empresa_afiliada);
        $vehiculo->observaciones = strtoupper($observaciones);
        $vehiculo->poliza_contractual = strtoupper($poliza_contractual);
        $vehiculo->poliza_extra_contractual = strtoupper($poliza_extra_contractual);
        $vehiculo->poliza_todo_riesgo = strtoupper($poliza_todo_riesgo);
        $vehiculo->tarjeta_propiedad = strtoupper($tarjeta_propiedad);
        $vehiculo->tarjeta_operacion = $tarjeta_operacion;
        $vehiculo->fecha_vigencia_tp = $fecha_vigencia_propiedad;
        $vehiculo->fecha_vigencia_to = $fecha_vigencia_operacion;
        $vehiculo->vigencia_soat = $fecha_vigencia_soat;

        if (Input::hasFile('pdf_tpro')){

          $file_pdf = Input::file('pdf_tpro');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->tarjeta_propiedad_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->tarjeta_propiedad_pdf = 0;
        }

        if (Input::hasFile('pdf_topr')){

          $file_pdf = Input::file('pdf_topr');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->tarjeta_operacion_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->tarjeta_operacion_pdf = 0;
        }

        if (Input::hasFile('pdf_soat')){

          $file_pdf = Input::file('pdf_soat');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->soat_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->soat_pdf = 0;
        }

        $vehiculo->vigencia_tecnomecanica = $vigencia_tecnomecanica;

        if (Input::hasFile('pdf_tecno')){

          $file_pdf = Input::file('pdf_tecno');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->tecnomecanica_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->tecnomecanica_pdf = 0;
        }

        /* PÓLIZAS PDF*/
        if (Input::hasFile('pdf_contra')){

          $file_pdf = Input::file('pdf_contra');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $random = '1234';//colocar número random
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $random.$name_pdf);
          $vehiculo->poliza_contractual_pdf = $random.$name_pdf;

        }else{
          $vehiculo->poliza_contractual_pdf = 0;
        }

        if (Input::hasFile('pdf_extra')){

          $file_pdf = Input::file('pdf_extra');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $random = '1234';//colocar número random
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $random.$name_pdf);
          $vehiculo->poliza_extra_contractual_pdf = $random.$name_pdf;

        }else{
          $vehiculo->poliza_extra_contractual_pdf = 0;
        }
        /*PÓLIZAS PDF*/

        if (Input::hasFile('foto_frontal')){//FOTO FRONTAL

          $file_pdf = Input::file('foto_frontal');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_frontal = $placa.$name_pdf;

        }else{
          $vehiculo->foto_frontal = 0;
        }

        if (Input::hasFile('foto_dorso')){//FOTO DORSO

          $file_pdf = Input::file('foto_dorso');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_dorso = $placa.$name_pdf;

        }else{
          $vehiculo->foto_dorso = 0;
        }

        if (Input::hasFile('foto_derecha')){//FOTO DERECHA

          $file_pdf = Input::file('foto_derecha');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_derecha = $placa.$name_pdf;

        }else{
          $vehiculo->foto_derecha = 0;
        }

        if (Input::hasFile('foto_izquierda')){//FOTO IZQUIERDA

          $file_pdf = Input::file('foto_izquierda');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_izquierda = $placa.$name_pdf;

        }else{
          $vehiculo->foto_izquierda = 0;
        }

        $vehiculo->proveedor_id = $pre->id;

        $vehiculo->save();

        //INGRESO DE CONDUCTOR
        $nombre_completoc = Input::get('nombre_completoc');
        $departamentoc = Input::get('departamentoc');
        $ciudadc = Input::get('ciudadc');
        $generoc = Input::get('generoc');
        $edadc = Input::get('edadc');
        $ccc = Input::get('ccc');
        $celularc = Input::get('celularc');
        $telefonoc = Input::get('telefonoc');
        $direccionc = Input::get('direccionc');
        $tipodelicenciac = Input::get('tipodelicenciac');
        $fecha_licencia_expedicionc = Input::get('fecha_licencia_expedicionc');
        $fecha_licencia_vigenciac = Input::get('fecha_licencia_vigenciac');
        $grupo_trabajoc = Input::get('grupo_trabajoc');
        $tipo_contratoc = Input::get('tipo_contratoc');
        $cargoc = Input::get('cargoc');
        $experienciac = Input::get('experienciac');
        $accidentesc = Input::get('accidentesc');
        $descripcion_accidentec = Input::get('descripcion_accidentec');
        //$incidentesc = Input::get('incidentesc');
        //$frecuencia_desplazamientoc = Input::get('frecuencia_desplazamientoc');
        //$vehiculo_propio_desplazamientoc = Input::get('vehiculo_propio_desplazamientoc');
        //$trayecto_casa_trabajoc = Input::get('trayecto_casa_trabajoc');
        $fotoc = Input::get('fotoc');
        $pdf_ss = Input::get('pdf_ss');

        $conductor = new IngresoConductor;
        $conductor->nombre_completo = strtoupper($nombre_completoc);
        $conductor->departamento = strtoupper($departamentoc);
        $conductor->ciudad = strtoupper($ciudadc);
        $conductor->genero = strtoupper($generoc);
        $conductor->edad = $edadc;
        $conductor->cc = $ccc;
        $conductor->celular = $celularc;
        $conductor->telefono = $telefonoc;
        $conductor->direccion = strtoupper($direccionc);
        $conductor->tipo_licencia = strtoupper($tipodelicenciac);
        $conductor->fecha_expedicion = $fecha_licencia_expedicionc;
        $conductor->fecha_vigencia = $fecha_licencia_vigenciac;
        $conductor->grupo_trabajo = strtoupper($grupo_trabajoc);
        $conductor->tipo_contrato = strtoupper($tipo_contratoc);
        $conductor->cargo = strtoupper($cargoc);
        $conductor->experiencia = $experienciac;
        $conductor->accidentes_encinco = strtoupper($accidentesc);
        $conductor->descripcion_accidente = strtoupper($descripcion_accidentec);
        //$conductor->incidentes = strtoupper($incidentesc);
        //$conductor->frecuencia_desplazamiento = $frecuencia_desplazamientoc;
        //$conductor->vehiculo_propio = $vehiculo_propio_desplazamientoc;
        //$conductor->trayecto_casa = $trayecto_casa_trabajoc;

        //
        if (Input::hasFile('fotoc')){

          $file = Input::file('fotoc');
          $ubicacion = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/';
          $nombre_imagen = $file->getClientOriginalName();



          $conductor->foto_conductor = $nombre_imagen;

          Image::make($file->getRealPath())->resize(250, 316)->save($ubicacion.$nombre_imagen);

          Image::make($file->getRealPath())
          ->resize(250, 250)->save($ubicacion.'thumbnail'.$nombre_imagen);

        }else{

          $conductor->foto_conductor = 'FALSE';
        }

        //$conductor->foto_conductor = $fotoc;
        //PDF CÉDULA DEL CONDUCTOR
        if(Input::hasFile('pdf_cc_conductor')){

          $file_pdf = Input::file('pdf_cc_conductor');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/cc/';
          $file_pdf->move($ubicacion_pdf, $ccc.$name_pdf);
          $conductor->pdf_cc = $ccc.$name_pdf;

        }else{
          $conductor->pdf_cc = 0;
        }

        //PDF LICENCIA DEL CONDUCCIÓN
        if(Input::hasFile('pdf_licencia_conductor')){

          $file_pdf = Input::file('pdf_licencia_conductor');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/licencias/';
          $file_pdf->move($ubicacion_pdf, $ccc.$name_pdf);
          $conductor->pdf_licencia = $ccc.$name_pdf;

        }else{
          $conductor->pdf_licencia = 0;
        }

        //PDF SEGURIDAD SOCIAL DEL CONDUCTOR
        if(Input::hasFile('pdf_ss')){

          $file_pdf = Input::file('pdf_ss');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/seguridadsocial';
          $file_pdf->move($ubicacion_pdf, $ccc.$name_pdf);
          $conductor->seguridad_social = $ccc.$name_pdf;

        }else{
          $conductor->seguridad_social = 0;
        }

        $conductor->proveedor_id = $pre->id;
        $conductor->save();

        /*ENVÍO DE CORREO AL GERENTE DE OPERACIONES

        //$email = 'gerenteoperaciones@aotour.com.co';
        $email = 'sistemas@aotour.com.co';

        $cc = ['comercial@aotour.com.co', 'gestionintegral@aotour.com.co' ,'aotourdeveloper@gmail.com']; //REGISTRO DE PROVEEDOR
        $data = [
          'id' => 1
        ];
        Mail::send('portalproveedores.emails.registro', $data, function($message) use ($email, $cc){
          $message->from('no-reply@aotour.com.co', 'AUTONET');
          $message->to($email)->subject('PORTAL PROVEEDORES');
          //$message->cc($cc);
        });
        //FIN ENVÍO DE CORREO AL PROVEEDOR*/
        return Response::json([
          'respuesta' => true,
          'conductor' => $conductor,
          'vehiculo' => $vehiculo
        ]);

      }else{
        return Response::json([
          'respuesta'=>false
        ]);
      }
    }

    public function postGuardarv2(){ //GUARDADO DE VEHÍCULO

      $nombre_proveedor = Input::get('nombre_proveedor');
      $cc_proveedor = Input::get('cc_proveedor');
      $digito_verificacion = Input::get('digito_verificacion');
      $email = Input::get('email_proveedor');
      $tipo_empresa = Input::get('tipo_empresa');
      $celular = Input::get('celular');
      $telefono = Input::get('telefono');
      $direccion = Input::get('direccion');
      $departamento = Input::get('departamento');
      $ciudad = Input::get('ciudad');
      $sede = Input::get('sede');

      $tipo_cuenta = Input::get('tipo_cuenta');
      $entidad_bancaria = Input::get('entidad_bancaria');
      $numero_cuenta = Input::get('numero_cuenta');
      $certificacion_proveedor = Input::get('certificacion_proveedor');

      $pre = new IngresoProveedor;
      $pre->razonsocial = strtoupper($nombre_proveedor);
      $pre->nit = $cc_proveedor;
      $pre->digito_verificacion = $digito_verificacion;
      $pre->email = strtoupper($email);
      $pre->tipo_empresa = strtoupper($tipo_empresa);
      $pre->celular = strtoupper($celular);
      $pre->telefono = strtoupper($telefono);
      $pre->direccion = strtoupper($direccion);
      $pre->departamento = strtoupper($departamento);
      $pre->ciudad = strtoupper($ciudad);
      $pre->sede = strtoupper($sede);

      $option = Input::get('option');

      if(intval($option)===1){

        $tipodecuenta = Input::get('tipodecuenta');
        $banco = Input::get('banco');
        $numero = Input::get('numero');
        $certificacion = Input::get('certificacion');

        if (Input::hasFile('certificacion')){

          $file_pdf = Input::file('certificacion');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $numero.$name_pdf);
          $certificacion_proveedor = $numero.$name_pdf;

        }else{
          $certificacion_proveedor = null;
        }

        $pre->tipo_cuenta = $tipodecuenta;
        $pre->entidad_bancaria = $banco;
        $pre->numero_cuenta = $numero;
        $pre->certificacion_proveedor = $certificacion_proveedor;

      }else if(intval($option)===2){

        $nombre = Input::get('nombre');
        $identificaciont = Input::get('identificaciont');
        $tipodecuentat = Input::get('tipodecuentat');
        $bancot = Input::get('bancot');
        $numerot = Input::get('numerot');
        $certificaciont = Input::get('certificaciont');
        $poder = Input::get('poder');

        if (Input::hasFile('certificaciont')){

          $file_pdf = Input::file('certificaciont');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $numero.$name_pdf);
          $certificacion_proveedor = $numero.$name_pdf;

        }else{
          $certificacion_proveedor = null;
        }

        if (Input::hasFile('poder')){

          $file_pdf = Input::file('poder');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
          $file_pdf->move($ubicacion_pdf, $identificaciont.$name_pdf);
          $poder = $identificaciont.$name_pdf;

        }else{
          $poder = null;
        }

        $pre->razonsocial_t = strtoupper($nombre);
        $pre->nit_t = $identificaciont;
        $pre->entidad_bancaria_t = $bancot;
        $pre->tipo_cuenta_t = $tipodecuentat;
        $pre->numero_cuenta_t = $numerot;
        $pre->estado_tercero = 1;
        $pre->certificacion_bancaria_t = $certificacion_proveedor;
        $pre->poder_t = $poder;

      }

      if (Input::hasFile('fotop')){//FOTO PROVEEDOR

        $file_pdf = Input::file('fotop');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
        $placa = 'Foto_proveedor';
        //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
        $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
        $pre->foto_proveedor = $placa.$name_pdf;

      }else{
        $pre->foto_proveedor = 0;
      }

      if(intval(Input::get('tipo'))==1){
        $pre->nombre_contacto = strtoupper(Input::get('contacto_nombrecompleto'));
        $pre->cargo_contacto = strtoupper(Input::get('cargop'));
        $pre->email_contacto = strtoupper(Input::get('email_contacto'));
        $pre->telefono_contacto = Input::get('telefono_contacto');
        $pre->celular_contacto = Input::get('celular_contacto');
        $pre->actividad_economica = strtoupper(Input::get('actividad_economica'));
        $pre->codigo_actividad = strtoupper(Input::get('codigo_actividad'));
        $pre->codigo_ica = strtoupper(Input::get('codigo_ica'));
        $pre->tarifa_ica = strtoupper(Input::get('tarifa_ica'));
        $pre->tipo_servicio = strtoupper(Input::get('tipo_servicio'));
      }

      //DATOS BANCARIOS PROVEEDOR
      $pre->tipo_cuenta = $tipo_cuenta;
      $pre->entidad_bancaria = $entidad_bancaria;
      $pre->numero_cuenta = $numero_cuenta;
      if (Input::hasFile('certificacion_proveedor')){

        $file_pdf = Input::file('certificacion_proveedor');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/certificaciones/';
        $file_pdf->move($ubicacion_pdf, $cc_proveedor.$name_pdf);
        $pre->certificacion_proveedor = $cc_proveedor.$name_pdf;

      }else{
        $pre->certificacion_proveedor = 0;
      }

      if($pre->save()){

        //INGRESO DE VEHÍCULOS
        $numero_interno = Input::get('numero_interno');
        $tipo_transporte = Input::get('tipo_transporte');
        $placa = Input::get('placa');
        $numero_motor = Input::get('numero_motor');
        $clase = Input::get('clase');
        $marca = Input::get('marca');
        $modelo = Input::get('modelo');
        $ano = Input::get('ano');
        $capacidad = Input::get('capacidad');
        $color = Input::get('color');
        $cilindraje = Input::get('cilindraje');
        $vn = Input::get('vn');
        $propietario = Input::get('propietario');
        $cc_propietario = Input::get('cc_propietario');
        $empresa_afiliada = Input::get('empresa_afiliada');
        if($empresa_afiliada!='AOTOUR'){
          $empresa_afiliada = Input::get('cual_empresa');
        }
        $observaciones = Input::get('observaciones');
        $poliza_contractual = Input::get('poliza_contractual');
        $poliza_extra_contractual = Input::get('poliza_extra_contractual');
        $poliza_todo_riesgo = Input::get('poliza_todo_riesgo');
        $tarjeta_propiedad = Input::get('tarjeta_propiedad');
        $tarjeta_operacion = Input::get('tarjeta_operacion');
        $fecha_vigencia_propiedad = Input::get('fecha_vigencia_propiedad');
        $fecha_vigencia_operacion = Input::get('fecha_vigencia_operacion');
        $fecha_vigencia_soat = Input::get('fecha_vigencia_soat');
        $pdf_tpro = Input::get('pdf_tpro');
        $pdf_topr = Input::get('pdf_topr');
        $pdf_soat = Input::get('pdf_soat');
        $vigencia_tecnomecanica = Input::get('vigencia_tecnomecanica');
        //$vigencia_contractual = Input::get('vigencia_contractual'); ...
        //$vigencia_extracontractual = Input::get('vigencia_extracontractual'); ...
        $pdf_tecno = Input::get('pdf_tecno');

        $vehiculo = new IngresoVehiculo;
        $vehiculo->numero_interno = $numero_interno;
        $vehiculo->tipo_transporte = strtoupper($tipo_transporte);
        $vehiculo->placa = strtoupper($placa);
        $vehiculo->numero_motor = $numero_motor;
        $vehiculo->clase = strtoupper($clase);
        $vehiculo->marca = strtoupper($marca);
        $vehiculo->linea = strtoupper($modelo);
        $vehiculo->modelo = $ano;
        $vehiculo->capacidad = $capacidad;
        $vehiculo->color = strtoupper($color);
        $vehiculo->cilindraje = strtoupper($cilindraje);
        $vehiculo->vin = $vn;
        $vehiculo->propietario = strtoupper($propietario);
        $vehiculo->cc_propietario = $cc_propietario;
        $vehiculo->empresa_afiliada = strtoupper($empresa_afiliada);
        $vehiculo->observaciones = strtoupper($observaciones);
        $vehiculo->poliza_contractual = strtoupper($poliza_contractual);
        $vehiculo->poliza_extra_contractual = strtoupper($poliza_extra_contractual);
        $vehiculo->poliza_todo_riesgo = strtoupper($poliza_todo_riesgo);
        $vehiculo->tarjeta_propiedad = strtoupper($tarjeta_propiedad);
        $vehiculo->tarjeta_operacion = $tarjeta_operacion;
        $vehiculo->fecha_vigencia_tp = $fecha_vigencia_propiedad;
        $vehiculo->fecha_vigencia_to = $fecha_vigencia_operacion;
        $vehiculo->vigencia_soat = $fecha_vigencia_soat;

        if (Input::hasFile('pdf_tpro')){

          $file_pdf = Input::file('pdf_tpro');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->tarjeta_propiedad_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->tarjeta_propiedad_pdf = 0;
        }

        if (Input::hasFile('pdf_topr')){

          $file_pdf = Input::file('pdf_topr');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->tarjeta_operacion_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->tarjeta_operacion_pdf = 0;
        }

        if (Input::hasFile('pdf_soat')){

          $file_pdf = Input::file('pdf_soat');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->soat_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->soat_pdf = 0;
        }

        $vehiculo->vigencia_tecnomecanica = $vigencia_tecnomecanica;

        if (Input::hasFile('pdf_tecno')){

          $file_pdf = Input::file('pdf_tecno');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->tecnomecanica_pdf = $placa.$name_pdf;

        }else{
          $vehiculo->tecnomecanica_pdf = 0;
        }

        /* PÓLIZAS PDF*/
        if (Input::hasFile('pdf_contra')){

          $file_pdf = Input::file('pdf_contra');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $random = '1234';//colocar número random
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $random.$name_pdf);
          $vehiculo->poliza_contractual_pdf = $random.$name_pdf;

        }else{
          $vehiculo->poliza_contractual_pdf = 0;
        }

        if (Input::hasFile('pdf_extra')){

          $file_pdf = Input::file('pdf_extra');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $random = '1234';//colocar número random
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $file_pdf->move($ubicacion_pdf, $random.$name_pdf);
          $vehiculo->poliza_extra_contractual_pdf = $random.$name_pdf;

        }else{
          $vehiculo->poliza_extra_contractual_pdf = 0;
        }
        /*PÓLIZAS PDF*/

        if (Input::hasFile('foto_frontal')){//FOTO FRONTAL

          $file_pdf = Input::file('foto_frontal');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_frontal = $placa.$name_pdf;

        }else{
          $vehiculo->foto_frontal = 0;
        }

        if (Input::hasFile('foto_dorso')){//FOTO DORSO

          $file_pdf = Input::file('foto_dorso');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_dorso = $placa.$name_pdf;

        }else{
          $vehiculo->foto_dorso = 0;
        }

        if (Input::hasFile('foto_derecha')){//FOTO DERECHA

          $file_pdf = Input::file('foto_derecha');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_derecha = $placa.$name_pdf;

        }else{
          $vehiculo->foto_derecha = 0;
        }

        if (Input::hasFile('foto_izquierda')){//FOTO IZQUIERDA

          $file_pdf = Input::file('foto_izquierda');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
          $placa = 'UNO';
          //$ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/';
          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/';
          $file_pdf->move($ubicacion_pdf, $placa.$name_pdf);
          $vehiculo->foto_izquierda = $placa.$name_pdf;

        }else{
          $vehiculo->foto_izquierda = 0;
        }

        $vehiculo->proveedor_id = $pre->id;

        $vehiculo->save();

        //INGRESO DE CONDUCTOR
        $nombre_completoc = Input::get('nombre_completoc');
        $departamentoc = Input::get('departamentoc');
        $ciudadc = Input::get('ciudadc');
        $generoc = Input::get('generoc');
        $edadc = Input::get('edadc');
        $ccc = Input::get('ccc');
        $celularc = Input::get('celularc');
        $telefonoc = Input::get('telefonoc');
        $direccionc = Input::get('direccionc');
        $tipodelicenciac = Input::get('tipodelicenciac');
        $fecha_licencia_expedicionc = Input::get('fecha_licencia_expedicionc');
        $fecha_licencia_vigenciac = Input::get('fecha_licencia_vigenciac');
        $grupo_trabajoc = Input::get('grupo_trabajoc');
        $tipo_contratoc = Input::get('tipo_contratoc');
        $cargoc = Input::get('cargoc');
        $experienciac = Input::get('experienciac');
        $accidentesc = Input::get('accidentesc');
        $descripcion_accidentec = Input::get('descripcion_accidentec');
        //$incidentesc = Input::get('incidentesc');
        //$frecuencia_desplazamientoc = Input::get('frecuencia_desplazamientoc');
        //$vehiculo_propio_desplazamientoc = Input::get('vehiculo_propio_desplazamientoc');
        //$trayecto_casa_trabajoc = Input::get('trayecto_casa_trabajoc');
        $fotoc = Input::get('fotoc');
        $pdf_ss = Input::get('pdf_ss');

        $conductor = new IngresoConductor;
        $conductor->nombre_completo = strtoupper($nombre_completoc);
        $conductor->departamento = strtoupper($departamentoc);
        $conductor->ciudad = strtoupper($ciudadc);
        $conductor->genero = strtoupper($generoc);
        $conductor->edad = $edadc;
        $conductor->cc = $ccc;
        $conductor->celular = $celularc;
        $conductor->telefono = $telefonoc;
        $conductor->direccion = strtoupper($direccionc);
        $conductor->tipo_licencia = strtoupper($tipodelicenciac);
        $conductor->fecha_expedicion = $fecha_licencia_expedicionc;
        $conductor->fecha_vigencia = $fecha_licencia_vigenciac;
        $conductor->grupo_trabajo = strtoupper($grupo_trabajoc);
        $conductor->tipo_contrato = strtoupper($tipo_contratoc);
        $conductor->cargo = strtoupper($cargoc);
        $conductor->experiencia = $experienciac;
        $conductor->accidentes_encinco = strtoupper($accidentesc);
        $conductor->descripcion_accidente = strtoupper($descripcion_accidentec);
        //$conductor->incidentes = strtoupper($incidentesc);
        //$conductor->frecuencia_desplazamiento = $frecuencia_desplazamientoc;
        //$conductor->vehiculo_propio = $vehiculo_propio_desplazamientoc;
        //$conductor->trayecto_casa = $trayecto_casa_trabajoc;

        //
        if (Input::hasFile('fotoc')){

          $file = Input::file('fotoc');
          $ubicacion = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/';
          $nombre_imagen = $file->getClientOriginalName();



          $conductor->foto_conductor = $nombre_imagen;

          Image::make($file->getRealPath())->resize(250, 316)->save($ubicacion.$nombre_imagen);

          Image::make($file->getRealPath())
          ->resize(250, 250)->save($ubicacion.'thumbnail'.$nombre_imagen);

        }else{

          $conductor->foto_conductor = 'FALSE';
        }

        //$conductor->foto_conductor = $fotoc;
        //PDF CÉDULA DEL CONDUCTOR
        if(Input::hasFile('pdf_cc_conductor')){

          $file_pdf = Input::file('pdf_cc_conductor');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/cc/';
          $file_pdf->move($ubicacion_pdf, $ccc.$name_pdf);
          $conductor->pdf_cc = $ccc.$name_pdf;

        }else{
          $conductor->pdf_cc = 0;
        }

        //PDF LICENCIA DEL CONDUCCIÓN
        if(Input::hasFile('pdf_licencia_conductor')){

          $file_pdf = Input::file('pdf_licencia_conductor');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/licencias/';
          $file_pdf->move($ubicacion_pdf, $ccc.$name_pdf);
          $conductor->pdf_licencia = $ccc.$name_pdf;

        }else{
          $conductor->pdf_licencia = 0;
        }

        //PDF SEGURIDAD SOCIAL DEL CONDUCTOR
        if(Input::hasFile('pdf_ss')){

          $file_pdf = Input::file('pdf_ss');
          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

          $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/seguridadsocial';
          $file_pdf->move($ubicacion_pdf, $ccc.$name_pdf);
          $conductor->seguridad_social = $ccc.$name_pdf;

        }else{
          $conductor->seguridad_social = 0;
        }

        $conductor->proveedor_id = $pre->id;
        $conductor->save();

        /*ENVÍO DE CORREO AL GERENTE DE OPERACIONES

        //$email = 'gerenteoperaciones@aotour.com.co';
        $email = 'sistemas@aotour.com.co';

        $cc = ['comercial@aotour.com.co', 'gestionintegral@aotour.com.co' ,'aotourdeveloper@gmail.com']; //REGISTRO DE PROVEEDOR
        $data = [
          'id' => 1
        ];
        Mail::send('portalproveedores.emails.registro', $data, function($message) use ($email, $cc){
          $message->from('no-reply@aotour.com.co', 'AUTONET');
          $message->to($email)->subject('PORTAL PROVEEDORES');
          //$message->cc($cc);
        });
        //FIN ENVÍO DE CORREO AL PROVEEDOR*/
        return Response::json([
          'respuesta' => true,
          'conductor' => $conductor,
          'vehiculo' => $vehiculo
        ]);

      }else{
        return Response::json([
          'respuesta'=>false
        ]);
      }
    }

    public function postRegistrarproveedor(){

        if(Request::ajax()){

          $nombres = Input::get('nombre');
          $cc = Input::get('cc');
          $tipo_empresa = Input::get('tipo_empresa');
          $celular = Input::get('celular');
          $telefono = Input::get('telefono');
          $email = Input::get('email');
          $direccion = Input::get('direccion');
          $departamento = Input::get('departamento');
          $ciudad = Input::get('ciudad');
          $sede = Input::get('sede');
          $tipo_cuenta = Input::get('tipo_cuenta');
          $entidad_bancaria = Input::get('entidad_bancaria');
          $numero_cuenta = Input::get('numero_cuenta');
          $certificacion_proveedor = Input::get('certificacion_proveedor');

          $consulta = Proveedor::where('nit',$cc)->first();
          if($consulta!=null){
            return Response::json([
              'respuesta'=>'existe'
            ]);
          }else{

            $proveedor = new IngresoProveedor;
            $proveedor->razonsocial = strtoupper($nombres);
            $proveedor->nit = $cc;
            $proveedor->codigoverificacion = 0;
            $proveedor->tipoempresa = strtoupper($tipo_empresa);
            $proveedor->celular = $celular;
            $proveedor->telefono = $telefono;
            $proveedor->email = strtoupper($email);
            $proveedor->direccion = strtoupper($direccion);
            $proveedor->departamento = strtoupper($departamento);
            $proveedor->ciudad = strtoupper($ciudad);
            $proveedor->localidad = strtoupper($sede);
            $proveedor->tipo_cuenta = strtoupper($tipo_cuenta);
            $proveedor->entidad_bancaria = strtoupper($entidad_bancaria);
            $proveedor->numero_cuenta = $numero_cuenta;
            $proveedor->estado = 0;
            //$proveedor->certificacion_bancaria = $certificacion_proveedor;

            if(Input::hasFile('certificacion_proveedor')){
              $file = Input::file('certificacion_proveedor');
              $name_img = str_replace(' ', '', $file->getClientOriginalName());

              $ubicacion_servicios = 'biblioteca_imagenes/proveedores/documentos/certificacion/';
              $file->move($ubicacion_servicios, $cc.'_'.$name_img);
              $proveedor->certificacion_bancaria = $cc.'_'.$name_img;
            }

            if($proveedor->save()){
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
    }//SG

    //CONDUCTORES
    public function postDocumentoincorrecto(){

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

        if(Request::ajax()){
          $id = Input::get('id');
          $option = Input::get('option');

          $conductor = IngresoConductor::find($id);
          if($conductor){
            if($option=='cedula'){
              $conductor->autorizado_cc = 2;
            }else if($option=='licencia'){
              $conductor->autorizado_licencia = 2;
            }else if($option=='ss'){
              $conductor->autorizado_seguridad_social = 2;
            }

            $conductor->save();
            return Response::json([
              'respuesta' => true
            ]);

          }else{

            return Response::json([
              'respuesta' => 'noexiste'
            ]);
          }
        }
      }
    }

    public function postDocumentocorrecto(){

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

        if(Request::ajax()){

          $id = Input::get('id');
          $option = Input::get('option');

          $conductor = IngresoConductor::find($id);

          if($conductor){

            if($option==='ss'){ //APROBACIÓN DE SEGURIDAD SOCIAL

              $fecha_inicial = Input::get('fecha_inicial');
              $fecha_final = Input::get('fecha_final');
              $numero_planilla = Input::get('numero_planilla');

              $conductor->autorizado_seguridad_social = 1;
              $conductor->fechainicial_seguridad_social = $fecha_inicial;
              $conductor->fechafinal_seguridad_social = $fecha_final;
              $conductor->numero_planilla = $numero_planilla;

            }else{//CC O LICENCIA
              if($option=='licencia'){
                $conductor->autorizado_licencia = 1;
              }else{
                $conductor->autorizado_cc = 1;
              }
            }

            if($conductor->save()){
              return Response::json([
                'respuesta' => true
              ]);
            }else{
              return Response::json([
                'respuesta' => false
              ]);
            }

          }else{

            return Response::json([
              'respuesta' => 'noexiste'
            ]);
          }
        }
      }
    }

    //VEHÍCULOS
    public function postDocumentoincorrectov(){

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

        if(Request::ajax()){
          $id = Input::get('id');
          $option = Input::get('option');

          $vehiculo = IngresoVehiculo::find($id);
          if($vehiculo){
            if($option=='tecnomecanica'){
              $vehiculo->autorizado_tecnomecanica = 2;
            }else if($option=='soat'){
              $vehiculo->autorizado_soat = 2;
            }else if($option=='tp'){
              $vehiculo->autorizado_tp = 2;
            }else if($option=='to'){
              $vehiculo->autorizado_to = 2;
            }else if($option=='pc'){
              $vehiculo->autorizado_pc = 2;
            }else if($option=='pec'){
              $vehiculo->autorizado_pec = 2;
            }

            $vehiculo->save();
            return Response::json([
              'respuesta' => true
            ]);

          }else{

            return Response::json([
              'respuesta' => 'noexiste'
            ]);
          }
        }
      }
    }

    public function postDocumentocorrectov(){

      if(!Sentry::check()){
        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
      }else{

        if(Request::ajax()){
          $id = Input::get('id');
          $option = Input::get('option');

          $vehiculo = IngresoVehiculo::find($id);
          if($vehiculo){
            if($option=='tecnomecanica'){
              $vehiculo->autorizado_tecnomecanica = 1;
            }else if($option=='soat'){
              $vehiculo->autorizado_soat = 1;
            }else if($option=='tp'){
              $vehiculo->autorizado_tp = 1;
            }else if($option=='to'){
              $vehiculo->autorizado_to = 1;
            }else if($option=='pc'){
              $vehiculo->autorizado_pc = 1;
            }else if($option=='pec'){
              $vehiculo->autorizado_pec = 1;
            }

            $vehiculo->save();
            return Response::json([
              'respuesta' => true
            ]);

          }else{

            return Response::json([
              'respuesta' => 'noexiste'
            ]);
          }
        }
      }
    }

    public function getCuentadecobro(){

      $id_rol = Sentry::getUser()->id_rol;
      $id_proveedor = Sentry::getUser()->proveedor_id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $departamentos = DB::table('departamento')->get();
      $centrosdecosto = Centrodecosto::Internos()->whereIn('id',[19,287])->orderBy('razonsocial')->get();
      $pasajeros = Pasajero::where('cedula', 12)->orderBy('nombres')->get();

      //Consulta de disponibilidad
      $disponibilidad = DB::table('datos_pago')->where('id',1)->first();

      if($disponibilidad!=null){

        $clientes = "SELECT DISTINCT centrodecosto_id FROM servicios left join facturacion on facturacion.servicio_id = servicios.id WHERE servicios.fecha_servicio BETWEEN '".$disponibilidad->fecha_inicio."' AND '".$disponibilidad->fecha_fin."' AND servicios.proveedor_id = '".$id_proveedor."' and facturacion.liquidado is not null"; //CAMBIAR ESTADO A FACURADO

          $clientes = DB::select($clientes);
          $objArray = [];
          $objArray2 = [];
          if($clientes){
            foreach ($clientes as $cliente) {

              $rs = DB::table('centrosdecosto')
              ->where('id',$cliente->centrodecosto_id)
              ->pluck('razonsocial');


              $array = $cliente->centrodecosto_id;
              array_push($objArray, $array);
              array_push($objArray2, $rs);
            }
          }
      }

      return View::make('portalproveedores.cuentadecobro.home')
        ->with('centrosdecosto',$centrosdecosto)
        ->with('pasajeros',$pasajeros)
        ->with('departamentos',$departamentos)
        ->with('objArray',$objArray)
        ->with('objArray2',$objArray2)
        ->with('o',$o=1);

    }

    public function getCliente($id){

      $id_rol = Sentry::getUser()->id_rol;
      $id_proveedor = Sentry::getUser()->proveedor_id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $nombre_cliente = DB::table('centrosdecosto')
      ->where('id',$id)
      ->pluck('razonsocial');

      $rutas_programadas = DB::table('servicios')
      ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
      ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
      ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
      ->join('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
      ->join('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
      ->select('rutas.nombre_ruta','rutas.codigo_ruta',
          'servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.id',
          'servicios.fecha_servicio', 'servicios.fecha_orden', 'servicios.hora_servicio','servicios.centrodecosto_id','servicios.ciudad','servicios.ruta_id', 'servicios.ruta',
          'proveedores.razonsocial',
          'vehiculos.placa','vehiculos.marca','vehiculos.clase',
          'facturacion.numero_planilla','facturacion.observacion','facturacion.facturado','facturacion.cambios_servicio',
          'facturacion.cod_centro_costo', 'facturacion.total_pagado',
          'conductores.nombre_completo', 'subcentrosdecosto.nombresubcentro')
      ->where('servicios.centrodecosto_id',$id)
      ->where('proveedores.id',$id_proveedor)
      ->whereNotNull('facturacion.liquidado')
      //->where('servicios.subcentrodecosto_id',$subcentrodecosto_id)
      ->whereBetween('fecha_servicio',['20210401','20210422'])
      ->whereNull('pendiente_autori_eliminacion')
      //->where('pasajeros',$pax)
      ->get();

      return View::make('portalproveedores.cuentadecobro.cliente')
      ->with('nombre_cliente',$nombre_cliente)
      ->with('rutas_programadas',$rutas_programadas)
      ->with('permisos',$permisos)
      ->with('centrodecosto',$id);
    }
/*
    public function getMisservicios(){
      $id=19;
      $id_rol = Sentry::getUser()->id_rol;
      $id_proveedor = Sentry::getUser()->proveedor_id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $nombre_cliente = DB::table('centrosdecosto')
      ->where('id',$id)
      ->pluck('razonsocial');

      $rutas_programadas = DB::table('servicios')
      ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
      ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
      ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
      ->join('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
      ->join('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->join('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
      ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
      ->select('rutas.nombre_ruta','rutas.codigo_ruta',
          'servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.id',
          'servicios.fecha_servicio', 'servicios.fecha_orden', 'servicios.hora_servicio','servicios.centrodecosto_id','servicios.ciudad','servicios.ruta_id', 'servicios.ruta',
          'proveedores.razonsocial',
          'vehiculos.placa','vehiculos.marca','vehiculos.clase',
          'facturacion.numero_planilla','facturacion.observacion','facturacion.facturado','facturacion.cambios_servicio',
          'facturacion.cod_centro_costo', 'facturacion.total_pagado',
          'conductores.nombre_completo', 'subcentrosdecosto.nombresubcentro', 'centrosdecosto.razonsocial as razoncentro')
      //->where('servicios.centrodecosto_id',$id)
      ->where('proveedores.id',$id_proveedor)
      ->whereNotNull('facturacion.liquidado')
      //->where('servicios.subcentrodecosto_id',$subcentrodecosto_id)
      ->whereBetween('fecha_servicio',['20210401','20210422'])
      ->whereNull('pendiente_autori_eliminacion')
      //->where('pasajeros',$pax)
      ->get();

      return View::make('portalproveedores.test')
      ->with('nombre_cliente',$nombre_cliente)
      ->with('rutas_programadas',$rutas_programadas)
      ->with('permisos',$permisos)
      ->with('centrodecosto',$id);
    }

    public function getSolicitudactual(){
      $id=19;
      $id_rol = Sentry::getUser()->id_rol;
      $id_proveedor = Sentry::getUser()->proveedor_id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $nombre_cliente = DB::table('centrosdecosto')
      ->where('id',$id)
      ->pluck('razonsocial');

      $rutas_programadas = DB::table('servicios')
      ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
      ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
      ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
      ->join('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
      ->join('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->join('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
      ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
      ->select('rutas.nombre_ruta','rutas.codigo_ruta',
          'servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.id',
          'servicios.fecha_servicio', 'servicios.fecha_orden', 'servicios.hora_servicio','servicios.centrodecosto_id','servicios.ciudad','servicios.ruta_id', 'servicios.ruta',
          'proveedores.razonsocial',
          'vehiculos.placa','vehiculos.marca','vehiculos.clase',
          'facturacion.numero_planilla','facturacion.observacion','facturacion.facturado','facturacion.cambios_servicio',
          'facturacion.cod_centro_costo', 'facturacion.total_pagado',
          'conductores.nombre_completo', 'subcentrosdecosto.nombresubcentro', 'centrosdecosto.razonsocial as razoncentro')
      //->where('servicios.centrodecosto_id',$id)
      ->where('proveedores.id',$id_proveedor)
      ->whereNotNull('facturacion.liquidado')
      //->where('servicios.subcentrodecosto_id',$subcentrodecosto_id)
      ->whereBetween('fecha_servicio',['20210401','20210422'])
      ->whereNull('pendiente_autori_eliminacion')
      //->where('pasajeros',$pax)
      ->get();

      $control = DB::table('listado_cuentas')->where('proveedor',$id_proveedor)->first();

      return View::make('portalproveedores.solicitud_actual')
      ->with('control',$control)
      ->with('nombre_cliente',$nombre_cliente)
      ->with('rutas_programadas',$rutas_programadas)
      ->with('permisos',$permisos)
      ->with('centrodecosto',$id);
    }

    public function getListadocuentas(){
      $id=19;
      $id_rol = Sentry::getUser()->id_rol;
      $id_proveedor = Sentry::getUser()->proveedor_id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $nombre_cliente = DB::table('centrosdecosto')
      ->where('id',$id)
      ->pluck('razonsocial');

      $rutas_programadas = DB::table('servicios')
      ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
      ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
      ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
      ->join('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
      ->join('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->join('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
      ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
      ->select('rutas.nombre_ruta','rutas.codigo_ruta',
          'servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.id',
          'servicios.fecha_servicio', 'servicios.fecha_orden', 'servicios.hora_servicio','servicios.centrodecosto_id','servicios.ciudad','servicios.ruta_id', 'servicios.ruta',
          'proveedores.razonsocial',
          'vehiculos.placa','vehiculos.marca','vehiculos.clase',
          'facturacion.numero_planilla','facturacion.observacion','facturacion.facturado','facturacion.cambios_servicio',
          'facturacion.cod_centro_costo', 'facturacion.total_pagado',
          'conductores.nombre_completo', 'subcentrosdecosto.nombresubcentro', 'centrosdecosto.razonsocial as razoncentro')
      //->where('servicios.centrodecosto_id',$id)
      ->where('proveedores.id',$id_proveedor)
      ->whereNotNull('facturacion.liquidado')
      //->where('servicios.subcentrodecosto_id',$subcentrodecosto_id)
      ->whereBetween('fecha_servicio',['20210401','20210422'])
      ->whereNull('pendiente_autori_eliminacion')
      //->where('pasajeros',$pax)
      ->get();

      //nuevo
      $rutas_programadas = DB::table('listado_cuentas')
      ->leftJoin('proveedores', 'proveedores.id', '=', 'listado_cuentas.proveedor')
      ->select('listado_cuentas.*', 'proveedores.razonsocial')
      ->get();

      return View::make('portalproveedores.listado_cuentas')
      ->with('nombre_cliente',$nombre_cliente)
      ->with('rutas_programadas',$rutas_programadas)
      ->with('permisos',$permisos)
      ->with('centrodecosto',$id);
    }

    public function getDetalles1($id){
      //$id=19;
      $id_rol = Sentry::getUser()->id_rol;
      $id_proveedor = Sentry::getUser()->proveedor_id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $nombre_cliente = DB::table('centrosdecosto')
      ->where('id',$id)
      ->pluck('razonsocial');

      $rutas_programadas = DB::table('servicios')
      ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
      ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
      ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
      ->join('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
      ->join('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->join('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
      ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
      ->select('rutas.nombre_ruta','rutas.codigo_ruta',
          'servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.id',
          'servicios.fecha_servicio', 'servicios.fecha_orden', 'servicios.hora_servicio','servicios.centrodecosto_id','servicios.ciudad','servicios.ruta_id', 'servicios.ruta',
          'proveedores.razonsocial',
          'vehiculos.placa','vehiculos.marca','vehiculos.clase',
          'facturacion.numero_planilla','facturacion.observacion','facturacion.facturado','facturacion.cambios_servicio',
          'facturacion.cod_centro_costo', 'facturacion.total_pagado',
          'conductores.nombre_completo', 'subcentrosdecosto.nombresubcentro', 'centrosdecosto.razonsocial as razoncentro')
      //->where('servicios.centrodecosto_id',$id)
      ->where('proveedores.id',$id_proveedor)
      ->whereNotNull('facturacion.liquidado')
      //->where('servicios.subcentrodecosto_id',$subcentrodecosto_id)
      ->whereBetween('fecha_servicio',['20210401','20210422'])
      ->whereNull('pendiente_autori_eliminacion')
      //->where('pasajeros',$pax)
      ->get();

      //nuevo
      $rutas_programadas = DB::table('listado_cuentas')
      ->leftJoin('proveedores', 'proveedores.id', '=', 'listado_cuentas.proveedor')
      ->select('listado_cuentas.*', 'proveedores.razonsocial')
      ->get();

      return View::make('portalproveedores.listado_cuentas')
      ->with('nombre_cliente',$nombre_cliente)
      ->with('rutas_programadas',$rutas_programadas)
      ->with('permisos',$permisos)
      ->with('centrodecosto',$id);
    }


*/
    public function getDescargarqremail($code){


    $data = $code;
    $pasajero = DB::table('pasajeros')->where('cedula',$data)->get();
    $cliente = DB::table('pasajeros')->where('cedula',$data)->pluck('centrodecosto_id');
    $centro = DB::table('centrosdecosto')->where('id',$cliente)->pluck('razonsocial');

    $html = View::make('portalusuarios.qrcode3')->with([
      'data' => $data,
      'dato' => $pasajero,
      'centro' => $centro,
    ]);

    return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('CODE'.$data);

  }

    public function getConfirmarcelular($code){

      $userp = Pasajero::where('codigo_confirmacion', $code)->first();

      if($userp){
        if($userp->estado_confirmacion==null){
          if($userp->estado_confirmacion!=1){
            $pasa = DB::table('pasajeros')->where('codigo_confirmacion',$code)->update(['estado_confirmacion'=>1]);
          }

          return View::make('servicios.pasajeros.confirmado');

        }else{
          return View::make('servicios.pasajeros.caducado');
        }
      }else{
        $user = Pregistro::where('codigo_confirmacion', $code)->first();
        $code_tel = $user->codigo_telefono;
        $Mensaje = "AOTOUR le informa que su codigo de confirmacion es ".$code_tel."";
        $Destino = trim($user->telefono);

        $post['to'] = array('57'.$Destino);
        $post['text'] = "AOTOUR le informa que su codigo de confirmacion es ".$code_tel."";
        $post['from'] = "msg";
        $user ="Aotour";
        $password = 'Tour20+';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sms.puntodigitalip.com/Api/rest/message");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($ch, CURLOPT_HTTPHEADER,
        array(
        "Accept: application/json",
        "Authorization: Basic ".base64_encode($user.":".$password)));
        $result = curl_exec ($ch);

        return View::make('servicios.pasajeros.confirmarcelular')
        ->with('Mensaje', $Mensaje)
        ->with('Destino', $Destino);

      }

    }

    public function getPhp(){
      echo phpinfo();
    }

    public function postGuardarpasajero(){
      $reglas = [
        'codigo' =>'required|numeric'
      ];
      $mensaje = [
        'codigo.required' => 'Debe ingresar el código de confirmación enviado a su celular',
      ];
      $validador = Validator::make(Input::all(), $reglas, $mensaje);
      if($validador->fails()){
         return Response::json([
          'response' => false,
          'errors' => $validador->messages()
        ]);
       }else{
          $user = Pregistro::where('codigo_telefono', Input::get('codigo'))->first();

          if(! $user){
            return Response::json([
              'respuesta' => false
            ]);
          }else{
            $qr_code = DNS2D::getBarcodePNG($user->cedula, "QRCODE", 10, 10,array(1,1,1), true);
            Image::make($qr_code)->save('biblioteca_imagenes/codigosqr/'.$user->cedula.'.png');
            $data = [
              'cedula' => $user->cedula,
              'nombres'=> $user->nombres,
              'apellidos'=> $user->apellidos,
              'username'=> $user->correo,
            ];
            $correo = $user->correo;
            Mail::send('servicios.pasajeros.qrcode', $data, function($message) use ($correo){

              $message->from('no-reply@aotour.com.co', 'AOTOUR');
              $message->to($correo)->subject('Código QR');
              $message->cc('aotourdeveloper@gmail.com');

            });
            $pasa = DB::table('pre_registro')->where('cedula',$user->cedula)->update(['estado'=>1]);

            $pasajeros = new Pasajero();
            $pasajeros->confirmado = 1;
            $pasajeros->nombres = $user->nombres;
            $pasajeros->apellidos = $user->apellidos;
            $pasajeros->id_employer = $user->id_employer;
            $pasajeros->cedula = $user->cedula;
            $pasajeros->telefono = $user->telefono;
            $pasajeros->direccion = $user->direccion;
            $pasajeros->barrio = $user->barrio;
            if($user->localidad!=null){
              $pasajeros->localidad = $user->localidad;
            }
            $pasajeros->municipio = $user->municipio;
            $pasajeros->departamento = $user->departamento;
            $pasajeros->correo = $user->correo;
            $pasajeros->area = $user->area;
            $pasajeros->sub_area = $user->sub_area;
            $pasajeros->eps = $user->eps;
            $pasajeros->arl = $user->arl;
            $pasajeros->centrodecosto_id = $user->centrodecosto_id;
            $pasajeros->codigo_telefono = $user->codigo_telefono;
            $pasajeros->codigo_confirmacion = $user->codigo_confirmacion;
            $pasajeros->save();

            //Guardar USER
            Config::set('cartalyst/sentry::users.login_attribute', 'username');
              $user = Sentry::createUser([
                  'username'     => $user->correo,
                  'password'  => $user->cedula,
                  'activated' => true,
                  'first_name'=> $user->nombres,
                  'last_name'=> $user->apellidos,
                  'tipo_usuario' => 8,
                  'id_rol' => 35,
                  'usuario_portal' => 1,
                  'identificacion' => $user->cedula,
                  'centrodecosto_id' => $user->centrodecosto_id,
              ]);
            //Fin Guradar USER
            return Response::json([
              'response' => true
            ]);

          }
       }
    }

    /*GESTIÓN DE FUNCIONES START*/
    public function getDocumentacionvehiculos(){

      if (Sentry::check()) {
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = 'on';
      }else{
        $id_rol = null;
        $permisos = null;
        $permisos = null;
        $ver = null;
      }

      //PENDIENTE EL CÓDIGO DE LA TABLA ROLES

      if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on' ) {
        return View::make('admin.permisos');
      }else {

        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $proveedor_id = Sentry::getUser()->proveedor_id;

        $vehiculo = DB::table('vehiculos')
        ->where('proveedores_id',$proveedor_id)
        ->whereNull('bloqueado')
        ->whereNull('bloqueado_total')
        ->first();

        $vehiculoss = DB::table('vehiculos')
        ->where('proveedores_id',$proveedor_id)
        ->whereNull('bloqueado')
        ->whereNull('bloqueado_total')
        ->get();

        //PRUEBA COMO ESTÁ EN EL FUEC CONTROLLER

        if($vehiculo!=null){
          $value = 1;
          $administracion = Administracion::where('vehiculo_id', $vehiculo->id)
          ->where('ano',date('Y'))
          ->where('mes',date('m'))
          ->pluck('pago');
          $placa = $vehiculo->id;
        }else{
          $administracion = null;
          $value = 0;
          $placa = null;
        }



        $date = date('Y-m-d');

        $vehiculos_array = [];
        $i = 0;

        foreach ($vehiculoss as $vehiculo) {

          $contadora = 0;

          $fecha_1 = strtotime ('-7 day', strtotime($vehiculo->fecha_vigencia_operacion));
          $fecha_1 = date ('Y-m-d' , $fecha_1);
          if(($date>=$fecha_1 and $date<=$vehiculo->fecha_vigencia_operacion) or ($vehiculo->fecha_vigencia_operacion<$date)){
            $contadora++;
          }

          $fecha_2 = strtotime ('-7 day', strtotime($vehiculo->fecha_vigencia_soat));
          $fecha_2 = date ('Y-m-d' , $fecha_2);
          if(($date>=$fecha_2 and $date<=$vehiculo->fecha_vigencia_soat) or ($vehiculo->fecha_vigencia_soat<$date)){
            $contadora++;
          }

          $fecha_3 = strtotime ('-7 day', strtotime($vehiculo->fecha_vigencia_tecnomecanica));
          $fecha_3 = date ('Y-m-d' , $fecha_3);
          if(($date>=$fecha_3 and $date<=$vehiculo->fecha_vigencia_tecnomecanica) or ($vehiculo->fecha_vigencia_tecnomecanica<$date)){
            $contadora++;
          }

          $fecha_4 = strtotime ('-7 day', strtotime($vehiculo->mantenimiento_preventivo));
          $fecha_4 = date ('Y-m-d' , $fecha_4);
          if(($date>=$fecha_4 and $date<=$vehiculo->mantenimiento_preventivo) or ($vehiculo->mantenimiento_preventivo<$date)){
            $contadora++;
          }

          $fecha_5 = strtotime ('-7 day', strtotime($vehiculo->poliza_contractual));
          $fecha_5 = date ('Y-m-d' , $fecha_5);
          if(($date>=$fecha_5 and $date<=$vehiculo->poliza_contractual) or ($vehiculo->poliza_contractual<$date)){
            $contadora++;
          }

          $fecha_6 = strtotime ('-7 day', strtotime($vehiculo->poliza_extracontractual));
          $fecha_6 = date ('Y-m-d' , $fecha_6);
          if(($date>=$fecha_6 and $date<=$vehiculo->poliza_extracontractual) or ($vehiculo->poliza_extracontractual<$date)){
            $contadora++;
          }

          $vehiculos_array[$i] = $contadora;

          $i++;
        }

        /*$administracion = Administracion::where('vehiculo_id', Input::get('id'))
        ->where('ano',date('Y'))
        ->where('mes',date('m'))
        ->pluck('pago');*/

        //FIN PRUEBA COMO ESTÁ EN EL FUEC CONTROLLER

        return View::make('portalproveedores.vehiculos.home')
        ->with('permisos',$permisos)
        ->with('administracion',$administracion)
        ->with('vehiculos',$vehiculo)
        ->with('administracion',$administracion)
        ->with('placa',$placa)
        ->with('count',$vehiculos_array)
        ->with('vehiculoss',$vehiculoss);

      }

    }

    public function getDocumentaciondevehiculo($id){

      $id = Crypt::decryptString($id);

      if (Sentry::check()) {
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = 'on';
      }else{
        $id_rol = null;
        $permisos = null;
        $permisos = null;
        $ver = null;
      }

      //PENDIENTE EL CÓDIGO DE LA TABLA ROLES

      if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on' ) {
        return View::make('admin.permisos');
      }else {

        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $proveedor_id = Sentry::getUser()->proveedor_id;

        $vehiculo = DB::table('vehiculos')
        ->where('placa',$id)
        ->first();

        if($vehiculo->proveedores_id!=$proveedor_id){
          return View::make('admin.permisos');
        }else{

          $vehiculoss = DB::table('vehiculos')
          ->where('proveedores_id',$proveedor_id)
          ->whereNull('bloqueado')
          ->whereNull('bloqueado_total')
          ->get();

          //TEST
          $date = date('Y-m-d');

          $vehiculos_array = [];
          $i = 0;

          foreach ($vehiculoss as $veh) {

            $contadora = 0;

            $fecha_1 = strtotime ('-7 day', strtotime($veh->fecha_vigencia_operacion));
            $fecha_1 = date ('Y-m-d' , $fecha_1);
            if(($date>=$fecha_1 and $date<=$veh->fecha_vigencia_operacion) or ($veh->fecha_vigencia_operacion<$date)){
              $contadora++;
            }

            $fecha_2 = strtotime ('-7 day', strtotime($veh->fecha_vigencia_soat));
            $fecha_2 = date ('Y-m-d' , $fecha_2);
            if(($date>=$fecha_2 and $date<=$veh->fecha_vigencia_soat) or ($veh->fecha_vigencia_soat<$date)){
              $contadora++;
            }

            $fecha_3 = strtotime ('-7 day', strtotime($veh->fecha_vigencia_tecnomecanica));
            $fecha_3 = date ('Y-m-d' , $fecha_3);
            if(($date>=$fecha_3 and $date<=$veh->fecha_vigencia_tecnomecanica) or ($veh->fecha_vigencia_tecnomecanica<$date)){
              $contadora++;
            }

            $fecha_4 = strtotime ('-7 day', strtotime($veh->mantenimiento_preventivo));
            $fecha_4 = date ('Y-m-d' , $fecha_4);
            if(($date>=$fecha_4 and $date<=$veh->mantenimiento_preventivo) or ($veh->mantenimiento_preventivo<$date)){
              $contadora++;
            }

            $fecha_5 = strtotime ('-7 day', strtotime($veh->poliza_contractual));
            $fecha_5 = date ('Y-m-d' , $fecha_5);
            if(($date>=$fecha_5 and $date<=$veh->poliza_contractual) or ($veh->poliza_contractual<$date)){
              $contadora++;
            }

            $fecha_6 = strtotime ('-7 day', strtotime($veh->poliza_extracontractual));
            $fecha_6 = date ('Y-m-d' , $fecha_6);
            if(($date>=$fecha_6 and $date<=$veh->poliza_extracontractual) or ($veh->poliza_extracontractual<$date)){
              $contadora++;
            }

            $vehiculos_array[$i] = $contadora;

            $i++;
          }
          //TEST

          $administracion = Administracion::where('vehiculo_id', $vehiculo->id)
          ->where('ano',date('Y'))
          ->where('mes',date('m'))
          ->pluck('pago');

          //FIN PRUEBA COMO ESTÁ EN EL FUEC CONTROLLER

          return View::make('portalproveedores.vehiculos.gestionvehiculos')
          ->with('permisos',$permisos)
          ->with('administracion',$administracion)
          ->with('vehiculos',$vehiculo)
          ->with('administracion',$administracion)
          ->with('placa',$id)
          ->with('count',$vehiculos_array)
          ->with('vehiculoss',$vehiculoss);
        }
      }
    }

    public function getDocumentacionconductores(){

      if (Sentry::check()) {
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = 'on';
      }else{
        $id_rol = null;
        $permisos = null;
        $permisos = null;
        $ver = null;
      }

      //PENDIENTE EL CÓDIGO DE LA TABLA ROLES

      if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on' ) {
        return View::make('admin.permisos');
      }else {

        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $proveedor_id = Sentry::getUser()->proveedor_id;
        $id = null;

        $conductor = DB::table('conductores')
        ->where('proveedores_id',$proveedor_id)
        ->first();

        $conductores = DB::table('conductores')
        ->where('proveedores_id',$proveedor_id)
        ->whereNull('bloqueado')
        ->whereNull('bloqueado_total')
        ->get();

        if(!$conductores){

          $value = null;
          $licencia_conduccion = null;
          $conductor = null;
          $id = null;
          $conductores_array = null;
          $conductores = null;
        }else{
          $date = date('Y-m-d');

          $seguridad_social = "select pago, fecha_inicial, fecha_final from seguridad_social where conductor_id = ".$conductor->id." and '".$date."' between fecha_inicial and fecha_final ";
          $seguridad_social = DB::select($seguridad_social);

          if($seguridad_social!=null){
            foreach ($seguridad_social as $seg) {
              $value = $seg->fecha_final;
            }
          }else{
            $value = null;
          }

          //TEST
          $date = date('Y-m-d');

          $conductores_array = [];
          $i = 0;

          foreach ($conductores as $conductor) {

            $contadora = 0;

            $fecha_1 = strtotime ('-7 day', strtotime($conductor->fecha_licencia_vigencia));
            $fecha_1 = date ('Y-m-d' , $fecha_1);
            if(($date>=$fecha_1 and $date<=$conductor->fecha_licencia_vigencia) or ($conductor->fecha_licencia_vigencia<$date)){
              $contadora++;
            }

            //ÚLTIMA FECHA DE SEGURIDAD SOCIAL
            $seguridad_social = "select fecha_final from seguridad_social where conductor_id = ".$conductor->id."";
            $seguridad_social = DB::select($seguridad_social);

            if($seguridad_social!=null){
              foreach ($seguridad_social as $seg) {
                $value = $seg->fecha_final;
              }
            }else{
              $value = null;
            }
            //ÚLTIMA FECHA DE SEGURIDAD SOCIAL

            $fecha_2 = strtotime ('-7 day', strtotime($value));
            $fecha_2 = date ('Y-m-d' , $fecha_2);
            if(($date>=$fecha_2 and $date<=$value) or ($value<$date)){
              $contadora++;
            }

            $conductores_array[$i] = $contadora;

            $i++;
          }
          //TEST

          $licencia_conduccion = floor((strtotime($conductor->fecha_licencia_vigencia)-strtotime(date('Y-m-d')))/86400);
        }

        $departamentos = DB::table('departamento')->get();

        return View::make('portalproveedores.conductores.home')
        ->with('permisos',$permisos)
        ->with('departamentos',$departamentos)
        ->with('condu',$value)
        ->with('licencia_conduccion',$licencia_conduccion)
        ->with('conductor',$conductor)
        ->with('id',$id)
        ->with('count',$conductores_array)
        ->with('conductores',$conductores);
      }
    }

    public function getDocumentaciondeconductor($id){

      $id = Crypt::decryptString($id);

      if (Sentry::check()) {
        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $ver = 'on';
      }else{
        $id_rol = null;
        $permisos = null;
        $permisos = null;
        $ver = null;
      }

      //PENDIENTE EL CÓDIGO DE LA TABLA ROLES

      if (!Sentry::check()){

        return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }else if($ver!='on' ) {
        return View::make('admin.permisos');
      }else {

        $id_rol = Sentry::getUser()->id_rol;
        $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
        $permisos = json_decode($permisos);
        $proveedor_id = Sentry::getUser()->proveedor_id;

        $conductor = DB::table('conductores')
        ->where('id',$id)
        ->first();

        if($conductor->proveedores_id!=$proveedor_id){
          return View::make('admin.permisos');
        }else{

          $conductores = DB::table('conductores')
          ->where('proveedores_id',$proveedor_id)
          ->whereNull('bloqueado')
          ->whereNull('bloqueado_total')
          ->get();

          //TEST
          $date = date('Y-m-d');

          $conductores_array = [];
          $i = 0;

          foreach ($conductores as $conduc) {

            $contadora = 0;

            $fecha_1 = strtotime ('-7 day', strtotime($conduc->fecha_licencia_vigencia));
            $fecha_1 = date ('Y-m-d' , $fecha_1);
            if(($date>=$fecha_1 and $date<=$conduc->fecha_licencia_vigencia) or ($conduc->fecha_licencia_vigencia<$date)){
              $contadora++;
            }

            //ÚLTIMA FECHA DE SEGURIDAD SOCIAL
            $seguridad_social = "select fecha_final from seguridad_social where conductor_id = ".$conduc->id."";
            $seguridad_social = DB::select($seguridad_social);

            if($seguridad_social!=null){
              foreach ($seguridad_social as $seg) {
                $value = $seg->fecha_final;
              }
            }else{
              $value = null;
            }
            //ÚLTIMA FECHA DE SEGURIDAD SOCIAL

            $fecha_2 = strtotime ('-7 day', strtotime($value));
            $fecha_2 = date ('Y-m-d' , $fecha_2);
            if(($date>=$fecha_2 and $date<=$value) or ($value<$date)){
              $contadora++;
            }

            $conductores_array[$i] = $contadora;

            $i++;
          }
          //TEST

          //ÚLTIMA FECHA DE SEGURIDAD SOCIAL
          $seguridad_social = "select fecha_final from seguridad_social where conductor_id = ".$id."";
          $seguridad_social = DB::select($seguridad_social);

          if($seguridad_social!=null){
            foreach ($seguridad_social as $seg) {
              $value = $seg->fecha_final;
            }
          }else{
            $value = null;
          }
          //ÚLTIMA FECHA DE SEGURIDAD SOCIAL

          $licencia_conduccion = floor((strtotime($conductor->fecha_licencia_vigencia)-strtotime(date('Y-m-d')))/86400);

          return View::make('portalproveedores.conductores.gestionconductores')
          ->with('permisos',$permisos)
          ->with('condu',$value)
          ->with('licencia_conduccion',$licencia_conduccion)
          ->with('conductor',$conductor)
          ->with('id',$id)
          ->with('count',$conductores_array)
          ->with('conductores',$conductores);
        }
      }
    }

    public function postEnviarsms() {

      $nombre = Input::get('nombre');
      $id = Input::get('id');

      $conductor = DB::table('users')
      ->where('id',$id)
      ->first();

      $number = $conductor->telefono;

      $usuario = $conductor->email;
      $clave = $conductor->identificacion;

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);

      curl_setopt($ch, CURLOPT_POST, TRUE);

      curl_setopt($ch, CURLOPT_POSTFIELDS, "{
        \"messaging_product\": \"whatsapp\",
        \"to\": \"".$number."\",
        \"type\": \"template\",
        \"template\": {
          \"name\": \"notification_driver\",
          \"language\": {
            \"code\": \"es\",
          },
          \"components\": [{
            \"type\": \"body\",
            \"parameters\": [{
              \"type\": \"text\",
              \"text\": \"".$nombre."\",
            },
            {
              \"type\": \"text\",
              \"text\": \"".$usuario."\",
            },
            {
              \"type\": \"text\",
              \"text\": \"".$clave."\",
            }]
          }]
        }
      }");

      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
      ));

      $response = curl_exec($ch);
      curl_close($ch);

      return Response::json([
        'respuesta' => true,
        'response' => $response
      ]);

    }

    public function postEnviarsmss() {

      $nombre = Input::get('nombre');
      $id = Input::get('id');

      $conductor = DB::table('conductores')
      ->where('id',$id)
      ->first();

      $number = $conductor->celular;

      //$usuario = $conductor->email;
      //$clave = $conductor->identificacion;

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);

      curl_setopt($ch, CURLOPT_POST, TRUE);

      curl_setopt($ch, CURLOPT_POSTFIELDS, "{
        \"messaging_product\": \"whatsapp\",
        \"to\": \"".$number."\",
        \"type\": \"template\",
        \"template\": {
          \"name\": \"notify\",
          \"language\": {
            \"code\": \"es\",
          }
        }
      }");

      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
      ));

      $response = curl_exec($ch);
      curl_close($ch);

      return Response::json([
        'respuesta' => true,
        'response' => $response
      ]);

    }

    //GUARDAR DOCUMENTOS VEHICULOS
    public function postGuardars(){

      if (!Sentry::check()){

        return Response::json([
          'respuesta'=>'relogin'
        ]);

      }else{

        if(Request::ajax()){

          $id = Input::get('id');

          $sw1 = 0;
          $sw2 = 0;
          $sw3 = 0;
          $sw4 = 0;
          $sw5 = 0;
          $sw6 = 0;

          $tarjeta_operacion = Input::get('tarjeta_operacion');
          $soat = Input::get('soat');
          $tecnomecanica = Input::get('tecnomecanica');
          $mantenimiento_preventivo = Input::get('mantenimiento_preventivo');
          $poliza_contractual = Input::get('poliza_contractual');
          $poliza_extracontractual = Input::get('poliza_extracontractual');

          $vehiculo = Vehiculo::find($id);
          $sw = 0;


          if (Input::hasFile('tarjeta_operacion')){

            $file_pdf = Input::file('tarjeta_operacion');
            $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

            $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/gestiondocumental/vehiculos/';
            $file_pdf->move($ubicacion_pdf, $name_pdf);
            $vehiculo->tarjeta_operacion_pdf = $name_pdf;
            $vehiculo->save();
            $sw = 1;
            $sw1 = 1;
          }

          if (Input::hasFile('soat')){

            $file_pdf = Input::file('soat');
            $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

            $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/gestiondocumental/vehiculos/';
            $file_pdf->move($ubicacion_pdf, $name_pdf);
            $vehiculo->soat_pdf = $name_pdf;
            $vehiculo->save();
            $sw = 1;
            $sw2 = 1;
          }

          if (Input::hasFile('tecnomecanica')){

            $file_pdf = Input::file('tecnomecanica');
            $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

            $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/gestiondocumental/vehiculos/';
            $file_pdf->move($ubicacion_pdf, $name_pdf);
            $vehiculo->tecnomecanica_pdf = $name_pdf;
            $vehiculo->save();
            $sw = 1;
            $sw3 = 1;
          }

          if (Input::hasFile('mantenimiento_preventivo')){

            $file_pdf = Input::file('mantenimiento_preventivo');
            $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

            $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/gestiondocumental/vehiculos/';
            $file_pdf->move($ubicacion_pdf, $name_pdf);
            $vehiculo->preventivo_pdf = $name_pdf;
            $vehiculo->save();
            $sw = 1;
            $sw4 = 1;
          }

          if(Input::hasFile('poliza_contractual')){

            $file_pdf = Input::file('poliza_contractual');
            $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

            $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/gestiondocumental/vehiculos/';
            $file_pdf->move($ubicacion_pdf, $name_pdf);
            $vehiculo->poliza_contractual_pdf = $name_pdf;
            $vehiculo->save();
            $sw = 1;
            $sw5 = 1;
          }

          if(Input::hasFile('poliza_extracontractual')){

            $file_pdf = Input::file('poliza_extracontractual');
            $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

            $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/gestiondocumental/vehiculos/';
            $file_pdf->move($ubicacion_pdf, $name_pdf);
            $vehiculo->poliza_extracontractual_pdf = $name_pdf;
            $vehiculo->save();
            $sw = 1;
            $sw6 = 1;
          }

          if($sw == 0) {

            return Response::json([
              'respuesta' => false
            ]);

          }else{

            if( $sw4!=0 and ($sw1!=1 and $sw2!=1 and $sw3!=1 and $sw5!=1 and $sw6!=1) ) { //Solo mantenimiento
              $email = ['mantenimiento@aotour.com.co'];
            }else if( $sw4!=0 and ($sw1!=0 or $sw2!=0 or $sw3!=0 or $sw5!=0 or $sw6!=0) ){
              $email = ['mantenimiento@aotour.com.co','juridica@aotour.com.co','juridicabaq@aotour.com.co'];
            }else{
              $email = ['mantenimiento@aotour.com.co','juridica@aotour.com.co','juridicabaq@aotour.com.co'];
            }
            /*ENVÍO DE CORREO AL PROVEEDOR*/ //actualización de documentos portal de proveedores
            
            //$email = 'sistemas@aotour.com.co';

            $nombre = Sentry::getUser()->first_name;

            $data = [
                'id' => 1,
                'nombre' => $nombre,
                'vehiculo' => 'vehículo'
              ];
            Mail::send('portalproveedores.emails.documentos_actualizados', $data, function($message) use ($email){
              $message->from('no-reply@aotour.com.co', 'PROVEEDORES');
              $message->to($email)->subject('Documentación de Vehículo');
              $message->cc('aotourdeveloper@gmail.com');
            });
            //FIN ENVÍO DE CORREO AL PROVEEDOR*/

            return Response::json([
              'respuesta' => true
            ]);

          }

        }
      }
    }

    //GUARDAR DOCUMENTOS CONDUCTOR
    public function postGuardarc(){

      if (!Sentry::check()){

        return Response::json([
          'respuesta'=>'relogin'
        ]);

      }else{

        if(Request::ajax()){

          $id = Input::get('id');

          $seguridad_social = Input::get('seguridad_social');
          $licencia = Input::get('licencia');

          $conductor = Conductor::find($id);
          $sw = 0;

          if (Input::hasFile('seguridad_social')){

            $file_pdf = Input::file('seguridad_social');
            $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

            $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/gestiondocumental/conductores/';
            $file_pdf->move($ubicacion_pdf, $name_pdf);
            $conductor->seguridad_social_pdf = $name_pdf;
            $conductor->save();
            $sw = 1;

          }

          if (Input::hasFile('licencia')){

            $file_pdf = Input::file('licencia');
            $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

            $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/gestiondocumental/conductores/';
            $file_pdf->move($ubicacion_pdf, $name_pdf);
            $conductor->licencia_conduccion_pdf = $name_pdf;
            $conductor->save();
            $sw = 1;

          }

          if($sw == 0) {

            return Response::json([
              'respuesta' => false
            ]);

          }else{

            /*ENVÍO DE CORREO AL PROVEEDOR*/
            $email = ['talentohumano@aotour.com.co','juridica@aotour.com.co','juridicabaq@aotour.com.co'];

            $nombre = Sentry::getUser()->first_name;

            $data = [
              'id'    => 1,
              'nombre' => $nombre,
              'vehiculo' => 'conductor'
            ];

            Mail::send('portalproveedores.emails.documentos_actualizados', $data, function($message) use ($email){
              $message->from('no-reply@aotour.com.co', 'PROVEEDORES');
              $message->to($email)->subject('Documentación de Conductor');
              $message->cc('aotourdeveloper@gmail.com');
            });
            //FIN ENVÍO DE CORREO AL PROVEEDOR*/

            return Response::json([
              'respuesta' => true
            ]);

          }

        }
      }
    }

    public function postBuscar(){

      if (!Sentry::check()){

        return Response::json([
          'respuesta'=>'relogin'
        ]);

      }else{

        if(Request::ajax()){

          $fecha_inicial = Input::get('fecha_inicial');
          $fecha_final = Input::get('fecha_final');
          $proveedor = intval(Input::get('proveedor'));
          $estado = intval(Input::get('estado'));


          $query = "select listado_cuentas.id as id_cuenta, listado_cuentas.valor, listado_cuentas.fecha_expedicion, listado_cuentas.estado, listado_cuentas.fecha_inicial, listado_cuentas.fecha_final, proveedores.razonsocial from listado_cuentas ".
          "left join proveedores on proveedores.id = listado_cuentas.proveedor ".
          "where listado_cuentas.fecha_inicial ='".$fecha_inicial."' and listado_cuentas.fecha_final ='".$fecha_final."'";

          if($estado===0){
            $query .= " and listado_cuentas.estado = 0 ";
          }else if($estado===1){
            $query .=" and listado_cuentas.estado = 1 ";
          }else if($estado===2){
            $query .= " and listado_cuentas.estado = 2 ";
          }else if($estado===3){
            $query .= " and listado_cuentas.estado = 3 ";
          }

          if ($proveedor===0) {
            $consulta = DB::select($query.'order by proveedores.razonsocial asc');
          }else if($proveedor!=0){
            $query .= "and listado_cuentas.proveedor = ".$proveedor." ";
            $consulta = DB::select($query.'order by proveedores.razonsocial asc');
          }

          if($consulta!=null){
            return Response::json([
              'respuesta' => true,
              'proveedor' => $proveedor,
              'cuentas' => $consulta
            ]);
          }else{
            return Response::json([
              'respuesta' => false,
              'cuentas' => $query
            ]);
          }
        }
      }
    }

    //CORREOS START
    public function getCorreodocumentovencido(){

      return View::make('portalproveedores.emails.documento_vencido');

    }

    public function getCuentac(){

      return View::make('portalproveedores.emails.cuenta_cobro');

    }

    public function getEntregadeusuario(){

      return View::make('portalproveedores.emails.entrega_usuario');
    }

    public function getDocumentorechazado(){

      return View::make('portalproveedores.emails.documento_rechazado')
      ->with('nombre', 'SEGURIDAD SOCIAL / LICENCIA / SOAT')
      ->with('motivo', 'FECHA INVÁLIDA / DOCUMENTO INCORRECTO ');
    }

    public function getDocumentosrechazados(){

      return View::make('portalproveedores.emails.documentos_rechazados');
    }
    //CORREOS END

    public function getClientes(){

      $id_rol = Sentry::getUser()->id_rol;
      $id_proveedor = Sentry::getUser()->proveedor_id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      /*$datos_pago = DB::table('datos_pago')
      ->where('id',1)
      ->first();*/

      /*CALCULAR LAS FECHAS DISPONIBLES PARA COBRAR START*/
      $fecha = explode('-', date('Y-m-d'));
      $mes = $fecha[1];

      $mes_actual = $mes;
      $mes_atras = $mes-1;

      if($mes_atras == 0){
        $mes_atras = 12;
      }

      if($mes_atras=='01'){
        $mes = '0';
        $last = '31';
      }else if($mes_atras=='02'){
        $mes = '0';
        $last = '28';
      }else if($mes_atras=='03'){
        $mes = '0';
        $last = '31';
      }else if($mes_atras=='04'){
        $mes = '0';
        $last = '30';
      }else if($mes_atras=='05'){
        $mes = '0';
        $last = '31';
      }else if($mes_atras=='06'){
        $mes = '0';
        $last = '30';
      }else if($mes_atras=='07'){
        $mes = '0';
        $last = '31';
      }else if($mes_atras=='08'){
        $mes = '0';
        $last = '31';
      }else if($mes_atras=='09'){
        $mes = '0';
        $last = '30';
      }else if($mes_atras=='10'){
        $mes = '';
        $last = '31';
      }else if($mes_atras=='11'){
        $mes = '';
        $last = '30';
      }else if($mes_atras=='12'){
        $mes = '';
        $last = '31';
      }
      //$last = '10';
      //echo $mes_atras;
      $mes_atras = $mes.$mes_atras;

      $fecha = explode('-', date('Y-m-d'));
      $ano = $fecha[0];

      $start_date = $ano.'-'.$mes_atras.'-01';
      $end_date = $ano.'-'.$mes_atras.'-'.$last;

      $actual = DB::table('cuenta')
      ->where('id',1)
      ->first();

      $start_date = $actual->fecha_inicial;
      $end_date = $actual->fecha_final;//LEONELA

      //Cambiar meses para pruebas
      //$start_date = '2021-06-01';
      //$end_date = '2021-06-30';

      /*CALCULAR LAS FECHAS DISPONIBLES PARA COBRAR END*/

      $cuenta_activa = DB::table('listado_cuentas')
      ->select('listado_cuentas.id')
      //->where('estado',0)
      //->orwhere('estado',1)
      //->orwhere('estado',2)
      ->whereNull('tipo_cuenta')
      ->where('fecha_inicial',$start_date)
      ->where('fecha_final',$end_date)

      ->where('proveedor',$id_proveedor)
      ->first();

      $cuenta_enviada = DB::table('listado_cuentas')
      ->select('ap.id', 'listado_cuentas.id as id_cuenta', 'listado_cuentas.estado', 'listado_cuentas.proveedor as proveedor_ide')
      ->leftJoin('ap', 'ap.id_cuenta', '=', 'listado_cuentas.id')
      ->where('ap.fecha_inicial',$start_date)
      ->where('ap.fecha_final',$end_date)
      ->whereNull('tipo_cuenta')
      ->where('listado_cuentas.proveedor',$id_proveedor)
      ->first();

      if($cuenta_enviada!=null){
        $cuenta_enviada = $cuenta_enviada->estado;
      }else{
        $cuenta_enviada = 0;
      }

      if($cuenta_activa!=null){
        $cuenta_activa = 0;
      }else{
        $cuenta_activa = 1;
      }

      $rutas_programadas = DB::table('servicios')
      ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
      ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
      ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
      ->join('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
      ->join('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->join('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
      ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
      ->select('rutas.nombre_ruta','rutas.codigo_ruta',
          'servicios.detalle_recorrido', 'servicios.recoger_en','servicios.dejar_en','servicios.id',
          'servicios.fecha_servicio', 'servicios.fecha_orden', 'servicios.hora_servicio','servicios.centrodecosto_id','servicios.ciudad','servicios.ruta_id', 'servicios.ruta',
          'proveedores.razonsocial',
          'vehiculos.placa','vehiculos.marca','vehiculos.clase',
          'facturacion.numero_planilla','facturacion.observacion','facturacion.facturado','facturacion.cambios_servicio',
          'facturacion.cod_centro_costo', 'facturacion.total_pagado', 'facturacion.unitario_pagado_correccion', 'facturacion.estado_correccion', 'facturacion.liquidado', 'facturacion.servicio_id', 'facturacion.aceptado_liquidado', 'facturacion.conversacion', 'facturacion.valor_proveedor',
          'conductores.nombre_completo', 'subcentrosdecosto.nombresubcentro', 'centrosdecosto.razonsocial as razoncentro')
      //->where('servicios.centrodecosto_id',$id)
      ->where('proveedores.id',$id_proveedor)
      ->where('centrosdecosto.id', '!=', 341)
      //->whereNotNull('facturacion.liquidado')
      //->where('servicios.subcentrodecosto_id',$subcentrodecosto_id)
      ->whereBetween('fecha_servicio',[''.$start_date.'',''.$end_date.''])
      ->whereNull('pendiente_autori_eliminacion')
      ->orderBy('centrosdecosto.id')
      ->orderBy('servicios.fecha_servicio')
      ->orderBy('servicios.hora_servicio')
      ->orderBy('servicios.subcentrodecosto_id')
      //->where('pasajeros',$pax)
      ->get();

      return View::make('portalproveedores.cuentadecobro.cliente')
      ->with('rutas_programadas',$rutas_programadas)
      ->with('cuenta_activa', $cuenta_activa)
      ->with('cuenta_enviada', $cuenta_enviada)
      ->with('mes_actual',$start_date)
      ->with('mes_atras',$end_date)
      ->with('permisos',$permisos);
    }

    public function getClientesescolar(){

      $id_rol = Sentry::getUser()->id_rol;
      $id_proveedor = Sentry::getUser()->proveedor_id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      /*$datos_pago = DB::table('datos_pago')
      ->where('id',1)
      ->first();*/

      /*CALCULAR LAS FECHAS DISPONIBLES PARA COBRAR START*/
      $fecha = explode('-', date('Y-m-d'));
      $mes = $fecha[1];

      $mes_actual = $mes;
      $mes_atras = $mes-1;

      if($mes_atras == 0){
        $mes_atras = 12;
      }

      if($mes_atras=='01'){
        $mes = '0';
        $last = '31';
      }else if($mes_atras=='02'){
        $mes = '0';
        $last = '28';
      }else if($mes_atras=='03'){
        $mes = '0';
        $last = '31';
      }else if($mes_atras=='04'){
        $mes = '0';
        $last = '30';
      }else if($mes_atras=='05'){
        $mes = '0';
        $last = '31';
      }else if($mes_atras=='06'){
        $mes = '0';
        $last = '30';
      }else if($mes_atras=='07'){
        $mes = '0';
        $last = '31';
      }else if($mes_atras=='08'){
        $mes = '0';
        $last = '31';
      }else if($mes_atras=='09'){
        $mes = '0';
        $last = '30';
      }else if($mes_atras=='10'){
        $mes = '';
        $last = '31';
      }else if($mes_atras=='11'){
        $mes = '';
        $last = '30';
      }else if($mes_atras=='12'){
        $mes = '';
        $last = '31';
      }
      //$last = '10';
      //echo $mes_atras;
      $mes_atras = $mes.$mes_atras;

      $fecha = explode('-', date('Y-m-d'));
      $ano = $fecha[0];

      $start_date = $ano.'-'.$mes_atras.'-01';
      $end_date = $ano.'-'.$mes_atras.'-'.$last;

      $actual = DB::table('cuenta')
      ->where('id',1)
      ->first();

      $start_date = $actual->fecha_inicial;
      $end_date = $actual->fecha_final;//LEONELA

      //Cambiar meses para pruebas
      //$start_date = '2021-06-01';
      //$end_date = '2021-06-30';

      /*CALCULAR LAS FECHAS DISPONIBLES PARA COBRAR END*/

      $cuenta_activa = DB::table('listado_cuentas')
      ->select('listado_cuentas.id')
      //->where('estado',0)
      //->orwhere('estado',1)
      //->orwhere('estado',2)

      ->where('fecha_inicial',$start_date)
      ->where('fecha_final',$end_date)
      ->where('tipo_cuenta',1)
      ->where('proveedor',$id_proveedor)
      ->first();

      $cuenta_enviada = DB::table('listado_cuentas')
      ->select('ap.id', 'listado_cuentas.id as id_cuenta', 'listado_cuentas.estado', 'listado_cuentas.proveedor as proveedor_ide')
      ->leftJoin('ap', 'ap.id_cuenta', '=', 'listado_cuentas.id')
      ->where('ap.fecha_inicial',$start_date)
      ->where('ap.fecha_final',$end_date)
      ->where('tipo_cuenta',1)
      ->where('listado_cuentas.proveedor',$id_proveedor)
      ->first();

      if($cuenta_enviada!=null){
        $cuenta_enviada = $cuenta_enviada->estado;
      }else{
        $cuenta_enviada = 0;
      }

      if($cuenta_activa!=null){
        $cuenta_activa = 0;
      }else{
        $cuenta_activa = 1;
      }

      $rutas_programadas = DB::table('servicios')
      ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
      ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
      //->join('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->join('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
      ->leftJoin('facturacion','facturacion.servicio_id', '=', 'servicios.id')
      ->select('servicios.detalle_recorrido', 'servicios.recoger_en','servicios.dejar_en','servicios.id',
          'servicios.fecha_servicio', 'servicios.fecha_orden', 'servicios.hora_servicio','servicios.centrodecosto_id','servicios.ciudad','servicios.ruta_id', 'servicios.ruta',
          'proveedores.razonsocial', 'facturacion.numero_planilla','facturacion.observacion','facturacion.facturado','facturacion.cambios_servicio',
          'facturacion.cod_centro_costo', 'facturacion.total_pagado', 'facturacion.total_pagado', 'facturacion.unitario_pagado_correccion', 'facturacion.estado_correccion', 'facturacion.servicio_id', 'facturacion.aceptado_liquidado', 'facturacion.conversacion', 'facturacion.valor_proveedor',
          'conductores.nombre_completo', 'centrosdecosto.razonsocial as razoncentro')
      //->where('servicios.centrodecosto_id',$id)
      ->where('proveedores.id',$id_proveedor)
      ->where('servicios.centrodecosto_id',341)
      //->whereNotNull('facturacion.liquidado')
      //->where('servicios.subcentrodecosto_id',$subcentrodecosto_id)
      ->whereBetween('fecha_servicio',[''.$start_date.'',''.$end_date.''])
      ->whereNull('pendiente_autori_eliminacion')
      ->orderBy('centrosdecosto.id')
      ->orderBy('servicios.fecha_servicio')
      ->orderBy('servicios.hora_servicio')
      ->orderBy('servicios.subcentrodecosto_id')
      //->where('pasajeros',$pax)
      ->get();

      return View::make('portalproveedores.cuentadecobro.cliente_escolar')
      ->with('rutas_programadas',$rutas_programadas)
      ->with('cuenta_activa', $cuenta_activa)
      ->with('cuenta_enviada', $cuenta_enviada)
      ->with('mes_actual',$start_date)
      ->with('mes_atras',$end_date)
      ->with('permisos',$permisos);
    }

    public function postRegistrarvalor(){

      $id = Input::get('id');
      $valor = Input::get('valor');

      $update = DB::table('facturacion')
      ->where('servicio_id',$id)
      ->update([
        'valor_proveedor' => $valor
      ]);

      if($update){
        return Response::json([
          'respuesta' => true
        ]);
      }else{
        return Response::json([
          'respuesta' => false
        ]);
      }
    }

    public function getMisservicios(){

      $id=19;
      $id_rol = Sentry::getUser()->id_rol;
      $id_proveedor = Sentry::getUser()->proveedor_id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $nombre_cliente = DB::table('centrosdecosto')
      ->where('id',$id)
      ->pluck('razonsocial');

      //Consulta de disponibilidad
      $disponibilidad = DB::table('datos_pago')->where('id',1)->first();

      $rutas_programadas = DB::table('servicios')
      ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
      ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
      ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
      ->join('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
      ->join('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->join('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
      ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
      ->select('rutas.nombre_ruta','rutas.codigo_ruta',
          'servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.id',
          'servicios.fecha_servicio', 'servicios.fecha_orden', 'servicios.hora_servicio','servicios.centrodecosto_id','servicios.ciudad','servicios.ruta_id', 'servicios.ruta',
          'proveedores.razonsocial',
          'vehiculos.placa','vehiculos.marca','vehiculos.clase',
          'facturacion.numero_planilla','facturacion.observacion','facturacion.facturado','facturacion.cambios_servicio',
          'facturacion.cod_centro_costo', 'facturacion.total_pagado', 'facturacion.aceptado_liquidado', 'facturacion.unitario_pagado_correccion',
          'conductores.nombre_completo', 'subcentrosdecosto.nombresubcentro', 'centrosdecosto.razonsocial as razoncentro')
      //->where('servicios.centrodecosto_id',$id)
      ->where('proveedores.id',$id_proveedor)
      ->whereNotNull('facturacion.liquidado')
      //->where('servicios.subcentrodecosto_id',$subcentrodecosto_id)
      ->whereBetween('fecha_servicio',[''.$disponibilidad->fecha_inicio.'', ''.$disponibilidad->fecha_fin.''])
      ->whereNull('pendiente_autori_eliminacion')
      ->orderBy('centrosdecosto.id')
      //->where('pasajeros',$pax)
      ->get();

      $control = DB::table('listado_cuentas')
      ->where('proveedor',$id_proveedor)
      ->where('estado',0)
      ->orwhere('estado',1)
      ->orwhere('estado',2)
      ->first();

      if($control!=null){
        $estado = $control->estado;
      }else{
        $estado = null;
      }

      return View::make('portalproveedores.test')
      ->with('nombre_cliente',$nombre_cliente)
      ->with('rutas_programadas',$rutas_programadas)
      ->with('permisos',$permisos)
      ->WITH('estado',$estado)
      ->with('centrodecosto',$id);
    }

    public function getSolicitudactual(){

      $id=19;
      $id_rol = Sentry::getUser()->id_rol;
      $id_proveedor = Sentry::getUser()->proveedor_id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $nombre_cliente = DB::table('centrosdecosto')
      ->where('id',$id)
      ->pluck('razonsocial');

      /*$datos_pago = DB::table('datos_pago')
      ->where('id',1)
      ->first();//GENERAR FECHA DINÁMICA (PENDIENTE)*/

      /*CALCULAR LAS FECHAS DISPONIBLES PARA COBRAR START*/
      $fecha = explode('-', date('Y-m-d'));
      $mes = $fecha[1];

      $mes_actual = $mes;
      $mes_atras = $mes_actual-1;
      if($mes==='01'){
        $mes = '0';
        $last = '31';
      }else if($mes==='02'){
        $mes = '0';
        $last = '28';
      }else if($mes==='03'){
        $mes = '0';
        $last = '31';
      }else if($mes==='04'){
        $mes = '0';
        $last = '30';
      }else if($mes==='05'){
        $mes = '0';
        $last = '30';
      }else if($mes==='06'){
        $mes = '0';
        $last = '30';
      }else if($mes==='07'){
        $mes = '0';
        $last = '30';
      }else if($mes==='08'){
        $mes = '0';
        $last = '31';
      }else if($mes==='09'){
        $mes = '0';
        $last = '30';
      }else if($mes==='10'){
        $mes = '';
        $last = '31';
      }else if($mes==='11'){
        $mes = '';
        $last = '30';
      }else if($mes==='12'){
        $mes = '';
        $last = '31';
      }

      $mes_atras = $mes.$mes_atras;

      $fecha = explode('-', date('Y-m-d'));
      $ano = $fecha[0];

      $start_date = $ano.'-'.$mes_atras.'-01';
      $end_date = $ano.'-'.$mes_atras.'-'.$last;

      $actual = DB::table('cuenta')
      ->where('id',1)
      ->first();

      $start_date = $actual->fecha_inicial;
      $end_date = $actual->fecha_final;//LEONELA

      //Cambiar meses para pruebas
      //$start_date = '2021-06-01';
      //$end_date = '2021-06-30';

      /*CALCULAR LAS FECHAS DISPONIBLES PARA COBRAR END*/

      //$start_date = $datos_pago->fecha_inicio;
      //$end_date = $datos_pago->fecha_fin;
      //$fecha_pago = $datos_pago->fecha_pago;

      $rutas_programadas = DB::table('servicios')
      ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
      ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
      ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
      ->join('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
      ->join('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->join('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
      ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
      ->select('rutas.nombre_ruta','rutas.codigo_ruta',
          'servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.id',
          'servicios.fecha_servicio', 'servicios.fecha_orden', 'servicios.hora_servicio','servicios.centrodecosto_id','servicios.ciudad','servicios.ruta_id', 'servicios.ruta',
          'proveedores.razonsocial',
          'vehiculos.placa','vehiculos.marca','vehiculos.clase',
          'facturacion.numero_planilla','facturacion.observacion','facturacion.facturado','facturacion.cambios_servicio',
          'facturacion.cod_centro_costo', 'facturacion.total_pagado', 'facturacion.unitario_pagado_correccion', 'facturacion.estado_correccion', 'facturacion.servicio_id', 'facturacion.aceptado_liquidado', 'facturacion.conversacion', 'facturacion.valor_proveedor',
          'conductores.nombre_completo', 'subcentrosdecosto.nombresubcentro', 'centrosdecosto.razonsocial as razoncentro')
      //->where('servicios.centrodecosto_id',$id)
      ->where('proveedores.id',$id_proveedor)
      ->where('centrosdecosto.id', '!=', 341)
      //->whereNotNull('facturacion.liquidado')
      //->where('servicios.subcentrodecosto_id',$subcentrodecosto_id)
      ->whereBetween('fecha_servicio',[''.$start_date.'',''.$end_date.''])
      ->whereNull('pendiente_autori_eliminacion')
      ->orderBy('centrosdecosto.id')
      //->where('pasajeros',$pax)
      ->get();

      $control = DB::table('listado_cuentas')
      ->where('proveedor',$id_proveedor)
      ->where('fecha_inicial',$start_date)
      ->where('fecha_final',$end_date)
      ->whereNull('tipo_cuenta')
      //->where('estado',1)
      //->orderBy('fecha', 'desc')
      ->first();

      if($control!=null){
        if($control->estado != 3){
          $cuenta = $control->id;
          $estado = $control->estado;
        }else{
          $cuenta = null;
          $estado = null;
        }
      }else{
        $cuenta = null;
        $estado = null;
      }

      return View::make('portalproveedores.solicitud_actual')
      ->with('control',$control)
      ->with('nombre_cliente',$nombre_cliente)
      ->with('rutas_programadas',$rutas_programadas)
      ->with('permisos',$permisos)
      ->with('centrodecosto',$id)
      ->with('estado',$estado)
      ->with('cuenta_id',$cuenta)
      ->with('id_proveedor',$cuenta);

    }

    public function getSolicitudactualescolar(){

      $id=19;
      $id_rol = Sentry::getUser()->id_rol;
      $id_proveedor = Sentry::getUser()->proveedor_id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $nombre_cliente = DB::table('centrosdecosto')
      ->where('id',$id)
      ->pluck('razonsocial');

      /*$datos_pago = DB::table('datos_pago')
      ->where('id',1)
      ->first();//GENERAR FECHA DINÁMICA (PENDIENTE)*/

      /*CALCULAR LAS FECHAS DISPONIBLES PARA COBRAR START*/
      $fecha = explode('-', date('Y-m-d'));
      $mes = $fecha[1];

      $mes_actual = $mes;
      $mes_atras = $mes_actual-1;
      if($mes==='01'){
        $mes = '0';
        $last = '31';
      }else if($mes==='02'){
        $mes = '0';
        $last = '28';
      }else if($mes==='03'){
        $mes = '0';
        $last = '31';
      }else if($mes==='04'){
        $mes = '0';
        $last = '30';
      }else if($mes==='05'){
        $mes = '0';
        $last = '30';
      }else if($mes==='06'){
        $mes = '0';
        $last = '30';
      }else if($mes==='07'){
        $mes = '0';
        $last = '30';
      }else if($mes==='08'){
        $mes = '0';
        $last = '31';
      }else if($mes==='09'){
        $mes = '0';
        $last = '30';
      }else if($mes==='10'){
        $mes = '';
        $last = '31';
      }else if($mes==='11'){
        $mes = '';
        $last = '30';
      }else if($mes==='12'){
        $mes = '';
        $last = '31';
      }

      $mes_atras = $mes.$mes_atras;

      $fecha = explode('-', date('Y-m-d'));
      $ano = $fecha[0];

      $start_date = $ano.'-'.$mes_atras.'-01';
      $end_date = $ano.'-'.$mes_atras.'-'.$last;

      $actual = DB::table('cuenta')
      ->where('id',1)
      ->first();

      $start_date = $actual->fecha_inicial;
      $end_date = $actual->fecha_final;//LEONELA

      //Cambiar meses para pruebas
      //$start_date = '2021-06-01';
      //$end_date = '2021-06-30';

      /*CALCULAR LAS FECHAS DISPONIBLES PARA COBRAR END*/

      //$start_date = $datos_pago->fecha_inicio;
      //$end_date = $datos_pago->fecha_fin;
      //$fecha_pago = $datos_pago->fecha_pago;

      $rutas_programadas = DB::table('servicios')
      ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
      ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
      ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
      ->join('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
      ->join('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->join('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
      ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
      ->select('rutas.nombre_ruta','rutas.codigo_ruta',
          'servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.id',
          'servicios.fecha_servicio', 'servicios.fecha_orden', 'servicios.hora_servicio','servicios.centrodecosto_id','servicios.ciudad','servicios.ruta_id', 'servicios.ruta',
          'proveedores.razonsocial',
          'vehiculos.placa','vehiculos.marca','vehiculos.clase',
          'facturacion.numero_planilla','facturacion.observacion','facturacion.facturado','facturacion.cambios_servicio',
          'facturacion.cod_centro_costo', 'facturacion.total_pagado', 'facturacion.unitario_pagado_correccion', 'facturacion.estado_correccion', 'facturacion.servicio_id', 'facturacion.aceptado_liquidado', 'facturacion.conversacion', 'facturacion.valor_proveedor',
          'conductores.nombre_completo', 'subcentrosdecosto.nombresubcentro', 'centrosdecosto.razonsocial as razoncentro')
      //->where('servicios.centrodecosto_id',$id)
      ->where('proveedores.id',$id_proveedor)
      ->where('centrosdecosto.id',341)
      //->whereNotNull('facturacion.liquidado')
      //->where('servicios.subcentrodecosto_id',$subcentrodecosto_id)
      ->whereBetween('fecha_servicio',[''.$start_date.'',''.$end_date.''])
      ->whereNull('pendiente_autori_eliminacion')
      ->orderBy('centrosdecosto.id')
      //->where('pasajeros',$pax)
      ->get();

      $control = DB::table('listado_cuentas')
      ->where('proveedor',$id_proveedor)
      ->where('fecha_inicial',$start_date)
      ->where('fecha_final',$end_date)
      ->where('tipo_cuenta',1)
      //->where('estado',1)
      //->orderBy('fecha', 'desc')
      ->first();

      if($control!=null){
        if($control->estado != 3){
          $cuenta = $control->id;
          $estado = $control->estado;
        }else{
          $cuenta = null;
          $estado = null;
        }
      }else{
        $cuenta = null;
        $estado = null;
      }

      return View::make('portalproveedores.solicitud_actual_escolar')
      ->with('control',$control)
      ->with('nombre_cliente',$nombre_cliente)
      ->with('rutas_programadas',$rutas_programadas)
      ->with('permisos',$permisos)
      ->with('centrodecosto',$id)
      ->with('estado',$estado)
      ->with('cuenta_id',$cuenta)
      ->with('id_proveedor',$cuenta);

    }

    /*
    public function getSolicitudactual2(){

      $id=19;
      $id_rol = Sentry::getUser()->id_rol;
      $id_proveedor = Sentry::getUser()->proveedor_id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $nombre_cliente = DB::table('centrosdecosto')
      ->where('id',$id)
      ->pluck('razonsocial');

      $datos_pago = DB::table('datos_pago')
      ->where('id',1)
      ->first();//GENERAR FECHA DINÁMICA (PENDIENTE)

      $start_date = $datos_pago->fecha_inicio;
      $end_date = $datos_pago->fecha_fin;
      $fecha_pago = $datos_pago->fecha_pago;

      $rutas_programadas = DB::table('servicios')
      ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
      ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
      ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
      ->join('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
      ->join('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->join('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
      ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
      ->select('rutas.nombre_ruta','rutas.codigo_ruta',
          'servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.id',
          'servicios.fecha_servicio', 'servicios.fecha_orden', 'servicios.hora_servicio','servicios.centrodecosto_id','servicios.ciudad','servicios.ruta_id', 'servicios.ruta',
          'proveedores.razonsocial',
          'vehiculos.placa','vehiculos.marca','vehiculos.clase',
          'facturacion.numero_planilla','facturacion.observacion','facturacion.facturado','facturacion.cambios_servicio',
          'facturacion.cod_centro_costo', 'facturacion.total_pagado', 'facturacion.unitario_pagado_correccion', 'facturacion.estado_correccion', 'facturacion.servicio_id', 'facturacion.aceptado_liquidado', 'facturacion.conversacion',
          'conductores.nombre_completo', 'subcentrosdecosto.nombresubcentro', 'centrosdecosto.razonsocial as razoncentro')
      //->where('servicios.centrodecosto_id',$id)
      ->where('proveedores.id',$id_proveedor)
      ->whereNotNull('facturacion.liquidado')
      //->where('servicios.subcentrodecosto_id',$subcentrodecosto_id)
      ->whereBetween('fecha_servicio',[''.$start_date.'',''.$end_date.''])
      ->whereNull('pendiente_autori_eliminacion')
      ->orderBy('centrosdecosto.id')
      //->where('pasajeros',$pax)
      ->get();

      $control = DB::table('listado_cuentas')
      ->where('proveedor',$id_proveedor)
      ->where('estado',0)
      ->orwhere('estado',1)
      ->orwhere('estado',2)
      //->orderBy('fecha', 'desc')
      ->first();

      if($control!=null){
        $cuenta = $control->id;
        $estado = $control->estado;
      }else{
        $cuenta = null;
        $estado = null;
      }

      return View::make('portalproveedores.solicitud_actual')
      ->with('control',$control)
      ->with('nombre_cliente',$nombre_cliente)
      ->with('rutas_programadas',$rutas_programadas)
      ->with('permisos',$permisos)
      ->with('centrodecosto',$id)
      ->with('estado',$estado)
      ->with('cuenta_id',$cuenta);

    }*/

    public function getHistorialdecuentas(){

      $id=19;
      $id_rol = Sentry::getUser()->id_rol;
      $id_proveedor = Sentry::getUser()->proveedor_id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $nombre_cliente = DB::table('centrosdecosto')
      ->where('id',$id)
      ->pluck('razonsocial');

      $cuentas = DB::table('listado_cuentas')
      ->select('listado_cuentas.*', 'proveedores.razonsocial')
      ->leftJoin('proveedores', 'proveedores.id', '=', 'listado_cuentas.proveedor')
      ->where('listado_cuentas.proveedor',$id_proveedor)
      ->where('listado_cuentas.estado',3)
      ->get();

      return View::make('portalproveedores.historial')
      //->with('control',$control)
      ->with('nombre_cliente',$nombre_cliente)
      ->with('cuentas',$cuentas)
      ->with('permisos',$permisos)
      ->with('centrodecosto',$id);
      //->with('estado',$estado)
      //->with('cuenta_id',$cuenta);

    }

    public function postAceptarliquidado(){

      $id = Input::get('id');

      $update = DB::table('facturacion')
      ->where('servicio_id',$id)
      ->update([
        'aceptado_liquidado' => 1
      ]);

      if($update){
        return Response::json([
          'respuesta' => true
        ]);
      }else{
        return Response::json([
          'respuesta' => false
        ]);
      }

    }

    public function postRechazarliquidado(){

      $id = Input::get('id');
      $nuevo_valor = Input::get('nuevo_valor');
      $mensaje = Input::get('mensaje');
      $cuenta_id = Input::get('cuenta_id');

      /*return Response::json([
        'respuesta' => true,
      ]);*/

      $cambios = DB::table('facturacion')
      ->where('servicio_id',$id)
      ->first();

      $up = $cambios->unitario_pagado_correccion;
      $vp = $cambios->unitario_pagado_correccion;
      $upc = $cambios->valor_proveedor;

      $array = null;

      $array = [
        'usuario' => 1,
        'mensaje' => strtoupper($mensaje),
        'valor' => $nuevo_valor,
        'time' => date('H:i:s'),
        'date' => date('Y-m-d')
      ];

      if($cambios!=null){
          $objArray = json_decode($cambios->conversacion);
          array_push($objArray, $array);
          $data = json_encode($objArray);
      }else{
          $data = json_encode([$array]);
      }

      //$mensaje = json_encode([$array]);

      $update = DB::table('facturacion')
      ->where('servicio_id',$id)
      ->update([
        'estado_correccion' => 0,
        'valor_proveedor' => $nuevo_valor,
        'conversacion' => $data
      ]);

      $sub = DB::table('servicios')
      ->where('id',$id)
      ->pluck('subcentrodecosto_id');

      $consulta = DB::table('ap')
      ->where('id_cuenta',$cuenta_id)
      ->where('subcentrodecosto',$sub)
      ->first();

      $modificacio_ap = DB::table('ap')
      ->where('id_cuenta',$cuenta_id)
      ->where('subcentrodecosto',$sub)
      ->update([
        'valor' => $consulta->valor-$upc+$nuevo_valor,
        'valor_corregido' => $consulta->valor_corregido-$upc+$nuevo_valor
      ]);

      if($update){
        return Response::json([
          'respuesta' => true,
          'nuevo_valor' => $nuevo_valor
        ]);
      }else{
        return response::json([
          'respuesta' => false
        ]);
      }
    }

    /*
    public function postRechazarliquidado(){

      $id = Input::get('id');
      $nuevo_valor = Input::get('nuevo_valor');
      $mensaje = Input::get('mensaje');

      $array = [
        'usuario' => 1,
        'mensaje' => strtoupper($mensaje),
        'valor' => $nuevo_valor
      ];

      $mensaje = json_encode([$array]);

      $update = DB::table('facturacion')
      ->where('servicio_id',$id)
      ->update([
        'estado_correccion' => 0,
        'unitario_pagado_correccion' => $nuevo_valor,
        'conversacion' => $mensaje
      ]);

      if($update){
        return Response::json([
          'respuesta' => true,
        ]);
      }else{
        return response::json([
          'respuesta' => false
        ]);
      }
    }
    */

    //ACEPTAR CORRECCIÓN INDIVIDUAL
    /* ANALIZAR: MANTENER EL VALOR CORREGIDO Y ANTIGUO PARA MOSTRAR Y DIFERENCIAR EN LA VISTA DE CONTABILIDAD */

    public function postAceptarcorreccion(){

      $cuenta_id = Input::get('cuenta_id');
      $id_servicio = Input::get('id_servicio');

      $query = DB::table('facturacion')
      ->where('servicio_id',$id_servicio)
      ->first();

      $up = $query->unitario_pagado_correccion;
      $vp = $query->unitario_pagado_correccion;
      $upc = $query->valor_proveedor;

      $utilidad = $query->total_cobrado-$up;

      $update = DB::table('facturacion')
      ->where('servicio_id',$id_servicio)
      ->update([
        'estado_correccion' => 3,
        'aceptado_liquidado' => 1,
        'unitario_pagado' => $up,
        'total_pagado' => $up,
        'utilidad' => $utilidad,
        'valor_proveedor' => $vp,
        'unitario_pagado_correccion' =>$upc
      ]);

      /*CAMBIO DE VALOR EN AP*/
      $sub = DB::table('servicios')
      ->where('id',$id_servicio)
      ->pluck('subcentrodecosto_id');

      $consulta = DB::table('ap')
      ->where('id_cuenta',$cuenta_id)
      ->where('subcentrodecosto',$sub)
      ->first();

      $modificacio_ap = DB::table('ap')
      ->where('id_cuenta',$cuenta_id)
      ->where('subcentrodecosto',$sub)
      ->update([
          'valor' => $consulta->valor-$upc+$up,
          'valor_corregido' => $consulta->valor_corregido-$upc+$up
      ]);
      /*FIN CAMBIO DE VALOR EN AP*/

      if($update){

        return Response::json([
          'respuesta' => true,
          'id_servicio' => $id_servicio
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    /*
    public function postAceptarcorreccion(){

      $cuenta_id = Input::get('cuenta_id');
      $id_servicio = Input::get('id_servicio');

      $query = DB::table('facturacion')
      ->where('servicio_id',$id_servicio)
      ->first();

      $update = DB::table('facturacion')
      ->where('servicio_id',$id_servicio)
      ->update([
        'estado_correccion' => 2,
        'aceptado_liquidado' => 1,
        'unitario_pagado' => $query->unitario_pagado_correccion,
        'total_pagado' => $query->unitario_pagado_correccion,
        'unitario_pagado_correccion' => $query->unitario_pagado
      ]);


      $sub = DB::table('servicios')
      ->where('id',$id_servicio)
      ->pluck('subcentrodecosto_id');

      $consulta = DB::table('ap')
      ->where('id_cuenta',$cuenta_id)
      ->where('subcentrodecosto',$sub)
      ->first();

      $modificacio_ap = DB::table('ap')
      ->where('id_cuenta',$cuenta_id)
      ->where('subcentrodecosto',$sub)
      ->update([
          'valor' => $consulta->valor-$query->unitario_pagado+$query->unitario_pagado_correccion,
          'valor_corregido' => $consulta->valor-$query->unitario_pagado+$query->unitario_pagado_correccion
      ]);


      if($update){

        return Response::json([
          'respuesta' => true,
          'id_servicio' => $id_servicio
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }*/

    /*NO ACEPTAR CORRECCIÓN*/
    public function postNoaceptarcorreccion(){

      $cuenta_id = Input::get('cuenta_id');
      $id_servicio = Input::get('id_servicio');

      $query = DB::table('facturacion')
      ->where('servicio_id',$id_servicio)
      ->first();

      $update = DB::table('facturacion')
      ->where('servicio_id',$id_servicio)
      ->update([
        'estado_correccion' => 4
      ]);

      /*CAMBIO DE VALOR EN AP*/
      $sub = DB::table('servicios')
      ->where('id',$id_servicio)
      ->pluck('subcentrodecosto_id');

      $consulta = DB::table('ap')
      ->where('id_cuenta',$cuenta_id)
      ->where('subcentrodecosto',$sub)
      ->first();

      $modificacio_ap = DB::table('ap')
      ->where('id_cuenta',$cuenta_id)
      ->where('subcentrodecosto',$sub)
      ->update([
        'valor_corregido' => $consulta->valor_corregido-$query->unitario_pagado_correccion+$query->unitario_pagado
      ]);
      /*FIN CAMBIO DE VALOR EN AP*/

      if($update){

        return Response::json([
          'respuesta' => true,
          'id_servicio' => $id_servicio
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }
    }
    /*FIN NO ACEPTAR CORRECCIÓN*/

    //ACEPTAR CORRECCIONES TOTALES
    public function postAceptarcorreccionok(){

      $cuenta_id = Input::get('cuenta_id');

      /*$query = DB::table('listado_cuentas')
      ->where('id',$cuenta_id)
      ->first();*/

      $update = DB::table('listado_cuentas')
      ->where('id',$cuenta_id)
      ->update([
        'estado' => 2
      ]);

      if($update){

        $consulta = DB::table('listado_cuentas')
        ->where('estado',2)
        ->get();

        $contadora = count($consulta);

        /*NOTIFIVACIÓN PUSHER*/
        //Pusher
        $idpusher = "578229";
        $keypusher = "a8962410987941f477a1";
        $secretpusher = "6a73b30cfd22bc7ac574";

        //CANAL DE NOTIFICACIÓN DE RECONFIRMACIONES
        $channel = 'contabilidad';
        $name = 'cuentares';

        $data = json_encode([
        //'proceso' => 1,
        'cantidad' => $contadora
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

        /* FIN NOTIFICACIÓN PUSHER*/

        return Response::json([
          'respuesta' => true,
          'cuenta_id' => $cuenta_id
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'cuenta_id' => $cuenta_id
        ]);

      }

    }

    public function getListadocuentas(){
      $id=19;
      $id_rol = Sentry::getUser()->id_rol;
      $id_proveedor = Sentry::getUser()->proveedor_id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $nombre_cliente = DB::table('centrosdecosto')
      ->where('id',$id)
      ->pluck('razonsocial');

      $rutas_programadas = DB::table('servicios')
      ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
      ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
      ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
      ->join('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
      ->join('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->join('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
      ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
      ->select('rutas.nombre_ruta','rutas.codigo_ruta',
          'servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.id',
          'servicios.fecha_servicio', 'servicios.fecha_orden', 'servicios.hora_servicio','servicios.centrodecosto_id','servicios.ciudad','servicios.ruta_id', 'servicios.ruta',
          'proveedores.razonsocial',
          'vehiculos.placa','vehiculos.marca','vehiculos.clase',
          'facturacion.numero_planilla','facturacion.observacion','facturacion.facturado','facturacion.cambios_servicio',
          'facturacion.cod_centro_costo', 'facturacion.total_pagado',
          'conductores.nombre_completo', 'subcentrosdecosto.nombresubcentro', 'centrosdecosto.razonsocial as razoncentro')
      //->where('servicios.centrodecosto_id',$id)
      ->where('proveedores.id',$id_proveedor)
      ->whereNotNull('facturacion.liquidado')
      //->where('servicios.subcentrodecosto_id',$subcentrodecosto_id)
      ->whereBetween('fecha_servicio',['20210401','20210422'])
      ->whereNull('pendiente_autori_eliminacion')
      //->where('pasajeros',$pax)
      ->get();

      //nuevo
      $rutas_programadas = DB::table('listado_cuentas')
      ->leftJoin('proveedores', 'proveedores.id', '=', 'listado_cuentas.proveedor')
      ->select('listado_cuentas.*', 'proveedores.razonsocial')
      ->get();

      return View::make('portalproveedores.listado_cuentas')
      ->with('nombre_cliente',$nombre_cliente)
      ->with('rutas_programadas',$rutas_programadas)
      ->with('permisos',$permisos)
      ->with('centrodecosto',$id);
    }

    //
    public function getDetails($id){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->contabilidad->factura_proveedores->ver)){
            $ver = 'on';//;$permisos->contabilidad->factura_proveedores->ver;
        }else{
            $ver = 'on';
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {
            $pago_proveedores_detalles = DB::table('facturacion')
                ->select('servicios.id','servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.pasajeros', 'servicios.detalle_recorrido', 'servicios.recoger_en', 'servicios.dejar_en', 'facturacion.observacion',
                    'facturacion.numero_planilla', 'facturacion.total_pagado', 'facturacion.pagado_real', 'ap.fecha_pago',
                    'ap.numero_factura as pfactura', 'ordenes_facturacion.numero_factura', 'ordenes_facturacion.consecutivo',
                    'ordenes_facturacion.ingreso', 'ordenes_facturacion.fecha_expedicion','ordenes_facturacion.id as id_orden_factura', 'centrosdecosto.razonsocial as razoncentro', 'subcentrosdecosto.nombresubcentro')
                ->leftJoin('servicios', 'facturacion.servicio_id', '=', 'servicios.id')
                ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
                ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                ->leftJoin('ordenes_facturacion', 'facturacion.factura_id', '=', 'ordenes_facturacion.id')
                ->leftJoin('ap', 'facturacion.pago_proveedor_id','=', 'ap.id')
                ->leftJoin('listado_cuentas', 'listado_cuentas.id', '=', 'facturacion.id_cuenta')
                ->where('facturacion.id_cuenta',$id)
                ->orderBy('servicios.centrodecosto_id', 'DESC')
                ->get();

            $pago_proveedores = DB::table('ap')
                ->select('centrosdecosto.razonsocial as centrodecostonombre', 'proveedores.razonsocial as proveedornombre',
                    'ap.id as idpago','ap.valor_no_cobrado','ap.consecutivo',
                    'users.first_name','users.last_name','ap.revisado','pagos.preparado',
                    'ap.fecha_expedicion', 'ap.numero_factura','ap.fecha_inicial', 'ap.observaciones',
                    'subcentrosdecosto.nombresubcentro','ap.valor','ap.fecha_final','ap.fecha_pago', 'listado_cuentas.id as id_cuenta', 'listado_cuentas.valor as valor_cuenta')
                ->leftJoin('listado_cuentas', 'listado_cuentas.id', '=', 'ap.id_cuenta')
                ->leftJoin('centrosdecosto', 'ap.centrodecosto', '=', 'centrosdecosto.id')
                ->leftJoin('proveedores', 'proveedores.id' , '=', 'listado_cuentas.proveedor')
                ->leftJoin('subcentrosdecosto', 'ap.subcentrodecosto', '=', 'subcentrosdecosto.id')
                ->leftJoin('users', 'ap.creado_por', '=', 'users.id')
                ->leftJoin('pagos', 'ap.id_pago', '=', 'pagos.id')
                //->where('ap.id',$id)
                ->where('ap.id_cuenta',$id)
                ->first();

            return View::make('portalproveedores.detalles_cuenta')
                ->with([
                    'pago_proveedores_detalles'=>$pago_proveedores_detalles,
                    'pago_proveedores'=>$pago_proveedores,
                    'permisos'=>$permisos
                ]);
        }

    }
    //

    public function getPdfcuenta($id){

      if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->contabilidad->factura_proveedores->ver)){
            $ver = 'on';//;$permisos->contabilidad->factura_proveedores->ver;
        }else{
            $ver = 'on';
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {
            $pago_proveedores_detalles = DB::table('facturacion')
            ->select('servicios.id','servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.pasajeros', 'servicios.detalle_recorrido', 'servicios.recoger_en', 'servicios.dejar_en', 'facturacion.observacion',
                    'facturacion.numero_planilla', 'facturacion.total_pagado', 'facturacion.pagado_real', 'ap.fecha_pago',
                    'ap.numero_factura as pfactura', 'ordenes_facturacion.numero_factura', 'ordenes_facturacion.consecutivo',
                    'ordenes_facturacion.ingreso', 'ordenes_facturacion.fecha_expedicion','ordenes_facturacion.id as id_orden_factura', 'centrosdecosto.razonsocial as razoncentro', 'subcentrosdecosto.nombresubcentro')
            ->leftJoin('servicios', 'facturacion.servicio_id', '=', 'servicios.id')
            ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
            ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
            ->leftJoin('ordenes_facturacion', 'facturacion.factura_id', '=', 'ordenes_facturacion.id')
            ->leftJoin('ap', 'facturacion.pago_proveedor_id','=', 'ap.id')
            ->leftJoin('listado_cuentas', 'listado_cuentas.id', '=', 'facturacion.id_cuenta')
            ->where('facturacion.id_cuenta',$id)
            ->orderBy('servicios.centrodecosto_id', 'DESC')
            ->get();

            $pago_proveedores = DB::table('ap')
                ->select('centrosdecosto.razonsocial as centrodecostonombre', 'proveedores.razonsocial as proveedornombre',
                    'ap.id as idpago','ap.valor_no_cobrado','ap.consecutivo',
                    'users.first_name','users.last_name','ap.revisado','pagos.preparado',
                    'ap.fecha_expedicion', 'ap.numero_factura','ap.fecha_inicial', 'ap.observaciones',
                    'subcentrosdecosto.nombresubcentro','ap.valor','ap.fecha_final','ap.fecha_pago', 'listado_cuentas.id as id_cuenta', 'listado_cuentas.valor as valor_cuenta')
                ->leftJoin('listado_cuentas', 'listado_cuentas.id', '=', 'ap.id_cuenta')
                ->leftJoin('centrosdecosto', 'ap.centrodecosto', '=', 'centrosdecosto.id')
                ->leftJoin('proveedores', 'proveedores.id' , '=', 'listado_cuentas.proveedor')
                ->leftJoin('subcentrosdecosto', 'ap.subcentrodecosto', '=', 'subcentrosdecosto.id')
                ->leftJoin('users', 'ap.creado_por', '=', 'users.id')
                ->leftJoin('pagos', 'ap.id_pago', '=', 'pagos.id')
                ->where('ap.id_cuenta',$id)
                ->first();

            return View::make('portalproveedores.pdf_cuenta')
            ->with([
              'pago_proveedores_detalles'=>$pago_proveedores_detalles,
              'pago_proveedores'=>$pago_proveedores,
              'permisos'=>$permisos,
              'radicado' =>$id
            ]);
        }
    }

    public function getDetalles($id){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->contabilidad->factura_proveedores->ver)){
            $ver = $permisos->contabilidad->factura_proveedores->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {
            $pago_proveedores_detalles = DB::table('facturacion')
                ->select('servicios.id','servicios.fecha_servicio', 'servicios.pasajeros', 'servicios.detalle_recorrido', 'servicios.recoger_en', 'servicios.dejar_en', 'facturacion.observacion',
                    'facturacion.numero_planilla', 'facturacion.total_pagado', 'facturacion.pagado_real', 'ap.fecha_pago',
                    'ap.numero_factura as pfactura', 'ordenes_facturacion.numero_factura', 'ordenes_facturacion.consecutivo',
                    'ordenes_facturacion.ingreso', 'ordenes_facturacion.fecha_expedicion','ordenes_facturacion.id as id_orden_factura', 'centrosdecosto.razonsocial as razoncentro', 'subcentrosdecosto.nombresubcentro')
                ->leftJoin('servicios', 'facturacion.servicio_id', '=', 'servicios.id')
                ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
                ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                ->leftJoin('ordenes_facturacion', 'facturacion.factura_id', '=', 'ordenes_facturacion.id')
                ->leftJoin('ap', 'facturacion.pago_proveedor_id','=', 'ap.id')
                ->leftJoin('listado_cuentas', 'listado_cuentas.id', '=', 'facturacion.id_cuenta')
                ->where('facturacion.id_cuenta',$id)->get();

            $pago_proveedores = DB::table('ap')
                ->select('centrosdecosto.razonsocial as centrodecostonombre', 'proveedores.razonsocial as proveedornombre',
                    'ap.id as idpago','ap.valor_no_cobrado','ap.consecutivo',
                    'users.first_name','users.last_name','ap.revisado','pagos.preparado',
                    'ap.fecha_expedicion', 'ap.numero_factura','ap.fecha_inicial', 'ap.observaciones',
                    'subcentrosdecosto.nombresubcentro','ap.valor','ap.fecha_final','ap.fecha_pago', 'listado_cuentas.id as id_cuenta', 'listado_cuentas.valor as valor_cuenta')
                ->leftJoin('listado_cuentas', 'listado_cuentas.id', '=', 'ap.id_cuenta')
                ->leftJoin('centrosdecosto', 'ap.centrodecosto', '=', 'centrosdecosto.id')
                ->leftJoin('proveedores', 'proveedores.id' , '=', 'listado_cuentas.proveedor')
                ->leftJoin('subcentrosdecosto', 'ap.subcentrodecosto', '=', 'subcentrosdecosto.id')
                ->leftJoin('users', 'ap.creado_por', '=', 'users.id')
                ->leftJoin('pagos', 'ap.id_pago', '=', 'pagos.id')
                //->where('ap.id',$id)
                ->where('ap.id_cuenta',$id)
                ->first();

            return View::make('portalproveedores.detalles_cuenta')
                ->with([
                    'pago_proveedores_detalles'=>$pago_proveedores_detalles,
                    'pago_proveedores'=>$pago_proveedores,
                    'permisos'=>$permisos
                ]);
        }

    }

    public function getDetalles1($id){
      //$id=19;
      $id_rol = Sentry::getUser()->id_rol;
      $id_proveedor = Sentry::getUser()->proveedor_id;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      $nombre_cliente = DB::table('centrosdecosto')
      ->where('id',$id)
      ->pluck('razonsocial');

      $rutas_programadas = DB::table('servicios')
      ->leftJoin('rutas', 'servicios.ruta_id', '=', 'rutas.id')
      ->join('proveedores', 'servicios.proveedor_id', '=', 'proveedores.id')
      ->join('conductores', 'servicios.conductor_id', '=', 'conductores.id')
      ->join('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
      ->join('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
      ->join('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
      ->leftJoin('facturacion','servicios.id', '=', 'facturacion.servicio_id')
      ->select('rutas.nombre_ruta','rutas.codigo_ruta',
          'servicios.detalle_recorrido','servicios.recoger_en','servicios.dejar_en','servicios.id',
          'servicios.fecha_servicio', 'servicios.fecha_orden', 'servicios.hora_servicio','servicios.centrodecosto_id','servicios.ciudad','servicios.ruta_id', 'servicios.ruta',
          'proveedores.razonsocial',
          'vehiculos.placa','vehiculos.marca','vehiculos.clase',
          'facturacion.numero_planilla','facturacion.observacion','facturacion.facturado','facturacion.cambios_servicio',
          'facturacion.cod_centro_costo', 'facturacion.total_pagado',
          'conductores.nombre_completo', 'subcentrosdecosto.nombresubcentro', 'centrosdecosto.razonsocial as razoncentro')
      //->where('servicios.centrodecosto_id',$id)
      ->where('proveedores.id',$id_proveedor)
      ->whereNotNull('facturacion.liquidado')
      //->where('servicios.subcentrodecosto_id',$subcentrodecosto_id)
      ->whereBetween('fecha_servicio',['20210401','20210422'])
      ->whereNull('pendiente_autori_eliminacion')
      //->where('pasajeros',$pax)
      ->get();

      //nuevo
      $rutas_programadas = DB::table('listado_cuentas')
      ->leftJoin('proveedores', 'proveedores.id', '=', 'listado_cuentas.proveedor')
      ->select('listado_cuentas.*', 'proveedores.razonsocial')
      ->get();

      return View::make('portalproveedores.listado_cuentas')
      ->with('nombre_cliente',$nombre_cliente)
      ->with('rutas_programadas',$rutas_programadas)
      ->with('permisos',$permisos)
      ->with('centrodecosto',$id);
    }

    public function postGuardarcuenta(){

      if(Request::ajax()){

        if(Sentry::check()){

          $id_serviciosArray = Input::get('dataidArray'); //ID DE LOS SERVICIOS
          $id_serviciosArray = explode(',', $id_serviciosArray); //CONVERSIÓN A ARRAY DE LOS ID DE SERVICIOS
          $valores_cobro = Input::get('valores_cobro'); //VALOR COBRADO DE CADA SERVICIO
          $valores_cobro = explode(',', $valores_cobro); //CONVERSIÓN A ARRAY DE LOS VALORES COBRADOS POR SERVICIO
          $centrodecosto_id = Input::get('centrodecosto'); //CENTRO DE COSTO

          /*$datos_pago = DB::table('datos_pago')
          ->where('id',1)
          ->first();*/

          /*CALCULAR LAS FECHAS DISPONIBLES PARA COBRAR START*/
          $fecha = explode('-', date('Y-m-d'));
          $mes = $fecha[1];

          $mes_actual = $mes;
          $mes_atras = $mes_actual-1;
          if($mes==='01'){
            $mes = '0';
            $last = '31';
          }else if($mes==='02'){
            $mes = '0';
            $last = '28';
          }else if($mes==='03'){
            $mes = '0';
            $last = '31';
          }else if($mes==='04'){
            $mes = '0';
            $last = '30';
          }else if($mes==='05'){
            $mes = '0';
            $last = '30';
          }else if($mes==='06'){
            $mes = '0';
            $last = '30';
          }else if($mes==='07'){
            $mes = '0';
            $last = '30';
          }else if($mes==='08'){
            $mes = '0';
            $last = '31';
          }else if($mes==='09'){
            $mes = '0';
            $last = '30';
          }else if($mes==='10'){
            $mes = '';
            $last = '31';
          }else if($mes==='11'){
            $mes = '';
            $last = '30';
          }else if($mes==='12'){
            $mes = '';
            $last = '31';
          }

          $mes_atras = $mes.$mes_atras;

          $fecha = explode('-', date('Y-m-d'));
          $ano = $fecha[0];

          $start_date = $ano.'-'.$mes_atras.'-01';
          $end_date = $ano.'-'.$mes_atras.'-'.$last;

          //Cambiar meses para pruebas
          $start_date = '2021-04-01';
          $end_date = '2021-04-22';

          $actual = DB::table('cuenta')
          ->where('id',1)
          ->first();

          $start_date = $actual->fecha_inicial;
          $end_date = $actual->fecha_final;//LEONELA

          /*CALCULAR LAS FECHAS DISPONIBLES PARA COBRAR END*/
          //$start_date = $datos_pago->fecha_inicio;
          //$end_date = $datos_pago->fecha_fin;
          //$fecha_pago = $datos_pago->fecha_pago;

          //CONSULTA DE LA ÚLTIMA AP
          $ultima_ap = "SELECT * FROM ap ORDER BY id DESC LIMIT 1";

          //CONSULTA DE LOS DIFERENTES SUBCENROS QUE TIENEN RUTA DEL CLIENTE ACTUAL
          $diferentes_subcentros = "SELECT DISTINCT subcentrodecosto_id FROM servicios left join facturacion on facturacion.servicio_id = servicios.id WHERE servicios.fecha_servicio BETWEEN '".$start_date."' AND '".$end_date."' AND servicios.centrodecosto_id = '".$centrodecosto_id."' and facturacion.liquidado is not null"; //CAMBIAR ESTADO A FACURADO

          $diferentes_subcentros = DB::select($diferentes_subcentros);

          //START PRIMERAS DOS LETRAS DE LOS NOMBRES DEL PROVEEDOR
          $name1 = Sentry::getUser()->first_name;
          $name2 = Sentry::getUser()->last_name;

          $name1 = substr($name1, 0,2);
          $name2 = substr($name2, 0,2);
          //END PRIMERAS DOS LETRAS DE LOS NOMBRES DEL PROVEEDOR

          $start_date = '2021-04-01'; //TRAER DE LA BASE DE DATOS
          $end_date = '2021-04-30'; //TRAER DE LA BASE DE DATOS
          //$fecha_pago = '2021-04-23'; //TRAER DE LA BASE DE DATOS

          $start_date = '2021-09-01';
          $end_date = '2021-09-30';

          //CICLO PARA GUARDAR LOS SERVICIOS EN LA AP DE CADA SUBCENTRO QUE TENGA SERVICIOS FACTURADOS, DISPONIBLES PARA PAGO.
          foreach ($diferentes_subcentros as $subcentro) {

            //ID DEL SUBCENTRO DE COSTO PARA GUARDAR EN LA TABLA PAGO_PROVEEDORES
            $subcentro_id = $subcentro->subcentrodecosto_id;

            $last_ap = DB::select($ultima_ap); //OBTENCIÓN DEL ÚLTIMO ID PARA LA CONCATENACIÓN EN EL NÚMERO DE FACTURA DE LAS DIFERENTES AP.

            foreach ($last_ap as $pago) {
              $ultimo_id = $pago->id;
            }

            //CREACIÓN DEL REGISTRO DE LAS AP
            $pago_proveedor = new Ap(); //INSTANCIA DE LA ENTIDAD DE LA TABLA
            $pago_proveedor->consecutivo = 'PENDIENTE'; //ID DEL CONSECUTIVO
            $pago_proveedor->numero_factura = $name1.$name2.$ultimo_id;//CONCATENACIÓN
            $pago_proveedor->fecha_expedicion = date('Y-m-d h:i:s'); //FECHA DE EXPEDICIÓN
            $pago_proveedor->fecha_pago = $fecha_pago; //FECHA DE PAGO
            $pago_proveedor->proveedor = Sentry::getUser()->proveedor_id; //ID DEL PROVEEDOR
            $pago_proveedor->centrodecosto = $centrodecosto_id; //CENTRO DE COSTO DEL SERVICIO
            $pago_proveedor->subcentrodecosto = $subcentro_id; //SUBCENTRO DE COSTO DEL SERVICIO
            $pago_proveedor->fecha_inicial = $start_date;
            $pago_proveedor->fecha_final = $end_date;
            $pago_proveedor->valor_no_cobrado = null;
            $pago_proveedor->subtotal_general = 0;
            $pago_proveedor->valor = 0;
            $pago_proveedor->creado_por = Sentry::getUser()->id;
            $pago_proveedor->observaciones = '';

            if($pago_proveedor->save()){

              $id = $pago_proveedor->id;
              $p = Ap::find($id);

              if(strlen($id)===1){
                  $p->consecutivo = 'AP0000'.$id;
              }elseif(strlen($id)===2){
                  $p->consecutivo = 'AP000'.$id;
              }elseif(strlen($id)===3){
                  $p->consecutivo = 'AP00'.$id;
              }elseif(strlen($id)===4){
                  $p->consecutivo = 'AP0'.$id;
              }else if(strlen($id)>4){
                  $p->consecutivo = 'AP'.$id;
              }

              //START GUARDADO DE REGISTROS DE PAGO_PROVEEDOR_ID EN LA TABLA DE FACTURACIÓN
              $cantidadArrays = count($id_serviciosArray);

              for($i=0; $i<$cantidadArrays; $i++){

                $facturacion = DB::table('facturacion')
                ->leftJoin('servicios', 'servicios.id', '=', 'facturacion.servicio_id')
                ->where('facturacion.servicio_id', $id_serviciosArray[$i])
                ->where('servicios.subcentrodecosto_id',$subcentro_id)
                ->update([
                  'facturacion.pago_proveedor_id' => $pago_proveedor->id,
                  'unitario_pagado'=>$valores_cobro[$i],
                  'total_pagado'=>$valores_cobro[$i]
                ]);

              }
              //END GUARDADO DE REGISTROS DE PAGO_PROVEEDOR_ID EN LA TABLA DE FACTURACIÓN

              $p->save();
              //SUMA DE SERVICIOS
              $consul = DB::table('facturacion')
              ->where('pago_proveedor_id',$p->id)
              ->get();
              $total_sub = 0;
              foreach ($consul as $consu) {
                $total_sub = $total_sub+$consu->total_pagado;
              }


              $update_pago_proveedor = DB::table('ap')
              ->where('id',$p->id)
              ->update([
                'valor' => $total_sub,
              ]);
            }
          }
          //
          return Response::json([
            'respuesta'=>true,
            'ids'=>$id_serviciosArray,
            'valor1'=>$id_serviciosArray[0],
            'last'=>$last_ap,
            'ultimo_id'=>$ultimo_id,
            'name1'=>$name1,
            'name2'=>$name2,
            'diferentes_subcentros'=>$diferentes_subcentros,
            'ultimo_cid'=>$subcentro_id,
            'facturacion'=>$facturacion,
            //'valores_cobro'=>$valores_cobro
          ]);
        }

      }

    }

    public function postGuardarcuentatotal(){

      if(Request::ajax()){

        if(Sentry::check()){

          $id_serviciosArray = Input::get('dataidArray'); //ID DE LOS SERVICIOS
          $id_serviciosArray = explode(',', $id_serviciosArray); //CONVERSIÓN A ARRAY DE LOS ID DE SERVICIOS
          $valores_cobro = Input::get('valores_cobro'); //VALOR COBRADO DE CADA SERVICIO
          $valores_cobro = explode(',', $valores_cobro); //CONVERSIÓN A ARRAY DE LOS VALORES COBRADOS POR SERVICIO
          $centrodecosto_id = Input::get('centrodecosto'); //CENTRO DE COSTO
          $id_proveedor = Sentry::getUser()->proveedor_id;
          $tipo_cuenta = Input::get('tipo_cuenta'); //TIPO DE CUENTA

          $last_ap = null;
          $ultimo_id = null;
          $subcentro_id = null;
          $facturacion = null;
          $ojo = null;
          $valor_cuenta = 0;

          if (Input::hasFile('seguridad_soc')){

            $lis = new ListadoCuenta();
            $lis->valor = 0;
            $lis->proveedor = 0;
            $lis->fecha_expedicion = date('Y-m-d H:i:s');
            $lis->estado = 5;
            $lis->save();

            $file_pdf = Input::file('seguridad_soc');
            $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());
            $ubicacion_pdf = 'biblioteca_imagenes/sss/cuentas/';
            $file_pdf->move($ubicacion_pdf, $lis->id.$name_pdf);

            $actual = DB::table('cuenta')
            ->where('id',1)
            ->first();

            $start_date = $actual->fecha_inicial;
            $end_date = $actual->fecha_final;

            //START PRIMERAS DOS LETRAS DE LOS NOMBRES DEL PROVEEDOR
            $name1 = Sentry::getUser()->first_name; //Primer nombre del proveedor
            $name2 = Sentry::getUser()->last_name; //Apellidos del proveedor

            $name1 = substr($name1, 0,2);
            $name2 = substr($name2, 0,2);
            //END PRIMERAS DOS LETRAS DE LOS NOMBRES DEL PROVEEDOR

            //NUEVO (OBTENCION DE LOS CLIENTES)
            $clientes = "SELECT DISTINCT centrodecosto_id FROM servicios left join facturacion on facturacion.servicio_id = servicios.id WHERE servicios.fecha_servicio BETWEEN '".$start_date."' AND '".$end_date."' AND servicios.proveedor_id = ".$id_proveedor." and facturacion.liquidado is not null and servicios.pendiente_autori_eliminacion is null";
            $clientes = DB::select($clientes);

            $objArray = [];
            $objArray2 = [];

            if($clientes){

              foreach ($clientes as $cliente) {

                $rs = DB::table('centrosdecosto')
                ->where('id',$cliente->centrodecosto_id)
                ->pluck('razonsocial');


                $array = $cliente->centrodecosto_id;
                array_push($objArray, $array);
                array_push($objArray2, $rs);
              }

            }
            //NUEVO (OBTENCIÓN DE LOS CLIENTES)
            for ($l=0; $l < count($objArray); $l++) {

              $centrodecosto_id = $objArray[$l];
              $ultima_ap = "SELECT * FROM ap ORDER BY id DESC LIMIT 1";

              //CONSULTA DE LOS DIFERENTES SUBCENROS QUE TIENEN RUTA DEL CLIENTE ACTUAL
              $diferentes_subcentros1 = "SELECT DISTINCT subcentrodecosto_id FROM servicios left join facturacion on facturacion.servicio_id = servicios.id WHERE servicios.fecha_servicio BETWEEN '".$start_date."' AND '".$end_date."'  AND servicios.proveedor_id = ".Sentry::getUser()->proveedor_id." AND servicios.centrodecosto_id = ".$centrodecosto_id." and facturacion.liquidado is not null and servicios.pendiente_autori_eliminacion is null"; //CAMBIAR ESTADO A FACURADO

              $diferentes_subcentros = DB::select($diferentes_subcentros1);

              //CICLO PARA GUARDAR LOS SERVICIOS EN LA AP DE CADA SUBCENTRO QUE TENGA SERVICIOS FACTURADOS, DISPONIBLES PARA PAGO.
              foreach ($diferentes_subcentros as $subcentro) {

                //ID DEL SUBCENTRO DE COSTO PARA GUARDAR EN LA TABLA PAGO_PROVEEDORES
                $subcentro_id = $subcentro->subcentrodecosto_id;

                $last_ap = DB::select($ultima_ap); //OBTENCIÓN DEL ÚLTIMO ID PARA LA CONCATENACIÓN EN EL NÚMERO DE FACTURA DE LAS DIFERENTES AP.

                foreach ($last_ap as $pago) {
                  $ultimo_id = $pago->id;
                }

                //CREACIÓN DEL REGISTRO DE LAS AP
                $pago_proveedor = new Ap();
                $pago_proveedor->consecutivo = 'PENDIENTE';
                $pago_proveedor->numero_factura = $name1.$name2.$ultimo_id;//CONCATENACIÓN
                $pago_proveedor->fecha_expedicion = date('Y-m-d h:i:s');
                $pago_proveedor->fecha_pago = '2021-04-23';
                $pago_proveedor->proveedor = Sentry::getUser()->proveedor_id;
                $pago_proveedor->centrodecosto = $centrodecosto_id;
                $pago_proveedor->subcentrodecosto = $subcentro_id;
                $pago_proveedor->fecha_inicial = $start_date;
                $pago_proveedor->fecha_final = $end_date;
                $pago_proveedor->valor_no_cobrado = null;
                $pago_proveedor->subtotal_general = 0;
                $pago_proveedor->valor = 0;
                $pago_proveedor->creado_por = Sentry::getUser()->id;
                $pago_proveedor->observaciones = '';
                $pago_proveedor->id_cuenta = $lis->id;

                if($pago_proveedor->save()){

                  $id = $pago_proveedor->id;
                  $p = Ap::find($id);

                  if(strlen($id)===1){
                      $p->consecutivo = 'AP0000'.$id;
                  }elseif(strlen($id)===2){
                      $p->consecutivo = 'AP000'.$id;
                  }elseif(strlen($id)===3){
                      $p->consecutivo = 'AP00'.$id;
                  }elseif(strlen($id)===4){
                      $p->consecutivo = 'AP0'.$id;
                  }else if(strlen($id)>4){
                      $p->consecutivo = 'AP'.$id;
                  }

                  //START GUARDADO DE REGISTROS DE PAGO_PROVEEDOR_ID EN LA TABLA DE FACTURACIÓN
                  $cantidadArrays = count($id_serviciosArray);
                  $ojo = 0;
                  $i=0;

                  for($i=0; $i<$cantidadArrays; $i++){

                    $facturacion = DB::table('facturacion')
                    ->leftJoin('servicios', 'servicios.id', '=', 'facturacion.servicio_id')
                    ->where('facturacion.servicio_id', $id_serviciosArray[$i])
                    ->where('servicios.centrodecosto_id',$centrodecosto_id)
                    ->where('servicios.subcentrodecosto_id',$subcentro_id)
                    ->update([
                      'facturacion.ap_id' => $pago_proveedor->id,
                      'valor_proveedor'=>$valores_cobro[$i],
                      //'total_pagado'=>$valores_cobro[$i],
                      'id_cuenta'=>$lis->id
                    ]);

                    $ojo++;

                  }
                  //END GUARDADO DE REGISTROS DE PAGO_PROVEEDOR_ID EN LA TABLA DE FACTURACIÓN

                  $p->save();
                  //SUMA DE SERVICIOS
                  $consul = DB::table('facturacion')
                  ->where('ap_id',$p->id)
                  ->get();
                  $total_sub = 0;

                  foreach ($consul as $consu) {
                    $total_sub = $total_sub+$consu->valor_proveedor;
                  }

                  $valor_cuenta = $valor_cuenta+$total_sub;

                  $update_pago_proveedor = DB::table('ap')
                  ->where('id',$p->id)
                  ->update([
                    'valor' => $total_sub,
                    'valor_corregido' => $total_sub,
                  ]);
                }
              }
            }

            $count = DB::table('listado_cuentas')
            ->where('id', $lis->id)
            ->update([
              'valor' => $valor_cuenta,
              'fecha_inicial' => $start_date,
              'fecha_final' => $end_date,
              'seguridad_social' => $lis->id.$name_pdf,
              'proveedor' => Sentry::getUser()->proveedor_id,
              'estado' => 0
            ]);

            return Response::json([
              'respuesta'=>true,
              'ids'=>$id_serviciosArray,
              'valor1'=>$id_serviciosArray[0],
            ]);

          }else{

            return Response::json([
              'respuesta'=>'no_file'
            ]);

          }

        }

      }

    }

    public function postAceptarcuenta(){
      $id = Input::get('id');

      $cuentas = DB::table('ap')
      ->where('id_cuenta',intval($id))
      ->get();

      foreach ($cuentas as $cuenta) {
        $pago_proveedor = new Pagoproveedor();
        $pago_proveedor->consecutivo = $cuenta->consecutivo;
        $pago_proveedor->numero_factura = $cuenta->numero_factura;
        $pago_proveedor->fecha_expedicion = $cuenta->fecha_expedicion;
        $pago_proveedor->fecha_pago = $cuenta->fecha_pago;
        $pago_proveedor->proveedor = $cuenta->proveedor;
        $pago_proveedor->centrodecosto = $cuenta->centrodecosto;
        $pago_proveedor->subcentrodecosto = $cuenta->subcentrodecosto;
        $pago_proveedor->fecha_inicial = $cuenta->fecha_inicial;
        $pago_proveedor->fecha_final = $cuenta->fecha_final;
        $pago_proveedor->valor = $cuenta->valor;
        $pago_proveedor->creado_por = $cuenta->creado_por;
        $pago_proveedor->save();
/*
        $update_pago = DB::table('facturacion')
        ->where('id_cuenta',$p->id)
        ->update([
          'valor' => $total_sub,
        ]);*/
      }
      if(intval($id)===11){
        return Response::json([
          'respuesta'=>true
        ]);
      }else{
        return Response::json([
          'respuesta'=>false
        ]);
      }
    }

    public function postCapacitacionth() {

      $id = Input::get('id');

      $search = DB::table('ingreso_conductores')
      ->where('id',$id)
      ->first();

      $update = DB::table('ingreso_conductores')
      ->where('id',$id)
      ->update([
        'cap_th' => 1
      ]);

      $habilitar = 0;

      if($search->cap_gestion===1 and $search->cap_juridica===1 and $search->cap_contabilidad===1 and $search->cap_sistemas===1 and $search->mantenimiento===1){
        $habilitar = 1;
      }

      if($update){

        return Response::json([
          'respuesta' => true,
          'id' => $id,
          'search' => $search,
          'habilitar' => $habilitar
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }


    }

    public function postCapacitaciongj() {

      $id = Input::get('id');

      $search = DB::table('ingreso_conductores')
      ->where('id',$id)
      ->first();

      $update = DB::table('ingreso_conductores')
      ->where('id',$id)
      ->update([
        'cap_juridica' => 1
      ]);

      $habilitar = 0;

      if($search->cap_gestion===1 and $search->cap_th===1 and $search->cap_contabilidad===1 and $search->cap_sistemas===1 and $search->mantenimiento===1){
        $habilitar = 1;
      }

      if($update){

        return Response::json([
          'respuesta' => true,
          'id' => $id,
          'search' => $search,
          'habilitar' => $habilitar
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }


    }

    public function postCapacitacionco() {

      $id = Input::get('id');

      $search = DB::table('ingreso_conductores')
      ->where('id',$id)
      ->first();

      $update = DB::table('ingreso_conductores')
      ->where('id',$id)
      ->update([
        'cap_contabilidad' => 1
      ]);

      $habilitar = 0;

      if($search->cap_gestion===1 and $search->cap_th===1 and $search->cap_juridica===1 and $search->cap_sistemas===1 and $search->mantenimiento===1){
        $habilitar = 1;
      }

      if($update){

        return Response::json([
          'respuesta' => true,
          'id' => $id,
          'search' => $search,
          'habilitar' => $habilitar
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }


    }

    public function postCapacitacionsi() {

      $id = Input::get('id');

      $search = DB::table('ingreso_conductores')
      ->where('id',$id)
      ->first();

      $update = DB::table('ingreso_conductores')
      ->where('id',$id)
      ->update([
        'cap_sistemas' => 1
      ]);

      $habilitar = 0;

      if($search->cap_gestion===1 and $search->cap_th===1 and $search->cap_juridica===1 and $search->cap_contabilidad===1 and $search->mantenimiento===1){
        $habilitar = 1;
      }

      if($update){

        return Response::json([
          'respuesta' => true,
          'id' => $id,
          'search' => $search,
          'habilitar' => $habilitar
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }


    }

    public function postCapacitacionma(){

      $id = Input::get('id');

      $search = DB::table('ingreso_conductores')
      ->where('id',$id)
      ->first();

      $update = DB::table('ingreso_conductores')
      ->where('id',$id)
      ->update([
        'mantenimiento' => 1
      ]);

      $habilitar = 0;

      if($search->cap_gestion===1 and $search->cap_th===1 and $search->cap_juridica===1 and $search->cap_contabilidad===1 and $search->cap_sistemas===1){
        $habilitar = 1;
      }

      if($update){

        return Response::json([
          'respuesta' => true,
          'id' => $id,
          'search' => $search,
          'habilitar' => $habilitar
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postCapacitaciongi() {

      $id = Input::get('id');

      $search = DB::table('ingreso_conductores')
      ->where('id',$id)
      ->first();

      $update = DB::table('ingreso_conductores')
      ->where('id',$id)
      ->update([
        'cap_gestion' => 1
      ]);

      $habilitar = 0;

      if($search->mantenimiento===1 and $search->cap_th===1 and $search->cap_juridica===1 and $search->cap_contabilidad===1 and $search->cap_sistemas===1){
        $habilitar = 1;
      }

      if($update){

        return Response::json([
          'respuesta' => true,
          'id' => $id,
          'search' => $search,
          'habilitar' => $habilitar
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }


    }

    public function getGenerarfuec(){

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
            $ver = 'on';
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {

          $usuario = Sentry::getUser()->proveedor_id;

          $localidad = DB::table('proveedores')->where('id',$usuario)->pluck('localidad');

          if($localidad=='barranquilla'){
            $dato1 = 'SANTA MARTA';
            $dato2 = 'CARTAGENA';
          }else{
            $dato1 = 'SOACHA';
            $dato2 = 'USME';
          }

          $query = "SELECT * FROM rutas_fuec WHERE origen LIKE '%".$localidad."%' OR destino LIKE '%".$localidad."%' OR destino LIKE '%".$dato1."%' OR origen LIKE '%".$dato1."%' OR destino LIKE '%".$dato2."%' OR origen LIKE '%".$dato2."%'";

          $rutas_fuec = DB::select($query);

          $array = [
            'rutas_fuec' => $rutas_fuec,
            'permisos' => $permisos
          ];
          return View::make('portalproveedores.fuec.generar_fuec',$array);
      }
    }

    public function postProveedores(){

      $localidad = Input::get('ciudad');
      $id = Input::get('id');

      /*CONDUCTORES: FALTA EXÁMENES*/
      /*VEHÍCULOS: FALTA ADMINISTRACIÓN*/

      $proveedores = DB::table('proveedores')
      ->leftJoin('conductores', 'conductores.proveedores_id', '=', 'proveedores.id')
      ->leftJoin('vehiculos', 'vehiculos.proveedores_id', '=', 'proveedores.id')
      ->select('proveedores.*', 'vehiculos.id as id_vehiculo', 'vehiculos.placa', 'vehiculos.fecha_vigencia_operacion', 'vehiculos.fecha_vigencia_soat', 'vehiculos.fecha_vigencia_tecnomecanica', 'vehiculos.mantenimiento_preventivo', 'vehiculos.poliza_contractual','vehiculos.poliza_extracontractual', 'conductores.id as id_conductor', 'conductores.nombre_completo', 'conductores.fecha_licencia_vigencia')
      //->where('proveedores.localidad', $localidad)
      ->where('proveedores.id',$id)
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

    public function getVer(){

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
            $ver = 'on';
        }

        if (!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {

          return View::make('admin.permisos');

        }else {

            $vehiculo = Vehiculo::find(312);

            $fecha = date('Y-m-d');

            $consulta = "SELECT fuec.*, conductores.nombre_completo, contratos.nit_contratante, contratos.contratante, contratos.numero_contrato, rutas_fuec.origen, rutas_fuec.destino FROM fuec left join contratos on contratos.id = fuec.contrato_id left join rutas_fuec on rutas_fuec.id = fuec.ruta_id left join conductores on conductores.id = fuec.conductor WHERE '".$fecha."' BETWEEN DATE(fuec.created_at) AND fecha_final AND FIND_IN_SET('".Sentry::getUser()->proveedor_id."', proveedor) > 0 ORDER BY id DESC";

            $fuec = DB::select($consulta);

            /*
            $fuec = DB::table('fuec')
            ->select('fuec.id','contratos.numero_contrato', 'contratos.contratante','contratos.nit_contratante',
            'fuec.fecha_inicial','fuec.fecha_final','fuec.consecutivo', 'rutas_fuec.origen', 'rutas_fuec.destino')
            ->leftJoin('contratos', 'fuec.contrato_id', '=', 'contratos.id')
            ->leftJoin('rutas_fuec', 'fuec.ruta_id', '=', 'rutas_fuec.id')
            ->where('fuec.vehiculo',$id)
            ->orderBy('id', 'desc')
            ->get();*/

            return View::make('portalproveedores.fuec.verfuec')
            ->with([
                'fuec' => $fuec,
                'vehiculo' => $vehiculo,
                'permisos' => $permisos
            ]);

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

    public function postFiltroclientes() {

      $usuario = Sentry::getUser()->proveedor_id;

      $localidad = DB::table('proveedores')->where('id',$usuario)->pluck('localidad');

      $clientes = DB::table('centrosdecosto')
      ->whereIn('localidad', [$localidad,'provisional'])
      ->whereNull('inactivo')
      ->whereNull('inactivo_total')
      ->get();

      return Response::json([
        'response' => true,
        'clientes' => $clientes,
        'localidad' => $localidad
      ]);

    }

    public function getPdfdownload($id){

      $pago_proveedores_detalles = DB::table('facturacion')
            ->select('servicios.id','servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.pasajeros', 'servicios.detalle_recorrido', 'servicios.recoger_en', 'servicios.dejar_en', 'facturacion.observacion',
                    'facturacion.numero_planilla', 'facturacion.total_pagado', 'facturacion.pagado_real', 'ap.fecha_pago',
                    'ap.numero_factura as pfactura', 'ordenes_facturacion.numero_factura', 'ordenes_facturacion.consecutivo',
                    'ordenes_facturacion.ingreso', 'ordenes_facturacion.fecha_expedicion','ordenes_facturacion.id as id_orden_factura', 'centrosdecosto.razonsocial as razoncentro', 'subcentrosdecosto.nombresubcentro')
            ->leftJoin('servicios', 'facturacion.servicio_id', '=', 'servicios.id')
            ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
            ->leftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
            ->leftJoin('ordenes_facturacion', 'facturacion.factura_id', '=', 'ordenes_facturacion.id')
            ->leftJoin('ap', 'facturacion.pago_proveedor_id','=', 'ap.id')
            ->leftJoin('listado_cuentas', 'listado_cuentas.id', '=', 'facturacion.id_cuenta')
            ->where('facturacion.id_cuenta',$id)
            ->orderBy('servicios.centrodecosto_id', 'DESC')
            ->orderBy('servicios.fecha_servicio')
            ->orderBy('servicios.hora_servicio')
            ->get();

            $pago_proveedores = DB::table('ap')
                ->select('centrosdecosto.razonsocial as centrodecostonombre', 'proveedores.razonsocial as proveedornombre', 'proveedores.nit',
                    'ap.id as idpago','ap.valor_no_cobrado','ap.consecutivo',
                    'users.first_name','users.last_name','ap.revisado','pagos.preparado',
                    'ap.fecha_expedicion', 'ap.numero_factura','ap.fecha_inicial', 'ap.observaciones',
                    'subcentrosdecosto.nombresubcentro','ap.valor','ap.fecha_final','ap.fecha_pago', 'listado_cuentas.id as id_cuenta', 'listado_cuentas.valor as valor_cuenta')
                ->leftJoin('listado_cuentas', 'listado_cuentas.id', '=', 'ap.id_cuenta')
                ->leftJoin('centrosdecosto', 'ap.centrodecosto', '=', 'centrosdecosto.id')
                ->leftJoin('proveedores', 'proveedores.id' , '=', 'listado_cuentas.proveedor')
                ->leftJoin('subcentrosdecosto', 'ap.subcentrodecosto', '=', 'subcentrosdecosto.id')
                ->leftJoin('users', 'ap.creado_por', '=', 'users.id')
                ->leftJoin('pagos', 'ap.id_pago', '=', 'pagos.id')
                ->where('ap.id_cuenta',$id)
                ->first();

                //'pago_proveedores_detalles'=>$pago_proveedores_detalles,
              //'pago_proveedores'=>$pago_proveedores,
              //'permisos'=>$permisos,
              //'radicado' =>$id

      $html = View::make('portalproveedores.pdf_cuenta')
        ->with(['pago_proveedores_detalles'=>$pago_proveedores_detalles, 'pago_proveedores'=>$pago_proveedores, 'radicado'=> $id]);


        return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('CUENTA DE COBRO # '.$id);

    }
    /*GESTIÓN DE FUNCIONES END*/

    public function postAgregarconductor () {

      $conductor = new IngresoConductor;
      //$conductor->fecha_vinculacion = date('Y-m-d');
      $conductor->departamento = Input::get('departamento');
      $conductor->ciudad = Input::get('ciudad');
      $conductor->nombre_completo = strtoupper(Input::get('nombre_completo'));
      $conductor->cc = Input::get('cc');
      $conductor->celular = Input::get('celular');
      $conductor->direccion = strtoupper(Input::get('direccion'));
      $conductor->tipo_licencia = Input::get('tipo_licencia');
      $conductor->fecha_expedicion = Input::get('fecha_expedicion');
      $conductor->fecha_vigencia = Input::get('fecha_vigencia');
      $conductor->edad = Input::get('edad');
      $conductor->genero = Input::get('genero');
      $conductor->experiencia = Input::get('experiencia');
      $conductor->accidentes_encinco = Input::get('accidentes');
      $conductor->descripcion_accidente = strtoupper(Input::get('descripcion_accidentes'));
      $conductor->proveedor_id = Sentry::getUser()->proveedor_id;
      $conductor->estado_aprobado = 0;
      //$conductor->creado_por = 2;
      //$conductor->estado_aplicacion = 0;
      //$conductor->estado = 'ACTIVO';

      //CÉDULA
      if (Input::hasFile('pdf_cc_conductor')){

        $file_pdf = Input::file('pdf_cc_conductor');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/cc/';

        $file_pdf->move($ubicacion_pdf, $name_pdf);
        $conductor->pdf_cc = $ubicacion_pdf.$name_pdf;

      }

      //LICENCIA
      if (Input::hasFile('pdf_licencia_conductor')){

        $file_pdf = Input::file('pdf_licencia_conductor');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/licencias/';

        $file_pdf->move($ubicacion_pdf, $name_pdf);
        $conductor->pdf_licencia = $ubicacion_pdf.$name_pdf;

      }

      //SEGURIDAD SOCIAL
      if (Input::hasFile('pdf_ss')){

        $file_pdf = Input::file('pdf_ss');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores/seguridadsocial/';

        $file_pdf->move($ubicacion_pdf, $name_pdf);
        $conductor->seguridad_social = $ubicacion_pdf.$name_pdf;

      }

      //SEGURIDAD SOCIAL
      if (Input::hasFile('fotoc')){

        $file_pdf = Input::file('fotoc');
        $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

        $ubicacion_pdf = 'biblioteca_imagenes/prov_nuevos/documentacion/conductores';

        $file_pdf->move($ubicacion_pdf, $name_pdf);
        $conductor->foto_conductor = $ubicacion_pdf.$name_pdf;

      }

      $conductor->save();

      $email = 'juridica@aotour.com.co'; //Correo de contabilidad y link de acceso directo
      $data = [
        'razonsocial' => Sentry::getUser()->first_name,
        'conductor' => strtoupper(Input::get('nombre_completo'))
      ];
      Mail::send('portalproveedores.emails.conductor_nuevo', $data, function($message) use ($email){
        $message->from('no-reply@aotour.com.co', 'PORTAL PROVEEDORES');
        $message->to($email)->subject('Nuevo conductor agregado');
        $message->bcc('aotourdeveloper@gmail.com');
      });

      return Response::json([
        'respuesta' => true
      ]);

    }

    public function postValidarcedula() {

      $cedula = Input::get('cedula');

      $conductor = DB::table('conductores')
      ->where('cc',$cedula)
      //->whereNull()
      ->first();

      if($conductor) {

        if($conductor->proveedores_id!=45){

          return Response::json([
            'respuesta' => 'ocupado',
            'conductor' => $conductor
          ]);

        }else{

          return Response::json([
            'respuesta' => true,
            'conductor' => $conductor
          ]);

        }
        

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postEnlazarusuario() {

      $id = Input::get('id');
      $update = DB::table('conductores')
      ->where('id',$id)
      ->update([
        'proveedores_id' => Sentry::getUser()->proveedor_id
      ]);

      $nombreConductor = DB::table('conductores')
      ->where('id',$id)
      ->pluck('nombre_completo');

      //Envío de correo a jurídica y operaciones, de la vinculación del conductor
      $data = [
        'nombre_proveedor' => Sentry::getUser()->first_name,
        'nombre_conductor' => $nombreConductor
      ];

      $emailcc = ['aotourdeveloper@gmail.com'];
      $email = 'juridica@aotour.com.co';

      Mail::send('emails.vinculacion_conductor', $data, function($message) use ($email, $emailcc){
        $message->from('no-reply@aotour.com.co', 'PORTAL PROVEEDORES');
        $message->to($email)->subject('Vinculación de Conductor Existente');
        $message->cc($emailcc);
      });
      //Envío de correo a jurídica y operaciones, de la vinculación del conductor

      $usuarioId = DB::table('conductores')
      ->where('id',$id)
      ->pluck('usuario_id');

      $update = DB::table('users')
      ->where('id',$usuarioId)
      ->update([
        'baneado' => null,
        'baneado_por' => null,
        'baneado_en' => null
      ]);

      return Response::json([
        'respuesta' => true
      ]);

    }

    public function postDesvincularconductor() {

      $id = Input::get('id');

      $update = DB::table('conductores')
      ->where('id',$id)
      ->update([
        'proveedores_id' => 45
      ]);

      if($update){ //desvincular el vehiculo que tenga asignado y sacar de la APP UP DRIVER

        $vehiculosUpdate = DB::table('vehiculos')
        ->where('conductores_id', $id)
        ->update([
          'conductores_id' => null
        ]);
        //Sacar del usuario de UP DRIVER -PENDIENTE-

        $nombreConductor = DB::table('conductores')
        ->where('id',$id)
        ->pluck('nombre_completo');

        $number = DB::table('conductores')
        ->where('id',$id)
        ->pluck('celular');

        //Envío de correo a jurídica y operaciones, de la vinculación del conductor
        $data = [
          'nombre_proveedor' => Sentry::getUser()->first_name,
          'nombre_conductor' => $nombreConductor
        ];

        $emailcc = ['aotourdeveloper@gmail.com'];
        $email = 'juridica@aotour.com.co';

        /*Mail::send('emails.desvinculacion_conductor', $data, function($message) use ($email, $emailcc){
          $message->from('no-reply@aotour.com.co', 'PORTAL PROVEEDORES');
          $message->to($email)->subject('Desvinculación de Conductor');
          $message->cc($emailcc);
        });*/
        //Envío de correo a jurídica y operaciones, de la vinculación del conductor

        //Push para informarle al usuario que su app quedó desactivada
        Servicio::Desvincularconductor($id); //Función para que se enví la notificación push

        //Función para que se enví la notificación por wpp cel del conductor -PENDIENTE-

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
          \"messaging_product\": \"whatsapp\",
          \"to\": \"".$number."\",
          \"type\": \"template\",
          \"template\": {
            \"name\": \"desvin\",
            \"language\": {
              \"code\": \"es\",
            }
          }
        }");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type: application/json",
          "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $usuarioId = DB::table('conductores')
        ->where('id',$id)
        ->pluck('usuario_id');

        $update = DB::table('users')
        ->where('id',$usuarioId)
        ->update([
          'baneado' => 1,
          'baneado_por' => Sentry::getUser()->id,
          'baneado_en' => date('Y-m-d H:i:s')
        ]);
        //Push pasa informarle al usuario que su app quedó desactivada

      }

      return Response::json([
        'respuesta' => true,
        'id' => $id
      ]);

    }

    public function getAprobar($id){ //RECHAZO DE DOCUMENTOS

      $consulta = DB::table('vehiculos')
      ->leftJoin('conductores', 'conductores.id', '=', 'vehiculos.estado_conductor')
      ->leftJoin('proveedores', 'proveedores.id', '=', 'vehiculos.proveedores_id')
      ->select('vehiculos.*', 'conductores.nombre_completo', 'proveedores.razonsocial')
      ->where('vehiculos.estado_conductor',$id)
      ->first();

      if($consulta){

        return View::make('portalproveedores.conductores.aprobar')
        ->with('id',$id)
        ->with('vehiculo',$consulta);

      }else{
        return View::make('portalproveedores.conductores.datos_enviados');
      }
    }

    public function postAprobar() {

      $id = Input::get('id');
      $placa = Input::get('placa');

      $update = DB::table('vehiculos')
      ->where('estado_conductor',$id)
      ->update([
        'conductores_id' => $id,
        'estado_conductor' => null
      ]);

      if($update){

        $nombreConductor = DB::table('conductores')
        ->where('id',$id)
        ->pluck('nombre_completo');
        
        //Enviar correo al proveedor de la APROVACIÓN
        $data = [
          'placa' => $placa,
          'nombreConductor' => $nombreConductor
        ];

        $id_proveedor = DB::table('conductores')
        ->where('id',$id)
        ->pluck('proveedores_id');

        $email = DB::table('proveedores')
        ->where('id',$id_proveedor)
        ->pluck('email');

        Mail::send('emails.conductor_vehiculo_aprobado', $data, function($message) use ($email, $nombreConductor){
          $message->from('no-reply@aotour.com.co', 'Aotour - Asignación APROBADA');
          $message->to($email)->subject('Tu cambio fue aprobado');
          $message->cc(['aotourdeveloper@gmail.com']);
        });
        //Enviar correo al proveedor de la APROVACIÓN end

        return Response::json([
          'respuesta' => true
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postNoaprobar() {

      $id = Input::get('id');
      $placa = Input::get('placa');

      $update = DB::table('vehiculos')
      ->where('estado_conductor',$id)
      ->update([
        'estado_conductor' => null
      ]);

      if($update){

        $nombreConductor = DB::table('conductores')
        ->where('id',$id)
        ->pluck('nombre_completo');

        //Enviar correo al proveedor de la no APROVACIÓN
        $data = [
          'placa' => $placa,
          'nombreConductor' => $nombreConductor
        ];

        $id_proveedor = DB::table('conductores')
        ->where('id',$id)
        ->pluck('proveedores_id');

        $email = DB::table('proveedores')
        ->where('id',$id_proveedor)
        ->pluck('email');

        Mail::send('emails.conductor_vehiculo_noaprobado', $data, function($message) use ($email, $nombreConductor){
          $message->from('no-reply@aotour.com.co', 'Aotour - Asignación NO APROBADA');
          $message->to($email)->subject('Tu cambio NO fue aprobado');
          $message->cc(['aotourdeveloper@gmail.com']);
        });
        //Enviar correo al proveedor de la no APROVACIÓN end

        return Response::json([
          'respuesta' => true
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postAsignarvehiculo() {

      $id_conductor = Input::get('id_conductor');
      $id_vehiculo = Input::get('id_vehiculo');

      $update = DB::table('vehiculos')
      ->where('id',$id_vehiculo)
      ->update([
          'estado_conductor' => $id_conductor
      ]);

      $nombreConductor = DB::table('conductores')
      ->where('id',$id_conductor)
      ->pluck('nombre_completo');

      $placa = DB::table('vehiculos')
      ->where('id',$id_vehiculo)
      ->pluck('placa');

      $nombreProveedor = Sentry::getUser()->first_name;

      //Enviar Emails
      $data = [
        'placa' => $placa,
        'nombreConductor' => $nombreConductor,
        'nombreProveedor' => $nombreProveedor,
        'id' => $id_conductor
      ];

      $id_proveedor = DB::table('conductores')
      ->where('id',$id_conductor)
      ->pluck('proveedores_id');

      $localidad = DB::table('proveedores')
      ->where('id',$id_proveedor)
      ->pluck('localidad');

      if($localidad!=null) {
        $email = 'jefedetransportebog@aotour.com.co';
      }else{
        $email = 'jefedetransporte@aotour.com.co';
      }

      //$email = 'sistemas@aotour.com.co';

      Mail::send('emails.conductor_vehiculo', $data, function($message) use ($email, $nombreConductor){
        $message->from('no-reply@aotour.com.co', 'Asignación de Vehículo');
        $message->to($email)->subject('Se ha asignado un vehículo a '.$nombreConductor);
        $message->cc(['aotourdeveloper@gmail.com']);
      });
      //Enviar Emails

      if($update) {

          return Response::json([
            'respuesta' => true,
            'id_conductor' => $id_conductor,
            'id_vehiculo' => $id_vehiculo
          ]);

      }else{

          return Response::json([
            'respuesta' => false,
            'id_conductor' => $id_conductor,
            'id_vehiculo' => $id_vehiculo
          ]);
      }

    }

    public function postDesasignarvehiculo() {

      $id_conductor = Input::get('id_conductor');
      $id_vehiculo = Input::get('id_vehiculo');

      $update = DB::table('vehiculos')
      ->where('id',$id_vehiculo)
      ->update([
          'conductores_id' => null
      ]);

      if($update) {

          return Response::json([
            'respuesta' => true,
            'id_conductor' => $id_conductor,
            'id_vehiculo' => $id_vehiculo
          ]);

      }else{

          return Response::json([
            'respuesta' => false,
            'id_conductor' => $id_conductor,
            'id_vehiculo' => $id_vehiculo
          ]);
      }

    }

    //SERVICIOS DE PROVEEDORES
    public function getProgramaciones(){

      if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->otrostransporte->otrostransporte->ver)){
          $ver = 'on';
        }else{
          $ver = 'on';
        }

        if (!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on') {

          return View::make('admin.permisos');

        }else{

          $id_proveedor = Sentry::getUser()->proveedor_id;

          $query = Servicio::select('servicios.*', 'facturacion.revisado','facturacion.liquidado','facturacion.facturado','facturacion.factura_id',
                    'proveedores.tipo_afiliado', 'centrosdecosto.razonsocial', 'centrosdecosto.localidad', 'subcentrosdecosto.nombresubcentro','users.first_name',
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
              //->where('centrosdecosto.localidad','')
              ->whereRaw('(servicios.cancelado=0 or servicios.cancelado is null)')
              ->whereNull('servicios.pendiente_autori_eliminacion')
              ->whereNull('servicios.afiliado_externo')
              ->where('servicios.proveedor_id',$id_proveedor)
              ->where('fecha_servicio',date('Y-m-d'));

          $servicios = $query->orderBy('hora_servicio')->get();

          $proveedores = Proveedor::Afiliadosinternos()
          ->orderBy('razonsocial')
          ->where('tipo_servicio', 'TRANSPORTE TERRESTRE')
          ->whereNull('inactivo_total')
          ->whereNull('inactivo')
          ->get();

          $centrosdecosto = Centrodecosto::Internos()->orderBy('razonsocial')->get();

          $subcentros = DB::table('subcentrosdecosto')->orderBy('nombresubcentro')->get();
          $departamentos = DB::table('departamento')->get();
          $ciudades = DB::table('ciudad')->orderBy('ciudad')->get();
          $rutas = DB::table('rutas')->get();
          $usuarios = DB::table('users')->where('coordinador',1)->where('activated',1)->get();

          $cotizaciones = DB::table('cotizaciones')->where('estado',1)->orderBy('created_at', 'desc')->take(10)->get();

          return View::make('portalproveedores.servicios.transportes_servicios_rutas')
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

    public function postBuscarservicios(){

      $id_rol = Sentry::getUser()->id_rol;
      $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
      $permisos = json_decode($permisos);

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          if (Request::ajax()){

              $fecha_inicial = Input::get('fecha_inicial');
              $fecha_final = Input::get('fecha_final');
              $servicio = intval(Input::get('servicios'));
              $proveedores = Input::get('proveedores');
              $conductores = Input::get('conductores');
              $option = Input::get('option');

              if ($conductores===null) {
                  $conductores = 0;
              }

              $centrodecosto = Input::get('centrodecosto');

              $subcentro = Input::get('subcentrodecosto');

              if ($subcentro===null) {
                  $subcentro=0;
              }

              $ciudades = Input::get('ciudades');
              $usuarios = Input::get('usuario');
              $codigo = Input::get('codigo');
              $tipo_usuario = Sentry::getUser()->id_tipo_usuario;
              $id_proveedor = Sentry::getUser()->proveedor_id;

              $consulta = "select servicios.id, servicios.ruta_qr, servicios.fecha_orden, servicios.fecha_servicio, servicios.solicitado_por, servicios.programado_app, ".
                  "servicios.resaltar, servicios.pago_directo, servicios.fecha_solicitud, servicios.ciudad, servicios.recoger_en, servicios.ruta, ".
                  "servicios.dejar_en, servicios.detalle_recorrido, servicios.pasajeros, servicios.pasajeros_ruta, servicios.finalizado, servicios.pendiente_autori_eliminacion, ".
                  "servicios.hora_servicio, servicios.origen, servicios.destino, servicios.fecha_pago_directo, servicios.rechazar_eliminacion, ".
                  "servicios.estado_servicio_app, servicios.recorrido_gps, servicios.calificacion_app_conductor_calidad, ".
                  "servicios.calificacion_app_conductor_actitud, servicios.calificacion_app_cliente_calidad, servicios.calificacion_app_cliente_actitud, ".
                  "servicios.aerolinea, servicios.vuelo, servicios.hora_salida, servicios.hora_llegada, servicios.aceptado_app, servicios.localidad as loc, ".
                  "servicios.cancelado, pago_proveedores.consecutivo as pconsecutivo, pagos.autorizado, ".
                  "servicios_edicion_pivote.id as servicios_id_pivote, ordenes_facturacion.id as idordenfactura, ".
                  "reportes_pivote.id as reportes_id_pivote, pago_proveedores.id as pproveedorid, ".
                  "reconfirmacion.ejecutado, reconfirmacion.numero_reconfirmaciones, ".
                  "facturacion.revisado, facturacion.liquidado, facturacion.facturado, facturacion.factura_id, facturacion.liquidacion_id, facturacion.liquidado_autorizado, ".
                  "novedades_reconfirmacion.seleccion_opcion, ".
                  "centrosdecosto.razonsocial, centrosdecosto.localidad, centrosdecosto.tipo_cliente, encuesta.pregunta_1, encuesta.pregunta_2, encuesta.pregunta_3, ".
                  "encuesta.pregunta_4, encuesta.pregunta_5, encuesta.pregunta_6, encuesta.pregunta_7, encuesta.pregunta_8, encuesta.pregunta_9, encuesta.pregunta_10, ".
                  "ordenes_facturacion.numero_factura, ordenes_facturacion.consecutivo, ordenes_facturacion.nomostrar, ".
                  "subcentrosdecosto.nombresubcentro, ".
                  "users.first_name, users.last_name, ".
                  "rutas.nombre_ruta, rutas.codigo_ruta, ".
                  "proveedores.razonsocial as razonproveedor, proveedores.tipo_afiliado, ".
                  "conductores.nombre_completo, conductores.celular, conductores.telefono, conductores.usuario_id, ".
                  "vehiculos.placa, vehiculos.clase,".
                  "vehiculos.marca, vehiculos.modelo, ".
                  "servicios_autorizados_pdf.documento_pdf1, servicios_autorizados_pdf.documento_pdf2, ".

                  " (select id from novedades_app where servicio_id = servicios.id limit 1) as novedades_app ".

                  "from servicios ".
                  "left join servicios_autorizados_pdf on servicios.id = servicios_autorizados_pdf.servicio_id ".
                  "left join reconfirmacion on servicios.id = reconfirmacion.id_servicio ".
                  "left join encuesta on servicios.id = encuesta.id_servicio ".
                  "left join servicios_edicion_pivote on servicios.id = servicios_edicion_pivote.servicios_id ".
                  "left join reportes_pivote on servicios.id = reportes_pivote.servicio_id ".
                  "left join novedades_reconfirmacion on servicios.id = novedades_reconfirmacion.id_reconfirmacion ".
                  "left join facturacion on servicios.id = facturacion.servicio_id ".
                  "left join ordenes_facturacion on facturacion.factura_id = ordenes_facturacion.id ".
                  "left join pago_proveedores on facturacion.pago_proveedor_id = pago_proveedores.id ".
                  "left join pagos on pago_proveedores.id_pago = pagos.id ".
                  "left join rutas on servicios.ruta_id = rutas.id ".
                  "left join proveedores on servicios.proveedor_id = proveedores.id ".
                  "left join conductores on servicios.conductor_id = conductores.id ".
                  "left join vehiculos on servicios.vehiculo_id = vehiculos.id ".
                  "left join centrosdecosto on servicios.centrodecosto_id = centrosdecosto.id ".
                  "left join subcentrosdecosto on servicios.subcentrodecosto_id = subcentrosdecosto.id ".
                  "left join users on servicios.creado_por = users.id ".
                  "where servicios.fecha_servicio between '".$fecha_inicial."' AND '".$fecha_final."' and servicios.proveedor_id = ".$id_proveedor."";

                $servicios = DB::select(DB::raw($consulta." and servicios.pendiente_autori_eliminacion is null ORDER BY fecha_servicio ASC, hora_servicio ASC"));

              if ($servicios!=null) {

                  return Response::json([
                      'mensaje'=>true,
                      'servicios'=>$servicios,
                      'tipo_usuario'=>$tipo_usuario,
                      'id_rol'=>$id_rol,
                      'consulta'=>$consulta,
                      'id_usuario'=>Sentry::getUser()->id,
                      'permisos'=>$permisos
                  ]);

              }else{

                  return Response::json([
                      'mensaje'=>false,
                      'consulta'=>$consulta,
                      'subcentro'=>$subcentro
                  ]);
              }
          }
      }
    }

  }
