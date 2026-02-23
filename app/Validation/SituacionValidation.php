<?php
namespace App\Validation;

use Validator;
use Session;

use App\Model\TSituacion;

class SituacionValidation
{
	private $mensajeGlobal='';

	public function validationInsertar($request)
	{
		$tSituacion=TSituacion::whereRaw("replace(nombre, ' ', '')=replace(?, ' ', '')", [$request->input('txtNombre')])->get();

		if(count($tSituacion)>0)
		{
			$this->mensajeGlobal.='La situación ya se encuentra registrada en el sistema (Nombre de la situación existente).__SALTOLINEA__';
		}

		return $this->mensajeGlobal;
	}

	public function validationEditar($request)
	{
		$tSituacion=TSituacion::whereRaw("replace(nombre, ' ', '')=replace(?, ' ', '') and codigoSituacion!=?", [$request->input('txtNombre'), $request->input('hdCodigoSituacion')])->get();

		if(count($tSituacion)>0)
		{
			$this->mensajeGlobal.='La situación ya se encuentra registrada en el sistema (Nombre de la situación existente).__SALTOLINEA__';
		}

		return $this->mensajeGlobal;
	}
}
?>