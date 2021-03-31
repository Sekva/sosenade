@extends('layouts.app')
@section('titulo','Cadastrar Disciplinas')
@section('content')

	<form class="shadow p-3 bg-white rounded" action="{{route('add_disciplina')}}" method="post">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		
		<h1 class="text-center"> Cadastrar Disciplina/Conteúdo </h1>
		<h2 class="text-center">
			@if (Auth::guard('aluno')->user())
				{{Auth::guard('aluno')->user()->curso->curso_nome}}
			@elseif (Auth::user())
				{{Auth::user()->curso->curso_nome}}
			@endif
		</h2><br>
		
		<div class="form-group justify-content-center row">
			<div class="col-md-6">
				<input type="text" name="nome" id="nome" placeholder="Digite o nome da disciplina/conteúdo aqui" class="form-control{{ $errors->has('nome') ? ' is-invalid' : '' }}" value="{{ old('nome') }}" required autofocus>
					@if ($errors->has('nome'))
						<span class = "invalid-feedback" role="alert">
							<strong>{{$errors->first('nome')}}</strong>
						</span>
					@endif
			</div> 
		</div>

		<div class="col-md-12 text-center">
			<br><button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button><br><br>
		</div>
	</form>
@stop