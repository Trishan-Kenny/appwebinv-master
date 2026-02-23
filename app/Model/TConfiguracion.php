<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TConfiguracion extends Model
{
	protected $table='tconfiguracion';
	protected $primaryKey='codigoConfiguracion';
	public $incrementing=false;
	public $timestamps=true;
}
?>