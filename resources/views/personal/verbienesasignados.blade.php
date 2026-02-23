<table class="table table-bordered" style="font-size: 12px;">
	<thead>
		<tr>
			<th>Datos principales del bien</th>
			<th class="text-center">Marca del bien</th>
			<th class="text-center">Modelo del bien</th>
			<th class="text-center">Tipo del bien</th>
			<th class="text-center">Color del bien</th>
			<th class="text-center">Estado bien entrega</th>
			<th class="text-center">Estado bien actual</th>
		</tr>
	</thead>
	<tbody>
		@foreach($listaTAsignacionDetalle as $value)
			<tr>
				<td>
					<div><b>Cod. patrimonial: </b>{{$value->tbien->codigoPatrimonial}}</div>
					<div><b>Serie: </b>{{$value->tbien->serie!='' ? $value->tbien->serie : '---'}}</div>
					{{mb_strtoupper($value->tbien->descripcion)}}
				</td>
				<td class="text-center" style="width: 80px;">{{$value->tbien->marca!='' ? $value->tbien->marca : '---'}}</td>
				<td class="text-center" style="width: 80px;">{{$value->tbien->modelo!='' ? $value->tbien->modelo : '---'}}</td>
				<td class="text-center" style="width: 80px;">{{$value->tbien->tipo!='' ? $value->tbien->tipo : '---'}}</td>
				<td class="text-center" style="width: 80px;">{{$value->tbien->color!='' ? $value->tbien->color : '---'}}</td>
				<td class="text-center" style="width: 80px;">{{$value->estadoBien}}</td>
				<td class="text-center" style="width: 80px;">{{$value->tbien->estado}}</td>
			</tr>
		@endforeach
	</tbody>
</table>
<hr>
<div class="row">
	<div class="col-md-12">
		{{csrf_field()}}
		<input type="button" class="btn btn-default pull-left" value="Cerrar ventana" onclick="$('#dialogoGeneralModal').modal('hide');">
		<input type="button" class="btn btn-primary pull-right" value="Aceptar" onclick="$('#dialogoGeneralModal').modal('hide');">
	</div>
</div>
<script>
</script>