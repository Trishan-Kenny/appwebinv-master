@extends('template.layoutgeneral')
@section('titulo', 'Registro de usuario')
@section('subTitulo', '...')
@section('cuerpoGeneral')
<div class="row">
	<div class="col-md-12">
		<div class="nav-tabs-custom">
			<div class="tab-content">
				<form id="frmInsertarUsuario" action="{{url('usuario/insertar')}}" method="post">
					<div class="tab-pane active" id="tab_1-1">
						<div class="row">
							<div class="form-group col-md-4">
								<label for="txtDni">DNI</label>
								<input type="text" id="txtDni" name="txtDni" class="form-control" placeholder="Obligatorio" value="{{old('txtDni')}}">
							</div>
							<div class="form-group col-md-4">
								<label for="txtNombre">Nombres</label>
								<input type="text" id="txtNombre" name="txtNombre" class="form-control" placeholder="Obligatorio" value="{{old('txtNombre')}}">
							</div>
							<div class="form-group col-md-4">
								<label for="txtApellido">Apellidos</label>
								<input type="text" id="txtApellido" name="txtApellido" class="form-control" placeholder="Obligatorio" value="{{old('txtApellido')}}">
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-4">
								<label for="txtCorreoElectronico">Correo electrónico</label>
								<input type="text" id="txtCorreoElectronico" name="txtCorreoElectronico" class="form-control" placeholder="Obligatorio" value="{{old('txtCorreoElectronico')}}">
							</div>
							<div class="form-group col-md-4">
								<label for="passContrasenia">Contraseña</label>
								<input type="password" id="passContrasenia" name="passContrasenia" class="form-control" placeholder="Obligatorio" value="{{old('passContrasenia')}}">
							</div>
							<div class="form-group col-md-4">
								<label for="passContraseniaRepita">Repita contraseña</label>
								<input type="password" id="passContraseniaRepita" name="passContraseniaRepita" class="form-control" placeholder="Obligatorio" value="{{old('passContraseniaRepita')}}">
							</div>
						</div>
						@if(strpos(Session::get('rol'), 'Súper usuario')!==false)
							<hr>
							<div class="row">
								<div class="form-group col-md-12">
									<label for="selectRol">Rol</label>
									<select id="selectRol" name="selectRol[]" class="selectStatic" multiple style="width: 100%;">
										<option value="Administrador" {{old('selectRol')!=null ? (in_array('Administrador', old('selectRol')) ? 'selected' : '') : ''}}>Administrador</option>
										<option value="Usuario general" {{old('selectRol')!=null ? (in_array('Usuario general', old('selectRol')) ? 'selected' : '') : ''}}>Usuario general</option>
									</select>
								</div>
							</div>
						@endif
						<hr>
						<div class="row">
							<div class="col-md-12">
								{{csrf_field()}}
								<input type="button" class="btn btn-primary pull-right" value="Registrar datos ingresados" onclick="enviarFrmInsertarUsuario();">
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
		$('#frmInsertarUsuario').formValidation(
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
				},
				passContrasenia :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						},
						identical :
						{
							message : '<b style="color: red;">Este campo no coincide con su confirmación correspondiente.</b>',
							field : 'passContraseniaRepita'
						}
					}
				},
				passContraseniaRepita :
				{
					validators : 
					{
						identical :
						{
							message : '<b style="color: red;">Este campo no coincide con su confirmación correspondiente.</b>',
							field : 'passContrasenia'
						}
					}
				}
			}
		});
	});

	function enviarFrmInsertarUsuario()
	{
		var isValid=null;

		$('#frmInsertarUsuario').data('formValidation').resetForm();
		$('#frmInsertarUsuario').data('formValidation').validate();

		isValid=$('#frmInsertarUsuario').data('formValidation').isValid();

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
				
				$('#frmInsertarUsuario')[0].submit();
			}
		});
	}
</script>
@endsection