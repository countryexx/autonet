<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Autonet | Listado de Pqr</title>
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
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
      border: 3px solid gray;
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
        border: 3px solid gray;
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
        background-color: gray;
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
          &.status-cell { flex: 0.42; }
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
    <div class="col-lg-2">
        <h1 class="h_titulo">LISTADO DE PQR</h1>

    </div>
    <!--<div class="col-xs-12 col-md-12 col-lg-12">
      <h3 class="h_titulo">LISTADO DE COTIZACIONES</h3>
      <form id="formulario" class="form-inline">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group date" id="datetimepicker1">
                  <input id="fecha_inicial" value="{{date('Y-m-d')}}" name="fecha_inicial" style="width: 89px;" type="text" class="form-control input-font">
                  <span class="input-group-addon">
                      <span class="fa fa-calendar">
                      </span>
                  </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group date" id="datetimepicker1">
                  <input id="fecha_final" value="{{date('Y-m-d')}}" name="fecha_final" style="width: 89px;" type="text" class="form-control input-font">
                  <span class="input-group-addon">
                      <span class="fa fa-calendar">
                      </span>
                  </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group date" id="datetimepicker1">
                  <input id="fecha_vencimiento" placeholder="VENCIMIENTO" name="fecha_vencimiento" style="width: 95px;" type="text" class="form-control input-font">
                  <span class="input-group-addon">
                      <span class="fa fa-calendar">
                      </span>
                  </span>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <select type="text" name="estado" value="" class="form-control input-font">
              <option value="0">SIN ESTADO - TODAS</option>
              <option value="1">APROBADO</option>
              <option value="2">EN NEGOCIACION</option>
              <option value="3">RECHAZADO</option>
			  <option value="4">VENCIDO</option>
			  <option value="5">SIN GESTION</option>

            </select>
          </div>
          <a id="buscar" class="btn btn-default btn-icon">BUSCAR<i class="fa fa-search icon-btn"></i></a>
      </form>
      <table id="tabla_cotizaciones" class="table table-bordered hover tabla">
        <thead>
          <tr>
            <th>#</th>
            <th>Fecha</th>
			<th>Vence</th>
            <th>Nombre completo</th>

            <th>Asunto</th>
            <th>Vendedor</th>
			<th>Contacto</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Informacion</th>
          </tr>
        </thead>
        <tbody>
          @if(isset($cotizaciones))
            @foreach($cotizaciones as $cotizacion)
              <tr>
                <td>{{$cotizacion->consecutivo}}</td>
                <td>{{$cotizacion->fecha}}</td>
				<td>{{$cotizacion->fecha_vencimiento}}</td>
                <td>{{$cotizacion->nombre_completo}}</td>

                <td>{{$cotizacion->asunto}}</td>
                <td>{{$cotizacion->vendedor}}</td>
				<td>{{$cotizacion->contacto}}</td>
                <?php
                  $tipo = '';
                  if(intval($cotizacion->tipo)===1){
                    $tipo = 'TRANSPORTE';
                  }elseif(intval($cotizacion->tipo)===2){
                    $tipo = 'TURISMO';
                  }elseif(intval($cotizacion->tipo)===3){
                    $tipo = 'AMBAS';
                  }
                ?>
                <td>{{$tipo}}</td>
                <td>
                  <select data-id="{{$cotizacion->id}}"  class="form-control input-font estado">

                    @if(intval($cotizacion->estado)===0)
                    <option value="0" selected disabled>-</option>
                    @else
                    <option value="0" disabled>-</option>
                    @endif

                    @if(intval($cotizacion->estado)===1)
                    <option value="1" selected>APROBADO</option>
                    @else
                    <option value="1">APROBADO</option>
                    @endif

                    @if(intval($cotizacion->estado)===2)
                    <option selected value="2" disabled>EN NEGOCIACION</option>
                    @else
                    <option value="2" disabled>EN NEGOCIACION</option>
                    @endif

                    @if(intval($cotizacion->estado)===3)
                    <option selected value="3">RECHAZADO</option>
                    @else
                    <option value="3">RECHAZADO</option>
                    @endif

					@if(intval($cotizacion->estado)===4)
                    <option selected value="4" disabled >VENCIDO</option>
                    @else
                    <option value="4" disabled>VENCIDO</option>
                    @endif

					@if(intval($cotizacion->estado)===5)
                    <option selected value="5" disabled>SIN GESTION</option>
                    @else
                    <option value="5" disabled>SIN GESTION</option>
                    @endif

                  </select>
                </td>
                <td>
				@if($cotizacion->contenido_html != null || $cotizacion->contenido_html==='')
                  <a href="{{url('cotizaciones/detalles/'.$cotizacion->id)}}" class="btn btn-list-table btn-primary">VER <i class="fa fa-file-o" aria-hidden="true"></i></i></a>
                  <a href="{{url('cotizaciones/exportarcotizacion/'.$cotizacion->id)}}" class="btn btn-list-table btn-danger">PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>

				@else
					<a href="{{url('cotizaciones/detallescot/'.$cotizacion->id)}}" class="btn btn-list-table btn-primary">VER <i class="fa fa-pencil" aria-hidden="true"></i></i></a>
					<a href="{{url('cotizaciones/exportarcot/'.$cotizacion->id)}}" class="btn btn-list-table btn-danger">PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
				@endif
              </tr>
            @endforeach
          @endif
        </tbody>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Fecha</th>
			<th>Vence</th>
            <th>Nombre completo</th>

            <th>Asunto</th>
            <th>Vendedor</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Informacion</th>
          </tr>
        </tfoot>
      </table>
    </div>-->

    <div class="col-xs-12">




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


          <?php
          $ano = 2023;
          $mess = 05;
           ?>
          <div class="app-content-actions-wrapper">
            <div class="filter-button-wrapper">
              <div class="row">
                <div class="col-lg-12">


                  <div class="inline">
                    <div class="action-button-t">
                        <label style="color: var(--app-content-secondary-color); margin-top: 4px; margin-right: 5px; border-right: 3px solid gray; line-height: 11px; margin-left: 8px"><p style="margin-right: 5px; margin-top: 10px"> Ciudad </p> </label>
                        <select style="float: right; width: 100%; margin-right: 3px; height: 70%" id="ciudad">
                          <option value="0">Todas</option>
                          <option>BARRANQUILLA</option>
                          <option>BOGOTA</option>
                        </select>
                      </div>
                  </div>
                  <div class="inline">
                    <div class="action-button-t">
                        <label style="color: var(--app-content-secondary-color); margin-top: 4px; border-right: 3px solid gray; line-height: 11px; margin-left: 5px"><p style="margin-right: 5px; margin-top: 10px"> Novedad </p></label>
                        <select style="float: right; width: 100%; margin-right: 3px; height: 70%; margin-left: 5px" id="novedad">
                          <option value="0">Todas</option>
                          <option>LLEGADA TARDE</option>
                          <option>RECOGIDA TARDE</option>
                          <option>NO RECOGIDA</option>
                          <option>PRESUNTO ACOSO</option>
                          <option>CALIDAD DE SERVICIO</option>
                          <option>SIN AUTORIZACION</option>
                          <option>MANEJO PELIGROSO</option>
                          <option>USO INADECUADO DEL LENGUAJE</option>
                          <option>FALLAS MECANICAS</option>
                          <option>ACCIDENTE</option>
                          <option>INCIDENTE</option>
                          <option>NO TOMA SERVICIO</option>
                          <option>NO APLICA</option>
                        </select>
                      </div>
                  </div>
                  <!--<div class="inline">
                    <div class="action-button-t" style="width: 95%">
                      <label style="color: var(--app-content-secondary-color); margin-top: 4px" class="ano">Año</label>
                      <select class="ano" style="width: 100%;" id="anos">
                        <option @if($ano==2022){{'selected'}}@endif>2022</option>
                        <option @if($ano==2023){{'selected'}}@endif>2023</option>
                        <option @if($ano==2024){{'selected'}}@endif>2024</option>
                        <option @if($ano==2025){{'selected'}}@endif>2025</option>
                      </select>
                    </div>
                  </div>-->
                  <!--<div class="inline">
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
                  </div>-->
                  <div class="inline">
                    <button class="action-button apply" style="width: 100%">
                      <span style="margin-left: 4px"> <p style="margin-top: 10px"> Buscar <span style="border-right: 3px solid gray; padding: 6px 4px 6px 0; margin-right: 5px"></span> <i style="margin-left: 6px;" class="fa fa-search" aria-hidden="true"></i></p> </span>
                    </button>
                  </div>
                </div>

              </div>

            </div>

        </div>
        <div class="products-area-wrapper tableView" style="margin-top: 20px">
          <div class="products-header">
            <div class="product-cell price" >#</div>
            <div class="product-cell price">Tipo de Servicio</div>
            <div class="product-cell price">Solicitante</div>
            <div class="product-cell price">Ciudad</div>
            <div class="product-cell price">Fecha Solicitud</div>
            <div class="product-cell price">Fecha de Respuesta</div>
            <div class="product-cell price">Fecha de Ocurrencia</div>
            <div class="product-cell price">Novedad</div>
            <div class="product-cell price">Estado</div>
            <div class="product-cell price">Ver PQR</div>
          </div>

           @if(isset($pqr))
             @foreach($pqr as $pq)
                <div class="products-row" style="border: 1px solid #DAD9D9">
                  <button class="cell-more-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                  </button>
                    <div class="product-cell price">
                      <span style="color: black">00{{$pq->id}}</span>
                    </div>

                    <div class="product-cell image"><span class="cell-label">Sales:</span><span style="color: black">
                        {{$pq->tipo_serv}}
                      </span>
                    </div>
                    <div class="product-cell image"><span class="cell-label">Sales:</span><span style="color: black">
                        {{$pq->solicitante}}
                      </span>
                    </div>
                    <div class="product-cell category"><span class="cell-label">Category:</span><span style="color: black">
                      {{$pq->ciudad}}
                      </span>
                    </div>
                    <div class="product-cell category"><span class="cell-label">Category:</span><span style="color: black">
                      {{$pq->fecha_solicitud}}
                      </span>
                    </div>
                    <div class="product-cell category"><span style="color: black">
                      {{$pq->created_at}}
                      </span>
                    </div>
                    <div class="product-cell category"><span class="cell-label">Category:</span><span style="color: black">
                      {{$pq->fecha_ocurrencia}}
                      </span>
                    </div>

                  <div class="product-cell image"><span class="cell-label">Sales:</span><span style="color: black">
                      {{$pq->novedad}}
                    </span>
                  </div>

                  <div class="product-cell image"><span class="cell-label">Sales:</span><span style="color: black">
                    @if($pq->estado==null)
                      <div>
                        <span style="background: orange; color: black; width: 80px" class="status active">Recibida</span>
                      </div>
                    @elseif($pq->estado==1)
                      <div>
                        <span style="background: gray; color: white; width: 80px" class="status active">Leída</span>
                      </div>
                    @else
                    <div>
                      <span style="background: green; color: white; width: 80px" class="status active">Cerrada</span>
                    </div>
                    @endif
                    </span>
                  </div>

                  <div class=" product-cell price form-inline">
                    <a title="PQR enviada" target="_blank" href="{{url('biblioteca_imagenes/reportes/pqr/pdf/'.$pq->soporte_pqr)}}" class="btn btn-list-table btn-danger">PQR <i class="fa fa-share" aria-hidden="true"></i></i></a>

                    <a title="Ver la respuesta" style="margin-left: 5px" target="_blank" href="{{url('biblioteca_imagenes/reportes/pqr/Respuesta_pqr_'.$pq->id.'.pdf')}}" data-id="{{$pq->id}}" class="btn btn-list-table btn-success leida">Resp.<i class="fa fa-reply" aria-hidden="true"></i></i></a>



                    @if($pq->estado==2)
                      <a title="Ver el cierre de la PQR" style="margin-left: 10px" target="_blank" href="{{url('biblioteca_imagenes/reportes/pqr/cierre/'.$pq->soporte_cierre)}}" class="btn btn-list-table btn-warning">Cierre <i class="fa fa-file-o" aria-hidden="true"></i></i></a>
                    @else
                      <a style="margin-left: 10px; color: white" target="_blank" class="btn btn-list-table btn-default disabled">Cierre <i class="fa fa-file-o" aria-hidden="true"></i></i></a>
                    @endif
                  </div>

                </div>
                @endforeach
              @endif


        </div>

    </div>

    </div>
    @include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script><script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
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

        $('.leida').click(function(){

          var id = $(this).attr('data-id');

          $.ajax({
            url: '../reportes/verpqr',
            method: 'post',
            data: {id: id}
          }).done(function(data){

            if(data.respuesta==true){

              //$('#sin_datos').addClass('hidden');

            }else if(data.respuesta==false){

              $('.products-row').html('');

            }

          });

        })

        $('.apply').click(function() {

          var novedad = $('#novedad option:selected').val();
          var ciudad = $('#ciudad option:selected').val();

          $.ajax({
            url: '../reportes/filtrarpqr',
            method: 'post',
            data: {novedad: novedad, ciudad: ciudad}
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

              for(var i in data.reportes) {

                var htmlCode = '';

                if(data.reportes[i].estado===null){

                  var estadoss = '<div>'+
                    '<span style="background: orange; color: black; width: 80px" class="status active">Recibida</span>'+
                  '</div>';

                }else if(data.reportes[i].estado===1){

                  var estadoss = '<div>'+
                    '<span style="background: gray; color: white; width: 80px" class="status active">Leída</span>'+
                  '</div>';

                }else{

                  var estadoss = '<div>'+
                    '<span style="background: green; color: white; width: 80px" class="status active">Cerrada</span>'+
                  '</div>';

                }

                if(data.reportes[i].estado===2){

                  var cierree = '<a title="Ver el cierre de la PQR" style="margin-left: 10px" target="_blank" href="../biblioteca_imagenes/reportes/pqr/cierre/'+data.reportes[i].soporte_cierre+'" class="btn btn-list-table btn-warning">Cierre <i class="fa fa-file-o" aria-hidden="true"></i></i></a>';
                }else{
                  var cierree = '<a style="margin-left: 10px; color: white" target="_blank" class="btn btn-list-table btn-default disabled">Cierre <i class="fa fa-file-o" aria-hidden="true"></i></i></a>';
                }

                htmlCode +='<div class="products-row" style="border: 1px solid #DAD9D9">'+
                  '<button class="cell-more-button">'+
                    '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>'+
                  '</button>'+
                    '<div class="product-cell category">'+
                      '<span style="color: black">00'+data.reportes[i].id+'</span>'+
                    '</div>'+
                    '<div class="product-cell category"><span style="color: black">'+
                      data.reportes[i].tipo_serv+
                      '</span>'+
                    '</div>'+
                    '<div class="product-cell image"><span class="cell-label">Sales:</span><span style="color: black">'+
                        data.reportes[i].solicitante+
                      '</span>'+
                    '</div>'+
                    '<div class="product-cell category"><span class="cell-label">Category:</span><span style="color: black">'+
                      data.reportes[i].ciudad+
                      '</span>'+
                    '</div>'+
                    '<div class="product-cell category"><span class="cell-label">Category:</span><span style="color: black">'+
                      data.reportes[i].fecha_solicitud+
                      '</span>'+
                    '</div>'+
                    '<div class="product-cell category"><span class="cell-label">Category:</span><span style="color: black">'+
                      data.reportes[i].created_at+
                      '</span>'+
                    '</div>'+


                  '<div class="product-cell image"><span class="cell-label">Sales:</span><span style="color: black">'+
                      data.reportes[i].fecha_ocurrencia+
                    '</span>'+
                  '</div>'+

                  '<div class="product-cell image"><span class="cell-label">Sales:</span><span style="color: black">'+
                      data.reportes[i].novedad+
                    '</span>'+
                  '</div>'+
                  '<div class="product-cell image"><span class="cell-label">Sales:</span><span style="color: black">'+
                    estadoss+
                    '</span>'+
                  '</div>'+
                  '<div class=" product-cell price form-inline">'+
                    '<a title="PQR enviada" target="_blank" href="../biblioteca_imagenes/reportes/pqr/pdf/'+data.reportes[i].soporte_pqr+'" class="btn btn-list-table btn-danger">PQR <i class="fa fa-share" aria-hidden="true"></i></i></a>'+
                    '<a title="Ver la respuesta" style="margin-left: 5px" target="_blank" href="../biblioteca_imagenes/reportes/pqr/Respuesta_pqr_'+data.reportes[i].id+'.pdf" data-id="+data.reportes[i].id+" class="btn btn-list-table btn-success leida">Resp.<i class="fa fa-reply" aria-hidden="true"></i></i></a>'+
                    cierree+
                    /*'<a target="_blank" href="../biblioteca_imagenes/reportes/pqr/Respuesta_pqr_'+data.reportes[i].id+'.pdf" class="btn btn-list-table btn-primary">PDF <i class="fa fa-file-o" aria-hidden="true"></i></i></a>'*/
                  '</div>'+
                '</div>';


                $('.tableView').append(htmlCode);
                console.log(htmlCode)

              }

              //$('#sin_datos').addClass('hidden');

            }else if(data.respuesta==false){

              $('.products-row').html('');

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

      });
    </script>
    <script src="{{url('jquery/cotizaciones.js')}}"></script>

  </body>
</html>
