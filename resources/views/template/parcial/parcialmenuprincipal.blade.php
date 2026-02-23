<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
	<li class="header">MENÚ DE NAVEGACIÓN</li>
	@if(strpos(Session::get('rol'), 'Súper usuario')!==false || strpos(Session::get('rol'), 'Administrador')!==false || strpos(Session::get('rol'), 'Usuario normal')!==false || strpos(Session::get('rol'), 'Firmante')!==false)
		<li id="liMenuPanelControl" class="treeview">
			<a href="#">
				<i class="fa fa-dashboard"></i> <span>Panel de control</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li id="liMenuItemPanelControlInicio"><a href="{{url('general/indexadmin')}}"><i class="fa fa-circle-o"></i> Inicio</a></li>
				@if(strpos(Session::get('rol'), 'Súper usuario')!==false)
					<li id="liMenuItemPanelControlConfiguracion"><a href="{{url('configuracion/insertareditar')}}"><i class="fa fa-circle-o"></i> Configuración</a></li>
					<li id="liMenuItemPanelControlBackupDatos"><a href="#" onclick="swal(
					{
						title : 'Confirmar operación',
						text : '¿Realmente desea continuar con la acción?',
						icon : 'warning',
						buttons : ['No, cancelar.', 'Si, proceder.']
					})
					.then((proceed) =>
					{
						if(proceed)
						{
							window.location.href='{{url('general/databackup')}}';
						}
					});"><i class="fa fa-circle-o"></i> Backup de datos</a></li>
				@endif
			</ul>
		</li>
		@if(strpos(Session::get('rol'), 'Súper usuario')!==false || strpos(Session::get('rol'), 'Administrador')!==false)
			<li id="liMenuGestionUsuario" class="treeview">
				<a href="#">
					<i class="fa fa-users"></i> <span>Gestión de usuario</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li id="liMenuItemGestionUsuarioRegistrarUsuario"><a href="{{url('usuario/insertar')}}"><i class="fa fa-circle-o"></i> Registrar usuario</a></li>
					<li id="liMenuItemGestionUsuarioListarUsuarios"><a href="{{url('usuario/ver')}}"><i class="fa fa-circle-o"></i> Listar usuarios</a></li>
				</ul>
			</li>
			{{-- <li id="liMenuGestionOficinas" class="treeview">
				<a href="#">
					<i class="fa fa-institution"></i> <span>Gestión de oficinas</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li id="liMenuItemGestionOficinasRegistrarOficina"><a href="{{url('oficina/insertar')}}"><i class="fa fa-circle-o"></i> Registrar oficina</a></li>
					<li id="liMenuItemGestionOficinasListarOficinas"><a href="{{url('oficina/ver')}}"><i class="fa fa-circle-o"></i> Listar oficinas</a></li>
				</ul>
			</li> --}}
			<li id="liMenuGestionMantenimiento" class="treeview">
				<a href="#">
					<i class="fa fa-gear"></i> <span>Mantenimientos gen.</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li id="liMenuItemGestionMantenimientoRegistrarLocal"><a href="{{url('local/insertar')}}"><i class="fa fa-circle-o"></i> Registrar local</a></li>
					<li id="liMenuItemGestionMantenimientoListarLocales"><a href="{{url('local/ver')}}"><i class="fa fa-circle-o"></i> Listar locales</a></li>
					<li id="liMenuItemGestionMantenimientoRegistrarDependencia"><a href="{{url('dependencia/insertar')}}"><i class="fa fa-circle-o"></i> Registrar dependencia</a></li>
					<li id="liMenuItemGestionMantenimientoListarDependencias"><a href="{{url('dependencia/ver')}}"><i class="fa fa-circle-o"></i> Listar dependencias</a></li>
					<li id="liMenuItemGestionMantenimientoRegistrarArea"><a href="{{url('area/insertar')}}"><i class="fa fa-circle-o"></i> Registrar área</a></li>
					<li id="liMenuItemGestionMantenimientoListarAreas"><a href="{{url('area/ver')}}"><i class="fa fa-circle-o"></i> Listar áreas</a></li>
					<li id="liMenuItemGestionMantenimientoRegistrarCargo"><a href="{{url('cargo/insertar')}}"><i class="fa fa-circle-o"></i> Registrar cargo</a></li>
					<li id="liMenuItemGestionMantenimientoListarCargos"><a href="{{url('cargo/ver')}}"><i class="fa fa-circle-o"></i> Listar cargos</a></li>
					<li id="liMenuItemGestionMantenimientoRegistrarSituacion"><a href="{{url('situacion/insertar')}}"><i class="fa fa-circle-o"></i> Registrar situación</a></li>
					<li id="liMenuItemGestionMantenimientoListarSituaciones"><a href="{{url('situacion/ver')}}"><i class="fa fa-circle-o"></i> Listar situaciones</a></li>
				</ul>
			</li>
			<li id="liMenuGestionPersonal" class="treeview">
				<a href="#">
					<i class="fa fa-user"></i> <span>Gestión de personal</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li id="liMenuItemGestionPersonalRegistrarPersonal"><a href="{{url('personal/insertar')}}"><i class="fa fa-circle-o"></i> Registrar personal</a></li>
					<li id="liMenuItemGestionPersonalListarPersonal"><a href="{{url('personal/ver/1')}}"><i class="fa fa-circle-o"></i> Listar personal</a></li>
				</ul>
			</li>
			<li id="liMenuGestionBien" class="treeview">
				<a href="#">
					<i class="fa fa-cubes"></i> <span>Gestión de bien</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li id="liMenuItemGestionBienRegistrarBien"><a href="{{url('bien/insertar')}}"><i class="fa fa-circle-o"></i> Registrar bien</a></li>
					<li id="liMenuItemGestionBienListarBienes"><a href="{{url('bien/ver/1')}}"><i class="fa fa-circle-o"></i> Listar bienes</a></li>
					<li id="liMenuItemGestionBienAsignarBienes"><a href="{{url('asignacion/insertar')}}"><i class="fa fa-circle-o"></i> Asignar bienes</a></li>
					<li id="liMenuItemGestionBienListarAsignaciones"><a href="{{url('asignacion/ver/1')}}"><i class="fa fa-circle-o"></i> Listar asignaciones</a></li>
				</ul>
			</li>
		@endif
	@endif
	@if(!Session::has('codigoUsuario'))
		<li>
			<a href="{{url('/')}}">
				<i class="fa fa-arrow-left"></i> <span>Regresar al login</span>
			</a>
		</li>
	@endif
</ul>
<script>
	@if(Session::has('menuItemPadreSelected'))
		$('#{{Session::get('menuItemPadreSelected')}}').addClass('active');
	@endif

	@if(Session::has('menuItemHijoSelected'))
		$('#{{Session::get('menuItemHijoSelected')}}').addClass('active');
	@endif
</script>