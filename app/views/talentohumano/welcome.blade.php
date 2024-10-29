<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Autonet | Welcome</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
     <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">

    <style>

      
    </style>
  </head>
  <body>
    @include('admin.menu')
    <div class="col-lg-12">
      @include('talentohumano.menu_bienvenida')
      <h3 class="h_titulo">CONFIGURACIÓN DE VISTA DE BIENVENIDA</h3>
      <div style="margin-top: 5px;" class="col-lg-8">
        
        <div class="row">
          <div class="panel panel-default">
            <div class="panel-heading" style="background: orange">HABILITACIÓN &#x231a;</div>
            <div class="panel-body" style="border: 1px solid orange">
              <div class="row">
                <div class="col-lg-5">
                  <label class="obligatorio">Nombre</label>
                  <input type="text" name="nombre" id="nombre" class="form-control input-font">
                </div>
                <div class="col-lg-10" style="margin-top: 25px">
                  <label class="obligatorio">Mensaje Principal</label>
                  <textarea rows="4" type="text" cols="100" id="mensaje" class="form-control input-font"></textarea>
                </div>
                <!--<div class="col-lg-2">
                  <button id="observacion" type="button" name="button" data-toggle="modal" class="btn btn-info emoji" data-id="" data-nombre="" style="margin-top: 100px">Insertar Emojis <i class="fa fa-plus" aria-hidden="true"></i></button>
                </div>-->
              </div>              
              <div class="row" style="margin-top: 15px">
                <div class="col-lg-6">                  
                  <!--<input type="radio" id="pdf" name="gender" value="male">                  
                  <label for="male">PDF</label> -->
                  <span><b>SECCIÓN 1</b></span><br>
                  <input type="radio" id="video" name="gender" value="female">
                  <label for="female">VIDEO</label>
                  <input type="radio" id="imagen" name="gender" value="other">
                  <label for="other">IMAGEN</label>
                </div>
                <div class="col-lg-6">                  
                  <!--<input type="radio" id="pdf2" name="gender2" value="male">
                  <label for="male">PDF</label>-->
                  <span><b>SECCIÓN 2</b></span><br>
                  <input type="radio" id="video2" name="gender2" value="female">
                  <label for="female">VIDEO</label>
                  <input type="radio" id="imagen2" name="gender2" value="other">
                  <label for="other">IMAGEN</label>
                </div>
              </div>
              <div class="row">
                <form id="formulario">
                <div class="col-lg-6">
                  <!-- COLUMNA 1 -->
                  <div class="row hidden pdffile">
                    <div class="col-lg-6">
                      <div class="d-flex justify-content-center">
                        <div class="btn btn-mdb-color btn-rounded float-left">
                          <span>Seleccionar Archivo</span>
                          <input type="file" name="pdfh" id="pdfh" accept="application/pdf" data-filename-placement="inside">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row hidden videofile">
                    <div class="col-lg-6">
                      <input style="margin-top: 10px; margin-bottom: 15px" type="text" name="text_video" id="text_video" rows="8" class="form-control input-font" placeholder="Introduzca aquí un subtítulo">
                      <textarea style="margin-bottom: 10px" rows="8" type="text" cols="100" id="video1" class="form-control input-font" placeholder="INTRODUZCA EL CÓDIGO DE INSERCIÓN DEL VÍDEO"></textarea>                      
                      <!--<iframe src="http://localhost/autonet/biblioteca_imagenes/mantenimiento_fact/1043027866HojaDeVidaKatiuska.pdf"></iframe>-->
                    </div>
                  </div>
                  <div class="row hidden imagenfile" style="margin-bottom: 15px; margin-top: 10px">
                    <div class="col-lg-6">
                        <input style="margin-bottom: 15px" type="text" name="text_video" id="text_imagen" rows="8" class="form-control input-font" placeholder="Introduzca aquí un subtítulo">
                        <input id="foto_perfil" class="foto_perfil" accept="image/jpeg" type="file" value="Subir" name="foto_perfil" >
                    </div>                
                  </div>
                </div>
                <div class="col-lg-6">
                  <!-- COLUMNA 2 -->
                  <div class="row hidden pdffile2">
                    <div class="col-lg-6">
                      <div class="d-flex justify-content-center">
                        <div class="btn btn-mdb-color btn-rounded float-left">
                          <span>Seleccionar Archivo</span>
                          <input type="file" name="pdff" id="pdff" accept="application/pdf" data-filename-placement="inside">
                        </div>
                      </div><!--
                      <label class="obligatorio" for="celular" >Documento PDF</label>
                      <input type="file" class="form-control" name="pdf" id="pdf" accept="application/pdf" data-filename-placement="inside">-->
                    </div>
                  </div>
                  <div class="row hidden videofile2">
                    <div class="col-lg-6">
                      <input style="margin-top: 10px; margin-bottom: 15px" type="text" name="text_video2" id="text_video2" rows="8" class="form-control input-font" placeholder="Introduzca aquí un subtítulo">
                     <textarea rows="8" type="text" cols="100" id="video22" class="form-control input-font" placeholder="INTRODUZCA EL CÓDIGO DE INSERCIÓN DEL VÍDEO"></textarea>
                    </div>
                  </div>
                  <div class="row hidden imagenfile2" style="margin-bottom: 15px; margin-top: 10px">
                    <div class="col-lg-6">
                      <input style="margin-bottom: 15px" type="text" name="text_video" id="text_imagen2" rows="8" class="form-control input-font" placeholder="Introduzca aquí un subtítulo">
                        <input id="foto_perfil2" class="foto_perfil" accept="image/jpeg" type="file" value="Subir" name="foto_perfil2" >
                    </div>                
                  </div>
                </div>
                </form>
              </div>

              <div class="row" style="margin-top: 20px">
                <div class="col-lg-12">
                  <button type="button" name="button" data-toggle="modal" class="btn btn-primary guardar_mensaje" data-uno="0" data-dos="0" data-id="" id="save_message" style="color: white">GUARDAR <i class="fa fa-floppy-o" aria-hidden="true"></i>
                </button>
                </div>                
              </div>

              <!-- -->
            
          </div>
        </div>
        
      </div>

      <!-- MODAL DE OBSERVACIONES -->
      <div class="modal" tabindex="-1" role="dialog" id='modal_emoji' style="margin-top: 60px">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            
            <div class="modal-body" style="opacity: 2.2">
              <div class="row">
                @foreach($emoticones as $emoticon)
                <div class="col-lg-1">
                  <a class="selec" data="{{$emoticon->codigo}}" style="font-size: 30px">{{$emoticon->codigo}}</a>
                </div>
                @endforeach
              </div>
            </div>
            
          </div>
        </div>
      </div>
    <!-- FIN OBSERVACIONES -->

    </div>
  
  @include('scripts.scripts')
  <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
  <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <script src="{{url('jquery/control.js')}}"></script>

  <script type="text/javascript">
    $('input[type=file]').bootstrapFileInput(); 
    $('.file-inputs').bootstrapFileInput();
  </script>
  </body>
</html>
