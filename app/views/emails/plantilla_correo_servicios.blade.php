<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width"/>
</head>
<body>
<p>Buenos dias.<br>
   De acuerdo a su amable solicitud le confirmo la coordinación de sus traslados, ante cualquier inquietud por favor  no dude en contactarnos.
</p>

<div style="
    border: 1px solid #CA5E1A;
    padding: 20px;
    text-align: center;
    background: #F47321;
    color: white;
    font-weight: 700;
    font-size: 14px;
    font-style: oblique;
    letter-spacing: 2px;
    margin-bottom: 0px !important;
    ">SOLICITUD DE TRASLADO / TRANSFER REQUEST ({{$empresa.' / '.$subcentrocosto}})</div>

<div style="
    border-left: 1px solid gray;
    border-right: 1px solid gray;
    border-top: 0;
    border-bottom: 0;
    padding: 10px;
    text-align: left;
    background: #e8e8e8;
    color: gray;
    font-weight: 700;
    font-size: 14px;
    font-style: oblique;
    letter-spacing: 2px;
    margin-top: 0px;
    margin-bottom: 0px;
    ">DATOS DEL TRASLADO / DATA TRANSFER</div>
<table style="border-collapse: collapse;">
<thead>
<tr>
    <th rowspan="2" style="border: 1px solid gray; padding: 10px;">PAX</th>
    <th style="border: 1px solid gray; padding: 10px;">FECHA SOLICITUD TRASLADO / TRANSFER REQUEST DATE</th>
    <th style="border: 1px solid gray; padding: 10px;">NUMERO TELEFONO PAX / TELEPHONE NUMBER PAX</th>
    <th style="border: 1px solid gray; padding: 10px;">GESTIONADO POR / MANAGED BY</th>
</tr>
</thead>
    <tbody>

        <tr>
            <td style="border: 1px solid gray;padding: 10px;width: 31%;">@for ($j = 0; $j < count($pax); $j++) {{$pax[$j]}} @endfor</td>
            <td style="border: 1px solid gray; padding: 10px;width: 11%;">{{$fecha_solicitud}}</td>
            <td style="border: 1px solid gray; padding: 10px;width: 19%;">@for ($j = 0; $j < count($pax); $j++) {{$pax_tel[$j]}} @endfor</td>
            <td style="border: 1px solid gray; padding: 10px;width: 19%">{{$gestionado_por}}</td>
        </tr>

    </tbody>

</table>

<div style="
    border-left: 1px solid gray;
    border-right: 1px solid gray;
    border-top: 0;
    border-bottom: 0;
    padding: 10px;
    text-align: left;
    background: #e8e8e8;
    color: gray;
    font-weight: 700;
    font-size: 14px;
    font-style: oblique;
    letter-spacing: 2px;
    margin-top: 0px;
    margin-bottom: 0px;
    ">DETALLE SOLICITUD DE TRASLADOS / TRANSFER DETAILS</div>
<table style="border-collapse: collapse;">
    <thead>
    <tr>
        <th rowspan="2" style="border: 1px solid gray; padding: 10px;">FECHA DEL TRASLADO / DATE OF TRANSFER</th>
        <th style="border: 1px solid gray; padding: 10px;">HORA DEL TRASLADO / TIME OF TRANSFER</th>
        <th style="border: 1px solid gray; padding: 10px;">RECOGER EN / PICKUP</th>
        <th style="border: 1px solid gray; padding: 10px;">LLEVAR A / CARRY</th>
        <th style="border: 1px solid gray; padding: 10px;">CONDUCTOR & VEHICULO / DRIVER & VEHICLE</th>
        <th style="border: 1px solid gray; padding: 10px;">OBSERVACIONES / COMMENTS</th>
    </tr>
    </thead>
    <tbody>
    @for ($i = 0; $i < count($ruta); $i++)
        <tr>
            <td style="border: 1px solid gray;padding: 10px;width: 12%;">{{$fecha_servicio[$i]}}</td>
            <td style="border: 1px solid gray; padding: 10px;width: 11%;">{{$hora_inicio[$i]}}</td>
            <td style="border: 1px solid gray; padding: 10px;width: 20%;">{{$recoger_en[$i]}}</td>
            <td style="border: 1px solid gray; padding: 10px;width: 20%">{{$dejar_en[$i]}}</td>
            <td style="border: 1px solid gray; padding: 10px;">{{$nombres_conductor[$i].'<br>'.$vehiculos_datos[$i]}}</td>
            <td style="border: 1px solid gray; padding: 10px;">{{$detalle[$i]}}</td>
        </tr>
    @endfor
    </tbody>
</table>
</body>
</html>

