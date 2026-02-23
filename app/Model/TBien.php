<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TBien extends Model
{
	protected $table='tbien';
	protected $primaryKey='codigoBien';
	public $incrementing=false;
	public $timestamps=true;

	public function tAsignacionDetalle()
	{
		return $this->hasMany('App\Model\TAsignacionDetalle', 'codigoBien');
	}
}
?>