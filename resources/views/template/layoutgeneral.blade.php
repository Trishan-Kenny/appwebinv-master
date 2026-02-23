<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{($tConfiguracionFm!=null ? $tConfiguracionFm->tituloSistema : 'System')}}</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
	<!-- Select2 -->
	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/select2/dist/css/select2.min.css')}}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('plugin/adminlte/dist/css/AdminLTE.min.css')}}">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
	folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="{{asset('plugin/adminlte/dist/css/skins/_all-skins.min.css')}}">
	<!-- Morris chart -->
	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/morris.js/morris.css')}}">
	<!-- jvectormap -->
	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/jvectormap/jquery-jvectormap.css')}}">
	<!-- Date Picker -->
	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="{{asset('plugin/adminlte/plugins/iCheck/all.css')}}">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="{{asset('plugin/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="{{asset('js/html5shiv.min.js')}}"></script>
	<script src="{{asset('js/respond.min.js')}}"></script>
	<![endif]-->

	<!-- Google Font -->
	<link rel="stylesheet" href="{{asset('css/googlefont.css')}}">

	<link rel="stylesheet" href="{{asset('plugin/pnotify/pnotify.custom.min.css')}}">

	<link rel="stylesheet" href="{{asset('css/cssPaginacion.css')}}">
	<link rel="stylesheet" href="{{asset('css/cssStep.css')}}">
	<link rel="stylesheet" href="{{asset('css/overrideTemplate.css')}}">

	<style>
		h3
		{
			margin-bottom: 4px;
			margin-top: 4px;
		}

		h4
		{
			margin-bottom: 4px;
			margin-top: 4px;
		}

		hr
		{
			margin-bottom: 7px;
			margin-top: 7px;
		}

		textarea
		{
			resize: vertical;
		}

		.btn-xs
		{
			margin: 1px;
		}

		.cursorPointer{ cursor: pointer; }

		.datepicker-dropdown
		{
			z-index: 70000 !important;
		}

		.modal { overflow: auto !important; }

		.table > tbody > tr > td, .table > thead > tr > th
		{
			vertical-align: middle;
		}
	</style>

	<script>
		var _token='{{csrf_token()}}';
		var _sessionCodigoUsuario='{{Session::get('codigoUsuario')}}';
	</script>

	<!-- jQuery 3 -->
	<script src="{{asset('plugin/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="{{asset('plugin/adminlte/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>

	<script src="{{asset('plugin/pnotify/pnotify.custom.min.js')}}"></script>
	<script src="{{asset('plugin/sweetalert/sweetalert.min.js')}}"></script>
	<script src="{{asset('js/jsAjax.js')}}"></script>
	<script src="{{asset('js/jsBuscar.js')}}"></script>
	<script src="{{asset('js/jsHelper.js')}}"></script>
	<script src="{{asset('js/jsStep.js')}}"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<!-- Logo -->
			<a href="{{url('/')}}" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><b>S</b>YS</span>
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg">{{($tConfiguracionFm!=null ? $tConfiguracionFm->tituloSistema : 'System')}}</span>
			</a>
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" onclick="saveCollapseMenu();">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<!--include('template/parcial/parcialnotificacion')-->
						@include('template/parcial/parcialcuentausuario')
						<!-- Control Sidebar Toggle Button -->
						<li>
							<!--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<!-- Sidebar user panel -->
				<div class="user-panel">
					<div class="pull-left image">
						<img src="{{asset('img/logo/logoSistema.'.($tConfiguracionFm!=null ? $tConfiguracionFm->extensionLogoSistema : '').'?x='.str_replace(' ', '_', str_replace(':', '-', ($tConfiguracionFm!=null ? $tConfiguracionFm->updated_at : ''))))}}" class="img-circle" alt="User Image" style="background-color: #ffffff;">
					</div>
					<div class="pull-left info">
						<p>{{Session::get('nombreCompleto', 'Anónimo')}}</p>
						<small>{{Session::get('nombreOficina')}}</small>
					</div>
				</div>
				@include('template/parcial/parcialmenuprincipal')
			</section>
			<!-- /.sidebar -->
		</aside>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					@yield('titulo')
					<small>@yield('subTitulo')</small>
				</h1>
			</section>
			<!-- Main content -->
			<section class="content">
				@if(Session::has('mensajeGlobal'))
					<script>
						$(function()
						{
							@if(Session::get('tipo')=='error')
								@foreach(explode('__SALTOLINEA__', Session::get('mensajeGlobal')) as $value)
									@if(trim($value)!='')
										new PNotify(
										{
											title : 'No se pudo proceder',
											text : '{{$value}}',
											type : '{{Session::get('tipo')}}'
										});
									@endif
								@endforeach
							@else
								swal(
								{
									title : '{{Session::get('tipo')=='success' ? 'Correcto' : 'Alerta'}}',
									text : '{{Session::get('mensajeGlobal')}}',
									icon : '{{Session::get('tipo')=='success' ? 'success' : 'warning'}}',
									timer: {{Session::get('tipo')=='success' ? '2000' : '60000'}}
								});
							@endif
						});
					</script>
				@endif
				<div class="modal" id="modalLoading" data-backdrop="static" data-keyboard="false" style="z-index: 50000;">
		            <div class="modal-dialog">
		                <div class="modal-content">
		                    <div class="modal-header">
		                        <h4 class="modal-title">Cargando datos...</h4>
		                    </div>
		                    <div class="modal-body">
								<div class="progress progress-striped active">
									<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
								</div>
		                    </div>
		                </div>
		            </div>
		        </div>
				<div id="dialogoGeneral"></div>
				<div id="dialogoAuxiliar"></div>
				@yield('cuerpoGeneral')
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Versión</b> 1.0
			</div>
			<strong>Copyright &copy; 2020-{{date('Y')}} <a href="https://www.pj.gob.pe/wps/wcm/connect/cortesuperiorapurimacpj/s_csj_apurimac_nuevo/as_inicio/inicio_corte_apurimac" target="_blank">Corte superior de justicia de Apurímac</a>.</strong> Todo los derechos reservados.
		</footer>
		<!--include('template/parcial/parcialsidebar')-->
	</div>
	<!-- ./wrapper -->
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
		$.widget.bridge('uibutton', $.ui.button);
	</script>
	<!-- Bootstrap 3.3.7 -->
	<script src="{{asset('plugin/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
	<!-- Select2 -->
	<script src="{{asset('plugin/adminlte/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
	<!-- Morris.js charts -->
	<script src="{{asset('plugin/adminlte/bower_components/raphael/raphael.min.js')}}"></script>
	<script src="{{asset('plugin/adminlte/bower_components/morris.js/morris.min.js')}}"></script>
	<!-- Sparkline -->
	<script src="{{asset('plugin/adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
	<!-- jvectormap -->
	<script src="{{asset('plugin/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
	<script src="{{asset('plugin/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
	<!-- jQuery Knob Chart -->
	<script src="{{asset('plugin/adminlte/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
	<!-- daterangepicker -->
	<script src="{{asset('plugin/adminlte/bower_components/moment/min/moment.min.js')}}"></script>
	<script src="{{asset('plugin/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
	<!-- datepicker -->
	<script src="{{asset('plugin/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
	<!-- iCheck 1.0.1 -->
	<script src="{{asset('plugin/adminlte/plugins/iCheck/icheck.min.js')}}"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script src="{{asset('plugin/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
	<!-- Slimscroll -->
	<script src="{{asset('plugin/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	<!-- FastClick -->
	<script src="{{asset('plugin/adminlte/bower_components/fastclick/lib/fastclick.js')}}"></script>
	<!-- AdminLTE App -->
	<script src="{{asset('plugin/adminlte/dist/js/adminlte.min.js')}}"></script>

	<script src="{{asset('plugin/formvalidation/formValidation.min.js')}}"></script>
	<script src="{{asset('plugin/formvalidation/bootstrap.validation.min.js')}}"></script>

	<script>
		$(function()
		{
			$('body').keypress(function(event)
			{
				if(event.keyCode===10 || event.keyCode===13)
				{
					event.preventDefault();
				}
			});

			if(localStorage.getItem('collapseMenu') !== null && localStorage.getItem('collapseMenu') === "true")
			{
				$('body').addClass('sidebar-collapse');
			}

			$('.datePicker').datepicker(
			{
				autoclose : true,
				format : 'yyyy-mm-dd'
			});

			$('[data-toggle="tooltip"]').tooltip();

			$('.select').select2(
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
				placeholder : 'Buscar...',
				minimumInputLength: 3
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

			$('.selectStaticClear').select2(
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
				placeholder : 'Buscar...',
				allowClear : true
			});
		});

		function saveCollapseMenu()
		{
			localStorage.setItem('collapseMenu', !$('body').hasClass('sidebar-collapse'));
		}
	</script>
</body>
</html>