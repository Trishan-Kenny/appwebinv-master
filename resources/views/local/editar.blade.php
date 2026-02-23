<form id="frmEditarLocal" action="{{url('local/editar')}}" method="post">
	<div class="tab-pane active" id="tab_1-1">
		<div class="row">
			<div class="form-group col-md-4">
				<label for="selectCodigoProvincia">Provincia</label>
				<select id="selectCodigoProvincia" name="selectCodigoProvincia" class="form-control selectStatic" style="width: 100%;" onchange="onChangeSelectCodigoProvincia();">
					@foreach($listaTProvincia as $value)
						<option value="{{$value->codigoProvincia}}" {{$value->codigoProvincia==$tLocal->tdistrito->codigoProvincia ? 'selected' : ''}}>{{$value->nombre}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-md-4">
				<label for="selectCodigoDistrito">Distrito</label>
				<select id="selectCodigoDistrito" name="selectCodigoDistrito" class="form-control selectStatic" style="width: 100%;">
					@foreach($listaTDistrito as $value)
						<option value="{{$value->codigoDistrito}}" {{$value->codigoDistrito==$tLocal->codigoDistrito ? 'selected' : ''}}>{{$value->nombre}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-md-4">
				<label for="txtNombre">Nombre</label>
				<input type="text" id="txtNombre" name="txtNombre" class="form-control" placeholder="Obligatorio" value="{{$tLocal->nombre}}">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<label for="txtDireccion">Dirección</label>
				<input type="text" id="txtDireccion" name="txtDireccion" class="form-control" placeholder="Obligatorio" value="{{$tLocal->direccion}}">
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12">
				{{csrf_field()}}
				<input type="hidden" name="hdCodigoLocal" value="{{$tLocal->codigoLocal}}">
				<input type="button" class="btn btn-default pull-left" value="Cerrar ventana" onclick="$('#dialogoGeneralModal').modal('hide');">
				<input type="button" class="btn btn-primary pull-right" value="Guardar cambios" onclick="enviarFrmEditarLocal();">
			</div>
		</div>
	</div>
</form>
<script>
	$(function()
	{
		$('#frmEditarLocal').formValidation(
		{
			framework : 'bootstrap',
			excluded : [':disabled', ':hidden', ':not(:visible)', '[class*="notValidate"]'],
			live : 'enabled',
			message : '<b style="color: #9d9d9d;">Asegúrese que realmente no necesita este valor.</b>',
			trigger : null,
			fields :
			{
				selectCodigoDistrito :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						}
					}
				},
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

	function onChangeSelectCodigoProvincia()
	{
		paginaAjaxJSON({ _token: '{{csrf_token()}}', codigoProvincia: $('#selectCodigoProvincia').val() }, '{{url('distrito/jsonporcodigoprovincia')}}', 'POST', null, function(objectJson)
		{
			if(!objectJson.correcto)
			{
				new PNotify(
				{
					title : 'No se pudo proceder',
					text : objectJson.mensajeGlobal,
					type : 'error'
				});

				return;
			}

			$('#selectCodigoDistrito').html(null);

			$('#selectCodigoDistrito').append(new Option('', '', false, false));

			objectJson.listaTDistrito.forEach(function(element)
			{
				$('#selectCodigoDistrito').append(new Option(element.nombre, element.codigoDistrito, false, false));
			});

			$('#selectCodigoDistrito').trigger('change');
		}, false, true);
	}

	function enviarFrmEditarLocal()
	{
		var isValid=null;

		$('#frmEditarLocal').data('formValidation').resetForm();
		$('#frmEditarLocal').data('formValidation').validate();

		isValid=$('#frmEditarLocal').data('formValidation').isValid();

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
				
				$('#frmEditarLocal')[0].submit();
			}
		});
	}
</script>