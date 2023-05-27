<?php

namespace App\Http\Controllers;

use App\Models\Locador;
use Illuminate\Http\Request;
use App\Models\Imovel;
use App\Models\Locacao;

class locadorController extends Controller
{
    #Função que realiza a verificação dos campos de cadastro
    public function cadastrarLocador(Request $request){
        
        #Verifica os campos do cadastro
        $request->validate([
            'nome' => 'required|max:350',
            'cpf' => 'required|max:11|min:11',
            'email' => 'required|unique',
            'senha' => 'required|max:50|min:50',
            'telefone' => 'required|max:11|min:11'
        ]);

        if(Locador::where('email', $request->email)->first() || Locador::where('cpf', $request->cpf)->first()){
            return redirect()->back();
        }

        $locador = Locador::create($request->all());

        return response()->json($locador);
    } 

    #Função que realiza a verificação dos campos de login
    public function logarLocador(Request $request){
        
        #Verifica os campos do login
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required'
        ]);

        #Verifica os campos do login
        if($locador = Locador::where('email', $request->email)->first()){
            if($locador->email == $request->email && $locador->senha == $request->senha) {
                session(['email' => $request->email, 'id' => $locador->id, 'cpf' => $locador->cpf]);
                return redirect()->route('home');
            }
        }
        
        #Caso a validação não seja um sucesso retorna para a própria página
        return response()->json($locador);
    }

    #Função para deslogar e limpar a session
    public function logoutLocador(Request $request){
        $request->session()->flush();
        return redirect()->back();
    }
    
    public function contaLocador(Request $request){
        $locador['dados'] = Locador::where('email', session('email') )->first();
        return response()->json($locador);
    }

    public function editarLocador(Request $request){

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
            $locador = Locador::find(session('id'));
            $locador->fill($request->all());
            $locador->save();
                
            return response()->json($locador);
            }
        return redirect()->back();
    }

    public function deletarLocador(){
        $locador = Locador::find(session('id'));
        $imovel['imoveis'] = Imovel::where('id_locador',session('id'))->delete();
        $locacao['locacoes'] = Locacao::where('id_locador',session('id'))->delete();
        $locador->delete();

        return redirect()->route('logout');
    }
}
