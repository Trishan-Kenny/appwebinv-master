<?php
namespace App\Validation;

use Validator;
use Session;

use App\Model\TDependencia;

class DependenciaValidation
{
	private $mensajeGlobal='';

	public function validationInsertar($request)
	{
		$tDependencia=TDependencia::whereRaw("replace(nombre, ' ', '')=replace(?, ' ', '')", [$request->input('txtNombre')])->get();

		if(count($tDependencia)>0)
		{
			$this->mensajeGlobal.='La dependencia ya se encuentra registrada en el sistema (Nombre de la dependencia existente).__SALTOLINEA__';
		}

		return $this->mensajeGlobal;
	}

	public function validationEditar($request)
	{
		$tDependencia=TDependencia::whereRaw("replace(nombre, ' ', '')=replace(?, ' ', '') and codigoDependencia!=?", [$request->input('txtNombre'), $request->input('hdCodigoDependencia')])->get();

		if(count($tDependencia)>0)
		{
			$this->mensajeGlobal.='La dependencia ya se encuentra registrada en el sistema (Nombre de la dependencia existente).__SALTOLINEA__';
		}

		return $this->mensajeGlobal;
	}
}
?>