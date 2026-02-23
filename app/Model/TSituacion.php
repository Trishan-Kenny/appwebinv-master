<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TSituacion extends Model
{
	protected $table='tsituacion';
	protected $primaryKey='codigoSituacion';
	public $incrementing=false;
	public $timestamps=true;

	public function tPersonal()
	{
		return $this->hasMany('App\Model\TPersonal', 'codigoSituacion');
	}
}
?>