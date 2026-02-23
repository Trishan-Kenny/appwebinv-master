@extends('template.layoutgeneral')
@section('titulo', 'Asignar bienes')
@section('subTitulo', '...')
@section('cuerpoGeneral')
<div class="row">
	<div class="col-md-12">
		<div class="nav-tabs-custom">
			<div class="tab-content">
				<form id="frmInsertarAsignacion" action="{{url('asignacion/insertar')}}" method="post">
					<div class="tab-pane active" id="tab_1-1">
						<div class="row">
							<div class="form-group col-md-4">
								<label for="txtDniPersonal">DNI personal</label>
								<input type="text" id="txtDniPersonal" name="txtDniPersonal" class="form-control" placeholder="Obligatorio" value="{{old('txtDniPersonal')}}" onkeyup="onKeyUpTxtDniPersonal();">
								<input type="hidden" id="hdCodigoPersonal" name="hdCodigoPersonal" class="form-control" placeholder="Obligatorio" value="{{old('hdCodigoPersonal')}}" onkeyup="onKeyUpTxtDniPersonal();">
							</div>
							<div class="form-group col-md-8">
								<label for="txtNombreCompletoPersonal">Nombre completo personal</label>
								<input type="text" id="txtNombreCompletoPersonal" name="txtNombreCompletoPersonal" class="form-control" placeholder="Obligatorio" readonly="readonly" value="{{old('txtNombreCompletoPersonal')}}">
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-4">
								<label for="txtNombreDependencia">Dependencia</label>
								<input type="text" id="txtNombreDependencia" name="txtNombreDependencia" class="form-control" placeholder="Obligatorio" readonly="readonly" value="{{old('txtNombreDependencia')}}">
							</div>
							<div class="form-group col-md-4">
								<label for="txtNombreArea">Área</label>
								<input type="text" id="txtNombreArea" name="txtNombreArea" class="form-control" placeholder="Obligatorio" readonly="readonly" value="{{old('txtNombreArea')}}">
							</div>
							<div class="form-group col-md-4">
								<label for="txtNombreCargo">Cargo</label>
								<input type="text" id="txtNombreCargo" name="txtNombreCargo" class="form-control" placeholder="Obligatorio" readonly="readonly" value="{{old('txtNombreCargo')}}">
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="form-group col-md-10">
								<label for="selectBien">Buscar el bien que se desea asignar al personal seleccionado</label>
								<select id="selectBien" name="selectBien" class="form-control" style="width: 100%;" onchange="onChangeSelectBien();"></select>
							</div>
							<div class="form-group col-md-2">
								<label for="selectBien">&nbsp;</label>
								<input type="button" class="btn btn-info btn-block" value="Nuevo bien" onclick="$('#modalNuevoBien').modal('show');">
							</div>
						</div>
						<hr>
						<div class="table-responsive">
							<table id="tableBienAsignado" class="table table-striped table-bordered" style="min-width: 777px;">
								<thead>
									<tr>
										<th style="display: none;"></th>
										<th>Descripción</th>
										<th class="text-center">Código patrimonial</th>
										<th class="text-center">Código interno</th>
										<th class="text-center">Código M</th>
										<th class="text-center">Serie</th>
										<th class="text-center">Marca</th>
										<th class="text-center">Modelo</th>
										<th class="text-center">Tipo</th>
										<th class="text-center">Color</th>
										<th class="text-center">Estado</th>
										<th></th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-12">
								{{csrf_field()}}
								<input type="button" class="btn btn-primary pull-right btn-block" value="Registrar datos ingresados" onclick="enviarFrmInsertarAsignacion();">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div id="modalNuevoBien" class="modal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Registro de nuevo bien para asignación</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-md-6">
						<label for="txtDescripcion">Descripción del bien</label>
						<input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" placeholder="Obligatorio">
					</div>
					<div class="form-group col-md-3">
						<label for="txtCodigoPatrimonial">Código patrimonial</label>
						<input type="text" id="txtCodigoPatrimonial" name="txtCodigoPatrimonial" class="form-control">
					</div>
					<div class="form-group col-md-3">
						<label for="txtCodigoInterno">Código interno</label>
						<input type="text" id="txtCodigoInterno" name="txtCodigoInterno" class="form-control">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-3">
						<label for="txtCodigoM">Código M</label>
						<input type="text" id="txtCodigoM" name="txtCodigoM" class="form-control">
					</div>
					<div class="form-group col-md-3">
						<label for="txtSerie">Serie</label>
						<input type="text" id="txtSerie" name="txtSerie" class="form-control">
					</div>
					<div class="form-group col-md-3">
						<label for="txtMarca">Marca</label>
						<input type="text" id="txtMarca" name="txtMarca" class="form-control">
					</div>
					<div class="form-group col-md-3">
						<label for="txtModelo">Modelo</label>
						<input type="text" id="txtModelo" name="txtModelo" class="form-control">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-3">
						<label for="txtTipo">Tipo</label>
						<input type="text" id="txtTipo" name="txtTipo" class="form-control">
					</div>
					<div class="form-group col-md-3">
						<label for="txtColor">Color</label>
						<input type="text" id="txtColor" name="txtColor" class="form-control">
					</div>
					<div class="form-group col-md-3">
						<label for="txtObservacion">Observación</label>
						<input type="text" id="txtObservacion" name="txtObservacion" class="form-control">
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
						<input type="button" class="btn btn-default pull-left" value="Cerrar ventana" onclick="$('#modalNuevoBien').modal('hide');">
						<input type="button" class="btn btn-primary pull-right" value="Agregar bien" onclick="agregarNuevoBien();">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(function()
	{
		$('#modalNuevoBien').formValidation(
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

		$('#selectBien').select2(
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
			allowClear: true,
			placeholder: 'Buscar bien...',
			minimumInputLength: 3,
			ajax:
			{
				url: '{{url('bien/jsonparaasignacion')}}',
				method: 'POST',
				dataType: 'json',
				delay: 300,
				data: function(params)
				{
					return {
						q: params.term,
						_token: '{{csrf_token()}}'
					};
				},
				processResults: function(data, params)
				{
					dataSelectBien=data.items;

					var searchTerm=$('#selectBien').data('select2').$dropdown.find('input').val();

					if(data.items.length==1 && (data.items[0].row.codigoPatrimonial==searchTerm || data.items[0].row.codigoInterno==searchTerm || data.items[0].row.codigoM==searchTerm || data.items[0].row.serie==searchTerm))
					{
						$('#selectBien').append($('<option/>')
							.attr('value', data.items[0].id)
							.html(data.items[0].text)
						).val(data.items[0].id).trigger('change').select2('close');
					}

					return {
						results: data.items
					};
				},
				cache: false
			},
			escapeMarkup : function(markup)
			{
				return markup;
			},
			templateResult : formatRepo,
			templateSelection : formatRepoSelection
		});
	});

	function limpiarDatosPersonal()
	{
		$('#txtDniPersonal').val(null);
		$('#hdCodigoPersonal').val(null);
		$('#txtNombreCompletoPersonal').val(null);
		$('#txtNombreDependencia').val(null);
		$('#txtNombreArea').val(null);
		$('#txtNombreCargo').val(null);
	}

	function onKeyUpTxtDniPersonal()
	{
		var evt=event || window.event;

		var code=evt.charCode || evt.keyCode || evt.which;

		if(code==13)
		{
			paginaAjaxJSON({ _token: '{{csrf_token()}}', dni: $('#txtDniPersonal').val() }, '{{url('personal/jsonpordni')}}', 'POST', null, function(objectJson)
			{
				limpiarDatosPersonal();

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

				$('#txtDniPersonal').val(objectJson.tPersonal.dni);
				$('#hdCodigoPersonal').val(objectJson.tPersonal.codigoPersonal);
				$('#txtNombreCompletoPersonal').val(objectJson.tPersonal.nombre+' '+objectJson.tPersonal.apellido);
				$('#txtNombreDependencia').val(objectJson.tPersonal.tdependencia.nombre);
				$('#txtNombreArea').val(objectJson.tPersonal.tarea.nombre);
				$('#txtNombreCargo').val(objectJson.tPersonal.tcargo.nombre);
			}, false, true);
		}
	}

	var dataSelectBien=[];

	function formatRepo(repo)
	{
		if(repo.loading)
		{
			return repo.text;
		}

		var indexTemp=null;

		$(dataSelectBien).each(function(index, element)
		{
			if(element.row.codigoBien==repo.id)
			{
				indexTemp=index;

				return false;
			}
		});

		var markup=`<div class="select2-result-repository clearfix">
			<table style="width: 100%;">
				<tbody>
					<tr>
						<td style="border: 1px dotted #594444;padding: 4px;width: 30px;text-align: center;"><span class="fa fa-cube"></span></td>
						<td style="border: 1px dotted #594444;padding: 4px;">
							<small><b>Actualmente asignado a:</b> `+(dataSelectBien[indexTemp].row.tasignaciondetalle.length ? (dataSelectBien[indexTemp].row.tasignaciondetalle[0].tasignacion.tpersonal.nombre+' '+dataSelectBien[indexTemp].row.tasignaciondetalle[0].tasignacion.tpersonal.apellido) : '---')+`</small>
							<div>`+dataSelectBien[indexTemp].row.descripcion.viiInjectionEscape()+`</div>
							<div><b>Estado:</b> `+dataSelectBien[indexTemp].row.estado+`</div>
						</td>
						<td style="border: 1px dotted #594444;padding: 4px;width: 300px;">
							<div><b>Código patrimonial:</b> `+(dataSelectBien[indexTemp].row.codigoPatrimonial!='' ? dataSelectBien[indexTemp].row.codigoPatrimonial : '---')+`</div>
							<div><b>Código interno:</b> `+(dataSelectBien[indexTemp].row.codigoInterno!='' ? dataSelectBien[indexTemp].row.codigoInterno : '---')+`</div>
							<div><b>Código M:</b> `+(dataSelectBien[indexTemp].row.codigoM!='' ? dataSelectBien[indexTemp].row.codigoM : '---')+`</div>
						</td>
						<td style="border: 1px dotted #594444;padding: 4px;width: 300px;">
							<div><b>Serie:</b> `+(dataSelectBien[indexTemp].row.serie!='' ? dataSelectBien[indexTemp].row.serie : '---')+`</div>
							<div><b>Marca:</b> `+(dataSelectBien[indexTemp].row.marca!='' ? dataSelectBien[indexTemp].row.marca : '---')+`</div>
							<div><b>Modelo:</b> `+(dataSelectBien[indexTemp].row.modelo!='' ? dataSelectBien[indexTemp].row.modelo : '---')+`</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>`;

		return markup;
	}

	function formatRepoSelection(repo)
	{
		return repo.text;
	}

	function removerBien(component)
	{
		$(component).parent().parent().remove();
	}

	function onChangeSelectBien()
	{
		if($('#selectBien').val()==null || $('#selectBien').val()=='')
		{
			return;
		}

		var codigoBienTemp=$('#selectBien').val();
		var indexTemp=null;

		$(dataSelectBien).each(function(index, element)
		{
			if(element.row.codigoBien==codigoBienTemp)
			{
				indexTemp=index;

				return false;
			}
		});

		var existeAsignacion=false;

		$('#tableBienAsignado > tbody > tr').each(function(index, element)
		{
			if(
				$($(element).find('input[name="hdCodigoBien[]"]')[0]).val()==dataSelectBien[indexTemp].row.codigoBien
				|| ($($(element).find('input[name="hdCodigoPatrimonial[]"]')[0]).val().trim()!='' && $($(element).find('input[name="hdCodigoPatrimonial[]"]')[0]).val().trim()==dataSelectBien[indexTemp].row.codigoPatrimonial.trim())
				|| ($($(element).find('input[name="hdCodigoInterno[]"]')[0]).val().trim()!='' && $($(element).find('input[name="hdCodigoInterno[]"]')[0]).val().trim()==dataSelectBien[indexTemp].row.codigoInterno.trim())
				|| ($($(element).find('input[name="hdCodigoM[]"]')[0]).val().trim()!='' && $($(element).find('input[name="hdCodigoM[]"]')[0]).val().trim()==dataSelectBien[indexTemp].row.codigoM.trim())
				|| ($($(element).find('input[name="hdSerie[]"]')[0]).val().trim()!='' && $($(element).find('input[name="hdSerie[]"]')[0]).val().trim()==dataSelectBien[indexTemp].row.serie.trim())
			)
			{
				existeAsignacion=true;

				return false;
			}
		});

		if(existeAsignacion)
		{
			notaError('Error!', 'El bien ya se encuentra asignado.');

			return false;
		}

		var htmlTemp=`<tr>
			<td style="display: none">
				<input type="hidden" name="hdCodigoBien[]" value="`+dataSelectBien[indexTemp].row.codigoBien+`">
				<input type="hidden" name="hdCodigoPatrimonial[]" value="`+dataSelectBien[indexTemp].row.codigoPatrimonial+`">
				<input type="hidden" name="hdCodigoInterno[]" value="`+dataSelectBien[indexTemp].row.codigoInterno+`">
				<input type="hidden" name="hdCodigoM[]" value="`+dataSelectBien[indexTemp].row.codigoM+`">
				<input type="hidden" name="hdSerie[]" value="`+dataSelectBien[indexTemp].row.serie+`">
				
				<input type="hidden" name="hdDescripcion[]">
				<input type="hidden" name="hdMarca[]">
				<input type="hidden" name="hdModelo[]">
				<input type="hidden" name="hdTipo[]">
				<input type="hidden" name="hdColor[]">
				<input type="hidden" name="hdObservacion[]">
				<input type="hidden" name="hdEstado[]">
			</td>
			<td>
				<div>`+dataSelectBien[indexTemp].row.descripcion.viiInjectionEscape()+`</div>
				<small style="color: #999999;">`+dataSelectBien[indexTemp].row.observacion.viiInjectionEscape()+`</small>
			</td>
			<td class="text-center">`+(dataSelectBien[indexTemp].row.codigoPatrimonial!='' ? dataSelectBien[indexTemp].row.codigoPatrimonial.viiInjectionEscape() : '---')+`</td>
			<td class="text-center">`+(dataSelectBien[indexTemp].row.codigoInterno!='' ? dataSelectBien[indexTemp].row.codigoInterno.viiInjectionEscape() : '---')+`</td>
			<td class="text-center">`+(dataSelectBien[indexTemp].row.codigoM!='' ? dataSelectBien[indexTemp].row.codigoM.viiInjectionEscape() : '---')+`</td>
			<td class="text-center">`+(dataSelectBien[indexTemp].row.serie!='' ? dataSelectBien[indexTemp].row.serie.viiInjectionEscape() : '---')+`</td>
			<td class="text-center">`+(dataSelectBien[indexTemp].row.marca!='' ? dataSelectBien[indexTemp].row.marca.viiInjectionEscape() : '---')+`</td>
			<td class="text-center">`+(dataSelectBien[indexTemp].row.modelo!='' ? dataSelectBien[indexTemp].row.modelo.viiInjectionEscape() : '---')+`</td>
			<td class="text-center">`+(dataSelectBien[indexTemp].row.tipo!='' ? dataSelectBien[indexTemp].row.tipo.viiInjectionEscape() : '---')+`</td>
			<td class="text-center">`+(dataSelectBien[indexTemp].row.color!='' ? dataSelectBien[indexTemp].row.color.viiInjectionEscape() : '---')+`</td>
			<td class="text-center">`+dataSelectBien[indexTemp].row.estado+`</td>
			<td class="text-right"><span class="btn btn-default btn-xs glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="left" title="Quitar" onclick="removerBien(this);"><span></td>
		</tr>`;

		$('#tableBienAsignado').append(htmlTemp);

		$('#selectBien').val(null).trigger('change');

		window.setTimeout(function()
		{
			$('#selectBien').select2('open');
		}, 50);

		$('[data-toggle="tooltip"]').tooltip();

		notaOperacionCorrecta();
	}

	function agregarNuevoBien()
	{
		var isValid=null;

		$('#modalNuevoBien').data('formValidation').resetForm();
		$('#modalNuevoBien').data('formValidation').validate();

		isValid=$('#modalNuevoBien').data('formValidation').isValid();

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

		var existeAsignacion=false;

		$('#tableBienAsignado > tbody > tr').each(function(index, element)
		{
			if(
				($($(element).find('input[name="hdCodigoPatrimonial[]"]')[0]).val().trim()!='' && $($(element).find('input[name="hdCodigoPatrimonial[]"]')[0]).val().trim()==$('#txtCodigoPatrimonial').val().trim().viiInjectionEscape())
				|| ($($(element).find('input[name="hdCodigoInterno[]"]')[0]).val().trim()!='' && $($(element).find('input[name="hdCodigoInterno[]"]')[0]).val().trim()==$('#txtCodigoInterno').val().trim().viiInjectionEscape())
				|| ($($(element).find('input[name="hdCodigoM[]"]')[0]).val().trim()!='' && $($(element).find('input[name="hdCodigoM[]"]')[0]).val().trim()==$('#txtCodigoM').val().trim().viiInjectionEscape())
				|| ($($(element).find('input[name="hdSerie[]"]')[0]).val().trim()!='' && $($(element).find('input[name="hdSerie[]"]')[0]).val().trim()==$('#txtSerie').val().trim().viiInjectionEscape())
			)
			{
				existeAsignacion=true;

				return false;
			}
		});

		if(existeAsignacion)
		{
			notaError('Error!', 'El bien ya se encuentra asignado.');

			return false;
		}

		var htmlTemp=`<tr>
			<td style="display: none">
				<input type="hidden" name="hdCodigoBien[]">
				<input type="hidden" name="hdDescripcion[]" value="`+$('#txtDescripcion').val().trim().viiInjectionEscape()+`">
				<input type="hidden" name="hdCodigoPatrimonial[]" value="`+$('#txtCodigoPatrimonial').val().trim().viiInjectionEscape()+`">
				<input type="hidden" name="hdCodigoInterno[]" value="`+$('#txtCodigoInterno').val().trim().viiInjectionEscape()+`">
				<input type="hidden" name="hdCodigoM[]" value="`+$('#txtCodigoM').val().trim().viiInjectionEscape()+`">
				<input type="hidden" name="hdSerie[]" value="`+$('#txtSerie').val().trim().viiInjectionEscape()+`">
				<input type="hidden" name="hdMarca[]" value="`+$('#txtMarca').val().trim().viiInjectionEscape()+`">
				<input type="hidden" name="hdModelo[]" value="`+$('#txtModelo').val().trim().viiInjectionEscape()+`">
				<input type="hidden" name="hdTipo[]" value="`+$('#txtTipo').val().trim().viiInjectionEscape()+`">
				<input type="hidden" name="hdColor[]" value="`+$('#txtColor').val().trim().viiInjectionEscape()+`">
				<input type="hidden" name="hdObservacion[]" value="`+$('#txtObservacion').val().trim().viiInjectionEscape()+`">
				<input type="hidden" name="hdEstado[]" value="`+$('#selectEstado').val().trim().viiInjectionEscape()+`">
			</td>
			<td>
				<div>`+$('#txtDescripcion').val().trim().viiInjectionEscape()+`</div>
				<small style="color: #999999;">`+$('#txtObservacion').val().trim().viiInjectionEscape()+`</small>
			</td>
			<td class="text-center">`+$('#txtCodigoPatrimonial').val().trim().viiInjectionEscape()+`</td>
			<td class="text-center">`+$('#txtCodigoInterno').val().trim().viiInjectionEscape()+`</td>
			<td class="text-center">`+$('#txtCodigoM').val().trim().viiInjectionEscape()+`</td>
			<td class="text-center">`+($('#txtSerie').val().trim()!='' ? $('#txtSerie').val().trim().viiInjectionEscape() : '---')+`</td>
			<td class="text-center">`+($('#txtMarca').val().trim()!='' ? $('#txtMarca').val().trim().viiInjectionEscape() : '---')+`</td>
			<td class="text-center">`+($('#txtModelo').val().trim()!='' ? $('#txtModelo').val().trim().viiInjectionEscape() : '---')+`</td>
			<td class="text-center">`+($('#txtTipo').val().trim()!='' ? $('#txtTipo').val().trim().viiInjectionEscape() : '---')+`</td>
			<td class="text-center">`+($('#txtColor').val().trim()!='' ? $('#txtColor').val().trim().viiInjectionEscape() : '---')+`</td>
			<td class="text-center">`+$('#selectEstado').val().trim()+`</td>
			<td class="text-right"><span class="btn btn-default btn-xs glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="left" title="Quitar" onclick="removerBien(this);"><span></td>
		</tr>`;

		$('#tableBienAsignado').append(htmlTemp);

		$('[data-toggle="tooltip"]').tooltip();

		$('#txtDescripcion').val(null);
		$('#txtCodigoPatrimonial').val(null);
		$('#txtCodigoInterno').val(null);
		$('#txtCodigoM').val(null);
		$('#txtSerie').val(null);
		$('#txtMarca').val(null);
		$('#txtModelo').val(null);
		$('#txtTipo').val(null);
		$('#txtColor').val(null);
		$('#txtObservacion').val(null);
		$('#selectEstado').val('').trigger('change');

		$('#modalNuevoBien').data('formValidation').resetForm();

		notaOperacionCorrecta();
	}

	function enviarFrmInsertarAsignacion()
	{
		if($('#hdCodigoPersonal').val().trim()=='' || !$('#tableBienAsignado > tbody > tr').length)
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
				paginaAjaxJSON($('#frmInsertarAsignacion').serialize(), '{{url('asignacion/insertar')}}', 'POST', null, function(objectJson)
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

					limpiarDatosPersonal();
					$('#tableBienAsignado > tbody').html(null);

					window.open('{{url('asignacion/hojaentregapdf')}}'+'/'+objectJson.codigoAsignacion, '_blank');

					swal(
					{
						title : 'Correcto',
						text : objectJson.mensajeGlobal,
						icon : 'success',
						timer: '2000'
					});
				}, false, true);
			}
		});
	}
</script>
@endsection