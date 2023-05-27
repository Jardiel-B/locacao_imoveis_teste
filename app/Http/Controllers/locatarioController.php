<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Locatario;
use App\Models\Locacao;

class locatarioController extends Controller
{
    
    #Função que realiza a verificação dos campos de cadastro
    public function cadastrarLocatario(Request $request){
        
        #Verifica os campos do cadastro
        $request->validate([
            'nome' => 'required|max:350',
            'cpf' => 'required|max:11|min:11',
            'email' => 'required|unique',
            'senha' => 'required|max:50|min:50',
            'telefone' => 'required|max:11|min:11'
        ]);

        if(Locatario::where('email', $request->email)->first() || Locatario::where('cpf', $request->cpf)->first()){
            return redirect()->back();
        }

        $locatario = Locatario::create($request->all());

        #Caso a validação seja um sucesso redireciona para a tela de login
        return response()->json($locatario);
    } 
  
    #Função que realiza a verificação dos campos de login
    public function logarLocatario(Request $request){
        
        #Verifica os campos do login
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required'
        ]);

        #Verifica os campos do login
        if($locatario = Locatario::where('email', $request->email)->first()){
            if($locatario->email == $request->email && $locatario->senha == $request->senha) {
                session(['email' => $request->email, 'id' => $locatario->id, 'cpf' => $locatario->cpf]);
                return redirect()->route('home');
            }
        }
        
        #Caso a validação não seja um sucesso retorna para a própria página
        return response()->json($locatario);
    }

    #Função para deslogar e limpar a session
    public function logout(Request $request){
        $request->session()->flush();
        return redirect()->back();
    }
    
    public function contaLocatario(Request $request){
        $locatario['dados'] = Locatario::where('email', session('email') )->first();
        return response()->json($locatario);
    }

    public function editarLocatario(Request $request){

        #Verifica os campos do cadastro
        $request->validate([
            'nome' => 'required|max:350',
            'cpf' => 'required|max:11|min:11',
            'email' => 'required|unique',
            'senha' => 'required|max:50|min:50',
            'telefone' => 'required|max:11|min:11'
        ]);

        if($request->email == session('email') && session('cpf') == $request->cpf){
            session(['email' => $request->email]);
            $locatario = Locatario::find(session('id'));
            $locatario->fill($request->all());
            $locatario->save();
                
            return response()->json($locatario);
            }
        return redirect()->back();
    }

    public function deletarLocatario(){
        $locatario = Locatario::find(session('id'));
        $locacao['locacoes'] = Locacao::where('id_locatario',session('id'))->delete();
        $locatario->delete();

        return redirect()->route('logout');
    }
}
