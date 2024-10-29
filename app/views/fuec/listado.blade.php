<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Listado Fuec</title>
    @include('scripts.styles')
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
  </head>
  <body >
  @include('admin.menu')
  @include('fuec.breadcrumb')
  <div class="col-lg-12">
      <h3 class="h_titulo">LISTADO DE PROVEEDORES</h3>
      <form class="form-inline" id="form_buscar">
          <div class="col-lg-12" style="margin-bottom: 5px">
              <div class="row">
                  <div class="form-group">
                    <select id="proveedores" class="form-control input-font">
                      <option value="0">-</option>
                      @foreach ($proveedores as $key => $proveedor)
                      <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                      @endforeach
                    </select>
                  </div>
                  <button id="buscar" class="btn btn-default btn-icon">
                      Buscar<i class="fa fa-search icon-btn"></i>
                  </button>
              </div>
          </div>
      </form>
      <table id="listado_proveedores_fuec" class="table table-bordered hover" cellspacing="0" width="100%">
          <thead>
          <tr>
            <th>#</th>
            <th>Proveedor</th>
            <th>Vehiculo</th>
            <th>Informacion</th>
          </tr>
          </thead>
          <tfoot>
          <tr>
            <th>#</th>
            <th>Proveedor</th>
            <th>Vehiculo</th>
            <th>Informacion</th>
          </tr>
          </tfoot>
          <tbody>

          </tbody>
      </table>
  </div>

  <script src="{{url('dist/fuec.js')}}"></script>
  <script>

    window.onload=function(){
      var pos=window.name || 0;
      window.scrollTo(0,pos);
    }
    window.onunload=function(){
        window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
    }

    function nobackbutton(){

       window.location.hash="no-back-button";

       window.location.hash="Again-No-back-button" //chrome

       window.onhashchange=function(){
         window.location.hash="no-back-button";
       }
    }

  </script>
  </body>
  </html>
