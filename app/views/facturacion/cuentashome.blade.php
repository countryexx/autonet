<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Autonet | Listado de Cuentas de Cobro</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    @include('scripts.styles')
  </head>
  <body>
    @include('admin.menu')
    @include('facturacion.menu_pago_proveedores')
      <div class="col-lg-12">
        <?php

        $mess = DB::table('cuenta')->where('id',1)->pluck('MES');

        if(intval($mess) == 1){
          $mes = 'ENERO';
        }else if(intval($mess) == 2){
          $mes = 'FEBRERO';
        }else if(intval($mess) == 3){
          $mes = 'MARZO';
        }else if(intval($mess) == 4){
          $mes = 'ABRIL';
        }else if(intval($mess) == 5){
          $mes = 'MAYO';
        }else if(intval($mess) == 6){
          $mes = 'JUNIO';
        }else if(intval($mess) == 7){
          $mes = 'JULIO';
        }else if(intval($mess) == 8){
          $mes = 'AGOSTO';
        }else if(intval($mess) == 9){
          $mes = 'SEPTIEMBRE';
        }else if(intval($mess) == 10){
          $mes = 'OCTUBRE';
        }else if(intval($mess) == 11){
          $mes = 'NOVIEMBRE';
        }else if(intval($mess) == 12){
          $mes = 'DICIEMBRE';
        }

        ?>
        <h3 class="h_titulo">Actualmente el mes Habilitado es <b>{{$mes}}<br></b></h3>

        <div class="form-group">
          <select data-option="1" name="meses" style="width: 130px;" class="form-control input-font meses">
            <option value="0">HABILITAR MES</option>
            <option value="1">ENERO</option>
            <option value="2" @if($mess>=2){{'disabled'}}@endif>FEBRERO</option>
            <option value="3" @if($mess>=3){{'disabled'}}@endif>MARZO</option>
            <option value="4" @if($mess>=4){{'disabled'}}@endif>ABRIL</option>
            <option value="5" @if($mess>=5){{'disabled'}}@endif>MAYO</option>
            <option value="6" @if($mess>=6){{'disabled'}}@endif>JUNIO</option>
            <option value="7" @if($mess>=7){{'disabled'}}@endif>JULIO</option>
            <option value="8" @if($mess>=8){{'disabled'}}@endif>AGOSTO</option>
            <option value="9" @if($mess>=9){{'disabled'}}@endif>SEPTIEMBRE</option>
            <option value="10" @if($mess>=10){{'disabled'}}@endif>OCTUBRE</option>
            <option value="11" @if($mess>=11){{'disabled'}}@endif>NOVIEMBRE</option>
            <option value="12" @if($mess>=12){{'disabled'}}@endif>DICIEMBRE</option>

          </select>
        </div>

          <input type="text" name="id_de_pago" id="id_de_pago" value="" class="hidden">
          <div style="margin-top: 15px;">
            <form class="form-inline" id="form_buscar">
          <div class="col-lg-12" style="margin-bottom: 5px">
              <div class="row">
          <div class="form-group">
            <div class="input-group" id="datetime_fecha">
              <div class='input-group date' id='datetimepicker10'>
                <input id="fecha_inicial" name="fecha_inicial" style="width: 100px;" type='text' class="form-control input-font" placeholder="FECHA INICIAL" value="<?php echo date('Y-m-d') ?>">
                  <span class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                  </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group" id="datetime_fecha">
              <div class='input-group date' id='datetimepicker10'>
                <input id="fecha_final" name="fecha_final" style="width: 100px;" type='text' class="form-control input-font" placeholder="FECHA FINAL" value="<?php echo date('Y-m-d') ?>">
                  <span class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                  </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <select data-option="1" name="estado" style="width: 130px;" class="form-control input-font">
              <option value="0">PENDIENTES</option>
              <option value="1">CORRECCIÓN ENVIADA</option>
              <option value="2">CORRECCIÓN RESPONDIDA</option>
              <option value="3">RADICADOS</option>
            </select>
          </div>
          <div class="input-group proveedor_content">
            <select data-option="1" name="proveedores" style="width: 130px;" class="form-control input-font" id="proveedor_search">
              <option value="0">PROVEEDORES</option>
              @foreach($proveedores as $proveedor)
                <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
              @endforeach
            </select>
          </div>
          <a proceso="2" id="buscar_cuentas" class="btn btn-default btn-icon">
            Buscar<i class="fa fa-search icon-btn"></i>
          </a>
              </div>
          </div>
      </form>
            <table id="examplecuentas" class="table table-bordered hover tabla" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <td>#</td>
                  <td>Proveedor</td>
                  <td>Fecha de Expedición</td>
                  <td>Estado</td>
                  <td>Fecha Inicial</td>
                  <td>Fecha Final</td>
                  <td>Valor</td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                @foreach($cuentas as $cuenta)
                  <tr>
                    <td>{{$i}}</td>
                    <td>{{$cuenta->razonsocial}}</td>
                    <td>{{$cuenta->fecha_expedicion}}</td>
                    <td>
                      @if($cuenta->estado==null)
                        PENDIENTE POR REVISAR
                      @elseif($cuenta->estado==1)
                        SE ENVIÓ UNA CORRECCIÓN AL PROVEEDOR
                      @elseif($cuenta->estado==2)
                        RESPUESTA POR PARTE DEL PROVEEDOR POR CORRECCIÓN
                      @elseif($cuenta->estado==3)
                        RADICADA
                      @endif
                    </td>
                    <td>
                      {{$cuenta->fecha_inicial}}
                    </td>
                    <td>
                      {{$cuenta->fecha_final}}
                    </td>
                    <td><p class="bolder text-primary" style="margin: 0 !important; font-size: 12px;"><?php echo '$ '.number_format($cuenta->valor)?></p></td>
                    <td>

                      <a href="{{url('facturacion/detallescuentas/'.$cuenta->id)}}" pago-id="{{$cuenta->id}}" nombre="{{$cuenta->id}}" class="btn btn-list-table btn-warning">REVISAR</a>
                      <a href="{{url('biblioteca_imagenes/sss/cuentas/'.$cuenta->seguridad_social)}}" pago-id="{{$cuenta->id}}" target="_blank" nombre="{{$cuenta->id}}" class="btn btn-list-table btn-success">SS</a>

                    </td>
                  </tr>
                  <?php $i++; ?>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td>#</td>
                  <td>Proveedor</td>
                  <td>Fecha de Expedición</td>
                  <td>Estado</td>
                  <td>Fecha Inicial</td>
                  <td>Fecha Final</td>
                  <td>Valor</td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
      		</div>
      </div>

      @include('scripts.scripts')
      <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
      <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
      <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
      <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
      <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
      <script src="{{url('jquery/portalproveedores.js')}}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
      <script type="text/javascript">
        function goBack(){
            window.history.back();
        }

        $('.meses').change(function(){

          var id = $(this).val();

          if(id!='0'){
            if(id==='1'){
              var mes = 'ENERO';
            }else if(id==='2'){
              var mes = 'FEBRERO';
            }else if(id==='3'){
              var mes = 'MARZO';
            }else if(id==='4'){
              var mes = 'ABRIL';
            }else if(id==='5'){
              var mes = 'MAYO';
            }else if(id==='6'){
              var mes = 'JUNIO';
            }else if(id==='7'){
              var mes = 'JULIO';
            }else if(id==='8'){
              var mes = 'AGOSTO';
            }else if(id==='9'){
              var mes = 'SEPTIEMBRE';
            }else if(id==='10'){
              var mes = 'OCTUBRE';
            }else if(id==='11'){
              var mes = 'NOVIEMBRE';
            }else if(id==='12'){
              var mes = 'DICIEMBRE';
            }

            $.confirm({
                title: 'Confirmación',
                content: '¿Estás seguro de Habilitar el mes de '+mes+'?<br><br>Se enviará una notificación por correo a los proveedores.',
                buttons: {
                    confirm: {
                        text: 'Si',
                        btnClass: 'btn-success',
                        keys: ['enter', 'shift'],
                        action: function(){

                          $.ajax({
                            url: '../facturacion/habilitarmes',
                            method: 'post',
                            data: {mes: id}
                          }).done(function(data){

                            if(data.respuesta==true){

                              alert('Realizado!');
                              location.reload();

                            }else if(data.response==false){

                            }

                          });

                        }

                    },
                    cancel: {
                      text: 'Cancelar',
                    }
                }
            });
          }

        });
      </script>
  </body>
</html>
