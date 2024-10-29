<html>
<head>
    <meta charset="UTF-8">
	<title>Autonet | Revisión Cuenta de Cobro</title>
    @include('scripts.styles')
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <style>

        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap');
        body{
            background: #EEEEEE;
            font-family: 'arial', sans-serif;
        }
        .card{
            width: 300px;
            border: none;
            border-radius: 15px;
        }
        .adiv{
            background: #04CB28;
            border-radius: 15px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            font-size: 12px;
            height: 46px;
        }
        .chat{
            border: none;
            background: #E2FFE8;
            font-size: 10px;
            border-radius: 20px;
        }
        .bg-white{
            border: 1px solid #E7E7E9;
            font-size: 10px;
            border-radius: 20px;
        }
        .myvideo img{
            border-radius: 20px
        }
        .dot{
            font-weight: bold;
        }
        .form-control{
            border-radius: 12px;
            border: 1px solid #F0F0F0;
            font-size: 8px;
        }
        .form-control:focus{
            box-shadow: none;
            }
        .form-control::placeholder{
            font-size: 8px;
            color: #C4C4C4;
        }

      #map{
        height: 80%;
        width: 100%;
        z-index: 1;
      }

      .pac-container {
        z-index: 100000;
      }

      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

      .bootstrap-select>.dropdown-toggle{
        padding: 8px;
      }

      .proveedor, [data-id="proveedor"]{
        z-index: 10 !important;
      }

      .alert-minimalist {
      	background-color: rgb(255, 255, 255);
      	border-color: rgba(149, 149, 149, 0.3);
      	border-radius: 3px;
      	color: rgb(149, 149, 149);
      	padding: 10px;
      }

      .alert-minimalist > [data-notify="icon"] {
      	height: 50px;
      	margin-right: 12px;
      }

      .alert-minimalist > [data-notify="title"] {
      	color: rgb(51, 51, 51);
      	display: block;
      	font-weight: bold;
      	margin-bottom: 5px;
      }

      .alert-minimalist > [data-notify="message"] {
        font-size: 13px;
        font-weight: 400;
      }

      .last_value{
          text-align: center;
          font-family: Bahnschrift;
          font-size: 13px
      }
      .usuario1{
          float: left;
      }

      .usuario2{
          float: right;
      }

      .app-container {
      border-radius: 4px;
      width: 100%;
      height: 100%;
      max-height: 100%;
      max-width: 1280px;
      display: flex;
      overflow: hidden;
      box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
      max-width: 2000px;
      margin: 0 auto;
      }

      .sidebar {
      flex-basis: 200px;
      max-width: 200px;
      flex-shrink: 0;
      background-color: white;
      display: flex;
      flex-direction: column;

      &-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px;
      }

      &-list {
        list-style-type: none;
        padding: 0;

        &-item {
          position: relative;
          margin-bottom: 4px;

          a {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 10px 16px;
            color: var(--sidebar-link);
            text-decoration: none;
            font-size: $font-small;
            line-height: 24px;
          }

          svg { margin-right: 8px; }

          &:hover { background-color: var(--sidebar-hover-link); }

          &.active {
            background-color: var(--sidebar-active-link);

            &:before {
              content: '';
              position: absolute;
              right: 0;
              background-color: var(--action-color);
              height: 100%;
              width: 4px;
            }
          }

          &.inactive {
            background-color: var(--sidebar-active-link);

            &:before {
              content: '';

              right: 0;
              background-color: red;
              height: 100%;
              width: 4px;
            }
          }
        }
      }

      @media screen and (max-width: 1024px) {&{
          display: none;
      }}
      }

      .mode-switch {
      background-color: transparent;
      border: none;
      padding: 0;
      color: var(--app-content-main-color);
      display: flex;
      justify-content: center;
      align-items: center;
      margin-left: auto;
      margin-right: 8px;
      cursor: pointer;

      .moon {
        fill: var(--app-content-main-color);
      }
      }

      .mode-switch.active .moon {
      fill: none;
      }

      .account-info {
      display: flex;
      align-items: center;
      padding: 16px;
      margin-top: auto;

      &-picture {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;

        img {
          width: 100%;
          height: 100%;
          object-fit: cover;
        }
      }

      &-name {
        font-size: $font-small;
        color: var(--sidebar-main-color);
        margin: 0 8px;
        overflow: hidden;
        max-width: 100%;
        text-overflow: ellipsis;
        white-space: nowrap;
      }

      &-more {
        color: var(--sidebar-main-color);
        padding: 0;
        border: none;
        background-color: transparent;
        margin-left: auto;
      }
      }

      .app-icon {
      color: var(--sidebar-main-color);

      svg {
        width: 24px;
        height: 24px;
      }
      }

      .app-content {
      padding: 16px;
      background-color: white;
      height: 100%;
      flex: 1;
      max-height: 100%;
      display: flex;
      flex-direction: column;

      &-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 4px;
      }

      &-headerText {
        color: var(--app-content-main-color);
        font-size: $font-large;
        line-height: 32px;
        margin: 0;
      }

      &-headerButton {
        background-color: var(--action-color);
        color: #fff;
        font-size: $font-small;
        line-height: 24px;
        border: none;
        border-radius: 4px;
        height: 32px;
        padding: 0 16px;
        transition: .2s;
        cursor: pointer;

        &:hover {
          background-color: var(--action-color-hover);
        }
      }

      &-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 4px;

        &-wrapper {
          display: flex;
          align-items: center;
          margin-left: auto;
        }

        @media screen and (max-width: 520px) {&{
          flex-direction: column;

          .search-bar { max-width: 100%; order: 2; }
          .app-content-actions-wrapper { padding-bottom: 16px; order: 1; }
        }}
      }
      }

      @mixin searchIcon($color) {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23#{$color}' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-search'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'/%3E%3C/svg%3E");
      }

      .search-bar {
      background-color: var(--app-content-secondary-color);
      border: 1px solid var(--app-content-secondary-color);
      color: var(--app-content-main-color);
      font-size: $font-small;
      line-height: 24px;
      border-radius: 4px;
      padding: 0px 10px 0px 32px;
      height: 32px;

      background-size: 16px;
      background-repeat: no-repeat;
      background-position: left 10px center;
      width: 100%;
      max-width: 320px;
      transition: .2s;



      &:placeholder { color: var(--app-content-main-color); }

      &:hover {
        border-color: var(--action-color-hover);

      }

      &:focus {
        outline: none;
        border-color: var(--action-color);

      }
      }

      .action-button {
      border-radius: 4px;
      height: 32px;
      background-color: var(--app-content-secondary-color);
      border: 1px solid var(--app-content-secondary-color);
      display: flex;
      align-items: center;
      color: var(--app-content-main-color);
      font-size: $font-small;
      margin-left: 8px;
      cursor: pointer;

      span { margin-right: 4px; }

       &:hover {
        border-color: var(--action-color-hover);
      }

      &:focus, &.active {
        outline: none;
        color: var(--action-color);
        border-color: var(--action-color);
      }
      }

      .filter-button-wrapper {
      position: relative;
      }

      @mixin arrowDown($color) {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23#{$color}' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-chevron-down'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
      }

      .filter-menu {

        background-color: var(--app-content-secondary-color);

        top: calc(100% + 16px);
        right: -74px;
        border-radius: 4px;
        padding: 8px;
        width: 220px;
        z-index: 2;
        box-shadow: var(--filter-shadow);


        opacity: 2;
        transition: .2s;

        &:before {
          content: '';
          position: absolute;
          width: 0;
          height: 0;
          border-left: 5px solid transparent;
          border-right: 5px solid transparent;

          border-bottom: 5px solid var(--app-content-secondary-color);
          bottom: 100%;
          left: 50%;
          transform: translatex(-50%);
        }

        &.active {
          visibility: visible;
          opacity: 1;
          top: calc(100% + 8px);
        }

        label {
          display: block;
          font-size: $font-small;
          color: var(--app-content-main-color);
          margin-bottom: 8px;
        }

      select {
        appearance: none;

        background-repeat: no-repeat;
        padding: 8px 24px 8px 8px;
        background-position: right 4px center;
        border: 1px solid var(--app-content-main-color);
        border-radius: 4px;
        color: var(--app-content-main-color);
        font-size: 12px;
        background-color: transparent;
        margin-bottom: 16px;
        width: 100%;
        option { font-size: 14px; }

        .light & {

        }

        &:hover {
          border-color: var(--action-color-hover);
        }

        &:focus, &.active {
          outline: none;
          color: var(--action-color);
          border-color: var(--action-color);

        }
      }
      }

      .filter-menu-buttons {
        display: inline;
        align-items: center;
        justify-content: space-between;
      }

      .filter-button {
      border-radius: 2px;
      font-size: 12px;
      padding: 4px 8px;
      cursor: pointer;
      border: none;
      color: #fff;

      &.apply {
        background-color: var(--action-color);
      }

      &.reset {
        background-color: var(--filter-reset);
      }
      }

      .products-area-wrapper {
      width: 100%;
      max-height: 100%;
      overflow: auto;
      padding: 0 4px;
      }

      .tableView {
      .products-header {
        display: flex;
        align-items: center;
        border-radius: 4px;
        background-color: var(--app-content-secondary-color);
        position: sticky;
        top: 0;
      }

      .products-row {
        display: flex;
        align-items: center;
        border-radius: 4px;

        &:hover {
          box-shadow: var(--filter-shadow);
          background-color: gray;
        }

        .cell-more-button {
          display: none;
        }
      }

      .product-cell {
        flex: 1;
        padding: 8px 16px;
        color: var(--app-content-main-color);
        font-size: $font-small;
        display: flex;
        align-items: center;

        img {
          width: 32px;
          height: 32px;
          border-radius: 6px;
          margin-right: 6px;
        }

        @media screen and (max-width: 780px) {&{
          font-size: 12px;
          &.image span { display: none; }
          &.image { flex: 0.2; }
        }}

        @media screen and (max-width: 520px) {&{
          &.category, &.sales {
            display: none;
          }
          &.status-cell { flex: 0.4; }
          &.stock, &.price { flex: 0.2; }
        }}

        @media screen and (max-width: 480px) {&{
          &.stock { display: none; }
          &.price { flex: 0.4; }
        }}
      }

      .sort-button {
        padding: 0;
        background-color: transparent;
        border: none;
        cursor: pointer;
        color: var(--app-content-main-color);
        margin-left: 4px;
        display: flex;
        align-items: center;

        &:hover { color: var(--action-color); }
        svg { width: 12px; }
      }

      .cell-label {
        display: none;
      }
      }

      .status {
      border-radius: 4px;
      display: flex;
      align-items: center;
      padding: 4px 8px;
      font-size: 12px;

      &:before {
        content: '';
        width: 4px;
        height: 4px;
        border-radius: 50%;
        margin-right: 4px;
      }

      &.active {
        color: #2ba972;
        background-color: rgba(43, 169, 114, 0.2);

        &:before {
          background-color: #2ba972;
        }
      }

      &.inactive {
        color: #2ba972;
        background-color: #FF674C;
        color: white;

        &:before {
          background-color: #2ba972;
        }
      }

      &.disabled {
        color: #59719d;
        background-color: rgba(89, 113, 157, 0.2);

        &:before {
          background-color: #59719d;
        }
      }
      }

      .gridView {
      display: flex;
      flex-wrap: wrap;
      margin: 0 -8px;

      @media screen and (max-width: 520px) {&{
        margin: 0;
      }}

      .products-header {
        display: none;
      }

      .products-row {
        margin: 8px;
        width: calc(25% - 16px);
        background-color: var(--app-content-secondary-color);
        padding: 8px;
        border-radius: 4px;
        cursor: pointer;
        transition: transform .2s;
        position: relative;

        &:hover {
          transform: scale(1.01);
          box-shadow: var(--filter-shadow);

          .cell-more-button {
            display: flex;
          }
        }

        @media screen and (max-width: 1024px) {&{
          width: calc(33.3% - 16px);
        }}

        @media screen and (max-width: 820px) {&{
          width: calc(50% - 16px);
        }}

        @media screen and (max-width: 520px) {&{
          width: 100%;
          margin: 8px 0;

          &:hover {
            transform: none;
          }
        }}

        .cell-more-button {
          border: none;
          padding: 0;
          border-radius: 4px;
          position: absolute;
          top: 16px;
          right: 16px;
          z-index: 1;
          display: flex;
          align-items: center;
          justify-content: center;
          width:24px;
          height: 24px;
          background-color: rgba(16, 24, 39, 0.7);
          color: #fff;
          cursor: pointer;
          display: none;
        }
      }

      .product-cell {
        color: var(--app-content-main-color);
        font-size: $font-small;
        margin-bottom: 8px;

        &:not(.image) {
          display: flex;
          align-items: center;
          justify-content: space-between;
        }

        &.image  span {
          font-size: 18px;
          line-height: 24px;
        }

        img {
          width: 100%;
          height: 140px;
          object-fit: cover;
          border-radius: 4px;
          margin-bottom: 16px;
        }
      }

      .cell-label { opacity: 1.6; }
      }

      /*Styles del radio button*/
      @import url('https://fonts.googleapis.com/css?family=Lato:400,500,600,700&display=swap');
      *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Lato', sans-serif;
      }

      .wrapper{
        display: inline-flex;
        background: #fff;
        height: 60px;
        width: 800px;
        align-items: center;
        justify-content: space-evenly;
        border-radius: 5px;
        padding: 15px 10px;
        box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
      }
      .wrapper .option{
        background: #fff;
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        margin: 0 10px;
        border-radius: 5px;
        cursor: pointer;
        padding: 0 10px;
        border: 2px solid lightgrey;
        transition: all 0.3s ease;
      }
      .wrapper .option .dot{
        height: 20px;
        width: 20px;
        background: #d9d9d9;
        border-radius: 50%;
        position: relative;
      }
      .wrapper .option .dot::before{
        position: absolute;
        content: "";
        top: 4px;
        left: 4px;
        width: 8px;
        height: 8px;
        background: #0069d9;
        border-radius: 50%;
        opacity: 0;
        transform: scale(1.5);
        transition: all 0.3s ease;
      }
      input[type="radio"]{
        display: none;
      }
      #option-1:checked:checked ~ .option-1,
      #option-0:checked:checked ~ .option-0,
      #option-3:checked:checked ~ .option-3,
      #option-2:checked:checked ~ .option-2{
        border-color: #0069d9;
        background: #0069d9;
      }
      #option-1:checked:checked ~ .option-1 .dot,
      #option-0:checked:checked ~ .option-0 .dot,
      #option-3:checked:checked ~ .option-3 .dot,
      #option-2:checked:checked ~ .option-2 .dot{
        background: #fff;
      }
      #option-1:checked:checked ~ .option-1 .dot::before,
      #option-0:checked:checked ~ .option-0 .dot::before,
      #option-3:checked:checked ~ .option-3 .dot::before,
      #option-2:checked:checked ~ .option-2 .dot::before{
        opacity: 1;
        transform: scale(1);
      }
      .wrapper .option span{
        font-size: 12px;
        color: #808080;
      }
      #option-1:checked:checked ~ .option-1 span,
      #option-0:checked:checked ~ .option-0 span,
      #option-3:checked:checked ~ .option-3 span,
      #option-2:checked:checked ~ .option-2 span{
        color: #fff;
      }

    </style>

</head>
<body>
@include('admin.menu')

<!-- -->

<!-- -->
<div class="col-lg-12">
  @if(isset($servicios))
  	<div class="row">
  		<div class="col-md-10" style="margin-bottom: 20px">
        <?php

        //$undia = date ('Y-m-d' , $undia);
        ?>
  			<h3 class="h_titulo">Novedades de Ruta del {{$cliente}}</h3>
<!--
        <button data-option="1" id="todas" class="btn btn-warning btn-icon">Ver Todas<i class="fa fa-globe icon-btn"></i></button>

        <button data-option="1" id="tiposdecomprobante" class="btn btn-default btn-icon">Buscar Rutas Dobles<i class="fa fa-sign-in icon-btn"></i></button>

        <button data-option="1" id="pasajeros_dobles" class="btn btn-default btn-icon">Pasajeros Dobles<i class="fa fa-sign-in icon-btn"></i></button>

        <button data-option="1" id="ocupacion_b" class="btn btn-default btn-icon">Ocupación Baja<i class="fa fa-car icon-btn"></i></button>-->

        <?php
        $ano = 2023;
        $mess = 05;
        ?>

        <div class="wrapper">

         <input type="radio" name="select" id="option-1" checked>
         <input type="radio" name="select" id="option-0">
         <input type="radio" name="select" id="option-2">
         <input type="radio" name="select" id="option-3">
           <label for="option-1" class="option option-1" id="todas">
             <div class="dot"></div>
              <span>TODAS LAS RUTAS</span>
              </label>
          <label for="option-0" class="option option-0" id="sin_novedad">
            <div class="dot"></div>
             <span>SIN NOVEDADES</span>
             </label>
           <label for="option-2" class="option option-2" id="pasajeros_dobles">
             <div class="dot"></div>
              <span>PAX DOBLES</span>
           </label>
           <label for="option-3" class="option option-3" id="ocupacion_b">
             <div class="dot"></div>
              <span>OCUPACIÓN BAJA</span>
           </label>

           <form class="form-inline" id="form_buscar" action="{{url('portalusu/exportarlistadonovedadesfecha')}}" method="post">

             <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 hidden">
                 <div class="input-group">
                   <div class="input-group date" id="datetimepicker1">
                       <input value="" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">
                       <span class="input-group-addon">
                           <span class="fa fa-calendar">
                           </span>
                       </span>
                   </div>
                 </div>
             </div>
             <input type="text" name="cc" value="{{$id}}" class="hidden">
             <input type="text" name="fecha" value="{{$cliente}}" class="hidden">

             <button type="submit" class="btn btn-success btn-icon input-font">EXCEL<i class="fa fa-download icon-btn"></i></button>
           </form>
        </div>

  		</div>
  		<div class="col-md-3 col-md-offset-5">
        <div class="estado_servicio_app hidden" style="background: red; color: white; margin: 2px 0px; font-size: 12px; padding: 3px 5px; width: 100%; border-radius: 2px;">
          Hay <span id="cantidad_ocupacion"></span> servicios con ocupación Baja
        </div>
  		</div>
  	</div>
  @else
  <div class="row">
    <div class="col-md-3 col-md-offset-5">
      <div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size: 12px; padding: 3px 5px; width: 100%; border-radius: 2px;">
        Reporte enviado!
      </div>
    </div>
  </div>
  @endif

    <?php

      $reports = DB::table('report')
      ->where('fecha',$cliente)
      ->where('cliente',$id)
      ->first();

    ?>

    @if(isset($reports))
      <div class="estado_servicio_app" style="float: right; background: #f47321; color: white; margin: 2px 0px; font-size: 9px; border-radius: 10px; padding: 3px 5px; width: 160px;">
        <b style="color: white; font-size: 12px">ENVIADO AL CLIENTE <i class="fa fa-check" aria-hidden="true"></i></b>
      </div>
      <br>
      <br>
      <br>
    @else
      <div class="estado_servicio_app" style="float: right; background: #f47321; color: white; margin: 2px 0px; font-size: 9px; border-radius: 1px; padding: 3px 5px; width: 160px;">
        <b style="color: white; font-size: 12px">PENDIENTE DE ENVIAR <i class="fa fa-clock-o" aria-hidden="true"></i></b>
      </div>
      <button style="float: right; margin-right: 20px" type="submit" data-fecha="{{$cliente}}" data-email="@if($id==19){{'jefedetransporte@aotour.com.co'}}@else{{'jefedetransportebog@aotour.com.co'}}@endif" class="btn btn-danger btn-icon input-font send_email hidden">Envíar a Operaciones<i class="fa fa-share icon-btn" aria-hidden="true"></i></button>
      <br>
      <br>
      <br>
    @endif

    @if(isset($servicios))
        <table class="table table-striped table-bordered hover" id="rutas_ejecutadas">
            <thead>
            <tr style="background: #0069d9; color: white">
                <td style="text-align: center">#</td>
                <td style="text-align: center">RUTA</td>
                <td style="text-align: center">RECOGER EN</td>
                <td style="text-align: center">DEJAR EN</td>
                <td style="text-align: center">FECHA</td>
                <td style="text-align: center">HORA</td>
                <td style="text-align: center">SITE</td>
                <td style="text-align: center">CONDUCTOR</td>
                <td style="text-align: center"><b>NOVEDAD</b></td>
            </tr>
            </thead>
            <tbody>
            	<?php $sw=0; $i=1; $total=0; $total2 = 0; $nombre_anterior= ''; $cor = 0; $cor2 = 0; $count_aprobar = 0;?>
            @foreach($servicios as $ruta)

                @if($ruta->razoncentro!=$nombre_anterior)
                	<tr>
                		<td colspan="13"><span>{{$ruta->razoncentro}}</span></td>
                	</tr>
                @endif

                <?php
                $class = 'success';
                $clases = '';
                $si_no = 0;
              //code query
                $json = json_decode($ruta->pasajeros_ruta);
                if(is_array($json)){
                  foreach ($json as $key => $value) {
                    if($value->area=='BOGOTÁ' or $value->area=='SOACHA' or $value->area=='BOGOTA' or $value->area==''){
                      $class = 'warning';
                      $clases = 'novedad_no ';
                      $si_no = 1;
                    }

                    $consultas = DB::table('qr_rutas')
                    ->leftJoin('servicios', 'servicios.id', '=', 'qr_rutas.servicio_id')
                    ->select('qr_rutas.id', 'qr_rutas.servicio_id', 'servicios.pendiente_autori_eliminacion')
                    ->where('servicio_id', '!=', $ruta->id)
                    ->where('fecha', $cliente)
                    ->where('hora','>', '20:00:00')
                    ->whereNull('servicios.pendiente_autori_eliminacion')
                    ->where('id_usuario', $value->apellidos)
                    ->first();

                    if($consultas) {
                      $clases .= 'pasajero_repetido';
                    }

                  }
                }

                $cllas = '';

                //$clases = ''; //ojo

                $capacidad = intval($ruta->capacidad)-1;
                $cantidad = intval($ruta->cantidad);

                $porcentaje = ($cantidad/$capacidad)*100;

                if( ( ($ruta->capacidad-1)<5 and $ruta->cantidad<2) or ( ($ruta->capacidad-1)>4 and $porcentaje < 50)){
                  $cllas = 'ocupacion_baja';
                }

                ?>

                <tr style="border-radius: 20px" data-id="{{$ruta->id}}" class="{{$clases}} {{$cllas}}" >

                    <td data-id="{{$ruta->id}}">
                        <?php echo $i ?>
                        <br>
                        <p class="@if($si_no==1){{'consecutiv'}}@endif" data-id="{{$ruta->id}}">{{$ruta->id}}</p>
                    </td>

                    <td>
                    	<span style="font-size: 10px">{{$ruta->detalle_recorrido}}</span>
                    </td>
                    <td style="width: 10%">
                    	<span style="font-size: 10px">{{$ruta->recoger_en}}</span>
                    </td>
                    <td style="width: 10%">
                    	<span style="font-size: 10px">{{$ruta->dejar_en}}</span>
                    </td>
                    <td style="width: 7%">
                    	<span>{{$ruta->fecha_servicio}}</span>
                    </td>
                    <td>
                    	<span>{{$ruta->hora_servicio}}</span>
                    </td>
                    <td>
                        <a href>{{$ruta->nombresubcentro}}</a>
                    </td>
                    <td>
                        <center>
                        <b style="font-size: 9px">{{$ruta->nombre_completo}}</b>
                        @if( (intval($ruta->capacidad)-1)<=4)
                          <!-- AUTO -->
                          @if($porcentaje < 50)
                            <?php
                              $icon = '<i title="('.$porcentaje.'%) El vehículo ('.$ruta->placa.') lleva menos del 50% de su capacidad!" style="color: red; font-size: 13px" class="fa fa-exclamation-circle" aria-hidden="true"></i>';
                            ?>
                          @else
                            <?php
                              $icon = '<i title="('.$porcentaje.'%) El vehículo ('.$ruta->placa.') lleva un buen porcentaje de usuarios!" style="color: green; font-size: 13px" class="fa fa-check" aria-hidden="true"></i>';
                            ?>
                          @endif

                          <center><div class="estado_servicio_app" style="background: #0069d9; color: white; margin: 2px 0px; font-size: 12px; padding: 1px 3px; width: 90%; border-radius: 1px;">
                            <b>Capacidad de {{intval($ruta->capacidad)-1}} pax <div style="float: right; margin-top: 3px; background: white; color: black; margin: 1px 0px; font-size: 12px; padding: 1px 2px; width: 20px; border-radius: 2px;">{{$icon}}</div></b>
                          </div></center>
                        @elseif( (intval($ruta->capacidad)-1)>4)
                          <!-- VAN -->

                          @if(intval($porcentaje) < 30)
                            <?php
                              $icon = '<i title="('.round($porcentaje, 2).'%) El vehículo ('.$ruta->placa.') lleva menos del 30% de su capacidad!" style="color: red; font-size: 13px" class="fa fa-exclamation-circle" aria-hidden="true"></i>';
                            ?>
                          @elseif(intval($porcentaje) < 50)
                            <?php
                              $icon = '<i title="('.round($porcentaje, 2).'%) El vehículo ('.$ruta->placa.') lleva menos del 50% de su capacidad!" style="color: orange; font-size: 13px" class="fa fa-exclamation-circle" aria-hidden="true"></i>';
                            ?>
                          @else
                            <?php
                              $icon = '<i title="('.round($porcentaje, 2).'%) El vehículo ('.$ruta->placa.') lleva un buen porcentaje de usuarios!" style="color: green; font-size: 13px" class="fa fa-check" aria-hidden="true"></i>';
                            ?>
                          @endif

                          <center><div class="estado_servicio_app" style="background: #0069d9; color: white; margin: 2px 0px; font-size: 12px; padding: 1px 3px; width: 90%; border-radius: 1px;">
                            <b>Capacidad de {{intval($ruta->capacidad)-1}} pax <div style="float: right; margin-top: 3px; background: white; color: black; margin: 1px 0px; font-size: 12px; padding: 1px 2px; width: 20px; border-radius: 2px;">{{$icon}}</div></b>
                          </div></center>
                        @endif
                      </center>
                    </td>
                    <td style="width: 500px">
                      <table class="table table-striped table-bordered hover" id="rutas_ejecutadasss">
                      <?php
                      $json = json_decode($ruta->pasajeros_ruta);
                      if(is_array($json)){
                        foreach ($json as $key => $value) {


                          $consultas = DB::table('qr_rutas')
                          ->leftJoin('servicios', 'servicios.id', '=', 'qr_rutas.servicio_id')
                          ->select('qr_rutas.id', 'qr_rutas.servicio_id', 'servicios.pendiente_autori_eliminacion')
                          ->where('servicio_id', '!=', $ruta->id)
                          ->where('fecha', $cliente)
                          ->where('hora','>', '20:00:00')
                          ->whereNull('servicios.pendiente_autori_eliminacion')
                          ->where('id_usuario', $value->apellidos)
                          ->first();

                          $repetido = '';
                          $service ='';
                          if($consultas) {
                            $repetido = 'Repetido';
                            $service = $consultas->servicio_id;
                          }
                          ?>
                          <tr class="{{$clases}} {{$cllas}}">
                            <td width="40%"><b style="font-size: 8px">{{$value->nombres}}</b>
                              @if($repetido!='')
                              <div class="estado_servicio_app" style="background: orange; color: white; margin: 2px 0px; font-size: 12px; padding: 3px 5px; width: 100%; border-radius: 2px;">
                                {{$repetido}} en <a style="color: white" href="{{url('transportesbaq/reconfirmacion/'.$service)}}" target="_blank">{{$service}}</a>
                              </div>

                              @endif
                            </td>
                            <td>
                              @if($value->area=='BOGOTÁ' or $value->area=='SOACHA' or $value->area=='BOGOTA' or $value->area=='')
                                <p style="font-size: 8px">NOVEDAD NO REGISTRADA <i style="color: orange; font-size: 13px; float: right" class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
                                <?php $sw++?>
                              @else
                                <p style="font-size: 8px">@if( trim($value->area)=='RUTA EJECUTADA CON ÉXITO' or trim($value->area)=='RUTA EJECUTADA CON EXITO' ){{$value->area}} <i style="color: green; font-size: 13px; float: right" class="fa fa-check" aria-hidden="true"></i>@elseif(trim($value->area)=='NO SE PRESENTÓ' or trim($value->area)=='NO SE PRESENTO'){{$value->area}} <i style="color: red; font-size: 13px; float: right" class="fa fa-times" aria-hidden="true"></i>@elseif(trim($value->area)=='CONSULTOR NO PROGRAMADO') {{$value->area}} <i style="color: blue; font-size: 13px; float: right" class="fa fa-pencil-square-o" aria-hidden="true"></i>@elseif(trim($value->area)=='CONSULTOR TOMA RUTA EN HORARIO NO PROGRAMADO') {{$value->area}} <i style="color: black; font-size: 13px; float: right" class="fa fa-exchange" aria-hidden="true"></i>@else{{$value->area}} @endif</p>
                              @endif


                            </td>
                          </tr>
                          <?php
                        }
                      }
                      ?>
                      </table>


                    </td>

                </tr>
                <?php $i++; $nombre_anterior=$ruta->razoncentro; ?>
            @endforeach
            </tbody>
        </table>

    @endif
</div>

<?php

  $reports = DB::table('report')
  ->where('fecha',$cliente)
  ->where('cliente',$id)
  ->first();

?>

@if(isset($reports))
  <button style="margin-bottom: 30px; float: right; margin-right: 15px" data-option="1" data-cliente="{{$id}}" disabled data-fecha="{{$cliente}}" class="btn btn-primary btn-icon">Enviado al Cliente<i class="fa fa-check icon-btn"></i></button>
@else
  <button style="margin-bottom: 30px; float: right; margin-right: 15px" data-option="1" data-cliente="{{$id}}" data-fecha="{{$cliente}}" data-sw="{{$sw}}" id="enviar_novedades" class="btn btn-success btn-icon">Enviar Reporte<i class="fa fa-check icon-btn"></i></button>
@endif

<div id="motivo_rechazo" class="hidden">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Fecha de Pago</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-group">
                              <div class="input-group">
                                  <div class='input-group date' id='datetimepicker1'>
                                      <input name="fecha_pago" id="fecha_pago" style="width: 89px;" type='text' class="form-control input-font" value="" placeholder="">
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar">
                                      </span>
                                  </span>
                                  </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <a id="confirmar_fecha" class="btn btn-success btn-icon">Realizar<i class="fa fa-check icon-btn"></i></a>
                    </div>
                    <div class="col-md-2">
                        <a id="cancelar_aprobacion_cuenta" class="btn btn-danger btn-icon">Cancelar<i class="fa fa-close icon-btn"></i></a>
                    </div>
                </div>
                <!-- BUTOMS -->
            </div>
        </div>

    </div>
</div>

<div id="motivo_eliminacion" class="hidden">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Confirmar</div>
            <div class="panel-body">
                <div class="form-group">
                    <label>Digite el motivo por el cual va a realizar modificación del valor cobrado.</label>
                    <textarea id="descripcion" cols="40" rows="10" class="form-control input-font"></textarea>
                </div>
                <a id="save2" class="btn btn-primary btn-icon">Realizar<i class="fa fa-check icon-btn"></i></a>
                <a id="cancelar2" class="btn btn-warning btn-icon">Cancelar<i class="fa fa-close icon-btn"></i></a>


                <a style="float: right;" id="colocar_texto" class="btn btn-list-table btn-dark"><i class="fa fa-clipboard" aria-hidden="true"></i></a>

            </div>
        </div>

    </div>
</div>

<!-- MODAL CONVERSACIÓN -->
<div class="modal fade" tabindex="-1" role="dialog" id='modal_conversacion'>
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background: #44AB2D">
            <span style="font-size: 18px">Comentarios <i class="fa fa-commenting" aria-hidden="true"></i></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="row conversacion">

            </div>
        </div>
    </div>
  </div>
</div>

<div class="errores-modal bg-danger text-danger hidden model" style="background: orange; color: black">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    	<li>
    		test
    	</li>
    </ul>
</div>

@include('scripts.scripts')
<script src="https://js.pusher.com/4.3/pusher.min.js"></script>

<script>

	Pusher.logToConsole = true;

  	//INICIO PUSHER APROBACIÓN DE CORRECCIÓN
  	var pusher2 = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    	cluster: 'us2',
	    forceTLS: true
  	});

  	var pusher2 = pusher2.subscribe('contabilidad');

  	pusher2.bind('bcuenta', function(data) {

    var proceso = parseInt(data.proceso);
    var cuenta_id = parseInt(data.cuenta_id);

    //var estado = '<h5 id="'+data.cuenta_id+''+data.cuenta_id+''+data.cuenta_id+'" style="float: left; margin-top: 2px; margin-bottom: 15px"><span style="background: red; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px; margin-top: 15px; margin-bottom: 15px"><b>PENDIENTE DE APROBACIÓN</b></span></h5>';

    location.reload();

    //var servicios_count = cantidad;
    //var ctx = document.getElementById(data.cuenta_id+data.cuenta_id+data.cuenta_id);
    //ctx.html('HOLA MUNDO!');
    //$('#'+data.cuenta_id+''+data.cuenta_id+''+data.cuenta_id+'').html('HOLA MUNDO!');

  });
  //FIN PUSHER SERVICIOS DE BOGOTÁ
</script>

<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/portalproveedores.js')}}"></script>
<script>

    $('#menus').click(function() {

      if($('.menus').hasClass('hidden')){
        $('.menus').removeClass('hidden');
      }else{
        $('.menus').addClass('hidden');
      }

    });

    $('table a').click(function (e) {
        e.preventDefault();
    });

    $('#pasajeros_dobles').click(function(){
      //$('.pasajero_repetido').addClass('hidden');

      $('#rutas_ejecutadas tbody tr').each(function(index){
        if( $(this).hasClass('pasajero_repetido') ){
          $(this).removeClass('hidden');
        }else{
          $(this).addClass('hidden');
        }
      })

      $('.send_email').addClass('hidden');

      $('#pasajeros_dobles').addClass('btn btn-warning btn-icon');
      $('#todas').removeClass('btn btn-warning btn-icon').addClass('btn btn-default btn-icon');
      $('#ocupacion_b').removeClass('btn btn-warning btn-icon').addClass('btn btn-default btn-icon');

    })

    $('#sin_novedad').click(function(){
      //$('.pasajero_repetido').addClass('hidden');

      var cont = 0;

      $('#rutas_ejecutadas tbody tr').each(function(index){
        if( $(this).hasClass('novedad_no') ){
          cont++;
          $(this).removeClass('hidden');
        }else{
          $(this).addClass('hidden');
        }
      })

      if(cont>0){
        $('.send_email').removeClass('hidden');
      }

      $('#pasajeros_dobles').addClass('btn btn-warning btn-icon');
      $('#todas').removeClass('btn btn-warning btn-icon').addClass('btn btn-default btn-icon');
      $('#ocupacion_b').removeClass('btn btn-warning btn-icon').addClass('btn btn-default btn-icon');

    })

    $('#ocupacion_b').click(function(){
      //$('.ocupacion_baja').addClass('hidden');
      var cantiti = 0;
      $('#rutas_ejecutadas tbody tr').each(function(index){
        if( $(this).hasClass('ocupacion_baja') ){
          $(this).removeClass('hidden');
          cantiti = cantiti + 1;
        }else{
          $(this).addClass('hidden');
        }
      })

      $('.send_email').addClass('hidden');

      $('#cantidad_ocupacion').html(cantiti)
      $('#ocupacion_b').addClass('btn btn-warning btn-icon');
      $('#pasajeros_dobles').removeClass('btn btn-warning btn-icon').addClass('btn btn-default btn-icon');
      $('#todas').removeClass('btn btn-warning btn-icon').addClass('btn btn-default btn-icon');

    })

    $('#todas').click(function(){
      //$('.ocupacion_baja').addClass('hidden');

      $('#rutas_ejecutadas tbody tr').each(function(index){
          $(this).removeClass('hidden');
      })

      $('.send_email').addClass('hidden');

      $('#todas').addClass('btn btn-warning btn-icon');
      $('#pasajeros_dobles').removeClass('btn btn-warning btn-icon').addClass('btn btn-default btn-icon');
      $('#ocupacion_b').removeClass('btn btn-warning btn-icon').addClass('btn btn-default btn-icon');

    })

    $('#enviar_novedades').click(function(){

      var cliente = $(this).attr('data-cliente');
      var fecha = $(this).attr('data-fecha');
      var sw = $(this).attr('data-sw');

      $.confirm({
            title: 'Atención',
            content: 'Estás seguro de enviar las novedades?<br><br>Recuerda que le llegará una notificación al cliente.',
            buttons: {
                confirm: {
                    text: 'Si, Enviar!',
                    btnClass: 'btn-success',
                    keys: ['enter', 'shift'],
                    action: function(){

                      //if(sw!=0){
                      if(1>2){

                        $.confirm({
                          title: 'Atención',
                          content: 'Aún quedan '+sw+' usuarios sin novedad registrada...',
                          buttons: {
                              confirm: {
                                  text: 'Ok',
                                  btnClass: 'btn-danger',
                                  keys: ['enter', 'shift'],
                                  action: function(){



                                  }

                              }
                          }

                        });

                      }else{

                        $.ajax({
                          url: '../../facturacion/enviarnovedades',
                          method: 'post',
                          data: {cliente: cliente, fecha: fecha}
                        }).done(function(data){

                          if(data.respuesta==true){

                            $.confirm({
                                title: 'Atención',
                                content: 'Se ha enviado el reporte de novedades con éxito!!!',
                                buttons: {
                                    confirm: {
                                        text: 'Ok',
                                        btnClass: 'btn-primary',
                                        keys: ['enter', 'shift'],
                                        action: function(){

                                          location.reload();

                                        }

                                    }
                                }
                          });

                          }else if(data.respuesta==false){

                          }

                        });

                      }

                    }

                },
                cancel: {
                  text: 'Volver',
                }
            }
        });

    });

    $('.send_email').click(function(){

      $.confirm({
            title: 'Atención',
            content: 'Confirmas el envío del correo a transportes?',
            buttons: {
                confirm: {
                    text: 'Si, Enviar correo!',
                    btnClass: 'btn-danger',
                    keys: ['enter', 'shift'],
                    action: function(){

                      var idArray = [];
                      var fecha = $('.send_email').attr('data-fecha');
                      var email = $('.send_email').attr('data-email');

                      $('#rutas_ejecutadas tbody tr').each(function(index){

                        $(this).children("td").each(function (index2){
                            switch (index2){
                                case 0:
                                    var $objeto = $(this).find('.consecutiv');

                                    if( $objeto.attr('data-id') != undefined){
                                      idArray.push($objeto.attr('data-id'));
                                    }

                                break;
                            }
                        });

                      });

                      $.ajax({
                        url: '../../facturacion/enviarnovedadespendientes',
                        method: 'post',
                        data: {idArray: idArray, fecha: fecha, email: email}
                      }).done(function(data){

                        if(data.respuesta==true){

                          $.confirm({
                              title: 'Atención',
                              content: 'Se ha enviado el correo exitosamente!',
                              buttons: {
                                  confirm: {
                                      text: 'Ok',
                                      btnClass: 'btn-primary',
                                      keys: ['enter', 'shift'],
                                      action: function(){



                                      }

                                  }
                              }
                        });

                        }else if(data.respuesta==false){

                        }

                    });



                    }

                },
                cancel: {
                  text: 'Cancelar',
                }
            }
        });

    });

</script>
</body>
</html>
