<form id="frmEditarSituacion" action="{{url('situacion/editar')}}" method="post">
	<div class="tab-pane active" id="tab_1-1">
		<div class="row">
			<div class="form-group col-md-12">
				<label for="txtNombre">Nombre</label>
				<input type="text" id="txtNombre" name="txtNombre" class="form-control" placeholder="Obligatorio" value="{{$tSituacion->nombre}}">
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12">
				{{csrf_field()}}
				<input type="hidden" name="hdCodigoSituacion" value="{{$tSituacion->codigoSituacion}}">
				<input type="button" class="btn btn-default pull-left" value="Cerrar ventana" onclick="$('#dialogoGeneralModal').modal('hide');">
				<input type="button" class="btn btn-primary pull-right" value="Guardar cambios" onclick="enviarFrmEditarSituacion();">
			</div>
		</div>
	</div>
</form>
<script>
	$(function()
	{
		$('#frmEditarSituacion').formValidation(
		{
			framework : 'bootstrap',
			excluded : [':disabled', ':hidden', ':not(:visible)', '[class*="notValidate"]'],
			live : 'enabled',
			message : '<b style="color: #9d9d9d;">Asegúrese que realmente no necesita este valor.</b>',
			trigger : null,
			fields :
			{
				txtNombre :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						},
						regexp :
						{
							message : '<b style="color: red;">Formato incorrecto. [Sólo se permite texto, números y espacios].</b>',
							regexp : /^[a-zA-Z0-9ñÑàèìòùÀÈÌÒÙáéíóúÁÉÍÓÚ\s*]*$/
						}
					}
				}
			}
		});
	});

	function enviarFrmEditarSituacion()
	{
		var isValid=null;

		$('#frmEditarSituacion').data('formValidation').resetForm();
		$('#frmEditarSituacion').data('formValidation').validate();

		isValid=$('#frmEditarSituacion').data('formValidation').isValid();

		if(!isValid)
		{
			new PNotify(
			{
				title : 'No se pudo proceder',
				text : 'Por favor complete y corrija toda la información necesaria antes de continuar.',
				type : 'error'
			});

			return;
		}

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
				
				$('#frmEditarSituacion')[0].submit();
			}
		});
	}
</script>