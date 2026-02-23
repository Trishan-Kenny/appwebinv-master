<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

use App\Validation\AsignacionValidation;
use App\Validation\BienValidation;

use DB;

use App\Model\TAsignacion;
use App\Model\TAsignacionDetalle;
use App\Model\TBien;

class AsignacionController extends Controller
{
	public function actionInsertar(Request $request, SessionManager $sessionManager)
	{
		if($_POST)
		{
			try
			{
				DB::beginTransaction();

				$tAsignacion=new TAsignacion();

				$tAsignacion->codigoAsignacion=uniqid();
				$tAsignacion->codigoUsuario=$sessionManager->get('codigoUsuario');
				$tAsignacion->codigoPersonal=$request->input('hdCodigoPersonal');
				$tAsignacion->descripcion='Asignación para uso laboral';
				$tAsignacion->observacion='';

				$tAsignacion->save();

				foreach($request->input('hdCodigoBien') as $key => $value)
				{
					$tBien=null;

					if($request->input('hdCodigoBien')[$key]!='')
					{
						$tBien=TBien::find($value);
					}
					else
					{
						$this->mensajeGlobal=(new BienValidation())->validationInsertarEnAsignacion($request, $key);

						if($this->mensajeGlobal!='')
						{
							DB::rollBack();

							return response()->json(['correcto' => false, 'mensajeGlobal' => 'Complete toda la información requerida y asegúrese que el bien Nº ['.($key+1).'] de la lista, no se encuentra registrado en el sistema.']);
						}

						$tBien=new TBien();

						$tBien->codigoBien=uniqid();
						$tBien->descripcion=trim($request->input('hdDescripcion')[$key]);
						$tBien->codigoPatrimonial=trim($request->input('hdCodigoPatrimonial')[$key]);
						$tBien->serie=trim($request->input('hdSerie')[$key]);
						$tBien->marca=trim($request->input('hdMarca')[$key]);
						$tBien->modelo=trim($request->input('hdModelo')[$key]);
						$tBien->tipo=trim($request->input('hdTipo')[$key]);
						$tBien->color=trim($request->input('hdColor')[$key]);
						$tBien->observacion=trim($request->input('hdObservacion')[$key]);
						$tBien->estado=trim($request->input('hdEstado')[$key]);

						$tBien->save();
					}

					TAsignacionDetalle::whereRaw('codigoBien=? and posesion', [$tBien->codigoBien])->update(
					[
						'codigoUsuario' => $sessionManager->get('codigoUsuario'),
						'fechaDevolucion' => date('Y-m-d H:i:s')
					]);

					TAsignacionDetalle::whereRaw('codigoBien=?', [$tBien->codigoBien])->update(
					[
						'posesion' => false
					]);

					$tAsignacionDetalle=new TAsignacionDetalle();

					$tAsignacionDetalle->codigoAsignacionDetalle=uniqid();
					$tAsignacionDetalle->codigoAsignacion=$tAsignacion->codigoAsignacion;
					$tAsignacionDetalle->codigoBien=$tBien->codigoBien;
					$tAsignacionDetalle->codigoUsuario=null;
					$tAsignacionDetalle->colorBien=$tBien->color;
					$tAsignacionDetalle->estadoBien=$tBien->estado;
					$tAsignacionDetalle->posesion=true;
					$tAsignacionDetalle->fechaAsignacion=date('Y-m-d H:i:s');
					$tAsignacionDetalle->fechaDevolucion=null;
					$tAsignacionDetalle->observacion='';

					$tAsignacionDetalle->save();
				}

				DB::commit();

				return response()->json(['correcto' => true, 'mensajeGlobal' => 'Operación realizada correctamente.', 'codigoAsignacion' => $tAsignacion->codigoAsignacion]);
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return response()->json(['correcto' => false, 'mensajeGlobal' => 'Ocurrió un error inesperado. Se está trabajando para solucionar este problema, gracias por su paciencia.']);
			}
		}

		return view('asignacion/insertar');
	}

	public function actionVer(Request $request, $paginaActual)
	{
		$parametroBusqueda=$request->has('parametroBusqueda') ? $request->input('parametroBusqueda') : '';

		$paginacion=$this->plataformHelper->prepararPaginacion(TAsignacion::with(['tusuario', 'tpersonal', 'tasignaciondetalle.tbien', 'tasignaciondetalle.tusuario'])->whereRaw('(compareFind(concat(descripcion), ?, 77)=1)', [$parametroBusqueda])->orWhereHas('tpersonal', function($sq1) use($parametroBusqueda)
		{
			$sq1->whereRaw('(compareFind(concat(dni, nombre, apellido), ?, 77)=1)', [$parametroBusqueda]);
		})->orderBy('created_at', 'desc'), 7, $paginaActual);
		
		return view('asignacion/ver',
		[
			'listaTAsignacion' => $paginacion['listaRegistros'],
			'paginaActual' => $paginacion['paginaActual'],
			'cantidadPaginas' => $paginacion['cantidadPaginas'],
			'parametroBusqueda' => $parametroBusqueda
		]);
	}

	public function actionHojaEntregaPdf($codigoAsignacion)
	{
		$pdf=\App::make('dompdf.wrapper');

		$pdf->loadHTML(view('asignacion/hojaentregapdf',
		[
			'tAsignacion' => TAsignacion::with(['tusuario', 'tpersonal.tdependencia.tlocal.tdistrito.tprovincia', 'tasignaciondetalle.tbien', 'tasignaciondetalle.tusuario'])->find($codigoAsignacion)
		]))->setPaper('a4', 'landscape');

		return $pdf->stream();
	}
}
?>