<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Políticas de Datos</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>
<body>
@include('admin.menu')

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <h3 class="h_titulo">Descargar Política de Datos </h3>          
        
      <div class="container-fluid">        
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="panel panel-default">
                  <div class="panel-heading" style="font-size: 20px">Política de Tratamiento de Datos</div>
                  <div class="panel-body">                                               

                          <p style="font-size: 14px; font-family: Arial"> En atención a las disposiciones de Ley 1581 de 2012, el Decreto Reglamentario 1377 de 2013, la Circular Externa 002 de 2015 expedida por la Superintendencia de Industria y Comercio, la política interna de manejo de la información implementada por AUTO OCASIONAL S.A.S. “AOTOUR” cuyo procedimiento estará a cargo de la oficina Gestión Integral, coadyuvada por la dependencia de Jurídica y de Seguridad Vial, y las demás normas concordantes, a través de las  cuales se establecen disposiciones generales en materia de hábeas data y se regula el tratamiento de la información que contenga datos personales, me permito declarar de manera expresa que:</p>


                          <ul>
                            <li style="text-align: justify; font-size: 14px">Autorizo de manera libre, voluntaria, previa, explícita, informada e inequívoca al AUTO OCASIONAL S.A.S. “AOTOUR”, para que en los términos legalmente establecidos realice la recolección, almacenamiento, uso, circulación, supresión y en general, el tratamiento de los datos personales que he procedido a entregar o que entregaré, en virtud de las relaciones legales, contractuales, comerciales y/o de cualquier otra que surja, en desarrollo y ejecución de los fines descritos en el presente documento.</li>
                            <li style="text-align: justify; font-size: 14px">Dicha autorización para adelantar el tratamiento de mis datos personales, se extiende durante la totalidad del tiempo en el que pueda llegar consolidarse un vínculo en cualquiera que sea la calidad o forma de vinculación o este persista por cualquier circunstancia con el AUTO OCASIONAL S.A.S. “AOTOUR” SA y con posterioridad al finiquito del mismo, siempre que tal tratamiento se encuentre relacionado con las finalidades para las cuales los datos personales, fueron inicialmente suministrados.</li>
                            <li style="text-align: justify; font-size: 14px">En consecuencia de lo anterior, declaro que la información obtenida para el Tratamiento de mis datos personales la he suministrado de forma voluntaria y es verídica, a fin de conocer que los datos personales objeto de tratamiento, serán utilizados específicamente para las finalidades derivadas de la ejecución de las actividades propias de la razón social de esta entidad, en el sentido de:
                            <ul>
                              <li style="text-align: justify; font-size: 14px">a) Que se realicen las consultas necesarias en diferentes listas restrictivas.</li>
                              <li style="text-align: justify; font-size: 14px">b) Todas las actuaciones administrativas que se requieran para garantizar la participación del postulante, así como la eventual ejecución de las actividades derivadas de la selección de mi postulación.</li>
                            </ul>
                            </li>
                            <li style="text-align: justify; font-size: 14px">Der igual forma, declaro que me han sido informados y conozco los derechos que el ordenamiento legal y la jurisprudencia, conceden al titular de los datos personales y que incluyen entre otras prerrogativas las que a continuación se relacionan: (i) Conocer, actualizar y rectificar datos personales frente a los responsables o encargados del tratamiento. Este derecho se podrá ejercer, entre otros frente a datos parciales, inexactos, incompletos, fraccionados, que induzcan a error, o aquellos cuyo tratamiento esté expresamente prohibido o no haya sido autorizado; (ii) solicitar prueba de la autorización otorgada al responsable del tratamiento salvo cuando expresamente se exceptúe como requisito para el tratamiento; (iii) ser informado por el responsable del tratamiento o el encargado del tratamiento, previa solicitud, respecto del uso que le ha dado a mis datos personales; (iv) presentar ante la Superintendencia de Industria y Comercio quejas por infracciones al régimen de protección de datos personales; (v) revocar la autorización y/o solicitar la supresión del dato personal cuando en el tratamiento no se respeten los principios, derechos y garantías constitucionales y legales, (vi) acceder en forma gratuita a mis datos personales que hayan sido objeto de Tratamiento. </li>
                            <li style="text-align: justify; font-size: 14px">La política de manejo de datos personales adoptada por AUTO OCASIONAL S.A.S. “AOTOUR”, se encuentran en la página web http://aotour.com.co/

                          Finalmente, manifiesto conocer que en los casos en que requiera ejercer los derechos anteriormente mencionados, la solicitud respectiva podrá ser elevada a través de los mecanismos dispuestos para tal fin por el AUTO OCASIONAL S.A.S. “AOTOUR”, que corresponden a los siguientes:
                          <ul>
                            <li style="text-align: justify; font-size: 14px">i)  Página Web http://aotour.com.co/</li>
                            <li style="text-align: justify; font-size: 14px">ii)  Teléfono: (5) 3582555</li>
                            <li style="text-align: justify; font-size: 14px">iii) Correo electrónico: servicios@aotour.com.co</li>
                            <li style="text-align: justify; font-size: 14px">iv) Correspondencia Cra 53 No. 68B – 87 C.C. Gran Centro Oficina 1-138.</li>
                            <li style="text-align: justify; font-size: 14px">v)  Presencial: Cra 53 No. 68B – 87 C.C. Gran Centro Oficina 1-138</li>
                          </ul>
                          </li>
                           
                          </ul><br>
                          <form id="form" action="{{url('descargarpoliticas')}}" method="get">
                            <button style="float: right;" class="btn btn-success">DESCARGAR EN FORMATO PDF <span><i class="fa fa-download" aria-hidden="true"></i></span></button> 
                          </form>  
                  </div>
              </div>
              </div>                
        </div>                          
      </div>
      
    </div>
  </div>
</div>


@include('scripts.scripts')
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

