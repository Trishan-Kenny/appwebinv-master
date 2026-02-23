<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TDistrito extends Model
{
	protected $table='tdistrito';
	protected $primaryKey='codigoDistrito';
	public $incrementing=false;
	public $timestamps=true;

	public function tProvincia()
	{
		return $this->belongsTo('App\Model\TProvincia', 'codigoProvincia');
	}

	public function tLocal()
	{
		return $this->hasMany('App\Model\TLocal', 'codigoDistrito');
	}
}
?>