<?php

use Illuminate\Routing\Controller;
use LucaDegasperi\OAuth2Server\Authorizer;

class OAuthController extends Controller
{
    protected $authorizer;

    public function __construct(Authorizer $authorizer)
    {
        $this->authorizer = $authorizer;
        $this->beforeFilter('auth', ['only' => ['getAuthorize', 'postAuthorize']]);
        $this->beforeFilter('csrf', ['only' => 'postAuthorize']);
        $this->beforeFilter('check-authorization-params', ['only' => ['getAuthorize', 'postAuthorize']]);
    }

    public function postAccesstokenv2()
    {
        //test
        //Login credentials
        $username = Input::get('username');
        $password = Input::get('password');
        //$tipo_usuario = Input::get('tipo_usuario');

        $validaciones = [
            'username' => 'required|email',
            'password' => 'required',
            //'tipo_usuario' => 'required|numeric'
        ];

        $mensajesValidacion = [
            'username.required' => 'El campo email es requerido!',
            'username.email' => 'El campo email debe ser un campo email valido!',
            'password.required' => 'El campo password es requerido',
            //'tipo.required' => 'Debe seleccionar un tipo de usuario',
            //'tipo.numeric' => 'El tipo de usuario debe ser numerico'
        ];

        $validador = Validator::make(Input::all(), $validaciones, $mensajesValidacion);

        if ($validador->fails()){

            return Response::json([
                'errores'=>$validador->errors()->getMessages(),
                'respuesta'=>false
            ]);

        }else {

            try {

                $credentials = array(
                    'email' => $username,
                    'password' => $password
                );

                Config::set('cartalyst/sentry::users.login_attribute', 'email');
                //Config::set('cartalyst/sentry::users.login_attribute', 'username');

                // Authenticate the user
                $user = Sentry::authenticate($credentials);

                if ($user) {

                    $dataUser = DB::table('oauth_clients')->where('id', 1)->first();

                    $usuario = DB::table('users')
                    ->where('email',$username)
                    ->first();

                    if($usuario->baneado==1){

                      return Response::json([
                          'response' => 'login'
                      ]);

                    }else if ($dataUser) {

                        Input::merge([
                            'grant_type' => 'password',
                            'client_id' => $dataUser->id,
                            'client_secret' => $dataUser->secret
                        ]);

                        $conductor = DB::table('conductores')
                          ->where('usuario_id', Sentry::getUser()->id)
                          ->first();

                        return Response::json([
                            'response' => $this->authorizer->issueAccessToken(),
                            'acceso' => true,
                            'id_usuario' => Sentry::getUser()->id,
                            'tipo_usuario' => Sentry::getUser()->tipo_usuario,
                            'conductor' => $conductor
                        ]);
                    } else {

                        return Response::json('No contiene registro para token', 404);

                    }
                }

                Sentry::logout();

            } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
                return Response::json([
                    'mensaje' => false,
                    'respuesta' => 'Contraseña incorrecta'
                ]);

            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                return Response::json([
                    'mensaje' => false,
                    'respuesta' => 'Usuario no encontrado'
                ]);
            } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {

                return Response::json([
                    'mensaje' => false,
                    'respuesta' => 'El usuario no ha sido activado'
                ]);

            } // The following is only required if the throttling is enabled
            catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {

                return Response::json([
                    'mensaje' => false,
                    'respuesta' => 'El usuario ha sido suspendido'
                ]);

            } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {

                return Response::json([
                    'mensaje' => false,
                    'respuesta' => 'El usuario ha sido baneado'
                ]);

            }
        }
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

    public function postLoginautonet(){

        //if(Request::ajax()){

        $usarname = Input::get('username');
        $password = Input::get('password');

            try {
                // Login credentials

                Config::set('cartalyst/sentry::users.login_attribute', 'username');

                $credentials = array(
                    'username'=> Input::get('username'),
                    'password' => Input::get('password'),
                );

                $remember = Input::get('recordarme');
               // $qruser = Input::get('qruser');


                $user = Sentry::authenticate($credentials, $remember);
                  if($user){

                    $dataUser = DB::table('oauth_clients')->where('id', 1)->first();

                    if ($dataUser) {

                        Input::merge([
                            'grant_type' => 'password',
                            'client_id' => $dataUser->id,
                            'client_secret' => $dataUser->secret
                        ]);

                        return Response::json([
                            'response' => $this->authorizer->issueAccessToken(),
                            'acceso' => true,
                            'id_usuario' => Sentry::getUser()->id,
                            'localidad' => Sentry::getUser()->localidad,
                            'id_empleado' => Sentry::getUser()->id_empleado,
                            'username' => Sentry::getUser()->username,
                            'first_name' => Sentry::getUser()->first_name,
                            'last_name' => Sentry::getUser()->last_name,
                            'telefono' => Sentry::getUser()->telefono,
                            'empresarial' => Sentry::getUser()->empresarial,
                            'centro' => Sentry::getUser()->centrodecosto_id,
                            'tipo_usuario' => Sentry::getUser()->tipo_usuario,
                            'id_rol' => Sentry::getUser()->id_rol,
                            'imagen' => DB::table('empleados')->where('id',Sentry::getUser()->id_empleado)->pluck('foto')
                        ]);
                    } else {

                        return Response::json('No contiene registro para token', 404);

                    }
                    /*return Response::json([
                        'mensaje'=>true,
                        'user' => $user,
                        'token' => $this->authorizer->issueAccessToken()
                    ]);*/
                  }


            }

            catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
            {
                return Response::json([
                    'mensaje'=>false,
                    'respuesta'=>'El campo de usuario es requerido'
                ]);

            }
            catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
            {
                return Response::json([
                    'mensaje'=>false,
                    'respuesta'=>'La contrase&ntildea es requerida'
                ]);
            }
            catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
            {
                return Response::json([
                    'mensaje'=>false,
                    'respuesta'=>'Contrase&ntildea incorrecta'
                ]);
            }
            catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
            {
                return Response::json([
                    'mensaje'=>false,
                    'respuesta'=>'Usuario o Contraseña incorrectos'
                ]);
            }
            catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
            {
                return Response::json([
                    'mensaje'=>false,
                    'respuesta'=>'Usuario no activado'
                ]);
            }

           // The following is only required if the throttling is enabled
            catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
            {
                return Response::json([
                    'mensaje'=>false,
                    'respuesta'=>'El usuario ha sido suspendido'
                ]);
            }
            catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
            {
                return Response::json([
                    'mensaje'=>false,
                    'respuesta'=>'El usuario ha sido baneado'
                ]);
            }

        //}
    }

    public function postAccesstokenv3(){ //Login de usuarios: app cliente
        //test
        //Login credentials
        $idioma = Input::get('idioma');
        $username = Input::get('username');
        $password = Input::get('password');
        //$tipo_usuario = Input::get('tipo_usuario');

        $validaciones = [
            'username' => 'required|email',
            'password' => 'required',
            //'tipo_usuario' => 'required|numeric'
        ];

        $mensajesValidacion = [
            'username.required' => 'El campo email es requerido!',
            'username.email' => 'El campo email debe ser un campo email valido!',
            'password.required' => 'El campo password es requerido',
            //'tipo.required' => 'Debe seleccionar un tipo de usuario',
            //'tipo.numeric' => 'El tipo de usuario debe ser numerico'
        ];

        $validador = Validator::make(Input::all(), $validaciones, $mensajesValidacion);

        if ($validador->fails()){

            return Response::json([
                'errores'=>$validador->errors()->getMessages(),
                'respuesta'=>false
            ]);

        }else {

          if($idioma=='en'){
            $mensaje_1 = 'Incorrect password';
            $mensaje_2 = 'User not found';
            $mensaje_3 = 'The user has not been activated';
            $mensaje_4 = 'The user has been suspended. Try again in an hour';
            $mensaje_5 = 'The user has been banned';
          }else{
            $mensaje_1 = 'Contraseña incorrecta';
            $mensaje_2 = 'Usuario no encontrado';
            $mensaje_3 = 'El usuario no ha sido activado';
            $mensaje_4 = 'El usuario ha sido suspendido. Intenta de nuevo en 1 hora';
            $mensaje_5 = 'El usuario ha sido baneado';
          }

            try {

                $credentials = array(
                    'email' => $username,
                    'password' => $password
                );

                Config::set('cartalyst/sentry::users.login_attribute', 'email');
                //Config::set('cartalyst/sentry::users.login_attribute', 'username');

                // Authenticate the user
                $user = Sentry::authenticate($credentials);

                if ($user) {

                    $dataUser = DB::table('oauth_clients')->where('id', 1)->first();

                    if ($dataUser) {

                        Input::merge([
                            'grant_type' => 'password',
                            'client_id' => $dataUser->id,
                            'client_secret' => $dataUser->secret
                        ]);

                        /*$usuario = DB::table('users')
                          ->where('id', Sentry::getUser()->id)
                          ->first();*/

                        return Response::json([
                            'response' => $this->authorizer->issueAccessToken(),
                            'acceso' => true,
                            'id_usuario' => Sentry::getUser()->id,
                            'email' => Sentry::getUser()->username,
                            'first_name' => Sentry::getUser()->first_name,
                            'last_name' => Sentry::getUser()->last_name,
                            'telefono' => Sentry::getUser()->telefono,
                            'empresarial' => Sentry::getUser()->empresarial,
                            'centro' => Sentry::getUser()->centrodecosto_id,
                            'tipo_usuario' => Sentry::getUser()->tipo_usuario,
                        ]);
                    } else {

                        return Response::json('No contiene registro para token', 404);

                    }
                }

                Sentry::logout();

            } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
                return Response::json([
                    'mensaje' => false,
                    'respuesta' => $mensaje_1,
                    'idioma' => $idioma
                ]);

            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                return Response::json([
                    'mensaje' => false,
                    'respuesta' => $mensaje_2
                ]);
            } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {

                return Response::json([
                    'mensaje' => false,
                    'respuesta' => $mensaje_3
                ]);

            } // The following is only required if the throttling is enabled
            catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {

                return Response::json([
                    'mensaje' => false,
                    'respuesta' => $mensaje_4
                ]);

            } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {

                return Response::json([
                    'mensaje' => false,
                    'respuesta' => $mensaje_5
                ]);

            }
        }
    }

    public function postAccesstokenruta(){
        //test
        //Login credentials
        $idioma = Input::get('idioma');
        $username = Input::get('username');
        $password = Input::get('password');
        //$tipo_usuario = Input::get('tipo_usuario');

        $validaciones = [
            'username' => 'required',
            'password' => 'required',
        ];

        $mensajesValidacion = [
            'username.required' => 'El campo Employ ID es requerido!',
            'password.required' => 'El campo password es requerido',
            //'tipo.required' => 'Debe seleccionar un tipo de usuario',
            //'tipo.numeric' => 'El tipo de usuario debe ser numerico'
        ];

        $validador = Validator::make(Input::all(), $validaciones, $mensajesValidacion);

        if ($validador->fails()){

            return Response::json([
                'errores'=>$validador->errors()->getMessages(),
                'respuesta'=>false
            ]);

        }else {

          if($idioma=='en'){
            $mensaje_1 = 'Incorrect password';
            $mensaje_2 = 'User not found';
            $mensaje_3 = 'The user has not been activated';
            $mensaje_4 = 'The user has been suspended. Try again in an hour';
            $mensaje_5 = 'The user has been banned';
          }else{
            $mensaje_1 = 'Contraseña incorrecta';
            $mensaje_2 = 'Usuario no encontrado';
            $mensaje_3 = 'El usuario no ha sido activado';
            $mensaje_4 = 'El usuario ha sido suspendido. Intenta de nuevo en 1 hora';
            $mensaje_5 = 'El usuario ha sido baneado';
          }

            try {

                $credentials = array(
                    'email' => $username,
                    'password' => $password
                );

                Config::set('cartalyst/sentry::users.login_attribute', 'email');
                //Config::set('cartalyst/sentry::users.login_attribute', 'username');

                // Authenticate the user
                $user = Sentry::authenticate($credentials);

                if ($user) {

                    $dataUser = DB::table('oauth_clients')->where('id', 1)->first();

                    if ($dataUser) {

                        Input::merge([
                            'grant_type' => 'password',
                            'client_id' => $dataUser->id,
                            'client_secret' => $dataUser->secret
                        ]);

                        /*$usuario = DB::table('users')
                          ->where('id', Sentry::getUser()->id)
                          ->first();*/

                        return Response::json([
                            'response' => $this->authorizer->issueAccessToken(),
                            'acceso' => true,
                            'id_usuario' => Sentry::getUser()->id,
                            'email' => Sentry::getUser()->email,
                            'ciudad' => Sentry::getUser()->centro_de_costo,
                            'first_name' => Sentry::getUser()->first_name,
                            'last_name' => Sentry::getUser()->last_name,
                            'telefono' => Sentry::getUser()->telefono,
                            'empresarial' => Sentry::getUser()->empresarial,
                            'centro' => Sentry::getUser()->centrodecosto_id,
                            'tipo_usuario' => Sentry::getUser()->tipo_usuario,
                        ]);
                    } else {

                        return Response::json('No contiene registro para token', 404);

                    }
                }

                Sentry::logout();

            } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
                return Response::json([
                    'mensaje' => false,
                    'respuesta' => $mensaje_1,
                    'idioma' => $idioma
                ]);

            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                return Response::json([
                    'mensaje' => false,
                    'respuesta' => $mensaje_2
                ]);
            } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {

                return Response::json([
                    'mensaje' => false,
                    'respuesta' => $mensaje_3
                ]);

            } // The following is only required if the throttling is enabled
            catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {

                return Response::json([
                    'mensaje' => false,
                    'respuesta' => $mensaje_4
                ]);

            } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {

                return Response::json([
                    'mensaje' => false,
                    'respuesta' => $mensaje_5
                ]);

            }
        }
    }

    public function postCreate(){

      $idioma = Input::get('idioma');

      $tipo = Input::get('tipo');
      $nombres = Input::get('nombre');
      $apellidos = Input::get('apellido');
      $correo = Input::get('email');
      $contrasena = Input::get('password');
      $telefono = Input::get('telefono');
      $empresa = Input::get('empresa');
      $cargo = Input::get('cargo');
      $centro = Input::get('centro');

      $usuario = DB::table('users')
      ->where('email',$correo)
      ->first();

      if($usuario){

        return Response::json([
          'response' => false,
          'error' => 'existe'
        ]);

      }else{

        $user = new User();

        if ($tipo=='empresarial') {
          $user->empresarial = 1;
          $user->empresa = trim(strtoupper(strtolower($empresa)));
          $user->centro_de_costo = trim($centro);
          $user->cargo = trim($cargo);
        }else{
          $user->particular = 1;
          //$user->centrodecosto_id = 100;
        }

        $user->first_name = strtoupper(strtolower($nombres));
        $user->last_name = strtoupper(strtolower($apellidos));
        $user->email = strtolower($correo);
        $user->telefono = $telefono;
        $user->password = Hash::make($contrasena);
        $user->activation_code = str_random(40);
        $user->usuario_app = 2;
        //$user->activated = 1;

        if ($user->save()) {

          $data = [
            'activation_code' => $user->activation_code
          ];

          $userArray = [
            'id' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'telefono' => $user->telefono,
            'empresarial' => $user->empresarial,
            'centro' => $user->centrodecosto_id
          ];

          /*Código de envío Email Creación de Uusario (Link de Activación)*/

          $emailcc = 'aotourdeveloper@gmail.com';

          $datos = [
            'activation_code' => $user->activation_code,
          ];

          $sub = new Subcentro;
          $sub->nombresubcentro = $nombres.' '.$apellidos;
          $sub->email_contacto = $correo;
          $sub->celular = $telefono;
          $sub->centrosdecosto_id = 100;
          $sub->save();

          $updateUser = DB::table('users')
          ->where('id',$user->id)
          ->update([
            'centrodecosto_id' => 100,
            'subcentrodecosto_id' => $sub->id
          ]);

          /*if (!$tipo=='empresarial') {

            if($idioma=='en'){

              Mail::send('mobile.client.email_activacion_en', $datos, function($message) use ($correo, $emailcc){
                $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
                $message->to($correo)->subject('Account Activation');
                $message->cc($emailcc);
              });

            }else{

              Mail::send('mobile.client.email_activacion', $datos, function($message) use ($correo, $emailcc){
                $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
                $message->to($correo)->subject('Activacion de cuenta');
                $message->cc($emailcc);
              });

            }

          }*/

          return Response::json([
            'response' => true,
            //'token' => $token,
            'userArray' => $userArray
          ]);

        }
      }
    }

    public function postResetpassword()
    {
      $username = Input::get('username');
      $idioma = Input::get('idioma');

      $validaciones = [
          'username' => 'required|email',
      ];
      if($idioma==='en'){
        $msgEmail = 'The typed email is not valid!';
      }else{
        $msgEmail = 'El correo ingresado no es válido';
      }
      $mensajesValidacion = [
          'username.email' => $msgEmail
      ];

      $validador = Validator::make(Input::all(), $validaciones, $mensajesValidacion);

      if ($validador->fails()){

          return Response::json([
            'response'=>false,
            'errores'=>$msgEmail,
          ]);

      }else{

        /*Código de envío Email Reset Password*/

        return Response::json([
          'response' => true,
          'username' => $username,
          'idioma' => $idioma,
          //'msgRequired' => $msgRequired
        ]);
      }

    }

    public function postAccesstoken()
    {

        //Login credentials
        $username = Input::get('username');
        $password = Input::get('password');
        $tipo_usuario = Input::get('tipo_usuario');

        $validaciones = [
            'username' => 'required|email',
            'password' => 'required',
            'tipo_usuario' => 'required|numeric'
        ];

        $mensajesValidacion = [
            'username.required' => 'El campo email es requerido!',
            'username.email' => 'El campo email debe ser un campo email valido!',
            'password.required' => 'El campo password es requerido',
            'tipo.required' => 'Debe seleccionar un tipo de usuario',
            'tipo.numeric' => 'El tipo de usuario debe ser numerico'
        ];

        $validador = Validator::make(Input::all(), $validaciones, $mensajesValidacion);

        if ($validador->fails()){

            return Response::json([
                'errores'=>$validador->errors()->getMessages(),
                'respuesta'=>false
            ]);

        }else {

            try {

                $credentials = array(
                    'email' => $username,
                    'password' => $password
                );

                Config::set('cartalyst/sentry::users.login_attribute', 'email');
                //Config::set('cartalyst/sentry::users.login_attribute', 'username');

                // Authenticate the user
                $user = Sentry::authenticate($credentials);

                if ($user) {

                    $dataUser = DB::table('oauth_clients')->where('id', 1)->first();

                    if ($dataUser) {

                        Input::merge([
                            'grant_type' => 'password',
                            'client_id' => $dataUser->id,
                            'client_secret' => $dataUser->secret
                        ]);

                        $conductor = DB::table('conductores')
                          ->where('usuario_id', Sentry::getUser()->id)
                          ->first();

                        return Response::json([
                            'response' => $this->authorizer->issueAccessToken(),
                            'acceso' => true,
                            'id_usuario' => Sentry::getUser()->id,
                            'tipo_usuario' => Sentry::getUser()->tipo_usuario,
                            'conductor' => $conductor
                        ]);
                    } else {

                        return Response::json('No contiene registro para token', 404);

                    }
                }

                Sentry::logout();

            } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
                return Response::json([
                    'mensaje' => false,
                    'respuesta' => 'Contraseña incorrecta'
                ]);

            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                return Response::json([
                    'mensaje' => false,
                    'respuesta' => 'Usuario no encontrado'
                ]);
            } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {

                return Response::json([
                    'mensaje' => false,
                    'respuesta' => 'El usuario no ha sido activado'
                ]);

            } // The following is only required if the throttling is enabled
            catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {

                return Response::json([
                    'mensaje' => false,
                    'respuesta' => 'El usuario ha sido suspendido'
                ]);

            } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {

                return Response::json([
                    'mensaje' => false,
                    'respuesta' => 'El usuario ha sido baneado'
                ]);

            }
        }
    }

    public function postBuscarproveedor(){

        $id = Input::get('id');
        $busqueda = DB::table('proveedores')
        ->where('nit',$id)
        ->first();

        if($busqueda!=null){

            return Response::json([
              'respuesta' => true,
              'proveedor' => $busqueda,
              'id' => $id
            ]);

        }else{

            return Response::json([
              'respuesta' => false,
              'id' => $id
            ]);

        }

    }

    public function postBuscarconductor(){

        $id = Input::get('id_proveedor');
        $cedula = Input::get('cedula_conductor');

        $busqueda = DB::table('conductores')
        ->leftJoin('users', 'users.id', '=', 'conductores.usuario_id')
        ->select('conductores.id', 'conductores.nombre_completo', 'conductores.celular', 'users.email')
        ->where('cc',$cedula)
        ->where('proveedores_id',$id)
        ->first();

        if($busqueda!=null){

            return Response::json([
              'respuesta' => true,
              'conductor' => $busqueda,
              'cedula' => $cedula
            ]);

        }else{

            return Response::json([
              'respuesta' => false,
              'cedula' => $cedula,
              'id' => $id
            ]);

        }

    }

    public function postEnviarusuario(){

        $id = Input::get('id');
        $email = Input::get('email');
        $nombre = Input::get('nombre');
        $celular = Input::get('celular');

        if(1>0){

            return Response::json([
              'respuesta' => true,
              'email' => $email,
              'nombre' => $nombre,
              'celular' => $celular,
            ]);

        }else{

            return Response::json([
              'respuesta' => false,
              'cedula' => $cedula,
              'id' => $id
            ]);

        }

    }

    public function postEnviarusuariocreado(){

        $id = Input::get('id');
        $email = Input::get('email');
        $nombre = Input::get('nombre');
        $celular = Input::get('celular');

        $numero = rand(1, 50);

        $ejemplo = "hola soy nakiox";


        $first = substr($ejemplo,0,2); //Sustrae las dos primera letras/vocales
        $first = substr($ejemplo,0,3); //Sustrae las tres primeras letras/vocales


        $array = explode ( ' ', $nombre );
        $cantidad = count($array);

        $apellido = null;

        if($cantidad==2){ //Si solo es nombre y apellido

            $first = substr($nombre,0,1); //Sustrae la primera letra/vocal
            $apellido = $array[1]; //primer apellido
            $usuario = $first.$apellido;

        }else if($cantidad==3){ //Si es un nombre y dos apellidos

            $first = substr($nombre,0,1); //Sustrae la primera letra/vocal
            $apellido = $array[1]; //primer apellido
            $usuario = $first.$apellido;

        }else if($cantidad==4){ //Si son dos nombres y dos apellidos

            $first = substr($nombre,0,1); //Sustrae la primera letra/vocal
            $apellido = $array[2]; //primer apellido
            $usuario = $first.$apellido;

        }

        $usuario = $usuario.'@AOTOUR.COM.CO'; //Primera letra del nombre

        $search = DB::table('users')
        ->where('email',$usuario)
        ->first();

        if($search!=null){

            if($cantidad==2){ //Si solo es nombre y apellido

                $first = substr($nombre,0,2); //Sustrae la primera letra/vocal
                $apellido = $array[1]; //primer apellido
                $usuario = $first.$apellido;

            }else if($cantidad==3){ //Si es un nombre y dos apellidos

                $first = substr($nombre,0,2); //Sustrae la primera letra/vocal
                $apellido = $array[1]; //primer apellido
                $usuario = $first.$apellido;

            }else if($cantidad==4){ //Si son dos nombres y dos apellidos

                $first = substr($nombre,0,2); //Sustrae la primera letra/vocal
                $apellido = $array[2]; //primer apellido
                $usuario = $first.$apellido;

            }

            $usuario = $usuario.'@AOTOUR.COM.CO'; //Dos primeras letras del nombre

            $search = DB::table('users')
            ->where('email',$usuario)
            ->first();

            if($search!=null){

                if($cantidad==2){ //Si solo es nombre y apellido

                    $first = substr($nombre,0,3); //Sustrae la primera letra/vocal
                    $apellido = $array[1]; //primer apellido
                    $usuario = $first.$apellido;

                }else if($cantidad==3){ //Si es un nombre y dos apellidos

                    $first = substr($nombre,0,3); //Sustrae la primera letra/vocal
                    $apellido = $array[1]; //primer apellido
                    $usuario = $first.$apellido;

                }else if($cantidad==4){ //Si son dos nombres y dos apellidos

                    $first = substr($nombre,0,3); //Sustrae la primera letra/vocal
                    $apellido = $array[2]; //primer apellido
                    $usuario = $first.$apellido;

                }

                $usuario = $usuario.'@AOTOUR.COM.CO'; //Tres primeras letras del nombre y primer apellido

                $search = DB::table('users')
                ->where('email',$usuario)
                ->first();

                if($search!=null){

                    if($cantidad==2){ //Si solo es nombre y apellido

                        $first = substr($nombre,0,2); //Sustrae la primera letra/vocal
                        $apellido = $array[1]; //primer apellido
                        $numero = rand(1, 150);
                        $usuario = $first.$apellido.$numero;

                    }else if($cantidad==3){ //Si es un nombre y dos apellidos

                        $first = substr($nombre,0,2); //Sustrae la primera letra/vocal
                        $apellido = $array[1]; //primer apellido
                        $numero = rand(1, 150);
                        $usuario = $first.$apellido.$numero;

                    }else if($cantidad==4){ //Si son dos nombres y dos apellidos

                        $first = substr($nombre,0,2); //Sustrae la primera letra/vocal
                        $apellido = $array[2]; //primer apellido
                        $numero = rand(1, 150);
                        $usuario = $first.$apellido.$numero;

                    }

                    $usuario = $usuario.'@AOTOUR.COM.CO'; //Primera letra del nombre + numer random + y primer apellido

                    /*$search = DB::table('users')
                    ->where('email',$usuario)
                    ->first();*/


                }

            }

            /*Código para crear el usuario y conectarlo con user_id de la tabla conductores*/

            /*Código para enviar el usuario por SMS*/

        }

        if(1>0){

            return Response::json([
              'respuesta' => true,
              'email' => $email,
              'nombre' => $nombre,
              'celular' => $celular,
              'numero' => $numero,
              'array' => $array,
              'apellido' => $apellido,
              'usuario' => $usuario,
              'search' => $search
            ]);

        }else{

            return Response::json([
              'respuesta' => false,
              'cedula' => $cedula,
              'id' => $id
            ]);

        }

    }

    public function postGuardarequipo(){

        $categoria = Input::get('categoria');
        $marca = Input::get('marca');
        $fecha = Input::get('fecha');
        $procesador = Input::get('procesador');
        $ref = Input::get('ref');
        $espacio = Input::get('espacio');
        $tipo_disco = Input::get('tipo_disco');
        $ram = Input::get('ram');
        $mac = Input::get('mac');
        $nombre_red = Input::get('nombre_red');
        $observaciones = Input::get('observaciones');

        $equipo = new Equipo();
        $equipo->categoria = $categoria;
        $equipo->marca = $marca;
        $equipo->fecha = $fecha;
        $equipo->procesador = $procesador;
        $equipo->ref = $ref;
        $equipo->espacio = $espacio;
        $equipo->tipo_disco = $tipo_disco;
        $equipo->ram = $ram;
        $equipo->mac = $mac;
        $equipo->nombre_red = $nombre_red;
        $equipo->observaciones = $observaciones;

        if($equipo->save()){

            $consulta = "select * from equipos where categoria '"+$categoria+"'";

            $consulta = DB::select($consulta);

            if($consulta){
                $number = count($consulta)+1;
                $number = '00'.$number;
            }else{
                $number = '001';
            }

            //$numero = intval(str_replace('AO','',$ultimo[0]->id))+1;

            //START PREV
            if($categoria==='Computador Escritorio'){
                $v1 = 'PC'.$number;
            }else if($categoria==='Computador Portatil'){
                $v1 = 'PT'.$number;
            }else if($categoria==='Celular'){
                $v1 = 'CEL'.$number;
            }else if($categoria==='Tablet'){
                $v1 = 'TAB'.$number;
            }else if($categoria==='Televisor'){
                $v1 = 'TV'.$number;
            }else if($categoria==='Video Beam'){
                $v1 = 'VB'.$number;
            }else if($categoria==='Audifonos'){
                $v1 = 'AUD'.$number;
            }

            $data = $v1.'.png'; //Valor de código QR
            $equipo->code = $vq;

            $id_image = Input::get('image');
            $img = base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$id_image));
            //END PREV

            $qr_code = DNS2D::getBarcodePNG($data, "QRCODE", 10, 10,array(1,1,1), true); //Creación de QR
            Image::make($qr_code)->save('biblioteca_imagenes/codigosqr/'.$data); //Creación del QR P2

            $filepath = "biblioteca_imagenes/codigosqr/".$equipo->id.'.jpeg';
            file_put_contents($filepath,$img);

            $update = DB::table('equipos')
            ->where('id',$equipo->id)
            ->update([
                'img' => $equipo->id.'.jpeg'
            ]);

            return Response::json([
                'respuesta' => true,
                'categoria' => $categoria
            ]);

        }

    }

    public function postVerequipo(){

        $id = Input::get('id');

        $equipo = DB::table('equipos')
        ->where('id',$id)
        ->first();

        if($equipo!=null){

            return Response::json([
                'respuesta' => true,
                'equipo' => $equipo
            ]);

        }

    }

    /*AUTONET MOBILE*/


    public function postListar(){

        $search = DB::table('equipos')->get();

            return Response::json([
                'respuesta' => true,
                'equipos' => $search
            ]);
    }
    /*AUTONET MOBILE*/

    public function postRegisteruser()
    {
        ##VALIDACIONES DE USUARIO
        $validaciones = [
            'nombres' => 'required|sololetrasyespacio',
            'apellidos' => 'required|sololetrasyespacio',
            'email' => 'required|email|unique:registro',
            'identificacion' => 'numeric',
            'password' => 'required',
            'tipo_usuario' => 'required|numeric', ##CORPORATIVO = 1, CONDUCTOR = 2, PERSONA NATURAL = 3
            'empresa' => 'letrasnumerosyespacios',
            'telefono' => 'numeric'
        ];

        $mensajesValidacion = [
            'nombres.required' => 'El campo nombre es requerido!',
            'nombres.sololetrasyespacio' => 'El campo nombre solo puede tener letras y espacios!',
            'apellidos.required' => 'El campo apellido es requerido!',
            'apellidos.sololetrasyespacio' => 'El campo apellido solo puede tener letras y espacios!',
            'email.required' => 'El campo email es requerido!',
            'email.email' => 'El campo email debe ser un campo email valido!',
            'email.unique' => 'Este email ya ha sido registrado!',
            'password.required' => 'El campo password es requerido',
            'tipo_usuario.required'
        ];

        ##VALIDADOR
        $validador = Validator::make(Input::all(), $validaciones, $mensajesValidacion);

        if ($validador->fails()){

            return Response::json(['errores'=>$validador->errors()->getMessages()],400);

        }else {

            $registro = new ApiRegistro;
            $registro->nombres = strtolower(Input::get('nombres'));
            $registro->apellidos = strtolower(Input::get('apellidos'));
            $registro->email = Input::get('email');
            $registro->identificacion = Input::get('identificacion');
            $registro->telefono = Input::get('telefono');
            $registro->tipo = Input::get('tipo');
            $registro->empresa = strtolower(Input::get('empresa'));
            $registro->password = Input::get('password');

            $str = "";
            $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
            $max = count($characters) - 1;

            for ($i = 0; $i < 20; $i++) {
                $rand = mt_rand(0, $max);
                $str .= $characters[$rand];
            }

            $registro->codigo_activacion = $str;

            if($registro->save()){

                ##SI ES TIPO DE USUARIO CORPORATIVO ENTONCES SE ENVIA UN MAIL DE CONFIRMACION
                if(Input::get('tipo')==1){

                    $data = [
                        'id' => $registro->id,
                        'nombres' => $registro->nombres,
                        'apellidos' => $registro->apellidos,
                        'codigo_activacion' => $registro->codigo_activacion
                    ];

                    Mail::send('emails/codigoactivacion', $data, function ($message) use ($registro){
                        $message->to($registro->email, $registro->nombres.''.$registro->apellidos);
                        $message->from('Mail@aotour.com.co', 'Auto ocasional tour');
                        $message->subject('Activacion de usuario App Aotour');
                    });
                }

                return Response::json([
                    'response' => true
                ],200);
            }
        }
    }

    public function getActivacionusuario()
    {

        $id = Input::get('id');
        $codigo_activation = Input::get('codigo_activacion');

        //REVISAR SI EL USUARIO YA HA SIDO ACTIVADO

        $registro = DB::table('registro')->where('id',$id)->first();

        if ($registro->codigo_activacion===$codigo_activation):

            $user = new User();
            $user->password = $password = Hash::make($registro->password);
            $user->activated = 1;
            $user->username = $registro->email;
            $user->first_name = $registro->nombres;
            $user->last_name = $registro->apellidos;
            $user->identificacion = $registro->identificacion;
            $user->telefono = $registro->telefono;
            $user->email = $registro->email;
            $user->tipo_usuario = 2;

            if($user->save()):

                $clientId = DB::table('oauth_clients')->orderBy('id','desc')->limit(1)->pluck('id');

                $cliente = DB::table('oauth_clients')
                ->insert([
                    'id' => intval($clientId)+1,
                    'secret' => $user->password,
                    'name' => $user->first_name.' '.$user->last_name,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'users_api_id' => $user->id
                ]);

                return 'Registro realizado con exito!';
            endif;
        endif;


    }

    public function getAuthorize()
    {
        return View::make('authorization-form', $this->authorizer->getAuthCodeRequestParams());
    }

    public function postAuthorize()
    {
        // get the user id
        $params['user_id'] = Auth::user()->id;

        $redirectUri = '';

        if (Input::get('approve') !== null) {
            $redirectUri = $this->authorizer->issueAuthCode('user', $params['user_id'], $params);
        }

        if (Input::get('deny') !== null) {
            $redirectUri = $this->authorizer->authCodeRequestDeniedRedirectUri();
        }

        return Redirect::to($redirectUri);
    }

    //Rutas APP
    public function postVerificarnumero(){ //Verificación y envío del código de confirmación

        $numero = Input::get('numero');
        $idEmpleado = Input::get('id');

        $number = DB::table('users')
        ->where('telefono',$numero)
        ->first();

        if($number!=null){ //Ya existe el número

            return Response::json([
              'response' => 'existe_numero'
            ]);

        }else{

            $employId = DB::table('users')
            ->where('email',$idEmpleado)
            ->first();

            if($employId!=null){ //Ya existe el Employ ID

                return Response::json([
                  'response' => 'existe_employ'
                ]);

            }else{ //Habilitado para crear

                $code = 0;

                $code = "";
                $characters = array_merge(range('0','9'));
                $max = count($characters) - 1;
                for ($i = 0; $i < 5; $i++) {
                  $rand = mt_rand(0, $max);
                  $code .= $characters[$rand];
                }

                $verify = new Verificacion();
                $verify->numero = $numero;
                $verify->codigo = $code;
                //$verify->nombre = ; //PENDING
                $verify->save();

                $ch = curl_init();
                //curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/102100369400004/messages");
                curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);

                $name = 'SAMUEL GONZALEZ';

                curl_setopt($ch, CURLOPT_POST, TRUE);

                curl_setopt($ch, CURLOPT_POSTFIELDS, "{
                  \"messaging_product\": \"whatsapp\",
                  \"to\": \"57".$numero."\",
                  \"type\": \"template\",
                  \"template\": {
                    \"name\": \"register\",
                    \"language\": {
                      \"code\": \"es\",
                    },
                    \"components\": [{
                      \"type\": \"body\",
                      \"parameters\": [{
                        \"type\": \"text\",
                        \"text\": \"".$code."\",
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
                  'response' => true,
                  'result' => $response,
                  'verify' => $verify->id
                ]);

            }
        }

    }

    public function postVerificarcodigo(){ //Confirmación del código de verificación

        $id = Input::get('id');
        $code = Input::get('code');

        $query = Verificacion::find($id);

        if($query->codigo==$code){

            return Response::json([
              'response' => true
            ]);

        }else{

            return Response::json([
              'response' => false
            ]);

        }


    }

    public function postReenviarcodigo(){ //Confirmación del código de verificación

        $id = Input::get('id');

        $code = DB::table('verificacion')
        ->where('id',$id)
        ->pluck('codigo');

        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/102100369400004/messages");
        curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        $name = 'SAMUEL GONZALEZ';

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
          \"messaging_product\": \"whatsapp\",
          \"to\": \"57".$numero."\",
          \"type\": \"template\",
          \"template\": {
            \"name\": \"code_number\",
            \"language\": {
              \"code\": \"es\",
            },
            \"components\": [{
              \"type\": \"body\",
              \"parameters\": [{
                \"type\": \"text\",
                \"text\": \"".$code."\",
              }]
            }]
          }
        }");

        /*
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
          \"messaging_product\": \"whatsapp\",
          \"to\": \"57".$numero."\",
          \"type\": \"template\",
          \"template\": {
            \"name\": \"code_number\",
            \"language\": {
              \"code\": \"es\",
            },
            \"components\": [{
              \"type\": \"body\",
              \"parameters\": [{
                \"type\": \"text\",
                \"text\": \"".$name."\",
              },
              {
                \"type\": \"text\",
                \"text\": \"".$code."\",
              }]
            }]
          }
        }");*/

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type: application/json",
          "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return Response::json([
          'response' => true,
          'mensaje' => $response
        ]);


    }

    public function postCreateruta(){ //Crear usuario de Ruta

      $idioma = Input::get('idioma');

      $ciudad = Input::get('ciudad');
      $nombres = Input::get('nombre');
      $apellidos = Input::get('apellido');
      $employ = Input::get('employ');
      $contrasena = Input::get('password');
      $telefono = Input::get('telefono');
      $campana = Input::get('campana');

      $usuario = DB::table('users')
      ->where('email',$employ)
      ->first();

      if($usuario){

        return Response::json([
          'response' => false,
          'error' => 'existe',
          'employ' => $employ
        ]);

      }else{

        $user = new User();

        //$user->empresarial = 1;

        $user->first_name = strtoupper(strtolower($nombres));
        $user->last_name = strtoupper(strtolower($apellidos));
        $user->email = $employ;
        $user->telefono = $telefono;
        $user->password = Hash::make($contrasena);
        $user->activation_code = str_random(40);
        $user->usuario_app = 2;
        $user->activated = 1;
        $user->empresa = $campana;
        $user->centro_de_costo = $ciudad;

        if ($user->save()) {

          $data = [
            'activation_code' => $user->activation_code
          ];

          $userArray = [
            'id' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'telefono' => $user->telefono,
            'empresarial' => $user->empresarial,
            'centro' => $user->centrodecosto_id
          ];

          return Response::json([
            'response' => true,
            //'token' => $token,
            'userArray' => $userArray
          ]);

          /*Código de envío Email Creación de Uusario (Link de Activación)*/

          //$emailcc = 'aotourdeveloper@gmail.com';

          //$datos = [
            //'activation_code' => $user->activation_code,
          //];

          /*if (!$tipo=='empresarial') {

            if($idioma=='en'){

              Mail::send('mobile.client.email_activacion_en', $datos, function($message) use ($correo, $emailcc){
                $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
                $message->to($correo)->subject('Account Activation');
                $message->cc($emailcc);
              });

            }else{

              Mail::send('mobile.client.email_activacion', $datos, function($message) use ($correo, $emailcc){
                $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
                $message->to($correo)->subject('Activacion de cuenta');
                $message->cc($emailcc);
              });

            }

          }

          return Response::json([
            'response' => true,
            //'token' => $token,
            'userArray' => $userArray
          ]);*/

        }else{
            return Response::json([
            'response' => false,
            'employ' => $employ
          ]);
        }
      }
    }

    public function postBuscarproveedores() { //Función para saber si el proveedor está creado en sistema

      $identificacion = Input::get('identificacion');

      $proveedor = DB::table('proveedores')
      ->whereNull('inactivo')
      ->whereNull('inactivo_total')
      ->where('nit',$identificacion)
      ->first();

      if($proveedor!=null){

        //El proveedor está habilitado
        return Response::json([
          'respuesta' => true,
          'proveedor' => $proveedor
        ]);

      }else{

        //El proveedor NO está habilitado
        return Response::json([
          'respuesta' => false
        ]);

      }


    }

    public function postBuscarconductor2() {

      $identificacion = Input::get('identificacion');
      $proveedor_id = Input::get('proveedor_id');

      $conductor = DB::table('conductores')
      ->where('proveedores_id',$proveedor_id)
      ->where('cc',$identificacion)
      ->first();

      if($conductor!=null) { //Conductor en sistema

        if($conductor->usuario_id!=null){ //Tiene app creada

          $usuarioApp = DB::table('users')
          ->where('id',$conductor->usuario_id)
          ->pluck('email');

          return Response::json([
            'respuesta' => 'usuario_con_app',
            'usuario' => $usuarioApp //Se envía usuario para pegar en el campo email, preguntar si quiere iniciar sesión
          ]);

        }else{ //No tiene app creada

          return Response::json([
            'respuesta' => 'usuario_sin_app',
            'user_id' => $conductor->usuario_id,
            'conductor_id' => $conductor->id
          ]); //Se envía id y se pregunta si quiere crear su app

        }

      }else{ //Conductor no está en sistema

        return Response::json([
          'respuesta' => false,
          'mensaje' => 'No se encontró ningún usuario con su cédula.<br><br>Valida tu identificación o comunícate con servicio al cliente.'
        ]);

      }

    }

    public function postCrearapp() {

      $user_id = Input::get('user_id');
      $conductor_id = Input::get('conductor_id');

      $username = Input::get('username');

      $data = strtolower($username.'@aotour.com.co');

      $consulta = DB::table('users')
      ->where('email',$data)
      ->first();

      if($consulta!=null){

        return Response::json([
          'respuesta' => 'existe' //Correo ya tomado por otro usuario
        ]);

      }else{

        $conductor = Conductor::find($conductor_id);

        $user = new User();

        //El documento de identidad va a ser el password
        $user->password = $password = Hash::make($conductor->cc);
        $user->activated = 1;
        $user->username = null;
        $user->email = $data;

        $nombre_comp = $conductor->nombre_completo;
        $nombre_comp = explode(' ',$nombre_comp);
        $cant_nombre = count($nombre_comp);

        if($cant_nombre===3){
          $user->first_name = $nombre_comp[0];
          $user->last_name = $nombre_comp[1].' '.$nombre_comp[2];
        }else if($cant_nombre>=4){
          $user->first_name = $nombre_comp[0].' '.$nombre_comp[1];
          $user->last_name = $nombre_comp[2].' '.$nombre_comp[3];
        }else{
          $user->first_name = $nombre_comp[0];
          if(isset($nombre_comp[1])){
            $user->last_name = $nombre_comp[1];
          }
        }

        $user->nombre_completo = $conductor->nombre_completo;
        $user->identificacion = $conductor->cc;
        $user->telefono = $conductor->celular;
        $user->usuario_app = 1;
        $user->tipo_usuario = 2;
        $user->save();

        $conductor->usuario_id = $user->id;
        $conductor->email = $user->email;
        $conductor->save();

        return Response::json([
          'respuesta' => true,
          'email' => $user->email,
          'password' => $conductor->cc
        ]); //Usuario creado, iniciar sesión automáticamente

      }

    }

    //aquí empieza cambiar contraseña
    public function postConsultarproveedor() {

      $identificacionProveedor = Input::get('identificacion');

      $proveedor =  DB::table('proveedores')
      ->where('nit',$identificacionProveedor)
      ->whereNull('inactivo')
      ->whereNull('inactivo_total')
      ->first();

      if($proveedor!=null) {

        return Response::json([
          'respuesta' => true,
          'proveedor' => $proveedor //Mostrar nombre en la app (razonsocial)
        ]);

      }else{

        $proveedor =  DB::table('proveedores')
        ->where('nit',$identificacionProveedor)
        ->first();

        if($proveedor!=null) {

          return Response::json([
            'respuesta' => 'no_habilitado', //El pro
            'mensaje' => 'No es posible continuar con el proceso. Puede ser que el este proveedor no está habilitado en el sistema.<br><br> Comunícate con servicio al cliente.'
          ]);

        }else{

          return Response::json([
            'respuesta' => false,
            'mensaje' => 'No se encontró ningún registro con el número de indentificación '.$identificacionProveedor
          ]);

        }

      }

    }

    public function postConsultarconductor() {

      $proveedor_id = Input::get('proveedor_id');

      $identificacionConductor = Input::get('identificacion_conductor');

      $conductor = DB::table('conductores')
      ->where('proveedores_id',$proveedor_id)
      ->where('cc',$identificacionConductor)
      ->first();

      if($conductor!=null) {

        $consultarUsuario = DB::table('users')
        ->where('id',$conductor->usuario_id)
        ->first();

        if($consultarUsuario!=null) {
          $codigo = '';
          $characters = array_merge(range('0','9'));
          $max = count($characters) - 1;
          for ($i = 0; $i < 6; $i++) {
            $rand = mt_rand(0, $max);
            $codigo .= $characters[$rand];
          }

          $numero = $conductor->celular;

          //Envío del código
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($ch, CURLOPT_HEADER, FALSE);
          curl_setopt($ch, CURLOPT_POST, TRUE);
          curl_setopt($ch, CURLOPT_POSTFIELDS, "{
            \"messaging_product\": \"whatsapp\",
            \"to\": \"".$numero."\",
            \"type\": \"template\",
            \"template\": {
              \"name\": \"register\",
              \"language\": {
                \"code\": \"es\",
              },
              \"components\": [{
                \"type\": \"body\",
                \"parameters\": [{
                  \"type\": \"text\",
                  \"text\": \"".$codigo."\",
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

          $query = DB::table('users')
          ->where('id',$conductor->usuario_id)
          ->update([
            'code' => $codigo
          ]);

          return Response::json([
            'respuesta' => 'mensaje_enviado',
            'codigo' => $codigo,
            'user' => $consultarUsuario,
            'mensaje' => 'Hemos encontrado tu usuario.',
            'mensaje_n2' => 'Ingresa el código de 6 dígitos que enviamos a tu celular terminado en '
          ]);

        }else{

          return Response::json([
            'respuesta' => 'usuario_sin_app',
            'conductor' => $conductor,
            'mensaje' => 'Actualmente no dispones de un usuario en nuestra APP.',
            'mensaje_n2' => '¿Quieres crear tu usuario?'
          ]);

        }

      }else{

        return Response::json([
          'respuesta' => false,
          'mensaje' => 'No se encontró ningún registró con tu número de cédula. <br>Valida la información e inténtalo de nuevo, o comunícate con servicio al cliente.'
        ]);

      }

    }

    public function postValidarcodigo() {

      $user_id = Input::get('user_id');
      $code = Input::get('code');

      $query = DB::table('users')
      ->where('id',$user_id)
      ->where('code',$code)
      ->first();

      if($query) {

        return Response::json([
          'respuesta' => true,
          'mensaje' => 'El código ingresado es correcto.'
        ]);

      }else{

        return Response::json([
          'respuesta' => 'incorrecto',
          'mensaje' => 'El código ingresado está errado. Valida e inténtalo de nuevo.'
        ]);

      }

    }

    public function postReestablecercontrasena() {

      $password = Input::get('password');
      $user_id = Input::get('user_id');

      $user = User::find($user_id);
      $user->password = Hash::make($password);

      if($user->save()) {

        return Response::json([
          'respuesta' => true,
          'mensaje' => 'Tu contraseña ha sido actualizada de forma exitosa.'
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postValidaremail() { //UP CLIENT

      $email =  Input::get('email');

      $user = DB::table('users')
      ->where('email',$email)
      ->first();

      if($user!=null){

        return Response::json([
          'respuesta' => false
        ]);

      }else{

        $str = "";
        $characters = array_merge(range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < 5; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }

        $temp = new Temp;
        $temp->email = strtoupper($email);
        $temp->codigo = $str;
        $temp->save();

        //Envíar el código de confirmación al usuario
        $data = [
          'code' => $str
        ];
        //$email = 'sistemas@aotour.com.co';
        //$cc = ['aotourdeveloper@gmail.com','comercial@aotour.com.co','servicioalcliente@aotour.com.co'];
        $cc = '';

        Mail::send('mobile.client.email_validation_code', $data, function($message) use ($email){
          $message->from('no-reply@aotour.com.co', 'Notificaciones Aotour');
          $message->to($email)->subject('Confirma tu correo');
        });
        //Envíar el código de confirmación al usuario

        return Response::json([
          'respuesta' => true,
          'code' => $str,
          'id' => $temp->id
        ]);

      }
    }

    public function postValidarcodeuser() {

      $code = Input::get('code');
      $id = Input::get('id');

      $consulta = DB::table('temp')
      ->where('id',$id)
      ->first();

      if($consulta->codigo == $code){

        return Response::json([
          'respuesta' => true,
          'mensaje' => 'Código correcto',
          'consulta' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'mensaje' => 'Código inválido',
          'consulta' => $consulta
        ]);

      }

    }

    public function postReenviarcode() {

      $id = Input::get('id');

      $user = Temp::find($id);

      if($user!=null){

        //Envíar el código de confirmación al usuario
        $data = [
          'code' => $str
        ];
        //$email = $user->email;
        $email = 'sistemas@aotour.com.co';
        //$cc = ['aotourdeveloper@gmail.com','comercial@aotour.com.co','servicioalcliente@aotour.com.co'];
        $cc = '';

        Mail::send('mobile.client.email_validation_code', $data, function($message) use ($email, $id, $cc){
          $message->from('no-reply@aotour.com.co', 'Notificaciones Aotour');
          $message->to($email)->subject('Confirma tu correo');
        });
        //Envíar el código de confirmación al usuario

        return Response::json([
          'respuesta' => true,
          'code' => $user->code
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postCreateaccount(){

      $idioma = Input::get('idioma');

      $tipo = Input::get('tipo');

      $nombres = Input::get('nombre');
      $apellidos = Input::get('apellido');
      $telefono = Input::get('telefono');
      $contrasena = Input::get('password');
      $empresa = Input::get('empresa');
      $correo = Input::get('email');

      $cargo = Input::get('cargo');
      $centro = Input::get('centro');

      $usuario = DB::table('users')
      ->where('email',$correo)
      ->first();

      if($usuario){

        return Response::json([
          'response' => false,
          'error' => 'existe'
        ]);

      }else{

        $identificacion = Input::get('id_empleado');

        $user = new User();

        if ($tipo=='empresarial') {
          $user->empresarial = 1;
          $user->empresa = trim(strtoupper(strtolower($empresa)));
          $user->centro_de_costo = trim($centro);
          $user->cargo = trim($cargo);
        }else{
          $user->particular = 1;
        }

        $user->first_name = strtoupper(strtolower($nombres));
        $user->last_name = strtoupper(strtolower($apellidos));
        $user->email = strtolower($correo);
        $user->telefono = $telefono;
        $user->password = Hash::make($contrasena);
        $user->activation_code = str_random(40);
        $user->usuario_app = 2;
        $user->activated = 1;

        if($empresa!=null) {
            $user->empresa = trim(strtoupper(strtolower($empresa)));
            $user->identificacion = $identificacion;
            $user->id_empleado = $identificacion;
        }

        if ($user->save()) {

          $data = [
            'activation_code' => $user->activation_code
          ];

          $userArray = [
            'id' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'telefono' => $user->telefono,
            'empresarial' => $user->empresarial,
            'centro' => $user->centrodecosto_id
          ];

          $sub = new Subcentro;
          $sub->nombresubcentro = $nombres.' '.$apellidos;
          $sub->email_contacto = $correo;
          $sub->celular = $telefono;
          $sub->centrosdecosto_id = 100;
          $sub->save();

          $updateUser = DB::table('users')
          ->where('id',$user->id)
          ->update([
            'centrodecosto_id' => 100,
            'subcentrodecosto_id' => $sub->id
          ]);

          /*Código de envío Email Creación de Uusario (Link de Activación)*/

          /*if (!$tipo=='empresarial') {

            if($idioma=='en'){

              Mail::send('mobile.client.email_activacion_en', $datos, function($message) use ($correo, $emailcc){
                $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
                $message->to($correo)->subject('Account Activation');
                $message->cc($emailcc);
              });

            }else{

              Mail::send('mobile.client.email_activacion', $datos, function($message) use ($correo, $emailcc){
                $message->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
                $message->to($correo)->subject('Activacion de cuenta');
                $message->cc($emailcc);
              });

            }

          }*/

          return Response::json([
            'response' => true,
            //'token' => $token,
            'userArray' => $userArray
          ]);

        }
      }
    }

    public function postMessages() {

        $data = file_get_contents('php://input');
        $var = json_decode($data);

        $siigo = new Siigo;
        $siigo->token = $data;
        $siigo->wid = $var->entry[0]->changes[0]->value->statuses[0]->id;
        $siigo->number = $var->entry[0]->changes[0]->value->statuses[0]->recipient_id;
        $siigo->status = $var->entry[0]->changes[0]->value->statuses[0]->status;
        $siigo->save();

        return $_REQUEST['hub_challenge'];

    }

    public function postMistransacciones() {

        try {
            
            $data = file_get_contents('php://input');
            $secret = 'prod_events_QbYVzIaLZU2SurSz5teCHrXGJ0evBJWJ';
            $var = json_decode($data);

            $checksum = $var->signature->checksum;

            $id = $var->data->transaction->id;
            $status = $var->data->transaction->status;
            $amount_in_cents = $var->data->transaction->amount_in_cents;

            $timestamp = $var->timestamp;

            $cadena = $id.$status.$amount_in_cents.$timestamp.$secret;

            $validador = hash ("sha256", $cadena);

            if($checksum==$validador) {

                $referenceCode = $var->data->transaction->reference;

                $reference = DB::table('referencias_payu')
                ->where('reference_code',$referenceCode)
                ->first();

                if($reference!=null) {

                    if($status=='APPROVED') {

                        $valor = DB::table('servicios_aplicacion')
                        ->where('id',$reference->servicio_aplicacion_id)
                        ->pluck('valor');

                        $pago = new PagoServicio;
                        $pago->reference_code = $referenceCode;
                        $pago->order_id = $id;
                        $pago->user_id = $reference->user_id;
                        $pago->valor = $valor;
                        $pago->numero_tarjeta = '************'.$reference->lastfour;
                        $pago->tipo_tarjeta = $reference->paymentMethod;
                        $pago->estado = $status;

                        $pago->save();

                        $update = DB::table('servicios_aplicacion')
                        ->where('id',$reference->servicio_aplicacion_id)
                        ->update([
                            'pago_servicio_id' => $pago->id,
                            'fecha_pago' => date('Y-m-d H:i:s')
                        ]);

                        Servicio::notificarCliente($reference->user_id, $reference->servicio_aplicacion_id);

                    }else if($status=='DECLINED') {

                        $valor = DB::table('servicios_aplicacion')
                        ->where('id',$reference->servicio_aplicacion_id)
                        ->pluck('valor');

                        $pago = new PagoServicio;
                        $pago->reference_code = $referenceCode;
                        $pago->order_id = $id;
                        $pago->user_id = $reference->user_id;
                        $pago->valor = $valor;
                        $pago->numero_tarjeta = '************'.$reference->lastfour;
                        $pago->tipo_tarjeta = $reference->paymentMethod;
                        $pago->estado = $status;

                        $pago->save();

                        $update = DB::table('servicios_aplicacion')
                        ->where('id',$reference->servicio_aplicacion_id)
                        ->update([
                            'pago_servicio_id' => $pago->id,
                            'fecha_pago' => date('Y-m-d H:i:s')
                        ]);

                        Servicio::notificarCliente2($reference->user_id, $reference->servicio_aplicacion_id);
                    }

                }

            }

        } catch (Exception $e) {

            // $nuevo = new Welcome;
            // $nuevo->mensaje = 'error 500';
            // $nuevo->save();
        }
    }

    public function postMistransaccionesdebug() { //URL DE PRUEBAS

        try {
            
            $data = file_get_contents('php://input');
            $secret = 'test_events_2o4Sp8v96MRF0BCe0CWRhWencHFT8lhB';
            $var = json_decode($data);

            $checksum = $var->signature->checksum;

            $id = $var->data->transaction->id;
            $status = $var->data->transaction->status;
            $amount_in_cents = $var->data->transaction->amount_in_cents;

            $timestamp = $var->timestamp;

            $cadena = $id.$status.$amount_in_cents.$timestamp.$secret;

            $validador = hash ("sha256", $cadena);

            if($checksum==$validador) {

                $referenceCode = $var->data->transaction->reference;

                $reference = DB::table('referencias_payu')
                ->where('reference_code',$referenceCode)
                ->first();

                if($reference!=null) {

                    if($status=='APPROVED') {

                        $valor = DB::table('servicios_aplicacion')
                        ->where('id',$reference->servicio_aplicacion_id)
                        ->pluck('valor');

                        $pago = new PagoServicio;
                        $pago->reference_code = $referenceCode;
                        $pago->order_id = $id;
                        $pago->user_id = $reference->user_id;
                        $pago->valor = $valor;
                        $pago->numero_tarjeta = '************'.$reference->lastfour;
                        $pago->tipo_tarjeta = $reference->paymentMethod;
                        $pago->estado = $status;

                        $pago->save();

                        $update = DB::table('servicios_aplicacion')
                        ->where('id',$reference->servicio_aplicacion_id)
                        ->update([
                            'pago_servicio_id' => $pago->id,
                            'fecha_pago' => date('Y-m-d H:i:s')
                        ]);

                        Servicio::notificarCliente($reference->user_id, $reference->servicio_aplicacion_id);

                    }else if($status=='DECLINED') {

                        $valor = DB::table('servicios_aplicacion')
                        ->where('id',$reference->servicio_aplicacion_id)
                        ->pluck('valor');

                        $pago = new PagoServicio;
                        $pago->reference_code = $referenceCode;
                        $pago->order_id = $id;
                        $pago->user_id = $reference->user_id;
                        $pago->valor = $valor;
                        $pago->numero_tarjeta = '************'.$reference->lastfour;
                        $pago->tipo_tarjeta = $reference->paymentMethod;
                        $pago->estado = $status;

                        $pago->save();

                        $update = DB::table('servicios_aplicacion')
                        ->where('id',$reference->servicio_aplicacion_id)
                        ->update([
                            'pago_servicio_id' => $pago->id,
                            'fecha_pago' => date('Y-m-d H:i:s')
                        ]);

                        Servicio::notificarCliente2($reference->user_id, $reference->servicio_aplicacion_id);
                    }

                    /*$nuevo = new Welcome;
                    $nuevo->mensaje = $checksum;
                    if($reference){
                        $nuevo->img = $validador;
                    }
                    $nuevo->save();*/
                }

            }

        } catch (Exception $e) {

            /*$nuevo = new Welcome;
            $nuevo->mensaje = 'error 500';
            $nuevo->save();*/
        }
    }

    public function postEnviarcodigo() {

        $email = Input::get('email');

        $search = DB::table('users')
        ->where('email',$email)
        ->first();

        if($search) {

            /*Envío de correo al usuario*/

            $email = $search->email;
            //$email = 'sistemas@aotour.com.co';

            $cc = ['aotourdeveloper@gmail.com'];

            $code = 0;

            $code = "";
            $characters = array_merge(range('0','9'));
            $max = count($characters) - 1;
            for ($i = 0; $i < 5; $i++) {
              $rand = mt_rand(0, $max);
              $code .= $characters[$rand];
            }

            $updateCode = DB::table('users')
            ->where('id',$search->id)
            ->update([
                'code' => $code
            ]);

            $data = [
              'id' => 1,
              'code' => $code,
              'name' => $search->first_name
            ];

            Mail::send('mobile.client.change_password', $data, function($message) use ($email, $cc){
              $message->from('no-reply@aotour.com.co', 'UP by Aotour');
              $message->to($email)->subject('Restablece tu contraseña');
              //$message->cc($cc);
            });
            /*Envío de correo al usuario*/

            return Response::json([
                'respuesta' => true,
                'user_id' => $search->id
            ]);

        }else{

            return Response::json([
                'respuesta' => 'no_existe'
            ]);

        }

    }

    public function postValidarcodigocliente() {

      $user_id = Input::get('user_id');
      $code = Input::get('code');

      $query = DB::table('users')
      ->where('id',$user_id)
      ->where('code',$code)
      ->first();

      if($query) {

        return Response::json([
          'respuesta' => true,
          'mensaje' => 'El código ingresado es correcto.'
        ]);

      }else{

        return Response::json([
          'respuesta' => 'incorrecto',
          'mensaje' => 'El código ingresado está errado. Valida e inténtalo de nuevo.'
        ]);

      }

    }

    public function postReestablecercontrasenacliente() {

      $password = Input::get('password');
      $user_id = Input::get('user_id');

      $user = User::find($user_id);
      $user->password = Hash::make($password);

      if($user->save()) {

        return Response::json([
          'respuesta' => true,
          'mensaje' => 'Tu contraseña ha sido actualizada de forma exitosa.'
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    /*UP NET*/

    public function postLoginup1(){

        try {

            Config::set('cartalyst/sentry::users.login_attribute', 'username');

            $credentials = array(
                'username'=> Input::get('usuario'),
                'password' => Input::get('password'),
            );

            $remember = Input::get('recordarme');

            $user = Sentry::authenticate($credentials, $remember);

            if($user){

                return Response::json([
                    'mensaje'=>true,
                    'user' => $user
                ]);

            }

        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            return Response::json([
                'mensaje'=>false,
                'respuesta'=>'El campo de usuario es requerido'
            ]);

        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            return Response::json([
                'mensaje'=>false,
                'respuesta'=>'La contrase&ntildea es requerida'
            ]);
        }
        catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
        {
            return Response::json([
                'mensaje'=>false,
                'respuesta'=>'Contrase&ntildea incorrecta'
            ]);
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return Response::json([
                'mensaje'=>false,
                'respuesta'=>'Usuario no encontrado'
            ]);
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            return Response::json([
                'mensaje'=>false,
                'respuesta'=>'Usuario no activado'
            ]);
        }

       // The following is only required if the throttling is enabled
        catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
        {
            return Response::json([
                'mensaje'=>false,
                'respuesta'=>'El usuario ha sido suspendido'
            ]);
        }
        catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
        {
            return Response::json([
                'mensaje'=>false,
                'respuesta'=>'El usuario ha sido baneado'
            ]);
        }

        
    }

    public function postLoginup()
    {
        $username = Input::get('email');
        $password = Input::get('password');

        $validaciones = [
            'email' => 'required',
            'password' => 'required'
        ];

        $mensajesValidacion = [
            'email.required' => 'El campo email es requerido!',
            'password.required' => 'El campo password es requerido'
        ];

        $validador = Validator::make(Input::all(), $validaciones, $mensajesValidacion);

        if ($validador->fails()){

            return Response::json([
                'errores'=>$validador->errors()->getMessages(),
                'respuesta'=>false
            ]);

        }else {

            try {

                $credentials = array(
                    'email' => $username,
                    'password' => $password
                );

                Config::set('cartalyst/sentry::users.login_attribute', 'email');

                $user = Sentry::authenticate($credentials);

                if ($user) {

                    $dataUser = DB::table('oauth_clients')->where('id', 1)->first();

                    $usuario = DB::table('users')
                    ->where('email',$username)
                    ->first();

                    if($usuario->baneado==1){

                      return Response::json([
                          'response' => 'login'
                      ]);

                    }else if ($dataUser) {

                        Input::merge([
                            'grant_type' => 'password',
                            'client_id' => $dataUser->id,
                            'client_secret' => $dataUser->secret
                        ]);

                        return Response::json([
                            'response' => $this->authorizer->issueAccessToken(),
                            'acceso' => true,
                            'id_usuario' => Sentry::getUser()->id,
                            'tipo_usuario' => Sentry::getUser()->tipo_usuario
                        ]);

                    } else {

                        return Response::json('No contiene registro para token', 404);

                    }
                }

                Sentry::logout();

            } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
                return Response::json([
                    'mensaje' => false,
                    'respuesta' => 'Contraseña incorrecta'
                ]);

            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                return Response::json([
                    'mensaje' => false,
                    'respuesta' => 'Usuario no encontrado'
                ]);
            } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {

                return Response::json([
                    'mensaje' => false,
                    'respuesta' => 'El usuario no ha sido activado'
                ]);

            } // The following is only required if the throttling is enabled
            catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {

                return Response::json([
                    'mensaje' => false,
                    'respuesta' => 'El usuario ha sido suspendido'
                ]);

            } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {

                return Response::json([
                    'mensaje' => false,
                    'respuesta' => 'El usuario ha sido baneado'
                ]);

            }
        }
    }

    public function postNavevent() {

        $identificador = Input::get('identificador');

        $latitude = Input::get('latitude');
        $longitude = Input::get('longitude');

        $objArray = null;

        $array = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'timestamp' => date('Y-m-d H:i:s')
        ];

        $evento = new EventoNav;
        $evento->identificador = $identificador;
        $evento->coords = json_encode([$array]);
        $evento->latitude = Input::get('latitude');
        $evento->longitude = Input::get('longitude');
        $evento->fecha = date('Y-m-d H:i:s');
        $evento->save();

        
        $servicio = Servicio::find(690015);

        //DB::table('servicios')
        //->where('id',)
        //->pluck('recorrido_gps');

        $latitude =  substr(Input::get('latitude'), 0, 10);
        $longitude = substr(Input::get('longitude'), 0, 10);

        //Objeto array json
        $objArray = null;

        //Array a insertar en json
        $array = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'timestamp' => date('Y-m-d H:i:s')
        ];

        //
        if ($servicio->recorrido_gps==null) {

          $servicio->recorrido_gps = json_encode([$array]);

        }else{

          $objArray = json_decode($servicio->recorrido_gps);
          array_push($objArray, $array);
          $servicio->recorrido_gps = json_encode($objArray);

        }
        //
        $servicio->save();

        return Response::json([
            'response' => true
        ]);

    }

    public function postConductoress() {

        $conductores = "SELECT * FROM conductores WHERE id IN(1660)";
        $conductores = DB::select($conductores);

        return Response::json([
            'conductores' => $conductores
        ]);

    }

    public function postProveedoress() {

        $query = "SELECT * FROM proveedores WHERE id = 775";
        $consulta = DB::select($query);

        return Response::json([
            'proveedores' => $consulta
        ]);

    }

    public function postVehiculoss() {

        $query = "SELECT * FROM proveedores WHERE id = 775";
        $consulta = DB::select($query);

        return Response::json([
            'proveedores' => $consulta
        ]);

    }

    public function postListarcoordenadas() {

        $coordenadas = DB::table('eventos_nav')
        ->where('identificador',Input::get('id'))
        ->get();

        return Response::json([
            'response' => true,
            'coordenadas' => $coordenadas
        ]);

    }

    public function postNuevoproveedor() {

        $prov = Input::get('proveedor');

        if($prov['fk_tipos_empresa']==20) {
            $tipoE = 'PN';
        }else if($prov['fk_tipos_empresa']==15) {
            $tipoE = 'S.A.S';
        }else if($prov['fk_tipos_empresa']==19) {
            $tipoE = 'L.T.D.A';
        }else if($prov['fk_tipos_empresa']==16) {
            $tipoE = 'S.A';
        }else if($prov['fk_tipos_empresa']==17) {
            $tipoE = 'S.C.A';
        }else if($prov['fk_tipos_empresa']==18) {
            $tipoE = 'S.C';
        }else{
            $tipoE = 'PN';
        }

        if($prov['fk_sede']==1) {
            $sede = 'BARRANQUILLA';
            $dep = 'ALTÁNTICO';
        }else if($prov['fk_sede']==2) {
            $sede = 'BOGOTA';
            $dep = 'CUNDINAMARCA';
        }else{
            $sede = 'BARRANQUILLA';
            $dep = 'ALTÁNTICO';
        }

        if($prov['fk_tipo_cuenta']==9) {
            $tipoC = 'AHORROS';
        }else if($prov['fk_tipo_cuenta']==10) {
            $tipoC = 'CORRIENTE';
        }

        if($prov['fk_banco']==2) {
            $banc = 'BANCO DE BOGOTA';
        }else if($prov['fk_banco']==3) {
            $banc = 'BANCO BBVA';
        }else if($prov['fk_banco']==1) {
            $banc = 'BANCOLOMBIA';
        }else if($prov['fk_banco']==4) {
            $banc = 'BANCO DAVIVIENDA';
        }else if($prov['fk_banco']==5) {
            $banc = 'BANCO POPULAR';
        }else if($prov['fk_banco']==6) {
            $banc = 'SCOTIABANK COLPATRIA S.A';
        }else if($prov['fk_banco']==7) {
            $banc = 'BANCOOMEVA';
        }else if($prov['fk_banco']==8) {
            $banc = 'BANCO FALABELLA S.A';
        }else if($prov['fk_banco']==9) {
            $banc = 'ITAÚ';
        }else if($prov['fk_banco']==10) {
            $banc = 'BANCO CAJA SOCIAL';
        }else if($prov['fk_banco']==11) {
            $banc = 'BANCO DE OCCIDENTE';
        }else if($prov['fk_banco']==12) {
            $banc = 'BANCO AV VILLAS';
        }else if($prov['fk_banco']==13) {
            $banc = 'BANCO PICHINCHA';
        }else if($prov['fk_banco']==14) {
            $banc = 'HELM BANK';
        }else if($prov['fk_banco']==15) {
            $banc = 'SUDAMERIS';
        }else if($prov['fk_banco']==16) {
            $banc = 'HSBC';
        }

        $proveedor = new Proveedor();
        $proveedor->id = $prov['id'];
        $proveedor->nit = $prov['nit'];
        $proveedor->codigoverificacion = $prov['digito'];
        $proveedor->tipo_afiliado = 1;
        $proveedor->razonsocial = strtoupper($prov['razonsocial']);
        $proveedor->tipoempresa = $tipoE;
        $proveedor->localidad = $sede;
        $proveedor->direccion = strtoupper($prov['direccion']);
        $proveedor->departamento = $dep;
        $proveedor->ciudad = $sede;
        $proveedor->celular = $prov['celular'];
        $proveedor->email = $prov['email'];
        $proveedor->tipo_servicio = 'TRANSPORTE TERRESTRE';

        $proveedor->tipo_cuenta = $tipoC;
        $proveedor->entidad_bancaria = $banc;
        $proveedor->numero_cuenta = $prov['numero_cuenta'];
        $proveedor->save();

        $conductores = Input::get('conductores');

        foreach ($conductores as $conductor) {
            
            if($conductor['fk_tipo_licencia']==18) {
                $tipoLic = 'A1';
            }else if($conductor['fk_tipo_licencia']==19) {
                $tipoLic = 'B1';
            }else if($conductor['fk_tipo_licencia']==20) {
                $tipoLic = 'B2';
            }else if($conductor['fk_tipo_licencia']==21) {
                $tipoLic = 'B3';
            }else if($conductor['fk_tipo_licencia']==22) {
                $tipoLic = 'C1';
            }else if($conductor['fk_tipo_licencia']==23) {
                $tipoLic = 'C2';
            }else if($conductor['fk_tipo_licencia']==24) {
                $tipoLic = 'C3';
            }

            if($conductor['fk_genero']==16) {
                $genero = 'MASCULINO';
            }else if($conductor['fk_genero']==17) {
                $genero = 'FEMENINO';
            }

            $driver = new Conductor;
            $driver->id = $conductor['id'];
            $driver->nombre_completo = strtoupper($conductor['primer_nombre'].' '.$conductor['primer_apellido']);
            $driver->fecha_vinculacion = $conductor['fecha_vinculacion'];
            $driver->fecha_nacimiento = $conductor['fecha_de_nacimiento'];
            $driver->departamento = $dep;
            $driver->ciudad = $sede;
            $driver->cc = $conductor['numero_documento'];
            $driver->celular = $conductor['celular'];
            $driver->direccion = strtoupper($conductor['direccion']);
            $driver->tipodelicencia = $tipoLic;
            $driver->fecha_licencia_expedicion = $conductor['fecha_licencia_expedicion'];
            $driver->fecha_licencia_vigencia = $conductor['fecha_licencia_vigencia'];
            $driver->edad = 30;
            $driver->genero = $genero;
            $driver->grupo_trabajo = 'OPERATIVO';
            $driver->cargo = 'CONDUCTOR';
            $driver->experiencia = $conductor['experiencia'];
            $driver->accidentes = 'NO';
            $driver->incidentes = 'NO';
            $driver->vehiculo_propio_desplazamiento = 'NO';
            $driver->trayecto_casa_trabajo = 'OTROS';
            $driver->proveedores_id = $proveedor->id;
            $driver->creado_por = 2;
            $driver->save();

        }

        $vehiculos = Input::get('vehiculos');

        foreach ($vehiculos as $vehiculo) {
            
            if($vehiculo['fk_tipo_vehiculo']==38) {
                $clase = 'AUTOMOVIL';
            }else if($vehiculo['fk_tipo_vehiculo']==39) {
                $clase = 'CAMIONETA';
            }else if($vehiculo['fk_tipo_vehiculo']==40) {
                $clase = 'MINI VAN';
            }else if($vehiculo['fk_tipo_vehiculo']==41) {
                $clase = 'VAN';
            }else if($vehiculo['fk_tipo_vehiculo']==42) {
                $clase = 'MICROBUS';
            }

            $vehicle = new Vehiculo;
            $vehicle->id = $vehiculo['id'];
            $vehicle->placa = $vehiculo['placa'];
            $vehicle->numero_motor = $vehiculo['numero_motor'];
            $vehicle->clase = $clase;
            $vehicle->marca = $vehiculo['marca'];
            $vehicle->modelo = $vehiculo['modelo'];
            $vehicle->ano = $vehiculo['ano'];
            $vehicle->capacidad = $vehiculo['capacidad'];
            $vehicle->color = $vehiculo['color'];
            $vehicle->propietario = strtoupper($prov['razonsocial']);
            $vehicle->cc = $prov['nit'];
            $vehicle->empresa_afiliada = $vehiculo['empresa_afiliada'];
            $vehicle->tarjeta_operacion = $vehiculo['tarjeta_operacion'];
            $vehicle->fecha_vigencia_operacion = $vehiculo['fecha_vigencia_operacion'];
            $vehicle->fecha_vigencia_soat = $vehiculo['fecha_vigencia_soat'];
            $vehicle->fecha_vigencia_tecnomecanica = $vehiculo['fecha_vigencia_tecnomecanica'];
            $vehicle->mantenimiento_preventivo = $vehiculo['mantenimiento_preventivo'];
            $vehicle->poliza_todo_riesgo = $vehiculo['poliza_todo_riesgo'];
            $vehicle->poliza_contractual = $vehiculo['poliza_contractual'];
            $vehicle->poliza_extracontractual = $vehiculo['poliza_extracontractual'];
            $vehicle->creado_por = 2;
            $vehicle->proveedores_id = $proveedor->id;
            $vehicle->numero_interno = $vehiculo['numero_interno'];
            $vehicle->numero_vin = $vehiculo['numero_vin'];
            $vehicle->cilindraje = $vehiculo['cilindraje'];
            $vehicle->save();

        }

        //Envio de usuario
        //$id = Input::get('id');

        /*$proveedor = DB::table('proveedores')
        ->where('id',$id)
        ->first();*/

        Config::set('cartalyst/sentry::users.login_attribute', 'username');

        $user = Sentry::createUser([
          'username' => $proveedor->email,
          'password'  => $proveedor->nit,
          'activated' => true,
          'first_name'=> $proveedor->razonsocial,
          'identificacion' => $proveedor->nit,
          //'last_name' =>$proveedor->razonsocial,
          'tipo_usuario' => 8,
          'usuario_portal' => 2,
          'id_rol' => 49,
          'proveedor_id' => $proveedor->id
          //'localidad' => Input::get('localidad')
        ]);

        if ($user) {

            /*ENVÍO DE CORREO AL PROVEEDOR*/
            $email = $proveedor->email;
            $data = [
                'id' => $proveedor->id,
                'email' => $proveedor->email,
                'pass' => $proveedor->nit
              ];
            Mail::send('portalproveedores.emails.entrega_usuario', $data, function($message) use ($email){
              $message->from('no-reply@aotour.com.co', 'AOTOUR');
              $message->to($email)->subject('PORTAL PORVEEDORES');
              $message->cc('aotourdeveloper@gmail.com');
            });
            /*FIN ENVÍO DE CORREO AL PROVEEDOR*/

        }
        //Envio de usuario

        return Response::json([
            'response' => true,
            'conductores' => $conductores
        ]);

    }

    public function postClientes() {

        $clientes = DB::table('centrosdecosto')
        //->whereIn('id',[19,97,343,474])
        ->get();

        return Response::json([
            'clientes' => $clientes
        ]);

    }

    public function postProveedores() {

        $clientes = DB::table('proveedores')
        ->whereBetween('id',[1,772])
        ->get();

        return Response::json([
            'proveedores' => $clientes
        ]); 

    }

    public function postSubcentros() {

        $clientes = DB::table('subcentrosdecosto')
        ->get();

        return Response::json([
            'subcentros' => $clientes
        ]); 

    }

    public function postVehiculos() {

        $clientes = DB::table('vehiculos')
        ->where('id',801)
        ->get();

        return Response::json([
            'vehiculos' => $clientes
        ]);

    }

    public function postBuscarusuario() {

        $usuario = DB::table('users')
        ->where('id', Input::get('id_usuario'))
        ->first();

        return Response::json([
            'response' => true,
            'id' => Input::get('id'),
            'email' => $usuario->email,
            'password' => $usuario->password,
            'device' => $usuario->device,
            'idregistrationdevice' => $usuario->idregistrationdevice
        ]);

    }

    public function postServicios() {

        //$query = "SELECT * FROM servicios WHERE fecha_servicio BETWEEN '20240711' AND '20241231' AND localidad is null AND pendiente_autori_eliminacion IS NULL AND ruta IS NULL ";
        //$query = "SELECT id, pasajeros_ruta, fecha_servicio FROM servicios WHERE fecha_servicio BETWEEN '20240701' AND '20240701' AND localidad IS NOT null AND pendiente_autori_eliminacion IS NULL AND ruta IS NOT NULL";
        
        //$query = "SELECT id, departamento, ciudad, tipo_ruta, centrodecosto_id, subcentrodecosto_id, solicitado_por, email_solicitante, fecha_solicitud, ruta_id, detalle_recorrido, proveedor_id, conductor_id, vehiculo_id, fecha_servicio, hora_servicio, control_facturacion, recoger_en, dejar_en, pasajeros_ruta, vuelo, expediente, pasajeros FROM servicios WHERE fecha_servicio BETWEEN '20240710' AND '20240710' AND localidad IS NOT null AND pendiente_autori_eliminacion IS NULL AND ruta IS NULL";

        //$query = "select id, departamento, ciudad, tipo_ruta, centrodecosto_id, subcentrodecosto_id, solicitado_por, email_solicitante, fecha_solicitud, ruta_id, detalle_recorrido, proveedor_id, conductor_id, vehiculo_id, fecha_servicio, hora_servicio, control_facturacion, recoger_en, dejar_en, pasajeros_ruta FROM servicios where id in(737610, 737611, 737612, 737613, 737614, 737615, 737081, 737082, 737083, 737622, 737623, 737624, 737625, 737627, 737687, 737626, 736458, 736459, 736462, 737084, 737086, 737087, 737088, 737089, 737090, 737091, 737092, 737484, 737628, 737629, 737630, 737636, 737637, 737638, 737639, 737640, 737641, 737642, 737643, 737644, 737645, 737646, 737631, 737632, 737633, 737634, 737635, 737648, 737649, 737650, 737651, 737652, 737085, 737653, 737654, 737655, 737656, 737657, 737658, 737659, 737660, 737661, 737662, 737663, 737664, 737665, 737666, 737667, 737668, 737669, 737670, 737480, 737481, 737482, 737483, 737671, 737672, 737673, 737674, 737675, 737676, 737677, 737678, 737679, 737680, 737681, 737682, 737683, 737684)";

        $query = "SELECT id, departamento, ciudad, tipo_ruta, centrodecosto_id, subcentrodecosto_id, solicitado_por, email_solicitante, fecha_solicitud, ruta_id, detalle_recorrido, proveedor_id, conductor_id, vehiculo_id, fecha_servicio, hora_servicio, control_facturacion, recoger_en, dejar_en, pasajeros_ruta, vuelo, expediente, pasajeros FROM servicios WHERE id in (731286,731287,731288,733901,733900)";

        $consulta = DB::select($query);

        /*$query = DB::table('servicios')
        ->where('id', 736268)
        ->first();

        $pass = json_decode($query->pasajeros_ruta);
        $name = null;
        foreach ($pass as $pa) {
            $name = $pa->nombres;
        }

        $pasajero = explode('/', $query->pasajeros);

        for ($i=0; $i <count($pasajero) ; $i++) { 
            
            $name = $pasajero[$i];
            if(explode(',', $name)[0]!=""){
                $name2 = explode(',', $name)[0];
            }

        }*/

        $cantidad = count($consulta);
        

        return Response::json([
            'cantidad' => $cantidad,
            'servicios' => $consulta,
        ]);

    }


    public function postTrayectos() { //Consultar los trayectos

        $trayectos = DB::table('traslados')
        ->get();

        return Response::json([
            'trayectos' => $trayectos
        ]);

    }

    public function postTarifasv() { //Consultar las tarifas

        $tarifas = DB::table('tarifas')
        ->get();

        return Response::json([
            'tarifas' => $tarifas
        ]);

    }

    public function postCrearclienteupnet() {

        $cliente = Input::get('cliente');
        $ejecutivos = Input::get('ejecutivos');
        $rutas = Input::get('rutas');

        if( $cliente['fk_sede']=="1" ) {
            $sede = 'barranquilla';
        }else if( $cliente['fk_sede']=="2" ) {
            $sede = 'bogota';
        }else if( $cliente['fk_sede']=="3" ) {
            $sede = 'PROVISIONAL';
        }

        $centrodecosto = new Centrodecosto;
        $centrodecosto->id = $cliente['id'];
        $centrodecosto->tipo_cliente = 1;
        $centrodecosto->nit = $cliente['nit'];
        $centrodecosto->codigoverificacion = $cliente['codigoverificacion'];
        $centrodecosto->razonsocial = strtoupper($cliente['razonsocial']);
        $centrodecosto->tipoempresa = $cliente['tipoempresa'];
        $centrodecosto->direccion = $cliente['direccion'];
        $centrodecosto->ciudad = $cliente['ciudad'];
        $centrodecosto->departamento = $cliente['departamento'];
        $centrodecosto->email = $cliente['email'];
        $centrodecosto->telefono = $cliente['telefono'];
        $centrodecosto->localidad = $sede;

        if($cliente['recargo_nocturno']==1) {
            $centrodecosto->recargo_nocturno = $cliente['recargo_nocturno'];
            $centrodecosto->desde = $cliente['desde'];
            $centrodecosto->hasta = $cliente['hasta'];
        }

        $centrodecosto->tarifa_aotour = $cliente['tarifa_aotour'];
        $centrodecosto->tarifa_aotour_proveedor = $cliente['tarifa_aotour_proveedor'];
        $centrodecosto->save();

        if($ejecutivos!=null) {
            $subcentro = new Subcentro;
            $subcentro->nombresubcentro = $ejecutivos['nombre'];
            $subcentro->centrosdecosto_id = $centrodecosto->id;
            $subcentro->save();
        }

        if($rutas!=null) {
            $subcentro = new Subcentro;
            $subcentro->nombresubcentro = $rutas['nombre'];
            $subcentro->centrosdecosto_id = $centrodecosto->id;
            $subcentro->save();
        }

        return Response::json([
            'response' => true
        ]);

    }

    public function postCrearsubcentroupnet() {

        $subcentros = Input::get('subcentro');

        $subcentro = new Subcentro;
        if( $subcentro['centrosdecosto_id']!=100 ) {
            $subcentro->nombresubcentro = $subcentros['nombre'];
        }else{
            $subcentro->nombresubcentro = $subcentros['nombre'].' '.$subcentros['apellido'];
        }
        $subcentro->celular = $subcentro['celular'];
        $subcentro->centrosdecosto_id = $subcentros['centrosdecosto_id'];
        $subcentro->save();

        return Response::json([
            'response' => true
        ]);

    }

    public function postConductoresautonet() {

        $conductores = DB::table('conductores')
        ->whereBetween('id',[1401,1614])
        ->get();

        return Response::json([
            'conductores' => $conductores
        ]);

    }

    public function postRutaactiva(){

      $user = User::find(Input::get('id'));

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      $diasiguiente = strtotime ('+1 day', strtotime($fecha));
      $diasiguiente = date ('Y-m-d' , $diasiguiente);

      $servicios_activos = DB::table('servicios')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->leftJoin('qr_rutas', 'qr_rutas.servicio_id', '=', 'servicios.id')
      ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.recoger_en', 'servicios.dejar_en', 'servicios.notificaciones_reconfirmacion as codigo', 'servicios.desde', 'servicios.hasta', 'servicios.tipo_ruta', 'servicios.detalle_recorrido', 'servicios.estado_servicio_app', 'servicios.recoger_pasajero', 'servicios.pendiente_autori_eliminacion', 'conductores.nombre_completo', 'conductores.celular', 'conductores.foto_app', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'vehiculos.clase', 'vehiculos.ano', 'vehiculos.color', 'qr_rutas.status', 'qr_rutas.id_usuario', 'qr_rutas.fullname', 'qr_rutas.address', 'qr_rutas.location', 'qr_rutas.coords', 'qr_rutas.sw')
      ->whereBetween('servicios.fecha_servicio', [$diaanterior, $diasiguiente])
      ->where('qr_rutas.id_usuario', intval($user->id_empleado))
      ->where('servicios.estado_servicio_app', 1)
      ->whereNull('servicios.pendiente_autori_eliminacion')
      //->whereNotNull('recorrido_gps')
      ->orderBy('servicios.fecha_servicio')
      ->orderBy('servicios.hora_servicio')
      ->first();

      $servicios_calificar = DB::table('servicios')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->leftJoin('qr_rutas', 'qr_rutas.servicio_id', '=', 'servicios.id')
      ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.recoger_en', 'servicios.dejar_en', 'servicios.estado_servicio_app', 'servicios.recoger_pasajero', 'servicios.calificacion_app_cliente_calidad', 'servicios.pendiente_autori_eliminacion', 'servicios.app_user_id', 'conductores.nombre_completo', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'vehiculos.clase', 'vehiculos.ano', 'vehiculos.color')
      ->where('servicios.fecha_servicio', '>', '20240420')
      ->where('qr_rutas.id_usuario', $user->id_empleado)
      ->where('servicios.estado_servicio_app', 2)
      ->whereNull('servicios.pendiente_autori_eliminacion')
      ->whereNull('qr_rutas.rate')
      ->first();

      if (count($servicios_activos)) {

        return Response::json([
          'response' => true,
          'servicios' => $servicios_activos,
          'calificar' => $servicios_calificar
        ]);

      }else {

        return Response::json([
          'response' => false,
          'calificar' => $servicios_calificar,
          'servicios' => $servicios_activos,
          'user' => $user
        ]);

      }

    }

}
