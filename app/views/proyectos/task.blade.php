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
          <img src="{{url('img/task.png')}}" width="40px" height="50px" alt="Avatar" style="margin-left: 18px;">
          <div class="container">
            <h4>{{ $task->nombre }} @if($task->asignado_por!=null) <b style="color: orange">- ASIGNADA POR {{$task->nombres. ' '.$task->apellidos}}</b> @endif</h4>
            <h6 style="font-family: monospace;;">{{ $task->descripcion }}</h6>
            <p style="font-family: cursive;">Compartida con...</p>

            @if($task->implicados!=null)

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
                  <img src="http://localhost/autonet/biblioteca_imagenes/talentohumano/fotos/{{$foto}}" alt="Avatar" class="avatar" title="{{$nombres.' '.$apellidos}}">
                  <?php

                }
            ?>

          @endif

            
          </div>
        </div>
        
        <section>
          <div class="row">
              <div class="col-sm-12 col-md-12">
                  <h1>Comentarios</h1>
                  
                  <div class="form-outline mb-8">
                    <input type="text" data-id="{{$task->id}}" id="comentar" class="form-control" placeholder="Escribe un comentario..." />
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
                            <p style="margin-top: 6px">{{$json->mensaje}}</p>
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

          <h2 class="h2 text-left mt-3 mb-4 pb-3">Adjuntos</h2>
          <div class="lookbook-grid" role="region">
            <div class="row">
              
                <?php 
                  if(isset($task->adjuntos)){

                    foreach (json_decode($task->adjuntos) as $key) {
                      ?>
                    <div class="col-lg-12">
                      
                      <figure class="model">
                      <img class="show_img" data-url="{{$key->nombre_imagen}}" style="width: 100%" src="{{url('biblioteca_imagenes/actividades/diarias/'.$key->nombre_imagen)}}" />
                       <figcaption class="model--caption" style="margin-bottom: 10px">
                        Subido por: <b>{{$key->usuario}}</b> at <b>{{$key->fecha}}</b>
                      </figcaption>
                    </figure>
                      

                      </div>
                      <?php
                    }

                  }else{
                    ?>
                    
                    <span class="h4 text-center mt-3 mb-4 pb-3">No hay adjuntos</span>

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
              <a data-dismiss="modal" class="btn btn-danger btn-icon h4 text-center mt-3 mb-4 pb-3">CERRAR<i class="fa fa-times icon-btn"></i></a>
              
            </div>
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id='modal_img'>
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea h4 text-center mt-3 mb-4 pb-3">Soporte</b></h4>
            </div>
            <div class="modal-body">
              
              <div class="row">

                <center>

                  <img class="img_view" src="" style="width: 100%; height: 100%">

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
            maxFilezise: 1,
            maxFiles: 4,
            addRemoveLinks: 'dictCancelUploadConfirmation ',
            url: '../../siigo/ingresoimagenv2',
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

          $.ajax({
            url: '../agregarcomentario',
            method: 'post',
            data: {task: task, comentario: comentario}
          }).done(function(data){

            if(data.response==true){
              
              if( $('.go_up').hasClass('hidden') ){
                alert('tiene clase hidden')
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
                    '<img style="vertical-align: middle; width: 30px; height: 30px; border-radius: 50%;" src="http://localhost/autonet/biblioteca_imagenes/talentohumano/fotos/'+data.comentarios[i].foto+'" alt="" class="rounded-circle" width="40" height="40">'+
                    '<h4 style="margin-left: 4px">'+data.comentarios[i].user+'</h4>'+
                    '<span style="margin-left: 4px">'+data.comentarios[i].date+' '+data.comentarios[i].time+'</span>'+
                    '<br>'+
                    '<p style="margin-top: 6px">'+data.comentarios[i].mensaje+'</p>'+
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

      var url = 'http://localhost/autonet/biblioteca_imagenes/actividades/diarias/'+data;

      $('.img_view').attr('src',url);
      $('#modal_img').modal('show');

    });
    $('.go_down').click(function(){
      $("html, body").animate({ scrollTop: $(document).height() }, 1000);
    });

    $('.go_up').click(function(){
      $("html, body").animate({ scrollTop: $(".comments_bar").scrollTop() }, 1000);
    });

    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();
    </script>

  </body>
</html>
