<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TAsignacion extends Model
{
	protected $table='tasignacion';
	protected $primaryKey='codigoAsignacion';
	public $incrementing=false;
	public $timestamps=true;

	public function tUsuario()
	{
		return $this->belongsTo('App\Model\TUsuario', 'codigoUsuario');
	}

	public function tPersonal()
	{
		return $this->belongsTo('App\Model\TPersonal', 'codigoPersonal');
	}

	public function tAsignacionDetalle()
	{
		return $this->hasMany('App\Model\TAsignacionDetalle', 'codigoAsignacion');
	}
}
?>