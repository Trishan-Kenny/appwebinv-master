<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

use App\Validation\LocalValidation;

use DB;

use App\Model\TLocal;
use App\Model\TProvincia;
use App\Model\TDistrito;

class LocalController extends Controller
{
	public function actionInsertar(Request $request, SessionManager $sessionManager)
	{
		if($_POST)
		{
			try
			{
				DB::beginTransaction();

				$this->mensajeGlobal=(new LocalValidation())->validationInsertar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					$request->flash();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'local/insertar');
				}

				$tLocal=new TLocal();

				$tLocal->codigoLocal=uniqid();
				$tLocal->codigoDistrito=$request->input('selectCodigoDistrito');
				$tLocal->nombre=trim($request->input('txtNombre'));
				$tLocal->direccion=trim($request->input('txtDireccion'));

				$tLocal->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'local/insertar');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$listaTProvincia=TProvincia::orderBy('nombre', 'asc')->get();

		return view('local/insertar', ['listaTProvincia' => $listaTProvincia]);
	}

	public function actionVer()
	{
		$listaTLocal=TLocal::with(['tdistrito.tprovincia'])->get();

		return view('local/ver', ['listaTLocal' => $listaTLocal]);
	}

	public function actionEditar(Request $request, SessionManager $sessionManager)
	{
		if($request->has('hdCodigoLocal'))
		{
			try
			{
				DB::beginTransaction();

				$tLocal=TLocal::find($request->input('hdCodigoLocal'));

				$this->mensajeGlobal=(new LocalValidation())->validationEditar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'local/ver');
				}

				$tLocal->nombre=trim($request->input('txtNombre'));
				$tLocal->codigoDistrito=$request->input('selectCodigoDistrito');
				$tLocal->nombre=trim($request->input('txtNombre'));
				$tLocal->direccion=trim($request->input('txtDireccion'));

				$tLocal->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'local/ver');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$tLocal=TLocal::with(['tdistrito'])->find($request->input('codigoLocal'));
		$listaTDistrito=TDistrito::whereRaw('codigoProvincia=?', [$tLocal->tdistrito->codigoProvincia])->orderBy('nombre', 'asc')->get();
		$listaTProvincia=TProvincia::orderBy('nombre', 'asc')->get();

		return view('local/editar', ['tLocal' => $tLocal, 'listaTDistrito' => $listaTDistrito, 'listaTProvincia' => $listaTProvincia]);
	}

	public function actionJsonPorCodigoDistrito(Request $request)
	{
		try
		{
			$listaTLocal=TLocal::whereRaw('codigoDistrito=?', [$request->input('codigoDistrito')])->orderBy('nombre', 'asc')->get();

			return response()->json(['correcto' => true, 'mensajeGlobal' => 'Operación realizada correctamente.', 'listaTLocal' => $listaTLocal]);
		}
		catch(\Exception $e)
		{
			return response()->json(['correcto' => false, 'mensajeGlobal' => 'Ocurrió un error inesperado. Se está trabajando para solucionar este problema, gracias por su paciencia.']);
		}
	}
}
?>