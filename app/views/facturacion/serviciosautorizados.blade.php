<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <title>Autonet | Servicios Autorizados</title>
    @include('scripts.styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  </head>
  <body>
    @include('admin.menu')
    <div class="col-lg-12">
      <div class="col-lg-12">
        <div class="row">
            @include('facturacion.menu_facturacion')
        </div>
      </div>
      <div class="col-lg-12">
    		<div class="row">
    		  <h3 class="h_titulo">FACTURAS AUTORIZADAS</h3>
    		</div>
    	</div>

      <?php
    		$fechaActual = date('Y-m-d');
    		$horaActual = date('H:i:s');
    		$token = DB::table('siigo')->where('id',1)->first();
    		$newDate = date("d/m/Y", strtotime($token->fecha_vence));
    	?>
    	@if( ($fechaActual<$token->fecha_vence) or ( $fechaActual==$token->fecha_vence and $horaActual<=$token->hora_vence) )
    		<div class="col-lg-12" style="margin-bottom: 20px">
    			<div class="row">
    	  		<span style="font-size: 15px; ">El token tiene validez hasta el: <b style="font-size: 20px; ">{{$newDate}}</b> a las <b style="font-size: 20px; ">{{$token->hora_vence}}</b></span>
    				<a class="btn btn-list-table btn-primary actualizar_token" style="margin-left: 5px">Actualizar Token de Siigo <i class="fa fa-refresh" aria-hidden="true"></i></a>
    				<img class="loader hidden" src="{{url('img/loaders.gif')}}" alt="" height="20px" width="20px">
    			</div>
    		</div>
    	@else
    		<div class="col-lg-12">
    			<div class="row">
    				<span>El token venció el: <b style="font-size: 20px; ">{{$newDate}}</b> a las <b style="font-size: 20px; ">{{$token->hora_vence}}</b></span>
    				<a class="btn btn-list-table btn-danger actualizar_token" style="margin-left: 5px">Actualizar Token de Siigo <i class="fa fa-refresh" aria-hidden="true"></i></a>
    				<img class="loader hidden" src="{{url('img/loaders.gif')}}" alt="" height="20px" width="20px">
    			</div>
    		</div>
    	@endif

      <form class="form-inline" id="form_buscar" method="post">
          <div class="col-lg-12" style="margin-bottom: 5px">
              <div class="row">
                  <div class="form-group">
                      <select id="centrodecosto_search" style="width: 164px;" class="form-control input-font" name="centrodecosto">
                          <option value="0">CENTROS DE COSTO</option>
                          @if(isset($centrosdecosto))
  	                        @foreach($centrosdecosto as $centrodecosto)
  	                            <option value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
  	                        @endforeach
  	                    @endif
                      </select>
                  </div>
                  <div class="form-group">
                      <select id="subcentrodecosto_search" style="width: 80px;" class="form-control input-font" name="subcentrodecosto">
                          <option value="0">-</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <select id="ciudades" style="width: 107px;" name="ciudades" class="form-control input-font">
                          <option>CIUDADES</option>
                          @if(isset($ciudades))
  	                        @foreach($ciudades as $ciudad)
  	                            <option>{{$ciudad->ciudad}}</option>
  	                        @endforeach
  	                    @endif
                      </select>
                  </div>
                  <button data-option="2" id="buscar_liquidaciones" class="btn btn-default btn-icon input-font">
                      Buscar<i class="fa fa-search icon-btn"></i>
                  </button>
              </div>
          </div>
      </form>
      <table id="example7" class="table table-hover table-bordered">
          <thead>
            <th>Consecutivo</th>
            <th>Fecha Inicial</th>
            <th>Fecha Final</th>
            <th>Fecha Registro</th>
            <th>Cliente</th>
            <th>Ciudad</th>
            <th>Total Facturado</th>
            <th>Total Costo</th>
            <th>Total Utilidad</th>
            <th>Detalles</th>
          </thead>
          <tbody>
			@foreach($otros_servicios as $otros_serv)
              <tr>
                <td>{{$otros_serv->consecutivo}}</td>
                <td>{{$otros_serv->fecha_orden}}</td>
                <td>{{$otros_serv->fecha_orden}}</td>
                <td>{{$otros_serv->created_at}}</td>
                <td>{{$otros_serv->razonsocial.' / '.$otros_serv->nombresubcentro}}</td>
                <td>{{$otros_serv->ciudad}}</td>
                <td>$ {{number_format($otros_serv->total_ingresos_propios+$otros_serv->total_costo-$otros_serv->descuento)}}</td>
                <td>$ {{number_format($otros_serv->total_costo)}}</td>
                <td>$ {{number_format($otros_serv->total_utilidad)}}</td>
                <td>
                    @if($permisos->facturacion->autorizar->generar_factura==='on')
                        <a data-id="{{$otros_serv->id}}" data-nit="{{$otros_serv->nit}}" data-client="{{$otros_serv->razonsocial}}" data-centro="{{$otros_serv->id_centro}}" f-inicial="{{$otros_serv->fecha}}" f-final="{{$otros_serv->fecha}}" data-ciudad="{{$otros_serv->ciudad}}" data-observa="{{$otros_serv->concepto}}" class="btn btn-list-table btn-primary generar_facturas2">Vista Previa</a>
                    @else
                        <a class="btn btn-list-table btn-primary disabled">Vista Previa</a>
                    @endif
					<a href="{{url('facturacion/verdetalleotros/'.$otros_serv->id)}}" class="btn btn-info btn-list-table">DETALLES</a>
                </td>
              </tr>
            @endforeach
            @foreach($liquidaciones as $liquidacion)
              <tr @if ($liquidacion->afiliado_externo==1) {{'class="info"'}} @endif>
                <td>{{$liquidacion->consecutivo}}<br>@if($liquidacion->razonsocial=='SGS COLOMBIA HOLDING BARRANQUILLA' or $liquidacion->razonsocial=='SGS COLOMBIA HOLDING BOGOTA'){{$liquidacion->kilometraje.' KM<br>'.$liquidacion->kilometraje_rutas.' KM'}}@endif</td>
                <td>{{$liquidacion->fecha_inicial}}</td>
                <td>{{$liquidacion->fecha_final}}</td>
                <td>{{$liquidacion->fecha_registro}}</td>
                <td>{{$liquidacion->razonsocial.' / '.$liquidacion->nombresubcentro}}</td>
                <td>{{$liquidacion->ciudad}}</td>
                <td>$ {{number_format($liquidacion->total_facturado_cliente)}}</td>
                <td>$ {{number_format($liquidacion->total_costo)}}</td>
                <td>$ {{number_format($liquidacion->total_utilidad)}}</td>
                <td>
                  @if($liquidacion->dividida===1)
                    @if($permisos->facturacion->autorizar->generar_factura==='on')
                        <a data-id="{{$liquidacion->id_detalle}}" class="btn btn-list-table btn-primary generar_factura_dividida">Vista Previa</a>
                    @else
                        <a class="btn btn-list-table btn-primary disabled">Vista Previa</a>
                    @endif
                    <a href="detallesautorizaciondividida/{{$liquidacion->id}}" class="btn btn-list-table btn-info">DETALLES</a>
                    <a href="exportarof/{{$liquidacion->id}}" class="btn btn-list-table btn-success">EXCEL</a><br>
                  @else
                    @if($permisos->facturacion->autorizar->generar_factura==='on')
                        <a data-km="{{$liquidacion->kilometraje}}" data-km-rutas="{{$liquidacion->kilometraje_rutas}}" data-ejecutivos="{{$liquidacion->cantidad_ejecutivos}}" data-rutas="{{$liquidacion->cantidad_rutas}}" data-id="{{$liquidacion->id}}" data-nit="{{$liquidacion->nit}}" data-client="{{$liquidacion->razonsocial}}" data-centro="{{$liquidacion->id_centro}}" f-inicial="{{$liquidacion->fecha_inicial}}" f-final="{{$liquidacion->fecha_final}}" data-ciudad="{{$liquidacion->ciudad}}" data-expediente="{{$liquidacion->expediente}}" data-observa="{{$liquidacion->observaciones}}" class="btn btn-list-table btn-primary generar_facturas">Vista Previa</a>

                        <!--<button type="button" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal">Agregar<i class="fa fa-plus icon-btn"></i></button>-->

                    @else
                        <a class="btn btn-list-table btn-primary disabled">Vista Previa</a>
                    @endif
                    <a href="detallesautorizacion/{{$liquidacion->id}}" class="btn btn-list-table btn-info">DETALLES</a>
                    <a href="exportarof/{{$liquidacion->id}}" class="btn btn-list-table btn-success">EXCEL</a><br>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>

          <tfoot>
            <th>Consecutivo</th>
            <th>Fecha Inicial</th>
            <th>Fecha Final</th>
            <th>Fecha Registro</th>
            <th>Cliente</th>
            <th>Ciudad</th>
            <th>Total Facturado</th>
            <th>Total Costo</th>
            <th>Total Utilidad</th>
            <th>Detalles</th>
          </tfoot>
        </table>
    </div>

    <div class="modal fade mymodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="factu">
        <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                        <center><strong>VISTA PREVIA DE FACTURA</strong></center>
                    </div>
                    <div class="modal-body">

                        <table cellpadding="0" cellspacing="0" role="presentation" width="100%">

                          <tr>

                            <td style="width: 20%;">
                              <p style="color: #929292; text-align:left">
                                <b style="color: #f47321; font-size: 20px;">NIT:</b> <br> <b id="nit"></b>
                              </p>
                            </td>

                            <td style="width: 20%;">
                              <p style="color: #929292; text-align:left">
                                <b style="color: #f47321; font-size: 20px;">Forma de Pago:</b> <br> <b id="f_pago"></b>

                                <!--Formas de Pago Producción -->
                                <select class="selectpicker" id="forma_pago" data-show-subtext="true" data-live-search="true">
                                  <option data-subtext="Seleccionar" id="0">Forma de Pago</option>
                                  <option value="30577">CONTADO</option>
                                  <option value="28363">Credito</option>
                                </select>

                                <!--<select class="selectpicker" id="forma_pago" data-show-subtext="true" data-live-search="true">
                                  <option data-subtext="Seleccionar" id="0">Forma de Pago</option>
                                  <option value="8709">Credito</option>
                                  <option value="8683">Contado</option>
                                </select>-->





                              </p>

                            </td>
                            <?php

                              $fecha = date('Y-m-d');

                              $treintadias = strtotime('+15 day', strtotime($fecha));
                              $treintadias = date('Y-m-d' , $treintadias);

                            ?>

                            <td style="width: 20%;">

                              <p style="color: #929292; text-align:left" class=" rang hidden">
                                <b style="color: #f47321; font-size: 20px;">Fechas:</b> <br> <b id="f_pago"></b>
                                <select class="selectpicker" id="rangos" data-show-subtext="true" data-live-search="true">
                                  <option data-subtext="Seleccionar" id="0">Fechas</option>
                                  <option value="0">Rango</option>
                                  <option value="15">15 días</option>
                                  <option value="30">30 días</option>
                                </select>

                              </p>

                            </td>

                            <td style="width: 20%;">
                              <input type="checkbox" id="noica" name="noica" class="noica">
                              <label for="vehicle1"> No Aplicar ReteICA </label>
                              <br>
                              <input type="checkbox" id="norete" name="norete" class="norete">
                              <label for="vehicle1"> No Aplicar Retefuente </label>

                            </td>

                          </tr>

                          <tr>

                            <td style="width: 20%;">
                              <p style="color: #929292; text-align:left">
                                <b style="color: #f47321; font-size: 20px;">Cliente:</b> <br> <b id="client"></b>
                              </p>
                            </td>

                            <td style="width: 20%;">
                              <div class="form-group fech hidden">
                                <p style="color: #929292; text-align:left">
                                  <b style="color: #f47321; font-size: 15px;">Fecha de Factura:</b>
                                </p>
                                <div class="input-group">
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input name="fecha_factura" id="fecha_factura" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar">
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            </td>

                            <td style="width: 20%;">
                              <div class="form-group fech hidden">
                                  <p style="color: #929292; text-align:left">
                                    <b style="color: #f47321; font-size: 15px;">Fecha de Vencimiento:</b>
                                  </p>
                                  <div class="input-group">
                                      <div class='input-group date' id='datetimepicker1'>
                                          <input name="fecha_vencimiento" id="fecha_vencimiento" style="width: 89px;" type='text' class="form-control input-font" value="{{$treintadias}}">
                                          <span class="input-group-addon">
                                              <span class="fa fa-calendar">
                                              </span>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                            </td>

                          </tr>

                          <tr>

                            <td style="width: 20%;">
                              <p style="color: #929292; text-align:left">
                                <input type="checkbox" id="copy_obs" name="copy_obs" class="copy_obs">
                                <label for="vehicle1"> Copiar observaciones </label>
                              </p>
                            </td>

                            <td style="width: 20%;">
                              <p style="color: #929292; text-align:left">

                              </p>
                            </td>

                            <td style="width: 20%;">
                              <p style="color: #929292; text-align:left">

                              </p>
                            </td>

                          </tr>

                        </table>

                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="row">
                                <div class="col-xs-12">
                                    <b style="color: #f47321; font-size: 20px;">Descripción:</b> <br> <b id="Descripcion"></b>
                                      <textarea class="form-control input-font" rows="10" type="text" id="observa" ></textarea>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-xs-12">

                          </div>
                        </div>
                    <div class="modal-footer">

                        <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Volver<i class="fa fa-times icon-btn"></i></a>

                        <button id="generar_facturass" class="btn btn-primary btn-icon hidden generar_facturass">Generar Factura<i class="fa fa-floppy-o icon-btn"></i></button>
                        <button id="generar_facturass2" class="btn btn-primary btn-icon hidden generar_facturass2">Generar Factura O<i class="fa fa-floppy-o icon-btn"></i></button>

                    </div>
                </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    @include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/facturacion.js')}}"></script>

    <script type="text/javascript">

      $('#datetimepicker1, #datetimepicker2').datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD',
        icons: {
            time: 'glyphicon glyphicon-time',
            date: 'glyphicon glyphicon-calendar',
            up: 'glyphicon glyphicon-chevron-up',
            down: 'glyphicon glyphicon-chevron-down',
            previous: 'glyphicon glyphicon-chevron-left',
            next: 'glyphicon glyphicon-chevron-right',
            today: 'glyphicon glyphicon-screenshot',
            clear: 'glyphicon glyphicon-trash',
            close: 'glyphicon glyphicon-remove'
        }
      });

      $('#example7').on('click', '.generar_factura_otross', function () {

          var id = $(this).attr('data-id');
          $(this).addClass('disabled');

          $.ajax({
              url: 'facturacionotroservicios',
              method: 'post',
              data: {
                  'id': id
              },
              dataType: 'json',
          })
          .done(function(data){
              if (data.respuesta===true){
                  alert('Factura Generada! '+data.consecutivo);
                  location.reload();
              }else if(data.respuesta===false){

        			}
          });
    });

      $('#rangos').change(function(){

        var rangos = $('#rangos option:selected').html();

        if(rangos==='Rango'){
          $('.fech').removeClass('hidden')
        }else if(rangos==='Fechas'){
          $('.fech').addClass('hidden')
        }else{ //Nada seleccionado
          $('.fech').addClass('hidden')
        }
        console.log( $('#rangos option:selected').html() )

      });

      $('#forma_pago').change(function(){

        var forma_pago = $('#forma_pago option:selected').html();

        if(forma_pago==='Credito'){
          $('.rang').removeClass('hidden')
        }else if(forma_pago==='Contado'){
          $('.rang').addClass('hidden')
          $('.fech').addClass('hidden')
        }else{ //Nada seleccionado
          $('.rang').addClass('hidden')
          $('.fech').addClass('hidden')
        }
        console.log( $('#forma_pago option:selected').html() )

      });

      $('#example7').on('click', '.generar_facturas', function(){

        $('#generar_facturass').attr('data-id', $(this).attr('data-id')).removeClass('hidden');
        $('#generar_facturass2').addClass('hidden');

        $('.copy_obs').attr('data-observ', $(this).attr('data-observa'));

        var cliente = $(this).attr('data-client');
        var cc = $(this).attr('data-centro');
        var expediente = $(this).attr('data-expediente');
        var nit = $(this).attr('data-nit');
        var km = $(this).attr('data-km');
        var kmr = $(this).attr('data-km-rutas');
        var ejecutivos = $(this).attr('data-ejecutivos');
        var rutas = $(this).attr('data-rutas');

        var fechainicial = $(this).attr('f-inicial');
        var fechafinal = $(this).attr('f-final');

        if(fechainicial>fechafinal){
          //console.log('la fecha final es menor a la fecha inciial')
        }

        var ciudad = $(this).attr('data-ciudad');

        if(fechainicial===fechafinal){

          const fecha = fechainicial.split("-");

          var dia = fecha[2];
          var mes = fecha[1];
          var ano = fecha[0];

          if(mes==='01'){
              mes = 'ENERO';
          }else if(mes==='02'){
              mes = 'FEBRERO';
          }else if(mes==='03'){
              mes = 'MARZO';
          }else if(mes==='04'){
              mes = 'ABRIL';
          }else if(mes==='05'){
              mes = 'MAYO';
          }else if(mes==='06'){
              mes = 'JUNIO';
          }else if(mes==='07'){
              mes = 'JULIO';
          }else if(mes==='08'){
              mes = 'AGOSTO';
          }else if(mes==='09'){
              mes = 'SEPTIEMBRE';
          }else if(mes==='10'){
              mes = 'OCTUBRE';
          }else if(mes==='11'){
              mes = 'NOVIEMBRE';
          }else if(mes==='12'){
              mes = 'DICIEMBRE';
          }

          dias = "\nDEL DIA "+dia+" DE "+mes+" DEL "+ano+"";

      }else{ //Fechas diferentes

          const fecha_inicial = fechainicial.split("-");

          const fecha_final = fechafinal.split("-");

          var diauno = fecha_inicial[2];
          var diados = fecha_final[2];

          var mesuno = fecha_inicial[1];

          if(mesuno==='01'){
              mesuno = 'ENERO';
          }else if(mesuno==='02'){
              mesuno = 'FEBRERO';
          }else if(mesuno==='03'){
              mesuno = 'MARZO';
          }else if(mesuno==='04'){
              mesuno = 'ABRIL';
          }else if(mesuno==='05'){
              mesuno = 'MAYO';
          }else if(mesuno==='06'){
              mesuno = 'JUNIO';
          }else if(mesuno==='07'){
              mesuno = 'JULIO';
          }else if(mesuno==='08'){
              mesuno = 'AGOSTO';
          }else if(mesuno==='09'){
              mesuno = 'SEPTIEMBRE';
          }else if(mesuno==='10'){
              mesuno = 'OCTUBRE';
          }else if(mesuno==='11'){
              mesuno = 'NOVIEMBRE';
          }else if(mesuno==='12'){
              mesuno = 'DICIEMBRE';
          }

          var mesdos = fecha_final[1];

          if(mesdos==='01'){
              mesdos = 'ENERO';
          }else if(mesdos==='02'){
              mesdos = 'FEBRERO';
          }else if(mesdos==='03'){
              mesdos = 'MARZO';
          }else if(mesdos==='04'){
              mesdos = 'ABRIL';
          }else if(mesdos==='05'){
              mesdos = 'MAYO';
          }else if(mesdos==='06'){
              mesdos = 'JUNIO';
          }else if(mesdos==='07'){
              mesdos = 'JULIO';
          }else if(mesdos==='08'){
              mesdos = 'AGOSTO';
          }else if(mesdos==='09'){
              mesdos = 'SEPTIEMBRE';
          }else if(mesdos==='10'){
              mesdos = 'OCTUBRE';
          }else if(mesdos==='11'){
              mesdos = 'NOVIEMBRE';
          }else if(mesdos==='12'){
              mesdos = 'DICIEMBRE';
          }

          var anouno = fecha_inicial[0];
          var anodos = fecha_final[0];

          if(anouno==anodos){ //Servicios del mismo año

              if(mesuno==mesdos){ //Servicios del mismo mes
                  dias = "\nDEL DIA "+diauno+" AL "+diados+" DE "+mesuno+" DEL "+anouno+"";
              }else{ //Servicios de diferentes meses
                  dias = "\nDEL DIA "+diauno+" DE "+mesuno+" AL "+diados+" DE "+mesdos+" DEL "+anouno+"";
              }

          }else{ //Servicios de dic y ene

              dias = "\nDEL DIA "+diauno+" DE "+mesuno+" DEL "+anouno+" AL "+diados+" DE "+mesdos+" DEL "+anodos+"";
          }
          //$dias = "DEL DIA 05 AL 06 DE DICIEMBRE DEL 2022";
      }
      //console.log(cc)

      dias = ''+cliente+'\n\nSERVICIO DE OPERACION Y LOGISTICA DE TRANSPORTE PRESTADOS EN LA CIUDAD DE '+ciudad+' '+dias;

      if(cc==329){
        //dias += '\n\n'+ $(this).attr('data-observa');
      }

        $('#client').html(cliente);
        $('#nit').html(nit);
        $('#factu').modal('show');


        if(cliente=='SGS COLOMBIA HOLDING BARRANQUILLA' || cliente=='SGS COLOMBIA HOLDING BOGOTA') {

          var cantidadEjecutivos = 'Cantidad de servicios Ejecutivos: '+ejecutivos;
          var cantidadRutas = 'Cantidad de Rutas: '+rutas;

          var valorEjecutivo = 'Servicios EJECUTIVOS: '+km;
          var valorRuta = 'Servicios de Rutas: '+kmr;

          var textual = 'El valor del kilometraje es un valor aproximado.';
          $('#observa').val(dias+'\n\n'+cantidadEjecutivos+'\n'+valorEjecutivo+' KM\n\n'+cantidadRutas+'\n'+valorRuta+' KM\n\n'+textual);
        }else{
          $('#observa').val(dias);
        }

      });

      //Generar Facturas OTROS SERVICIOS
      $('#example7').on('click', '.generar_facturas2', function(){

        $('#generar_facturass2').attr('data-id', $(this).attr('data-id')).removeClass('hidden');
        $('#generar_facturass').addClass('hidden');

        $('.copy_obs').attr('data-observ', $(this).attr('data-observa'));

        var cliente = $(this).attr('data-client');
        var cc = $(this).attr('data-centro');
        var expediente = $(this).attr('data-expediente');
        var nit = $(this).attr('data-nit');

        var fechainicial = $(this).attr('f-inicial');
        var fechafinal = $(this).attr('f-final');

        var ciudad = $(this).attr('data-ciudad');
        var dias = '';

        dias = ''+cliente+'\n\nSERVICIOSSS DE OPERACION Y LOGISTICA DE TRANSPORTE PRESTADOS EN LA CIUDAD DE '+ciudad+' '+dias;

        $('#client').html(cliente);
        $('#nit').html(nit);
        $('#factu').modal('show');

        $('#observa').val(dias);

      });

      //Generar OK
      $('#generar_facturass2').click(function() {

          var fecha_factura = $('#fecha_factura').val();
          var fecha_vencimiento = $('#fecha_vencimiento').val();
          var forma_pago = $('#forma_pago').val();
          var rangos = $('#rangos').val();
          var observa = $('#observa').val();

          var noica = $('.noica').val();

          if($('.noica').is(':checked')){
            noica = 'checked';
          }else{
            noica = 'nochecked';
          }

          var norete = $('.norete').val();

          if($('.norete').is(':checked')){
            norete = 'checked';
          }else{
            norete = 'nochecked';
          }

          var fp = $('#forma_pago option:selected').html();
          var rg = $('#rangos option:selected').html();

          if( (fp==='Forma de Pago') || (fp==='Credito' && rg==='Fechas') || (fp==='Credito' && rg==='Rango' && (fecha_factura==='' || fecha_vencimiento==='') )){

            var text = '';

            if(forma_pago==='Forma de Pago'){
              text +="<li>Debe seleccionar una forma de pago.</li>";
            }

            if(fp==='Credito' && rg==='Fechas'){
              text +="<li>Debe seleccionar un Rango de tiempo.</li>";
            }

            if(fp==='Credito' && rg==='Rango' && (fecha_factura==='' || fecha_vencimiento==='') ){
              text +="<li>Debe seleccionar Fecha de Factura y de Vencimiento.</li>";
            }

            $.confirm({
                title: 'Alerta',
                content: text,
                buttons: {
                    confirm: {
                        text: 'Ok',
                        btnClass: 'btn-success',
                        keys: ['enter', 'shift'],
                        action: function(){


                        }

                    }
                }
            });

          }else{

            var id = $(this).attr('data-id');
            $(this).addClass('disabled');

            $.ajax({
                url: 'facturacionotroservicios',
                method: 'post',
                data: {
                    'id': id,
                    //'fecha_inicial' : fecha_inicial,
                    //'fecha_final' : fecha_final,
                    'fecha_factura': fecha_factura, //ok
                    'fecha_vencimiento' : fecha_vencimiento, //ok
                    'forma_pago' : forma_pago, //
                    'fp' : fp, //
                    'rg' : rg, //
                    'observaciones' : observa,
                    'noica' : noica, //ok
                    'norete' : norete //ok
                },
                dataType: 'json',
            })
            .done(function(data){
                if (data.respuesta===true){
                    alert('Factura Generada! '+data.consecutivo);
                    location.reload();
                }else if(data.respuesta===false){

          			}
            });

          }

      });
      //Generar Facturas OTROS SERVICIOS

      $('.copy_obs').click(function(){

        var observa = '\n\n'+$(this).attr('data-observ');

        if($('.copy_obs').is(':checked')){
          norete = 'checked';
          //alert(norete+observa)
          $('#observa').val(dias+observa);

        }else{
          norete = 'nochecked';
          //alert(norete)
          $('#observa').val(dias);

        }
      })

      $('#generar_facturass').click(function() {

        var fecha_factura = $('#fecha_factura').val();
        var fecha_vencimiento = $('#fecha_vencimiento').val();
        var forma_pago = $('#forma_pago').val();
        var rangos = $('#rangos').val();
        var observa = $('#observa').val();

        var noica = $('.noica').val();

        if($('.noica').is(':checked')){
          noica = 'checked';
        }else{
          noica = 'nochecked';
        }

        var norete = $('.norete').val();

        if($('.norete').is(':checked')){
          norete = 'checked';
        }else{
          norete = 'nochecked';
        }

        var fp = $('#forma_pago option:selected').html();
        var rg = $('#rangos option:selected').html();

        if( (fp==='Forma de Pago') || (fp==='Credito' && rg==='Fechas') || (fp==='Credito' && rg==='Rango' && (fecha_factura==='' || fecha_vencimiento==='') )){

          var text = '';

          if(forma_pago==='Forma de Pago'){
            text +="<li>Debe seleccionar una forma de pago.</li>";
          }

          if(fp==='Credito' && rg==='Fechas'){
            text +="<li>Debe seleccionar un Rango de tiempo.</li>";
          }

          if(fp==='Credito' && rg==='Rango' && (fecha_factura==='' || fecha_vencimiento==='') ){
            text +="<li>Debe seleccionar Fecha de Factura y de Vencimiento.</li>";
          }

          $.confirm({
              title: 'Alerta',
              content: text,
              buttons: {
                  confirm: {
                      text: 'Ok',
                      btnClass: 'btn-success',
                      keys: ['enter', 'shift'],
                      action: function(){


                      }

                  }
              }
          });

        }else{

          $objeto = $(this);
          $objeto.addClass('disabled');

          //SACAR LOS DATOS QUE FALTA DE LA LIQUIDACION
          var id = $(this).attr('data-id');
          var fecha_inicial = '';
          var fecha_final = '';
          var centrodecosto_id = 0;
          var subcentrodecosto_id = 0;
          var ciudad = '';
          var total_generado_cobrado = 0;
          var total_generado_pagado = 0;
          var total_generado_utilidad = 0;
          var id_facturaArray = [];
          var afiliado_externo = null;

          $.ajax({
            url: 'verliquidacionservicios',
            method: 'post',
            data: {
              'id': id
            },
            dataType: 'json',
            async: false
          })
          .done(function(data){
            if(data.respuesta===true){

              id_liquidado_servicio = data.liquidacion_servicios.id
              fecha_inicial = data.liquidacion_servicios.fecha_inicial;
              fecha_final = data.liquidacion_servicios.fecha_final;
              centrodecosto_id = data.liquidacion_servicios.centrodecosto_id;
              subcentrodecosto_id = data.liquidacion_servicios.subcentrodecosto_id;
              ciudad = data.liquidacion_servicios.ciudad;
              total_generado_cobrado = data.total_generado_cobrado;
              total_generado_pagado = data.total_generado_pagado;
              total_generado_utilidad = data.total_generado_utilidad;
              otros_ingresos = data.otros_ingresos;
              otros_costos = data.otros_costos;
              id_facturaArray = data.id_facturaArray;
              observaciones = data.liquidacion_servicios.observaciones;
              afiliado_externo = data.liquidacion_servicios.afiliado_externo;

            }else if(data.respuesta===false){
              alert('Ha ocurrido un error contacte con su administrador!');
            }
          }).fail(function(request,status,error){
            alert('Hubo un error Request: '+JSON.stringify(request)+', Status: '+status+', Error: '+error);
          });

          var formData = new FormData();
          formData.append('fecha_inicial',fecha_inicial);
          formData.append('fecha_final',fecha_final);
          formData.append('centrodecosto_id',centrodecosto_id);
          formData.append('subcentrodecosto_id',subcentrodecosto_id);
          formData.append('ciudad',ciudad);
          formData.append('total_generado_cobrado',total_generado_cobrado);
          formData.append('total_generado_pagado',total_generado_pagado);
          formData.append('total_generado_utilidad',total_generado_utilidad);
          formData.append('otros_ingresos', otros_ingresos);
          formData.append('otros_costos', otros_costos);
          formData.append('id_liquidado_servicio',id_liquidado_servicio);
          formData.append('id_facturaArray',id_facturaArray);
          formData.append('observaciones_liq',observaciones);
          formData.append('afiliado_externo', afiliado_externo);

          formData.append('fecha_factura', fecha_factura);
          formData.append('fecha_vencimiento', fecha_vencimiento);
          formData.append('forma_pago', forma_pago);
          formData.append('fp', fp);
          formData.append('rg', rg);
          formData.append('observaciones', observa);
          formData.append('noica', noica);
          formData.append('norete', norete);

          //TODOS LOS SERVICIOS ESTAN REVISADOS, LIQUIDADOS Y AUTORIZADOS
          $.ajax({
            url: 'nuevafactura',
            method: 'post',
            data: formData,
            processData: false,
            contentType: false
          })
          .done(function(data){

            if (data.respuesta===true) {

                if(data.consecutivo===data.numero_factura){

                  $.confirm({
                      title: 'Grandioso!!!',
                      content: 'Se ha generado la factura <b>N° '+data.consecutivo+'</b> con éxito <i style="color: green" class="fa fa-check-circle" aria-hidden="true"></i>',
                      buttons: {
                          confirm: {
                              text: 'Ok',
                              btnClass: 'btn-success',
                              keys: ['enter', 'shift'],
                              action: function(){

                                $objeto.removeClass('disabled');
                                location.reload();

                              }

                          }
                      }
                  });

                }else{

                  $.confirm({
                      title: '¡Cuidado! <i style="color: red" class="fa fa-exclamation-triangle" aria-hidden="true"></i>',
                      content: '¡Acción Inmediata!<br> <b style="color: black">Se ha generado la factura, pero el consecutivo de Siigo no concuerda con el de AUTONET</b><br><br> N° Siigo: <b>'+data.consecutivo+'</b><br> N° AUTONET: <b>'+data.numero_factura+'</b>',
                      buttons: {
                          confirm: {
                              text: 'Ok',
                              btnClass: 'btn-success',
                              keys: ['enter', 'shift'],
                              action: function(){

                                $objeto.removeClass('disabled');
                                location.reload();

                              }

                          }
                      }
                  });

                }

                //location.href = '../facturacion/verorden'+'/'+data.id;
            }else if (data.respuesta===false) {

                $objeto.removeClass('disabled');
                $.confirm({
                    title: 'Atención! <i style="color: red" class="fa fa-exclamation-triangle" aria-hidden="true"></i>',
                    content: '¡Ya existe una orden de facturacion para estas fechas!',
                    buttons: {
                        confirm: {
                            text: 'Ok',
                            btnClass: 'btn-danger',
                            keys: ['enter', 'shift'],
                            action: function(){


                            }

                        }
                    }
                });

            }else if (data.respuesta==='error') {
                 $objeto.removeClass('disabled');
                 $.confirm({
                     title: 'Atención! <i style="color: red" class="fa fa-exclamation-triangle" aria-hidden="true"></i>',
                     content: '¡Se ha generado un error de conectividad entre Autonet y Siigo!<br><br><b>Detalles <i style="color: red" class="fa fa-arrow-down" aria-hidden="true"></i></b><br><b>error:</b> <span style="color: red">'+data.code+'</span><br><b>info:</b> '+data.message,
                     buttons: {
                         confirm: {
                             text: 'Ok',
                             btnClass: 'btn-danger',
                             keys: ['enter', 'shift'],
                             action: function(){


                             }

                         }
                     }
                 });
            }

          })
          .fail(function(request, status, error){
            alert('Hubo un error - Request: '+JSON.stringify(request)+' Status: '+status+' Error: '+error);
          });

        }

    });

    $('.actualizar_token').click(function(){

      $('.loader').removeClass('hidden');
      $(this).addClass('hidden');

      $.ajax({
        url: 'actualizartoken',
        method: 'post',
        data: {id: 1}
      }).done(function(data){

        if(data.respuesta==true){

          $('.loader').addClass('hidden');
          $('.actualizar_token').removeClass('hidden');

          $.confirm({
              title: '¡Token Generado!',
              content: 'Se ha actualizado el token y su fecha de vencimiento es el <b>'+data.fecha+'</b> a las <b>'+data.hora+'</b>.',
              buttons: {
                  confirm: {
                      text: 'Recargar Página',
                      btnClass: 'btn-success',
                      keys: ['enter', 'shift'],
                      action: function(){

                        location.reload();

                      }

                  }
              }
          });

        }else if (data.respuesta==='error') {

            $('.loader').addClass('hidden');
            $('.actualizar_token').removeClass('hidden');

             $.confirm({
                 title: 'Atención! <i style="color: red" class="fa fa-exclamation-triangle" aria-hidden="true"></i>',
                 content: '¡Se ha generado un error en la generación de Token Siigo!<br><br><b>Detalles <i style="color: red" class="fa fa-arrow-down" aria-hidden="true"></i></b><br><b>error:</b> <span style="color: red">'+data.code+'</span><br><b>info:</b> '+data.message,
                 buttons: {
                     confirm: {
                         text: 'Ok',
                         btnClass: 'btn-danger',
                         keys: ['enter', 'shift'],
                         action: function(){


                         }

                     }
                 }
             });
        }

      });

    });

    </script>
  </body>
</html>
