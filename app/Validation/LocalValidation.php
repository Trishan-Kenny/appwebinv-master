<?php
namespace App\Validation;

use Validator;
use Session;

use App\Model\TLocal;

class LocalValidation
{
	private $mensajeGlobal='';

	public function validationInsertar($request)
	{
		$tLocal=TLocal::whereRaw("replace(nombre, ' ', '')=replace(?, ' ', '')", [$request->input('txtNombre')])->get();

		if(count($tLocal)>0)
		{
			$this->mensajeGlobal.='El local ya se encuentra registrada en el sistema (Nombre del local existente).__SALTOLINEA__';
		}

		return $this->mensajeGlobal;
	}

	public function validationEditar($request)
	{
		$tLocal=TLocal::whereRaw("replace(nombre, ' ', '')=replace(?, ' ', '') and codigoLocal!=?", [$request->input('txtNombre'), $request->input('hdCodigoLocal')])->get();

		if(count($tLocal)>0)
		{
			$this->mensajeGlobal.='El local ya se encuentra registrada en el sistema (Nombre del local existente).__SALTOLINEA__';
		}

		return $this->mensajeGlobal;
	}
}
?>