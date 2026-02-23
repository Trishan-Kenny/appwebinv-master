<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TPersonal extends Model
{
	protected $table='tpersonal';
	protected $primaryKey='codigoPersonal';
	public $incrementing=false;
	public $timestamps=true;

	public function tDependencia()
	{
		return $this->belongsTo('App\Model\TDependencia', 'codigoDependencia');
	}

	public function tArea()
	{
		return $this->belongsTo('App\Model\TArea', 'codigoArea');
	}

	public function tCargo()
	{
		return $this->belongsTo('App\Model\TCargo', 'codigoCargo');
	}

	public function tSituacion()
	{
		return $this->belongsTo('App\Model\TSituacion', 'codigoSituacion');
	}

	public function tAsignacion()
	{
		return $this->belongsTo('App\Model\TAsignacion', 'codigoPersonal');
	}
}
?>