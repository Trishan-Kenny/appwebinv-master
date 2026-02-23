<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

use App\Validation\DependenciaValidation;

use DB;

use App\Model\TDependencia;
use App\Model\TProvincia;
use App\Model\TDistrito;
use App\Model\TLocal;

class DependenciaController extends Controller
{
	public function actionInsertar(Request $request, SessionManager $sessionManager)
	{
		if($_POST)
		{
			try
			{
				DB::beginTransaction();

				$this->mensajeGlobal=(new DependenciaValidation())->validationInsertar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					$request->flash();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'dependencia/insertar');
				}

				$tDependencia=new TDependencia();

				$tDependencia->codigoDependencia=uniqid();
				$tDependencia->codigoLocal=$request->input('selectCodigoLocal');
				$tDependencia->nombre=trim($request->input('txtNombre'));

				$tDependencia->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'dependencia/insertar');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$listaTProvincia=TProvincia::orderBy('nombre', 'asc')->get();

		return view('dependencia/insertar', ['listaTProvincia' => $listaTProvincia]);
	}

	public function actionVer()
	{
		$listaTDependencia=TDependencia::with(['tlocal.tdistrito.tprovincia'])->get();

		return view('dependencia/ver', ['listaTDependencia' => $listaTDependencia]);
	}

	public function actionEditar(Request $request, SessionManager $sessionManager)
	{
		if($request->has('hdCodigoDependencia'))
		{
			try
			{
				DB::beginTransaction();

				$tDependencia=TDependencia::find($request->input('hdCodigoDependencia'));

				$this->mensajeGlobal=(new DependenciaValidation())->validationEditar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'dependencia/ver');
				}

				$tDependencia->nombre=trim($request->input('txtNombre'));
				$tDependencia->codigoLocal=$request->input('selectCodigoLocal');
				$tDependencia->nombre=trim($request->input('txtNombre'));

				$tDependencia->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'dependencia/ver');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$tDependencia=TDependencia::with(['tlocal.tdistrito'])->find($request->input('codigoDependencia'));
		$listaTLocal=TLocal::whereRaw('codigoDistrito=?', [$tDependencia->tlocal->codigoDistrito])->orderBy('nombre', 'asc')->get();
		$listaTDistrito=TDistrito::whereRaw('codigoProvincia=?', [$tDependencia->tlocal->tdistrito->codigoProvincia])->orderBy('nombre', 'asc')->get();
		$listaTProvincia=TProvincia::orderBy('nombre', 'asc')->get();

		return view('dependencia/editar', ['tDependencia' => $tDependencia, 'listaTLocal' => $listaTLocal, 'listaTDistrito' => $listaTDistrito, 'listaTProvincia' => $listaTProvincia]);
	}

	public function actionJsonPorCodigoLocal(Request $request)
	{
		try
		{
			$listaTDependencia=TDependencia::whereRaw('codigoLocal=?', [$request->input('codigoLocal')])->orderBy('nombre', 'asc')->get();

			return response()->json(['correcto' => true, 'mensajeGlobal' => 'Operación realizada correctamente.', 'listaTDependencia' => $listaTDependencia]);
		}
		catch(\Exception $e)
		{
			return response()->json(['correcto' => false, 'mensajeGlobal' => 'Ocurrió un error inesperado. Se está trabajando para solucionar este problema, gracias por su paciencia.']);
		}
	}
}
?>