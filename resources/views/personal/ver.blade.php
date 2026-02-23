<?php use App\Helper\PlataformHelper; ?>
@extends('template.layoutgeneral')
@section('titulo', 'Lista de personal')
@section('subTitulo', '...')
@section('cuerpoGeneral')
<div class="row">
	<div class="col-md-12">
		<div class="nav-tabs-custom">
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1-1">
					<div class="row">
						<div class="col-md-12">
							<div id="divSearch" class="row">
								<div class="col-md-7">
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-search"></i>
										</div>
										<input type="text" id="txtBuscar" name="txtBuscar" class="form-control pull-right" placeholder="Información para búsqueda (Enter)" autofocus onkeyup="buscarPersonal(this.value, '{{url('personal/ver/1')}}', event);" value="{{$parametroBusqueda}}">
									</div>
								</div>
								<div class="col-md-5">
									{!!(new PlataformHelper())->renderizarPaginacion('personal/ver', $cantidadPaginas, $paginaActual, $parametroBusqueda)!!}
								</div>
							</div>
							<hr>
							<div class="table-responsive">
								<table id="tablePersonal" class="table table-striped table-bordered" style="min-width: 777px;">
									<thead>
										<tr>
											<th>Personal</th>
											<th>Ubicación</th>
											<th>Ocupación</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach($listaTPersonal as $value)
											<tr>
												<td>
													<div><small><b>DNI: </b>{{$value->dni}}</small></div>
													<div>{{$value->nombre.' '.$value->apellido}}</div>
													<div><small style="color: #999999;"><b>Correo: </b>{{$value->correoElectronico}}</small></div>
													<div><small style="color: #999999;"><b>Celular: </b>{{$value->celular}}</small></div>
												</td>
												<td>
													<div>{{$value->tdependencia->tlocal->tdistrito->tprovincia->nombre.' - '.$value->tdependencia->tlocal->tdistrito->nombre}}</div>
													<div><small style="color: #999999;"><b>Local: </b>{{$value->tdependencia->tlocal->nombre}}</small></div>
													<div><small style="color: #999999;"><b>Dependencia: </b>{{$value->tdependencia->nombre}}</small></div>
												</td>
												<td>
													<div>{{$value->tcargo->nombre}}</div>
													<div><small style="color: #999999;"><b>Situación: </b>{{$value->tsituacion->nombre}}</small></div>
												</td>
												<td class="text-right">
													<span class="btn btn-default btn-xs glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" title="Editar" onclick="dialogoAjax('dialogoGeneral', 77, '{{$value->nombre.' '.$value->apellido.' ['.$value->dni.']'}} (Editar)', { _token : '{{csrf_token()}}', codigoPersonal : '{{$value->codigoPersonal}}' }, '{{url('personal/editar')}}', 'POST', null, null, false, true);"></span>
													<span class="btn btn-default btn-xs glyphicon glyphicon-th" data-toggle="tooltip" data-placement="left" title="Ver bienes asignados" onclick="dialogoAjax('dialogoGeneral', 77, '{{$value->nombre.' '.$value->apellido.' ['.$value->dni.']'}} (Bienes asignados)', { _token : '{{csrf_token()}}', codigoPersonal : '{{$value->codigoPersonal}}' }, '{{url('personal/verbienesasignados')}}', 'POST', null, null, false, true);"></span>
													<span class="btn btn-default btn-xs glyphicon glyphicon-print" data-toggle="tooltip" data-placement="left" title="Imprimir hoja de disposición de bienes" onclick="window.open('{{url('personal/disposicionbienpdf/'.$value->codigoPersonal)}}', '_blank')"></span>
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
<script>
	$(function()
	{
		$('#divSearch').formValidation(
		{
			framework: 'bootstrap',
			excluded: [':disabled', ':hidden', ':not(:visible)', '[class*="notValidate"]'],
			live: 'enabled',
			message: '<b style="color: #9d9d9d;">Asegúrese que realmente no necesita este valor.</b>',
			trigger: null,
			fields:
			{
				txtBuscar:
				{
					validators:
					{
						regexp:
						{
							message: '<b style="color: red;">Sólo se permite texto y números.</b>',
							regexp: /^[a-zA-Z0-9ñÑàèìòùÀÈÌÒÙáéíóúÁÉÍÓÚ\s@\.\-_]*$/
						}
					}
				}
			}
		});
	});

	function enviarBuscarPersonal(texto, url)
	{
		var isValid=null;

		$('#divSearch').data('formValidation').resetForm();
		$('#divSearch').data('formValidation').validate();

		isValid=$('#divSearch').data('formValidation').isValid();

		if(!isValid)
		{
			notaDatosIncorrectos();

			return;
		}

		$('#modalLoading').modal('show');
		$('#txtBuscar').attr('disabled', 'disabled');

		window.location.href=url+'/'+'?parametroBusqueda='+(texto==null ? $('#txtBuscar').val() : texto);
	}

	function buscarPersonal(texto, url, event)
	{
		var evt=event || window.event;

		var code=evt.charCode || evt.keyCode || evt.which;

		if(code==13)
		{
			enviarBuscarPersonal(texto, url);
		}
	}
</script>
@endsection