<html>
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AOTOUR | Formulario de Limpieza de Vehículos</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">
    <style type="text/css">
      @import url('https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900');
      body {
          font-family: 'Roboto', sans-serif;
        }

      .card {
          width: 80%;
          margin: 10px auto;
          clear: both;
          display: block;
          padding: 0px 0px;
          background-color: #FF1700;
          border-radius: 4px;
      }
      .card::after {
          clear: both;
          display: block;
          content: "";
      }
      .card .checkbox-container {
          width: 100%;
          box-sizing: border-box;
          text-align:center;
        padding: 40px 0px;
      }
      .card .circular-container {
        background-color:#0067FF;
      }

      .input-title {
          clear: both;
          padding: 22px 0px 0px 0px;
          font-size: 16px;
          color: white;
          font-weight: 300;
      }




      /* Styling Checkbox Starts */
      .checkbox-label {
          display: block;
          position: relative;
          margin: auto;
          cursor: pointer;
          font-size: 22px;
          line-height: 24px;
          height: 24px;
          width: 24px;
          clear: both;
      }

      .checkbox-label input {
          position: absolute;
          opacity: 0;
          cursor: pointer;
      }

      .checkbox-label .checkbox-custom {
          position: absolute;
          top: 0px;
          left: 0px;
          height: 24px;
          width: 24px;
          background-color: transparent;
          border-radius: 5px;
          transition: all 0.3s ease-out;
          -webkit-transition: all 0.3s ease-out;
          -moz-transition: all 0.3s ease-out;
          -ms-transition: all 0.3s ease-out;
          -o-transition: all 0.3s ease-out;
          border: 2px solid #FFFFFF;
      }


      .checkbox-label input:checked ~ .checkbox-custom {
          background-color: #FF1700;
          border-radius: 5px;
          -webkit-transform: rotate(0deg) scale(1);
          -ms-transform: rotate(0deg) scale(1);
          transform: rotate(0deg) scale(1);
          opacity:1;
          border: 2px solid #FFFFFF;
      }


      .checkbox-label .checkbox-custom::after {
          position: absolute;
          content: "";
          left: 12px;
          top: 12px;
          height: 0px;
          width: 0px;
          border-radius: 5px;
          border: solid #009BFF;
          border-width: 0 3px 3px 0;
          -webkit-transform: rotate(0deg) scale(0);
          -ms-transform: rotate(0deg) scale(0);
          transform: rotate(0deg) scale(0);
          opacity:1;
          transition: all 0.3s ease-out;
          -webkit-transition: all 0.3s ease-out;
          -moz-transition: all 0.3s ease-out;
          -ms-transition: all 0.3s ease-out;
          -o-transition: all 0.3s ease-out;
      }


      .checkbox-label input:checked ~ .checkbox-custom::after {
        -webkit-transform: rotate(45deg) scale(1);
        -ms-transform: rotate(45deg) scale(1);
        transform: rotate(45deg) scale(1);
        opacity:1;
        left: 8px;
        top: 3px;
        width: 6px;
        height: 12px;
        border: solid #009BFF;
        border-width: 0 2px 2px 0;
        background-color: transparent;
        border-radius: 0;
      }



      /* For Ripple Effect */
      .checkbox-label .checkbox-custom::before {
          position: absolute;
          content: "";
          left: 10px;
          top: 10px;
          width: 0px;
          height: 0px;
          border-radius: 5px;
          border: 2px solid #FFFFFF;
          -webkit-transform: scale(0);
          -ms-transform: scale(0);
          transform: scale(0);    
      }

      .checkbox-label input:checked ~ .checkbox-custom::before {
          left: -3px;
          top: -3px;
          width: 24px;
          height: 24px;
          border-radius: 5px;
          -webkit-transform: scale(3);
          -ms-transform: scale(3);
          transform: scale(3);
          opacity:0;
          z-index: 999;
          transition: all 0.3s ease-out;
          -webkit-transition: all 0.3s ease-out;
          -moz-transition: all 0.3s ease-out;
          -ms-transition: all 0.3s ease-out;
          -o-transition: all 0.3s ease-out;
      }




      /* Style for Circular Checkbox */
      .checkbox-label .checkbox-custom.circular {
          border-radius: 50%;
          border: 2px solid #FFFFFF;
      }

      .checkbox-label input:checked ~ .checkbox-custom.circular {
          background-color: #FFFFFF;
          border-radius: 50%;
          border: 2px solid #FFFFFF;
      }
      .checkbox-label input:checked ~ .checkbox-custom.circular::after {
          border: solid #0067FF;
          border-width: 0 2px 2px 0;
      }
      .checkbox-label .checkbox-custom.circular::after {
          border-radius: 50%;
      }

      .checkbox-label .checkbox-custom.circular::before {
          border-radius: 50%;
          border: 2px solid #FFFFFF;
      }

      .checkbox-label input:checked ~ .checkbox-custom.circular::before {
          border-radius: 50%;
      }
    </style>
</head>

<body>
    <div class="container-fluid" >
      <form id="formulario">
        <div class="row">
            <center><img src="https://app.aotour.com.co/autonet/biblioteca_imagenes/logos_cotizacion.png" height="70px" width="300px" style="margin-top: 10px"></center>
            <div class="col-md-3">

            </div>
            <div class="col-md-6">
                <h4 style="text-align: center; margin: 20px 0 0 0; color: #FF1700;"><b>CONTROL DE LIMPIEZA Y DESINFECCIÓN DE VEHÍCULOS</b></h4>                
            </div>
            <div class="col-md-3">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-2">
                <label class="obligatorio" for="ciudad">Ciudad</label>
                <select class="form-control input-font" id="ciudad">
                    <option>-</option>
                        <option value="1" >BARRANQUILLA</option>
                        <option value="2" >BOGOTA</option>
                        <option value="1" >CARTAGENA</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="obligatorio" for="proveedor">Proveedor</label>
                <select disabled class="form-control input-font" name="proveedor" id="proveedor">
                    <option>-</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="obligatorio" for="conductor">Conductor</label>
                <select disabled class="form-control input-font" name="conductor" id="conductor">
                    <option>-</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="obligatorio" for="vehiculo">Vehículo</label>
                <select disabled class="form-control input-font" name="vehiculo" id="vehiculo">
                    <option>-</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="obligatorio" for="tipo_vehiculo">Tipo de Vehículo</label>
                <select class="form-control input-font" id="tipo_vehiculo">
                    <option>-</option>
                    <option>AUTOMOVIL</option>
                    <option>MINI VAN</option>
                    <option>VAN</option>
                    <option>BUSETA</option>
                    <option>BUS</option>
                    <option>OTRO</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="obligatorio" for="telefono">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-control input-font">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3 col-md-offset-4" >
                <label class="obligatorio" for="fecha">Fecha</label>
                <div class="input-group">
                    <div class="input-group date" id="datetimepicker1">
                        <input value="{{date('Y-m-d')}}" name="fecha" id="fecha" type="text" style="float: right; width: 300px;" class="form-control input-font">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                </div>

            </div>
            <div class="col-md-1">
            </div>          
        </div>
        <hr><center>
        <h5 style="color: #FF1700;"><b>LIMPIEZA Y DESINFECCIÓN</b></h5></center>
        <hr>
        <div class="row">            
          <div class="card">
            <div class="checkbox-container">
            <label class="checkbox-label">
                <input type="checkbox" name="dato1" id="dato1">
                <span class="checkbox-custom rectangular"></span>
            </label>
            <div class="input-title">Doy fé de la realización de la limpieza y desinfección al inicio de ruta, donde se limpiaron y desinfectaron los puntos de contacto frecuente de los usuarios y la realización del aseo del vehículo.</div>
            </div>            
        </div>                       
        </div>            
        <hr> <center>
        <h5 style="color: #FF1700;"><b>ELEMENTOS DE LIMPIEZA</b></h5></center>
        <hr>
        <div class="row">          
          <div class="card">
            <div class="checkbox-container">
              <label class="checkbox-label">
                  <input type="checkbox" name="dato2" id="dato2">
                  <span class="checkbox-custom rectangular"></span>
              </label>
              <div class="input-title">Se realiza limpieza con los elementos indicados por el ministerio de salud y los epp adecuados.
              </div>
            </div>       
          </div>                 
        </div>       

    <hr>
      <input type="checkbox" name="politicas" id="politicas" style="vertical-align: sub; float: right;">
      <label style="margin-right: 5px; color: #FF1700; display: inline; font-size: 15px; float: right;"><b>Acepto las políticas.</b></label>
      <br><br>
      <button style="margin-bottom: 7px; float: right;" type="button" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal2">
          Ver Info<i class="fa fa-info icon-btn"></i>
      </button><br>
    <center>
        <button type="submit" id="guardarform" style="background: #FF1700; color: white; margin: 25px 0 50px 50px;" class="btn btn-primary btn-icon input-font">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
    </center>
      </form>
    </div>    

    <div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="margin: 40px;">      
      <div class="modal-content">
        <div class="modal-header" style="background-color: #FF1700">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <center> <strong style="font-family: 'Roboto', sans-serif;">DECLARACIÓN DE REALIZACIÓN DE LIMPIEZA Y DESINFECCIÓN VEHICULAR</strong></center>
        </div>
        @include('modales.politicas')
      </div>
  </div>

    <div class="section" id="mensajes">

    </div>

<div class="errores-modal bg-danger text-danger hidden model" style="background: #FF1700; color: white">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    </ul>
</div>
<div class="guardado bg-success text-success hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul style="margin: 0;padding: 0;">
    </ul>
</div>
<form action="downloadpdf" method="get">
    <div class="hidden">
    <div class="col-md-2">
        <label class="obligatorio" for="nombrec">Nombre</label>
        <input type="text" name="nombrec" id="nombrec" class="form-control input-font">
    </div>
    <div class="col-md-2">
        <label class="obligatorio" for="ciudadpdf">Ciudad</label>
        <input type="text" name="ciudadpdf" id="ciudadpdf" class="form-control input-font">
    </div>
    <div class="col-md-2">
        <label class="obligatorio" for="fechapdf">Fecha</label>
        <input type="text" name="fechapdf" id="fechapdf" class="form-control input-font">
    </div>
    <div class="col-md-2">
        <label class="obligatorio" for="nombrep">Teléfono</label>
        <input type="text" name="nombrep" id="nombrep" class="form-control input-font">
    </div>
    <button type="submit" id="pdf1" style="background: #FF1700; color: white; margin: 25px 0 50px 50px;" class="btn btn-primary btn-icon input-font">Guardar<i class="fa fa-floppy-o icon-btn pdf1"></i></button>
  </div>
</form>

@include('scripts.scripts')

<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/provisional.js')}}"></script>

</body>
</html>
