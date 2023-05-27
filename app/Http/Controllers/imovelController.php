<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use Illuminate\Http\Request;
use App\Models\Locacao;
use App\Models\Locador;
use Illuminate\Support\Facades\Cache;

class imovelController extends Controller
{
    #Validação e criação de imovél
    public function cadastrarImovel(Request $request){
    
        if($locador = Locador::find(session('email'))){
            #Verifica os campos do cadastro do imóvel
            $request->validate([
                'id_locador' => 'required|integer|exists:locadores,id',
                'cep' => 'required|min:8|max:8',
                'descricao' => 'required|max:300',
                'valor_diaria' => 'required|float',
                'status' => 'required|in: disponível, locado',
                'qtd_pessoas' => 'required|integer'
            ]);
            
            $imovel = Imovel::create(['id_locador' => $locador->id,
                                      'cep' => $request->cep,
                                      'descricao' => $request->descricao,
                                      'valor_diaria' => $request->valor_diaria,
                                      'status' => 'diponível',
                                      'qtd_pessoas' => $request->qtd_pessoas]);
            
            #Caso a validação seja um sucesso
            return redirect()->route('listarImovel')->with('Sucesso','Imovel Cadastrado');
        }
        
        return redirect()->back()->with('erro', 'O usuário não é um locador');
    }

    public function editarImovel(Request $request, $id){

        if($locador = Locador::find(session('email'))){
            #Verifica os campos do cadastro
            $request->validate([
                'id_locador' => 'required|integer|exists:locadores,id',
                'cep' => 'required|min:8|max:8',
                'descricao' => 'required|max:300',
                'valor_diaria' => 'required|float',
                'status' => 'required|in: disponível, locado',
                'qtd_pessoas' => 'required|integer'
            ]);
            $imovel = Imovel::find($id);

            if($locador->id = $imovel->id_locador){
                
                $imovel->fill(['id_locador' => $locador->id,
                               'cep' => $request->cep,
                               'descricao' => $request->descricao,
                               'valor_diaria' => $request->valor_diaria,
                               'status' => 'diponível',
                               'qtd_pessoas' => $request->qtd_pessoas]);
    
                $imovel->save();
                        
                return redirect()->route('listarImovel')->with('Sucesso','Imovel alterado');

            };

            return redirect()->back()->with('erro', 'Você não pode alterar os dados pois não é o dono do imóvel');

        }

        return redirect()->back()->with('erro', 'O usuário não é um locador');
    }
    
    public function listarImovel(Request $request){
        $imovel['imoveis'] = Imovel::get();
        return  response()->json($imovel);
    } 

    public function buscarImovel(Request $request, $cep){ 
        $imovel['imoveis'] = Imovel::where('cep', $cep)->get();
        return  response()->json($imovel);
    }

    public function visulizarImovel(Request $request, $id){
        $imovel = Imovel::where('id', $id)->first();
        return  response()->json($imovel);
    }
    
    public function filtrarImovelValor(Request $request){
        $imovel['imoveis'] = Imovel::orderByDesc('valor_diaria')->get();
        return  response()->json($imovel);
    }
    public function filtrarImovelPessoas(Request $request){
        $imovel['imoveis'] = Imovel::orderByDesc('qtd_pessoas')->get();
        return  response()->json($imovel);
    }

    public function deletarImovel($id){
        if($locador = Locador::find(session('email'))){
        $imovel['imoveis'] = Imovel::where('id', $id)->delete();
        $locacao['locacoes'] = Locacao::where('id_imovel', $id)->delete();

        return  response()->json($imovel);
    }
}
}