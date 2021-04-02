<nav class="navbar navbar-dark navbar-expand-lg" style="background-color: #1B2E4F; border-color: #d3e0e9" role="navigation">
	<div class="container">
		<a class="navbar-brand" href="{{(Auth::guard('aluno')->user() == null) ? route('home') : route('home_aluno')}}">Início</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<!-- Left Side Of Navbar -->
			<ul class="navbar-nav mr-auto">
				@can('create', Auth::user()) 
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Cursos
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{route('new_curso')}}">Cadastrar</a>
							<a class="dropdown-item" href="{{route('list_curso')}}">Listar</a>
						</div>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Usuários
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{route('new_usuario')}}">Cadastrar</a>
							<a class="dropdown-item" href="{{route('list_usuario')}}">Listar</a>
						</div>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Ciclos
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{route('new_ciclo')}}">Cadastrar</a>
							<a class="dropdown-item" href="{{route('list_ciclo')}}">Listar</a>
						</div>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="{{route('geral_cursos')}}" role="button" aria-haspopup="true" aria-expanded="false">
							Visão Geral do Sistema
						</a>
					</li>
				@endcan

				@can('view_coordenador', Auth::user())
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Alunos
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{route('new_aluno')}}">Cadastrar</a>
							<a class="dropdown-item" href="{{route('list_aluno')}}">Listar</a>
						</div>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Professores
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{route('new_professor')}}">Cadastrar</a>
							<a class="dropdown-item" href="{{route('list_professor')}}">Listar</a>
						</div>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Disciplinas
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{route('new_disciplina')}}">Cadastrar</a>
							<a class="dropdown-item" href="{{route('list_disciplina')}}">Listar</a>
						</div>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Questões
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{route('new_qst')}}">Cadastrar</a>
							<a class="dropdown-item" href="{{route('list_qst')}}">Listar</a>
							<a class="dropdown-item" href="{{route('import_qst')}}">Importar Questões</a>
						</div>
					</li>
					
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Simulados
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{route('new_simulado')}}">Cadastrar</a>
							<a class="dropdown-item" href="{{route('list_simulado')}}">Listar</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{route('desempenho_alunos')}}">Desempenho por Aluno</a>
							<a class="dropdown-item" href="{{route('relatorio_disciplinas')}}">Desempenho por Disciplinas</a>
							<a class="dropdown-item" href="{{route('qst_por_disciplina')}}">Desempenho por Questões</a>
							<a class="dropdown-item" href="{{route('relatorio_simulados')}}">Desempenho por Simulado</a>
						</div>
					</li>
				@endcan

				@can('view_professor', Auth::user())
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Questões
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{route('new_qst')}}">Cadastrar</a>
							<a class="dropdown-item" href="{{route('list_qst')}}">Listar</a>
						</div>
					</li>
				@endcan


				@can('view_coordenadorGeral', Auth::user())
					<li class="nav-item">
						<a class="nav-link" href="{{route('geral_cursosCG')}}" role="button" aria-haspopup="true" aria-expanded="false">
							Visão Geral do Sistema
						</a>
					</li>
				@endcan

				@if(Auth::guard('aluno')->check())
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Simulados
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{route('list_simulado_aluno')}}">Lista de Simulados</a>		  
						</div>
					</li>
				@endif
			</ul>

			<!-- Right Side Of Navbar -->
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown" style="list-style-type: none">
					<a id="navbarDropdown" class="nav-link dropdown-toggle font-weight-bold" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						@if (Auth::guard('aluno')->user())
							{{Auth::guard('aluno')->user()->nome}} (Aluno) - {{Auth::guard('aluno')->user()->curso->curso_nome}}
						@elseif ((Auth::user()->tipousuario->id == 5))
							{{Auth::user()->nome}} ({{Auth::user()->tipousuario->tipo}}) - {{Auth::user()->curso->unidade->nome}}
						@elseif (Auth::user() && !(Auth::user()->tipousuario->id == 4))
							{{Auth::user()->nome}} ({{Auth::user()->tipousuario->tipo}}) - {{Auth::user()->curso->curso_nome}}

						@else
							{{Auth::user()->nome}} ({{Auth::user()->tipousuario->tipo}})
						@endif
						<span class="caret"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="{{(Auth::guard('aluno')->user()) ? route('edit_perfil_aluno') : route('edit_usuario', ['id' => Auth::user()->id])}}">
							Meu Perfil
						</a>
						<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							{{ __('Logout') }}
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>