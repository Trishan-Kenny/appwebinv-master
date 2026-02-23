<?php use App\Helper\PlataformHelper; ?>
@extends('template.layoutgeneral')
@section('titulo', 'Lista de bienes')
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
										<input type="text" id="txtBuscar" name="txtBuscar" class="form-control pull-right" placeholder="Información para búsqueda (Enter)" autofocus onkeyup="buscarBien(this.value, '{{url('bien/ver/1')}}', event);" value="{{$parametroBusqueda}}">
									</div>
								</div>
								<div class="col-md-5">
									{!!(new PlataformHelper())->renderizarPaginacion('bien/ver', $cantidadPaginas, $paginaActual, $parametroBusqueda)!!}
								</div>
							</div>
							<hr>
							<div class="table-responsive">
								<table id="tableBien" class="table table-striped table-bordered" style="min-width: 777px;">
									<thead>
										<tr>
											<th>Bien</th>
											<th class="text-center">Serie</th>
											<th class="text-center">Marca</th>
											<th class="text-center">Modelo</th>
											<th class="text-center">Tipo</th>
											<th class="text-center">Color</th>
											<th>Observación</th>
											<th class="text-center">Estado</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach($listaTBien as $value)
											<tr>
												<td>
													<div><small><b>Cód. patrimonial: </b>{{$value->codigoPatrimonial}}</small></div>
													<div>{{$value->descripcion}}</div>
													<small><b>Actualmente en posesión de: </b>{{count($value->tasignaciondetalle)>0 ? $value->tasignaciondetalle[0]->tasignacion->tpersonal->nombre.' '.$value->tasignaciondetalle[0]->tasignacion->tpersonal->apellido : '---'}}</small>
												</td>
												<td class="text-center">{{$value->serie!='' ? $value->serie : '---'}}</td>
												<td class="text-center">{{$value->marca!='' ? $value->marca : '---'}}</td>
												<td class="text-center">{{$value->modelo!='' ? $value->modelo : '---'}}</td>
												<td class="text-center">{{$value->tipo!='' ? $value->tipo : '---'}}</td>
												<td class="text-center">{{$value->color!='' ? $value->color : '---'}}</td>
												<td>{{$value->observacion!='' ? $value->observacion : '---'}}</td>
												<td class="text-center">
													<span class="label label-{{$value->estado=='Bueno' ? 'info' : ($value->estado=='Regular' ? 'success' : ($value->estado=='Malo' ? 'warning' : ($value->estado=='Inservible' ? 'danger' : ($value->estado=='Desechado' ? 'default' : 'danger'))))}}">{{$value->estado}}</span>
												</td>
												<td class="text-right">
													<span class="btn btn-default btn-xs glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" title="Editar" onclick="dialogoAjax('dialogoGeneral', 77, '{{$value->descripcion.' ['.$value->codigoPatrimonial.']'}} (Editar)', { _token : '{{csrf_token()}}', codigoBien : '{{$value->codigoBien}}' }, '{{url('bien/editar')}}', 'POST', null, null, false, true);"></span>
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

	function enviarBuscarBien(texto, url)
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

	function buscarBien(texto, url, event)
	{
		var evt=event || window.event;

		var code=evt.charCode || evt.keyCode || evt.which;

		if(code==13)
		{
			enviarBuscarBien(texto, url);
		}
	}
</script>
@endsection