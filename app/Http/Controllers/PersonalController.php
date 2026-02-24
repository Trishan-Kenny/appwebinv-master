<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

use App\Validation\PersonalValidation;

use DB;

use App\Model\TPersonal;
use App\Model\TProvincia;
use App\Model\TDistrito;
use App\Model\TDependencia;
use App\Model\TLocal;
use App\Model\TArea;
use App\Model\TCargo;
use App\Model\TSituacion;
use App\Model\TAsignacionDetalle;

class PersonalController extends Controller
{
	public function actionInsertar(Request $request, SessionManager $sessionManager)
	{
		if($_POST)
		{
			try
			{
				DB::beginTransaction();

				$this->mensajeGlobal=(new PersonalValidation())->validationInsertar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					$request->flash();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'personal/insertar');
				}

				$tPersonal=new TPersonal();

				$tPersonal->codigoPersonal=uniqid();
				$tPersonal->codigoDependencia=$request->input('selectCodigoDependencia');
				$tPersonal->codigoArea=$request->input('selectCodigoArea');
				$tPersonal->codigoCargo=$request->input('selectCodigoCargo');
				$tPersonal->codigoSituacion=$request->input('selectCodigoSituacion');
				$tPersonal->dni=trim($request->input('txtDni'));
				$tPersonal->nombre=trim($request->input('txtNombre'));
				$tPersonal->apellido=trim($request->input('txtApellido'));
				$tPersonal->correoElectronico=trim($request->input('txtCorreoElectronico'));
				$tPersonal->celular=trim($request->input('txtCelular'));

				$tPersonal->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'personal/insertar');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$listaTProvincia=TProvincia::orderBy('nombre', 'asc')->get();
		$listaTArea=TArea::orderBy('nombre', 'asc')->get();
		$listaTCargo=TCargo::orderBy('nombre', 'asc')->get();
		$listaTSituacion=TSituacion::orderBy('nombre', 'asc')->get();

		return view('personal/insertar', [
			'listaTProvincia' => $listaTProvincia,
			'listaTArea' => $listaTArea,
			'listaTCargo' => $listaTCargo,
			'listaTSituacion' => $listaTSituacion
		]);
	}

	public function actionVer(Request $request, $paginaActual)
	{
		$parametroBusqueda=$request->has('parametroBusqueda') ? $request->input('parametroBusqueda') : '';

		$paginacion=$this->plataformHelper->prepararPaginacion(TPersonal::with(['tdependencia.tlocal.tdistrito.tprovincia', 'tarea', 'tcargo', 'tsituacion'])->whereRaw('(compareFind(concat(dni, nombre, apellido, correoElectronico), ?, 77)=1)', [$parametroBusqueda]), 7, $paginaActual);

		return view('personal/ver',
		[
			'listaTPersonal' => $paginacion['listaRegistros'],
			'paginaActual' => $paginacion['paginaActual'],
			'cantidadPaginas' => $paginacion['cantidadPaginas'],
			'parametroBusqueda' => $parametroBusqueda
		]);
	}

	public function actionEditar(Request $request, SessionManager $sessionManager)
	{
		if($request->has('hdCodigoPersonal'))
		{
			try
			{
				DB::beginTransaction();

				$tPersonal=TPersonal::find($request->input('hdCodigoPersonal'));

				$this->mensajeGlobal=(new PersonalValidation())->validationEditar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'personal/ver/1');
				}

				$tPersonal->codigoDependencia=$request->input('selectCodigoDependencia');
				$tPersonal->codigoArea=$request->input('selectCodigoArea');
				$tPersonal->codigoCargo=$request->input('selectCodigoCargo');
				$tPersonal->codigoSituacion=$request->input('selectCodigoSituacion');
				$tPersonal->dni=trim($request->input('txtDni'));
				$tPersonal->nombre=trim($request->input('txtNombre'));
				$tPersonal->apellido=trim($request->input('txtApellido'));
				$tPersonal->correoElectronico=trim($request->input('txtCorreoElectronico'));
				$tPersonal->celular=trim($request->input('txtCelular'));

				$tPersonal->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'personal/ver/1');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$tPersonal=TPersonal::with(['tdependencia.tlocal.tdistrito'])->find($request->input('codigoPersonal'));

		$listaTDependencia=TDependencia::whereRaw('codigoLocal=?', [$tPersonal->tdependencia->codigoLocal])->orderBy('nombre', 'asc')->get();
		$listaTLocal=TLocal::whereRaw('codigoDistrito=?', [$tPersonal->tdependencia->tlocal->codigoDistrito])->orderBy('nombre', 'asc')->get();
		$listaTDistrito=TDistrito::whereRaw('codigoProvincia=?', [$tPersonal->tdependencia->tlocal->tdistrito->codigoProvincia])->orderBy('nombre', 'asc')->get();
		$listaTProvincia=TProvincia::orderBy('nombre', 'asc')->get();
		$listaTArea=TArea::orderBy('nombre', 'asc')->get();
		$listaTCargo=TCargo::orderBy('nombre', 'asc')->get();
		$listaTSituacion=TSituacion::orderBy('nombre', 'asc')->get();

		return view('personal/editar',
		[
			'tPersonal' => $tPersonal,
			'listaTDependencia' => $listaTDependencia,
			'listaTLocal' => $listaTLocal,
			'listaTDistrito' => $listaTDistrito,
			'listaTProvincia' => $listaTProvincia,
			'listaTArea' => $listaTArea,
			'listaTCargo' => $listaTCargo,
			'listaTSituacion' => $listaTSituacion
		]);
	}

	public function actionJsonPorDni(Request $request)
	{
		try
		{
			$tPersonal=TPersonal::with(['tdependencia', 'tarea', 'tcargo'])->whereRaw('dni=?', [$request->input('dni')])->first();

			if($tPersonal==null)
			{
				return response()->json(['correcto' => false, 'mensajeGlobal' => 'Datos no encontrados para el DNI ingresado.']);
			}

			return response()->json(['correcto' => true, 'mensajeGlobal' => 'Operación realizada correctamente.', 'tPersonal' => $tPersonal]);
		}
		catch(\Exception $e)
		{
			return response()->json(['correcto' => false, 'mensajeGlobal' => 'Ocurrió un error inesperado. Se está trabajando para solucionar este problema, gracias por su paciencia.']);
		}
	}

	public function actionVerBienesAsignados(Request $request)
	{
		$listaTAsignacionDetalle=TAsignacionDetalle::with(['tbien'])->whereHas('tasignacion', function($sq1) use($request)
		{
			$sq1->whereRaw('codigoPersonal=?', [$request->input('codigoPersonal')]);
		})->whereRaw('posesion', [])->get();

		return view('personal/verbienesasignados', ['listaTAsignacionDetalle' => $listaTAsignacionDetalle]);
	}

	public function actionDisposicionBienPdf($codigoPersonal)
	{
		$pdf=\App::make('dompdf.wrapper');

		$pdf->loadHTML(view('personal/disposicionbienpdf',
		[
			'tPersonal' => TPersonal::with(['tdependencia.tlocal.tdistrito.tprovincia'])->find($codigoPersonal),
			'listaTAsignacionDetalle' => TAsignacionDetalle::with(['tbien'])->whereHas('tasignacion', function($sq1) use($codigoPersonal)
			{
				$sq1->whereRaw('codigoPersonal=?', [$codigoPersonal]);
			})->whereRaw('posesion', [])->get()
		]))->setPaper('a4', 'landscape');

		return $pdf->stream();
	}

	public function actionEliminar()
	{

	}
}
?>