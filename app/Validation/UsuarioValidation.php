<?php
namespace App\Validation;

use Validator;
use Session;
use Illuminate\Validation\Rule;

use App\Model\TUsuario;

class UsuarioValidation
{
	private $mensajeGlobal='';

	public function validationInsertar($request)
	{
		$validator=Validator::make(
		[
			'dni' => trim($request->input('txtDni')),
			'nombre' => trim($request->input('txtNombre')),
			'apellido' => trim($request->input('txtApellido')),
			'correoElectronico' => trim($request->input('txtCorreoElectronico')),
			'contrasenia' => trim($request->input('passContrasenia'))
		],
		[
			'dni' => ['required', 'unique:tusuario,dni'],
			'nombre' => 'required',
			'apellido' => 'required',
			'correoElectronico' => ['required', 'unique:tusuario,correoElectronico'],
			'contrasenia' => 'required'
		],
		[
			'dni.unique' => 'El usuario ya se encuentra registrado en el sistema (DNI del usuario existente).__SALTOLINEA__',
			'dni.required' => 'El campo "dni" es requerido.__SALTOLINEA__',
			'nombre.required' => 'El campo "nombre" es requerido.__SALTOLINEA__',
			'apellido.required' => 'El campo "apellido" es requerido.__SALTOLINEA__',
			'correoElectronico.unique' => 'El usuario ya se encuentra registrado en el sistema (Correo electrónico del usuario existente).__SALTOLINEA__',
			'correoElectronico.required' => 'El campo "correoElectronico" es requerido.__SALTOLINEA__',
			'contrasenia.required' => 'El campo "contrasenia" es requerido.__SALTOLINEA__'
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
			'nombre' => trim($request->input('txtNombre')),
			'apellido' => trim($request->input('txtApellido')),
			'correoElectronico' => trim($request->input('txtCorreoElectronico'))
		],
		[
			'dni' => ['required', Rule::unique('tusuario')->where(function($query) use($request){ return $query->where('codigoUsuario', '<>', $request->input('hdCodigoUsuario')); })],
			'nombre' => 'required',
			'apellido' => 'required',
			'correoElectronico' => ['required', Rule::unique('tusuario')->where(function($query) use($request){ return $query->where('codigoUsuario', '<>', $request->input('hdCodigoUsuario')); })]
		],
		[
			'dni.unique' => 'El usuario ya se encuentra registrado en el sistema (DNI del usuario existente).__SALTOLINEA__',
			'dni.required' => 'El campo "dni" es requerido.__SALTOLINEA__',
			'nombre.required' => 'El campo "nombre" es requerido.__SALTOLINEA__',
			'apellido.required' => 'El campo "apellido" es requerido.__SALTOLINEA__',
			'correoElectronico.unique' => 'El usuario ya se encuentra registrado en el sistema (Correo electrónico del usuario existente).__SALTOLINEA__',
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

		if(!in_array($request->input('selectEstado'), ['Pendiente', 'Activo', 'Bloqueado']))
		{
			$this->mensajeGlobal.='Datos incorrectos. Por favor, no trate de alterar el comportamiento del sistema.__SALTOLINEA__';
		}

		return $this->mensajeGlobal;
	}
}
?>