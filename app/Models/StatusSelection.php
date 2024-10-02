<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusSelection extends Model
{
    use HasFactory;

    // Nome da tabela associado ao modelo
    protected $table = 'status_selection';

    // Definir que a chave primária não é um incremento automático
    protected $primaryKey = 'id_status';

    // Desativar timestamps, pois a tabela não tem `created_at` e `updated_at`
    public $timestamps = false;

    // Definir os campos que podem ser preenchidos
    protected $fillable = ['description'];
}
