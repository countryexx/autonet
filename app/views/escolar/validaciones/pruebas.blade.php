<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Pruebas</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="manifest" href="{{url('manifest.json')}}">
   <!-- <script src="https://maps.googleapis.com/maps/api/js?key={{$_ENV['API_KEY_GOOGLE_MAPS']}}" async defer></script>-->
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGM6WeUAlFGPSsT5pCtu-wRzrEC-pt4yw" async defer></script>-->
    <style>

      /* Optional: Makes the sample page fill the window. */
      html,
      body {
      height: 100%;
      margin: 0;
      padding: 0;
      }

      #container {
      height: 100%;
      display: flex;
      }

      #sidebar {
      flex-basis: 15rem;
      flex-grow: 1;
      padding: 1rem;
      max-width: 30rem;
      height: 100%;
      box-sizing: border-box;
      overflow: auto;
      }

      #map {
      flex-basis: 0;
      flex-grow: 4;
      height: 100%;
      }

      #directions-panel {
      margin-top: 10px;
      }

    </style>
</head>

<body onload="nobackbutton();">
  @include('admin.menu')

  <h1 style="margin: 0 10px 10px 16px" class="h_titulo">VISTA DE PRUEBAS</h1>

  <div id="container">
      <div id="map"></div>
      <div id="sidebar">
        <div>
          <b>Start:</b>
          <select id="start">
            <option value="Halifax, NS">Halifax, NS</option>
            <option value="Boston, MA">Boston, MA</option>
            <option value="New York, NY">New York, NY</option>
            <option value="Miami, FL">Miami, FL</option>
          </select>
          <br />
          <b>Waypoints:</b> <br />
          <i>(Ctrl+Click or Cmd+Click for multiple selection)</i> <br />
          <select multiple id="waypoints">
            <option value="montreal, quebec">Montreal, QBC</option>
            <option value="toronto, ont">Toronto, ONT</option>
            <option value="chicago, il">Chicago</option>
            <option value="winnipeg, mb">Winnipeg</option>
            <option value="fargo, nd">Fargo</option>
            <option value="calgary, ab">Calgary</option>
            <option value="spokane, wa">Spokane</option>
          </select>
          <br />
          <b>End:</b>
          <select id="end">
            <option value="Vancouver, BC">Vancouver, BC</option>
            <option value="Seattle, WA">Seattle, WA</option>
            <option value="San Francisco, CA">San Francisco, CA</option>
            <option value="Los Angeles, CA">Los Angeles, CA</option>
          </select>
          <br />
          <input type="submit" id="submit" />
        </div>
        <div id="directions-panel"></div>
      </div>
    </div>

    <!--
     The `defer` attribute causes the callback to execute after the full HTML
     document has been parsed. For non-blocking uses, avoiding race conditions,
     and consistent behavior across browsers, consider loading using Promises
     with https://www.npmjs.com/package/@googlemaps/js-api-loader.
    -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly"
      defer
    ></script>

  @include('scripts.scripts')

  <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>-->

</body>
</html>
