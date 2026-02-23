<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

use App\Validation\AreaValidation;

use DB;

use App\Model\TArea;

class AreaController extends Controller
{
	public function actionInsertar(Request $request, SessionManager $sessionManager)
	{
		if($_POST)
		{
			try
			{
				DB::beginTransaction();

				$this->mensajeGlobal=(new AreaValidation())->validationInsertar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					$request->flash();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'area/insertar');
				}

				$tArea=new TArea();

				$tArea->codigoArea=uniqid();
				$tArea->nombre=trim($request->input('txtNombre'));

				$tArea->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'area/insertar');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		return view('area/insertar');
	}

	public function actionVer()
	{
		$listaTArea=TArea::all();

		return view('area/ver', ['listaTArea' => $listaTArea]);
	}

	public function actionEditar(Request $request, SessionManager $sessionManager)
	{
		if($request->has('hdCodigoArea'))
		{
			try
			{
				DB::beginTransaction();

				$tArea=TArea::find($request->input('hdCodigoArea'));

				$this->mensajeGlobal=(new AreaValidation())->validationEditar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'area/ver');
				}

				$tArea->nombre=trim($request->input('txtNombre'));

				$tArea->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'area/ver');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$tArea=TArea::find($request->input('codigoArea'));

		return view('area/editar', ['tArea' => $tArea]);
	}
}
?>