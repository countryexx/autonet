<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Reporte de Novedades</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link href="https://assets.codepen.io/344846/style.css" rel="stylesheet"><link rel="stylesheet" href="./style.css">
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
      display: absolute;
      flex-direction: column;

      &-header {
        display: flex;
        align-items: right;
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
              width: 14px;
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
      border-radius: 2px;
      height: 32px;
      width: 65px;
      background-color: white;
      border: 3px solid var(--app-content-secondary-color);
      display: flex;
      align-items: center;
      color:  var(--app-content-secondary-color);
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

      .action-button-t {
        border-radius: 2px;
        height: 32px;
        background-color: white;
        border: 3px solid var(--app-content-secondary-color);
        display: flex;
        align-items: center;
        color: black;
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
        border-radius: 2px;
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

        /*border-radius: 4px;
        height: 32px;
        background-color: white;
        border: 2px solid var(--app-content-secondary-color);
        display: flex;
        align-items: center;
        color: black;
        font-size: $font-small;
        margin-left: 8px;
        cursor: pointer;*/

      height: 32px;
      border-radius: 2px;
      font-size: 12px;
      padding: 4px 8px;
      cursor: pointer;
      border: none;
      color: #fff;

      &.apply {
        /*background-color: #BEBEBE;*/
        background-color: white;
        border: 3px solid;
        color: black;
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
          background-color: #BEBEBE;
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
        background-color: white;
        color: white;

        &:before {
          font-weight: bold;
          padding: 4px;
          background-color: green;
          animation-name: parpadeo;
          animation-duration: 1s;
          animation-timing-function: linear;
          animation-iteration-count: infinite;

          -webkit-animation-name:parpadeo;
          -webkit-animation-duration: 1s;
          -webkit-animation-timing-function: linear;
          -webkit-animation-iteration-count: infinite;
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

      div.inline { float:left; }
    </style>
</head>
<body>

@include('admin.menu')

<?php
  $mess = date('m');
  $ano = date('Y');
?>
<div >

  @if(1>0)
  <div class="app-content" style="width: 100%">
    <div class="app-content-header" >
      <div class="row" style="margin-bottom: 20px">
        <div class="col-lg-2">
          <div class="product-cell status-cell" style="margin-top: 15px; margin-left: 10px">
            <span style="width: 175px; background: #f47321; font-size: 15 px" class="status inactive" id="seen">Estás viendo JUNIO</span>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="product-cell status-cell" style="margin-top: 15px; margin-left: 10px;">
            <span style="width: 380px; background: #f47321; color: white" class="status active hidden" id="sin_datos" style="font-size: 17px"></span>
          </div>
        </div>
        <div class="col-lg-4">



        </div>
        <div class="col-lg-2">
          <div class="sidebar" style="float: right">
              <div class="app-icon">
                <img src="{{url('img/igt.png')}}" alt="">
              </div>
            </div>
        </div>
      </div>

      <br><br>
      <button class="mode-switch" title="Switch Theme">
        <svg class="moon" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="24" height="24" viewBox="0 0 24 24">
          <defs></defs>
          <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
        </svg>
      </button>



    </div>
    <div class="app-content-actions" style="margin-top: -120px;">
      <!--<input class="search-bar" placeholder="Search..." type="text">-->
      <div class="app-content-actions-wrapper" style="height: 100%">
        <div class="filter-button-wrapper" style="height: 100%">
          <div class="row">
            <div class="col-lg-12">

              <div class="inline">
                <button id="menus" class="action-button filter jsFilter"><span style="margin-left: 6px">Filtro</span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-filter"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg></button>
              </div>
              <!--<div class="inline">
                <div class="action-button-t">
                    <label style="color: var(--app-content-secondary-color); margin-top: 4px">Ciudad</label>
                    <select style="float: right; width: 100%;" id="city">
                      <option>Seleccionar</option>
                      <option>Bogotá</option>
                      <option>Barranquilla</option>
                    </select>
                  </div>
              </div>-->
              <div class="inline">
                <div class="action-button-t" style="width: 95%">
                  <label style="color: var(--app-content-secondary-color); margin-top: 4px" class="ano">Año</label>
                  <select class="ano" style="width: 100%;" id="anos">
                    <option @if($ano==2024){{'selected'}}@endif>2024</option>
                    <option @if($ano==2025){{'selected'}}@endif>2025</option>
                  </select>
                </div>
              </div>
              <div class="inline">
                <div class="action-button-t">
                  <label style="color: var(--app-content-secondary-color); margin-top: 4px" class="mes">Mes</label>
                  <select class="mes"  style="width: 100%;" id="meses">
                    <option value="01" @if($mess==1){{'selected'}}@endif>Enero</option>
                    <option value="02" @if($mess==2){{'selected'}}@endif>Febrero</option>
                    <option value="03" @if($mess==3){{'selected'}}@endif>Marzo</option>
                    <option value="04" @if($mess==4){{'selected'}}@endif>Abril</option>
                    <option value="05" @if($mess==5){{'selected'}}@endif>Mayo</option>
                    <option value="06" @if($mess==6){{'selected'}}@endif>Junio</option>
                    <option value="07" @if($mess==7){{'selected'}}@endif>Julio</option>
                    <option value="08" @if($mess==8){{'selected'}}@endif>Agosto</option>
                    <option value="09" @if($mess==9){{'selected'}}@endif>Septiembre</option>
                    <option value="10" @if($mess==10){{'selected'}}@endif>Octubre</option>
                    <option value="11" @if($mess==11){{'selected'}}@endif>Noviembre</option>
                    <option value="12" @if($mess==12){{'selected'}}@endif>Diciembre</option>
                  </select>
                </div>
              </div>
              <div class="inline">
                <button class="action-button apply" style="width: 100%">
                  <span style="margin-left: 4px">Buscar <i style="float: 3px; margin-left: 6px" class="fa fa-search" aria-hidden="true"></i></span>
                </button>
              </div>
              <div class="inline">

                <a style="margin-left: 30px" type="button" class="btn btn-primary btn-icon input-font download">DESCARGAR DÍAS SELECCIONADOS<i class="fa fa-check icon-btn"></i></a>



              </div>
              <div class="inline hidden formu">
                <form class="form-inline" id="form_buscar" action="{{url('portalusu/descargarselect')}}" method="post">

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
                  <input type="text" name="fechas" value="" class="hidden fechas">
                  <input type="text" name="ciudad" value="" class="hidden ciudad">
                  <button type="submit" style="margin-left: 30px" class="btn btn-success btn-icon input-font">DESCARGAR EXCEL<i class="fa fa-download icon-btn"></i></button>
                </form>
              </div>
            </div>

          </div>

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

    <!-- Datatables -->
    <table id="example_table" class="table table-bordered hover tabla" cellspacing="0" width="100%">
      <thead>
        <tr style="background-color: var(--app-content-secondary-color);">
          <td style="text-align: center; color: white" class="h4 text-center mt-3 mb-4 pb-3">#</td>
          <td style="text-align: center; color: white" class="h4 text-center mt-3 mb-4 pb-3">Descarga Múltiple<br><center><input style="width: 15px; height: 15px;" class="select_all" type="checkbox" check="false"></center>Select All</td>
          <td style="text-align: center; color: white" class="h4 text-center mt-3 mb-4 pb-3">Fecha de Reporte</td>
          <td style="text-align: center; color: white" class="h4 text-center mt-3 mb-4 pb-3"> Fecha de Envío </td>
          <td style="text-align: center; color: white" class="h4 text-center mt-3 mb-4 pb-3"> Enviado Por </td>
          <td style="text-align: center; color: white" class="h4 text-center mt-3 mb-4 pb-3"> Estado </td>
          <td style="text-align: center; color: white" class="h4 text-center mt-3 mb-4 pb-3"> Ciudad </td>
          <td style="text-align: center; color: white" class="h4 text-center mt-3 mb-4 pb-3"> Descargar </td>
        </tr>
      </thead>
      <tbody>
        <?php $o = 1; ?>
        @foreach($reportes as $reporte)
          <tr>
            <th style="font-weight: normal;"><center>{{$o}}</center></th>
            <th style="font-weight: normal; color: black">
              <center>
                  <input class="clients" data-fecha="{{$reporte->fecha}}" data-id="{{$reporte->id}}" style="width: 15px; height: 15px;" type="checkbox" check="false">
              </center>
            </th>

            <th style="font-weight: normal; color: black">
              <center>{{$reporte->fecha}}</center>
            </th>

            <th style="text-align: center; font-weight: normal; color: black">
              {{$reporte->fecha_created}}
            </th>

            <th style="font-weight: normal; color: black">
              <center>
              {{$reporte->first_name}} {{$reporte->last_name}}
              </center>
            </th>

            <th style="text-align: center; font-weight: normal; color: black">
              @if($reporte->descargado==1)
                <center><div class="product-cell status-cell">
                  <span style="background: green; color: white; width: 120px" class="status active">Descargado</span>
                </div></center>
              @else
              <center>
                <div class="product-cell status-cell">
                  <span style="background: red; color: white; width: 120px" class="status active">No Descargado</span>
                </div>
              </center>
              @endif
            </th>

            <th style="text-align: center; font-weight: normal; color: black">
              {{$reporte->ciudad}}
            </th>

            <th><center>
              <form class="form-inline" id="form_buscar" action="{{url('portalusu/exportarlistadonovedades')}}" method="post">

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 hidden">
                    <div class="input-group">
                      <div class="input-group date" id="datetimepicker1">
                          <input value="{{$reporte->fecha}}" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">
                          <span class="input-group-addon">
                              <span class="fa fa-calendar">
                              </span>
                          </span>
                      </div>
                    </div>
                </div>
                <input type="text" name="cc" value="{{$cc}}" class="hidden">
                <input type="text" name="id_reporte" value="{{$reporte->id}}" class="hidden">

                <button type="submit" class="btn btn-success btn-icon input-font">EXCEL<i class="fa fa-download icon-btn"></i></button>
              </form></center>
            </th>
          </tr>
          <?php $o++; ?>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
        <tr>
          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">#</td>
          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Descarga Múltiple</td>
          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Fecha de Reporte</td>
          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Fecha de Envío </td>
          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Enviado Por </td>
          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Estado </td>
          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Ciudad </td>
          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Descargar </td>
        </tr>
      </tfoot>
    </table>
    <!-- Datatables -->
  </div>
  @else
  <div class="row">

    <div class="col-lg-12">
      <img style="height: 120px; width: 390px; margin-top: 50px; margin-left: 20px" src="{{url('img/under.png')}}" alt="">
    </div>

    <div class="col-lg-12" style="margin-top: 70px">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="jumbotron" style="padding-left: 48px; padding-right: 48px">
                    <h1></h1>
                    <p>Estamos trabajando de acuerdo a los cambios que solicitaste.</p>
                    <p>¡Pronto serás notificado!</p>
                </div>
            </div>


        </div>
    </div>
  </div>
  @endif
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
<script src="{{url('jquery/pasajerosv2.js')}}"></script>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <script>
    const setup = () => {
      const getTheme = () => {
        if (window.localStorage.getItem('dark')) {
          return JSON.parse(window.localStorage.getItem('dark'))
        }
        return !!window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
      }

      const setTheme = (value) => {
        window.localStorage.setItem('dark', value)
      }

      return {
        loading: true,
        isDark: getTheme(),
        toggleTheme() {
          this.isDark = !this.isDark
          setTheme(this.isDark)
        },
      }
    }
  </script>
<script type="text/javascript">
    function goBack(){
        window.history.back();
    }

    $('#menus').click(function() {

      if($('.menus').hasClass('hidden')){
        $('.menus').removeClass('hidden');
      }else{
        $('.menus').addClass('hidden');
      }

    });

    $('#city').change(function(){

      var dataCiudad = $(this).val();
      //alert(dataCiudad);

      if(dataCiudad=='Barranquilla') {

        $('.sede').removeClass('hidden');

        $('.baq').removeClass('hidden')
        $('.bog').addClass('hidden')
        $('.bog').addClass('hidden')

        $('.ano').removeClass('hidden')
        $('.mes').removeClass('hidden')
        $('.ciudad').val(dataCiudad)

      }else if(dataCiudad=='Bogotá') {

        $('.sede').removeClass('hidden');

        $('.baq').addClass('hidden')
        $('.bog').removeClass('hidden')
        $('.bog').removeClass('hidden')

        $('.ano').removeClass('hidden')
        $('.mes').removeClass('hidden')
        $('.ciudad').val(dataCiudad)

      }else{

        $('.sede').addClass('hidden');
        $('.ano').addClass('hidden');
        $('.mes').addClass('hidden');

        $('.ano').addClass('hidden')
        $('.mes').addClass('hidden')
        $('.ciudad').val('')
      }

    });

    $('.apply').click(function() {

      var ciudad = $('#city option:selected').val();
      var sedes = $('#sedes option:selected').val();
      var ano = $('#anos option:selected').val();
      var mes = $('#meses').val();
      var month = $('#meses option:selected').html();

      $tablenovedades.clear().draw();

      $.ajax({
        url: '../reportes/filtrarmes',
        method: 'post',
        data: {ciudad: ciudad, sedes: sedes, ano: ano, mes: mes}
      }).done(function(data){


        $('#seen').html('Estás viendo '+month.toUpperCase())
        $('.menus').addClass('hidden');

        if(data.respuesta=='sesion_caducada'){

          $.confirm({
            title: '¡Atención!',
            content: 'La sesión ha caducado...<br><br>Serás redirigido al login para volver a iniciar sesión!',
            buttons: {
                confirm: {
                    text: 'Ok',
                    btnClass: 'btn-danger',
                    keys: ['enter', 'shift'],
                    action: function(){
                      location.href = "/autonet";
                    }

                }
            }

          });

        }else if(data.respuesta==true){

          $('.products-row').html('').removeAttr('style');

          for(var i in data.reportes) {

            var htmlCode = '';

            if(data.reportes[i].descargado==1){

              var part1 = '<div class="product-cell status-cell">'+
                            '<span style="background: green; color: white; width: 120px" class="status active">Descargado</span>'+
                          '</div>';

            }else{

              var part1 = '<div class="product-cell status-cell">'+
                            '<span style="background: red; color: white; width: 120px" class="status active">No Descargado</span>'+
                          '</div>';
            }

            var created = '';

            if(data.reportes[i].fecha_created!=null){
              created = data.reportes[i].fecha_created;
            }
            htmlCode +='<div class="products-row" style="border: 1px solid #DAD9D9;">'+
                '<div class="product-cell image">'+
                  '<span style="color: black">'+data.reportes[i].fecha+'</span>'+
                '</div>'+
                '<div class="product-cell image">'+
                  '<span style="color: black">'+data.reportes[i].fecha_fin+'</span>'+
                '</div>'+
              '<div class="product-cell category"><span class="cell-label">Category:</span><span style="color: black">'+created+'</span></div>'+

              '<div class="product-cell sales"><span class="cell-label">Sales:</span><span style="color: black">'+data.reportes[i].first_name+' '+data.reportes[i].last_name+'</span></div>'+
              ''+part1+''+
              '<div class="product-cell stock"><span class="cell-label">Stock:</span><span style="color: black">'+data.reportes[i].ciudad.toUpperCase ()+'</span></div>'+
              '<div class="product-cell price"><span class="cell-label">Price:</span><span style="color: black"></span>'+
                '<form class="form-inline" id="form_buscar" action="https://app.aotour.com.co/autonet/portalusu/exportarlistadonovedades" method="post">'+

                  '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 hidden">'+
                      '<div class="input-group">'+
                        '<div class="input-group date" id="datetimepicker1">'+
                            '<input value="'+data.reportes[i].created_at+'" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">'+
                            '<span class="input-group-addon">'+
                                '<span class="fa fa-calendar">'+
                                '</span>'+
                            '</span>'+
                        '</div>'+
                      '</div>'+
                  '</div>'+
                  '<input type="text" name="cc" value="'+data.cc+'" class="hidden">'+
                  '<input type="text" name="id_reporte" value="'+data.reportes[i].id+'" class="hidden">'+
                  '<button type="submit" class="btn btn-success btn-icon input-font">EXCEL<i class="fa fa-download icon-btn"></i></button>'+
                '</form>'+
              '</div>'+
            '</div>';

            //$('.tableView').append(htmlCode);
            //console.log(htmlCode)

            /*filtro datatable*/

            var excel = '<center><form class="form-inline" id="form_buscar" action="https://app.aotour.com.co/autonet/portalusu/exportarlistadonovedades" method="post">'+

              '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 hidden">'+
                  '<div class="input-group">'+
                    '<div class="input-group date" id="datetimepicker1">'+
                        '<input value="'+data.reportes[i].created_at+'" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">'+
                        '<span class="input-group-addon">'+
                            '<span class="fa fa-calendar">'+
                            '</span>'+
                        '</span>'+
                    '</div>'+
                  '</div>'+
              '</div>'+
              '<input type="text" name="cc" value="'+data.cc+'" class="hidden">'+
              '<input type="text" name="id_reporte" value="'+data.reportes[i].id+'" class="hidden">'+
              '<button type="submit" class="btn btn-success btn-icon input-font">EXCEL<i class="fa fa-download icon-btn"></i></button>'+
            '</form></center>';

            var checkBox = '<center><input data-fecha="'+data.reportes[i].fecha+'" data-id="'+data.reportes[i].id+'" class="clients" data-id="" data-traslado="" data-auto="" data-van="" style="width: 15px; height: 15px;" type="checkbox" check="false"></center>'

            $tablenovedades.row.add([
              '<center>'+(parseInt(i)+1)+'</center>',
              '<center>'+checkBox+'</center>',
              '<center>'+data.reportes[i].fecha+'</center>',
              '<center>'+data.reportes[i].fecha_created+'</center>',
              '<center>'+data.reportes[i].first_name+' '+data.reportes[i].last_name+'</center>',
              '<center>'+part1+'</center>',
              '<center>'+data.reportes[i].ciudad.toUpperCase()+'</center>',
              excel,
              //descargado,
              //opt
            ]).draw();

            /*filtro datatable*/

          }

          $('#sin_datos').addClass('hidden');

        }else if(data.respuesta==false){

          $('.products-row').html('');

          //$('#sin_datos').removeClass('hidden');
          //$('#sin_datos').html('Oops! Parece que no hay datos en el mes seleccionado.');

          $.confirm({
            title: '¡Atención!',
            content: 'No se encontraron registros en los parametros filtrados',
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

        }

      });

    });

    $tablenovedades = $('#example_table').DataTable( {
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
            { 'sWidth': '2%' },
            { 'sWidth': '4%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
          ],
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

      $('.select_all').change(function(e){

          if ($(this).is(':checked')) {
              $('#example_table tbody tr').each(function(index){
                  $(this).children("td").each(function (index2){
                      switch (index2){
                          case 1:

                              $(this).find('input[type="checkbox"]').prop('checked',true).attr('check',true);

                          break;
                      }
                  });
              });
          }else if(!$(this).is(':checked')){
              $('#example_table tbody tr').each(function(index){
                  $(this).children("td").each(function (index2){
                      switch (index2){
                          case 1:

                              $(this).find('input[type="checkbox"]').prop('checked',false).attr('check',false);

                          break;
                      }
                  });
              });
          }

          var idArray = [];
      		var fecha = [];

      		$('#example_table tbody tr').each(function(index){

      			var valorCheckbox = $(this).find('td input[type="checkbox"]').attr('check');

            $(this).children("td").each(function (index2){
      					var valorCheckbox2 = $(this).find('input[type="checkbox"]').attr('check');

                switch (index2){
                    case 1:
                        var $objeto = $(this).find('.clients');

                        if ($objeto.is(':checked')) {
                            idArray.push($objeto.attr('data-id'));
      											fecha.push($objeto.attr('data-fecha'));
                        }

                    break;
                }
            });

          });

          //$('.fechas').val(fecha)

      });

      $('.download').click(function(e){

        var idArray = [];
    		var fecha = [];
        var cont = 0;
        e.preventDefault();

    		$('#example_table tbody tr').each(function(index){

    			var valorCheckbox = $(this).find('td input[type="checkbox"]').attr('check');

          $(this).children("td").each(function (index2){
    					var valorCheckbox2 = $(this).find('input[type="checkbox"]').attr('check');

              switch (index2){
                  case 1:
                      var $objeto = $(this).find('.clients');

                      if ($objeto.is(':checked')) {
                          idArray.push($objeto.attr('data-id'));
    											fecha.push($objeto.attr('data-fecha'));
                          cont++
                      }

                  break;
              }
          });

        });

        console.log(fecha)
        $('.fechas').val(fecha)
        var ciudad = $('#city').val();
        var mes = '';

        if(cont>0){
          $('.formu').removeClass('hidden');
        }else{
          $('.formu').addClass('hidden');
        }

        /*$.ajax({
          url: '../portalusu/descargarselect',
          method: 'post',
          data: {fecha: fecha, idArray: idArray, ciudad: ciudad, mes: mes}
        }).done(function(data){

          if(data.respuesta=='sesion_caducada'){

            $.confirm({
              title: '¡Atención!',
              content: 'La sesión ha caducado...<br><br>Serás redirigido al login para volver a iniciar sesión!',
              buttons: {
                  confirm: {
                      text: 'Ok',
                      btnClass: 'btn-danger',
                      keys: ['enter', 'shift'],
                      action: function(){
                        location.href = "/autonet";
                      }

                  }
              }

            });

          }else if(data.respuesta==true){

            $('.products-row').html('').removeAttr('style');

            for(var i in data.reportes) {



            }

          }else if(data.respuesta==false){

            $.confirm({
              title: '¡Atención!',
              content: 'No se encontraron registros en los parametros filtrados',
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

          }

        });*/

      });

</script>
</body>
</html>
