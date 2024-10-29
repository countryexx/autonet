<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Registro de Proveedores</title>
        @include('scripts.styles')
        <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
        <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
        <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
        <link rel="stylesheet" href="css/normalize.css">
        <link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
        <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
        <link rel="stylesheet" href="css/main.css">
        <style type="text/css">
            *, *:before, *:after {
              -moz-box-sizing: border-box;
              -webkit-box-sizing: border-box;
              box-sizing: border-box;
            }

            body {
              font-family: 'Nunito', sans-serif;
              color: #384047;
            }

            form {
              max-width: 300px;
              margin: 10px auto;
              padding: 15px 20px;
              background: #f4f7f8;
              border-radius: 8px;
            }

            h1 {
              margin: 0 0 30px 0;
              text-align: center;
            }

            input[type="text"],
            input[type="password"],
            input[type="date"],
            input[type="datetime"],
            input[type="email"],
            input[type="number"],
            input[type="search"],
            input[type="tel"],
            input[type="time"],
            input[type="url"],
            textarea,
            select {
              background: orange;
              border: none;
              font-size: 11px;
              height: auto;
              margin: 0;
              outline: 0;
              padding: 10px;
              width: 100%;
              background-color: white;
              color: #black;
              box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
              margin-bottom: 30px;
            }

            input[type="radio"],
            input[type="checkbox"] {
              margin: 0 4px 8px 0;
            }

            select {
              padding: 6px;
              height: 32px;
              border-radius: 2px;
            }

            button {
              padding: 10px 30px 10px 30px;
              color: #FFF;
              background-color: #4bc970;
              font-size: 15px;
              text-align: center;
              font-style: normal;
              border-radius: 5px;
              width: 100%;
              border: 1px solid #3ac162;
              border-width: 1px 1px 3px;
              box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
              margin-bottom: 10px;
            }

            .button1 {
              padding: 19px 39px 18px 39px;
              color: #FFF;
              background-color: #9E9E98;
              font-size: 12px;
              text-align: center;
              font-style: normal;
              border-radius: 5px;
              width: 100%;
              border: 1px solid #9E9E98;
              border-width: 1px 1px 3px;
              box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
              margin-bottom: 10px;
            }

            .button2 {
              padding: 19px 39px 18px 39px;
              color: #FFF;
              background-color: #8FD817;
              font-size: 12px;
              text-align: center;
              font-style: normal;
              border-radius: 5px;
              width: 100%;
              border: 1px solid #8FD817;
              border-width: 1px 1px 3px;
              box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
              margin-bottom: 10px;
            }

            #siguiente {
              padding: 19px 39px 18px 39px;
              color: #FFF;
              background-color: #4bc970;
              font-size: 12px;
              text-align: center;
              font-style: normal;
              border-radius: 5px;
              width: 100%;
              border: 1px solid #4bc970;
              border-width: 1px 1px 3px;
              box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
              margin-bottom: 10px;
            }

            #atras {
              padding: 19px 39px 18px 39px;
              color: #FFF;
              background-color: red;
              font-size: 12px;
              text-align: center;
              font-style: normal;
              border-radius: 5px;
              width: 100%;
              border: 1px solid red;
              border-width: 1px 1px 3px;
              box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
              margin-bottom: 10px;
            }

            fieldset {
              margin-bottom: 30px;
              border: none;
            }

            legend {
              font-size: 2.4em;
              margin-bottom: 10px;
            }

            label {
              display: block;
              margin-bottom: 8px;
            }

            label.light {
              font-weight: 300;
              display: inline;
            }

            .number {
              background-color: #5fcf80;
              color: #fff;
              height: 30px;
              width: 30px;
              display: inline-block;
              font-size: 0.8em;
              margin-right: 4px;
              line-height: 30px;
              text-align: center;
              text-shadow: 0 1px 0 rgba(255,255,255,0.2);
              border-radius: 100%;
            }

            @media screen and (min-width: 480px) {

              form {
                max-width: 1080px;
              }

            }

            .campo_vacio{
                background: red;
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
                background-color:#FA8F07;
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
                background-color: white;
                text-align: center;
            }

            .inactivo {
                padding: 10px;
                background-color: gray;
                text-align: center;
            }

        </style>
    </head>
    <body style="background-color: #E8E8E8;">

      <form class="formulario" style="background-color: #FA8F07">

        <div id="navega">
        <div id="menu">
            <div id="fijo">
                <!--<a href="#">1. Información Básica</a> |
                <a href="#">2. Datos del Conductor</a> |
                <a href="#">3. Datos del Vehículo</a> |
                <a href="#">4. Datos Financieros</a> |-->
                <div class="row">
            <div class="col-xs-3">
                <div class="proveedores activo">
                    <legend style="font-size: 13px;"><span class="number" style="color: white; font-size: 10px;">1</span><br><b>Información Básica</b></legend>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="conductor inactivo">
                    <legend style="font-size: 13px;"><span class="number">2</span><br><b>Conductor</b></legend>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="vehiculo inactivo">
                    <legend style="font-size: 13px;"><span class="number">3</span><br><b>Vehículo</b> <i class="fa fa-car" aria-hidden="true"></i></legend>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="financieros inactivo">
                    <legend style="font-size: 13px;"><span class="number">4</span><br><b>Datos Financieros</b> <i class="fa fa-money" aria-hidden="true"></i></legend>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>

        <h1 style="margin-top: 90px;">Registro de Proveedores</h1>

        <!-- 1.0 -->
        <fieldset class="uno" style="margin-top: 10px;">
          <legend><span class="number">1</span>Información Básica</legend>
          <div class="row">
              <div class="col-xs-4">
                <label for="name"><b>Nombres y Apellidos o Razón Social:</b> <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty hidden" aria-hidden="true"></i></label></label>
                <input type="text" id="name" name="user_name">
                </div>
                <div class="col-xs-3">
                    <label for="job"><b>Tipo de Empresa:</b></label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_tipoempresa hidden" aria-hidden="true"></i></label>
                    <select id="tipo_empresa" name="tipo_empresa">
                        <option value="0">-</option>
                        <option value="pn">PERSONA NATURAL</option>
                        <option value="sas">S.A.S</option>
                        <option value="srl">S.R.L</option>
                        <option value="sa">S.A</option>
                        <option value="ltda"> L.T.D.A</option>
                    </select>
                </div>
                <div class="col-lg-2 col-xs-12">
                  <label for="name"><b>Nit o CC:</b></label>
                  <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_cc hidden" aria-hidden="true"></i></label>
                  <input type="number" id="cc" name="user_cc">
                </div>
                <div class="col-lg-2 col-xs-12">
                  <label for="name"><b>Dígito de Verificación:</b></label>
                  <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_digito hidden" aria-hidden="true"></i></label>
                  <input type="number" id="digito_verificacion" name="digito_verificacion" maxlength=1>
                </div>
            </div>

            <label class="pn hidden" for="job"><b>Tipo de Servicio:</b>b</label>
            <select class="pn hidden" id="tipo_empresa" name="tipo_empresa">
                <option value="0">-</option>
                <option value="pn">P.N</option>
                <option value="sas">S.A.S</option>
                <option value="srl">S.R.L</option>
                <option value="sa">S.A</option>
                <option value="ltda"> L.T.D.A</option>
            </select>

            <div class="row">
                <div class="col-xs-3">
                    <label for="mail"><b>Email:</b></label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_email hidden" aria-hidden="true"></i></label>
                    <input type="email" id="mail" name="user_email">
                </div>
                <div class="col-xs-2">
                    <label for="celular"><b>Celular:</b></label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_celular hidden" aria-hidden="true"></i></label>
                    <input type="number" id="celular" name="celular">
                </div>
                <div class="col-xs-2">
                    <label for="telefono"><b>Teléfono:</b></label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_telefono hidden" aria-hidden="true"></i></label>
                    <input type="number" id="telefono" name="telefono">
                </div>
                <div class="col-xs-3">
                    <label for="direccion"><b>Dirección:</b></label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_direccion hidden" aria-hidden="true"></i></label>
                    <input type="text" id="direccion" name="direccion">
                </div>
            </div>

            <div class="row">

                <div class="col-xs-3">
                    <label for="departamento"><b>Departamento:</b></label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_departamento hidden" aria-hidden="true"></i></label>
                    <select id="departamento" name="departamento">
                        <option value="0">-</option>
                        @foreach($departamentos as $departamento)
                        <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xs-3">
                    <label for="ciudad"><b>Ciudad:</b></label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_ciudad hidden" aria-hidden="true"></i></label>
                    <select disabled id="ciudad" name="ciudad">
                        <option>-</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="sede"><b>¿A qué sede está interesado(a) en ingresar?</b></label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_sede hidden" aria-hidden="true"></i></label>
                    <select id="sede" name="sede">
                        <option>-</option>
                        <option>BARRANQUILLA</option>
                        <option>BOGOTÁ</option>
                        <option>CARTAGENA</option>
                        <option>MEDELLÍN</option>
                        <option>CALI</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <label for="fotoc"><b>Registro fotográfico tipo cédula (png,jpeg,jpg)</b></label>
                    <input id="fotop" accept="image/x-png,image/image/jpeg" class="fotop" type="file" name="fotop" >
                </div>
            </div>


            <div class="row">

                <div class="col-xs-12">
                    <h5 style="text-align: center;">¿ Quién será el conductor ?</h5>
                </div>
                <div class="col-xs-6">
                    <button id="proveedor_conductor" data-value="proveedor_conductor" type="button" data-number="1" class="proveedor_conductor button1">Yo seré el Conductor <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
                <div class="col-xs-6">
                    <button id="solo_proveedor" data-value="solo_proveedor" type="button" data-number="1" class="proveedor_conductor button1">El Conductor será otra persona <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
                <center><h5 style="text-decoration: underline"><b>Nota:</b> Cuando aprobemos tu documentación podrás agregar más conductores y vehículos</h5></center>
            </div>

            <!--<div class="row type_proveedor" style="margin-top: 20px;">
                <div class="col-lg-4 col-xs-10">
                    <label for="male">Sólo soy el proveedor</label><br>
                </div>
                <div class="col-xs-1">
                    <input type="radio" id="solo_proveedor" name="tipo_proveedor" value="solo_proveedor">
                </div>
            </div>

            <div class="row type_proveedor">
                <div class="col-lg-4 col-xs-10">
                    <label for="female">Soy el proveedor y también el conductor</label><br>
                </div>
                <div class="col-xs-1">
                    <input type="radio" id="proveedor_conductor" name="tipo_proveedor" value="proveedor_conductor">
                </div>
            </div>-->

        </fieldset>

        <!-- 1.1 Información cuando el proveedor no es Persona Natural -->
        <!-- Esta información se debe guardar para la posterior revisión por CONTABILIDAD Y JURÍDICA -->

        <fieldset class="unos sas hidden">
            <legend><span class="number">1.1</span>Información de Contacto</legend>
            <div class="row">
                <div class="col-xs-12">
                    <label class="obligatorio" for="contacto_nombrecompleto">Nombre Completo</label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_ncontacto" aria-hidden="true"></i></label>
                    <input class="form-control input-font" id="contacto_nombrecompleto" type="text">
                </div>
                <div class="col-xs-12">
                    <label class="obligatorio" for="cargop">Cargo</label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_ccontacto" aria-hidden="true"></i></label>
                    <input type="text" class="form-control input-font" id="cargop">
                </div>
                <div class="col-xs-12">
                    <label class="obligatorio" for="email_contacto">Email</label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_econtacto" aria-hidden="true"></i></label>
                    <input type="email" class="form-control input-font" id="email_contacto">
                </div>
                <div class="col-xs-12">
                    <label class="obligatorio" for="telefono_contacto">Telefono</label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_tcontacto" aria-hidden="true"></i></label>
                    <input type="number" class="form-control input-font" id="telefono_contacto">
                </div>
                <div class="col-xs-12">
                    <label class="obligatorio" for="celular_contacto">Celular</label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_celcontacto" aria-hidden="true"></i></label>
                    <input type="number" class="form-control input-font" id="celular_contacto">
                </div>
            </div>
        </fieldset>

        <!-- 1.2 -->

        <fieldset class="unos sas hidden">
            <legend><span class="number">1.2</span>Información Tributaria</legend>
            <div class="row">
                <div class="col-xs-12">
                    <label class="obligatorio" for="actividad_economica">Actividad Economica</label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_actividad" aria-hidden="true"></i></label>
                    <input type="text" class="form-control input-font" id="actividad_economica">
                </div>
                <div class="col-xs-12">
                    <label class="obligatorio" for="codigo_actividad">Codigo de Actividad</label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_actividadc" aria-hidden="true"></i></label>
                    <input type="text" class="form-control input-font" id="codigo_actividad">
                </div>
                <div class="col-xs-12">
                    <label class="obligatorio" for="codigo_ica">Codigo ICA</label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_icac" aria-hidden="true"></i></label>
                    <input class="form-control input-font" type="text" id="codigo_ica">
                </div>
                <div class="col-xs-12">
                    <label class="obligatorio" for="tarifa_ica">Tarifa ICA</label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_icat" aria-hidden="true"></i></label>
                    <input type="text" class="form-control input-font" id="tarifa_ica">
                </div>
                <div class="col-xs-12">
                    <label class="obligatorio" for="tipo_servicio">Tipo de Servicio</label>
                    <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty_tipos" aria-hidden="true"></i></label>
                    <select class="form-control input-font" id="tipo_servicio" name="tipo_servicio">
                      <option>-</option>
                      <option>TRANSPORTE TERRESTRE</option>
                      <option>HOTEL</option>
                      <option>OTROS</option>
                  </select>
                </div>
            </div>
        </fieldset>
        <!-- FIN INFORMACIÓN DE DATOS DEL PROVEEDOR -->

        <!--<div class="row">
            <div class="col-xs-12">
                <h5 style="text-align: center;">¿Quién será el conductor?</h5>
            </div>
            <div class="col-xs-6">
                <button id="proveedor_conductor" data-value="proveedor_conductor" type="button" data-number="1" class="proveedor_conductor button1">Yo seré el Conductor <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            </div>
            <div class="col-xs-6">
                <button id="solo_proveedor" data-value="solo_proveedor" type="button" data-number="1" class="proveedor_conductor button1">El Conductor será otra persona <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            </div>
        </div>-->

        <!-- INICIO INFORMACIÓN DE CONDUCTORES -->
        <fieldset class="tres hidden">

          <legend><span class="number">2</span>Información de Conductores</legend>

            <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 15px;">
                <li role="presentation" class="active">
                    <a href="#info" aria-controls="progr_exx" id="prog_exx" role="tab" data-toggle="tab" style="color: black">INFORMACIÓN DEL CONDUCTOR</a>
                </li>
                <!--<li role="presentation">
                    <a href="#ss" aria-controls="e" id="export_ruta2" role="tab" data-toggle="tab" style="color: black">DOCUMENTACIÓN (PDF)</a>
                </li>-->
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="info">
                    <div class="row">

                        <div class="col-xs-4">
                            <label class="obligatorio" for="nombre_completoc"><b>Ingrese el nombre completo del conductor</b></label>
                            <label><i style="color: red; font-size: 18px; float: right" title="Campo Vacío" class="fa fa-times empty hidden" aria-hidden="true"></i></label>
                            <input type="text" class="form-control" id="nombre_completoc">
                        </div>
                        <div class="col-lg-3 col-xs-12">
                            <label class="obligatorio" for="ccconcd"><b>Número de Identificación</b></label>
                            <input type="number" class="form-control input-font" id="ccconcd">
                        </div>
                        <div class="col-lg-2 col-xs-6">
                            <label class="obligatorio" for="generoc"><b>Género</b></label>
                            <select class="form-control input-font" id="generoc">
                                <option>-</option>
                                <option>MASCULINO</option>
                                <option>FEMENINO</option>
                            </select>
                        </div>
                        <div class="col-lg-1 col-xs-6">
                            <label class="obligatorio" for="edadc"><b>Edad</b></label>
                            <input type="number" class="form-control input-font" id="edadc">
                        </div>
                        <div class="col-lg-2 col-xs-6">
                            <label class="obligatorio" for="experienciac"><b>Experiencia (Años)</b></label>
                            <input type="number" class="form-control input-font" id="experienciac">
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-lg-2 col-xs-12">
                        <label class="obligatorio" for="departamentoc"><b>Departamento</b></label>
                        <select class="form-control input-font" id="departamentoc">
                            <option>-</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-xs-12">
                        <label class="obligatorio" for="ciudadc"><b>Ciudad o Municipio</b></label>
                        <select disabled class="form-control input-font" id="ciudadc">
                            <option>-</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-xs-12">
                        <label class="obligatorio" for="direccionc"><b>Direccion</b></label>
                        <input type="text" class="form-control input-font" id="direccionc">
                    </div>
                        <div class="col-lg-2 col-xs-12">
                            <label class="obligatorio" for="celularc"><b>Celular</b></label>
                            <input type="number" class="form-control input-font" id="celularc">
                        </div>
                        <div class="col-lg-2 col-xs-12">
                            <label for="telefonoc"><b>Telefono</b></label>
                            <input type="number" class="form-control input-font" id="telefonoc">
                        </div>

                        <div class="col-lg-2 col-xs-12">
                            <label class="obligatorio" for="tipodelicenciac"><b>Tipo de licencia</b></label>
                            <select class="form-control input-font" id="tipodelicenciac">
                                <option>-</option>
                                <option>A1</option>
                                <option>A2</option>
                                <option>B1</option>
                                <option>B2</option>
                                <option>B3</option>
                                <option>C1</option>
                                <option>C2</option>
                                <option>C3</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-xs-12">
                            <label><b>Fecha de Expedicion</b></label>
                            <div class="input-group">
                                <div class='input-group date' id='datetimepicker'>
                                    <input type='text' class="form-control input-font" id="fecha_licencia_expedicionc">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xs-12">
                            <label><b>Fecha de Vencimiento</b></label>
                            <div class="input-group">
                                <div class="input-group date" id="datetimepicker">
                                    <input type="text" class="form-control input-font" id="fecha_licencia_vigenciac">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-xs-12">
                            <label class="obligatorio" for="accidentesc"><b>El conductor a tenido accidentes en los últimos 5 a&ntildeos?</b></label>
                            <select class="form-control input-font" id="accidentesc">
                                <option>-</option>
                                <option>SI</option>
                                <option>NO</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-xs-12 accidentes_description hidden">
                            <label class="obligatorio" for="descripcion_accidentec"><b>Describa detalladamente lo ocurrido</b></label>
                            <textarea rows="2" class="form-control input-font" id="descripcion_accidentec"></textarea>
                        </div>
                    </div>
                    <!--<div class="row">
                    <div class="col-xs-2">
                        <label class="obligatorio" for="vehiculo_propio_desplazamientoc">Veh propio desplaz</label>
                        <select class="form-control input-font" id="vehiculo_propio_desplazamientoc">
                            <option>-</option>
                            <option>SI</option>
                            <option>NO</option>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <label class="obligatorio" for="trayecto_casa_trabajoc">Trayecto casa - trabajo</label>
                        <select class="form-control input-font" id="trayecto_casa_trabajoc">
                            <option>-</option>
                            <option>VEHICULO</option>
                            <option>OTROS</option>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <label class="obligatorio" for="incidentesc">Incidentes materiales</label>
                        <select class="form-control input-font" id="incidentesc">
                            <option>-</option>
                            <option>SI</option>
                            <option>NO</option>
                        </select>
                    </div>
                    <div class="col-xs-3">
                        <label for="frecuencia_desplazamientoc">Frenc. de Desplazamiento</label>
                        <input type="text" class="form-control input-font" id="frecuencia_desplazamientoc">
                    </div>
                    </div>-->
                </div>
                <!-- SS Y FOTO -->
                <div role="tabpanel" class="tab-pane fade in inactive" id="ss">
                    <div class="row">
                            <div class="col-xs-6">
                                <label for="pdf_cc_conductor"><b>Cédula de Ciudadanía:</b></label>
                                <input id="pdf_cc_conductor" accept="application/pdf" class="pdf_cc_conductor" type="file" value="Subir" name="pdf_cc_conductor" >
                            </div>
                            <div class="col-xs-6">
                                <label for="pdf_licencia_conductor"><b>Licencia de Conducción:</b></label>
                                <input id="pdf_licencia_conductor" accept="application/pdf" class="pdf_licencia_conductor" type="file" value="Subir" name="pdf_licencia_conductor" >
                            </div>
                    </div>
                    <div class="row" style="margin-top: 25px">
                            <div class="col-xs-6">
                                <label for="pdf_ss"><b>Planilla de Seguridad Social Vigente:</b></label>
                                <input id="pdf_ss" accept="application/pdf" class="pdf_ss" type="file" value="Subir" name="pdf_ss" >
                            </div>
                            <div class="col-xs-6">
                                <label for="fotoc"><b>Foto del Conductor</b></label>
                                <input id="fotoc" accept="image/x-png,image/gif,image/jpeg" class="fotoc" type="file" name="fotoc" >
                            </div>
                    </div>
                </div>
            </div>
        </div>

        </fieldset>
        <!-- FIN INFORMACIÓN DE CONDUCTORES -->

        <!-- INICIO INFORMACIÓN DE VEHÍCULOS -->
        <fieldset class="dos hidden">

          <legend><span class="number">3</span>Información de Vehículos</legend>

            <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 15px;">
                    <li role="presentation" class="active">
                        <a href="#informacion" aria-controls="progr_exx" id="prog_exx" role="tab" data-toggle="tab" style="color: black">INFORMACIÓN DEL VEHÍCULO</a>
                    </li>
                    <li role="presentation">
                        <a href="#ops" aria-controls="e" id="export_ruta" role="tab" data-toggle="tab" style="color: black">DOCUMENTACIÓN (PDF)</a>
                    </li>
                    <!--<li role="presentation">
                        <a href="#tecno" aria-controls="e" id="export_ruta2" role="tab" data-toggle="tab" style="color: black">TECNOMECÁNICA</a>
                    </li>-->
                    <!--<li role="presentation">
                        <a href="#polizas" aria-controls="e" id="nombres_ruta" role="tab" data-toggle="tab" style="color: black">FOTOS DEL VEHÍCULO</a>
                    </li>-->
                </ul>
                <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="informacion">
                <div class="row">
                    <div class="col-xs-2">
                        <label class="obligatorio" for="placa"><b>Placa</b></label>
                        <input type="text" class="form-control input-font" id="placa">
                    </div>
                    <div class="col-xs-2">
                        <label class="obligatorio" for="numero_interno"><b>Número Interno</b></label>
                        <input type="number" class="form-control input-font" id="numero_interno">
                    </div>
                    <div class="col-xs-2">
                        <label class="obligatorio" for="numero_motor"><b>Numero del Motor</b></label>
                        <input type="text" class="form-control input-font" id="numero_motor">
                    </div>
                    <div class="col-xs-2">
                        <label class="obligatorio" for="clase"><b>Clase</b></label>
                        <select class="form-control input-font" id="clase">
                            <option>-</option>
                            <option>AUTOMOVIL</option>
                            <option>CAMPERO</option>
                            <option>CAMIONETA</option>
                            <option>BUSETA</option>
                            <option>BUS</option>
                            <option>MICROBUS</option>
                            <option>MINIVAN</option>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <label class="obligatorio" for="marca"><b>Marca</b></label>
                        <input type="text" class="form-control input-font" id="marca">
                    </div>
                    <div class="col-xs-2">
                        <label class="obligatorio" for="modelo"><b>Linea</b></label>
                        <input type="text" class="form-control input-font" id="modelo">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label for="anos" class="obligatorio"><b>Modelo</b></label>
                            <div class='input-group date' id='datetimep'>
                                <input type='text' class="form-control input-font" id="ano">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar">
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <label class="obligatorio" for="capacidad"><b>Capacidad</b></label>
                        <input type="number" class="form-control input-font" id="capacidad">
                    </div>
                    <div class="col-xs-2">
                        <label class="obligatorio" for="color"><b>Color</b></label>
                        <input class="form-control input-font" type="text" id="color">
                    </div>
                    <div class="col-xs-3">
                        <label class="obligatorio" for="color"><b>Cilindraje</b></label>
                        <input class="form-control input-font" type="text" id="cilindraje">
                    </div>
                    <div class="col-xs-3">
                        <label class="obligatorio" for="color"><b>V/N</b></label>
                        <input class="form-control input-font" type="text" id="vn">
                    </div>

                    <div class="col-xs-3">
                        <label class="obligatorio" for="propietario"><b>Propietario del Vehiculo</b></label>
                        <input class="form-control input-font" type="text" id="propietario">
                    </div>

                    <div class="col-xs-3">
                        <label class="obligatorio" for="cc"><b>Cédula de propietario</b></label>
                        <input class="form-control input-font" type="number" id="ccc">
                    </div>

                        <div class="col-xs-3" id="container_empresa_afiliada">
                            <label for="empresa_afiliada"><b>Empresa afiliada</b></label>
                            <select type="text" class="form-control input-font" id="empresa_afiliada">
                            <option value="0">-</option>
                            <option value="1">AOTOUR</option>
                            <option value="2">OTRO</option>
                            </select>
                        </div>
                        <div class="col-xs-3 cual_empresa hidden">
                            <label for="cual_empresa"><b>Empresa Afiliadora</b></label>
                            <input type="text" class="form-control input-font" id="cual_empresa">
                        </div>

                        <!--<div class="col-xs-4">
                            <label for="observaciones">Poliza Contractual</label>
                            <input type="text" class="form-control input-font" id="poliza_contractual"></input>
                        </div>
                        <div class="col-xs-4">
                            <label for="observaciones">Poliza Extra Contractual</label>
                            <input type="text" class="form-control input-font" id="poliza_extra_contractual"></input>
                        </div>
                        <div class="col-xs-4">
                            <label for="observaciones">Poliza Todo Riesgo</label>
                            <input type="text" class="form-control input-font" id="poliza_todo_riesgo"></input>
                        </div>-->

                </div>
            </div>
            <!-- TO Y SOAT -->
            <div role="tabpanel" class="tab-pane fade in inactive" id="ops">

                <div class="row">

                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-xs-4">
                              <label class="obligatorio" for="tarjeta_propiedad"><b>Tarjeta de Propiedad</b></label>
                              <input type="text" class="form-control input-font" id="tarjeta_propiedad">
                            </div>
                            <div class="col-xs-4">
                              <div class="form-group" style="margin-bottom: 0px;">
                                  <label for="fecha_vigencia_propiedad" class="obligatorio">Fecha de vencimiento</label>
                                  <div class='input-group date' id='datetimepicker2'>
                                      <input type='text' class="form-control input-font" id="fecha_vigencia_propiedad">
                                      <span class="input-group-addon">
                                          <span class="fa fa-calendar">
                                          </span>
                                      </span>
                                  </div>
                              </div>
                            </div>
                            <div class="col-xs-4" style="border-right: 1px solid;">
                              <label for="pdf_tpro"><b>Tarjeta de Propiedad PDF:</b></label>
                              <input id="pdf_tpro" accept="application/pdf" class="pdf_tpro" type="file" value="Subir" name="pdf_tpro" >
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-xs-4">
                                  <label class="obligatorio" for="vehiculo_tarjeta_operacion"><b>Tarjeta de Operación</b></label>
                                  <input type="text" class="form-control input-font" id="tarjeta_operacion">
                              </div>
                              <div class="col-xs-4">
                                  <div class="form-group" style="margin-bottom: 0px;">
                                      <label for="vehiculo_fecha_vigencia_operacion" class="obligatorio"><b>Fecha de Vencimiento</b></label>
                                      <div class='input-group date' id='datetimepicker2'>
                                          <input type='text' class="form-control input-font" id="fecha_vigencia_operacion">
                                          <span class="input-group-addon">
                                              <span class="fa fa-calendar">
                                              </span>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-xs-4">
                                  <label for="pdf_topr"><b>Tarjeta de Operación PDF:</b></label>
                                  <input id="pdf_topr" accept="application/pdf" class="pdf_topr" type="file" value="Subir" name="pdf_topr" >
                              </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-xs-6">
                              <div class="form-group" style="margin-bottom: 0px;">
                                  <label for="vehiculo_fecha_vigencia_soat" class="obligatorio"><b>Fecha de Vencimiento del Soat</b></label>
                                  <div class='input-group date' id='datetimepicker3'>
                                      <input type='text' class="form-control input-font" id="fecha_vigencia_soat">
                                      <span class="input-group-addon">
                                          <span class="fa fa-calendar">
                                          </span>
                                      </span>
                                  </div>
                              </div>
                          </div>
                          <div class="col-xs-6" style="border-right: 1px solid;">
                              <label for="pdf_soat"><b>SOAT PDF:</b></label>
                              <input id="pdf_soat" accept="application/pdf" class="pdf_soat" type="file" value="Subir" name="pdf_soat">
                          </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-xs-6">
                              <div class="form-group" style="margin-bottom: 0px;">
                                  <label for="vigencia_tecnomecanica" class="obligatorio"><b>Fecha de Vencimiento Tecnomecánica</b></label>
                                  <div class='input-group date' id='datetimepicker4'>
                                      <input type='text' class="form-control input-font" id="vigencia_tecnomecanica">
                                      <span class="input-group-addon">
                                          <span class="fa fa-calendar">
                                          </span>
                                      </span>
                                  </div>
                              </div>
                          </div>
                          <div class="col-xs-6">
                              <label for="pdf_tecno"><b>TECNOMECÁNICA PDF:</b></label>
                              <input id="pdf_tecno" accept="application/pdf" class="pdf_tecno" type="file" value="Subir" name="pdf_tecno">
                          </div>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-xs-6">
                              <div class="form-group" style="margin-bottom: 0px;">
                                  <label for="vigencia_contractual" class="obligatorio"><b>Fecha de vencimiento Póliza Contractual</b></label>
                                  <div class='input-group date' id='datetimepicker5'>
                                      <input type='text' class="form-control input-font" id="vigencia_contractual">
                                      <span class="input-group-addon">
                                          <span class="fa fa-calendar">
                                          </span>
                                      </span>
                                  </div>
                              </div>
                          </div>
                          <div class="col-xs-6">
                              <label for="pdf_contra"><b>PÓLIZA CONTRACTUAL PDF:</b></label>
                              <input id="pdf_contra" accept="application/pdf" class="pdf_contra" type="file" value="Subir" name="pdf_contra">
                          </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-xs-6">
                              <div class="form-group" style="margin-bottom: 0px;">
                                  <label for="vigencia_extracontractual" class="obligatorio"><b>Fecha de Vencimiento Póliza Extracontractual</b></label>
                                  <div class='input-group date' id='datetimepicker6'>
                                      <input type='text' class="form-control input-font" id="vigencia_extracontractual">
                                      <span class="input-group-addon">
                                          <span class="fa fa-calendar">
                                          </span>
                                      </span>
                                  </div>
                              </div>
                          </div>
                          <div class="col-xs-6">
                              <label for="pdf_extra"><b>PÓLIZA EXTRACONTRACTUAL PDF:</b></label>
                              <input id="pdf_extra" accept="application/pdf" class="pdf_extra" type="file" value="Subir" name="pdf_extra">
                          </div>
                        </div>
                    </div>

                </div>
                <hr>
                </div>
                <!-- POLIZAS -->
                <div role="tabpanel" class="tab-pane fade in inactive" id="polizas">
                    <div class="tab-pane fade in active" id="DatosGenerales" style="margin-top: 10px;">
                    <!-- IMAGENES VEHICULOS -->
                      <div class="panel-body" style="border: 1px">
                        <div class="row">
                            <div class="col-xs-3">
                                <label for="foto_frontal"><b>Foto Frontal</b></label>
                            </div>
                            <div class="col-xs-7">
                            <img src="{{url('img/capturas/frontal.PNG')}}" alt="">
                            </div>
                            <div class="col-xs-2">
                                <input id="foto_frontal" style="float: right" accept="image/x-png,image/gif,image/jpeg" class="foto_frontal" type="file" name="foto_frontal" >
                            </div>
                        </div>
                        <hr>
                        <div class="row" style="margin-top: 25px">
                            <div class="col-xs-3">
                                <label for="foto_dorso"><b>Foto Trasera</b></label>
                            </div>
                            <div class="col-xs-7">
                            <img src="{{url('img/capturas/trasera.PNG')}}" alt="">
                            </div>
                            <div class="col-xs-2">
                                <input id="foto_dorso" accept="image/x-png,image/gif,image/jpeg" class="foto_dorso" type="file" name="foto_dorso" >
                            </div>
                        </div>
                        <hr>
                        <div class="row" style="margin-top: 25px">
                            <div class="col-xs-3">
                                <label for="foto_derecha"><b>Foto desde la Derecha</b></label>
                            </div>
                            <div class="col-xs-7">
                            <img src="{{url('img/capturas/vista_derecha.PNG')}}" alt="">
                            </div>
                            <div class="col-xs-2">
                                <input id="foto_derecha" accept="image/x-png,image/gif,image/jpeg" class="foto_derecha" type="file" name="foto_derecha" >
                            </div>
                        </div>
                        <hr>
                        <div class="row" style="margin-top: 25px">
                            <div class="col-xs-3">
                                <label for="foto_izquierda"><b>Foto desde la Izquierda</b></label>
                            </div>
                            <div class="col-xs-7">
                                <img src="{{url('img/capturas/vista_izquierda.PNG')}}" alt="">
                            </div>
                            <div class="col-xs-2">
                                <input id="foto_izquierda" accept="image/x-png,image/gif,image/jpeg" class="foto_izquierda" type="file" name="foto_izquierda" >
                            </div>
                        </div>
                    </div>
                  </div>
                </div>

                    </div>

        </div>
           <!-- <a id="agregar_descuento" style="margin-right: 3px;" class="btn btn-info btn-icon margin">AGREGAR<i class="fa fa-plus icon-btn"></i></a>
            <a id="eliminar_descuento" class="btn btn-danger btn-icon">ELIMINAR<i class="fa fa-close icon-btn"></i></a>-->
            <table class="table table-bordered hover descuentos hidden" style="margin-bottom:15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);">
            </table>
        </fieldset>
        <!-- FIN INFORMACIÓN DE VEHÍCULOS -->

        <!-- INICIO INFORMACIÓN DE PAGOS -->
        <fieldset class="cuatro hidden">
          <legend><span class="number">4</span>Información para Pagos</legend>

            <div class="row">
                <div class="col-lg-4">
                    <label for="pago"><b>A quién se le realizarán los pagos?</b></label>
                    <select id="pago" name="pago">
                        <option value="0">Seleccionar</option>
                        <option value="1">Al Proveedor</option>
                        <option value="2">A un Tercero (Esposo(a), Hermano(a), etc.)</option>
                    </select>
                </div>
                <div class="col-lg-6">

                </div>
            </div>
            <div class="row tercero hidden">
                <div class="col-lg-12" style="margin-bottom: 15px">
                    <h4><b>A continuación ingrese los datos financieros de esa persona</b></h4>
                </div>
                <div class="col-lg-7 col-sm-12 col-xs-12 col-md-12">
                    <label class="obligatorio" for="razonsocialt" ><b>Nombres y Apellidos</b></label>
                    <input class="form-control input-font" type="text" id="razonsocialt">
                </div>
                <div class="col-lg-5 col-sm-12 col-xs-12 col-md-12">
                    <label class="obligatorio" for="numero_documentot" ><b>Número de Documento de Identidad</b></label>
                    <input class="form-control input-font" type="number" id="numero_documentot">
                </div>

            </div>
            <div class="row tercero hidden">
                <div class="col-lg-4 col-sm-12 col-xs-12">
                    <label class="obligatorio" for="tipo_cuentat" ><b>Tipo de Cuenta</b></label>
                    <select class="form-control input-font" name="tipo_cuentat" id="tipo_cuentat">
                        <option >-</option>
                        <option >AHORROS</option>
                        <option >CORRIENTE</option>
                    </select>
                </div>
                <div class="col-lg-4 col-sm-12 col-xs-12">
                    <label class="obligatorio" for="entidad_bancariat" ><b>Entidad Bancaria</b></label>
                    <select class="form-control input-font" name="entidad_bancariat" id="entidad_bancariat">
                        <option >-</option>
                        <option >BANCO DE BOGOTA</option>
                        <option >BANCO BBVA</option>
                        <option >BANCOLOMBIA</option>
                        <option >BANCO DAVIVIENDA</option>
                        <option >BANCO POPULAR</option>
                        <option >SCOTIABANK COLPATRIA S.A</option>
                        <option >BANCOOMEVA</option>
                        <option >BANCO FALABELLA S.A.</option>
                        <option >ITAÚ</option>
                        <option >BANCO CAJA SOCIAL</option>
                        <option >BANCO DE OCCIDENTE</option>
                        <option >BANCO AV VILLAS</option>
                        <option >BANCO PICHINCHA</option>
                        <option >HELM BANK</option>
                        <option >SUDAMERIS</option>
                        <option >HSBC</option>
                    </select>
                </div>
                <div class="col-lg-4 col-sm-12 col-xs-12">
                    <label class="obligatorio" for="numero_cuentat" ><b>Número de Cuenta</b></label>
                    <input class="form-control input-font" type="number" id="numero_cuentat">
                </div>
                <div class="col-lg-6 col-sm-12 col-xs-12 col-md-12">
                    <label class="obligatorio" for="certificacion_tercero"><b>Adjunte Certificación Bancaria</b></label>
                    <input id="certificacion_tercero" accept="application/pdf" class="certificacion_tercero" type="file" value="Subir" name="certificacion_tercero" class="perfil">

                    <a type="button" name="button" data-toggle="modal" class="btn btn-info boton_ver_certificacion_t hidden" data-empleado-id="" data-nombre="" target="_blank" title="Vista Previa">Ver Cerficicación <i class="fa fa-external-link" aria-hidden="true"></i></a>
                </div>
                <div class="col-lg-6 col-sm-12 col-xs-12">

                    <label class="obligatorio" for="certificacion"><b>Adjunte el Poder</b></label>
                <input id="poder_tercero" accept="application/pdf" class="poder_tercero" type="file" value="Subir" name="poder_tercero" class="perfil">

                <a type="button" name="button" data-toggle="modal" class="btn btn-info boton_ver_poder hidden" data-empleado-id="" data-nombre="" target="_blank" title="Vista Previa">Ver PODER  <i class="fa fa-external-link" aria-hidden="true"></i></a>

                </div>
            </div>
            <div class="row proveedor hidden">
                <div class="col-lg-12" style="margin-bottom: 15px">
                    <h4><b>A continuación ingrese sus datos financieros</b></h4>
                </div>
                <div class="col-lg-4 col-xs-12">
                    <label for="tipo_cuenta"><b>Tipo de Cuenta:</b></label>
                    <select id="tipo_cuenta" name="tipo_cuenta">
                        <option >-</option>
                        <option>AHORROS</option>
                        <option>CORRIENTE</option>
                    </select>
                </div>
                <div class="col-lg-4 col-xs-12">
                    <label for="entidad_bancaria"><b>Entidad Bancaria:</b></label>
                    <select id="entidad_bancaria" name="entidad_bancaria">
                        <option >-</option>
                        <option >BANCO DE BOGOTA</option>
                        <option >BANCO BBVA</option>
                        <option >BANCOLOMBIA</option>
                        <option >BANCO DAVIVIENDA</option>
                        <option >BANCO POPULAR</option>
                        <option >SCOTIABANK COLPATRIA S.A</option>
                        <option >BANCOOMEVA</option>
                        <option >BANCO FALABELLA S.A.</option>
                        <option >ITAÚ</option>
                        <option >BANCO CAJA SOCIAL</option>
                        <option >BANCO DE OCCIDENTE</option>
                        <option >BANCO AV VILLAS</option>
                        <option >BANCO PICHINCHA</option>
                        <option >HELM BANK</option>
                        <option >SUDAMERIS</option>
                        <option >HSBC</option>
                    </select>
                </div>
                <div class="col-lg-4 col-xs-12">
                    <label for="numero_cuenta"><b>Número de la cuenta:</b></label>
                    <input type="number" id="numero_cuenta" name="numero_cuenta">
                </div>
            </div>
            <div class="row proveedor hidden">

                <div class="col-lg-12 col-xs-12">
                    <label for="certificacion_proveedor"><b>Adjunte Certificación Bancaria:</b></label>
                    <input id="certificacion_proveedor" accept="application/pdf" class="certificacion_proveedor" type="file" value="Subir" name="certificacion_proveedor" >
                </div>
            </div>
        </fieldset>
        <!-- INICIO INFORMACIÓN DE PAGOS -->

        <div class="row">
            <!--<div class="col-xs-6">
                <button type="button" data-number="1" class="back_form" disabled="true" style="background: red"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás</button>
            </div>-->
            <div class="col-xs-12">
                <button type="button" data-number="1" class="continuar1 hidden">Continuar <i class="fa fa-arrow-right" aria-hidden="true"></i></button>

                <label><input type="checkbox" id="cbox1"><b>Autorizo el <a data-toggle="modal" data-target=".mymodalP">tratamiento</a> de datos</b></label>

                <!--<a style="margin-bottom: 7px;" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodalP">Ver Políticas<i class="fa fa-eye icon-btn"></i></a>-->

                <!--<button type="button" data-number="1" class="enviar2">Enviar Información <i class="fa fa-arrow-right" aria-hidden="true"></i></button>-->

                <div class="row">
                    <div class="col-lg-6 six hidden">
                        <button type="button" id="atras" data-number="1" class="enviar3"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás</button>
                    </div>
                    <div class="col-lg-6 six hidden">
                        <button type="button" id="siguiente" data-number="1" class="enviar3">Continuar <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                    </div>

                    <div class="col-lg-6 enviar_datos hidden"> <!-- Enviar datos -->
                        <button type="button" data-number="1" class="enviar2">Enviar Datos <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                    </div>

                    <div class="col-lg-12">
                        <button type="button" id="seguir" data-number="1" class="enviar3">Continuar <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                    </div>
                </div>

            </div>
        </div>

        <!-- TEST -->

    <!-- COLOCAR MODALES DINÁMICOS PARA LA CREACIÓN DE LOS VEHÍCULOS -->
    <!-- COLOCAR MODALES DINÁMICOS PARA LA CREACIÓN DE LOS CONDUCTORES -->
    <!-- COLOCAR MODAL DINÁMICO PARA LOS PROVEEDORES QUE TENGAN PAGO A TERCERO -->

    <!-- MODAL PDF -->
    <div class="modal mymodal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-color: orange">
          <div class="modal-header" style="background: #C0BFC0">
            <div class="row">
                <div class="col-lg-11">
                    <strong style="color: black">AGREGAR VEHÍCULO</strong>
                </div>
                <div class="col-lg-1">
                    <button style="float: right;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            </div>
          </div>
            <div class="modal-body tabbable">

                <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 15px;">
                    <li role="presentation" class="active">
                        <a href="#informacion" aria-controls="progr_exx" id="prog_exx" role="tab" data-toggle="tab" style="color: black">INFORMACIÓN DEL VEHÍCULO</a>
                    </li>
                    <li role="presentation">
                        <a href="#ops" aria-controls="e" id="export_ruta" role="tab" data-toggle="tab" style="color: black">TARJETA DE PROPIEDAD, OPERACIÓN, Y SOAT</a>
                    </li>
                    <li role="presentation">
                        <a href="#tecno" aria-controls="e" id="export_ruta2" role="tab" data-toggle="tab" style="color: black">TECNOMECÁNICA</a>
                    </li>
                    <li role="presentation">
                        <a href="#polizas" aria-controls="e" id="nombres_ruta" role="tab" data-toggle="tab" style="color: black">FOTOS DEL VEHÍCULO</a>
                    </li>
                </ul>

                </div>

            </div>
            </div>
        </div>
        <!-- MODAL VEHICULOS -->

    </form>

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

    <div class="modal" id="modal_alert" data-easein="bounceIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

            <div class="modal-body">
            <div id="contenido_alerta">
            </div>
            </div>
            </div>
        </div>
    </div>

    <div id="alert_eliminar" class="hidden">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: green; color: white">¡PROCESO DE REGISTRO COMPLETADO! <i class="fa fa-check-square-o" aria-hidden="true"></i><i id="cerrar_ventana" title="Cerrar Mensaje" style="float: right" class="fa fa-close"></i></div>
                <div class="panel-body">
                    <div id="contenido_alerta2">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        Dropzone.options.myDropzone = {
            acceptedFiles: ".png, .jpg",
            autoProcessQueue: false,
            uploadMultiple: false,
            maxFilezise: 1,
            maxFiles: 6,
            addRemoveLinks: 'dictCancelUploadConfirmation ',
            url: '../../proveedores/subirimagenes',
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

    </script>
    @include('scripts.scripts')

    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/portalproveedores.js')}}"></script>
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>

    <!--@include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
   <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="{{url('jquery/hvvehiculos.js')}}"></script>
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
-->
    <script>

      $('input[type=file]').bootstrapFileInput();
      $('.file-inputs').bootstrapFileInput();

    </script>

    </body>
</html>
