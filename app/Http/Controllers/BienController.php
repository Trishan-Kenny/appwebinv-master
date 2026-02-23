<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

use App\Validation\BienValidation;

use DB;

use App\Model\TBien;

class BienController extends Controller
{
	public function actionInsertar(Request $request, SessionManager $sessionManager)
	{
		if($_POST)
		{
			try
			{
				DB::beginTransaction();

				$this->mensajeGlobal=(new BienValidation())->validationInsertar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					$request->flash();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'bien/insertar');
				}

				$tBien=new TBien();

				$tBien->codigoBien=uniqid();
				$tBien->descripcion=trim($request->input('txtDescripcion'));
				$tBien->codigoPatrimonial=trim($request->input('txtCodigoPatrimonial'));
				$tBien->codigoInterno=trim($request->input('txtCodigoInterno'));
				$tBien->codigoM=trim($request->input('txtCodigoM'));
				$tBien->serie=trim($request->input('txtSerie'));
				$tBien->marca=trim($request->input('txtMarca'));
				$tBien->modelo=trim($request->input('txtModelo'));
				$tBien->tipo=trim($request->input('txtTipo'));
				$tBien->color=trim($request->input('txtColor'));
				$tBien->observacion=trim($request->input('txtObservacion'));
				$tBien->estado=trim($request->input('selectEstado'));

				$tBien->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'bien/insertar');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		return view('bien/insertar');
	}

	public function actionVer(Request $request, $paginaActual)
	{
		$parametroBusqueda=$request->has('parametroBusqueda') ? $request->input('parametroBusqueda') : '';

		$paginacion=$this->plataformHelper->prepararPaginacion(TBien::with(['tasignaciondetalle' => function($iq1)
		{
			$iq1->whereRaw('posesion', []);
		}, 'tasignaciondetalle.tasignacion.tpersonal'])->whereRaw('(compareFind(concat(descripcion, codigoPatrimonial, serie, marca, modelo, tipo, observacion), ?, 77)=1)', [$parametroBusqueda]), 7, $paginaActual);
		
		return view('bien/ver',
		[
			'listaTBien' => $paginacion['listaRegistros'],
			'paginaActual' => $paginacion['paginaActual'],
			'cantidadPaginas' => $paginacion['cantidadPaginas'],
			'parametroBusqueda' => $parametroBusqueda
		]);
	}

	public function actionEditar(Request $request, SessionManager $sessionManager)
	{
		if($request->has('hdCodigoBien'))
		{
			try
			{
				DB::beginTransaction();

				$tBien=TBien::find($request->input('hdCodigoBien'));

				$this->mensajeGlobal=(new BienValidation())->validationEditar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'bien/ver/1');
				}

				$tBien->descripcion=trim($request->input('txtDescripcion'));
				$tBien->codigoPatrimonial=trim($request->input('txtCodigoPatrimonial'));
				$tBien->codigoInterno=trim($request->input('txtCodigoInterno'));
				$tBien->codigoM=trim($request->input('txtCodigoM'));
				$tBien->serie=trim($request->input('txtSerie'));
				$tBien->marca=trim($request->input('txtMarca'));
				$tBien->modelo=trim($request->input('txtModelo'));
				$tBien->tipo=trim($request->input('txtTipo'));
				$tBien->color=trim($request->input('txtColor'));
				$tBien->observacion=trim($request->input('txtObservacion'));
				$tBien->estado=trim($request->input('selectEstado'));

				$tBien->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'bien/ver/1');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$tBien=TBien::find($request->input('codigoBien'));

		return view('bien/editar',
		[
			'tBien' => $tBien
		]);
	}

	public function actionJSONParaAsignacion(Request $request)
	{
		$listaTBien=[];

		$listaTBien=TBien::with(['tasignaciondetalle' => function($sq1)
		{
			$sq1->whereRaw('posesion', []);
		}, 'tasignaciondetalle.tasignacion.tpersonal'])->whereRaw('compareFind(concat(descripcion, codigoPatrimonial, serie, marca, modelo), ?, 77)=1 limit 10', [$request->input('q')])->get();

		$items=[];

		foreach($listaTBien as $item)
		{
			$items[]=['id' => $item->codigoBien, 'text' => $item->descripcion, 'row' => $item];
		}

		$result=['items' => $items];

		return response()->json($result);
	}
}
?>