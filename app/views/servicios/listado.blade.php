<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Listado de Cotizaciones</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
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
      border-radius: 2px;
      height: 32px;
      width: 65px;
      background-color: white;
      border: 1px solid #f47321;
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
        background-color: #f47321;
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

      .action-button-t {
        border-radius: 2px;
        height: 32px;
        background-color: white;
        border: 1px solid #f47321;
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

      div.inline { float:left; }
    </style>

</head>
<body>

@include('admin.menu')

  <?php
    $mess = date('m');
    $ano = date('Y');
    $dia = date('d');

  ?>

<div class="container-fluid" style="height: 85%;">
  <div class="col-xs-12">
    <div class="col-lg-12">
      <ol style="margin-bottom: 5px" class="breadcrumb">
        <li><a href="{{url('cotizaciones/listado')}}">Cotizaciones</a></li>
        <li><a href="{{url('cotizaciones')}}">Crear Cotización</a></li>
      </ol>
    </div>

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

              <div class="filter-button-wrapper">

                    <div class="inline">
                      <div class="action-button-t">
                          <label style="color: var(--app-content-secondary-color); margin-top: 4pxmargin-right: 5px; border-right: 1px solid #f47321; padding: 12px 2px -3px 0; line-height: 8px; margin-left: 4px; margin-top: 3px"><p style="margin-right: 5px; margin-top: 12px"> F. Inicial </p></label>
                          <div class='input-group date' id='datetime_fecha'>
                              <input id="fecha_inicial" name="fecha_pago" style="width: 80px; height: 30px" type='text' class="form-control input-font" placeholder="Fecha" value="{{date('Y-m-d')}}">
                              <span class="input-group-addon" style="height: 15px">
                                  <span class="fa fa-calendar">
                                  </span>
                              </span>
                          </div>
                        </div>
                    </div>

                    <div class="inline">
                      <div class="action-button-t">
                          <label style="color: var(--app-content-secondary-color); margin-top: 4pxmargin-right: 5px; border-right: 1px solid #f47321; padding: 12px 2px -3px 0; line-height: 8px; margin-left: 4px; margin-top: 3px"><p style="margin-right: 5px; margin-top: 12px"> F. Final </p></label>
                          <div class='input-group date' id='datetime_fecha2'>
                              <input id="fecha_final" name="fecha_pago" style="width: 80px; height: 30px" type='text' class="form-control input-font" placeholder="Fecha" value="{{date('Y-m-d')}}">
                              <span class="input-group-addon" style="height: 15px">
                                  <span class="fa fa-calendar">
                                  </span>
                              </span>
                          </div>
                        </div>
                    </div>

                    <div class="inline">
                      <div class="action-button-t">
                          <label style="color: var(--app-content-secondary-color); margin-top: 4pxmargin-right: 5px; border-right: 1px solid #f47321; padding: 12px 2px -3px 0; line-height: 8px; margin-left: 4px; margin-top: 3px"><p style="margin-right: 5px; margin-top: 12px"> Cliente </p></label>
                          <select style="float: right; width: 100%; margin-right: 6px; height: 70%; margin-left: 6px" id="cliente">
                            <option value="0">Seleccionar Cliente</option>
                            @foreach($centrosdecosto as $centro)
                              <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>

                    <div class="inline">
                      <div class="action-button-t">
                          <label style="color: var(--app-content-secondary-color); margin-top: 4pxmargin-right: 5px; border-right: 1px solid #f47321; padding: 12px 2px -3px 0; line-height: 8px; margin-left: 4px; margin-top: 3px"><p style="margin-right: 5px; margin-top: 12px"> Estado </p></label>
                          <select style="float: right; width: 100%; margin-right: 6px; height: 70%; margin-left: 6px" id="estado">
                            <option value="0">Seleccionar</option>
                            <option value="2">Negociando</option>
                            <option value="1">Aprobada</option>
                            <option value="3">Rechazada</option>
                            <option value="4">Vencida</option>
                            <option value="5">Sin Gestión</option>
                          </select>
                        </div>
                    </div>

                    <div class="inline">
                      <div class="action-button-t">
                          <label style="color: var(--app-content-secondary-color); margin-top: 4pxmargin-right: 5px; border-right: 1px solid #f47321; padding: 12px 2px -3px 0; line-height: 8px; margin-left: 4px; margin-top: 3px"><p style="margin-right: 5px; margin-top: 12px"> Usuario </p></label>
                          <select style="float: right; width: 100%; margin-right: 6px; height: 70%; margin-left: 6px" id="usuario">
                            <option value="0">Todos los usuarios</option>
                            @foreach($users as $user)
                              <option value="{{$user->id}}">{{$user->first_name.' '.$user->last_name}}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>

                    <div class="inline">
                      <button class="action-button apply" style="width: 100%">
                        <span style="margin-left: 4px"> <p style="margin-top: 10px"> Buscar <span style="border-right: 1px solid #f47321; padding: 5px 4px 6px 0; margin-right: 5px"></span> <i style="margin-left: 5px;" class="fa fa-search" aria-hidden="true"></i></p> </span>
                      </button>
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
        <br><br>

        <!-- Datatables -->
        <table id="example_table" class="table table-bordered hover tabla" cellspacing="0" width="100%">
          <thead>
            <tr>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">#</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Consecutivo</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Cliente</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Asunto</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Fecha de Solicitud</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Fecha de Creación</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Fecha de Envío </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Vence el </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Usuario </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Estado </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Descargado </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Opciones </td>
            </tr>
          </thead>
          <tbody>
            <?php $o = 1; ?>
            @foreach($cotizaciones as $cotizacion)
              <tr>
                <th style="font-weight: normal;"><center>{{$o}}</center></th>
                <th style="font-weight: normal; color: black">
                  <center>
                      00{{$cotizacion->id}}
                  </center>
                </th>

                <th style="font-weight: normal; color: black">
                  <center>{{$cotizacion->nombre_completo}}</center>
                </th>

                <th style="text-align: center; font-weight: normal; color: black">
                  {{$cotizacion->asunto}}
                </th>

                <th style="font-weight: normal; color: black">
                  <center>
                  {{$cotizacion->fecha_solicitud}}
                  </center>
                </th>

                <th style="text-align: center; font-weight: normal; color: black">
                  {{$cotizacion->fecha}}
                </th>

                <th style="text-align: center; font-weight: normal; color: black">
                  {{$cotizacion->fecha}}
                </th>

                <th style="text-align: center; font-weight: normal; color: black">
                  {{$cotizacion->fecha_vencimiento}}
                </th>

                <th style="text-align: center; font-weight: normal; color: black">
                  {{$cotizacion->vendedor}}
                </th>

                <th style="font-weight: normal; color: black">
                  <center>
                    @if(intval($cotizacion->estado)===0)
                      <span data-id="{{$cotizacion->id}}" style="background: green; color: white; width: 120px; font-weight: normal;" class="gestiones status active">Enviado </span>
                    @endif

                    @if(intval($cotizacion->estado)===1)
                      <span data-id="{{$cotizacion->id}}" style="background: green; color: white; width: 120px; font-weight: normal;" class="gestiones status active">(@if($cotizacion->cantidad_gestiones==null){{(0)}}@else{{$cotizacion->cantidad_gestiones}}@endif)Aprobado</span>
                    @endif

                    @if(intval($cotizacion->estado)===2)

                      <span data-id="{{$cotizacion->id}}" style="background: #f47321; color: white; width: 120px; font-weight: normal;" class="gestiones status active">(@if($cotizacion->cantidad_gestiones==null){{(0)}}@else{{$cotizacion->cantidad_gestiones}}@endif)Negociando </span>
                    @endif

                    @if(intval($cotizacion->estado)===3)
                      <span data-id="{{$cotizacion->id}}" style="background: red; color: white; width: 120px; font-weight: normal;" class="gestiones status active">(@if($cotizacion->cantidad_gestiones==null){{(0)}}@else{{$cotizacion->cantidad_gestiones}}@endif)Rechazado </span>
                    @endif

                    @if(intval($cotizacion->estado)===4)
                      <span data-id="{{$cotizacion->id}}" style="background: red; color: white; width: 120px; font-weight: normal;" class="gestiones status active">Vencido</span>
                    @endif

                    @if(intval($cotizacion->estado)===5)
                      <span data-id="{{$cotizacion->id}}" style="background: green; color: white; width: 120px; font-weight: normal;" class="gestiones status active">Sin Gestión</span>
                    @endif

                  </center>
                </th>
                <th>
                  @if($cotizacion->descargado==1)
                    <span style="background: green; color: white; width: 100px; font-weight: normal;" class="status active">Sí</span>
                  @else
                    <span style="background: red; color: white; width: 100px; font-weight: normal;" class="status active">No</span>
                  @endif
                </th>
                <th>

                    @if(1==287)
                      <a href="{{url('facturacion/revisionnovedadesbogota/'.$cotizacion->fecha)}}" type="submit" class="btn btn-primary btn-icon input-font">Ver<i class="fa fa-eye icon-btn"></i></a>
                    @else
                      <!--<a href="{{url('cotizaciones/detalles/'.$cotizacion->id)}}" class="btn btn-list-table btn-primary">VER <i class="fa fa-file-o" aria-hidden="true"></i></i></a>-->
                      <a target="_blank" href="{{url('biblioteca_imagenes/escolar/pdf/Cotizacion_Aotour_'.$cotizacion->id.'.pdf')}}" class="btn btn-list-table btn-primary">PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                      <!--<a style="margin-right: 10px;" target="_blank" data-id="" data-nombre="" class="btn btn-list-table btn-primary gestiones">Gestiones <i class="fa fa-refresh" aria-hidden="true"></i></i></a>-->
                      @if($cotizacion->estado!=3 and $cotizacion->estado!=1 and $cotizacion->estado!=4)
                        <a title="Registrar Aprobado" style="margin-right: 5px;" target="_blank" data-id="{{$cotizacion->id}}" data-nombre="" class="btn btn-list-table btn-success aprobada"><i class="fa fa-check" aria-hidden="true"></i></i></a>

                        <a title="Registrar Rechazado" style="margin-right: 5px;" target="_blank" data-id="{{$cotizacion->id}}" data-nombre="" class="btn btn-list-table btn-danger rechazada"><i class="fa fa-times" aria-hidden="true"></i></i></a>
                      @endif
                    @if($cotizacion->estado==3)
                      <a title="Reactivar Cotización" data-id="{{$cotizacion->id}}" class="btn btn-list-table btn-info reactivar" data-id=""><i class="fa fa-repeat" aria-hidden="true"></i></i></a>
                    @endif
                      <!--@if($cotizacion->estado==1)
                        <a title="Enviar a Operaciones" class="btn btn-list-table btn-success"><i class="fa fa-share" aria-hidden="true"></i></a>
                      @endif-->
                    @endif

                </th>
              </tr>
              <?php $o++; ?>
            @endforeach

            @foreach($otrascotizaciones as $cotizacion)
              <tr class="info">
                <th style="font-weight: normal;"><center>{{$o}}</center></th>
                <th style="font-weight: normal; color: black">
                  <center>
                      00{{$cotizacion->id}}
                  </center>
                </th>

                <th style="font-weight: normal; color: black">
                  <center>{{$cotizacion->nombre_completo}}</center>
                </th>

                <th style="text-align: center; font-weight: normal; color: black">
                  {{$cotizacion->asunto}}
                </th>

                <th style="font-weight: normal; color: black">
                  <center>
                  {{$cotizacion->fecha_solicitud}}
                  </center>
                </th>

                <th style="text-align: center; font-weight: normal; color: black">
                  {{$cotizacion->fecha}}
                </th>

                <th style="text-align: center; font-weight: normal; color: black">
                  {{$cotizacion->fecha}}
                </th>

                <th style="text-align: center; font-weight: normal; color: black">
                  {{$cotizacion->fecha_vencimiento}}
                </th>

                <th style="text-align: center; font-weight: normal; color: black">
                  {{$cotizacion->vendedor}}
                </th>

                <th style="font-weight: normal; color: black">
                  <center>
                    @if(intval($cotizacion->estado)===0)
                      <span data-id="{{$cotizacion->id}}" style="background: green; color: white; width: 120px; font-weight: normal;" class="gestiones status active">Enviado </span>
                    @endif

                    @if(intval($cotizacion->estado)===1)
                      <span data-id="{{$cotizacion->id}}" style="background: green; color: white; width: 120px; font-weight: normal;" class="gestiones status active">(@if($cotizacion->cantidad_gestiones==null){{(0)}}@else{{$cotizacion->cantidad_gestiones}}@endif)Aprobado</span>
                    @endif

                    @if(intval($cotizacion->estado)===2)

                      <span data-id="{{$cotizacion->id}}" style="background: #f47321; color: white; width: 120px; font-weight: normal;" class="gestiones status active">(@if($cotizacion->cantidad_gestiones==null){{(0)}}@else{{$cotizacion->cantidad_gestiones}}@endif)Negociando </span>
                    @endif

                    @if(intval($cotizacion->estado)===3)
                      <span data-id="{{$cotizacion->id}}" style="background: red; color: white; width: 120px; font-weight: normal;" class="gestiones status active">(@if($cotizacion->cantidad_gestiones==null){{(0)}}@else{{$cotizacion->cantidad_gestiones}}@endif)Rechazado </span>
                    @endif

                    @if(intval($cotizacion->estado)===4)
                      <span data-id="{{$cotizacion->id}}" style="background: red; color: white; width: 120px; font-weight: normal;" class="gestiones status active">Vencido</span>
                    @endif

                    @if(intval($cotizacion->estado)===5)
                      <span data-id="{{$cotizacion->id}}" style="background: green; color: white; width: 120px; font-weight: normal;" class="gestiones status active">Sin Gestión</span>
                    @endif

                  </center>
                </th>
                <th>
                  @if($cotizacion->descargado==1)
                    <span style="background: green; color: white; width: 100px; font-weight: normal;" class="status active">Sí</span>
                  @else
                    <span style="background: red; color: white; width: 100px; font-weight: normal;" class="status active">No</span>
                  @endif
                </th>
                <th>

                    @if(1==287)
                      <a href="{{url('facturacion/revisionnovedadesbogota/'.$cotizacion->fecha)}}" type="submit" class="btn btn-primary btn-icon input-font">Ver<i class="fa fa-eye icon-btn"></i></a>
                    @else
                      <!--<a href="{{url('cotizaciones/detalles/'.$cotizacion->id)}}" class="btn btn-list-table btn-primary">VER <i class="fa fa-file-o" aria-hidden="true"></i></i></a>-->
                      <a target="_blank" href="{{url('biblioteca_imagenes/escolar/pdf/Cotizacion_Aotour_'.$cotizacion->id.'.pdf')}}" class="btn btn-list-table btn-primary">PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                      <!--<a style="margin-right: 10px;" target="_blank" data-id="" data-nombre="" class="btn btn-list-table btn-primary gestiones">Gestiones <i class="fa fa-refresh" aria-hidden="true"></i></i></a>-->
                      @if($cotizacion->estado!=3 and $cotizacion->estado!=1 and $cotizacion->estado!=4)
                        <a title="Registrar Aprobado" style="margin-right: 5px;" target="_blank" data-id="{{$cotizacion->id}}" data-nombre="" class="btn btn-list-table btn-success aprobada"><i class="fa fa-check" aria-hidden="true"></i></i></a>

                        <a title="Registrar Rechazado" style="margin-right: 5px;" target="_blank" data-id="{{$cotizacion->id}}" data-nombre="" class="btn btn-list-table btn-danger rechazada"><i class="fa fa-times" aria-hidden="true"></i></i></a>
                      @endif
                    @if($cotizacion->estado==3)
                      <a title="Reactivar Cotización" data-id="{{$cotizacion->id}}" class="btn btn-list-table btn-info reactivar" data-id=""><i class="fa fa-repeat" aria-hidden="true"></i></i></a>
                    @endif
                      <!--@if($cotizacion->estado==1)
                        <a title="Enviar a Operaciones" class="btn btn-list-table btn-success"><i class="fa fa-share" aria-hidden="true"></i></a>
                      @endif-->
                    @endif

                </th>
              </tr>
              <?php $o++; ?>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
            <tr>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">#</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Consecutivo</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Cliente</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Asunto</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Fecha de Solicitud</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Fecha de Creación</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Fecha de Envío </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Vence el </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Usuario </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Estado </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Descargado </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Opciones </td>
            </tr>
          </tfoot>
        </table>
        <!-- Datatables -->

  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id='modal_nueva' style="overflow: scroll;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Agregar nueva Gestión</b></h4>
        </div>
        <div class="modal-body">
          <form id="formulario">
            <div class="row">
                <div class="col-lg-12" style="margin-top: 10px">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color: gray; color: white">Estás agregando una gestión realizada en esta negociación con <span style="color: orange" id="cliente_name"></span>.</div>
                        <div class="panel-body">

                          <div class="row">
                            <div class="col-lg-12">
                              <label for="descripcion" class="obligatorio">Tipo de Gestión</label>
                              <select class="form-control input-font" name="recargo_nocturno" id="recargo_nocturno">
                                  <option value="0">-</option>
                                  <option value="1">RECHAZADA</option>
                                  <option value="2">No</option>
                              </select>
                            </div>
                          </div>

                            <div class="row">
                              <div class="col-lg-12">
                                <label for="descripcion" class="obligatorio">Describe la gestión realizada...</label>
                                <textarea rows="6" class="form-control input-font" type="text" name="descripcion" id="descripcion" placeholder="Escribe aquí..."></textarea>
                              </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <hr>

            <!-- Soportes de Gestión -->
            <div class="row soportes" style="height: 200px">
              <div class="col-lg-12" style="margin-top: 20px">
                <input id="input-44" name="archivos[]" type="file" multiple class="file-loading">
                <span>Inserta aquí las imágenes soporte.<br><hr></span>
              </div>
            </div>
            <!-- Soportes de Gestión -->


            <!-- Tabla de tarifas -->

            <a id="mostrar_tarifas" style="float: right; margin-bottom: 25px; margin-top: 15px" type="text" class="btn btn-info btn-icon">Quiero Enviar Tarifas<i class="fa fa-send icon-btn"></i></a>

            <a id="enviar_tarifas_seleccionadas" style="float: right; margin-bottom: 25px; margin-top: 15px" type="text" class="btn btn-primary btn-icon hidden">Enviar Tarifas Seleccionadas<i class="fa fa-send icon-btn"></i></a>

            <a id="esconder_tarifas" style="float: left; margin-bottom: 25px; margin-top: 15px" type="text" class="btn btn-warning btn-icon hidden">Quiero Adjuntar Soportes<i class="fa fa-paperclip icon-btn"></i></a>

            <hr>
            <button id="guardar_gestion" style="width: 100%" type="button" class="btn btn-success btn-icon">Agregar Gestión<i class="fa fa-plus icon-btn"></i></button>
          </form>
        </div>
        <div class="modal-footer">
          <a style="float: right; margin-right: 6px; margin-left: 5px" data-dismiss="modal" class="btn btn-danger btn-icon">Cancelar<i class="fa fa-times icon-btn"></i></a>
          <a style="float: right; margin-right: 6px; margin-left: 5px" class="btn btn-info btn-icon volver">Regresar<i class="fa fa-arrow-left icon-btn"></i></a>
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

<!-- Modal de Gestiones -->
<div class="modal fade" tabindex="-1" role="dialog" id='modal_gestiones'>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Gestiones de la Cotización</b></h4>
        </div>
        <div class="modal-body">
          <div class="cuerpo">

          </div>
        </div>
        <div class="modal-footer">
          <a id="edit" style="float: right; margin-right: 6px; margin-left: 5px" class="btn btn-success btn-icon edit">Editar Tarifas<i class="fa fa-pencil-square-o icon-btn"></i></a>
          <a style="float: right; margin-right: 6px; margin-left: 20px" data-dismiss="modal" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
        </div>
    </div>
  </div>
</div>

<!-- Modal de Editar Tarifas -->
<div class="modal fade" tabindex="-1" role="dialog" id='editar_tarifas' data-backdrop="static" style="overflow: scroll;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Edición de Tarifas</b></h4>
        </div>
        <div class="modal-body">

          <!-- -->
          <div class="row primero hidden">
            <div class="col-lg-12">
              <form id="form_items">
    						<div class="row">
    							<div class="col-xs-2">
    								<div class="form-group" style="margin-bottom: 0px;">
    									<label for="fecha_servicio" >Fecha Servicio</label>
    									<div class='input-group date' id='datetimepicker3'>
    										<input type='text' class="form-control input-font" id="fecha_servicio" value="{{date('Y-m-d')}}">
    										<span class="input-group-addon">
    											<span class="fa fa-calendar">
    											</span>
    										</span>
    									</div>
    								</div>
    							</div>
    							<div class="col-xs-2">
    								<label for="Ciudades" >Ciudades</label>
    								<select name="ciudades" id="ciudades" class="form-control input-font">

    									@foreach($ciudades as $ciudad)
    										<option>{{$ciudad->ciudad}}</option>
    									@endforeach
    								</select>
    							</div>

    							<div class="col-xs-2">
    								<label for="t_vehiculo" >Tipo Vehiculo</label>
    								<select name="t_vehiculo" id="t_vehiculo" class="form-control input-font">
    									<option>CAMIONETA</option>
    									<option>MINIVANS</option>
    									<option>VANS</option>
    									<option>MICROBUS</option>
    									<option>BUSETA</option>

    								</select>
    							</div>
    							<div class="col-xs-4">
    								<label for="t_servicio" >Trayecto</label>
    								<select name="t_servicio" id="t_servicio" class="form-control input-font">

    								</select>
                    <!--<p class="trayect" style="font-size: 11px; color: red; float: left">Añadir un Trayecto <i class="fa fa-plus crear_trayecto" aria-hidden="true"></i></p>-->
    							</div>

    						</div>
    						<div class="row" style="margin-top: 10px;">
    							<div class="col-xs-2">
    								<label for="pax" ># PAX</label>
    								<input type="text" class="form-control input-font solo-numero" id="pax">
                    <p class="cantidad hidden" style="font-size: 11px; color: red; float: left"></p>
    							</div>
    							<div class="col-xs-1">
    								<label for="n_vehiculos" >Vehiculos</label>
    								<input type="text" class="form-control input-font solo-numero" id="n_vehiculos">
    							</div>
    							<div class="col-xs-2">
    								<label for="valor_trayecto" >Valor Trayecto Unitario</label>
    								<input type="text" class="form-control input-font solo-numero" id="valor_trayecto">
                    <p class="sin_tarifa hidden" style="font-size: 11px; color: red; float: right">*Sin Tarifa. Agrega un Valor</p>
    							</div>
    							<div class="col-xs-2">
    								<label for="valor_total" >Valor Total</label>
    								<input type="text" class="form-control input-font solo-numero" id="valor_total">
    							</div>
                  <div class="col-xs-3">
    								<label for="descripcion" >Nota</label>
    								<input type="text" class="form-control input-font" id="descripcion">
    							</div>
    						</div>
                <a style="float: right" class="btn btn-success btn-icon" id="agregar_itemss" >AGREGAR<i class="fa fa-check icon-btn" ></i></a>
                <a style="float: right" class="btn btn-success btn-icon hidden" id="mod_items" >MODIFICAR<i class="fa fa-check icon-btn" ></i></a>
                <br>
                <hr>

                <div class="row trayecto_nuevo hidden" >
                  <div class="col-xs-12">
                    <p><b>NUEVO TRAYECTO</b></p>
                  </div>
                  <div class="col-xs-3">
    								<label for="descripcion" >Nombre del Trayecto</label>
    								<input type="text" class="form-control input-font" id="nombre_trayecto" placeholder="Ingresa el nombre del trayecto">
    							</div>
                  <div class="col-xs-3">
    								<label for="descripcion" >Tarifa Cliente</label>
    								<input type="text" class="form-control input-font" id="tarifa_cliente" placeholder="Ingresa Tarifa Cliente">
    							</div>
                  <div class="col-xs-3">
    								<label for="descripcion" >Tarifa Proveedor</label>
    								<input type="text" class="form-control input-font" id="tarifa_proveedor" placeholder="Ingresa Tarifa Proveedor">
    							</div>
                  <div class="col-xs-3">
                    <label for="descripcion" >Guardar y Asignar Trayecto</label>
                    <a class="btn btn-primary btn-icon" id="nuevo_trayecto" >Guardar Trayecto<i class="fa fa-check icon-btn" ></i></a>
                  </div>
                </div>
                <hr>

    						</form>

            </div>
            <div class="col-lg-12">


            </div>
          </div>
          <!-- ->

          <!-- Tabla de tarifas -->
          <div class="row">
            <div class="col-lg-12">
              <a style="padding: 5px 6px; float: left; margin-bottom: 15px" title="Añadir traslados a la cotización" class="btn btn-info add"><i class="fa fa-plus"></i></a>
            </div>
            <div class="col-lg-12">
              <table style="margin-bottom: 0" class="table table-hover table-bordered" id="table_traslados">
      					<thead>
      						<tr align="center">
      							<td>#</td>
      							<td>FECHA SERVICIO</td>
      							<td>TRAYECTO</td>
      							<td>NOTA</td>
      							<td>CIUDAD</td>
      							<td>TIPO DE VEHICULO</td>
      							<td># PAX</td>
      							<td># VEHICULOS</td>
      							<td>VALOR TRAYECTO POR VEHICULO</td>
      							<td>VALOR TOTAL</td>

      							<td></td>
      						</tr>
      					</thead>
      					<tbody id="servicios_otros">
      					</tbody>
      				</table>
            </div>
            <div class="col-lg-12" >
    					<div style="margin-left:750px; margin-top: 10px; float: left;" class="input-font total content-facturado">
    						<label style="margin-bottom: 0">TOTAL $</label>
    						<label style="color: #F47321; font-size: 15px; margin-left: 20px; margin-bottom: 0" id="total_general">0</label>
    					</div>
    				</div>
          </div>
          <!-- Tabla de tarifas -->

        </div>
        <div class="modal-footer">
          <a id="enviar_actualizacion" style="float: right; margin-right: 6px; margin-left: 5px" class="btn btn-success btn-icon">Envíar Actualización<i class="fa fa-save icon-btn"></i></a>
          <a style="float: right; margin-right: 6px; margin-left: 20px" data-dismiss="modal" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
        </div>
    </div>
  </div>
</div>

<!-- Modal de Opciones -->
<div class="modal fade" tabindex="-1" role="dialog" id='modal_options' data-backdrop="static">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Selecciona el Motivo</b></h4>
        </div>
        <div class="modal-body">
          <center>
            <div class="row">
              <div class="col-xs-12">
                <select class="form-control input-font" name="opciones" id="opciones">
                    <option value="0">-</option>
                    <option value="1">COTIZACIÓN NO DE ACUERDO A LO SOLICITADO</option>
                    <option value="2">DEMORA EN ENVIO DE COTIZACION</option>
                    <option value="3">COSTO ELEVADO</option>
                    <option value="4">NO SE REALIZO EL VIAJE</option>
                    <option value="5">NO HUBO RESPUESTA</option>
                    <option value="6">OTROS</option>
                </select>
              </div>
              <div class="col-xs-12 hidden motivo_input" style="margin-top: 25px">
                  <input class="form-control input-font" type="text" id="motivo_input" placeholder="Ingresa aquí el motivo">
              </div>
            </div>
          </center>
        </div>
        <div class="modal-footer">
          <center><a id="guardar_motivo" style="float: right; margin-right: 6px; margin-left: 5px" class="btn btn-success btn-icon">Guardar<i class="fa fa-save icon-btn"></i></a>
          <a style="float: left; margin-right: 6px; margin-left: 20px" data-dismiss="modal" class="btn btn-danger btn-icon">Cancelar<i class="fa fa-times icon-btn"></i></a></center>
        </div>
    </div>
  </div>
</div>

@include('scripts.scripts')
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script><script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/pasajerosv2.js')}}"></script>
<script>
  $(function(){

    $table = $('#tabla_cotizaciones').DataTable({
        "aaSorting": [],
        paging: false,
        language: {
            processing:     "Procesando...",
            search:         "Buscar:",
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
        'bAutoWidth': false ,
        'aoColumns' : [
            { 'sWidth': '1%' },
            { 'sWidth': '1%' },
            { 'sWidth': '1%' },
            { 'sWidth': '7%' },
            { 'sWidth': '8%' },
            { 'sWidth': '3%' },
    { 'sWidth': '3%' },
            { 'sWidth': '3%' },
            { 'sWidth': '3%' },
            { 'sWidth': '3%' },

        ],
        processing: true,
        "bProcessing": true
    });
    $('#datetimepicker1, #datetimepicker2, #datetimepicker5, #datetimepicker6').datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD',
        icons: {
            time: 'glyphicon glyphicon-time',
            date: 'glyphicon glyphicon-calendar',
            up: 'glyphicon glyphicon-chevron-up',
            down: 'glyphicon glyphicon-chevron-down',
            previous: 'glyphicon glyphicon-chevron-left',
            next: 'glyphicon glyphicon-chevron-right',
            today: 'glyphicon glyphicon-screenshot',
            clear: 'glyphicon glyphicon-trash',
            close: 'glyphicon glyphicon-remove'
        }
    });
  });

  $('.add').click(function() {
    $('.primero').removeClass('hidden');
    $(this).addClass('hidden');
  });

  $('table').on('click', '.item_selects', function (){

    $('.primero').removeClass('hidden');
    $('.add').addClass('hidden');

		var $objetoTR = $(this).closest('tr');
    var idHide = $objetoTR.find('td').eq(0).text();
    var t_servicio = $objetoTR.find('td').eq(2).text().trim();
		var item_tb = $objetoTR.find('td').eq(0).text();
		var fecha_servicio = $objetoTR.find('td').eq(1).text();
		var descripcion = $objetoTR.find('td').eq(3).text();
		var ciudad = $objetoTR.find('td').eq(4).text();
		var t_vehiculo = $objetoTR.find('td').eq(5).text();
		var n_pax = $objetoTR.find('td').eq(6).text();
		var n_vehiculo = $objetoTR.find('td').eq(7).text();
		var valor_trayecto = $objetoTR.find('td').eq(8).text();
		var valor_total = $objetoTR.find('td').eq(9).text();
		//alert(t_servicio);
		var urlPath = $("meta[name='url']").attr('content');

		$.ajax({
			url: urlPath+'/cotizaciones/tiposervicios',
			method: 'post',
			data: {'ciudad': ciudad},
			success: function(data){

				if(data.mensaje===false){

					$('#t_servicio').find('option').remove().end();

				}else if(data.mensaje===true){

					$('#t_servicio').find('option').remove().end();

					for(j in data.tipo_servicio){

            if(t_servicio==data.tipo_servicio[j].nombre){
              console.log(data.tipo_servicio[j].nombre)
              $('#t_servicio').append('<option selected value="'+data.tipo_servicio[j].nombre+'">'+data.tipo_servicio[j].nombre+'</option>');
            }else{
              $('#t_servicio').append('<option value="'+data.tipo_servicio[j].nombre+'">'+data.tipo_servicio[j].nombre+'</option>');
            }
					}

				}else if(data.mensaje==='relogin'){
				  location.reload();
				}else if(data.mensaje==='no hay'){
					$('#t_servicio').find('option').remove().end();
				}
			}
		});

    $('#idHide').val(idHide);
		$('#fecha_servicio').val(fecha_servicio);
		$('#descripcion').val(descripcion);
		$('#ciudades').val(ciudad);
		$('#t_vehiculo').val(t_vehiculo);
		$('#pax').val(n_pax);
		$('#n_vehiculos').val(n_vehiculo);
		$('#valor_trayecto').val(valor_trayecto);
		$('#valor_total').val(valor_total);

		if (!$('#agregar_itemss').hasClass('hidden')) {
      $('#agregar_itemss').addClass('hidden');
      $('#mod_items').removeClass('hidden');
    }

		$('#mod_items').attr('data-item',item_tb);

	});

  $('#mod_items').click(function(e){
		e.preventDefault();

		var item_tb = parseInt($('#mod_items').attr('data-item')) - 1;
		var fecha_serv = $('#fecha_servicio').val();
		var ciudad_serv = $('#ciudades').val();
		var t_veh = $('#t_vehiculo').val();
		var t_serv = $('#t_servicio').val();
		var t_serv_text = $('#t_servicio :selected').text();
		var descrip = $('#descripcion').val().toUpperCase();
		var pax = $('#pax').val();
		var n_vehiculos = $('#n_vehiculos').val();
		var valor_trayecto = $('#valor_trayecto').val();
		var valor_total = $('#valor_total').val();

		$('#table_traslados tbody tr').eq(item_tb).find('td').eq(1).text(fecha_serv);
		$('#table_traslados tbody tr').eq(item_tb).find('td').eq(2).text(t_serv_text);
		$('#table_traslados tbody tr').eq(item_tb).find('td').eq(3).text(descrip);
		$('#table_traslados tbody tr').eq(item_tb).find('td').eq(4).text(ciudad_serv);
		$('#table_traslados tbody tr').eq(item_tb).find('td').eq(5).text(t_veh);
		$('#table_traslados tbody tr').eq(item_tb).find('td').eq(6).text(pax);
		$('#table_traslados tbody tr').eq(item_tb).find('td').eq(7).text(n_vehiculos);
		$('#table_traslados tbody tr').eq(item_tb).find('td').eq(8).text(valor_trayecto);
		$('#table_traslados tbody tr').eq(item_tb).find('td').eq(9).text(valor_total);

		$g_total = 0;

		$('#table_traslados tbody tr').each(function(index){
			$(this).children("td").each(function (index2){
				switch (index2){
					case 9:
						var $objetoa = $(this);
						v_total = parseInt($objetoa.text());
						$g_total = $g_total+v_total;
						break;
				}
			});
		});

		$('#total_general').text(number_format($g_total));

		$(this).addClass('hidden');
    $('#agregar_itemss').removeClass('hidden');
    $('.primero').addClass('hidden');
    $('.add').removeClass('hidden');

    $('#n_vehiculos').val('');
    $('#pax').val('');
    $('#valor_trayecto').val('');
    $('#valor_total').val('');
    $('#descripcion').val('');

	});

  $('#agregar_itemss').click(function(e){
		e.preventDefault();

		var fecha_serv = $('#fecha_servicio').val();
		var ciudad_serv = $('#ciudades').val();
		var t_veh = $('#t_vehiculo').val();
		var t_serv = $('#t_servicio').val();
		var t_serv_text = $('#t_servicio :selected').text();
		var descrip = $('#descripcion').val().toUpperCase();
		var pax = $('#pax').val();
		var n_vehiculos = $('#n_vehiculos').val();
		var valor_trayecto = $('#valor_trayecto').val();
		var valor_total = $('#valor_total').val();

		var edit_serv = '<a data-toggle="modal" data-target=".mymodal" style="padding: 5px 6px; margin-bottom: 5px" class="btn btn-success item_selects" title="Editar" ><i class="fa fa-pencil"></i></a>';
		var anular_serv = '<a style="padding: 5px 6px;" class="btn btn-danger eliminar" title="Anular"><i class="fa fa-close"></i></a>';

		cont_t = 0;
		$('.table tbody tr').each(function(index){
			$(this).children("td").each(function (index2){
				switch (index2){
					case 0:
						var $TDcont = $(this);
						cont_t++;
						$TDcont.text(cont_t);
						break;
				}
			});
		});

		$('#table_traslados').append(
			'<tr>'+
				'<td >'+(cont_t+1)+'</td>'+
				'<td >'+fecha_serv+'</td>'+
				'<td data-id="'+t_serv+'">'+t_serv_text+'</td>'+
				'<td>'+descrip+'</td>'+
				'<td>'+ciudad_serv+'</td>'+
				'<td>'+t_veh+'</td>'+
				'<td align="center">'+pax+'</td>'+
				'<td align="center">'+n_vehiculos+'</td>'+
				'<td align="center">'+valor_trayecto+'</td>'+
				'<td align="right">'+valor_total+'</td>'+

				'<td align="center">'+edit_serv+' '+anular_serv+'</td>'+
			'</tr>)');
		$g_total = 0;

		$('#table_traslados tbody tr').each(function(index){
			$(this).children("td").each(function (index2){
				switch (index2){
					case 9:
						var $objetoa = $(this);
						v_total = parseInt($objetoa.text());
						$g_total = $g_total+v_total;
						break;
				}
			});
		});

		$('#total_general').text(number_format($g_total));
    $('.add').removeClass('hidden');
    $('.primero').addClass('hidden');

    $('#n_vehiculos').val('');
    $('#pax').val('');
    $('#valor_trayecto').val('');
    $('#valor_total').val('');
    $('#descripcion').val('');

	});

  $('table').on('click', '.eliminar', function (){
		$(this).closest('tr').remove();
		$g_total = 0;

		$('.table tbody tr').each(function(index){
			$(this).children("td").each(function (index2){
				switch (index2){
					case 9:
						var $objetoa = $(this);
						v_total = parseInt($objetoa.text());
						$g_total = $g_total+v_total;
						break;
				}
			});
		});

		$('#total_general').text(number_format($g_total));
	});

  $('#t_vehiculo').change(function(){
		var tipo_serv = $('#t_servicio').val();
		var tipo_veh = $(this).val();
    var cc = $('#centrodecosto_search').val();

    var tipo_veh = $('#t_vehiculo').val();
    var pax = $('#pax').val();

    if( tipo_veh === 'AUTOMOVIL' && pax>4 ){
      $('.cantidad').html('* Maximo 4 pax').removeClass('hidden');
      $('#agregar_itemss').attr('disabled','disabled')
    }else if( tipo_veh === 'MINIVANS' && pax>7 ){
      $('.cantidad').html('* Maximo 7 pax').removeClass('hidden');
      $('#agregar_itemss').attr('disabled','disabled')
    }else if( tipo_veh === 'VANS' && pax>10 ){
      $('.cantidad').html('* Maximo 10 pax').removeClass('hidden');
      $('#agregar_itemss').attr('disabled','disabled')
    }else if( tipo_veh === 'MICROBUS' && pax>15 ){
      $('.cantidad').html('* Maximo 15 pax').removeClass('hidden');
      $('#agregar_itemss').attr('disabled','disabled')
    }else{
      $('.cantidad').html('').addClass('hidden');
      $('#agregar_itemss').removeAttr('disabled','disabled')
    }

		$.ajax({
			url: 'buscartarifalistado',
			method: 'post',
			data: {'tipo_serv': tipo_serv, 'tipo_veh':tipo_veh, 'cc': cc},
			success: function(data){
				if(data.mensaje===false){
          $('#valor_trayecto').val('');
          $('#valor_total').val('');
          $('.sin_tarifa').removeClass('hidden');
				}else if(data.mensaje===true){
					if(!($('.errores-modal').hasClass('hidden'))){
					  $('.errores-modal').addClass('hidden');
					}

					$('#n_vehiculos').val('1');
					$('#valor_trayecto').val(data.cotizacion_re[0].tarifa);
					$('#valor_total').val(data.cotizacion_re[0].tarifa);
          $('.sin_tarifa').addClass('hidden');


				}else if(data.mensaje==='relogin'){
				  location.reload();
				}else{
					$('.errores-modal ul li').remove();
					$('.errores-modal').addClass('hidden');
				}
			}
		});

	});

	$('#t_servicio').change(function(){

		var tipo_serv = $(this).val();

		var tipo_veh = $('#t_vehiculo').val();

    var cc = $('#centrodecosto_search').val();

    var id_cotizacion = $('#enviar_actualizacion').attr('data-id');

		$.ajax({
			url: 'buscartarifalistado',
			method: 'post',
			data: {'tipo_serv': tipo_serv, 'tipo_veh':tipo_veh, 'cc': cc, 'id_cotizacion': id_cotizacion},
			success: function(data){
				if(data.mensaje===false){
          $('#valor_trayecto').val('');
          $('#valor_total').val('');
          $('.sin_tarifa').removeClass('hidden');
				}else if(data.mensaje===true){
					if(!($('.errores-modal').hasClass('hidden'))){
					  $('.errores-modal').addClass('hidden');
					}

					$('#n_vehiculos').val('1');
					$('#valor_trayecto').val(data.cotizacion_re[0].tarifa);
					$('#valor_total').val(data.cotizacion_re[0].tarifa);
          $('.sin_tarifa').addClass('hidden');

        }else if(data.mensaje==='relogin'){
				  location.reload();
				}else{
					$('.errores-modal ul li').remove();
					$('.errores-modal').addClass('hidden');
				}
			}
		});

	});


	$('.solo-numero').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');


    });

	$('#n_vehiculos, #valor_trayecto').keyup(function (){
		n_veh = $('#n_vehiculos').val();
		valor_tray = $('#valor_trayecto').val();

		if(n_veh===''){
			n_veh = 0;
		}else{
			n_veh = parseInt(n_veh);
		}
		if(valor_tray===''){
			valor_tray = 0;
		}else{
			valor_tray = parseInt(valor_tray);
		}

		v_total = n_veh*valor_tray;
		$('#valor_total').val(v_total);
	});

  $('#pax').keyup(function (){

    var vehiculo = $('#t_vehiculo').val();

    if( vehiculo === 'AUTOMOVIL' && $(this).val()>4 ){
      $('.cantidad').html('* Maximo 4 pax').removeClass('hidden');
      $('#agregar_itemss').attr('disabled','disabled')
    }else if( vehiculo === 'MINIVANS' && $(this).val()>7 ){
      $('.cantidad').html('* Maximo 7 pax').removeClass('hidden');
      $('#agregar_itemss').attr('disabled','disabled')
    }else if( vehiculo === 'VANS' && $(this).val()>10 ){
      $('.cantidad').html('* Maximo 10 pax').removeClass('hidden');
      $('#agregar_itemss').attr('disabled','disabled')
    }else if( vehiculo === 'MICROBUS' && $(this).val()>14 ){
      $('.cantidad').html('* Maximo 14 pax').removeClass('hidden');
      $('#agregar_itemss').attr('disabled','disabled')
    }else{
      $('.cantidad').html('').addClass('hidden');
      $('#agregar_itemss').removeAttr('disabled','disabled')
    }

  });

  $('.apply').click(function() {

    var estado = $('#estado').val();
    var cliente =   $('#cliente option:selected').html();
    var usuario =   $('#usuario').val();
    var fecha_inicial = $('#fecha_inicial').val();
    var fecha_final = $('#fecha_final').val();

    //console.log(cliente)
    //var ciudad = $('#ciudad option:selected').val();
    $tablecuentas.clear().draw();

    $.ajax({
      url: '../cotizaciones/filtrar',
      method: 'post',
      data: {estado: estado, cliente: cliente, usuario: usuario, fecha_inicial: fecha_inicial, fecha_final: fecha_final}
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

        //alert('respuesta true')

        $('.products-row').html('').removeAttr('style');

        for(var i in data.cotizaciones) {

          var htmlCode = '';

          if(data.cotizaciones[i].cantidad_gestiones==null){
            var cantidad = 0;
          }else{
            var cantidad = data.cotizaciones[i].cantidad_gestiones;
          }

          var opts = '';

          if(data.cotizaciones[i].estado!=3 && data.cotizaciones[i].estado!=1 && data.cotizaciones[i].estado!=4){
            opts += '<a title="Registrar Aprobado" style="margin-right: 5px; margin-left: 5px" target="_blank" data-id="'+data.cotizaciones[i].id+'" data-nombre="" class="btn btn-list-table btn-success aprobada"><i class="fa fa-check" aria-hidden="true"></i></i></a>';
            opts += '<a title="Registrar Rechazado" target="_blank" data-id="'+data.cotizaciones[i].id+'" data-nombre="" class="btn btn-list-table btn-danger rechazada"><i class="fa fa-times" aria-hidden="true"></i></i></a>';
          }

          if(data.cotizaciones[i].estado===3){
            opts += '<a title="Reactivar Cotización" style="margin-left: 5px;" data-id="'+data.cotizaciones[i].id+'" class="btn btn-list-table btn-info reactivar" data-id=""><i class="fa fa-repeat" aria-hidden="true"></i></i></a>';
          }

          if(parseInt(data.cotizaciones[i].estado)===0){
            var status = '<span data-id="'+data.cotizaciones[i].id+'" style="background: green; color: white; width: 120px" class="gestiones status active">('+cantidad+') Enviado</span>';
          }

          if(parseInt(data.cotizaciones[i].estado)===1){
            var status = '<span data-id="'+data.cotizaciones[i].id+'" style="background: green; color: white; width: 120px" class="gestiones status active">('+cantidad+') Aprobado</span>';
          }

          if(parseInt(data.cotizaciones[i].estado)===2){
            var status = '<span data-id="'+data.cotizaciones[i].id+'" style="background: #f47321; color: white; width: 120px" class="gestiones status active">('+cantidad+') Negociando</span>';
          }

          if(parseInt(data.cotizaciones[i].estado)===3){
            var status = '<span data-id="'+data.cotizaciones[i].id+'" style="background: red; color: white; width: 120px" class="gestiones status active">('+cantidad+') Rechazado</span>';
          }

          if(parseInt(data.cotizaciones[i].estado)===4){
            var status = '<span data-id="'+data.cotizaciones[i].id+'" style="background: red; color: white; width: 120px" class="gestiones status active">('+cantidad+') Vencido</span>';
          }

          if(parseInt(data.cotizaciones[i].estado)===5){
            var status = '<span data-id="'+data.cotizaciones[i].id+'" style="background: green; color: white; width: 120px" class="gestiones status active">('+cantidad+') Sin Gestión</span>';
          }

          if(data.cotizaciones[i].descargado===1){
            var descargado = '<center><span style="background: green; color: white; width: 100px" class="status active">Sí</span></center>';
          }else{
            var descargado = '<center><span style="background: red; color: white; width: 100px" class="status active">No</span></center>';
          }

          var urls = 'https://app.aotour.com.co/autonet/biblioteca_imagenes/escolar/pdf/Cotizacion_Aotour_'+data.cotizaciones[i].id+'.pdf';

          var options = '';
          options += '<a target="_blank" href="'+urls+'" class="btn btn-list-table btn-primary">PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';

          if(data.cotizaciones[i].estado===1){
            options +'<a title="Enviar a Operaciones" class="btn btn-list-table btn-success"><i class="fa fa-share" aria-hidden="true"></i></a>';
          }

          var opt = '<form class="form-inline" id="form_buscar" action="{{url('portalusu/exportarlistadonovedades')}}" method="post">'+

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
            '<input type="text" name="cc" value="" class="hidden">'+
            '<input type="text" name="id_cliente" value="ra" class="hidden">'+
            options+opts
          '</form>';
          /*filtro datatable*/

          $tablecuentas.row.add([
            '<center>'+(parseInt(i)+1)+'</center>',
            '<center>00'+data.cotizaciones[i].id+'</center>',
            '<center>'+data.cotizaciones[i].nombre_completo+'</center>',
            '<center>'+data.cotizaciones[i].asunto+'</center>',
            '<center>'+data.cotizaciones[i].fecha_solicitud+'</center>',
            '<center>'+data.cotizaciones[i].fecha+'</center>',
            '<center>'+data.cotizaciones[i].fecha+'</center>',
            '<center>'+data.cotizaciones[i].fecha_vencimiento+'</center>',
            '<center>'+data.cotizaciones[i].vendedor+'</center>',
            '<center>'+status+'</center>',
            descargado,
            opt
          ]).draw();

          /*filtro datatable*/

        }

        //$('#sin_datos').addClass('hidden');

      }else if(data.respuesta==false){

        $('.products-row').html('').removeAttr('style');

        $.confirm({
            title: 'Atención',
            content: 'No se encontraron registros',
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

  $('#datetime_fecha, #datetime_fecha2, .datetime_fecha').datetimepicker({
      locale: 'es',
      format: 'YYYY-MM-DD',
      icons: {
          time: 'glyphicon glyphicon-time',
          date: 'glyphicon glyphicon-calendar',
          up: 'glyphicon glyphicon-chevron-up',
          down: 'glyphicon glyphicon-chevron-down',
          previous: 'glyphicon glyphicon-chevron-left',
          next: 'glyphicon glyphicon-chevron-right',
          today: 'glyphicon glyphicon-screenshot',
          clear: 'glyphicon glyphicon-trash',
          close: 'glyphicon glyphicon-remove'
      }
  });

  $tablecuentas = $('#example_table').DataTable( {
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
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' }
        ],
  });

  function number_format(number, decimals, dec_point, thousands_sep) {

    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
         s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
        .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

  $(document).on('click', '.gestiones', function(){

    var id = $(this).attr('data-id');
    var nombre = $(this).attr('data-nombre');

    $.ajax({
      url: 'consultargestion',
      method: 'post',
      data: {id: id}
    }).done(function(data){

      if(data.respuesta==true){

        $('.cuerpo').html('');

        var htmls = '';


        var $json = JSON.parse(data.portafolio.gestiones);

        var htmlJson = '';
        var cont = 1;
        for(var a in $json){

            var btns = '';

            if($json[a].soporte!=null){
              var photos = $json[a].soporte.split(',');
              for (var i = 0; i < photos.length; i++) {
                btns +='<a data-url="'+photos[i]+'" class="btn btn-list-table btn-primary soport" style="margin-right: 5px">Soporte</a>';
              }
            }

            var start = '<ul class="list-group">';
            var end = '</ul>';
            var inicio = '';

            if($json[a].cambios){

              var $jsonss = JSON.parse($json[a].cambios);
              var html = '';

              for(var e in $jsonss){

                html += '<tr align="center">'+
                    '<td style="font-size: 9px">'+$jsonss[e].trayecto+'</td>'+
                    '<td style="font-size: 9px">'+$jsonss[e].vehiculos+'</td>'+
                    '<td style="font-size: 9px">$ '+number_format($jsonss[e].valortotal)+'</td>'+
                  '</tr>';

              }

              inicio = '<div class="row">'+
                  '<div class="col-lg-5">'+
                  '<table style="margin-bottom: 0" class="table table-hover table-bordered" id="details">'+
          					'<thead>'+
                    '<tr align="center">'+
                      '<td colspan="3" style="background-color: orange; color: white">Traslados</td>'+
                    '</tr>'+
          						'<tr align="center">'+
          							'<td>Trayecto</td>'+
          							'<td>Vehículos</td>'+
          							'<td>Valor</td>'+
          						'</tr>'+
          					'</thead>'+
          					'<tbody>'+
                      html+
          					'</tbody>'+
          				'</table>'+
                  '</div>'+


            '</div>';

            }

            htmlJson += '<li class="list-group-item"><b><span style="color: orange">'+$json[a].usuario+' <i class="fa fa-user" aria-hidden="true"></i></span><br>'+$json[a].gestion+'<br><span style="color: orange; font-size: 10px; float: right;">'+$json[a].fecha+'<span></b>'+btns+''+inicio+'</li>';
            console.log(htmlJson)

        }

        if(data.portafolio.pdf_tarifas!=null){
          $('#mostrar_tarifas').addClass('hidden');
        }else{
          $('#mostrar_tarifas').removeClass('hidden');
          $('#mostrar_tarifas').attr('data-id',id);
        }

        $('.cuerpo').append(start+htmlJson+end);


        $('#agregar_gestion').attr('data-id',id);
        $('#agregar_gestion').attr('data-nombre',nombre);
        $('.edit').attr('data-id',id);
        $('#modal_gestiones').modal('show');

      }else if(data.respuesta==false){

        $('.cuerpo').html('');

        var htmls = '';

        if(data.portafolio.pdf_tarifas!=null){
          $('#mostrar_tarifas').addClass('hidden');
        }else{
          $('#mostrar_tarifas').removeClass('hidden');
          $('#mostrar_tarifas').attr('data-id',id);
        }

        var start = '<ul class="list-group">';
        var end = '</ul>';
        htmlJson += '<li class="list-group-item"><b><span style="color: red">Esta cotización no tiene gestiones</span><br><span style="color: orange; font-size: 10px; float: right;"><span></b></li>';

        $('.cuerpo').append(htmlJson);


        $('#agregar_gestion').attr('data-id',id);
        $('#agregar_gestion').attr('data-nombre',nombre);
        $('.edit').attr('data-id',id);
        $('#modal_gestiones').modal('show');

      }

    });

  });

  $(document).on('click', '.aprobada', function(){

    var id = $(this).attr('data-id');

    $.confirm({
        title: 'Atención!',
        content: '¿Estás seguro de resgistrar la cotización <b># '+id+'</b> como <b style="color: green">APROBADA</b> ?',
        buttons: {
            confirm: {
                text: 'Estoy seguro',
                btnClass: 'btn-success',
                keys: ['enter', 'shift'],
                action: function(){

                  $.ajax({
                    url: 'aprobada',
                    method: 'post',
                    data: {id: id}
                  }).done(function(data){

                    if(data.respuesta==true){

                      $.confirm({
                          title: '¡Grandioso!',
                          content: 'La cotización <b># '+id+'</b> fue registrada como <b>APROBADA!</b>',
                          buttons: {
                              confirm: {
                                  text: 'Ok',
                                  btnClass: 'btn-primary',
                                  keys: ['enter', 'shift'],
                                  action: function(){

                                    location.reload();

                                  }

                              },
                              /*cancel: {
                                text: 'No crearlo',
                                btnClass: 'btn-danger',
                                action: function(){
                                  location.reload();
                                }
                              }*/
                          }
                      });

                    }else if(data.respuesta==false){

                    }

                  });

                }

            },
            cancel: {
              text: 'Cancelar',
              btnClass: 'btn-danger',
              action: function(){

              }
            }
        }
    });
    //end

  });

  /*$('.rechazada').click(function() {

  });*/

  $(document).on('click', '.rechazada', function(){

    var id = $(this).attr('data-id');
    var motivo = 'MOTIVO ESTÁTICO. CAMBIAR A DINÁMICO';
    $.confirm({
        title: 'Atención!',
        content: '¿Estás seguro de resgistrar la cotización <b># '+id+'</b> como <b style="color: red">RECHAZADA</b> ?',
        buttons: {
            confirm: {
                text: 'Estoy seguro',
                btnClass: 'btn-success',
                keys: ['enter', 'shift'],
                action: function(){

                  $('#modal_options').modal('show');
                  $('#guardar_motivo').attr('data-id',id);

                }

            },
            cancel: {
              text: 'Cancelar',
              btnClass: 'btn-danger',
              action: function(){

              }
            }
        }
    });

  });

  $(document).on('click', '.reactivar', function(){

    var id = $(this).attr('data-id');

    $.confirm({
        title: 'Atención!',
        content: '¿Estás seguro de <b style="color: blue">REACTIVAR</b> cotización <b># '+id+'</b>?',
        buttons: {
            confirm: {
                text: 'Estoy seguro',
                btnClass: 'btn-primary',
                keys: ['enter', 'shift'],
                action: function(){

                  $.ajax({
                    url: 'reactivar',
                    method: 'post',
                    data: {id: id}
                  }).done(function(data){

                    if(data.respuesta==true){

                      $.confirm({
                          title: '¡Negociación reactivada!',
                          content: 'Esta cotización se ha reactivado.',
                          buttons: {
                              confirm: {
                                  text: 'Ok',
                                  btnClass: 'btn-success',
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

            },
            cancel: {
              text: 'Cancelar',
              btnClass: 'btn-danger',
              action: function(){

              }
            }
        }
    });

  });

  $('#opciones').change(function() {
    var value = $(this).val();
    console.log(value)
    if(value==6){
      $('.motivo_input').removeClass('hidden');
    }else{
      $('.motivo_input').addClass('hidden');
      $('#motivo_input').val('');
    }
  });

  $('#guardar_motivo').click(function(){

    var id = $(this).attr('data-id');
    var value = $('#motivo_input').val();
    var motivo = $('#opciones').val();
    var motivo_text = $('#opciones option:selected').html();

    if(motivo==='0'){ //Ninguna selección

      $.confirm({
          title: '¡Atención!',
          content: 'No has seleccionado ninguna opción',
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

    }else if(motivo==='6' && value===''){ //Selección otros y campo vacío

      $.confirm({
          title: '¡Atención!',
          content: 'El campo motivo está vacío. <br>Por favor ingresa el motivo del rechazo.',
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

    }else{ //Selección de las opciones disponibles

      if(motivo==='6'){
        motivo = value;
      }else{
        motivo = motivo_text;
      }

      $.confirm({
          title: 'Atención!',
          content: '¿Estás seguro de registrar la  cotización <b># '+id+'</b> como <b style="color: red">RECHAZADA</b>?<br><b>MOTIVO:</b> '+motivo.toUpperCase()+'.',
          buttons: {
              confirm: {
                  text: 'Estoy seguro',
                  btnClass: 'btn-primary',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: 'rechazada',
                      method: 'post',
                      data: {id: id, motivo: motivo}
                    }).done(function(data){

                      if(data.respuesta==true){

                        $.confirm({
                            title: '¡Cotización Rechazada!',
                            content: 'La cotización <b># '+id+'</b> se registró como <b style="color: red">RECHAZADA!</b>',
                            buttons: {
                                confirm: {
                                    text: 'Ok',
                                    btnClass: 'btn-danger',
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

              },
              cancel: {
                text: 'Cancelar',
                btnClass: 'btn-danger',
                action: function(){

                }
              }
          }
      });

    }


  });

  $('.edit').click(function() {

    var id = $(this).attr('data-id');

    $('#modal_gestiones').modal('hide');

    $.ajax({
      url: 'fees',
      method: 'post',
      data: {id: id}
    }).done(function(data){

      if(data.respuesta==true){

        var htmlCode = '';
        var cont_t = 1;
        for(var i in data.detalles) {

          var edit_serv = '<a data-toggle="modal" data-target=".mymodal" style="padding: 5px 6px; margin-bottom: 5px" class="btn btn-success item_selects" title="Editar" ><i class="fa fa-pencil"></i></a>';
      		var anular_serv = '<a style="padding: 5px 6px;" class="btn btn-danger eliminar" title="Anular"><i class="fa fa-close"></i></a>';

          htmlCode += '<tr>'+
    				'<td >'+cont_t+'</td>'+
    				'<td >'+data.detalles[i].fecha_servicio+'</td>'+
    				'<td data-id="'+data.detalles[i].id+'">'+data.detalles[i].tipo_servicio+'</td>'+
    				'<td>'+data.detalles[i].descripcion+'</td>'+
    				'<td>'+data.detalles[i].ciudad+'</td>'+
    				'<td>'+data.detalles[i].tipo_vehiculo+'</td>'+
    				'<td align="center">'+data.detalles[i].pax+'</td>'+
    				'<td align="center">'+data.detalles[i].vehiculos+'</td>'+
    				'<td align="center">'+data.detalles[i].valorxvehiculo+'</td>'+
    				'<td align="right">'+data.detalles[i].valortotal+'</td>'+

    				'<td align="center">'+edit_serv+' '+anular_serv+'</td>'+
    			'</tr>';
          cont_t++;
        }

        $('#table_traslados').append(htmlCode);

        $g_total = 0;

        $('#table_traslados tbody tr').each(function(index){
    			$(this).children("td").each(function (index2){
    				switch (index2){
    					case 9:
    						var $objetoa = $(this);
    						v_total = parseInt($objetoa.text());
    						$g_total = $g_total+v_total;
    						break;
    				}
    			});
    		});

        $('#total_general').text(number_format($g_total));

      }else if(data.respuesta==false){

      }

    });

    $('#editar_tarifas').modal('show');
    $('#enviar_actualizacion').attr('data-id',id);

  });

  $('#enviar_actualizacion').click(function() {

    var id = $(this).attr('data-id');
    var total_gen = parseInt($('#total_general').text().replace(/,/g,''));

    var fecha_servicioV = [], tipo_servV = [], descripV = [], ciudadV = [], t_vehV = [], paxV = [], vehiculoV = [], valorTrayectoV = [], valorTotalV = [];

    $.confirm({
        title: 'Atención!',
        content: '¿Estás seguro de modificar estas tarifas?<br><br>Recuerda que se enviará nuevamente el formato de PDF al cliente con los nuevos traslados y valores...',
        buttons: {
            confirm: {
                text: 'Estoy seguro',
                btnClass: 'btn-primary',
                keys: ['enter', 'shift'],
                action: function(){

                  $('#table_traslados tbody tr').each(function(ind){
            				$(this).children("td").each(function (ind2){
            					switch (ind2){
            						case 1:
            							var $objetoa = $(this);
            							fecha_servicioV.push($objetoa.text());
            							break;
            						case 2:
            							var $objetoa = $(this);
            							tipo_servV.push($objetoa.text());
            							break;
            						case 3:
            							var $objetoa = $(this);
            							descripV.push($objetoa.text());
            							break;
            						case 4:
            							var $objetoa = $(this);
            							ciudadV.push($objetoa.text());
            							break;
            						case 5:
            							var $objetoa = $(this);
            							t_vehV.push($objetoa.text());
            							break;
            						case 6:
            							var $objetoa = $(this);
            							paxV.push($objetoa.text());
            							break;
            						case 7:
            							var $objetoa = $(this);
            							vehiculoV.push($objetoa.text());
            							break;
            						case 8:
            							var $objetoa = $(this);
            							valorTrayectoV.push($objetoa.text());
            							break;
            						case 9:
            							var $objetoa = $(this);
            							valorTotalV.push($objetoa.text());
            							break;
            					}
            				});
            			});

                  var formData = new FormData($('#formulario')[0]);

                  formData.append('id',id);
              		formData.append('total_general',total_gen);

              		formData.append('fecha_servicioV',fecha_servicioV);
              		formData.append('tipo_servV',tipo_servV);
              		formData.append('descripV',descripV);
              		formData.append('ciudadV',ciudadV);
              		formData.append('t_vehV',t_vehV);
              		formData.append('paxV',paxV);
              		formData.append('vehiculoV',vehiculoV);
              		formData.append('valorTrayectoV',valorTrayectoV);
              		formData.append('valorTotalV',valorTotalV);

                  $.ajax({
                    url: 'actualizarcotizacion',
                    processData: false,
                    contentType: false,
                    method: 'post',
                    data: formData,
                    success: function(data){

                      if(data.mensaje===false){


                      }else if(data.mensaje===true){

                          $.confirm({
                              title: 'Atención',
                              content: 'Se ha actualizado la cotización.<br>El cliente ha sido notificado!',
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

                      }else if(data.mensaje==='relogin'){
                          location.reload();
                      }else{

                      }
                    },
                    error: function (request, status, error) {
                        alert('Hubo un error, llame al administrador del sistema'+request+status+error);
                        alert(request.responseText);
                        alert(status.responseText);
                        alert(error.responseText);
                    }
                  });
                  //console.log(fecha_servicioV)
                  //console.log(total_gen)

                }

            },
            cancel: {
              text: 'Cancelar',
              btnClass: 'btn-danger',
              action: function(){

              }
            }
        }
    });

  });

</script>
<script src="{{url('jquery/cotizaciones.js')}}"></script>
</body>
</html>
