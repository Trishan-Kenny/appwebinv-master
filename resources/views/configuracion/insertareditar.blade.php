@extends('template.layoutgeneral')
@section('titulo', 'Configuración')
@section('subTitulo', '...')
@section('cuerpoGeneral')
<div class="row">
	<div class="col-md-12">
		<div class="nav-tabs-custom">
			<div class="tab-content">
				<form id="frmInsertarEditarConfiguracion" action="{{url('configuracion/insertareditar')}}" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-4">
							<label for="txtTituloSistema">Título del sistema</label>
							<input type="text" id="txtTituloSistema" name="txtTituloSistema" class="form-control" placeholder="Obligatorio" value="{{$tConfiguracion!=null ? $tConfiguracion->tituloSistema : ''}}">
						</div>
						<div class="col-md-8">
							<label for="fileLogoSistema">Logo sistema*</label>
							<input type="file" id="fileLogoSistema" name="fileLogoSistema" class="form-control" accept="image/x-png,image/gif,image/jpeg,image/jpg">
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12 text-right">
							{!!csrf_field()!!}
							<input type="button" class="btn btn-primary" value="Guardar cambios" onclick="enviarFrmInsertarEditarConfiguracion();">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(function()
	{
		$('#frmInsertarEditarConfiguracion').formValidation(
		{
			framework: 'bootstrap',
			excluded : [':disabled', ':hidden', ':not(:visible)', '[class*="notValidate"]'],
			live: 'enabled',
			message: '<b style="color: #9d9d9d;">Asegúrese que realmente no necesita este valor.</b>',
			trigger: null,
			fields:
			{
				txtTituloSistema:
				{
					validators:
					{
						notEmpty:
						{
							message: '<b style="color: red;">Este campo es requerido.</b>'
						}
					}
				},
				fileLogoSistema:
				{
					validators:
					{
						file:
						{
							message: '<b style="color: red;">Sólo se permite formato "png, jpg o jpeg" y no más de 500KB.</b>',
							extension: 'png,jpg,jpeg',
							maxSize: 512000
						}
					}
				}
			}
		});
	});

	function enviarFrmInsertarEditarConfiguracion()
	{
		var isValid=null;

		$('#frmInsertarEditarConfiguracion').data('formValidation').resetForm();

		$('#frmInsertarEditarConfiguracion').data('formValidation').validate();

		isValid=$('#frmInsertarEditarConfiguracion').data('formValidation').isValid();

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
				
				$('#frmInsertarEditarConfiguracion')[0].submit();
			}
		});
	}
</script>
@endsection