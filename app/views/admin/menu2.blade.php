
    <nav class="navbar navbar-custom">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar" style="background: #ffffff;"></span>
            <span class="icon-bar" style="background: #ffffff;"></span>
            <span class="icon-bar" style="background: #ffffff;"></span>
          </button>
          <a class="navbar-brand" href="{{url('/')}}">
            
              <img src="{{url('img/logot.png')}}">            
            
          </a>

        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">              
              @if(isset($permisos->portalusuarios->qrusers->ver))
                @if($permisos->portalusuarios->qrusers->ver==='on')
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Código QR <i class="fa fa-qrcode"></i><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li >
                          <a class="dropdown-toggle" href="{{url('portalusu/qrcode')}}" >Descargar Código QR  <i class="fa fa-qrcode" aria-hidden="true"></i></a>                              
                        </li>                                                           
                        <li >
                          <a class="dropdown-toggle" href="{{url('portalusu/politicas')}}" >Descargar Politicas de datos <i class="fa fa-cloud-download" aria-hidden="true"></i></a>                              
                        </li>  
                    </ul>
                  </li>
                @endif  
              @endif
              <!-- -->
                @if(isset($permisos->portalusuarios->gestiondocumental->ver))                                
                  @if($permisos->portalusuarios->gestiondocumental->ver==='on')
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gestión documental <i class="fa fa-pencil-square-o" aria-hidden="true"></i></i><span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li>
                          <a class="dropdown-toggle" href="{{url('gestiondocumental/verificacionderutas')}}">Verificación de fotos <i class="fa fa-camera" aria-hidden="true"></i></a>         
                        </li>
                        <li>
                          <a class="dropdown-toggle" href="{{url('gestiondocumental/reportedelimpieza')}}">Reporte de limpieza <i class="fa fa-dot-circle-o" aria-hidden="true"></i></a>
                        </li>
                      </ul>
                    </li>
                  @endif
                @endif
              <!-- -->
              @if(isset($permisos->portalusuarios->admin->ver))                                
                @if($permisos->portalusuarios->admin->ver==='on')
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">PQR <i class="fa fa-pencil-square-o" aria-hidden="true"></i></i><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li>
                        <a class="dropdown-toggle" href="{{url('pqr')}}" >Generar PQR <i class="fa fa-share-square" aria-hidden="true"></i></a>         
                      </li>                         
                    </ul>
                  </li>
                @endif
              @endif
              <!-- -->
              @if(isset($permisos->portalusuarios->admin->ver))
                @if($permisos->portalusuarios->admin->ver==='on')
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuarios <i class="fa fa-users"></i><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li>
                        <a class="dropdown-toggle" href="{{url('listadousuariosqr')}}" >Usuarios QR <i class="fa fa-user" aria-hidden="true"></i></a>         
                      </li>                    
                    </ul>
                  </li>

                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dashboard <i class="fa fa-tachometer" aria-hidden="true"></i><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li>
                        <a class="dropdown-toggle" href="{{url('portalusu/dashboardadministrador')}}" >Ver Dashboard <i class="fa fa-tachometer" aria-hidden="true"></i></a>         
                      </li>
                      <li>
                        <a class="dropdown-toggle" href="{{url('portalusu/exportardatos')}}" >Exportar Información de Rutas <i class="fa fa-download" aria-hidden="true"></i></a>         
                      </li>                     
                    </ul>
                  </li>
                @endif
              @endif
              
                @if(isset($permisos->portalusuarios->admin->ver) or isset($permisos->portalusuarios->bancos->ver))
                  @if($permisos->portalusuarios->admin->ver==='on' or $permisos->portalusuarios->bancos->ver==='on')
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Servicios <i class="fa fa-bars"></i><span class="caret"></span></a>
                      <ul class="dropdown-menu">
                          @if($permisos->portalusuarios->admin->ver==='on' or $permisos->portalusuarios->bancos->ver==='on')
                              <li >
                                <a class="dropdown-toggle" href="{{url('serviciosadmin')}}" >Servicios Ejecutivos <i class="fa fa-car" aria-hidden="true"></i></a>                              
                              </li> 
                          @endif
                          @if($permisos->portalusuarios->admin->ver==='on')
                            <li>
                              <a class="dropdown-toggle" href="{{url('serviciosadmin/rutasempresariales')}}" >Rutas Empresariales <i class="fa fa-bus" aria-hidden="true"></i></a>         
                            </li>
                          @endif
                          
                      </ul>
                    </li>  
                  @endif                     
                @endif 

                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Documentación <i class="fa fa-book"></i><span class="caret"></span></a>
                  <ul class="dropdown-menu">

                    <li >
                      <a class="dropdown-toggle" href="{{url('portalproveedores/cuentadecobro')}}" >Vehículos <i class="fa fa-car" aria-hidden="true"></i></a>                              
                    </li> 

                    <!--<li>
                      <a class="dropdown-toggle" href="{{url('serviciosadmin/rutasempresariales')}}" >
                      Estado de solicitud actual <i class="fa fa-hourglass-start" aria-hidden="true"></i></a>         
                    </li>
                      
                    <li>
                      <a class="dropdown-toggle" href="{{url('serviciosadmin/rutasempresariales')}}" >
                      Procesos anteriores <i class="fa fa-history" aria-hidden="true"></i></a>         
                    </li>-->

                  </ul>
                </li>

                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cuentas de Cobro <i class="fa fa-money"></i><span class="caret"></span></a>
                  <ul class="dropdown-menu">

                    <li >
                      <a class="dropdown-toggle" href="{{url('portalproveedores/cuentadecobro')}}" >Generar <i class="fa fa-thumb-tack" aria-hidden="true"></i></a>                              
                    </li> 

                    <li>
                      <a class="dropdown-toggle" href="{{url('portalproveedores/solicitudactual')}}" >
                      Estado de solicitud actual <i class="fa fa-hourglass-start" aria-hidden="true"></i></a>         
                    </li>
                      
                    <li>
                      <a class="dropdown-toggle" href="{{url('serviciosadmin/rutasempresariales')}}" >
                      Procesos anteriores <i class="fa fa-history" aria-hidden="true"></i></a>         
                    </li>

                  </ul>
                </li>


              @if(isset($permisos->barranquilla->transportesbq->ver) or isset($permisos->bogota->transportes->ver) or isset($permisos->otrostransporte->otrostransportes->ver))
              <?php

                $s = 0;

              ?>
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Servicios <i class="fa fa-bars"></i><span class="caret"></span>@if(isset($permisos->bogota->reconfirmacion->alerta_reconfirmacion))
                        @if($permisos->bogota->reconfirmacion->alerta_reconfirmacion==='on')
                          @if($s>0)
                            <div style="background: gray; color: yellow" class="badge_menu_head fontbulger servicio_mobil_badge">{{$s}}
                            </div>
                          @else
                            <div style="background: gray; color: yellow" class="badge_menu_head servicio_mobil_badge">0
                            </div>
                          @endif
                        @endif
                      @endif

                      <!-- OPCIONES PARA BARRANQUILLA -->
                      @if(isset($permisos->barranquilla->reconfirmacionbq->alerta_reconfirmacion))
                        @if($permisos->barranquilla->reconfirmacionbq->alerta_reconfirmacion==='on')
                          @if($s>0)
                            <div style="background: gray; color: yellow" class="badge_menu_head fontbulger serviciob_mobilb_badge">{{$s}}
                            </div>
                          @else
                            <div style="background: gray; color: yellow" class="badge_menu_head serviciob_mobilb_badge">0
                            </div>
                          @endif
                        @endif
                      @endif
                      <!-- FIN OPCIONES PARA BARRANQUILLA -->

                      @if($permisos->bogota->transportes->ver==='on')
                        <?php 
                          $sin_programar = ServicioA::whereNull('estado_programado')->where('localidad','bogota')->count();
                        ?>

                        @if($sin_programar>0)
                          <div style="background: #B1EA5E; color: #F06926; margin-left: 8px" class="badge_menu_head fontbulger serv_autonet_badge">{{$sin_programar}}
                          </div>
                        @else
                          <div style="background: #B1EA5E; color: #F06926; margin-left: 8px" class="badge_menu_head serv_autonet_badge">0
                          </div>
                        @endif
                      @endif
                    </a>
                      <ul class="dropdown-menu">
                        @if(isset($permisos->barranquilla->transportesbq->ver))
                          @if($permisos->barranquilla->transportesbq->ver==='on')
                          <li class="dropdown-submenu">
                            <a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bold" aria-hidden="true"></i>ARRANQUILL<i class="fa fa-buysellads" aria-hidden="true"></i></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                  <a class="dropdown-toggle" data-toggle="dropdown">Transportes <i class="fa fa-road"></i></a>
                                  <ul class="dropdown-menu">
                                    <li><a href="{{url('transportesbaq')}}">Servicios <i class="fa fa-car" aria-hidden="true"></i></a></li>
                                
                                <li><a href="{{url('transportesrutas')}}">Rutas <i class="fa fa-bus" aria-hidden="true"></i></a></li>                                

                                <li><a href="{{url('serviciosyrutasbarranquilla')}}">Servicios y Rutas <i class="fa fa-car" aria-hidden="true"></i> <i class="fa fa-bus" aria-hidden="true"></i></a></li>                                

                                <li><a href="{{url('serviciosgps/liveview')}}">Live View <i class="fa fa-map-marker" aria-hidden="true"></i></a></li> 

                            </ul>
                                </li>
                                @if(isset($permisos->barranquilla->poreliminarbq->ver))
                                  @if($permisos->barranquilla->poreliminarbq->ver==='on')
                                    <li><a href="{{url('transportesbaq/serviciosporeliminar')}}">Servicios por Eliminar <i class="fa fa-ban"></i></a></li>
                                    <li><a href="{{url('transportesbaq/servicioseditados')}}">Servicios Editados <i class="fa fa-pencil"></i></a></li>
                                  @endif
                                @endif     
                                @if(isset($permisos->turismo->otros->ver))
                                  @if($permisos->turismo->otros->ver==='on')                           
                                    <li><a href="{{url('otrosservicios')}}">Otros <i class="fa fa-ticket"></i></a></li>
                                  @endif
                                @endif                         
                                @if(isset($permisos->barranquilla->papeleradereciclajebq->ver))
                                  @if($permisos->barranquilla->papeleradereciclajebq->ver==='on')
                                    <li><a href="{{url('papelera')}}">Papelera de reciclaje <i class="fa fa-trash-o"></i></a></li>
                                  @endif
                                @endif
                                @if(isset($permisos->barranquilla->transportesbq->ver))
                                  @if($permisos->barranquilla->transportesbq->ver==='on')
                                    <li><a href="{{url('gestiondocumental/verificaciondefotosbaq')}}">Fotos de Bioseguridad <i class="fa fa-photo"></i></a></li>
                                  @endif
                                @endif
                            </ul>
                          </li>
                          @endif
                          @endif
                          @if(isset($permisos->bogota->transportes->ver))
                              @if($permisos->bogota->transportes->ver==='on')                              
                      
                                <li class="dropdown-submenu">
                                <a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bold" aria-hidden="true"></i>OGOTÁ 
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-submenu">
                                      <a class="dropdown-toggle" data-toggle="dropdown">Transportes <i class="fa fa-road"></i></a>
                                      <ul class="dropdown-menu">
                                        <li><a href="{{url('transportesbog')}}">Servicios <i class="fa fa-car" aria-hidden="true"></i></a></li>        

                                          <li><a href="{{url('transportesbog/serviciosporprogramar')}}">Servicios Excel  <i class="fa fa-calendar" aria-hidden="true"></i> 
                                            <?php

                                              $sin_programar = ServicioA::whereNull('estado_programado')->where('localidad','bogota')->count();

                                            ?>
                                            @if($sin_programar>0)
                                              <div style="background: #B1EA5E; color: #F06926;" class="badge_menu_head fontbulger serv_autonet_badge">{{$sin_programar}}
                                              </div>
                                            @else
                                              <div style="background: #B1EA5E; color: #F06926;" class="badge_menu_head serv_autonet_badge">0
                                              </div>
                                            @endif
                                  </a></li>
    
                                        <li><a href="{{url('transportesrutasbog')}}">Rutas <i class="fa fa-bus" aria-hidden="true"></i></a></li>
                                        
                                        <li><a href="{{url('serviciosyrutasbogota')}}">Servicios y Rutas <i class="fa fa-car" aria-hidden="true"></i> <i class="fa fa-bus" aria-hidden="true"></i></a></li>

                                        <li><a href="{{url('serviciosgps/liveviewbog')}}">Live View <i class="fa fa-map-marker" aria-hidden="true"></i></a></li> 
                                        
                                      </ul>
                                    </li>
                                    @if(isset($permisos->bogota->poreliminar->ver))
                                      @if($permisos->bogota->poreliminar->ver==='on')
                                        <li><a href="{{url('transportesbog/serviciosporeliminar')}}">Servicios por Eliminar <i class="fa fa-ban"></i></a></li>
                                        <li><a href="{{url('transportesbog/servicioseditados')}}">Servicios Editados <i class="fa fa-pencil"></i></a></li>
                                      @endif
                                    @endif
                                    @if(isset($permisos->turismo->otros->ver))
                                      @if($permisos->turismo->otros->ver==='on')
                                        <li><a href="{{url('otrosservicios')}}">Otros <i class="fa fa-ticket"></i></a></li>
                                      @endif
                                    @endif
                                    @if(isset($permisos->bogota->papeleradereciclaje->ver))
                                      @if($permisos->bogota->papeleradereciclaje->ver==='on')
                                         <li><a href="{{url('papelerabog')}}">Papelera de reciclaje <i class="fa fa-trash-o"></i></a></li>                               
                                       @endif
                                    @endif
                                    @if(isset($permisos->bogota->transportes->ver))
                                      @if($permisos->bogota->transportes->ver==='on')
                                        <li><a href="{{url('gestiondocumental/verificaciondefotosbog')}}">Fotos de Bioseguridad <i class="fa fa-photo"></i></a></li>
                                      @endif
                                    @endif
                                </ul>
                              </li>
                              @endif
                          @endif
                          @if(isset($permisos->otrostransporte->otrostransporte->ver))
                            @if($permisos->otrostransporte->otrostransporte->ver==='on')

                              <li class="dropdown-submenu">
                                <a class="dropdown-toggle" data-toggle="dropdown">OTROS <i class="fa fa-globe" aria-hidden="true"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{url('transportes')}}">Transportes AO <i class="fa fa-car" aria-hidden="true"></i></a></li>
                                                                        
                                </ul>
                              </li>
                              @endif
                              @endif
                      </ul>
                  </li>
              @endif

              @if(isset($permisos->facturacion->revision->ver) or isset($permisos->facturacion->liquidacion->ver) or isset($permisos->facturacion->autorizar->ver) or isset($permisos->facturacion->ordenes_de_facturacion->ver))
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Facturacion <i class="fa fa-usd"></i><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    @if(isset($permisos->facturacion->revision->ver))
                        @if($permisos->facturacion->revision->ver==='on')
                            <li><a href="{{url('facturacion/revision')}}">Revision <i class="fa fa-files-o"></i></a></li>
                        @endif
                    @endif
                    @if(isset($permisos->facturacion->liquidacion->ver))
                        @if($permisos->facturacion->liquidacion->ver==='on')
                            <li><a href="{{url('facturacion/liquidacion')}}">Liquidacion <i class="fa fa-file-o"></i></a></li>
                        @endif
                    @endif
                    @if(isset($permisos->facturacion->autorizar->ver))
                        @if($permisos->facturacion->autorizar->ver==='on')
                            <li><a href="{{url('facturacion/autorizacionservicios')}}">Pendientes Autorizar <i class="fa fa-square-o" aria-hidden="true"></i></a></li>
                            <li><a href="{{url('facturacion/serviciosautorizados')}}">Autorizados <i class="fa fa-check-square-o"></i></a></li>
                        @endif
                    @endif
                    @if(isset($permisos->facturacion->ordenes_de_facturacion->ver))
                        @if($permisos->facturacion->ordenes_de_facturacion->ver==='on')
                            <li><a href="{{url('facturacion/ordenesfacturacion')}}">Ordenes Facturacion <i class="fa fa-file-text-o" aria-hidden="true"></i></a></li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-toggle" data-toggle="dropdown">Facturas <i class="fa fa-text"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{url('facturacion/facturasanuladas')}}">Anuladas <i class="fa fa fa-text" aria-hidden="true"></i></a></li>
                                    <li><a href="{{url('facturacion/facturasporvencer')}}">Por Vencer <i class="fa fa fa-text" aria-hidden="true"></i></a></li>
                                    <li><a href="{{url('facturacion/facturasvencidas')}}">Vencidas <i class="fa fa fa-text" aria-hidden="true"></i></a></li>
                                    <li><a href="{{url('facturacion/facturasconingreso')}}">Con Ingreso<i class="fa fa fa-text" aria-hidden="true"></i></a></li>
                                    <li><a href="{{url('facturacion/facturasrevisadas')}}">Revisadas <i class="fa fa fa-text"></i></a></li>
                                </ul>
                            </li>
                        @endif
                    @endif
                </ul>
              </li>
              @endif

              @if(isset($permisos->contabilidad->pago_proveedores->ver) or isset($permisos->contabilidad->comisiones->ver))
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Contabilidad <i class="fa fa-usd"></i><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      @if(isset($permisos->contabilidad->pago_proveedores->ver))
                          @if($permisos->contabilidad->pago_proveedores->ver==='on')
                          <li><a href="{{url('facturacion/pagoproveedores')}}">Pagos proveedores <i class="fa fa-building-o" aria-hidden="true"></i></a></li>
                          @endif
                      @endif
                      @if(isset($permisos->contabilidad->comisiones->ver))
                          @if($permisos->contabilidad->comisiones->ver==='on')
                          <li><a href="{{url('comisiones')}}">Comisiones <i class="fa fa-star" aria-hidden="true"></i></a></li>
                          @endif
                      @endif                      
                      @if(isset($permisos->contabilidad->comisiones->ver))
                          @if($permisos->contabilidad->comisiones->ver==='on')
                          <li><a href="{{url('portalproveedores/listadocuentas')}}">Cuentas de Cobro <i class="fa fa-star" aria-hidden="true"></i></a></li>
                          @endif
                      @endif   
                  </ul>
              </li>
              @endif

              @if(isset($permisos->administrativo->centros_de_costo->ver) or isset($permisos->administrativo->proveedores->ver)
              or isset($permisos->administrativo->administracion_proveedores->ver) or isset($permisos->administrativo->contratos->ver)
              or isset($permisos->administrativo->seguridad_social->ver) or isset($permisos->administrativo->fuec->ver)
              or isset($permisos->administrativo->rutas_y_tarifas->ver) or isset($permisos->administrativo->ciudades->ver))
                <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">ADMIN <i class="fa fa-sliders"></i><span class="caret"></span></a>
                  <ul class="dropdown-menu multi-level">
                      @if(isset($permisos->administrativo->centros_de_costo->ver))
                          @if($permisos->administrativo->centros_de_costo->ver==='on')
                              <li><a href="{{url('centrodecosto')}}">Centros de costos <i class="fa fa-users"></i></a></li>
                          @endif
                      @endif
                    @if(isset($permisos->administrativo->proveedores->ver) or isset($permisos->administrativo->administracion_proveedores->ver)
                    or isset($permisos->administrativo->contratos->ver) or isset($permisos->administrativo->seguridad_social->ver) or isset($permisos->administrativo->fuec->ver))
                    <li class="dropdown-submenu">
                        <a class="dropdown-toggle" data-toggle="dropdown">Proveedores <i class="fa fa-car"></i></a>
                        <ul class="dropdown-menu">
                            @if(isset($permisos->administrativo->proveedores->ver))
                                @if($permisos->administrativo->proveedores->ver==='on')
                                    <li class="dropdown-submenu">
                                      <a href="{{url('proveedores')}}">Listado</a>
                                      <ul class="dropdown-menu">
                                          <li><a href="{{url('proveedores')}}">Proveedores <i class="fa fa-server" aria-hidden="true"></i></i></a></li>
                                          <li><a href="{{url('proveedores/listadoconductores')}}">Conductores <i class="fa fa-users"></i></a></li>
                                          <li><a href="{{url('proveedores/listadovehiculos')}}">Vehiculos <i class="fa fa-car"></i></a></li>
                                          @if(Sentry::getUser()->id===2 or Sentry::getUser()->id===4086 or Sentry::getUser()->id===508)
                                            <li><a href="{{url('proveedores/listadofotosconductores')}}">Fotos de Conductores <i class="fa fa-car"></i></a></li>
                                          @endif
                                      </ul>
                                    </li>
                                @endif
                            @endif
                            @if(isset($permisos->administrativo->administracion_proveedores->ver))
                                @if($permisos->administrativo->administracion_proveedores->ver==='on')
                                    <li><a href="{{url('proveedores/administracion')}}">Administracion <i class="fa fa-balance-scale" aria-hidden="true"></i></a></li>
                                @endif
                            @endif
                            @if(isset($permisos->administrativo->contratos->ver))
                                @if($permisos->administrativo->contratos->ver==='on')
                                    <li><a href="{{url('proveedores/contratos')}}">Contratos <i class="fa fa-book" aria-hidden="true"></i></a></li>
                                @endif
                            @endif
                            @if(isset($permisos->administrativo->seguridad_social->ver))
                                @if($permisos->administrativo->seguridad_social->ver==='on')
                                    <li><a href="{{url('proveedores/seguridadsocialciudades')}}">Seguridad Social <i class="fa fa-heart" aria-hidden="true"></i></a></li>
                                @endif
                            @endif
                            @if(isset($permisos->administrativo->fuec->ver))
                                @if($permisos->administrativo->fuec->ver==='on')
                                    <li><a href="{{url('fuec')}}">Fuec <i class="fa fa-map"></i></a></li>
                                @endif
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if(isset($permisos->administrativo->rutas_y_tarifas->ver))
                        @if($permisos->administrativo->rutas_y_tarifas->ver==='on')
                            <!--<li><a href="{{url('rutas')}}">Rutas y Tarifas <i class="fa fa-road"></i></a></li>-->
                            <li><a href="{{url('tarifastraslados')}}">Tarifas Traslado <i class="fa fa-road"></i></a></li>
                        @endif
                    @endif
                    @if(isset($permisos->administrativo->ciudades->ver))
                        @if($permisos->administrativo->ciudades->ver==='on')
                            <li><a href="{{url('ciudades')}}">Ciudades <i class="fa fa-globe"></i></a></li>
                        @endif                        
                    @endif                  
                  </ul>
                </li>
              @endif
              <!-- START GESTIÓN INTEGRAL -->
              @if(isset($permisos->gestion_integral->indicadores->ver))
                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">GI <i class="fa fa-get-pocket"></i><span class="caret"></span></a>
                  <ul class="dropdown-menu multi-level">
                    @if($permisos->gestion_integral->indicadores->ver==='on')
                      <li><a href="{{url('gestionintegral')}}">Indicadores de Gestión <i class="fa fa-tachometer"></i></a></li>
                    @endif
                  </ul>
                </li>
              @endif
              <!-- END GESTIÓN INTEGRAL -->
              <!-- START TALENTO HUMANO -->
              @if(isset($permisos->talentohumano->empleados->ver) or isset($permisos->talentohumano->prestamos->ver)
              or isset($permisos->talentohumano->vacaciones->ver) or isset($permisos->talentohumano->control_ingreso->ver) or isset($permisos->talentohumano->control_ingreso_bog->ver) or isset($permisos->talentohumano->control_ingreso_bog->guardar_personal) or isset($permisos->talentohumano->control_ingreso_bog->guardar_personal_bog))
                <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">TH <i class="fa fa-user"></i><span class="caret"></span></a>
                  <ul class="dropdown-menu multi-level">
                      @if(isset($permisos->talentohumano->empleados->ver))
                          @if($permisos->talentohumano->empleados->ver==='on')
                              <li><a href="{{url('talentohumano/personaladministrativo')}}">Personal Administrativo <i class="fa fa-users"></i></a></li>
                          @endif
                      @endif
                      @if(isset($permisos->talentohumano->empleados->ver))
                          @if($permisos->talentohumano->empleados->ver==='on')
                              <li><a href="{{url('talentohumano/personaloperativo')}}">Personal Operativo <i class="fa fa-users"></i></a></li>
                          @endif
                      @endif
                      @if(isset($permisos->talentohumano->empleados->ver))
                          @if($permisos->talentohumano->empleados->ver==='on')
                              <li><a href="{{url('talentohumano/personalretirado')}}">Personal Retirado <i class="fa fa-users"></i></a></li>
                          @endif
                      @endif
                      @if(isset($permisos->talentohumano->prestamos->ver))
                          @if($permisos->talentohumano->prestamos->ver==='on')
                              <li><a href="{{url('talentohumano/solicitudesdeprestamos')}}">Gestión de Préstamos <i class="fa fa-money"></i></a></li>
                          @endif
                      @endif
                      @if(isset($permisos->talentohumano->vacaciones->ver))
                          @if($permisos->talentohumano->vacaciones->ver==='on')
                              <li><a href="{{url('talentohumano/vacaciones')}}">Vacaciones <i class="fa fa-plane"></i></a></li>
                          @endif
                      @endif
                                        
                      @if(isset($permisos->talentohumano->control_ingreso->ver) or isset($permisos->talentohumano->control_ingreso->guardar_personal))
                          @if($permisos->talentohumano->control_ingreso->ver==='on' or $permisos->talentohumano->control_ingreso->guardar_personal==='on')
                              <li><a href="{{url('control')}}">Control de Ingreso BAQ <i class="fa fa-check"></i></a></li>
                          @endif                        
                      @endif

                      @if(isset($permisos->talentohumano->control_ingreso_bog->ver) or isset($permisos->talentohumano->control_ingreso_bog->guardar_personal_bog))
                          @if($permisos->talentohumano->control_ingreso_bog->ver==='on' or $permisos->talentohumano->control_ingreso_bog->guardar_personal_bog==='on')
                              <li><a href="{{url('control/controlbog')}}">Control de Ingreso BOG <i class="fa fa-check"></i></a></li>
                          @endif                        
                      @endif
                  </ul>
                </li>
              @endif
              <!-- END TALENTO HUMANO -->

              @if(isset($permisos->comercial->cotizaciones->ver))
                  @if($permisos->comercial->cotizaciones->ver==='on')
                  <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Comercial <i class="fa fa-briefcase" aria-hidden="true"></i><span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        @if(isset($permisos->comercial->cotizaciones->ver))
                            @if($permisos->comercial->cotizaciones->ver==='on')
                                <li><a href="{{url('cotizaciones')}}">Cotizaciones <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></li>
                            @endif
                        @endif
                      </ul>
                  </li>
                  @endif
              @endif

              @if(isset($permisos->administracion->usuarios->ver) or isset($permisos->administracion->clientes_particulares->ver) or isset($permisos->administracion->clientes_empresariales->ver) or isset($permisos->administracion->importar_pasajeros->ver) or isset($permisos->administracion->listado_pasajeros->ver))
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <i class="fa fa-users"></i><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @if(isset($permisos->administracion->usuarios->ver))
                          @if($permisos->administracion->usuarios->ver==='on')
                              <li><a href="{{url('usuarios')}}">Listado <i class="fa fa-user" aria-hidden="true"></i></a></li>
                          @endif
                        @endif
                        @if(isset($permisos->administracion->clientes_particulares->ver))
                          @if($permisos->administracion->clientes_particulares->ver==='on')
                            <li><a href="{{url('usuarios/clientesparticulares')}}">Clientes particulares <i class="fa fa-user" aria-hidden="true"></i></a></li>
                          @endif
                        @endif
                        @if(isset($permisos->administracion->clientes_empresariales->ver))
                          @if($permisos->administracion->clientes_empresariales->ver==='on')
                            <li><a href="{{url('usuarios/clientesempresariales')}}">Clientes empresariales<i class="fa fa-user" aria-hidden="true"></i></a></li>
                          @endif
                        @endif
                        @if(isset($permisos->administracion->importar_pasajeros->ver))
                          @if($permisos->administracion->importar_pasajeros->ver==='on')
                            <li><a href="{{url('importarpasajeros')}}">Importar Usuarios Clientes <i class="fa fa-user"></i></a></li>
                          @endif
                        @endif
                        @if(isset($permisos->administracion->listado_pasajeros->ver))
                          @if($permisos->administracion->listado_pasajeros->ver==='on')
                            <li><a href="{{url('listadopasajeros')}}">Listado Usuarios Clientes <i class="fa fa-user"></i></a></li>
                          @endif
                        @endif
                        <li><a href="{{url('listadopasajeros')}}">Listado Usuarios Empresas <i class="fa fa-user"></i></a></li>
                    </ul>
                </li>
              @endif

              @if(isset($permisos->mobile->servicios_programados_sintarifa->ver) or isset($permisos->mobile->servicios_programados_tarifado->ver) or
                  isset($permisos->mobile->servicios_programados_pagados->ver) or isset($permisos->mobile->servicios_programados_facturacion->ver) or
                  isset($permisos->mobile->servicios_programados->ver))

                <?php

                  $sin_tarifa = Servicioaplicacion::sintarifa()->count();
                  $pagados = Servicioaplicacion::pagados()->count();

                  //$empresarial = Servicioaplicacion::pagofacturacion()->count();

                  $empresarial = Servicioaplicacion::whereRaw('(pago_facturacion = 1 or liquidacion_pendiente = 1)')
    							->whereNull('programado')
    							->whereNull('cancelado')
    							->count();


                  $cancelados = Servicio::canceladoapp()->count();

                ?>

                <li class="dropdown">
                  <a href="#" class="dropdown-toggle usuario_nombre" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                      Servicios APP
                      <i class="fa fa-mobile-phone"></i>
                      @if(($sin_tarifa+$pagados+$empresarial+$cancelados)>0)
                        <div class="badge_menu_head fontbulger servicios_mobile_badge">
                          {{$sin_tarifa+$pagados+$empresarial+$cancelados}}
                        </div>
                      @else
                        <div class="badge_menu_head servicios_mobile_badge">{{$sin_tarifa+$pagados+$empresarial+$cancelados}}</div>
                      @endif
                      <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    @if(isset($permisos->mobile->servicios_programados_sintarifa->ver))
                        @if($permisos->mobile->servicios_programados_sintarifa->ver==='on')
                          <li class="list_sin_tarifa" style="position: relative">
                            <a href="{{url('mobile/serviciosprogramadossintarifa')}}">
                              Sin tarifa
                              <i class="fa fa-car"></i>
                              @if ($sin_tarifa>0)
                                <div class="badge_menu">
                                  {{$sin_tarifa}}
                                </div>
                              @else
                                <div class="badge_menu hidden">
                                </div>
                              @endif
                            </a>
                          </li>
                        @endif
                    @endif

                    @if(isset($permisos->mobile->servicios_programados_tarifado->ver))
                        @if($permisos->mobile->servicios_programados_tarifado->ver==='on')
                          <li class="list_tarifados" style="position: relative">
                            <a href="{{url('mobile/serviciosprogramadostarifado')}}">Tarifados <i class="fa fa-car"></i></a>
                          </li>
                        @endif
                    @endif

                    @if(isset($permisos->mobile->servicios_programados_pagados->ver))
                        @if($permisos->mobile->servicios_programados_pagados->ver==='on')
                          <li class="list_pagados" style="position: relative">
                            <a href="{{url('mobile/serviciosprogramadospagados')}}">Pagados
                              <i class="fa fa-car"></i>
                              @if ($pagados>0)
                                <div class="badge_menu">
                                  {{$pagados}}
                                </div>
                              @else
                                <div class="badge_menu hidden">
                                </div>
                              @endif
                            </a>
                          </li>
                        @endif
                    @endif

                    @if(isset($permisos->mobile->servicios_programados_facturacion->ver))
                        @if($permisos->mobile->servicios_programados_facturacion->ver==='on')
                          <li class="list_empresariales" style="position: relative">
                            <a href="{{url('mobile/serviciosempresariales')}}">Empresariales
                              @if ($empresarial>0)
                                <div class="badge_menu">
                                  {{$empresarial}}
                                </div>
                              @else
                                <div class="badge_menu hidden">
                                </div>
                              @endif
                            </a>
                          </li>
                        @endif
                    @endif

                    @if(isset($permisos->mobile->servicios_programados->ver))
                        @if($permisos->mobile->servicios_programados->ver==='on')
          								<li class="dropdown-submenu">
          									<a class="dropdown-toggle" data-toggle="dropdown">Programados <i class="fa fa-road"></i></a>
          									<ul class="dropdown-menu">
                              <li><a href="{{url('mobile/serviciosprogramadosparticulares')}}">Particulares</a></li>
                              <li><a href="{{url('mobile/serviciosprogramados')}}">Cobro por facturacion</a></li>
                              <li><a href="{{url('mobile/serviciospendientesporliquidar')}}">Cobro por tarjeta de credito</a></li>
                            </ul>
                          </li>
                        @endif
                    @endif

                    @if(isset($permisos->mobile->servicios_programados_facturacion->ver))
                        @if($permisos->mobile->servicios_programados_facturacion->ver==='on')
                          <li class="dropdown-submenu">
          									<a class="dropdown-toggle" data-toggle="dropdown">Cancelados</a>
          									<ul class="dropdown-menu">
                              <li class="list_cancelados" style="position: relative">
                                <a href="{{url('mobile/servicioscancelados')}}">
                                  Cancelados sin programar
                                  @if ($cancelados>0)
                                    <div class="badge_menu">
                                      {{$cancelados}}
                                    </div>
                                  @else
                                    <div class="badge_menu hidden">
                                    </div>
                                  @endif
                                </a>
                              </li>
                              <li><a href="{{url('mobile/servicioscanceladosinprogramar')}}">Despues de programados</a></li>
                            </ul>
                          </li>
                        @endif
                    @endif

                  </ul>
                </li>
              @endif

              <li class="dropdown">
                <a href="#" class="dropdown-toggle usuario_nombre" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    {{Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name}}
                    <i class="fa fa-user"></i>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="{{url('usuarios/configuracion')}}">Configuracion <i class="fa fa-cog"></i></a></li>                  
                  <li><a href="{{url('usuarios/logout')}}">Salir <i class="fa fa-power-off"></i></a></li>
                </ul>
              </li>
            </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
  </nav>
