<?php

class ProvisionalController extends BaseController{

    public function getIndex(){
      return View::make('admin.form_limpieza');
    }

    public function getFormularioupdate(){

      $documentos = DB::table('limpieza_vehiculos')->get();

      return View::make('admin.reporte')
      ->with('documentos',$documentos);
    }

    public function getFormularioupdate1(){
      //return View::make('admin.mantenimiento2');
      
      $fecha = '20201223';

      //PROCESO A REALIZAR
      $consulta = "select control_ingreso.id, control_ingreso.hora_llegada, control_ingreso.hora_salida, control_ingreso.hora_llegadapm, control_ingreso.hora_salidapm, control_ingreso.observaciones, empleados.nombres, empleados.apellidos, empleados.sede, empleados.cargo from control_ingreso left join empleados on empleados.id =  control_ingreso.empleado where empleados.estado=1 and empleados.sede='BARRANQUILLA' and control_ingreso.fecha = '".$fecha."' ";
      $documentos = DB::select($consulta);

      $documentos = DB::table('limpieza_vehiculos')->get();

      return View::make('admin.reporte')
      ->with('documentos',$documentos)
      ->with('fecha',$fecha);
    }

    public function postGuardar(){
        if(Request::ajax()){
            $validaciones = [
              'nombre_proveedor'=>'required|select',
              'nombre_conductor'=>'required|select',
              'placa'=>'required|select',
              'tipo_vehiculo'=>'required|select',
              'telefono'=>'required|numeric',
              'ciudad'=>'required|sololetrasyespacio',              
              'politicas'=>'accepted',
            ];

            $mensajes = [
              'nombre_proveedor.select'=>'Debe seleccionar una opción de NOMBRE DE PROVEEDOR',
              'nombre_conductor.select'=>'Debe seleccionar una opción de NOMBRE DE CONDUCTOR',
              'placa.select'=>'Debe seleccionar un valor válido para la opción VEHÍCULO',
              'placa.required'=>'El campo VEHÍCULO es obligatorio',
              'tipo_vehiculo.select'=>'Debe seleccionar una opción de TIPO DE VEHÍCULO',
              'telefono.required'=>'El campo TELÉFONO es obligatorio',
              'telefono.numeric'=>'El campo TELÉFONO debe ser numérico',
              'ciudad.sololetrasyespacio'=>'Debe seleccionar una opción de CIUDAD',              
              'politicas.accepted'=>'Se deben aceptar las POLÍTICAS',

            ];

          $validador = Validator::make(Input::all(), $validaciones,$mensajes);

          if ($validador->fails())
          {
            return Response::json([
              'mensaje'=>false,
              'errores'=>$validador->errors()->getMessages()
            ]);

          }else{

            $nombre_proveedor = Input::get('nombre_proveedor');
            $nombre_conductor = Input::get('nombre_conductor');
            $placa = Input::get('placa');
            $tipo_vehiculo = Input::get('tipo_vehiculo');
            $telefono = Input::get('telefono');
            $ciudad = Input::get('ciudad');
            $fecha = Input::get('fecha_servicio');            

            $formulario = new Formulario;
            $formulario->nombre_proveedor = $nombre_proveedor;
            $formulario->nombre_conductor = $nombre_conductor;
            $formulario->placa = $placa;
            $formulario->tipo_vehiculo = $tipo_vehiculo;
            $formulario->telefono = $telefono;
            $formulario->ciudad = $ciudad;
            $formulario->fecha = $fecha;            
            $formulario->limpieza = input::get('dato1');
            $formulario->elementos_limpieza = input::get('dato2');            
           
            if($formulario->save()){              

              return Response::json([
                'mensaje'=>true,                
                'name'=>$nombre_conductor,
                'ciudadpdf'=>$ciudad,
                'nombrep'=>$nombre_proveedor,
                'fechapdf'=>$fecha,
              ]);

            }//fin si guardado
        }
        }      
    }//SG

    public function getDownloadpdf(){
      $nombrec = Input::get('nombrec');
      $nombrep = Input::get('nombrep');
      $ciudadpdf = Input::get('ciudadpdf');
      $fechapdf = Input::get('fechapdf');
      $placapdf = Input::get('placapdf');
      $tipovehiculopdf = Input::get('tipovehiculopdf');
      $telefonopdf = Input::get('telefonopdf');

      $html = View::make('admin.pdf_limpieza')
      ->with(['nombrec'=>$nombrec, 'nombrep'=>$nombrep, 'ciudadpdf'=>$ciudadpdf, 'fechapdf'=>$fechapdf, 'placapdf'=>$placapdf, 'telefonopdf'=>$telefonopdf, 'tipovehiculopdf'=>$tipovehiculopdf]);
      return PDF::load(utf8_decode($html), 'A4', 'portrait')->download('COSTANCIA DE LIMPIEZA '.$nombrec);
    }


    public function postMostrarproveedores(){
        $id = Input::get('valor');
        if($id==1){
          $proveedores = DB::table('proveedores')->where('localidad', 'BARRANQUILLA')->orderBy('razonsocial')->get();
        }elseif ($id==2) {
          $proveedores = DB::table('proveedores')->where('localidad', 'BOGOTA')->orderBy('razonsocial')->get();
        }else {
          $proveedores = '';
        }

        if(!empty($proveedores)){
            return Response::json([
                'mensaje'=>true,
                'respuesta'=>$proveedores
            ]);
        }else if(empty($proveedores)){
            return Response::json([
                'mensaje'=>false
            ]);
        }
    }

      public function postMostrarconductoresyvehiculos(){
        $id = Input::get('id');
        $conductores = DB::table('conductores')->where('proveedores_id', $id)->orderBy('nombre_completo')->get();
        $vehiculos = DB::table('vehiculos')->where('proveedores_id',$id)->orderBy('placa')->get();

        if(!empty($conductores) and !empty($vehiculos)){
            return Response::json([
                'mensaje'=>true,
                'conductores'=>$conductores,
                'vehiculos' =>$vehiculos
            ]);
        }else if(empty($proveedores)){
            return Response::json([
                'mensaje'=>false
            ]);
        }
    }

    public function getTest(){
      $conductores = DB::table('conductores')->whereIn('id',[2,3,4,5,6,66,78,56,34,22,56,77,88,98,12])->get();
      return View::make('servicios.nuevos.test')
      ->with('conductores',$conductores);
    }

}
