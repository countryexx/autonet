<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autonet | Solicitud de Servicio</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="manifest" href="{{url('manifest.json')}}">
   <!-- <script src="https://maps.googleapis.com/maps/api/js?key={{$_ENV['API_KEY_GOOGLE_MAPS']}}" async defer></script>-->
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGM6WeUAlFGPSsT5pCtu-wRzrEC-pt4yw" async defer></script>-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>

    $( function() {
        $( "#datepicker" ).datepicker();
    });

    $( function() {
        $( "#datepicker2" ).datepicker();
    });

    </script>

    <style>

        /*card start*/
        * {
                padding: 0;
                margin: 0;
                box-sizing: border-box;
            }

            body {
                background: #ddeefc;
                font-family: 'Lato', sans-serif;
            }

            .contenedor {
                width: 90%;
                max-width: 1000px;
                padding: 40px 20px;
                margin: auto;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            /* ---------- Estilos Generales de las Tarjetas ----------*/
            .tarjeta {
                width: 100%;
                height: 50%;
                max-width: 450px;
                position: relative;
                color: #fff;
                transition: .3s ease all;
                transform: rotateY(0deg);
                transform-style: preserve-3d;
                cursor: pointer;
                z-index: 2;
            }

            .tarjeta.active {
                transform: rotateY(180deg);
            }

            .tarjeta > div {
                padding: 20px;
                border-radius: 15px;
                min-height: 315px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                box-shadow: 0 10px 10px 0 rgba(90,116,148,0.3);
            }

            /* ---------- Tarjeta Delantera ----------*/

            .tarjeta .delantera {
                width: 100%;
                background: url(https://app.aotour.com.co/autonet/img/img/bg-tarjeta/bg-tarjeta-02.jpg);
                background-size: cover;
            }

            .delantera .logo-marca {
                text-align: right;
                min-height: 50px;
            }

            .delantera .logo-marca img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                max-width: 80px;
            }

            .delantera .chip {
                width: 100%;
                max-width: 50px;
                margin-bottom: 20px;
            }

            .delantera .grupo .label {
                font-size: 16px;
                color: #7d8994;
                margin-bottom: 5px;
            }

            .delantera .grupo .numero,
            .delantera .grupo .nombre,
            .delantera .grupo .expiracion {
                color: #fff;
                font-size: 22px;
                text-transform: uppercase;
            }

            .delantera .flexbox {
                display: flex;
                justify-content: space-between;
                margin-top: 20px;
            }

            /* ---------- Tarjeta Trasera ----------*/
            .trasera {
                background: url(https://app.aotour.com.co/autonet/img/img/bg-tarjeta/bg-tarjeta-02.jpg);
                background-size: cover;
                position: absolute;
                top: 0;
                transform: rotateY(180deg);
                backface-visibility: hidden;
            }

            .trasera .barra-magnetica {
                height: 40px;
                background: #000;
                width: 100%;
                position: absolute;
                top: 30px;
                left: 0;
            }

            .trasera .datos {
                margin-top: 60px;
                display: flex;
                justify-content: space-between;
            }

            .trasera .datos p {
                margin-bottom: 5px;
            }

            .trasera .datos #firma {
                width: 70%;
            }

            .trasera .datos #firma .firma {
                height: 40px;
                background: repeating-linear-gradient(skyblue 0, skyblue 5px, orange 5px, orange 10px);
            }

            .trasera .datos #firma .firma p {
                line-height: 40px;
                font-family: 'Liu Jian Mao Cao', cursive;
                color: #000;
                font-size: 30px;
                padding: 0 10px;
                text-transform: capitalize;
            }

            .trasera .datos #ccv {
                width: 20%;
            }

            .trasera .datos #ccv .ccv {
                background: #fff;
                height: 40px;
                color: #000;
                padding: 10px;
                text-align: center;
            }

            .trasera .leyenda {
                font-size: 14px;
                line-height: 24px;
            }

            .trasera .link-banco {
                font-size: 14px;
                color: #fff;
            }

            /* ---------- Contenedor Boton ----------*/
            .contenedor-btn .btn-abrir-formulario {
                width: 50px;
                height: 50px;
                font-size: 20px;
                line-height: 20px;
                background: #2364d2;
                color: #fff;
                position: relative;
                top: -25px;
                z-index: 3;
                border-radius: 100%;
                box-shadow: -5px 4px 8px rgba(24,56,182,0.4);
                padding: 5px;
                transition: all .2s ease;
                border: none;
                cursor: pointer;
            }

            .contenedor-btn .btn-abrir-formulario:hover {
                background: #1850b1;
            }

            .contenedor-btn .btn-abrir-formulario.active {
                transform: rotate(45deg);
            }

            /* ---------- Formulario Tarjeta ----------*/
            .formulario-tarjeta {
                background: #fff;
                width: 100%;
                max-width: 700px;
                padding: 120px 30px 30px 30px;
                border-radius: 10px;
                position: relative;
                top: -150px;
                z-index: 1;
                clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
                transition: clip-path .3s ease-out;
            }

            .formulario-tarjeta.active {
                clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
            }

            .formulario-tarjeta label {
                display: block;
                color: #7d8994;
                margin-bottom: 5px;
                font-size: 16px;
            }

            .formulario-tarjeta input,
            .formulario-tarjeta select,
            .btn-enviar {
                border: 2px solid #CED6E0;
                font-size: 18px;
                height: 50px;
                width: 100%;
                padding: 5px 12px;
                transition: .3s ease all;
                border-radius: 5px;
            }

            .formulario-tarjeta input:hover,
            .formulario-tarjeta select:hover {
                border: 2px solid #93BDED;
            }

            .formulario-tarjeta input:focus,
            .formulario-tarjeta select:focus {
                outline: rgb(4,4,4);
                box-shadow: 1px 7px 10px -5px rgba(90,116,148,0.3);
            }

            .formulario-tarjeta input {
                margin-bottom: 20px;
                text-transform: uppercase;
            }

            .formulario-tarjeta .flexbox {
                display: flex;
                justify-content: space-between;
            }

            .formulario-tarjeta .expira {
                width: 100%;
            }

            .formulario-tarjeta .ccv {
                min-width: 100px;
            }

            .formulario-tarjeta .grupo-select {
                width: 100%;
                margin-right: 15px;
                position: relative;
            }

            .formulario-tarjeta select {
                -webkit-appearance: none;
            }

            .formulario-tarjeta .grupo-select i {
                position: absolute;
                color: #CED6E0;
                top: 18px;
                right: 15px;
                transition: .3s ease all;
            }

            .formulario-tarjeta .grupo-select:hover i {
                color: #93bfed;
            }

            .formulario-tarjeta .btn-enviar {
                border: none;
                padding: 10px;
                font-size: 22px;
                color: #fff;
                background: #2364d2;
                box-shadow: 2px 2px 10px 0px rgba(0,85,212,0.4);
                cursor: pointer;
            }

            .formulario-tarjeta .btn-enviar:hover {
                background: #1850b1;
            }
        /*card end*/

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

      /*estilo angosto y redondeado*/

        #navega #menu #fijo {
            position:fixed;
            font-family:verdana,arial;
            font-size:11pt;
            text-align:center;
            padding: 10px 5px 10px 5px;    /* margen con valores: arriba - derecha - abajo - izquierda */
            top: 0px;                    /* Distancia hasta el borde superior */
            left: 0px;            /* Distancia hasta el borde izquierdo */
            width:100%;
            background-color: #F2F3EB;
            z-index: 1;               /* hace que la capa sea opaca  */
        }

        #texto {
            position:absolute;
            margin: 20px 5px 10px 5px;    /* margen con valores: arriba - derecha - abajo - izquierda */
            font-family:verdana,arial;
            font-size:10pt;
        }

        .activo {
            padding: 10px;
            background-color: gray;
            text-align: center;
        }

        .inactivo {
            padding: 10px;
            background-color: gray;
            text-align: center;
        }

        /* new */

        @import url(https://fonts.googleapis.com/css?family=Montserrat:400,700);

        html {
          font-family: 'Montserrat', Arial, sans-serif;
          -ms-text-size-adjust: 100%;
          -webkit-text-size-adjust: 100%;
        }

        body {
          background: #F2F3EB;
        }

        button {
          overflow: visible;
        }

        button, select {
          text-transform: none;
        }

        button, input, select, textarea {
          color: #5A5A5A;
          font: inherit;
          margin: 0;
        }

        input {
          line-height: normal;
        }

        textarea {
          overflow: auto;
        }

        #container {
          border: solid 3px #474544;
          max-width: 768px;
          margin: 60px auto;
          position: relative;
        }

        form {
          padding: 37.5px;
          margin: 50px 0;
        }

        h1 {
          color: #474544;
          font-size: 32px;
          font-weight: 700;
          letter-spacing: 7px;
          text-align: center;
          text-transform: uppercase;
        }

        .underline {
          border-bottom: solid 2px #474544;
          margin: -0.512em auto;
          width: 80px;
        }

        .icon_wrapper {
          margin: 50px auto 0;
          width: 100%;
        }

        .icon {
          display: block;
          fill: #474544;
          height: 50px;
          margin: 0 auto;
          width: 50px;
        }

        .email {
            float: right;
            width: 45%;
        }

        input[type='text'], [type='email'], select, textarea {
            background: none;
          border: none;
            border-bottom: solid 2px #474544;
            color: #474544;
            font-size: 1.000em;
          font-weight: 400;
          letter-spacing: 1px;
            margin: 0em 0 1.875em 0;
            padding: 0 0 0.875em 0;
          text-transform: uppercase;
            width: 100%;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -o-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            -ms-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }

        input[type='text']:focus, [type='email']:focus, textarea:focus {
            outline: none;
            padding: 0 0 0.875em 0;
        }

        .message {
            float: none;
        }

        .name {
            float: left;
            width: 45%;
        }

        select {
          background: url('https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-32.png') no-repeat right;
          outline: none;
          -moz-appearance: none;
          -webkit-appearance: none;
        }

        select::-ms-expand {
          display: none;
        }

        .subject {
          width: 100%;
        }

        .telephone {
          width: 100%;
        }

        textarea {
            line-height: 150%;
            height: 150px;
            resize: none;
          width: 100%;
        }

        ::-webkit-input-placeholder {
            color: #474544;
        }

        :-moz-placeholder {
            color: #474544;
            opacity: 1;
        }

        ::-moz-placeholder {
            color: #474544;
            opacity: 1;
        }

        :-ms-input-placeholder {
            color: #474544;
        }

        #form_button {
          background: none;
          border: solid 2px #474544;
          color: #474544;
          cursor: pointer;
          display: inline-block;
          font-family: 'Helvetica', Arial, sans-serif;
          font-size: 0.875em;
          font-weight: bold;
          outline: none;
          padding: 20px 35px;
          text-transform: uppercase;
          -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            -ms-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }

        #form_button:hover {
          background: #474544;
          color: #F2F3EB;
        }

        @media screen and (max-width: 768px) {
          #container {
            margin: 20px auto;
            width: 95%;
          }
        }

        @media screen and (max-width: 480px) {
          h1 {
            font-size: 26px;
          }

          .underline {
            width: 68px;
          }

          #form_button {
            padding: 15px 25px;
          }
        }

        @media screen and (max-width: 420px) {
          h1 {
            font-size: 18px;
          }

          .icon {
            height: 35px;
            width: 35px;
          }

          .underline {
            width: 53px;
          }

          input[type='text'], [type='email'], select, textarea {
            font-size: 0.875em;
          }
        }

    </style>
</head>

<body>

<!--<img src="https://app.aotour.com.co/autonet/biblioteca_imagenes/facturacion/ingresos/1140835204.png" />-->

 <div class="container-fluid" id="ex_ruta">

    <div id="navega">
        <div id="menu">
            <div id="fijo">

                <div class="row">

            <div class="col-lg-3">

            </div>

            <div class="col-lg-6">
                <div class="proveedores activo">
                    <legend style="font-size: 20px;"><b style="color: white;">Solicita tu Servicio</b> <img src="{{url('img/logo_aotour.png')}}" height="35px" width="150px" style="float: unset; border-radius: 20px;"></legend>
                </div>
            </div>




        </div>
            </div>
        </div>
    </div>

    <div class="hidden" id="map" style="overflow-y: auto; height: 500px;"></div>

    <div class="row" style="margin-top: 150px;">
        <div class="col-lg-6 col-md-6 col-sm-6 col-lg-push-3 formulario">
         <div class="panel panel-default">
             <div class="panel-heading"><b>Formulario de Solicitud</b>
                <!--
                <input style="float: right; margin-left: 5px;" type="radio" id="ida_regreso" name="drone" value="dewey">
                <label style="float: right; margin-left: 15px;" for="huey">Ida y Regreso </label>
                <input style="float: right; margin-left: 5px;" type="radio" id="ida" name="drone" value="dewey">
                <label style="float: right;" for="huey">Sólo Ida </label>-->

            </div>

             <div class="panel-body">

                <!-- Tipo de Identificación -->
                <div class="input-group margin_input">
                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-id-card-o" aria-hidden="true"></i></span>

                    <div class="row">
                        <div class="col-lg-6">
                            <select class="form-control input-font" id="tipo_documento" name="tipo_documento" dato="ninguno">
                              <option>Tipo de Identificación</option>
                              <option>CC</option>
                              <option>CE</option>
                              <option>Nit</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <input class="form-control input-font" maxlength="10" id="cc" class="numero_transaccion" aria-describedby="basic-addon1" type="number" placeholder="Ingresar Identificación">
                        </div>
                    </div>

                    <a style="float: right; width: 100%; margin-top: 10px; padding: 9px;" id="buscarCliente" class="detalles_centro btn btn-list-table btn-primary hidden">Buscar</a>

                    <a style="float: right; width: 100%; padding: 9px; margin-top: 10px" id="buscarUsuario" class="detalles_centro btn btn-list-table btn-primary hidden">Siguiente</a>

                 </div>
                <div class="input-group margin_input cliente hidden">
                    <center>
                        <div class="estado_servicio_app" style="background: #f47321; color: white; margin: 2px 0px; font-size: 14px; padding: 6px 10px; width: 100%; border-radius: 2px;"><span class="cliente_name"></span>
                        </div>
                    </center>
                </div>

                 <!-- Identificación -->

                 <!-- CIUDAD -->
                 <div class="row ciudad hidden">
                    <div class="col-lg-6">
                        <select class="form-control input-font" id="ciudad" name="ciudad" dato="ninguno">
                          <option>Seleccionar Ciudad</option>
                          <option>Barranquilla</option>
                          <option>Bogotá</option>
                          <option>Cartagena</option>
                          <option>Medellín</option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <span>Actualmente sólo tenemos cobertura en estas ciudades.</span>
                    </div>

                </div>

                 <div class="row">
                     <div class="col-lg-3">
                         <div class="input-group margin_input fecha hidden">
                            <span class="input-group-addon" id="basic-addon1">Fecha:</span>
                            <input maxlength="0" type="text" id="datepicker" class="form-control input-font" aria-describedby="basic-addon1" value="">

                        </div>
                     </div>
                     <div class="col-lg-3">
                         <div class="input-group margin_input hora hidden">
                            <span class="input-group-addon" id="basic-addon1">Hora:</span>

                            <input maxlength="5" type="text" class="form-control input-font" id="hora_servicio" autocomplete="off">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                        </div>
                     </div>
                     <div class="col-lg-6">
                         <div class="input-group margin_input notas hidden">
                            <span class="input-group-addon" id="basic-addon1">Notas:</span>
                            <input class="form-control input-font" id="notas" class="numero_transaccion" aria-describedby="basic-addon1" value="">
                        </div>
                     </div>
                 </div>



                 <div class="row">
                     <div class="col-lg-6">
                         <div class="input-group margin_input desde hidden">
                            <span class="input-group-addon" id="basic-addon1">Desde:</span>
                            <input class="form-control input-font" id="desde" class="numero_transaccion" aria-describedby="basic-addon1" value="">
                        </div>
                     </div>
                     <div class="col-lg-6">
                         <div class="input-group margin_input hasta hidden">
                            <span class="input-group-addon" id="basic-addon1">Hasta:</span>
                            <input class="form-control input-font" id="hasta" class="numero_transaccion" aria-describedby="basic-addon1" value="">
                        </div>
                     </div>
                 </div>

                 <div class="hidden forwhat" style="text-align: center;">
                     <b style="padding: 3px; background-color: orange; font-size: 15px;">Si el servicio es para usted, debe agregarse como pasajero</b>
                 </div>

                <div class="row hidden forwhat" style="background-color: orange; margin-top: 15px; margin-bottom: 10px;">

                    <div class="col-lg-6" style="background-color: orange;">

                        <label><input class="form-check-input" type="radio" name="flexRadioDefault" id="para_mi"> <b>El servicio es para mí</b></label><br>
                    </div>

                    <div class="col-lg-6" style="background-color: orange;">

                        <label><input class="form-check-input" type="radio" name="flexRadioDefault" id="otra_persona"> <b>El servicio es para otra(s) persona(s)</b></label><br>
                    </div>
                </div>

                <div class="row prueba hidden" style="margin-top: 15px; margin-bottom: 10px;">
                    <div class="input-group margin_input notas hidden">
                        <span class="input-group-addon" id="basic-addon1">Escriba a continuación sus datos para notificarle cuando sea programada su solicitud</span>
                        <!--<input class="form-control input-font" id="notas" class="numero_transaccion" aria-describedby="basic-addon1" value="">-->

                    </div>
                </div>

                <div class="row prueba hidden">
                     <div class="col-lg-6">
                         <div class="input-group margin_input desde hidden">
                            <span class="input-group-addon" id="basic-addon1">Nombre:</span>
                            <input class="form-control input-font" id="nombre_request" class="numero_transaccion" aria-describedby="basic-addon1" value="">
                        </div>
                     </div>
                     <div class="col-lg-6">
                         <div class="input-group margin_input hasta hidden">
                            <span class="input-group-addon" id="basic-addon1">Correo:</span>
                            <input class="form-control input-font" id="correo_request" class="numero_transaccion" aria-describedby="basic-addon1" value="">
                        </div>
                     </div>
                 </div>

                <p class="listado hidden">A continuación, agregue las personas a transportar <br></p>
                <table style="margin-bottom: 15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);" class="table table-bordered hover listado hidden">
                    <tr class="table_botones">
                        <td><span style="font-size: 14px;"><b>PASAJEROS</b></span></td>
                        <td>
                            <a id="eliminar_descuento" style="float: right;" class="btn btn-danger btn-icon">ELIMINAR<i class="fa fa-close icon-btn"></i></a>
                            <a id="agregar_descuento" style="margin-right: 3px; float: right;" class="btn btn-info btn-icon margin">AGREGAR<i class="fa fa-plus icon-btn"></i></a>
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered hover descuentos hidden" style="margin-bottom:15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);">
                </table>

                <div class="row">
                    <div class="col-md-9">

                        <span style="margin-top: 10px; font-size: 25px;" id="fees" class="hidden"><b id="precio">COP $ 0</b></span><br>

                        <span style="margin-top: 10px" id="fee" class="hidden">Distancia:  <b id="distancia"></b> | Tiempo:  <b id="tiempo"></b></span>

                    </div>
                    <div class="col-md-3">

                        <a style="float: right; margin-top: 10px; padding: 9px; font-size: 50px;" id="solicitar" class="detalles_centro btn btn-list-table btn-success"><h5>Solicitar <i class="fa fa-arrow-right" aria-hidden="true"></i></h5></a>

                        <a style="float: right; margin-top: 10px; padding: 9px;" class="loading hidden btn btn-list-table btn-success ">Cargando <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></a>

                        <a style="float: right; margin-top: 10px; padding: 12px;" id="request" class="hidden btn btn-list-table btn-primary ">IR A PAGAR <i class="fa fa-check" aria-hidden="true"></i> <i class="fa fa-credit-card" aria-hidden="true"></i> </a>

                    </div>

                </div>

             </div>
         </div>
        </div>

        <!-- start -->

        <div class="col-lg-4 col-md-4 col-sm-4 col-lg-push-4 pagado hidden">
         <div class="panel panel-default">
             <div class="panel-heading" style="text-align: center;"><b>Confirmación de Solicitud y Pago</b>

            </div>

             <div class="panel-body">

                <b style="text-align: center; font-size: 18px;">Detalles de la Solicitud</b>

                <!-- Desde Hasta -->

                <div class="row" style="margin-top: 20px;">
                    <div class="col-lg-12">
                        <div class="input-group margin_input desde">
                            <span class="input-group-addon" id="basic-addon1">Desde:</span>
                            <input class="form-control input-font" id="desde_pagado" class="numero_transaccion" aria-describedby="basic-addon1" value="" disabled>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="input-group margin_input hasta">
                            <span class="input-group-addon" id="basic-addon1">Hasta:</span>
                            <input class="form-control input-font" id="hasta_pagado" class="numero_transaccion" aria-describedby="basic-addon1" value="" disabled>
                        </div>
                    </div>
                 </div>

                 <div class="row">
                     <div class="col-lg-5">
                         <div class="input-group margin_input fecha">
                            <span class="input-group-addon" id="basic-addon1">Fecha:</span>

                            <input class="form-control input-font" id="datepicker_pagado" class="numero_transaccion" aria-describedby="basic-addon1" value="" disabled>

                        </div>
                     </div>
                     <div class="col-lg-5">
                         <div class="input-group margin_input hora">
                            <span class="input-group-addon" id="basic-addon1">Hora:</span>

                            <input class="form-control input-font" id="hora_servicio_pagado" class="numero_transaccion" aria-describedby="basic-addon1" value="" disabled>

                        </div>
                     </div>
                     <div class="col-lg-12">
                         <div class="input-group margin_input notas">
                            <span class="input-group-addon" id="basic-addon1">Notas:</span>
                            <input class="form-control input-font" disabled id="notas_pagado" class="numero_transaccion" aria-describedby="basic-addon1" value="">
                        </div>
                     </div>
                 </div>


                <div class="input-group margin_input mensaje" style="float: right; margin-top: 15PX;">
                    <center>
                        <div class="estado_servicio_app" style="float: right; background: #f47321; color: white; margin: 2px 0px; font-size: 14px; padding: 6px 10px; width: 100%; border-radius: 2px;"><span class="mensaje">PAGO REALIZADO EXITOSAMENTE  <i class="fa fa-check" aria-hidden="true"></i></span>
                        </div>

                        <span style="font-size: 18px;" slot="start"><b id="brand">VISA</b> Terminada en <b id="lastfour">**** 8186</b></span> <br>
                        <span style="font-size: 18px;" slot="start"><b id="valor"></b></span>

                        <!--<span style="font-size: 11px;" slot="start"><b id="seconds">En 6 segundos será redirigido (a) nuestra página web...</b></span>-->

                    </center>
                </div>

             </div>
         </div>
        </div>
        <!-- end -->


        <div class="contenedor hidden">
            <!-- Tarjeta -->
            <section class="tarjeta" id="tarjeta">
                <div class="delantera">
                    <div class="logo-marca" id="logo-marca">
                        <!-- <img src="img/logos/visa.png" alt=""> -->
                    </div>
                    <img src="{{url('img/img/chip-tarjeta.png')}}" class="chip" alt="">
                    <div class="datos">
                        <div class="grupo" id="numero">
                            <p class="label">Número Tarjeta</p>
                            <p class="numero">#### #### #### ####</p>
                        </div>
                        <div class="flexbox">
                            <div class="grupo" id="nombre">
                                <p class="label">Nombre Tarjeta</p>
                                <p class="nombre">Nombre</p>
                            </div>

                            <div class="grupo" id="expiracion">
                                <p class="label">Expiracion</p>
                                <p class="expiracion"><span class="mes">MM</span> / <span class="year">AA</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="trasera">
                    <div class="barra-magnetica"></div>
                    <div class="datos">
                        <div class="grupo" id="firma">
                            <p class="label">Firma</p>
                            <div class="firma"><p></p></div>
                        </div>
                        <div class="grupo" id="ccv">
                            <p class="label">CCV</p>
                            <p class="ccv"></p>
                        </div>
                    </div>
                    <p class="leyenda">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus exercitationem, voluptates illo.</p>
                    <a href="#" class="link-banco">aotour.com.co</a>
                </div>
            </section>

            <!-- Contenedor Boton Abrir Formulario -->
            <div class="contenedor-btn">
                <button class="btn-abrir-formulario" id="btn-abrir-formulario">
                    <i class="fas fa-plus"></i>
                </button>
            </div>

            <!-- Formulario -->
            <form action="" id="formulario-tarjeta" class="formulario-tarjeta">
                <div class="grupo">
                    <label for="inputNumero">Número Tarjeta</label>
                    <input type="text" id="inputNumero" maxlength="19" autocomplete="off">
                </div>
                <div class="grupo">
                    <label for="inputNombre">Nombre</label>
                    <input type="text" id="inputNombre" maxlength="19" autocomplete="off">
                </div>
                <div class="flexbox">
                    <div class="grupo expira">
                        <label for="selectMes">Expiracion</label>
                        <div class="flexbox">
                            <div class="grupo-select">
                                <select name="mes" id="selectMes">
                                    <option disabled selected>Mes</option>
                                </select>
                                <i class="fas fa-angle-down"></i>
                            </div>
                            <div class="grupo-select">
                                <select name="year" id="selectYear">
                                    <option disabled selected>Año</option>
                                </select>
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grupo ccv">
                        <label for="inputCCV">CCV</label>
                        <input type="text" id="inputCCV" maxlength="3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button type="button" class="btn-enviar devolverse" style="background-color: red;">Volver</button>
                    </div>
                    <div class="col-lg-6">
                        <button type="button" class="btn-enviar card_credit">Solicitar</button>
                        <button type="button" class="btn-enviar cargando hidden">Solicitando <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></button>
                    </div>
                </div>

            </form>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id='modal_datos' data-backdrop="static">
             <div class="modal-dialog modal-md" role="document">
               <div class="modal-content">

                   <div class="modal-body">

                     <div class="panel panel-default">
                         <div class="panel-heading" style="font-size: 35px;">Datos Personales</div>
                         <div class="panel-body">
                             <div class="input-group margin_input">
                                 <span class="input-group-addon" id="basic-addon1"><b>NOMBRE COMPLETO</b></span>
                                 <input class="form-control input-font" id="nombre_complete" aria-describedby="basic-addon1">
                             </div>
                             <div class="input-group margin_input">
                                 <span class="input-group-addon" id="basic-addon1"> <b>NÚMERO DE IDENTIFICACIÓN</b> </span>
                                 <input class="form-control input-font" id="identification" aria-describedby="basic-addon1">
                             </div>
                             <div class="input-group margin_input">
                                 <span class="input-group-addon" id="basic-addon1"> <b># DE CÉLULAR</b> </span>
                                 <input class="form-control input-font" type="number" id="celular_user" aria-describedby="basic-addon1">
                             </div>
                             <div class="input-group margin_input">
                                 <span class="input-group-addon" id="basic-addon1"> <b>CORREO ELECTRÓNICO</b> </span>
                                 <input class="form-control input-font" id="email_user" aria-describedby="basic-addon1">
                             </div>
                             <div class="input-group margin_input">
                                 <span class="input-group-addon" id="basic-addon1"> <b>DIRECCIÓN</b> </span>
                                 <input class="form-control input-font" id="address_user" aria-describedby="basic-addon1">
                             </div>

                             <button style="float: right; margin-left: 10px;" type="button" class="btn btn-primary datos_personales">Continuar</button>

                             <button style="float: right;" type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>

                         </div>
                     </div>
                     <label><input type="checkbox" id="cbox1"><b> Autorizo el <a data-toggle="modal" data-target=".mymodalP">tratamiento</a> de datos</b></label>
                   </div>
               </div>
             </div>
           </div>

           <div class="modal mymodalP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content" style="background-color: orange">
                  <div class="modal-header" style="background: #C0BFC0">
                    <div class="row">
                        <div class="col-lg-11 col-sm-11">
                            <strong style="color: black;">Política de Tratamiento de datos Ley 1581 de 2012</strong>
                        </div>
                        <div class="col-lg-1 col-sm-1">
                            <button style="float: right;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    </div>
                  </div>
                    <div class="modal-body tabbable">

                       <p style="text-align: justify;">
                           De acuerdo con lo estipulado en la Ley 1581 de 2012 y sus decretos reglamentarios, AUTORIZO a AOTOUR SAS para que trate la información suministrada en el marco de la Política de Tratamiento de Datos Personales de la organización, garantizando la seguridad de la misma, con los medios técnicos, administrativos  y humanos necesarios evitando su adulteración, pérdida, consulta, uso o acceso no autorizado o fraudulento y cuyo uso será exclusivo para los fines de la operación.
                       </p>

                    </div>

                </div>
                </div>
            </div>

        <!--<div class="col-lg-6 col-md-6 col-sm-6 regreso hidden">
         <div class="panel panel-default">
             <div class="panel-heading">Viaje de Regreso



            </div>
             <div class="panel-body">

                <div class="input-group margin_input cliente hidden">
                    <center>
                        <div class="estado_servicio_app" style="background: #f47321; color: white; margin: 2px 0px; font-size: 14px; padding: 6px 10px; width: 100%; border-radius: 2px;"><span class="cliente_name"></span>
                        </div>
                    </center>
                </div>

                <div class="input-group margin_input fecha hidden">
                    <span class="input-group-addon" id="basic-addon1">Fecha:</span>
                    <input maxlength="0" type="text" id="datepicker2" class="form-control input-font" aria-describedby="basic-addon1" value="">

                </div>

                <div class="input-group margin_input hora hidden">
                    <span class="input-group-addon" id="basic-addon1">Hora:</span>

                    <input maxlength="5" type="text" class="form-control input-font" id="hora_servicio2" autocomplete="off">
                    <span class="input-group-addon">
                        <span class="fa fa-calendar">
                        </span>
                    </span>
                </div>

                <div class="input-group margin_input desde hidden">
                    <span class="input-group-addon" id="basic-addon1">Desde:</span>
                    <input class="form-control input-font" id="desde_regreso" class="numero_transaccion" aria-describedby="basic-addon1" value="">
                </div>

                <div class="input-group margin_input hasta hidden">
                    <span class="input-group-addon" id="basic-addon1">Hasta:</span>
                    <input class="form-control input-font" id="hasta_regreso" class="numero_transaccion" aria-describedby="basic-addon1" value="">
                </div>

                <div class="input-group margin_input notas hidden">
                    <span class="input-group-addon" id="basic-addon1">Notas:</span>
                    <input class="form-control input-font" id="numero_transaccion" class="numero_transaccion" aria-describedby="basic-addon1" value="">
                </div>

                <table style="margin-bottom: 15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);" class="table table-bordered hover listado hidden">
                    <tr class="table_botones">
                        <td><span style="font-size: 14px;"><b>PASAJEROS</b></span></td>
                        <td>
                            <a id="eliminar_descuento" style="float: right;" class="btn btn-danger btn-icon">ELIMINAR<i class="fa fa-close icon-btn"></i></a>
                            <a id="agregar_descuento" style="margin-right: 3px; float: right;" class="btn btn-info btn-icon margin">AGREGAR<i class="fa fa-plus icon-btn"></i></a>
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered hover descuentos hidden" style="margin-bottom:15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);">
                </table>

             </div>
         </div>
        </div>-->

        <!--<div class="col-lg-6 col-md-6 col-sm-6">
            <img src="{{url('img/img.png')}}">
        </div>-->
   </div>

  </div>

  @include('scripts.scripts')

  <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

  <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
  <script src="js/main.js"></script>

  <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0&callback=initMap&libraries=places&v=weekly"
      defer
    ></script>

    <!--<script src='https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0&callback=initMap&libraries=geometry,places'></script>-->

  <script>



    function initMap() {

        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer();

        const map = new google.maps.Map(document.getElementById("map"), {
          center: { lat: -33.8688, lng: 151.2195 },
          zoom: 13,
        });

        directionsRenderer.setMap(map);

        var inputRecoger = (document.getElementById('desde'));
        var inputDestino = (document.getElementById('hasta'));

        var options = {
          componentRestrictions: {
            country: 'co'
          }
        };

        var autocompleteRecoger = new google.maps.places.SearchBox(inputRecoger, options);

        var autocompleteDejar = new google.maps.places.SearchBox(inputDestino, options);
        var latitudeRecoger = null;
        var longitudeRecoger = null;

        map.addListener('bounds_changed', function() {
          autocompleteRecoger.setBounds(map.getBounds());
        });

        map.addListener('bounds_changed', function() {
          autocompleteDejar.setBounds(map.getBounds());
        });
    }

    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();
  </script>

  <script type="text/javascript">

  $( document ).ready(function() {

    var isMobile = {
      Android: function() {
          return navigator.userAgent.match(/Android/i);
      },
      BlackBerry: function() {
          return navigator.userAgent.match(/BlackBerry/i);
      },
      iOS: function() {
          return navigator.userAgent.match(/iPhone|iPad|iPod/i);
      },
      Opera: function() {
          return navigator.userAgent.match(/Opera Mini/i);
      },
      Windows: function() {
          return navigator.userAgent.match(/IEMobile/i);
      },
      any: function() {
          return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
      }
    };

    if(isMobile.Android()) {
      console.log('Esto es un dispositivo Windows');
    }else{
      console.log(('test'));
    }

    $('#tipo_documento').change(function(e){

        var estado = $(this).attr('dato');

        var valor = $(this).val();

        if(estado!=valor && estado!='ninguno'){

            $('.cliente_name').html('');

            $('.cliente').addClass('hidden');
            $('.fecha').addClass('hidden');
            $('.hora').addClass('hidden');
            $('.desde').addClass('hidden');
            $('.hasta').addClass('hidden');
            $('.notas').addClass('hidden');
            $('.ciudad').addClass('hidden');
            $('.listado').addClass('hidden');
            //cliente_name
            $('.forwhat').addClass('hidden');

            //$('.descuentos').addClass('hidden').append('');

            //Limpiar campos si estaban llenos con la opción de cc o ce

        }

        console.log(valor);

        if(valor==='CC' || valor==='CE'){
            $('#buscarUsuario').removeClass('hidden');
            $('#buscarCliente').addClass('hidden');

            $(this).attr('dato','cc');
        }else{
            $('#buscarCliente').removeClass('hidden');
            $('#buscarUsuario').addClass('hidden');
            $(this).attr('dato','nit');
        }
        //$('#buscarCliente').removeClass('hidden');
        //console.log(valor)

    });

    $('#otra_persona').click(function(event){

        $(this).attr('disabled', 'disabled');
        $('#para_mi').removeAttr('disabled', 'disabled');

        $('.prueba').removeClass('hidden');

        if(tipo_documento!='NIT'){

            var name = $(this).attr('nombre');
            var email = $(this).attr('email');

            $('#nombre_request').val(name);
            $('#correo_request').val(email);

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

        }

    });

    $('#para_mi').click(function(event){

        $(this).attr('disabled', 'disabled');
        $('#otra_persona').removeAttr('disabled', 'disabled');

        $('.prueba').addClass('hidden');

        var tipo_documento = $('select[name="tipo_documento"]').val().toUpperCase();

        console.log(tipo_documento)

        if(tipo_documento!='NIT'){

            $('#nombre_request').val('');
            $('#correo_request').val('');

            var name = $(this).attr('nombre');
            var email = $(this).attr('email');
            var celular = $(this).attr('celular');

            $elemento = '<tr>'+
                        '<td>'+
                         '<div class="input-group">'+
                              '<input type="text" class="form-control input-font nombre" value="'+name+'" placeholder="Nombre">'+
                              '<div class="input-group-addon"><i class="fa fa-user"></i></div>'+
                          '</div>'+
                        '</td>'+
                        '<td style="width: 25%;">'+
                         '<div class="input-group">'+
                              '<input type="text" class="form-control input-font celular" value="'+celular+'" placeholder="Celular">'+
                              '<div class="input-group-addon"><i class="fa fa-phone"></i></div>'+
                          '</div>'+
                        '</td>'+
                        '<td>'+
                         '<div class="input-group">'+
                              '<input type="text" class="form-control input-font correo" value="'+email+'" placeholder="Correo (Le llegará un Email)">'+
                              '<div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>'+
                          '</div>'+
                        '</td>'+
                      '</tr>';
          $('.descuentos').removeClass('hidden').append($elemento);

        }

    });

    $('#buscarUsuario').click(function(){

        var tipo_documento = $('select[name="tipo_documento"]').val()
        var numero = $('#cc').val()
        if(tipo_documento==='Tipo de Identificación' || numero===''){

            var data = '';

            if(tipo_documento==='Tipo de Identificación'){
                console.log('No seleccionado el tipo de documento')

                data = data+'No ha seleccionado el Tipo de Identificación <br>'

            }
            if(numero===''){

                data = data+'No ha ingresado el Número de Identificación'

            }

            $.confirm({
                title: '¡Datos Incorrectos! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                content: data,
                type: 'red',
                typeAnimated: true,
                buttons: {
                  tryAgain: {
                    text: 'Entendido',
                    btnClass: 'btn-danger',
                    action: function(){
                      //window.location.href = "https://www.aotour.com.co/portalusuarios/";
                    }
                  }
                }
            });

        }else{

            var id = $('#cc').val();
            //var tipo = $('#tipo_documento option:selected').html();
            var tipo = $('select[name="tipo_documento"]').val();
            console.log(tipo);

            $.ajax({
              url: 'buscarusuario',
              method: 'post',
              data: {id_cliente: id, tipo: tipo}
            }).done(function(data){

              if(data.respuesta===false){

                $.confirm({
                    title: '¡Atención! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                    content: 'Primera vez que solicita servicio con nosotros.<br><br> Para continuar debe rellenar el siguiente formulario...',
                    type: 'yellow',
                    typeAnimated: true,
                    buttons: {
                      tryAgain: {
                        text: 'Cancelar',
                        btnClass: 'btn-danger',
                        action: function(){
                        }
                      },cancel: {
                        text: 'Continuar',
                        btnClass: 'btn-success',
                        action: function(){
                            mostrarFormulario();
                        }
                      }
                    }
                });

              }else if(data.respuesta==true){

                console.log(data.razonsocial)

                $('.cliente_name').html(data.razonsocial)

                $('.cliente').removeClass('hidden');
                $('.fecha').removeClass('hidden');
                $('.hora').removeClass('hidden');
                $('.desde').removeClass('hidden');
                $('.hasta').removeClass('hidden');
                $('.notas').removeClass('hidden');
                $('.ciudad').removeClass('hidden');
                $('.listado').removeClass('hidden');

                $('.forwhat').removeClass('hidden');

                $('#para_mi').attr('nombre',data.razonsocial);
                $('#para_mi').attr('email',data.email);
                $('#para_mi').attr('celular',data.celular);

                $('#otra_persona').attr('nombre',data.razonsocial);
                $('#otra_persona').attr('email',data.email);

                $('.card_credit').attr('nombre',data.razonsocial);
                $('.card_credit').attr('email',data.email);
                $('.card_credit').attr('celular',data.celular);
                $('.card_credit').attr('identificacion',data.identificacion);
                $('.card_credit').attr('direccion',data.direccion);

              }else if(data.response==false){
                alert('Error');
              }
            });
        }

    });//SG

    function mostrarFormulario(){
        $('#identification').val($('#cc').val())
        $('#modal_datos').modal('show');
    }



    $('.datos_personales').click(function(){

        var name = $('#nombre_complete').val();
        var identificacion = $('#identification').val();
        var email = $('#email_user').val();
        var celular = $('#celular_user').val();
        var direccion = $('#address_user').val();
        var politicas = $('#cbox1').is(':checked');

        var switchEmail = null;

        if(email.indexOf('@', 0) == -1 || email.indexOf('.', 0) == -1) {

            switchEmail = 1;

        }

        if(name==='' || identificacion==='' || email==='' || celular==='' || direccion==='' || switchEmail===1 || politicas==false){

            var string = '';

            if(name===''){
                string +='El campo nombre es requerido<br>';
            }
            if(identificacion===''){
                string +='El campo Identificación es requerido<br>';
            }
            if(email===''){
                string +='El campo Email es requerido<br>';
            }
            if(celular===''){
                string +='El campo Celular es requerido<br>';
            }
            if(direccion===''){
                string +='El campo dirección es requerido<br>';
            }

            if(switchEmail===1 && email!=''){
                string += 'Correo inválido <br>';
            }

            if(politicas==false){
                string += 'Debe aceptar las políticas <br>';
            }

            $.confirm({
                title: '¡Atención! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                content: string,
                type: 'primary',
                typeAnimated: true,
                buttons: {
                  tryAgain: {
                    text: 'Cerrar',
                    btnClass: 'btn-primary',
                    action: function(){
                    }
                  }
                }
            });

        }else{

            $('#para_mi, .card_credit').attr('nombre',name);
            $('#para_mi, .card_credit').attr('email',email);
            $('#para_mi, .card_credit').attr('celular',celular);
            $('.card_credit').attr('identificacion',identificacion);
            $('.card_credit').attr('direccion',direccion);

            $('#otra_persona').attr('nombre',name);
            $('#otra_persona').attr('email',email);

            $('#modal_datos').modal('hide');

            $('.cliente').removeClass('hidden');
            $('.fecha').removeClass('hidden');
            $('.hora').removeClass('hidden');
            $('.desde').removeClass('hidden');
            $('.hasta').removeClass('hidden');
            $('.notas').removeClass('hidden');
            $('.ciudad').removeClass('hidden');
            $('.listado').removeClass('hidden');
            //cliente_name
            $('.forwhat').removeClass('hidden');

            $('.cliente_name').html(name.toUpperCase());

        }

    });


    $('#buscarCliente').click(function(){

        //Validar campos
        var tipo_documento = $('select[name="tipo_documento"]').val()
        var numero = $('#cc').val()
        if(tipo_documento==='Tipo de Identificación' || numero===''){

            var data = '';

            if(tipo_documento==='Tipo de Identificación'){
                console.log('No seleccionado el tipo de documento')

                data = data+'No ha seleccionado el Tipo de Identificación <br>'

            }
            if(numero===''){

                data = data+'No ha ingresado el Número de Identificación'

            }

            $.confirm({
                title: '¡Datos Incorrectos! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                content: data,
                type: 'red',
                typeAnimated: true,
                buttons: {
                  tryAgain: {
                    text: 'Entendido',
                    btnClass: 'btn-danger',
                    action: function(){
                      //window.location.href = "https://www.aotour.com.co/portalusuarios/";
                    }
                  }
                }
            });

        }else{

            var id = $('#cc').val();

            $.ajax({
              url: 'buscarcliente',
              method: 'post',
              data: {id_cliente: id}
            }).done(function(data){

              if(data.respuesta===false){

                $.confirm({
                    title: '¡Sin resultados! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                    content: 'No se encuentra en nuestro sistema la Identificación digitada...',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                      tryAgain: {
                        text: 'Entendido',
                        btnClass: 'btn-danger',
                        action: function(){
                          //window.location.href = "https://www.aotour.com.co/portalusuarios/";
                        }
                      }
                    }
                });

              }else if(data.respuesta==true){

                console.log(data.razonsocial)

                $('.cliente_name').html(data.razonsocial)

                $('.cliente').removeClass('hidden');
                $('.fecha').removeClass('hidden');
                $('.hora').removeClass('hidden');
                $('.desde').removeClass('hidden');
                $('.hasta').removeClass('hidden');
                $('.notas').removeClass('hidden');
                $('.listado').removeClass('hidden');
                $('.ciudad').removeClass('hidden');
                //cliente_name
                $('.forwhat').removeClass('hidden');

              }else if(data.response==false){
                alert('Error');
              }
            });
        }

    });//SG

    $('#agregar_descuento').click(function(event){
      event.preventDefault();

      //localStorage.setItem('samu','test')
      $elemento = '<tr>'+
                    '<td>'+
                     '<div class="input-group">'+
                          '<input type="text" class="form-control input-font nombre" placeholder="Nombre">'+
                          '<div class="input-group-addon"><i class="fa fa-user"></i></div>'+
                      '</div>'+
                    '</td>'+
                    '<td style="width: 25%;">'+
                     '<div class="input-group">'+
                          '<input type="text" class="form-control input-font celular" placeholder="Celular">'+
                          '<div class="input-group-addon"><i class="fa fa-phone"></i></div>'+
                      '</div>'+
                    '</td>'+
                    '<td>'+
                     '<div class="input-group">'+
                          '<input type="text" class="form-control input-font correo" placeholder="Correo (Le llegará un Email)">'+
                          '<div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>'+
                      '</div>'+
                    '</td>'+
                  '</tr>';
      $('.descuentos').removeClass('hidden').append($elemento);
    });

    $('#eliminar_descuento').click(function(event){

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

    });

    $('input:radio[id="ida_regreso"]').click(function(e){

        $('.regreso').removeClass('hidden')
    });

    $('input:radio[id="ida"]').click(function(e){

        $('.regreso').addClass('hidden')
    });

    $('#metodo').click(function (){

        //$('#modal_tarjeta').modal('show');
        $('.formulario').addClass('hidden');
        $('.contenedor').removeClass('hidden');

    });

    $('.devolverse').click(function (){

        $('.formulario').removeClass('hidden');
        $('.contenedor').addClass('hidden');

        $('#solicitar').removeClass('hidden');
        $('.loading').addClass('hidden');

        $('#request').addClass('hidden');

    });

    $('.card_credit').click(function (){

        var numero = $('#inputNumero').val();
        var nombre = $('#inputNombre').val();
        var mes = $('#selectMes').val();
        var ano = $('#selectYear').val();
        var ccv = $('#inputCCV').val();

        if(numero==='' || nombre==='' || mes===null || ano===null || ccv===''){

            var string = '';

            if(numero===''){
                string +='El campo Número Tarjeta es requerido<br>';
            }

            if(nombre===''){
                string +='El campo Nombre es requerido<br>';
            }

            if(mes===null){
                string +='El campo Mes es requerido<br>';
            }

            if(ano===null){
                string +='El campo Año es requerido<br>';
            }

            if(ccv===''){
                string +='El campo CCV es requerido<br>';
            }

            $.confirm({
                title: '¡Atención! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                content: string,
                type: 'red',
                typeAnimated: true,
                buttons: {
                  tryAgain: {
                    text: 'Ok',
                    btnClass: 'btn-danger',
                    action: function(){
                      //window.location.href = "https://www.aotour.com.co/portalusuarios/";
                    }
                  }
                }
            });

        }else{

            var valor = $('.card_credit').attr('info');

            var correo_electronico = $('.card_credit').attr('email');

            $(this).addClass('hidden');
            $('.cargando').removeClass('hidden');

            $('.devolverse').attr('disabled','disabled');

            $.ajax({
                url: 'addtoken',
                method: 'post',
                data: {
                  numero: numero,
                  nombre: nombre,
                  mes: mes,
                  ano: ano,
                  ccv: ccv,
                  valor: valor,
                  correo_electronico: correo_electronico
                },
                dataType: 'json',
            }).done(function(data){

                if (data.respuesta===true) { //Transacción realizada exitosamente

                    $('.fa-spin').removeClass('fa fa-spinner fa-spin').addClass('fa fa-check');

                    var y = 1;
                    //var franquicia = data.brand;
                    //var lastfour = data.last_four;

                    var client = $('.card_credit').attr('client');
                    var ciudad = $('.card_credit').attr('ciudad');
                    var fecha = $('.card_credit').attr('fecha');
                    var hora = $('.card_credit').attr('hora');
                    var desde = $('.card_credit').attr('desde');
                    var hasta = $('.card_credit').attr('hasta');
                    var notas = $('.card_credit').attr('notas');

                    var datanombreArray = [];
                    var datacelularArray = [];
                    var datacorreoArray = [];

                    var nombre_subcentro = $('.card_credit').attr('nombre');
                    var email_subcentro = $('.card_credit').attr('email');
                    var celular_subcentro = $('.card_credit').attr('celular');
                    var identificacion_subcentro = $('.card_credit').attr('identificacion');
                    var direccion_subcentro = $('.card_credit').attr('direccion');

                    datanombreArray = $('.card_credit').attr('datanombreArray');
                    datacelularArray = $('.card_credit').attr('datacelularArray');
                    datacorreoArray = $('.card_credit').attr('datacorreoArray');

                    console.log(nombre_subcentro+' , '+desde+' , '+hasta+' , '+fecha)

                    guardarServicio(nombre_subcentro,email_subcentro,celular_subcentro,identificacion_subcentro,direccion_subcentro,1,client,ciudad,fecha,hora,desde,hasta,notas,datanombreArray,datacelularArray,datacorreoArray);

                }else if (data.respuesta===false) { //No se puedo crear el token de la tarjeta

                    $('.card_credit').removeClass('hidden');
                    $('.cargando').addClass('hidden');

                    $('.devolverse').removeAttr('disabled','disabled');

                    $.confirm({
                        title: '¡Error! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                        content: 'No se pudo validar la tarjeta. Por favor verifique los datos.',
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                          tryAgain: {
                            text: 'Entendido',
                            btnClass: 'btn-danger',
                            action: function(){
                              //window.location.href = "https://www.aotour.com.co/portalusuarios/";
                            }
                          }
                        }
                    });

                }else if(data.respuesta==='pendiente'){

                    setTimeout(function() {

                        var id = data.id;
                        var reference_code = data.reference_code;

                        $.ajax({
                            url: 'validarpago',
                            method: 'post',
                            data: {
                              id: id
                            },
                            dataType: 'json',
                        }).done(function(data){

                            if(data.respuesta===true){

                                $('.fa-spin').removeClass('fa fa-spinner fa-spin').addClass('fa fa-check');

                                var y = 1;
                                //var franquicia = data.brand;
                                //var lastfour = data.last_four;

                                var client = $('.card_credit').attr('client');
                                var ciudad = $('.card_credit').attr('ciudad');
                                var fecha = $('.card_credit').attr('fecha');
                                var hora = $('.card_credit').attr('hora');
                                var desde = $('.card_credit').attr('desde');
                                var hasta = $('.card_credit').attr('hasta');
                                var notas = $('.card_credit').attr('notas');

                                var datanombreArray = [];
                                var datacelularArray = [];
                                var datacorreoArray = [];

                                var nombre_subcentro = $('.card_credit').attr('nombre');
                                var email_subcentro = $('.card_credit').attr('email');
                                var celular_subcentro = $('.card_credit').attr('celular');
                                var identificacion_subcentro = $('.card_credit').attr('identificacion');
                                var direccion_subcentro = $('.card_credit').attr('direccion');

                                datanombreArray = $('.card_credit').attr('datanombreArray');
                                datacelularArray = $('.card_credit').attr('datacelularArray');
                                datacorreoArray = $('.card_credit').attr('datacorreoArray');

                                console.log(nombre_subcentro+' , '+desde+' , '+hasta+' , '+fecha)

                                var brand = data.brand;
                                var last_four = data.last_four;
                                var precio = data.precio;

                                guardarServicio(brand,last_four,reference_code,id,precio,nombre_subcentro,email_subcentro,celular_subcentro,identificacion_subcentro,direccion_subcentro,1,client,ciudad,fecha,hora,desde,hasta,notas,datanombreArray,datacelularArray,datacorreoArray);

                            }else if(data.respuesta==='pendiente'){

                            }

                        });

                    }, 15000);

                }else if(data.respuesta==='declinada'){

                    $.confirm({
                        title: '¡Error! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                        content: 'La transacción fue declinada por su banco.',
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                          tryAgain: {
                            text: 'Entendido',
                            btnClass: 'btn-danger',
                            action: function(){
                              //window.location.href = "https://www.aotour.com.co/portalusuarios/";
                            }
                          }
                        }
                    });

                }

            });

            $('#modal_tarjeta').modal('hide');
        }

    });

    $('#request').click(function(e){

        $('.formulario').addClass('hidden');
        $('.contenedor').removeClass('hidden');

        /*$('.card_credit').attr('client',client);
        $('.card_credit').attr('fecha',fecha);
        $('.card_credit').attr('hora',hora);
        $('.card_credit').attr('desde',desde);
        $('.card_credit').attr('hasta',hasta);
        $('.card_credit').attr('notas',notas);
        $('.card_credit').attr('datanombreArray',datanombreArray);
        $('.card_credit').attr('datacelularArray',datacelularArray);
        $('.card_credit').attr('datacorreoArray',datacorreoArray);*/


    });



    $('#solicitar').click(function(e){



        //console.log('Ciudad : '+ciudad)

        var switchPasajeros = 0;
        var switchEmail = 0;
        var cont = 1;
        var mensajeNombre = '';
        var mensajeCelular = '';
        var mensajeCorreo = '';

        $('.descuentos tbody tr').each(function(index) {

            if ($(this).find('.nombre').val()==='') {
              switchPasajeros = 1;
              mensajeNombre = mensajeNombre+'Nombre del Pasajero # '+cont+'<br>'
            }

            if ($(this).find('.celular').val()==='') {
              switchPasajeros = 1;
              mensajeNombre = mensajeNombre+'Celular del Pasajero # '+cont+'<br>'
            }

            if ($(this).find('.correo').val()==='') {
                switchPasajeros = 1;
                mensajeNombre = mensajeNombre+'Correo del Pasajero # '+cont+'<br>'
            }
            if($(this).find('.correo').val().indexOf('@', 0) == -1 || $(this).find('.correo').val().indexOf('.', 0) == -1) {
                switchEmail = 1;
                mensajeCelular = mensajeCelular+'Correo inválido del Pasajero # '+cont+'<br>'
            }
            cont++;

        });

        if(switchPasajeros===1){
            $.confirm({
                title: '¡Campos Vacíos! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                content: mensajeNombre,
                type: 'red',
                typeAnimated: true,
                buttons: {
                  tryAgain: {
                    text: 'Entendido',
                    btnClass: 'btn-danger',
                    action: function(){
                      //window.location.href = "https://www.aotour.com.co/portalusuarios/";
                    }
                  }
                }
            });
            console.log(mensajeNombre)
        }else if(switchEmail===1){
            $.confirm({
                title: '¡Campos Inválidos! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                content: mensajeCelular,
                type: 'red',
                typeAnimated: true,
                buttons: {
                  tryAgain: {
                    text: 'Entendido',
                    btnClass: 'btn-danger',
                    action: function(){
                      //window.location.href = "https://www.aotour.com.co/portalusuarios/";
                    }
                  }
                }
            });

            //console.log(mensajeCelular)

        }else{

            var fecha = $('#datepicker').val();
            var hora = $('#hora_servicio').val();
            var desde = $('#desde').val();
            var hasta = $('#hasta').val();
            var notas = $('#notas').val();

            var datanombreArray = [];
            var datacelularArray = [];
            var datacorreoArray = [];

            //console.log(fecha+' , '+hora+' , '+desde+' , '+hasta+' , '+notas)

            $('.descuentos tbody tr').each(function(index) {


                var valor_nombre = '';
                var valor_celular = '';
                var valor_correo = '';

                if ($(this).find('.nombre').val()==='') {
                  valor_nombre = 0;
                }else {
                  valor_nombre = $(this).find('.nombre').val().toUpperCase();
                }
                datanombreArray.push(valor_nombre);

                if ($(this).find('.celular').val()==='') {
                  valor_celular = 0;
                }else {
                  valor_celular = $(this).find('.celular').val();
                }
                datacelularArray.push(valor_celular);

                if ($(this).find('.correo').val()==='') {
                  valor_correo = 0;
                }else {
                  valor_correo = $(this).find('.correo').val().toUpperCase();
                }

                if(valor_correo.indexOf('@', 0) == -1 || valor_correo.indexOf('.', 0) == -1) {
                    alert('El correo electrónico introducido no es correcto.');
                    return false;
                }

                datacorreoArray.push(valor_correo);

            });

            var client = $('.cliente_name').html();
            var ciudad = $('select[name="ciudad"]').val();

            if(client==='' || fecha==='' || hora==='' || desde==='' || hasta==='' || notas==='' || (datanombreArray.length<1) || ciudad==='Seleccionar Ciudad'){

                var contenido = '';

                if(client===''){
                    contenido = contenido+'Cliente<br>';
                }

                if(ciudad==='Seleccionar Ciudad'){
                    contenido = contenido+'Ciudad del Servicio<br>';
                }

                if(fecha===''){
                    contenido = contenido+'Fecha<br>';
                }

                if(hora===''){
                    contenido = contenido+'Hora<br>';
                }

                if(desde===''){
                    contenido = contenido+'Desde<br>';
                }

                if(hasta===''){
                    contenido = contenido+'Hasta<br>';
                }

                if(notas===''){
                    contenido = contenido+'Notas<br>';
                }

                if(datanombreArray.length<1){
                    contenido = contenido+'No ha agregado ningún pasajero<br>';
                }

                $.confirm({
                    title: 'Campos Vacíos! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                    content: contenido,
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                      tryAgain: {
                        text: 'Entendido',
                        btnClass: 'btn-danger',
                        action: function(){

                        }
                      }
                    }
                });

            }else{

                $('#solicitar').addClass('hidden');

                var tipo = $('select[name="tipo_documento"]').val();

                if(tipo!='CC' && tipo!='CE'){

                    $('.loading').removeClass('hidden');

                    $.ajax({
                        url: 'guardarservicio',
                        method: 'post',
                        data: {
                          cliente: client,
                          ciudad: ciudad,
                          fecha: fecha,
                          hora: hora,
                          desde: desde,
                          hasta: hasta,
                          nota: notas,
                          nombres: datanombreArray,
                          celulares: datacelularArray,
                          correos: datacorreoArray,
                        },
                        dataType: 'json',
                      }).done(function(data){

                        if (data.respuesta===true) {

                            $('.loading').addClass('hidden');
                            $('#solicitar').removeClass('hidden').attr('disabled', 'disabled');

                            $.confirm({
                                title: '¡Realizado! <i style="color: green" class="fa fa-check" aria-hidden="true"></i> ',
                                content: 'Servicio solicitado exitosamente!!! <br><br><br> Pronto le enviaremos la confirmación de su traslado...',
                                type: 'green',
                                typeAnimated: true,
                                buttons: {
                                  tryAgain: {
                                    text: 'Ok',
                                    btnClass: 'btn-success',
                                    action: function(){
                                      window.location.href = "https://www.aotour.com.co";
                                    }
                                  }
                                }
                            });

                        }else if (data.respuesta===false) {

                            $.confirm({
                                title: '¡Error! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                                content: 'No se guardó el Servicio...',
                                type: 'red',
                                typeAnimated: true,
                                buttons: {
                                  tryAgain: {
                                    text: 'Entendido',
                                    btnClass: 'btn-danger',
                                    action: function(){
                                      //window.location.href = "https://www.aotour.com.co/portalusuarios/";
                                    }
                                  }
                                }
                            });

                        }
                      });

                }else{

                    var distanciaServicio = '';
                    var tiempoServicio = '';
                    var directionsService = new google.maps.DirectionsService();
                    var directionsRenderer = new google.maps.DirectionsRenderer();

                    var start = document.getElementById('desde').value;
                    var end = document.getElementById('hasta').value;
                    var request = {
                        origin: start,
                        destination: end,
                        travelMode: 'DRIVING'
                    };
                    directionsService.route(request, function(result, status) {
                        if (status == 'OK') {
                            directionsRenderer.setDirections(result);

                            //console.log(result);
                            //console.log(result.routes[0].legs[0].duration['text']);

                            $('#fee').removeClass('hidden');
                            $('#fees').removeClass('hidden');

                            distanciaServicio = result.routes[0].legs[0].distance['text'];
                            tiempoServicio = result.routes[0].legs[0].duration['text'];

                            $('#distancia').html(distanciaServicio);
                            $('#tiempo').html(tiempoServicio);

                            /*url de consulta para calcular la tarifa*/

                            var distanciaValue = result.routes[0].legs[0].distance['value'];
                            var tiempoValue = result.routes[0].legs[0].duration['value'];

                            $.ajax({
                            url: 'consultartarifa',
                            method: 'post',
                            data: {
                              distancia: distanciaValue,
                              tiempo: tiempoValue
                            },
                            dataType: 'json',
                            }).done(function(data){

                                if (data.respuesta===true) {

                                    $('#precio').html('COP $ '+number_format(data.valor));
                                    $('.card_credit').attr('info',data.valor);

                                    $.confirm({
                                        title: '¡Tarifa Asignada! <i style="color: green" class="fa fa-check" aria-hidden="true"></i> ',
                                        content: 'Se le ha asignado un precio a su servicio!',
                                        type: 'green',
                                        typeAnimated: true,
                                        buttons: {
                                          tryAgain: {
                                            text: 'Ok',
                                            btnClass: 'btn-success',
                                            action: function(){

                                                $('#request').removeClass('hidden');

                                                $('#datepicker').attr('disabled','disabled');
                                                $('#hora_servicio').attr('disabled','disabled');
                                                $('#desde').attr('disabled','disabled');
                                                $('#hasta').attr('disabled','disabled');
                                                $('#ciudad').attr('disabled','disabled');
                                                $('#notas').attr('disabled','disabled');

                                                $('#agregar_descuento').attr('disabled','disabled');
                                                $('#agregar_descuento').attr('disabled','disabled');

                                                $('#nombre').attr('disabled','disabled');
                                                $('#celular').attr('disabled','disabled');
                                                $('#correo').attr('disabled','disabled');

                                                $('.card_credit').attr('client',client);
                                                $('.card_credit').attr('ciudad',ciudad);
                                                $('.card_credit').attr('fecha',fecha);
                                                $('.card_credit').attr('hora',hora);
                                                $('.card_credit').attr('desde',desde);
                                                $('.card_credit').attr('hasta',hasta);
                                                $('.card_credit').attr('notas',notas);
                                                $('.card_credit').attr('datanombreArray',datanombreArray);
                                                $('.card_credit').attr('datacelularArray',datacelularArray);
                                                $('.card_credit').attr('datacorreoArray',datacorreoArray);

                                                $('#solicitar').addClass('hidden');

                                            }
                                          }
                                        }
                                    });
                                }else if (data.respuesta===false) {

                                    $.confirm({
                                        title: '¡Error! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                                        content: 'No se pudo obtener una tarifa...',
                                        type: 'red',
                                        typeAnimated: true,
                                        buttons: {
                                          tryAgain: {
                                            text: 'Entendido',
                                            btnClass: 'btn-danger',
                                            action: function(){
                                              //window.location.href = "https://www.aotour.com.co/portalusuarios/";
                                            }
                                          }
                                        }
                                    });
                                }
                            });
                            /*url de consulta para el cálculo de la tarifa*/


                        }
                    });



                    /*$('.formulario').addClass('hidden');
                    $('.contenedor').removeClass('hidden');

                    $('.card_credit').attr('client',client);
                    $('.card_credit').attr('fecha',fecha);
                    $('.card_credit').attr('hora',hora);
                    $('.card_credit').attr('desde',desde);
                    $('.card_credit').attr('hasta',hasta);
                    $('.card_credit').attr('notas',notas);
                    $('.card_credit').attr('datanombreArray',datanombreArray);
                    $('.card_credit').attr('datacelularArray',datacelularArray);
                    $('.card_credit').attr('datacorreoArray',datacorreoArray);*/

                }

            }



            console.log('Array de nombres : '+datanombreArray)

            console.log('Array de Celular : '+datacelularArray)

            console.log('Array de Correo : '+datacorreoArray)

        }

    });

    $('#desde').keyup(function(){
        var valor = $(this).val();
        $('#hasta_regreso').val(valor);
    });

    $('#hasta').keyup(function(){
        var valor = $(this).val();
        $('#desde_regreso').val(valor);
    });

    $('#hora_servicio').datetimepicker({
        format: 'HH:mm',
        locale: 'es',
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

    $('#hora_servicio2').datetimepicker({
        format: 'HH:mm',
        locale: 'es',
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

  });

function guardarServicio(brand,last_four,reference_code,order_id,precio,nombre_subcentro,email_subcentro,celular_subcentro,identificacion_subcentro,direccion_subcentro,sw,client,ciudad,fecha,hora,desde,hasta,notas,datanombreArray,datacelularArray,datacorreoArray) {

        /*Código AJAX*/
        $.ajax({
            url: 'guardarservicio',
            method: 'post',
            data: {
              brand: brand,
              last_four: last_four,
              reference_code: reference_code,
              order_id: order_id,
              precio: precio,
              nombre_subcentro: nombre_subcentro,
              email_subcentro: email_subcentro,
              celular_subcentro: celular_subcentro,
              identificacion_subcentro: identificacion_subcentro,
              direccion_subcentro: direccion_subcentro,
              sw: sw,
              cliente: client,
              ciudad: ciudad,
              fecha: fecha,
              hora: hora,
              desde: desde,
              hasta: hasta,
              nota: notas,
              nombres: datanombreArray,
              celulares: datacelularArray,
              correos: datacorreoArray,
            },
            dataType: 'json',
          }).done(function(data){

            if (data.respuesta===true) {

                $.confirm({
                    title: '¡Realizado! <i style="color: green" class="fa fa-check" aria-hidden="true"></i> ',
                    content: 'Servicio solicitado exitosamente!!! <br><br><br> Pronto le enviaremos la confirmación de su traslado...',
                    type: 'green',
                    typeAnimated: true,
                    buttons: {
                      tryAgain: {
                        text: 'Ok',
                        btnClass: 'btn-success',
                        action: function(){
                          //window.location.href = "https://www.aotour.com.co";

                          /*Redireccionamiento a la confirmación del pago*/
                          $('.pagado').removeClass('hidden');

                          $('#desde_pagado').val(data.desde);
                          $('#hasta_pagado').val(data.hasta);

                          $('#datepicker_pagado').val(data.fecha);
                          $('#hora_servicio_pagado').val(data.hora);
                          $('#notas_pagado').val(data.nota);

                          $('#brand').html(brand); //falta
                          $('#lastfour').html(last_four); //falta
                          $('#valor').html('COP $ '+number_format(precio)); //falta

                          $('.contenedor').addClass('hidden');
                          $('.formulario').addClass('hidden');

                          $('#seconds').removeClass('hidden');

                          setTimeout(function() {

                            window.location.href = "https://www.aotour.com.co";

                          }, 6000);

                        }
                      }
                    }
                });

            }else if (data.respuesta===false) {

                $.confirm({
                    title: '¡Error! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                    content: 'No se guardó el Servicio...',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                      tryAgain: {
                        text: 'Entendido',
                        btnClass: 'btn-danger',
                        action: function(){

                        }
                      }
                    }
                });

            }
          });
        /*Código AJAX*/
    }

    function number_format(number, decimals, dec_point, thousands_sep) {

        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
          var k = Math.pow(10, prec);
          return '' + (Math.round(n * k) / k)
            .toFixed(prec);
        };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
             s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '')
            .length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    const tarjeta = document.querySelector('#tarjeta'),
          btnAbrirFormulario = document.querySelector('#btn-abrir-formulario'),
          formulario = document.querySelector('#formulario-tarjeta'),
          numeroTarjeta = document.querySelector('#tarjeta .numero'),
          nombreTarjeta = document.querySelector('#tarjeta .nombre'),
          logoMarca = document.querySelector('#logo-marca'),
          firma = document.querySelector('#tarjeta .firma p'),
          mesExpiracion = document.querySelector('#tarjeta .mes'),
          yearExpiracion = document.querySelector('#tarjeta .year');
          ccv = document.querySelector('#tarjeta .ccv');

    // * Volteamos la tarjeta para mostrar el frente.
    const mostrarFrente = () => {
        if(tarjeta.classList.contains('active')){
            tarjeta.classList.remove('active');
        }
    }

    // * Rotacion de la tarjeta
    tarjeta.addEventListener('click', () => {
        tarjeta.classList.toggle('active');
    });

    // * Boton de abrir formulario
    btnAbrirFormulario.addEventListener('click', () => {
        btnAbrirFormulario.classList.toggle('active');
        formulario.classList.toggle('active');
    });

    // * Select del mes generado dinamicamente.
    for(let i = 1; i <= 12; i++){
        let opcion = document.createElement('option');
        opcion.value = i;
        opcion.innerText = i;
        formulario.selectMes.appendChild(opcion);
    }

    // * Select del año generado dinamicamente.
    const yearActual = new Date().getFullYear();
    for(let i = yearActual; i <= yearActual + 8; i++){
        let opcion = document.createElement('option');
        opcion.value = i;
        opcion.innerText = i;
        formulario.selectYear.appendChild(opcion);
    }

    // * Input numero de tarjeta
    formulario.inputNumero.addEventListener('keyup', (e) => {
        let valorInput = e.target.value;

        formulario.inputNumero.value = valorInput
        // Eliminamos espacios en blanco
        .replace(/\s/g, '')
        // Eliminar las letras
        .replace(/\D/g, '')
        // Ponemos espacio cada cuatro numeros
        .replace(/([0-9]{4})/g, '$1 ')
        // Elimina el ultimo espaciado
        .trim();

        numeroTarjeta.textContent = valorInput;

        if(valorInput == ''){
            numeroTarjeta.textContent = '#### #### #### ####';

            logoMarca.innerHTML = '';
        }

        if(valorInput[0] == 4){
            logoMarca.innerHTML = '';
            const imagen = document.createElement('img');
            imagen.src = 'https://app.aotour.com.co/autonet/img/img/logos/visa.png';
            logoMarca.appendChild(imagen);
        } else if(valorInput[0] == 5){
            logoMarca.innerHTML = '';
            const imagen = document.createElement('img');
            imagen.src = 'https://app.aotour.com.co/autonet/img/img/logos/mastercard.png';
            logoMarca.appendChild(imagen);
        }

        // Volteamos la tarjeta para que el usuario vea el frente.
        mostrarFrente();
    });

    // * Input nombre de tarjeta
    formulario.inputNombre.addEventListener('keyup', (e) => {
        let valorInput = e.target.value;

        formulario.inputNombre.value = valorInput.replace(/[0-9]/g, '');
        nombreTarjeta.textContent = valorInput;
        firma.textContent = valorInput;

        if(valorInput == ''){
            nombreTarjeta.textContent = 'Jhon Doe';
        }

        mostrarFrente();
    });

    // * Select mes
    formulario.selectMes.addEventListener('change', (e) => {
        mesExpiracion.textContent = e.target.value;
        mostrarFrente();
    });

    // * Select Año
    formulario.selectYear.addEventListener('change', (e) => {
        yearExpiracion.textContent = e.target.value.slice(2);
        mostrarFrente();
    });

    // * CCV
    formulario.inputCCV.addEventListener('keyup', () => {
        if(!tarjeta.classList.contains('active')){
            tarjeta.classList.toggle('active');
        }

        formulario.inputCCV.value = formulario.inputCCV.value
        // Eliminar los espacios
        .replace(/\s/g, '')
        // Eliminar las letras
        .replace(/\D/g, '');

        ccv.textContent = formulario.inputCCV.value;
    });

  </script>

</body>
</html>
