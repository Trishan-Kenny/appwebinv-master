<?php use App\Helper\PlataformHelper; ?>
@extends('template.layoutgeneral')
@section('titulo', 'Lista de asignaciones')
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
										<input type="text" id="txtBuscar" name="txtBuscar" class="form-control pull-right" placeholder="Información para búsqueda (Enter)" autofocus onkeyup="buscarAsignacion(this.value, '{{url('asignacion/ver/1')}}', event);" value="{{$parametroBusqueda}}">
									</div>
								</div>
								<div class="col-md-5">
									{!!(new PlataformHelper())->renderizarPaginacion('asignacion/ver', $cantidadPaginas, $paginaActual, $parametroBusqueda)!!}
								</div>
							</div>
							<hr>
							<div class="table-responsive">
								<table id="tableAsignacion" class="table" style="min-width: 777px;">
									<tbody>
										@foreach($listaTAsignacion as $value)
											<tr>
												<td style="background-color: #f5f5f5;border-top: 1px solid #999999;vertical-align: top;width: 350px;">
													<div style="color: #3737b1;font-size: 18px;font-weight: bold;">{{mb_strtoupper($value->descripcion)}}</div>
													<div><small><b>Usuario que asignó: </b>{{$value->tusuario->nombre.' '.$value->tusuario->apellido}}</small></div>
													<div><small><b>Personal a quien se asignó: </b>{{$value->tpersonal->nombre.' '.$value->tpersonal->apellido}}</small></div>
													<div><small><b>Fecha de asignación: </b>{{$value->created_at}}</small></div>
													<hr>
													<input type="button" class="btn btn-primary btn-block" onclick="window.open('{{url('asignacion/hojaentregapdf/'.$value->codigoAsignacion)}}', '_blank')" value="Imprimir hoja de entrega">
												</td>
												<td style="border-top: 1px solid #999999;vertical-align: top;">
													<table class="table table-bordered" style="font-size: 12px;">
														<thead>
															<tr>
																<th>Usuario que aplica devolución</th>
																<th>Datos principales del bien</th>
																<th class="text-center">Marca del bien</th>
																<th class="text-center">Modelo del bien</th>
																<th class="text-center">Tipo del bien</th>
																<th class="text-center">Color del bien</th>
																<th class="text-center">Estado del bien</th>
																<th class="text-center">Fecha dev. del bien</th>
															</tr>
														</thead>
														<tbody>
															@foreach($value->tasignaciondetalle as $item)
																<tr>
																	<td style="width: 140px;">{{$item->tusuario!=null ? ($item->tusuario->nombre.' '.$item->tusuario->apellido) : '---'}}</td>
																	<td>
																		<div><b>Cod. patrimonial: </b>{{$item->tbien->codigoPatrimonial}}</div>
																		<div><b>Serie: </b>{{$item->tbien->serie!='' ? $item->tbien->serie : '---'}}</div>
																		{{mb_strtoupper($item->tbien->descripcion)}}
																	</td>
																	<td class="text-center" style="width: 80px;">{{$item->tbien->marca!='' ? $item->tbien->marca : '---'}}</td>
																	<td class="text-center" style="width: 80px;">{{$item->tbien->modelo!='' ? $item->tbien->modelo : '---'}}</td>
																	<td class="text-center" style="width: 80px;">{{$item->tbien->tipo!='' ? $item->tbien->tipo : '---'}}</td>
																	<td class="text-center" style="width: 80px;">{{$item->tbien->color!='' ? $item->tbien->color : '---'}}</td>
																	<td class="text-center" style="width: 80px;">{{$item->estadoBien}}</td>
																	<td class="text-center" style="width: 80px;">{{$item->fechaDevolucion!=null ? $item->fechaDevolucion : '---'}}</td>
																</tr>
															@endforeach
														</tbody>
													</table>
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

	function enviarBuscarAsignacion(texto, url)
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

	function buscarAsignacion(texto, url, event)
	{
		var evt=event || window.event;

		var code=evt.charCode || evt.keyCode || evt.which;

		if(code==13)
		{
			enviarBuscarAsignacion(texto, url);
		}
	}
</script>
@endsection