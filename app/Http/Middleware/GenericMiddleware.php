<?php
namespace App\Http\Middleware;

use Closure;
use Session;

use App\Model\TUsuario;
use App\Model\TConfiguracion;

class GenericMiddleware
{
	public function handle($request, Closure $next)
	{
		if(Session::has('codigoUsuario'))
		{
			$tUsuario=TUsuario::with(['tusuariotoficina' => function($q)
			{
				$q->whereRaw('codigoOficina=?', [Session::get('codigoOficina')]);
			}])->find(Session::get('codigoUsuario'));

			if((count($tUsuario->tusuariotoficina)==0 && strpos($tUsuario->rol, 'Súper usuario')===false) || $tUsuario->estado!='Activo')
			{
				Session::flush();
			}
			else
			{
				Session::put('dni', $tUsuario->dni);
				Session::put('correoElectronico', $tUsuario->correoElectronico);
				Session::put('nombreCompleto', $tUsuario->nombre);
				Session::put('rol', $tUsuario->rol);
			}
		}

		$url=explode('/', $request->url());

		$protocolo=$url[0];
		$dominio=$url[1].$url[2];
		$url=$url[0].'//'.$url[1].$url[2].config('var.URL_ADICIONAL_FILTRO');

		$accesoUrl=false;

		$permisosUrl=
		[
			//TIndex
			['Súper usuario,Administrador,Usuario general,Firmante,Público', false, $url, null, null],

			//TGeneral
			['Súper usuario,Administrador,Usuario general,Firmante', false, $url.'/general/indexadmin', 'liMenuPanelControl', 'liMenuItemPanelControlInicio'],
			['Súper usuario', false, $url.'/general/databackup', null, null],

			//TConfiguracion
			['Súper usuario', false, $url.'/configuracion/insertareditar', 'liMenuPanelControl', 'liMenuItemPanelControlConfiguracion'],

			//TUsuario
			['Súper usuario,Administrador,Público', false, $url.'/usuario/insertar', 'liMenuGestionUsuario', 'liMenuItemGestionUsuarioRegistrarUsuario'],
			['Súper usuario,Administrador,Público', false, $url.'/usuario/graciasregistro', null, null],
			['Súper usuario,Administrador,Usuario general,Firmante,Público', false, $url.'/usuario/login', null, null],
			['Súper usuario,Administrador,Usuario general,Firmante,Público', false, $url.'/usuario/logout', null, null],
			['Súper usuario,Administrador,Usuario general,Firmante', false, $url.'/usuario/ver', 'liMenuGestionUsuario', 'liMenuItemGestionUsuarioListarUsuarios'],
			['Súper usuario,Administrador,Usuario general,Firmante', false, $url.'/usuario/editar', null, null],
			['Súper usuario,Administrador,Usuario general,Firmante', false, $url.'/usuario/cambiarcontrasenia', null, null],

			//TOficina
			['Súper usuario,Administrador', false, $url.'/oficina/insertar', 'liMenuGestionOficinas', 'liMenuItemGestionOficinasRegistrarOficina'],
			['Súper usuario,Administrador', false, $url.'/oficina/ver', 'liMenuGestionOficinas', 'liMenuItemGestionOficinasListarOficinas'],
			['Súper usuario,Administrador', false, $url.'/oficina/editar', null, null],

			//TUsuarioTOficina
			['Súper usuario,Administrador', false, $url.'/usuariotoficina/gestionar', null, null],

			//TDistrito
			['Súper usuario,Administrador', false, $url.'/distrito/jsonporcodigoprovincia', null, null],

			//TLocal
			['Súper usuario,Administrador', false, $url.'/local/insertar', 'liMenuGestionMantenimiento', 'liMenuItemGestionMantenimientoRegistrarLocal'],
			['Súper usuario,Administrador', false, $url.'/local/ver', 'liMenuGestionMantenimiento', 'liMenuItemGestionMantenimientoListarLocales'],
			['Súper usuario,Administrador', false, $url.'/local/editar', null, null],
			['Súper usuario,Administrador', false, $url.'/local/jsonporcodigodistrito', null, null],

			//TDependencia
			['Súper usuario,Administrador', false, $url.'/dependencia/insertar', 'liMenuGestionMantenimiento', 'liMenuItemGestionMantenimientoRegistrarDependencia'],
			['Súper usuario,Administrador', false, $url.'/dependencia/ver', 'liMenuGestionMantenimiento', 'liMenuItemGestionMantenimientoListarDependencias'],
			['Súper usuario,Administrador', false, $url.'/dependencia/editar', null, null],
			['Súper usuario,Administrador', false, $url.'/dependencia/jsonporcodigolocal', null, null],

			//TArea
			['Súper usuario,Administrador', false, $url.'/area/insertar', 'liMenuGestionMantenimiento', 'liMenuItemGestionMantenimientoRegistrarArea'],
			['Súper usuario,Administrador', false, $url.'/area/ver', 'liMenuGestionMantenimiento', 'liMenuItemGestionMantenimientoListarAreas'],
			['Súper usuario,Administrador', false, $url.'/area/editar', null, null],

			//TCargo
			['Súper usuario,Administrador', false, $url.'/cargo/insertar', 'liMenuGestionMantenimiento', 'liMenuItemGestionMantenimientoRegistrarCargo'],
			['Súper usuario,Administrador', false, $url.'/cargo/ver', 'liMenuGestionMantenimiento', 'liMenuItemGestionMantenimientoListarCargos'],
			['Súper usuario,Administrador', false, $url.'/cargo/editar', null, null],

			//TSituacion
			['Súper usuario,Administrador', false, $url.'/situacion/insertar', 'liMenuGestionMantenimiento', 'liMenuItemGestionMantenimientoRegistrarSituacion'],
			['Súper usuario,Administrador', false, $url.'/situacion/ver', 'liMenuGestionMantenimiento', 'liMenuItemGestionMantenimientoListarSituaciones'],
			['Súper usuario,Administrador', false, $url.'/situacion/editar', null, null],

			//TPersonal
			['Súper usuario,Administrador', false, $url.'/personal/insertar', 'liMenuGestionPersonal', 'liMenuItemGestionPersonalRegistrarPersonal'],
			['Súper usuario,Administrador', true, $url.'/personal/ver', 'liMenuGestionPersonal', 'liMenuItemGestionPersonalListarPersonal'],
			['Súper usuario,Administrador', false, $url.'/personal/editar', null, null],
			['Súper usuario,Administrador', false, $url.'/personal/jsonpordni', null, null],
			['Súper usuario,Administrador', false, $url.'/personal/verbienesasignados', null, null],
			['Súper usuario,Administrador', true, $url.'/personal/disposicionbienpdf', null, null],

			//TBien
			['Súper usuario,Administrador', false, $url.'/bien/insertar', 'liMenuGestionBien', 'liMenuItemGestionBienRegistrarBien'],
			['Súper usuario,Administrador', true, $url.'/bien/ver', 'liMenuGestionBien', 'liMenuItemGestionBienListarBienes'],
			['Súper usuario,Administrador', false, $url.'/bien/editar', null, null],
			['Súper usuario,Administrador', false, $url.'/bien/jsonparaasignacion', null, null],

			//TAsignacion
			['Súper usuario,Administrador', false, $url.'/asignacion/insertar', 'liMenuGestionBien', 'liMenuItemGestionBienAsignarBienes'],
			['Súper usuario,Administrador', true, $url.'/asignacion/ver', 'liMenuGestionBien', 'liMenuItemGestionBienListarAsignaciones'],
			['Súper usuario,Administrador', true, $url.'/asignacion/hojaentregapdf', null, null]
		];

		$miRol=Session::get('rol', 'Público');
		$miRol=$miRol=='' ? 'Público' : $miRol;

		foreach($permisosUrl as $key => $value)
		{
			if($request->url()==$value[2] || ($value[1] && strlen(strpos($request->url(), $value[2]))>0))
			{
				$permisos=explode(',', $value[0]);
				$roles=explode(',', $miRol);

				foreach($permisos as $key2 => $value2)
				{
					foreach($roles as $item)
					{
						if($value2==$item)
						{
							$accesoUrl=true;

							Session::put('menuItemPadreSelected', $value[3]);
							Session::put('menuItemHijoSelected', $value[4]);

							break 3;
						}
					}
				}
			}
		}

		if(!$accesoUrl)
		{
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest')
			{
				echo '<div class="alert alert-danger"><h4><i class="icon fa fa-ban"></i> Prohibido!</h4>No tiene autorización para realizar esta operación o su "sesión de usuario" ya ha finalizado.</div>';exit;
			}
			else
			{
				return redirect('/usuario/login');
			}
		}

		view()->share('tConfiguracionFm', TConfiguracion::first());

		return $next($request);
	}
}