<?php
use App\User;
use App\Controllers\Controller;

class importController extends BaseController{

    public function getIndex(){

        if (Sentry::check()){
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
          $ver = $permisos->administracion->importar_pasajeros->ver;
        }else{
            $ver = null;
        }

        if (!Sentry::check()){            
          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on') {
            return View::make('admin.permisos');
        }else{
      
            $centrosdecosto = Centrodecosto::Internos()->orderBy('razonsocial')->get();
            $pasajeros = Pasajero::where('cedula', 12)->orderBy('nombres')->get();

            return View::make('servicios.pasajeros.importar')
                ->with('centrosdecosto',$centrosdecosto)      
                ->with('permisos',$permisos)
                ->with('pasajeros',$pasajeros)
                ->with('o',$o=1);
        }
    }

    public function postImportarexcelp(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

          $var = '';

          Excel::selectSheetsByIndex(0)->load(Input::file('excel'), function($reader){
              $reader->skip(1);
              $result = $reader->noHeading()->get();
              $cc = DB::table('centrosdecosto')->where('id',Input::get('centrodecosto_id'))->pluck('razonsocial');
              foreach($result as $value){            

                $nombre_excel = $value[0];

                $apellidos_excel = $value[1];
                $dataExcel[] = [
                     'cedula'=> strtoupper(trim($nombre_excel)),
                     'idemployer'=> strtoupper($apellidos_excel),
                     'nombres'=>strtoupper(trim($value[2])),
                     'apellidos'=>strtoupper(trim($value[3])),
                     'telefono'=>strtoupper(trim($value[4])),
                     'direccion'=>strtoupper(trim($value[5])),
                     'barrio'=>strtoupper(trim($value[6])),
                     'municipio'=>strtoupper(trim($value[7])),
                     'departamento'=>strtoupper(trim($value[8])),
                     'correo'=>strtoupper(trim($value[9])),
                     'area'=>strtoupper(trim($value[10])),
                     'sub_area'=>strtoupper(trim($value[11])),
                     'eps'=>strtoupper(trim($value[12])),
                     'arl'=>strtoupper(trim($value[13])),
                     'cc' => strtoupper(trim($cc))
                  ];
              }

              echo $var = json_encode($dataExcel);

          });
      }

    }//SG

    public function postNuevopasajero1(){

      if (!Sentry::check()){
        return Response::json([
            'respuesta' => 'relogin'
        ]);
      }else{
        $pasajeros = json_decode(Input::get('pasajeros'));
        $sw=0;
        $sw2 = 0;
        foreach ($pasajeros as $item) {          
          $user = DB::table('pasajeros')->where('cedula', $item->cedula)->get();      
//          $nombrerazonsocial= DB::table('centrosdecosto')->where('id',$item->centrodecosto)->pluck('razonsocial');
	$nombrerazonsocial= $item->centrodecosto;
          if($user!=null){

          }else{
            $sw++;
            $pasajero = new Pasajero();
            $pasajero->cedula = $item->cedula;
            $pasajero->id_employer = $item->id_employeer;
            $pasajero->nombres = $item->nombres;
            $pasajero->apellidos = $item->apellidos;
            $pasajero->telefono = $item->telefono;
            $pasajero->direccion = $item->direccion;
            $pasajero->barrio = $item->barrio;
            $pasajero->municipio = $item->municipio;
            $pasajero->departamento = $item->departamento;
            $pasajero->correo = $item->correo;
            
            $qr_code = DNS2D::getBarcodePNG($item->id_employeer, "QRCODE", 10, 10,array(1,1,1), true);
          
            Image::make($qr_code)->save('biblioteca_imagenes/facturacion/ingresos/'.$item->id_employeer.'.png');

            $data = [          
              'codigo' => $item->id_employeer,
              'nombres'=> $item->nombres,
              'apellidos'=> $item->apellidos,
              'razonsocial'=> $nombrerazonsocial

            ];

            $pass=$item->correo;
            
            Mail::send('emails.correo_pasajeros', $data, function($message) use ($pass){

              $message->from('sistemas@aotour.com.co', 'Registro de Pasajero - Autonet');
              $message->to($pass)->subject('Información de pasajero');
		$message->cc('aotourdeveloper@gmail.com');
            });  
            
            /*Mail::send(['text'=>'mail'],['name'])*/
            $pasajero->area = $item->area;
            $pasajero->sub_area = $item->subarea;
            $pasajero->eps = $item->eps;
            $pasajero->arl = $item->arl;
            $pasajero->estado = 1;
            $pasajero->version = 1;
            $pasajero->centrodecosto_id = Input::get('centrodecosto_id');
            $pasajero->save();
          } 
        } 
                   
        if($sw==0){
          return Response::json([
            'respuesta'=>false,
          ]);
        }else{
          return Response::json([
            'respuesta'=>true,
          ]);
        }        
      }
    }//SG




}

