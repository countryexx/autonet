<?php
class HvvehiculosController extends BaseController{

      ##------- RC ---------##
      public function getHvvehiculos($id){

        function registraHvdocumentacion($id_hv1, $id_vehiculo1, $tipo_doc1, $fecha_vence1){
            $tabladocumentacion = new hvdocumentacion;
            $tabladocumentacion->hv_vehiculo_id = $id_hv1;
            $tabladocumentacion->vehiculo_id = $id_vehiculo1;
            $tabladocumentacion->tipo_documento = $tipo_doc1;
            $tabladocumentacion->fecha_vencimiento = $fecha_vence1;
            $tabladocumentacion->save();
        }

        if(Sentry::check()){
          $id_rol = Sentry::getUser()->id_rol;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);

        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
        }

        if (isset($permisos->administrativo->proveedores->ver)){
            $ver = $permisos->administrativo->proveedores->ver;
        }else{
            $ver = null;
        }

        if($ver!='on' ) {
            return View::make('admin.permisos');
        }else{
          $vehiculo = DB::table('vehiculos')->where('id',$id)->first();

          if ($vehiculo){
            $hvexiste = DB::table('hv_vehiculo')->where('vehiculo_id',$id)->first();

            if(!$hvexiste){
              $hoja_vida = new hvvehiculo;
              $hoja_vida->vehiculo_id = $id;
              $hoja_vida->save();

              $id_hv_vehiculo = $hoja_vida->id;

              if ($vehiculo->fecha_vigencia_operacion != null) {
                registraHvdocumentacion($id_hv_vehiculo, $id, 'TARJETA DE OPERACION', $vehiculo->fecha_vigencia_operacion);

              }
              if ($vehiculo->fecha_vigencia_soat != null){
                registraHvdocumentacion($id_hv_vehiculo, $id, 'SOAT', $vehiculo->fecha_vigencia_soat);

              }
              if ($vehiculo->fecha_vigencia_tecnomecanica != null){
                registraHvdocumentacion($id_hv_vehiculo, $id, 'TECNOMECANICA', $vehiculo->fecha_vigencia_tecnomecanica);

              }
              if ($vehiculo->poliza_todo_riesgo != null){
                registraHvdocumentacion($id_hv_vehiculo, $id, 'POLIZA TODO RIESGO', $vehiculo->poliza_todo_riesgo);

              }
              if ($vehiculo->poliza_contractual != null){
                registraHvdocumentacion($id_hv_vehiculo, $id, 'POLIZA CONTRACTUAL', $vehiculo->poliza_contractual);

              }
              if ($vehiculo->poliza_extracontractual != null){
                registraHvdocumentacion($id_hv_vehiculo, $id, 'POLIZA EXTRACONTRACTUAL', $vehiculo->poliza_extracontractual);

              }

            }else {
              $id_hv_vehiculo = $hvexiste->id;
              $doc_existe = DB::table('hv_documentacion')->where('hv_vehiculo_id',$hvexiste->id)->where('vehiculo_id',$id)->orderBy('fecha_vencimiento')->get();

              if ($doc_existe != null) {
                $sw_tarjeta_operacion = 0;
                $sw_soat = 0;
                $sw_tecnomecanica = 0;
                $sw_todo_riesgo = 0;
                $sw_contractual = 0;
                $sw_extracontractual = 0;

                foreach($doc_existe as $documento_exis){
                  if($documento_exis->tipo_documento === 'TARJETA DE OPERACION'){
                    if ($documento_exis->fecha_vencimiento === $vehiculo->fecha_vigencia_operacion) {
                        $sw_tarjeta_operacion = 1;

                    }
                  }
                  if($documento_exis->tipo_documento === 'SOAT'){
                    if ($documento_exis->fecha_vencimiento === $vehiculo->fecha_vigencia_soat) {
                        $sw_soat = 1;

                    }
                  }
                  if($documento_exis->tipo_documento === 'TECNOMECANICA'){
                    if ($documento_exis->fecha_vencimiento === $vehiculo->fecha_vigencia_tecnomecanica) {
                        $sw_tecnomecanica = 1;

                    }
                  }
                  if($documento_exis->tipo_documento === 'POLIZA TODO RIESGO'){
                    if ($documento_exis->fecha_vencimiento === $vehiculo->poliza_todo_riesgo) {
                        $sw_todo_riesgo = 1;

                    }
                  }
                  if($documento_exis->tipo_documento === 'POLIZA CONTRACTUAL'){
                    if ($documento_exis->fecha_vencimiento === $vehiculo->poliza_contractual) {
                      $sw_contractual = 1;

                    }
                  }
                  if($documento_exis->tipo_documento === 'POLIZA EXTRACONTRACTUAL'){
                    if ($documento_exis->fecha_vencimiento === $vehiculo->poliza_extracontractual) {
                        $sw_extracontractual = 1;

                    }
                  }
                }

                if($sw_tarjeta_operacion === 0){
                  registraHvdocumentacion($hvexiste->id, $id, 'TARJETA DE OPERACION', $vehiculo->fecha_vigencia_operacion);

                }
                if($sw_soat === 0) {
                  registraHvdocumentacion($hvexiste->id, $id, 'SOAT', $vehiculo->fecha_vigencia_soat);

                }
                if($sw_tecnomecanica === 0){
                  registraHvdocumentacion($hvexiste->id, $id, 'TECNOMECANICA', $vehiculo->fecha_vigencia_tecnomecanica);


                }
                if($sw_todo_riesgo === 0){
                  registraHvdocumentacion($hvexiste->id, $id, 'POLIZA TODO RIESGO', $vehiculo->poliza_todo_riesgo);

                }
                if($sw_contractual === 0){
                  registraHvdocumentacion($hvexiste->id, $id, 'POLIZA CONTRACTUAL', $vehiculo->poliza_contractual);

                }
                if($sw_extracontractual === 0){
                  registraHvdocumentacion($hvexiste->id, $id, 'POLIZA EXTRACONTRACTUAL', $vehiculo->poliza_extracontractual);

                }

              } else{
                    if ($vehiculo->fecha_vigencia_operacion != null || $vehiculo->fecha_vigencia_operacion != '0000-00-00' || $vehiculo->fecha_vigencia_operacion != '') {
                      registraHvdocumentacion($hvexiste->id, $id, 'TARJETA DE OPERACION', $vehiculo->fecha_vigencia_operacion);

                    }
                    if ($vehiculo->fecha_vigencia_soat != null || $vehiculo->fecha_vigencia_soat != '0000-00-00' || $vehiculo->fecha_vigencia_soat != ''){
                      registraHvdocumentacion($hvexiste->id, $id, 'SOAT', $vehiculo->fecha_vigencia_soat);

                    }
                    if ($vehiculo->fecha_vigencia_tecnomecanica != null || $vehiculo->fecha_vigencia_tecnomecanica != '0000-00-00' || $vehiculo->fecha_vigencia_tecnomecanica != ''){
                      registraHvdocumentacion($hvexiste->id, $id, 'TECNOMECANICA', $vehiculo->fecha_vigencia_tecnomecanica);

                    }
                    if ($vehiculo->poliza_todo_riesgo != null || $vehiculo->poliza_todo_riesgo != '0000-00-00' || $vehiculo->poliza_todo_riesgo != ''){
                      registraHvdocumentacion($hvexiste->id, $id, 'POLIZA TODO RIESGO', $vehiculo->poliza_todo_riesgo);

                    }
                    if ($vehiculo->poliza_contractual != null || $vehiculo->poliza_contractual != '0000-00-00' || $vehiculo->poliza_contractual != ''){
                      registraHvdocumentacion($hvexiste->id, $id, 'POLIZA CONTRACTUAL', $vehiculo->poliza_contractual);

                    }
                    if ($vehiculo->poliza_extracontractual != null || $vehiculo->poliza_extracontractual != '0000-00-00' || $vehiculo->poliza_extracontractual != ''){
                      registraHvdocumentacion($hvexiste->id, $id, 'POLIZA EXTRACONTRACTUAL', $vehiculo->poliza_extracontractual);

                    }
                }
            }
            
            if(isset($hvexiste->id) || isset($id_hv_vehiculo)){
                
            }

            $imagenes = DB::table('img_vehiculos')->where('vehiculos_id',$id)->get();
            $hvexiste = DB::table('hv_vehiculo')->where('vehiculo_id',$id)->first();
            $hvdocumentacion = DB::table('hv_documentacion')->where('hv_vehiculo_id',$id_hv_vehiculo)->orderBy('fecha_vencimiento', 'desc')->whereNull('anulado')->get();
            $hvconductores = DB::table('hv_conductores')->where('hv_vehiculo_id',$id_hv_vehiculo)->whereNull('anulado')->get();
            $conductores = DB::table('conductores')->orderBy('nombre_completo')->get();
            $hvsuceso = DB::table('hv_suceso')->where('hv_vehiculo_id',$id_hv_vehiculo)->whereNull('anulado')->get();
            $clientes = DB::table('centrosdecosto')->orderBy('razonsocial')->get();
            $hvcomparendos = DB::table('hv_comparendos')->where('hv_vehiculo_id',$id_hv_vehiculo)->whereNull('anulado')->get();
            
            $mantenimiento_kilometraje = DB::table('mantenimiento_kilometraje')->where('hv_vehiculo_id',$id_hv_vehiculo)->whereNull('anulado')->orderBy('kilometraje', 'asc')->get();
			
            $mtmt_select = "select km.id, km.kilometraje, km.fecha  from mantenimiento_kilometraje as km left join mantenimiento_revision as rev on rev.mantenimiento_kilometraje_id = km.id where km.hv_vehiculo_id = '$id_hv_vehiculo' and km.anulado is null and rev.mantenimiento_kilometraje_id is null ";
			$mtmt_select2 = DB::select($mtmt_select);
			
			$prog_mtn = "select opkm.mantenimiento_kilometraje_id, km.kilometraje, rev.mantenimiento_operacion_id, opkm.mantenimiento_operacion_id, op.item
    from mantenimiento_operacion_kilometraje AS opkm
    left join mantenimiento_revision as rev on rev.mantenimiento_operacion_id = opkm.id
    left join mantenimiento_operacion as op ON op.id = opkm.mantenimiento_operacion_id
    left join mantenimiento_kilometraje as km ON km.id = opkm.mantenimiento_kilometraje_id
where opkm.hv_vehiculo_id = '$id_hv_vehiculo' and opkm.anulado is null   order by opkm.mantenimiento_operacion_id, opkm.mantenimiento_kilometraje_id";
			$prog_mtn2 = DB::select($prog_mtn);
			
			$mantenimiento_operacion = DB::table('mantenimiento_operacion')->whereNull('anulado')->get();
			$mantenimiento_op_km = DB::table('mantenimiento_operacion_kilometraje')
									->select('mantenimiento_operacion.item', 'mantenimiento_kilometraje.kilometraje','mantenimiento_operacion_kilometraje.id')
									->leftJoin('mantenimiento_kilometraje', 'mantenimiento_operacion_kilometraje.mantenimiento_kilometraje_id', '=', 'mantenimiento_kilometraje.id')
									->leftJoin('mantenimiento_operacion', 'mantenimiento_operacion_kilometraje.mantenimiento_operacion_id', '=', 'mantenimiento_operacion.id')
									->where('mantenimiento_operacion_kilometraje.hv_vehiculo_id',$id_hv_vehiculo)->whereNull('mantenimiento_operacion_kilometraje.anulado')->orderBy('mantenimiento_operacion_kilometraje.mantenimiento_operacion_id', 'asc')->get();
			
			$mtn_revision = DB::table('mantenimiento_revision')->where('hv_vehiculo_id',$id_hv_vehiculo)->groupBy('mantenimiento_kilometraje_id')->get();
            
            $hvmantenimientos = DB::table('hv_mantenimientos')->where('hv_vehiculo_id',$id_hv_vehiculo)->whereNull('anulado')->get();


              return View::make('hvvehiculos.hvvehiculos')
               ->with([
                  'permisos'=>$permisos,
                  'vehiculo'=> $vehiculo,
                  'img_vehiculos'=>$imagenes,
                  'hojavida_vehiculo'=> $hvexiste,
                  'hojavida_documentacion'=> $hvdocumentacion,
                  'hojavida_conductores'=> $hvconductores,
                  'conductores'=> $conductores,
                  'clientes'=> $clientes,
                  'hojavida_comparendos'=> $hvcomparendos,
                  'hojavida_suceso'=> $hvsuceso,
                   'mantenimiento_kilometraje'=> $mantenimiento_kilometraje,
				   'mtmt_select2'=> $mtmt_select2,
				   'prog_mtn2'=> $prog_mtn2,
                   'mantenimiento_operacion'=> $mantenimiento_operacion,
				   'mantenimiento_op_km'=> $mantenimiento_op_km,
                   'hojavida_mantenimientos' => $hvmantenimientos,
				   'mtn_revision' => $mtn_revision,
                  'id'=>$id
              ]);
          }

        }

      }


      public function postNuevodocumento(){
        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
              if(Request::ajax()){
            $validaciones = [
              'tipo_documento'=>'required|select',
              'numero_documento'=>'required|numeric',
              'empresa_emite'=>'required|sololetrasyespacio',
              'valor_doc'=>'required|numeric',
              'fecha_emision'=>'required|date_format:Y-m-d|alpha_dash',
              'fecha_vigencia'=>'required|date_format:Y-m-d|alpha_dash'
            ];

          $mensajes = [
              'tipo_documento.required'=>'Seleccione un tipo de Documento',
              'numero_documento.numeric'=>'El campo numero documento debe ser numerico',
              'valor_doc.numeric'=>'El campo valor debe ser numerico',
              'fecha_vigencia.required'=>'El campo fecha vigencia es requerido',
              'empresa_emite.sololetrasyespacio'=>'Este campo debe tener solo letras y espacio'
          ];

          $validador = Validator::make(Input::all(), $validaciones, $mensajes);

          if ($validador->fails()){
              return Response::json([
                  'mensaje'=>false,
                  'errores'=>$validador->errors()->getMessages()
              ]);

          }else{

            $tabladocumentacion = new hvdocumentacion;
            $tabladocumentacion->hv_vehiculo_id = Input::get('hv_id');
            $tabladocumentacion->vehiculo_id = Input::get('id_veh');
            $tabladocumentacion->tipo_documento = Input::get('tipo_documento');
            $tabladocumentacion->empresa_emite = Input::get('empresa_emite');
            $tabladocumentacion->numero_documento = Input::get('numero_documento');
            $tabladocumentacion->fecha_expedicion = Input::get('fecha_emision');
            $tabladocumentacion->fecha_vencimiento = Input::get('fecha_vigencia');
            $tabladocumentacion->valor = Input::get('valor_doc');
            //$tabladocumentacion->save();

              if($tabladocumentacion->save()){
                  $id_docm = $tabladocumentacion->id;
                  $id_veh = $tabladocumentacion->vehiculo_id;
                  $t_docm = $tabladocumentacion->tipo_documento;
                  $fecha_docm = $tabladocumentacion->fecha_vencimiento;

                  if($t_docm === 'SOAT'){
                    $act_vehiculo= Vehiculo::find($id_veh);
                    $act_vehiculo->fecha_vigencia_soat = $fecha_docm;
                    $act_vehiculo->save();
                  }
                  if($t_docm === 'TARJETA DE OPERACION'){
                    $act_vehiculo= Vehiculo::find($id_veh);
                    $act_vehiculo->tarjeta_operacion = Input::get('numero_documento');
                    $act_vehiculo->fecha_vigencia_operacion = $fecha_docm;
                    $act_vehiculo->save();
                  }
                  if($t_docm === 'TECNOMECANICA'){
                    $act_vehiculo= Vehiculo::find($id_veh);
                    $act_vehiculo->fecha_vigencia_tecnomecanica = $fecha_docm;
                    $act_vehiculo->save();
                  }
                  if($t_docm === 'POLIZA TODO RIESGO'){
                    $act_vehiculo= Vehiculo::find($id_veh);
                    $act_vehiculo->poliza_todo_riesgo = $fecha_docm;
                    $act_vehiculo->save();
                  }
                  if($t_docm === 'POLIZA CONTRACTUAL'){
                    $act_vehiculo= Vehiculo::find($id_veh);
                    $act_vehiculo->poliza_contractual = $fecha_docm;
                    $act_vehiculo->save();
                  }
                  if($t_docm === 'POLIZA EXTRACONTRACTUAL'){
                    $act_vehiculo= Vehiculo::find($id_veh);
                    $act_vehiculo->poliza_extracontractual = $fecha_docm;
                    $act_vehiculo->save();
                  }

                  return Response::json([
                      'mensaje'=>true,
                      'respuesta'=>'Registro guardado correctamente!'
                  ]);
              }
          }
        }
        }
      }

      public function postEditardocumento(){
        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
              if(Request::ajax()){
            /*$validaciones = [
              'tipo_documento'=>'required|select',
              'numero_documento'=>'required|numeric',
              'empresa_emite'=>'required|sololetrasyespacio',
              'valor_doc'=>'required|numeric',
              'fecha_emision'=>'required|date_format:Y-m-d|alpha_dash',
              'fecha_vigencia'=>'required|date_format:Y-m-d|alpha_dash'
            ];

          $mensajes = [
              'tipo_documento.required'=>'Seleccione un tipo de Documento',
              'numero_documento.numeric'=>'El campo numero documento debe ser numerico',
              'valor_doc.numeric'=>'El campo valor debe ser numerico',
              'fecha_vigencia.required'=>'El campo fecha vigencia es requerido',
              'empresa_emite.sololetrasyespacio'=>'Este campo debe tener solo letras y espacio'
          ];

          $validador = Validator::make(Input::all(), $validaciones, $mensajes);

          if ($validador->fails()){
              return Response::json([
                  'mensaje'=>false,
                  'errores'=>$validador->errors()->getMessages()
              ]);

          }else{

            //$tabladocumentacion = new hvdocumentacion;
            $editvehiculo = hvdocumentacion::find(Input::get('eddoc_id'));
            $editvehiculo->hv_vehiculo_id = Input::get('edhv_id');
            //$tabladocumentacion->vehiculo_id = $id_vehiculo1;
            $editvehiculo->tipo_documento = Input::get('edtipo_documento');
            $editvehiculo->empresa_emite = Input::get('edempresa_emite');
            $editvehiculo->numero_documento = Input::get('ednumero_documento');
            $editvehiculo->fecha_expedicion = Input::get('edfecha_emision');
            $editvehiculo->fecha_vencimiento = Input::get('edfecha_vigencia');
            $editvehiculo->valor = Input::get('edvalor_doc');
            //$tabladocumentacion->save();

              if($editvehiculo->save()){

                  return Response::json([
                      'mensaje'=>true,
                      'respuesta'=>'Registro Actualizado correctamente!'
                  ]);

              }
          }*/
          //$tabladocumentacion = new hvdocumentacion;
          $editvehiculo = hvdocumentacion::find(Input::get('eddoc_id'));
          $editvehiculo->hv_vehiculo_id = Input::get('edhv_id');
          //$tabladocumentacion->vehiculo_id = $id_vehiculo1;
          $editvehiculo->tipo_documento = Input::get('edtipo_documento');
          $editvehiculo->empresa_emite = Input::get('edempresa_emite');
          $editvehiculo->numero_documento = Input::get('ednumero_documento');
          $editvehiculo->fecha_expedicion = Input::get('edfecha_emision');
          $editvehiculo->fecha_vencimiento = Input::get('edfecha_vigencia');
          $editvehiculo->valor = Input::get('edvalor_doc');
          //$tabladocumentacion->save();

            if($editvehiculo->save()){

                return Response::json([
                    'mensaje'=>true,
                    'respuesta'=>'Registro Actualizado correctamente!'
                ]);

            }else{
              return Response::json([
                  'mensaje'=>false,
                  'respuesta'=>'No se Encontro Registro!'
              ]);
            }

        }
        }
      }

      public function postEliminardoc(){
        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
              if(Request::ajax()){
                $id_doc = Input::get('id_doc');

                $doc_drop = hvdocumentacion::find($id_doc);
                $doc_drop->anulado = '1';
                if($doc_drop->save()){
                  return Response::json([
                      'mensaje'=>true,
                      'respuesta'=>'Registro Anulado!'
                  ]);
                }else{
                  return Response::json([
                      'mensaje'=>false,
                      'respuesta'=>'No se Encontro Registro!'
                  ]);
                }
            }
          }
      }

      public function postNewconductorhv(){
        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
              if(Request::ajax()){
          $newconductor = new hvconductores;
          $newconductor->hv_vehiculo_id = Input::get('hv_id');
          $newconductor->conductores_id = Input::get('conductorid');
          $newconductor->conductores_nombre = Input::get('conductornombre');
          $newconductor->fecha_inicial = Input::get('fecha_desde');
          $newconductor->fecha_final = Input::get('fecha_vigenciaco');

          if($newconductor->save()){
            return Response::json([
                'mensaje'=>true,
                'respuesta'=>'Registro guardado correctamente!'
            ]);
          }
        }
        }
      }

      public function postEditconductorhv(){
        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
              if(Request::ajax()){
          $editconductor = hvconductores::find(Input::get('cond_idhv'));

          $editconductor->conductores_id = Input::get('conductorid');
          $editconductor->conductores_nombre = Input::get('conductornombre');
          $editconductor->fecha_inicial = Input::get('fecha_desde');
          $editconductor->fecha_final = Input::get('fecha_vigenciaco');

          if($editconductor->save()){
            return Response::json([
                'mensaje'=>true,
                'respuesta'=>'Registro Modificado correctamente!'
            ]);
          }
        }
        }
      }

      public function postAnularconductorhv(){
        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
              if(Request::ajax()){
                $anularconductor = hvconductores::find(Input::get('cond_idhv'));

                $anularconductor->anulado = '1';

                if($anularconductor->save()){
                  return Response::json([
                      'mensaje'=>true,
                      'respuesta'=>'Registro Anulado correctamente!'
                  ]);
                }
              }
        }
      }

      public function postNewcomparendohv(){
        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
              if(Request::ajax()){
          $newcomparendo = new hvcomparendos;
          $newcomparendo->vehiculo_id = Input::get('id_vehiculo');
          $newcomparendo->hv_vehiculo_id = Input::get('hv_id');
          $newcomparendo->numero_comparendo = Input::get('numero_comparendo');
          $newcomparendo->causal = Input::get('causal');
          $newcomparendo->fecha_comparendo = Input::get('fecha_comparendo');
          $newcomparendo->detalle_comparendo = Input::get('detalle_comparendo');
          $newcomparendo->valor_comparendo = Input::get('valor_comparendo');
          $newcomparendo->numero_descargue = Input::get('numero_descargue');

          if($newcomparendo->save()){
            return Response::json([
                'mensaje'=>true,
                'respuesta'=>'Registro guardado correctamente!'
            ]);
          }
        }
        }
      }

      public function postEditcomparendohv(){
        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
              if(Request::ajax()){
          $editcomparendo = hvcomparendos::find(Input::get('id_comp'));

          $editcomparendo->numero_comparendo = Input::get('numero_comparendo');
          $editcomparendo->causal = Input::get('causal');
          $editcomparendo->fecha_comparendo = Input::get('fecha_comparendo');
          $editcomparendo->detalle_comparendo = Input::get('detalle_comparendo');
          $editcomparendo->valor_comparendo = Input::get('valor_comparendo');
          $editcomparendo->numero_descargue = Input::get('numero_descargue');

          if($editcomparendo->save()){
            return Response::json([
                'mensaje'=>true,
                'respuesta'=>'Registro Modificado correctamente!'
            ]);
          }
        }
        }

      }

      public function postAnularcomparendohv(){
        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
          if(Request::ajax()){
            $anularcomparedo = hvcomparendos::find(Input::get('id_compd'));
            $anularcomparedo->anulado = '1';

            if($anularcomparedo->save()){
              return Response::json([
                  'mensaje'=>true,
                  'respuesta'=>'Registro Anulado correctamente!'
              ]);
            }
          }

        }

      }

      public function postNewsucesohv(){
        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
              if(Request::ajax()){
          $newsuceso = new hvsuceso;
          $newsuceso->vehiculo_id = Input::get('id_vehiculo');
          $newsuceso->hv_vehiculo_id = Input::get('hv_id');
          $newsuceso->suceso = Input::get('tipo_suceso');
          $newsuceso->danos = Input::get('dano_check');
          $newsuceso->heridos = Input::get('heridos_check');
          $newsuceso->fallecidos = Input::get('fallecidos_check');
          $newsuceso->fecha_suceso = Input::get('fecha_suceso');
          $newsuceso->conductor_id = Input::get('conductorid');
          $newsuceso->conductor_nombre = Input::get('conductornombre');
          $newsuceso->centrosdecosto_id = Input::get('clienteid');
          $newsuceso->cliente_nombre = Input::get('clientenombre');
          $newsuceso->descripcion_suceso = Input::get('descripcion');

          if($newsuceso->save()){
            return Response::json([
                'mensaje'=>true,
                'respuesta'=>'Registro guardado correctamente!'
            ]);
          }

        }
        }
      }

      public function postEditsucesohv(){
        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
              if(Request::ajax()){

                $edithvsuceso = hvsuceso::find(Input::get('id_suces'));
                $edithvsuceso->suceso = Input::get('tipo_suceso');
                $edithvsuceso->danos = Input::get('dano_check');
                $edithvsuceso->heridos = Input::get('heridos_check');
                $edithvsuceso->fallecidos = Input::get('fallecidos_check');
                $edithvsuceso->fecha_suceso = Input::get('fecha_suceso');
                $edithvsuceso->conductor_id = Input::get('conductorid');
                $edithvsuceso->conductor_nombre = Input::get('conductornombre');
                $edithvsuceso->centrosdecosto_id = Input::get('clienteid');
                $edithvsuceso->cliente_nombre = Input::get('clientenombre');
                $edithvsuceso->descripcion_suceso = Input::get('descripcion');

                if($edithvsuceso->save()){
                  return Response::json([
                      'mensaje'=>true,
                      'respuesta'=>'Registro guardado correctamente!'
                  ]);
                }
              }
        }
      }

      public function postAnularsucesohv(){
        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
          if(Request::ajax()){
              $anularsuceso = hvsuceso::find(Input::get('id_suce'));
              $anularsuceso->anulado = '1';

              if($anularsuceso->save()){
                return Response::json([
                    'mensaje'=>true,
                    'respuesta'=>'Registro Anulado Correctamente!'
                ]);
              }
          }

        }

      }

      
    /**
     * Historial de mantenimientos
     */
    public function postNuevomantenimiento() {
        if (!Sentry::check()) {
            return Response::json([
                        'respuesta' => 'relogin'
            ]);
        } else {
            if (Request::ajax()) {
                $validaciones = [
                    'numero_orden' => 'required|numeric',
                    'tipo_mantenimiento' => 'required|select',
                    'fecha_realizacion' => 'required|date_format:Y-m-d|alpha_dash',
                    'nombre_taller' => 'required',
                    'nombre_tecnico' => 'required|sololetrasyespacio',
                    'kilometraje' => 'required|numeric',
                    'numero_factura' => 'required'

                ];

                $mensajes = [
                    'numero_orden.required' => 'El campo orden de compra/servicio es requerido',
                    'tipo_mantenimiento.required' => 'Seleccione un tipo de mantenimiento',
                    'fecha_realizacion.required' => 'El campo fecha realización es requerido',
                    'nombre_taller.required' => 'El campo nombre taller es requerido',
                    'nombre_tecnico.required' => 'El campo nombre técnico es requerido',
                    'kilometraje.numeric' => 'El campo kilometraje debe ser numérico',
                    'kilometraje.required' => 'El campo kilometraje es requerido',
                    'detalle_servicio.sololetrasyespacio' => 'El campo detalle del servicio debe tener sólo letras y espacio',
                    'numero_factura.required' => 'El campo número de factura es requerido'
                    
                ];

                $validador = Validator::make(Input::all(), $validaciones, $mensajes);

                if ($validador->fails()) {
                    return Response::json([
                                'mensaje' => false,
                                'errores' => $validador->errors()->getMessages()
                    ]);
                } else {
					
					if (Input::hasFile('fact_mnt_pdf')){
						$file1 = Input::file('fact_mnt_pdf');
						$name_pdf1 = str_replace(' ', '', $file1->getClientOriginalName());
						$name_pdf1 = Input::get('numero_factura').$name_pdf1;
						
						$ubicacion_servicios = 'biblioteca_imagenes/mantenimiento_fact/';
						$file1->move($ubicacion_servicios, $name_pdf1);
					}else{  $name_pdf1=  'na.pdf'; }

                    $tablamantenimientos = new hvmantenimientos;
                    $tablamantenimientos->hv_vehiculo_id = Input::get('hv_id');
                    $tablamantenimientos->vehiculo_id = Input::get('id_veh');
                    $tablamantenimientos->numero_orden = Input::get('numero_orden');
                    $tablamantenimientos->tipo_mantenimiento = Input::get('tipo_mantenimiento');
                    $tablamantenimientos->fecha_realizacion = Input::get('fecha_realizacion');
                    $tablamantenimientos->nombre_taller = Input::get('nombre_taller');
                    $tablamantenimientos->nombre_tecnico = Input::get('nombre_tecnico');
                    $tablamantenimientos->kilometraje = Input::get('kilometraje');
                    $tablamantenimientos->detalle_servicio = Input::get('detalle_servicio');
                    $tablamantenimientos->numero_factura = Input::get('numero_factura');
                    $tablamantenimientos->fecha_entrada = Input::get('fecha_entrada');
                    $tablamantenimientos->fecha_salida = Input::get('fecha_salida');
                    $tablamantenimientos->numero_accion = Input::get('numero_accion');
					$tablamantenimientos->factura_pdf = $name_pdf1;

                    if ($tablamantenimientos->save()) {

                        return Response::json([
                                    'mensaje' => true,
                                    'respuesta' => 'Registro guardado correctamente!'
                        ]);
                    } else {

                        return Response::json([
                                    'mensaje' => false,
                                    'respuesta' => 'No se pudo almacenar el manteniminiento!'
                        ]);
                    }
                }
            }
        }
    }

    public function postEditarmantenimiento() {
        if (!Sentry::check()) {
            return Response::json([
                        'respuesta' => 'relogin'
            ]);
        } else {
            if (Request::ajax()) {

                $tablamantenimientos = hvmantenimientos::find(Input::get('edmnto_id'));
                $tablamantenimientos->hv_vehiculo_id = Input::get('edhv_id');
                $tablamantenimientos->numero_orden = Input::get('ednumero_orden');
                $tablamantenimientos->tipo_mantenimiento = Input::get('edtipo_mantenimiento');
                $tablamantenimientos->fecha_realizacion = Input::get('edfecha_realizacion');
                $tablamantenimientos->nombre_taller = Input::get('ednombre_taller');
                $tablamantenimientos->nombre_tecnico = Input::get('ednombre_tecnico');
                $tablamantenimientos->kilometraje = Input::get('edkilometraje');
                $tablamantenimientos->detalle_servicio = Input::get('eddetalle_servicio');
                $tablamantenimientos->numero_factura = Input::get('ednumero_factura');
                $tablamantenimientos->fecha_entrada = Input::get('edfecha_entrada');
                $tablamantenimientos->fecha_salida = Input::get('edfecha_salida');
                $tablamantenimientos->numero_accion = Input::get('ednumero_accion');

                if ($tablamantenimientos->save()) {

                    return Response::json([
                                'mensaje' => true,
                                'respuesta' => 'Registro actualizado correctamente!'
                    ]);
                } else {
                    return Response::json([
                                'mensaje' => false,
                                'respuesta' => 'No se encontro registro!'
                    ]);
                }
            }
        }
    }
    
    public function postEliminarmantenimiento() {
        if (!Sentry::check()) {
            return Response::json([
                        'respuesta' => 'relogin'
            ]);
        } else {
            if (Request::ajax()) {
                $id_mnto = Input::get('id_mnto');

                $mnto_drop = hvmantenimientos::find($id_mnto);
                $mnto_drop->anulado = '1';
                if ($mnto_drop->save()) {
                    return Response::json([
                                'mensaje' => true,
                                'respuesta' => 'Registro anulado!'
                    ]);
                } else {
                    return Response::json([
                                'mensaje' => false,
                                'respuesta' => 'No se encontro registro!'
                    ]);
                }
            }
        }
    }

    /**
     * End - Historial de mantenimientos
     */
	 
	public function postAddkilometraje(){
        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
          if(Request::ajax()){
			  $km =  DB::table('mantenimiento_kilometraje')->where('kilometraje', Input::get('kilometraje'))->where('hv_vehiculo_id', Input::get('hv_id'))->first();
			  
			  if(count($km)>0){
				return Response::json(['mensaje'=>false]);  
			  }else{
				$addkilometraje = new Mtnkm;
				  $addkilometraje->kilometraje = Input::get('kilometraje');
				  $addkilometraje->fecha = Input::get('kilometraje_fecha');
				  $addkilometraje->hv_vehiculo_id = Input::get('hv_id');
				  $addkilometraje->vehiculo_id = Input::get('vehiculo_id');

				  if($addkilometraje->save()){
					return Response::json(['mensaje'=>true]);
				  }  
			  }
          }
        }
    }
	
	public function postAddoperacion(){
        if (!Sentry::check()){
            return Response::json([
                'respuesta'=>'relogin'
            ]);
        }else{
          if(Request::ajax()){
			  $op =  DB::table('mantenimiento_operacion')->where('item', Input::get('operacion'))->first();
			  
			  if(count($op)>0){
				return Response::json(['mensaje'=>false]);  
			  }else{
					$addoperacion = new Mtnop;
					$addoperacion->item = Input::get('operacion');
				  
				  if($addoperacion->save()){
					return Response::json(['mensaje'=>true]);
				  }  
			  }
          }
        }
    }
	
	public function postViewoperacion(){
        if(Request::ajax()){
				$km_select = Input::get('km_control');
				$hv_id = Input::get('hv_id');
			  $op =  DB::table('mantenimiento_operacion')->get();
			  $mantenimiento_op_km = DB::table('mantenimiento_operacion_kilometraje')
									->select('mantenimiento_operacion_kilometraje.id','mantenimiento_operacion_kilometraje.mantenimiento_operacion_id','mantenimiento_operacion.item', 'mantenimiento_kilometraje.kilometraje')
									->leftJoin('mantenimiento_kilometraje', 'mantenimiento_operacion_kilometraje.mantenimiento_kilometraje_id', '=', 'mantenimiento_kilometraje.id')
									->leftJoin('mantenimiento_operacion', 'mantenimiento_operacion_kilometraje.mantenimiento_operacion_id', '=', 'mantenimiento_operacion.id')
									->where('mantenimiento_operacion_kilometraje.hv_vehiculo_id',$hv_id)
									->where('mantenimiento_operacion_kilometraje.mantenimiento_kilometraje_id',$km_select)
									->whereNull('mantenimiento_operacion_kilometraje.anulado')
									->orderBy('mantenimiento_operacion_kilometraje.mantenimiento_operacion_id', 'asc')->get();
			if(!$op){
				return Response::json(['mensaje'=>false]);  
			}else{
					return Response::json([
						'mensaje'=>true,
						'respuesta'=>$op,
						'op_km'=>$mantenimiento_op_km
					]);
					  
			    } 
        }
        
    }
	
	public function postAddenlaze(){
		if(Request::ajax()){
			$addkm_control = Input::get('addkm_control');
			$addop_control = Input::get('addop_control');
			$addhv_id = Input::get('addhv_id');
			$addvehiculo_id = Input::get('addvehiculo_id');
			
			$new_enlaze = new Mtnopkm;
			$new_enlaze->mantenimiento_operacion_id = $addop_control;
			$new_enlaze->mantenimiento_kilometraje_id = $addkm_control;
			$new_enlaze->hv_vehiculo_id = $addhv_id;
			$new_enlaze->vehiculo_id = $addvehiculo_id;
			
			if($new_enlaze->save()){
				$op =  DB::table('mantenimiento_operacion')->get();
				$mantenimiento_op_km = DB::table('mantenimiento_operacion_kilometraje')
									->select('mantenimiento_operacion_kilometraje.id', 'mantenimiento_operacion_kilometraje.mantenimiento_operacion_id','mantenimiento_operacion.item', 'mantenimiento_kilometraje.kilometraje')
									->leftJoin('mantenimiento_kilometraje', 'mantenimiento_operacion_kilometraje.mantenimiento_kilometraje_id', '=', 'mantenimiento_kilometraje.id')
									->leftJoin('mantenimiento_operacion', 'mantenimiento_operacion_kilometraje.mantenimiento_operacion_id', '=', 'mantenimiento_operacion.id')
									->where('mantenimiento_operacion_kilometraje.hv_vehiculo_id',$addhv_id)
									->where('mantenimiento_operacion_kilometraje.mantenimiento_kilometraje_id',$addkm_control)
									->whereNull('mantenimiento_operacion_kilometraje.anulado')
									->orderBy('mantenimiento_operacion_kilometraje.mantenimiento_operacion_id', 'asc')->get();
				
				return Response::json([
					'mensaje'=>true, 
					'respuesta'=>$op,
					'op_km'=>$mantenimiento_op_km
					]);
			} 
		}
		else{
			return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');
		}
	}
	
	public function postAnularoperacionkm(){
		if (!Sentry::check()){
            return Response::json(['respuesta'=>'relogin']);
        }else{
			if(Request::ajax()){
				$id_enlace = Input::get('id_enlace');
				
				$b_enlace = Mtnopkm::find($id_enlace);
				$b_enlace->anulado = '1';
									
				if ($b_enlace->save()) {
					$op =  DB::table('mantenimiento_operacion')->get();
					$mantenimiento_op_km = DB::table('mantenimiento_operacion_kilometraje')
						->select('mantenimiento_operacion_kilometraje.id','mantenimiento_operacion_kilometraje.mantenimiento_operacion_id','mantenimiento_operacion.item', 'mantenimiento_kilometraje.kilometraje')
						->leftJoin('mantenimiento_kilometraje', 'mantenimiento_operacion_kilometraje.mantenimiento_kilometraje_id', '=', 'mantenimiento_kilometraje.id')
						->leftJoin('mantenimiento_operacion', 'mantenimiento_operacion_kilometraje.mantenimiento_operacion_id', '=', 'mantenimiento_operacion.id')
						->where('mantenimiento_operacion_kilometraje.hv_vehiculo_id',$b_enlace->hv_vehiculo_id)
						->where('mantenimiento_operacion_kilometraje.mantenimiento_kilometraje_id',$b_enlace->mantenimiento_kilometraje_id)
						->whereNull('mantenimiento_operacion_kilometraje.anulado')
						->orderBy('mantenimiento_operacion_kilometraje.mantenimiento_operacion_id', 'asc')->get();
                    return Response::json([
                                'mensaje' => true,
                                'respuesta' => $op,
								'op_km'=>$mantenimiento_op_km
								
                    ]);
                } else {
                    return Response::json([
                                'mensaje' => false,
                                'respuesta' => 'No se encontro Registro!'
                    ]);
                }
			}
		}
	}
	
	public function postSaverev(){
		if (!Sentry::check()){
            return Response::json(['respuesta'=>'relogin']);
        }else{
			if(Request::ajax()){
				$id_item = explode(',',Input::get('items_check'));
				for($i=0;$i<count($id_item);$i++){
					$revision = new Mtnorevision;
					$revision->hv_vehiculo_id = Input::get('hv_id');
					$revision->mantenimiento_kilometraje_id = Input::get('idkm_control');
					$revision->mantenimiento_operacion_id = $id_item[$i];
					$revision->fecha_mantenimiento = Input::get('fecha_revision');
					$revision->kilometraje_real = Input::get('km_recorido');
					$revision->observaciones = Input::get('observaciones');
					$revision->save();
				}
				return Response::json(['mensaje' => true ]);
			}
		}
	}
}
