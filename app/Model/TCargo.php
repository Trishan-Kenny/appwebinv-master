<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TCargo extends Model
{
	protected $table='tcargo';
	protected $primaryKey='codigoCargo';
	public $incrementing=false;
	public $timestamps=true;

	public function tPersonal()
	{
		return $this->hasMany('App\Model\TPersonal', 'codigoCargo');
	}
}
?>