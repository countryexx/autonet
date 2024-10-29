<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="{{url('bootstrap/css/custom.css')}}" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    <br>
    <br>
    <br>
    <tr>
      <td></td>
      <td></td>
      <td valign="middle" align="center">LIQUIDACION DE SERVICIO</td>
      <td valign="middle" align="center">EMISION: {{date('Y-m-d')}}</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td valign="middle" align="center">GESTION FINANCIERA</td>
    </tr>
    <br>
    <table class="excel">
      <thead>
        <tr>
          <th style="color: white" width="7" valign="middle" align="center">No</th>
          <th width="12" valign="middle" align="center">FECHA DE SERVICIO</th>
          <th width="12" valign="middle" align="center">HORA DE SERVICIO</th>
          <th width="12" valign="middle" align="center">SOLICITADO POR</th>
          <th width="16" valign="middle" align="center">CANTIDAD</th>
          <th width="17" valign="middle" align="center">No. CONSTANCIA</th>
          <th width="16" valign="middle" align="center">NOMBRE PASAJERO</th>
          <th width="16" valign="middle" align="center">PROVEEDOR</th>
          <th width="16" valign="middle" align="center">RECOGER EN</th>
          <th width="16" valign="middle" align="center">DEJAR EN</th>
          <th width="16" valign="middle" align="center">CLIENTE</th>
          <th width="16" valign="middle" align="center">COD CENTRO COSTO</th>
          <th width="16" valign="middle" align="center">OBSERVACION</th>
          <th width="16" valign="middle" align="center">UNITARIO COBRADO</th>
          <th width="16" valign="middle" align="center">UNITARIO PAGADO</th>
          <!--<th width="16" valign="middle" align="center">UTILIDAD</th>
          <th width="16" valign="middle" align="center">%RENTABILIDAD</th> -->

        </tr>
      </thead>
      <tbody>
        <?php
          $k = 1;
          $total = 0;
          $total2 = 0;
          $a=0;
          $sum = 0;
         ?>
        @foreach($servicios as $servicio)

          <?php 

          ?>

          <tr>
            <td valign="middle" align="center">{{$k++}}</td>
            <td valign="middle" align="center">{{$servicio->fecha_servicio}}</td>
            <td valign="middle" align="center">{{$servicio->hora_servicio}}</td>
            <td valign="middle" align="center">{{$servicio->solicitado_por}}</td>
            <td valign="middle" align="center">{{$servicio->cantidad}}</td>
            <td valign="middle" align="center">{{$servicio->numero_planilla}}</td>
            <td valign="middle" align="center">

              <?php 

              $pasajeros = DB::table('qr_rutas')
              ->where('servicio_id',$servicio->id)
              ->get();

              $direcciones = '';

              if($pasajeros!=null){

                foreach ($pasajeros as $pass) {
                  if($direcciones===''){
                    $direcciones = $pass->fullname;
                  }else{
                    $direcciones = $direcciones.' | '.$pass->fullname;
                  }
                }

                echo $direcciones; 

              }else{
                
                $pax = explode('/',$servicio->pasajeros);

                for ($i=0; $i < count($pax); $i++) {
                    $pasajeros[$i] = explode(',', $pax[$i]);
                }

                for ($i=0; $i < count($pax)-1; $i++) {

                    for ($j=0; $j < count($pasajeros[$i]); $j++) {

                        if ($j===0) {
                            $nombre = $pasajeros[$i][$j].'<br>';
                        }

                    }
                    echo $nombre;

                }

              }
              
              //echo $direcciones; 

              ?>

              <?php

                /*if($servicio->ruta==1){

                  $pasajeros = DB::table('qr_rutas')
                  ->where('servicio_id',$servicio->id)
                  ->get();

                  $pass = '';

                  if($pasajeros!=null){

                    foreach ($pasajeros as $pass) {
                      
                      if($pass===''){

                        if($pass->fullname!=null and $pass->fullname!=''){
                          $pass = $pass->fullname;
                        }else{
                          $pass = '';
                        }
                        
                      }else{

                        if($pass->fullname!=null and $pass->fullname!=''){
                          $pass = $pass.' | '.$pass->fullname;
                        }else{
                          $pass = '';
                        }
                        
                      }
                      
                    }

                  }
                  
                  echo $pass; 

                }else{

                  $pax = explode('/',$servicio->pasajeros);

                  for ($i=0; $i < count($pax); $i++) {
                      $pasajeros[$i] = explode(',', $pax[$i]);
                  }

                  for ($i=0; $i < count($pax)-1; $i++) {

                      for ($j=0; $j < count($pasajeros[$i]); $j++) {

                          if ($j===0) {
                              $nombre = $pasajeros[$i][$j].'<br>';
                          }

                      }
                      echo $nombre;

                  }

                }*/

                

              ?>

            </td>
            <td valign="middle" align="center">{{$servicio->prazonproveedor}}</td>
            <!--servicio->prazonproveedor -->
            <!--<td valign="middle" align="center"></td> -->
            <td valign="middle" align="center">
              <?php 

              if($servicio->dejar_en=='OPTUM'){
                
                $pasajeros = DB::table('qr_rutas')
                ->where('servicio_id',$servicio->id)
                ->get();

                $direcciones = '';

                if($pasajeros!=null){

                  foreach ($pasajeros as $pass) {
                    if($direcciones===''){
                      $direcciones = $pass->address;
                    }else{
                      $direcciones = $direcciones.' | '.$pass->address;
                    }
                  }

                }else{
                  $direcciones = $servicio->recoger_en;
                }

              }else{

                $direcciones = $servicio->recoger_en;

              }
              
              echo $direcciones; 

              ?>

            </td>
            <td valign="middle" align="center">
              <?php 

              if($servicio->dejar_en=='OPTUM'){
                $direcciones = $servicio->dejar_en;
              }else{

                $pasajeros = DB::table('qr_rutas')
                ->where('servicio_id',$servicio->id)
                ->get();

                $direcciones = '';

                if($pasajeros!=null){

                  foreach ($pasajeros as $pass) {
                    if($direcciones===''){
                      $direcciones = $pass->address;
                    }else{
                      $direcciones = $direcciones.' | '.$pass->address;
                    }
                  }

                }else{
                  $direcciones = $servicio->dejar_en;
                }

              }
              
              echo $direcciones; 

              ?>
            </td>

            <td valign="middle" align="center">
              @if($servicio->razonsocial===$servicio->nombresubcentro)
                {{$servicio->razonsocial}}
              @elseif($servicio->razonsocial!=$servicio->nombresubcentro)
                {{$servicio->razonsocial.'/'.$servicio->nombresubcentro}}
              @endif
            </td>

            <td valign="middle" align="center">
              {{$servicio->cod_centro_costo}}
            </td>

            <td valign="middle" align="center">
              {{$servicio->observacion}}
            </td>

            <td valign="middle" align="center">
              {{$servicio->total_cobrado}}
            </td>
            
            <td valign="middle" align="center">
              {{$servicio->total_pagado}}
            </td>
            <!--<td valign="middle" align="center">
                {{$servicio->utilidad}}
            </td>
            <td valign="middle" align="center">%  @if($servicio->total_cobrado !=0){{round($servicio->utilidad/$servicio->total_cobrado,3)*100}} @endif</td> -->
          </tr>

          <?php
            $total = $total+$servicio->total_cobrado;
            $total2 = $total2+$servicio->total_pagado;

            $a++;
            if($servicio->total_cobrado != 0){
              $sum = $sum + ($servicio->utilidad/$servicio->total_cobrado)*100;
            }else{
                $sum = 0;
            }
          ?>
        @endforeach

      </tbody>
    </table>

      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td class="border-table color-table" valign="middle" align="center">
        TOTAL COBRADO
      </td>
      <td class="border-table color-table" valign="middle" align="center">$ {{number_format($total)}}</td>
      <td valign="middle" align="center"></td>
      <!-- <td class="border-table color-table" valign="middle" align="center">
        TOTAL PAGADO
      </td>
      <td class="border-table color-table" valign="middle" align="center">$ {{number_format($total2)}}</td>
      <td valign="middle" align="center"></td>
      <td valign="middle" align="center"></td>
      <td valign="middle" align="center"></td>
      <td valign="middle" align="center"></td>
      <td valign="middle" align="center"></td>
      <td class="border-table color-table" valign="middle" align="center">PROMEDIO DE RENTABILIDAD</td>
      <td valign="middle" align="center">{{round($sum/$a,2)}}</td>
      -->
  </body>
</html>
