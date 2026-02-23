<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

use App\Model\TConfiguracion;

class ConfiguracionController extends Controller
{
	public function actionInsertarEditar(Request $request)
	{
		if($_POST)
		{
			try
			{
				DB::beginTransaction();

				if($request->hasFile('fileLogoSistema'))
				{
					$fileGetClientOriginalExtension=strtolower($request->file('fileLogoSistema')->getClientOriginalExtension());
					$fileGetSizeKb=(($request->file('fileLogoSistema')->getSize())/1024);

					if($fileGetClientOriginalExtension!='png' && $fileGetClientOriginalExtension!='jpg' && $fileGetClientOriginalExtension!='jpeg')
					{
						$this->mensajeGlobal.='El formato de la imagen sólo debe ser "png, jpg o jpeg".<br>';
					}

					if($fileGetSizeKb>500)
					{
						$this->mensajeGlobal.='La imagen no debe pesar más de 500KB.<br>';
					}

					if($this->mensajeGlobal!='')
					{
						DB::rollBack();

						return $this->plataformHelper->redirectError($this->mensajeGlobal, 'configuracion/insertareditar');
					}
				}

				$tConfiguracion=TConfiguracion::first();

				if($tConfiguracion==null)
				{
					$tConfiguracion=new TConfiguracion();
				}

				$tConfiguracion->codigoConfiguracion=uniqid();
				$tConfiguracion->tituloSistema=trim($request->input('txtTituloSistema'));
				$tConfiguracion->extensionLogoSistema=$request->hasFile('fileLogoSistema') ? $fileGetClientOriginalExtension : ($tConfiguracion->extensionLogoSistema!=null ? $tConfiguracion->extensionLogoSistema : '');
				$tConfiguracion->updated_at=date('Y-m-d');

				$tConfiguracion->save();

				if($request->hasFile('fileLogoSistema'))
				{
					$request->file('fileLogoSistema')->move(public_path().'/img/logo', 'logoSistema.'.$fileGetClientOriginalExtension);
				}

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Configuración guardada correctamente.', 'configuracion/insertareditar');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$tConfiguracion=TConfiguracion::first();

		return view('configuracion/insertareditar', ['tConfiguracion' => $tConfiguracion]);
	}
}