<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div
		style="
			background-color: #eeeeee;
			font-size: 22px;
			padding: 10px;
			text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);">
		<img src="{{config('var.LOGO_SHOW_MAIL')}}" height="50"
			onclick="window.location.href='{{config('var.URL_GENERAL_SHOW')}}';"
			style="
				cursor: pointer;
				display: inline-block;
				vertical-align: middle;">
	</div>
	<h2>Hola {{$nombreReceptor}}</h2>
	{!!$mensajeCorreo!!}
	<hr>
	<b>
		<table>
			<tr>
				<td colspan="2">Atte: Plataforma <a href="{{config('var.URL_GENERAL_SHOW')}}">{{config('var.URL_GENERAL_SHOW')}}</a></td>
			</tr>
			<tr><td colspan="2"><br></td></tr>
			<tr>
				<td colspan="2">Saludos.</td>
			</tr>
		</table>
	</b>
</body>
</html>