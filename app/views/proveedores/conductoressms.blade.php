<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | SMS Conductores</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="manifest" href="{{url('manifest.json')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">       
</head>

<body>
@include('admin.menu')
<div class="container-fluid">
    <h1 class="h_titulo"><b>Mensajes a conductores</b></h1>
    <div class="row">                
        <div class="col-md-6">
            <form id="formulario">
                <textarea style="width: 100%; height:25%" placeholder="Escribe aquí el mensaje..." name="message" id="sms"  onkeyup="countChars(this);"></textarea>
                <p style="float:right;" id="charNum">0 Caracteres</p>            
                <input type="text" class="hidden" name="valores" id="valores">
            </form>
            <div class="row" style="margin-top: 25px">
                <div class="col-md-3">
                    <button type="submit" id="enviarsms" style="color: black" class="btn btn-primary btn-icon input-font">Enviar a Todos<i class="fa fa-share-square icon-btn" aria-hidden="true"></i></button>
                </div>
                <div class="col-md-3">
                    <button id="enviarsmsp" style="color: black" class="btn btn-primary btn-icon input-font">Elegir conductores<i class="fa fa-share-square icon-btn" aria-hidden="true"></i></button>
                </div>
                <div class="col-md-3">
                    <button type="submit" id="enviarsmsp2" style="color: black" class="btn btn-primary btn-icon input-font hidden">Enviar a Conductores seleccionados<i class="fa fa-share-square icon-btn" aria-hidden="true"></i></button>
                </div>                                                
            </div>
            
        </div>
        <div class="col-md-6 hidden" id="divtable">  
            <form onsubmit="return is_checked()">
                  <table id="tableDriver" class="display">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>NOMBRE COMPLETO</th>
                        <th>CELULAR</th>
                        <th>CIUDAD</th>
                        <th>ENVIAR / NO ENVIAR</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; $sw = 1; ?>
                         @foreach($conductores as $conductor)
                            <tr>                        
                                <td>{{$i}}</td> 
                                <td>{{$conductor->nombre_completo}}</td> 
                                <td>{{$conductor->celular}}</td>
                                <td>{{$conductor->ciudad}}</td>
                                <td><input type="checkbox" value="{{$conductor->id}}" id="{{$conductor->id}}"></td>
                            </tr> 
                            <?php $i++?>           
                        @endforeach
                    </tbody>
                  </table>
            </form>            
            <button type="submit" onclick="return is_checked()" style="background: gray; color: black; margin: 0 0 25px 0;" class="btn btn-primary btn-icon">Listo, ya seleccioné los conductores!<i class="fa fa-check icon-btn" aria-hidden="true"></i></button>            

        </div>
    </div> 
    <div class="section" id="mensajes">

    </div> 
    <div class="errores-modal bg-danger text-danger hidden model" style="background: #FF1700; color: white">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    </ul>
</div>    
</div>

    <?php $i = 1;  $array = [];?>
    @foreach($conductores as $conductor)
      <?php
      $array[$i] = $conductor->nombre_completo;
      $array2[$i] = $conductor->id;
      $i++;
      ?>
    @endforeach
    <script type="text/javascript">        
        function is_checked(){
            var arrayid=<?php echo json_encode($array);?>;
            var arrayid2=<?php echo json_encode($array2);?>;
            var cont = <?php echo $i-1; ?>;
            var sw = 0;
            var conductores = [];
            var valores = [];
            for (var i = 1; i <= cont ; i++) {                                
                var value = arrayid2[i];
                value = document.getElementById(arrayid2[i]).checked;
                //alert(value);
                if(value==true){
                    valores.push(arrayid2[i]);
                }
                conductores.push(value);
            }  
            if(valores==''){
                alert('No has selecionado ningún conductor')
                document.getElementById('valores').value = '';
                if(!($('#enviarsmsp2').hasClass('hidden'))){
                    $('#enviarsmsp2').addClass('hidden');
                }
            }else{                
                alert('Conductores seleccionados')
                //alert(valores);
                document.getElementById('valores').value = valores;
                $('#enviarsmsp2').removeClass('hidden');
            }            
        }
    </script>
    
    <script>
    
    function countChars(obj){
        var maxLength = 160;
        var strLength = obj.value.length;        
        if(strLength > maxLength){
            document.getElementById("charNum").innerHTML = '<span style="float:right; color: red;">'+strLength+' de '+maxLength+' Caracteres</span>';
        }else{
            document.getElementById("charNum").innerHTML = '<span style="float:right; color: green;">'+strLength+' de '+maxLength+' Caracteres</span>';
        }
    }
    </script>

    @include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="{{url('jquery/conductores.js')}}"></script>
    <script type="text/javascript">    
</script>
</body>