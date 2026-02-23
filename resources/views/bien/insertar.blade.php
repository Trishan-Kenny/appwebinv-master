@extends('template.layoutgeneral')
@section('titulo', 'Registrar bien')
@section('subTitulo', '...')
@section('cuerpoGeneral')
<div class="row">
	<div class="col-md-12">
		<div class="nav-tabs-custom">
			<div class="tab-content">
				<form id="frmInsertarBien" action="{{url('bien/insertar')}}" method="post">
					<div class="tab-pane active" id="tab_1-1">
						<div class="row">
							<div class="form-group col-md-6">
								<label for="txtDescripcion">Descripción del bien</label>
								<input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" placeholder="Obligatorio" value="{{old('txtDescripcion')}}">
							</div>
							<div class="form-group col-md-3">
								<label for="txtCodigoPatrimonial">Código patrimonial</label>
								<input type="text" id="txtCodigoPatrimonial" name="txtCodigoPatrimonial" class="form-control" value="{{old('txtCodigoPatrimonial')}}">
							</div>
							<div class="form-group col-md-3">
								<label for="txtCodigoInterno">Código interno</label>
								<input type="text" id="txtCodigoInterno" name="txtCodigoInterno" class="form-control" value="{{old('txtCodigoInterno')}}">
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-3">
								<label for="txtCodigoM">Código M</label>
								<input type="text" id="txtCodigoM" name="txtCodigoM" class="form-control" value="{{old('txtCodigoM')}}">
							</div>
							<div class="form-group col-md-3">
								<label for="txtSerie">Serie</label>
								<input type="text" id="txtSerie" name="txtSerie" class="form-control" value="{{old('txtSerie')}}">
							</div>
							<div class="form-group col-md-3">
								<label for="txtMarca">Marca</label>
								<input type="text" id="txtMarca" name="txtMarca" class="form-control" value="{{old('txtMarca')}}">
							</div>
							<div class="form-group col-md-3">
								<label for="txtModelo">Modelo</label>
								<input type="text" id="txtModelo" name="txtModelo" class="form-control" value="{{old('txtModelo')}}">
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-3">
								<label for="txtTipo">Tipo</label>
								<input type="text" id="txtTipo" name="txtTipo" class="form-control" value="{{old('txtTipo')}}">
							</div>
							<div class="form-group col-md-3">
								<label for="txtColor">Color</label>
								<input type="text" id="txtColor" name="txtColor" class="form-control" value="{{old('txtColor')}}">
							</div>
							<div class="form-group col-md-3">
								<label for="txtObservacion">Observación</label>
								<input type="text" id="txtObservacion" name="txtObservacion" class="form-control" value="{{old('txtObservacion')}}">
							</div>
							<div class="form-group col-md-3">
								<label for="selectEstado">Estado</label>
								<select id="selectEstado" name="selectEstado" class="form-control selectStatic" style="width: 100%;">
									<option value=""></option>
									<option value="Bueno">Bueno</option>
									<option value="Regular">Regular</option>
									<option value="Malo">Malo</option>
									<option value="Inservible">Inservible</option>
									<option value="Desechado">Desechado</option>
									<option value="Perdido">Perdido</option>
								</select>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-12">
								{{csrf_field()}}
								<input type="button" class="btn btn-primary pull-right" value="Registrar datos ingresados" onclick="enviarFrmInsertarBien();">
							</div>
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
		$('#frmInsertarBien').formValidation(
		{
			framework : 'bootstrap',
			excluded : [':disabled', ':hidden', ':not(:visible)', '[class*="notValidate"]'],
			live : 'enabled',
			message : '<b style="color: #9d9d9d;">Asegúrese que realmente no necesita este valor.</b>',
			trigger : null,
			fields :
			{
				txtDescripcion :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						}
					}
				},
				selectEstado :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						}
					}
				}
			}
		});
	});

	function enviarFrmInsertarBien()
	{
		var isValid=null;

		$('#frmInsertarBien').data('formValidation').resetForm();
		$('#frmInsertarBien').data('formValidation').validate();

		isValid=$('#frmInsertarBien').data('formValidation').isValid();

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
				
				$('#frmInsertarBien')[0].submit();
			}
		});
	}
</script>
@endsection