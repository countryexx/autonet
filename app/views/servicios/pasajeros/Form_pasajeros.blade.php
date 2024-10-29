<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro Portal de Usuarios AOTOUR</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="manifest" href="{{url('manifest.json')}}">   
    <style type="text/css">
        @media (max-width: @screen-xs-min) {
        .modal-lg { width: @modal-sm; }
        }
        .but {
        padding: 10px;
        color: #FFF;
        background-color: #545859;
        font-size: 18px;
        text-align: center;
        font-style: normal;
        border-radius: 5px;
        width: 10%;
        border-width: 1px 1px 3px;
        box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
        margin-bottom: 5px;
        width: 100%;
      }
    </style>     
</head>
<body style="background-color: #DC4405">
    <div class="container-fluid" >
        <div class="text-center" style="margin: 10px 0 15px 0">
            <img style="margin-top: 10px;" src="{{url('img/powered.png')}}" width="200px;">
        </div>
        <form id="formulario">            
            <div class="modal-header" style="background: #545859">                
              <center>	<strong style="font-size: 18px">PORTAL DE USUARIOS</strong></center>
            </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
    							<div class="col-lg-3 col-sm-12 col-xs-12 col-md-12">
                                    <label class="obligatorio" for="nombres" style="color: white;">Nombres</label>
                                    <input class="form-control input-font" type="text" status="0" id="nombres" placeholder="NOMBRES">
                                </div>
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label class="obligatorio" for="apellidos" style="color: white;">Apellidos</label>
                                    <input class="form-control input-font" type="text" status="0" id="apellidos" placeholder="APELLIDOS">
                                </div>
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label class="obligatorio" for="id_employer" style="color: white;">ID de empleado</label>
                                    <input class="form-control input-font" type="text" status="0" id="id_employer" placeholder="EMPLOY ID">
                                </div>
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label class="obligatorio" for="cedula" style="color: white;">Cédula</label>
                                    <input class="form-control input-font" type="number" status="0" id="cedula" placeholder="CÉDULA">
                                </div>
                        	</div>
                        	<div class="row">
                        		
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label class="obligatorio" for="empresa" style="color: white;">Empresa</label>
                                    <select class="form-control input-font" status="0" name="empresa" id="empresa">
                                        <option >-</option>
                                        <option >AUTO OCASIONAL TOUR BOG</option>
                                        <option >EMPRESA X</option>
                                        <!--
                                   		<option >SGS COLOMBIA HOLDING BARRANQUILLA</option>	
                                        <option >SGS COLOMBIA HOLDING BOGOTA</option>-->   
                                    </select>
                                </div>
                                <div class="col-lg-2 col-xs-7">
                                    <label  for="area2" style="color: white;">Centro de Costo / Área</label>
                                    <input class="form-control input-font hidden" type="text" status="0" id="area2" name="area2" placeholder="CENTRO DE COSTO / ÁREA">
                                     <select class="form-control input-font" status="0" name="area" id="area">
                                        <option >-</option>
                                        <option >AREA 1</option> 
                                        <option >AREA 2</option>    
                                        <option >AREA 3</option>
                                        <option >AREA 4</option>
                                    </select>
                                </div>
                                <!--
                                    <div class="col-lg-2 col-xs-7">
                                    <label  for="area2" style="color: white;">Centro de Costo / Campaña</label>
                                    <input class="form-control input-font hidden" type="text" status="0" id="area2" name="area2" placeholder="CENTRO DE COSTO / CAMPAÑA">
                                     <select class="form-control input-font" status="0" name="area" id="area">
                                        <option >-</option>
                                        <option >Airbnb</option> 
                                        <option >AT&T</option>    
                                        <option >Capital One</option>    
                                        <option >Cox</option>
                                        <option >Facilities</option>    
                                        <option >GoDaddy</option>    
                                        <option >Google</option>    
                                        <option >GTI</option>    
                                        <option >Humana</option>
                                        <option >McAfee</option>    
                                        <option >NetApp</option>    
                                        <option >Nice</option>    
                                        <option >Schlumberger</option>    
                                        <option >Spotify</option>    
                                        <option >T Mobile</option>    
                                        <option >Training</option>
                                    </select>
                                </div>
                            -->
                                
                                <div class="col-lg-2 col-xs-5">
                                    <label for="subarea" style="color: white;">Sub Área</label>
                                    <input class="form-control input-font" type="text" id="subarea" placeholder="SUB ÁREA">
                                </div>
                                <div class="col-lg-2 col-xs-6">
                                    <label for="eps" style="color: white;">EPS</label>
                                    <input class="form-control input-font" type="text" id="eps" placeholder="EPS">
                                </div>
                                <div class="col-lg-2 col-xs-6">
                                    <label class="obligatorio" for="arl" style="color: white;">ARL</label>
                                    <input class="form-control input-font" type="text" status="0" id="arl" placeholder="ARL">
                                </div>
                        	</div>
                        	<div class="row">
                        		<div class="col-lg-2">
                                    <label class="obligatorio" for="departamento" style="color: white;">Departamento</label>
                                    <select class="form-control input-font" id="departamento" status="0">
                                        <option>-</option>
                                        @foreach($departamentos as $departamento)
                                        	<option value="{{$departamento->id}}">{{$departamento->departamento}}</option>	
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label class="obligatorio" for="ciudad" style="color: white;">Ciudad / Municipio</label>
                                    <select disabled class="form-control input-font" status="0" name="ciudad" id="ciudad">
                                        <option>-</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="obligatorio" for="email" style="color: white;">Email</label>
                                    <input class="form-control input-font" type="email" status="0" id="email" placeholder="CORREO ELECTRÓNICO">
                                </div>
                                <div class="col-lg-3">
                                    <label class="obligatorio" for="email2" style="color: white;">Confirmar Email</label>
                                    <input class="form-control input-font" type="email" status="0" id="email2" placeholder="CONFIRMAR CORREO" onpaste="alert('Acción no permitida');return false">
                                </div>
                                <div class="col-lg-2">
                                    <label class="obligatorio" for="celular" style="color: white;">Celular</label>
                                    <div class="row">
                                        <div class="col-lg-5 col-xs-3"> 
                                            <select class="form-control input-font" id="indicativo">
                                                <option >-</option>
                                                <option >+ 57</option>
                                                <option >+ 1</option>
                                                <option >+ 593</option>
                                                <option >+ 56</option>
                                                <option >+ 55</option>
                                                <option >+ 591</option>
                                                <option >+ 598</option>
                                                <option >+ 54</option>
                                                <option >+ 58</option>
                                                <option >+ 51</option>
                                                <option >+ 595</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-7 col-xs-6" style="margin: 0 0 0 -20px"><input class="form-control input-font" type="number" status="0" id="celular" placeholder="CELULAR"></div>
                                    </div>
                                </div>                                
                        	</div>
                        	<div class="row">
                                <div class="col-lg-7">
                                    <label class="obligatorio" for="calle1" style="color: white;">Dirección</label>
                                    <div class="row">
                                        <div class="col-lg-2 col-xs-12" style="margin-top: 5px">
                                            <select class="form-control input-font" id="calle1" status="0">
                                                <option value="0">-</option>
                                                <option value="1">Calle</option>
                                                <option value="2">Kra</option>
                                                <option value="3">Transversal</option>
                                                <option value="4">Avenida</option>
                                                <option value="5">Vereda</option>
                                                <option value="6">Diagonal</option>                                                
                                            </select>
                                        </div>
                                        
                                        <div class="col-lg-3 col-xs-12" style="margin-top: 5px">
                                            <input class="form-control input-font" type="text" status="0" id="direccion1" placeholder="ej: 70">
                                        </div>
                                        
                                        <div class="col-lg-2 col-xs-12" style="margin-top: 5px">
                                            <select class="form-control input-font" id="calle2" status="0">
                                                <option value="0">-</option>
                                                <option value="1">Calle</option>
                                                <option value="2">Kra</option>
                                                <option value="3">Transversal</option>
                                                <option value="4">Avenida</option>
                                                <option value="5">Vereda</option>
                                                <option value="6">#</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-xs-12" style="margin-top: 5px">
                                            <input class="form-control input-font" type="text" status="0" id="direccion2" placeholder="ej: 50">
                                        </div>
                                        
                                        <div class="col-lg-3 col-xs-12" style="margin-top: 5px">
                                            <input class="form-control input-font" type="text" status="0" id="direccion3" placeholder="ej: 60">
                                        </div>                                    
                                    </div>
                                </div>
                                <div class="col-lg-2 col-xs-8">
                                    <label for="barrio" style="color: white;">Complemento</label>
                                    <input class="form-control input-font" type="text" id="complemento" placeholder="ej: piso 2">
                                </div>
                                <div class="col-lg-3 col-xs-12">
                                    <label class="obligatorio" for="barrio" style="color: white;">Mi Dirección</label>
                                    <input disabled class="form-control input-font" type="text" id="direccion_digitada" placeholder="Aquí se verá como quedará tu dirección">
                                </div>
                        	</div>
                            <div class="row">
                                <div class="col-lg-2 col-xs-12">
                                    <label class="obligatorio" for="barrio" style="color: white;">Barrio</label>
                                    <input class="form-control input-font" type="text" status="0" id="barrio" placeholder="BARRIO">
                                </div>
                                <div class="col-lg-3 col-xs-12 localidad">                                                                         
                                    <label class="obligatorio" for="localidad" style="color: white;">Localidad</label>
                                    <select class="form-control input-font" status="0" id="localidad">
                                        <option >-</option>
                                        <option >Usaquen</option>
                                        <option >Chapinero</option>
                                        <option >Santa fe</option>
                                        <option >San Cristobal</option>
                                        <option >Usme</option>
                                        <option >Tunjuelito</option>
                                        <option >Bosa</option>
                                        <option >Kennedy</option>
                                        <option >Fontibon</option>
                                        <option >Engativa</option>
                                        <option >Suba</option>
                                        <option >Barrios Unidos</option>
                                        <option >Teusaquillo</option>
                                        <option >Los Martires</option>
                                        <option >Antonio Narino</option>
                                        <option >Puente Aranda</option>
                                        <option >La Candelaria</option>
                                        <option >Soacha</option>
                                        <option >Rafael Uribe Uribe</option>
                                        <option >Ciudad Bolivar</option>
                                        <option >Sumapaz</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <a style="margin-bottom: 2px" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal2">
                                        Ver las políticas<i class="fa fa-eye icon-btn"></i></a>
                                    </div>
                                </div>
                                
                                <label style="margin-right: 5px; display: inline; color: white; font-size: 17px">Acepto las políticas de privacidad y tratamiento de datos, y autorizo a que me puedan contactar a mi correo electrónico por motivo de actualización de dichas políticas.</label>
                                <input type="checkbox" name="aceptar_politicas" status="0" class="politics" style="vertical-align: sub;">
                                @if ($errors->has('aceptar_politicas'))
                                    <br><small class="text-danger">{{$errors->first('aceptar_politicas')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-lg-2 col-xs-12 col-lg-offset-10">
                            <button style="border: 1px solid orange;" id="guardarp" type="button" class="but" class="confirmar">Registrarme <i class="fa fa-sign-in" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 8px">
                        <div class="col-lg-12 col-xs-12">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">
                                    <span status="0" id="actual">10%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
        </form>

    </div>

    <div class="section" id="mensajes">
        
    </div>

    
    <!-- Modal -->
    <div class="modal fade mymodal2 bd-example-modal-md" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #DC4405">
                    <div class="row">
                        <div class="col-lg-11">
                            <h5 class="modal-title" id="exampleModalLabel">POLÍTICA DE TRATAMIENTO DE DATOS Ley 1581 de 2012</h5>
                        </div>
                        <div class="col-lg-1">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>                    
                </div>
                <div class="modal-body">
                @include('portalusuarios.politicasdatos')
                </div>            
            </div>
        </div>
    </div>


    <div class="modal fade mymodal22" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="margin: 40px;">      
        <div class="modal-content">
            <div class="modal-header" style="background-color: #DC4405">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <center> <strong>POLÍTICA DE TRATAMIENTO DE DATOS Ley 1581 de 2012</strong></center>
            </div>
            
        </div>
    </div>          
          
          
    
    <div class="errores-modal bg-danger text-danger hidden model" style="background: orange; color: black">
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

    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/pasajeros.js')}}"></script>
	
</body>	
</html>