<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\TDistrito;

class DistritoController extends Controller
{
	public function actionJsonPorCodigoProvincia(Request $request)
	{
		try
		{
			$listaTDistrito=TDistrito::whereRaw('codigoProvincia=?', [$request->input('codigoProvincia')])->orderBy('nombre', 'asc')->get();

			return response()->json(['correcto' => true, 'mensajeGlobal' => 'Operación realizada correctamente.', 'listaTDistrito' => $listaTDistrito]);
		}
		catch(\Exception $e)
		{
			return response()->json(['correcto' => false, 'mensajeGlobal' => 'Ocurrió un error inesperado. Se está trabajando para solucionar este problema, gracias por su paciencia.']);
		}
	}
}