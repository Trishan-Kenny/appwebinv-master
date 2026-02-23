<?php
namespace App\Validation;

use Validator;
use Session;

use App\Model\TArea;

class AreaValidation
{
	private $mensajeGlobal='';

	public function validationInsertar($request)
	{
		$tArea=TArea::whereRaw("replace(nombre, ' ', '')=replace(?, ' ', '')", [$request->input('txtNombre')])->get();

		if(count($tArea)>0)
		{
			$this->mensajeGlobal.='El área ya se encuentra registrada en el sistema (Nombre del área existente).__SALTOLINEA__';
		}

		return $this->mensajeGlobal;
	}

	public function validationEditar($request)
	{
		$tArea=TArea::whereRaw("replace(nombre, ' ', '')=replace(?, ' ', '') and codigoArea!=?", [$request->input('txtNombre'), $request->input('hdCodigoArea')])->get();

		if(count($tArea)>0)
		{
			$this->mensajeGlobal.='El área ya se encuentra registrada en el sistema (Nombre del área existente).__SALTOLINEA__';
		}

		return $this->mensajeGlobal;
	}
}
?>