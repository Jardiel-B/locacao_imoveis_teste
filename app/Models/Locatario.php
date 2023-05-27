<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locatario extends Model
{
    use HasFactory;
    protected $table = 'locatarios';

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
        'id' => 'required|int',
        'nome' => 'required|max:350',
        'CPF' => 'required|max:11|min:11',
        'email' => 'required|unique',
        'senha' => 'required|max:50|min:50',
        'telefone' => 'required|max:11|min:11'
    ];

    public function locacao()
    {
        return $this->hasMany(Locacao::class);
    }
}
