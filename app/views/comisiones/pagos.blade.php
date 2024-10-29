<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Pago de Comisiones</title>
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  </head>
  <body>

    @include('admin.menu')
    <div class="col-lg-12">
      <div class="col-lg-5">
        <div class="row">
          <ol style="margin-bottom: 10px" class="breadcrumb">
            <li><a href="{{url('comisiones')}}">Listado</a></li>
            {{$valores['link_pago_comisiones']}}
            {{$valores['link_pago_autorizar']}}
            {{$valores['link_pago_pagar']}}
          </ol>
        </div>
      </div>
      <div class="col-lg-12">
  			<div class="row">
          <h3 class="h_titulo">{{$valores['titulo']}}</h3>
          <form class="form-inline" id="form_comisiones">
            <div class="form-group">
                <div class="input-group">
                    <div class='input-group date' id='datetimepicker1'>
                        <input name="fecha_inicial" style="width: 89px;" type='text' class="form-control input-font" placeholder="FECHA INICIAL">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class='input-group date' id='datetimepicker1'>
                        <input name="fecha_final" style="width: 89px;" type='text' class="form-control input-font" placeholder="FECHA FINAL">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
              <select name="tipo_servicio" type="text" class="form-control input-font" id="tipo_servicio" placeholder="TIPO DE SERVICIO">
                <option value="0">TIPO DE SERVICIO</option>
                <option value="1">TRANSPORTE</option>
                <option value="2">TURISMO</option>
              </select>
            </div>
            <div class="form-group">
              <select name="asesor_comercial" type="text" class="form-control input-font" id="asesor_comercial">
                <option value="0">ASESOR COMERCIAL</option>
                @foreach ($comercial as $value)
                    <option value="{{$value->id}}">{{$value->nombre_completo}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <select name="tercero" type="text" class="form-control input-font" id="tercero">
                <option value="0">ASESOR EXTERNO</option>
                @foreach ($terceros as $value)
                    <option value="{{$value->id}}">{{$value->nombre_completo}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <select name="coordinador_turismo" type="text" class="form-control input-font" id="coordinador_turismo">
                <option value="0">COORDINADOR COMERCIAL</option>
                @foreach ($users as $value)
                    <option value="{{$value->id}}">{{$value->first_name.' '.$value->last_name}}</option>
                @endforeach
              </select>
            </div>
            <button data-option="{{$option}}" id="buscar_pagos" type="button" class="btn btn-lg btn-default btn-icon">BUSCAR <i class="fa fa-search icon-btn"></i></button>
  			</div>
  		</div>
      <table class="table table-bordered table-hover" id="example2">
        <thead>
          <tr>
            <th>#</th>
            <th>Fecha de Pago</th>
            <th>Fecha de Registro</th>
            <th>Total Comision</th>
            <th>Otros Descuentos</th>
            <th>Total a Pagar</th>
            <th>Tipo Comision</th>
            <th>Tipo Pago</th>
            <th>Nombre Completo</th>
            <th>Estado</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Fecha de Pago</th>
            <th>Fecha de Registro</th>
            <th>Total Comision</th>
            <th>Otros Descuentos</th>
            <th>Total a Pagar</th>
            <th>Tipo Comision</th>
            <th>Tipo Pago</th>
            <th>Nombre Completo</th>
            <th>Estado</th>
            <th></th>
            <th></th>
          </tr>
        </tfoot>
      </table>
      <div class="form-inline">
      @if(intval($option)===0)
              @if(isset($permisos->contabilidad->pago_de_comisiones->revisar))
                  @if($permisos->contabilidad->pago_de_comisiones->revisar==='on')
                      <a id="revisar" style="margin-top: 15px" class="btn btn-default">{{$valores['boton']}}</a>
                  @else
                      <a style="margin-top: 15px" class="btn btn-default disabled">{{$valores['boton']}}</a>
                  @endif
              @else
                  <a style="margin-top: 15px" class="btn btn-default disabled">{{$valores['boton']}}</a>
              @endif
      @elseif(intval($option)===1)
          @if(isset($permisos->contabilidad->pagos_por_autorizar_comision->autorizar))
              @if($permisos->contabilidad->pagos_por_autorizar_comision->autorizar==='on')
                  <a id="autorizar" style="margin-top: 15px" class="btn btn-default">{{$valores['boton']}}</a>
              @else
                  <a style="margin-top: 15px" class="btn btn-default disabled">{{$valores['boton']}}</a>
              @endif
          @else
              <a style="margin-top: 15px" class="btn btn-default disabled">{{$valores['boton']}}</a>
          @endif
      @endif
      </div>
    </div>

    <div id="modal-activar-reconfirmacion" class="hidden" style="opacity: 1;">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Fecha de Pago<i id="cerrar_alerta" style="float: right; font-weight:100" class="fa fa-close"></i></div>
                <div class="panel-body">
                    <label>Digite la fecha en la que desea autorizar el pago</label><br>
                    <div style="float: left; margin-right: 5px;" class="input-group">
                        <div class="input-group date" id="datetimepicker1">
                            <input name="fecha_pago" style="width: 97px;" type="text" class="form-control input-font" placeholder="FECHA DE PAGO">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                        </div>
                    </div>
                    <a id="autorizar_pago" style="float: left" class="btn btn-success btn-icon">AUTORIZAR<i class="fa fa-check icon-btn"></i></a>
                </div>
            </div>
        </div>
    </div>

    @include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>

    <script src="{{url('jquery/comisiones.js')}}"></script>
    <script>
      $tableb = $('#example2').DataTable({

          paging: false,
          language: {
              processing:     "Procesando...",
              search:         "Buscar:",
              lengthMenu:    "Mostrar _MENU_ Registros",
              info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
              infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
              infoFiltered:   "(Filtrando de _MAX_ registros en total)",
              infoPostFix:    "",
              loadingRecords: "Cargando...",
              zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
              emptyTable:     "NINGUN REGISTRO DISPONIBLE EN LA TABLA",
              paginate: {
                  first:      "Primer",
                  previous:   "Antes",
                  next:       "Siguiente",
                  last:       "Ultimo"
              },
              aria: {
                  sortAscending:  ": activer pour trier la colonne par ordre croissant",
                  sortDescending: ": activer pour trier la colonne par ordre décroissant"
              },
              "aoColumnDefs": [
                  { "sClass": "column-2", "aTargets": [ 1 ] }
              ]
          },
          'bAutoWidth': false ,
          'aoColumns' : [
              { 'sWidth': '1%' },
              { 'sWidth': '2%' },
              { 'sWidth': '2%' },
              { 'sWidth': '2%' },
              { 'sWidth': '1%' },
              { 'sWidth': '2%' },
              { 'sWidth': '2%' },
              { 'sWidth': '3%' },
              { 'sWidth': '5%' },
              { 'sWidth': '7%' },
              { 'sWidth': '1%' },
              { 'sWidth': '4%' }
          ],
          processing: true,
          "bProcessing": true
      });

      $('#datetimepicker1, #datetimepicker2, #datetimepicker5, #datetimepicker6').datetimepicker({
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

      var fInicial = $('input[name="fecha_inicial"]').val();
      var fFinal = $('input[name="fecha_final"]').val();
      var idAsesor = parseInt($('#asesor_comercial').val());
      var terceroId = parseInt($('#tercero').val());
      var coordinadorTurismo = parseInt($('#coordinador_turismo').val());

      if(fInicial!='' || fFinal!=''){
        $option = parseInt($('#buscar_pagos').attr('data-option'));
        buscarPagos($option);
      }

      window.onload=function(){
        var pos=window.name || 0;
        window.scrollTo(0,pos);
      }

      window.onunload=function(){
        window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
      }

    </script>
  </body>
</html>
