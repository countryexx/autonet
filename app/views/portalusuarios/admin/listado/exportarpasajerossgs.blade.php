<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Exportar Pasajeros</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="manifest" href="{{url('manifest.json')}}">
    <script src="https://maps.googleapis.com/maps/api/js?key={{$_ENV['API_KEY_GOOGLE_MAPS']}}" async defer></script>
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGM6WeUAlFGPSsT5pCtu-wRzrEC-pt4yw" async defer></script>-->
    <style>

      #map{
        height: 80%;
        width: 100%;
        z-index: 1;
      }

      [data-notify="progressbar"] {
	      	margin-bottom: 0px;
	      	position: absolute;
	      	bottom: 0px;
	      	left: 0px;
	      	width: 100%;
	      	height: 5px;
      }

    </style>
</head>
<body>
	@include('admin.menu')

  <div class="container-fluid">

    <div class="row" style="margin-top: 150px">
      <div class="col-lg-5">
        <div class="panel panel-default" >
            <div class="panel-body" style=" height: 300px; width: 100%">
                <div class="col-xs-12">
                    <div class="row">
                        <h3 style="text-align: center;">Exportar Bitácora</h3>
                        <br>
                    </div>
                    @if(Sentry::getUser()->id_rol==38)
                      <form id="form" action="{{url('portalusu/exportarlistadodia')}}" method="post">
                    @else
                      <form id="form" action="{{url('portalusu/exportarlistadosgs')}}" method="post">
                    @endif
                      <div class="row">
                          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                              <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
                              <div class="input-group">
                                <div class="input-group date" id="datetimepicker1">
                                    <input value="{{date('Y-m-d')}}" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                </div>
                              </div>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                              <label class="obligatorio" for="rt_fecha_final">Fecha Final</label>
                              <div class="input-group">
                                <div class="input-group date" id="datetimepicker1">
                                    <input value="{{date('Y-m-d')}}" name="md_fecha_final" style="width: 115;" type="text" class="form-control input-font">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                </div>
                              </div>
                          </div>

                          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label class="obligatorio" for="subcentrodecosto_ex_excel">Exportar</label>
                            <div class="input-group">
                                <button type="submit" id="exportar_rutas_pasajeros" class="btn btn-success btn-icon">GENERAR ARCHIVO EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
                            </div>
                          </div>
                      </div>
                      <br>
                      @if(Sentry::getUser()->id_rol!=38)
                        <div class="row">
                            <div class="col-xs-3">
                              <label style="margin-top: 10px" class="obligatorio" for="centrodecosto_ex_excel">Centro de costo</label>
                            </div>
                            <div class="col-xs-9">
                              <select name="centro" id="centro" type="text" class="form-control input-font centrodecosto_ex_excel">
                                  <option>-</option>
                                  @foreach($centrosdecosto as $centro)
                                      <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                      @endif
                    </form>
                  <div class="row" style="margin: 20px 0 0 0px">
                    <p style="font-size: 20px">Descarga de bitácora de rutas con valores de liquidación.</p>
                  </div>
              </div>
            </div>
        </div>
      </div>

      <!-- new novedades -->
      @if(Sentry::getUser()->id_rol!=38)
        <div class="col-lg-5 col-lg-offset-1">
          <div class="panel panel-default" >
              <div class="panel-body" style=" height: 300px; width: 100%">
                  <div class="col-xs-12">
                      <div class="row">
                          <h3 style="text-align: center;">Exportar Novedades</h3>
                          <br>
                      </div>

                        <form id="form" action="{{url('portalusu/exportarnovporfechas')}}" method="post">

                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label class="obligatorio" for="fecha">Fecha Inicial</label>
                                <div class="input-group">
                                  <div class="input-group date" id="datetimepicker1">
                                      <input value="{{date('Y-m-d')}}" name="fecha" style="width: 115;" type="text" class="form-control input-font">
                                      <span class="input-group-addon">
                                          <span class="fa fa-calendar">
                                          </span>
                                      </span>
                                  </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label class="obligatorio" for="md_fecha_final">Fecha Final</label>
                                <div class="input-group">
                                  <div class="input-group date" id="datetimepicker1">
                                      <input value="{{date('Y-m-d')}}" name="md_fecha_final" style="width: 115;" type="text" class="form-control input-font">
                                      <span class="input-group-addon">
                                          <span class="fa fa-calendar">
                                          </span>
                                      </span>
                                  </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                              <label class="obligatorio" for="subcentrodecosto_ex_excel">Exportar</label>
                              <div class="input-group">
                                  <button type="submit" id="exportar_rutas_pasajeros" class="btn btn-success btn-icon">Descargar Novs<i class="fa fa-file-excel-o icon-btn"></i></button>
                              </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-xs-3">
                              <label style="margin-top: 10px" class="obligatorio" for="centrodecosto_ex_excel">Centro de costo</label>
                            </div>
                            <div class="col-xs-9">
                              <select name="cc" id="cc" type="text" class="form-control input-font centrodecosto_ex_excel">
                                  <option>-</option>
                                  @foreach($centrosdecosto as $centro)
                                      <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                        
                      </form>
                    <div class="row" style="margin: 20px 0 0 0px">
                      <p style="font-size: 20px"> Descarga de novedades de rutas.</p>
                    </div>
                </div>
              </div>
          </div>
        </div>
      @endif
      <!-- new novedades end -->

      <!--<div class="col-lg-4 col-lg-offset-1">
        <div class="panel panel-default" >
            <div class="panel-body" style=" height: 300px; width: 100%">
                <div class="col-xs-12">
                    <div class="row">
                        <h3 style="text-align: center; font-family: times new roman">EXPORTAR NOVEDADES</h3>
                    </div>

                      <form id="form" action="{{url('portalusu/exportarlistadoemergia')}}" method="post">

                      <div class="row">
                          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                              <label class="obligatorio" for="fecha">Fecha Inicial</label>
                              <div class="input-group">
                                <div class="input-group date" id="datetimepicker1">
                                    <input value="{{date('Y-m-d')}}" name="fecha" style="width: 115;" type="text" class="form-control input-font">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                </div>
                              </div>
                          </div>

                          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                              <label class="obligatorio" for="md_fecha_final">Fecha Final</label>
                              <div class="input-group">
                                <div class="input-group date" id="datetimepicker1">
                                    <input value="{{date('Y-m-d')}}" name="md_fecha_final" style="width: 115;" type="text" class="form-control input-font">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                </div>
                              </div>
                          </div>

                          @if(Sentry::getUser()->id_rol!=38)
                            <div class="row">
                                <div class="col-xs-3">
                                  <label style="margin-top: 10px" class="obligatorio" for="centrodecosto_ex_excel">Centro de costo</label>
                                </div>
                                <div class="col-xs-9">
                                  <select name="cc" id="cc" type="text" class="form-control input-font centrodecosto_ex_excel">
                                      <option>-</option>
                                      @foreach($centrosdecosto as $centro)
                                          <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                                      @endforeach
                                  </select>
                                </div>
                            </div>
                          @endif

                          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label class="obligatorio" for="subcentrodecosto_ex_excel">Exportar</label>
                            <div class="input-group">
                                <button type="submit" id="exportar_rutas_pasajeros" class="btn btn-success btn-icon">DESCARGAR EMERGIA<i class="fa fa-download icon-btn"></i></button>
                            </div>
                          </div>
                      </div>
                      <br>

                    </form>
                  <div class="row" style="margin: 20px 0 0 0px">
                    <p style="font-size: 20px">Descarga de novedades de rutas: Emergia.</p>
                  </div>
              </div>
            </div>
        </div>
      </div>-->

    </div>

  </div>


    @include('scripts.scripts')

</body>
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/conductores.js')}}"></script>

<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('datatables/media/js/dataTables.bootstrap.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/pasajeros.js')}}"></script>
<script></script>
<script language="JavaScript" type="text/JavaScript">
  function selODessel(obj){
    if(obj.checked){
        console.log("chulado")
    }else{
        //desSeleccionarTodos();
        console.log("DesChulado")
    }
  }

  function seleccionarTodos(){
    alert("Selecciono todos")
  }
  function desSeleccionarTodos(){
    alert("Desselecciono todos")
  }


</script>
</html>
