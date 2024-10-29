<?php

class ListadoAController extends BaseController{
    
    public function getIndex(){
        
        if (Sentry::check()){
            $id_rol = Sentry::getUser()->id_rol;
            $centrodecosto_id = Sentry::getUser()->centrodecosto_id;
            $cliente = DB::table('centrosdecosto')->where('id',$centrodecosto_id)->pluck('razonsocial');
            $idusuario = Sentry::getUser()->id;
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

        $pasajeros = DB::table('pasajeros')->where('centrodecosto_id',$centrodecosto_id)->get();
        return View::make('portalusuarios.admin.listado.listado')
        ->with('idusuario',$idusuario)
        ->with('cliente',$cliente)
        ->with('permisos',$permisos)
        ->with('centrodecosto_id',$centrodecosto_id)
        ->with('pasajeros',$pasajeros);
        }
    }
    public function getDescargarcodigoqr($id){       
      
      $pasajero = $id;
      

      $pasajero = Pasajero::find($pasajero);
      $centro = DB::table('centrosdecosto')
      ->where('id',$pasajero->centrodecosto_id)
      ->pluck('razonsocial');

      $html = View::make('portalusuarios.qrcode3')->with([
        'dato' => $pasajero,
        'centro' => $centro,
      ]);

      return PDF::load(utf8_decode($html), 'Legal', 'portrait')->download('CODE'.$pasajero->cedula);
      
    }

    public function postVerpasajeros(){

        $centro = Input::get('centro');

        if($centro!=0){
          $pasajeros = DB::table('pasajeros')
          ->leftjoin('centrosdecosto', 'centrosdecosto.id', '=', 'pasajeros.centrodecosto_id')
          ->leftjoin('users', 'users.identificacion', '=', 'pasajeros.cedula')
          ->where('pasajeros.centrodecosto_id',$centro)
          ->where('users.id_rol',35)
          ->get();
        }else if($centro==0){
          $pasajeros = DB::table('pasajeros')->orderBy('id')->get();
        }

        return Response::json([
            'respuesta' => true,
            'pasajeros' => $pasajeros
        ]);

    }

    public function postMostrarqr(){
        $pasajeros = Pasajero::find(Input::get('pasajero_id'));
        $qr_code = DNS2D::getBarcodePNG($pasajeros->cedula, "QRCODE", 10, 10,array(1,1,1), true);

        return Response::json([
          'response' => true,
          'qr_code' => $qr_code
        ]);
      }

      public function postEliminarpas(){
        $pasajero = Pasajero::find(Input::get('pasajero_id'));
        if ($pasajero->delete()) {
          return Response::json([
            'response' => true
          ]);
          } 
      }

      public function getListadonumero2(){
        
        if (Sentry::check()){
            $id_rol = Sentry::getUser()->id_rol;
            $centrodecosto_id = Sentry::getUser()->centrodecosto_id;
            $cliente = DB::table('centrosdecosto')->where('id',$centrodecosto_id)->pluck('razonsocial');
            $idusuario = Sentry::getUser()->id;
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

        $pasajeros = DB::table('pre_registro')
        ->whereNull('estado')
        ->get();
        return View::make('portalusuarios.admin.listado.Listado2')
        ->with('idusuario',$idusuario)
        ->with('cliente',$cliente)
        ->with('permisos',$permisos)
        ->with('centrodecosto_id',$centrodecosto_id)
        ->with('pasajeros',$pasajeros);
        }
    }

    public function postEnviarmsj(){

        //$id = Pasajero::find(Input::get('pasajero_id'));
        $numero = DB::table('pre_registro')->where('id',Input::get('pasajero_id'))->pluck('telefono');
        $user = DB::table('pre_registro')->where('id',Input::get('pasajero_id'))->pluck('telefono');
        $cantidad = DB::table('pre_registro')->where('id',Input::get('pasajero_id'))->pluck('cantidad');
        $userenviado = DB::table('pre_registro')
          ->where('id', Input::get('pasajero_id'))
          ->update([
            'cantidad' => 1+$cantidad
          ]);

        $claveapi = "74d0efd53680";
        $Destino = $numero; 
        $Mensaje = "AOTOUR lo invita a completar el registro";
        $usuario = 17; //CODIGO DE USUARIO
        // Escoja el tipo a enviar dato
        $Tipo = "SMS";
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, 'https://conectbox.com/index.php/APIsms/api/EnviarSms'); 
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'claveapi='.$claveapi.'&d='.$Destino.'&m='.$Mensaje.'&t='.$Tipo.'&usuario='.$usuario);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        $output = curl_exec($ch); 
        echo $output;
        curl_close($ch);
        //$qr_code = DNS2D::getBarcodePNG($pasajeros->cedula, "QRCODE", 10, 10,array(1,1,1), true);

        return Response::json([
          'response' => true,
        ]);
      }
}
//controlador del portal de usuarios!!!
