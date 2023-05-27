<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imovel extends Model
{
    use HasFactory;
    protected $table = 'imoveis';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_locador',
        'cep',
        'descricao',
        'valor_diaria',
        'status',
        'qtd_pessoas'
    ];

    protected $casts = [
        'id' => 'int|required',
        'id_locador' => 'required|int|exists:locadores,id',
        'cep' => 'required|min:8|max:8',
        'descricao' => 'required|max:300',
        'valor_diaria' => 'required|float',
        'status' => 'required|in: disponível, locado',
        'qtd_pessoas' => 'required|int'
    ];

    public function locador()
    {
        return $this->belogsTo(Locador::class, 'id_locador', 'id');
    }
}
