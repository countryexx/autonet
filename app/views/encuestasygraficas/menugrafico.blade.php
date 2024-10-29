<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Autonet | Encuestas y Graficas</title>
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('chartist-js-develop/dist/chartist.css')}}" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap/css/custom.css')}}">

  </head>
  <body>
    @include('admin.menu')
    <!--<a class="btn btn-primary" id="servicios_mes">GRAFICOS ENCUESTA POR CLIENTE ENTRE FECHAS</a>-->
    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
        <div class="row">
            <div class="col-lg-12">
                <form class="form-inline" id="form_buscar">
                    <div class="col-lg-12" style="margin-bottom: 5px">
                        <div class="row">
                            <div class="form-group" style="margin-bottom: 5px">
                                <select id="opcion_grafico" style="width: 164px;" class="form-control input-font">
                                    <option value="0">-</option>
                                    <option value="1">SERVICIOS DEL MES</option>
                                    <option value="2">SERVICIOS DEL AÑO</option>
                                    <option value="3">PORCENTAJE ENCUESTADO</option>
                                </select>
                            </div>
                            <button style="margin-bottom: 5px;" id="graficas" class="btn btn-default btn-icon">
                                GRAFICAR<i class="fa fa-bar-chart icon-btn"></i>
                            </button>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="row">
                                <div class="form-group hidden">
                                    <div class="input-group">
                                        <div class="input-group mes" id="mes">
                                            <input name="mes" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m')}}">
                                            <span class="input-group-addon" style="cursor: pointer;">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group hidden">
                                    <div class="input-group">
                                        <div class="input-group ano" id="ano">
                                            <input name="ano" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y')}}">
                                            <span class="input-group-addon" style="cursor: pointer;">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group hidden">
                                    <div class="input-group">
                                        <div class="input-group" id="fecha_inicial">
                                            <input name="fecha_inicial" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                                            <span class="input-group-addon" style="cursor: pointer;">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group hidden">
                                    <div class="input-group">
                                        <div class="input-group" id="fecha_final">
                                            <input name="fecha_final" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                                        <span class="input-group-addon" style="cursor: pointer;">
                                            <span class="fa fa-calendar">
                                            </span>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group hidden">
                                    <select id="centrodecosto_search" style="width: 164px;" class="form-control input-font" name="centrodecosto">
                                        <option value="0">CENTROS DE COSTO</option>
                                        @foreach($centrosdecosto as $centro)
                                            <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                                        @endforeach
                                    </select>
                                </div>
                              </div>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
            <div class='col-lg-8 col-md-8 col-sm-8'>
              <div class="ct-chart"></div>

            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="ct-pie" style="height: 300px;"></div>
            </div>
        </div>
    </div>

    @include('scripts.scripts')
    <script type="text/javascript" src="{{url('chartist-js-develop/dist/chartist.min.js')}}"></script>
    <script type="text/javascript" src="{{url('chartist-plugin-pointlabels-master/dist/chartist-plugin-pointlabels.min.js')}}"></script>
    <script type="text/javascript" src="{{url('chartist-plugin-pointlabels-master/dist/chartist-bar-labels.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script type="text/javascript" src="{{url('jquery/graficas.js')}}">

    </script>
  </body>
</html>
