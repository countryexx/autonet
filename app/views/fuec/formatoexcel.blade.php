<!DOCTYPE html>
<html>
  <head>
    <meta name="name" content="content" charset="utf-8">
    <title></title>
  </head>
  <body>
    <tr>
      <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
      <td style="text-align: center" align="center">FORMATO ÚNICO DE EXTRACTO DEL CONTRATO DEL SERVICIO PÚBLICO DE TRANSPORTE TERRESTRE DEL AUTOMOTOR ESPECIAL - No, 208,0013,00,{{$fuec->ano}},{{$fuec->numero_contrato}},{{$fuec->consecutivo}}</td>
    </tr>
    <tr><td></td></tr>
    <tr>
      <td>RAZÓN SOCIAL: AUTO OCASIONAL TOUR LTDA. NIT: 819,003,684-2</td>
    </tr>
    <tr><td>CONTRATO No: {{$fuec->numero_contrato}}</td></tr>
    <tr>
      <td>CONTRATANTE: {{$fuec->contratante}} NIT: {{$fuec->nit_contratante}}</td>
    </tr>
    <tr>
      <td>OBJETO CONTRATO: @if($fuec->objeto_contrato==='TRANSPORTE TERRESTRE ESCOLAR'){{$fuec->objeto_contrato.' DEL '.$fuec->colegio}} @else {{$fuec->objeto_contrato}} @endif</td>
    </tr>
    <tr><td></td></tr>
    <tr><td>ORIGEN: {{$fuec->origen}}</td></tr>
    <tr><td>DESTINO: {{$fuec->destino}}</td></tr>
    <tr>
      <td style="text-align: left" align="left">{{$fuec->descripcion_ruta}}</td>
    </tr>
    <tr><td></td></tr>
    <tr><td>CONVENIO ___ CONSORCIO ___ UNIÓN TEMPORAL ___ CON: @if($fuec->empresa_afiliada==='AOTOUR'){{$fuec->contratante}}@else{{$fuec->empresa_afiliada}}@endif</td></tr>
    <tr><td style="text-align: center" align="center">VIGENCIA DEL CONTRATO</td></tr>
    <tr>
      <?php
        $fecha_in = explode('-',$fuec->fecha_inicial);
        $fecha_fn = explode('-',$fuec->fecha_final);
      ?>
      <td>FECHA INICIAL</td>
      <td></td>
      <td></td>
      <td>DIA: {{$fecha_in[2]}}</td>
      <td>MES: {{$fecha_in[1]}}</td>
      <td>AÑO: {{$fecha_in[0]}}</td>
    </tr>
    <tr>

      <td>FECHA FINAL</td>
      <td></td>
      <td></td>
      <td>DIA: {{$fecha_fn[2]}}</td>
      <td>MES: {{$fecha_fn[1]}}</td>
      <td>AÑO: {{$fecha_fn[0]}}</td>
    </tr>
      <tr><td style="text-align: center" align="center">CARACTERÍSTICAS DEL VEHÍCULO</td></tr>
      <tr>
        <td style="text-align: center" align="center">PLACA</td>
        <td style="text-align: center" align="center">MODELO</td>
        <td></td>
        <td style="text-align: center" align="center">MARCA</td>
        <td style="text-align: center" align="center">CLASE</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td style="text-align: center" align="center">{{$fuec->placa}}</td>
        <td style="text-align: center" align="center">{{$fuec->vehiculo_ano}}</td>
        <td></td>
        <td style="text-align: center" align="center">{{$fuec->marca}}</td>
        <td style="text-align: center" align="center">{{$fuec->clase}}</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td style="text-align: center" align="center">NUMERO INTERNO</td>
        <td></td>
        <td></td>
        <td style="text-align: center" align="center">NUMERO TARJETA DE OPERACION</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td style="text-align: center" align="center">{{$fuec->numero_interno}}</td>
        <td></td>
        <td></td>
        <td style="text-align: center" align="center">{{$fuec->tarjeta_operacion}}</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <?php
        $arrayidc = explode(',',$fuec->conductor);
        $conductor = DB::table('conductores')->whereIn('id', $arrayidc)->get();
      ?>
      @foreach($conductor as $con)
        <tr>
          <td rowspan="2" style="text-align: center" align="center">DATOS DEL CONDUCTOR</td>
          <td colspan="2" style="text-align: center" align="center">NOMBRES Y APELLIDOS</td>
          <td style="text-align: center" align="center">No. CEDULA</td>
          <td style="text-align: center" align="center">No. LICENCIA CONDUCCION</td>
          <td colspan="2" style="text-align: center" align="center">VIGENCIA</td>
        </tr>
        <tr>
          <td style="text-align: center" align="center"></td>
          <td colspan="2" style="text-align: center" align="center">{{$con->nombre_completo}}</td>
          <td style="text-align: center" align="center">{{$con->cc}}</td>
          <td style="text-align: center" align="center">{{$con->cc}}</td>
          <td colspan="2" style="text-align: center" align="center">{{$con->fecha_licencia_vigencia}}</td>
        </tr>
      @endforeach
      <tr>
        <td rowspan="2" style="text-align: center" align="center">RESPONSABLE DEL CONTRATANTE</td>
        <td colspan="2" style="text-align: center" align="center">NOMBRES Y APELLIDOS</td>
        <td style="text-align: center" align="center">No. CEDULA</td>
        <td style="text-align: center" align="center">TELEFONO</td>
        <td colspan="2" style="text-align: center" align="center">DIRECCION</td>
      </tr>
      <tr>
        <?php

        if (intval($fuec->cliente)===2 or $fuec->cliente===null) {
          $razonsocial = $fuec->representante_legal;
          $nit = $fuec->cc_representante;
          $telefono = $fuec->telefono_representante;
          $direccion = $fuec->direccion_representante;
        }else {
          $razonsocial = 'AUTO OCASIONAL TOUR';
          $nit = '819,003,684';
          $telefono = '3582555-3582003';
          $direccion = 'CRA 53 No. 68B-87';
        }

        ?>
        <td valign="center" style="text-align: center" align="center"></td>
        <td colspan="2" valign="center" style="text-align: center" align="center">{{$razonsocial}}</td>
        <td valign="center" style="text-align: center" align="center">{{$nit}}</td>
        <td valign="center" style="text-align: center" align="center">{{$telefono}}</td>
        <td colspan="2" valign="center" style="text-align: center" align="center">{{$direccion}}</td>
      </tr>
      <tr>
        <td></td>
      </tr>
      <tr>
        <td>Cra. 53 N° 68B - 87 Ofic 1-138 C.C. Gran Centro Barranquilla - Colombia</td>
      </tr>
      <tr>
        <td>(57) (5) 358 2555 - 358 2003</td>
      </tr>
      <tr>
        <td>Línea Nacional: 018000 510 400</td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3" valign="center" style="text-align: center" align="center">_______________________________________</td>
      </tr>
      <tr>
        <td>servicios@aotour.com.co</td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3" valign="center" style="text-align: center" align="center">FIRMA Y SELLO GERENTE CONTRATO</td>
      </tr>

  </body>
</html>
