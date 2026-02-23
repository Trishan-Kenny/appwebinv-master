<?php
namespace App\Validation;

use Validator;
use Session;
use Illuminate\Validation\Rule;

use App\Model\TPersonal;

class PersonalValidation
{
	private $mensajeGlobal='';

	public function validationInsertar($request)
	{
		$validator=Validator::make(
		[
			'dni' => trim($request->input('txtDni')),
			'correoElectronico' => trim($request->input('txtCorreoElectronico'))
		],
		[
			'dni' => ['required', 'unique:tpersonal,dni'],
			'correoElectronico' => ['required', 'unique:tpersonal,correoElectronico']
		],
		[
			'dni.unique' => 'El personal ya se encuentra registrado en el sistema (DNI del personal existente).__SALTOLINEA__',
			'dni.required' => 'El campo "dni" es requerido.__SALTOLINEA__',
			'correoElectronico.unique' => 'El personal ya se encuentra registrado en el sistema (Correo electrónico del personal existente).__SALTOLINEA__',
			'correoElectronico.required' => 'El campo "correoElectronico" es requerido.__SALTOLINEA__'
		]);

		if($validator->fails())
		{
			$errors=$validator->errors()->all();

			foreach($errors as $value)
			{
				$this->mensajeGlobal.=$value;
			}
		}

		return $this->mensajeGlobal;
	}

	public function validationEditar($request)
	{
		$validator=Validator::make(
		[
			'dni' => trim($request->input('txtDni')),
			'correoElectronico' => trim($request->input('txtCorreoElectronico'))
		],
		[
			'dni' => ['required', Rule::unique('tpersonal')->where(function($query) use($request){ return $query->where('codigoPersonal', '<>', $request->input('hdCodigoPersonal')); })],
			'correoElectronico' => ['required', Rule::unique('tpersonal')->where(function($query) use($request){ return $query->where('codigoPersonal', '<>', $request->input('hdCodigoPersonal')); })]
		],
		[
			'dni.unique' => 'El personal ya se encuentra registrado en el sistema (DNI del personal existente).__SALTOLINEA__',
			'dni.required' => 'El campo "dni" es requerido.__SALTOLINEA__',
			'correoElectronico.unique' => 'El personal ya se encuentra registrado en el sistema (Correo electrónico del personal existente).__SALTOLINEA__',
			'correoElectronico.required' => 'El campo "correoElectronico" es requerido.__SALTOLINEA__'
		]);

		if($validator->fails())
		{
			$errors=$validator->errors()->all();

			foreach($errors as $value)
			{
				$this->mensajeGlobal.=$value;
			}
		}

		return $this->mensajeGlobal;
	}
}
?>