<?php

namespace SimuladoENADE\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

use \SimuladoENADE\Mail\emailConfirmacao;
use SimuladoENADE\Validator\UsuarioValidator;
use SimuladoENADE\Validator\ValidationException;
use \SimuladoENADE\Notifications\usuarioNotificacao;

class Usuariocontroller extends Controller{

	public function home(){
		$user =  \Auth::user();
		$curso = \SimuladoENADE\Curso::find($user->curso_id);
		$unidade = \SimuladoENADE\UnidadeAcademica::find($curso->unidade_id)->nome;
		$tipo_usuario = \SimuladoENADE\Tipousuario::find($user->tipousuario_id)->tipo;
		return view('home', ['nome' => $user->nome, 'curso' => $curso->curso_nome, 'unidade' => $unidade, 'tipo' => $tipo_usuario]);
	}

	public function adicionar(Request $request){

		if(\Auth::guard('instituicao')->check()) {
			$user = \Auth::guard('instituicao')->user()->tipousuario_id;
		} else {
			$user = \Auth::user()->tipousuario_id;
		}

		try{

			if($user == 4){ // Instituicao / Administrador

				$inf_array = $request->all();
				UsuarioValidator::Validate($inf_array);
				$new_user = new \SimuladoENADE\Usuario();
				$new_user->fill($inf_array);
				$new_user->password = Hash::make($request->password);
				$new_user->save();

				if(false){ // email de confirmação não funcionando ainda
					Mail::to($request->email)->send(new emailConfirmacao());
				}

				return redirect("/listar/usuario");

			} elseif($user == 2){ // Coordenação de Curso

				$inf_array = $request->all();
				$inf_array["curso_id"] = \Auth::user()->curso_id; // Pega o curso do usuario que está cadastrando.
				$inf_array["tipousuario_id"] = 3; // Coordenador só pode cadastrar professor aqui!
				UsuarioValidator::Validate($inf_array);
				$new_user = new \SimuladoENADE\Usuario();
				$new_user->fill($inf_array);
				$new_user->password = Hash::make($request->password);
				$new_user->save();
		  
				if(false){
					Mail::to($request->email)->send(new emailConfirmacao());
				}

				return redirect("/listar/professor");

			} elseif ($user == 5) { // Coordenação Geral

				$inf_array = $request->all();
				$inf_array["curso_id"] = \Auth::user()->curso_id; // Pega o curso do usuario que está cadastrando.
				$inf_array["tipousuario_id"] = 5; // Coordenador só pode cadastrar professor aqui!
				UsuarioValidator::Validate($inf_array);
				$new_user = new \SimuladoENADE\Usuario();
				$new_user->fill($inf_array);
				$new_user->password = Hash::make($request->password);
				$new_user->save();
		  
				if(false){
					Mail::to($request->email)->send(new emailConfirmacao());
				}
				return redirect("listar/coordenacaoGeral");
				# code...

			}

		} catch(ValidationException $ex){

			if($user == 4)
				return redirect("/cadastrar/usuario")->withErrors($ex->getValidator())->withInput();
			elseif($user == 2)
				return redirect("/cadastrar/professor")->withErrors($ex->getValidator())->withInput();
			elseif($user == 5)
				return redirect("/cadastrar/coordenacaoGeral")->withErrors($ex->getValidator())->withInput();

		}
			
	}

	public function cadastrar(){

		if(\Auth::guard('instituicao')->check()) {
			$auth = \Auth::guard('instituicao')->user();
			$user = \Auth::guard('instituicao')->user()->tipousuario_id;
			$unidades = \SimuladoENADE\UnidadeAcademica::where('instituicao_id', $auth->id)->get();
			$unidades_ids = \SimuladoENADE\UnidadeAcademica::queryToArrayIds($unidades);
			$cursos = \SimuladoENADE\Curso::whereIn('unidade_id', $unidades_ids)->get();
			$tipos_usuario = \SimuladoENADE\Tipousuario::where('tipo', 'NOT LIKE', 'Admin%')->get();
		} else {
			$auth = \Auth::user();
			$user = \Auth::user()->tipousuario_id;
			$cursos = \SimuladoENADE\Curso::find($auth->curso_id);
			$tipos_usuario = \SimuladoENADE\Tipousuario::all();
		}

		if($user == 4) // Instituicao / Administrador
			return view('/UsuarioView/cadastrarUsuario',
						['cursos' => $cursos, 'unidades' => $unidades, 'tipos_usuario' => $tipos_usuario]);
		elseif($user == 2){ // Coordenação de Curso
			return view('/UsuarioView/cadastrarProfessor',
						['cursos' => $cursos, 'tipos_usuario' => $tipos_usuario]);
		}
		elseif($user == 5){ // Coordenação Geral
			return view('/UsuarioView/cadastrarCoordenacaoGeral',
						['cursos' => $cursos, 'tipos_usuario' => $tipos_usuario]);

		}
		
	}

	public function listar (Request $request) {
		/**
		Lista de forma distintas de acordo com seu usuario
		criar uma lista diferente para professor
		**/

		if(\Auth::guard('instituicao')->check()) {
			$auth = \Auth::guard('instituicao')->user();
			$tipo_usuario = $auth->tipousuario_id;
		} else if(\Auth::check()) {
			$curso_id = \Auth::user()->curso_id;
			$tipo_usuario = \Auth::user()->tipousuario_id;
		}

		if($tipo_usuario == 4){ // Instituicao / Administrador

			$unidades_academicas = \SimuladoENADE\UnidadeAcademica::where('instituicao_id', $auth->id)->get();
			$unidades_id = \SimuladoENADE\UnidadeAcademica::queryToArrayIds($unidades_academicas);

			$cursos = \SimuladoENADE\Curso::whereIn('unidade_id', $unidades_id)->get();
			$cursos_id = \SimuladoENADE\UnidadeAcademica::queryToArrayIds($cursos);

			// Para exibir o tipo de usuário na lista do Adm
			$usuarios = \SimuladoENADE\Usuario::select('*', \DB::raw('usuarios.id as userid'))
				->whereIn('curso_id', $cursos_id) // Filtragem de Usuarios por cursos de uma mesma instituicao
				->join('tipousuarios', 'usuarios.tipousuario_id', '=', 'tipousuarios.id')
				->join('cursos', 'usuarios.curso_id', '=', 'cursos.id') // para exibir o nome do curso
				->orderBy('nome')
				->get();

			return view('/UsuarioView/ListaUsuario',['usuarios' => $usuarios]); 

		} elseif($tipo_usuario == 2){ // Coordenação de Curso

			// Apenas usuarios do tipo 3 (professores) e do mesmo curso do coord
			$usuarios = \SimuladoENADE\Usuario::where('curso_id', '=', $curso_id)
				->where('tipousuario_id','=',3) // apenas professores
				->orderBy('nome')
				->get();

			return view('/UsuarioView/ListaProfessor',['usuarios' => $usuarios]); 
			
		} elseif($tipo_usuario == 5){ // Coordenação Geral

			// Apenas usuarios do tipo 5 (CoordenacaoGeral) e do mesmo curso do coord
			$usuarios = \SimuladoENADE\Usuario::where('curso_id', '=', $curso_id)
				->where('unidade_id','=','curso.unidade_id') // apenas professores
				->orderBy('nome')
				->get();

			return view('/UsuarioView/ListaProfessor',['usuarios' => $usuarios]); 
			
		}
		
	}

	public function editar(Request $request) {

		if(\Auth::guard('instituicao')->check()) {
			$auth = \Auth::guard('instituicao')->user();
			$user = $auth->tipousuario_id;
			$unidades = \SimuladoENADE\UnidadeAcademica::where('instituicao_id', $auth->id)->get();
			$unidades_id = \SimuladoENADE\UnidadeAcademica::queryToArrayIds($unidades);
			$cursos = \SimuladoENADE\Curso::whereIn('unidade_id', $unidades_id)->get();
			$tipos_usuario = \SimuladoENADE\Tipousuario::where('tipo', 'NOT LIKE', 'Admin%')->get();
		} else if(\Auth::check()) {
			$auth = \Auth::user();
			$user = $auth->tipousuario_id;
			$cursos = \SimuladoENADE\Curso::all();
			$tipos_usuario = \SimuladoENADE\Tipousuario::where('tipo', 'NOT LIKE', 'Admin%')->get();
		}

		$usuario = \SimuladoENADE\Usuario::find($request->id);

		if($user == 4){ // Instituicao / Administrador
			return view('/UsuarioView/editarPerfilAdm', ['usuario'=> $usuario, 'cursos' => $cursos, 'tipos_usuario' => $tipos_usuario]);
		} else { // Geral
			return view('/UsuarioView/editarPerfilGeral', ['usuario'=> $usuario, 'cursos' => $cursos, 'tipos_usuario' => $tipos_usuario]);
		}    
	}

	public function editarSenha(Request $request) {

		$usuario = \SimuladoENADE\Usuario::find($request->id);

		if (!(Hash::check($request->old_password, $usuario->password)))
			return redirect()->back()->with('fail', true)->with('message','Senha incorreta! Alterações não efetuadas.')->with('senha', true);

		$validator = Validator::make($request->all(), [
			'password' => 'min:6|max:16|required_with:password_confirmation',
			'password_confirmation' => 'required_with:password|same:password'
			]);

		if($validator->fails())
			return redirect()->back()->withErrors($validator->errors())->withInput()->with('senha', true);

		$usuario->password = Hash::make($request->password);
		$usuario->save();

		return redirect()->back()->with('success', true)->with('message','Senha alterada com sucesso!');
	}
	
	public function atualizar(Request $request){

		try{
			
			if(\Auth::guard('instituicao')->check()) {
				$user = \Auth::guard('instituicao')->user()->tipousuario_id;
			} else {
				$user = \Auth::user()->tipousuario_id;
			}
			
			if($user == 4){ // Instituicao / Administrador

				$inf_array = $request->all();

				$usuario = \SimuladoENADE\Usuario::find($request->id);
				$inf_array["password"] = $usuario->password;
				$inf_array["password_confirmation"] = $usuario->password;
				
				UsuarioValidator::Validate($inf_array);

				$usuario->fill($inf_array);
				$usuario->update();
				return redirect("/listar/usuario");

			} elseif($user == 2){ // Coordenação de Curso

				$inf_array = $request->all();
				$inf_array["curso_id"] = \Auth::user()->curso_id;

				$usuario = \SimuladoENADE\Usuario::find($request->id);
				$inf_array["password"] = $usuario->password;
				$inf_array["password_confirmation"] = $usuario->password;
				$inf_array["tipousuario_id"] = $usuario->tipousuario_id;  
				
				UsuarioValidator::Validate($inf_array);

				$usuario->fill($inf_array);
				$usuario->update();
				return redirect()->back()->with('success', true)->with('message','Alterações efetuadas.');

			} elseif($user == 5){ // Coordenação Geral

				$inf_array = $request->all();
				$inf_array["curso_id"] = \Auth::user()->curso_id;

				$usuario = \SimuladoENADE\Usuario::find($request->id);
				$inf_array["password"] = $usuario->password;
				$inf_array["password_confirmation"] = $usuario->password;
				$inf_array["tipousuario_id"] = $usuario->tipousuario_id;  
				
				UsuarioValidator::Validate($inf_array);

				$usuario->fill($inf_array);
				$usuario->update();
				return redirect()->back()->with('success', true)->with('message','Alterações efetuadas.');

			}
		}
		catch(ValidationException $ex){
			dd($ex->getValidator());
			$usuario = \SimuladoENADE\Usuario::find($request->id); 
			return redirect("editar/usuario/".$usuario->id)->withErrors($ex->getValidator())->withInput();
		}
	}
	
	public function remover(Request $request) {

		$usuario = \SimuladoENADE\Usuario::find($request->id);
		$usuario->delete();
		
		if(\Auth::guard('instituicao')->check()) {
			$user = \Auth::guard('instituicao')->user()->tipousuario_id;
		} else {
			$user = \Auth::user()->tipousuario_id;
		}
		
		if($user == 4){ // Instituicao / Administrador
			return redirect("/listar/usuario");
		} elseif($user == 2){ // Coordenador
			return redirect("/listar/professor");
		} elseif($user == 5){ // Coordenador Geral
			return redirect("/listar/coordenacaoGeral");	
		}
	}

}
