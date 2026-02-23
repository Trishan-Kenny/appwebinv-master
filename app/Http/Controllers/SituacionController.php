<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

use App\Validation\SituacionValidation;

use DB;

use App\Model\TSituacion;

class SituacionController extends Controller
{
	public function actionInsertar(Request $request, SessionManager $sessionManager)
	{
		if($_POST)
		{
			try
			{
				DB::beginTransaction();

				$this->mensajeGlobal=(new SituacionValidation())->validationInsertar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					$request->flash();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'situacion/insertar');
				}

				$tSituacion=new TSituacion();

				$tSituacion->codigoSituacion=uniqid();
				$tSituacion->nombre=trim($request->input('txtNombre'));

				$tSituacion->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'situacion/insertar');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		return view('situacion/insertar');
	}

	public function actionVer()
	{
		$listaTSituacion=TSituacion::all();

		return view('situacion/ver', ['listaTSituacion' => $listaTSituacion]);
	}

	public function actionEditar(Request $request, SessionManager $sessionManager)
	{
		if($request->has('hdCodigoSituacion'))
		{
			try
			{
				DB::beginTransaction();

				$tSituacion=TSituacion::find($request->input('hdCodigoSituacion'));

				$this->mensajeGlobal=(new SituacionValidation())->validationEditar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'situacion/ver');
				}

				$tSituacion->nombre=trim($request->input('txtNombre'));

				$tSituacion->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'situacion/ver');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$tSituacion=TSituacion::find($request->input('codigoSituacion'));

		return view('situacion/editar', ['tSituacion' => $tSituacion]);
	}
}
?>