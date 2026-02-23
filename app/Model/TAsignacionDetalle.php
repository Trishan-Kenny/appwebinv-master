<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TAsignacionDetalle extends Model
{
	protected $table='tasignaciondetalle';
	protected $primaryKey='codigoAsignacionDetalle';
	public $incrementing=false;
	public $timestamps=true;

	public function tAsignacion()
	{
		return $this->belongsTo('App\Model\TAsignacion', 'codigoAsignacion');
	}

	public function tBien()
	{
		return $this->belongsTo('App\Model\TBien', 'codigoBien');
	}

	public function tUsuario()
	{
		return $this->belongsTo('App\Model\TUsuario', 'codigoUsuario', 'codigoUsuario');
	}
}
?>