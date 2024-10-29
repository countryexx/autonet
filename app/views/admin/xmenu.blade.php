
    <nav class="navbar navbar-custom">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{url('/')}}"><img src="{{url('img/logot.png')}}"></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">

            @if(isset($permisos->transportes->servicios->ver) or isset($permisos->transportes->poreliminar->ver) or isset($permisos->turismo->otros->ver) or isset($permisos->transportes->papeleradereciclaje->ver))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Servicios <i class="fa fa-bars"></i><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @if(isset($permisos->transportes->servicios->ver))
                            @if($permisos->transportes->servicios->ver==='on')
                                <li><a href="{{url('transportes')}}">Transportes <i class="fa fa-truck"></i></a></li>
                            @endif
                        @endif
                        @if(isset($permisos->transportes->poreliminar->ver))
                            @if($permisos->transportes->poreliminar->ver==='on')
                                <li><a href="{{url('transportes/serviciosporeliminar')}}">Servicios por Eliminar <i class="fa fa-ban"></i></a></li>
                            @endif
                        @endif
                        @if(isset($permisos->turismo->otros->ver))
                            @if($permisos->turismo->otros->ver==='on')
                                <li><a href="{{url('otrosservicios')}}">Otros <i class="fa fa-ticket"></i></a></li>
                            @endif
                        @endif
                        @if(isset($permisos->transportes->papeleradereciclaje->ver))
                            @if($permisos->transportes->papeleradereciclaje->ver==='on')
                                <li><a href="{{url('papelera')}}">Papelera de reciclaje <i class="fa fa-trash-o"></i></a></li>
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
                </ul>
            </li>
            @endif

            @if(isset($permisos->administrativo->centros_de_costo->ver) or isset($permisos->administrativo->proveedores->ver)
            or isset($permisos->administrativo->administracion_proveedores->ver) or isset($permisos->administrativo->contratos->ver)
            or isset($permisos->administrativo->seguridad_social->ver) or isset($permisos->administrativo->fuec->ver)
            or isset($permisos->administrativo->rutas_y_tarifas->ver) or isset($permisos->administrativo->ciudades->ver))
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administrativo <i class="fa fa-sliders"></i><span class="caret"></span></a>
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
                                <li><a href="{{url('proveedores/seguridadsocial')}}">Seguridad Social <i class="fa fa-heart" aria-hidden="true"></i></a></li>
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
                        <li><a href="{{url('rutas')}}">Rutas y Tarifas <i class="fa fa-road"></i></a></li>
                    @endif
                @endif
                @if(isset($permisos->administrativo->ciudades->ver))
                    @if($permisos->administrativo->ciudades->ver==='on')
                        <li><a href="{{url('ciudades')}}">Ciudades <i class="fa fa-globe"></i></a></li>
                    @endif
                @endif

              <!-- <li class="dropdown-submenu" >
        					<a class="dropdown-toggle" data-toggle="dropdown">Mantenimiento <i class="fa fa-car"></i></a>
        						<ul class="dropdown-menu">
        						  <li><a href="{{url('mantenimiento/pre-operativa')}}">Pre-Operativa <i class="fa fa-server" aria-hidden="true"></i></i></a></li>
        						  <li><a href="{{url('mantenimiento/hv-vehiculos')}}">H.V. Vehiculos <i class="fa fa-users"></i></a></li>
        						  <li><a href="{{url('mantenimiento/etc')}}">etc <i class="fa fa-car"></i></a></li>
        						</ul>
        				</li> -->

              </ul>
            </li>
            @endif

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

            @if(isset($permisos->administracion->usuarios->ver))
                @if($permisos->administracion->usuarios->ver==='on')
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuarios <i class="fa fa-users"></i><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @if(isset($permisos->administracion->usuarios->ver))
                              @if($permisos->administracion->usuarios->ver==='on')
                                  <li><a href="{{url('usuarios')}}">Listado <i class="fa fa-user" aria-hidden="true"></i></a></li>
                              @endif
                            @endif
                        </ul>
                    </li>
                @endif
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
