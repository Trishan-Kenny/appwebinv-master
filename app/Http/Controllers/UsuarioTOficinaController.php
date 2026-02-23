<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

use DB;

use App\Model\TOficina;
use App\Model\TUsuario;
use App\Model\TUsuarioTOficina;

class UsuarioTOficinaController extends Controller
{
	public function actionGestionar(Request $request, SessionManager $sessionManager)
	{
		if($request->has('hdCodigoOficina'))
		{
			try
			{
				DB::beginTransaction();

				$tOficina=TOficina::find($request->input('hdCodigoOficina'));

				TUsuarioTOficina::whereRaw('codigoOficina=?', [$tOficina->codigoOficina])->delete();

				if($request->input('selectCodigoUsuario')!=null && count($request->input('selectCodigoUsuario'))>0)
				{
					$uniqTemp=null;

					foreach($request->input('selectCodigoUsuario') as $value)
					{
						do
						{
							$uniqTemp=uniqid();
						} while(TUsuarioTOficina::find($uniqTemp)!=null);

						$tUsuarioTOficina=new TUsuarioTOficina();

						$tUsuarioTOficina->codigoUsuarioTOficina=$uniqTemp;
						$tUsuarioTOficina->codigoUsuario=$value;
						$tUsuarioTOficina->codigoOficina=$tOficina->codigoOficina;

						$tUsuarioTOficina->save();
					}
				}

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'oficina/ver');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$tOficina=TOficina::with(['tusuariotoficina'])->whereRaw('codigoOficina=?', [$request->input('codigoOficina')])->first();
		$listaTUsuario=TUsuario::whereRaw('rol!=?', ['Súper usuario'])->orderBy('correoElectronico', 'asc')->get();

		return view('usuariotoficina/gestionar', ['tOficina' => $tOficina, 'listaTUsuario' => $listaTUsuario]);
	}
}
?>