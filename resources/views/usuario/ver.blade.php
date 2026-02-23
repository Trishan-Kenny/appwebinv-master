@extends('template.layoutgeneral')
@section('titulo', 'Lista de usuarios')
@section('subTitulo', '...')
@section('cuerpoGeneral')
<div class="row">
	<div class="col-md-12">
		<div class="nav-tabs-custom">
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1-1">
					<div class="row">
						<div class="col-md-12">
							<div>
								<input type="text" id="txtBuscar" name="txtBuscar" class="form-control" autocomplete="off" placeholder="Ingrese datos de búsqueda (Enter)" onkeyup="filtrarHtml('tableUsuario', this.value, false, 0, event);">
							</div>
							<hr>
							<div class="table-responsive">
								<table id="tableUsuario" class="table table-striped table-bordered" style="min-width: 777px;">
									<thead>
										<tr>
											<th>Datos del usuario</th>
											<th class="text-center">Rol</th>
											<th class="text-center">Estado</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach($listaTUsuario as $value)
											@if($value->codigoUsuario!=Session::get('codigoUsuario') && strpos(Session::get('rol'), 'Súper usuario')===false && strpos(Session::get('rol'), 'Administrador')===false)
												<?php continue; ?>
											@endif
											<tr class="elementoBuscar">
												<td>
													<div>{{$value->nombre.' '.$value->apellido}}</div>
													<div><small style="color: #999999;"><b>DNI:</b> {{$value->dni}}</small></div>
													<div><small style="color: #999999;"><b>Correo:</b> {{$value->correoElectronico}}</small></div>
												</td>
												<td class="text-center">{{$value->rol}}</td>
												<td class="text-center"><span class="label label-{{$value->estado=='Pendiente' ? 'warning' : ($value->estado=='Activo' ? 'info' : 'danger')}}">{{$value->estado}}</span></td>
												<td class="text-right">
													@if(strpos(Session::get('rol'), 'Súper usuario')!==false || strpos(Session::get('rol'), 'Administrador')!==false)
														<span class="btn btn-default btn-xs glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" title="Editar" onclick="dialogoAjax('dialogoGeneral', null, '{{$value->nombre.' '.$value->apellido}} (Editar)', { _token : '{{csrf_token()}}', codigoUsuario : '{{$value->codigoUsuario}}' }, '{{url('usuario/editar')}}', 'POST', null, null, false, true);"></span>
													@endif
													<span class="btn btn-default btn-xs glyphicon glyphicon-asterisk" data-toggle="tooltip" data-placement="left" title="Cambiar contraseña" onclick="dialogoAjax('dialogoGeneral', null, '{{$value->nombre.' '.$value->apellido}} (Cambiar contraseña)', { _token : '{{csrf_token()}}', codigoUsuario : '{{$value->codigoUsuario}}' }, '{{url('usuario/cambiarcontrasenia')}}', 'POST', null, null, false, true);"></span>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection