<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Historial mensajes</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
</head>
<body>

@include('admin.menu')
<div class="col-xs-12">
    <div class="col-lg-8">
      <div class="row">
          @include('talentohumano.historial_mensajes')
      </div>
    </div>
    <div class="col-lg-12">
      <div class="row">
        <h3 class="h_titulo">HISTORIAL DE MENSAJES</h3>
      </div>
    </div>

    @if(isset($welcome))
      <table id="examplew" class="table table-bordered hover" cellspacing="0" width="100%">
          <thead>
            <tr>
                <th>Fecha de Creación</th>
                <th>Nombre</th>
                <th>Mensaje</th>
                <th>Sección 1</th>
                <th>Sección 2</th>
                <th></th>
            </tr>
          </thead>
          <tfoot>
          <tr>
            <th>Fecha de Creación</th>
            <th>Nombre</th>
            <th>Mensaje</th>
            <th>Sección 1</th>
            <th>Sección 2</th>
            <th></th>
          </tr>
          </tfoot>
          <tbody>
          @foreach($welcome as $proveedor)
            <tr>
              <td>{{$proveedor->created_at}}</td>
              <td>{{$proveedor->nombre}}</td>
              <td>{{$proveedor->mensaje}}</td>
              <td><button data-value="{{$proveedor->id}}" data-url="{{$proveedor->pdf}}" data-razon="{{$proveedor->nombre}}" class="btn btn-success ver_pdf">VER CERTIFICACIÓN <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button></td>
              <td><button data-value="{{$proveedor->id}}" data-url="{{$proveedor->pdf2}}" data-razon="{{$proveedor->nombre}}" class="btn btn-success ver_pdf">VER CERTIFICACIÓN <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button></td>
              <td id="{{$proveedor->id}}">
                <span>acciones</span>
              </td>
            </tr>
          @endforeach
          </tbody>
      </table>
    @endif
    
    <a class="btn btn-primary btn-icon" onclick="goBack()">Volver<i class="fa fa-reply icon-btn"></i></a>
</div>

<!-- MODAL PDF -->
    <div class="modal fade" tabindex="-1" role="dialog" id='modal_pdf'>
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #ED7606">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" style="text-align: center;" id="name"></h4>
            </div>
            <div class="modal-body">
              <div class="documento">
                <span id="division_ver"></span>
              </div>              
            </div>
            <div class="modal-footer">
              <div class="row">
                <div class="col-md-9">
                  <p id="novedades_modal" style="text-align: left;"></p>
                </div>
                <div class="col-md-3">
                  <button type="button" class="btn btn-default" data-dismiss="modal" style="background: #B1B2B4">Cerrar</button>
                </div>
              </div>                    
            </div>
        </div>
      </div>
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
<script src="{{url('jquery/control.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script type="text/javascript">
    function goBack(){
        window.history.back();
    }

    $('input[type=file]').bootstrapFileInput(); 
    $('.file-inputs').bootstrapFileInput();

</script>
</body>
</html>
