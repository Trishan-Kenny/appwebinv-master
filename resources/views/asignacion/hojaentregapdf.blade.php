<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>

	<style>
		.table
		{
			font-size: 12px;
			width: 100%;
		}

		.table > tbody > tr > td
		{
			border: 1px solid #000000;
			padding: 4px;
		}

		.tableBien
		{
			border-collapse: collapse;
			font-size: 12px;
			width: 100%;
		}

		.tableBien > tbody > tr > td
		{
			border: 1px dotted #999999;
			padding: 4px;
		}

		.tableBien > thead > tr > th
		{
			border: 1px solid #000000;
			padding: 4px;
			padding-bottom: 10px;
			padding-top: 10px;
		}
	</style>
</head>
<body>
	<table style="width: 100%;">
		<tbody>
			<tr>
				<td style="text-align: left;width: 55px;"><img src="{{asset('img/logo/logoSistema.png')}}" alt="" style="width: 50px;"></td>
				<td style="color: #999999;font-size: 13px;width: 210px;">
					<div style="font-weight: bold;">PODER JUDICIAL DEL PERÚ</div>
					<small>Justicia honorable, país responsable</small>
				</td>
				<td>
					<h3 style="margin: 0px;">INVENTARIO DE BIENES DEL PODER JUDICIAL</h3>
					<h3 style="margin: 0px;">(HOJA DE ENTREGA DE BIENES)</h3>
				</td>
				<td style="text-align: right;width: 90px;">
					<div>Generado el:</div>
					<div>Cod. Asig.:</div>
				</td>
				<td style="text-align: right;width: 150px;">
					<div>{{date('Y-m-d H:i:s')}}</div>
					<div>{{$tAsignacion->codigoAsignacion}}</div>
				</td>
			</tr>
		</tbody>
	</table>
	<hr>
	<table class="table">
		<tbody>
			<tr>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">Sede:</td>
				<td style="width: 30%;" colspan="3">Corte Superior de Justicia de Apurímac</td>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">Ap./Nombre:</td>
				<td style="width: 30%;" colspan="3">{{$tAsignacion->tpersonal->apellido.', '.$tAsignacion->tpersonal->nombre}}</td>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">DNI:</td>
				<td style="width: 10%;">{{$tAsignacion->tpersonal->dni}}</td>
			</tr>
			<tr>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">Departamento:</td>
				<td style="width: 10%;">Apurímac</td>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">Provincia:</td>
				<td style="width: 10%;">{{$tAsignacion->tpersonal->tdependencia->tlocal->tdistrito->tprovincia->nombre}}</td>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">Cargo:</td>
				<td style="width: 20%;" colspan="2">{{$tAsignacion->tpersonal->tcargo->nombre}}</td>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">Dependencia:</td>
				<td style="width: 20%;" colspan="2">{{$tAsignacion->tpersonal->tdependencia->nombre}}</td>
			</tr>
			<tr>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">Distrito:</td>
				<td style="width: 30%;" colspan="3">{{$tAsignacion->tpersonal->tdependencia->tlocal->tdistrito->nombre}}</td>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">Área interna:</td>
				<td style="width: 20%;" colspan="2">{{$tAsignacion->tpersonal->tarea->nombre}}</td>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">Situación:</td>
				<td style="width: 20%;" colspan="2">{{$tAsignacion->tpersonal->tsituacion->nombre}}</td>
			</tr>
			<tr>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">Dirección:</td>
				<td style="width: 30%;" colspan="3">{{$tAsignacion->tpersonal->tdependencia->tlocal->direccion}}</td>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">Grupo de trab.:</td>
				<td style="width: 20%;" colspan="2">DJ03_CSJAP</td>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">Func. q' cumple:</td>
				<td style="width: 20%;" colspan="2">{{$tAsignacion->descripcion}}</td>
			</tr>
			<tr>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">Local:</td>
				<td style="width: 30%;" colspan="3">{{$tAsignacion->tpersonal->tdependencia->tlocal->nombre}}</td>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">Us. que asignó:</td>
				<td style="width: 30%;" colspan="3">{{$tAsignacion->tusuario->apellido.', '.$tAsignacion->tusuario->nombre}}</td>
				<td style="background-color: #f5f5f5;font-weight: bold;width: 10%;">DNI Us. que asi.:</td>
				<td style="width: 10%;">{{$tAsignacion->tusuario->dni}}</td>
			</tr>
		</tbody>
	</table>
	<hr>
	<table class="tableBien" style="font-size: 11px;width: 1031px;">
		<thead>
			<tr>
				<th>Nº</th>
				<th style="text-align: left;">Denominación del bien</th>
				<th>Cód. pat.</th>
				<th>Cód. int.</th>
				<th>Cód. M</th>
				<th>Serie</th>
				<th>Marca</th>
				<th>Modelo</th>
				<th>Tipo</th>
				<th>Color</th>
				<th>Estado</th>
				<th>Observación</th>
			</tr>
		</thead>
		<tbody>
			@foreach($tAsignacion->tasignaciondetalle as $key => $value)
				<tr>
					<td style="text-align: center;width: 20px;">{{($key+1)}}</td>
					<td>{{$value->tbien->descripcion}}</td>
					<td style="text-align: center;">{{$value->tbien->codigoPatrimonial!='' ? $value->tbien->codigoPatrimonial : '---'}}</td>
					<td style="text-align: center;">{{$value->tbien->codigoInterno!='' ? $value->tbien->codigoInterno : '---'}}</td>
					<td style="text-align: center;">{{$value->tbien->codigoM!='' ? $value->tbien->codigoM : '---'}}</td>
					<td style="text-align: center;">{{$value->tbien->serie!='' ? $value->tbien->serie : '---'}}</td>
					<td style="text-align: center;">{{$value->tbien->marca!='' ? $value->tbien->marca : '---'}}</td>
					<td style="text-align: center;">{{$value->tbien->modelo!='' ? $value->tbien->modelo : '---'}}</td>
					<td style="text-align: center;">{{$value->tbien->tipo!='' ? $value->tbien->tipo : '---'}}</td>
					<td style="text-align: center;">{{$value->colorBien!='' ? $value->colorBien : '---'}}</td>
					<td style="text-align: center;width: 70px;">{{$value->estadoBien}}</td>
					<td style="text-align: center;">{{$value->observacion!='' ? $value->observacion : '---'}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<table style="margin-top: 70px;width: 100%">
		<tbody>
			<tr>
				<td style="text-align: center;widht: 50%;">
					______________________________
					<div>Administrador distrital</div>
				</td>
				<td style="text-align: center;widht: 50%;">
					______________________________
					<div>Personal responsable</div>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>