<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TUsuario extends Model
{
	protected $table='tusuario';
	protected $primaryKey='codigoUsuario';
	public $incrementing=false;
	public $timestamps=true;

	public function tUsuarioTOficina()
	{
		return $this->hasMany('App\Model\TUsuarioTOficina', 'codigoUsuario');
	}

	public function tExcepcion()
	{
		return $this->hasMany('App\Model\TExcepcion', 'codigoUsuario');
	}

	public function tAsignacion()
	{
		return $this->hasMany('App\Model\TAsignacionDetalle', 'codigoUsuario', 'codigoUsuario');
	}

	public function tAsignacionDetalle()
	{
		return $this->hasMany('App\Model\TAsignacionDetalle', 'codigoUsuario', 'codigoUsuario');
	}
}
?>