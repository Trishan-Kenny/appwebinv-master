<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TDependencia extends Model
{
	protected $table='tdependencia';
	protected $primaryKey='codigoDependencia';
	public $incrementing=false;
	public $timestamps=true;

	public function tLocal()
	{
		return $this->belongsTo('App\Model\TLocal', 'codigoLocal');
	}

	public function tPersonal()
	{
		return $this->hasMany('App\Model\TPersonal', 'codigoDependencia');
	}
}
?>