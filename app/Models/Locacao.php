<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locacao extends Model
{
    use HasFactory;
    protected $table = 'locacoes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id' => 'int|required',
        'id_imovel' => 'required|int|exists:imoveis, id',
        'id_locador' => 'required|int|exists:locadores, id',
        'id_locatario' => 'required|int|exists:locatarios, id',
        'status' => 'required|in: ativa, cancelada',
        'qtd_dias' => 'required|int',
        'valor_final' => 'required|float'
    ];

    public function locador()
    {
        return $this->belogsTo(Locador::class, 'id_locador', 'id');
    }
    
    public function imovel()
    {
        return $this->belongsTo(Imovel::class, 'id_imovel', 'id');
    }

    public function locatario()
    {
        return $this->belongsTo(Locatario::class, 'id_locatario', 'id');
    }
}
