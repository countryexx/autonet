<?php

class UsuariosController extends BaseController{

    /**
     * [getIndex Metodo para devolver la vista de usuarios]
     * @return [type] [description]
     */
    public function getIndex(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $userportal = Sentry::getUser()->usuario_portal;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (isset($permisos->administracion->usuarios->ver)){
            $ver = $permisos->administracion->usuarios->ver;
        }else{
            $ver = null;
        }

       // $ver = 'on';

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else if($ver!='on' ) {
            return View::make('admin.permisos');
        }else {

            $roles = DB::table('roles')->get();
            $usuarios = User::UsuarioWeb()->orderBy('username')->get();
            //$usuarios = DB::table('users')->orderBy('username')->get();

            return View::make('usuarios.listado', [
                'usuarios' => $usuarios,
                'roles' => $roles,
                'permisos' => $permisos,
                'userportal' => $userportal
            ]);
        }
    }

    /**
     * [postBanearusuario description]
     * @return [type] [description]
     */
    public function postBanearusuario(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if (Request::ajax()) {

                $id = Input::get('id');
                $option = intval(Input::get('option'));

                $throttle = Sentry::findThrottlerByUserId($id);



                // Ban
                if ($option===0){

                    $throttle->ban();
                    return Response::json([
                        'respuesta'=>true,
                        'mensaje'=>'Se ha realizado el bloqueo de este usuario!'
                    ]);

                }else if($option===1){

                    $throttle->unBan();
                    return Response::json([
                        'respuesta'=>true,
                        'mensaje'=>'Se ha realizado el desbloqueo de este usuario!'
                    ]);
                }
            }
        }
    }

    public function postCrearusuario(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

        if (Request::ajax()) {

          try{
              Config::set('cartalyst/sentry::users.login_attribute', 'username');

              $user_id = Input::get('');

              //ULTIMO REGISTRO DE USUARIO PARA HACER EL CALCULO DEL CONSECUTIVO
              $consulta = "select * from servicios where usuario_portal = 0 order by id desc limit 1";
              $ultimo = DB::select($consulta);

              $numero = intval(str_replace('AO','',$ultimo[0]->username))+1;

              $user = Sentry::createUser([
                  'username'     => 'AO'.$numero,
                  'password'  => Input::get('contrasena'),
                  'activated' => true,
                  'first_name'=>Input::get('nombres'),
                  'last_name'=>Input::get('apellidos'),
                  'tipo_usuario' => 1,
                  'id_rol' => Input::get('rol'),
                  'localidad' => Input::get('localidad')
              ]);

              if ($user) {
                return Response::json([
                  'respuesta'=>true
                ]);
              }

          }
          catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
          {
              echo 'Login field is required.';
          }
          catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
          {
              echo 'Password field is required.';
          }
          catch (Cartalyst\Sentry\Users\UserExistsException $e)
          {
              echo 'User with this login already exists.';
          }
          catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
          {
              echo 'Group was not found.';
          }
        }
      }
    }

    public function postCrearrol(){

        if (!Sentry::check())
        {
            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else {

            if (Request::ajax()){

                $validaciones = [
                    'nombre_rol'=>'required|sololetrasyespacio|unique:roles'
                ];

                $mensajes = [
                    'nombre_rol.required'=>'El nombre del rol es requerido',
                    'nombre_rol.unique'=>'El nombre no se puede repetir',
                    'nombre_rol.sololetrasyespacio'=>'El nombre del rol solo puede llevar letras y espacios'
                ];

                $validador = Validator::make(Input::all(), $validaciones, $mensajes);

                if ($validador->fails()){

                    return Response::json([
                        'respuesta'=>false,
                        'errores'=>$validador->errors()->getMessages(),
                        'all'=>Input::all()
                    ]);

                }else {

                    $array = ["portalusuarios" => [
                              "admin" => [
                                "ver" => Input::get('portalusuarios_admin_ver'),
                              ],
                                "qrusers" => [
                                "ver" => Input::get('portalusuarios_qrusers_ver'),
                              ],
                                "bancos" => [
                                "ver" => Input::get('portalusuarios_bancos_ver'),
                              ],
                              "ejecutivo" => [
                                "ver" => Input::get('portalusuarios_ejecutivo_ver'),
                              ],
                                "gestiondocumental" => [
                                "ver" => Input::get('portalusuarios_gestiondocumental_ver'),
                              ],
                            ],
                            "portalproveedores" => [
                              "documentacion" => [
                                "ver" => Input::get('portalproveedores_documentacion_ver'),
                                "creacion" => Input::get('portalproveedores_documentacion_creacion'),
                              ],
                                "cuentasdecobro" => [
                                "ver" => Input::get('portalproveedores_cuentasdecobro_ver'),
                                "creacion" => Input::get('portalproveedores_cuentasdecobro_creacion'),
                                "historial" => Input::get('portalproveedores_cuentasdecobro_historial'),
                              ],
                            ],
                            "escolar" => [
                              "gestion" => [
                                "ver" => Input::get('escolar_gestion_ver'),
                              ],
                            ],
                            "transporteescolar" => [
                              "gestionusuarios" => [
                                "ver" => Input::get('transporteescolar_gestionusuarios_ver'),
                                "creacion" => Input::get('transporteescolar_gestionusuarios_creacion'),
                              ],
                            ],
                            "transportes" => [
                              "plan_rodamiento" => [
                                "ver" => Input::get('transportes_plan_rodamiento_ver'),
                              ],
                            ],
                            "barranquilla" => [
                            "transportesbq" => [
                              "ver" => Input::get('barranquilla_transportesbq_ver'),
                            ],
                            "serviciosbq"=>[
                                "ver"=>Input::get('barranquilla_serviciosbq_ver'),
                                "creacion"=> Input::get('barranquilla_serviciosbq_creacion'),
                                "edicion"=> Input::get('barranquilla_serviciosbq_edicion'),
                                "eliminacion"=> Input::get('barranquilla_serviciosbq_eliminacion')
                            ],
                            "reconfirmacionbq" =>[
                                "ver"=>Input::get('barranquilla_reconfirmacionbq_ver'),
                                "reconfirmar"=> Input::get('barranquilla_reconfirmacionbq_reconfirmar'),
                                "alerta_reconfirmacion"=> Input::get('barranquilla_reconfirmacionbq_alerta_reconfirmacion')
                            ],
                            "novedadbq" =>[
                                "ver"=> Input::get('barranquilla_novedadbq_ver'),
                                "crear"=> Input::get('barranquilla_novedadbq_crear'),
                                "editar"=> Input::get('barranquilla_novedadbq_editar'),
                                "eliminar"=> Input::get('barranquilla_novedadbq_eliminar')
                            ],
                            "reportesbq"=> [
                                "ver"=> Input::get('barranquilla_reportesbq_ver'),
                                "crear"=> Input::get('barranquilla_reportesbq_crear')
                            ],
                            "encuestabq"=> [
                                "ver"=> Input::get('barranquilla_encuestabq_ver'),
                                "crear"=> Input::get('barranquilla_encuestabq_crear')
                            ],
                            "constanciabq"=> [
                                "crear"=> Input::get('barranquilla_constanciabq_crear'),
                                "edicion"=> Input::get('barranquilla_constanciabq_edicion')
                            ],
                            "poreliminarbq"=>[
                                "ver"=> Input::get('barranquilla_poreliminarbq_ver'),
                                "rechazar"=> Input::get('barranquilla_poreliminarbq_rechazar'),
                                "eliminar"=> Input::get('barranquilla_poreliminarbq_eliminar')
                            ],
                            "papeleradereciclajebq"=>[
                                "ver"=> Input::get('barranquilla_papeleradereciclajebq_ver')
                            ],
                            "poraceptarbq"=>[
                                  "ver"=> Input::get('barranquilla_poraceptarbq_ver'),
                                  "rechazar"=> Input::get('barranquilla_poraceptarbq_rechazar'),
                                  "eliminar"=> Input::get('barranquilla_poraceptarbq_eliminar')
                              ],
                              "ejecutivosbq"=>[
                                "ver"=> Input::get('barranquilla_ejecutivosbq_ver'),
                                "crear"=> Input::get('barranquilla_ejecutivosbq_crear'),
                              ],
                            "afiliadosexternosbq"=>[
                                  "ver"=> Input::get('barranquilla_afiliadosexternosbq_ver')
                              ]
                        ],
                        "bogota" => [
                            "transportes" => [
                              "ver" => Input::get('bogota_transportes_ver'),
                            ],
                            "servicios"=>[
                                "ver"=>Input::get('bogota_servicios_ver'),
                                "creacion"=> Input::get('bogota_servicios_creacion'),
                                "edicion"=> Input::get('bogota_servicios_edicion'),
                                "eliminacion"=> Input::get('bogota_servicios_eliminacion')
                            ],
                            "reconfirmacion" =>[
                                "ver"=>Input::get('bogota_reconfirmacion_ver'),
                                "reconfirmar"=> Input::get('bogota_reconfirmacion_reconfirmar'),
                                "alerta_reconfirmacion"=> Input::get('bogota_reconfirmacion_alerta_reconfirmacion')
                            ],
                            "novedad" =>[
                                "ver"=> Input::get('bogota_novedad_ver'),
                                "crear"=> Input::get('bogota_novedad_crear'),
                                "editar"=> Input::get('bogota_novedad_editar'),
                                "eliminar"=> Input::get('bogota_novedad_eliminar')
                            ],
                            "reportes"=> [
                                "ver"=> Input::get('bogota_reportes_ver'),
                                "crear"=> Input::get('bogota_reportes_crear')
                            ],
                            "encuesta"=> [
                                "ver"=> Input::get('bogota_encuesta_ver'),
                                "crear"=> Input::get('bogota_encuesta_crear')
                            ],
                            "constancia"=> [
                                "crear"=> Input::get('bogota_constancia_crear'),
                                "edicion"=> Input::get('bogota_constancia_edicion')
                            ],
                            "poreliminar"=>[
                                "ver"=> Input::get('bogota_poreliminar_ver'),
                                "rechazar"=> Input::get('bogota_poreliminar_rechazar'),
                                "eliminar"=> Input::get('bogota_poreliminar_eliminar')
                            ],
                            "papeleradereciclaje"=>[
                                "ver"=> Input::get('bogota_papeleradereciclaje_ver')
                            ],
                            "poraceptar"=>[
                                  "ver"=> Input::get('bogota_poraceptar_ver'),
                                  "rechazar"=> Input::get('bogota_poraceptar_rechazar'),
                                  "eliminar"=> Input::get('bogota_poraceptar_eliminar')
                              ],
                              "ejecutivos"=>[
                                "ver"=> Input::get('bogota_ejecutivos_ver'),
                                "crear"=> Input::get('bogota_ejecutivos_crear'),
                            ],
                            "afiliadosexternos"=>[
                                  "ver"=> Input::get('bogota_afiliadosexternos_ver')
                              ]
                        ],
                        "otrostransporte" => [
                            "otrostransporte" => [
                              "ver" => Input::get('otrostransporte_otrostransporte_ver'),
                            ]
                        ],

                        //
                        "transportes" => [
                            "plan_rodamiento" => [
                              "ver" => Input::get('transportes_plan_rodamiento_ver'),
                            ]
                        ],
                        "turismo"=>[
                            "otros"=>[
                                "ver"=> Input::get('turismo_otros_ver'),
                                "crear"=> Input::get('turismo_otros_crear')
                            ]
                        ],
                        "comercial"=>[
                            "cotizaciones"=>[
                                "ver"=>Input::get('comercial_cotizaciones_crear'),
                                "crear"=>Input::get('comercial_cotizaciones_ver')
                            ]
                        ],
                        "facturacion"=>[
                            "revision"=> [
                                "ver"=> Input::get('facturacion_revision_ver'),
                                "crear"=> Input::get('facturacion_revision_crear')
                            ],
                            "liquidacion"=> [
                                "ver"=> Input::get('facturacion_liquidacion_ver'),
                                "liquidar"=> Input::get('facturacion_liquidacion_liquidar'),
                                "generar_liquidacion"=> Input::get('facturacion_liquidacion_generar_liquidacion')
                            ],
                            "autorizar"=> [
                                "ver"=> Input::get('facturacion_autorizar_ver'),
                                "autorizar"=> Input::get('facturacion_autorizar_autorizar'),
                                "anular"=> Input::get('facturacion_autorizar_anular'),
                                "generar_factura"=> Input::get('facturacion_autorizar_generar_factura')
                            ],
                            "ordenes_de_facturacion"=> [
                                "ver"=> Input::get('facturacion_ordenes_de_facturacion_ver'),
                                "anular"=> Input::get('facturacion_ordenes_de_facturacion_anular'),
                                "ingreso"=> Input::get('facturacion_ordenes_de_facturacion_ingreso'),
                                "ingreso_imagenes"=> Input::get('facturacion_ordenes_de_facturacion_ingreso_imagenes'),
                                "revision"=> Input::get('facturacion_ordenes_de_facturacion_revision')
                            ]
                        ],
                        "contabilidad"=>[
                            "pago_proveedores"=>[
                                "ver"=> Input::get('contabilidad_pago_proveedores_ver'),
                                "generar_orden_pago" => Input::get('contabilidad_pago_proveedores_generar_orden_pago')
                            ],
                            "factura_proveedores"=>[
                                "ver"=>Input::get('contabilidad_factura_proveedores_ver'),
                                "cerrar_pago"=> Input::get('contabilidad_factura_proveedores_cerrar_pago'),
                                "revisar"=>Input::get('contabilidad_factura_proveedores_revisar'),
                                "anular"=>Input::get('contabilidad_factura_proveedores_anular')
                            ],
                            "listado_de_pagos_preparar"=>[
                                "ver"=> Input::get('contabilidad_listado_de_pagos_preparar_ver'),
                                "preparar"=>Input::get('contabilidad_listado_de_pagos_preparar_preparar')
                            ],
                            "listado_de_pagos_auditar"=>[
                                "ver"=> Input::get('contabilidad_listado_de_pagos_auditar_ver'),
                                "auditar"=>Input::get('contabilidad_listado_de_pagos_auditar_auditar')
                            ],
                            "listado_de_pagos_autorizar"=>[
                                "ver"=>Input::get('contabilidad_listado_de_pagos_autorizar_ver'),
                                "autorizar"=>Input::get('contabilidad_listado_de_pagos_autorizar_autorizar')
                            ],
                            "listado_de_pagados"=>[
                                "ver"=>Input::get('contabilidad_listado_de_pagados_ver'),
                            ],
                            "comisiones"=>[
                                "ver"=>Input::get('contabilidad_comisiones_ver'),
                                "generar_pago"=>Input::get('contabilidad_comisiones_generar_pago')
                            ],
                            "pago_de_comisiones"=>[
                                "ver"=>Input::get('contabilidad_pago_de_comisiones_ver'),
                                "revisar"=>Input::get('contabilidad_pago_de_comisiones_revisar')
                            ],
                            "pagos_por_autorizar_comision"=>[
                                "ver"=> Input::get('contabilidad_pagos_por_autorizar_comision_ver'),
                                "autorizar"=> Input::get('contabilidad_pagos_por_autorizar_comision_autorizar'),
                            ],
                            "pagos_por_pagar_comision"=>[
                                "ver"=>Input::get('contabilidad_pagos_por_pagar_comision_ver')
                            ],
                        ],
                        "turismo"=>[
                            "otros"=>[
                                "ver"=>Input::get('turismo_otros_ver'),
                                "crear"=>Input::get('turismo_otros_crear')
                            ]
                        ],
                        "comercial"=>[
                            "cotizaciones"=>[
                                "ver"=>Input::get('comercial_cotizaciones_ver'),
                                "crear"=>Input::get('comercial_cotizaciones_crear'),
                                "editar"=>Input::get('comercial_cotizaciones_editar')
                            ]
                        ],
                        "administrativo"=>[
                            "centros_de_costo"=>[
                                "ver" => Input::get('administrativo_centros_de_costo_ver'),
                                "crear" => Input::get('administrativo_centros_de_costo_crear'),
                                "editar" => Input::get('administrativo_centros_de_costo_editar'),
                                "bloquear_desbloquear" => Input::get('administrativo_centros_de_costo_bloquear_desbloquear'),
                            ],
                            "proveedores"=>[
                                "ver" => Input::get('administrativo_proveedores_ver'),
                                "crear" => Input::get('administrativo_proveedores_crear'),
                                "editar" => Input::get('administrativo_proveedores_editar'),
                                "bloquear_desbloquear" => Input::get('administrativo_proveedores_bloquear_desbloquear'),
                                "listado_vehiculos" => Input::get('administrativo_proveedores_listado_vehiculos'),
                                "listado_conductores" => Input::get('administrativo_proveedores_listado_conductores'),
                                "bloqueo_conductores" => Input::get('administrativo_proveedores_bloqueo_conductores'),
                                "bloqueo_vehiculos" => Input::get('administrativo_proveedores_bloqueo_vehiculos'),
                            ],
                            "administracion_proveedores"=>[
                                "ver"=> Input::get('administrativo_administracion_proveedores_ver'),
                                "crear"=> Input::get('administrativo_administracion_proveedores_crear')
                            ],
                            "contratos"=>[
                                "ver" => Input::get('administrativo_contratos_ver'),
                                "crear" => Input::get('administrativo_contratos_crear'),
                                "editar" => Input::get('administrativo_contratos_editar'),
                                "renovar" => Input::get('administrativo_contratos_renovar')
                            ],
                            "seguridad_social"=>[
                                "ver"=>Input::get('administrativo_seguridad_social_ver'),
                                "crear"=>Input::get('administrativo_seguridad_social_crear')
                            ],
                            "fuec"=>[
                                "ver"=> Input::get('administrativo_fuec_ver'),
                                "crear"=> Input::get('administrativo_fuec_crear'),
                                "editar"=> Input::get('administrativo_fuec_editar'),
                                "descargar"=> Input::get('administrativo_fuec_descargar'),
                                "rutas_fuec"=>Input::get('administrativo_fuec_rutas_fuec')
                            ],
                            "rutas_y_tarifas"=>[
                                "ver"=> Input::get('administrativo_rutas_y_tarifas_ver'),
                                "editar"=>Input::get('administrativo_rutas_y_tarifas_editar')
                            ],
                            "ciudades"=>[
                                "ver"=>Input::get('administrativo_ciudades_ver'),
                                "crear"=>Input::get('administrativo_ciudades_crear'),
                                "editar"=>Input::get('administrativo_ciudades_editar')
                            ]
                        ],
                        "talentohumano"=>[
                          "empleados"=> [
                            "ver"=> Input::get('talentohumano_empleados_ver'),
                            "crear"=> Input::get('talentohumano_empleados_crear'),
                            "editar"=> Input::get('talentohumano_empleados_editar'),
                            "retirar"=> Input::get('talentohumano_empleados_retirar')
                          ],
                          "prestamos"=> [
                            "ver"=> Input::get('talentohumano_prestamos_ver'),
                            "crear"=> Input::get('talentohumano_prestamos_crear'),
                            "gestionar"=> Input::get('talentohumano_prestamos_gestionar')
                          ],
                          "vacaciones"=> [
                            "ver"=> Input::get('talentohumano_vacaciones_ver'),
                            "crear"=> Input::get('talentohumano_vacaciones_crear')
                          ],
                          "control_ingreso"=> [
                            "ver"=> Input::get('talentohumano_control_ingreso_ver'),
                            "crear"=> Input::get('talentohumano_control_ingreso_crear'),
                            "guardar_personal"=> Input::get('talentohumano_control_ingreso_guardar_personal'),
                            "historial"=> Input::get('talentohumano_control_ingreso_historial')
                          ],
                          "control_ingreso_bog"=> [
                            "ver"=> Input::get('talentohumano_control_ingreso_bog_ver'),
                            "crear"=> Input::get('talentohumano_control_ingreso_bog_crear'),
                            "guardar_personal_bog"=> Input::get('talentohumano_control_ingreso_bog_guardar_personal_bog'),
                            "historial"=> Input::get('talentohumano_control_ingreso_bog_historial')
                          ]
                        ],
                        "gestion_integral"=>[
                          "indicadores"=>[
                            "ver"=> Input::get('gestion_integral_indicadores_ver'),
                            "crear"=> Input::get('gestion_integral_indicadores_crear'),
                            "editar"=> Input::get('gestion_integral_indicadores_editar'),
                            "eliminar"=> Input::get('gestion_integral_indicadores_eliminar')
                          ]
                        ],
                        "administracion"=>[
                            "usuarios" =>[
                                "ver"=> Input::get('administracion_usuarios_ver')
                            ],
                            "clientes_particulares" => [
                              "ver" => Input::get('administracion_clientes_particulares_ver')
                            ],
                            "clientes_empresariales" => [
                              "ver" => Input::get('administracion_clientes_empresariales_ver')
                            ],
                            "importar_pasajeros" => [
                              "ver" => Input::get('administracion_importar_pasajeros_ver')
                            ],
                            "listado_pasajeros" => [
                              "ver" => Input::get('administracion_listado_pasajeros_ver')
                            ]
                        ],
                        "mobile"=>[
                            "servicios_programados_sintarifa" =>[
                                "ver"=> Input::get('mobile_servicios_programados_sintarifa_ver')
                            ],
                            "servicios_programados_tarifado" =>[
                                "ver"=> Input::get('mobile_servicios_programados_tarifado_ver')
                            ],
                            "servicios_programados_pagados" =>[
                                "ver"=> Input::get('mobile_servicios_programados_pagados_ver')
                            ],
                            "servicios_programados_facturacion" =>[
                                "ver"=> Input::get('mobile_servicios_programados_facturacion_ver')
                            ],
                            "servicios_programados" =>[
                                "ver"=> Input::get('mobile_servicios_programados_ver')
                            ]
                        ]
                    ];

                    $rol = new Rol();
                    $rol->nombre_rol = strtoupper(Input::get('nombre_rol'));
                    $rol->permisos = json_encode($array);
                    $rol->creado_por = Sentry::getUser()->id;

                    if ($rol->save()){

                        return Response::json([
                            'respuesta'=>true,
                            'arrayRoles'=>json_encode($array),
                            'all'=>Input::all()
                        ]);

                    }
                }
            }
        }
    }

    public function postVerroles(){

        if (!Sentry::check())
        {
            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else {

            if (Request::ajax()) {

                $roles = DB::table('roles')
                    ->select('roles.id','roles.nombre_rol','users.first_name','users.last_name','roles.created_at')
                    ->leftJoin('users','roles.creado_por','=','users.id')
                    ->get();

                if ($roles!=null){

                    return Response::json([
                        'respuesta'=>true,
                        'roles'=>$roles
                    ]);

                }
            }
        }
    }

    public function postEditarrol(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if (Request::ajax()) {

                $array = ["portalusuarios" => [
                              "admin" => [
                                "ver" => Input::get('portalusuarios_admin_ver'),
                              ],
                              "qrusers" => [
                                "ver" => Input::get('portalusuarios_qrusers_ver'),
                              ],
                              "bancos" => [
                                "ver" => Input::get('portalusuarios_bancos_ver'),
                              ],
                              "ejecutivo" => [
                                "ver" => Input::get('portalusuarios_ejecutivo_ver'),
                              ],
                              "gestiondocumental" => [
                                "ver" => Input::get('portalusuarios_gestiondocumental_ver'),
                              ],
                            ],
                            "portalproveedores" => [
                              "documentacion" => [
                                "ver" => Input::get('portalproveedores_documentacion_ver'),
                                "creacion" => Input::get('portalproveedores_documentacion_creacion'),
                              ],
                              "cuentasdecobro" => [
                                "ver" => Input::get('portalproveedores_cuentasdecobro_ver'),
                                "creacion" => Input::get('portalproveedores_cuentasdecobro_creacion'),
                                "historial" => Input::get('portalproveedores_cuentasdecobro_historial'),
                              ]
                            ],
                            "escolar" => [
                              "gestion" => [
                                "ver" => Input::get('escolar_gestion_ver'),
                              ],
                            ],
                            "transporteescolar" => [
                              "gestionusuarios" => [
                                "ver" => Input::get('transporteescolar_gestionusuarios_ver'),
                                "creacion" => Input::get('transporteescolar_gestionusuarios_creacion'),
                              ],
                            ],
                            "barranquilla" => [
                                    "transportesbq" => [
                                      "ver" => Input::get('barranquilla_transportesbq_ver'),
                            ],
                            "serviciosbq"=>[
                                "ver"=>Input::get('barranquilla_serviciosbq_ver'),
                                "creacion"=> Input::get('barranquilla_serviciosbq_creacion'),
                                "edicion"=> Input::get('barranquilla_serviciosbq_edicion'),
                                "eliminacion"=> Input::get('barranquilla_serviciosbq_eliminacion')
                            ],
                            "reconfirmacionbq" =>[
                                "ver"=>Input::get('barranquilla_reconfirmacionbq_ver'),
                                "reconfirmar"=> Input::get('barranquilla_reconfirmacionbq_reconfirmar'),
                                "alerta_reconfirmacion"=> Input::get('barranquilla_reconfirmacionbq_alerta_reconfirmacion')
                            ],
                            "novedadbq" =>[
                                "ver"=> Input::get('barranquilla_novedadbq_ver'),
                                "crear"=> Input::get('barranquilla_novedadbq_crear'),
                                "editar"=> Input::get('barranquilla_novedadbq_editar'),
                                "eliminar"=> Input::get('barranquilla_novedadbq_eliminar')
                            ],
                            "reportesbq"=> [
                                "ver"=> Input::get('barranquilla_reportesbq_ver'),
                                "crear"=> Input::get('barranquilla_reportesbq_crear')
                            ],
                            "encuestabq"=> [
                                "ver"=> Input::get('barranquilla_encuestabq_ver'),
                                "crear"=> Input::get('barranquilla_encuestabq_crear')
                            ],
                            "constanciabq"=> [
                                "crear"=> Input::get('barranquilla_constanciabq_crear'),
                                "edicion"=> Input::get('barranquilla_constanciabq_edicion')
                            ],
                            "poreliminarbq"=>[
                                "ver"=> Input::get('barranquilla_poreliminarbq_ver'),
                                "rechazar"=> Input::get('barranquilla_poreliminarbq_rechazar'),
                                "eliminar"=> Input::get('barranquilla_poreliminarbq_eliminar')
                            ],
                            "papeleradereciclajebq"=>[
                                "ver"=> Input::get('barranquilla_papeleradereciclajebq_ver')
                            ],
                            "poraceptarbq"=>[
                                  "ver"=> Input::get('barranquilla_poraceptarbq_ver'),
                                  "rechazar"=> Input::get('barranquilla_poraceptarbq_rechazar'),
                                  "eliminar"=> Input::get('barranquilla_poraceptarbq_eliminar')
                              ],
                              "ejecutivosbq"=>[
                                "ver"=> Input::get('barranquilla_ejecutivosbq_ver'),
                                "crear"=> Input::get('barranquilla_ejecutivosbq_crear'),
                              ],
                            "afiliadosexternosbq"=>[
                                  "ver"=> Input::get('barranquilla_afiliadosexternosbq_ver')
                              ]
                        ],
                        "bogota" => [
                            "transportes" => [
                              "ver" => Input::get('bogota_transportes_ver'),
                            ],
                            "servicios"=>[
                                "ver"=>Input::get('bogota_servicios_ver'),
                                "creacion"=> Input::get('bogota_servicios_creacion'),
                                "edicion"=> Input::get('bogota_servicios_edicion'),
                                "eliminacion"=> Input::get('bogota_servicios_eliminacion')
                            ],
                            "reconfirmacion" =>[
                                "ver"=>Input::get('bogota_reconfirmacion_ver'),
                                "reconfirmar"=> Input::get('bogota_reconfirmacion_reconfirmar'),
                                "alerta_reconfirmacion"=> Input::get('bogota_reconfirmacion_alerta_reconfirmacion')
                            ],
                            "novedad" =>[
                                "ver"=> Input::get('bogota_novedad_ver'),
                                "crear"=> Input::get('bogota_novedad_crear'),
                                "editar"=> Input::get('bogota_novedad_editar'),
                                "eliminar"=> Input::get('bogota_novedad_eliminar')
                            ],
                            "reportes"=> [
                                "ver"=> Input::get('bogota_reportes_ver'),
                                "crear"=> Input::get('bogota_reportes_crear')
                            ],
                            "encuesta"=> [
                                "ver"=> Input::get('bogota_encuesta_ver'),
                                "crear"=> Input::get('bogota_encuesta_crear')
                            ],
                            "constancia"=> [
                                "crear"=> Input::get('bogota_constancia_crear'),
                                "edicion"=> Input::get('bogota_constancia_edicion')
                            ],
                            "poreliminar"=>[
                                "ver"=> Input::get('bogota_poreliminar_ver'),
                                "rechazar"=> Input::get('bogota_poreliminar_rechazar'),
                                "eliminar"=> Input::get('bogota_poreliminar_eliminar')
                            ],
                            "papeleradereciclaje"=>[
                                "ver"=> Input::get('bogota_papeleradereciclaje_ver')
                            ],
                            "poraceptar"=>[
                                  "ver"=> Input::get('bogota_poraceptar_ver'),
                                  "rechazar"=> Input::get('bogota_poraceptar_rechazar'),
                                  "eliminar"=> Input::get('bogota_poraceptar_eliminar')
                              ],
                              "ejecutivos"=>[
                                "ver"=> Input::get('bogota_ejecutivos_ver'),
                                "crear"=> Input::get('bogota_ejecutivos_crear'),
                            ],
                            "afiliadosexternos"=>[
                                  "ver"=> Input::get('bogota_afiliadosexternos_ver')
                              ]
                        ],
                        "otrostransporte" => [
                            "otrostransporte" => [
                              "ver" => Input::get('otrostransporte_otrostransporte_ver'),
                            ]
                        ],

                    "transportes" =>[
                        "plan_rodamiento" => [
                          "ver" => Input::get('transportes_plan_rodamiento_ver')
                        ],
                    ],
                    "turismo"=>[
                        "otros"=>[
                            "ver"=> Input::get('turismo_otros_ver'),
                            "crear"=> Input::get('turismo_otros_crear')
                        ]
                    ],
                    "facturacion"=>[
                        "revision"=> [
                            "ver"=> Input::get('facturacion_revision_ver'),
                            "crear"=> Input::get('facturacion_revision_crear')
                        ],
                        "liquidacion"=> [
                            "ver"=> Input::get('facturacion_liquidacion_ver'),
                            "liquidar"=> Input::get('facturacion_liquidacion_liquidar'),
                            "generar_liquidacion"=> Input::get('facturacion_liquidacion_generar_liquidacion')
                        ],
                        "autorizar"=> [
                            "ver"=> Input::get('facturacion_autorizar_ver'),
                            "autorizar"=> Input::get('facturacion_autorizar_autorizar'),
                            "anular"=> Input::get('facturacion_autorizar_anular'),
                            "generar_factura"=> Input::get('facturacion_autorizar_generar_factura')
                        ],
                        "ordenes_de_facturacion"=> [
                            "ver"=> Input::get('facturacion_ordenes_de_facturacion_ver'),
                            "anular"=> Input::get('facturacion_ordenes_de_facturacion_anular'),
                            "ingreso"=> Input::get('facturacion_ordenes_de_facturacion_ingreso'),
                            "ingreso_imagenes"=> Input::get('facturacion_ordenes_de_facturacion_ingreso_imagenes'),
                            "revision"=> Input::get('facturacion_ordenes_de_facturacion_revision')
                        ]
                    ],
                    "contabilidad"=>[
                        "pago_proveedores"=>[
                            "ver"=> Input::get('contabilidad_pago_proveedores_ver'),
                            "generar_orden_pago" => Input::get('contabilidad_pago_proveedores_generar_orden_pago')
                        ],
                        "factura_proveedores"=>[
                            "ver"=>Input::get('contabilidad_factura_proveedores_ver'),
                            "cerrar_pago"=> Input::get('contabilidad_factura_proveedores_cerrar_pago'),
                            "revisar"=>Input::get('contabilidad_factura_proveedores_revisar'),
                            "anular"=>Input::get('contabilidad_factura_proveedores_anular')
                        ],
                        "listado_de_pagos_preparar"=>[
                            "ver"=> Input::get('contabilidad_listado_de_pagos_preparar_ver'),
                            "preparar"=>Input::get('contabilidad_listado_de_pagos_preparar_preparar')
                        ],
                        "listado_de_pagos_auditar"=>[
                            "ver"=> Input::get('contabilidad_listado_de_pagos_auditar_ver'),
                            "auditar"=>Input::get('contabilidad_listado_de_pagos_auditar_auditar')
                        ],
                        "listado_de_pagos_autorizar"=>[
                            "ver"=>Input::get('contabilidad_listado_de_pagos_autorizar_ver'),
                            "autorizar"=>Input::get('contabilidad_listado_de_pagos_autorizar_autorizar')
                        ],
                        "listado_de_pagados"=>[
                            "ver"=>Input::get('contabilidad_listado_de_pagados_ver'),
                        ],
                        "comisiones"=>[
                            "ver"=>Input::get('contabilidad_comisiones_ver'),
                            "generar_pago"=>Input::get('contabilidad_comisiones_generar_pago')
                        ],
                        "pago_de_comisiones"=>[
                            "ver"=>Input::get('contabilidad_pago_de_comisiones_ver'),
                            "revisar"=>Input::get('contabilidad_pago_de_comisiones_revisar')
                        ],
                        "pagos_por_autorizar_comision"=>[
                            "ver"=> Input::get('contabilidad_pagos_por_autorizar_comision_ver'),
                            "autorizar"=> Input::get('contabilidad_pagos_por_autorizar_comision_autorizar'),
                        ],
                        "pagos_por_pagar_comision"=>[
                            "ver"=>Input::get('contabilidad_pagos_por_pagar_comision_ver')
                        ],
                    ],
                    "comercial"=>[
                        "cotizaciones"=>[
                            "ver"=>Input::get('comercial_cotizaciones_ver'),
                            "crear"=>Input::get('comercial_cotizaciones_crear'),
                            "editar"=>Input::get('comercial_cotizaciones_editar')
                        ]
                    ],
                    "administrativo"=>[
                        "centros_de_costo"=>[
                            "ver"=>Input::get('administrativo_centros_de_costo_ver'),
                            "crear"=>Input::get('administrativo_centros_de_costo_crear'),
                            "editar"=>Input::get('administrativo_centros_de_costo_editar'),
                            "bloquear_desbloquear"=>Input::get('administrativo_centros_de_costo_bloquear_desbloquear'),
                        ],
                        "proveedores"=>[
                            "ver"=>Input::get('administrativo_proveedores_ver'),
                            "crear"=>Input::get('administrativo_proveedores_crear'),
                            "editar"=>Input::get('administrativo_proveedores_editar'),
                            "bloquear_desbloquear"=>Input::get('administrativo_proveedores_bloquear_desbloquear'),
                            "listado_vehiculos"=>Input::get('administrativo_proveedores_listado_vehiculos'),
                            "listado_conductores"=>Input::get('administrativo_proveedores_listado_conductores'),
                            "bloqueo_conductores" => Input::get('administrativo_proveedores_bloqueo_conductores'),
                            "bloqueo_vehiculos" => Input::get('administrativo_proveedores_bloqueo_vehiculos'),
                        ],
                        "administracion_proveedores"=>[
                            "ver"=> Input::get('administrativo_administracion_proveedores_ver'),
                            "crear"=> Input::get('administrativo_administracion_proveedores_crear')
                        ],
                        "contratos"=>[
                            "ver" => Input::get('administrativo_contratos_ver'),
                            "crear" => Input::get('administrativo_contratos_crear'),
                            "editar" => Input::get('administrativo_contratos_editar'),
                            "renovar" => Input::get('administrativo_contratos_renovar')
                        ],
                        "seguridad_social"=>[
                            "ver"=>Input::get('administrativo_seguridad_social_ver'),
                            "crear"=>Input::get('administrativo_seguridad_social_crear')
                        ],
                        "fuec"=>[
                            "ver"=> Input::get('administrativo_fuec_ver'),
                            "crear"=> Input::get('administrativo_fuec_crear'),
                            "editar"=> Input::get('administrativo_fuec_editar'),
                            "descargar"=> Input::get('administrativo_fuec_descargar'),
                            "rutas_fuec"=>Input::get('administrativo_fuec_rutas_fuec')
                        ],
                        "rutas_y_tarifas"=>[
                            "ver"=> Input::get('administrativo_rutas_y_tarifas_ver'),
                            "editar"=>Input::get('administrativo_rutas_y_tarifas_editar')
                        ],
                        "ciudades"=>[
                            "ver"=>Input::get('administrativo_ciudades_ver'),
                            "crear"=>Input::get('administrativo_ciudades_crear'),
                            "editar"=>Input::get('administrativo_ciudades_editar')
                        ]
                    ],
                    "talentohumano"=>[
                          "empleados"=> [
                            "ver"=> Input::get('talentohumano_empleados_ver'),
                            "crear"=> Input::get('talentohumano_empleados_crear'),
                            "editar"=> Input::get('talentohumano_empleados_editar'),
                            "retirar"=> Input::get('talentohumano_empleados_retirar')
                          ],
                          "prestamos"=> [
                            "ver"=> Input::get('talentohumano_prestamos_ver'),
                            "crear"=> Input::get('talentohumano_prestamos_crear'),
                            "gestionar"=> Input::get('talentohumano_prestamos_gestionar')
                          ],
                          "vacaciones"=> [
                            "ver"=> Input::get('talentohumano_vacaciones_ver'),
                            "crear"=> Input::get('talentohumano_vacaciones_crear')
                          ],
                          "control_ingreso"=> [
                            "ver"=> Input::get('talentohumano_control_ingreso_ver'),
                            "crear"=> Input::get('talentohumano_control_ingreso_crear'),
                            "guardar_personal"=> Input::get('talentohumano_control_ingreso_guardar_personal'),
                            "historial"=> Input::get('talentohumano_control_ingreso_historial')
                          ],
                          "control_ingreso_bog"=> [
                            "ver"=> Input::get('talentohumano_control_ingreso_bog_ver'),
                            "crear"=> Input::get('talentohumano_control_ingreso_bog_crear'),
                            "guardar_personal_bog"=> Input::get('talentohumano_control_ingreso_bog_guardar_personal_bog'),
                            "historial"=> Input::get('talentohumano_control_ingreso_bog_historial')
                          ]
                        ],
                        "gestion_integral"=>[
                          "indicadores"=>[
                            "ver"=> Input::get('gestion_integral_indicadores_ver'),
                            "crear"=> Input::get('gestion_integral_indicadores_crear'),
                            "editar"=> Input::get('gestion_integral_indicadores_editar'),
                            "eliminar"=> Input::get('gestion_integral_indicadores_eliminar')
                          ]
                        ],
                    "administracion"=>[
                        "usuarios" =>[
                            "ver"=> Input::get('administracion_usuarios_ver')
                        ],
                        "clientes_particulares" => [
                          "ver" => Input::get('administracion_clientes_particulares_ver')
                        ],
                        "clientes_empresariales" => [
                          "ver" => Input::get('administracion_clientes_empresariales_ver')
                        ],
                        "importar_pasajeros" => [
                            "ver" => Input::get('administracion_importar_pasajeros_ver')
                        ],
                        "listado_pasajeros" => [
                          "ver" => Input::get('administracion_listado_pasajeros_ver')
                        ]
                    ],
                    "mobile"=>[
                        "servicios_programados_sintarifa" =>[
                            "ver"=> Input::get('mobile_servicios_programados_sintarifa_ver')
                        ],
                        "servicios_programados_tarifado" =>[
                            "ver"=> Input::get('mobile_servicios_programados_tarifado_ver')
                        ],
                        "servicios_programados_pagados" =>[
                            "ver"=> Input::get('mobile_servicios_programados_pagados_ver')
                        ],
                        "servicios_programados_facturacion" =>[
                            "ver"=> Input::get('mobile_servicios_programados_facturacion_ver')
                        ],
                        "servicios_programados" =>[
                            "ver"=> Input::get('mobile_servicios_programados_ver')
                        ]
                    ]
                ];

                $rol = Rol::find(Input::get('id'));
                $rol->nombre_rol = strtoupper(Input::get('nombre_rol'));
                $rol->permisos = json_encode($array);

                if ($rol->save()){

                    return Response::json([
                        'respuesta'=>true
                    ]);
                }
            }
        }
    }

    public function postVerrolusuario(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if(Request::ajax()){

                $user = DB::table('users')
                    ->select('users.id','roles.id as id_rol','roles.nombre_rol')
                    ->leftJoin('roles','users.id_rol','=','roles.id')
                    ->where('users.id',Input::get('id'))
                    ->first();
                if ($user){
                    return Response::json([
                        'respuesta'=>true,
                        'user'=>$user
                    ]);
                }else {
                    return Response::json([
                        'respuesta'=>false,
                        'user'=>$user
                    ]);
                }

            }

        }
    }

    public function postCambiarrolusuario(){

        if (!Sentry::check()){

            return Response::json([
                'respuesta'=>'relogin'
            ]);

        }else {

            if (Request::ajax()) {

                $user = User::find(Input::get('id'));
                $user->id_rol = Input::get('rol');

                if ($user->save()){
                    return Response::json([
                        'respuesta'=>true
                    ],200);
                }

            }
        }
    }

    public function postPermisosrol(){

        if (!Sentry::check())
        {
            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else {

            if (Request::ajax()) {

                $id = Input::get('id');
                $rol = Rol::find($id);

                return Response::json([
                    'respuesta'=>true,
                    'permisos'=>$rol->permisos,
                    'nombre_rol'=>$rol->nombre_rol
                ]);

            }

        }
    }

    public function getConfiguracion(){

        if (Sentry::check()) {
          $id_rol = Sentry::getUser()->id_rol;
          $idusuario = Sentry::getUser()->id;
          $permisos = DB::table('roles')->where('id',$id_rol)->pluck('permisos');
          $permisos = json_decode($permisos);
        }else{
          $id_rol = null;
          $permisos = null;
          $permisos = null;
        }

        if (!Sentry::check()){

            return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

        }else {

            $firma_correo = FirmaCorreo::where('user_id', Sentry::getUser()->id)->first();

            return View::make('usuarios.configuracion', [
              'firma_correo' => $firma_correo,
              'idusuario' => $idusuario,
              'permisos' => $permisos
            ]);

        }
    }

    public function postCambiarcontrasena(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

        if (Request::ajax()) {

          try {

            $contrasena = Input::get('contrasena');
            $id = Input::get('id');
            $user = Sentry::findUserById($id);

            $resetCode = $user->getResetPasswordCode();

            if ($user->checkResetPasswordCode($resetCode)){

                if ($user->attemptResetPassword($resetCode, $contrasena)){
                    return Response::json([
                      'respuesta'=>true
                    ]);
                }
            }

          } catch (Exception $e) {
              return Response::json([
                'e'=>$e
              ]);
          }
        }
      }

    }

    public function postCambiarcontrasenaapp(){

      if (!Sentry::check()){

          return Response::json([
              'respuesta'=>'relogin'
          ]);

      }else{

        if (Request::ajax()) {

          $user_id = Input::get('id');
          $password = Input::get('password');

          $user = User::find($user_id);
          $user->password = Hash::make($password);

          if ($user->save()) {

            return Response::json([
              'response' => true
            ]);

          }

        }

      }

    }

    public function postRecuperar(){

      if(Request::ajax()){

        $correo = Input::get('correo');

        $validaciones = [
            'correo' => 'email',
        ];

        $mensajesValidacion = [
            'correo.email' => 'El correo ingresado no es válido!',
        ];

        $validador = Validator::make(Input::all(), $validaciones, $mensajesValidacion);

        if ($validador->fails()){

          return Response::json([
            'mensaje' => false,
            'texto'=>'El correo ingresado no es válido!',
          ]);

        }else{

          //Validar si el correo está registrado
          $consulta = DB::table('users')
          ->where('username',$correo)
          ->first();

          if(!$consulta){

            return Response::json([
              'mensaje' => false,
              'texto'=> 'El correo ingresado no está registrado en nuestro sistema<br><br>Valide la información e inténtelo de nuevo.',
            ]);

          }else{

            $clave = str_random(8);

            $update = DB::table('users')
            ->where('username',$correo)
            ->update([
              'password' => Hash::make($clave)
            ]);

            if($update){

              /*Inicio envío Email con la contraseña nueva*/

              $data = [
                'clave' => $clave,
                'nombre' => $consulta->first_name
              ];
              $message = 'EMAIL';
              $email = $consulta->username;

              Mail::send('emails.cambio_contrasena', $data, function($message) use ($email){
              	$message->from('no-reply@aotour.com.co', 'Notificaciones Aotour');
              	$message->to($email)->subject('Cambio de Contraseña');
                //$message->cc('escolar@aotour.com.co');
              	//$message->attach($pdfPath);
              });

              /*Fin envío Email con la contraseña nueva*/

              return Response::json([
                'mensaje' => true,
                'texto'=> 'Le hemos enviado una clave temporal a su correo, válida para iniciar sesión.<br><br> Una vez iniciado sesión, puede realizar el cambio en la pestaña de configuración.',
                //'clave' => $clave
              ]);

            }else{

              return Response::json([
                'mensaje' => false,
                'texto'=> 'Error! comuníquese con el administrador del sistema.',
              ]);

            }

          }
        }

      }

    }

    public function postLogin(){

        if(Request::ajax()){

            try {
                // Login credentials

                Config::set('cartalyst/sentry::users.login_attribute', 'username');

                $credentials = array(
                    'username'=> Input::get('usuario'),
                    'password' => Input::get('password'),
                );

                $remember = Input::get('recordarme');
               // $qruser = Input::get('qruser');

                /*if($qruser!=null){
                  $username = DB::table('pasajeros')->where('correo',Input::get('usuario'))->pluck('cedula');
                  if($username!=null){
                    if($username==Input::get('password')){
                      //$user = Sentry::authenticate($credentials, $remember);
                      return Response::json([
                          'mensaje'=>true,
                      ]);

                    }else{
                      return Response::json([
                        'mensaje'=>false,
                        'respuesta'=>'Contrase&ntildea incorrecta2'
                    ]);
                    }
                  }else{
                    return Response::json([
                      'mensaje'=>false,
                      'respuesta'=>'Usuario no encontrado'
                    ]);
                  }
                }else{*/
                  // Authenticate the user
                $user = Sentry::authenticate($credentials, $remember);
                  if($user){
                    return Response::json([
                        'mensaje'=>true,
                    ]);
                  }
                //}



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
    }

    public function getClientesparticulares(){

      $ver = null;

      if (Sentry::check()){

          $rol_id = Sentry::getUser()->id_rol;

          $permisos = json_decode(Rol::find($rol_id)->permisos);

          if (isset($permisos->administracion->clientes_particulares->ver)) {

              $ver = $permisos->administracion->clientes_particulares->ver;

              if($ver!='on') {

                  return Redirect::to('permiso_denegado');

              }else{

                $usuarios = User::particular()->orderBy('created_at', 'desc')->get();

                //dd($usuarios);

                return View::make('usuarios.clientes_particulares', [
                  'usuarios' => $usuarios,
                  'i' => 1,
                  'permisos' => $permisos
                ]);

              }

          }else{

              return Redirect::to('permiso_denegado');
          }

      }else if(!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }

    }

    public function getClientesempresariales(){

      $ver = null;

      if (Sentry::check()){

          $rol_id = Sentry::getUser()->id_rol;

          $permisos = json_decode(Rol::find($rol_id)->permisos);

          if (isset($permisos->administracion->clientes_empresariales->ver)) {

              $ver = $permisos->administracion->clientes_empresariales->ver;

              if($ver!='on') {

                  return Redirect::to('permiso_denegado');

              }else{

                $usuarios = User::empresarial()->orderBy('created_at', 'desc')->get();
                $centrosdecosto = Centrodecosto::Activos()->Internos()->orderBy('razonsocial')->get();

                //dd($usuarios);

                return View::make('usuarios.clientes_empresariales', [
                  'usuarios' => $usuarios,
                  'centrosdecosto' => $centrosdecosto,
                  'i' => 1,
                  'permisos' => $permisos
                ]);

              }

          }else{

              return Redirect::to('permiso_denegado');
          }

      }else if(!Sentry::check()){

          return Redirect::to('/')->with('mensaje','<i class="fa fa-exclamation-triangle"></i> Para ingresar al sistema debe loguearse primero');

      }

    }

    public function postEnlazarcentrodecosto(){

      $user = User::find(Input::get('user_id'));
      $user->centrodecosto_id = Input::get('centrodecosto_id');

      if (Input::get('subcentrodecosto_id')==0) {
        $user->subcentrodecosto_id = null;
      }else {
        $user->subcentrodecosto_id = Input::get('subcentrodecosto_id');
      }

      $user->activated = 1;
      $user->activated_at = date('Y-m-d H:i:s');
      $user->activado_por = Sentry::getUser()->id;

      if ($user->save()) {

        $arrayData = [

        ];

        $message = 'Hola '.ucwords(strtolower($user->first_name)).' '.ucwords(strtolower($user->last_name)).' gracias por descargar nuestra aplicacion y registrarte, tu cuenta de usuario ha sido activada, ya puedes solicitar servicios de '.$user->centrodecosto->razonsocial.' desde nuestra aplicacion.';

        Servicio::notificacionGeneral2($user->id, $message, $arrayData);

        if ($user->empresarial==1) {

          Mail::send('emails.correo_activacion', [], function($messages) use ($user)
          {
              $messages->to($user->email)
                      ->cc('aotourdeveloper@gmail.com')
                      ->subject('Activacion de cuenta')
                      ->from('no-reply@aotour.com.co', 'Aotour Mobile Client');
          });

        }

        return Response::json([
          'respuesta' => true
        ]);

      }

    }

    public function postActivarcliente(){

      $user = User::find(Input::get('user_id'));

      if ($user->subcentrodecosto===null) {

        $user->activated = 1;
        $user->activated_at = date('Y-m-d H:i:s');

        if ($user->save()) {

          $subcentrodecosto = new Subcentro();
          $subcentrodecosto->nombresubcentro = $user->first_name.' '.$user->last_name;
          $subcentrodecosto->email_contacto = $user->email;
          $subcentrodecosto->telefono = $user->telefono;
          $subcentrodecosto->centrosdecosto_id = 100;

          if ($subcentrodecosto->save()) {

            $user->centrodecosto_id = 100;
            $user->subcentrodecosto_id = $subcentrodecosto->id;
            $user->save();

            $message = 'Hola '.ucwords(strtolower($user->first_name)).' '.ucwords(strtolower($user->last_name)).' gracias por descargar nuestra aplicacion y registrarte, tu cuenta de usuario ha sido activada, ya puedes solicitar nuestros servicios desde la aplicacion.';

            $arrayData = [
              'eru' => true
            ];

            Servicio::notificacionGeneral2($user->id, $message, $arrayData);

            return Response::json([
              'response' => true
            ]);

          }

        }

      }else{

        return Response::json([
          'response' => false,
          $user
        ]);

      }

    }

    public function getLogout(){
        Sentry::logout();
        return Redirect::to('/')->with('mensaje','Ud ha sido deslogueado');
    }

    public function postBloquear(){

      $user = User::find(Input::get('user_id'));

      if ($user->baneado==1) {

        $user->baneado = null;
        $user->baneado_por = Sentry::getUser()->id;
        $user->baneado_en = date('Y-m-d H:i:s');

      }else {

        $user->baneado = 1;
        $user->baneado_por = Sentry::getUser()->id;
        $user->baneado_en = date('Y-m-d H:i:s');

      }

      if ($user->save()) {

        return Response::json([
          'response' => true,
          'bloqueado' => $user->baneado
        ]);

      }else {

        return Response::json([
          'response' => false,
          'bloqueado' => $user->baneado
        ]);

      }

    }

    public function getTraercentrosubcentro(){

      $user = User::where('id', Input::get('user_id'))->with('centrodecosto.subcentro')->first();

      if (count($user)) {

        return Response::json([
          'user' => $user
        ], 200);

      }else {

        return App::abort(404, 'Not Found');

      }

    }

    public function postActualizarcentrodeusuario(){

      $rules = [
        'centrodecosto' => 'required',
        'subcentrodecosto' => 'required'
      ];

      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {

        return Response::json([
          'errors' => $validator->messages()
        ], 404);

      }else {

        if (Request::ajax()) {

          $centrodecosto_id = Input::get('centrodecosto');
          $subcentrodecosto_id = Input::get('subcentrodecosto');
          $user_id = Input::get('user_id');

          $user = User::find($user_id);
          $user->centrodecosto_id = $centrodecosto_id;
          $user->subcentrodecosto_id = $subcentrodecosto_id;

          if ($user->save()) {

            return Response::json([
              'response' => true
            ], 200);

          }

        }

      }

    }

    public function postCrearfirma(){

      $rules = [
        'nombre_completo' => 'required|sololetrasyespacio',
        'nombre_puesto' => 'required|sololetrasyespacio'
      ];

      $messages = [
        'nombre_completo.sololetrasyespacio' => 'El campo nombre completo solo puede tener letras y espacio',
        'nombre_puesto.sololetrasyespacio' => 'El campo nombre del puesto solo puede tener letras y espacio'
      ];

      $validator = Validator::make(Input::all(), $rules, $messages);

      if ($validator->fails()) {

        return Response::json([
          'response' => false,
          'errores' => $validator->messages()
        ]);

      }else {

        $buscarFirma = FirmaCorreo::where('user_id', Sentry::getUser()->id)->first();

        if (count($buscarFirma)) {

          $buscarFirma->nombre_completo = strtoupper(trim(Input::get('nombre_completo')));
          $buscarFirma->nombre_puesto = strtoupper(trim(Input::get('nombre_puesto')));
          $buscarFirma->user_id = Sentry::getUser()->id;

          if ($buscarFirma->save()) {

            return Response::json([
              'response' => true
            ]);

          }

        }else {

          $firma = new FirmaCorreo();
          $firma->nombre_completo = strtoupper(Input::get('nombre_completo'));
          $firma->nombre_puesto = strtoupper(Input::get('nombre_puesto'));
          $firma->user_id = Sentry::getUser()->id;

          if ($firma->save()) {

            return Response::json([
              'response' => true
            ]);

          }

        }

      }

    }

}
