<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TOficina extends Model
{
	protected $table='toficina';
	protected $primaryKey='codigoOficina';
	public $incrementing=false;
	public $timestamps=true;

	public function tUsuarioTOficina()
	{
		return $this->hasMany('App\Model\TUsuarioTOficina', 'codigoOficina');
	}
}
?>