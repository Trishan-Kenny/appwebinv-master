<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TUsuarioTOficina extends Model
{
	protected $table='tusuariotoficina';
	protected $primaryKey='codigoUsuarioTOficina';
	public $incrementing=false;
	public $timestamps=true;

	public function tUsuario()
	{
		return $this->belongsTo('App\Model\TUsuario', 'codigoUsuario');
	}

	public function tOficina()
	{
		return $this->belongsTo('App\Model\TOficina', 'codigoOficina');
	}
}
?>