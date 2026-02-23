<!DOCTYPE html>
<html lang="en">
<head>
	<title>System</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/fonts/iconic/css/material-design-iconic-font.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/vendor/animate/animate.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/vendor/css-hamburgers/hamburgers.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/vendor/animsition/css/animsition.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/vendor/select2/select2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/vendor/daterangepicker/daterangepicker.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/css/main.css')}}">

	<link rel="stylesheet" href="{{asset('plugin/pnotify/pnotify.custom.min.css')}}">

	<style>
		body
		{
			background-image: url('{{url('img/backgroundLogin.jpg')}}');
			background-size: 100% auto;
		}

		.login100-form-bgbtn
		{
			background: -webkit-linear-gradient(right, #424a4c, #504754, #848484, #2e2a2f);
		}

		.ui-pnotify-text
		{
			font-size: 13px;
		}
		
		.ui-pnotify-title
		{
			font-size: 18px;
		}

		.wrap-login100
		{
			background-color: #333333;
		}
	</style>

	<script src="{{url('plugin/logintemplate/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('plugin/pnotify/pnotify.custom.min.js')}}"></script>
</head>
<body>
	@if(Session::has('mensajeGlobal'))
		<script>
			$(function()
			{
				@foreach(explode('__SALTOLINEA__', Session::get('mensajeGlobal')) as $value)
					@if(trim($value)!='')
						new PNotify(
						{
							title : '{{Session::get('tipo')=='error' ? 'No se pudo proceder' : (Session::get('tipo')=='success' ? 'Correcto' : 'Advertencia')}}',
							text : '{{$value}}',
							type : '{{Session::get('tipo')}}'
						});
					@endif
				@endforeach
			});
		</script>
	@endif
	<div class="limiter">
		<div class="container-login100" style="background-color: transparent;">
			<div class="wrap-login100" style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.7);">
				<form class="login100-form validate-form" action="{{url('usuario/login')}}" method="post">
					<span class="login100-form-title p-b-26" style="color: #ffffff;">
						{{($tConfiguracionFm!=null ? $tConfiguracionFm->tituloSistema : 'System')}}
					</span>
					<span class="login100-form-title p-b-48">
						<img src="{{asset('img/logo/logoSistema.'.($tConfiguracionFm!=null ? $tConfiguracionFm->extensionLogoSistema : '').'?x='.str_replace(' ', '_', str_replace(':', '-', ($tConfiguracionFm!=null ? $tConfiguracionFm->updated_at : ''))))}}" style="background-color: #ffffff;box-shadow: 0px 0px 5px white;width: 77px;">
					</span>
					<div class="wrap-input100">
						<input type="text" id="txtCorreoElectronico" name="txtCorreoElectronico" class="input100" style="color: #ffffff;">
						<span class="focus-input100" data-placeholder="Correo electrónico o usuario"></span>
					</div>
					<div class="wrap-input100">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input type="password" id="passContrasenia" name="passContrasenia" class="input100" style="color: #ffffff;">
						<span class="focus-input100" data-placeholder="Contraseña"></span>
					</div>
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Acceder
							</button>
						</div>
					</div>
					<div class="text-center p-t-115">
						<span class="txt1" style="color: #cccccc;">
							Si olvidaste tu contraseña, comunícate con el área de informática del Poder Judicial de Apurímac.
						</span>
					</div>
					<div class="form-group has-feedback text-left" style="display: none;">
						<select id="selectCodigoOficina" name="selectCodigoOficina" class="selectStatic" style="width: 100%;">
							@foreach($listaTOficina as $value)
								<option value="{{$value->codigoOficina}}">{{$value->nombre}}</option>
							@endforeach
						</select>
					</div>
					{{csrf_field()}}
				</form>
			</div>
		</div>
	</div>
	<script src="{{url('plugin/logintemplate/vendor/animsition/js/animsition.min.js')}}"></script>
	<script src="{{url('plugin/logintemplate/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{url('plugin/logintemplate/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{url('plugin/logintemplate/vendor/select2/select2.min.js')}}"></script>
	<script src="{{url('plugin/logintemplate/vendor/daterangepicker/moment.min.js')}}"></script>
	<script src="{{url('plugin/logintemplate/vendor/daterangepicker/daterangepicker.js')}}"></script>
	<script src="{{url('plugin/logintemplate/vendor/countdowntime/countdowntime.js')}}"></script>
	<script src="{{url('plugin/logintemplate/js/main.js')}}"></script>
	<script>
		$(function()
		{
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
		});
	</script>
</body>
</html>