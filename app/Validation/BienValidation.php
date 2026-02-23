<?php
namespace App\Validation;

use Validator;
use Session;
use Illuminate\Validation\Rule;

use App\Model\TBien;

class BienValidation
{
	private $mensajeGlobal='';

	public function validationInsertar($request)
	{
		$validator=Validator::make(
		[
			'codigoPatrimonial' => trim($request->input('txtCodigoPatrimonial')),
			'codigoInterno' => trim($request->input('txtCodigoInterno')),
			'codigoM' => trim($request->input('txtCodigoM')),
			'serie' => trim($request->input('txtSerie'))
		],
		[
			'codigoPatrimonial' => ['unique:tbien,codigoPatrimonial'],
			'codigoInterno' => ['unique:tbien,codigoInterno'],
			'codigoM' => ['unique:tbien,codigoM'],
			'serie' => ['unique:tbien,serie']
		],
		[
			'codigoPatrimonial.unique' => 'El bien ya se encuentra registrado en el sistema (Código patrimonial del bien existente).__SALTOLINEA__',
			'codigoInterno.unique' => 'El bien ya se encuentra registrado en el sistema (Código interno del bien existente).__SALTOLINEA__',
			'codigoM.unique' => 'El bien ya se encuentra registrado en el sistema (Código M del bien existente).__SALTOLINEA__',
			'serie.unique' => 'El bien ya se encuentra registrado en el sistema (Serie del bien existente).__SALTOLINEA__'
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
			'codigoPatrimonial' => trim($request->input('txtCodigoPatrimonial')),
			'codigoInterno' => trim($request->input('txtCodigoInterno')),
			'codigoM' => trim($request->input('txtCodigoM')),
			'serie' => trim($request->input('txtSerie'))
		],
		[
			'codigoPatrimonial' => [Rule::unique('tbien')->where(function($query) use($request){ return $query->where('codigoBien', '<>', $request->input('hdCodigoBien')); })],
			'codigoInterno' => [Rule::unique('tbien')->where(function($query) use($request){ return $query->where('codigoBien', '<>', $request->input('hdCodigoBien')); })],
			'codigoM' => [Rule::unique('tbien')->where(function($query) use($request){ return $query->where('codigoBien', '<>', $request->input('hdCodigoBien')); })],
			'serie' => [Rule::unique('tbien')->where(function($query) use($request){ return $query->where('codigoBien', '<>', $request->input('hdCodigoBien')); })]
		],
		[
			'codigoPatrimonial.unique' => 'El bien ya se encuentra registrado en el sistema (Código patrimonial del bien existente).__SALTOLINEA__',
			'codigoInterno.unique' => 'El bien ya se encuentra registrado en el sistema (Código interno del bien existente).__SALTOLINEA__',
			'codigoM.unique' => 'El bien ya se encuentra registrado en el sistema (Código M del bien existente).__SALTOLINEA__',
			'serie.unique' => 'El bien ya se encuentra registrado en el sistema (Serie del bien existente).__SALTOLINEA__'
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

	public function validationInsertarEnAsignacion($request, $key)
	{
		$validator=Validator::make(
		[
			'codigoPatrimonial' => trim($request->input('hdCodigoPatrimonial')[$key]),
			'codigoInterno' => trim($request->input('hdCodigoInterno')[$key]),
			'codigoM' => trim($request->input('hdCodigoM')[$key]),
			'serie' => trim($request->input('hdSerie')[$key])
		],
		[
			'codigoPatrimonial' => ['unique:tbien,codigoPatrimonial'],
			'codigoInterno' => ['unique:tbien,codigoInterno'],
			'codigoM' => ['unique:tbien,codigoM'],
			'serie' => ['unique:tbien,serie']
		],
		[
			'codigoPatrimonial.unique' => 'El bien ya se encuentra registrado en el sistema (Código patrimonial del bien existente).__SALTOLINEA__',
			'codigoInterno.unique' => 'El bien ya se encuentra registrado en el sistema (Código interno del bien existente).__SALTOLINEA__',
			'codigoM.unique' => 'El bien ya se encuentra registrado en el sistema (Código M del bien existente).__SALTOLINEA__',
			'serie.unique' => 'El bien ya se encuentra registrado en el sistema (Serie del bien existente).__SALTOLINEA__'
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