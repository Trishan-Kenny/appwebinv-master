<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

use App\Validation\CargoValidation;

use DB;

use App\Model\TCargo;

class CargoController extends Controller
{
	public function actionInsertar(Request $request, SessionManager $sessionManager)
	{
		if($_POST)
		{
			try
			{
				DB::beginTransaction();

				$this->mensajeGlobal=(new CargoValidation())->validationInsertar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					$request->flash();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'cargo/insertar');
				}

				$tCargo=new TCargo();

				$tCargo->codigoCargo=uniqid();
				$tCargo->nombre=trim($request->input('txtNombre'));

				$tCargo->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'cargo/insertar');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		return view('cargo/insertar');
	}

	public function actionVer()
	{
		$listaTCargo=TCargo::all();

		return view('cargo/ver', ['listaTCargo' => $listaTCargo]);
	}

	public function actionEditar(Request $request, SessionManager $sessionManager)
	{
		if($request->has('hdCodigoCargo'))
		{
			try
			{
				DB::beginTransaction();

				$tCargo=TCargo::find($request->input('hdCodigoCargo'));

				$this->mensajeGlobal=(new CargoValidation())->validationEditar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'cargo/ver');
				}

				$tCargo->nombre=trim($request->input('txtNombre'));

				$tCargo->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'cargo/ver');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$tCargo=TCargo::find($request->input('codigoCargo'));

		return view('cargo/editar', ['tCargo' => $tCargo]);
	}
}
?>