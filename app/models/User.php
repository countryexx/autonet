<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table = 'users';

	protected $hidden = ['password', 'remember_token', 'activation_code', 'activated_at', 'baneado',
								       'baneado_en', 'baneado_por', 'usuario_app', 'userscol', 'reset_password_code', 'persist_code'];

	public function centrodecosto()
	{
			return $this->belongsTo('Centrodecosto');
	}

	public function subcentrodecosto()
	{
			return $this->belongsTo('Subcentro', 'subcentrodecosto_id');
	}

	public function scopeEmpresarial($query)
	{
			return $query->where('empresarial', 1);
	}

	public function scopeParticular($query)
	{
			return $query->where('particular', 1);
	}

	public function scopeUsuarioMovil($query)
  {
      return $query->where('usuario_app', '=', 2);
  }

	public function scopeUsuarioWeb($query)
  {
      return $query->whereNull('usuario_app')->where('usuario_portal',0);
  }

	public function firmacorreo(){
		return $this->hasOne('FirmaCorreo');
	}

}
