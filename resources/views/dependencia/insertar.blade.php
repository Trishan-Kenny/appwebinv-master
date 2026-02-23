@extends('template.layoutgeneral')
@section('titulo', 'Registrar dependencia')
@section('subTitulo', '...')
@section('cuerpoGeneral')
<div class="row">
	<div class="col-md-12">
		<div class="nav-tabs-custom">
			<div class="tab-content">
				<form id="frmInsertarDependencia" action="{{url('dependencia/insertar')}}" method="post">
					<div class="tab-pane active" id="tab_1-1">
						<div class="row">
							<div class="form-group col-md-4">
								<label for="selectCodigoProvincia">Provincia</label>
								<select id="selectCodigoProvincia" name="selectCodigoProvincia" class="form-control selectStatic" style="width: 100%;" onchange="onChangeSelectCodigoProvincia();">
									<option></option>
									@foreach($listaTProvincia as $value)
										<option value="{{$value->codigoProvincia}}">{{$value->nombre}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-4">
								<label for="selectCodigoDistrito">Distrito</label>
								<select id="selectCodigoDistrito" name="selectCodigoDistrito" class="form-control selectStatic" style="width: 100%;" onchange="onChangeSelectCodigoDistrito();"></select>
							</div>
							<div class="form-group col-md-4">
								<label for="selectCodigoLocal">Local</label>
								<select id="selectCodigoLocal" name="selectCodigoLocal" class="form-control selectStatic" style="width: 100%;"></select>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<label for="txtNombre">Nombre</label>
								<input type="text" id="txtNombre" name="txtNombre" class="form-control" placeholder="Obligatorio" value="{{old('txtNombre')}}">
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-12">
								{{csrf_field()}}
								<input type="button" class="btn btn-primary pull-right" value="Registrar datos ingresados" onclick="enviarFrmInsertarDependencia();">
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
		$('#frmInsertarDependencia').formValidation(
		{
			framework : 'bootstrap',
			excluded : [':disabled', ':hidden', ':not(:visible)', '[class*="notValidate"]'],
			live : 'enabled',
			message : '<b style="color: #9d9d9d;">Asegúrese que realmente no necesita este valor.</b>',
			trigger : null,
			fields :
			{
				selectCodigoLocal :
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
						}
					}
				}
			}
		});
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
		}, false, true);
	}

	function onChangeSelectCodigoDistrito()
	{
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
		}, false, true);
	}

	function enviarFrmInsertarDependencia()
	{
		var isValid=null;

		$('#frmInsertarDependencia').data('formValidation').resetForm();
		$('#frmInsertarDependencia').data('formValidation').validate();

		isValid=$('#frmInsertarDependencia').data('formValidation').isValid();

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
				
				$('#frmInsertarDependencia')[0].submit();
			}
		});
	}
</script>
@endsection