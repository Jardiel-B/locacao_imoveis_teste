<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locador extends Model
{
    use HasFactory;
    protected $table = 'locadores';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 
        'nome',
        'CPF',
        'email',
        'senha',
        'telefone'
    ];

    protected $casts = [
        'id' => 'int|required',
        'nome' => 'required|max:350',
        'cpf' => 'required|max:11|min:11',
        'email' => 'required|unique',
        'senha' => 'required|max:50|min:6',
        'telefone' => 'required|max:11|min:11'
    ];

    public function imoveis()
    {
        return $this->hasMany(Imovel::class);
    }
}
