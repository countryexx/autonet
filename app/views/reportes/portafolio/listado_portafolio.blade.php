<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Portafolios enviados</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link href="{{url('bootstrap-fileinput-master\css\fileinput.min.css')}}" media="all" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
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
      border: 1px solid gray;
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
        border: 1px solid gray;
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
        background-color: #2CBAF7;
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
    $dia = date('d');

  ?>

<div class="container-fluid">
  <div class="col-xs-12">
    <div class="col-lg-12">
      <ol style="margin-bottom: 5px" class="breadcrumb">
        <li><a href="{{url('reportes/portafolio')}}">Enviar Portafolio</a></li>
        <li><a href="{{url('reportes/portafoliosenviados')}}">Portafolios enviados</a></li>
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

          <div class="app-content-actions-wrapper">
            <div class="filter-button-wrapper">
              <div class="row">
                <div class="col-lg-12">

                  <div class="inline">
                    <div class="action-button-t">
                        <label style="color: var(--app-content-secondary-color); margin-top: 4pxmargin-right: 5px; border-right: 1px solid gray; padding: 12px 2px -3px 0; line-height: 8px; margin-left: 4px; margin-top: 3px"><p style="margin-right: 5px; margin-top: 12px"> F. Inicial </p></label>
                        <div class='input-group date' id='datetime_fecha'>
                            <input id="fecha_inicial" name="fecha_inicial" style="width: 80px; height: 30px" type='text' class="form-control input-font" placeholder="Fecha" value="{{date('Y-m-d')}}">
                            <span class="input-group-addon" style="height: 15px">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                        </div>
                      </div>
                  </div>

                  <div class="inline">
                    <div class="action-button-t">
                        <label style="color: var(--app-content-secondary-color); margin-top: 4pxmargin-right: 5px; border-right: 1px solid gray; padding: 12px 2px -3px 0; line-height: 8px; margin-left: 4px; margin-top: 3px"><p style="margin-right: 5px; margin-top: 12px"> F. Final </p></label>
                        <div class='input-group date' id='datetime_fecha2'>
                            <input id="fecha_final" name="fecha_final" style="width: 80px; height: 30px" type='text' class="form-control input-font" placeholder="Fecha" value="{{date('Y-m-d')}}">
                            <span class="input-group-addon" style="height: 15px">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                        </div>
                      </div>
                  </div>

                  <div class="inline">
                    <div class="action-button-t">
                        <label style="color: var(--app-content-secondary-color); margin-top: 4pxmargin-right: 5px; border-right: 1px solid gray; padding: 12px 2px -3px 0; line-height: 8px; margin-left: 4px; margin-top: 3px"><p style="margin-right: 5px; margin-top: 12px"> Ciudad </p></label>
                        <select style="float: right; width: 100%; margin-right: 6px; height: 70%; margin-left: 6px" id="city">
                          <option>Seleccionar Ciudad</option>
                          <option>BARRANQUILLA</option>
                          <option>BOGOTA</option>
                        </select>
                      </div>
                  </div>

                  <div class="inline">
                    <div class="action-button-t">
                        <label style="color: var(--app-content-secondary-color); margin-top: 4pxmargin-right: 5px; border-right: 1px solid gray; padding: 12px 2px -3px 0; line-height: 8px; margin-left: 4px; margin-top: 3px"><p style="margin-right: 5px; margin-top: 12px"> Estado </p></label>
                        <select style="float: right; width: 100%; margin-right: 6px; height: 70%; margin-left: 6px" id="estado">
                          <option value="0">Seleccionar</option>
                          <option value="3">Enviada</option>
                          <option value="1">Exitosas</option>
                          <option value="2">No Exitosas</option>
                        </select>
                      </div>
                  </div>

                  <div class="inline">
                    <div class="action-button-t">
                        <label style="color: var(--app-content-secondary-color); margin-top: 4px; border-right: 1px solid gray; line-height: 11px; margin-left: 5px"><p style="margin-right: 5px; margin-top: 10px"> Usuario </p></label>
                        <select style="float: right; width: 100%; margin-right: 3px; height: 70%; margin-left: 5px" id="usuario">
                          <option value="0">Todos los Usuarios</option>
                          @foreach($usuarios as $user)
                            <option value="{{$user->id}}">{{$user->first_name.' '.$user->last_name}}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>

                  <div class="inline">
                    <div class="action-button-t">
                        <label style="color: var(--app-content-secondary-color); margin-top: 4px; border-right: 1px solid gray; line-height: 11px; margin-left: 5px"><p style="margin-right: 5px; margin-top: 10px"> Gestiones </p></label>
                        <select style="float: right; width: 100%; margin-right: 3px; height: 70%; margin-left: 5px" id="cantidad">
                          <option value="0">Todas las Gestiones</option>
                          <option value="1">1 gestión</option>
                          <option value="2">2 gestiones</option>
                          <option value="3">3 gestiones</option>
                          <option value="4">4 gestiones</option>
                          <option value="5">5 gestiones</option>
                          <option value="6">+5 gestiones</option>
                        </select>
                      </div>
                  </div>

                  <div class="inline">
                    <button class="action-button apply" style="width: 100%">
                      <span style="margin-left: 6px"> <p style="margin-top: 10px"> Buscar <span style="border-right: 1px solid gray; padding: 5px 4px 6px 0; margin-right: 5px"></span> <i style="margin-left: 6px;" class="fa fa-search" aria-hidden="true"></i></p> </span>
                    </button>
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
            <tr>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">#</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Consecutivo</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Archivos</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Fecha</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Nombre Empresa</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Solicitante</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Correo</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Ciudad</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Teléfono </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Creado Por </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Estado </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Opciones </td>
            </tr>
          </thead>
          <tbody>
            <?php $o = 1; ?>
            @foreach($portafolio as $pt)
              <tr>
                <th style="font-weight: normal; color: black">
                  <center>
                      {{$o}}
                  </center>
                </th>
                <th style="font-weight: normal; color: black">
                  <center>
                      00{{$pt->id}}
                  </center>
                </th>
                <th style="font-weight: normal; color: black">
                  <center>
                  @if($pt->ejecutivos==1)
                    <a style="margin-right: 10px; float: left" href="{{url('biblioteca_imagenes/PORTAFOLIO DE SERVICIOS.pdf')}}" target="_blank" class="btn btn-list-table btn-warning">Eje</a>
                  @endif

                  @if($pt->rutas==1)
                    <a style="margin-right: 10px; float: left" href="{{url('biblioteca_imagenes/PORTAFOLIO DE RUTAS.pdf')}}" target="_blank" class="btn btn-list-table btn-danger">Rut</a>
                  @endif

                  @if($pt->pdf_tarifas!=null)
                    <a style="margin-right: 10px; float: left" href="{{url($pt->pdf_tarifas)}}" target="_blank" class="btn btn-list-table btn-info">Tar</a>
                  @endif

                </center>
                </th>
                <th style="font-weight: normal; color: black">
                  <center>
                    {{$pt->fecha}}
                  </center>
                </th>
                <th style="text-align: center; font-weight: normal; color: black">
                  {{$pt->nombre_cliente}}
              </th>
                <th style="font-weight: normal; color: black">
                  <center>
                  {{$pt->solicitante}}
                  </center>
                </th>
                <th style="text-align: center; font-weight: normal; color: black">
                  {{$pt->correo}}
                </th>

                <th style="text-align: center; font-weight: normal; color: black">
                  {{$pt->ciudad}}
                </th>

                <th style="text-align: center; font-weight: normal; color: black">
                  {{$pt->telefono}}
                </th>

                <th style="text-align: center; font-weight: normal; color: black">
                  {{$pt->first_name.' '.$pt->last_name}}
                </th>

                <th style="font-weight: normal; color: black">
                  <center>
                    @if($pt->estado==null)
                      <div>
                        <span style="background: orange; color: black; width: 100px" class="status active">Enviada</span>
                      </div>
                    @elseif($pt->estado==1)
                      <div>
                        <span style="background: green; color: white; width: 100px" class="status active">Exitosa</span>
                      </div>
                    @else
                    <div>
                      <span style="background: red; color: white; width: 100px" class="status active">No Exitosa</span>
                    </div>
                    @endif
                    </span>
                  </center>
                </th>
                <th>
                  <a style="margin-right: 10px; float: left" target="_blank" data-id="{{$pt->id}}" data-nombre="{{$pt->nombre_cliente}}" class="btn btn-list-table btn-primary gestiones">({{$pt->cantidad_gestiones}})Gestiones <i class="fa fa-refresh" aria-hidden="true"></i></i></a>

                  @if($pt->estado==2)
                    <a title="Reactivar Negociación - SE REACTIVARÁ LA NEGOCIACIÓN" data-id="{{$pt->id}}" class="btn btn-list-table btn-info reactivar" data-id="{{$pt->id}}">REAC <i class="fa fa-repeat" aria-hidden="true"></i></i></a>
                  @else
                    <a title="Negociación Exitosa - SE ENVIARÁ CORREO A LA EMPRESA CON EL FORMATO DE INSCRIPCIÓN DE CLIENTES" data-id="{{$pt->id}}" class="@if($pt->estado!=null){{'disabled'}}@endif btn btn-list-table btn-success exitosa @if($pt->estado==2){{'disabled'}}@endif" data-id="{{$pt->id}}"><i class="fa fa-check" aria-hidden="true"></i></i></a>
                    <a title="Negociación NO Exitosa - SE CERRARÁ LA NEGOCIACIÓN CON ESTA EMPRESA" data-id="{{$pt->id}}" style="margin-left: 10px" class="@if($pt->estado!=null){{'disabled'}}@endif btn btn-list-table btn-danger no_exitosa @if($pt->estado==2){{'disabled'}}@endif" data-id="{{$pt->id}}"><i class="fa fa-close" aria-hidden="true"></i></i></a>
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
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Archivos</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Fecha</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Nombre Empresa</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Solicitante</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Correo</td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Ciudad </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Teléfono </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Creado Por </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Estado </td>
              <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Opciones </td>
            </tr>
          </tfoot>
        </table>
        <!-- Datatables -->
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

<div class="modal fade" tabindex="-1" role="dialog" id='modal_asignar'>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background: #E53935">
          <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Adjunta el formato de cierre</b></h4>
        </div>
        <div class="modal-body">
          <center>
            <form id="cierre">

              <center>
                <input class="soporte_cierre" type="file" value="Subir" name="soporte_cierre" id="soporte_cierre">
              </center>

            </form>
          </center>
        </div>

        <div class="modal-footer">

          <a id="guardar_cierre" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-check icon-btn"></i></a>

        </div>
    </div>
  </div>
</div>

<!-- Modal de Gestiones -->
<div class="modal fade" tabindex="-1" role="dialog" id='modal_gestiones'>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Gestiones Realizadas</b></h4>
        </div>
        <div class="modal-body">
          <div class="cuerpo">

          </div>
        </div>
        <div class="modal-footer">
          <a id="agregar_gestion" style="float: right; margin-right: 6px; margin-left: 5px" class="btn btn-success btn-icon">Agregar Gestión<i class="fa fa-check icon-btn"></i></a>
          <a style="float: right; margin-right: 6px; margin-left: 20px" data-dismiss="modal" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
        </div>
    </div>
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
            <div class="row tarifas_table hidden" style="height: 200px">
              <div class="col-lg-12" style="margin-top: 20px">
                <table name="clientes_fuec" id="clientes_fuec" class="table table-hover table-bordered tablesorter tabla" style="margin-top: 15px">
                   <thead>
                     <tr>
                      <td style="text-align: center;">Check All <br><center><input style="width: 15px; height: 15px;" class="select_all" type="checkbox" check="false"></center></td>
                       <td style="text-align: center;">Trayecto</td>
                       <td style="text-align: center;">Valor SUV</td>
                       <td style="text-align: center;">Valor VAN</td>
                     </tr>
                   </thead>
                   <tbody>
                     @if(isset($centrosdecosto))
                      @foreach($centrosdecosto as $ruta)

                          <?php
                          $tarifa = DB::table('tarifas')
                          ->leftJoin('traslados', 'traslados.id', '=', 'tarifas.trayecto_id')
                          ->select('tarifas.id', 'tarifas.trayecto_id', 'tarifas.proveedor_auto', 'tarifas.proveedor_van', 'tarifas.cliente_auto', 'tarifas.cliente_van', 'tarifas.centrodecosto_id', 'traslados.nombre')
                          ->whereIn('tarifas.centrodecosto_id', [97,292])
                          //->whereNotNull('tarifas.localidad')
                          ->where('tarifas.trayecto_id',$ruta->id)
                          ->first();
                          ?>
                          @if($tarifa!=null)
                            <tr>
                                <td><center><input class="clients" data-id="{{$ruta->id}}" data-traslado="{{$ruta->nombre}}" data-auto="{{$tarifa->cliente_auto}}" data-van="{{$tarifa->cliente_van}}" style="width: 15px; height: 15px;" type="checkbox" check="false"></center></td>
                                <td>{{$ruta->nombre}}</td>
                                <td>
                                  @if($tarifa!=null)
                                      <p class="bolder text-primary" style="margin: 0 !important; font-size: 12px; text-align: center">$ {{number_format($tarifa->cliente_auto)}} </p>
                                  @else
                                      <p class="bolder text-danger" style="margin: 0 !important; font-size: 13px; text-align: center"> Sin Tarifa </p>
                                  @endif
                                </td>
                                <td>
                                  @if($tarifa!=null)
                                      <p class="bolder text-primary" style="margin: 0 !important; font-size: 12px; text-align: center">$ {{number_format($tarifa->cliente_van)}} </p>
                                  @else
                                      <p class="bolder text-danger" style="margin: 0 !important; font-size: 13px; text-align: center"> Sin Tarifa </p>
                                  @endif
                                </td>
                            </tr>
                          @endif

                      @endforeach
                    @endif
                   </tbody>
                 </table>
              </div>
            </div>
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

<div class="modal fade" tabindex="-1" role="dialog" id='modal_cliente' data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Creación de Cliente</b></h4>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-2 hidden">
                            <label class="obligatorio" for="tipo_cliente">Tipo de cliente</label>
                            <select class="form-control input-font" id="tipo_cliente" name="tipo_cliente">
                                <option value="0">TIPO CLIENTE</option>
                                <option value="1" selected>INTERNO</option>
                                <option value="2">AFILIADO EXTERNO</option>
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <label class="obligatorio" for="nit">Nit.</label>
                            <input class="form-control input-font" type="text" id="nit">
                        </div>
                        <div class="col-xs-2">
                            <label class="obligatorio" for="digitoverificacion">Digito verificacion</label>
                            <select name="digitoverificacion" class="form-control input-font" id="digitoverificacion">
                                <option>-</option>
                                <option>0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <label class="obligatorio" for="razonsocial">Razon social</label>
                            <input class="form-control input-font" type="text" id="razonsocial">
                        </div>
                        <div class="col-xs-2">
                            <label class="obligatorio" for="tipoempresa">Tipo de empresa</label>
                            <select class="form-control input-font" name="tipoempresa" id="tipoempresa">
                                <option>-</option>
                                <option>P.N</option>
                                <option>S.A.S</option>
                                <option>S.A</option>
                                <option>S.C.A</option>
                                <option>S.C</option>
                                <option>L.T.D.A</option>
                                <option>OTROS</option>
                            </select>
                        </div>
                        <div class="col-xs-2">
                              <label class="obligatorio" for="localidad">Localidad</label>
                              <select class="form-control input-font" name="localidad" id="localidad">
                                  <option>-</option>
                                  <option>Barranquilla</option>
                                  <option>Bogota</option>
                                  <option>Provisional</option>
                              </select>
                          </div>
                        <div class="col-xs-3">
                            <label class="obligatorio" for="direccion">Direccion</label>
                            <input class="form-control input-font" type="text" id="direccion">
                        </div>

                        <div class="col-xs-2">
                            <label class="obligatorio" for="ciudad">Ciudad</label>
                            <select class="form-control input-font" id="ciudad">
                                <option>-</option>
                                <option>BARRANQUILLA</option>
                                <option>BOGOTA</option>
                                <option>CARTAGENA</option>
                                <option>CALI</option>
                                <option>MEDELLIN</option>
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <label class="obligatorio" for="email">Email</label>
                            <input class="form-control input-font" type="text" id="email" autocomplete="off">
                        </div>
                        <div class="col-xs-2">
                            <label class="obligatorio" for="telefono">Telefono</label>
                            <input class="form-control input-font" type="text" id="telefono">
                        </div>
                        <div class="col-xs-2">
                            <label class="obligatorio">Credito</label>
                            <select id="credito" class="form-control input-font">
                                <option value="0">-</option>
                                <option value="1">SI</option>
                                <option value="2">NO</option>
                            </select>
                        </div>
                        <div class="col-xs-2 hidden plazo_pago">
                            <label class="obligatorio">Plazo de Pago</label>
                            <input type="text" class="form-control input-font" id="plazo_pago">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-3">
                          <label class="obligatorio" for="localidad">Tipo Tarifa Cliente</label>
                          <select class="form-control input-font" name="tipo_tarifa" id="tipo_tarifa">
                              <option value="0">-</option>
                              <option value="1">Tarifa Aotour</option>
                              <option value="2">Tarifa Negociada</option>
                          </select>
                        </div>
                        <div class="col-xs-3">
                          <label class="obligatorio" for="localidad">Tipo Tarifa Proveedor</label>
                          <select class="form-control input-font" name="tipo_tarifa_proveedor" id="tipo_tarifa_proveedor">
                              <option value="0">-</option>
                              <option value="1">Tarifa Aotour</option>
                              <option value="2">Tarifa Negociada</option>
                          </select>
                        </div>
                        <div class="col-xs-2">
                          <label class="obligatorio" for="recargo_nocturno">Recargo Nocturno</label>
                          <select class="form-control input-font" name="recargo_nocturno" id="recargo_nocturno">
                              <option value="0">-</option>
                              <option value="1">Si</option>
                              <option value="2">No</option>
                          </select>
                        </div>
                        <div class="col-xs-2 horarios">
                            <label class="obligatorio" for="localidad">Desde</label>
                            <div class="input-group">
                                <div class="input-group date" id="datetimepicker8">
                                    <input type="text" class="form-control input-font" id="desde" autocomplete="off" placeholder="Hora inicio">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2 horarios">
                            <label class="obligatorio" for="localidad">Hasta</label>
                            <div class="input-group">
                                <div class="input-group date" id="datetimepicker9">
                                    <input type="text" class="form-control input-font" id="hasta" autocomplete="off" placeholder="Hora fin">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>

          <!--<button id="guardar_gestion" style="width: 100%" type="button" class="btn btn-primary btn-icon">Agregar Gestión<i class="fa fa-plus icon-btn"></i></button>-->

        <div class="modal-footer">
          <a id="guardar_cliente" style="float: right; margin-right: 6px; margin-left: 5px" class="btn btn-primary btn-icon">Guardar Cliente<i class="fa fa-save icon-btn"></i></a>
          <a style="float: right; margin-right: 6px; margin-left: 5px" class="btn btn-danger btn-icon volvers">Cerrar<i class="fa fa-times icon-btn"></i></a>
        </div>
    </div>
  </div>
</div>

<div class="modal" id='modal_img' tabindex="-1" style="position: fixed;" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header success">
            <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea h4 text-center mt-3 mb-4 pb-3">Soporte</b></h4>
          </div>
          <div class="modal-body">

							<div class="panel-body" style="height: 700px">

		               <center>
                     <img style="height: 700px" class="img-responsive" id="img_ingreso">
                   </center>

							</div>

          </div>

          <div class="modal-footer">

            <a id="cerrar" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-danger btn-icon">Regresar<i class="fa fa-arrow-left icon-btn"></i></a>

          </div>
      </div>
    </div>
  </div>

@include('scripts.scripts')
<script src="{{url('bootstrap-fileinput-master\js\plugins\canvas-to-blob.min.js')}}" type="text/javascript"></script>
<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
     This must be loaded before fileinput.min.js -->
<script src="{{url('bootstrap-fileinput-master\js\plugins\sortable.min.js')}}" type="text/javascript"></script>

<script src="{{url('bootstrap-fileinput-master\js\plugins\purify.min.js')}}" type="text/javascript"></script>
<!-- the main fileinput plugin file -->
<script src="{{url('bootstrap-fileinput-master\js\fileinput.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script><script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/pasajerosv2.js')}}"></script>
<script>

  $(document).on('ready', function() {

    $("#input-44").fileinput({
        uploadUrl: '/file-upload-batch/2',
        maxFilePreviewSize: 10240
    });

  });

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

    $('.select_all').change(function(e){

        if ($(this).is(':checked')) {
            $('#clientes_fuec tbody tr').each(function(index){
                $(this).children("td").each(function (index2){
                    switch (index2){
                        case 0:

                            $(this).find('input[type="checkbox"]').prop('checked',true).attr('check',true);

                        break;
                    }
                });
            });
        }else if(!$(this).is(':checked')){
            $('#clientes_fuec tbody tr').each(function(index){
                $(this).children("td").each(function (index2){
                    switch (index2){
                        case 0:

                            $(this).find('input[type="checkbox"]').prop('checked',false).attr('check',false);

                        break;
                    }
                });
            });
        }
    });

    $('.cerrar_pqr').click(function(){
      var id = $(this).attr('data-id');

      $('#modal_asignar').modal('show');
      $('#guardar_cierre').attr('data-id',id);

    });

    $('#guardar_cierre').click(function(){

      var id = $(this).attr('data-id');
      var file = $('#soporte_cierre').val();

      if(file===''){

        $.confirm({
          title: '¡Atención!',
          content: 'No has adjuntado el documento!',
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

        $.confirm({
          title: '¡Atención!',
          content: '¿Estás seguro de cerrar la <b>PQR N° '+id+'</b>? ',
          buttons: {
              confirm: {
                  text: 'Confirmar',
                  btnClass: 'btn-danger',
                  keys: ['enter', 'shift'],
                  action: function(){

                    formData = new FormData($('#cierre')[0]);
                    formData.append('id',id);

                    $.ajax({
                        method: "post",
                        url: "../reportes/cerrarpqr",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {

                            if(data.respuesta===false){

                              $.confirm({
                                title: '¡Atención!',
                                content: 'No se pudo ejecutar la acción. ¡Intentalo de nuevo!',
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

                            }else if(data.respuesta===true){

                              $.confirm({
                                title: '¡PQR cerrada!',
                                content: 'Se ha cerrado la pqr seleccionada y el cliente fue notificado vía email.',
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

                            }else if(data.respuesta==='relogin'){
                                location.reload();
                            }else{
                                $('.errores-modal ul li').remove();
                                $('.errores-modal').addClass('hidden');
                            }
                        }
                    });

                  }

              },
              cancel: {
                text: 'Cancelar',
              }
          }

        });

      }

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
              htmlJson += '<li class="list-group-item"><b><span style="color: orange">'+$json[a].usuario+' <i class="fa fa-user" aria-hidden="true"></i></span><br>'+$json[a].gestion+'<br><span style="color: orange; font-size: 10px; float: right;">'+$json[a].fecha+'<span></b>'+btns+'</li>';
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
          $('#modal_gestiones').modal('show');

        }else if(data.respuesta==false){

        }

      });

    });

    $('#agregar_gestion').click(function() {

      var id = $(this).attr('data-id');

      $('#guardar_gestion').attr('data-id',id);
      $('#guardar_gestion').attr('data-nombre',$(this).attr('data-nombre'));

      $('#cliente_name').html($(this).attr('data-nombre'))
      $('#modal_gestiones').modal('hide');
      $('#modal_nueva').modal('show');

    });

    $('#guardar_gestion').click(function() {

      var id = $(this).attr('data-id');
      var descripcion = $('#descripcion').val().toUpperCase().trim();

      if(descripcion===''){

        $.confirm({
            title: 'Atención!',
            content: 'No has ingresado datos en el campo de descripción...',
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

        //test

        var formData = new FormData($('#formulario')[0]);
        formData.append('id',id);
        formData.append('descripcion',descripcion);

        $.ajax({
          url: 'guardargestion',
          processData: false,
          contentType: false,
          method: 'post',
          data: formData,
          success: function(data){

            if(data.respuesta==true){

              $.confirm({
                  title: 'Grandioso!',
                  content: '¡Se ha agregado la gestión de forma satisfactoria!',
                  buttons: {
                      confirm: {
                          text: 'Ok',
                          btnClass: 'btn-primary',
                          keys: ['enter', 'shift'],
                          action: function(){

                            $('#modal_nueva').modal('hide');

                            var id = $('#guardar_gestion').attr('data-id');
                            var nombre = $('#guardar_gestion').attr('data-nombre');

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
                                  htmlJson += '<li class="list-group-item"><b><span style="color: orange">'+$json[a].usuario+' <i class="fa fa-user" aria-hidden="true"></i></span><br>'+$json[a].gestion+'<br><span style="color: orange; font-size: 10px; float: right;">'+data.portafolio.fecha+'<span></b>'+btns+'</li>';
                                }

                                $('.cuerpo').append(start+htmlJson+end);

                                $('#agregar_gestion').attr('data-id',id);
                                $('#agregar_gestion').attr('data-nombre',nombre);
                                $('#modal_gestiones').modal('show');

                              }else if(data.respuesta==false){

                              }

                            });

                          }

                      }
                  }
              });

            }else if(data.respuesta==false){

            }

          },
          error: function (request, status, error) {
              alert('Hubo un error, llame al administrador del sistema'+request+status+error);
              alert(request.responseText);
              alert(status.responseText);
              alert(error.responseText);
          }
        });
        //test

      }

    })

    $(document).on('click', '.exitosa', function(){

      var id = $(this).attr('data-id');

      $.confirm({
          title: 'Atención!',
          content: '¿Estás seguro de registrar esta negociación como <b style="color: green">EXITOSA</b>?',
          buttons: {
              confirm: {
                  text: 'Estoy seguro',
                  btnClass: 'btn-success',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: 'exitosa',
                      method: 'post',
                      data: {id: id}
                    }).done(function(data){

                      if(data.respuesta==true){

                        $.confirm({
                            title: '¡Grandioso!',
                            content: 'Gracias a tu excelente gestión esta negociación fue exitosa.<br>Procede a crear el cliente...',
                            buttons: {
                                confirm: {
                                    text: 'Ir a crearlo',
                                    btnClass: 'btn-primary',
                                    keys: ['enter', 'shift'],
                                    action: function(){

                                      //Consultar datos del portafolio
                                      $.ajax({
                                        url: 'portaf',
                                        method: 'post',
                                        data: {id: id}
                                      }).done(function(data){

                                        if(data.respuesta==true){

                                          $('#razonsocial').val(data.portafolio.nombre_cliente)
                                          $('#direccion').val(data.portafolio.direccion)
                                          $('#telefono').val(data.portafolio.telefono)
                                          $('#email').val(data.portafolio.correo)
                                          $('#ciudad').val(data.portafolio.ciudad)
                                          $('#modal_cliente').modal('show');

                                        }else if(data.respuesta==false){

                                        }

                                      });
                                      //Consultar datos del portafolio

                                    }

                                },
                                cancel: {
                                  text: 'No crearlo',
                                  btnClass: 'btn-danger',
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
      //end

    });

    $(document).on('click', '.no_exitosa', function(){

      var id = $(this).attr('data-id');

      $.confirm({
          title: 'Atención!',
          content: '¿Estás seguro de resgistrar esta negociación como <b style="color: red">NO EXITOSA</b> ?',
          buttons: {
              confirm: {
                  text: 'Estoy seguro',
                  btnClass: 'btn-success',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: 'noexitosa',
                      method: 'post',
                      data: {id: id}
                    }).done(function(data){

                      if(data.respuesta==true){

                        $.confirm({
                            title: '¡Negociación terminada!',
                            content: 'Esta negociación se registró como <b style="color: red">NO EXITOSA!</b>',
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

    });

    $(document).on('click', '.reactivar', function(){

      var id = $(this).attr('data-id');

      $.confirm({
          title: 'Atención!',
          content: '¿Estás seguro de <b style="color: blue">REACTIVAR</b> esta negociación?',
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
                            content: 'Esta negociación se ha reactivado.',
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

    $('.volver').click(function() {

      $('#modal_nueva').modal('hide');
      $('#modal_gestiones').modal('show');

    })

    $('.volvers').click(function() {

      $.confirm({
          title: 'Atención!',
          content: 'Estás seguro de cerrar esta ventana?<br><br>Se recargará la página...',
          buttons: {
              confirm: {
                  text: 'Estoy seguro',
                  btnClass: 'btn-danger',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $('#modal_cliente').modal('hide');
                    location.reload();

                  }

              },
              cancel: {
                text: 'Seguir aquí',
                btnClass: 'btn-success',
                action: function(){
                }
              }
          }
      });

    })

    $('#recargo_nocturno').change(function() {

      var id = $(this).val();
      //console.log(id);
      if(id==2){
        $('.horarios').addClass('hidden');
      }else{
        $('.horarios').removeClass('hidden');
      }

    });

    $(document).on('click', '.soport', function(){

      var imgs = $(this).attr('data-url');
      var url = 'https://app.aotour.com.co/autonet/biblioteca_imagenes/reportes/soporte_gestiones/'+imgs;
      console.log(url);

      $('#modal_img').modal('show');
			$('#modal_gestiones').modal('hide');
      $('#img_ingreso').attr('src',url);

    });

    $('#cerrar').click(function(){

			$('#modal_img').modal('hide');
			$('#modal_gestiones').modal('show');

		});

    //GUARDAR NUEVO CENTRO DE COSTO
    $('#guardar_cliente').click(function(e){
        e.preventDefault();

        var nombre = $('#razonsocial').val().trim().toUpperCase();

        formData = new FormData($('#formulario')[0]);

        formData.append('tipo_cliente',$('#tipo_cliente').val());
        formData.append('razonsocial',$('#razonsocial').val().trim().toUpperCase());
        formData.append('nit',$('#nit').val().trim());
        formData.append('digitoverificacion',$('#digitoverificacion').val());
        formData.append('tipoempresa',$('#tipoempresa option:selected').html().trim().toUpperCase());
        formData.append('localidad',$('#localidad option:selected').html().trim().toUpperCase());
        formData.append('direccion',$('#direccion').val().trim().toUpperCase());
        formData.append('ciudad',$('#ciudad option:selected').html().trim().toUpperCase());
        formData.append('email',$('#email').val().trim().toUpperCase());
        formData.append('telefono',$('#telefono').val().trim());
        formData.append('credito',$('#credito').val().trim());

        formData.append('tipo_tarifa',$('#tipo_tarifa').val());
        formData.append('tipo_tarifa_proveedor',$('#tipo_tarifa_proveedor').val());
        formData.append('recargo_nocturno',$('#recargo_nocturno').val());
        formData.append('desde',$('#desde').val());
        formData.append('hasta',$('#hasta').val());

        $.ajax({
            type: "post",
            url: "nuevocentro",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {

                if(data.respuesta===false){

                  $.confirm({
                      title: 'Error!',
                      content: 'No ha sido posible crear a este cliente. Comunícate con el administrador del sistema.',
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

                }else if(data.respuesta===true){

                  $.confirm({
                      title: '¡Excelente!',
                      content: '<b style="color: blue">'+nombre+'</b> ha sido creado como cliente.',
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

                }else if(data.respuesta==='relogin'){
                    location.reload();
                }else{
                    $('.errores-modal ul li').remove();
                    $('.errores-modal').addClass('hidden');
                }
            }
        });

    });

    $('#datetimepicker8, #datetimepicker9').datetimepicker({
        format: 'HH:mm',
        locale: 'es',
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
            { 'sWidth': '1%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '3%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '4%' },
            { 'sWidth': '1%' },
            { 'sWidth': '2%' }
          ],
        });

    $('#mostrar_tarifas').click(function(){
      $(this).addClass('hidden')
      $('.soportes').addClass('hidden');
      $('.tarifas_table').removeClass('hidden');
      $('#enviar_tarifas_seleccionadas').removeClass('hidden');
      $('#enviar_tarifas_seleccionadas').attr('data-id',$(this).attr('data-id'));
      $('#esconder_tarifas').removeClass('hidden');
      $('#descripcion').attr('disabled','disabled');
      $('#guardar_gestion').attr('disabled','disabled');
    });

    $('#esconder_tarifas').click(function(){
      $(this).addClass('hidden')
      $('.soportes').removeClass('hidden');
      $('.tarifas_table').addClass('hidden');
      $('#enviar_tarifas_seleccionadas').addClass('hidden');
      $('#mostrar_tarifas').removeClass('hidden');
      $('#descripcion').removeAttr('disabled','disabled');
      $('#guardar_gestion').removeAttr('disabled','disabled');
    });

    $('#enviar_tarifas_seleccionadas').click(function(e){

      var id = $(this).attr('data-id');

      var idArray = [];
  		var traslado = [];
  		var valorAuto = [];
  		var valorVan = [];
      var cont = 0;
      var datas = '';

      e.preventDefault();

      $('#clientes_fuec tbody tr').each(function(index){

  			var valorCheckbox = $(this).find('td input[type="checkbox"]').attr('check');

        $(this).children("td").each(function (index2){
  					var valorCheckbox2 = $(this).find('input[type="checkbox"]').attr('check');

            switch (index2){
                case 0:
                    var $objeto = $(this).find('.clients');

                    if ($objeto.is(':checked')) {
                        cont++;
                        datas += '<b>'+$objeto.attr('data-traslado')+'</b><br>'
                        idArray.push($objeto.attr('data-id'));
  											traslado.push($objeto.attr('data-traslado'));
  											valorAuto.push($objeto.attr('data-auto'));
  											valorVan.push($objeto.attr('data-van'));
                    }

                break;
            }
        });

      });

      console.log(idArray)
      console.log(traslado)
      console.log(valorAuto)
      console.log(valorVan)

      if( !cont!=0){
        $.confirm({
          title: '¡Atención!',
          content: 'No has seleccionado ninguna tarifa...',
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
        //Ajax

        $.confirm({
          title: '¡Atención!',
          content: 'Estás seguro de enviar estas tarifas?<br><br>'+datas,
          buttons: {
              confirm: {
                  text: 'Ok',
                  btnClass: 'btn-danger',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: 'enviartarifasgestion',
                      method: 'post',
                      data: {id: id, idArray: idArray, traslado: traslado, valorAuto: valorAuto, valorVan: valorVan}
                    }).done(function(data){

                      if(data.respuesta==true){

                        $.confirm({
                            title: 'Tarifas enviadas con éxito!',
                            content: 'Se envió un correo con las tarifas a este potencial cliente.',
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
                    //Ajax

                  }

              },
              cancel: {
                text: 'Cancelar',
              }
          }

        });

      }

    });

    $('.apply').click(function() {

      var fecha_inicial = $('#fecha_inicial').val();
      var fecha_final = $('#fecha_final').val();
      var ciudad = $('#city').val();
      var estado = $('#estado').val();
      var usuario = $('#usuario').val();
      var cantidad = $('#cantidad').val();

      $tablecuentas.clear().draw();

      $.ajax({
        url: '../reportes/search',
        method: 'post',
        data: {fecha_inicial: fecha_inicial, fecha_final: fecha_final, ciudad: ciudad, estado: estado, usuario: usuario, cantidad: cantidad}
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

          for(var i in data.reportes) {

            var htmlCode = '';
            var files = '';

            if(data.reportes[i].ejecutivos==1){
              files +='<a style="margin-right: 10px; float: left" href="https://app.aotour.com.co/autonet/biblioteca_imagenes/PORTAFOLIO DE SERVICIOS.pdf" target="_blank" class="btn btn-list-table btn-warning">Eje</a>';
            }

            if(data.reportes[i].rutas==1){
              files+='<a style="margin-right: 10px; float: left" href="https://app.aotour.com.co/autonet/biblioteca_imagenes/PORTAFOLIO DE RUTAS.pdf" target="_blank" class="btn btn-list-table btn-danger">Rut</a>';
            }

            if(data.reportes[i].pdf_tarifas!=null){
              files+='<a style="margin-right: 10px; float: left" href="https://app.aotour.com.co/autonet/'+data.reportes[i].pdf_tarifas+'" target="_blank" class="btn btn-list-table btn-info">Tar</a>';
            }

            var btnns = '';
            var complement = '';

            var classe = '';
            if(data.reportes[i].estado!=null){
              classe = 'disabled';
            }

            if(data.reportes[i].estado==2){
              complement+='<a title="Reactivar Negociación - SE REACTIVARÁ LA NEGOCIACIÓN" data-id="'+data.reportes[i].id+'" class="btn btn-list-table btn-info reactivar" data-id="'+data.reportes[i].id+'">REAC <i class="fa fa-repeat" aria-hidden="true"></i></i></a>';
            }else{
              complement+='<a title="Negociación Exitosa - SE ENVIARÁ CORREO A LA EMPRESA CON EL FORMATO DE INSCRIPCIÓN DE CLIENTES" data-id="'+data.reportes[i].id+'" class="'+classe+' btn btn-list-table btn-success exitosa" data-id="'+data.reportes[i].id+'"><i class="fa fa-check" aria-hidden="true"></i></i></a>'+
              '<a title="Negociación NO Exitosa - SE CERRARÁ LA NEGOCIACIÓN CON ESTA EMPRESA" data-id="'+data.reportes[i].id+'" style="margin-left: 10px" class="'+classe+'  btn btn-list-table btn-danger no_exitosa" data-id="'+data.reportes[i].id+'"><i class="fa fa-close" aria-hidden="true"></i></i></a>';
            }

            btnns +='<a style="margin-right: 10px; float: left" target="_blank" data-id="'+data.reportes[i].id+'" data-nombre="'+data.reportes[i].nombre_cliente+'" class="btn btn-list-table btn-primary gestiones">('+data.reportes[i].cantidad_gestiones+')Gestiones <i class="fa fa-refresh" aria-hidden="true"></i></i></a>';

            var estado = '';
            var part = '';

            if(data.reportes[i].estado==null){
              part +='<div>'+
                '<span style="background: orange; color: black; width: 100px" class="status active">Enviada</span>'+
              '</div>';
            }else if(data.reportes[i].estado==1){
              part +='<div>'+
                '<span style="background: green; color: white; width: 100px" class="status active">Exitosa</span>'+
              '</div>';
            }else{
              part +='<div>'+
                '<span style="background: red; color: white; width: 100px" class="status active">No Exitosa</span>'+
              '</div>';
            }

            estado +='<center><div class="product-cell image"><span style="color: black">'+
                part+
              '</span>'+
            '</div></center>';

            /*filtro datatable*/
            $tablecuentas.row.add([
              '<center>'+(parseInt(i)+1)+'</center>',
              '<center>00'+data.reportes[i].id+'</center>',
              '<center>'+files+'</center>',
              '<center>'+data.reportes[i].fecha+'</center>',
              '<center>'+data.reportes[i].nombre_cliente+'</center>',
              '<center>'+data.reportes[i].solicitante+'</center>',
              '<center>'+data.reportes[i].correo+'</center>',
              '<center>'+data.reportes[i].ciudad+'</center>',
              '<center>'+data.reportes[i].telefono+'</center>',
              '<center>'+data.reportes[i].first_name+' '+data.reportes[i].last_name+'</center>',
              estado,
              btnns+complement
            ]).draw();

          }

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

  });


</script>
</body>
</html>
