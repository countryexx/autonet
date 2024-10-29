<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Vehiculos</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('dropzonejs/dist/dropzone.css')}}">
</head>
<body>
@include('admin.menu')
<div class="col-lg-12">

    <h3 class="h_titulo">VEHICULO {{$vehiculos->placa}}</h3>
    <?php $sw = 0; ?>
    <!-- -->
    <div class="panel panel-default">
      <div class="panel-heading" style="background: #f98006">
        <div class="row">
          <div class="col-md-9">
            <span style="font-size: 40px;">FOTOS E INFORMACIÓN</span>
          </div>
          <div class="col-md-2">
            <i class="fa fa-check" aria-hidden="true" style="font-size: 40px; color: green"></i>
            @if($vehiculos->autorizado_tecnomecanica===1)<!-- ESTADO TECNOMECÁNICA -->
              <i class="fa fa-check" aria-hidden="true" style="font-size: 40px; color: green"></i>
            @elseif($vehiculos->autorizado_tecnomecanica===2)
              <i class="fa fa-times" aria-hidden="true" style="font-size: 40px; color: red"></i>
            @else
              <i class="fa fa-clock-o" aria-hidden="true" style="font-size: 40px; color: white"></i>
              <?php $sw = 1; ?>
            @endif

            @if($vehiculos->autorizado_soat===1) <!-- ESTADO SOAT -->
              <i class="fa fa-check" aria-hidden="true" style="font-size: 40px; color: green"></i>
            @elseif($vehiculos->autorizado_soat===2)
              <i class="fa fa-times" aria-hidden="true" style="font-size: 40px; color: red"></i>
            @else
              <i class="fa fa-clock-o" aria-hidden="true" style="font-size: 40px; color: white"></i>
              <?php $sw = 1; ?>
            @endif

            @if($vehiculos->autorizado_tp===1)<!-- ESTADO TARJETA DE PROPIEDAD -->
              <i class="fa fa-check" aria-hidden="true" style="font-size: 40px; color: green"></i>
            @elseif($vehiculos->autorizado_tp===2)
              <i class="fa fa-times" aria-hidden="true" style="font-size: 40px; color: red"></i>
            @else
              <i class="fa fa-clock-o" aria-hidden="true" style="font-size: 40px; color: white"></i>
              <?php $sw = 1; ?>
            @endif

            @if($vehiculos->autorizado_to===1) <!-- ESTADO TARJETA DE OPERACIÓN -->
              <i class="fa fa-check" aria-hidden="true" style="font-size: 40px; color: green"></i>
            @elseif($vehiculos->autorizado_to===2)
              <i class="fa fa-times" aria-hidden="true" style="font-size: 40px; color: red"></i>
            @else
              <i class="fa fa-clock-o" aria-hidden="true" style="font-size: 40px; color: white"></i>
              <?php $sw = 1; ?>
            @endif
          </div>
          <div class="col-md-1">
            @if($estado===1)
              <i class="fa fa-check" aria-hidden="true" style="font-size: 70px; color: green"></i>
            @else
              <i class="fa fa-clock-o" aria-hidden="true" style="font-size: 70px; color: white"></i>
            @endif

          </div>
        </div>
      </div>
        <div class="panel-body" style="height: 100%; background: #DADDE7">
          <div class="row">
              <!-- Fin división #1 -->
              <div class="col-md-6" style="border: 2px solid orange; height: 580px">
                <h1 class="h_titulo">Fotos</h1>
                <div class="row">
                  <div class="col-md-6">
                    <a target="_blank" href="{{url('biblioteca_imagenes/prov_nuevos/documentacion/'.$vehiculos->foto_frontal)}}"><img src="{{url('biblioteca_imagenes/prov_nuevos/documentacion/'.$vehiculos->foto_frontal)}}" width="320px" height="250px"></a>
                  </div>
                  <div class="col-md-6">
                    <a target="_blank" href="{{url('biblioteca_imagenes/prov_nuevos/documentacion/'.$vehiculos->foto_dorso)}}"><img src="{{url('biblioteca_imagenes/prov_nuevos/documentacion/'.$vehiculos->foto_dorso)}}" width="320px" height="250px"></a>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <a target="_blank" href="{{url('biblioteca_imagenes/prov_nuevos/documentacion/'.$vehiculos->foto_derecha)}}"><img src="{{url('biblioteca_imagenes/prov_nuevos/documentacion/'.$vehiculos->foto_derecha)}}" width="320px" height="250px"></a>
                  </div>
                  <div class="col-md-6">
                    <a target="_blank" href="{{url('biblioteca_imagenes/prov_nuevos/documentacion/'.$vehiculos->foto_izquierda)}}"><img src="{{url('biblioteca_imagenes/prov_nuevos/documentacion/'.$vehiculos->foto_izquierda)}}" width="320px" height="250px"></a>
                  </div>
                </div>
              </div>
              <!-- Fin división #2 -->
              <div class="col-md-6" style="border: 2px solid orange; height: 580px">
                <h1 class="h_titulo">Información</h1>
                <div class="row">
                  <div class="col-md-10">

                    <table cellspacing="0" id="table_detalle_solicitud" style="width: 120%;" border="1">
                    <thead>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">PLACA</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$vehiculos->placa}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">INFO VEHÍCULO</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$vehiculos->clase}} / {{$vehiculos->marca}} // {{$vehiculos->linea}} // {{$vehiculos->color}} // {{$vehiculos->modelo}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">NÚMERO INTERNO / NÚMERO DEL MOTOR</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$vehiculos->numero_interno}} / {{$vehiculos->numero_motor}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">CAPACIDAD</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$vehiculos->capacidad}} PASAJEROS</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                      <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">CILINDRAJE</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$vehiculos->cilindraje}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                      <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">TARJETA DE PROPIEDAD</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$vehiculos->tarjeta_propiedad}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 6px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">VIGENCIA TARJETA DE PROPIEDAD</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$vehiculos->fecha_vigencia_tp}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 6px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">TARJETA DE OPERACIÓN</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$vehiculos->tarjeta_operacion}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 6px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">VIGENCIA TARJETA DE OPERACIÓN</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$vehiculos->fecha_vigencia_to}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 6px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">VIGENCIA SOAT</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$vehiculos->vigencia_soat}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 6px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">VIGENCIA TECNOMECÁNICA>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$vehiculos->vigencia_tecnomecanica}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 6px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">PROPIETARIO
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$vehiculos->propietario}} / {{$vehiculos->cc_propietario}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 6px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">VIN
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$vehiculos->vin}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 6px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">EMPRESA AFILIADA
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$vehiculos->empresa_afiliada}}</th>
                      </tr>
                    </thead>

                  </table>

                  </div>

                </div>
              </div>
          </div>

        </div>
    </div>
    <!-- -->
    <div class="panel panel-default">
      <div class="panel-heading" style="background: #f98006"><span style="font-size: 40px">DOCUMENTACIÓN PDF</span></div>
        <div class="panel-body" style="height: 200%; background: white">
          <div class="row">

            <div class="col-md-12">
              <span style="font-family: monospace; font-size: 25px">TECNOMECÁNICA
              </span>
              <iframe src="{{url('biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/'.$vehiculos->tecnomecanica_pdf)}}" width="100%" height="40%"></iframe>
            </div>

            <div class="col-md-12" style="margin-top: 40px">
              <span style="font-family: monospace; font-size: 25px">SOAT</span>
              <iframe src="{{url('biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/'.$vehiculos->soat_pdf)}}" width="100%" height="40%"></iframe>
            </div>
          </div>

          <div class="row" style="margin-top: 40px">
            <div class="col-md-12">
              <span style="font-family: monospace; font-size: 25px"> TARJETA DE PROPIEDAD</span>
              <iframe src="{{url('biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/'.$vehiculos->tarjeta_propiedad_pdf)}}" width="100%" height="40%"></iframe>
            </div>

            <div class="col-md-12" style="margin-top: 40px">
              <span style="font-family: monospace; font-size: 25px"> TARJETA DE OPERACIÓN

              </span>
              <iframe src="{{url('biblioteca_imagenes/prov_nuevos/documentacion/vehiculos/'.$vehiculos->tarjeta_operacion_pdf)}}" width="100%" height="40%"></iframe>
            </div>

            @if(1>0)
              <button style="margin-top: 20px; margin-right: 10px; float: right; margin-bottom: 30px;" data-value="{{$id}}" class="btn btn-success disabled">GUARDAR DATOS <i class="fa fa-check" aria-hidden="true"></i></button>
            @elseif($sw===0)
              <button style="margin-top: 20px; margin-right: 10px; float: right; margin-bottom: 30px;" data-value="{{$id}}" class="btn btn-success aprobar_vehiculo">GUARDAR DATOS <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>
            @endif

          </div>
        </div>
      </div>

      <!-- MODAL PDF -->
      <div class="modal fade" tabindex="-1" role="dialog" id='modal_pdf'>
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header" style="background: #079F33">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="text-align: center;" id="name">INGRESO SEGURIDAD SOCIAL</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-5">
                        <input name="numero_planilla" id="numero_planilla" type='text' class="form-control input-font" value="" placeholder="NÚMERO DE PLANILLA">
                  </div>
                  <div class="col-md-3">
                    <div class='input-group date' id='datetimepicker1'>
                        <input name="fecha_inicial" id="fecha_inicial_t" style="width: 100px;" type='text' class="form-control input-font" value="" placeholder="Fecha INICIAL">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class='input-group date' id='datetimepicker2'>
                        <input name="fecha_final" id="fecha_final_t" style="width: 100px;" type='text' class="form-control input-font" value="" placeholder="Fecha FINAL">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <div class="row">
                  <div class="col-md-2 col-md-offset-10">
                    <button type="button" class="btn btn-primary confirmar_documento_correcto" style="float: left;">GUARDAR</button>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>
@include('scripts.scripts')
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="{{url('jquery/portalproveedores.js')}}"></script>

<script type="text/javascript">
    function goBack(){
        window.history.back();
    }
</script>
</body>
</html>
