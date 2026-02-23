<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TLocal extends Model
{
	protected $table='tlocal';
	protected $primaryKey='codigoLocal';
	public $incrementing=false;
	public $timestamps=true;

	public function tDistrito()
	{
		return $this->belongsTo('App\Model\TDistrito', 'codigoDistrito');
	}

	public function tDependencia()
	{
		return $this->hasMany('App\Model\TDependencia', 'codigoLocal');
	}
}
?>