<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">

    <title>Autonet | Adjuntar Proyecto</title>
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

    </style>
  </head>
  <body>
    @include('admin.menu')

    <div class="row" style="margin-left: 6px">
      <h1 class="h2 text-left mt-3 mb-4 pb-3" style="margin-left: 18px">Adjuntar Proyecto</h1>
      <div class="col-lg-1">

          <div class="input-group" id="datetime_fecha">
              <label class="h5 text-center mt-3 mb-4 pb-3">Fecha de Proyecto</label>
              <div class='input-group date' id='datetime_fecha'>
                  <input id="fecha_proyecto" name="fecha_pago" style="width: 80px;" type='text' class="form-control input-font" placeholder="Fecha" value="">
                  <span class="input-group-addon">
                      <span class="fa fa-calendar">
                      </span>
                  </span>
              </div>
          </div>
        
      </div>

      <div class="col-lg-1">
        <div class="input-group" id="datetime_fecha">
          <form id="formulario">
            <label class="h5 text-center mt-3 mb-4 pb-3">Seleccionar</label>
            <input type="file" value="Subir" id="recibo" name="recibo">
          </form>
        </div>
      </div>
      <div class="col-lg-1">
        <label class="h5 text-center mt-3 mb-4 pb-3">Click</label>
        <button title="" data-option="1" id="compartido_con" class="btn btn-warning btn-icon adjuntar_proyecto ">Adjuntar <i class="fa fa-paperclip icon-btn"></i></button>
      </div>

    </div>

    <div class="row">
      <div class="col-lg-12">
        
        <section class="" style="width: 99%;">
          <div style="margin-left: 20px;">
            <div class="row d-flex justify-content-center align-items-center h-50 actividades_hoy">
              <div class="col">
                <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
                  <div class="card-body py-4 px-4 px-md-5">

                    <p class="h3 text-center mt-3 mb-4 pb-3 text-primary">
                      <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                      <u>Mis Proyectos</u>
                    </p>

                    <hr class="my-4">

                    <table id="example_table" class="table table-bordered hover tabla" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">#</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Fecha de Proyecto</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Fecha de Subido</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"></td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $o = 1; ?>
                        @foreach($proyectos as $proyecto)
                          <tr>
                            <th>
                            
                            <center>
                              {{$o}}
                            </center>

                            </th>
                            <th>
                              <center>
                                <span class="h5 text-center mt-3 mb-4 pb-3">{{$proyecto->fecha_proyecto}}</span>
                              </center>
                          </th>
                            <th>
                              <center>
                                <span class="h5 text-center mt-3 mb-4 pb-3">{{$proyecto->created_at}}</span>
                              </center>
                            </th>
                            <th>
                              <center>
                                
                                <a href="{{url('biblioteca_imagenes/proyectos/'.$proyecto->file)}}" target="_blank" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-primary btn-list-table" aria-haspopup="true" title="Descargar Proyecto" aria-expanded="true"><i class="fa fa-download" aria-hidden="true" style="font-size: 16px;"></i></a>

                              <button data-id="{{$proyecto->id}}" target="_blank" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-danger btn-list-table eliminar_proyecto @if($proyecto->fecha_proyecto<=date('Y-m-d')){{'disabled'}}@endif" aria-haspopup="true" title="Descargar Proyecto" aria-expanded="true"><i class="fa fa-times" aria-hidden="true" style="font-size: 16px;"></i></button>

                              </center>
                            </th>
                          </tr>
                          <?php $o++; ?>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                        <tr>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">#</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Fecha de Proyecto</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Fecha de Subido</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"></td>
                        </tr>
                      </tfoot>
                    </table>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

    </div>

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

      $('.eliminar_proyecto').click(function(){

        var id = $(this).attr('data-id');
        //alert(id);

        $.confirm({
            title: 'Atención',
            content: '¿Estás seguro de eliminar este proyecto?',
            buttons: {
                confirm: {
                    text: 'Si, Eliminar.',
                    btnClass: 'btn-danger',
                    keys: ['enter', 'shift'],
                    action: function(){

                      $.ajax({
                        url: 'eliminar',
                        method: 'post',
                        data: {id: id}
                      }).done(function(data){

                        if(data.respuesta==true){
                          alert('¡Proyecto Eliminado!');
                          location.reload();
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

      });

      $('.adjuntar_proyecto').click(function() {

         var file = $('#recibo').val();
         var fecha = $('#fecha_proyecto').val();
         var id = $(this).attr('data-id');

         console.log(file)
         console.log(id)

        if(fecha==='' || file === ''){

          var data = '';

          if(fecha === ''){
            data += '<li>Debe seleccionar la fecha del proyecto</li>';
          }

          if(file === ''){
            data += '<li>Debe adjuntar un archivo</li>';
          }

          $.confirm({
              title: '¡Atención!',
              content: data,
              buttons: {
                  confirm: {
                      text: 'Cerrar',
                      btnClass: 'btn-warning',
                      keys: ['enter', 'shift'],
                      action: function(){



                      }

                  }
              }
          });

        }else{

          formData = new FormData($('#formulario')[0]);
          formData.append('recibo',$('#recibo').val());
          formData.append('fecha',$('#fecha_proyecto').val());
          formData.append('data-id',id);

          console.log($('#recibo').val());

          $.ajax({
              type: "post",
              url: "adjuntar",
              data: formData,
              processData: false,
              contentType: false,
              success: function(data) {

                  if(data.respuesta===false){
                    alert('¡No se pudo guardar. Intentelo de nuevo!');
                  }else if(data.respuesta===true){
                    alert('¡Proyecto Guardado!');
                    location.reload();
                  }
              },
              error: function (request, status, error) {
                  console.log('Hubo un error, llame al administrador del sistema'+request+status+error);
              }
          });

        }

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

      $('#consultarfactura').click(function(e){ //Consultar factura individual

        $.ajax({
          url: 'siigo/consultarfactura',
          method: 'post',
          data: {factura_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
            location.reload();
          }else if(data.respuesta==false){

          }

        });

      });

    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();
    </script>

  </body>
</html>
