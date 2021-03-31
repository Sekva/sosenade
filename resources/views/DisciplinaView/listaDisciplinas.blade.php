@extends('layouts.app')
@section('titulo','Disciplinas Cadastradas')
@section('content')

    <div class="shadow p-3 bg-white" style="border-radius: 10px">
        <div class="row"
             style="background: #1B2E4F; margin-top: -15px; margin-bottom:  30px; border-radius: 10px 10px 0 0; color: white">
            <div class="col-sm">
                <h1 style="margin-left: 15px; margin-top: 15px">Disciplinas/Conteúdos Cadastrados</h1>
                <p style="color: #606f7b; margin-left: 15px; margin-top: -5px">
                    <a href="{{route('home')}}" style="color: inherit;">Inicio</a> >
                    Questões Cadastradas
                </p>
            </div>

            <div class="col-sm-3" style="margin-top: 30px; margin-right: 20px">
                <a class="btn btn-primary" href="{{route('new_disciplina')}}" style="float: right;"> Cadastrar
                    Disciplina</a><br>
            </div>
            {{-- <p><a href="">Inicio</a> > <a href="">Olá, fulano</a> > <a href=""></a>Meu Perfil</p> --}}
        </div>
        @if(!$disciplinas->isEmpty())
            <table class="table table-hover" id="tabela_dados" style="border-style: groove; border-color: #6cb2eb">
                <thead>
                <tr class="header" style="background: #1B2E4F; color: white">
                    <th>Nome</th>
                    <th style="width: 20%">Opções</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($disciplinas as $disciplina)
                    <tr>
                        <td style="">{{$disciplina->nome}}</td>
                        <td>
                            <a href="{{route('list_qst_disciplina', ['id'=>$disciplina->id])}}" class="btn btn-info"
                               data-placement="bottom" rel="tooltip" title="Ver questões"><i class="fa fa-eye"></i></a>
                            <a href="{{route('edit_disciplina',['id'=>$disciplina->id])}}" class="btn btn-primary"
                               data-placement="bottom" rel="tooltip" title="Editar"><i class="fa fa-pencil"></i></a>
                            <a onclick="return confirm('Você tem certeza que deseja excluir?')"
                               href="{{route('delete_disciplina',['id'=>$disciplina->id])}}" class="btn btn-danger"
                               data-placement="bottom" rel="tooltip" title="Excluir"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center alert alert-light">Não existem disciplinas cadastradas até o momento.</p>
        @endif

        <hr>

        <p>Legenda:</p>
        <a class="icons btn btn-info"
           data-placement="bottom" rel="tooltip" title="Visualizar" style="color: white"><i class="fa fa-eye"></i></a>
        Abrir Disciplina
        <a class="btn btn-primary"
           data-placement="bottom" rel="tooltip" title="Editar" style="color: white; margin-left: 5px"><i
                class="fa fa-pencil"></i></a>
        Editar Disciplina
        <a class="btn btn-danger"
           data-placement="bottom" rel="tooltip" title="Excluir" style="color: white; margin-left: 5px"><i
                class="fa fa-trash"></i></a>
        Deletar Disciplina
    </div>

    <script type="text/javascript">
        $('[rel="tooltip"]').tooltip();
    </script>

@stop
