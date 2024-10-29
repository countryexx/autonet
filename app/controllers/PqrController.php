<?php

class PqrController extends BaseController{

    public function getIndex(){
    	if (Sentry::check()){
            $id_rol = Sentry::getUser()->id_rol;
            $idusuario = Sentry::getUser()->id;
            $userportal = Sentry::getUser()->usuario_portal;
            $identificacion = Sentry::getUser()->identificacion;
            $apellidosuser = DB::table('pasajeros')->where('cedula',$identificacion)->pluck('apellidos');
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

        return View::make('portalusuarios.generarpqr')
        ->with('userportal',$userportal)
        ->with('idusuario',$idusuario)
        ->with('permisos',$permisos)
        ->with('identificacion',$identificacion);
        }
    }
    //DESCARGA PQR
    public function getDescargarpqr($code){

    $data = $code;

    $nombres = DB::table('pqr_table')->where('id',$data)->pluck('nombre');
    $tiposolicitud = DB::table('pqr_table')->where('id',$data)->pluck('tipo');
    $direccion = DB::table('pqr_table')->where('id',$data)->pluck('direccion');
    $ciudad = DB::table('pqr_table')->where('id',$data)->pluck('ciudad');
    $email = DB::table('pqr_table')->where('id',$data)->pluck('email');
    $telefono = DB::table('pqr_table')->where('id',$data)->pluck('telefono');
    $info = DB::table('pqr_table')->where('id',$data)->pluck('info');
    $fecha = DB::table('pqr_table')->where('id',$data)->pluck('fecha_solicitud');
    $fecha_ocurrencia = DB::table('pqr_table')->where('id',$data)->pluck('fecha_ocurrencia');
    $id_servicio = DB::table('pqr_table')->where('id',$data)->pluck('id_servicio');
    $ruta = DB::table('pqr_table')->where('id',$data)->pluck('ruta');
    $placa = DB::table('pqr_table')->where('id',$data)->pluck('placa');
    $conductor = DB::table('pqr_table')->where('id',$data)->pluck('conductor');
    $tipo_servicio = DB::table('pqr_table')->where('id',$data)->pluck('tipo_serv');
    $info2 = DB::table('pqr_table')->where('id',$data)->pluck('descripcion');
    $nombres_r = DB::table('pqr_table')->where('id',$data)->pluck('nombres_r');
    $apellidos_r = DB::table('pqr_table')->where('id',$data)->pluck('apellidos_r');
    $direccion_r = DB::table('pqr_table')->where('id',$data)->pluck('direccion_r');
    $telefono_r = DB::table('pqr_table')->where('id',$data)->pluck('telefono_r');
    $correo_r = DB::table('pqr_table')->where('id',$data)->pluck('correo_r');

    $html = View::make('portalusuarios.admin.dashboard.pdf_pqr')->with([
      'data' => $data,
      'nombres' => $nombres,
      'tiposolicitud' => $tiposolicitud,
      'direccion' => $direccion,
      'ciudad' => $ciudad,
      'email' => $email,
      'telefono' => $telefono,
      'info' => $info,
      'info2' => $info2,
      'fecha' => $fecha,
      'fecha_ocurrencia' => $fecha_ocurrencia,
      'id_servicio' => $id_servicio,
      'ruta' => $ruta,
      'placa' => $placa,
      'conductor' => $conductor,
      'tipo_servicio' => $tipo_servicio,
      'info2' => $info2,
      'nombres_r' => $nombres_r,
      'apellidos_r' => $apellidos_r,
      'direccion_r' => $direccion_r,
      'telefono_r' => $telefono_r,
      'correo_r' => $correo_r,

    ]);

    return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('pqr #'.$data);

  }

  //FIN DESCARGA PQR

    public function postPqr(){

        $cliente = Sentry::getUser()->centrodecosto_id;
        if(Request::ajax()){


          $validaciones = [
            'nombres'=>'required',
            'telefono'=>'required',
            'tiposolicitud'=>'required|sololetrasyespacio',
            'email'=>'required|email',
            'ciudad'=>'required|sololetrasyespacio',
            'direccion'=>'required',
            'info'=>'required',
            'fecha_inicial' => 'required|date_format:Y-m-d',
            'aceptar_politicas'=>'accepted',
          ];

          $mensajes = [
            'nombres.required'=>'El campo nombres es obligatorio',
            'telefono.required'=>'El campo teléfono es obligatorio',
            'tiposolicitud.sololetrasyespacio'=>'El campo tipo de solicitud es obligatorio',
            'email.required'=>'El campo Correo Electrónico es obligatorio',
            'ciudad.sololetrasyespacio'=>'Debe seleccionar una opción de ciudad',
            'direccion.required'=>'El campo dirección es obligatorio',
            'info.required'=>'El campo descripción es obligatorio',
            'aceptar_politicas.accepted'=>'La opción de autorización de información es obligatoria'

          ];


            $validador = Validator::make(Input::all(), $validaciones,$mensajes);

          if ($validador->fails())
          {
            return Response::json([
              'mensaje'=>false,
              'errores'=>$validador->errors()->getMessages()
            ]);

          	}else{

	            $nombres = Input::get('nombres');
	            $telefono = Input::get('telefono');
	            $fecha = Input::get('fecha_inicial');
//                $fecha_ocurrencia = Input::get('fecha_ocurrencia');
	            $tiposolicitud = Input::get('tiposolicitud');
	            $info = Input::get('info');
	            $email = Input::get('email');
							$solicitante = Input::get('solicitante');
	            $ciudad = Input::get('ciudad');
	            $direccion = Input::get('direccion');

                if(Input::get('info2')==null){
                    $info2 = 'N/A';
                }else{
                    $info2 = Input::get('info2');
                }

                if(Input::get('tiposerv')==null){
                    $tiposerv = 'N/A';
                }else{
                    $tiposerv = Input::get('tiposerv');
                }

                if(Input::get('conductor')==null){
                    $conductor = 'N/A';
                }else{
                    $conductor = Input::get('conductor');
                }

                if(Input::get('ruta')==null){
                    $ruta = 'N/A';
                }else{
                    $ruta = Input::get('ruta');
                }

                if(Input::get('placa')==null){
                    $placa = 'N/A';
                }else{
                    $placa = Input::get('placa');
                }

                if(Input::get('servicio')==null){
                    $servicio = 'N/A';
                }else{
                    $servicio = Input::get('servicio');
                }

                if(Input::get('fecha_ocurrencia')==null)           {
                    $fecha_ocurrencia = 'N/A';
                }else{
                    $fecha_ocurrencia = Input::get('fecha_ocurrencia');
                }

                if(Input::get('nombres_r')==null){
                  $nombres_r = 'N/A';
                }else{
                  $nombres_r = Input::get('nombres_r');
                }

                if(Input::get('apellidos_r')==null){
                  $apellidos_r = 'N/A';
                }else{
                  $apellidos_r = Input::get('apellidos_r');
                }

                if(Input::get('direccion_r')==null){
                  $direccion_r = 'N/A';
                }else{
                  $direccion_r = Input::get('direccion_r');
                }

                if(Input::get('telefono_r')==null){
                  $telefono_r = 'N/A';
                }else{
                  $telefono_r = Input::get('telefono_r');
                }

                if(Input::get('correo_r')==null){
                  $correo_r = 'N/A';
                }else{
                  $correo_r = Input::get('correo_r');
                }

								if (Input::hasFile('soporte_pqr')){

				          $file_pdf = Input::file('soporte_pqr');
				          $name_pdf = str_replace(' ', '', $file_pdf->getClientOriginalName());

				          $ubicacion_pdf = 'biblioteca_imagenes/reportes/pqr/pdf/';

									if(file_exists($ubicacion_pdf.$name_pdf)){
	                  $name_pdf = rand(1,10000).$name_pdf;
	                }

				          $file_pdf->move($ubicacion_pdf, $name_pdf);
				          $soporte_pqr = $name_pdf;

				        }else{
				          $name_pdf = null;
				        }

	            $pasajero = new Pqr;
	            $pasajero->fecha_solicitud = $fecha;
              $pasajero->nombre = $nombres;
              $pasajero->direccion = $direccion;
              $pasajero->ciudad = $ciudad;
	            $pasajero->telefono = $telefono;
	            $pasajero->info = $info;
              $pasajero->descripcion = $info2;
	            $pasajero->email = $email;
							$pasajero->solicitante = $solicitante;
	            $pasajero->tipo = $tiposolicitud;
	            $username = Sentry::getUser()->username;
	            $dato = DB::table('pasajeros')->where('correo',$username)->pluck('centrodecosto_id');
	            $pasajero->cliente = $dato;
	            $data = DB::table('pasajeros')->where('correo',$username)->pluck('cedula');
	            $pasajero->id_user = $data;
            	$pasajero->id_servicio = $servicio;
            	$pasajero->ruta = $ruta;
            	$pasajero->placa = $placa;
            	$pasajero->conductor = $conductor;
            	$pasajero->tipo_serv = $tiposerv;
            	$pasajero->descripcion = $info2;
              $pasajero->fecha_ocurrencia = $fecha_ocurrencia;
							$pasajero->soporte_pqr = $soporte_pqr;

              $pasajero->nombres_r = $nombres_r;
              $pasajero->apellidos_r = $apellidos_r;
              $pasajero->direccion_r = $direccion_r;
              $pasajero->telefono_r = $telefono_r;
              $pasajero->correo_r = $correo_r;

	            if($pasajero->save()){
                    $idrecienguardado = $pasajero->id;
                    //envio de correo PQR
                        $correoelectronico = 'dcoba@aotour.com.co';
                        $correosistemas = 'sistemas@aotour.com.co';
                            $data = [
                              'nombres' => $nombres,
                              'telefono'=> $telefono,
                              'tipo_solicitud'=> $tiposolicitud,
                              'info' => $info,
                              'email'=> $email,
															'solicitante'=> $solicitante,
                              'ciudad'=> $ciudad,
                              'direccion' => $direccion,
                              'info2' => $info2,
                              'tiposerv' => $tiposerv,
                              'conductor' => $conductor,
                              'placa' => $placa,
                              'ruta' => $ruta,
                              'servicio' => $servicio,
                              'fecha' => $fecha,
                              'fecha_ocurrencia' => $fecha_ocurrencia,
                              'id' => $idrecienguardado,
                              'nombres_r' => $nombres_r,
                              'apellidos_r' => $apellidos_r,
                              'telefono_r' => $telefono_r,
                              'direccion_r' => $direccion_r,
                              'correo_r' => $correo_r,

                            ];
                            if($cliente==19){
                              Mail::send('emails.pdf_pqr', $data, function($message) use ($correoelectronico){
                                $message->from('aotourdeveloper@gmail.com', 'Reporte de PQR');
                                $message->to($correoelectronico)
                                ->bcc(array('jcalderon@aotour.com.co','lrada@aotour.com.co','gestionintegral@aotour.com.co'))
                                ->subject('PQR');
                              });
                            }else if($cliente==287){
                              Mail::send('emails.pdf_pqr', $data, function($message) use ($correoelectronico){
                                $message->from('aotourdeveloper@gmail.com', 'Reporte de PQR');
                                $message->to($correoelectronico)
                                ->bcc(array('jcalderon@aotour.com.co','jrosero@aotour.com.co','gestionintegral@aotour.com.co'))
                                ->subject('PQR');
                              });
                            }else{
                              Mail::send('emails.pdf_pqr', $data, function($message) use ($correoelectronico, $correosistemas){
                                $message->from('aotourdeveloper@gmail.com', 'Reporte de PQR');
                                $message->to($correosistemas)
                                ->subject('PQR');
                              });
                            }


                        //fin envio de correo PQR
	                return Response::json([
	                    'mensaje'=>true,
                        'respuesta'=>'PQR enviado con Éxito!',
                        'respuesta2'=>'Estudiaremos su PQR y pronto tendrá una resuesta!',
	                ]);
	            }
        	}
        }
      //}

    }//SG
}
