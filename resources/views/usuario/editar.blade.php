<form id="frmEditarUsuario" action="{{url('usuario/editar')}}" method="post">
	<div class="tab-pane active" id="tab_1-1">
		<div class="row">
			<div class="form-group col-md-4">
				<label for="txtDni">DNI</label>
				<input type="text" id="txtDni" name="txtDni" class="form-control" placeholder="Obligatorio" value="{{$tUsuario->dni}}">
			</div>
			<div class="form-group col-md-4">
				<label for="txtNombre">Nombres</label>
				<input type="text" id="txtNombre" name="txtNombre" class="form-control" placeholder="Obligatorio" value="{{$tUsuario->nombre}}">
			</div>
			<div class="form-group col-md-4">
				<label for="txtApellido">Apellidos</label>
				<input type="text" id="txtApellido" name="txtApellido" class="form-control" placeholder="Obligatorio" value="{{$tUsuario->apellido}}">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="txtCorreoElectronico">Correo electrónico</label>
				<input type="text" id="txtCorreoElectronico" name="txtCorreoElectronico" class="form-control" placeholder="Obligatorio" value="{{$tUsuario->correoElectronico}}">
			</div>
			<div class="form-group col-md-6">
				<label for="selectEstado">Estado</label>
				<select id="selectEstado" name="selectEstado" class="form-control">
					<option value="Pendiente" {{$tUsuario->estado=='Pendiente' ? 'selected' : ''}}>Pendiente</option>
					<option value="Activo" {{$tUsuario->estado=='Activo' ? 'selected' : ''}}>Activo</option>
					<option value="Bloqueado" {{$tUsuario->estado=='Bloqueado' ? 'selected' : ''}}>Bloqueado</option>
				</select>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="form-group col-md-12">
				<label for="selectRol">Rol</label>
				<select id="selectRol" name="selectRol[]" class="selectStatic" multiple style="width: 100%;">
					<option value="Administrador" {{strpos($tUsuario->rol, 'Administrador')!==false ? 'selected' : ''}}>Administrador</option>
					<option value="Usuario general" {{strpos($tUsuario->rol, 'Usuario general')!==false ? 'selected' : ''}}>Usuario general</option>
				</select>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12">
				{{csrf_field()}}
				<input type="hidden" name="hdCodigoUsuario" value="{{$tUsuario->codigoUsuario}}">
				<input type="button" class="btn btn-default pull-left" value="Cerrar ventana" onclick="$('#dialogoGeneralModal').modal('hide');">
				<input type="button" class="btn btn-primary pull-right" value="Guardar cambios" onclick="enviarFrmEditarUsuario();">
			</div>
		</div>
	</div>
</form>
<script>
	$(function()
	{
		$('.datePicker').datepicker(
		{
			autoclose : true,
			format : 'yyyy-mm-dd'
		});

		$('#frmEditarUsuario').formValidation(
		{
			framework : 'bootstrap',
			excluded : [':disabled', ':hidden', ':not(:visible)', '[class*="notValidate"]'],
			live : 'enabled',
			message : '<b style="color: #9d9d9d;">Asegúrese que realmente no necesita este valor.</b>',
			trigger : null,
			fields :
			{
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
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						},
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

	function enviarFrmEditarUsuario()
	{
		var isValid=null;

		$('#frmEditarUsuario').data('formValidation').resetForm();
		$('#frmEditarUsuario').data('formValidation').validate();

		isValid=$('#frmEditarUsuario').data('formValidation').isValid();

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
				
				$('#frmEditarUsuario')[0].submit();
			}
		});
	}
</script>