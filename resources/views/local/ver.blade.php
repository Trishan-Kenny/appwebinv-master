@extends('template.layoutgeneral')
@section('titulo', 'Lista de locales')
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
								<input type="text" id="txtBuscar" name="txtBuscar" class="form-control" autocomplete="off" placeholder="Ingrese datos de búsqueda (Enter)" onkeyup="filtrarHtml('tableLocal', this.value, false, 0, event);">
							</div>
							<hr>
							<div class="table-responsive">
								<table id="tableLocal" class="table table-striped" style="min-width: 777px;">
									<thead>
										<tr>
											<th>Nombre</th>
											<th>Provincia</th>
											<th>Distrito</th>
											<th>Dirección</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach($listaTLocal as $value)
											<tr class="elementoBuscar">
												<td>{{$value->nombre}}</td>
												<td>{{$value->tdistrito->tprovincia->nombre}}</td>
												<td>{{$value->tdistrito->nombre}}</td>
												<td>{{$value->direccion}}</td>
												<td class="text-right">
													<span class="btn btn-default btn-xs glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" title="Editar" onclick="dialogoAjax('dialogoGeneral', null, '{{$value->nombre}} (Editar)', { _token : '{{csrf_token()}}', codigoLocal : '{{$value->codigoLocal}}' }, '{{url('local/editar')}}', 'POST', null, null, false, true);"></span>
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