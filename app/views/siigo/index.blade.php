<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">

    <title>Autonet | Proyecto 2</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />

    <style>

      body {
        background-color: lightgray;
      }

    #list1 .form-control {
      border-color: transparent;
    }
    #list1 .form-control:focus {
      border-color: transparent;
      box-shadow: none;
    }
    #list1 .select-input.form-control[readonly]:not([disabled]) {
      background-color: #fbfbfb;
    }

    .avatar {
      vertical-align: middle;
      width: 30px;
      height: 30px;
      border-radius: 50%;
    }

    #container {
      position:relative;
    }

    #img2 {
        position: absolute;
        left: 50px;
        top: 50px;
    }

    </style>
  </head>
  <body>
    @include('admin.menu')

    <!--<button data-option="1" id="email" class="btn btn-success btn-icon">Enviar Email<i class="fa fa-check icon-btn"></i></button>

    <button data-option="1" id="whatsapp" class="btn btn-success btn-icon">Enviar Whatsapp<i class="fa fa-whatsapp icon-btn"></i></button>-->

    <button data-option="1" id="cuadrar" class="btn btn-default btn-icon">Cuadrar servicios<i class="fa fa-list icon-btn"></i></button>

    <!--
    <br>
    <button data-option="1" id="finalizar" class="btn btn-success btn-icon">Finalizar<i class="fa fa-whatsapp icon-btn"></i></button>
    <br>
    <button data-option="1" id="query" class="btn btn-success btn-icon">Query<i class="fa fa-sign-in icon-btn"></i></button>

    <button data-option="1" id="mail" class="btn btn-success btn-icon">Mail<i class="fa fa-sign-in icon-btn"></i></button>-->


    <button data-option="1" id="confirmar_servicio" class="btn btn-primary btn-icon">Confirmar Servicio UP DRIVER<i class="fa fa-check icon-btn"></i></button>

    <button data-option="1" id="query" class="btn btn-success btn-icon">Query<i class="fa fa-sign-in icon-btn"></i></button>

    <button data-option="1" id="consultarfactura" class="btn btn-default btn-icon">Factura Individual<i class="fa fa-file-text icon-btn"></i></button>
    <br><br><br>
    <div class="row">
      <div class="col-lg-5" style="border: 1px solid white">

        <div class="input-group">
          <div class="input-group date" id="datetimepicker1">
              <input value="{{date('Y-m-d')}}" id="fecha" name="md_fecha_final" style="width: 115;" type="text" class="form-control input-font">
              <span class="input-group-addon">
                  <span class="fa fa-calendar">
                  </span>
              </span>
          </div>
        </div>

        <br>

        <select style="width: 120px;" name="cc" id="cc" type="text" class="form-control input-font centrodecosto_ex_excel">
          <option>Cliente</option>
          @foreach($centrosdecosto as $centro)
            <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
          @endforeach
        </select>
        <br>
        <button id="enviar_repetidos" class="btn btn-default btn-icon">Enviar Mail<i class="fa fa-send icon-btn"></i></button>
      </div>
    </div>

    <?php

    $cotizacion = DB::table('cotizaciones')
    ->where('id',1621)
    ->first();

    ?>
<!--
    <div id="container">
      <img src="{{url('img/fondo1.png')}}" id="img1" style="width: 500px" />
      <img src="{{url('biblioteca_imagenes/archivos_cotizaciones/187car2.JPG')}}" id="img2" style="width: 290px; margin-top: 130px; margin-left: 55px" />
    </div>-->

    
<!--
    <div class="col-lg-12">

        <h3 class="h_titulo">Siigo - Consultas</h3>
        <form class="form-inline" id="form_buscar" action="{{url('gestiondocumental/downloadpdf')}}" method="post">

        </form>
        <button data-option="1" id="tiposdecomprobante" class="btn btn-default btn-icon">Tipos de Comprobantes<i class="fa fa-sign-in icon-btn"></i></button>

        <button data-option="1" id="tiposdecomprobante2" class="btn btn-default btn-icon">Tipos de Comprobantes 2<i class="fa fa-sign-in icon-btn"></i></button>

        <button data-option="1" id="consultarcliente" class="btn btn-default btn-icon">Consultar Cliente<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="listarclientes" class="btn btn-default btn-icon">Listar Clientes<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="formasdepago" class="btn btn-default btn-icon">Formas de pago<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="impuestos" class="btn btn-default btn-icon">Impuestos<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="vendedor" class="btn btn-default btn-icon">Vendedor<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="consultarfactura" class="btn btn-default btn-icon">Factura Individual<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="consultarfacturapdf" class="btn btn-default btn-icon">Consultar Factura PDF<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="consultarrecibo" class="btn btn-default btn-icon">CR<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="mail" class="btn btn-default btn-icon">Envío Email<i class="fa fa-file-text icon-btn"></i></button>

    </div>

    <div class="col-lg-12">
      <h3 class="h_titulo">Siigo</h3>

      <button data-option="1" id="auth" class="btn btn-default btn-icon">AUTH<i class="fa fa-sign-in icon-btn"></i></button>
      <button data-option="1" id="factura" class="btn btn-default btn-icon">Crear Factura<i class="fa fa-file-text icon-btn"></i></button>

      <button data-option="1" id="recibo" class="btn btn-default btn-icon">Crear RC<i class="fa fa-file-text icon-btn"></i></button>

      <button data-option="1" id="facturadian" class="btn btn-default btn-icon">Crear Factura DIAN<i class="fa fa-file-text icon-btn"></i></button>

      <button data-option="1" id="notac" class="btn btn-default btn-icon">Nota Crédito<i class="fa fa-file-text icon-btn"></i></button>


    </div>

    <div>
      <button data-option="1" id="routes" class="btn btn-success btn-icon">Routes API<i class="fa fa-file-text icon-btn"></i></button>
    </div>-->

    @include('scripts.scripts')

    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/gestiondocumental.js')}}"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

    <script type="text/javascript">

      $tablecuentas2 = $('#example_table2').DataTable( {
        "order": [[ 0, "asc" ]],
        paging: false,

        language: {
          processing:     "Procesando...",
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
          }
        },
        'bAutoWidth': false,
        'aoColumns' : [
          { 'sWidth': '1%' },
          { 'sWidth': '2%' },
          { 'sWidth': '4%' },
          { 'sWidth': '3%' },
        ],
      });

      $tablecuentas = $('#example_table').DataTable( {
        "order": [[ 0, "asc" ]],
        paging: false,

        language: {
          processing:     "Procesando...",
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
          }
        },
        'bAutoWidth': false,
        'aoColumns' : [
          { 'sWidth': '1%' },
          { 'sWidth': '2%' },
          { 'sWidth': '4%' },
          { 'sWidth': '2%' },
          { 'sWidth': '3%' },
        ],
      });

      $('.buscar_fecha').click(function(){

        var fecha = $('#fecha_filtro').val();

        $('.date_activity').html('<b>'+fecha+'</b>');

        $tablecuentas.clear().draw();
        $tablecuentas2.clear().draw();

        $.ajax({
          url: 'siigo/filtrardia',
          method: 'post',
          data: {fecha: fecha}
        }).done(function(data){

          if(data.respuesta==true){

            var cont = 1 ;

            for(i in data.actividades){

              var nomb = '';

              if(data.actividades[i].nombres!=null){
               nomb = '<br><b style="font-size: 10px; color: gray;">('+data.actividades[i].nombres+' '+data.actividades[i].apellidos+')</b>';
              }

              var botones = '<center>';

              if(data.actividades[i].estado==1){
                var classe = 'disabled';
              }

              botones += '<a data-id="'+data.actividades[i].id+'" style="padding: 6px 8px 6px 8px; display: inline-block; margin-right: 5px" type="button" class="btn btn-primary btn-list-table compartir_tarea" aria-haspopup="true" title="Compartir Tarea" aria-expanded="true"><i class="fa fa-share" aria-hidden="true" style="font-size: 16px;"></i></a>';

              //botones += '<button data-id="'+data.actividades[i].id+'" style="padding: 6px 8px 6px 8px; display: inline-block; margin-right: 5px" type="button" class="btn btn-warning btn-list-table adjuntar_soporte" aria-haspopup="true" title="Adjuntar Soporte" aria-expanded="true"><i class="fa fa-paperclip" aria-hidden="true" style="font-size: 16px;"></i></button>';

              botones += '<a href="https://app.aotour.com.co/autonet/siigo/task/'+data.actividades[i].id+'" target="_blank" style="padding: 6px 8px 6px 8px; display: inline-block; margin-right: 5px" type="button" class="btn btn-default btn-list-table" aria-haspopup="true" title="Ver Tarea" aria-expanded="true"><i class="fa fa-eye ver_tarea" aria-hidden="true" style="font-size: 16px;"></i></a>';

              botones += '<a data-id="'+data.actividades[i].id+'" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-success btn-list-table cerrar_tarea" title="Cerrar Tarea" aria-haspopup="true" aria-expanded="true"><i class="fa fa-check-square-o" aria-hidden="true" style="font-size: 16px;"></i></a>';

              botones += '</center>';

              var estado = '<center>';

              if(data.actividades[i].estado==null){

                estado += '<div class="estado_servicio_app" style="background: gray; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">En Proceso</div>';

              }else{

                estado += '<div class="estado_servicio_app" style="background: green; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Terminada</div>';

              }

              if(data.actividades[i].comentarios==null){

                estado += '<div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Sin Comentarios</div>';

              }else{

                estado += '<div class="estado_servicio_app" style="background: blue; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Con Comentarios</div>';

              }

              if(data.actividades[i].adjuntos==null){

                estado += '<div class="estado_servicio_app" style="background: #67F6C7; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Sin Adjuntos</div>';

              }else{

                estado += '<div class="estado_servicio_app" style="background: #f47321; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Con Adjuntos</div>';

              }

              estado += '</center>';

              if(data.actividades[i].estado==null){
                var icons = '<i class="fa fa-spinner" style="color: orange; font-size: 15px" aria-hidden="true"></i> ';
              }else{
                var icons = '<i class="fa fa-check" style="color: green; font-size: 25px" aria-hidden="true"></i> ';
              }

              $tablecuentas.row.add([
                icons+cont,
                '<b>'+data.actividades[i].nombre+'<b>'+nomb,
                botones,
                '...',
                estado,
              ]).draw();
              cont++;

            }

            //Tabla 2
            var cont = 1 ;

            for(i in data.shared){

              var nomb = '';

              if(data.shared[i].nombres!=null){
               nomb = '<br><b style="font-size: 10px; color: gray;">('+data.shared[i].nombres+' '+data.shared[i].apellidos+')</b>';
              }

              var botones = '<center>';

              if(data.shared[i].estado==1){
                var classe = 'disabled';
              }

              //botones += '<a data-id="'+data.shared[i].id+'" style="padding: 6px 8px 6px 8px; display: inline-block; margin-right: 5px" type="button" class="btn btn-primary btn-list-table compartir_tarea" aria-haspopup="true" title="Compartir Tarea" aria-expanded="true"><i class="fa fa-share" aria-hidden="true" style="font-size: 16px;"></i></a>';

              //botones += '<button data-id="'+data.shared[i].id+'" style="padding: 6px 8px 6px 8px; display: inline-block; margin-right: 5px" type="button" class="btn btn-warning btn-list-table adjuntar_soporte" aria-haspopup="true" title="Adjuntar Soporte" aria-expanded="true"><i class="fa fa-paperclip" aria-hidden="true" style="font-size: 16px;"></i></button>';

              botones += '<a href="https://app.aotour.com.co/autonet/siigo/task/'+data.shared[i].id+'" target="_blank" style="padding: 6px 8px 6px 8px; display: inline-block; margin-right: 5px" type="button" class="btn btn-default btn-list-table" aria-haspopup="true" title="Ver Tarea" aria-expanded="true"><i class="fa fa-eye ver_tarea" aria-hidden="true" style="font-size: 16px;"></i></a>';

              botones += '<a data-id="'+data.shared[i].id+'" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-success btn-list-table cerrar_tarea" title="Cerrar Tarea" aria-haspopup="true" aria-expanded="true"><i class="fa fa-check-square-o" aria-hidden="true" style="font-size: 16px;"></i></a>';

              botones += '</center>';

              var estado = '<center>';

              if(data.shared[i].estado==null){

                estado += '<div class="estado_servicio_app" style="background: gray; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">En Proceso</div>';

              }else{

                estado += '<div class="estado_servicio_app" style="background: green; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Terminada</div>';

              }

              if(data.shared[i].comentarios==null){

                estado += '<div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Sin Comentarios</div>';

              }else{

                estado += '<div class="estado_servicio_app" style="background: blue; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Con Comentarios</div>';

              }

              if(data.shared[i].adjuntos==null){

                estado += '<div class="estado_servicio_app" style="background: #67F6C7; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Sin Adjuntos</div>';

              }else{

                estado += '<div class="estado_servicio_app" style="background: #f47321; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Con Adjuntos</div>';

              }

              estado += '</center>';

              if(data.shared[i].estado==null){
                var icons = '<i class="fa fa-spinner" style="color: orange; font-size: 15px" aria-hidden="true"></i> ';
              }else{
                var icons = '<i class="fa fa-check" style="color: green; font-size: 25px" aria-hidden="true"></i> ';
              }

              $tablecuentas2.row.add([
                icons+cont,
                nomb+'<b><br>'+data.shared[i].nombre+'<b>',
                botones,
                estado,
              ]).draw();
              cont++;

            }

          }else if(data.respuesta==false){

          }

        });

      });

      function dayss(id){
        alert('pruebas')
      }
      Dropzone.options.myDropzone = {
        autoProcessQueue: true,
        uploadMultiple: false,
        maxFilezise: 1,
        maxFiles: 4,
        addRemoveLinks: 'dictCancelUploadConfirmation ',
        url: 'siigo/ingresoimagenv2',
        init: function() {
            var submitBtn = document.querySelector("#subir");

            myDropzone = this;
            submitBtn.addEventListener("click", function(e){
                e.preventDefault();
                e.stopPropagation();
                myDropzone.processQueue();
            });
            this.on("addedfile", function(file) {

            });
            this.on("complete", function(file) {

            });
            myDropzone.on("success", function(file, response) {
                if(response.mensaje===true){
                    $(file.previewElement).fadeOut({
                        complete: function() {
                            // If you want to keep track internally...
                            myDropzone.removeFile(file);
                        }
                    });
                    alert(response.respuesta);
                }else if(response.mensaje===false){
                    alert(response.respuesta);
                }

            });
        }
      };

      $('.add_task').click(function(){
        //Abrir modal
        $('#modal_asignar').modal('show');
      });

      //Tipos de Comprobantes
      $('#tiposdecomprobante').click(function(e){ //Obtener access token

        var url = 'https://app.aotour.com.co/autonet';

        $.ajax({
          url: url+'/siigo/tiposdecomprobante',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      //Tipos de Comprobantes 1
      $('#tiposdecomprobante2').click(function(e){ //Obtener access token

        $.ajax({
          url: 'siigo/tiposdecomprobante2',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      //Listar Clientes
      $('#consultarcliente').click(function(e){ //Obtener access token

        $.ajax({
          url: 'siigo/consultarcliente',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      //Listar Clientes
      $('#listarclientes').click(function(e){ //Obtener access token

        $.ajax({
          url: 'siigo/listarclientes',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            //console.log(data.response.results)
              for(i in data.response.results) {
                console.log(data.response.results[i].identification+' , '+data.response.results[i].name+' , '+data.response.results[i].person_type+' , '+data.response.results[i].id_type.code)
              }
          }else if(data.respuesta==false){

          }

        });

      });

      //Formas de Pago
      $('#formasdepago').click(function(e){ //Obtener access token

        $.ajax({
          url: 'siigo/formasdepago',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      //Impuestos
      $('#impuestos').click(function(e){ //Obtener access token

        $.ajax({
          url: 'siigo/impuestos',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      //Vendedor
      $('#vendedor').click(function(e){ //Obtener access token

        $.ajax({
          url: 'siigo/vendedor',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      //Autenticación

      $('#auth').click(function(e){ //Obtener access token

        $.ajax({
          url: 'siigo/auth',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#factura').click(function(e){ //Crear factura

        $.ajax({
          url: 'siigo/crearfactura',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#recibo').click(function(e){ //Crear factura

        $.ajax({
          url: 'siigo/crearrecibo',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#facturadian').click(function(e){ //Crear factura

        $.ajax({
          url: 'siigo/crearfacturadian',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#notac').click(function(e){ //Crear factura

        $.ajax({
          url: 'siigo/notac',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#routes').click(function(e){ //Crear factura

        $.ajax({
          url: 'siigo/routes',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#consultarfactura').click(function(e){ //Consultar factura individual

        $.ajax({
          url: 'siigo/consultarfactura',
          method: 'post',
          data: {factura_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#consultarfacturapdf').click(function(e){ //Consultar factura individual

        $.ajax({
          url: 'siigo/consultarfacturapdf',
          method: 'post',
          data: {factura_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#consultarrecibo').click(function(e){ //Consultar factura individual

        $.ajax({
          url: 'siigo/consultarrecibo',
          method: 'post',
          data: {factura_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#mail').click(function(e){ //Consultar factura individual

        $.ajax({
          url: 'siigo/mail',
          method: 'post',
          data: {factura_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#consultarfacturas').click(function(e){ //Consultar facturas

        $.ajax({
          url: 'siigo/consultarfacturas',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#consultarclientes').click(function(e){ //Consultar clientes

        $.ajax({
          url: 'siigo/consultarcliente',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      /*$('.compartido_con').click(function(){
        //alert('Compartido Con');
        console.log('prueba')

        $('#modal_nota2').modal('show');
      });*/

      $('.task').click(function(){
        //alert('Compartido Con');
        console.log('prueba')

        $('#modal_nota').modal('show');
      });



      /*$('#agregar_descuento').click(function(event){
      event.preventDefault();
      $elemento = '<tr>'+
                    '<td>'+
                        '<textarea rows="2" class="form-control input-font detalle_text" style="text-transform: uppercase;" placeholder="NOMBRE DE LA ACTIVIDAD"></textarea>'+
                    '</td>'+
                    '<td>'+
                          '<select data-option="1" name="proveedores" class="form-control input-font selectpicker" multiple data-live-search="true" id="proveedor_search">'+
                          '<option value="0">USUARIOS</option>'+
                          '<option value="0">SAMUEL GONZALEZ</option>'+
                          '<option value="0">SAMUEL GONZALEZ</option>'+
                          '<option value="0">SAMUEL GONZALEZ</option>'+
                          '<option value="0">SAMUEL GONZALEZ</option>'+
                        '</select>'+
                    '</td>'+
                  '</tr>';
      $('.descuentos').removeClass('hidden').append($elemento);
    });*/

    /*$('#eliminar_descuento').click(function(event){

      $('.descuentos tbody tr').last().remove();
      var total_descuentos = 0;
      var totales = 0;
      var otros_descuentos = 0;

      $('.descuentos tbody tr').each(function(index) {
        if ($(this).find('.valor_descuento').val()==='') {
          descuento = 0;
        }else {
          descuento = parseInt($(this).find('.valor_descuento').val());
        }
        total_descuentos += descuento;
      });

      total = parseInt($('#totales_cuentas').attr('data-value'));
      valor_retefuente = $('.valor_retefuente').val();

      if (valor_retefuente==='') {
        valor_retefuente = 0;
      }else{
        valor_retefuente = parseInt(valor_retefuente);
      }
      var valor_prestamo = $('#prestamo1').val();
      if (valor_prestamo==='') {
        valor_prestamo = 0;
      }else{
        valor_prestamo = parseInt(valor_prestamo);
      }

      $('#otros_descuentos').val(total_descuentos);
      $('#totales_pagado').val(total-valor_retefuente-total_descuentos-valor_prestamo);

    });*/

    $('#nombre_actividad').keyup(function(e){
      var cantidad = $(this).val().length;
      console.log(cantidad);

      if(cantidad>20){
        $('.limit').removeClass('hidden');
        $('.boton_guardar').attr('disabled','disabled');
        $('.boton_guardar').addClass('disabled');
      }else{
        $('.limit').addClass('hidden');
        $('.boton_guardar').removeAttr('disabled','disabled');
        $('.boton_guardar').removeClass('disabled');
      }

    });

    $('#nombre_tarea').keyup(function(e){
      var cantidad = $(this).val().length;
      console.log(cantidad);

      if(cantidad>20){
        $('.limites').removeClass('hidden');
        $('#guardar_asignar_tarea').attr('disabled','disabled');
        $('#guardar_asignar_tarea').addClass('disabled');
      }else{
        $('.limites').addClass('hidden');
        $('#guardar_asignar_tarea').removeAttr('disabled','disabled');
        $('#guardar_asignar_tarea').removeClass('disabled');
      }

    });

    $('.boton_guardar').click(function(){

      var nombre = $('#nombre_actividad').val().toUpperCase();
      var users = $('#participantes').val();
      var descripcionTarea = $('#descripcion_actividad').val();

      console.log('users : '+users)

      if(nombre==='' || descripcionTarea===''){
        var text = '';

        if(nombre===''){
          text += '<li>El nombre de la tarea es obligatorio.<br></li>'
        }

        if(descripcionTarea===''){
          text += '<li>La descripción de la tarea es obligatoria.</li>'
        }

        $.confirm({
            title: 'Atención',
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

        if(users===null){

          $.confirm({
              title: 'Atención',
              content: 'No has seleccionado ninguna copia. <br><br>¿Estás seguro de no compartir tu tarea?',
              buttons: {
                  confirm: {
                      text: 'Si, Crear Tarea,',
                      btnClass: 'btn-success',
                      keys: ['enter', 'shift'],
                      action: function(){

                        $.ajax({
                          url: 'siigo/agregaractividad',
                          method: 'post',
                          data: {nombre: nombre, users: users, descripcionTarea: descripcionTarea, cantidad: 0}
                        }).done(function(data){

                          if(data.respuesta==true){
                            alert('Success!!!')
                          }else if(data.respuesta==false){

                          }

                        });

                      }

                  },
                  cancel: {
                    text: 'Volver',
                  }
              }
          });


        }else{

          $.ajax({
            url: 'siigo/agregaractividad',
            method: 'post',
            data: {nombre: nombre, users: users, descripcionTarea: descripcionTarea}
          }).done(function(data){

            if(data.respuesta==true){
              alert('Tarea creada satisfactoriamente!')
              //location.reload();
            }else if(data.respuesta==false){

            }

          });

        }



      }

    });

    $('#guardar_asignar_tarea').click(function(){

      var asignado = $('#asignado').val();
      var nombreTarea = $('#nombre_tarea').val().toUpperCase();
      var descripcionTarea = $('#descripcion_tarea').val().toUpperCase();
      var participantesTarea = $('#participantes2').val();

      console.log(asignado)
      console.log(nombreTarea)
      console.log(descripcionTarea)
      console.log(participantesTarea)

      if(asignado==0 || nombreTarea==='' || descripcionTarea===''){
        var text = '';

        if(asignado==0){
          text += '<li>Selecciona al responsable de la tarea.<br></li>'
        }

        if(nombreTarea===''){
          text += '<li>El nombre de la tarea es obligatorio.<br></li>'
        }

        if(descripcionTarea===''){
          text += '<li>La descripción de la tarea es obligatoria.</li>'
        }

        $.confirm({
            title: 'Atención',
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

        if(participantesTarea==null){

          $.confirm({
              title: 'Atención',
              content: 'No has seleccionado ninguna copia. <br><br>¿Estás seguro de no compartir tu tarea?',
              buttons: {
                  confirm: {
                      text: 'Si, Crear Tarea,',
                      btnClass: 'btn-success',
                      keys: ['enter', 'shift'],
                      action: function(){

                        $.ajax({
                          url: 'siigo/asignartarea',
                          method: 'post',
                          data: {asignado: asignado, nombreTarea: nombreTarea, descripcionTarea: descripcionTarea, participantesTarea: participantesTarea, cantidad: 0}
                        }).done(function(data){

                          if(data.respuesta==true){
                            alert('Success!!!')
                          }else if(data.respuesta==false){

                          }

                        });

                      }

                  },
                  cancel: {
                    text: 'Volver',
                  }
              }
          });


        }
        //console.log('users : '+users)



      }

    });

    $('.opciones').click(function(){

      var id = $(this).attr('data-id');

      var urlTask = 'https://app.aotour.com.co/autonet/siigo/task/'+id;

      $('.compartir_tarea').attr('data-id',id);
      $('.ver_tarea').attr('href',urlTask);
      $('.cerrar_tarea').attr('data-id',id);
      $('.adjuntar_soporte').attr('data-id',id);

      $('#modal_opciones').modal('show');
    })

    $('.tarea_hoy').click(function(){

      //var id = $(this).attr('data-id');

      //var urlTask = 'http://localhost/autonet/siigo/task/'+id;

      //$('.compartir_tarea').attr('data-id',id);
      //$('.ver_tarea').attr('href',urlTask);
      //$('.cerrar_tarea').attr('data-id',id);

      $('#modal_tarea_hoy').modal('show');
    })

    $('#example_table').on('click', '.activar_tarea', function(event) {

      var id = $(this).attr('data-id');

      console.log(id)

      $.confirm({
          title: 'Confirmación',
          content: 'Estás seguro de reactivar esta tarea?',
          buttons: {
              confirm: {
                  text: 'Si, Reactivarla.',
                  btnClass: 'btn-success',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: 'siigo/activartarea',
                      method: 'post',
                      data: {id: id}
                    }).done(function(data){

                      if(data.response==true){

                        $('#modal_opciones').modal('hide')

                        $.alert({
                          title: 'Realizado!',
                          content: '¡Tarea Activada!',
                        });

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

    });

    $('#example_table').on('click', '.cerrar_tarea', function(event) {

      var id = $(this).attr('data-id');

      console.log(id)

      $.confirm({
          title: 'Confirmación',
          content: 'Estás seguro de cerrar esta tarea?',
          buttons: {
              confirm: {
                  text: 'Si, Cerrarla.',
                  btnClass: 'btn-success',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: 'siigo/cerrartarea',
                      method: 'post',
                      data: {id: id}
                    }).done(function(data){

                      if(data.response==true){

                        $('#modal_opciones').modal('hide')

                        $.alert({
                          title: 'Realizado!',
                          content: '¡Tarea cerrada!',
                        });

                        //location.reload();

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

    });

    $('#example_table').on('click', '.adjuntar_soporte', function(event) {

      var id = $(this).attr('data-id');

      //alert(id)

      $('.id_Activity').val(id);

      $('#modal_opciones').modal('hide');
      $('#modal_adjuntar').modal('show');

    });

    $('#example_table2').on('click', '.adjuntar_soporte', function(event) {

      var id = $(this).attr('data-id');

      //alert(id)

      $('.id_Activity').val(id);

      //$('#modal_opciones').modal('hide');
      $('#modal_adjuntar').modal('show');

    });

    $('#example_table').on('click', '.compartir_tarea', function(event) {

      var id = $(this).attr('data-id');

      //alert(id)

      //$('.id_Activity').val(id);
      $('#guardar_share').attr('data-id',id);
      $('#modal_share').modal('show');

    });

    $('#guardar_share').click(function(){

      var id = $(this).attr('data-id');

      var users = $('#participantes3').val();

      if(users===null){

        $.confirm({
            title: 'Atención',
            content: 'No has seleccionado ningún usuario...',
            buttons: {
                confirm: {
                    text: 'Ok',
                    btnClass: 'btn-warning',
                    keys: ['enter', 'shift'],
                    action: function(){



                    }

                }
            }
        });

      }else{

        $.ajax({
          url: 'siigo/sharetask',
          method: 'post',
          data: {id: id, users: users}
        }).done(function(data){

          if(data.response==true){

            alert('Tarea compartida!')

            location.reload();

          }else if(data.response==false){

          }

        });

      }
      //alert($(this).attr('data-id')+' , '+users);

    });

    $('#whatsapp').click(function(){

      $.ajax({
        url: 'siigo/enviarmail',
        method: 'post',
        data: {cantidad: 0}
      }).done(function(data){

        if(data.respuesta==true){
          alert('Success!!!')
        }else if(data.respuesta==false){

        }

      });

    });

    $('#finalizar').click(function(){

      $.ajax({
        url: 'siigo/finalizarservicio',
        method: 'post',
        data: {cantidad: 0}
      }).done(function(data){

        if(data.respuesta==true){
          alert('Success!!!')
        }else if(data.respuesta==false){

        }

      });

    });

    $('#whatsapp').click(function(){

      $.ajax({
        url: 'siigo/whatsapp',
        method: 'post',
        data: {cantidad: 0}
      }).done(function(data){

        if(data.respuesta==true){
          alert('Success!!!')
        }else if(data.respuesta==false){

        }

      });

    });

    $('#cuadrar').click(function(){

      $.ajax({
        url: 'siigo/cuadrar',
        method: 'post',
        data: {cantidad: 0}
      }).done(function(data){

        if(data.respuesta==true){
          alert('Success!!!')
        }else if(data.respuesta==false){

        }

      });

    });

    $('#confirmar_servicio').click(function(){

      var id = 658680;

      $.ajax({
        url: 'siigo/confirmarservicio',
        method: 'post',
        data: {id: id}
      }).done(function(data){

        if(data.respuesta==true){
          
          $.confirm({
            title: 'Realizado!',
            content: 'Simulación de confirmación de conductor!',
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

        }else if(data.respuesta==false){

        }

      });

    });

    $('#datetime_fecha, .datetime_fecha').datetimepicker({
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

    $('.dayss').click(function(){
      alert('pruebas')
    });

    $('.buscar_fechas').click(function(){

      var fecha = $('#fecha_filtro').val();

      console.log(fecha)
    });

    $('#guardar_adjunto').click(function(){
      alert($('.id_Activity').val())
    });

    $('#query').click(function(e){ //Obtener access token

      $.ajax({
        url: 'reportes/query',
        method: 'post',
        data: {foto_id: 123}
      }).done(function(data){

        if(data.respuesta==true){
          alert('Success!!!')
        }else if(data.respuesta==false){

        }

      });

    });

    /*$('#mail').click(function(e){ //Obtener access token

      $.ajax({
        url: 'siigo/mail',
        method: 'post',
        data: {foto_id: 123}
      }).done(function(data){

        if(data.respuesta==true){
          alert('Success!!!')
        }else if(data.respuesta==false){

        }

      });

    });*/

    $('#enviar_repetidos').click(function(e){ //Obtener access token

      var cc = $('#cc').val();
      var fecha = $('#fecha').val();

      console.log(cc)
      console.log(fecha)

      if(cc=='Cliente' || fecha == ''){
        
        $.confirm({
          title: 'Atención',
          content: 'Campos vacíos...',
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

        $.confirm({
          title: 'Atención',
          content: 'Estás seguro de enviar este correo?',
          buttons: {
            confirm: {
              text: 'Sí',
              btnClass: 'btn-success',
              keys: ['enter', 'shift'],
              action: function(){

                if(cc==19) {
                  var service = 'siigo/enviarrepetidosbaq';
                }else{
                  var service = 'siigo/enviarrepetidosbog';
                }

                $.ajax({
                  url: service,
                  method: 'post',
                  data: {fecha: fecha, cc: cc}
                }).done(function(data){

                  if(data.respuesta==true){
                    alert('Success!!!')
                  }else if(data.respuesta==false){

                  }

                });

              }
            }
          }
        });

      }

    });

    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();
    </script>

  </body>
</html>
