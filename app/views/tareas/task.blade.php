<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">

    <title>Autonet | Proyecto</title>
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

      #profile{
          background-color: unset;
          
      } 

      #post{
          margin: 10px;
          padding: 6px;
          padding-top: 2px;
          padding-bottom: 2px;
          text-align: center;
          background-color: #ecb21f;
          border-color: #a88734 #9c7e31 #846a29;
          color: black;
          border-width: 1px;
          border-style: solid;
          border-radius: 13px;
          width: 50%;
      }


      .comments{
          margin-top: 5%;
          margin-left: 20px;
      }


      .comment{
          border: 1px solid rgba(16, 46, 46, 1);
          background-color: gray;
          float: left;
          border-radius: 5px;
          padding-left: 10px;
          padding-right: 30px;
          padding-top: 10px;
          
      }
      .comment h4,.comment span,.darker h4,.darker span{
          display: inline;
      }

      .comment p,.comment span,.darker p,.darker span{
          color: rgb(184, 183, 183);
      }

      h1,h4{
          color: white;
          font-weight: bold;
      }
      label{
          color: rgb(212, 208, 208);
      }

      #align-form{
          margin-top: 20px;
      }
      .form-group p a{
          color: white;
      }

      #checkbx{
          background-color: black;
      }

      #darker img{
          margin-right: 15px;
          position: static;
      }

      .form-group input,.form-group textarea{
          background-color: black;
          border: 1px solid rgba(16, 46, 46, 1);
          border-radius: 12px;
      }

      form{
          border: 1px solid rgba(16, 46, 46, 1);
          background-color: rgba(16, 46, 46, 0.973);
          border-radius: 5px;
          padding: 20px;
       }

      

      body {
  
        background-color: lightgray;
      }

      .card {
        /* Add shadows to create the "card" effect */
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
      }

      /* On mouse-over, add a deeper shadow */
      .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
      }

      /* Add some padding inside the card container */

      .card {
        box-shadow: 0 2px 8px 0 black;
        transition: 0.3s;
        border-radius: 10px; /* 5px rounded corners */
      }

      /* Add rounded corners to the top left and the top right corner of the image */
      img {
        border-radius: 5px 5px 0 0;
      }

      .avatar {
        vertical-align: middle;
        width: 40px;
        height: 40px;
        border-radius: 50%;
      }

    </style>
  </head>
  <body>
    @include('admin.menu')

    <div class="row">
      <div class="col-lg-6 col-lg-push-1">
        
        <div class="card">
          <img src="{{url('img/task3.png')}}" width="50px" height="60px" alt="Avatar" style="margin-left: 8px;">
            <h5 style="margin-left: 8px; color: #FA631A" class="h6 text-left mt-3 mb-4 pb-3">{{$task->created_at}}</h5>
            <?php 
              $nombres = DB::table('empleados')->where('id',$task->responsable)->first();
            ?>
            <h5 style="margin-left: 8px;" class="h6 text-left mt-3 mb-4 pb-3">{{$nombres->nombres. ' '.$nombres->apellidos}}</h5>
            <h3 style="margin-left: 8px;" class="h4 text-left mt-3 mb-4 pb-3">{{ $task->nombre }} @if($task->asignado_por!=null) - ASIGNADA POR  <b style="color: #FA631A">{{$task->nombres. ' '.$task->apellidos}}</b> @endif</h3>

            <h5 style="margin-left: 8px;" class="h6 text-left mt-3 mb-4 pb-3">{{ $task->descripcion }}</h5>

            @if($task->implicados!=null)
            <h6 style="margin-left: 8px;" class="h6 text-left mt-3 mb-4 pb-3">COMPARTIDA CON:</h6>

              <?php
                
                $usuarioss = explode(",", $task->implicados);

                for ($i=0; $i <count($usuarioss) ; $i++) { 
                                  
                  $foto = DB::table('empleados')
                  ->where('id',$usuarioss[$i])
                  ->pluck('foto');

                  $nombres = DB::table('empleados')
                  ->where('id',$usuarioss[$i])
                  ->pluck('nombres');

                  $apellidos = DB::table('empleados')
                  ->where('id',$usuarioss[$i])
                  ->pluck('apellidos');

                  ?>
                  <img style="margin-left: 4px" data-id="{{$usuarioss[$i]}}" tarea-id="{{$task->id}}" data-name="{{$nombres.' '.$apellidos}}" src="https://app.aotour.com.co/autonet/biblioteca_imagenes/talentohumano/fotos/{{$foto}}" alt="Avatar" class="avatar @if(Sentry::getUser()->id_empleado==$task->responsable or Sentry::getUser()->id_empleado==$task->asignado_por){{'eliminar_usuario'}}@endif" title="{{$nombres.' '.$apellidos}}">

                  <?php

                }
            ?>
            @if($task->implicados!=null and ( Sentry::getUser()->id_empleado == $task->responsable || Sentry::getUser()->id_empleado == $task->asignado_por ) )
              <h5 class="h5 text-left mt-3 mb-4 pb-3" style="margin-left: 5px; color: red">Presiona click en la foto para eliminar al usuario de la tarea.</h5>
            @endif
          @else
            <h5 class="h5 text-left mt-3 mb-4 pb-3" style="color: #FA631A; margin-left: 8px; margin-bottom: 10px;"><b>Tarea no compartida.</b></h5>
          @endif
            
          
        </div>
        
        <section>
          <div class="row">
              <div class="col-sm-12 col-md-12">
                  <h1 class="h3 text-left mt-3 mb-4 pb-3">Comentarios</h1>
                  
                  <div class="form-outline mb-8">
                    <input type="text" data-id="{{$task->id}}" id="comentar" @if($task->estado===1){{'disabled'}}@endif class="form-control" placeholder="Escribe un comentario..." />
                  </div>
                  <?php 
                    if(isset($task->comentarios)){
                      $classes = '';
                    }else{
                      $classes = 'hidden';
                    }
                  ?>

                  <a style="margin-top: 25px; margin-bottom: 30px;" class="btn btn-primary btn-icon go_down {{$classes}}">IR AL FINAL<i class="fa fa-arrow-down icon-btn"></i></a>

                  <div class="comments_bar {{$classes}}" style="width: 100%">

                  @if(isset($task->comentarios))
                  
                    @foreach( json_decode($task->comentarios) as $json )
                      
                        <div class="comment mt-4 text-justify" style="width: 100%; margin-top: 20px;">
                            <img style="vertical-align: middle; width: 30px; height: 30px; border-radius: 50%;" src="{{url('biblioteca_imagenes/talentohumano/fotos/'.$json->foto)}}" alt="" class="rounded-circle" width="40" height="40">
                            <h4>{{$json->user}}</h4>
                            <span>{{$json->date.' '.$json->time}}</span>
                            <br>
                            <p style="margin-top: 6px" class="h4 text-left mt-3 mb-4 pb-3">{{$json->mensaje}}</p>
                        </div>
                      
                    @endforeach
                  
                  @endif

                  </div>
                  <a style="margin-top: 25px; margin-bottom: 30px;" class="btn btn-primary btn-icon go_up {{$classes}}">IR A ARRIBA<i class="fa fa-arrow-up icon-btn"></i></a>
              </div>
          </div>
        </section>
      </div>
      <div class="col-lg-4 col-sm-push-1">
        
        <div class="lookbook-gallery">
          
          <a data-id="{{$task->id}}" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-warning btn-list-table adjuntar_soporte @if($task->estado==1){{'disabled'}}@endif" aria-haspopup="true" title="Adjuntar Soporte" aria-expanded="true"><i class="fa fa-paperclip" aria-hidden="true" style="font-size: 16px;"></i></a>

          <h3 class="h3 text-left mt-3 mb-4 pb-3">Adjuntos</h3>
          <div class="lookbook-grid" role="region">
            <div class="row">
              
                <?php 
                  if(isset($task->adjuntos)){

                    foreach (json_decode($task->adjuntos) as $key) {
                      ?>
                      <div class="col-lg-12">
                        
                        <a type="button" data-url="{{$key->nombre_imagen}}" class="btn btn-default btn-list-table show_img" data-id="" alt="" width="200px" height="150px" >Ver Imagen</a>

                        <figure class="model">

                          <?php
                          $dt = new DateTime($key->fecha);
                          ?>

                          <figcaption class="model--caption" style="margin-bottom: 10px; margin-top: 10px; font-size: 13px">
                            Subido por: <b>{{$key->usuario}}</b> el <b>{{$dt->format('Y-m-d')}}</b> a las <b>{{$dt->format('H:i')}}</b>
                          </figcaption>
                           
                        </figure>

                      </div>
                      <?php
                    }

                  }else{
                    ?>
                    <div class="col-lg-12">
                      <span class="h4 text-center mt-3 mb-4 pb-3">No hay adjuntos</span>
                    </div>
                    <?php
                  }
               ?>
              
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id='modal_adjuntar'>
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Adjuntar Soporte</b></h4>
            </div>
            <div class="modal-body">
              
              <div class="row">

                <center>

                  <form class="dropzone" id="my-dropzone">
                      <input type="hidden" name="id" value="{{$task->id}}" id="id_activity" class="id_activity">
                      <div class="dz-message" data-dz-message><span class="h4 text-center mt-3 mb-4 pb-3">Presiona para subir las imágenes</span></div>
                  </form>

                </center>
                
              </div>

            </div>

            <div class="modal-footer">
              <span style="float:left;" class="h4 text-center mt-3 mb-4 pb-3">*Las imagenes se subirán al presionar abrir en el explorador de archivos</span>

              <a class="btn btn-danger cerrar_modal btn-icon h4 text-center mt-3 mb-4 pb-3">CERRAR<i class="fa fa-times icon-btn"></i></a>
              
            </div>
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id='modal_img'>
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: white;">&times;</span></button>
              <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea h4 text-center mt-3 mb-4 pb-3">Soporte</b></h4>
            </div>
            <div class="modal-body">
              
              <div class="row">

                <center>

                  <img class="img_view img-responsive" src="" style="width: 100%; height: 100%">

                </center>
                
              </div>

            </div>

            <div class="modal-footer">
              
              <!--<a id="subir" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-check icon-btn"></i></a>-->
              
            </div>
        </div>
      </div>
    </div>

    @include('scripts.scripts')

    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/gestiondocumental.js')}}"></script>
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

    <script type="text/javascript">

    Dropzone.options.myDropzone = {
            autoProcessQueue: true,
            uploadMultiple: false,
            maxFilezise: 10,
            maxFiles: 8,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: 'dictCancelUploadConfirmation ',
            url: '../../tareas/ingresoimagenv2',
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

    $('.boton_guardar').click(function(){

      var nombre = $('#nombre_actividad').val().toUpperCase();
      var users = $('#proveedor_search').val();

      console.log('users : '+users)

      $.ajax({
        url: 'siigo/agregaractividad',
        method: 'post',
        data: {nombre: nombre, users: users}
      }).done(function(data){

        if(data.respuesta==true){
          alert('Success!!!')
        }else if(data.respuesta==false){

        }

      });

    });

    $('#comentar').keyup(function(e){
      
      if (e.which === 13) {
        
        if($(this).val()!=''){

          var task = $(this).attr('data-id');
          var comentario = $(this).val();

          $(this).val('').attr('disabled');
          $(this).addClass('disabled');
          $(this).attr('placeholder','Enviando comentario...')

          $.ajax({
            url: '../agregarcomentario',
            method: 'post',
            data: {task: task, comentario: comentario}
          }).done(function(data){

            if(data.response==true){
              
              $('#comentar').attr('placeholder','Escribe un comentario...')
              $('#comentar').removeAttr('disabled');
              $('#comentar').removeClass('disabled');

              if( $('.go_up').hasClass('hidden') ){
                //alert('tiene clase hidden')
                $('.go_up').removeClass('hidden')
                $('.go_down').removeClass('hidden')
              }
              $('.comments_bar').html('');

              //Actualizar la barra de comentarios

              var html = '';
              
              //var btn = '<button style="margin-top: 25px; margin-bottom: 30px;" class="btn btn-primary btn-icon go_down">IR AL FINAL<i class="fa fa-arrow-down icon-btn"></i></button>';

              //$('.comments_bar').append(btn);

              var cant = data.comentarios.length;
              console.log(cant)

              for(var i in data.comentarios){
                console.log(i)
                if(i == cant-1){
                  var borde = 'border-color: orange; border: 5px solid';
                }else{
                  var borde = '';
                }

                html = '<div class="comment mt-4 text-justify" style="width: 100%; margin-top: 20px; margin-right: 20px; '+borde+'">'+
                    '<img style="vertical-align: middle; width: 30px; height: 30px; border-radius: 50%;" src="https://app.aotour.com.co/autonet/biblioteca_imagenes/talentohumano/fotos/'+data.comentarios[i].foto+'" alt="" class="rounded-circle" width="40" height="40">'+
                    '<h4 style="margin-left: 4px">'+data.comentarios[i].user+'</h4>'+
                    '<span style="margin-left: 4px">'+data.comentarios[i].date+' '+data.comentarios[i].time+'</span>'+
                    '<br>'+
                    '<p style="margin-top: 6px" class="h4 text-left mt-3 mb-4 pb-3">'+data.comentarios[i].mensaje+'</p>'+
                '</div>';

                $('.comments_bar').append(html);

              }

              $('.comments_bar').removeClass('hidden');
              $('#comentar').val('');

              $("html, body").animate({ scrollTop: $(document).height() }, 1000);

            }else if(data.respuesta==false){

            }

          });

        }

      }

    });

    $('.adjuntar_soporte').click(function() {

      var id = $(this).attr('data-id');

      //alert(id)

      $('.id_Activity').val(id);

      $('#modal_opciones').modal('hide');
      $('#modal_adjuntar').modal('show');

    });

    $('.show_img').click(function(){

      var data = $(this).attr('data-url');

      var url = 'https://app.aotour.com.co/autonet/biblioteca_imagenes/actividades/diarias/'+data;

      $('.img_view').attr('src',url);
      $('#modal_img').modal('show');

    });
    $('.go_down').click(function(){
      //$("html, body").animate({ scrollTop: $(".go_down").scrollTo() }, 1000);
      $("html, body").animate({ scrollTop: $(document).height() }, 1000);
    });

    $('.go_up').click(function(){
      $("html, body").animate({ scrollTop: $(".comments_bar").scrollTop() }, 1000);
    });

    $('.cerrar_modal').click(function(){
      location.reload();
    })

    $('.eliminar_usuario').click(function(){

      var id = $(this).attr('data-id');
      var tarea_id = $(this).attr('tarea-id');
      var name = $(this).attr('data-name');

      //alert(tarea_id);

      $.confirm({
          title: 'Atención',
          content: 'Estás seguro de eliminar a '+name+' de esta tarea?<br><br>Se le notificará al usuario de su eliminación.',
          buttons: {
              confirm: {
                  text: 'Si, Eliminarlo!',
                  btnClass: 'btn-danger',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: '../eliminarusuario',
                      method: 'post',
                      data: {id: id, tarea_id: tarea_id}
                    }).done(function(data){

                      if(data.respuesta==true){
                        alert('¡Usuario Eliminado!');
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

    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();
    </script>

  </body>
</html>
