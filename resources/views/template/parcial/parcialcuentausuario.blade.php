<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<img src="{{asset('img/logo/logoSistema.'.($tConfiguracionFm!=null ? $tConfiguracionFm->extensionLogoSistema : '').'?x='.str_replace(' ', '_', str_replace(':', '-', ($tConfiguracionFm!=null ? $tConfiguracionFm->updated_at : ''))))}}" class="user-image" alt="User Image" style="background-color: #ffffff;">
		<span class="hidden-xs">{{Session::get('nombreCompleto', 'Anónimo')}}</span>
	</a>
	<ul class="dropdown-menu">
		<!-- User image -->
		<li class="user-header">
			<img src="{{asset('img/logo/logoSistema.'.($tConfiguracionFm!=null ? $tConfiguracionFm->extensionLogoSistema : '').'?x='.str_replace(' ', '_', str_replace(':', '-', ($tConfiguracionFm!=null ? $tConfiguracionFm->updated_at : ''))))}}" class="img-circle" alt="User Image" style="background-color: #ffffff;">
			<p>
				{{Session::get('nombreCompleto', 'Anónimo')}}
				<small>{{Session::get('rol', 'Acceso público')}}</small>
			</p>
		</li>
		<!-- Menu Body -->
		<li class="user-body">
			<div class="row">
				<div class="col-xs-12 text-center">
					<a href="#">Sistema de información gerencial</a>
				</div>
			</div>
			<!-- /.row -->
		</li>
		<!-- Menu Footer-->
		<li class="user-footer">
			@if(Session::has('codigoUsuario'))
				<div class="pull-left">
					<a href="{{url('usuario/ver')}}" class="btn btn-default btn-flat">Mi perfil</a>
				</div>
			@endif
			<div class="pull-right">
				<a href="{{url('usuario/logout')}}" class="btn btn-default btn-flat">Salir</a>
			</div>
		</li>
	</ul>
</li>