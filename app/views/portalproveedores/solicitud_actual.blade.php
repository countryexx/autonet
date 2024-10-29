<html>
<head>
    <meta charset="UTF-8">
	<title>Autonet | Solicitud Actual</title>
    @include('scripts.styles')
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style type="text/css">
        .last_value{
            text-align: center;
            font-family: Bahnschrift;
            font-size: 13px
        }
        .usuario1{
            float: left;
        }

        .usuario2{
            float: right;
        }
    </style>
</head>
<body>
    @include('admin.menu')
    <div class="col-lg-12">

        @if($control!=null)
            <h3 class="h_titulo">ESTADO DE LA SOLICITUD ACTUAL</h3>
            <h5 id="{{$cuenta_id}}{{$cuenta_id}}{{$cuenta_id}}" style="float: left; margin-top: 2px; margin-bottom: 15px">@if($estado===0){{'<span style="background: red; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px; margin-top: 15px; margin-bottom: 15px"><b>PENDIENTE DE APROBACIÓN</b></span>'}}@elseif($estado===1){{'<span style="background: gray; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px;"><b>TIENES UNA CORRECCIÓN POR REVISAR</b></span>'}}@elseif($estado===2){{'<span style="background: orange; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px;"><b>RESPUESTA DE CORRECCIÓN ENVIADA</b></span>'}}@elseif($estado===3)<span style="background: green; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px;"><b>RADICADA CON N° <?php echo '0000'.$cuenta_id ?></b></span>@endif</h5>
            <!-- SI NO HAY NINGUNA CUENTA DE COBRO, NO SE EJECUTA ESTE CÓDIGO -->
            <table class="table table-striped table-bordered hover" id="rutas_ejecutadas">
                <thead>
                <tr style="background: gray; color: white">
                    <td>#</td>
                    <td>RUTA</td>
                    <td>RECOGER EN</td>
                    <td>DEJAR EN</td>
                    <td>FECHA</td>
                    <td>HORA</td>
                    <td>SITE</td>
                    <td>CONDUCTOR</td>
                    <td>VALOR</td>
                    <td>ACCIÓN</td>
                    <td>MSJ</td>
                </tr>
                </thead>
                <tbody>
                	<?php $i=1; $total=0; $total2 = 0; $nombre_anterior = ''; $cor = 0;?>
                @foreach($rutas_programadas as $ruta)
                        @if($nombre_anterior!=$ruta->razoncentro)
                            <tr>
                                <td colspan="11">{{$ruta->razoncentro}}</td>
                            </tr>
                        @endif
                    <tr data-id="{{$ruta->id}}" @if($ruta->aceptado_liquidado!=null){{'class="success"'}}@elseif($ruta->aceptado_liquidado!=null and $estado===1 or $estado===3){{'class="success"'}}@elseif($ruta->aceptado_liquidado===null and $ruta->estado_correccion===0 and $estado===1 or $estado===3){{'class="warning"'}}@elseif($estado===1){{'class="danger"'}}@elseif($ruta->estado_correccion===0 and $ruta->aceptado_liquidado===null and $estado===2){{'class="danger"'}}@endif >
                        <td data-id="{{$ruta->id}}">
                            <?php echo $i ?>
                        </td>

                        <td>
                        	<span>{{$ruta->detalle_recorrido}}</span>
                        </td>
                        <td style="width: 10%">
                        	<span>{{$ruta->recoger_en}}</span>
                        </td>
                        <td style="width: 10%">
                        	<span style="padding: 4px">{{$ruta->dejar_en}}</span>
                        </td>
                        <td>
                        	<span>{{$ruta->fecha_servicio}}</span>
                        </td>
                        <td>
                        	<span>{{$ruta->hora_servicio}}</span>
                        </td>
                        <td>
                            <a href>{{$ruta->nombresubcentro}}</a>
                        </td>
                        <td>
                            <a href>{{$ruta->nombre_completo}}</a>
                        </td>
                        <td>
                        	@if($ruta->valor_proveedor!=null)
                        		<?php $total = $total+$ruta->valor_proveedor; $t?>

                                <!-- NUEVA -->
                                @if($estado===0)
                                   <!-- CUENTA ENVIADA A CONTABILIDAD -->
                                @elseif($estado===1)
                                    <!-- RESPUESTA DE CORRECCIÓN AL PROVEEDOR -->
                                    @if($ruta->estado_correccion==2 and $ruta->aceptado_liquidado==1)
                                        <!-- SERVICIO APROBADO -->

                                        <span class="last_value">Valor Aprobado <i class="fa fa-check" style="color: green" aria-hidden="true"></i></span>

                                    @elseif($ruta->estado_correccion===2 and $ruta->aceptado_liquidado===null)
                                        <!-- CUANDO SE APROBÓ UN SERVICIO -->
                                        <span class="last_value" >Pendiente: <?php echo number_format($ruta->unitario_pagado_correccion).', <br> Valor Cobrado <i class="fa fa-arrow-down" style="color: red" aria-hidden="true"></i>' ?></span>

                                        <?php $cor=1; ?>

                                    @elseif($ruta->estado_correccion===3 and $ruta->aceptado_liquidado===1)
                                        <!-- CUANDO SE APROBÓ UN SERVICIO -->
                                        <span class="last_value" >Valor Cobrado: <?php echo number_format($ruta->unitario_pagado_correccion).',<br> Valor Corregido <i class="fa fa-arrow-down" style="color: green" aria-hidden="true"></i>'; ?></span>

                                    @elseif($ruta->estado_correccion===0 and $ruta->aceptado_liquidado===null)
                                        <!-- CUANDO SE APROBÓ UN SERVICIO -->
                                        <span class="last_value" >Corrección: <?php echo number_format($ruta->unitario_pagado_correccion).', <br> Valor nuevo Cobrado <i class="fa fa-arrow-right" style="color: orange" aria-hidden="true"></i>' ?></span>

                                    @endif

                                @elseif($estado===2)
                                    <!-- RESPUESTA DE CORRECCIÓN A CONTABILIDAD -->
                                    @if($ruta->estado_correccion===3 and $ruta->unitario_pagado_correccion!=null)
                                        <!-- CUANDO EL PROVEEDOR ACEPTA LA CORRECCIÓN -->
                                        <span class="last_value">Valor cobrado: <?php echo number_format($ruta->unitario_pagado_correccion).', <br> Valor Corregido <i class="fa fa-check" style="color: green" aria-hidden="true"></i>' ?></span>

                                    @elseif($ruta->estado_correccion===0 and $ruta->aceptado_liquidado===null)
                                        <!-- CUANDO SE APROBÓ UN SERVICIO -->
                                        <span class="last_value" >Corrección: <?php echo number_format($ruta->unitario_pagado_correccion).', <br> Valor nuevo Cobrado <i class="fa fa-arrow-right" style="color: orange" aria-hidden="true"></i>' ?></span>

                                    @elseif($ruta->estado_correccion==2 and $ruta->aceptado_liquidado==1)

                                    <!-- CUANDO SE APROBÓ UN SERVICIO -->
                                    <span class="last_value" >Valor Aprobado: <i class="fa fa-check" style="color: green" aria-hidden="true"></i></span>

                                    @elseif($ruta->estado_correccion===2 and $ruta->aceptado_liquidado===null)
                                        <!-- PENDIENTE POR REVISAR EN CONTABILIDAD -->
                                        <span class="last_value" >Pendiente: <?php echo number_format($ruta->unitario_pagado_correccion).', <br> Valor Cobrado <i class="fa fa-arrow-down" style="color: red" aria-hidden="true"></i>' ?></span>

                                        <?php $cor=1; ?>

                                    @endif
                                @endif
                                <!-- NUEVA -->

                        		<input type="text" disabled="true" class="form-control input-font valor_cobrado1" id="valor_cobrado" data-original="{{$ruta->valor_proveedor}}" valor-correccion="{{$ruta->unitario_pagado_correccion}}" placeholder="Ingresar valor" value="{{$ruta->valor_proveedor}}">

                                <!--<button type="submit" style="margin-bottom: 5px; margin-top: 5px;" class="btn btn-warning">VER<i class="fa fa-file-pdf-o icon-btn" aria-hidden="true"></i></button>-->

                        	@else
                        		<input type="text" class="form-control input-font valor_cobrado1" id="valor_cobrado" placeholder="Ingresar valor">
                            <div class="alert_planilla"></div>
                        	@endif
                        </td>
                        <td>
                            <!-- BOTÓN OK -->
                            @if( ($ruta->aceptado_liquidado===null and $estado===1) and $ruta->estado_correccion!=0 )
                                <a title="Aceptar el nuevo valor." id="aceptar_correc" data-id="{{$ruta->servicio_id}}" data-cuenta="{{$cuenta_id}}" nombre="" class="btn btn-primary aceptar_correc"><i class="fa fa-check-circle" aria-hidden="true"></i></a>
                            @else
                                <a id="aceptar_correc" data-id="{{$ruta->servicio_id}}" data-cuenta="{{$cuenta_id}}" nombre="" class="btn btn-primary aceptar_correc disabled"><i class="fa fa-check-circle" aria-hidden="true"></i></a>
                            @endif

                            <!-- BOTÓN NO -->
                            @if( ($ruta->aceptado_liquidado===null and $estado===1) and  $ruta->estado_correccion!=0)
                                <a title="Mantener el valor cobrado inicialmente." id="no_correccion" data-id="{{$ruta->servicio_id}}" data-cuenta="{{$cuenta_id}}" nombre="" class="btn btn-danger no_correccion"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                            @else
                                <a id="no_correccion" data-id="{{$ruta->servicio_id}}" data-cuenta="{{$cuenta_id}}" nombre="" class="btn btn-danger no_correccion disabled"><i class="fa fa-times" aria-hidden="true"></i></a>
                            @endif

                            <!--BOTONES DE EDÍCIÓN-->

                                <!-- TEST BOTÓN GUARDAR -->
                                <a title="GUARDAR NUEVO VALOR." id="rechazar_liquidado" data-id="{{$ruta->id}}" data-cuenta="{{$cuenta_id}}" nombre="" class="btn btn-primary nuevo_valorv2 hidden"><i class="fa fa-save" aria-hidden="true"></i></a>
                                <!-- TEST BOTÓN GUARDAR -->

                                <!-- TEST BOTÓN DEVOLVERSE -->
                                <a title="CANCELAR CAMBIO DE VALOR." id="rechazar_liquidado" data-id="{{$ruta->id}}" data-cuenta="{{$ruta->id}}" nombre="" class="btn btn-dark atrasv2 hidden"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                                <!-- TEST BOTÓN DEVOLVERSE -->

                            <!-- BOTONES DE EDICIÓN -->
                        </td>
                        <td>
                            @if($ruta->conversacion!=null and $estado===1 or $estado===3)
                                <a id="ver_motivo" option="2" data-id="{{$ruta->servicio_id}}" data-cuenta="{{$cuenta_id}}" class="btn btn-dark ver_motivo"><i class="fa fa-comment" aria-hidden="true"></i></a>
                            @endif
                        </td>
                    </tr>
                    <?php $i++; $nombre_anterior = $ruta->razoncentro; ?>
                @endforeach
                </tbody>
            </table>

            <!-- REALIZAR ENLACES DE AP CON PAGO_PROVEEDORES EN LA APROBACIÓN DE LOS VALORES -->
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="panel panel-default" style="margin-top: 20px; margin-bottom: 0px;">
                              <div class="panel-heading">
                                <strong>TOTALES</strong>
                                @if($estado!=3)
                                    <i class="fa fa-clock-o icon-btn" style="margin-left: 25px"></i>
                                @else
                                    <i class="fa fa-clock-o icon-btn" style="margin-left: 25px"></i>
                                @endif
                              </div>
                              <div class="panel-body" style="margin-bottom: 40px">
                                    <table style="margin-bottom: 0px;" class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                @if($total!=0)
                                                    <td>TOTAL GENERADO</td>
                                                    <td>
                                                        <span class="span-total" id="valor_total"><?php echo '$ '. number_format($total)?></span>
                                                    </td>
                                                @else
                                                    <td>TOTAL A COBRAR</td>
                                                    <td>
                                                        <span class="span-total" id="valor_total">$ 0</span>
                                                    </td>
                                                @endif
                                            </tr>
                                            @if(1==3)
                                                <tr style="margin-top: 25px">
                                                    @if($total!=0)
                                                        <td>TOTAL CON LAS CORRECCIONES</td>
                                                        <td><span class="span-total" id="valor_total"><?php echo '$ '. number_format($total2)?></span></td>
                                                    @endif
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-5 col-xs-offset-3" style="margin-bottom:10px;">
                        <div class="row" style="float: right;">

                            @if($estado==1 and $cor==0)

                                <a style="float: right;" data-cuenta="{{$cuenta_id}}" id="enviar_correccion_ok" centrodecosto="" class="btn btn-success btn-icon input-font">Enviar<i class="fa fa-check icon-btn" style="margin-left: 25px"></i></a>
                            @else

                                <a style="float: right;" data-cuenta="{{$cuenta_id}}" id="enviar_correccion_ok" centrodecosto="" class="btn btn-success btn-icon input-font disabled">Enviar<i class="fa fa-check icon-btn" style="margin-left: 25px"></i></a>

                            @endif


                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="jumbotron" style="padding-left: 48px; padding-right: 48px">
                            <h1>NO DISPONIBLE</h1>
                            <p>Actualmente usted no dispone de solicitud en proceso.</p>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- REALIZAR LOS CONTROLES PARA APROBAR LAS CUENTAS DE COBRO Y GENERACIÓN DE LAERTAS -->
    </div>

    <!-- MODAL CONVERSACIÓN -->
    <div class="modal fade" tabindex="-1" role="dialog" id='modal_conversacion'>
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #44AB2D">
                <span style="font-size: 18px">Comentarios <i class="fa fa-commenting" aria-hidden="true"></i></span>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row conversacion">

                </div>
            </div>
        </div>
      </div>
    </div>

    <div id="motivo_eliminacion" class="hidden">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Confirmar</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>Describa la razón por la cual está realizando la modificación de valor</label>
                        <textarea id="descripcion" cols="40" rows="10" class="form-control input-font"></textarea>
                    </div>
                    <a id="nuevo_valor2v2" class="btn btn-primary btn-icon">Realizar<i class="fa fa-check icon-btn"></i></a>
                    <a id="cancelarv2" class="btn btn-warning btn-icon">Cancelar<i class="fa fa-close icon-btn"></i></a>
                </div>
            </div>

        </div>
    </div>
    @include('otros.pushercontabilidad')

    @include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/portalproveedores.js')}}"></script>
    <script>
        $('table a').click(function (e) {
            e.preventDefault();
        });

        $('#rutas_ejecutadas').on('click', '.aceptar_correc', function(event) {
        //$('.aceptar_correc').click(function(){

            var cuenta_id = $(this).attr('data-cuenta');//OBTENER EL ID DE LA CUENTA PARA LA POSTERIOR CONSULTA
            var id_servicio = $(this).attr('data-id');//OBTENER EL ID DEL SERVICIO PARA BUSCARLO EN LA TABLA DE FACTURACIÓN

            $.confirm({
              title: 'Confirmación',
              content: 'Confirma la corrección del valor?',
              buttons: {
                  confirm: {
                      text: 'SI',
                      btnClass: 'btn-success',
                      keys: ['enter', 'shift'],
                      action: function(){

                        $.ajax({
                          url: 'aceptarcorreccion',
                          method: 'post',
                          data: {
                            cuenta_id: cuenta_id,//ID DE CUENTA
                            id_servicio: id_servicio,//ID DE SERVICIO
                          },
                          dataType: 'json',
                        }).done(function(data){
                          //SI SE PROCESA TODA LA INFORMACIÓN DE FORMA CORRECTA, ENTRA AL TRUE.
                          if (data.respuesta===true) {
                            location.reload();
                          //SI HAY ALGÚN PROBLEMA EN EL SERVER, ENTRA AL FALSE.
                          }else if (data.respuesta===false) {
                            alert('Error en el proceso!');
                          }
                        });
                        //FIN DE CÓDIGO AJAX
                      }
                  },
                  cancel: {
                    text: 'NO',
                  }
              }
            });
          });

          $('#rutas_ejecutadas').on('click', '.no_correccion', function(event) {
          //$('.no_correccion').click(function(){

            var id = $(this).attr('data-id');

            $('#rutas_ejecutadas tbody tr').each(function (index) {//RECORRIDO POR TODA LA TABLA PARA BUSCAR LA FILA SELECCIONADA
              if($(this).attr('data-id')==id){
                $(this).addClass('danger');
                var value = $(this).find('td').eq(8).find('.valor_cobrado1').val();

                $(this).find('td').eq(8).find('.valor_cobrado1').removeAttr('disabled','disabled');
                $(this).find('td').eq(9).find('.aceptar_correc').addClass('hidden');
                $(this).find('td').eq(9).find('.no_correccion').addClass('hidden');

                $(this).find('td').eq(9).find('.nuevo_valorv2').attr('valor-servicio',value).removeClass('hidden');
                $(this).find('td').eq(9).find('.atrasv2').attr('valor-servicio',value).removeClass('hidden');
              }else{
                if(!$(this).find('td').eq(9).find('.no_correccion').hasClass('disabled')){
                  $(this).find('td').eq(9).find('.no_correccion').addClass('disabled','disabled');
                }
              }
            });
          });

    </script>
</body>
</html>
