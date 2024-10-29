<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Capacitación Conductores</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <style type="text/css">
      a.notif {
        position: relative;
        display: block;
        height: 50px;
        width: 50px;
        background: url('http://i.imgur.com/evpC48G.png');
        background-size: contain;
        text-decoration: none;
      }
      .num {
        position: absolute;
        right: 11px;
        top: 6px;
        color: #fff;
      }

      .th{
        text-align: center;
      }
    </style>
</head>
<body>

@include('admin.menu')
<div class="col-xs-12">
<h1 class="h_titulo">Conductores por Capacitar</h1>
    <div class="col-lg-8">
      <div class="row">
          @include('portalproveedores.menu_proveedores')
      </div>
    </div>

    @if(isset($conductores))
      <table id="exampleCapacitaciones" class="table table-bordered hover exampleCapacitaciones" cellspacing="0" width="100%">
          <thead>
            <tr class="success">
              <th class="th">Cédula</th>
              <th class="th">Nombre</th>
              <th class="th">Email</th>
              <th class="th">Ciudad</th>
              <th class="th">Talento Humano</th>
              <th class="th">Jurídica</th>
              <th class="th">Gestión Integral</th>
              <th class="th">Contabilidad</th>
              <th class="th">Sistemas</th>
              <th class="th">Mantenimiento</th>
              <th class="th">Acciones</th>
            </tr>
          </thead>
          <tfoot>
          <tr class="success">
            <th class="th">Cédula</th>
            <th class="th">Nombre</th>
            <th class="th">Email</th>
            <th class="th">Ciudad</th>
            <th class="th">Talento Humano</th>
            <th class="th">Jurídica</th>
            <th class="th">Gestión Integral</th>
            <th class="th">Contabilidad</th>
            <th class="th">Sistemas</th>
            <th class="th">Mantenimiento</th>
            <th class="th">Acciones</th>
          </tr>
          </tfoot>
          <tbody>
          @foreach($conductores as $proveedor)
          <?php
          $sw = 0;
          $sw2 = 0;
          $sw3 = 0;

          if($proveedor->autorizacion_th===1){
            $icon_th = 'check';
            $fondo_th = 'green';
          }else{
            $icon_th = 'times';
            $fondo_th = 'red';
          }

          if($proveedor->autorizacion_juridica===1){
            $icon_juridica = 'check';
            $fondo_juridica = 'green';
          }else{
            $icon_juridica = 'times';
            $fondo_juridica = 'red';
          }

          if($proveedor->autorizacion_contabilidad===1){
            $icon_contabilidad = 'check';
            $fondo_contabilidad = 'green';
          }else{
            $icon_contabilidad = 'times';
            $fondo_contabilidad = 'red';
            //$sw = 1;
          }

          ?>
            <tr id="{{$proveedor->id}}" class="{{$proveedor->id}}">
              <td>{{$proveedor->nit}}-{{$proveedor->digito_verificacion}}</td>
              <td><a title="PROVEEDOR: {{$proveedor->razonsocial}} | PLACA: {{$proveedor->placa}}">{{$proveedor->nombre_completo}}</a></td>
              <td><a href="mailto:{{$proveedor->email}}">{{$proveedor->email}}</a></td>
              <td>{{$proveedor->ciudad}}</td>
              <!--<td>

                @if($proveedor->estado_global===null)
                  <span style="padding: 4px; background: red; color: white">PENDIENTE REVISIÓN</span>                  
                @elseif($proveedor->estado_global===1 and $proveedor->autorizacion_contabilidad===null)
                  <span style="padding: 4px; background: red; color: white">SOLICITUD DATOS BANCARIOS</span>
                @elseif($proveedor->estado_global===1 and $proveedor->autorizacion_contabilidad===1)
                  <span style="padding: 4px; background: red; color: white">RESPUESTA DATOS BANCARIOS</span>
                @elseif($proveedor->estado_global===2 and $proveedor->autorizacion_contabilidad===null)
                  <span style="padding: 4px; background: red; color: white">CORRECCIÓN DE DOCS ENVIADA</span>
                @elseif($proveedor->estado_global===4)
                  <span style="padding: 4px; background: red; color: white">CORRECCIÓN DE DOCS RESPONDIDA</span>
                @elseif($proveedor->estado_global===3 and $proveedor->autorizacion_contabilidad===2)
                  <span style="padding: 4px; background: red; color: white">APROBACIÓN CONTABLE</span>
                @endif
              
              </td>-->
              <td id="{{$proveedor->id}}">

                <center>

                  @if($proveedor->cap_th===1)

                    <label>TH</label>
                    <i class="fa fa-check" aria-hidden="true" style="color: green; font-size: 20px;"></i>

                  @else

                    <label><input data-id="{{$proveedor->id}}" type="checkbox" class="th"> TH</label>
                    <i class="fa fa-check th_icon hidden" aria-hidden="true" style="color: green; font-size: 20px;"></i>

                  @endif
                  
                </center>

              </td>
              <td id="{{$proveedor->id}}">

                <center>

                  @if($proveedor->cap_juridica===1)

                    <label>GJ</label>
                    <i class="fa fa-check" aria-hidden="true" style="color: green; font-size: 20px;"></i>

                  @else

                    <label><input data-id="{{$proveedor->id}}" type="checkbox" class="gj"> GJ</label>
                    <i class="fa fa-check gj_icon hidden" aria-hidden="true" style="color: green; font-size: 20px;"></i>

                  @endif
                  
                </center>

              </td>
              <td id="{{$proveedor->id}}">

                <center>

                  @if($proveedor->cap_gestion===1)

                    <label>GI</label>
                    <i class="fa fa-check" aria-hidden="true" style="color: green; font-size: 20px;"></i>

                  @else

                    <label><input data-id="{{$proveedor->id}}" type="checkbox" class="gi"> GI</label>
                    <i class="fa fa-check gi_icon hidden" aria-hidden="true" style="color: green; font-size: 20px;"></i>

                  @endif

                </center>

              </td>
              <td id="{{$proveedor->id}}">

                <center>

                  @if($proveedor->cap_contabilidad===1)

                    <label>CO</label>
                    <i class="fa fa-check" aria-hidden="true" style="color: green; font-size: 20px;"></i>

                  @else

                    <label><input data-id="{{$proveedor->id}}" type="checkbox" class="co"> CO</label>
                    <i class="fa fa-check co_icon hidden" aria-hidden="true" style="color: green; font-size: 20px;"></i>

                  @endif
                  
                </center>

              </td>
              <td id="{{$proveedor->id}}">

                <center>

                  @if($proveedor->cap_sistemas===1)

                    <label>SI</label>
                    <i class="fa fa-check" aria-hidden="true" style="color: green; font-size: 20px;"></i>

                  @else

                    <label><input data-id="{{$proveedor->id}}" type="checkbox" class="si"> SI</label>
                    <i class="fa fa-check si_icon hidden" aria-hidden="true" style="color: green; font-size: 20px;"></i>

                  @endif

              </td>
              <td id="{{$proveedor->id}}">

                <center>

                  @if($proveedor->mantenimiento===1)

                    <label>MA</label>
                    <i class="fa fa-check" aria-hidden="true" style="color: green; font-size: 20px;"></i>

                  @else

                    <label><input data-id="{{$proveedor->id}}" type="checkbox" class="ma"> MA</label>
                    <i class="fa fa-check ma_icon hidden" aria-hidden="true" style="color: green; font-size: 20px;"></i>

                  @endif

              </td>
              <td>
                <!-- ESTADO DE SOLICITUD O RESPUESTA DE DATOS BANCARIOS DEL PROVEEDOR -->

                <?php 
                
                  $disabled = '';
                  if( !($proveedor->cap_th===1 and $proveedor->cap_gestion===1 and $proveedor->cap_juridica===1 and $proveedor->cap_contabilidad===1 and $proveedor->cap_sistemas===1 and $proveedor->mantenimiento===1) ){
                    $disabled = 'disabled';
                  }

                ?>

                <a title="Incorporar proveedor" id="send_transportes" data-id="{{$proveedor->id_proveedor}}" class="btn btn-success incorporar {{$disabled}} send_transportes"><i class="fa fa-check" aria-hidden="true"></i></a>

              </td>
            </tr>
          @endforeach
          </tbody>
      </table>
    @endif
    <a class="btn btn-primary btn-icon" onclick="goBack()">Volver<i class="fa fa-reply icon-btn"></i></a>
</div>

<div class="errores-modal bg-danger text-danger hidden model" style="top: 10%;">
  <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
  <ul>
  </ul>
</div>

<div class="guardado bg-success text-success hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul style="margin: 0;padding: 0;">
    </ul>
</div>

@include('scripts.scripts')
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/portalproveedores.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script type="text/javascript">
    function goBack(){
        window.history.back();
    }

    $('#th').click(function(){
      console.log('th')
    });

    $('#exampleCapacitaciones').on('click', '.th', function(event) { //TALENTO HUMANO
      
      var idfila = $(this).attr('data-id');

      $.confirm({
        title: 'Capacitación Talento Humano',
        content: 'Confirma la realización de la capacitación de <br> TALENTO HUMANO?',
        buttons: {
            confirm: {
                text: 'SI, Realizada! <i class="fa fa-check" aria-hidden="true"></i>',
                btnClass: 'btn-success',
                keys: ['enter', 'shift'],
                action: function(){

                  $('.enviar2').html('').append('Cargando... <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>').addClass('disabled');

                  $.ajax({
                    url: 'capacitacionth',
                    method: 'post',
                    data: {
                      id: idfila
                    },
                    dataType: 'json',
                  }).done(function(data){
                    if (data.respuesta===true) {

                      $('#exampleCapacitaciones tbody tr').each(function () {
                        $(this).find('td').eq(4).find('.th_icon').removeClass('hidden');
                        $(this).find('td').eq(4).find('.th').addClass('hidden');
                        if(data.habilitar===1){
                          console.log('habilitar habilitado')
                          $(this).find('td').eq(10).find('.incorporar').removeClass('disabled');
                        }
                      });
                    

                    }else if (data.respuesta===false) {
                      alert('Error en el proceso!');
                    }else if(data.respuesta=='noexiste'){
                      alert('No existe información en el sistema sobre este proceso.')
                    }
                  });

                }

            },
            cancel: {
            text: 'CANCELAR',
            action: function(){

              $('#exampleCapacitaciones tbody tr').each(function () {

                if($(this).attr('id')==idfila){
                  $(this).find('td').eq(4).find('.th').prop('checked',false);
                }

              });

            }
          }
        }
      });
    });

    $('#exampleCapacitaciones').on('click', '.gj', function(event) { //JURÍDICA
      
      var idfila = $(this).attr('data-id');

      $.confirm({
        title: 'Capacitación Jurídica',
        content: 'Confirma la realización de la capacitación <br> JURÍDICA Y DOCUMENTAL?',
        buttons: {
            confirm: {
                text: 'SI, Realizada! <i class="fa fa-check" aria-hidden="true"></i>',
                btnClass: 'btn-success',
                keys: ['enter', 'shift'],
                action: function(){

                  $.ajax({
                    url: 'capacitaciongj',
                    method: 'post',
                    data: {
                      id: idfila
                    },
                    dataType: 'json',
                  }).done(function(data){
                    if (data.respuesta===true) {

                      $('#exampleCapacitaciones tbody tr').each(function () {
                        $(this).find('td').eq(5).find('.gj_icon').removeClass('hidden');
                        $(this).find('td').eq(5).find('.gj').addClass('hidden');
                        if(data.habilitar===1){
                          console.log('habilitar habilitado')
                          $(this).find('td').eq(10).find('.incorporar').removeClass('disabled');
                        }
                      });

                    }else if (data.respuesta===false) {
                      alert('Error en el proceso!');
                    }else if(data.respuesta=='noexiste'){
                      alert('No existe información en el sistema sobre este proceso.')
                    }
                  });
                }

            },
            cancel: {
            text: 'CANCELAR',
            action: function(){

              $('#exampleCapacitaciones tbody tr').each(function () {

                if($(this).attr('id')==idfila){
                  $(this).find('td').eq(5).find('.gj').prop('checked',false);
                }

              });

            }
          }
        }
      });
    });

    $('#exampleCapacitaciones').on('click', '.gi', function(event) { //GESTIÓN INTEGRAL
      
      var idfila = $(this).attr('data-id');

      $.confirm({
        title: 'Capacitación Gestión Integral',
        content: 'Confirma la realización de la capacitación <br> GESTIÓN INTEGRAL?',
        buttons: {
            confirm: {
                text: 'SI, Realizada! <i class="fa fa-check" aria-hidden="true"></i>',
                btnClass: 'btn-success',
                keys: ['enter', 'shift'],
                action: function(){

                  $.ajax({
                    url: 'capacitaciongi',
                    method: 'post',
                    data: {
                      id: idfila
                    },
                    dataType: 'json',
                  }).done(function(data){
                    if (data.respuesta===true) {

                      $('#exampleCapacitaciones tbody tr').each(function () {
                        $(this).find('td').eq(6).find('.gi_icon').removeClass('hidden');
                        $(this).find('td').eq(6).find('.gi').addClass('hidden');
                        if(data.habilitar===1){
                          console.log('habilitar habilitado')
                          $(this).find('td').eq(10).find('.incorporar').removeClass('disabled');
                        }
                      });

                    }else if (data.respuesta===false) {
                      alert('Error en el proceso!');
                    }else if(data.respuesta=='noexiste'){
                      alert('No existe información en el sistema sobre este proceso.')
                    }
                  });
                }

            },
            cancel: {
            text: 'CANCELAR',
            action: function(){

              $('#exampleCapacitaciones tbody tr').each(function () {

                if($(this).attr('id')==idfila){
                  $(this).find('td').eq(6).find('.gi').prop('checked',false);
                }

              });

            }
          }
        }
      });
    });

    $('#exampleCapacitaciones').on('click', '.co', function(event) { //CONTABILIDAD
      
      var idfila = $(this).attr('data-id');

      $.confirm({
        title: 'Capacitación Contabilidad',
        content: 'Confirma la realización de la capacitación <br> CONTABILIDAD?',
        buttons: {
            confirm: {
                text: 'SI, Realizada! <i class="fa fa-check" aria-hidden="true"></i>',
                btnClass: 'btn-success',
                keys: ['enter', 'shift'],
                action: function(){

                  $.ajax({
                    url: 'capacitacionco',
                    method: 'post',
                    data: {
                      id: idfila
                    },
                    dataType: 'json',
                  }).done(function(data){
                    if (data.respuesta===true) {

                      $('#exampleCapacitaciones tbody tr').each(function () {
                        $(this).find('td').eq(7).find('.co_icon').removeClass('hidden');
                        $(this).find('td').eq(7).find('.co').addClass('hidden');
                        if(data.habilitar===1){
                          console.log('habilitar habilitado')
                          $(this).find('td').eq(10).find('.incorporar').removeClass('disabled');
                        }
                      });

                    }else if (data.respuesta===false) {
                      alert('Error en el proceso!');
                    }else if(data.respuesta=='noexiste'){
                      alert('No existe información en el sistema sobre este proceso.')
                    }
                  });
                }

            },
            cancel: {
            text: 'CANCELAR',
            action: function(){

              $('#exampleCapacitaciones tbody tr').each(function () {

                if($(this).attr('id')==idfila){
                  $(this).find('td').eq(7).find('.co').prop('checked',false);
                }

              });

            }
          }
        }
      });
    });

    $('#exampleCapacitaciones').on('click', '.si', function(event) { //SISTEMAS
      
      var idfila = $(this).attr('data-id');

      $.confirm({
        title: 'Capacitación Sistemas',
        content: 'Confirma la realización de la capacitación <br> SISTEMAS?',
        buttons: {
            confirm: {
                text: 'SI, Realizada! <i class="fa fa-check" aria-hidden="true"></i>',
                btnClass: 'btn-success',
                keys: ['enter', 'shift'],
                action: function(){

                  $.ajax({
                    url: 'capacitacionsi',
                    method: 'post',
                    data: {
                      id: idfila
                    },
                    dataType: 'json',
                  }).done(function(data){
                    if (data.respuesta===true) {

                      $('#exampleCapacitaciones tbody tr').each(function () {
                        $(this).find('td').eq(8).find('.si_icon').removeClass('hidden');
                        $(this).find('td').eq(8).find('.si').addClass('hidden');
                        if(data.habilitar===1){
                          console.log('habilitar habilitado')
                          $(this).find('td').eq(10).find('.incorporar').removeClass('disabled');
                        }
                      });

                    }else if (data.respuesta===false) {
                      alert('Error en el proceso!');
                    }else if(data.respuesta=='noexiste'){
                      alert('No existe información en el sistema sobre este proceso.')
                    }
                  });
                }

            },
            cancel: {
            text: 'CANCELAR',
            action: function(){

              $('#exampleCapacitaciones tbody tr').each(function () {

                if($(this).attr('id')==idfila){
                  $(this).find('td').eq(8).find('.si').prop('checked',false);
                }

              });

            }
          }
        }
      });
    });

    $('#exampleCapacitaciones').on('click', '.ma', function(event) { //MANTENIMIENTO
      
      var idfila = $(this).attr('data-id');

      $.confirm({
        title: 'Revisión Mantenimiento',
        content: 'Confirma la realización de la Revisión de <br> MANTENIMIENTO?',
        buttons: {
            confirm: {
                text: 'SI, Realizada! <i class="fa fa-check" aria-hidden="true"></i>',
                btnClass: 'btn-success',
                keys: ['enter', 'shift'],
                action: function(){

                  $.ajax({
                    url: 'capacitacionma',
                    method: 'post',
                    data: {
                      id: idfila
                    },
                    dataType: 'json',
                  }).done(function(data){
                    if (data.respuesta===true) {

                      $('#exampleCapacitaciones tbody tr').each(function () {
                        $(this).find('td').eq(9).find('.ma_icon').removeClass('hidden');
                        $(this).find('td').eq(9).find('.ma').addClass('hidden');
                        if(data.habilitar===1){
                          console.log('habilitar habilitado')
                          $(this).find('td').eq(10).find('.incorporar').removeClass('disabled');
                        }
                      });

                    }else if (data.respuesta===false) {
                      alert('Error en el proceso!');
                    }else if(data.respuesta=='noexiste'){
                      alert('No existe información en el sistema sobre este proceso.')
                    }
                  });
                }

            },
            cancel: {
            text: 'CANCELAR',
            action: function(){

              $('#exampleCapacitaciones tbody tr').each(function () {

                if($(this).attr('id')==idfila){
                  $(this).find('td').eq(9).find('.ma').prop('checked',false);
                }

              });

            }
          }
        }
      });
    });

    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();

    var $tableCapacitaciones = $('.exampleCapacitaciones').DataTable({
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
        responsive: true
    },
    'bAutoWidth': false ,
    'aoColumns' : [
        { 'sWidth': '1%' }, //count
        { 'sWidth': '2%' }, //cliente
        { 'sWidth': '2%' }, //tipo de ruta
        { 'sWidth': '1%' }, //hora
        { 'sWidth': '2%' }, //fecha
        { 'sWidth': '2%' }, //placa
        { 'sWidth': '2%' }, //placa
        { 'sWidth': '2%' }, //placa
        { 'sWidth': '2%' }, //placa
        { 'sWidth': '2%' }, //placa
    ],
    processing: true,
    "bProcessing": true
});

</script>
</body>
</html>
