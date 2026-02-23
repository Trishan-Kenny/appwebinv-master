<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TArea extends Model
{
	protected $table='tarea';
	protected $primaryKey='codigoArea';
	public $incrementing=false;
	public $timestamps=true;

	public function tPersonal()
	{
		return $this->hasMany('App\Model\TPersonal', 'codigoArea');
	}
}
?>