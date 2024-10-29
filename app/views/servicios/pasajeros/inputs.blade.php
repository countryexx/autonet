<div class="col-lg-6">
    <div class="form-group">
      <label for="nombres">Nombres</label>
      <input type="text" class="form-control input-font" id="nombres" placeholder="" name="nombres" autocomplete="off" required>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
      <label for="nombres">Apellidos</label>
      <input type="text" class="form-control input-font" id="apellidos" name="apellidos" autocomplete="off" required >
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
      <label for="cedula">Cedula</label>
      <input type="number" class="form-control input-font disabled" id="cedula" name="cedula" autocomplete="off" required readonly="readonly">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
      <label for="nombres">Direccion</label>
      <input type="text" class="form-control input-font" id="direccion" name="direccion" autocomplete="off" required>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
      <label for="nombres">Email</label>
      <input type="text" class="form-control input-font" id="email" name="email" autocomplete="off" required>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
      <label for="nombres">Barrio</label>
      <input type="text" class="form-control input-font" id="barrio" name="barrio" autocomplete="off" required>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
      <label for="nombres">ARL</label>
      <input type="text" class="form-control input-font" id="arl" name="arl" autocomplete="off" required>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
      <label for="nombres">EPS</label>
      <input type="text" class="form-control input-font" id="eps" name="eps" autocomplete="off" required>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
      <label for="nombres">Municipio</label>
      <input type="text" class="form-control input-font" id="municipio" name="municipio" autocomplete="off" required>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
      <label for="nombres">Departamento</label>
      <input type="text" class="form-control input-font" id="barrio" name="departamento" autocomplete="off" required>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
      <label for="nombres">Teléfono</label>
      <input type="text" class="form-control input-font" id="cargo" name="telefono" autocomplete="off" required="true">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
      <label for="nombres">Area</label>
      <input type="text" class="form-control input-font" id="area" name="area" autocomplete="off" required>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
      <label for="nombres">Sub Area</label>
      <input type="text" class="form-control input-font" id="subarea" name="subarea" autocomplete="off">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
      <label for="nombres">Centro de costo</label>
      <select class="form-control input-font" name="centrodecosto_id" required>
        <option>-</option>
        @foreach ($centrosdecosto as $centrodecosto)
          <option value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
        @endforeach
      </select>
    </div>
</div>