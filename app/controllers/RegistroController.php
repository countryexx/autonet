<?php
use App\User;
use App\Controllers\Controller;

class RegistroController extends BaseController{

    public function getIndex(){

      $departamentos = DB::table('departamento')->get();
      $centrosdecosto = Centrodecosto::Internos()->whereIn('id',[19,287])->orderBy('razonsocial')->get();
      $pasajeros = Pasajero::where('cedula', 12)->orderBy('nombres')->get();

      return View::make('servicios.pasajeros.Form_pasajeros')
      ->with('centrosdecosto',$centrosdecosto)      
      ->with('pasajeros',$pasajeros)
      ->with('departamentos',$departamentos)
      ->with('o',$o=1);
        
    }

    public function postRegistro(){

      if(Request::ajax()){

        $validaciones = [              
          'email'=>'email',
        ];

        $mensajes = [
          'email.email'=>'El campo EMAIL debe ser un correo electrónico válido',
        ];

        $validador = Validator::make(Input::all(), $validaciones,$mensajes);

        if ($validador->fails())
        {
          return Response::json([
            'respuesta'=>false,
            'errores'=>$validador->errors()->getMessages()
          ]);

        }else{

          $query_correo = DB::table('pre_registro')
          ->where('correo',Input::get('email'))
          ->pluck('correo');

          $query_cedula = DB::table('pre_registro')
          ->where('cedula',Input::get('cedula'))
          ->pluck('cedula');

          $query_id = DB::table('pre_registro')
          ->where('id_employer',Input::get('id_employer'))
          ->pluck('id_employer');
          
          //SI LA CÉDULA INGRESADA YA ESTÁ REGISTRADA

          if($query_correo!=null || $query_cedula!=null || $query_id!=null){
            
            $cedula_switch = 0;
            $id_switch = 0;
            $correo_switch = 0;

            if($query_correo!=null){
              $correo_switch = 1;
            }
            if($query_cedula!=null){
              $cedula_switch = 1;
            }
            if($query_id!=null){
              $id_switch = 1;
            }

            return Response::json([
              'mensaje'=>false,
              'cedula_duplicada'=> $cedula_switch,
              'id_duplicado'=> $id_switch,
              'correo_duplicado'=> $correo_switch,
            ]);

          }else{
            
            $direccion1 = Input::get('direccion1');
            $direccion2 = Input::get('direccion2');
            $direccion3 = Input::get('direccion3');        
            $calle1 = Input::get('calle1');
            $calle2 = Input::get('calle2');
            $complemento = Input::get('complemento');

            $dir = trim($calle1).' '.trim($direccion1).' '.trim($calle2).' '.trim($direccion2).' '.trim($direccion3).' '.trim($complemento);

            $nombres = Input::get('nombres');
            $apellidos = Input::get('apellidos');
            $id_employer = Input::get('id_employer');
            $cedula = Input::get('cedula');
            $empresa = Input::get('empresa');
            $area = Input::get('area');
            $area2 = Input::get('area2');
            $subarea = Input::get('subarea');
            $departamento = Input::get('departamento');
            $ciudad = Input::get('ciudad');
            $direccion = $dir;
            $barrio = Input::get('barrio');
            $localidad = Input::get('localidad');
            $email = Input::get('email');
            $celular = Input::get('celular');
            $eps = Input::get('eps');
            $arl = Input::get('arl');

            $centro = DB::table('centrosdecosto')->where('razonsocial',Input::get('empresa'))->pluck('id');

            $pasajero = new Pregistro;
            $pasajero->nombres = $nombres;
            $pasajero->apellidos = $apellidos;
            $pasajero->id_employer = $id_employer;
            $pasajero->cedula = $cedula;
            $pasajero->centrodecosto_id = $centro;
            if($area!='-'){
              $pasajero->area = $area;
            }else if($area2!=null){
              $pasajero->area = $area2;
            }
            $pasajero->sub_area = $subarea;
            $pasajero->departamento = $departamento;
            $pasajero->municipio = $ciudad;
            $pasajero->direccion = $direccion;
            $pasajero->barrio = $barrio;
            if($localidad!='-'){
              $pasajero->localidad = $localidad;
            }            
            $pasajero->correo = $email;
            $pasajero->telefono = $celular;
            $pasajero->eps = strtoupper($eps);
            $pasajero->arl = strtoupper($arl);

            //codigo email
            $str = "";
            $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
            $max = count($characters) - 1;

            for ($i = 0; $i < 20; $i++) {
              $rand = mt_rand(0, $max);
              $str .= $characters[$rand];
            }

            $code_email  = Crypt::encryptString(trim($cedula));
            
            $pasajero->codigo_confirmacion = $code_email;
            //codigo email

            //codigo tel
            $is = 0;
            while ($is == 0) {
              
              $tel = "";
              $characters = array_merge(range('0','9'));
              $max = count($characters) - 1;
              for ($i = 0; $i < 6; $i++) {
                $rand = mt_rand(0, $max);
                $tel .= $characters[$rand];
              }

              $search = DB::table('pre_registro')
              ->where('codigo_telefono',$tel)
              ->pluck('codigo_telefono');

              if($search===null){
                $is=1;
              }

            }

            $pasajero->codigo_telefono = $tel;
            //codigo tel

            $arrayIP = [];

            array_push($arrayIP, [
              'IP' => Methods::getRealIpAddr(),
              'USER_AGENT' => Methods::getBrowser(),
              'TIME' => date('Y-m-d H:i:s')
            ]);

            $pasajero->jsonIP = json_encode($arrayIP);

            if($pasajero->save()){

              $data = [      
                  'id'    => $pasajero->id,
                  'nombres' => $pasajero->nombres,
                  'apellidos'=> $pasajero->apellidos,
                  'codigo'=> $pasajero->codigo_confirmacion,

                ];

                Mail::send('emails.correo_confirmacion', $data, function($message) use ($email){

                  $message->from('no-reply@aotour.com.co', 'AOTOUR');
                  $message->to($email)->subject('Verificación de Email');
                  $message->cc('aotourdeveloper@gmail.com');

                });
  
              return Response::json([
                'mensaje'=>true,
              ]);
              
            }//fin si guardado

          }
          
        }//fin sino validador
      }

    }//SG

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

          /*$name = 'SAMUEL';
          $ape = 'GONZALEZ';
          $code = 1234;
          $cedula = '1043027866';
          return View::make('servicios.pasajeros.confirmado')
          ->with('nombres', $name)
          ->with('codigo', $ape)
          ->with('cedula', $cedula)
          ->with('apellidos', $code);*/
        }

      }else{     

        $user = Pregistro::where('codigo_confirmacion', $code)->first();
        $code_tel = $user->codigo_telefono;
        $Mensaje = "AOTOUR le informa que su codigo de confirmacion es ".$code_tel."";   
        $Destino = trim($user->telefono);
        $id = $user->id;
        
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
        ->with('id',$id)
        ->with('Destino', $Destino);        

      }               

    }

    public function postReenviarcodigo(){

      $id = Input::get('id');

      $user = Pregistro::where('id', $id)->first();
      $code_tel = $user->codigo_telefono;
      $Mensaje = "AOTOUR le informa que su codigo de confirmacion es ".$code_tel."";   
      $Destino = trim($user->telefono);
      $id = $user->id;
      
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

      return Response::json([
        'respuesta' => true,
        'id' => $id,
        'destino' => $Destino
      ]);

    }

    //
      public function postSaveuser(){
        
        //'aceptar_politicas'=>'accepted',
        if(null!=Input::get('aceptar_politicas')){
          return Response::json([
            'mensaje'=>true,
          ]);
        }else{
          return Response::json([
            'mensaje'=>false,
          ]);
        }      
      }
    //

    //
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
              'respuesta' => true
            ]);  

          }
       }
    }
  }

  
