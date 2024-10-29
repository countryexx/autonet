<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Listado de Novedades</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style media="screen">
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap');

      * { box-sizing: border-box; }

      .label-estado {
        right: 10px;
        font-size: 12px;
        top: 65px;
        padding: 6px 7px 5px;
        z-index: 10;
        color: white;
        border-radius: 4px;

        animation-name: parpadeo;
        animation-duration: 1s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;

        -webkit-animation-name:parpadeo;
        -webkit-animation-duration: 1s;
        -webkit-animation-timing-function: linear;
        -webkit-animation-iteration-count: infinite;
      }

      @-moz-keyframes parpadeo{
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
        100% { opacity: 1.0; }
      }

      @-webkit-keyframes parpadeo {
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
         100% { opacity: 1.0; }
      }

      @keyframes parpadeo {
        0% { opacity: 1.0; }
         50% { opacity: 0.0; }
        100% { opacity: 1.0; }
      }

      :root {
      --app-bg: #101827;
      --sidebar: rgba(21, 30, 47,1);
      --sidebar-main-color: #fff;
      --table-border: #1a2131;
      --table-header: #1a2131;
      --app-content-main-color: #fff;
      --sidebar-link: #fff;
      --sidebar-active-link: #1d283c;
      --sidebar-hover-link: #1a2539;
      --action-color: #2869ff;
      --action-color-hover: #6291fd;
      --app-content-secondary-color: #1d283c;
      --filter-reset: #2c394f;
      --filter-shadow: rgba(16, 24, 39, 0.8) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
      }

      .light:root {
      --app-bg: #fff;
      --sidebar: #f3f6fd;
      --app-content-secondary-color: #f3f6fd;
      --app-content-main-color: #1f1c2e;
      --sidebar-link: #1f1c2e;
      --sidebar-hover-link: rgba(195, 207, 244, 0.5);
      --sidebar-active-link: rgba(195, 207, 244, 1);
      --sidebar-main-color: #1f1c2e;
      --filter-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
      }

      $font-small: 14px;
      $font-medium: 16px;
      $font-large: 24px;

      body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      width: 100%;
      }

      body {
      overflow: hidden;
      font-family: 'Poppins', sans-serif;

      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
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
        background-color: gray;

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
      display: flex;
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
    </style>

</head>
<body>

@include('admin.menu')

  <?php
    $mess = date('m');
    $ano = date('Y');
    $dia = date('d');

  ?>

<div class="container-fluid" style="height: 70%;">
  <div class="col-xs-12">
    <div class="col-lg-12">
      @include('facturacion.menu_facturacion')
    </div>

      <div class="row">

        <div class="col-lg-4 col-md-3 col-sm-2" style="margin-bottom: 5px;">
          <h3 class="h_titulo">{{$nombreRazon}}</h3>
          <?php

          if($mess==1){
            $month = 'ENERO';
          }else if($mess==2){
            $month = 'FEBRERO';
          }else if($mess==3){
            $month = 'MARZO';
          }else if($mess==4){
            $month = 'ABRIL';
          }else if($mess==5){
            $month = 'MAYO';
          }else if($mess==6){
            $month = 'JUNIO';
          }else if($mess==7){
            $month = 'JULIO';
          }else if($mess==8){
            $month = 'AGOSTO';
          }else if($mess==9){
            $month = 'SEPTIEMBRE';
          }else if($mess==10){
            $month = 'OCTUBRE';
          }else if($mess==11){
            $month = 'NOVIEMBRE';
          }else if($mess==12){
            $month = 'DICIEMBRE';
          }

          $consulta = DB::table('dash')
          ->where('cliente',$centrodecosto_id)
          ->where('mes',$month)
          ->first();

          if($consulta!=null){
            ?>
              <a data-option="1" target="_blank" href="{{url('reportes/dash/'.$consulta->id)}}" class="btn btn-primary btn-icon enviado" style="margin-bottom: 20px">¡Dashboard Enviado! Click para ver <i class="fa fa-share icon-btn"></i></a>
              <button data-option="1" data-mes="{{$month}}" data-cliente="{{$centrodecosto_id}}" class="btn btn-success btn-icon por_enviar hidden" style="margin-bottom: 20px">Generar Dashboard de este mes<i class="fa fa-sign-in icon-btn"></i></button>
            <?php
          }else{
            ?>
              <a data-option="1" target="_blank" class="btn btn-primary btn-icon enviado hidden" style="margin-bottom: 20px">¡Dashboard Enviado! Click para ver <i class="fa fa-share icon-btn"></i></a>
              <button data-option="1" data-mes="{{$month}}" data-cliente="{{$centrodecosto_id}}" id="query" class="btn btn-success btn-icon por_enviar" disabled style="margin-bottom: 20px">Generar Dashboard de este mes<i class="fa fa-sign-in icon-btn"></i></button>
            <?php
          }
          ?>
        </div>
      </div>

    <div class="app-container">

      <div class="app-content" style="margin-bottom: 80px">
        <div class="app-content-header">
          <center>
            <div class="product-cell status-cell">
              <span style="width: 380px" class="status inactive hidden" id="sin_datos" style="font-size: 17px"></span>
            </div>
          </center>
          <button class="mode-switch" title="Switch Theme">
            <svg class="moon" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="24" height="24" viewBox="0 0 24 24">
              <defs></defs>
              <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
            </svg>
          </button>

        </div>
        <div class="app-content-actions">
          <!--<input class="search-bar" placeholder="Search..." type="text">-->
          <div class="app-content-actions-wrapper">
            <div class="filter-button-wrapper">

              <!-- FILTROS -->
              <?php
              $mess = date('m');
              //echo $mess;

              if(intval($mess) == 01){
                $mes = 'ENERO';
              }else if(intval($mess) == 02){
                $mes = 'FEBRERO';
              }else if(intval($mess) == 03){
                $mes = 'MARZO';
              }else if(intval($mess) == 04){
                $mes = 'ABRIL';
              }else if(intval($mess) == 05){
                $mes = 'MAYO';
              }else if(intval($mess) == 06){
                $mes = 'JUNIO';
              }else if(intval($mess) == 07){
                $mes = 'JULIO';
              }/*else if(intval($mess) == 08){
                $mes = 'AGOSTO';
              }else if(intval($mess) == 09){
                $mes = 'SEPTIEMBRE';
              }else if(intval($mess) == 10){
                $mes = 'OCTUBRE';
              }else if(intval($mess) == 11){
                $mes = 'NOVIEMBRE';
              }else if(intval($mess) == 12){
                $mes = 'DICIEMBRE';
              }*/
              //echo $mes;
              ?>
              <input type="text" name="" value="{{$centrodecosto_id}}" class="hidden" id="client">
              <div class="form-group">
                <select data-option="1" name="meses" style="width: 130px; margin-left: 10px" class="form-control input-font meses">
                  <option value="0">FILTRAR MES</option>
                  <option data-mes="ENERO" value="1" @if($mess<'01'){{'disabled'}}@endif>ENERO</option>
                  <option data-mes="FEBRERO" value="2" @if($mess<'02'){{'disabled'}}@endif>FEBRERO</option>
                  <option data-mes="MARZO" value="3" @if($mess<'03'){{'disabled'}}@endif>MARZO</option>
                  <option data-mes="ABRIL" value="4" @if($mess<'04'){{'disabled'}}@endif>ABRIL</option>
                  <option data-mes="MAYO" value="5" @if($mess<'05'){{'disabled'}}@endif>MAYO</option>
                  <option data-mes="JUNIO" value="6" @if($mess<'06'){{'disabled'}}@endif>JUNIO</option>
                  <option data-mes="JULIO" value="7" @if($mess<'07'){{'disabled'}}@endif>JULIO</option>
                  <option data-mes="AGOSTO" value="8" @if($mess<'08'){{'disabled'}}@endif>AGOSTO</option>
                  <option data-mes="SEPTIEMBRE" value="9" @if($mess<'09'){{'disabled'}}@endif>SEPTIEMBRE</option>
                  <option data-mes="OCTUBRE" value="10" @if($mess<'10'){{'disabled'}}@endif>OCTUBRE</option>
                  <option data-mes="NOVIEMBRE" value="11" @if($mess<'11'){{'disabled'}}@endif>NOVIEMBRE</option>
                  <option data-mes="DICIEMBRE" value="12" @if($mess<'12'){{'disabled'}}@endif>DICIEMBRE</option>

                </select>
              </div>
              <!-- FILTROS -->
            </div>
            <br>
            <button class="action-button list active hidden" title="List View">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            </button>
            <button class="action-button grid hidden" title="Grid View">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </button>
          </div>
        </div>
        <div class="products-area-wrapper tableView">
          <div class="products-header">
            <div class="product-cell image">
              Fecha
              <button class="sort-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><path fill="currentColor" d="M496.1 138.3L375.7 17.9c-7.9-7.9-20.6-7.9-28.5 0L226.9 138.3c-7.9 7.9-7.9 20.6 0 28.5 7.9 7.9 20.6 7.9 28.5 0l85.7-85.7v352.8c0 11.3 9.1 20.4 20.4 20.4 11.3 0 20.4-9.1 20.4-20.4V81.1l85.7 85.7c7.9 7.9 20.6 7.9 28.5 0 7.9-7.8 7.9-20.6 0-28.5zM287.1 347.2c-7.9-7.9-20.6-7.9-28.5 0l-85.7 85.7V80.1c0-11.3-9.1-20.4-20.4-20.4-11.3 0-20.4 9.1-20.4 20.4v352.8l-85.7-85.7c-7.9-7.9-20.6-7.9-28.5 0-7.9 7.9-7.9 20.6 0 28.5l120.4 120.4c7.9 7.9 20.6 7.9 28.5 0l120.4-120.4c7.8-7.9 7.8-20.7-.1-28.5z"/></svg>
              </button>
            </div>
            <div class="product-cell category">Fecha de Envío<button class="sort-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><path fill="currentColor" d="M496.1 138.3L375.7 17.9c-7.9-7.9-20.6-7.9-28.5 0L226.9 138.3c-7.9 7.9-7.9 20.6 0 28.5 7.9 7.9 20.6 7.9 28.5 0l85.7-85.7v352.8c0 11.3 9.1 20.4 20.4 20.4 11.3 0 20.4-9.1 20.4-20.4V81.1l85.7 85.7c7.9 7.9 20.6 7.9 28.5 0 7.9-7.8 7.9-20.6 0-28.5zM287.1 347.2c-7.9-7.9-20.6-7.9-28.5 0l-85.7 85.7V80.1c0-11.3-9.1-20.4-20.4-20.4-11.3 0-20.4 9.1-20.4 20.4v352.8l-85.7-85.7c-7.9-7.9-20.6-7.9-28.5 0-7.9 7.9-7.9 20.6 0 28.5l120.4 120.4c7.9 7.9 20.6 7.9 28.5 0l120.4-120.4c7.8-7.9 7.8-20.7-.1-28.5z"/></svg>
              </button></div>
              <div class="product-cell sales">Hora de Envío<button class="sort-button">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><path fill="currentColor" d="M496.1 138.3L375.7 17.9c-7.9-7.9-20.6-7.9-28.5 0L226.9 138.3c-7.9 7.9-7.9 20.6 0 28.5 7.9 7.9 20.6 7.9 28.5 0l85.7-85.7v352.8c0 11.3 9.1 20.4 20.4 20.4 11.3 0 20.4-9.1 20.4-20.4V81.1l85.7 85.7c7.9 7.9 20.6 7.9 28.5 0 7.9-7.8 7.9-20.6 0-28.5zM287.1 347.2c-7.9-7.9-20.6-7.9-28.5 0l-85.7 85.7V80.1c0-11.3-9.1-20.4-20.4-20.4-11.3 0-20.4 9.1-20.4 20.4v352.8l-85.7-85.7c-7.9-7.9-20.6-7.9-28.5 0-7.9 7.9-7.9 20.6 0 28.5l120.4 120.4c7.9 7.9 20.6 7.9 28.5 0l120.4-120.4c7.8-7.9 7.8-20.7-.1-28.5z"/></svg>
                </button></div>
            <div class="product-cell status-cell">Estado<button class="sort-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><path fill="currentColor" d="M496.1 138.3L375.7 17.9c-7.9-7.9-20.6-7.9-28.5 0L226.9 138.3c-7.9 7.9-7.9 20.6 0 28.5 7.9 7.9 20.6 7.9 28.5 0l85.7-85.7v352.8c0 11.3 9.1 20.4 20.4 20.4 11.3 0 20.4-9.1 20.4-20.4V81.1l85.7 85.7c7.9 7.9 20.6 7.9 28.5 0 7.9-7.8 7.9-20.6 0-28.5zM287.1 347.2c-7.9-7.9-20.6-7.9-28.5 0l-85.7 85.7V80.1c0-11.3-9.1-20.4-20.4-20.4-11.3 0-20.4 9.1-20.4 20.4v352.8l-85.7-85.7c-7.9-7.9-20.6-7.9-28.5 0-7.9 7.9-7.9 20.6 0 28.5l120.4 120.4c7.9 7.9 20.6 7.9 28.5 0l120.4-120.4c7.8-7.9 7.8-20.7-.1-28.5z"/></svg>
              </button></div>

            <div class="product-cell stock">Ciudad<button class="sort-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><path fill="currentColor" d="M496.1 138.3L375.7 17.9c-7.9-7.9-20.6-7.9-28.5 0L226.9 138.3c-7.9 7.9-7.9 20.6 0 28.5 7.9 7.9 20.6 7.9 28.5 0l85.7-85.7v352.8c0 11.3 9.1 20.4 20.4 20.4 11.3 0 20.4-9.1 20.4-20.4V81.1l85.7 85.7c7.9 7.9 20.6 7.9 28.5 0 7.9-7.8 7.9-20.6 0-28.5zM287.1 347.2c-7.9-7.9-20.6-7.9-28.5 0l-85.7 85.7V80.1c0-11.3-9.1-20.4-20.4-20.4-11.3 0-20.4 9.1-20.4 20.4v352.8l-85.7-85.7c-7.9-7.9-20.6-7.9-28.5 0-7.9 7.9-7.9 20.6 0 28.5l120.4 120.4c7.9 7.9 20.6 7.9 28.5 0l120.4-120.4c7.8-7.9 7.8-20.7-.1-28.5z"/></svg>
              </button></div>
            <div class="product-cell price">Revisar<button class="sort-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><path fill="currentColor" d="M496.1 138.3L375.7 17.9c-7.9-7.9-20.6-7.9-28.5 0L226.9 138.3c-7.9 7.9-7.9 20.6 0 28.5 7.9 7.9 20.6 7.9 28.5 0l85.7-85.7v352.8c0 11.3 9.1 20.4 20.4 20.4 11.3 0 20.4-9.1 20.4-20.4V81.1l85.7 85.7c7.9 7.9 20.6 7.9 28.5 0 7.9-7.8 7.9-20.6 0-28.5zM287.1 347.2c-7.9-7.9-20.6-7.9-28.5 0l-85.7 85.7V80.1c0-11.3-9.1-20.4-20.4-20.4-11.3 0-20.4 9.1-20.4 20.4v352.8l-85.7-85.7c-7.9-7.9-20.6-7.9-28.5 0-7.9 7.9-7.9 20.6 0 28.5l120.4 120.4c7.9 7.9 20.6 7.9 28.5 0l120.4-120.4c7.8-7.9 7.8-20.7-.1-28.5z"/></svg>
              </button></div>
          </div>
          <?php
          if($dia=='06' and $mess=='07'){
            $dia = 31;
            $mess = $mess-1;
            if($mess<10){
              $mess = '0'.$mess;
            }
          }

           //$dias = 31; ?>
          @for($i = $dia-1; $i>=1; $i--)
            <div class="products-row" style="border: 1px solid #DAD9D9">
              <button class="cell-more-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
              </button>
                <div class="product-cell image">
                  <?php
                    if($i>9){
                      $day = $i;
                    }else{
                      $day = '0'.$i;
                    }

                    $fecha = $ano.$mess.$day;

                    $reporte = DB::table('report')
                    ->where('fecha',$fecha)
                    ->where('cliente',$centrodecosto_id)
                    ->first();
                  ?>
                  <span style="color: black">{{$fecha}}</span>
                </div>
              <div class="product-cell category"><span class="cell-label">Category:</span><span style="color: black">
                @if(isset($reporte->created_at))
                  {{$reporte->fecha_created}}
                @else

                @endif
              </span></div>

              <div class="product-cell sales"><span class="cell-label">Sales:</span><span style="color: black">@if(isset($reporte->created_at))
                {{$reporte->hora_created}}
              @else

              @endif</span></div>
              @if($reporte!=null)

                @if($reporte->descargado!=1)
                  <div class="product-cell status-cell">
                    <span class="cell-label">Status:</span>
                    <span style="background: green; color: white; width: 100px" class="status active">Enviado</span>
                  </div>
                @else
                  <div class="product-cell status-cell">
                    <span class="cell-label">Status:</span>
                    <span style="width: 100px" class="status active">Descargado</span>
                  </div>
                @endif
              @else
                <div class="product-cell status-cell">
                  <span class="cell-label">Status:</span>
                  <span style="background: red; color: white; width: 100px" class="status active">No Enviado</span>
                </div>
              @endif
              <div class="product-cell stock"><span class="cell-label">Stock:</span><span style="color: black">
                  @if($id==287)
                    {{'BOGOTÁ'}}
                  @elseif($id==489)
                    {{'BOGOTÁ'}}
                  @else
                    {{'BARRANQUILLA'}}
                  @endif
              </span></div>
              <div class="product-cell price"><span class="cell-label">Price:</span><span style="color: black"></span>
                <form class="form-inline" id="form_buscar" action="{{url('portalusu/exportarlistadonovedades')}}" method="post">

                  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 hidden">
                      <div class="input-group">
                        <div class="input-group date" id="datetimepicker1">
                            <input value="ra" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                        </div>
                      </div>
                  </div>
                  <input type="text" name="cc" value="{{$cc}}" class="hidden">
                  <input type="text" name="id_cliente" value="ra" class="hidden">
                  @if($id==287)
                    <a href="{{url('facturacion/revisionnovedadesbogota/'.$fecha)}}" type="submit" class="btn btn-primary btn-icon input-font">Ver<i class="fa fa-eye icon-btn"></i></a>
                  @elseif($id==489)
                    <a href="{{url('facturacion/revisionnovedadesigt/'.$fecha)}}" type="submit" class="btn btn-primary btn-icon input-font">Ver<i class="fa fa-eye icon-btn"></i></a>
                  @else
                    <a href="{{url('facturacion/revisionnovedadesbarranquilla/'.$fecha)}}" type="submit" class="btn btn-primary btn-icon input-font">Ver<i class="fa fa-eye icon-btn"></i></a>
                  @endif
                </form>
              </div>
            </div>
          @endfor

        </div>
      </div>
    </div>
  </div>
</div>

<!--Modal QR-->
<div class="modal fade" tabindex="-1" role="dialog" id='modal_qr'>
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Codigo QR</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12" align="center">
              <img id="imagen_qr">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@include('scripts.scripts')
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/pasajerosv2.js')}}"></script>
<script type="text/javascript">
    function goBack(){
        window.history.back();
    }

    $('#query').click(function(e){ //Obtener access token

      var mes = $(this).attr('data-mes');
      var cliente = $(this).attr('data-cliente');

      console.log('mes : '+mes)


      if(cliente==19){
        var ciudad = 'BARRANQUILLA';
      }else{
        var ciudad = 'BOGOTÁ';
      }

      console.log('cliente : '+cliente)

      $.confirm({
          title: 'Generando Dashboard',
          content: '¿Estás seguro de generar este reporte?',
          buttons: {
              confirm: {
                  text: 'Si!',
                  btnClass: 'btn-success',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: '../../reportes/query',
                      method: 'post',
                      data: {foto_id: 123, mes: mes, cliente: cliente, ciudad: ciudad}
                    }).done(function(data){

                      if(data.respuesta==true){
                        alert('Success!!!')
                      }else if(data.respuesta==false){

                      }

                    });

                  }

              },
              cancel: {
                text: 'Volver',
              }
          }
      });

    });

    $pass = $('#passss').DataTable( {
        "order": [[ 0, "asc" ]],
        paging: false,

        language: {
          processing:     "Procesando...",
          lengthMenu:    "Mostrar _MENU_ Registros",
          info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
          infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
          infoFiltered:   "(Filtrando de _MAX_ registros en total)",
          infoPostFix:    "",
          loadingRecords: "Cargando...",
          zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
          emptyTable:     "NINGUN REGISTRO DISPONIBLE EN LA TABLA",
          paginate: {
            first:      "Primer",
            previous:   "Antes",
            next:       "Siguiente",
            last:       "Ultimo"
          },
          aria: {
            sortAscending:  ": activer pour trier la colonne par ordre croissant",
            sortDescending: ": activer pour trier la colonne par ordre décroissant"
          }
        },
        'bAutoWidth': false,
        'aoColumns' : [
          { 'sWidth': '1%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '4%' },
          { 'sWidth': '1%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '1%' },
          { 'sWidth': '1%' },
          { 'sWidth': '4%' },
          { 'sWidth': '3%' },
        ],
      });

      $('.meses').change(function(){

        var mes = $(this).val();
        var mesText = $('.meses option:selected').attr('data-mes');
        var cliente =$('#client').val();

        //alert(mes)
        //alert(mesText)

        $.ajax({
          url: '../../reportes/filtro',
          method: 'post',
            data: {mes: mes, mesText: mesText, cliente: cliente}
        }).done(function(data){

          if(data.respuesta==true){

            if(data.dashboard!=null){
              $('.enviado').removeClass('hidden').attr('href','https://app.aotour.com.co/autonet/reportes/dash/'+data.dashboard.id+'');
              $('.por_enviar').addClass('hidden');
            }else{
              $('.enviado').addClass('hidden').removeAttr('href');
              $('.por_enviar').removeClass('hidden');
              if(data.actual==='off'){
                $('.por_enviar').removeAttr('disabled');
              }else{
                $('.por_enviar').attr('disabled', 'disabled');
              }
            }

            //table
            $('.products-row').html('').removeAttr('style');

            var $json = data.arrayDias;

            for(var i in $json) {

              console.log($json[i].fecha)

              var htmlCode = '';

              if($json[i].estado!='NO ENVIADO'){

                if($json[i].estado!=null){

                  var estado = '<div class="product-cell status-cell">'+
                    '<span class="cell-label">Status:</span>'+
                    '<span style="background: green; color: white; width: 100px" class="status active">Enviado</span>'+
                  '</div>';

                }else{

                  var estado = '<div class="product-cell status-cell">'+
                    '<span class="cell-label">Status:</span>'+
                    '<span style="width: 100px" class="status active">Descargado</span>'+
                  '</div>';
                }

              }else{

                var estado = '<div class="product-cell status-cell">'+
                  '<span class="cell-label">Status:</span>'+
                  '<span style="background: red; color: white; width: 100px" class="status active">No Enviado</span>'+
                '</div>';

              }

              var urls = 'https://app.aotour.com.co/autonet/facturacion/'+$json[i].link;

              htmlCode +='<div class="products-row" style="border: 1px solid #DAD9D9">'+
                '<button class="cell-more-button">'+
                  '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>'+
                '</button>'+
                  '<div class="product-cell image">'+
                    '<span style="color: black">'+
                    $json[i].fecha+
                    '</span>'+
                  '</div>'+
                '<div class="product-cell category"><span class="cell-label">Category:</span><span style="color: black">'+
                  $json[i].fecha_envio+
                '</span></div>'+
                '<div class="product-cell sales"><span class="cell-label">Sales:</span><span style="color: black">'+
                  $json[i].hora_envio+
                '</span></div>'+
                  estado+
                '<div class="product-cell stock"><span class="cell-label">Stock:</span><span style="color: black">'+
                    $json[i].ciudad+
                '</span></div>'+
                '<div class="product-cell price"><span class="cell-label">Price:</span><span style="color: black"></span>'+
                  '<form class="form-inline" id="form_buscar" action="{{url('portalusu/exportarlistadonovedades')}}" method="post">'+

                    '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 hidden">'+
                        '<div class="input-group">'+
                          '<div class="input-group date" id="datetimepicker1">'+
                              '<input value="ra" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">'+
                              '<span class="input-group-addon">'+
                                  '<span class="fa fa-calendar">'+
                                  '</span>'+
                              '</span>'+
                          '</div>'+
                        '</div>'+
                    '</div>'+
                    '<input type="text" name="cc" value="'+data.cc+'" class="hidden">'+
                    '<input type="text" name="id_cliente" value="ra" class="hidden">'+
                      '<a href="'+urls+'" type="submit" class="btn btn-primary btn-icon input-font">Ver<i class="fa fa-eye icon-btn"></i></a>'+
                  '</form>'+
                '</div>'+
              '</div>';


              $('.tableView').append(htmlCode);
              //console.log(htmlCode)

            }

            //$('#sin_datos').addClass('hidden');

          }else if(data.respuesta==false){

            $('.products-row').html('').removeAttr('style');

          }

        });

      });

</script>
</body>
</html>
