<?php

class Restriccionvehiculo extends Eloquent {

	protected $table = 'restriccion_vehiculos';
	protected $hidden = ['created_at', 'updated_at'];

	public function vehiculo()
	{
			return $this->belongsTo('Vehiculo');
	}

}
