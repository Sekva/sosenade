@extends('layouts.app')
@section('titulo','Editar Ciclo')
@section('content')

    <div class="shadow p-3 bg-white" style="border-radius: 10px; width: 80%; margin-left: auto; margin-right: auto">
        <div class="row"
             style="background: #1B2E4F; margin-top: -15px; margin-bottom:  30px; border-radius: 10px 10px 0 0; color: white">
            <div class="col" align="left">
                <h1 style="margin-left: 15px; margin-top: 15px"> Editar Ciclo </h1>
                <p style="color: #606f7b; margin-left: 15px; margin-top: -5px">
                    <a href="{{route('home')}}" style="color: inherit;">Inicio</a> >
                    Editar Ciclo
                </p>
            </div>
        </div>

        <form action="{{route('update_ciclo')}}" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="id" value="{{$ciclo->id}}">

            <h1 class="text-center"> Editar Ciclo </h1><br><br>

            <div class="form-row justify-content-center row">
                <div class="form-group col-md-6">
                    <label for="tipo_ciclo">Ano do Ciclo:</label>
                    <input type="text" name="tipo_ciclo" id="tipo_ciclo" placeholder="Nome"
                           class="form-control{{ $errors->has('tipo_ciclo') ? ' is-invalid' : '' }}"
                           value="{{$ciclo->tipo_ciclo}}" required autofocus>
                    @if ($errors->has('tipo_ciclo'))
                        <span class="invalid-feedback" role="alert">
			    		{{$errors->first('tipo_ciclo')}}
			    	</span>
                    @endif
                </div>
            </div>

            <hr style="width: 67%">
            <div class="row" style="margin-left: 60%; margin-top: -15px">
                <div class="text-center my-3" id="btn_cadastrar">
                    <button type="submit" name="cadastrar" class="btn btn-primary" style="width: 200px">Salvar Alterações</button>
                </div>
            </div>
        </form>
    </div>
@stop
