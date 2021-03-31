<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Fonts -->
		<link rel="dns-prefetch" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">


        <link href="{{ asset('css/questoes.css') }}" rel="stylesheet">

		@include('includes.head')
		<title>
			@if(!Auth::guard('aluno')->check() && !Auth::guard('instituicao')->check() && !Auth::check())
				Entrar | S.O.S Enade
			@else
				@yield('titulo') | S.O.S Enade
			@endif
		</title>
	</head>

	<body class="position-relative" style="background: #EEE; min-height: 100vh; padding-bottom: 60px">
		<!-- Barra Brasil -->
		<div id="barra-brasil" style="background:#7F7F7F; height: 20px; padding:0 0 0 10px; display:block;">
			<ul id="menu-barra-temp" style="list-style:none;">
				<li style="display:inline; float:left;padding-right:10px; margin-right:10px; border-right:1px solid #EDEDED">
					<a href="http://brasil.gov.br" style="font-family:sans,sans-serif; text-decoration:none; color:white;">Portal do Governo Brasileiro</a>
				</li>
				<li>
					<a style="font-family:sans,sans-serif; text-decoration:none; color:white;" href="http://epwg.governoeletronico.gov.br/barra/atualize.html">Atualize sua Barra de Governo</a>
				</li>
			</ul>
		</div>

		<div id="app">
			<!-- Barra da tela de Login -->
			@if(!Auth::guard('aluno')->check() && !Auth::guard('instituicao')->check() && !Auth::check())
				<nav class="navbar navbar-dark navbar-expand-lg" style="background-color: white; border-color: #d3e0e9;
                 box-shadow: 0px 4px 10px -5px rgba(0,0,0,0.64);
                " role="navigation">
					<div class="container">
						<a href="{{ (Auth::guard('aluno')->user()) ? route('home_aluno') : route('home') }}" style="max-height: 45%; max-width: 45%">
							<img src="{{asset('1.png')}}" style="width: 20%" class="img-fluid float-left">
						</a>

						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
							<span class="navbar-toggler-icon"></span>
						</button>

						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<!-- Left Side Of Navbar -->
							<ul class="navbar-nav mr-auto">

							</ul>



							<!-- Right Side Of Navbar -->
							<ul class="navbar-nav ml-auto">
								<!-- Authentication Links -->
								@guest
                                <div style="display: inline-block; margin-right: 30px">
                                    <a href="/" style="text-decoration: none; color:black;">Início</a>
                                </div>
                                <div style="display: inline-block;">
                                    <a href="" style="text-decoration: none; color:black;">Sobre</a>
                                </div>

								@else
									<li class="nav-item dropdown">
										<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
											{{ Auth::user()->name }} <span class="caret"></span>
										</a>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
											<a class="dropdown-item" href="{{ route('logout') }}"
											   onclick="event.preventDefault();
															 document.getElementById('logout-form').submit();">
												{{ __('Logout') }}
											</a>
											<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
												@csrf
											</form>
										</div>
									</li>
								@endguest
							</ul>
						</div>
					</div>
				</nav>
			@else
				@include('includes.nav_bar')
			@endif
			<main class="py-3">
				<div class="container justify-content-center">
					@yield('content')
				</div>
			</main>
		</div>
	</body>
	@include('includes.footer')
</html>
