<?php
/**
 * Clase para gestión de aplicación móvil (VERSIÓN IONIC)
 */
class Apiv4Controller extends BaseController{

    public function postListarccccc() {

      $consulta = DB::table('correos')
      ->get();

      if($consulta!=null){

        return Response::json([
          'respuesta' => true,
          'correos' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }
      
    }

    public function postForward() {

      $id = Input::get('id'); 

      $consulta = DB::table('correos')
      ->where('id',$id)
      ->pluck('reenvio');

      $consulta = DB::table('correos')
      ->where('id', '!=',$id)
      ->get();

      ////$explode = explode(',',$consulta);
      ////$text = '';

      /*for($i=0; $i< count($explode); $i++){
        if($i==0){
          $text .=  "reenvio <> ".$explode[$i]." ";
        }else{
          $text .=  "and reenvio <> ".$explode[$i]." ";
        }        
      }*/

      ////$consult = "SELECT * FROM correos WHERE ".$text."";
      ////$consult2 = DB::select($consult);

        //$consult = "SELECT * FROM correos WHERE NOT FIND_IN_SET('259', reenvio)";
        //$consult = DB::select($consult);

      if($consulta!=null){

        return Response::json([
          'respuesta' => true,
          'correos' => $consulta,
          //'consult' => $consult,
          //'consult2' => $consult2
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'consulta'=> $consulta,
          'consult' => $consult,
          'consult2' => $consult2
        ]);

      }
      
    }

    public function postReenvio() {

      $id = Input::get('id');
      $reenvio = Input::get('reenvio');

      

      $consulta = DB::table('correos')
        ->where('id',$id)
        ->pluck('reenvio');

        if ($consulta===null) { 

        $consulta = DB::table('correos')

        ->where('id',$id)
        ->update([
          'reenvio' => $reenvio
        ]);

        return Response::json([ 
          'respuesta' => false,     
         ]);

          }else{ 


           $nuevoDato = $consulta.','.$reenvio;

           $update = DB::table('correos')
            ->where('id',$id)
            ->update([
              'reenvio' => $nuevoDato

                ]);
              return Response::json([ 
                'respuesta' => true,
              ]);    
         }
      }

    public function postPlan() {

      $id = Input::get('id');
      $tipo = Input::get('tipo');

      $query = DB::table('lineas')
      ->where('id',$id)
      ->update([
       'tipo_plan' => $tipo
      ]);

      if($query){

        return Response::json([ 
          'respuesta' => true
         ]);

      }else{

        return Response::json([ 
          'respuesta' => false
         ]);
      }

    }
    
    public function postMostrar() {

      $id = Input::get('id');

      $correo = DB::table('correos')   
      ->where('id',$id)
      ->first(); 

      $consulta = DB::table('empleados')
      ->whereIn('id',[$correo->usuario])
      ->get();

      if($consulta!=null){

        return Response::json([
          'respuesta' => true,
          'usuarios' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'id' => $correo,
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

            $consulta = "select * from equipos where categoria = '".$categoria."'";

            $consulta = DB::select($consulta);

            $contadora = count($consulta);

            if($consulta!=null and $contadora > 1){
                $number = count($consulta);
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

            $data = $v1; //Valor de código QR

            $equipo->code = $v1;

            $id_image = Input::get('image');
            $img = base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$id_image));
            //END PREV

            $qr_code = DNS2D::getBarcodePNG($data, "QRCODE", 10, 10,array(1,1,1), true); //Creación de QR
            Image::make($qr_code)->save('biblioteca_imagenes/codigosqr/'.$data.'.png'); //Creación del QR P2

            $filepath = "biblioteca_imagenes/codigosqr/".$equipo->id.'.PNG';
            file_put_contents($filepath,$img);

            $update = DB::table('equipos')
            ->where('id',$equipo->id)
            ->update([
                'img' => $equipo->id.'.PNG',
                'code' =>$v1,
                'qr' => $data.'.png'
            ]);

            return Response::json([
                'respuesta' => true,
                'categoria' => $categoria,

            ]);

        }
        
    }

    public function postServiciossolicitados(){ //EJEMPLO

      $user_id = Input::get('id');

      $user = User::find($user_id);

      if ($user->empresarial===1) {

        $servicios = Servicioaplicacion::where('user_id', $user_id)
        ->whereRaw('cancelado is null and programado is null')
        ->orderBy('fecha', 'asc')
        ->orderBy('hora', 'asc')
        ->get();

      }else {

        $servicios = Servicioaplicacion::where('user_id', $user_id)
        ->whereRaw('pago_servicio_id is not null and pago_facturacion is null and cancelado is null')
        ->orderBy('fecha', 'asc')
        ->orderBy('hora', 'asc')
        ->get();

      }

      if (count($servicios)) {

        return Response::json([
          'respuesta' => true,
          'servicios' => $servicios,
          'user_id' => $user_id
        ]);

      }else {

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postEmpleados(){

      $id = Input::get('usuario_id');

      $variable = input::get('hola');

      $consulta = DB::table('empleados')
      ->where('estado',1)
      ->get();

      if($consulta!=null){

        return Response::json([
          'respuesta' => true,
          'empleados' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }
    }
    public function postListados(){

      $id_usuario = Input::get('id');

      $consult = "SELECT * FROM equipos WHERE FIND_IN_SET('".$id_usuario."', empleado) > 0 ";

      $consulta = DB::select($consult);

     if($consulta!=null){

        return Response::json([
          'respuesta' => true,
          'equipos' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false
          
        ]);

      }
    }
  

    public function postEjemplo(){

      $id = Input::get('id');

      //$query = DB::table('equipos')
      //->where('empleado',$id)
      //->get();

      $query = "SELECT * FROM equipos WHERE FIND_IN_SET('".$id."', empleado) > 0 ";

      $querys = DB::select($query);

      $consult = "SELECT * FROM correos WHERE FIND_IN_SET('".$id."', usuario) > 0 ";

      $consulta = DB::select($consult);

      $consult1 = "SELECT * FROM lineas WHERE FIND_IN_SET('".$id."', usuario) > 0 ";

      $consulta2 = DB::select($consult1);

      if($querys!=null or $consulta or $consulta2){

        return Response::json([
          'respuesta' => true,
          'equipo' => $querys,
          'correos' => $consulta,
          'lineas' => $consulta2
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postUsuarios(){

      $consulta = DB::table('empleados')
      ->where('estado',1)
      ->get();

      if($consulta!=null){

        return Response::json([
          'respuesta' => true,
          'empleados' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false, 
        ]);

      }
    }

    public function postUsuarios2(){

      $consulta = DB::table('empleados')
      ->where('estado',1)
      ->get();

      if($consulta!=null){

        return Response::json([
          'respuesta' => true,
          'empleados' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false, 
        ]);

      }
    }

    public function postNombre() {

      //$code = Input::get('code');
      $code = 'CEL001';

      //consultas
      //condicionales
      //ci

      return Response::json([
        'respuesta' => false,
        'code' => $code
      ]);

    }

    public function postBuscarequipo(){

      $code = Input::get('code');
      //$code = 'PC001';

      $query = DB::table('equipos')
      ->where('code',$code)
      ->first();

      if($query!=null){

        $consulta = DB::table('empleados')
        ->where('estado',1)
        ->get();

        if($consulta!=null){

          return Response::json([
            'respuesta' => true,
            'usuarios' => $consulta,
            'equipo' => $query->id
          ]);

        }else{

          return Response::json([
            'respuesta' => false, 
          ]);

        }

      }else{

        return Response::json([
          'respuesta' => 'indefinido',
          'code' => $code
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

    public function postEntregarequipo(){

      $id = Input::get('id');
      $equipo = 1;// Input::get('equipo');

      $consult = "SELECT * FROM equipos WHERE id = ".$equipo." AND FIND_IN_SET('".$id."', empleado) > 0 "; 

      $consulta = DB::select($consult);

      if($consulta){

        return Response::json([
          'respuesta' => false, 
        ]);

      }else{

        $acta = new Acta;
        $acta->empleado = $id;
        $acta->equipo = $equipo;
        $acta->tipo = 1;

        if($acta->save()){

          //start consulta del dato actual
          $consultaEquipo = DB::table('equipos')
          ->where('id',$equipo)
          ->first();

          $tot = explode(",", $consultaEquipo->empleado);

          if(count($tot) >= 1){

            //asignación a una variable la concatenación del dato actualizado para guardar
            $nuevoDato = $consultaEquipo->empleado.','.$id;

            $update = DB::table('equipos')
            ->where('id',$equipo)
            ->update([
              'empleado' => $nuevoDato
            ]);

          }else{

            $update = DB::table('equipos')
            ->where('id',$equipo)
            ->update([
              'empleado' => $id
            ]);

          }

          //ENTREGA
          //Creación de imagenes de firma
          $baseFromJavascripte = Input::get('image');

          // Remover la parte de la cadena de texto que no necesitamos (data:image/png;base64,)
          // y usar base64_decode para obtener la información binaria de la imagen
          $datas = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseFromJavascripte));

          //Ubicacion para el archivo
          $filepathe = "biblioteca_imagenes/firma_actas/".'entrega'.$acta->id.'.png';

          //Guardar imagen
          file_put_contents($filepathe,$datas);

          $imge = Image::make($filepathe);

          //RECIBE
          //Creación de imagenes de firma
          $baseFromJavascript = Input::get('imagen');

          // Remover la parte de la cadena de texto que no necesitamos (data:image/png;base64,)
          // y usar base64_decode para obtener la información binaria de la imagen
          $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseFromJavascript));

          //Ubicacion para el archivo
          $filepath = "biblioteca_imagenes/firma_actas/".'recibe'.$acta->id.'.png';

          //Guardar imagen
          file_put_contents($filepath,$data);

          $img = Image::make($filepath);

          $id = Empleado::find($id);

          $updateActa = DB::table('actas')
          ->where('id',$acta->id)
          ->update([
            'firma_entrega' => 'entrega'.$acta->id.'.png',
            'firma_recibe' => 'recibe'.$acta->id.'.png'
          ]);

          return Response::json([
            'respuesta' => true,
            'id' => $id,
            'nombres' => $id->nombres,
            'apellidos' => $id->apellidos
          ]);

        }else{

          return Response::json([
            'respuesta' => 'no_creado', 
          ]);

        }

      }

    }

    public function postRecibirequipo(){

      $id = Input::get('id');
      $equipo = Input::get('equipo');

      $consulta = DB::table('actas')
      ->where('empleado',$id)
      ->where('tipo',1)
      ->where('equipo',$equipo) 
      ->whereNull('entregado')
      ->first();


      if($consulta!=null){

        $acta = new Acta;
        $acta->empleado = $id;
        $acta->equipo = $equipo;
        $acta->tipo = 2;

        if($acta->save()){

          //start consulta del dato actual
          $consultaEquipo = DB::table('equipos')
          ->where('id',$equipo)
          ->first();

          if(count($consultaEquipo) > 1){

            //asignación a una variable la concatenación del dato actualizado para guardar
            $nuevoDato = $consultaEquipo->empleado.','.$id;

            $update = DB::table('equipos')
            ->where('id',$equipo)
            ->update([
              'empleado' => $nuevoDato
            ]);

          }else{

            $update = DB::table('equipos')
            ->where('id',$equipo)
            ->update([
              'empleado' => $id
            ]);

          }

          //ENTREGA
          //Creación de imagenes de firma
          $baseFromJavascripte = Input::get('image');

          // Remover la parte de la cadena de texto que no necesitamos (data:image/png;base64,)
          // y usar base64_decode para obtener la información binaria de la imagen
          $datas = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseFromJavascripte));

          //Ubicacion para el archivo
          $filepathe = "biblioteca_imagenes/firma_actas/".'entrega'.$acta->id.'.png';

          //Guardar imagen
          file_put_contents($filepathe,$datas);

          $imge = Image::make($filepathe);

          //RECIBE
          //Creación de imagenes de firma
          $baseFromJavascript = Input::get('imagen');

          // Remover la parte de la cadena de texto que no necesitamos (data:image/png;base64,)
          // y usar base64_decode para obtener la información binaria de la imagen
          $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseFromJavascript));

          //Ubicacion para el archivo
          $filepath = "biblioteca_imagenes/firma_actas/".'recibe'.$acta->id.'.png';

          //Guardar imagen
          file_put_contents($filepath,$data);

          $img = Image::make($filepath);

          $id = Empleado::find($id);

          $updateActa = DB::table('actas')
          ->where('id',$acta->id)
          ->update([
            'firma_entrega' => 'entrega'.$acta->id.'.png',
            'firma_recibe' => 'recibe'.$acta->id.'.png'
          ]);

          $consulta = DB::table('actas')
          ->where('id',$consulta->id)
          ->update([
            'entregado' => 1
            ]);

          return Response::json([
            'respuesta' => true,
            'nombres' => $id->nombres,
            'apellidos' => $id->apellidos
          ]);

        }else{

          return Response::json([
            'respuesta' => false, 
          ]);

        }
        
      }else{

        return Response::json([
          'respuesta' => false, 
        ]);
      }  
    }

    public function postListaractas(){

      $consulta = DB::table('actas')
      ->leftJoin('empleados', 'empleados.id', '=', 'actas.empleado')
      ->select('actas.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('tipo',1)
      ->get();

      if($consulta!=null){

    
        return Response::json([
          'respuesta' => true,
          'actas' => $consulta,

        ]);

      }else{

        return Response::json([
          'respuesta' => false, 
        ]);

      }

    }

    public function postListaractasr(){

      $id = Input::get('id');

      $consulta = DB::table('actas')
      ->leftJoin('empleados', 'empleados.id', '=', 'actas.empleado')
      ->select('actas.*', 'empleados.nombres', 'empleados.apellidos')
      ->where('tipo',2) 
      ->get();

      if($consulta!=null){

        return Response::json([
          'respuesta' => true,
          'actas' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
        ]);

      }

    }

    public function postVeractas(){

      $id = Input::get('id');

      $consulta = DB::table('actas')
      ->leftJoin('equipos', 'equipos.id', '=', 'actas.equipo')
      ->select('actas.*', 'equipos.categoria', 'equipos.marca' , 'equipos.procesador',
      'equipos.ram', 'equipos.espacio', 'equipos.mac', 'equipos.nombre_red')
      ->where('actas.id',$id)
      ->get();

      if($consulta!=null){

        return Response::json([
          'respuesta' => true,
          'actas' => $consulta,

        ]);

      }else{

        return Response::json([
          'respuesta' => false, 
        ]);

      }
    }
    public function postListaactasrr(){

      $id = Input::get('id');

      $consulta = DB::table('actas')
      ->leftJoin('equipos', 'equipos.id', '=', 'actas.equipo')
      ->select('actas.*', 'equipos.categoria', 'equipos.marca' , 'equipos.procesador',
      'equipos.ram', 'equipos.espacio', 'equipos.mac', 'equipos.nombre_red')
      ->where('actas.id',$id)
      ->get();

      if($consulta!=null){

        return Response::json([
          'respuesta' => true,
          'actas' => $consulta,

        ]);

      }else{

        return Response::json([
          'respuesta' => false, 
        ]);

      }
    }

  /*public function postAllactas(){


  }*/

  /*public function postDescargaractasrecibida(){
   

    
  }*/

  public function postRecibireqp(){

    $code = Input::get('code');

    $consulta = DB::table('equipos')
    ->where('code',$code)
    ->first();

    if($consulta){

      $users = explode(',', $consulta->empleado);
      $total = count($users);  

      if($total>1){

        $users = DB::table('empleados')
        ->whereIn('id',[$consulta->empleado])
        ->get();

        return Response::json([
          'respuesta' => true,
          'users' => $users
        ]);

      }else{

        $users = DB::table('empleados')
        ->whereIn('id',[$consulta->empleado])
        ->get();

        return Response::json([
          'respuesta' => true,
          'users' => $users
        ]);

      }

    }else{

      return Response::json([
        'respuesta' => 'invalido'
      ]);

    }

  }

  public function postDesenlazarqp(){

    $code = 'PC001';

      $query = DB::table('equipos')
      ->where('code',$code)
      ->first();

      if($query!=null){

        $consulta = DB::table('empleados')
        ->where('estado',1)
        ->get();

        if($consulta!=null){

          return Response::json([
            'respuesta' => true,
            'usuarios' => $consulta,
            'equipo' => $query->id
          ]);

        }else{

          return Response::json([
            'respuesta' => false, 
          ]);

        }

      }
    }
    
    public function postGuardarnumber(){

     $lineas = Input::get('lineas');

     $consulta = DB::table('lineas')
     ->where('lineas',$lineas )
      ->first();

      if($consulta!=null){

        return Response::json([
        'respuesta' => false,
         'linea' => $lineas
      ]);

      }else{

        $linea = new Lineas();

       $linea->lineas = $lineas;

       $linea->save(); 

        return Response::json([
          'respuesta' => true,
           'linea' => $lineas
      ]);

      }
      

    }

    public function postListarnumber() {

      $consulta = DB::table('lineas')
      ->get();

      if($consulta!=null){

        return Response::json([
          'respuesta' => true,
          'lineas' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }
      
    }
    public function postMostrarnumber(){ 

      $id = Input::get('id');

      $consulta = DB::table('lineas')
      ->where('id',$id)
      ->first();

      if($consulta!=null){

        return Response::json([
          'respuesta' => true,       
          'id' => $id,
          'lineas' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'id' => $id,
          'lineas' => $consulta
        ]);

      }

    }
    public function postEliminarnumber(){

      $id = Input::get('id');

      $query = 'DELETE FROM `lineas` WHERE id = '.$id. '';
                                        
      $consulta = DB::select($query);

      return Response::json([
        'respuesta' => true,
         'id' => $id

      ]);

    }
    
    public function postGuardarcorreo(){

     $mail = Input::get('correo');


     $consulta = DB::table('correos')
     ->where('address',$mail )
      ->first();

      if($consulta!=null){

        return Response::json([
        'respuesta' => false,
         'correo' => $mail
      ]);

      }else{

        //$text = 'El usuario fue REINTEGRADO el '.$fecha.'.';
        $info = 'El correo fue creado el '.date('Y-m-d');

        $array = [
          'detalle' => $info, 
          'time' => date('Y-m-d')
        ];

        $history = json_encode([$array]);


        $correo = new Correos();
        
        $correo->address = strtoupper($mail);
        $correo->historial = $history;

        $correo->save(); 

        return Response::json([
          'respuesta' => true,
           'correo' => $correo
        ]);

      }
 

    }

    public function postEditarcorreo(){

     $id = Input::get('id');

      $correo = DB::table('correos')
      ->where('id',$id)
      ->first();

      if($correo!=null){

        return Response::json([
          'respuesta' => true,
          
          'id' => $id,
          'correo' => $correo
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'id' => $id,
          'correo' => $correo
        ]);

      }

    }
    public function postNewcorreo(){//funcion para editar correos!!!

        return Response::json([
          'respuesta' => true,
  
         ]);
    }

    public function postEditarnumber(){

      $id = Input::get('id');
      

      $query = DB::table('lineas')
        ->where('id',$id)
        ->pluck('lineas');

      $consulta = DB::table('lineas')
      ->where('id',$id)
      ->update([
          'lineas' =>$query
        ]);

      if($query){

        return Response::json([
        'respuesta' => false,  

        ]);

      }else{

        return Response::json([
        'respuesta' => true,  
            
        ]);
    
      }

    }

    public function postEliminar(){

      $id = Input::get('id');

      $query = 'DELETE FROM `correos` WHERE id = '.$id. '';
                                        
      $consulta = DB::select($query);

      return Response::json([
        'respuesta' => true,
         'id' => $id
      ]);

    }

    public function postDetalles(){
      
      $id = Input::get('id');

       $consulta = DB::table('equipos')
      ->where('id',$id)
      ->get();

      return Response::json([
        'respuesta' => true,
        'equipos' => $consulta
      ]);

    } 

    public function postDetallesnumber(){
      
      $id = Input::get('id');

      $id = DB::table('lineas')
      ->where('id',$id)
      ->first();

      $ejemplo = explode(',', $id->usuario);

      $consulta = DB::table('empleados')
      ->whereIn('id',$ejemplo)
      ->get();

      if($consulta!=null){

        return Response::json([
          'respuesta' => true,       
          'id' => $id,
          'empleados' => $consulta,
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'id' => $id,
          'empleados' => $consulta
        ]);

      }

    }

    public function postDetallescorreos(){
      
      $id = Input::get('id');

      $id = DB::table('correos')
      ->where('id',$id)
      ->first();

      $ejemplo = explode(',', $id->usuario);

      $consulta = DB::table('empleados')
      ->whereIn('id',$ejemplo)
      ->get();

      if($consulta!=null){

        return Response::json([
          'respuesta' => true,       
          'id' => $id,
          'empleados' => $consulta,
        ]);

      }else{

        return Response::json([
          'respuesta' => false,
          'id' => $id,
          'empleados' => $consulta
        ]);

      }
    }

    public function postHistorial(){

      $id = Input::get('id');

      $consulta = DB::table('control_ingreso')
      ->where('empleado', $id)
      ->where('fecha', date('Y-m-d'))
      ->first();
      

        return Response::json([
          'respuesta' => true,
          'control_ingreso' => $consulta
         
        ]);      
    }

    public function postGenerarqr(){


      $fecha = date('Y-m-d');
      $manana = strtotime ('+1 day', strtotime($fecha));
      $manana = $fecha;

      $select = DB::table('qr_ingreso')
      ->where('fecha',$manana)
      ->first();

      if($select!=null){ // código creado

        return Response::json([
          'respuesta' => 'creado'
        ]);

      }else{ //Crear código

        $code = "";
        $characters = array_merge(range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < 50; $i++) {
          $rand = mt_rand(0, $max);
          $code .= $characters[$rand];
        }

        $consulta = "select * from qr_ingreso order by id desc limit 1";
        $ultimo_id = DB::select($consulta);
        if($ultimo_id){
          $ultimo = $ultimo_id[0]->id;
        }else{
          $ultimo = 0;
        }

        //Código que genera el QR
        $id_image = Input::get('image');
        $img = base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$id_image));

        $valor1 = $code;
        $valor2 = $manana;
        $valor3 = $ultimo;

        $data = $valor1.$valor2.$valor3; //Valor de Código QR

        $qr_code = DNS2D::getBarcodePNG($data, "QRCODE", 10, 10,array(1,1,1), true); //Creación de QR
        $logo = Image::make(storage_path('img/logo_aotour.png'))->resize(42,60);
        $imag = Image::make($qr_code)->save('biblioteca_imagenes/control_ingreso/'.$data.'.png'); //Creación del QR P2
        $imag->insert($logo,'center')->encode('data-url')->encoded;

        $ingresoqr = new IngresoQR;
        $ingresoqr->codigo = $data;
        $ingresoqr->fecha = $manana;

        if($ingresoqr->save()){

          return Response::json([
            'respuesta' => true,   
          ]);

        }else{

          return Response::json([
            'respuesta' => false,   
          ]);

        }

      }

    }

    public function postAcceso(){

      $qr = Input::get('qr');
      $usuario = Input::get('usuario');
      

      //consulta: valida que el codigo qr que se lea sea el que está en la DB.
      //where: examnina que el registro esté en la DB. 

      $consulta = DB::table('qr_ingreso')   
      ->where('codigo',$qr)
      ->where('fecha',date('Y-m-d'))
      ->get(); //Consulta del código de hoy

      $date = date('Y-m-d');
      $date = strtotime ('-1 day', strtotime($date));
      $ayer = date('Y-m-d' , $date);

      $consult = DB::table('qr_ingreso')   
      ->where('codigo',$qr)
      ->where('fecha',$ayer)
      ->get(); //Consulta del código de ayer


      if($consulta!=null){

        $query = DB::table('empleados')
        ->where('id', $usuario)
        ->pluck('sede');

        $consultar = DB::table('control_ingreso') 
        ->leftJoin('empleados', 'empleados.id', '=', 'control_ingreso.empleado')
        ->select('control_ingreso.*', 'empleados.sede')
        ->where('fecha',date('Y-m-d'))
        ->where('empleados.sede', $query)
        ->first();

        if($consultar){ 

          $user = DB::table('control_ingreso')
          ->where('empleado',$usuario)
          ->where('fecha',date('Y-m-d'))
          ->first();

          if($user->estado==0){

            $query = DB::table('control_ingreso')
            ->where('empleado',$usuario)
            ->where('fecha',date('Y-m-d'))
            ->update([
              'hora_llegada'=> date('H:i'),
              'estado' => 1
            ]);

            return Response::json([
              'respuesta' => true,
              'sw'=> 1
            ]);

          }else if($user->estado==1){

            $query = DB::table('control_ingreso')
            ->where('empleado',$usuario)
            ->where('fecha',date('Y-m-d'))
            ->update([
              'hora_salida'=> date('H:i'),
              'estado' => 2
            ]);

            return Response::json([
              'respuesta' => true,
              'sw'=> 2
            ]);

          }else if($user->estado==2){

            $query = DB::table('control_ingreso')
            ->where('empleado',$usuario)
            ->where('fecha',date('Y-m-d'))
            ->update([
              'hora_llegadapm'=> date('H:i'),
              'estado' => 3
            ]);

            return Response::json([
              'respuesta' => true,
              'sw'=> 3
            ]);

          }else if($user->estado==3){

            $query = DB::table('control_ingreso')
            ->where('empleado',$usuario)
            ->where('fecha',date('Y-m-d'))
            ->update([
              'hora_salidapm'=> date('H:i'),
              'estado' => 4
            ]);

            return Response::json([
              'respuesta' => true,
              'sw'=> 4
            ]);

          }else if($user->estado==4){

              return Response::json([
                'respuesta' => 'completo',
             ]);

          }

        }else{

          $empleados = DB::table('empleados')
          ->where('estado',1)
          ->where('sede',$query)
          ->get();

          if($empleados){
             foreach ($empleados as $empleado) {
              $nuevo = new Ingreso;
              $nuevo->empleado = $empleado->id;
              $nuevo->fecha = date('Y-m-d');
              $nuevo->estado = 0;
              $nuevo->save();
            }

          } //hasta aqui se crea la plantilla

          $query = DB::table('control_ingreso')
          ->where('empleado',$usuario)
          ->where('fecha',date('Y-m-d'))
          ->update([
            'hora_llegada'=>date('H:i'),
            'estado' => 1
          ]);


          return Response::json([
            'respuesta' => true,
            'sw' => 1,

          ]);

        }

      }else if($consult!=null){ // Qr de otra fecha

        $user = DB::table('control_ingreso')
        ->where('empleado',$usuario)
        ->where('fecha',$ayer)
        ->first();

        if($user->estado==0){

          $query = DB::table('control_ingreso')
          ->where('empleado',$usuario)
          ->where('fecha',$ayer)
          ->update([
            'hora_llegada'=> date('H:i'),
            'estado' => 1
          ]);

          return Response::json([
            'respuesta' => true,
            'sw'=> 1
          ]);

        }else if($user->estado==1){

          $query = DB::table('control_ingreso')
          ->where('empleado',$usuario)
          ->where('fecha',$ayer)
          ->update([
            'hora_salida'=> date('H:i'),
            'estado' => 2
          ]);

          return Response::json([
            'respuesta' => true,
            'sw2'=> 2
          ]);

        }else if($user->estado==2){

          $query = DB::table('control_ingreso')
          ->where('empleado',$usuario)
          ->where('fecha',$ayer)
          ->update([
            'hora_llegadapm'=> date('H:i'),
            'estado' => 3
          ]);

          return Response::json([
            'respuesta' => true,
            'sw'=> 3
          ]);

        }else if($user->estado==3){

          $query = DB::table('control_ingreso')
          ->where('empleado',$usuario)
          ->where('fecha',$ayer)
          ->update([
            'hora_salidapm'=> date('H:i'),
            'estado' => 4
          ]);

          return Response::json([
            'respuesta' => true,
            'sw'=> 4
          ]);

        }else if($user->estado==4){

            return Response::json([
              'respuesta' => 'completo',
           ]);

        }

      }else if($qr===''){

        return Response::json([
        'respuesta' => 'vacio',
        ]);
      }else{

        return Response::json([
        'respuesta' => false,
        ]);

      }
    }
     public function postListadresss(){

       $id = Input::get('id');
      $usuario = Input::get('usuario');
      

        return Response::json([
          'respuesta' => true,

          
        ]);

    }
     public function postVer(){


      $id = Input::get('id');

      $usuario = Input::get('usuario');

      $consulta = DB::table('empleados')
        ->where('estado',1)
        ->get();

        if($consulta!=null){

          return Response::json([
            'respuesta' => true,
            'usuario' => $consulta,
            
          ]);   
      }

    }

    public function postMirar(){


      $id = Input::get('id');

      $usuario = Input::get('usuario');

      $consulta = DB::table('empleados')
        ->where('estado',1)
        ->get();

        if($consulta!=null){

          return Response::json([
            'respuesta' => true,
            'usuario' => $consulta,
            
          ]);   
      }

    }

    public function postEntregaradress(){ //PENDIENTE VALIDACIÓN SI YA EL CORREO FUE ASIGNADO O PRIMERA VEZ QUE SE ASIGNA
 
      $id = Input::get('id');
      $usuario = Input::get('usuario');

      $correo = DB::table('correos')
      ->where('id',$id)
      ->first();

      $consult = "SELECT * FROM correos WHERE id = ".$id." AND FIND_IN_SET('".$usuario."', usuario) > 0 "; 

      $consulta = DB::select($consult);

      if($consulta){

        return Response::json([
          'respuesta' => false,
          'consult' => $consult,
          'consulta' => $consulta,
          'datoActual' => $correo
        ]);

      }else{ 

        $total = explode(',', $correo->usuario);

        if( $correo->usuario != null ) {

          $consulta = Correos::find($id);

          if($consulta->historial==null){

             $us = Empleado::find($usuario);

             $nombres = $us->nombres;
             $apellidos = $us->apellidos;
        
            //$text = 'El usuario fue REINTEGRADO el '.$fecha.'.';
            $info = 'El correo fue asigado al empleado '.$us->nombres. ' ' .$us->apellidos. ' el dia '.date('Y-m-d'); 

            $array = [
              'detalle' => $info, 
              'time' => date('Y-m-d')
            ];

            //$consulta->historial = json_encode([$array]);
            $history = json_encode([$array]);


         }else{

          $us = Empleado::find($usuario);

            $info = 'El correo fue asignado al empleado '.$us->nombres. ' ' .$us->apellidos. ' el dia '.date('Y-m-d');
            $array = [
              'detalle' => $info,
              'time' => date('Y-m-d')
            ];

            $objArray = json_decode($consulta->historial);
            array_push($objArray, $array);
            //$info->historial = json_encode($objArray);
            $history = json_encode($objArray);
          }

          $nuevoDato = $correo->usuario.','.$usuario;

          $update = DB::table('correos')
          ->where('id',$id)
          ->update([
            'usuario' => $nuevoDato,
            'historial' => $history
          ]);


        }else{

          $consulta = Correos::find($id);

          if($consulta->historial==null){

             $us = Empleado::find($usuario);

             $nombres = $us->nombres;
             $apellidos = $us->apellidos;
        
            //$text = 'El usuario fue REINTEGRADO el '.$fecha.'.';
            $info = 'El correo fue asigado al empleado '.$us->nombres. ' ' .$us->apellidos. ' el dia '.date('Y-m-d'); 

            $array = [
              'detalle' => $info, 
              'time' => date('Y-m-d')
            ];

            //$consulta->historial = json_encode([$array]);
            $history = json_encode([$array]);


         }else{

          $us = Empleado::find($usuario);

            $info = 'El correo fue asigado al empleado '.$us->nombres. ' ' .$us->apellidos. ' el dia '.date('Y-m-d');
            $array = [
              'detalle' => $info,
              'time' => date('Y-m-d')
            ];

            $objArray = json_decode($consulta->historial);
            array_push($objArray, $array);
            //$info->historial = json_encode($objArray);
            $history = json_encode($objArray);
          }


          $update = DB::table('correos')
          ->where('id',$id)
          ->update([
            'usuario' => $usuario,
            'historial' => $history
          ]);

        }

        $user = Empleado::find($usuario); //Consulta para motrar nombre y apellido en el toast de la app

        return Response::json([
          'respuesta' => true,
          'nombre' => $user->nombres,
          'apellido' => $user->apellidos,
        ]);

      }

    }

    public function postEntregarnum(){ //PENDIENTE VALIDACIÓN SI YA EL CORREO FUE ASIGNADO O PRIMERA VEZ QUE SE ASIGNA
 
      $id = Input::get('id');
      $usuario = Input::get('usuario');

      //start consulta del dato actual
      $linea = DB::table('lineas')
      ->where('id',$id)
      ->first();

      //end consulta del dato actual
       
      //OJO: VALIDAR QUE NO SE AGREGUE DOS VECES A LA MISMA PERSONA. En caso de que se agregue, mostrar el mensaje correspondiente

      $consult = "SELECT * FROM lineas WHERE id = ".$id." AND FIND_IN_SET('".$usuario."', usuario) > 0 ";

      $consulta = DB::select($consult);

      if($consulta){

        return Response::json([
          'respuesta' => false,
          'consult' => $consult,
          'consulta' => $consulta,
          'datoActual' => $linea
        ]);

      }else{

        $total = explode(',', $linea->usuario);

        if( $linea->usuario != null ) {

          $consulta = Lineas::find($id);

          if($consulta->historial==null){

             $us = Empleado::find($usuario);

             $nombres = $us->nombres;
             $apellidos = $us->apellidos;
        
            
            $info = 'Línea asigada al empleado '.$us->nombres. ' ' .$us->apellidos. ' el dia '.date('Y-m-d'); 

            $array = [
              'detalle' => $info, 
              'time' => date('Y-m-d')
            ];

            $history = json_encode([$array]);


         }else{

          $us = Empleado::find($usuario);

            $info = 'Línea desasignada al empleado '.$us->nombres. ' ' .$us->apellidos. ' el dia '.date('Y-m-d');
            $array = [
              'detalle' => $info,
              'time' => date('Y-m-d')
            ];

            $objArray = json_decode($consulta->historial);
            array_push($objArray, $array);
            $history = json_encode($objArray);
          }

          //asignación a una variable la concatenación del dato actualizado para guardar
          $nuevoDato = $linea->usuario.','.$usuario;

          $update = DB::table('lineas')
          ->where('id',$id)
          ->update([
            'usuario' => $nuevoDato,
            'historial' => $history
          ]);

        }else{

          $consulta = Lineas::find($id);

          if($consulta->historial==null){

             $us = Empleado::find($usuario);

             $nombres = $us->nombres;
             $apellidos = $us->apellidos;
        
            
            $info = 'Línea asigada al empleado '.$us->nombres. ' ' .$us->apellidos. ' el dia '.date('Y-m-d'); 

            $array = [
              'detalle' => $info, 
              'time' => date('Y-m-d')
            ];

            //$consulta->historial = json_encode([$array]);
            $history = json_encode([$array]);


         }else{

          $us = Empleado::find($usuario);

            $info = 'Línea desasignada al empleado '.$us->nombres. ' ' .$us->apellidos. ' el dia '.date('Y-m-d');
            $array = [
              'detalle' => $info,
              'time' => date('Y-m-d')
            ];

            $objArray = json_decode($consulta->historial);
            array_push($objArray, $array);
            $history = json_encode($objArray);
          }

          $update = DB::table('lineas')
          ->where('id',$id)
          ->update([
            'usuario' => $usuario,
            'historial' => $history
          ]);

        }

        $user = Empleado::find($usuario);

        return Response::json([
          'respuesta' => true,
          'nombre' => $user->nombres,
          'apellido' => $user->apellidos,
        ]);

      }

    }

    public function postVer2(){ //PENDIENTE VALIDACIÓN SI YA EL CORREO FUE ASIGNADO O PRIMERA VEZ QUE SE ASIGNA
 
      $id = Input::get('id');
      $usuario = Input::get('usuario');

      //start consulta del dato actual
      $datoActual = DB::table('correos')
      ->where('id',$id)
      ->pluck('usuario');

      $ejemplo = explode(',', $datoActual);

      $empleados = DB::table('empleados')
      ->whereIn('id',$ejemplo)
      ->get();

      if($empleados){

        return Response::json([
          'respuesta' => true,
          'usuario' => $empleados
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postQuitarnum(){ 
 
      $id = Input::get('id');
      $usuario = Input::get('usuario');

      //start consulta del dato actual
      $datoActual = DB::table('lineas')
      ->where('id',$id)
      ->pluck('usuario');

      $ejemplo = explode(',', $datoActual);

      $empleados = DB::table('empleados')
      ->whereIn('id',$ejemplo)
      ->get();

      if($empleados){

        return Response::json([
          'respuesta' => true,
          'usuario' => $empleados
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postQuitaradress(){
 
      $id = Input::get('id');
      $usuario = Input::get('usuario');

      //start consulta del dato actual
      $correos = DB::table('correos')
      ->where('id',$id)
      ->pluck('usuario');

      $users = explode(',', $correos);

      $actualizacion = '';
      $sw = 0;

      for ($i=0; $i < count($users); $i++) {
        $sw++;

        if($users[$i] == $usuario){

        }else{

          if($i == (count($users)-1)){
            $coma = '';
          }else{
            $coma = ',';
          }

          if(count($users) == 2){
            $actualizacion = $users[$i];
          }else{
            $actualizacion .= $users[$i].$coma;
          }
        }        
      }

      if($actualizacion == ''){
        $actualizacion = null; 
      }else if(count($users) == 2){
        str_replace(',', '', $actualizacion);
      }

      $consulta = Correos::find($id);

      if($consulta->historial==null){

        $us = Empleado::find($usuario);

        $nombres = $us->nombres;
        $apellidos = $us->apellidos;

        $info = 'El correo fue desasigado del empleado '.$us->nombres. ' ' .$us->apellidos. ' el dia '.date('Y-m-d'); 

        $array = [
          'detalle' => $info, 
          'time' => date('Y-m-d')
        ];
        
        $history = json_encode([$array]);

      }else{

        $us = Empleado::find($usuario);

        $info = 'El correo fue desasignado del empleado '.$us->nombres. ' ' .$us->apellidos. ' el dia '.date('Y-m-d');
        $array = [
          'detalle' => $info,
          'time' => date('Y-m-d')
        ];

        $objArray = json_decode($consulta->historial);
        array_push($objArray, $array);
        $history = json_encode($objArray);

      }

      $update = DB::table('correos')
      ->where('id',$id)
      ->update([
        'usuario' => $actualizacion,
        'historial' => $history
      ]);

      if($update){ //aqui se desvincula el correo, añadir el campo historial con su mensaje correspondiente.

        //$usuario = Empleado::find($usuario);

        return Response::json([
          'respuesta' => true,
          'sw' => $sw,
          'actualizacion' => $actualizacion,
          'usuario' => $us,
          'nombre' => $us->nombres,
          'apellido' => $us->apellidos,
          'count' => count($users)
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postQuitarnmrs(){
 
      $id = Input::get('id');
      $usuario = Input::get('usuario');

      //start consulta del dato actual
      $lineas = DB::table('lineas')
      ->where('id',$id)
      ->pluck('usuario');

      $users = explode(',', $lineas);

      $actualizacion = '';
      $sw = 0;

      for ($i=0; $i < count($users); $i++) {
        $sw++;

        if($users[$i] == $usuario){

        }else{

          if($i == (count($users)-1)){
            $coma = '';
          }else{
            $coma = ',';
          }

          if(count($users) == 2){
            $actualizacion = $users[$i];
          }else{
            $actualizacion .= $users[$i].$coma;
          }
        }        
      }

      if($actualizacion == ''){
        $actualizacion = null; 
      }else if(count($users) == 2){
        str_replace(',', '', $actualizacion);
      }

      $update = DB::table('lineas')
      ->where('id',$id)
      ->update([
        'usuario' => $actualizacion
      ]);

      if($update){

        $usuario = Empleado::find($usuario);

        return Response::json([
          'respuesta' => true,
          'sw' => $sw,
          'actualizacion' => $actualizacion,
          'usuario' => $usuario,
          'nombre' => $usuario->nombres,
          'apellido' => $usuario->apellidos,
          'count' => count($users)
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    //WhatsApp
    public function postWhatsapp(){
 
      $numero = Input::get('numero');

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v15.0/109529185312847/messages");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);

      curl_setopt($ch, CURLOPT_POST, TRUE);

      curl_setopt($ch, CURLOPT_POSTFIELDS, "{
        \"messaging_product\": \"whatsapp\",
        \"to\": \"57".$numero."\",
        \"type\": \"template\",
        \"template\": {
          \"name\": \"envio\",
          \"language\": {
            \"code\": \"es\",
          },
        }
      }");

      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization: Bearer ".TransportesrutasController::KEY_WHATSAPP.""
      ));

      $response = curl_exec($ch);
      curl_close($ch);

      $sended = 12345;

      return Response::json([
        'respuesta' => true,
        'result' => json_decode($response),
        'sended' => json_decode($response)->messages[0]->id
      ]);

    }

    //APP RUTAS
    public function postHacersolicitudruta(){ //Solicitar ruta en la APP
 
      $id_usuario = Input::get('id');
      $fecha = Input::get('fecha');
      if($fecha=='Hoy'){
        $fecha = date('Y-m-d');
      }else{
        $fechaActual = date('Y-m-d');
        $fecha = strtotime ('+1 day', strtotime($fechaActual));
        $fecha = date ('Y-m-d' , $fecha);
      }
      $hora = Input::get('hora');
      $horasite = Input::get('horasite');
      $tiporuta = Input::get('tiporuta');
      $site = Input::get('site');
      $direccion = Input::get('direccion');
      $barrio = Input::get('barrio');
      $localidade = Input::get('localidade');
      $predeterminada = Input::get('predeterminada');

      $employID = User::find($id_usuario);

      $rutaActiva = DB::table('solicitud_rutas')
      ->where('employ_id',$employID->email)
      ->where('fecha',date('Y-m-d'))
      ->first();

      if($rutaActiva){

        return Response::json([
          'respuesta' => 'activa'
        ]);

      }else{

        $ruta = new SolicitudRutas();

        $ruta->employ_id = $employID->email;
        $ruta->fecha = $fecha;
        $ruta->hora = $hora;
        //$ruta->horasite = $horasite;
        $ruta->direccion = $direccion;
        $ruta->barrio = $barrio;
        $ruta->localidade = $localidade;
        $ruta->site = $site;
        
        if($ruta->save()){

          if($predeterminada==true){

            $employID->cargo = $direccion;
            $employID->barrio = $barrio;
            $employID->localidade = $localidade;
            $employID->save();

          }

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

    public function postMiruta(){ //Consulta de ruta solicitidad y/o programada
 
      $id = Input::get('id');

      $employID = User::find($id);

      $fechaActual = date('Y-m-d');

      $diasiguiente = strtotime ('+1 day', strtotime($fechaActual));
      $diasiguiente = date ('Y-m-d' , $diasiguiente);

      $query = DB::table('solicitud_rutas')
      ->where('employ_id',$employID->email)
      ->where('fecha',date('Y-m-d'))
      ->first();
      
      if($query){

        $rutaProgramada = DB::table('qr_rutas')
        ->where('id_usuario',$employID->email)
        ->where('fecha',$query->fecha)
        ->where('hora',$query->hora)
        ->first();

        return Response::json([
          'respuesta' => true,
          'solicitud' => $query,
          'rutaProgramada' => $rutaProgramada
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postConsultarvehiculo(){ //Consultar vehículo en la vista de rutas
 
      $id = Input::get('id');
      $servicio = Input::get('servicio');

      $select = DB::table('servicios')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'vehiculos.id as id_vehiculo', 'conductores.nombre_completo', 'conductores.celular', 'conductores.foto_app', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.color', 'vehiculos.modelo', 'vehiculos.clase')
      ->where('servicios.id',$servicio)
      ->first();

      $employ = Input::get('employ');

      $select2 = DB::table('qr_rutas')
      ->where('servicio_id',$servicio)
      ->where('id_usuario',$employ)
      ->first();

      if($select){

        return Response::json([
          'respuesta' => true,
          'vehiculo' => $select,
          'qr' => $select2
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postConsultarqr(){ //Consultar qr en la vista de ruta
 
      $id = Input::get('id');
      $servicio = Input::get('servicio');
      $employ = Input::get('employ');

      $select = DB::table('qr_rutas')
      ->where('servicio_id',$servicio)
      ->where('id_usuario',$employ)
      ->first();

      if($select){

        return Response::json([
          'respuesta' => true,
          'qr' => $select
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postDeleterequest(){ //(Test) eliminación de solicitud
 
      $id = Input::get('id');
      
      $query = "delete from solicitud_rutas where id = ".$id."";
      $consulta = DB::select($query);

      if($consulta){

        return Response::json([
          'respuesta' => true,
          'consulta' => $consulta
        ]);

      }else{

        return Response::json([
          'respuesta' => false
        ]);

      }

    }

    public function postDireccionpredeterminada(){ //Consulta de dirección predeterminada
 
      $id = Input::get('id');

      $consulta = DB::table('users')
      ->where('id',$id)
      ->first();

      if($consulta){

        return Response::json([
          'respuesta' => true,
          'direccion' => $consulta
        ]);

      }

    }

    public function postEliminardireccion(){ //Eliminación de dirección predeterminada
 
      $id = Input::get('id');

      $consulta = DB::table('users')
      ->where('id',$id)
      ->update([
        'cargo' => null,
        'barrio' => null,
        'localidade' => null
      ]);

      if($consulta){

        return Response::json([
          'respuesta' => true
        ]);

      }

    }

    public function postServicioactivo(){ //CONSULTAS V1

      $user = User::find(Input::get('user_id'));
      $employ = Input::get('employ');

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      $diasiguiente = strtotime ('+1 day', strtotime($fecha));
      $diasiguiente = date ('Y-m-d' , $diasiguiente);

      $servicios_activos = DB::table('servicios')
      ->leftJoin('qr_rutas', 'qr_rutas.servicio_id', '=', 'servicios.id')
      ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.estado_servicio_app', 'servicios.recorrido_gps', 'servicios.pendiente_autori_eliminacion', 'servicios.dejar_en', 'qr_rutas.id_usuario')
      ->where('estado_servicio_app', 1)
      ->where('qr_rutas.id_usuario',$employ)
      ->whereNull('pendiente_autori_eliminacion')
      ->whereBetween('fecha_servicio', [$diaanterior, $diasiguiente])
      ->whereNotNull('recorrido_gps')
      ->orderBy('fecha_servicio')
      ->orderBy('hora_servicio')
      //->with(['conductor', 'vehiculo'])
      ->first();

      $servicios_calificar = DB::table('qr_rutas')
      ->leftJoin('servicios', 'servicios.id', '=', 'qr_rutas.servicio_id')
      ->select('qr_rutas.*', 'servicios.id as id_de_servicio', 'servicios.pendiente_autori_eliminacion', 'servicios.estado_servicio_app', 'servicios.fecha_servicio', 'servicios.hora_servicio')

      ->where('id_usuario', $user->email)
      ->whereNull('servicios.pendiente_autori_eliminacion')
      ->where('estado_servicio_app', 2)
      ->whereNull('qr_rutas.rate')
      ->first();

      $notificacion = DB::table('notificaciones')
      ->where('id_usuario',Input::get('user_id'))
      ->whereNull('leido')
      ->get();

      $notificacion = count($notificacion);

      if (count($servicios_activos)) {

        return Response::json([
          'response' => true,
          'servicios' => $servicios_activos,
          'notificacion' => $notificacion,
          'calificar' => $servicios_calificar,
          'employ' => $employ
        ]);

      }else {

        return Response::json([
          'response' => false,
          'notificacion' => $notificacion,
          'calificar' => $servicios_calificar
        ]);

      }

    }

    public function postCalificarruta(){

      $employ = Input::get('employ');

      $update = DB::table('qr_rutas')
      ->where('id_usuario',$employ)
      ->where('servicio_id',Input::get('id_servicio'))
      ->update([
        'rate' => Input::get('calificacion'),
        'comentarios' => Input::get('comentario')
      ]);

      if($update) {

        return Response::json([
          'response' => true
        ]);

      }

    }

    public function postRate(){ //Calificación mediante notificación push

      $id = Input::get('id_servicio');
      $employ = Input::get('employ');

      $servicios_calificar = DB::table('qr_rutas')
      ->leftJoin('servicios', 'servicios.id', '=', 'qr_rutas.servicio_id')
      ->select('qr_rutas.*', 'servicios.id as id_de_servicio', 'servicios.pendiente_autori_eliminacion', 'servicios.estado_servicio_app', 'servicios.fecha_servicio', 'servicios.hora_servicio')
      ->where('qr_rutas.servicio_id',$id)
      ->where('id_usuario', $employ)
      ->whereNull('servicios.pendiente_autori_eliminacion')
      ->where('estado_servicio_app', 2)
      ->whereNull('qr_rutas.rate')
      ->first();

      if($servicios_calificar!=null){ //Se puede calificar

        return Response::json([
          'respuesta' => false,
          'servicio' => $servicios_calificar
        ]);

      }else{ //Ya está calificado

        return Response::json([
          'respuesta' => true,
          'servicio' => $servicios_calificar
        ]);

      }

    }

    public function postRutasbogota() {

      $localidad = Input::get('localidad');

      $cc = 287;

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      $rutas = DB::table('servicios')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->select('servicios.id','servicios.fecha_servicio','servicios.hora_servicio','servicios.cantidad','servicios.ruta','conductores.nombre_completo', 'vehiculos.placa')
      ->whereBetween('fecha_servicio',[$diaanterior,$fecha])
      ->where('centrodecosto_id',$cc)
      ->whereNotNull('ruta')
      ->get();

      $query = "SELECT DISTINCT hora_servicio FROM servicios WHERE fecha_servicio between '".$diaanterior."' AND '".$fecha."' AND ruta = 1 AND centrodecosto_id = ".$cc." AND pendiente_autori_eliminacion IS NULL";

      $select = DB::select($query);

      $queryFechas = "SELECT DISTINCT fecha_servicio FROM servicios WHERE fecha_servicio between '".$diaanterior."' AND '".$fecha."' AND ruta = 1 AND centrodecosto_id = 19 AND pendiente_autori_eliminacion IS NULL";

      $fechas = DB::select($queryFechas);

      return Response::json([
        'respuesta' => true,
        'rutas' => $rutas,
        'fechas' => $fechas,
        'horas' => $select
      ]);

    }

    public function postRutas() {

      $localidad = Input::get('localidad');

      $cc = 19;

      $fecha = date('Y-m-d');
      $diaanterior = strtotime ('-1 day', strtotime($fecha));
      $diaanterior = date ('Y-m-d' , $diaanterior);

      $rutas = DB::table('servicios')
      ->leftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
      ->leftJoin('vehiculos', 'vehiculos.id', '=', 'servicios.vehiculo_id')
      ->select('servicios.id','servicios.fecha_servicio','servicios.hora_servicio','servicios.cantidad','servicios.ruta','conductores.nombre_completo', 'vehiculos.placa')
      ->whereBetween('fecha_servicio',[$diaanterior,$fecha])
      ->where('centrodecosto_id',$cc)
      ->whereNotNull('ruta')
      ->get();

      $query = "SELECT DISTINCT hora_servicio FROM servicios WHERE fecha_servicio between '".$diaanterior."' AND '".$fecha."' AND ruta = 1 AND centrodecosto_id = ".$cc." AND pendiente_autori_eliminacion IS NULL";

      $select = DB::select($query);

      $queryFechas = "SELECT DISTINCT fecha_servicio FROM servicios WHERE fecha_servicio between '".$diaanterior."' AND '".$fecha."' AND ruta = 1 AND centrodecosto_id = 19 AND pendiente_autori_eliminacion IS NULL";

      $fechas = DB::select($queryFechas);

      return Response::json([
        'respuesta' => true,
        'rutas' => $rutas,
        'fechas' => $fechas,
        'horas' => $select
      ]);

    }

    public function postListapasajeros(){

      $id_servicio= Input::get('id_servicio');

      $usuarios=DB::table('qr_rutas')
      ->select('qr_rutas.id','qr_rutas.status','qr_rutas.fullname','qr_rutas.address','qr_rutas.neighborhood', 'qr_rutas.id_rutaqr')
      ->where('qr_rutas.servicio_id',$id_servicio)
      ->get();

      if (count($usuarios)){
        return Response::json([
          'respuesta'=>true,
          'usuarios'=>$usuarios
        ]);

      }else{

        return Response::json([
          'respuesta'=>false,
          'consulta'=>$usuarios
        ]);

      }
    }

    public function postAgregarpax(){

      $nombre = Input::get('nombre');
      $employ = Input::get('employ');
      $celular = Input::get('celular');
      $direccion = Input::get('direccion');
      $barrio = Input::get('barrio');
      $novedad = Input::get('novedad');
      $campana = Input::get('campana');

      $servicio = Servicio::find(Input::get('id'));

      $array = [
        'nombres' => strtoupper($nombre),
        'apellidos' => $employ,
        'cedula' => $celular,
        'direccion' => strtoupper($direccion),
        'barrio' => strtoupper($barrio),
        'cargo' => '',
        'area' => $novedad,
        'sub_area' => $campana,
        'hora' => $servicio->hora_servicio
      ];

      $objArray = json_decode($servicio->pasajeros_ruta);
      array_push($objArray, $array);
      $servicio->pasajeros_ruta = json_encode($objArray);
      $servicio->cantidad = intval($servicio->cantidad)+1;

      if($servicio->save()){

        if($servicio->localidad!=null){
          
          $data = [
            'latitude' => Input::get('lat'),
            'longitude' => Input::get('lng')
          ];

        }
        $qr = new Ruta_qr();
        $qr->id_usuario = $employ;  //ID del pasajero
        $qr->cel = $celular; //Celular del pasajero
        $qr->address = strtoupper($direccion); //Dirección del pasajero
        $qr->fullname = strtoupper($nombre); //Nombre completo del pasajero
        $qr->neighborhood = strtoupper($barrio); //Barrio del pasajero
        $qr->id_rutaqr = $novedad; //Novedad registrada
        $qr->fecha = $servicio->fecha_servicio;
        $qr->hora = $servicio->hora_servicio; //Hora del Servicio
        $qr->servicio_id = Input::get('id'); //Id del servicio
        $qr->employ = $campana; //Campaña del usuario
        if($servicio->localidad!=null){
          $qr->coords = json_encode([$data]);
        }
        //$qr->vehiculo = $placa; //Placa del vehículo
        $qr->save();

        $message = "Pasajero agregado como novedad!";

        return Response::json([
          'respuesta' => true,
          'message' => $message
        ]);

      }else{

        $message = "No se pudo completar el proceso. ¡Inténtalo de nuevo!";

        return Response::json([
          'respuesta' => true,
          'message' => $message
        ]);

      }

    }

  }