<form id="frmGestionarUsuarioTOficina" action="{{url('usuariotoficina/gestionar')}}" method="post">
	<div class="tab-pane active" id="tab_1-1">
		<div class="row">
			<div class="col-md-12">
				<select id="selectCodigoUsuario" name="selectCodigoUsuario[]" class="select" multiple style="width: 100%;">
					@foreach($listaTUsuario as $value)
						<?php $usuarioAsignado=false; ?>

						@foreach($tOficina->tusuariotoficina as $item)
							@if($value->codigoUsuario==$item->codigoUsuario)
								<?php $usuarioAsignado=true;break; ?>
							@endif
						@endforeach

						<option value="{{$value->codigoUsuario}}" {{$usuarioAsignado ? 'selected' : ''}}>{{$value->nombre.' '.$value->apellido}} ({{$value->correoElectronico}})</option>
					@endforeach
				</select>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12">
				{{csrf_field()}}
				<input type="hidden" name="hdCodigoOficina" value="{{$tOficina->codigoOficina}}">
				<input type="button" class="btn btn-default pull-left" value="Cerrar ventana" onclick="$('#dialogoGeneralModal').modal('hide');">
				<input type="button" class="btn btn-primary pull-right" value="Guardar cambios" onclick="enviarFrmGestionarUsuarioTOficina();">
			</div>
		</div>
	</div>
</form>
<script>
	$('.select').select2(
	{
		language:
		{
			noResults: function()
			{
				return "No se encontraron resultados.";        
			},
			searching: function()
			{
				return "Buscando...";
			},
			inputTooShort: function()
			{
				return 'Por favor ingrese 3 o más caracteres';
			}
		},
		placeholder: 'Buscar...'
	});

	function enviarFrmGestionarUsuarioTOficina()
	{
		swal(
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
				$('#modalLoading').modal('show');
				
				$('#frmGestionarUsuarioTOficina')[0].submit();	
			}
		});
	}
</script>