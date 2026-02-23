<?php
namespace App\Validation;

use Validator;
use Session;

use App\Model\TCargo;

class CargoValidation
{
	private $mensajeGlobal='';

	public function validationInsertar($request)
	{
		$tCargo=TCargo::whereRaw("replace(nombre, ' ', '')=replace(?, ' ', '')", [$request->input('txtNombre')])->get();

		if(count($tCargo)>0)
		{
			$this->mensajeGlobal.='El cargo ya se encuentra registrada en el sistema (Nombre del cargo existente).__SALTOLINEA__';
		}

		return $this->mensajeGlobal;
	}

	public function validationEditar($request)
	{
		$tCargo=TCargo::whereRaw("replace(nombre, ' ', '')=replace(?, ' ', '') and codigoCargo!=?", [$request->input('txtNombre'), $request->input('hdCodigoCargo')])->get();

		if(count($tCargo)>0)
		{
			$this->mensajeGlobal.='El cargo ya se encuentra registrada en el sistema (Nombre del cargo existente).__SALTOLINEA__';
		}

		return $this->mensajeGlobal;
	}
}
?>