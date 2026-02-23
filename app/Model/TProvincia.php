<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TProvincia extends Model
{
	protected $table='tprovincia';
	protected $primaryKey='codigoProvincia';
	public $incrementing=false;
	public $timestamps=true;

	public function tDistrito()
	{
		return $this->hasMany('App\Model\TDistrito', 'codigoProvincia');
	}
}
?>