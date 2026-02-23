<form id="frmEditarBien" action="{{url('bien/editar')}}" method="post">
	<div class="tab-pane active" id="tab_1-1">
		<div class="row">
			<div class="form-group col-md-6">
				<label for="txtDescripcion">Descripción del bien</label>
				<input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" placeholder="Obligatorio" value="{{$tBien->descripcion}}">
			</div>
			<div class="form-group col-md-3">
				<label for="txtCodigoPatrimonial">Código patrimonial</label>
				<input type="text" id="txtCodigoPatrimonial" name="txtCodigoPatrimonial" class="form-control" value="{{$tBien->codigoPatrimonial}}">
			</div>
			<div class="form-group col-md-3">
				<label for="txtCodigoInterno">Código interno</label>
				<input type="text" id="txtCodigoInterno" name="txtCodigoInterno" class="form-control" value="{{$tBien->codigoInterno}}">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-3">
				<label for="txtCodigoM">Código M</label>
				<input type="text" id="txtCodigoM" name="txtCodigoM" class="form-control" value="{{$tBien->codigoM}}">
			</div>
			<div class="form-group col-md-3">
				<label for="txtSerie">Serie</label>
				<input type="text" id="txtSerie" name="txtSerie" class="form-control" value="{{$tBien->serie}}">
			</div>
			<div class="form-group col-md-3">
				<label for="txtMarca">Marca</label>
				<input type="text" id="txtMarca" name="txtMarca" class="form-control" value="{{$tBien->marca}}">
			</div>
			<div class="form-group col-md-3">
				<label for="txtModelo">Modelo</label>
				<input type="text" id="txtModelo" name="txtModelo" class="form-control" value="{{$tBien->modelo}}">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-3">
				<label for="txtTipo">Tipo</label>
				<input type="text" id="txtTipo" name="txtTipo" class="form-control" value="{{$tBien->tipo}}">
			</div>
			<div class="form-group col-md-3">
				<label for="txtColor">Color</label>
				<input type="text" id="txtColor" name="txtColor" class="form-control" value="{{$tBien->color}}">
			</div>
			<div class="form-group col-md-3">
				<label for="txtObservacion">Observación</label>
				<input type="text" id="txtObservacion" name="txtObservacion" class="form-control" value="{{$tBien->observacion}}">
			</div>
			<div class="form-group col-md-3">
				<label for="selectEstado">Estado</label>
				<select id="selectEstado" name="selectEstado" class="form-control selectStatic" style="width: 100%;">
					<option value="Bueno" {{$tBien->estado=='Bueno' ? 'selected' : ''}}>Bueno</option>
					<option value="Regular" {{$tBien->estado=='Regular' ? 'selected' : ''}}>Regular</option>
					<option value="Malo" {{$tBien->estado=='Malo' ? 'selected' : ''}}>Malo</option>
					<option value="Inservible" {{$tBien->estado=='Inservible' ? 'selected' : ''}}>Inservible</option>
					<option value="Desechado" {{$tBien->estado=='Desechado' ? 'selected' : ''}}>Desechado</option>
					<option value="Perdido" {{$tBien->estado=='Perdido' ? 'selected' : ''}}>Perdido</option>
				</select>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12">
				{{csrf_field()}}
				<input type="hidden" name="hdCodigoBien" value="{{$tBien->codigoBien}}">
				<input type="button" class="btn btn-default pull-left" value="Cerrar ventana" onclick="$('#dialogoGeneralModal').modal('hide');">
				<input type="button" class="btn btn-primary pull-right" value="Guardar cambios" onclick="enviarFrmEditarBien();">
			</div>
		</div>
	</div>
</form>
<script>
	$(function()
	{
		$('#frmEditarBien').formValidation(
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

	$('.selectStatic').select2(
	{
		language :
		{
			noResults : function()
			{
				return "No se encontraron resultados.";
			},
			searching : function()
			{
				return "Buscando...";
			},
			inputTooShort : function()
			{ 
				return 'Por favor ingrese 3 o más caracteres';
			}
		},
		placeholder : 'Buscar...'
	});

	function enviarFrmEditarBien()
	{
		var isValid=null;

		$('#frmEditarBien').data('formValidation').resetForm();
		$('#frmEditarBien').data('formValidation').validate();

		isValid=$('#frmEditarBien').data('formValidation').isValid();

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
				
				$('#frmEditarBien')[0].submit();
			}
		});
	}
</script>