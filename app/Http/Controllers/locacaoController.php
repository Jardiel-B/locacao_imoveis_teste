<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Locacao;
use App\Models\Imovel;
use App\Models\Locatario;
use App\Models\Locador;
use App\Jobs\CancelamentoLocacaoJob;

class locacaoController extends Controller
{

    #Função que realiza a verificação dos campos de cadastro da corrida
    public function locarImovel(Request $request, $id){
        
        if($locatario = Locatario::find(session('email'))){
            
            $imovel = Imovel::find($id);

            if($imovel->status == 'disponível'){

                $request->validate([
                    'id_imovel' => 'required|integer|exists:imoveis, id',
                    'id_locador' => 'required|integer|exists:locadores, id',
                    'id_locatario' => 'required|integer|exists:locatarios, id',
                    'qtd_dias' => 'required|integer',
                    'valor_final' => 'required|float'
                ]);
                
                $diaria = DB::table('imoveis')->value('valor_diaria')->where('id_imovel', $id);
                $id_locador = DB::table('imoveis')->value('id_locador')->where('id_imovel', $id);
                $dias = $request->qtd_dias;
                $valor =  $dias * $diaria;
    
                $imovel = Imovel::find($id);
                $imovel->status = 'locado';
                $imovel->save();
                
                $locacao = Locacao::create(['id_locador' => $id_locador,
                                            'id_locatario' => session('id'),
                                            'id_imovel' => $id,
                                            'status' => 'ativa', 
                                            'qtd_dias' => $request->qtd_dias,
                                            'valor_final' => $valor
                                            ]);
    
                #Caso a validação seja um sucesso
                return redirect()->route('listarLocacao')->with('Sucesso','Locacao realizada');
            }

            else{
                return redirect()->back()->with('erro','O imovel já está locado');
            }
            
        }
        else{
            return redirect()->back()->with('erro','O status do usuario não é de locatário');
        }
    }
    
    public function listarLocacaoLocador(Request $request){
        $locacao['dados'] = Locacao::where('id_locador',session('id'))->get();
        return response()->json($locacao);
    } 

    public function buscarLocacaoLocador(Request $request, $cep){
        
        if($cep){ 
            $locacao['dados'] = Locacao::where('id_locador',session('id'))->where('cep', $cep)->get();
            return response()->json($locacao);
        }
        else{
            $locacao['dados'] = Locacao::where('id_locador',session('id'))->get();
            return response()->json($locacao);
        }
    }

    public function listarLocacaoLocatario(Request $request){
        $locacao['dados'] = Locacao::where('id_locatario', session('id'))->get();
        return response()->json($locacao);
    } 

    public function buscarLocacaoLocatario(Request $request, $cep){
        
        if($cep){ 
            $locacao['dados'] = Locacao::where('id_locatario',session('id'))->where('cep', $cep)->get();
            return response()->json($locacao);
        }
        else{
            $locacao['dados'] = Locacao::where('id_locatario',session('id'))->get();
            return response()->json($locacao);
        }
    }

    public function cacelarLocacao($id){

        if($locador = Locador::find(session('email'))){
            $id_imovel = DB::table('locacoes')->value('id_imovel')->where('id', $id);
            $imovel = Imovel::find($id_imovel);
            $imovel->status = 'disponível';
            $imovel->save();
            $locacao = Locacao::find($id);
            dispatch(new CancelamentoLocacaoJob($locacao));
        }

        else if($locatario = Locatario::find(session('email'))){
            $id_imovel = DB::table('locacoes')->value('id_imovel')->where('id', $id);
            $imovel = Imovel::find($id_imovel);
            $imovel->status = 'disponível';
            $imovel->save();
            $locacao = Locacao::find($id);
            dispatch(new CancelamentoLocacaoJob($locacao));
        }
    }
}