<!DOCTYPE html>
<html>
<head>
     <title></title>
</head>
<body>
<?php
/*
     $claveapi = "74d0efd53680";
$Destino = 3053745124; 
$Mensaje = "AOTOUR le informa sr(a) samuel gonzalez que tiene la ruta a1' en la ciudad de barranquilla programada para el día 24 a las 22 de la empresa aotour de la sede cc gran centro, el vehiculo asignado es el de placas uuw126.";

$usuario = 17; //CODIGO DE USUARIO
// Escoja el tipo a enviar dato
$Tipo = "SMS";
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, 'https://conectbox.com/index.php/APIsms/api/EnviarSms'); 
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'claveapi='.$claveapi.'&d='.$Destino.'&m='.$Mensaje.'&t='.$Tipo.'&usuario='.$usuario);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
$output = curl_exec($ch); 
curl_close($ch);
//prueba*/
?>
<input type="button" class="btn bg-orange btn-block btn-lg waves-effect" value="Enviar Mensaje" onclick="enviarsms();" >
<script src="https://conectbox.com/plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
	
function enviarsms(){
    var numero ="3053745124";
    var texto ="AOTOUR le informa sr(a) samuel gonzalez que tiene la ruta a1' en la ciudad de barranquilla programada para el día 24 a las 22 de la empresa aotour de la sede cc gran centro, el vehiculo asignado es el de placas uuw126.";
    var usuario =17;
    var claveapi = "74d0efd53680";
    if (numero.length == 10){
        if (texto.length > 1){
            $.ajax({
                       method: "POST",
                   url: "https://conectbox.com/index.php/APIsms/api/EnviarSms",
                        data: {
                            claveapi: claveapi,
                            d: numero,
                            m: texto,
                            t:'SMS',
                            usuario: usuario
          
                     },      contentType: "application/x-www-form-urlencoded",
                            success: function (data) {
                              console.log(data);
                             var usuario = data.Estado;
                             alert(usuario);
                          
                      }, error: function (data) {

                  alert("Error Al Enviar Mensaje");
                  }
                });
        }else {
            alert("No hay Texto Para enviar Mensaje");
        }
    }else {
            alert ("Numero No Valido Para Envio De SMS");
    }

}



</script>



</body>
</html>

