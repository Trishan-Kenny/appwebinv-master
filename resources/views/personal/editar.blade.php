<form id="frmEditarPersonal" action="{{url('personal/editar')}}" method="post">
	<div class="tab-pane active" id="tab_1-1">
		<div class="row">
			<div class="form-group col-md-3">
				<label for="selectCodigoProvincia">Provincia</label>
				<select id="selectCodigoProvincia" name="selectCodigoProvincia" class="form-control selectStatic" style="width: 100%;" onchange="onChangeSelectCodigoProvincia();">
					@foreach($listaTProvincia as $value)
						<option value="{{$value->codigoProvincia}}" {{$tPersonal->tdependencia->tlocal->tdistrito->codigoProvincia==$value->codigoProvincia ? 'selected' : ''}}>{{$value->nombre}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-md-3">
				<label for="selectCodigoDistrito">Distrito</label>
				<select id="selectCodigoDistrito" name="selectCodigoDistrito" class="form-control selectStatic" style="width: 100%;" onchange="onChangeSelectCodigoDistrito();">
					@foreach($listaTDistrito as $value)
						<option value="{{$value->codigoDistrito}}" {{$tPersonal->tdependencia->tlocal->codigoDistrito==$value->codigoDistrito ? 'selected' : ''}}>{{$value->nombre}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-md-3">
				<label for="selectCodigoLocal">Local</label>
				<select id="selectCodigoLocal" name="selectCodigoLocal" class="form-control selectStatic" style="width: 100%;" onchange="onChangeSelectCodigoLocal();">
					@foreach($listaTLocal as $value)
						<option value="{{$value->codigoLocal}}" {{$tPersonal->tdependencia->codigoLocal==$value->codigoLocal ? 'selected' : ''}}>{{$value->nombre}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-md-3">
				<label for="selectCodigoDependencia">Dependencia</label>
				<select id="selectCodigoDependencia" name="selectCodigoDependencia" class="form-control selectStatic" style="width: 100%;">
					@foreach($listaTDependencia as $value)
						<option value="{{$value->codigoDependencia}}" {{$tPersonal->codigoDependencia==$value->codigoDependencia ? 'selected' : ''}}>{{$value->nombre}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-3">
				<label for="selectCodigoArea">Área</label>
				<select id="selectCodigoArea" name="selectCodigoArea" class="form-control selectStatic" style="width: 100%;">
					@foreach($listaTArea as $value)
						<option value="{{$value->codigoArea}}" {{$tPersonal->codigoArea==$value->codigoArea ? 'selected' : ''}}>{{$value->nombre}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-md-3">
				<label for="selectCodigoCargo">Cargo</label>
				<select id="selectCodigoCargo" name="selectCodigoCargo" class="form-control selectStatic" style="width: 100%;">
					@foreach($listaTCargo as $value)
						<option value="{{$value->codigoCargo}}" {{$tPersonal->codigoCargo==$value->codigoCargo ? 'selected' : ''}}>{{$value->nombre}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-md-3">
				<label for="selectCodigoSituacion">Situación</label>
				<select id="selectCodigoSituacion" name="selectCodigoSituacion" class="form-control selectStatic" style="width: 100%;">
					@foreach($listaTSituacion as $value)
						<option value="{{$value->codigoSituacion}}" {{$tPersonal->codigoSituacion==$value->codigoSituacion ? 'selected' : ''}}>{{$value->nombre}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-md-3">
				<label for="txtDni">DNI</label>
				<input type="text" id="txtDni" name="txtDni" class="form-control" placeholder="Obligatorio" value="{{$tPersonal->dni}}">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-3">
				<label for="txtNombre">Nombre</label>
				<input type="text" id="txtNombre" name="txtNombre" class="form-control" placeholder="Obligatorio" value="{{$tPersonal->nombre}}">
			</div>
			<div class="form-group col-md-3">
				<label for="txtApellido">Apellido</label>
				<input type="text" id="txtApellido" name="txtApellido" class="form-control" placeholder="Obligatorio" value="{{$tPersonal->apellido}}">
			</div>
			<div class="form-group col-md-3">
				<label for="txtCorreoElectronico">Correo electrónico</label>
				<input type="text" id="txtCorreoElectronico" name="txtCorreoElectronico" class="form-control" placeholder="Obligatorio" value="{{$tPersonal->correoElectronico}}">
			</div>
			<div class="form-group col-md-3">
				<label for="txtCelular">Celular</label>
				<input type="text" id="txtCelular" name="txtCelular" class="form-control" placeholder="Obligatorio" value="{{$tPersonal->celular}}">
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12">
				{{csrf_field()}}
				<input type="hidden" name="hdCodigoPersonal" value="{{$tPersonal->codigoPersonal}}">
				<input type="button" class="btn btn-default pull-left" value="Cerrar ventana" onclick="$('#dialogoGeneralModal').modal('hide');">
				<input type="button" class="btn btn-primary pull-right" value="Guardar cambios" onclick="enviarFrmEditarPersonal();">
			</div>
		</div>
	</div>
</form>
<script>
	$(function()
	{
		$('#frmEditarPersonal').formValidation(
		{
			framework : 'bootstrap',
			excluded : [':disabled', ':hidden', ':not(:visible)', '[class*="notValidate"]'],
			live : 'enabled',
			message : '<b style="color: #9d9d9d;">Asegúrese que realmente no necesita este valor.</b>',
			trigger : null,
			fields :
			{
				selectCodigoDependencia :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						}
					}
				},
				selectCodigoArea :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						}
					}
				},
				selectCodigoCargo :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						}
					}
				},
				selectCodigoSituacion :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						}
					}
				},
				txtDni :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						},
						regexp :
						{
							message : '<b style="color: red;">Formato incorrecto. [Ingrese un DNI válido.].</b>',
							regexp : /^[0-9]{8}$/
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
						}
					}
				},
				txtApellido :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						}
					}
				},
				txtCorreoElectronico :
				{
					validators : 
					{
						regexp :
						{
							message : '<b style="color: red;">Formato incorrecto. [Ejemplo: nombre@gmail.com].</b>',
							regexp : /^[a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\-_]+\.[a-zA-Z]+(\.[a-zA-Z]+)?$/
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

			$('#selectCodigoLocal').html(null);
			$('#selectCodigoDependencia').html(null);
		}, false, true);
	}

	function onChangeSelectCodigoDistrito()
	{
		if($('#selectCodigoDistrito').val()=='' || $('#selectCodigoDistrito').val()==null){ return false; }

		paginaAjaxJSON({ _token: '{{csrf_token()}}', codigoDistrito: $('#selectCodigoDistrito').val() }, '{{url('local/jsonporcodigodistrito')}}', 'POST', null, function(objectJson)
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

			$('#selectCodigoLocal').html(null);

			$('#selectCodigoLocal').append(new Option('', '', false, false));

			objectJson.listaTLocal.forEach(function(element)
			{
				$('#selectCodigoLocal').append(new Option(element.nombre, element.codigoLocal, false, false));
			});

			$('#selectCodigoLocal').trigger('change');

			$('#selectCodigoDependencia').html(null);
		}, false, true);
	}

	function onChangeSelectCodigoLocal()
	{
		if($('#selectCodigoLocal').val()=='' || $('#selectCodigoLocal').val()==null){ return false; }

		paginaAjaxJSON({ _token: '{{csrf_token()}}', codigoLocal: $('#selectCodigoLocal').val() }, '{{url('dependencia/jsonporcodigolocal')}}', 'POST', null, function(objectJson)
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

			$('#selectCodigoDependencia').html(null);

			$('#selectCodigoDependencia').append(new Option('', '', false, false));

			objectJson.listaTDependencia.forEach(function(element)
			{
				$('#selectCodigoDependencia').append(new Option(element.nombre, element.codigoDependencia, false, false));
			});

			$('#selectCodigoDependencia').trigger('change');
		}, false, true);
	}

	function enviarFrmEditarPersonal()
	{
		var isValid=null;

		$('#frmEditarPersonal').data('formValidation').resetForm();
		$('#frmEditarPersonal').data('formValidation').validate();

		isValid=$('#frmEditarPersonal').data('formValidation').isValid();

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
				
				$('#frmEditarPersonal')[0].submit();
			}
		});
	}
</script>