@extends('layouts.app')
@section('titulo','Cadastro de Alunos')
@section('content')
    <div class="shadow p-3 bg-white" style="border-radius: 10px; width: 80%; margin-left: auto; margin-right: auto">
        <div class="row"
             style="background: #1B2E4F; margin-top: -15px; margin-bottom:  30px; border-radius: 10px 10px 0 0; color: white">
            <div class="col" align="left">
                <h1 style="margin-left: 15px; margin-top: 15px"> Cadastro de Alunos </h1>
                <p style="color: #606f7b; margin-left: 15px; margin-top: -5px">
                    <a href="{{route('home')}}" style="color: inherit;">Inicio</a> >
                    Cadastrar Aluno
                </p>
            </div>
        </div>
        <div class="card" id="body-tabs">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="cadastrar-tab" data-toggle="tab" href="#cadastrar" role="tab"
                           aria-controls="cadastrar" aria-selected="true">Cadastrar </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="importar-tab" data-toggle="tab" href="#importar" role="tab"
                           aria-controls="importar" aria-selected="false">Importar de arquivo</a>
                    </li>
                </ul>
            </div>
            <br>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="cadastrar" role="tabpanel" aria-labelledby="cadastrar-tab">
                    <div class="list-group list-group-flush">
                        <br>
                        <form action="{{route('add_aluno')}}" method="post">
                            <input type="hidden" name="id" value="-1">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group justify-content-center row" id="cadastrar">
                                <div class="form-group col-md-8">
                                    <label for="nome">Nome Completo</label>
                                    <input type="text" name="nome" id="nome" placeholder="Nome"
                                           class="form-control{{ $errors->has('nome') ? ' is-invalid' : '' }}"
                                           value="{{ old('nome') }}" required autofocus>
                                    @if ($errors->has('nome'))
                                        <span class="invalid-feedback" role="alert">
											{{$errors->first('nome')}}
										</span>
                                    @endif
                                </div>
                                <div class="form-row col-md-12 justify-content-center">
                                    <div class="form-group col-md-4">
                                        <label for="email">E-mail</label>
                                        <input type="text" id="email" name="email" placeholder="exemplo@exemplo.com"
                                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                               value="{{ old('email') }}" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
												{{$errors->first('email')}}
											</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="cpf">CPF</label>
                                        <input type="text" id="cpf" name="cpf" placeholder="xxx.xxx.xxx-xx"
                                               class="form-control{{ $errors->has('cpf') ? ' is-invalid' : '' }} cpf"
                                               value="{{ old('cpf') }}" required autofocus>
                                        @if ($errors->has('cpf'))
                                            <span class="invalid-feedback" role="alert">
												{{$errors->first('cpf')}}
											</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row col-md-12 justify-content-center">
                                    <div class="form-group col-md-4">
                                        <label for="password">Senha</label>
                                        <input type="password" id="password" name="password" placeholder="Senha"
                                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                               value="{{ old('password') }}" required autofocus>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
												{{$errors->first('password')}}
											</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="password_confirmation">Confirmar Senha</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                               placeholder="Confirmar Senha"
                                               class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                               value="{{ old('password_confirmation') }}" required autofocus>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="invalid-feedback" role="alert">
												{{$errors->first('password_confirmation')}}
											</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr style="width: 67%">
                            <div class="row" style="margin-left: 60%; margin-top: -15px">
                                <div class="text-center my-3" id="btn_cadastrar">
                                    <button type="submit" name="cadastrar" class="btn btn-primary" style="width: 200px">Cadastrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="importar" role="tabpanel" aria-labelledby="importar-tab">
                    <div class="list-group list-group-flush">
                        <br>
                        <form method="POST" action="{{ route('import_aluno') }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group justify-content-center row" id="cadastrar">
                                <div class="form-group col-md-8 custom-file">
                                    <input id="csv_file" type="file" class="form-control custom-control-input"
                                           name="csv_file" required>
                                    <label class="custom-file-label" for="csv_file">Escolha o arquivo</label>
                                    @if ($errors->has('csv_file'))
                                        <span class="help-block">
											<strong>{{ $errors->first('csv_file') }}</strong>
										</span>
                                    @endif
                                </div>
                            </div>
                            <hr style="width: 67%; margin-top: 30%">
                            <div class="row" style="margin-left: 60%; margin-top: -15px">
                                <div class="text-center my-3" id="btn_cadastrar">
                                    <button type="submit" name="cadastrar" class="btn btn-primary" style="width: 200px">Importar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style type="text/css">
        .custom-file-label::after {
            content: "Procurar";
        }
    </style>

@stop
